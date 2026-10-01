<?php

namespace App\Http\Controllers;

use App\Models\StudentPayment;
use App\Models\Finance;
use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 use Barryvdh\DomPDF\Facade\Pdf;
 use App\Models\FeeStructure;
 use App\Models\AcademicYear;

class StudentPaymentController extends Controller
{
  public function index(Request $request)
{
    $user = auth()->user();

    if ($user->role === 'student') {
        $student = Student::where('user_id', $user->id)->first();

        if (!$student) {
            abort(403, 'Student profile not found.');
        }

        $query = StudentPayment::with([
    'student',
    'academicYear'
])
            ->where('student_id', $student->id);
    } else {
        $query = StudentPayment::with([
    'student',
    'academicYear'
]);
    }

    if ($request->filled('search')) {
        $search = $request->search;
        $query->whereHas('student', function ($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWhere('admission_no', 'like', "%{$search}%");
        })->orWhere('term', 'like', "%{$search}%");
    }

    $payments = $query->latest()->paginate(10);
    $totalPayments = $query->sum('amount_paid');

    return view('finances.students.index', compact('payments', 'totalPayments'));
}



public function create()
{
    $students = Student::orderBy('admission_no')->get();

    $academicYears = AcademicYear::orderByDesc('start_date')->get();

    $classrooms = Classroom::orderBy('name')->get();

    return view(
        'finances.students.create',
        compact(
            'students',
            'academicYears',
            'classrooms'
        )
    );
}

   public function store(Request $request)
{
    $data = $request->validate([
    'student_id' => 'required|exists:students,id',

    'academic_year_id' => 'required|exists:academic_years,id',

    'amount_paid' => 'required|numeric|min:0',

    'term' => 'required|string',
]);

      $student = Student::findOrFail($data['student_id']);

$fee = FeeStructure::where(
        'classroom_id',
        $student->classroom_id
    )
    ->where(
        'academic_year_id',
        $data['academic_year_id']
    )
    ->where(
        'term',
        $data['term']
    )
    ->first();

if (!$fee) {

    return back()
        ->withInput()
        ->with(
            'error',
            'No fee structure has been created for this class, academic year and term.'
        );

}

$data['total_fee'] = $fee->amount;
    

    // CHECK PREVIOUS TERM BALANCES HERE
    $termsOrder = ['Term 1', 'Term 2', 'Term 3'];

    $currentTermIndex = array_search($data['term'], $termsOrder);

    if ($currentTermIndex > 0) {

        $previousTerms = array_slice($termsOrder, 0, $currentTermIndex);

        $previousBalance = StudentPayment::where('student_id', $data['student_id'])
            ->whereIn('term', $previousTerms)
            ->where('academic_year_id', $data['academic_year_id'])
            ->latest()
            ->first();

        if ($previousBalance && $previousBalance->balance > 0) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error',
                    'Student has an outstanding balance of Ksh '
                    . number_format($previousBalance->balance, 2)
                    . ' from '
                    . $previousBalance->term);
        }
    }

    // CHECK CURRENT TERM PAYMENTS
    $previousPayments = StudentPayment::where('student_id', $data['student_id'])
        ->where('term', $data['term'])
        ->where('academic_year_id', $data['academic_year_id'])
        ->sum('amount_paid');

    $newTotalPaid = $previousPayments + $data['amount_paid'];

    // PREVENT OVERPAYMENT
    if ($newTotalPaid > $data['total_fee']) {

        $remainingBalance = $data['total_fee'] - $previousPayments;

        return redirect()
            ->back()
            ->withInput()
            ->with('error',
                'Payment exceeds remaining balance. Remaining balance is Ksh '
                . number_format($remainingBalance, 2));
    }

    // CALCULATE BALANCE
    $data['balance'] = $data['total_fee'] - $newTotalPaid;

    $data['payment_date'] = now();

    $data['recorded_by'] = Auth::id();

    $payment = StudentPayment::create($data);

    $student = Student::findOrFail($data['student_id']);

    Finance::create([
        'type' => 'income',
        'category' => 'Student Fee',
        'amount' => $data['amount_paid'],
        'description' => 'Fee payment for '
            . $student->first_name . ' '
            . $student->last_name
            . ' — Admission No: '
            . $student->admission_no,
        'recorded_by' => Auth::id(),
    ]);

    return redirect()
        ->route('student-payments.index')
        ->with('success', 'Payment recorded successfully.');
}

public function download($id)
{
    $payment = StudentPayment::with('student')->findOrFail($id);

    // Allow only admin or the student who owns the record
    $user = Auth::user();
    if ($user->role === 'student') {
        $student = Student::where('user_id', $user->id)->first();
        if (!$student || $student->id !== $payment->student_id) {
            abort(403, 'Unauthorized to download this receipt.');
        }
    }

    $pdf = Pdf::loadView('finances.students.receipt', compact('payment'));
    return $pdf->download('Payment_Receipt_' . $payment->id . '.pdf');
}




public function loadFeeStructure(Request $request)
{
    $fee = FeeStructure::where(
            'classroom_id',
            $request->classroom_id
        )
        ->where(
            'academic_year_id',
            $request->academic_year_id
        )
        ->where(
            'term',
            $request->term
        )
        ->first();

    if (!$fee) {

        return response()->json([
            'amount' => 0
        ]);

    }

    return response()->json([
        'amount' => $fee->amount
    ]);
}


  public function destroy(StudentPayment $studentPayment)
{
    // Delete the related finance record (optional but recommended)
    Finance::where('description', 'like', '%' . $studentPayment->student->admission_no . '%')
        ->where('amount', $studentPayment->amount_paid)
        ->delete();

    $studentPayment->delete();

    return redirect()
        ->route('student-payments.index')
        ->with('success', 'Payment deleted successfully.');
}



}

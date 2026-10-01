<?php

namespace App\Http\Controllers;

use App\Models\FeeStructure;
use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\StudentPayment;
use Illuminate\Http\Request;

class FeeStructureController extends Controller
{
    /**
     * Display a listing of fee structures.
     */
    public function index(Request $request)
    {
        $query = FeeStructure::with([
            'classroom',
            'academicYear'
        ]);

        if ($request->filled('search')) {

            $search = $request->search;

            $query->whereHas('classroom', function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%");

            })
            ->orWhereHas('academicYear', function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%");

            })
            ->orWhere('term', 'like', "%{$search}%");

        }

        $feeStructures = $query
            ->latest()
            ->paginate(10);

        return view(
            'finances.fee-structures.index',
            compact('feeStructures')
        );
    }

    /**
     * Show the form for creating a fee structure.
     */
    public function create()
    {
        $classrooms = Classroom::orderBy('name')->get();

        $academicYears = AcademicYear::orderByDesc('start_date')->get();

        return view(
            'finances.fee-structures.create',
            compact(
                'classrooms',
                'academicYears'
            )
        );
    }

    /**
     * Store a newly created fee structure.
     */
    public function store(Request $request)
    {
        $data = $request->validate([

            'classroom_id'      => 'required|exists:classrooms,id',

            'academic_year_id'  => 'required|exists:academic_years,id',

            'term'              => 'required|in:Term 1,Term 2,Term 3',

            'amount'            => 'required|numeric|min:0',

        ]);

        // Prevent duplicates
        $exists = FeeStructure::where('classroom_id', $data['classroom_id'])
            ->where('academic_year_id', $data['academic_year_id'])
            ->where('term', $data['term'])
            ->exists();

        if ($exists) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'A fee structure already exists for this class, academic year and term.'
                );
        }

        FeeStructure::create($data);

        return redirect()
            ->route('fee-structures.index')
            ->with(
                'success',
                'Fee Structure created successfully.'
            );
    }

    /**
     * Show the form for editing.
     */
    public function edit(FeeStructure $feeStructure)
    {
        $classrooms = Classroom::orderBy('name')->get();

        $academicYears = AcademicYear::orderByDesc('start_date')->get();

        return view(
            'finances.fee-structures.edit',
            compact(
                'feeStructure',
                'classrooms',
                'academicYears'
            )
        );
    }

    /**
     * Update fee structure.
     */
    public function update(Request $request, FeeStructure $feeStructure)
    {
        $data = $request->validate([

            'classroom_id'      => 'required|exists:classrooms,id',

            'academic_year_id'  => 'required|exists:academic_years,id',

            'term'              => 'required|in:Term 1,Term 2,Term 3',

            'amount'            => 'required|numeric|min:0',

        ]);

        $feeStructure->update($data);

        return redirect()
            ->route('fee-structures.index')
            ->with(
                'success',
                'Fee Structure updated successfully.'
            );
    }

    /**
     * Delete fee structure.
     */
    public function destroy(FeeStructure $feeStructure)
    {
        $feeStructure->delete();

        return redirect()
            ->route('fee-structures.index')
            ->with(
                'success',
                'Fee Structure deleted successfully.'
            );
    }
}
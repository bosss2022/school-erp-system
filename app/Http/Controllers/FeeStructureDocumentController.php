<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\FeeStructureDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FeeStructureDocumentController extends Controller
{
    public function index()
    {
        $documents = FeeStructureDocument::with('academicYear')
                        ->latest()
                        ->paginate(10);

        return view(
            'fee_structure_documents.index',
            compact('documents')
        );
    }

    public function create()
    {
        $academicYears = AcademicYear::orderBy('name')->get();

        return view(
            'fee_structure_documents.create',
            compact('academicYears')
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'academic_year_id' =>

                'required|exists:academic_years,id',

            'file' =>

                'required|mimes:pdf|max:10240',

        ]);
$file = $request->file('file');

$filename = $file->getClientOriginalName();

$path = $file->storeAs(
    'fee_structures',
    $filename,
    'public'
);

        $existing = FeeStructureDocument::where(

            'academic_year_id',

            $request->academic_year_id

        )->first();

        if($existing){

            Storage::disk('public')->delete($existing->file);

            $existing->update([

                'file'=>$path

            ]);

        }else{

            FeeStructureDocument::create([

                'academic_year_id'=>$request->academic_year_id,

                'file'=>$path,

            ]);

        }

        return redirect()

            ->route('fee-structure-documents.index')

            ->with(

                'success',

                'Fee Structure uploaded successfully.'

            );
    }

    public function download(FeeStructureDocument $document)
    {
        return response()->download(

            storage_path(

                'app/public/'.$document->file

            )

        );
    }

public function destroy(FeeStructureDocument $fee_structure_document)
{
    if (
        $fee_structure_document->file &&
        Storage::disk('public')->exists($fee_structure_document->file)
    ) {
        Storage::disk('public')->delete($fee_structure_document->file);
    }

    $fee_structure_document->delete();

    return redirect()
        ->route('fee-structure-documents.index')
        ->with('success', 'Document deleted successfully.');
}


  public function downloadLatest()
{
    $document = FeeStructureDocument::whereHas('academicYear', function ($query) {
        $query->where('is_current', true);
    })->latest()->first();

    if (!$document) {
        return redirect()->back()->with('error', 'Current fee structure is not available.');
    }

    if (!Storage::disk('public')->exists($document->file)) {
        return redirect()->back()->with('error', 'Fee structure file not found.');
    }

    return Storage::disk('public')->download(
        $document->file,
        'MASU_SCHOOL_FEE_STRUCTURE.pdf'
    );
}


}
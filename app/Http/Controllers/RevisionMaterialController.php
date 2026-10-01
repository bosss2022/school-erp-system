<?php

namespace App\Http\Controllers;


use App\Models\RevisionMaterial;
use App\Models\Subject;
use App\Models\Classroom;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RevisionMaterialController extends Controller
{

    // =========================================
    // INDEX
    // =========================================
    public function index(Request $request)
    {
        $query = RevisionMaterial::with([
            'subject',
            'classroom',
            'teacher'
        ]);

        // Student sees only own class materials
        if (auth()->user()->role == 'student') {

            $student = auth()->user()->student;

            if ($student) {

                $query->where(
                    'classroom_id',
                    $student->classroom_id
                );
            }
        }

        // Filters
        if ($request->subject_id) {

            $query->where(
                'subject_id',
                $request->subject_id
            );
        }

        if ($request->type) {

            $query->where(
                'type',
                $request->type
            );
        }

        $materials = $query->latest()->paginate(10);
$subjects = Subject::select('id', 'name')
    ->get()
    ->unique('name');

        return view(
            'revision-materials.index',
            compact('materials', 'subjects')
        );
    }


    // =========================================
    // CREATE
    // =========================================
    public function create()
    {
     $subjects = Subject::select('id', 'name')
    ->get()
    ->unique('name');
        $classrooms = Classroom::all();

        return view(
            'revision-materials.create',
            compact('subjects', 'classrooms')
        );
    }


    // =========================================
    // STORE
    // =========================================
    public function store(Request $request)
    {
        $request->validate([

            'title' => 'required|string|max:255',

            'description' => 'nullable|string',

            'subject_id' => 'required|exists:subjects,id',

            'classroom_id' => 'required|exists:classrooms,id',

            'type' => 'required',

            'file' => 'required|mimes:pdf,doc,docx,ppt,pptx,zip|max:20480',
        ]);


        // Upload file
        $filePath = $request->file('file')
            ->store('revision-materials', 'public');


        // Teacher
        $teacher = Teacher::where(
            'user_id',
            Auth::id()
        )->first();


        RevisionMaterial::create([

            'title' => $request->title,

            'description' => $request->description,

            'file' => $filePath,

            'subject_id' => $request->subject_id,

            'classroom_id' => $request->classroom_id,

            'teacher_id' => $teacher?->id,

            'type' => $request->type,

            'uploaded_by' => Auth::id(),
        ]);


        return redirect()
            ->route('revision-materials.index')
            ->with(
                'success',
                'Revision material uploaded successfully.'
            );
    }


    // =========================================
    // DOWNLOAD
    // =========================================
    public function show(RevisionMaterial $revisionMaterial)
    {
        return response()->download(
            storage_path(
                'app/public/' . $revisionMaterial->file
            )
        );
    }


    // =========================================
    // DELETE
    // =========================================
    public function destroy(RevisionMaterial $revisionMaterial)
    {
        $revisionMaterial->delete();

        return back()->with(
            'success',
            'Material deleted successfully.'
        );
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ClassroomController extends Controller
{
   public function index(Request $request)
{
    $user = auth()->user();
    $search = $request->input('search');

    if ($user->role === 'admin') {
        // Admin can view all classrooms with optional search
        $classrooms = Classroom::with('teacher')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhereHas('teacher', function ($q) use ($search) {
                          $q->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                      });
            })
            ->latest()
            ->paginate(10);
    } 
    elseif ($user->role === 'teacher') {
        // Teacher: view their classrooms only
        $teacher = Teacher::where('user_id', $user->id)
            ->with(['classrooms' => function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', "%{$search}%");
                }
            }])
            ->first();

        if (!$teacher) {
            abort(403, 'Teacher profile not found.');
        }

        // Manual pagination for the teacher's classrooms
        $page = $request->get('page', 1);
        $perPage = 10;
        $items = $teacher->classrooms;
        $classrooms = new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    } 
    else {
        abort(403, 'Unauthorized action.');
    }

    return view('classrooms.index', compact('classrooms', 'search'));
}


    public function create()
    {
        $teachers = Teacher::all();
    return view('classrooms.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:classrooms,name',
             'teacher_id' => 'nullable|exists:teachers,id',
            'capacity' => 'nullable|integer',
        ]);

        Classroom::create($data);

        return redirect()->route('classrooms.index')->with('success', 'Classroom created successfully.');
    }

    public function edit(Classroom $classroom)
    {
         $teachers = Teacher::all();
    return view('classrooms.edit', compact('classroom', 'teachers'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $data = $request->validate([
            'name' => 'required|unique:classrooms,name,' . $classroom->id,
            'teacher_id' => 'nullable|exists:teachers,id',
            'capacity' => 'nullable|integer',
        ]);

        $classroom->update($data);

        return redirect()->route('classrooms.index')->with('success', 'Classroom updated successfully.');
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return redirect()->route('classrooms.index')->with('success', 'Classroom deleted.');
    }

      public function show(Classroom $classroom)
{
    $classroom->load('students'); // eager-load students
    return view('classrooms.show', compact('classroom'));
}

}

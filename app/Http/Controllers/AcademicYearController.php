<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    // ============================
    // INDEX
    // ============================
    public function index()
    {
        $years = AcademicYear::latest()->paginate(10);

        return view('academic-years.index', compact('years'));
    }

    // ============================
    // CREATE
    // ============================
    public function create()
    {
        return view('academic-years.create');
    }

    // ============================
    // STORE
    // ============================
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:academic_years,name',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        if ($request->has('is_current')) {

            AcademicYear::query()->update([
                'is_current' => false
            ]);
        }

        AcademicYear::create([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_current' => $request->has('is_current'),
        ]);

        return redirect()
            ->route('academic-years.index')
            ->with('success', 'Academic Year created successfully.');
    }

    // ============================
    // SHOW
    // ============================
    public function show(AcademicYear $academicYear)
    {
        return view(
            'academic-years.show',
            compact('academicYear')
        );
    }

    // ============================
    // EDIT
    // ============================
    public function edit(AcademicYear $academicYear)
    {
        return view(
            'academic-years.edit',
            compact('academicYear')
        );
    }

    // ============================
    // UPDATE
    // ============================
    public function update(Request $request, AcademicYear $academicYear)
    {
        $request->validate([
            'name' => 'required|unique:academic_years,name,' . $academicYear->id,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        if ($request->has('is_current')) {

            AcademicYear::query()->update([
                'is_current' => false
            ]);
        }

        $academicYear->update([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_current' => $request->has('is_current'),
        ]);

        return redirect()
            ->route('academic-years.index')
            ->with('success', 'Academic Year updated successfully.');
    }

    // ============================
    // DELETE
    // ============================
    public function destroy(AcademicYear $academicYear)
    {
        $academicYear->delete();

        return back()->with(
            'success',
            'Academic Year deleted successfully.'
        );
    }
}
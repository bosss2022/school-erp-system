<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $finances = Finance::when($search, function ($query, $search) {
            $query->where('type', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('amount', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(10);

    return view('finances.index', compact('finances', 'search'));
}
    public function create()
    {
        return view('finances.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:income,expense',
            'category' => 'nullable|string',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $data['recorded_by'] = Auth::id();

        Finance::create($data);

        return redirect()->route('finances.index')->with('success', 'Finance record added successfully.');
    }

    public function destroy(Finance $finance)
    {
        $finance->delete();
        return redirect()->route('finances.index')->with('success', 'Record deleted.');
    }
}

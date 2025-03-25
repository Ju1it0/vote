<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voter;
use Illuminate\Http\Request;

class VoterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $voters = Voter::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.voters.index', compact('voters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.voters.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'document' => 'required|string|unique:voters',
            'name' => 'required|string',
            'lastname' => 'required|string',
            'dob' => 'required|date',
            'isCandidate' => 'required|boolean',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'gender' => 'nullable|in:M,F,O',
        ]);

        Voter::create($request->all());

        return redirect()->route('admin.voters.index')
            ->with('success', 'Votante creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Voter $voter)
    {
        return view('admin.voters.edit', compact('voter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Voter $voter)
    {
        $request->validate([
            'document' => 'required|string|unique:voters,document,' . $voter->id,
            'name' => 'required|string',
            'lastname' => 'required|string',
            'dob' => 'required|date',
            'isCandidate' => 'required|boolean',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'gender' => 'nullable|in:M,F,O',
        ]);

        $voter->update($request->all());

        return redirect()->route('admin.voters.index')
            ->with('success', 'Votante actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Voter $voter)
    {
        $voter->delete();

        return redirect()->route('admin.voters.index')
            ->with('success', 'Votante eliminado exitosamente.');
    }
}

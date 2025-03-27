<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Voter;
use Illuminate\Http\Request;

class VoterController extends Controller
{
    public function index()
    {
        $voters = Voter::all();

        return response()->json($voters);
    }

    public function store(Request $request)
    {
        $request->validate([
            'document' => 'required|string|max:20|unique:voters',
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'dob' => 'required|date',
            'isCandidate' => 'boolean',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'gender' => 'required|string|in:M,F,O',
        ]);

        $voter = Voter::create($request->all());

        return response()->json($voter, 201);
    }

    public function show(Voter $voter)
    {
        return response()->json($voter);
    }

    public function update(Request $request, Voter $voter)
    {
        $request->validate([
            'document' => 'required|string|max:20|unique:voters,document,' . $voter->id,
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'dob' => 'required|date',
            'isCandidate' => 'boolean',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'gender' => 'required|string|in:M,F,O',
        ]);

        $voter->update($request->all());

        return response()->json($voter);
    }

    public function destroy(Voter $voter)
    {
        $voter->delete();

        return response()->json(null, 204);
    }
}

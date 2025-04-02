<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Voter;
use Illuminate\Http\Request;

class VoterController extends Controller
{
    public function index()
    {
        $voters = Voter::orderBy('created_at', 'desc')->paginate(20);
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

    public function candidates()
    {
        return Voter::where('isCandidate', true)->get();
    }

    public function topCandidates()
    {
        $candidates = Voter::where('isCandidate', true)
            ->withCount('receivedVotes')
            ->orderBy('received_votes_count', 'desc')
            ->get()
            ->map(function ($candidate) {
                return [
                    'id' => $candidate->id,
                    'name' => $candidate->name,
                    'lastname' => $candidate->lastname,
                    'document' => $candidate->document,
                    'totalVotes' => $candidate->received_votes_count
                ];
            });

        return response()->json(['data' => $candidates]);
    }
}

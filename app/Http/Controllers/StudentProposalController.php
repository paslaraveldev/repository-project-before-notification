<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Proposal;
use App\Models\Concept;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProposalSubmitted; 
use App\Mail\ProposalModified;

class StudentProposalController extends Controller
{
     public function create()
    {
        $user = Auth::user();
        $userGroup = $user->groups()->first();

        if (!$userGroup) {
            return redirect()->route('studentgroups.index')->with('error', 'You do not belong to any group.');
        }

        $concepts = Concept::where('group_id', $userGroup->id)->get();
        return view('Studentfiles.proposals.create', compact('concepts'));
    }

    public function store(Request $request)
{
    $request->validate([
        'concept_id' => 'required|exists:concepts,id',
        'pdf' => 'required|mimes:pdf|max:20480',
        'description' => 'required|string',
    ]);

    $user = Auth::user();
    $userGroup = $user->groups()->first();

    if (!$userGroup) {
        return redirect()->route('studentgroups.index')->with('error', 'You do not belong to any group.');
    }

    // Check if the group already has a proposal
    $existingProposal = Proposal::where('group_id', $userGroup->id)->first();
    if ($existingProposal) {
        return redirect()->back()->with('error', 'Your group has already submitted a proposal. You can only modify the existing proposal.');
    }

    $concept = Concept::findOrFail($request->concept_id);
    if ($concept->status !== 'Accepted') {
        return redirect()->back()->with('error', 'The selected concept has not been accepted for proposals.');
    }

    $path = $request->file('pdf')->store('proposals', 'public');

    $proposal = Proposal::create([
        'group_id' => $userGroup->id,
        'concept_id' => $concept->id,
        'description' => $request->description,
        'title' => $concept->title,
        'pdf_path' => $path,
        'status' => 'Draft',
        'submitted_by' => Auth::id(),
    ]);

    Mail::to($userGroup->supervisor->email)->send(new ProposalSubmitted($proposal));
    
    return redirect()->route('proposals.index')->with('success', 'Proposal created successfully.');
}


    public function index()
    {
        $user = Auth::user();
        $group = $user->groups()->first();
        if (!$group) {
            return redirect()->back()->with('error', 'You must be assigned to a group to view proposals.');
        }

        $proposals = Proposal::where('group_id', $group->id)->get();
        return view('Studentfiles.proposals.index', compact('proposals', 'group'));
    }

public function download($id)
{
    $proposal = Proposal::findOrFail($id);
    $user = Auth::user();
    $group = $user->groups()->first();

    // Ensure the student is part of the group that owns the proposal
    if (!$group || $group->id !== $proposal->group_id) {
        return redirect()->back()->with('error', 'Unauthorized access.');
    }

    // Check if the reviewed PDF exists before downloading
    if ($proposal->reviewed_pdf_path && Storage::disk('public')->exists($proposal->reviewed_pdf_path)) {
        return response()->download(storage_path('app/public/' . $proposal->reviewed_pdf_path));
    }

    return redirect()->back()->with('error', 'No reviewed PDF available for download.');
}

public function show($id)
{
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'You need to log in to view this proposal.');
    }

    $proposal = Proposal::with('group.students')->findOrFail($id);
    $user = Auth::user();
    $group = $user->groups()->first();

    if (!$group || $group->id !== $proposal->group_id) {
        return redirect()->back()->with('error', 'Unauthorized access.');
    }

    return view('Studentfiles.proposals.show', compact('proposal'));
}



    public function edit($id)
    {
        $proposal = Proposal::findOrFail($id);
        if (Auth::id() !== $proposal->submitted_by) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }
        return view('Studentfiles.proposals.modify', compact('proposal'));
    }

    public function modify(Request $request, $id)
    {
        $proposal = Proposal::findOrFail($id);
        
        if (Auth::id() !== $proposal->submitted_by) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'description' => 'required|string',
            'pdf' => 'nullable|mimes:pdf|max:20480',
        ]);

        if ($request->hasFile('pdf')) {
            Storage::disk('public')->delete($proposal->pdf_path);
            $proposal->pdf_path = $request->file('pdf')->store('proposals', 'public');
        }

        $proposal->update([
            'description' => $request->description,
            'pdf_path' => $proposal->pdf_path,
            'status' => 'Draft',
        ]);

        // Notify the supervisor about the modification
        Mail::to($proposal->group->supervisor->email)->send(new ProposalModified($proposal));
        
        return redirect()->route('proposals.index')->with('success', 'Proposal updated successfully and supervisor has been notified.');
    }
}

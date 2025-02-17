<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Proposal;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use App\Models\ProposalComment;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProposalReviewed;




class SupervisorProposalController extends Controller
{ /**
     * Display all groups assigned to the supervisor and their proposals.
     */
    public function index()
{
    $supervisor = Auth::user();

    // Fetch only groups assigned to the supervisor where 'supervisor_id' is not null
    $groups = Group::where('supervisor_id', $supervisor->id)
        ->whereNotNull('supervisor_id') // Ensure supervisor_id is not null
        ->with('proposals')
        ->get();

    if ($groups->isEmpty()) {
        return view('Supervisorfiles.proposal.index', ['message' => 'No groups assigned to you.']);
    }

    return view('Supervisorfiles.proposal.index', compact('groups'));
}


    /**
     * Show a specific proposal for review.
     */
   // app/Http/Controllers/SupervisorProposalController.php

public function show($id)
{
    $supervisor = Auth::user();

    // Fetch the proposal with its comments
    $proposal = Proposal::with(['group', 'comments'])->whereHas('group', function ($query) use ($supervisor) {
        $query->where('supervisor_id', $supervisor->id);
    })->find($id);

    // Check if proposal is found and belongs to the assigned group
    if (!$proposal) {
        return redirect()->route('supervisor.proposals.index')->with('error', 'You are trying to review a proposal that is not assigned to you.');
    }

    // Pass the comments to the view
    return view('Supervisorfiles.proposal.show', compact('proposal'));
}




    /**
     * Download the proposal PDF.
     */
public function download($id)
{
    $supervisor = Auth::user();
    
    // Ensure the proposal belongs to a group assigned to this supervisor
    $proposal = Proposal::whereHas('group', function ($query) use ($supervisor) {
        $query->where('supervisor_id', $supervisor->id);
    })->findOrFail($id);

    // Ensure the file exists before allowing download
    if (Storage::disk('public')->exists($proposal->pdf_path)) {
        return response()->download(storage_path('app/public/' . $proposal->pdf_path));
    }

    return redirect()->back()->with('error', 'File not found.');
}




    /**
     * Upload a new version of the proposal PDF.
     */
 public function upload(Request $request, $id)
{
    $supervisor = Auth::user();

    // Find the proposal, ensuring it belongs to a group assigned to the supervisor
    $proposal = Proposal::whereHas('group', function ($query) use ($supervisor) {
        $query->where('supervisor_id', $supervisor->id);
    })->findOrFail($id);

    // Validate the uploaded file with 50MB size limit
    $request->validate([
        'pdf' => 'required|mimes:pdf|max:51200', // 50MB max (51200KB)
    ]);

    // Delete old reviewed PDF if it exists
    if ($proposal->reviewed_pdf_path && Storage::disk('public')->exists($proposal->reviewed_pdf_path)) {
        Storage::disk('public')->delete($proposal->reviewed_pdf_path);
    }

    // Store the new reviewed PDF
    $path = $request->file('pdf')->store('proposals/reviewed', 'public');

    // Update proposal with the reviewed PDF path
    $proposal->update([
        'reviewed_pdf_path' => $path,
        'reviewed_by' => $supervisor->id, // Update reviewer
        'supervisor_commented_at' => now(), // Timestamp for review
    ]);

    return redirect()->back()->with('success', 'Reviewed proposal uploaded successfully.');
}


  public function review(Request $request, $id)
{
    $supervisor = Auth::user();

    // Find the proposal, ensuring it belongs to a group assigned to the supervisor
    $proposal = Proposal::whereHas('group', function ($query) use ($supervisor) {
        $query->where('supervisor_id', $supervisor->id);
    })->findOrFail($id);

    // Validate input
    $request->validate([
        'status' => 'required|in:Needs Revision,Approved',
        'supervisor_comments' => 'required|string',
    ]);

    // Store the new comment in the ProposalComment table
    $comment = ProposalComment::create([
        'proposal_id' => $proposal->id,
        'supervisor_id' => $supervisor->id,
        'comment' => $request->supervisor_comments,
    ]);

    // Update the status of the proposal
    $proposal->update([
        'status' => $request->status,
    ]);

    // Fetch all students in the group
    $students = $proposal->group->students;

    // Send email to all students in the group
    foreach ($students as $student) {
        Mail::to($student->email)->send(new ProposalReviewed($proposal, $comment, $request->status));
    }

    return redirect()->route('supervisor.proposals.index')->with('success', 'Proposal reviewed successfully.');
}


}

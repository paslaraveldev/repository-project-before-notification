<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Report;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use App\Models\ReportComment;
use App\Mail\SupervisorCommentNotification;
use Illuminate\Support\Facades\Mail;

class SupervisorReportController extends Controller
{ 

     /**
     * Display all project reports for groups assigned to the supervisor.
     */
    public function index()
    {
        $supervisor = Auth::user();
        $groups = Group::where('supervisor_id', $supervisor->id)->with('reports')->get();
        $reports = $groups->flatMap->reports;

        return view('Supervisorfiles.projectreport.index', compact('reports'));
    }

    /**
     * Show a specific project report.
     */
    public function show($id)
    {
        $supervisor = Auth::user();
        $report = Report::whereHas('group', fn($q) => $q->where('supervisor_id', $supervisor->id))
                        ->with(['group', 'comments'])
                        ->findOrFail($id);

        return view('Supervisorfiles.projectreport.show', compact('report'));
    }

    /**
     * Download the project report PDF securely (Uploaded by students).
     */
  public function downloadStudentPdf($id)
{
    $supervisor = Auth::user();
    $report = Report::whereHas('group', function ($query) use ($supervisor) {
        $query->where('supervisor_id', $supervisor->id);
    })->findOrFail($id);

    // Check if the PDF file exists and is accessible
    $pdfFilePath = public_path($report->pdf_file);
    if (!$report->pdf_file || !file_exists($pdfFilePath)) {
        return redirect()->back()->with('error', 'Report file not found.');
    }

    return response()->download($pdfFilePath);
}

    public function review(Request $request, $id)
{
    $report = Report::findOrFail($id);

    // Add supervisor comment
    if ($request->has('supervisor_comments')) {
        ReportComment::create([
            'report_id' => $report->id,
            'supervisor_id' => auth()->user()->id,
            'comment' => $request->supervisor_comments,
        ]);
    }

    // Update report status
    if ($request->has('status')) {
        $report->status = $request->status;
        $report->save();
    }

    return redirect()->route('supervisor.reports.show', $id)
                     ->with('success', 'Review submitted successfully.');
}

    /**
     * Upload a reviewed project report PDF securely.
     */

    public function uploadReviewPdf(Request $request, $id)
    {
        $supervisor = Auth::user();
        $report = Report::whereHas('group', fn($q) => $q->where('supervisor_id', $supervisor->id))
                        ->findOrFail($id);

        $request->validate([
            'review_pdf' => 'required|mimes:pdf|max:20480',
        ]);

        if ($request->hasFile('review_pdf')) {
            $file = $request->file('review_pdf');
            $fileName = 'review_' . time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('supervisor_reviews', $fileName, 'local');

            $report->update(['review_pdf' => $filePath]);
        }

        return redirect()->back()->with('success', 'Review PDF uploaded successfully.');
    }

    /**
     * Download the reviewed project report PDF securely (Uploaded by supervisor).
     */
public function downloadReviewPdf($id)
{
    $user = Auth::user();
    $report = Report::findOrFail($id);
    $group = Group::findOrFail($report->group_id);

    if ($group->supervisor_id !== $user->id && !$group->students->contains('id', $user->id)) {
        abort(403, 'Unauthorized access');
    }

    if (!$report->review_pdf || !Storage::exists($report->review_pdf)) {
        return redirect()->back()->with('error', 'Review file not found.');
    }

    return Storage::download($report->review_pdf);
}
}

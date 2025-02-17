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
{ /**
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
     * Download the project report PDF securely.
     */
    public function downloadStudentPdf($id)
        {
            $supervisor = Auth::user();
            $report = Report::whereHas('group', function ($query) use ($supervisor) {
                $query->where('supervisor_id', $supervisor->id);
            })->findOrFail($id);

            if (!$report->pdf_file || !Storage::exists($report->pdf_file)) {
                return redirect()->back()->with('error', 'Report file not found.');
            }

            return response()->download(storage_path('app/' . $report->pdf_file));
        }

    /**
     * Upload a new version of the project report PDF securely.
     */
    public function upload(Request $request, $id)
    {
        $supervisor = Auth::user();
        $report = Report::whereHas('group', fn($q) => $q->where('supervisor_id', $supervisor->id))
                        ->findOrFail($id);

        $request->validate(['pdf' => 'required|mimes:pdf|max:20480']);

        $file = $request->file('pdf');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('reports', $fileName, 'local');
        
        $report->update(['pdf_file' => $filePath]);

        return redirect()->back()->with('success', 'Report uploaded successfully.');
    }

    /**
     * Review and comment on a project report.
     */
    public function review(Request $request, $id)
    {
        $supervisor = Auth::user();
        $report = Report::whereHas('group', fn($q) => $q->where('supervisor_id', $supervisor->id))
                        ->findOrFail($id);

        $request->validate(['status' => 'required|in:Draft,Ready for Submission', 'supervisor_comments' => 'required|string']);

        $comment = ReportComment::create(['report_id' => $report->id, 'supervisor_id' => $supervisor->id, 'comment' => $request->supervisor_comments]);
        $report->update(['status' => $request->status]);

        foreach ($report->group->students as $student) {
            Mail::to($student->email)->send(new SupervisorCommentNotification($report, $comment));
        }

        return redirect()->route('supervisor.reports.index')->with('success', 'Project reviewed and students notified.');
    }

    /**
     * Upload a review PDF securely.
     */
   public function uploadReviewPdf(Request $request, $id)
{
    $report = Report::findOrFail($id);
    
    $request->validate([
        'review_pdf' => 'required|mimes:pdf|max:2048',
    ]);

    if ($request->hasFile('review_pdf')) {
        $file = $request->file('review_pdf');
        $filename = 'review_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('supervisor_reviews', $filename);

        $report->review_pdf = $path;
        $report->save();
    }

    return redirect()->back()->with('success', 'Review PDF uploaded successfully.');
}


    /**
     * Download a review PDF securely.
     */
    public function downloadReviewPdf($id)
    {
        $user = Auth::user();
        $report = Report::findOrFail($id);
        $group = Group::findOrFail($report->group_id);

        if ($group->supervisor_id !== $user->id && !$group->students->contains('id', $user->id)) {
            abort(403, 'Unauthorized access');
        }

        return Storage::download($report->review_pdf);
    }

}

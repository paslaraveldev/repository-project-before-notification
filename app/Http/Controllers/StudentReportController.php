<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Group;
use App\Models\Concept;
use App\Models\ProjectType;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;
use App\Notifications\ReportSubmitted;



class StudentReportController extends Controller
{
   public function create()
    {
        $group = auth()->user()->groups()->first();
        $concepts = Concept::where('group_id', $group->id)->where('status', 'Accepted')->get();
        $projectTypes = ProjectType::all();
        return view('Studentfiles.projectreport.create', compact('group', 'concepts', 'projectTypes'));
    }

    public function store(Request $request)
{
    $group = auth()->user()->groups()->first();

    // Check if the group already has a report
    if (Report::where('group_id', $group->id)->exists()) {
        return redirect()->route('studentreports.index')->with('error', 'Your group has already submitted a report. You can only modify the existing report.');
    }

    $request->validate([
        'concept_id' => 'required|exists:concepts,id',
        'project_type_id' => 'required|exists:project_types,id',
        'title' => 'required|string|max:255',
        'abstract' => 'required|string',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg',
        'video_link' => 'nullable|url',
        'pdf_file' => 'required|mimes:pdf',
        'confidentiality_level' => 'required|in:Public,Restricted,Confidential',
    ]);

    $pdfPath = null;
    if ($request->hasFile('pdf_file')) {
        $pdfFile = $request->file('pdf_file');
        $pdfFileName = time() . '_' . $pdfFile->getClientOriginalName();
        $pdfPath = 'assets/projectreport/' . $pdfFileName;
        $pdfFile->move(public_path('assets/projectreport/'), $pdfFileName);
    }

    $imagePath = null;
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageFileName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('assets/report_images/'), $imageFileName);
        $imagePath = 'assets/report_images/' . $imageFileName;
    }

    $report = Report::create([
        'group_id' => $group->id,
        'concept_id' => $request->concept_id,
        'project_type_id' => $request->project_type_id,
        'title' => $request->title,
        'description' => $request->description,
        'image' => $imagePath,
        'abstract' => $request->abstract,
        'video_link' => $request->video_link,
        'pdf_file' => $pdfPath,
        'status' => 'Draft',
        'submitted_by' => auth()->id(),
        'confidentiality_level' => $request->confidentiality_level,
    ]);

    $supervisor = $report->group->supervisor;
    if ($supervisor) {
        $supervisor->notify(new ReportSubmitted($report));
    }

    return redirect()->route('studentreports.index')->with('success', 'Report submitted successfully.');
}


    public function index()
    {
        $user = auth()->user();
        $group = $user->groups()->first();
        if (!$group) {
            return redirect()->route('studentgroups.index')->with('error', 'You are not assigned to any group.');
        }

        $reports = Report::where('group_id', $group->id)->get();
        return view('Studentfiles.projectreport.index', compact('reports'));
    }

public function downloadSupervisorPdf($id)
{
    $report = Report::findOrFail($id);
    $user = auth()->user();
    $group = $user->groups()->first();

    // Ensure the student is in the correct group
    if (!$group || $group->id !== $report->group_id) {
        return redirect()->route('studentreports.index')->with('error', 'Unauthorized access');
    }

    // Check if the review PDF exists
    if (!$report->review_pdf || !Storage::exists($report->review_pdf)) {
        return redirect()->route('studentreports.index')->with('error', 'Review PDF not found.');
    }

    return response()->download(storage_path("app/" . $report->review_pdf));
}


    public function modify($id)
    {
        $report = Report::findOrFail($id);
        return view('Studentfiles.projectreport.modify', compact('report'));
    }

    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'video_link' => 'nullable|url',
            'pdf_file' => 'nullable|mimes:pdf',
        ]);

        if ($request->hasFile('pdf_file')) {
            $pdfFile = $request->file('pdf_file');
            $pdfFileName = time() . '_' . $pdfFile->getClientOriginalName();
            $pdfPath = 'assets/projectreport/' . $pdfFileName;
            $pdfFile->move(public_path('assets/projectreport/'), $pdfFileName);
            $report->pdf_file = $pdfPath;
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageFileName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/report_images/'), $imageFileName);
            $report->image = 'assets/report_images/' . $imageFileName;
        }

        $report->update($request->except(['pdf_file', 'image']));
        return redirect()->route('studentreports.index')->with('success', 'Report modified successfully.');
    }

}

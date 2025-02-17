<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Storage;

class AdminApprovedReportController extends Controller
{
     public function index()
    {
        $reports = Report::where('status', 'Ready for Submission')->with('group')->get();
        return view('Adminfiles.reports.approved_reports', compact('reports'));
    }

    public function show($id)
    {
        $report = Report::with('group')->findOrFail($id);
        return view('Adminfiles.reports.show_report', compact('report'));
    }

    public function download($id)
    {
        $report = Report::findOrFail($id);

        if (!Storage::disk('public')->exists($report->pdf_file)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        return response()->download(storage_path('app/public/' . $report->pdf_file));
    }
}

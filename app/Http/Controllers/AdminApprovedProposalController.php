<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposal;
use Illuminate\Support\Facades\Storage;


class AdminApprovedProposalController extends Controller
{
     public function index()
    {
        $proposals = Proposal::where('status', 'Approved')->with('group')->get();
        return view('Adminfiles.reports.approved_proposals', compact('proposals'));
    }

    public function show($id)
    {
        $proposal = Proposal::with('group')->findOrFail($id);
        return view('Adminfiles.reports.show_proposal', compact('proposal'));
    }

    public function download($id)
    {
        $proposal = Proposal::findOrFail($id);

        if (!Storage::disk('public')->exists($proposal->pdf_path)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        return response()->download(storage_path('app/public/' . $proposal->pdf_path));
    }
}

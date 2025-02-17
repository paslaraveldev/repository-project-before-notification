<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concept;
use App\Models\Proposal;
use App\Models\Report;
use App\Models\Group;
use App\Models\ProjectType;
use App\Models\User;

class AdminSortingController extends Controller
{
    /**
     * Display sorted concepts, proposals, or reports based on the filter.
     */
    public function index(Request $request)
    {
        // Get sorting parameters from the request
        $sortBy = $request->input('sort_by', 'title'); // Default sorting by title
        $sortOrder = $request->input('sort_order', 'asc'); // Default order ascending

        // Retrieve all reports with relationships
        $reports = Report::with(['group', 'concept', 'projectType', 'submittedBy'])
            ->orderBy($sortBy, $sortOrder)
            ->paginate(10); // Paginate results

        // Retrieve all proposals
        $proposals = Proposal::with(['group', 'concept', 'submittedBy', 'reviewedBy'])
            ->orderBy($sortBy, $sortOrder)
            ->paginate(10);

        // Retrieve all concepts
        $concepts = Concept::with(['group', 'updatedBy'])
            ->orderBy($sortBy, $sortOrder)
            ->paginate(10);

        return view('Adminfiles.sorted.sorted', compact('reports', 'proposals', 'concepts', 'sortBy', 'sortOrder'));
    }
}

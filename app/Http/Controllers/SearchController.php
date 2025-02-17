<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concept;
use App\Models\Course;
use App\Models\Department;
use App\Models\Group;
use App\Models\Proposal;
use App\Models\Report;
use App\Models\User;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return redirect()->back()->with('error', 'Please enter a search term.');
        }

        // Search in Concepts
        $concepts = Concept::where('title', 'LIKE', "%{$query}%")
            ->orWhere('main_objective', 'LIKE', "%{$query}%")
            ->orWhere('other_objectives', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->orWhere('significance', 'LIKE', "%{$query}%")
            ->orWhere('project_year', 'LIKE', "%{$query}%")
            ->get();

        // Search in Courses
        $courses = Course::where('name', 'LIKE', "%{$query}%")->get();

        // Search in Departments
        $departments = Department::where('name', 'LIKE', "%{$query}%")->get();

        // Search in Groups
        $groups = Group::where('name', 'LIKE', "%{$query}%")->get();

        // Search in Proposals
        $proposals = Proposal::where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->get();

        // Search in Reports
        $reports = Report::where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->orWhere('abstract', 'LIKE', "%{$query}%")
            ->get();

        // Search in Users (Students, Admins, Supervisors)
        $users = User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->orWhere('registration_number', 'LIKE', "%{$query}%")
            ->orWhere('job_id_number', 'LIKE', "%{$query}%")
            ->get();

        return view('search.results', compact(
            'query',
            'concepts',
            'courses',
            'departments',
            'groups',
            'proposals',
            'reports',
            'users'
        ));
    }
}

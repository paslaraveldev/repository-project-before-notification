<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Report;
use App\Models\Concept;
use App\Models\Proposal;
use App\Models\Department;
use App\Models\Course;
use App\Models\AboutUs;


class GuestController extends Controller
{
  public function index()
{
    // Retrieve supervisors with images
    $users = User::where('role', 'supervisor')->whereNotNull('image')->get();
    
    // Get paginated public reports (Ready for Submission)
    $latestReports = Report::where('status', 'Ready for Submission')
        ->latest()
        ->paginate(10); // Change 10 to the number of reports per page

    // Fetch paginated public concepts that are accepted and not confidential
    $publicConcepts = Concept::where('confidentiality_level', 'Public')
        ->where('status', 'Accepted')
        ->latest()
        ->paginate(10); // Paginate concepts

    // Fetch the latest proposals (optional: you may add pagination)
    $latestProposals = Proposal::latest()->take(3)->get();

    // Retrieve all departments for display
    $departments = Department::all();

    // Retrieve courses associated with departments
    $courses = Course::with('department')->get();

    // Fetch About Us data
    $about = AboutUs::first(); // Assuming there is only one record

    return view('index', compact(
        'users', 
        'latestReports', 
        'publicConcepts', 
        'latestProposals', 
        'departments', 
        'courses', 
        'about'
    ));
}


}

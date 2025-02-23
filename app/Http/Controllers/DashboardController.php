<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Proposal;
use App\Models\Report;
use App\Models\Concept;
use App\Models\Department;
use App\Models\AboutUs;

use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{

    public function dashboard()
{
    $user = Auth::user(); // Get the logged-in user

    if ($user->role == 'admin') {
        return view('admin.dashboard');
    } elseif ($user->role == 'student') {
        // Fetch courses the student is enrolled in
        $courses = Course::where('id', $user->id)->get(); 

        // Fetch only accepted concepts with pagination (3 per page)
        $publicConcepts = Concept::latest()->paginate(3);

        // Fetch latest proposals with pagination
        $latestProposals = Proposal::latest()->paginate(3);

        // Fetch latest reports with pagination
        $latestReports = Report::latest()->paginate(3);

        // Fetch about us details
        $about = AboutUs::first();

        // Fetch all supervisors
        $users = User::where('role', 'supervisor')->get();

        // Fetch all departments
        $departments = Department::with('head')->get();

        return view('Studentfiles.studenthomepage', compact(
            'user', 
            'courses', 
            'publicConcepts', 
            'latestProposals', 
            'latestReports', 
            'about', 
            'users', 
            'departments'
        ));
    } elseif ($user->role == 'supervisor') {
        return view('Supervisorfiles.dashboard');
    } else {
        return view('guestpage');
    }
}

        }

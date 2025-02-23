<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutUs;


class AboutUsController extends Controller
{
   public function index() {
        $about = AboutUs::first();
        return view('about_us.index', compact('about'));
    }

    public function create() {
        return view('about_us.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'purpose' => 'required',
            'mission' => 'required',
            'vision' => 'required',
            'features' => 'required',
            'audience' => 'required',
            'workflow' => 'required',
            'policies' => 'required',
            'team' => 'required',
            'phone1' => 'required',
            'phone2' => 'nullable',
            'phone3' => 'nullable',
            'phone4' => 'nullable',
            'email' => 'required|email',
            'po_box' => 'required',
        ]);

        AboutUs::create($validated);
        return redirect()->route('about.index')->with('success', 'About Us details created successfully!');
    }

    public function show($id) {
        $about = AboutUs::findOrFail($id);
        return view('about_us.show', compact('about'));
    }

    public function edit($id) {
        $about = AboutUs::findOrFail($id);
        return view('about_us.edit', compact('about'));
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'purpose' => 'required',
            'mission' => 'required',
            'vision' => 'required',
            'features' => 'required',
            'audience' => 'required',
            'workflow' => 'required',
            'policies' => 'required',
            'team' => 'required',
            'phone1' => 'required',
            'phone2' => 'nullable',
            'phone3' => 'nullable',
            'phone4' => 'nullable',
            'email' => 'required|email',
            'po_box' => 'required',
        ]);

        $about = AboutUs::findOrFail($id);
        $about->update($validated);
        return redirect()->route('about.index')->with('success', 'About Us details updated successfully!');
    }

    public function destroy($id) {
        $about = AboutUs::findOrFail($id);
        $about->delete();
        return redirect()->route('about.index')->with('success', 'About Us details deleted successfully!');
    }
}

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubjectController extends Controller
{
    function index() {
        $subjects = Subject::all();

        return Inertia::render('admin/Subjects/index', ['subjects' =>$subjects ]);
    }

    function update(Subject $subject, Request $request) {

        $subject->update(['name'=>$request->name, 'name_cn'=>$request->name_cn]);

        return redirect()->back();
    }

    function store( Request $request) {

        Subject::create(['name'=>$request->name, 'name_cn'=>$request->name_cn]);

        return redirect()->back();
    }

    function destroy(Subject $subject, Request $request) {

        $subject->delete();

        return redirect()->back();
    }
}

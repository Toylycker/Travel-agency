<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NoteController extends Controller
{
    function index() {
        $notes = Note::all();
        return Inertia::render('admin/Notes/index', ['notes' =>$notes ]);
    }

    function update(Note $note, Request $request) {
        $note->update(['name'=>$request->name, 'name_cn'=>$request->name_cn]);
        return redirect()->back();
    }

    function store(Request $request) {
        Note::create(['name'=>$request->name, 'name_cn'=>$request->name_cn]);
        return redirect()->back();
    }

    function destroy(Note $note, Request $request) {
        $note->delete();
        return redirect()->back();
    }
}

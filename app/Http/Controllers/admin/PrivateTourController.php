<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\Place;
use App\Models\Hotel;
use App\Models\Note;

class PrivateTourController extends Controller
{
    public function create()
    {
        return Inertia::render('admin/PrivateTours/Create', [
            'places' => Place::select(['id', 'name'])->get(),
            'hotels' => Hotel::select(['id', 'name'])->get(),
            'notes' => Note::select(['id', 'name'])->get(),
        ]);
    }
} 
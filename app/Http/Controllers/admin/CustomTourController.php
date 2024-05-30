<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CustomTour;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomTourController extends Controller
{
    public function index(){
        $customTours = CustomTour::with('country')->paginate('20')->withQueryString();

        return Inertia::render('admin/CustomTours/index', ['customTours'=>$customTours]);
    }
}

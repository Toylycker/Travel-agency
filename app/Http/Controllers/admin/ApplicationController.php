<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    public function index(){
        $applications = Application::with('country', 'tour')->paginate('20')->withQueryString();

        return Inertia::render('admin/Applications/index', ['applications'=>$applications]);
    }
}

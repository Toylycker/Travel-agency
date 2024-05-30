<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $filePath = storage_path('logs/visitor.log');
        $logEntries = [];

        if (File::exists($filePath)) {
            $lines = File::lines($filePath);
    
            foreach ($lines as $line) {
                    $logEntries[] = $line;
            }
        }
        return Inertia::render('admin/adminDashboard', ['log_entries'=>$logEntries]);
    }

    public function downloadVisitorsLog(){
        $filePath = storage_path('logs/visitor.log');
        if (File::exists($filePath)) {
            return response()->download($filePath, 'visitor.log');
        }
        return response()->json(['message' => 'File not found.'], 404);
    }

    public function deleteVisitorsLog(){
        $filePath = storage_path('logs/visitor.log');
        if (File::exists($filePath)) {
            File::delete($filePath);
            return response()->json(['message' => 'Log file successfully deleted.']);
        }
        return response()->json(['message' => 'File not found.'], 404);
    }
}
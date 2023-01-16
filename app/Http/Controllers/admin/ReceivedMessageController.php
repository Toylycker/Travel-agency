<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ReceivedMessage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReceivedMessageController extends Controller
{
    public function index()
    {
        $messages = ReceivedMessage::orderBy('id')->paginate('15');

        return Inertia::render('admin/Messages/index', ['messages'=>$messages]);
    }
}

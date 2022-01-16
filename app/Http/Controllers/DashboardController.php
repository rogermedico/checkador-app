<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {


        return view('dashboard.index', [
            'eventTypes' => EventType::all()
        ]);
    }
}
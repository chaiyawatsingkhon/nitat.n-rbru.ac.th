<?php

namespace App\Http\Controllers;

use App\Models\Activities;

class ActivitiesController extends Controller
{
    public function index()
    {
        $activities = Activities::with(['community', 'organization'])->get();
        return view('activities.index', compact('activities'));
    }
}
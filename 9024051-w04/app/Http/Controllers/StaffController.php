<?php

namespace App\Http\Controllers;

use App\Models\Staff;

class StaffController extends Controller
{
    public function index()
    {
        $staffs = Staff::with('title')->get();
        return view('staff.index', compact('staffs'));
    }
}
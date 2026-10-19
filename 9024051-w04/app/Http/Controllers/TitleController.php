<?php

namespace App\Http\Controllers;

use App\Models\Title;

class TitleController extends Controller
{
    public function index()
    {
        $titles = Title::all();
        return view('title.index', compact('titles'));
    }
}
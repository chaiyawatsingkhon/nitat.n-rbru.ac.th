<?php

namespace App\Http\Controllers;

use App\Models\Community;

class CommunityController extends Controller
{
    public function index()
    {
        $communities = Community::all();
        return view('community.index', compact('communities'));
    }
}
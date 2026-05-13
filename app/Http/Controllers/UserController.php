<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function ratings(Request $request)
    {
        return $request->user()
            ->ratings()
            ->with('movie')
            ->latest()
            ->get();
    }

    public function comments(Request $request)
    {
        return $request->user()
            ->comments()
            ->with('movie')
            ->latest()
            ->get();
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index() {
        return view('layouts.frontend');
    }

    public function article($slug) {
        return view('layouts.frontend');
    }
}

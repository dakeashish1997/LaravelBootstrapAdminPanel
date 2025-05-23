<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('home');
        }
        return view('admin.home');
    }
}

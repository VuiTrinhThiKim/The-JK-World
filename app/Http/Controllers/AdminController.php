<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
    	return view('admin_login_view');
    }

    public function show_dashboard(){
    	return view('admin_layout_view');
    }
}

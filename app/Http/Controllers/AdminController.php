<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use App\Models\Admin;
use Redirect;
use Session;
use Hash;

//Start session
session_start();

class AdminController extends Controller
{
    public function loginAuthentication() {
        $ad_username = Session::get('ad_username');

        if($ad_username){
            return Redirect::to('admin_login_view');
        }
        else {
            return Redirect::to('admin')->send('Vui lòng đăng nhập');
        }
    }
    public function index(){

    	return view('admin_login_view');
    }

    public function showDashboard(){
        
        $this->loginAuthentication();

    	return view('admin.dashboard_view');
    }

    public function showCreate(){

        return view('admin.add_admin_view');
    }
    //Check admin login
    public function dashboard(Request $request){

    	$username = $request->get('username');
    	$password = md5($request->password);

    	$result = Admin::where('username', $username)
    							     -> where('password', $password)
    							     -> first();
		if($result){
            Session::put('ad_username', $result->username);
            Session::put('ad_id', $result->id);
            return Redirect::to('admin/dashboard');
        }
        else {
            Session::put('message', 'Sai tên đăng nhập hoặc mật khẩu!!!');
            return Redirect::to('/admin');
        }
    }

    public function logout(){

        Session::put('ad_username', null);
        Session::put('ad_id', null);

        return Redirect::to('/admin');
    }
}

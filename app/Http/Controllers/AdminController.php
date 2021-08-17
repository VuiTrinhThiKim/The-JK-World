<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use App\Models\Admin;
use Redirect;
use Session;
use DB;

//Start session
session_start();

class AdminController extends Controller
{
    public function loginAuthentication() {
        $ad_username = Session::get('username');

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

    //Check admin login
    public function dashboard(Request $request_ad){

    	$username = $request_ad->username;
    	$password = md5($request_ad->password);

    	$result = DB::table('admin') -> where('username', $username)
    							     -> where('password', $password)
    							     -> first();
		if($result){
            Session::put('username', $result->username);
            Session::put('id', $result->id);
            return Redirect::to('admin/dashboard');
        }
        else {
            Session::put('message', 'Sai mật khẩu!!!');
            return Redirect::to('/admin');
        }
    }

    public function logout(){

        Session::put('username', null);
        Session::put('id', null);

        return Redirect::to('/admin');
    }
}

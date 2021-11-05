<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Order;
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

        $orders = Order::all(); 

        return view('admin.dashboard_view')->with('orders', $orders);
    }

    public function showCreate(){

        return view('admin.add_admin_view');
    }
    //Check admin login
    public function dashboard(Request $request){

        //dd($request);
        $username = $request->username;
        //dd($username);
        $password = $request->password;
        $result = Admin::where('username', $username)->first();
        $ad_avatar = $result->avatar;
        $admin_role = $result->role_id;
        //dd($admin_role);
        if($result) {
            $hashedPassword = $result->password;
            if (Hash::check($password, $hashedPassword)) {

                Session::put('ad_username', $username);
                Session::put('ad_avatar', $ad_avatar);
                Session::put('admin_id', $result->admin_id);
                Session::put('admin_role', $admin_role);
                return Redirect::to('admin/dashboard');
            }
            else {
                Session::put('message', 'Sai mật khẩu');
                return Redirect::to('/admin');
            }
        }
        Session::put('message', 'Sai tên đăng nhập');
        return Redirect::to('/admin');
    }

    public function logout(){

        Session::put('ad_username', null);
        Session::put('admin_id', null);

        return Redirect::to('/admin');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role_list = Role::orderby('role_name', 'asc')->get();

        return view('admin.member.add_member_view')->with('role_list', $role_list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(AdminRequest $request)
    {
        $admin = new Admin;

        $hash_pass = Hash::make($request->get('password'));

        $admin->username = $request->get('username');
        $admin->password= $hash_pass;
        $admin->first_name = $request->get('firstName');
        $admin->last_name = $request->get('lastName');
        $admin->dob = $request->get('adDOB');
        $admin->gender = $request->get('adGender');
        $admin->phone = $request->get('adPhone');
        $admin->email = $request->get('adEmail');
        $admin->address = $request->get('adAddress');
        $admin->role_id = $request->get('role_id');

        if(Admin::where('phone',$admin->phone)->first() != null) {
            Session::put('messMember','Lỗi: Số điện thoại đã được sử dụng!!!');
            return Redirect::to('/admin/member/add');
        }
        if(Admin::where('email',$admin->email)->first() != null) {
            Session::put('messMember','Lỗi: Email đã được sử dụng!!!');
            return Redirect::to('/admin/member/add');
        }
        $image = $request->file('adAvatar');
        if($image) {

            $extension = $image->getClientOriginalExtension();
            if(Admin::where('username',$admin->username)->first() == null) {
            
                $get_image_name = $image->getClientOriginalName();
                $new_image_name = current(explode('.',$get_image_name));
                $new_image =  $new_image_name.'-'.rand(0,128).'.'.$extension;
                $image->move('upload/avatar/admin/', $new_image);

                $admin->avatar = $new_image;
                // Save product
                $admin->save();
                // Get product_id
                Session::put('messUser','Thêm quản trị viên thành công');
                return Redirect::to('/admin/member/view-all');
            }
            else {
                Session::put('messUser','Lỗi: Tên đăng nhập đã được sử dụng!!!');
                return Redirect::to('/admin/member/add');
            }
        }
        $admin->avatar = 'no-pic.png';
        // Save product
        $admin->save();
        // Get product_id
        Session::put('messMember','Thêm quản trị viên thành công');
        return Redirect::to('/admin/member/view-all');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin, $admin_id)
    {
        $role_list = Role::orderby('role_name', 'asc')->get();

        $edit_admin = Admin::where('admin_id',$admin_id)->get();
        $manager_admin  = view('admin.member.edit_member_view')
                      ->with('admin', $edit_admin)
                      ->with('role_list',$role_list);
        //dd($manager_product);
        return view('admin_layout_view')->with('admin.member.edit_member_view', $manager_admin);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, Admin $admin, $admin_id)
    {
        $admin = Admin::where('admin_id',$admin_id)->first();
        //dd($admin);
        $hash_pass = Hash::make($request->get('password'));

        $admin->username = $request->get('username');
        $admin->password= $hash_pass;
        $admin->first_name = $request->get('firstName');
        $admin->last_name = $request->get('lastName');
        $admin->dob = $request->get('adDOB');
        $admin->gender = $request->get('adGender');
        $admin->phone = $request->get('adPhone');
        $admin->email = $request->get('adEmail');
        $admin->address = $request->get('adAddress');
        $admin->role_id = $request->get('role_id');

        if(Admin::where('phone',$admin->phone)->where('admin_id', '<>', $admin_id)->first() != null ){
            Session::put('messMember','Lỗi: Số điện thoại đã được sử dụng!!!');
            return Redirect::to('/admin/member/add');
        }
        if(Admin::where('email',$admin->email)->where('admin_id', '<>', $admin_id)->first() != null) {
            Session::put('messMember','Lỗi: Email đã được sử dụng!!!');
            return Redirect::to('/admin/member/add');
        }
        if(Admin::where('username',$admin->username)->where('admin_id', '<>', $admin_id)->first() != null) {
            Session::put('messMember','Lỗi: Tên đăng nhập đã được sử dụng!!!');
            return Redirect::to('/admin/member/edit/'.$admin_id);
        } 
        $image = $request->file('adAvatar');
        if($image) {

            $extension = $image->getClientOriginalExtension();
            $get_image_name = $image->getClientOriginalName();
                $new_image_name = current(explode('.',$get_image_name));
                $new_image =  $new_image_name.'-'.rand(0,128).'.'.$extension;
                $image->move('upload/avatar/admin/', $new_image);

                $admin->avatar = $new_image;
                // Save product
                $admin->save();
                // Get product_id
                Session::put('messMember','Cập nhật thông tin tài khoản thành công');
                return Redirect::to('/admin/member/view-all');
        }
        $user_img = Admin::where('admin_id', $admin_id)->value('avatar');
        $admin->avatar = $user_img;
        // Save product
        $admin->save();
        // Get product_id
        Session::put('messMember','Cập nhật thông tin tài khoản thành công');
        return Redirect::to('/admin/member/view-all');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy($admin_id)
    {
        $user = Admin::find($admin_id)->delete();
        Session::put('messUser','Xóa tài khoản thành công!!!');
        return Redirect::to('/admin/member/view-all');
    }

    public function view_all(){

        //$this->loginAuthentication();

        $admins = Admin::join('roles', 'roles.role_id', '=', 'admin.role_id')
                            ->orderby('roles.role_id', 'asc')->paginate(5);
        //dd($admins);
        $manager_admin = view('admin.member.all_members_view')-> with('admins', $admins);

        return view('admin_layout_view')
                ->with('admin.member.all_members_view', $manager_admin);
    }

    public function show_info($admin_id){

        $current_admin = Session::get('admin_id');
        if($current_admin == $admin_id) {
            $admin = Admin::where('admin_id', $admin_id)->get();
            //dd($admin);
            $admin_role = Admin::find($admin_id)->role->value('role_name');
            //dd($admin_role);
            $manager_admin = view('admin.show_info')->with('admin_id',$admin_id)
                                                    ->with('admin', $admin)
                                                    ->with('admin_role', $admin_role);
            return view('admin_layout_view')->with('admin.show_info', $manager_admin);
        }
        else {
            Session::put('messError', 'Bạn không có quyền này!!!');

            $manager_admin = view('admin.error')->with('admin_id',$admin_id);
            return view('admin_layout_view')->with('admin.error', $manager_admin);
        }
    }

    public function show_change_password($admin_id){

        $current_admin = Session::get('admin_id');

        $admin = Admin::where('admin_id', $admin_id)->first();
        if($admin == null) {
            Session::put('messError', 'Không tìm thấy dữ liệu!!!');

            $manager_admin = view('admin.error')->with('admin_id',$admin_id);
            return view('admin_layout_view')->with('admin.error', $manager_admin);
        }
        else {
            if( $current_admin != $admin_id || $admin->admin_role != 1) {
                Session::put('messError', 'Bạn không có quyền đổi password của tài khoản này!!!');

                $manager_admin = view('admin.error')->with('admin_id',$admin_id);
                return view('admin_layout_view')->with('admin.error', $manager_admin);
            }
        }
        $manager_admin = view('admin.change_password')->with('admin_id',$admin_id);
        return view('admin_layout_view')->with('admin.change_password', $manager_admin);
    }

    public function change_password(ChangePasswordRequest $request, $admin_id){

        $curent_password = $request->get('current_password');
        $hashed_password = $admin->password;

        //Check current password and change if 
        if (Hash::check($curent_password, $hashed_password)) {
            
            
            $new_password = $request->get('password');
            $hashed_new_password = Hash::make($new_password);

            $admin->password = $hashed_new_password;
            $admin->save();

            Session::put('messUpdate', 'Đổi mật khẩu thành công!!!');
        }
        else {
            Session::put('messUpdate', 'Sai mật khẩu hiện tại!!!');
        }
        
        $manager_admin = view('admin.change_password')->with('admin_id',$admin_id);
        return view('admin_layout_view')->with('admin.change_password', $manager_admin);
    }

    public function search(Request $request)
    {
        $keywords = $request->keywords;

        $result = Admin::where('username', 'LIKE BINARY', '%'.$keywords.'%')->get();

        Session::put('keywords', $keywords);
        Session::forget('filter');
        Session::forget('filter_id');
        return view('admin.member.search_member')->with('result', $result);
    }

    public function filter(Request $request)
    {
        $filter_value = $request->filter;
        Session::forget('keywords');
        //dd($filter_value);
        //$all_admin = Admin::;
        switch ($filter_value) {
            case '0':
                return Redirect::to('/admin/member/view-all');
            case '1':
                Session::put('filter', 'ID tăng dần');
                Session::put('filter_id', 1);
                $result = Admin::orderBy('admin_id')->paginate(5);
                return view('admin.member.search_member')->with('result', $result);
            case '2':
                Session::put('filter', 'ID giảm dần');
                Session::put('filter_id', 2);
                $result = Admin::orderByDesc('admin_id')->paginate(5);
                return view('admin.member.search_member')->with('result', $result);
            case '3':
                Session::put('filter', 'Tên A-Z');
                Session::put('filter_id', 3);
                $result = Admin::orderBy('first_name')->paginate(5);
                return view('admin.member.search_member')->with('result', $result);
            case '4':
                Session::put('filter', 'Tên Z-A');
                Session::put('filter_id', 4);
                $result = Admin::orderByDesc('first_name')->paginate(5);
                return view('admin.member.search_member')->with('result', $result);
            case '5':
                Session::put('filter', 'Manager');
                Session::put('filter_id', 5);
                $result = Admin::where('role_id', 1)->paginate(5);
                return view('admin.member.search_member')->with('result', $result);
            case '6':
                Session::put('filter', 'Staff');
                Session::put('filter_id', 6);
                $result = Admin::where('role_id', 2)->paginate(5);
                return view('admin.member.search_member')->with('result', $result);
            default:
                return Redirect::to('/admin/member/view-all');
        }
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Session;
use Redirect;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category_list = Category::orderby('category_name', 'asc')->get();
        $brand_list = Brand::orderby('brand_name', 'asc')->get();
        
        return view('page.user.login_view')->with('category_list', $category_list)->with('brand_list', $brand_list);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role_list = Role::orderby('role_name', 'asc')->get();

        return view('admin.user.add_user_view')->with('role_list', $role_list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(UserRequest $request)
    {
        $user = new User;

        $hash_pass = Hash::make($request->get('password'));

        $user->username = $request->get('username');
        $user->password= $hash_pass;
        $user->first_name = $request->get('firstName');
        $user->last_name = $request->get('lastName');
        $user->phone = $request->get('userPhone');
        $user->email = $request->get('userEmail');
        $user->address = $request->get('userAddress');
        $user->role_id = $request->get('role_id');

        if(User::where('phone',$user->phone)->first() != null) {
            Session::put('messUser','Lỗi: Số điện thoại đã được sử dụng!!!');
            return Redirect::to('/admin/user/add');
        }
        if(User::where('email',$user->email)->first() != null) {
            Session::put('messUser','Lỗi: Email đã được sử dụng!!!');
            return Redirect::to('/admin/user/add');
        }
        $image = $request->file('userAvatar');
        if($image) {

            $extension = $image->getClientOriginalExtension();
            if(User::where('username',$user->username)->first() == null) {
            
                $get_image_name = $image->getClientOriginalName();
                $new_image_name = current(explode('.',$get_image_name));
                $new_image =  $new_image_name.'-'.rand(0,128).'.'.$extension;
                $image->move('public/upload/avatar', $new_image);

                $user->avatar = $new_image;
                // Save product
                $user->save();
                // Get product_id
                Session::put('messUser','Thêm người dùng thành công');
                return Redirect::to('/admin/user/view-all');
            }
            else {
                Session::put('messUser','Lỗi: Tên đăng nhập đã được sử dụng!!!');
                return Redirect::to('/admin/user/add');
            }
        }
        $user->avatar = 'no-pic.png';
        // Save product
        $user->save();
        // Get product_id
        Session::put('messUser','Thêm người dùng thành công');
        return Redirect::to('/admin/user/view-all');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, $user_id)
    {
        $role_list = Role::orderby('role_name', 'asc')->get();

        $edit_user = User::where('user_id',$user_id)->get();
        $manager_user  = view('admin.user.edit_user_view')
                      ->with('edit_user', $edit_user)
                      ->with('role_list',$role_list);
        //dd($manager_product);
        return view('admin_layout_view')->with('admin.user.edit_user_view', $manager_user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user, $user_id)
    {
        $user = User::where('user_id',$user_id)->first();
        //dd($user);
        $hash_pass = Hash::make($request->get('password'));

        $user->username = $request->get('username');
        $user->password= $hash_pass;
        $user->first_name = $request->get('firstName');
        $user->last_name = $request->get('lastName');
        $user->phone = $request->get('userPhone');
        $user->email = $request->get('userEmail');
        $user->address = $request->get('userAddress');
        $user->role_id = $request->get('role_id');

        if(User::where('phone',$user->phone)->where('user_id', '<>', $user_id)->first() != null ){
            Session::put('messUser','Lỗi: Số điện thoại đã được sử dụng!!!');
            return Redirect::to('/admin/user/add');
        }
        if(User::where('email',$user->email)->where('user_id', '<>', $user_id)->first() != null) {
            Session::put('messUser','Lỗi: Email đã được sử dụng!!!');
            return Redirect::to('/admin/user/add');
        }
        if(User::where('username',$user->username)->where('user_id', '<>', $user_id)->first() != null) {
            Session::put('messUser','Lỗi: Tên đăng nhập đã được sử dụng!!!');
            return Redirect::to('/admin/user/edit/'.$user_id);
        } 
        $image = $request->file('userAvatar');
        if($image) {

            $extension = $image->getClientOriginalExtension();
            $get_image_name = $image->getClientOriginalName();
                $new_image_name = current(explode('.',$get_image_name));
                $new_image =  $new_image_name.'-'.rand(0,128).'.'.$extension;
                $image->move('public/upload/avatar', $new_image);

                $user->avatar = $new_image;
                // Save product
                $user->save();
                // Get product_id
                Session::put('messUser','Cập nhật thông tin người dùng thành công');
                return Redirect::to('/admin/user/view-all');
        }
        $user_img = User::where('user_id', $user_id)->value('avatar');
        $user->avatar = $user_img;
        // Save product
        $user->save();
        // Get product_id
        Session::put('messUser','Cập nhật thông người dùng thành công');
        return Redirect::to('/admin/user/view-all');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
        $user = User::find($user_id)->delete();
        Session::put('messUser','Xóa tài khoản người dùng thành công!!!');
        return Redirect::to('/admin/user/view-all');
    }

    public function view_all(){

        //$this->loginAuthentication();

        $all_user = User::join('roles', 'roles.role_id', '=', 'users.role_id')
                            ->orderby('roles.role_id', 'asc')->get();
        //dd($all_product);
        $manager_user = view('admin.user.all_users_view') 
                     -> with('all_users', $all_user);

        return view('admin_layout_view')->with('admin.user.all_users_view', $manager_user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

}

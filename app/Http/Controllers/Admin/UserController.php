<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /*
        *
        * Editing/Saving USERS
        *
       */

    public function index(){

        $adm_users = User::orderBy('id','asc')->paginate(2);

        if(request()->ajax()){
            return view('admin.user.ajax.ajax-pagination', [
                'adm_users' => $adm_users,
            ])->render();
        }

        return view('admin.user.index', [
            'user' => $this->getUser(),
            'adm_users'=> $adm_users
        ]);
    }

    public function editUser($user_id){
        $user = User::find($user_id);

        if(!$user){
            return response()->view('errors.404-admin', [
                'user' => $this->getUser(),
            ], 404);
        }

        return view('admin.user.edit',[
            'user' => $this->getUser(),
            'adm_user' => $user,
        ]);
    }

    public function saveEditUser(Request $request){
        $user = User::find($request['id']);

        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        $superuser = false;
        if($request['admin-field'] == "on"){
            $superuser = true;
        }
        $user->update([
            'first_name'=> $request['firstname-field'],
            'last_name'=> $request['lastname-field'],
            'email'=> $request['email-field'],
            'city'=> $request['city-field'],
            'active'=> $active,
            'superuser'=> $superuser,

        ]);
        session(['success-message' => 'Користувача успішно змінено.']);
        return redirect('/admin/users');
    }

    public function delUser($user_id){
        User::find($user_id)->delete();
        session(['success-message' => 'Користувача успішно видалено.']);
        return redirect('/admin/users');
    }
}

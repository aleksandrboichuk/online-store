<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /*
        *
        * Editing/Saving USERS
        *
       */

    protected function validator(array $data){
        $messages = [
            'firstname-field.min' => 'Ім\'я має містити не менше 2-х символів.',
            'lastname-field.min' => 'Прізвище має містити не менше 2-х символів.',
            'email-field.min' => 'E-mail має містити не менше 8-ми символів.',
            'email-field.unique' => 'Користувач з таким E-mail вже існує.',
        ];
        return Validator::make($data, [
            'firstname-field' => ['string', 'min:2'],
            'lastname-field' => ['string', 'min:2'],
            'email-field' => ['string', 'unique:users,email', 'min:8'],
        ], $messages);
    }

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

    public function edit($user_id){
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

    public function saveEdit(Request $request){
        $user = User::find($request['id']);

        // ================ в случае старого email не делать валидацию на уникальность==============
        if($request['email-field'] == $user->email){
            $validator = $this->validator($request->except('email-field'));
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }else{
            // ================ если email все же изменили то проверить на уникальность ==============
            $validator = $this->validator($request->all());
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }

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
        return redirect('/admin/users')->with(['success-message' => 'Користувача успішно змінено.']);
    }

    public function delete($user_id){
        User::find($user_id)->delete();
        return redirect('/admin/users')->with(['success-message' => 'Користувача успішно видалено.']);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRole;
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        if(!$user){
            return response()->view('errors.404-admin', [
                'user' => $this->getUser(),
            ], 404);
        }

        if(!empty($user->roles) && count($user->roles) > 0){
            $arRoles = [];
            foreach ($user->roles as $r){
                $arRoles[] = $r->id;
            }
        }

        return view('admin.user.edit',[
            'user' => $this->getUser(),
            'adm_user' => $user,
            'roles' => UserRole::all(),
            'arRoles' => isset($arRoles) ? $arRoles : null,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        //   в случае старого email не делать валидацию на уникальность
        if($request['email-field'] == $user->email){
            $validator = $this->validator($request->except('email-field'));
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }else{
            //   если email все же изменили то проверить на уникальность
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

        $user->update([
            'first_name'=> $request['firstname-field'],
            'last_name'=> $request['lastname-field'],
            'email'=> $request['email-field'],
            'city'=> $request['city-field'],
            'active'=> $active,
        ]);

        $user->roles()->detach();
        if(isset($request['roles']) && !empty($request['roles']) && count($request['roles']) > 0){
            $user->update(['superuser' => 1]);
            foreach ($request['roles'] as $r) {
                $user->roles()->attach([
                    'user_role_id' => intval($r),
                ]);
            }
        }else{
            $user->update(['superuser' => 0]);
        }

        return redirect('/admin/users')->with(['success-message' => 'Користувача успішно змінено.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect('/admin/users')->with(['success-message' => 'Користувача успішно видалено.']);
    }
}

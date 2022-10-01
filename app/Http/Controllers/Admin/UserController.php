<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|string
     */
    public function index(): View|Factory|string|Application
    {
        $users = User::query()->orderBy('id','asc')->paginate(2);

        // ajax pagination
        if(request()->ajax()){
            return view('admin.user.ajax.pagination', compact('users'))->render();
        }

        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public function edit(int $id): View|Factory|Response|Application
    {
        $user = User::query()->find($id);

        if(!$user){
            abort(404);
        }

        //TODO:: with Trait or Lib
        if(!empty($user->roles) && count($user->roles) > 0){
            $arRoles = [];
            foreach ($user->roles as $r){
                $arRoles[] = $r->id;
            }
        }

        return view('admin.user.edit',[
            'selected_user' => $user,
            'roles' => UserRole::all(),
            'arRoles' => $arRoles ?? null,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(UserRequest $request, int $id)
    {
        $user = User::query()->find($id);

        if(!$user){
            abort(404);
        }

        $request->setActiveField();

        $user->update($request->all());

        //TODO:: user roles
//        $user->roles()->detach();
//        if(isset($request['roles']) && !empty($request['roles']) && count($request['roles']) > 0){
//            $user->update(['superuser' => 1]);
//            foreach ($request['roles'] as $r) {
//                $user->roles()->attach([
//                    'user_role_id' => intval($r),
//                ]);
//            }
//        }else{
//            $user->update(['superuser' => 0]);
//        }

        return redirect('/admin/users')->with(['success-message' => 'Користувача успішно змінено.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy($id): Redirector|RedirectResponse|Application
    {
        $user = User::query()->find($id);

        if(!$user){
            abort(404);
        }

        $user->delete();

        return redirect('/admin/users')->with(['success-message' => 'Користувача успішно видалено.']);
    }
}

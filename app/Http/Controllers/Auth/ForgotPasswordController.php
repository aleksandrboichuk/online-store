<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordReset;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    protected function validator(array $data){
        $messages = [
            'email.exists' => 'E-mail не зареєстрований.',
            'email.min' => 'E-mail має містити не менше 10-ти символів.',
        ];
        return Validator::make($data, [
            'email' => ['email', 'min:10' , 'exists:users'],
        ], $messages);
    }

    //      ОСТОРОЖНО!!     
    //       Г**НО КОД      


    public function showForgotPasswordForm(){
        return view('auth.passwords.reset', [
            'cart' => $this->getCartByToken(),
        ]);
    }

    public function sendEmailWithCode(Request $request){
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = \App\Models\User::where('email', $request['email'])->first();

        //  генерируем код и отправляем письмо  
        $code = rand(100001, 999999);
        try{
            Mail::to($request['email'])->send(new PasswordReset($code, $user));
        }catch(\Exception $e){
            return redirect()->back();
        }

        //  в спец табоицу в базе вносим данные  
        DB::table('password_resets')->insert([
           'email' =>  $user->email,
           'confirm_code' => $code,
           'session_code' => session()->getId(),
           'created_at' => date('Y-m-d H:i:s')
        ]);
        //  чтоб не было доступа к урлу - все далаем по цепочке вьюх  
        return  view('auth.passwords.confirm', [
            'cart' => $this->getCartByToken(),
        ])->with(['success' => 'Лист з кодом відправлено на вказаний E-mail.']);
    }

    public function confirmEmailCode(Request $request){
//  проверяем на любопытных, которые меняют имя инпута на фронте  
        if(isset($request['code'])){
            //  получаем ранее созданную запись в бд через токен сессии  
            $record = DB::table('password_resets')->where('session_code',session()->getId())->orderBy('created_at', 'desc')->first();

            if(!$record){
                return redirect('/login')->with(['error' => 'Щось пішло не так. Спробуйте ще раз через декілька хвилин.']);
            }elseif($record->created_at < date('Y-m-d H:i:s', strtotime('-5 minutes'))){
                return redirect('/login')->with(['error' => 'Час вийшов. Спробуйте ще раз через декілька хвилин']);
            }

            if($record->confirm_code != trim($request['code'])){
               return view('auth.passwords.confirm', [
                   'cart' => $this->getCartByToken(),
                   'code' => 'Код невірний'
               ]);
            }else{
               return view('auth.passwords.new-password', [
                   'cart' => $this->getCartByToken(),
               ]);
            }
        }else{
           return redirect('/login')->with(['error' => 'Щось пішло не так. Спробуйте ще раз через декілька хвилин.']);
        }
    }

    public function savePassword(Request $request){
        $record = DB::table('password_resets')->where('session_code', session()->getId())->orderBy('created_at', 'desc')->first();
        if(!$record){
            return redirect('/login')->with(['error' => 'Щось пішло не так. Спробуйте ще раз через декілька хвилин.']);
        }
        //   валидация нового пароля  
        $messages = [
            'password.min' => 'Пароль повинен містити не менше 3-x символів.',
            'password.confirmed' => 'Паролі не співпадають.',
        ];
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:3', 'confirmed'],
        ], $messages);

        if ($validator->fails()) {
//  опять же все через цепочку вьюх  
            return view('auth.passwords.new-password')->with([
               'password_error'=> $validator->errors()->get('password')[0],
               'password_confirm_error' => isset($validator->errors()->get('password')[1]) ? $validator->errors()->get('password')[1] :  null
            ]);
        }
//   наконец обновляем пароль в бд  
        $user = User::where('email', $record->email)->first();
        $user->update([
            'password' => Hash::make($request['password'])
        ]);

        return redirect('/login')->with(['success' => 'Пароль успішно змінено!']);

    }
}

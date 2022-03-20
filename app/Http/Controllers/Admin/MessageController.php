<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    public function index()
    {
        $messages = UserMessage::orderBy('id', 'desc')->paginate(3);

        if(request()->ajax()){
            return view('admin.message.ajax.ajax-pagination', [
                'messages' => $messages,
            ])->render();
        }

        return view('admin.message.index',[
            'user'=>$this->getUser(),
            'messages' => $messages,

        ]);
    }

    //showing

    public function showMessage($message_id){
        $message = UserMessage::find($message_id);

        if(!$message){
            return response()->view('errors.404-admin', [
                'user' => $this->getUser(),
            ], 404);
        }
        return view('admin.message.single-message',[
            'user' => $this->getUser(),
            'message' => $message ,

        ]);
    }

    //delete

    public function delMessage($message_id){
        $message = UserMessage::find($message_id);
        $message->delete();
        session(['success-message' => 'Повідомлення успішно видалено.']);
        return redirect("/admin/messages");
    }
}

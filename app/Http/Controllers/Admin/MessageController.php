<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserMessage;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|string
     */
    public function index(): View|Factory|string|Application
    {
        $messages = UserMessage::query()->orderBy('id', 'desc')->paginate(3);

        // ajax pagination
        if(request()->ajax()){
            return view('admin.message.ajax.pagination', [
                'messages' => $messages,
            ])->render();
        }

        return view('admin.message.index', compact('messages'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public function show(int $id): View|Factory|Response|Application
    {
        $message = UserMessage::query()->find($id);

        if(!$message){
           abort(404);
        }

        return view('admin.message.single-message', compact('message'));
    }

    /**
     *  Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(int $id): Redirector|RedirectResponse|Application
    {
        $message = UserMessage::query()->find($id);

        if(!$message){
            abort(404);
        }

        $message->delete();

        return redirect("/admin/messages")->with(['success-message' => 'Повідомлення успішно видалено.']);
    }
}

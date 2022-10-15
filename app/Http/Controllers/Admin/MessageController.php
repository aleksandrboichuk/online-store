<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserMessage;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class MessageController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|string
     */
    public function index(): View|Factory|string|Application
    {
        $this->canSee('messages');

        $messages = UserMessage::query()->orderBy('id', 'desc')->paginate(3);

        // ajax pagination
        if(request()->ajax()){
            return view('admin.message.ajax.pagination', [
                'messages' => $messages,
            ])->render();
        }

        $this->setBreadcrumbs($this->getBreadcrumbs());

        return view('admin.message.index', [
            'messages' => $messages,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Get the breadcrumbs array
     *
     * @return array[]
     */
    protected function getBreadcrumbs(): array
    {
        $breadcrumbs = parent::getBreadcrumbs();

        $breadcrumbs[] = ["Повідомлення"];

        return $breadcrumbs;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public function show(int $id): View|Factory|Response|Application
    {
        $this->canSee('messages');

        $message = UserMessage::query()->find($id);

        if(!$message){
           abort(404);
        }

        $this->setBreadcrumbs($this->getCreateOrEditPageBreadcrumbs('messages',false));

        return view('admin.message.single-message',[
            'message' => $message,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     *  Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(int $id): Redirector|RedirectResponse|Application
    {
        $this->canDelete('messages');

        $message = UserMessage::query()->find($id);

        if(!$message){
            abort(404);
        }

        $message->delete();

        return redirect("/admin/messages")->with(['success-message' => 'Повідомлення успішно видалено.']);
    }
}

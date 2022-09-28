<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SizeRequest;
use App\Models\ProductSize;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;

class SizeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $sizes =  ProductSize::query()->orderBy('id', 'desc')->get();
        return view('admin.additional-to-products.size.index', compact('sizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('admin.additional-to-products.size.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SizeRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(SizeRequest $request): Redirector|RedirectResponse|Application
    {
        $request->setActiveField();

        ProductSize::query()->create($request->all());

        return redirect('/admin/sizes')->with(['success-message' => 'Розмір успішно додано.']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(int $id): View|Factory|Application
    {
        $size = ProductSize::query()->find($id);

        if(!$size){
            abort(404);
        }

        return view('admin.additional-to-products.size.edit', compact('size'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SizeRequest $request
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(SizeRequest $request, int $id)
    {
        $size = ProductSize::query()->find($id);

        if(!$size){
            abort(404);
        }

        $request->setActiveField();

        $size->update($request->all());

        return redirect('admin/sizes')->with(['success-message' => 'Розмір успішно змінено.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(int $id): Redirector|RedirectResponse|Application
    {
        $size = ProductSize::query()->find($id);

        if(!$size){
            abort(404);
        }

        $size->delete();

        return redirect('admin/sizes')->with(['success-message' => 'Розмір успішно видалено.']);
    }
}

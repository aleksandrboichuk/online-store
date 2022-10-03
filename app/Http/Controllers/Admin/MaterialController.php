<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MaterialRequest;
use App\Models\Material;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;

class MaterialController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $materials = Material::query()->orderBy('id', 'desc')->get();

        return view('admin.additional-to-products.material.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('admin.additional-to-products.material.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MaterialRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(MaterialRequest $request): Redirector|RedirectResponse|Application
    {
        $request->setActiveField();

        Material::query()->create($request->all());

        return redirect('/admin/materials')->with(['success-message' => 'Матеріал успішно додано.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public function edit(int $id): View|Factory|Response|Application
    {
        $material = Material::query()->find($id);

        if(!$material){
            abort(404);
        }

        return view('admin.additional-to-products.material.edit', compact('material'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MaterialRequest $request
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(MaterialRequest $request, int $id): Redirector|RedirectResponse|Application
    {
        $material = Material::query()->find($id);

        if(!$material){
            abort(404);
        }

        $request->setActiveField();

        $material->update($request->all());

        return redirect('admin/materials')->with(['success-message' => 'Матеріал успішно змінено.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(int $id): Redirector|RedirectResponse|Application
    {
        $material = Material::query()->find($id);

        if(!$material){
            abort(404);
        }

        return redirect('admin/materials')->with(['success-message' => 'Матеріал успішно видалено.']);
    }
}

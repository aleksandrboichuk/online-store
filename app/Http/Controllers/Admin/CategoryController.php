<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    protected function validator(array $data){
        $messages = [
            'title-field.min' => 'Заговоловок має містити не менше 3-х символів.',
            'name-field.min' => 'Назва має містити не менше 3-х символів.',
            'seo-field.min' => 'СЕО має містити не менше 3-х символів.',
            'seo-field.unique' => 'СЕО вже існує.',
        ];
        return Validator::make($data, [
            'title-field' => ['string', 'min:3'],
            'name-field' => [ 'string', 'min:3'],
            'seo-field' => [ 'string', 'min:3',  'unique:categories,seo_name']
        ], $messages);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('admin.category.index',[
            'user'=>$this->getUser(),
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.add',[
            'user'=>$this->getUser(),
            'category_groups' => CategoryGroup::where('active', 1)->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        //   Определение активности чекбокса
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }

        //   Создание категории
        $category =  Category::create([
            'title' => $request['title-field'],
            'name' => $request['name-field'],
            'seo_name' => $request['seo-field'],
            'active' => $active,
        ]);

        //   Связь категории с группой категорий
        $category->categoryGroups()->attach($category->id,[
            'category_group_id' => $request['cat-field'],
            'category_id' => $category->id
        ]);
        return redirect('/admin/categories')->with(['success-message' => 'Категорію успішно додано.']);
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
        $category =  Category::find($id);

        if(!$category){
            return response()->view('errors.404-admin', [
                'user' => $this->getUser(),
            ], 404);
        }
        return view('admin.category.edit',[
            'user' => $this->getUser(),
            'category' => $category,
            'category_groups' => CategoryGroup::all()

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
        $category = Category::find($id);

        //   в случае старого сео не делать валидацию на уникальность

        if($request['seo-field'] == $category->seo_name){
            $validator = $this->validator($request->except('seo-field'));
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }else{
            //   если сео все же изменили то проверить на уникальность

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
        // отключаем все продукты категории и подкатегории,
        // если саму категорию отключили
        if($category->active == 1 && $active == false){
            foreach ($category->products as $product) {
                $product->update(['active' => $active]);
            }
            foreach ($category->subCategories as $subCat) {
                $subCat->update(['active' => $active]);
            }
        }elseif($category->active == 0 && $active == true){
            foreach ($category->products as $product) {
                $product->update(['active' => $active]);
            }
            foreach ($category->subCategories as $subCat) {
                $subCat->update(['active' => $active]);
            }
        }
        //   обновляем запись в базе
        $category->update([
            'title' => $request['title-field'],
            'name' => $request['name-field'],
            'seo_name' => $request['seo-field'],
            'active' => $active,
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        //   обновляем связь с группой категорий

        $category->categoryGroups()->where('category_id', $request['id'])->update(["category_group_id" => $request['cat-field']]);
        return redirect("/admin/categories")->with(['success-message' => 'Категорію успішно змінено.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect("/admin/categories")->with(['success-message' => 'Категорію успішно видалено.']);
    }
}

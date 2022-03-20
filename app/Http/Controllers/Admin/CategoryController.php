<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('admin.category.index',[
            'user'=>$this->getUser(),
            'categories' => $categories
        ]);
    }

    //show adding form

    public function addCategory(){

        return view('admin.category.add',[
            'user'=>$this->getUser(),
            'category_groups' => CategoryGroup::where('active', 1)->get()
        ]);
    }

    //saving add

    public function saveAddCategory(Request $request){
        Validator::make($request->all(), [
            'title-field' => ['required', 'string', 'max:255', 'unique:categories'],
            'name-field' => ['required', 'string', 'max:255', 'unique:categories'],
            'seo-field' => ['required', 'string', 'min:8',  'unique:categories']
        ]);

        $category = new Category();
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        $category->create([
            'title' => $request['title-field'],
            'name' => $request['name-field'],
            'seo_name' => $request['seo-field'],
            'active' => $active,
        ]);
        $addedCategory = Category::where('title', $request['title-field'])->first();
        $category->categoryGroups()->attach($addedCategory->id,[
            'category_group_id' => $request['cat-field'],
            'category_id' => $addedCategory->id
        ]);
        session(['success-message' => 'Категорію успішно додано.']);
        return redirect('/admin/categories');
    }

    //editing

    public function editCategory($category_id){
        $category =  Category::find($category_id);

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


    //saving edit

    public function saveEditCategory(Request $request){

        $category = Category::find($request['id']);
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

        $category->update([
            'title' => $request['title-field'],
            'name' => $request['name-field'],
            'seo_name' => $request['seo-field'],
            'active' => $active,
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        $category->categoryGroups()->where('category_id', $request['id'])->update(["category_group_id" => $request['cat-field']]);
        session(['success-message' => 'Категорію успішно змінено.']);
        return redirect("/admin/categories");
    }

    //delete

    public function delCategory($category_id){
        $category = Category::find($category_id);
        $category->delete();
        session(['success-message' => 'Категорію успішно видалено.']);
        return redirect("/admin/categories");
    }
}

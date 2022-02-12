<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index', [
            'user'=>$this->getUser(),
        ]);
    }

    public function categoryIndex()
    {
        $categories = Category::all();
        return view('admin.category.index',[
            'user'=>$this->getUser(),
            'categories' => $categories
        ]);
    }
    public function addCategory(){

        return view('admin.category.add',[
            'user'=>$this->getUser(),
        ]);
    }

    public function saveAddCategory(Request $request){
        Validator::make($request->all(), [
            'title-field' => ['required', 'string', 'max:255', 'unique:categories'],
            'name-field' => ['required', 'string', 'max:255', 'unique:categories'],
            'seo-field' => ['required', 'string', 'min:8',  'unique:categories']
        ]);

        $category = new Category;
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

        return redirect('/admin/categories');
    }

    public function editCategory($category_id){


        return view('admin.category.edit',[
            'user' => $this->getUser(),
            'category' =>  Category::find($category_id)

        ]);
    }

    public function saveEditCategory(Request $request){

        $category = Category::find($request['id']);
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        $category->update([
            'title' => $request['title-field'],
            'name' => $request['name-field'],
            'seo_name' => $request['seo-field'],
            'active' => $active,
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        $category->categoryGroups()->where('category_id', $request['id'])->update(["category_group_id" => $request['cat-field']]);

        return redirect("/admin/categories");
    }

    public function delCategory($category_id){
        $category = Category::find($category_id);
        $category->delete();

        return redirect("/admin/categories");
    }

}

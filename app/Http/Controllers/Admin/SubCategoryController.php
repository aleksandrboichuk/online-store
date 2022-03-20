<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subcategories =  SubCategory::orderBy('id', 'desc')->get();
        return view('admin.subcategory.index',[
            'user'=>$this->getUser(),
            'subcategories' => $subcategories
        ]);
    }

    //show adding form

    public function addSubCategory(){

        return view('admin.subcategory.add',[
            'user'=>$this->getUser(),
            'categories' => Category::where('active', 1)->get()
        ]);
    }

    //saving add

    public function saveAddSubCategory(Request $request){
        Validator::make($request->all(), [
            'title-field' => ['required', 'string', 'max:255', 'unique:sub_categories'],
            'name-field' => ['required', 'string', 'max:255', 'unique:sub_categories'],
            'seo-field' => ['required', 'string', 'min:8',  'unique:sub_categories']
        ]);

        $subcategory = new SubCategory();
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        $subcategory->create([
            'title' => $request['title-field'],
            'name' => $request['name-field'],
            'seo_name' => $request['seo-field'],
            'category_id' => $request['cat-field'],
            'active' => $active,
        ]);
        session(['success-message' => 'Підкатегорію успішно додано.']);
        return redirect('/admin/subcategories');
    }

    //editing

    public function editSubCategory($subcategory_id){
        $subCategory = SubCategory::find($subcategory_id);

        if(!$subCategory){
            return response()->view('errors.404-admin', [
                'user' => $this->getUser(),
            ], 404);
        }
        return view('admin.subcategory.edit',[
            'user' => $this->getUser(),
            'subcategory' =>  $subCategory,
            'categories' => Category::all()
        ]);
    }


    //saving edit

    public function saveEditSubCategory(Request $request){

        $subcategory = SubCategory::find($request['id']);
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }

        // отключаем все продукты подкатегории,
        // если саму подкатегории отключили

        if($subcategory->active == 1 && $active == false){
            foreach ($subcategory->products as $product) {
                $product->update(['active' => $active]);
            }
        }elseif($subcategory->active == 0 && $active == true){
            foreach ($subcategory->products as $product) {
                $product->update(['active' => $active]);
            }
        }

        $subcategory->update([
            'title' => $request['title-field'],
            'name' => $request['name-field'],
            'seo_name' => $request['seo-field'],
            'category_id' =>  $request['cat-field'],
            'active' => $active,
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        session(['success-message' => 'Підкатегорію успішно змінено.']);
        return redirect("/admin/subcategories");
    }

    //delete

    public function delSubCategory($subcategory_id){
        $subcategory = SubCategory::find($subcategory_id);
        $subcategory->delete();
        session(['success-message' => 'Підкатегорію успішно видалено.']);
        return redirect("/admin/subcategories");
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{

    protected function validator(array $data){
        $messages = [
            'name-field.min' => 'Назва має містити не менше 4-х символів.',
            'title-field.min' => 'Заговоловок має містити не менше 4-х символів.',
            'seo-field.min' => 'СЕО має містити не менше 4-х символів.',
            'seo-field.unique' => 'СЕО вже існує.',
        ];
        return Validator::make($data, [
            'name-field' => ['string', 'min:4'],
            'title-field' => ['string', 'min:4'],
            'seo-field' => ['string', 'unique:sub_categories,seo_name', 'min:4'],
        ], $messages);
    }

    public function index()
    {
        $subcategories =  SubCategory::orderBy('id', 'desc')->get();
        return view('admin.subcategory.index',[
            'user'=>$this->getUser(),
            'subcategories' => $subcategories
        ]);
    }

    //show adding form

    public function add(){

        return view('admin.subcategory.add',[
            'user'=>$this->getUser(),
            'categories' => Category::where('active', 1)->get()
        ]);
    }

    //saving add

    public function saveAdd(Request $request){
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

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
        return redirect('/admin/subcategories')->with(['success-message' => 'Підкатегорію успішно додано.']);
    }

    //editing

    public function edit($subcategory_id){
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

    public function saveEdit(Request $request){
        $subcategory = SubCategory::find($request['id']);

        // ================ в случае старого сео не делать валидацию на уникальность==============
        if($request['seo-field'] == $subcategory->seo_name){
            $validator = $this->validator($request->except('seo-field'));
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }else{
            // ================ если сео все же изменили то проверить на уникальность ==============

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
        return redirect("/admin/subcategories")->with(['success-message' => 'Підкатегорію успішно змінено.']);
    }

    //delete

    public function delete($subcategory_id){
        $subcategory = SubCategory::find($subcategory_id);
        $subcategory->delete();
        return redirect("/admin/subcategories")->with(['success-message' => 'Підкатегорію успішно видалено.']);
    }
}

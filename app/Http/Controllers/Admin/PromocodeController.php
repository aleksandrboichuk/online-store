<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\UserPromocode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PromocodeController extends Controller
{
    protected function validator(array $data){
        $messages = [
            'title-field.min' => 'Заговоловок має містити не менше 3-х символів.',
            'promocode-field.min' => 'Промокод має містити не менше 3-х символів.',
            'promocode-field.unique' => 'Промокод вже існує.',
            'description-field.min' => 'Опис має містити не менше 10-ти символів.',
        ];
        return Validator::make($data, [
            'title-field' => ['string', 'min:3'],
            'description-field' => ['string', 'min:10'],
            'promocode-field' => ['string', 'min:3','unique:user_promocodes,promocode'],
        ], $messages);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promocodes = UserPromocode::orderBy('id', 'desc')->paginate(5);

        if(request()->ajax()){
            return view('admin.promocode.ajax.ajax-pagination', [
                'promocodes' => $promocodes,
            ])->render();
        }

        return view('admin.promocode.index',[
            'user'=>$this->getUser(),
            'promocodes' => $promocodes,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.promocode.add',[
            'user'=>$this->getUser(),
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

        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        UserPromocode::create([
            'title' => $request['title-field'],
            'description' => $request['description-field'],
            'discount' => $request['discount-field'],
            'min_cart_total' => !empty( $request['min-cart-total-field']) &&  $request['min-cart-total-field'] != '0' ?  $request['min-cart-total-field'] : null,
            'min_cart_products' =>  !empty( $request['min-cart-products-field']) &&  $request['min-cart-products-field'] != '0' ?  $request['min-cart-products-field'] : null,
            'promocode' => $request['promocode-field'],
            'active' => $active,
        ]);
        return redirect('/admin/promocodes')->with(['success-message' => 'Промокод успішно додано.']);
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
        $promocode = UserPromocode::find($id);

        if(!$promocode){
            return response()->view('errors.404-admin', [
                'user' => $this->getUser(),
            ], 404);
        }
        return view('admin.promocode.edit',[
            'user' => $this->getUser(),
            'promocode' => $promocode ,
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
        $promocode = UserPromocode::find($id);
        // ================ в случае старого promocode не делать валидацию на уникальность==============
        if($request['promocode-field'] == $promocode->promocode){
            $validator = $this->validator($request->except('promocode-field'));
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }else{
            // ================ если promocode все же изменили то проверить на уникальность ==============
            $validator = $this->validator($request->all());
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }
        if(!$promocode){
            if($this->getUser()){
                $cart = $this->getCartByToken();
            }
            return response()->view('errors.404', ['user' => $this->getUser(), 'cart' => isset($cart) ? $cart : null ], 404);
        }
        $active = false;
        if($request['active-field'] == "on"){
            $active = true;
        }
        $promocode->update([
            'title' => $request['title-field'],
            'description' => $request['description-field'],
            'discount' => $request['discount-field'],
            'min_cart_total' => isset( $request['min-cart-total-field']) &&  $request['min-cart-total-field'] != '0' ?  $request['min-cart-total-field'] : null,
            'min_cart_products' =>  isset( $request['min-cart-products-field']) &&  $request['min-cart-products-field'] != '0' ?  $request['min-cart-products-field'] : null,
            'promocode' => $request['promocode-field'],
            'active' => $active,
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        return redirect("/admin/promocodes")->with(['success-message' => 'Промокод успішно змінено.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $promocode = UserPromocode::find($id);
        $promocode->delete();
        return redirect("/admin/promocodes")->with(['success-message' => 'Промокод успішно видалено.']);
    }
}

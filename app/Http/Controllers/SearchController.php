<?php

namespace App\Http\Controllers;

use App\Services\ElasticSearch;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request, ElasticSearch $elasticSearch ){
       // dd($request->get('q'));
        $products = $elasticSearch->search('Кросівки Black');

        return view('search', compact('products'));
    }
}

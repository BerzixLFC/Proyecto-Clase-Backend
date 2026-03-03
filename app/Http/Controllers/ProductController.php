<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){  
    $productList = Product::all();

    return view('product.index', [
        'miLista' => $productList
    ]);}

    public function create()
    {
        return view('product.create');
    }

    public function show($id, $categoria = null)
    {
        return view('product.show');
    }
}
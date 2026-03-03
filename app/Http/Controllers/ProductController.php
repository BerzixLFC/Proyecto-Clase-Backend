<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $productList = Product::all();
        return view('product.index', [
            'miLista' => $productList
        ]);
    }

    public function create()
    {
        // Corregido: Variable en minúscula por convención
        $categorias = Category::all(); 
        return view('product.create', [
            'categorias' => $categorias
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        $newProduct = new Product();
        $newProduct->name = $request->input('nombre');
        $newProduct->description = $request->input('descripcion');
        $newProduct->price = $request->input('precio');
        $newProduct->category_id = $request->input('category_id'); 
        $newProduct->save();
        
        return redirect()->route('product.index');
    }

    public function show($id, $categoria = null)
    {
        return view('product.show');
    }
}
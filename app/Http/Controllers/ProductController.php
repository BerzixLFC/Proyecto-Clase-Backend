<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
// Importamos la fachada Storage para manejar archivos
use Illuminate\Support\Facades\Storage; 

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
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' 
        ]);

        $newProduct = new Product();
        $newProduct->name = $request->input('nombre');
        $newProduct->description = $request->input('descripcion');
        $newProduct->price = $request->input('precio');
        $newProduct->category_id = $request->input('category_id');

        //LÓGICA DE SUBIDA DE IMAGEN
        if ($request->hasFile('imagen')) {
            $imageName = time().'_'.$request->file('imagen')->getClientOriginalName();
            
            $path = $request->file('imagen')->storeAs('products', $imageName, 'public'); 
            
            $newProduct->image = $path; 
        }

        $newProduct->save();
        
        return redirect()->route('product.index');
    }

    public function show($id, $categoria = null)
    {
        $product = Product::findOrFail($id); 

        return view('product.show', compact('product'));
    }
}
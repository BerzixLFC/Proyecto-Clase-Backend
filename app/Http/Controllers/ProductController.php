<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 

class ProductController extends Controller
{
    // ==========================================
    // MOSTRAR PANEL DE ADMINISTRADOR
    // ==========================================
    public function adminIndex(Request $request)
    {
        $categorias = Category::all(); 
        
        // Si hay una categoría en la URL, filtramos. Si no, traemos todos.
        if ($request->has('category')) {
            $productList = Product::where('category_id', $request->input('category'))->get();
        } else {
            $productList = Product::all(); 
        }
        
        return view('product.admin', [
            'productList' => $productList,
            'categorias' => $categorias
        ]);
    }

    // ==========================================
    // MOSTRAR CATÁLOGO NORMAL (CLIENTES)
    // ==========================================
    public function index()
    {
        $productList = Product::paginate(10);
        return view('product.index', [
            'miLista' => $productList
        ]);
    }

    // ==========================================
    // MOSTRAR FORMULARIO DE CREACIÓN
    // ==========================================
    public function create()
    {
        $categorias = Category::all(); 
        return view('product.create', [
            'categorias' => $categorias
        ]);
    }

    // ==========================================
    // GUARDAR NUEVO PRODUCTO
    // ==========================================
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'descripcion' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'specifications' => 'nullable|string'
        ]);

        $newProduct = new Product();
        $newProduct->name = $request->input('nombre');
        $newProduct->description = $request->input('descripcion');
        $newProduct->price = $request->input('precio');
        $newProduct->category_id = $request->input('category_id');
        $newProduct->specifications = $request->input('specifications'); 
        $newProduct->is_in_stock = 1; // Por defecto disponible

        if ($request->hasFile('imagen')) {
            $imageName = time().'_'.$request->file('imagen')->getClientOriginalName();
            $path = $request->file('imagen')->storeAs('products', $imageName, 'public'); 
            $newProduct->image = $path; 
        }

        $newProduct->save();
        
        return redirect()->route('product.admin');
    }

    // ==========================================
    // MOSTRAR DETALLE DEL PRODUCTO (SHOW)
    // ==========================================
    public function show($id, $categoria = null)
    {
        $product = Product::findOrFail($id); 
        $categorias = Category::all(); 
        
        $isAdmin = request()->has('admin');
        $autoEdit = request()->has('edit');
        
        return view('product.show', compact('product', 'categorias', 'isAdmin', 'autoEdit'));
    }

    // ==========================================
    // ACTUALIZAR PRODUCTO DESDE EL MODAL
    // ==========================================
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'is_in_stock' => 'required|boolean',
            'specifications' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'imagen_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'imagen_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'imagen_4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->category_id = $request->input('category_id');
        $product->is_in_stock = $request->input('is_in_stock');
        $product->specifications = $request->input('specifications');

        $images = [
            'imagen' => 'image', 
            'imagen_2' => 'image_2', 
            'imagen_3' => 'image_3', 
            'imagen_4' => 'image_4'
        ];

        foreach($images as $input => $column) {
            if ($request->has('remove_'.$column)) {
                if ($product->$column) {
                    Storage::disk('public')->delete($product->$column);
                }
                $product->$column = null;
            }

            if ($request->hasFile($input)) {
                if ($product->$column) {
                    Storage::disk('public')->delete($product->$column);
                }
                $imageName = time().'_'.$input.'_'.$request->file($input)->getClientOriginalName();
                $path = $request->file($input)->storeAs('products', $imageName, 'public'); 
                $product->$column = $path;
            }
        }

        $product->save();
        
        return redirect()->route('product.show', ['id' => $product->id, 'edit' => 1]);
    }

    // ==========================================
    // ELIMINAR PRODUCTO POR COMPLETO
    // ==========================================
    public function destroy(Product $product)
    {
        $images = ['image', 'image_2', 'image_3', 'image_4'];
        
        foreach($images as $img) {
            if ($product->$img) {
                Storage::disk('public')->delete($product->$img);
            }
        }
        
        $product->delete();
        
        return redirect()->route('product.admin');
    }
}
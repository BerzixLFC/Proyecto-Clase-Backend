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
        // Traemos las categorías con su conteo de productos
        $categorias = Category::withCount('products')->get(); 
        
        // Productos para la pestaña de "Productos" (con filtro backend)
        if ($request->has('category') && $request->input('category') != "") {
            $productList = Product::where('category_id', $request->input('category'))->get();
        } else {
            $productList = Product::all(); 
        }

        // Todos los productos sin filtrar para la pestaña "Landing Home"
        $allProducts = Product::all();

        // Obtener la configuración del Home para el editor
        $homeSetting = \App\Models\HomeSetting::first() ?? (object) [
            'hero_title' => 'El futuro de la tecnología, hoy.',
            'hero_description' => 'Descubre nuestro catálogo con los equipos más potentes...',
            'why_us_title' => '¿Por qué escogernos?',
            'why_us_description' => 'Ofrecemos la mejor calidad en equipos...'
        ];
        
        return view('product.admin', [
            'productList' => $productList,
            'allProducts' => $allProducts, // Pasamos la lista completa
            'categorias' => $categorias,
            'homeSetting' => $homeSetting
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
        
        return redirect()->route('product.admin', ['tab' => 'products']);
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
        
        return redirect()->route('product.admin', ['tab' => 'products']);
    }

    // ==========================================
    // CRUD CATEGORIAS
    // ==========================================
    public function storeCategory(Request $request) {
        $request->validate(['name' => 'required|string|max:255']);
        $cat = new Category();
        $cat->name = $request->input('name');
        $cat->save();
        return redirect()->route('product.admin', ['tab' => 'categories']);
    }

    public function updateCategory(Request $request, $id) {
        $request->validate(['name' => 'required|string|max:255']);
        $cat = Category::findOrFail($id);
        $cat->name = $request->input('name');
        $cat->save();
        return redirect()->route('product.admin', ['tab' => 'categories']);
    }

    public function destroyCategory($id) {
        $cat = Category::findOrFail($id);
        $cat->delete();
        return redirect()->route('product.admin', ['tab' => 'categories']);
    }

    // ==========================================
    // ACTUALIZAR LANDING PAGE (WELCOME)
    // ==========================================
    public function updateHomeSettings(Request $request) {
        $request->validate([
            'hero_title' => 'required|string',
            'hero_description' => 'required|string',
            'why_us_title' => 'required|string',
            'why_us_description' => 'required|string',
            'hero_image_1' => 'nullable|image|max:2048',
            'hero_image_2' => 'nullable|image|max:2048',
            'hero_image_3' => 'nullable|image|max:2048',
            'hero_image_4' => 'nullable|image|max:2048',
        ]);

        $setting = \App\Models\HomeSetting::first();
        if(!$setting) {
            $setting = new \App\Models\HomeSetting();
        }

        $setting->hero_title = $request->input('hero_title');
        $setting->hero_description = $request->input('hero_description');
        $setting->why_us_title = $request->input('why_us_title');
        $setting->why_us_description = $request->input('why_us_description');

        // Guardar las imágenes
        for ($i = 1; $i <= 4; $i++) {
            $field = 'hero_image_' . $i;
            if ($request->has('remove_'.$field)) {
                if ($setting->$field) Storage::disk('public')->delete($setting->$field);
                $setting->$field = null;
            }
            if ($request->hasFile($field)) {
                if ($setting->$field) Storage::disk('public')->delete($setting->$field);
                $setting->$field = $request->file($field)->storeAs('landing', time().'_img'.$i.'_'.$request->file($field)->getClientOriginalName(), 'public');
            }
        }
        $setting->save();

        // Actualizar Productos Destacados (Máximo 10)
        // Primero reiniciamos todos a 0
        Product::where('is_featured', 1)->update(['is_featured' => 0]);
        
        // Luego ponemos en 1 los que llegaron en el formulario
        if($request->has('featured_products')) {
            // limitamos a 10 por seguridad en backend
            $selectedIds = array_slice($request->input('featured_products'), 0, 10);
            Product::whereIn('id', $selectedIds)->update(['is_featured' => 1]);
        }

        return redirect()->route('product.admin', ['tab' => 'landing']);
    }
}
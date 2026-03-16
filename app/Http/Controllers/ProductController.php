<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // ==========================================
    // CATÁLOGO PÚBLICO (CON BUSCADOR Y FILTROS)
    // ==========================================
    public function index(Request $request)
    {
        $query = Product::query();

        // Filtrar por nombre si el usuario busca algo
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filtrar por categoría si selecciona una en el menú desplegable
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Paginamos y mantenemos los filtros en la URL
        $productList = $query->paginate(10)->appends($request->all());
        
        // AQUÍ ESTÁ LA SOLUCIÓN: Traemos todas las categorías para llenar el menú
        $categorias = Category::all(); 

        return view('product.index', [
            'miLista' => $productList,
            'categorias' => $categorias
        ]);
    }

    // ==========================================
    // VISTA DE DETALLE DEL PRODUCTO
    // ==========================================
    public function show($id, $categoria = null)
    {
        $product = Product::with('category')->findOrFail($id);
        $categorias = Category::all();
        
        $isAdmin = request()->has('admin');
        $autoEdit = request()->has('edit');
        
        return view('product.show', compact('product', 'categorias', 'isAdmin', 'autoEdit'));
    }

    // ==========================================
    // PANEL DE ADMINISTRADOR
    // ==========================================
    public function adminIndex(Request $request)
    {
        $tab = $request->query('tab', 'products');
        $products = Product::with('category')->get();
        $categorias = Category::all();
        $homeSetting = DB::table('home_settings')->first();
        
        return view('product.admin', compact('products', 'categorias', 'tab', 'homeSetting'));
    }

    // ==========================================
    // CREAR PRODUCTO (VISTA)
    // ==========================================
    public function create()
    {
        $categorias = Category::all();
        return view('product.create', compact('categorias'));
    }

    // ==========================================
    // GUARDAR PRODUCTO
    // ==========================================
    public function store(Request $request)
    {
        $data = $request->all();
        $data['is_in_stock'] = $request->has('is_in_stock') ? 1 : 0;
        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;

        if ($request->hasFile('imagen')) {
            $data['image'] = $request->file('imagen')->store('productos', 'public');
        }
        if ($request->hasFile('imagen_2')) {
            $data['image_2'] = $request->file('imagen_2')->store('productos', 'public');
        }
        if ($request->hasFile('imagen_3')) {
            $data['image_3'] = $request->file('imagen_3')->store('productos', 'public');
        }
        if ($request->hasFile('imagen_4')) {
            $data['image_4'] = $request->file('imagen_4')->store('productos', 'public');
        }

        Product::create($data);
        return redirect()->route('product.admin', ['tab' => 'products'])->with('success', 'Producto creado.');
    }

    // ==========================================
    // ACTUALIZAR PRODUCTO
    // ==========================================
    public function update(Request $request, Product $product)
    {
        $data = $request->all();
        
        $data['is_in_stock'] = $request->input('is_in_stock', 0);
        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;

        $imgFields = ['image' => 'imagen', 'image_2' => 'imagen_2', 'image_3' => 'imagen_3', 'image_4' => 'imagen_4'];

        foreach ($imgFields as $dbCol => $inputName) {
            if ($request->has("remove_{$dbCol}")) {
                if ($product->$dbCol) Storage::disk('public')->delete($product->$dbCol);
                $data[$dbCol] = null;
            }
            if ($request->hasFile($inputName)) {
                if ($product->$dbCol) Storage::disk('public')->delete($product->$dbCol);
                $data[$dbCol] = $request->file($inputName)->store('productos', 'public');
            }
        }

        $product->update($data);
        return redirect()->back()->with('success', 'Producto actualizado correctamente.');
    }

    // ==========================================
    // ELIMINAR PRODUCTO
    // ==========================================
    public function destroy(Product $product)
    {
        if ($product->image) Storage::disk('public')->delete($product->image);
        if ($product->image_2) Storage::disk('public')->delete($product->image_2);
        if ($product->image_3) Storage::disk('public')->delete($product->image_3);
        if ($product->image_4) Storage::disk('public')->delete($product->image_4);
        
        $product->delete();
        return redirect()->route('product.admin', ['tab' => 'products'])->with('success', 'Producto eliminado.');
    }

    // ==========================================
    // CATEGORÍAS (CRUD)
    // ==========================================
    public function storeCategory(Request $request)
    {
        Category::create(['name' => $request->name]);
        return redirect()->route('product.admin', ['tab' => 'categories'])->with('success', 'Categoría creada.');
    }

    public function updateCategory(Request $request, $id)
    {
        $cat = Category::findOrFail($id);
        $cat->update(['name' => $request->name]);
        return redirect()->route('product.admin', ['tab' => 'categories'])->with('success', 'Categoría actualizada.');
    }

    public function destroyCategory($id)
    {
        $cat = Category::findOrFail($id);
        $cat->delete();
        return redirect()->route('product.admin', ['tab' => 'categories'])->with('success', 'Categoría eliminada.');
    }

    // ==========================================
    // ACTUALIZAR LANDING PAGE (HOME)
    // ==========================================
    public function updateHomeSettings(Request $request)
    {
        $setting = DB::table('home_settings')->first();
        $data = $request->only(['hero_title', 'hero_description', 'why_us_title', 'why_us_description']);

        for ($i = 1; $i <= 4; $i++) {
            $field = "hero_image_$i";
            if ($request->hasFile($field)) {
                if ($setting && $setting->$field) Storage::disk('public')->delete($setting->$field);
                $data[$field] = $request->file($field)->store('home', 'public');
            } elseif ($request->has("remove_$field")) {
                if ($setting && $setting->$field) Storage::disk('public')->delete($setting->$field);
                $data[$field] = null;
            }
        }

        if ($setting) {
            DB::table('home_settings')->where('id', $setting->id)->update($data);
        } else {
            DB::table('home_settings')->insert($data);
        }

        Product::query()->update(['is_featured' => 0]);
        if ($request->has('featured_products')) {
            Product::whereIn('id', $request->featured_products)->update(['is_featured' => 1]);
        }

        return redirect()->route('product.admin', ['tab' => 'landing'])->with('success', 'Página de inicio actualizada.');
    }
}
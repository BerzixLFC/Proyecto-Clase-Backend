<?php

namespace App\Http\Controllers;

use App\Models\carItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private function getUserId() {
        if (Auth::check()) return Auth::id();
        
        $defaultUser = User::first();
        if (!$defaultUser) {
            $defaultUser = User::create([
                'name' => 'Cliente de Prueba',
                'email' => 'cliente' . time() . '@prueba.com',
                'password' => bcrypt('12345678')
            ]);
        }
        return $defaultUser->id;
    }

    public function index()
    {
        $userId = $this->getUserId();
        $cartItems = carItem::with('product')->where('user_id', $userId)->get();
        
        $total = 0;
        foreach($cartItems as $item) {
            if($item->product) {
                $total += $item->product->price * $item->quantity;
            }
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, $productId)
    {
        $userId = $this->getUserId();
        $product = Product::findOrFail($productId);
        
        // Atrapamos la cantidad que envía la vista (por defecto 1 si no envían nada)
        $qty = $request->input('quantity', 1);

        $cartItem = carItem::where('user_id', $userId)->where('product_id', $productId)->first();

        if ($cartItem) {
            // Si ya existe el producto, le sumamos la cantidad seleccionada
            $cartItem->quantity += $qty;
            $cartItem->save();
        } else {
            // Si es nuevo en el carrito, lo creamos con esa cantidad
            carItem::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $qty
            ]);
        }

        return redirect()->back()->with('show_cart', true);
    }

    public function remove($id)
    {
        $cartItem = carItem::findOrFail($id);
        $cartItem->delete();

        return redirect()->back()->with('show_cart', true);
    }

    public function clear()
    {
        $userId = $this->getUserId();
        carItem::where('user_id', $userId)->delete();

        return redirect()->route('cart.success');
    }

    public function success()
    {
        return view('cart.success');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Http\Requests\CartRequest;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class CartController extends Controller
{
    private CartService $cartService;

    public function __construct(CartService $cartService) {
        $this->cartService = $cartService;
    }

    public function add(CartRequest $request)
    {
        $data = $request->validated();

        $product = Product::getProductToCart($data['product_id'], $data['color'], $data['sizes']);
        // dd($product);
        $this->cartService->addToCart($data, $product);
        
        return back();
    }

    public function index()
    {
        $cartItems = $this->cartService->getCart();

        return view("site.cart", compact('cartItems'));
    }

    public function updateCart(Request $request)
    {
        $cartData = $request->validate([
            'id' => ['required', 'string', 'max:13'],
            'action' => ['required', 'string', 'max:1'],
            'quantity' => ['required', 'integer', 'min:1', 'max:10000']
        ]);

        if ($cartData['action'] === "+") {
            $cartData['quantity']++;
        } else if ($cartData['action'] === '-' && $cartData['quantity'] > 1) {
            $cartData['quantity']--;
        }

        $item = Cart::get($cartData['id']);

        Cart::update($cartData['id'], [
            'quantity' => [
                'value' => $cartData['quantity'],
                'relative' => false,
            ],
            'attributes' => $item->attributes,
        ]);

        return back();
    }

    public function removeOne(string $id)
    {
        Cart::remove($id);
        
        return back();
    }

    public function clearCart() 
    {
        Cart::clear();

        return back();
    }

}



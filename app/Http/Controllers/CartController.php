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
        
        return $this->cartService->addToCart($data, $product);
    }

    public function index($isUpdate = false)
    {
        $cartItems = $this->cartService->getCart();

        return !$isUpdate ? view("site.cart", compact('cartItems')) 
                          : view("components.basket", compact('cartItems'));
            
    }

    public function updateCart(Request $request)
    {
        $cartData = $request->validate([
            'id' => ['required', 'string', 'max:13'],
            'action_btn' => ['required', 'string', 'max:10'],
            'quantity' => ['required', 'integer', 'min:1', 'max:10000']
        ]);

        $this->cartService->update($cartData);
        return $this->index(true);
    }

    public function removeOne(string $id)
    {
        Cart::remove($id);

        return $this->index(true);
    }

    public function clearCart() 
    {
        Cart::clear();

        return $this->index(true);
    }

}



<?php

namespace App\Services;

use App\Models\Product;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class CartService 
{
    public function addToCart(array $data, Product $product)
    {
        // dd($data, $product);
        Cart::add([
            'id' => $data['sizes'] . '_' . $data['color'], // inique row ID
            'name' => $product->title,
            'price' => $product->saleprice,
            'quantity' => 1,
            'attributes' => [
                'product_id' => $data['product_id'],
                'img_url' => $product->img_url,
                'color_name' => $product->chousen_color->name,
                'color_hex' => $product->chousen_color->hex,
                'size' => $product->chousen_size->name,
                'old_price' => $product->price,
            ]
        ]);

        Cart::getContent();
    }

    public function getCart()
    {
        $contentCart = Cart::getContent()->sortBy('id');
        // dump($contentCart);
        $totalPrice = $totalOldPrice = 0;

        $contentCart->each(function($item) use (&$totalPrice, &$totalOldPrice) {
            $totalPrice += $item->price;
            $totalOldPrice += $item->attributes->old_price; 
        });
        
        $contentCart->total_price = $totalPrice;
        $contentCart->total_old_price = $totalOldPrice;
        $contentCart->total_discount = $totalOldPrice - $totalPrice;

        return $contentCart;
    }

   public function update($cartData)
    {
        $item = Cart::get($cartData['id']);

        if ($cartData['action_btn'] === "+") {
            $cartData['quantity'] = $item->quantity + 1;
        } elseif ($cartData['action_btn'] === "-" && $item->quantity > 1) {
            $cartData['quantity'] = $item->quantity - 1;
        } elseif ($cartData['action_btn'] === "set") {
            $cartData['quantity'] = max(1, (int)$cartData['quantity']);
        }

        Cart::update($cartData['id'], [
            'quantity' => [
                'value' => $cartData['quantity'],
                'relative' => false,
            ],
            'attributes' => $item->attributes,
        ]);
    }



}
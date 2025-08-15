<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Darryldecode\Cart\CartCollection;

class CacheStorage
{
    private $data = [];
    private $cart_id;

    public function __construct()
    {
        $this->cart_id = Cookie::get('cart');
        if ($this->cart_id) {
            $this->data = \Cache::get('cart_' . $this->cart_id, []);
        } else {
            $this->cart_id = uniqid();
        }
    }

    /**
     * Check if item exists in Storage.
     */
    public function has($key)
    {
        return isset($this->data[$key]);
    }

    /**
     * Get item from Storage.
     */
    public function get($key)
    {
        return new CartCollection($this->data[$key] ?? []);
    }

    /**
     * Put item into Storage.
     */
    public function put($key, $value)
    {
        $this->data[$key] = $value;
        \Cache::put('cart_' . $this->cart_id, $this->data, Carbon::now()->addDays(30));

        if (!Cookie::hasQueued('cart')) {
            Cookie::queue(
                Cookie::make('cart', $this->cart_id, 60 * 24 * 30)
            );
        }
    }
}

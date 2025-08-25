<?php

namespace App\Http\Controllers\Site;

use App\Models\Order;
use App\Models\Customer;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    private CartService $cartService;
    
    public function __construct(CartService $cartService) {
        $this->cartService = $cartService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('product', 'customer')
        ->where('user_id', Auth::user()->id)->get();
        return view('user.order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        return view('site.order');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        $orderData = $request->validated();
        $dataCustomer = $orderData;
        unset($dataCustomer['adress']);
        if(!Auth::user()) {
            $userData = Customer::create($dataCustomer);
        } else {
            $userData = Auth::user()->customer;
            $userData->customer_id = $userData->id;
        }
        
        $cartData = $this->cartService->getCart();
        
        $userData['adress'] = $orderData['adress'];

        Order::createOrder($userData, $cartData);
        $this->tgBot($userData, $cartData);
        
        return to_route('site.index');
    }

    public function tgBot($userData, $cartData)
    {
        $textContent = "Ім'я замовника: <b>$userData->name</b>\n" .
            "Прізвище: <b>$userData->surname</b>\n" .
            "Телефон: <b>$userData->phone</b>\n" .
            "Адреса: <b>$userData->adress</b>\n";

        foreach ($cartData as $item) {
            $textContent .= "\n------Товар------\n\n" . 
            "Назва товару: <b>$item->name</b>\n" .
            "Колір: <b>" . $item->attributes->color_name . "</b>\n" .
            "Розмір: <b>" . $item->attributes->size . "</b>\n" .
            "Кількість: <b>$item->quantity</b>\n" .
            "Ціна: <b>$item->price грн</b>\n";
            if($item->quantity > 1) {
               $textContent .= "Сума: <b>" . $item->quantity * $item->price . " грн</b>\n";
            }
        }

        $textContent .= "\nЗагальна вартість: <b><u>$cartData->total_price грн</u></b>";

        Http::post("https://api.telegram.org/bot" . env("TOKEN_TG") . "/sendMessage", 
            [
                'chat_id' => env("CHAT_ID"),
                'text' => strip_tags($textContent, '<b><i><u><s><code><pre>'),
                'parse_mode' => "HTML"
            ],
        );
    }

}

<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use App\Mail\OrderThankyouMail;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PrintOption;
use App\Models\Shipping;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;

class OrderController extends Controller
{
    

    public function addToCart($id) {

        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

        if(!$cart){
            $cart = new Cart();
            $cart->user_id = $user->id;
            $cart->totalPrice = 0;
            $cart->save();
        }

        $cartItem = CartItem::where(['cart_id' => $cart->id, 'photo_id' => $id])->first();
        
        if(!$cartItem){
            $cartItem = new CartItem();
            
            $cartItem->photo_id = $id;
            $cartItem->cart_id = $cart->id;
            $cartItem->price = 0;
            $cartItem->quantity = 1;            
        } else {
            $cartItem->quantity = $cartItem->quantity + 1;
        }

        $cartItem->save();

        return redirect()
            ->route('gallery')
            ->withSuccess(__('crud.cart.add_to_cart'));

        

    }

    public function cart(){
        
        $user = Auth::user();

        $cart = Cart::where('user_id', $user->id)->first();
        $printOptions = PrintOption::get();

        $shippings = Shipping::get();

        return view('app.order.cart', compact('cart', 'printOptions', 'shippings'));

    }

    public function updateCart(Request $request, $id){
        
        $cartItem = CartItem::where('id', $request->id)->first();

        $printOption = PrintOption::where('id', $request->print_option)->first();

        $cartItem->print_option = $request->print_option;
        $cartItem->quantity = $request->quantity;
        $cartItem->price = $printOption->price;

        $cartItem->save();

        return redirect()
            ->route('order.cart')
            ->withSuccess(__('crud.cart.update_cart'));

    }

    public function checkout(Request $request){


        $request->validate([
            'first_name' => 'required',
            'email'     => 'required|email',
            'phone'     => 'required',
            'postal_code' => 'required',
            'city'      => 'required',
            'country'   => 'required',
            'address'   => 'required',   
            'shipping_id'   => 'required'         
        ]);

        $user = Auth::user();

        $cart = Cart::where('user_id', $user->id)->first();
        $shipping = Shipping::where('id', $request->shipping_id)->first();

        $totalPrice = 0;

        foreach($cart->cartItems as $item):
            $totalPrice += number_format((float)$item->quantity * $item->price, 2, '.', '');
        endforeach;

        $totalPrice = $totalPrice + $shipping->price;

        try{

            Stripe::setApiKey(env('STRIPE_SECRET'));

            $customer = Customer::create(array(
                "address" => [
                        "line1" => $request->address,
                        "postal_code" => $request->postal_code,
                        "city" => $request->city,
                        "country" => $request->country,
                    ],
                "email" => $request->email,
                "name" => $request->first_name . ' ' . $request->last_name,
                "source" => $request->stripeToken
             ));
            

            $orderDescription = $request->first_name . ' ' . isset($request->last_name) ? $request->last_name : '' . ' ' . ' Photos Order'; 

            $stripe_response = Charge::create([
                "amount" => $totalPrice * 100,
                "currency" => "usd",
                "customer" => $customer->id,
                "description" => $orderDescription 
            ]);
        } catch(Exception $err){
            dd($err);
        }

        

        $order = new Order();

        $order->first_name = $request->first_name;
        $order->last_name = $request->last_name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->postal_code = $request->postal_code;
        $order->city = $request->city;
        $order->country = $request->country;
        $order->address = $request->address;
        $order->total_price = $totalPrice;
        $order->payment_method = 'stripe';
        $order->response = json_encode($stripe_response);
        $order->has_billing = $request->isBilling ? $request->isBilling : 0;
        $order->billing_first_name = isset($request->billing_first_name) ? $request->billing_first_name : null;
        $order->billing_last_name = isset($request->billing_last_name) ? $request->billing_last_name : null;
        $order->billing_email = isset($request->billing_email) ? $request->billing_email : null;
        $order->billing_phone = isset($request->billing_phone) ? $request->billing_phone : null;
        $order->billing_postal_code = isset($request->billing_postal_code) ? $request->billing_postal_code : null;
        $order->billing_city = isset($request->billing_city) ? $request->billing_city : null;
        $order->billing_country = isset($request->billing_country) ? $request->billing_country : null;
        $order->billing_address = isset($request->billing_address) ? $request->billing_address : null;
        $order->user_id = $user->id;
        $order->shipping_id = $request->shipping_id;
        $order->shipping_price = $shipping->price;

        $order->save();

        foreach($cart->cartItems as $item):
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->photo_id = $item->photo_id;
            $orderItem->print_option = $item->print_option;
            $orderItem->quantity = $item->quantity;
            $orderItem->price = $item->price;
            $orderItem->save();
        endforeach;

        CartItem::where('cart_id', $cart->id)->delete();

        $cart->delete();

        Mail::to('ishraq@yopmail.com')->send(new OrderMail());
        Mail::to($request->email)->send(new OrderThankyouMail());
        

        return redirect()
            ->route('order.cart')
            ->withSuccess(__('crud.cart.payment_processed'));


    }

    public function index (Request $request): View {
        $this->authorize('view-any', Order::class);

        $orders = Order::get();

        return view('app.order.index', compact('orders'));
    }

    public function view($id){
        $order = Order::where('id', $id)->first();

        return view('app.order.view', compact('order'));
    }

}

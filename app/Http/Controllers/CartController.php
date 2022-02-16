<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use Session;
use DB;
use App\Item;
use App\Order;
use App\Receipt;


class CartController extends Controller
{
    // Shopping Cart View
    public function index()
    {
        // Return only the cart for the current session
        $userCart = DB::table('shopping_cart')
            ->where('shopping_cart.session_id', Session::get('session_id'))
            ->where('shopping_cart.ip_address', Session::get('ip_address'));
        // Return only the items in the session's cart
        $cartItems = DB::table('items')
            ->joinSub($userCart, 'shopping_cart', function ($join) {
                $join->on('items.id', '=', 'shopping_cart.item_id')
                ->whereNull('shopping_cart.deleted_at'); // Do not display soft-deleted items
            })->get();

        // Calculate subtotal of cart items
        $subtotal = 0.00;
        foreach($cartItems as $cartItem)
        {
            $subtotal += ($cartItem->quantity * $cartItem->price);
        }

        return view('cart.index')->with('cartItems', $cartItems)->with('subtotal', $subtotal);
    }

    // Add to Cart
    public function addToCart($id)
    {
        // Search shopping_cart table for matching cart (session & ip) already containing id of item passed in
        $result = Cart::where('shopping_cart.session_id', Session::get('session_id'))
            ->where('shopping_cart.ip_address', Session::get('ip_address'))
            ->where('shopping_cart.item_id', $id);

        // If result returned (item found in user's cart)
        if($result->first())
        {
            // Increase quantity of this item by 1
            $result->increment('shopping_cart.quantity', 1);
        }
        else
        {
            // Otherwise, add item to user's cart for first time (quantity = 1)
            $cart = new Cart;
            $cart->item_id = $id;
            $cart->session_id = Session::get('session_id');
            $cart->ip_address = Session::get('ip_address');
            $cart->quantity = 1;

            // Save to db
            $cart->save();
        }

        return redirect()->route('cart.index');
    }

    // Update Cart
    public function update_cart(Request $request, $id)
    {
        // Check item quantity in db
        $itemToCheck = Item::find($id);

        if($request->productQuantity > $itemToCheck->quantity)
        {
            Session::flash('error', "Only " . $itemToCheck->quantity . " of that product left in stock");
        }
        else
        {
            Cart::where('shopping_cart.session_id', Session::get('session_id'))
            ->where('shopping_cart.ip_address', Session::get('ip_address'))
            ->where('shopping_cart.item_id', $id)
            ->update(['shopping_cart.quantity' => $request->productQuantity]);

            Session::flash('success','Your cart has been updated');
        }
           
        return redirect()->route('cart.index');
    }

    // Remove Item from Cart
    public function remove_item($id)
    {
        $itemsToRemoveFromCart = Cart::where('shopping_cart.session_id', Session::get('session_id'))
            ->where('shopping_cart.ip_address', Session::get('ip_address'))
            ->where('shopping_cart.item_id', $id);

        $itemsToRemoveFromCart->delete();

        Session::flash('success','Item(s) successfully removed from cart ');

        return redirect()->route('cart.index');
    }

    // Process Order Form
    public function check_order(Request $request)
    {
        // Validate form data
        $this->validate($request, ['fName'=>'required|string|max:255',
                                   'lName'=>'required|string|max:255',
                                   'phone'=>'required|digits:11',
                                   'email'=>'required|email|max:255']); 
        
        // Create new Order object
        $order = new Order;
        // Save order form & session values to Order object attributes
        $order->fName = $request->fName;
        $order->lName = $request->lName;
        $order->phone = $request->phone;
        $order->email = $request->email;
        $order->session_id = Session::get('session_id');
        $order->ip_address = Session::get('ip_address');
        // Save object to db
        $order->save();

        // Retrieve the "order_id" (of current session's order)
        $orderID = DB::table('order_info')
            ->select('id as order_id', 'session_id', 'ip_address')
            ->where('session_id', '=', Session::get('session_id'))
            ->where('ip_address', '=', Session::get('ip_address'));
        // Join order_info table to shopping_cart table based on matching session variables
        $cart = DB::table('shopping_cart AS cart')
            ->select('order_id','cart.item_id', 'cart.quantity as cart_quantity', 'cart.session_id', 'cart.ip_address')
            ->joinSub($orderID, 'order', function ($join) {
                $join->on('cart.session_id', '=', 'order.session_id');
                $join->on('cart.ip_address', '=', 'order.ip_address');
            });
        // Join items table to shopping_cart table based on matching item ids
        $items = DB::table('items')
        ->select('items.id as item_id', 'items.price as item_price', 'items.title as item_name', 'order_id', 'cart_quantity', 'items.quantity as inventory')
        ->joinSub($cart, 'cart', function ($join) {
            $join->on('items.id', '=', 'cart.item_id');
        })->get();

        // Loop through each item in cart and save to items_sold table
        // $itemSold = new Receipt;

        foreach($items as $item)
        {
            $itemSold = new Receipt;
            $itemSold->item_id = $item->item_id;
            $itemSold->order_id = $item->order_id;
            $itemSold->price = $item->item_price;
            $itemSold->quantity = $item->cart_quantity;
            $itemSold->save();

            // Update item quantities in items table
            $item_to_update = Item::find($itemSold->item_id);
            $item_to_update->decrement('quantity', $itemSold->quantity);
        }

        // Redirect to thankyou pg
        return redirect()->route('cart.thankyou', $itemSold->order_id);
    }

    public function show($order_id)
    {
        $customer_info = Order::find($order_id);

        $items_ordered = Receipt::join('items', 'items_sold.item_id', '=', 'items.id')
            ->where('items_sold.order_id', $order_id)
            ->get(['items.title', 'items_sold.*']);
        
            $order_total = 0.00;
            foreach($items_ordered as $item)
            {
                $order_total += ($item->price * $item->quantity);
            }
        return view('cart.thankyou')->with('customer_info', $customer_info)->with('items_ordered', $items_ordered)->with('order_id', $order_id)->with('order_total', $order_total);
    }
}

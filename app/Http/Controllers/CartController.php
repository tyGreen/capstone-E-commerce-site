<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use Session;
use DB;
use App\Item;

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
        // return redirect()->route('cart.index')->with('cartItems', $cartItems);
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
}

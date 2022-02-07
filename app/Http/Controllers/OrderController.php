<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Receipt;
use App\Item;
use DB;

class OrderController extends Controller
{
    // Modify ORDER controller to be accessible only to authenticated users
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Display list of completed orders
    public function index()
    {
        $orders = Order::orderBy('id', 'DESC')->paginate(10);
        return view('orders.index')->with('orders', $orders);
    }

    // Display customer (order) receipt
    public function show($id)
    {
        $order_customer = Order::find($id);

        $items_sold = DB::table('items_sold')
            ->where('items_sold.order_id', '=', $id);
        // Join item/product name onto price, quantity, and item id from order_info table
        $item_details = DB::table('items')
            ->select('items.title as name', 'items_sold.item_id', 'items_sold.price', 'items_sold.quantity')
            ->joinSub($items_sold, 'items_sold', function ($join) {
                $join->on('items.id', '=', 'items_sold.item_id');
            })->get();

        // Calculate order total to pass to view
        $orderTotal = 0.00;
        foreach($item_details as $item_sold)
        {
            $orderTotal += ($item_sold->price * $item_sold->quantity);
        }

        return view('orders.details')->with('order_customer', $order_customer)->with('item_details', $item_details)->with('orderTotal', $orderTotal);
    }
}

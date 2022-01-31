<?php

// =====================================================================================================================
// Public controller for public store (product) pages
// =====================================================================================================================

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Item;
use App\Product;
use Session;

class ProductController extends Controller
{
    // Product List
    public function index()
    {
        $categories = Category::orderby('name', 'ASC')->get();
        $items = Item::orderBy('title', 'ASC')->paginate(10);

        return view('products.index')->with('categories',$categories)->with('items',$items);
    }

    // Show items by category
    public function show($id)
    {
        // Find item(s) whose id matches category id passed in
        $items = Item::where('category_id', $id)->paginate(10);
        $categories = Category::orderby('name', 'ASC')->get();

        return view('products.index')->with('categories',$categories)->with('items',$items);
    }

    // Product Details
    public function details($id)
    {
        // Find item whose id matches that passed in
        $item = Item::find($id);
        return view('products.details')->with('item',$item);
    }
}

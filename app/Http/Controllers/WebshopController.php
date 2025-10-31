<?php 
namespace App\Http\Controllers;

use App\Models\Product;

class WebshopController extends Controller
{
    public function list()
    {
        $products = Product::with(['category', 'tags'])->paginate(5);
        
        return view('webshop.list', compact('products'));
    }

    public function detail($id)
    {
        $product = Product::with(['category', 'tags'])->findOrFail($id);
        
        return view('webshop.detail', compact('product'));
    }
}
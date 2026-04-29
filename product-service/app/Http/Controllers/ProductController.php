<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json([
            'success' => true,
            'service' => 'ProductService',
            'data' => $products
        ]);
    }

    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }
        return response()->json(['success' => true, 'service' => 'ProductService', 'data' => $product]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
        ]);
        $product = Product::create($validated);
        return response()->json(['success' => true, 'message' => 'Product created', 'service' => 'ProductService', 'data' => $product], 201);
    }

    public function updateStock(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }
        $validated = $request->validate(['stock' => 'required|integer|min:0']);
        $product->update(['stock' => $validated['stock']]);
        return response()->json(['success' => true, 'message' => 'Stock updated', 'service' => 'ProductService', 'data' => $product]);
    }
}
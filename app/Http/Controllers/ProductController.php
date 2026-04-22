<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Display all products
    public function index()
    {
        $products = Product::orderBy('category')->orderBy('name')->get();

        // Calculate stats for the cards
        $totalProducts = $products->count();
        $inStockCount = $products->where('stock', '>', 10)->count();
        $lowStockCount = $products->where('stock', '>', 0)->where('stock', '<=', 10)->count();
        $outOfStockCount = $products->where('stock', '<=', 0)->count();

        return view('inventory.index', compact('products', 'totalProducts', 'inStockCount', 'lowStockCount', 'outOfStockCount'));
    }

    // Show form to add new product (not used anymore - modal handles it)
    public function create()
    {
        // Redirect to index since we use modal
        return redirect()->route('inventory.index');
    }

    // Store new product
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'stock_quantity' => 'required|integer|min:0',
                'category' => 'nullable|string|max:100',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
            ]);

            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('products', 'public');
            }

            $product = new Product();
            $product->name = $request->name;
            $product->price = $request->price;
            $product->stock = $request->stock_quantity;
            $product->category = $request->category;
            $product->description = $request->description;
            $product->image = $imagePath;
            $product->save();

            return response()->json(['success' => true, 'message' => 'Product added successfully!']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Show form to edit
    public function edit(Product $inventory)
    {
        // Redirect to index since we use modal
        return redirect()->route('inventory.index');
    }

    // Update product
    public function update(Request $request, Product $inventory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        // Handle image upload
        $imagePath = $inventory->image;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($inventory->image && Storage::disk('public')->exists($inventory->image)) {
                Storage::disk('public')->delete($inventory->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $inventory->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock_quantity,
            'category' => $request->category,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return response()->json(['success' => true, 'message' => 'Product updated successfully!']);
    }

    // Delete product
    public function destroy(Product $inventory)
    {
        try {
            // Delete image if exists
            if ($inventory->image && Storage::disk('public')->exists($inventory->image)) {
                Storage::disk('public')->delete($inventory->image);
            }

            $inventory->delete();

            return redirect()->route('inventory.index');
        } catch (\Exception $e) {
            return redirect()->route('inventory.index')->with('error', 'Failed to delete product');
        }
    }
}

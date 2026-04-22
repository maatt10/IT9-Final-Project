<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    // Display POS interface
    public function create()
    {
        $products = Product::where('stock', '>', 0)->orderBy('category')->get();
        return view('sales.create', compact('products'));
    }

    // Store sale transaction
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $totalAmount = 0;
            $saleItems = [];

            // Calculate total and prepare items
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);

                // Check if enough stock
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$product->name}");
                }

                $subtotal = $product->price * $item['quantity'];
                $totalAmount += $subtotal;

                $saleItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price_at_sale' => $product->price,
                ];

                // Reduce stock
                $product->decrement('stock', $item['quantity']);
            }

            // Create sale record
            $sale = Sale::create(['total_amount' => $totalAmount]);

            // Create sale items
            foreach ($saleItems as $item) {
                $item['sale_id'] = $sale->id;
                SaleItem::create($item);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sale completed successfully!',
                'sale_id' => $sale->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // Display all sales history
    public function index()
    {
        $sales = Sale::with('saleItems.product')->orderBy('created_at', 'desc')->get();

        // Calculate statistics
        $totalRevenue = $sales->sum('total_amount');
        $totalTransactions = $sales->count();
        $totalItemsSold = $sales->sum(function ($sale) {
            return $sale->saleItems->sum('quantity');
        });
        $avgOrderValue = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;

        return view('sales.index', compact('sales', 'totalRevenue', 'totalTransactions', 'totalItemsSold', 'avgOrderValue'));
    }

    // View single sale details
    public function show(Sale $sale)
    {
        $sale->load('saleItems.product');
        return view('sales.show', compact('sale'));
    }
}

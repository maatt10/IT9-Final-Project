<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Today's sales
        $todaySales = Sale::whereDate('created_at', today())->sum('total_amount');
        $todayTransactions = Sale::whereDate('created_at', today())->count();
        
        // This week's sales
        $weeklySales = Sale::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_amount');
        $weeklyTransactions = Sale::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        
        // Products stats
        $totalProducts = Product::count();
        $lowStockCount = Product::where('stock', '>', 0)->where('stock', '<=', 10)->count();
        $outOfStockCount = Product::where('stock', '<=', 0)->count();
        $totalItemsSold = Sale::with('saleItems')->get()->sum(function($sale) {
            return $sale->saleItems->sum('quantity');
        });
        
        // Low stock products list
        $lowStockProductsList = Product::where('stock', '>', 0)->where('stock', '<=', 10)->limit(5)->get();
        
        // Out of stock products list
        $outOfStockProductsList = Product::where('stock', '<=', 0)->limit(5)->get();
        
        // Top selling products
        $topProducts = DB::table('sale_items')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.name',
                DB::raw('SUM(sale_items.quantity) as total_sold'),
                DB::raw('SUM(sale_items.quantity * sale_items.price_at_sale) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->paginate(3, ['*'], 'top_page');
        
        // Recent sales with pagination
        $recentSales = Sale::with('saleItems')
            ->orderBy('created_at', 'desc')
            ->paginate(3, ['*'], 'sales_page');
        
        return view('dashboard.index', compact(
            'todaySales',
            'todayTransactions',
            'weeklySales',
            'weeklyTransactions',
            'totalProducts',
            'lowStockCount',
            'outOfStockCount',
            'totalItemsSold',
            'lowStockProductsList',
            'outOfStockProductsList',
            'topProducts',
            'recentSales'
        ));
    }
}
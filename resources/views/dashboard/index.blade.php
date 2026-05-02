@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Welcome Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-500 mt-1">Welcome back! Here's what's happening with your cafe today.</p>
    </div>

    <!-- Quick Action Buttons -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <a href="{{ route('sales.create') }}"
            class="group bg-gradient-to-r from-coral-500 to-coral-600 rounded-2xl p-4 sm:p-6 shadow-lg hover:shadow-xl transition-all hover:scale-[1.02]">
            <div class="flex items-center justify-between">
                <div>
                    <div class="bg-white/20 rounded-full w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center mb-2 sm:mb-3 group-hover:scale-110 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-white text-lg sm:text-xl font-bold">New Sale</h3>
                    <p class="text-coral-50 text-xs sm:text-sm mt-1">Start a new transaction</p>
                </div>
                <div class="text-white/50 group-hover:text-white/80 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
        </a>

        <a href="{{ route('inventory.create') }}"
            class="group bg-gradient-to-r from-teal-500 to-teal-600 rounded-2xl p-4 sm:p-6 shadow-lg hover:shadow-xl transition-all hover:scale-[1.02]">
            <div class="flex items-center justify-between">
                <div>
                    <div class="bg-white/20 rounded-full w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center mb-2 sm:mb-3 group-hover:scale-110 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <h3 class="text-white text-lg sm:text-xl font-bold">Add Product</h3>
                    <p class="text-teal-100 text-xs sm:text-sm mt-1">Add new item to inventory</p>
                </div>
                <div class="text-white/50 group-hover:text-white/80 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-8 sm:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
        </a>
    </div>

    <!-- Low Stock & Out of Stock Alert -->
    @if(($lowStockProductsList && $lowStockProductsList->count() > 0) || ($outOfStockProductsList && $outOfStockProductsList->count() > 0))
    <div class="bg-orange-50 border-l-4 border-orange-500 rounded-2xl p-4">
        <div class="flex items-start gap-3">
            <div class="bg-orange-100 rounded-full p-2 flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div class="flex-1">
                <h4 class="font-semibold text-orange-800">Inventory Alert</h4>
                @if($lowStockProductsList && $lowStockProductsList->count() > 0)
                <div>
                    <p class="text-sm text-gray-600 mb-2">The following products are running low on stock:</p>
                    <div class="space-y-1">
                        @foreach($lowStockProductsList as $product)
                        <div class="text-sm">
                            <span class="font-semibold text-orange-700">{{ $product->name }}</span>
                            <span class="text-red-500"> ({{ $product->stock }} left)</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            <a href="{{ route('inventory.index') }}" class="text-orange-600 hover:text-orange-700 text-sm font-medium whitespace-nowrap">Restock →</a>
        </div>
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Today's Sales -->
        <div class="bg-white rounded-2xl shadow-lg p-4">
            <div class="flex items-center justify-between">
                <div class="bg-coral-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-coral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-gray-500 text-sm">Today's Sales</p>
                    <p class="text-2xl font-bold text-gray-800">₱{{ number_format($todaySales, 2) }}</p>
                    <p class="text-xs text-green-600 mt-1">{{ $todayTransactions }} transaction(s)</p>
                </div>
            </div>
        </div>

        <!-- Weekly Sales -->
        <div class="bg-white rounded-2xl shadow-lg p-4">
            <div class="flex items-center justify-between">
                <div class="bg-teal-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-gray-500 text-sm">Weekly Sales</p>
                    <p class="text-2xl font-bold text-gray-800">₱{{ number_format($weeklySales, 2) }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $weeklyTransactions }} transactions</p>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="bg-white rounded-2xl shadow-lg p-4">
            <div class="flex items-center justify-between">
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-gray-500 text-sm">Total Products</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalProducts }}</p>
                    <p class="text-xs text-yellow-600 mt-1">{{ $lowStockCount }} low stock</p>
                </div>
            </div>
        </div>

        <!-- Items Sold -->
        <div class="bg-white rounded-2xl shadow-lg p-4">
            <div class="flex items-center justify-between">
                <div class="bg-teal-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6M17 13l1.5 6M9 21h6M12 15v6" />
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-gray-500 text-sm">Items Sold (Lifetime)</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalItemsSold ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Two Column Layout with Pagination -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Top Selling Products with Pagination -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">Top Selling Products</h2>
                <div class="bg-coral-100 rounded-full p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-coral-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>

            @if($topProducts->count() > 0)
            <div class="space-y-3">
                @foreach($topProducts as $index => $product)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-coral-100 text-coral-700 flex items-center justify-center font-bold text-sm">
                            {{ $index + 1 + (($topProducts->currentPage() - 1) * $topProducts->perPage()) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">{{ $product->name }}</p>
                            <p class="text-xs text-gray-500">{{ $product->total_sold }} units sold</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-gray-800">₱{{ number_format($product->total_revenue ?? 0, 2) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            <!-- Top Products Pagination -->
            <div class="mt-4 pt-4 border-t border-gray-100">
                {{ $topProducts->links() }}
            </div>
            @else
            <div class="text-center py-8 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <p>No sales data yet</p>
            </div>
            @endif
        </div>

        <!-- Recent Transactions with Pagination -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">Recent Transactions</h2>
                <a href="{{ route('sales.index') }}" class="text-sm text-coral-600 hover:text-coral-700">View all →</a>
            </div>

            @if($recentSales->count() > 0)
            <div class="space-y-3">
                @foreach($recentSales as $sale)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Sale #{{ $sale->id }}</p>
                            <p class="text-xs text-gray-500">{{ $sale->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-teal-600">₱{{ number_format($sale->total_amount, 2) }}</p>
                        <p class="text-xs text-gray-500">{{ $sale->saleItems->sum('quantity') }} items</p>
                    </div>
                </div>
                @endforeach
            </div>
            <!-- Recent Sales Pagination -->
            <div class="mt-4 pt-4 border-t border-gray-100">
                {{ $recentSales->links() }}
            </div>
            @else
            <div class="text-center py-8 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                <p>No transactions yet</p>
                <a href="{{ route('sales.create') }}" class="text-coral-600 text-sm mt-2 inline-block">Start your first sale →</a>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Pagination Styling */
    .pagination {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.25rem;
    }

    .pagination nav {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.25rem;
    }

    .pagination .page-link,
    .pagination span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 2rem;
        height: 2rem;
        padding: 0 0.5rem;
        font-size: 0.75rem;
        border-radius: 0.375rem;
        background-color: white;
        color: #4b5563;
        border: 1px solid #e5e7eb;
    }

    .pagination .active span {
        background-color: #f97316;
        color: white;
        border-color: #f97316;
    }

    .pagination .page-link:hover {
        background-color: #fff7ed;
        color: #f97316;
        border-color: #f97316;
    }

    @media (min-width: 640px) {

        .pagination .page-link,
        .pagination span {
            min-width: 2.5rem;
            height: 2.5rem;
            padding: 0 0.75rem;
            font-size: 0.875rem;
        }
    }
</style>
@endsection
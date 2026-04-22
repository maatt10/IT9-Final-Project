@extends('layouts.app')

@section('content')
<div class="space-y-6">
    
    <!-- Welcome Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-500 mt-1">Welcome back! Here's what's happening with your cafe today.</p>
    </div>

    <!-- Quick Action Buttons -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="{{ route('sales.create') }}" 
           class="group bg-gradient-to-r from-coral-500 to-coral-600 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all hover:scale-[1.02]">
            <div class="flex items-center justify-between">
                <div>
                    <div class="bg-white/20 rounded-full w-12 h-12 flex items-center justify-center mb-3 group-hover:scale-110 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-white text-xl font-bold">New Sale</h3>
                    <p class="text-coral-50 text-sm mt-1">Start a new transaction</p>
                </div>
                <div class="text-white/50 group-hover:text-white/80 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
        </a>

        <a href="{{ route('inventory.create') }}" 
           class="group bg-gradient-to-r from-teal-500 to-teal-600 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all hover:scale-[1.02]">
            <div class="flex items-center justify-between">
                <div>
                    <div class="bg-white/20 rounded-full w-12 h-12 flex items-center justify-center mb-3 group-hover:scale-110 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <h3 class="text-white text-xl font-bold">Add Product</h3>
                    <p class="text-teal-100 text-sm mt-1">Add new item to inventory</p>
                </div>
                <div class="text-white/50 group-hover:text-white/80 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Today's Sales Card -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-coral-100 rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-coral-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-full">Today</span>
            </div>
            <h3 class="text-gray-500 text-sm font-medium">Today's Sales</h3>
            <p class="text-2xl font-bold text-gray-800 mt-1">₱{{ number_format($todaySales, 2) }}</p>
            <p class="text-xs text-green-600 mt-2">+{{ $todayTransactions }} transaction(s)</p>
        </div>

        <!-- Total Sales Card (This Week) -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-teal-100 rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-full">This Week</span>
            </div>
            <h3 class="text-gray-500 text-sm font-medium">Weekly Sales</h3>
            <p class="text-2xl font-bold text-gray-800 mt-1">₱{{ number_format($weeklySales, 2) }}</p>
            <p class="text-xs text-gray-500 mt-2">{{ $weeklyTransactions }} transactions</p>
        </div>

        <!-- Total Products Card -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-green-100 rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-full">Inventory</span>
            </div>
            <h3 class="text-gray-500 text-sm font-medium">Total Products</h3>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalProducts }}</p>
            <p class="text-xs text-gray-500 mt-2">{{ $lowStockCount }} low stock</p>
        </div>

        <!-- Low Stock Alert Card -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-orange-100 rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-full">Needs Attention</span>
            </div>
            <h3 class="text-gray-500 text-sm font-medium">Low Stock Items</h3>
            <p class="text-2xl font-bold text-orange-600 mt-1">{{ $lowStockCount }}</p>
            <a href="{{ route('inventory.index') }}" class="text-xs text-coral-600 hover:text-coral-700 mt-2 inline-block">View inventory →</a>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Top Selling Products -->
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
                                <div class="w-8 h-8 rounded-full bg-coral-100 text-coral-700 flex items-center justify-center font-bold">
                                    {{ $index + 1 }}
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
            @else
                <div class="text-center py-8 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <p>No sales data yet</p>
                </div>
            @endif
        </div>

        <!-- Recent Sales / Transactions -->
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

    <!-- Low Stock Warning Section (if any) -->
    @if($lowStockProductsList && $lowStockProductsList->count() > 0)
    <div class="bg-orange-50 border-l-4 border-orange-500 rounded-2xl p-4">
        <div class="flex items-start gap-3">
            <div class="bg-orange-100 rounded-full p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div class="flex-1">
                <h4 class="font-semibold text-orange-800">Low Stock Alert</h4>
                <p class="text-sm text-orange-700">The following products are running low on stock:</p>
                <div class="flex flex-wrap gap-2 mt-2">
                    @foreach($lowStockProductsList as $product)
                        <span class="bg-white text-orange-700 text-xs px-2 py-1 rounded-full shadow-sm">
                            {{ $product->name }} ({{ $product->stock }} left)
                        </span>
                    @endforeach
                </div>
            </div>
            <a href="{{ route('inventory.index') }}" class="text-orange-600 hover:text-orange-700 text-sm font-medium">Restock →</a>
        </div>
    </div>
    @endif
</div>
@endsection
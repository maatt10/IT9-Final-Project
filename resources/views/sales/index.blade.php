@extends('layouts.app')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Sales History</h1>
        <p class="text-gray-500 mt-1">View and manage all your transactions</p>
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl shadow-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Sales</p>
                    <p class="text-2xl font-bold text-gray-800">₱{{ number_format($totalRevenue ?? 0, 2) }}</p>
                </div>
                <div class="bg-coral-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-coral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl shadow-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Transactions</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalTransactions ?? 0 }}</p>
                </div>
                <div class="bg-coral-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-coral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl shadow-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Items Sold</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalItemsSold ?? 0 }}</p>
                </div>
                <div class="bg-coral-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-coral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6M17 13l1.5 6M9 21h6M12 15v6" />
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl shadow-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Avg. Order Value</p>
                    <p class="text-2xl font-bold text-gray-800">₱{{ number_format($avgOrderValue ?? 0, 2) }}</p>
                </div>
                <div class="bg-coral-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-coral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Bar - Matching New Sale Page Style -->
    <div class="relative mb-6">
        <div class="absolute left-5 top-3 px-2 py-2 rounded-full bg-coral-500 text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <input type="text" 
               id="searchSale"
               class="bg-white rounded-3xl shadow text-lg w-full h-14 py-4 pl-16 transition-shadow focus:shadow-2xl focus:outline-none"
               placeholder="Search by Transaction ID..." />
    </div>

    <!-- Past Transactions Container -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <!-- Container Header -->
        <div class="border-b border-gray-200 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-coral-100 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-coral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Past Transactions</h2>
                        <p class="text-sm text-gray-500">View all your completed sales</p>
                    </div>
                </div>
                <div class="bg-gray-100 rounded-full px-4 py-2">
                    <span class="text-sm font-semibold text-gray-700">{{ $totalTransactions ?? 0 }}</span>
                    <span class="text-sm text-gray-500"> total transactions</span>
                </div>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="px-6 py-3 bg-gray-50 border-b border-gray-200 flex justify-end">
            <select id="filterMonth" class="px-4 py-2 rounded-xl border border-gray-200 focus:border-coral-500 focus:outline-none text-sm">
                <option value="all">All Time</option>
                <option value="today">Today</option>
                <option value="week">This Week</option>
                <option value="month">This Month</option>
            </select>
        </div>

        <!-- Transaction Cards List -->
        <div class="p-6 space-y-4 max-h-[500px] overflow-y-auto" id="salesList">
            @forelse($sales as $sale)
            <!-- Transaction Card -->
<div class="sale-card bg-teal-50 rounded-xl border border-coral-500 shadow-[0px_4px_4px_rgba(255,111,97,0.64)] overflow-hidden" data-id="{{ $sale->id }}" data-date="{{ $sale->created_at->format('Y-m-d') }}">
    
    <!-- Card Body -->
    <div class="p-5">
        <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-4">
            
            <!-- Left: Transaction ID -->
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 bg-white rounded-lg flex items-center justify-center shadow-sm">
                    <svg class="w-6 h-6 text-coral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v2M12 18v2M4 12H2M22 12h-2M19.07 4.93l-1.41 1.41M6.34 17.66l-1.41 1.41M17.66 6.34l1.41-1.41M6.34 6.34L4.93 4.93M8 12a4 4 0 108 0 4 4 0 00-8 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Transaction ID</p>
                    <p class="text-xl font-bold text-gray-800">#{{ $sale->id }}</p>
                </div>
            </div>

            <!-- Center: Total Amount - CENTERED -->
            <div class="text-center">
                <p class="text-xs text-gray-400">TOTAL AMOUNT</p>
                <p class="text-3xl font-bold text-teal-600">₱{{ number_format($sale->total_amount, 2) }}</p>
            </div>

            <!-- Right: Date, Time, Items -->
            <div class="flex items-center justify-end gap-3">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <div>
                        <p class="text-sm text-gray-700">{{ $sale->created_at->format('F d, Y') }}</p>
                        <p class="text-xs text-gray-400">{{ $sale->created_at->format('h:i A') }}</p>
                    </div>
                </div>
                <div class="w-px h-8 bg-gray-200"></div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6M17 13l1.5 6M9 21h6M12 15v6" />
                    </svg>
                    <div>
                        <p class="text-sm text-gray-700">{{ $sale->saleItems->sum('quantity') }} items</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Footer -->
    <a href="{{ route('sales.show', $sale)}}"
       class="block bg-coral-500 hover:bg-coral-600 transition py-3 text-center">
        <div class="flex items-center justify-center gap-2">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            <p class="text-white text-sm font-medium tracking-wide">VIEW RECEIPT & DETAILS</p>
            <span class="text-white text-xl font-bold">→</span>
        </div>
    </a>
</div>

            
            @empty
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p class="text-gray-500 text-lg">No transactions found</p>
                <a href="{{ route('sales.create') }}" class="text-coral-500 text-sm mt-2 inline-block">Start your first sale →</a>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
// Search by ID
document.getElementById('searchSale')?.addEventListener('keyup', function() {
    const searchValue = this.value.toLowerCase();
    const cards = document.querySelectorAll('.sale-card');
    
    cards.forEach(card => {
        const id = card.getAttribute('data-id');
        if (id.includes(searchValue)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
});

// Filter by date
document.getElementById('filterMonth')?.addEventListener('change', function() {
    const filter = this.value;
    const cards = document.querySelectorAll('.sale-card');
    const today = new Date();
    const todayStr = today.toDateString();
    const currentWeekStart = new Date(today);
    currentWeekStart.setDate(today.getDate() - today.getDay());
    const currentMonthStart = new Date(today.getFullYear(), today.getMonth(), 1);
    
    cards.forEach(card => {
        const saleDate = new Date(card.getAttribute('data-date'));
        
        if (filter === 'all') {
            card.style.display = '';
        } else if (filter === 'today') {
            card.style.display = saleDate.toDateString() === todayStr ? '' : 'none';
        } else if (filter === 'week') {
            card.style.display = saleDate >= currentWeekStart ? '' : 'none';
        } else if (filter === 'month') {
            card.style.display = saleDate >= currentMonthStart ? '' : 'none';
        }
    });
});
</script>
@endsection
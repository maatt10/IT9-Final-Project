@extends('layouts.app')

@section('content')
<div class="py-4 sm:py-8 px-3 sm:px-4">
    
    <!-- Back to Sales Button - Top Right aligned with receipt -->
    <div class="hide-print max-w-4xl mx-auto mb-4 flex justify-end">
        <a href="{{ route('sales.index') }}" class="inline-flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-xl shadow-lg transition text-sm sm:text-base">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Sales
        </a>
    </div>

    <!-- Receipt Card -->
    <div class="bg-white border border-gray-200 rounded-2xl shadow-xl max-w-4xl mx-auto w-full overflow-hidden print-area">

        <!-- Receipt Header -->
        <div class="pt-6 sm:pt-8 pb-3 sm:pb-4 px-4 sm:px-6 border-b border-dashed border-gray-200">
            <div class="text-center">
                <!-- Logo -->
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-20 h-20 sm:w-32 sm:h-32 object-contain mx-auto mb-2 sm:mb-3">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Cash'Here POS</h1>
                <div class="flex flex-wrap justify-center gap-1 mt-2 text-gray-500 text-xs sm:text-sm">
                    <span>Store #127</span>
                    <span>-</span>
                    <span>Manila Central</span>
                    <span>|</span>
                    <span>Terminal POS-03</span>
                </div>
            </div>
        </div>

        <!-- Transaction Info -->
        <div class="py-3 sm:py-4 px-4 sm:px-6 border-b border-dashed border-gray-200">
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-3 sm:space-y-4">
                    <div>
                        <p class="text-xs text-gray-400">Transaction ID</p>
                        <p class="font-semibold text-gray-800 text-sm sm:text-base">#{{ $sale->id }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Date</p>
                        <p class="font-semibold text-gray-800 text-sm sm:text-base">{{ $sale->created_at->format('F d, Y') }}</p>
                    </div>
                </div>
                <div class="space-y-3 sm:space-y-4 text-right">
                    <div>
                        <p class="text-xs text-gray-400">Cashier on Duty</p>
                        <p class="font-semibold text-gray-800 text-sm sm:text-base">{{ Auth::user()->name ?? 'Cashier' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Time</p>
                        <p class="font-semibold text-gray-800 text-sm sm:text-base">{{ $sale->created_at->format('h:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Purchased - Responsive with proper image sizing -->
        <div class="py-3 sm:py-4 px-4 sm:px-6 border-b border-dashed border-gray-200">
            <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Items Purchased</h2>
            <div class="space-y-3">
                @foreach($sale->saleItems as $item)
                <div class="flex flex-col sm:flex-row sm:items-center gap-3 p-3 bg-gray-50 rounded-xl">
                    <!-- Product Image - Responsive -->
                    <div class="flex-shrink-0 flex justify-center sm:justify-start">
                        <div class="w-16 h-16 sm:w-14 sm:h-14 rounded-xl bg-gray-200 flex items-center justify-center overflow-hidden">
                            @if($item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            @else
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            @endif
                        </div>
                    </div>

                    <!-- Product Details - Responsive text -->
                    <div class="flex-1 text-center sm:text-left">
                        <p class="font-semibold text-gray-800 text-sm sm:text-base">{{ $item->product->name }}</p>
                        <p class="text-xs text-gray-400">SKU: {{ strtoupper(substr($item->product->name, 0, 3)) }}-{{ $item->product_id }}</p>
                    </div>

                    <!-- Quantity & Price - Responsive layout -->
                    <div class="flex sm:flex-col justify-between sm:text-right items-center sm:items-end gap-2 sm:gap-0">
                        <p class="text-xs text-gray-400">Qty. <span class="font-medium text-gray-600">{{ $item->quantity }}</span></p>
                        <p class="font-bold text-gray-800 text-sm sm:text-base">₱{{ number_format($item->price_at_sale * $item->quantity, 2) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Tax Summary -->
        <div class="py-3 sm:py-4 px-4 sm:px-6 border-b border-dashed border-gray-200">
            <div class="flex justify-end">
                <div class="w-full sm:w-64 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600 text-sm">Subtotal</span>
                        <span class="font-semibold text-sm">₱{{ number_format($sale->total_amount / 1.12, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 text-sm">VAT (12%)</span>
                        <span class="font-semibold text-sm">₱{{ number_format($sale->total_amount - ($sale->total_amount / 1.12), 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Amount -->
        <div class="py-3 sm:py-4 px-4 sm:px-6 border-b border-dashed border-gray-200 bg-gray-50">
            <div class="flex justify-end">
                <div class="w-full sm:w-64">
                    <div class="flex justify-between items-center">
                        <span class="text-base sm:text-lg font-bold text-gray-800">Total Amount</span>
                        <span class="text-xl sm:text-2xl font-bold text-teal-600">₱{{ number_format($sale->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="py-4 sm:py-6 px-4 sm:px-6 text-center">
            <p class="text-base sm:text-lg font-semibold text-gray-600">Thank you! Come Again!</p>
            <p class="text-xs text-gray-400 mt-2">
                Store #127 · Terminal POS-03 · Cashier: {{ Auth::user()->name ?? 'Cashier' }}
            </p>
            <p class="text-xs text-gray-400 mt-1">
                Generated: {{ now()->format('F d, Y · h:i:s A') }}
            </p>
        </div>

        <!-- Print Receipt Button - Bottom of receipt (inside printable area, hidden when printing) -->
        <div class="hide-print py-4 px-4 sm:px-6 border-t border-gray-200 bg-white">
            <button onclick="window.print()" class="w-full bg-coral-500 hover:bg-coral-600 text-white font-semibold py-3 rounded-xl transition flex items-center justify-center gap-2 shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Print Receipt
            </button>
        </div>
    </div>
</div>

<style>
    @media print {
        .hide-print {
            display: none !important;
        }

        .print-area {
            margin: 0;
            padding: 0;
            box-shadow: none !important;
        }

        body {
            background: white;
            padding: 0;
            margin: 0;
        }

        .shadow-xl {
            box-shadow: none !important;
        }

        .bg-gray-50 {
            background-color: white !important;
        }
        
        .rounded-2xl {
            border-radius: 0 !important;
        }
        
        .border {
            border: none !important;
        }
    }
</style>
@endsection
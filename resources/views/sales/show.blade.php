@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center py-8 px-4">

    <!-- Receipt Card -->
    <div class="bg-white border border-gray-200 rounded-2xl shadow-xl max-w-4xl w-full overflow-hidden print-area">

        <!-- Receipt Header -->
        <div class="pt-8 pb-4 px-6 border-b border-dashed border-gray-200">
            <div class="text-center">
                <!-- Logo -->
                <!-- Logo -->
<img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-32 h-32 object-contain mx-auto mb-3">
                <h1 class="text-3xl font-bold text-gray-800">Cash'Here POS</h1>
                <div class="flex flex-wrap justify-center gap-1 mt-2 text-gray-500 text-sm">
                    <span>Store #127</span>
                    <span>-</span>
                    <span>Manila Central</span>
                    <span>|</span>
                    <span>Terminal POS-03</span>
                </div>
            </div>
        </div>

        <!-- Transaction Info -->
        <div class="py-4 px-6 border-b border-dashed border-gray-200">
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-400">Transaction ID</p>
                        <p class="font-semibold text-gray-800">#{{ $sale->id }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Date</p>
                        <p class="font-semibold text-gray-800">{{ $sale->created_at->format('F d, Y') }}</p>
                    </div>
                </div>
                <div class="space-y-4 text-right">
                    <div>
                        <p class="text-xs text-gray-400">Cashier on Duty</p>
                        <p class="font-semibold text-gray-800">{{ Auth::user()->name ?? 'Cashier' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Time</p>
                        <p class="font-semibold text-gray-800">{{ $sale->created_at->format('h:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Purchased -->
        <div class="py-4 px-6 border-b border-dashed border-gray-200">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Items Purchased</h2>
            <div class="space-y-3">
                @foreach($sale->saleItems as $item)
                <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl">
                    <!-- Product Image -->
                    <div class="w-16 h-16 rounded-xl bg-gray-200 flex items-center justify-center overflow-hidden flex-shrink-0">
                        @if($item->product->image)
                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                        @else
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        @endif
                    </div>

                    <!-- Product Details -->
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800">{{ $item->product->name }}</p>
                        <p class="text-xs text-gray-400">SKU: {{ strtoupper(substr($item->product->name, 0, 3)) }}-{{ $item->product_id }}</p>
                    </div>

                    <!-- Quantity & Price -->
                    <div class="text-right">
                        <p class="text-xs text-gray-400">Qty. {{ $item->quantity }}</p>
                        <p class="font-bold text-gray-800">₱{{ number_format($item->price_at_sale * $item->quantity, 2) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Tax Summary -->
        <div class="py-4 px-6 border-b border-dashed border-gray-200">
            <div class="flex justify-end">
                <div class="w-64 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold">₱{{ number_format($sale->total_amount / 1.12, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">VAT (12%)</span>
                        <span class="font-semibold">₱{{ number_format($sale->total_amount - ($sale->total_amount / 1.12), 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Amount -->
        <div class="py-4 px-6 border-b border-dashed border-gray-200 bg-gray-50">
            <div class="flex justify-end">
                <div class="w-64">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-gray-800">Total Amount</span>
                        <span class="text-2xl font-bold text-teal-600">₱{{ number_format($sale->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="py-6 px-6 text-center">
            <p class="text-lg font-semibold text-gray-600">Thank you! Come Again!</p>
            <p class="text-xs text-gray-400 mt-2">
                Store #127 · Terminal POS-03 · Cashier: {{ Auth::user()->name ?? 'Cashier' }}
            </p>
            <p class="text-xs text-gray-400 mt-1">
                Generated: {{ now()->format('F d, Y · h:i:s A') }}
            </p>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="hide-print fixed bottom-8 right-8 flex gap-3">
        <button onclick="window.print()" class="bg-coral-500 hover:bg-coral-600 text-white px-6 py-3 rounded-xl shadow-lg transition flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Print Receipt
        </button>

        <a href="{{ route('sales.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl shadow-lg transition flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Sales
        </a>
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
    }
</style>
@endsection
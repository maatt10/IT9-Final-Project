@extends('layouts.app')

@section('content')
<div class="flex flex-col h-full">
    <div class="flex gap-6">

        <!-- Products Grid (Left Side) -->
        <div class="flex-1">
            <!-- Search Bar -->
            <div class="relative mb-4">
                <div class="absolute left-5 top-3 px-2 py-2 rounded-full bg-coral-500 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input
                    type="text"
                    id="searchProduct"
                    class="bg-white rounded-3xl shadow text-lg w-full h-14 py-4 pl-16 transition-shadow focus:shadow-2xl focus:outline-none"
                    placeholder="Search menu..." />
            </div>

            <!-- Products Grid -->
            <div class="h-full overflow-y-auto" style="max-height: calc(100vh - 140px);">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 pb-3">
                    @foreach($products as $product)
                    <div
                        role="button"
                        onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, {{ $product->stock }}, '{{ asset('storage/' . $product->image) }}')"
                        class="product-card select-none cursor-pointer transition-all overflow-hidden rounded-2xl bg-white shadow hover:shadow-lg hover:scale-105">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-32 object-cover">
                        <div class="p-3">
                            <h5 class="font-semibold text-gray-800 truncate">{{ $product->name }}</h5>
                            <p class="text-coral-600 font-bold mt-1">₱{{ number_format($product->price, 2) }}</p>
                            <p class="text-xs text-gray-400 mt-1">Stock: {{ $product->stock }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Shopping Cart (Right Sidebar) -->
        <div class="w-96 flex-shrink-0">
            <div class="bg-white rounded-3xl shadow-lg flex flex-col h-full" style="max-height: calc(100vh - 32px);">

                <!-- Cart Header -->
                <div class="p-4 border-b">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-coral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <h2 class="text-lg font-semibold">Current Order</h2>
                            <span id="cartCount" class="bg-coral-500 text-white text-xs rounded-full px-2 py-0.5">0</span>
                        </div>
                        <button onclick="clearCart()" class="text-gray-400 hover:text-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Cart Items -->
                <div id="cartItems" class="flex-1 overflow-y-auto p-4 space-y-2">
                    <div class="text-center text-gray-400 py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p>Cart is empty</p>
                    </div>
                </div>

                <!-- Cart Footer / Payment -->
                <div class="p-4 border-t">
                    <div class="space-y-2 mb-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Subtotal (before VAT)</span>
                            <span id="cartSubtotal" class="text-gray-700">₱0.00</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">VAT (12%)</span>
                            <span id="cartTax" class="text-gray-700">₱0.00</span>
                        </div>
                        <div class="flex justify-between text-lg font-semibold pt-2 border-t">
                            <span>Total (VAT inclusive)</span>
                            <span id="cartTotal" class="text-coral-600">₱0.00</span>
                        </div>
                    </div>

                    <button
                        onclick="processSale()"
                        id="submitBtn"
                        class="w-full bg-coral-500 hover:bg-coral-600 text-white font-semibold py-3 rounded-2xl transition disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                        Complete Sale
                    </button>
                </div>

                <script>
                    let cart = [];

                    function addToCart(id, name, price, stock, image) {
                        const existingItem = cart.find(item => item.id === id);

                        if (existingItem) {
                            if (existingItem.quantity + 1 > stock) {
                                alert('Insufficient stock!');
                                return;
                            }
                            existingItem.quantity++;
                        } else {
                            if (1 > stock) {
                                alert('Insufficient stock!');
                                return;
                            }
                            cart.push({
                                id,
                                name,
                                price, // This price already INCLUDES 12% VAT
                                quantity: 1,
                                image
                            });
                        }

                        updateCartDisplay();
                    }

                    function updateCartDisplay() {
                        const cartContainer = document.getElementById('cartItems');
                        const subtotalElement = document.getElementById('cartSubtotal');
                        const taxElement = document.getElementById('cartTax');
                        const totalElement = document.getElementById('cartTotal');
                        const cartCountElement = document.getElementById('cartCount');
                        const submitBtn = document.getElementById('submitBtn');

                        if (cart.length === 0) {
                            cartContainer.innerHTML = `
                <div class="text-center text-gray-400 py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <p>Cart is empty</p>
                </div>
            `;
                            subtotalElement.innerText = '₱0.00';
                            taxElement.innerText = '₱0.00';
                            totalElement.innerText = '₱0.00';
                            cartCountElement.innerText = '0';
                            submitBtn.disabled = true;
                            return;
                        }

                        let totalWithVAT = 0;
                        let itemCount = 0;
                        cartContainer.innerHTML = '';

                        cart.forEach((item, index) => {
                            const itemTotal = item.price * item.quantity; // This already includes VAT
                            totalWithVAT += itemTotal;
                            itemCount += item.quantity;

                            cartContainer.innerHTML += `
                <div class="flex gap-3 bg-blue-gray-50 rounded-xl p-3">
                    <img src="${item.image}" class="w-12 h-12 rounded-lg object-cover">
                    <div class="flex-1">
                        <h5 class="font-semibold text-sm">${item.name}</h5>
                        <div class="flex justify-between items-center mt-1">
                            <p class="text-gray-600 text-xs semi-bold">₱${item.price.toFixed(2)}</p>
                            <p class="text-xs text-gray-500">x${item.quantity}</p>
                        </div>
                        <p class="text-xs font-bold text-coral-500 mt-1">₱${itemTotal.toFixed(2)}</p>
                    </div>
                    <div class="flex flex-col items-center gap-1">
                        <button onclick="updateQuantity(${index}, 1)" class="bg-gray-200 hover:bg-gray-300 w-6 h-6 rounded-lg text-xs font-bold">+</button>
                        <span class="text-sm font-semibold">${item.quantity}</span>
                        <button onclick="updateQuantity(${index}, -1)" class="bg-gray-200 hover:bg-gray-300 w-6 h-6 rounded-lg text-xs font-bold">-</button>
                    </div>
                </div>
            `;
                        });

                        // Calculate VAT (12% of the total with VAT? No - extract VAT from inclusive price)
                        // Formula: VAT = TotalWithVAT - (TotalWithVAT / 1.12)
                        const vatAmount = totalWithVAT - (totalWithVAT / 1.12);
                        const subtotal = totalWithVAT - vatAmount;

                        subtotalElement.innerText = `₱${subtotal.toFixed(2)}`;
                        taxElement.innerText = `₱${vatAmount.toFixed(2)}`;
                        totalElement.innerText = `₱${totalWithVAT.toFixed(2)}`;
                        cartCountElement.innerText = itemCount;
                        submitBtn.disabled = false;
                    }

                    function updateQuantity(index, change) {
                        const item = cart[index];
                        const newQty = item.quantity + change;

                        if (newQty < 1) {
                            cart.splice(index, 1);
                        } else {
                            item.quantity = newQty;
                        }

                        updateCartDisplay();
                    }

                    function clearCart() {
                        if (confirm('Clear entire cart?')) {
                            cart = [];
                            updateCartDisplay();
                        }
                    }

                    function processSale() {
                        if (cart.length === 0) {
                            alert('Cart is empty!');
                            return;
                        }

                        const items = cart.map(item => ({
                            product_id: item.id,
                            quantity: item.quantity
                        }));

                        fetch('{{ route("sales.store") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    items: items
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Sale completed successfully!');
                                    cart = [];
                                    updateCartDisplay();
                                    location.reload();
                                } else {
                                    alert('Error: ' + data.message);
                                }
                            })
                            .catch(error => {
                                alert('Error processing sale');
                            });
                    }

                    // Search functionality
                    document.getElementById('searchProduct')?.addEventListener('keyup', function() {
                        const searchValue = this.value.toLowerCase();
                        const cards = document.querySelectorAll('.product-card');

                        cards.forEach(card => {
                            const name = card.querySelector('h5').innerText.toLowerCase();
                            if (name.includes(searchValue)) {
                                card.style.display = '';
                            } else {
                                card.style.display = 'none';
                            }
                        });
                    });
                </script>
                @endsection
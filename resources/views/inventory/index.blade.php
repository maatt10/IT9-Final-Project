@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">
    
    <!-- Welcome Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Inventory</h1>
        <p class="text-gray-500 mt-1">Manage your products and stock levels</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-lg p-5 border-l-4 border-coral-500">
            <p class="text-gray-500 text-sm">Total Products</p>
            <p class="text-2xl font-bold text-gray-900">{{ $totalProducts ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-5 border-l-4 border-teal-500">
            <p class="text-gray-500 text-sm">In Stock</p>
            <p class="text-2xl font-bold text-teal-600">{{ $inStockCount ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-5 border-l-4 border-yellow-500">
            <p class="text-gray-500 text-sm">Low Stock</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $lowStockCount ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-5 border-l-4 border-red-500">
            <p class="text-gray-500 text-sm">Out of Stock</p>
            <p class="text-2xl font-bold text-red-600">{{ $outOfStockCount ?? 0 }}</p>
        </div>
    </div>

    <!-- Search Bar & Add Product Button -->
    <div class="flex gap-4 mb-6">
        <div class="flex-1 relative">
            <div class="absolute left-5 top-3 px-2 py-2 rounded-full bg-coral-500 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text"
                id="searchInput"
                class="bg-white rounded-3xl shadow text-lg w-full h-14 py-4 pl-16 transition-shadow focus:shadow-2xl focus:outline-none"
                placeholder="Search by name, category, or ID..." />
        </div>
        <button onclick="openAddModal()" class="bg-coral-500 hover:bg-coral-600 text-white px-6 py-3 rounded-xl transition flex items-center gap-2 shadow-md whitespace-nowrap">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Product
        </button>
    </div>

    @if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
        {{ session('error') }}
    </div>
    @endif

    <!-- Products Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody id="productTableBody" class="bg-white divide-y divide-gray-200">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-10 h-10 object-cover rounded-lg">
                            @else
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $product->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->category ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->stock ?? 0 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-teal-600">₱{{ number_format($product->price, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                            $stock = $product->stock ?? 0;
                            if($stock > 10) {
                                $badge = 'bg-teal-100 text-teal-700';
                                $status = 'In Stock';
                            } elseif($stock > 0) {
                                $badge = 'bg-yellow-100 text-yellow-700';
                                $status = 'Low Stock';
                            } else {
                                $badge = 'bg-red-100 text-red-700';
                                $status = 'Out of Stock';
                            }
                            @endphp
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $badge }}">{{ $status }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick='openEditModal({{ $product->id }}, "{{ addslashes($product->name) }}", "{{ $product->category }}", {{ $product->price }}, {{ $product->stock }}, "{{ addslashes($product->description) }}", "{{ $product->image }}")' class="text-teal-600 hover:text-teal-800 mr-3 inline-flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </button>
                            <button type="button" onclick="confirmDelete({{ $product->id }}, '{{ addslashes($product->name) }}')" class="text-red-600 hover:text-red-800 inline-flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete
                            </button>
                            <form id="delete-form-{{ $product->id }}" action="{{ route('inventory.destroy', $product->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <p>No products found. Click "Add Product" to get started.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Product Modal -->
<div id="addProductModal" class="modal-overlay">
    <div class="modal-container">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Add New Product</h2>
                <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="addProductForm" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Product Name *</label>
                        <input type="text" name="name" id="add_name" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-coral-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Category</label>
                        <select name="category" id="add_category" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-coral-500">
                            <option value="">Select Category</option>
                            <option value="Coffee">Coffee</option>
                            <option value="Pastry">Pastry</option>
                            <option value="Beverage">Beverage</option>
                            <option value="Food">Food</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Price *</label>
                            <input type="number" step="0.01" name="price" id="add_price" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-coral-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Stock *</label>
                            <input type="number" name="stock_quantity" id="add_stock" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-coral-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Description</label>
                        <textarea name="description" id="add_description" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-coral-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Product Image</label>
                        <input type="file" name="image" id="add_image" accept="image/*" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        <p class="text-gray-500 text-sm mt-1">Max 2MB. JPG, PNG, GIF</p>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" onclick="closeAddModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-coral-500 hover:bg-coral-600 text-white rounded-lg transition">Save Product</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div id="editProductModal" class="modal-overlay">
    <div class="modal-container">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Edit Product</h2>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="editProductForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="product_id" id="edit_product_id">
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Product Name *</label>
                        <input type="text" name="name" id="edit_name" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-coral-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Category</label>
                        <select name="category" id="edit_category" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-coral-500">
                            <option value="">Select Category</option>
                            <option value="Coffee">Coffee</option>
                            <option value="Pastry">Pastry</option>
                            <option value="Beverage">Beverage</option>
                            <option value="Food">Food</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Price *</label>
                            <input type="number" step="0.01" name="price" id="edit_price" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-coral-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Stock *</label>
                            <input type="number" name="stock_quantity" id="edit_stock" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-coral-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Description</label>
                        <textarea name="description" id="edit_description" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-coral-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Current Image</label>
                        <div id="edit_current_image"></div>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">New Image</label>
                        <input type="file" name="image" accept="image/*" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-coral-500 hover:bg-coral-600 text-white rounded-lg transition">Update Product</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Confirm Delete Modal -->
<div id="deleteModal" class="modal-overlay">
    <div class="modal-container max-w-md">
        <div class="p-6 text-center">
            <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Confirm Delete</h3>
            <p class="text-gray-500 mb-6" id="deleteMessage">Are you sure you want to delete this product?</p>
            <div class="flex justify-center gap-3">
                <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition">Cancel</button>
                <button onclick="submitDelete()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Add Product Modal
    function openAddModal() {
        document.getElementById('addProductModal').classList.add('active');
        document.body.classList.add('modal-open');
    }

    function closeAddModal() {
        document.getElementById('addProductModal').classList.remove('active');
        document.body.classList.remove('modal-open');
        document.getElementById('addProductForm').reset();
    }

    // Edit Product Modal
    function openEditModal(id, name, category, price, stock, description, image) {
        document.getElementById('edit_product_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_category').value = category || '';
        document.getElementById('edit_price').value = price;
        document.getElementById('edit_stock').value = stock;
        document.getElementById('edit_description').value = description || '';

        if (image) {
            document.getElementById('edit_current_image').innerHTML = '<img src="/storage/' + image + '" class="w-20 h-20 object-cover rounded">';
        } else {
            document.getElementById('edit_current_image').innerHTML = '<p class="text-gray-500">No image</p>';
        }

        document.getElementById('editProductModal').classList.add('active');
        document.body.classList.add('modal-open');
    }

    function closeEditModal() {
        document.getElementById('editProductModal').classList.remove('active');
        document.body.classList.remove('modal-open');
    }

    // Delete Modal
    let deleteId = null;

    function confirmDelete(id, name) {
        deleteId = id;
        document.getElementById('deleteMessage').innerHTML = 'Are you sure you want to delete <strong>' + name + '</strong>? This action cannot be undone.';
        document.getElementById('deleteModal').classList.add('active');
        document.body.classList.add('modal-open');
    }

    function closeDeleteModal() {
        deleteId = null;
        document.getElementById('deleteModal').classList.remove('active');
        document.body.classList.remove('modal-open');
    }

    function submitDelete() {
        if (deleteId) {
            document.getElementById('delete-form-' + deleteId).submit();
        }
    }

    // Add Product
    document.getElementById('addProductForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        try {
            const response = await fetch('{{ route("inventory.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                closeAddModal();
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'Something went wrong'));
            }
        } catch (error) {
            alert('Error adding product');
        }
    });

    // Edit Product
    document.getElementById('editProductForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();

        const id = document.getElementById('edit_product_id').value;
        const formData = new FormData(this);

        try {
            const response = await fetch('/inventory/' + id, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                closeEditModal();
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'Something went wrong'));
            }
        } catch (error) {
            alert('Error updating product');
        }
    });

    // Search functionality
    document.getElementById('searchInput')?.addEventListener('keyup', function() {
        let searchTerm = this.value.toLowerCase();
        let rows = document.querySelectorAll('#productTableBody tr');

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endsection
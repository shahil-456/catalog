@extends('user.layouts.app')

@section('title', 'Dashboard')

@section('content')





<div class="flex flex-col gap-6">
            <h4 class="card-title">Catalogs & Products</h4>

<div class="card">
    <div class="card-header">
        <div class="flex justify-end">
    <a href="{{route('reports')}}">
        <button class="bg-primary text-white px-4 py-2 rounded">
            Sales Report
        </button>
    </a>
</div>
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">

            <div class="grid lg:grid-cols-2 gap-6 w-30">
                    
            
            <div class="max-w-3xl mx-auto p-6">
            <div class="flex gap-4 items-center">
                <div class="w-1/2">
                    <label for="catalog" class="block mb-2 text-sm font-medium text-gray-700">Select Catalog</label>
                    <select id="catalog" 
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">-- Choose Catalog --</option>
                        @foreach ($catalogs as $catalog)
                            <option value="{{ $catalog->id }}">{{ $catalog->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-1/2">
                    <label for="product" class="block mb-2 text-sm font-medium text-gray-700">Select Product</label>
                    <select id="product" 
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">-- Choose Product --</option>
                    </select>
                </div>
            </div>

            <div id="products" class="mt-6 space-y-2 w-full"></div>
        </div>

            

            </div>
                
                
            </div>
        </div>
    </div>

</div>
</div>
       
















<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script>
    $(document).ready(function() {
        $('#catalog').on('change', function() {
            var catalogId = $(this).val();

            if (catalogId) {
                $.ajax({
                    url: "{{ route('catalog.products', ':id') }}".replace(':id', catalogId),
                    type: 'GET',
                    success: function(response) {
                        let productsDiv = $('#products');
                        productsDiv.empty();

                        if (response.products.length === 0) {
                            productsDiv.append('<p class="text-gray-500">No products found.</p>');
                        } else {
                            let productSelect = $('#product');
                            productSelect.empty().append('<option value="">-- Choose Product --</option>');

                            response.products.forEach(function(product) {
                                productSelect.append(`<option value="${product.id}">${product.name}</option>`);
                            });


                            response.products.forEach(function(product) {
                               productsDiv.append(
                                `<div class="p-3 border rounded-lg shadow-sm bg-white flex justify-between items-center">
                                    <div>
                                        <strong>${product.name}</strong> - $${product.price}
                                    </div>
                                    <div class="space-x-2">
                                        <a href="{{ url('store-sale') }}/${product.id}">
                                            <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">
                                                Sale
                                            </button>
                                        </a>
                                        <a href="{{ url('delete-product') }}/${product.id}">
                                            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                                Delete
                                            </button>
                                        </a>
                                    </div>
                                </div>`
                            );

                            });
                        }
                    },
                    error: function(xhr) {
                        alert('Error fetching products');
                    }
                });
            } else {
                $('#products').empty();
            }
        });
    });
</script>
            

@endsection

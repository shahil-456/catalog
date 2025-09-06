@extends('user.layouts.app')

@section('title', 'Dashboard')

@section('content')


 
               <div class="flex flex-col gap-6">

                  <div class="card">
                        <div class="card-header">
                            <div class="flex justify-between items-center">
                                <h4 class="card-title">sales</h4>
                                <div class="flex items-center gap-2">
                                  
                                </div>
                            </div>
                        </div>
                        <div>
                            
                            <div class="overflow-x-auto">
                                <div class="min-w-full inline-block align-middle">
                                    <div class="py-3 px-4">
                                            <div class="relative max-w-xs">
                                                
                                                
                                            </div>
                                        </div>
                                    <div class="overflow-hidden">
                                        
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                            <thead>
                                                <tr>

                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>

                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product Name</th>
                                                    
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catalog</th>

                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               @foreach ($sales as $key => $sale)

                                                <tr id="productRow{{ $sale->id }}" class="odd:bg-white even:bg-gray-100 dark:odd:bg-slate-700 dark:even:bg-slate-800">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{$key+1}}</td>

                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{$sale->product->name}}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"> {{$sale->product->catalog->name}}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"> {{$sale->product->price}}</td>

                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">
                                                    {{ $sale->product->deleted_at ? 'Deleted Product' : 'Active' }}
                                                </td>



                                                </tr>

                                                @endforeach



                                            </tbody>

                                        </table>
                                    </div>




                                
                                    </div>
                                </div>


                           
                        </div>
                    </div> <!-- end card -->

            </div>  

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   
            

@endsection

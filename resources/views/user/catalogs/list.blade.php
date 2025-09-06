@foreach ($products as $key => $product)


<tr id="productRow{{ $product->id }}" class="odd:bg-white even:bg-gray-100 dark:odd:bg-slate-700 dark:even:bg-slate-800">
<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{$key+1}}</td>

<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{$product->name}}</td>
<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"> {{$product->category->name}}</td>
<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"> {{$product->price}}</td>
<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"> {{$product->stock}}</td>

<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"> 
    <img src="{{ asset($product->image) }}" width="150" alt="User Photo">

</td>

<td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">

<div class="flex space-x-3">
  <a href="{{ route('admin.product.view', [$product->id]) }}"><i data-feather="eye" class="text-green-600 w-4"></i></a>
  <a href="{{ route('admin.product.edit', [$product->id]) }}"><i data-feather="edit-2" class="text-blue-600 w-4"></i></a>
    <a href="javascript:void(0);" class="link-danger fs-15 deleteProduct" data-id="{{ $product->id }}"> <i data-feather="trash-2" class="text-red-600 w-4"></i></a>
</div>

</td>
</tr>

@endforeach








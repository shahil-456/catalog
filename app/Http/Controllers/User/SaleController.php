<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Repositories\ProductRepositoryInterface;

class SaleController extends Controller
{


    public function store(Request $request,$id)
    {
        $product=Product::findOrFail($id);

        $user = Sale::create([
            'product_id'      => $id,
            'product_name'      => $product->name,

        ]);

        return redirect()->back()->with('success', 'Sale Create Success!');
         
    }

     public function report()
    {
        $sales = Sale::all();
        return view('user.catalogs.report', compact('sales'));
    }



  
}

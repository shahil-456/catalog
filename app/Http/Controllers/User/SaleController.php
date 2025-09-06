<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

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

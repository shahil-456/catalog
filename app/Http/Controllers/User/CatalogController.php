<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Catalog;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Repositories\ProductRepositoryInterface;

class CatalogController extends Controller
{

    public function index(Request $request)    
    {
        $catalogs = Catalog::all();
        return view('user.catalogs.index', compact('catalogs'));
    }


    public function getProducts(Request $request, $catalogId)
    {
        $products = Product::where('catalog_id', $catalogId)->get();

        return response()->json([
            'success' => true,
            'products' => $products,
        ]);
    }










    


    // public function search(Request $request)
    //     {
    //         $query = Product::query();

    //         if ($request->has('search') && !empty($request->search)) {
    //             $searchTerm = $request->search;
    //             $query->where('name', 'LIKE', "%{$searchTerm}%");
    //         }

    //         $products = $query->get(); 

    //         if ($request->ajax()) {
    //             return response()->json([
    //                 'success' => true,
    //                 'products' => $products
    //             ]);
    //         }
    //     }



  
}

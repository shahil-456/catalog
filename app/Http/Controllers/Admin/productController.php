<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Notification;
use App\Models\Category;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use App\Models\Order;
use App\Events\OrderStatusNotification;
use App\Exports\TestProductsExport;


class ProductController extends Controller
{
    public function index(Request $request)
    {

    
        $query = Product::query();
        $categories = Category::all();


        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('name', 'LIKE', "%{$searchTerm}%");
                
        }
        $products = $query->paginate(10);
        if ($request->ajax()) {
            return view('admin.products.list', compact('products'))->render();
        }
        return view('admin.products.index', compact('products','categories'));
    }

    public function create()
    {
        $categories = Category::all();

        $roles = Role::all();
        return view('admin.products.add', compact('roles','categories'));
    }

    public function store(Request $request)
    {

            
        try {

            $validated = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|numeric|min:1',
            'category_id' => 'required',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            ]);


            if ($validated->fails()) {
                return response()->json([
                    'errors' => $validated->errors(),
                ], 422);
            } else {


                $imageName = 'products/test_product.png';
                
                if ($request->hasFile('image')) {
                $image      = $request->file('image');
                $imageName  = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('products'), $imageName); 
                $imageName = 'products/'.$imageName; 
                }

                $product = Product::create([
                    'name'        => $request->input('name'),
                    'price'       => $request->input('price'),
                    'stock'       => $request->input('stock'),
                    'category_id' => $request->input('category_id'),
                    'type'        => $request->input('type'),
                    'image'       => $imageName,
                ]);


                return response()->json(['success' => true, 'message' => 'Product added successfully']);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error Adding Product: ', ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the Product. Please try again later.',
            ], 500);
        }
    }

    public function profile()
    {
        return view('admin.products.profile');
    }
    public function edit($id)
    {
        $categories = Category::all();
        $product = Product::findOrFail($id);
        $roles = Role::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }


    public function update(Request $request, $id)
    {
                 
        
        try {
            $product = Product::findOrFail($id);

            
            $validated = Validator::make($request->all(), [
               'name'        => 'required|string|max:255|unique:products,name,' . $product->id,
                'price'       => 'required|numeric|min:0',
                'stock'       => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,id',
                'description'    => 'nullable',
                'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:3048',       

            ]);


            if ($validated->fails()) {
                return response()->json([
                    'errors' => $validated->errors(),
                ], 422);
            }

            $imageName = null;

            if ($request->hasFile('image')) {
                $image      = $request->file('image');
                $imageName  = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('products'), $imageName); 
                $imageName = 'products/'.$imageName; 
            }


            $product->update([
                'name'        => $request->input('name'),
                'price'       => $request->input('price'),
                'category_id' => $request->input('category_id'),
                'description' => $request->input('description'),
                'type'        => 'test',
                'stock'       => $request->input('stock'),
                'image'       => $imageName ?? $product->image,
               
            ]);


            return response()->json(['success' => true, 'message' => 'Product Updated successfully']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error Adding Product: ', ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the Product. Please try again later.',
            ], 500);
        }

        // Find the lead

    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.view', compact('product'));
    }



    public function destroy($id)
    {
        // return 1;
        try {
            if (Product::findOrFail($id)->delete()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product deleted successfully!',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Product could not be deleted. Please try again later.',
                ], 500);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error deleting Laed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again later.',
            ], 500);
        }
    }



     public function import()
    {
        return view('admin.products.import');

    }


        public function importSubmit(Request $request)
    {

        try {
            $request->validate([
                'products_excel' => 'required|file|mimes:xlsx,xls,csv|max:102400',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        }

        Excel::queueImport(new ProductsImport, $request->file('products_excel')); 

        $rowCount = Excel::toCollection(null, $request->file('products_excel'))->first()->count();

        if ($rowCount > 10000) {
            return back()->withErrors(['products_excel' => 'File cannot have more than 10,000 rows.']);
        }

        // die;

        return redirect()->back()->with('success', 'Products Imported successfully!');
                 
       
    }

    public function allOrders(Request $request)
    {

        $orders = Order::query()->paginate(10);    
        return view('admin.products.orders', compact('orders'));
    }


    public function orderDetails($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.products.order-details', compact('order'));
    }

    
    public function updateOrderStatus(Request $request, $id)
    {
                 
        try {
            $order = Order::findOrFail($id);

            $validated = Validator::make($request->all(), [
               'status'        => 'required|string',
                       
            ]);

            if ($validated->fails()) {
                return response()->json([
                    'errors' => $validated->errors(),
                ], 422);
            }

            $order->update([
                
                'status'      => $request->input('status'),       
               
            ]);

            $data = [
                    'message' => 'Your Order Status is '.$request->input('status'),
                    'user' => $order->user_id,
                    'order_id' => $order->id,
                    'status' => $request->input('status'),
                    'type' => 'status-notify',
                    'time' => now(),
                ];

            $notify = Notification::create([
            'type'        =>'status-notify',
            'user_id'       => $order->user_id,
            'message'       =>'Your Order Status is '.$request->input('status'),
            'status'      => 1,
            ]);


            event(new OrderStatusNotification($data, $type = 'status-notify', $to=$order->user_id));

            return response()->json(['success' => true, 'message' => 'Order Status Updated successfully']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error Adding Product: ', ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the Product. Please try again later.',
            ], 500);
        }


    }

  

    public function downloadExcel()
    {
        return Excel::download(new TestProductsExport, 'products_sample_import.csv');
    }



   


}

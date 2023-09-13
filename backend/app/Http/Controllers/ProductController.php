<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductStoreRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        return response()->json([
            'products' => $products
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        //
        try{
            $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();

            // Create Product
            Product::create([
                'name' => $request->name,
                'image'=> $imageName,
                'description' => $request->description,

            ]);

            //Save Image IN Storage Folder
            Storage::disk('public')->put($imageName, file_get_contents($request->image));

            return response()->json([
                'message'=>"Product Successfully Create"
            ]);


        }catch(\Exception $e){
            return response()->json([
                'message'=> 'Something went wrong'
            ], 500);

        }
    }

    
      


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $product = Product::find($id);
        if(!$product){
            return response()->json([
                'message'=>"Product not found!"
            ], 404);
        }

        return response()->json([
            'product' => $product
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductStoreRequest $request, string $id)
    {
        //
        try {
            $product = Product::find($id);
            if(!$product){
                return response()->json([
                    'message'=> 'Product Not Found!'
                ],400);
            };
            
            $product->name = $request->name;
            $product->description = $request->description;


            if($request->image){

                //public Storage
                $storage = Storage::disk('public');

                //Old image delete

                if( $storage->exists($product->image))
                    $storage->delete($product->image);
                //Image name
                $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();
                $product->image = $imageName;

                //image save in public folder

                $storage->put($imageName, file_get_contents($request->image));

            };
            //Update Product
            $product->save();


            return response() -> json([
                'message'=> 'Product Update Successfully'
            ], 200);
        } catch (\Exception $e){
            return response()->json([
                'message'=> 'Update Went Wrong!'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //Detail
        $product = Product::find($id);
        if(!$product) {
            return response()->json([
                'message'=>'Product not found!!'
            ], 404);
        }
    }
}

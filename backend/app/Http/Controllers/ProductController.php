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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

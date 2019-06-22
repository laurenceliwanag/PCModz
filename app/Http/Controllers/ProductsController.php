<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Products;
use App\Http\Resources\Products as ProductsResource;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get Products
        $products = Products::orderBy('id', 'asc')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->select('products.*', 'categories.name AS category')
        ->get();

        //Return Collection of Products
        return ProductsResource::collection($products);
    }

    public function active()
    {
        //Get Products
        $products = Products::orderBy('id', 'asc')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->select('products.*', 'categories.name AS category')
        ->where('status', '1')
        ->get();

        //Return Collection of Products
        return ProductsResource::collection($products);
    }

    public function critical_products()
    {
        //Get Products
        $products = Products::orderBy('id', 'asc')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->select('products.*', 'categories.name AS category')
        ->whereRaw('stock <= critical')
        ->get();

        //Return Collection of Products
        return ProductsResource::collection($products);
    }

    public function featured()
    {
        //Get Products
        $products = Products::orderBy('id', 'asc')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->select('products.*', 'categories.name AS category')
        ->where('featured', '1')
        ->where('status', '1')
        ->get();

        //Return Collection of Products
        return ProductsResource::collection($products);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = $request->isMethod('put') ? Products::findOrFail($request->product_id) : new Products;  

        if($request->isMethod('put')){

        }
        else{
            $request->validate([
                'name' => 'required|unique:products|max:255',
            ]);
        }

        if($request->hasFile('image')){
            $fileNameWithExtension = $request->file('image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            $path = $request->file('image')->storeAs('public/img/products', $fileNameToStore);
        }
        else if($request->input('image') != ""){
            $fileNameToStore = $request->input('image');
        }
        else{
            $fileNameToStore = 'noimage.jpg';
        }

        $product->id = $request->input('product_id');
        $product->image = $fileNameToStore;
        $product->name = $request->input('name');
        $product->description = $request->input('desc');
        $product->category_id = $request->input('category_id');
        $product->srp = $request->input('srp');
        $product->critical = $request->input('critical');
        $product->status = $request->input('status');
        $product->featured = $request->input('featured');

        if($product->save()){
            return new ProductsResource($product);
        }
    }

    public function receive(Request $request)
    {
        $product = Products::findOrFail($request->product_id); 

        $product->id = $request->input('product_id');
        $product->stock = $request->input('stock') + $request->input('receive_quantity');

        if($product->save()){
            return new ProductsResource($product);
        }
    }
    
    public function remove(Request $request)
    {
        $product = Products::findOrFail($request->product_id); 

        $product->id = $request->input('product_id');
        $product->stock = $request->input('stock') - $request->input('order_quantity');

        if($product->save()){
            return new ProductsResource($product);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Get Single Products
        $product = Products::join('categories', 'products.category_id', '=', 'categories.id')
        ->select('products.*', 'categories.name AS category')
        ->where('products.id', $id)
        ->get();
        
        //Return Single Products as a Resource
        return ProductsResource::collection($product);
    }


    public function filter($id)
    {
        //Get Products
        $products = Products::orderBy('id', 'asc')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->select('products.*', 'categories.name AS category')
        ->where('category_id', $id)
        ->where('status', '1')
        ->get();

        //Return Collection of Products
        return ProductsResource::collection($products);
    }

    public function search_product($value){
          //Get Products
          $products = Products::orderBy('id', 'asc')
          ->join('categories', 'products.category_id', '=', 'categories.id')
          ->select('products.*', 'categories.name AS category')
          ->where('products.name', 'like', '%' . $value . '%')
          ->where('status', '1')
          ->get();
  
          //Return Collection of Products
          return ProductsResource::collection($products);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Get Products
        $product = Products::findOrFail($id);

        if($product->delete()){
            return new ProductsResource($product);
        }
    }
}

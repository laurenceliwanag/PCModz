<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Orders;
use App\Http\Resources\Orders as OrdersResource;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         //Get Order
         $orders = Orders::orderBy('created_at', 'desc')
         ->join('users', 'orders.user_id', '=', 'users.id')
         ->join('products', 'orders.product_id', '=', 'products.id')
         ->select('orders.*', 'users.name AS user_name', 'products.name AS product_name')
         ->groupBy('invoice')
         ->get();
 
         //Return Collection of Orders
         return OrdersResource::collection($orders);
    }

    public function last_invoice()
    {
         //Get Order
         $order = Orders::find(Orders::max('id'));
 
         //Return Collection of Orders
         return new OrdersResource($order);
    }

    public function pending()
    {
         //Get Order
         $orders = Orders::orderBy('created_at', 'desc')
         ->join('users', 'orders.user_id', '=', 'users.id')
         ->join('products', 'orders.product_id', '=', 'products.id')
         ->select('orders.*', 'users.name AS user_name', 'products.name AS product_name')
         ->groupBy('invoice')
         ->where('orders.status', 0)
         ->get();
 
         //Return Collection of Orders
         return OrdersResource::collection($orders);
    }

    public function approved()
    {
         //Get Order
         $orders = Orders::orderBy('created_at', 'desc')
         ->join('users', 'orders.user_id', '=', 'users.id')
         ->join('products', 'orders.product_id', '=', 'products.id')
         ->select('orders.*', 'users.name AS user_name', 'products.name AS product_name')
         ->groupBy('invoice')
         ->where('orders.status', 1)
         ->get();
 
         //Return Collection of Orders
         return OrdersResource::collection($orders);
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
        $order = new Orders; 

        $order->invoice = $request->input('invoice');
        $order->user_id = $request->input('user_id');
        $order->product_id = $request->input('product_id');
        $order->incharge_id = $request->input('incharge_id');
        $order->order_quantity = $request->input('order_quantity');
        $order->total = $request->input('total');
        $order->status = $request->input('status');

        if($order->save()){
            return new OrdersResource($order);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($invoice)
    {
         //Get Single Orders
         $orders = Orders::orderBy('product_id', 'asc')
         ->join('users', 'orders.user_id', '=', 'users.id')
         ->join('products', 'orders.product_id', '=', 'products.id')
         ->select('orders.*', 'users.name AS user_name', 'products.name AS product_name')
         ->where('invoice', $invoice)
         ->get();

         //Return Single Orders as a Resource
         return OrdersResource::collection($orders);
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
        //
    }
}

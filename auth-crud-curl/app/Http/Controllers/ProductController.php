<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = product::paginate(10);
        return ProductResource::collection($product);
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

        $request->validate([
            'title' => 'required',
            'amount'=>'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        $path = $request->file('image')->store('public/images');

        $product = new Product();
        $product->title = $request->title;
        $product->amount = $request ->amount;
        $user = User::findOrFail(auth()->user()->id);
        $product -> user_id = $user->id;
        $product->user_data = $user;
        $product ->image=$path;
        echo $product;
        if($product->save())
        {
            return new ProductResource($product);
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
        $product = Product::findOrFail($id);
        return new ProductResource($product);
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
        $product = Product::findOrFail($id);
        $product->title = $request->title;
        $product->amount = $request ->amount;
        $product -> user_id = $request ->user_id;

        if($product->save())
        {
            return new ProductResource($product);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if($product->delete())
        {
            return new ProductResource($product);
        }
    }
}

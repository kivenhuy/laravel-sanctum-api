<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Store;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::all();
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
            'name' => 'required',
            'slug' => 'required',
            'price' => 'required',
            'id_store' => 'required'
        ]);
        $id_store = $request->id_store;
        $check =  Store::find($id_store);
        if($check ==  null)
        {
            $response = [
                'message' => "ID Store Not Exists",
            ];
            return response($response, 404);
        }
        // print_r($id_store);
        return Product::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $check =  Product::find($id);
        if($check ==  null)
        {
            $response = [
                'message' => "Product Not Found",
            ];
            return response($response, 404);
        }
        else
        {
            return Product::find($id);
        }
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
        $product = Product::find($id);
        if($product == null)
        {
            $response = [
                'message' => "Product Not Found",
            ];
            return response($response, 404);
        }
        $product->update($request->all());
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if($product == null)
        {
            $response = [
                'message' => "Product Not Found",
            ];
            return response($response, 404);
        }
        
        $check =  Product::destroy($id);
        if($check)
        {
            $response = [
                'message' => "Delete Product Successfully",
            ];
            return response($response, 200);
        }
        else
        {
            $response = [
                'message' => "Delete Product Failed",
            ];
            return response($response, 400);
        }
    }

     /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        $check = Product::where('name', 'like', '%'.$name.'%')->get();
        if(count($check) ==  0)
        {
            $response = [
                'message' => "Product Not Found",
            ];
            return response($response, 404);
        }
        else
        {
            return Product::where('name', 'like', '%'.$name.'%')->get();
        }
    }

    public function searchbystore($id)
    {
        $check =  Store::find($id);
        if($check ==  null)
        {
            $response = [
                'message' => "ID Store Not Exists",
            ];
            return response($response, 404);
        }
        if(!empty($pagination))
        {
            return Product::where('id_store', 'like', '%'.$id.'%')->paginate(10);
        }
        
    }
}
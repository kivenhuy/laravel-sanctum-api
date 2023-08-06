<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
            return "Record not found";
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
        $check =  Product::destroy($id);
        if($check)
        {
            return "Delete Product Successfully";
        }
        else
        {
            return "Delete Product  Failed";
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
            return "Record not found";
        }
        else
        {
            return Product::where('name', 'like', '%'.$name.'%')->get();
        }
    }

    public function searchbystore(Request $request)
    {
        $id_store = $request->header('id_store');
        $pagination = $request->header('pagination');
        if(!empty($pagination))
        {
            return Product::where('id_store', 'like', '%'.$id_store.'%')->paginate($pagination);
        }
        else
        {
            return Product::where('id_store', 'like', '%'.$id_store.'%')->get();
        }
        
    }
}
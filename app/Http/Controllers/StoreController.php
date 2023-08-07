<?php

namespace App\Http\Controllers;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Store::all();
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
            'user_id' => 'required'
        ]);
        $id_users = $request->id_users;
        $check =  User::find($id_users);
        if($check ==  null)
        {
            $response = [
                'message' => "ID Users Not Exist",
            ];
            return response($response, 404);
        }
        return Store::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $check =  Store::find($id);
        if($check ==  null)
        {
            $response = [
                'message' => "Store Not Found",
            ];
            return response($response, 404);
        }
        else
        {
            return Store::find($id);
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
        $Store = Store::find($id);
        if($Store == null)
        {
            $response = [
                'message' => "Store Not Found",
            ];
            return response($response, 404);
        }
        $Store->update($request->all());
        return $Store;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Store = Store::find($id);
        if($Store == null)
        {
            $response = [
                'message' => "Store Not Found",
            ];
            return response($response, 404);
        }
        $check =  Store::destroy($id);
        if($check)
        {
            $response = [
                'message' => "Delete Store Successfully",
            ];
            return response($response, 200);
        }
        else
        {
            $response = [
                'message' => "Delete Store Failed",
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
        $check = Store::where('name', 'like', '%'.$name.'%')->get();
        if(count($check) ==  0)
        {
            $response = [
                'message' => "Store Not Found",
            ];
            return response($response, 404);
        }
        else
        {
            return Store::where('name', 'like', '%'.$name.'%')->get();
        }
        
    }

    public function searchbyusers($id)
    {
        $check =  User::find($id);
        if($check ==  null)
        {
            $response = [
                'message' => "ID Users Not Exist",
            ];
            return response($response, 404);
        }
        else
        {
            $check =  User::find($id)->getStore()->paginate(10);
            return $check;
        }
    }
}

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
            'id_users' => 'required'
        ]);

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
            return "Record not found";
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
            return "Record not found";
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
            return "Record not found";
        }
        $check =  Store::destroy($id);
        if($check)
        {
            return "Delete Store Successfully";
        }
        else
        {
            return "Delete Store Failed";
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
            return "Record not found";
        }
        else
        {
            return Store::where('name', 'like', '%'.$name.'%')->get();
        }
        
    }

    public function searchbyusers(Request $request)
    {
        $id_users = $request->header('id_users');
        $check =  User::find($id_users);
        if($check ==  null)
        {
            return "ID Users not exists try again";
        }
        $pagination = $request->header('pagination');
        if(!empty($pagination))
        {
            return Store::where('id_users', 'like', '%'.$id_users.'%')->paginate($pagination);
        }
        else
        {
            return Store::where('id_users', 'like', '%'.$id_users.'%')->get();
        }
    }
}

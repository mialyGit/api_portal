<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Type_user;
use Illuminate\Http\Request;

class TypeUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type_users = Type_user::all();
        return $type_users;
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
        return Type_user::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type_user  $type_user
     * @return \Illuminate\Http\Response
     */
    public function show(Type_user $type_user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Type_user  $type_user
     * @return \Illuminate\Http\Response
     */
    public function edit(Type_user $type_user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Type_user  $type_user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type_user $type_user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type_user  $type_user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type_user $type_user)
    {
        $response = ['message' => 'Toute est bien supprimée'];

        return response($response, 201);
        //
    }

    public function destroy_all()
    {
        Type_user::truncate();
        
        $response = ['message' => 'Toute est bien supprimée'];

        return response($response, 201);
    }
}

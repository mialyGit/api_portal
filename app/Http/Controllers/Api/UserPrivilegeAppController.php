<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserPrivilegeApp;
use Illuminate\Http\Request;

class UserPrivilegeAppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $fields = $request->validate([
            'user_id' => 'required | int | exists:users,id',
            'application_id' => 'required | int | exists:applications,id',
            'privilege_id' => 'required | int | exists:privileges,id',
        ]);

        $userPrivilegeApp = UserPrivilegeApp::create([
            'user_id' => $fields['user_id'],
            'application_id' =>  $fields['application_id'],
            'privilege_id' =>  $fields['privilege_id'],
        ]);

        return response($userPrivilegeApp, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserPrivilegeApp  $userPrivilegeApp
     * @return \Illuminate\Http\Response
     */
    public function show(UserPrivilegeApp $userPrivilegeApp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserPrivilegeApp  $userPrivilegeApp
     * @return \Illuminate\Http\Response
     */
    public function edit(UserPrivilegeApp $userPrivilegeApp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserPrivilegeApp  $userPrivilegeApp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserPrivilegeApp $userPrivilegeApp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserPrivilegeApp  $userPrivilegeApp
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserPrivilegeApp $userPrivilegeApp)
    {
        //
    }

    public function destroy_all()
    {
        UserPrivilegeApp::truncate();
        
        $response = ['message' => 'Toute est bien supprimée'];

        return response($response, 201);
    }
}

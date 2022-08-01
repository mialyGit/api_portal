<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
// use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        // return UserResource::collection($users);
        return $users;
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $fields = $request->validate([
            'nom' => 'required | string',
            'prenom' => 'nullable | string',
            'cin' => 'nullable | string',
            'telephone' => 'nullable | string',
            'photo' => 'nullable | string',
            'email' => 'required | string | unique:users,email',
            'password' => 'required | string | confirmed',
            'adresse' => 'nullable | string',
            'type_user_id' => 'required | int | exists:type_users,id',
        ]);

        $user = User::create([
            'nom' => $fields['nom'],
            'prenom' =>  $fields['prenom'],
            'cin' =>  $fields['cin'],
            'telephone' =>  $fields['telephone'],
            'photo' =>  $fields['photo'],
            'email' =>  $fields['email'],
            'password' =>  bcrypt($fields['password']),
            'remember_token' =>  Str::random(10),
            'adresse' => $fields['adresse'],
            'type_user_id' => $fields['type_user_id'],
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];
        
        return response($response, 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required | string ',
            'password' => 'required | string '
        ]);

        $user = User::where('email', $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                'message' => 'Email ou mot de passe incorrect',
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];
        
        return response($response, 201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Déconnectée'
        ];
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
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function destroy_all()
    {
        User::truncate();
        
        $response = ['message' => 'Toute est bien supprimée'];

        return response($response, 201);
    }
}

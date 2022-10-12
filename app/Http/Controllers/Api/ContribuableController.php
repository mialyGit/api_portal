<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Contribuable;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\UserController;

class ContribuableController extends Controller
{
    protected $userController;
    protected $data;

    public function __construct(UserController $userController)
    {
        $this->userController = $userController;
        $this->data = User::with('contribuable')->has('contribuable');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->data->get();
        //return Contribuable::all();
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
        $user = $this->userController->store($request);

        $fields = $request->validate([
            'nif' => 'required | string',
            'raison_sociale' => 'nullable | string',
            's_matrim' => 'nullable | int',
            'activite' => 'nullable | string',
            'type_contr' => 'nullable | int',
            'localisation' => 'nullable | string'
        ]);

        $fields['user_id'] = $user->id;
        $contribuable = Contribuable::create($fields);

        // $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'user' => $this->data->where('users.id', '=', $user->id)->first()
        ];

        return response($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contribuable  $contribuable
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->data->where('users.id', '=', $id)->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contribuable  $contribuable
     * @return \Illuminate\Http\Response
     */
    public function edit(Contribuable $contribuable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contribuable  $contribuable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contribuable $contribuable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contribuable  $contribuable
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contribuable $contribuable)
    {
        $contribuable->delete();
        return $this->userController->destroy($contribuable->user_id);
    }
}

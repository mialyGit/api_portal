<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Personnel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\UserController;

class PersonnelController extends Controller
{
    protected $userController;
    protected $data;

    public function __construct(UserController $userController)
    {
        $this->userController = $userController;
        /*$this->data =  User::join('personnels', 'personnels.user_id', '=', 'users.id')
        ->join('fonctions', 'fonctions.id', '=', 'personnels.fonction_id')
        ->join('services', 'services.id', '=', 'fonctions.service_id')
        ->join('grades', 'grades.id', '=', 'personnels.grade_id');*/
        $this->data = User::with('personnel','personnel.fonction','personnel.fonction.service','personnel.grade')->has('personnel')->orderBy('created_at', 'DESC');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        //return Personnel::all(); 
        return $this->data->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'num_matricule' => 'required | string',
            'fonction_id' => 'required | int | exists:fonctions,id',
            'grade_id' => 'required | int | exists:grades,id'
        ], $this->messages());

        $fields['user_id'] = $user->id;
        $personnel = Personnel::create($fields);

        // $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'user' => $this->data->where('users.id', '=', $user->id)->first()
        ];

        return response($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Personnel  $personnel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->data->where('users.id', '=', $id)->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Personnel  $personnel
     * @return \Illuminate\Http\Response
     */
    public function edit(Personnel $personnel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Personnel  $personnel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Personnel $personnel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Personnel  $personnel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Personnel $personnel)
    {
        $personnel->delete();
        return $this->userController->destroy($personnel->user_id);
    }

    private function messages()
    {
        return 
        [   
            'num_matricule.required'    => 'Veuillez entrer le numero matricule de l\'utilisateur',
            'fonction_id.required'      => 'Veuillez entrer le fonction de l\'utilisateur',
            'grade_id.required'      => 'Veuillez entrer le grade de l\'utilisateur',
            'fonction_id.exists'      => 'le fonction est introuvable',
            'grade_id.exists'      => 'le grade est introuvable',
        ];
    }
}

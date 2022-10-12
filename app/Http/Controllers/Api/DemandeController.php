<?php

namespace App\Http\Controllers\Api;

use App\Models\Demande;
use App\Models\Personnel;
use App\Models\Contribuable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Demande::with('user')->get();
    }

    public function demande_pers(Request $request)
    {
        $personnel = Personnel::where('num_matricule', $request->num_matricule)->first();
        if($personnel != null){
            $demande = Demande::where('user_id', $personnel->user_id)->first();
            if(!$demande){
                return Demande::create([
                    'user_id' => $personnel->user_id,
                ]);
            } else {
                return response([
                    'message' => 'Demande déjà envoyé',
                ], 200);
            }
        } else {
            return response([
                'message' => 'Numéro matricule invalide!',
            ], 401);
        }
    }

    public function demande_cont(Request $request)
    {
        $contribuable = Contribuable::where('nif', $request->nif)->first();
        if($contribuable != null){
            $demande = Demande::where('user_id', $contribuable->user_id)->first();
            if(!$demande){
                return Demande::create([
                    'user_id' => $contribuable->user_id,
                ]);
            } else {
                return response([
                    'message' => 'Demande déjà envoyé',
                ], 409);
            }
        } else {
            return response([
                'message' => 'NIF invalide!',
            ], 401);
        }
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
        return Demande::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function show(Demande $demande)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function edit(Demande $demande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Demande $demande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Demande $demande)
    {
        //
    }

    public function destroy_all()
    {
        Demande::truncate();
        
        $response = ['message' => 'Toute est bien supprimée'];

        return response($response, 201);
    }
}

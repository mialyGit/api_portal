<?php

namespace App\Http\Controllers\Api;

use App\Models\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applications = Application::all();
        return $applications;
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
            'code_app' => 'required | string | unique:applications,code_app',
            'nom_app' => 'required | string ',
            'desc_app' => 'nullable | string ',
            'abrev_app' => 'nullable | string ',
            'lien_app' => 'required | string ',
            'file' => ' nullable | image | mimes:jpeg,jpg,png,PNG | max:2048'
        ]);

        $fields['logo_app'] = "logo/default-logo.png";

        if($file = $request->file('file')){
            // $name = $file->getClientOriginalName();
            $ext = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $name = strtolower($fields['nom_app'].'_'.$fields['code_app']).'.'. $ext;
            $path = $request->file('file')->storeAs('logo', $name, 'public');
            $fields['logo_app'] = $path;
        }

        unset($fields['file']);

        $app = Application::create($fields);

        return response($app, 201);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {
        $fields = $request->validate([
            'code_app' => 'required | string | unique:applications,code_app,' . $application->id,
            'nom_app' => 'required | string ',
            'desc_app' => 'nullable | string ',
            'abrev_app' => 'nullable | string ',
            'logo_app' => 'nullable | string',
            'lien_app' => 'required | string ',
            'file' => ' nullable | image | mimes:jpeg,jpg,png,PNG | max:2048'
        ]);

        // $fields['logo_app'] = "default-logo.png";

        if($file = $request->file('file')){
            // $name = $file->getClientOriginalName();
            $ext = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $name = strtolower($fields['nom_app'].'_'.$fields['code_app']).'.'. $ext;
            if($fields['logo_app'] !=    'logo/'.$name){
                $imagePath = public_path("storage/" . $fields['logo_app']);
                if(File::exists($imagePath)) {
                    File::delete($imagePath);
                }
                $path = $request->file('file')->storeAs('logo', $name, 'public');
                $fields['logo_app'] = $path;
            }
        }

        unset($fields['file']);

        $app = $application->update($fields);

        return response($app, 201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        if($application->logo_app != "logo/default-logo.png"){
            $imagePath = public_path("storage/" . $application->logo_app);
            if(File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        $application->delete();
        $response = ['message' => 'Application supprimée de la base de données'];
        return response($response,201);
    }

    public function destroy_all()
    {
        Application::truncate();
        
        $response = ['message' => 'Toute est bien supprimée'];

        return response($response, 201);
    }

}

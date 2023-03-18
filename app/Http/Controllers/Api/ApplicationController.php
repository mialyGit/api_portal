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
        $applications = Application::orderBy('created_at', 'DESC')->get();
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
            'type_app' => 'required | int ',
        ]);

        $fields['logo_app'] = "logo/default-logo.png";

        if($request->file != ''){
            $name = strtolower($fields['nom_app'].'_'.$fields['code_app']);
            $fields['logo_app'] = $this->upload_image($request->file,$name);
        }

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
        $fields = $this->validateUpdate($request, $application);
        $application->update($fields);
        $response = [
            'application' => $application
        ];
        return response($response, 201);

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

    private function upload_image($img, $name)
    {
        $folderPath = "logo/";
        if($this->url_is_image($img)){
            $contents = file_get_contents($img);
            $ext = pathinfo($img, PATHINFO_EXTENSION);
        } else {
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $ext = $image_type_aux[1];
            $contents = base64_decode($image_parts[1]);
        }

        $file = $folderPath.$name.".".$ext;
        file_put_contents("storage/".$file, $contents);
        return $file;
    }

    private function url_is_image($url)
    {
        if(filter_var($url, FILTER_VALIDATE_URL)){
            $headers = get_headers($url, 1);
            return (strpos($headers['Content-Type'], 'image/') !== false);
        }
        return false;
    }

    private function validateUpdate($request, $app)
    {
        $allowed = ['code_app','nom_app','desc_app','abrev_app','logo_app','lien_app','type_app','file'];
        $fields = array_filter(
            $request->all(),
            function ($key) use ($allowed) { 
                return in_array($key, $allowed);
            },
            ARRAY_FILTER_USE_KEY
        );

        if(isset($fields['file'])){
            $name = strtolower($app->nom_app.'_'.$app->code_app);
            if($app->logo_app != "logo/default-logo.png"){
                $imagePath = public_path("storage/" . $app->logo_app);
                if(File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }
            $fields['logo_app'] = $this->upload_image($fields['file'],$name);
            unset($fields['file']);
        }
        if(isset($fields['code_app'])){
            $request->validate(['code_app' => 'required | string | unique:applications,code_app,'. $app->id],$this->messages());
        }
        if(isset($fields['nom_app'])){
            $request->validate(['nom_app' => 'required | string'],$this->messages());
        }
        if(isset($fields['desc_app'])){
            $request->validate(['desc_app' => 'nullable | string']);
        }
        if(isset($fields['abrev_app'])){
            $request->validate(['abrev_app' => 'nullable | string']);
        }
        if(isset($fields['lien_app'])){
            $request->validate(['lien_app' => 'required | string'],$this->messages());
        }
        if(isset($fields['type_app'])){
            $request->validate(['type_app' => 'required | int '],$this->messages());
        }
        return $fields;
    }

    private function messages()
    {
        return 
        [   
            'code_app.required'    => 'Veuillez entrer le code de l\'application',
            'nom_app.required'      => 'Veuillez entrer le nom de l\'application',
            'lien_app.required'      => 'Veuillez entrer le lien de l\'application',
            'type_app.required' => 'Veuillez entrer le type d\'application',
            'code_app.unique'      => 'Cette code application est déjà dans la base, veuillez essayer une autre',
        ];
    }

}

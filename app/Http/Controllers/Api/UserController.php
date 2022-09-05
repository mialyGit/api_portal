<?php

namespace App\Http\Controllers\Api;

// use Storage;
use App\Models\User;
// use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $users = User::with('type_user:id,libelle_type')->get();
        // // return UserResource::collection($users);
        // return $users;
        return User::all()->load('type_user'); 
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
            'email' => 'required | email | string | unique:users,email',
            'password' => 'required | string | confirmed',
            'adresse' => 'nullable | string',
            'type_user_id' => 'required | int | exists:type_users,id',
        ], $this->messages());

        $fields['photo'] = "profiles/default-icon.jpg";
        $fields['mot_de_passe'] = $fields['password'];
        $fields['password'] = bcrypt($fields['password']);
        $fields['remember_token'] = Str::random(10);

        if(isset($request->file)){
            $parts = explode('@', $fields['email']);
            $name = strtolower($parts[0]);
            $fields['photo'] = $this->upload_image($request->file, $name);
        }
        
        $user = User::create($fields);
        // $token = $user->createToken('myapptoken')->plainTextToken;
        // $response = [
        //     'user' => $user,
        //     'token' => $token
        // ];
        
        return $user;
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required | string ',
            'password' => 'required | string '
        ]);

        $user = User::where('email', $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password)){
            return null;
        }

        return $user;
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user->type_user;
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
        $fields = $this->validateUpdate($request, $user);
        $user->update($fields);
        $response = [
            'user' => $user
        ];
        
        return response($response, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if($user->photo != "profiles/default-icon.jpg"){
            $imagePath = public_path("storage/" . $user->photo);
            if(File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        $user->delete();
        $response = ['message' => 'Utilisateur supprimée de la base de données'];
        return response($response,201);
    }

    public function destroy_all()
    {
        User::truncate();
        
        $response = ['message' => 'Toute est bien supprimée'];

        return response($response, 201);
    }

    private function upload_image($img, $name)
    {
        $folderPath = "profiles/";
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
    
    private function validateUpdate($request, $user)
    {
        $allowed = ['nom','prenom','email','password','mot_de_passe','status','online','cin','telephone','photo','adresse','type_user_id'];
        $fields = array_filter(
            $request->all(),
            function ($key) use ($allowed) { 
                return in_array($key, $allowed);
            },
            ARRAY_FILTER_USE_KEY
        );

        if(isset($fields['file'])){
            $parts = explode('@', $user->email);
            $name = strtolower($parts[0]);
            if($user->photo != "profiles/default-icon.jpg"){
                $imagePath = public_path("storage/" . $user->photo);
                if(File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }
            $fields['photo'] = $this->upload_image($fields['file'],$name);
            unset($fields['file']);
        }
        if(isset($fields['nom'])){
            $request->validate(['nom' => 'required | string'],$this->messages());
        }
        if(isset($fields['prenom'])){
            $request->validate(['prenom' => 'nullable | string']);
        }
        if(isset($fields['cin'])){
            $request->validate(['cin' => 'nullable | string']);
        }
        if(isset($fields['telephone'])){
            $request->validate(['telephone' => 'nullable | string']);
        }
        if(isset($fields['adresse'])){
            $request->validate(['adresse' => 'nullable | string']);
        }
        if(isset($fields['email'])){
            $request->validate(['email' => 'required | email | string | unique:users,email,'. $user->id],$this->messages());
        }
        if(isset($fields['password'])){
            $request->validate(['password' => 'required | string | confirmed'],$this->messages());
            $fields['mot_de_passe'] = $fields['password'];
            $fields['password'] = bcrypt($fields['password']);
        }
        if(isset($fields['type_user_id'])){
            $request->validate(['type_user_id' => 'required | int | exists:type_users,id'],$this->messages());
        }
        return $fields;
    }

    private function messages()
    {
        return 
        [   
            'nom.required'    => 'Veuillez entrer le nom de l\'utilisateur',
            'email.required'      => 'Veuillez entrer l\'email de l\'utilisateur',
            'password.required'      => 'Veuillez entrer le mot de passe de l\'utilisateur',
            'email.unique'      => 'Cette email est déjà dans la base, veuillez essayer une autre',
            'password.confirmed' => 'Veuillez confirmer le mot de passe',
            'type_user_id.required'      => 'Veuillez entrer le type d\'utilisateur',
            'type_user_id.exists'      => 'Cette type d\'utilisateur est introuvable',
        ];
    }
}

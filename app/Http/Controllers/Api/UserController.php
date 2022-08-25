<?php

namespace App\Http\Controllers\Api;

use Storage;
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
            'email' => 'required | string | unique:users,email',
            'password' => 'required | string | confirmed',
            'adresse' => 'nullable | string',
            'file' => 'nullable',
            'type_user_id' => 'required | int | exists:type_users,id',
        ]);

        $fields['photo'] = "profiles/default-icon.jpg";

        if($request->file !== ''){
            $parts = explode('@', $fields['email']);
            $name = strtolower($parts[0]);
            $fields['photo'] = $this->upload_image($request->file,$name);
        }

        unset($fields['file']);
        
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
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
        // $file = $this->upload_image($request->file,"mldevopsy");
        $allowed = ['nom','prenom','cin','telephone','email','password','adresse','file','type_user_id'];
        $fields = array_filter(
            $request->all(),
            function ($key) use ($allowed) { 
                return in_array($key, $allowed);
            },
            ARRAY_FILTER_USE_KEY
        );

        if(isset($fields['password'])){
            $request->validate(['password' => 'required | string | confirmed']);
            $fields['password'] = bcrypt($fields['password']);
        }

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
    public function destroy(User $user)
    {
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

    // public function upload_img_if_an_url($url, $name)
    // {
    //     if($this->url_is_image($url)){
    //         $contents = file_get_contents($url);
    //         $ext = pathinfo($url, PATHINFO_EXTENSION);
    //         $name = "public/profiles/".$name.".".$ext;
    //         Storage::put($name, $contents);
    //     }
    // }

    public function upload_image($img, $name)
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

    public function url_is_image($url)
    {
        if(filter_var($url, FILTER_VALIDATE_URL)){
            $headers = get_headers($url, 1);
            return (strpos($headers['Content-Type'], 'image/') !== false);
        }
        return false;
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Historique;
use Illuminate\Http\Request;
use App\Models\UserPrivilegeApp;
use App\Http\Controllers\Controller;

class UserPrivilegeAppController extends Controller
{
    protected $data;
    public function __construct(UserController $userController)
    {
        $this->data =  UserPrivilegeApp::join('users', 'users.id', '=', 'user_privilege_apps.user_id')
        ->join('applications', 'applications.id', '=', 'user_privilege_apps.application_id')
        ->join('privileges', 'privileges.id', '=', 'user_privilege_apps.privilege_id');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*return UserPrivilegeApp::mapToGroups(function($i) {
            return ['application_id' => $i['application_id'],
                    'applications' => [
                         'application_id' => $i['application_id']
                   ]];
        });*/
        return UserPrivilegeApp::all();
    }

    private function group_by($key, $name, $data) {
        $result = array();
        $keys = array();
        foreach($data as $val) {
            if(in_array($val[$key],$keys)){
                foreach($result as $row){
                    if($row[$key] == $val[$key]){
                        $row[$name] = $row[$name] .",".$val[$name];
                    }
                }
            } else {
                $keys[] = $val[$key];
                $result[] = $val;
            }
        }
    
        return $result;
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
        ]);

        $p = $request->validate(['privilege_id' => 'required | string ']);
        
        $ints = array_map('intval', explode(',', $p['privilege_id'] ));

        $response = [];

        for ($i=0; $i < count($ints); $i++) { 
            $fields['privilege_id'] = $ints[$i];
            $userPrivilegeApp = UserPrivilegeApp::where('user_id',$fields['user_id'])
            ->where('application_id',$fields['application_id'])->where('privilege_id',$fields['privilege_id'])->first();
            if($userPrivilegeApp == null){
                $userPrivilegeApp = UserPrivilegeApp::create($fields);
            }
            $response[] = $userPrivilegeApp;
        }

        if(isset($request->maker_id)){
            $user = User::where('id', $fields['user_id'])->first();
            Historique::create([
                'action' => "Assigné des privilèges à $user->nom",
                'user_id' => $request->maker_id
            ]);
        }

        return response($response, 201);
    }

    public function store2(Request $request)
    {
        $fields = $request->validate([
            'user_id' => 'required | int | exists:users,id',
            'application_id' => 'required | int | exists:applications,id',
        ]);

        $userPrivilegeApp = UserPrivilegeApp::where('user_id',$fields['user_id'])
            ->where('application_id',$fields['application_id']);
        $userPrivilegeApp->delete();
        $response = [];
        
        if($request->privilege_id != ""){
            $ints = array_map('intval', explode(',', $request->privilege_id ));

            for ($i=0; $i < count($ints); $i++) { 
                $fields['privilege_id'] = $ints[$i];
                $userPrivilegeApp = UserPrivilegeApp::create($fields);
                
                $response[] = $userPrivilegeApp;
            }
    
            if(isset($request->maker_id)){
                $user = User::where('id', $fields['user_id'])->first();
                Historique::create([
                    'action' => "Modifié des privilèges à $user->nom",
                    'user_id' => $request->maker_id
                ]);
            }
        }
        
        return response($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserPrivilegeApp  $userPrivilegeApp
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        $response = array();
        $users = $this->data->where('user_id', $user_id)->get(['application_id','code_app','user_id','nom','prenom','desc_app','logo_app','nom_app','nom_privilege']);
        $response = $this->group_by('code_app', 'nom_privilege', $users);
        return $response;
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
        $fields = $request->validate([
            'user_id' => 'required | int | exists:users,id',
            'application_id' => 'required | int | exists:applications,id',
        ]);

        $p = $request->validate(['privilege_id' => 'required | string ']);
        
        $ints = array_map('intval', explode(',', $p['privilege_id'] ));

        $response = [];

        for ($i=0; $i < count($ints); $i++) { 
            $fields['privilege_id'] = $ints[$i];
            $userPrivilegeApp = UserPrivilegeApp::where('user_id',$fields['user_id'])
            ->where('application_id',$fields['application_id'])->where('privilege_id',$fields['privilege_id'])->first();
            if($userPrivilegeApp == null){
                $userPrivilegeApp = UserPrivilegeApp::create($fields);
            }
            $response[] = $userPrivilegeApp;
        }

        if(isset($request->maker_id)){
            $user = User::where('id', $fields['user_id'])->first();
            Historique::create([
                'action' => "Modifié des privilèges à $user->nom",
                'user_id' => $request->maker_id
            ]);
        }

        return response($response, 201);
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

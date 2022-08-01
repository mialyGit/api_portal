<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $privilege = $this->whenLoaded('privilege');
        // $type_user = $this->whenLoaded('type_user');
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'email' => $this->email ,
            'password' => $this->password,
            'cin' => $this->cin,
            'telephone' => $this->telephone,
            'photo' => $this->photo,
            'privilege' =>  new PrivilegeResource($this->privileges),
            // 'type_user' =>  new TypeUserResource($privilege),
        ];
    }
}

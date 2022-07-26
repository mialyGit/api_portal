<?php

namespace App\Models;

use App\Models\Message;
// use App\Models\Type_user;
use App\Models\Fonction;
use App\Models\Personnel;
use App\Models\Historique;
use App\Models\Contribuable;
use Laravel\Sanctum\HasApiTokens;
// use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['id','nom','prenom','email','password','mot_de_passe','status','online','cin','telephone','photo','adresse','type_user_id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'cin' => 'array'
    ];

    // protected $attributes = [
    //     'cin' => [
    //         'numero','date_delivrance',
    //         'date_naissance', 'lieu_naissance', 
    //         'date_duplicata','lieu_duplicata',
    //         'pere','mere'
    //     ]
    // ];

    /**
     * The roles that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function applications(): BelongsToMany
    {
        return $this->belongsToMany(Application::class);
    }

    /**
     * Get the type_user that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    /*public function type_user(): BelongsTo
    {
        return $this->belongsTo(Type_user::class);
    }*/

    /**
     * Get all of the historiques for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function historiques(): HasMany
    {
        return $this->hasMany(Historique::class);
    }

    public function senderMessage(): HasMany
    {
        return $this->hasMany(Message::class,'sender_id');
    }

    public function receiverMessage(): HasMany
    {
        return $this->hasMany(Message::class,'rec_id');
    }

    public function unreadMessage()
    {
        return $this->hasMany(Message::class,'sender_id')->whereStatus(false);
    }

    public function lastSendMessage()
    {
        return $this->hasOne(Message::class,'sender_id')->latest();
    }

    public function lastRecMessage()
    {
        return $this->hasOne(Message::class,'rec_id')->latest();
    }
    
    public function personnel(): HasOne
    {
        return $this->hasOne(Personnel::class)
        ->select(['id','user_id','num_matricule','fonction_id','grade_id']);
    }

    public function contribuable(): HasOne
    {
        return $this->hasOne(Contribuable::class)
        ->select(['id','user_id','nif','raison_sociale','s_matrim','activite','type_contr','localisation']);
    }

    public function message()
    {
        return Message::where('rec_id',  $this->id)
        ->where('status',  false)
        ->get();
    }
}

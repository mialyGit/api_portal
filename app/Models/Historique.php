<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Historique extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'action', 'user_id'];

    /**
     * Get the user that owns the Historique
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)
        ->select(['id','nom','prenom','telephone','photo','adresse','email']);
    }
}

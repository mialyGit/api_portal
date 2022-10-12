<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    use HasFactory;

    public function historiques(): HasMany
    {
        return $this->hasMany(Historique::class);
    }

    public function personnel(): HasOne
    {
        return $this->hasOne(Personnel::class);
    }

    public function contribuable(): HasOne
    {
        return $this->hasOne(Contribuable::class);
    }
}

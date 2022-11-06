<?php

namespace App\Models;

use App\Models\Fonction;
use App\Models\Direction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['id','code_sc','nom_sc','abrev_sc','cur_bur_sc','lieu_bur_sc','adresse_sc','mail_sc','tel_2_sc','direction_id'];

    public function direction(): BelongsTo
    {
        return $this->belongsTo(Direction::class);
    }

    public function fonctions(): HasMany
    {
        return $this->hasMany(Fonction::class);
    }
}

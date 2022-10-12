<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contribuable extends Model
{
    use HasFactory;

    protected $fillable = ['id','user_id','nif','raison_sociale','s_matrim','activite','type_contr','localisation'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

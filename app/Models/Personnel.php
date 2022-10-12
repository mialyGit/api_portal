<?php

namespace App\Models;

use App\Models\User;
use App\Models\Grade;
use App\Models\Fonction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Personnel extends Model
{
    use HasFactory;

    protected $fillable = ['id','num_matricule','user_id','fonction_id','grade_id'];

    public function fonction(): BelongsTo
    {
        return $this->belongsTo(Fonction::class)
        ->select(['id','nom_fn','service_id']);
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class)
        ->select(['id','nom_gr']);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

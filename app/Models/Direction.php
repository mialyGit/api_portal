<?php

namespace App\Models;

use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Direction extends Model
{
    use HasFactory;

    protected $fillable = ['id','code_dir','nom_dir','abrev_dir'];

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPrivilegeApp extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'user_id', 'application_id', 'privilege_id'];
}

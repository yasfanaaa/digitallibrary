<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Users as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Users extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'password',
        'name',
        'email',
        'phone'
    ];

}
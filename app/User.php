<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * This class was created to provide Authentication
 * for the users of ProductManagement application
 * using Authenticatable and Illuminate\Foundation\Auth\User.
 *
 * @license MIT
 * @package davidwlfreitas\ProductManagement
 */
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}

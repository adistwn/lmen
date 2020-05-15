<?php

namespace App;

// use Illuminate\Auth\Authenticatable;
// use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
// use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
// use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;

class User extends Model 
{
    // use Authenticatable, Authorizable;

    /**
     * Set default incrementing
     * @var bool
     */
    public $incrementing = false;

    /**
     * Set default primary key
     * @var string
     */
    protected $primaryKey = 'uuid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'uuid', 'token'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'uuid', 'token'
    ];
}

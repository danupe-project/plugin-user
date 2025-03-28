<?php

namespace Danupe\Plugin\User\Models;

use Danupe\Plugin\Database\Classes\Model;

class User extends Model
{
    protected $table = 'users';

    protected $attributes = [
        'id' => null,
        'email' => null,
        'password' => null,
    ];

}
<?php

namespace Danupe\Plugin\User\Models;

use Danupe\Plugin\Database\Classes\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $attributes = [
        'id' => null,
        'name' => null,
    ];

}
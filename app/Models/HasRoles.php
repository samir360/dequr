<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasRoles extends Model
{
    protected $table = 'role_has_permissions';

    protected $guarded = [];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RadUserGroup extends Model
{
    protected $table = 'radusergroup';
    
    protected $fillable = [
        'username',
        'groupname',
        'priority',
    ];

    // Disable default timestamps if table doesn't have them
    // Looking at seeder, it seems to have them.
}

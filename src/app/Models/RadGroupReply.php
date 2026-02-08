<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RadGroupReply extends Model
{
    protected $table = 'radgroupreply';
    
    protected $fillable = [
        'groupname',
        'attribute',
        'op',
        'value',
    ];

    // Disable default timestamps if table doesn't have them, 
    // but migration showed $table->timestamps(), so we keep them enabled.
}

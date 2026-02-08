<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenueSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'nas_id',
        'name',
        'logo_path',
        'background_image_path',
        'primary_color',
        'policy_id',
    ];

    public function policy()
    {
        return $this->belongsTo(Policy::class);
    }

    public function nas()
    {
        return $this->hasMany(Nas::class);
    }
}

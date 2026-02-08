<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nas extends Model
{
    protected $table = 'nas';
    
    protected $fillable = [
        'nasname',
        'shortname', 
        'type',
        'ports',
        'secret',
        'community',
        'description'
    ];
    
    /**
     * Get NAS by IP address
     */
    public static function getByIp($ip)
    {
        return static::where('nasname', $ip)->first();
    }
    
    /**
     * Get NAS by short name
     */
    public static function getByShortName($shortName)
    {
        return static::where('shortname', $shortName)->first();
    }
    
    /**
     * Scope for active NAS devices
     */
    public function scopeActive($query)
    {
        return $query->where('type', '>', 0);
    }
}

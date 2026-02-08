<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RadCheck extends Model
{
    protected $table = 'radcheck';
    
    protected $fillable = [
        'username',
        'attribute',
        'op',
        'value'
    ];
    
    public $timestamps = false;
    
    /**
     * Create a new RADIUS user with password
     */
    public static function createUser($username, $password)
    {
        return static::create([
            'username' => $username,
            'attribute' => 'Cleartext-Password',
            'op' => ':=',
            'value' => $password
        ]);
    }
    
    /**
     * Get user password record
     */
    public static function getPassword($username)
    {
        return static::where('username', $username)
                    ->where('attribute', 'Cleartext-Password')
                    ->first();
    }
    
    /**
     * Check if user exists
     */
    public static function userExists($username)
    {
        return static::where('username', $username)
                    ->where('attribute', 'Cleartext-Password')
                    ->exists();
    }
}

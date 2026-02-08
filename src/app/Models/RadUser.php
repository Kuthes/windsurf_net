<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RadUser extends Model
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
     * Get user password attribute
     */
    public static function getPassword($username)
    {
        return static::where('username', $username)
                    ->where('attribute', 'Cleartext-Password')
                    ->first();
    }
    
    /**
     * Create a new RADIUS user
     */
    public static function createUser($username, $password, $group = 'hotspot_users')
    {
        // Create password entry
        static::create([
            'username' => $username,
            'attribute' => 'Cleartext-Password',
            'op' => ':=',
            'value' => $password
        ]);
        
        // Create auth type entry
        static::create([
            'username' => $username,
            'attribute' => 'Auth-Type',
            'op' => ':=',
            'value' => 'Local'
        ]);
        
        // Assign to group
        DB::table('radusergroup')->insert([
            'username' => $username,
            'groupname' => $group,
            'priority' => 1
        ]);
    }
    
    /**
     * Delete a RADIUS user
     */
    public static function deleteUser($username)
    {
        static::where('username', $username)->delete();
        DB::table('radusergroup')->where('username', $username)->delete();
    }
    
    /**
     * Get all users with their groups
     */
    public static function getAllUsers()
    {
        return DB::table('radcheck as rc')
            ->select('rc.username', 'rc.value as password', 'rug.groupname')
            ->leftJoin('radusergroup as rug', 'rc.username', '=', 'rug.username')
            ->where('rc.attribute', 'Cleartext-Password')
            ->get();
    }
}

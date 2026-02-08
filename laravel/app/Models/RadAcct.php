<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RadAcct extends Model
{
    protected $table = 'radacct';
    
    protected $fillable = [
        'acctsessionid',
        'acctuniqueid',
        'username',
        'groupname',
        'realm',
        'nasipaddress',
        'nasportid',
        'nasporttype',
        'acctstarttime',
        'acctstoptime',
        'acctsessiontime',
        'acctauthentic',
        'connectinfo_start',
        'connectinfo_stop',
        'acctinputoctets',
        'acctoutputoctets',
        'calledstationid',
        'callingstationid',
        'acctterminatecause',
        'servicetype',
        'framedprotocol',
        'framedipaddress'
    ];
    
    public $timestamps = false;
    protected $dates = [
        'acctstarttime',
        'acctstoptime'
    ];
    
    /**
     * Get active sessions
     */
    public static function getActiveSessions()
    {
        return static::whereNull('acctstoptime')
                    ->orderBy('acctstarttime', 'desc')
                    ->get();
    }
    
    /**
     * Get session statistics
     */
    public static function getSessionStats($days = 30)
    {
        $startDate = now()->subDays($days);
        
        return [
            'total_sessions' => static::where('acctstarttime', '>=', $startDate)->count(),
            'total_time' => static::where('acctstarttime', '>=', $startDate)->sum('acctsessiontime'),
            'total_upload' => static::where('acctstarttime', '>=', $startDate)->sum('acctinputoctets'),
            'total_download' => static::where('acctstarttime', '>=', $startDate)->sum('acctoutputoctets'),
            'unique_users' => static::where('acctstarttime', '>=', $startDate)
                                ->distinct('username')
                                ->count('username')
        ];
    }
    
    /**
     * Get daily usage statistics
     */
    public static function getDailyUsage($days = 30)
    {
        return static::selectRaw('DATE(acctstarttime) as date, COUNT(*) as sessions, SUM(acctsessiontime) as total_time, SUM(acctinputoctets) as upload, SUM(acctoutputoctets) as download')
                    ->where('acctstarttime', '>=', now()->subDays($days))
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();
    }
    
    /**
     * Get user usage statistics
     */
    public static function getUserUsage($username, $days = 30)
    {
        $startDate = now()->subDays($days);
        
        return static::where('username', $username)
                    ->where('acctstarttime', '>=', $startDate)
                    ->orderBy('acctstarttime', 'desc')
                    ->get();
    }
}

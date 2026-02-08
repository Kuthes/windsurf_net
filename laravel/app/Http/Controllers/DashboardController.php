<?php

namespace App\Http\Controllers;

use App\Models\RadUser;
use App\Models\RadAcct;

class DashboardController extends Controller
{
    /**
     * Display the dashboard
     */
    public function index()
    {
        $stats = RadAcct::getSessionStats(30);
        $activeSessions = RadAcct::getActiveSessions();
        $totalUsers = RadUser::getAllUsers()->count();
        $dailyUsage = RadAcct::getDailyUsage(7);
        
        return view('dashboard', compact('stats', 'activeSessions', 'totalUsers', 'dailyUsage'));
    }
}

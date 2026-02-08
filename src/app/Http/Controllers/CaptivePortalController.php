<?php

namespace App\Http\Controllers;

use App\Models\Nas;
use App\Models\RadUserGroup;
use App\Models\VenueSetting;
use Illuminate\Http\Request;

class CaptivePortalController extends Controller
{
    /**
     * Display the captive portal login page
     */
    public function show(Request $request)
    {
        $nasId = $request->get('nasId');
        
        if (!$nasId) {
            return response()->view('captive-portal', ['venueSettings' => null], 404);
        }
        
        // 1. Look up NAS by nasname (IP) or shortname
        $nas = Nas::where('nasname', $nasId)
                  ->orWhere('shortname', $nasId)
                  ->first();

        // 2. Get the linked Venue Setting
        $venueSettings = $nas ? $nas->venueSetting : null;
        
        // Fallback: Check strictly by IP if nasId was an IP, but not found in DB?
        // Actually, users must register NAS in DB for this to work now.
        
        if (!$venueSettings) {
            return response()->view('captive-portal', ['venueSettings' => null], 404);
        }
        
        return view('captive-portal', compact('venueSettings'));
    }

    /**
     * Display the captive portal login page and persist UAM parameters.
     */
    public function loginPage(Request $request)
    {
        $params = $request->only([
            'res',
            'uamip',
            'uamport',
            'challenge',
            'mac',
            'ip',
            'nasid',
        ]);

        $request->session()->put('portal.login', $params);

        return view('portal.login', [
            'params' => $params,
        ]);
    }
    
    /**
     * Handle captive portal login
     */
    public function login(Request $request)
    {
        $params = $request->session()->get('portal.login', []);

        if (!$request->filled('nas_id') && isset($params['nasid'])) {
            $request->merge(['nas_id' => $params['nasid']]);
        }

        $request->validate([
            'username' => 'required|string|max:64',
            'password' => 'required|string',
            'nas_id' => 'required|string'
        ]);
        
        // Login Logic
        $username = $request->username;
        $nasId = $request->nas_id;
        
        // 1. Find NAS & Venue
        $nas = Nas::where('nasname', $nasId)
                  ->orWhere('shortname', $nasId)
                  ->first();
                  
        $venueSettings = $nas ? $nas->venueSetting : null;

        // 2. Policy Enforcement
        if ($venueSettings && $venueSettings->policy_id) {
            $policyGroupName = 'policy_' . $venueSettings->policy_id;

            // Clean up old policy groups
            RadUserGroup::where('username', $username)
                ->where('groupname', 'like', 'policy_%')
                ->delete();

            // Assign new policy group
            RadUserGroup::create([
                'username' => $username,
                'groupname' => $policyGroupName,
                'priority' => 10,
            ]);
        }

        // TODO: Full RADIUS Authentication check here
        
        return redirect()->route('captive-portal.success', ['nasId' => $nasId])
                        ->with('success', 'Login successful! Redirecting to internet...');
    }
    
    /**
     * Show success page after successful login
     */
    public function success(Request $request)
    {
        $nasId = $request->get('nasId');
        
        $nas = Nas::where('nasname', $nasId)
                  ->orWhere('shortname', $nasId)
                  ->first();
                  
        $venueSettings = $nas ? $nas->venueSetting : null;
        
        return view('captive-portal-success', compact('venueSettings'));
    }
}

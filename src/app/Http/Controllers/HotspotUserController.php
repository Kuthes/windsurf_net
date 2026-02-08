<?php

namespace App\Http\Controllers;

use App\Models\RadCheck;
use Illuminate\Http\Request;

class HotspotUserController extends Controller
{
    /**
     * Store a newly created hotspot user.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'username' => 'required|string|max:64|unique:radcheck,username',
            'password' => 'required|string|min:6|max:253',
        ]);
        
        try {
            // Create the user in radcheck table
            $radCheck = RadCheck::create([
                'username' => $validated['username'],
                'attribute' => 'Cleartext-Password',
                'op' => ':=',
                'value' => $validated['password']
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'data' => $radCheck
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user: ' . $e->getMessage()
            ], 500);
        }
    }
}

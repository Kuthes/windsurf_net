<?php

namespace App\Http\Controllers;

use App\Models\RadUser;
use App\Models\RadAcct;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display all users
     */
    public function index()
    {
        $users = RadUser::getAllUsers();
        return view('users.index', compact('users'));
    }
    
    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        return view('users.create');
    }
    
    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:64|unique:radcheck,username',
            'password' => 'required|string|min:6|confirmed',
            'group' => 'required|string|max:64'
        ]);
        
        RadUser::createUser(
            $request->username,
            $request->password,
            $request->group
        );
        
        return redirect()->route('users.index')
                        ->with('success', 'User created successfully.');
    }
    
    /**
     * Show user details
     */
    public function show($username)
    {
        $user = RadUser::getAllUsers()->where('username', $username)->first();
        $usage = RadAcct::getUserUsage($username, 30);
        
        if (!$user) {
            abort(404);
        }
        
        return view('users.show', compact('user', 'usage'));
    }
    
    /**
     * Show the form for editing user
     */
    public function edit($username)
    {
        $user = RadUser::getAllUsers()->where('username', $username)->first();
        
        if (!$user) {
            abort(404);
        }
        
        return view('users.edit', compact('user'));
    }
    
    /**
     * Update user password
     */
    public function update(Request $request, $username)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed'
        ]);
        
        // Update password
        RadUser::where('username', $username)
               ->where('attribute', 'Cleartext-Password')
               ->update(['value' => $request->password]);
        
        return redirect()->route('users.show', $username)
                        ->with('success', 'Password updated successfully.');
    }
    
    /**
     * Delete user
     */
    public function destroy($username)
    {
        RadUser::deleteUser($username);
        
        return redirect()->route('users.index')
                        ->with('success', 'User deleted successfully.');
    }
}

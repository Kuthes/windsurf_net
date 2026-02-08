@extends('layouts.app')

@section('title', 'Edit User')
@section('header', 'Edit User: {{ $user->username }}')

@section('content')
<div class="max-w-md">
    <form action="{{ route('users.update', $user->username) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-6">
            <div class="bg-gray-50 p-4 rounded">
                <div class="text-sm font-medium text-gray-700">Username: {{ $user->username }}</div>
                <div class="text-sm text-gray-500">Group: {{ $user->groupname ?: 'No Group' }}</div>
            </div>
        </div>
        
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
            <input type="password" id="password" name="password" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        
        <div class="flex space-x-3">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Update Password
            </button>
            <a href="{{ route('users.show', $user->username) }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection

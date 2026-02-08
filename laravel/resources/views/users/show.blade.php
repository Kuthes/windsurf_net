@extends('layouts.app')

@section('title', 'User Details')
@section('header', 'User Details: {{ $user->username }}')

@section('content')
<div class="mb-6">
    <a href="{{ route('users.index') }}" class="text-blue-600 hover:text-blue-800">&larr; Back to Users</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- User Info -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-semibold">User Information</h2>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <div>
                        <div class="text-sm font-medium text-gray-500">Username</div>
                        <div class="text-lg font-semibold">{{ $user->username }}</div>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-500">Group</div>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            {{ $user->groupname ?: 'No Group' }}
                        </span>
                    </div>
                </div>
                
                <div class="mt-6 space-y-2">
                    <a href="{{ route('users.edit', $user->username) }}" class="block w-full bg-blue-600 text-white px-4 py-2 rounded text-center hover:bg-blue-700">
                        Change Password
                    </a>
                    <form action="{{ route('users.destroy', $user->username) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                            Delete User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Usage Statistics -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-semibold">Usage Statistics (Last 30 days)</h2>
            </div>
            <div class="p-6">
                @if($usage->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th class="text-left py-2">Session ID</th>
                                    <th class="text-left py-2">Start Time</th>
                                    <th class="text-left py-2">Duration</th>
                                    <th class="text-left py-2">Upload</th>
                                    <th class="text-left py-2">Download</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($usage->take(20) as $session)
                                    <tr class="border-t">
                                        <td class="py-2 text-sm">{{ $session->acctsessionid }}</td>
                                        <td class="py-2 text-sm">{{ $session->acctstarttime ? \Carbon\Carbon::parse($session->acctstarttime)->format('M j, Y H:i') : 'N/A' }}</td>
                                        <td class="py-2 text-sm">{{ gmdate('H:i:s', $session->acctsessiontime ?: 0) }}</td>
                                        <td class="py-2 text-sm">{{ formatBytes($session->acctinputoctets ?: 0) }}</td>
                                        <td class="py-2 text-sm">{{ formatBytes($session->acctoutputoctets ?: 0) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500">No usage data available for this user.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

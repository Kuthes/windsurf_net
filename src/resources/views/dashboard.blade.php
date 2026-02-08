@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-sm font-medium text-gray-500">Total Users</div>
        <div class="text-2xl font-bold text-gray-900">{{ $totalUsers }}</div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-sm font-medium text-gray-500">Active Sessions</div>
        <div class="text-2xl font-bold text-green-600">{{ $activeSessions->count() }}</div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-sm font-medium text-gray-500">Total Sessions (30 days)</div>
        <div class="text-2xl font-bold text-blue-600">{{ number_format($stats['total_sessions']) }}</div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-sm font-medium text-gray-500">Unique Users (30 days)</div>
        <div class="text-2xl font-bold text-purple-600">{{ $stats['unique_users'] }}</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Active Sessions -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold">Active Sessions</h2>
        </div>
        <div class="p-6">
            @if($activeSessions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="text-left py-2">Username</th>
                                <th class="text-left py-2">Start Time</th>
                                <th class="text-left py-2">IP Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activeSessions->take(10) as $session)
                                <tr class="border-t">
                                    <td class="py-2">{{ $session->username }}</td>
                                    <td class="py-2">{{ $session->acctstarttime ? \Carbon\Carbon::parse($session->acctstarttime)->format('M j, Y H:i') : 'N/A' }}</td>
                                    <td class="py-2">{{ $session->framedipaddress }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500">No active sessions</p>
            @endif
        </div>
    </div>
    
    <!-- Daily Usage Chart -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold">Daily Usage (7 days)</h2>
        </div>
        <div class="p-6">
            @if($dailyUsage->count() > 0)
                <div class="space-y-2">
                    @foreach($dailyUsage as $day)
                        <div class="flex justify-between items-center">
                            <span class="text-sm">{{ \Carbon\Carbon::parse($day->date)->format('M j') }}</span>
                            <div class="flex items-center space-x-4">
                                <span class="text-sm text-blue-600">{{ $day->sessions }} sessions</span>
                                <span class="text-sm text-green-600">{{ number_format($day->total_time / 60, 1) }} min</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No usage data available</p>
            @endif
        </div>
    </div>
</div>

<!-- Bandwidth Usage -->
<div class="mt-6 bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b">
        <h2 class="text-lg font-semibold">Bandwidth Usage (30 days)</h2>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <div class="text-sm font-medium text-gray-500">Total Upload</div>
                <div class="text-xl font-bold text-green-600">{{ formatBytes($stats['total_upload']) }}</div>
            </div>
            <div>
                <div class="text-sm font-medium text-gray-500">Total Download</div>
                <div class="text-xl font-bold text-blue-600">{{ formatBytes($stats['total_download']) }}</div>
            </div>
        </div>
    </div>
</div>
@endsection

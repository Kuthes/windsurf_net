<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    protected $fillable = [
        'name',
        'concurrency_limit',
        'max_devices_limit',
        'daily_session_count',
        'session_timeout', 'session_timeout_unit',
        'idle_timeout', 'idle_timeout_unit',
        'validity_interval', 'validity_interval_unit',
        'total_time_quota', 'total_time_quota_unit',
        'daily_time_quota', 'daily_time_quota_unit',
        'total_bandwidth_quota', 'total_bandwidth_quota_unit',
        'daily_bandwidth_quota', 'daily_bandwidth_quota_unit',
        'download_rate', 'download_rate_unit',
        'upload_rate', 'upload_rate_unit',
        'auto_renewal',
        'is_default',
        'filter_id',
        'redirect_url',
    ];

    protected $casts = [
        'auto_renewal' => 'boolean',
        'is_default' => 'boolean',
    ];
}

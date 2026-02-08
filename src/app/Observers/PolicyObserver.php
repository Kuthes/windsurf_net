<?php

namespace App\Observers;

use App\Models\Policy;
use App\Models\RadGroupCheck;
use App\Models\RadGroupReply;
use Illuminate\Support\Facades\DB;

class PolicyObserver
{
    /**
     * Handle the Policy "saved" event.
     */
    public function saved(Policy $policy): void
    {
        $groupName = 'policy_' . $policy->id;

        DB::transaction(function () use ($policy, $groupName) {
            // 1. Clear existing attributes for this group
            RadGroupReply::where('groupname', $groupName)->delete();
            RadGroupCheck::where('groupname', $groupName)->delete();

            // 2. Prepare Check Attributes (Conditions)
            $checks = [];
            
            // Simultaneous-Use (Concurrency)
            if ($policy->concurrency_limit > 0) {
                $checks[] = [
                    'groupname' => $groupName,
                    'attribute' => 'Simultaneous-Use',
                    'op' => ':=',
                    'value' => (string) $policy->concurrency_limit,
                ];
            }

            if (!empty($checks)) {
                RadGroupCheck::insert($checks);
            }

            // 3. Prepare Reply Attributes (Enforcement)
            $replies = [];

            // --- Bandwidth Limits ---
            
            // Helper to convert rate to bps (bits per second) for WISPr/Coova
            $toBps = function ($rate, $unit) {
                return match ($unit) {
                    'Kbps' => $rate * 1000,
                    'Mbps' => $rate * 1000 * 1000,
                    default => $rate,
                };
            };
            
            // Helper to convert rate to Kbps for Cisco/Aruba
            $toKbps = function ($rate, $unit) {
                return match ($unit) {
                    'Kbps' => $rate,
                    'Mbps' => $rate * 1000,
                    default => $rate / 1000,
                };
            };

            // Helper for Mikrotik format (e.g. 10M)
            $toMikrotik = function ($rate, $unit) {
                return match ($unit) {
                    'Kbps' => $rate . 'k',
                    'Mbps' => $rate . 'M',
                    default => $rate,
                };
            };

            // Download Rate
            if ($policy->download_rate > 0) {
                $bps = $toBps($policy->download_rate, $policy->download_rate_unit);
                $kbps = $toKbps($policy->download_rate, $policy->download_rate_unit);
                $mikrotik = $toMikrotik($policy->download_rate, $policy->download_rate_unit);

                // Mikrotik-Rate-Limit (We need Upload too for the format rx/tx)
                // We'll handle Mikrotik combined string after checking Upload
                
                // Ruckus / Coova / UniFi
                $replies[] = ['attribute' => 'WISPr-Bandwidth-Max-Down', 'value' => (string) $bps];
                
                // Cisco
                $replies[] = ['attribute' => 'Airespace-Data-Bandwidth-Average-Contract-Downstream', 'value' => (string) $kbps];
                
                // CoovaChilli Vendor Specific
                $replies[] = ['attribute' => 'ChilliSpot-Bandwidth-Max-Down', 'value' => (string) $kbps];
            }

            // Upload Rate
            if ($policy->upload_rate > 0) {
                $bps = $toBps($policy->upload_rate, $policy->upload_rate_unit);
                $kbps = $toKbps($policy->upload_rate, $policy->upload_rate_unit);
                
                // Ruckus / Coova / UniFi
                $replies[] = ['attribute' => 'WISPr-Bandwidth-Max-Up', 'value' => (string) $bps];
                
                // Cisco
                $replies[] = ['attribute' => 'Airespace-Data-Bandwidth-Average-Contract-Upstream', 'value' => (string) $kbps];
                
                // CoovaChilli Vendor Specific
                $replies[] = ['attribute' => 'ChilliSpot-Bandwidth-Max-Up', 'value' => (string) $kbps];
            }

            // Mikrotik-Rate-Limit (rx/tx -> upload/download)
            // Note: Mikrotik format is rx-rate/tx-rate usually matched to client upload/download or vice versa depending on perspective.
            // Usually Target Upload / Target Download.
            if ($policy->download_rate > 0 || $policy->upload_rate > 0) {
                $up = ($policy->upload_rate > 0) ? $toMikrotik($policy->upload_rate, $policy->upload_rate_unit) : '0';
                $down = ($policy->download_rate > 0) ? $toMikrotik($policy->download_rate, $policy->download_rate_unit) : '0';
                
                // Format: rx/tx (Upload/Download from client perspective usually)
                $replies[] = ['attribute' => 'Mikrotik-Rate-Limit', 'value' => "{$up}/{$down}"];
            }

            // --- Timeouts ---
            
            // Session Timeout
            if ($policy->session_timeout > 0) {
                $seconds = match ($policy->session_timeout_unit) {
                    'Minutes' => $policy->session_timeout * 60,
                    'Hours' => $policy->session_timeout * 3600,
                    default => $policy->session_timeout,
                };
                $replies[] = ['attribute' => 'Session-Timeout', 'value' => (string) $seconds];
            }

            // Idle Timeout
            if ($policy->idle_timeout > 0) {
                $seconds = match ($policy->idle_timeout_unit) {
                    'Minutes' => $policy->idle_timeout * 60,
                    'Hours' => $policy->idle_timeout * 3600,
                    default => $policy->idle_timeout,
                };
                $replies[] = ['attribute' => 'Idle-Timeout', 'value' => (string) $seconds];
            }

            // --- Quotas ---
            // (These might need more logic like sqlcounter, but adding basic attributes if supported by NAS)
            
            // Total Data Limit (Coova)
            if ($policy->total_bandwidth_quota > 0) {
                 $bytes = match ($policy->total_bandwidth_quota_unit) {
                    'MB' => $policy->total_bandwidth_quota * 1024 * 1024,
                    'GB' => $policy->total_bandwidth_quota * 1024 * 1024 * 1024,
                    default => $policy->total_bandwidth_quota,
                };
                $replies[] = ['attribute' => 'CoovaChilli-Max-Total-Octets', 'value' => (string) $bytes];
            }

            // --- Redirect URL (Vendor Specific) ---
            if (!empty($policy->redirect_url)) {
                $url = $policy->redirect_url;
                
                // Aruba
                $replies[] = ['attribute' => 'Aruba-Captive-Portal-URL', 'value' => $url];
                
                // Cisco (cisco-av-pair=url-redirect=...)
                $replies[] = ['attribute' => 'Cisco-AVPair', 'value' => 'url-redirect=' . $url];
                
                // Ruckus / SmartZone
                $replies[] = ['attribute' => 'WISPr-Redirection-URL', 'value' => $url];
            }

            // Insert all replies
            foreach ($replies as $reply) {
                RadGroupReply::create([
                    'groupname' => $groupName,
                    'attribute' => $reply['attribute'],
                    'op' => ':=',
                    'value' => $reply['value'],
                ]);
            }
        });
    }

    /**
     * Handle the Policy "deleted" event.
     */
    public function deleted(Policy $policy): void
    {
        $groupName = 'policy_' . $policy->id;
        RadGroupReply::where('groupname', $groupName)->delete();
        RadGroupCheck::where('groupname', $groupName)->delete();
    }
}

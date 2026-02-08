<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RadiusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default group for hotspot users
        DB::table('radgroupreply')->insert([
            [
                'groupname' => 'hotspot_users',
                'attribute' => 'Session-Timeout',
                'op' => '=',
                'value' => '3600',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'groupname' => 'hotspot_users',
                'attribute' => 'Idle-Timeout',
                'op' => '=',
                'value' => '600',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'groupname' => 'hotspot_users',
                'attribute' => 'Framed-Protocol',
                'op' => '=',
                'value' => 'PPP',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'groupname' => 'hotspot_users',
                'attribute' => 'Service-Type',
                'op' => '=',
                'value' => 'Framed-User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Create a test user (password: test123)
        DB::table('radcheck')->insert([
            [
                'username' => 'testuser',
                'attribute' => 'Cleartext-Password',
                'op' => ':=',
                'value' => 'test123',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'testuser',
                'attribute' => 'Auth-Type',
                'op' => ':=',
                'value' => 'Local',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Assign test user to hotspot group
        DB::table('radusergroup')->insert([
            'username' => 'testuser',
            'groupname' => 'hotspot_users',
            'priority' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create default NAS entry
        DB::table('nas')->insert([
            'nasname' => 'localhost',
            'shortname' => 'local',
            'type' => 'other',
            'ports' => null,
            'secret' => 'testing123',
            'community' => null,
            'description' => 'Local NAS',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

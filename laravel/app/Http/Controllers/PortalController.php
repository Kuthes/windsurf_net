<?php

namespace App\Http\Controllers;

use App\Models\RadUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PortalController extends Controller
{
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

        $request->session()->put('portal.uam', $params);

        $nasid = $request->get('nasid');

        $primaryColor = '#2563eb';
        $logoUrl = null;
        $backgroundImageUrl = null;

        if ($nasid) {
            try {
                $venue = DB::table('venue_settings')
                    ->where('is_active', true)
                    ->where(function ($query) use ($nasid) {
                        $query->where('venue_name', $nasid)
                            ->orWhere('nas_ip_address', $nasid);
                    })
                    ->first();

                if ($venue) {
                    $primaryColor = $venue->primary_color_hex ?: $primaryColor;

                    if (!empty($venue->logo_path)) {
                        $logoUrl = str_starts_with($venue->logo_path, 'http') ? $venue->logo_path : asset($venue->logo_path);
                    }

                    if (!empty($venue->background_image_path)) {
                        $backgroundImageUrl = str_starts_with($venue->background_image_path, 'http') ? $venue->background_image_path : asset($venue->background_image_path);
                    }
                }
            } catch (\Throwable $e) {
                // Fall back to defaults.
            }
        }

        return view('portal.login', [
            'params' => $params,
            'logoUrl' => $logoUrl,
            'backgroundImageUrl' => $backgroundImageUrl,
            'primaryColor' => $primaryColor,
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:64'],
            'password' => ['required', 'string'],
            'uamip' => ['nullable', 'string'],
            'uamport' => ['nullable', 'string'],
            'challenge' => ['nullable', 'string'],
        ]);

        $uam = $request->session()->get('portal.uam', []);

        $uamip = $request->input('uamip') ?: ($uam['uamip'] ?? null);
        $uamport = $request->input('uamport') ?: ($uam['uamport'] ?? null);
        $challenge = $request->input('challenge') ?: ($uam['challenge'] ?? null);

        $passwordRecord = RadUser::getPassword($request->string('username'));

        if (!$passwordRecord || !hash_equals((string) $passwordRecord->value, (string) $request->input('password'))) {
            return back()
                ->withErrors(['credentials' => 'Invalid Credentials'])
                ->withInput();
        }

        if (!$uamip || !$uamport) {
            return back()
                ->withErrors(['credentials' => 'Missing gateway parameters (uamip/uamport).'])
                ->withInput();
        }

        if ($uamip === 'mock' || $uamport === 'mock') {
            $query = [
                'username' => $request->input('username'),
                'password' => $request->input('password'),
            ];

            return redirect()->route('mock.logon', $query);
        }

        $baseUrl = sprintf('http://%s:%s/logon', $uamip, $uamport);

        $query = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        if ($challenge) {
            $query['challenge'] = $challenge;
        }

        $url = $baseUrl . '?' . http_build_query($query);

        return redirect($url);
    }

    public function mockRouterLogon(Request $request)
    {
        $username = $request->query('username', '');
        $password = $request->query('password', '');

        $message = sprintf(
            'Simulated Router: Received login request for user %s with password %s',
            $username,
            $password
        );

        return response()->view('portal.mock-logon', [
            'message' => $message,
            'username' => $username,
            'password' => $password,
        ]);
    }
}

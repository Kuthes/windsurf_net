<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Login</title>
    <style>
        body {
            margin: 0;
            font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
            background-color: #0b1220;
            @if(!empty($backgroundImageUrl))
            background-image: url('{{ $backgroundImageUrl }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            @endif
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            width: 100%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.25);
        }

        .logo {
            display: block;
            margin: 0 auto 12px;
            max-height: 64px;
            max-width: 220px;
            object-fit: contain;
        }

        .submit-btn {
            background: {{ $primaryColor ?? '#2563eb' }};
            border: 0;
            color: #fff;
            padding: 10px 14px;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
        }

        .field {
            margin: 12px 0;
        }

        .field input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="card">
        @if(!empty($logoUrl))
            <img class="logo" src="{{ $logoUrl }}" alt="Venue logo" />
        @endif

        <h1 style="margin: 0 0 10px;">Wi-Fi Login</h1>

    @if($errors->has('credentials'))
        <div style="color: red;">
            {{ $errors->first('credentials') }}
        </div>
    @endif

    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

        <form method="POST" action="{{ route('portal.login.submit') }}">
            @csrf

        <input type="hidden" name="uamip" value="{{ $params['uamip'] ?? '' }}" />
        <input type="hidden" name="uamport" value="{{ $params['uamport'] ?? '' }}" />
        <input type="hidden" name="challenge" value="{{ $params['challenge'] ?? '' }}" />

            <div class="field">
                <label for="username">Username</label>
                <input id="username" name="username" type="text" value="{{ old('username') }}" required />
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" required />
            </div>

            <button class="submit-btn" type="submit">Login</button>
        </form>

        <hr />

        <h2>Captured Parameters</h2>
        <pre style="white-space: pre-wrap;">{{ json_encode($params ?? [], JSON_PRETTY_PRINT) }}</pre>
    </div>
</body>
</html>

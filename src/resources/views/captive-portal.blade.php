<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $venueSettings->venue_name ?? 'Hotspot Portal' }} - Login</title>
    
    @if($venueSettings)
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, rgba(0,0,0,0.7), rgba(0,0,0,0.5)), 
                        @if($venueSettings->background_image_path)
                            url('{{ asset($venueSettings->background_image_path) }}')
                        @else
                            linear-gradient(135deg, #667eea 0%, #764ba2 100%)
                        @endif;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 90%;
            text-align: center;
        }
        
        .logo {
            max-width: 200px;
            max-height: 80px;
            margin-bottom: 20px;
            object-fit: contain;
        }
        
        .venue-name {
            font-size: 28px;
            font-weight: bold;
            color: {{ $venueSettings->primary_color_hex ?? '#007bff' }};
            margin-bottom: 10px;
        }
        
        .welcome-message {
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: 500;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
            box-sizing: border-box;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: {{ $venueSettings->primary_color_hex ?? '#007bff' }};
        }
        
        .login-button {
            width: 100%;
            padding: 14px;
            background: {{ $venueSettings->primary_color_hex ?? '#007bff' }};
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }
        
        .login-button:hover {
            background: {{ $venueSettings->primary_color_hex ? $venueSettings->primary_color_hex . 'dd' : '#0056b3' }};
        }
        
        .login-button:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        
        .terms {
            font-size: 12px;
            color: #666;
            margin-top: 20px;
        }
        
        .terms a {
            color: {{ $venueSettings->primary_color_hex ?? '#007bff' }};
            text-decoration: none;
        }
        
        .terms a:hover {
            text-decoration: underline;
        }
        
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        
        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        
        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
                margin: 20px;
            }
            
            .venue-name {
                font-size: 24px;
            }
        }
    </style>
    @else
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .error-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 90%;
            text-align: center;
        }
        
        .error-title {
            color: #dc3545;
            font-size: 24px;
            margin-bottom: 20px;
        }
        
        .error-message {
            color: #666;
            line-height: 1.6;
        }
    </style>
    @endif
</head>
<body>
    @if($venueSettings)
    <div class="login-container">
        @if($venueSettings->logo_path)
            <img src="{{ asset($venueSettings->logo_path) }}" alt="Venue Logo" class="logo">
        @endif
        
        <h1 class="venue-name">{{ $venueSettings->venue_name ?? 'Wi-Fi Hotspot' }}</h1>
        
        @if($venueSettings->welcome_message)
            <p class="welcome-message">{{ $venueSettings->welcome_message }}</p>
        @else
            <p class="welcome-message">Welcome to our Wi-Fi network! Please login to continue.</p>
        @endif
        
        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif
        
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif
        
        <form action="{{ route('captive-portal.login') }}" method="POST">
            @csrf
            <input type="hidden" name="nas_id" value="{{ request('nasId') }}">
            
            <div class="form-group">
                <label for="username">Username or Email</label>
                <input type="text" id="username" name="username" required autocomplete="username" placeholder="Enter your username">
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="Enter your password">
            </div>
            
            <button type="submit" class="login-button">
                Connect to Internet
            </button>
        </form>
        
        <div class="terms">
            By connecting, you agree to our 
            <a href="#" onclick="alert('Terms of Service will be displayed here')">Terms of Service</a> 
            and 
            <a href="#" onclick="alert('Privacy Policy will be displayed here')">Privacy Policy</a>
        </div>
    </div>
    @else
    <div class="error-container">
        <h1 class="error-title">Venue Not Found</h1>
        <p class="error-message">
            Sorry, we couldn't find the venue settings for this hotspot. 
            Please contact the venue administrator or try again later.
        </p>
        <p class="error-message">
            <small>NAS ID: {{ request('nasId') }}</small>
        </p>
    </div>
    @endif
    
    <script>
        // Auto-focus on username field
        document.addEventListener('DOMContentLoaded', function() {
            const usernameField = document.getElementById('username');
            if (usernameField) {
                usernameField.focus();
            }
        });
        
        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            const submitButton = document.querySelector('.login-button');
            
            if (!username || !password) {
                e.preventDefault();
                alert('Please enter both username and password');
                return;
            }
            
            // Disable button to prevent double submission
            submitButton.disabled = true;
            submitButton.textContent = 'Connecting...';
        });
    </script>
</body>
</html>

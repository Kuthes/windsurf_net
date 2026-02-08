<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $venueSettings->venue_name ?? 'Hotspot Portal' }} - Success</title>
    
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
        
        .success-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 90%;
            text-align: center;
        }
        
        .success-icon {
            width: 80px;
            height: 80px;
            background: {{ $venueSettings->primary_color_hex ?? '#007bff' }};
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .success-icon::before {
            content: '✓';
            color: white;
            font-size: 40px;
            font-weight: bold;
        }
        
        .venue-name {
            font-size: 28px;
            font-weight: bold;
            color: {{ $venueSettings->primary_color_hex ?? '#007bff' }};
            margin-bottom: 10px;
        }
        
        .success-message {
            color: #333;
            font-size: 18px;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        .countdown {
            font-size: 16px;
            color: #666;
            margin-bottom: 20px;
        }
        
        .redirect-button {
            background: {{ $venueSettings->primary_color_hex ?? '#007bff' }};
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s;
        }
        
        .redirect-button:hover {
            background: {{ $venueSettings->primary_color_hex ? $venueSettings->primary_color_hex . 'dd' : '#0056b3' }};
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
        
        .success-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 90%;
            text-align: center;
        }
    </style>
    @endif
</head>
<body>
    <div class="success-container">
        <div class="success-icon"></div>
        
        @if($venueSettings)
            <h1 class="venue-name">{{ $venueSettings->venue_name ?? 'Connected!' }}</h1>
        @else
            <h1 class="venue-name">Connected!</h1>
        @endif
        
        <p class="success-message">
            You are now connected to the internet!
        </p>
        
        <p class="countdown" id="countdown">
            Redirecting in <span id="timer">5</span> seconds...
        </p>
        
        <a href="http://www.google.com" class="redirect-button" id="redirectButton">
            Continue to Internet
        </a>
    </div>
    
    <script>
        let countdown = 5;
        const timerElement = document.getElementById('timer');
        const countdownElement = document.getElementById('countdown');
        const redirectButton = document.getElementById('redirectButton');
        
        function updateCountdown() {
            if (countdown > 0) {
                timerElement.textContent = countdown;
                countdown--;
                setTimeout(updateCountdown, 1000);
            } else {
                countdownElement.textContent = 'Redirecting now...';
                window.location.href = 'http://www.google.com';
            }
        }
        
        // Start countdown
        updateCountdown();
        
        // Allow manual redirect
        redirectButton.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = 'http://www.google.com';
        });
    </script>
</body>
</html>

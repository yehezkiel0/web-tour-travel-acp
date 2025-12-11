<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }

        .email-header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            padding: 40px 30px;
            text-align: center;
        }

        .email-header h1 {
            color: #ffffff;
            font-size: 28px;
            margin: 0;
            font-weight: 600;
        }

        .email-header p {
            color: #e0e7ff;
            margin-top: 10px;
            font-size: 14px;
        }

        .email-body {
            padding: 40px 30px;
            background-color: #ffffff;
        }

        .email-content {
            color: #4b5563;
            font-size: 15px;
            line-height: 1.8;
        }

        .email-content p {
            margin-bottom: 15px;
        }

        .email-content a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }

        .email-content a:hover {
            text-decoration: underline;
        }

        .verification-code {
            background-color: #f0f9ff;
            border: 2px solid #3b82f6;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 25px 0;
        }

        .verification-code span {
            font-size: 32px;
            font-weight: bold;
            color: #1e40af;
            letter-spacing: 5px;
            font-family: 'Courier New', monospace;
        }

        .btn {
            display: inline-block;
            padding: 14px 32px;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin: 20px 0;
            transition: transform 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .email-footer {
            background-color: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }

        .email-footer p {
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .social-links {
            margin-top: 20px;
        }

        .social-links a {
            display: inline-block;
            margin: 0 8px;
            color: #6b7280;
            text-decoration: none;
            font-size: 12px;
        }

        .divider {
            height: 1px;
            background-color: #e5e7eb;
            margin: 30px 0;
        }

        @media only screen and (max-width: 600px) {
            .email-header {
                padding: 30px 20px;
            }

            .email-header h1 {
                font-size: 24px;
            }

            .email-body {
                padding: 30px 20px;
            }

            .verification-code span {
                font-size: 24px;
                letter-spacing: 3px;
            }
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <!-- Header -->
        <div class="email-header">
            <h1>🌏 ACP Tours & Travel</h1>
            <p>Your Trusted Travel Partner</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <div class="email-content">
                {!! $body !!}
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p><strong>ACP Tours & Travel</strong></p>
            <p>Making your travel dreams come true</p>

            <div class="divider"></div>

            <p style="font-size: 12px; color: #9ca3af;">
                This is an automated email. Please do not reply to this message.
            </p>

            <p style="font-size: 12px; color: #9ca3af; margin-top: 15px;">
                © {{ date('Y') }} ACP Tours & Travel. All rights reserved.
            </p>

            <div class="social-links">
                <a href="{{ config('app.url') }}">Visit Website</a>
                <span style="color: #d1d5db;">•</span>
                <a href="{{ route('contact') }}">Contact Us</a>
                <span style="color: #d1d5db;">•</span>
                <a href="{{ route('about') }}">About Us</a>
            </div>
        </div>
    </div>
</body>

</html>

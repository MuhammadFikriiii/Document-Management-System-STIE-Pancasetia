<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DMS STIE Pancasetia</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
            background-color: #FFFFFF;
            color: #333;
            overflow: hidden;
        }

        /* --- Left Panel (Red Area) --- */
        .left-panel {
            width: 45%;
            height: 100%;
            background-color: #BA1D2E;
            color: white;
            padding: 40px 50px;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        /* Subtle background circles */
        .left-panel::before {
            content: '';
            position: absolute;
            top: -150px;
            right: -100px;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.04);
            border-radius: 50%;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -200px;
            left: -100px;
            width: 600px;
            height: 600px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
        }

        .logo {
            font-size: 22px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            z-index: 1;
            margin-bottom: 30px;
        }

        .hero-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            z-index: 1;
        }

        .hero-content h1 {
            font-size: 38px;
            line-height: 1.2;
            margin-bottom: 15px;
            font-weight: 700;
            margin-top: -40px;
        }

        .hero-content>p {
            font-size: 16px;
            line-height: 1.5;
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 30px;
            max-width: 90%;
        }

        /* Laptop Vector Illustration */
        .illustration-container {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        .svg-illustration {
            position: relative;
            width: 100%;
            height: 260px;
            max-width: 420px;
            margin: 0 auto;
            transform-origin: center center;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            width: 100%;
            margin-top: 60px;
        }

        .feature {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 0 10px;
        }

        .feature h4 {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .feature p {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.5;
        }

        .footer-text {
            font-size: 12px;
            color: #ffffff;
            z-index: 1;
            margin-top: 30px;
            text-align: center;
            width: 100%;
        }


        /* --- Right Panel (Form Area) --- */
        .right-panel {
            width: 55%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background-color: #FFFFFF;
            overflow: hidden;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
        }

        .login-card h2 {
            font-size: 28px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 8px;
            color: #111;
        }

        .subtitle {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-bottom: 40px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
            color: #333;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper i {
            position: absolute;
            left: 16px;
            color: #999;
            font-size: 16px;
        }

        .input-wrapper .toggle-password {
            position: absolute;
            right: 16px;
            left: auto;
            cursor: pointer;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px 14px 45px;
            border: 1px solid #000;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.2s;
            outline: none;
            color: #333;
        }

        .form-control:focus {
            border-color: #BA1D2E;
            box-shadow: 0 0 0 3px rgba(186, 29, 46, 0.1);
        }

        .form-control::placeholder {
            color: #A0A0A0;
        }

        .forgot-password {
            display: block;
            text-align: right;
            font-size: 13px;
            color: #BA1D2E;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 25px;
            margin-top: -10px;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: #BA1D2E;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: background 0.2s;
        }

        .btn-submit:hover {
            background: #9D1927;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 25px 0;
            color: #000;
            font-size: 13px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #000;
        }

        .divider:not(:empty)::before {
            margin-right: 15px;
        }

        .divider:not(:empty)::after {
            margin-left: 15px;
        }

        .btn-google {
            width: 100%;
            padding: 14px;
            background: white;
            color: #333;
            border: 1px solid #000;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: background 0.2s;
            margin-bottom: 30px;
        }

        .btn-google:hover {
            background: #F9F9F9;
        }



        .contact-admin {
            text-align: center;
            font-size: 13px;
            color: #666;
        }

        .contact-admin a {
            color: #BA1D2E;
            text-decoration: none;
            font-weight: 500;
        }

        .alert-error {
            background: #FFF1F1;
            color: #BA1D2E;
            border: 1px solid #FCD4D4;
            padding: 12px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Responsive Design */
        @media (max-height: 900px) {
            .left-panel {
                padding: 30px 40px;
            }

            .logo {
                margin-bottom: 20px;
                font-size: 20px;
            }

            .hero-content h1 {
                font-size: 32px;
                margin-bottom: 10px;
            }

            .hero-content>p {
                font-size: 15px;
                margin-bottom: 15px;
            }

            .illustration-container {
                margin-bottom: 15px;
            }

            .svg-illustration {
                transform: scale(0.85);
                margin: -20px auto;
            }

            .footer-text {
                margin-top: 15px;
            }

            .login-card {
                max-width: 380px;
            }

            .subtitle {
                margin-bottom: 30px;
            }

            .form-group {
                margin-bottom: 15px;
            }

            .btn-google {
                margin-bottom: 20px;
            }
        }

        @media (max-height: 750px) {
            .left-panel {
                padding: 20px 30px;
            }

            .logo {
                font-size: 18px;
                margin-bottom: 10px;
            }

            .hero-content h1 {
                font-size: 26px;
                margin-bottom: 5px;
            }

            .hero-content>p {
                font-size: 13px;
                margin-bottom: 10px;
            }

            .svg-illustration {
                transform: scale(0.7);
                margin: -40px auto;
            }

            .features {
                gap: 10px;
            }

            .feature .icon {
                font-size: 20px;
            }

            .feature h4 {
                font-size: 13px;
            }

            .feature p {
                font-size: 10px;
            }

            .footer-text {
                margin-top: 10px;
                font-size: 11px;
            }

            .right-panel {
                padding: 20px;
            }

            .login-card h2 {
                font-size: 22px;
                margin-bottom: 4px;
            }

            .subtitle {
                font-size: 13px;
                margin-bottom: 20px;
            }

            .form-control {
                padding: 10px 14px 10px 40px;
                font-size: 14px;
            }

            .btn-submit,
            .btn-google {
                padding: 10px;
                font-size: 14px;
            }

            .divider {
                margin: 15px 0;
            }
        }

        @media (max-height: 600px) {
            .svg-illustration {
                transform: scale(0.55);
                margin: -55px auto;
            }

            .hero-content h1 {
                font-size: 22px;
            }

            .hero-content>p {
                font-size: 12px;
            }

            .logo {
                margin-bottom: 5px;
            }

            .illustration-container {
                margin-bottom: 5px;
            }

            .feature .icon {
                font-size: 16px;
            }

            .feature h4 {
                font-size: 11px;
            }

            .login-card h2 {
                font-size: 18px;
            }

            .subtitle {
                font-size: 11px;
                margin-bottom: 15px;
            }
        }

        @media (max-width: 992px) {
            body {
                flex-direction: column;
                height: 100vh;
                overflow-y: auto;
            }

            .left-panel {
                display: none;
            }

            .right-panel {
                width: 100%;
                height: 100%;
                padding: 40px 20px;
                overflow-y: auto;
            }
        }
    </style>
</head>

<body>

    <!-- Left Panel -->
    <div class="left-panel">
        <div class="logo">
            <i class="fas fa-cloud" style="color: #fff;"></i> STIE Pancasetia
        </div>

        <div class="hero-content">
            <h1>Document Management System</h1>
            <p>Organize, manage, and secure your documents<br>in one centralized platform.</p>

            <div class="illustration-container">
                <!-- Pure HTML/CSS Vector Graphic -->
                <div class="svg-illustration">
                    <!-- Cloud -->
                    <svg style="position: absolute; right: 20px; top: -10px; width: 140px; opacity: 0.2;"
                        viewBox="0 0 24 24" fill="white">
                        <path
                            d="M17.5 19c2.485 0 4.5-2.015 4.5-4.5 0-2.312-1.736-4.217-3.984-4.476C17.487 6.643 14.545 4 11 4 7.134 4 4 7.134 4 11c0 .233.011.463.033.688C1.782 12.19 0 14.167 0 16.5 0 19.015 2.015 21 4.5 21h13V19z" />
                    </svg>
                    <i class="fas fa-arrows-up-down"
                        style="position: absolute; right: 75px; top: 18px; font-size: 26px; color: white; opacity: 0.2;"></i>

                    <!-- Laptop -->
                    <div
                        style="position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); width: 280px; z-index: 2;">
                        <!-- Screen -->
                        <div
                            style="background: #2D2D2D; padding: 8px; border-radius: 12px 12px 0 0; box-shadow: 0 15px 30px rgba(0,0,0,0.2);">
                            <div style="background: #F8F9FA; height: 160px; border-radius: 4px; display: flex;">
                                <!-- Sidebar -->
                                <div
                                    style="width: 45px; background: #2D2D2D; border-radius: 4px 0 0 4px; padding: 12px 0; display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                    <div style="width: 18px; height: 18px; background: #555; border-radius: 50%;"></div>
                                    <div
                                        style="width: 20px; height: 20px; background: #BA1D2E; border-radius: 4px; margin-top: 8px;">
                                    </div>
                                    <div
                                        style="width: 14px; height: 3px; background: #666; margin-top: 8px; border-radius: 2px;">
                                    </div>
                                    <div style="width: 14px; height: 3px; background: #666; border-radius: 2px;"></div>
                                    <div style="width: 14px; height: 3px; background: #666; border-radius: 2px;"></div>
                                </div>
                                <!-- Main Content -->
                                <div
                                    style="flex: 1; position: relative; display: flex; align-items: center; justify-content: center; border-left: 1px solid #EAEAEA;">
                                    <!-- Header Dots -->
                                    <div
                                        style="position: absolute; top: 0; left: 0; right: 0; height: 24px; border-bottom: 1px solid #EAEAEA; display: flex; align-items: center; padding: 0 12px; gap: 5px;">
                                        <div style="width: 7px; height: 7px; background: #D0D0D0; border-radius: 50%;">
                                        </div>
                                        <div style="width: 7px; height: 7px; background: #D0D0D0; border-radius: 50%;">
                                        </div>
                                        <div style="width: 7px; height: 7px; background: #D0D0D0; border-radius: 50%;">
                                        </div>
                                    </div>

                                    <!-- Red Folder Icon -->
                                    <svg width="110" height="90" viewBox="0 0 24 24" fill="#BA1D2E"
                                        style="margin-top: 15px;">
                                        <path
                                            d="M10 4H4C2.89 4 2.01 4.89 2.01 6L2 18C2 19.1 2.89 20 4 20H20C21.1 20 22 19.1 22 18V8C22 6.9 21.1 6 20 6H12L10 4Z" />
                                        <path d="M22 8V18C22 19.1 21.1 20 20 20H4V8H22Z" fill="#9D1927" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <!-- Keyboard Base -->
                        <div
                            style="background: #111; height: 14px; border-radius: 0 0 16px 16px; position: relative; width: 330px; margin-left: -25px; box-shadow: 0 10px 20px rgba(0,0,0,0.3);">
                            <div
                                style="position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 50px; height: 4px; background: #333; border-radius: 0 0 4px 4px;">
                            </div>
                        </div>
                        <!-- Keyboard Lip -->
                        <div
                            style="background: #000; height: 4px; border-radius: 0 0 6px 6px; width: 310px; margin-left: -15px;">
                        </div>
                    </div>

                    <!-- Floating Document Left -->
                    <div
                        style="position: absolute; left: 5px; bottom: 50px; background: white; padding: 15px; border-radius: 8px; box-shadow: 0 12px 25px rgba(0,0,0,0.15); z-index: 3; width: 65px; height: 85px;">
                        <div
                            style="width: 100%; height: 4px; background: #BA1D2E; margin-bottom: 10px; border-radius: 2px;">
                        </div>
                        <div
                            style="width: 100%; height: 3px; background: #E0E0E0; margin-bottom: 8px; border-radius: 2px;">
                        </div>
                        <div
                            style="width: 80%; height: 3px; background: #E0E0E0; margin-bottom: 8px; border-radius: 2px;">
                        </div>
                        <div
                            style="width: 90%; height: 3px; background: #E0E0E0; margin-bottom: 8px; border-radius: 2px;">
                        </div>
                        <div style="width: 70%; height: 3px; background: #E0E0E0; border-radius: 2px;"></div>
                    </div>

                    <!-- Floating Shield Right -->
                    <div
                        style="position: absolute; right: 10px; bottom: 35px; background: #9D1927; width: 75px; height: 90px; clip-path: polygon(50% 0%, 100% 20%, 100% 70%, 50% 100%, 0% 70%, 0% 20%); display: flex; align-items: center; justify-content: center; box-shadow: 0 12px 30px rgba(0,0,0,0.25); z-index: 3;">
                        <div
                            style="background: #BA1D2E; width: 65px; height: 80px; clip-path: polygon(50% 0%, 100% 20%, 100% 70%, 50% 100%, 0% 70%, 0% 20%); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-lock" style="color: white; font-size: 28px;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="features">
                <div class="feature">
                    <div class="text">
                        <h4>Secure</h4>
                        <p>Your data is protected<br>with enterprise security</p>
                    </div>
                </div>
                <div class="feature">
                    <div class="text">
                        <h4>Organized</h4>
                        <p>Easily categorize and<br>find documents</p>
                    </div>
                </div>
                <div class="feature">
                    <div class="text">
                        <h4>Efficient</h4>
                        <p>Access anytime,<br>anywhere</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-text">
            &copy; 2026 STIE Pancasetia. All rights reserved.
        </div>
    </div>

    <!-- Right Panel -->
    <div class="right-panel">
        <div class="login-card">
            <h2>Welcome Back!</h2>
            <p class="subtitle">Sign in to continue to your account</p>

            @if($errors->any())
                <div class="alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Email Address</label>
                    <div class="input-wrapper">
                        <i class="far fa-user"></i>
                        <input type="email" name="email" class="form-control" placeholder="Enter your email"
                            value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Enter your password" required>
                        <i class="far fa-eye-slash toggle-password" onclick="togglePassword()"></i>
                    </div>
                </div>

                <a href="#" class="forgot-password">Forgot your password?</a>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-lock"></i> Sign In
                </button>
            </form>

            <div class="divider">or</div>

            <button type="button" class="btn-google">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="18px" height="18px">
                    <path fill="#EA4335"
                        d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                    <path fill="#4285F4"
                        d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z" />
                    <path fill="#FBBC05"
                        d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z" />
                    <path fill="#34A853"
                        d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                </svg>
                Sign in with Google
            </button>

            <div class="contact-admin">
                Don't have an account? <a href="#">Contact your administrator</a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            }
        }
    </script>
</body>

</html>
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Klinik Meow</title>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        .forgot-card {
            width: 420px;
            max-width: 90%;
        }

        .forgot-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 20px;
            background: #E8F5F4;
            color: #2FA6A0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .forgot-card h2 {
            text-align: center;
            color: #123B52;
            margin-bottom: 10px;
        }

        .forgot-card .description {
            text-align: center;
            color: #71808C;
            font-size: 14px;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .forgot-button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 8px;
            background: #2FA6A0;
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .forgot-button:hover {
            background: #258C87;
        }

        .back-login {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #2FA6A0;
            text-decoration: none;
            font-size: 14px;
        }

        .back-login:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="login-container">

    <div class="login-card forgot-card">

        <div class="forgot-icon">
            <i class="fa-solid fa-lock"></i>
        </div>

        <h2>Forgot Password?</h2>

        <p class="description">
            Enter your Staff ID to reset your password.
        </p>

        <form action="forgot_password_process.php" method="POST">

            <div class="input-box">
                <i class="fa-solid fa-id-card"></i>

                <input
                    type="text"
                    name="staff_id"
                    placeholder="Enter your Staff ID"
                    required
                >
            </div>

            <button type="submit" class="forgot-button">
                Reset Password
            </button>

        </form>

        <a href="login.php" class="back-login">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Login
        </a>

    </div>

</div>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klinik Meow Inventory System</title>

    <!-- CSS -->
   <link rel="stylesheet" href="assets/css/style.css?v=3">

   <style>
    body {
        background-image: url("assets/images/login-bg.png") !important;
        background-size: cover !important;
        background-position: center !important;
        background-repeat: no-repeat !important;
        background-attachment: fixed !important;
        min-height: 100vh !important;
    }

    .login-container {
        min-height: 100vh;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        padding: 40px 8vw 40px 40px;
        position: relative;
        z-index: 2;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.94);
        backdrop-filter: blur(8px);
    }
</style>

   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
.login-card {
    width: 650px !important;
    max-width: 90% !important;
    padding: 50px 60px !important;
}
</style>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>

<div class="overlay"></div>

<div class="login-container">
    

    <div class="login-card">

        <div class="logo">

            <i class="fa-solid fa-paw"></i>

            <h1>KLINIK MEOW</h1>

            <p>Veterinary Medicine Inventory System</p>

        </div>

        <h2>Welcome To Klinik Meow</h2>

        <p class="subtitle">
            Please login to access your account.
        </p>

        <form action="login_process.php" method="POST">

            <label>Staff ID</label>

            <div class="input-box">

                <i class="fa-solid fa-user"></i>

                <input
                    type="text"
                    name="staffid"
                    placeholder="Enter your staff Id"
                    required>

            </div>

            <label>Password</label>

            <div class="input-box">

                <i class="fa-solid fa-lock"></i>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter your password"
                    required>

                <i
                class="fa-solid fa-eye toggle-password"
                onclick="togglePassword()"></i>

            </div>

            <div class="remember">

                <label>

                    <input type="checkbox">

                    Remember Me

                </label>

<a href="forgot_password.php" class="forgot-password">
        Forgot Password?
    </a>               
    

            </div>

            <button type="submit">

                <i class="fa-solid fa"></i>

                Log In

            </button>

        </form>

        <div class="footer">

            © 2026 Klinik Meow Inventory System

        </div>

    </div>

</div>

<script src="assets/js/script.js"></script>

<?php

if (isset($_GET['error'])) {

    if ($_GET['error'] == 'wrong_password') {

        echo "
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Login Failed',
            text: 'Wrong Password',
            confirmButtonText: 'Try Again',
            confirmButtonColor: '#2FA6A0'
        });
        </script>
        ";

    }

    elseif ($_GET['error'] == 'wrong_login') {

        echo "
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Login Failed',
            text: 'Wrong Staff ID',
            confirmButtonText: 'Try Again',
            confirmButtonColor: '#2FA6A0'
        });
        </script>
        ";

    }

}

?>

</body>
</html>
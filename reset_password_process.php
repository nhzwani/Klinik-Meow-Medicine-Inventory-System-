<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("config/database.php");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: forgot_password.php");
    exit();
}

$staff_id = $_POST['staff_id'] ?? '';
$new_password = $_POST['new_password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';


// Check password match
if ($new_password !== $confirm_password) {

    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>

    <script>
        Swal.fire({
            icon: 'error',
            title: 'Password Mismatch',
            text: 'New password and confirm password do not match.',
            confirmButtonText: 'Try Again',
            confirmButtonColor: '#2FA6A0'
        }).then(function() {
            window.history.back();
        });
    </script>

    </body>
    </html>
    ";

    exit();
}


// Check Staff ID
$check_sql = "SELECT user_id FROM user WHERE staff_id = '$staff_id'";
$check_result = mysqli_query($conn, $check_sql);

if (!$check_result) {
    die("Database Error: " . mysqli_error($conn));
}

if (mysqli_num_rows($check_result) == 0) {

    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>

    <script>
        Swal.fire({
            icon: 'error',
            title: 'Staff ID Not Found',
            text: 'The Staff ID does not exist.',
            confirmButtonText: 'Try Again',
            confirmButtonColor: '#2FA6A0'
        }).then(function() {
            window.location.href = 'forgot_password.php';
        });
    </script>

    </body>
    </html>
    ";

    exit();
}


// Update password
$update_sql = "UPDATE user
               SET password = '$new_password'
               WHERE staff_id = '$staff_id'";

if (mysqli_query($conn, $update_sql)) {

    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>

    <script>
        Swal.fire({
            icon: 'success',
            title: 'Password Reset Successful!',
            text: 'Your password has been updated successfully.',
            confirmButtonText: 'Login',
            confirmButtonColor: '#2FA6A0'
        }).then(function() {
            window.location.href = 'login.php';
        });
    </script>

    </body>
    </html>
    ";

} else {

    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>

    <script>
        Swal.fire({
            icon: 'error',
            title: 'Reset Failed',
            text: 'Unable to update your password.',
            confirmButtonText: 'Try Again',
            confirmButtonColor: '#2FA6A0'
        }).then(function() {
            window.location.href = 'forgot_password.php';
        });
    </script>

    </body>
    </html>
    ";
}

mysqli_close($conn);

?>
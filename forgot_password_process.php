<?php

include("config/database.php");

$staff_id = $_POST['staff_id'];

// Check Staff ID
$sql = "SELECT * FROM user WHERE staff_id='$staff_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {

    // Staff ID exists
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Reset Password - Klinik Meow</title>

        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

        <link rel="stylesheet" href="assets/css/style.css">

        <style>
            .reset-card {
                width: 420px;
                max-width: 90%;
            }

            .reset-icon {
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

            .reset-card h2 {
                text-align: center;
                color: #123B52;
                margin-bottom: 10px;
            }

            .description {
                text-align: center;
                color: #71808C;
                font-size: 14px;
                margin-bottom: 25px;
            }

            .reset-button {
                width: 100%;
                padding: 13px;
                border: none;
                border-radius: 8px;
                background: #2FA6A0;
                color: white;
                font-size: 15px;
                font-weight: 600;
                cursor: pointer;
            }

            .reset-button:hover {
                background: #258C87;
            }
        </style>
    </head>

    <body>

    <div class="login-container">

        <div class="login-card reset-card">

            <div class="reset-icon">
                <i class="fa-solid fa-key"></i>
            </div>

            <h2>Reset Password</h2>

            <p class="description">
                Create a new password for your account.
            </p>

            <form action="reset_password_process.php" method="POST">

                <input type="hidden" name="staff_id"
                       value="<?php echo htmlspecialchars($staff_id); ?>">

                <div class="input-box">
                    <i class="fa-solid fa-lock"></i>

                    <input
                        type="password"
                        name="new_password"
                        placeholder="Enter new password"
                        required
                    >
                </div>

                <div class="input-box">
                    <i class="fa-solid fa-lock"></i>

                    <input
                        type="password"
                        name="confirm_password"
                        placeholder="Confirm new password"
                        required
                    >
                </div>

                <button type="submit" class="reset-button">
                    <i class="fa-solid fa-check"></i>
                    Reset Password
                </button>

            </form>

        </div>

    </div>

    </body>
    </html>

    <?php

} else {

    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>

    <script>
        Swal.fire({
            icon: 'error',
            title: 'Staff ID Not Found',
            text: 'Please check your Staff ID and try again.',
            confirmButtonText: 'Try Again',
            confirmButtonColor: '#2FA6A0'
        }).then(() => {
            window.location.href = 'forgot_password.php';
        });
    </script>
    ";

}

mysqli_close($conn);

?>
<?php
session_start();

include("config/database.php");

// Pastikan Staff sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Pastikan hanya Staff boleh masuk
if ($_SESSION['role'] != "Staff") {
    header("Location: owner_dashboard.php");
    exit();
}

// Tentukan page
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Staff Dashboard | Klinik Meow</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Dashboard CSS -->
    <link rel="stylesheet"
      href="assets/css/dashboard.css?v=3">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>


<body>


<!-- =========================
     SIDEBAR
========================= -->

<div class="sidebar">

    <div class="logo">

        <i class="fa-solid fa-cat"></i>

        <h2>Klinik Meow</h2>

    </div>


    <ul>

        <!-- Dashboard -->

        <li>

            <a href="staff_dashboard.php?page=dashboard"
               class="<?php if($page == 'dashboard') echo 'active'; ?>">

                <i class="fa-solid fa-house"></i>

                Dashboard

            </a>

        </li>


<li>
    <a href="staff_dashboard.php?page=add_medicine"
       class="<?php if($page == 'add_medicine') echo 'active'; ?>">

        <i class="fa-solid fa-plus"></i>

        Add Medicine

    </a>
</li>

        <!-- Manage Medicine -->

        <li>

            <a href="staff_dashboard.php?page=manage_medicine"
               class="<?php if($page == 'manage_medicine') echo 'active'; ?>">

                <i class="fa-solid fa-pills"></i>

                Manage Medicine

            </a>

        </li>

<!-- Purchase Request -->

        <li>

            <a href="staff_dashboard.php?page=purchase_request"
               class="<?php if($page == 'purchase_request') echo 'active'; ?>">

                <i class="fa-solid fa-cart-shopping"></i>

                Purchase Request

            </a>

        </li>
        


        <!-- Stock Movement -->

        <li>

            <a href="staff_dashboard.php?page=stock_movement"
               class="<?php if($page == 'stock_movement') echo 'active'; ?>">

                <i class="fa-solid fa-arrow-right-arrow-left"></i>

                Stock Movement

            </a>

        </li>


        <!-- Log Out -->

        <li>

            <a href="#"
               onclick="confirmLogout(); return false;">

                <i class="fa-solid fa-right-from-bracket"></i>

                Log Out

            </a>

        </li>

</div>



<!-- =========================
     MAIN CONTENT
========================= -->

<div class="main-content">


    <!-- TOP BAR -->

    <div class="topbar">

        <h2>Clinic Staff Dashboard</h2>


        <div class="user-info">

            <span>

                <strong>Staff ID:</strong>

                <?php echo $_SESSION['staff_id']; ?>

            </span>


            <span>

                <strong>Role:</strong>

                <?php echo $_SESSION['role']; ?>

            </span>

        </div>

    </div>



    <!-- CONTENT -->

    <div class="content">

        <?php

        switch($page) {


            // =========================
            // DASHBOARD
            // =========================

            case "dashboard":

                include("pages/staff_dashboard_home.php");

                break;


            case "add_medicine":
                
                  include("pages/add_medicine.php");

                   break;
            // =========================
            // MANAGE MEDICINE
            // =========================

            case "manage_medicine":

                include("pages/manage_medicine.php");

                break;



            // =========================
            // STOCK MOVEMENT
            // =========================

            case "stock_movement":

                include("pages/staff_stock_movement.php");

                break;



            // =========================
            // PURCHASE REQUEST
            // =========================

            case "purchase_request":

                include("pages/staff_purchase_request.php");

                break;


            case "cat_case":

                include("pages/cat_case.php");

                break;
            // =========================
            // DEFAULT
            // =========================

            default:

                include("pages/staff_dashboard_home.php");

                break;

        }

        ?>

    </div>

</div>



<!-- =========================
     LOGOUT SCRIPT
========================= -->

<script>

function confirmLogout() {

    Swal.fire({

        title: 'Log Out?',

        text: 'Are you sure you want to log out?',

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#2E5AAC',

        cancelButtonColor: '#d33',

        confirmButtonText: 'Yes',

        cancelButtonText: 'Cancel',

        reverseButtons: false

    }).then((result) => {

        if (result.isConfirmed) {

            window.location.href = 'logout.php';

        }

    });

}

<?php if(isset($_GET['login']) && $_GET['login'] == 'success'): ?>

Swal.fire({
    icon: 'success',
    title: 'Login Successful!',
    text: 'Welcome to Klinik Meow.',
    confirmButtonColor: '#2FA6A0',
    confirmButtonText: 'Continue'
});

<?php endif; ?>


<?php if(isset($_GET['success']) && $_GET['success'] == 'medicine_added'): ?>

Swal.fire({
    icon: 'success',
    title: 'Medicine Added!',
    text: 'Medicine has been added successfully.',
    confirmButtonColor: '#2FA6A0',
    confirmButtonText: 'Continue'
});

<?php endif; ?>

<?php if(isset($_GET['success']) && $_GET['success'] == 'stock_movement'): ?>

Swal.fire({
    icon: 'success',
    title: 'Stock Movement Recorded!',
    text: 'Stock movement recorded successfully.',
    confirmButtonColor: '#2FA6A0',
    confirmButtonText: 'Continue'
});

<?php endif; ?>

<?php if(isset($_GET['success']) && $_GET['success'] == 'case_added'): ?>

Swal.fire({
    icon: 'success',
    title: 'Cat Case Recorded!',
    text: 'The cat case has been recorded successfully.',
    confirmButtonColor: '#2FA6A0',
    confirmButtonText: 'Continue'
});

<?php endif; ?>

</script>

</body>

</html>
<?php
session_start();

include("config/database.php");

// Pastikan hanya Owner boleh masuk
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != "Owner") {
    header("Location: staff_dashboard.php");
    exit();
}

// Tentukan page yang hendak dipaparkan
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard | Klinik Meow</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Dashboard CSS -->
    <link rel="stylesheet" href="assets/css/dashboard.css?v=2">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

<div class="sidebar">

    <div class="logo">
        <i class="fa-solid fa-cat"></i>
        <h2>Klinik Meow</h2>
    </div>

    <ul>

        <!-- Dashboard -->
        <li>
            <a href="owner_dashboard.php?page=dashboard"
               class="<?php if($page == 'dashboard') echo 'active'; ?>">
                <i class="fa-solid fa-house"></i>
                Dashboard
            </a>
        </li>


        <!-- Register Staff -->
        <li>
            <a href="owner_dashboard.php?page=register_staff"
               class="<?php if($page == 'register_staff') echo 'active'; ?>">
                <i class="fa-solid fa-user-plus"></i>
                Register Staff
            </a>
        </li>


        <!-- Request Approval -->
        <li>
            <a href="owner_dashboard.php?page=request_approval"
               class="<?php if($page == 'request_approval') echo 'active'; ?>">
                <i class="fa-solid fa-cart-shopping"></i>
                 Request Approval
            </a>
        </li>


        <!-- View Inventory -->
        <li>
            <a href="owner_dashboard.php?page=view_inventory"
               class="<?php if($page == 'view_inventory') echo 'active'; ?>">
                <i class="fa-solid fa-boxes-stacked"></i>
                View Inventory
            </a>
        </li>


        <!-- Stock Movement -->
        <li>
            <a href="owner_dashboard.php?page=stock_movement"
               class="<?php if($page == 'stock_movement') echo 'active'; ?>">
                <i class="fa-solid fa-arrow-right-arrow-left"></i>
                Stock Movement
            </a>
        </li>


        <!-- Generate Reports -->
        <li>
            <a href="owner_dashboard.php?page=reports"
               class="<?php if($page == 'reports') echo 'active'; ?>">
                <i class="fa-solid fa-chart-column"></i>
                Generate Reports
            </a>
        </li>


        <!-- Log Out -->
     <li>
    <a href="#" onclick="confirmLogout(); return false;">
         <i class="fa-solid fa-right-from-bracket"></i>
        Log Out
    </a>
</li>

    </ul>

</div>

<div class="main-content">

    <div class="topbar">

        <h2>Clinic Owner Dashboard</h2>

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

    <div class="content">

        <?php

      switch($page){

    case "register_staff":
        include("pages/register_staff.php");
        break;

    case "request_approval":
        include("pages/request_approval.php");
        break;

    case "view_inventory":
        include("pages/view_inventory.php");
        break;

    case "stock_movement":
        include("pages/stock_movement.php");
        break;

    case "reports":
        include("pages/reports.php");
        break;

    default:
        include("pages/dashboard.php");
        break;
}

        ?>

    </div>

</div>

<script>

function confirmLogout(){

    Swal.fire({

        title: 'Log Out',
        text: 'Are you sure you want to log out?',
        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#2E5AAC',
        cancelButtonColor: '#d33',

        confirmButtonText: 'Yes, Log Out',
        cancelButtonText: 'Cancel',

        reverseButtons: true

    }).then((result) => {

        if(result.isConfirmed){

            window.location.href = "logout.php";

        }

    });

}


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
    confirmButtonColor: '#2E5AAC',
    confirmButtonText: 'Continue'
});

<?php if (isset($_GET['success']) && $_GET['success'] == 'registered') { ?>

<script>
Swal.fire({
    icon: 'success',
    title: 'Success!',
    text: 'Staff registered successfully!',
    confirmButtonText: 'OK'
});
</script>

<?php } ?>
<?php endif; ?>

</script>

</body>
</html>
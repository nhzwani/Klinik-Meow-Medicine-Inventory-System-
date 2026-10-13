<?php

// ===============================
// TOTAL MEDICINES
// ===============================

$query_medicine = "SELECT COUNT(*) AS total FROM medicine";

$result_medicine = mysqli_query($conn, $query_medicine);

$total_medicines = 0;

if ($result_medicine) {
    $row = mysqli_fetch_assoc($result_medicine);
    $total_medicines = $row['total'];
}


// ===============================
// LOW STOCK
// ===============================

$query_low_stock = "
    SELECT COUNT(*) AS total
    FROM medicine
    WHERE quantity < 10
";

$result_low_stock = mysqli_query($conn, $query_low_stock);

$low_stock = 0;

if ($result_low_stock) {
    $row = mysqli_fetch_assoc($result_low_stock);
    $low_stock = $row['total'];
}


// ===============================
// TOTAL STOCK
// ===============================

$query_stock = "
    SELECT SUM(quantity) AS total
    FROM medicine
";

$result_stock = mysqli_query($conn, $query_stock);

$total_stock = 0;

if ($result_stock) {
    $row = mysqli_fetch_assoc($result_stock);
    $total_stock = $row['total'] ?? 0;
}

?>

<div class="dashboard-page">

    <!-- DASHBOARD TITLE -->

    <div class="dashboard-title">

        <h1>Dashboard</h1>

        <p>
            Welcome to Klinik Meow Inventory Management System
        </p>

    </div>


    <!-- SUMMARY CARDS -->

    <div class="dashboard-cards">


        <!-- TOTAL MEDICINES -->

        <div class="dashboard-card">

            <div class="card-icon">

                <i class="fa-solid fa-pills"></i>

            </div>

            <div class="card-info">

                <h3>
                    <?php echo $total_medicines; ?>
                </h3>

                <p>Total Medicines</p>

            </div>

        </div>


        <!-- LOW STOCK -->

        <div class="dashboard-card">

            <div class="card-icon warning">

                <i class="fa-solid fa-triangle-exclamation"></i>

            </div>

            <div class="card-info">

                <h3>
                    <?php echo $low_stock; ?>
                </h3>

                <p>Low Stock</p>

            </div>

        </div>


        <!-- TOTAL STOCK -->

        <div class="dashboard-card">

            <div class="card-icon stock">

                <i class="fa-solid fa-boxes-stacked"></i>

            </div>

            <div class="card-info">

                <h3>
                    <?php echo $total_stock; ?>
                </h3>

                <p>Total Stock</p>

            </div>

        </div>


        <!-- PURCHASE REQUEST -->

        <div class="dashboard-card">

            <div class="card-icon request">

                <i class="fa-solid fa-cart-shopping"></i>

            </div>

            <div class="card-info">

                <h3>0</h3>

                <p>My Purchase Requests</p>

            </div>

        </div>

    </div>

    <!-- RECORD CAT CASE -->

            <a href="staff_dashboard.php?page=cat_case"
               style="text-decoration:none;">

                <div class="dashboard-card">

                    <div class="card-icon">

                        <i class="fa-solid fa-cat"></i>

                    </div>

                    <div class="card-info">

                        <h3 style="font-size:18px;">
                            Record Cat Case
                        </h3>

                        <p>
                            Record cat conditions
                        </p>

                    </div>

                </div>

            </a>


        </div>

    </div>

    <!-- QUICK ACTIONS -->

    <div class="dashboard-section">

        <div class="section-header">

            <h2>Quick Actions</h2>

        </div>


        <div class="dashboard-cards">


            <!-- MANAGE MEDICINE -->

            <a href="staff_dashboard.php?page=manage_medicine"
               style="text-decoration:none;">

                <div class="dashboard-card">

                    <div class="card-icon">

                        <i class="fa-solid fa-pills"></i>

                    </div>

                    <div class="card-info">

                        <h3 style="font-size:18px;">
                            Manage Medicine
                        </h3>


                    </div>

                </div>

            </a>


            <!-- STOCK MOVEMENT -->

            <a href="staff_dashboard.php?page=stock_movement"
               style="text-decoration:none;">

                <div class="dashboard-card">

                    <div class="card-icon stock">

                        <i class="fa-solid fa-arrow-right-arrow-left"></i>

                    </div>

                    <div class="card-info">

                        <h3 style="font-size:18px;">
                            Stock Movement
                        </h3>

                    </div>

                </div>

            </a>


            <!-- PURCHASE REQUEST -->

            <a href="staff_dashboard.php?page=purchase_request"
               style="text-decoration:none;">

                <div class="dashboard-card">

                    <div class="card-icon request">

                        <i class="fa-solid fa-cart-shopping"></i>

                    </div>

                    <div class="card-info">

                        <h3 style="font-size:18px;">
                            Purchase Request
                        </h3>

                    </div>

                </div>

            </a>


        </div>

    </div>

</div>
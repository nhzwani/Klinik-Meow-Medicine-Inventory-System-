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


// ===============================
// PENDING PURCHASE REQUESTS
// ===============================

$query_pending = "
    SELECT COUNT(*) AS total
    FROM purchase_request
    WHERE status = 'Pending'
";

$result_pending = mysqli_query($conn, $query_pending);

$pending_requests = 0;

if ($result_pending) {
    $row = mysqli_fetch_assoc($result_pending);
    $pending_requests = $row['total'];
}


// ===============================
// RECENT STOCK MOVEMENT
// ===============================

$query_movement = "
    SELECT
        medicine.medicine_name,
        medicine_record.movement_type,
        medicine_record.quantity,
        medicine_record.date_added
    FROM medicine_record
    INNER JOIN medicine
        ON medicine_record.medicine_id = medicine.medicine_id
    ORDER BY
        medicine_record.date_added DESC,
        medicine_record.record_id DESC
    LIMIT 5
";

$result_movement = mysqli_query($conn, $query_movement);


$query_common_condition = "
    SELECT
        condition_name,
        COUNT(*) AS total_cases
    FROM cat_case
    GROUP BY condition_name
    ORDER BY total_cases DESC
    LIMIT 5
";

$result_common_condition = mysqli_query(
    $conn,
    $query_common_condition
);

// ===============================
// MOST USED MEDICINE
// ===============================

$query_most_used = "
    SELECT
        medicine.medicine_name,
        SUM(medicine_record.quantity) AS total_used
    FROM medicine_record
    INNER JOIN medicine
        ON medicine_record.medicine_id = medicine.medicine_id
    WHERE medicine_record.movement_type = 'OUT'
    GROUP BY medicine_record.medicine_id
    ORDER BY total_used DESC
    LIMIT 1
";

$result_most_used = mysqli_query($conn, $query_most_used);



// ===============================
// LEAST USED MEDICINE
// ===============================

$query_least_used = "
    SELECT
        medicine.medicine_name,
        SUM(medicine_record.quantity) AS total_used
    FROM medicine_record
    INNER JOIN medicine
        ON medicine_record.medicine_id = medicine.medicine_id
    WHERE medicine_record.movement_type = 'OUT'
    GROUP BY medicine_record.medicine_id
    ORDER BY total_used ASC
    LIMIT 1
";

$result_least_used = mysqli_query($conn, $query_least_used);
?>

<?php

// Most Used Medicine
$usage_query = "
    SELECT 
        medicine.medicine_name,
        SUM(medicine_record.quantity) AS total_used
    FROM medicine_record
    INNER JOIN medicine 
        ON medicine_record.medicine_id = medicine.medicine_id
    WHERE medicine_record.movement_type = 'OUT'
    GROUP BY medicine_record.medicine_id
    ORDER BY total_used DESC
    LIMIT 5
";

$usage_result = mysqli_query($conn, $usage_query);

$usage_labels = [];
$usage_data = [];

while ($row = mysqli_fetch_assoc($usage_result)) {
    $usage_labels[] = $row['medicine_name'];
    $usage_data[] = $row['total_used'];
}
?>

<?php

// Expiry Analytics

$expired_query = "
    SELECT COUNT(*) AS total
    FROM medicine
    WHERE expiry_date < CURDATE()
";

$expiring_query = "
    SELECT COUNT(*) AS total
    FROM medicine
    WHERE expiry_date >= CURDATE()
    AND expiry_date <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)
";

$safe_query = "
    SELECT COUNT(*) AS total
    FROM medicine
    WHERE expiry_date > DATE_ADD(CURDATE(), INTERVAL 30 DAY)
";

$expired_count = mysqli_fetch_assoc(mysqli_query($conn, $expired_query))['total'];
$expiring_count = mysqli_fetch_assoc(mysqli_query($conn, $expiring_query))['total'];
$safe_count = mysqli_fetch_assoc(mysqli_query($conn, $safe_query))['total'];

?>

<?php

$condition_query = "
    SELECT 
        condition_name,
        COUNT(*) AS total_cases
    FROM cat_case
    GROUP BY condition_name
    ORDER BY total_cases DESC
    LIMIT 5
";

$condition_result = mysqli_query($conn, $condition_query);

$condition_labels = [];
$condition_data = [];

while ($row = mysqli_fetch_assoc($condition_result)) {
    $condition_labels[] = $row['condition_name'];
    $condition_data[] = $row['total_cases'];
}

?>

<?php

$movement_query = "
    SELECT 
        DATE_FORMAT(date_added, '%Y-%m') AS month,
        SUM(CASE WHEN movement_type = 'IN' THEN quantity ELSE 0 END) AS stock_in,
        SUM(CASE WHEN movement_type = 'OUT' THEN quantity ELSE 0 END) AS stock_out
    FROM medicine_record
    GROUP BY DATE_FORMAT(date_added, '%Y-%m')
    ORDER BY month ASC
";

$movement_result = mysqli_query($conn, $movement_query);

$movement_labels = [];
$stock_in_data = [];
$stock_out_data = [];

while ($row = mysqli_fetch_assoc($movement_result)) {
    $movement_labels[] = $row['month'];
    $stock_in_data[] = $row['stock_in'];
    $stock_out_data[] = $row['stock_out'];
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


        <!-- PENDING PURCHASE REQUEST -->

        <div class="dashboard-card">

            <div class="card-icon request">

                <i class="fa-solid fa-cart-shopping"></i>

            </div>

            <div class="card-info">

                <h3>
                    <?php echo $pending_requests; ?>
                </h3>

                <p>Pending Purchase Requests</p>

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

    </div>

<?php



$most_used_name = "No Data";
$most_used_quantity = 0;

if ($result_most_used && mysqli_num_rows($result_most_used) > 0) {

    $most_used = mysqli_fetch_assoc($result_most_used);

    $most_used_name = $most_used['medicine_name'];
    $most_used_quantity = $most_used['total_used'];
}


$least_used_name = "No Data";
$least_used_quantity = 0;

if ($result_least_used && mysqli_num_rows($result_least_used) > 0) {

    $least_used = mysqli_fetch_assoc($result_least_used);

    $least_used_name = $least_used['medicine_name'];
    $least_used_quantity = $least_used['total_used'];
}

?>

<div style="
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-top: 24px;
">

    <!-- MOST USED -->
    <div class="dashboard-card">

        <div class="card-icon">
            <i class="fa-solid fa-arrow-trend-up"></i>
        </div>

        <div class="card-info">

            <h3 style="font-size: 20px;">
                <?php echo htmlspecialchars($most_used_name); ?>
            </h3>

            <p>
                Most Used Medicine
                (<?php echo $most_used_quantity; ?> units)
            </p>

        </div>

    </div>


    <!-- LEAST USED -->
    <div class="dashboard-card">

        <div class="card-icon warning">
            <i class="fa-solid fa-arrow-trend-down"></i>
        </div>

        <div class="card-info">

            <h3 style="font-size: 20px;">
                <?php echo htmlspecialchars($least_used_name); ?>
            </h3>

            <p>
                Least Used Medicine
                (<?php echo $least_used_quantity; ?> units)
            </p>

        </div>

    </div>

</div>

<div class="analytics-grid">

    <div class="analytics-card">
        <h3>Most Used Medicine</h3>
        <canvas id="usageChart"></canvas>
    </div>

    <div class="analytics-card">
        <h3>Stock Movement</h3>
        <canvas id="movementChart"></canvas>
    </div>

    <div class="analytics-card">
        <h3>Expiry Status</h3>
        <canvas id="expiryChart"></canvas>
    </div>

    <div class="analytics-card">
        <h3>Common Cat Conditions</h3>
        <canvas id="conditionChart"></canvas>
    </div>

</div>

<div class="dashboard-section" style="margin-top: 20px;">

    <div class="section-header">
        <h2>Common Cat Conditions</h2>
    </div>

    <div class="table-container">

        <table>

            <thead>
                <tr>
                    <th>Condition</th>
                    <th>Total Cases</th>
                </tr>
            </thead>

            <tbody>

            <?php

            if (
                $result_common_condition &&
                mysqli_num_rows($result_common_condition) > 0
            ) {

                while ($condition = mysqli_fetch_assoc($result_common_condition)) {

            ?>

                <tr>

                    <td>
                        <strong>
                            <?php
                            echo htmlspecialchars(
                                $condition['condition_name']
                            );
                            ?>
                        </strong>
                    </td>

                    <td>
                        <?php
                        echo $condition['total_cases'];
                        ?> cases
                    </td>

                </tr>

            <?php

                }

            } else {

            ?>

                <tr>
                    <td colspan="2" class="no-data">
                        No cat case records found.
                    </td>
                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

    <!-- ===================================
         RECENT STOCK MOVEMENT
    ==================================== -->

    <div class="dashboard-section">

        <div class="section-header">

            <h2>Recent Stock Movement</h2>

            <a href="owner_dashboard.php?page=stock_movement">
                View All
            </a>

        </div>

        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>Medicine</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Date</th>

                    </tr>

                </thead>

                <tbody>

                <?php

                if ($result_movement && mysqli_num_rows($result_movement) > 0) {

                    while ($movement = mysqli_fetch_assoc($result_movement)) {

                ?>

                    <tr>

                        <!-- MEDICINE -->

                        <td>

                            <strong>
                                <?php
                                echo htmlspecialchars(
                                    $movement['medicine_name']
                                );
                                ?>
                            </strong>

                        </td>


                        <!-- TYPE -->

                        <td>

                            <?php if ($movement['movement_type'] == 'IN') { ?>

                                <span class="status-in">
                                    Stock In
                                </span>

                            <?php } else { ?>

                                <span class="status-out">
                                    Stock Out
                                </span>

                            <?php } ?>

                        </td>


                        <!-- QUANTITY -->

                        <td>

                            <?php

                            if ($movement['movement_type'] == 'IN') {

                                echo "+" . $movement['quantity'];

                            } else {

                                echo "-" . $movement['quantity'];

                            }

                            ?>

                        </td>


                        <!-- DATE -->

                        <td>

                            <?php

                            echo date(
                                "d/m/Y",
                                strtotime($movement['date_added'])
                            );

                            ?>

                        </td>

                    </tr>

                <?php

                    }

                } else {

                ?>

                    <tr>

                        <td colspan="4" class="no-data">

                            No stock movement recorded yet.

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>


    <!-- ===================================
         PURCHASE REQUESTS
    ==================================== -->

    <div class="dashboard-section">

        <div class="section-header">

            <h2>Purchase Requests</h2>

            <a href="owner_dashboard.php?page=request_approval">
                View All
            </a>

        </div>


        <?php

        // Get latest purchase requests
        $query_requests = "
            SELECT
                purchase_request.request_id,
                medicine.medicine_name,
                purchase_request.quantity,
                purchase_request.request_date,
                purchase_request.status
            FROM purchase_request
            INNER JOIN medicine
                ON purchase_request.medicine_id = medicine.medicine_id
            ORDER BY purchase_request.request_date DESC
            LIMIT 5
        ";

        $result_requests = mysqli_query($conn, $query_requests);

        ?>


        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>Medicine</th>
                        <th>Quantity</th>
                        <th>Date</th>
                        <th>Status</th>

                    </tr>

                </thead>


                <tbody>

                <?php

                if ($result_requests && mysqli_num_rows($result_requests) > 0) {

                    while ($request = mysqli_fetch_assoc($result_requests)) {

                ?>

                    <tr>

                        <td>

                            <strong>
                                <?php
                                echo htmlspecialchars(
                                    $request['medicine_name']
                                );
                                ?>
                            </strong>

                        </td>


                        <td>
                            <?php echo $request['quantity']; ?>
                        </td>


                        <td>

                            <?php

                            echo date(
                                "d/m/Y",
                                strtotime($request['request_date'])
                            );

                            ?>

                        </td>


                        <td>

                            <?php if ($request['status'] == 'Approved') { ?>

                                <span class="status-in">
                                    Approved
                                </span>

                            <?php } elseif ($request['status'] == 'Rejected') { ?>

                                <span class="status-out">
                                    Rejected
                                </span>

                            <?php } else { ?>

                                <span class="status-pending">
                                    Pending
                                </span>

                            <?php } ?>

                        </td>

                    </tr>

                <?php

                    }

                } else {

                ?>

                    <tr>

                        <td colspan="4" class="no-data">

                            No Purchase Requests

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>


</div>

<script>

// Most Used Medicine
new Chart(document.getElementById('usageChart'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($usage_labels); ?>,
        datasets: [{
            label: 'Units Used',
            data: <?php echo json_encode($usage_data); ?>
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});


// Stock Movement
new Chart(document.getElementById('movementChart'), {
    type: 'line',
    data: {
        labels: <?php echo json_encode($movement_labels); ?>,
        datasets: [
            {
                label: 'Stock In',
                data: <?php echo json_encode($stock_in_data); ?>,
                tension: 0.3
            },
            {
                label: 'Stock Out',
                data: <?php echo json_encode($stock_out_data); ?>,
                tension: 0.3
            }
        ]
    },
    options: {
        responsive: true
    }
});


// Expiry Status
new Chart(document.getElementById('expiryChart'), {
    type: 'doughnut',
    data: {
        labels: ['Expired', 'Expiring Soon', 'Safe'],
        datasets: [{
            data: [
                <?php echo $expired_count; ?>,
                <?php echo $expiring_count; ?>,
                <?php echo $safe_count; ?>
            ]
        }]
    },
    options: {
        responsive: true
    }
});


// Common Cat Conditions
new Chart(document.getElementById('conditionChart'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($condition_labels); ?>,
        datasets: [{
            label: 'Number of Cases',
            data: <?php echo json_encode($condition_data); ?>
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

</script>
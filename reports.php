<?php

// =====================================
// REPORT TYPE
// =====================================

$report_type = isset($_GET['report']) ? $_GET['report'] : 'inventory';


// =====================================
// INVENTORY REPORT
// =====================================

if ($report_type == "inventory") {

    $query = "
        SELECT
            medicine_code,
            medicine_name,
            category,
            dosage,
            price,
            quantity,
            expiry_date
        FROM medicine
        ORDER BY medicine_name ASC
    ";

    $result = mysqli_query($conn, $query);
}


// =====================================
// LOW STOCK REPORT
// =====================================

elseif ($report_type == "low_stock") {

    $query = "
        SELECT
            medicine_code,
            medicine_name,
            category,
            dosage,
            quantity,
            expiry_date
        FROM medicine
        WHERE quantity < 10
        ORDER BY quantity ASC
    ";

    $result = mysqli_query($conn, $query);
}


// =====================================
// STOCK MOVEMENT REPORT
// =====================================

elseif ($report_type == "stock_movement") {

    $query = "
        SELECT
            medicine.medicine_name,
            medicine_record.movement_type,
            medicine_record.quantity,
            medicine_record.date_added,
            medicine_record.staff_id
        FROM medicine_record
        INNER JOIN medicine
            ON medicine_record.medicine_id = medicine.medicine_id
        ORDER BY medicine_record.date_added DESC
    ";

    $result = mysqli_query($conn, $query);
}


// =====================================
// PURCHASE REQUEST REPORT
// =====================================

elseif ($report_type == "purchase_requests") {

    $query = "
        SELECT
            purchase_request.request_id,
            medicine.medicine_name,
            purchase_request.staff_id,
            purchase_request.quantity,
            medicine.price,
            (purchase_request.quantity * medicine.price) AS total_cost,
            purchase_request.reason,
            purchase_request.request_date,
            purchase_request.status
        FROM purchase_request
        INNER JOIN medicine
            ON purchase_request.medicine_id = medicine.medicine_id
        ORDER BY purchase_request.request_date DESC
    ";

    $result = mysqli_query($conn, $query);
}

?>


<div class="dashboard-page">

    <!-- =====================================
         PAGE TITLE
    ====================================== -->

    <div class="dashboard-title">

        <h1>Generate Reports</h1>

    </div>


    <!-- =====================================
         REPORT OPTIONS
    ====================================== -->

    <div class="dashboard-section">

        <div class="section-header">

            <h2>Select Report</h2>

        </div>


        <div class="report-buttons">

            <a
                href="owner_dashboard.php?page=reports&report=inventory"
                class="report-button"
            >

                <i class="fa-solid fa-boxes-stacked"></i>

                Inventory Report

            </a>


            <a
                href="owner_dashboard.php?page=reports&report=low_stock"
                class="report-button"
            >

                <i class="fa-solid fa-triangle-exclamation"></i>

                Low Stock Report

            </a>


            <a
                href="owner_dashboard.php?page=reports&report=stock_movement"
                class="report-button"
            >

                <i class="fa-solid fa-arrow-right-arrow-left"></i>

                Stock Movement Report

            </a>


            <a
                href="owner_dashboard.php?page=reports&report=purchase_requests"
                class="report-button"
            >

                <i class="fa-solid fa-cart-shopping"></i>

                Purchase Request Report

            </a>

        </div>

    </div>


    <!-- =====================================
         REPORT TABLE
    ====================================== -->

    <div class="dashboard-section">

        <div class="section-header">

            <h2>

                <?php

                if ($report_type == "inventory") {

                    echo "Inventory Report";

                } elseif ($report_type == "low_stock") {

                    echo "Low Stock Report";

                } elseif ($report_type == "stock_movement") {

                    echo "Stock Movement Report";

                } elseif ($report_type == "purchase_requests") {

                    echo "Purchase Request Report";

                }

                ?>

            </h2>


            <button
                type="button"
                onclick="window.print()"
                class="print-button"
            >

                <i class="fa-solid fa-print"></i>

                Print Report

            </button>

        </div>


        <div class="table-container">

            <table>


                <!-- =====================================
                     INVENTORY
                ====================================== -->

                <?php if ($report_type == "inventory") { ?>

                    <thead>

                        <tr>

                            <th>Code</th>
                            <th>Medicine</th>
                            <th>Category</th>
                            <th>Dosage</th>
                            <th>Price (RM)</th>
                            <th>Total Cost (RM)</th>
                            <th>Stock</th>
                            <th>Expiry Date</th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php

                    if ($result && mysqli_num_rows($result) > 0) {

                        while ($row = mysqli_fetch_assoc($result)) {

                    ?>

                            <tr>

                                <td>
                                    <?php
                                    echo htmlspecialchars($row['medicine_code']);
                                    ?>
                                </td>


                                <td>

                                    <strong>
                                        <?php
                                        echo htmlspecialchars($row['medicine_name']);
                                        ?>
                                    </strong>

                                </td>


                                <td>
                                    <?php
                                    echo htmlspecialchars($row['category']);
                                    ?>
                                </td>


                                <td>
                                    <?php
                                    echo htmlspecialchars($row['dosage']);
                                    ?>
                                </td>


                                <td>
                                    RM <?php
                                    echo number_format($row['price'], 2);
                                    ?>
                                </td>


                                <td>
                                    RM <?php
                                    echo number_format(
                                        $row['price'] * $row['quantity'],
                                        2
                                    );
                                    ?>
                                </td>


                                <td>
                                    <?php
                                    echo $row['quantity'];
                                    ?>
                                </td>


                                <td>

                                    <?php

                                    echo date(
                                        "d/m/Y",
                                        strtotime($row['expiry_date'])
                                    );

                                    ?>

                                </td>

                            </tr>

                    <?php

                        }

                    } else {

                    ?>

                        <tr>

                            <td colspan="8" class="no-data">

                                No medicine records found.

                            </td>

                        </tr>

                    <?php } ?>

                    </tbody>


                <!-- =====================================
                     LOW STOCK
                ====================================== -->

                <?php } elseif ($report_type == "low_stock") { ?>

                    <thead>

                        <tr>

                            <th>Code</th>
                            <th>Medicine</th>
                            <th>Category</th>
                            <th>Dosage</th>
                            <th>Stock</th>
                            <th>Expiry Date</th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php

                    if ($result && mysqli_num_rows($result) > 0) {

                        while ($row = mysqli_fetch_assoc($result)) {

                    ?>

                            <tr>

                                <td>
                                    <?php
                                    echo htmlspecialchars($row['medicine_code']);
                                    ?>
                                </td>


                                <td>

                                    <strong>
                                        <?php
                                        echo htmlspecialchars($row['medicine_name']);
                                        ?>
                                    </strong>

                                </td>


                                <td>
                                    <?php
                                    echo htmlspecialchars($row['category']);
                                    ?>
                                </td>


                                <td>
                                    <?php
                                    echo htmlspecialchars($row['dosage']);
                                    ?>
                                </td>


                                <td>

                                    <span class="status-out">

                                        <?php
                                        echo $row['quantity'];
                                        ?>

                                    </span>

                                </td>


                                <td>

                                    <?php

                                    echo date(
                                        "d/m/Y",
                                        strtotime($row['expiry_date'])
                                    );

                                    ?>

                                </td>

                            </tr>

                    <?php

                        }

                    } else {

                    ?>

                        <tr>

                            <td colspan="6" class="no-data">

                                No low stock medicines.

                            </td>

                        </tr>

                    <?php } ?>

                    </tbody>


                <!-- =====================================
                     STOCK MOVEMENT
                ====================================== -->

                <?php } elseif ($report_type == "stock_movement") { ?>

                    <thead>

                        <tr>

                            <th>Medicine</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Date</th>
                            <th>Staff ID</th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php

                    if ($result && mysqli_num_rows($result) > 0) {

                        while ($row = mysqli_fetch_assoc($result)) {

                    ?>

                            <tr>

                                <td>

                                    <strong>
                                        <?php
                                        echo htmlspecialchars($row['medicine_name']);
                                        ?>
                                    </strong>

                                </td>


                                <td>

                                    <?php if ($row['movement_type'] == "IN") { ?>

                                        <span class="status-in">
                                            Stock In
                                        </span>

                                    <?php } else { ?>

                                        <span class="status-out">
                                            Stock Out
                                        </span>

                                    <?php } ?>

                                </td>


                                <td>

                                    <?php

                                    echo (
                                        $row['movement_type'] == "IN"
                                        ? "+"
                                        : "-"
                                    );

                                    echo $row['quantity'];

                                    ?>

                                </td>


                                <td>

                                    <?php

                                    echo date(
                                        "d/m/Y",
                                        strtotime($row['date_added'])
                                    );

                                    ?>

                                </td>


                                <td>

                                    <?php
                                    echo htmlspecialchars($row['staff_id']);
                                    ?>

                                </td>

                            </tr>

                    <?php

                        }

                    } else {

                    ?>

                        <tr>

                            <td colspan="5" class="no-data">

                                No stock movement recorded yet.

                            </td>

                        </tr>

                    <?php } ?>

                    </tbody>


                <!-- =====================================
                     PURCHASE REQUEST
                ====================================== -->

                <?php } elseif ($report_type == "purchase_requests") { ?>

                    <thead>

                        <tr>

                            <th>Request ID</th>
                            <th>Medicine</th>
                            <th>Staff ID</th>
                            <th>Quantity</th>
                            <th>Unit Price (RM)</th>
                            <th>Total Cost (RM)</th>
                            <th>Reason</th>
                            <th>Date</th>
                            <th>Status</th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php

                    if ($result && mysqli_num_rows($result) > 0) {

                        while ($row = mysqli_fetch_assoc($result)) {

                    ?>

                            <tr>

                                <!-- REQUEST ID -->
                                <td>
                                    <?php
                                    echo htmlspecialchars($row['request_id']);
                                    ?>
                                </td>


                                <!-- MEDICINE -->
                                <td>

                                    <strong>
                                        <?php
                                        echo htmlspecialchars($row['medicine_name']);
                                        ?>
                                    </strong>

                                </td>


                                <!-- STAFF ID -->
                                <td>
                                    <?php
                                    echo htmlspecialchars($row['staff_id']);
                                    ?>
                                </td>


                                <!-- QUANTITY -->
                                <td>
                                    <?php
                                    echo htmlspecialchars($row['quantity']);
                                    ?>
                                </td>


                                <!-- UNIT PRICE -->
                                <td>
                                    RM <?php
                                    echo number_format($row['price'], 2);
                                    ?>
                                </td>


                                <!-- TOTAL COST -->
                                <td>
                                    RM <?php
                                    echo number_format($row['total_cost'], 2);
                                    ?>
                                </td>


                                <!-- REASON -->
                                <td>
                                    <?php
                                    echo htmlspecialchars($row['reason']);
                                    ?>
                                </td>


                                <!-- DATE -->
                                <td>

                                    <?php

                                    echo date(
                                        "d/m/Y",
                                        strtotime($row['request_date'])
                                    );

                                    ?>

                                </td>


                                <!-- STATUS -->
                                <td>

                                    <?php if ($row['status'] == "Approved") { ?>

                                        <span class="status-in">
                                            Approved
                                        </span>

                                    <?php } elseif ($row['status'] == "Rejected") { ?>

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

                            <td colspan="9" class="no-data">

                                No purchase requests found.

                            </td>

                        </tr>

                    <?php } ?>

                    </tbody>

                <?php } ?>


            </table>

        </div>

    </div>

</div>
<?php

// Get all medicine inventory

$query = "SELECT 
            medicine_id,
            medicine_name,
            category,
            price,
            dosage,
            quantity,
            expiry_date
          FROM medicine
          ORDER BY medicine_name ASC";

$result = mysqli_query($conn, $query);

?>

<div class="dashboard-page">

    <!-- PAGE TITLE -->

    <div class="dashboard-title">

        <h1>Medicine Inventory</h1>


    </div>


    <!-- INVENTORY TABLE -->

    <div class="dashboard-section">

        <div class="section-header">

            <h2>Current Medicine Inventory</h2>

        </div>


        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>Code</th>
                        <th>Medicine Name</th>
                        <th>Category</th>                   
                        <th>Dosage</th>
                        <th>Price (RM)</th>
                        <th>Stock</th>
                        <th>Expiry Date</th>
                        <th>Status</th>

                    </tr>

                </thead>


                <tbody>

                <?php

                if ($result && mysqli_num_rows($result) > 0) {

                    while ($medicine = mysqli_fetch_assoc($result)) {

                        // Stock status

                        if ($medicine['quantity'] <= 0) {

                            $stock_status = "Out of Stock";

                        } elseif ($medicine['quantity'] < 10) {

                            $stock_status = "Low Stock";

                        } else {

                            $stock_status = "In Stock";

                        }


                        // Expiry status

                        $today = date("Y-m-d");

                        if ($medicine['expiry_date'] < $today) {

                            $expiry_status = "Expired";

                        } else {

                            $expiry_status = "Valid";

                        }

                ?>

                    <tr>

                        <!-- MEDICINE CODE -->

                        <td>
                            <?php echo htmlspecialchars($medicine['medicine_id']); ?>
                        </td>


                        <!-- MEDICINE NAME -->

                        <td>
                            <strong>
                                <?php echo htmlspecialchars($medicine['medicine_name']); ?>
                            </strong>
                        </td>


                        <!-- CATEGORY -->

                        <td>
                            <?php echo htmlspecialchars($medicine['category']); ?>
                        </td>

                        <!-- DOSAGE -->

                        <td>
                            <?php echo htmlspecialchars($medicine['dosage']); ?>
                        </td>
                       
                         <!-- PRICE -->
                        <td>
                      <?php echo number_format($medicine['price'], 2); ?>
                        </td>


                        <!-- STOCK -->

                        <td>
                            <?php echo $medicine['quantity']; ?>
                        </td>


                        <!-- EXPIRY -->

                        <td>

                            <?php
                            echo date(
                                "d/m/Y",
                                strtotime($medicine['expiry_date'])
                            );
                            ?>

                        </td>


                        <!-- STATUS -->

                        <td>

                            <?php if ($stock_status == "In Stock") { ?>

                                <span class="inventory-status in-stock">
                                    In Stock
                                </span>

                            <?php } elseif ($stock_status == "Low Stock") { ?>

                                <span class="inventory-status low-stock">
                                    Low Stock
                                </span>

                            <?php } else { ?>

                                <span class="inventory-status out-stock">
                                    Out of Stock
                                </span>

                            <?php } ?>


                            <?php if ($expiry_status == "Expired") { ?>

                                <br>

                                <span class="inventory-status expired">
                                    Expired
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

                            <i class="fa-solid fa-box-open"></i>

                            <br><br>

                            No medicine records found.

                        </td>

                    </tr>

                <?php

                }

                ?>

                </tbody>

            </table>

        </div>

    </div>

</div>
<?php

$query = "
    SELECT
        medicine_record.record_id,
        medicine.medicine_name,
        medicine_record.quantity,
        medicine_record.movement_type,
        medicine_record.date_added,
        medicine_record.staff_id
    FROM medicine_record
    INNER JOIN medicine
        ON medicine_record.medicine_id = medicine.medicine_id
    ORDER BY medicine_record.date_added DESC,
             medicine_record.record_id DESC
";

$result = mysqli_query($conn, $query);

?>

<div class="dashboard-page">

    <!-- PAGE TITLE -->

    <div class="dashboard-title">

        <h1>Stock Movement</h1>

    </div>


    <!-- STOCK MOVEMENT TABLE -->

    <div class="dashboard-section">

        <div class="section-header">

            <h2>Medicine Stock Movement</h2>

        </div>


        <div class="table-container">

            <table>

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

                    while ($movement = mysqli_fetch_assoc($result)) {

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

                            <?php

                            if ($movement['movement_type'] == "IN") {

                            ?>

                                <span class="status-in">

                                    <i class="fa-solid fa-arrow-down"></i>

                                    Stock In

                                </span>

                            <?php

                            } else {

                            ?>

                                <span class="status-out">

                                    <i class="fa-solid fa-arrow-up"></i>

                                    Stock Out

                                </span>

                            <?php

                            }

                            ?>

                        </td>


                        <!-- QUANTITY -->

                        <td>

                            <?php

                            if ($movement['movement_type'] == "IN") {

                                echo "+";

                            } else {

                                echo "-";

                            }

                            echo $movement['quantity'];

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


                        <!-- STAFF -->

                        <td>

                            <?php
                            echo htmlspecialchars(
                                $movement['staff_id']
                            );
                            ?>

                        </td>

                    </tr>

                <?php

                    }

                } else {

                ?>

                    <tr>

                        <td colspan="5" class="no-data">

                            <i class="fa-solid fa-arrows-rotate"></i>

                            <br><br>

                            No stock movement recorded yet.

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
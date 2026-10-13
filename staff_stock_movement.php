<?php

// =====================================
// GET MEDICINE LIST
// =====================================

$query_medicine = "
    SELECT 
        medicine_id,
        medicine_code,
        medicine_name,
        quantity
    FROM medicine
    ORDER BY medicine_name ASC
";

$result_medicine = mysqli_query($conn, $query_medicine);


// =====================================
// PROCESS STOCK MOVEMENT
// =====================================

if (isset($_POST['save_movement'])) {

    $medicine_id  = intval($_POST['medicine_id']);
    $movement_type = $_POST['movement_type'];
    $quantity     = intval($_POST['quantity']);

    // Get Staff ID
    $staff_id = $_SESSION['staff_id'];


    // =====================================
    // BASIC VALIDATION
    // =====================================

    if ($quantity <= 0) {

        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Invalid Quantity',
                text: 'Quantity must be greater than 0.',
                confirmButtonColor: '#2FA6A0'
            });
        </script>
        ";

    } elseif ($movement_type != "IN" && $movement_type != "OUT") {

        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Invalid Movement',
                text: 'Please select Stock In or Stock Out.',
                confirmButtonColor: '#2FA6A0'
            });
        </script>
        ";

    } else {


        // =====================================
        // GET CURRENT STOCK
        // =====================================

        $query_current = "
            SELECT quantity
            FROM medicine
            WHERE medicine_id = '$medicine_id'
        ";

        $result_current = mysqli_query($conn, $query_current);

        $medicine = mysqli_fetch_assoc($result_current);


        if (!$medicine) {

            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Medicine Not Found',
                    text: 'The selected medicine could not be found.',
                    confirmButtonColor: '#2FA6A0'
                });
            </script>
            ";

        } else {

            $current_stock = intval($medicine['quantity']);


            // =====================================
            // STOCK OUT VALIDATION
            // =====================================

            if (
                $movement_type == "OUT" &&
                $quantity > $current_stock
            ) {

                echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Insufficient Stock',
                        text: 'Stock Out quantity cannot be greater than current stock.',
                        confirmButtonColor: '#2FA6A0'
                    });
                </script>
                ";

            } else {


                // =====================================
                // CALCULATE NEW STOCK
                // =====================================

                if ($movement_type == "IN") {

                    $new_stock = $current_stock + $quantity;

                } else {

                    $new_stock = $current_stock - $quantity;

                }


                // =====================================
                // UPDATE MEDICINE STOCK
                // =====================================

                $update_stock = "
                    UPDATE medicine
                    SET quantity = '$new_stock'
                    WHERE medicine_id = '$medicine_id'
                ";

                $update_result = mysqli_query($conn, $update_stock);


                if ($update_result) {


                    // =====================================
                    // INSERT STOCK MOVEMENT RECORD
                    // =====================================

                    $insert_record = "
                        INSERT INTO medicine_record
                        (
                            medicine_id,
                            movement_type,
                            staff_id,
                            quantity,
                            date_added
                        )
                        VALUES
                        (
                            '$medicine_id',
                            '$movement_type',
                            '$staff_id',
                            '$quantity',
                            CURDATE()
                        )
                    ";

                    $record_result = mysqli_query(
                        $conn,
                        $insert_record
                    );


                    if ($record_result) {

                        // =====================================
                        // SUCCESS
                        // =====================================

                        header(
                            "Location: staff_dashboard.php?page=stock_movement&success=stock_movement"
                        );

                        exit();

                    } else {

                        echo "
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Record Failed',
                                text: 'Stock was updated but the movement record could not be saved.',
                                confirmButtonColor: '#2FA6A0'
                            });
                        </script>
                        ";

                    }

                } else {

                    echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Update Failed',
                            text: 'Medicine stock could not be updated.',
                            confirmButtonColor: '#2FA6A0'
                        });
                    </script>
                    ";

                }

            }

        }

    }

}


// =====================================
// GET STOCK MOVEMENT HISTORY
// =====================================

$query_history = "
    SELECT
        mr.record_id,
        m.medicine_code,
        m.medicine_name,
        mr.movement_type,
        mr.quantity,
        mr.staff_id,
        mr.date_added
    FROM medicine_record mr
    INNER JOIN medicine m
        ON mr.medicine_id = m.medicine_id
    ORDER BY mr.record_id DESC
";

$result_history = mysqli_query(
    $conn,
    $query_history
);

?>


<div class="dashboard-page">


    <!-- =====================================
         PAGE HEADER
    ====================================== -->

    <div class="dashboard-title">

        <div>

            <h1>Stock Movement</h1>

            <p>
                Record and monitor medicine stock movement.
            </p>

        </div>

    </div>



    <!-- =====================================
         STOCK MOVEMENT FORM
    ====================================== -->

    <div class="dashboard-section">

        <div class="section-header">

            <h2>Record Stock Movement</h2>

        </div>


        <form method="POST">


            <!-- MEDICINE -->

            <div class="form-group">

                <label>
                    Medicine
                </label>

                <select
                    name="medicine_id"
                    required
                >

                    <option value="">
                        Select Medicine
                    </option>


                    <?php

                    if (
                        $result_medicine &&
                        mysqli_num_rows($result_medicine) > 0
                    ) {

                        while (
                            $medicine = mysqli_fetch_assoc(
                                $result_medicine
                            )
                        ) {

                    ?>

                        <option
                            value="<?php echo $medicine['medicine_id']; ?>"
                        >

                            <?php

                            echo htmlspecialchars(
                                $medicine['medicine_code']
                                . " - "
                                . $medicine['medicine_name']
                            );

                            ?>

                            (Stock:
                            <?php echo $medicine['quantity']; ?>)

                        </option>

                    <?php

                        }

                    }

                    ?>

                </select>

            </div>



            <!-- MOVEMENT TYPE -->

            <div class="form-group">

                <label>
                    Movement Type
                </label>

                <select
                    name="movement_type"
                    required
                >

                    <option value="">
                        Select Movement Type
                    </option>

                    <option value="IN">
                        Stock In
                    </option>

                    <option value="OUT">
                        Stock Out
                    </option>

                </select>

            </div>



            <!-- QUANTITY -->

            <div class="form-group">

                <label>
                    Quantity
                </label>

                <input
                    type="number"
                    name="quantity"
                    min="1"
                    required
                    placeholder="Enter quantity"
                >

            </div>



            <!-- SUBMIT -->

            <button
                type="submit"
                name="save_movement"
                class="btn-primary"
            >

                <i class="fa-solid fa-plus"></i>

                Record Movement

            </button>


        </form>

    </div>



    <!-- =====================================
         STOCK MOVEMENT HISTORY
    ====================================== -->

    <div class="dashboard-section">

        <div class="section-header">

            <h2>Stock Movement History</h2>

        </div>


        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>Code</th>

                        <th>Medicine</th>

                        <th>Type</th>

                        <th>Quantity</th>

                        <th>Staff ID</th>

                        <th>Date</th>

                    </tr>

                </thead>


                <tbody>


                <?php

                if (
                    $result_history &&
                    mysqli_num_rows($result_history) > 0
                ) {

                    while (
                        $movement = mysqli_fetch_assoc(
                            $result_history
                        )
                    ) {

                ?>

                    <tr>


                        <!-- CODE -->

                        <td>

                            <?php

                            echo htmlspecialchars(
                                $movement['medicine_code']
                            );

                            ?>

                        </td>



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

                            if (
                                $movement['movement_type'] == "IN"
                            ) {

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

                            if (
                                $movement['movement_type'] == "IN"
                            ) {

                                echo "+";

                            } else {

                                echo "-";

                            }

                            echo $movement['quantity'];

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



                        <!-- DATE -->

                        <td>

                            <?php

                            echo date(
                                "d/m/Y",
                                strtotime(
                                    $movement['date_added']
                                )
                            );

                            ?>

                        </td>


                    </tr>


                <?php

                    }

                } else {

                ?>


                    <tr>

                        <td
                            colspan="6"
                            class="no-data"
                        >

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



<!-- =====================================
     SWEETALERT SUCCESS
====================================== -->

<?php

if (
    isset($_GET['success']) &&
    $_GET['success'] == 'stock_movement'
) {

?>

<script>

Swal.fire({

    icon: 'success',

    title: 'Stock Movement Recorded!',

    text: 'The stock movement has been recorded successfully.',

    confirmButtonColor: '#2FA6A0',

    confirmButtonText: 'Continue'

});

</script>

<?php

}

?>
<?php

// ===============================
// GET MEDICINE LIST
// ===============================

$query_medicine = "
    SELECT medicine_id, medicine_code, medicine_name, quantity
    FROM medicine
    ORDER BY medicine_name ASC
";

$result_medicine = mysqli_query($conn, $query_medicine);


// ===============================
// SUBMIT PURCHASE REQUEST
// ===============================

if (isset($_POST['submit_request'])) {

    $medicine_id = $_POST['medicine_id'];
    $quantity = (int) $_POST['quantity'];
    $reason = trim($_POST['reason']);

    $staff_id = $_SESSION['staff_id'];


    // ===============================
    // VALIDATION
    // ===============================

    if ($quantity <= 0) {

        echo "
        <script>
            alert('Quantity must be greater than 0.');
            window.location.href='staff_dashboard.php?page=purchase_request';
        </script>
        ";

        exit();
    }


    if (empty($reason)) {

        echo "
        <script>
            alert('Please enter a reason for the purchase request.');
            window.location.href='staff_dashboard.php?page=purchase_request';
        </script>
        ";

        exit();
    }


    // ===============================
    // INSERT REQUEST
    // ===============================

    $query_insert = "
        INSERT INTO purchase_request
        (
            medicine_id,
            staff_id,
            quantity,
            reason,
            status,
            request_date
        )
        VALUES
        (
            '$medicine_id',
            '$staff_id',
            '$quantity',
            '" . mysqli_real_escape_string($conn, $reason) . "',
            'Pending',
            CURDATE()
        )
    ";


    if (mysqli_query($conn, $query_insert)) {

       header("Location: staff_dashboard.php?page=purchase_request&success=request_submitted");
       exit();

        exit();

    } else {

        echo "
        <script>
            alert('Failed to submit purchase request.');
            window.location.href='staff_dashboard.php?page=purchase_request';
        </script>
        ";

        exit();
    }
}


// ===============================
// GET STAFF REQUEST HISTORY
// ===============================

$query_history = "
    SELECT
        pr.request_id,
        m.medicine_code,
        m.medicine_name,
        pr.quantity,
        pr.reason,
        pr.status,
        pr.request_date
    FROM purchase_request pr

    INNER JOIN medicine m
        ON pr.medicine_id = m.medicine_id

    WHERE pr.staff_id = '" . mysqli_real_escape_string($conn, $_SESSION['staff_id']) . "'

    ORDER BY pr.request_id DESC
";

$result_history = mysqli_query($conn, $query_history);

?>


<div class="dashboard-page">


    <!-- ===============================
         PAGE HEADER
    =============================== -->

    <div class="dashboard-title">

        <div>

            <h1>Purchase Request</h1>

            <p>
                Submit medicine purchase requests for owner approval.
            </p>

        </div>

    </div>


    <!-- ===============================
         REQUEST FORM
    =============================== -->

    <div class="dashboard-section">

        <div class="section-header">

            <h2>New Purchase Request</h2>

        </div>


        <form method="POST">


            <!-- Medicine -->

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

                    if ($result_medicine) {

                        while (
                            $medicine =
                            mysqli_fetch_assoc($result_medicine)
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

                            (Current Stock:
                            <?php echo $medicine['quantity']; ?>)

                        </option>

                    <?php

                        }

                    }

                    ?>

                </select>

            </div>


            <!-- Quantity -->

            <div class="form-group">

                <label>
                    Requested Quantity
                </label>

                <input
                    type="number"
                    name="quantity"
                    min="1"
                    required
                    placeholder="Enter quantity"
                >

            </div>


            <!-- Reason -->

            <div class="form-group">

                <label>
                    Reason
                </label>

               <textarea
    name="reason"
    rows="4"
    placeholder="Enter reason for purchase request"
    required
></textarea>

            </div>


            <!-- Submit -->

            <button
                type="submit"
                name="submit_request"
                class="btn-primary"
            >
                Submit Request

            </button>


        </form>

    </div>



    <!-- ===============================
         REQUEST HISTORY
    =============================== -->

    <div class="dashboard-section">

        <div class="section-header">

            <h2>My Purchase Requests</h2>

        </div>


        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>Request ID</th>

                        <th>Medicine</th>

                        <th>Quantity</th>

                        <th>Reason</th>

                        <th>Date</th>

                        <th>Status</th>

                    </tr>

                </thead>


                <tbody>

                <?php

                if (
                    $result_history &&
                    mysqli_num_rows($result_history) > 0
                ) {

                    while (
                        $request =
                        mysqli_fetch_assoc($result_history)
                    ) {

                ?>

                    <tr>

                        <td>
                            #<?php
                            echo $request['request_id'];
                            ?>
                        </td>


                        <td>

                            <?php

                            echo htmlspecialchars(
                                $request['medicine_name']
                            );

                            ?>

                        </td>


                        <td>

                            <?php
                            echo $request['quantity'];
                            ?>

                        </td>


                        <td>

                            <?php

                            echo htmlspecialchars(
                                $request['reason']
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            echo date(
                                "d/m/Y",
                                strtotime(
                                    $request['request_date']
                                )
                            );

                            ?>

                        </td>


                        <td>

                            <?php

                            if (
                                $request['status']
                                == "Pending"
                            ) {

                            ?>

                                <span class="status-pending">
                                    Pending
                                </span>

                            <?php

                            } elseif (
                                $request['status']
                                == "Approved"
                            ) {

                            ?>

                                <span class="status-approved">
                                    Approved
                                </span>

                            <?php

                            } else {

                            ?>

                                <span class="status-rejected">
                                    Rejected
                                </span>

                            <?php

                            }

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

                            No purchase requests yet.

                        </td>

                    </tr>

                <?php

                }

                ?>

                <?php if (isset($_GET['success']) && $_GET['success'] == 'request_submitted') { ?>

<script>
Swal.fire({
    icon: 'success',
    title: 'Request Submitted!',
    text: 'Purchase request submitted successfully.',
    confirmButtonText: 'Continue',
    confirmButtonColor: '#2FA6A0'
});
</script>

<?php } ?>
                

                </tbody>

            </table>

        </div>

    </div>


</div>
<?php

// Get all purchase requests
$query = "
    SELECT 
        purchase_request.request_id,
        purchase_request.quantity,
        purchase_request.reason,
        purchase_request.status,
        purchase_request.request_date,
        purchase_request.staff_id,
        medicine.medicine_name,
        medicine.price
    FROM purchase_request
    INNER JOIN medicine 
        ON purchase_request.medicine_id = medicine.medicine_id
    ORDER BY purchase_request.request_date DESC
";

$result = mysqli_query($conn, $query);

?>

<div class="dashboard-page">

    <!-- PAGE TITLE -->

    <div class="dashboard-title">

        <h1>Request Approval</h1>


    </div>


    <!-- PURCHASE REQUEST TABLE -->

    <div class="dashboard-section">

        <div class="section-header">

            <h2>Medicine Purchase Requests</h2>

        </div>


        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>Request ID</th>

                        <th>Medicine</th>

                        <th>Staff ID</th>

                        <th>Quantity</th>

                        <th>Unit Price (RM)</th>

                        <th>Total Cost</th>

                        <th>Reason</th>

                        <th>Date</th>

                        <th>Status</th>

                        <th>Action</th>

                    </tr>

                </thead>


                <tbody>

                <?php

                if ($result && mysqli_num_rows($result) > 0) {

                    while ($request = mysqli_fetch_assoc($result)) {

                ?>

                    <tr>

                        <td>
                            #<?php echo $request['request_id']; ?>
                        </td>


                        <td>
                            <?php echo htmlspecialchars($request['medicine_name']); ?>
                        </td>


                        <td>
                            <?php echo htmlspecialchars($request['staff_id']); ?>
                        </td>

                  
                        <td>
                            <?php echo $request['quantity']; ?>
                        </td>

                    
                        <td>
                         RM <?php echo number_format($request['price'], 2); ?>
                        </td>

                        <td>
                        RM <?php echo number_format(
                        $request['price'] * $request['quantity'],
                          2
                         ); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($request['reason']); ?>
                        </td>


                        <td>
                            <?php
                            echo date(
                                "d/m/Y",
                                strtotime($request['request_date'])
                            );
                            ?>
                        </td>


                        <!-- STATUS -->

                        <td>

                            <?php if ($request['status'] == "Pending") { ?>

                                <span class="status-pending">
                                    Pending
                                </span>

                            <?php } elseif ($request['status'] == "Approved") { ?>

                                <span class="status-in">
                                    Approved
                                </span>

                            <?php } else { ?>

                                <span class="status-out">
                                    Rejected
                                </span>

                            <?php } ?>

                        </td>


                        <!-- ACTION -->

                        <td>

                            <?php if ($request['status'] == "Pending") { ?>

                               <a
    href="purchase_request_action.php?id=<?php echo $request['request_id']; ?>&action=approve"
    class="btn-approve"
    onclick="approveRequest(event, this.href);"
>
    Approve
</a>


                                <a
    href="purchase_request_action.php?id=<?php echo $request['request_id']; ?>&action=reject"
    class="btn-reject"
    onclick="rejectRequest(event, this.href);"
>
    Reject
</a>

                            <?php } else { ?>

                                <span class="action-completed">
                                    Completed
                                </span>

                            <?php } ?>

                        </td>

                    </tr>

                <?php

                    }

                } else {

                ?>

                    <tr>

                        <td colspan="10" class="no-data">

                            <i class="fa-solid fa-cart-shopping"></i>

                            <br><br>

                            No purchase requests yet.

                        </td>

                    </tr>

                <?php

                }

                ?>

<script>

function approveRequest(event, url) {

    event.preventDefault();

    Swal.fire({
        icon: 'question',
        title: 'Approve Request?',
        text: 'Are you sure you want to approve this purchase request?',
        showCancelButton: true,
        confirmButtonText: 'Approve',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#2FA6A0',
        cancelButtonColor: '#6c757d'
    }).then((result) => {

        if (result.isConfirmed) {
            window.location.href = url;
        }

    });
}


function rejectRequest(event, url) {

    event.preventDefault();

    Swal.fire({
        icon: 'warning',
        title: 'Reject Request?',
        text: 'Are you sure you want to reject this purchase request?',
        showCancelButton: true,
        confirmButtonText: 'Reject',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#e74c3c',
        cancelButtonColor: '#6c757d'
    }).then((result) => {

        if (result.isConfirmed) {
            window.location.href = url;
        }

    });
}

</script>

                </tbody>

            </table>

        </div>

    </div>

</div>
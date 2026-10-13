<?php

session_start();

include("config/database.php");


// =====================================
// CHECK LOGIN
// =====================================

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit();

}


// =====================================
// ONLY OWNER CAN APPROVE / REJECT
// =====================================

if ($_SESSION['role'] != "Owner") {

    header("Location: staff_dashboard.php");
    exit();

}


// =====================================
// CHECK REQUEST ID & ACTION
// =====================================

if (!isset($_GET['id']) || !isset($_GET['action'])) {

    header("Location: owner_dashboard.php?page=request_approval");
    exit();

}


$request_id = intval($_GET['id']);

$action = $_GET['action'];


// =====================================
// DETERMINE STATUS
// =====================================

if ($action == "approve") {

    $status = "Approved";

} elseif ($action == "reject") {

    $status = "Rejected";

} else {

    header("Location: owner_dashboard.php?page=request_approval");
    exit();

}


// =====================================
// UPDATE PURCHASE REQUEST
// =====================================

$query = "
    UPDATE purchase_request
    SET status = '$status'
    WHERE request_id = $request_id
      AND status = 'Pending'
";


if (mysqli_query($conn, $query)) {


    // Check whether a record was actually updated

    if (mysqli_affected_rows($conn) > 0) {

        echo "

        <!DOCTYPE html>

        <html>

        <head>

            <meta charset='UTF-8'>

            <title>Request Updated</title>

            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>

        </head>


        <body>


        <script>

        Swal.fire({

            icon: 'success',

            title: 'Request $status!',

            text: 'The purchase request has been $status successfully.',

            confirmButtonColor: '#2E5AAC',

            confirmButtonText: 'Continue',

            allowOutsideClick: false

        }).then((result) => {

            if (result.isConfirmed) {

                window.location.href =
                'owner_dashboard.php?page=request_approval';

            }

        });

        </script>


        </body>

        </html>

        ";

    } else {

        echo "

        <!DOCTYPE html>

        <html>

        <head>

            <meta charset='UTF-8'>

            <title>Request Not Updated</title>

            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>

        </head>


        <body>


        <script>

        Swal.fire({

            icon: 'warning',

            title: 'Request Already Processed',

            text: 'This purchase request has already been processed.',

            confirmButtonColor: '#2E5AAC',

            confirmButtonText: 'OK'

        }).then((result) => {

            window.location.href =
            'owner_dashboard.php?page=request_approval';

        });

        </script>


        </body>

        </html>

        ";

    }


} else {


    // =====================================
    // UPDATE FAILED
    // =====================================

    echo "

    <!DOCTYPE html>

    <html>

    <head>

        <meta charset='UTF-8'>

        <title>Error</title>

        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>

    </head>


    <body>


    <script>

    Swal.fire({

        icon: 'error',

        title: 'Failed!',

        text: 'Unable to update the purchase request.',

        confirmButtonColor: '#d33',

        confirmButtonText: 'OK'

    }).then((result) => {

        window.location.href =
        'owner_dashboard.php?page=request_approval';

    });

    </script>


    </body>

    </html>

    ";

}


mysqli_close($conn);

?>
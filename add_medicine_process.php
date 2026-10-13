<?php

session_start();

include("config/database.php");

// =====================================
// CHECK STAFF LOGIN
// =====================================

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit();

}

if ($_SESSION['role'] != "Staff") {

    header("Location: owner_dashboard.php");
    exit();

}


// =====================================
// GET FORM DATA
// =====================================

$medicine_code = $_POST['medicine_code'];
$medicine_name = $_POST['medicine_name'];
$category      = $_POST['category'];
$dosage        = $_POST['dosage'];
$price         = $_POST['price'];
$quantity      = $_POST['quantity'];
$expiry_date   = $_POST['expiry_date'];

// =====================================
// UPLOAD MEDICINE IMAGE
// =====================================

$medicine_image = "";

if (isset($_FILES['medicine_image']) && $_FILES['medicine_image']['error'] == 0) {

    $upload_dir = "uploads/medicine/";

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_name = time() . "_" . basename($_FILES['medicine_image']['name']);

    $target_file = $upload_dir . $file_name;

    move_uploaded_file(
        $_FILES['medicine_image']['tmp_name'],
        $target_file
    );

    $medicine_image = $target_file;
}


// =====================================
// GET STAFF ID
// =====================================

$staff_id = $_SESSION['user_id'];


// =====================================
// INSERT MEDICINE
// =====================================
$sql = "INSERT INTO medicine
        (
            medicine_code,
            medicine_name,
            category,
            dosage,
            price,
            quantity,
            expiry_date,
            medicine_image
        )
        VALUES
        (
            '$medicine_code',
            '$medicine_name',
            '$category',
            '$dosage',
            '$price',
            '$quantity',
            '$expiry_date',
            '$medicine_image'
        )";


if (mysqli_query($conn, $sql)) {


    // =====================================
    // GET NEW MEDICINE ID
    // =====================================

    $medicine_id = mysqli_insert_id($conn);


    // =====================================
    // DATE
    // =====================================

    $date_added = date("Y-m-d");


    // =====================================
    // INSERT STOCK MOVEMENT
    // =====================================

    $record_sql = "INSERT INTO medicine_record
                   (
                       medicine_id,
                       quantity,
                       date_added,
                       movement_type,
                       staff_id
                   )
                   VALUES
                   (
                       '$medicine_id',
                       '$quantity',
                       '$date_added',
                       'IN',
                       '$staff_id'
                   )";


    if (mysqli_query($conn, $record_sql)) {

    header("Location: staff_dashboard.php?page=add_medicine&success=medicine_added");
    exit();

}

    } else {

        // =====================================
        // MEDICINE ADDED BUT RECORD FAILED
        // =====================================

        echo "

        <script>

            alert('Medicine added, but stock record failed: " . mysqli_error($conn) . "');

            window.history.back();

        </script>

        ";

    }


    // =====================================
    // MEDICINE INSERT FAILED
    // =====================================

    echo "

    <script>

        alert('Failed to Add Medicine: " . mysqli_error($conn) . "');

        window.history.back();

    </script>

    ";



mysqli_close($conn);



?>
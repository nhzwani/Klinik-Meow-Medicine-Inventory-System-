<?php

session_start();

include("config/database.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != "Staff") {
    header("Location: owner_dashboard.php");
    exit();
}

if (!isset($_POST['save_case'])) {
    header("Location: staff_dashboard.php?page=dashboard");
    exit();
}

$case_date = $_POST['case_date'];

$condition_name = mysqli_real_escape_string(
    $conn,
    $_POST['condition_name']
);

$medicine_id = !empty($_POST['medicine_id'])
    ? intval($_POST['medicine_id'])
    : "NULL";

$staff_id = mysqli_real_escape_string(
    $conn,
    $_SESSION['staff_id']
);

$sql = "
    INSERT INTO cat_case
    (
        case_date,
        condition_name,
        medicine_id,
        staff_id
    )
    VALUES
    (
        '$case_date',
        '$condition_name',
        $medicine_id,
        '$staff_id'
    )
";

if (mysqli_query($conn, $sql)) {

    header(
        "Location: staff_dashboard.php?page=dashboard&success=case_added"
    );

    exit();

} else {

    echo "Error: " . mysqli_error($conn);

}

mysqli_close($conn);

?>
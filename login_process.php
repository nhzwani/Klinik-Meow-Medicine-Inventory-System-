<?php
session_start();

include("config/database.php");

$staff_id = $_POST['staffid'];
$password = $_POST['password'];

$sql = "SELECT * FROM user WHERE staff_id='$staff_id'";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 1)
{
    $row = mysqli_fetch_assoc($result);

    if($password == $row['password'])
    {
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['staff_id'] = $row['staff_id'];
        $_SESSION['role'] = $row['role'];

        if ($row['role'] == "Owner") {

    $_SESSION['user_id'] = $row['user_id'];
    $_SESSION['staff_id'] = $row['staff_id'];
    $_SESSION['role'] = $row['role'];

    header("Location: owner_dashboard.php?login=success");
    exit();

}
        else
        {
           header("Location: staff_dashboard.php?login=success");
exit();
        }
    }
    else
    {
       header("Location: login.php?error=wrong_password");
    exit();
    }
}
else
{
     header("Location: login.php?error=wrong_login");
    exit();
}

mysqli_close($conn);
?>
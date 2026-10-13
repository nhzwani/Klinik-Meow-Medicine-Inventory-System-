<?php

include("config/database.php");

$staff_id = $_POST['staff_id'];

$full_name = $_POST['full_name'];

$password = $_POST['password'];

$confirm_password = $_POST['confirm_password'];

if($password != $confirm_password){

    echo "<script>

    alert('Password does not match!');

    window.history.back();

    </script>";

    exit();

}

$sql = "INSERT INTO user
(staff_id, full_name, password, role)
VALUES

('$staff_id','$full_name','$password','Staff')";

if(mysqli_query($conn,$sql)){

    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

echo "<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: 'Staff registered successfully!',
        confirmButtonText: 'OK'
    }).then(function() {
        window.location.href = 'owner_dashboard.php?page=register_staff';
    });
</script>";

exit();

}else{

    echo "Error : ".mysqli_error($conn);

}

?>
<?php

// Auto Generate Staff ID

$query = "SELECT staff_id FROM user ORDER BY user_id DESC LIMIT 1";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0){

    $row = mysqli_fetch_assoc($result);

    $last_id = $row['staff_id'];

    $number = (int)substr($last_id,1);

    $number++;

    $staff_id = "S".str_pad($number,3,"0",STR_PAD_LEFT);

}else{

    $staff_id = "S001";

}
?>

<div class="register-container">

<h2>Register Staff</h2>

<form action="register_staff_process.php" method="POST">

<div class="form-group">

<label>Staff ID</label>

<input type="text"
name="staff_id"
value="<?php echo $staff_id; ?>"
readonly>

</div>

<div class="form-group">

<label>Full Name</label>

<input type="text"
name="full_name"
placeholder="Enter Full Name"
required>

</div>

<div class="form-group">

<label>Password</label>

<input type="password"
name="password"
placeholder="Enter Password"
required>

</div>

<div class="form-group">

<label>Confirm Password</label>

<input type="password"
name="confirm_password"
placeholder="Confirm Password"
required>

</div>

<button type="submit">

<i class="fa-solid fa-user-plus"></i>

Register Staff

</button>

</form>

</div>
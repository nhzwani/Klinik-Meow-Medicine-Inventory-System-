<?php

$query = "SELECT * FROM medicine ORDER BY medicine_name ASC";
$result = mysqli_query($conn, $query);

?>

<div class="register-container">

<h2>Add Medicine Record</h2>

<form action="add_medicine_process.php" method="POST">

<div class="form-group">

<label>Medicine</label>

<select name="medicine_id" required>

<option value="">-- Select Medicine --</option>

<?php

while($row = mysqli_fetch_assoc($result))
{

?>

<option value="<?php echo $row['medicine_id']; ?>">

<?php echo $row['medicine_name']; ?>

</option>

<?php

}

?>

</select>

</div>

<div class="form-group">

<label>Quantity</label>

<input
type="number"
name="quantity"
placeholder="Enter Quantity"
required>

</div>

<button type="submit">

<i class="fa-solid fa-plus"></i>

Add Record

</button>

</form>

</div>
<?php

// Auto Generate Medicine Code

$query = "SELECT medicine_code FROM medicine ORDER BY medicine_id DESC LIMIT 1";

$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0)
{
    $row = mysqli_fetch_assoc($result);

    $last_code = $row['medicine_code'];

    $number = (int)substr($last_code,1);

    $number++;

    $medicine_code = "M".str_pad($number,3,"0",STR_PAD_LEFT);
}
else
{
    $medicine_code = "M001";
}

?>

<div class="register-container">

    <h2>Add Medicine</h2>

   <form action="add_medicine_process.php"
      method="POST"
      enctype="multipart/form-data">

        <div class="form-group">       

            <label>Medicine Code</label>

            <input
            type="text"
            name="medicine_code"
            value="<?php echo $medicine_code; ?>"
            readonly>

        </div>

        <div class="form-group">

            <label>Medicine Name</label>

            <input
            type="text"
            name="medicine_name"
            placeholder="Enter Medicine Name"
            required>

        </div>

        <div class="form-group">

            <label>Category</label>

            <select name="category" required>

                <option value="">-- Select Category --</option>

                <option value="Antibiotic">Antibiotic</option>
                <option value="Analgesic">Analgesic</option>
                <option value="Dewormer">Dewormer</option>
                <option value="Anti-inflammatory">Anti-inflammatory</option>
                <option value="Eye Medication">Eye Medication</option>
                <option value="Antiparasitic">Antiparasitic</option>
                <option value="Vaccine">Vaccine</option>
                <option value="Supplement">Supplement</option>
                <option value="Vitamin">Vitamin</option>
                <option value="Eat Treatment">Ear Treatment</option>
                <option value="Others">Others</option>

            </select>

        </div>

        <div class="form-group">

            <label>Dosage</label>

            <input
            type="text"
            name="dosage"
            placeholder="Example : 250 mg / 5 ml"
            required>

        </div>

        <div class="form-group">

            <label>Price (RM)</label>

            <input
            type="number"
            name="price"
            step="0.01"
            min="0"
            placeholder="Example : 18.50"
            required>

        </div>

        <div class="form-group">

            <label>Quantity</label>

            <input
            type="number"
            name="quantity"
            min="0"
            placeholder="Enter Quantity"
            required>

        </div>

        <div class="form-group">

            <label>Expiry Date</label>

            <input
            type="date"
            name="expiry_date"
            required>

        </div>

        <div class="form-group">

    <label>Medicine Image</label>

    <input
        type="file"
        name="medicine_image"
        accept="image/*"
        required
    >

</div>

        <button type="submit">

            <i class="fa-solid fa-capsules"></i>

            Add Medicine

        </button>

    </form>
    

</div>
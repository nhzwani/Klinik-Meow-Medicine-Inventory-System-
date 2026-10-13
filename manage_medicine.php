<?php

// ===============================
// DELETE MEDICINE
// ===============================

if (isset($_GET['delete'])) {

    $medicine_id = intval($_GET['delete']);

    // Delete related purchase requests first
    $delete_purchase = "
        DELETE FROM purchase_request
        WHERE medicine_id = $medicine_id
    ";

    mysqli_query($conn, $delete_purchase);


    // Delete related stock movement records
    $delete_record = "
        DELETE FROM medicine_record
        WHERE medicine_id = $medicine_id
    ";

    mysqli_query($conn, $delete_record);


    // Delete medicine
    $delete_medicine = "
        DELETE FROM medicine
        WHERE medicine_id = $medicine_id
    ";

    if (mysqli_query($conn, $delete_medicine)) {

        header("Location: staff_dashboard.php?page=manage_medicine&success=deleted");
        exit();

    } else {

        echo "Error deleting medicine: " . mysqli_error($conn);
        exit();

    }

}
    


// =====================================================
// UPDATE MEDICINE
// =====================================================

if (isset($_POST['update_medicine'])) {

    $medicine_id = intval($_POST['medicine_id']);

    $medicine_name = mysqli_real_escape_string(
        $conn,
        $_POST['medicine_name']
    );

    $category = mysqli_real_escape_string(
        $conn,
        $_POST['category']
    );

    $dosage = mysqli_real_escape_string(
        $conn,
        $_POST['dosage']
    );

    $price = floatval($_POST['price']);

    $expiry_date = mysqli_real_escape_string(
        $conn,
        $_POST['expiry_date']
    );


   $update_query = "
    UPDATE medicine
    SET
        medicine_name = '$medicine_name',
        category = '$category',
        dosage = '$dosage',
        price = '$price',
        expiry_date = '$expiry_date'
    WHERE medicine_id = $medicine_id
";


    if (mysqli_query($conn, $update_query)) {

    echo "<script>

        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Medicine updated successfully!',
            confirmButtonText: 'OK'
        }).then(function() {
            window.location.href = 'staff_dashboard.php?page=manage_medicine';
        });

    </script>";

    exit();

} else {

    echo "<script>

        Swal.fire({
            icon: 'error',
            title: 'Update Failed!',
            text: 'Failed to update medicine!',
            confirmButtonText: 'OK'
        });

    </script>";
}
}



// =====================================================
// GET MEDICINE FOR EDIT
// =====================================================

$edit_medicine = null;

if (isset($_GET['edit'])) {

    $edit_id = intval($_GET['edit']);

    $edit_query = "
        SELECT *
        FROM medicine
        WHERE medicine_id = $edit_id
    ";

    $edit_result = mysqli_query($conn, $edit_query);

    if ($edit_result && mysqli_num_rows($edit_result) > 0) {

        $edit_medicine = mysqli_fetch_assoc($edit_result);

    }

}



// =====================================================
// SEARCH
// =====================================================

$search = "";

if (isset($_GET['search'])) {

    $search = mysqli_real_escape_string(
        $conn,
        $_GET['search']
    );

}


$query = "
    SELECT *
    FROM medicine
    WHERE medicine_name LIKE '%$search%'
       OR medicine_code LIKE '%$search%'
       OR category LIKE '%$search%'
    ORDER BY medicine_id DESC
";


$result = mysqli_query($conn, $query);

?>


<div class="dashboard-page">


    <!-- =================================================
         TITLE
    ================================================== -->

    <div class="dashboard-title">

        <div>

            <h1>Manage Medicine</h1>


        </div>

    </div>

<?php

$expired_query = "
    SELECT COUNT(*) AS total
    FROM medicine
    WHERE expiry_date < CURDATE()
";

$expired_result = mysqli_query($conn, $expired_query);
$expired_count = mysqli_fetch_assoc($expired_result)['total'];


$expiring_query = "
    SELECT COUNT(*) AS total
    FROM medicine
    WHERE expiry_date >= CURDATE()
    AND expiry_date <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)
";

$expiring_result = mysqli_query($conn, $expiring_query);
$expiring_count = mysqli_fetch_assoc($expiring_result)['total'];

?>

<<div style="
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 18px;
    margin: 0 0 24px 0;
">

    <!-- EXPIRED -->
    <div style="
        display: flex;
        align-items: center;
        gap: 16px;
        background: #ffffff;
        border: 1px solid #E5ECEB;
        border-left: 4px solid #E85D5D;
        border-radius: 14px;
        padding: 18px 22px;
        box-sizing: border-box;
        box-shadow: 0 4px 12px rgba(18, 59, 82, 0.05);
    ">

        <div style="
            width: 48px;
            height: 48px;
            background: #FDECEC;
            color: #E85D5D;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        ">
            <i class="fa-solid fa-circle-exclamation"></i>
        </div>

        <div>
            <div style="
                font-size: 24px;
                font-weight: 700;
                color: #203746;
                line-height: 1.1;
            ">
                <?php echo $expired_count; ?>
            </div>

            <div style="
                font-size: 13px;
                color: #71808C;
                margin-top: 4px;
            ">
                Expired Medicine
            </div>
        </div>

    </div>


    <!-- EXPIRING SOON -->
    <div style="
        display: flex;
        align-items: center;
        gap: 16px;
        background: #ffffff;
        border: 1px solid #E5ECEB;
        border-left: 4px solid #F2995A;
        border-radius: 14px;
        padding: 18px 22px;
        box-sizing: border-box;
        box-shadow: 0 4px 12px rgba(18, 59, 82, 0.05);
    ">

        <div style="
            width: 48px;
            height: 48px;
            background: #FFF3E8;
            color: #F2995A;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        ">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>

        <div>
            <div style="
                font-size: 24px;
                font-weight: 700;
                color: #203746;
                line-height: 1.1;
            ">
                <?php echo $expiring_count; ?>
            </div>

            <div style="
                font-size: 13px;
                color: #71808C;
                margin-top: 4px;
            ">
                Expiring Within 30 Days
            </div>
        </div>

    </div>

</div>

    <!-- =================================================
         UPDATE FORM
         ONLY SHOW WHEN EDIT IS CLICKED
    ================================================== -->

    <?php if ($edit_medicine): ?>


    <div class="dashboard-section">

        <div class="section-header">

            <h2>
                <i class="fa-solid fa-pen"></i>
                Update Medicine
            </h2>

        </div>


        <form method="POST">


            <!-- MEDICINE ID -->

            <input
                type="hidden"
                name="medicine_id"
                value="<?php echo $edit_medicine['medicine_id']; ?>"
            >


            <!-- MEDICINE CODE -->

            <div class="form-group">

                <label>Medicine Code</label>

                <input
                    type="text"
                    value="<?php echo htmlspecialchars(
                        $edit_medicine['medicine_code']
                    ); ?>"
                    readonly
                >

            </div>



            <!-- MEDICINE NAME -->

            <div class="form-group">

                <label>Medicine Name</label>

                <input
                    type="text"
                    name="medicine_name"
                    value="<?php echo htmlspecialchars(
                        $edit_medicine['medicine_name']
                    ); ?>"
                    required
                >

            </div>



            <!-- CATEGORY -->

            <div class="form-group">

                <label>Category</label>

                <select name="category" required>

                    <option value="Antibiotic"
                        <?php
                        if ($edit_medicine['category'] == 'Antibiotic')
                            echo 'selected';
                        ?>>
                        Antibiotic
                    </option>


                    <option value="Analgesic"
                        <?php
                        if ($edit_medicine['category'] == 'Analgesic')
                            echo 'selected';
                        ?>>
                        Analgesic
                    </option>


                    <option value="Dewormer"
                        <?php
                        if ($edit_medicine['category'] == 'Dewormer')
                            echo 'selected';
                        ?>>
                        Dewormer
                    </option>


                    <option value="Anti-inflammatory"
                        <?php
                        if ($edit_medicine['category'] == 'Anti-inflammatory')
                            echo 'selected';
                        ?>>
                        Anti-inflammatory
                    </option>


                    <option value="Antiparasitic"
                        <?php
                        if ($edit_medicine['category'] == 'Antiparasitic')
                            echo 'selected';
                        ?>>
                        Antiparasitic
                    </option>


                    <option value="Vaccine"
                        <?php
                        if ($edit_medicine['category'] == 'Vaccine')
                            echo 'selected';
                        ?>>
                        Vaccine
                    </option>


                    <option value="Supplement"
                        <?php
                        if ($edit_medicine['category'] == 'Supplement')
                            echo 'selected';
                        ?>>
                        Supplement
                    </option>


                    <option value="Vitamin"
                        <?php
                        if ($edit_medicine['category'] == 'Vitamin')
                            echo 'selected';
                        ?>>
                        Vitamin
                    </option>


                    <option value="Others"
                        <?php
                        if ($edit_medicine['category'] == 'Others')
                            echo 'selected';
                        ?>>
                        Others
                    </option>

                </select>

            </div>



            <!-- DOSAGE -->

            <div class="form-group">

                <label>Dosage</label>

                <input
                    type="text"
                    name="dosage"
                    value="<?php echo htmlspecialchars(
                        $edit_medicine['dosage']
                    ); ?>"
                    required
                >

            </div>



            <!-- PRICE -->

            <div class="form-group">

                <label>Price (RM)</label>

                <input
                    type="number"
                    name="price"
                    step="0.01"
                    min="0"
                    value="<?php echo $edit_medicine['price']; ?>"
                    required
                >

            </div>



     <!-- EXPIRY DATE -->

<div class="form-group">

    <label>Expiry Date</label>

    <input
        type="date"
        name="expiry_date"
        value="<?php echo $edit_medicine['expiry_date']; ?>"
        required
    >

</div>


            <!-- BUTTONS -->

            <div style="
                display:flex;
                gap:10px;
                margin-top:20px;
            ">


                <button
                    type="submit"
                    name="update_medicine"
                    class="btn-primary"
                >

                    <i class="fa-solid fa-check"></i>

                    Update Medicine

                </button>


                <a
                    href="staff_dashboard.php?page=manage_medicine"
                    class="btn-secondary"
                    style="
                        display:inline-flex;
                        align-items:center;
                        justify-content:center;
                        padding:12px 20px;
                        text-decoration:none;
                    "
                >

                    Cancel

                </a>


            </div>


        </form>

    </div>


    <?php endif; ?>



    <!-- =================================================
         MEDICINE RECORDS
    ================================================== -->

    <div class="dashboard-section">


        <div class="section-header">

            <h2>Medicine Records</h2>

        </div>



        <!-- SEARCH -->

        <form
            method="GET"
            action="staff_dashboard.php"
            style="
                display:flex;
                gap:10px;
                margin-bottom:20px;
            "
        >

            <input
                type="hidden"
                name="page"
                value="manage_medicine"
            >


            <input
                type="text"
                name="search"
                placeholder="Search medicine..."
                value="<?php echo htmlspecialchars($search); ?>"
                style="
                    flex:1;
                    padding:12px;
                    border:1px solid #ddd;
                    border-radius:8px;
                "
            >


            <button
                   type="submit"
                   class="btn-primary"
                 style="
                  width: auto;
                  margin: 0;
                  padding: 12px 25px;
    "
>

                <i class="fa-solid fa-search"></i>

                Search

            </button>

        </form>



        <!-- TABLE -->

        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>Image</th>

                        <th>Code</th>

                        <th>Medicine</th>

                        <th>Category</th>

                        <th>Dosage</th>

                        <th>Price (RM)</th>

                        <th>Stock</th>

                        <th>Expiry Date</th>

                        <th>Action</th>

                    </tr>

                </thead>


                <tbody>


                <?php

                if ($result && mysqli_num_rows($result) > 0) {

                    while ($medicine = mysqli_fetch_assoc($result)) {

                ?>


                    <tr>

                        <!-- IMAGE -->
                    <td>
    <?php if (!empty($medicine['medicine_image'])) { ?>

        <img
            src="<?php echo htmlspecialchars($medicine['medicine_image']); ?>"
            alt="Medicine Image"
            style="
                width:60px;
                height:60px;
                object-fit:contain;
                border-radius:8px;
            "
        >

    <?php } else { ?>

        No Image

    <?php } ?>
</td>


                        <!-- CODE -->

                        <td>

                            <?php

                            echo htmlspecialchars(
                                $medicine['medicine_code']
                            );

                            ?>

                        </td>



                        <!-- MEDICINE -->

                        <td>

                            <?php

                            echo htmlspecialchars(
                                $medicine['medicine_name']
                            );

                            ?>

                        </td>



                        <!-- CATEGORY -->

                        <td>

                            <?php

                            echo htmlspecialchars(
                                $medicine['category']
                            );

                            ?>

                        </td>



                        <!-- DOSAGE -->

                        <td>

                            <?php

                            echo htmlspecialchars(
                                $medicine['dosage']
                            );

                            ?>

                        </td>



                        <!-- PRICE -->

                        <td>

                            <?php

                            echo number_format(
                                $medicine['price'],
                                2
                            );

                            ?>

                        </td>



                        <!-- STOCK -->

                        <td>

                            <?php

                            echo $medicine['quantity'];

                            ?>

                        </td>



                        <!-- EXPIRY -->

                        <td>

                            <?php

                            echo date(
                                "d/m/Y",
                                strtotime(
                                    $medicine['expiry_date']
                                )
                            );

                            ?>

                        </td>



                        <!-- ACTION -->

                        <td>


                            <!-- EDIT -->

                            <a
                                href="staff_dashboard.php?page=manage_medicine&edit=<?php echo $medicine['medicine_id']; ?>"
                                class="btn-edit"
                            >

                                <i class="fa-solid fa-pen"></i>

                            </a>



                            <!-- DELETE -->

                            <a
    href="#"
    class="btn-delete"
    onclick="confirmDelete(<?php echo $medicine['medicine_id']; ?>); return false;"
>
    <i class="fa-solid fa-trash"></i>
</a>


                        </td>


                    </tr>


                <?php

                    }

                } else {

                ?>


                    <tr>

                        <td
                            colspan="8"
                            class="no-data"
                        >

                            No medicine records found.

                        </td>

                    </tr>


                <?php

                }

                ?>


                </tbody>

            </table>

        </div>


    </div>


</div>

<script>

function confirmDelete(medicineId) {

    Swal.fire({

        title: 'Delete Medicine?',

        text: 'Are you sure you want to delete this medicine?',

        icon: 'warning',

        showCancelButton: true,

        confirmButtonText: 'Delete',

        cancelButtonText: 'Cancel',

        confirmButtonColor: '#e33434',

        cancelButtonColor: '#6c757d',

        customClass: {
            actions: 'swal-actions-vertical'
        }

    }).then(function(result) {

        if (result.isConfirmed) {

            // Pergi ke delete function
            window.location.href =
                'staff_dashboard.php?page=manage_medicine&delete=' + medicineId;

        }

    });

}

</script>
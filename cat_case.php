<?php

$medicine_query = "
    SELECT medicine_id, medicine_name
    FROM medicine
    ORDER BY medicine_name ASC
";

$medicine_result = mysqli_query($conn, $medicine_query);

?>

<div class="dashboard-page">

    <div class="dashboard-title">

        <h1>Record Cat Case</h1>

        <p>
            Record cat medical conditions for monitoring.
        </p>

    </div>


    <div class="dashboard-section">

        <div class="section-header">

            <h2>
                <i class="fa-solid fa-cat"></i>
                New Cat Case
            </h2>

        </div>


        <form action="cat_case_process.php" method="POST">

            <div class="form-group">

                <label>Case Date</label>

                <input
                    type="date"
                    name="case_date"
                    value="<?php echo date('Y-m-d'); ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label>Condition</label>

                <select name="condition_name" required>

                    <option value="">
                        Select Condition
                    </option>

                    <option value="Upper Respiratory Infection">
                        Upper Respiratory Infection
                    </option>

                    <option value="Skin Infection">
                        Skin Infection
                    </option>

                    <option value="Gastrointestinal Problem">
                        Gastrointestinal Problem
                    </option>

                    <option value="Urinary Tract Problem">
                        Urinary Tract Problem
                    </option>

                    <option value="Eye Infection">
                        Eye Infection
                    </option>

                    <option value="Ear Infection">
                        Ear Infection
                    </option>

                    <option value="Dental Disease">
                        Dental Disease
                    </option>

                    <option value="Parasite Infestation">
                        Parasite Infestation
                    </option>

                    <option value="Other">
                        Other
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label>Medicine Used</label>

                <select name="medicine_id">

                    <option value="">
                        Select Medicine
                    </option>

                    <?php

                    if ($medicine_result && mysqli_num_rows($medicine_result) > 0) {

                        while ($medicine = mysqli_fetch_assoc($medicine_result)) {

                    ?>

                        <option value="<?php echo $medicine['medicine_id']; ?>">

                            <?php
                            echo htmlspecialchars($medicine['medicine_name']);
                            ?>

                        </option>

                    <?php

                        }

                    }

                    ?>

                </select>

            </div>


            <button
                type="submit"
                name="save_case"
                class="btn-primary"
            >

                <i class="fa-solid fa-save"></i>
                Save Case

            </button>

        </form>

    </div>

</div>
<!DOCTYPE html>
<html>
<head>
    <title>Weight-Based Dosage Calculator</title>
</head>
<body>
    <h1>Weight-Based Dosage Calculator</h1>
    <form method="post">
        <label for="weight">Weight (kg):</label>
        <input type="number" step="any" name="weight" required><br><br>

        <label for="dosage">Dosage per kg (mg/kg):</label>
        <input type="number" step="any" name="dosage" required><br><br>

        <input type="submit" value="Calculate Dosage">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $weight = $_POST["weight"];
        $dosage_per_kg = $_POST["dosage"];

        // Calculate the total dosage based on weight
        $total_dosage = $weight * $dosage_per_kg;

        echo "<h2>Calculated Dosage:</h2>";
        echo "<p>" . round($total_dosage, 2) . " mg</p>";

        // You can use the $total_dosage value for further processing or displaying the result.
    }
    ?>
</body>
</html>

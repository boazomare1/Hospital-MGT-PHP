<!DOCTYPE html>
<html>
<head>
    <title>BSA Dosage Calculator</title>
</head>
<body>
    <h1>Body Surface Area (BSA) Dosage Calculator</h1>
    <form method="post">
        <label for="weight">Weight (kg):</label>
        <input type="number" step="any" name="weight" required><br><br>

        <label for="height">Height (cm):</label>
        <input type="number" step="any" name="height" required><br><br>

        <input type="submit" value="Calculate BSA">
    </form>

    <?php
    // Function to calculate BSA using the Du Bois formula
    function calculate_bsa($weight, $height) {
        return sqrt(($weight * $height) / 3600);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $weight = $_POST["weight"];
        $height = $_POST["height"];

        $bsa = calculate_bsa($weight, $height);

        echo "<h2>Calculated BSA:</h2>";
        echo "<p>" . round($bsa, 2) . " m<sup>2</sup></p>";

        // You can use the BSA value to calculate drug dosages or perform other medical calculations.
    }
    ?>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Weight-Based Dosage Calculator</title>
</head>
<body>
    <h1>Weight-Based Dosage Calculator</h1>
    <form method="post" action="">
        <label for="weight">Patient's Weight (kg):</label>
        <input type="number" id="weight" name="weight" required><br><br>
        
        <label for="dosage">Dosage per kg (mg/kg):</label>
        <input type="number" id="dosage" name="dosage" required><br><br>
        
        <input type="submit" value="Calculate Dosage">
    </form>

    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve the user input
        $weightInKg = $_POST["weight"];
        $dosagePerKg = $_POST["dosage"];
        
        // Calculate the total dosage
        $totalDosage = $weightInKg * $dosagePerKg;
        
        // Display the result
        echo "<h2>Result:</h2>";
        echo "Patient's weight: " . $weightInKg . " kg<br>";
        echo "Dosage per kg: " . $dosagePerKg . " mg/kg<br>";
        echo "Total dosage: " . $totalDosage . " mg";
    }
    ?>

</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $age = $_POST['age'];

    // Determine weight category
    $bmi = $weight / (($height / 100) ** 2);
    if ($bmi < 18.5) {
        $weight_category = 'underweight';
    } elseif ($bmi >= 18.5 && $bmi < 24.9) {
        $weight_category = 'normal';
    } else {
        $weight_category = 'overweight';
    }

    // Determine age group
    if ($age >= 18 && $age <= 25) {
        $age_group = '18-25';
    } elseif ($age >= 26 && $age <= 35) {
        $age_group = '26-35';
    } elseif ($age >= 36 && $age <= 45) {
        $age_group = '36-45';
    } else {
        $age_group = 'unknown';
    }

    // Read the CSV file and find the exercise program
    $exercises = [];
    if (($handle = fopen("exercise_programs.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[0] == $age_group && $data[1] == $weight_category) {
                $exercises[] = $data[2];
            }
        }
        fclose($handle);
    }

    // Display the exercise program
    echo "<h1>Your Exercise Program</h1>";
    if (!empty($exercises)) {
        echo "<ul>";
        foreach ($exercises as $exercise) {
            echo "<li>" . htmlspecialchars($exercise) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No exercise program found for your criteria.</p>";
    }
} else {
    echo "<p>Invalid request.</p>";
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // User inputs
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $age = $_POST['age'];

    // Calculate BMI
    $bmi = $weight / ($height * $height);

    // Load CSV data
    $csvFile = fopen('exercise_data.csv', 'r');
    $headers = fgetcsv($csvFile); // Skip header row
    $suggestion = "No suitable program found.";

    while ($row = fgetcsv($csvFile)) {
        $data = array_combine($headers, $row);

        if ($data['Age'] == $age && $data['Height'] == $height && $data['Weight'] == $weight) {
            $suggestion = "Based on your inputs, here is your exercise program: \n" .
                          "Fitness Goal: {$data['Fitness Goal']} \n" .
                          "Exercise Type: {$data['Fitness Type']} \n" .
                          "Exercises: {$data['Exercises']} \n" .
                          "Equipment: {$data['Equipment']} \n" .
                          "Diet: {$data['Diet']}";
            break;
        }
    }

    fclose($csvFile);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise Program Generator</title>
</head>
<body>
    <h1>Exercise Program Generator</h1>
    <form method="POST">
        <label for="weight">Weight (kg):</label>
        <input type="number" step="0.1" name="weight" id="weight" required><br>

        <label for="height">Height (m):</label>
        <input type="number" step="0.01" name="height" id="height" required><br>

        <label for="age">Age:</label>
        <input type="number" name="age" id="age" required><br>

        <button type="submit">Generate Exercise Program</button>
    </form>

    <?php if (isset($suggestion)) { ?>
        <h2>Your Exercise Program:</h2>
        <pre><?php echo $suggestion; ?></pre>
    <?php } ?>
</body>
</html>

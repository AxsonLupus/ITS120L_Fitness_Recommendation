<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise Program Generator</title>
</head>
<body>
    <h1>Exercise Program Generator</h1>
    <form action="generate_program.php" method="post">
        <label for="weight">Weight (kg):</label>
        <input type="number" name="weight" required><br>

        <label for="height">Height (cm):</label>
        <input type="number" name="height" required><br>

        <label for="age">Age:</label>
        <input type="number" name="age" required><br>

        <input type="submit" value="Generate Program">
    </form>
</body>
</html>
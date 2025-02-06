<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fitness Recommendation</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&display=swap');
        
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-image: 
                linear-gradient(rgba(255,255,255,0.8), rgba(255,255,255,0.8)),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200' viewBox='0 0 200 200'%3E%3Cstyle%3E.dumbbell%7Bfill:%23007bff;%7D%3C/style%3E%3Cpath class='dumbbell' d='M40 80h20v40H40zM140 80h20v40h-20zM100 60h40v80h-40z' opacity='0.1'/%3E%3C/svg%3E");
        }
        
        .container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            padding: 30px;
            animation: fadeIn 0.8s ease-out;
        }
        
        h2 {
            color: #007bff;
            text-align: center;
            margin-bottom: 25px;
            font-weight: 600;
        }
        
        form {
            display: flex;
            flex-direction: column;
        }
        
        label {
            margin-top: 10px;
            color: #495057;
            font-weight: 600;
        }
        
        input, select {
            margin: 8px 0 15px;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        
        input:focus, select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }
        
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            padding: 12px;
            border-radius: 5px;
            text-transform: uppercase;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>🏋️ Fitness Recommendation</h2>
        <form action="recommend.php" method="post">
            <label>Age:</label>
            <input type="number" name="age" required min="12" max="100">
            
            <label>Weight (kg):</label>
            <input type="number" name="weight" step="0.1" required min="20" max="300">
            
            <label>Height (m):</label>
            <input type="number" name="height" step="0.01" required min="0.5" max="2.5">
            
            <label>BMI:</label>
            <input type="number" name="bmi" step="0.1" required min="10" max="50">
            
            <label>BMI Level:</label>
            <select name="level" required>
                <option value="">Select BMI Level</option>
                <option value="Underweight">Underweight</option>
                <option value="Normal">Normal</option>
                <option value="Overweight">Overweight</option>
                <option value="Obese">Obese</option>
            </select>
            
            <label>Fitness Type:</label>
            <select name="fitness_type" required>
                <option value="">Select Fitness Type</option>
                <option value="Cardio Fitness">Cardio Fitness</option>
                <option value="Muscular Fitness">Muscular Fitness</option>
            </select>
            
            <input type="submit" value="Get Recommendations">
        </form>
    </div>
</body>
</html>
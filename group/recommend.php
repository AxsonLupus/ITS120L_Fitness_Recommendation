<?php
class FitnessRecommender {
    private $data;

    public function __construct($csvFile) {
        $this->data = $this->loadData($csvFile);
    }

    private function loadData($csvFile) {
        $data = array_map('str_getcsv', file($csvFile));
        $headers = array_shift($data);
        return array_map(function($row) use ($headers) {
            return array_combine($headers, $row);
        }, $data);
    }

    private function calculateSimilarity($user, $record) {
        $weights = [
            'age' => 0.2,
            'bmi' => 0.3,
            'level' => 0.5
        ];

        $ageDiff = abs($user['age'] - $record['Age']);
        $bmiDiff = abs($user['bmi'] - $record['BMI']);
        $levelMatch = ($user['level'] === $record['Level']) ? 0 : 1;

        $similarity = 1 - (
            ($weights['age'] * $ageDiff / 100) +
            ($weights['bmi'] * $bmiDiff / 50) +
            ($weights['level'] * $levelMatch)
        );

        return max(0, $similarity);
    }

    public function recommend($user) {
        $similarities = [];
        
        foreach ($this->data as $record) {
            if (strpos($record['Fitness Type'], $user['fitness_type']) !== false) {
                $similarity = $this->calculateSimilarity($user, $record);
                $similarities[] = [
                    'record' => $record,
                    'similarity' => $similarity
                ];
            }
        }

        // Sort by similarity
        usort($similarities, function($a, $b) {
            return $b['similarity'] <=> $a['similarity'];
        });

        // Return top recommendation
        return $similarities ? $similarities[0]['record'] : null;
    }
}

// Load CSV data
$csvFile = 'exercise_data.csv';

// User input
$age = $_POST['age'];
$weight = $_POST['weight'];
$height = $_POST['height'];
$userBMI = $_POST['bmi'];
$userLevel = $_POST['level'];
$userFitnessType = $_POST['fitness_type'];

// Create recommender and get recommendations
$recommender = new FitnessRecommender($csvFile);

$user = [
    'age' => $age,
    'weight' => $weight,
    'height' => $height,
    'bmi' => $userBMI,
    'level' => $userLevel,
    'fitness_type' => $userFitnessType
];

$recommendations = $recommender->recommend($user);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fitness Recommendations</title>
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
        
        .recommendation {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            padding: 30px;
            animation: fadeIn 0.8s ease-out;
        }
        
        h2 {
            color: #007bff;
            text-align: center;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .user-details {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        h3 {
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-top: 20px;
        }
        
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .back-link:hover {
            color: #0056b3;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="recommendation">
        <h2>🏆 Your Fitness Recommendations</h2>
        
        <div class="user-details">
            <p><strong>Age:</strong> <?php echo $age; ?></p>
            <p><strong>Weight:</strong> <?php echo $weight; ?> kg</p>
            <p><strong>Height:</strong> <?php echo $height; ?> m</p>
            <p><strong>BMI:</strong> <?php echo $userBMI; ?></p>
        </div>
        
        <?php if ($recommendations): ?>
            <h3>Recommended Exercises</h3>
            <p><?php echo $recommendations['Exercises']; ?></p>
            
            <h3>Recommended Equipment</h3>
            <p><?php echo $recommendations['Equipment']; ?></p>
        <?php else: ?>
            <p>No specific recommendations found for your profile.</p>
        <?php endif; ?>
        
        <a href="index.php" class="back-link">← Try Again</a>
    </div>
</body>
</html>
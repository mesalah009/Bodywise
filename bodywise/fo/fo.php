<?php
header("Content-Type: application/json");

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "work";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed."]);
    exit();
}

// Retrieve and validate form data
$food_name = isset($_POST['food_name']) ? trim($_POST['food_name']) : '';
$food_amount = isset($_POST['food_amount']) ? floatval($_POST['food_amount']) : 0;
$id_client1 = isset($_POST['id_client1']) ? intval($_POST['id_client1']) : 0; // Récupérer l'id_client1

if (empty($food_name) || $food_amount <= 0 || $id_client1 <= 0) {
    echo json_encode(["status" => "error", "message" => "Food name, amount, and client ID are required."]);
    exit();
}

// Check if the food item exists in the Foods table
$sql = "SELECT * FROM Foods WHERE food_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $food_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Food exists in Foods table
    $food = $result->fetch_assoc();
    $calories = ($food['calories_per_100g'] * $food_amount) / 100;
    $protein = ($food['protein_per_100g'] * $food_amount) / 100;
    $fat = ($food['fat_per_100g'] * $food_amount) / 100;
    $carbs = ($food['carbs_per_100g'] * $food_amount) / 100;

    // Insert into FoodIntake table
    $insert_sql = "INSERT INTO foodintake (food_name, amount, calories, protein, fat, carbs, intake_date, id_client1) 
                   VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("sdddddi", $food_name, $food_amount, $calories, $protein, $fat, $carbs, $id_client1);
    $insert_stmt->execute();

    echo json_encode([
        "status" => "success",
        "food_name" => $food_name,
        "amount" => $food_amount,
        "calories" => $calories,
        "protein" => $protein,
        "fat" => $fat,
        "carbs" => $carbs
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "Food not found in database."]);
}

$stmt->close();
$conn->close();
?>

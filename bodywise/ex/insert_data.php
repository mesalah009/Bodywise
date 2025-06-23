<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "work";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Erreur de connexion : " . $conn->connect_error]));
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "Aucune donnée reçue."]);
    exit;
}

$routineName = $data["routineName"];
$routineDate = $data["routineDate"];
$clientId = 1;
$exercises = $data["exercises"];

if (empty($routineName) || empty($routineDate) || empty($exercises)) {
    echo json_encode(["success" => false, "message" => "Champs obligatoires manquants."]);
    exit;
}

$sqlRoutine = "INSERT INTO routines (client_idd, name, date) VALUES (?, ?, ?)";
$stmtRoutine = $conn->prepare($sqlRoutine);
$stmtRoutine->bind_param("iss", $clientId, $routineName, $routineDate);

if (!$stmtRoutine->execute()) {
    echo json_encode(["success" => false, "message" => "Erreur lors de l'insertion de la routine : " . $stmtRoutine->error]);
    exit;
}

$routineId = $stmtRoutine->insert_id;

foreach ($exercises as $exercise) {
    $exerciseName = $exercise["name"];
    $seriesCount = $exercise["series"];
    $repetitions = $exercise["repetitions"];
    $weight = $exercise["weight"];

    $sqlExercise = "INSERT INTO exercises (routine_id, name) VALUES (?, ?)";
    $stmtExercise = $conn->prepare($sqlExercise);
    $stmtExercise->bind_param("is", $routineId, $exerciseName);

    if (!$stmtExercise->execute()) {
        echo json_encode(["success" => false, "message" => "Erreur lors de l'insertion de l'exercice : " . $stmtExercise->error]);
        exit;
    }

    $exerciseId = $stmtExercise->insert_id;

    $sqlSeries = "INSERT INTO series (exercise_id, series_count, repetitions, weight) VALUES (?, ?, ?, ?)";
    $stmtSeries = $conn->prepare($sqlSeries);
    $stmtSeries->bind_param("iiid", $exerciseId, $seriesCount, $repetitions, $weight);

    if (!$stmtSeries->execute()) {
        echo json_encode(["success" => false, "message" => "Erreur lors de l'insertion de la série : " . $stmtSeries->error]);
        exit;
    }
}

echo json_encode(["success" => true, "message" => "Routine et exercices enregistrés avec succès."]);
$conn->close();
?>

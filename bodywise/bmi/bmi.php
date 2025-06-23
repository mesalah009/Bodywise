<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI Calculator</title>
    <link rel="stylesheet" href="bmi.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert -->
</head>
<body>
    <form action="insert_bmi.php" method="post" id="bmiForm">
        <section class="img-click">
            <div class="container" id="bmi">
                <h1>BMI Calculator</h1>
                <div class="input-section">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date"><br><br> <!-- Ajout de name="date" -->
    
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender"> <!-- Ajout de name="gender" -->
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select><br><br>
    
                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" placeholder="Enter your age"><br><br> <!-- Ajout de name="age" -->
    
                    <label for="weight">Weight (kg):</label>
                    <input type="number" id="weight" name="weight" placeholder="Enter your weight"><br><br> <!-- Ajout de name="weight" -->
    
                    <label for="height">Height (cm):</label>
                    <input type="number" id="height" name="height" placeholder="Enter your height"><br><br> <!-- Ajout de name="height" -->
    
                    <button type="button" onclick="calculateBMI()">Calculate BMI</button>
                    <button type="submit">Add Record</button> <!-- Remplacé onclick="saveRecord()" par type="submit" -->
                </div>
    
                <div class="result-section">
                    <h3>Your Saved Records:</h3>
                    <ul id="recordList"></ul>
                </div>
            </div>
        </section>
    </form>    
    <script src="bmi.js"></script>
    <?php if (!empty($message)) : ?>
    <p style="color: green; font-weight: bold;"><?php echo $message; ?></p>
<?php endif; ?>

<h3>Vos enregistrements :</h3>
<table border="1" style="width: 100%; text-align: left; border-collapse: collapse;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Genre</th>
            <th>Âge</th>
            <th>Poids (kg)</th>
            <th>Taille (cm)</th>
            <th>BMI</th>
            <th>Catégorie</th>
            <th>Date de création</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($records)) : ?>
            <?php foreach ($records as $record) : ?>
                <tr>
                    <td><?php echo $record['id']; ?></td>
                    <td><?php echo $record['date']; ?></td>
                    <td><?php echo $record['gender']; ?></td>
                    <td><?php echo $record['age']; ?></td>
                    <td><?php echo $record['weight']; ?></td>
                    <td><?php echo $record['height']; ?></td>
                    <td><?php echo $record['bmi']; ?></td>
                    <td><?php echo $record['category']; ?></td>
                    <td><?php echo $record['created_at']; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="9" style="text-align: center;">Aucun enregistrement trouvé.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</form>
</body>
</html>

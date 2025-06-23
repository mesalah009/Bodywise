document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('calorieForm');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const age = parseInt(document.getElementById('age').value);
        const gender = document.getElementById('gender').value;
        const weight = parseInt(document.getElementById('weight').value);
        const height = parseInt(document.getElementById('height').value);
        const activityLevel = parseFloat(document.getElementById('activityLevel').value);

        let bmr;

        // Calcul des calories (BMR) selon le sexe
        if (gender === 'male') {
            bmr = 10 * weight + 6.25 * height - 5 * age + 5;
        } else {
            bmr = 10 * weight + 6.25 * height - 5 * age - 161;
        }

        // Calcul des besoins caloriques quotidiens
        const dailyCalories = Math.round(bmr * activityLevel);

        // Afficher le résultat avec SweetAlert2
        Swal.fire({
            title: 'Votre besoin calorique quotidien',
            text: `${dailyCalories} kcal`,
            icon: 'info',
            confirmButtonText: 'OK',
            background: '#f9f9f9',
            color: '#333',
            iconColor: '#4caf50',
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        });

        // Envoyer les données au script PHP
        fetch('store_calorie_data.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                age: age,
                gender: gender,
                weight: weight,
                height: height,
                activityLevel: activityLevel,
                dailyCalories: dailyCalories
            })
        })
        .then(response => response.text())
        .then(data => {
            console.log('Success:', data);
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    });
});

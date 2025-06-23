function calculateBMI() {
    const weight = document.getElementById('weight').value;
    const height = document.getElementById('height').value;

    if (weight && height) {
        const bmi = (parseFloat(weight) / Math.pow(parseFloat(height) / 100, 2)).toFixed(2);
        let category = "";

        if (bmi < 18.5) {
            category = "Underweight";
        } else if (bmi < 24.9) {
            category = "Normal weight";
        } else if (bmi < 29.9) {
            category = "Surpoids";
        } else {
            category = "Overweight";
        }

        Swal.fire({
            title: 'BMI result',
            html: `Your BMI is <strong>${bmi}</strong> and you are in the <strong>${category}</strong> category.`,
            icon: 'info',
            confirmButtonText: 'OK'
        });
    } else {
        Swal.fire({
            title: 'Error',
            text: 'Please fill in all fields to calculate BMI.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
}

function saveRecord() {
    const date = document.getElementById('date').value;
    const gender = document.getElementById('gender').value;
    const age = document.getElementById('age').value;
    const weight = document.getElementById('weight').value;
    const height = document.getElementById('height').value;

    if (!date || !gender || !age || !weight || !height) {
        Swal.fire({
            title: 'Error',
            text: 'Please fill in all fields to save the data.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }

    const bmi = (parseFloat(weight) / Math.pow(parseFloat(height) / 100, 2)).toFixed(2);
    let category = "";

    if (bmi < 18.5) {
        category = "Underweight";
    } else if (bmi < 24.9) {
        category = "Normal weight";
    } else if (bmi < 29.9) {
        category = "Overweight";
    } else {
        category = "Obesity";
    }

    fetch('insert_bmi.php', {
        method: 'POST',
        body: new URLSearchParams({
            date: date,
            gender: gender,
            age: age,
            weight: weight,
            height: height,
            bmi: bmi,
            category: category
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            Swal.fire({
                title: "Success",
                text: data.message,
                icon: "success",
                confirmButtonColor: "#0b789b",
            }).then(() => {
                location.reload(); // Rafraîchir la page après succès
            });
        } else {
            Swal.fire({
                title: "Erreur",
                text: data.message,
                icon: "error",
                confirmButtonColor: "#0b789b",
            });
        }
    })
    .catch(error => {
        Swal.fire({
            title: "Error",
            text: "An error has occurred. Please try again",
            icon: "error",
            confirmButtonColor: "#0b789b",
        });
    });
}

function goToHomePage() {
    window.location.href = "../home/home.html"; // Redirige vers la page d'accueil
}

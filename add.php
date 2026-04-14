<?php
// Database connection
$host = "localhost";
$user = "root";
$password = "";
$database = "clinic_db";

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];

    // Insert query
    $sql = "INSERT INTO patients (name, age, gender, phone)
            VALUES ('$name', '$age', '$gender', '$phone')";

    if ($conn->query($sql) === TRUE) {
        echo "New patient added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html>
<head>
    <title>Add Patient</title>
</head>
<body>

<h2>Add Patient</h2>

<form method="POST" action="">
    Name: <input type="text" name="name" required><br><br>
    Age: <input type="number" name="age" required><br><br>
    Gender:
    <select name="gender" required>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
    </select><br><br>
    Phone: <input type="text" name="phone" required><br><br>

    <input type="submit" name="submit" value="Add Patient">
</form>

</body>
</html>
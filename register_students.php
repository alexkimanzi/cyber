<?php
include 'db.php';
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reg = $_POST['reg_no'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    $sql = "INSERT INTO students (reg_number, full_name, email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $reg, $name, $email);

    if ($stmt->execute()) {
        $msg = "<div class='alert alert-success'>Student Registered Successfully!</div>";
    } else {
        $msg = "<div class='alert alert-danger'>Error: Registration Number might already exist.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="col-md-6 mx-auto card p-4 shadow">
            <h3>Add New Student</h3>
            <?= $msg ?>
            <form method="POST">
                <div class="mb-3">
                    <label>Registration Number</label>
                    <input type="text" name="reg_no" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Full Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
                <a href="index.php" class="btn btn-secondary">Back to Home</a>
            </form>
        </div>
    </div>
</body>
</html>
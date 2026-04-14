<?php
include 'db.php';
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $unit_name = $_POST['unit_name'];

    // Prepared statement for security
    $sql = "INSERT INTO units (unit_name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $unit_name);

    if ($stmt->execute()) {
        $msg = "<div class='alert alert-success'>Unit '$unit_name' added successfully!</div>";
    } else {
        $msg = "<div class='alert alert-danger'>Error adding unit.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Unit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="col-md-6 mx-auto card p-4 shadow">
            <h3>Add New Unit/Course</h3>
            <?= $msg ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Unit Name</label>
                    <input type="text" name="unit_name" class="form-control" placeholder="e.g. Data Structures" required>
                </div>
                <button type="submit" class="btn btn-warning">Add Unit</button>
                <a href="index.php" class="btn btn-secondary">Back to Home</a>
            </form>
        </div>
    </div>
</body>
</html>
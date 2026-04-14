<?php
include 'db.php';

// Fetch all students
$sql = "SELECT * FROM students ORDER BY full_name ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <div class="d-flex justify-content-between mb-3">
                <h3><i class="fas fa-users me-2"></i>Registered Students List</h3>
                <a href="index.php" class="btn btn-secondary btn-sm">Back to Home</a>
            </div>
            <table class="table table-bordered table-hover bg-white">
                <thead class="table-dark">
                    <tr>
                        <th>Reg Number</th>
                        <th>Full Name</th>
                        <th>Email Address</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['reg_number']) ?></td>
                            <td><?= htmlspecialchars($row['full_name']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td class="text-center">
                                <a href="delete.php?type=student&id=<?= urlencode($row['reg_number']) ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Warning: Deleting this student will remove all their records. Continue?')">
                                   <i class="fas fa-trash-alt me-1"></i> Remove
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center">No students found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
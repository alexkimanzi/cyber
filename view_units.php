<?php
include 'db.php';

// Fetch all units
$sql = "SELECT * FROM units ORDER BY unit_name ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Units | Student Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <div class="d-flex justify-content-between mb-3">
                <h3><i class="fas fa-book-open me-2"></i>Available Academic Units</h3>
                <div>
                    <a href="add_unit.php" class="btn btn-success btn-sm">+ Add New Unit</a>
                    <a href="index.php" class="btn btn-secondary btn-sm">Home</a>
                </div>
            </div>
            
            <table class="table table-bordered table-hover bg-white">
                <thead class="table-dark text-center">
                    <tr>
                        <th style="width: 10%;">ID</th>
                        <th>Unit Name</th>
                        <th style="width: 20%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="text-center"><?= $row['unit_id'] ?></td>
                            <td><?= htmlspecialchars($row['unit_name']) ?></td>
                            <td class="text-center">
                                <a href="delete.php?type=unit&id=<?= $row['unit_id'] ?>" 
                                   class="btn btn-outline-danger btn-sm"
                                   onclick="return confirm('Are you sure? Removing this unit will affect any marks already assigned to it.')">
                                   <i class="fas fa-trash"></i> Remove
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="3" class="text-center">No units found. Click 'Add New Unit' to start.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
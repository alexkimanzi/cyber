<?php
include 'db.php';

// Capture the filter values from the URL
$student_filter = isset($_GET['student_reg']) ? $_GET['student_reg'] : '';
$unit_filter = isset($_GET['unit_id']) ? $_GET['unit_id'] : '';

// 1. Fetch Students and Units for the dropdown menus
$students_list = $conn->query("SELECT reg_number, full_name FROM students ORDER BY full_name ASC");
$units_list = $conn->query("SELECT unit_id, unit_name FROM units ORDER BY unit_name ASC");

// 2. Build the dynamic SQL query
$sql = "SELECT s.full_name, u.unit_name, m.score 
        FROM marks m
        JOIN students s ON m.student_reg = s.reg_number
        JOIN units u ON m.unit_id = u.unit_id";

$conditions = [];
if (!empty($student_filter)) {
    $conditions[] = "m.student_reg = '" . $conn->real_escape_string($student_filter) . "'";
}
if (!empty($unit_filter)) {
    $conditions[] = "m.unit_id = '" . $conn->real_escape_string($unit_filter) . "'";
}

if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$sql .= " ORDER BY s.full_name ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Performance Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3><i class="fas fa-chart-bar me-2 text-primary"></i>Consolidated Student Marks</h3>
                <a href="index.php" class="btn btn-secondary btn-sm">Back to Dashboard</a>
            </div>

            <form method="GET" class="row g-3 mb-4 p-3 bg-white rounded border shadow-sm">
                <div class="col-md-5">
                    <label class="form-label fw-bold">Filter by Student</label>
                    <select name="student_reg" class="form-select">
                        <option value="">-- All Students --</option>
                        <?php while($st = $students_list->fetch_assoc()): ?>
                            <option value="<?= $st['reg_number'] ?>" <?= ($student_filter == $st['reg_number']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($st['full_name']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Filter by Unit</label>
                    <select name="unit_id" class="form-select">
                        <option value="">-- All Units --</option>
                        <?php while($un = $units_list->fetch_assoc()): ?>
                            <option value="<?= $un['unit_id'] ?>" <?= ($unit_filter == $un['unit_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($un['unit_name']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100">Apply Filter</button>
                    <a href="view_marks.php" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Student Name</th>
                            <th>Unit Name</th>
                            <th class="text-center">Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($result && $result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['full_name']) ?></td>
                                <td><?= htmlspecialchars($row['unit_name']) ?></td>
                                <td class="text-center">
                                    <span class="badge <?= ($row['score'] >= 40) ? 'bg-success' : 'bg-danger' ?> p-2">
                                        <?= $row['score'] ?>%
                                    </span>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="3" class="text-center py-4 text-muted">No records found matching your selection.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
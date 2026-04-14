<?php
include 'db.php';
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_marks'])) {
    $reg = $_POST['reg_no'];
    $scores = $_POST['scores']; // Array of unit_id => score

    // 1. Verify student exists to avoid Foreign Key errors
    $check = $conn->prepare("SELECT reg_number FROM students WHERE reg_number = ?");
    $check->bind_param("s", $reg);
    $check->execute();
    $student_exists = $check->get_result()->num_rows > 0;

    if (!$student_exists) {
        $msg = "<div class='alert alert-warning'><strong>Error:</strong> Student ID <b>$reg</b> not found in records.</div>";
    } else {
        try {
            foreach ($scores as $unit_id => $score) {
                // Only process if a mark was actually typed
                if ($score !== "") {
                    // Check if mark already exists for this student/unit
                    $mark_check = $conn->prepare("SELECT id FROM marks WHERE student_reg = ? AND unit_id = ?");
                    $mark_check->bind_param("si", $reg, $unit_id);
                    $mark_check->execute();
                    $has_mark = $mark_check->get_result()->num_rows > 0;

                    if ($has_mark) {
                        // UPDATE existing mark
                        $sql = "UPDATE marks SET score = ? WHERE student_reg = ? AND unit_id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("isi", $score, $reg, $unit_id);
                    } else {
                        // INSERT new mark
                        $sql = "INSERT INTO marks (student_reg, unit_id, score) VALUES (?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("sii", $reg, $unit_id, $score);
                    }
                    $stmt->execute();
                }
            }
            $msg = "<div class='alert alert-success'><strong>Success!</strong> All marks updated for student: $reg.</div>";
        } catch (Exception $e) {
            // This catches any database errors and shows a friendly message
            $msg = "<div class='alert alert-danger'><strong>System Error:</strong> Data could not be saved. Please try again later.</div>";
        }
    }
}

// Fetch Data for the Form
$students = $conn->query("SELECT reg_number, full_name FROM students ORDER BY full_name ASC");
$units = $conn->query("SELECT * FROM units ORDER BY unit_name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Student Marks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="col-md-8 mx-auto card p-4 shadow border-0">
            <h3 class="mb-4 text-center text-primary">Academic Mark Entry</h3>
            
            <?= $msg ?>
            
            <form method="POST">
                <div class="mb-4 p-3 border rounded bg-white">
                    <label class="form-label fw-bold">1. Select Registered Student</label>
                    <select name="reg_no" class="form-select" required>
                        <option value="">-- Choose Student --</option>
                        <?php while($st = $students->fetch_assoc()): ?>
                            <option value="<?= $st['reg_number'] ?>">
                                <?= htmlspecialchars($st['full_name']) ?> (<?= $st['reg_number'] ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">2. Enter Scores for All Units</label>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Unit Name</th>
                                    <th style="width: 180px;">Score (0-100)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($units->num_rows > 0): ?>
                                    <?php while($u = $units->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($u['unit_name']) ?></td>
                                        <td>
                                            <input type="number" name="scores[<?= $u['unit_id'] ?>]" 
                                                   class="form-control" min="0" max="100" placeholder="Mark">
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="2" class="text-center text-danger">Please add units first!</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="index.php" class="btn btn-outline-secondary">Back to Dashboard</a>
                    <button type="submit" name="submit_marks" class="btn btn-primary px-5 shadow-sm">Save All Records</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
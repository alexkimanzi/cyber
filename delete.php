<?php
include 'db.php';

if (isset($_GET['type']) && isset($_GET['id'])) {
    $type = $_GET['type'];
    $id = $_GET['id'];

    if ($type == 'student') {
        // Prepare the delete statement
        $sql = "DELETE FROM students WHERE reg_number = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id);
    } 
    elseif ($type == 'unit') {
        $sql = "DELETE FROM units WHERE unit_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
    }

    if ($stmt->execute()) {
        // Redirect back to the page you came from with a success message
        header("Location: " . $_SERVER['HTTP_REFERER'] . "?msg=deleted");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>
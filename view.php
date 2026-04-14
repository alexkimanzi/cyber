<?php
include('../config/db.php');
include('../security.php'); // Protects the page
$query = "SELECT * FROM visitstable";
$result = mysqli_query($conn, $query);
?>

<h2>Patient Visit Records</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>Visit ID</th>
        <th>Patient ID</th>
        <th>Visit Type</th>
        <th>Schedule</th>
        <th>Actions</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row['visitsid']; ?></td>
        <td><?php echo $row['patientid']; ?></td>
        <td><?php echo $row['visittype']; ?></td>
        <td><?php echo $row['visitsschedule']; ?></td>
        <td>
            <a href="edit.php?id=<?php echo $row['visitsid']; ?>">Edit</a> | 
            <a href="delete.php?id=<?php echo $row['visitsid']; ?>" onclick="return confirm('Delete this record?')">Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>
<br>
<a href="add.php">Add New Visit</a>
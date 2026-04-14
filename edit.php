<?php
include('../config/db.php');
include('../security.php');

$id = $_GET['id'];
$res = mysqli_query($conn, "SELECT * FROM visitstable WHERE visitsid=$id");
$row = mysqli_fetch_assoc($res);

if(isset($_POST['update'])) {
    $type = $_POST['visittype'];
    $sched = $_POST['visitsschedule'];
    mysqli_query($conn, "UPDATE visitstable SET visittype='$type', visitsschedule='$sched' WHERE visitsid=$id");
    header("Location: view.php");
}
?>

<form method="POST">
    <h3>Edit Visit #<?php echo $id; ?></h3>
    Type: <input type="text" name="visittype" value="<?php echo $row['visittype']; ?>"><br><br>
    Schedule: <input type="datetime-local" name="visitsschedule" value="<?php echo date('Y-m-d\TH:i', strtotime($row['visitsschedule'])); ?>"><br><br>
    <button type="submit" name="update">Update</button>
</form>
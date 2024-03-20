<!--</?php
include ('dbconnect.php');

// Check if tenants_id is set and is a valid integer
if (!isset($_POST['studentNumber']) || !ctype_digit($_POST['studentNumber'])) {
    echo "Invalid studentNumber";
    exit;
}

$id = $_POST['studentNumber'];

// Get the room number and dorm name of the removed student
//$stmt = mysqli_prepare($con, "SELECT room, dorm_name FROM tenants WHERE tenants_id = ?");
//mysqli_stmt_bind_param($stmt, "i", $id);
//mysqli_stmt_execute($stmt);
//$result2 = mysqli_stmt_get_result($stmt);
//$row = mysqli_fetch_assoc($result2);
//$room_number = $row['room'];
//$dorm_name = $row['dorm_name'];

// Use prepared statement to prevent SQL injection
$stmt = mysqli_prepare($con, "UPDATE tenants SET dorm_name = '', room = '' WHERE studnum = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
$result1 = mysqli_stmt_execute($stmt);

$stmt = mysqli_prepare($con, "DELETE FROM occupied_room WHERE academicYear = ? AND semesTer = ? AND studentNumber = ?");
mysqli_stmt_bind_param($stmt, "sss", $_SESSION['academic_year'], $_SESSION['semester'], $id);
$result1 = mysqli_stmt_execute($stmt);

// Update the available_beds value in the room_list table
//mysqli_query($con, "UPDATE room_list SET available_beds = available_beds + 1 WHERE dorm_name = '$dorm_name' AND room_number = '$room_number' "); 

?>-->

<?php
include('dbconnect.php');


if (!isset($_POST['studentNumber']) || !ctype_digit($_POST['studentNumber'])) {
    echo "Invalid studentNumber";
    exit;
}

$id = $_POST['studentNumber'];


$stmt = mysqli_prepare($con, "UPDATE tenants SET dorm_name = '', room = '' WHERE studnum = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
$result1 = mysqli_stmt_execute($stmt);

$stmt = mysqli_prepare($con, "DELETE FROM occupied_room WHERE academicYear = ? AND semesTer = ? AND studentNumber = ?");
mysqli_stmt_bind_param($stmt, "ssi", $_SESSION['academic_year'], $_SESSION['semester'], $id);
$result2 = mysqli_stmt_execute($stmt);

if ($result1 && $result2) {
    echo "Deletion successful"; 
} else {
    echo "Deletion failed"; 
}

?>
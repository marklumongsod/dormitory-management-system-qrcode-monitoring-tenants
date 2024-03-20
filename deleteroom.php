<?php
include ('dbconnect.php');
$id = $_POST['id'];

$response = array();

// Delete record from database
if(mysqli_query($con,"DELETE FROM room_list WHERE id='$id'")) {
    $response['success'] = true;
} else {
    $response['success'] = false;
}

echo json_encode($response);
?>

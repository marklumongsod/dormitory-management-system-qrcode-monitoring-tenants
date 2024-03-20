<?php
include ('../dbconnect.php');
$id = $_POST['id'];

$response = array();

// Delete record from database
if(mysqli_query($con,"DELETE FROM user WHERE acc_id='$id'")) {
    $response['success'] = true;
} else {
    $response['success'] = false;
}

echo json_encode($response);
?>
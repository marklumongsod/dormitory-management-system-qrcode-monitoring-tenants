<?php
include ('dbconnect.php');

// Check if the ID parameter is present and not empty
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];

    // Delete related payments first
    $result = mysqli_query($con,"delete from payment where tenant_id='$id'") or die(mysqli_error($con));

    // Delete the tenant
    $result = mysqli_query($con,"delete from tenants where tenants_id='$id'") or die(mysqli_error($con));

    // Check if the tenant was deleted
    if (mysqli_affected_rows($con) > 0) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
    }
    echo json_encode($response);
    exit();
} else {
    echo "Error: Missing or invalid ID parameter";
    exit();
}
?>
<?php
session_start();
include("dbconnect.php");

if (isset($_POST['text']) && isset($_POST['time-option'])) {
    date_default_timezone_set("Asia/Manila");
    $text = $_POST['text'];
    $date = date('Y-m-d');
    $time = date('h:i:s A');
    $action = $_POST['time-option'];
    $origin = $_POST['origin-option'];
    $destination = $_POST['destination-option'];

    
    $sql = "SELECT fname, mname, lname, studnum, status FROM tenants WHERE studnum='$text'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['fname'] . ' ' . $row['lname'];
        $tenantStatus = $row['status'];

        if ($tenantStatus == 'Inactive') {
            $_SESSION['error'] = '<center>You are an inactive boarder. Please consult with the dormitory manager.</center>';
            $_SESSION['status_codee'] = "alert alert-danger";
        } else {
            if ($action == 'timeout') {

                if ($destination === 'Other') {
                    $otherDestination = mysqli_real_escape_string($con, $_POST['other-option']);
                    $destination = $otherDestination;
                }   
            
                $sql = "SELECT * FROM tbl_attendance WHERE tenant_studnum='$text' AND logdate='$date' AND status='0' ";
                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                    $_SESSION['error'] = '<center>Your previous action was a time-out. Please select time-in if you intend to enter.</center>';
                    $_SESSION['status_codee'] = "alert alert-danger";
                } else {
                    $sql = "INSERT INTO tbl_attendance(tenant_studnum, tenant_name, time_out, destination, logdate, status) VALUES('$text', '$name', '$time','$destination', '$date', '0')"; 
                    if($con->query($sql) === TRUE) { 
                        $last_id = $con->insert_id; // Get the last inserted ID
                        $sql = "SELECT tenant_name FROM tbl_attendance WHERE id = '$last_id'";
                        $result = $con->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $name = $row['tenant_name'];
                            }
                        }
                        $_SESSION['statuss'] = '<center>Hello, have a wonderful day <strong><br> '.$name.' </strong> <br> You have successfully timed out!</center>';
                        $_SESSION['status_code'] = "alert alert-success";
                    } else {
                        $_SESSION['error'] = $con->error;
                    }
                }
            } elseif ($action == 'timein') {
                
                if ($origin === 'Other') {
                    $otherOrigin = mysqli_real_escape_string($con, $_POST['other-option']);
                    $origin = $otherOrigin;
                }
                
                $sql = "SELECT * FROM tbl_attendance WHERE tenant_studnum='$text' AND logdate='$date' AND status='0' ";
                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                    $sql = "UPDATE tbl_attendance SET time_in='$time', origin='$origin' ,status='1' WHERE tenant_studnum='$text' AND logdate='$date' AND status='0' ";
                    if($con->query($sql) === TRUE) { 
                        $last_id = $con->insert_id; // Get the last inserted ID
                        $sql = "SELECT tenant_name FROM tbl_attendance WHERE id = '$last_id'";
                        $result = $con->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $name = $row['tenant_name'];
                            }
                        }
                        $_SESSION['statuss'] = '<center>Welcome back! <strong><br> '.$name.' </strong><br> You have successfully timed in!</center>';
                        $_SESSION['status_code'] = "alert alert-success";
                    }
                } else {
                    $_SESSION['error'] = '<center>Your previous action was a time-in. If you intend to leave, please select time-out.</center>';
                    $_SESSION['status_codee'] = "alert alert-danger";
                }
            }
        }
    } else {
        $_SESSION['error'] = 'The QR code is not registered. Unregistered QR code detected!';
        $_SESSION['status_codee'] = "alert alert-danger";
        header("location: qrscanner.php");
        exit;
    }
}

$con->close();
header("location: qrscanner.php");
exit;
?>
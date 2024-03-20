<?php
include ('dbconnect.php');
$id = $_POST['id'];

$response = array();

// Get payment amount, payment type, student number, academic year, and semester
$result = mysqli_query($con, "SELECT amount, electricity_fee, payment, student_number, academic_year, semester FROM payment WHERE payment_id='$id'");
$row = mysqli_fetch_array($result);
$amount = $row['amount'];
$electricity_fee = $row['electricity_fee'];
$student_number = $row['student_number'];
$academic_year = $row['academic_year'];
$semester = $row['semester'];
$payment = $row['payment'];

// Delete record from payment table
if(mysqli_query($con, "DELETE FROM payment WHERE payment_id='$id'")) {

    // Check the payment type
    if ($payment == 'Electricity Fee') {
        // If the payment is "Electricity Fee", only delete the record
        $response['success'] = true;
    } elseif ($payment == 'Dorm Rental Fee') {
        // If the payment is "Dorm Rental Fee", update the room assignment and add the payment amount back to the balance
        if(mysqli_query($con, "UPDATE room_assignments SET balance = balance + $amount WHERE student_number='$student_number' AND academic_year='$academic_year' AND semester='$semester' ")) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
        }
    }
} else {
    $response['success'] = false;
}

echo json_encode($response);
?>

<?php


include("dbconnect.php"); 

$personname = $_POST['personname'];

 
 $query = "SELECT * FROM tenants WHERE studnum = '$personname' ";
 $result = $con->query($query);


 $options = '';
if($result->num_rows > 0){
while($row = $result->fetch_assoc()){
$dorm_name = $row['dorm_name'];
$room_number = $row['room'];
$options .= '<option value="'.$dorm_name.' '.$room_number.'">'.$dorm_name.' '.$room_number.'</option>';
}
}

 echo $options;
?>
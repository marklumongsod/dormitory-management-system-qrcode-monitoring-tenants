<?php

include("dbconnect.php");


$dorm_name = $_POST['dorm_name'];


$query = "SELECT DISTINCT room_number FROM room_list WHERE dorm_name = '$dorm_name' ORDER BY room_number ASC";
$result = $con->query($query);


$options = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $room_number = $row['room_number'];
        $options .= '<option value="' . $room_number . '">' . $room_number . '</option>';
    }
}


echo $options;
?>
<?php
include('dbconnect.php');

if(isset($_POST["id"]))  
{
    $output = '';
    
    
    $id = mysqli_real_escape_string($con, $_POST["id"]);

    
    $query = "select * from tenants where tenants_id = ? ";
    
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    while($row=mysqli_fetch_assoc($result))
    {
        $name = $row['fname']. ' ' .$row['mname']. ' ' .$row['lname'];    
        $gender = $row['gender'];
        $contactnumber = $row['contactnumber'];
        $email = $row['email'];
        $address = $row['address'];
        $studnum = $row['studnum'];
        $year = $row['year'];
        $course = $row['course'];
        $department = $row['department'];
        $guardianname = $row['guardianname']; 
        $guardiancontact = $row['guardiancontact']; 
        $relation = $row['relation']; 
        $room = $row['room']; 
        $status = $row['status']; 
        $birthdate = $row['birthdate']; 
        $birthplace = $row['birthplace']; 
        $guardianoccupation = $row['guardianoccupation']; 
        $guardianemail = $row['guardianemail']; 
        $guardianaddress = $row['guardianaddress'];  
    }    


    $query = "SELECT * FROM room_list
              LEFT JOIN dorm_list ON dorm_list.name = room_list.dorm_name
              WHERE dorm_list.id = ?  ";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $output .= '
                <legend>Personal Information</legend>
                <p><b>Name: </b>' . $name . '</p>
                <p><b>Gender: </b>' . $gender . '</p>
                <p><b>Contact Number: </b>' . $contactnumber . '</p>
                <p><b>Email: </b>' . $email . '</p>
                <p><b>Current Address: </b>' . $address . '</p>
                <p><b>Birth Date: </b>' . date('F j, Y', strtotime($birthdate)) . '</p>
                <p><b>Birth place: </b>' . $birthplace . '</p>
                <hr>
                <legend>School Information</legend>
                <p><b>Student Number: </b>' . $studnum . '</p>
                <p><b>Year and Section: </b>' . $year . '</p>
                <p><b>Course: </b>' . $course . '</p>
            
                <hr>
                <legend>Emergency Details</legend>
                <p><b>Guardian Name: </b>' . $guardianname . '</p>
                <p><b>Guardian Occupation: </b>' . $guardianoccupation . '</p>
                <p><b>Guardian Email: </b>' . $guardianemail . '</p>
                <p><b>Contact Number: </b>' . $guardiancontact . '</p>
                <p><b>Guardian Address: </b>' . $guardianaddress . '</p>
                <p><b>Relation: </b>' . $relation . '</p>
            ';
    echo $output; 
}
?>
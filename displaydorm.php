<?php
include('dbconnect.php');

if(isset($_POST["id"]))  
{
    $output = '';
    
   
    $id = mysqli_real_escape_string($con, $_POST["id"]);

  
    $query = "SELECT * FROM dorm_list
              WHERE id = ?";
    
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    while($row=mysqli_fetch_assoc($result))
    {
        $name = $row['name'];    
        $status = $row['status']; 
    }    

   
    $query = "SELECT * FROM room_list
              LEFT JOIN dorm_list ON dorm_list.name = room_list.dorm_name
              WHERE dorm_list.id = ?  ";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $output .= '
        <p><b>Dorm name: </b>' . $name . '</p>
        <p><b>Status: </b><b style="color: red;">' . $status . '</b></p>
        <legend><b><hr>Dorm rooms are listed below.</b></legend>';

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $output .= '<br><b>Room: </b>'. $row['room_number'];
        }
    } else {
        $output .= '<p>No rooms have been created yet.</p>';
    }
    echo $output; 
}
?>
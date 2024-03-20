<?php
include('dbconnect.php');

session_start();


if (isset($_SESSION['semester'])) {
    $semester = $_SESSION['semester'];
} else {
    $semester = 'First Semester'; 
}

if (isset($_POST["id"])) {
    $output = '';

   
    $id = mysqli_real_escape_string($con, $_POST["id"]);

 
    $query = "SELECT * FROM room_list
              WHERE id = ?";

    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $room_img = $row['room_img'];
        $dorm_name = $row['dorm_name'];
        $room_number = $row['room_number'];
        $slots = $row['beds'];
        $price = $row['price'];
        $status = $row['status'];
        $description = $row['description'];
    }

  
    $academic_year = (date('Y') - 1) . '-' . date('Y');


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $academic_year = isset($_POST['academic_year']) ? $_POST['academic_year'] : $academic_year;
        $semester = isset($_POST['semester']) ? $_POST['semester'] : $semester;

        $_SESSION['academic_year'] = $academic_year;
        $_SESSION['semester'] = $semester;
    }

   
    $query = "SELECT DISTINCT tenants.fname, tenants.lname, room_assignments.student_number FROM room_list
    LEFT JOIN room_assignments ON room_assignments.room_id = room_list.room_number 
    JOIN tenants ON tenants.studnum = room_assignments.student_number
    WHERE room_list.id = ? 
    AND room_assignments.dormname = room_list.dorm_name AND room_assignments.academic_year = ? AND room_assignments.semester = ?";

    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'iss', $id, $academic_year, $semester);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    echo '<form method="post" action="" id="filter-form" hidden>
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <select class="form-control form-control-sm rounded-3 shadow" name="academic_year" id="academic_year" required="required">
                    <i class="fa fa-filter"></i>
                    <option value="">Select Academic Year</option>';

    $query = "SELECT DISTINCT academic_year FROM room_assignments ORDER BY academic_year DESC";
    $result_academic_year = $con->query($query);
    if ($result_academic_year->num_rows > 0) {
        while ($optionData = $result_academic_year->fetch_assoc()) {
            $option = $optionData['academic_year'];
            $selected = ($academic_year == $option) ? 'selected' : '';
            echo '<option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
        }
    }
    echo '</select>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <select class="form-control form-control-sm rounded-3 shadow" name="semester" id="semester" required="required">
                    <i class="fa fa-filter"></i>
                    <option value="">Select Semester</option>
                    <option value="First Semester"';
    if ($semester == 'First Semester') {
        echo ' selected';
    }
    echo '>First Semester</option>
                    <option value="Second Semester"';
    if ($semester == 'Second Semester') {
        echo ' selected';
    }
    echo '>Second Semester</option>
                </select>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <button type="submit" id="filter" class="btn btn-primary btn-sm bg-primary rounded-3 shadow">
                    <i class="fa fa-filter"></i> Filter
                </button>
            </div>
        </div>
    </div>
</form>';

$output .= '
<div style="display: flex; justify-content: center;">
    ';

if (!empty($room_img)) {
    $output .= '<img src="' . $room_img . '" alt="Room Image" style="max-width: 200px; height: auto;">';
} else {
    $output .= '<p>Room photo is not available</p>';
}

$output .= '
</div>
<p><b>Dorm name: </b>' . $dorm_name . '</p>
<p><b>Room: </b>' . $room_number . '</p>
<p><b>Description: </b>' . $description . '</p>
<p><b>Bed/s: </b>' . $slots . '</p>
<p><b>Price Per Semester: </b>₱' . number_format($price, 2) . '</p>
<p><b>Status: </b><b style="color: red;">' . $status . '</b></p><hr>
<legend><b>This room contains the following students:</b></legend>';


if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $output .= '<br><i class="fas fa-user"></i>' . ' <strong>' . $row['student_number'] . '</strong> ' . $row['fname'] . ' ' . $row['lname'];
        //$output .= ' <button onclick="removeStudent(' . $row['studentNumber'] . ')">Remove</button>';
    }
} else {
    $output .= '<p>No students assigned in the room.</p>';
}

    echo $output;
}
?>

<script>
    function removeStudent(studentId) {
        if (confirm('Are you sure you want to remove this student from the room?')) {
          
            $.ajax({
                type: "POST",
                url: "remove_student_room.php",
                data: {studentNumber: studentId},
                success: function (response) {
                
                    alert("The student has been removed from the room.");
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }
    }
</script>

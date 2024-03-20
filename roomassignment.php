<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
include("dbconnect.php");

$adminId = $_SESSION['id']; 
$query = mysqli_query($con, "SELECT fullname FROM user WHERE acc_id = '$adminId'");
$row = mysqli_fetch_assoc($query);
$adminName = $row['fullname'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    if (array_key_exists("student_number", $_POST)) {
      
        $student_number = $_POST["student_number"];
        $academic_year = $_POST["academic_year"];
        $semester = $_POST["semester"];
        $balance = "";
        $room_id = "";
        $dorm_name = "";
        if (!empty($_POST["room_number"])) {
            $room_id = $_POST["room_number"];
        }
        if (!empty($_POST["dorm_name"])) {
            $dorm_name = $_POST["dorm_name"];
        }
        if (!empty($_POST["price"])) {
            $balance = $_POST["price"];
        }
 
        $academicYear = isset($_POST['academic_year']) ? $_POST['academic_year'] : $academic_year;
        $semester = isset($_POST['semester']) ? $_POST['semester'] : $semester;

       
        $query = "SELECT COUNT(*) AS assigned_count FROM room_assignments WHERE dormname = ? AND room_id = ? AND academic_year = ? AND semester = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "siss", $dorm_name, $room_id, $academic_year , $semester);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $assigned_count = $row['assigned_count'];

       
        $query = "SELECT beds FROM room_list WHERE dorm_name = ? AND room_number = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "si", $dorm_name, $room_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $beds = $row['beds'];
        
       
        $available_beds = $beds - $assigned_count;

        
        if ($available_beds > 0) {
           
            $query = "SELECT * FROM room_assignments WHERE student_number = ? AND dormname = ? AND academic_year = ? AND semester = ?";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, "ssss", $student_number, $dorm_name, $academic_year, $semester);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

          
            $query = "SELECT * FROM room_assignments WHERE student_number = ? AND academic_year = ? AND semester = ?";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, "sss", $student_number, $academic_year, $semester);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
             
                $_SESSION['statuss'] = "Error! The student is already assigned in the same academic year and semester";
                $_SESSION['status_code'] = "error";
            } else {
               
                $query = "INSERT INTO room_assignments (student_number, room_id, dormname, balance, academic_year, semester) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($stmt, "sissss", $student_number, $room_id, $dorm_name, $balance, $academic_year, $semester);
                mysqli_stmt_execute($stmt);

                // Insert new data into the occupied_room table
                //$query = "INSERT INTO occupied_room (studentNumber, dormName, roomNumber, academicYear, semesTer) VALUES (?, ?, ?, ?, ?)";
                //$stmt = mysqli_prepare($con, $query);
                //mysqli_stmt_bind_param($stmt, "ssiss", $student_number, $dorm_name, $room_id, $academic_year, $semester);
                //mysqli_stmt_execute($stmt);

                // Update the tenants table with the assigned dorm and room
                $query = "UPDATE tenants SET dorm_name = ?, room = ? WHERE studnum = ?";
                $stmt = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($stmt, "ssi", $dorm_name, $room_id, $student_number);
                $stmt->execute();

                $_SESSION['statuss'] = "Successfully assigned to a room.";
                $_SESSION['status_code'] = "success";

                // Redirect to a success page or display a success message
                // header("Location: success.php");
                // exit();
            }
        } else {
            
            $_SESSION['statuss'] = "Error! There are no available beds in the room";
            $_SESSION['status_code'] = "error";
        }
    } else {
       
    }
}
?>

<?php



$academic_year = (date('Y')-1).'-'.date('Y');
$semester = 'First Semester';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $academic_year = isset($_POST['academic_year']) ? $_POST['academic_year'] : $academic_year;
    $semester = isset($_POST['semester']) ? $_POST['semester'] : $semester;
    
    $_SESSION['academic_year'] = $academic_year;
    $_SESSION['semester'] = $semester;
} else {
    
    if (isset($_SESSION['academic_year'])) {
        $academic_year = $_SESSION['academic_year'];
    }
    if (isset($_SESSION['semester'])) {
        $semester = $_SESSION['semester'];
    }
}



?>
      
 

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/CvSUlogo.png">
  <title>DMS Room Assignment</title>
<!--     Fonts and icons     -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <link href="./assets/css/style.css" rel="stylesheet" />
  <!-- Data tables -->
  <link href="https://code.jquery.com/jquery-3.5.1.js" rel="stylesheet" />
  <script type="text/javascript" src="assets/js/jquery-3.5.1.js"></script>
  <script type="text/javascript" src="assets/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link rel="stylesheet" href="assets/css/style.css" />
  <link rel="stylesheet" href="assets/css/modal.content.css" />
  <link rel="stylesheet" href="assets/css/button.css" />
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js"></script>


  <!-- CSS Files -->
  <link id="pagestyle" href="./assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
     <link rel="stylesheet" href="css/styles.index.css" />-->
<style>
.group {
  display: flex;
  line-height: 28px;
  align-items: center;
  position: relative;
  max-width: 590px;
}

.input {
  height: 40px;
  line-height: 28px;
  padding: 0 1rem;
  width: 430px;
  padding-left: 2.5rem;
  border: 2px solid transparent;
  border-radius: 8px;
  outline: none;
  background-color: #D9E8D8;
  color: #0d0c22;
  box-shadow: 0 0 5px #C1D9BF, 0 0 0 10px #f5f5f5eb;
  transition: .3s ease;
}

.input::placeholder {
  color: #777;
}

.icon1 {
  position: absolute;
  left: 1rem;
  fill: #777;
  width: 1rem;
  height: 1rem;
}


a#GFG {
  color: #fff; 
}
.custom-color {
  background-color: #DCB601;
  border-radius: 20px;
}
.nav-link:hover {
  background-color: #f0f0f0;
  color: #333;
  border-radius: 10px
} 

.dropdown-container {
        border: 1px solid #ced4da; 
        border-radius: 0.25rem; 
        padding: 0.375rem 0.75rem; 
    }

    .searchable-dropdown {
      width: 380px;
        font-size: 1rem; 
        line-height: 1.5; 
        border: none; 
        background-color: white; 
    }
</style>

</head>

<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 position-absolute w-100"
    style="background-image: url('https://cvsu.edu.ph/wp-content/uploads/2022/10/image2-2.jpeg'); background-repeat: no-repeat;background-position: center center; background-size: cover;">
  </div>
  </div>
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-2 border-radius-md my-3 shadow fixed-start ms-4 " id="sidenav-main" style="border: solid #046621;">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
        aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="#" style="text-align:center;">
        <img src="./assets/img/CvSUlogo.png" class="navbar-brand-img h-100" alt="main_logo"><br>
        Dormitory Management System
      </a>
    </div>

    <br>
    <hr class="horizontal dark mt-0">

    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link " href="index.php">
          <div
            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-tachometer-alt text-primary text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link active " href="tenants.php">
          <div
            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-users text-warning text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Student Boarders</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="dorm.php">
          <div
            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-building text-success text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Dorm List</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="room.php">
          <div
            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-door-closed text-info opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">List of Rooms</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="payment.php">
          <div
            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-credit-card text-secondary text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Payment</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="report.php">
          <div
            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-file-invoice text-danger text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Reports</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="guardian.php">
          <div
            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-user-nurse text-muted text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Emergency Details</span>
        </a>
      </li>
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Logs</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="studenthistorylogs.php">
          <div
            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-user-clock text-dark text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Borders Logs</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="visitorhistorylogs.php">
          <div
            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-user-clock text-dark text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Visitors Logs</span>
        </a>
      </li>
      <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Set Data</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="acad_year_semester.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-filter text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Academic Year / Semester</span>
          </a>
        </li>
    </ul>
    <br>
  </aside>
  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur"
      data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">

            <ul class="navbar-nav  justify-content-end">
              <li class="nav-item dropdown">
                <a class="nav-link1 dropdown-toggle second-text text-white fw-bold" href="#" id="navbarDropdown"
                  role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-user me-2"></i><?php echo $adminName; ?>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="profile.php">View Profile</a></li>
                  <li><a class="dropdown-item" href="changelogindetails.php">Change Password</a></li>
                  <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
    </nav>
    <br><br><br><br><br><br><br><br><br><hr>
    <div class="container-fluid px-4">

      

      <div class="card-body custom-color p-3 shadow">
        <div class="row">
          <div class="col-8">
            <h3 class="text-right mb-0" style="text-transform: uppercase; font-size: 20px; color: #046621; padding: 10px;">
            Room Assignment</h3>
          </div>
        </div>
      </div>

      <!--Add Button-->
      <div class="d-flex m-3 justify-content-start">
        <a class="button-option me-2" id="GFG" href="tenants.php">
          <span class="transition"></span>
          <span class="gradient"></span>
          <span class="label">Back</span>
        </a>
      </div>

      <form method="post" action="" id="filter-form" hidden>
            <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
            <select class="form-control form-control-sm rounded-3 shadow" name="academic_year" id="academic_year" required="required">
                            <i class="fa fa-filter"></i>
                            <option value=" ">Select Academic Year</option>
                            <?php 
                            $query ="SELECT DISTINCT academic_year FROM room_assignments ORDER BY academic_year DESC";
                            $result_academic_year = $con->query($query);
                            if($result_academic_year->num_rows> 0){
                                while($optionData=$result_academic_year->fetch_assoc()){
                                    $option =$optionData['academic_year'];
                                    ?>
                                    <option value="<?php echo $option; ?>" <?php if($academic_year == $option) echo 'selected'; ?>><?php echo $option; ?> </option> 
                                    <?php
                                }
                            }
                            ?>
                        </select>
            </div>
        </div>

                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                    <select class="form-control form-control-sm rounded-3 shadow" name="semester" id="semester" required="required">
                            <i class="fa fa-filter"></i>
                            <option value=" ">Select Semester</option>
                            <option value="First Semester" <?php if($semester == 'First Semester') echo 'selected'; ?>>First Semester</option>
                            <option value="Second Semester" <?php if($semester == 'Second Semester') echo 'selected'; ?>>Second Semester</option>
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
        </form>

      <?php 
                        if(isset($_SESSION['statuss']))
                        {
                            ?>
                                <script>
                                    swal({
                                        title: "<?php echo $_SESSION['statuss']; ?>",
                                        icon: "<?php echo $_SESSION['status_code']; ?>",
                                        button: "OK",
                                    }).then(function() {
                                        window.location.href = "roomassignment.php";
                                    });
                                </script> 
                       <?php 
                            unset($_SESSION['statuss']);
                       }
                    ?>
                    <!-- Search form --><br>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label for="fee_type" class="control-label">Dorm intended for:</label><br> 
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="dorm_intended" id="All" value="All"<?php echo (isset($_POST['dorm_intended']) && $_POST['dorm_intended'] === 'All') ? ' checked' : ''; ?>>
                <label class="form-check-label" for="All">All</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="dorm_intended" id="Female" value="Female"<?php echo (isset($_POST['dorm_intended']) && $_POST['dorm_intended'] === 'Female') ? ' checked' : ''; ?>>
                <label class="form-check-label" for="Female">Female</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="dorm_intended" id="Male" value="Male"<?php echo (isset($_POST['dorm_intended']) && $_POST['dorm_intended'] === 'Male') ? ' checked' : ''; ?>>
                <label class="form-check-label" for="Male">Male</label>
            </div>
           
            <button class="btn btn-secondary" type="submit" name="filter">Filter</button>
            <br><br><br>
            <input type="text" name="search_query" id="search_query" placeholder="Search" class="form-control">
            <button class="btn btn-secondary" type="submit" name="filter" hidden>Filter</button>
        </div>
    </div>
</form>
    
                    <?php
                    
                    $dorm_intended = isset($_POST['dorm_intended']) ? $_POST['dorm_intended'] : '';

                  
                    $search_query = isset($_POST['search_query']) ? $_POST['search_query'] : '';

                    if ($dorm_intended === "Female") {
                       
                        $sql = "SELECT room_list.dorm_name, room_list.price, room_list.room_number, room_list.beds, room_list.available_beds, room_list.description, room_list.room_img, room_list.status, dorm_list.intended
                                FROM room_list 
                                LEFT JOIN room_assignments ON room_list.id = room_assignments.room_id 
                                LEFT JOIN dorm_list ON room_list.dorm_name = dorm_list.name
                                WHERE room_list.status = 'Active' AND dorm_list.intended = 'Female' 
                                AND (room_list.dorm_name LIKE '%$search_query%' OR room_list.room_number LIKE '%$search_query%')
                                GROUP BY room_list.id, room_list.dorm_name 
                                ORDER BY room_list.id;
                        ";
                    } else if ($dorm_intended === "Male") {
                     
                        $sql = "SELECT room_list.dorm_name, room_list.price, room_list.room_number, room_list.beds, room_list.available_beds, room_list.description, room_list.room_img, room_list.status, dorm_list.intended
                                FROM room_list 
                                LEFT JOIN room_assignments ON room_list.id = room_assignments.room_id 
                                LEFT JOIN dorm_list ON room_list.dorm_name = dorm_list.name
                                WHERE room_list.status = 'Active' AND dorm_list.intended = 'Male' 
                                AND (room_list.dorm_name LIKE '%$search_query%' OR room_list.room_number LIKE '%$search_query%')
                                GROUP BY room_list.id, room_list.dorm_name 
                                ORDER BY room_list.id;
                        ";
                    } else if ($dorm_intended === "All") {
                       
                        $sql = "SELECT room_list.dorm_name, room_list.price, room_list.room_number, room_list.beds, room_list.available_beds, room_list.description, room_list.room_img, room_list.status, dorm_list.intended
                                FROM room_list 
                                LEFT JOIN room_assignments ON room_list.id = room_assignments.room_id 
                                LEFT JOIN dorm_list ON room_list.dorm_name = dorm_list.name
                                WHERE room_list.status = 'Active'
                                AND (room_list.dorm_name LIKE '%$search_query%' OR room_list.room_number LIKE '%$search_query%')
                                GROUP BY room_list.id, room_list.dorm_name 
                                ORDER BY room_list.id;
                        ";
                    }else {
                    
                      $sql = "SELECT room_list.dorm_name, room_list.price, room_list.room_number, room_list.beds, room_list.available_beds, room_list.description, room_list.room_img, room_list.status, dorm_list.intended
                              FROM room_list 
                              LEFT JOIN room_assignments ON room_list.id = room_assignments.room_id 
                              LEFT JOIN dorm_list ON room_list.dorm_name = dorm_list.name
                              WHERE room_list.status = 'Active'
                              AND (room_list.dorm_name LIKE '%$search_query%' OR room_list.room_number LIKE '%$search_query%')
                              GROUP BY room_list.id, room_list.dorm_name 
                              ORDER BY room_list.id;
                      ";
                  }

                  
                    $result = $con->query($sql);


if (mysqli_num_rows($result) > 0) {
   
    $academicYear = isset($_POST['academic_year']) ? $_POST['academic_year'] : $academic_year;
    $semester = isset($_POST['semester']) ? $_POST['semester'] : $semester;

    $query = "SELECT dormname, room_id, COUNT(*) AS assigned_count 
              FROM room_assignments 
              WHERE academic_year = ? AND semester = ?
              GROUP BY dormname, room_id";

    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ss", $academicYear, $semester);
    mysqli_stmt_execute($stmt);
    $result_count = mysqli_stmt_get_result($stmt);

   
    $assigned_counts = array();
    while ($row_count = mysqli_fetch_assoc($result_count)) {
        $dorm_room = $row_count['dormname'] . '-' . $row_count['room_id'];
        $assigned_counts[$dorm_room] = $row_count['assigned_count'];
    }

 
    if ($result->num_rows > 0) {
       
        while ($row = $result->fetch_assoc()) {
            

          
            $dorm_room = $row['dorm_name'] . '-' . $row['room_number'];

           
            if (array_key_exists($dorm_room, $assigned_counts)) {
                $assigned_count = $assigned_counts[$dorm_room];
                $available_beds = $row['beds'] - $assigned_count;
            } else {
                $available_beds = $row['beds'];
            }
            echo '<div class="card text-dark bg-light "> <br>';
            echo '<div class="row no-gutters">
                      <div class="col-sm-2">';
            
            if (!empty($row["room_img"])) {
                echo '<img src="' . $row["room_img"] . '" class="card-img" alt="Room Image" style="max-width: 100%; height: 500px;">';
            } else {
                echo '<img src="assets/img/roomnotavail.png"  class="card-img" alt="...">';
            }
            
            echo '</div>';
            
            echo '<div class="col-md-8">';
            echo '    <div class="card-body">
                    <p class="card-text">Dorm Name: <b>' . $row["dorm_name"] . '</b></p>
                    <p class="card-text">Room Number: <b>' . $row["room_number"] . '</b></p>
                    <p class="card-text">Description: <b>' . $row["description"] . '</b></p>
                    <p class="card-text">Beds: <b>' . $row["beds"] . '</b></p>
                    <p class="card-text">Available Beds: <b><span style="color: ' . (($available_beds > 0) ? 'green' : 'red') . ';">' . $available_beds . '</span>';            


            

            echo '</b></p>
                        <p class="card-text">Price: <b>₱' . number_format($row["price"], 2) . '</b></p>
                    </div>';

           
            if ($available_beds == $row['beds']) {
                echo '<script>document.getElementById("dorm_name").hidden = true;</script>';
                echo '<script>document.getElementById("room_number").hidden = true;</script>';
            }

          
            echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
          
            echo '<select class="form-control-s form-control-sm rounded-3 searchable-dropdown" name="student_number" id="student_number" required>';
            echo '<option value="">Select Students</option>';

            $query = "SELECT * FROM tenants ORDER BY lname ASC";
            $result2 = $con->query($query);
            if ($result2->num_rows > 0) {
                while ($optionData = $result2->fetch_assoc()) {
                    $fname = $optionData['fname'];
                    $lname = $optionData['lname'];
                    $studnum = $optionData['studnum'];
                    echo '<option value="' . $studnum . '">' . $lname . ' ' . $fname . ',<b> ' . $studnum . '</b></option>';
                }
            }

            echo '</select>';

            echo '<div class="form-group">
           
            <select class="form-control form-control-sm rounded-3" name="academic_year" id="academic_year" required>';

            $currentYear = date('Y');
            $startYear = $currentYear - 1;
            $endYear = $currentYear + 1;
            for ($i = $startYear; $i <= $endYear; $i++) {
                $academicYear = $i . '-' . ($i + 1);
                $selected = '';
                if (isset($_POST['academic_year']) && $_POST['academic_year'] == $academicYear) {
                    $selected = 'selected';
                }
                echo '<option value="' . $academicYear . '" ' . $selected . '>' . $academicYear . '</option>';
            }

            echo '</select>

 
                <select class="form-control form-control-sm rounded-3" name="semester" id="semester" required>
                    <option value="">Select Semester</option>
                    <option value="First Semester">First Semester</option>
                    <option value="Second Semester">Second Semester</option>
                </select>
            ';


            echo "<input type='text' id='price' name='price' value='" . $row["price"] . "' hidden>";
            echo "<input type='text' id='dorm_name' name='dorm_name' value='" . $row["dorm_name"] . "' hidden>";
            echo "<input type='text' id='room_number' name='room_number' value='" . $row["room_number"] . "' hidden> ";

          
            if ($available_beds == 0) {
                echo '<input type="submit" class="btn btn-secondary btn-success" style="position: absolute; top: 20px; right: 20px" value="Assign Room" disabled>';
            } else {
                echo '<input type="submit" class="btn btn-secondary btn-success" style="position: absolute; top: 20px; right: 20px" value="Assign Room">';
            }

            echo "</form></div></div></div><br></div>";
        }
    } else {
       
        echo "<br>No rooms found.";
    }
}
 else {
 
  echo "<br>No matching results.";
}


$con->close();
?>
</div>


      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
      <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");
        toggleButton.onclick = function() {
          el.classList.toggle("toggled");
        };
      </script>
      <script>
        $(document).ready(function() {
          $('#table').DataTable();
        });
      </script>
      <script>
    $(document).ready(function() {
        $(".searchable-dropdown").selectize({
            create: true,
            sortField: 'text'
        });
    });
</script>
</body>

</html>


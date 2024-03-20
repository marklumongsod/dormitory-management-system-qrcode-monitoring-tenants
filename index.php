<?php

session_start();
include('dbconnect.php');
   
    if (!isset($_SESSION['id'])) {
       
        $_SESSION['error_message'] = "You must log in to access this page.";
        header("Location: login.php");
        exit();
    }

$adminId = $_SESSION['id']; 
$query = mysqli_query($con, "SELECT fullname FROM user WHERE acc_id = '$adminId'");
$row = mysqli_fetch_assoc($query);
$adminName = $row['fullname'];



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


if (!isset($_SESSION['academic_year'])) {
    $_SESSION['academic_year'] = $academic_year;
}
if (!isset($_SESSION['semester'])) {
    $_SESSION['semester'] = $semester;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/CvSUlogo.png">
  <title>
    DMS Dashboard
  </title>
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
  <!-- CSS Files -->
  <link id="pagestyle" href="./assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  <style>
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
</style>
</head>

<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 position-absolute w-100" style="background-image: url('https://cvsu.edu.ph/wp-content/uploads/2022/10/image2-2.jpeg'); background-repeat: no-repeat;background-position: center center; background-size: cover;"></div>
  </div>
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-2 border-radius-md my-3 shadow fixed-start ms-4 " id="sidenav-main" style="border: solid #046621;">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="#" style="text-align:center;">
        <img src="./assets/img/CvSUlogo.png" class="navbar-brand-img h-100" alt="main_logo"><br>
        Dormitory Management System
      </a>
    </div>
    <?php 
            $sql = "SELECT COUNT(*) FROM tenants GROUP BY tenants_id";
            $result = mysqli_query($con, $sql);
            
          
            $count = mysqli_num_rows($result);
            
            ?>
            <?php 
            $sql = "SELECT COUNT(*) FROM dorm_list GROUP BY id";
            $result = mysqli_query($con, $sql);
            
         
            $count1 = mysqli_num_rows($result);
            
            ?>
            <?php
$roomCount = 0; 
$selectedDorm = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dorm'])) {
    $selectedDorm = $_POST['dorm'];

    if ($selectedDorm === 'all') {
        $sql = "SELECT COUNT(*) AS room_count FROM room_list";
    } else {
        $sql = "SELECT COUNT(*) AS room_count FROM room_list WHERE dorm_name = '$selectedDorm'";
    }

    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $roomCount = $row['room_count'];
    } else {
        $roomCount = 0; 
    }

    $attendanceCount = 0;
    if ($selectedDorm === 'all') {
        $attendanceSql = "SELECT COUNT(*) AS attendance_count FROM tbl_attendance WHERE DATE(logdate) = CURDATE()";
    } else {
        $attendanceSql = "SELECT COUNT(*) AS attendance_count FROM tbl_attendance 
                        LEFT JOIN tenants ON tbl_attendance.tenant_studnum = tenants.studnum 
                        WHERE tenants.dorm_name = '$selectedDorm' AND DATE(tbl_attendance.logdate) = CURDATE()";
    }

    $attendanceResult = mysqli_query($con, $attendanceSql);

    if ($attendanceResult && mysqli_num_rows($attendanceResult) > 0) {
        $attendanceRow = mysqli_fetch_assoc($attendanceResult);
        $attendanceCount = $attendanceRow['attendance_count'];
    } else {
        $attendanceCount = 0;
    }


    $totalPayment = 0;
    if ($selectedDorm === 'all') {
        $paymentSql = "SELECT SUM(amount) + SUM(electricity_fee) AS totalAmount FROM payment  
                   WHERE payment.academic_year = '{$_SESSION['academic_year']}' 
                   AND payment.semester = '{$_SESSION['semester']}'";
    } else {
        $paymentSql = "SELECT SUM(amount) + SUM(electricity_fee) AS totalAmount FROM payment 
                   WHERE dorm_name = '$selectedDorm' AND payment.academic_year = '{$_SESSION['academic_year']}' 
                   AND payment.semester = '{$_SESSION['semester']}' ";
    }

    $paymentResult = mysqli_query($con, $paymentSql);

    if ($paymentResult && mysqli_num_rows($paymentResult) > 0) {
        $paymentRow = mysqli_fetch_assoc($paymentResult);
        $totalPayment = $paymentRow['totalAmount'];
    } else {
        $totalPayment = 0; 
    }
  

    $totalPayment = number_format((double)$totalPayment, 2);

    $visitorCount = 0;
    if ($selectedDorm === 'all') {
        $visitorSql = "SELECT COUNT(*) AS visitor_count FROM visitor WHERE DATE(logdate) = CURDATE()";
    } else {
        $visitorSql = "SELECT COUNT(*) AS visitor_count FROM visitor 
                       LEFT JOIN tenants ON visitor.visit_person = tenants.studnum 
                       WHERE tenants.dorm_name = '$selectedDorm' AND DATE(visitor.logdate) = CURDATE()";
    }

    $visitorResult = mysqli_query($con, $visitorSql);

    if ($visitorResult && mysqli_num_rows($visitorResult) > 0) {
        $visitorRow = mysqli_fetch_assoc($visitorResult);
        $visitorCount = $visitorRow['visitor_count'];
    } else {
        $visitorCount = 0; 
    }
} else {
   
    $sql = "SELECT COUNT(*) AS room_count FROM room_list";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $roomCount = $row['room_count'];
    } else {
        $roomCount = 0; 
    }

    $attendanceCount = 0;
    $attendanceSql = "SELECT COUNT(*) AS attendance_count FROM tbl_attendance WHERE DATE(logdate) = CURDATE()";
    $attendanceResult = mysqli_query($con, $attendanceSql);

    if ($attendanceResult && mysqli_num_rows($attendanceResult) > 0) {
        $attendanceRow = mysqli_fetch_assoc($attendanceResult);
        $attendanceCount = $attendanceRow['attendance_count'];
    } else {
        $attendanceCount = 0; 
    }

    
    $totalPayment = 0;
    $paymentSql = "SELECT SUM(amount) + SUM(electricity_fee) AS totalAmount FROM payment
                 WHERE payment.academic_year = '{$_SESSION['academic_year']}' 
                 AND payment.semester = '{$_SESSION['semester']}'";
    $paymentResult = mysqli_query($con, $paymentSql);

    if ($paymentResult && mysqli_num_rows($paymentResult) > 0) {
        $paymentRow = mysqli_fetch_assoc($paymentResult);
        $totalPayment = $paymentRow['totalAmount'];
    } else {
        $totalPayment = 0; 
    }

    
    $totalPayment = number_format((double)$totalPayment, 2);

    $visitorCount = 0;
    $visitorSql = "SELECT COUNT(*) AS visitor_count FROM visitor WHERE DATE(logdate) = CURDATE()";
    $visitorResult = mysqli_query($con, $visitorSql);

    if ($visitorResult && mysqli_num_rows($visitorResult) > 0) {
        $visitorRow = mysqli_fetch_assoc($visitorResult);
        $visitorCount = $visitorRow['visitor_count'];
    } else {
        $visitorCount = 0; 
    }
}

?>

            <?php 
            $sql = "SELECT SUM(amount) as totalAmount FROM payment WHERE academic_year = '".$_SESSION['academic_year']."' AND semester = '".$_SESSION['semester']."'";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($result);
            $totalAmount = $row['totalAmount'];
            $formattedTotal = number_format((double)$totalAmount, 2);
            ?>

            <?php 
            $sql = "SELECT COUNT(*) FROM visitor WHERE logdate = CURDATE()";
            $result = mysqli_query($con, $sql);
            
       
            $count4 = mysqli_fetch_array($result)[0];
            
            ?>
            <?php
          
            $sql = "SELECT COUNT(*) FROM tbl_attendance WHERE logdate = CURDATE()";

         
            $result = mysqli_query($con, $sql);

          
            $count5 = mysqli_fetch_array($result)[0];

            ?>
    <br>
    <hr class="horizontal dark mt-0">
   
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" href="index.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-tachometer-alt text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="tenants.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-users text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Student Boarders</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="dorm.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-building text-success text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dorm List</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="room.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-door-closed text-info opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">List of Rooms</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="payment.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-credit-card text-secondary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Payment</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="report.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-file-invoice text-danger text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Reports</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="guardian.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
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
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-user-clock text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Borders Logs</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="visitorhistorylogs.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
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
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
      <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">DMS</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Dashboard</li>
          </ol>
        </nav>
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
    <!-- End Navbar -->
    <!-- Dashboard cards --><br><br><br><br><br><br><br><br><hr>

    <form method="post" action="" id="filter-form" hidden>
            <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                    <select class="form-control form-control-sm rounded-3 shadow" name="academic_year" id="academic_year" required="required">
                        <i class="fa fa-filter"></i>
                        <option value="">Select Academic Year</option>
                        
                        <?php
                        $query = "SELECT DISTINCT academic_year FROM room_assignments ORDER BY academic_year DESC";
                        $result_academic_year = $con->query($query);
                        
                        if ($result_academic_year->num_rows > 0) {
                            $currentYear = date('Y');
                            $startYear = $currentYear - 1;
                            $endYear = $currentYear + 1;

                            for ($i = $endYear; $i >= $startYear; $i--) {
                                $academicYear = $i . '-' . ($i + 1);
                                $selected = ($academic_year == $academicYear) ? 'selected' : '';
                                ?>
                                <option value="<?php echo $academicYear; ?>" <?php echo $selected; ?>><?php echo $academicYear; ?></option>
                                <?php
                            }

                            while ($optionData = $result_academic_year->fetch_assoc()) {
                                $option = $optionData['academic_year'];
                                if (!in_array($option, array($startYear . '-' . ($startYear + 1), $endYear . '-' . ($endYear + 1)))) {
                                    ?>
                                    <option value="<?php echo $option; ?>" <?php if ($academic_year == $option) echo 'selected'; ?>><?php echo $option; ?></option>
                                    <?php
                                }
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
        
    <div class="container-fluid py-4 ">
    <form method="POST" action="">
      <div class="row">
      
                <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                    <div class="form-group">
                    <select class="form-control form-control-sm rounded-3 shadow" name="dorm" id="dorm">
                    <!--<option value="">Select Dorm</option>-->
                    <option value="all" <?php echo ($selectedDorm === 'all' || $selectedDorm === '') ? 'selected' : ''; ?>>All Dorms</option>
                    <?php
                    $query = "SELECT * FROM dorm_list WHERE status = 'active' ORDER BY name ASC";
                    $result_academic_year = $con->query($query);

                    while ($optionData = $result_academic_year->fetch_assoc()) {
                        $option = $optionData['name'];
                        $isSelected = ($selectedDorm === $option) ? 'selected' : ''; 

                        echo '<option value="' . $option . '" ' . $isSelected . '>' . $option . '</option>';
                    }
                    ?>
                </select>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                    <div class="form-group">
                        <button type="submit" id="filter1" class="btn btn-primary btn-sm bg-primary rounded-3 shadow">
                            <i class="fa fa-filter"></i> Set Dorm
                        </button>
                    </div>
                </div></form><br>
      <div class="row">
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
          <div class="card shadow">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Registered Students</p>
                    <h5 class="font-weight-bolder">
                    <?php echo $count;?>
                    </h5>
                    <!--<p class="mb-0">
                      <span class="text-success text-sm font-weight-bolder">+55%</span>
                      since yesterday
                    </p>-->
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                    <i class="fa fa-users text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
          <div class="card shadow">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Dorms</p>
                    <h5 class="font-weight-bolder">
                    <?php echo $count1;?>
                    </h5>
                   
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                    <i class="fas fa-building text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
          <div class="card shadow">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Number of visitor logs today</p>
                    <h5 class="font-weight-bolder">
                    <?php echo $visitorCount;?>
                    </h5>
                   
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                    <i class="fas fa-user-clock text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div></div>
      <br>
      <div class="row">
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4"><br>
          <div class="card shadow">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Semester Payment Collection</p>
                    <h5 class="font-weight-bolder">
                    <?php echo '₱'.$totalPayment;?>
                    </h5>
                 
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-info shadow-primary text-center rounded-circle">
                    <i class="fas fa-credit-card text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4"><br>
          <div class="card shadow">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Rooms</p>
                    <h5 class="font-weight-bolder">
                  <!--  </?php echo $count2;?>-->
                    <?php echo $roomCount;?> 
                    </h5>
                  
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-warning shadow-danger text-center rounded-circle">
                    <i class="fas fa-door-closed text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4"><br>
          <div class="card shadow">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Number of boarder logs today</p>
                    <h5 class="font-weight-bolder">
                    <?php echo $attendanceCount;?>
                    </h5>
                    
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-secondary shadow-success text-center rounded-circle">
                    <i class="fas fa-user-clock text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div></div>
      <br>
      <div class="row ">
      <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card  ">
          <div class="card-body custom-color p-3 shadow">
            <div class="row">
              <div class="col-8">
                <h3 class="text-right mb-0 " style="text-transform: uppercase; font-size: 20px; color: #046621; padding: 10px;">Student Logs as of 
                <?php $month = isset($_GET['month']) ? $_GET['month'] : date("Y-m-d"); ?>
                <?= date("F d, Y", strtotime($month."-01")) ?></h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
      
      <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
        <table id="table" class="table bg-white rounded shadow-sm table-striped table-hover shadow">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>STUDENT NO.</th>
                                <th>STUDENT NAME</th>
                                <th>COURSE</th>
                                <th>DORM / ROOM</th>
                                <th>TIME-OUT</th>
                                <th>DESTINATION</th>
                                <th>TIME-IN</th>
                                <th>ORIGIN</th>
                                <th>LOGDATE</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                          $i = 1;
                          if ($selectedDorm == "all" || empty($selectedDorm)) {
                              $sql = "SELECT * FROM tbl_attendance 
                                      LEFT JOIN tenants ON tbl_attendance.tenant_studnum = tenants.studnum
                                      WHERE DATE(logdate) = CURDATE() ORDER BY id DESC";
                          } else {
                              $sql = "SELECT * FROM tbl_attendance 
                                      LEFT JOIN tenants ON tbl_attendance.tenant_studnum = tenants.studnum
                                      WHERE tenants.dorm_name = '$selectedDorm' AND DATE(logdate) = CURDATE() ORDER BY id DESC";
                          }
                          $query = $con->query($sql);
                          while ($row = $query->fetch_assoc()) {
                              ?>
                              <tr>
                                  <td><?php echo $i++; ?></td>
                                  <td><?php echo $row['tenant_studnum']; ?></td>
                                  <td><?php echo $row['tenant_name']; ?></td>
                                  <td><?php echo $row['course']; ?></td>
                                  <td><?php echo $row['dorm_name']; ?> <b>/</b> <?php echo $row['room']; ?></td>
                                  <td><?php echo $row['time_out']; ?></td>
                                  <td><?php echo $row['destination']; ?></td>
                                  <td><?php echo $row['time_in']; ?></td>
                                  <td><?php echo $row['origin']; ?></td>
                                  <td><?php echo $row['logdate']; ?></td>
                              </tr>
                              <?php
                          }
                          ?>  
                        </tbody>
                    </table>
        </div>
      </div>
      <footer class="footer pt-3  ">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script>
                <a href="#" class="font-weight-bold" target="_blank">Cavite State University Dormitory Management System</a>
              </div>
            </div>
            <div class="col-lg-6">
              <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                <li class="nav-item">
                  <a href="#" class="nav-link text-muted" target="_blank">DMSv1</a>
                </li>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>
  <!--   Core JS Files   -->
  <script src="./assets/js/core/popper.min.js"></script>
  <script src="./assets/js/core/bootstrap.min.js"></script>
  <script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="./assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="./assets/js/plugins/chartjs.min.js"></script>
  <script>
    var ctx1 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
    new Chart(ctx1, {
      type: "line",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Mobile apps",
          tension: 0.4,
          borderWidth: 0,
          pointRadius: 0,
          borderColor: "#5e72e4",
          backgroundColor: gradientStroke1,
          borderWidth: 3,
          fill: true,
          data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#fbfbfb',
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#ccc',
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
    });
  </script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="./assets/js/argon-dashboard.min.js?v=2.0.4"></script>

  <script>
    $(document).ready(function () {
      $('#table').DataTable();
  });
  </script>
</body>

</html>
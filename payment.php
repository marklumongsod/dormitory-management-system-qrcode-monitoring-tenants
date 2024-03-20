<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
date_default_timezone_set("Asia/Manila");

include('dbconnect.php');

$adminId = $_SESSION['id']; 
$query = mysqli_query($con, "SELECT fullname FROM user WHERE acc_id = '$adminId'");
$row = mysqli_fetch_assoc($query);
$adminName = $row['fullname'];

$result = null;


$academic_year = (date('Y')-1).'-'.date('Y');
$semester = 'First Semester';


if(isset($_POST['academic_year']) && isset($_POST['semester'])) {
    $academic_year = $_POST['academic_year'];
    $semester = $_POST['semester'];
    
    $_SESSION['academic_year'] = $academic_year;
    $_SESSION['semester'] = $semester;
} else {
   
    if(isset($_SESSION['academic_year'])) {
        $academic_year = $_SESSION['academic_year'];
    }
    if(isset($_SESSION['semester'])) {
        $semester = $_SESSION['semester'];
    }
}

$currentMonth = date('Y-m');

$query = "SELECT room_assignments.id AS assignment_id, room_assignments.*, tenants.*, room_list.*, payment.electricity_fee
    FROM room_assignments
    JOIN tenants ON tenants.studnum = room_assignments.student_number
    JOIN room_list ON room_list.dorm_name = room_assignments.dormname AND room_list.room_number = room_assignments.room_id
    LEFT JOIN (SELECT tenant_id, MAX(electricity_fee) AS electricity_fee FROM payment WHERE DATE_FORMAT(date_created, '%Y-%m') = '$currentMonth' GROUP BY tenant_id) AS payment ON tenants.tenants_id = payment.tenant_id
    WHERE room_assignments.academic_year = '$academic_year' AND room_assignments.semester = '$semester' AND tenants.status = 'active' ORDER BY assignment_id ASC";


$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/CvSUlogo.png">
  <title>DMS Assigned Rooms</title>
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    <!-- CSS Files -->
    <link id="pagestyle" href="./assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
     <link rel="stylesheet" href="css/styles.index.css" />-->
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

    <br>
    <hr class="horizontal dark mt-0">
   
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link " href="index.php">
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
          <a class="nav-link active" href="payment.php">
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
                <h3 class="text-right mb-0" style="text-transform: uppercase; font-size: 20px; color: #046621; padding: 10px;">Student Assigned Rooms and Payment</h3>
              </div>
            </div>
          </div><br>
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
        
                <div class="row mt-4">
                 <div class="col-lg-12 mb-lg-0 mb-4">
                 <?php if($result && mysqli_num_rows($result) > 0): ?>
                 <table id="table" class="table bg-white rounded shadow table-striped table-hover" style="width:100% ">
                        <thead>
                            <tr>
                                <th scope="col" width="2%">#</th>
                                <th scope="col" width="10%">Student Number</th>
                                <th scope="col" width="10%">Student Name</th>
                                <th scope="col" width="7%">Dorm / Room </th>
                                <th scope="col" width="7%">Rental Balance </th>
                                <th scope="col" width="5%">Electricity Fee (<span style="color: blue;"><?php echo date('F'); ?></span>)</th>

                                <th scope="col" width="10%">Action</th>
                                </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php while($row = mysqli_fetch_array($result)): ?>
              <tr>
                <td class=""><?php echo $i++; ?></td>
                <td><?php echo $row['studnum'] ?></td>
                <td><?php echo $row['fname']. ' ' .$row['lname']; ?> </td> 
                <td><?php echo $row['dormname']; ?> <b>(<?php echo $row['room_id']; ?>)</b> </td>   
                <td>
                    <?php
                    $balance = $row['balance'];
                    if ($balance == 0) {
                        echo '<span style="color: green;">Fully Paid</span>';
                    } else {
                        echo '<span style="color: red;">₱' . number_format($balance, 2) . '</span>';
                    }
                    ?>
                </td>       
                <td>
                    <?php
                    $electricityFee = $row['electricity_fee'];
                    if (!empty($electricityFee)) {
                        echo '<span style="color: green;">Paid';
                    } else {
                        echo '<span style="color: red;">Not yet paid';
                    }
                    ?>
                </td>
                <td>
                    <a style="text-decoration: none; color:white;" href="addpayment.php?id=<?php echo $row['assignment_id']; ?>">
                        <button class='btn btn-success' style="height:40px;width:150px">
                            <i class="fa fa-credit-card me-2"></i>Add Payment
                        </button>
                    </a>
                    <button id="<?php echo $row['tenants_id']; ?>" class="history-button btn bg-gradient-primary" style="height:40px;width:150px"><i class="fa fa-history me-2"></i>History</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p> No data found.</p>
<?php endif; ?>
<?php mysqli_close($con); ?>    
                </div>
                <div class="modal" id="myModal">
                        <div class="modal-dialog modal-dialog-centered" style="max-width: 800px;">
                            <div class="modal-content animate">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Payment History</h4>
                            </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            Modal body..
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" onclick="$('#myModal').modal('hide')">Close</button>
                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
            </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var el = document.getElementById("wrapper");
    var toggleButton = document.getElementById("menu-toggle");

    toggleButton.onclick = function () {
        el.classList.toggle("toggled");
    };</script>
    <script>
    $(document).ready(function () {
      $('#table').DataTable();
  });
  </script>
  <script>
$(document).ready(function() {
  $('table').on('click', '.history-button', function() {
    var id = $(this).attr('id');
    $.ajax({
      url: "paymenthistory.php",
      method: 'post',
      data: { id: id },
      success: function(result) {
        $(".modal-body").html(result);
      }
    });
    $('#myModal').modal("show");
  });
});

  </script>
</body>

</html>

<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
include('dbconnect.php');
$adminId = $_SESSION['id']; 
$query = mysqli_query($con, "SELECT fullname FROM user WHERE acc_id = '$adminId'");
$row = mysqli_fetch_assoc($query);
$adminName = $row['fullname'];
$query ="SELECT * FROM tenants";
$result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/CvSUlogo.png">
  <title>DMS Report</title>
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
    <!-- Excel-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    
    <!-- CSS Files -->
    <link id="pagestyle" href="./assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
     <link rel="stylesheet" href="css/styles.index.css" />-->
     <style>
        @media print {
            #print  {
                display: none;
            }
        }

        @media print {
            #PrintButton {
                display: none;
            }
        }

        @media print {
            #menu-toggle {
                display: none;
            }
        }

        @media print {
            #dashboard {
                display: none;
            }
        }

        @media print {
            #month {
                display: none;
            }
        }

        @media print {
            #img {
                display: none;
            }
        }

        @media print {
            #date {
                display: none;
            }
        }

        @media print {
            #sidebar-wrapper {
                display: none;
            }
        }

        @media print {
            #navbarSupportedContent {
                display: none;
            }
        }

        @media print {
            table {
              width: 100%;
            font-size: 12px;
            }
        }
        @media print {
          #table_filter,  
          #table_paginate,
          #table_length,   .dataTables_info{
            display: none;
          }
        }

        @media print {
            #toggler {
                display: none;
            }
        }
        @media print {
          #filter-form, #export, #end_date, #start_date, #preport, #bgcover, #admin, #sidenav-main, #preport, #start_date_label, #end_date_label, #fee_type, #dorm_fee, #electricity_fee, #radio, #month, #year {
                display: none;
            }
        }
        @media screen {
        .hide-on-screen {
            display: none;
        }

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


.logo-container {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        text-align: center;
    }

    .logo {
        margin-right: 10px;
        margin-bottom: 10px;
    }

    .logo img {
        width: 130px;
        height: auto;
    }

 

    .content-container {
        text-align: center;
        padding-left: 130px;
    }

    

    th,
    td {
        padding: 10px;
        text-align: left;
    }

    thead {
        background-color: #ccc;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    h4,h3,h2,h1 {
        color: black;
    }

     </style>

</head>

<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 position-absolute w-100" id="bgcover" style="background-image: url('https://cvsu.edu.ph/wp-content/uploads/2022/10/image2-2.jpeg'); background-repeat: no-repeat;background-position: center center; background-size: cover;"></div>
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
          <a class="nav-link " href="payment.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-credit-card text-secondary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Payment</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active " href="report.php">
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
              <a class="nav-link1 dropdown-toggle second-text text-white fw-bold" href="#" id="admin"
                  role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i  class="fas fa-user me-2"></i><?php echo $adminName; ?>
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
           <br id="admin"><br id="admin"><br id="admin"><br id="admin"><br id="admin"><br id="admin"><br id="admin"> <br id="admin"><br id="admin"><hr id="admin">
          <div class="container-fluid px-4">
            
          <div class="card-body custom-color p-3 shadow" id="admin">
            <div class="row">
              <div class="col-8">
                <h3 class="text-right mb-0" id="preport" style="text-transform: uppercase; font-size: 20px; color: #046621; padding: 10px;">Payment Reports</h3>
              </div>
            </div>
          </div>
        
                <div class="row mt-4">
                 <div class="col-lg-12 mb-lg-0 mb-4">
                 
                
                 <form method="post" action="" id="filter-form">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="fee_type" class="control-label">Fee Type:</label><br> 
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="fee_type" id="dorm_fee" value="dorm_fee" required="required" >
                                <label class="form-check-label" for="dorm_fee">Dorm Fee</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="fee_type" id="electricity_fee" value="electricity_fee" >
                                <label class="form-check-label" for="electricity_fee">Electricity Fee</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="start_date" id="start_date_label" class="control-label">Start Date:</label>
                            <input type="date" class="form-control form-control-sm rounded-3 shadow" name="start_date" id="start_date" required="required" disabled>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="end_date" id="end_date_label" class="control-label">End Date:</label>
                            <input type="date" class="form-control form-control-sm rounded-3 shadow" name="end_date" id="end_date" required="required" disabled>
                        </div>
                    </div></div>
                    <div class="row justify-content-center">
                      <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                          <div class="form-group">
                              <label for="month" id="month_label" class="control-label">Month:</label>
                              <select class="form-control form-control-sm rounded-3 shadow" name="month" id="month" disabled>
                                  <option value="01" <?php if (date('m') === '01') echo 'selected'; ?>>January</option>
                                  <option value="02" <?php if (date('m') === '02') echo 'selected'; ?>>February</option>
                                  <option value="03" <?php if (date('m') === '03') echo 'selected'; ?>>March</option>
                                  <option value="04" <?php if (date('m') === '04') echo 'selected'; ?>>April</option>
                                  <option value="05" <?php if (date('m') === '05') echo 'selected'; ?>>May</option>
                                  <option value="06" <?php if (date('m') === '06') echo 'selected'; ?>>June</option>
                                  <option value="07" <?php if (date('m') === '07') echo 'selected'; ?>>July</option>
                                  <option value="08" <?php if (date('m') === '08') echo 'selected'; ?>>August</option>
                                  <option value="09" <?php if (date('m') === '09') echo 'selected'; ?>>September</option>
                                  <option value="10" <?php if (date('m') === '10') echo 'selected'; ?>>October</option>
                                  <option value="11" <?php if (date('m') === '11') echo 'selected'; ?>>November</option>
                                  <option value="12" <?php if (date('m') === '12') echo 'selected'; ?>>December</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                          <div class="form-group">
                              <label for="year" id="year_label" class="control-label">Year:</label>
                              <input type="number" class="form-control form-control-sm rounded-3 shadow" name="year" id="year" min="2000" max="2099" step="1" value="<?php echo date('Y'); ?>" disabled>
                          </div>
                      </div>
                  </div>
                <div class="row  justify-content-center">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <button type="submit" id="filter" class="btn btn-primary btn-xs bg-gradient-primary rounded-3 shadow">
                                <i class="fa fa-filter"></i> Filter
                            </button>
                            <button class="btn btn-light btn-xs bg-gradient-light rounded-3 border shadow" type="button" id="print" onclick="PrintPage()">
                                <i class="fa fa-print"></i> Print
                            </button>
                            <button class="btn btn-success btn-xs bg-gradient-success rounded-3 border shadow" type="button" id="export" onclick="ExportToExcel()">
                                <i class="fa fa-file-excel"></i> Excel
                            </button>
                        </div>
                    </div>
                </div>
            </form>

                    
                <div class="hide-on-screen">
                    <div class="logo-container">
                        <div class="logo">
                            <img src="./assets/img/CvSUlogo.png" alt="Logo">
                        </div>
                        <div><br>
                            <h4>Republic of the Philippines</h4>
                            <h1>Cavite State University</h1>
                            <h4>Don Severino delas Alas Campus</h4>
                            <div><b>Indang, Cavite</b></div>
                        </div>
                    </div><br>
                    <div class="content-container">
        <h4><b>UNIVERSITY DORMITORY</b></h4>         
        <h4><b id="selected-fee-type">[Selected Fee Type]</b></h4>
        <div>
        <b>Payment Report as of the <span id="selected-month"></span> <span id="selected-year"></span></b>
        <span id="date-range" style="display: none;"><b>Date Range:</b> (<span id="start_date_value"></span> - <b></b> <span id="end_date_value"></span>)</span>
      </div>
    </div><br>
                </div>

                <table id="table" class="table bg-white rounded shadow-sm table-striped table-hover shadow" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col" width="1%">#</th>
                            
                            <?php
                            // Check if form was submitted
                            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                // Get form data
                                $fee_type = isset($_POST['fee_type']) ? $_POST['fee_type'] : '';

                                if ($fee_type === "dorm_fee") {
                                    echo '<th scope="col" width="15%">Payment Created</th>';
                                    echo '<th scope="col" width="15%">Name</th>';
                                    echo '<th scope="col" width="10%">Academic Year</th>';
                                    echo '<th scope="col" width="10%">Semester</th>';
                                    echo '<th scope="col" width="10%">Dorm name</th>';
                                    echo '<th scope="col" width="5%">room</th>';
                                    echo '<th scope="col" width="10%">Rental Amount</th>';
                                    echo '<th scope="col" width="10%">Rental Status / Balance</th>';
                                    
                                } else if ($fee_type === "electricity_fee") {
                                    echo '<th scope="col" width="15%">Payment Created</th>';
                                    echo '<th scope="col" width="15%">Name</th>';
                                    echo '<th scope="col" width="10%">Academic Year</th>';
                                    echo '<th scope="col" width="10%">Semester</th>';
                                    echo '<th scope="col" width="10%">Dorm name</th>';
                                    echo '<th scope="col" width="5%">room</th>';
                                    echo '<th scope="col" width="5%">OR number</th>';
                                    echo '<th scope="col" width="10%">Electricity Status</th>';
                                }
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                          $i = 1;

                          // Check if form was submitted
                          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                              // Get form data
                              $fee_type = isset($_POST['fee_type']) ? $_POST['fee_type'] : '';

                              if ($fee_type === "dorm_fee") {
                                  $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
                                  $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';

                                  // Query database table for Dorm Fee
                                  $query = "SELECT tenants.*, payment.date_created AS datecreated, room_list.price, room_assignments.balance, payment.semester, payment.academic_year
                                            FROM tenants
                                            LEFT JOIN (
                                                SELECT tenant_id, MAX(date_created) AS max_date
                                                FROM payment
                                                WHERE payment = 'Dorm Rental Fee'
                                                GROUP BY tenant_id
                                            ) AS latest_payment ON tenants.tenants_id = latest_payment.tenant_id
                                            LEFT JOIN payment ON latest_payment.tenant_id = payment.tenant_id AND latest_payment.max_date = payment.date_created
                                            LEFT JOIN room_assignments ON payment.student_number = room_assignments.student_number
                                            LEFT JOIN room_list ON room_assignments.dormname = room_list.dorm_name AND room_assignments.room_id = room_list.room_number
                                            WHERE payment.dorm_name = room_assignments.dormname AND payment.room = room_assignments.room_id
                                              AND payment.student_number = room_assignments.student_number
                                              AND payment.academic_year = room_assignments.academic_year
                                              AND payment.semester = room_assignments.semester
                                              AND payment.payment = 'Dorm Rental Fee'
                                              AND payment.date_created BETWEEN '$start_date' AND '$end_date'
                                            ORDER BY payment.date_created DESC";
                                            
                                  $result = mysqli_query($con, $query);

                                  // Check if query was successful
                                  if ($result) {
                                      // Loop through results and do something with each row
                                      while ($row = mysqli_fetch_assoc($result)) {
                                          ?>
                                          <tr>
                                              <td class=""><?php echo $i++; ?></td>
                                              <td><?php echo date('F-d-Y', strtotime($row['datecreated'])) ?></td>
                                              <td><?php echo $row['fname']; ?> <?php echo $row['lname']; ?></td>
                                              <td><?php echo $row['academic_year']; ?></td>
                                              <td><?php echo $row['semester']; ?></td>
                                              <td><?php echo $row['dorm_name']; ?></td>
                                              <td><?php echo $row['room']; ?></td>
                                              <td><?php echo '₱' . number_format($row['price'], 2); ?></td>
                                              
                                              <td><?php echo ($row['balance'] == 0) ? 'Fully Paid' : 'Partial / ' . '₱' . number_format($row['balance'], 2); ?></td>
                                          </tr>
                                          <?php
                                      }

                                      // Free result set
                                      mysqli_free_result($result);
                                  } else {
                                      // Display error message
                                      echo 'Error: ' . mysqli_error($con);
                                  }
                              } else if ($fee_type === "electricity_fee") {
                                  $month = isset($_POST['month']) ? $_POST['month'] : '';
                                  $year = isset($_POST['year']) ? $_POST['year'] : '';

                                  // Query database table for Electricity Fee
                                  $query = "SELECT room_assignments.id AS assignment_id, room_assignments.*, tenants.*, room_list.*, payment.electricity_fee, payment.academic_year, payment.semester, payment.date_created AS datecreated, payment.or_number
                                            FROM room_assignments
                                            JOIN tenants ON tenants.studnum = room_assignments.student_number
                                            JOIN room_list ON room_list.dorm_name = room_assignments.dormname AND room_list.room_number = room_assignments.room_id
                                            JOIN payment ON tenants.tenants_id = payment.tenant_id
                                            WHERE payment.electricity_fee IS NOT NULL
                                              AND MONTH(payment.date_created) = '$month'
                                              AND YEAR(payment.date_created) = '$year'
                                              AND payment.payment = 'Electricity Fee'
                                              AND room_assignments.academic_year = payment.academic_year 
                                              AND room_assignments.semester = payment.semester
                                            ORDER BY payment.date_created DESC";

                                  $result = mysqli_query($con, $query);

                                  // Check if query was successful
                                  if ($result) {
                                      // Loop through results and do something with each row
                                      while ($row = mysqli_fetch_assoc($result)) {
                                          ?>
                                          <tr>
                                              <td class=""><?php echo $i++; ?></td>
                                              <td><?php echo !empty($row['electricity_fee']) ? date('F-d-Y',strtotime($row['datecreated'])) : "No payment has been made this month."; ?></td>
                                              <td><?php echo $row['fname']; ?> <?php echo $row['lname']; ?></td>
                                              <td><?php echo $row['academic_year']; ?></td>
                                              <td><?php echo $row['semester']; ?></td>
                                              <td><?php echo $row['dorm_name']; ?></td>
                                              <td><?php echo $row['room']; ?></td>
                                              <td><?php echo $row['or_number']; ?></td>
                                              <td><?php echo ($row['electricity_fee'] == '') ? 'Unpaid' : 'Paid ' ; ?></td>
                                          </tr>
                                          <?php
                                      }

                                      // Free result set
                                      mysqli_free_result($result);
                                  } else {
                                      // Display error message
                                      echo 'Error: ' . mysqli_error($con);
                                  }
                              }
                          }
                          ?>
    </tbody>
</table>
<div class="hide-on-screen">
<div style="margin-top: 20px;">
    <hr style="border: none; border-top: 1px solid #000; margin-bottom: 50px;">
    <div style="text-align: right; font-weight: bold; padding-right: 25px"><?php echo $adminName; ?></div>
    <div style="text-align: right;">__________________________</div>
    <div style="text-align: right; font-weight: bold; padding-right: 10px;">Dormitory Manager</div>

</div></div>
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
  
  <script type="text/javascript">
  function formatDate(dateString) {
    var date = new Date(dateString);
    var options = { month: 'long', day: 'numeric', year: 'numeric' };
    return date.toLocaleDateString('en-US', options);
  }

  function PrintPage() {
    var selectedFeeType = document.querySelector('input[name="fee_type"]:checked').value;
    var selectedFeeTypeText = "";

    if (selectedFeeType === "dorm_fee") {
      selectedFeeTypeText = "Dorm Fee";
      var startDate = document.getElementById("start_date").value;
      var endDate = document.getElementById("end_date").value;
      document.getElementById("date-range").style.display = "inline";
      document.getElementById("start_date_value").textContent = formatDate(startDate);
      document.getElementById("end_date_value").textContent = formatDate(endDate);
    } else if (selectedFeeType === "electricity_fee") {
      selectedFeeTypeText = "Electricity Fee";
      document.getElementById("date-range").style.display = "none";
    }

    var selectedMonth = document.getElementById("month").value;
    var selectedYear = document.getElementById("year").value;

    var monthNames = [
      "January", "February", "March", "April", "May", "June",
      "July", "August", "September", "October", "November", "December"
    ];
    var selectedMonthText = monthNames[parseInt(selectedMonth) - 1];

    document.getElementById("selected-fee-type").textContent = selectedFeeTypeText;
    document.getElementById("selected-month").textContent = selectedFeeType === "dorm_fee" ? "" : selectedMonthText;
    document.getElementById("selected-year").textContent = selectedFeeType === "dorm_fee" ? "" : selectedYear;

    window.print();
  }
</script>




<script>
function ExportToExcel() {
  var table = document.getElementById("table");
  var rows = table.querySelectorAll("tr");
  var wb = XLSX.utils.table_to_book(table, {sheet:"Sheet JS"});
  var wbout = XLSX.write(wb, {bookType:'xlsx', type:'binary'});
  function s2ab(s) {
    var buf = new ArrayBuffer(s.length);
    var view = new Uint8Array(buf);
    for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
    return buf;
  }
  saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), 'Payment_report.xlsx');
}
</script>
    


<script>
  function enableEndDate() {
    // Disable end date input until start date is selected
    var startDateInput = document.getElementById("start_date");
    var endDateInput = document.getElementById("end_date");
    endDateInput.disabled = true;

    // Clear previously selected end date
    endDateInput.value = "";

    // Retrieve previously selected start date and end date from localStorage
    var storedStartDate = localStorage.getItem('start_date');
    var storedEndDate = localStorage.getItem('end_date');

    // Set the values if they exist
    if (storedStartDate) {
      startDateInput.value = storedStartDate;
    }
    if (storedEndDate) {
      endDateInput.value = storedEndDate;
    }

    // Disable the day after the current day in the start date picker
    var currentDate = new Date();
    var dayAfterCurrentDate = new Date(currentDate);
    dayAfterCurrentDate.setDate(currentDate.getDate() + 1);
    var dayAfterCurrentDateString = dayAfterCurrentDate.toISOString().split('T')[0];
    startDateInput.max = dayAfterCurrentDateString;

    // Disable the day after the current day in the end date picker
    endDateInput.min = dayAfterCurrentDateString;

    // Enable end date input if start date is selected
    if (startDateInput.value !== "") {
      endDateInput.disabled = false;

      // Disable the day after the selected start date in the end date picker
      var selectedStartDate = new Date(startDateInput.value);
      var dayAfterStartDate = new Date(selectedStartDate);
      dayAfterStartDate.setDate(selectedStartDate.getDate() + 1);
      var dayAfterStartDateString = dayAfterStartDate.toISOString().split('T')[0];
      endDateInput.min = dayAfterStartDateString;
    }
  }

  enableEndDate();

  // Save selected dates to localStorage when start date changes
  var startDateInput = document.getElementById("start_date");
  startDateInput.addEventListener('change', function() {
    localStorage.setItem('start_date', startDateInput.value);
    enableEndDate();
  });

  // Save selected dates to localStorage when end date changes
  var endDateInput = document.getElementById("end_date");
  endDateInput.addEventListener('change', function() {
    localStorage.setItem('end_date', endDateInput.value);
  });
</script>




<script>
  // Check if a previously selected fee type is stored in local storage
  var selectedFeeType = localStorage.getItem('selectedFeeType');
  if (selectedFeeType) {
    var radioButton = document.getElementById(selectedFeeType);
    if (radioButton) {
      radioButton.checked = true;
      enableFilters(selectedFeeType);
    }
  }

  // Check if a previously selected month is stored in local storage
  var selectedMonth = localStorage.getItem('selectedMonth');
  if (selectedMonth) {
    document.getElementById('month').value = selectedMonth;
  }

  // Store the selected fee type and month in local storage when a radio button or month is changed
  var radioButtons = document.getElementsByName('fee_type');
  for (var i = 0; i < radioButtons.length; i++) {
    radioButtons[i].addEventListener('click', function(event) {
      localStorage.setItem('selectedFeeType', event.target.id);
      enableFilters(event.target.id);
    });
  }

  var monthSelect = document.getElementById('month');
  monthSelect.addEventListener('change', function(event) {
    localStorage.setItem('selectedMonth', event.target.value);
  });

  // Function to enable/disable date and month filters based on the selected fee type
  function enableFilters(selectedType) {
    var startDateInput = document.getElementById('start_date');
    var endDateInput = document.getElementById('end_date');
    var monthSelect = document.getElementById('month');
    var yearInput = document.getElementById('year');

    if (selectedType === 'dorm_fee') {
      startDateInput.disabled = false;
      endDateInput.disabled = false;
      monthSelect.disabled = true;
      yearInput.disabled = true;
    } else if (selectedType === 'electricity_fee') {
      startDateInput.disabled = true;
      endDateInput.disabled = true;
      monthSelect.disabled = false;
      yearInput.disabled = false;
    }
  }
</script>

    
</body>

</html>

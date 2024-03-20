<?php
session_start();
include('../dbconnect.php');


if (!isset($_SESSION['id'])) {
       
  $_SESSION['error_message'] = "You must log in to access this page.";
  header("Location: ../login.php");
  exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="../assets/img/CvSUlogo.png">
  <title>
    DMS Admin Dashboard
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <link href="../assets/css/style.css" rel="stylesheet" />
  <!-- Data tables -->
  <link href="https://code.jquery.com/jquery-3.5.1.js" rel="stylesheet" />
  <script type="text/javascript" src="../assets/js/jquery-3.5.1.js"></script>
  <script type="text/javascript" src="../assets/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link href="https://code.jquery.com/jquery-3.5.1.js" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/modal.content.css" />
    <link rel="stylesheet" href="../assets/css/button.css" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  
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
        <img src="../assets/img/CvSUlogo.png" class="navbar-brand-img h-100" alt="main_logo"><br>
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
          <a class="nav-link " href="index.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-tachometer-alt text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="tenants.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-users text-muted text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">List of Admin</span>
          </a>
        </li>
      
        
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Profile</h6>
        </li>
      
        <li class="nav-item">
          <a class="nav-link " href="viewprofile.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-users text-danger text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">View Profile</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="../logout.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-sign-out-alt text-success text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Logout</span>
          </a>
        </li>
      </ul>
   
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
            
         <!-- <ul class="navbar-nav  justify-content-end">
            <li class="nav-item dropdown">
              <a class="nav-link1 dropdown-toggle second-text text-white fw-bold" href="#" id="navbarDropdown"
                  role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-user me-2"></i>Administrator
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="../changelogindetails.php">Change Password</a></li>
              <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
              </ul>
          </li>
          </ul>-->
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <!-- Dashboard cards --><br><br><br><br><br><br><br><br><hr>

   
        
    <div class="container-fluid py-4 ">
      <div class="row">
      <div class="row ">
      <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card  ">
          <div class="card-body custom-color p-3 shadow">
            <div class="row">
              <div class="col-8">
                <h3 class="text-right mb-0 " style="text-transform: uppercase; font-size: 20px; color: #046621; padding: 10px;">List of Administrator / Dormitory Manager
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex m-3 justify-content-start"> 
            <a class="button-option me-2" id="GFG" href="insertadmin.php">
                <span class="transition"></span>
                <span class="gradient"></span>
                <span class="label">Add Admin</span>
            </a>
            </div>
      <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
        <table id="table" class="table bg-white rounded shadow-sm table-striped table-hover shadow">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>USERNAME</th>
                                <th>PASSWORD</th>
                                <th>FULL NAME</th>
                                <th>ROLE</th>
                                <th>EMAIL</th>
                                <th>CONTACT NUMBER</th>
                                <th>DATE CREATED</th>
                                <th>DATE UPDATED</th>
                                <th>ACTION</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                          $i = 1;
                          $sql = "SELECT * FROM user where role = 'Dormitory Manager'  ORDER BY acc_id DESC";
                          $query = $con->query($sql);
                          while ($row = $query->fetch_assoc()) {
                              ?>
                              <tr>
                                  <td><?php echo $i++; ?></td>
                                  <td><?php echo $row['username']; ?></td>
                                  <td><?php echo $row['password']; ?></td>
                                  <td><?php echo $row['fullname']; ?></td>
                                  <td><?php echo $row['role']; ?></td>
                                  <td><?php echo $row['email']; ?></td>
                                  <td><?php echo $row['contact_number']; ?></td>
                                  <td><?php echo date('F j, Y', strtotime($row['date_created'])); ?></td>
                                  <td><?php echo date('F j, Y', strtotime($row['date_updated'])); ?></td>
                                  <td><a href="editadmin.php?id=<?php echo $row["acc_id"]; ?>"><button class='btn bg-gradient-success'><i class="fa fa-edit"></i></button></a>
                                    <button class='comfirm_del_btn btn bg-gradient-danger' value="<?php echo $row['acc_id']; ?>"><i class='fa fa-trash'></i></button>

                                    <script>
                                    $(document).ready(function() {
                                        $('.comfirm_del_btn').click(function(e) {
                                            e.preventDefault();
                                            var id = $(this).val();

                                            swal({
                                                title: "Are you sure?",
                                                text: "Once deleted, you will not be able to recover this record!",
                                                icon: "warning",
                                                buttons: true,
                                                dangerMode: true,
                                            }).then((willDelete) => {
                                                if (willDelete) {
                                                
                                                    $.ajax({
                                                        url: "deleteadmin.php",
                                                        type: "POST",
                                                        data: {
                                                            id: id
                                                        },
                                                        dataType: "json",
                                                        success: function(response) {
                                                            if (response.success) {
                                                                swal({
                                                                    title: "Success!",
                                                                    text: "The record has been deleted.",
                                                                    icon: "success",
                                                                    button: "OK",
                                                                })
                                                                .then(() => {
                                                       
                                                                    location.reload();
                                                                });
                                                            } else {
                                                                swal("Error!", "An error occurred while deleting the record.", "error");
                                                            }
                                                        },
                                                        error: function(xhr, status, error) {
                                                            console.log(xhr.responseText);
                                                            swal("Error!", "An error occurred while deleting the record.", "error");
                                                        }
                                                    });
                                                } else {
                                                    swal("The record is safe!");
                                                }
                                            });
                                        });
                                    });
                                    </script>
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
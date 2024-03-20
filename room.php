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


$query = "SELECT *, room_list.id as id, room_list.status as status FROM room_list
          LEFT JOIN dorm_list ON room_list.dorm_name = dorm_list.name 
          WHERE dorm_list.status = 'Active'
          ORDER BY room_list.id ";


$result = mysqli_query($con, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/CvSUlogo.png">
  <title>DMS Room List</title>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    
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
          <a class="nav-link active" href="room.php">
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
          <a class="nav-link " href="acad_year_semester.php">
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
                <h3 class="text-right mb-0" style="text-transform: uppercase; font-size: 20px; color: #046621; padding: 10px;">Room List</h3>
              </div>
            </div>
          </div>
          <!--Buttons-->
          <div class="d-flex m-3 justify-content-start"> 
            <a class="button-option me-2" id="GFG" href="createroom.php">
                <span class="transition"></span>
                <span class="gradient"></span>
                <span class="label">Add Room</span>
            </a>
            <!--<a class="button-option me-2" id="GFG" href="roomassignment.php">
                <span class="transition"></span>
                <span class="gradient"></span>
                </i><span class="label">Assign Room</span>
            </a>
            <a class="button-option me-2" id="GFG" href="updateroomassignment.php">
                <span class="transition"></span>
                <span class="gradient"></span>
                </i><span class="label">Update student room</span>
            </a>-->
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
        
                <div class="row mt-4">
                 <div class="col-lg-12 mb-lg-0 mb-4">
                 <table id="table" class="table bg-white  shadow table-striped table-hover" style="width:100% ">
                        <thead>
                            <tr>
                                <th scope="col" width="">#</th>
                                <th scope="col" width="">Date Created</th>
                                <th scope="col" width="">Dorm</th>
                                <th scope="col" width="">Room</th>
                                <th scope="col" width="">Description</th>
                                <th scope="col" width="">Beds</th>
                                <th scope="col" width="">Available</th>
                                <th scope="col" width="">Price</th>
                                <th scope="col" width="">Status</th>
                                <th scope="col" width="15%">Action</th>
                            </tr>
                        </thead>
                        <?php
                            $i = 1;
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
                          

                              
                                while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                    <tr>
                                        <td class=""><?php echo $i++; ?></td>
                                        <td><?php echo date('F-d-Y', strtotime($row['date_created'])) ?></td>
                                        <td><?php echo $row['dorm_name']; ?></td>
                                        <td><?php echo $row['room_number']; ?></td>
                                        <td><?php echo $row['description']; ?></td>
                                        <td><?php echo $row['beds']; ?></td>
                                        <td>
                                            <?php
                                        
                                            $dorm_room = $row['dorm_name'] . '-' . $row['room_number'];
                                            
                                            
                                            if (array_key_exists($dorm_room, $assigned_counts)) {
                                                $assigned_count = $assigned_counts[$dorm_room];
                                                $available_beds = $row['beds'] - $assigned_count;
                                            } else {
                                                $available_beds = $row['beds'];
                                            }

                                            echo $available_beds;
                                            ?>
                                        </td>
                                        <td><?php echo '₱'.number_format($row['price'], 2); ?></td>
                                        <td style="color: red;"><b><?php echo $row['status']; ?></b></td>
                                        <td>
                                            <a href="editroom.php?id=<?php echo $row["id"]; ?>">
                                                <button class='btn bg-gradient-success'><i class="fa fa-edit"></i></button>
                                            </a>
                                            <button id="<?php echo $row['id']; ?>" class="eye-button btn bg-gradient-primary"><i class="fa fa-eye"></i></button>
                                            <button class='comfirm_del_btn btn bg-gradient-danger' value="<?php echo $row['id']; ?>"><i class='fa fa-trash'></i></button>
                                       
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
                                                        url: "deleteroom.php",
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
                        }
                         ?>
                    </table>   
                </div>
                <div class="modal" id="myModal">
                <br><br><div class="modal-dialog modal-dialog-centered" style="max-width: 800px;">
                            <div class="modal-content animate">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Room Details</h4>
                                
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
$(document).ready(function() {
  $('#table').DataTable();
});
</script>
  <script>
$(document).ready(function() {
  $('table').on('click', '.eye-button', function() {
    var id = $(this).attr('id');
    $.ajax({
      url: "displayroom.php",
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

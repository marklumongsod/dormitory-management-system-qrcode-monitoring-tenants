
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

$tenants_id = $_GET['id'];
$query = "select * from tenants where tenants_id = '".$tenants_id."' ";
$result = mysqli_query($con, $query);

while($row=mysqli_fetch_assoc($result))
{
    $firstname = $row['fname'];
    $middlename = $row['mname'];
    $lastname = $row['lname'];
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

if(isset($_POST['submit'])){
  $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
  $middlename = mysqli_real_escape_string($con, $_POST['middlename']);
  $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
  $gender = mysqli_real_escape_string($con, $_POST['gender']);
  $contactnumber = mysqli_real_escape_string($con, $_POST['contactnumber']);
  $email = mysqli_real_escape_string($con, $_POST['email']);
  $address = mysqli_real_escape_string($con, $_POST['address']);
  $studnum = mysqli_real_escape_string($con, $_POST['studnum']);
  $year = mysqli_real_escape_string($con, $_POST['year']);
  $course = mysqli_real_escape_string($con, $_POST['course']);
  //$department = mysqli_real_escape_string($con, $_POST['department']);
  $guardianname = mysqli_real_escape_string($con, $_POST['guardianname']); 
  $guardiancontact = mysqli_real_escape_string($con, $_POST['guardiancontact']); 
  $relation = mysqli_real_escape_string($con, $_POST['relation']); 
  $birthdate = mysqli_real_escape_string($con, $_POST['birthdate']); 
  $birthplace = mysqli_real_escape_string($con, $_POST['birthplace']);
  $guardianoccupation = mysqli_real_escape_string($con, $_POST['guardianoccupation']); 
  $guardianemail = mysqli_real_escape_string($con, $_POST['guardianemail']); 
  $guardianaddress = mysqli_real_escape_string($con, $_POST['guardianaddress']); 

  $status = mysqli_real_escape_string($con, $_POST['status']); 
  $dt = date('Y-m-d h:i:s A');

  $query= "UPDATE tenants SET fname= '".$firstname."', mname = '".$middlename."', lname = '".$lastname."', gender = '".$gender."',birthdate = '".$birthdate."', birthplace = '".$birthplace."', contactnumber = '".$contactnumber."', email = '".$email."', address = '".$address."', studnum = '".$studnum."', year = '".$year."', course = '".$course."', department = '".$department."', guardianname = '".$guardianname."', guardianoccupation = '".$guardianoccupation."', guardianemail = '".$guardianemail."', guardianaddress = '".$guardianaddress."', guardiancontact = '".$guardiancontact."', relation = '".$relation."', status = '".$status."' WHERE tenants_id  = '".$tenants_id."'";
  $result = mysqli_query($con, $query); 

  $_SESSION['statuss'] = "Student Boarder Information Updated!";
  $_SESSION['status_code'] = "success";

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/CvSUlogo.png">
  <title>DMS Edit Student Boarder</title>
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
        <a class="nav-link active" href="tenants.php">
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
            <h3 class="text-right mb-0 " style="text-transform: uppercase; font-size: 20px; color: #046621; padding: 10px;">
              Update Student Boarder</h3>
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
                                        window.location.href = "tenants.php";
                                    });
                                </script> 
                       <?php 
                            unset($_SESSION['statuss']);
                       }
                    ?>
      <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">

          <div class="card-group-dorm shadow">
            <div class="card-body mt-3 text-dark ">
            <form class="pad" method="post"> <br>
                              <legend>Personal Information</legend>

                              <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                  <div class="form-group">
                                    <label for="firstname" class="control-label">First Name</label>
                                    <input type="text" name="firstname" id="firstname" class="form-control form-control-sm rounded-3"  value="<?php echo $firstname ?>" required/>
                                  </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                  <div class="form-group">
                                    <label for="middlename" class="control-label">Middle Name</label>
                                    <input type="text" name="middlename" id="middlename" class="form-control form-control-sm rounded-3" value="<?php echo $middlename ?>" placeholder="optional"/>
                                  </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                  <div class="form-group">
                                    <label for="lastname" class="control-label">Last Name</label>
                                    <input type="text" name="lastname" id="lastname" class="form-control form-control-sm rounded-3"  value="<?php echo $lastname ?>" required/>
                                  </div>
                                </div>
                              </div>

                            <div class="row">
                              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label for="gender" class="control-label">Sex</label>
                                  <select type="text" name="gender" id="gender" class="form-control form-control-sm rounded-3" required>
                                    <option><?php echo $gender ?></option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label for="contact" class="control-label">Contact number</label>
                                  <input type="number" name="contactnumber" id="contactnumber" class="form-control form-control-sm rounded-3" value="<?php echo $contactnumber ?>" required/>
                                </div>
                              </div>
                              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label for="email" class="control-label">Email</label>
                                  <input type="email" name="email" id="email" class="form-control form-control-sm rounded-3" value="<?php echo $email ?>" required/>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label for="address" class="control-label">Current Address</label>
                                  <textarea rows="3" name="address" id="address" class="form-control form-control-sm rounded-3" required><?php echo $address ?></textarea>
                                </div>
                              </div>
                            

                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label for="birthdate" class="control-label">Date of Birth</label>
                                  <input type="date" name="birthdate" id="birthdate" class="form-control form-control-sm rounded-3" value="<?php echo $birthdate ?>"required>
                                </div>
                              </div>


                              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label for="address" class="control-label">Place of Birth</label>
                                  <textarea rows="3" name="birthplace" id="birthplace" class="form-control form-control-sm rounded-3" required><?php echo $birthplace ?></textarea>
                                </div>
                              </div>

                              
                            </div>

                             <hr>

                           
                                  <legend>School Information</legend>
                                  <div class="row">
                              <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label for="department" class="control-label">Student number</label>
                                  <input type="number" name="studnum" id="studnum" class="form-control form-control-sm rounded-3" value="<?php echo $studnum ?>" readonly/>
                                </div>
                              </div>

                              <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label for="course" class="control-label">Year & Section</label>
                                  <input type="text" name="year" id="year" class="form-control form-control-sm rounded-3" value="<?php echo $year ?>" required/>
                                </div>
                              </div>
                           

                              <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                              <div class="form-group">
                              <label for="course" class="control-label">Course</label>
                              <select name="course" id="course" class="form-control form-control-sm rounded-3" required>
                                <option><?php echo $course ?></option>
                                <option value="Bachelor of Agricultural Entrepreneurship (BAE)">Bachelor of Agricultural Entrepreneurship (BAE)</option>
                                <option value="Bachelor of Arts in English Language Studies (BAELS)">Bachelor of Arts in English Language Studies (BAELS)</option>
                                <option value="Bachelor of Arts in Journalism (BA Journ)">Bachelor of Arts in Journalism (BA Journ)</option>
                                <option value="Bachelor of Arts in Political Science (BAPS)">Bachelor of Arts in Political Science (BAPS)</option>
                                <option value="Bachelor of Early Childhood Education BECE)">Bachelor of Early Childhood Education (BECE)</option>
                                <option value="Bachelor of Elementary Education (BEE)">Bachelor of Elementary Education (BEE)</option>
                                <option value="Bachelor of Exercise and Sports Sciences (BSESS)">Bachelor of Exercise and Sports Sciences (BSESS)</option>
                                <option value="Bachelor of Physical Education (BPEd)">Bachelor of Physical Education (BPEd)</option>
                                <option value="Bachelor of Science in Accountancy (BS Acc)">Bachelor of Science in Accountancy (BS Acc)</option>
                                <option value="Bachelor of Science in Agricultural and Bio systems Engineering (BSABE)">Bachelor of Science in Agricultural and Bio systems Engineering (BSABE)</option>
                                <option value="Bachelor of Science in Agriculture (BS Agri)">Bachelor of Science in Agriculture (BS Agri)</option>
                                <option value="Bachelor of Science in Applied Mathematics (BSAM)">Bachelor of Science in Applied Mathematics (BSAM)</option>
                                <option value="Bachelor of Science in Architecture (BS Arch)">Bachelor of Science in Architecture (BS Arch)</option>
                                <option value="Bachelor of Science in Biology (BS Bio)">Bachelor of Science in Biology (BS Bio)</option>
                                <option value="Bachelor of Science in Business Management (BSBM)">Bachelor of Science in Business Management (BSBM)</option>
                                <option value="Bachelor of Science in Civil Engineering (BSCE)">Bachelor of Science in Civil Engineering (BSCE)</option>
                                <option value="Bachelor of Science in Computer Engineering (BSCoE)">Bachelor of Science in Computer Engineering (BSCoE)</option>
                                <option value="Bachelor of Science in Computer Science (BS CS)">Bachelor of Science in Computer Science (BS CS)</option>
                                <option value="Bachelor of Science in Criminology (BS Crim)">Bachelor of Science in Criminology (BS Crim)</option>
                                <option value="Bachelor of Science in Development Management (BSDM)">Bachelor of Science in Development Management (BSDM)</option>
                                <option value="Bachelor of Science in Economics (BS Econ)">Bachelor of Science in Economics (BS Econ)</option>
                                <option value="Bachelor of Science in Electrical Engineering (BSEE)">Bachelor of Science in Electrical Engineering (BSEE)</option>
                                <option value="Bachelor of Science in Electronics Engineering (BSECE)">Bachelor of Science in Electronics Engineering (BSECE)</option>
                                <option value="Bachelor of Science in Environmental Science (BSES)">Bachelor of Science in Environmental Science (BSES)</option>
                                <option value="Bachelor of Science in Food Technology (BSFT)">Bachelor of Science in Food Technology (BSFT) </option>
                                <option value="Bachelor of Science in Hospitality Management (BSHM)">Bachelor of Science in Hospitality Management (BSHM)</option>
                                <option value="Bachelor of Science in Industrial Engineering (BSIE)">Bachelor of Science in Industrial Engineering (BSIE)</option>
                                <option value="Bachelor of Science in Industrial Engineering (BSIE)">Bachelor of Science in Industrial Engineering (BSIE)</option>
                                <option value="Bachelor of Science in Industrial Technology major in Automotive (BS IndT- AT)">Bachelor of Science in Industrial Technology major in Automotive (BS IndT- AT)</option>
                                <option value="Bachelor of Science in Industrial Technology major in Electrical (BS IndT – ET)">Bachelor of Science in Industrial Technology major in Electrical (BS IndT – ET)</option>
                                <option value="Bachelor of Science in Industrial Technology major in Electronics (BS IndT – ELEX)">Bachelor of Science in Industrial Technology major in Electronics (BS IndT – ELEX)</option>
                                <option value="Bachelor of Science in Information Technology (BSIT)">Bachelor of Science in Information Technology (BSIT)</option>
                                <option value="Bachelor of Science in International Studies (BSIS)">Bachelor of Science in International Studies (BSIS)</option>
                                <option value="Bachelor of Science in Medical Technology (BSMT)">Bachelor of Science in Medical Technology (BSMT)</option>
                                <option value="Bachelor of Science in Midwifery">Bachelor of Science in Midwifery</option>
                                <option value="Bachelor of Science in Nursing (BSN)">Bachelor of Science in Nursing (BSN)</option>
                                <option value="Bachelor of Science in Office Administration (BSOA)">Bachelor of Science in Office Administration (BSOA)</option>
                                <option value="Bachelor of Science in Psychology (BS Psy)">Bachelor of Science in Psychology (BS Psy)</option>
                                <option value="Bachelor of Science in Social Work (BS SW)">Bachelor of Science in Social Work (BS SW)</option>
                                <option value="Bachelor of Science in Tourism Management (BSTM)">Bachelor of Science in Tourism Management (BSTM)</option>
                                <option value="Bachelor of Secondary Education (BSE)">Bachelor of Secondary Education (BSE)</option>
                                <option value="Bachelor of Special Needs Education (BSNE)">Bachelor of Special Needs Education (BSNE)</option>
                                <option value="Bachelor of Technology and Livelihood Education (BTLE)">Bachelor of Technology and Livelihood Education (BTLE)</option>
                                <option value="Doctor of Veterinary Medicine (DVM)">Doctor of Veterinary Medicine (DVM)</option>
                                <option value="Diploma in Midwifery">Diploma in Midwifery</option>
                              </select>
                              </div></div>  </div>
                              
                              <!--<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                  <label for="course" class="control-label">Deparment</label>
                                  <select class="form-control form-control-sm rounded-3" name="department" id="department" required>
                                              <option></?php echo $department ?></option>
                                              <option>College of Agriculture, Food, Environment and Natural Resources</option>
                                              <option>College of Arts and Sciences</option>
                                              <option>College of Criminal Justice</option>
                                              <option>College of Economics, Management, and Development Studies</option>
                                              <option>College of Education</option>
                                              <option>College of Engineering and Information Technology</option>
                                              <option>College of Nursing</option>
                                              <option>College of Sports, Physical Education and Recreation</option>
                                              <option>College of Veterinary Medicine and Biomedical Sciences</option>    
                                    </select>
                                </div>
                              </div>-->
                            

                            <hr>

                            <legend>Emergency Details</legend>
                          
                            <div class="row">
                              <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                              <label for="title">Guardian Name</label> <!-- Guardian Name -->
                                <div class="form-group">
                                  <input type="text" class="form-control form-control-sm rounded-3" id="guardianname" placeholder="" name="guardianname" value="<?php echo $guardianname ?>" required>     
                                </div></div>

                                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                              <label for="title">Occupation</label> <!-- Occupation -->
                                <div class="form-group">
                                  <input type="text" class="form-control form-control-sm rounded-3" id="guardianoccupation" placeholder="" name="guardianoccupation" value="<?php echo $guardianoccupation ?>" required/>     
                                </div>
                              </div>

                              <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                  <label for="title">Relation</label> <!-- Relation -->
                                    <div class="form-group">
                                          <input type="text" class="form-control form-control-sm rounded-3" id="relation" placeholder="" name="relation" value="<?php echo $relation ?>" required/>     
                                    </div>
                                </div>

                                    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group"> 
                                      <label for="title">Contact number</label><!-- Contact number -->
                                      <input type="number" class="form-control form-control-sm rounded-3" id="guardiancontact" name="guardiancontact" value="<?php echo $guardiancontact ?>" required/>
                                  </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                              <div class="form-group">
                                <label for="email" class="control-label">Email</label>
                                <input type="email" name="guardianemail" id="guardianemail" class="form-control form-control-sm rounded-3" value="<?php echo $guardianemail ?>" required/>
                              </div>
                              </div>

                              <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                  <label for="title">Address</label> <!-- Address -->
                                    <div class="form-group">
                                          <input type="text" class="form-control form-control-sm rounded-3" id="guardianaddress" placeholder="" name="guardianaddress" value="<?php echo $guardianaddress ?>" required/>     
                                    </div>
                                </div>

                              </div>
                            <hr>

                            <div class="row">
                              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><!-- Status -->
                              <div class="form-group">
                                      <label for="select">Status</label>
                                      <select class="form-control form-control-sm rounded-3" name="status" id="status"  required>
                                                <option><?php echo $status ?></option>
                                                <option>Active</option>
                                                <option>Inactive</option> 
                                      </select>
                                    </div></div>

                            <div class="d-flex flex-row align-items-center flex-wrap"> <!-- Submit and reset -->
                            <div class="my-1 me-sm-2"><br>
                                <button type="submit"  id="submit" name="submit" class="button-option1">
                                <span class="transition"></span>
                                <span class="gradient"></span>
                                <span class="label">Update</span> 
                                </button>
                              </div>
            </div></form>
            </div><br>
            </div>
            </div>
            <br></div></div>

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
</body>

</html>

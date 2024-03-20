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

if (isset($_POST['submit'])) {
    date_default_timezone_set("Asia/Manila");
    $dorm_name = mysqli_real_escape_string($con, $_POST['dorm_name']);
    $roomname = mysqli_real_escape_string($con, $_POST['roomname']);
    $slots = mysqli_real_escape_string($con, $_POST['slots']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $dt = date('Y-m-d h:i:s A');

    $sql_u = "SELECT * FROM room_list WHERE dorm_name='$dorm_name' AND room_number='$roomname'";
    $res_u = mysqli_query($con, $sql_u);

    if (mysqli_num_rows($res_u) > 0) {
        $_SESSION['statuss'] = "Error! Room already exists!";
        $_SESSION['status_code'] = "error";
    } else {
        $photo = $_FILES['photo']['name']; 
        $photo_tmp = $_FILES['photo']['tmp_name']; 
        $photo_path = "room_img/" . $photo; 

       
        move_uploaded_file($photo_tmp, $photo_path);

        mysqli_query($con, "INSERT INTO room_list VALUES (0, '$dorm_name', '$roomname', '$description', '$slots', '$slots', '$price', '$status', '$photo_path', 0, '$dt')");
        $_SESSION['statuss'] = "Room Created Successfully.";
        $_SESSION['status_code'] = "success";
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
  <title>DMS Add Room</title>
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
.invalid-input {
    border-color: red !important;
}
.empty-input {
    border-color: red;
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
        <a class="nav-link " href="tenants.php">
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
        <a class="nav-link active" href="room.php">
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
              Add Room</h3>
          </div>
        </div>
      </div>

      <!--Add Button-->
      <div class="d-flex m-3 justify-content-start">
        <a class="button-option me-2" id="GFG" href="room.php">
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
                                        window.location.href = "room.php";
                                    });
                                </script> 
                       <?php 
                            unset($_SESSION['statuss']);
                       }
                    ?>
      <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">

          <div class="card-group-room shadow">
            <div class="card-body mt-3 text-dark ">
            <form class="pad" method="post" enctype="multipart/form-data"> <!-- Add enctype attribute for uploading files -->
            <br>
            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <label for="select">Dorm</label>
                <select class="form-control form-control-sm rounded-3" name="dorm_name" id="dorm_name" required>
                  <option value="">Select Dorm</option>
                  <?php 
                    $query = "SELECT * FROM dorm_list";
                    $result = $con->query($query);
                    if ($result->num_rows > 0) {
                      while ($optionData = $result->fetch_assoc()) {
                        $option = $optionData['name'];
                        $id = $optionData['id'];
                        ?>
                        <option value="<?php echo $option; ?>"><?php echo $option; ?></option> 
                        <?php
                      }
                    }
                  ?>
                </select>  
              </div> 

              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label for="roomname" class="control-label">Room</label>
                  <input type="text" name="roomname" id="roomname" class="form-control form-control-sm rounded-3" required/>
                </div>
              </div>
              
              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label for="roomname" class="control-label">Room Description</label>
                  <input type="text" name="description" id="description" class="form-control form-control-sm rounded-3" placeholder="ex: Air-conditioned room" required/>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label for="slots" class="control-label">Bed/s</label>
                  <input type="number" name="slots" id="slots" class="form-control form-control-sm rounded-3" required/>
                </div>
              </div>
              
              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label for="price" class="control-label">Price Per Semester</label>
                  <input type="number" name="price" id="price" class="form-control form-control-sm rounded-3" required/>
                </div>
              </div>
              
              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <label for="select">Status</label>
                <select class="form-control form-control-sm rounded-3" name="status" id="status" required>
                  <option value=''>Select status</option>
                  <option>Active</option>
                  <option>Inactive</option> 
                </select>  
              </div>
            </div>

            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label for="photo" class="control-label">Add Photo</label>
                  <input type="file" name="photo" id="photo" class="form-control form-control-sm rounded-3" accept="image/*" />
                </div>
              </div>
            </div>

            <div class="d-flex flex-row align-items-center flex-wrap">
              <!-- Submit and reset -->
              <div class="my-1 me-sm-2">
                <br>
                <button type="submit" id="submit" name="submit" class="button-option">
                  <span class="transition"></span>
                  <span class="gradient"></span>
                  <span class="label">Add</span> 
                </button>
              </div>       
            </div>
          </form>

            <br>
            </div>
            <br></div>
        </div>
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
  const statusInput = document.getElementById('status');

 
  if (statusInput.value === '') {
    statusInput.classList.add('empty-input');
  }

  statusInput.addEventListener('input', function() {
    if (statusInput.value === '') {
      statusInput.classList.add('empty-input');
    } else {
      statusInput.classList.remove('empty-input');
    }
  });
</script>

<script>
  const dorm_nameInput = document.getElementById('dorm_name');

 
  if (dorm_nameInput.value === '') {
    dorm_nameInput.classList.add('empty-input');
  }

  dorm_nameInput.addEventListener('input', function() {
    if (dorm_nameInput.value === '') {
      dorm_nameInput.classList.add('empty-input');
    } else {
      dorm_nameInput.classList.remove('empty-input');
    }
  });
</script>

<script>
  const roomnameInput = document.getElementById('roomname');


  if (roomnameInput.value === '') {
    roomnameInput.classList.add('empty-input');
  }

  roomnameInput.addEventListener('input', function() {
    if (roomnameInput.value === '') {
      roomnameInput.classList.add('empty-input');
    } else {
      roomnameInput.classList.remove('empty-input');
    }
  });
</script>

<script>
  const descriptionInput = document.getElementById('description');


  if (descriptionInput.value === '') {
    descriptionInput.classList.add('empty-input');
  }

  descriptionInput.addEventListener('input', function() {
    if (descriptionInput.value === '') {
      descriptionInput.classList.add('empty-input');
    } else {
      descriptionInput.classList.remove('empty-input');
    }
  });
</script>



<script>
  const slotsInput = document.getElementById('slots');

  
  if (slotsInput.value === '') {
    slotsInput.classList.add('empty-input');
  }

  slotsInput.addEventListener('input', function() {
    if (slotsInput.value === '') {
      slotsInput.classList.add('empty-input');
    } else {
      slotsInput.classList.remove('empty-input');
    }
  });
</script>

<script>
  const priceInput = document.getElementById('price');

  
  if (priceInput.value === '') {
    priceInput.classList.add('empty-input');
  }

  priceInput.addEventListener('input', function() {
    if (priceInput.value === '') {
      priceInput.classList.add('empty-input');
    } else {
      priceInput.classList.remove('empty-input');
    }
  });
</script>

<script>
  const photoInput = document.getElementById('photo');


  if (photoInput.value === '') {
    photoInput.classList.add('empty-input');
  }

  photoInput.addEventListener('input', function() {
    if (photoInput.value === '') {
      photoInput.classList.add('empty-input');
    } else {
      photoInput.classList.remove('empty-input');
    }
  });
</script>

</body>

</html>

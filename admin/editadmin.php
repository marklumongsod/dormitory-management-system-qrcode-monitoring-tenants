<?php
session_start();
include('../dbconnect.php');

if (!isset($_SESSION['id'])) {
       
  $_SESSION['error_message'] = "You must log in to access this page.";
  header("Location: ../login.php");
  exit();
}


$id = $_GET['id'];
$query = "SELECT * FROM user WHERE acc_id = '".$id."' ";
$result = mysqli_query($con, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $name = $row['fullname'];
    $username = $row['username'];
    $password = $row['password'];
    $role = $row['role'];
    $email = $row['email'];
    $contact = $row['contact_number'];
}

if (isset($_POST['submit'])) {
    date_default_timezone_set("Asia/Manila");
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $role = mysqli_real_escape_string($con, $_POST['role']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $dt = date('Y-m-d h:i:s A');

    $sql_u = "SELECT * FROM user WHERE username='$username' AND password='$password' AND acc_id != '$id'";
    $res_u = mysqli_query($con, $sql_u);

    if (mysqli_num_rows($res_u) > 0) {
        $_SESSION['statuss'] = "Error! The username and password already exist for another user.";
        $_SESSION['status_code'] = "error";
    } else {
        mysqli_query($con, "UPDATE user SET username='$username', password='$password', fullname='$name', role='$role', email='$email', contact_number='$contact', date_updated='$dt' WHERE acc_id='$id'");
        $_SESSION['statuss'] = "Administrator updated successfully.";
        $_SESSION['status_code'] = "success";
    }
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
  <script type="text/javascript" src="assets/js/jquery-3.5.1.js"></script>
  <script type="text/javascript" src="assets/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
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
.custom-color1 {
  background-color: white;
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
          <a class="nav-link active" href="adminlist.php">
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
          <a class="nav-link " href="../changelogindetails.php">
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
                <h3 class="text-right mb-0 " style="text-transform: uppercase; font-size: 20px; color: #046621; padding: 10px;">Add Administrator
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex m-3 justify-content-start">
        <a class="button-option me-2" id="GFG" href="adminlist.php">
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
                                        window.location.href = "adminlist.php";
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
                              <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                  <div class="form-group">
                                    <label for="name" class="control-label">Full Name</label>
                                    <input type="text" name="name" id="name" class="form-control form-control-sm rounded-3" value="<?php echo $name ?>" required/>
                                  </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                  <div class="form-group">
                                    <label for="username" class="control-label">Username</label>
                                    <input type="text" name="username" id="username" class="form-control form-control-sm rounded-3" value="<?php echo $username ?>" required/>
                                  </div>
                                </div>
                                
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="password" class="control-label">Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password" id="password" class="form-control form-control-sm rounded-3" value="<?php echo $password ?>" required/>
                                            <button type="button" id="showPassword" class="btn btn-secondary" onclick="togglePasswordVisibility()"><i class="fa fa-eye"></i></button>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                  <div class="form-group">
                                    <label for="role" class="control-label">Role</label>
                                    <select type="text" name="role" id="role" class="form-control form-control-sm rounded-3" value="<?php echo $role ?>" readonly>
                                      <option value="Dormitory Manager">Dormitory Manager / Administrator</option>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                  <div class="form-group">
                                    <label for="email" class="control-label">Email</label>
                                    <input type="text" name="email" id="email" class="form-control form-control-sm rounded-3" value="<?php echo $email ?>" required/>
                                  </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                  <div class="form-group">
                                    <label for="contact" class="control-label">Contact Number</label>
                                    <input type="text" name="contact" id="contact" class="form-control form-control-sm rounded-3" value="<?php echo $contact ?>" required/>
                                  </div>
                                </div>

                            <div class="d-flex flex-row align-items-center flex-wrap"> <!-- Submit and reset -->
                            <div class="my-1 me-sm-2"><br>
                                <button type="submit"  id="submit" name="submit" class="button-option1">
                                <span class="transition"></span>
                                <span class="gradient"></span>
                                <span class="label">Update</span> 
                                </button>
                              </div>
            </div></form>
            </div>
            <br></div>
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

<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password");
        var showPasswordButton = document.getElementById("showPassword");
        
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            showPasswordButton.innerHTML = '<i class="fa fa-eye-slash"></i>';
        } else {
            passwordInput.type = "password";
            showPasswordButton.innerHTML = '<i class="fa fa-eye"></i>';
        }
    }
</script>
<script>
  const nameInput = document.getElementById('name');

  // Add red color initially if the input is empty
  if (nameInput.value === '') {
    nameInput.classList.add('empty-input');
  }

  nameInput.addEventListener('input', function() {
    if (nameInput.value === '') {
        nameInput.classList.add('empty-input');
    } else {
        nameInput.classList.remove('empty-input');
    }
  });
</script>

<script>
  const usernameInput = document.getElementById('username');

  // Add red color initially if the input is empty
  if (usernameInput.value === '') {
    usernameInput.classList.add('empty-input');
  }

  usernameInput.addEventListener('input', function() {
    if (usernameInput.value === '') {
        usernameInput.classList.add('empty-input');
    } else {
        usernameInput.classList.remove('empty-input');
    }
  });
</script>

<script>
  const passwordInput = document.getElementById('password');

  // Add red color initially if the input is empty
  if (passwordInput.value === '') {
    passwordInput.classList.add('empty-input');
  }

  passwordInput.addEventListener('input', function() {
    if (passwordInput.value === '') {
        passwordInput.classList.add('empty-input');
    } else {
        passwordInput.classList.remove('empty-input');
    }
  });
</script>

<script>
  const roleInput = document.getElementById('role');

  // Add red color initially if the input is empty
  if (roleInput.value === '') {
    roleInput.classList.add('empty-input');
  }

  roleInput.addEventListener('input', function() {
    if (roleInput.value === '') {
        roleInput.classList.add('empty-input');
    } else {
        roleInput.classList.remove('empty-input');
    }
  });
</script>

<script>
  const emailInput = document.getElementById('email');

  // Add red color initially if the input is empty
  if (emailInput.value === '') {
    emailInput.classList.add('empty-input');
  }

  emailInput.addEventListener('input', function() {
    if (emailInput.value === '') {
        emailInput.classList.add('empty-input');
    } else {
        emailInput.classList.remove('empty-input');
    }
  });
</script>

<script>
  const contactInput = document.getElementById('contact');

  // Add red color initially if the input is empty
  if (contactInput.value === '') {
    contactInput.classList.add('empty-input');
  }

  contactInput.addEventListener('input', function() {
    if (contactInput.value === '') {
        contactInput.classList.add('empty-input');
    } else {
        contactInput.classList.remove('empty-input');
    }
  });
</script>

</body>

</html>
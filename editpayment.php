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

$id = $_GET['id'];

$query = "SELECT * FROM payment
    LEFT JOIN tenants ON payment.tenant_id = tenants.tenants_id
    JOIN room_assignments ON tenants.studnum = room_assignments.student_number
    JOIN room_list ON room_list.dorm_name = room_assignments.dormname AND room_list.room_number = room_assignments.room_id
    WHERE payment.payment_id = '".$id."' ";

$result = mysqli_query($con, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $fname = $row['fname'];
    $lname = $row['lname'];
    $dorm_name = $row['dorm_name'];
    $room = $row['room_id'];
    $price = $row['price'];
    $student_number = $row['student_number'];
    $balance = $row['balance'];
    $academic_year = $row['academic_year'];
    $semester = $row['semester'];
    $tenants_id = $row['tenants_id'];
    $or_number = $row['or_number'];
    $amount = $row['amount'];
    $electricity_fee = $row['electricity_fee'];
    $payment = $row['payment'];
}


if (isset($_POST['submit'])) {
  date_default_timezone_set("Asia/Manila");
  $student_number = mysqli_real_escape_string($con, $_POST['student_number']);
  $academic_year = mysqli_real_escape_string($con, $_POST['academic_year']);
  $semester = mysqli_real_escape_string($con, $_POST['semester']);
  $amount = mysqli_real_escape_string($con, $_POST['amount']);
  $payment = mysqli_real_escape_string($con, $_POST['payment']);
  $ornumber = mysqli_real_escape_string($con, $_POST['ornumber']);
  $dormname = mysqli_real_escape_string($con, $_POST['dormname']);
  $room = mysqli_real_escape_string($con, $_POST['room']);
  $dt = date('Y-m-d h:i:s A');

  // Check if the student already paid the electricity fee for the same date created month
  if ($payment === 'Electricity Fee') {
    $existingResult = mysqli_query($con, "SELECT * FROM payment WHERE student_number = '$student_number' AND academic_year = '$academic_year' AND semester = '$semester' AND payment = 'Electricity Fee' AND MONTH(date_created) = MONTH(NOW())");

    // Check if there are existing payment records
    if (mysqli_num_rows($existingResult) > 0) {
      $_SESSION['statuss'] = "The student already paid the electricity fee for this month.";
      $_SESSION['status_code'] = "error";
    } else {
      // Insert new payment record
      mysqli_query($con, "UPDATE payment SET or_number = '$or_number', amount = '$amount' WHERE payment_id = '$id' ");
      $_SESSION['statuss'] = "Payment Successfully Updated.";
      $_SESSION['status_code'] = "success";

    }
  } else if ($payment === 'Dorm Rental Fee') {
    // Retrieve the existing payment amount
    $existingPaymentResult = mysqli_query($con, "SELECT amount FROM payment WHERE payment_id='$id'");
    $existingPaymentRow = mysqli_fetch_assoc($existingPaymentResult);
    $existingAmount = $existingPaymentRow['amount'];

    // Update the balance in room_assignments table
    mysqli_query($con, "UPDATE room_assignments SET balance = balance + $existingAmount WHERE student_number='$student_number' AND academic_year='$academic_year' AND semester='$semester' ");

    // Delete the existing payment record
    mysqli_query($con, "DELETE FROM payment WHERE payment_id='$id'");

    // Insert new payment record
    mysqli_query($con, "INSERT INTO payment VALUES (0, '$tenants_id', '$student_number', '$academic_year', '$semester', '$dormname',  '$room', '$amount', '', '$payment', '$ornumber', '$dt')");

    // Update balance in room_assignments table
    $balanceResult = mysqli_query($con, "SELECT semester, balance FROM room_assignments WHERE student_number = '$student_number' AND academic_year = '$academic_year' AND semester = '$semester'");
    $row = mysqli_fetch_assoc($balanceResult);
    $currentBalance = $row['balance'];

    if ($currentBalance == 0 && $row['semester'] == $semester) {
        $_SESSION['statuss'] = "The student has already fully paid for this semester.";
        $_SESSION['status_code'] = "error";
        
    

        mysqli_query($con, "UPDATE payment SET amount = $existingAmount WHERE student_number = '$student_number' AND academic_year = '$academic_year' AND semester = '$semester' AND payment = '$payment' AND date_created = '$dt'");
        mysqli_query($con, "UPDATE room_assignments SET balance = balance - $existingAmount WHERE student_number='$student_number' AND academic_year='$academic_year' AND semester='$semester' ");

    } elseif ($amount > $currentBalance) {
        $_SESSION['statuss'] = "The amount is greater than the balance. Please enter a valid amount.";
        $_SESSION['status_code'] = "error";

    
      
        mysqli_query($con, "UPDATE payment SET amount = $existingAmount WHERE student_number = '$student_number' AND academic_year = '$academic_year' AND semester = '$semester' AND payment = '$payment' AND date_created = '$dt'");
        mysqli_query($con, "UPDATE room_assignments SET balance = balance - $existingAmount WHERE student_number='$student_number' AND academic_year='$academic_year' AND semester='$semester' ");
    
    } else {
        mysqli_query($con, "UPDATE room_assignments SET balance = balance - $amount WHERE student_number = '$student_number' AND academic_year = '$academic_year' AND semester = '$semester'");
        $_SESSION['statuss'] = "Payment successfully updated.";
        $_SESSION['status_code'] = "success";
    }
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
  <title>DMS Update Payment</title>
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
        <a class="nav-link " href="room.php">
          <div
            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fas fa-door-closed text-info opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">List of Rooms</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="payment.php">
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
              Update Student Payment</h3>
          </div>
        </div>
      </div>

      <!--Add Button-->
      <div class="d-flex m-3 justify-content-start">
        <a class="button-option me-2" id="GFG" href="payment.php">
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
                                        window.location.href = "payment.php";
                                    });
                                </script> 
                       <?php 
                            unset($_SESSION['statuss']);
                       }
                    ?>
      <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">

          <div class="card-group shadow">
            <div class="card-body mt-3 text-dark ">

              <form class="pad" method="post">
                <!--<legend>Payment</legend>-->
                <p><b><?php echo $student_number ?> - </b><?php echo $fname ?> <?php echo $lname ?></p>
                <p><b>Dorm: </b><?php echo $dorm_name ?>   <b>Room: </b><?php echo $room ?></p>
            
                <p><b>Dorm rental amount per semester: </b><?php echo '₱'.number_format($price, 2); ?></p>
                <p><b>Remaining Balance: </b><?php echo ($balance == 0) ? 'Fully Paid' : '₱'.number_format($balance, 2); ?></p>

                <div class="row">
                <input type='text' id='student_number' name='student_number' value='<?php echo $student_number ?>' hidden>
                <input type='text' id='dormname' name='dormname' value='<?php echo $dorm_name ?>' hidden>
                <input type='text' id='room' name='room' value='<?php echo $room ?>' hidden>
                
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label for="payment" class="control-label">Select Payment</label>
                  <select name="payment" id="payment" class="form-control form-control-sm rounded-3">
                    <option><?php echo $payment ?></option>
                    <option value="Dorm Rental Fee">Dorm Rental Fee</option>
                    <option value="Electricity Fee">Electricity Fee</option>
                  </select>
                </div>
            </div>
            

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="academic_year" class="control-label">Academic Year</label>
                    <select name="academic_year" id="academic_year" class="form-control form-control-sm rounded-3 "readonly>
                        <?php 
                        $query = "SELECT DISTINCT academic_year FROM room_assignments WHERE student_number = '$student_number' AND room_id = '$room' AND dormname = '$dorm_name' ORDER BY academic_year DESC";
                        $result_academic_year = $con->query($query);

                        if ($result_academic_year->num_rows > 0) {
                            while ($optionData = $result_academic_year->fetch_assoc()) {
                                $option = $optionData['academic_year'];
                                $selected = ($option == $academic_year) ? 'selected' : '';
                                echo '<option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                  <div class="form-group">
                      <label for="semester" class="control-label">Semester</label>
                      <select name="semester" id="semester" class="form-control form-control-sm rounded-3 "readonly>
                      <?php 
                        $query = "SELECT DISTINCT semester FROM room_assignments WHERE student_number = '$student_number' AND room_id = '$room' AND dormname = '$dorm_name' ORDER BY semester DESC";
                        $result_academic_year = $con->query($query);

                        if ($result_academic_year->num_rows > 0) {
                            while ($optionData = $result_academic_year->fetch_assoc()) {
                                $option = $optionData['semester'];
                                $selected = ($option == $semester) ? 'selected' : '';
                                echo '<option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
                            }
                        }
                        ?>
                      </select>
                  </div>
              </div>

              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="payment" class="control-label">Official Reciept Number</label>
                    <input type="number" name="ornumber" id="ornumber" class="form-control form-control-sm rounded-3 " value="<?php echo $or_number ?>">
                       
                  
                </div>
            </div>
            
                  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                      <label for="price" class="control-label">Amount</label>
                      <input type="number" name="amount" id="amount" class="form-control form-control-sm rounded-3" placeholder="Amount" value="<?php echo $amount ? $amount : $electricity_fee ?>" required />

                    </div>
                  </div>
                 
                  <div class="d-flex flex-row align-items-center flex-wrap">
                    <!-- Submit and reset -->
                    <div class="my-1 me-sm-2">
                      <button type="submit" id="submit" name="submit" class="button-option1">
                        <span class="transition"></span>
                        <span class="gradient"></span>
                        <span class="label">Update</span>
                      </button>
                    </div>
                    </div>
                    </form>
            </div><br>
         </div>
        </div>
        <br></div>

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
          $('button.btn-primary').click(function() {
            id = $(this).attr('id')
            $.ajax({
              url: "paymenthistory.php",
              method: 'post',
              data: {
                id
              },
              success: function(result) {
                $(".modal-body").html(result);
              }
            });
            $('#myModal').modal("show");
          })
        })
      </script>

<script>
  const paymentInput = document.getElementById('payment');

  if (paymentInput.value === '') {
    paymentInput.classList.add('empty-input');
  }

  paymentInput.addEventListener('input', function() {
    if (paymentInput.value === '') {
      paymentInput.classList.add('empty-input');
    } else {
      paymentInput.classList.remove('empty-input');
    }
  });
</script>

<script>
  const ornumberInput = document.getElementById('ornumber');

  if (ornumberInput.value === '') {
    ornumberInput.classList.add('empty-input');
  }

  ornumberInput.addEventListener('input', function() {
    if (ornumberInput.value === '') {
      ornumberInput.classList.add('empty-input');
    } else {
      ornumberInput.classList.remove('empty-input');
    }
  });
</script>

<script>
  const amountInput = document.getElementById('amount');

  if (amountInput.value === '') {
    amountInput.classList.add('empty-input');
  }

  amountInput.addEventListener('input', function() {
    if (amountInput.value === '') {
      amountInput.classList.add('empty-input');
    } else {
      amountInput.classList.remove('empty-input');
    }
  });
</script>

</body>

</html>
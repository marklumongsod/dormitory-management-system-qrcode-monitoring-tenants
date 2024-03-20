<?php
    include('dbconnect.php');

    session_start(); 
    
    if (isset($_REQUEST['login'])) {
        $username = mysqli_real_escape_string($con, $_POST['username']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
    
        $query = mysqli_query($con, "SELECT * FROM user WHERE username='$username' AND password='$password'");
        $count = mysqli_num_rows($query);
        $row = mysqli_fetch_array($query);
    
        if ($count > 0) {
            $role = $row['role']; 
            
            if ($role == "Dormitory Manager") {
                $_SESSION['id'] = $row['acc_id'];
                header("Location: index.php"); 
                exit();
            } elseif ($role == "Super Administrator") {
                $_SESSION['id'] = $row['acc_id'];
                header("Location: ./admin/index.php"); 
                exit();
            } else {
               
            }
        } else {
            ?>
            <script type="text/javascript">
                alert("Error, double check your username or password");
                window.location = "login.php";
            </script>
            <?php
        }
    }
    
    if (isset($_SESSION['error_message'])) {
        echo '<script type="text/javascript">alert("' . $_SESSION['error_message'] . '");</script>';
        unset($_SESSION['error_message']);
    }
    

    
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Dormitory Management System</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@600&display=swap"
        rel="stylesheet">
    <link href="assets/css/styles.login.css" rel="stylesheet">
    <link rel="stylesheet" href="libs/style.css">
    <link rel="icon" href="assets/img/CvSUlogo.png">

    <style>
    .navbar-inverse .navbar-nav li a:hover {
        color: white;
    }
    </style>

</head>

<body>
<nav class="navbar-inverse" role="navigation" style="background-color: transparent;">
    <a href="login.php"><img src="assets/img/logo.png" class="hederimg" style="width:150px;height:50px"></a>
    <ul class="nav navbar-nav" style="position: absolute; right: 4%; list-style: none;">
        <li><a href="about.php" class="btn-solid-login" style="text-decoration: none;">About System</a></li>
    </ul>
</nav>






    

   

    <div class="marquee">
        <h3>
            <div class="marquee-wrapper">
                <div class="marquee-title">
                    <span class="text-stroke-black">Dormitory Management System</span>
                    <span class="text-stroke-black">&amp; Log Monitoring System with qr code</span>
                    <span class="text-stroke-black">Dormitory Management System</span>
                    <span class="text-stroke-black">&amp; Log Monitoring System with qr code</span>
                </div>
            </div>
        </h3>
    </div>
    
    <div class="login-box">
        <p>Cavite State University Dormitory Management And Log Monitoring System</p><p><br>Administrator Login</p>
        <form method="post">
            <div class="user-box">
                <input class="input-login"  id="username" name="username" type="text" required>
                <label>Username</label>
            </div>
            <div class="user-box">
                <input class="input-login"  id="password" name="password" type="password" required>
                <label>Password</label>
            </div>
            <button type="submit" id="login" name="login" class="btn-solid-login">Sign in</button>
        </form><br>
        

    </div>




    </header>
</body>

</html>
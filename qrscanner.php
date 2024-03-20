<?php
 session_start();
include("dbconnect.php"); ?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="assets/js/adapter.min.js"></script>
    <script type="text/javascript" src="assets/js/vue.min.js"></script>
    <script type="text/javascript" src="assets/js/instascan.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="assets/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Orbitron'>
    <link rel="icon" href="img/favicon.ico" type="image/png">
    <link rel="stylesheet" href="libs/css/bootstrap.min.css">
    <link rel="stylesheet" href="libs/style.css">
    <script src="libs/navbarclock.js"></script>
    <title>Student Logs</title>
    <link rel="icon" href="assets/img/CvSUlogo.png">
    <style>
        @font-face {
            font-family: Cyber;
            src: url("https://assets.codepen.io/605876/Blender-Pro-Bold.otf");
            font-display: swap;
        }

        h3 {
            font-size: 30px;
            font-family: 'Cyber', sans-serif;
        }

        body {
            overflow-x: hidden;
            background-image: linear-gradient(to right,
                    #90EE90,
                    #90EE90,
                    #77dd77);

        }

        .card {
    position: relative;
    width: 700px;
    height: 484px;
    background: rgb(236, 236, 236);
    box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
    margin: 0 auto; 
}

.card-text {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    padding: 10px;
    text-align: center;
    background-color: rgba(0, 0, 0, 0.5);
    color: #fff;
    box-sizing: border-box; 
}


.container-fluid {
  display: flex;
  flex-direction: column;
  align-items: center;
}
.form-group.text-center {
  text-align: center;
}

.radio-buttons {
  display: inline-block;
  margin-right: 10px;
}

.radio-buttons input[type="radio"] {
  display: none;
}

.radio-buttons label {
  display: inline-block;
  padding: 5px 10px;
  background-color: #e9ecef;
  border-radius: 4px;
  cursor: pointer;
}

.radio-buttons input[type="radio"]:checked + label {
  background-color: #007bff;
  color: #fff;
}
.select-options {
        display: inline-block;
        margin-left: 10px;
    }


    </style>
</head>

<body onload="startTime()">

    <nav class="navbar-inverse" role="navigation">
        <a href=time_in_out.php>
            <img src="assets/img/brand2.png" class="hederimg" style="width:150px;height:50px">
        </a>
        <div id="boarderlog">
            <h3>Student Boarder Log</h3>
        </div>
        <div id="clockdate">
            <div class="clockdate-wrapper">
                <div id="clock"></div>
                <div id="date"><?php echo date('l, F j, Y'); ?></div>
            </div>
        </div>
    </nav>

    
    <div class="container-fluid px-4">

    <br><br><br><br>
    <form method="post" action="insertqr.php">
    <div class="form-group text-center">
    <label for="time-option" class="control-label">Select Action:</label><br>
    <div class="radio-buttons">
        <input class="form-check-input" type="radio" name="time-option" id="time-out" value="timeout">
        <label class="form-check-label" for="time-out">Time Out (Lalabas)</label>
        <div class="select-options">
            <label id="option-label" style="display: none;">Select Destination:</label>
            <select id="destination-option" name="destination-option" style="display: none;">
                <option value="Class">University/Class</option>
                <option value="Home">Home</option>
                <option value="Part-time job">Part-time Job</option>
                <option value="Social activity">Social Activity</option>
                <option value="Other">Other</option> 
            </select>
        </div>
    </div>
    <div class="radio-buttons">
        <input class="form-check-input" type="radio" name="time-option" id="time-in" value="timein" required>
        <label class="form-check-label" for="time-in">Time In (Papasok)</label>
        <div class="select-options">
            <label id="option-label-origin" style="display: none;">Select Origin:</label>
            <select id="origin-option" name="origin-option" style="display: none;">
                <option value="Class">University/Class</option>
                <option value="Home">Home</option>
                <option value="Part-time job">Part-time Job</option>
                <option value="Social activity">Social Activity</option>
                <option value="Other">Other</option> 
            </select>
        </div>
    </div>
    <div id="other-text-field" style="display: none;"> 
        <label for="other-option">Please specify:</label>
        <input type="text" id="other-option" name="other-option">
    </div>
</div>

<div class="row my-5">
    <div class="col-md-8 d-flex justify-content-center">
        <div class="card">
            <div class="video-container" id="camera-container" style="display: none;">
                <video id="preview" width="100%"></video>
            </div>
            <div class="card-text">
                Scan your assigned QR Code.
            </div>
        </div>
    </div>
</div>
</div>

    <br>

            
           

            <div class="col-lg-12">
                <?php                      
                if(isset($_SESSION['statuss'])) {
                    echo "<div class='" . $_SESSION['status_code'] . "'  style='background:green; color:white; font-size:50px; padding:10px; margin-bottom:0px;'>";
                    echo " " . $_SESSION['statuss'] . " ";
                    echo "</div>";
                }
                if(isset($_SESSION['error'])) {
                    echo "<div class='" . $_SESSION['status_codee'] . "' style='background:danger; color:black; font-size:50px; padding:10px; margin-bottom:0px;'>
                            <h4>Error!</h4>
                            " . $_SESSION['error'] . "
                        </div>";
                }
                unset($_SESSION['statuss']);
                unset($_SESSION['error']);
            ?>
            </div>
        

    <div class="col-md-6">

            <br><br><br><br><br>
            <input type="hidden" name="text" id="text" readonly placeholder="Scan QR Code" class="form-control">
      

    </div>
    </div>
    </div>
    </form>
    <script>
        let scanner = new Instascan.Scanner({
            video: document.getElementById('preview')
        });
        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                alert('No cameras found')
            }
        }).catch(function(e) {
            console.error(e);
        });
        scanner.addListener('scan', function(c) {
            document.getElementById('text').value = c;
            document.forms[0].submit();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>

<script>
    const timeInRadio = document.getElementById('time-in');
    const timeOutRadio = document.getElementById('time-out');
    const destinationLabel = document.getElementById('option-label');
    const destinationSelect = document.getElementById('destination-option');
    const originLabel = document.getElementById('option-label-origin');
    const originSelect = document.getElementById('origin-option');
    const otherTextField = document.getElementById('other-text-field');
    const cameraContainer = document.getElementById('camera-container');

    timeInRadio.addEventListener('click', () => {
        destinationLabel.style.display = 'none';
        destinationSelect.style.display = 'none';
        originLabel.style.display = 'block';
        originSelect.style.display = 'block';
        otherTextField.style.display = 'none'; 
        cameraContainer.style.display = 'block';
    });

    timeOutRadio.addEventListener('click', () => {
        destinationLabel.style.display = 'block';
        destinationSelect.style.display = 'block';
        originLabel.style.display = 'none';
        originSelect.style.display = 'none';
        otherTextField.style.display = 'none'; 
        cameraContainer.style.display = 'block'; 
    });

    destinationSelect.addEventListener('change', () => {
        if (destinationSelect.value === 'Other') {
            otherTextField.style.display = 'block'; 
            cameraContainer.style.display = 'block'; 
        } else {
            otherTextField.style.display = 'none'; 
            cameraContainer.style.display = 'block'; 
        }
    });

    originSelect.addEventListener('change', () => {
        if (originSelect.value === 'Other') {
            otherTextField.style.display = 'block'; 
            cameraContainer.style.display = 'block'; 
        } else {
            otherTextField.style.display = 'none'; 
            cameraContainer.style.display = 'block'; 
        }
    });
</script>

</body>

</html>
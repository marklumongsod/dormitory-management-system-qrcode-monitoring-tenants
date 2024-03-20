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
        <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Orbitron' >
        <link rel="icon" href="img/favicon.ico" type="image/png">
        <link rel="stylesheet" href="libs/css/bootstrap.min.css">
        <link rel="stylesheet" href="libs/style.css">
        <script src="libs/navbarclock.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">





<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

        <title>Student Logs</title>
        <link rel="icon" href="assets/img/CvSUlogo.png">
        <title>Visitor Logs</title>
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
  background-image: linear-gradient(
    to right,
    #90EE90,
    #90EE90,
    #77dd77
    
  );
}


  </style>
    </head>
    <body onload="startTime()">

      <nav class="navbar-inverse" role="navigation">
        <a href=time_in_out.php>
              <img src="assets/img/brand2.png" class="hederimg" style="width:150px;height:50px">
        </a>
              <div id="boarderlog"><h3>Visitor Log</h3></div>
        <div id="clockdate">
          <div class="clockdate-wrapper">
            <div id="clock"></div>
            <div id="date"><?php echo date('l, F j, Y'); ?></div>
          </div>
        </div>
      </nav>
       
       
            <div class="container-fluid px-4">
            <div class="row my-5">

                <div class="card bg-light">
                <div class="card-body mt-3 text-dark">
                <div class="col-md-4">
              <br><br><br><br><br>
                    <form method="post"> 
                            
                                
                              <div class="row">

                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="name" class="control-label">Name</label>
                                    <input type="text" name="name" id="name" class="form-control form-control-sm rounded-0" required/>
                                  </div>
                                </div>

                                 <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="select">Name of person to visit</label>
                                    <select class="form-control form-control-sm rounded-0" name="personname" id="personname" required>
                                      <option value="">Select Students</option>
                                      <?php 
                                      $query ="SELECT * FROM tenants ORDER BY fname ASC";
                                      $result = $con->query($query);
                                      if($result->num_rows > 0){
                                        while($optionData = $result->fetch_assoc()){
                                          $fname = $optionData['fname'];
                                          $lname = $optionData['lname'];
                                          $studnum = $optionData['studnum'];
                                      ?>
                                          <option value="<?php echo $studnum?>"><?php echo $fname.' '.$lname; ?></option> 
                                      <?php
                                        }
                                      }
                                      ?>
                                    </select>  
                                  </div>
                            </div>

                                
                                
                              </div>

                            <div class="row">

                           
                                
                                <div class="col-md-6">
                                <div class="form-group">
                                  <label for="purpose" class="control-label">Purpose of visit</label>
                                  <select name="purpose" id="purpose" class="form-control form-control-sm rounded-0" required>
                                    <option value="">Select Purpose</option>
                                    <!--<option value="Social Visit">Social visit</option>
                                    <option value="Academic Collaboration">Academic collaboration</option>
                                    <option value="Support Assistance">Support or assistance</option>
                                    <option value="Formal Meetings">Formal meetings</option>
                                    <option value="Delivery Package">Delivery or package pickup</option>
                                    <option value="Dormitory Tour">Dormitory tour</option>
                                    <option value="Official Business">Official business</option>-->
                                    <option value="Parent family visit">Parent or family visit</option>
                                    <option value="other">Other</option>
                                  </select>
                                </div>
                              </div>
                              

                              <div class="col-md-6">
                            <div class="form-group">
                              <label for="select">Dorm / Room</label>
                              <select class="form-control form-control-sm rounded-0" name="roomnumber" id="roomnumber" required>
                                <option value="">Select Dorm</option>
                                
                              </select>  
                            </div>
                          </div>

                          <div class="col-md-6" id="other-purpose-field" style="display: none;">
                                <div class="form-group">
                                  <label for="other-purpose" class="control-label">Please specify:</label>
                                  <input type="text" class="form-control form-control-sm rounded-0" name="other-purpose" id="other-purpose">
                                </div>
                              </div>

                        
                             
                            </div>
                            
                            <div class="row">
                            <div class="col-md-6">
                                <button type="submit"  id="submit" name="submit" class="btn  text-dark btn-block my-3"><i class="fas fa-user-clock"></i> Time in</button>
                            </div>
                            </div><br>
                    
                </div>
               
                <?php
                       if(isset($_POST['submit'])){
                        date_default_timezone_set("Asia/Manila");
                        
                        $name = mysqli_real_escape_string($con, $_POST['name']);
                        $roomnumber = mysqli_real_escape_string($con, $_POST['roomnumber']);
                        $personname = mysqli_real_escape_string($con, $_POST['personname']);
                        
                        $purpose = mysqli_real_escape_string($con, $_POST['purpose']);
                        if ($purpose === 'other') {
                            $otherPurpose = mysqli_real_escape_string($con, $_POST['other-purpose']);
                            $purpose = $otherPurpose;
                        }
                        
                        $date = date('Y-m-d');
                        $time = date('h:i:s A');
                    
                        $sql = "INSERT INTO visitor (name, room_number, visit_person, purpose, time_in, logdate) 
                                VALUES ('$name', '$roomnumber', '$personname', '$purpose', '$time', '$date')";
                        $query = $con->query($sql);
                    }                             
                ?>
                <div class="col-md-8">
                <form action="insertqr.php" method="post" class="form-horizontal">
                <div class="text-uppercase">
                <br><br><br><br><br>
                </div>
                </form>
                    <table id="table"  class="table bg-white rounded shadow-sm table-striped table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NAME</th>
                                <th>DORM / ROOM</th>
                                <th>PERSON TO VISIT</th>
                                <th>PURPOSE</th>
                                <th scope="col" width="10%">IN</th>
                                <th scope="col" width="10%">OUT</th>
                                <th>LOGDATE</th>
                                <th scope="col" width="10%">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $sql = "SELECT * FROM visitor 
                            LEFT JOIN tenants ON visitor.visit_person = tenants.studnum
                            WHERE DATE(logdate)=CURDATE()";
                            $query = $con->query($sql);
                            while ($row = $query->fetch_assoc()){
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $row['name'];?></td>
                                <td><?php echo $row['room_number'];?></td>
                                <td><?php echo $row['fname'];?> <?php echo $row['lname'];?></td>
                                <td><?php echo $row['purpose'];?></td>
                                <td><?php echo $row['time_in'];?></td>
                                <td><?php echo $row['time_out'];?></td>
                                <td><?php echo $row['logdate'];?></td>
                                <td><a href="editvisitorlogs.php?id=<?php echo $row["id"]; ?>"><button class="btn"><i class="fas fa-user-clock"></i> Time out</button></a>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table> 

                   
                </div>
            </div>
        </div>
    <script>
    $(document).ready(function () {
        $('#table').DataTable();
    });
    </script>

<script>
  $(document).ready(function() {
   
    $('#personname').select2();
  });
</script>

<script>
  $(document).ready(function() {
    
    $('#purpose').on('change', function() {
      var selectedValue = $(this).val();
      if (selectedValue === 'other') {
       
        $('#other-purpose-field').show();
      } else {
     
        $('#other-purpose-field').hide();
        $('#other-purpose').val('');
      }
    });
  });
</script>

<script>
 
  $("#personname").on("change", function() {
    var personname = $(this).val();
    if (personname != '') {
      $.ajax({
        type: 'POST',
        url: 'get_room_numbers.php',
        data: {
          personname: personname
        },
        success: function(data) {
          $("#roomnumber").html(data);
        }
      });
    }
  });
</script>
        
    </body>
</html>



<?php
include("dbconnect.php");
$id=$_GET['id'];          
                      
                            
                            date_default_timezone_set("Asia/Manila");
                            $date = date('Y-m-d');
                            $time = date('h:i:s A');

                            mysqli_query($con,"UPDATE visitor SET time_out='$time' WHERE id='$id'") or die (mysqli_error());                          
                            header ('location:visitorlogs.php');
                ?>
            </div>
        </div>
   



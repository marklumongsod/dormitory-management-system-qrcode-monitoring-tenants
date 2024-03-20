<?php

include('dbconnect.php');

if(isset($_POST["id"]))  
{
    $output = '';
    
    
    $id = mysqli_real_escape_string($con, $_POST["id"]);

   
    $query = "SELECT * FROM tenants
    JOIN payment ON tenants.studnum = payment.student_number
    WHERE tenants.tenants_id = ? ORDER BY payment.payment ASC";
    
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    //echo '<legend>'.$row["fname"].'</legend>';
    $output .= '
    <br>
    <div class="table-responsive">  
        <input type="text" id="searchInput" placeholder="Search...">
        <table class="table table-striped">
        <th width="50%"><label>Date created</label></th>
        <th width="20%"><label>OR number</label></th>
        <th width="20%"><label>Academic Year</label></th>  
        <th width="20%"><label>Semester</label></th>  
        <th width="10%"><label>Payment</label></th> 
        <th width="10%"><label>Amount</label></th>  
        <th width="10%"><label>Action</label></th>';

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $output .= '
        <tr>
            <td>'.date('F-d-Y', strtotime($row['date_created'])).'</td>
            <td>'.$row["or_number"].'</td>
            <td>'.$row["academic_year"].'</td>
            <td>'.$row["semester"].'</td>
            <td>'.$row["payment"].'</td>
            <td>';

        if (!empty($row['amount'])) {
            $output .= $row['amount'];
        } else {
            $output .= $row['electricity_fee'];
        }

        $output .= '</td>
            <td>
                <a href="editpayment.php?id=' . $row["payment_id"] . '"><button class="btn bg-gradient-success"><i class="fa fa-edit"></i></button></a>
                <!--<button class="confirm_del_btn btn btn-danger" data-id="' . $row['payment_id'] . '"><i class="fa fa-trash"></i></button>-->
            </td>
        </tr>';

    }
} else {
    $output .= '
        <tr>
            <td colspan="7">No payment has been made.</td>
        </tr>';
}

$output .= "</table></div>";

$output .= '
<script>
  $(document).ready(function() {
    $("#searchInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("table tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
</script>';

    
    echo $output;  
  ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        $('.confirm_del_btn').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
    
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this record!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                   
                    $.ajax({
                        url: "deletepayment.php",
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
    </script> <?php
    
 }
?>



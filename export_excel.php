<?php
require_once('PHPExcel.php');

function ExportToExcel($con, $start_date, $end_date) {
    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel();

    // Set document properties
    $objPHPExcel->getProperties()->setCreator("Your Name")
                                     ->setLastModifiedBy("Your Name")
                                     ->setTitle("Tenant Payments Report")
                                     ->setSubject("Tenant Payments Report")
                                     ->setDescription("Tenant Payments Report");

    // Add worksheet
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle('Payments');

    // Add table headers
    $objPHPExcel->getActiveSheet()->setCellValue('A1', '#');
    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Date Created');
    $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Name');
    $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Semester');
    $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Amount');
    $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Payment');

    // Query database table
    $query = "SELECT * FROM tenants
                LEFT JOIN payment ON tenants.tenants_id = payment.tenant_id
                WHERE payment.date_created BETWEEN '$start_date' AND '$end_date'";
    $result = mysqli_query($con, $query);

    // Check if query was successful
    if ($result) {
        $i = 2;
        // Loop through results and add each row to the worksheet
        while ($row = mysqli_fetch_assoc($result)) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $i-1);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, date('Y-F-d h:i:s A', strtotime($row['date_created'])));
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $row['fname'] . ' ' . $row['lname']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $row['semester']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $row['amount']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $row['payment']);
            $i++;
        }

        // Free result set
        mysqli_free_result($result);
    } else {
        // Display error message
        echo 'Error: ' . mysqli_error($con);
    }

    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);

    // Redirect output to a client’s web browser (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Tenant_Payments_Report.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
}
?>

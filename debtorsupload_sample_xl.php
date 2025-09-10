<?php
ob_start();
session_start(); 

include ("db/db_connect.php");
$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

$locationname  = $res["locationname"];

$locationcode = $res["locationcode"];

$res12locationanum = $res["auto_number"]; 


$subtypeanum=$_REQUEST['subtype'];

 $query3 = "select * from master_subtype where auto_number = '$subtypeanum'";
        $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res3 = mysqli_fetch_array($exec3);
        $subtype_name = $res3['subtype'];



 

?>

<?php

if (isset($_REQUEST["maintype"])) 
{

	

	$snocount=0;

	require_once 'phpexcel/Classes/PHPExcel.php';

 	$objPHPExcel = new PHPExcel();

	$objPHPExcel->getProperties()->setCreator("Med360")

							 ->setLastModifiedBy("Med360")

							 ->setTitle($subtype_name)

							 ->setSubject($subtype_name)

							 ->setDescription($subtype_name)

							 ->setKeywords($subtype_name)

							 ->setCategory("Debtors");

	$objPHPExcel->setActiveSheetIndex(0);

	$rowCount = 1; 

	 

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$rowCount, "Main Type");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$rowCount, "Sub Type");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$rowCount, "Company name");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$rowCount, "Validity(DD/MM/YYYY)");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$rowCount, "Currency");



	$rowCount++;

	
 $maintype=$_REQUEST['maintype'];
			$subtype=$_REQUEST['subtype'];




			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$rowCount, $maintype);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$rowCount, $subtype);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$rowCount, '');

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$rowCount, '');

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$rowCount, 'KES or USD');

			

			$rowCount++;

		// }

	// }

	



    $downloadpath =$subtype_name.'.xls';
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save($downloadpath);
    
	header('Content-Description: File Transfer');
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename='.basename($downloadpath));
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($downloadpath));
	ob_clean();
	flush();
	readfile($downloadpath);
	unlink($downloadpath);
	exit;
}

?>


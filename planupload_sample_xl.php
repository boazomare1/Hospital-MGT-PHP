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

							 ->setTitle("Plan-".$subtype_name)

							 ->setSubject("Plan-".$subtype_name)

							 ->setDescription("Plan-".$subtype_name)

							 ->setKeywords("Plan-".$subtype_name)

							 ->setCategory("Plan");

	$objPHPExcel->setActiveSheetIndex(0);

	$rowCount = 1; 

	 

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$rowCount, "Main Type");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$rowCount, "Sub Type");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$rowCount, "Accounts ID");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$rowCount, "Account name");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$rowCount, "Plan Name");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$rowCount, "Plan Status(OP+IP/OP/IP)");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$rowCount, "Copay Amount");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$rowCount, "Copay Percentage");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$rowCount, "All(Yes/No)");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$rowCount, "Limit Status(Overall/Visit)");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$rowCount, "Smart Applicable(Yes/No)");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$rowCount, "Overall OP Limit");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$rowCount, "Visit OP Limit");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$rowCount, "Overall Ip Limit");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$rowCount, "Visit IP Limit");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$rowCount, "Department Limit(Yes/No)");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$rowCount, "Pharmacy Limit");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$rowCount, "Lab Limit");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$rowCount, "Radiology Limit");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$rowCount, "Services Limit");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$rowCount, "Validity End(DD/MM/YYYY)");
	// $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$rowCount, "Smart");
	// $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$rowCount, "Smart");
	// $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$rowCount, "Smart");
	// $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.$rowCount, "Smart");
	// $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.$rowCount, "Smart");

	$rowCount++;

	
 

	$maintype=$_REQUEST['maintype'];
			$subtype=$_REQUEST['subtype'];

			$query31 = "SELECT * from master_accountname where subtype = '$subtype' and paymenttype='$maintype' and accountsmain='2' and accountssub='2' order by accountname";
        $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
        $x=mysqli_num_rows($exec31);
        while($res31 = mysqli_fetch_array($exec31)){


        $accountname = $res31['accountname'];
        $account_auto_number = $res31['auto_number'];
        $expirydate = $res31['expirydate'];
 
									$expirydate2 = date("d/m/Y", strtotime($expirydate));
									// $dat=date(“Y-m-d”,strtotime($dat));




			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$rowCount, $maintype);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$rowCount, $subtype);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$rowCount, $account_auto_number);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$rowCount, $accountname);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$rowCount, '');

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$rowCount, '');

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$rowCount, '');

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$rowCount,'');

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$rowCount, '');


			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$rowCount, "");

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$rowCount, "");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$rowCount, "");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$rowCount, "");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$rowCount, "");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$rowCount, "");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$rowCount, "");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$rowCount, "");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$rowCount, "");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$rowCount, "");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$rowCount, "");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$rowCount, $expirydate2);

			$rowCount++;

		}

	// }

	



    $downloadpath ='Plan-'.$subtype_name.'.xls';
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


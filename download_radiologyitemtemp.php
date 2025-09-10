<?php
session_start();  
ob_start();

include ("db/db_connect.php");

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

$locationname  = $res["locationname"];

$locationcode = $res["locationcode"];

$res12locationanum = $res["auto_number"]; 

$temp=isset($_REQUEST['radtemp'])?$_REQUEST['radtemp']:'';

if (isset($_REQUEST["frmflag34"])) { $frmflag34 = $_REQUEST["frmflag34"]; } else { $frmflag34 = "frmflag34"; }

?>

<?php

if($frmflag34 == 'frmflag34')

{

	

	$snocount=0;

	require_once 'phpexcel/Classes/PHPExcel.php';

 	$objPHPExcel = new PHPExcel();

	$objPHPExcel->getProperties()->setCreator("Med360")

							 ->setLastModifiedBy("Med360")

							 ->setTitle("Radiology Template")

							 ->setSubject("Radiology Template")

							 ->setDescription("Radiology Template")

							 ->setKeywords("Radiology Template")

							 ->setCategory("Radiology");

	$objPHPExcel->setActiveSheetIndex(0);

	$rowCount = 1; 

	 

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$rowCount, "S.No");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$rowCount, "Item Code");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$rowCount, "Category");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$rowCount, "Item Name");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$rowCount, "Location");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$rowCount, "Temp Name");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$rowCount, "Unit Charges");

	

	$rowCount++;

	

	$query1 = "select * from $temp where status <> 'deleted'  group by itemcode order by itemcode asc ";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res1 = mysqli_fetch_array($exec1))

		{

		$itemcode = $res1["itemcode"];

		$itemname = $res1["itemname"];

		$categoryname = $res1["categoryname"];

		$purchaseprice = $res1["purchaseprice"];

		$rateperunit = $res1["rateperunit"];

		$expiryperiod = $res1["expiryperiod"];

		$auto_number = $res1["auto_number"];

		$itemname_abbreviation = $res1["itemname_abbreviation"];

		$taxname = $res1["taxname"];

		$taxanum = $res1["taxanum"];

		$ipmarkup = $res1["ipmarkup"];

		$location = $res1["locationcode"];

		$rate2 = $res1['rate2'];

		$rate3 = $res1['rate3'];

	

		if ($expiryperiod != '0') 

		{ 

			$expiryperiod = $expiryperiod.' Months'; 

		}

		else

		{

			$expiryperiod = ''; 

		}

		

		

		

			$sno=0;

			$snocount = $snocount + 1;

			

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$rowCount, $snocount);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$rowCount, $itemcode);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$rowCount, $categoryname);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$rowCount, $itemname);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$rowCount, $location);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$rowCount, $temp);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$rowCount, $rateperunit);

			

			

			$rowCount++;

		}

	// }

	

	$objPHPExcel->setActiveSheetIndex(0)->setTitle($temp);

 	$objSheet = $objPHPExcel->getActiveSheet();

	

	//PROTECT THE CELL RANGE

	$objSheet->protectCells('G1:G'.$rowCount, 'MasterData');

	

	// UNPROTECT THE CELL RANGE

	$objSheet->getColumnDimension('G')->setVisible(true);

	$objSheet->getStyle('G1:G'.$rowCount)

      ->getProtection()

      ->setHidden(PHPExcel_Style_Protection::PROTECTION_PROTECTED);

	
/*
	$objSheet->getStyle('G1:G'.$rowCount)

	  ->getFont()->getColor( )->setRGB('FFFFFF');*/
	  



	/*$objSheet->getStyle('A1:I'.$rowCount)

	  ->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);*/

	$objSheet->getStyle('A1:G'.$rowCount)->applyFromArray(

    	array(

        	'borders' => array(

        	    'allborders' => array(

        	        'style' => PHPExcel_Style_Border::BORDER_THIN,

        	        'color' => array('rgb' => '000000')

        	    )

        	)

    	)

	);



	$objSheet->getStyle('G2:G'.$rowCount)->getProtection()

		->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

	

	// PROTECT THE WORKSHEET SHEET

	$objSheet->getProtection()->setSheet(true)

							->setPassword('MasterData')

							//->setSelectLockedCells(true)

							->setFormatCells(true)

							->setFormatRows(true)

							->setInsertColumns(true)

							->setInsertRows(true)

							->setDeleteColumns(true)

							->setDeleteRows(true);


    $downloadpath ='stocktaking/'.$temp.'.xls';
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


<?php
session_start();
include ("db/db_connect.php");
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
$locationname  = $res["locationname"];
$locationcode = $res["locationcode"];
$res12locationanum = $res["auto_number"]; 
if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }
if (isset($_REQUEST["subtype"])) { $searchsubtype = $_REQUEST["subtype"]; } else { $searchsubtype = ""; }
$locationcode = $location;
$searchsubtype = $searchsubtype;
if (isset($_REQUEST["frmflag34"])) { $frmflag34 = $_REQUEST["frmflag34"]; } else { $frmflag34 = ""; }
?>
<?php
if($frmflag34 == 'frmflag34')
{
	
	$snocount=0;
	require_once 'phpexcel/Classes/PHPExcel.php';
 	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("Med360")
							 ->setLastModifiedBy("Med360")
							 ->setTitle("Pharmacy Rates")
							 ->setSubject("Pharmacy Rates")
							 ->setDescription("Pharmacy Rates")
							 ->setKeywords("Pharmacy Rates")
							 ->setCategory("Pharmacy");
	$objPHPExcel->setActiveSheetIndex(0);
	$rowCount = 1; 
	$colCount = 'A';
	$ratecolumn = '';
	$lastcolumn = '';
	$subtypeanos = array();
	$subtypes = array();
	 $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colCount.$rowCount, "S.No");$colCount++;
	 $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colCount.$rowCount, "Item Code");$colCount++;
	 $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colCount.$rowCount, "Item Name");$colCount++;/*
	 $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colCount.$rowCount, "Category Name");$colCount++;*/
	if($searchsubtype == 1)
	{
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colCount.$rowCount, "Rate");
		$ratecolumn =$colCount;
	}
	else
	{
	$qrysubtype = "select * from master_subtype where auto_number = '$searchsubtype' and recordstatus <> 'deleted'";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $qrysubtype) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res =mysqli_fetch_array($exec))
	{
	 $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colCount.$rowCount,$res['subtype']);
	 $ratecolumn =$colCount;
	 array_push($subtypes,$res['subtype']);
	 array_push($subtypeanos,$res['auto_number']);
	}
	}
	$lastcolumn = $colCount;
	 $rowCount++;$colCount = 'A';
	$qry001 = "select * from master_medicine where status <> 'deleted' order by categoryname ASC";
	$exec001 = mysqli_query($GLOBALS["___mysqli_ston"], $qry001) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res001 =mysqli_fetch_array($exec001))
	{ 
		$medanum=$res001['auto_number'];
			$itemname=$res001['itemname'];
			$itemcode=$res001['itemcode'];
			$rate=$res001['rateperunit'];
			$sno=0;
			$snocount = $snocount + 1;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colCount.$rowCount, $snocount);$colCount++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colCount.$rowCount, $itemcode);$colCount++;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colCount.$rowCount, $itemname);$colCount++;/*
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colCount.$rowCount, $category);$colCount++;*/
		if($searchsubtype ==1)
		{
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colCount.$rowCount, $res001[$locationcode.'_rateperunit']);$colCount++;
		}
		else{
		foreach($subtypeanos as $key => $subtype)
		{
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colCount.$rowCount, $res001['subtype_'.$subtype]);$colCount++;	
		}
		}
		$rowCount++;$colCount = 'A';
	}
	//echo $rowCount;
	$rowCount--;
	$objPHPExcel->setActiveSheetIndex(0)->setTitle("Pharmacy Rates");
 $objSheet = $objPHPExcel->getActiveSheet();
//PROTECT THE CELL RANGE

$objSheet->protectCells('A1:C'.$rowCount, 'MasterData');
// UNPROTECT THE CELL RANGE
/*$objSheet->getColumnDimension('J')->setVisible(false);
$objSheet->getStyle('J1:J'.$rowCount)
      ->getProtection()
      ->setHidden(PHPExcel_Style_Protection::PROTECTION_PROTECTED);
$objSheet->getStyle('J1:J'.$rowCount)
	  ->getFont()->getColor( )->setRGB('FFFFFF');*/

/*$objSheet->getStyle('A1:I'.$rowCount)
	  ->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);*/
$objSheet->getStyle('A1:'.$lastcolumn.$rowCount)->applyFromArray(
    array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')
            )
        )
    )
);

$objSheet->getStyle($ratecolumn.'2:'.$ratecolumn.$rowCount)->getProtection()
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
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename=Pharamcy Rates.xls');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 EAT'); // Date in the past
header ('Last-Modified: '.date('D, d M Y H:i:s').' EAT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');



}
?>

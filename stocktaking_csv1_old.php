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
if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
$locationcode = $location;
$storecode = $store;
$query778 = mysqli_query($GLOBALS["___mysqli_ston"], "select store from master_store where storecode = '$storecode'");
$res778 = mysqli_fetch_array($query778);
$storename = $res778['store'];
$storename = str_replace(' ','_',$storename);
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
							 ->setTitle("Stock taking")
							 ->setSubject("Stock Taking")
							 ->setDescription("Stock Taking")
							 ->setKeywords("Stock Taking")
							 ->setCategory("Stock");
	$objPHPExcel->setActiveSheetIndex(0);
	$rowCount = 1; 
	 
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$rowCount, "S.No");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$rowCount, "Store Code");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$rowCount, "Item Code");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$rowCount, "Item Name");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$rowCount, "Category Name");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$rowCount, "Rate");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$rowCount, "Exp Date");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$rowCount, "Batch");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$rowCount, "Sys Qty");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$rowCount, "Phy Qty");
	$rowCount++;
	
	// $qry001 = "select categoryname from master_medicine group by categoryname order by categoryname ASC";
	// $exec001 = mysql_query($qry001) or die(mysql_error());
	// while($res001 =mysql_fetch_array($exec001))
	// { 
		//$category1 = addslashes($res001['categoryname']);
		$query01="select a.auto_number as auto_number,a.itemname as itemname,a.itemcode as itemcode,sum(a.batch_quantity) as batch_quantity,a.batchnumber as batchnumber,a.rate as rate,c.categoryname as category,  a.locationcode,a.storecode,a.fifo_code,b.expirydate as expirydate from transaction_stock a JOIN purchase_details as b ON a.fifo_code=b.fifo_code JOIN master_medicine c ON (a.itemcode=c.itemcode) where a.storecode='$store' AND a.locationcode='$locationcode' AND a.batch_quantity > '0' AND a.batch_stockstatus ='1' group by a.batchnumber, b.expirydate, a.itemname order by a.itemname";
		$run01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
		while($exec01=mysqli_fetch_array($run01))
		{
			$medanum=$exec01['auto_number'];
			$itemname=$exec01['itemname'];
			$itemcode=$exec01['itemcode']; 
			$batchnumber=$exec01['batchnumber'];
			$category = $exec01['category'];
			$fifo_code = $exec01['fifo_code'];
			// $query03="select SUM(batch_quantity) as batch_quantity FROM transaction_stock WHERE itemcode='$itemcode' AND storecode='".$storecode."' AND locationcode='".$locationcode."' AND batch_quantity > '0' AND batch_stockstatus ='1' and batchnumber='$batchnumber' and fifo_code = '$fifo_code'";
			// $run03=mysql_query($query03);
			// $exec03=mysql_fetch_array($run03);				
			$batch_quantity=$exec01['batch_quantity'];
			$query04="select expirydate FROM purchase_details WHERE itemcode='$itemcode' and fifo_code='$fifo_code' group by expirydate, batchnumber asc";
			$run04=mysqli_query($GLOBALS["___mysqli_ston"], $query04);
			$exec04=mysqli_fetch_array($run04);	
			$expirydate=$exec04['expirydate'];
			if($expirydate=='')
			{
				$query05="select expirydate FROM materialreceiptnote_details WHERE itemcode='$itemcode' and fifo_code='$fifo_code' order by expirydate, batchnumber asc";
				$run05=mysqli_query($GLOBALS["___mysqli_ston"], $query05);
				$exec05=mysqli_fetch_array($run05);	
				$expirydate=$exec05['expirydate'];
			}
			$rate=$exec01['rate'];
			$sno=0;
			$snocount = $snocount + 1;
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$rowCount, $snocount);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$rowCount, $storecode);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$rowCount, $itemcode);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$rowCount, $itemname);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$rowCount, $category);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$rowCount, $rate);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$rowCount,$expirydate);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$rowCount, "'".$batchnumber);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$rowCount, $batch_quantity);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$rowCount, "0");
			$rowCount++;
		}
	// }
	
	$objPHPExcel->setActiveSheetIndex(0)->setTitle($storename);
 	$objSheet = $objPHPExcel->getActiveSheet();
	
	//PROTECT THE CELL RANGE
	$objSheet->protectCells('A1:H'.$rowCount, 'MasterData');
	
	// UNPROTECT THE CELL RANGE
	$objSheet->getColumnDimension('J')->setVisible(true);
	$objSheet->getStyle('J1:J'.$rowCount)
      ->getProtection()
      ->setHidden(PHPExcel_Style_Protection::PROTECTION_PROTECTED);
	
	$objSheet->getStyle('J1:J'.$rowCount)
	  ->getFont()->getColor( )->setRGB('FFFFFF');

	/*$objSheet->getStyle('A1:I'.$rowCount)
	  ->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);*/
	$objSheet->getStyle('A1:I'.$rowCount)->applyFromArray(
    	array(
        	'borders' => array(
        	    'allborders' => array(
        	        'style' => PHPExcel_Style_Border::BORDER_THIN,
        	        'color' => array('rgb' => '000000')
        	    )
        	)
    	)
	);

	$objSheet->getStyle('I2:I'.$rowCount)->getProtection()
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
	header('Content-Disposition: attachment;filename='.$storename.'.xls');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');
	
	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');

}
?>

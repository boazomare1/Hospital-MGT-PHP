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

if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }

if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }

if (isset($_REQUEST["producttype"])) { $producttype = $_REQUEST["producttype"]; } else { $producttype = ""; }
if (isset($_REQUEST["categoryid"])) { $categoryid = $_REQUEST["categoryid"]; } else { $categoryid = ""; }
if (isset($_REQUEST["category"])) { $category = $_REQUEST["category"]; } else { $category = ""; }

if (isset($_REQUEST["genericname"])) { $genericname = $_REQUEST["genericname"]; } else { $genericname = ""; }

if (isset($_REQUEST["res_prod_id"])) { $res_prod_id = $_REQUEST["res_prod_id"]; } else { $res_prod_id = ""; }

$locationcode = $location;

$storecode = $store;

$query778 = mysqli_query($GLOBALS["___mysqli_ston"], "select store from master_store where storecode = '$storecode'");

$res778 = mysqli_fetch_array($query778);

$storename = $res778['store'];

$storename = str_replace(' ','_',$storename);

if (isset($_REQUEST["frmflag34"])) { $frmflag34 = $_REQUEST["frmflag34"]; } else { $frmflag34 = ""; }

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

	 

	//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$rowCount, "S.No");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$rowCount, "storecode");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$rowCount, "itemcode");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$rowCount, "itemname");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$rowCount, "batchnumber");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$rowCount, "rate");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$rowCount, "physical quantity");

	

	$rowCount++;

	/* 
	$generic_cond = "";
	if($producttype == "")

	{

		$where_cond = "";

	}

	if($producttype !="")

	{

		$where_cond = " AND c.type like '".$producttype."' ";

	}

	$category_cond ="";
	if($category !="" && $category !="Select Category")
	{
		$category_cond = " AND c.categoryname ='".$category."' ";
	}
	
	$prod_id ="";
	if($res_prod_id !="" && $res_prod_id !="Select Product Type")
	{
		$prod_id = " AND c.producttypeid ='".$res_prod_id."' ";
	}

	if($genericname !="" && $genericname !="Select Generic Name")
	{
		$generic_cond = " AND c.genericname ='".$genericname."' ";
	}
		$query01="select * from (select a.auto_number as auto_number,trim(a.itemname) as itemname,a.itemcode as itemcode,sum(a.batch_quantity) as batch_quantity,a.batchnumber as batchnumber,a.rate as rate,c.categoryname as category,c.genericname,  a.locationcode,a.storecode,a.fifo_code,b.expirydate as expirydate,d.name producttype from transaction_stock a left JOIN (select * from (
		select billnumber,itemcode,expirydate,fifo_code from purchase_details where ((not((billnumber like 'GRN-%'))) and (itemcode <> '')) group by itemcode,fifo_code,expirydate
		union all 
		select billnumber,itemcode,expirydate,fifo_code from materialreceiptnote_details where (itemcode <> '') group by itemcode,fifo_code,expirydate
		) as a group by itemcode,fifo_code,expirydate) as b ON a.fifo_code=b.fifo_code left JOIN  master_medicine as c ON (a.itemcode=c.itemcode) left join product_type d ON(c.producttypeid=d.id) where a.storecode='$store' AND a.locationcode='$locationcode'   $where_cond $category_cond $generic_cond $prod_id and a.itemcode <> ''  group by a.batchnumber,b.expirydate,a.itemcode) as final  order by IF(final.itemname RLIKE '^[a-z]', 1, 2), final.itemname";
		 */
		//echo $query01.'<br>';exit;

		$query01="select itemcode,itemname,batchnumber,rate from transaction_stock where locationcode='$locationcode' and storecode='$store' and itemcode <> '' and batchnumber <> '' group by itemcode, batchnumber ";
		
		$run01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);

		while($exec01=mysqli_fetch_array($run01))

		{

			
			$itemname=$exec01['itemname'];

			$itemcode=$exec01['itemcode']; 

			$batchnumber=$exec01['batchnumber'];

			$rate=$exec01['rate'];

			$sno=0;

			$snocount = $snocount + 1;

			//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$rowCount, $snocount);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$rowCount, $storecode);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$rowCount, $itemcode);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$rowCount, $itemname);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$rowCount, $batchnumber);

			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$rowCount, $rate);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$rowCount, '');
			

			$rowCount++;
			
		}

	// }

	

	$objPHPExcel->setActiveSheetIndex(0)->setTitle($storename);

 	$objSheet = $objPHPExcel->getActiveSheet();

	

	//PROTECT THE CELL RANGE

	$objSheet->protectCells('A1:E'.$rowCount, 'MasterData');

	

	// UNPROTECT THE CELL RANGE
/* 
	$objSheet->getColumnDimension('L')->setVisible(true);

	$objSheet->getStyle('L1:L'.$rowCount)

      ->getProtection()

      ->setHidden(PHPExcel_Style_Protection::PROTECTION_PROTECTED);

	

	$objSheet->getStyle('L1:L'.$rowCount)

	  ->getFont()->getColor( )->setRGB('FFFFFF');

    
	$objSheet->getColumnDimension('M')->setVisible(true);

	$objSheet->getStyle('M1:M'.$rowCount)

      ->getProtection()

      ->setHidden(PHPExcel_Style_Protection::PROTECTION_PROTECTED);

	

	$objSheet->getStyle('M1:M'.$rowCount)

	  ->getFont()->getColor( )->setRGB('FFFFFF');
	  

 */

	/*$objSheet->getStyle('A1:I'.$rowCount)

	  ->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);*/

	$objSheet->getStyle('A1:E'.$rowCount)->applyFromArray(

    	array(

        	'borders' => array(

        	    'allborders' => array(

        	        'style' => PHPExcel_Style_Border::BORDER_THIN,

        	        'color' => array('rgb' => '000000')

        	    )

        	)

    	)

	);



	$objSheet->getStyle('F2:F'.$rowCount)->getProtection()

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


    $downloadpath ='stocktaking/'.$storename.'.xls';
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


<?php

ini_set('max_execution_time', '300'); //300 seconds = 5 minutes
session_start();

error_reporting(0);

include ("db/db_connect.php");

include ("includes/loginverify.php");

$updatedatetime = date("Y-m-d H:i:s");

$indiandatetitme = date ("d-m-Y H:i:s");

$dateonly=date("Y-m-d");

$suppdateonly = date("Y-m-d");

$username = $_SESSION['username'];

$ipaddress = $_SERVER['REMOTE_ADDR'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$pagename = 'PURCHASE BILL ENTRY';

$today_date = date("Y-m-d");

$titlestr = 'PURCHASE BILL';



$docno = $_SESSION['docno'];



$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

	

$reslocationname = $res["locationname"];

$res12locationanum = $res["auto_number"];



$query3 = "select * from master_location where locationname='$reslocationname'";

$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

$res3 = mysqli_fetch_array($exec3);

$locationcode = $res3['locationcode'];

$locationname = $res3['locationname'];

$location = $locationcode;


if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

if (isset($_REQUEST["frmflag_upload"])) { $frmflag_upload = $_REQUEST["frmflag_upload"]; } else { $frmflag_upload = ""; }

//$frm1submit1 = $_REQUEST["frm1submit1"];


if ($frmflag_upload == 'frmflag_upload')

{

	
	$locationcode = $_REQUEST['locationcode'];

	$locationname = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_REQUEST['locationname']);

	

	if(!empty($_FILES['upload_file']))

	{

		$inputFileName = $_FILES['upload_file']['tmp_name'];

		//print_r($_FILES['upload_file']);

		include 'phpexcel/Classes/PHPExcel/IOFactory.php';

		try {

    		$inputFileType = PHPExcel_IOFactory::identify($inputFileName);

			$objReader = PHPExcel_IOFactory::createReader($inputFileType);

			$objReader->setReadDataOnly(true);

		    $objPHPExcel = $objReader->load($inputFileName);

		    $objWorksheet = $objPHPExcel->getActiveSheet();
$CurrentWorkSheetIndex = 0;

			

			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
    // echo 'WorkSheet' . $CurrentWorkSheetIndex++ . "\n";

    //echo 'Worksheet number - ', $objPHPExcel->getIndex($worksheet), PHP_EOL;
    $highestRow = $worksheet->getHighestDataRow();
    $highestColumn = $worksheet->getHighestDataColumn();
    $rowData = $worksheet->rangeToArray('A1:' . $highestColumn . 1,
        NULL,
        TRUE,
        FALSE)[0];

    $dep_datecolumn = $rowData[14];
			$depreciate_datearr = explode("Depreciation ",$dep_datecolumn);
			$depdate = $depreciate_datearr[1];
			
			$ledger_sequence_no = 1;

			foreach($rowData as $key=>$value)

			{

			if($rowData[$key] == 'ASSET CATEGORY')

			 $asset_category = $key;

			 if($rowData[$key] == 'DEPARTMENT')

			 $department = $key;

			 if($rowData[$key] == 'UNIT')

			 $unit = $key;

			 if($rowData[$key] == 'ASSET NAMES')

			 $assetname = $key;

			if($rowData[$key] == 'SERIAL NUMBER')

			 $serialnok = $key;

			if($rowData[$key] == 'SUPPLIER')

			 $supplierk = $key;


			if($rowData[$key] == 'ASSET CATEGORY-SECTION')

			 $categorysectionk = $key;


			if($rowData[$key] == 'ASSET ID - FORMER')

			 $assetid_formerk = $key;

			if($rowData[$key] == 'TAG NUMBER - (CURRENT')

			 $assetid = $key;

			
			
			 if($rowData[$key] == 'COST')
			 	$purchasecost  = $key;

			 

			 if($rowData[$key] == 'ACQUISITION DATE')
			 {
			 	$acquisition_date = $key;
			 	
			 }

			   

			if($rowData[$key] == 'LIFE')
			{
				 $life = $key;
				 
			}

			 if($rowData[$key] == 'DEPRECIATION START YEAR')
			 {
			 	$depreciation_start_year  = $key;

			 }
			 	


			  if($rowData[$key] == 'ASSET LEDGER')
			 	$asset_ledgerid  = $key;

			  if($rowData[$key] == 'DEPRECIATION LEDGER')
			 	$depreciation_ledgerid  = $key;

			  if($rowData[$key] == 'ACC. DEP. LEDGER')
			 	$acc_dep_ledgerid  = $key;

			  if($rowData[$key] == 'DEPRECIATION 30/06/19')
			 	$depreciation_amountk  = $key;

			 
			
			}			


   		
			for ($row = 2; $row <= $highestRow; $row++){ 

				
    		//  Read a row of data into an array

    		$rowData = $worksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,

                                    NULL,

                                    TRUE,

                                    FALSE)[0];

			

				//$sno = $rowData[0];				

				$asset_category_name=trim($rowData[$asset_category]);	
				

				$department_name=trim($rowData[$department]);	

			
				$asset_unit=trim($rowData[$unit]);	

				//echo $unit.'<br>';


				$asset_name=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], trim($rowData[$assetname]));

				
				$serialno = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], trim($rowData[$serialnok]));

				$supplier = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], trim($rowData[$supplierk]));

				$section = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], trim($rowData[$categorysectionk]));

				$assetid_former = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], trim($rowData[$assetid_formerk]));

				$asset_id = trim($rowData[$assetid]);

				

				$noofyears = trim($rowData[$life]);

				$asset_ledger_id = trim($rowData[$asset_ledgerid]);

				$depreciation_ledger_id = trim($rowData[$depreciation_ledgerid]);

				$acc_depreciation_ledger_id = trim($rowData[$acc_dep_ledgerid]);

				$costprice = trim($rowData[$purchasecost]);

				//$costprice = str_replace(array( '(', ')' ), '', $costprice);

				$acquisitiondate = trim($rowData[$acquisition_date]);

				$acquisitiondate = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($acquisitiondate));

				$dep_start_year = trim($rowData[$depreciation_start_year]);
				
				$dep_start_year=date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($dep_start_year));
			

				$depreciation_amount = abs(trim($rowData[$depreciation_amountk])); 

				$depreciation_amount = str_replace(',','',$depreciation_amount);
				
$d = date_parse_from_format("Y-m-d", $dep_start_year);


$month = $d["month"];

		$start_year = $d['year'];

$date = strtotime($dep_start_year);

 $mon =  date('M', $date);
 $monthabbr = strtoupper($mon);


 $process_month = $monthabbr.'-'.$start_year;

		
		
		if($month <10)
		{
			$month = "0".$month;
		}
		$start_day = '01';

		

		//$depreciation_start_date = $start_year.'-'.$month.'-'.$start_day;

		$depreciation_start_date = $dep_start_year;


				
				$salvage =0;
				$dep_percent =0;
				$accdepreciationvalue = 0;

				$assetledger = "";
				if($asset_ledger_id !="")
				$assetledger = getLedgerName($asset_ledger_id);
				$depreciation = "";
				if($depreciation_ledger_id!="")
				$depreciation = getLedgerName($depreciation_ledger_id);
				$accdepreciation ="";
				if($acc_depreciation_ledger_id!="")
				$accdepreciation = getLedgerName($acc_depreciation_ledger_id);
				$gainlossledger = "Gain/loss on Disposal of Fixed Assets";
				$gainlossledgercode = "04-1500-1";
			
			if($asset_name!="" )

				{
					
					$error_message ="";
					$error_flag ='0';
					
					$query = "select auto_number from master_assetcategory where category='$asset_category_name' and recordstatus=''";

					$catexec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
					$cat_num_rows = mysqli_num_rows($catexec);

					if($cat_num_rows)
					{
						$category_res = mysqli_fetch_array($catexec);
						$asset_category_id = $category_res['auto_number'];
					
				  	}
				  else
				  {
				  		
				  		
				  	 $query1 = "insert into master_assetcategory (category, ipaddress, recorddate, username,id, salvage,noofyears) 

		values ('$asset_category_name', '$ipaddress', '$updatedatetime', '$username','','$salvage','$noofyears')";

	    mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
									
						$asset_category_id = 		((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);	

				  }



	$query33 = "select asset_id from assets_register where asset_id = '$asset_id'";

	$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));

	$row33 = mysqli_num_rows($exec33);

	if($row33 == 0)

	{ 


		$query32 = "select auto_number from assets_register order by auto_number desc limit 0,1";

	$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res32 = mysqli_fetch_array($exec32);

	$anum = $res32['auto_number'];

	$assetanum = $anum + 1;

		$billnumber = 'FAP-'.$assetanum;

		$query88 = "INSERT INTO assets_register SET `billnumber` = '$billnumber', `itemname` = '$asset_name', `asset_id` = '$asset_id', `asset_category` = '$asset_category_name', `asset_department` = '$department_name', `asset_unit` = '$asset_unit', `asset_period` = '$noofyears', companyanum = '$companyanum',

		`startyear` = '$process_month', asset_class = '$asset_category_name', dep_percent = '$dep_percent', `depreciationledger` = '$depreciation', `depreciationledgercode` = '$depreciation_ledger_id', `accdepreciationledger` = '$accdepreciation',

		`accdepreciationledgercode` = '$acc_depreciation_ledger_id', `accdepreciation` = '$accdepreciationvalue', `rate` = '$costprice', `quantity` = '1', `subtotal` = '$costprice', `totalamount` = '$costprice', `coa` = '$asset_ledger_id', 

		`username` = '$username', `ipaddress` = '$ipaddress', `entrydate` = '$acquisitiondate', `itemtotalquantity` = '1', `typeofpurchase` = 'Manual', `locationcode` = '$locationcode', `location` = '$locationname', `assetledger` = '$assetledger', `assetledgercode` = '$asset_ledger_id', `salvage` = '$salvage', `depreciation_start_month` = '$month', `depreciation_start_year` = '$dep_start_year',`depreciation_start_date` = '$depreciation_start_date', `asset_category_id` = '$asset_category_id', `gainloss_ledger` = '$gainlossledger' , `gainloss_ledger_code` = '$gainlossledgercode', `serial_number` = '$serialno' , `asset_category_section` = '$section' , `assetid_former` = '$assetid_former', `supplier` = '$supplier'";
		//echo '<br>'.$query88.'<br>';
		$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));


		$query881 = "INSERT INTO purchase_details SET `billnumber` = '$billnumber',`itemcode`='$assetid', `itemname` = '$asset_name', companyanum = '$companyanum',

		`rate` = '$costprice', `quantity` = '1', `subtotal` = '$costprice', `totalamount` = '$costprice', `costprice` = '$costprice', `coa` = '$asset_ledger_id', 

		`username` = '$username', `ipaddress` = '$ipaddress', `entrydate` = '$acquisitiondate', `itemtotalquantity` = '1', `typeofpurchase` = 'Manual', `purchasetype` = 'Asset', `totalfxamount` = '$costprice', `fxtotamount` = '$costprice',

		`locationcode` = '$locationcode', `location` = '$locationname', `expense` = '$assetledger', `expensecode` = '$asset_ledger_id', `accdepreciation_ledger` = '$accdepreciation', `accdepreciation_code` = '$acc_depreciation_ledger_id'";

		$exec881 = mysqli_query($GLOBALS["___mysqli_ston"], $query881) or die ("Error in Query881".mysqli_error($GLOBALS["___mysqli_ston"]));

			// Data insertion into assets_depreciation table start
			$depreciation_prefix = "DEP-";

			$query2 = "select * from assets_depreciation order by auto_number desc limit 0, 1";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_fetch_array($exec2);
			$billnumber_new = $res2["doc_number"];
			if ($billnumber_new == '')
			{
			$billnumbercode =$depreciation_prefix.'1';
			
			}
			else
			{
			$billnumber_new = $res2["doc_number"];
			$billnumbercode = substr($billnumber_new, 4, 8);
			$billnumbercode = intval($billnumbercode);
			$billnumbercode = $billnumbercode + 1;
			$maxanum = $billnumbercode;


			$billnumbercode = $depreciation_prefix.$maxanum;
			
			}
			$depreciation_done_date = "2019-06-30";
					$processmonth = "Jun-2019";
				$query66 = "SELECT auto_number FROM assets_depreciation WHERE asset_id = '$asset_id' AND processmonth = '$processmonth'";

				$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));

				$row66 = mysqli_num_rows($exec66);

				if($row66 == 0)

				{

					

					 $query34 = "select * from assets_register where asset_id = '$asset_id'";

					
					   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

					   $asset_num = mysqli_num_rows($exec34);

					  
					   $res34 = mysqli_fetch_array($exec34);

					   $itemname = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $res34['itemname']);

					   $itemcode = $res34['itemcode'];

					   $totalamount = $res34['totalamount'];

					   $entrydate = $res34['entrydate'];

					   $suppliercode = $res34['suppliercode'];

					   $suppliername = $res34['suppliername'];

					   $anum = $res34['auto_number'];

					   $asset_id = $res34['asset_id'];

						$asset_category1 = $res34['asset_category'];

						$asset_class = $res34['asset_class'];

						$asset_department = $res34['asset_department'];

						$asset_unit = $res34['asset_unit'];

						$asset_period = $res34['asset_period'];

						$startyear = $res34['startyear'];

						$billnumber = $res34['billnumber'];

						$companyanum =  $res34['companyanum'];

						$bill_autonumber = $res34['bill_autonumber'];

						$itemanum = $res34['itemanum'];

						$itemdescription = $res34['itemdescription'];

						$unit_abbreviation = $res34['unit_abbreviation'];

						$rate = $res34['rate'];

						$quantity = $res34['quantity'];

						$subtotal = $res34['subtotal'];

						$free = $res34['free'];

						$itemtaxpercentage = $res34['itemtaxpercentage'];

						$itemtaxamount = $res34['itemtaxamount'];

						$closingstock = $res34['closingstock'];

						$coa = $res34['coa'];

						$coa = $res34['coa'];
						$discountamount = $res34['discountamount'];
						$recordstatus = $res34['recordstatus'];
						$username = $res34['username'];
						$ipaddress = $res34['ipaddress'];
						$entrydate = $res34['entrydate'];
						$batchnumber = $res34['batchnumber'];
						$costprice = $res34['costprice'];
						$salesprice = $res34['salesprice'];
						$expirydate = $res34['expirydate'];
						$itemfreequantity = $res34['itemfreequantity'];
						$itemtotalquantity = $res34['itemtotalquantity'];
						$packageanum = $res34['packageanum'];
						$packagename = $res34['packagename'];
						$quantityperpackage = $res34['quantityperpackage'];
						$allpackagetotalquantity = $res34['allpackagetotalquantity'];
						$manufactureranum = $res34['manufactureranum'];
						$manufacturername = $res34['manufacturername'];
						$suppliername = $res34['suppliername'];
						$suppliercode = $res34['suppliercode'];
						$supplieranum = $res34['supplieranum'];
						$supplierbillnumber = $res34['supplierbillnumber'];

						$typeofpurchase = $res34['typeofpurchase'];
						$ponumber = $res34['ponumber'];
						$itemstatus = $res34['itemstatus'];
						$locationcode = $res34['locationcode'];
						$store = $res34['store'];
						$location = $res34['location'];
						$fifo_code = $res34['fifo_code'];
						$currency = $res34['currency'];
						$fxrate = $res34['fxrate'];
						$totalfxamount = $res34['totalfxamount'];
						$deliverybillno = $res34['deliverybillno'];
						$mrnno = $res34['mrnno'];
						$fxpkrate = $res34['fxpkrate'];
						$fxtotamount = $res34['fxtotamount'];
						$assetledger = $res34['assetledger'];
						$assetledgercode = $res34['assetledgercode'];
						$assetledgeranum = $res34['assetledgeranum'];
						$priceperpk = $res34['priceperpk'];
						$fxamount = $res34['fxamount'];
						
						$dep_percent = $res34['dep_percent'];
						$asset_department = $res34['asset_department'];
						$depreciationledger = $res34['depreciationledger'];
						$depreciationledgercode = $res34['depreciationledgercode'];

						$accdepreciationledger = $res34['accdepreciationledger'];
						$accdepreciationledgercode = $res34['accdepreciationledgercode'];
						$accdepreciation = $res34['accdepreciation'];

						$openingstock = $res34['openingstock'];
						$closingstock = $res34['closingstock'];
					



					$query78 = "INSERT INTO `assets_depreciation`(`bill_autonumber`,`doc_number`, `companyanum`, `billnumber`, `categoryname`, `itemanum`, `itemcode`, `itemname`, `itemdescription`,

					`unit_abbreviation`, `rate`, `quantity`, `subtotal`, `free`, `itemtaxpercentage`, `itemtaxamount`, `discountpercentage`, `discountrupees`, `openingstock`, 

					`closingstock`, `totalamount`, `coa`, `discountamount`, `recordstatus`, `username`, `ipaddress`, `entrydate`, `batchnumber`, `costprice`, `salesprice`, 

					`expirydate`, `itemfreequantity`, `itemtotalquantity`, `packageanum`, `packagename`, `quantityperpackage`, `allpackagetotalquantity`, `manufactureranum`, 

					`manufacturername`, `suppliername`, `suppliercode`, `supplieranum`, `supplierbillnumber`, `typeofpurchase`, `ponumber`, `itemstatus`, `locationcode`, `store`, 

					`location`, `fifo_code`, `currency`, `fxrate`, `totalfxamount`, `deliverybillno`, `mrnno`, `fxpkrate`, `fxtotamount`, `assetledger`, `assetledgercode`, 

					`assetledgeranum`, `priceperpk`, `fxamount`, `asset_id`, `asset_class`, `asset_category`, `dep_percent`, `asset_department`, `asset_unit`, `asset_period`, 

					`startyear`, `depreciationledger`, `depreciationledgercode`, `accdepreciationledger`, `accdepreciationledgercode`, `accdepreciation`,`depreciation`,`processmonth`,`depreciation_date`) 

					VALUES ('$bill_autonumber', '$billnumbercode', '$companyanum', '$billnumber','$asset_category1','$itemanum','$itemcode','$itemname','$itemdescription','$unit_abbreviation','$rate','$quantity','$subtotal','$free','$itemtaxpercentage','$itemtaxamount','$discountpercentage','$discountrupees','$openingstock','$closingstock','$totalamount','$coa','$discountamount','$recordstatus','$username','$ipaddress','$updatedatetime','$batchnumber','$costprice','$salesprice','$expirydate','$itemfreequantity','$itemtotalquantity','$packageanum','$packagename','$quantityperpackage','$allpackagetotalquantity','$manufactureranum','$manufacturername','$suppliername','$suppliercode','$supplieranum','$supplierbillnumber','$typeofpurchase','$ponumber','$itemstatus','$locationcode','$store','$location','$fifo_code','$currency','$fxrate','$totalfxamount','$deliverybillno','$mrnno','$fxpkrate','$fxtotamount','$assetledger','$assetledgercode','$assetledgeranum','$priceperpk','$fxamount','$asset_id','$asset_class','$asset_category1','$dep_percent','$asset_department','$asset_unit','$asset_period','$startyear','$depreciationledger','$depreciationledgercode','$accdepreciationledger','$accdepreciationledgercode','$depreciation_amount','$depreciation_amount','$processmonth','$depreciation_done_date')";


					

					$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die ("Error in Query78".mysqli_error($GLOBALS["___mysqli_ston"]));


					$query66 ="DELETE FROM tb WHERE doc_number like 'FAP-%' and transaction_date = '".$today_date."' and from_table='purchase_details' ";

					$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					
					

				}

		//$assetanum = mysql_insert_id();
		
	}
				  
				
				 
				
											
					
				   


				}
				

   				 
				
			}


		}

	 } catch(Exception $e) {

			 die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());

	 }

			

			//print_r($objPHPExcel);
			
			

		}

	

	header("location:fixedasset_upload.php?st=success");

}





if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$st = $_REQUEST["st"];

if (isset($_REQUEST["banum"])) { $banum = $_REQUEST["banum"]; } else { $banum = ""; }

//$banum = $_REQUEST["banum"];
$errmsg = "";
if ($st == 'success')

{

	$errmsg = "The data has been imported Successfully.";

	$bgcolorcode = 'success';

}

if ($st == '2')

{

	$errmsg = "Failed. New Bill Cannot Be Completed.";

	$bgcolorcode = 'failed';

}

if ($st == '1' && $banum != '')

{

	$loadprintpage = 'onLoad="javascript:loadprintpage1()"';

}

?>

<?php include ("includes/pagetitle1.php"); ?>

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

-->

</style>



<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/disablebackenterkey.js"></script>







<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.style1 {

	font-size: 36px;

	font-weight: bold;

}

.style2 {

	font-size: 18px;

	font-weight: bold;

}

.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }

.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

.style8 {COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none; font-size: 11px;}

-->

</style>

</head>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        



<script src="js/datetimepicker_css.js"></script>

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js" type="text/javascript"></script>

<link href="js/jquery-ui.css" rel="stylesheet">

<script src="js/datetimepicker_css.js"></script>

<script type="text/javascript" src="js/jquery-1.11.1.js"></script>

<script type="text/javascript">

function Calc(id)

{		
	
	var Total1 = "0.00";

	var idsplit = id.split('|');

	var Year = document.getElementById('byear').value;

	var Anum = idsplit[1];

	var IYear = parseFloat(Year) - 1;

	var amt2total = 0;

	//alert(Anum+'---'+IYear);

	if(document.getElementById(id)!=null)

	{	

		var Percent = document.getElementById(id).value;

		if(Percent == '') { Percent = "0.00"; }

		var LAmount = document.getElementById('L|'+IYear+'|'+Anum).value;

		LAmount=LAmount.replace(/,/g,'');

		var Calcamt = parseFloat(LAmount) * (parseFloat(Percent) / 100);

		var Final = parseFloat(LAmount) + parseFloat(Calcamt);

		Final = parseFloat(Final).toFixed(2);

		Finaltot = parseFloat(Final).toFixed(2);

		Final = Final.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

		document.getElementById('LV|'+Anum).value = Final;

	}

	for(var i=0;i<=1000;i++)

	{

		if(document.getElementById('LV|'+i)!=null)

		{

			var Total2 = document.getElementById('LV|'+i).value;

			Total2=Total2.replace(/,/g,'');

			Total1=Total1.replace(/,/g,'');

			var Total1 = parseFloat(Total1) + parseFloat(Total2);

			Total1 = parseFloat(Total1).toFixed(2);

			Total1 = Total1.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

			if(document.getElementById('total')!=null)

			{

			document.getElementById('total').value = Total1;

			}

		}

	}

	
	
	var clssattr = document.getElementById(id).getAttribute("cval");
	

	var cvalstr = clssattr.split('_');

	var cval = cvalstr[0];

	$('.hasamt2_'+cval).find("input:text").each(function() {

 	 		
		var thisval = this.value.replace(/,/g,'');

         amt2total = parseFloat(amt2total) + parseFloat(thisval);  
         
         

    });	
	
    var amt2total_new = amt2total.toFixed(2);

    var amt2total_final = amt2total_new.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

	$('#amt2total_'+cval).text(amt2total_final);

}



function Process1()

{

	if(document.getElementById('budgetname').value == "")

	{

		alert("Enter Budget Name");

		document.getElementById('budgetname').focus();

		return false;

	}

}

$(document).ready(function(){



	

	var i=0;

	var j=0;

	

		$( ".parentPercent" ).keyup(function(e) {



			var amt1total = 0;

			var amt2total = 0;

 	 		

 	 		var This_id = $(this).attr("id");

 	 		

 	 		var idsplit = This_id.split('_');

			var id = idsplit[1];

			

 	 		var percent = $(this).val();

 	 		$('.has_'+id).find("input:text").each(function() {

 	 		

	            //inputName = $(this).attr("name");



	            $(this).val(percent);

	            $(this).keyup();

            

        	});



 	 		$('.hasamt2_'+id).find("input:text").each(function() {

 	 		

	            //inputName = $(this).attr("name");

	            amt2total = parseFloat(amt2total) + parseFloat(this.value);

        	});



 	 		var amt2totalfinal = amt2total.toFixed(2); 

 	 		var amt2totalfinal = amt2totalfinal.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

        	$('#amt2total_'+id).text(amt2totalfinal);



        	var LVtotal = 0;

        	for(var i=0;i<=1000;i++)

			{

				if(document.getElementById('LV|'+i)!=null)

				{

					var lvvalue = document.getElementById('LV|'+i).value;

					

					LVtotal = parseFloat(LVtotal) + parseFloat(lvvalue);

					

				}

			}

			var LVfinal = LVtotal.toFixed(2);

			var LVfinal = LVfinal.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

			$('#total').val(LVfinal);	



			var ledgertotal = 0;

			

			

		});



		

})

function budgetcheck()

{

var location = document.getElementById("location").value;
if(location=="")

	{

		alert("Please select location name");

		
		return false;

	}

	var byear =  document.getElementById("byear").value;

	if(byear=="")

	{

		alert("Please select budget year");

		

		return false;

	}
	

	

	
	window.open("budgetentrycc_csv1.php?frmflag34=frmflag34&&location="+location+"&&byear="+byear, "_blank");

	return true;

	

}
function validcheck()

{

	if (document.getElementById('upload_file').value == '') 

	{

		 alert('Select CSV file to Upload');

		 return false;

	} 

	

	var alert1;
    alert1 = confirm('Are you sure, Do you want to Save Data?');
    //alert(fRet);
    if (alert1 === true)
    {
        FuncPopup();
            document.cbform1.submit();
    }
    if (alert1 === false)
    {
        // alert ("Sub Type Entry Delete Not Completed.");
        return false;
    }
	//if(confirm("Are You Want To Save The Record?")==false){return false;}

}


function FuncPopup()
{
    window.scrollTo(0,0);
    document.getElementById("imgloader").style.display = "";
    // display.time(0,30);

}
function acknowledgevalid()
{
   var alert1;
    alert1 = confirm('Are you sure! want to Save Data?');
    //alert(fRet);
    if (alert1 == true)
    {
        FuncPopup();
            document.form1.submit();
    }
    if (alert1 == false)
    {
        // alert ("Sub Type Entry Delete Not Completed.");
        return false;
    }
}
</script>
<style type="text/css">
.imgloader { background-color:#FFFFFF; }
#imgloader1 {
    position: absolute;
    top: 158px;
    left: 487px;
    width: 28%;
    height: 25%;
}
</style>
<body>
<div align="center" class="imgloader" id="imgloader" style="display:none;">
    <div align="center" class="imgloader" id="imgloader1" style="display:;">
        <p style="text-align:center;"><strong>Processing <br><br> Please be Patient...</strong></p>
        <img src="images/ajaxloader.gif">
    </div>
</div>


<table width="101%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>

  </tr>

<tr>

    <td colspan="9" bgcolor="#ecf0f5">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="99%" valign="top"><table width="1214" border="0" cellspacing="0" cellpadding="0">

    	<tr>
      	<td width="" class="bodytext3" align="left"><strong><?php echo $errmsg;?></strong></td>
       

		</tr>
		<?php  if($errmsg !=""){?>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
	<?php } ?>
      <tr>
      	
       <td width="" class="bodytext3" align="left"><strong>Asset Entry Bulk Upload</strong></td>

		</tr>


		</table>

	</td>

		</tr>

		

		


      <form name="cbform1" method="post" action="fixedasset_upload.php" enctype="multipart/form-data" onSubmit="return validcheck()">	

        <?php

				if (isset($_REQUEST["cbfrmflag12"])) { $cbfrmflag12 = $_REQUEST["cbfrmflag12"]; } else { $cbfrmflag12 = ""; }

				

				//if ($cbfrmflag12 == 'cbfrmflag12')

				//{

						 /*$locationcode = $_REQUEST['location'];

					     $storecode = $_REQUEST['store']; */

					?>

      <tr>
<td></td>
        <td><table id="AutoNumber4" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="1" width="567" 

            align="left" border="0">

          <tbody >

            <tr>

			<td colspan="3">&nbsp;</td>

			</tr>

			<tr>

			<td width="102">&nbsp;</td>

			<td width="643" colspan="2" align="left" class="bodytext3">

			<strong>Upload CSV File </strong>			</td>

			</tr>

			<tr>

			<td>&nbsp;</td>

			<td colspan="2"><input type="file" name="upload_file" id="upload_file"></td>

			</tr>

			<tr>

			<td>&nbsp;</td>

			<td colspan="2">

			<input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode; ?>">

			<input type="hidden" name="frmflag_upload" id="frmflag_upload" value="frmflag_upload">

			<input type="submit" name="frmsubmit1" value="Upload Excel">

			</td>

			</tr>

          </tbody>

        </table></td>

      </tr>

      

	  </form>



<?php include ("includes/footer1.php"); ?>

<?php

function ledgervalue($parentid,$ADate1,$ADate2)

{

$orderid1 = '';

$lid = '';

$colorloopcount = '';

$totalamount12 = "0.00";

$sumopeningbalance = "0.00";

$sumbalance = '0.00';



if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }

	

	$query92 = "select * from master_accountname where auto_number = '$parentid'";

	$exec92 = mysqli_query($GLOBALS["___mysqli_ston"], $query92) or die ("Error in Query92".mysqli_error($GLOBALS["___mysqli_ston"]));

	$num92 = mysqli_num_rows($exec92);

	while($res92 = mysqli_fetch_array($exec92))

	{  

		$accountsmain2 = $res92['accountname'];

		$orderid1 = $orderid1 + 1;

		$parentid2 = $res92['auto_number'];

		$ledgeranum = $parentid2;

		$id2 = $res92['id'];

		$lid = $lid + 1;

		$ledgerid = $id2;

		$group = $res92['accountssub'];

		

		include('include_ledgervalue.php');

		

		$sumbalance = $sumbalance + $balance;

		

		$colorloopcount = $colorloopcount + 1;

		$showcolor = ($colorloopcount & 1); 

		if ($showcolor == 0)

		{

			//echo "if";

			$colorcode = 'bgcolor="#CBDBFA"';

		}

		else

		{

			//echo "else";

			$colorcode = 'bgcolor="#ecf0f5"';

		}

		

	}

	

	return $sumbalance;

}
function getledgervalue($ledgercode,$startdate,$enddate)
{
 	
    $amt = array();
 	$credit_amount = 0;
	$debit_amount = 0;

	$query3 = "select sum(transaction_amount) as transaction_amount,transaction_type from tb where ledger_id='$ledgercode' and transaction_date between  '$startdate' and '$enddate' group by transaction_type";
	//echo $query3.'<br>';
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

    while($res3 = mysqli_fetch_array($exec3))
	{
		//var_dump($res2);
		$totc = $res2["transaction_date"];
		$transaction_type = $res3['transaction_type'];
		
		if($transaction_type == 'C'){
			$credit_amount = $res3['transaction_amount'];
			
		}else{
			$debit_amount = $res3['transaction_amount'];
			
		}

	}
	$ledgerval = $credit_amount - $debit_amount;

	return $ledgerval;
				
}
function getLedgerName($ledgercode)
{

	$accountname = "";
	$query61 = "select accountname from master_accountname where id= '$ledgercode'";

$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query61".mysqli_error($GLOBALS["___mysqli_ston"]));

$res61 = mysqli_fetch_array($exec61);

$accountname = $res61['accountname'];
return $accountname;

}
?>





</body>

</html>
<?php
session_start();
set_time_limit(0);
//include ("includes/loginverify.php");
include ("db/db_connect.php");
include 'phpexcel/Classes/PHPExcel/IOFactory.php';
$username='admin';
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
try {
	$inputFileName = 'master_medicine.xlsx';
	$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
	$objReader = PHPExcel_IOFactory::createReader($inputFileType);
	$objPHPExcel = $objReader->load($inputFileName);
	$sheet = $objPHPExcel->getSheet(0); 
	$highestRow = $sheet->getHighestRow();
	$highestColumn = $sheet->getHighestColumn();
	$row = 1;
	$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
							NULL,
							TRUE,
							FALSE)[0];

	foreach($rowData as $key=>$value)
	{
		if($rowData[$key] == 'Item Code')
		 $code = $key;
		if($rowData[$key] == 'Item Name')
		 $name = $key;
		if($rowData[$key] == 'Generic Name')
		 $generic = $key;
		if($rowData[$key] == 'category')
		 $cate = $key;
		if($rowData[$key] == 'Purchase Type')
		 $purchasetype = $key;
		
		if($rowData[$key] == 'Pack Size')
		 $pack = $key;
		if($rowData[$key] == 'Buying Price')
		 $buy = $key;
		if($rowData[$key] == 'Selling Price')
		 $rate = $key;
		if($rowData[$key] == 'Fomula')
		 $formulas = $key;
		if($rowData[$key] == 'Volume')
		 $vol = $key;
		if($rowData[$key] == 'Minimum Stock')
		 $min = $key;
		if($rowData[$key] == 'Maximum Stock')
		 $max = $key;
		if($rowData[$key] == 'Re-order Level')
		 $rol = $key;
		if($rowData[$key] == 'transfer type')
		 $transType = $key;

		if($rowData[$key] == 'Income Ledger Name')
		 $incomename = $key;
		if($rowData[$key] == 'Income Ledger Code')
		 $incomecode = $key;
		if($rowData[$key] == 'COS Ledger Name')
		 $cogsname = $key;
		if($rowData[$key] == 'Cost of Sales Ledger Code')
		 $cogscode = $key;
		if($rowData[$key] == 'Inventory Ledger Name')
		 $invledname = $key;
		if($rowData[$key] == 'Inventory Ledger Code')
		 $invledcode = $key;
	    if($rowData[$key] == 'Nature of Item/Category')
		 $producttypes = $key;

		if($rowData[$key] == 'Expense Ledger name')
		 $expname = $key;
		if($rowData[$key] == 'Expense Ledger code')
		 $expcode = $key;

		if($rowData[$key] == 'MED360')
		 $mcode = $key;

	}			
	for ($row = 2; $row <= $highestRow; $row++){ 

	$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
							NULL,
							TRUE,
							FALSE)[0];

	
		//$sno = $rowData[0];				
		$itemcode=str_replace("-","",$rowData[$code]);	
		$itemname=$rowData[$name];
		$categoryname=$rowData[$cate];
		$res4packagename=$rowData[$pack];
		$rateperunit=$rowData[$rate];
		$type=$rowData[$purchasetype];
		$description='';
		$purchaseprice=$rowData[$buy];
		$pkg='';
		$genericname=$rowData[$generic];
		$exclude ='';
		$minimumstock=$rowData[$min];
		$maximumstock=$rowData[$max];
		$rol=$rowData[12];
		$roq=$rowData[$vol];
		$ipmarkup='';
		$spmarkup='';
		$formula= $rowData[$formulas];
		$disease='';
		$transfertype=$rowData[13];
		$incomeledgername=$rowData[$incomename];
		$incomeledgercode=$rowData[$incomecode];

		$ledgername=$rowData[$cogsname];
		$ledgercode=$rowData[$cogscode];

		$inventoryledgercode=$rowData[$invledcode];
		$inventoryledgername=$rowData[$invledname];
		$producttypes2=$rowData[$producttypes];

		$expledgercode=$rowData[$expcode];
		$expledgername=$rowData[$expname];

		$mcodes=$rowData[$mcode];

         $query2 = "select * from master_medicine where itemcode = '$mcodes' and status!='deleted'";// or itemname = '$itemname'";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_num_rows($exec2);
		if ($res2 == 0)
		{
		
		$query = "select id,name from product_type where name ='$producttypes2'";
		$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res = mysqli_fetch_array($exec);
		$producttype = $res["id"]; 

		$query1 = "insert into master_medicine (itemcode, itemname, categoryname, unitname_abbreviation,packagename,rateperunit, expiryperiod, taxanum, taxname, ipaddress, updatetime, description, purchaseprice,pkg,genericname,exclude,minimumstock,maximumstock,rol,roq,ipmarkup,spmarkup,formula,disease,type,producttypeid,ledgername,ledgercode,ledgerautonumber,transfertype,nature,incomeledgercode,incomeledger,inventoryledgercode,inventoryledgername,expenseledgercode,expenseledgername,legacy_code) 
			values ('$mcodes', '$itemname', '$categoryname', '$res4packagename','$res4packagename', '$rateperunit', '0', '', '', '$ipaddress', '$updatedatetime','$description', '$purchaseprice','$pkg','$genericname','','$minimumstock','$maximumstock','$rol','$roq','$ipmarkup','$spmarkup','$formula','$disease','$type','$producttype','$ledgername','$ledgercode','','$transfertype','','$incomeledgercode','$incomeledgername','$inventoryledgercode','$inventoryledgername','$expledgercode','$expledgername','$itemcode')";

		

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$fields = array();
			$queryChk = "SHOW COLUMNS FROM master_medicine";
			$execchk = mysqli_query($GLOBALS["___mysqli_ston"], $queryChk) or die ("Error in queryChk".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($x = mysqli_fetch_assoc($execchk)){

				  if (stripos($x['Field'], "subtype_") !== false) {
					    $fieldname=$x['Field'];
						$query1 = "update master_medicine set $fieldname='$rateperunit' where itemcode='$mcodes'";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				  }
				  
			}
	
	       $query2 = "insert into master_itempharmacy (itemcode, itemname, categoryname, unitname_abbreviation, packagename,rateperunit, expiryperiod, taxanum, taxname, ipaddress, updatetime, description, purchaseprice, pkg, genericname,exclude,minimumstock,maximumstock,rol,roq,ipmarkup,spmarkup,formula,disease,type,producttypeid,ledgername,ledgercode,ledgerautonumber,transfertype,nature,incomeledgercode,incomeledger,inventoryledgercode,inventoryledgername,expenseledgercode,expenseledgername) 
			values ('$mcodes', '$itemname', '$categoryname', '$res4packagename','$res4packagename', '$rateperunit', '0', '', '', '$ipaddress', '$updatedatetime','$description', '$purchaseprice','$pkg','$genericname','$exclude','$minimumstock','$maximumstock','$rol','$roq','$ipmarkup','$spmarkup','$formula','$disease','$type','$producttype','$ledgername','$ledgercode','','$transfertype','','$incomeledgercode','$incomeledgername','$inventoryledgercode','$inventoryledgername','$expledgercode','$expledgername')";

		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
 
		
	}
		

	} catch(Exception $e) {
	 die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
	}
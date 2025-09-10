<?php
session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
 $username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$docno = $_SESSION['docno'];
$updatetime = date('H:i:s');
$updatedate = date('Y-m-d H:i:s');

 
$query233 = "select locationcode from master_location where username='$username'";
$exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die ("Error in query233".mysqli_error($GLOBALS["___mysqli_ston"]));

$res233 = mysqli_fetch_array($exec233);
$location=$locationcode = $res233['locationcode'];

$location=$locationcode = "LTC-1";

$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'OPS-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from openingstock_entry order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='OPS-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billnumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'OPS-'.$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
	

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if ($cbfrmflag1 == 'cbfrmflag1')
{
  $billnumber=$billnumbercode;
 // $serial = $_REQUEST['serialnumber'];

if(!empty($_FILES['upload_file']))
{
	//$store = 'STO1';
	//$number = $serial - 1;
	$inputFileName = $_FILES['upload_file']['tmp_name'];

	//print_r($_FILES['upload_file']);

	include 'phpexcel/Classes/PHPExcel/IOFactory.php';

	try {

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
			 $itemcodenm = $key;

			 if($rowData[$key] == 'Item Name')
			 $itemnamenm = $key;

			 if($rowData[$key] == 'Rate')
			 $ratenm = $key;

			 if($rowData[$key] == 'Exp Date')
			 $expirynm = $key;

			 if($rowData[$key] == 'Batch')
			 $batchnm = $key;

			 if($rowData[$key] == 'Phy Qty')
			 $quantitynm = $key;

			 if($rowData[$key] == 'Store Code')
			 $storecodenm = $key;

			 	
			 

			}			

			for ($row = 2; $row <= $highestRow; $row++){ 

    		//  Read a row of data into an array

    		$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,

                                    NULL,

                                    TRUE,

                                    FALSE)[0];
			
		
		 $store=$rowData[$storecodenm];	

		 $medicinecode=$rowData[$itemcodenm];	

		 $quantity=$rowData[$quantitynm];	

		 $batch=$rowData[$batchnm];	
		 $batch=str_replace("'","",$batch);

		 $salesrate=$rowData[$ratenm];
		 $salesrate=str_replace(",","",$salesrate);

		 $expirydate=$rowData[$expirynm];
	     // $expirydate=date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($expirydate));
		
			$query23 = "select * from master_itempharmacy where itemcode = '$medicinecode' and status!='deleted'";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in query23".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res23 = mysqli_fetch_array($exec23);
			$categoryname = $res23['categoryname'];
			//$salesrate= $res23['purchaseprice'];
			$medicinename=$res23['itemname'];
		
		//echo $medicinecode;
		
		
/*		$expirymonth = substr($expirydate, 0, 2);
			$expiryyear = substr($expirydate, 3, 2);
			$expiryday = '01';
			$expirydate = $expiryyear.'-'.$expirymonth.'-'.$expiryday;
*/

		$itemsubtotal=$salesrate * $quantity;
		
		
		if($medicinename!="")
		{
			
				
			$querystock2 = "select fifo_code from transaction_stock where docstatus='New Batch' order by auto_number desc limit 0, 1";
			$execstock2 =mysqli_query($GLOBALS["___mysqli_ston"], $querystock2) or die ("Error in querystock2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resstock2 = mysqli_fetch_array($execstock2);
			$fifo_code = $resstock2["fifo_code"];
			if ($fifo_code == '')
			{		
				$fifo_code = '1';
				$querycumstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$medicinecode' and locationcode='$locationcode'";
				$execcumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querycumstock2) or die ("Error in querycumstock2".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,
				batchnumber, batch_quantity, 
				transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice)
				values ('1','purchase_details','$medicinecode', '$medicinename', '$updatedatetime','1', 'OPENINGSTOCK', 
				'$batch', '$quantity', '$quantity', 
				'$quantity', '$billnumber', 'New Batch','1','1', '$locationcode','','$store', '', '$username', '$ipaddress','$updatedatetime','$updatetime','$updatedate','$salesrate','$itemsubtotal')";
				$stockexecquery2=mysqli_query($GLOBALS["___mysqli_ston"], $stockquery2) or die ("Error in stockquery2".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				else
				{
				$querycumstock2 = "select sum(batch_quantity) as cum_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$medicinecode' and locationcode='$locationcode'";
				$execcumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querycumstock2) or die ("Error in querycumstock2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$rescumstock2 = mysqli_fetch_array($execcumstock2);
				$cum_quantity = $rescumstock2["cum_quantity"];
				$cum_quantity = $quantity+$cum_quantity;
				$fifo_code = $fifo_code + 1;				
				$queryupdatecumstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$medicinecode' and locationcode='$locationcode'";
				$execupdatecumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatecumstock2) or die ("Error in queryupdatecumstock2".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,
				batchnumber, batch_quantity, 
				transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice)
				values ('$fifo_code','purchase_details','$medicinecode', '$medicinename', '$updatedatetime','1', 'OPENINGSTOCK', 
				'$batch', '$quantity', '$quantity', 
				'$cum_quantity', '$billnumber', 'New Batch','1','1', '$locationcode','','$store', '', '$username', '$ipaddress','$updatedatetime','$updatetime','$updatedate','$salesrate','$itemsubtotal')";
				
				$stockexecquery2=mysqli_query($GLOBALS["___mysqli_ston"], $stockquery2) or die ("Error in stockquery2".mysqli_error($GLOBALS["___mysqli_ston"]));			
			}
			$medicinequery1="insert into purchase_details (itemcode, itemname, entrydate,suppliername,suppliercode,
			quantity,allpackagetotalquantity,totalamount,
			username, ipaddress, rate, subtotal, companyanum,batchnumber,expirydate,location, locationcode,store,billnumber,categoryname,fifo_code,costprice)
			values ('$medicinecode', '$medicinename', '$updatedatetime', 'OPENINGSTOCK','OPSE-1',
			'$quantity','$quantity','$itemsubtotal',
			'$username', '$ipaddress', '$salesrate','$itemsubtotal','$companyanum','$batch','$expirydate','$location','$locationcode','$store','$billnumber','$categoryname','$fifo_code','$salesrate')"; 
			
			$execquery1=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery1) or die ("Error in medicinequery1".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$medicinequery2="insert into openingstock_entry (itemcode, itemname, transactiondate,transactionmodule,transactionparticular,
			billnumber, quantity, 
			username, ipaddress, rateperunit, totalrate, companyanum, companyname,batchnumber,expirydate,store,location)
			values ('$medicinecode', '$medicinename', '$updatedatetime', 'OPENINGSTOCK', 
			'BY STOCK ADD', '$billnumber', '$quantity', 
			'$username', '$ipaddress', '$salesrate','$itemsubtotal','$companyanum', '$companyname','$batch','$expirydate', '$store', '$location')";
			
			$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die ("Error in medicinequery2".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			}
			else
				echo ','.$medicinecode;
			}
		} catch(Exception $e) {

			 die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());

			}
}
}



?>

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none

}

-->

</style>

<script>
function validcheck()
{

	if (document.getElementById('upload_file').value == '') 

	{

		 alert('Select CSV file to Upload');

		 return false;

	} 

	if(confirm("Are You Want To Save The Record?")==false){return false;}	

}

</script>

</head>



<body>

<table width="101%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td   bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>

  </tr>
  <tr>

    <td   bgcolor="#ecf0f5">&nbsp;</td>

  </tr>

  <tr>
    <td colspan="10">
	<table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tr bgcolor="#011E6A">

              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong> Upload Opening Stocks </strong></td>
			  </tr>

	<form action="update_openingstock.php" method='post' enctype="multipart/form-data" onSubmit="return validcheck()">
	<tr >
	  <td  align="left" class="bodytext3"> <strong>Upload CSV File </strong>			</td>
	   <td colspan="2"><input type="file" name="upload_file" id="upload_file"></td>
	 </td>

	</tr>

	<input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
	<tr><td colspan='3'><input type="submit" name="submit"></td></tr>
	</form>
	</table>
	</td>
</tr>
 </table>

  <?php 

  //}

  ?>

<?php include ("includes/footer1.php"); ?>
</body>

</html>



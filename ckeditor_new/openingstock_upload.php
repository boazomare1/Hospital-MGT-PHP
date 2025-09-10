<?php

session_start();

include ("includes/loginverify.php"); 

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$updatetime = date('H:i:s');

$colorloopcount = '';

$updatedate = date('Y-m-d H:i:s');

$sno = '';

$snocount = '';


$errmsg = '';

$bgcolorcode = '';


$docno = $_SESSION['docno'];

$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

	

	 $locationname  = $res["locationname"];

	 $locationcode = $res["locationcode"];

	 $res12locationanum = $res["auto_number"];

	 $locationcode_new = $locationcode;

  $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';

  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

  

function readCSV($csvFile){

    $file_handle = fopen($csvFile, 'r');

    while (!feof($file_handle) ) {

        $line_of_text[] = fgetcsv($file_handle, 1024);

    }

    fclose($file_handle);

    return $line_of_text;

}

    

if (isset($_REQUEST["frmflag_upload"])) { $frmflag_upload = $_REQUEST["frmflag_upload"]; } else { $frmflag_upload = ""; }

if ($frmflag_upload == 'frmflag_upload')

{	

$query3 = "select * from master_company where companystatus = 'Active'";

			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res3 = mysqli_fetch_array($exec3);

			$paynowbillprefix = 'OPS-';

			$paynowbillprefix1=strlen($paynowbillprefix);

			

			$query22 = "select * from openingstock_entry order by auto_number desc limit 0, 1";

			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res22 = mysqli_fetch_array($exec22);

			$billnumber = $res22["billnumber"];

			$billdigit=strlen($billnumber);

				

				if ($billnumber == '')

				{

				$billnumbercode ='OPS-'.'1';

				$openingbalance = '0.00';

				}

				else

				{

				$billnumber = $res22["billnumber"];

				$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

		
				$billnumbercode = intval($billnumbercode);

				$billnumbercode = $billnumbercode + 1;

				$maxanum = $billnumbercode;
				

				$billnumbercode = 'OPS-'.$maxanum;

				$openingbalance = '0.00';

			    }

	$locationcode = $_REQUEST['locationcode'];

		

	if(!empty($_FILES['upload_file']))

	{

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

			
			 if($rowData[$key] == 'itemcode')

			$itemcode1 = $key;

			 if($rowData[$key] == 'itemname')

			$itemname1 = $key;
			 
			 if($rowData[$key] == 'quantity')

			 $quantity1 = $key;
			
			 if($rowData[$key] == 'rateperunit')

			 $rateperunit1 = $key;
			 
			 if($rowData[$key] == 'batchnumber')

			 $batchnumber1 = $key;
			 
			 if($rowData[$key] == 'expirydate')

			 $expirydate1 = $key;
			
			 if($rowData[$key] == 'store')

			$store1 = $key;

			 if($rowData[$key] == 'location')

			 $location1 = $key;

			}			

			for ($row = 2; $row <= $highestRow; $row++){ 

    		//  Read a row of data into an array

    		$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,

                                    NULL,

                                    TRUE,

                                    FALSE)[0];

				 $medicinecode=$rowData[$itemcode1];	
			
				$item_name=$rowData[$itemname1];	
			
				$quantity_val=$rowData[$quantity1];
				
				 $item_name = addslashes($item_name);

				$rateper_unit=$rowData[$rateperunit1];

				$batch_number=$rowData[$batchnumber1];

				$expiry_date1=$rowData[$expirydate1];
				
				$store_name=$rowData[$store1];
				
				$location_name1=$rowData[$location1];
				
				 
			$transactiondate=str_replace('/','-',$expiry_date1);
			$transactiondate = trim(strtoupper($transactiondate));
			$transactiondate=str_replace('/','-',$transactiondate);
			
			$transactiondate=str_replace('"','',$transactiondate);
			if(strpos($transactiondate,'/') != true){
			
			$transactiondate=str_replace('/','-',$transactiondate);

            $expiry_date= date('Y-m-d', strtotime($expiry_date1));
			}
		
				
				
   $query1880 = "select storecode from master_store where storecode='$store_name'";

$exec1880 = mysqli_query($GLOBALS["___mysqli_ston"], $query1880) or die ("Error in Query1880".mysqli_error($GLOBALS["___mysqli_ston"]));

$res1880 = mysqli_fetch_array($exec1880);

$store_code = $res1880["storecode"];


  $query18801 = "select locationcode,locationname from master_location where locationcode='$location_name1'";

$exec18801 = mysqli_query($GLOBALS["___mysqli_ston"], $query18801) or die ("Error in Query18801".mysqli_error($GLOBALS["___mysqli_ston"]));

$res18801 = mysqli_fetch_array($exec18801);

$locationcode = $res18801["locationcode"];

$location_name = $res18801["locationname"];

$location=$locationcode;

 $query23 = "select * from master_medicine where itemcode = '$medicinecode' and status!='deleted'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in query23".mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$categoryname = $res23['categoryname'];
$medicine_name=$res23['itemname'];
if($item_name!='')
{
$item_name=$medicine_name;
}
if($store_code=='')
{
$item_name='';
}
	
if($locationcode=='')
{
$item_name='';
}
	


if($medicine_name=='')
{
$item_name='';
}		

$totalrate=$rateper_unit * $quantity_val;	

$transactiondate= date('Y-m-d');
		if ($item_name != '')
			{

				

			 $querystock2 = "select fifo_code from transaction_stock where docstatus='New Batch' order by auto_number desc limit 0, 1";

			$execstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querystock2) or die ("Error in Query212".mysqli_error($GLOBALS["___mysqli_ston"]));

			$resstock2 = mysqli_fetch_array($execstock2);

			$fifo_code = $resstock2["fifo_code"];

			if ($fifo_code == '')

			{		

				$fifo_code = '1';

				$querycumstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$medicinecode' and locationcode='$locationcode'";

				$execcumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querycumstock2) or die ("Error in CumQuery2update".mysqli_error($GLOBALS["___mysqli_ston"]));

				

$stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname,transaction_date,transactionfunction,description,batchnumber, batch_quantity,transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus,batch_stockstatus,locationcode,locationname,storecode,storename, username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice)
values ('1','purchase_details','$medicinecode', '$item_name', '$transactiondate','1', 'OPENINGSTOCK', '$batch_number', '$quantity_val', '$quantity_val', 
'$quantity_val', '$billnumbercode', 'New Batch','1','1', '$location','$location_name','$store_code', '', '$username', '$ipaddress','$updatedatetime', '$updatetime','$updatedate', '$rateper_unit','$totalrate')";
$stockexecquery2=mysqli_query($GLOBALS["___mysqli_ston"], $stockquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

}

else

{

$querycumstock2 = "select cum_quantity from transaction_stock where cum_stockstatus='1' and itemcode='$medicinecode' and locationcode='$locationcode'";

$execcumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querycumstock2) or die ("Error in CumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

$rescumstock2 = mysqli_fetch_array($execcumstock2);

$cum_quantity = $rescumstock2["cum_quantity"];

$cum_quantity = $quantity_val+$cum_quantity;

$fifo_code = $fifo_code + 1;				

$queryupdatecumstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$medicinecode' and locationcode='$locationcode'";

$execupdatecumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatecumstock2) or die ("Error in updateCumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

				

$stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,batchnumber, batch_quantity, transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode, locationname,storecode, storename,username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice)
values ('$fifo_code','purchase_details','$medicinecode', '$item_name', '$transactiondate','1', 'OPENINGSTOCK', '$batch_number', '$quantity_val', '$quantity_val', '$cum_quantity', '$billnumbercode', 'New Batch','1','1', '$location','','$store_code', '', '$username', '$ipaddress','$updatedatetime', '$updatetime','$updatedate','$rateper_unit','$totalrate')";
$stockexecquery2=mysqli_query($GLOBALS["___mysqli_ston"], $stockquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));				

	}

$query288 = "insert into openingstock_entry(itemcode,itemname,transactiondate,transactionmodule,transactionparticular,billnumber,quantity,rateperunit,totalrate,expirydate,store,location,batchnumber,companyanum,companyname,username,ipaddress,lastupdate) values ('$medicinecode','$item_name','$transactiondate','OPENINGSTOCK', 
'BY STOCK ADD','$billnumbercode', '$quantity_val','$rateper_unit','$totalrate','$expiry_date','$store_code','$location','$batch_number', '$companyanum','$companyname','$username','$ipaddress','$updatedatetime')";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query288) or die ("Error in Query2final".mysqli_error($GLOBALS["___mysqli_ston"]));

	

 $query12="insert into purchase_details (itemcode, itemname, entrydate,suppliername,suppliercode,quantity,allpackagetotalquantity,totalamount,username, ipaddress, rate, subtotal, companyanum,batchnumber,expirydate,location,store,billnumber,fifo_code)
values ('$medicinecode', '$item_name', '$transactiondate', 'OPENINGSTOCK','OPSE-1','$quantity_val','$quantity_val','$totalrate',
'$username','$ipaddress','$rateper_unit','$totalrate','$companyanum','$batch_number','$expiry_date','$location','$store_code','$billnumbercode','$fifo_code')";
$exec12=mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	
		  
			$totalrate=0;
			$rateper_unit=0;

		    }	
			
			
			
			
			
			
			
			}

			} catch(Exception $e) {

			 die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());

			}
            $errmsg = "Success. Services Uploaded.";

	        $bgcolorcode = 'success';
				

		}
		
		else
		{
		$errmsg = "Upload Failed.";

		$bgcolorcode = 'failed';
		}


}


	
?>


<script src="jquery/jquery-1.11.3.min.js"></script>
<script>

function storechk(store)
{

}



function ajaxlocationfunction(val)

{ 

}

					

//ajax to get location which is selected ends here







function validcheck()

{

	if (document.getElementById('upload_file').value == '') 

	{

		 alert('Select XLXS file to Upload');

		 return false;

	} 

	if(confirm("Are You Want To Save The Record?")==false){return false;}	

}



function funcOnLoadBodyFunctionCall()

{



}

function btnDeleteClick10(delID)

{


}

</script>



<script>

function medicinecheck()

{
	

}



function checkqty(val,sno)

{

}

//ajax function to get store for corrosponding location

function storefunction(loc)

{

}

	

	function functioncheklocationandstock()

	{

		
	}

	function checkallfunc()

	{

	}


</script>

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #E0E0E0;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

-->

</style>

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />







<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<style type="text/css">

<!--

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

-->

.bal

{

border-style:none;

background:none;

text-align:right;

}

.bali

{

text-align:right;

}

</style>

</head>



<script src="js/datetimepicker_css.js"></script>



<body onLoad="return funcOnLoadBodyFunctionCall();">

<table width="101%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="10" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10">&nbsp;</td>

  </tr>
  
<tr bgcolor="">

<td width="102">&nbsp;</td>

<td width="643" colspan="2" align="left" class="bodytext3"><strong>Opening Stocks  Data Import</strong></td>

</tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>

      &nbsp;</td>

    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">


   
      <form name="cbform1" method="post" action="openingstock_upload.php" enctype="multipart/form-data" onSubmit="return validcheck()">	

        <?php

				if (isset($_REQUEST["cbfrmflag12"])) { $cbfrmflag12 = $_REQUEST["cbfrmflag12"]; } else { $cbfrmflag12 = ""; }

					?>

      <tr>

        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="767" 

            align="left" border="0">

          <tbody bgcolor="#D3EEB7">

            <tr>

			<td colspan="3">&nbsp;</td>

			</tr>

			<tr>

			<td width="102">&nbsp;</td>

			<td width="643" colspan="2" align="left" class="bodytext3">

			<strong>Upload XLSX File </strong>			</td>

			</tr>
            
             <tr>
                    

                        <td colspan="3" align="left" valign="middle"   bgcolor="<?php if ($bgcolorcode == '') { echo '#D3EEB7'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>

                      </tr>

			<tr>

			

			<td colspan="2"><input type="file" name="upload_file" id="upload_file"></td>
            
        
            <td><a href="uploads/upload_openingstock.xlsx">Download Sample Excel</a></td>

			</tr>

			<tr>

			

			<td colspan="2" valig="left">

			<input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode_new; ?>">

			<input type="hidden" name="frmflag_upload" id="frmflag_upload" value="frmflag_upload">

			<input type="submit" name="frmsubmit1" value="Upload Excel">

			</td>
            
            <td>&nbsp;</td>

			</tr>

          </tbody>

        </table></td>

      </tr>

      

	  </form>

    </table>

  </table>

  <?php 

  //}

  ?>

<?php include ("includes/footer1.php"); ?>

</body>

</html>




<?php
session_start();
set_time_limit(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$transactiondate= date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$updatetime = date('H:i:s');
if (isset($_REQUEST["upload"])) { $upload = $_REQUEST["upload"]; } else { $upload = ""; }
if (isset($_REQUEST["errmsg"])) { $errmsg = $_REQUEST["errmsg"]; } else { $errmsg = ""; }
if (isset($_REQUEST["bgcolorcode"])) { $bgcolorcode = $_REQUEST["bgcolorcode"]; } else { $bgcolorcode = ""; }
//$upload = $_REQUEST['upload'];

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'success')
{
		$errmsg = "Success. File Uploaded Successfully.";
		if (isset($_REQUEST["cpynum"])) { $cpynum = $_REQUEST["cpynum"]; } else { $cpynum = ""; }
		if ($cpynum == 1) //for first company.
		{
			$errmsg = "Success. File Upload Failed.";
		}
}
if ($st == 'failed')
{
		$errmsg = "Failed. Supplier Already Exists.";
}

if ($upload == 'success')
{

	$importstarted = date("d-M-Y H:i:s");

	$skipcountservice = 0;
	$skipcounttax = 0;
	$skipcountcategory = 0;
	$skipcountunit = 0;
	$successcount = 0;
	$forloopcount = 0;
	$foldername = "tab_file_dump//";
	$filename = $username."_tabdump.txt";
	$filepath = $foldername.$filename;
	$fd = fopen ($filepath, "r");
	$fullcontents = fread ($fd,filesize ($filepath));
	fclose ($fd); 
	
	$linebreak = "\n"; //for line breaks
	$linecounter = 0;
	$splitcontents = explode($linebreak, $fullcontents);
	//print_r($splitcontents);
	$totallinecount = count($splitcontents);
	
	
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
				//echo $billnumbercode;
				$billnumbercode = intval($billnumbercode);
				$billnumbercode = $billnumbercode + 1;
				
				$maxanum = $billnumbercode;
				
				
				$billnumbercode = 'OPS-'.$maxanum;
				$openingbalance = '0.00';
				//echo $companycode;
			    }
	//echo "<br>";
	
	foreach ( $splitcontents as $linecontent )
	{
		$forloopcount = $forloopcount + 1;
		//echo "<br>";
		if ($forloopcount > 1 && $forloopcount < $totallinecount) // to skip header row. to skip last empty row to avoid empty array error.
		{
			//echo "<br><br>";
			$linecounter = $linecounter + 1;
			$linecontent; //contains the text of each line.
			
			$delimiter = "\t"; // for tab delimit breaks
			$delimitercount = 0;
			$splitdelimiter = explode($delimiter, $linecontent);
			$itemcode = $splitdelimiter[0];
			$itemname = $splitdelimiter[1];
			$itemname = strtoupper($itemname);
			$quantity = $splitdelimiter[2];
			$rateperunit = $splitdelimiter[3];
		    $totalrate = $quantity * $rateperunit;
			$batchnumber = $splitdelimiter[4];
			$expirydate = $splitdelimiter[5];
			$expirydate = date('Y-m-d',strtotime($expirydate));
			
			$store= $splitdelimiter[6];
			$store = strtoupper($store);
			$location = $splitdelimiter[7];
			$location = strtoupper($location);
			$location = trim($location);
			
	        $itemname = addslashes($itemname);
			
			//preg_match ('/[!,^,+,=,[,],;,,,{,},|,\,<,>,?,~]/', $itemname);
			
			if ($itemname != '')
			{
				
			$querystock2 = "select fifo_code from transaction_stock where docstatus='New Batch' order by auto_number desc limit 0, 1";
			$execstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querystock2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resstock2 = mysqli_fetch_array($execstock2);
			$fifo_code = $resstock2["fifo_code"];
			if ($fifo_code == '')
			{		
				$fifo_code = '1';
				$querycumstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$medicinecode' and locationcode='$locationcode'";
				$execcumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querycumstock2) or die ("Error in CumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,
				batchnumber, batch_quantity, 
				transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice)
				values ('1','purchase_details','$itemcode', '$itemname', '$transactiondate','1', 'OPENINGSTOCK', 
				'$batchnumber', '$quantity', '$quantity', 
				'$quantity', '$billnumbercode', 'New Batch','1','1', '$location','','$store', '', '$username', '$ipaddress','$updatedatetime','$updatetime','$updatedate','$rateperunit','$totalrate')";
				$stockexecquery2=mysqli_query($GLOBALS["___mysqli_ston"], $stockquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				else
				{
				$querycumstock2 = "select cum_quantity from transaction_stock where cum_stockstatus='1' and itemcode='$medicinecode' and locationcode='$locationcode'";
				$execcumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querycumstock2) or die ("Error in CumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$rescumstock2 = mysqli_fetch_array($execcumstock2);
				$cum_quantity = $rescumstock2["cum_quantity"];
				$cum_quantity = $quantity+$cum_quantity;
				$fifo_code = $fifo_code + 1;				
				$queryupdatecumstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$medicinecode' and locationcode='$locationcode'";
				$execupdatecumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatecumstock2) or die ("Error in updateCumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,
				batchnumber, batch_quantity, 
				transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice)
				values ('$fifo_code','purchase_details','$itemcode', '$itemname', '$transactiondate','1', 'OPENINGSTOCK', 
				'$batchnumber', '$quantity', '$quantity', 
				'$cum_quantity', '$billnumbercode', 'New Batch','1','1', '$location','','$store', '', '$username', '$ipaddress','$updatedatetime','$updatetime','$updatedate','$rateperunit','$totalrate')";
				
				$stockexecquery2=mysqli_query($GLOBALS["___mysqli_ston"], $stockquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));				
			}
			
			$query2 = "insert into openingstock_entry(itemcode,itemname,transactiondate,transactionmodule,transactionparticular,billnumber,quantity,rateperunit,totalrate,expirydate,store,location,batchnumber,companyanum,companyname,username,ipaddress,lastupdate) values ('$itemcode','$itemname','$transactiondate','OPENINGSTOCK', 
	       'BY STOCK ADD','$billnumbercode','$quantity','$rateperunit','$totalrate','$expirydate','$store','$location','$batchnumber','$companyanum','$companyname','$username','$ipaddress','$updatedatetime')";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$query12="insert into purchase_details (itemcode, itemname, entrydate,suppliername,suppliercode,
			quantity,allpackagetotalquantity,totalamount,
			username, ipaddress, rate, subtotal, companyanum,batchnumber,expirydate,location,store,billnumber,fifo_code)
			values ('$itemcode', '$itemname', '$transactiondate', 'OPENINGSTOCK','OPSE-1',
			'$quantity','$quantity','$totalrate',
			'$username', '$ipaddress', '$rateperunit','$totalrate','$companyanum','$batchnumber','$expirydate','$location','$store','$billnumbercode','$fifo_code')";
		    $exec12=mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			
			

		    $successcount = $successcount + 1;
		    }
			else
			{
			$skipcountunit = $skipcountunit + 1;
			}
		}
	}
	header("location:addstockopeningentry1.php?st=success");
}
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">


</script>
<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td>
                  <table width="83%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Item / Services Data Import From TAB Delimited File </strong></td>
                      </tr>
                       <tr>
                        <td colspan="8" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
				 
            <tr>
              <td>&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$billautonumberr = $_GET['billautonumber'];

//$financialyear = $_SESSION["financialyear"];

	$query6 = "select * from master_company where auto_number = '$companyanum'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res6 = mysqli_fetch_array($exec6);
	$res6companycode = $res6["companycode"];
	
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
//echo $billautonumber;
if (isset($_REQUEST["printsource"])) { $printsource = $_REQUEST["printsource"]; } else { $printsource = ""; }

$query1 = "select * from master_company where auto_number = '$companyanum'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1companyname = $res1['companyname'];
$res1address1 = $res1['address1'];
$res1area = $res1['area'];
$res1city = $res1['city'];
$res1state = $res1['state'];
$res1country = $res1['country'];
$res1pincode = $res1['pincode'];
$res1phonenumber1 = $res1['phonenumber1'];
$consultationprefix = $res1['consultationprefix'];

$query33 = "select * from master_billing where billnumber = '$billautonumberr' ";
$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
$res33 = mysqli_fetch_array($exec33);
$res33patientfirstname = $res33['patientfirstname'];
$res33patientcode = $res33['patientcode'];
$res33visitcode = $res33['visitcode'];
$res33billnumber = $res33['billnumber'];
$res33consultationfees = $res33['consultationfees'];
$res33copaypercentageamount = $res33['copaypercentageamount'];
$res33consultingdoctor = $res33['consultingdoctor'];
$res33totalamount = $res33['totalamount'];
$res33billingdatetime = $res33['billingdatetime'];
$res33patientpaymentmode = $res33['patientpaymentmode'];
$res33username = $res33['username'];
$res33cashgiventocustomer = $res33['cashgiventocustomer'];
$res33cashgivenbycustomer = $res33['cashgivenbycustomer'];




$query3 = "select * from master_transactionpaynow where billnumber = '$billautonumberr'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$res3patientname = $res3['patientname'];
$res3patientcode = $res3['patientcode'];
$res3visitcode = $res3['visitcode'];
$res3billnumber = $res3['billnumber'];
$res3transactionamount = $res3['transactionamount'];
$res3transactiondate = $res3['transactiondate'];
$res3transactionmode = $res3['transactionmode'];
$res3cashgiventocustomer = $res3['cashgiventocustomer'];
$res3cashgivenbycustomer = $res3['cashgivenbycustomer'];
$res3username = $res3['username'];
$res3username = strtoupper($res3username);
$res3transactiondate = $res3['transactiondate'];
$res3transactiontime = $res3['transactiontime'];
$res3transactiontime = explode(":",$res3transactiontime);

if($res33username == 'ADMIN')
{
$res33username = 'AMINISTRATOR';
}

?>
<script language="javascript">
function escapekeypressed()
{
	//alert(event.keyCode);
	if(event.keyCode=='27'){ window.close(); }
}

</script>
<style type="text/css">
<!--
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 12px; COLOR: #000000; FONT-FAMILY: Tahoma
}
.number
{
padding-left:690px;
text-align:right;
font-weight:bold;
}
-->

table.data
{
    height: auto;
    width: 660;
	position: relative;
    top: 20;
    left: 0;
  
}
.data {font-size:16px }
.data {table-layout:auto }

</style>

<body onkeydown="escapekeypressed()">
	<table width="700" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<div align="left">&nbsp;
	<?php
			$query2showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec2showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query2showlogo) or die ("Error in Query2showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2showlogo = mysqli_fetch_array($exec2showlogo);
			$showlogo = $res2showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
				
			<img src="logofiles/<?php echo $companyanum;?>.jpg" width="75" height="75" />
			
			<?php
			}
			?>	
	</div></td>
	<td>
	<div align="right">&nbsp;
	<?php
	echo '<strong>'.$res1companyname.'</strong>';
	echo '<br>'.$res1address1.' '.$res1area;
	echo '<br>Phone : '.$res1phonenumber1;
	?>
	</div></td>
  </tr>
  
  <tr>
    <td>
	  <div align="left">
	<strong><?php
	echo 'Name :'.$res33patientfirstname; 
	echo '<br>Reg No. :'.$res33patientcode; ;
	echo '<br>Visit No. :'.$res33visitcode;
	?></strong>&nbsp;
    </div>
	</td>
	
	<td>
	<div align="right">
	<strong>
	<?php
	echo 'Bill Number :'.$billautonumberr ;
	echo '<br>Bill Date :'.$res33billingdatetime;
     ?>
    </strong>
    </div>
	</td>
  </tr>
  
</table>
<table border="0" cellpadding="0" cellspacing="0" class = "data">
      <tr>
        <td class="bodytext31" width="12%" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>No.</strong></div></td>
        <td width="29%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Description </strong></div></td>
        <td width="24%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Consultation Fees </strong></div></td>
        <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Copay </strong></div></td>
        <td width="24%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Net Amount </strong></div></td>
      </tr>
      <tr>
        <td  align="left" valign="center" 
 bgcolor="#ffffff" class="bodytext31" nowrap="nowrap"><?php echo '1'; ?></td>
        <td  align="left" valign="center" 
bgcolor="#ffffff" class="bodytext31" nowrap="nowrap" ><?php echo $res33consultingdoctor; ?></td>
        <td  align="left" valign="center" 
bgcolor="#ffffff" class="bodytext31" nowrap="nowrap"><?php echo $res33consultationfees; ?></td>
        <td align="left" valign="center" 
bgcolor="#ffffff" class="bodytext31" nowrap="nowrap"><?php echo $res33copaypercentageamount; ?></td>
        <td align="left" valign="center" 
bgcolor="#ffffff" class="bodytext31" nowrap="nowrap"><?php echo $res33totalamount; ?></td>
      </tr>
      <tr>
        <td colspan="1" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left">&nbsp;</div></td>
        <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left">&nbsp;</div>
            <strong> Payment Mode: <?php echo $res33patientpaymentmode; ?></strong></td>
      </tr>
      <tr>
        <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left">&nbsp;</div></td>
        <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left">&nbsp;</div></td>
        <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left">&nbsp;</div></td>
        <td colspan ="3" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Total:</strong><strong> <?php echo $res33totalamount; ?> </strong></div></td>
      </tr>
      <tr>
        <td class="bodytext31" width="12%" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left">&nbsp;</div></td>
        <td class="bodytext31" width="29%" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left">&nbsp;</div></td>
        <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left">&nbsp;</div></td>
        <td colspan="3"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Cash Given:</strong><strong> <?php echo $res33cashgivenbycustomer; ?> </strong></div></td>
      </tr>
      <tr>
        <td class="bodytext31" width="12%" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left">&nbsp;</div></td>
        <td class="bodytext31" width="29%" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left">&nbsp;</div></td>
        <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left">&nbsp;</div></td>
        <td colspan="3"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Change Returned:</strong><strong> <?php echo $res33cashgiventocustomer; ?> </strong></div></td>
      </tr>
      <!-- 
		  <?php
	include ('convert_currency_to_words.php');
	$convertedwords = covert_currency_to_words($res2totalamount); ?>
-->
      <tr>
        <td class="bodytext31"  valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
     </tr>
     <tr>
        <td colspan ="5" class="bodytext31"  valign="center"  align="left" 
                bgcolor="#ffffff"><strong> Amount in words:</strong> <?php echo $convertedwords; ?></td>
      </tr>
	  <tr>
    <td colspan ="5" class="bodytext31"  valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Served by:</strong></div></td>
</tr>

<tr>
<td colspan ="5" class="bodytext31"  valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong> <?php echo '<strong>'.strtoupper($res33username);
	echo '<br> '.$res33billingdatetime.'&nbsp;'.$res33billingdatetime[0]. ':' .$res33billingdatetime[1];
	?></strong></div></td>
</tr>

     </td>
  </tr>
    </table>
</body>
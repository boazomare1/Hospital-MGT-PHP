<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
 
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

//$financialyear = $_SESSION["financialyear"];

	$query6 = "select * from master_company where auto_number = '$companyanum'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res6 = mysqli_fetch_array($exec6);
	$res6companycode = $res6["companycode"];
	
	$query7 = "select * from master_settings where companycode = '$res6companycode' and modulename = 'SETTINGS' and 
	settingsname = 'CURRENT_FINANCIAL_YEAR'";
	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res7 = mysqli_fetch_array($exec7);
	$financialyear = $res7["settingsvalue"];
	$_SESSION["financialyear"] = $financialyear;
	//echo $_SESSION['financialyear'];


if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
//echo $billautonumber;

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


$query2 = "select * from master_billing where auto_number = '$billautonumber'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$patientcode = $res2['patientcode'];
$billnumber = $res2['billnumber'];
$billdate = $res2['billingdatetime'];

$patientfirstname = $res2['patientfirstname'];
$patientlastname = $res2['patientlastname'];
$consultingdoctor = $res2['consultingdoctor'];
$consultationdate = $res2['consultationdate'];
$consultationtime = $res2['consultationtime'];

$subtotalamount = $res2['subtotalamount'];
$copayfixedamount = $res2['copayfixedamount'];
$copaypercentageamount = $res2['copaypercentageamount'];
$discountamount = $res2['discountamount'];
$totalamount = $res2['totalamount'];
$patientpaymentmode = $res2['patientpaymentmode'];


?>
<script language="javascript">

function escapekeypressed()
{
	//alert(event.keyCode);
	if(event.keyCode=='27'){ window.close(); }
}

</script>
<body onkeydown="escapekeypressed()">
<table width="660" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<div align="center">&nbsp;
	<?php
	echo '<strong>'.$res1companyname.'</strong>';
	echo '<br>'.$res1address1.' '.$res1area.' '.$res1city.' '.$res1pincode;
	echo '<br>Phone : '.$res1phonenumber1;
	?>
	</div>	</td>
  </tr>
  <tr>
    <td>
	  <div align="right">
	<?php
	echo 'Bill Number : '.$billnumber.'&nbsp;';
	echo '<br>Bill Date : '.$billdate;
	?>&nbsp;
    </div></td>
  </tr>
  <tr>
    <td><div align="left">
    <?php
	echo 'Patient : '.$patientfirstname.' '.$patientlastname.' ( '.$patientcode.' ) ';
	echo '<br>Consulting Doctor : '.$consultingdoctor;
	?>
    </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="left">
      <?php
	echo 'Particulars : Consultation Fees';
	?>
    </div></td>
  </tr>
  <tr>
    <td><table width="300" border="0" align="right" cellpadding="0" cellspacing="0">
      <tr>
        <td width="198">Sub Total </td>
        <td width="102">
		  <div align="right">
		  <?php
		  echo $subtotalamount;
		  ?>&nbsp;
		  </div>
		  </td>
      </tr>
      <tr>
        <td>Copay Fixed Amount </td>
        <td>
		  <div align="right">
		  <?php
		  echo $copayfixedamount;
		  ?>&nbsp;
		  </div>
		</td>
      </tr>
      <tr>
        <td>Copay Percentage Amount </td>
        <td>
		  <div align="right">
		  <?php
		  echo $copaypercentageamount;
		  ?>&nbsp;
		  </div>
		</td>
      </tr>
      <tr>
        <td>Discount Amount </td>
        <td>
		  <div align="right">
		  <?php
		  echo $discountamount;
		  ?>&nbsp;
		  </div>
		</td>
      </tr>
      <tr>
        <td>Total Amount </td>
        <td>
		  <div align="right">
		  <?php
		  echo $totalamount;
		  ?>&nbsp;
		  </div>
		</td>
      </tr>
      <tr>
        <td>Payment Mode </td>
        <td>
		  <div align="right">
		  <?php
		  echo $patientpaymentmode;
		  ?>&nbsp;
		  </div>
		</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
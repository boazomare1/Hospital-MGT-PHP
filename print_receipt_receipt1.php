<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

$query1 = "select * from receiptsub_details where recordstatus <> 'DELETED' and companyanum = '$companyanum' order by auto_number desc";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$rowcount1 = mysqli_num_rows($exec1);
if ($rowcount1 == 0)
{
	echo 'Sorry. No Receipt Entry To Print.';
	exit;
}

if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
//$billautonumber = $_REQUEST["billautonumber"];

if (isset($_REQUEST["copy1"])) { $copy1 = $_REQUEST["copy1"]; } else { $copy1 = ""; }
//$copy1 = $_REQUEST['copy1'];
if (isset($_REQUEST["title1"])) { $title1 = $_REQUEST["title1"]; } else { $title1 = ""; }
//$title1 = $_REQUEST['title1'];

$query2 = "select * from settings_billhospital where companyanum = '$companyanum'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);

	$f1 = $res2['f1'];
	$f2 = $res2['f2'];
	$f3 = $res2['f3'];
	$f4 = $res2['f4'];
	$f5 = $res2['f5'];
	$f6 = $res2['f6'];
	$f7 = $res2['f7'];
	$f8 = $res2['f8'];
	$f9 = $res2['f9'];
	$f10 = $res2['f10'];
	$f11 = $res2['f11'];
	$f12 = $res2['f12'];
	$f13 = $res2['f13'];
	$f14 = $res2['f14'];
	$f15 = $res2['f15'];
	$f16 = $res2['f16'];
	$f17 = $res2['f17'];
	$f18 = $res2['f18'];
	$f19 = $res2['f19'];
	$f20 = $res2['f20'];
	$f21 = $res2['f21'];
	$f22 = $res2['f22'];
	$f23 = $res2['f23'];
	$f24 = $res2['f24'];
	$f25 = $res2['f25'];
	$f26 = $res2['f26'];
	$f27 = $res2['f27'];
	$f28 = $res2['f28'];
	$f29 = $res2['f29'];
	$f30 = $res2['f30'];
	$f31 = $res2['f31'];
	$f32 = $res2['f32'];
	$f9size = $res2['f9size'];
	$f27size = $res2['f27size'];
	$f28size = $res2['f28size'];
	$letterheadprinting = $res2['letterheadprinting'];


//$query21 = "select auto_number from master_sales where auto_number = '$res22anum' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
if (isset($_REQUEST["receiptanum"])) { $receiptanum = $_REQUEST["receiptanum"]; } else { $receiptanum = ""; }
//$receiptanum = $_REQUEST['receiptanum'];
if ($receiptanum != '')
{
	$query21 = "select * from receiptsub_details where auto_number = '$receiptanum'";
}
else
{
	$query21 = "select * from receiptsub_details where recordstatus <> 'DELETED' and companyanum = '$companyanum' order by auto_number desc";
}
$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
$res21 = mysqli_fetch_array($exec21);
$res21anum = $res21['auto_number'];
/*
$res21date = $res21['transactiondate'];
$billtime = substr($res21date, 11, 8);
$dotarray = explode("-", $res21date);
$dotyear = $dotarray[0];
$dotmonth = $dotarray[1];
$dotday = $dotarray[2];
$dbdateday = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));
*/
$res21date = $res21["transactiondate"];
$billtime = substr($res21date, 11, 8);
$billdateonly = substr($res21date, 0, 10);
$dotarray = explode("-", $billdateonly);
$dotyear = $dotarray[0];
$dotmonth = $dotarray[1];
$dotday = $dotarray[2];
$dbdateday = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));

//$billdate = $dbdateday.' '.$billtime;
$billdate = $dbdateday;//.' '.$billtime;
//$customeranum = $res21['customeranum'];
$transactionmode = $res21['transactionmode'];
if ($transactionmode == 'CASH')
{
	$amount = $res21['cashamount'];
}
if ($transactionmode == 'CHEQUE')
{
	$amount = $res21['chequeamount'];
}
if ($transactionmode == 'ONLINE')
{
	$amount = $res21['onlineamount'];
}
$remarks = $res21['remarks'];
$transactionmode = $res21['transactionmode'];
if ($transactionmode == 'CHEQUE')
{
	$chequenumber = $res21['chequenumber'];
	$chequedate = $res21['chequedate'];
	$transactionmode = 'Cheque No.'.$chequenumber.' Dated '.$chequedate;
}
$transactionmode = 'By '.$transactionmode;

$receiptmainname = $res21['receiptmainname'];
$receiptsubname = $res21['receiptsubname'];
$receiptfullname = $receiptmainname.' - '.$receiptsubname;

/*
$query3 = "select * from master_customer where auto_number = '$customeranum'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$customername = $res3['customername'];
if ($customername != '') $customername = 'M/s. '.$customername;
$address = $res3['address'];
$location = $res3['location'];
$city = $res3['city'];
$state = $res3['state'];
$pincode = $res3['pincode'];
$city = $city.', '.$state;
if ($pincode != '') $city = $city.' - '.$pincode;

$subtotal = $res3['subtotal'];

$delivery = $res3['delivery'];
$deliverymode = $res3['deliverymode'];
$roundoff = $res3['roundoff'];
$totalamount = $res3['totalamount'];
*/

/*
$footerline1 = $res3['footerline1'];
$footerline2 = $res3['footerline2'];
$footerline3 = $res3['footerline3'];
$footerline4 = $res3['footerline4'];
$footerline5 = $res3['footerline5'];
$footerline6 = $res3['footerline6'];

$tinnumber = $res3['tinnumber'];
$cstnumber = $res3['cstnumber'];

$fontsize1 = $res2['fontsize1']; //F1 customer title
$fontsize2 = $res2['fontsize2']; // F2 Header lines.
$fontsize3 = $res2['fontsize3']; // F3 Body of bill.
$fontsize4 = $res2['fontsize4']; // F4 Tabular Columns.

$companyanum = $_SESSION['companyanum'];
$query4 = "select * from master_company where auto_number = '$companyanum'";
$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
$res4 = mysql_fetch_array($exec4);
$f9color = $res4['f9color'];
$f10color = $res4['f10color'];
$f25color = $res4['f25color'];

*/

?>
<style type="text/css">
<!--
.style6 {<?php echo 'font-size: '.$fontsize4.'px'; ?>;}
.style8 {<?php echo 'font-size: '.$fontsize4.'px'; ?>; font-weight: bold; }


/*
.style3 {
	font-family: "Times New Roman", Times, serif;
	font-weight: bold;
	font-size: 24px;
}

.style2 {font-size: 10px}
.style5 {font-family: "Times New Roman", Times, serif; font-weight: bold; font-size: 18px; }
.style6 {font-size: 14px}
.style8 {font-size: 14px; font-weight: bold; }
*/

table.sample {
	border-width: 1px;
	border-spacing: 1px;
	border-style: outset;
	border-color: gray;
	border-collapse: collapse;
	background-color: white;
}
table.sample th {
	border-width: 1px;
	border-spacing: 1px;
	border-style: outset;
	border-color: gray;
	border-collapse: collapse;
	background-color: white;
}
.style12 {font-size: 18px; font-weight: bold; }
.style27 {font-size: 14px; }
.style28 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 24px;
}
.style29 {font-family: Neuropol}

-->
</style>
<script language="javascript">

function escapekeypressed()
{
	//alert(event.keyCode);
	if(event.keyCode=='27'){ window.close(); }
}

</script>
<body onkeydown="escapekeypressed()">
<table width="660" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3"><div align="center">
	<?php
	//for letter head printing settings
	if ($letterheadprinting == '') // to print on blank paper with headers.
	{
	//echo "inside if";
	?>
      <table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
		<?php include ("print_showlogo1pharmacy.php"); ?>
          <td width="57%"><div align="center" class="style12">
            <div align="left"><span class="style29"><font <?php echo 'size="'.$f9size.'"'; ?>><?php echo $f9; ?></font></span></div>
          </div>
            <div align="center" class="style27">
              <div align="left"><span class="style6"> <font <?php echo 'size="'.$f27size.'"'; ?>><?php echo $f10; ?></font> </span></div>
            </div>
            <div align="center" class="style27">
              <div align="left"><span class="style6"> <font <?php echo 'size="'.$f27size.'"'; ?>><?php echo $f11; ?></font> </span></div>
            </div>
            <div align="center" class="style27">
              <div align="left"><span class="style6"> <font <?php echo 'size="'.$f27size.'"'; ?>><?php echo $f12; ?></font> </span></div>
            </div></td>
          <td width="29%" valign="top">
		  <div align="right"><span class="style28">
			<?php 
			echo 'EXPENSE RECEIPT';
			?>
		     </span> <br />
		    </div>
		  <div class="style27">
		    <div align="right"><span class="style6"><?php echo $title1; ?></span>&nbsp;&nbsp;</div>
		  </div></td>
        </tr>
      </table>
	  <?php
	}
	else if ($letterheadprinting == 'YES') // to print on letter head without headers.
	{
	//echo "inside else";
	?>
      <table width="99%" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td width="14%">&nbsp;</td>
          <td width="57%"><div align="center" class="style12">
            <div align="left"><span class="style28"><font <?php if ($f9size != '') { echo 'size="'.$f9size.'"'; } ?>><?php //echo $f9; ?>&nbsp;</font></span></div>
          </div>
            <div align="center" class="style27">
              <div align="left"><span class="style6"> <font <?php if ($f27size != '') { echo 'size="'.$f27size.'"'; } ?>><?php //echo $f10; ?>&nbsp;</font> </span></div>
            </div>
            <div align="center" class="style27">
              <div align="left"><span class="style6"> <font <?php if ($f27size != '') { echo 'size="'.$f27size.'"'; } ?>><?php //echo $f11; ?>&nbsp;</font> </span></div>
            </div>
            <div align="center" class="style27">
              <div align="left"><span class="style6"> <font <?php if ($f27size != '') { echo 'size="'.$f27size.'"'; } ?>><?php //echo $f12; ?>&nbsp;</font> </span></div>
            </div></td>
          <td width="29%" valign="top">
		  <span class="style28">
		  <?php 
		  /*
		  if ($title1 == '')
		  {
		  	echo $f28; 
		}
		else
		{
			echo $title1;
		}
		*/
		  ?>
			<?php 
			echo 'EXPENSE RECEIPT';
			?>
		  </span><br /><?php //echo $copy1; ?></td>
        </tr>
      </table>
	<?php
	}
	//end of letter head printing settings.	  
	  ?>
    </div></td>
  </tr>
  <tr>
    <td colspan="3"><div align="center">&nbsp;</div></td>
  </tr>
  
  <tr>
    <td colspan="2"  valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="62%">&nbsp;</td>
        <td width="38%" valign="top"><table width="92%" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
            <td><div align="left" class="style27"><span class="style6"><?php echo 'Receipt No.: '.$res21anum; ?></span></div></td>
          </tr>
          <tr>
            <td><div align="left" class="style27"><span class="style6"><?php echo $f16.' '.$billdate; ?></span></div></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>Paid To </td>
    <td><?php echo $receiptfullname; ?>&nbsp;</td>
    <td width="4">&nbsp;</td>
  </tr>
  <tr>
    <td>Amount Paid </td>
    <td>
	<?php 
	echo 'Rs.'.$amount; 
	include ('convert_currency_to_words.php');
	$convertedwords = covert_currency_to_words($amount); //function call
	echo ' ( '.$convertedwords.' )';
	?>	</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>Towards</td>
    <td><?php echo $remarks; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $transactionmode; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><div class="style27">&nbsp;
    </span></div></td>
  </tr>
  
  <tr>
    <td width="174" valign="top">&nbsp;</td>
    <td width="482" valign="top"><table width="98%" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr>
        <td><div align="right"><span class="style27">
          </span>
            <table width="99%" border="0" align="left">
              <tr>
                <td><div align="right"><span class="style27"><b><?php echo $f25; ?></b></span></div></td>
              </tr>
            </table>
            </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
		  <div align="right"><span class="style6">
	        </span>
		    <table width="99%" border="0" align="left">
              <tr>
                <td><div align="right"><span class="style27">
				<b><?php echo $f26; ?></b></span></div></td>
              </tr>
            </table>
		    </div></td>
      </tr>
      
    </table></td>
  </tr>
  
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><span class="style27">
	<?php 
	$query7 = "select * from master_edition where status = 'ACTIVE'";
	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res7 = mysqli_fetch_array($exec7);
	$res7edition = $res7['edition'];
	if ($res7edition == 'FREE' or $res7edition == 'SPONSORED')
	{
		echo "Free Software By: WWW.SIMPLEINDIA.COM"; 
	}
	?>
	</span></td>
  </tr>
</table>
</body>
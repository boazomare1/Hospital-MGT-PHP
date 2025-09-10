<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');



$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";
$total_depositsip = "0.00";
$total_depositsip_accounts=0;
$openingbalance = "0.00";
$disocuntamount=0;
$total = '0.00';

$totalamount = "0.00";

$totalamount30 = "0.00";

$searchsuppliername = "";

$searchsuppliername1 = "";

$cbsuppliername = "";

$snocount = "";

$colorloopcount="";

$range = "";

$total30="0.00";

$total60 = "0.00";

$total90 = "0.00";

$total120 = "0.00";

$total180 = "0.00";

$total240 = "0.00";

$totalamount1 = "0.00";

$totalamount301 = "0.00";

$totalamount601 = "0.00";
$rebate = "0.00";

$totalamount901 = "0.00";

$totalamount1201 = "0.00";

$totalamount1801 = "0.00";

$totalamount2101 = "0.00";

$grandtotalamount1 = "0.00";

$grandtotalamount301 = "0.00";

$grandtotalamount601 = "0.00";

$grandtotalamount901 = "0.00";

$grandtotalamount1201 = "0.00";

$grandtotalamount1801 = "0.00";

$grandtotalamount2101 = "0.00";

$grandtotalamount2401 = "0.00";

$totalamount1 = "0.00";

$totalamount301 = "0.00";

$totalamount60 = "0.00";

$totalamount601 = "0.00";

$totalamount90 = "0.00";

$totalamount901 = "0.00";

$totalamount120 = "0.00";

$totalamount1201 = "0.00";

$totalamount180 = "0.00";

$totalamount1801 = "0.00";

$totalamount210 = "0.00";

$totalamount2101 = "0.00";

$totalamount240 = "0.00";

$totalamount2401 = "0.00";

$res21accountnameano='';

$closetotalamount1 = '0';

$closetotalamount301 = '0';

$closetotalamount601 = '0';

$closetotalamount901 = '0';

$closetotalamount1201 = '0';

$closetotalamount1801 = '0';

$closetotalamount2101 = '0';

$closetotalamount2401 = '0';



$total301='0';

$total601='0';

$total901='0';

$total1201='0';

$total1801='0';

$total2401='0';



$total3012='0';

$total6012='0';

$total9012='0';

$total12012='0';

$total18012='0';

$total24012='0';



$total3013='0';

$total6013='0';

$total9013='0';

$total12013='0';

$total18013='0';

$total24013='0';







//This include updatation takes too long to load for hunge items database.

//include("autocompletebuild_subtype.php");



//include ("autocompletebuild_account3.php");





if (isset($_REQUEST["searchsuppliername1"])) { $searchsuppliername1 = $_REQUEST["searchsuppliername1"]; } else { $searchsuppliername1 = ""; }



if (isset($_REQUEST["searchsubtypeanum1"])) {  $searchsubtypeanum1 = $_REQUEST["searchsubtypeanum1"]; } else { $searchsubtypeanum1 = ""; }





if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }

$type1 = $type;

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; $paymentreceiveddatefrom= $_REQUEST["ADate1"];} else { $ADate1 = ""; }

//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; $paymentreceiveddateto= $_REQUEST["ADate2"];} else { $ADate2 = ""; }

//echo $ADate2;

if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }

//echo $range;

if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }

//echo $amount;

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

//$frmflag2 = $_POST['frmflag2'];



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

<!--<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />-->

<!--<script type="text/javascript" src="js/adddate.js"></script>-->

<!--<script type="text/javascript" src="js/adddate2.js"></script>-->

<script type="text/javascript" src="js/autocomplete_subtype.js"></script>

<script type="text/javascript" src="js/autosuggestsubtype.js"></script>



<script type="text/javascript">

window.onload = function () 

{

	var oTextbox = new AutoSuggestControl1(document.getElementById("searchsuppliername1"), new StateSuggestions1());

	//var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        

}

</script>



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

<script language="javascript">

function showsub(subtypeano)

{

if(document.getElementById(subtypeano) != null)

{

if(document.getElementById(subtypeano).style.display == 'none')

{

document.getElementById(subtypeano).style.display = '';

}

else

{

document.getElementById(subtypeano).style.display = 'none';

}

}

}

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

    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860">

		

		

              <form name="cbform1" method="post" action="" >

		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Revenue Summary Report</strong></td>

              </tr>

            <!--<tr>

              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">

			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 

                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 

				</td>

              </tr>-->

			  <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Type </td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

              <select name="type" id="type">

			  <option value="">All Types</option>

			  <?php

			  $query51 = "select * from master_paymenttype where recordstatus <> 'deleted' and paymenttype <> 'cash'";

			  $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			  while($res51 = mysqli_fetch_array($exec51))

			  {

			  $paymenttype = $res51['paymenttype'];

			  $manum = $res51['auto_number'];

			  ?>

			  <option value="<?php echo $manum; ?>" <?php if($manum == $type){ echo "selected"; }?>><?php echo $paymenttype; ?></option>

			  <?php

			  }

			  ?>

			  </select>

			  </span></td>

           </tr>

			   <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Subtype </td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

              <input name="searchsuppliername1" type="text" id="searchsuppliername1" value="<?php echo $searchsuppliername1; ?>" size="50" autocomplete="off">

              <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">

			  <input name="searchsubtypeanum1" id="searchsubtypeanum1" value="<?php echo $searchsubtypeanum1; ?>" type="hidden">

			  </span></td>

           </tr>

		 

            

		   

			  <tr>

                      <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF"> Date From </td>

                    <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>

                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>

                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">

                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>

                  </tr>	

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                  <input type="submit" value="Search" name="Submit" />

                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>

            </tr>

          </tbody>

        </table>

		</form>		</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

       <tr>

        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="700" 

            align="left" border="0">

          <tbody>

            <tr>

              <td width="7%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td colspan="2" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311">

              <?php

				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{

					if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }

					//$cbbillnumber = $_REQUEST['cbbillnumber'];

					if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }

					//$cbbillstatus = $_REQUEST['cbbillstatus'];

					

					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }

					//$cbbillnumber = $_REQUEST['cbbillnumber'];

					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }

					//$cbbillstatus = $_REQUEST['cbbillstatus'];

					

					//$transactiondatefrom = $_REQUEST['ADate1'];

					//$transactiondateto = $_REQUEST['ADate2'];

					

					//$paymenttype = $_REQUEST['paymenttype'];

					//$billstatus = $_REQUEST['billstatus'];

					

					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";

				}

				else

				{

					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";

				}

				?>

 				

              <!--<input  value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />

&nbsp;				<input  value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />-->

</span></td>  

            </tr>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></td>

              <td width="15%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account</strong></div></td>

	              <td width="16%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong> Total Revenue </strong></td>
	              <td width="16%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong> Total Deposits </strong></td>

             </tr>

			

			<?php

			

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{

				$totalbilling = 0;	

			$dotarray = explode("-", $paymentreceiveddateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			$searchsuppliername1 = trim($searchsuppliername1);

			$searchsuppliername = trim($searchsuppliername);

		 	if($type != '')

			{

			$query513 = "select auto_number, paymenttype from master_paymenttype where auto_number = '$type' and recordstatus <> 'deleted'";

			}

			else

			{

			$query513 = "select auto_number, paymenttype from master_paymenttype where paymenttype <> 'cash' and recordstatus <> 'deleted'";

			}

			$exec513 = mysqli_query($GLOBALS["___mysqli_ston"], $query513) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res513 = mysqli_fetch_array($exec513))

			{

			$type = $res513['paymenttype'];

			$typeanum = $res513['auto_number'];

			?>

			<tr bgcolor="#CCC">

            <td colspan="4" align="left" valign="center" bgcolor="#CCC" class="bodytext31" ><strong><?php echo $type; ?> </strong></td>

            </tr>

			<tr>

			<td colspan="3"></td>

			</tr> 

			<?php

			if($searchsubtypeanum1=='')

			{

				 $query2212 = "select accountname,auto_number,id,subtype from master_accountname where subtype <> '' and paymenttype = '$typeanum' group by subtype";

			}

			else if($searchsubtypeanum1!='')

			{

				 $query2212 = "select accountname,auto_number,id,subtype from master_accountname where paymenttype = '$typeanum' and subtype='$searchsubtypeanum1'  group by subtype";

			}

			//echo $query2212;
			$exec2212 = mysqli_query($GLOBALS["___mysqli_ston"], $query2212) or die ("Error in Query2212".mysqli_error($GLOBALS["___mysqli_ston"]));
 			$resnum=mysqli_num_rows($exec2212); 

			while($res2212 = mysqli_fetch_array($exec2212))
			{

			$subtypeanum = $res2212['subtype'];

			$sno=1;

			$query9 = mysqli_query($GLOBALS["___mysqli_ston"], "select subtype from master_subtype where auto_number = '$subtypeanum'");

			$res9 = mysqli_fetch_array($query9);

			$subtype = $res9['subtype'];

			?>

			<tr bgcolor="#cbdbfa">

            <td colspan="4"  align="left" valign="center" bgcolor="#FFF" class="bodytext31" onClick="showsub(<?=$subtypeanum?>)"><strong><?php echo $subtype; ?> </strong></td>

            </tr> 

			<tbody id="<?=$subtypeanum?>" style="display:none">

			<?php

			if( $subtypeanum!='')

			{

				 $query221 = "select accountname,auto_number,id from master_accountname where subtype='$subtypeanum'";

			}

			//echo $query221;

			$exec221 = mysqli_query($GLOBALS["___mysqli_ston"], $query221) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));

 			$resnum=mysqli_num_rows($exec221); 

			while($res221 = mysqli_fetch_array($exec221))

			{

			

			$res22accountname = $res221['accountname'];

			$res21accountnameano=$res221['auto_number'];

			$res21accountname = $res221['accountname'];

			$res21accountid = $res221['id'];

			

		 	$querydebit1 = "select * from master_transactionpaylater where accountnameano='$res21accountnameano' and accountnameid='$res21accountid'";

		

			$execdebit1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydebit1) or die ("Error in Querydebit1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$numdebit1 = mysqli_num_rows($execdebit1);

					

			//echo $cashamount;

			

		

			if( $res22accountname != '' && $numdebit1>0)

			{

			

			$openingbalance='0';

			if ($cbfrmflag1 == 'cbfrmflag1')

			{

			

	$totaldebit=0;		

$debit=0;

$credit1=0;

$credit2=0;

$totalpayment=0;

$totalcredit='0';

$resamount=0;



			

			

			$totalamountgreater=0;

			$dotarray = explode("-", $paymentreceiveddateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			$searchsuppliername1 = trim($searchsuppliername1);

		  // $query1 = "select subtypeano,accountname,subtype,transactiondate,patientcode,patientname,visitcode,billnumber,particulars,fxamount,auto_number from master_transactionpaylater where accountnameano='$res21accountnameano' and accountnameid='$res21accountid' and transactiontype = 'finalize' and transactiondate between '$ADate1' and '$ADate2' and fxamount <> '0'  order by auto_number desc";
		// $query1 = "SELECT subtypeano,accountname,subtype,transactiondate,patientcode,patientname,visitcode,billnumber,particulars,fxamount,auto_number from master_transactionpaylater where accountnameano='$res21accountnameano' and accountnameid='$res21accountid' and billnumber IN (select billno from billing_ip where billdate between '$ADate1' and '$ADate2' UNION ALL SELECT billno from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' UNION ALL SELECT billno from billing_paylater where billdate between '$ADate1' and '$ADate2') and transactiontype = 'finalize' and fxamount <> '0'  order by auto_number desc";
		// $query1 = "SELECT subtypeano,accountname,subtype,transactiondate,patientcode,patientname,visitcode,billnumber,particulars,fxamount,auto_number from master_transactionpaylater where accountnameano='$res21accountnameano' and accountnameid='$res21accountid' and visitcode IN (select visitcode from billing_ip  UNION ALL SELECT visitcode from billing_ipcreditapproved  UNION ALL select visitcode from master_visitentry) and transactiontype = 'finalize' and fxamount <> '0' and transactiondate between '$ADate1' and '$ADate2' order by auto_number desc";
			 
			// working op credits

			// 
		$query1 = "SELECT subtypeano,accountname,subtype,transactiondate,patientcode,patientname,visitcode,billnumber,particulars,fxamount,auto_number from master_transactionpaylater where accountnameano='$res21accountnameano' and accountnameid='$res21accountid' and visitcode IN 
				(select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and accountnameano <> '47' group by visitcode 
				UNION ALL SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' and accountnameano <> '47'  group by visitcode
				)
			and transactiontype = 'finalize' and fxamount <> '0'   order by auto_number desc";
		 // and visitcode in (select visitcode from master_visitentry)
			// UNION ALL select visitcode from master_visitentry where consultationdate between '$ADate1' and '$ADate2' group by visitcode)
			// and accountnameano='$res21accountnameano'
		// transactiondate between '$ADate1' and '$ADate2'
		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res2 = mysqli_fetch_array($exec1))
		  {
		 		$resamount=0;
				$res2transactionamount=0;			
				$res2transactiondate = $res2['transactiondate'];
				$res2visitcode = $res2['visitcode'];
				$res2billnumber = $res2['billnumber'];
				$anum = $res2['auto_number'];
				$exchange_rate=1;			
				$res2transactionamount = $res2['fxamount']/$exchange_rate;
				$totalbilling +=  $res2['fxamount'];	
				$totalpayment = 0;
				$res7sumtransactionamount =0;
				$res8sumtransactionamount=0;
				// $res2transactionamount = $res2transactionamount-$res7sumtransactionamount-$res8sumtransactionamount;
				$resamount = $res2transactionamount;
				if($resamount != '0')
				{
					$snocount = $snocount + 1;
					$totalamount1 = $totalamount1 + $res2transactionamount;
					$totalamount301 = $totalamount301 + $res2transactionamount;
				$closetotalamount1 = $closetotalamount1 + $res2transactionamount;
			$closetotalamount301 = $closetotalamount301 + $res2transactionamount;
			$res2transactionamount=0;
			$resamount=0;
			}
			$res2transactionamount=0;
			$resamount=0;
			$res5transactionamount=0;
			$respharmacreditpayment=0;
		}

// paynow consultation with paylater ////
// $query_pnphar="select SUM(consultation) as billamount1 from billing_consultation where  billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select visitcode from master_visitentry where accountname='$res21accountnameano' ) and accountname != 'CASH - HOSPITAL'";
// // $query_pnphar="select SUM(consultation) as billamount1 from billing_consultation where patientvisitcode in (select visitcode from master_visitentry where accountname='$res21accountnameano' and consultationdate between '$ADate1' and '$ADate2' group by visitcode )";
// $exec_pnphar = mysql_query($query_pnphar) or die ("Error in Query_pnphar".mysql_error());
// 			$res_pnphar = mysql_fetch_array($exec_pnphar) ;
// 		    $res_pnpharrate = $res_pnphar['billamount1'];

// 		    $closetotalamount301 = $closetotalamount301 + $res_pnpharrate;
// 		  	$totalamount301 = $totalamount301+$res_pnpharrate;

// // paynow pharmacy with paylater////
// $query_pd="select sum(fxamount) as amount1 from billing_paynowpharmacy  where  billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select visitcode from master_visitentry where accountname='$res21accountnameano' ) and accountname != 'CASH - HOSPITAL'";
// // $query_pd="select sum(fxamount) as amount1 from billing_paynowpharmacy where patientvisitcode in (select visitcode from master_visitentry where accountname='$res21accountnameano' and consultationdate between '$ADate1' and '$ADate2' group by visitcode )";
// $exec_pd = mysql_query($query_pd) or die ("Error in Query_pd".mysql_error());
// 			$res_pd = mysql_fetch_array($exec_pd) ;
// 		    $res_pdrate = $res_pd['amount1'];
// 		    $closetotalamount301 = $closetotalamount301 + $res_pdrate;
// 		  	$totalamount301 = $totalamount301+$res_pdrate;

		  	//////// refunds ///////////////
		 //  	$query21p = "SELECT SUM(`amount`) as amount1 FROM `paylaterpharmareturns` WHERE  billdate between  '$ADate1' and '$ADate2' AND ledgercode <> '' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) where a.accountnameano='$res21accountnameano' and a.accountnameid='$res21accountid' and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`)";
			// $exec21p = mysql_query($query21p) or die ("Error in Query21p".mysql_error());
			// $res21p = mysql_fetch_array($exec21p) ;
		 //    $res21prefundlabitemrate = $res21p['amount1'];

		 //    $closetotalamount301 = $closetotalamount301 - $res21prefundlabitemrate;
		 //  	$totalamount301 = $totalamount301-$res21prefundlabitemrate;
		  	//////// refunds ///////////////

/////// Rebate ////////////
$query16 = "SELECT (1*amount) as rebate FROM `billing_ipnhif` where recorddate between '$ADate1' and '$ADate2' and accountcode='$res21accountid' ";
// and accountcode!='02-4500-1'
			$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num16=mysqli_num_rows($exec16);
			while($res16 = mysqli_fetch_array($exec16)){
			$rebateamount = $res16['rebate'];
			// $rebate += $rebateamount;
			$closetotalamount301 = $closetotalamount301 + $rebateamount;
		  	$totalamount301 = $totalamount301+$rebateamount;
		  }
		  // echo $rebate;
///// Rebate close DEPOSIT OPENS ///////////
		  $depositsip=0;
		$depositrefunds=0;
/*
				$query_depositsip = "SELECT (transactionamount) as amountuhx FROM `master_transactionipdeposit` WHERE visitcode in (select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and accountnameano = '$res21accountnameano' group by visitcode 
			UNION ALL SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' and accountnameano = '$res21accountnameano'  group by visitcode 
			UNION ALL SELECT visitcode from billing_paylater where billdate between '$ADate1' and '$ADate2' group by visitcode   
				)";
			$exec_depositsip = mysql_query($query_depositsip) or die ("Error in Query_depositsip".mysql_error());
			$num_depositsip=mysql_num_rows($exec_depositsip);
			while($res_depositsip = mysql_fetch_array($exec_depositsip)){
			$depositsip += $res_depositsip['amountuhx'];
			// $rebate += $rebateamount;
			// $closetotalamount301 = $closetotalamount301 + $depositsip;
		  	// $totalamount301 = $totalamount301+$depositsip;
		  }
		  ///// DEPOSIT CLOSESE AND REFUNDS DEPOSIT  ///////////
		  $query_depositrefunds = "SELECT  sum(amount) AS amount from deposit_refund WHERE visitcode in (select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and accountnameano = '$res21accountnameano' and accountnameano!='47' group by visitcode 
			UNION ALL SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' and accountnameano = '$res21accountnameano' and accountnameano!='47'  group by visitcode  
			UNION ALL SELECT visitcode from billing_paylater where billdate between '$ADate1' and '$ADate2' group by visitcode  
				)";
			$exec_depositrefunds = mysql_query($query_depositrefunds) or die ("Error in Query_depositrefunds".mysql_error());
			$num_depositrefunds=mysql_num_rows($exec_depositrefunds);
			while($res_depositrefunds = mysql_fetch_array($exec_depositrefunds)){
			$depositrefunds += $res_depositrefunds['amount'];
			// $rebate += $rebateamount;
			// $closetotalamount301 = $closetotalamount301 - $depositrefunds;
		  	// $totalamount301 = $totalamount301-$depositrefunds;
		  }
*/
		  // $total_depositsip_accounts=0;

		  $query_debitnotes = "SELECT (-1*deposit) as amountuhx FROM `billing_ip` WHERE   billdate between '$ADate1' and '$ADate2' and accountnameano = '$res21accountnameano' and accountnameid='$res21accountid' 
		  		union all SELECT (-1*deposit) as amountuhx FROM `billing_ipcreditapproved` WHERE   billdate between '$ADate1' and '$ADate2' and accountnameano = '$res21accountnameano' and accountnameid='$res21accountid' 
		  ";
			$exec_debitnotes = mysqli_query($GLOBALS["___mysqli_ston"], $query_debitnotes) or die ("Error in Query_debitnotes".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num_debitnotes=mysqli_num_rows($exec_debitnotes);
			while($res_debitnotes = mysqli_fetch_array($exec_debitnotes)){
			$depositsip += $res_debitnotes['amountuhx'];
			// $rebate += $rebateamount;
			// $closetotalamount301 = $closetotalamount301 + (-1*$debitnotes);
		  	// $totalamount301 = $totalamount301+(-1*$debitnotes);
		  }
		  // $depositsip= (-1*$depositsip);

		  //  $query_debitnotes = "SELECT (-1*deposit) as amountuhx FROM `billing_ip` WHERE  visitcode in (select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and accountnameano = '$res21accountnameano'  group by visitcode 
			// UNION ALL SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' and accountnameano = '$res21accountnameano'  group by visitcode  
			// 	) and accountnameano!='47'";
// $query_pd="SELECT sum(transactionamount) as pvtdoc from billing_ipprivatedoctor where visitcode IN (select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and accountnameano = '$res21accountnameano' group by visitcode ) ";
// // and docno NOT IN (SELECT billnumber from master_transactionpaylater )
// // $query_pd="SELECT sum(transactionamount) as pvtdoc from billing_ipprivatedoctor where  recorddate between '$ADate1' and '$ADate2' and visitcode IN (select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2'  group by visitcode  UNION ALL SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' group by visitcode  UNION ALL select visitcode from master_visitentry where consultationdate between '$ADate1' and '$ADate2' group by visitcode) and coa='$res21accountid' ";
// $exec_pd = mysql_query($query_pd) or die ("Error in Query_pd".mysql_error());
// 			$res_pd = mysql_fetch_array($exec_pd) ;
// 		   echo $res_pdrate = $res_pd['pvtdoc'];

// 		    $closetotalamount301 = $closetotalamount301 + $res_pdrate;
// 		  	$totalamount301 = $totalamount301+$res_pdrate;

//  $query1 = "select subtypeano,accountname,subtype,transactiondate,patientcode,patientname,visitcode,billnumber,particulars,transactionamount as fxamount,auto_number from master_transactionpaylater where accountnameano='$res21accountnameano' and accountnameid='$res21accountid' and transactiontype = 'finalize' and transactiondate between '$ADate1' and '$ADate2' and billnumber like 'AOP%' order by auto_number desc";

// 		  $exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());

// 		  while($res2 = mysql_fetch_array($exec1))

// 		  {

// 		 		$resamount=0;

// 				$res2transactionamount=0;

				

// 				$res2transactiondate = $res2['transactiondate'];

// 				$res2visitcode = $res2['visitcode'];

// 				$res2billnumber = $res2['billnumber'];

// 				$anum = $res2['auto_number'];



// 				$exchange_rate=1;

				

// 				$res2transactionamount = $res2['fxamount']/$exchange_rate;

			

// 				$totalpayment = 0;

				

				

// 				$res7sumtransactionamount =0;

// 				$res8sumtransactionamount=0;

// 				$res2transactionamount = $res2transactionamount-$res7sumtransactionamount-$res8sumtransactionamount;

				

// 				$resamount = $res2transactionamount - $totalpayment;

				

// 				if($resamount != '0')

// 				{

// 					$snocount = $snocount + 1;

					

		 			

// 			$totalamount1 = $totalamount1 + $res2transactionamount;

// 			$totalamount301 = $totalamount301 + $resamount;

			

// 			$closetotalamount1 = $closetotalamount1 + $res2transactionamount;

// 			$closetotalamount301 = $closetotalamount301 + $resamount;

			

// 			$res2transactionamount=0;

// 			$resamount=0;

// 			}

// 			$res2transactionamount=0;

// 			$resamount=0;

			

			

// 				$res5transactionamount=0;

// 				$respharmacreditpayment=0;

				

// }





// $query2 = "SELECT b.`docno` as docno, b.`transactionamount` as fxamount, b.`transactiondate` as transactiondate  FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE b.`accountnameid` = '$res21accountid' and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number` AND b.`transactiondate` BETWEEN '$ADate1' AND '$ADate2'";

// 	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());

// 		  while($res3 = mysql_fetch_array($exec2))

// 		  {

// 		 		$resamount=0;

// 				$res3transactionamount=0;

				

// 				$res3transactiondate = $res3['transactiondate'];

// 				$res3docno = $res3['docno'];

// 				$exchange_rate=1;

				

// 				 $res3transactionamount = $res3['fxamount']/$exchange_rate;

			

// 				$totalpayment = 0;

								

// 				$res7sumtransactionamount =0;

// 				$res8sumtransactionamount=0;

// 				$res3transactionamount = $res3transactionamount-$res7sumtransactionamount-$res8sumtransactionamount;

				

// 				$resamount = $res3transactionamount - $totalpayment;

				

// 				if($resamount != '0')

// 				{

// 					$snocount = $snocount + 1;

					

// 			 $totalamount1 = $totalamount1 - $res3transactionamount;

// 			$totalamount301 = $totalamount301 - $resamount;

			

// 			$closetotalamount1 = $closetotalamount1 - $res3transactionamount;

// 			$closetotalamount301 = $closetotalamount301 - $resamount;

			

// 			$res3transactionamount=0;

// 			$resamount=0;

// 			}

// 			$res3transactionamount=0;

// 			$resamount=0;

			

			

// 				$res5transactionamount=0;

// 				$respharmacreditpayment=0;

				

// }


		  // discount
		  
		//   $querysearchnew = "select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and accountnameano = '$res21accountnameano'   UNION ALL SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1'  and '$ADate2' and accountnameano = '$res21accountnameano' ";

		// $query17 = " SELECT sum(1*rate) as income FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `master_transactionip` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' and accountnameano = '$res21accountnameano' and accountnameid='$res21accountid'  group by billnumber) and patientvisitcode IN ($querysearchnew)
		// 	UNION ALL SELECT sum(1*rate) as income FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `billing_ipcreditapprovedtransaction` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and accountnameano = '$res21accountnameano' group by billno) and patientvisitcode IN ($querysearchnew)
		// 	";
		// 	$exec17 = mysql_query($query17) or die ("Error in Query17".mysql_error());
		// 	$num17=mysql_num_rows($exec17);
		// 	while($res17 = mysql_fetch_array($exec17)){
		// 	$disocuntamount = $res17['income'];
		// 	// $disocuntamount += $res17['income'];
		// 	$closetotalamount301 = $closetotalamount301 - $disocuntamount;
		//   	$totalamount301 = $totalamount301-$disocuntamount;
		//   }


///// discount close////////////


//  $query3 = "SELECT `billnumber` as docno, `fxamount` as fxamount, `transactiondate` as transactiondate  from master_transactionpaylater where accountnameano='$res21accountnameano'  and accountnameid='$res21accountid' and transactiontype = 'paylatercredit' and recordstatus <> 'deallocated' and transactiondate between '$ADate1' and '$ADate2'";

 

// 	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());

// 		  while($res4 = mysql_fetch_array($exec3))

// 		  {

// 		 		$resamount=0;

// 				$res4transactionamount=0;

				

// 				$res4transactiondate = $res4['transactiondate'];

// 				$res4docno = $res4['docno'];

// 				$exchange_rate=1;

				

// 				 $res4transactionamount = $res4['fxamount']/$exchange_rate;

			

// 				$totalpayment = 0;

						

// 				$res7sumtransactionamount =0;

// 				$res8sumtransactionamount=0;

// 				$res4transactionamount = $res4transactionamount-$res7sumtransactionamount-$res8sumtransactionamount;

				

// 				$resamount = $res4transactionamount - $totalpayment;

				

// 				if($resamount != '0')

// 				{

// 					$snocount = $snocount + 1;

					

// 			//echo $res4transactionamount;

// 			 $totalamount1 = $totalamount1 - $res4transactionamount;

// 			$totalamount301 = $totalamount301 - $resamount;

			

// 			$closetotalamount1 = $closetotalamount1 - $res4transactionamount;

// 			$closetotalamount301 = $closetotalamount301 - $resamount;

			

// 			$res4transactionamount=0;

// 			$resamount=0;

// 			}

// 			$res4transactionamount=0;

// 			$resamount=0;

			

// 				$res5transactionamount=0;

// 				$respharmacreditpayment=0;

				

// }

	$closetotalamount1 =$closetotalamount1 +$openingbalance;

	$closetotalamount301=$closetotalamount301 + $openingbalance;

		

		$totalamount1 =$totalamount1+$openingbalance;

		$totalamount301=$totalamount301 + $openingbalance;

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

	

			?>

           

           <tr <?php echo $colorcode; ?>>

		   <td class="bodytext31" valign="center"  align="left"><?=$sno++;?></td>

                <td class="bodytext31" valign="center"  align="left" 

                ><a href="revenuedetailed_account.php?accid=<?=$res21accountid?>&&fromdate=<?=$ADate1?>&&todate=<?=$ADate2?>" target="_blank"><?php echo $res22accountname; ?></a></td>

                <td class="bodytext31" valign="center"  align="right" ><?php echo number_format($closetotalamount301,2,'.',','); ?></td>
                <?php $deposit=$depositsip-$depositrefunds; 
                $total_depositsip_accounts+=$deposit;
                ?>
                <td class="bodytext31" valign="center"  align="right" ><?php echo number_format($deposit,2,'.',','); ?></td>

            </tr>

            <?php
            

			$closetotalamount1 = '0';

			$closetotalamount301 = '0';

			}

			$totalamount30=0;

			$totalamount60=0;

			$totalamount90=0;

			$totalamount120=0;

			$totalamount180=0;

			$totalamount210=0;

			}

			}

			?>

			</tbody>

            <tr onClick="showsub(<?=$subtypeanum?>)">

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="center" 

                bgcolor="#ecf0f5"><strong>Total:</strong></td>

              <td class="bodytext31" valign="center"  align="right"  bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount301,2,'.',','); ?></strong></td>
              <td class="bodytext31" valign="center"  align="right"  bgcolor="#ecf0f5"><strong><?php echo number_format($total_depositsip_accounts,2,'.',','); ?></strong></td>

            </tr>

			<tr>

			<?php

			$total_depositsip+=$total_depositsip_accounts;

			$grandtotalamount1 += $totalamount1;

				$grandtotalamount301 += $totalamount301;

			$total_depositsip_accounts = "0.00";
			$totalamount1 = "0.00";

			$totalamount301 = "0.00";

				$urlpath = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&searchsuppliername=$searchsuppliername&&searchsuppliername1=$searchsuppliername1&&type=$type1&&searchsubtypeanum1=$searchsubtypeanum1";	

				

			?>

			 <td colspan="2"></td>

		   	<td class="bodytext31" valign="center"  align="right"></td>

			</tr>     

			   <?php

			   } }

			   ?>

			   <tr >

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="center" 

                bgcolor="#ecf0f5"><strong>Grand Total:</strong></td>

              <td class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotalamount301,2,'.',','); ?></strong></td>
              <td class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($total_depositsip,2,'.',','); ?></strong></td>

            </tr>

			<a href="print_revenuereport_summary.php?<?php echo $urlpath; ?>"><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;"></a>

			<?php

			
// echo $disocuntamount;
			}

			   ?>

          </tbody>

        </table></td>

      </tr>

	  

    </table>

</table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>


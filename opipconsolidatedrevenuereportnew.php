<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('d-m-Y');

$paymentreceiveddateto = date('d-m-Y');



$colorloopcount = '';

$sno = '';

$snocount = '';

$visitcode1 = '';

$total = '0.00';

$cashamount1='';

$cashamount='';

$sumunfinal='0.00';

$cashamount5='';

$totalopcash='';

$totalipcash='';

$testcashamount='';

$searchsuppliername = "";

$overaltotalrefund='';



if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{

	//$cbsuppliername = $_REQUEST['cbsuppliername'];

	//$suppliername = $_REQUEST['cbsuppliername'];

	$paymentreceiveddatefrom =$_REQUEST["ADate1"];

	$paymentreceiveddateto = $_REQUEST["ADate2"];

}



if (isset($_REQUEST["ADate1"])) { $ADate1 = date("Y-m-d", strtotime($_REQUEST["ADate1"])); } else { $ADate1 = ""; }



//$paymenttype = $_REQUEST['paymenttype'];

if (isset($_REQUEST["ADate2"])) { $ADate2 = date("Y-m-d", strtotime($_REQUEST["ADate2"])); } else { $ADate2 = ""; }

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

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<script language="javascript">



function cbsuppliername1()

{

	document.cbform1.submit();

}



</script>

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

-->

</style>



</head>



<script src="js/datetimepicker_css.js"></script>



<body>

<table width="1900" border="0" cellspacing="0" cellpadding="2">

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

    <td colspan="9">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860">

		

		

              <form name="cbform1" method="post" action="opipconsolidatedrevenuereportnew.php">

                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                  <tbody>

                    <tr bgcolor="#011E6A">

                      <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>OP/IP Consolidated Revenue Report </strong></td>

                      <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->

                      <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">&nbsp;</td>

                    </tr>

                    <tr>

                      <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF"> <strong>Date From</strong> </td>

                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1', 'DDMMYYYY')" style="cursor:pointer"/> </td>

                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><strong> Date To</strong> </td>

                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">

                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2', 'DDMMYYYY')" style="cursor:pointer"/> </span></td>

                    </tr>

                    <tr>

                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                          <input  type="submit" value="Search" name="Submit" />

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

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="600" 

            align="left" border="0">

          <tbody>

	<?php

	$sumpackage=0.00;

	$sumpharmacy=0.00;

	$sumlab=0.00;

	$sumrad=0.00;

	$sumservice=0.00;

	$sumtransaction='';

	$ipfinalizedamount='';

	$refundamount=0.00;

	$sumbed=0.00;

		

	if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

	if ($cbfrmflag1 == 'cbfrmflag1')

	{

		$i = 0;

	$drresult = array();

	

	$j = 0;

	$crresult = array();


	$querycr1 = "SELECT SUM(`consultation`) as income FROM `billing_consultation` WHERE billdate BETWEEN '$ADate1' AND
				'$ADate2' and accountname = 'CASH - HOSPITAL'	
				
				UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowlab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
				

				UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
				

				UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
				


				UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and accountname = 'CASH - HOSPITAL'
				


				UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
				

				UNION ALL select sum(amount) as income from billing_homecare where recorddate between '$ADate1' and '$ADate2'

				UNION ALL select sum(servicesitemrate) as income from billing_externalservices where  billdate between '$ADate1' and '$ADate2'
				UNION ALL select sum(radiologyitemrate) as income from billing_externalradiology where billdate between '$ADate1' and '$ADate2'
				UNION ALL select sum(labitemrate) as income from billing_externallab where billdate between '$ADate1' and '$ADate2'
				UNION ALL select sum(amount) as income from billing_externalpharmacy where billdate between '$ADate1' and '$ADate2'
					"; 

	// $querycr1 = "SELECT SUM(`consultation`) as income FROM `billing_consultation` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and accountname = 'CASH - HOSPITAL'

	// 			UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowlab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' 

	// 			UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowpharmacy` WHERE ledgercode <> '' AND billdate BETWEEN '$ADate1' AND '$ADate2' and accountname = 'CASH - HOSPITAL'

	// 			UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'

	// 			UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paynowservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'

	// 			UNION ALL SELECT SUM(`cashamount`) as income FROM `billing_paynowreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'

	// 			UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_referal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'

				

	// 			UNION ALL SELECT SUM(`labitemrate`) as income FROM `billing_externallab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'

	// 			UNION ALL SELECT SUM(`amount`) as income FROM `billing_externalpharmacy` WHERE ledgercode <> '' AND billdate BETWEEN '$ADate1' AND '$ADate2'

	// 			UNION ALL SELECT SUM(`radiologyitemrate`) as income FROM `billing_externalradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'

	// 			UNION ALL SELECT SUM(`servicesitemrate`) as income FROM `billing_externalservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'

				

	// 			UNION ALL SELECT SUM(-1*`labitemrate`) as income FROM `refund_paynowlab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'

	// 			UNION ALL SELECT SUM(-1*`amount`) as income FROM `refund_paynowpharmacy` WHERE ledgercode <> '' AND billdate BETWEEN '$ADate1' AND '$ADate2'

	// 			UNION ALL SELECT SUM(-1*`referalrate`) as income FROM `refund_paynowreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'

	// 			UNION ALL SELECT SUM(-1*`radiologyitemrate`) as income FROM `refund_paynowradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'

	// 			UNION ALL SELECT SUM(-1*`serviceamount`) as income FROM `refund_paynowservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'

	// 			UNION ALL SELECT SUM(-1*`consultation`) as income FROM `refund_consultation` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'

	// 			UNION ALL SELECT SUM(-1*`consultationfxamount`) as income FROM `billing_patientweivers` WHERE accountnameano = '1107' and entrydate BETWEEN '$ADate1' AND '$ADate2'

	// 			UNION ALL SELECT SUM(-1*`labfxamount`) as income FROM `billing_patientweivers` WHERE accountnameano = '1107' and entrydate BETWEEN '$ADate1' AND '$ADate2'

	// 			UNION ALL SELECT SUM(-1*`radiologyfxamount`) as income FROM `billing_patientweivers` WHERE accountnameano = '1107' and entrydate BETWEEN '$ADate1' AND '$ADate2'

	// 			UNION ALL SELECT SUM(-1*`servicesfxamount`) as income FROM `billing_patientweivers` WHERE accountnameano = '1107' and entrydate BETWEEN '$ADate1' AND '$ADate2'

	// 			UNION ALL SELECT SUM(-1*`pharmacyfxamount`) as income FROM `billing_patientweivers` WHERE accountnameano = '1107' and entrydate BETWEEN '$ADate1' AND '$ADate2'";

	$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($rescr1 = mysqli_fetch_array($execcr1))

	{

	$j = $j+1;
	//print_r($resdr1);
	$crresult[$j] = $rescr1['income'];
	//$paylater = $result[$i];
	}	

	/////////////////// op refunds ////////////////////
	$oprefunds =0;
	$querycr1 = "SELECT sum(1*consultation) as income from refund_consultation where billdate between '$ADate1' and '$ADate2'
				UNION ALL select sum(1*fxamount) as income from refund_paylaterconsultation where billdate between '$ADate1' and '$ADate2'
				UNION ALL select sum(1*consultationfxamount) as income from billing_patientweivers where entrydate between '$ADate1' and '$ADate2'

UNION ALL  select sum(1*labitemrate) as income from refund_paylaterlab where billdate between '$ADate1' and '$ADate2'
				UNION ALL select sum(1*labitemrate) as income from refund_paynowlab where billdate between '$ADate1' and '$ADate2'
				UNION ALL select sum(1*labfxamount) as income from billing_patientweivers where entrydate between '$ADate1' and '$ADate2'
UNION ALL select sum(1*fxamount) as income from refund_paylaterradiology where billdate between '$ADate1' and '$ADate2'
				UNION ALL select sum(1*radiologyitemrate) as income from refund_paynowradiology where billdate between '$ADate1' and '$ADate2'
				UNION ALL select sum(1*radiologyfxamount) as income from billing_patientweivers where entrydate between '$ADate1' and '$ADate2'

UNION ALL select sum(1*fxamount) as income from refund_paylaterservices where billdate between '$ADate1' and '$ADate2'
				UNION ALL select sum(1*servicetotal) as income from refund_paynowservices where billdate between '$ADate1' and '$ADate2'
				UNION ALL select sum(1*servicesfxamount) as income from billing_patientweivers where entrydate between '$ADate1' and '$ADate2'
UNION ALL select sum(1*amount)as income from refund_paylaterpharmacy where billdate between '$ADate1' and '$ADate2'
				UNION ALL select sum(1*amount)as income from refund_paynowpharmacy where billdate between '$ADate1' and '$ADate2'
				UNION ALL select sum(1*pharmacyfxamount) as income from billing_patientweivers where entrydate between '$ADate1' and '$ADate2'
				UNION ALL SELECT SUM(1*`amount`) as income FROM `paylaterpharmareturns` WHERE billdate between  '$ADate1' and '$ADate2' AND ledgercode <> '' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`)
UNION ALL select sum(1*referalrate)as income from refund_paylaterreferal where billdate between '$ADate1' and '$ADate2'
				UNION ALL select sum(1*referalrate)as income from refund_paynowreferal where billdate between '$ADate1' and '$ADate2'
				";
				$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($rescr1 = mysqli_fetch_array($execcr1))
	{
	$oprefunds += $rescr1['income'];
	}	

	/////////////////// op refunds ////////////////////

	//echo "total ".array_sum($crresult)." and ".array_sum($drresult);

	$totalopcash = array_sum($crresult);
// 	$res2consultationamount=0;
// $res8pharmacyitemrate=0;

// $query1 = "select SUM(totalamount) AS billamount1 from billing_paylaterconsultation where  billdate between '$ADate1' and '$ADate2' and accountname != 'CASH - HOSPITAL' and visitcode in (select visitcode from master_visitentry )
// 			UNION ALL
// 			select SUM(consultation) as billamount1 from billing_consultation where  billdate between '$ADate1' and '$ADate2' and accountname != 'CASH - HOSPITAL' and patientvisitcode in (select visitcode from master_visitentry)";
// 			$exec1 = mysql_query($query1) or die ("Error in query1".mysql_error());

// 			while($res1 = mysql_fetch_array($exec1)){;

// 			$res1billamount = $res1['billamount1'];
// 			$res2consultationamount = $res2consultationamount + $res1billamount;

// 			}

// 			$query8 = "select SUM(fxamount) AS  amount1 from billing_paylaterpharmacy where billdate between '$ADate1' and '$ADate2' and accountname != 'CASH - HOSPITAL' and patientvisitcode in (select visitcode from master_visitentry)

// 				UNION ALL

// 				select SUM(fxamount) AS  amount1 from billing_paynowpharmacy where billdate between '$ADate1' and '$ADate2' and accountname != 'CASH - HOSPITAL' and patientvisitcode in (select visitcode from master_visitentry )";
// 			$exec8 = mysql_query($query8) or die ("Error in query8".mysql_error());

// 			while($res8 = mysql_fetch_array($exec8)){

// 			$res8pharmacyamount = $res8['amount1'];
// 			$res8pharmacyitemrate =$res8pharmacyitemrate + $res8pharmacyamount;

			
// 			}

// op credit
	 // $querycr11 = "
	 // SELECT SUM(totalamount) AS income from billing_paylaterconsultation where  billdate between  '$ADate1' and '$ADate2' and accountname != 'CASH - HOSPITAL' and visitcode in (select visitcode from master_visitentry )
		// 			UNION ALL select SUM(consultation) as income from billing_consultation where  billdate between '$ADate1' and '$ADate2' and accountname != 'CASH - HOSPITAL' and patientvisitcode in (select visitcode from master_visitentry)"
			// UNION ALL select SUM(fxamount) AS  amount1 from billing_paylaterpharmacy where billdate between '$ADate1' and '$ADate2' and accountname != 'CASH - HOSPITAL' and patientvisitcode in (select visitcode from master_visitentry)
			// 	UNION ALL select SUM(fxamount) AS  amount1 from billing_paynowpharmacy where billdate between '$ADate1' and '$ADate2' and accountname != 'CASH - HOSPITAL' and patientvisitcode in (select visitcode from master_visitentry )
			// SELECT SUM(`fxamount`) as income FROM `billing_paylaterlab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'

$querycr11 = "SELECT SUM(totalamount) AS income from billing_paylaterconsultation where  billdate between  '$ADate1' and '$ADate2' and accountname != 'CASH - HOSPITAL' and visitcode in (select visitcode from master_visitentry )
					UNION ALL select SUM(consultation) as income from billing_consultation where  billdate between '$ADate1' and '$ADate2' and accountname != 'CASH - HOSPITAL' and patientvisitcode in (select visitcode from master_visitentry)

				UNION ALL select SUM(fxamount) AS  amount1 from billing_paylaterpharmacy where billdate between '$ADate1' and '$ADate2' and accountname != 'CASH - HOSPITAL' and patientvisitcode in (select visitcode from master_visitentry)
				UNION ALL select SUM(fxamount) AS  amount1 from billing_paynowpharmacy where billdate between '$ADate1' and '$ADate2' and accountname != 'CASH - HOSPITAL' and patientvisitcode in (select visitcode from master_visitentry )


				UNION ALL SELECT  sum(labitemrate) as income from billing_paylaterlab where billdate between '$ADate1' and '$ADate2' and accountname != 'CASH - HOSPITAL'

				UNION ALL SELECT SUM(`radiologyitemrate`) as income FROM `billing_paylaterradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and accountname != 'CASH - HOSPITAL'

				UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_paylaterservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' 

				UNION ALL SELECT SUM(`referalrate`) as income FROM `billing_paylaterreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'

				UNION ALL SELECT SUM(`amount`) as income FROM `billing_opambulancepaylater` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'

				UNION ALL SELECT SUM(`amount`) as income FROM `billing_homecarepaylater` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'

				
				";


			 
				// -- UNION ALL SELECT SUM(`fxamount`) as income FROM `billing_referal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'

				

				// -- UNION ALL SELECT SUM(-1*`fxamount`) as income FROM `refund_paylaterconsultation` WHERE  billdate BETWEEN '$ADate1' AND '$ADate2'

				// -- UNION ALL SELECT SUM(-1*`fxamount`) as income FROM `refund_paylaterlab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'

				// -- UNION ALL SELECT SUM(-1*`amount`) as income FROM `refund_paylaterpharmacy` WHERE ledgercode <> '' AND billdate BETWEEN '$ADate1' AND '$ADate2'

				// -- UNION ALL SELECT SUM(-1*`fxamount`) as income FROM `refund_paylaterreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'

				// -- UNION ALL SELECT SUM(-1*`fxamount`) as income FROM `refund_paylaterradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'

				// -- UNION ALL SELECT SUM(-1*`fxamount`) as income FROM `refund_paylaterservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'

				// -- UNION ALL SELECT SUM(-1*`amount`) as incomedebit FROM `paylaterpharmareturns` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' AND ledgercode <> '' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`)

				

				// -- UNION ALL SELECT SUM(-1*`consultationfxamount`) as income FROM `billing_patientweivers` WHERE accountnameano <> '1107' and entrydate BETWEEN '$ADate1' AND '$ADate2'

				// -- UNION ALL SELECT SUM(-1*`labfxamount`) as income FROM `billing_patientweivers` WHERE accountnameano <> '1107' and entrydate BETWEEN '$ADate1' AND '$ADate2'

				// -- UNION ALL SELECT SUM(-1*`radiologyfxamount`) as income FROM `billing_patientweivers` WHERE accountnameano <> '1107' and entrydate BETWEEN '$ADate1' AND '$ADate2'

				// -- UNION ALL SELECT SUM(-1*`servicesfxamount`) as income FROM `billing_patientweivers` WHERE accountnameano <> '1107' and entrydate BETWEEN '$ADate1' AND '$ADate2'

				// -- UNION ALL SELECT SUM(-1*`pharmacyfxamount`) as income FROM `billing_patientweivers` WHERE accountnameano <> '1107' and entrydate BETWEEN '$ADate1' AND '$ADate2'


	$execcr11 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr11) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($rescr11 = mysqli_fetch_array($execcr11))

	{

	$j = $j+1;

	//print_r($resdr1);

	$crresult1[$j] = $rescr11['income'];

	//$paylater = $result[$i];

	}	

	//echo "total ".array_sum($crresult)." and ".array_sum($drresult);

	 $totalopcrdt = array_sum($crresult1);

	 // $totalopcrdt=$totalopcrdt+$res2consultationamount+$res8pharmacyitemrate;


	//$balance = ($paylater + $ippaylater + $nhif + $opening); //- ($credit + $refund + $receipt);

	$cashamount5 = $totalopcrdt;

	

$totalbedcharges='0.00';

$labtotal = "0.00";

$totalradiologyitemrate = "0.00";

$totalservicesitemrate = "0.00";

$totalprivatedoctoramount = "0.00";

$totalpharmacysaleamount = "0.00";

$totalpharmacysalereturnamount = "0.00";

$totalambulanceamount = "0.00";

$totalipmis = "0.00";

$totaldiscountrate = "0.00";

$totalnhifamount = "0.00";

$totalipdepositamount = "0.00";

$totalbedcharges = "0.00";

$totalbedtransfercharges = "0.00";

$totalpackage = "0.00";

$totaladmncharges = "0.00";

$ipunfinalizeamount='';

$ipfinalizedamount='';



						$j = 0;

	$crresultcash = array();

///////////// IP CASH ////////////////

	$admissionamount          = 0.00;
$ipdiscountamount         = 0.00;
$totaladmissionamount     = 0.00;
$totallabamount           = 0.00;
$totalpharmacyamount      = 0.00;
$totalradiologyamount     = 0.00;
$totalservicesamount      = 0.00;
$totalambulanceamount     = 0.00;
$totalprivatedoctoramount = 0.00;
$totalipbedcharges        = 0.00;
$totalipnursingcharges    = 0.00;
$totaliprmocharges        = 0.00;
$totaliprmocharges1       = 0.00;
$totalipdiscountamount    = 0.00;
$totalipmiscamount        = 0.00;
$totalipdiscamount        = 0.00;
$totaltransactionamount   = 0.00;
$colorcode                = '';
$transactionamount        = 0.00;
$totalhospitalrevenue     = '0.00';
$totalpackagecharge       = 0.00;
$totalhomecareamount      = 0.00;
$totalotamount            = 0.00;
$totaliprefundamount      = 0.00;
$totalnhifamount          = 0.00;
$bedchgsdiscount          = 0;
$labchgsdiscount          = 0;
$nursechgsdiscount        = 0;
$pharmachgsdiscount       = 0;
$radchgsdiscount          = 0;
$rmochgsdiscount          = 0;
$servchgsdiscount         = 0;
$totbedchgdisc            = 0;
$totlabchgdisc            = 0;
$totnursechgdisc          = 0;
$totpharmachgdisc         = 0;
$totradchgdisc            = 0;
$totrmochgdisc            = 0;
$totservchgdisc           = 0;
$brfbedchgsdiscount       = 0;
$brflabchgsdiscount       = 0;
$brfnursechgsdiscount     = 0;
$brfpharmachgsdiscount    = 0;
$brfradchgsdiscount       = 0;
$brfrmochgsdiscount       = 0;
$brfservchgsdiscount      = 0;
$rebate                   = 0;
$totbrfbeddisc            = 0;
$totbrflabdisc            = 0;
$totbrfnursedisc          = 0;
$totbrfpharmadisc         = 0;
$totbrfraddisc            = 0;
$totbrfrmodisc            = 0;
$totbrfservdisc           = 0;
$totcreditnotebedchgs     = 0;
$totcreditnotelabchgs     = 0;
$totcreditnotenursechgs   = 0;
$totcreditnotepharmachgs  = 0;
$totcreditnoteradchgs     = 0;
$totcreditnotermochgs     = 0;
$totcreditnoteservchgs    = 0;
$totadmn                  = 0;
$totpkg                   = 0;
$totbed                   = 0;
$totnur                   = 0;
$totrmo                   = 0;
$totrmo1                  = 0;
$totlab                   = 0;
$totrad                   = 0;
$totpha                   = 0;
$totser                   = 0;
$totamb                   = 0;
$tothom                   = 0;
$totdr                    = 0;
$totmisc                  = 0;
$totothers                = 0;
$totdisc                  = 0;
$totrebate                = 0;
	$fromdate=$ADate1;
	$todate=$ADate2;
$query1 = "select  auto_number,patientname,patientcode,visitcode,'billing' as type  from billing_ip where   accountnameano = '47' and billdate between '$fromdate' and '$todate'
        UNION ALL 
     SELECT auto_number,patientname,patientcode,visitcode,'creditapproved' as type from billing_ipcreditapproved where   accountnameano = '47' and billdate between '$fromdate' and '$todate' group by visitcode  order by auto_number DESC ";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
$num1 = mysqli_num_rows($exec1);
while ($res1 = mysqli_fetch_array($exec1)) {
                $patientname = $res1['patientname'];
                $patientcode = $res1['patientcode'];
                $visitcode   = $res1['visitcode'];
                // if ($res1['type'] == 'billing') {
                                $query112 = "select sum(amountuhx) as amountuhx from billing_ipbedcharges where   description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and  visitcode='$visitcode'  and recorddate between '$fromdate' and '$todate' 

                  UNION ALL SELECT sum(fxamount) as amountuhx FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$todate' and billtype = 'PAY LATER' and description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and patientvisitcode='$visitcode'";
                // } else {
                   //              $query112 = "select sum(amountuhx) as amountuhx from billing_ipbedcharges where   description NOT IN  ('Bed Charges','Resident Doctor Charges','Ward Dispensing Charges') and  visitcode='$visitcode'  and recorddate between '$fromdate' and '$todate'

                   // UNION ALL SELECT  sum(fxamount) as amountuhx FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$todate' and billtype = 'PAY LATER' and description NOT IN ('Bed Charges','Resident Doctor Charges','Ward Dispensing Charges') and patientvisitcode='$visitcode' ";
                // }
                $exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die("Error in Query112" . mysqli_error($GLOBALS["___mysqli_ston"]));
                $num112             = mysqli_num_rows($exec112);
                $res112             = mysqli_fetch_array($exec112);
                $packagecharge      = $res112['amountuhx'];
                $totalpackagecharge = $totalpackagecharge + $packagecharge;
                $query2             = "select  amountuhx  from billing_ipadmissioncharge where  patientcode = '$patientcode' and visitcode='$visitcode'   and recorddate between '$fromdate' and '$todate'  ";
                $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query2" . mysqli_error($GLOBALS["___mysqli_ston"]));
                $num2                 = mysqli_num_rows($exec2);
                $res2                 = mysqli_fetch_array($exec2);
                $admissionamount      = $res2['amountuhx'];
                $totaladmissionamount = $totaladmissionamount + $admissionamount;
                $query3               = "select sum(rateuhx) from billing_iplab where  patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
                $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3" . mysqli_error($GLOBALS["___mysqli_ston"]));
                $num3           = mysqli_num_rows($exec3);
                $res3           = mysqli_fetch_array($exec3);
                $labamount      = $res3['sum(rateuhx)'];
                $totallabamount = $totallabamount + $labamount;
                $query4         = "select sum(radiologyitemrateuhx) from billing_ipradiology where  patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
                $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die("Error in Query4" . mysqli_error($GLOBALS["___mysqli_ston"]));
                $num4                 = mysqli_num_rows($exec4);
                $res4                 = mysqli_fetch_array($exec4);
                $radiologyamount      = $res4['sum(radiologyitemrateuhx)'];
                $totalradiologyamount = $totalradiologyamount + $radiologyamount;
                $query5               = "select sum(amountuhx) from billing_ippharmacy where  patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
                $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die("Error in Query5" . mysqli_error($GLOBALS["___mysqli_ston"]));
                $num5                = mysqli_num_rows($exec5);
                $res5                = mysqli_fetch_array($exec5);
                $pharmacyamount      = $res5['sum(amountuhx)'];
                $totalpharmacyamount = $totalpharmacyamount + $pharmacyamount;

                $query6              = "select sum(servicesitemrateuhx),sum(sharingamount) from billing_ipservices where  patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'";
                $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die("Error in Query6" . mysqli_error($GLOBALS["___mysqli_ston"]));
                $num6                = mysqli_num_rows($exec6);
                $res6                = mysqli_fetch_array($exec6);
                $servicesamount      = $res6['sum(servicesitemrateuhx)'] - $res6['sum(sharingamount)'];

                $totalservicesamount = $totalservicesamount + $servicesamount;
                $query8              = "select sum(amountuhx) from billing_ipambulance where  patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
                $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die("Error in Query8" . mysqli_error($GLOBALS["___mysqli_ston"]));
                $num8                 = mysqli_num_rows($exec8);
                $res8                 = mysqli_fetch_array($exec8);
                $ambulanceamount      = $res8['sum(amountuhx)'];
                $totalambulanceamount = $totalambulanceamount + $ambulanceamount;
                $query81              = "select sum(amount) from billing_iphomecare where  patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
                $exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die("Error in Query81" . mysqli_error($GLOBALS["___mysqli_ston"]));
                $num81               = mysqli_num_rows($exec81);
                $res81               = mysqli_fetch_array($exec81);
                $homecareamount      = $res81['sum(amount)'];
                $totalhomecareamount = $totalhomecareamount + $homecareamount;
                // $query8              = "select sum(transactionamount) from billing_ipprivatedoctor where  patientcode = '$patientcode' and visitcode='$visitcode' and billtype <>'' and recorddate between '$fromdate' and '$todate'  ";
                // $exec8 = mysql_query($query8) or die("Error in Query8" . mysql_error());
                // $num8                     = mysql_num_rows($exec8);
                // $res8                     = mysql_fetch_array($exec8);
                // $privatedoctoramount      = $res8['sum(transactionamount)'];
                // $totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctoramount;
                $query8              = "select (transactionamount) as transactionamount, (original_amt) as original_amt, visittype, coa from billing_ipprivatedoctor where  patientcode = '$patientcode' and visitcode='$visitcode' and billtype <>'' and recorddate between '$fromdate' and '$todate'  ";
                $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die("Error in Query8" . mysqli_error($GLOBALS["___mysqli_ston"]));
                $num8                     = mysqli_num_rows($exec8);
                while($res8 = mysqli_fetch_array($exec8)){
                		if($res8['visittype'] =="IP")
							{
								if($res8['coa'] !="")
								 $privatedoctoramount = $res8['transactionamount'];
								else
								 $privatedoctoramount = $res8['original_amt'];
							}
							else
							{
								$privatedoctoramount = $res8['original_amt'];
							}
			                // $privatedoctoramount      = $res8['sum(transactionamount)'];
			                $totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctoramount;
            		}


                
                $query9                   = "select sum(amountuhx) from billing_ipbedcharges where  patientcode = '$patientcode' and visitcode='$visitcode' and description = 'bed charges' and recorddate between '$fromdate' and '$todate' ";
                $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die("Error in Query9" . mysqli_error($GLOBALS["___mysqli_ston"]));
                $num9              = mysqli_num_rows($exec9);
                $res9              = mysqli_fetch_array($exec9);
                $ipbedcharges      = $res9['sum(amountuhx)'];
                $totalipbedcharges = $totalipbedcharges + $ipbedcharges;
                if ($res1['type'] == 'billing') {
                                $query10 = "select sum(amountuhx) as amount  from billing_ipbedcharges where   description='Nursing Charges' and  visitcode='$visitcode'  and recorddate between '$fromdate' and '$todate' 

          UNION ALL SELECT sum(fxamount) as amount   FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$todate' and billtype = 'PAY LATER' and description='Nursing Charges' and patientvisitcode='$visitcode'";
                } else {
                                $query10 = "select sum(amountuhx) as amount  from billing_ipbedcharges where   description='Nursing Charges' and  visitcode='$visitcode'  and recorddate between '$fromdate' and '$todate' 

           UNION ALL SELECT sum(fxamount) as amount  FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$todate' and billtype = 'PAY LATER' and description='Nursing Charges' and patientvisitcode='$visitcode'  ";
                }
                $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die("Error in Query10" . mysqli_error($GLOBALS["___mysqli_ston"]));
                $num10                 = mysqli_num_rows($exec10);
                $res10                 = mysqli_fetch_array($exec10);
                $ipnursingcharges      = $res10['amount'];
                $totalipnursingcharges = $totalipnursingcharges + $ipnursingcharges;
                $query11               = "select sum(amount) from billing_ipbedcharges where  patientcode = '$patientcode' and visitcode='$visitcode' and (description = 'Daily Review charge' or description = 'RMO Charges') and recorddate between '$fromdate' and '$todate' ";
                $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die("Error in Query11" . mysqli_error($GLOBALS["___mysqli_ston"]));
                $num11             = mysqli_num_rows($exec11);
                $res11             = mysqli_fetch_array($exec11);
                $iprmocharges      = $res11['sum(amount)'];
                $totaliprmocharges = $totaliprmocharges + $iprmocharges;
                $query111          = "select sum(amount) from billing_ipbedcharges where  patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Consultant Fee' and recorddate between '$fromdate' and '$todate' ";
                $exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die("Error in Query11" . mysqli_error($GLOBALS["___mysqli_ston"]));
                $num111             = mysqli_num_rows($exec111);
                $res111             = mysqli_fetch_array($exec111);
                $iprmocharges1      = $res111['sum(amount)'];
                $totaliprmocharges1 = $totaliprmocharges1 + $iprmocharges1;
                $query133           = "select sum(amount) from deposit_refund where  patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
                $exec133 = mysqli_query($GLOBALS["___mysqli_ston"], $query133) or die("Error in Query133" . mysqli_error($GLOBALS["___mysqli_ston"]));
                $num133              = mysqli_num_rows($exec133);
                $res133              = mysqli_fetch_array($exec133);
                $iprefundamount      = $res133['sum(amount)'];
                $totaliprefundamount = $totaliprefundamount + $iprefundamount;
                $query14             = "select sum(amount) from billing_ipmiscbilling where  patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
                $exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die("Error in Query14" . mysqli_error($GLOBALS["___mysqli_ston"]));
                $num14             = mysqli_num_rows($exec14);
                $res14             = mysqli_fetch_array($exec14);
                $ipmiscamount      = $res14['sum(amount)'];
                $totalipmiscamount = $totalipmiscamount + $ipmiscamount;
                $query149          = "select sum(-1*rate) as amount from ip_discount where  patientcode = '$patientcode' and patientvisitcode='$visitcode'  and consultationdate between '$fromdate' and '$todate' ";
                $exec149 = mysqli_query($GLOBALS["___mysqli_ston"], $query149) or die("Error in Query149" . mysqli_error($GLOBALS["___mysqli_ston"]));
                $num149            = mysqli_num_rows($exec149);
                $res149            = mysqli_fetch_array($exec149);
                $ipdiscamount      = $res149['amount'];
                $totalipdiscamount = $totalipdiscamount + $ipdiscamount;
                $query15           = "select patientname,patientcode,visitcode from billing_ipbedcharges where  patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
                $exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die("Error in Query15" . mysqli_error($GLOBALS["___mysqli_ston"]));
                $num15            = mysqli_num_rows($exec15);
                $res15            = mysqli_fetch_array($exec15);
                $res15patientname = $res1['patientname'];
                $res15patientcode = $res1['patientcode'];
                $res15visitcode   = $res1['visitcode'];
                $query12          = "select transactionamount,docno from master_transactionipdeposit where  patientcode = '$patientcode' and visitcode='$visitcode' and transactiondate between '$fromdate' and '$todate' ";
                $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die("Error in Query12" . mysqli_error($GLOBALS["___mysqli_ston"]));
                $num12 = mysqli_num_rows($exec12);
                while ($res12 = mysqli_fetch_array($exec12)) {
                                $transactionamount      = $res12['transactionamount'];
                                $referencenumber        = $res12['docno'];
                                $totaltransactionamount = $totaltransactionamount + $transactionamount;
                }
                $colorloopcount = $colorloopcount + 1;
                $showcolor      = ($colorloopcount & 1);
                if ($showcolor == 0) {
                                $colorcode = 'bgcolor="#CBDBFA"';
                } else {
                                $colorcode = 'bgcolor="#ecf0f5"';
                }
?>

<?php
}
$query16 = "SELECT sum(1*amount) as rebate FROM `billing_ipnhif` where recorddate between '$fromdate' and '$todate' and accountname = 'CASH - HOSPITAL'";
$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die("Error in Query16" . mysqli_error($GLOBALS["___mysqli_ston"]));
$num16        = mysqli_num_rows($exec16);
$res16        = mysqli_fetch_array($exec16);
$rebateamount = $res16['rebate'];
$rebate += $rebateamount;
$totrebate += $rebate;
$totadmn = $totadmn + $totaladmissionamount;
$totpkg  = $totpkg + $totalpackagecharge;
$totbed  = $totbed + $totalipbedcharges;
$totnur  = $totnur + $totalipnursingcharges;
$totrmo  = $totrmo + $totaliprmocharges;
$totrmo1 = $totrmo1 + $totaliprmocharges1;
$totlab  = $totlab + $totallabamount;
$totrad  = $totrad + $totalradiologyamount;
$totpha  = $totpha + $totalpharmacyamount;
$totser  = $totser + $totalservicesamount;
$totamb  = $totamb + $totalambulanceamount;
$tothom  = $tothom + $totalhomecareamount;
$totdr   = $totdr + $totalprivatedoctoramount;
$totmisc = $totmisc + $totalipmiscamount;
$totdisc = $totdisc + $totalipdiscamount;
 $ipcash_total = $totaladmissionamount + $totalpackagecharge + $totalipbedcharges + $totalipnursingcharges + $totaliprmocharges + $totaliprmocharges1 + $totallabamount + $totalradiologyamount + $totalpharmacyamount + $totalservicesamount + $totalambulanceamount + $totalhomecareamount + $totalprivatedoctoramount + $totalipmiscamount + $totalipdiscamount + $rebate; 
///////////// IP CASH //////////////// 
	 

	// $querycr1cash = "SELECT SUM(a.`amountuhx`) as income FROM `billing_ippharmacy` AS a WHERE ledgercode <> '' AND  a.billdate BETWEEN '$ADate1' AND '$ADate2' AND billnumber in (select billno from billing_ip where accountnameano = '47') 

	// 				UNION ALL SELECT SUM(`rateuhx`) as income FROM `billing_iplab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'  AND billnumber in (select billno from billing_ip where accountnameano = '47') 

	// 				UNION ALL SELECT SUM(`radiologyitemrateuhx`) as income FROM `billing_ipradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'  AND billnumber in (select billno from billing_ip where accountnameano = '47')

	// 				UNION ALL SELECT SUM(`servicesitemrateuhx`) as income FROM `billing_ipservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'  AND billnumber in (select billno from billing_ip where accountnameano = '47') and wellnesspkg = '1' 

	// 				UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipadmissioncharge` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'  AND docno in (select billno from billing_ip where accountnameano = '47') 

	// 				UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipambulance` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' AND docno in (select billno from billing_ip where accountnameano = '47') 

	// 				UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' AND docno in (select billno from billing_ip where accountnameano = '47') 

	// 				UNION ALL SELECT SUM(`amount`) as income FROM `billing_iphomecare` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' AND docno in (select billno from billing_ip where accountnameano = '47') 

	// 				UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipmiscbilling` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' AND docno in (select billno from billing_ip where accountnameano = '47') 

	// 				UNION ALL SELECT SUM(`fxamount`) as income FROM `master_transactionpaylater` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' and accountnameano = '47' and billnumber = patientcode and billnumber like 'ipdr%'

	// 				UNION ALL SELECT SUM(-1*`fxamount`) as income FROM `master_transactionpaylater` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' and accountnameano = '47' and billnumber = patientcode and billnumber like 'ipcr%'

	// 				UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype like 'PAY NOW'

	// 				UNION ALL SELECT SUM(-1*`fxamount`) as income FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype like 'PAY NOW'

	// 				UNION ALL SELECT SUM(-1*`rate`) as income FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `master_transactionip` WHERE accountnameano = '47' and transactiondate BETWEEN '$ADate1' AND '$ADate2' group by billnumber)

	// 					UNION ALL SELECT SUM(-1*`rate`) as income FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `billing_ipcreditapprovedtransaction` WHERE accountnameano = '47' and billdate BETWEEN '$ADate1' AND '$ADate2' group by billno)";

	// $execcrcash1 = mysql_query($querycr1cash) or die ("Error in querycr1cash".mysql_error());

	// while($rescrcash1 = mysql_fetch_array($execcrcash1))
	// {

	// $j = $j+1;

	// $crresultcash[$j] = $rescrcash1['income'];

	// }

	// $totalipcash = array_sum($crresultcash);

		$j = 0;

	$crresultcredit = array();
$querysearchnew = "select visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' and accountnameano <> '47'   UNION ALL SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1'  and '$ADate2' and accountnameano <> '47'  ";

	$querycr1credit = "SELECT SUM(a.`amountuhx`) as income FROM `billing_ippharmacy` AS a WHERE  a.billdate BETWEEN '$ADate1' AND '$ADate2'
	UNION ALL SELECT SUM(`rateuhx`) as income FROM `billing_iplab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
	UNION ALL SELECT SUM(`radiologyitemrateuhx`) as income FROM `billing_ipradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
	-- UNION ALL SELECT SUM(`servicesitemrateuhx`) as income FROM `billing_ipservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
	UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipadmissioncharge` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
	UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipambulance` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
	UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
	UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipmiscbilling` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
	-- UNION ALL SELECT sum(`amountuhx`) as income  FROM `billing_ipprivatedoctor` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
	UNION ALL SELECT sum(1*amount) as income FROM `billing_ipnhif` where recorddate between '$ADate1' and '$ADate2'

	-- discount
	UNION ALL SELECT sum(-1*rate) as income from ip_discount where patientvisitcode IN (select visitcode from billing_ip where accountnameano = '47' and billdate between '$ADate1' and '$ADate2' group by visitcode )  and consultationdate between '$ADate1' and '$ADate2'
							union all select sum(-1*rate) as income from ip_discount where patientvisitcode IN (select visitcode from billing_ipcreditapproved where accountnameano = '47' and billdate between '$ADate1' and '$ADate2' group by visitcode ) and consultationdate between '$ADate1' and '$ADate2'
	UNION ALL SELECT sum(-1*rate) as income FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `master_transactionip` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' and accountnameano <> '47' group by billnumber) and patientvisitcode IN ($querysearchnew)
			UNION ALL SELECT sum(-1*rate) as income FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `billing_ipcreditapprovedtransaction` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' and accountnameano <> '47' group by billno) and patientvisitcode IN ($querysearchnew)
	";

	// $querycr1credit = "SELECT SUM(a.`amountuhx`) as income FROM `billing_ippharmacy` AS a WHERE ledgercode <> '' AND  a.billdate BETWEEN '$ADate1' AND '$ADate2' AND billnumber not in (select billno from billing_ip where accountnameano = '47') 

	// 				UNION ALL SELECT SUM(`rateuhx`) as income FROM `billing_iplab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'  AND billnumber not in (select billno from billing_ip where accountnameano = '47') 

	// 				UNION ALL SELECT SUM(`radiologyitemrateuhx`) as income FROM `billing_ipradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'  AND billnumber not in (select billno from billing_ip where accountnameano = '47')

	// 				UNION ALL SELECT SUM(`servicesitemrateuhx`) as income FROM `billing_ipservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'  AND billnumber not in (select billno from billing_ip where accountnameano = '47') and wellnesspkg = '1'

	// 				UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipadmissioncharge` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'  AND docno not in (select billno from billing_ip where accountnameano = '47') 

	// 				UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipambulance` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' AND docno not in (select billno from billing_ip where accountnameano = '47') 

	// 				UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipbedcharges` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' AND docno not in (select billno from billing_ip where accountnameano = '47') 

	// 				UNION ALL SELECT SUM(`amount`) as income FROM `billing_iphomecare` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' AND docno not in (select billno from billing_ip where accountnameano = '47') 

	// 				UNION ALL SELECT SUM(`amountuhx`) as income FROM `billing_ipmiscbilling` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2' AND docno not in (select billno from billing_ip where accountnameano = '47') 

	// 				UNION ALL SELECT SUM(`fxamount`) as income FROM `master_transactionpaylater` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' and accountnameano <> '47' and billnumber = patientcode and billnumber like 'ipdr%'

	// 				UNION ALL SELECT SUM(-1*`fxamount`) as income FROM `master_transactionpaylater` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' and accountnameano <> '47' and billnumber = patientcode and billnumber like 'ipcr%'

	// 				UNION ALL SELECT SUM(`fxamount`) as income FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype like 'PAY LATER'

	// 				UNION ALL SELECT SUM(-1*`fxamount`) as income FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype like 'PAY LATER'

	// 				UNION ALL SELECT SUM(-1*`rate`) as income FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `master_transactionip` WHERE accountnameano <> '47' and transactiondate BETWEEN '$ADate1' AND '$ADate2' group by billnumber)

	// 					UNION ALL SELECT SUM(-1*`rate`) as income FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `billing_ipcreditapprovedtransaction` WHERE accountnameano <> '47' and billdate BETWEEN '$ADate1' AND '$ADate2' group by billno)";

	$execcrcredit1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1credit) or die ("Error in querycr1credit".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($rescrcredit1 = mysqli_fetch_array($execcrcredit1))

	{

	$j = $j+1;

	$crresultcredit[$j] = $rescrcredit1['income'];

	}

	$totalipcredit = array_sum($crresultcredit);						  


// ip pvt doctor changes has modified 
	// UNION ALL SELECT sum(`amountuhx`) as income  FROM `billing_ipprivatedoctor` WHERE recorddate BETWEEN '$ADate1' AND '$ADate2'
	$privatedoctoramount=0;
	 $query186 = "select  auto_number,patientname,patientcode,visitcode,'billing' as type from billing_ip where billdate between '$ADate1' and '$ADate2' 
	 	UNION ALL SELECT auto_number,patientname,patientcode,visitcode,'creditapproved' as type from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' group by visitcode  order by auto_number DESC ";

		$exec186 = mysqli_query($GLOBALS["___mysqli_ston"], $query186) or die ("Error in Query186".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num186=mysqli_num_rows($exec186);
		while($res186 = mysqli_fetch_array($exec186))
		{ 				$visitcode=$res186['visitcode'];
				$query8 = "select (transactionamount) as transactionamount, (original_amt) as original_amt, visittype, coa from billing_ipprivatedoctor  where visitcode='$visitcode' and recorddate between '$ADate1' and '$ADate2'  ";
			                $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die("Error in Query8" . mysqli_error($GLOBALS["___mysqli_ston"]));
			                $num8                     = mysqli_num_rows($exec8);
			                while($res8 = mysqli_fetch_array($exec8)){
			                		if($res8['visittype'] =="IP")
										{
											if($res8['coa'] !="")
											 $privatedoctoramount += $res8['transactionamount'];
											else
											 $privatedoctoramount += $res8['original_amt'];
										}
										else
										{
											$privatedoctoramount += $res8['original_amt'];
										}
						                // $privatedoctoramount      = $res8['sum(transactionamount)'];
						                // $totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctoramount;
			            		}
            		}


            		$query_servicechanrges_ip = " SELECT SUM(`servicesitemrateuhx`) as income, sum(sharingamount) FROM `billing_ipservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'";
			                $exec_servicechanrges_ip = mysqli_query($GLOBALS["___mysqli_ston"], $query_servicechanrges_ip) or die("Error in Query_servicechanrges_ip" . mysqli_error($GLOBALS["___mysqli_ston"]));
			                $num_servicechanrges_ip = mysqli_num_rows($exec_servicechanrges_ip);
			                while($res_servicechanrges_ip = mysqli_fetch_array($exec_servicechanrges_ip)){
							 	$serviceamount_ip = $res_servicechanrges_ip['income'] - $res_servicechanrges_ip['sum(sharingamount)'];
			                }
            		
		
 $ipcash_total;

	 // $sumtransaction = $totalipcredit+$totalipcash;
 $totalipcredit=$totalipcredit+$privatedoctoramount+$serviceamount_ip;
	  $sumtransaction = $totalipcredit;
 $ipcredit_total=$sumtransaction-$ipcash_total;
	

					//include ('ipunfinalizedrevenue.php');

		include ('ipunfinalizedrevenuejoin.php');

												//echo $ipunfinalizeamount;

		$sumunfinal=$ipunfinalizeamount;

		$totalamount1 = '0.00';

$totalamount2 = '0.00';

$totalamount3 = '0.00';

$totalamount4 = '0.00';

$totalamount5 = '0.00';

$totalamount6 = '0.00';

$totalamount7 = '0.00';

		include("opunfinalizedreport.php");			

		$totalamount1;

		$totalamount=0;

			/*$group='21';

	$ledgerid='08-9301-NHL';

					$totalamount=0;

					$openingbalance1=0;

					

					$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$group'  and id like '%$ledgerid%'";

				$exec267 = mysql_query($query267) or die ("Error in Query267".mysql_error());

				while($res267 = mysql_fetch_array($exec267))

				{  

					

					$id = $res267['id'];

				

						if($id != '')

					{		

									 

						$depositref = 0;

						

						$querydr1dp = "SELECT sum(amount) as depositref FROM `deposit_refund` WHERE `recorddate` < '$ADate1' 

									   UNION ALL SELECT sum(deposit) as depositref FROM `billing_ip` WHERE `billdate` < '$ADate1' 

									   UNION ALL SELECT sum(debitamount) as depositref FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` < '$ADate1' ";

						$execdr1 = mysql_query($querydr1dp) or die ("Error in querydr1dp".mysql_error());

						while($resdr1 = mysql_fetch_array($execdr1))

						{

						

						 $depositref += $resdr1['depositref'];

						// $ledgertotal = $ledgertotal - $depositref;

						}		

					

						$deposit = 0;

						

						$querycr1dp = "SELECT sum(transactionamount) as deposit FROM `master_transactionadvancedeposit` WHERE `transactiondate` < '$ADate1' 

									   UNION ALL SELECT sum(transactionamount) as deposit FROM `master_transactionipdeposit` WHERE `transactiondate` < '$ADate1'  AND `transactionmodule` = 'PAYMENT'

									   UNION ALL SELECT sum(creditamount) as deposit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` < '$ADate1' ";

						$execcr1 = mysql_query($querycr1dp) or die ("Error in querycr1dp".mysql_error());

						while($rescr1 = mysql_fetch_array($execcr1))

						{

						 $deposit += $rescr1['deposit'];

						// $ledgertotal = $ledgertotal + $deposit;

						}

						

					$totalamount +=$deposit-$depositref;	

					}

						

					}*/

					

				$openingbalance1 =$totalamount;

				//echo $openingbalance1;

				$deposit=0;

				$depositref=0;

				$openingbalance1=0;

				?>

					 

					<?php

						

					/*$scount3=0;

				$ledgertotal = 0;

					$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$group'  and id like '%$ledgerid%'";

				$exec267 = mysql_query($query267) or die ("Error in Query267".mysql_error());

				while($res267 = mysql_fetch_array($exec267))

				{/*  

					$accountsmain2 = $res267['accountname'];

					

					$parentid2 = $res267['auto_number'];

					$ledgeranum = $parentid2;

					//$id2 = $res2['id'];

					$id = $res267['id'];

					//$id2 = trim($id2);

					

						if($id != '')

					{		

							 

						$i = 0;

						$drresult = array();

						$querydr1dp = "SELECT deposit, code, name, docno, date FROM (SELECT (-1*`amount`) as deposit, patientcode as code, patientname as name, docno as docno, recorddate as date FROM `deposit_refund` WHERE `recorddate` BETWEEN '$ADate1' AND '$ADate2'

									   UNION ALL SELECT (-1*ABS(`deposit`)) as deposit, patientcode as code, patientname as name, billno as docno, billdate as date FROM `billing_ip` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'

									   UNION ALL SELECT (-1*`debitamount`) as deposit, ledgerid as code, ledgername as name, docno as docno, entrydate as date FROM `master_journalentries` WHERE `ledgerid` = '$id' and selecttype = 'Dr' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'

									   

									   UNION ALL SELECT `transactionamount` as deposit, patientcode as code, patientname as name, docno as docno, transactiondate as date FROM `master_transactionadvancedeposit` WHERE `transactiondate` BETWEEN '$ADate1' AND '$ADate2'

									   UNION ALL SELECT `transactionamount` as deposit, patientcode as code, patientname as name, docno as docno, transactiondate as date FROM `master_transactionipdeposit` WHERE `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactionmodule` = 'PAYMENT'

									   UNION ALL SELECT `creditamount` as deposit,ledgerid as code, ledgername as name, docno as docno, entrydate as date FROM `master_journalentries` WHERE `ledgerid` = '$id' and selecttype = 'Cr' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2') as de order by de.date";

						$execdr1 = mysql_query($querydr1dp) or die ("Error in querydr1dp".mysql_error());

						while($resdr1 = mysql_fetch_array($execdr1))

						{

						$i = $i+1;

						 $depositref = $resdr1['deposit'];

						 $code = $resdr1['code'];

						 $name = $resdr1['name'];

						 $docno = $resdr1['docno'];

						 $date = $resdr1['date'];

						 $scount3=$scount3+1;

						 if($scount3==1)

						 {

						 $ledgertotal = $ledgertotal + $depositref+$openingbalance1;

						 }

						 else

						 {

							 $ledgertotal = $ledgertotal + $depositref;

						 }

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

					

                        <?php

						}		

						$sumunfinal=$sumunfinal+$ledgertotal;				

					}

					else

					{

						//$balance = 0;

					}

							

					}*/

				

					?>

				

				<?php	

				$i=0;

				$drresultdp = array();

						$querydr1dp = "SELECT SUM(`transactionamount`) as depositref FROM `master_transactionipdeposit` WHERE visitcode IN (select visitcode FROM `master_transactionip` WHERE accountnameano <> '47' and transactiondate BETWEEN '$ADate1' AND '$ADate2' group by billnumber)

										UNION ALL SELECT SUM(`transactionamount`) as depositref FROM `master_transactionadvancedeposit` WHERE visitcode IN (select visitcode FROM `master_transactionip` WHERE accountnameano <> '47' and transactiondate BETWEEN '$ADate1' AND '$ADate2' group by billnumber)

										";

						$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1dp) or die ("Error in querydr1dp".mysqli_error($GLOBALS["___mysqli_ston"]));

						while($resdr1 = mysqli_fetch_array($execdr1))

						{

						$i = $i+1;

						$drresultdp[$i] = $resdr1['depositref'];

						}

						

						$j = 0;

						$crresultdp = array();

						$querycr1dp = "SELECT SUM(amount) as deposit FROM `deposit_refund` WHERE visitcode IN (select visitcode FROM `master_transactionip` WHERE accountnameano <> '47' and transactiondate BETWEEN '$ADate1' AND '$ADate2')

									 ";

						$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1dp) or die ("Error in querycr1dp".mysqli_error($GLOBALS["___mysqli_ston"]));

						while($rescr1 = mysqli_fetch_array($execcr1))

						{

						$j = $j+1;

						$crresultdp[$j] = $rescr1['deposit'];

						}

						

					 $ippaylaterdeposite = array_sum($crresultdp) - array_sum($drresultdp);

				

		

					

			?>

            <tr>

              <td width="24%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong><a target="_blank" href="viewoprevenuereportdetails.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>&&type=opcash">OP Cash</a> </strong></td>

              <td width="22%" align="right" valign="left"  

                bgcolor="#ecf0f5" class="bodytext31"><?php echo number_format($totalopcash,2,'.',','); ?></td>

              <td width="10%" align="left" valign="center" bgcolor="#ecf0f5"  

                 class="style1"></td>

              <td width="23%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>
<!-- href="linkipfinalizedrevenue.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>" -->
                <a target="_blank" >

                IP Cash </a></strong></td>

              <td width="21%" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><?php echo number_format($ipcash_total,2,'.',','); ?></td>
              <!-- <td width="21%" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><?php // echo number_format($sumtransaction,2,'.',','); ?></td> -->

            </tr>

            <tr>
	              <td  align="left" valign="center"bgcolor="#ffffff" class="style1"><a target="_blank" href="viewoprevenuereportdetails.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>&&type=oprefunds">OP Refunds</a> </td>
	              <td align="right" valign="left" bgcolor="#CBDBFA" class="bodytext31">-<?php echo number_format($oprefunds,2,'.',','); ?></td>

	              <td align="left" valign="center"class="style1" bgcolor="#ecf0f5">&nbsp;</td>
<!-- href="linkipunfinalizedrevenue.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>" -->
				<td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><span class="style1"><a target="_blank" > <strong>IP Credit </strong></a></span></td>
	              <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><?php echo number_format($ipcredit_total,2,'.',','); ?></td>

            </tr>

            <tr>
	              <td  align="left" valign="center"bgcolor="#ffffff" class="style1"><a target="_blank" href="viewopcredit.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">OP Credit</a> </td>
	              <td align="right" valign="left" bgcolor="#CBDBFA" class="bodytext31"><?php echo number_format($cashamount5,2,'.',','); ?></td>

	              <td align="left" valign="center"class="style1" bgcolor="#ecf0f5">&nbsp;</td>
 

	              <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><span class="style1"><a target="_blank" href="linkipfinalizedrevenue.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>"> <strong>IP Finalized </strong></a></span></td>
	              <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><?php echo number_format($sumtransaction,2,'.',','); ?></td>  
            </tr>

<?php
$opfinalized_t=$totalopcash+$cashamount5-$oprefunds;
?>
            <tr>
            	<!-- href="viewopcredit.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>" -->
	              <td  align="left" valign="center"bgcolor="#ffffff" class="style1"><a target="_blank" >OP Finalized</a> </td>
	              <td align="right" valign="left" bgcolor="#CBDBFA" class="bodytext31"><?php echo number_format($opfinalized_t,2,'.',','); ?></td>

	              <td align="left" valign="center"class="style1" bgcolor="#ecf0f5">&nbsp;</td>
 

	              <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><span class="style1"><a target="_blank" href="linkipunfinalizedrevenue.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>"> <strong>IP Unfinalized </strong></a></span></td>
	              <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><?php echo number_format($sumunfinal,2,'.',','); ?></td>  
            </tr>

			<?php 

			$totalop='';

			$totalip='';

			$totalopandip = "";

			$totalfinal='';

			$totalunfinal='';

			
 
			// $totalop=$totalopcash + $cashamount5 + $totalamount1;
			$totalop=$opfinalized_t + $totalamount1;

			$totalip=$sumtransaction + $sumunfinal;

			$totalopandip = $totalop + $totalip;

			$totalfinal=$totalopcash + $cashamount5+$sumtransaction;

			$totalunfinal=$totalamount1 + $sumunfinal;

			$totalcreditfinal=$cashamount5 + $totalipcredit+$ippaylaterdeposite;

			?>

			 <tr>

              <td  align="left" valign="center" 

                bgcolor="#ffffff" class="style1">

 <a target="_blank" href="viewopunfinalizedreportdetails.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>">

              OP Unfinalized</a> </td>

              <td align="right" valign="left"  

                bgcolor="#ecf0f5" class="bodytext31"><?php echo number_format($totalamount1,2,'.',','); ?></td>

              <td align="left" valign="center"  

                 class="style1" bgcolor="#ecf0f5">&nbsp;</td>

              <td align="left" valign="center"  

                bgcolor="#ffffff" class="style1"><span class="style1">Total IP</span></td>

              <td align="right" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($totalip,2,'.',','); ?></strong></td>

            </tr>

			

            <tr>

              <td  align="left" valign="center" 

                bgcolor="#ffffff" class="style1"><span class="style1">Total OP</span></td>

              <td  align="right" valign="center" 

                bgcolor="#CBDBFA" class="style1"><?php echo number_format($totalop,2,'.',','); ?></td>

              <td align="left" valign="center"  

                 class="style1" bgcolor="#ecf0f5">&nbsp;</td>

              <td align="left" valign="center"  

                bgcolor="#ffffff" class="style1"><span class="style1">Total OP + IP</span></td>

              <td align="right" valign="center"  

                bgcolor="#CBDBFA" class="bodytext31"><strong><?php echo number_format($totalopandip,2,'.',','); ?></strong></td>

            </tr>

			<!--<tr>

              <td  align="left" valign="center" 

                bgcolor="#ffffff" class="style1"><span class="style1">Total Final</span></td>

              <td  align="right" valign="center" 

                bgcolor="#CBDBFA" class="style1"><?php echo number_format($totalfinal,2,'.',','); ?></td>

              <td align="left" valign="center"  

                 class="style1" bgcolor="#ecf0f5">&nbsp;</td>

              <td align="left" valign="center"  

                bgcolor="#ffffff" class="style1"><span class="style1">Total Unfinal</span></td>

              <td align="right" valign="center"  

                bgcolor="#CBDBFA" class="bodytext31"><strong><?php echo number_format($totalunfinal,2,'.',','); ?></strong></td>

            </tr>-->

			<tr>

              <td  align="left" valign="center" 

                bgcolor="#ffffff" class="style1"><span class="style1">Total Final Credit</span></td>

              <td  align="right" valign="center" 

                bgcolor="#CBDBFA" class="style1"><?php echo number_format($totalcreditfinal,2,'.',','); ?></td>

              <td align="left" valign="center"  

                 class="style1" bgcolor="#ecf0f5">&nbsp;</td>

              <td align="left" valign="center"  

                bgcolor="#ffffff" class="style1"><span class="style1"></span></td>

              <td align="right" valign="center"  

                bgcolor="#CBDBFA" class="bodytext31"><strong></strong></td>

            </tr>

			<?php

		    

		  //$query2 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionpaynow where transactiondate between '$ADate1' and '$ADate2' "; 

		 

					if (isset($_REQUEST["ADate1"])) { $transactiondatefrom = date("Y-m-d", strtotime($_REQUEST["ADate1"])); } else { $transactiondatefrom = ""; }



//$paymenttype = $_REQUEST['paymenttype'];

if (isset($_REQUEST["ADate2"])) { $transactiondateto = date("Y-m-d", strtotime($_REQUEST["ADate2"])); } else { $transactiondateto = ""; }

$res2cashamount1 =	0;
$res3cashamount1 =	0;
$res4cashamount1 =	0;
$res6cashamount1 =	0;
$res7cashamount1 =	0;
$res8cashamount1 =	0;
$res9cashamount1  =	0;
$res10cashamount1 =	0;
$res11cashamount1 =	0;

$res2cardamount1  =	0;
$res3cardamount1  =	0;
$res4cardamount1  =	0;
$res6cardamount1  =	0;
$res7cardamount1  =	0;
$res8cardamount1  =	0;
$res9cardamount1  =	0;
$res10cardamount1 =	0;
$res11cardamount1 =	0;

$res2chequeamount1  =	0;
$res3chequeamount1  =	0;
$res4chequeamount1  =	0;
$res6chequeamount1  =	0;
$res7chequeamount1  =	0;
$res8chequeamount1  =	0;
$res9chequeamount1  =	0;
$res10chequeamount1 =	0;
$res11chequeamount1 =	0;

$res2onlineamount1  =	0;
$res3onlineamount1  =	0;
$res4onlineamount1  =	0;
$res6onlineamount1  =	0;
$res7onlineamount1  =	0;
$res8onlineamount1  =	0;
$res9onlineamount1  =	0;
$res10onlineamount1 =	0;
$res11onlineamount1 =	0;

$res2creditamount1  =	0;
$res3creditamount1  =	0;
$res4creditamount1  =	0;
$res6creditamount1  =	0;
$res7creditamount1  =	0;
$res8creditamount1  =	0;
$res9creditamount1  =	0;
$res10creditamount1 =	0;
$res11creditamount1 =	0;					

// Refunds
$res5cashamount1=0;
$res54cashamount1=0;
$res5cardamount1=0;
$res54cardamount1=0;
$res5chequeamount1=0;
$res54chequeamount1=0;
$res5onlineamount1=0;
$res54onlineamount1=0;
$res5creditamount1=0;
$res54creditamount1	=0;	  
				//	$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'LTC-1';

					

		//   echo "hii".$locationcode1;

// transaction_transactionip 
// master_transactionpaynow

$query23 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionpaynow where  transactiondate between '$transactiondatefrom' and '$transactiondateto' and accountname='CASH - HOSPITAL' ";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die("Error in Query2" . mysqli_error($GLOBALS["___mysqli_ston"]));
$res23             = mysqli_fetch_array($exec23);
$res2cashamount1   = $res23['cashamount1'];
$res2onlineamount1 = $res23['onlineamount1'];
$res2creditamount1 = $res23['creditamount1'];
$res2chequeamount1 = $res23['chequeamount1'];
$res2cardamount1   = $res23['cardamount1'];
// echo  "hi".$res23['creditamount1'];
$query3            = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionexternal where  transactiondate between '$transactiondatefrom' and '$transactiondateto'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3" . mysqli_error($GLOBALS["___mysqli_ston"]));
$res3              = mysqli_fetch_array($exec3);
$res3cashamount1   = $res3['cashamount1'];
$res3onlineamount1 = $res3['onlineamount1'];
$res3creditamount1 = $res3['creditamount1'];
$res3chequeamount1 = $res3['chequeamount1'];
$res3cardamount1   = $res3['cardamount1'];

////// UNWANTED AT PRESENT /////////////
$query4            = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_billing where  billingdatetime between '$transactiondatefrom' and '$transactiondateto'";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die("Error in Query4" . mysqli_error($GLOBALS["___mysqli_ston"]));
$res4              = mysqli_fetch_array($exec4);
$res4cashamount1   = $res4['cashamount1'];
$res4onlineamount1 = $res4['onlineamount1'];
$res4creditamount1 = $res4['creditamount1'];
$res4chequeamount1 = $res4['chequeamount1'];
$res4cardamount1   = $res4['cardamount1'];
$query5            = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from refund_paynow where  transactiondate between '$transactiondatefrom' and '$transactiondateto'";
$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die("Error in Query5" . mysqli_error($GLOBALS["___mysqli_ston"]));
$res5              = mysqli_fetch_array($exec5);
$res5cashamount1   = $res5['cashamount1'];
$res5onlineamount1 = $res5['onlineamount1'];
$res5creditamount1 = $res5['creditamount1'];
$res5chequeamount1 = $res5['chequeamount1'];
$res5cardamount1   = $res5['cardamount1'];
$query54           = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1  from deposit_refund where   recorddate between '$transactiondatefrom' and '$transactiondateto'";
$exec54 = mysqli_query($GLOBALS["___mysqli_ston"], $query54) or die("Error in Query4" . mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res54 = mysqli_fetch_array($exec54)) {
    $res54cashamount1   = $res54['cashamount1'];
    $res54onlineamount1 = $res54['onlineamount1'];
    $res54creditamount1 = $res54['creditamount1'];
    $res54chequeamount1 = $res54['chequeamount1'];
    $res54cardamount1   = $res54['cardamount1'];
} //refund adv
$query6 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionadvancedeposit where  transactiondate between '$transactiondatefrom' and '$transactiondateto'";
$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die("Error in Query5" . mysqli_error($GLOBALS["___mysqli_ston"]));
$res6              = mysqli_fetch_array($exec6);
$res6cashamount1   = $res6['cashamount1'];
$res6onlineamount1 = $res6['onlineamount1'];
$res6creditamount1 = $res6['creditamount1'];
$res6chequeamount1 = $res6['chequeamount1'];
$res6cardamount1   = $res6['cardamount1'];
$query7            = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionipdeposit where  transactiondate between '$transactiondatefrom' and '$transactiondateto'";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die("Error in Query5" . mysqli_error($GLOBALS["___mysqli_ston"]));
$res7              = mysqli_fetch_array($exec7);
$res7cashamount1   = $res7['cashamount1'];
$res7onlineamount1 = $res7['onlineamount1'];
$res7creditamount1 = $res7['creditamount1'];
$res7chequeamount1 = $res7['chequeamount1'];
$res7cardamount1   = $res7['cardamount1'];
//// UNWANTED AT PRESENT ENDS/////////////

$query8            = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(mpesaamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionip where  transactiondate between '$transactiondatefrom' and '$transactiondateto'";
$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die("Error in Query5" . mysqli_error($GLOBALS["___mysqli_ston"]));
$res8              = mysqli_fetch_array($exec8);
$res8cashamount1   = $res8['cashamount1'];
$res8onlineamount1 = $res8['onlineamount1'];
$res8creditamount1 = $res8['creditamount1'];
$res8chequeamount1 = $res8['chequeamount1'];
$res8cardamount1   = $res8['cardamount1'];

$query9            = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionipcreditapproved where  transactiondate between '$transactiondatefrom' and '$transactiondateto'";
$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die("Error in Query5" . mysqli_error($GLOBALS["___mysqli_ston"]));
$res9              = mysqli_fetch_array($exec9);
$res9cashamount1   = $res9['cashamount1'];
$res9onlineamount1 = $res9['onlineamount1'];
$res9creditamount1 = $res9['creditamount1'];
$res9chequeamount1 = $res9['chequeamount1'];
$res9cardamount1   = $res9['cardamount1'];

// ////// UNWANTED AT PRESENT /////////////
$query10           = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from receiptsub_details where  transactiondate between '$transactiondatefrom' and '$transactiondateto'";
$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die("Error in Query10" . mysqli_error($GLOBALS["___mysqli_ston"]));
$res10              = mysqli_fetch_array($exec10);
$res10cashamount1   = $res10['cashamount1'];
$res10onlineamount1 = $res10['onlineamount1'];
$res10creditamount1 = $res10['creditamount1'];
$res10chequeamount1 = $res10['chequeamount1'];
$res10cardamount1   = $res10['cardamount1'];
$query11            = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionpaylater where docno like 'AR-%' and transactionstatus like 'onaccount' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die("Error in Query11" . mysqli_error($GLOBALS["___mysqli_ston"]));
$res11              = mysqli_fetch_array($exec11);
$res11cashamount1   = $res11['cashamount1'];
$res11onlineamount1 = $res11['onlineamount1'];
$res11creditamount1 = $res11['creditamount1'];
$res11chequeamount1 = $res11['chequeamount1'];
$res11cardamount1   = $res11['cardamount1'];
////// UNWANTED AT PRESENT ENDS/////////////


		  $cashamount = $res2cashamount1 + $res3cashamount1 + $res4cashamount1 + $res6cashamount1 + $res7cashamount1 + $res8cashamount1 + $res9cashamount1 + $res10cashamount1+ $res11cashamount1;

		  $cardamount = $res2cardamount1 + $res3cardamount1 + $res4cardamount1 + $res6cardamount1 + $res7cardamount1 + $res8cardamount1 + $res9cardamount1 + $res10cardamount1+ $res11cardamount1;

		  $chequeamount = $res2chequeamount1 + $res3chequeamount1 + $res4chequeamount1 + $res6chequeamount1 + $res7chequeamount1 + $res8chequeamount1 + $res9chequeamount1 + $res10chequeamount1+ $res11chequeamount1;

		  $onlineamount = $res2onlineamount1 + $res3onlineamount1 + $res4onlineamount1 + $res6onlineamount1 + $res7onlineamount1 + $res8onlineamount1 + $res9onlineamount1 + $res10onlineamount1+ $res11onlineamount1;

		  $creditamount = $res2creditamount1 + $res3creditamount1 + $res4creditamount1 + $res6creditamount1 + $res7creditamount1 + $res8creditamount1 + $res9creditamount1 + $res10creditamount1+ $res11creditamount1;



		  $cashamount1 = $cashamount - $res5cashamount1 - $res54cashamount1;

		  $cardamount1 = $cardamount - $res5cardamount1 - $res54cardamount1;

		  $chequeamount1 = $chequeamount - $res5chequeamount1 - $res54chequeamount1;

		  $onlineamount1 = $onlineamount - $res5onlineamount1 - $res54onlineamount1;

		  $creditamount1 = $creditamount - $res5creditamount1 - $res54creditamount1;

		  

		  $total = $cashamount1 + $onlineamount1 + $chequeamount1 + $cardamount1 + $creditamount1;

		  

		  $snocount = $snocount + 1;

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

			<tr>

			<td colspan="5" align="left">&nbsp;</td>

			</tr>

			<tr>

			<td bgcolor="#ecf0f5" colspan="6" align="left" class="bodytext31"><strong>Collection Summary</strong></td>

			</tr>

			 <tr>

              

              <td width="21%" align="left" valign="left"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Cash</strong></div></td>

				<td width="18%" align="left" valign="left"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Card</strong></div></td>

				<td width="17%" align="left" valign="left"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Cheque</strong></div></td>

				<td width="17%" align="left" valign="left"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Online</strong></div></td>

				<td width="17%" align="left" valign="left"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Mpesa</strong></div></td>

				<td width="19%" align="left" valign="left"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total</strong></div></td>

               

            </tr>

           <tr <?php echo $colorcode; ?>>

             

               <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($cashamount1,2,'.',','); ?></div>  </td>

              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($cardamount1,2,'.',','); ?></div>  </td>

              <td class="bodytext31" valign="center"  align="right">

			  <?php echo number_format($chequeamount1,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php echo number_format($onlineamount1,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php echo number_format($creditamount1,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>

				<td width="2%"  align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">

			    <div align="right">&nbsp;</div></td>

				

               

           </tr>

		   <?php

		   

	

		   

		   ?>

			<tr>

			<td bgcolor="#ecf0f5" colspan="6" align="left">&nbsp;</td>

			</tr>

			

          </tbody>

        </table></td>

      </tr>

	 <?php } ?>

<?php include ("includes/footer1.php"); ?>

</body>

</html>




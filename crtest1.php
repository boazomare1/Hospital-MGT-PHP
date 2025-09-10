<?php

session_start();

//error_reporting(0);

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

$openingbalance = "0.00";

$total = '0.00';

$totalamount = "0.00";

$totalamount30 = "0.00";
$checktotal = 0;

$searchsuppliername = "";

$searchsuppliername1 = "";

$cbsuppliername = "";

$snocount = "";

$colorloopcount="";

$range = "";

$total60 = "0.00";

$total90 = "0.00";



$total120 = "0.00";

$total180 = "0.00";

$total210 = "0.00";

$totalamount1 = "0.00";

$totalamount301 = "0.00";

$totalamount601 = "0.00";

$totalamount901 = "0.00";

$totalamount1201 = "0.00";

$totalamount1801 = "0.00";

$totalamount2101 = "0.00";

$totalamount90 = '0.00';

$totalamount2401 = 0;

$totalamount60 = 0;



$ftotalamount1 = 0;

$ftotalamount301 = 0;

$ftotalamount601 = 0;

$ftotalamount901 = 0;

$ftotalamount1201 = 0;

$ftotalamount1801 = 0;

$ftotalamount2101 = 0;

$ftotalamount2401 = 0;

//This include updatation takes too long to load for hunge items database.

//include("autocompletebuild_subtype.php");



//include ("autocompletebuild_account3.php");

$totalamount302=0;

				$totalamount602=0;

				$totalamount902=0;

				$totalamount1202=0;

				$totalamount1802=0;

				$totalamount2102=0;

				$totalamountgreater2=0;



if (isset($_REQUEST["searchsuppliername1"])) { $searchsuppliername1 = $_REQUEST["searchsuppliername1"]; } else { $searchsuppliername1 = ""; }



if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }

//echo $searchsuppliername;

 

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $transactiondatefrom; }

//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $transactiondateto; }

//echo $ADate2;

if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }

//echo $range;

if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }

//echo $amount;

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

//$frmflag2 = $_POST['frmflag2'];

if (isset($_REQUEST["accountssub"])) { $accountssubanum = $_REQUEST["accountssub"]; } else { $accountssubanum = ""; }		// by Kenique 22 Nov 2018

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



<!--<script type="text/javascript" src="js/autocomplete_accounts3.js"></script>

<script type="text/javascript" src="js/autosuggest5accounts.js"></script>

<script type="text/javascript">

window.onload = function () 

{

	var oTextbox = new AutoSuggestControl1(document.getElementById("searchsuppliername1"), new StateSuggestions1());

	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        

}-->



<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/autocomplete.css"> 

<script type="text/javascript">

/*window.onload = function () 

{

	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        

}*/



$(document).ready(function(e) {

	$('#searchsuppliername').autocomplete({

		

	source:"ajaxsupplieraccount_new.php?accountssub="+$("#accountssub").val()+"",		// by Kenique 22 Nov 2018

	//alert(source);

	matchContains: true,

	minLength:1,

	html: true, 

		select: function(event,ui){

			var accountname=ui.item.value;

			var accountid=ui.item.id;

			$("#searchsuppliercode").val(accountid);

			},

	});	

});



function setaccountmainanum(){		// by Kenique 22 Nov 2018

	var accountssub = $("#accountssub").val();

	

	$('#searchsuppliername').autocomplete({

	

	source:"ajaxsupplieraccount_new.php?accountssub="+accountssub+"",

	//alert(source);

	matchContains: true,

	minLength:1,

	html: true, 

		select: function(event,ui){

			var accountname=ui.item.value;

			var accountid=ui.item.id;

			$("#searchsuppliercode").val(accountid);

			},

	});

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

    <td width="2%" valign="top"><?php //ab ?>

      &nbsp;</td>

    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860">

		

		

              <form name="cbform1" method="post" action="">

		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Full Creditor Analysis Summary</strong></td>

              </tr>

            <!--<tr>

              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">

			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 

                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 

				</td>

              </tr>

			   <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Subtype </td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

              <input name="searchsuppliername1" type="text" id="searchsuppliername1" value="<?php echo $searchsuppliername1; ?>" size="50" autocomplete="off">

              <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">

			  <input name="searchsubtypeanum1" id="searchsubtypeanum1" value="" type="hidden">

			  </span></td>

           </tr>-->

		 	<!-- // Added by Kenique 22 Nov 2018 -->

		  <!-- <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Type </td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

              <select name="accountssub" id="accountssub" onchange="setaccountmainanum();">

			  <option value="">Select</option>

			  <?php

			  $query51 = "SELECT auto_number,accountssub FROM `master_accountssub` WHERE `accountsmain` = '7' AND recordstatus <> 'deleted' ORDER BY `master_accountssub`.`accountssub` ASC ";

			  $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			  while($res51 = mysqli_fetch_array($exec51))

			  {

			  $accountssub = $res51['accountssub'];

			  $anum = $res51['auto_number'];

			  ?>

			  <option value="<?php echo $anum; ?>" <?php if($anum == $accountssubanum){ echo "selected"; }?>><?php echo $accountssub; ?></option>

			  <?php

			  }

			  ?>

			  </select>

			  </span></td> 

           </tr> -->
 <!-- //  Added by Kenique 22 Nov 2018 -->
		 
 				<input type="hidden" name="accountssub" id="accountssub" value="">
            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Supplier </td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

              <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">

              <input name="searchsuppliernamehiddentextbox" id="searchsuppliernamehiddentextbox" value="" type="hidden">

			  <input name="searchaccountnameanum1" id="searchaccountnameanum1" value="" type="hidden">

			  </span></td>

           </tr>

		   

			  <tr>

                      <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF"> Date From </td>

                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $ADate1; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>

                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>

                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">

                        <input name="ADate2" id="ADate2" value="<?php echo $ADate2; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>

                    </tr>	

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>

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

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1000" 

            align="left" border="0">

          <tbody>

            <tr>

              <td width="7%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td colspan="14" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311">

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

 			

              <script language="javascript">

				function printbillreport1()

				{

					window.open("print_paymentgivenreport1.php?<?php echo $urlpath; ?>","Window1",'width=900,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

					//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');

				}

				function printbillreport2()

				{

					window.location = "dbexcelfiles/PaymentGivenToSupplier.xls"

				}

				</script>

              <!--<input  value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />

&nbsp;				<input  value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />-->

</span></td>  

            </tr>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></td>

              <td width="19%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Supplier</strong></div></td>

              <td width="12%" align="right" valign="right"  

                bgcolor="#ffffff" class="bodytext31"><strong> Total Amount </strong></td>

              <td width="11%" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> 30 days </strong></td>

              <td width="11%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>60 days </strong></div></td>

				<td width="10%" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>90 days</strong></div></td>

				<td width="10%" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>120 days</strong></div></td>

              <td width="9%" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>180 days </strong></div></td>

				<td width="11%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>180+ days </strong></div></td>

            </tr>

			

			<?php

			

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{

				

			$dotarray = explode("-", $paymentreceiveddateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			$searchsuppliername1 = $_REQUEST['searchsuppliername'];

			$arraysuppliercode='';

			

			

			$res1suppliername = '';

			$res1suppliercode = '';

			$res1transactiondate ='';

			//print_r($_POST);

		 

		  if($searchsuppliername1 != '')

		  {

		  $arraysuppliername = $_REQUEST['searchsuppliername'];

			$searchsuppliername1 = trim($arraysuppliername);

			$arraysuppliercode = $_REQUEST['searchsuppliercode'];

		  // $query212 = "select * from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and transactiondate between '$ADate1' and '$ADate2' group by suppliercode";
		  $query212 = "select * from master_accountname where id = '$arraysuppliercode' and accountssub='12' group by id";
		  	// $query212 = " SELECT scode as id from (	SELECT suppliercode as scode from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and transactiondate between '$ADate1' and '$ADate2' group by suppliercode
	 	  //    	union all SELECT   ledgerid as scode from master_journalentries where ledgerid='$res21suppliercode' and entrydate between '$ADate1' and '$ADate2' group by ledgerid 
  			// 	union all SELECT   supplier_id as scode from supplier_debit_transactions where supplier_id = '$res21suppliercode'  and date(created_at) between '$ADate1' and '$ADate2' group by supplier_id ) as a group by scode
 				// 	 ";


		  }

		  else if($searchsuppliername1 == '')

		  {
		  	$query212 = "select * from master_accountname where accountssub='12' group by id";

		  // $query212 = "select * from master_transactionpharmacy where transactiondate between '$ADate1' and '$ADate2'  group by suppliercode";
		  	// $query212 = "select * from master_accountname where accountssub='12' group by id";
 

		  	// $query212 = " SELECT scode as id from (SELECT suppliercode as scode from master_transactionpharmacy where transactiondate between '$ADate1' and '$ADate2' group by suppliercode
	 	  //    	union all SELECT   ledgerid as scode from master_journalentries where entrydate between '$ADate1' and '$ADate2' group by ledgerid 
  			// 	union all SELECT   supplier_id as scode from supplier_debit_transactions where date(created_at) between '$ADate1' and '$ADate2' group by supplier_id ) as a group by scode
 				// 	 ";

		  }

		  //echo $query212;

		  $exec212 = mysqli_query($GLOBALS["___mysqli_ston"], $query212) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res212 = mysqli_fetch_array($exec212))

		  {

		  

			// $res21suppliername = $res212['suppliername'];
			$res21suppliername = $res212['accountname'];

			$res21suppliercode = $res212['id'];
			// $res21suppliercode = $res212['suppliercode'];

			

			$query222 = "select * from master_accountname where id = '$res21suppliercode' and recordstatus <>'DELETED' ";

			$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res222 = mysqli_fetch_array($exec222);

			$res22accountname = $res222['accountname'];
			// $res21suppliername = $res222['accountname'];



			if( $res21suppliername != '')

			{

			
			

			$dotarray = explode("-", $paymentreceiveddateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			$searchsuppliername1 = trim($searchsuppliername1);

			$res21suppliername = trim($res21suppliername);

			



		  //$query1 = "select * from master_transactionpharmacy where suppliercode = '$res21suppliercode' and transactiondate between '$ADate1' and '$ADate2' group by billnumber order by suppliername";

		// 	 // $query1 = "SELECT billnumber, suppliercode as scode from master_purchase where suppliercode = '$res21suppliercode' and recordstatus <> 'deleted' and billdate between '$ADate1' and '$ADate2' and companyanum = '$companyanum'  group by suppliercode
	 // 	     union all SELECT docno as billnumber, ledgerid as scode from master_journalentries where ledgerid='$res21suppliercode' and entrydate between '$ADate1' and '$ADate2' group by ledgerid 
  // union all SELECT approve_id as billnumber, supplier_id as scode from supplier_debit_transactions where supplier_id = '$res21suppliercode'  and date(created_at) between '$ADate1' and '$ADate2' group by supplier_id

	 // 	  ";

	 	  //$query1 = "select * from master_purchase where suppliercode = '$res21suppliercode' and recordstatus <> 'deleted' and billdate between '$ADate1' and '$ADate2' and companyanum = '$companyanum'  group by suppliercode";

		   $query1 = "select * from master_transactionpharmacy where suppliercode = '$res21suppliercode'  and (transactiontype = 'PURCHASE' or transactiontype = 'PAYMENT') and transactiondate between '$ADate1' and '$ADate2' group by suppliercode";

		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num1 = mysqli_num_rows($exec1);
		  while($res1 = mysqli_fetch_array($exec1))

		  {

		  $res1suppliername = $res1['suppliername'];

		  $res1suppliercode = $res1['suppliercode'];

		  $res1transactiondate  = $res1['transactiondate'];

		  $res1billnumber = $res1['billnumber'];

		  $res2transactionamount = $res1['transactionamount'];

		  /*$res1patientname = $res1['patientname'];

		  $res1visitcode = $res1['visitcode'];*/

		  

		  echo "----".$query2 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode'  and transactiontype = 'PURCHASE' and transactiondate between '$ADate1' and '$ADate2'";

		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res2 = mysqli_fetch_array($exec2);

		  echo "----".$res2transactionamount1 = $res2['transactionamount1'];

		  //////////////// for wht //////////////
		  $wh_tax_value=0;
		   $query222 = "select sum(wh_tax_value) as wh_tax_value from purchase_details where suppliercode = '$res1suppliercode' and entrydate between '$ADate1' and '$ADate2'";
		  $exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res222 = mysqli_fetch_array($exec222);
		  $wh_tax_value = $res222['wh_tax_value'];
		  //////////////// for wht //////////////
		  $res2transactionamount=$res2transactionamount1-$wh_tax_value;

		  

		  echo "----".$query3 = "SELECT sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode'   and transactiontype = 'PAYMENT' and recordstatus = 'allocated' and transactiondate between '$ADate1' and '$ADate2'  ";
		  // and docno not like '%SDBT%'

		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res3 = mysqli_fetch_array($exec3);

		  echo "----". $res3transactionamount = $res3['transactionamount1'];

		  

		  $res4return = 0;

		  $query4 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where  transactiontype = 'PURCHASE' and suppliercode = '$res1suppliercode' and transactiondate between '$ADate1' and '$ADate2')

		  UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select billnumber from master_transactionpharmacy where transactiontype = 'PURCHASE' and suppliercode = '$res1suppliercode' and transactiondate between '$ADate1' and '$ADate2')";

		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res4 = mysqli_fetch_array($exec4))

		  {

		  $res4return += $res4['totalreturn'];

		  }

			

		

		  

	 	  $invoicevalue =  $res2transactionamount - ($res3transactionamount + $res4return) ;

		  

$query45122 = "select billnumber from master_purchase where suppliercode = '$res1suppliercode' and recordstatus <> 'deleted' and billdate between '$ADate1' and '$ADate2' and companyanum = '$companyanum'  group by billnumber";		  $exe45122=mysqli_query($GLOBALS["___mysqli_ston"], $query45122);

		  while($res45122=mysqli_fetch_array($exe45122))

		  {

		 $resbill=$res45122['billnumber']; 

	 	   $query451= "select transactiondate,sum(transactionamount) as transactionamount,billnumber,mrnno from master_transactionpharmacy where billnumber='$resbill' and  suppliercode = '$res1suppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PURCHASE' group by billnumber";

		  

		  $exec451 = mysqli_query($GLOBALS["___mysqli_ston"], $query451) or die ("Error in Query45".mysqli_error($GLOBALS["___mysqli_ston"]));

     $num451 = mysqli_num_rows($exec451);

	 if($num451>0)

		  {

		  while($res451=mysqli_fetch_array($exec451))

		{  

		 

	  $res451transactiondate = $res451['transactiondate'];

		$res451transactionamount1 = $res451['transactionamount'];

		  $res451billnumber=$res451['billnumber'];

		  $res451mrnno =$res451['mrnno'];

		  /////////////// for wht //////////////
		  $wh_tax_value=0;
		   $query222 = "select sum(wh_tax_value) as wh_tax_value from purchase_details where billnumber='$res451billnumber' and suppliercode = '$res1suppliercode' and entrydate between '$ADate1' and '$ADate2' group by billnumber";
		  $exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res222 = mysqli_fetch_array($exec222);
		  $wh_tax_value = $res222['wh_tax_value'];
		  //////////////// for wht //////////////
		  $res451transactionamount=$res451transactionamount1-$wh_tax_value;

		  $query452= "select sum(transactionamount) as transactionamount from master_transactionpharmacy where  billnumber='$res451billnumber' and  suppliercode = '$res1suppliercode'  and transactiontype = 'PAYMENT' and recordstatus='allocated'  and transactiondate between '$ADate1' and '$ADate2' group by billnumber";
		   // and docno not like '%SDBT%' 


		  $exe452=mysqli_query($GLOBALS["___mysqli_ston"], $query452);

		  $res452=mysqli_fetch_array($exe452);

		  

		 $totalpayment=$res452['transactionamount'];

		  

		  $returnamount451 = 0;

		  $query652 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$res451billnumber' and  transactiontype = 'PURCHASE' and transactiondate between '$ADate1' and '$ADate2')

		  UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber = '$res451billnumber' and entrydate between '$ADate1' and '$ADate2'";

		  $exe652=mysqli_query($GLOBALS["___mysqli_ston"], $query652) or die("Error in query652".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res652=mysqli_fetch_array($exe652))

		  {

		  $returnamount451 += $res652['totalreturn'];

		  }

		  

		if($snocount==0)

		{

		 $totalamount420 =$res451transactionamount-($totalpayment + $returnamount451)+$openingbalance;

}

else

{

$totalamount420 =$res451transactionamount-($totalpayment + $returnamount451);

}

			$totalamount451 =$totalamount420;		 

		  $t1 = strtotime("$ADate2");

		  $t2 = strtotime("$res451transactiondate");

		  $days_between = ceil(abs($t1 - $t2) / 86400);

		

		  

		  if($days_between <= 30)

		  {

		

		  $totalamount302 = $totalamount302 + $totalamount451;

		

		  }

		  else if(($days_between >30) && ($days_between <=60))

		  {

		

		  $totalamount602 = $totalamount602 + $totalamount451;

		

		  }

		  else if(($days_between >60) && ($days_between <=90))

		  {

		

		  $totalamount902 = $totalamount902 + $totalamount451;

		

		  }

		  else if(($days_between >90) && ($days_between <=120))

		  {

		

		  $totalamount1202 = $totalamount1202 + $totalamount451;

		

		  }

		  else if(($days_between >120) && ($days_between <=180))

		  {

		

		  $totalamount1802 = $totalamount1802 + $totalamount451;

		

		  }

		  else

		  {

		

		  $totalamountgreater2 = $totalamountgreater2 + $totalamount451;

		  }

	$totalamount451=0;

		   }

		

		}

		}

		 

		

		  

				$totalamount1 = $totalamount1 + $res2transactionamount;

				

				$totalamount301 = $totalamount301 + $invoicevalue;

				$totalamount601 = $totalamount601 + $totalamount302;

				$totalamount901 = $totalamount901 + $totalamount602;

				$totalamount1201 = $totalamount1201 + $totalamount902;

				$totalamount1801 = $totalamount1801 + $totalamount1202;

				$totalamount2101 = $totalamount2101 + $totalamount1802;

				$totalamount2401 = $totalamount2401 + $totalamountgreater2;

				

				$ftotalamount1 = $ftotalamount1 + $res2transactionamount;

				

				$ftotalamount301 = $ftotalamount301 + $invoicevalue;

				$ftotalamount601 = $ftotalamount601 + $totalamount302;

				$ftotalamount901 = $ftotalamount901 + $totalamount602;

				$ftotalamount1201 = $ftotalamount1201 + $totalamount902;

				$ftotalamount1801 = $ftotalamount1801 + $totalamount1202;

				$ftotalamount2101 = $ftotalamount2101 + $totalamount1802;

				$ftotalamount2401 = $ftotalamount2401 + $totalamountgreater2;

				

				$res2transactionamount=0;

				$invoicevalue=0;

				$totalamount30=0;

				$totalamount60=0;

				$totalamount90=0;

				$totalamount120=0;

				$totalamount180=0;

				$totalamount210=0;

				$totalamount302=0;

				$totalamount602=0;

				$totalamount902=0;

				$totalamount1202=0;

				$totalamount1802=0;

				$totalamount2102=0;

				$totalamountgreater2=0;

				

				$total60=0;

				$total90=0;

				$total120=0;

				$total180=0;

				$total210=0;

				   

			}
		}

			

					 	echo '---'.$query2="select sum(creditamount-debitamount) as creditamount,ledgername,entrydate,docno from master_journalentries where ledgerid='$res21suppliercode' and entrydate between '$ADate1' and '$ADate2' group by docno";

			$exe2=mysqli_query($GLOBALS["___mysqli_ston"], $query2);

			while($res2=mysqli_fetch_array($exe2))

			{

	 	  	$creditamount=$res2['creditamount'];

			$ledgername=$res2['ledgername'];

			$entrydate=$res2['entrydate'];

			$docno=$res2['docno'];

			

			$t1 = strtotime($entrydate);

    	  $t2 = strtotime($ADate2);

		  $days_between = ceil(abs($t2 - $t1) / 86400);

		    if($days_between<30)

			{

			$totalamount30=$totalamount30+$creditamount;

			}

			

			if($days_between>30 && $days_between<=60)

			{

			$total60=$total60+$creditamount;

			}

			if($days_between>60 && $days_between<=90)

			{

			$total90=$total90+$creditamount;

			}

			if($days_between>90 && $days_between<=120)

			{

			$total120=$total120+$creditamount;

			}

			if($days_between>120 && $days_between<=180)

			{

			$total180=$total180+$creditamount;

			}

			if($days_between>180)

			{

			$total210=$total210+$creditamount;

			}

		  

			

			  if($creditamount !=''){	

			

				$totalamount1 = $totalamount1 + $creditamount;

				$totalamount301 = $totalamount301 + $creditamount;

				$totalamount601 = $totalamount601 + $totalamount30;

				$totalamount901 = $totalamount901 + $total60;

				$totalamount1201 = $totalamount1201 + $total90;

				$totalamount1801 = $totalamount1801 + $total120;

				$totalamount2101 = $totalamount2101 + $total180;

				$totalamount2401 = $totalamount2401 + $total210;

				

				$ftotalamount1 = $ftotalamount1 + $creditamount;

				$ftotalamount301 = $ftotalamount301 + $creditamount;

				$ftotalamount601 = $ftotalamount601 + $totalamount30;

				$ftotalamount901 = $ftotalamount901 + $total60;

				$ftotalamount1201 = $ftotalamount1201 + $total90;

				$ftotalamount1801 = $ftotalamount1801 + $total120;

				$ftotalamount2101 = $ftotalamount2101 + $total180;

				$ftotalamount2401 = $ftotalamount2401 + $total210;

			//echo $cashamount;

			

		



			

}

				$res2transactionamount=0;

				$invoicevalue=0;

				$totalamount30=0;

				$totalamount60=0;

				$totalamount90=0;

				$totalamount120=0;

				$totalamount180=0;

				$totalamount210=0;

				

				$totalamount302=0;

				$totalamount602=0;

				$totalamount902=0;

				$totalamount1202=0;

				$totalamount1802=0;

				$totalamount2102=0;

				$total60=0;

				$total90=0;

				$total120=0;

				$total180=0;

				$total210=0;

			

			}

			///////////////////////
					$total_debit=0;
				// $arraysuppliercode = $_POST['searchsuppliercode'];
				echo $query5 = "SELECT * from supplier_debit_transactions where supplier_id = '$res21suppliercode'  and date(created_at) between '$ADate1' and '$ADate2' order by created_at ASC";
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  // $num5 = mysql_num_rows($exec5);
		  while($res5 = mysqli_fetch_array($exec5))
		  {
		   $res5docnumber = $res5['approve_id'];
		  $created_at = $res5['created_at'];
		  $ref_no = $res5['ref_no'];
		   $res5transactionamount = $res5['total_amount'];

		 	 $timestamp = strtotime($created_at);
			 $entrydate = date('Y-m-d', $timestamp); // d.m.YYYY
		 
			$transactionamount='0';
			 $query3 = "SELECT * from master_transactionpharmacy where  docno = '$res5docnumber' and recordstatus = 'allocated'";

				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
				// $num=mysql_num_rows($exec3);
				while ($res3 = mysqli_fetch_array($exec3))
				{  $transactionamount += $res3['transactionamount'];
				}
				 $pending12 = $res5transactionamount-$transactionamount;

				 	$t1 = strtotime($entrydate);
    	  $t2 = strtotime($ADate2);
		  $days_between = ceil(abs($t2 - $t1) / 86400);
		    if($days_between<=30)
			{
			$totalamount30=$totalamount30-$pending12;
			}


			if($days_between>30 && $days_between<=60)
			{
			$total60=$total60-$pending12;
			}
			if($days_between>60 && $days_between<=90)
			{
			$total90=$total90-$pending12;
			}
			if($days_between>90 && $days_between<=120)
			{
			$total120=$total120-$pending12;
			}
			if($days_between>120 && $days_between<=180)
			{
			$total180=$total180-$pending12;
			}
			if($days_between>180)
			{
			$total210=$total210-$pending12;
			}


			  if($pending12 !=''){	
				$totalamount1 = $totalamount1 - $pending12;
				$totalamount301 = $totalamount301 - $pending12;
				$totalamount601 = $totalamount601 + $totalamount30;
				$totalamount901 = $totalamount901 + $total60;
				$totalamount1201 = $totalamount1201 + $total90;
				$totalamount1801 = $totalamount1801 + $total120;
				$totalamount2101 = $totalamount2101 + $total180;
				$totalamount2401 = $totalamount2401 + $total210;
				

				$ftotalamount1 = $ftotalamount1 - $pending12;
				$ftotalamount301 = $ftotalamount301 - $pending12;
				$ftotalamount601 = $ftotalamount601 + $totalamount30;
				$ftotalamount901 = $ftotalamount901 + $total60;
				$ftotalamount1201 = $ftotalamount1201 + $total90;
				$ftotalamount1801 = $ftotalamount1801 + $total120;
				$ftotalamount2101 = $ftotalamount2101 + $total180;
				$ftotalamount2401 = $ftotalamount2401 + $total210;
			//echo $cashamount;
			}

				$res2transactionamount=0;
				$invoicevalue=0;
				$totalamount30=0;
				$totalamount60=0;
				$totalamount90=0;
				$totalamount120=0;
				$totalamount180=0;
				$totalamount210=0;			
				$totalamount302=0;
				$totalamount602=0;
				$totalamount902=0;
				$totalamount1202=0;
				$totalamount1802=0;
				$totalamount2102=0;
				$total60=0;
				$total90=0;
				$total120=0;
				$total180=0;
				$total210=0;
			}

			///////////////////////

		  // $checktotal = $totalamount301+$totalamount601+$totalamount901+$totalamount1201+$totalamount1801+$totalamount2101+$totalamount2401;


			if($totalamount301!=0	||	$totalamount601!=0	||	$totalamount901!=0	||	$totalamount1201!=0	||	$totalamount1801!=0	||	$totalamount2101!=0	||	$totalamount2401!=0) 
				// if(1)
				{

				$snocount = $snocount + 1;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				$colorcode = 'bgcolor="#ecf0f5"';
			}


			?>

			<tr <?php echo $colorcode; ?>>

			<td align="left" class="bodytext3"><?php echo $snocount; ?></td>
			 <?php // echo //$res21suppliercode; ?> 

			<td align="left" class="bodytext3"><?php echo $res21suppliercode; ?></td>

			 <td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($totalamount301,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($totalamount601,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($totalamount901,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($totalamount1201,2,'.',','); ?></td>

				 <td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($totalamount1801,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($totalamount2101,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right" 

                ><?php echo number_format($totalamount2401,2,'.',','); ?></td>

            </tr>

			<?php


			}

				$totalamount1 = 0;

				$totalamount301 = 0;

				$totalamount601 = 0;

				$totalamount901 = 0;

				$totalamount1201 = 0;

				$totalamount1801 = 0;

				$totalamount2101 = 0;

				$totalamount2401 = 0;

			

		  }

			?>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="center" 

                bgcolor="#ecf0f5"><strong>Total:</strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($ftotalamount301,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($ftotalamount601,2,'.',','); ?></strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($ftotalamount901,2,'.',','); ?></strong></td>

				 <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($ftotalamount1201,2,'.',','); ?></strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($ftotalamount1801,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($ftotalamount2101,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($ftotalamount2401,2,'.',','); ?></strong></td>

            </tr>

			<tr>

			<?php

			

				$urlpath = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&searchsuppliercode=$arraysuppliercode";

			

			?>

			 <td colspan="8"></td>

		   	 <td class="bodytext31" valign="center"  align="right"><a href="print_fullcredittoranalysissummary.php?<?php echo $urlpath; ?>"><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;"></a>

             <a href="print_fullcredittoranalysissummarypdf.php?<?php echo $urlpath; ?>"><img src="images/pdfdownload.jpg" width="40" height="40"></a></td>

			</tr>     

			   <?php

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


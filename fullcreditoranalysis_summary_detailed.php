<?php

session_start();

error_reporting(0);

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


$totalamount1_final =0;
$totalamount301_final =0;
$totalamount601_final =0;
$totalamount901_final =0;
$totalamount1201_final =0;
$totalamount1801_final =0;
$totalamount2101_final =0;
$totalamount2401_final =0;


$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Full Creditor Analysis - Summary & Detailed</title>
<!-- Modern CSS -->
<link href="css/fullcreditoranalysis_summary_detailed-modern.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<link href="css/three.css" rel="stylesheet" type="text/css">
<!-- Modern JavaScript -->
<script type="text/javascript" src="js/fullcreditoranalysis_summary_detailed-modern.js?v=<?php echo time(); ?>"></script>
</head>

<body>

<header>
  <?php include ("includes/alertmessages1.php"); ?>
  <?php include ("includes/title1.php"); ?>
  <?php include ("includes/menu1.php"); ?>
</header>

<main class="main-container">
<?php

$balanceamount = "0.00";

$openingbalance = "0.00";

$total = '0.00';

$searchsuppliername = "";

$searchsuppliername1 = "";

$cbsuppliername = "";

$snocount = "";

$colorloopcount="";

$range = "";

$totalamount = "0.00";

$totalamount30 = "0.00";

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

$totalamount2401 = "0.00";

//This include updatation takes too long to load for hunge items database.

//include("autocompletebuild_subtype.php");



//include ("autocompletebuild_account3.php");





if (isset($_REQUEST["searchsuppliername1"])) { $searchsuppliername1 = $_REQUEST["searchsuppliername1"]; } else { $searchsuppliername1 = ""; }



if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

//echo $searchsuppliername;

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

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

<!--<script type="text/javascript" src="js/autocomplete_subtype.js"></script>

<script type="text/javascript" src="js/autosuggestsubtype.js"></script>



<script type="text/javascript" src="js/autocomplete_accounts3.js"></script>

<script type="text/javascript" src="js/autosuggest5accounts.js"></script>

<script type="text/javascript">

window.onload = function () 

{

	var oTextbox = new AutoSuggestControl1(document.getElementById("searchsuppliername1"), new StateSuggestions1());

	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        

}





</script>-->



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

	source:"ajaxsupplieraccount_new.php?accountssub="+$("#accountssub").val()+"",			// by Kenique 22 Nov 2018

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

 function showsub(subtypeano)
{
	 // alert(subtypeano);
		if(document.getElementById('hide'+subtypeano) != null)
		{
			if(document.getElementById('hide'+subtypeano).style.display == 'none')
			{
			document.getElementById('hide'+subtypeano).style.display = '';
			}
			else
			{
			document.getElementById('hide'+subtypeano).style.display = 'none';
			}
		}
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

    <td colspan="10" ><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" ><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" ><?php include ("includes/menu1.php"); ?></td>

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

		

		

              <form name="cbform1" method="post" >

		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="4"  class="bodytext3"><strong>Full Creditor Analysis Detailed</strong></td>

              </tr>

            <!--<tr>

              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">

			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 

                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 

				</td>

              </tr>-->

			  <!-- <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Subtype </td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

              <input name="searchsuppliername1" type="text" id="searchsuppliername1" value="<?php echo $searchsuppliername1; ?>" size="50" autocomplete="off">

              <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">

			  <input name="searchsubtypeanum1" id="searchsubtypeanum1" value="" type="hidden">

			  </span></td>

           </tr>-->

		<!-- // Added by Kenique 22 Nov 2018 -->

	<!-- 	  <tr>

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
 				 <?php
           	if($ADate1!=''){
           			$paymentreceiveddatefrom=$_REQUEST['ADate1'];
           			$paymentreceiveddateto=$_REQUEST['ADate2'];

           			if($searchsuppliername!=''){

           				if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }
           			}


           		 
           	}
           ?>
            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Supplier </td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

              <input name="searchsuppliername" type="text" id="searchsuppliername"  value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">

              <input name="searchsuppliernamehiddentextbox" id="searchsuppliernamehiddentextbox" value="" type="hidden">

			  <input name="searchaccountnameanum1" id="searchaccountnameanum1" value="" type="hidden">

			  </span></td>

           </tr>

		   

			  <tr>

                      <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF"> Date From </td>

                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>

                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>

                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">

                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>

                    </tr>	

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">


              	<input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>

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

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 

            align="left" border="0">

          <tbody>

            <tr>

              <td width="4%"  class="bodytext31">&nbsp;</td>

              <td colspan="12"  class="bodytext31"><span class="bodytext311">

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

 				<?php

				//For excel file creation.

				

				$applocation1 = $applocation1; //Value from db_connect.php file giving application path.

				$filename1 = "print_paymentgivenreport1.php?$urlpath";

				$fileurl = $applocation1."/".$filename1;

				$filecontent1 = @file_get_contents($fileurl);

				

				$indiatimecheck = date('d-M-Y-H-i-s');

				$foldername = "dbexcelfiles";

				$fp = fopen($foldername.'/PaymentGivenToSupplier.xls', 'w+');

				fwrite($fp, $filecontent1);

				fclose($fp);



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

><strong>No.</strong></td>

              <td width="22%" align="left" valign="center"  

 class="bodytext31"><div align="left"><strong>Supplier Name</strong></div></td>

				<td width="10%" align="left" valign="center"  

 class="bodytext31"><div align="left"><strong>GRN No</strong></div></td>

             <!-- <td width="22%" align="left" valign="right"  

 class="bodytext31"><strong> Patient </strong></td>-->

               <td width="10%" align="left" valign="center"  class="bodytext31"><strong>Invoice No</strong></td>

              <td width="10%" align="left" valign="center"   class="bodytext31"><strong> Invoice Date </strong></td>

              <td width="10%" align="left" valign="center"    class="bodytext31"><div align="right"><strong>Invoice Amt</strong></div></td>

				<td width="6%" align="left" valign="center"  

 class="bodytext31"><div align="right"><strong>Bal. Amt</strong></div></td>

				<td width="5%" align="left" valign="center"  

 class="bodytext31"><div align="right"><strong>30 days</strong></div></td>

              <td width="5%" align="left" valign="center"  

 class="bodytext31"><div align="right"><strong>60 days </strong></div></td>

				<td width="6%" align="left" valign="center"  

 class="bodytext31"><div align="right"><strong>90 days </strong></div></td>

			<td width="6%" align="left" valign="center"  

 class="bodytext31"><div align="right"><strong>120 days </strong></div></td>

				<td width="6%" align="left" valign="center"  

 class="bodytext31"><div align="right"><strong>180 days </strong></div></td>

				<td width="7%" align="left" valign="center"  

 class="bodytext31"><div align="right"><strong>180+ days </strong></div></td>

			  </tr>

			<?php

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

			if ($cbfrmflag1 == 'cbfrmflag1')

			{

			

			$arraysupplier = $searchsuppliername;

			$arraysuppliername = $arraysupplier;

			$searchsuppliername = trim($arraysuppliername);

			$arraysuppliercode = trim($_REQUEST['searchsuppliercode']);

			$searchsuppliername = trim($searchsuppliername);

			

			if($arraysuppliercode == '') {

			$query212 = "select suppliercode,suppliername from master_transactionpharmacy where transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PURCHASE' group by suppliername order by suppliername desc ";

			} else {

			$query212 = "select suppliercode,suppliername from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PURCHASE' group by suppliername order by suppliername desc ";

			}

			$exec212 = mysqli_query($GLOBALS["___mysqli_ston"], $query212) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $num_main=mysqli_num_rows($exec212);
			while ($res212 = mysqli_fetch_array($exec212))

			{

				// echo 1;

			$res21suppliername = $res212['suppliername'];

			$res21suppliercode = $res212['suppliercode'];

			// if($num_main==0){
			// 	$res21suppliername = $searchsuppliername;
			// 	$res21suppliercode = $arraysuppliercode;
			// }

			

			$query222 = "select * from master_accountname where id = '$res21suppliercode' and recordstatus <>'DELETED' ";

			$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res222 = mysqli_fetch_array($exec222);

			$res22accountname = $res222['accountname'];
			$res22accountautonum = $res222['auto_number'];
			$id = $res222['id'];



			if( $res21suppliername != '')

			{

				//////////////// for opening Balance //////////
				$totalamount30=0;
			$total60=0;
			$total90=0;
			$total120=0;
			$total180=0;
			$total210=0;
			$invoicevalue1=0;
			$invoicevalue2=0;
				// $querycr1op = "SELECT sum(-1*`transactionamount`) as payables, suppliercode as code, CONCAT('Payment - ',remarks) as name, docno as docno, transactiondate as date_entry,chequenumber as chequenum FROM `master_transactionpharmacy` WHERE `suppliercode` = '$id' AND `transactionmodule` = 'PAYMENT' AND (`docno` LIKE 'SP%' or `docno` LIKE 'SPE%') AND `transactiondate` < '$ADate1'  and billnumber NOT LIKE 'PV%'

						 

				// 		 UNION ALL SELECT sum(-1*`totalamount`) as payables,suppliercode as code, CONCAT('Return - ',suppliername) as name, billnumber as docno, entrydate as date_entry,typeofreturn as chequenum FROM `purchasereturn_details` WHERE `suppliercode` = '$id' AND billnumber NOT LIKE 'SPCA%' AND `entrydate` < '$ADate1'

						 

				// 		 UNION ALL SELECT sum(-1*`debitamount`) as payables, locationcode as code, CONCAT('Journal - ',ledgername) as name, docno as docno, entrydate as date_entry,vouchertype as chequenum FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Dr' AND `entrydate` < '$ADate1'

						 

				// 		 UNION ALL SELECT sum(-1*`transactionamount`) as payables,expensecoa as code, remarks as name, docnumber as docno, transactiondate as date_entry, chequenumber as chequenum FROM `expensesub_details` WHERE `expensecoa` = '$id' AND transactionmode <> 'ADJUSTMENT' AND transactiondate < '$ADate1'

						

				// 		 UNION ALL SELECT sum(-1*`openbalanceamount`) as payables, docno as code, CONCAT('Opening Balance as of may 1st - ',accountname) as name, docno as docno, entrydate as date_entry, 'Opening Balance' as chequenum FROM `openingbalanceaccount` WHERE `accountcode` = '$id' AND `entrydate` < '$ADate1'

						

				// 		UNION ALL SELECT sum(`openbalanceamount`) as payables, docno as code, CONCAT('Opening Balance as of may 1st - ',accountname) as name, docno as docno, entrydate as date_entry, 'Opening Balance' as chequenum FROM `openingbalancesupplier` WHERE `accountcode` = '$id' AND `entrydate` < '$ADate1' and payablestatus ='1'

						

				// 		 UNION ALL SELECT sum(`transactionamount`) as payables, suppliercode as code, CONCAT('Purchase - ',suppliername) as name, billnumber as docno, transactiondate as date_entry,chequenumber as chequenum FROM `master_transactionpharmacy` WHERE `suppliercode` = '$id' AND `billnumber` NOT LIKE 'SUPO%' AND `transactiontype` = 'PURCHASE' AND `transactiondate` < '$ADate1'  and billnumber NOT LIKE 'PV%'

				// 		 UNION ALL SELECT sum(`creditamount`) as payables, locationcode as code, CONCAT('Journal - ',ledgername) as name, docno as docno, entrydate as date_entry,vouchertype as chequenum FROM `master_journalentries` WHERE `ledgerid` = '$id' AND selecttype = 'Cr' AND `entrydate` < '$ADate1'

				// 		 UNION ALL SELECT sum(`totalamount`) as payables,suppliercode as code, CONCAT('Payable Credit - ',suppliername) as name, billnumber as docno, entrydate as date_entry,typeofreturn as chequenum FROM `purchasereturn_details` WHERE `suppliercode` = '$id' AND billnumber LIKE 'SPCA%' AND `entrydate` < '$ADate1'

				// 		 UNION ALL SELECT sum(-total_amount) as payables, '' as code, '' as name, approve_id as docno, date(created_at) as date_entry, '' as chequenum  from supplier_debit_transactions where supplier_id = '$id' and date(created_at) < '$ADate1'
 
				// 		 ";

				// 		$execcr1 = mysql_query($querycr1op) or die ("Error in querycr1op".mysql_error());

				// 		while($rescr1 = mysql_fetch_array($execcr1))

				// 		{

				// 			$payables = $rescr1['payables'];
				// 			$entrydate = $rescr1['date_entry'];
				// 			 $rescr1docno = $rescr1['docno'];
				// 			// $payables = $payables / $exchange_rate;
				// 		    $openingbalance += $payables;


						    

							// $total_allocated_amount=0;
			    //         	$query3 = "SELECT * from master_transactionpharmacy where  docno = '$rescr1docno' and recordstatus = 'allocated' order by auto_number desc"; 
							// $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
							// $num=mysql_num_rows($exec3);
							// while ($res3 = mysql_fetch_array($exec3)) {  $total_allocated_amount +=$res3['transactionamount']; }
							// if($total_allocated_amount!=0){
							// 	// echo $total_allocated_amount;
							//    $pending_amountfromdb=$payables+$total_allocated_amount;
							// }


						// 	$query3 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$id' and billnumber = '$rescr1docno'  and transactiontype = 'PAYMENT' and recordstatus = 'allocated' and transactiondate < '$ADate1'";
						// 	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
						// 	$res3 = mysql_fetch_array($exec3);
						// 	$res3transactionamount = $res3['transactionamount1'];

						// 	$res4return = 0;
						// 	$query4 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$id' and grnbillnumber = '$rescr1docno' and entrydate < '$ADate1'
						// 		UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$id' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$rescr1docno' and transactiontype = 'PURCHASE' and transactiondate < '$ADate1' )";
						// 	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
						// 	while($res4 = mysql_fetch_array($exec4))
						// 	{
						// 		$res4return += $res4['totalreturn'];
						// 	}
						// 	  $invoicevalue1 +=  $payables - ($res3transactionamount + $res4return);
						// 	 // echo $invoicevalue1 +=  $payables - ($res3transactionamount + $res4return)-$total_allocated_amount+$pending_amountfromdb;
						// }
						

					$query1 = "SELECT billdate as date_entry,totalamount as payables, billnumber as billnumber from master_purchase where suppliercode = '$id' and recordstatus <> 'deleted' and billdate < '$ADate1'   group by billnumber
					 UNION ALL SELECT date(created_at) as date_entry, (-1*total_amount) as payables,  approve_id as billnumber from supplier_debit_transactions where supplier_id = '$id' and date(created_at) < '$ADate2'
					  ";
					$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num1 = mysqli_num_rows($exec1);
					while($res1 = mysqli_fetch_array($exec1))
					{
					$entrydate  = $res1['date_entry'];
					$rescr1docno = $res1['billnumber'];
					$payables = $res1['payables'];
					$openingbalance += $payables;


					$query3 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$id' and billnumber = '$rescr1docno'  and transactiontype = 'PAYMENT' and recordstatus = 'allocated' and transactiondate <= '$ADate2'";
							$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
							$res3 = mysqli_fetch_array($exec3);
							$res3transactionamount = $res3['transactionamount1'];
							
							$res4return = 0;
							$query4 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$id' and grnbillnumber = '$rescr1docno' and entrydate <= '$ADate2'
								UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$id' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$rescr1docno' and transactiontype = 'PURCHASE' and transactiondate <= '$ADate2' )";
							$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
							while($res4 = mysqli_fetch_array($exec4))
							{
								$res4return += $res4['totalreturn'];
							}

								/////// for grns///////////////////////////////////
									$total_allocated_amount=0;
									// $query3 = "SELECT * from master_transactionpharmacy where  billnumber = '$rescr1docno' and recordstatus = 'allocated' and transactiondate < '$ADate1' order by auto_number desc";
									// $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
									// while ($res3 = mysql_fetch_array($exec3))
									// {
									// $total_allocated_amount +=$res3['transactionamount'];
									// }
									/////////// for sdbts /////////////////
									$total_allocated_amount2=0;
					            	 $query3 = "SELECT * from master_transactionpharmacy where  docno = '$rescr1docno' and recordstatus = 'allocated' and transactiondate <= '$ADate2' order by auto_number desc"; 
									$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
									$num123=mysqli_num_rows($exec3);
									while ($res3 = mysqli_fetch_array($exec3)) { $total_allocated_amount2 +=$res3['transactionamount']; }
									// echo number_format($debitamount_sbdt-$total_allocated_amount,2,'.',',');
									if($num123>0){
											 $pending_amountfromdb=$payables+$total_allocated_amount2;
										}
									///////////////////////////////////
										if($num123>0){
											 $invoicevalue1 =  ($res3transactionamount + $res4return)-$total_allocated_amount+$pending_amountfromdb;
							  				$invoicevalue2 +=  ($res3transactionamount + $res4return)-$total_allocated_amount+$pending_amountfromdb;

										}else{
							  				$invoicevalue1 =  $payables - ($res3transactionamount + $res4return)-$total_allocated_amount;
							  				$invoicevalue2 +=  $payables - ($res3transactionamount + $res4return)-$total_allocated_amount;
											}


							  $t1 = strtotime($entrydate);
					    	  $t2 = strtotime($ADate2);
							  $days_between = ceil(abs($t2 - $t1) / 86400);
							    if($days_between<30) { $totalamount30=$totalamount30+$invoicevalue1; }
								if($days_between>30 && $days_between<=60) { $total60=$total60+$invoicevalue1; }
								if($days_between>60 && $days_between<=90){ $total90=$total90+$invoicevalue1; }
								if($days_between>90 && $days_between<=120) { $total120=$total120+$invoicevalue1; }
								if($days_between>120 && $days_between<=180) { $total180=$total180+$invoicevalue1; }
								if($days_between>180){ $total210=$total210+$invoicevalue1; }

									
								}


									// $totalamount1=$totalamount1+$payables;
									// $totalamount301=$totalamount301+$invoicevalue1;

									$totalamount1=$totalamount1+$openingbalance;
									$totalamount301=$totalamount301+$invoicevalue2;
									$totalamount601=$totalamount601+$totalamount30;
									$totalamount901=$totalamount901+$total60;
									$totalamount1201=$totalamount1201+$total90;
									$totalamount1801=$totalamount1801+$total120;
									$totalamount2101=$totalamount2101+$total180;
									$totalamount2401=$totalamount2401+$total210;
							 
 


					// $snocount = $snocount + 1;
				//////////////// for opening Balance //////////

			?>

			<!-- <tr >
		            <td colspan="13"  align="left" valign="center" bgcolor="#fff" class="bodytext31"  onClick="showsub(<?=$res22accountautonum?>)"><strong><?php //echo strtoupper($res22accountname);?> </strong></td>
		           
        	</tr> -->
        	 <!-- <td colspan="2"  align="left" valign="center" bgcolor="#fff" class="bodytext31"  onClick="showsub(<?=$res22accountautonum?>)"><strong>Opening Balance : </strong></td> -->

        	<tr  bgcolor="#ff944d" onClick="showsub(<?=$res22accountautonum?>)">
            		<td colspan="3" class="bodytext31" valign="center"  align="left"><strong><?php echo strtoupper($res22accountname);?></strong></td>
            		 <td colspan="2" class="bodytext31" valign="center"  align="left"><div class="bodytext31">Opening Balance : </div></td>
            		 <!-- <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
            		 <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
            		 <td class="bodytext31" valign="center"  align="left">&nbsp;</td> -->
            		 <td class="bodytext31" valign="center"  align="right"> <div align="right"><?php echo number_format($openingbalance,2,'.',','); ?></div></td>
            		 <td class="bodytext31" valign="center"  align="right"> <div align="right"><?php echo number_format($invoicevalue2,2,'.',','); ?></div></td>
            		 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalamount30,2,'.',','); ?></div></td>
            		 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($total60,2,'.',','); ?></div></td>
            		 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($total90,2,'.',','); ?></div></td>
            		 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($total120,2,'.',','); ?></div></td>
            		 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($total180,2,'.',','); ?></div></td>
            		 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($total210,2,'.',','); ?></div></td>

           </tr>


             <!-- <td colspan="1"  align="right" valign="center" bgcolor="#fff" class="bodytext31"><strong><?php echo number_format($openingbalance,2,'.',','); $openingbalance=0;?></strong></td> -->
            <!-- (Date From: <?php //echo $ADate1; ?> Date To: <?php echo $ADate2;?>) -->
            <!-- <td colspan="15"  align="left" valign="center"  class="bodytext31" onClick="showsub(<?=$subtypeanum?>)"><strong><?php //echo $subtype; ?> </strong></td> -->

            </tr> 
            <tbody id="hide<?=$res22accountautonum?>" style="display:none">


			<?php

			
			$totalamount30=0;
			$total60=0;
			$total90=0;
			$total120=0;
			$total180=0;
			$total210=0;
			

			$dotarray = explode("-", $paymentreceiveddateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			$searchsuppliername1 = trim($searchsuppliername1);

			$res21suppliername = trim($res21suppliername);

		  

		  //$query1 = "select * from master_transactionpharmacy where suppliercode = '$res21suppliercode' and transactiondate between '$ADate1' and '$ADate2' group by billnumber order by suppliername";

		   $query1 = "select * from master_purchase where suppliercode = '$res21suppliercode' and recordstatus <> 'deleted' and billdate between '$ADate1' and '$ADate2'  and companyanum = '$companyanum' group by billnumber order by billdate asc";

		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		   $num1 = mysqli_num_rows($exec1);

		  while($res1 = mysqli_fetch_array($exec1))

		  {

		  $res1suppliername = $res1['suppliername'];

		  $res1suppliercode = $res1['suppliercode'];

		  $res1transactiondate  = $res1['billdate'];

		  $res1billnumber = $res1['billnumber'];

		  $res2transactionamount = $res1['totalamount'];

		  $supplierbillnumber = $res1['supplierbillnumber'];

		  /*$res1patientname = $res1['patientname'];

		  $res1visitcode = $res1['visitcode'];*/

		  

		  $query2 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$ADate1' and '$ADate2'";

		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res2 = mysqli_fetch_array($exec2);

		  //$res2transactionamount = $res2['transactionamount1'];

		  

		  $query3 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'PAYMENT' and recordstatus = 'allocated' and transactiondate between '$ADate1' and '$ADate2'";

		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res3 = mysqli_fetch_array($exec3);

		   $res3transactionamount = $res3['transactionamount1'];

		  

		  $res4return = 0;

		  $query4 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber = '$res1billnumber' and entrydate between '$ADate1' and '$ADate2'

		  UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$ADate1' and '$ADate2')";

		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res4 = mysqli_fetch_array($exec4))

		  {

		  	$res4return += $res4['totalreturn'];

		  }

		  

		  /*$query4 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'paylatercredit'";

		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());

		  $res4 = mysql_fetch_array($exec4);

		  $res4transactionamount = $res4['transactionamount'];

		  

		  $query5 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'pharmacycredit'";

		  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());

		  $res5 = mysql_fetch_array($exec5);

		  $res5transactionamount = $res5['transactionamount'];*/

		  ///////////////// sdbt allocated for grn numbers//////////
		  $total_allocated_amount=0;
		  // $query3 = "SELECT * from master_transactionpharmacy where  billnumber = '$res1billnumber' and recordstatus = 'allocated' order by auto_number desc";
				// $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
				// // $num=mysql_num_rows($exec3);
				// // 	if($num>0){
				// while ($res3 = mysql_fetch_array($exec3))
				// {
				// 		$total_allocated_amount +=$res3['transactionamount'];
				// }

		  ///////////////// sdbt allocated for grn numbers//////////
		  ///////////////// SPE  for grn numbers//////////
				$res5transactionamount_spe=0;
			// 	$query5 = "select * from master_transactionpharmacy where billnumber = '$res1billnumber' and transactionmodule = 'PAYMENT'  and recordstatus <> 'deallocated'  order by transactiondate desc";
			// 	// $query5 = "select * from master_transactionpharmacy where billnumber = '$res1billnumber' and transactiondate between '$ADate1' and '$ADate2' and transactionmodule = 'PAYMENT'  and recordstatus <> 'deallocated'  order by transactiondate desc";
		 //  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		 //  $num5 = mysql_num_rows($exec5);
		 //  if($num5 > 0)
		 //  {
			//   while($res5 = mysql_fetch_array($exec5))
			//   {
			// 	  $res5billnumber = $res5['billnumber'];
			// 	  $res5openingbalance = $res5['openingbalance'];
			// 	  $res5docnumber = $res5['docno'];
			// 	  $res5transactionamount = $res5['transactionamount'];
			// 	  $res5transactionamount_spe += $res5['transactionamount'];
			// 	}
			// }
		  ///////////////// SPE  for grn numbers//////////

		  $invoicevalue =  $res2transactionamount - ($res3transactionamount + $res4return)-$total_allocated_amount-$res5transactionamount_spe;
		  $creditamount =  $res2transactionamount - ($res3transactionamount + $res4return);

		  $t1 = strtotime($res1transactiondate);
    	  $t2 = strtotime($ADate2);
		  $days_between = ceil(abs($t2 - $t1) / 86400);

		  if($days_between<30) { $totalamount30=$totalamount30+$invoicevalue; }
			if($days_between>30 && $days_between<=60) { $total60=$total60+$invoicevalue; }
			if($days_between>60 && $days_between<=90){ $total90=$total90+$invoicevalue; }
			if($days_between>90 && $days_between<=120) { $total120=$total120+$invoicevalue; }
			if($days_between>120 && $days_between<=180) { $total180=$total180+$invoicevalue; }
			if($days_between>180) { $total210=$total210+$invoicevalue; }

		  // if($invoicevalue>0)

		  // {

		  // $date1 = 30;

		  // $date2 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date1)); 

		  

		  // $query8 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date2' and '$ADate2' ";

		  // $exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());

		  // $res8 = mysql_fetch_array($exec8);

		  // $res8transactionamount = $res8['transactionamount1'];

	      

		  // $query9 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'PAYMENT'  and transactiondate between '$date2' and '$ADate2' and recordstatus = 'allocated'";

		  // $exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());

		  // $res9 = mysql_fetch_array($exec9);

		  // $res9transactionamount = $res9['transactionamount1'];

		  

		  // $res10return = 0;

		  // $query10 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber = '$res1billnumber' and entrydate between '$date2' and '$ADate2' 

		  // UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date2' and '$ADate2')";

		  // $exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());

		  // while($res10 = mysql_fetch_array($exec10))

		  // {

		  // $res10return += $res10['totalreturn'];

		  // }

		  

		  // /*$query10 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'paylatercredit'  and transactiondate between '$date2' and '$ADate2'";

		  // $exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());

		  // $res10 = mysql_fetch_array($exec10);

		  // $res10transactionamount = $res10['transactionamount'];

	

		  // $query12 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'pharmacycredit'  and transactiondate between '$date2' and '$ADate2'";

		  // $exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());

		  // $res12 = mysql_fetch_array($exec12);

		  // $res12transactionamount = $res12['transactionamount'];*/

		  

		  // $totalamount30 = $res8transactionamount - ($res9transactionamount + $res10return);

		  

		  // $t1 = strtotime($res1transactiondate);

    // 	  $t2 = strtotime($ADate2);

		  // $days_between = ceil(abs($t2 - $t1) / 86400);

		  

		  // if($days_between>30 && $days_between<=60)

		  // {

		  // $date3 = 60;

		  // $date4 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date3)); 

		  

		  // $query13 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date4' and '$ADate2' ";

		  // $exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());

		  // $res13 = mysql_fetch_array($exec13);

		  // $res13transactionamount = $res13['transactionamount1'];

	      

		  // $query14 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'PAYMENT' and transactiondate between '$date4' and '$ADate2' and recordstatus = 'allocated'";

		  // $exec14 = mysql_query($query14) or die ("Error in Query14".mysql_error());

		  // $res14 = mysql_fetch_array($exec14);

		  // $res14transactionamount = $res14['transactionamount1'];

		  

		  // $res15return = 0;

		  // $query15 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date4' and '$ADate2')

		  // UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber = '$res1billnumber' and entrydate between '$date4' and '$ADate2' ";

		  // $exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());

		  // while($res15 = mysql_fetch_array($exec15))

		  // {

		  // $res15return += $res15['totalreturn'];

		  // }

		  

		  // $totalamount60 = $res13transactionamount - ($res14transactionamount + $res15return);

		  

		  // $total60 = $totalamount60 - $totalamount30;

		  // }

		  

		  // if($days_between>60 && $days_between<=90)

		  // {

		  // $date5 = 90;

		  // $date6 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date5));

		  

		  // $query17 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date6' and '$ADate2' ";

		  // $exec17 = mysql_query($query17) or die ("Error in Query17".mysql_error());

		  // $res17 = mysql_fetch_array($exec17);

		  // $res17transactionamount = $res17['transactionamount1'];

	      

		  // $query18 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'PAYMENT' and transactiondate between '$date6' and '$ADate2' and recordstatus = 'allocated'";

		  // $exec18 = mysql_query($query18) or die ("Error in Query18".mysql_error());

		  // $res18 = mysql_fetch_array($exec18);

		  // $res18transactionamount = $res18['transactionamount1'];

		  

		  // $res19return = 0;

		  // $query19 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date6' and '$ADate2')

		  // UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber = '$res1billnumber' and entrydate between '$date6' and '$ADate2'";

		  // $exec19 = mysql_query($query19) or die ("Error in Query19".mysql_error());

		  // while($res19 = mysql_fetch_array($exec19))

		  // {

		  // $res19return += $res19['totalreturn'];

		  // }

		  

		  // /*$query19 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'paylatercredit' and transactiondate between '$date6' and '$ADate2'";

		  // $exec19 = mysql_query($query19) or die ("Error in Query19".mysql_error());

		  // $res19 = mysql_fetch_array($exec19);

		  // $res19transactionamount = $res19['transactionamount'];

	

		  // $query20 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'pharmacycredit' and transactiondate between '$date6' and '$ADate2'";

		  // $exec20 = mysql_query($query20) or die ("Error in Query20".mysql_error());

		  // $res20 = mysql_fetch_array($exec20);

		  // $res20transactionamount = $res20['transactionamount'];*/

		  

		  // $totalamount90 = $res17transactionamount - ($res18transactionamount + $res19return) /* + $res19transactionamount + $res20transactionamount*/;

		  

		  // $total90 = $totalamount90 - $totalamount60;

		  // }

		  

		  // if($days_between>90 && $days_between<=120)

		  // {

		  // $date7 = 120;

		  // $date8 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date7));

		  

		  // $query21 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date8' and '$ADate2' ";

		  // $exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());

		  // $res21 = mysql_fetch_array($exec21);

		  // $res21transactionamount = $res21['transactionamount1'];

	      

		  // $query22 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'PAYMENT' and transactiondate between '$date8' and '$ADate2' and recordstatus = 'allocated'";

		  // $exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());

		  // $res22 = mysql_fetch_array($exec22);

		  // $res22transactionamount = $res22['transactionamount1'];

		  

		  // $res23return = 0;

		  // $query23 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date8' and '$ADate2')

		  // UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber = '$res1billnumber' and entrydate between '$date8' and '$ADate2'";

		  // $exec23 = mysql_query($query23) or die ("Error in Query23".mysql_error());

		  // while($res23 = mysql_fetch_array($exec23))

		  // {

		  // $res23return += $res23['totalreturn'];

		  // }

		  // /*$query23 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'paylatercredit' and transactiondate between '$date8' and '$ADate2'";

		  // $exec23 = mysql_query($query23) or die ("Error in Query23".mysql_error());

		  // $res23 = mysql_fetch_array($exec23);

		  // $res23transactionamount = $res23['transactionamount'];

	

		  // $query24 = "select * from  master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'pharmacycredit' and transactiondate between '$date8' and '$ADate2'";

		  // $exec24 = mysql_query($query24) or die ("Error in Query24".mysql_error());

		  // $res24 = mysql_fetch_array($exec24);

		  // $res24transactionamount = $res24['transactionamount'];*/

		  

		  // $totalamount120 = $res21transactionamount - ($res22transactionamount + $res23return)/* + $res23transactionamount + $res24transactionamount*/;

		  

		  // $total120 = $totalamount120 - $totalamount90;

		  // }

		  

		  // if($days_between>120 && $days_between<=180)

		  // {

		  // $date9 = 180;

		  // $date10 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date9));

		  

		  // $query25 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date10' and '$ADate2' ";

		  // $exec25 = mysql_query($query25) or die ("Error in Query25".mysql_error());

		  // $res25 = mysql_fetch_array($exec25);

		  // $res25transactionamount = $res25['transactionamount1'];

	      

		  // $query26 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'PAYMENT' and transactiondate between '$date10' and '$ADate2' and recordstatus = 'allocated'";

		  // $exec26 = mysql_query($query26) or die ("Error in Query26".mysql_error());

		  // $res26 = mysql_fetch_array($exec26);

		  // $res26transactionamount = $res26['transactionamount1'];

		  

		  // $res27return = 0;

		  // $query27 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber = '$res1billnumber' and entrydate between '$date10' and '$ADate2'

		  // UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date10' and '$ADate2')";

		  // $exec27 = mysql_query($query27) or die ("Error in Query27".mysql_error());

		  // while($res27 = mysql_fetch_array($exec27))

		  // {

		  // $res27return += $res27['totalreturn'];

		  // }

		  

		  // /*$query27 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'paylatercredit' and transactiondate between '$date10' and '$ADate2'";

		  // $exec27 = mysql_query($query27) or die ("Error in Query27".mysql_error());

		  // $res27 = mysql_fetch_array($exec27);

		  // $res27transactionamount = $res27['transactionamount'];

	

		  // $query28 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'pharmacycredit' and transactiondate between '$date10' and '$ADate2'";

		  // $exec28 = mysql_query($query28) or die ("Error in Query28".mysql_error());

		  // $res28 = mysql_fetch_array($exec28);

		  // $res28transactionamount = $res28['transactionamount'];*/

		  

		  // $totalamount180 = $res25transactionamount - ($res26transactionamount + $res27return)/* + $res27transactionamount + $res28transactionamount*/;

		  

		  // $total180 = $totalamount180 - $totalamount120;

		  // }

		  

		  // if($days_between>180)

		  // {

		  // $date11 = 2100;

		  // $date12 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date11));

		  

		  // $query29 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date12' and '$ADate2' ";

		  // $exec29 = mysql_query($query29) or die ("Error in Query29".mysql_error());

		  // $res29 = mysql_fetch_array($exec29);

		  // $res29transactionamount = $res29['transactionamount1'];

	      

		  // $query30 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'PAYMENT' and transactiondate between '$date12' and '$ADate2' and recordstatus = 'allocated'";

		  // $exec30 = mysql_query($query30) or die ("Error in Query30".mysql_error());

		  // $res30 = mysql_fetch_array($exec30);

		  // $res30transactionamount = $res30['transactionamount1'];

		  

		  // $res31return = 0;

		  // $query31 = "select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber = '$res1billnumber' and entrydate between '$date12' and '$ADate2'

		  // UNION ALL select sum(subtotal) as totalreturn from purchasereturn_details where suppliercode = '$res1suppliercode' and grnbillnumber IN (select mrnno from master_transactionpharmacy where billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date12' and '$ADate2')";

		  // $exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());

		  // while($res31 = mysql_fetch_array($exec31))

		  // {

		  // $res31return += $res31['totalreturn'];

		  // }

		  

		  // /*$query31 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber' and transactiontype = 'paylatercredit' and transactiondate between '$date12' and '$ADate2'";

		  // $exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());

		  // $res31 = mysql_fetch_array($exec31);

		  // $res31transactionamount = $res31['transactionamount2'];

	

		  // $query32 = "select * from master_transactionpharmacy where suppliercode = '$res1suppliercode' and billnumber = '$res1billnumber'  and transactiontype = 'pharmacycredit' and transactiondate between '$date12' and '$ADate2'";

		  // $exec32 = mysql_query($query32) or die ("Error in Query32".mysql_error());

		  // $res32 = mysql_fetch_array($exec32);

		  // $res32transactionamount = $res32['transactionamount2'];*/

		  

		  // $totalamount210 = $res29transactionamount - ($res30transactionamount + $res31return)/* + $res31transactionamount + $res32transactionamount*/;

		  

		  // $total210 = $totalamount210 - $totalamount180;

		  // }

		  // }

		  // else

		  // {

				// $totalamount30=0;

				// $total60=0;

				// $$totalamount60=0;

				// $total90=0;

				// $totalamount90=0;

				// $total120=0;

				// $totalamount120=0;

				// $total180=0;

				// $totalamount180=0;

				// $total210=0;

				// $totalamount210=0;  

		  // }

		  if($res2transactionamount !=''){

		  $snocount = $snocount + 1;

			

			//echo $cashamount;

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

				$colorcode = '';

			}

			

			?>


           <tr  <?php echo $colorcode; ?> >

              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res21suppliername; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res1billnumber; ?></div></td>

              <!--<td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res21suppliername; ?></div></td>-->
                <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php echo $supplierbillnumber; ?></div></td>

              <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php echo $res1transactiondate; ?></div></td>
              

              <td class="bodytext31" valign="center"  align="right"> <div align="right"><?php echo number_format($res2transactionamount,2,'.',','); ?></div></td>

               <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php echo number_format($invoicevalue,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="right"><?php echo number_format($totalamount30,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($total60,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($total90,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($total120,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($total180,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($total210,2,'.',','); ?></div></td>

           </tr>

			<?php

			}

				$totalamount1 = $totalamount1 + $res2transactionamount;

				$totalamount301 = $totalamount301 + $invoicevalue;

				$totalamount601 = $totalamount601 + $totalamount30;

				$totalamount901 = $totalamount901 + $total60;

				$totalamount1201 = $totalamount1201 + $total90;

				$totalamount1801 = $totalamount1801 + $total120;

				$totalamount2101 = $totalamount2101 + $total180;

				$totalamount2401 = $totalamount2401 + $total210;

				

				$res2transactionamount=0;

				$invoicevalue=0;

				$totalamount30=0;

				$total60=0;

				$$totalamount60=0;

				$total90=0;

				$totalamount90=0;

				$total120=0;

				$totalamount120=0;

				$total180=0;

				$totalamount180=0;

				$total210=0;

				$totalamount210=0;   

			}

			

		 	$query2="select sum(creditamount-debitamount) as creditamount,ledgername,entrydate,docno from master_journalentries where ledgerid='$res21suppliercode' and entrydate between '$ADate1' and '$ADate2' group by docno";

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

		  $snocount = $snocount + 1;

			

			

			$totalamount1=$totalamount1+$creditamount;

			$totalamount301=$totalamount301+$creditamount;

			$totalamount601=$totalamount601+$totalamount30;

			$totalamount901=$totalamount901+$total60;

			$totalamount1201=$totalamount1201+$total90;

			$totalamount1801=$totalamount1801+$total120;

			$totalamount2101=$totalamount2101+$total180;

			$totalamount2401=$totalamount2401+$total210;

			//echo $cashamount;

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

				$colorcode = '';

			}

			

			?>

           <tr  <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res21suppliername; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $docno; ?></div></td>

              <!--<td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $ledgername; ?></div></td>-->
                <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php //echo $entrydate; ?></div></td>

              <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php echo $entrydate; ?></div></td>

              

              <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php echo number_format($creditamount,2,'.',','); ?></div></td>

               <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php echo number_format($creditamount,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="right"><?php echo number_format($totalamount30,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($total60,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($total90,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($total120,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($total180,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($total210,2,'.',','); ?></div></td>

           </tr>
           <?php
           $totalamount30=0;
			$total60=0;
			$total90=0;
			$total120=0;
			$total180=0;
			$total210=0;
		}
	}
?>

            <!-- /////////////////////////////////////// DEBIT NOTES //////////////// -->
            <?php
             $query2 = "SELECT * from supplier_debit_transactions where supplier_id = '$id' and date(created_at) between '$ADate1' and '$ADate2'  order by created_at ASC";

			$exe2=mysqli_query($GLOBALS["___mysqli_ston"], $query2);

			while($res2=mysqli_fetch_array($exe2))

			{

		 	// $creditamount=$res2['creditamount'];

		 

			 $docno = $res2['approve_id'];
		  $created_at = $res2['created_at'];

		  $timestamp = strtotime($created_at);
			$entrydate = date('Y-m-d', $timestamp); // d.m.YYYY
			$child2 = date('H:i', $timestamp); // HH:ss


		  $supplier_id_debitnotes = $res2['supplier_id'];

		   $debitamount_sbdt = $res2['total_amount'];

		   // FOR PENDING AMOUNT //////////////////////////////////////////////////////////////////
		   $total_allocated_amount=0;
            	 $query3 = "SELECT * from master_transactionpharmacy where  docno = '$docno' and recordstatus = 'allocated' order by auto_number desc"; 
				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num=mysqli_num_rows($exec3);
				while ($res3 = mysqli_fetch_array($exec3)) { $total_allocated_amount +=$res3['transactionamount']; }
				// echo number_format($debitamount_sbdt-$total_allocated_amount,2,'.',',');
				$pending_amountfromdb=$debitamount_sbdt-$total_allocated_amount;

			   // FOR PENDING AMOUNT //////////////////////////////////////////////////////////////////

			$t1 = strtotime($entrydate);

    	  $t2 = strtotime($ADate2);

		  $days_between = ceil(abs($t2 - $t1) / 86400);

		    if($days_between<30)

			{

			$totalamount30=$totalamount30-$pending_amountfromdb;

			}

			

			if($days_between>30 && $days_between<=60)

			{

			$total60=$total60-$pending_amountfromdb;

			}

			if($days_between>60 && $days_between<=90)

			{

			$total90=$total90-$pending_amountfromdb;

			}

			if($days_between>90 && $days_between<=120)

			{

			$total120=$total120-$pending_amountfromdb;

			}

			if($days_between>120 && $days_between<=180)

			{

			$total180=$total180-$pending_amountfromdb;

			}

			if($days_between>180)

			{

			$total210=$total210-$pending_amountfromdb;

			}

		  

			

			  if($debitamount_sbdt !=''){

		  $snocount = $snocount + 1;

			

			

			$totalamount1=$totalamount1-$debitamount_sbdt;

			$totalamount301=$totalamount301-$pending_amountfromdb;

			$totalamount601=$totalamount601+$totalamount30;

			$totalamount901=$totalamount901+$total60;

			$totalamount1201=$totalamount1201+$total90;

			$totalamount1801=$totalamount1801+$total120;

			$totalamount2101=$totalamount2101+$total180;

			$totalamount2401=$totalamount2401+$total210;

			//echo $cashamount;

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

				$colorcode = '';

			}

			

			?>

           <tr  <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res21suppliername; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $docno; ?></div></td>

              <!--<td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $ledgername; ?></div></td>-->
                <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php //echo $entrydate; ?></div></td>

              <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php echo $entrydate; ?></div></td>

              

              <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php echo '-'.number_format($debitamount_sbdt,2,'.',','); ?></div></td>

               <td class="bodytext31" valign="center"  align="right"> <div align="right"><?php echo '-'.number_format($pending_amountfromdb,2,'.',',');
               
                ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="right"><?php echo number_format($totalamount30,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($total60,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($total90,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($total120,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($total180,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($total210,2,'.',','); ?></div></td>

           </tr>
            <!-- /////////////////////////////////////// DEBIT NOTES //////////////// -->


			<?php
			$totalamount30=0;
			$total60=0;
			$total90=0;
			$total120=0;
			$total180=0;
			$total210=0;
		

}

			

			}
			//////////////////////////// debit notes end ///////////////////////////
			//////////////////////////// SPE BILLS STARTS HERE ///////////////////////////
		// $query51 = "select auto_number from paymentmodecredit ";
		// $exec51 = mysql_query($query51) or die ("Error in Query5".mysql_error());
		// $num = mysql_num_rows($exec51);
		// if($num>0)
		//   {
		  // $paymentdocno = $res45['billnumber'];
		  // $res5transactionamount = $res45['totalfxamount'];
		  // $res5transactiondate = $res45['groupdate'];

			$query5 = "select * from master_transactionpharmacy where suppliercode = '$id' and transactiondate between '$ADate1' and '$ADate2' and transactionmodule = 'PAYMENT'  and recordstatus <> 'deallocated'  order by transactiondate desc";
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num5 = mysqli_num_rows($exec5);
		  if($num5 > 0)
		  {
		  while($res5 = mysqli_fetch_array($exec5))
		  {

	      $res5suppliername = $res5['suppliername'];
		  $res5patientcode = $res5['suppliercode'];
		  $res5billnumber = $res5['billnumber'];
		  $res5openingbalance = $res5['openingbalance'];
		  $res5docnumber = $res5['docno'];
		  $res5particulars = $res5['particulars'];
		  $res5transactionamount = $res5['transactionamount'];
		  //$res5particulars = substr($res5particulars,2,6);
		  $res5transactionmode= $res5['transactionmode'];
		  $res5chequenumber= $res5['chequenumber'];
		  $res5remarks = $res5['remarks'];
		  $entrydate = $res5['transactiondate'];

		  $res5transactionamount_balance=0;


		   $query852 = "select supplierbillnumber from master_purchase where billnumber = '$res5billnumber' ";
		  $exec852 = mysqli_query($GLOBALS["___mysqli_ston"], $query852) or die ("Error in Query852".mysqli_error($GLOBALS["___mysqli_ston"]));
		  //echo $num = mysql_num_rows($exec3);
		  $res852 = mysqli_fetch_array($exec852);
		  $res85supplierbillnumber = $res852['supplierbillnumber'];

		  $t1 = strtotime($entrydate);
    	  $t2 = strtotime($ADate2);
		  $days_between = ceil(abs($t2 - $t1) / 86400);

		  if($days_between<30) { $totalamount30=$totalamount30-$res5transactionamount_balance; }
			if($days_between>30 && $days_between<=60) { $total60=$total60-$res5transactionamount_balance; }
			if($days_between>60 && $days_between<=90){ $total90=$total90-$res5transactionamount_balance; }
			if($days_between>90 && $days_between<=120) { $total120=$total120-$res5transactionamount_balance; }
			if($days_between>120 && $days_between<=180) { $total180=$total180-$res5transactionamount_balance; }
			if($days_between>180) { $total210=$total210-$res5transactionamount_balance; }

			

			  if($res5transactionamount !=''){
		  		$snocount = $snocount + 1;

		  		$totalamount1=$totalamount1-$res5transactionamount;
				$totalamount301=$totalamount301-$res5transactionamount_balance;
				$totalamount601=$totalamount601+$totalamount30;
				$totalamount901=$totalamount901+$total60;
				$totalamount1201=$totalamount1201+$total90;
				$totalamount1801=$totalamount1801+$total120;
				$totalamount2101=$totalamount2101+$total180;
				$totalamount2401=$totalamount2401+$total210;

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
				$colorcode = '';
			}

			?>

           <tr  <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res21suppliername; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res5docnumber; ?></div></td>

              <!--<td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $ledgername; ?></div></td>-->
                <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php echo $res85supplierbillnumber; ?></div></td>

              <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php echo $entrydate; ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php echo '-'.number_format($res5transactionamount,2,'.',','); ?></div></td>

               <td class="bodytext31" valign="center"  align="right"> <div align="right"><?php echo  number_format($res5transactionamount_balance,2,'.',',');
               
                ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="right"><?php echo number_format($totalamount30,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($total60,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($total90,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($total120,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($total180,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($total210,2,'.',','); ?></div></td>

           </tr>
            <!-- /////////////////////////////////////// spe bills //////////////// -->


			<?php
			$totalamount30=0;
			$total60=0;
			$total90=0;
			$total120=0;
			$total180=0;
			$total210=0;
		}
	}
}

 
			//////////////////////////// SPE BILLS ENDS HERE ///////////////////////////


			

			}

			?>
			</tbody>
			<tr onClick="showsub(<?=$res22accountautonum?>)">

              <td class="bodytext31" valign="center"  align="left" 

>&nbsp;</td>

              

				<td class="bodytext31" valign="center"  align="center" 

>&nbsp;</td>

              <td class="bodytext31" valign="center"  align="center" 

>&nbsp;</td>

                 <td class="bodytext31" valign="center"  align="center" 

>&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

><strong>Total:</strong></td>

				<td class="bodytext31" valign="center"  align="right" 

><strong><?php echo number_format($totalamount1,2,'.',','); ?></strong></td>

              <td class="bodytext31" valign="center"  align="right" 

><strong><?php echo number_format($totalamount301,2,'.',','); ?></strong></td>

				 <td class="bodytext31" valign="center"  align="right" 

><strong><?php echo number_format($totalamount601,2,'.',','); ?></strong></td>

              <td class="bodytext31" valign="center"  align="right" 

><strong><?php echo number_format($totalamount901,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

><strong><?php echo number_format($totalamount1201,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

><strong><?php echo number_format($totalamount1801,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

><strong><?php echo number_format($totalamount2101,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

><strong><?php echo number_format($totalamount2401,2,'.',','); ?></strong></td>        

            </tr>


			

			<?php

			$totalamount1_final +=$totalamount1;
			$totalamount301_final +=$totalamount301;
			$totalamount601_final +=$totalamount601;
			$totalamount901_final +=$totalamount901;
			$totalamount1201_final +=$totalamount1201;
			$totalamount1801_final +=$totalamount1801;
			$totalamount2101_final +=$totalamount2101;
			$totalamount2401_final +=$totalamount2401;

			$snocount=0;
			$totalamount1=0;
		$totalamount301=0;
		$totalamount601=0;
		$totalamount901=0;
		$totalamount1201=0;
		$totalamount1801=0;
		$totalamount2101=0;
		$totalamount2401=0;

			} 

			}

			?>

			<tr >

              <td class="bodytext31" valign="center"  align="left" 

>&nbsp;</td>

              

				<td class="bodytext31" valign="center"  align="center" 

>&nbsp;</td>

              <td class="bodytext31" valign="center"  align="center" 

>&nbsp;</td>

                 <td class="bodytext31" valign="center"  align="center" 

>&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

><strong>Total:</strong></td>

				<td class="bodytext31" valign="center"  align="right" 

><strong><?php echo number_format($totalamount1_final,2,'.',','); ?></strong></td>

              <td class="bodytext31" valign="center"  align="right" 

><strong><?php echo number_format($totalamount301_final,2,'.',','); ?></strong></td>

				 <td class="bodytext31" valign="center"  align="right" 

><strong><?php echo number_format($totalamount601_final,2,'.',','); ?></strong></td>

              <td class="bodytext31" valign="center"  align="right" 

><strong><?php echo number_format($totalamount901_final,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

><strong><?php echo number_format($totalamount1201_final,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

><strong><?php echo number_format($totalamount1801_final,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

><strong><?php echo number_format($totalamount2101_final,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

><strong><?php echo number_format($totalamount2401_final,2,'.',','); ?></strong></td>        

            </tr>
		
            
			<tr>

			<?php

			

				$urlpath = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&searchsuppliercode=$arraysuppliercode&&searchsuppliername=$searchsuppliername";
				$urlpath_summary = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&searchsuppliercode=$arraysuppliercode";

			

			?>

			 <td colspan="11"></td>

		   	<!--  <td colspan="2" class="bodytext31" valign="center"  align="right"><a href="fullcreditoranalysis_summary_detailed_xl.php?<?php echo $urlpath; ?>"><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;"></a>

             <a href="fullcreditoranalysis_summary_detailed_pdf.php?<?php echo $urlpath; ?>"><img src="images/pdfdownload.jpg" width="40" height="40"></a></td> -->

			</tr>    
			<?php if ($cbfrmflag1 == 'cbfrmflag1'){ ?> 

			<tr>
				 <td colspan="2" class="bodytext31" valign="center"  align="left" 
><?php if ($cbfrmflag1 == 'cbfrmflag1'){ ?><a target="_blank" href="fullcreditoranalysis_summary_detailed_xl.php?<?php echo $urlpath; ?>">DETAILED EXCEL</a><? } else { ?> &nbsp; <?php } ?></td>
				<td colspan="2" class="bodytext31" valign="center"  align="left" 
><?php if ($cbfrmflag1 == 'cbfrmflag1'){ ?><a target="_blank" href="fullcreditoranalysis_summary_detailed_pdf.php?<?php echo $urlpath; ?>">DETAILED PDF</a><? } else { ?> &nbsp; <?php } ?></td>

                <td colspan="4" class="bodytext31" valign="center"  align="left" 
></td>


                 <td colspan="3" class="bodytext31" valign="center"  align="left" 
><?php if ($cbfrmflag1 == 'cbfrmflag1'){ ?><a target="_blank" href="fullcreditoranalysis_del_sum_xl.php?<?php echo $urlpath_summary; ?>">SUMMARY EXCEL</a><? } else { ?> &nbsp; <?php } ?></td>
				<td colspan="3" class="bodytext31" valign="center"  align="left" 
><?php if ($cbfrmflag1 == 'cbfrmflag1'){ ?><a target="_blank" href="fullcreditoranalysis_del_sum_pdf.php?<?php echo $urlpath_summary; ?>">SUMMARY PDF</a><? } else { ?> &nbsp; <?php } ?></td>

                <!--  <td colspan="3" class="bodytext31" valign="center"  align="left" 
><?php if ($cbfrmflag1 == 'cbfrmflag1'){ ?><a target="_blank" href="print_fullcredittoranalysissummary.php?<?php echo $urlpath_summary; ?>">SUMMARY EXCEL</a><? } else { ?> &nbsp; <?php } ?></td>
				<td colspan="3" class="bodytext31" valign="center"  align="left" 
><?php if ($cbfrmflag1 == 'cbfrmflag1'){ ?><a target="_blank" href="print_fullcredittoranalysissummarypdf.php?<?php echo $urlpath_summary; ?>">SUMMARY PDF</a><? } else { ?> &nbsp; <?php } ?></td> -->
			</tr>
		<?php } ?>

          </tbody>

        </table></td>

      </tr>

    </table>

</table>

<footer>
  <?php include ("includes/footer1.php"); ?>
</footer>
</main>

</body>

</html>


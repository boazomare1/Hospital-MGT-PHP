<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');



$searchsuppliername = '';

$suppliername = '';

$cbsuppliername = '';

$cbcustomername = '';

$cbbillnumber = '';

$cbbillstatus = '';

$colorloopcount = '';

$sno = '';

$snocount = '';

$visitcode1 = '';

$total = '0.00';

$looptotalpaidamount = '0.00';

$looptotalpendingamount = '0.00';

$looptotalwriteoffamount = '0.00';

$looptotalcashamount = '0.00';

$looptotalcreditamount = '0.00';

$looptotalcardamount = '0.00';

$looptotalonlineamount = '0.00';

$looptotalchequeamount = '0.00';

$looptotaltdsamount = '0.00';

$looptotalwriteoffamount = '0.00';

$pendingamount = '0.00';

$accountname = '';

$amount = 0;



if (isset($_REQUEST["slocation"])) { $slocation = $_REQUEST["slocation"]; } else { $slocation = ""; }

if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }

if (isset($_REQUEST["lab"])) { $lab = $_REQUEST["lab"]; } else { $lab = ""; }

			

if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }



if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

//$getcanum = $_GET['canum'];

if ($getcanum != '')

{

	$query4 = "select suppliername from master_supplier where auto_number = '$getcanum'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res4 = mysqli_fetch_array($exec4);

	$cbsuppliername = $res4['suppliername'];

	$suppliername = $res4['suppliername'];

}



if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{



	//$cbsuppliername = $_REQUEST['cbsuppliername'];

	//$suppliername = $_REQUEST['cbsuppliername'];

	$paymentreceiveddatefrom = $_REQUEST['ADate1'];

	$paymentreceiveddateto = $_REQUEST['ADate2'];

	$visitcode1 = 10;



}



if (isset($_REQUEST["task"])) { $task = $_REQUEST["task"]; } else { $task = ""; }

//$task = $_REQUEST['task'];

if ($task == 'deleted')

{

	$errmsg = 'Payment Entry Delete Completed.';

}



if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

//$paymenttype = $_REQUEST['paymenttype'];

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

//$billstatus = $_REQUEST['billstatus'];

if ($ADate1 != '' && $ADate2 != '')

{

	$transactiondatefrom = $_REQUEST['ADate1'];

	$transactiondateto = $_REQUEST['ADate2'];

}

else

{

	$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

	$transactiondateto = date('Y-m-d');

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

<script src="js/datetimepicker_css.js"></script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />      

<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/autocomplete.css">      

<script>

$(document).ready(function(e) {

   

		$('#lab').autocomplete({

	

	source:"ajaxlab_search.php",

	//alert(source);

	matchContains: true,

	minLength:1,

	html: true, 

		select: function(event,ui){

			var accountname=ui.item.value;

			var accountid=ui.item.id;

			var accountanum=ui.item.anum;

			$("#labcode").val(accountid);

			$("#lab").val(accountname);

			

			},

    

	});

		

});

</script>

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

<script language="javascript">



function funcPrintReceipt1(varRecAnum)

{

	var varRecAnum = varRecAnum

	//alert (varRecAnum);

	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php //echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

	window.open("print_payment_receipt1.php?receiptanum="+varRecAnum+"","OriginalWindow<?php //echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

}



function funcDeletePayment1(varPaymentSerialNumber)

{

	var varPaymentSerialNumber = varPaymentSerialNumber;

	var fRet;

	fRet = confirm('Are you sure want to delete this payment entry serial number '+varPaymentSerialNumber+'?');

	//alert(fRet);

	if (fRet == true)

	{

		alert ("Payment Entry Delete Completed.");

		//return false;

	}

	if (fRet == false)

	{

		alert ("Payment Entry Delete Not Completed.");

		return false;

	}

	//return false;

}



</script>

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

		

		

              <form name="cbform1" method="post" action="labrevenuereport.php">

                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                  <tbody>

                    <tr bgcolor="#011E6A">

                      <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Lab Revenue Report </strong></td>

                      <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->

                      <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">&nbsp;</td>

                    </tr>

					 <tr>

                      <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF"> Search Lab </td>

                      <td colspan="3" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">

					  <input type="text" name="lab" id="lab" size="60" value="<?php echo $lab; ?>">

					  <input type="hidden" name="labcode" id="labcode">

					  </td>

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

                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location </td>

                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">

                      <select name="slocation" id="slocation">
                        <option value="All">All</option>

                      	<?php

						$query01="select locationcode,locationname from master_location where status ='' order by locationname";

						$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);

						while($res01=mysqli_fetch_array($exc01))

						{?>

							<option value="<?= $res01['locationcode'] ?>" <?php if($slocation==$res01['locationcode']){ echo "selected";} ?>> <?= $res01['locationname'] ?></option>		

						<?php 

						}

						?>

                      </select>

                      </td>

                      

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Type </td>

                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">

                      <select name="type" id="type">

                      	<option value="" selected>ALL</option>

                      	<option value="OP" <?php if($type=='OP'){ echo "selected";} ?>> OP + EXTERNAL </option>

                      	<option value="IP" <?php if($type=='IP'){ echo "selected";} ?>> IP </option>

                      

                      </select>

                      </td>

                      

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

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1247" 

            align="left" border="0">

          <tbody>

           

           <tr>

              <td width="3%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>

              <td width="7%" align="left" valign="left"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill Date</strong></div></td>

              <td width="8%" align="left" valign="left"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg Code</strong></div></td>

              <td width="7%" align="left" valign="center"  

                bgcolor="#ffffff" class="style1">Visit Code</td>

              <td width="15%" align="left" valign="left"  

                bgcolor="#ffffff" class="style1"><div align="left"><strong>Patitent Name</strong></div></td>
                 <td width="15%" align="left" valign="left"  

                bgcolor="#ffffff" class="style1"><div align="left"><strong>Category</strong></div></td>

              <td width="8%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Item Code</strong></div></td>

                <td width="19%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Item Name</strong></div></td>

                <td width="6%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Rate</strong></div></td>

                <td width="6%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill Type</strong></div></td>

                <td width="14%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account Name</strong></div></td>  

            </tr>

            

			<?php

			$num1=0;

			$num2=0;

			$num3=0;

			$num6=0;

			$grandtotal = 0;

			$res2itemname = '';

			

			$ADate1 = $transactiondatefrom;

			$ADate2 = $transactiondateto;

			

			if($cbfrmflag1 == 'cbfrmflag1')

			{

			 $j = 0;

	  	  

			$crresult = array();
			
			if($slocation=='All')
			{
			$pass_location = "locationcode !=''";
			}
			else
			{
			$pass_location = "locationcode ='$slocation'";
			}
			


			if($type == 'OP')

			{

			$querycr1in = "SELECT fxamount as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,labitemcode as lcode, labitemname as lname, billdate as date, accountname as accountname, billtype as billtype FROM `billing_paynowlab`  WHERE labitemname LIKE '%$lab%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location

						   UNION ALL SELECT labitemrate as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,labitemcode as lcode, labitemname as lname, billdate as date, CONCAT(accountname,'CASH COLLECTIONS') as accountname, CONCAT(billtype,'PAY NOW') as billtype FROM `billing_externallab`  WHERE labitemname LIKE '%$lab%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location

						   UNION ALL SELECT fxamount as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,labitemcode as lcode, labitemname as lname, billdate as date, accountname as accountname, billtype as billtype FROM `billing_paylaterlab`  WHERE labitemname LIKE '%$lab%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location";

			}

			else if($type == 'IP')

			{

			$querycr1in = "SELECT rateuhx as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,labitemcode as lcode, labitemname as lname, billdate as date, accountname as accountname, billtype as billtype FROM `billing_iplab`  WHERE labitemname LIKE '%$lab%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location";

			}

			else 

			{

			 $querycr1in = "SELECT fxamount as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,labitemcode as lcode, labitemname as lname, billdate as date, accountname as accountname, billtype as billtype FROM `billing_paynowlab`  WHERE labitemname LIKE '%$lab%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location

						   UNION ALL SELECT labitemrate as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,labitemcode as lcode, labitemname as lname, billdate as date, CONCAT(accountname,'CASH COLLECTIONS') as accountname, CONCAT(billtype,'PAY NOW') as billtype FROM `billing_externallab`  WHERE labitemname LIKE '%$lab%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location

						   UNION ALL SELECT fxamount as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,labitemcode as lcode, labitemname as lname, billdate as date, accountname as accountname, billtype as billtype FROM `billing_paylaterlab`  WHERE labitemname LIKE '%$lab%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location

						   UNION ALL SELECT rateuhx as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,labitemcode as lcode, labitemname as lname, billdate as date, accountname as accountname, billtype as billtype FROM `billing_iplab`  WHERE labitemname LIKE '%$lab%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location";

			}			   

			$execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($rescr1 = mysqli_fetch_array($execcr1))

			{

			$j = $j+1;

			$patientcode = $rescr1['pcode'];

			$patientname = $rescr1['pname'];

			$patientvisitcode = $rescr1['vcode'];

			$itemcode = $rescr1['lcode'];

			$itemname = $rescr1['lname'];

			$billdate = $rescr1['date'];

			$labrate = $rescr1['income'];

			$total = $total + $labrate;
$query4 = "select categoryname from master_lab where itemcode = '$itemcode'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res4 = mysqli_fetch_array($exec4);

	$categoryname = $res4['categoryname'];
			

			//$res4billtype = $rescr1['billtype'];

			$res4accountname = $rescr1['accountname'];

			if( $res4accountname != 'CASH - HOSPITAL')

			{

				$res4billtype = 'PAY LATER';

			}

			else

			{

				$res4billtype = 'PAY NOW';

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

               <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $j; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $billdate; ?></div>              </td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $patientcode; ?></div>              </td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $patientvisitcode; ?></div>              </td>

              <td class="bodytext31" valign="center"  align="left">

			  <?php echo $patientname; ?></td>
<td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $categoryname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $itemcode; ?></div></td>

                <td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $itemname; ?></div></td>

                <td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo number_format($labrate,2,'.',','); ?></div></td>

                <td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $res4billtype; ?></div></td>

                <td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $res4accountname; ?></div></td>

           </tr>

		   <?php

			}

			

			 $amount = $amount + $total;	

			

		  $num4 = $num1 + $num2 + $num3 + $num6;

		 

		  $grandtotal = $grandtotal + $amount;

		  

		  $total = number_format($total,'2','.','');

		  

			

			?>

          <tr>

              <td class="bodytext31" valign="center"  align="left"></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"></div>              </td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"></div>              </td>

              <td colspan="3" class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"></div>              </td>

              <td class="bodytext31" valign="center"  align="left">

			  <strong>Total</strong></td>

              <td class="bodytext31" valign="center"  align="left">

			    <div align="left"><strong><?php echo number_format($amount,2); ?></strong></div></td>

                <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"></div>              </td>

                <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"></div>              </td>

           </tr>

		  

		   <tr>

			<td bgcolor="#ecf0f5" colspan="10" class="bodytext31" valign="center"  align="left">

			    <div align="left"><strong><?php echo 'Refund'; ?></strong></div></td>

			</tr>	

		   <?php

		   $amount=0;

		   $j=0;

		   	$total = 0;

			if($type == "OP")

			{

			$querydr1in = "SELECT (labitemrate) as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,labitemcode as lcode, labitemname as lname, billdate as date, CONCAT(accountname,'CASH COLLECTIONS') as accountname, CONCAT(billtype,'PAY NOW') as billtype FROM `refund_paynowlab` WHERE labitemname LIKE '%$lab%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location

						   UNION ALL SELECT (fxamount) as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,labitemcode as lcode, labitemname as lname, billdate as date, accountname as accountname, billtype as billtype FROM `refund_paylaterlab` WHERE labitemname LIKE '%$lab%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location

						   UNION ALL SELECT labfxamount as income, patientcode as pcode, patientname as pname, visitcode as vcode,'' as lcode, '' as lname, entrydate as date, accountname as accountname, billtype as billtype FROM `billing_patientweivers` WHERE entrydate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location";

			}

			else if($type == "IP")

			{

			$querydr1in = "SELECT rate as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,'' as lcode, '' as lname, consultationdate as date, accountname as accountname, '' as billtype FROM `ip_discount` WHERE description = 'Lab' AND consultationdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location";

			}

			else

			{

			$querydr1in = "SELECT (labitemrate) as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,labitemcode as lcode, labitemname as lname, billdate as date, CONCAT(accountname,'CASH COLLECTIONS') as accountname, CONCAT(billtype,'PAY NOW') as billtype FROM `refund_paynowlab` WHERE labitemname LIKE '%$lab%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location

						   UNION ALL SELECT (fxamount) as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,labitemcode as lcode, labitemname as lname, billdate as date, accountname as accountname, billtype as billtype FROM `refund_paylaterlab` WHERE labitemname LIKE '%$lab%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location

						   UNION ALL SELECT labfxamount as income, patientcode as pcode, patientname as pname, visitcode as vcode,'' as lcode, '' as lname, entrydate as date, accountname as accountname, billtype as billtype FROM `billing_patientweivers` WHERE labfxamount > '0' and entrydate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location

						   UNION ALL SELECT rate as income, patientcode as pcode, patientname as pname, patientvisitcode as vcode,'' as lcode, '' as lname, consultationdate as date, accountname as accountname, '' as billtype FROM `ip_discount` WHERE description = 'Lab' AND consultationdate BETWEEN '$ADate1' AND '$ADate2' AND $pass_location";

			}

			$execdr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydr1in) or die ("Error in querydr1in".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($resdr1 = mysqli_fetch_array($execdr1))

			{

			$j = $j+1;

			$patientcode = $resdr1['pcode'];

			$patientname = $resdr1['pname'];

			$patientvisitcode = $resdr1['vcode'];

			$itemcode = $resdr1['lcode'];

			$itemname = $resdr1['lname'];

			$billdate = $resdr1['date'];

			$labrate = $resdr1['income'];

			$total = $total + $labrate;

			

			//$res4billtype = $resdr1['billtype'];

			$res4accountname = $resdr1['accountname'];

			if($res4accountname != 'CASH - HOSPITALCASH COLLECTIONS')

			{

				$res4billtype = 'PAY LATER';

			}

			else

			{

				$res4billtype = 'PAY NOW';

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

               <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $j; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $billdate; ?></div>              </td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $patientcode; ?></div>              </td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $patientvisitcode; ?></div>              </td>

              <td class="bodytext31" valign="center"  align="left">

			  <?php echo $patientname; ?></td>

              <td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $itemcode; ?></div></td>

                <td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $itemname; ?></div></td>

                <td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo number_format($labrate,2,'.',','); ?></div></td>

                <td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $res4billtype; ?></div></td>

                <td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $res4accountname; ?></div></td>

           </tr>

		   <?php

			}	

			$amount = $amount + $total;

			

		  $num4 = $num1 + $num2 + $num3 + $num6;

		  //$num4 = number_format($num4, '2', '.' ,''); 

		  

		  $grandtotal = $grandtotal - $amount;

		  

		  $total = number_format($total,'2','.','');

		  

		

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

              <td class="bodytext31" valign="center"  align="left"></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"></div>              </td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"></div>              </td>

              <td colspan="3" class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"></div>              </td>

              <td class="bodytext31" valign="center"  align="left">

			  <strong>Total</strong></td>

              <td class="bodytext31" valign="center"  align="left">

			    <div align="left"><strong><?php echo number_format($amount,2); ?></strong></div></td>

                <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"></div>              </td>

                <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"></div>              </td>

           </tr>

			

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

               <td colspan="3" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><strong><strong>Grand Total:</strong></strong></td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotal,2);?></strong></td>

              <td colspan="2" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td width="7%"  align="left" valign="center" bgcolor="" class="bodytext31">

              <a href="xl_labrevenuereport.php?slocation=<?= $slocation; ?>&&type=<?= $type ?>&&cbfrmflag1=cbfrmflag1&&ADate1=<?= $transactiondatefrom ?>&&ADate2=<?= $transactiondateto ?>&&lab=<?php echo $lab; ?>" target="_blank"> <img src="images/excel-xls-icon.png" width="30" height="30" /> </a>

              </td> 

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




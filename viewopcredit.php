<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

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

$total = '0.00';

$balanceamount = "0.00";

$openingbalance = "0.00";

$searchsuppliername = "";

$cbsuppliername = "";

$snocount = "";

$colorloopcount="";

$grandtotal = 0;



//This include updatation takes too long to load for hunge items database.

include ("autocompletebuild_account2.php");

 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

//$getcanum = $_GET['canum'];

if ($getcanum != '')

{

	$query4 = "select * from master_supplier where auto_number = '$getcanum'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res4 = mysqli_fetch_array($exec4);

	$cbsuppliername = $res4['suppliername'];

	$suppliername = $res4['suppliername'];

}



if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }



if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{



	$searchsuppliername = $_POST['searchsuppliername'];

	if ($searchsuppliername != '')

	{

		$arraysupplier = explode("#", $searchsuppliername);

		$arraysuppliername = $arraysupplier[0];

		$arraysuppliername = trim($arraysuppliername);

		//$arraysuppliercode = $arraysupplier[1];

		

		//$query1 = "select * from master_supplier where suppliercode = '$arraysuppliercode'";

		//$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());

		//$res1 = mysql_fetch_array($exec1);

		//$supplieranum = $res1['auto_number'];

		//$openingbalance = $res1['openingbalance'];



		$cbsuppliername = $arraysuppliername;

		$suppliername = $arraysuppliername;

	}

	else

	{

		//$cbsuppliername = $_REQUEST['cbsuppliername'];

		//$suppliername = $_REQUEST['cbsuppliername'];

	}



	//$transactiondatefrom = $_REQUEST['ADate1'];

	//$transactiondateto = $_REQUEST['ADate2'];



}



if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

//$paymenttype = $_REQUEST['paymenttype'];

//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

//$billstatus = $_REQUEST['billstatus'];

//echo $ADate2;



if (isset($_REQUEST["ADate1"])){
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
}

// else

// {

// 	$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

// 	$transactiondateto = date('Y-m-d');

// }



if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

//$frmflag2 = $_POST['frmflag2'];



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$st = $_REQUEST['st'];

if ($st == '1')

{

	$errmsg = "Success. Payment Entry Update Completed.";

}

if ($st == '2')

{

	$errmsg = "Failed. Payment Entry Not Completed.";

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

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>



<script type="text/javascript" src="js/autocomplete_accounts2.js"></script>

<script type="text/javascript" src="js/autosuggest4accounts.js"></script>

<script type="text/javascript">





function ajaxlocationfunction(val)

{ 

if (window.XMLHttpRequest)

					  {// code for IE7+, Firefox, Chrome, Opera, Safari

					  xmlhttp=new XMLHttpRequest();

					  }

					else

					  {// code for IE6, IE5

					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

					  }

					xmlhttp.onreadystatechange=function()

					  {

					  if (xmlhttp.readyState==4 && xmlhttp.status==200)

						{

						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;

						}

					  }

					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);

					xmlhttp.send();

}

					

//ajax to get location which is selected ends here







window.onload = function () 

{

	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        

}





function disableEnterKey(varPassed)

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

	

	var key;

	if(window.event)

	{

		key = window.event.keyCode;     //IE

	}

	else

	{

		key = e.which;     //firefox

	}



	if(key == 13) // if enter key press

	{

		//alert ("Enter Key Press2");

		return false;

	}

	else

	{

		return true;

	}

}





function process1backkeypress1()

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

}



function disableEnterKey()

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

	

	var key;

	if(window.event)

	{

		key = window.event.keyCode;     //IE

	}

	else

	{

		key = e.which;     //firefox

	}

	

	if(key == 13) // if enter key press

	{

		return false;

	}

	else

	{

		return true;

	}



}



function paymententry1process2()

{

	if (document.getElementById("cbfrmflag1").value == "")

	{

		alert ("Search Bill Number Cannot Be Empty.");

		document.getElementById("cbfrmflag1").focus();

		document.getElementById("cbfrmflag1").value = "<?php echo $cbfrmflag1; ?>";

		return false;

	}

}



function paymententry1process1()

{

	//alert ("inside if");

	if (document.getElementById("paymentamount").value == "")

	{

		alert ("Payment Amount Cannot Be Empty.");

		document.getElementById("paymentamount").focus();

		document.getElementById("paymentamount").value = "0.00"

		return false;

	}

	if (document.getElementById("paymentamount").value == "0.00")

	{

		alert ("Payment Amount Cannot Be Empty.");

		document.getElementById("paymentamount").focus();

		document.getElementById("paymentamount").value = "0.00"

		return false;

	}

	if (isNaN(document.getElementById("paymentamount").value))

	{

		alert ("Payment Amount Can Only Be Numbers.");

		document.getElementById("paymentamount").focus();

		return false;

	}

	if (document.getElementById("paymentmode").value == "")

	{

		alert ("Please Select Payment Mode.");

		document.getElementById("paymentmode").focus();

		return false;

	}

	if (document.getElementById("paymentmode").value == "CHEQUE")

	{

		if(document.getElementById("chequenumber").value == "")

		{

			alert ("If Payment By Cheque, Then Cheque Number Cannot Be Empty.");

			document.getElementById("chequenumber").focus();

			return false;

		} 

		else if (document.getElementById("bankname").value == "")

		{

			alert ("If Payment By Cheque, Then Bank Name Cannot Be Empty.");

			document.getElementById("bankname").focus();

			return false;

		}

	}

	

	var fRet; 

	fRet = confirm('Are you sure want to save this payment entry?'); 

	//alert(fRet); 

	//alert(document.getElementById("paymentamount").value); 

	//alert(document.getElementById("pendingamounthidden").value); 

	if (fRet == true)

	{

		var varPaymentAmount = document.getElementById("paymentamount").value; 

		var varPaymentAmount = varPaymentAmount * 1;

		var varPendingAmount = document.getElementById("pendingamounthidden").value; 

		var varPendingAmount = parseInt(varPendingAmount);

		var varPendingAmount = varPendingAmount * 1;

		//alert (varPendingAmount);

		/*

		if (varPaymentAmount > varPendingAmount)

		{

			alert('Payment Amount Is Greater Than Pending Amount. Entry Cannot Be Saved.'); 

			alert ("Payment Entry Not Completed.");

			return false;

		}

		*/

	}

	if (fRet == false)

	{

		alert ("Payment Entry Not Completed.");

		return false;

	}

		

	//return false;

	

}



function funcPrintReceipt1()

{

	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

}



</script>

<script>

function updatebox(varSerialNumber,billamt,totalcount1)

{



var adjamount1;

var grandtotaladjamt2=0;

var varSerialNumber = varSerialNumber;

var totalcount1=totalcount1;

var billamt = billamt;

  var textbox = document.getElementById("adjamount"+varSerialNumber+"");

    textbox.value = "";

if(document.getElementById("acknow"+varSerialNumber+"").checked == true)

{

    if(document.getElementById("acknow"+varSerialNumber+"").checked) {

        textbox.value = billamt;

    }

	var balanceamt=billamt-billamt;

	document.getElementById("balamount"+varSerialNumber+"").value=balanceamt.toFixed(2);

	var totalbillamt=document.getElementById("paymentamount").value;

	if(totalbillamt == 0.00)

{

totalbillamt=0;

}

				totalbillamt=parseFloat(totalbillamt)+parseFloat(billamt);

			

		

			//alert(totalbillamt);





document.getElementById("paymentamount").value = totalbillamt.toFixed(2);

document.getElementById("totaladjamt").value=totalbillamt.toFixed(2);

}

else

{

//alert(totalcount1);

for(j=1;j<=totalcount1;j++)

{

var totaladjamount2=document.getElementById("adjamount"+j+"").value;



if(totaladjamount2 == "")

{

totaladjamount2=0;

}

grandtotaladjamt2=grandtotaladjamt2+parseFloat(totaladjamount2);

}

//alert(grandtotaladjamt);

document.getElementById("paymentamount").value = grandtotaladjamt2.toFixed(2);

document.getElementById("totaladjamt").value=grandtotaladjamt2.toFixed(2);



 }  

}

function checkboxcheck(varSerialNumber5)

{



if(document.getElementById("acknow"+varSerialNumber5+"").checked == false)

{

alert("Please click on the Select check box");

return false;

}

return true;

}

function balancecalc(varSerialNumber1,billamt1,totalcount)

{

var varSerialNumber1 = varSerialNumber1;

var billamt1 = billamt1;

var totalcount=totalcount;

var grandtotaladjamt=0;



var adjamount=document.getElementById("adjamount"+varSerialNumber1+"").value;

var adjamount3=parseFloat(adjamount);

if(adjamount3 > billamt1)

{

alert("Please enter correct amount");

document.getElementById("adjamount"+varSerialNumber1+"").focus();

return false;

}

var balanceamount=parseFloat(billamt1)-parseFloat(adjamount);



document.getElementById("balamount"+varSerialNumber1+"").value=balanceamount.toFixed(2);

for(i=1;i<=totalcount;i++)

{

var totaladjamount=document.getElementById("adjamount"+i+"").value;

if(totaladjamount == "")

{

totaladjamount=0;

}

grandtotaladjamt=grandtotaladjamt+parseFloat(totaladjamount);



}



document.getElementById("paymentamount").value = grandtotaladjamt.toFixed(2);

document.getElementById("totaladjamt").value=grandtotaladjamt.toFixed(2);



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

    <td width="97%" valign="top">
    	<table width="98%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td>&nbsp;</td>

      </tr>

       <tr>

        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" 

            align="left" border="0">

          <tbody>

            <tr>

              <td width="2%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td colspan="15" bgcolor="#ecf0f5" class="bodytext31">

              <?php

				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if (1)
				{

					if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }

					//$cbbillnumber = $_REQUEST['cbbillnumber'];

					if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }

					//$cbbillstatus = $_REQUEST['cbbillstatus'];

					

					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }

					//$cbbillnumber = $_REQUEST['cbbillnumber'];

					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }

					//$cbbillstatus = $_REQUEST['cbbillstatus'];

					// $locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
					$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'LTC-1';

			  	}
			  	$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'LTC-1';
			  	$locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'LTC-1';

				?> 			</td>  

            </tr>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></td>

              <td width="7%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit No</strong></div></td>

              <td width="6%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Bill No </strong></td>

              <td width="6%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Bill Date </strong></td>

              <td width="8%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg No. </strong></div></td>

				 <!-- <td width="8%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Member No. </strong></div></td> -->

              <td width="15%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>

				<!-- <td width="15%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Accountname</strong></div></td>

				<td width="15%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Subtype</strong></div></td>

				<td width="15%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>MIS Type</strong></div></td> -->

				<td width="15%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Payment Type</strong></div></td>

              <td width="12%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Plan Name </strong></div></td>

              <td width="3%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Lab</strong></div></td>

              <td width="4%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Service</strong></div></td>

              <td width="5%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Pharmacy</strong></div></td>

              <td width="5%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Radiology</strong></div></td>

              <td width="6%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Consultation</strong></div></td>

              <td width="5%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Referral</strong></div></td>

              <td width="5%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Total</strong></td>

              <td width="5%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Username</strong></td>

           <!--    <td width="5%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><div align="right"></div></td> -->

            </tr>

			<?php

			$totallab = $totalser = $totalpharm = $totalrad = $totalref = $totalcons = 0;

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				

				if (1)

				{
					if($searchsuppliername!=''){
							$query21 = "SELECT result.accountname from ( 
							 SELECT accountname from billing_paylater where locationcode='$locationcode1' and accountname like '%$searchsuppliername%' and billdate between '$ADate1' and '$ADate2' group by accountname
							 UNION ALL   SELECT accountname from billing_paynow where locationcode='$locationcode1' and accountname like '%$searchsuppliername%' and billdate between '$ADate1' and '$ADate2' group by accountname
							 UNION ALL  SELECT accountname from billing_consultation where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2' group by accountname
									order by accountname desc 
								) as result group by result.accountname";
					}else{
						$query21 = "SELECT result.accountname from (
						SELECT accountname from billing_paylater where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2' group by accountname 
						UNION ALL   SELECT accountname from billing_paynow where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2' group by accountname
						UNION ALL  SELECT accountname from billing_consultation where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2' group by accountname
						order by accountname desc 
						) as result group by result.accountname";
					}
			// $query21 = "SELECT accountname from master_accountname where locationcode='$locationcode1' and recordstatus <>'DELETED' ";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res21 = mysqli_fetch_array($exec21))
			{

			$res21accountname = $res21['accountname'];

			

			$query22 = "select * from master_accountname where locationcode='$locationcode1' and accountname = '$res21accountname' and recordstatus <>'DELETED' ";

			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res22 = mysqli_fetch_array($exec22);

			$res22accountname = $res22['accountname'];



			if( $res21accountname != '')

			{

			

			

			$dotarray = explode("-", $paymentreceiveddateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			

			

		  $query1 = "select * from master_accountname where locationcode='$locationcode1' and accountname = '$searchsuppliername'";

		  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res1 = mysqli_fetch_array($exec1);

		  $res1auto_number = $res1['auto_number'];

		  $res1accountname = $res1['accountname'];


		  $query2 = "SELECT accountname, patientcode, visitcode, billno, billdate, patientname, accountnameid, subtype from billing_paylater where locationcode='$locationcode1' and accountname = '$res21accountname' and billdate between '$ADate1' and '$ADate2' 
		 UNION ALL  SELECT accountname, patientcode, visitcode, billno, billdate, patientname, '' as accountnameid, subtype from billing_paynow where locationcode='$locationcode1' and accountname = '$res21accountname'  and accountname != 'CASH - HOSPITAL'  and billdate between '$ADate1' and '$ADate2' 
		 UNION ALL   SELECT accountname, patientcode,patientvisitcode as visitcode,billnumber as billno, billdate, patientname, '' as accountnameid,'' as subtype from billing_consultation where locationcode='$locationcode1' and accountname = '$res21accountname'  and accountname != 'CASH - HOSPITAL'  and billdate between '$ADate1' and '$ADate2' 
		  order by accountname desc "; 

		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num1=mysqli_num_rows($exec2);
		  if($num1>0){
		  // if(1){
		  	?>
				<tr bgcolor="#ecf0f5">
            		<td colspan="16"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo $res21accountname;?></strong></td>
            	</tr>
            <?php
		  while ($res2 = mysqli_fetch_array($exec2))
		  {

     	  $res2accountname = $res2['accountname'];

		  $res2patientcode = $res2['patientcode'];

		  $res2visitcode = $res2['visitcode'];

		  $res2billno = $res2['billno'];

		  $res2billdate = $res2['billdate'];

		  $res2patientname = $res2['patientname'];

		  $accountid = $res2['accountnameid'];

		  $subtype = $res2['subtype'];

		  //echo $res2paymenttype = $res2['paymenttype'];

		  $res5labitemrate1 = '0.00';

		  $res6servicesitemrate1 = '0.00';

		  $res7pharmacyitemrate1 = '0.00';

		  $res8radiologyitemrate1 = '0.00';

		  $res9referalitemrate1 = '0.00';

		  $res10consultationitemrate1 = '0.00';

		  

		  $query12 = "select * from master_transactionpaylater where locationcode='$locationcode1' and patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and billnumber='$res2billno' and transactiontype='finalize' ";

          $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res12 = mysqli_fetch_array($exec12);

		  $res12username = $res12['username'];

		  

		 $query3 = "select * from master_visitentry where locationcode='$locationcode1' and visitcode = '$res2visitcode'";

		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res3 = mysqli_fetch_array($exec3);

		  $res3planname = $res3['planname'];

		  $res10paymenttype = $res3['paymenttype'];

		  $memberno = $res3['memberno'];

		  

		  $query11 = "select * from master_paymenttype where auto_number = '$res10paymenttype'";

		  $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res11 = mysqli_fetch_array($exec11);

		  $res11paymenttype = $res11['paymenttype'];

		  

		  $query4 = "select * from master_planname where auto_number = '$res3planname'";

		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res4 = mysqli_fetch_array($exec4);

		  $res4planname = $res4['planname'];



		  $query50 = "select accountname, misreport from master_accountname where id = '$accountid'";

		  $exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die ("Error in Query50".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res50 = mysqli_fetch_array($exec50);

		  $res50accountname = $res50['accountname'];

		  $misid = $res50['misreport'];



		  $query51 = "select type from mis_types where auto_number = '$misid'";

		  $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res51 = mysqli_fetch_array($exec51);

		  $mistype = $res51['type'];

		  

		  $query5 = "select * from billing_paylaterlab where locationcode='$locationcode1' and billnumber = '$res2billno'";

		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while ($res5 = mysqli_fetch_array($exec5))

		  {

		  $res5labitemrate = $res5['labitemrate'];

		  $res5labitemrate1 = $res5labitemrate1 + $res5labitemrate;

		  }

		  $res5labitemrate1 = number_format($res5labitemrate1,'2','.','');

		  

		  $query6 = "select * from billing_paylaterservices where locationcode='$locationcode1' and wellnessitem <> 1 and billnumber = '$res2billno'";

		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while ($res6 = mysqli_fetch_array($exec6))

		  {

		  $res6servicesitemrate = $res6['amount'];

		  $res6servicesitemrate1 = $res6servicesitemrate1 + $res6servicesitemrate;

		  }

		  $res6servicesitemrate1 = number_format($res6servicesitemrate1,'2','.','');

		  /// pharmacy
		  $query88p = "select SUM(fxamount) AS  amount1 from billing_paylaterpharmacy where  locationcode='$locationcode' and  billnumber = '$res2billno' and accountname != 'CASH - HOSPITAL' group by accountname 
				UNION ALL
				select SUM(fxamount) AS  amount1 from billing_paynowpharmacy where  locationcode='$locationcode'and  billnumber = '$res2billno' and accountname != 'CASH - HOSPITAL' group by accountname ";
			$exec88p = mysqli_query($GLOBALS["___mysqli_ston"], $query88p) or die ("Error in query88p".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res88p = mysqli_fetch_array($exec88p)){

			$res88ppharmacyamount = $res88p['amount1'];
			$res7pharmacyitemrate1 =$res7pharmacyitemrate1 + $res88ppharmacyamount;
			}

			// ????????????? pharmacy 

		  // $query7 = "select * from billing_paylaterpharmacy where locationcode='$locationcode1' and billnumber = '$res2billno'";

		  // $exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());

		  // while ($res7 = mysql_fetch_array($exec7))

		  // {

		  // $res7pharmacyitemrate = $res7['amount'];

		  // $res7pharmacyitemrate1 = $res7pharmacyitemrate1 + $res7pharmacyitemrate;

		  // }

		  $res7pharmacyitemrate1 = number_format($res7pharmacyitemrate1,'2','.','');

		  

		  $query8 = "select * from billing_paylaterradiology where locationcode='$locationcode1' and billnumber = '$res2billno'";

		  $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while ($res8 = mysqli_fetch_array($exec8))

		  {

		  $res8radiologyitemrate = $res8['radiologyitemrate'];

		  $res8radiologyitemrate1 = $res8radiologyitemrate1 + $res8radiologyitemrate;

		  }

		  $res8radiologyitemrate1 = number_format($res8radiologyitemrate1,'2','.','');

		  

		  $query9 = "select * from billing_paylaterreferal where locationcode='$locationcode1' and billnumber = '$res2billno'";

		  $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while ($res9 = mysqli_fetch_array($exec9))

		  {

		  $res9referalitemrate = $res9['referalrate'];

		  $res9referalitemrate1 = $res9referalitemrate1 + $res9referalitemrate;

		  }

		  $res9referalitemrate1 = number_format($res9referalitemrate1,'2','.','');

		   $query1 = "select SUM(totalamount) AS billamount1 from billing_paylaterconsultation where  locationcode='$locationcode' and billno = '$res2billno' and accountname != 'CASH - HOSPITAL' group by accountname
			UNION ALL
			select SUM(consultation) as billamount1 from billing_consultation where locationcode='$locationcode' and billnumber = '$res2billno' and accountname != 'CASH - HOSPITAL' group by accountname";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res1 = mysqli_fetch_array($exec1)){;
			$res1billamount = $res1['billamount1'];
			$res10consultationitemrate1 = $res10consultationitemrate1 + $res1billamount;
			}

		  // $query10 = "select * from billing_paylaterconsultation where locationcode='$locationcode1' and billno = '$res2billno'";

		  // $exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());

		  // while ($res10 = mysql_fetch_array($exec10))

		  // {

		  // $res10consultationitemrate = $res10['totalamount'];

		  // $res10consultationitemrate1 = $res10consultationitemrate1 + $res10consultationitemrate;

		  // }

		  $res10consultationitemrate1 = number_format($res10consultationitemrate1,'2','.','');

		 

		  $total = $res5labitemrate1 + $res6servicesitemrate1 + $res7pharmacyitemrate1 + $res8radiologyitemrate1 + $res9referalitemrate1 + $res10consultationitemrate1;



		  $totallab += $res5labitemrate1;

		  $totalser += $res6servicesitemrate1;

		  $totalpharm += $res7pharmacyitemrate1;

		  $totalrad += $res8radiologyitemrate1;

		  $totalref += $res9referalitemrate1;

		  $totalcons += $res10consultationitemrate1;





		  $total = number_format($total,'2','.','');

		  $grandtotal = $grandtotal + $total;

		  

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

				$colorcode = 'bgcolor="#ecf0f5"';

			}

	

			?>

           <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res2billno; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <?php echo $res2billdate; ?></td>

              <td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $res2patientcode; ?></div></td>

				<!-- <td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php // echo $memberno; ?></div></td> -->

              <td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $res2patientname; ?></div></td>

				<!-- <td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php // echo $res50accountname; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php // echo $subtype; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php // echo $mistype; ?></div></td> -->

				<td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $res11paymenttype; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div align="left"><?php echo $res4planname; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($res5labitemrate1,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($res6servicesitemrate1,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($res7pharmacyitemrate1,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($res8radiologyitemrate1,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($res10consultationitemrate1,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div align="right"><?php echo number_format($res9referalitemrate1,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left"><?php echo number_format($total,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res12username); ?></td>

              <!-- <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td> -->

           </tr>

			<?php

			$res21accountname ='';

			}

			}

			

			}

			$res22accountname ='';

	        }

			

			}

			

			?>

            <tr>

              <!-- <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td> -->

              <!-- <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong> </strong></div></td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong> </strong></div></td> -->

              <td colspan="8" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong>Total</strong></div></td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totallab,2); ?></strong></div></td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totalser,2); ?></strong></div></td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totalpharm,2); ?></strong></div></td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totalrad,2); ?></strong></div></td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totalcons,2); ?></strong></div></td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totalref,2); ?></strong></div></td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotal,2,'.',','); ?></strong></td>

			  <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

			  <?php if($grandtotal != 0.00) 

			      {

				  ?>

              <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="viewopcreditxl.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $locationcode1; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&user=<?php echo $searchsuppliername; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>

            <?php } ?>

			</tr>

          </tbody>

        </table></td>

      </tr>

	  

    </table>

</table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>


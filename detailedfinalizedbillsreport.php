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
th {
            background-color: #ffffff;
            position: sticky;
            top: 0;
            z-index: 1;
        }


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
<link href="autocomplete.css" rel="stylesheet">

<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/datetimepicker_css.js"></script>

<script type="text/javascript" src="js/autocomplete_accounts2.js"></script>

<script type="text/javascript" src="js/autosuggest4accounts.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 
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

    <td width="97%" valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860">

		

		

              <form name="cbform1" method="post" action="detailedfinalizedbillsreport.php">

		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>OP Finalized Bills Summary</strong></td>

              <td colspan="2" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>

             

            

                  <?php

						

						if ($location!='')

						{

						 $query12 = "select locationname from master_location where locationcode='$location' order by locationname";

						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res12 = mysqli_fetch_array($exec12);

						

						echo $res1location = $res12["locationname"];

						//echo $location;

						}

						else

						{

						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res1 = mysqli_fetch_array($exec1);

						

						echo $res1location = $res1["locationname"];

						//$res1locationanum = $res1["locationcode"];

						}

						?>

						

						

                  

                  </td> 

              </tr>

            <!--<tr>

              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">

			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 

                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 

				</td>

              </tr>-->

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Account </td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
                 <input name="searchsuppliernamehiddentextbox" id="searchsuppliernamehiddentextbox" type="hidden" value="">
			  <input name="searchsubtypeanum1" id="searchsubtypeanum1" value="<?php echo $searchsubtypeanum1; ?>" type="hidden">

              </span></td>

              </tr>

            

			  <tr>

                      <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF"> Date From </td>
                	<?php 
                		if($ADate1!=""){
                			$paymentreceiveddatefrom=$ADate1;
                			$paymentreceiveddateto=$ADate2;
                		}
                	?>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>

                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31" > Date To </td>

                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">

                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>

                  </tr>

				<tr>

           

			  <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>

              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

			 

				 <select name="location" id="location" onChange="ajaxlocationfunction(this.value);">
                     <option value="All">All</option>

                    <?php
					

						$query1 = "select locationname,locationcode from master_location  order by auto_number desc";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						$loccode=array();

						while ($res1 = mysqli_fetch_array($exec1))

						{

						$locationname = $res1["locationname"];

						$locationcode = $res1["locationcode"];


						?>

						 <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>

						<?php

						} 

						?>

                      </select>

					 

              </span></td>

			   <td width="10%" align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>

			  </tr>	

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

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

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="120%" 

            align="left" border="0">

          <tbody>

            <tr>

              <td width="2%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td colspan="21" bgcolor="#ecf0f5" class="bodytext31">

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

					$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';

			  	}

				?> 			</td>  

            </tr>

            <tr>

              <th class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></th>

              <th width="" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit No</strong></div></th>

              <th width="" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Bill No </strong></th>

              <th width="" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Bill Date </strong></th>

              <th width="" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg No. </strong></div></th>

				 <th width="" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Member No. </strong></div></th>

              <th width="" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></th>

				<th width="12%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Accountname</strong></div></th>

				<th width="12%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Subtype</strong></div></th>

				<th width="" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Claim No</strong></div></th>
				
				<th width="" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>MIS Type</strong></div></th>

				<th width="" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Payment Type</strong></div></th>

              <th width="" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Plan Name </strong></div></th>

              <th width="" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Lab</strong></div></th>

              <th width="" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Service</strong></div></th>

              <th width="" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Pharmacy</strong></div></th>

              <th width="" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Radiology</strong></div></th>

              <th width="" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Consultation</strong></div></th>

              <th width="" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Referral</strong></div></th>

             

              <th width="" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Rescue</strong></th>
              <th width="" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Home Care</strong></th>

               <th width="" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Total</strong></th>
              <th width="" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Username</strong></th>

              <!--<th width="" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><div align="right"></div></th>-->

            </tr>

			<?php

			$totallab = $totalser = $totalpharm = $totalrad = $totalref = $totalcons = 0;
			 $total_res = 0;
		  $total_homecare = 0;

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				

				if ($cbfrmflag1 == 'cbfrmflag1')

				{
if($locationcode1=='All')
{
$pass_location = "locationcode !=''";
}
else
{
$pass_location = "locationcode ='$locationcode1'";
}

					
				if($searchsuppliername!=''){
							$query21 = "SELECT result.accountname from ( 
							 SELECT accountname from billing_paylater where $pass_location and accountname like '%$searchsuppliername%' and billdate between '$ADate1' and '$ADate2' group by accountname
							 UNION ALL   SELECT accountname from billing_paynow where $pass_location and accountname like '%$searchsuppliername%' and billdate between '$ADate1' and '$ADate2' group by accountname
							 UNION ALL  SELECT accountname from billing_consultation where $pass_location and accountname like '%$searchsuppliername%' and billdate between '$ADate1' and '$ADate2' group by accountname
									order by accountname desc 
								) as result group by result.accountname";
					}else{
						$query21 = "SELECT result.accountname from (
						SELECT accountname from billing_paylater where $pass_location and billdate between '$ADate1' and '$ADate2' group by accountname 
						UNION ALL   SELECT accountname from billing_paynow where $pass_location and billdate between '$ADate1' and '$ADate2' group by accountname
						UNION ALL  SELECT accountname from billing_consultation where $pass_location and billdate between '$ADate1' and '$ADate2' group by accountname
						order by accountname desc 
						) as result group by result.accountname";
					}
			// $query21 = "SELECT accountname from master_accountname where $pass_location and recordstatus <>'DELETED' ";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res21 = mysqli_fetch_array($exec21))
			{

			$res21accountname = $res21['accountname'];

			

			// $query22 = "select * from master_accountname where $pass_location and accountname = '$res21accountname' and recordstatus <>'DELETED' ";
			// $exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
			// $res22 = mysql_fetch_array($exec22);
			// $res22accountname = $res22['accountname'];

			if(( $res21accountname != '')&&($res21accountname != 'CASH - HOSPITAL'))
			{
	

			// $dotarray = explode("-", $paymentreceiveddateto);
			// $dotyear = $dotarray[0];
			// $dotmonth = $dotarray[1];
			// $dotday = $dotarray[2];
			// $paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			

		  // $query1 = "select * from master_accountname where $pass_location and accountname = '$searchsuppliername'";
		  // $exec1 = mysql_query($query1) or die ("Error in query1".mysql_error());
		  // $res1 = mysql_fetch_array($exec1);
		  // $res1auto_number = $res1['auto_number'];
		  // $res1accountname = $res1['accountname'];


		  $query2 = "SELECT accountname, patientcode, visitcode, billno, billdate, patientname, accountnameid, subtype,preauthcode as claimid from billing_paylater where $pass_location and accountname = '$res21accountname' and billdate between '$ADate1' and '$ADate2' 
		 UNION ALL  SELECT accountname, patientcode, visitcode, billno, billdate, patientname, '' as accountnameid,subtype,'' as claimid  from billing_paynow where $pass_location and accountname = '$res21accountname'  and accountname != 'CASH - HOSPITALzs'  and billdate between '$ADate1' and '$ADate2' 
		 UNION ALL   SELECT accountname, patientcode,patientvisitcode as visitcode,billnumber as billno, billdate, patientname, '' as accountnameid,'' as subtype,'' as claimid from billing_consultation where $pass_location and accountname = '$res21accountname'  and accountname != 'CASH - HOSPITAL'  and billdate between '$ADate1' and '$ADate2' 
		  order by accountname desc "; 

		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num1=mysqli_num_rows($exec2);
		  if($num1>0){
		  // if(1){
		  	?>
				<tr bgcolor="#ecf0f5">
            		<td colspan="22"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo $res21accountname.$num1;?> </strong></td>
            	</tr>
            <?php
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
		    $res2visitcode = $res2['visitcode'];   

     	  $res2accountname = $res2['accountname'];

		  $res2patientcode = $res2['patientcode'];

		  $res2visitcode = $res2['visitcode'];

		  $res2billno = $res2['billno'];

		  $res2billdate = $res2['billdate'];

		  $res2patientname = $res2['patientname'];

		  $accountid = $res2['accountnameid'];

		  $subtype = $res2['subtype'];
		  
		  $claimid = $res2['claimid'];

		  //echo $res2paymenttype = $res2['paymenttype'];

		  $res5labitemrate1 = '0.00';

		  $res6servicesitemrate1 = '0.00';

		  $res7pharmacyitemrate1 = '0.00';

		  $res8radiologyitemrate1 = '0.00';

		  $res9referalitemrate1 = '0.00';

		  $res10consultationitemrate1 = '0.00';

		  

		  $query12 = "select * from master_transactionpaylater where $pass_location and patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and billnumber='$res2billno' and transactiontype='finalize' ";

          $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res12 = mysqli_fetch_array($exec12);

		  $res12username = $res12['username'];

		  

		 $query3 = "select * from master_visitentry where $pass_location and visitcode = '$res2visitcode'";

		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $res3 = mysqli_fetch_array($exec3);

		  $res3planname = $res3['planname'];

		  $res10paymenttype = $res3['paymenttype'];

		  $memberno = $res3['memberno'];
			
		  $schemefromvisit=$res3['accountfullname'];
		  

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

		  

		  $query5 = "select * from billing_paylaterlab where $pass_location and billnumber = '$res2billno'";

		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while ($res5 = mysqli_fetch_array($exec5))

		  {

		  $res5labitemrate = $res5['labitemrate'];

		  $res5labitemrate1 = $res5labitemrate1 + $res5labitemrate;

		  }

		  $res5labitemrate1 = number_format($res5labitemrate1,'2','.','');

		  

		  $query6 = "select * from billing_paylaterservices where $pass_location and wellnessitem <> 1 and billnumber = '$res2billno'";

		  $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while ($res6 = mysqli_fetch_array($exec6))

		  {

		  $res6servicesitemrate = $res6['amount'];

		  $res6servicesitemrate1 = $res6servicesitemrate1 + $res6servicesitemrate;

		  }

		  $res6servicesitemrate1 = number_format($res6servicesitemrate1,'2','.','');

		  /// pharmacy
		  /* $query88p = "select SUM(fxamount) AS  amount1 from billing_paylaterpharmacy where  locationcode='$locationcode' and  billnumber = '$res2billno' and accountname != 'CASH - HOSPITAL' group by accountname 
				UNION ALL
				select SUM(fxamount) AS  amount1 from billing_paynowpharmacy where  locationcode='$locationcode'and  billnumber = '$res2billno' and accountname != 'CASH - HOSPITAL' group by accountname "; *///commented by KK
			$query88p = "select SUM(fxamount) AS  amount1 from billing_paylaterpharmacy where    billnumber = '$res2billno' and accountname != 'CASH - HOSPITAL' group by accountname 
				";
			$exec88p = mysqli_query($GLOBALS["___mysqli_ston"], $query88p) or die ("Error in query88p".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res88p = mysqli_fetch_array($exec88p)){

			$res88ppharmacyamount = $res88p['amount1'];
			$res7pharmacyitemrate1 =$res7pharmacyitemrate1 + $res88ppharmacyamount;
			}

			// ????????????? pharmacy 

		  // $query7 = "select * from billing_paylaterpharmacy where $pass_location and billnumber = '$res2billno'";

		  // $exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());

		  // while ($res7 = mysql_fetch_array($exec7))

		  // {

		  // $res7pharmacyitemrate = $res7['amount'];

		  // $res7pharmacyitemrate1 = $res7pharmacyitemrate1 + $res7pharmacyitemrate;

		  // }

		  $res7pharmacyitemrate1 = number_format($res7pharmacyitemrate1,'2','.','');

		  

		  // $query8 = "select * from billing_paylaterradiology where $pass_location and billnumber = '$res2billno'";
		  $query8 = "SELECT sum(radiologyitemrate) as radiologyitemrate from billing_paylaterradiology where $pass_location and billnumber = '$res2billno'
		  ";
		  // union all select sum(radiologyitemrate) as radiologyitemrate from billing_paynowradiology where $pass_location and billnumber = '$res2billno'

		  $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while ($res8 = mysqli_fetch_array($exec8))

		  {

		  $res8radiologyitemrate = $res8['radiologyitemrate'];

		  $res8radiologyitemrate1 = $res8radiologyitemrate1 + $res8radiologyitemrate;

		  }

		  $res8radiologyitemrate1 = number_format($res8radiologyitemrate1,'2','.','');

		  

		  $query9 = "SELECT sum(referalrate) as referalrate from billing_paylaterreferal where $pass_location and billnumber = '$res2billno'
		  union all select sum(referalrate) as referalrate from billing_paynowreferal where billnumber='$res2billno'";

		  $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while ($res9 = mysqli_fetch_array($exec9))

		  {

		  $res9referalitemrate = $res9['referalrate'];

		  $res9referalitemrate1 = $res9referalitemrate1 + $res9referalitemrate;

		  }

		  $res9referalitemrate1 = number_format($res9referalitemrate1,'2','.','');

		  /*  $query1 = "select SUM(totalamount) AS billamount1 from billing_paylaterconsultation where  locationcode='$locationcode' and billno = '$res2billno' and accountname != 'CASH - HOSPITAL' group by accountname
			UNION ALL
			select SUM(consultation) as billamount1 from billing_consultation where locationcode='$locationcode' and billnumber = '$res2billno' and accountname != 'CASH - HOSPITAL' group by accountname";  */
			$query1 = "select SUM(totalamount) AS billamount1 from billing_paylaterconsultation where   billno = '$res2billno' and accountname != 'CASH - HOSPITAL' group by accountname
			";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res1 = mysqli_fetch_array($exec1)){;
			$res1billamount = $res1['billamount1'];
			$res10consultationitemrate1 = $res10consultationitemrate1 + $res1billamount;
			}

		  // $query10 = "select * from billing_paylaterconsultation where $pass_location and billno = '$res2billno'";

		  // $exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());

		  // while ($res10 = mysql_fetch_array($exec10))

		  // {

		  // $res10consultationitemrate = $res10['totalamount'];

		  // $res10consultationitemrate1 = $res10consultationitemrate1 + $res10consultationitemrate;

		  // }

		  $res10consultationitemrate1 = number_format($res10consultationitemrate1,'2','.','');


		 

		  $total = $res5labitemrate1 + $res6servicesitemrate1 + $res7pharmacyitemrate1 + $res8radiologyitemrate1 + $res9referalitemrate1 + $res10consultationitemrate1;
/*if($res21accountname=='UAP OLD MUTUAL INSURANCE')
{
    ?>
	<tr bgcolor="#ecf0f5">
            		<td colspan="22"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo $res2visitcode.$res7pharmacyitemrate1;?> </strong></td>
            	</tr>    
<?php   
} */


		  $totallab += $res5labitemrate1;

		  $totalser += $res6servicesitemrate1;

		  $totalpharm += $res7pharmacyitemrate1;

		  $totalrad += $res8radiologyitemrate1;

		  $totalref += $res9referalitemrate1;

		  $totalcons += $res10consultationitemrate1;





		  $total = number_format($total,'2','.','');

		  $grandtotal = $grandtotal + $total;
	
		  
		if($total>0){
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

				<td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $memberno; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $res2patientname; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $schemefromvisit; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $subtype; ?></div></td>
				
				<td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $claimid; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $mistype; ?></div></td>

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

			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(0,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(0,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="right"><?php echo number_format($total,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right"><?php echo strtoupper($res12username); ?></td>

              <!--<td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>-->

           </tr>

			<?php

			$res21accountname ='';

			}
		  }
			}

			

			}

			$res22accountname ='';

	        }

			
 
			
			///////////// OP CASH STARTS/////////////////////////
			/*
			if($searchsuppliername=='CASH' or $searchsuppliername==''){
			?>
			<tr bgcolor="#ecf0f5">
            		<td colspan="22"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>CASH - HOSPITAL</strong></td>
            	</tr>
            	<?php
	        $transactiondatefrom=$_POST['ADate1'];
				$transactiondateto=$_POST['ADate2'];
				$location = $locationcode1;
				$cashtotal_final=0;
			//**CONSULTATION**
			//CASH
			$query_op = "SELECT patientcode, patientvisitcode as  visitcode, patientname, billnumber as billno, billdate as billdate, username  from billing_consultation where $pass_location and accountname='CASH - HOSPITAL' and billdate between '$transactiondatefrom' and '$transactiondateto' group by billno
			union all SELECT patientcode,visitcode, patientname, billno as billno, billdate as billdate, username   from billing_paynow where  $pass_location and  billdate between '$transactiondatefrom' and '$transactiondateto' group by billno
			 -- accountname='CASH - HOSPITAL' and

			UNION ALL SELECT patientcode,visitcode, patientname, billno as billno, billdate as billdate, username   from billing_paylater where accountname='CASH - HOSPITAL' and $pass_location  group by billno
			-- and  billdate between '$transactiondatefrom' and '$transactiondateto'


			union all SELECT patientcode,visitcode, patientname, docno as billno, recorddate as billdate, username   from billing_opambulance where  $pass_location and  recorddate between '$transactiondatefrom' and '$transactiondateto' group by billno
			-- accountname='CASH - HOSPITAL' and 
			union all SELECT patientcode,visitcode, patientname, docno as billno, recorddate as billdate, username  from billing_homecare where  $pass_location and  recorddate between '$transactiondatefrom' and '$transactiondateto' group by billno
			-- accountname='CASH - HOSPITAL' and 
			";
			$exec_op = mysqli_query($GLOBALS["___mysqli_ston"], $query_op) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res_op = mysqli_fetch_array($exec_op)){
				$patientcode_op = $res_op['patientcode'];
				$patientname_op = $res_op['patientname'];
				$visitcode_op = $res_op['visitcode'];
				$billno_op = $res_op['billno'];
				$billno_op = $res_op['billno'];
				$billdate_op  = $res_op['billdate'];
				$username_op  = $res_op['username'];
	////////////////
			$query3 = "select * from master_visitentry where $pass_location and visitcode = '$visitcode_op'";
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res3 = mysqli_fetch_array($exec3);
		  $res3planname = $res3['planname'];
		  $res10paymenttype = $res3['paymenttype'];
		  $memberno_op = $res3['memberno'];

		  $accountname_op = $res3['accountfullname'];
		  $subtypeanum_op = $res3['subtype'];
		  $accountid_op = $res3['accountname'];

		  $query_subtype = "select subtype from master_subtype where auto_number = '$subtypeanum_op'";
		  $exec_subtype = mysqli_query($GLOBALS["___mysqli_ston"], $query_subtype) or die ("Error in Query_subtype".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res_subtype = mysqli_fetch_array($exec_subtype);
		  $subtype_op = $res_subtype['subtype'];

		  $query11 = "select * from master_paymenttype where auto_number = '$res10paymenttype'";
		  $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res11 = mysqli_fetch_array($exec11);
		  $res11paymenttype = $res11['paymenttype'];

		  $query4 = "select * from master_planname where auto_number = '$res3planname'";
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res4 = mysqli_fetch_array($exec4);
		  $res4planname = $res4['planname'];

		  // $accountname_op='CASH - HOSPITAL';
		  // $subtype_op='CASH';
		  //////////
		  $query50 = "select accountname, misreport from master_accountname where auto_number = '$accountid_op'";
		  $exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die ("Error in Query50".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res50 = mysqli_fetch_array($exec50);
		  $res50accountname = $res50['accountname'];
		  $misid = $res50['misreport'];

		  $query51 = "select type from mis_types where auto_number = '$misid'";
		  $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res51 = mysqli_fetch_array($exec51);
		  $mistype = $res51['type'];
		  // $mistype = 'CASH';
		  //////////

				$query1 = "SELECT sum(consultation) as billamount1 from billing_consultation where billnumber='$billno_op'  and accountname='CASH - HOSPITAL' 
				UNION ALL
				select sum(totalamount) as billamount1 from billing_paylaterconsultation where $pass_location and  billno = '$billno_op' and  accountname = 'CASH - HOSPITAL' ";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$res1consultationamount = $res1['billamount1'];

			$query9 = "SELECT sum(fxamount) as amount1 from billing_paynowpharmacy where $pass_location and   billnumber='$billno_op' and accountname='CASH - HOSPITAL'
			-- AND billdate between '$transactiondatefrom' and '$transactiondateto'
			UNION ALL
		  	select sum(amount) as amount1 from billing_paylaterpharmacy where $pass_location and  billnumber = '$billno_op' and  accountname = 'CASH - HOSPITAL'  AND billdate between '$transactiondatefrom' and '$transactiondateto'
			"; 
			$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res9 = mysqli_fetch_array($exec9);
			$res9pharmacyitemrate = $res9['amount1'];

			$query3 = "SELECT sum(fxamount) as labitemrate1 from billing_paynowlab where $pass_location and billnumber='$billno_op'  
			-- AND billdate between '$transactiondatefrom' and '$transactiondateto'
			UNION ALL select sum(labitemrate) as labitemrate1 from billing_paylaterlab where $pass_location  and  billnumber = '$billno_op' and accountname = 'CASH - HOSPITAL' AND billdate between '$transactiondatefrom' and '$transactiondateto'
			"; 
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$res3labitemrate = $res3['labitemrate1'];

			$query5 = "SELECT sum(fxamount) as radiologyitemrate1 from billing_paynowradiology where $pass_location and billnumber='$billno_op'  AND billdate between '$transactiondatefrom' and '$transactiondateto'
				UNION ALL select SUM(fxamount) AS  radiologyitemrate1 from billing_paylaterradiology where  $pass_location and  billnumber = '$billno_op' and accountname = 'CASH - HOSPITAL'  AND billdate between '$transactiondatefrom' and '$transactiondateto'"; 
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res5 = mysqli_fetch_array($exec5);
			$res5radiologyitemrate = $res5['radiologyitemrate1'];

			$query7 = "select sum(fxamount) as servicesitemrate1 from billing_paynowservices where billnumber='$billno_op'  "; 
			// AND billdate between '$transactiondatefrom' and '$transactiondateto'
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res7 = mysqli_fetch_array($exec7);
			$res7servicesitemrate = $res7['servicesitemrate1'];

			$query11 = "select sum(referalrate) as referalrate1 from billing_paynowreferal where billnumber='$billno_op'  "; 
			// AND billdate between '$transactiondatefrom' and '$transactiondateto'
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11 = mysqli_fetch_array($exec11);
			$res11referalitemrate = $res11['referalrate1'];

			$query30 = "select sum(amount) as amount1 from billing_opambulance where docno='$billno_op' ";
			$exec30= mysqli_query($GLOBALS["___mysqli_ston"], $query30) or die ("Error in Query30".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res30 = mysqli_fetch_array($exec30) ;
			$res30rescue = $res30['amount1'];

			$query28 = "select sum(amount) as amount1 from billing_homecare where docno='$billno_op' ";
			$exec28= mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query28".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res28 = mysqli_fetch_array($exec28) ;
			$res28homecare = $res28['amount1'];

			 $cashtotal = $res1consultationamount + $res9pharmacyitemrate + $res3labitemrate + $res5radiologyitemrate + $res7servicesitemrate + $res11referalitemrate + $res30rescue + $res28homecare;
			 // 

			 // $cashtotal_final+=$cashtotal;

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

			$totallab += $res3labitemrate;
		  $totalser += $res7servicesitemrate;
		  $totalpharm += $res9pharmacyitemrate;
		  $totalrad += $res5radiologyitemrate;
		  $totalref += $res11referalitemrate;
		  $totalcons += $res1consultationamount;

		  $total_res += $res30rescue;
		  $total_homecare += $res28homecare;

		  $grandtotal = $grandtotal + $cashtotal;
			 ?>

			 <tr <?php echo $colorcode; ?>>
              	  <td class="bodytext31" valign="center"  align="left"><?=$snocount;?></td>	
              	  <td class="bodytext31" valign="center"  align="left"><?=$visitcode_op;?></td>
              	   <td class="bodytext31" valign="center"  align="left"><?=$billno_op;?></td>
              	  <td class="bodytext31" valign="center"  align="left"><?=$billdate_op;?></td>	
              	 	<td class="bodytext31" valign="center"  align="left"><?=$patientcode_op;?></td>	
              	 	<td class="bodytext31" valign="center"  align="left"><?=$memberno_op;?></td>	
              	  <td class="bodytext31" valign="center"  align="left"><?=$patientname_op;?></td>	

              	  <td class="bodytext31" valign="center"  align="left"><?=$accountname_op;?></td>	
              	  <td class="bodytext31" valign="center"  align="left"><?=$subtype_op;?></td>	
              	  <td class="bodytext31" valign="center"  align="left"><?=$mistype;?></td>	

              	  <td class="bodytext31" valign="center"  align="left"><?=$res11paymenttype;?></td>	
              	  <td class="bodytext31" valign="center"  align="left"><?=$res4planname;?></td>	

              	  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res3labitemrate,2,'.',','); ?></div></td>
              	   <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res7servicesitemrate,2,'.',','); ?></div></td>
              	    <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo  number_format($res9pharmacyitemrate,2,'.',','); ?></div></td>
              	      <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res5radiologyitemrate,2,'.',','); ?></div></td>
              	  	
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res1consultationamount,2,'.',','); ?></div></td>
                 
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res11referalitemrate,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res30rescue,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res28homecare,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($cashtotal,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo strtoupper($username_op); ?></div></td>
               </tr>
			
			<?php
			   	}
			} //if($searchsuppliername='cash' or $searchsuppliername=''){ ends
			// echo $cashtotal_final;
			///////////// OP CASH ENDS///////////////////////// */
				
			///////////// OP REFUNDS STARTS/////////////////////////
			if($searchsuppliername=='REFUNDS' or $searchsuppliername=='REFUND' or $searchsuppliername==''){
			?>
			<tr bgcolor="#ecf0f5">
            		<td colspan="22"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong>REFUNDS</strong></td>
            	</tr>
            	<?php
			$res12refundconsultation1=0;
			$res12refundconsultation2=0;
			$res12refundconsultation3=0;

	$query_refund="SELECT patientcode,visitcode, patientname, billnumber as billno, transactiondate as billdate, username,'' as claimid from refund_paynow where  $pass_location and  transactiondate between '$transactiondatefrom' and '$transactiondateto'  
			UNION ALL SELECT patientcode,visitcode, patientname, billno as billno, billdate as billdate, username,'' as claimid from refund_paylater where  $pass_location and  billdate between '$transactiondatefrom' and '$transactiondateto'  
			UNION ALL SELECT patientcode,visitcode, patientname, billno as billno, entrydate as billdate, username,'' as claimid from billing_patientweivers where  $pass_location and entrydate between '$transactiondatefrom' and '$transactiondateto'

			UNION ALL SELECT patientcode,patientvisitcode AS visitcode, patientname, billnumber AS billno, billdate as billdate, username, '' as claimid FROM `paylaterpharmareturns` WHERE $pass_location and billdate between  '$transactiondatefrom' and '$transactiondateto' AND ledgercode <> '' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`) group by billnumber

			";
			// UNION ALL SELECT patientcode,patientvisitcode as visitcode, patientname, billnumber as billno from refund_consultation where  $pass_location and  billdate between '$transactiondatefrom' and '$transactiondateto'  group by visitcode

			$exec_refund = mysqli_query($GLOBALS["___mysqli_ston"], $query_refund) or die ("Error in query1123".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res_refund = mysqli_fetch_array($exec_refund)){
				$patientcode_refund = $res_refund['patientcode'];
				$patientname_refund = $res_refund['patientname'];
				$visitcode_refund = $res_refund['visitcode'];
				$billno_refund = $res_refund['billno'];
				$billdate_refund = $res_refund['billdate'];
				$username_refund = $res_refund['username'];
				$claimid = $res_refund['claimid'];


				////////////////
			$query3 = "select * from master_visitentry where $pass_location and visitcode = '$visitcode_refund'";
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res3 = mysqli_fetch_array($exec3);
		  $res3planname = $res3['planname'];
		  $res10paymenttype = $res3['paymenttype'];
		  $memberno_refund = $res3['memberno'];
		  $accountname_refund = $res3['accountfullname'];
		  $subtypeanum_refund = $res3['subtype'];
		  $accountid_refund = $res3['accountname'];

		  $query_subtype = "select subtype from master_subtype where auto_number = '$subtypeanum_refund'";
		  $exec_subtype = mysqli_query($GLOBALS["___mysqli_ston"], $query_subtype) or die ("Error in Query_subtype".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res_subtype = mysqli_fetch_array($exec_subtype);
		  $res_subtype_name_refunds = $res_subtype['subtype'];

		  $query11 = "select * from master_paymenttype where auto_number = '$res10paymenttype'";
		  $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res11 = mysqli_fetch_array($exec11);
		  $res11paymenttype = $res11['paymenttype'];
		if($res11paymenttype=='CASH')
		{
			continue;
		}
		  $query4 = "select * from master_planname where auto_number = '$res3planname'";
		  $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res4 = mysqli_fetch_array($exec4);
		  $res4planname = $res4['planname'];

		  //////////
		  $query50 = "select accountname, misreport from master_accountname where auto_number = '$accountid_refund'";
		  $exec50 = mysqli_query($GLOBALS["___mysqli_ston"], $query50) or die ("Error in Query50".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res50 = mysqli_fetch_array($exec50);
		  $res50accountname = $res50['accountname'];
		  $misid = $res50['misreport'];

		  $query51 = "select type from mis_types where auto_number = '$misid'";
		  $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res51 = mysqli_fetch_array($exec51);
		  $mistype = $res51['type'];
		  // $mistype = 'CASH';
		  //////////


			// 	$query121 = "select sum(consultationfxamount) as consultation1 from billing_patientweivers where billno='$billno_refund' ";
			// $exec121 = mysql_query($query121) or die ("Error in Query121".mysql_error());
			// $res121 = mysql_fetch_array($exec121);
			// $res12refundconsultation = $res121['consultation1'];

//REFUND
			$query12 = "select sum(consultation) as consultation1 from refund_consultation where billnumber='$billno_refund'";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res12 = mysqli_fetch_array($exec12);
			$res12refundconsultation1 = $res12['consultation1'];

			$query12 = "select sum(consultation) as consultation1 from refund_paylaterconsultation where billnumber='$billno_refund'";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res12 = mysqli_fetch_array($exec12);
			$res12refundconsultation2 = $res12['consultation1'];

			$query222 = "select sum(consultationfxamount) as amount1 from billing_patientweivers where billno='$billno_refund'";
			$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res222 = mysqli_fetch_array($exec222) ;
			$res12refundconsultation3 = $res222['amount1'];

			$res12refundconsultation=$res12refundconsultation1+$res12refundconsultation2+$res12refundconsultation3;

//REFUND pharmacy
			$query21 = "select sum(amount) as amount1 from refund_paylaterpharmacy where billnumber='$billno_refund'";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res21 = mysqli_fetch_array($exec21) ;
			$res21refundlabitemrate = $res21['amount1'];

			$query22 = "select sum(amount) as amount1 from refund_paynowpharmacy where billnumber='$billno_refund'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22) ;
			$res22refundlabitemrate = $res22['amount1'];

			$query221 = "select sum(pharmacyfxamount) as amount1 from billing_patientweivers where `billno`='$billno_refund'";
			$exec221 = mysqli_query($GLOBALS["___mysqli_ston"], $query221) or die ("Error in Query221".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res221 = mysqli_fetch_array($exec221) ;
			$res22refundlabitemrate1 = $res221['amount1'];
			

			$query21p = "SELECT SUM(`amount`) as amount1 FROM `paylaterpharmareturns` WHERE  `billnumber`='$billno_refund'";
			$exec21p = mysqli_query($GLOBALS["___mysqli_ston"], $query21p) or die ("Error in Query21p".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res21p = mysqli_fetch_array($exec21p) ;
		    $res21prefundlabitemrate = $res21p['amount1'];

		    $totalrefundpharmacy = $res22refundlabitemrate + $res21refundlabitemrate+$res21prefundlabitemrate+$res22refundlabitemrate1;






			//REFUND LAB
			$query19 = "select sum(labitemrate) as labitemrate1 from refund_paylaterlab where billnumber='$billno_refund'";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query19".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res19 = mysqli_fetch_array($exec19) ;
			$res19refundlabitemrate = $res19['labitemrate1'];
			$query20 = "select sum(labitemrate) as labitemrate1 from refund_paynowlab where billnumber='$billno_refund'";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res20 = mysqli_fetch_array($exec20) ;
			$res20refundlabitemrate = $res20['labitemrate1'];

			$query222 = "select sum(labfxamount) as amount1 from billing_patientweivers where `billno`='$billno_refund'";
			$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res222 = mysqli_fetch_array($exec222) ;
			$res20refundlabitemrate1 = $res222['amount1'];

			$totalrefundlab = $res20refundlabitemrate + $res19refundlabitemrate+$res20refundlabitemrate1;


			//REFUND radiology
			$query22 = "select sum(fxamount) as radiologyitemrate1 from refund_paylaterradiology where billnumber='$billno_refund'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22) ;
			$res22refundradioitemrate = $res22['radiologyitemrate1'];
			$query23 = "select sum(radiologyitemrate) as radiologyitemrate1 from refund_paynowradiology where billnumber='$billno_refund'";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res23 = mysqli_fetch_array($exec23) ;
			$res23refundradioitemrate = $res23['radiologyitemrate1'];

			$query223 = "select sum(radiologyfxamount) as amount1 from billing_patientweivers where `billno`='$billno_refund'";
			$exec223 = mysqli_query($GLOBALS["___mysqli_ston"], $query223) or die ("Error in Query223".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res223 = mysqli_fetch_array($exec223) ;
			$res23refundradioitemrate1 = $res223['amount1'];

			$totalrefundradio = $res23refundradioitemrate + $res22refundradioitemrate+$res23refundradioitemrate1;

			//REFUND services
			$query24 = "select sum(fxamount) as servicesitemrate1 from refund_paylaterservices where billnumber='$billno_refund'";
			$exec24= mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res24 = mysqli_fetch_array($exec24) ;
			$res24refundserviceitemrate = $res24['servicesitemrate1'];
			$query25 = "select sum(servicetotal) as servicesitemrate1 from refund_paynowservices where billnumber='$billno_refund'";
			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res25 = mysqli_fetch_array($exec25) ;
			$res25refundserviceitemrate = $res25['servicesitemrate1'];

			$query225 = "select sum(servicesfxamount) as amount1 from billing_patientweivers where `billno`='$billno_refund'";
			$exec225 = mysqli_query($GLOBALS["___mysqli_ston"], $query225) or die ("Error in Query225".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res225 = mysqli_fetch_array($exec225) ;
			$res25refundserviceitemrate1 = $res225['amount1'];

			$totalrefundservice = $res25refundserviceitemrate + $res24refundserviceitemrate+$res25refundserviceitemrate1;


			//REFUNDS
			$query26 = "select sum(referalrate) as referalrate1 from refund_paylaterreferal where billnumber='$billno_refund'";
			$exec26= mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res26 = mysqli_fetch_array($exec26) ;
			$res26refundreferalitemrate = $res26['referalrate1'];
			$query27 = "select sum(referalrate) as referalrate1 from refund_paynowreferal where billnumber='$billno_refund'";
			$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res27 = mysqli_fetch_array($exec27) ;
			$res27refundreferalitemrate = $res27['referalrate1'];
			$totalrefundreferal = $res27refundreferalitemrate + $res26refundreferalitemrate;

			 $refundtotal = $res12refundconsultation + $totalrefundpharmacy + $totalrefundlab + $totalrefundradio + $totalrefundservice + $totalrefundreferal;

$consultation_ref=$res12refundconsultation;
$pharmacy_ref=$totalrefundpharmacy;
$lab_ref=$totalrefundlab;
$radio_ref=$totalrefundradio;
$services_ref=$totalrefundservice;
$ref_ref=$totalrefundreferal;
$rescue_ref=0;
$homecare_ref=0;

$subtotal_ref=$refundtotal;
		$totallab -=$lab_ref;
		  $totalser -=$services_ref;
		  $totalpharm -=$pharmacy_ref;
		  $totalrad -=$radio_ref;
		  $totalref -=$ref_ref;
		  $totalcons -=$consultation_ref;

		  $grandtotal -= $refundtotal;

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


			 <tr <?php echo $colorcode; ?>>
              	  <td class="bodytext31" valign="center"  align="left"><?=$snocount;?></td>	
              	   <td class="bodytext31" valign="center"  align="left"><?=$visitcode_refund;?></td>	
              	    <td class="bodytext31" valign="center"  align="left"><?=$billno_refund;?></td>	

              	  <td class="bodytext31" valign="center"  align="left"><?=$billdate_refund;?></td>	
              	  <td class="bodytext31" valign="center"  align="left"><?=$patientcode_refund;?></td>	
              	  <td class="bodytext31" valign="center"  align="left"><?=$memberno_refund;?></td>	
              	  <td class="bodytext31" valign="center"  align="left"><?=$patientname_refund;?></td>	
 
				 <td class="bodytext31" valign="center"  align="left"><?=$accountname_refund;?></td>	
              	  <td class="bodytext31" valign="center"  align="left"><?=$res_subtype_name_refunds;?></td>	
              	  <td class="bodytext31" valign="center"  align="left"><?=$claimid;?></td>	
              	  <td class="bodytext31" valign="center"  align="left"><?=$mistype;?></td>	
              	  <td class="bodytext31" valign="center"  align="left"><?=$res11paymenttype;?></td>	
              	  <td class="bodytext31" valign="center"  align="left"><?=$res4planname;?></td>	

              	  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format((-1)*$lab_ref,2,'.',','); ?></div></td>
              	  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format((-1)*$services_ref,2,'.',','); ?></div></td>
              	  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo  number_format((-1)*$pharmacy_ref,2,'.',','); ?></div></td>
              	  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format((-1)*$radio_ref,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format((-1)*$consultation_ref,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format((-1)*$ref_ref,2,'.',','); ?></div></td>

                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  echo number_format((-1)*$rescue_ref,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  echo number_format((-1)*$homecare_ref,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format((-1)*$subtotal_ref,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo strtoupper($username_refund); ?></div></td>
               </tr>

           <?php } // while close of refunds  
           	} // if($searchsuppliername='refunds' or $searchsuppliername='refund' or $searchsuppliername=''){ close.
           		
			///////////// OP REFUNDS ENDS/////////////////////////

			} // CBFORM CLOSE

			?>

            <tr>

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

                bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong> </strong></div></td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong> </strong></div></td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong><!--Total--></strong></div></td>

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

              <td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($totalref,2); ?></strong></div></td>

              <td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($total_res,2); ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($total_homecare,2); ?></strong></div></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotal,2,'.',','); ?></strong></td>

			  <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

			  <?php if($grandtotal != 0.00) 

			      {

				  ?>

              <td align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="print_detailedfinalizedbillsreport.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $locationcode1; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&user=<?php echo $searchsuppliername; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>

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


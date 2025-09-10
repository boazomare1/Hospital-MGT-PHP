<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");


$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$suppliername = "";

$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$searchsuppliername = "";

$res2suppliername = '';

$suppliercode = '';

$cbsuppliername = "";

$totalbalance=0;

$billnumberprefix = '';

 

$location="select locationcode from login_locationdetails where username='$username' and docno='$docno'";

$exeloc=mysqli_query($GLOBALS["___mysqli_ston"], $location);

$resloc=mysqli_fetch_array($exeloc);

$locationcode=$resloc['locationcode'];

//This include updatation takes too long to load for hunge items database.

//include ("autocompletebuild_supplier1.php");

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

//$frmflag2 = $_POST['frmflag2'];



if ($frmflag2 == 'frmflag2')

{



$paynowbillprefix = 'PV-';

$paynowbillprefix1=strlen($paynowbillprefix);



//$query2 = "select paymentvoucherno from master_transactionpharmacy where approved_payment = '1' and paymentvoucherno <> '' group by paymentvoucherno";
$query2 = "select paymentvoucherno from master_transactionpharmacy where approved_payment = '1' and paymentvoucherno <> '' group by  LENGTH(paymentvoucherno) desc,paymentvoucherno desc limit 0,1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$pvrows = mysqli_num_rows($exec2);

$billnumber = $res2["paymentvoucherno"];

$billdigit=strlen($billnumber);

if ($pvrows == '0')

{

	$billnumbercode ='PV-'.'1';

	$openingbalance = '0.00';

}

else

{

	$billnumber = $res2["paymentvoucherno"];

	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

	

	//$billnumbercode = intval($pvrows);

	//echo $billnumbercode;

	$billnumbercode = $billnumbercode + 1;
    
    
    

	$maxanum = $billnumbercode;

	

	$billnumbercode = 'PV-' .$maxanum;

	$openingbalance = '0.00';

    //echo $billnumbercode;

    //exit;
	//echo $companycode;

}

		if (isset($_REQUEST['billnum'])){$numrow = (sizeof($_REQUEST["billnum"]))?sizeof($_REQUEST["billnum"]):0;} else {$numrow=0;}

		

		if(true)

		{

		$data=0;

		//$bankname1 = $_REQUEST['bankname'];

		$chequedate=$_REQUEST['ADate1'];

		$paymentmode = $_REQUEST['paymentmode'];

		//$billnum= $_REQUEST['newserselect'];

		$suppliercode= $_REQUEST['suppliercode'];

		//$apndbankname=$_POST['apndbankname'];

		$bankname1 = $_REQUEST['apndbankname'];

		if($bankname1 != '')

		{

		$banknamesplit = explode('||',$bankname1);

		$bankcode = $banknamesplit[0];

		$apndbankname = $banknamesplit[1];

		}

		else

		{

		$bankcode = '';

		$apndbankname = '';

		}

		$remarks = $_REQUEST['remarks'];

		$chequenumber = $_REQUEST['chequenumber'];

		$currency1 = $_REQUEST['currency'];

		$currencysp = explode('||', $currency1);

		$currencyname = $currencysp[0];

		$currency = $currencysp[1];

		

		//select * from master_transactionpharmacy where billnumber = '$billnumber' order by auto_number desc limit 0, 1 

		

		$totcount = $_REQUEST['totcount'];

		

		for($i=1;$i<=$totcount;$i++)

		{

			if(isset($_REQUEST['ack'.$i]))

			{

				$billnum=$_REQUEST['billnum'.$i];
				$mrnnos=$_REQUEST['mrnno'.$i];

				if($billnum != "")

				{

					$adjamount=$_REQUEST['adjamount'.$i];

					$appvdfxamount=$_REQUEST['adjamount'.$i];

					$adjamount = $adjamount * $currency;

					//echo $i."<br>";

					$data=$data."&&billnum[]=".@$billnum[$i];

					if($paymentmode != 'WRITEOFF'){

					$query12 = "select * from master_transactionpharmacy where billnumber = '$billnum' and `suppliercode`  = '".$suppliercode."' and transactiontype = 'PURCHASE' and transactionmode <> 'CREDIT' and mrnno='$mrnnos' order by auto_number desc limit 0, 1 ";

					$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

					mysqli_num_rows($exec12);

					$res12 = mysqli_fetch_array($exec12);

					$res12anumber = $res12['auto_number'];
                    $approval_status = $res12['approved_payment'];
 
					$query2 = "UPDATE `master_transactionpharmacy` SET  `remarks`='$remarks', `appvdbank` = '$apndbankname',`appvdcheque` = '$chequenumber',`appvdchequedt` = '$chequedate', `approved_amount` = '$adjamount', bankcode = '$bankcode', paymentvoucherno = '$billnumbercode', appvdfxrate = '$currency', appvdcurrency = '$currencyname', `appvdfxamount` = '$appvdfxamount',`paymentmode` = '$paymentmode' WHERE  `auto_number`  = '".$res12anumber."'";

					$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

					
					$query1 = "UPDATE `master_purchase` SET `approved_payment` = '1' WHERE `master_purchase`.`billnumber`  = '".$billnum."' and `master_purchase`.`suppliercode`  = '".$suppliercode."' and mrnno='$mrnnos'";

					$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

					$query2 = "UPDATE `master_transactionpharmacy` SET `approved_payment` = '1' WHERE `master_transactionpharmacy`.`billnumber`  = '".$billnum."' and `master_transactionpharmacy`.`suppliercode`  = '".$suppliercode."' and mrnno='$mrnnos'";

					$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

					?>

					<script>

					window.open("print_payment1.php?billnumber=<?php echo $billnum; ?>&&suppliercode=<?php echo $suppliercode; ?>&&voucherno=<?php echo $billnumbercode; ?>", "OriginalWindow", 'width=522,height=650,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

					</script>

					<?php

				}

			}

		}		

		}   

		} ?> <script>

		

		//window.open("print_payment_receipt2.php?number=<?php echo $numrow; ?>&&billnum[]=<?php echo $data; ?>","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

		</script>

		<?php 

		}



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



$paynowbillprefix = 'PV-';

$paynowbillprefix1=strlen($paynowbillprefix);



$query2 = "select paymentvoucherno from master_transactionpharmacy where approved_payment = '1' and paymentvoucherno <> '' group by paymentvoucherno";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$pvrows = mysqli_num_rows($exec2);

$billnumber = $res2["paymentvoucherno"];

$billdigit=strlen($billnumber);

if ($pvrows == '1')

{

	$billnumbercode ='PV-'.'1';

	$openingbalance = '0.00';

}

else

{

	$billnumber = $res2["paymentvoucherno"];

	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

	//echo $billnumbercode;

	$billnumbercode = intval($pvrows);

	$billnumbercode = $billnumbercode + 1;



	$maxanum = $billnumbercode;

	

	

	$billnumbercode = 'PV-' .$maxanum;

	$openingbalance = '0.00';

	//echo $companycode;

}	

//echo $billnumbercode;



if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{



	$searchsuppliername = $_POST['searchsuppliername'];

	if ($searchsuppliername != '')

	{

		$arraysuppliername = $searchsuppliername;

		$arraysuppliername = trim($arraysuppliername);

		$arraysuppliercode = $_POST['searchsuppliercode'];

		//	$arraysuppliername = $_POST['searchsuppliername'];

		//$arraysuppliercode = $_POST['searchsuppliercode'];

		

		$query1 = "select * from master_supplier where suppliercode = '$arraysuppliercode'";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res1 = mysqli_fetch_array($exec1);

		$supplieranum = $res1['auto_number'];

		$openingbalance = $res1['openingbalance'];



		$cbsuppliername = $arraysuppliername;

		$suppliername = $arraysuppliername;

		$suppliercode = $arraysuppliercode;

		

	}

	else

	{

		$cbsuppliername = $_REQUEST['cbsuppliername'];

		$suppliername = $_REQUEST['cbsuppliername'];

		$suppliercode = $_REQUEST['searchsuppliercode'];

	}



	//$transactiondatefrom = $_REQUEST['ADate1'];

	//$transactiondateto = $_REQUEST['ADate2'];



}



if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }

if($st == 'success' && $billnumber != '')

{

?>

<script>

window.open("print_payment1.php?billnumber=<?php echo $billnumber; ?>", "OriginalWindow", 'width=522,height=650,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

</script>

<?php

}

//$st = $_REQUEST['st'];

if ($st == 'success')

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

<script language="javascript">



function cbsuppliername1()

{

	document.cbform1.submit();

}

function amountcheck()

{



}

</script>

<!--<script type="text/javascript" src="js/autocomplete_supplier12.js"></script>

<script type="text/javascript" src="js/autosuggest2supplier1.js"></script>-->

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

		

	source:"ajaxsupplieraccount_nm.php",

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

	document.getElementById("submit1").disabled=true;

	if (document.getElementById("paymentmode").value == "")

	{

		alert ("Please Select Payment Mode.");

		document.getElementById("paymentmode").focus();

		document.getElementById("submit1").disabled=false;

		return false;

	}

	/*if (document.getElementById("paymentmode").value == "CHEQUE")

	{

		if(document.getElementById("chequenumber").value == "")

		{

			alert ("If Payment By Cheque, Then Cheque Number Cannot Be Empty.");

			document.getElementById("chequenumber").focus();

			document.getElementById("submit1").disabled=false;

			return false;

		} 

	}	
*/
	if (document.getElementById("apndbankname").value == "")

	{

		alert ("Account Name Cannot Be Empty.");

		document.getElementById("apndbankname").focus();

		document.getElementById("submit1").disabled=false;

		return false;

	}

	if (document.getElementById("remarks").value == "")

	{

		alert ("Remarks Cannot Be Empty.");

		document.getElementById("remarks").focus();

		document.getElementById("submit1").disabled=false;

		return false;

	}

	

	var fRet; 

	fRet = confirm('Are you sure want to save this payment entry?'); 

	//return false;

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

		document.getElementById("submit1").disabled=false;

		return false;

	}

		

	window.scrollTo(0,0);

	document.getElementById("formloader").style.display = "";

	document.body.style.overflow='auto';

	//return false;

	

}



function funcPrintReceipt1()

{

	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

//	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

}



</script>

<script>

function updatebox(varSerialNumber,billamt,totalcount1)

{

var currency1=document.getElementById("currency").value;

var currencysp = currency1.split("||");

var fxrate = currencysp[1];

//alert(fxrate);

document.getElementById("currency").options.length = null;

document.getElementById("currency").options[0] = new Option(currencysp[0], currency1);



var adjamount1;

var grandtotaladjamt2=0;

var varSerialNumber = varSerialNumber;

var totalcount1=document.getElementById("totcount").value;

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

	var totalbillamt=document.getElementById("paymentamount").value;

	totalbillamt=totalbillamt.replace(/,/g,'');

	if(totalbillamt == 0.00)

{

totalbillamt=0;

}

totalbillamt=parseFloat(totalbillamt)+parseFloat(billamt);

		

			//alert(totalbillamt);

totalbillamt = totalbillamt.toFixed(2);

totalbillamt = totalbillamt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

document.getElementById("paymentamount").value = totalbillamt;

document.getElementById("netpayable").value = totalbillamt;

document.getElementById("totaladjamt").value=totalbillamt;

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

document.getElementById("netpayable").value = grandtotaladjamt2.toFixed(2);

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

var totalcount=document.getElementById("totcount").value;

var currency1=document.getElementById("currency").value;

var currencysp = currency1.split("||");

var fxrate = currencysp[1];

//alert(fxrate);

document.getElementById("currency").options.length = null;

document.getElementById("currency").options[0] = new Option(currencysp[0], currency1);

var grandtotaladjamt=0;

var adjamount=document.getElementById("adjamount"+varSerialNumber1+"").value;

var adjamount3=parseFloat(adjamount) * parseFloat(fxrate);

if(adjamount3 < 0)

{

alert("Please enter correct amount");

document.getElementById("paymentamount").value = '0.00';

document.getElementById("totaladjamt").value = '0.00';

document.getElementById("adjamount"+varSerialNumber1+"").value = '0.00';

document.getElementById("balamount"+varSerialNumber1+"").value = '0.00';

return false;

}

if(adjamount3 > billamt1)

{

alert("Please enter correct amount");

document.getElementById("paymentamount").value = '0.00';

document.getElementById("totaladjamt").value = '0.00';

document.getElementById("adjamount"+varSerialNumber1+"").value = '0.00';

document.getElementById("balamount"+varSerialNumber1+"").value = billamt1;

document.getElementById("adjamount"+varSerialNumber1+"").focus();

return false;

}

var balanceamount=parseFloat(billamt1)-parseFloat(adjamount3);

balanceamount = balanceamount.toFixed(2);

balanceamount = balanceamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

document.getElementById("balamount"+varSerialNumber1+"").value=balanceamount;



for(i=1;i<=totalcount;i++)

{

var totaladjamount=document.getElementById("adjamount"+i+"").value;

if(totaladjamount == "")

{

totaladjamount=0;

}

grandtotaladjamt=grandtotaladjamt+parseFloat(totaladjamount);

}

//alert(grandtotaladjamt);

grandtotaladjamt = grandtotaladjamt.toFixed(2);

grandtotaladjamt = grandtotaladjamt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

document.getElementById("paymentamount").value = grandtotaladjamt;

document.getElementById("netpayable").value = grandtotaladjamt;

document.getElementById("totaladjamt").value=grandtotaladjamt;

var tax = document.getElementById("taxanum").value;

if(tax != '')

{

var paymentamount = document.getElementById("paymentamount").value;

<?php

$query1 = "select * from master_tax where status <> 'deleted' order by taxname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res1 = mysqli_fetch_array($exec1))

						{

						$res1taxname = $res1["taxname"];

						$res1taxpercent = $res1["taxpercent"];

						$res1anum = $res1["auto_number"];

						?>

						if(tax == "<?php echo $res1anum; ?>")

						{

						taxpercent = "<?php echo $res1taxpercent; ?>";

						}

						<?php

	}

	

	?>

	

	taxamount = (paymentamount * taxpercent)/100;

	var netpayable = paymentamount - taxamount;

	document.getElementById("taxamount").value = taxamount.toFixed(2);

	document.getElementById("netpayable").value = netpayable.toFixed(2);

}

}



function checkvalid(totcount)

{

var totcount=totcount;



for(j=1;j<=totcount;j++)

{

if(document.getElementById("acknow"+j+"").checked == true)

{

alert("Please deselect invoice");



return false;

}

}

return true;





}



function netpayablecalc()

{

var taxamount;

var taxpercent;

if(document.getElementById("whton").value == "")

{

	alert("Select WHT Condition");

	document.getElementById("taxanum").value = "";

	document.getElementById("whton").focus();

	return false;

}

var paymentamount = document.getElementById("pretax").value;

paymentamount=paymentamount.replace(/,/g,'');

var tax = document.getElementById("taxanum").value;

<?php

$query1 = "select * from master_tax where status <> 'deleted' order by taxname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res1 = mysqli_fetch_array($exec1))

						{

						$res1taxname = $res1["taxname"];

						$res1taxpercent = $res1["taxpercent"];

						$res1anum = $res1["auto_number"];

						?>

						if(tax == "<?php echo $res1anum; ?>")

						{

						taxpercent = "<?php echo $res1taxpercent; ?>";

						}

						<?php

	}

	

	?>

	

	taxamount = (paymentamount * taxpercent)/100;

	var tax16 = document.getElementById("tax16").value;

	tax16=tax16.replace(/,/g,'');

	var netpayable = parseFloat(paymentamount) - parseFloat(taxamount) + parseFloat(tax16);

	document.getElementById("taxamount").value = taxamount.toFixed(2);

	document.getElementById("netpayable").value = netpayable.toFixed(2);

	

}

function balances()

{

	/*var balance = 0;

	var mode = document.getElementById("paymentmode").value;

	if(mode == 'CASH'){

		<?php

		    

			/*$querydcash = "SELECT SUM(cash) AS totalcash FROM paymentmodedebit";

			$execdcash = mysql_query($querydcash) or die(mysql_error());

			$resdcash= mysql_fetch_array($execdcash);

			$debitcash =  $resdcash['totalcash'];

			$queryccash = "SELECT SUM(cash) AS totalccash FROM paymentmodecredit";

			$execccash = mysql_query($queryccash) or die(mysql_error());

			$resccash= mysql_fetch_array($execccash);

			$creditcash =  $resccash['totalccash'];

			$balance=$debitcash-$creditcash*/

		?>

			

			var balance = '<?php echo number_format($balance,2,'.',','); ?>';

			document.getElementById("balamount").style.display='block';

			document.getElementById("balanc").style.display='block';

			document.getElementById("balanc").value = balance;

//			alert(balance);	

			if((document.getElementById("paymentamount").value) >= balance){ alert("The expense amount should be less than of balance amount"); }	

	}

	else{document.getElementById("balanc").value = balance;document.getElementById("balamount").style.display='none';document.getElementById("balanc").style.display='none';}*/

}



function whtcalc()

{

 var whton = document.getElementById("whton").value;

 if(whton == 1)

 {

	 var paymentamount = document.getElementById("paymentamount").value;

	 paymentamount=paymentamount.replace(/,/g,'');

	 var pretax = parseFloat(paymentamount) / parseFloat(1.16);

	 var tax16 = parseFloat(pretax) * parseFloat(0.16);

	 tax16 = tax16.toFixed(2);

	 var tot1 = parseFloat(paymentamount) - parseFloat(tax16);

	 tot1 = tot1.toFixed(2);

	 document.getElementById("tax16").value = tax16;

	 document.getElementById("pretax").value = tot1;

	 document.getElementById("netpayable").value = tot1;

 }

 else if(whton == 2)

 {

	 var paymentamount = document.getElementById("paymentamount").value;

	 paymentamount=paymentamount.replace(/,/g,'');

	 paymentamount=parseFloat(paymentamount);

	 paymentamount=paymentamount.toFixed(2);

	 var pretax = parseFloat(paymentamount) / parseFloat(1.16);

	 var tax16 = parseFloat(pretax) * parseFloat(0.16);

	 tax16 = tax16.toFixed(2);

	 var tot1 = parseFloat(paymentamount) - parseFloat(tax16);

	 tot1 = tot1.toFixed(2);

	 document.getElementById("tax16").value = '0.00';

	 document.getElementById("pretax").value = paymentamount;

	 document.getElementById("netpayable").value = paymentamount;

 }

 //alert(tax16);

}

</script>

<?php



$query765 = "select * from master_financialintegration where field='cashsupplierpaymententry'";

$exec765 = mysqli_query($GLOBALS["___mysqli_ston"], $query765) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res765= mysqli_fetch_array($exec765);



$cashcoa = $res765['code'];





$query766 = "select * from master_financialintegration where field='chequesupplierpaymententry'";

$exec766 = mysqli_query($GLOBALS["___mysqli_ston"], $query766) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res766 = mysqli_fetch_array($exec766);



$chequecoa = $res766['code'];





$query767 = "select * from master_financialintegration where field='mpesasupplierpaymententry'";

$exec767 = mysqli_query($GLOBALS["___mysqli_ston"], $query767) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res767 = mysqli_fetch_array($exec767);



$mpesacoa = $res767['code'];



$query768 = "select * from master_financialintegration where field='cardsupplierpaymententry'";

$exec768 = mysqli_query($GLOBALS["___mysqli_ston"], $query768) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res768 = mysqli_fetch_array($exec768);



$cardcoa = $res768['code'];



$query769 = "select * from master_financialintegration where field='onlinesupplierpaymententry'";

$exec769 = mysqli_query($GLOBALS["___mysqli_ston"], $query769) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res769 = mysqli_fetch_array($exec769);



$onlinecoa = $res769['code'];





?>

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

.formloader { background-color:#FFFFFF; }

#formloader { background-color:#000; }

#formloader1 {

    position: absolute;

    top: 158px;

    left: 487px;

    width: 28%;

    height: 24%;

}

</style>

</head>



<script src="js/datetimepicker_css.js"></script>



<body>

<div align="center" class="formloader" id="formloader" style="display:none;">

<div align="center" class="formloader" id="formloader1" style="display:;">

<p style="text-align:center;"><strong>Saving <br><br> Please Wait...</strong></p>

<img src="images/ajaxloader.gif">

</div>

</div>

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

		

		

              <form name="cbform1" method="post" action="paymentapproval.php">

		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Payment Entry     - Select Supplier </strong></td>

              </tr>

            <tr>

              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

              </tr>

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Supplier </td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">

              </span></td>

              </tr>

            <tr>

             

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

			  <input value="<?php echo $cbsuppliername; ?>" name="cbsuppliername" type="hidden" id="cbsuppliername" readonly onKeyDown="return disableEnterKey()" size="50" ></td>

              </tr>

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" value="<?php echo $suppliercode; ?>" style="border: 1px solid #001E6A; text-transform:uppercase" size="20" /></td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

             

                  <input  type="submit" value="Search" name="Submit" />

				  

                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>

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

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 

            align="left" border="0">

          <tbody>

           <!-- <tr>

              <td width="4%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td width="30%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td width="14%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td width="14%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td width="13%" bgcolor="#ecf0f5" class="bodytext31"><strong>Opening Balance </strong></td>

              <td width="12%" bgcolor="#ecf0f5" class="bodytext31"><div align="right">

                <?php 

			  echo number_format($openingbalance, 2); 

			  ?>

              </div></td>

            </tr>-->

            <!--<tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong> Supplier </strong></td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="left"><strong>By Purchase </strong></div></td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="left"><strong>By Payments </strong></div></td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="left"><strong>By Adjustment </strong></div></td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="left"><strong>By Balance </strong></div></td>

            </tr>-->

			<?php



			if($res2suppliername == '')

			{

			$purchasebalance = 0.00;

			}

			

			?>

          </tbody>

        </table></td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 

            align="left" border="0">

          <tbody>

          

            <?php

			

/*			$dotarray = explode("-", $transactiondateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

*/

			$transactionamount = "0.00";

			$totalpurchase = "0.00";

			$cashamount1 = "0.00";

			$onlineamount1 = "0.00";

			$chequeamount1 = "0.00";

			$cardamount1 = "0.00";
			
			$mpesaamount1 = "0";


			$tdsamount1 = "0.00";

			$writeoffamount1 = "0.00";

			$taxamount1 = "0.00";

			$cashamount2 = "0.00";

			$cardamount2 = "0.00";

			$onlineamount2 = "0.00";
			
			$mpesaamount2 = "0";

			$chequeamount2 = "0.00";

			$tdsamount2 = "0.00";

			$writeoffamount2 = "0.00";

			$taxamount2 = "0.00";

			$totalpayments = "0.00";

			$netpayments = "0.00";

			$balanceamount = "0.00";

			

			

			$query2 = "select * from master_transactionpharmacy where suppliercode = '$suppliercode' and recordstatus = ''  group by suppliercode";// and cstid='$custid' and cstname='$custname'";//  order by transactiondate desc";

			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			while ($res2 = mysqli_fetch_array($exec2))

			{

			$res2anum = $res2['supplieranum'];

			$res2suppliername = $res2['suppliername'];

			if ($supplieranum != 0)

			{

			$query3 = "select * from master_transactionpharmacy where transactiontype = 'PURCHASE RETURN' and transactionmodule = 'PURCHASE RETURN'  and suppliercode = '$suppliercode' and recordstatus = ''";// and cstid='$custid' and cstname='$custname'";

			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

			while ($res3 = mysqli_fetch_array($exec3))

			{

				$transactionamount = $res3['transactionamount'];

				$totalpurchase = $totalpurchase + $transactionamount;

			}

		

			$query3 = "select * from master_transactionpharmacy where transactiontype = 'COLLECTION' and transactionmodule = 'PURCHASE RETURN' and suppliercode = '$suppliercode' and recordstatus = '' ";// and cstid='$custid' and cstname='$custname'";

			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

			while ($res3 = mysqli_fetch_array($exec3))

			{

				$cashamount1 = $res3['cashamount'];

				$onlineamount1 = $res3['onlineamount'];

				$chequeamount1 = $res3['chequeamount'];

				$cardamount1 = $res3['cardamount'];
				
				$mpesaamount1 = $res3['mpesaamount'];


				$tdsamount1 = $res3['tdsamount'];

				$writeoffamount1 = $res3['writeoffamount'];

				$taxamount1 = $res3['taxamount'];

				

				$cashamount2 = $cashamount2 + $cashamount1;

				$cardamount2 = $cardamount2 + $cardamount1;

				$onlineamount2 = $onlineamount2 + $onlineamount1;


				$mpesaamount2 = $mpesaamount2 + $mpesaamount1;

				$chequeamount2 = $chequeamount2 + $chequeamount1;

				$tdsamount2 = $tdsamount2 + $tdsamount1;

				$writeoffamount2 = $writeoffamount2 + $writeoffamount1;

				$taxamount2 = $taxamount2 + $taxamount1;

			}

			

			$totalpayments = $cashamount2 + $chequeamount2 + $onlineamount2 + $cardamount2 + $mpesaamount2 + $taxamount2;

			$netpayments = $totalpayments + $tdsamount2 + $writeoffamount2;

			$balanceamount = $totalpurchase - $netpayments;

			

			//netpayments

			if ($res2suppliername != '')

			{

			

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

              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>

              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2suppliername; ?></div></td>

              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalpurchase, 2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalpayments, 2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($writeoffamount2, 2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($balanceamount, 2,'.',','); ?></div></td>

            </tr>

            <?php

			}

			}

			}

			$purchasereturnbalance = $balanceamount;

			//$purchasebalance;

			$actualbalance = $purchasebalance - $purchasereturnbalance;

			?>

          </tbody>

        </table></td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

	

     

      <tr>

        <td>&nbsp;</td>

      </tr>

	  <tr>

        <td>

<?php

	

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{ 

	$_SESSION['paymententrysession']='pending';

	$searchsuppliername = $_POST['searchsuppliername'];

	if ($searchsuppliername != '')

	{

		$arraysuppliername = $_POST['searchsuppliername'];

		$arraysuppliername = trim($arraysuppliername);

		$arraysuppliercode = $_POST['searchsuppliercode'];

		//$arraysuppliername = $_POST['searchsuppliername'];

		//$arraysuppliername = trim($arraysuppliername);

		//$arraysuppliercode = $arraysupplier[1];

		//$arraysuppliercode = $_POST['searchsuppliercode'];

		$query1 = "select * from master_supplier where suppliercode = '$arraysuppliercode'";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res1 = mysqli_fetch_array($exec1);

		$supplieranum = $res1['auto_number'];

		$openingbalance = $res1['openingbalance'];



		$cbsuppliername = $arraysuppliername;

		$suppliername = $arraysuppliername;

		$suppliercode = $arraysuppliercode;

	}

	else

	{

		$cbsuppliername = $_REQUEST['cbsuppliername'];

		$suppliername = $_REQUEST['cbsuppliername'];

		$suppliercode = $_REQUEST['searchsuppliercode'];

	}

	

?>

		<form name="cbform2" method="post" action="paymentapproval.php" onSubmit="return paymententry1process2()">

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 

            align="left" border="0">

          <tbody>

		   <tr bgcolor="#011E6A">

                    <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Payment  Entry - Details </strong></td>

                    <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->

                    <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">

					<strong> <?php //echo number_format($openingbalance, 2).' + '.number_format($purchasebalance, 2).' - '.number_format($purchasereturnbalance, 2).' = '.number_format($actualbalance + $openingbalance, 2); ?></strong></td>

                  </tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Payment Mode </td>

                    <td align="left" valign="top"  bgcolor="#FFFFFF">

					<select name="paymentmode" id="paymentmode" style="width: 130px;" onChange="balances();">

                        <option value="" selected="selected">SELECT</option>

                        <option value="CHEQUE">CHEQUE</option>

                        <option value="CASH">CASH</option>
						
						<option value="MPESA">MPESA</option>

                        <!--<option value="TDS">TDS</option>-->

                        <option value="ONLINE">ONLINE</option>

                        <option value="WRITEOFF">ADJUSTMENT</option>

                    </select></td>

					<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Account Name </td>

                    <td align="left" valign="top"  bgcolor="#FFFFFF"><!--<input name="bankname" id="bankname" style="border: 1px solid #001E6A" value=""  size="20" />-->

					<select name="apndbankname" id="apndbankname">

					<option value="">Select Account</option>

					<?php 

					$querybankname = "select * from master_bank where bankstatus!='Deleted'";

					$execbankname = mysqli_query($GLOBALS["___mysqli_ston"], $querybankname) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

					while($resbankname = mysqli_fetch_array($execbankname))

					{?>

						<option value="<?php echo $resbankname['bankcode'].'||'.$resbankname['bankname']; ?>"><?php echo $resbankname['bankname']; ?></option>

					<?php

					}

					?>
					
					</select></td>

				  </tr>

				  

                  <tr>

                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Number </td>

                    <td align="left" valign="top"  bgcolor="#FFFFFF">

					<input name="chequenumber" id="chequenumber" style="border: 1px solid #001E6A" value=""  size="20" /></td>

					<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Date </td>

                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo date('Y-m-d'); ?>"  size="20"  readonly="readonly" onKeyDown="return disableEnterKey()"/>

					<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>

				    </td>

                   

                  </tr>

                  <tr>

                    

                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Remarks</td>

                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="remarks" id="remarks" style="border: 1px solid #001E6A" value=""  size="20" />

					<input type="hidden" name="suppliercode" id="suppliercode" value="<?php echo $suppliercode; ?>"></td>

                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Currency</td>

                    <td align="left" valign="top"  bgcolor="#FFFFFF">

					<select name="currency" id="currency" style="width: 130px;">

                       <?php  $query_currency=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT rate,currency,defaultcurr FROM master_currency where recordstatus=''") or die("Error ".mysqli_error($GLOBALS["___mysqli_ston"])); 

								while($exec_currency=mysqli_fetch_array($query_currency)){

									?>

									<option value="<?= $exec_currency['currency'].'||'.$exec_currency['rate'] ?>" <?= ($exec_currency['defaultcurr']=="yes")?"selected='selected'":""; ?> > <?= $exec_currency['currency'] ?></option>

						<?php		}

						

						?>

						

                    </select></td>

				  </tr>

				  </tbody>

             </table> 

			 

			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 

            align="left" border="0">

			<tbody>

            <tr>

              <td colspan="3" bgcolor="#ecf0f5" class="bodytext311"><strong><?php echo $suppliername; ?></strong></td>

              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>

              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>

              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>

			   <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>

              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>

			  <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>

              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>

			  <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>

			  <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
			  <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>

             </tr>

            <tr>

              <td width="5%" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ffffff" class="bodytext311"><strong>No.</strong></td>

				  <td width="6%" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ffffff" class="bodytext311"><strong>Select</strong></td>

              <td width="13%" align="left" valign="center" bordercolor="#f3f3f3"  bgcolor="#ffffff" class="bodytext311"><strong> Supplier Inv No</strong></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ffffff"><div align="left"><strong>Doc No </strong></div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" width="8%" 

                bgcolor="#ffffff"><div align="left"><strong>Bill Date </strong></div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ffffff"><div align="right"><strong>Bill Amt </strong></div></td>

                 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ffffff"><div align="right"><strong>WHT VAT</strong></div></td>


				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong>WHT TAX</strong></div></td>

<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Net.Amt</strong></div></td>

				 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ffffff"><div align="right"><strong>Return Amt</strong></div></td>

              <td width="8%" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ffffff" class="bodytext311"><div align="right"><strong>Pending</strong></div></td>

				  <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ffffff"><div align="right"><strong> Adj Amt</strong></div></td>

              <td width="8%" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong> Bal Amt</strong></div></td>

            </tr>

            <?php

			$colorloopcount='';

			$totalbalance = '';

			$sno = 0;

			$cashamount21 = '';

            $mpesaamount21='';
			
			 $mpesaamount22='';
			
			$cardamount21 = '';

			$onlineamount21 = '';

			$chequeamount21 = '';

			$tdsamount21 = '';

			$writeoffamount21 = '';

			$taxamount21 = '';

			$totalnumbr='';

			$totalnumb=0;

			$totalreturn = 0;

			$totalapproved = 0;

			

			

			$dotarray = explode("-", $transactiondateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			$totalpurchase1=0;

			$ss=0;

			if (isset($_REQUEST["showbilltype"])) { $showbilltype = $_REQUEST["showbilltype"]; } else { $showbilltype = ""; }

			if ($showbilltype == 'All Bills')

			{

				$showbilltype = '';

			}			

	

			 //echo $number=mysql_num_rows($exec25);

			$query2 = "select * from master_purchase where suppliercode = '$suppliercode' and recordstatus <> 'deleted' and companyanum = '$companyanum' group by billnumber,mrnno";

			//$query2 = "select * from master_transaction where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and transactionmodule = 'SALES' and billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''";

			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rowcount2 = mysqli_num_rows($exec2);

			$number=mysqli_num_rows($exec2);

			while ($res2 = mysqli_fetch_array($exec2))

			{

				$suppliername = $res2['suppliername'];

				$suppliercode = $res2['suppliercode'];

				$anum=$res2['auto_number'];

				$billnumber = $res2['billnumber'];

				$supplierbillnumber=$res2['supplierbillnumber'];

				$billnumberprefix = $res2['billnumberprefix'];

				$billnumberpostfix = $res2['billnumberpostfix'];

				$billdate = $res2['billdate'];

				$billtotalamount = $res2['totalamount'];

				$billtotalfxamount = $res2['totalfxamount'];

				$mrnno = $res2['mrnno'];

				

				$query44 = "select sum(wh_tax_value) as wh_tax_value,sum(wh_vat_value) as wh_vat_value,ponumber from purchase_details where billnumber='$billnumber' and mrnno='$mrnno'";

				$exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				$res44 = mysqli_fetch_array($exec44);

				$wh_tax_value =$res44['wh_tax_value'];
			    $wh_vat_value =$res44['wh_vat_value'];
				$ponumber = $res44['ponumber'];

				$subponumber = substr($ponumber,0,1);

				if($subponumber == 'M')

				{

				$query45 = "select * from materialreceiptnote_details where billnumber='$ponumber'";

				$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				$res45 = mysqli_fetch_array($exec45);

				$ponumber = $res45['ponumber'];

				}

				$totaladjust=0;
                
				 $query3 = "select * from master_transactionpharmacy where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and billnumber = '$billnumber' and  recordstatus = 'allocated' ";

				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

				$num=mysqli_num_rows($exec3);

				while ($res3 = mysqli_fetch_array($exec3))

				{

					//echo $res3['auto_number'];

				    $cashamount1 = $res3['cashamount'];

					$onlineamount1 = $res3['onlineamount'];

					$chequeamount1 = $res3['chequeamount'];

					$cardamount1 = $res3['cardamount'];

					$tdsamount1 = $res3['tdsamount'];
					
					$mpesaamount21 = $res3['mpesaamount'];


					$writeoffamount1 = $res3['writeoffamount'];

					$taxamount1 = $res3['taxamount'];

					

					$cashamount21 = $cashamount21 + $cashamount1;

					$cardamount21 = $cardamount21 + $cardamount1;
					
					$mpesaamount22 = $mpesaamount22 + $mpesaamount21;


					$onlineamount21 = $onlineamount21 + $onlineamount1;

					$chequeamount21 = $chequeamount21 + $chequeamount1;

					$tdsamount21 = $tdsamount21 + $tdsamount1;

					$writeoffamount21 = $writeoffamount21 + $writeoffamount1;

					$taxamount21 = $taxamount21 + $taxamount1;
                    
					if(strpos($res3['docno'], 'SDBT-') !== false)						
						 $totaladjust = $totaladjust + $res3['transactionamount'];

					

				}
				$billtotalfxamount = $billtotalfxamount-$totaladjust;

				$billtotalamount = $billtotalamount-$totaladjust;

				//$billtotalfxamount = $billtotalfxamount-$totaladjust;

				

				$totalapproved = 0;

				$query342 = "select * from master_transactionpharmacy where transactiontype = 'PURCHASE' and transactionmode <> 'CREDIT' and billnumber = '$billnumber' and companyanum='$companyanum' and  approved_payment = '1' and mrnno='$mrnno'";

				$exec342 = mysqli_query($GLOBALS["___mysqli_ston"], $query342) or die ("Error in Query342".mysqli_error($GLOBALS["___mysqli_ston"]));

				$num=mysqli_num_rows($exec342);

				while ($res342 = mysqli_fetch_array($exec342))

				{

					$approvedamt = $res342['approved_amount'];

					//$totalapproved = $totalapproved + $approvedamt;

				}

			

			     $totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21 + $mpesaamount22 + $taxamount21;

				$netpayment = $totalpayment + $tdsamount21 + $writeoffamount21 + $totalapproved;

				

				$totalreturn = 0;

				$query38 = "select totalamount from purchasereturn_details where grnbillnumber = '$mrnno'";

				$exec38 = mysqli_query($GLOBALS["___mysqli_ston"], $query38) or die ("Error in Query38".mysqli_error($GLOBALS["___mysqli_ston"]));

				$num=mysqli_num_rows($exec38);

				while ($res38 = mysqli_fetch_array($exec38))

				{

					$return = $res38['totalamount'];

					$totalreturn = $totalreturn + $return;

				}

				
                //if($billtotalamount>0)
				   $balanceamount = $billtotalamount - $netpayment - $totalreturn;
				//else
				//	$balanceamount =0;

				//echo $billtotalamount.' -'.$netpayment.' - '.$totalreturn;

				$billtotalamount = number_format($billtotalamount, 2, '.', '');

				$netpayment = number_format($netpayment, 2, '.', '');

				$balanceamount = number_format($balanceamount, 2, '.', '');

				

				$billstatus = $billtotalamount.'||'.$netpayment.'||'.$balanceamount;



			//echo $balanceamount;

			$billdate = substr($billdate, 0, 10);

			$date1 = $billdate;



			$dotarray = explode("-", $billdate);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$billdate = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));



			$billtotalamount = number_format($billtotalamount, 2, '.', '');

			$netpayment = number_format($netpayment, 2, '.', '');

			$balanceamount = number_format($balanceamount, 2, '.', '');

			

			$date1 = $date1;

			$date2 = date("Y-m-d");  

			$diff = abs(strtotime($date2) - strtotime($date1));  

			$days = floor($diff / (60*60*24));  

			$daysafterbilldate = $days;

			

			$query3 = "select * from master_transactionpharmacy where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = '' and mrnno='$mrnno'   order by auto_number desc";

			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res3 = mysqli_fetch_array($exec3);

			 $numb=mysqli_num_rows($exec3);

			 $totalnumb=$totalnumb+$numb;

		//	$docno1 = $res3['docno']; 

			$lastpaymentdate = $res3['transactiondate'];

			

			$lastpaymentdate = substr($lastpaymentdate, 0, 10);

			

			if ($lastpaymentdate != '')

			{

				$date1 = $lastpaymentdate;

				$date2 = date("Y-m-d");  

				$diff = abs(strtotime($date2) - strtotime($date1));  

				$days = floor($diff / (60*60*24));  

				$daysafterpaymentdate = $days;

				

				$dotarray = explode("-", $lastpaymentdate);

				$dotyear = $dotarray[0];

				$dotmonth = $dotarray[1];

				$dotday = $dotarray[2];

				$lastpaymentdate = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));

				

			}

			else

			{

				$daysafterpaymentdate = '';

				$lastpaymentdate = '';

			}			



			//echo $balanceamount;

			if ($balanceamount != '0.00')

			{



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



			//if ($balanceamount != 0.00)

			//{

			

			$query12 = "select * from master_transactionpharmacy where billnumber = '$billnumber' and mrnno='$mrnno' order by auto_number desc limit 0, 1 ";

			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

			mysqli_num_rows($exec12);

			$res12 = mysqli_fetch_array($exec12);

			$appvdbank = $res12['appvdbank'];

			$appvdcheque = $res12['appvdcheque'];

			$appvdchequedt = $res12['appvdchequedt'];

			$balanceamount =$balanceamount-($wh_vat_value+$wh_tax_value);
			if($balanceamount>0){
			?>

             <tr <?php echo $colorcode; ?>>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $sno = $sno + 1; ?><?php $ss = $ss + 1; ?></td>

			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">

			  <input type="checkbox" name="ack<?php echo $sno; ?>" id="acknow<?php echo $sno; ?>" value="<?php echo $billnumber; ?>" onClick="updatebox('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>

              <td class="bodytext311"  valign="center" bordercolor="#f3f3f3" align="left"><div class="bodytext311"><?php echo $supplierbillnumber; ?> , <?php //echo $ponumber; 
              $fetch_PI='';
              $query_fetch_PI = "SELECT purchaseindentdocno from purchaseorder_details where billnumber='$ponumber' group by billnumber";
					  $exec_fetch_PI = mysqli_query($GLOBALS["___mysqli_ston"], $query_fetch_PI) or die ("Error in Query_fetch_PI".mysqli_error($GLOBALS["___mysqli_ston"]));
					  while($res_fetch_PI = mysqli_fetch_array($exec_fetch_PI)){
					  		  $fetch_PI = $res_fetch_PI['purchaseindentdocno'];
					  }
					  $query_lpo_type = "SELECT lpo_type from purchase_indent where docno='$fetch_PI' group by docno ";
					  $exec_lpo_type = mysqli_query($GLOBALS["___mysqli_ston"], $query_lpo_type) or die ("Error in Query_lpo_type".mysqli_error($GLOBALS["___mysqli_ston"]));
					  $res_lpo_type = mysqli_fetch_array($exec_lpo_type);
					  		  $lpo_type = $res_lpo_type['lpo_type'];
					  		  if($lpo_type=='CREDIT'){
					  		  	echo "<b style='color:red;'> ".trim($ponumber)."</b>";
					  		  }elseif($lpo_type=='CASH'){
					  		  	echo "<b style='color:green;'> ".trim($ponumber)."</b>";
					  		  }else{
					  		  	echo "<b style='color:indigo;'> ".trim($ponumber)."</b>";
					  		  }




              ?>,<?php echo $mrnno;?></div></td>

			  <input type="hidden" name="supplierbillnumber<?php echo $sno; ?>" value="<?php echo $supplierbillnumber; ?>">

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billnumberprefix.$billnumber.$billnumberpostfix; ?></div></td>

              <input type="hidden" name="billnum<?php echo $sno; ?>" value="<?php echo $billnumber; ?>">
			  <input type="hidden" name="mrnno<?php echo $sno; ?>" value="<?php echo $mrnno; ?>">

			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billdate; ?></div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">

                <?php if ($billtotalamount != '0.00') echo number_format($billtotalamount, 2,'.',','); //echo number_format($billtotalamount, 2); ?>

              </div></td><input type="hidden" name="billamount" id="bill" value="<?php if ($billtotalamount != '0.00') echo $billtotalamount; ?>">


			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
               <?php echo number_format($wh_vat_value, 2,'.',','); ?>
              </div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">

               <?php echo number_format($wh_tax_value, 2,'.',','); ?>
              </div></td>

			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
               <?php echo number_format($billtotalamount, 2,'.',','); 
			   
			   ?>
              </div></td>
			  
			  <input type="hidden" name="billfxamount" id="billfx" value="<?php if ($billtotalfxamount != '0.00') echo $billtotalfxamount; ?>">

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">

                <?php if ($totalreturn != '0') echo number_format($totalreturn,2,'.',','); //echo number_format($balanceamount, 2); ?>

              </div></td>

			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">

                <?php if ($balanceamount != '0.00') echo number_format($balanceamount,2,'.',','); //echo number_format($balanceamount, 2); ?>

              </div></td>

			      <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right"><input class="bali" type="text" name="adjamount<?php echo $sno; ?>" id="adjamount<?php echo $sno; ?>" size="7"  onClick="checkboxcheck('<?php echo $sno; ?>')" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>

            <td class="bodytext311" valign="center" bordercolor="#f3f3f3"><input type="text" class="bal" name="balamount<?php echo $sno; ?>" id="balamount<?php echo $sno; ?>" value="" size="7" readonly></td>

            </tr>

            <?php

				$totalbalance = $totalbalance + $balanceamount;
			   }

				}

				

				$cashamount21 = '0.00';

				$cardamount21 = '0.00';

				$onlineamount21 = '0.00';

				$chequeamount21 = '0.00';

				$tdsamount21 = '0.00';
				
								$mpesaamount22 = '0.00';

								$mpesaamount21 = '0.00';

				$writeoffamount21 = '0.00';

				$taxamount21 = '0.00';

				$totalapproved = 0;



				$totalpayment = '0.00';

				$netpayment = '0.00';

				$balanceamount = '0.00';

				

				$billtotalamount = '0.00';

				$netpayment = '0.00';

				$balanceamount = '0.00';

				

				$billstatus = '0.00';

			}

			}

			

			if ($cbfrmflag1 == 'cbfrmflag1')

			{ 

			?>

<style type="text/css">
	.box{
	width:8px;
	height:8px;
	color:transparent;
}
 
.red{
	background:red;
}
.green{
	background:green;
}
.indigo{
	background:indigo;
}
</style>

			<tr>

              <td class="bodytext311" colspan="4" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ecf0f5">
              	<span class="box red">aa</span>Credit&nbsp;&nbsp;&nbsp;
					<span class="box green">aa</span>Cash&nbsp;&nbsp;&nbsp;
					<span class="box indigo">aa</span>Old.
              </td>

                 <!-- <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong>

                <?php //echo number_format($totalpurchaseamount, 2); ?>

              </strong></div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong>

                <?php //echo number_format($netpaymentamount, 2); ?>

              </strong></div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td> -->

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong>

                <?php //echo number_format($netpaymentamount, 2); ?>

              </strong></div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong><?php if ($totalbalance != '') echo number_format($totalbalance, 2, '.', ','); ?></strong></div></td>

             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">

				<input type="hidden" name="totcount" id="totcount" value="<?php echo $sno; ?>">

				<input type="hidden" name="paymentamount" id="paymentamount">

				<input type="hidden" name="netpayable" id="netpayable">

				<input type="hidden" name="taxanum" id="taxanum">

				<input type="text" name="totaladjamt" id="totaladjamt" size="7" class="bal"></td>

             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

			</tr>

			<tr>

              <td colspan="2" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">

			  <input type="hidden" name="frmflag2" id="frmflag2" value="frmflag2">

			  <input type="submit" name="submit1" id="submit1" value="Submit"></td>

				<td colspan="8" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">&nbsp;</td>

			</tr>

			<?php

			}

			?>	

			 </tbody>

        </table>	

		</form>

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

    </table>

  </table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>




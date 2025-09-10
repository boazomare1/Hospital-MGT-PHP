<?php
error_reporting(0);
session_start();

include ("includes/loginverify.php"); 

include ("db/db_connect.php");



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
		$query3 = "select * from master_company where companystatus = 'Active'";

			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res3 = mysqli_fetch_array($exec3);

			$paynowbillprefix = 'DP-';

			$paynowbillprefix1=strlen($paynowbillprefix);

				$query2 = "select * from master_transactiondoctor where transactiontype='PAYMENT' and docno like 'DP-%' order by auto_number desc limit 0, 1";

			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res2 = mysqli_fetch_array($exec2);

			$billnumber = $res2["docno"];

			$billdigit=strlen($billnumber);

			if ($billnumber == '')

			{

				$billnumbercode ='DP-'.'1';

				$openingbalance = '0.00';

			}

			else

			{

				$billnumber = $res2["docno"];

				$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

				//echo $billnumbercode;

				$billnumbercode = intval($billnumbercode);

				$billnumbercode = $billnumbercode + 1;

			

				$maxanum = $billnumbercode;

				

				

				$billnumbercode = 'DP-' .$maxanum;

				$openingbalance = '0.00';

				//echo $companycode;

			}





if($username_auto_number!=""){

	$billnumbercode.="-".$username_auto_number;

}
		$ipaddress = $ipaddress;

			$updatedate = $updatedatetime;

			$transactiondate = $updatedatetime;
			$transactionmodule = 'PAYMENT';

			$doctorcode = $_REQUEST['doctorcode'];
				$transactiontype = 'PAYMENT';

				$transactionmode = 'CASH';

				//$particulars = 'BY CASH '.$billnumberprefix.$billnumber.'';	

				$particulars = 'BY ADJUST';	

				$debit_reference_no = $_POST['documentnumber'];
				

				//$cashamount = $paymentamount;

				//include ("transactioninsert1.php");

				

				if(!isset($_POST['serialno']))

				{	$querychk1 = "select visitcode from master_transactiondoctor where visitcode = '$visitcode' and transactionamount = '$adjamount' and billnumber = '$billnum' and billautonumber = '$billautonumber' and transactiondate = '$transactiondate'";

							$execchk1 = mysqli_query($GLOBALS["___mysqli_ston"], $querychk1) or die ("Error in querychk1".mysqli_error($GLOBALS["___mysqli_ston"]));

							$numchk = mysqli_num_rows($execchk1);

							if($numchk == 0)

							{

					$query9 = "insert into master_transactiondoctor (transactiondate, particulars, 

					transactionmode, transactiontype, transactionamount, cashamount,taxamount,

					billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 

					transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,doctorcode,username,locationcode,bankname, bankcode,debit_reference_no) 

					values ('$transactiondate', 'BY CASH', 

					'$transactionmode', '$transactiontype', '$paymentamount', '$paymentamount', '$taxamount', 

					'',  '', '$ipaddress', '$updatedate', '0.00', '$companyanum', '$companyname', '$remarks', 

					'$transactionmodule','','','','','$searchsuppliername1','','$billnumbercode','$searchsuppliercode1','$username','$locationcode','$bankname','$bankcode','$debit_reference_no')";

					$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query91".mysqli_error($GLOBALS["___mysqli_ston"]));

					

					$query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,cash,cashcoa,source,transactionamount)values('$billnumbercode','$transactiondate','$ipaddress','$username','$netpayable','$cashcoa','doctorpaymententry','$netpayable')";

					$exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

							}

				}

				else

				{

					

					foreach($_POST['serialno'] as $key => $value)

					{

						//echo count($_POST['billnum']);

						$billnum=$_POST['billnum'][$key];

						$name=$_POST['name'][$key];

						$accountname=$_POST['accountname'][$key];

						$patientcode=$_POST['patientcode'][$key];

						$visitcode=$_POST['visitcode'][$key];

						$doctorname=$_POST['doctorname'][$key];

						$serialno=$_POST['serialno'][$key];

						//echo $doctorname;

						$balamount=$_POST['balamount'][$key];

						$billautonumber=$_POST['billautonumber'][$key];

						//echo $balamount;

						if($balamount == 0.00)

						{

							$billstatus='paid';

						}

						else

						{

							$billstatus='unpaid';

						}

						//echo $billstatus;

						$adjamount=$_POST['adjamount'][$key];

						

						

						

						$taxamount=$adjamount * $res1taxpercent/100;

						$netpayable=$adjamount-$taxamount;

						foreach($_POST['ack'] as $check)

						{

						$acknow=$check;

						if($acknow==$serialno)

						{

							$querychk1 = "select visitcode from master_transactiondoctor where visitcode = '$visitcode' and transactionamount = '$adjamount' and billnumber = '$billnum' and billautonumber = '$billautonumber' and transactiondate = '$transactiondate'";

							$execchk1 = mysqli_query($GLOBALS["___mysqli_ston"], $querychk1) or die ("Error in querychk1".mysqli_error($GLOBALS["___mysqli_ston"]));

							$numchk = mysqli_num_rows($execchk1);

							if($numchk == 0)

							{

								/*$query87="update billing_paylater set doctorstatus='$billstatus' where billno='$billnum'";

								$exec87=mysql_query($query87);

								$query88="update billing_paynow set doctorstatus='$billstatus' where billno='$billnum'";

								$exec88=mysql_query($query88);

								$query90="update billing_ipprivatedoctor set doctorstatus='$billstatus' where docno='$billnum' and description='$doctorname' and auto_number = '$billautonumber'";

								$exec90=mysql_query($query90);*/

								

								

								$query9 = "insert into master_transactiondoctor (transactiondate, particulars, 

								transactionmode, transactiontype, transactionamount, cashamount,taxamount,

								billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 

								transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,doctorcode,billautonumber,username,bankcode,bankname,debit_reference_no) 

								values ('$transactiondate', '$particulars', 

								'$transactionmode', '$transactiontype', '$adjamount', '$adjamount', '$taxamount', 

								'$billnum',  '$billanum', '$ipaddress', '$updatedate', '$balamount', '$companyanum', '$companyname', '$remarks', 

								'$transactionmodule','$name','$patientcode','$visitcode','$accountname','$doctorname','$billstatus','$billnumbercode','$doctorcode','$billautonumber','$username','$bankcode','$bankname','$debit_reference_no')";

								$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query92".mysqli_error($GLOBALS["___mysqli_ston"]));

								

								$query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,cash,cashcoa,source,transactionamount)values('$billnumbercode','$transactiondate','$ipaddress','$username','$adjamount','$cashcoa','doctorpaymententry','$adjamount')";

								$exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

							}

						

						}	

					}

				}

			}

			


		// if (isset($_REQUEST['billnum'])){$numrow = (sizeof($_REQUEST["billnum"]))?sizeof($_REQUEST["billnum"]):0;} else {$numrow=0;}

		

		 ?>  
		<?php 

		}


		// ///////////////////////////////////////
		/*if (isset($_POST['deallocate']))
		{
			$count_dis = $_REQUEST['count_dis'];
			for($i=1;$i<=$count_dis;$i++)
		{
			if(isset($_REQUEST['ack'.$i]))
			{
					 $anums=$_REQUEST['anums'.$i];
					 $query12 = "UPDATE `master_transactionpharmacy` SET `recordstatus`='deallocated' where  auto_number='$anums'";
					$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
					

					?>

					<?php

				 

			}

		}		

		}*/   
			// ///////////////////////////////////////
		 ?>  
<?php

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
if (isset($_REQUEST["document"])) { $document = $_REQUEST["document"]; } else { $document = ""; }
if (isset($_REQUEST["suppliername"])) { $suppliername = $_REQUEST["suppliername"]; } else { $suppliername = ""; }
if (isset($_REQUEST["suppliercode"])) { $suppliercode = $_REQUEST["suppliercode"]; } else { $suppliercode = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];

if ($document)

{



	$searchsuppliername = $suppliername;

	if ($searchsuppliername != '')

	{

		$arraysuppliername = $searchsuppliername;

		$arraysuppliername = trim($arraysuppliername);

		$arraysuppliercode = $suppliercode;

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

		$cbsuppliername = '';

		$suppliername = '';

		$suppliercode = $_REQUEST['suppliercode'];

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

 
// function loadamount() {
//             alert('ok');
//             var bal=$(#balance_amount).val();
//             $(#move_pendingamount).val(bal);
//         }
// window.onload = loadamount();

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

	if (document.getElementById("paymentmode").value == "CHEQUE")

	{

		if(document.getElementById("chequenumber").value == "")

		{

			alert ("If Payment By Cheque, Then Cheque Number Cannot Be Empty.");

			document.getElementById("chequenumber").focus();

			document.getElementById("submit1").disabled=false;

			return false;

		} 

	}	

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

function check(){

	// var ttamount = document.getElementById("totaladjamt").value;
	// if(ttamount >= 0){
	// 	document.getElementById("submit1").disabled = false;
	// }else{
	// 	document.getElementById("submit1").disabled = true;
	// }

	var ttamount = document.getElementById("cumtotal").innerHTML;
	if(ttamount > 0 ){
		// document.getElementById("submit112").disabled = false;
		document.getElementById("cumtotal").style.color="black";
		return true;
	}
	if(ttamount == '0.00' ){
		// document.getElementById("submit112").disabled = false;
		document.getElementById("cumtotal").style.color="black";
		return true;
	}
	
	if(ttamount < 0)
	{
		// document.getElementById("submit112").disabled = true;
		alert('Amount Exceded! Please enter correct amount');
		document.getElementById("cumtotal").style.color="red";
		return false;
	}
}

function updatebox(varSerialNumber,billamt,totalcount1,viewtotal){

var fxrate = 1.00;
var j;
var adjamount1;
var grandtotaladjamt2=0;
var varSerialNumber = varSerialNumber;
var totalcount1=document.getElementById("totcount").value;
var billamt = billamt;
var viewPendingtotal = viewtotal;
var textbox = document.getElementById("adjamount"+varSerialNumber+"");
    textbox.value = "";
	if(document.getElementById("acknow"+varSerialNumber+"").checked == true)
	{
		console.log('in checked');
	    if(document.getElementById("acknow"+varSerialNumber+"").checked) {
	        // textbox.value = billamt;
	        textbox.focus();
	    }
	    	var balanceamt=billamt-billamt;
			// document.getElementById("balamount"+varSerialNumber+"").value=balanceamt.toFixed(2);
			totalbillamt=totalbillamt.replace(/,/g,'');

				if(totalbillamt == 0.00) {
				totalbillamt=0;
				}

		totalbillamt=parseFloat(totalbillamt)+parseFloat(0);
		// totalbillamt1=parseFloat(viewPendingtotal)-parseFloat(totalbillamt);
					alert(totalbillamt);
		totalbillamt = totalbillamt.toFixed(2);
		totalbillamt = totalbillamt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
		document.getElementById("balamount"+varSerialNumber+"").value=totalbillamt;
		document.getElementById("totaladjamt").value=totalbillamt;
		document.getElementById("cumtotal").innerHTML=totalbillamt;
	}else {
	// alert(totalcount1);
	// var a = document.getElementById("acknow"+varSerialNumber+""); 
	for(j=1;j<=totalcount1;j++)
	{
	var totaladjamount2=document.getElementById("adjamount"+j+"").value;
		if(totaladjamount2 == "")
		{
		totaladjamount2=0;
		}
		// var b = j-'1';
		// var a = document.getElementById("balamount"+b+"").value;
		// if(totaladjamount2!=0){ document.getElementById("balamount"+j+"").value=totaladjamount2; }
		
	grandtotaladjamt2=grandtotaladjamt2+parseFloat(totaladjamount2);
	}
	// alert(grandtotaladjamt);
	var grandtotaladjamt2_pen = viewPendingtotal-grandtotaladjamt2;
	document.getElementById("balamount"+varSerialNumber+"").value='0.00';
	document.getElementById("paymentamount").value = grandtotaladjamt2.toFixed(2);
	document.getElementById("netpayable").value = grandtotaladjamt2.toFixed(2);
	document.getElementById("totaladjamt").value=grandtotaladjamt2.toFixed(2);
	document.getElementById("cumtotal").innerHTML=grandtotaladjamt2_pen.toFixed(2);

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

function balancecalc(varSerialNumber1,billamt1,totalcount,pending)
{

var varSerialNumber1 = varSerialNumber1;
var filter = filter;
var billamt1 = billamt1;
var pending=pending;
var pending=parseFloat(pending);
var totalcount=document.getElementById("totcount").value;

console.log('@'+totalcount);

var fxrate = 1.00;
//alert(fxrate);

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
	document.getElementById("cumtotal").innerHTML='';
	return false;
	}
	if(adjamount3 > pending)
	{
	alert("Amount Exceded! Please enter correct amount");
	document.getElementById("paymentamount").value = '0.00';
	document.getElementById("totaladjamt").value = '0.00';
	document.getElementById("adjamount"+varSerialNumber1+"").value = '0.00';
	document.getElementById("balamount"+varSerialNumber1+"").value = '';
	document.getElementById("adjamount"+varSerialNumber1+"").focus();
	document.getElementById("cumtotal").innerHTML='';
	return false;
	}


var balanceamount=parseFloat(adjamount3);
// var balanceamount=pending-parseFloat(adjamount3);

// var balanceamount=parseFloat(billamt1)-parseFloat(adjamount3);
balanceamount = balanceamount.toFixed(2);
balanceamount = balanceamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
// document.getElementById("balamount"+varSerialNumber1+"").value=balanceamount;
// document.getElementById("balamount"+varSerialNumber+"").value=totalbillamt;

for(i=1;i<=totalcount;i++)
{
var totaladjamount=document.getElementById("adjamount"+i).value;
	if(totaladjamount == "")
	{
	totaladjamount=0;
	}
grandtotaladjamt=grandtotaladjamt+parseFloat(totaladjamount);
}

//alert(grandtotaladjamt);
document.getElementById("totaladjamt").value=grandtotaladjamt;

grandtotaladjamt1=grandtotaladjamt;
grandtotaladjamt_pen=pending-grandtotaladjamt;

grandtotaladjamt1 = grandtotaladjamt1.toFixed(2);
grandtotaladjamt1 = grandtotaladjamt1.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
console.log(grandtotaladjamt_pen);
grandtotaladjamt_pen = grandtotaladjamt_pen.toFixed(2);
grandtotaladjamt_pen = grandtotaladjamt_pen.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
document.getElementById("cumtotal").innerHTML=grandtotaladjamt_pen;



document.getElementById("balamount"+varSerialNumber1+"").value = grandtotaladjamt1;
document.getElementById("paymentamount").value = grandtotaladjamt;
document.getElementById("netpayable").value = grandtotaladjamt;
//document.getElementById("totaladjamt").value=grandtotaladjamt1;


var ttamount = document.getElementById("cumtotal").innerHTML;
// alert(ttamount);
	if(ttamount > 0 ){
		// document.getElementById("submit112").disabled = false;
		document.getElementById("cumtotal").style.color="black";
	}
	if(ttamount == '0.00' ){
		// document.getElementById("submit112").disabled = false;
		document.getElementById("cumtotal").style.color="black";
	}
	
	if(ttamount < 0)
	{
		// document.getElementById("submit112").disabled = true;
		document.getElementById("cumtotal").style.color="red";
	alert("Amount Exceded! Please enter correct amount");
	document.getElementById("adjamount"+varSerialNumber1+"").value = '0.00';
	document.getElementById("balamount"+varSerialNumber1+"").value = '';
	document.getElementById("adjamount"+varSerialNumber1+"").focus();
	// return false;
	}

// 	var a =parseFloat(document.getElementById("adjamount"+varSerialNumber1+"").value);
// 		a = a.toFixed(2);
// 		a = a.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
// // 

// if(grandtotaladjamt1>=0){
// document.getElementById("submit1").disabled = false;
// 	}else{
// 		document.getElementById("submit1").disabled = true;
// 	}

// var tax = document.getElementById("taxanum").value;

// return check();

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



<body >

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

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 

            align="left" border="0">

          <tbody>

            

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

			$tdsamount1 = "0.00";

			$writeoffamount1 = "0.00";

			$taxamount1 = "0.00";

			$cashamount2 = "0.00";

			$cardamount2 = "0.00";

			$onlineamount2 = "0.00";

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

				$tdsamount1 = $res3['tdsamount'];

				$writeoffamount1 = $res3['writeoffamount'];

				$taxamount1 = $res3['taxamount'];

				

				$cashamount2 = $cashamount2 + $cashamount1;

				$cardamount2 = $cardamount2 + $cardamount1;

				$onlineamount2 = $onlineamount2 + $onlineamount1;

				$chequeamount2 = $chequeamount2 + $chequeamount1;

				$tdsamount2 = $tdsamount2 + $tdsamount1;

				$writeoffamount2 = $writeoffamount2 + $writeoffamount1;

				$taxamount2 = $taxamount2 + $taxamount1;

			}

			

			$totalpayments = $cashamount2 + $chequeamount2 + $onlineamount2 + $cardamount2 + $taxamount2;

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

      <?php

	

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if (isset($_REQUEST["document"])) { $document = $_REQUEST["document"]; } else { $document = ""; }
if (isset($_REQUEST["suppliercode"])) { $suppliercode = $_REQUEST["suppliercode"]; } else { $suppliercode = ""; }
if (isset($_REQUEST["suppliername"])) { $suppliername = $_REQUEST["suppliername"]; } else { $suppliername = ""; }
// if (isset($_REQUEST["ald"])) { $allocationdate1 = $_REQUEST["ald"]; } else { $allocationdate1 = ""; }
// if (isset($_REQUEST["billamount"])) { $billamount_url = $_REQUEST["billamount"]; } else { $billamount_url = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];

if ($document)

{ 

	$_SESSION['paymententrysession']='pending';

	$searchsuppliername = $suppliername;

	if ($suppliercode != '')

	{

		$arraysuppliername = $suppliername;

		$arraysuppliername = trim($arraysuppliername);

		// $arraysuppliercode = $_POST['searchsuppliercode'];
		$arraysuppliercode = $suppliercode;

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

	$query2 = "select * from master_purchase where suppliercode = '$suppliercode' and recordstatus <> 'deleted' and billnumber = '$document' group by billnumber";

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

				 $billtotalamount_forview = $res2['totalamount'];

				$billtotalfxamount = $res2['totalfxamount'];

				$mrnno = $res2['mrnno'];
			}

	

?>
<form name="cbform2" method="post" action="" onSubmit="return paymententry1process2()">
      <tr>
      	<td>
      	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 

            align="left" border="0">

          <tbody>

		   		<tr bgcolor="#011E6A">

                    <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Doctor Account Activity - Details </strong></td> <td bgcolor="#ecf0f5" class="bodytext3" colspan="2"> </td>

                  </tr>
                  <?php
                  	$query5 = "SELECT * from supplier_debit_transactions where supplier_id = '".$_GET['suppliercode']."' and approve_id='$document'";
		  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($res5 = mysqli_fetch_array($exec5)){
		  	$res5docnumber = $res5['approve_id'];
		  	$res5transactionamount = $res5['total_amount'];
		  	$ref_no = $res5['ref_no'];
		  	 $created_at = $res5['created_at'];
		  	 $timestamp = strtotime($created_at);

			$child1 = date('Y-m-d', $timestamp); // d.m.YYYY
			$child2 = date('H:i', $timestamp); // HH:ss
			$billdate = substr($child1, 0, 10);
			$date1 = $billdate;

			$dotarray = explode("-", $billdate);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$billdate = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));
		  }
		  
		  $query122 = "SELECT * FROM `master_accountname` WHERE `id` = '".$_GET['suppliercode']."'";
		  $exec122 = mysqli_query($GLOBALS["___mysqli_ston"], $query122) or die ("Error in Query122".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while($res122 = mysqli_fetch_array($exec122)){
		  	$suppliername123=$res122['accountname'];
		  }
                  ?>
                  <input type="hidden" name="suppliername123" value="<?=trim($suppliername123);?>" >
                  <!-- <input type="hidden" name="suppliername" value="" > -->
                  <tr>
                  	 <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Doc No. : </td>
                  	 <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><b><?=$document; ?></b> </td>
                  	 <input type="hidden" name="documentnumber" value="<?= $document; ?>">
                  	 <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Doctor Name : </td>
                  	 <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><b><?=trim($suppliername123);?></b></td>
                  	 <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Allocation Date : </td>
                  	 <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><b><?=$billdate; ?></b></td>
                  </tr>
                   <tr>
                  	 <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Amount : </td>
                  	 <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><b><?=number_format($res5transactionamount,2,'.',','); ?></b> </td>
                  	 <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Pending Amount : </td>
                  	 <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><b><?php
                  	 $total_allocated_amount=0;
            	 $query3 = "SELECT transactionamount from master_transactiondoctor where  doctorcode='$suppliercode' and debit_reference_no='$document' order by auto_number desc"; 
				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num=mysqli_num_rows($exec3);
				while ($res3 = mysqli_fetch_array($exec3)) { $total_allocated_amount +=$res3['transactionamount']; }

				echo number_format($res5transactionamount-$total_allocated_amount,2,'.',',');
				$pending_amountfromdb=$res5transactionamount-$total_allocated_amount;

                  	 ?></b></td>
                  	 <input type="hidden" id="pending_amount" value="<?=$pending_amountfromdb;?>">
                  	 <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Ref No. : </td>
                  	 <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><b><?=$ref_no;?></b></td>
                  </tr>
              </tbody>
          </table>
      </td>
      </tr>
      <tr><td colspan="6">&nbsp;</td></tr>
      
      <tr><td>&nbsp;</td></tr>
       

	  <tr>

        <td>


		
 			<!-- <input type="hidden"  name="currencyas" id="currencyas" value="Kshs||1.00"> -->
                  

                   

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

             </tr>

            <tr>

              <td width="5%" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ffffff" class="bodytext311"><strong>No.</strong></td>

				  <td width="6%" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ffffff" class="bodytext311"><strong>Select</strong></td>

              <td width="9%" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ffffff" class="bodytext311"><strong> Doctor Inv No</strong></td>

             <!--  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ffffff"><div align="left"><strong>Doc No </strong></div></td> -->

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" width="8%" 

                bgcolor="#ffffff"><div align="left"><strong>Bill Date </strong></div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ffffff"><div align="right"><strong>Bill Amt </strong></div></td>

                 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ffffff"><div align="right"><strong>Allocated Amt </strong></div></td>

				 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ffffff"><div align="right"><strong>Dr</strong></div></td>

              <td width="8%" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ffffff" class="bodytext311"><div align="right"><strong>Cr Pending</strong></div></td>

				  <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ffffff"><div align="right"><strong> Adj Amt</strong></div></td>

              <td width="8%" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong> </strong></div></td>

                 <td colspan="6" class="cumtotal" align="right" style="position: fixed;">
					<table border="1" >
					<tr><th>&nbsp;Amount&nbsp;</th><th>&nbsp;Cum Total&nbsp;</th></tr>
					<tr><td><?php echo number_format($pending_amountfromdb,2,'.',','); ?></td><td id="cumtotal">0.00</td></tr>
					</table></td>

            </tr>

            <?php

			$colorloopcount='';

			$totalbalance = '';

			$sno = 0;

			$cashamount21 = '';

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

				
			

			
			$sno = 0;
			$query2 = "select description as doctorname,patientname,patientcode,visitcode,accountname,docno as billnumber,recorddate as transactiondate,original_amt,amount,transactionamount from billing_ipprivatedoctor where doccoa = '$suppliercode' ";

			//echo $query2;

			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			$rowcount2 = mysqli_num_rows($exec2);
			

			while ($res2 = mysqli_fetch_array($exec2))

			{

				$suppliername1 = $res2['patientname'];

				$patientcode = $res2['patientcode'];

				$visitcode = $res2['visitcode'];

				//$billautonumber=$res2['billanum'];

				$billnumber = $res2['billnumber'];

				$billdate = $res2['transactiondate'];

				$suppliername = $res2['accountname'];

				$doctorname=$res2['doctorname'];

				//$amount_topay_doc = $res2['amount'];
				$amount_topay_doc = $res2['transactionamount'];

				/*$query66="select * from consultation_referal where patientvisitcode='$visitcode'";

				$exec66=mysql_query($query66);

				$res66=mysql_fetch_array($exec66);

				$num66=mysql_num_rows($exec66);

				if($num66 == 0)

				{

					$doctorname='';

				}

				else

				{

					$doctorname=$res66['referalname'];

				}
*/
				

				/*$query67="select * from master_customer where customercode='$patientcode'";

				$exec67=mysql_query($query67);

				$res67=mysql_fetch_array($exec67);

				$firstname=$res67['customername'];

				$lastname=$res67['customerlastname'];

				$name=$firstname.$lastname;*/

				$name = $res2['patientname'];


				/*$query761="select transactionamount from doctorsharing where billnumber = '$billnumber' and billanum = '$billautonumber' AND visitcode ='$visitcode' ";

				$exec761=mysql_query($query761) or die("Error in query761".mysql_error());

				$res761=mysql_fetch_array($exec761);

				$billtotalamount = $res761['transactionamount'];*/

				//$billtotalamount = $res2['original_amt'];

				//$billtotalamount = $res2['amount'];
				$billtotalamount = $res2['transactionamount'];
				
				

				//$query3 = "select * from master_transactiondoctor where billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = '' and billautonumber='$billautonumber' and acc_status <> 'deallocated'";

				$query3 = "select * from master_transactiondoctor where billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''  and acc_status <> 'deallocated'";


				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

				$numb=mysqli_num_rows($exec3);

				

				while ($res3 = mysqli_fetch_array($exec3))

				{

					//echo $res3['auto_number'];

					$cashamount1 = $res3['cashamount'];

					$onlineamount1 = $res3['onlineamount'];

					$chequeamount1 = $res3['chequeamount'];

					$cardamount1 = $res3['cardamount'];

					$tdsamount1 = $res3['tdsamount'];

					$writeoffamount1 = $res3['writeoffamount'];

					

					

					$cashamount21 = $cashamount21 + $cashamount1;

					$cardamount21 = $cardamount21 + $cardamount1;

					$onlineamount21 = $onlineamount21 + $onlineamount1;

					$chequeamount21 = $chequeamount21 + $chequeamount1;

					$tdsamount21 = $tdsamount21 + $tdsamount1;

					$writeoffamount21 = $writeoffamount21 + $writeoffamount1;

					

				}

			

				$totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21;

				//echo '#'.$totalpayment.'#<br>';

				$netpayment = $totalpayment + $tdsamount21 + $writeoffamount21;
				//echo '##'.$totalpayment.'##<br>';

				//$balanceamount = $billtotalamount - $netpayment;
				$balanceamount = $amount_topay_doc - $netpayment;

				

				

				

				$billtotalamount = number_format($billtotalamount, 2, '.', '');

				$netpayment = number_format($netpayment, 2, '.', '');

				$balanceamount = number_format($balanceamount, 2, '.', '');

				

				$billstatus = $billtotalamount.'||'.$netpayment.'||'.$balanceamount;



				

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

			

			//$query3 = "select * from master_transactiondoctor where billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = '' and billautonumber='$billautonumber' and acc_status <> 'deallocated' order by auto_number desc";

			$query3 = "select * from master_transactiondoctor where billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''  and acc_status <> 'deallocated' order by auto_number desc";

			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res31 = mysqli_fetch_array($exec31);

			 $numb1=mysqli_num_rows($exec31);

			 $totalnumb=$totalnumb+$numb1;

			 

			$lastpaymentdate = $res31['transactiondate'];

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


			$sno = $sno + 1;
			

			?>

            <tr <?php echo $colorcode; ?>>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $sno; ?></td>

			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">

			  <input type="checkbox" name="ack[]" id="acknow<?php echo $sno; ?>" value="<?php echo $sno; ?>" onClick="updatebox('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>',<?=$pending_amountfromdb;?>)"></td>

            <!--   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div class="bodytext311"><?php echo $name; ?>(<?php echo $visitcode; ?>)</div></td> -->

			  <input type="hidden" name="patientcode[]" id="patientcode" value="<?php echo $patientcode; ?>">

			  <input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitcode; ?>">

			  <input type="hidden" name="accountname[]" id="accountname" value="<?php echo $suppliername; ?>">

			  <input type="hidden" name="doctorname[]" value="<?php echo $doctorname; ?>">

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billnumber; ?></div></td>

              <input type="hidden" name="billnum[]" value="<?php echo $billnumber; ?>">

			  <input type="hidden" name="name[]" value="<?php echo $name; ?>">

              <input type="hidden" name="serialno[]" value="<?php echo $sno; ?>">

              <input type="hidden" name="billautonumber[]" value="<?php echo $billautonumber; ?>">

			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billdate; ?></div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">

                <?php if ($billtotalamount != '0.00') echo $billtotalamount; //echo number_format($billtotalamount, 2); ?>

              </div></td><input type="hidden" name="billamount" id="bill" value="<?php if ($billtotalamount != '0.00') echo $billtotalamount; ?>">

                <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">

                <?php $allocatedamount = 0; if ($allocatedamount != '0.00') echo $allocatedamount; //echo number_format($billtotalamount, 2); ?>

              </div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">

             

              </div></td>

             <!--  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">

                <?php if ($netpayment != '0.00') echo $netpayment; //echo number_format($netpayment, 2); ?>

              </div></td> -->

             <!--  <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left"><div align="right"> <?php echo $lastpaymentdate; ?> </div>

                  <div align="right"></div>

                <div align="right"></div></td> -->

             <!--  <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">

                  <?php if ($daysafterpaymentdate != '') echo $daysafterpaymentdate.' Days'; ?>

                </div>

                  <div align="right"></div>

                <div align="right"></div></td> -->

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">

                <?php if ($balanceamount != '0.00') echo $balanceamount; //echo number_format($balanceamount, 2); ?>

              </div></td>

			      <td class="bodytext311" valign="right" bordercolor="#f3f3f3" align="right">

					<input class="bali" type="text" name="adjamount[]" id="adjamount<?php echo $sno; ?>" size="7" onClick="checkboxcheck('<?php echo $sno; ?>')" autocomplete="off" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>','<?=$pending_amountfromdb;?>')">
					<input type="hidden" class="bal" name="balamount<?php echo $sno; ?>" id="balamount<?php echo $sno; ?>" value="" size="7" readonly>
					</td>

           <!--  <td class="bodytext311" valign="center" bordercolor="#f3f3f3"><input type="text" class="bal" name="balamount[]" id="balamount<?php echo $sno; ?>" size="7" readonly></td> -->

            </tr>

            <?php

				$totalbalance = $totalbalance + $balanceamount;

				}

				//$cashamount21 = '0.00';
				$cashamount21 = 0;

				//$cardamount21 = '0.00';
				$cardamount21 = 0;

				//$onlineamount21 = '0.00';
				$onlineamount21 = 0;

				//$chequeamount21 = '0.00';
				$chequeamount21 = 0;

				//$tdsamount21 = '0.00';
				$tdsamount21 = 0;

				//$writeoffamount21 = '0.00';
				$writeoffamount21 = 0;

				//$taxamount21 = '0.00';
				$taxamount21 = 0;



				//$totalpayment = '0.00';
				$totalpayment = 0;

				//$netpayment = '0.00';
				$netpayment = 0;

				//$balanceamount = '0.00';
				$balanceamount = 0;

				

				//$billtotalamount = '0.00';
				$billtotalamount = 0;

				//$netpayment = '0.00';
				$netpayment = 0;

				//$balanceamount = '0.00';
				$balanceamount = 0;

				

				//$billstatus = '0.00';

				$billstatus = 0;

			}

			

			 //echo $number=mysql_num_rows($exec25);
					 
			  }

			

			if ($document!="")

			{ 

			?>

			<tr>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

                 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong>

                <?php //echo number_format($totalpurchaseamount, 2); ?>

              </strong></div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong>

                <?php //echo number_format($netpaymentamount, 2); ?>

              </strong></div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"  bgcolor="#ecf0f5"><div align="right"><strong> </strong></div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right"  bgcolor="#ecf0f5"><b><?php //if ($total_debit != '') echo number_format($total_debit, 2, '.', ','); ?></b></td>

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
                <input type="hidden" name="doctorcode" value="<?php echo $suppliercode; ?>">

			</tr>

			<tr>

              <td colspan="10" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right">

			  <input type="hidden" name="frmflag2" id="frmflag2" value="frmflag2">

			  <input type="submit" name="submit1" id="submit1" value="Submit"  onclick="return confirm('Are you sure you want to Save?');"></td>

				<td colspan="" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">&nbsp;</td>

			</tr>

			<?php

			}

			?>	

			 </tbody>

        </table>	

		<!-- </form> -->

		<tr>
      	<td>
      		<!-- <form method="post" > -->
      		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="700" 

            align="left" border="0">

          <tbody>

		   		<tr bgcolor="#011E6A">

                    <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Doctor Allocated Account - Details </strong></td> <td bgcolor="#ecf0f5" class="bodytext3" colspan="2"> </td>

                  </tr>
              <tr>

              <td width="5%" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext311"><strong>No.</strong></td>
              <td width="10%" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext311"><strong>Doc No</strong></td>
              <td width="10%" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext311"><strong>Ref No</strong></td>
              <td width="10%" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext311"><strong>Bill Date</strong></td>
              <!-- <td width="25%" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext311"><strong>Bill Amt</strong></td> -->
              <td width="15%" align="right" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext311" > <strong>Allocated Amount</strong></td>
              <!-- <td width="15%" align="left" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext311"><strong>Bal Amount</strong></td> -->
              <td width="15%" align="right" valign="center" bordercolor="#f3f3f3" bgcolor="#ffffff" class="bodytext311">status</td>
				  
               

            </tr>
            <tr>
            	<?php
            	$snoq=0;
            	$total_allocated_amount=0;
            	 $query3 = "SELECT * from master_transactiondoctor where  debit_reference_no = '$document' and doctorcode = '$suppliercode' order by auto_number desc";
            	// echo $query3 = "SELECT * from master_transactionpharmacy where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and billnumber = '$document'and recordstatus = 'allocated'";
				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num=mysqli_num_rows($exec3);
				while ($res3 = mysqli_fetch_array($exec3))

				{

					//echo $res3['auto_number'];

				    $auto_number = $res3['auto_number'];
				    $cashamount1 = $res3['cashamount'];

					$onlineamount1 = $res3['onlineamount'];

					$chequeamount1 = $res3['chequeamount'];

					$cardamount1 = $res3['cardamount'];

					$tdsamount1 = $res3['tdsamount'];

					$writeoffamount1 = $res3['writeoffamount'];

					$taxamount1 = $res3['taxamount'];
					$transactionamount = $res3['transactionamount'];
					$docno = $res3['docno'];
					$transactioncode = $res3['transactioncode'];
					$transactiondate = $res3['transactiondate'];
					$billnumber = $res3['billnumber'];

					$total_allocated_amount +=$res3['transactionamount'];

					$colorloopcount = $colorloopcount + 1;
						$showcolor = ($colorloopcount & 1); 
						if ($showcolor == 0) { $colorcode = 'bgcolor="#CBDBFA"';
						}else{ $colorcode = 'bgcolor="#ecf0f5"'; }
						?>

					<tr <?php echo $colorcode; ?>>

					<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $snoq = $snoq + 1; ?></td>
					
					<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?=$docno;?></td>
					<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?=$billnumber;?></td>
					<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?=$transactiondate;?></td>
					<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right"><?=number_format($transactionamount, 2, '.', ',');?></td>
					 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right"><?='Approved'?>
						<!-- <input type="checkbox" name="ack<?php echo $snoq; ?>" id="acknow<?php echo $sno; ?>" value="<?php echo $billnumber; ?>"> -->
					 </td> 
					 <input type="hidden" name="anums<?php echo $snoq; ?>" value="<?=$auto_number;?>">
					</tr>
						<?php }
            	?>
            </tr>
            <tr>
            	<td colspan="5" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($total_allocated_amount, 2, '.', ','); ?></strong></div></td>
            	<td colspan="1" class="bodytext311" valign="center" bgcolor="#ecf0f5"></td>
            </tr>
            <tr>
            	<input type="hidden" name="count_dis" value="<?=$snoq;?>">
              <td colspan="7" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right">
			 		<!--  <input type="submit" name="deallocate" id="deallocate" value="Submit" onclick="return confirm('Are you sure you want to Save?');"> -->
				</td>
			</tr>
              </tbody>
          </table>
      </form>
      	</td>
      </tr>

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




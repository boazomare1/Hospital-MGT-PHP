<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$updatedate = date('Y-m-d');
$updatetime = date('H:i:s');
$errmsg = "";
$bgcolorcode = "";

// Default date ranges
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

// Initialize variables
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$locdocno = $_SESSION['docno'];



$query = "select * from login_locationdetails where username='$username' and docno='$locdocno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

	

	$res12location = $res["locationname"];

	$res12locationcode = $res["locationcode"];

	$res12locationanum = $res["auto_number"];



//This include updatation takes too long to load for hunge items database.

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d', strtotime('-30 days')); }

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }



// if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

// //$getcanum = $_GET['canum'];

// if ($getcanum != '')

// {

// 	$query4 = "select * from master_supplier where auto_number = '$getcanum'";

// 	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());

// 	$res4 = mysql_fetch_array($exec4);

// 	$cbsuppliername = $res4['suppliername'];

// 	$suppliername = $res4['suppliername'];

// }
 
if (isset($_REQUEST["frmflag23"])) { $frmflag23 = $_REQUEST["frmflag23"]; } else { $frmflag23 = ""; }
if ($frmflag23 == 'frmflag23')
{

$docnumber = $_REQUEST['docnumber'];
$searchsuppliername2 = $_REQUEST['searchsuppliername2'];
$searchsuppliercode = $_REQUEST['searchsuppliercode'];
$searchsupplieranum = $_REQUEST['searchsupplieranum'];

$searchaccountname = $_REQUEST['searchaccountname'];
$searchaccountcode = $_REQUEST['searchaccountcode'];
$searchaccountanum = $_REQUEST['searchaccountanum'];

$totaladjamt = $_REQUEST['totaladjamt'];
$totaladjamt=str_replace(',', '', $totaladjamt);

$query="INSERT INTO `crdradjustment_summary`(`docno`, `amount`, `subtype`, `subtype_anum`, `accountname`, `accountcode`, `accountnameano`, `locationname`, `locationcode`, `ipaddress`, `recorddate`, `username`,`recordtime`) VALUES ('$docnumber','$totaladjamt','$searchsuppliername2','$searchsupplieranum','$searchaccountname','$searchaccountcode','$searchaccountanum','$res12location','$res12locationcode','$ipaddress','$updatedate','$username','$updatetime')";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
 

foreach($_POST['billnum'] as $key => $value)
		{
		$billnum=$_POST['billnum'][$key];
		$name=$_POST['name'][$key];
		$patientcode=$_POST['patientcode'][$key];
		$visitcode=$_POST['visitcode'][$key];
		$accountname=$_POST['accountname'][$key];
		$accountnameid = $_REQUEST['accountnameid'][$key];
		$accountnameano = $_REQUEST['accountnameano'][$key];
		$balamount=$_POST['balamount'][$key];
		$balamount=str_replace(',', '', $balamount);

		$billamount=$_POST['billamount'][$key];
		// $billamount=str_replace(',', '', $billamount);

		$adjamount=$_POST['adjamount'][$key];
		$discount=$_POST['discount'][$key];
		$billdate=$_POST['billdate'][$key];

		$adjamount=str_replace(',', '', $adjamount);

		foreach($_POST['ack'] as $check)
		{
		$acknow=$check;

		$dotarray = explode("||", $acknow);
			$cbilln = $dotarray[0];
			$caccountid = $dotarray[1];

		if($cbilln==$billnum && $accountnameid==$caccountid )
		{
		 
		//  $query87 ="select * from master_transactionpaylater where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1' and recordstatus = 'allocated' and accountnameid='$accountnameid' and subtypeano='$subtypeano' " ;
		// $exec87 = mysql_query($query87) or die(mysql_error());
		// $num87 = mysql_num_rows($exec87);
		// exit();
		// if($num87 == 0)
		if(1)
		{
		
		if($adjamount != 0 || $adjamount != 0.00)
		{

			// FOR ADHC CREDIT
					$paynowbillprefix = 'CRN-';
					$paynowbillprefix1=strlen($paynowbillprefix);
					$query2 = "select * from adhoc_creditnote order by auto_number desc limit 0, 1";
					$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res2 = mysqli_fetch_array($exec2);
					$billnumber = $res2["docno"];
					$billdigit=strlen($billnumber);
					if ($billnumber == '')
					{
					$billnumbercode ='CRN-'.'1';
					}
					else
					{
					$billnumber = $res2["docno"];
					$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
					$billnumbercode = intval($billnumbercode);
					$billnumbercode = $billnumbercode + 1;
					$maxanum = $billnumbercode;
					$billnumbercode = 'CRN-' .$maxanum;
					}

			// FOR DEBTOR SALES ID
				$paynowbillprefix = 'DBI-';
				$paynowbillprefix1=strlen($paynowbillprefix);
				$query2 = "select * from debtors_invoice where companyanum = '$companyanum' order by auto_number desc";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res2 = mysqli_fetch_array($exec2);
				$res2billnumber = $res2["billnumber"];
				$billdigit=strlen($res2billnumber);
				if ($res2billnumber == '')
				{
				$debtor_billnumbercode ='DBI-'.'1';
				}
				else
				{
				$res2billnumber = $res2["billnumber"];
				$billnumbercode2 = substr($res2billnumber,$paynowbillprefix1, $billdigit);
				$billnumbercode2 = intval($billnumbercode2);
				$billnumbercode2 = $billnumbercode2 + 1;
				$maxanum = $billnumbercode2;
				$debtor_billnumbercode = 'DBI-' .$maxanum;
				}


		// FOR DETAILED ONE 
		  $query9 = "INSERT INTO `crdradjustment_detail`(`docno`, `billnumber`, `patientname`, `patientcode`, `patientvisitcode`, `subtype`, `subtype_anum`, `accountname`, `accountcode`, `accountnameano`, `billdate`, `transactionamount`, `balance_amount`, 
		 `locationname`, `locationcode`, `ipaddress`, `recorddate`, `username`,`recordtime`,`billamount`,`creditnote_billnum`,`debtor_billnum`) 
		 VALUES ('$docnumber','$billnum','$name','$patientcode','$visitcode','$searchsuppliername2','$searchsupplieranum',
		 '$accountname','$accountnameid','$accountnameano','$billdate','$adjamount','$balamount',
		 '$res12location','$res12locationcode','$ipaddress','$updatedate','$username','$updatetime','$billamount','$billnumbercode','$debtor_billnumbercode')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));



 		 $query3 = "INSERT into adhoc_creditnote(docno,units,amount,patientcode,patientname,patientvisitcode,description,rate,billtype,billingaccountcode,billingaccountname,accountname,accountnameano, accountcode,
 		consultationdate,paymentstatus,consultationtime,remarks,username,ipaddress,locationname,locationcode,ref_no )
 		values('$billnumbercode','1','$adjamount','$patientcode','$name','$visitcode','','$adjamount','$billtype','$searchaccountcode','$searchaccountname','$accountname','$accountnameano','$accountnameid'
 		,'$updatedate','pending','$updatetime','','$username','$ipaddress','".$res12location."','".$res12locationcode."', '$billnum')";
		$exec3=mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		// FOR ALLOCATION

		$query2 = "SELECT billbalanceamount,accountnameano from master_transactionpaylater where billnumber='$billnum' and accountcode = '$accountnameid' and transactionstatus <> 'onaccount' and acc_flag = '0'  and transactiontype not in ('pharmacycredit','paylatercredit')  order by transactiondate ASC";
			// and transactiondate between '$ADate1' and '$ADate2' and transactionmode <> 'CREDIT NOTE'
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowcount21 = $rowcount21 + $rowcount2 = mysqli_num_rows($exec2);
			while ($res2 = mysqli_fetch_array($exec2)){
				$balamount1 = $res2['billbalanceamount'];
				$accountnameano = $res2['accountnameano'];
				}

			$receivableamount=$adjamount;
			$query_allocated_amount = "SELECT sum(transactionamount) as amount, sum(discount) as discount from master_transactionpaylater where  recordstatus='allocated' and billnumber='$billnum'";
			$exec_allocated_amount = mysqli_query($GLOBALS["___mysqli_ston"], $query_allocated_amount) or die ("Error in Query_allocated_amount".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res_allocated_amount = mysqli_fetch_array($exec_allocated_amount)){
			$allocated_amount=$res_allocated_amount['amount']+$res_allocated_amount['discount'];
				}
			$balamount = $balamount1-$receivableamount;

			if($balamount == 0.00) { $billstatus='paid'; }
 				else { $billstatus='unpaid'; }
 			$discount = '';
			$currency = 'Kenya Shillings';


			$query55 = "select * from master_accountname where id='$accountnameid'";
			$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res55 = mysqli_fetch_array($exec55);
			$paytype = $res55['paymenttype'];
			$subpaytype = $res55['subtype'];

			$querytype1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$paytype'");
			$exectype1=mysqli_fetch_array($querytype1);
			$patienttype11=$exectype1['paymenttype'];

			$querysubtype1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$subpaytype'");
			$execsubtype1=mysqli_fetch_array($querysubtype1);
			$patientsubtype11=$execsubtype1['subtype'];
			$subtypeano = $execsubtype1['auto_number'];

		
				//////////////// INSERT OF DOC IN master_transactionpaylater////////////
		$query91 = "INSERT into master_transactionpaylater (transactiondate, transactiontime, particulars,  
		transactionmode, transactiontype, transactionamount, writeoffamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,docno,billbalanceamount,recordstatus,receivableamount,paymenttype,subtype,username,accountnameano,accountnameid,locationcode,locationname,subtypeano,accountcode,currency,fxrate,fxamount,discount,acc_flag) 
		values ('$updatedate','$updatetime', '',
		'', 'paylatercredit', '$receivableamount', '', 
		'',  '', '$ipaddress', '$updatedate', '', '$companyanum', '$companyname', '', 
		'','$name','$patientcode','$visitcode','$accountname','$billnumbercode','$receivableamount','','$receivableamount','$patienttype11','$patientsubtype11','$username','$accountnameano','$accountnameid','$res12locationcode','$res12location','$subtypeano','$accountnameid','$currency','1','$receivableamount','','0')";
		$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die ("Error in Query91".mysqli_error($GLOBALS["___mysqli_ston"]));
			//////////////// INSERT OF DOC IN ////////////

		$query9912="update master_transactionpaylater set acc_flag='1' where billnumber='$billnum' and transactiontype='finalize' and accountnameid='$accountnameid'";
		$exec9912=mysqli_query($GLOBALS["___mysqli_ston"], $query9912);

		$query99122="update master_transactionpaylater set acc_flag='1' where billnumber='$billnum' and transactiontype='PAYMENT' and recordstatus = 'allocated'  and accountnameid='$accountnameid' and subtypeano='$subtypeano' ";
		$exec99122=mysqli_query($GLOBALS["___mysqli_ston"], $query99122);

		// for deallocate
		// $query84="update master_transactionpaylater set acc_flag = '0' where billnumber='$billnum2' and recordstatus <> 'deallocated' and accountnameid='$accountnameid' and subtypeano='$subtypeano' order by auto_number desc limit 1";
		// $exec84=mysql_query($query84) or die(mysql_error());
		// for deallocate


		/////////// ALLCOATION AGAINST THAT CRN DOC NUMBER FOR BILLS ////////////////////
		$query87 ="SELECT * from master_transactionpaylater where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$billnumbercode' and recordstatus = 'allocated'";
		$exec87 = mysqli_query($GLOBALS["___mysqli_ston"], $query87) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num87 = mysqli_num_rows($exec87);
		if($num87 == 0)
		{

		$billnumberprefix = '';
		$billnumber = '';
		$billanum = '';
		$balanceamount = '';
		$remarks = '';
		$transactionmodule = '';
		$doctorname = '';	

		$transactiontype = 'PAYMENT';
		$transactionmode = 'CREDIT NOTE';
		$particulars = 'BY CREDIT NOTE '.$billnumberprefix.$billnumber;		

		$query9 = "INSERT into master_transactionpaylater (transactiondate, transactiontime, particulars,  
		transactionmode, transactiontype, transactionamount, writeoffamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,billbalanceamount,recordstatus,receivableamount,paymenttype,subtype,username,accountnameano,accountnameid,locationcode,locationname,subtypeano,accountcode,currency,fxrate,fxamount,discount) 

		values ('$updatedate','$updatetime', '$particulars',
		'$transactionmode', '$transactiontype', '$adjamount', '$adjamount', 
		'$billnum',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$name','$patientcode','$visitcode','$accountname','$doctorname','$billstatus','$billnumbercode','$balamount','allocated','$receivableamount','$patienttype11','$patientsubtype11','$username','$accountnameano','$accountnameid','$res12locationcode','$res12location','$subtypeano','$accountnameid','$currency','1','$adjamount','$discount')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
 
		}
		// echo '<br>';


		/// DEBTOR SALES
// searchaccountname
// searchaccountcode
// searchaccountanum

				$query4 = "INSERT into debtors_invoice (companyanum, billnumber, itemname, rate, quantity, subtotal,  totalamount, username, ipaddress, entrydate,accountname,accountcode, locationcode, locationname, remarks, currency, fxrate, fxamount, fxpkrate, fxtotamount,ref_accountcode,ref_accountname) 
				values ('$companyanum', '$debtor_billnumbercode', '$billnum', '$adjamount', '1', '$adjamount', '$adjamount', '$username', '$ipaddress', '$updatedate', '$searchaccountname','$searchaccountcode',  '$res12locationcode', '$res12location','','$currency','1','1','$adjamount','$adjamount','$accountnameid','$accountname')";
				$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

				$financialyear = $_SESSION["financialyear"];
				$query43="INSERT into master_transactionpaylater(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,financialyear,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,locationname,locationcode,accountnameano,accountnameid,subtypeano,billbalanceamount,billamount,currency,fxrate,fxamount,accountcode)
				values('Debtor Invoice','','','$updatedate','$searchaccountname','$debtor_billnumbercode','$ipaddress','$companyanum','$companyname','$financialyear','finalize','$patienttype11','$patientsubtype11','$adjamount','$username','$updatetime','".$res12location."','".$res12locationcode."','$searchaccountanum','$searchaccountcode','$subtypeano','$adjamount','$adjamount','$currency','1','$adjamount','$searchaccountcode')";
				$exec43=mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die("error in query43".mysqli_error($GLOBALS["___mysqli_ston"]));

		}
		} 

		 
	} /// CHECK BOX CONDITION IF CONDITION
	}  /// for each check box checked
	} // for each the names array loop
// Check for URL messages
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'success') {
        $errmsg = "Credit/Debit adjustment processed successfully.";
        $bgcolorcode = 'success';
    } elseif ($_GET['msg'] == 'failed') {
        $errmsg = "Failed to process credit/debit adjustment.";
        $bgcolorcode = 'failed';
    }
}

header("location:crdradjustment.php?msg=success");

}



// include ("autocompletebuild_accounts1.php");



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credit/Debit Adjustment - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/crdr-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Legacy CSS for compatibility -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
    <link rel="stylesheet" type="text/css" href="css/autocomplete.css">
    
    <!-- Legacy JavaScript -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>

<script>

// function openCity(evt, cityName) {

//     var i, tabcontent, tablinks;

//     tabcontent = document.getElementsByClassName("tabcontent");

//     for (i = 0; i < tabcontent.length; i++) {

//         tabcontent[i].style.display = "none";

//     }

//     tablinks = document.getElementsByClassName("tablinks");

//     for (i = 0; i < tablinks.length; i++) {

//         tablinks[i].className = tablinks[i].className.replace(" active", "");

//     }

//     document.getElementById(cityName).style.display = "block";

//     evt.currentTarget.className += " active";

	

// 	//alert(cityName); 

// 	var elements = document.getElementsByClassName("hiddenclass");

// 	if(cityName == "emrtabid"){

// 		for(var i=0; i<elements.length; i++) { 

// 		elements[i].style.display='none';

// 		}

// 	}else{

// 		for(var i=0; i<elements.length; i++) { 

// 		elements[i].style.display='block';

// 		}

// 	}

// }

function dispnone(){

	//alert('dispnone');

	 var cityName ="consultationtabid";

	  var i, tabcontent, tablinks;

    tabcontent = document.getElementsByClassName("tabcontent");

	for (i = 0; i < tabcontent.length; i++) {

        tabcontent[i].style.display = "none";

    }

    tablinks = document.getElementsByClassName("tablinks");

    for (i = 0; i < tablinks.length; i++) {

        tablinks[i].className = tablinks[i].className.replace(" active", "");

    }

    document.getElementById(cityName).style.display = "block";

	document.getElementById("defaultOpen").className += " active";

	

	//alert('dispnone end');

 }

 window.onload =function() {

 dispnone();

};

</script>

<script>

function updatebox1(varSerialNumber6,billamt6,totalcount6)

{



var grandtotalamt = 0;

var varSerialNumber6 = varSerialNumber6;

var totalcount6=totalcount6;

var billamt6 = billamt6;

  

  document.getElementById("amt"+varSerialNumber6+"").value='';

if(document.getElementById("acknow1"+varSerialNumber6+"").checked == true)

{

    

		var totalbillamt6=document.getElementById("totaladjamt1").value;

	if(totalbillamt6 == 0.00)

{

totalbillamt6=0;

}

				totalbillamt6=parseFloat(totalbillamt6)+parseFloat(billamt6);

			document.getElementById("amt"+varSerialNumber6+"").value=billamt6;

document.getElementById("totaladjamt1").value=totalbillamt6.toFixed(2);

}

else

{

//alert(totalcount1);

for(j=1;j<=totalcount6;j++)

{

var totalamt=document.getElementById("amt"+j+"").value;



if(totalamt == "")

{

totalamt=0;

}

grandtotalamt=grandtotalamt+parseFloat(totalamt);

}





document.getElementById("totaladjamt1").value=grandtotalamt.toFixed(2);



 }  

}



function updatebox(varSerialNumber,billamt,totalcount1)
{
var adjamount1;
var grandtotaladjamt2=0;
var varSerialNumber = varSerialNumber;
var totalcount1=document.getElementById("totalrow").value;
// var amounttodisp1=parseFloat(document.getElementById("amounttodisp").value.replace(/,/g,''));
// var cumtotal1=parseFloat(document.getElementById("cumtotal").innerHTML.replace(/,/g,''));

var billamt = billamt;
  var textbox = document.getElementById("adjamount"+varSerialNumber+"");
    textbox.value = "";
    document.getElementById("discount"+varSerialNumber+"").value = "";
    document.getElementById("balamount"+varSerialNumber+"").value = "";
if(document.getElementById("acknowpending"+varSerialNumber+"").checked == true)
{

			if(document.getElementById("acknowpending"+varSerialNumber+"").checked) {
					 
							textbox.value = billamt;
			}

	// var balanceamt=billamt-billamt;
	var balanceamt=billamt-textbox.value;
	if(balanceamt == 0.00)
	{
	balanceamt=0;
	}
	discount123=0;
	document.getElementById("balamount"+varSerialNumber+"").value=balanceamt.toFixed(2);
	document.getElementById("discount"+varSerialNumber+"").value=discount123.toFixed(2);
	var totalbillamt=document.getElementById("totaladjamt").value;

		if(totalbillamt == 0.00)
		{
		totalbillamt=0;
		}
				totalbillamt=parseFloat(totalbillamt)+parseFloat(billamt);
				document.getElementById("totaladjamt").value = totalbillamt.toFixed(2);



			for(j=1;j<=totalcount1;j++)
			{
			var totaladjamount2=document.getElementById("adjamount"+j+"").value;
			if(totaladjamount2 == "")
			{
			totaladjamount2=0;
			}
			grandtotaladjamt2=grandtotaladjamt2+parseFloat(totaladjamount2);
			}
			grandtotaladjamt2=grandtotaladjamt2.toFixed(2);
			grandtotaladjamt2 = grandtotaladjamt2.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			document.getElementById("totaladjamt").value=grandtotaladjamt2;

			// document.getElementById("cumtotal").innerHTML=document.getElementById("totaladjamt").value;
			return false;
			}
			else
			{
			for(j=1;j<=totalcount1;j++)
			{
			var totaladjamount2=document.getElementById("adjamount"+j+"").value;
			if(totaladjamount2 == "")
			{
			totaladjamount2=0;
			}
			grandtotaladjamt2=grandtotaladjamt2+parseFloat(totaladjamount2);
			}
			grandtotaladjamt2=grandtotaladjamt2.toFixed(2);
			grandtotaladjamt2 = grandtotaladjamt2.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			document.getElementById("totaladjamt").value=grandtotaladjamt2;
			// document.getElementById("cumtotal").innerHTML=document.getElementById("totaladjamt").value;
			return false;
			 }  

			}



function totalamountcheck(totalcount7,grandtotalamt1)

{

var totalcount7=totalcount7;

var grandtotalamt1=grandtotalamt1;

//alert(totalcount7);



document.getElementById("submit1").disabled=true;

var receivableamount = document.getElementById("receivableamount").value;



var checkamount= document.getElementById("totaladjamt").value;
var amounttodisp= document.getElementById("amounttodisp").value;

checkamount = checkamount.replace(/,/g,'');

receivableamount = receivableamount.replace(/,/g,'');

if(checkamount == 0.00)

{

alert("Adjustable amount cannot be Zero");

document.getElementById("submit1").disabled=false;

return false;

}

//alert(receivableamount);

// if((parseFloat(checkamount)) > (parseFloat(receivableamount)))
// if((parseFloat(checkamount)) > (parseFloat(amounttodisp)))

if (parseFloat(parseFloat(checkamount).toFixed(2)) > parseFloat(parseFloat(amounttodisp).toFixed(2)))
// if (parseFloat(checkamount.toFixed(2)) > parseFloat(amounttodisp.toFixed(2)))
{

alert("Allocated amount is greater than Receivable amount");

document.getElementById("submit1").disabled=false;

return false;

}

var checkamount2 = parseInt(checkamount) + parseInt(grandtotalamt1);

var checkamount1= document.getElementById("receivableamount").value;

// if(parseInt(checkamount2) > parseInt(checkamount1))
// if (parseFloat(checkamount2.toFixed(2)) > parseFloat(checkamount1.toFixed(2)))
if (parseFloat(parseFloat(checkamount2).toFixed(2)) > parseFloat(parseFloat(checkamount1).toFixed(2)))
{

alert("Allocated amount is greater than Receivable amount");

document.getElementById("submit1").disabled=false;

return false;

}

FuncPopup();

document.form2.submit();

return true;

}



function checkboxcheck(varSerialNumber5)

{



if(document.getElementById("acknowpending"+varSerialNumber5+"").checked == false)

{

alert("Please click on the Select check box");

return false;

}

return true;

}

// function balancecalc(varSerialNumber1,billamt1,totalcount)
// {
// 	document.getElementById("adjamount"+varSerialNumber1+"").disabled=true;
// 		var varSerialNumber1 = varSerialNumber1;
// 		var billamt1 = billamt1;
// 		var totalcount=document.getElementById("totalrow").value;
// 		var grandtotaladjamt=0;

// 		var adjamount=document.getElementById("adjamount"+varSerialNumber1+"").value;
// 		var adjamount3=parseFloat(adjamount);

// 		var discount=document.getElementById("discount"+varSerialNumber1+"").value;
// 		var discount3=parseFloat(discount);
// 		if(discount=="") {
// 			var discount3=0;
// 		}
// 		if(adjamount=="" ){
// 			var adjamount3=0;
// 		}
// 		if((discount3+adjamount3) > billamt1)
// 		{
// 			alert("Please enter correct amount");
// 			document.getElementById("totaladjamt").value = '0.00';
// 			document.getElementById("adjamount"+varSerialNumber1+"").value = '0.00';
// 			var balance_after =  billamt1-discount3;
// 			document.getElementById("balamount"+varSerialNumber1+"").value = balance_after.toFixed(2);
// 			// document.getElementById("balamount"+varSerialNumber1+"").value = billamt1;
// 			document.getElementById("adjamount"+varSerialNumber1+"").focus();
// 			return false;
// 		}
// 		var balanceamount=parseFloat(billamt1)-(discount3+adjamount3);
// 		alert(balanceamount);
// 		document.getElementById("balamount"+varSerialNumber1+"").value=balanceamount.toFixed(2);
// 		for(i=1;i<=totalcount;i++)
// 		{
// 			var totaladjamount=document.getElementById("adjamount"+i+"").value;
// 			if(totaladjamount == "")
// 			{
// 				totaladjamount=0;
// 			}
// 			grandtotaladjamt=grandtotaladjamt+parseFloat(totaladjamount);
// 		}

// 		grandtotaladjamt=grandtotaladjamt.toFixed(2);
// 		grandtotaladjamt = grandtotaladjamt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
// 		document.getElementById("totaladjamt").value=grandtotaladjamt;
// }

function balancecalc_dis(varSerialNumber1,billamt1,totalcount)
{
		var varSerialNumber1 = varSerialNumber1;
		var billamt1 = billamt1;
		var totalcount=document.getElementById("totalrow").value;
		var grandtotaldiscount=0;
		var grandtotaladjamt=0;

		var discount=document.getElementById("discount"+varSerialNumber1+"").value;
		var discount3=parseFloat(discount);

		var adjamount=document.getElementById("adjamount"+varSerialNumber1+"").value;
		var adjamount3=parseFloat(adjamount);

		var amounttodisp1=parseFloat(document.getElementById("amounttodisp").value.replace(/,/g,''));
		var cumtotal1=parseFloat(document.getElementById("cumtotal").innerHTML.replace(/,/g,''));

		if(discount=="") {
			var discount3=0;
		}
		if(adjamount=="" ){
			var adjamount3=0;
		}

		if((discount3) > billamt1)
		{
			alert("Please enter correct amount");
			document.getElementById("totaldiscount").value = '0.00';
			document.getElementById("discount"+varSerialNumber1+"").value = '0.00';
			
			document.getElementById("balamount"+varSerialNumber1+"").value = '0.00';
			document.getElementById("adjamount"+varSerialNumber1+"").value = billamt1;
			document.getElementById("discount"+varSerialNumber1+"").focus();
			return false;
		}

		var bal_amount= amounttodisp1-cumtotal1;
		// alert(billamt1);
		// alert(bal_amount);
		

   //  	if(parseFloat(billamt1)>parseFloat(bal_amount)){

   //  		var balance_after =  adjamount3-(discount3);
			// document.getElementById("balamount"+varSerialNumber1+"").value = '0.00';
			// document.getElementById("adjamount"+varSerialNumber1+"").value = balance_after.toFixed(2);
			// document.getElementById("discount"+varSerialNumber1+"").focus();

   //  	}else{

		// if((discount3+adjamount3) > billamt1)
		// {
			// alert("Please enter correct amount");
			// document.getElementById("totaldiscount").value = '0.00';
			// document.getElementById("discount"+varSerialNumber1+"").value = '0.00';
			// var balance_after =  billamt1-adjamount3;
			var balance_after =  parseFloat(billamt1)-(discount3);
			// document.getElementById("balamount"+varSerialNumber1+"").value = balance_after.toFixed(2);
			document.getElementById("balamount"+varSerialNumber1+"").value = '0.00';
			document.getElementById("adjamount"+varSerialNumber1+"").value = (billamt1-discount3).toFixed(2);
			document.getElementById("discount"+varSerialNumber1+"").focus();
			// return false;
		// }

			// }

		// var balanceamount=parseFloat(billamt1)-(discount3+adjamount3);

		// document.getElementById("balamount"+varSerialNumber1+"").value=balanceamount.toFixed(2);
		// document.getElementById("adjamount"+varSerialNumber1+"").value=balanceamount.toFixed(2);
		for(i=1;i<=totalcount;i++)
		{
			var totaldiscount=document.getElementById("discount"+i+"").value;
			if(totaldiscount == "")
			{
				totaldiscount=0;
			}
			grandtotaldiscount=grandtotaldiscount+parseFloat(totaldiscount);
		}
		grandtotaldiscount=grandtotaldiscount.toFixed(2);
		grandtotaldiscount = grandtotaldiscount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
		document.getElementById("totaldiscount").value=grandtotaldiscount;
		// alert(grandtotaldiscount);

		for(i=1;i<=totalcount;i++)
		{
			var totaladjamount=document.getElementById("adjamount"+i+"").value;
			if(totaladjamount == "")
			{
				totaladjamount=0;
			}
			grandtotaladjamt=grandtotaladjamt+parseFloat(totaladjamount);
		}


		// if(totaladjamount>parseFloat(bal_amount)){
		// 	grandtotaladjamt=bal_amount;;
		// }

		grandtotaladjamt=grandtotaladjamt.toFixed(2);
		grandtotaladjamt = grandtotaladjamt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
		document.getElementById("totaladjamt").value=grandtotaladjamt;
		document.getElementById("cumtotal").innerHTML=document.getElementById("totaladjamt").value;


		if((parseFloat(document.getElementById("amounttodisp").value.replace(/,/g,''))) < (parseFloat(document.getElementById("totaladjamt").value.replace(/,/g,''))))
		{
			document.getElementById("cumtotal").style.color="red";
			}
			else
			{document.getElementById("cumtotal").style.color="black";}
		document.getElementById("cumtotal").innerHTML=document.getElementById("totaladjamt").value;
}

function balancecalc(varSerialNumber1,billamt1,totalcount)
{
		// document.getElementById("discount"+varSerialNumber1+"").disabled=true;
		var varSerialNumber1 = varSerialNumber1;
		var billamt1 = billamt1;
		var totalcount=document.getElementById("totalrow").value;
		var grandtotaladjamt=0;

		var adjamount=document.getElementById("adjamount"+varSerialNumber1+"").value;
		var adjamount3=parseFloat(adjamount);

		var discount=document.getElementById("discount"+varSerialNumber1+"").value;
		var discount3=parseFloat(discount);
		if(discount=="") {
			var discount3=0;
		}
		if(adjamount=="" ){
			var adjamount3=0;
		}

		if((adjamount3+discount3) > billamt1)
		{
			alert("Please enter correct amount");
			// document.getElementById("totaladjamt").value = '0.00';
			document.getElementById("adjamount"+varSerialNumber1+"").value = '0.00';
			document.getElementById("balamount"+varSerialNumber1+"").value = (billamt1-discount3).toFixed(2);
			document.getElementById("adjamount"+varSerialNumber1+"").focus();

			for(i=1;i<=totalcount;i++)
				{
						var totaladjamount=document.getElementById("adjamount"+i+"").value;
						if(totaladjamount == "")
						{
							totaladjamount=0;
						}
						grandtotaladjamt=grandtotaladjamt+parseFloat(totaladjamount);
				
				}
				grandtotaladjamt=grandtotaladjamt.toFixed(2);
				grandtotaladjamt = grandtotaladjamt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				document.getElementById("totaladjamt").value=grandtotaladjamt;

			return false;
		}

		var balanceamount=parseFloat(billamt1)-(discount3+adjamount3);
		balanceamount=balanceamount.toFixed(2);
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
		// alert(grandtotaladjamt);
		grandtotaladjamt=grandtotaladjamt.toFixed(2);
		grandtotaladjamt = grandtotaladjamt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
		document.getElementById("totaladjamt").value=grandtotaladjamt;

		//alert(document.getElementById("totaladjamt").value);
		//alert(document.getElementById("receivableamount").value);
		// if((parseFloat(document.getElementById("amounttodisp").value.replace(/,/g,''))) < (parseFloat(document.getElementById("totaladjamt").value.replace(/,/g,''))))
		// {
		// 	document.getElementById("cumtotal").style.color="red";
		// 	}
		// 	else
		// 	{document.getElementById("cumtotal").style.color="black";}
		// document.getElementById("cumtotal").innerHTML=document.getElementById("totaladjamt").value;
}



</script>

<script type="text/javascript">





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

		document.getElementById("cbfrmflag1").value = "";

		return false;

	}

}





function funcPrintReceipt1()

{

	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

}

function FuncPopup()
{
	window.scrollTo(0,0);
	document.getElementById("imgloader").style.display = "";

}

function acknowledgevalid()

{

	document.getElementById("submit0").disabled=true;	

	FuncPopup();

	document.cbform1.submit();

}



function SearchAlloc()

{

	var searchbill2 = document.getElementById("searchbill2").value;

	if(searchbill2==''){

		alert("Enter Billno ");

		document.getElementById("searchbill2").focus();

		return false;

	}

	else{

		var docno = $('#docnumbers').val();

		window.location.href = "?docno="+docno+"&&searchbill2="+searchbill2;

	}

}



</script>



<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />      

<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/autocomplete.css">      

<script>

$(document).ready(function(e) {

	$("#searchbillno").click(function (e) {

	  

	  if (true) {

		  var Date1 = $('#ADate1').val();

	var Date2 = $('#ADate2').val();

	var date1 = new Date(Date1);

	var date2 = new Date(Date2);

	var timeDiff = Math.abs(date2.getTime() - date1.getTime());

	var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 

	// if(diffDays > 30)

	// {

	// 	alert("Select date range within 30 Days");

	// 	$('#ADate1').val('<?= $ADate1; ?>');

	// 	$('#ADate2').val('<?= $ADate2; ?>');

	// 	return false;

	// }

		var sbillno = '';

		$('#rowinsert').empty();

		$('#totalrow').val('1');

		var subanum = $('#searchsupplieranum').val();

		// var docno = $('#docnumbers').val();
		var docno = '';

		var totalrow = $('#totalrow').val();

		var ADate1 = $('#ADate1').val();

		var ADate2 = $('#ADate2').val();

		var Databuild = "subanum="+subanum+"&&billno="+sbillno+"&&docno="+docno+"&&totalrow="+totalrow+"&&ADate1="+ADate1+"&&ADate2="+ADate2;

		$.ajax({

			url: "crdradjust_searchallocbillno.php",

			type: "GET",

			data: Databuild,

			success: function(data){

				if(data != '')

				{	

					$('#rowinsert').append(data);

					var rowCount = $('#rowinsert tr').length;

					$('#totalrow').val(parseFloat(rowCount));

				}
				$("#imgloader").hide();

			}

		});

	  }

	});

	

	// $("#searchbill2").keydown(function (e) {

	//   if (e.keyCode == 13) {

	// 	var sbillno = this.value;

	// 	var accountnameano = $('#searchaccountnameano').val();

	// 	var docno = $('#docnumbers').val();

	// 	var totalrow = $('#totalrow1').val();

	// 	$('#rowinsert1').empty();

	// 	var Databuild = "accountnameano="+accountnameano+"&&billno="+sbillno+"&&docno="+docno+"&&totalrow="+totalrow;

	// 	$.ajax({

	// 		url: "searchdeallocbillno.php",

	// 		type: "GET",

	// 		data: Databuild,

	// 		success: function(data){

	// 			if(data != '')

	// 			{	

	// 				$('#rowinsert1').append(data);

	// 				var rowCount = $('#rowinsert1 tr').length;

	// 				$('#totalrow1').val(parseFloat(rowCount));

	// 				//$('#searchbill2').val('');

	// 			}

	// 		}

	// 	});

	//   }

	// });

	

	var totaladj = 0;

	

	$('#checkall').click(function(){

		var chk = $('#checkall').prop('checked');

		var chkcount = $('.chkalloc').length;

		 if (chk==true) {

			  $('.chkalloc').prop('checked',true);

			  for(var i=1; i<=chkcount; i++)

			  {

				$('#adjamount'+i).val($('#billamount'+i).val()); 

				totaladj = parseFloat(totaladj) + parseFloat($('#billamount'+i).val());

				$('#balamount'+i).val('0.00');
				$('#discount'+i).val('0.00');
				$('#totaldiscount').val('0.00');

			  }

			  totaladj=totaladj.toFixed(2);

			  totaladj = totaladj.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

			  $('#totaladjamt').val(totaladj);

	     } else {

		  	  $('.chkalloc').prop('checked', false);

			  for(var i=1; i<=chkcount; i++)

			  {

				$('#adjamount'+i).val('0.00');

				$('#balamount'+i).val('0.00'); 
				$('#discount'+i).val('0.00');

				$('#totaladjamt').val('0.00');
				$('#totaldiscount').val('0.00');

			  }

	     } 

	});

});



function DateValid1()

{

	var Date1 = $('#ADate1').val();

	var Date2 = $('#ADate2').val();

	var date1 = new Date(Date1);

	var date2 = new Date(Date2);

	var timeDiff = Math.abs(date2.getTime() - date1.getTime());

	var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 

	// if(diffDays > 30)

	// {

	// 	alert("Select date range within 30 Days");

	// 	$('#ADate1').val('<?= $ADate1; ?>');

	// 	$('#ADate2').val('<?= $ADate2; ?>');

	// 	return false;

	// }

}



</script>

<!-- <script src="js/datetimepicker_css.js"></script> -->
<!-- <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />      
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">  -->
<script>
$(document).ready(function(e) {
		$('#searchsuppliername').autocomplete({
	source:"ajaxaccountsub_search.php",
	//alert(source);
	matchContains: true,
	minLength:1,
	html: true, 
		select: function(event,ui){
			var accountname=ui.item.value;
			var accountid=ui.item.id;
			var accountanum=ui.item.anum;
			$("#searchsuppliercode").val(accountid);
			$("#searchsupplieranum").val(accountanum);
			$('#searchsuppliername').val(accountname);
			$('#searchsuppliername2').val(accountname);
			},
	});
});

$(document).ready(function(e) {
		$('#searchaccountname').autocomplete({
	source:"crdradjustment_ajaxaccout.php",
	// source:"ajaxaccount_search.php",
	//alert(source);
	matchContains: true,
	minLength:1,
	html: true, 
		select: function(event,ui){
			var accountname=ui.item.value;
			var accountid=ui.item.id;
			var accountanum=ui.item.anum;
			$("#searchaccountcode").val(accountid);
			$("#searchaccountanum").val(accountanum);
			
			},
    
	});
		
});

function check_search(){
	var subtype_anum = document.getElementById("searchsupplieranum").value;
	// var subtype_n = document.getElementById("searchsuppliername").value;
	if(subtype_anum==''){
	// if(subtype_anum=='' || subtype_n==''){
		alert('Please Select Subtype!');
		return false;
	}else{
		return FuncPopup();
	}
}



function validation_check()
{
	var total_amount=document.getElementById("totaladjamt").value;
	if(total_amount=='0.00' || total_amount==''){
		alert('Please! Check the Checkbox!');
		return false;
	}
	if(document.getElementById("searchaccountcode").value==''){
		alert('Please! Select Account!');
		return false;
	}
	var check = confirm('Are you sure you want to Save?');
        if (check == true) {
            return FuncPopup();
            // window.scrollTo(0,0);
			// document.getElementById("imgloader").style.display = "";
        }else{
            return false;
        }
}
</script>
<?php
if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }

if (isset($_REQUEST["searchsupplieranum"])) { $searchsupplieranum = $_REQUEST["searchsupplieranum"]; } else { $searchsupplieranum = ""; }


if (isset($_REQUEST["searchaccountname"])) { $searchaccountname = $_REQUEST["searchaccountname"]; } else { $searchaccountname = ""; }
if (isset($_REQUEST["searchaccountcode"])) { $searchaccountcode = $_REQUEST["searchaccountcode"]; } else { $searchaccountcode = ""; }
if (isset($_REQUEST["searchaccountanum"])) { $searchaccountanum = $_REQUEST["searchaccountanum"]; } else { $searchaccountanum = ""; }

$paynowbillprefix1 = 'CRDRADJ-';
$paynowbillprefix12=strlen($paynowbillprefix1);
$query23 = "select * from crdradjustment_summary order by auto_number desc limit 0, 1";
$exec23= mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$billnumber1 = $res23["docno"];
$billdigit1=strlen($billnumber1);
if ($billnumber1 == '')
{
	$billnumbercode1 ='CRDRADJ-'.'1';
}
else
{
	$billnumber1 = $res23["docno"];
	$billnumbercode1 = substr($billnumber1,$paynowbillprefix12, $billdigit1);
	//echo $billnumbercode;
	$billnumbercode1 = intval($billnumbercode1);
	$billnumbercode1 = $billnumbercode1 + 1;
	$maxanum1 = $billnumbercode1;
	$billnumbercode1 = 'CRDRADJ-'.$maxanum1;
}


?>
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

.imgloader { background-color:#FFFFFF; }

#imgloader1 {

    position: absolute;

    top: 158px;

    left: 487px;

    width: 28%;

    height: 24%;

}

</style>

</head>



<script src="js/datetimepicker_css.js"></script>



    <!-- Loading Overlay -->
    <div id="imgloader" class="loading-overlay" style="display:none;">
        <div class="loading-content">
            <div class="loading-spinner">
                <i class="fas fa-spinner fa-spin"></i>
            </div>
            <p><strong>Transaction in Progress</strong></p>
            <p>Please be patient...</p>
        </div>
    </div>

    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
    </header>

    <!-- User Information Bar -->
    <div class="user-info-bar">
        <div class="user-welcome">
            <span class="welcome-text">Welcome, <strong><?php echo htmlspecialchars($username); ?></strong></span>
            <span class="location-info">📍 Company: <?php echo htmlspecialchars($companyname); ?></span>
        </div>
        <div class="user-actions">
            <a href="mainmenu1.php" class="btn btn-outline">🏠 Main Menu</a>
            <a href="logout.php" class="btn btn-outline">🚪 Logout</a>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Home</a>
        <span>→</span>
        <span>Credit/Debit Adjustment</span>
    </nav>

    <!-- Floating Menu Toggle -->
    <div id="menuToggle" class="floating-menu-toggle">
        <i class="fas fa-bars"></i>
    </div>

    <!-- Main Container with Sidebar -->
    <div class="main-container-with-sidebar">
        <!-- Left Sidebar -->
        <aside id="leftSidebar" class="left-sidebar">
            <div class="sidebar-header">
                <h3>Quick Navigation</h3>
                <button id="sidebarToggle" class="sidebar-toggle">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="mainmenu1.php" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="labitem1master.php" class="nav-link">
                            <i class="fas fa-flask"></i>
                            <span>Lab Items</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="openingstockentry_master.php" class="nav-link">
                            <i class="fas fa-boxes"></i>
                            <span>Opening Stock</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addward.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Wards</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountreceivableentrylist.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>Account Receivable</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="corporateoutstanding.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Corporate Outstanding</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="accountstatement.php" class="nav-link">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Account Statement</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountsmain.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Accounts Main</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addaccountssub.php" class="nav-link">
                            <i class="fas fa-chart-pie"></i>
                            <span>Accounts Sub Type</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="fixedasset_acquisition_report.php" class="nav-link">
                            <i class="fas fa-building"></i>
                            <span>Fixed Asset Acquisition</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeinpatientlist.php" class="nav-link">
                            <i class="fas fa-bed"></i>
                            <span>Active Inpatient List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="activeusersreport.php" class="nav-link">
                            <i class="fas fa-users"></i>
                            <span>Active Users Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartofaccounts_upload.php" class="nav-link">
                            <i class="fas fa-upload"></i>
                            <span>Chart of Accounts Upload</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartaccountsmaindataimport.php" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Chart of Accounts Main Import</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="chartaccountssubdataimport.php" class="nav-link">
                            <i class="fas fa-database"></i>
                            <span>Chart of Accounts Sub Import</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addbloodgroup.php" class="nav-link">
                            <i class="fas fa-tint"></i>
                            <span>Blood Group Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addfoodallergy1.php" class="nav-link">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Food Allergy Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addgenericname.php" class="nav-link">
                            <i class="fas fa-pills"></i>
                            <span>Generic Name Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addpromotion.php" class="nav-link">
                            <i class="fas fa-percentage"></i>
                            <span>Promotion Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="addsalutation1.php" class="nav-link">
                            <i class="fas fa-user-tie"></i>
                            <span>Salutation Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="vat.php" class="nav-link">
                            <i class="fas fa-receipt"></i>
                            <span>VAT Master</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="payrollmonthwiseinterim.php" class="nav-link">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Payroll Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="internalreferallist.php" class="nav-link">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Internal Referral List</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="crdradjustment.php" class="nav-link">
                            <i class="fas fa-balance-scale"></i>
                            <span>Credit/Debit Adjustment</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php if (!empty($errmsg)): ?>
                    <div class="alert alert-<?php echo $bgcolorcode === 'success' ? 'success' : ($bgcolorcode === 'failed' ? 'error' : 'info'); ?>">
                        <i class="fas fa-<?php echo $bgcolorcode === 'success' ? 'check-circle' : ($bgcolorcode === 'failed' ? 'exclamation-triangle' : 'info-circle'); ?> alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Credit/Debit Adjustment</h2>
                    <p>Process credit and debit adjustments for patient accounts and transactions.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div>

            <!-- Adjustment Form Section -->
            <div class="adjustment-form-section">
                <div class="form-header">
                    <i class="fas fa-balance-scale form-icon"></i>
                    <h3 class="form-title">Credit/Debit Adjustment Form</h3>
                </div>
                
                <div class="form-info">
                    <div class="info-item">
                        <strong>Document Number:</strong> 
                        <span class="doc-number"><?php echo $billnumbercode1; ?></span>
                    </div>
                </div>
                
                <form name="cbform1" method="post" action="crdradjustment.php" class="adjustment-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchsuppliername" class="form-label">Subtype</label>
                            <input name="searchsuppliername" type="text" id="searchsuppliername" 
                                   class="form-input" value="<?php echo htmlspecialchars($searchsuppliername); ?>" 
                                   placeholder="Search subtype..." autocomplete="off">
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <div class="date-input-group">
                                <input name="ADate1" id="ADate1" class="form-input" 
                                       value="<?php echo $transactiondatefrom; ?>" 
                                       readonly="readonly" onKeyDown="return disableEnterKey()">
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" 
                                     class="calendar-icon" style="cursor:pointer"/>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <div class="date-input-group">
                                <input name="ADate2" id="ADate2" class="form-input" 
                                       value="<?php echo $transactiondateto; ?>" 
                                       readonly="readonly" onKeyDown="return disableEnterKey()">
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" 
                                     class="calendar-icon" style="cursor:pointer"/>
                            </div>
                        </div>
                        
                        <div class="form-group form-group-submit">
                            <button type="button" name="searchbillno" id="searchbillno" 
                                    class="submit-btn" onClick="return check_search()">
                                <i class="fas fa-search"></i>
                                Search Bills
                            </button>
                            <button type="reset" name="resetbutton" class="btn btn-secondary">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                        </div>
                    </div>
                    
                    <!-- Hidden fields -->
                    <input type="hidden" name="searchsuppliercode" id="searchsuppliercode" 
                           value="<?php echo htmlspecialchars($searchsuppliercode); ?>">
                    <input type="hidden" name="searchsupplieranum" id="searchsupplieranum" 
                           value="<?php echo htmlspecialchars($searchsupplieranum); ?>">
                </form>
            </div>

	

      
            <!-- Pending Invoices Section -->
            <div class="pending-invoices-section">
                <div class="section-header">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <h3>Pending Invoices for Adjustment</h3>
                </div>
                
                <form action="crdradjustment.php" method="post" name="form2" class="adjustment-form">
                    <!-- Hidden fields -->
                    <input type="hidden" name="docnumber" value="<?php echo $billnumbercode1; ?>">
                    <input name="searchsuppliername2" type="hidden" id="searchsuppliername2" 
                           value="<?php echo htmlspecialchars($searchsuppliername); ?>">
                    <input type="hidden" name="searchsuppliercode" id="searchsuppliercode" 
                           value="<?php echo htmlspecialchars($searchsuppliercode); ?>">
                    <input type="hidden" name="searchsupplieranum" id="searchsupplieranum" 
                           value="<?php echo htmlspecialchars($searchsupplieranum); ?>">
                    
                    <!-- Table Container -->
                    <div class="table-container">
                        <table class="adjustment-table">
                            <thead>
                                <tr>
                                    <th class="serial-header">No.</th>
                                    <th class="select-header">
                                        <input type="checkbox" name="checkall" id="checkall" class="checkall" value="1">
                                        Select All
                                    </th>
                                    <th class="patient-header">Patient</th>
                                    <th class="account-header">Account</th>
                                    <th class="bill-header">Bill No</th>
                                    <th class="date-header">Bill Date</th>
                                    <th class="pending-header">Pending</th>
                                    <th class="transfer-header">Transfer Amt</th>
                                    <th class="balance-header">Bal Amt</th>
                                </tr>
                            </thead>
                            <tbody id="rowinsert">
                                <!-- Dynamic content will be inserted here -->
                            </tbody>
                            <tfoot>
                                <tr class="totals-row">
                                    <td colspan="6" class="totals-label">Total:</td>
                                    <td class="totals-amount pending-total">
                                        <span id="totalPending">0.00</span>
                                    </td>
                                    <td class="totals-amount transfer-total">
                                        <input type="text" name="totaladjamt" id="totaladjamt" 
                                               class="total-input" readonly>
                                    </td>
                                    <td class="totals-amount balance-total">
                                        <span id="totalBalance">0.00</span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <input type="hidden" name="totalrow" id="totalrow" value="0">
                    <input type="hidden" name="totaldiscount" id="totaldiscount">
                </form>
            </div>

            

            <?php

			$number = 0;

			$totalbalance = '';

			$sno = 0;

			

			 $cashamount21 = 0.00;

			$cardamount21 = '';

			$onlineamount21 = '';

			$chequeamount21 = '';

			$tdsamount21 = '';

			$writeoffamount21 = '';

		$totalrefundedamount=0;

			$totalnumbr='';

			$totalnumb=0;

			$dotarray = explode("-", $transactiondateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			$totalpurchase1=0;

			

			if (isset($_REQUEST["showbilltype"])) { $showbilltype = $_REQUEST["showbilltype"]; } else { $showbilltype = ""; }

			if ($showbilltype == 'All Bills')

			{

				$showbilltype = '';

			}			

			$num=0;

			$ssno = 0;

		

			$cashamount21 = 0.00;

			$cardamount21 = '';

			$onlineamount21 = '';

			$chequeamount21 = '';

			$tdsamount21 = '';

			$writeoffamount21 = '';

		$totalrefundedamount=0;

			$totalnumbr='';

			$totalnumbipf=0;

			?>

            <tbody id="rowinsert">

            </tbody>

            <tr>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

                <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

            

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong>

                <?php //echo number_format($netpaymentamount, 2); ?>

              </strong></div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong><?php if ($totalbalance != '') echo number_format($totalbalance,2,'.',','); ?></strong></div></td>

           

             <!-- <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ecf0f5"> -->
             	<input type="hidden" name="totaldiscount" id="totaldiscount" size="7" class="bal" readonly>
             <!-- </td> -->

               <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ecf0f5"><input type="text" name="totaladjamt" id="totaladjamt" size="7" class="bal" readonly></td>

             <!-- <td class="bodytext311" valign="center" bordercolor="#f3f3f3" bgcolor="#ecf0f5">&nbsp;</td> -->

             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"  bgcolor="#ecf0f5">&nbsp;<input type="hidden" name="totalrow" id="totalrow" value="<?php echo $sno; ?>"></td>

			</tr>

          

	  

	  <!-- <tr> <td>&nbsp;	  </td> </tr> -->
	



	  <tr>
              <td colspan="4" align="right" valign="middle"  class="bodytext3">Search Account </td>
              <td width="82%" colspan="3" align="left" valign="top" ><span class="bodytext3">
              <input name="searchaccountname" type="text" id="searchaccountname" value="<?php echo $searchaccountname; ?>" size="50" autocomplete="off">
			  <input type="hidden" name="searchaccountcode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchaccountcode" style="text-transform:uppercase" value="<?php echo $searchaccountcode; ?>" size="20" />
			   <input name="searchaccountanum" type="hidden" id="searchaccountanum" value="<?php echo $searchaccountanum; ?>" size="50" autocomplete="off">
              </span></td>
           </tr>


	  <tr>

	  <td colspan="9" width="1002"align="right" valign="top"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                      

                      <input type="hidden" name="frmflag23" value="frmflag23">

                      <input name="Submit" type="submit"  value="Save" class="button" id="submit1" onClick="return validation_check();"style="border: 1px solid #001E6A"/>

       </font></td>

	  </tr>
           
 
	 </form>

	   </tbody>

      </table>

            <!-- Account Search Section -->
            <div class="account-search-section">
                <div class="section-header">
                    <i class="fas fa-search"></i>
                    <h3>Target Account Selection</h3>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="searchaccountname" class="form-label">Search Account</label>
                        <input name="searchaccountname" type="text" id="searchaccountname" 
                               class="form-input" value="<?php echo htmlspecialchars($searchaccountname); ?>" 
                               placeholder="Search target account..." autocomplete="off">
                        <input type="hidden" name="searchaccountcode" id="searchaccountcode" 
                               value="<?php echo htmlspecialchars($searchaccountcode); ?>">
                        <input name="searchaccountanum" type="hidden" id="searchaccountanum" 
                               value="<?php echo htmlspecialchars($searchaccountanum); ?>">
                    </div>
                </div>
            </div>

            <!-- Submit Section -->
            <div class="submit-section">
                <div class="submit-actions">
                    <input type="hidden" name="frmflag23" value="frmflag23">
                    <button type="submit" name="Submit" class="submit-btn" id="submit1" onClick="return validation_check();">
                        <i class="fas fa-save"></i>
                        Process Adjustment
                    </button>
                </div>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/crdr-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>




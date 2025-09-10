<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$updatedate = date('Y-m-d');

$suppliername="";

$errmsg = "";

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



if (isset($_REQUEST["searchbill2"])) { $searchbill2 = $_REQUEST["searchbill2"]; } else { $searchbill2 = ""; }

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

if ($frm1submit1 == 'frm1submit1')

{

$docnum = $_REQUEST['docno'];


foreach($_POST['billnum2'] as $key => $value)
		{
		$billnum2=$_POST['billnum2'][$key];
		$subtypeano=$_POST['subtypeano123'][$key];
		 $accountnameid=$_POST['accountnameid123'][$key];
		foreach($_POST['acknow1'] as $check1)
		{
		 $acknow1=$check1;
		// exit();
			$dotarray = explode("||", $acknow1);
			$cbilln = $dotarray[0];
			$caccountid = $dotarray[1];

		if($cbilln==$billnum2 && $accountnameid==$caccountid )
		{

		 $query8="update master_transactionpaylater set recordstatus = 'deallocated', acc_flag = '1' where docno='$docnum' and billnumber='$billnum2' and recordstatus = 'allocated' and accountnameid='$accountnameid' and subtypeano='$subtypeano'";
		$exec8=mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$query991="update billing_ipprivatedoctor set billstatus='unpaid' where docno='$billnum2' ";
		$exec991=mysqli_query($GLOBALS["___mysqli_ston"], $query991);

		 $query84="update master_transactionpaylater set acc_flag = '0' where billnumber='$billnum2' and recordstatus <> 'deallocated' and accountnameid='$accountnameid' and subtypeano='$subtypeano'";
		$exec84=mysqli_query($GLOBALS["___mysqli_ston"], $query84) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		}

		}

		}

header("location:accountreceivableentry.php?docno=$docnum");

}



if (isset($_REQUEST["frmflag23"])) { $frmflag23 = $_REQUEST["frmflag23"]; } else { $frmflag23 = ""; }

//$frmflag2 = $_POST['frmflag2'];



if ($frmflag23 == 'frmflag23')

{



$docnum1 = $_REQUEST['docno1'];

$date1 = $_REQUEST['date1'];

$bankname1 = $_REQUEST['bankname1'];

$number1 = $_REQUEST['number1'];

$paymentmode = $_REQUEST['paymentmode'];

$receivableamount = $_REQUEST['receivableamount1'];

$receivableamount=str_replace(',', '', $receivableamount);



$currency = 'Uganda Shillings';

foreach($_POST['billnum'] as $key => $value)

		{

		$billnum=$_POST['billnum'][$key];

		$name=$_POST['name'][$key];

		$patientcode=$_POST['patientcode'][$key];

		$visitcode=$_POST['visitcode'][$key];

		$doctorname=$_POST['doctorname'][$key];

		//echo $doctorname;

		$accountname = '';
		// $accountname = $_REQUEST['ar_accountname'][$key];

		$accountnameid = $_REQUEST['accountnameid'][$key];

		$accountnameano = $_REQUEST['accountnameano'][$key];

		$balamount=$_POST['balamount'][$key];

		$balamount=str_replace(',', '', $balamount);

		$query55 = "select * from master_accountname where auto_number='$accountnameano'";

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

		//echo $balamount;

		if($balamount == 0.00)

		{

		$billstatus='paid';

		}

		else

		{

		$billstatus='unpaid';

		}

		$billnumberprefix = '';

		$billnumber = '';

		$billanum = '';

		$remarks = '';

		$bankbranch = '';

		$transactionmodule = '';

		//echo $billstatus;

		$adjamount=$_POST['adjamount'][$key];
		$discount=$_POST['discount'][$key];

		$adjamount=str_replace(',', '', $adjamount);

		foreach($_POST['ack'] as $check)

		{

		$acknow=$check;

		$dotarray = explode("||", $acknow);
			$cbilln = $dotarray[0];
			$caccountid = $dotarray[1];

		if($cbilln==$billnum && $accountnameid==$caccountid )
			// && $subtypeano==$subtypeano
		{
		 $query99="update billing_paylater set billstatus='$billstatus' where billno='$billnum'";
		$exec99=mysqli_query($GLOBALS["___mysqli_ston"], $query99);

		 $query89="update refund_paylater set billstatus='$billstatus' where finalizationbillno='$billnum'";
		$exec99=mysqli_query($GLOBALS["___mysqli_ston"], $query89);

		 $query991="update billing_ipprivatedoctor set billstatus='$billstatus' where docno='$billnum'";
		$exec991=mysqli_query($GLOBALS["___mysqli_ston"], $query991);

		 $query992="update billing_paylaterreferal set billstatus='$billstatus' where billnumber='$billnum'";
		$exec992=mysqli_query($GLOBALS["___mysqli_ston"], $query992);

		 $query892="update billing_ipservices set billstatus='$billstatus' where billnumber='$billnum'";
		$exec892=mysqli_query($GLOBALS["___mysqli_ston"], $query892);

		  $query9912="update master_transactionpaylater set acc_flag='1' where billnumber='$billnum' and transactiontype='finalize' and accountnameid='$accountnameid' and subtypeano='$subtypeano' ";
		$exec9912=mysqli_query($GLOBALS["___mysqli_ston"], $query9912);

		 $query99122="update master_transactionpaylater set acc_flag='1' where billnumber='$billnum' and transactiontype='PAYMENT' and recordstatus = 'allocated'  and accountnameid='$accountnameid' and subtypeano='$subtypeano' ";
		$exec99122=mysqli_query($GLOBALS["___mysqli_ston"], $query99122);

		// exit();

		 $query87 ="select * from master_transactionpaylater where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1' and recordstatus = 'allocated' and accountnameid='$accountnameid' and subtypeano='$subtypeano' " ;
		$exec87 = mysqli_query($GLOBALS["___mysqli_ston"], $query87) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num87 = mysqli_num_rows($exec87);
		// exit();
		if($num87 == 0)
		{
		
		if($adjamount != 0 || $adjamount != 0.00)
		{

		if ($paymentmode == 'CASH')
		{

		$transactiontype = 'PAYMENT';

		$transactionmode = 'CASH';

		$particulars = 'BY CASH '.$billnumberprefix.$billnumber.'';	

		

		$query9 = "insert into master_transactionpaylater (transactiondate, particulars, 

		transactionmode, transactiontype, transactionamount, cashamount,

		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 

		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,billbalanceamount,recordstatus,receivableamount,paymenttype,subtype,username,accountnameano,accountnameid,locationcode,locationname,subtypeano,accountcode,currency,fxrate,fxamount,discount) 

		values ('$updatedatetime', '$particulars', 

		'$transactionmode', '$transactiontype', '$adjamount', '$adjamount', 

		'$billnum',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 

		'$transactionmodule','$name','$patientcode','$visitcode','$accountname','$doctorname','$billstatus','$docnum1','$balamount','allocated','$receivableamount','$patienttype11','$patientsubtype11','$username','$accountnameano','$accountnameid','$res12locationcode','$res12location','$subtypeano','$accountnameid','$currency','1','$adjamount','$discount')";

		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

		}

		if ($paymentmode == 'ONLINE')

		{

		$transactiontype = 'PAYMENT';

		$transactionmode = 'ONLINE';

		$particulars = 'BY ONLINE '.$billnumberprefix.$billnumber.'';	

	

		$query9 = "insert into master_transactionpaylater (transactiondate, particulars,

		transactionmode, transactiontype, transactionamount, onlineamount,

		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 

		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,billbalanceamount,recordstatus,receivableamount,paymenttype,subtype,username,accountnameano,accountnameid,locationcode,locationname,subtypeano,accountcode,currency,fxrate,fxamount,discount) 

		values ('$updatedatetime','$particulars', 

		'$transactionmode', '$transactiontype', '$adjamount', '$adjamount', 

		'$billnum',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 

		'$transactionmodule','$name','$patientcode','$visitcode','$accountname','$doctorname','$billstatus','$docnum1','$balamount','allocated','$receivableamount','$patienttype11','$patientsubtype11','$username','$accountnameano','$accountnameid','$res12locationcode','$res12location','$subtypeano','$accountnameid','$currency','1','$adjamount','$discount')";

		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));



		}

		if ($paymentmode == 'CHEQUE')

		{

		$transactiontype = 'PAYMENT';

		$transactionmode = 'CHEQUE';

		$particulars = 'BY CHEQUE '.$billnumberprefix.$billnumber;		

	

		$query9 = "insert into master_transactionpaylater (transactiondate, particulars,

		transactionmode, transactiontype, transactionamount,

		chequeamount,chequenumber, billnumber, billanum, 

		chequedate, bankname, bankbranch, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 

		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,billbalanceamount,recordstatus,receivableamount,paymenttype,subtype,username,accountnameano,accountnameid,locationcode,locationname,subtypeano,accountcode,currency,fxrate,fxamount,discount) 

		values ('$updatedatetime', '$particulars', 

		'$transactionmode', '$transactiontype', '$adjamount',

		'$adjamount','$number1',  '$billnum',  '$billanum', 

		'$date1', '$bankname1', '$bankbranch','$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', 

		'$remarks', '$transactionmodule','$name','$patientcode','$visitcode','$accountname','$doctorname','$billstatus','$docnum1','$balamount','allocated','$receivableamount','$patienttype11','$patientsubtype11','$username','$accountnameano','$accountnameid','$res12locationcode','$res12location','$subtypeano','$accountnameid','$currency','1','$adjamount','$discount')";

		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

	

		}

		if ($paymentmode == 'WRITEOFF')

		{

		$transactiontype = 'PAYMENT';

		$transactionmode = 'WRITEOFF';

		$particulars = 'BY WRITEOFF '.$billnumberprefix.$billnumber;		

		

		$query9 = "insert into master_transactionpaylater (transactiondate, particulars,  

		transactionmode, transactiontype, transactionamount, writeoffamount,

		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 

		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,billbalanceamount,recordstatus,receivableamount,paymenttype,subtype,username,accountnameano,accountnameid,locationcode,locationname,subtypeano,accountcode,currency,fxrate,fxamount,discount) 

		values ('$updatedatetime', '$particulars',

		'$transactionmode', '$transactiontype', '$adjamount', '$adjamount', 

		'$billnum',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 

		'$transactionmodule','$name','$patientcode','$visitcode','$accountname','$doctorname','$billstatus','$docnum1','$balamount','allocated','$receivableamount','$patienttype11','$patientsubtype11','$username','$accountnameano','$accountnameid','$res12locationcode','$res12location','$subtypeano','$accountnameid','$currency','1','$adjamount','$discount')";

		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));



		}

		if ($paymentmode == 'By Credit Note')

		{

		$transactiontype = 'PAYMENT';

		$transactionmode = 'CREDIT NOTE';

		$particulars = 'BY CREDIT NOTE '.$billnumberprefix.$billnumber;		

	

		$query9 = "insert into master_transactionpaylater (transactiondate, particulars,  

		transactionmode, transactiontype, transactionamount, writeoffamount,

		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 

		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,billbalanceamount,recordstatus,receivableamount,paymenttype,subtype,username,accountnameano,accountnameid,locationcode,locationname,subtypeano,accountcode,currency,fxrate,fxamount,discount) 

		values ('$updatedatetime', '$particulars',

		'$transactionmode', '$transactiontype', '$adjamount', '$adjamount', 

		'$billnum',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 

		'$transactionmodule','$name','$patientcode','$visitcode','$accountname','$doctorname','$billstatus','$docnum1','$balamount','allocated','$receivableamount','$patienttype11','$patientsubtype11','$username','$accountnameano','$accountnameid','$res12locationcode','$res12location','$subtypeano','$accountnameid','$currency','1','$adjamount','$discount')";

		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));



		}

		}

		}

		else

		{

		$totalaadjamount =0;
		$totaladiscount=0;

		$query67 = "select * from master_transactionpaylater where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1' and accountnameid='$accountnameid' and subtypeano='$subtypeano' ";

		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		while($res67 = mysqli_fetch_array($exec67))

		{

		$existingamt = $res67['transactionamount'];
		$existingdiscount = $res67['discount'];

		$totalaadjamount = $totalaadjamount + $existingamt;

		if($existingdiscount==""){  $existingdiscount=0; }
		$totaladiscount = $totaladiscount + $existingdiscount;

		}

		$restotalaadjamount = $totalaadjamount + $adjamount;
		$restotaladiscount = $totaladiscount + $discount;

	
		if ($paymentmode == 'CASH')
		{
		 $query45 = "update master_transactionpaylater set recordstatus='allocated',transactionamount='$restotalaadjamount',fxamount = '$restotalaadjamount',cashamount='$restotalaadjamount',billbalanceamount='$balamount',transactiondate='$updatedatetime',username='$username', discount='$restotaladiscount' where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1' and accountnameid='$accountnameid' and subtypeano='$subtypeano' ";

		$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		}


		if ($paymentmode == 'ONLINE')

		{

		 $query45 = "update master_transactionpaylater set recordstatus='allocated',transactionamount='$restotalaadjamount',fxamount = '$restotalaadjamount',onlineamount='$restotalaadjamount',billbalanceamount='$balamount',transactiondate='$updatedatetime',username='$username', discount='$restotaladiscount' where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1' and accountnameid='$accountnameid' and subtypeano='$subtypeano' ";

		$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

    	}

		if ($paymentmode == 'CHEQUE')

		{

		 $query45 = "update master_transactionpaylater set recordstatus='allocated',transactionamount='$restotalaadjamount',fxamount = '$restotalaadjamount',chequeamount='$restotalaadjamount',billbalanceamount='$balamount',transactiondate='$updatedatetime',username='$username', discount='$restotaladiscount' where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1' and accountnameid='$accountnameid' and subtypeano='$subtypeano' ";

		$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

    

		}

		if ($paymentmode == 'WRITEOFF')

		{

		 $query45 = "update master_transactionpaylater set recordstatus='allocated',transactionamount='$restotalaadjamount',fxamount = '$restotalaadjamount',writeoffamount='$restotalaadjamount',billbalanceamount='$balamount',transactiondate='$updatedatetime',username='$username', discount='$restotaladiscount' where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1' and accountnameid='$accountnameid' and subtypeano='$subtypeano' ";

		$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

    	

		}

		if ($paymentmode == 'By Credit Note')

		{

		 $query45 = "update master_transactionpaylater set recordstatus='allocated',transactionamount='$restotalaadjamount',fxamount = '$restotalaadjamount',writeoffamount='$restotalaadjamount',billbalanceamount='$balamount',transactiondate='$updatedatetime',username='$username', discount='$restotaladiscount' where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1' and accountnameid='$accountnameid' and subtypeano='$subtypeano' ";

		$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

    	

		}

		 $query9912="update master_transactionpaylater set acc_flag='0' where billnumber='$billnum' and recordstatus='allocated' and transactiontype='finalize'  ";

		$exec9912=mysqli_query($GLOBALS["___mysqli_ston"], $query9912);

		}

	}

	}

	}

	header("location:accountreceivableentry.php?docno=$docnum1");
	// exit();

}



include ("autocompletebuild_accounts1.php");



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

if(isset($_REQUEST['docno']))

{

$docno = $_REQUEST['docno'];

}

$totalamount=0;

// $query5="select * from master_transactionpaylater where docno='$docno' group by docno";
$query5="select * from master_transactionpaylater where docno='$docno' ORDER BY `auto_number` ASC limit 1 ";

$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res5 = mysqli_fetch_array($exec5);

$entrydate = $res5['transactiondate'];

$totalamount = $res5['receivableamount'];		  

$receivableamount = $totalamount;

$paymentmode = $res5['transactionmode'];
$transactiontype = $res5['transactiontype'];

if($paymentmode == '')

{

$paymentmode = 'By Credit Note';

}

$number = $res5['chequenumber'];

$date = $res5['chequedate'];

$bankname = $res5['bankname'];

$suppliername = $res5['accountname'];

$accountnameano = $res5['accountnameano'];
$accountnameid = $res5['accountnameid'];
$subtypeano = $res5['subtypeano'];

if($transactiontype=='paylatercredit'){
	$totalamount = $res5['fxamount'];
}


$query11 = "select sum(transactionamount) as total11 from master_transactionpaylater where docno='$docno' and recordstatus='allocated'";

$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

$num11 = mysqli_num_rows($exec11);

$res11 = mysqli_fetch_array($exec11);

$total11 = $res11['total11'];

$total11=str_replace(',', '', $total11);

$totalamount=str_replace(',', '', $totalamount);

// $totalamount = (int) $totalamount;

// $total11 = (int) $total11;

$amounttodisp=$totalamount-$total11;

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

.cumtotal{position:fixed}

-->

</style>

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<script>

function openCity(evt, cityName) {

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

    evt.currentTarget.className += " active";

	

	//alert(cityName); 

	var elements = document.getElementsByClassName("hiddenclass");

	if(cityName == "emrtabid"){

		for(var i=0; i<elements.length; i++) { 

		elements[i].style.display='none';

		}

	}else{

		for(var i=0; i<elements.length; i++) { 

		elements[i].style.display='block';

		}

	}

}

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

// var amounttodisp1=document.getElementById("amounttodisp").value;
// var cumtotal1=document.getElementById("cumtotal").value;


var amounttodisp1=parseFloat(document.getElementById("amounttodisp").value.replace(/,/g,''));
var cumtotal1=parseFloat(document.getElementById("cumtotal").innerHTML.replace(/,/g,''));


var billamt = billamt;

  var textbox = document.getElementById("adjamount"+varSerialNumber+"");

    textbox.value = "";
    document.getElementById("discount"+varSerialNumber+"").value = "";
    document.getElementById("balamount"+varSerialNumber+"").value = "";

if(document.getElementById("acknowpending"+varSerialNumber+"").checked == true)

{


    if(document.getElementById("acknowpending"+varSerialNumber+"").checked) {
    	// var bal_amount= parseFloat(amounttodisp1)-parseFloat(cumtotal1);
    	var bal_amount= amounttodisp1-cumtotal1;
    	// alert(amounttodisp1);
    	// alert(cumtotal1);
    	// alert(bal_amount);
    	if(bal_amount<0){
    		textbox.value = '0.00';
    			alert('Amount Exceed!');
				 document.getElementById("acknowpending"+varSerialNumber+"").checked = false;
				  document.getElementById("discount"+varSerialNumber+"").value = "";
			    document.getElementById("balamount"+varSerialNumber+"").value = "";
			    document.getElementById("adjamount"+varSerialNumber+"").value = "";
				 return false;
    	}else{
		    	if(billamt>parseFloat(bal_amount)){
		    		// if((parseFloat(document.getElementById("billamt").value.replace(/,/g,''))) < (parseFloat(document.getElementById("totaladjamt").value.replace(/,/g,''))))
		    		textbox.value = bal_amount.toFixed(2);
		    		// textbox.value = billamt-bal_amount;
		    	}
		    	else{
		    		 textbox.value = billamt;
		    	}
		    }
       

    }
    	var bal_amount= amounttodisp1-cumtotal1;
			if(bal_amount=='0'){
			 alert('Amount Exceed!');
			 document.getElementById("acknowpending"+varSerialNumber+"").checked = false;
			  document.getElementById("discount"+varSerialNumber+"").value = "";
		    document.getElementById("balamount"+varSerialNumber+"").value = "";
		    document.getElementById("adjamount"+varSerialNumber+"").value = "";
			 return false;
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

//alert(grandtotaladjamt);

grandtotaladjamt2=grandtotaladjamt2.toFixed(2);

grandtotaladjamt2 = grandtotaladjamt2.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

document.getElementById("totaladjamt").value=grandtotaladjamt2;



if((parseFloat(document.getElementById("receivableamount").value.replace(/,/g,''))) < (parseFloat(document.getElementById("totaladjamt").value.replace(/,/g,''))))

{

	document.getElementById("cumtotal").style.color="red";

	}

	else

	{document.getElementById("cumtotal").style.color="black";}

document.getElementById("cumtotal").innerHTML=document.getElementById("totaladjamt").value;
// document.getElementById("cumtotal").value=document.getElementById("totaladjamt").value;

return false;



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



document.getElementById("totaladjamt").value=grandtotaladjamt2.toFixed(2);

if((parseFloat(document.getElementById("receivableamount").value.replace(/,/g,''))) < (parseFloat(document.getElementById("totaladjamt").value.replace(/,/g,''))))

{

	document.getElementById("cumtotal").style.color="red";

	}

	else

	{document.getElementById("cumtotal").style.color="black";}

document.getElementById("cumtotal").innerHTML=document.getElementById("totaladjamt").value;

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
if((parseFloat(checkamount)) > (parseFloat(amounttodisp)))

{

alert("Allocated amount is greater than Receivable amount");

document.getElementById("submit1").disabled=false;

return false;

}

var checkamount2 = parseInt(checkamount) + parseInt(grandtotalamt1);

var checkamount1= document.getElementById("receivableamount").value;

if(parseInt(checkamount2) > parseInt(checkamount1))

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

function balancecalc(varSerialNumber1,billamt1,totalcount)
{
	document.getElementById("adjamount"+varSerialNumber1+"").disabled=true;
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
		if((discount3+adjamount3) > billamt1)
		{
			alert("Please enter correct amount");
			document.getElementById("totaladjamt").value = '0.00';
			document.getElementById("adjamount"+varSerialNumber1+"").value = '0.00';
			var balance_after =  billamt1-discount3;
			document.getElementById("balamount"+varSerialNumber1+"").value = balance_after.toFixed(2);
			// document.getElementById("balamount"+varSerialNumber1+"").value = billamt1;
			document.getElementById("adjamount"+varSerialNumber1+"").focus();
			return false;
		}
		var balanceamount=parseFloat(billamt1)-(discount3+adjamount3);
		alert(balanceamount);
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

		grandtotaladjamt=grandtotaladjamt.toFixed(2);
		grandtotaladjamt = grandtotaladjamt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
		document.getElementById("totaladjamt").value=grandtotaladjamt;
}

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
			document.getElementById("totaladjamt").value = '0.00';
			document.getElementById("adjamount"+varSerialNumber1+"").value = '0.00';
			document.getElementById("balamount"+varSerialNumber1+"").value = (billamt1-discount3).toFixed(2);
			document.getElementById("adjamount"+varSerialNumber1+"").focus();
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

		grandtotaladjamt=grandtotaladjamt.toFixed(2);
		grandtotaladjamt = grandtotaladjamt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
		document.getElementById("totaladjamt").value=grandtotaladjamt;

		//alert(document.getElementById("totaladjamt").value);
		//alert(document.getElementById("receivableamount").value);
		if((parseFloat(document.getElementById("amounttodisp").value.replace(/,/g,''))) < (parseFloat(document.getElementById("totaladjamt").value.replace(/,/g,''))))
		{
			document.getElementById("cumtotal").style.color="red";
			}
			else
			{document.getElementById("cumtotal").style.color="black";}
		document.getElementById("cumtotal").innerHTML=document.getElementById("totaladjamt").value;
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

		var accountnameano = $('#searchaccountnameano').val();

		var docno = $('#docnumbers').val();

		var totalrow = $('#totalrow').val();

		var ADate1 = $('#ADate1').val();

		var ADate2 = $('#ADate2').val();

		var Databuild = "accountnameano="+accountnameano+"&&billno="+sbillno+"&&docno="+docno+"&&totalrow="+totalrow+"&&ADate1="+ADate1+"&&ADate2="+ADate2;

		$.ajax({

			url: "searchallocbillno.php",

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

	

	$("#searchbill2").keydown(function (e) {

	  if (e.keyCode == 13) {

		var sbillno = this.value;

		var accountnameano = $('#searchaccountnameano').val();

		var docno = $('#docnumbers').val();

		var totalrow = $('#totalrow1').val();

		$('#rowinsert1').empty();

		var Databuild = "accountnameano="+accountnameano+"&&billno="+sbillno+"&&docno="+docno+"&&totalrow="+totalrow;

		$.ajax({

			url: "searchdeallocbillno.php",

			type: "GET",

			data: Databuild,

			success: function(data){

				if(data != '')

				{	

					$('#rowinsert1').append(data);

					var rowCount = $('#rowinsert1 tr').length;

					$('#totalrow1').val(parseFloat(rowCount));

					//$('#searchbill2').val('');

				}

			}

		});

	  }

	});

	

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



<body>

<div align="center" class="imgloader" id="imgloader" style="display:none;">

<div align="center" class="imgloader" id="imgloader1" style="display:;">

<p style="text-align:center;"><strong>Transaction in Progress <br><br> Please be patience...</strong></p>

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

    <td width="97%" valign="top"><table border="0" cellspacing="0" cellpadding="0">

	

	

	

      <tr>

        <td width="709">

        

             

			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="709" 

            align="left" border="0">

          <tbody>

		  

		  <tr>

	<td class="bodytext31" valign="center"  align="left" width="12%"><strong>DOC No

	  

	</strong></td>

	<td class="bodytext31" valign="center"  align="left"><input type="hidden" name="docnumbers" id="docnumbers" value="<?php echo $docno; ?>" size="6" class="bal"><?php echo $docno; ?></td>

	

	<td class="bodytext31" valign="center"  align="left"><strong>Account Name</strong></td>

	<td class="bodytext31" valign="center"  align="left" colspan="4"><?php echo $suppliername; ?></td>

	</tr>

	<tr>

	<td class="bodytext31" valign="center"  align="left" width="12%"><strong>Entry Date</strong></td>

	<td class="bodytext31" valign="center"  align="left"><input type="hidden" name="entrydate" value="<?php echo $entrydate; ?>" size="6" class="bal"><?php echo $entrydate; ?></td>

	<td class="bodytext31" valign="center"  align="left" width="14%"><strong>Amount</strong></td>

	<td class="bodytext31" valign="center"  align="left"><input type="hidden" name="receivableamount" id="receivableamount" value="<?php echo $receivableamount; ?>" size="6" class="bal"><?php echo number_format($receivableamount,2,'.',','); ?></td>

	<td class="bodytext31" valign="center"  align="left" width="14%"><strong>Payment Mode</strong></td>

	<td class="bodytext31" valign="center"  align="left"><input type="hidden" name="paymentmode" value="<?php echo $paymentmode; ?>" size="6" class="bal"><?php echo $paymentmode; ?></td>



	</tr>

	<tr>

	<td class="bodytext31" valign="center"  align="left" width="12%"><strong>Number</strong></td>

	<td class="bodytext31" valign="center"  align="left"><input type="hidden" name="number" value="<?php echo $number; ?>" size="6" class="bal"><?php echo $number; ?></td>

	<td class="bodytext31" valign="center"  align="left" width="14%"><strong>Date</strong></td>

	<td class="bodytext31" valign="center"  align="left"><input type="hidden" name="date" value="<?php echo $date; ?>" size="6" class="bal"><?php echo $date; ?></td>

	<td class="bodytext31" valign="center"  align="left" width="14%"><strong>Bank Name</strong></td>

	<td class="bodytext31" valign="center"  align="left"><input type="hidden" name="bankname" value="<?php echo $bankname; ?>" size="6" class="bal"><?php echo $bankname; ?></td>

    </tr>

	 </tbody>

        </table>

        <tr>

  <td colspan="4" align="left" valign="top">&nbsp;</td>

  </tr>

	<tr>

  <td colspan="4" align="left" valign="top" class="tab">

	  <button type="button" class="tablinks" onClick="openCity(event, 'consultationtabid')" id = "defaultOpen">Allocated Invoices</button>

	  <button type="button" class="tablinks" onClick="openCity(event, 'prescriptiontabid')">Pending Invoices</button>

   </td>

   

   <td class="cumtotal">

        <table border="1">

        <tr><th>&nbsp;Amount&nbsp;</th><th>&nbsp;Cum Total&nbsp;</th></tr>
        <input type="hidden" id="amounttodisp" value="<?=$amounttodisp;?>">

        <tr><td><?php echo number_format($amounttodisp,2,'.',','); ?></td><td id="cumtotal">0.00</td></tr>

       <!--  <tr><td><?php //echo number_format($amounttodisp,2,'.',','); ?></td><td >
        <input type="text" id="cumtotal" value="0.00"></td></tr> -->

        

        </table></td>

	

  </tr>

             <tr>

             <td id="consultationtabid" class="tabcontent" colspan="10">

              <form name="cbform1" method="post" action="accountreceivableentry.php">

        	<table width="621" border="0" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">

			 <tr>

			 <td colspan="8" class="bodytext311"><strong>&nbsp;</strong></td>

			 </tr>

             <tr>

			 <td colspan="9" bgcolor="#ecf0f5" class="bodytext311"><strong>Allocated Invoices</strong></td>

			 </tr>

             <tr>

			 <td colspan="8"  class="bodytext311"><strong>Search Billno: </strong>

             <input type="text" name="searchbill2" id="searchbill2"> (Press Enter)

             <input type="hidden" name="sbtn2" id="sbtn2" value="Search" onClick="return SearchAlloc()">

             </td>

			 </tr>

           <tr>

                <td width="12%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>S.No</strong></td>

				<td width="25%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>Patient</strong></td>

                <td width="14%"align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill No</strong></div></td>

                <td width="16%"align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill Date</strong></div></td>

                <td width="15%"align="center" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Bill Amt</strong></td>

				
				<td width="14%"align="center" valign="center"   bgcolor="#ffffff" class="bodytext31"><strong>Discount</strong></td>
				<td width="14%"align="center" valign="center"   bgcolor="#ffffff" class="bodytext31"><strong>Adj Amt</strong></td>

				<td width="20%"align="center" valign="center"   bgcolor="#ffffff" class="bodytext31"><strong>Bal Amt</strong></td>

				  <td width="16%" align="center" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Select</strong></td>

                </tr>

                <tbody id="rowinsert1">

                </tbody>

			  <?php 

			  $colorloopcount = 0;

			  $totamount = 0;

			  $query27 = "select sum(transactionamount) as amount from master_transactionpaylater where docno='$docno' and recordstatus='allocated' and accountnameid='$accountnameid' and subtypeano='$subtypeano'";

			  $exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query27".mysqli_error($GLOBALS["___mysqli_ston"]));

			  $num2 = mysqli_num_rows($exec27);

			  $res27 = mysqli_fetch_array($exec27);

			  $amount = $res27['amount'];

			  $totamount = $totamount + $amount;

			  

			  ?>

              <tr>

                     <td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>
                     <td class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>

				

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

           	</tr>

			<tr>

			<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">

            <input type="hidden" name="totalrow1" id="totalrow1" value="0">

            <input type="hidden" name="docno" id="docno" value="<?php echo $docno; ?>">

            <strong>Total</strong>			</td>

			<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input type="text" name="totaladjamt1" id="totaladjamt1" size="7"></td>

			</tr>

			

			<tr>

              <td class="bodytext31" align="right" valign="top" colspan="7">

                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">

             	  <input name="Submit2223" type="submit" id="submit0" value="Save " onClick="return acknowledgevalid()" accesskey="b" class="button" style="border: 1px solid #001E6A"/>               </td>

            <td class="bodytext31" align="right" valign="top" colspan="7"><a target="_blank" href="print_accountremittances.php?docno=<?php echo $docno; ?>"> <img src="images/pdfdownload.jpg" width="30" height="30"></a></td> 

            </tr>

			</table>

            </form>	

            </td>

			 </tr>      

         

			</td>

        </tr>

		

	  <tr>

       <td id="prescriptiontabid" class="tabcontent" colspan="10" >&nbsp;

	  <form action="accountreceivableentry.php" method="post" name="form2">

	  <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="952" 

            align="left" border="0">

          <tbody>

          <tr>

              <td colspan="10" bgcolor="#ecf0f5" class="bodytext311"><strong>From <input type="text" name="ADate1" id="ADate1" size="10" value="<?php echo $ADate1; ?>" readonly onChange="" /> <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; To <input type="text" name="ADate2" id="ADate2" size="10" value="<?php echo $ADate2; ?>" readonly onChange="" /> <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/></strong>

              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="searchbillno" id="searchbillno" value="Search" onClick="return FuncPopup();">

              <input type="hidden" name="searchaccountnameano" id="searchaccountnameano" value="<?php echo $accountnameano; ?>"></td>

           </tr>

          

            <tr>

              <td colspan="3" bgcolor="#ecf0f5" class="bodytext311"><strong>Pending Invoices</strong></td>

			  <input type="hidden" name="paymentmode" value="<?php echo $paymentmode; ?>" size="6" class="bal">

			    <input type="hidden" name="docno1" value="<?php echo $docno; ?>">

			  <input type="hidden" name="paymentmode1" value="<?php echo $paymentmode; ?>" size="6" class="bal">

			  <input type="hidden" name="date1" value="<?php echo $date; ?>" size="6" class="bal">

			  <input type="hidden" name="number1" value="<?php echo $number; ?>" size="6" class="bal">

			  <input type="hidden" name="bankname1" value="<?php echo $bankname; ?>" size="6" class="bal">

			  <input type="hidden" name="receivableamount1" id="receivableamount" value="<?php echo $receivableamount; ?>" size="6" class="bal">

      

              <td width="22%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>

              <td width="10%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>

              <td width="9%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>

              <td width="9%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>

              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>

             

          <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>

            </tr>

            

            <tr>

              <td width="3%" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ffffff" class="bodytext311"><strong>No.</strong></td>

				  <td width="5%" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ffffff" class="bodytext311"><strong>Select <input type="checkbox" name="checkall" id="checkall" class="checkall" value="1"></strong></td>

              <td width="26%" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ffffff" class="bodytext311"><strong>Patient</strong></td>

                <td width="22%" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ffffff" class="bodytext311"><strong>Account</strong></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ffffff"><div align="left"><strong>Bill No </strong></div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" width="13%"  bgcolor="#ffffff"><div align="left"><strong>Bill Date </strong></div></td>

              <td width="9%" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ffffff" class="bodytext311"><div align="right"><strong>Pending</strong></div></td>

				 
				  <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left"   bgcolor="#ffffff"><div align="right"><strong>Discount</strong></div></td>
				   <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left"   bgcolor="#ffffff"><div align="right"><strong> Adj Amt</strong></div></td>

              <td width="8%" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong> Bal Amt</strong></div></td>

            </tr>

            

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

           

             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ecf0f5"><input type="text" name="totaldiscount" id="totaldiscount" size="7" class="bal" readonly></td>

               <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" bgcolor="#ecf0f5"><input type="text" name="totaladjamt" id="totaladjamt" size="7" class="bal" readonly></td>

             <!-- <td class="bodytext311" valign="center" bordercolor="#f3f3f3" bgcolor="#ecf0f5">&nbsp;</td> -->

             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"  bgcolor="#ecf0f5">&nbsp;<input type="hidden" name="totalrow" id="totalrow" value="<?php echo $sno; ?>"></td>

			</tr>

          

	  

	  <tr>

	  <td>&nbsp;	  </td>

	  </tr>

	  <tr>

	  <td colspan="9" width="1002"align="right" valign="top"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">

                      

                      <input type="hidden" name="frmflag23" value="frmflag23">

                      <input name="Submit" type="submit"  value="Save" class="button" id="submit1" onClick="return totalamountcheck('<?php echo $num2; ?>','<?php echo $totamount; ?>');"style="border: 1px solid #001E6A"/>

       </font></td>

	  </tr>

	 </form>

	   </tbody>

      </table>

	</td>

	</tr>

  </table>

  

<?php include ("includes/footer1.php"); ?>

</body>

</html>




<?php

session_start();

error_reporting(0);

//date_default_timezone_set('Asia/Calcutta');

include ("db/db_connect.php");

include ("includes/loginverify.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$updatedatetime = date("Y-m-d H:i:s");

$indiandatetime = date ("d-m-Y H:i:s");

$dateonly = date("Y-m-d");

$username = $_SESSION["username"];

$ipaddress = $_SERVER["REMOTE_ADDR"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];

$financialyear = $_SESSION["financialyear"];



$titlestr = 'SALES BILL';

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

if ($frm1submit1 == 'frm1submit1')

{

    $visitcode=$_REQUEST["visitcode"];

	$patientcode = $_REQUEST["customercode"];

	$patientname = $_REQUEST["customername"];

	$locationcode = $_REQUEST["locationcode"];

	$consultationdate = date("Y-m-d");

	$accountname = $_REQUEST["account"];

	$patientpaymentmode = $_REQUEST['billtype'];

	if($patientpaymentmode =='PAY NOW')

	{

	$status='pending';

	}

	else

	{

	$status='completed';

	}

	foreach($_POST['itemcode'] as $key => $value)

	{

	$aitemcode = $_POST['itemcode'][$key];

	$alabfree = $_POST['afree'][$key];

	$query1="update ipconsultation_radiology set freestatus='$alabfree' where patientcode='$patientcode' and patientvisitcode='$visitcode' and radiologyitemcode='$aitemcode' and locationcode = '$locationcode'";

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"])); 

	}

	$query21 = "select * from ipconsultation_radiology where patientcode='$patientcode' and patientvisitcode='$visitcode' order by auto_number desc limit 0, 1";

	    $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res21 = mysqli_fetch_array($exec21);

		$radrefnonumber = $res21["refno"];

	

     	$rad= $_POST['radiology'];

		$rat=$_POST['rate8'];

		$items = array_combine($rad,$rat);

		$pairs = array();

		

		foreach($_POST['radiology'] as $key=>$value){	

			//echo '<br>'.

		

		$pairs= $_POST['radiology'][$key];

		$pairvar= $pairs;

	    $pairs1= $_POST['rate8'][$key];

		$pairvar1= $pairs1;

		

		$radiologyquery=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_radiology where itemname='$pairvar'");

		$execradiology=mysqli_fetch_array($radiologyquery);

		$radiologycode=$execradiology['itemcode'];

		$radiologyfree=$_POST['radiologyfree'][$key];

		

		if(($pairvar!="")&&($pairvar1!=""))

		{

		$radiologyquery1="insert into ipconsultation_radiology(consultationid,patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,billtype,accountname,consultationdate,paymentstatus,refno,resultentry,freestatus,locationcode)values('$consultationid','$patientcode','$patientname','$visitcode','$radiologycode','$pairvar','$pairvar1','$patientpaymentmode','$accountname','$consultationdate','$status','$radrefnonumber','pending','$radiologyfree','$locationcode')";

		$radiologyexecquery1=mysqli_query($GLOBALS["___mysqli_ston"], $radiologyquery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$radiologyquery2=mysqli_query($GLOBALS["___mysqli_ston"], "update master_visitentry set radiologybill='pending' where visitcode='$visitcode'");

		}

		}

		header("location:ipamendrad_pending_sup.php");



}





//to redirect if there is no entry in masters category or item or customer or settings







//To get default tax from autoitemsearch1.php and autoitemsearch2.php - for CST tax override.

if (isset($_REQUEST["defaulttax"])) { $defaulttax = $_REQUEST["defaulttax"]; } else { $defaulttax = ""; }

if(isset($_REQUEST['delete']))

{

$radiologyname=$_REQUEST['delete'];

$visit = $_REQUEST['visitcode'];

$data=mysqli_query($GLOBALS["___mysqli_ston"], "select auto_number,patientcode,patientvisitcode,patientname,refno,radiologyitemcode,radiologyitemname,radiologyitemrate from ipconsultation_radiology where auto_number='$radiologyname'");

$data1=mysqli_fetch_array($data);

$patientname=$data1['patientname'];

$patientcode=$data1['patientcode'];

$visitcode=$data1['patientvisitcode'];

$refno=$data1['refno'];

$medicinecode=$data1['radiologyitemcode'];

$medicinename=$data1['radiologyitemname'];

$rate=$data1['radiologyitemrate'];

$autonum=$data1['auto_number'];

 $date=date('Y-m-d'); 

$time=date('H:i:s');

$remarks=stripslashes(urldecode($_REQUEST['remarks-'.$radiologyname]));

if($medicinecode<>'')

{

 $query="insert into amendment_details (patientcode,visitcode,patientname,refno,itemcode,itemname,rate,amenddate,amendtime,amendfrom,amendby,ipaddress,type,remarks) values ('$patientcode','$visitcode','$patientname','$refno','$medicinecode','$medicinename','$rate','$date','$time','radiology','$username','$ipaddress','IP','$remarks')";

mysqli_query($GLOBALS["___mysqli_ston"], $query)or die("Error in query".mysqli_error($GLOBALS["___mysqli_ston"]));

}

mysqli_query($GLOBALS["___mysqli_ston"], "delete from ipconsultation_radiology where auto_number='$radiologyname' and patientvisitcode='$visit'");

header('location:ipamendradiology_sup.php?patientcode='.$patientcode.'&visitcode='.$visitcode.'&locationcode='.$locationcode);



}

//$defaulttax = $_REQUEST["defaulttax"];

if ($defaulttax == '')

{

	$_SESSION["defaulttax"] = '';

}

else

{

	$_SESSION["defaulttax"] = $defaulttax;

}

if(isset($_REQUEST["patientcode"]))

{

$patientcode=$_REQUEST["patientcode"];

$visitcode=$_REQUEST["visitcode"];

}





//This include updatation takes too long to load for hunge items database.





//To populate the autocompetelist_services1.js





//To verify the edition and manage the count of bills.

$thismonth = date('Y-m-');

$query77 = "select * from master_edition where status = 'ACTIVE'";

$exec77 =  mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));

$res77 = mysqli_fetch_array($exec77);

$res77allowed = $res77["allowed"];







/*

$query99 = "select count(auto_number) as cntanum from master_quotation where quotationdate like '$thismonth%'";

$exec99 = mysql_query($query99) or die ("Error in Query99".mysql_error());

$res99 = mysql_fetch_array($exec99);

$res99cntanum = $res99["cntanum"];

$totalbillandquote = $res88cntanum + $res99cntanum; //total of bill and quote in current month.

if ($totalbillandquote > $res77allowed)

{

	//header ("location:usagelimit1.php"); // redirecting.

	//exit;

}

*/



//To Edit Bill

if (isset($_REQUEST["delbillst"])) { $delbillst = $_REQUEST["delbillst"]; } else { $delbillst = ""; }

//$delbillst = $_REQUEST["delbillst"];

if (isset($_REQUEST["delbillautonumber"])) { $delbillautonumber = $_REQUEST["delbillautonumber"]; } else { $delbillautonumber = ""; }

//$delbillautonumber = $_REQUEST["delbillautonumber"];

if (isset($_REQUEST["delbillnumber"])) { $delbillnumber = $_REQUEST["delbillnumber"]; } else { $delbillnumber = ""; }

//$delbillnumber = $_REQUEST["delbillnumber"];



if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

//$frm1submit1 = $_REQUEST["frm1submit1"];

if (isset($_REQUEST["locationcode"])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }







if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$st = $_REQUEST["st"];

if (isset($_REQUEST["banum"])) { $banum = $_REQUEST["banum"]; } else { $banum = ""; }

//$banum = $_REQUEST["banum"];

if ($st == '1')

{

	$errmsg = "Success. New Bill Updated. You May Continue To Add Another Bill.";

	$bgcolorcode = 'success';

}

if ($st == '2')

{

	$errmsg = "Failed. New Bill Cannot Be Completed.";

	$bgcolorcode = 'failed';

}

if ($st == '1' && $banum != '')

{

	$loadprintpage = 'onLoad="javascript:loadprintpage1()"';

}



if ($delbillst == "" && $delbillnumber == "")

{

	$res41customername = "";

	$res41customercode = "";

	$res41tinnumber = "";

	$res41cstnumber = "";

	$res41address1 = "";

	$res41deliveryaddress = "";

	$res41area = "";

	$res41city = "";

	$res41pincode = "";

	$res41billdate = "";

	$billnumberprefix = "";

	$billnumberpostfix = "";

}









?>



<?php

$query78="select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";

$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res78=mysqli_fetch_array($exec78);

$patientage=$res78['age'];

$patientgender=$res78['gender'];

$res111paymenttype = $res78['paymenttype'];



$query131 = "select * from master_location where locationcode = '$locationcode'";

$exec131 = mysqli_query($GLOBALS["___mysqli_ston"], $query131) or die ("Error in Query131".mysqli_error($GLOBALS["___mysqli_ston"]));

$res131 = mysqli_fetch_array($exec131);

$locationname = $res131['locationname'];



$query121 = "select * from master_paymenttype where auto_number = '$res111paymenttype'";

$exec121 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die (mysqli_error($GLOBALS["___mysqli_ston"]));

$res121 = mysqli_fetch_array($exec121);

$res121paymenttype = $res121['paymenttype'];



$res111subtype = $res78['subtype'];



$query131 = "select * from master_subtype where auto_number = '$res111subtype'";

$exec131 = mysqli_query($GLOBALS["___mysqli_ston"], $query131) or die ("Error in Query131".mysqli_error($GLOBALS["___mysqli_ston"]));

$res131 = mysqli_fetch_array($exec131);

$res131subtype = $res131['subtype'];

?>

<?php

$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");

$execlab1=mysqli_fetch_array($querylab1);

$patientname=$execlab1['customerfullname'];

$patientaccount=$execlab1['accountname'];

$billtype=$execlab1['billtype'];



$querylab2=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$patientaccount'");

$execlab2=mysqli_fetch_array($querylab2);

$patientaccount1=$execlab2['accountname'];



?>

<?php

$query3 = "select * from master_company where companystatus = 'Active'";

$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

$res3 = mysqli_fetch_array($exec3);

$radiologyprefix = $res3['radiologyprefix'];



$query2 = "select * from billing_radiology order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["billnumber"];

if ($billnumber == '')

{

	$billnumbercode =$radiologyprefix.'00000001';

	$openingbalance = '0.00';

}

else

{

	$billnumber = $res2["billnumber"];

	$billnumbercode = substr($billnumber, 3, 8);

	$billnumbercode = intval($billnumbercode);

	$billnumbercode = $billnumbercode + 1;



	$maxanum = $billnumbercode;

	if (strlen($maxanum) == 1)

	{

		$maxanum1 = '0000000'.$maxanum;

	}

	else if (strlen($maxanum) == 2)

	{

		$maxanum1 = '000000'.$maxanum;

	}

	else if (strlen($maxanum) == 3)

	{

		$maxanum1 = '00000'.$maxanum;

	}

	else if (strlen($maxanum) == 4)

	{

		$maxanum1 = '0000'.$maxanum;

	}

	else if (strlen($maxanum) == 5)

	{

		$maxanum1 = '000'.$maxanum;

	}

	else if (strlen($maxanum) == 6)

	{

		$maxanum1 = '00'.$maxanum;

	}

	else if (strlen($maxanum) == 7)

	{

		$maxanum1 = '0'.$maxanum;

	}

	else if (strlen($maxanum) == 8)

	{

		$maxanum1 = $maxanum;

	}

	

	$billnumbercode = $radiologyprefix .$maxanum1;

	$openingbalance = '0.00';

	//echo $companycode;

}

?>



<script language="javascript">


function deletevalid(id,patient,visit,locationcode)
{

var msg=document.getElementById('remarks-'+id).value;
if(msg.trim()==''){
alert("Must have remarks.");
document.getElementById('remarks-'+id).focus();

return false;
}

var del;

del=confirm("Do You want to delete this test ?");

if(del == false)

{

return false;

}else{

window.location='ipamendradiology_sup.php?delete='+id+'&patientcode='+patient+'&&visitcode='+visit+'&locationcode='+locationcode+'&remarks-'+id+'='+msg;
}

}

function btnDeleteClick9(delID5,radrate)

{

	//alert ("Inside btnDeleteClick.");

	var newtotal2;

	//alert(radrate);

	var varDeleteID2= delID5;

	//alert (varDeleteID2);

	var fRet5; 

	fRet5 = confirm('Are You Sure Want To Delete This Entry?'); 

	//alert(fRet); 

	if (fRet5 == false)

	{

		//alert ("Item Entry Not Deleted.");

		return false;

	}



	var child2= document.getElementById('idTR'+varDeleteID2);  //tr name

    var parent2 = document.getElementById('insertrow2'); // tbody name.

	document.getElementById ('insertrow2').removeChild(child2);

	

	var child2 = document.getElementById('idTRaddtxt'+varDeleteID2);  //tr name

    var parent2 = document.getElementById('insertrow2'); // tbody name.

	//alert (child);

	if (child2 != null) 

	{

		//alert ("Row Exsits.");

		document.getElementById ('insertrow2').removeChild(child2);

	}

	

	var currenttotal2=document.getElementById('total2').value;

	//alert(currenttotal);

	newtotal2= currenttotal2-radrate;

	

	//alert(newtotal);

	

	document.getElementById('total2').value=newtotal2;

	

	

	



	

}



<?php

if ($delbillst != 'billedit') // Not in edit mode or other mode.

{

?>

	//Function call from billnumber onBlur and Save button click.

	function billvalidation()

	{

		billnovalidation1();

	}

<?php

}

?>





function funcOnLoadBodyFunctionCall()

{





	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php

	

	funcCustomerDropDownSearch2(); //To handle ajax dropdown list.

	

	funcPopupPrintFunctionCall();

	

}



function funcPopupPrintFunctionCall()

{



	///*

	//alert ("Auto Print Function Runs Here.");

	<?php

	if (isset($_REQUEST["src"])) { $src = $_REQUEST["src"]; } else { $src = ""; }

	//$src = $_REQUEST["src"];

	if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

	//$st = $_REQUEST["st"];

	if (isset($_REQUEST["billnumber"])) { $previousbillnumber = $_REQUEST["billnumber"]; } else { $previousbillnumber = ""; }

	//$previousbillnumber = $_REQUEST["billnumber"];

	if (isset($_REQUEST["billautonumber"])) { $previousbillautonumber = $_REQUEST["billautonumber"]; } else { $previousbillautonumber = ""; }

	//$previousbillautonumber = $_REQUEST["billautonumber"];

	if (isset($_REQUEST["companyanum"])) { $previouscompanyanum = $_REQUEST["companyanum"]; } else { $previouscompanyanum = ""; }

	//$previouscompanyanum = $_REQUEST["companyanum"];

	if ($src == 'frm1submit1' && $st == 'success')

	{

	$query1print = "select * from master_printer where defaultstatus = 'default' and status <> 'deleted'";

	$exec1print = mysqli_query($GLOBALS["___mysqli_ston"], $query1print) or die ("Error in Query1print.".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res1print = mysqli_fetch_array($exec1print);

	$papersize = $res1print["papersize"];

	$paperanum = $res1print["auto_number"];

	$printdefaultstatus = $res1print["defaultstatus"];

	if ($paperanum == '1') //For 40 Column paper

	{

	?>

		//quickprintbill1();

		quickprintbill1sales();

	<?php

	}

	else if ($paperanum == '2') //For A4 Size paper

	{

	?>

		loadprintpage1('A4');

	<?php

	}

	else if ($paperanum == '3') //For A4 Size paper

	{

	?>

		loadprintpage1('A5');

	<?php

	}

	}

	?>

	//*/





}



//Print() is at bottom of this page.



</script>

<?php include ("js/sales1scripting1.php"); ?>

<script type="text/javascript">

function btnDeleteClick5(delID5,radrate)

{

var radrate=radrate;

	//alert ("Inside btnDeleteClick.");

	var newtotal2;

	//alert(radrate);

	//alert(delID5);

	var varDeleteID2= delID5;

	//alert (varDeleteID2);

	var fRet5; 

	fRet5 = confirm('Are You Sure Want To Delete This Entry?'); 

	//alert(fRet); 

	if (fRet5 == false)

	{

		//alert ("Item Entry Not Deleted.");

		return false;

	}



	var child2= document.getElementById('idTR'+varDeleteID2);  //tr name

	//alert(child2);

    var parent2 = document.getElementById('insertrow2'); // tbody name.

	//alert(parent2);

	document.getElementById ('insertrow2').removeChild(child2);

	

	var child2 = document.getElementById('idTRaddtxt'+varDeleteID2);  //tr name

    var parent2 = document.getElementById('insertrow2'); // tbody name.

	//alert (child);

	if (child2 != null) 

	{

		//alert ("Row Exsits.");

		document.getElementById ('insertrow2').removeChild(child2);

	}

	

	var currenttotal2=document.getElementById('total2').value;

	//alert(currenttotal);

	newtotal2= currenttotal2-radrate;

	

	//alert(newtotal);

	

	document.getElementById('total2').value=newtotal2;



	if(document.getElementById('total1').value=='')

	{

	totalamount21=0;

	}

	else

	{

	totalamount21=document.getElementById('total1').value;

	}

	if(document.getElementById('total3').value=='')

	{

	totalamount31=0;

	}

	else

	{

	totalamount31=document.getElementById('total3').value;

	}

	

	

	

    var newgrandtotal2=parseInt(totalamount21)+parseInt(newtotal2)+parseInt(totalamount31);

	

	//alert(newgrandtotal4);

	

	document.getElementById('total4').value=newgrandtotal2.toFixed(2);

	

	

	

		document.getElementById("subtotal").value=newgrandtotal2.toFixed(2);

	document.getElementById("subtotal1").value=newgrandtotal2.toFixed(2);



	document.getElementById("totalamount").value=newgrandtotal2.toFixed(2);



	

}

function loadprintpage1(varPaperSizeCatch)

{

	//var varBillNumber = document.getElementById("billnumber").value;

	var varPaperSize = varPaperSizeCatch;

	//alert (varPaperSize);

	//return false;

	<?php

	//To previous js error if empty. 

	if ($previousbillnumber == '') 

	{ 

		$previousbillnumber = 1; 

		$previousbillautonumber = 1; 

		$previouscompanyanum = 1; 

	} 

	?>

	var varBillNumber = document.getElementById("quickprintbill").value;

	var varBillAutoNumber = "<?php //echo $previousbillautonumber; ?>";

	var varBillCompanyAnum = "<?php echo $_SESSION["companyanum"]; ?>";

	if (varBillNumber == "")

	{

		alert ("Bill Number Cannot Be Empty.");//quickprintbill

		document.getElementById("quickprintbill").focus();

		return false;

	}

	

	var varPrintHeader = "INVOICE";

	var varTitleHeader = "ORIGINAL";

	if (varTitleHeader == "")

	{

		alert ("Please Select Print Title.");

		document.getElementById("titleheader").focus();

		return false;

	}

	

	//alert (varBillNumber);

	//alert (varPrintHeader);

	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');



	if (varPaperSize == "A4")

	{

		window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&billnumber="+varBillNumber+"","OriginalWindowA4<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

	}

	if (varPaperSize == "A5")

	{

		window.open("print_bill1_a5.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&billnumber="+varBillNumber+"","OriginalWindowA5<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

	}

}



function cashentryonfocus1()

{



	if (document.getElementById("cashgivenbycustomer").value == "0.00")

	{

		document.getElementById("cashgivenbycustomer").value = "";

		document.getElementById("cashgivenbycustomer").focus();

	}

}



function funcDefaultTax1() //Function to CST Taxes if required.

{

	//alert ("Default Tax");

	<?php

	//delbillst=billedit&&delbillautonumber=13&&delbillnumber=1

	//To avoid change of bill number on edit option after selecting default tax.

	if (isset($_REQUEST["delbillst"])) { $delBillSt = $_REQUEST["delbillst"]; } else { $delBillSt = ""; }

	//$delBillSt = $_REQUEST["delbillst"];

	if (isset($_REQUEST["delbillautonumber"])) { $delBillAutonumber = $_REQUEST["delbillautonumber"]; } else { $delBillAutonumber = ""; }

	//$delBillAutonumber = $_REQUEST["delbillautonumber"];

	if (isset($_REQUEST["delbillnumber"])) { $delBillNumber = $_REQUEST["delbillnumber"]; } else { $delBillNumber = ""; }

	//$delBillNumber = $_REQUEST["delbillnumber"];

	

	?>

	var varDefaultTax = document.getElementById("defaulttax").value;

	if (varDefaultTax != "")

	{

		<?php

		if ($delBillSt == 'billedit')

		{

		?>

		window.location="sales1.php?defaulttax="+varDefaultTax+"&&delbillst=<?php echo $delBillSt; ?>&&delbillautonumber="+<?php echo $delBillAutonumber; ?>+"&&delbillnumber="+<?php echo $delBillNumber; ?>+"";

		<?php

		}

		else

		{

		?>

		window.location="sales1.php?defaulttax="+varDefaultTax+"";

		<?php

		}

		?>

	}

	else

	{

		window.location="sales1.php";

	}

	//return false;

}







</script>

<script type="text/javascript" src="js/insertnewitem7.js"></script>

<style type="text/css">

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.style1 {

	font-size: 36px;

	font-weight: bold;

}

.style2 {

	font-size: 18px;

	font-weight: bold;

}

.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }

.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }



</style>



<script src="js/datetimepicker_css.js"></script>

<?php include ("js/dropdownlist1scriptingradiology1.php"); ?>

<?php include("autocompletebuild_radiology1.php"); ?>

<script type="text/javascript" src="js/autocomplete_radiology1.js"></script>

<script type="text/javascript" src="js/autosuggestradiology1.js"></script> 

<script type="text/javascript" src="js/autoradiologycodesearch2.js"></script>

<script type="text/javascript" src="js/insertnewitem33iprad.js"></script>



</head>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<body onLoad="return funcOnLoadBodyFunctionCall();">

<form name="form1" id="frmsales" method="post" action="ipamendradiology_sup.php" onKeyDown="return disableEnterKey(event)">

<table width="101%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>

  </tr>

<!--  <tr>

    <td colspan="10">&nbsp;</td>

  </tr>

-->

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="99%" valign="top"><table width="980" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

            <tbody>

              

			 

		

			  <tr>

			    <td width="15%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient * </strong></td>

                <td width="36%" align="left" valign="middle" class="bodytext3">

				<input name="customername" id="customer" type="hidden" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $patientname; ?>

                  </td>

                 <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient code </strong></td>

                <td colspan="3" align="left" valign="middle" class="bodytext3">

				<input name="customercode" id="customercode" type="hidden" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?>

				

				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>

             

			    </tr>

			   <tr>

			    <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>

			    <td align="left" valign="middle" class="bodytext3">

				<input type="hidden" name="patientage" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientage; ?>

				&

				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientgender; ?>

				<input type="hidden" name="address1" id="address1" value="<?php echo $res41address1; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;" size="30" />

			      <span class="style4"><!--Area--> </span>

			      <input type="hidden" name="area" id="area" value="<?php echo $res41area; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="10" />

				  </td>

				    <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>

                <td colspan="3" align="left" valign="middle" class="bodytext3">

				<input name="account" id="account" type="hidden" value="<?php echo $patientaccount1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientaccount1; ?>

				

				  </tr>

				  <tr>

				  <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>

                <td colspan="1" align="left" valign="middle" class="bodytext3">

				<input name="visitcode" id="visitcode" type="hidden" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $visitcode; ?>

				<input type="hidden" name="billtype" id="billtypes" value="<?php echo $billtype; ?>">

			 <input type="hidden" name="paymenttype" id="payment" value="<?php echo $res121paymenttype; ?>" readonly   size="20" />	

			 <input type="hidden" name="subtype" id="subtype"  value="<?php echo $res131subtype; ?>" >  	

				  </td>

				  <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Location</strong></td>

                <td colspan="3" align="left" valign="middle" class="bodytext3">

				<input type="hidden" id="locationname" name="locationname" value="<?php echo $locationname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $locationname;?>

				 <input type="hidden" id="locationcode" name="locationcode" value="<?php echo $locationcode; ?>" >

				  </td>

				  </tr>

            </tbody>

        </table></td>

      </tr>

      

      <tr>

        <td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 

            align="left" border="0">

          <tbody id="foo">

            <tr>

              <td width="16%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>

				<td width="16%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Code </strong></div></td>

				<td width="13%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Radiology</strong></div></td>

				<td width="13%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>

				<td width="13%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>

				<td width="13%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Free </strong></div></td>

				<td width="13%"  align="left" valign="center" 

 				bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Remarks </strong></div></td>

				<td width="13%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action </strong></div></td>

				

              

                  </tr>

				  		<?php

			$colorloopcount = '';

			$sno = '';

			$totalamount=0;

			if($billtype == 'PAY NOW')

			{

			$status='pending';

			}

			else

	{

	$status='completed';

	}

			$query17 = "select * from ipconsultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode'";

			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while ($res17 = mysqli_fetch_array($exec17))

			{

			

				$paharmitemname=$res17['radiologyitemname'];

				$autonumber=$res17['auto_number'];

				

				$pharmitemcode=$res17['radiologyitemcode'];

			$pharmitemrate=$res17['radiologyitemrate'];

			$freestatus=$res17['freestatus'];

		

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

			$totalamount=$totalamount+$pharmitemrate;

			$totalamount=number_format($totalamount,2);

			?>

			  <tr <?php echo $colorcode; ?>>

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>

			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemcode; ?>

				<input type="hidden" name="itemcode[]" id="itemcode<?php echo $sno; ?>" value="<?php echo $pharmitemcode; ?>"></div></td>

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>

			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="center"><select name="afree[]" id="afree">

					  <?php if($freestatus=='Yes'){ ?>

					  <option value="No">No</option>

					  <option value="Yes" selected="selected">Yes</option>

					  <?php } ?>

					  <?php if(($freestatus=='No')||($freestatus=='')||($freestatus=='0')){  ?>

					  <option value="No">No</option>

					  <option value="Yes">Yes</option>

					  <?php } ?>

					  </select></div></td>

				<td class="bodytext31" valign="center"  align="left"><div align="center"><input type = "text" name ="remarks-<?php echo $autonumber; ?>" id ="remarks-<?php echo $autonumber; ?>"></div></td>

				  <td class="bodytext31" valign="center"  align="left"><div align="center"><a onClick="return deletevalid('<?php echo $autonumber; ?>','<?php echo $patientcode; ?>','<?php echo $visitcode; ?>','<?php echo $locationcode; ?>')" href='javascript:return false;' >Delete</a></div></td>

				

				</tr>

			<?php } ?>

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

             </tr>

           

          </tbody>

        </table>		</td>

      </tr>

      <tr>

	   <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Add Radiology Tests</strong></td>

	 

	  </tr>

     <tr id="radid">

				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">

                     <tr>

                       <td width="30" class="bodytext3">Radiology Test</td>

                       <td class="bodytext3">Rate</td>

                       <td width="30" class="bodytext3">Free</td>

                     </tr>

					  <tr>

					 <div id="insertrow2">					 </div></tr>

					  <tr>

					  <input type="hidden" name="serialnumber2" id="serialnumber27" value="1">

					  <input type="hidden" name="radiologycode" id="radiologycode" value="">

				   <td width="30"> <input name="radiology[]" id="radiology" type="text" size="69" autocomplete="off"></td>

				      <td width="30"><input name="rate8[]" type="text" id="rate8" readonly size="8"></td>

					   <td><select name="radiologyfree[]" id="radiologyfree">

					   <option value="">Select</option>

					  <option value="0">No</option>

					  <option value="1">Yes</option>

					  </select>

					  </td>

					   <td><label>

                       <input type="button" name="Add2" id="Add2" value="Add" onClick="return insertitem3()" class="button" style="border: 1px solid #001E6A">

                       </label></td>

					   </tr>

					    </table>						</td>

		        </tr>

				

				 <tr>

				   <td colspan="6" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total Amount</span>

				   <input type="text" id="total2" readonly size="7">

				   <input type="hidden" id="total1" readonly size="7">

				   <input type="hidden" id="total3" readonly size="7">

				   <input type="hidden" id="total4" readonly size="7"></td>

				   </tr>

		        

      <tr>

        

		 <td colspan="2" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

		  <input type="hidden" name="frm1submit1" value="frm1submit1" />

                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />

               <input name="Submit222" type="submit"  value="Save Request" class="button"/>

		 </td>

      </tr>

	  </table>

      </td>

      </tr>

    

  </table>

</form>

<?php include ("includes/footer1.php"); ?>

<?php //include ("print_bill_dmp4inch1.php"); ?>

</body>

</html>
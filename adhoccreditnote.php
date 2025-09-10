<?php

session_start();

error_reporting(0);

//date_default_timezone_set('Asia/Calcutta');

include ("db/db_connect.php");

include ("includes/loginverify.php");

$updatedatetime = date("Y-m-d H:i:s");

$indiandatetime = date ("d-m-Y H:i:s");

$dateonly = date("Y-m-d");

$timeonly = date("H:i:s");

$username = $_SESSION["username"];

$ipaddress = $_SERVER["REMOTE_ADDR"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];

$financialyear = $_SESSION["financialyear"];

$currentdate = date("Y-m-d");

$updatedate=date("Y-m-d");

$titlestr = 'SALES BILL';


$locdocno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$locdocno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	$locationnameget = $res["locationname"];
	$locationcodeget = $res["locationcode"];
	$res12locationanum = $res["auto_number"];

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if (isset($_REQUEST["billno"])) { $bill_num_get = $_REQUEST["billno"]; } else { $bill_num_get = ""; }

if ($frm1submit1 == 'frm1submit1')

{

	

       //get locationcode and locationname for inserting

 // $locationcodeget=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';

 // $locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';

//get ends here

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

	

	

	$billnumbercode = 'CRN-' .$maxanum;

	$openingbalance = '0.00';

	//echo $companycode;

}



	$billdate=$_REQUEST['billdate'];

	

	$paymentmode = $_REQUEST['billtype'];

		$patientfullname = $_REQUEST['customername'];

		$patientcode = $_REQUEST['patientcode'];

		$visitcode = $_REQUEST['visitcode'];

		// $bill_num = $_REQUEST['bill_num'];
		$ref_num = $_REQUEST['ref_num'];

		$billtype = $_REQUEST['billtypes'];

		$age=$_REQUEST['age'];

		$gender=$_REQUEST['gender'];

		//$account = $_REQUEST['account'];
		//$pat_accountcode=$_REQUEST['pat_accountcode'];
		//$pat_accountanum=$_REQUEST['pat_accountanum'];

        $accountid = trim($_REQUEST['account']);
		$sqlacc="SELECT auto_number,accountname,id FROM `master_accountname` WHERE auto_number='".$accountid."'";
		$opexec2 = mysqli_query($GLOBALS["___mysqli_ston"], $sqlacc);
		$opres2= mysqli_fetch_array($opexec2);
		$pat_accountcode=$opres2['id'];
		$pat_accountanum=$opres2['auto_number'];
		$account=$opres2['accountname'];


		$remarks = '';

		


		

		foreach($_POST['referal'] as $key=>$value){	

			//echo '<br>'.

		

		$pairs= $_POST['referal'][$key];

		$pairvar= $pairs;

	    $pairs1= $_POST['rate4'][$key];

		$pairvar1= $pairs1;

		

		$units = $_POST['units'][$key];

		$amount = $_POST['amount'][$key];

		$accountname=$_POST['accountname'][$key];

		$accountcode=$_POST['accountcode'][$key];

			

		if($pairvar!="")
		{
		$referalquery1=mysqli_query($GLOBALS["___mysqli_ston"], "INSERT into adhoc_creditnote(docno,units,amount,patientcode,patientname,patientvisitcode,description,rate,billtype,billingaccountcode,billingaccountname,accountname,consultationdate,paymentstatus,consultationtime,remarks,username,ipaddress,locationname,locationcode,ref_no, accountnameano, accountcode)values('$billnumbercode','$units','$amount','$patientcode','$patientfullname','$visitcode','$pairvar','$pairvar1','$billtype','$accountcode','$accountname','$account','$dateonly','pending','$timeonly','$remarks','$username','$ipaddress','".$locationnameget."','".$locationcodeget."', '$ref_num','$pat_accountanum','$pat_accountcode')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
}


///////////////////// FOR ALLOCATION //////////////////////////////
// $billnumbercode=$billnumbercode;
$billnum=$_REQUEST['ref_num'];
$adjamount=$_REQUEST['total_amount'];
$receivableamount=$_REQUEST['total_amount'];
//$pat_accountcode=$_REQUEST['pat_accountcode'];
//$pat_accountanum=$_REQUEST['pat_accountanum'];



$billnumberprefix = '';
$billnumber = '';
$billanum = '';
$balanceamount = '';
$remarks = '';
$transactionmodule = '';
$doctorname = '';



$query2 = "SELECT billbalanceamount,accountnameano from master_transactionpaylater where billnumber='$billnum' and accountcode = '$pat_accountcode' and transactionstatus <> 'onaccount' and acc_flag = '0'  and transactiontype not in ('pharmacycredit','paylatercredit')  order by transactiondate ASC";
// and transactiondate between '$ADate1' and '$ADate2' and transactionmode <> 'CREDIT NOTE'
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$rowcount21 = $rowcount21 + $rowcount2 = mysqli_num_rows($exec2);
while ($res2 = mysqli_fetch_array($exec2)){
	$balamount1 = $res2['billbalanceamount'];
	$accountnameano = $res2['accountnameano'];
}


$query_allocated_amount = "SELECT sum(transactionamount) as amount, sum(discount) as discount from master_transactionpaylater where  recordstatus='allocated' and billnumber='$billnum'";
          // docno='$docno' and
$exec_allocated_amount = mysqli_query($GLOBALS["___mysqli_ston"], $query_allocated_amount) or die ("Error in Query_allocated_amount".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res_allocated_amount = mysqli_fetch_array($exec_allocated_amount)){
$allocated_amount=$res_allocated_amount['amount']+$res_allocated_amount['discount'];
}

$balamount = $balamount1-$receivableamount;

if($balamount == 0.00) { $billstatus='paid'; }
 else { $billstatus='unpaid'; }

// $billstatus = '';
// $balamount = '';
$discount = '';
$currency = 'Kenya Shillings';


$query55 = "select * from master_accountname where id='$pat_accountcode'";
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

		values ('$dateonly','$timeonly', '',

		'', 'paylatercredit', '$receivableamount', '', 

		'',  '', '$ipaddress', '$updatedate', '', '$companyanum', '$companyname', '$remarks', 

		'','$patientfullname','$patientcode','$visitcode','$account','$billnumbercode','$receivableamount','','$receivableamount','$patienttype11','$patientsubtype11','$username','$pat_accountanum','$pat_accountcode','$locationcodeget','$locationnameget','$subtypeano','$pat_accountcode','$currency','1','$adjamount','','0')";

		$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die ("Error in Query91".mysqli_error($GLOBALS["___mysqli_ston"]));

//////////////// INSERT OF DOC IN ////////////



 $query9912="update master_transactionpaylater set acc_flag='1' where billnumber='$billnum' and transactiontype='finalize' and accountnameid='$pat_accountcode'";
$exec9912=mysqli_query($GLOBALS["___mysqli_ston"], $query9912);

 $query99122="update master_transactionpaylater set acc_flag='1' where billnumber='$billnum' and transactiontype='PAYMENT' and recordstatus = 'allocated'  and accountnameid='$pat_accountcode' and subtypeano='$subtypeano' ";
$exec99122=mysqli_query($GLOBALS["___mysqli_ston"], $query99122);

// exit();

$query87 ="select * from master_transactionpaylater where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$billnumbercode' and recordstatus = 'allocated'";
		$exec87 = mysqli_query($GLOBALS["___mysqli_ston"], $query87) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num87 = mysqli_num_rows($exec87);

		if($num87 == 0)
		{
		// if($adjamount != 0 || $adjamount != 0.00)
		// {

		// 	if ($paymentmode == 'By Credit Note')

		// {

		$transactiontype = 'PAYMENT';

		$transactionmode = 'CREDIT NOTE';

		$particulars = 'BY CREDIT NOTE '.$billnumberprefix.$billnumber;		

	

		$query9 = "INSERT into master_transactionpaylater (transactiondate, transactiontime, particulars,  

		transactionmode, transactiontype, transactionamount, writeoffamount,

		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 

		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,billbalanceamount,recordstatus,receivableamount,paymenttype,subtype,username,accountnameano,accountnameid,locationcode,locationname,subtypeano,accountcode,currency,fxrate,fxamount,discount) 

		values ('$dateonly','$timeonly', '$particulars',

		'$transactionmode', '$transactiontype', '$adjamount', '$adjamount', 

		'$billnum',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 

		'$transactionmodule','$patientfullname','$patientcode','$visitcode','$account','$doctorname','$billstatus','$billnumbercode','$balamount','allocated','$receivableamount','$patienttype11','$patientsubtype11','$username','$pat_accountanum','$pat_accountcode','$locationcodeget','$locationnameget','$subtypeano','$pat_accountcode','$currency','1','$adjamount','$discount')";

		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));



				// }
			// }
		}
				else

					{

					$totalaadjamount =0;
					$totaladiscount=0;

					$query67 = "select * from master_transactionpaylater where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$billnumbercode'";

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

					// if ($paymentmode == 'By Credit Note')

					// {

					 	$query45 = "UPDATE master_transactionpaylater set recordstatus='allocated',transactionamount='$restotalaadjamount',fxamount = '$restotalaadjamount',writeoffamount='$restotalaadjamount',billbalanceamount='$balamount',transactiondate='$dateonly',username='$username', discount='$restotaladiscount' where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$billnumbercode'";

						$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

					// }
				}

///////////////////// FOR ALLOCATION //////////////////////////////

	

		//header("location:creditnotelist.php");  
echo "<script>window.open('print_adhoc_creditnote.php?billno=$billnumbercode&&visitcode=$visitcode&&patientcode=$patientcode', '', 'location=yes,height=520,width=620,scrollbars=yes,status=yes');</script>";
echo "<script> window.location.href = 'creditnotelist.php';</script>";
		exit;

}
?>

<script>// window.open('print_adhoc_creditnote.php?billno=<?php echo $billno;?>&&visitcode=<?php echo $visitcode;?>&&patientcode=<?php echo $patientcode;?>'); </script>	

<?php

//to redirect if there is no entry in masters category or item or customer or settings







//To get default tax from autoitemsearch1.php and autoitemsearch2.php - for CST tax override.

if (isset($_REQUEST["defaulttax"])) { $defaulttax = $_REQUEST["defaulttax"]; } else { $defaulttax = ""; }

if(isset($_REQUEST['delete']))

{

$radiologyname=$_REQUEST['delete'];

mysqli_query($GLOBALS["___mysqli_ston"], "delete from consultation_radiology where radiologyitemname='$radiologyname'");

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

$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");

$execlab=mysqli_fetch_array($Querylab);

 $patientage=$execlab['age'];

 $patientgender=$execlab['gender'];

 $patientname = $execlab['customerfullname'];

 $billtype = $execlab['billtype'];



$patienttype=$execlab['maintype'];

$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$patienttype'");

$exectype=mysqli_fetch_array($querytype);

$patienttype1=$exectype['paymenttype'];

$patientsubtype=$execlab['subtype'];

$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$patientsubtype'");

$execsubtype=mysqli_fetch_array($querysubtype);

$patientsubtype1=$execsubtype['subtype'];

$patientplan=$execlab['planname'];

$queryplan=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_planname where auto_number='$patientplan'");

$execplan=mysqli_fetch_array($queryplan);

$patientplan1=$execplan['planname'];



?>

<?php

$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_customer where customercode='$patientcode'");
$execlab1=mysqli_fetch_array($querylab1);
$patientname=$execlab1['customerfullname'];
$patientaccount=$execlab1['accountname'];



$querylab2=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$patientaccount'");

$execlab2=mysqli_fetch_array($querylab2);

$patientaccount1=$execlab2['accountname'];



?>

<?php

$query3 = "select * from master_company where companystatus = 'Active'";

$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

$res3 = mysqli_fetch_array($exec3);

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

	

	

	$billnumbercode = 'CRN-' .$maxanum;

	$openingbalance = '0.00';

	//echo $companycode;

}?>

<script src="js/jquery-1.11.1.min.js"></script>

<script type="text/javascript">

$(document).ready(function()

{

$("#searchaccountname").keydown(function()

{

$("#searchaccountcode").val('');

});



});

</script>



<script language="javascript">







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


<script type="text/javascript" src="js/adhoc_insertnewcrdbnotes.js"></script>
<script type="text/javascript" src="js/adhoc_autosuggesaccountsearch1.js"></script>
<script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>


<script language="javascript">

var totalamount=0;

var totalamount1=0;

var totalamount2=0;  

var totalamount3=0;

var totalamount4=0;

var totalamount11;

var totalamount21;

var totalamount31;

var totalamount41;

var grandtotal=0;

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

function frequencyitem()

{

if(document.form1.frequency.value=="select")

{

alert("please select a frequency");

document.form1.frequency.focus();

return false;

}

return true;

}



function Functionfrequency()

{

var ResultFrequency;

 var frequencyanum = document.getElementById("frequency").value;

var medicinedose=document.getElementById("dose").value;

 var VarDays = document.getElementById("days").value; 

 if((frequencyanum != '') && (VarDays != ''))

 {

  ResultFrequency = medicinedose*frequencyanum * VarDays;

 }

 else

 {

 ResultFrequency =0;

 }

 document.getElementById("quantity").value = ResultFrequency;

var VarRate = document.getElementById("rate").value;

var ResultAmount = parseFloat(VarRate * ResultFrequency);

  document.getElementById("amount").value = ResultAmount.toFixed(2);

}

function processflowitem(varstate)

{

	//alert ("Hello World.");

	var varProcessID = varstate;



	//alert (varProcessID);

	var varItemNameSelected = document.getElementById("state").value;

	//alert (varItemNameSelected);

	ajaxprocess5(varProcessID);

	//totalcalculation();

}



function processflowitem1()

{

}

function btnDeleteClick4(delID4,amt_del)

{

	//alert ("Inside btnDeleteClick.");

	var newtotal;

	//alert(delID4);

	var varDeleteID4= delID4;
	var amt_del= amt_del;

	// alert(amt_del);

	 

	//alert(rateref);

	//alert (varDeleteID3);

	var fRet7; 

	fRet7 = confirm('Are You Sure Want To Delete This Entry?'); 

	//alert(fRet); 

	if (fRet7 == false)

	{

		//alert ("Item Entry Not Deleted.");

		return false;

	}



	var child4 = document.getElementById('idTR'+varDeleteID4);  

	//alert (child3);//tr name

    var parent4 = document.getElementById('insertrow4'); // tbody name.

	document.getElementById ('insertrow4').removeChild(child4);

	

	var child4= document.getElementById('idTRaddtxt'+varDeleteID4);  //tr name

    var parent4 = document.getElementById('insertrow4'); // tbody name.

	

	if (child4 != null) 

	{

		//alert ("Row Exsits.");

		document.getElementById ('insertrow4').removeChild(child4);

	}



var scode=document.getElementById('scode').value;

scode=parseInt(scode)-1;

document.getElementById('scode').value=scode;	


var currenttotal=document.getElementById('total').value.replace(/[^0-9\.]+/g,"");
// alert(currenttotal);

  newtotal= currenttotal-amt_del;
//alert(newtotal);
document.getElementById('total').value=newtotal.toFixed(2);

}



function validcheck()

{

var myElem = document.getElementById('scode').value;

if (myElem === '0') {  alert('Please add any account');  return false;} 



if(confirm("Do You Want To Save The Record?")==false){return false;}	

}



function funcamountcalc()

{



if(document.getElementById("units").value != '')

{

var units = document.getElementById("units").value;

var rate = document.getElementById("rate4").value;

var amount = units * rate;



document.getElementById("amount").value = amount.toFixed(2);



}

}





window.onload = function() 

{

	var oTextbox = new AutoSuggestControl(document.getElementById("searchaccountname"), new StateSuggestions());

}




function isNumberKey(evt, element) {
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57) && !(charCode == 46 || charCode == 8))
    return false;
  else {
    var len = $(element).val().length;
    var index = $(element).val().indexOf('.');
    if (index > 0 && charCode == 46) {
      return false;
    }
    if (index > 0) {
      var charAfterdot = (len + 1) - index;
      if (charAfterdot > 3) {
        return false;
      }
    }

  }
  return true;
}

function check_pen() {
var total_amount=document.getElementById('total').value;
if(total_amount==''){
	total_amount='0.00';
}
var single_amout = document.getElementById("amount").value;
var pending_amt=document.getElementById('balamount').value;
// alert(total_amount);
var total_final = parseFloat(total_amount)+parseFloat(single_amout);
// alert(total_final);
		if(total_final>pending_amt){
			alert('The Total Amount exceded than Pending Amount!');
			document.getElementById('amount').value='';
			document.getElementById('rate4').value='';
		}
	}

function getamt(acc){
var bill=document.getElementById('ref_num').value;
var patient=document.getElementById('patientcode').value;
var visit=document.getElementById('visitcode').value;
window.location="adhoccreditnote.php?billno="+bill+"&patientcode="+patient+"&visitcode="+visit+"&acc="+acc;
}

</script>



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

	font-size: 30px;

	font-weight: bold;

}

.style2 {

	font-size: 18px;

	font-weight: bold;

}

.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }

.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

.bal

{

border-style:none;

background:none;

text-align:right;

font-size: 30px;

	font-weight: bold;

	FONT-FAMILY: Tahoma

}

</style>



<script src="js/datetimepicker_css.js"></script>



</head>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<body >

<form name="form1" id="frmsales" method="post" action="adhoccreditnote.php" onKeyDown="return disableEnterKey(event)" onSubmit="return validcheck()">

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

        <td width="792"><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

            <tbody>

             <?php

		  

		  $locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';

		   $query1 = "select locationcode from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num1=mysqli_num_rows($exec1);

		
		while($res1 = mysqli_fetch_array($exec1))

		{

		

		

		$locationcodeget = $res1['locationcode'];

		$query551 = "select * from master_location where locationcode='".$locationcodeget."'";

		$exec551 = mysqli_query($GLOBALS["___mysqli_ston"], $query551) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$res551 = mysqli_fetch_array($exec551);

		$locationnameget = $res551['locationname'];

		}?>

                <tr bgcolor="#011E6A">

                <td colspan="4" bgcolor="#ecf0f5" class="bodytext32"><strong>Patient Details</strong></td>

                 <td colspan="3" class="bodytext31" bgcolor="#ecf0f5"><strong>Location &nbsp;</strong><?php echo $locationnameget;?></td>

                  <input type="hidden" name="locationcodeget" value="<?php echo $locationcodeget?>">

				<input type="hidden" name="locationnameget" value="<?php echo $locationnameget?>">

			 </tr>

		<tr>

                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>

			 </tr>

			

				<tr>

                <td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> <strong>Patient Name</strong>  </span></td>

                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				<input name="customername" id="customername" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18" type="hidden"><?php echo $patientname; ?>

				<input type="hidden" name="nameofrelative" id="nameofrelative" value="<?php echo $nameofrelative; ?>" style="border: 1px solid #001E6A;" size="45"></td>

                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				<strong>Patientcode</strong></td>

                <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				<input name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18" type="hidden"><?php echo $patientcode; ?></td>

				</tr>       

               

			   <tr>

			    <td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visitcode</strong></td>

                <td align="left" valign="middle" class="bodytext3">

				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" />	<?php echo $visitcode; ?></td>			

			   	  <td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>

                <td align="left" valign="top" class="bodytext3">
                	
				 <select name="account" id="account" onChange="getamt(this.value)">
                	<?php
					if(isset($_REQUEST['acc']))
						  $accountnumber=$_REQUEST['acc'];
						else
						  $accountnumber=0;

				    $bal=0;

                	 $sql12="SELECT accountname as accountname,accountcode, accountnameano,billbalanceamount from master_transactionpaylater where billnumber='$bill_num_get' and transactiontype='finalize'";
                	 // -- union all SELECT accountname  as accountname from billing_ipcreditapproved where billno='$bill_num_get'
					 $k=1;
						$querylab12=mysqli_query($GLOBALS["___mysqli_ston"], $sql12);
						if (mysqli_num_rows($querylab12) > 0) {
							while($execlab12=mysqli_fetch_array($querylab12)){
							 $patientaccount_final=$execlab12['accountname'];
							 $patientaccount_code=$execlab12['accountcode'];
							 $pat_accountanum=$execlab12['accountnameano'];

							 if($k==1){
								if($accountnumber==0){
                                   $accountnumber=$pat_accountanum;							      
								}
								 $bal=$execlab12['billbalanceamount'];
							 }

							 ?>
                              <option value="<?php echo $pat_accountanum; ?>" <?php if($pat_accountanum==$accountnumber) echo 'selected'; else echo ''; ?>><?php echo $patientaccount_final; ?></option>
							 <?php
                             $k++;
							}
					}
					 
                	?>
				</select>


				<input type="hidden" name="billtypes" id="billtypes" value="<?php echo $billtype; ?>" />

			</td>	

 </tr>

				  <tr>

							 <td align="left" valign="middle" class="bodytext3"><strong> Date</strong></td>

				<td class="bodytext3"><input type="hidden" name="billdate" id="billdate" value="<?php echo $dateonly; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>

				<?php echo $dateonly; ?>				</td>	

                 <td align="left" valign="middle" class="bodytext3"><strong>Doc No</strong></td>

				<td class="bodytext3"><input type="hidden" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	

				<?php echo $billnumbercode; ?>							</td>

				  </tr>

				<tr>

						<td align="left" valign="middle" class="bodytext3"><strong> Ref No. </strong></td>
						<td class="bodytext3"><input type="hidden" name="ref_num" id="ref_num" value="<?php echo $bill_num_get; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/> <?php echo $bill_num_get; ?> </td>

						<?php
						
						  $query2 = "SELECT billbalanceamount from master_transactionpaylater where billnumber='$bill_num_get' and accountcode = '$patientaccount_code' and transactionstatus <> 'onaccount' and acc_flag = '0' and transactiontype not in ('pharmacycredit','paylatercredit')  and accountnameano='".$accountnumber."' order by transactiondate ASC";

								$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
								$num_rows=mysqli_num_rows($exec2);

							if($num_rows>0){
								while ($res2 = mysqli_fetch_array($exec2)){
									 $balamount = $res2['billbalanceamount'];
								}
							}else
							{
                             $balamount = $bal;
							}
														?>
						<td align="left" valign="middle" class="bodytext3"><strong>Pending Amt </strong></td>
						<td class="bodytext3"><input type="hidden" name="balamount" id="balamount" value="<?php echo $balamount; ?>"/> <?php   echo number_format($balamount,2,'.',','); ?> </td>	

						<!-- <td align="left" valign="middle" class="bodytext3"><strong>Ref No.</strong></td>
						<td class="bodytext3">
							<input type="text" name="ref_num" id="ref_num" value="" style="border: 1px solid #001E6A" size="18" rsize="20" autocomplete="off" /> 
						</td> -->

				</tr>

				 		

				 

				  	<tr>

                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>

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

				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><strong>Credit Note</strong> </span></td>

		        </tr>

				<tr id="reffid">

				    <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">

                     <tr>

                                      <td width="30" class="bodytext3">Account</td>

                       <td width="30" class="bodytext3">Description</td>

                       <td class="bodytext3">Unit</td>

					     <td class="bodytext3">Rate</td>

						  <td class="bodytext3">Amount</td>

                     </tr>

					  <tr>

					 <div id="insertrow4">					 </div></tr>

					  <tr>

					  <input type="hidden" name="scode" id="scode" value="0">

					  <input type="hidden" name="serialnumber4" id="serialnumber4" value="1">

					  <input type="hidden" name="referalcode" id="referalcode" value="">

                       <td width="30">

                   <input name="autobuildaccount" type="hidden" id="autobuildaccount" size="30">

                   <input name="searchaccountcode" type="hidden" id="searchaccountcode" size="30">

                   <input name="searchaccountname" type="text" id="searchaccountname" size="30"></td>

				   <td width="30"><input name="referal[]" type="text" id="referal" size="30"></td>

				    <td width="30"><input name="units[]" type="text" id="units" size="8" onKeyPress="return isNumberKey(event,this)"></td>

				    <td width="30"><input name="rate4[]" type="text" id="rate4" size="8" onKeyUp="funcamountcalc(), check_pen();" onKeyPress="return isNumberKey(event,this)"></td>

					  <td width="30"><input name="amount[]" type="text" id="amount" readonly size="8" ></td>
					  <!-- onclick="return check_pen();"  -->
					   <td><label>

                       <input type="button" name="Add4" id="Add4" value="Add" onClick="return insertitem5()" class="button">

                       </label></td>

					   </tr>

					    </table></td>

		        </tr>


		         <tr> <td>&nbsp;</td>  </tr>
            <tr> <td>&nbsp;</td>  </tr>
            <tr>
              <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total Amt  </span>
              	<input type="text" id="total" name="total_amount" readonly size="10" style="font-size:25px; text-align:right"></td>
            </tr>

			

		

          </tbody>

        </table>		</td></tr>

		

		<tr>

		<td>&nbsp;		</td>

		</tr>

             

               <tr>

	  <td colspan="7" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

	   <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">

	    <input name="Submit2223" type="submit" value="Save" accesskey="b" class="button" style="font-size:30px"/>		</td>

	  </tr>

              

            </tbody>

        </table>

	  </td>

		</tr>

     

    </table>



</form>

<?php include ("includes/footer1.php"); ?>

<?php //include ("print_bill_dmp4inch1.php"); ?>

</body>

</html>
<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');

$updatetime = date('H:i:s');
$updatedate = date('Y-m-d');
$currentdate = date('Y-m-d');


$docno = $_SESSION['docno'];
 //get location for sort by location purpose
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		  $locationcode=$location;
		}
		//location get end here
  $loadtext=isset($_REQUEST['loadtext'])?$_REQUEST['loadtext']:'';
  $availableamount=isset($_REQUEST['availableamount'])?$_REQUEST['availableamount']:'';
  
   $patientname=isset($_REQUEST['ptname1'])?$_REQUEST['ptname1']:'';
    $patientcode=isset($_REQUEST['regcode1'])?$_REQUEST['regcode1']:'';
	 $visitcode=isset($_REQUEST['ipcode1'])?$_REQUEST['ipcode1']:'';
	  $packagename=isset($_REQUEST['packg1'])?$_REQUEST['packg1']:'';
	   $packagecost=isset($_REQUEST['costpkg1'])?$_REQUEST['costpkg1']:'';
	    $accountname=isset($_REQUEST['account1'])?$_REQUEST['account1']:'';
		 $patientbilltype=isset($_REQUEST['billtype1'])?$_REQUEST['billtype1']:'';
		 $locationcodeget=isset($_REQUEST['locationcodeget1'])?$_REQUEST['locationcodeget1']:'';
 $locationnameget=isset($_REQUEST['locationnameget1'])?$_REQUEST['locationnameget1']:'';
  $hpldoctor='';
 if($patientbilltype == 'PAY NOW')
		{
		$stat = 'paid';
		}
		else
		{
		$stat = 'unpaid';
		}
  if($loadtext!='')
  {
	  for($i=1; $i<5; $i++)
	  { //echo $i;
	  $hpldoctor=isset($_REQUEST['hpldoctor'.$i])?$_REQUEST['hpldoctor'.$i]:'';
	  $pvtdoctor=isset($_REQUEST['pvtdoctor'.$i])?$_REQUEST['pvtdoctor'.$i]:'';
	  $hpldoctorcode=isset($_REQUEST['hpldoctorcode'.$i])?$_REQUEST['hpldoctorcode'.$i]:'';
	  $hpldoctorrate=isset($_REQUEST['hpldoctorrate'.$i])?$_REQUEST['hpldoctorrate'.$i]:'';
	  $pvtdoctorcode=isset($_REQUEST['pvtdoctorcode'.$i])?$_REQUEST['pvtdoctorcode'.$i]:'';
	  $pvtdoctorrate=isset($_REQUEST['pvtdoctorrate'.$i])?$_REQUEST['pvtdoctorrate'.$i]:'';
	  
	
	if($pvtdoctorcode!='' && $availableamount >=0)
	{
		$query52 = "insert into privatedoctor_billing(description,rate,amount,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,billstatus,doctorstatus,billtype,locationname,locationcode,doctorcode,quantity)values('$pvtdoctor','$pvtdoctorrate','$pvtdoctorrate','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$stat','unpaid','$patientbilltype','".$locationnameget."','".$locationcodeget."','".$pvtdoctorcode."',1)";
		$exec52=mysqli_query($GLOBALS["___mysqli_ston"], $query52) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query53 = "insert into billing_ipprivatedoctor(description,rate,amount,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,billstatus,doctorstatus,billtype,locationname,locationcode,quantity)values('$pvtdoctor','$pvtdoctorrate','$pvtdoctorrate','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$stat','unpaid','$patientbilltype','".$locationnameget."','".$locationcodeget."',1)";
		$exec53=mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		
	if($hpldoctorcode!='' && $availableamount >=0)
	{
		$query52 = "insert into residentdoctor_billing(description,rate,amount,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,billstatus,doctorstatus,billtype,locationname,locationcode,doctorcode,quantity)values('$hpldoctor','$hpldoctorrate','$hpldoctorrate','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$stat','unpaid','$patientbilltype','".$locationnameget."','".$locationcodeget."','".$hpldoctorcode."',1)";
		$exec52=mysqli_query($GLOBALS["___mysqli_ston"], $query52) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	
	  }
	  
	 /* $hpldoctor2=isset($_REQUEST['hpldoctor2'])?$_REQUEST['hpldoctor2']:'';
	  $pvtdoctor2=isset($_REQUEST['pvtdoctor2'])?$_REQUEST['pvtdoctor2']:'';
	  $hpldoctorcode2=isset($_REQUEST['hpldoctorcode2'])?$_REQUEST['hpldoctorcode2']:'';
	  $hpldoctorrate2=isset($_REQUEST['hpldoctorrate2'])?$_REQUEST['hpldoctorrate2']:'';
	  $pvtdoctorcode2=isset($_REQUEST['pvtdoctorcode2'])?$_REQUEST['pvtdoctorcode2']:'';
	  $pvtdoctorrate2=isset($_REQUEST['pvtdoctorrate2'])?$_REQUEST['pvtdoctorrate2']:'';
	  
	  $hpldoctor3=isset($_REQUEST['hpldoctor3'])?$_REQUEST['hpldoctor3']:'';
	  $pvtdoctor3=isset($_REQUEST['pvtdoctor3'])?$_REQUEST['pvtdoctor3']:'';
	  $hpldoctorcode3=isset($_REQUEST['hpldoctorcode3'])?$_REQUEST['hpldoctorcode3']:'';
	  $hpldoctorrate3=isset($_REQUEST['hpldoctorrate3'])?$_REQUEST['hpldoctorrate3']:'';
	  $pvtdoctorcode3=isset($_REQUEST['pvtdoctorcode3'])?$_REQUEST['pvtdoctorcode3']:'';
	  $pvtdoctorrate3=isset($_REQUEST['pvtdoctorrate3'])?$_REQUEST['pvtdoctorrate3']:'';
	  
	  $hpldoctor4=isset($_REQUEST['hpldoctor4'])?$_REQUEST['hpldoctor4']:'';
	  $pvtdoctor4=isset($_REQUEST['pvtdoctor4'])?$_REQUEST['pvtdoctor4']:'';
	  $hpldoctorcode4=isset($_REQUEST['hpldoctorcode4'])?$_REQUEST['hpldoctorcode4']:'';
	  $hpldoctorrate4=isset($_REQUEST['hpldoctorrate4'])?$_REQUEST['hpldoctorrate4']:'';
	  $pvtdoctorcode4=isset($_REQUEST['pvtdoctorcode4'])?$_REQUEST['pvtdoctorcode4']:'';
	  $pvtdoctorrate4=isset($_REQUEST['pvtdoctorrate4'])?$_REQUEST['pvtdoctorrate4']:'';*/
	  
	  
	  }
$query1111 = "select * from master_employee where username = '$username'";
$exec1111 = mysqli_query($GLOBALS["___mysqli_ston"], $query1111) or die ("Error in Query1111".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1111 = mysqli_fetch_array($exec1111))
{
$locationnumber = $res1111["location"];
$query1112 = "select * from master_location where auto_number = '$locationnumber' and status<>'delete'";
$exec1112 = mysqli_query($GLOBALS["___mysqli_ston"], $query1112) or die ("Error in Query1112".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1112 = mysqli_fetch_array($exec1112))
{
 $locationname = $res1112["locationname"];    
 $locationcode = $res1112["locationcode"];
}
 }
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

//This include updatation takes too long to load for hunge items database.


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

$visitcode=isset($_REQUEST['visitcode'])?$_REQUEST['visitcode']:'';
 $query1 = "select mipv.patientcode,mipv.accountname,mipv.visitcode,mipv.patientfullname,mipp.packagename,mipv.package,mipp.rate,mipv.billtype,mipv.locationcode,mipv.locationname from master_ippackage as mipp  LEFT JOIN master_ipvisitentry as mipv ON mipv.package = mipp.auto_number where visitcode = '".$visitcode."'  AND mipv.visitcode NOT IN (SELECT visitcode FROM billing_ip )  order by patientfullname ";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);

	$res1customercode = $res1['patientcode'];
	$res1patientfullname=$res1['patientfullname'];
	$res1accountname = $res1['accountname'];
	
	$res1visitcode = $res1['visitcode'];
	$res1packagename = $res1['packagename'];
	$res1package = $res1['package'];
	$res1rate = $res1['rate'];
	$res1billtype = $res1['billtype'];
	$locationcode = $res1['locationcode'];
	$locationname = $res1['locationname'];
	
	$query111 = "select * from master_accountname where auto_number = '$res1accountname'";
	$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res111 = mysqli_fetch_array($exec111);
	$res111accountname = $res111['accountname'];

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
function calculateamount()
{//alert("ok");
	var totapack = document.getElementById("totalpackagecost").value;
	//alert(totapack);
	var pvt1=document.getElementById("pvtdoctorrate1").value; //alert(pvt1);
	var pvt2=document.getElementById("pvtdoctorrate2").value; //alert(pvt2);
	var pvt3=document.getElementById("pvtdoctorrate3").value;// alert(pvt3);
	var pvt4=document.getElementById("pvtdoctorrate4").value; //alert(pvt4);
	
	if(pvt1==''){pvt1=0;}
	if(pvt2==''){pvt2=0;}
	if(pvt3==''){pvt3=0;}
	if(pvt4==''){pvt4=0;}
	
	var pvtd1=document.getElementById("hpldoctorrate1").value; //alert(pvtd1);
	var pvtd2=document.getElementById("hpldoctorrate2").value; //alert(pvtd2);
	var pvtd3=document.getElementById("hpldoctorrate3").value;// alert(pvt3);
	var pvtd4=document.getElementById("hpldoctorrate4").value; //alert(pvt4);
	
	if(pvtd1==''){pvtd1=0;}
	if(pvtd2==''){pvtd2=0;}
	if(pvtd3==''){pvtd3=0;}
	if(pvtd4==''){pvtd4=0;}
	
	var pvttotal = parseFloat(pvt1)+parseFloat(pvt2)+parseFloat(pvt3)+parseFloat(pvt4)+parseFloat(pvtd1)+parseFloat(pvtd2)+parseFloat(pvtd3)+parseFloat(pvtd4); //alert(parseFloat(pvttotal));
	
	var newtotal = parseFloat(totapack)-parseFloat(pvttotal);//alert(newtotal);
	
	document.getElementById("availableamount1").value=newtotal.toFixed(2);
	document.getElementById("availableamount").value=newtotal.toFixed(2);
	if(totapack<pvttotal){alert("Doctor's Cost Greater than Available Package"); return false;}
	}
	
function calculateamount1(doc,val)
{//alert("ok");

if(document.getElementById(doc).value=='')
{
	alert('Please Select Doctor');
	document.getElementById(val).value='';
	return false;
	}
	var totapack = document.getElementById("totalpackagecost").value;
	//alert(totapack);
	var pvt1=document.getElementById("pvtdoctorrate1").value; //alert(pvt1);
	var pvt2=document.getElementById("pvtdoctorrate2").value; //alert(pvt2);
	var pvt3=document.getElementById("pvtdoctorrate3").value;// alert(pvt3);
	var pvt4=document.getElementById("pvtdoctorrate4").value; //alert(pvt4);
	
	if(pvt1==''){pvt1=0;}
	if(pvt2==''){pvt2=0;}
	if(pvt3==''){pvt3=0;}
	if(pvt4==''){pvt4=0;}
	
	var pvtd1=document.getElementById("hpldoctorrate1").value; //alert(pvtd1);
	var pvtd2=document.getElementById("hpldoctorrate2").value; //alert(pvtd2);
	var pvtd3=document.getElementById("hpldoctorrate3").value;// alert(pvt3);
	var pvtd4=document.getElementById("hpldoctorrate4").value; //alert(pvt4);
	
	if(pvtd1==''){pvtd1=0;}
	if(pvtd2==''){pvtd2=0;}
	if(pvtd3==''){pvtd3=0;}
	if(pvtd4==''){pvtd4=0;}
	
	var pvttotal = parseFloat(pvt1)+parseFloat(pvt2)+parseFloat(pvt3)+parseFloat(pvt4)+parseFloat(pvtd1)+parseFloat(pvtd2)+parseFloat(pvtd3)+parseFloat(pvtd4); //alert(parseFloat(pvttotal));
	
	var newtotal = parseFloat(totapack)-parseFloat(pvttotal);//alert(newtotal);
	
	document.getElementById("availableamount1").value=newtotal.toFixed(2);
	document.getElementById("availableamount").value=newtotal.toFixed(2);
	if(totapack<pvttotal){alert("Doctor's Cost Greater than Available Package"); return false;}
	}
function funcOnLoadBodyFunctionCall()
{ 
	//alert ("Inside Body On Load Fucntion.");
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	//locationform();
	//funcDepartmentChange();
	//funcConsultationTypeChange();
//	funcbankDropDownSearch1();
		var oTextbox = new AutoSuggestControlcustomer(document.getElementById("hpldoctor1"), new StateSuggestionscustomer()); 
		
		var oTextbox1 = new AutoSuggestControlcustomer1(document.getElementById("hpldoctor2"), new StateSuggestionscustomer()); 
		var oTextbox2 = new AutoSuggestControlcustomer2(document.getElementById("hpldoctor3"), new StateSuggestionscustomer()); 
		var oTextbox3 = new AutoSuggestControlcustomer3(document.getElementById("hpldoctor4"), new StateSuggestionscustomer()); 
		
		var oTextbox11 = new AutoSuggestControlcustomer11(document.getElementById("pvtdoctor1"), new StateSuggestionscustomer());
		var oTextbox12 = new AutoSuggestControlcustomer12(document.getElementById("pvtdoctor2"), new StateSuggestionscustomer());
		var oTextbox13 = new AutoSuggestControlcustomer13(document.getElementById("pvtdoctor3"), new StateSuggestionscustomer());
		var oTextbox14 = new AutoSuggestControlcustomer14(document.getElementById("pvtdoctor4"), new StateSuggestionscustomer()); 
		
	//alert(oTextbox); 
	//funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
	//distriage();
}

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
function cbsuppliername1()
{
	document.cbform1.submit();
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
		document.getElementById("cbfrmflag1").value = "<?php echo $cbfrmflag1; ?>";
		return false;
	}
}


function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

</script>
<script>
<?php 
if (isset($_REQUEST["refundbillnumber"])) { $refundbillnumbers = $_REQUEST["refundbillnumber"]; } else { $refundbillnumbers = ""; }
if (isset($_REQUEST["patientcode"])) { $refundpatientcode = $_REQUEST["patientcode"]; } else { $refundpatientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $refundvisitcode= $_REQUEST["visitcode"]; } else { $refundvisitcode = ""; }
if (isset($_REQUEST["locationode"])) { $refundlocationode= $_REQUEST["locationode"]; } else { $refundlocationode = ""; }
?>
	var refundbillnumber;
	var refundbillnumber = "<?php echo $refundbillnumbers; ?>";
	var refundpatientcodes;
	var refundpatientcodes = "<?php echo $refundpatientcode; ?>";
	var refundvisitcodes;
	var refundvisitcodes = "<?php echo $refundvisitcode; ?>";
	var refloccode;
	var refloccode = "<?php echo $refundlocationode; ?>";
	//alert(refundbillnumber);
	if(refundbillnumber != "") 
	{
		window.open("print_paynow_refund.php?billnumber="+refundbillnumber+"&&patientcode="+refundpatientcodes+"&&visitcode="+refundvisitcodes+"&&locationcode="+refloccode,"OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}	
</script>
<script>
<?php 
if (isset($_REQUEST["otcbillnumber"])) { $otcbillnumbers = $_REQUEST["otcbillnumber"]; } else { $otcbillnumbers = ""; }
?>
	var otcbillnumberr;
	var otcbillnumberr = "<?php echo $otcbillnumbers; ?>";
	//alert(refundbillnumber);
	if(otcbillnumberr != "") 
	{
		window.open("print_otcbilling_dmp4inch1.php?billnumber="+otcbillnumberr,"OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}	
</script>
<script>
<?php 
if (isset($_REQUEST["paynowpatientcode"])) { $paynowpatientcoder = $_REQUEST["paynowpatientcode"]; } else { $paynowpatientcoder = ""; }
if (isset($_REQUEST["paynowbillnumber"])) { $paynowbillnumbers = $_REQUEST["paynowbillnumber"]; } else { $paynowbillnumbers = ""; }
if (isset($_REQUEST["paynowpatientcode1"])) { $paynowpatientcoder1 = $_REQUEST["paynowpatientcode1"]; } else { $paynowpatientcoder1 = ""; }
?>
	var paynowpatientcoderr;
	var paynowpatientcoderr = "<?php echo $paynowpatientcoder; ?>";
	
	
	
	var paynowbillnumberr;
	var paynowbillnumberr = "<?php echo $paynowbillnumbers; ?>";
	//copay
	var paynowpatientcoderr1;
	var paynowpatientcoderr1 = "<?php echo $paynowpatientcoder1; ?>";
	//alert(refundbillnumber);
	if(paynowpatientcoderr1 != "") 
	{
		window.open("print_billpaynowbill_dmp4inch_copay.php?billautonumber="+paynowbillnumberr+"&&patientcode="+paynowpatientcoderr+"","OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}	
	else if(paynowpatientcoderr != "") 
	{
		window.open("print_billpaynowbill_dmp4inch1.php?billautonumber="+paynowbillnumberr+"&&patientcode="+paynowpatientcoderr+"","OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}	
	
</script>
<script>	
<?php 
if (isset($_REQUEST["consbillautonumber"])) { $consbillautonumbers = $_REQUEST["consbillautonumber"]; } else { $paynowpatientcoder = ""; }
?>
	var consbillautonumberr;
	var consbillautonumberr = "<?php echo $consbillautonumbers; ?>";
	//alert(refundbillnumber);
	if(consbillautonumberr != "") 
	{
		window.open("print_consultationbill_dmp4inch1.php?billautonumber="+consbillautonumberr+"","OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}				
</script>
<script>	
<?php 
if (isset($_REQUEST["ipbillnumber"])) { $ipbillnumbers = $_REQUEST["ipbillnumber"]; } else { $ipbillnumbers = ""; }
if (isset($_REQUEST["ippatientcode"])) { $ippatientcodes = $_REQUEST["ippatientcode"]; } else { $ipbillnumbers = ""; }
?>
	var ipbillnumberr;
	var ipbillnumberr = "<?php echo $ipbillnumbers; ?>";
	var ippatientcoder;
	var ippatientcoder = "<?php echo $ippatientcodes; ?>";
	//alert(refundbillnumber);
	if(ipbillnumberr != "") 
	{
		window.open("print_depositcollection_dmp4inch1.php?billnumbercode="+ipbillnumberr+"&&patientcode="+ippatientcoder+"","OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
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
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript" src="js/autosuggestpackagedoc.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autosuggestpackagedocpri.js"></script>

<script type="text/javascript" src="js/autosuggestpackagedoc1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autosuggestpackagedocpri1.js"></script>

<script type="text/javascript" src="js/autosuggestpackagedoc2.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autosuggestpackagedocpri2.js"></script>

<script type="text/javascript" src="js/autosuggestpackagedoc3.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autosuggestpackagedocpri3.js"></script>

<script type="text/javascript" src="js/autocomplete_newcustomerpackage.js"></script>
<script type="text/javascript" src="js/autocustomercodesearchpackage.js"></script>

<body onLoad="return funcOnLoadBodyFunctionCall()">
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
        <td width="800" rowspan="9"><form name="cbform1" method="post" action="patientbillingstatus_bills.php">
          <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
		  <!--<tr bgcolor="red">
              <td colspan="4" bgcolor="red" class="bodytext3"><strong> PLEASE REFRESH PAGE BEFORE MAKING BILL </strong></td>
              </tr>-->
            <tr bgcolor="#011E6A">
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong> Package Split Billing </strong></td>
              <td colspan="1" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                
                  <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						?>
						<?php echo $res1location; ?>
						<?php
						}
						?>
                   <input type="hidden" name="location" id="location" value="<?php echo $res1locationanum;?>">
						
                  
                  </td>
     
              </tr>
             <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input type="text" name="ptname" id="ptname" disabled value="<?php echo $res1patientfullname;?>">
              </span></td>
              </tr>
			    <tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Code</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input type="text" name="regcode" id="regcode" disabled value="<?php echo $res1customercode;?>">
              </span></td>
              </tr>
              <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Visitcode</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input type="text" name="ipcode" id="ipcode" disabled value="<?php echo $res1visitcode;?>">
              </span></td>
              </tr>
              <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Package</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input type="text" name="packg" id="packg" disabled value="<?php echo $res1packagename;?>">
              </span></td>
              </tr>
              <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Package Cost</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input type="text" name="costpkg" id="costpkg" disabled value="<?php echo $res1rate;?>">
              </span></td>
              </tr>
              <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Account</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input type="text" name="account" id="account" disabled value="<?php echo $res111accountname;?>">
              </span></td>
              </tr>
              
              <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Bill Type</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input type="text" name="billtype" id="billtype" disabled value="<?php echo $res1billtype;?>">
                <input type="hidden" name="locationcodeget" id="locationcodeget" disabled value="<?php echo $locationcode;?>">
                <input type="hidden" name="locationnameget" id="locationnameget" disabled value="<?php echo $locationname;?>">
              </span></td>
              </tr>
			   <!-- <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Registration No</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patientcode" type="text" id="patient" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="visitcode" type="text" id="visitcode" value="" size="50" autocomplete="off">
              </span></td>
              </tr>-->
			<?php /*?>  <tr>
          <td width="136" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="131" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="76" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="425" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr><?php */?>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			 <!-- <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />-->
                 <!-- <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" />--></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
        <td width="481" class="bodytext3" style="font-size: 14px">&nbsp;</td>
      </tr>
      <!--<tr>
        <td class="bodytext3" style="font-size: 14px"><span class="bodytext32" style="font-size: 14px"><strong><a href="externalbilling.php" target="_blank" style="text-decoration:none;">External Billing </a></strong></span></td>
      </tr>-->
     <!-- <tr>
        <td class="bodytext3" style="font-size: 14px"><span class="bodytext32" style="font-size: 14px"><strong><a href="billing_pending_op2.php" target="_blank" style="text-decoration:none;">Credit Patient Billing</a></strong></span></td>
      </tr>-->
     <!-- <tr>
         <td class="bodytext3" style="font-size: 14px"><span class="bodytext32" style="font-size: 14px"><strong><a href="ipbilling.php" target="_blank" style="text-decoration:none;">Inpatient Billing </a></strong></span></td>
      </tr>
      <tr>
        <td><span class="bodytext32" style="font-size: 14px"><strong><a href="advancedeposit.php" target="_blank" style="text-decoration:none;">Advance Deposit </a></strong></span></td>
      </tr>
      <tr>
         <td><span class="bodytext32" style="font-size: 14px"><strong><a href="approvedcreditlist.php" target="_blank" style="text-decoration:none;">Approved Credit List </a></strong></span></td>
      </tr>-->
      <!--<tr>
        <td><span class="bodytext32" style="font-size: 14px"><strong><a href="consultationrefundlist.php" target="_blank" style="text-decoration:none;">Consultation Refund </a></strong></span></td>
      </tr>
      <tr>-->
        <!--<td><span class="bodytext32" style="font-size: 14px"><strong><a href="paylaterrefundlist.php" target="_blank" style="text-decoration:none;">Credit Patient Refund </a></strong></span></td>
      </tr>
      <tr>
        <td><span class="bodytext32" style="font-size: 14px"><strong><a href="refundreferrallist.php" target="_blank" style="text-decoration:none;">Pay Now Referral Refund </a></strong></span></td>
      </tr>-->
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
       <tr>
        <td colspan="2">&nbsp;</td>
      </tr> <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
       <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
       <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
       <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
	  <tr>
        <td colspan="2">&nbsp;
	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];


	// $searchpatient = $_POST['patient'];
	//$searchpatientcode=$_POST['patientcode'];
	//$searchvisitcode = $_POST['visitcode'];
	//$fromdate=$_POST['ADate1'];
	//$todate=$_POST['ADate2'];



	//echo $searchpatient;
		//$transactiondatefrom = $_REQUEST['ADate1'];
	//$transactiondateto = $_REQUEST['ADate2'];


	
?>
<form name="form1" id="form1" method="post" action="packagesplitbill.php">	
		<table id="AutoNumber33" style="BORDER-COLLAPSE: collapse; " 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" 
            align="left" border="0">
          <tbody>
             
           <tr>
                <td width="44"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Category</strong></td>
                               <td width="96" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Hospital Doctor</strong></td>
				  <td width="100" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Private Doctor</strong></td>
					 
                 
                 </tr>
                 <tr bgcolor="#CBDBFA">
               
                               <td width="96" align="left" valign="center"  
                class="bodytext31"><strong> Surgeon</strong></td>
				  <td width="500" align="left" valign="center"  
                class="bodytext31"><strong> <input name="hpldoctor1" id="hpldoctor1" size="40" autocomplete="off" ></strong>
                <input name="customerhiddentextbox" id="customerhiddentextbox" value="" type="hidden">
                
                <input name="hpldoctorcode1" id="hpldoctorcode1" value="" size="20" type="hidden">
                <input name="hpldoctorrate1" id="hpldoctorrate1" value="" size="10" type="text"  onKeyUp="calculateamount1('hpldoctor1','hpldoctorrate1')">
                
				  <input name="customercode" id="customercode" value="" type="hidden"></td>
					  <td width="93" align="left" valign="center"  
                 class="bodytext31"><strong> <input name="pvtdoctor1" id="pvtdoctor1" size="40" autocomplete="off"></strong>
                  <input name="pvtdoctorcode1" id="pvtdoctorcode1" value="" size="20" type="hidden">
                <input name="pvtdoctorrate1" id="pvtdoctorrate1" value="" size="10" type="text" onKeyUp="calculateamount1('pvtdoctor1','pvtdoctorrate1')"></td>
			
			       
                 
                 </tr>
                  <tr bgcolor="#CBDBFA">
               
                               <td width="96" align="left" valign="center"  
                class="bodytext31"><strong> Anaesthestist</strong></td>
				  <td width="500" align="left" valign="center"  
                class="bodytext31"><strong> <input name="hpldoctor2" id="hpldoctor2" size="40" autocomplete="off"></strong>
                <input name="customerhiddentextbox" id="customerhiddentextbox" value="" type="hidden">
                
                <input name="hpldoctorcode2" id="hpldoctorcode2" value="" size="20" type="hidden">
                <input name="hpldoctorrate2" id="hpldoctorrate2" value="" size="10" type="text"  onKeyUp="calculateamount1('hpldoctor2','hpldoctorrate2')">
                
				  <input name="customercode" id="customercode" value="" type="hidden"></td>
					  <td width="93" align="left" valign="center"  
                 class="bodytext31"><strong> <input name="pvtdoctor2" id="pvtdoctor2" size="40" autocomplete="off"></strong>
                  <input name="pvtdoctorcode2" id="pvtdoctorcode2" value="" size="20" type="hidden">
                <input name="pvtdoctorrate2" id="pvtdoctorrate2" value="" size="10" type="text"  onKeyUp="calculateamount1('pvtdoctor2','pvtdoctorrate2')"></td>
			
			       
                 
                 </tr>
                  <tr bgcolor="#CBDBFA">
               
                               <td width="96" align="left" valign="center"  
                class="bodytext31"><strong> Paed</strong></td>
				  <td width="500" align="left" valign="center"  
                class="bodytext31"><strong> <input name="hpldoctor3" id="hpldoctor3" size="40" autocomplete="off"></strong>
                <input name="customerhiddentextbox" id="customerhiddentextbox" value="" type="hidden">
                
                <input name="hpldoctorcode3" id="hpldoctorcode3" value="" size="20" type="hidden">
                <input name="hpldoctorrate3" id="hpldoctorrate3" value="" size="10" type="text"  onKeyUp="calculateamount1('hpldoctor3','hpldoctorrate3')">
                
				  <input name="customercode" id="customercode" value="" type="hidden"></td>
					  <td width="93" align="left" valign="center"  
                 class="bodytext31"><strong> <input name="pvtdoctor3" id="pvtdoctor3" size="40" autocomplete="off"></strong>
                  <input name="pvtdoctorcode3" id="pvtdoctorcode3" value="" size="20" type="hidden">
                <input name="pvtdoctorrate3" id="pvtdoctorrate3" value="" size="10" type="text"  onKeyUp="calculateamount1('pvtdoctor3','pvtdoctorrate3')"></td>
			
			       
                 
                 </tr>
                  </tr>
                  <tr bgcolor="#CBDBFA">
               
                               <td width="96" align="left" valign="center"  
                class="bodytext31"><strong> Others</strong></td>
				  <td width="500" align="left" valign="center"  
                class="bodytext31"><strong> <input name="hpldoctor4" id="hpldoctor4" size="40" autocomplete="off"></strong>
                <input name="customerhiddentextbox" id="customerhiddentextbox" value="" type="hidden">
                
                <input name="hpldoctorcode4" id="hpldoctorcode4" value="" size="20" type="hidden">
                <input name="hpldoctorrate4" id="hpldoctorrate4" value="" size="10" type="text"  onKeyUp="calculateamount1('hpldoctor4','hpldoctorrate4')">
                
				  <input name="customercode" id="customercode" value="" type="hidden"></td>
					  <td width="93" align="left" valign="center"  
                 class="bodytext31"><strong> <input name="pvtdoctor4" id="pvtdoctor4" size="40" autocomplete="off"></strong>
                  <input name="pvtdoctorcode4" id="pvtdoctorcode4" value="" size="20" type="hidden">
                <input name="pvtdoctorrate4" id="pvtdoctorrate4" value="" size="10" type="text"  onKeyUp="calculateamount1('pvtdoctor4','pvtdoctorrate4')"></td>
			
			       
                 
                 </tr>
			  
              <tr>
                     <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				            <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><b>Package Amount :<?php echo $res1rate;?></b><input type="hidden" name="totalpackagecost" id="totalpackagecost" value="<?php echo $res1rate;?>"></td>
        
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><b>Available Amount : <input type="text" readonly style="border:none;background:none" value="0.00" id="availableamount" name="availableamount"></b><input type="hidden" name="availableamount1" id="availableamount1" value=""></td>
				 
             
               
                
           	</tr>
           <tr> <td><input type="submit"></td><td></td><td></td></tr>
           <input type="hidden" name="loadtext" value="loadtext">
          </tbody>
        </table>













                <input type="hidden" name="ptname1" id="ptname1"  value="<?php echo $res1patientfullname;?>">
                <input type="hidden" name="regcode1" id="regcode1"  value="<?php echo $res1customercode;?>">
                <input type="hidden" name="ipcode1" id="ipcode1"  value="<?php echo $res1visitcode;?>">
                <input type="hidden" name="packg1" id="packg1"  value="<?php echo $res1packagename;?>">
                <input type="hidden" name="costpkg1" id="costpkg1"  value="<?php echo $res1rate;?>">
                <input type="hidden" name="account1" id="account1"  value="<?php echo $res111accountname;?>">
                <input type="hidden" name="billtype1" id="billtype1"  value="<?php echo $res1billtype;?>">
                <input type="hidden" name="locationcodeget1" id="locationcodeget1"  value="<?php echo $locationcode;?>">
                <input type="hidden" name="locationnameget1" id="locationnameget1"  value="<?php echo $locationname;?>">
              </span></td>
              </tr>
		 </form>
		 <?php
		 
		 ?>		</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
	  
	 
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>


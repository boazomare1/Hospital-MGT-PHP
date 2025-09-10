<?php 
session_start();
include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");
$errmsg = "";
$bgcolorcode = "";
$pagename = "";
$consultationfees1 = '';
$availablelimit = '';
$admissionfees = '';
$photoavailable = '';

$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$locationcode=isset($_REQUEST["location"])?$_REQUEST["location"]:''; 
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_customer1.php");

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
$ipaddress = $_SERVER["REMOTE_ADDR"];
$username = $_SESSION['username'];
	
if($username != '')
{
	$patientcode=$_REQUEST["patientcode"];
	$locationcode=$_REQUEST["location"]; 
	
		$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
	$res12location = $res["locationname"];
	$res12locationanum = $res["auto_number"];

$query3 = "select * from master_location where status = '' and locationcode='$locationcode'"; 
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$visitcodeprefix = $res3['prefix'];
$reslocationcode = $res3['locationcode'];
$reslocationname = $res3['locationname'];
$visitcodeprefix1=strlen($visitcodeprefix);

	
    $query3 = "select * from master_company where companystatus = 'Active'"; 
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$ipvisitcodeprefix = $res3['ipvisitcodeprefix'];
	$ipvisitcodeprefix=chop($ipvisitcodeprefix,"-");
	$visitcodeprefix1=strlen($visitcodeprefix);

$query2 = "select * from master_ipvisitentry order by auto_number desc limit 0, 1"; 
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
//$res2visitcode = $res2["visitcode"];
 $res2visitcode=$_REQUEST['visitcode'];
$res2visitnum=strlen($res2visitcode);
 $vvcode6=str_split($res2visitcode);
				  $value6=arrayHasOnlyInts($vvcode6);
				  $visitcodepre6=$res2visitnum-$value6-'1';
				  
				  //echo $visitcodeprefix=$_REQUEST['visitcode'];
 //$visitcodeprefix= substr($res2visitcode,0,2);
if ($res2visitcode == '')
{

	$visitcode =$visitcodeprefix."-".'1'."-".$ipvisitcodeprefix; 
	$openingbalance = '0.00';
}
else
{

	 $res2visitcode;
	//$visitcodeprefix =explode('-', $res2visitcode)
	//$visitcode = substr($res2visitcode,$visitcodepre6,$res2visitnum);
	$visitexplode = explode('-',$res2visitcode);
 	$visitcode = $visitexplode[1];
	echo $visitcode = intval($visitcode);
	
	//$visitcode = $visitcode + 1;
	$maxanum = $visitcode;
	
	
	$visitcode = $visitcodeprefix ."-".$maxanum."-".$ipvisitcodeprefix;   
	$openingbalance = '0.00';
	//echo $companycode;
}
	
    $patientfirstname = $_REQUEST["patientfirstname"]; 
	$patientfirstname = strtoupper($patientfirstname);
	$patientmiddlename = $_REQUEST['patientmiddlename'];
	$patientmiddlename = strtoupper($patientmiddlename);
	$patientlastname = $_REQUEST["patientlastname"];
	$patientlastname = strtoupper($patientlastname);
	$patientfullname=$patientfirstname.' '.$patientmiddlename.' '.$patientlastname;
	$consultingdoctor = $_REQUEST["consultingdoctor"];
	$querydoc=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_doctor where auto_number='$consultingdoctor'"); 
	$execdoc=mysqli_fetch_array($querydoc);
	$consultingdoctor=$execdoc['doctorname'];
//	$department = $_REQUEST["department"];
		$billnumbercode=$_REQUEST['billnumbercode'];
		$type=$_REQUEST['type'];
			
	$paymenttype = $_REQUEST["paymenttype"];
	$subtype = $_REQUEST["subtype"];
	$billtype = $_REQUEST["billtype"];
	if($billtype == 'PAY NOW')
	{
	$deposit = '';
	}
	else
	{
	$deposit = 'notapplicable';
	}
    $accountname = $_REQUEST["accountname"];
	
    $query87="select * from master_accountname where auto_number='$accountname' and recordstatus != 'DELETED' and recordstatus != 'SUSPENDED'"; 
	$exec87=mysqli_query($GLOBALS["___mysqli_ston"], $query87);
	$res87=mysqli_fetch_array($exec87);
	$accname=$res87['accountname'];
	$accountexpirydate = $_REQUEST["accountexpirydate"];
	$planname = $_REQUEST["planname"];
	$planstatus = $_REQUEST["planstatus"];
	$planexpirydate = $_REQUEST["planexpirydate"];
	$consultationdate = $_REQUEST["consultationdate"];
	$consultationtime  = $_REQUEST["consultationtime"];
//	$consultationtype = $_REQUEST["consultationtype"];
	$admissionfees  = $_REQUEST["admissionfees"];
//	$referredby = $_REQUEST["referredby"];
//	$consultationremarks = $_REQUEST["consultationremarks"];
//	$complaint = $_REQUEST["complaint"];
	$registrationdate = $_REQUEST["registrationdate"];
	$visittype = $_REQUEST["visittype"];
	$visitlimit = $_REQUEST["visitlimit"];
	$overalllimit = $_REQUEST["overalllimit"];
	$visitcount = $_REQUEST["visitcount"];
	$planfixedamount = $_REQUEST["planfixedamount"];
	$planpercentageamount = $_REQUEST["planpercentageamount"];
	$updatedatetime = date('Y-m-d H:i:s');
	$age = $_REQUEST['age'];
	$gender = $_REQUEST['gender'];
	$packapp = isset($_POST['packapplicable'])?$_POST['packapplicable']:'';
	$opadmissiondoctor = $_REQUEST['admissiondoctor'];
	$admissionnotes = $_REQUEST['admissionnotes'];
	
	$ack = $packapp;
	if($ack == '1')
	{
	$package = $_REQUEST['package'];
	$packcharge = $_REQUEST['packcharge'];
//	$packchargeapply = $_POST['packchargeapply'];
	}
	else
	{
	$package = '';
	$packcharge = '';
	}
	
	$nhifapplicable = $_REQUEST['nhifapplicable'];
	if($nhifapplicable == 'yes')
	{
	$nhifid = $_REQUEST['nhifid'];
	$issuedate = $_REQUEST['issuedate'];
	$validtill = $_REQUEST['validtill'];
	$nhifrebate = $_REQUEST['nhifrebate'];
	}
	else
	{
	$nhifid = '';
	$issuedate = '';
	$validtill = '';
	$nhifrebate = '';
	}
	
	$patientspent=$_REQUEST['patientspent'];
	
		$query3 = "select * from master_ipvisitentry where patientcode = '$patientcode' and  registrationdate = '$registrationdate'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rowcount3 = mysqli_num_rows($exec3);
		/*if ($rowcount3 != 0)
		{
			header ("location:ipvisitentry.php?errorcode=errorcode1failed");
			exit();
		}*/	
		
		
		$query31 = "select * from master_ipvisitentry where patientcode = '$patientcode' order by auto_number desc";
		$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res31 = mysqli_fetch_array($exec31);
		$previsitcode = $res31['visitcode'];
		if($previsitcode != '')
		{
		$query311 = "select * from billing_ip where visitcode='$previsitcode'";
		$exec311 = mysqli_query($GLOBALS["___mysqli_ston"], $query311) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num311 = mysqli_num_rows($exec311);
		
		$query312 = "select * from ip_creditapprovalformdata where visitcode='$previsitcode'";
		$exec312 = mysqli_query($GLOBALS["___mysqli_ston"], $query312) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num312 = mysqli_num_rows($exec312);
		
		$totnum = $num311 + $num312; 
		
		
		if($totnum == 0)
		{
		header ("location:ipvisitentry.php?errorcode=errorcode1failed");
		exit();
		}
		}
		
	 $query2 = "select * from master_ipvisitentry where visitcode = '$visitcode'"; 
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	
	
	if($planstatus=='OP')
	{
	?>
	<script>
	alert('Sorry Here IP Only  !')
	</script>
	<?php
	
	}
	else
	{
	
	if ($res2 == 0)
	{
		$query1 = "insert into master_ipvisitentry (locationcode,type,patientcode, visitcode, patientfirstname,patientmiddlename, patientlastname,patientfullname, consultingdoctor,
		department,paymenttype,subtype,billtype,accountname,accountexpirydate,planname,planexpirydate,consultationdate,consultationtime,consultationtype,admissionfees,referredby,consultationremarks,complaint,registrationdate,visittype,visitlimit,overalllimit,visitcount,patientspent,planpercentage,planfixedamount,age,gender,accountfullname,itemrefund,package,packagecharge,nhifid,nhifissuedate,nhifvaliddate,nhifrebate,deposit,packchargeapply,username,opadmissiondoctor,admissionnotes,locationname) 
		values('$reslocationcode','$type','$patientcode','$visitcode','$patientfirstname','$patientmiddlename','$patientlastname','$patientfullname','$consultingdoctor',
		'$department','$paymenttype','$subtype','$billtype','$accountname','$accountexpirydate','$planname','$planexpirydate','$consultationdate','$consultationtime','$consultationtype','$admissionfees','$referredby', '$consultationremarks','$complaint','$registrationdate','$visittype','$visitlimit','$overalllimit','$visitcount','$patientspent','$planpercentageamount','$planfixedamount','$age','$gender','$accname','torefund','$package','$packcharge','$nhifid','$issuedate','$validtill','$nhifrebate','$deposit','$packchargeapply','$username','$opadmissiondoctor','$admissionnotes','$reslocationname')";  
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query44 = "select * from consultation_ipadmission where patientcode='$patientcode'"; 
		$exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num44 = mysqli_num_rows($exec44);
		if($num44>0)
		{
		$query11 = "update consultation_ipadmission set status='completed' where patientcode='$patientcode'"; 
		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		//$patientcode = '';
		//$visitcode = '';
		$patientfirstname = '';
		$patientmiddlename = '';
		$patientlastname = '';
		$consultingdoctor = '';

		$department = '';
		$paymenttype = '';
		$subtype = '';
		$accountname = '';
		$accountexpirydate = '';
		$planname = '';
		$planstatus='';
		$planexpirydate = '';
		$consultationdate = '';
		$consultationtime = '';
		$consultationtype = '';
		$consultationfees = '';
		$referredby = '';
		$consultationremarks = '';
		$complaint = '';
		$registrationdate = '';
		$visittype = '';
		$visitlimit ='';
		$overalllimit = '';
		$planfixedamount = '';
		$planpercentageamount = '';
		$billtype ='';
		$patientspent='';
		$visitcount='';
		$packapp='';
		header("location:ipvisitentry.php");
		exit();
		//header ("location:addcompany1.php?st=success&&cpynum=1");
		
	}
	
	else
	{
		header ("location:ipvisitentry.php?patientcode=$patientcode&&st=failed");
		exit;
	}
	}
	}
}
else
{
	$patientcode = '';
	$visitcode = '';
	$patientfirstname = '';
	$patientmiddlename = '';
	$patientlastname = '';
	$consultingdoctor = '';
	$department = '';
	$paymenttype = '';
	$subtype = '';
	$accountname = '';
	$accountexpirydate = '';
	$planname = '';
	$planstatus='';
	$planexpirydate = '';
	$consultationdate = '';
	$consultationtime = '';
	$consultationtype = '';
	$consultationfees = '';
	$referredby = '';
	$consultationremarks = '';
	$complaint = '';
	$registrationdate = '';
	$visittype = '';
	$visitlimit = '';
	$overalllimit = '';
	$planfixedamount = '';
	$planpercentageamount = '';
	$billtype = '';
	$patientspent='';
	$visitcount='';
	$age='';
	$gender='';
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'success')
{
		$errmsg = "Success. New Visit Updated.";
		if (isset($_REQUEST["cpynum"])) { $cpynum = $_REQUEST["cpynum"]; } else { $cpynum = ""; }
		if ($cpynum == 1) //for first company.
		{
			$errmsg = "Success. New Visit Updated.";
		}
}
else if ($st == 'failed')
{
		$errmsg = "Failed. Visit Code Already Exists.";
}

		$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
	$res12location = $res["locationname"];
	$res12locationanum = $res["auto_number"];

$query3 = "select * from master_location where status = '' and locationname='$res12location'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$visitcodeprefix = $res3['prefix'];
$visitcodeprefix1=strlen($visitcodeprefix);


$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$ipvisitcodeprefix = $res3['ipvisitcodeprefix'];
 //$ipvisitcodeprefix=explode("-",$ipvisitcodeprefix);
$ipvisitcodeprefix=chop($ipvisitcodeprefix,"-");


$nhifrebate = $res3['nhifrebate'];
$ipadmissionfee = $res3['ipadmissionfees'];
$visitcodeprefix1=strlen($visitcodeprefix);
$query2 = "select * from master_ipvisitentry order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
 $res2visitcode = $res2["visitcode"];
 
$res2visitnum=strlen($res2visitcode);
 $vvcode6=str_split($res2visitcode);
				  $value6=arrayHasOnlyInts($vvcode6);
				  $visitcodepre6=$res2visitnum-$value6-'1';
				  
			  
if ($res2visitcode == '')
{

	$visitcode =$visitcodeprefix.'-'.'1'.'-'.$ipvisitcodeprefix;
	$openingbalance = '0.00';
}
else
{

	$res2visitcode = $res2["visitcode"];
	$visitcode = substr($res2visitcode,$visitcodepre6,$res2visitnum);
	$visitexplode = explode('-',$res2visitcode);
 	$visitcode = $visitexplode[1];
	$visitcode = intval($visitcode);
	
	$visitcode = $visitcode + 1;
	$maxanum = $visitcode;
	
	
	$visitcode = $visitcodeprefix.'-' .$maxanum.'-'.$ipvisitcodeprefix;
	$openingbalance = '0.00';
	//echo $companycode;
}

?>
<script>

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

function locationform(frm,val)
{

<?php $query11 = "select * from master_location where 1";
    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res11 = mysqli_fetch_array($exec11))
	{
	$scriptlocationcode = $res11["locationcode"];
	$scriptlocationprefix = $res11["prefix"];
	?>
	if(document.getElementById("location").value=="<?php echo $scriptlocationcode; ?>")
		{
		document.getElementById("visitcode").value = "<?php echo $scriptlocationprefix.'-'.$maxanum.'-'.$ipvisitcodeprefix; ?>";
		
		}
	<?php
	 }?>
	//document.form1.customercode.value='ok';
	
}

</script>


</script>

<?php

$query31 = "select * from master_company where companystatus = 'Active'";
$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res31 = mysqli_fetch_array($exec31);
$consultationprefix = $res31['consultationprefix'];

$query21 = "select * from master_billing order by auto_number desc limit 0, 1";
$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res21 = mysqli_fetch_array($exec21);
$billnumber = $res21["billnumber"];
if ($billnumber == '')
{
	$billnumbercode =$consultationprefix.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res21["billnumber"];
	$billnumbercode = substr($billnumber, 3, 8);
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $consultationprefix.$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
	function arrayHasOnlyInts($array)
{
$count=0;
$count1=0;
    foreach ($array as $key => $value)
    {
        if (is_numeric($value)) // there are several ways to do this
        {
		$count1++;    
		
        }
		else
		{
		$count=$count+1;
		
		}
    }
    return $count1; 
}	
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
//$patientcode = 'MSS000000014';

if ($patientcode != '')
{
	//echo 'Inside Patient Code Condition.';
	$query3 = "select * from master_customer where customercode = '$patientcode'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	
	$patientfirstname = $res3['customername'];
	$patientfirstname = strtoupper($patientfirstname);

	$patientmiddlename = $res3['customermiddlename'];
	$patientmiddlename = strtoupper($patientmiddlename);

	$patientlastname = $res3['customerlastname'];
	$patientlastname = strtoupper($patientlastname);
	
	$patientfullname = $res3['customerfullname'];
	$patientfullname = strtoupper($patientfullname);
     
    $pamenttype1 = $res3['paymenttype'];
	$photoavailable = $res3['photoavailable'];

	$paymenttype = $res3['paymenttype'];
	$query4 = "select * from master_paymenttype where auto_number = '$paymenttype'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$paymenttypeanum = $res4['auto_number'];
	$paymenttype = $res4['paymenttype'];
	
	$subtype = $res3['subtype'];
	$query4 = "select * from master_subtype where auto_number = '$subtype'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$subtypeanum = $res4['auto_number'];
	$subtype = $res4['subtype'];

	$billtype = $res3['billtype'];
	$age = $res3['age'];
	$gender = $res3['gender'];
	
	$query39 = "select * from master_company";
	$exec39 = mysqli_query($GLOBALS["___mysqli_ston"], $query39) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res39 = mysqli_fetch_array($exec39);
	$ipadmissionfees = $res39['ipadmissionfees'];
	$creditipadmissionfees = $res39['creditipadmissionfees'];
	
	if($billtype == 'PAY NOW')
	{
	$admissionfees = $ipadmissionfees;
	}
	else
	{
	$admissionfees = $creditipadmissionfees;
	}
	
	$accountname = $res3['accountname'];
	$query4 = "select * from master_accountname where auto_number = '$accountname' and recordstatus != 'DELETED' and recordstatus != 'SUSPENDED'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$accountnameanum = $res4['auto_number'];
	$accountname = $res4['accountname'];
	
	
	
	$accountexpirydate = $res3['accountexpirydate'];
	
	 $planname = $res3['planname'];
	$query4 = "select * from master_planname where auto_number = '$planname'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$plannameanum = $res4['auto_number'];
	$planname = $res4['planname'];
    $planstatus=$res4['recordstatus'];
	$planfixedamount = $res4['planfixedamount'];
	$planpercentageamount = $res4['planpercentage'];
	
	$query5 = "select * from master_ipvisitentry where patientcode = '$patientcode' and recordstatus = ''";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rowcount5 = mysqli_num_rows($exec5);
	$visitcount = $rowcount5 + 1;
	
	$planexpirydate = $res3['planexpirydate'];
	$registrationdate = $res3['registrationdate'];
	
	$visitlimit = $res4['ipvisitlimit'];	
	$overalllimit = $res4['overalllimitip'];
	if($visitcount == 1)
	{
	$availablelimit=$overalllimit ;
	}
	else
	{
	$availablelimit=$overalllimit-$planfixedamount;
	}
	
	
	
}
if (isset($_REQUEST["opvisitcode"])) { $opvisitcode = $_REQUEST["opvisitcode"]; } else { $opvisitcode = ""; }

if($opvisitcode != '')
{
$query76 = "select * from consultation_ipadmission where visitcode='$opvisitcode'";
$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res76 = mysqli_fetch_array($exec76);
$admissiondoctor = $res76['username'];
$admissionnotes = $res76['notes'];
}
else
{
$admissiondoctor = '';
$admissionnotes = '';

}
$registrationdate = date('Y-m-d');
$consultationdate = date('Y-m-d');
$consultationtime = date('H:i');
//$consultationfees = '500';

if (isset($_REQUEST["errorcode"])) { $errorcode = $_REQUEST["errorcode"]; } else { $errorcode = ""; }
//$patientcode = 'MSS00000009';
if ($errorcode == 'errorcode1failed')
{
	$errmsg = 'Bill for Previous Visit has to be Finalised to Create a New Visit for this Patient';	
}
/*if ($errorcode == 'statuserror')
{
	$errmsg = 'This is  IP and IP+OP only.';	
}*/

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
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script language="javascript">


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

function funcRegistrationIPLabel()
{
var patientcode = document.getElementById("patientcode").value;
var popWin; 
popWin = window.open("print_ipvisit_label.php?patientcode="+patientcode,"_blank");
return true;
}

/*
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

*/
</script>

<script type="text/javascript">
function ShowImage(imgval,flg)
{
	var imgval = document.getElementById('patientcode').value;
	if(imgval != '')
	{
		if(flg == 'Show Image') {
		var photoavailable = document.getElementById('photoavailable').value;
		if(photoavailable == 'YES') {
		document.getElementById('patientimage').src = 'patientphoto/'+imgval+'.jpg';
		} else {
		document.getElementById('patientimage').src = 'patientphoto/noimage.jpg';
		}
		document.getElementById('imgbtn').value = "Hide Image";
		} else {
		document.getElementById('patientimage').src = '';
		document.getElementById('imgbtn').value = "Show Image";
		}
	}
	else
	{
		alert("Patient Code is Empty");
	}
}
</script>

<style type="text/css">
.ui-menu .ui-menu-item{ zoom:1 !important; }
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}

</style>
</head>
<script language="javascript">

function process1()
{

	
	if(document.getElementById("plannamename").value == "OP ONLY")
	{
	alert("This Plan is Not Valid for IP Registration, Please Contact Accounts.");
	return false;
	}
	//alert ("Before Function");
	//To validate patient is not registered for the current date.
	//funcVisitEntryPatientCodeValidation1();
	//return false;


	if (document.form1.type.value == "")
	{
		alert ("Please Select Type.");
		document.form1.type.focus();
		return false;
	}
	/*
	if (document.form1.patientfirstname.value == "")
	{
		alert ("Please Enter Patient First Name.");
		document.form1.patientfirstname.focus();
		return false;
	}
	if(document.getElementById("billtype").value = "PAY LATER")
	{
	  if(document.getElementById("accountname").value == "")
	   {
	    alert("Account Name Cannot be Empty");
		document.form1.accountname.focus();
		return false;
	   }
	}
	
	if(document.getElementById("billtype").value = "PAY LATER")
	 {
	  if(document.getElementById("planname").value == "")
	   {
	    alert("Plan Name Cannot be Empty");
		document.form1.planname.focus();
		return false;
		}
	}
	
	*/
/*	if (document.form1.visittype.value == "")
	{
		alert ("Please Select Visit Type.");
		document.form1.visittype.focus();
		return false;
	}*/
	//alert(document.getElementById("recordstatus").value);
	if(document.getElementById("recordstatus").value == 'DELETED')
	{
	alert("Account has been suspended.Please Contact Accounts.");
		document.getElementById("accountnamename").focus();
			return false;
	}
	if(document.getElementById("nhifapplicable").value == 'yes')

	{
	if(document.getElementById("nhifid").value == '')
	{
	alert("Please Enter NHIF ID");
	document.getElementById("nhifid").focus();
	return false;
	}
	}
	
	if(document.getElementById("packapplicable").checked == true)
	{
	if(document.getElementById("package").value == "")
	{
	alert("Please Select Package");
	document.getElementById("package").focus();
	return false;
	}
	}
	Submit222.disabled = true; return true;
	//if (confirm("Do You Want To Save The Record?")==false){return false;}
	
	if(document.getElementById("paymenttypename").value != "CASH" && document.getElementById("subtypename").value !="CASH")
	{
		 var VarVisitLimit = document.getElementById("visitlimit").value;
		 var VarVisitCount = document.getElementById("visitcount").value;
		 
		/*<!-- if(VarVisitCount > VarVisitLimit)
		 {
			alert("Your Visit Limit Is Finished .You Cannot Proceed");
			document.getElementById("department").focus();
			return false;
		}-->
			*/
	if (document.form1.availablelimit.value == 0)
	  {
		alert ("Available Limit Cannot be Empty.");
		document.form1.availablelimit.focus();
		return false;
	  }		
  }
	
	if (document.form1.department.value == "")
	{
		alert ("Please Select Department.");
		document.form1.department.focus();
		return false;
	}
	
	if (document.form1.consultingdoctor.value == "")
	{
		alert ("Please Select Consulting Doctor.");
		document.form1.consultingdoctor.focus();
		return false;
	}	
	
	if (document.form1.consultationtype.value == "")
	{
		alert ("Please Select Consultation Type.");
		document.form1.consultationtype.focus();
		return false;
	}
	
	
	
	if (document.getElementById("accountexpirydate").value != "")
	{
		<?php $date = mktime(0,0,0,date("m"),date("d")-1,date("Y")); 
		$currentdate = date("Y/m/d",$date);
		?>
		var currentdate = "<?php echo $currentdate; ?>";
		var expirydate = document.getElementById("accountexpirydate").value; 
		var currentdate = Date.parse(currentdate);
		var expirydate = Date.parse(expirydate);
		
		if( expirydate < currentdate)
		{
			alert("Please Select Correct Account Expiry date");
			//document.getElementById("accountexpirydate").focus();
			return false;
		}
	}
	
    if(document.getElementById("paymenttypename").value != "CASH" && document.getElementById("subtypename").value != "CASH")
	   {
		 /*if (document.getElementById("planfixedamount").value == 0)
		  {
			alert ("For Consultation Visit Entry, Plan Fixed Amount Cannot Be Zero. Please Refer Your Plan Details.");
			return false;
		 }*/
		
		/*if (parseFloat(document.getElementById("visitlimit").value) < parseFloat(document.getElementById("consultationfees").value))
		 {
			alert ("Consultation Fees Crossed Visit Limit Amount Level. Cannot Proceed.");
			return false;
		 }*/
		//return false;
		 var VarVisitLimit = document.getElementById("visitlimit").value;
		 var VarVisitCount = document.getElementById("visitcount").value;
		 
		/* if(VarVisitCount > VarVisitLimit)
		  {
			alert("Your Visit Limit Is Finished .You Cannot Proceed");
			document.getElementById("department").focus();
			return false;
		 }
		*/
		
		var VarOverallLimit = document.getElementById("overalllimit").value;
		var Varavaliablelimit = document.getElementById("availablelimit").value;
		
		if(Varavaliablelimit == 0)
		{
			alert("You Cannot Proceed Because No Available Balance");
			document.getElementById("department").focus();
			return false;
		}	
	}
	
	Submit222.disabled = true; return true;
}


/*
function funcVisitLimt()
{
<?php
	$query11 = "select * from master_customer where status = 'ACTIVE'";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res11 = mysqli_fetch_array($exec11))
	{
	$res11customername = $res11["customername"];
	$res11visitlimit = $res11['visitlimit'];
	$res11patientfirstname=$res11patientfirstname['patientfirstname'];
		?>
		if(document.getElementById("customername").value == "<?php echo $res11customername; ?>")
		{
			document.getElementById("visitlimit").value = <?php echo $res11visitlimit; ?>;
			document.getElementById("patientfirstname").value = <?php echo $res11patientfirstname; ?>;
			document.getElementById("customername").value = <?php echo $res11customername; ?>;
	
			return false;
		}
	<?php
	}
	?>
}
*/

function funcDepartmentChange()
{



	<?php
	$query11 = "select * from master_department where recordstatus = ''";
    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res11 = mysqli_fetch_array($exec11))
	{
	$res11departmentanum = $res11['auto_number'];
	$res11department = $res11["department"];
	?>
		if(document.getElementById("department").value == "<?php echo $res11departmentanum; ?>")
		{
		document.getElementById("consultingdoctor").options.length=null; 
		var combo = document.getElementById('consultingdoctor'); 
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Doctor Name", ""); 
		<?php
		$query10 = "select * from master_doctor where department = '$res11departmentanum' order by doctorname";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10 = mysqli_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10doctoranum = $res10['auto_number'];
		$res10doctorcode = $res10["doctorcode"];
		$res10doctorname = $res10["doctorname"];
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10doctorname;?>", "<?php echo $res10doctoranum;?>"); 
		<?php 
		}
		?>
		}
	<?php
	}
	?>
	<?php
	$query11 = "select * from master_department where recordstatus = ''";
    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res11 = mysqli_fetch_array($exec11))
	{
	$res11departmentanum = $res11['auto_number'];
	$res11department = $res11["department"];
	?>
		if(document.getElementById("department").value == "<?php echo $res11departmentanum; ?>")
		{
		document.getElementById("consultationtype").options.length=null; 
		var combo = document.getElementById('consultationtype'); 
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Consultation Type", ""); 
		<?php
		$query10 = "select * from master_consultationtype where department = '$res11departmentanum' order by consultationtype";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10 = mysqli_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10consultationtypeanum = $res10['auto_number'];
		$res10consultationtype = $res10["consultationtype"];
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10consultationtype;?>", "<?php echo $res10consultationtypeanum;?>"); 
		<?php 
		}
		?>
		}
	<?php
	}
	?>
 

}
function funcConsultationTypeChange()
{
//alert("hi");
document.getElementById("consultationfees").value = '';
	<?php
	$query11 = "select * from master_consultationtype where recordstatus = ''";
    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res11 = mysqli_fetch_array($exec11))
	{
	$res11consultationanum = $res11["auto_number"];
	$res11consultationtype = $res11["consultationtype"];
	$res11consultationfees = $res11["consultationfees"];
	?>
	var varconsultationanum =  "<?php echo $res11consultationanum; ?>";
	//alert(varconsultationanum);
	var varconsultationtype = document.getElementById("consultationtype").value;
	//alert(varconsultationtype);
		if(parseInt(varconsultationtype) == parseInt(varconsultationanum))
		{
		    //alert('hi');
			document.getElementById("consultationfees").value = <?php echo $res11consultationfees; ?>;
			document.getElementById("consultationfees").focus();
		}
	<?php
	}
	?>
}
function funcpackageChange()
{
//alert();
	dataString = "action=packagechange&&package="+ $('#package').val()+"&&location="+$('#location').val()+"&&subtype="+$('#subtype').val()+'&&billtype='+$('#billtype').val();
	$.ajax({
	type:"POST",
	url:"packagechangeip.php",
	data:dataString,
	cache: true,
	success: function(html)
	{
		//$("#packcharge").empty().append(html);
		$("#packcharge").val(html);
	//	alert(html);
	}
	});
}

function funcOnLoadBodyFunctionCall()
{ 
	
	//funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
	funcpackHideView();
	funcnhifHideView();
}

function funcpackShowView()
{
  if (document.getElementById("pack") != null) 
     {
	 document.getElementById("pack").style.display = 'none';
	}
	if (document.getElementById("pack") != null) 
	  {
	  document.getElementById("pack").style.display = '';
	 }
}
function funcpackHideView()
{		
 if (document.getElementById("pack") != null) 
	{
	document.getElementById("pack").style.display = 'none';
	}	
}

function funcnhifShowView()
{

  if (document.getElementById("nhif") != null) 
     {
	 document.getElementById("nhif").style.display = 'none';
	}
	if (document.getElementById("nhif") != null) 
	  {
	  document.getElementById("nhif").style.display = '';
	 }
}
function funcnhifHideView()
{		
 if (document.getElementById("nhif") != null) 
	{
	document.getElementById("nhif").style.display = 'none';
	}	
}

function funcnhifcheck()
{

if(document.getElementById("nhifapplicable").value == 'yes')
{
funcnhifShowView();
}
if(document.getElementById("nhifapplicable").value == 'no')
{
funcnhifHideView();
}
}
function funcpackcheck()
{
if(document.getElementById("packapplicable").checked == true)
{
funcpackShowView();
}
if(document.getElementById("packapplicable").checked == false)
{
funcpackHideView();
}
}
function funcaccountexpiry()
{
    <?php $date = mktime(0,0,0,date("m"),date("d")-1,date("Y")); 
	$currentdate = date("Y/m/d",$date);
	?>
	var currentdate = "<?php echo $currentdate; ?>";
	var expirydate = document.getElementById("expirydate").value; 
	var currentdate = Date.parse(currentdate);
	var expirydate = Date.parse(expirydate);
	
	if( expirydate > currentdate)
	{
	alert("Please Select Correct Account Expiry date");
	document.getElementById("expirydate").focus();
	return false;
	}
}
function expirydateandlimitwarning()
{
  <?php $date = mktime(0,0,0,date("m"),date("d")-1,date("Y")); 
	$currentdate = date("Y/m/d",$date);
	?>
	var currentdate = "<?php echo $currentdate; ?>";
	var expirydate = document.getElementById("expirydate").value; 
	var currentdate = Date.parse(currentdate);
	var expirydate = Date.parse(expirydate);
	
	if( expirydate > currentdate)
	{
	alert("Please Select Correct Account Expiry date");
	document.getElementById("expirydate").focus();
	return false;
	}
}


function expirydatewarning()
{
	
	//alert("hi");
	<?php $date = mktime(0,0,0,date("m"),date("d")-1,date("Y")); 
	$currentdate = date("Y/m/d",$date);
	?>
	var currentdate = "<?php echo $currentdate; ?>";
	var expirydate = document.getElementById("planexpirydate").value;
	var billtype1 = document.getElementById("billtype").value;
	var overalllimit1 = document.getElementById("overalllimit").value;
	var visitlimit1 = document.getElementById("visitlimit").value;
	var availablelimit1 = document.getElementById("availablelimit").value;
	
	//var currentdate = Date.parse(currentdate);
	//var expirydate = Date.parse(expirydate);
	var expirydate = expirydate.replace(/-/gi, "/");
	//alert(expirydate);
	//alert(currentdate);
	//alert(availablelimit1);
	
	if(billtype1 != "PAY NOW")
{
	if(overalllimit1 > 0)
	{
	if( availablelimit1 <= 0)
	{
	alert("Overall limit Exceeded");
	document.getElementById("availablelimit").focus();
	return false;
	}
	}
	

	
	if(expirydate < currentdate)
	{
	alert("Plan Expired");
	
return false;
	}
}

}



</script>
<link href="autocomplete.css" rel="stylesheet">

<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/autocustomercodesearch2.js"></script>

<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script type="text/javascript" src="js/visitentrypatientcodevalidation1.js"></script>

<script src="js/datetimepicker_css.js"></script>
<script>

$(function() {
	
$('#customer').autocomplete({
		
	source:'ajaxcustomernewserach.php', 
	//alert(source);
	minLength:3,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var code = ui.item.id;
			var customercode = ui.item.customercode;
			var accountname = ui.item.accountname;
			$('#customercode').val(customercode);
			$('#accountnamename').val(accountname);
			$('#patientcode').val(customercode);
			
			funcCustomerSearch2();
			
			},
    });
	
	$('#consultingdoctorsearch').autocomplete({
		
	source:'ajaxipadmdoctorsearch.php', 
	//alert(source);
	minLength:3,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var code = ui.item.id;
			var value = ui.item.value;
			$('#consultingdoctor').val(code);
			$('#consultingdoctorsearch').val(value);
			},
    });
});



</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall()">
<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5">
	<?php 
	
		include ("includes/menu1.php"); 
	
	//	include ("includes/menu2.php"); 
	
	?>	</td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">


      	  <form name="form1" id="form1" method="post" action="ipvisitentry.php" onKeyDown="return disableEnterKey(event)" onSubmit="return process1()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860"><table width="1258" height="282" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="2"><strong>IP Visit Entry </strong></td>
                <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                <td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td colspan="4" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
						
						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						//$res1locationanum = $res1["locationcode"];
						?>
						
						
                  
                  </td>
                <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"></td>
              </tr>
              <tr bgcolor="#011E6A">
                
               
                 <td colspan="9" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Search Sequence : First Name | Middle Name | Last Name | Date of Birth | Location | Mobile Number | National ID | Registration No   (*Use "|" symbol to skip sequence)</strong>
             
            
          
                
              </tr>
              <tr>
                <td colspan="12" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo 'red'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
                
              </tr>
              <!--<tr bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3"  colspan="4"><strong>Registration</strong></font></div></td>
                </tr>-->
              <!--<tr>
                  <tr  bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3" colspan="4"><div align="right">* Indicates Mandatory</div></td>
                </tr>-->
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Patient Search </td>
				  <td colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5">
				  <input name="customer" id="customer" size="60" autocomplete="off">
				  	  <input name="customerhiddentextbox" id="customerhiddentextbox" value="" type="hidden">
				  <input name="customercode" id="customercode" value="" type="hidden">
				<input type="hidden" name="recordstatus" id="recordstatus">
				  <input type="hidden" name="billnumbercode" id="billnumbercode" value="<?php echo $billnumbercode; ?>" readonly ></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Location</td>
				  <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5">
                  <select name="location" id="location" onChange="locationform(form1,this.value); ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
                  <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>"><?php echo $res1location; ?></option>
						<?php
						}
						?>
                  </select>
                  </td>
				  </tr>
				
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Type</td>
				  <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5">
                  <select name="type" id="type" style="border: 1px solid #001E6A;">
                  <option value="">select</option>
                  <option value="hospital">Hospital</option>
                  <option value="private">Private</option>
                  </select>
                  </td>
				  <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				  <td width="13%" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				  <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				  <td width="15%" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				  <td colspan="2" rowspan="6" align="center" valign="middle"  bgcolor="#ecf0f5">
				  <input type="hidden" name="photoavailable" id="photoavailable" value="<?php echo $photoavailable; ?>"><img width="150" height="150" id="patientimage" src="">
				  <br/> <input type="button" name="imgbtn" id="imgbtn" value="Show Image" onClick="return ShowImage('<?php echo $patientcode; ?>',this.value);"><br/>
				  </td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Patient</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">
				  <input name="patientfirstname" id="patientfirstname" value="<?php echo $patientfirstname; ?>" readonly  size="20" /></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">
				  <input name="patientmiddlename" id="patientmiddlename" value="<?php echo $patientmiddlename; ?>" readonly size="20" /></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="patientlastname" id="patientlastname" value="<?php echo $patientlastname; ?>" readonly size="20" /></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Age</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="age" id="age" value="<?php echo $age; ?>" readonly></td>
				  <td width="1%" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				 </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Patient Reg ID </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">
				  <input name="patientcode" id="patientcode" size="20" value="<?php echo $patientcode; ?>"/></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Registration Date </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="registrationdate" id="registrationdate" value="<?php echo $consultationdate; ?>"></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Gender</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="gender" value="<?php echo $gender; ?>" id="gender" readonly></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Type</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">
				    <input type="text" name="paymenttypename" id="paymenttypename"  value="<?php echo $paymenttype;?>" readonly>				
				    <input type="hidden" name="paymenttype" id="paymenttype"  value="<?php echo $paymenttypeanum;?>" readonly>					</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Visit ID </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" readonly size="20" /></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Account Name </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="accountnamename" id="accountnamename"  value="<?php echo $accountname;?>"  readonly="readonly">
				    <input type="hidden" name="accountname" id="accountname"  value="<?php echo $accountnameanum;?>"  readonly="readonly" ></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				</tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Sub Type </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>
                    <input type="text" name="subtypename" id="subtypename"  value="<?php echo $subtype;?>"  readonly="readonly" >
				    <input type="hidden" name="subtype" id="subtype"  value="<?php echo $subtypeanum;?>"  readonly="readonly" >
				  </label></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Bill Type </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="billtype" id="billtype"  value="<?php echo $billtype;?>"  readonly="readonly"  
				  ></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Account Expiry</span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="accountexpirydate" id="accountexpirydate"  value="<?php echo $accountexpirydate;?>"  readonly="readonly"></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				  </tr>
				
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Plan Name </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>
                    <input type="text" name="plannamename" id="plannamename"  value="<?php echo $planname;?>"   readonly="readonly">
                    <input type="hidden" name="planname" id="planname"  value="<?php echo $plannameanum;?>"   readonly="readonly">
					<input type="hidden" name="planstatus" id="planstatus"  value="<?php echo $planstatus;?>"   readonly="readonly">
					
					
					
                  </label></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Plan Expiry </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="planexpirydate" id="planexpirydate"  value="<?php echo $planexpirydate;?>"   readonly="readonly" ></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Visit Limit</span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="visitlimit" id="visitlimit"  value="<?php echo $visitlimit;?>"   readonly="readonly"></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label></label></td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Fixed Amount </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>
				  <input type="text" name="planfixedamount" id="planfixedamount"  value="<?php echo $planfixedamount;?>"   readonly="readonly">
				  </label></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Overall Limit </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="overalllimit" id="overalllimit"  value="<?php echo $overalllimit;?>"   readonly="readonly" ></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Patient Due</span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="patientspent" id="patientspent"  value="<?php echo $patientspent;?>"   readonly="readonly"></td>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><label></label></td>
				  </tr>
				
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Percentage</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>
				 <input type="text" name="planpercentageamount" id="planpercentageamount"  value="<?php echo $planpercentageamount;?>"   readonly="readonly" ></label> </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Available Limit </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="availablelimit" id="availablelimit"  value="<?php echo $availablelimit;?>"   readonly="readonly" ></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Member_No </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><strong>
				  <input name="memberno" id="memberno" value="" size="20" />
				    <input type="hidden" name="visitcount" id="visitcount"  value="<?php echo $visitcount;?>"   readonly="readonly">
				    <input name="visittype" id="visittype" value="" type="hidden">
				  </strong></td>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><label></label></td>
				</tr>
				
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">OP Admission Doctor</span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="admissiondoctor" id="admissiondoctor" value="<?php echo $admissiondoctor; ?>"></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Admission Doctor </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><strong><input type="hidden" name="consultingdoctor" id="consultingdoctor" value="">
				  <input type="text" name="consultingdoctorsearch" id="consultingdoctorsearch" value="">
				   <!-- <select name="consultingdoctor" id="consultingdoctor">
                      <option value="">Select Consulting Doctor</option>-->
                      <?php
				     $query51 = "select * from master_doctor where auto_number = 4 ";
				     $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				     while ($res51 = mysqli_fetch_array($exec51))
				       {
				       $res51anum = $res51["auto_number"];
				       $res51doctorname = $res51["doctorname"];
				       ?>
                     <!-- <option value="<?php echo $res51anum; ?>" selected="selected"><?php echo $res51doctorname; ?></option>-->
                      <?php
				     }
				  ?>
                      <?php
				     $query51 = "select * from master_doctor where status = '' and doctorcode <> 'DTC00000004' order by doctorcode";
				     $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				     while ($res51 = mysqli_fetch_array($exec51))
				       {
				       $res51anum = $res51["auto_number"];
				       $res51doctorname = $res51["doctorname"];
				       ?>
                     <!-- <option value="<?php echo $res51anum; ?>" ><?php echo $res51doctorname; ?></option>-->
                      <?php
				     }
				  ?>
                   <!-- </select>-->
				  </strong></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Admission Notes</span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><textarea name="admissionnotes" id="admissionnotes" ><?php echo $admissionnotes; ?></textarea></td>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">
				  <!--<input type="hidden" name="department" id="department" value="<?php echo $department; ?>" style="border: 1px solid #001E6A;"  size="20" />--></td>
				</tr>
				<tr>
                <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Consultation Date </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="consultationdate" id="consultationdate" value="<?php echo $consultationdate; ?>" readonly ></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32"> Consultation Time </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="consultationtime" id="consultationtime" value="<?php echo $consultationtime; ?>" readonly size="8" />
                  <span class="bodytext32">(Ex: HH:MM)</span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Admission Fees </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="admissionfees" id="admissionfees" onFocus="return funcVisitEntryPatientCodeValidation1()" size="20" value="<?php echo $admissionfees; ?>"/></td>
                <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				</tr>
				 			 
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> Package Applicable</span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="packapplicable" id="packapplicable" onClick="return funcpackcheck();" value="1"></td>
				   
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				   <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				 </tr>
				 <tr id="pack">
				 	   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> Package </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" id="pack"><select name="package" id="package" onChange="return funcpackageChange()">
				    <option value="">Select Package</option>
				   <?php
				   $query66 = "select * from master_ippackage where locationname='$res1location' and status=''";
				   $exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				   while($res66 = mysqli_fetch_array($exec66))
				   {
				   $packageanum = $res66['auto_number'];
				   $packagename = $res66['packagename'];
				   ?>
				   <option value="<?php echo $packageanum; ?>"><?php echo $packagename; ?></option>
				   <?php
				   }
				   
				   ?>
				   </select></td>
				   
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Package Charges</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="packcharge" id="packcharge" readonly value="" size="20" /></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><!--Apply Admn Fee--></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><!--<input type="checkbox" name="packchargeapply" id="packchargeapply" value="1">--></td>
				   <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				 </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">NHIF Applicable </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><select name="nhifapplicable" id="nhifapplicable" onChange="return funcnhifcheck();">
				    <option value="no">Select</option>
				   <option value="yes">YES</option>
				   <option value="no">NO</option>
				   </select></td>
				   
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" >&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				   <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				 </tr>
				 <tr id="nhif">
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">NHIF ID</span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="nhifid" id="nhifid" ></td>
				   
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Issue Date </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="text" name="issuedate" id="issuedate" size="10"> <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('issuedate')" style="cursor:pointer"/> </span></strong></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Valid Till</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="text" name="validtill" id="validtill" size="10"> <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('validtill')" style="cursor:pointer"/> </span></strong></td>
				   <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">NHIF Rebate</td>
				   <td width="18%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="text" name="nhifrebate" id="nhifrebate" value="<?php echo $nhifrebate; ?>" readonly></td>
				 </tr>
<!--				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Complaint</td>
				   <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5"><input name="complaint" id="complaint" value="<?php echo $complaint; ?>" style="border: 1px solid #001E6A;"  size="75" /></td>
			      </tr>
-->				 
				 
                 <tr>
                <td colspan="8" align="middle"  bgcolor="#ecf0f5" style="padding-right:200px;"><div align="right"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input type="hidden" name="frmflag1" value="frmflag1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                  <input name="Submit222" type="submit"  value="Save Visit Entry (Alt+S)" accesskey="s" onClick="return expirydatewarning()" class="button" id="submit"/>
                </font></font></font></font></font></div></td>
              </tr>
            </tbody>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
    </table>
	</form>
<script language="javascript">
</script>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

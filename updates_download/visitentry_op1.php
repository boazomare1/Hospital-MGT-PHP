<?php 
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");

$errmsg = "";
$bgcolorcode = "";
$pagename = "";
$consultationfees1 = '';
$availablelimit = '';
$mrdno = '';
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$locationname='';
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];

$location =isset( $_REQUEST['location'])?$_REQUEST['location']:'';	
$locationcode1 =isset( $_REQUEST['locationcodenew'])?$_REQUEST['locationcodenew']:'';
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_customer1.php");

if (isset($_REQUEST["apnum"])) { $apnum = $_REQUEST["apnum"]; } else { $apnum = ""; }

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
$ipaddress = $_SERVER["REMOTE_ADDR"];
$patientcode=$_REQUEST["patientcode"];
$apnum=$_REQUEST["apnum"];
$locationname1 = $_REQUEST['locationnamenew'];	
$locationcode1 = $_REQUEST['locationcodenew'];
	$_SESSION['sessionlocationname']=$locationname1;
    $_SESSION['sessionlocationcode']=$locationcode1;
	
	$patientfirstname = $_REQUEST["patientfirstname"];
	$patientfirstname = strtoupper($patientfirstname);
	$patientmiddlename = $_REQUEST['patientmiddlename'];
	$patientmiddlename = strtoupper($patientmiddlename);
	$patientlastname = $_REQUEST["patientlastname"];
	$patientlastname = strtoupper($patientlastname);
	$patientfullname=$patientfirstname.' '.$patientmiddlename.' '.$patientlastname;
	$consultingdoctor = $_REQUEST["consultingdoctor"];
	
	$department = $_REQUEST["department"];
	
	$query43 = "select * from master_department where auto_number='$department'";
	$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res43 = mysqli_fetch_array($exec43);
	$departmentname = $res43['department'];
		$billnumbercode=$_REQUEST['billnumbercode'];
	
	$paymenttype = $_REQUEST["paymenttype"];
	$subtype = $_REQUEST["subtype"];
	$billtype = $_REQUEST["billtype"];
    $accountname = $_REQUEST["accountname"];
	
	$query87="select * from master_accountname where auto_number='$accountname'";
	$exec87=mysqli_query($GLOBALS["___mysqli_ston"], $query87);
	$res87=mysqli_fetch_array($exec87);
	$accname=$res87['accountname'];
	$accountexpirydate = $_REQUEST["accountexpirydate"];
	$planname = $_REQUEST["planname"];
	$planexpirydate = $_REQUEST["planexpirydate"];
 	$consultationdate = $_REQUEST["consultationdate"];
	$consultationtime  = $_REQUEST["consultationtime"];
	$consultationtype = $_REQUEST["consultationtype"];
	$consultationfees  = $_REQUEST["consultationfees"];
	$referredby = $_REQUEST["referredby"];
	$consultationremarks = $_REQUEST["consultationremarks"];
	$complaint = $_REQUEST["complaint"];
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
	$triag = isset($_POST["triag"])? 1 : 0;
	
	
	$patientspent=$_REQUEST['patientspent'];
	
	
	    $query77 = "update appointmentschedule_entry set visitstatus='yes' where auto_number='$apnum' ";
		$exec77= mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
	
		if($billtype == 'PAY NOW')
	{
		$query3 = "select * from master_visitentry where patientcode = '$patientcode' and  consultationdate = '$consultationdate'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rowcount3 = mysqli_num_rows($exec3);
		if ($rowcount3 != 0)
		{
			header ("location:visitentry_op1.php?errorcode=errorcode1failed");
			exit();
		}	
	}
	else
	{
	$query21 = "select * from master_visitentry where patientcode = '$patientcode' and consultationdate = '$consultationdate' order by auto_number desc limit 0,1";
	$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res21 = mysqli_fetch_array($exec21);
	$oldvisitcode = $res21['visitcode'];
	
	if($oldvisitcode != '')
	{
	$query22 = "select * from billing_paylater where visitcode='$oldvisitcode'";
	$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res22 = mysqli_num_rows($exec22);
	if ($res22 == 0)
	{
		header ("location:visitentry_op1.php?errorcode=errorcode1failed");
			exit();
		
	}
	}
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
$query2 = "select * from master_visitentry order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$res2visitcode = $res2["visitcode"];
$res2visitnum=strlen($res2visitcode);
 $vvcode6=explode("-",$res2visitcode);
 $testvalue= $vvcode6[1];
				  $value6=strlen($testvalue);
				  $visitcodepre6=$res2visitnum-$value6;
if ($res2visitcode == '')
{

	$visitcode =$visitcodeprefix.'-'.'1';
	$openingbalance = '0.00';
}
else
{

	$res2visitcode = $res2["visitcode"];
	$visitcode = substr($res2visitcode,$visitcodepre6,$res2visitnum);
	$visitcode = intval($visitcode);
	
	$visitcode = $visitcode + 1;
	$maxanum = $visitcode;
	
	
	$visitcode = $visitcodeprefix.'-'.$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
		if(($planfixedamount =='0.00' && $planpercentageamount =='0.00') && ($consultationfees =='0'))
	{
	$query2 = "select * from master_visitentry where visitcode = '$visitcode'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	
	if ($res2 == 0)
	{
		$query56="insert into master_visitentry(patientcode, visitcode, patientfirstname,patientmiddlename, patientlastname,consultationtype,consultingdoctor,accountname,accountexpirydate,paymenttype,subtype,planname,planexpirydate,visitlimit,overalllimit,billtype,
		visitcount,department,consultationdate,consultationtime,consultationfees,patientspent,planfixedamount,planpercentage,patientfullname,paymentstatus,triagestatus,age,gender,accountfullname,departmentname,username,complaint,consultationrefund,locationname1,locationcode)values('$patientcode','$visitcode','$patientfirstname','$patientmiddlename','$patientlastname','$consultationtype','$consultingdoctor','$accountname','$accountexpirydate','$paymenttype','$subtype','$planname','$planexpirydate','$visitlimit','$overalllimit','$billtype',
		'$visitcount','$department','$consultationdate','$consultationtime','$consultationfees','$patientspent','$planfixedamount','$planpercentageamount','$patientfullname','completed','','$age','$gender','$accname','$departmentname','$username','$triag','torefund','$locationname','$location')";
		$exec56=mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		header("location:visitentry_op1.php");
		exit();
}
	}
	else if(($planfixedamount =='0.00' && $planpercentageamount =='0.00') && ($department =='2'))
	
	{
	
	$query2 = "select * from master_visitentry where visitcode = '$visitcode'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
	$query56="insert into master_visitentry(patientcode, visitcode, patientfirstname,patientmiddlename, patientlastname,consultationtype,consultingdoctor,accountname,accountexpirydate,paymenttype,subtype,planname,planexpirydate,visitlimit,overalllimit,billtype,
		visitcount,department,consultationdate,consultationtime,consultationfees,patientspent,planfixedamount,planpercentage,patientfullname,paymentstatus,triagestatus,age,gender,accountfullname,departmentname,username,complaint,consultationrefund,locationname,locationcode)values('$patientcode','$visitcode','$patientfirstname','$patientmiddlename','$patientlastname','$consultationtype','$consultingdoctor','$accountname','$accountexpirydate','$paymenttype','$subtype','$planname','$planexpirydate','$visitlimit','$overalllimit','$billtype,$visitcount','$department','$consultationdate','$conultationtime','$consultationfees','$patientspent','$planfixedamount','$planpercentageamount','$patientfullname','completed','pendng','$age','$gender','$accname','$departmentname','$username','$triag','torefund','$locationname1','$location)";
		$exec56=mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		header("location:visitentry_op1.php");
	exit();
	}
	}
	
	else if(($planfixedamount =='0.00' && $planpercentageamount =='0.00') && ($department =='3'))
	
	{
	$query2 = "select * from master_visitentry where visitcode = '$visitcode'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
	$query56="insert into master_visitentry(patientcode, visitcode, patientfirstname,patientmiddlename, patientlastname,consultationtype,consultingdoctor,accountname,accountexpirydate,paymenttype,subtype,planname,planexpirydate,visitlimit,overalllimit,billtype,
		visitcount,department,consultationdate,consultationtime,consultationfees,patientspent,planfixedamount,planpercentage,patientfullname,paymentstatus,triagestatus,age,gender,accountfullname,departmentname,username,complaint,consultationrefund,locationname,locationcode)values('$patientcode','$visitcode','$patientfirstname','$patientmiddlename','$patientlastname','$consultationtype','$consultingdoctor','$accountname','$accountexpirydate','$paymenttype','$subtype','$planname','$planexpirydate','$visitlimit','$overalllimit','$billtype',
		'$visitcount','$department','$consultationdate','$consultationtime','$consultationfees','$patientspent','$planfixedamount','$planpercentageamount','$patientfullname','completed','pending','$age','$gender','$accname','$departmentname','$username','$triag','torefund','$locationname1','$location')";
		$exec56=mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		header("location:visitentry_op1.php");
	exit();
	}
		}
	else if($planfixedamount =='0.00' && $planpercentageamount =='0.00') 
		{
		$query2 = "select * from master_visitentry where visitcode = '$visitcode'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
	$query56="insert into master_visitentry(patientcode, visitcode, patientfirstname,patientmiddlename, patientlastname,consultationtype,consultingdoctor,accountname,accountexpirydate,paymenttype,subtype,planname,planexpirydate,visitlimit,overalllimit,billtype,
		visitcount,department,consultationdate,consultationtime,consultationfees,patientspent,planfixedamount,planpercentage,patientfullname,paymentstatus,triagestatus,age,gender,accountfullname,departmentname,username,complaint,consultationrefund,locationname,locationcode)values('$patientcode','$visitcode','$patientfirstname','$patientmiddlename','$patientlastname','$consultationtype','$consultingdoctor','$accountname','$accountexpirydate','$paymenttype','$subtype','$planname','$planexpirydate','$visitlimit','$overalllimit','$billtype',
		'$visitcount','$department','$consultationdate','$consultationtime','$consultationfees','$patientspent','$planfixedamount','$planpercentageamount','$patientfullname','completed','pending','$age','$gender','$accname','$departmentname','$username','$triag','torefund','$locationname1','$location')";
		$exec56=mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		header("location:visitentry_op1.php");
		exit();
		}
		}
		else if($consultationfees =='0')
		{
		$query2 = "select * from master_visitentry where visitcode = '$visitcode'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
		$query56="insert into master_visitentry(patientcode, visitcode, patientfirstname,patientmiddlename, patientlastname,consultationtype,consultingdoctor,accountname,accountexpirydate,paymenttype,subtype,planname,planexpirydate,visitlimit,overalllimit,billtype,
		visitcount,department,consultationdate,consultationtime,consultationfees,patientspent,planfixedamount,planpercentage,patientfullname,paymentstatus,triagestatus,age,gender,accountfullname,departmentname,username,complaint,consultationrefund,locationname,locationcode)values('$patientcode','$visitcode','$patientfirstname','$patientmiddlename','$patientlastname','$consultationtype','$consultingdoctor','$accountname','$accountexpirydate','$paymenttype','$subtype','$planname','$planexpirydate','$visitlimit','$overalllimit','$billtype',
		'$visitcount','$department','$consultationdate','$consultationtime','$consultationfees','$patientspent','$planfixedamount','$planpercentageamount','$patientfullname','completed','pending','$age','$gender','$accname','$departmentname','$username','$triag','torefund','$locationname1','$location')";
		$exec56=mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		header("location:visitentry_op1.php");
	exit();
		}
		}
		else if($department =='2')
		{
		$query2 = "select * from master_visitentry where visitcode = '$visitcode'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
		$query56="insert into master_visitentry(patientcode, visitcode, patientfirstname,patientmiddlename, patientlastname,consultationtype,consultingdoctor,accountname,accountexpirydate,paymenttype,subtype,planname,planexpirydate,visitlimit,overalllimit,billtype,
		visitcount,department,consultationdate,consultationtime,consultationfees,patientspent,planfixedamount,planpercentage,patientfullname,paymentstatus,triagestatus,age,gender,accountfullname,departmentname,username,consultationrefund,complaint,locationname,locationcode)values('$patientcode','$visitcode','$patientfirstname','$patientmiddlename','$patientlastname','$consultationtype','$consultingdoctor','$accountname','$accountexpirydate','$paymenttype','$subtype','$planname','$planexpirydate','$visitlimit','$overalllimit','$billtype',
		'$visitcount','$department','$consultationdate','$consultationtime','$consultationfees','$patientspent','$planfixedamount','$planpercentageamount','$patientfullname','','','$age','$gender','$accname','$departmentname','$username','torefund','$triag','$locationname1','$location')";
		$exec56=mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		header("location:visitentry_op1.php");
	exit();
		}
		}
		else if($department =='3')
		{
		$query2 = "select * from master_visitentry where visitcode = '$visitcode'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
		$query56="insert into master_visitentry(patientcode, visitcode, patientfirstname,patientmiddlename, patientlastname,consultationtype,consultingdoctor,accountname,accountexpirydate,paymenttype,subtype,planname,planexpirydate,visitlimit,overalllimit,billtype,
		visitcount,department,consultationdate,consultationtime,consultationfees,patientspent,planfixedamount,planpercentage,patientfullname,paymentstatus,triagestatus,age,gender,accountfullname,departmentname,username,consultationrefund,complaint,locationname,locationcode)values('$patientcode','$visitcode','$patientfirstname','$patientmiddlename','$patientlastname','$consultationtype','$consultingdoctor','$accountname','$accountexpirydate','$paymenttype','$subtype','$planname','$planexpirydate','$visitlimit','$overalllimit','$billtype',
		'$visitcount','$department','$consultationdate','$consultationtime','$consultationfees','$patientspent','$planfixedamount','$planpercentageamount','$patientfullname','','','$age','$gender','$accname','$departmentname','$username','torefund','$triag','$locationname1','$location')";
		$exec56=mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		header("location:visitentry_op1.php");
	exit();
	}
		}
		else
		{
	$query2 = "select * from master_visitentry where visitcode = '$visitcode'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
		$query1 = "insert into master_visitentry (patientcode, visitcode, patientfirstname,patientmiddlename, patientlastname,patientfullname, consultingdoctor,
		department,paymenttype,subtype,billtype,accountname,accountexpirydate,planname,planexpirydate,consultationdate,consultationtime,consultationtype,consultationfees,referredby,consultationremarks,complaint,registrationdate,visittype,visitlimit,overalllimit,visitcount,patientspent,planpercentage,planfixedamount,age,gender,accountfullname,itemrefund,departmentname,username,consultationrefund,locationname,locationcode) 
		values('$patientcode','$visitcode','$patientfirstname','$patientmiddlename','$patientlastname','$patientfullname','$consultingdoctor',
		'$department','$paymenttype','$subtype','$billtype','$accountname','$accountexpirydate','$planname','$planexpirydate','$consultationdate','$consultationtime','$consultationtype','$consultationfees','$referredby', '$consultationremarks','$triag','$registrationdate','$visittype','$visitlimit','$overalllimit','$visitcount','$patientspent','$planpercentageamount','$planfixedamount','$age','$gender','$accname','torefund','$departmentname','$username','torefund','$locationname1','$location')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		
		
		
		
			
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
		header("location:visitentry_op1.php");
		exit();
		header ("location:addcompany1.php?st=success&&cpynum=1");
		
	}
	else
	{
		header ("location:visitentry_op1.php?patientcode=$patientcode&&st=failed");
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
	$lastvisitdate = '';
	$visitdays = '';
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
$query2 = "select * from master_visitentry order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$res2visitcode = $res2["visitcode"];
$res2visitnum=strlen($res2visitcode);
 $vvcode6=explode("-",$res2visitcode);
 $testvalue= $vvcode6[1];
				  $value6=strlen($testvalue);
				  $visitcodepre6=$res2visitnum-$value6;
				  
if ($res2visitcode == '')
{

	$visitcode =$visitcodeprefix.'-'.'1';
	$openingbalance = '0.00';
}
else
{

	$res2visitcode = $res2["visitcode"];
	$visitcode = substr($res2visitcode,$visitcodepre6,$res2visitnum);
	$visitcode = intval($visitcode);
	
	$visitcode = $visitcode + 1;
	$maxanum = $visitcode;
	
	
	$visitcode = $visitcodeprefix.'-'.$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
<script>

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
		document.getElementById("visitcode").value = "<?php echo $scriptlocationprefix.'-'.$maxanum; ?>";
		
		}
	<?php
	 }?>
	//document.form1.customercode.value='ok';
	
}

</script>

<?php
$res11locationcode='';
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

$registrationdate = date('Y-m-d');
$consultationdate = date('Y-m-d');
$consultationtime = date('H:i');

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

    $paymenttype1 = $res3['paymenttype'];
	
	$paymenttype = $res3['paymenttype'];
	
	$mrdno = $res3['mrdno'];
	
	$res11locationcode=$res3['locationcode'];
	
	$query4 = "select * from master_paymenttype where auto_number = '$paymenttype'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$paymenttypeanum = $res4['auto_number'];
	$paymenttype = $res4['paymenttype'];
	
	$subtype = $res3['subtype'];
	$query4 = "select * from master_location where auto_number = '$subtype'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	 $subtypeanum = $res4['auto_number'];
	//$subtype = $res4['subtype'];

	$billtype = $res3['billtype'];
	$age = $res3['age'];
	$gender = $res3['gender'];
	
	//get subtype name
	$query24 = "select subtype from master_subtype where auto_number = '$subtype'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	 $subtype = $res4['subtype'];
	 //end of get subtype name
	
	$accountname = $res3['accountname'];
	
	$query4 = "select * from master_accountname where auto_number = '$accountname'";
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
	$planfixedamount = $res4['planfixedamount'];
	$planpercentageamount = $res4['planpercentage'];
	
	$query5 = "select * from master_visitentry where patientcode = '$patientcode' and recordstatus = ''";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rowcount5 = mysqli_num_rows($exec5);
	$visitcount = $rowcount5 + 1;
	
	$query51 = "select * from master_visitentry where patientcode = '$patientcode' and recordstatus = '' order by auto_number desc limit 0,1";
	$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res51 = mysqli_fetch_array($exec51);
    $lastvisitdate = $res51['consultationdate'];
	if($lastvisitdate == '')
	{
	$lastvisitdate = $consultationdate;
	}
	$todaysdatetime = strtotime($consultationdate);
	$lastvisitdatetime = strtotime($lastvisitdate);
	$datediff = $todaysdatetime - $lastvisitdatetime;
	$visitdays = floor($datediff/(60*60*24));
	
	
	
	$planexpirydate = $res3['planexpirydate'];
	$registrationdate = $res3['registrationdate'];
	
	$visitlimit = $res3['visitlimit'];	
	$overalllimit = $res3['overalllimit'];
	if($visitcount == 1)
	{
	$availablelimit=$overalllimit ;
	}
	else
	{
	$availablelimit=$overalllimit-$planfixedamount;
	}
	
	
	
}



//$consultationfees = '500';

if (isset($_REQUEST["errorcode"])) { $errorcode = $_REQUEST["errorcode"]; } else { $errorcode = ""; }
//$patientcode = 'MSS00000009';
if ($errorcode == 'errorcode1failed')
{
	$errmsg = 'Patient Already Visited Today. Cannot Proceed With Visit Entry. Save Not Completed.';	
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
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script type="text/javascript" src="js/membervalidation.js"></script>
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

</script>

<?php	$query1111 = "select * from master_employee where username = '$username'";
    $exec1111 = mysqli_query($GLOBALS["___mysqli_ston"], $query1111) or die ("Error in Query1111".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res1111 = mysqli_fetch_array($exec1111))
	{
	$username = $res1111["username"];
	$locationnumber = $res1111["location"];
	$query1112 = "select * from master_location where auto_number = '$locationnumber' and status <> 'deleted'";
    $exec1112 = mysqli_query($GLOBALS["___mysqli_ston"], $query1112) or die ("Error in Query1112".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res1112 = mysqli_fetch_array($exec1112))
	{
		 $locationname = $res1112["locationname"];		  
		 $locationcode = $res1112["locationcode"];
		 $prefix = $res1112["prefix"];
		 $suffix = $res1112["suffix"];
	}
	}

?>
<style type="text/css">
<!--
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
-->
</style>
</head>
<script language="javascript">

function enabtriage()
{

  if (document.getElementById("enabtriag") != null) 
     {
	 document.getElementById("enabtriag").style.display = 'none';
	}
	if (document.getElementById("enabtriag") != null) 
	  {
	  document.getElementById("enabtriag").style.display = '';
	 }

}
function distriage()
{		
 if (document.getElementById("enabtriag") != null) 
	{
	document.getElementById("enabtriag").style.display = 'none';
	}	
}
function process1()
{
	document.getElementById('submit').disabled="true";
	//alert ("Before Function");
	//To validate patient is not registered for the current date.
	//funcVisitEntryPatientCodeValidation1();
	//return false;


	/*if (document.form1.patientcode.value == "")
	{
		alert ("Please Search & Select Patient To Proceed.");
		document.form1.visittype.focus();
		return false;
	}
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
		document.getElementById('submit').disabled="";
			return false;
	}
	
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
		document.getElementById('submit').disabled="";
		return false;
	  }		
  }
	
	if (document.form1.department.value == "")
	{
		alert ("Please Select Department.");
		document.form1.department.focus();
		document.getElementById('submit').disabled="";
		return false;
	}
	
	/*if (document.form1.consultingdoctor.value == "")
	{
		alert ("Please Select Consulting Doctor.");
		document.form1.consultingdoctor.focus();
		document.getElementById('submit').disabled="";
		return false;
	}	
	*/
	if (document.form1.consultationtype.value == "")
	{
		alert ("Please Select Consultation Type.");
		document.form1.consultationtype.focus();
		document.getElementById('submit').disabled="";
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
			document.getElementById('submit').disabled="";
			return false;
		}
	}
	
	/*if(document.getElementById("visitdays").value > 1)
	{
	if(document.getElementById("consultationfees").value == 0)
	{
	alert("Review Fees is not Applicable");
	return false;
	}
	}*/
	
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
			document.getElementById('submit').disabled="";
			return false;
		}	
	}

var patientcode = document.getElementById("patientcode").value;
var popWin; 
popWin = window.open("print_opvisit_label.php?patientcode="+patientcode,"OriginalWindowA4",'width=800,height=800,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
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
	$query11 = "select * from master_department where recordstatus = '' order by auto_number ASC";
    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res11 = mysqli_fetch_array($exec11))
	{
	$res11departmentanum = $res11['auto_number'];
	$res11department = $res11["department"];
	
	$query4 = "select * from master_location where status = ''";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res4 = mysqli_fetch_array($exec4))
	{
	
	$res4locanum = $res4['auto_number'];
	$res4loccode = $res4['locationcode'];
	?>
		if(document.getElementById("department").value == "<?php echo $res11departmentanum; ?>")
		{
		if(document.getElementById("location").value == "<?php echo $res4loccode; ?>")
		{
		//alert(document.getElementById("department").value);
		document.getElementById("consultationtype").options.length=null; 
		var combo = document.getElementById('consultationtype'); 
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Consultation Type", ""); 
		<?php
		$query10 = "select * from master_consultationtype where department = '$res11departmentanum' and locationname = '$res4locanum' order by consultationtype";
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
		}
	<?php
	}
	}
	?>
 

}
function funcConsultationTypeChange()
{
//alert("hi");
document.getElementById("consultationfees").value = '';
	<?php
	$query11 = "select * from master_consultationtype where recordstatus = '' ";
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


function funcOnLoadBodyFunctionCall()
{ 
	//alert ("Inside Body On Load Fucntion.");
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	funcbankDropDownSearch1();
	funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
	distriage();
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

</script>

<?php include ("js/dropdownlist1newscripting1.php"); ?>
<?php include ("js/dropdownlistdoctorname.php"); ?>
<script type="text/javascript" src="js/autosuggestnew1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newcustomer.js"></script>
<script type="text/javascript" src="js/autocustomercodesearch2op.js"></script>

<script type="text/javascript" src="js/autosuggestdoctorvis.js"></script> 
<script type="text/javascript" src="js/autocomplete_doctorvis.js"></script>

  <script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script type="text/javascript" src="js/visitentrypatientcodevalidation1.js"></script>

<script src="js/datetimepicker_css.js"></script>

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


      	  <form name="form1" id="form1" method="post" action="visitentry_op1.php" onKeyDown="return disableEnterKey(event)" onSubmit="return process1()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860"><table width="1258" height="282" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="2"><strong>Visit Entry </strong></td>
                <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                <td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td bgcolor="#ecf0f5" class="bodytext3"></td>
                
              </tr>
  
             <tr>
                <td colspan="11" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo 'red'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
               
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
				  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5">
				  <input name="customer" id="customer" size="60" autocomplete="off">
				  <input name="customerhiddentextbox" id="customerhiddentextbox" value="" type="hidden">
				  <input name="customercode" id="customercode" value="" type="hidden">
				  <input name="nationalid" id="nationalid" value = "" type = "hidden">
				  <input name="accountnames" id="accountnames" value="" type="hidden">
				  <input name = "mobilenumber111" id="mobilenumber111" value="" type="hidden">
 				<input type="hidden" name="recordstatus" id="recordstatus">
				  <input type="hidden" name="billnumbercode" id="billnumbercode" value="<?php echo $billnumbercode; ?>" readonly style="border: 1px solid #001E6A;">	
				  <input name="apnum" id="apnum" value="<?php echo $apnum; ?>" type="hidden">
				  			  </td>
				  </tr>
				
				<tr><td  class="bodytext3" ><strong> Location </strong></td>
              <td  class="bodytext3" >
              <select name="location" id="location" onChange="locationform(form1,this.value)"  style="border: 1px solid #001E6A;">
                  <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>" <?php if($res11locationcode!=''){if($res11locationcode == $res1locationanum){echo "selected";}}?>><?php echo $res1location; ?></option>
						<?php
						}
						?>
                  </select>
                  <input type="hidden" name="locationnamenew" value="<?php echo $locationname; ?>">
                <input type="hidden" name="locationcodenew" value="<?php echo $res1locationanum; ?>">
             </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				  <td width="12%" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				  <td width="13%" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				
				  <td width="26%" rowspan="6" align="center" valign="middle"  bgcolor="#ecf0f5"><img width="150" height="150" src="patientphoto/<?php echo $patientcode; ?>.jpg" id="img"></td>
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
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				 </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Patient Reg ID </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">
				  <input name="patientcode" id="patientcode" size="20" value="<?php echo $patientcode; ?>" /></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Registration Date </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="registrationdate" id="registrationdate" value="<?php echo $consultationdate; ?>" ></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Gender</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="gender" value="<?php echo $gender; ?>" id="gender" readonly></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Type</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="paymenttypename" id="paymenttypename"  value="<?php echo $paymenttype;?>" readonly>
				    <input type="hidden" name="paymenttype" id="paymenttype"  value="<?php echo $paymenttypeanum;?>" readonly   style="border: 1px solid #001E6A;">					</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Visit ID </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" readonly size="20" /></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Account</span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="accountnamename" id="accountnamename"  value="<?php echo $accountname;?>"  readonly="readonly" style="width: 250px">
				    <input type="hidden" name="accountname" id="accountname"  value="<?php echo $accountnameanum;?>"  readonly="readonly"  style="border: 1px solid #001E6A;"></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				</tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Sub Type </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>
                 
				    <input type="text" name="subtypename" id="subtypename"  value="<?php echo $subtype;?>"  readonly="readonly"  >
				    <input type="hidden" name="subtype" id="subtype"  value="<?php echo $subtypeanum;?>"  readonly="readonly"  style="border: 1px solid #001E6A;">
				  </label></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Bill Type </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="billtype" id="billtype"  value="<?php echo $billtype;?>"  readonly="readonly" ></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Account Expiry</span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="accountexpirydate" id="accountexpirydate"  value="<?php echo $accountexpirydate;?>"  readonly="readonly" ></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				  </tr>
				
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Plan Name </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>
                    <input type="text" name="plannamename" id="plannamename"  value="<?php echo $planname;?>"   readonly="readonly">
                    <input type="hidden" name="planname" id="planname"  value="<?php echo $plannameanum;?>"   readonly="readonly" style="border: 1px solid #001E6A;">
                  </label></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Plan Expiry </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="planexpirydate" id="planexpirydate"  value="<?php echo $planexpirydate;?>"   readonly="readonly" ></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Last Visit</span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="lastvisitdate" id="lastvisitdate" value="<?php echo $lastvisitdate; ?>" readonly>
				    <input type="hidden" name="visitlimit" id="visitlimit"  value="<?php echo $visitlimit;?>"   readonly="readonly" ></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label></label></td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Fixed Amt </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>
				  <input type="text" name="planfixedamount" id="planfixedamount"  value="<?php echo $planfixedamount;?>">
				  </label></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Overall Limit </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="overalllimit" id="overalllimit"  value="<?php echo $overalllimit;?>"   readonly="readonly"></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Patient Due</span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="patientspent" id="patientspent"  value="<?php echo $patientspent;?>"   readonly="readonly" ></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label></label></td>
				  </tr>
				
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Percentage</td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>
				 <input type="text" name="planpercentageamount" id="planpercentageamount"  value="<?php echo $planpercentageamount;?>"   readonly="readonly" ></label> </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Available Limit </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="availablelimit" id="availablelimit"  value="<?php echo $availablelimit;?>"   readonly="readonly" ></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Visit Days </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><strong>
				    <input type="text" name="visitdays" id="visitdays" value="<?php echo $visitdays; ?>" readonly>
				    <input type="hidden" name="visitcount" id="visitcount"  value="<?php echo $visitcount;?>"   readonly="readonly" >
				    <input name="visittype" id="visittype" value="" type="hidden">
				  </strong></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label></label></td>
				</tr>
				
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Department</span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><strong><!--				   
				    <select name="hidden" id="visittype" >
                      <?php
				if ($visittype == '')
				{
					echo '<option value="" selected="selected">Select Visit Type</option>';
				}
				else
				{
					$query51 = "select * from master_visittype where recordstatus = ''";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res51 = mysqli_fetch_array($exec51);
					$res51visittype = $res51["visittype"];
					//echo '<option value="">Select Normal Tax</option>';
					echo '<option value="'.$res51visittype.'" selected="selected">'.$res51visittype.'</option>';
				}
				
				$query5 = "select * from master_visittype where recordstatus = '' order by visittype";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5visittype = $res5["visittype"];
				?>
                      <option value="<?php echo $res5visittype; ?>"><?php echo $res5visittype; ?></option>
                      <?php
				}
				?>
                    </select>
-->
				      <select name="department" id="department" onChange="return funcDepartmentChange()">
                        <!--<option value="">Select Department</option>-->
              
                        <?php
				$query6 = "select * from master_department where recordstatus = '' order by auto_number ASC";
				$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res6 = mysqli_fetch_array($exec6))
				{
				$res6anum = $res6["auto_number"];
				$res6department = $res6["department"];
				?>
                        <option value="<?php echo $res6anum; ?>" ><?php echo $res6department; ?></option>
                        <?php
				}
				?>
                      </select>
				  </strong></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Consulting Doctor </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><strong>
			<input name="consultingdoctor" id="consultingdoctor" value="" />
			<input name="consultingdoctorsearch" id="consultingdoctorsearch" value="" type="hidden" />
				  </strong></td>
				  
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32"> Fee Type</span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><strong>
				    <select name="consultationtype" id="consultationtype" onChange="return funcConsultationTypeChange()">
                     <!-- <option value="" selected="selected">Select Consultation Type</option>-->
                      
					  
					  
					  
					  <?php 
					 
					  $que = "select * from login_locationdetails where username='$username' and docno='$docno' order by auto_number desc";
						$exe = mysqli_query($GLOBALS["___mysqli_ston"], $que) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res = mysqli_fetch_array($exe);
						
						$resultlocation = $res["locationname"];
						$resultlocationanum = $res["locationcode"];
						
						$s =0 ;
						$t=0;
				  $query52="select * from master_consultationtype where locationcode = '$resultlocationanum' and department = '1' and recordstatus = ''";
				  $exec52=mysqli_query($GLOBALS["___mysqli_ston"], $query52) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  while($res52=mysqli_fetch_array($exec52))
				  {
				  $res52anum=$res52["auto_number"];
				  $res52consultationtype=$res52["consultationtype"];
				  $s = $s + 1;
				  if($s == 1)
				  {
					  $res52fees = $res52["consultationtype"];
				  }
				  ?>
                      <option value="<?php echo $res52anum; ?>" ><?php echo $res52consultationtype; ?></option>
                      <?php
				  }
					  
				  ?>
                    </select>
				  </strong></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">
				  <!--<input type="hidden" name="department" id="department" value="<?php echo $department; ?>" style="border: 1px solid #001E6A;"  size="20" />--></td>
				</tr>
				<tr>
                <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Visit Date </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="consultationdate" id="consultationdate" value="<?php echo $consultationdate; ?>" readonly ></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32"> Time </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="consultationtime" id="consultationtime" value="<?php echo $consultationtime; ?>" readonly size="10" /></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Consultation Fees </span></td>
              <?php  
                $query53="select * from master_consultationtype where locationcode = '$resultlocationanum' and department = '1' and recordstatus = ''";
				
				  $exec53=mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				  $res53=mysqli_fetch_array($exec53);
				  
				  $res53anum=$res52["auto_number"];
				  $res53consultationfees=$res53["consultationfees"];
				  
				  ?>
                  
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="consultationfees" id="consultationfees" value="<?php echo $res53consultationfees; ?>" onFocus="return funcVisitEntryPatientCodeValidation1()" size="20" readonly/></td>
               
                <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				</tr>
				 
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Member No </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="memberno" id="memberno" onBlur="membernovalidation1();" value="" size="20" /></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><label onClick="return enabtriage();">MRD NO </label></span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="mrdno" id="mrdno" value="<?php echo $mrdno; ?>"readonly="readonly" size="20" /></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				 </tr>
				 
			 <tr id="enabtriag">
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Triage</td>
				   <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="triag" id="triag" checked="checked"></td>
			      </tr>
			 
				 
                 <tr>
				 <td></td>
				 <td colspan="2"><span id="name" class="bodytext32"></span><br><span id="policy" class="bodytext32"></span><br><span id="insurance" class="bodytext32"></span></td>
                <td colspan="4" align="middle"  bgcolor="#ecf0f5"><div align="center"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input type="hidden" name="frmflag1" value="frmflag1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                  <input name="Submit222" type="submit"  value="Save Visit Entry (Alt+S)" accesskey="s" class="button" id="submit" onClick="return funcRegistrationOPLabel()"/>
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
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
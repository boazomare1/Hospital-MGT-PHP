<?php 
session_start();
error_reporting(0);
include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$myBase = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
$errmsg = "";
$bgcolorcode = "";
$pagename = "";
$consultationfees1 = '';
$availablelimit = '';
$admissionfees = '';
$photoavailable = '';
$memberno='';
$overallplandue = 0;
$currentdate = date('Y-m-d H:i:s');
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
// this is for resubmit process, suppose if dupicate code happened. added by k Kenique on 25 may 2019
 visitcreate:
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
$loc_anum = $res3['auto_number'];
//$visitcodeprefix1=strlen($visitcodeprefix);
	
    $query3 = "select * from master_company where companystatus = 'Active'"; 
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$ipvisitcodeprefix = $res3['ipvisitcodeprefix'];
	$ipvisitcodeprefix=chop($ipvisitcodeprefix,"-");
	$visitcodeprefix1=strlen($visitcodeprefix);
$query2 = "select * from master_ipvisitentry  order by auto_number desc limit 0, 1"; 
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$res2visitcode=$_REQUEST['visitcode'];
$res2visitnum=strlen($res2visitcode);
 $vvcode6=str_split($res2visitcode);
$value6=arrayHasOnlyInts($vvcode6);
$visitcodepre6=$res2visitnum-$value6-'1';
if ($res2visitcode == '')
{
$visitcode =$ipvisitcodeprefix."-".'1'."-".$loc_anum; 
$openingbalance = '0.00';
}else{
	$res2visitcode;
	$visitexplode = explode('-',$res2visitcode);
 	$visitcode = $visitexplode[1];
	$visitcode = intval($visitcode);
	$maxanum = $visitcode;
	$visitcode = $ipvisitcodeprefix ."-".$maxanum."-".$loc_anum;   
	$openingbalance = '0.00';
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
	$consultingdoctor1=$execdoc['doctorname'];
	$consultingdoctorcode1=$execdoc['doctorcode'];
    /*if(isset($consultingdoctorcode1) && $consultingdoctorcode1!='')
          $consultingdoctortype = 1;
	else
		$consultingdoctortype =0;
 */
   
	if(isset($_REQUEST["admissiondoctorType"]) && $_REQUEST["admissiondoctorType"]!='')
	 $consultingdoctortype = $_REQUEST["admissiondoctorType"];
	else
	 $consultingdoctortype = $_REQUEST["consultingdoctorType"];
 
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
	
 /*    $query87="select * from master_accountname where auto_number='$accountname' and recordstatus != 'DELETED' and recordstatus != 'SUSPENDED'"; 
	$exec87=mysqli_query($GLOBALS["___mysqli_ston"], $query87);
	$res87=mysqli_fetch_array($exec87); */
	$accname=$_REQUEST['accountnamename'];
	$accountexpirydate = $_REQUEST["accountexpirydate"];
	$planname = $_REQUEST["planname"];
	/*$query87p="select smartap from master_planname where auto_number='$planname'";
	$exec87p=mysqli_query($GLOBALS["___mysqli_ston"], $query87p);
	$res87p=mysqli_fetch_array($exec87p);
	$original_smart=$smartap=$res87p['smartap'];*/
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
	$visitlimit = str_replace(',', '', $visitlimit);
	$overalllimit = $_REQUEST["overalllimit"];
	$visitcount = $_REQUEST["visitcount"];
	$planfixedamount = $_REQUEST["planfixedamount"];
	$planpercentageamount = $_REQUEST["planpercentageamount"];
	$updatedatetime = date('Y-m-d H:i:s');
	$age = $_REQUEST['age'];
	$gender = $_REQUEST['gender'];
	$packapp = isset($_POST['packapplicable'])?$_POST['packapplicable']:'';
	$opadmissiondoctor = $_REQUEST['admissiondoctor'];
	$opadmissiondoctorCode = $_REQUEST['admissiondoctorCode'];
	$opdoctorcode = $_REQUEST['opdoctorcode'];
	$op_visit = $_REQUEST['op_visit'];
	$admissionnotes = addslashes($_REQUEST['admissionnotes']);
	$memberno = $_REQUEST['memberno'];
	$smartbenefitno = $_REQUEST["smartbenefitno"];
	$admitid = $_REQUEST["admitid"];
	
	$visit_ward = $_REQUEST["visit_ward"];
	$parts = explode("||", $_POST['visit_ward']);
	// Access the parts of the split value
	$visit_ward = $parts[1];
	
	
	$slade_authentication_token = addslashes($_REQUEST['slade_authentication_token']);
	$savannah_authid = $_REQUEST['savannah_authid'];	
	$savannahvalid_from = $_REQUEST['savannahvalid_from'];
	$savannahvalid_to = $_REQUEST['savannahvalid_to'];
	$offpatient = $_REQUEST['offpatient'];
	/*if($offpatient==1)
	{
	 $smartap='0';  
	}
	if(($offpatient==1)&&($original_smart=='3'))
	{
	 $smartap=3;   
	}*/
	
	$ack = $packapp;
	if($ack == '1')
	{
	$package = $_REQUEST['package'];
	$packcharge = $_REQUEST['packcharge'];
	$packchargeapply = $packapp;
	}
	else
	{
	$package = '';
	$packcharge = '';
	$packchargeapply = '';
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
	$preauth_ref=$_REQUEST['preauth_ref'];
	$ipplandue = $_REQUEST['plandue'];
	$scheme_id = $_REQUEST['scheme_id'];
	
	$mrdno = $_REQUEST['mrdno'];
	$mrdstatus = isset($_REQUEST['mrd']) ? $_REQUEST['mrd'] : '';
	
		$query3 = "select * from master_ipvisitentry where patientcode = '$patientcode' and  registrationdate = '$registrationdate'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rowcount3 = mysqli_num_rows($exec3);
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
		header ("location:ipvisitentry_new.php?errorcode=errorcode1failed");
		exit();
		}
		}
		
	 $query2 = "select * from master_ipvisitentry where visitcode = '$visitcode'"; 
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	$query4 = "select * from master_planname where auto_number = '$planname'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$planstatus = $res4['planstatus'];
	$eclaimstatus = $res4['smartap'];
	
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
	$query_edition = "select * from master_edition where `from` <= '$currentdate' and `end` >= '$currentdate' and status = 'ACTIVE'";
	$execed = mysqli_query($GLOBALS["___mysqli_ston"], $query_edition) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$resed = mysqli_num_rows($execed);
	if($resed > 0)
	{
	if ($res2 == 0)
	{
		$query1 = "insert into master_ipvisitentry(eclaim_id,scheme_id,locationcode,type,patientcode, visitcode, patientfirstname,patientmiddlename, patientlastname,patientfullname, consultingdoctor,
		department,paymenttype,subtype,billtype,accountname,accountexpirydate,planname,planexpirydate,consultationdate,consultationtime,consultationtype,admissionfees,referredby,consultationremarks,complaint,registrationdate,visittype,visitlimit,overalllimit,visitcount,patientspent,planpercentage,planfixedamount,age,gender,accountfullname,itemrefund,package,packagecharge,nhifid,nhifissuedate,nhifvaliddate,nhifrebate,deposit,packchargeapply,username,opadmissiondoctor,admissionnotes,locationname,memberno,admitid,smartbenefitno,ipplandue,opadmissiondoctorCode,opdoctorcode,consultingdoctorName,consultingdoctorCode,doctorType,op_visit,slade_payload,savannah_authid,savannahvalid_from,savannahvalid_to,visit_ward,preauth_ref,offpatient) 
		values
		('$eclaimstatus','$scheme_id','$reslocationcode','$type','$patientcode','$visitcode','$patientfirstname','$patientmiddlename','$patientlastname','$patientfullname','$consultingdoctor',
		'$department','$paymenttype','$subtype','$billtype','$accountname','$accountexpirydate','$planname','$planexpirydate','$consultationdate','$consultationtime','$consultationtype','$admissionfees','$referredby', '$consultationremarks','$complaint','$registrationdate','$visittype','$visitlimit','$overalllimit','$visitcount','$patientspent','$planpercentageamount','$planfixedamount','$age','$gender','$accname','torefund','$package','$packcharge','$nhifid','$issuedate','$validtill','$nhifrebate','$deposit','$packchargeapply','$username','$opadmissiondoctor','$admissionnotes','$reslocationname','$memberno','$admitid','$smartbenefitno','$ipplandue','$opadmissiondoctorCode','$opdoctorcode','$consultingdoctor1','$consultingdoctorcode1','$consultingdoctortype','$op_visit','$slade_authentication_token','$savannah_authid','$savannahvalid_from','$savannahvalid_to','$visit_ward','$preauth_ref','$offpatient')";  
		
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) ;
		if( mysqli_errno($GLOBALS["___mysqli_ston"]) == 1062) {
		   goto visitcreate;
		}
		else if(mysqli_errno($GLOBALS["___mysqli_ston"]) > 0){
		   die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		
		
		$query661 = "select filenumber from filenumber where filenumber = '$mrdno' and locationcode='$res100ocationanum'";
		$exec661 = mysqli_query($GLOBALS["___mysqli_ston"], $query661) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num661 = mysqli_num_rows($exec661);
		if($num661 == 0)
		{
			if($mrdstatus==1){
					$suffix =  date('y');

					$query100 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
					$exec100 = mysqli_query($GLOBALS["___mysqli_ston"], $query100) or die ("Error in Query100".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res100 = mysqli_fetch_array($exec100);
					$res100ocationanum = $res100["locationcode"];

					$query3 = "select * from master_location where status = '' and locationcode='$res100ocationanum'"; 
					$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res3 = mysqli_fetch_array($exec3);
					$loc_anum = $res3['auto_number'];

					$query790 = "select filenumber from filenumber where filestatus = '1' and locationcode='$res100ocationanum' order by auto_number desc limit 0,1";
					$exec790 =  mysqli_query($GLOBALS["___mysqli_ston"], $query790) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$res790 = mysqli_fetch_array($exec790);
					$filenumber = $res790['filenumber'];

					if($filenumber == '') {
					$mrdno = '100'."-".$loc_anum."-".$suffix;
					} else {
					$fileexplode = explode('-',$filenumber);
					$filenumber = $fileexplode[0];
					$mrd_autono1 = $filenumber + 1;
					$mrdno = $mrd_autono1."-".$loc_anum."-".$suffix;
					}


				}
			$query67 = "insert into filenumber (`filenumber`, `patientcode`, `patientfirstname`, `patientmiddlename`, `patientlastname`, `patientname`, `filestatus`, `ipaddress`, `username`,`updatedatetime`,`locationcode`)
			values('$mrdno','$patientcode','$patientfirstname','$patientmiddlename','$patientlastname','$patientfullname','$mrdstatus','$ipaddress','$username','$currentdate','$reslocationcode')";
			$exec67 =mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$query68 = "update master_ipvisitentry set mrdno = '$mrdno' where patientcode = '$patientcode' and mrdno = '' and locationcode='$reslocationcode' ";
    		$exec68 =mysqli_query($GLOBALS["___mysqli_ston"], $query68) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		}
		else
		{
		   if($mrdstatus==1)
		   {
					$suffix =  date('y');

					$query100 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
					$exec100 = mysqli_query($GLOBALS["___mysqli_ston"], $query100) or die ("Error in Query100".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res100 = mysqli_fetch_array($exec100);
					$res100ocationanum = $res100["locationcode"];

					$query3 = "select * from master_location where status = '' and locationcode='$res100ocationanum'"; 
					$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res3 = mysqli_fetch_array($exec3);
					$loc_anum = $res3['auto_number'];

					$query790 = "select filenumber from filenumber where filestatus = '1' and locationcode='$res100ocationanum' order by auto_number desc limit 0,1";
					$exec790 =  mysqli_query($GLOBALS["___mysqli_ston"], $query790) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$res790 = mysqli_fetch_array($exec790);
					$filenumber = $res790['filenumber'];

					if($filenumber == '') {
					$mrdno = '100'."-".$loc_anum."-".$suffix;
					} else {
					$fileexplode = explode('-',$filenumber);
					$filenumber = $fileexplode[0];
					$mrd_autono1 = $filenumber + 1;
					$mrdno = $mrd_autono1."-".$loc_anum."-".$suffix;
					}

	        $query67 = "insert into filenumber (`filenumber`, `patientcode`, `patientfirstname`, `patientmiddlename`, `patientlastname`, `patientname`, `filestatus`, `ipaddress`, `username`,`updatedatetime`,`locationcode`)
			values('$mrdno','$patientcode','$patientfirstname','$patientmiddlename','$patientlastname','$patientfullname','$mrdstatus','$ipaddress','$username','$currentdate','$reslocationcode')";
			$exec67 =mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$query68 = "update master_ipvisitentry set mrdno = '$mrdno' where patientcode = '$patientcode' and mrdno = '' and locationcode='$reslocationcode' ";
    		$exec68 =mysqli_query($GLOBALS["___mysqli_ston"], $query68) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				}
		
   
		}
		
		
		$query44 = "select * from consultation_ipadmission where patientcode='$patientcode'"; 
		$exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num44 = mysqli_num_rows($exec44);
		if($num44>0)
		{
		$query11 = "update consultation_ipadmission set status='completed' where patientcode='$patientcode'"; 
		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		
	
		if($eclaimstatus==3){
		  
		 // @file_get_contents("$myBase/slade-claimvisit.php?frmtype=ip&visitcode=$visitcode");
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
		$scheme_id = '';
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
		
		$visit_ward='';
		?>
        <script>window.open('ip_docs_all.php?patientcode=<?php echo $patientcode; ?>&visitcode=<?php echo $visitcode;?>',"OriginalWindowA4",'width=800,height=800,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
		window.location='ipvisitentry_new.php';
		</script> 
		<?php
		//header("location:ipvisitentry_new.php");
		exit();
		//header ("location:addcompany1.php?st=success&&cpynum=1");
		
	}
	
	else
	{
		header ("location:ipvisitentry_new.php?patientcode=$patientcode&&st=failed");
		exit;
	}
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
	$smartap='';
	$account_active='';
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
	$location21code = $res["locationcode"];
		
$query3 = "select * from master_location where status = '' and locationcode='$location21code'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$visitcodeprefix = $res3['prefix'];
$loc_anum = $res3['auto_number'];
$visitcodeprefix1=strlen($visitcodeprefix);
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$ipvisitcodeprefix = $res3['ipvisitcodeprefix'];
$ipvisitcodeprefix=chop($ipvisitcodeprefix,"-");
$nhifrebate = $res3['nhifrebate'];
$ipadmissionfee = $res3['ipadmissionfees'];
$visitcodeprefix1=strlen($visitcodeprefix);
$query2 = "select * from master_ipvisitentry  order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
 $res2visitcode = $res2["visitcode"];
$res2visitnum=strlen($res2visitcode);
$vvcode6=str_split($res2visitcode);
$value6=arrayHasOnlyInts($vvcode6);
$visitcodepre6=$res2visitnum-$value6-'1';
if ($res2visitcode == '')
{
$visitcode =$ipvisitcodeprefix.'-'.'1'.'-'.$loc_anum;
$openingbalance = '0.00';
}else{
$res2visitcode = $res2["visitcode"];
$visitcode = substr($res2visitcode,$visitcodepre6,$res2visitnum);
$visitexplode = explode('-',$res2visitcode);
$visitcode = $visitexplode[1];
$visitcode = intval($visitcode);
$visitcode = $visitcode + 1;
$maxanum = $visitcode;
$visitcode = $ipvisitcodeprefix.'-' .$maxanum.'-'.$loc_anum;
$openingbalance = '0.00';
}
?>
<script>
function check_offpatient()
{
if(document.getElementById("offpatient").checked==true)
	{
		var smart_ap=document.getElementById("smart_ap").value;
		$("#offpatient").val(1);
		if(smart_ap==0 || smart_ap==2)
		{
		document.getElementById('submit').disabled="";
		}
		var overalllimit = document.getElementById("overalllimit").value;
		document.getElementById("availablelimit").value=overalllimit;
		var visitlimit = document.getElementById("visitlimit").value;
		if((parseFloat(overalllimit)<=0)&&(parseFloat(visitlimit)>0))
		{
		document.getElementById("availablelimit").value=visitlimit;    
		}
		
		return false;
	}
	else
	{
		$("#offpatient").val(0);
		document.getElementById('submit').disabled="True";
		document.getElementById("availablelimit").value='';
		return false;
	}
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
$patientcode=isset($_REQUEST["patientcode"])?$_REQUEST["patientcode"]:'';
//echo $patientcode;
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
	$patientspent=$res3['ipdue'];
	$memberno = $res3['memberno'];
	$paymenttype = $res3['paymenttype'];
	$query4 = "select * from master_paymenttype where auto_number = '$paymenttype'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$paymenttypeanum = $res4['auto_number'];
	$paymenttype = $res4['paymenttype'];
	
	$subtype = $res3['subtype'];
	
	
	$query790 = "select mrdno from master_ipvisitentry where locationcode='$location21code' and patientcode='$patientcode' order by auto_number desc limit 0,1";
	$exec790 =  mysqli_query($GLOBALS["___mysqli_ston"], $query790) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res790 = mysqli_fetch_array($exec790);
	$mrdno = $res790['mrdno'];
	
	
	
	$query4 = "select * from master_subtype where auto_number = '$subtype'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$subtypeanum = $res4['auto_number'];
	$subtype = $res4['subtype'];
	$billtype = $res3['billtype'];
	$age = $res3['age'];
	$gender = $res3['gender'];
	$ageduration = $res3['ageduration'];
	if($ageduration=='MONTHS')
		$age =1;
	
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
$scheme_id = $res3["scheme_id"];
	$query_sc = "select * from master_planname where scheme_id = '$scheme_id'";
	$exec_sc = mysqli_query($GLOBALS["___mysqli_ston"], $query_sc) or die ("Error in query_sc".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res_sc = mysqli_fetch_array($exec_sc);
	//$plannameanum = $res4['auto_number'];
	$accountname = $res_sc['scheme_name'];
	$accountexpirydate = $res_sc['scheme_expiry'];
	$account_active = $res_sc['scheme_active_status'];
	
	 $planname = $res3['planname'];
	$query4 = "select * from master_planname where auto_number = '$planname'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$plannameanum = $res4['auto_number'];
	$planname = $res4['planname'];
    $planstatus=$res4['recordstatus'];
	$planfixedamount = $res4['planfixedamount'];
	$planpercentageamount = $res4['planpercentage'];
	$smartap= $res4['smartap'];
	$planapplicable = $res4['planapplicable'];
		
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
	 $availablelimit=$overalllimit-$patientspent;
	if($visitlimit!=0)
	{
		$availablelimit=$visitlimit ;
		}
	}
	else
	{
	 $availablelimit=$overalllimit-$patientspent;
	if($visitlimit!=0)
	{
		$availablelimit=$visitlimit ;
		}
	}
	
	if($planapplicable=='1')
	{
		$query88 = "select sum(ipplandue) as overallplandue from master_customer where planname = '$plannameanum'";
		$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res88 = mysqli_fetch_array($exec88);
		$overallplandue = $res88['overallplandue'];
		$availablelimit = $overalllimit - $overallplandue;	
	}
	else
	{
		$overallplandue = 0;	
	}
	$availablelimit=$overalllimit;
}
if (isset($_REQUEST["opvisitcode"])) { $opvisitcode = $_REQUEST["opvisitcode"]; } else { $opvisitcode = ""; }
if($opvisitcode != '')
{
$query76 = "select username,notes from consultation_ipadmission where visitcode='$opvisitcode'";
$exec76 = mysqli_query($GLOBALS["___mysqli_ston"], $query76) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res76 = mysqli_fetch_array($exec76);
$admissiondoctor = $res76['username'];
$admissionnotes = $res76['notes'];
$master_emp_query = "select employeecode, DoctorType from master_employee where username='$admissiondoctor'";
$me_rslt = mysqli_query($GLOBALS["___mysqli_ston"], $master_emp_query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$me_rslt = mysqli_fetch_array($me_rslt);
$empcode = $me_rslt['employeecode'];
$admission_doc_type = $me_rslt['DoctorType'];
$master_emp_query1 = "select * from doctor_mapping where employeecode = '$empcode'";
$me_rslt1 = mysqli_query($GLOBALS["___mysqli_ston"], $master_emp_query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$me_rslt1 = mysqli_fetch_array($me_rslt1);
$admission_doc_name = $me_rslt1['employeename'];
$admission_doc_code = $me_rslt1['doctorcode'];
$admission_emp_code = $me_rslt1['employeecode'];
}
else
{
$admissiondoctor = '';
$admissionnotes = '';
$admission_doc_name ="";
$admission_doc_code ="";
$admission_emp_code ="";
$admission_doc_type ="";
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

$suffix =  date('y');
 
$query100 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec100 = mysqli_query($GLOBALS["___mysqli_ston"], $query100) or die ("Error in Query100".mysqli_error($GLOBALS["___mysqli_ston"]));
$res100 = mysqli_fetch_array($exec100);
$res100ocationanum = $res100["locationcode"];

$query3 = "select * from master_location where status = '' and locationcode='$res100ocationanum'"; 
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$loc_anum = $res3['auto_number'];

$query790 = "select filenumber from filenumber where filestatus = '1' and locationcode='$res100ocationanum' order by auto_number desc limit 0,1";
$exec790 =  mysqli_query($GLOBALS["___mysqli_ston"], $query790) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res790 = mysqli_fetch_array($exec790);
$filenumber = $res790['filenumber'];

if($filenumber == '') {
	$mrd_autono = '100'."-".$loc_anum."-".$suffix;
} else {
	$fileexplode = explode('-',$filenumber);
	$filenumber = $fileexplode[0];
	$mrd_autono1 = $filenumber + 1;
	$mrd_autono = $mrd_autono1."-".$loc_anum."-".$suffix;
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
<script src="js/autocustomersmartsearchip.js"></script>
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
	
	if(document.getElementById("visitlimit").value == "0.00" || document.getElementById("visitlimit").value == "" || document.getElementById("visitlimit").value == "0")
	{
	alert("Please Select The Ward.");
	document.form1.visitlimit.focus();
	return false;
	}
	
	if(document.getElementById("preauth_ref").value == "")
	{
	alert("Please Enter Pre Auth.");
	document.form1.preauth_ref.focus();
	return false;
	}
	
	if((document.getElementById('mrd0').checked == false) && (document.getElementById('mrd1').checked == false)){
	alert("Please Select File No Either New or Exist ");
	return false;	
	}
	
	
	if(document.getElementById("mrdno").value==''){
	alert("Enter IP FILE Number. It Can Be Existing or New");
	document.form1.mrdno.focus();
	return false;
	}
	
	
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
<?php 
	$date = mktime(0,0,0,date("m"),date("d"),date("Y")); 
	$currentdate = date("Y-m-d");
	?>
	//alert("hi");
	var currentdate = "<?php echo $currentdate; ?>";
	
var acount_expiry=document.getElementById("accountexpirydate").value;
//alert(currentdate);
//alert(acount_expiry);

	var d1 = new Date();
	var d2 = new Date(acount_expiry);
	var checkdate=d1.getTime();
	var accountdate=d2.getTime();
	
	if((document.getElementById("recordstatus").value != 'ACTIVE')||(accountdate < checkdate))
	{
	alert("Account has been suspended.Please Contact Accounts.");
		document.getElementById("accountnamename").focus();
			return false;
	}
	
	var planexpirydate=document.getElementById("planexpirydate").value;
	if((document.getElementById("planstatus").value != 'ACTIVE')||(accountdate < checkdate))
	{
	alert("Plan has been suspended.Please Contact Accounts.");
		document.getElementById("plannamename").focus();
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
	if (document.form1.opdoctorcode.value == "")
	{
		alert ("Please select Admitting Doctor from the List.");
		$("#admissiondoctor").focus().select();
		return false;
	}
	if (document.form1.consultingdoctor.value == "")
	{
		alert ("Please Select Treating Doctor from the List.");
		$("#consultingdoctorsearch").focus().select();
		return false;
	}	
		
	/* if (document.form1.consultationtype.value == "")
	{
		alert ("Please Select Consultation Type.");
		document.form1.consultationtype.focus();
		return false;
	} */
if (confirm("Do You Want To Save The Record?")==false){return false;}
	//Submit222.disabled = true; return true;
	
	
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
	document.getElementById("admissionfees_1").value=document.getElementById("admissionfees").value;
	document.getElementById("admissionfees").value=0;
	
	}
	if(document.getElementById("packapplicable").checked == false)
	{
	funcpackHideView();
	document.getElementById("admissionfees").value=document.getElementById("admissionfees_1").value;
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
	function clearCode(id){
		$("#"+id).val('');
	}
</script>
<link href="autocomplete.css" rel="stylesheet">
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/autocustomercodesearch21.js"></script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script type="text/javascript" src="js/visitentrypatientcodevalidation1.js"></script>
<script src="js/datetimepicker_css.js"></script>
<script>

function fileCheck(res,mrdno)
{	
	if(res == 1) {
		document.getElementById('mrdno').value = document.getElementById('mrd_autono').value;
		document.getElementById('mrdno').readOnly  = true;
		document.getElementById('mrd1').Checked = true;
		document.getElementById('mrdno').style.backgroundColor = '#CCC';
	} else {
		if(document.getElementById('ipfileno').value==''){
		document.getElementById('mrdno').value = document.getElementById('ipfileno').value;
		document.getElementById('mrd0').Checked = true;
		document.getElementById('mrdno').readOnly  = false;
		document.getElementById('mrdno').style.backgroundColor = '#FFF';
		}
		else{
		document.getElementById('mrdno').value = document.getElementById('ipfileno').value;
		document.getElementById('mrd0').Checked = true;
		document.getElementById('mrdno').readOnly  = true;
		document.getElementById('mrdno').style.backgroundColor = '#CCC';			
		}
	}
}

$(document).ready(function(e) {
		 if(document.getElementById('ipfileno').value!=''){
			document.getElementById('mrdno').value = document.getElementById('ipfileno').value;
			document.getElementById('mrdno').readOnly  = true;
			document.getElementById('mrd1').Checked = true;
			document.getElementById('mrdno').style.backgroundColor = '#CCC';    
			document.getElementById('mrd1').disabled=true;		
		
		}
		
		/*else{
		document.getElementById('mrdno').value = document.getElementById('mrd_autono').value;
		document.getElementById('mrdno').readOnly  = true;
		document.getElementById('mrd0').Checked = true;
		document.getElementById('mrdno').style.backgroundColor = '#CCC';
			document.getElementById('mrd1').disabled=false;		
			
		} */
});




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
		
	source:'ajaxipadmdoctorsearch.php?location='+$('#location').val(), 	
	//alert(source);
	minLength:3,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var code = ui.item.id;
			var value = ui.item.value;
			var ConsDoctorType = ui.item.DoctorType;
			$('#consultingdoctor').val(code);
			$('#consultingdoctorsearch').val(value);
			$('#consultingdoctorType').val(ConsDoctorType);
			}, 
			// open: function( event, ui ) {
			// $("#consultingdoctor").val('');
			// $("#consultingdoctorsearch").val('');
			// $("#consultingdoctorType").val('');
	  //       }
    });
	$('#admissiondoctor').autocomplete({
		
	source:'ajaxipadmdoctorsearch.php?location='+$('#location').val(), 
	//alert(source);
	minLength:3,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var code = ui.item.empcode;
			var value = ui.item.value;
			var doccode = ui.item.doccode;
			var ConsDoctorType = ui.item.DoctorType;
			$('#admissiondoctorCode').val(code);
			$('#opdoctorcode').val(doccode);
			$('#admissiondoctor').val(value);
			$('#admissiondoctorType').val(ConsDoctorType);
			},
	  //      open: function( event, ui ) {
			// $("#admissiondoctorCode").val('');
			// $("#opdoctorcode").val('');
			// $("#admissiondoctor").val('');
			// $("#admissiondoctorType").val('');
	  	//  }
    });	
	$('#packagename').autocomplete({
		
	source:'ajaxippackagesearch.php', 
	//alert(source);
	minLength:3,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var anum = ui.item.anum;
			var value = ui.item.value;
			$('#package').val(anum);
			funcpackageChange();
			},
    });
});
function funfetchsavannah(smartap)
{
  if(smartap==2)
  {
	$('#savannah_authflag').val("");	
	if(document.getElementById("packapplicable").checked == true){
		if(document.getElementById('packcharge').value == '')
		{
			alert("Please select package.");
			document.getElementById('packagename').focus();
			return false;
		}
		var admissionfee=document.getElementById('packcharge').value;
	}else
	{
		var admissionfee=document.getElementById('admissionfees').value;
	}
	if(document.getElementById('savannah_authid').value == '')
	{
		alert("Slade auth id. can not be empty.");
		document.getElementById('savannah_authid').focus();
		return false;
	}
	else
	{
	FuncPopup();
	memberno = document.getElementById('savannah_authid').value;
	first_name = document.getElementById('patientfirstname').value;
	last_name = document.getElementById('patientlastname').value;
	data = "auth_token="+memberno+"&first_name="+first_name+"&last_name="+last_name+"&type=ip";
	$.ajax({
	  type : "get",
	  url : "slade-check.php",
	  data : data,
	  cache : false,
	  timeout:30000,
	  success : function (data){
	   var jsondata = JSON.parse(data);
	   if(jsondata.length !=0 && jsondata['status'] == 'Success'){
	  if(jsondata['has_op'] == 'Y')
	  {
	  //alert("check savannah");
	   $('#visitlimit').val(jsondata['visit_limit']);
	   $('#savannahvalid_from').val(jsondata['valid_from']);
	   $('#savannahvalid_to').val(jsondata['valid_to']);
	   $('#slade_authentication_token').val(jsondata['slade_authentication_token']);
	   $('#memberno').val(jsondata['member_number']);
	   $('#savannah_authlb').removeClass("style1");
	   $('#savannah_authflag').val("");
		$('#savannah_authid').prop("readonly",true);
	   if(smartap==2)
	   {
		 $('#availablelimit').val(jsondata['visit_limit']);
		 alert("Slade Fetch Sucessful.");
	   }
		
	   if(parseFloat($('#availablelimit').val()) > 0.00 && parseFloat(jsondata['visit_limit']) >= parseFloat(admissionfee))
	   {
	   $('#submit').prop("disabled",false);
	   }
	   else{
         alert("Insufficient benefit balance.");
	   }
	  }
	else
	{
	alert('Member not covered for In-Patient');
	}
	   } 
		else{
	     alert(jsondata['error']);
		
	   } 
	   document.getElementById("imgloader").style.display = "none";
	  },error: function(x, t, m) {
         alert("Unable to connect slade server.");	
		 document.getElementById("imgloader").style.display = "none";
		 return false;
      }
		
	 });
	}
  } else if(smartap==3) {
	 if(document.getElementById("offpatient").checked==false)
	{
		if(document.getElementById('savannah_authid').value == '')
		{
			alert("Slade auth id. can not be empty.");
			document.getElementById('savannah_authid').focus();
			return false;
		}
	}
   FuncPopup();
 var memberno = document.getElementById('savannah_authid').value;
var customersearch=document.getElementById("patientcode").value;
var registrationdate=document.getElementById("registrationdate").value;
var data = "InOut_Type=2&customersearch="+customersearch+"&&registrationdate="+registrationdate;	
$.ajax({
  type : "get",
  url : "autocustomersmartsearch.php",
  data : data,
  cache : false,
  success : function (t){
  if(t!='')
	{
	//document.getElementById("price").innerHTML=t;
	var varCompleteStringReturned=t;
	//alert (varCompleteStringReturned);
	var varNewLineValue=varCompleteStringReturned.split("#");
	//alert(varNewLineValue);
	//alert(varNewLineValue.length);
	var varNewLineLength = varNewLineValue.length;
	//alert(varNewLineLength);
	
	var Benefitno = varNewLineValue[0];
	var BenefitAmt = varNewLineValue[1];
	var Admitid = varNewLineValue[2];
	
	var availablelimit = document.getElementById("availablelimit").value;
	//if(availablelimit == 0){
	document.getElementById("availablelimit").value = BenefitAmt;
	document.getElementById("smartbenefitno").value = Benefitno;
	document.getElementById("admitid").value = Admitid;
	//}
	if(Admitid=='' || Admitid==null || Admitid==0){
		alert('Admit id is not available, try to reforward and fetch.');
		document.getElementById("imgloader").style.display = "none";
		return false;
	}
	else{
		if(document.getElementById("offpatient").checked==false)
	  {
	  first_name = document.getElementById('patientfirstname').value;
	  last_name = document.getElementById('patientlastname').value;
	  data = "auth_token="+memberno+"&first_name="+first_name+"&last_name="+last_name+"&type=ip";
	  $.ajax({
	  type : "get",
	  url : "slade-check.php",
	  data : data,
	  cache : false,
	  timeout:30000,
	  success : function (data){
	   var jsondata = JSON.parse(data);
	   if(jsondata.length !=0 && jsondata['status'] == 'Success'){
	  if(jsondata['has_op'] == 'Y')
	  {
	   
	   $('#savannahvalid_from').val(jsondata['valid_from']);
	   $('#savannahvalid_to').val(jsondata['valid_to']);
	   $('#slade_authentication_token').val(jsondata['slade_authentication_token']);
	   $('#savannah_authlb').removeClass("style1");
	   $('#savannah_authflag').val("");
	   $('#savannah_authid').prop("readonly",true);
	    if(parseFloat($('#availablelimit').val()) > 0.00)
		{
		 $('#submit').prop("disabled",false);
		}
	   
	  }
	  else
	  {
	   alert('Member not covered for In-Patient');
	   }
	  } 
	  else if(jsondata['error']!='Insufficient benefit balance'){
	     alert(jsondata['error']);
		
	   }else{
        $('#submit').prop("disabled",false);
	   }  
	   document.getElementById("imgloader").style.display = "none";
	  },error: function(x, t, m) {
                 alert("Unable to connect slade server.");	
		 document.getElementById("imgloader").style.display = "none";
		 return false;
      }
		
});
	}
	 else
	  {
		 document.getElementById("imgloader").style.display = "none";
		 document.getElementById('submit').disabled="";
		 return false; 
	  }
	}
	
	
	}
	}
    
 });
}
}
function FuncPopup()
{
	window.scrollTo(0,0);
	document.getElementById("imgloader").style.display = "";
}
function validatenumerics(key) {
           //getting key code of pressed key
           var keycode = (key.which) ? key.which : key.keyCode;
           //comparing pressed keycodes
           if (keycode > 31 && (keycode < 48 || keycode > 57)) {
               //alert(" You can enter only characters 0 to 9 ");
               return false;
           }
           else return true;
 
       }
</script>
<style type="text/css">
.imgloader { background-color:#FFFFFF; }
#imgloader1 {
    position: absolute;
    top: 158px;
    left: 487px;
    width: 28%;
    height: 24%;
}
</style>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall()">
<div align="center" class="imgloader" id="imgloader" style="display:none;">
	<div align="center" class="imgloader" id="imgloader1" style="display:;">
	    <p style="text-align:center;" id='claim_msg'></p>
		<p style="text-align:center;"><strong>Processing <br><br> Please be patient...</strong></p>
		<img src="images/ajaxloader.gif">
	</div>
</div>
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
      	  <form name="form1" id="form1" method="post" action="ipvisitentry_new.php" onKeyDown="return disableEnterKey(event)" onSubmit="return process1()">
		  <input name="op_visit" id="op_visit" value="<?php echo $opvisitcode;?>" type="hidden">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860"><table width="1258" height="282" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="1"><strong>IP Visit Entry </strong></td>
                <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="5"><span style="color:red;font-size:14px"><b>PLEASE ENSURE IP FILE NUMBER IS PROPER. BEFORE SAVING JUST ENSURE</span></td>
                <td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td colspan="2" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
						
						$query1 = "select locationname, locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						
						$res1locationcode = $res1["locationcode"];
						?>
						
						
                  
                  </td>
                <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"></td>
              </tr>
              <tr bgcolor="#011E6A">
                
               
                 <td colspan="9" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Search Sequence : First Name | Middle Name | Last Name | Date of Birth | Location | Mobile Number | National ID | Registration No | Member No.  (*Use "|" symbol to skip sequence)</strong>
             
            
          
                
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
				  <input name="customer" id="customer" size="60" autocomplete="off" <?php  if($opvisitcode!='' ) echo 'readonly';?>>
				  	  <input name="customerhiddentextbox" id="customerhiddentextbox" value="" type="hidden">
				  <input name="customercode" id="customercode" value="" type="hidden">
				<input type="hidden" name="recordstatus" id="recordstatus" value="<?php echo $account_active;  ?>">
				  <input type="hidden" name="billnumbercode" id="billnumbercode" value="<?php echo $billnumbercode; ?>" readonly ></td>
				  <td colspan="2">
					 <span align="middle" id="edit"><?php if($patientcode!=''){ ?> <a href='editpatient_new.php?patientcode=<?php echo $patientcode; ?>&&ip=1'><input type='button' value='Edit Patient Details'/></a><?php } ?></span>
					</td>
				  </tr>
				
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Type</td>
				  <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5">
                  <select name="type" id="type" style="border: 1px solid #001E6A;">
                  <option value="">select</option>
                  <option value="hospital" selected >Hospital</option>
                  <option value="private">Private</option>
                  </select>
                  </td>
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
				 <td colspan="2" align="left" valign="middle" class="bodytext3">File No 
				  &nbsp;&nbsp;
				  <input type="radio" name="mrd" id="mrd1" value="1"  onChange="return fileCheck(this.value,'<?php echo $mrdno; ?>')"><label for="mrd1">New</label>&nbsp;
				  <input type="radio" name="mrd" id="mrd0" value="0" <?php if($mrdno!=''){ echo 'checked'; }?>  onChange="return fileCheck(this.value,'<?php echo $mrdno; ?>')"><label for="mrd0">Existing</label>
				
				  <input type="hidden" name="ipfileno" id="ipfileno" value="<?php echo $mrdno; ?>">
				  <input type="hidden" name="mrd_autono" id="mrd_autono" value="<?php echo $mrd_autono; ?>">
				  <input type="text" name="mrdno" id="mrdno" size="10" value="<?php echo $mrdno; ?>"  onChange="return checkfileno();" <?php if($mrdno != ''){ echo 'readonly'; } ?>>
				  
				  </td>
				  <td colspan="2" rowspan="6" align="center" valign="middle"  bgcolor="#ecf0f5">
				  <input type="hidden" name="photoavailable" id="photoavailable" value="<?php echo $photoavailable; ?>"><img width="150" height="150" id="patientimage" src="">
				  <br/> <input type="button" name="imgbtn" id="imgbtn" value="Show Image" onClick="return ShowImage('<?php echo $patientcode; ?>',this.value);"><br/>
				  <div id="fetchbtn" style="display:<?php if($smartap > 0 ){ echo ""; } else { echo "none"; } ?>">
				  <input id="fetch" name="fetch" type="button"  value="<?php if($smartap ==1 ){ echo "Smart"; } elseif($smartap ==2 ) { echo "Slade"; } elseif($smartap ==3 ) { echo "Smart+Slade"; } ?>" <?php if($smartap > 0 ){ echo ""; } else { echo "disabled"; } ?> class="button" id="fetch" <?php if($smartap == 1 ){ echo 'onClick="return funcCustomerSmartSearch()";'; } elseif($smartap==2 || $smartap==3) { echo 'onClick="return funfetchsavannah('.$smartap.')";'; } ?>  style="background-color:#FF9900;color:#FFFFFF; font-weight:bold; height:50px; width:100px; cursor:pointer;" /></div>
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
				  <input name="patientcode" id="patientcode" size="20" value="<?php echo $patientcode; ?>" readonly /></td>
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
				    <input type="hidden" name="accountname" id="accountname"  value="<?php echo $accountnameanum;?>"  readonly="readonly" >
				    <input type="hidden" name="scheme_id" id="scheme_id"  value="<?php echo $scheme_id;?>"  readonly="readonly" >
                    <input type="hidden" name="smart_ap" id="smart_ap"  value=""  readonly="readonly" >
					</td>
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
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" class="number" name="visitlimit" id="visitlimit"  value="<?php echo $visitlimit;?>" readOnly ></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label></label></td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Fixed Amount </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>
				  <input type="text" name="planfixedamount" id="planfixedamount"  value="<?php echo $planfixedamount;?>"   readonly="readonly">
				  </label></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Overall Limit </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="overalllimit" id="overalllimit"  value="<?php echo $overalllimit;?>"   readonly="readonly" ></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Pre Auth</span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">
				  
				  <input type="text" name="preauth_ref" id="preauth_ref"  value=""   >
				  
				  <input type="hidden" name="patientspent" id="patientspent"  value="<?php echo $patientspent;?>"   readonly="readonly">
				  
				  </td>
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
				  <input name="memberno" id="memberno" value="<?= $memberno ?>" size="20" readonly />
				    <input type="hidden" name="visitcount" id="visitcount"  value="<?php echo $visitcount;?>"   readonly="readonly">
				    <input name="visittype" id="visittype" value="" type="hidden">
				  </strong></td>
				  <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5"><label></label></td>
				</tr>
				
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><font color="red">Admitting Doctor</font></span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="admissiondoctor" id="admissiondoctor" value="<?php echo $admission_doc_name; ?>" onKeyUp="clearCode('opdoctorcode')">
				  <input type="hidden" name="opdoctorcode" id="opdoctorcode" value="<?php echo $admission_doc_code; ?>">
				  <input type="hidden" name="admissiondoctorCode" id="admissiondoctorCode" value="<?php echo $admission_emp_code; ?>">
				  <input type="hidden" name="admissiondoctorType" id="admissiondoctorType" value="<?php echo $admission_doc_type; ?>">
				  </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32"><font color="red">Treating Doctor</font></span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><strong>
				  <input type="hidden" name="consultingdoctor" id="consultingdoctor" value="">
				  <input type="text" name="consultingdoctorsearch" id="consultingdoctorsearch" onKeyUp="clearCode('consultingdoctor')"  value="">
                  <input name="consultingdoctorType" id="consultingdoctorType" value="" type='hidden'>
				  
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
					<!--<input type="hidden" name="department" id="department" value="<?php //echo $department; ?>" style="border: 1px solid #001E6A;"  size="20" />-->
				  <td colspan="" align="left" valign="middle"  bgcolor="#ecf0f5"> <span class="bodytext32">Ward</span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">
					<select id="visit_ward" name="visit_ward"  onclick="appendValue()">
					<option value="">Select Ward</option>
					<?php
					$query1 = "select * from master_ward where recordstatus = ''  and locationcode='$location21code' order by ward";
					$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($res1 = mysqli_fetch_array($exec1))
					{
					$res1ward= $res1["ward"];
					$res1wardnum= $res1["auto_number"];
					$deposit_amount= $res1["deposit_amount"];
					?>
					<option value="<?php echo $deposit_amount; ?>||<?php echo $res1wardnum; ?>" ><?php echo $res1ward; ?></option>
					<?php
					}
					?>
					</select>
					</td>
				</tr>
                <?php if(isset($admission_doc_type) && $admission_doc_type!='' && $admission_doc_type==0) { ?>
				<tr><td><span class="bodytext32">Doctor Type</span></td><td><input name="admission_doc_type" id="admission_doc_type" value="MO" readonly size="8" /></td><td colspan='4'></td></tr>
                <?php } elseif(isset($admission_doc_type) && $admission_doc_type!='' && $admission_doc_type==1) { ?>
				<tr><td><span class="bodytext32">Doctor Type</span></td><td><input name="admission_doc_type" id="admission_doc_type" value="CO" readonly size="8" /></td><td colspan='4'></td></tr>
                <?php }
				?>
				<tr>
                <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Consultation Date </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="consultationdate" id="consultationdate" value="<?php echo $consultationdate; ?>" readonly ></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32"> Consultation Time </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="consultationtime" id="consultationtime" value="<?php echo $consultationtime; ?>" readonly size="8" />
                  <span class="bodytext32">(Ex: HH:MM)</span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Admission Fees </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="admissionfees" id="admissionfees" onFocus="return funcVisitEntryPatientCodeValidation1()" size="20" value="<?php echo $admissionfees; ?>"/>
				<input name="admissionfees_1" id="admissionfees_1" type='hidden' value=''>
				</td>
                <td colspan="" align="left" valign="middle"  bgcolor="#ecf0f5"> <span class="bodytext32">OFFSLADE</span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5">
					<input type="checkbox" id="offpatient" name="offpatient" value="0" onClick="check_offpatient()"/>
					</td>
				</tr>
				 			 
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> Package Applicable</span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="packapplicable" id="packapplicable" onClick="return funcpackcheck();" value="1"></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" >Plan Used</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="plandue" id="plandue" readonly value="<?php echo $overallplandue; ?>"></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span id="savannah_authlb" class="bodytext32">Slade Authentication No</span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="savannah_authid" id="savannah_authid" value="" size="20"  /><input name="savannah_authflag" id="savannah_authflag" value="" size="20" type="hidden" /></td>
				   <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				 </tr>
				 <tr id="pack">
				 	   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> Package </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" id="pack"><input type="text" name="packagename" id="packagename" size="30" autocomplete="off">
                   <input type="hidden" name="package" id="package" value="">
                   </td>
				   
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
				   
				    <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Smart Benefit No </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="smartbenefitno" id="smartbenefitno" value="" size="20"  readonly/></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><label onClick="return enabtriage();">Admit ID </label></span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="admitid" id="admitid" value="" size="20" readonly/></td>
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
				 
<input name="savannahvalid_from" id="savannahvalid_from" value="" type="hidden" />
				<input name="savannahvalid_to" id="savannahvalid_to" value="" type="hidden" />
				<input name="slade_authentication_token" id="slade_authentication_token" value="" type="hidden" />
                 <tr>
                <td colspan="8" align="middle"  bgcolor="#ecf0f5" style="padding-right:200px;"><div align="right"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input type="hidden" name="frmflag1" value="frmflag1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                  <input name="Submit222" type="submit"  value="Save Visit Entry (Alt+S)" accesskey="s" onClick="return expirydatewarning()" class="button" id="submit" <?php if($smartap > 0) echo "disabled"; ?>/> <span align="middle" id="edit"> </span>
                </font></font></font></font></font></div></td>
              </tr>
             <!--<tr>
                  <td colspan="2"> <b><span style="font-size:18px">Note For Slade:</span></b></td>
                  <td colspan="8">
                      <span style="color:red;font-size:18px"><b>
                        &nbsp;&nbsp;&nbsp;Please Ensure <br/>
                        - First Name and Last Should Match as in Slade Portal.<br/>
                        - Member Number Should be exact.<br/> 
                        - Slade Authentication Number should be proper.<br/>
                        </b>
                    </span>
                </td>
            </tr>-->
            
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
<script>
$('input.number').keyup(function(event) {
  // skip for arrow keys
  if(event.which >= 37 && event.which <= 40) return;
  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    ;
  });
});	

function checkfileno(){
	var fileno = document.getElementById("mrdno").value;
	var location = document.getElementById("location").value;
	var dataString = "fileno="+fileno+"&&location="+location;
	$.ajax({
		url: "ajaxcheckfileno.php",
		method: "post",
		data: dataString,
		success: function(data){
			
			var dataSplit = data;
		
			if(dataSplit>0){
				
				alert('FIle No Already Exists');
				document.getElementById("mrdno").value='';
			} 
			
		}
	});	
}

function appendValue() {
  var selectBox = document.getElementById("visit_ward");
  var selectedValue = selectBox.options[selectBox.selectedIndex].value;
  
  // Check if the selected value is not empty
  if (selectedValue.trim() !== "") {
  var selectedValue = selectBox.options[selectBox.selectedIndex].value;
  var parts = selectedValue.split("||");
  var firstPart = parts[0];
  var secondPart = parts[1];
  document.getElementById("visitlimit").value = firstPart.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
  }
  else{
	document.getElementById("visitlimit").value =0;  
  }
}
</script>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
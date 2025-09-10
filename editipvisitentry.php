<?php 
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");
if (isset($_REQUEST["menuid"])) { $menuid = $_REQUEST["menuid"]; } else { $menuid = ""; }
if (isset($_REQUEST["populate"])) { $populate = $_REQUEST["populate"]; } else { $populate = "6"; }
$check_checkbox='';
$location='';
$errmsg = "";
$bgcolorcode = "";
$pagename = "";
$consultationfees1 = '';
$availablelimit = '';
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$docno = $_SESSION['docno'];
$username = $_SESSION['username'];
$currentdate = date('Y-m-d H:i:s');
$overallplandue = 0;
$query1 = "select locationname, locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$res1location = $res1["locationname"];
$res1locationcode = $res1["locationcode"];
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_customer1.php");
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
$ipaddress = $_SERVER["REMOTE_ADDR"];
$username = $_SESSION['username'];
	$patientcode=$_REQUEST["patientcode"];
	$visitcode = $_REQUEST["visitcode"];
	
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
    if(isset($consultingdoctorcode1) && $consultingdoctorcode1!='')
          $consultingdoctortype = 1;
	else
		$consultingdoctortype =0;
	$department = $_REQUEST["department"];
		$billnumbercode=$_REQUEST['billnumbercode'];
	$reslocation = $_REQUEST["location"];
		$type=$_REQUEST['type'];
		
			$selectedlocationcode=$_REQUEST["location"];
	
	$query31 = "select * from master_location where locationcode = '$reslocation' and status = '' " ;
	$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res31 =(mysqli_fetch_array($exec31));
	$selectedlocation = $res31["locationname"];
	
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
	
	$query87="select * from master_accountname where auto_number='$accountname'";
	$exec87=mysqli_query($GLOBALS["___mysqli_ston"], $query87);
	$res87=mysqli_fetch_array($exec87);
	//$accname=$res87['accountname'];
	$accname = $_REQUEST["accountnamename"];
	$accountexpirydate = $_REQUEST["accountexpirydate"];
	$planname = $_REQUEST["planname"];
	$planexpirydate = $_REQUEST["planexpirydate"];
	$consultationdate = $_REQUEST["consultationdate"];
	$consultationtime  = $_REQUEST["consultationtime"];
	$consultationtype = $_REQUEST["consultationtype"];
	$admissionfees  = $_REQUEST["admissionfees"];
	$referredby = $_REQUEST["referredby"];
	$consultationremarks = $_REQUEST["consultationremarks"];
	$complaint = $_REQUEST["complaint"];
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
	$mrdno = $_REQUEST['mrdno'];
	
	$query4 = "select * from master_planname where auto_number = '$planname'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);

	$eclaimstatus = $res4['smartap'];
	
	$visit_ward = $_REQUEST['visit_ward'];
	$packapp = isset($_POST['packapplicable'])?$_POST['packapplicable']:'';
	$opadmissiondoctor = $_REQUEST['admissiondoctor'];
	$opadmissiondoctorCode = $_REQUEST['admissiondoctorCode'];
	$querydoc1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_doctor where auto_number='$opadmissiondoctorCode'");
	$execdoc1=mysqli_fetch_array($querydoc1);
	$opadmissiondoctor1=$execdoc1['doctorname'];
	$opadmissiondoctorCode1=$execdoc1['doctorcode'];
	if($opadmissiondoctor1!='')
		$opadmissiondoctor=$opadmissiondoctor1;
	if($opadmissiondoctorCode1!='')
		$opadmissiondoctorCode=$opadmissiondoctorCode1;
	
	
$slade_authentication_token = addslashes($_REQUEST['slade_authentication_token']);
	$savannah_authid = $_REQUEST['savannah_authid'];
	$savannahvalid_from = $_REQUEST['savannahvalid_from'];
	$savannahvalid_to = $_REQUEST['savannahvalid_to'];
	$ack = $packapp;
	if($ack == '1')
	{
	$package = $_REQUEST['package'];
	$packagename = $_REQUEST['packagename'];
	$packcharge = $_REQUEST['packcharge'];
	$packchargeapply = $packapp;
	
	
	//code for if package change
	if($package !='' && $patientcode !='' && $visitcode !='' && $packagename!='')
	{

		
		//code for if package change
		$delq=mysqli_query($GLOBALS["___mysqli_ston"], "delete from package_processing where package_id != '$package' and  visitcode='$visitcode' and recordstatus='' ");
		//end here	

	//code for if package change
			$uppkg=mysqli_query($GLOBALS["___mysqli_ston"], "update package_processing set package_id='$package' where package_id != '$package' and  visitcode='$visitcode' and recordstatus!='' ");
			//end

	


	}
	//end

	
	
	}
	else
	{
	$package = '';
	$packcharge = '';
	$packchargeapply = $packapp;
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
	$smartbenefitno = $_REQUEST["smartbenefitno"];
	$admitid = $_REQUEST["admitid"];
	$scheme_id = $_REQUEST["scheme_id"];
	
		$query1 = "update master_ipvisitentry set eclaim_id='$eclaimstatus',scheme_id='$scheme_id',locationname='$selectedlocation',locationcode='$reslocation',type='$type', patientcode='$patientcode', visitcode='$visitcode', patientfirstname='$patientfirstname',patientmiddlename='$patientmiddlename', patientlastname='$patientlastname',patientfullname='$patientfullname', consultingdoctor='$consultingdoctor',
		department='$department',paymenttype='$paymenttype',subtype='$subtype',billtype='$billtype',accountname='$accountname',accountexpirydate='$accountexpirydate',planname='$planname',planexpirydate='$planexpirydate',consultationdate='$consultationdate',consultationtime='$consultationtime',consultationtype='$consultationtype',admissionfees='$admissionfees',referredby='$referredby',consultationremarks='$consultationremarks',complaint='$complaint',registrationdate='$registrationdate',visittype='$visittype',visitlimit='$visitlimit',overalllimit='$overalllimit',visitcount='$visitcount',patientspent='$patientspent',planpercentage='$planpercentageamount',planfixedamount='$planfixedamount',age='$age',gender='$gender',accountfullname='$accname',itemrefund='torefund',package='$package',packagecharge='$packcharge',nhifid='$nhifid',nhifissuedate='$issuedate',nhifvaliddate='$validtill',nhifrebate='$nhifrebate',deposit='$deposit',packchargeapply='$packchargeapply',username='$username',ipplandue='$ipplandue',admitid = '$admitid' ,smartbenefitno = '$smartbenefitno', consultingdoctorName ='$consultingdoctor1', consultingdoctorCode ='$consultingdoctorcode1',opadmissiondoctor='$opadmissiondoctor',opadmissiondoctorCode='$opadmissiondoctorCode',savannah_authid='$savannah_authid',slade_payload='$slade_authentication_token',savannahvalid_from='$savannahvalid_from',savannahvalid_to='$savannahvalid_to',visit_ward='$visit_ward',preauth_ref='$preauth_ref',mrdno='$mrdno' where patientcode='$patientcode' and visitcode='$visitcode'";
		
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query661 = "select filenumber from filenumber where filenumber = '$mrdno' and locationcode='$reslocation'";
		$exec661 = mysqli_query($GLOBALS["___mysqli_ston"], $query661) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num661 = mysqli_num_rows($exec661);
		if($num661 == 0)
		{
			
			$query790 = "select filenumber from filenumber where patientcode = '$patientcode' ";
			$exec790 = mysqli_query($GLOBALS["___mysqli_ston"], $query790) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res790 = mysqli_fetch_array($exec790);
			$num790 = mysqli_num_rows($exec790);	
			if($num790<=0){
			$query67 = "insert into filenumber (`filenumber`, `patientcode`, `patientfirstname`, `patientmiddlename`, `patientlastname`, `patientname`, `filestatus`, `ipaddress`, `username`,`updatedatetime`)
			values('$mrdno','$patientcode','$patientfirstname','$patientmiddlename','$patientlastname','$patientfullname','0','$ipaddress','$username','$currentdate')";
			$exec67 =mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			
		}
		
		
		
	   //, doctorType  ='$consultingdoctortype'
		
		/*if($package != '')
		{
			$query_p = "select * from master_ippackage where auto_number = '$package'";
			$exec_p = mysql_query($query_p) or die ("Error in Query_p".mysql_error());
			$res_p = mysql_fetch_array($exec_p);
			$servicescode = $res_p['servicescode'];
			
			$wellnesspkg='';
			$paynowbillprefix = 'TP-';
			$paynowbillprefix1=strlen($paynowbillprefix);
			$query2 = "select * from iptest_procedures order by auto_number desc limit 0, 1";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			$res2 = mysql_fetch_array($exec2);
			$billnumber = $res2["docno"];
			$billdigit=strlen($billnumber);
			if ($billnumber == '')
			{
				$billnumbercode ='TP-'.'1';
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
				
				
				$billnumbercode = 'TP-' .$maxanum;
				$openingbalance = '0.00';
				//echo $companycode;
			}
			$query13s = "select sertemplate from master_subtype where auto_number = '$subtype' order by subtype";
			$exec13s = mysql_query($query13s) or die ("Error in Query13s".mysql_error());
			$res13s = mysql_fetch_array($exec13s);
			$tablenames = $res13s['sertemplate'];
			if($tablenames == '')
			{
			  $tablenames = 'master_services';
			}
			
			$stringbuild1 = "";
			$query1 = "select itemcode, itemname, ledgerid, ledgername, rateperunit from $tablenames where status = '' AND itemcode='".$servicescode."'";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$execservice=mysql_fetch_array($exec1);
			$servicescode=$execservice['itemcode'];
			$servicesname=$execservice['itemname'];
			$ledgername=$execservice['ledgername'];
			$ledgercode=$execservice['ledgerid'];
			$serdoct='';
			$serdoctcode='';
			$servicesrate=$execservice['rateperunit'];
			$servicesfree = 'Yes';
			$quantityser=1;
			$seramount=$servicesrate;
			
			$qrycheckhc = "select wellnesspkg,itemname from master_services where itemcode like '$servicescode' and status <> 'deleted'";
	$execcheckhc = mysql_query($qrycheckhc) or die("Error in Qrycheckhc ".mysql_error());
	$rescheckhc = mysql_fetch_array($execcheckhc);
	$wellnesspkg=$rescheckhc['wellnesspkg'];
	
			$query770 = "select patientvisitcode from ipconsultation_services where patientvisitcode = '$visitcode' and servicesitemcode = '$servicescode' and  freestatus = 'Yes'";
			$exec770 = mysql_query($query770) or die ("Error in Query770".mysql_error());
			$row770 = mysql_fetch_array($exec770);
			if($row770 == 0 && $servicescode != '')
			{
	
			$servicesquery1=mysql_query("insert into ipconsultation_services(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,consultationdate,paymentstatus,process,iptestdocno,accountname,billtype,consultationtime,freestatus,locationcode,serviceqty,amount,incomeledgercode,incomeledgername,username,doctorcode,doctorname,wellnesspkg)values('$patientcode','$patientfullname','$visitcode','$servicescode','$servicesname','$servicesrate','$consultationdate','paid','pending','$billnumbercode','$accname','$billtype','$consultationtime','$servicesfree','$reslocation','".$quantityser."','".$seramount."','$ledgercode','$ledgername','$username','$serdoctcode','$serdoct','$wellnesspkg')") or die(mysql_error());
			}
			
		}
*/
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
		$packapp='';
		
		header("location:searchipvisit.php");
		exit();
		//header ("location:addcompany1.php?st=success&&cpynum=1");
		
	
	
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
	$admitid='';
	$smartbenefitno='';
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
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$visitcodeprefix = $res3['ipvisitcodeprefix'];
$nhifrebate = $res3['nhifrebate'];
$nhifrebaterate = $res3['nhifrebate'];
//$ipadmissionfee = $res3['ipadmissionfees'];
$visitcodeprefix1=strlen($visitcodeprefix);
$query2 = "select * from master_ipvisitentry order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$res2visitcode = $res2["visitcode"];
$res2visitnum=strlen($res2visitcode);
 $vvcode6=str_split($res2visitcode);
				  $value6=arrayHasOnlyInts($vvcode6);
				  $visitcodepre6=$res2visitnum-$value6;
if ($res2visitcode == '')
{
	$visitcode =$visitcodeprefix.'1';
	$openingbalance = '0.00';
}
else
{
	$res2visitcode = $res2["visitcode"];
	$visitcode = substr($res2visitcode,$visitcodepre6,$res2visitnum);
	$visitcode = intval($visitcode);
	
	$visitcode = $visitcode + 1;
	$maxanum = $visitcode;
	
	
	$visitcode = $visitcodeprefix .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
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
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
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
	
	
	
	
	$query56="select * from master_ipvisitentry where patientcode = '$patientcode' and visitcode = '$visitcode'";
	$exec56=mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    $num56 = mysqli_num_rows($exec56);
	$res56=mysqli_fetch_array($exec56);
	$nhifid = $res56['nhifid'];
	$mrdno = $res56['mrdno'];
	$nhifissuedate = $res56['nhifissuedate'];
	$nhifvaliddate = $res56['nhifvaliddate'];
	$nhifrebateip = $res56['nhifrebate'];
	$reslocationname = $res56['locationname'];
	$reslocationcode = $res56['locationcode'];
	$restype = $res56['type'];
	if($nhifid != '')
	{
	$nhifanum = 'yes';
	$nhifname = 'YES';
	}
	$opadmissiondoctor = $res56['opadmissiondoctor'];
	$admission_doc_code=$res56['opadmissiondoctorCode'];
	$admissionnotes = $res56['admissionnotes'];
	$packapplicablecheck = $res56['package'];
	$packageanum = $res56['package'];
	$packagenum3 = $res56['package'];
	$ipadmissionfee = $res56['admissionfees'];
	$admitid = $res56['admitid'];
	$smartbenefitno = $res56['smartbenefitno'];
	$savannah_authid = $res56['savannah_authid'];
	$offpatient = $res56['offpatient'];
	$visit_ward = $res56['visit_ward'];
	
	$query666 = "select * from master_ippackage where auto_number='$packageanum' and status=''";
	$exec666 = mysqli_query($GLOBALS["___mysqli_ston"], $query666) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res666 = mysqli_fetch_array($exec666);
	$res1packagename = $res666['packagename'];
				
	$adminfeeapply = $res56['packchargeapply'];
	$packagecharge = $res56['packagecharge'];
	$departmentanum = $res56['department'];
	$visitlimit = $res56['visitlimit'];	
	$overalllimit = $res56['overalllimit'];
	$planfixedamount = $res56['planfixedamount'];
	$planpercentageamount = $res56['planpercentage'];
	$visitcount = $res56['visitcount'];
	$consultationdate = $res56['consultationdate'];
	$consultationtime = $res56['consultationtime'];
	$age = $res56['age'];
	$gender = $res56['gender']; 
	$referredby = $res56['referredby'];
	$patientspent = $res56['patientspent'];
	
	$preauth_ref = $res56['preauth_ref'];
	$paymenttype = $res56['paymenttype'];
	$query4 = "select * from master_paymenttype where auto_number = '$paymenttype'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$paymenttypeanum = $res4['auto_number'];
	$paymenttype = $res4['paymenttype'];
	
	$subtype = $res56['subtype'];
	$query4 = "select * from master_subtype where auto_number = '$subtype'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$subtypeanum = $res4['auto_number'];
	$subtype = $res4['subtype'];
	
	$get_subtype = $res4['subtype'];
	$billtype = $res56['billtype'];
	$accountname = $res56['accountname'];
	
	$exclude_location_main = $res4['exclude_location'];
	
	 $traits = explode( ',' , $exclude_location_main );
	foreach($traits as $val)
	{
	
	if($reslocationcode==$val)
	{
		$check_checkbox='Excluded';
		
	}
	} 
	$query4 = "select * from master_accountname where auto_number = '$accountname'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$accountnameanum = $res4['auto_number'];
$scheme_id = $res56["scheme_id"];
	$query_sc = "select * from master_planname where scheme_id = '$scheme_id'";
	$exec_sc = mysqli_query($GLOBALS["___mysqli_ston"], $query_sc) or die ("Error in query_sc".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res_sc = mysqli_fetch_array($exec_sc);
	//$plannameanum = $res4['auto_number'];
	$accountname = $res_sc['scheme_name'];
	$accountexpirydate = $res_sc['scheme_expiry'];
	$account_active = $res_sc['scheme_active_status'];
	
	 $planname = $res56['planname'];
	 $query4 = "select * from master_planname where auto_number = '$planname'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$plannameanum = $res4['auto_number'];
	$planname = $res4['planname'];
	$smartap = $res4['smartap'];
	$planapplicable = $res4['planapplicable'];
	
	$planexpirydate = $res56['planexpirydate'];
	$registrationdate = $res56['registrationdate'];
	
	$query66="select * from master_department where auto_number='$departmentanum'";
	$exec66=mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res66=mysqli_fetch_array($exec66);
	$department=$res66['department'];
	
	$consultingdoctoranum = $res56['consultingdoctor'];
	
	$query67="select * from master_doctor where auto_number='$consultingdoctoranum'";
	$exec67=mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res67=mysqli_fetch_array($exec67);
	$doctor=$res67['doctorname'];
	
	$consultingtypeanum = $res56['consultationtype'];
	
	$query68="select * from master_consultationtype where auto_number='$consultingtypeanum'";
	$exec68=mysqli_query($GLOBALS["___mysqli_ston"], $query68) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res68=mysqli_fetch_array($exec68);
	$consultingtype=$res68['consultationtype'];
	$consultationfees=$res68['consultationfees'];
	
	if($visitcount == 1)
	{
	$availablelimit=$overalllimit ;
	}
	else
	{
	$availablelimit=$overalllimit-$planfixedamount;
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
	
}
if (isset($_REQUEST["errorcode"])) { $errorcode = $_REQUEST["errorcode"]; } else { $errorcode = ""; }
//$patientcode = 'MSS00000009';
if ($errorcode == 'errorcode1failed')
{
	$errmsg = 'Patient Already Visited Today. Cannot Proceed With Visit Entry. Save Not Completed.';	
}

$suffix =  date('y');
 
$query100 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec100 = mysqli_query($GLOBALS["___mysqli_ston"], $query100) or die ("Error in Query100".mysqli_error($GLOBALS["___mysqli_ston"]));
$res100 = mysqli_fetch_array($exec100);
$res100ocationanum = $res100["locationcode"];

$query3 = "select * from master_location where status = '' and locationcode='$res100ocationanum'"; 
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$loc_anum = $res3['auto_number'];


$query3 = "select * from master_location where status = '' and locationcode='$res100ocationanum'"; 
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$loc_anum = $res3['auto_number'];

$query31 = "select * from package_processing where visitcode='$visitcode' and recordstatus<>''"; 
$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
$numpkg=mysqli_num_rows($exec31);

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
<script language="javascript">
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


function checksubtype()
{
var check_exc=$("#check_checkbox").val();
var get_subtype=$("#get_subtype").val();
check_exc = check_exc.trim();
	if(check_exc!='')
	{
	alert(get_subtype+" is not applicable for this Location");
	document.getElementById("submit").disabled = true;
	return false;	
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
<script type="text/javascript" src="js/autocustomercodesearch2.js"></script>
<script language="javascript">
function process1()
{
	
	if(document.getElementById("preauth_ref").value == "")
	{
	alert("Please Enter Pre Auth.");
	document.form1.preauth_ref.focus();
	return false;
	}
	
	if (document.form1.package_consumed.value != "0" &&  document.form1.packagename.value == ""  )
	{
		alert ("Patient Must Have Package as Previous Package is Processed");
		return false;
	} else if (document.getElementById("packapplicable").checked == false && document.form1.package_consumed.value != "0" &&  (document.form1.packagename.value == "" ||document.form1.packagename.value != "" )){
		alert ("Patient Must Have Package as Previous Package is Processed");
		return false;
	}

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
	if (document.getElementById("consultingdoctor").value == "")
	{
		alert ("Please Select Treating Doctor.");
		document.getElementById("consultingdoctorsearch").focus();
		return false;
	}
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
		//alert(html);
	}
	});
}
function funcOnLoadBodyFunctionCall()
{ 
	//alert ("Inside Body On Load Fucntion.");
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	//funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
	funcpackHideView();
	funcnhifHideView();
	funcpackapplicablecheck();
	funcnhifapplicablecheck();
	var populate=<?php echo $populate; ?>;
	if(populate==1)
	{
		//alert('ok');
		funcCustomerSearch2();
	}
}
function funcpackapplicablecheck()
{
if(document.getElementById("packapplicablecheck").value != 0)
{
document.getElementById("packapplicable").checked = true;
funcpackcheck();
if(document.getElementById("adminfeeapply").value != 0)
{
document.getElementById("packchargeapply").checked = true;
}
}
}
function funcnhifapplicablecheck()
{
if(document.getElementById("nhifid").value != '')
{
funcnhifcheck();
}
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
</script>
<link href="autocomplete.css" rel="stylesheet">
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<?php //include ("js/dropdownlist1newscripting1.php"); ?>
<!--<script type="text/javascript" src="js/autosuggestnew1.js"></script> <!-- For searching customer -->
<!--<script type="text/javascript" src="js/autocomplete_newcustomer.js"></script> -->
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />   
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script type="text/javascript" src="js/visitentrypatientcodevalidation1.js"></script>
<script src="js/autocustomersmartsearchip.js"></script>
<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript">
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
			var ConsDoctorType = ui.item.DoctorType;
			$('#consultingdoctor').val(code);
			$('#consultingdoctorsearch').val(value);
			$('#consultingdoctorType').val(ConsDoctorType);
			},
			open: function( event, ui ) {
			$("#consultingdoctor").val('');
			$("#consultingdoctorsearch").val('');
			$("#consultingdoctorType").val('');
	        }
    });
	$('#admissiondoctor').autocomplete({
		
	source:'ajaxipadmdoctorsearch.php', 
	//alert(source);
	minLength:3,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var code = ui.item.id;
			var value = ui.item.value;
			var ConsDoctorType = ui.item.DoctorType;
			$('#admissiondoctorCode').val(code);
			$('#admissiondoctor').val(value);
			$('#admissiondoctorType').val(ConsDoctorType);
			},
	       open: function( event, ui ) {
			$("#admissiondoctorCode").val('');
			$("#admissiondoctor").val('');
			$("#admissiondoctorType").val('');
			
	   }
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
	   $('#savannah_authlb').removeClass("style1");	   
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
  }else if(smartap==3) {
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
      	  <form name="form1" id="form1" method="post" action="editipvisitentry.php" onKeyDown="return disableEnterKey(event)" onSubmit="return process1()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860"><table width="1258" height="282" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
			
              <tr bgcolor="#011E6A">
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="2"><strong>Edit IP Visit Entry </strong></td>
                <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                <td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"></td>
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
				  <td style="display:none" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Patient Search </td>
				  <td style="display:none" colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5">
				  <input name="customer" id="customer" size="60" autocomplete="off" type="hidden">
				  	  <input name="customerhiddentextbox" id="customerhiddentextbox" value="" type="hidden">
				  <input name="customercode" id="customercode" value="" type="hidden">
				<input type="hidden" name="recordstatus" id="recordstatus">
				  <input type="hidden" name="billnumbercode" id="billnumbercode" value="<?php echo $billnumbercode; ?>" readonly ></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Location</td>
				  <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5">
                  <select name="location" id="location" onChange="return funclocationChange1();"  style="border: 1px solid #001E6A;">
						<option value="<?php echo $reslocationcode; ?>"><?php echo $reslocationname; ?></option>
                  </select>
                  </td>
					<td>
						<?php if($patientcode!=''){ ?> <a href='editpatient_new.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&ip_edit=1'><input type='button' value='Edit Patient Details'/></a><?php } ?>
				<!--<input type ="button" id = "populatepatientdetails" name = "populatepatientdetails" onclick = "populatepatient('<?php echo $patientregno ?>')" value = "Edit Patient Details">-->
					</td>
				  </tr>
				
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Type</td>
				  <td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5">
                  <select name="type" id="type" style="border: 1px solid #001E6A;">
                  <option value="<?php echo $restype;?>"><?php echo ucfirst($restype);?></option>
                  <option value="hospital">Hospital</option>
                  <option value="private">Private</option>
                  </select>
                  </td>
				 <td colspan="3" align="left" valign="middle" class="bodytext3">File No 
				  &nbsp;&nbsp;
				 
				  <input type="text" name="mrdno" id="mrdno" size="11" value="<?php echo $mrdno; ?>"  <?php if($mrdno != ''){ echo 'readonly'; } else{  ?> onChange="return checkfileno();"  <?php }  ?>>
				  
				  
				  </td>
				  <td width="15%" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				  <td colspan="2" rowspan="6" align="center" valign="middle"  bgcolor="#ecf0f5">
				  <img width="150" height="150" src="patientphoto/<?php echo $patientcode; ?>.jpg" id="img">
				  <div id="fetchbtn" style="display:<?php if($smartap > 0 ){ echo ""; } else { echo "none"; } ?>">
				  <input name="fetch" type="button"  value="<?php if($smartap ==1 ){ echo "Smart"; } elseif($smartap ==2 ) { echo "Slade"; } elseif($smartap ==3 ) { echo "Smart+Slade"; } ?>" <?php if($smartap > 0 ){ echo ""; } else { echo "disabled"; } ?> class="button" id="fetch" <?php if($smartap == 1 ){ echo 'onClick="return funcCustomerSmartSearch()";'; } elseif($smartap==2 || $smartap==3) { echo 'onClick="return funfetchsavannah('.$smartap.')";'; } ?>  style="background-color:#FF9900;color:#FFFFFF; font-weight:bold; height:50px; width:100px; cursor:pointer;" /></div>
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
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="age" id="age" value="<?php echo $age; ?>" readonly ></td>
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
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Account</span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="accountnamename" id="accountnamename"  value="<?php echo $accountname;?>"  readonly="readonly" size="50">
				    <input type="hidden" name="accountname" id="accountname"  value="<?php echo $accountnameanum;?>"  readonly="readonly"></td>
				    <input type="hidden" name="scheme_id" id="scheme_id"  value="<?php echo $scheme_id;?>"  readonly="readonly"></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				</tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Sub Type </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>
                    <input type="text" name="subtypename" id="subtypename"  value="<?php echo $subtype;?>"  readonly="readonly" >
				    <input type="hidden" name="subtype" id="subtype"  value="<?php echo $subtypeanum;?>"  readonly="readonly">
				  </label></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Bill Type </span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="billtype" id="billtype"  value="<?php echo $billtype;?>"  readonly="readonly"></td>
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
                    <input type="hidden" name="photoavailable" id="photoavailable">
                  </label></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Plan Expiry </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="planexpirydate" id="planexpirydate"  value="<?php echo $planexpirydate;?>"   readonly="readonly" ></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Visit Limit</span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" class="number" name="visitlimit" id="visitlimit"  value="<?php echo number_format($visitlimit);?>"   readonly="readonly"></td>
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
				  <td align="left" valign="middle"  bgcolor="#ecf0f5">
				  
				  <input type="text" name="preauth_ref" id="preauth_ref"  value="<?php echo $preauth_ref;?>"   >
				  
				  <input type="hidden" name="patientspent" id="patientspent"  value="<?php echo $patientspent;?>"   readonly="readonly" ></td>
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
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Admitting Doctor</span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="admissiondoctor" id="admissiondoctor" value="<?php echo $opadmissiondoctor; ?>" >
				  <input type="hidden" name="admissiondoctorCode" id="admissiondoctorCode" value="<?php echo $admission_doc_code; ?>">
				  <input type="hidden" name="admissiondoctorType" id="admissiondoctorType" value="">
				  </td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Treating Doctor</span></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><strong><input type="text" name="consultingdoctorsearch" id="consultingdoctorsearch" value="<?php echo $doctor; ?>">
				  <input type="hidden" name="consultingdoctor" id="consultingdoctor" value="<?php echo $consultingdoctoranum; ?>">
				  <input name="consultingdoctorType" id="consultingdoctorType" value="" type='hidden'>
				    <!--<select name="consultingdoctor" id="consultingdoctor">
                      <?php
						if ($doctor != '')
						{
						?>
                      <option value="<?php echo $consultingdoctoranum; ?>" selected="selected"><?php echo $doctor; ?></option>
                      <?php
						}
						else
						{
						?>
                      <option value="" selected="selected">Select</option>
                      <?php
						}
						$query1 = "select * from master_doctor where status <> 'deleted' order by doctorname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1doctor = $res1["doctorname"];
						$res1doctoranum = $res1["auto_number"];
						?>
                      <option value="<?php echo $res1doctoranum; ?>"><?php echo $res1doctor; ?></option>
                      <?php
						}
						?>
                    </select>-->
				  </strong></td>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Admission Notes</span></td>
				   <td align="left" valign="middle" colspan="3" bgcolor="#ecf0f5"><textarea name="admissionnotes" id="admissionnotes" ><?php echo $admissionnotes; ?></textarea>
				 &nbsp;&nbsp;
				  <!--<input type="hidden" name="department" id="department" value="<?php echo $department; ?>" style="border: 1px solid #001E6A;"  size="20" />-->
				  <span class="bodytext32"  >Ward</span> &nbsp;&nbsp;
					<select id="visit_ward" name="visit_ward"  >
					<option value="">Select Ward</option>
					<?php
					$query1 = "select * from master_ward where recordstatus = ''  and locationcode='$reslocationcode' order by ward";
					$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
					while ($res1 = mysqli_fetch_array($exec1))
					{
					$res1ward= $res1["ward"];
					$res1wardnum= $res1["auto_number"];
					?>
					<option value="<?php echo $res1wardnum; ?>" <?php if($visit_ward==$res1wardnum){ echo 'selected';} ?>><?php echo $res1ward; ?></option>
					<?php
					}
					?>
					</select>
					</td>
				</tr>
				<tr>
                <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Consultation Date </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="consultationdate" id="consultationdate" value="<?php echo $consultationdate; ?>" readonly ></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32"> Consultation Time </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="consultationtime" id="consultationtime" value="<?php echo $consultationtime; ?>" readonly size="8" />
                  <span class="bodytext32">(Ex: HH:MM)</span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Admission Fees </span></td>
                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="admissionfees" id="admissionfees" value="<?php echo $ipadmissionfee; ?>" onFocus="return funcVisitEntryPatientCodeValidation1()" size="20" />
                 
                     <?php// if(($smartap==2)||($smartap==3)){ ?>
                     <label><span class="bodytext32">OFFSLADE</span></label> &nbsp; 
                   <input type="checkbox" id="offpatient" name="offpatient" value="0" onClick="check_offpatient()" <?php if($offpatient == '1') { echo 'checked="checked"'; } ?> />
                   <?php// } ?>
                   <input type="hidden" id="smart_ap" name="smart_ap" value="<?php echo $smartap;?>"/></td>
                </td>  
				</tr>
				
				 
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> Package Applicable</span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="packapplicable" id="packapplicable" onClick="return funcpackcheck();" value="1"<?php if($packapplicablecheck!=0)echo 'checked'; ?>></td>
				   <input type="hidden" name="packapplicablecheck" id="packapplicablecheck" value="<?php echo $packapplicablecheck; ?>">
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Smart Benefit No </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="smartbenefitno" id="smartbenefitno" value="<?= $smartbenefitno; ?>" size="20"  readonly/></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><label onClick="return enabtriage();">Admit ID </label></span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="admitid" id="admitid" value="<?= $admitid; ?>" size="20" readonly/></td>
				   <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				 </tr>
				 
				 <tr id="pack">
				 	   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> Package </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" id="pack">
                   <input type="text" name="packagename" id="packagename" size="30" autocomplete="off" value="<?php echo $res1packagename; ?>">
                   <input type="hidden" name="package" id="package" value="<?php echo $packageanum; ?>">
                   <input type="hidden" name="package_consumed" id="package_consumed" value="<?php echo $numpkg; ?>">
                   </td>
				   
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Package Charges</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="packcharge" id="packcharge"  size="20" value="<?php echo $packagecharge; ?>" readonly/></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Apply Admn Fee</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="checkbox" name="packchargeapply" id="packchargeapply" value="1">
				   <input type="hidden" name="adminfeeapply" id="adminfeeapply" value="<?php echo $adminfeeapply; ?>"></td>
				   <td colspan="2" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				 </tr>
				 <tr>
				
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">NHIF Applicable </span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><select name="nhifapplicable" id="nhifapplicable" onChange="return funcnhifcheck();">
				   <?php
						if ($nhifanum != '')
						{
						?>
                      <option value="<?php echo $nhifanum; ?>" selected="selected"><?php echo $nhifname; ?></option>
                      <?php
						}
						else
						{
						?>
				    <option value="no">Select</option>
					<?php
					}
					?>
				   <option value="yes">YES</option>
				   <option value="no">NO</option>
				   </select></td>
				   
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" >Plan Used</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="plandue" id="plandue" readonly value="<?php echo $overallplandue; ?>"></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><span id="savannah_authlb" class="bodytext32">Slade Authentication No</span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="savannah_authid" id="savannah_authid"  size="20"  value="<?php echo $savannah_authid;?>"/><input name="savannah_authflag" id="savannah_authflag"  size="20" type="hidden" /></td>
				 </tr>
				 <tr id="nhif">
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">NHIF ID</span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="nhifid" id="nhifid" value="<?php echo $nhifid; ?>"></td>
				   
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Issue Date </td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="text" name="issuedate" id="issuedate" size="10" value="<?php echo $nhifissuedate; ?>"> <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('issuedate')" style="cursor:pointer"/> </span></strong></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Valid Till</td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="text" name="validtill" id="validtill" size="10" value="<?php echo $nhifvaliddate; ?>"> <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('validtill')" style="cursor:pointer"/> </span></strong></td>
				   <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">NHIF Rebate</td>
				   <td width="18%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><input type="text" name="nhifrebate" id="nhifrebate" value="<?php echo $nhifrebaterate; ?>"></td>
				 </tr>
<!--				 <tr>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Complaint</td>
				   <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5"><input name="complaint" id="complaint" value="<?php echo $complaint; ?>" style="border: 1px solid #001E6A;"  size="75" /></td>
			      </tr>
-->				 
				 
                 <tr>
                <td colspan="8" align="middle"  bgcolor="#ecf0f5"><div align="right"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input type="hidden" name="frmflag1" value="frmflag1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                  
                   <input type="hidden" name="check_checkbox" id="check_checkbox" value="<?php echo $check_checkbox; ?>" />
                    
                   <input type="hidden" name="get_subtype" id="get_subtype" value="<?php echo $get_subtype; ?>" />
				  <input name="savannahvalid_from" id="savannahvalid_from" value="" type="hidden" />
				<input name="savannahvalid_to" id="savannahvalid_to" value="" type="hidden" />
				<input name="slade_authentication_token" id="slade_authentication_token" value="" type="hidden" />
                  <input name="Submit222" type="submit"  value="Save Visit Entry (Alt+S)" accesskey="s" class="button" id="submit" <?php if($smartap > 0) echo "disabled"; ?>/>
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
$(document).ready(function(){
checksubtype();
});
</script>
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
</script>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
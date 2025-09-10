<?php 

session_start();

include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
//echo $menu_id;
include ("includes/check_user_access.php");

if (!isset($_SESSION["username"])) header ("location:index.php");

include ("db/db_connect.php");



$errmsg = "";

$bgcolorcode = "";

$pagename = "";

$consultationfees1 = '';

$availablelimit = '';

$overallplandue = '0.00';

$is_mcc = '';

//This include updatation takes too long to load for hunge items database.

//include ("autocompletebuild_customer1.php");



if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["menuid"])) { $menuid = $_REQUEST["menuid"]; } else { $menuid = ""; }
if (isset($_REQUEST["populate"])) { $populate = $_REQUEST["populate"]; } else { $populate = "6"; }

if ($frmflag1 == 'frmflag1')

{

$ipaddress = $_SERVER["REMOTE_ADDR"];

$username = $_SESSION['username'];

$updatetime = date('Y-m-d H:i:s');

	$query1111 = "select * from master_employee where username = '$username'";

    $exec1111 = mysqli_query($GLOBALS["___mysqli_ston"], $query1111) or die ("Error in Query1111".mysqli_error($GLOBALS["___mysqli_ston"]));

	//while ($res1111 = mysql_fetch_array($exec1111))

	//{

	// $username = $res1111["username"];

	 $locationcode1 = $_REQUEST["location"];

	 

	  $query1112 = "select * from master_location where locationcode = '$locationcode1'";

    $exec1112 = mysqli_query($GLOBALS["___mysqli_ston"], $query1112) or die ("Error in Query1112".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res1112 = mysqli_fetch_array($exec1112);



		 $locationname = $res1112["locationname"];		  

		  $locationcode = $res1112["locationcode"];

		   $prefix = $res1112["prefix"];

		    $suffix = $res1112["suffix"];

	

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

	$consultingdoctorcode = $_REQUEST['consultingdoctorcode'];

	

	$department = $_REQUEST["department"];
    $remarks=addslashes($_REQUEST['remarks']);

	

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

	//$accname=$res87['accountname'];

	$accname = $_REQUEST["accountnamename"];
	$accountexpirydate = $_REQUEST["accountexpirydate"];

	$planname = $_REQUEST["planname"];

 $query87p="select smartap from master_planname where auto_number='$planname'";

	$exec87p=mysqli_query($GLOBALS["___mysqli_ston"], $query87p);

	$res87p=mysqli_fetch_array($exec87p);

	$smartap=$res87p['smartap'];

	$planexpirydate = $_REQUEST["planexpirydate"];

	$consultationdate = $_REQUEST["consultationdate"];

	$consultationtime  = $_REQUEST["consultationtime"];

	$consultationtype = $_REQUEST["consultationtype"];

	$consultationfees  = $_REQUEST["consultationfees"];

	$referredby = $_REQUEST["referredby"];

	$consultationremarks = $_REQUEST["consultationremarks"];

	$complaint = $_REQUEST["complaint"];

	$registrationdate = $_REQUEST["registrationdate"];

	$visittype = $_REQUEST["type"];

	$visitlimit = $_REQUEST["visitlimit"];

	$overalllimit = $_REQUEST["overalllimit"];

	$visitcount = $_REQUEST["visitcount"];

	$planfixedamount = $_REQUEST["planfixedamount"];

	$planpercentageamount = $_REQUEST["planpercentageamount"];

	$updatedatetime = date('Y-m-d H:i:s');

	$memberno = $_REQUEST['memberno'];

	$smartbenefitno = $_REQUEST["smartbenefitno"];

	$admitid = $_REQUEST["admitid"];

    $availablelimit = $_REQUEST["availablelimit"];
	
	$copay_forcecheck = isset($_POST["copay_forcecheck"])? 1 : 0;

	

	$patientspent=$_REQUEST['patientspent'];

	$plandue = $_REQUEST['plandue'];

    $slade_authentication_token = addslashes($_REQUEST['slade_authentication_token']);
	$savannah_authid = $_REQUEST['savannah_authid'];
	$savannahvalid_from = $_REQUEST['savannahvalid_from'];
	$savannahvalid_to = $_REQUEST['savannahvalid_to'];

$scheme_id = $_REQUEST["scheme_id"];
$offpatient = $_REQUEST['offpatient'];
	if($offpatient==1)
	{
	 $smartap='0';  
	}
	if(($offpatient==1)&&($original_smart=='3'))
	{
	 $smartap=3;   
	}

$query87p1="select billtype from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec87p1=mysqli_query($GLOBALS["___mysqli_ston"], $query87p1);
$res87p1=mysqli_fetch_array($exec87p1);
$billtype_before=$res87p1['billtype'];


	if(isset($_POST['mccno']) && $_POST['mccno']!='' && $_POST['subtype_mcc']==1)

		$mcc = $_POST['mccno'] ;

	else

        $mcc ='';

	 $query201 = "INSERT INTO `audit_master_visitentry` (`visit_auto_id`, `patientcode`, `visitcode`, `registrationdate`, `patientfirstname`, `patientmiddlename`, `patientlastname`, `patientfullname`, `paymenttype`, `subtype`, `billtype`, `accountname`, `accountexpirydate`, `planname`, `planexpirydate`, `overalllimit`, `availablelimit`, `consultingdoctor`, `consultingdoctorcode`, `department`, `departmentname`, `consultationdate`, `consultationtime`, `consultationfees`, `referredby`, `consultationremarks`, `complaint`, `visittype`, `visitlimit`, `paymentstatus`, `consultationtype`, `ipaddress`, `recordstatus`, `username`, `visitcount`, `planfixedamount`, `planpercentage`, `doctorconsultation`, `overallpayment`, `patientspent`, `pharmacybill`, `labbill`, `radiologybill`, `servicebill`, `referalbill`, `medicineissue`, `labsamplecoll`, `itemrefund`, `consultationrefund`, `triagestatus`, `age`, `gender`, `accountfullname`, `referalconsultation`, `triageconsultation`, `locationname`, `locationcode`, `planstatus`, `memberno`, `admitid`, `smartbenefitno`, `locationname1`, `hospitalfees`, `doctorfees`, `doctorfeesstatus`, `doctorfeesrefund`, `consultationrefundremarks`, `edited_by`, `edited_time`, `edited_ip`, `lablimit`, `radiologylimit`, `serviceslimit`, `pharmacylimit`, `plandue`, `registrationfees`, `mcc`, `slade_payload`, `payer_code`, `savannah_authid`, `savannah_authflag`, `savannahvalid_from`, `savannahvalid_to`, `refundrequestedby`, `eclaim_id`, `is_revisit`) SELECT auto_number, `patientcode`, `visitcode`, `registrationdate`, `patientfirstname`, `patientmiddlename`, `patientlastname`, `patientfullname`, `paymenttype`, `subtype`, `billtype`, `accountname`, `accountexpirydate`, `planname`, `planexpirydate`, `overalllimit`, `availablelimit`, `consultingdoctor`, `consultingdoctorcode`, `department`, `departmentname`, `consultationdate`, `consultationtime`, `consultationfees`, `referredby`, `consultationremarks`, `complaint`, `visittype`, `visitlimit`, `paymentstatus`, `consultationtype`, `ipaddress`, `recordstatus`, `username`, `visitcount`, `planfixedamount`, `planpercentage`, `doctorconsultation`, `overallpayment`, `patientspent`, `pharmacybill`, `labbill`, `radiologybill`, `servicebill`, `referalbill`, `medicineissue`, `labsamplecoll`, `itemrefund`, `consultationrefund`, `triagestatus`, `age`, `gender`, `accountfullname`, `referalconsultation`, `triageconsultation`, `locationname`, `locationcode`, `planstatus`, `memberno`, `admitid`, `smartbenefitno`, `locationname1`, `hospitalfees`, `doctorfees`, `doctorfeesstatus`, `doctorfeesrefund`, `consultationrefundremarks`, `edited_by`, `edited_time`, `edited_ip`, `lablimit`, `radiologylimit`, `serviceslimit`, `pharmacylimit`, `plandue`, `registrationfees`, `mcc`, `slade_payload`, `payer_code`, `savannah_authid`, `savannah_authflag`, `savannahvalid_from`, `savannahvalid_to`, `refundrequestedby`, `eclaim_id`, `is_revisit` FROM master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201);
$lastid=((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
mysqli_query($GLOBALS["___mysqli_ston"], "update `audit_master_visitentry` set remarks='$remarks' where auto_number='$lastid'");

	if(($planfixedamount =='0.00' && $planpercentageamount =='0.00') && ($consultationfees =='0'))

	{

	 $query1 = "update master_visitentry set scheme_id='$scheme_id',patientcode='$patientcode',visitcode='$visitcode',patientfirstname='$patientfirstname',patientmiddlename='$patientmiddlename',patientlastname='$patientlastname',patientfullname='$patientfullname',consultingdoctor='$consultingdoctor',

		department='$department',paymenttype='$paymenttype',subtype='$subtype',billtype='$billtype',accountname='$accountname',accountexpirydate='$accountexpirydate',planname='$planname',planexpirydate='$planexpirydate',consultationdate='$consultationdate', 

		consultationtime='$consultationtime',consultationtype='$consultationtype',consultationfees='$consultationfees',referredby='$referredby',consultationremarks='$consultationremarks',complaint='$complaint',registrationdate='$registrationdate',visittype='$visittype',visitlimit='$visitlimit',overalllimit='$overalllimit',visitcount='$visitcount',patientspent='$patientspent',planpercentage='$planpercentageamount',planfixedamount='$planfixedamount',

		paymentstatus='completed',triagestatus='',departmentname='$departmentname',accountfullname='$accname',locationcode='$locationcode',locationname='$locationname',consultingdoctorcode = '$consultingdoctorcode',memberno='$memberno',plandue='$plandue',edited_by='$username',edited_time='$updatetime',edited_ip='$ipaddress',admitid = '$admitid' ,smartbenefitno = '$smartbenefitno',mcc='$mcc',savannah_authid='$savannah_authid',slade_payload='$slade_authentication_token',savannahvalid_from='$savannahvalid_from',savannahvalid_to='$savannahvalid_to',availablelimit='$availablelimit',eclaim_id='$smartap',offpatient='$offpatient' where patientcode='$patientcode' and visitcode='$visitcode'";

		

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	

	

	}

else if($planfixedamount =='0.00' && $planpercentageamount =='0.00')

{

	    $query1 = "update master_visitentry set scheme_id='$scheme_id',patientcode='$patientcode',visitcode='$visitcode',patientfirstname='$patientfirstname',patientmiddlename='$patientmiddlename',patientlastname='$patientlastname',patientfullname='$patientfullname',consultingdoctor='$consultingdoctor',

		department='$department',paymenttype='$paymenttype',subtype='$subtype',billtype='$billtype',accountname='$accountname',accountexpirydate='$accountexpirydate',planname='$planname',planexpirydate='$planexpirydate',consultationdate='$consultationdate', 

		consultationtime='$consultationtime',consultationtype='$consultationtype',consultationfees='$consultationfees',referredby='$referredby',consultationremarks='$consultationremarks',complaint='$complaint',registrationdate='$registrationdate',visittype='$visittype',visitlimit='$visitlimit',overalllimit='$overalllimit',visitcount='$visitcount',patientspent='$patientspent',planpercentage='$planpercentageamount',planfixedamount='$planfixedamount',

		paymentstatus='completed',triagestatus='pending',departmentname='$departmentname',accountfullname='$accname',locationcode='$locationcode',locationname='$locationname',consultingdoctorcode = '$consultingdoctorcode',memberno='$memberno',edited_by='$username',edited_time='$updatetime',edited_ip='$ipaddress',plandue='$plandue',admitid = '$admitid' ,smartbenefitno = '$smartbenefitno',mcc='$mcc',savannah_authid='$savannah_authid',slade_payload='$slade_authentication_token',savannahvalid_from='$savannahvalid_from',savannahvalid_to='$savannahvalid_to',availablelimit='$availablelimit',eclaim_id='$smartap',offpatient='$offpatient'  where patientcode='$patientcode' and visitcode='$visitcode'";

		

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			

			}

			else if($consultationfees =='0')

			{
				
				
		if($copay_forcecheck=='1'){
		$paymentstatus='';	
		}else{
		$paymentstatus='completed';
		}

			 $query1 = "update master_visitentry set scheme_id='$scheme_id',patientcode='$patientcode',visitcode='$visitcode',patientfirstname='$patientfirstname',patientmiddlename='$patientmiddlename',patientlastname='$patientlastname',patientfullname='$patientfullname',consultingdoctor='$consultingdoctor',

		department='$department',paymenttype='$paymenttype',subtype='$subtype',billtype='$billtype',accountname='$accountname',accountexpirydate='$accountexpirydate',planname='$planname',planexpirydate='$planexpirydate',consultationdate='$consultationdate', 

		consultationtime='$consultationtime',consultationtype='$consultationtype',consultationfees='$consultationfees',referredby='$referredby',consultationremarks='$consultationremarks',complaint='$complaint',registrationdate='$registrationdate',visittype='$visittype',visitlimit='$visitlimit',overalllimit='$overalllimit',visitcount='$visitcount',patientspent='$patientspent',planpercentage='$planpercentageamount',planfixedamount='$planfixedamount',

		paymentstatus='$paymentstatus',triagestatus='pending',departmentname='$departmentname',accountfullname='$accname',locationcode='$locationcode',locationname='$locationname',consultingdoctorcode = '$consultingdoctorcode',memberno='$memberno',edited_by='$username',edited_time='$updatetime',edited_ip='$ipaddress',plandue='$plandue',admitid = '$admitid' ,smartbenefitno = '$smartbenefitno',mcc='$mcc',savannah_authid='$savannah_authid',slade_payload='$slade_authentication_token',savannahvalid_from='$savannahvalid_from',savannahvalid_to='$savannahvalid_to',availablelimit='$availablelimit',eclaim_id='$smartap',copay_forcecheck='$copay_forcecheck',offpatient='$offpatient'  where patientcode='$patientcode' and visitcode='$visitcode'";

		

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	

			}

			else

			{

				 $query1 = "update master_visitentry set scheme_id='$scheme_id',patientcode='$patientcode',visitcode='$visitcode',patientfirstname='$patientfirstname',patientmiddlename='$patientmiddlename',patientlastname='$patientlastname',patientfullname='$patientfullname',consultingdoctor='$consultingdoctor',

		department='$department',paymenttype='$paymenttype',subtype='$subtype',billtype='$billtype',accountname='$accountname',accountexpirydate='$accountexpirydate',planname='$planname',planexpirydate='$planexpirydate',consultationdate='$consultationdate', 

		consultationtime='$consultationtime',consultationtype='$consultationtype',consultationfees='$consultationfees',referredby='$referredby',consultationremarks='$consultationremarks',complaint='$complaint',registrationdate='$registrationdate',visittype='$visittype',visitlimit='$visitlimit',overalllimit='$overalllimit',visitcount='$visitcount',patientspent='$patientspent',planpercentage='$planpercentageamount',planfixedamount='$planfixedamount',

		triagestatus='',departmentname='$departmentname',accountfullname='$accname',locationcode='$locationcode',locationname='$locationname',consultingdoctorcode = '$consultingdoctorcode',memberno='$memberno',edited_by='$username',edited_time='$updatetime',edited_ip='$ipaddress',plandue='$plandue',admitid = '$admitid' ,smartbenefitno = '$smartbenefitno',mcc='$mcc',savannah_authid='$savannah_authid',slade_payload='$slade_authentication_token',savannahvalid_from='$savannahvalid_from',savannahvalid_to='$savannahvalid_to',availablelimit='$availablelimit',eclaim_id='$smartap',offpatient='$offpatient'  where patientcode='$patientcode' and visitcode='$visitcode'";

		

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));



			}


         $query3 = "select * from master_triage where patientcode = '$patientcode' and  visitcode = '$visitcode'";

		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

		$rowcount3 = mysqli_num_rows($exec3);

		if ($rowcount3 > 0)

		{
			$query002="update master_triage set consultingdoctor='$consultingdoctor',
		department='$departmentname',consultationtype='$consultationtype' where patientcode='$patientcode' and visitcode='$visitcode'"; 

			$exec002=mysqli_query($GLOBALS["___mysqli_ston"], $query002) or die ("Error in Query002".mysqli_error($GLOBALS["___mysqli_ston"]));
			
        }
		
		
if($billtype_before=='PAY LATER' && $billtype=='PAY NOW' && $consultationfees>0)
{
$query18 = "update master_visitentry set paymentstatus='' where patientcode='$patientcode' and visitcode='$visitcode'";
$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));	
}
if(($billtype=='PAY LATER' &&  $planfixedamount >'0.00'  && $consultationfees>0) || ( $planpercentageamount >'0.00' && $billtype=='PAY LATER' && $consultationfees>0 ))
{
		$query291 = "select * from master_billing where visitcode='$visitcode'";
		$exec291 = mysqli_query($GLOBALS["___mysqli_ston"], $query291) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num291 = mysqli_num_rows($exec291);
		if($num291 == 0)
		{
	
		$query18 = "update master_visitentry set paymentstatus='' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));	

		}
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

	$admitid='';

	$smartbenefitno='';

		

		header("location:searchpatientvisit.php");

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

	$billnumbercode =$consultationprefix.'00000001';

	$openingbalance = '0.00';

}

else

{

	$billnumber = $res21["billnumber"];

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

	

	$billnumbercode = $consultationprefix.$maxanum1;

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

		

	$opdue = $res3['opdue'];

	

	

	$query56="select * from master_visitentry where patientcode = '$patientcode' and visitcode = '$visitcode'";

	$exec56=mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	$res56=mysqli_fetch_array($exec56);

	$departmentanum = $res56['department'];

	

	$planfixedamount = $res56['planfixedamount'];

	$planpercentageamount = $res56['planpercentage'];

	$billtype = $res56['billtype'];

	$locationcode=$this_location= $res56['locationcode'];

	$memberno = $res56['memberno'];

	$mccnumber = $res56['mcc'];
   
    $savannah_authid = $res56['savannah_authid'];
	$visittype = $res56['visittype'];
	$offpatient = $res56['offpatient'];
	
	$copay_forcecheck = $res56['copay_forcecheck'];
	$copay_forcebillstatus = $res56['copay_forcebillstatus'];
	$readonly_copaycollect='';
	if($copay_forcebillstatus=='completed'){
		$readonly_copaycollect='style="pointer-events: none;"';
	}
	

	$query7 = "select * from master_location where locationcode = '$locationcode'";

	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res7 = mysqli_fetch_array($exec7);

	$locationname = $res7['locationname'];

	

	if($billtype == 'PAY NOW')

	{

	if($planfixedamount == '0.00')

	{

	$planfixedamount = '';

	}

	

	if($planpercentageamount == '0.00')

	{

	$planpercentageamount = '';

	}

	}

	$visitcount = $res56['visitcount'];

	$consultationdate = $res56['consultationdate'];

$consultationtime = $res56['consultationtime'];

$age = $res56['age'];

$gender = $res56['gender']; 

$referredby = $res56['referredby'];

$patientspent = $res56['patientspent'];

$paymenttype = $res56['paymenttype'];

$admitid = $res56['admitid'];

$smartbenefitno = $res56['smartbenefitno'];

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

	$billtype = $res56['billtype'];

	



$accountname = $res56['accountname'];

	$query4 = "select * from master_accountname where auto_number = '$accountname'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res4 = mysqli_fetch_array($exec4);

	$accountnameanum = $res4['auto_number'];

	//$accountname = $res4['accountname'];

	$is_mcc = $res4['mcc'];


 $scheme_id = trim($res56["scheme_id"]);
	$query_sc = "select * from master_planname where scheme_id = '$scheme_id'";

	$exec_sc = mysqli_query($GLOBALS["___mysqli_ston"], $query_sc) or die ("Error in query_sc".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res_sc = mysqli_fetch_array($exec_sc);

	//$plannameanum = $res4['auto_number'];

	$accountname = $res_sc['scheme_name'];
	$accountexpirydate = $res_sc['scheme_expiry'];
	$account_active = $res_sc['scheme_active_status'];
	$exclusions = $res_sc['exclusions'];

	 $planname = $res56['planname'];

	 $query4 = "select * from master_planname where auto_number = '$planname'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res4 = mysqli_fetch_array($exec4);

	$plannameanum = $res4['auto_number'];

	$planname = $res4['planname'];

	$smartap = $res4['smartap'];

	$planapplicable = $res4['planapplicable'];

	$planfixedamount = $res4['planfixedamount'];

	$planexpirydate = $res56['planexpirydate'];

	$registrationdate = $res56['registrationdate'];
	$opvisitlimit = $res4["opvisitlimit"];
	$overalllimit = $res4["overalllimitop"];
$visitlimit = $res4['opvisitlimit'];	

	



	$query66="select * from master_department where auto_number='$departmentanum'";

	$exec66=mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	$res66=mysqli_fetch_array($exec66);

	$department=$res66['department'];

	

	$consultingdoctoranum = $res56['consultingdoctor'];

	$consultingdoctorcode = $res56['consultingdoctorcode'];

	

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

	$query1 = "select consultationfees from locationwise_consultation_fees where consultation_id='$consultingtypeanum'  and locationcode = '$locationcode' and department='$departmentanum' ";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res1 = mysqli_fetch_array($exec1);

		

		$consultationfees = $res1["consultationfees"];

	if($visitcount == 1)

	{

	$availablelimit=$overalllimit ;

	}

	else

	{

	$availablelimit=$overalllimit-$planfixedamount-$opdue;
	//$availablelimit=$overalllimit-$planfixedamount;

	}

	

	if($planapplicable=='1')

	{

		$query88 = "select sum(plandue) as overallplandue from master_customer where planname = '$plannameanum'";

		$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res88 = mysqli_fetch_array($exec88);

		$overallplandue = $res88['overallplandue'];

		$availablelimit = $overalllimit-$overallplandue;	

	}

	else

	{

		$overallplandue = 0;	

	}	

	

	

    $query51 = "select * from master_visitentry where patientcode = '$patientcode' and consultationdate < '$consultationdate' and recordstatus = '' order by auto_number desc limit 0,1";

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

	

	

	

}





$registrationdate = date('Y-m-d');



 

//$consultationfees = '500';



if (isset($_REQUEST["errorcode"])) { $errorcode = $_REQUEST["errorcode"]; } else { $errorcode = ""; }

//$patientcode = 'MSS00000009';

if ($errorcode == 'errorcode1failed')

{

	$errmsg = 'Patient Already Visited Today. Cannot Proceed With Visit Entry. Save Not Completed.';	

}


if($opvisitlimit > 0){
	
	$availablelimit = $opvisitlimit;
	
}


?>

<style type="text/css">
.bal {
    border-style: 1px;
	font-weight: 800;
    background: none;
    FONT-FAMILY: Tahoma;
    FONT-SIZE: 12px;
}

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

.ui-menu .ui-menu-item{ zoom:1 !important; }

</style>

</head>

<link href="autocomplete.css" rel="stylesheet">



<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

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


function process1()

{

	if (document.form1.type.value == "")


	{


		alert ("Please Select Visit Type.");


		document.form1.type.focus();


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

	*/

	if(document.getElementById("billtype").value == "PAY LATER")

	 {

	  if(document.getElementById("memberno").value == "")

	   {

	    alert("Member No Cannot be Empty");

		document.form1.memberno.focus();

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



	/*	if (document.form1.subtype_mcc.value == 1)

		{

			if (document.form1.mccno.value == '') {

				alert ("Please Enter MCC number.");

				document.form1.mccno.focus();

				return false;

			}

		} */

	}

  if (document.form1.remarks.value == '') {


				alert ("Please Enter the reason.");


				document.form1.remarks.focus();


				return false;


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



function funcDepartmentChangeNew()

{

		var department = document.getElementById("department").value;

		var department = department.trim();

		var location = document.getElementById("location").value;

		var location = location.trim();

		var subtype = document.getElementById("subtype").value;

		var subtype = subtype.trim();

		var consultingdoctorcode = document.getElementById("consultingdoctorcode").value;

		var consultingdoctorcode = consultingdoctorcode.trim();

		

  	if(location == "")

	{

		alert("Please Select Location.");

		document.getElementById("location").focus();

		return false;

	}

	if(subtype == "")

	{

		alert("Please Select Patient.");

		document.getElementById("customer").focus();

		return false;

	}

	

	if(department == "")

	{

		alert("Please Select Department.");

		document.getElementById("customer").focus();

		return false;

	}

	//alert(department+" department "+subtype+" subtype "+location+" location "+consultingdoctorcode+" consultingdoctorcode");

	

	if(consultingdoctorcode != "")

	{

	

			$.ajax({

				type: "POST",

				url: "ajaxAddConsultationTypeOptions.php",

				datatype: "json",

				async: false,

				data:{'department':department,'subtype':subtype,'location' : location,'doctorcode' : consultingdoctorcode },

				catch : false,

				success:function(data){

				//alert(data);

				//console.log("Inside ajax: "+data); 

				var options = data.split('^');

				var option = options[0];

				var options1 = options[1];

				var optfees = options1.split(',');

				var fees = optfees[1];

				//alert(option);

				//alert(fees);

				$('#consultationtype').html(option);

				$('#consultationfees').val(fees)

				var planfixedamount = $('#planfixedamount').val();
		
				var planpercentageamount = $('#planpercentageamount').val();

				if((planfixedamount>0 || planpercentageamount>0) && (fees==0)){
				
				$('#copayforce_pay').show();	
				}else{
				$('#copayforce_pay').hide();	
				}

				}

			});

			

	}else{

		

		alert("Please Select Consulting Doctor.");

		document.getElementById("consultingdoctor").focus();

		return false;

	} 

	 

}



function funcDepartmentChange()

{<?php /*?>



		<?php

	$query11 = "select auto_number,department from master_department where recordstatus = '' order by auto_number ASC";

    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

	while ($res11 = mysqli_fetch_array($exec11))

	{

	$res11departmentanum = $res11['auto_number'];

	$res11department = $res11["department"];

	

	$query4 = "select auto_number,locationcode from master_location where status = ''";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res4 = mysqli_fetch_array($exec4))

	{

	

	$res4locanum = $res4['auto_number'];

	$res4loccode = $res4['locationcode'];

	

	$query41 = "select auto_number from master_subtype where recordstatus = ''";

	$exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die ("Error in Query41".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res41 = mysqli_fetch_array($exec41))

	{

	$subanum = $res41['auto_number']; 

	?>

		if(document.getElementById("department").value == "<?php echo $res11departmentanum; ?>")

		{

		if(document.getElementById("location").value == "<?php echo $res4loccode; ?>")

		{

		var subtype = document.getElementById("subtype").value;

		var subtype = subtype.trim();

		if(subtype == "<?php echo $subanum; ?>")

		{

		//alert(document.getElementById("department").value);

		document.getElementById("consultationtype").options.length=null; 

		var combo = document.getElementById('consultationtype'); 

		<?php 

		$loopcount=0;

		?>

		combo.options[<?php echo $loopcount;?>] = new Option ("Select Consultation Type", ""); 

		<?php

$query10 ="select auto_number,consultationtype,condefault,consultationfees from master_consultationtype where department = '$res11departmentanum' and subtype = '$subanum' and locationcode = '$res4loccode' and recordstatus <>'deleted' order by consultationtype";

		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res10 = mysqli_fetch_array($exec10))

		{

		

		$res10consultationtypeanum = $res10['auto_number'];

		$res10consultationtype = $res10["consultationtype"];

		$res10consultationdefault = $res10["condefault"];

		//if($loopcount==0)

		//{

			$res10consultationfee = $res10["consultationfees"];

			

			?>

			 

			<?php 

			//}

		$loopcount = $loopcount+1;



		?>

		combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10consultationtype;?>", "<?php echo $res10consultationtypeanum;?>"); 

		<?php if($res10consultationdefault=='on'){?>

		combo.options[<?php echo $loopcount;?>].selected ="selected"; 

		document.getElementById('consultationfees').value=<?php echo $res10consultationfee;?>; 

		<?php 

		}

		//$loopcount = $loopcount+1;

		}

		?>

		}

		}

		}

	<?php

	}

	}

	}

	?>

 



<?php */?>}

function funcConsultationTypeChange(depid)

{
	
$.ajax({

				type: "POST",

				url: "ajaxgetconsultamount.php",

				datatype: "json",

				async: false,

				data:{'depid':depid},

				catch : false,

				success:function(data){

				$('#consultationfees').val(data);
				
				var planfixedamount = $('#planfixedamount').val();
		
				var planpercentageamount = $('#planpercentageamount').val();

				if((planfixedamount>0 || planpercentageamount>0) && (data==0)){
				
				$('#copayforce_pay').show();	
				}else{
				$('#copayforce_pay').hide();	
				}
				



				}

			});
	<?php /*?><?php

	$query11 = "select * from master_consultationtype where recordstatus = ''";

    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

	while ($res11 = mysqli_fetch_array($exec11))

	{

	$res11consultationanum = $res11["auto_number"];
	
	$query_sub = "select consultationfees from locationwise_consultation_fees where consultation_id='$res11consultationanum' and locationcode = '$this_location'  and recordstatus <> 'Deleted' limit 1";

 

	$res11consultationtype = $res11["consultationtype"];

	
  $exec_sub = mysqli_query($GLOBALS["___mysqli_ston"], $query_sub) or die ("Error in query_sub".mysqli_error($GLOBALS["___mysqli_ston"]));
$res_sub = mysqli_fetch_array($exec_sub);
$res_num = mysqli_num_rows($exec_sub);
if($res_num>0){
$res11consultationfees=$res_sub["consultationfees"]; 
}else
{
	$res11consultationfees=0;
}

	?>

		if(document.getElementById("consultationtype").value == "<?php echo $res11consultationanum; ?>")

		{

			document.getElementById("consultationfees").value = <?php echo $res11consultationfees; ?>;

			document.getElementById("consultationfees").focus();

		}

	<?php

	}

	?><?php */?>

}



function funcLocationDepartmentChange()

{

	

		<?php

	$query4 = "select * from master_location where status = ''";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res4 = mysqli_fetch_array($exec4))

	{

	

	$res4locanum = $res4['auto_number'];

	$res4loccode = $res4['locationcode'];

	?>

		if(document.getElementById("location").value == "<?php echo $res4loccode; ?>")

		{

		//alert(document.getElementById("department").value);

		document.getElementById("department").options.length=null; 

		var combo = document.getElementById('department'); 

		<?php 

		$loopcount=-1;

		?>

		//combo.options[<?php echo $loopcount;?>] = new Option ("Select Department", ""); 

		<?php

		$query10 = "select * from master_department where locationcode = '$res4loccode'";

		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res10 = mysqli_fetch_array($exec10))

		{

		$loopcount = $loopcount+1;

		//if($loopcount == 1) {$loopcount = 0; }

		$res10consultationtypeanum = $res10['auto_number'];

		$res10consultationtype = $res10["department"];

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



function funcOnLoadBodyFunctionCall()

{ 

	//alert ("Inside Body On Load Fucntion.");

	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php

	//funcLocationDepartmentChange();

	//funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
var populate=<?php echo $populate;?>;
	funcbankDropDownSearch1();
	funcbankDropDownSearch3();
	if(populate==1){
	    //alert('yes');
	$('#populatepatientdetails').click();
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
function populatepatient(patientcode){
	//var patientcode = $('#customer').val();
//alert(patientcode);
	$.ajax({
		type: "GET",
		url: "ajaxeditvisitentry.php",
		datatype: "json",
		async: false,
		data:{'patientcode':patientcode },
		catch : false,
		success:function(data){
		//alert(data);
		//console.log("Inside ajax: "+data); 
		var details = data.split('^');
		var patientcode = details[0];
		var accountname = details[1];

			$('#customercode').val(patientcode);
			$('#accountnamename').val(accountname);
			$('#patientcode').val(patientcode);
			
			funcCustomerSearch2();

		}

	});
	
}
$(function() {

$('#customer').autocomplete({
	source:'ajaxcustomernewserach.php', 
	//alert(source);
	minLength:0,
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
	});

function funfetchsavannah(smartap)
{

if(smartap==1)
{
var customersearch=document.getElementById("patientcode").value;
	//alert(customersearch);
var registrationdate=document.getElementById("registrationdate").value;
var data = "customersearch="+customersearch+"&&registrationdate="+registrationdate;	
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
		return false;
	}
	else
	  alert("Smart Fetch Successfull");


	
	if(parseFloat($('#availablelimit').val()) > 0.00)
    {
     $('#submit').prop("disabled",false);
    }
	
	}
	}
    
 });
}
else if(smartap==2)
{
	$('#savannah_authflag').val("");

	if(document.getElementById('consultationfees').value == '')
	{
		alert("Please select consultation type.");
		return false;
	}

	if(document.getElementById('savannah_authid').value == '')
	{
		alert("Savannah auth id. can not be empty.");
		return false;
	}
	else
	{
    FuncPopup();
	memberno = document.getElementById('savannah_authid').value;
	first_name = document.getElementById('patientfirstname').value;
	last_name = document.getElementById('patientlastname').value;
	data = "auth_token="+memberno+"&first_name="+first_name+"&last_name="+last_name;
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
		$('#savannah_authid').prop("readonly",true);
	   if(smartap==2)
	   {
		 $('#availablelimit').val(jsondata['visit_limit']);
		 alert("Slade Fetch Sucessful.");
	   }
		
	   if(parseFloat($('#availablelimit').val()) > 0.00 && parseFloat(jsondata['visit_limit']) >= parseFloat(document.getElementById('consultationfees').value))
	   {
	   $('#submit').prop("disabled",false);
	   }
	   else{
         alert("Insufficient benefit balance.");
	   }
	  }
	else
	{
	alert('Member not covered for Out-Patient');
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
var data = "customersearch="+customersearch+"&&registrationdate="+registrationdate;	
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
		data = "auth_token="+memberno+"&first_name="+first_name+"&last_name="+last_name;
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
		alert('Member not covered for Out-Patient');
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

<?php //include ("js/dropdownlist1newscripting1.php"); ?>

<?php include ("js/dropdownlistdoctorname.php"); ?>

<?php include ("js/dropdownlistdepartment.php"); ?>

<script type="text/javascript" src="js/autosuggestdeptvis.js"></script> 

<script type="text/javascript" src="js/autocomplete_deptvis.js"></script>

<!--<script type="text/javascript" src="js/autosuggestnew1.js"></script> <!-- For searching customer -->

<!--<script type="text/javascript" src="js/autocomplete_newcustomer.js"></script> -->

<script type="text/javascript" src="js/autocustomercodesearch2editop.js"></script>

<script type="text/javascript" src="js/disablebackenterkey.js"></script>

<script type="text/javascript" src="js/autosuggestdoctorvis.js"></script> 

<script type="text/javascript" src="js/autocomplete_doctorvis.js"></script>

<script type="text/javascript" src="js/autosuggestdoctorfees.js"></script> 

<script src="js/autocustomersmartsearch.js"></script>



<script src="js/datetimepicker_css.js"></script>

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





      	  <form name="form1" id="form1" method="post" action="editpatientvisit.php" onKeyDown="return disableEnterKey(event)" onSubmit="return process1()">

      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td width="860"><table width="1132" height="282" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

            <tbody>

              <tr bgcolor="#011E6A">

                <td bgcolor="#ecf0f5" class="bodytext3" colspan="2"><strong>Edit Visit Entry </strong></td>

                <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->

                <td bgcolor="#ecf0f5" class="bodytext3" colspan="4">&nbsp;</td>

              </tr>

              <tr>

                <td colspan="10" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo 'red'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>

              </tr>

              <!--<tr bordercolor="#000000" >

                  <td  align="left" valign="middle"  class="bodytext3"  colspan="4"><strong>Registration</strong></font></div></td>

                </tr>-->

              <!--<tr>

                  <tr  bordercolor="#000000" >

                  <td  align="left" valign="middle"  class="bodytext3" colspan="4"><div align="right">* Indicates Mandatory</div></td>

                </tr>-->

				<tr bgcolor="#011E6A">

                 <td colspan="8" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Search Sequence : First Name | Middle Name | Last Name | Date of Birth | Location | Mobile Number | National ID | Registration No   (*Use "|" symbol to skip sequence)</strong>

              </tr>

				<tr>

				  <!--<td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Patient Search </td>-->

				  <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5">

				<?php $patientregno = $_REQUEST['patientcode']; ?>
				<?php if($patientcode!=''){ ?> <a href='editpatient_new.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&menuid=<?php echo $menuid; ?>&&op_edit=1'><input type='button' value='Edit Patient Details'/></a><?php } ?>
				<span style="display:none"><input type ="button" id = "populatepatientdetails" name = "populatepatientdetails" onclick = "populatepatient('<?php echo $patientregno ?>')" value = "Edit Patient Details"></span>
				  <input type = "hidden" name="customer" id="customer" size="60" autocomplete="off" value = <?php echo $patientregno ?>>

				   <input name="customerhiddentextbox" id="customerhiddentextbox" value="" type="hidden">

				  <input name="customercode" id="customercode" value="" type="hidden">

				   <input name="nationalid" id="nationalid" value = "" type = "hidden">

				  <input name="accountnames" id="accountnames" value="" type="hidden">

				  <input name = "mobilenumber111" id="mobilenumber111" value="" type="hidden">

 				<input type="hidden" name="recordstatus" id="recordstatus">

				  <input type="hidden" name="billnumbercode" id="billnumbercode" value="<?php echo $billnumbercode; ?>" readonly ></td>

				 

				  </tr>

				<tr><td  class="bodytext3" ><strong> Location </strong></td>

              <td  class="bodytext3" >

              <select name="location" id="location" onChange="locationform(form1,this.value)"  style="border: 1px solid #001E6A;">

                

			<option value="<?php echo $locationcode; ?>"><?php echo $locationname; ?></option>

						

                  </select>

                  <input type="hidden" name="locationnamenew" value="<?php echo $locationname; ?>">

                <input type="hidden" name="locationcodenew" value="<?php echo $locationcode; ?>">

             </td>

				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Type &nbsp;&nbsp;&nbsp;
				  
                  <select name="type" id="type" style="border: 1px solid #001E6A;">
                  <option value="" <?php if($visittype=='') echo "selected"; else echo '';?>>select</option>
                  <option value="hospital" <?php if($visittype=='hospital') echo "selected"; else echo '';?>>Hospital</option>
                  <option value="private" <?php if($visittype=='private') echo "selected"; else echo '';?>>Private</option>
                  </select>
                  </td>

				  <td width="18%" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>

				  <td width="15%" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>

				  <td width="17%" align="left" valign="middle"  bgcolor="#ecf0f5">&nbsp;</td>
				 <td width="26%" rowspan="3" align="center" valign="middle"  bgcolor="#ecf0f5" colspan='1'>
					<span >Exclusions</span>
				  <textarea id="schemeexclusions" name='schemeexclusions' class="bal"  rowspan='4' style="height: 68px; width: 292px;" readOnly><?php echo $exclusions; ?></textarea>
				 
					</td>
				  </tr>

				<tr>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Patient</td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5">

				  <input name="patientfirstname" id="patientfirstname" value="<?php echo $patientfirstname; ?>" readonly size="20" /></td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5">

				  <input name="patientmiddlename" id="patientmiddlename" value="<?php echo $patientmiddlename; ?>" readonly size="20" /></td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="patientlastname" id="patientlastname" value="<?php echo $patientlastname; ?>" readonly size="20" /></td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Age</td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="age" id="age" value="<?php echo $age; ?>" readonly ></td>

				 </tr>

				<tr>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"> Reg No </td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5">

				  <input name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>" size="20" /></td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Visit  Date </span></td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="registrationdate" id="registrationdate" value="<?php echo $consultationdate; ?>" ></td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Gender</td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="gender" value="<?php echo $gender; ?>" id="gender" readonly></td>

				  </tr>

				<tr>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Type</td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5">

				    <input type="text" name="paymenttypename" id="paymenttypename"  value="<?php echo $paymenttype;?>" readonly >				

				    <input type="hidden" name="paymenttype" id="paymenttype"  value="<?php echo $paymenttypeanum;?>" readonly >					</td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Visit ID </span></td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" readonly size="20" /></td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Account  </span></td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="accountnamename" id="accountnamename"  value="<?php echo $accountname;?>"  readonly="readonly" style="width: 250px">

				    <input type="hidden" name="accountname" id="accountname"  value="<?php echo $accountnameanum;?>"  readonly="readonly" ></td>
				    <input type="hidden" name="scheme_id" id="scheme_id"  value="<?php echo $scheme_id;?>"  readonly="readonly" ></td>
					
				</tr>

				<tr>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Sub Type </td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>

                    <input type="text" name="subtypename" id="subtypename"  value="<?php echo $subtype;?>"  readonly="readonly" >

				    <input type="hidden" name="subtype" id="subtype"  value="<?php echo $subtypeanum;?>"  readonly="readonly"  style="border: 1px solid #001E6A;">

                    <input type="hidden" name="subtype_mcc" id="subtype_mcc"  value="<?php echo $is_mcc;?>"  readonly="readonly"  style="border: 1px solid #001E6A;">



				  </label></td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Bill Type </span></td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="billtype" id="billtype"  value="<?php echo $billtype;?>"  readonly="readonly"></td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Account Expiry </span></td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="accountexpirydate" id="accountexpirydate"  value="<?php echo $accountexpirydate;?>"  readonly="readonly"  style="border: 1px solid #001E6A;"></td>

				  <td>
					
				  <div id="fetchbtn" style="display:<?php if($smartap > 0){ echo ""; } else { echo "none"; } ?>">

				  <input name="fetch" type="button"  value="Smart" <?php if($smartap == 1){ echo ""; } else { echo "disabled"; } ?> class="button" id="fetch"      onClick="return funcCustomerSmartSearch()" style="background-color:#FF9900;color:#FFFFFF; font-weight:bold; height:50px; width:100px; cursor:pointer;display:<?php if($smartap ==1){ echo ""; } else { echo "none"; } ?>" />

                  <input name="fetch" type="button"  value="Slade" <?php if($smartap == 2){ echo ""; } else { echo "disabled"; } ?> class="button" id="fetch"      onClick="return funfetchsavannah('<?php echo $smartap;?>')" style="background-color:#FF9900;color:#FFFFFF; font-weight:bold; height:50px; width:100px; cursor:pointer;display:<?php if($smartap ==2 ){ echo ""; } else { echo "none"; } ?>" />

				   <input name="fetch" type="button"  value="Smart+Slade" <?php if($smartap == 3){ echo ""; } else { echo "disabled"; } ?> class="button" id="fetch"      onClick="return funfetchsavannah('<?php echo $smartap;?>')" style="background-color:#FF9900;color:#FFFFFF; font-weight:bold; height:50px; width:100px; cursor:pointer;display:<?php if($smartap ==3 ){ echo ""; } else { echo "none"; } ?>" />
</div>

				  </td>

				  </tr>

				

				<tr>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Plan Name </td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>

                    <input type="text" name="plannamename" id="plannamename"  value="<?php echo $planname;?>"   readonly="readonly">

                    <input type="hidden" name="planname" id="planname"  value="<?php echo $plannameanum;?>"   readonly="readonly" >

                  </label></td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Plan Expiry </td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="planexpirydate" id="planexpirydate"  value="<?php echo $planexpirydate;?>"   readonly="readonly"></td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Last Visit</span></td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>

				  <input type="text" name="lastvisitdate" id="lastvisitdate" value="<?php echo $lastvisitdate; ?>">

 				    <input type="hidden" name="visitlimit" id="visitlimit"  value="<?php echo $visitlimit;?>"   readonly="readonly">

				  </label></td>

				  </tr>

				<tr>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Fixed Amount </span></td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>

				  <input type="text" name="planfixedamount" id="planfixedamount"  value="<?php echo $planfixedamount;?>"   readonly="readonly">

				  </label></td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Overall Limit </td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="overalllimit" id="overalllimit"  value="<?php echo $overalllimit;?>"   readonly="readonly" ></td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Patient Due</span></td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>

				    <input type="text" name="patientspent" id="patientspent"  value="<?php echo $patientspent;?>"   readonly="readonly">

				  </label></td>

				  </tr>

				

				<tr>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Percentage</td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label>

				 <input type="text" name="planpercentageamount" id="planpercentageamount"  value="<?php echo $planpercentageamount;?>"   readonly="readonly" ></label> </td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Available Limit (Amount) </td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="availablelimit" id="availablelimit"  value="<?php echo $availablelimit;?>"   readonly="readonly"></td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Visit Days </span></td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><label><strong>

				   <input type="text" name="visitdays" id="visitdays" value="<?php echo $visitdays; ?>" readonly>

				  <input name="visittype" id="visittype" value="" type="hidden">

				  <input type="hidden" name="visitcount" id="visitcount"  value="<?php echo $visitcount;?>"   readonly="readonly">

				  </strong></label></td>

				</tr>

				

				<tr>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32" style="color:red" >*Department</span></td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5" ><strong>

				      <!-- <select name="department" id="department" onChange="return funcDepartmentChangeNew()" <?php //echo $readonly_copaycollect;?>>

                   		<?php //if($departmentanum != '') { ?>

						<option value="<?php //echo $departmentanum; ?>" selected="selected"><?php //echo $department; ?></option>

						<?php /* } 

						$query8 = "select * from master_department where  recordstatus <> 'deleted'";

						$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));

						while($res8 = mysqli_fetch_array($exec8))

						{

						$res8departmentanum = $res8['auto_number'];

						$res8department = $res8['department']; */

						?>

						<option value="<?php //echo $res8departmentanum; ?>"><?php //echo $res8department; ?></option>

						<?php //} ?>

                      </select> -->
					  
					  <input name="departmentname" id="departmentname" value="<?php echo $department; ?>" size='28' placeholder="Search Dept Here" autocomplete="off" <?php echo $readonly_copaycollect;?>/>
					<input type="hidden" name="department" id="department" value="<?php echo $departmentanum; ?>" />
					<input name="consultingdeptsearch" id="consultingdeptsearch" value="" type="hidden" />
					  

				  </strong></td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32" style="color:red" >*Consulting Doctor</span></td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><strong>

				    <input type="text" name="consultingdoctor" id="consultingdoctor" size='24' value="<?php echo $consultingdoctoranum; ?>" size="20" autocomplete="off" <?php echo $readonly_copaycollect;?>>

                     <input type="hidden" name="consultingdoctorcode" id="consultingdoctorcode" value="<?php echo $consultingdoctorcode; ?>" size="20">

                     <input name="consultingdoctorsearch" id="consultingdoctorsearch" value="" type="hidden" />

				  </strong></td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32"style="color:red" >* Fee Type</span></td>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5" <?php echo $readonly_copaycollect;?>>

				  <!--<input type="hidden" name="department" id="department" value="<?php echo $department; ?>" style="border: 1px solid #001E6A;"  size="20" />-->

				  <strong>

				  <select name="consultationtype" id="consultationtype" onChange="return funcConsultationTypeChange(this.value)" style="width:170px"  >

                    <option value="" selected="selected">Select Consultation Type</option>

                    <?php

						if ($consultingtype != '')

						{

						?>

                    <option value="<?php echo $consultingtypeanum; ?>" selected="selected"><?php echo $consultingtype; ?></option>

                    <?php

						}

			?>

                  </select>

				  </strong></td>
				  
				    <td align="left" valign="middle"  bgcolor="#ecf0f5" rowspan='2'>
                     <div id='copaymsg'>
					 
					 <?php
					// echo $planpercentageamount;
					// echo $planfixedamount;
					 if($planpercentageamount>0 || $planfixedamount>0){
                        echo "<span style='color:red;FONT-WEIGHT:bold;FONT-SIZE: 20px;'>COPAY TO BE COLLECTED </span>";
				      } 
					 ?> 
					 </div>
				  </td>

				</tr>

				<tr>

                <td width="16%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"> Visit Date</span></td>

                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input type="text" name="consultationdate" id="consultationdate" value="<?php echo $consultationdate; ?>" readonly></td>

                <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Time </span></td>

                <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="consultationtime" id="consultationtime" value="<?php echo $consultationtime; ?>" readonly size="10" />

                  <span class="bodytext32">(Ex: HH:MM)</span></td>

                <td align="left" valign="middle"  bgcolor="#ecf0f5"><span class="bodytext32">Consultation  Fees </span></td>

                <td align="left" valign="middle"  bgcolor="#ecf0f5">

				<input type="hidden" name="hospitalfees" id="hospitalfees">

				<input type="hidden" name="doctorfees" id="doctorfees">

				<input name="consultationfees" id="consultationfees" value="<?php echo $consultationfees; ?>" onFocus="return funcVisitEntryPatientCodeValidation1()"size="20" readonly/></td>
				
				

				</tr>

				 

				 <tr>

				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Member No</td>

				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="memberno"  type="" id="memberno" value="<?php echo $memberno; ?>" size="20" readonly /></td>

				   <td align="left" class="bodytext3">Plan Used</td>

               	   <td align="left" class="bodytext31"><input type="text" name="plandue" id="plandue" readonly value="<?php echo $overallplandue; ?>"></td>

				   <td align="left" valign="middle"  bgcolor="#ecf0f5" id='mccarea' <?php if($is_mcc==1){ } else { ?> style='display:none' <?php } ?>><!--<span class="bodytext32" style="color:red" >*MCC</span>--></td>

				   <td align="left" valign="middle"  bgcolor="#ecf0f5" id='mccareaval' <?php if($is_mcc==1){ } else { ?> style='display:none' <?php } ?>><input type='hidden' name="mccno" id="mccno" value="<?php echo $mccnumber;?>" size="20"  /></td>
                   
                    <td align="left" id="offslade" valign="middle"  bgcolor="#ecf0f5" class="bodytext3" 
                     <?php if(($smartap==2)||($smartap==3)){ ?>style="display:block"  <?php }else{ ?>style="display:none" <?php } ?>><label>OFFSLADE</label> &nbsp; 
                   <input type="checkbox" id="offpatient" name="offpatient" value="0" onClick="check_offpatient()" <?php if($offpatient == '1') { echo 'checked="checked"'; } ?> />
				

                   <input type="hidden" id="smart_ap" name="smart_ap" value="<?php echo $smartap;?>"/></td>
					
				<?php if($copay_forcebillstatus=='completed'){ ?>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" size="20"  >
					 <div style="color:red; FONT-WEIGHT:bold; FONT-SIZE: 20px;"> Force Copay ALready Colleted &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					  </div>
				  </td>
				 <?php } else if($planpercentageamount>0 || $planfixedamount>0){ ?>
				  <td align="left" valign="middle"  bgcolor="#ecf0f5" id="copayforce_pay"  >
					 <div style="color:red; FONT-WEIGHT:bold; FONT-SIZE: 16px;">
					  <input type="checkbox" id="copay_forcecheck" name="copay_forcecheck" <?php if($copay_forcecheck=='1'){ echo 'checked'; }?>  /> Force Copay
					  </div>
				  </td>
				 <?php } ?>
				 
				 
				  
				  
					
				 </tr>

				 

				 <tr>

				     <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">Smart Benefit No </span></td>

				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="smartbenefitno" id="smartbenefitno" value="<?= $smartbenefitno; ?>" size="20"  readonly/></td>

				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><label onClick="return enabtriage();">Admit ID </label></span></td>

				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="admitid" id="admitid" value="<?= $admitid; ?>" size="20" readonly/></td>

				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="referredby"  type="hidden" id="referredby" value="<?php echo $referredby; ?>" size="20" /><span id="savannah_authlb" class="bodytext32">Slade Authentication No</span></td>
				   <td align="left" valign="middle"  bgcolor="#ecf0f5"><input name="savannah_authid" id="savannah_authid"  size="20"  value="<?php echo $savannah_authid;?>"/><input name="savannah_authflag" id="savannah_authflag"  size="20" type="hidden" /></td>

				 </tr>

				 

				 <tr>


				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"style="color:red" >*Reason</span></td>


				   <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5"><textarea name='remarks' id='remarks' rows='5' cols='40'></textarea></td>


			      </tr>

				 <tr>

				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>

				   <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5"><input name="complaint"  type="hidden" id="complaint" value="<?php echo $complaint; ?>" style="border: 1px solid #001E6A;"  size="75" /></td>

			      </tr>

				 <tr>

				   <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>

				   <td colspan="5" align="left" valign="middle"  bgcolor="#ecf0f5">

				   <input type="hidden" name="consultationremarks" id="consultationremarks" value="<?php echo $consultationremarks; ?>" style="border: 1px solid #001E6A;"  size="75" /></td>

			      </tr>

				 <tr>

				   <td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>

			      </tr>

                 <tr>

                <td colspan="6" align="middle"  bgcolor="#ecf0f5"><div align="right"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">

                 
                  <input name="savannahvalid_from" id="savannahvalid_from" value="" type="hidden" />
				<input name="savannahvalid_to" id="savannahvalid_to" value="" type="hidden" />
				<input name="slade_authentication_token" id="slade_authentication_token" value="" type="hidden" />
                  <input type="hidden" name="frmflag1" value="frmflag1" />

                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />

                  <input name="Submit222" type="submit"  id="submit" value="Save Visit Entry (Alt+S)" accesskey="s" class="button" <?php if($smartap ==2 || $smartap ==3) echo "disabled"; ?>/>

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


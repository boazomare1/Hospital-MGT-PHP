<?php

session_start(); 

error_reporting(0);

//date_default_timezone_set('Asia/Calcutta');

include ("db/db_connect.php");

include ("includes/loginverify.php");

$updatedatetime = date("Y-m-d H:i:s");

$indiandatetime = date ("d-m-Y H:i:s");

$currentdate = date("Y-m-d");

$updatedate=date("Y-m-d");


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



 $docno = $_SESSION['docno'];

						

$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname limit 0,1";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res1 = mysqli_fetch_array($exec1))

{

$locationname = $res1["locationname"];

$locationcode = $res1["locationcode"];



}

						



$paynowbillprefix = 'EB-';

$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select billnumber from consultation_lab where billnumber like 'EB-%'

			union select billnumber from consultation_radiology where billnumber like 'EB-%'

			union select billnumber from consultation_services where billnumber like 'EB-%' order by billnumber desc";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

if($res2["billnumber"]=='')

{

$res2 = mysqli_fetch_array($exec2);

}

 $billnumber = $res2["billnumber"]; 

$billdigit=strlen($billnumber);

if ($billnumber == '')

{

	$billnumbercode ='EB-'.'1'."-".date('y');

	$openingbalance = '0.00';

}

else

{

	$billnumber = $res2["billnumber"];

	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

	//echo $billnumbercode;

	$billnumbercode = intval($billnumbercode);

	$billnumbercode = $billnumbercode + 1;



	$maxanum = $billnumbercode;

	

	

	$billnumbercode = 'EB-' .$maxanum."-".date('y');

	$openingbalance = '0.00';

	//echo $companycode;

}

$timestamp=date('H:i:s');

		//get locationcode and locationname here for insert

	

		//get locationcode ends here

		$billnumber=$billnumbercode;

		$consultationid=$billnumber;

		$billdate=$_REQUEST['billdate'];

		$referalname=$_REQUEST['referalname'];

		$billingtype = $_REQUEST['billtype'];



		
		$approvalstatus='';
	    $approvalvalue='';

	if($billingtype =='PAY NOW')
	{
	$status='completed';
	}
	else
	{
	   //$status='completed';
	  $status='completed';
	   $approvalstatus='1';
	   $approvalvalue=1;
	}





			$billnumbercode='';




		$query31 = "select radrefnoprefix from master_company where companystatus = 'Active'";

		$exec31= mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res31 = mysqli_fetch_array($exec31);

		$radrefnoprefix = $res31['radrefnoprefix'];

		$radrefnoprefix1=strlen($radrefnoprefix);

		$query21 = "select refno from consultation_radiology order by auto_number desc limit 0, 1";

	    $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res21 = mysqli_fetch_array($exec21);

		$radrefnonumber = $res21["refno"];

		$billdigit1=strlen($radrefnonumber);

		if ($radrefnonumber == '')

		{

		$radrefcode =$radrefnoprefix.'1';

		$openingbalance = '0.00';

		}

		else

		{

		$radrefnonumber = $res21["refno"];

		$radrefcode = substr($radrefnonumber,$radrefnoprefix1, $billdigit1);

		$radrefcode = intval($radrefcode);

		$radrefcode = $radrefcode + 1;

		$maxanum = $radrefcode;

		$radrefcode = $radrefnoprefix.$maxanum;

		$openingbalance = '0.00';

		//echo $companycode;

		}


 $query3 = "select labrefnoprefix from master_company where companystatus = 'Active'";

$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

$res3 = mysqli_fetch_array($exec3);

$labrefnoprefix = $res3['labrefnoprefix'];

$labrefnoprefix1=strlen($labrefnoprefix);

$query2 = "select refno from consultation_lab order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$labrefnonumber = $res2["refno"];

$billdigit=strlen($labrefnonumber);

if ($labrefnonumber == '')

{

	$labrefcode =$labrefnoprefix.'1';

	$openingbalance = '0.00';

}

else

{

	$labrefnonumber = $res2["refno"];

	$labrefcode = substr($labrefnonumber,$labrefnoprefix1, $billdigit);

	$labrefcode = intval($labrefcode);

	$labrefcode = $labrefcode + 1;

	$maxanum = $labrefcode;

	$labrefcode = $labrefnoprefix.$maxanum;

	$openingbalance = '0.00';

	//echo $companycode;

}

// services 
	$query31 = "select serrefnoprefix from master_company where companystatus = 'Active'";

		$exec31= mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res31 = mysqli_fetch_array($exec31);

		$serrefnoprefix = $res31['serrefnoprefix'];

		$serrefnoprefix1=strlen($serrefnoprefix);

		$query21 = "select refno from consultation_services order by auto_number desc limit 0, 1";

	    $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res21 = mysqli_fetch_array($exec21);

		$serrefnonumber = $res21["refno"];

		$billdigit1=strlen($serrefnonumber);

		if ($serrefnonumber == '')

		{

		$serrefcode =$serrefnoprefix.'1';

		$openingbalance = '0.00';

		}

		else

		{

		$serrefnonumber = $res21["refno"];

		$serrefcode = substr($serrefnonumber,$serrefnoprefix1, $billdigit1);

		$serrefcode = intval($serrefcode);

		$serrefcode = $serrefcode + 1;

		$maxanum = $serrefcode;

		$serrefcode = $serrefnoprefix.$maxanum;

		$openingbalance = '0.00';

		//echo $companycode;

		}

if (isset($_REQUEST["servicesitemcode"])) {  
	$servicesitemcode = $_REQUEST["servicesitemcode"];
} 
else { 
	$servicesitemcode = "";
}
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["refnumber"])) { $refnumber = $_REQUEST["refnumber"]; } else { $refnumber = ""; }

if($servicesitemcode !="") 
{

	// get package id from serviceitem code
	$pkgquery=mysqli_query($GLOBALS["___mysqli_ston"], "select auto_number from master_ippackage where servicescode='$servicesitemcode'");

	$execpkg=mysqli_fetch_array($pkgquery);

	$packageid = $execpkg['auto_number'];

	if($packageid > 0 && $patientcode !="" && $visitcode!="")
	{
		

		$Querylab=mysqli_query($GLOBALS["___mysqli_ston"], "select customerfullname from master_customer where customercode='$patientcode'");
		$execlab=mysqli_fetch_array($Querylab);
		$patientname = $execlab['customerfullname'];


		$Querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select billtype,accountname,locationcode from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'");
		$execlab1=mysqli_fetch_array($Querylab1);
		$billingtype      = $execlab1['billtype'];
		$accountname      = $execlab1['accountname'];

		$query111 = "select accountname from master_accountname where auto_number = '$accountname'";

		$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res111 = mysqli_fetch_array($exec111);

		$accountname = $res111['accountname'];
		//$locationcodeget  = $execlab1['locationcode'];

		/*$locationnameget = "";
		if($locationcodeget !="")
		{
			$Querylab1=mysql_query("select locationname from master_location where locationcode='$locationcodeget'");
			$execlab2=mysql_fetch_array($Querylab2);
			$locationnameget  = $execlab2['locationname'];
		}
		*/

		// get the lab package items

		$qrypackageitems = "select * from package_items where package_id = '$packageid' and recordstatus != 'deleted' and package_type='LI'";
			 
		$execpackageitems = mysqli_query($GLOBALS["___mysqli_ston"], $qrypackageitems) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		while($respackageitems = mysqli_fetch_array($execpackageitems))
		{
		 


		 $package_item_type = $respackageitems['package_type'];
		 $itemcode = $respackageitems['itemcode'];
		 $itemname = $respackageitems['itemname'];
		 $quantity = $respackageitems['quantity'];
		 $itemrate = $respackageitems['rate'];
		// $dose = $respackageitems['dose'];
		 //$dosemeasure = $respackageitems['dosemeasure'];
		// $frequency =   $respackageitems['frequency'];
		// $days = $respackageitems['days'];
		 //$amount = $respackageitems['amount'];
		 $locationname = $respackageitems['locationname'];
		// $locationcode = $respackageitems['locationcode'];


		   $query001="insert into consultation_lab(consultationid,patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,billtype,accountname,consultationdate,paymentstatus,billnumber,refno,labsamplecoll,resultentry,labrefund,urgentstatus,consultationtime,username,locationname,locationcode,approvalstatus,op_package_id)values('$consultationid','$patientcode','$patientname','$visitcode','$itemcode','$itemname','0','$billingtype','$accountname','$currentdate','$status','$consultationid','$labrefcode','pending','pending','norefund','$urgentstatus','$timestamp','$username','$locationname','$locationcode','$approvalstatus','$packageid')"; 

			 $labquery1=mysqli_query($GLOBALS["___mysqli_ston"], $query001) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  
		}


		// get the radiology package items

		$qrypackageitems = "select * from package_items where package_id = '$packageid' and recordstatus != 'deleted' and package_type='RI'";
			 
		$execpackageitems = mysqli_query($GLOBALS["___mysqli_ston"], $qrypackageitems) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		while($respackageitems = mysqli_fetch_array($execpackageitems))
		{
		 


		 $package_item_type = $respackageitems['package_type'];
		 $itemcode = $respackageitems['itemcode'];
		 $itemname = $respackageitems['itemname'];
		 $quantity = $respackageitems['quantity'];
		 $itemrate = $respackageitems['rate'];
		/* $dose = $respackageitems['dose'];
		 $dosemeasure = $respackageitems['dosemeasure'];
		 $frequency =   $respackageitems['frequency'];
		 $days = $respackageitems['days'];
		 $amount = $respackageitems['amount'];*/
		 $locationname = $respackageitems['locationname'];
		 //$locationcode = $respackageitems['locationcode'];


		 	$query1="insert into consultation_radiology(consultationid,patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,billtype,accountname,consultationdate,paymentstatus,refno,resultentry,consultationtime,username,locationname,locationcode,urgentstatus,approvalstatus,op_package_id)values('$consultationid','$patientcode','$patientname','$visitcode','$itemcode','$itemname','0','$billingtype','$accountname','$currentdate','$status','$radrefcode','pending','$timestamp','$username','$locationname','$locationcode','$urgentstatus1','$approvalstatus','$packageid')";

					

		$radiologyquery1=mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  
		}

			// get the services package items

		$qrypackageitems = "select * from package_items where package_id = '$packageid' and recordstatus != 'deleted' and package_type='SI'";
			 
		$execpackageitems = mysqli_query($GLOBALS["___mysqli_ston"], $qrypackageitems) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		while($respackageitems = mysqli_fetch_array($execpackageitems))
		{
		 


		 $package_item_type = $respackageitems['package_type'];
		 $itemcode = $respackageitems['itemcode'];
		 $itemname = $respackageitems['itemname'];
		 $quantity = $respackageitems['quantity'];
		 $itemrate = $respackageitems['rate'];
		
		 $locationname = $respackageitems['locationname'];
		 //$locationcode = $respackageitems['locationcode'];


		 	$query1="insert into consultation_services(consultationid,patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,serviceqty,amount,billtype,accountname,consultationdate,paymentstatus,refno,process,consultationtime,username,locationname,locationcode,approvalstatus,op_package_id)values('$consultationid','$patientcode','$patientname','$visitcode','$itemcode','$itemname','0','1','0','$billingtype','$accountname','$currentdate','$status','$serrefcode','pending','$timestamp','$username','$locationname','$locationcode','$approvalstatus','$packageid')";
		 	
					

		$servicequery1=mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  
		}

	}
	if($refnumber)
	{
		$updqry = "update consultation_services set process='completed' where auto_number='$refnumber'";
		
		mysqli_query($GLOBALS["___mysqli_ston"], $updqry) or die ("Error in Update Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	


}

	
header("location:oppackageprocesslist.php");

        exit;
		
?>



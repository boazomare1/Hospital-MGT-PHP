<?php
session_start();
include("db/db_connect.php");
include("includes/loginverify.php");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$docno = $_SESSION['docno'];

$query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by auto_number desc";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);

$locationname = $res1["locationname"];
$locationcode = $res1["locationcode"];

function calculate_age($birthday)

{

	if($birthday=="0000-00-00")

		return '0';

	

    $today = new DateTime();

    $diff = $today->diff(new DateTime($birthday));

    if ($diff->y)

    {

        return $diff->y.' Years';

    }

    elseif ($diff->m)

    {

        return $diff->m.' Months';

    }

    else

    {

        return $diff->d.' Days';

    }

}



$customer = trim($_REQUEST['term']);

$customersplit = explode('|',$customer);

$customersearch='';

//echo count($customersplit);

for($i=0;$i<count($customersplit);$i++)

{

	if(count($customersplit)=='1')

	{

		if($customersearch=='')

		{

			$customersearch = "(patientfirstname like '%$customersplit[$i]%' or patientmiddlename like '%$customersplit[$i]%' or patientlastname like '%$customersplit[$i]%' or patientcode like '%$customersplit[$i]%')";

		}

		else

		{

			$customersearch = $customersearch." or (patientfullname like '%$customersplit[$i]%')";

		}

	}

	else

	{

		

		if($customersearch=='')

		{

			if($i=='0')

			{

				$customersearch = "(patientfirstname like '%$customersplit[$i]%')";

			}

			else if($i=='1')

			{

				$customersearch = "(patientmiddlename like '%$customersplit[$i]%')";

			}

			else if($i=='2')

			{				

				$customersearch = "(patientlastname like '%$customersplit[$i]%')";

			}

			else if($i=='3')

			{

				$customersearch = "(patientcode like '%$customersplit[$i]%')";			

			}

		}

		else

		{

			if($i=='0')

			{

				$customersearch = $customersearch." and (patientfirstname like '%$customersplit[$i]%')";

			}

			else if($i=='1')

			{

				$customersearch = $customersearch." and (patientmiddlename like '%$customersplit[$i]%')";

			}

			else if($i=='2')

			{

				$customersearch = $customersearch." and (patientlastname like '%$customersplit[$i]%')";

			}

			else if($i=='3')

			{

				$customersearch = $customersearch." and (patientcode like '%$customersplit[$i]%')";

			}			

		}

	}

}

//echo $customersearch;

//$location = $_REQUEST['location'];

//echo $customer;

//$stringbuild1 = "";

$a_json = array();

$a_json_row = array();

$today=date('Y-m-d');

$lastdat = date('Y-m-d', strtotime('-2 days'));
$query1 = "select patientcode,visitcode,patientfullname,accountname,patientfirstname,patientmiddlename,patientlastname,age,gender,billtype, consultationtype, consultationfees, departmentname, consultingdoctor,planpercentage, planfixedamount from master_visitentry where ($customersearch) and visitcode not in(select visitcode from billing_paylater) and consultationdate between '$lastdat' and '$today' and locationcode='$locationcode' group by visitcode limit 20";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res1 = mysqli_fetch_array($exec1))

{

	$res1customercode = $res1['patientcode'];

	$res1visitcode = '';

	$res1billtype = $res1['billtype'];

	$res1customerfirstname=$res1['patientfirstname'];

	$res1customermiddlename=$res1['patientmiddlename'];

	$res1customerlastname=$res1['patientlastname'];

	$res1customerfullname=$res1['patientfullname'];

	$res1accountname = $res1['accountname'];

	$visitcode = $res1['visitcode'];

		$rowcount3=0;
			$checkstatus=0;
			$consultationtype = $res1['consultationtype'];
			  $consultationfees = $res1['consultationfees'];
			  $departmentname = $res1['departmentname'];
			  $consultingdoctor = $res1['consultingdoctor'];
			  $planpercentage = $res1['planpercentage'];
			  $planfixedamount = $res1['planfixedamount'];

			  if($consultationfees=='0' or $consultationfees=='0.00'){
			  	$rowcount3=1;
			  }
			  if($consultationfees>0){
			  if($res1billtype=='PAY LATER'){
			  	if($planpercentage>0 || $planfixedamount>0){
			  		$checkstatus=1;
			  	}if($planpercentage=='0.00' || $planfixedamount=='0.00'){
			  		$rowcount3=1;
			  	}
			  }
			  if($res1billtype=='PAY NOW' || $checkstatus>0){
             $query23s=mysqli_query($GLOBALS["___mysqli_ston"], "select consultationtype from master_consultationtype where auto_number = '$consultationtype'");
			 $exec23s=mysqli_fetch_array($query23s);
			 $consultationtype=$exec23s['consultationtype'];

			  $sql_chk="select visitcode from master_billing where visitcode='$visitcode' and consultingdoctor='$consultingdoctor' and department='$departmentname' and consultationfees='$consultationfees' and consultationtype='$consultationtype'";

			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $sql_chk) or die ("Error in sql_chk".mysqli_error($GLOBALS["___mysqli_ston"]));
		       $rowcount3 = mysqli_num_rows($exec3);
			   // if($rowcount3>0){
				  //  continue;
			   // }
		   	}
		} 



	$res1dateofbirth='';

	$res1gender = '';

	$planfixedamount='';

	$planpercentageamount='';



	$paymenttype='';

	$subtype='';
    $billtype='';
    $plannamenew ='';
	$consultationfees ='';
	$totaliplimit = '';

	$query001="select auto_number,visitcode,planfixedamount,planpercentage,paymenttype,subtype,billtype,planname,consultationfees,availablelimit from master_visitentry where patientcode='$res1customercode' and visitcode='$visitcode' order by auto_number desc";

	$exec001= mysqli_query($GLOBALS["___mysqli_ston"], $query001) or die ("Error in Query001".mysqli_error($GLOBALS["___mysqli_ston"]));

	if ($res001 = mysqli_fetch_array($exec001))
	{
	$auto_number = $res001['auto_number'];

	$res1visitcode = $res001['visitcode'];

	$planfixedamount=$res001['planfixedamount'];

	$planpercentageamount=$res001['planpercentage'];

	$paymenttype=$res001['paymenttype'];

	$subtype=$res001['subtype'];

	$subtype=trim($subtype);
	$billtype=$res001['billtype'];

	$plannamenew = $res001['planname'];
    $consultationfees = $res001['consultationfees'];
    $totaliplimit = $res001['availablelimit'];

	}
    $previousvisitcode ='';
	$query0011="select visitcode from master_visitentry where patientcode='$res1customercode' and auto_number < '$auto_number' order by auto_number desc limit 0,1";

	$exec0011= mysqli_query($GLOBALS["___mysqli_ston"], $query0011) or die ("Error in Query0011".mysqli_error($GLOBALS["___mysqli_ston"]));

	if ($res0011 = mysqli_fetch_array($exec0011))
	{
       $previousvisitcode = $res0011['visitcode'];
	}

    $curranticd=array();

	$query005="select primarydiag from consultation_icd where patientcode='$res1customercode' and patientvisitcode='$visitcode' order by auto_number desc";
	$exec005= mysqli_query($GLOBALS["___mysqli_ston"], $query005) or die ("Error in Query005".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res005 = mysqli_fetch_array($exec005))
	{
       $curranticd[]=$res005["primarydiag"];
	}

    if(count($curranticd)>0)
		$currenticd10=implode(",",$curranticd);
	else
		$currenticd10='';

	 $pasticd=array();

	if($previousvisitcode!=''){

	$query005="select primarydiag from consultation_icd where patientcode='$res1customercode' and patientvisitcode='$previousvisitcode' order by auto_number desc";
	$exec005= mysqli_query($GLOBALS["___mysqli_ston"], $query005) or die ("Error in Query005".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res005 = mysqli_fetch_array($exec005))
	{
       $pasticd[]=$res005["primarydiag"];
	}
	}

    if(count($pasticd)>0)
		$pasticd10=implode(",",$pasticd);
	else
		$pasticd10='';

	$totalserivces=0;
	$avaliable_limit_op =0;
	if($billtype=='PAY LATER')
	{
		$query222 = "select overalllimitop,opvisitlimit,planfixedamount from master_planname where auto_number = '$plannamenew'";
		$exec222=mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res222=mysqli_fetch_array($exec222);
		$overalllmt =$res222['overalllimitop'];
		$opvisitlimit =$res222['opvisitlimit'];
		$planfixedamount =$res222['planfixedamount'];
		//$totaliplimit = $overalllmt + $opvisitlimit + $planfixedamount; 

		$pharmrefund=0;
		$pharmcalcrate=0;
		$querybilpharm="select (amount-cash_copay) as pharmrate,medicinecode from master_consultationpharm  where patientcode = '$res1customercode' and  patientvisitcode='$visitcode' and  (paymentstatus = 'completed' and  approvalstatus <> '2') ";
		$execbilpharm=mysqli_query($GLOBALS["___mysqli_ston"], $querybilpharm) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		while ($resbilpharm=mysqli_fetch_array($execbilpharm))
		{
		$pharmrate=$resbilpharm['pharmrate'];
		$medicinecode=$resbilpharm['medicinecode'];
		$querybilpharm1="select totalamount as refundpharm from pharmacysalesreturn_details  where patientcode = '$res1customercode' and  visitcode='$visitcode' and itemcode ='".$medicinecode."' ";
		$execbilpharm1=mysqli_query($GLOBALS["___mysqli_ston"], $querybilpharm1) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		while ($resbilpharm1=mysqli_fetch_array($execbilpharm1))
		{
		$pharmrate1=$resbilpharm1['refundpharm'];
		$pharmrefund=$pharmrefund+$pharmrate1;
		}
		$pharmcalcrate=$pharmcalcrate+($pharmrate-$pharmrefund);
		}
		
		
		$query67 = "select sum(amount-cash_copay) as serviceamt from consultation_services where patientcode='$res1customercode' and patientvisitcode='$visitcode' and paymentstatus='completed'";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$num67 = mysqli_fetch_array($exec67);
		$serviceamt =$num67['serviceamt'];
		$query67 = "select sum(labitemrate-cash_copay) as labamt from consultation_lab where patientcode='$res1customercode' and patientvisitcode='$visitcode'  and labrefund<>'refund' and paymentstatus='completed'";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$num67 = mysqli_fetch_array($exec67);
		$labamt =$num67['labamt'];
		$query67 = "select sum(radiologyitemrate-cash_copay) as radamt from consultation_radiology where patientcode='$res1customercode' and patientvisitcode='$visitcode' and paymentstatus='completed' ";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]).__LINE__);
		$num67 = mysqli_fetch_array($exec67);
		$radamt =$num67['radamt'];
		$totalserivces = $consultationfees + $serviceamt + $labamt + $radamt+$pharmcalcrate;
		$avaliable_limit_op = $totaliplimit - $totalserivces;
		$avaliable_limit_op =number_format($avaliable_limit_op,2,'.',',');

	}



	$query01="select dateofbirth,gender from master_customer where customercode='$res1customercode'";

	$exec01= mysqli_query($GLOBALS["___mysqli_ston"], $query01) or die ("Error in Query01".mysqli_error($GLOBALS["___mysqli_ston"]));

	if ($res01 = mysqli_fetch_array($exec01))

	{

	$res1dateofbirth = $res01['dateofbirth'];

	$res1gender = $res01['gender'];

	}



	$res1age = calculate_age($res1dateofbirth);

		

	$query111 = "select accountname,iscapitation  from master_accountname where auto_number = '$res1accountname'";

	$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res111 = mysqli_fetch_array($exec111);

	$res111accountname = $res111['accountname'];
	$res111iscapitation = $res111['iscapitation'];

	

	$res1customercode = addslashes($res1customercode);

	



	$res1customercode = strtoupper($res1customercode);

	

	$res1customercode = trim($res1customercode);

	

	

	$res1customercode = preg_replace('/,/', ' ', $res1customercode);

	$res1customerfullname = preg_replace('/,/', ' ', $res1customerfullname);

	

	/*if ($stringbuild1 == '')

	{

		$stringbuild1 = ' '.$res1customerfullname.'#'.$res1customercode.'#'.$res111accountname.'#'.$res1mobilenumber.'#'.$res1nationalidnumber.' ';

	}

	else

	{

		$stringbuild1 = $stringbuild1.','.$res1customerfullname.'#'.$res1customercode.'#'.$res111accountname.'#'.$res1mobilenumber.'#'.$res1nationalidnumber.'';

	}*/

if($rowcount3>0){
	$a_json_row["patientfirstname"] = $res1customerfirstname;

	$a_json_row["patientmiddlename"] = $res1customermiddlename;

	$a_json_row["patientlastname"] = $res1customerlastname;

	$a_json_row["customercode"] = $res1customercode;

	$a_json_row["visitcode"] = $res1visitcode;

	$a_json_row["billtype"] = $res1billtype;

	$a_json_row["age"] = $res1age;

	$a_json_row["gender"] = $res1gender;

	$a_json_row["accountname"] = $res111accountname;
	$a_json_row["iscapitation"] = $res111iscapitation;

	

	$a_json_row["planfixedamount"] = $planfixedamount;

	$a_json_row["planpercentageamount"] = $planpercentageamount;

	$a_json_row["paymenttype"] = $paymenttype;

	$a_json_row["subtype"] = $subtype;
	$a_json_row["avaliable_limit_op"] = $avaliable_limit_op;	
	$a_json_row["currenticd"] = $currenticd10;	
	$a_json_row["previousicd"] = $pasticd10;	

	$a_json_row["value"] = trim($res1customerfullname);

	$a_json_row["label"] = trim($res1customerfullname).'#'.$res1customercode.'#'.$res1visitcode.'#'.$res111accountname;

	array_push($a_json, $a_json_row);

}
}

//echo $stringbuild1;

echo json_encode($a_json);

?>


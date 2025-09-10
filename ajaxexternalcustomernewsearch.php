<?php

session_start();

include ("db/db_connect.php");



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
$locationcode='';
$username = $_SESSION["username"];
 $docno = $_SESSION['docno'];
$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname limit 0,1";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res1 = mysqli_fetch_array($exec1))

{

$locationname = $res1["locationname"];

$locationcode = $res1["locationcode"];



}
$stringbuild1 = "";

$a_json = array();

$a_json_row = array();

$today=date('Y-m-d');

$lastdat = date('Y-m-d', strtotime('-2 days'));
$query1 = "select patientcode,visitcode,patientfullname,accountname,patientfirstname,patientmiddlename,patientlastname,age,gender,billtype, consultationtype, consultationfees, departmentname, consultingdoctor,planpercentage, planfixedamount,scheme_id from master_visitentry where ($customersearch)  and visitcode not in(select visitcode from billing_paylater) and consultationdate between '$lastdat' and '$today' and locationcode='$locationcode' group by visitcode limit 20";

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
	
	$scheme_id = $res1['scheme_id'];


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



	$query001="select visitcode,planfixedamount,planpercentage,paymenttype,subtype from master_visitentry where patientcode='$res1customercode' and visitcode='$visitcode'  order by auto_number desc";

	$exec001= mysqli_query($GLOBALS["___mysqli_ston"], $query001) or die ("Error in Query001".mysqli_error($GLOBALS["___mysqli_ston"]));

	if ($res001 = mysqli_fetch_array($exec001))

	{

	$res1visitcode = $res001['visitcode'];

	$planfixedamount=$res001['planfixedamount'];

	$planpercentageamount=$res001['planpercentage'];

	$paymenttype=$res001['paymenttype'];

	$subtype=$res001['subtype'];



	}



	$query01="select dateofbirth,gender from master_customer where customercode='$res1customercode'";

	$exec01= mysqli_query($GLOBALS["___mysqli_ston"], $query01) or die ("Error in Query01".mysqli_error($GLOBALS["___mysqli_ston"]));

	if ($res01 = mysqli_fetch_array($exec01))

	{

	$res1dateofbirth = $res01['dateofbirth'];

	$res1gender = $res01['gender'];

	}



	$res1age = calculate_age($res1dateofbirth);

	$query1118 = "select scheme_name from master_planname where scheme_id = '$scheme_id'";

	$exec1118 = mysqli_query($GLOBALS["___mysqli_ston"], $query1118) or die ("Error in Query1118".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res1118 = mysqli_fetch_array($exec1118);

	$scheme_name = $res1118['scheme_name'];	

	$query111 = "select accountname from master_accountname where auto_number = '$res1accountname'";

	$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res111 = mysqli_fetch_array($exec111);

	$res111accountname = $res111['accountname'];

	

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

	

	$a_json_row["planfixedamount"] = $planfixedamount;

	$a_json_row["planpercentageamount"] = $planpercentageamount;

	$a_json_row["paymenttype"] = $paymenttype;

	$a_json_row["subtype"] = $subtype;

	$a_json_row["scheme_name"] = $scheme_name;

	$a_json_row["value"] = trim($res1customerfullname);

	$a_json_row["label"] = trim($res1customerfullname).'#'.$res1customercode.'#'.$res1visitcode.'#'.$res111accountname;

	array_push($a_json, $a_json_row);

}
}
//echo $stringbuild1;

echo json_encode($a_json);

?>


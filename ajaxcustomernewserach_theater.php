<?php
//session_start();
include ("db/db_connect.php");
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
			$customersearch = "(patientname like '%$customersplit[$i]%' or patientcode like '%$customersplit[$i]%' or visitcode like '%$customersplit[$i]%')";
		}
		else
		{
			$customersearch = $customersearch." or (patientcode like '%$customersplit[$i]%' and visitcode like '%$customersplit[$i]%' )";
		}
	}
	else
	{
		if($customersearch=='')
		{
			if($i=='0')
			{
				$customersearch = "(patientname like '%$customersplit[$i]%')";
			}	
			else if($i=='6')
			{
				$customersearch = "(visitcode like '%$customersplit[$i]%')";					
			}
			else if($i=='7')
			{
				$customersearch = "(patientcode like '%$customersplit[$i]%')";
			}
		}
		else
		{
			if($i=='0')
			{
				$customersearch = $customersearch." and (patientname like '%$customersplit[$i]%')";
			}
			else if($i=='6')
			{
				$customersearch = $customersearch." and (visitcode like '%$customersplit[$i]%')";					
			}
			else if($i=='7')
			{
				$customersearch = $customersearch." and (patientcode like '%$customersplit[$i]%')";
			}
		}
	}
}
//echo $customersearch;
//$location = $_REQUEST['location'];
//echo $customer;
$stringbuild1 = "";
$a_json = array();
$a_json_row = array();
$query1 = "select patientcode,patientname,visitcode,accountname,paymentstatus,creditapprovalstatus from ip_bedallocation where ($customersearch) and recordstatus NOT IN ('discharged','transfered') order by auto_number desc limit 20";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$num59 = mysqli_num_rows($exec1);
if($num59 > 0)
{
while ($res1 = mysqli_fetch_array($exec1))
{
	$res1customercode = $res1['patientcode'];
	$res1customerfullname=$res1['patientname'];
	$res1nationalidnumber = $res1['visitcode'];
	$res1accountname = $res1['accountname'];
	$paymentstatus = $res1['paymentstatus'];
	$creditapprovalstatus = $res1['creditapprovalstatus'];
	
	$query1110 = "select accountname from master_ipvisitentry where visitcode = '$res1nationalidnumber'";
	$exec1110 = mysqli_query($GLOBALS["___mysqli_ston"], $query1110) or die ("Error in Query1110".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1110 = mysqli_fetch_array($exec1110);
	$res1110accountname = $res1110['accountname'];
	
	$query111 = "select accountname from master_accountname where auto_number = '$res1110accountname'";
	$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res111 = mysqli_fetch_array($exec111);
	$res111accountname = $res111['accountname'];
	$res1customercode = addslashes($res1customercode);
	$res1nationalidnumber = addslashes($res1nationalidnumber);
	$res1customercode = strtoupper($res1customercode);
	$res1nationalidnumber = strtoupper($res1nationalidnumber);
	$res1customercode = trim($res1customercode);
	$res1customercode = preg_replace('/,/', ' ', $res1customercode);
	$res1customerfullname = preg_replace('/,/', ' ', $res1customerfullname);

if($paymentstatus == '')
{
if($creditapprovalstatus == '')
{	
	$a_json_row["customercode"] = $res1customercode;
	$a_json_row["accountname"] = $res111accountname;
	$a_json_row["visitcode"] = $res1nationalidnumber;
	$a_json_row["value"] = trim($res1customerfullname);
	$a_json_row["label"] = trim($res1customerfullname).'#'.$res1nationalidnumber.'#'.$res1customercode.'#'.$res111accountname;
	array_push($a_json, $a_json_row);
}
}
}

//echo $stringbuild1;
} else{
$query1 = "select patientcode,patientname,visitcode,accountname from ip_bedtransfer where ($customersearch) and recordstatus NOT IN ('discharged','transfered') order by auto_number desc limit 20";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$num59 = mysqli_num_rows($exec1);	
while ($res1 = mysqli_fetch_array($exec1))
{
	$res1customercode = $res1['patientcode'];
	$res1customerfullname=$res1['patientname'];
	$res1nationalidnumber = $res1['visitcode'];
	$res1accountname = $res1['accountname'];
	
	$query1110 = "select accountname from master_ipvisitentry where visitcode = '$res1nationalidnumber'";
	$exec1110 = mysqli_query($GLOBALS["___mysqli_ston"], $query1110) or die ("Error in Query1110".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1110 = mysqli_fetch_array($exec1110);
	$res1110accountname = $res1110['accountname'];
	
	$query111 = "select accountname from master_accountname where auto_number = '$res1110accountname'";
	$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res111 = mysqli_fetch_array($exec111);
	$res111accountname = $res111['accountname'];
	$res1customercode = addslashes($res1customercode);
	$res1nationalidnumber = addslashes($res1nationalidnumber);
	$res1customercode = strtoupper($res1customercode);
	$res1nationalidnumber = strtoupper($res1nationalidnumber);
	$res1customercode = trim($res1customercode);
	$res1customercode = preg_replace('/,/', ' ', $res1customercode);
	$res1customerfullname = preg_replace('/,/', ' ', $res1customerfullname);

	
	$a_json_row["customercode"] = $res1customercode;
	$a_json_row["accountname"] = $res111accountname;
	$a_json_row["visitcode"] = $res1nationalidnumber;
	$a_json_row["value"] = trim($res1customerfullname);
	$a_json_row["label"] = trim($res1customerfullname).'#'.$res1nationalidnumber.'#'.$res1customercode.'#'.$res111accountname;
	array_push($a_json, $a_json_row);
}
	
}



echo json_encode($a_json);
?>
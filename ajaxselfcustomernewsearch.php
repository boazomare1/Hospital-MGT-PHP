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
			$customersearch = "(customername like '%$customersplit[$i]%' or customermiddlename like '%$customersplit[$i]%' or customerlastname like '%$customersplit[$i]%' or customerfullname like '%$customersplit[$i]%' or customercode like '%$customersplit[$i]%' or nationalidnumber like '%$customersplit[$i]%' or mobilenumber like '%$customersplit[$i]%' or dateofbirth like '%$customersplit[$i]' or area like '%$customersplit[$i]%' or memberno like '%$customersplit[$i]%')";
		}
		else
		{
			$customersearch = $customersearch." or (customercode like '%$customersplit[$i]%' and nationalidnumber like '%$customersplit[$i]%' and mobilenumber like '%$customersplit[$i]%' )";
		}
	}
	else
	{
		
		if($customersearch=='')
		{
			if($i=='0')
			{
				$customersearch = "(customername like '%$customersplit[$i]%')";
			}
			else if($i=='1')
			{
				$customersearch = "(customermiddlename like '%$customersplit[$i]%')";
			}
			else if($i=='2')
			{				
				$customersearch = "(customerlastname like '%$customersplit[$i]%')";
			}
			else if($i=='3')
			{
				$customersearch = "(dateofbirth like '%$customersplit[$i]%')";				
			}
			else if($i=='4')
			{
				$customersearch = "(area like '%$customersplit[$i]%')";				
			}
			else if($i=='5')
			{
				$customersearch = "(mobilenumber like '%$customersplit[$i]%')";						
			}
			else if($i=='6')
			{
				$customersearch = "(nationalidnumber like '%$customersplit[$i]%')";					
			}
			else if($i=='7')
			{
				$customersearch = "(customercode like '%$customersplit[$i]%')";
			}
			else if($i=='8')
			{
				$customersearch = "(memberno like '%$customersplit[$i]%')";
			}
		}
		else
		{
			if($i=='0')
			{
				$customersearch = $customersearch." and (customername like '%$customersplit[$i]%')";
			}
			else if($i=='1')
			{
				$customersearch = $customersearch." and (customermiddlename like '%$customersplit[$i]%')";
			}
			else if($i=='2')
			{
				$customersearch = $customersearch." and (customerlastname like '%$customersplit[$i]%')";
			}
			else if($i=='3')
			{
				$customersearch = $customersearch." and (dateofbirth like '%$customersplit[$i]%')";
			}
			else if($i=='4')
			{
				$customersearch = $customersearch." and (area like '%$customersplit[$i]%')";				
			}
			else if($i=='5')
			{
				$customersearch = $customersearch." and (mobilenumber like '%$customersplit[$i]%')";						
			}
			else if($i=='6')
			{
				$customersearch = $customersearch." and (nationalidnumber like '%$customersplit[$i]%')";					
			}
			else if($i=='7')
			{
				$customersearch = $customersearch." and (customercode like '%$customersplit[$i]%')";
			}
			else if($i=='8')
			{
				$customersearch = $customersearch." and (memberno like '%$customersplit[$i]%')";
			}
			
		}
	}
}

$stringbuild1 = "";
$a_json = array();
$a_json_row = array();
$query1 = "select customercode,customerfullname,nationalidnumber,mobilenumber,accountname,dateofbirth,area,customername,customermiddlename,customerlastname,age,gender from master_customer  where ($customersearch) and status <> 'Deleted' order by auto_number limit 20";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$res1customercode = $res1['customercode'];
	$res1customername=$res1['customername'];
	$res1customermiddlename=$res1['customermiddlename'];
	$res1customerlastname=$res1['customerlastname'];
	$res1customerfullname=$res1['customerfullname'];
	$res1age = $res1['age'];
	$res1gender = $res1['gender'];
	$res1nationalidnumber = $res1['nationalidnumber'];
	$res1mobilenumber = $res1['mobilenumber'];
	$res1accountname = $res1['accountname'];
	$res1dateofbirth = $res1['dateofbirth'];
	$res1area = $res1['area'];
	if($res1dateofbirth=='0000-00-00')
	{
		$res1dateofbirth='';
	}
	$query111 = "select accountname from master_accountname where auto_number = '$res1accountname'";
	$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res111 = mysqli_fetch_array($exec111);
	$res111accountname = $res111['accountname'];
	$res1customercode = addslashes($res1customercode);
	$res1nationalidnumber = addslashes($res1nationalidnumber);
	$res1mobilenumber = addslashes($res1mobilenumber);
	$res1customercode = strtoupper($res1customercode);
	$res1nationalidnumber = strtoupper($res1nationalidnumber);
	$res1mobilenumber = strtoupper($res1mobilenumber);
	$res1customercode = trim($res1customercode);
	$res1customercode = preg_replace('/,/', ' ', $res1customercode);
	$res1customerfullname = preg_replace('/,/', ' ', $res1customerfullname);
	
	$a_json_row["customercode"] = $res1customercode;
	$a_json_row["customername"] = $res1customername;
	$a_json_row["customermiddlename"] = $res1customermiddlename;
	$a_json_row["accountname"] = $res111accountname;
	$a_json_row["customerlastname"] = $res1customerlastname;
	$a_json_row["age"] = $res1age;
	$a_json_row["mobile"] = $res1mobilenumber;
	$a_json_row["gender"] = $res1gender;
	$a_json_row["value"] = trim($res1customerfullname);
	$a_json_row["label"] = trim($res1customerfullname).'#'.$res1dateofbirth.'#'.$res1area.'#'.$res1mobilenumber.'#'.$res1nationalidnumber.'#'.$res1customercode;
	array_push($a_json, $a_json_row);
}
//echo $stringbuild1;
echo json_encode($a_json);
?>
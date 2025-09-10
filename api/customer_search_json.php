<?php

header("Content-Type:application/json");

$hostname = '127.0.0.1';
$hostlogin = 'root';
$hostpassword = '@spyc3@1ct@2019';
$databasename = 'premier';

$link = ($GLOBALS["___mysqli_ston"] = mysqli_connect($hostname, $hostlogin, $hostpassword)) or die('Could not connect Table : ' . mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($GLOBALS["___mysqli_ston"], $databasename) or die('Could not select database'. mysqli_error($GLOBALS["___mysqli_ston"]));

if(isset($_REQUEST['term'])){
$customer = trim($_REQUEST['term']);
$customersplit = explode('|',$customer);
$customersearch='';

for($i=0;$i<count($customersplit);$i++)
{
	if(count($customersplit)=='1')
	{
		if($customersearch=='')
		{
			$customersearch = "(customername like '%$customersplit[$i]%' or customermiddlename like '%$customersplit[$i]%' or customerlastname like '%$customersplit[$i]%' or customercode like '%$customersplit[$i]%' or nationalidnumber like '%$customersplit[$i]%' or mobilenumber like '%$customersplit[$i]%' or dateofbirth like '%$customersplit[$i]' or area like '%$customersplit[$i]%')";
		}
		else
		{
			$customersearch = $customersearch." or customercode like '%$customersplit[$i]%' or nationalidnumber like '%$customersplit[$i]%' or mobilenumber like '%$customersplit[$i]%'";
		}
	}
	else
	{
		
		if($customersearch=='')
		{
			if($i=='3')
			{
				$customersearch = "(customername like '%$customersplit[$i]%')";
			}
			else if($i=='4')
			{
				$customersearch = "(customermiddlename like '%$customersplit[$i]%')";
			}
			else if($i=='5')
			{				
				$customersearch = "(customerlastname like '%$customersplit[$i]%')";
			}
			else if($i=='6')
			{
				$customersearch = "(dateofbirth like '%$customersplit[$i]%')";				
			}
			else if($i=='7')
			{
				$customersearch = "(area like '%$customersplit[$i]%')";				
			}
			else if($i=='1')
			{
				$customersearch = "(mobilenumber like '%$customersplit[$i]%')";						
			}
			else if($i=='2')
			{
				$customersearch = "(nationalidnumber like '%$customersplit[$i]%')";					
			}
			else if($i=='0')
			{
				$customersearch = "(customercode like '%$customersplit[$i]%')";
			}
		}
		else
		{
			if($i=='3')
			{
				$customersearch = $customersearch." and (customername like '%$customersplit[$i]%')";
			}
			else if($i=='4')
			{
				$customersearch = $customersearch." and (customermiddlename like '%$customersplit[$i]%')";
			}
			else if($i=='5')
			{
				$customersearch = $customersearch." and (customerlastname like '%$customersplit[$i]%')";
			}
			else if($i=='6')
			{
				$customersearch = $customersearch." and (dateofbirth like '%$customersplit[$i]%')";
			}
			else if($i=='7')
			{
				$customersearch = $customersearch." and (area like '%$customersplit[$i]%')";				
			}
			else if($i=='1')
			{
				$customersearch = $customersearch." and (mobilenumber like '%$customersplit[$i]%')";						
			}
			else if($i=='2')
			{
				$customersearch = $customersearch." and (nationalidnumber like '%$customersplit[$i]%')";					
			}
			else if($i=='0')
			{
				$customersearch = $customersearch." and (customercode like '%$customersplit[$i]%')";
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
$query1 = "select auto_number,customercode,customername,customermiddlename,customerlastname,customerfullname,gender,mothername,age,address1,address2,area,city,state,country,pincode,mobilenumber,dateofbirth,registrationdate,registrationtime,nationalidnumber,ageduration,salutation,username from master_customer where ($customersearch) and status <> 'Deleted'  order by auto_number limit 20";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{

	
	
		$auto_number = $res1['auto_number'];
		$customercode = $res1['customercode'];
		$customername = $res1['customername'];
		$customermiddlename = $res1['customermiddlename'];
		$customerlastname = $res1['customerlastname'];
		$customerfullname = $res1['customerfullname'];
		$gender = $res1['gender'];
		$mothername = $res1['mothername'];
		$age = $res1['age'];
		$address1 = $res1['address1'];
		$address2 = $res1['address2'];
		$area = $res1['area'];
		$city = $res1['city'];
		$state = $res1['state'];
		$country = $res1['country'];
		$pincode = $res1['pincode'];
		$mobilenumber = $res1['mobilenumber'];
		$dateofbirth = $res1['dateofbirth'];
		$registrationdate = $res1['registrationdate'];
		$registrationtime = $res1['registrationtime'];
		$nationalidnumber = $res1['nationalidnumber'];
		$ageduration = $res1['ageduration'];
		$salutation = $res1['salutation'];
		$username = $res1['username'];
	
		

	if($dateofbirth=='0000-00-00')
	{
		$dateofbirth='';
	}

	
	
$a_json_row["auto_number"] = $auto_number;
$a_json_row["customercode"] =$customercode;
$a_json_row["customername"] =$customername;
$a_json_row["customermiddlename"] =$customermiddlename;
$a_json_row["customerlastname"] =$customerlastname;
$a_json_row["customerfullname"] =$customerfullname;
$a_json_row["salutation"] =$salutation;
$a_json_row["gender"] =$gender;
$a_json_row["mothername"] =$mothername;
$a_json_row["age"] =$age;		
$a_json_row["ageduration"] =$ageduration;		
$a_json_row["area"] =$area;		
$a_json_row["city"] =$city;		
$a_json_row["state"] =$state;		
$a_json_row["pincode"] =$pincode;		
$a_json_row["country"] =$country;		
$a_json_row["mobilenumber"] =$mobilenumber;		
$a_json_row["nationalidnumber"] =$nationalidnumber;		
$a_json_row["registrationdate"] =$registrationdate;		
$a_json_row["registrationtime"] =$registrationtime;		
$a_json_row["biometricinfo"] ="NA";		
$a_json_row["biludate"] =null;		
$a_json_row["patientBioMetricInfo"] =array();

 
 $query2 = "SELECT pfpi_index,pfpi_fingerprint FROM `patient_fingerprint_info` WHERE `patn_id` = '$auto_number'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res2 = mysqli_fetch_array($exec2))
{
		$pfpi_index = $res2['pfpi_index'];
		$pfpi_fingerprint = $res2['pfpi_fingerprint'];

 $input1= array(
               "pfpi_index"=> $pfpi_index,
                "pfpi_fingerprint"=> $pfpi_fingerprint
            );
				array_push($a_json_row["patientBioMetricInfo"], $input1);



}

          
	
	array_push($a_json, $a_json_row);
		

	

}
echo json_encode($a_json);

}
?>
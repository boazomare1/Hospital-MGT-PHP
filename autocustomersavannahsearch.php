<?php
$hostname = '127.0.0.1';
$hostlogin = 'root';
$hostpassword = '';
$databasename = 'policyplus';
date_default_timezone_set('Africa/Nairobi'); 
//Folder Name Change Only Necessary
$result = array();
$link = ($GLOBALS["___mysqli_ston"] = mysqli_connect($hostname, $hostlogin, $hostpassword)) or die('Could not connect Database : ' . mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($GLOBALS["___mysqli_ston"], $databasename) or die('Could not select database'. mysqli_error($GLOBALS["___mysqli_ston"]));
$customersearch = $_REQUEST['memberno'];

$query1 = "select * from exchange_files where Member_Nr = '$customersearch' and Progress_Flag = '1'";
//$query1 = "select * from exchange_files where Progress_Flag = '1'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$num = mysqli_num_rows($exec1);


	$Smart_File = $res1['Smart_File'];
	$Admit_ID = $res1['Admit_ID'];
//echo $Member_Nr = $res1['Member_Nr'];
	//echo $Smart_Date = $res1['Smart_Date'];
	
	 $myXMLData = $Smart_File;
	
	if($num > 0)
	{
		$xml=simplexml_load_string($myXMLData) or die("Error: Cannot create object");
		$result['has_op'] = trim($xml->has_outpatient);
		$result['has_ip'] = trim($xml->has_inpatient);
		$result['valid_from'] = date('Y-m-d H:i:s',strtotime($xml->valid_from));
		$result['valid_to'] = date('Y-m-d H:i:s',strtotime($xml->valid_to));
		$result['slade_authentication_token'] = trim($xml->slade_authentication_token);
		$result['payer_code'] =trim($xml->payer_code);
		$result['visit_limit'] =trim($xml->visit_limit);
	//$sql = "UPDATE exchange_files SET Progress_Flag = '2' WHERE Member_Nr = '$memberno' AND Progress_Flag = '1'";
	}
	else
	{
	//$sql = "UPDATE exchange_files SET Progress_Flag = '3' WHERE Member_Nr = '$memberno' AND Progress_Flag = '1'";
	}
	//$update_id = mysql_query($sql);
	echo json_encode($result);
?>

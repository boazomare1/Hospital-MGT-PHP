<?php

//session_start();

include ("../db/db_connect.php");

 
/*$customer = trim($_REQUEST['term']);



$customersearch='';

//echo count($customersplit);



//echo $customersearch;

//$location = $_REQUEST['location'];

//echo $customer;

$stringbuild1 = "";

$a_json = array();

$a_json_row = array();

$query1 = "select doctorcode as id,doctorname as accountname,auto_number,'' as accountsmain from master_doctor where (doctorname like '$customer%' or doctorname like '% $customer%') and status <> 'Deleted' and is_staff <>'1' order by doctorname)";
//echo $query1;

$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());

while ($res1 = mysql_fetch_array($exec1))

{

	$id = $res1["id"];

	$accountname = $res1["accountname"];

	$accountsmain = $res1["accountsmain"];

	$acccountanum = $res1['auto_number'];

	$a_json_row["id"] = trim($id);

	$a_json_row["anum"] = trim($acccountanum);

	$a_json_row["value"] = trim($accountname);

	$a_json_row["label"] = trim($accountname);

	array_push($a_json, $a_json_row);

}

//echo $stringbuild1;

echo json_encode($a_json);*/

?>


<?php







 $process=$_REQUEST['term'];



$a_json = array();

$a_json_row = array();

 $query1 = "select doctorcode as id,doctorname as accountname,auto_number,'' as accountsmain from master_doctor where doctorname like '%$process%'  and status <> 'Deleted' and is_staff <>'1' order by doctorname";
//echo $query1;

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res1 = mysqli_fetch_array($exec1))

{

	$id = $res1['id'];

	$accountname = $res1['accountname'];

	
	

	$a_json_row["id"] = trim($id);

	$a_json_row["accountname"] = trim($accountname);

	$a_json_row["value"] = trim($accountname);

	$a_json_row["label"] = $accountname;

	

	

	array_push($a_json, $a_json_row);  

}



echo json_encode($a_json);





?>

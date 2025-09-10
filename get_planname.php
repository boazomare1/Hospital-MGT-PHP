<?php

//session_start();

include ("db/db_connect.php");



$stringbuild1 = "";

$sourcesearch = $_REQUEST["sourcesearch"];
$plansearch = $_REQUEST["term"];

$a_json = array();

$a_json_row = array();

$subtype_name='';

if($sourcesearch=='Scheme')
{
//and recordstatus = 'ACTIVE'
 $query111 = "select scheme_name as scheme_name,null as subtype from master_planname where scheme_name like '%$plansearch%' ";
}
else
{

$query22 = "select auto_number from master_subtype where subtype like '%$plansearch%'";
$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
$res22 = mysqli_fetch_array($exec22);
$subtype = $res22['auto_number'];	

if($subtype!='')
{
$pass_sub = "subtype ='$subtype'"; 
}
else
{
$pass_sub ="subtype like '%%' ";
}

	
 $query111 = "select null as scheme_name,subtype as subtype from master_planname where $pass_sub and recordstatus = 'ACTIVE' group by subtype";
}
$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die("Error in Query111" . mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res111 = mysqli_fetch_array($exec111)) 
{
$scheme_name = $res111['scheme_name'];
$sub_type = $res111['subtype'];
if($sub_type!='')
{
  $query221 = "select subtype from master_subtype where auto_number='$sub_type'";
$exec221 = mysqli_query($GLOBALS["___mysqli_ston"], $query221) or die ("Error in Query221".mysqli_error($GLOBALS["___mysqli_ston"]));
$res221 = mysqli_fetch_array($exec221);
 $subtype_name = $res221['subtype'];
}

if($subtype_name!='')
{
	$subtype_name = preg_replace('/,/', ' ', $subtype_name); 
	$a_json_row["value"] = $subtype_name;
	$a_json_row["id"] = $sub_type;

	$a_json_row["genericname"] = $subtype_name;
	

	array_push($a_json, $a_json_row);
}
else if($scheme_name!='')
{
	$scheme_name = preg_replace('/,/', ' ', $scheme_name); 
	$a_json_row["value"] = $scheme_name;
	$a_json_row["id"] = $sub_type;
	$a_json_row["genericname"] = $scheme_name;
	

	array_push($a_json, $a_json_row);
	
}


	

}



echo json_encode($a_json);





?>
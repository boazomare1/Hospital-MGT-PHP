<?php

//session_start();

include ("db/db_connect.php");

$res12paymenttypeanum = $_GET['res12paymenttypeanum'];

$searchsuppliername1 = $_REQUEST['term'];

$stringbuild1 = "";


$a_json = array();

$a_json_row = array();



  $query2 = "select * from master_subtype where maintype = '$res12paymenttypeanum' and recordstatus = '' and subtype like '%$searchsuppliername1%' order by subtype";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res2 = mysqli_fetch_array($exec2))

{

	$res2anum = $res2['auto_number'];

	$res2subtype = $res2['subtype'];
	
	
 $query1s = "select auto_number from master_consultationtype where paymenttype='$res12paymenttypeanum' and subtype='$res2anum'";
$exec1s = mysqli_query($GLOBALS["___mysqli_ston"], $query1s) or die ("Error in query1s".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1s = mysqli_fetch_array($exec1s);
$consultation_id=$res1s['auto_number'];
if($consultation_id!='')
{
 $query1s1 = "select auto_number from locationwise_consultation_fees where  consultation_id='$consultation_id'";
$exec1s1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1s1) or die ("Error in query1s1".mysqli_error($GLOBALS["___mysqli_ston"]));
$num1s1 = mysqli_num_rows($exec1s1);
}
else
{
	$num1s1=0;
}
if($num1s1<=0)
{


	

	$res2subtype = addslashes($res2subtype);



	$res2subtype = strtoupper($res2subtype);

	

	$res2subtype = trim($res2subtype);

	

	$res2subtype = preg_replace('/,/', ' ', $res2subtype); // To avoid comma from passing on to ajax url.
	
	$a_json_row["value"] = $res2subtype;

	$a_json_row["subtypeid"] = $res2anum;
	
	$a_json_row["label"] = $res2subtype;
	

	array_push($a_json, $a_json_row);

   }

}




echo json_encode($a_json);







?>
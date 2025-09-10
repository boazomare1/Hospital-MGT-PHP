<?php

//session_start();

include ("db/db_connect.php");

if (isset($_REQUEST["res12paymenttypeanum"])) { $res12paymenttypeanum = $_REQUEST["res12paymenttypeanum"]; } else { $res12paymenttypeanum = ""; }

$searchsuppliername1 = $_REQUEST['term'];


if (isset($_REQUEST["searchsource"])) { $searchsource = $_REQUEST["searchsource"]; } else { $searchsource = ""; }

$stringbuild1 = "";


$a_json = array();

$a_json_row = array();

if($searchsource=='billestimate')
{
 $query2 = "select * from master_subtype where subtype like '%$searchsuppliername1%' and recordstatus = '' order by maintype";
	
}
else
{
 $query2 = "select * from master_subtype where maintype = '$res12paymenttypeanum' and recordstatus = '' and subtype like '%$searchsuppliername1%' order by subtype";
}

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res2 = mysqli_fetch_array($exec2))

{

	$res2anum = $res2['auto_number'];

	$res2subtype = $res2['subtype'];

	

	$res2subtype = addslashes($res2subtype);



	$res2subtype = strtoupper($res2subtype);

	

	$res2subtype = trim($res2subtype);

	

	$res2subtype = preg_replace('/,/', ' ', $res2subtype); // To avoid comma from passing on to ajax url.
	
	$a_json_row["value"] = $res2subtype;

	$a_json_row["subtypeid"] = $res2anum;
	
	$a_json_row["label"] = $res2subtype;
	

	array_push($a_json, $a_json_row);

	
/*
	if ($stringbuild1 == '')
	{
		$stringbuild1 = ''.$res2anum.' #'.$res2subtype.'';

	}

	else
	{

	$stringbuild1 = $stringbuild1.','.$res2anum.' #'.$res2subtype.'';

	}*/

}




echo json_encode($a_json);







?>
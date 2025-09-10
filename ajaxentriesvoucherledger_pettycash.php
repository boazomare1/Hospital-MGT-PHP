<?php
//session_start();
include ("db/db_connect.php");

$stringbuild1 = "";
$term = trim(strip_tags($_GET['term'])); 

//$action = trim(strip_tags($_REQUEST['action'])); 
//$voucher = trim(strip_tags($_REQUEST['voucher'])); 
//$term ='Fredrick Kimathi Muriungi';
$a_json = array();
$a_json_row = array();
//subledger('40',$term);
flush();
$ledgertype = "";
$slo = 0;
$ledgerbuild = "";
subgroup($term);
	
function subgroup($term)
{
function processReplacement($one, $two)
{
  return $one . strtoupper($two);
}
global $a_json_row;
global $a_json;
$type = $_REQUEST['type'];
$location = $_REQUEST['location'];
	if($type=='Cr'){
	$query2 = "select * from master_accountname where accountname like '%$term%' and recordstatus <> 'deleted' and id <> '' and locationcode='$location' and accountssub='9' order by auto_number desc";
	}else{
	$query2 = "select * from master_accountname where accountname like '%$term%' and recordstatus <> 'deleted' and id <> ''  and accountsmain='6' order by auto_number desc";	
	}
	
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res2 = mysqli_fetch_array($exec2))
	{
		
		$res2subtype = $res2['accountname'];
		$accountsmain = $res2['accountsmain'];
		$accountssub = $res2['accountssub'];	
		
		$query11 = "select auto_number,accountsmain from master_accountsmain where auto_number = '$accountsmain'";
	    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res11 = mysqli_fetch_array($exec11);
		$accountsmain1 = $res11['accountsmain'];
		$ledgergroupid = $res11['auto_number'];
		
		$query12 = "select accountssub from master_accountssub where auto_number = '$accountssub'";
	    $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res12 = mysqli_fetch_array($exec12);
		$accountssub1 = $res12['accountssub'];
		
		$res2subtype = trim($res2subtype);
		
		$res2subtype = preg_replace('/,/', ' ', $res2subtype); // To avoid comma from passing on to ajax url.
		$res2subtype=ucfirst(strtolower($res2subtype));
		
		$res2subtype=preg_replace("/(^|[^a-zA-Z])([a-z])/e","processReplacement('$1', '$2')", $res2subtype);
		
		$res2docno = $res2['id'];
		$billwise = '';	
		
		$res2docno = trim($res2docno);
		
		$a_json_row["id"] = $res2docno;
		$a_json_row["billwise"] = $billwise;
		$a_json_row["ledgergroupid"] = $ledgergroupid;
		$a_json_row["value"] = $res2subtype;
		$a_json_row["label"] = $res2subtype.' | '.$accountsmain1.' | '.$accountssub1;
		array_push($a_json, $a_json_row);
		
	}
//$a_json_row = array();
echo json_encode($a_json);	
}
?>
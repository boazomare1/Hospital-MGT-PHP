<?php
include ("db/db_connect.php");
/*$speacility = $_REQUEST['state'];*/
$term = trim(strip_tags($_GET['term'])); 
$a_json = array();
$a_json_row = array();




$query_s = "SELECT a.auto_number,a.speaciality_subtype_name,b.speaciality_name FROM master_theatrespeaciality_subtype a  LEFT JOIN master_theatrespeaciality b ON b.auto_number= a.speaciality_id WHERE a.record_status <> 'deleted' and a.speaciality_subtype_name like '%$term%'";
$exec_s = mysqli_query($GLOBALS["___mysqli_ston"], $query_s) or die ("Error in Query_s".mysqli_error($GLOBALS["___mysqli_ston"]));



/*echo "<option value=''>Select Services</option>";*/
while ($res_s = mysqli_fetch_assoc($exec_s))
{  
	 $id = $res_s['auto_number'];
	$procedure_name=$res_s['speaciality_subtype_name'];

	$spname=$res_s['speaciality_name'];

	$a_json_row["label"] = $procedure_name . '' .' - ' . $spname;
	$a_json_row["docid"] = $id;
	/*$a_json_row["spname"] = $spname;*/



	
	
	
	array_push($a_json, $a_json_row);
}

echo json_encode($a_json);

?>

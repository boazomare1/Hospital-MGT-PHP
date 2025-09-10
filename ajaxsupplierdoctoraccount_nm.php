<?php



include ("db/db_connect.php");



 $process=$_REQUEST['term'];



$a_json = array();

$a_json_row = array();

 $query1 = " (select id,accountname,accountssub,@v1:='supplier' as type from master_accountname where accountssub = '12' and accountname like '%$process%' and recordstatus <> 'Deleted' order by accountname limit 15 ) union (select doctorcode as id,doctorname as accountname,'' as accountssub,@v2:='doctor' as type from master_doctor where doctorname like '%$process%'  and status <> 'Deleted' and is_staff <>'1' order by doctorname )";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

while ($res1 = mysqli_fetch_array($exec1))

{

	$id = $res1['id'];

	$accountname = $res1['accountname'];

	$accountssubanum = $res1['accountssub'];

	$type = $res1['type'];

	$query77 = mysqli_query($GLOBALS["___mysqli_ston"], "select accountssub from master_accountssub where auto_number = '$accountssubanum'") or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res77 = mysqli_fetch_array($query77);

	$accountssub = $res77['accountssub'];

	

	$a_json_row["id"] = trim($id);

	$a_json_row["accountname"] = trim($accountname);

	$a_json_row["value"] = trim($accountname);

	$a_json_row["label"] = $accountname.' || '.$accountssub;

	$a_json_row["type"] = $type;

	

	

	array_push($a_json, $a_json_row);  

}



echo json_encode($a_json);





?>
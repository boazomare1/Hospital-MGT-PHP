<?php 
ini_set('max_execution_time', '0');
ini_set("memory_limit",'1024M');
include ("db/db_connect.php");


// tbtemp
$noof_updated_rows = 0;
$updated_rows = 0;
$query = "select auto_number,patientcode,patientname,visitcode,refno,itemcode,itemname
          from tbtemp ";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in  select Query".mysqli_error($GLOBALS["___mysqli_ston"]));

 while($res = mysqli_fetch_array($exec))
 {

 	$tb_auto_number = $res['auto_number'];
 	
 
	    $patientcode    = $res['patientcode'];
	 	$patientname    = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $res['patientname']);
	 	$visitcode      = $res['visitcode'];
	 	$ref_no         = $res['refno'];
	 	$itemcode       = $res['itemcode'];
	 	$itemname       = $res['itemname'];
 		
	 
 	
 	$query_inner = "update tb set 
 	           patientcode = '$patientcode',
 	           patientname = '$patientname',
 	           visitcode   = '$visitcode',
 	           refno       = '$ref_no',
 	           itemcode    = '$itemcode',
 	           itemname    = '$itemname'
	           where auto_number=$tb_auto_number";

 mysqli_query($GLOBALS["___mysqli_ston"], $query_inner) or die ("Error in  Update Query".mysqli_error($GLOBALS["___mysqli_ston"]));

	$noof_updated_rows = mysqli_affected_rows($GLOBALS["___mysqli_ston"]);

	$updated_rows = $updated_rows + $noof_updated_rows;
	

 }

echo $updated_rows." Rows updated in tb <br>";

((mysqli_free_result($exec) || (is_object($exec) && (get_class($exec) == "mysqli_result"))) ? true : false); 

?>
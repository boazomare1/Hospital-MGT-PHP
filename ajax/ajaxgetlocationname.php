
<?php
include ("../db/db_connect.php");

 $loccode=isset($_REQUEST['loccode'])?$_REQUEST['loccode']:'';?>
<strong>Location: </strong>
<?php  $query10 = "select locationname from master_location where locationcode='".$loccode."' and status <> 'deleted'";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res10 = mysqli_fetch_array($exec10);
		
		//$loopcount = $loopcount+1;
		//$res10plannameanum = $res10["auto_number"];
		echo $locationname=$res10["locationname"];
        ?>
       
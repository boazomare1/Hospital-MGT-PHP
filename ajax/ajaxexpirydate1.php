<?php

include ("../db/db_connect.php");



 $accname=isset($_REQUEST['accname'])?$_REQUEST['accname']:'';?>



<?php $query10 = "select expirydate from master_accountname where accountname = '$accname' and expirydate > NOW() and recordstatus <> 'deleted' ";

		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res10 = mysqli_fetch_array($exec10);

		

		//$res10plannameanum = $res10["auto_number"];


	echo	$expdate=isset($res10["expirydate"])?$res10["expirydate"]:'';

		//$exodate=

        ?>

      
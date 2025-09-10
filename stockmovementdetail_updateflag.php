<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$anum = $_REQUEST['anum'];
$st = $_REQUEST['st'];

if($st == '0'){
	$q1="update `transaction_stock` SET `cum_stockstatus` = '1', batch_stockstatus = '1' WHERE `transaction_stock`.`auto_number` = $anum";
} else {
	$q1="update `transaction_stock` SET `cum_stockstatus` = '0', batch_stockstatus = '0' WHERE `transaction_stock`.`auto_number` = $anum";
}
if(mysqli_query($GLOBALS["___mysqli_ston"], $q1))
{		
?>
<script>
window.close();
</script>
<?php
}
?>
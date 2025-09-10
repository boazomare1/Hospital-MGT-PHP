<?php
session_start();

include ("db/db_connect.php");
$recorddate = date('Y-m-d');
$recordtime = date('H:i:s');
$updatetime = date('Y-m-d H:i:s');
$user = $_SESSION['username'];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$labcode = $_REQUEST['labcode'];
$sno=0;
$query13 = "select referencename,refcode from master_labreference where itemcode='$labcode' and status<>'deleted'";
$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res13 = mysqli_fetch_array($exec13))
{
$referencename = $res13["referencename"];
$refcode = $res13["refcode"];
$sno=$sno+1;
?>
<tr>
 <td><input name="reference[]" type="text" id="reference<?php echo $sno; ?>" size="35" value="<?php echo $referencename; ?>" readonly="readonly"></td>
 <td> <input name="referencecode[]" type="text" id="referencecode<?php echo $sno; ?>" size="5" value="<?php echo $refcode; ?>"></td>
 </tr>
<?php
}
?>
 <?php 
 session_start();

 include ("db/db_connect.php");

 $i=0;
$loopcontrol='1';
$actkey=isset($_REQUEST['actkey'])?$_REQUEST['actkey']:'';
$autkey=isset($_REQUEST['autkey'])?$_REQUEST['autkey']:'';
$delkey=isset($_REQUEST['delkey'])?$_REQUEST['delkey']:'';

if($actkey==1)
{
	$query66 ="DELETE FROM tempmedicineqty WHERE medicinekey = '".$delkey."'";
				
				$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	else
	{
	$query66 ="DELETE FROM tempmedicineqty WHERE auto_number = '".$autkey."'";
				
				$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			//	echo "fasdfadsfadsfasdf";
	}

?>


 
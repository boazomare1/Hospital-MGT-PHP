 <?php 
 session_start();

 include ("db/db_connect.php");

 $i=0;
$loopcontrol='1';
$medcod=isset($_REQUEST['medcod'])?$_REQUEST['medcod']:'';
$mednam=isset($_REQUEST['mednam'])?$_REQUEST['mednam']:'';
$batnam=isset($_REQUEST['batnam'])?$_REQUEST['batnam']:'';
$avlqty=isset($_REQUEST['avlqty'])?$_REQUEST['avlqty']:'';
$medkey=isset($_REQUEST['medkey'])?$_REQUEST['medkey']:'';
$fifo=isset($_REQUEST['fifo'])?$_REQUEST['fifo']:'';
//$autkey=isset($_REQUEST['autkey'])?$_REQUEST['autkey']:'';
//$autkey=35;


$query66 ="insert into tempmedicineqty(medicinename,medicinecode,batchname,availableqty,medicinekey,fifo_code)values('".$mednam."','".$medcod."','".$batnam."','".$avlqty."','".$medkey."','".$fifo."')";
				
				$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	//	echo	$curid =	"SELECT SCOPE_IDENTITY($exec66)";
	//	echo insert_id($exec66);
	//	echo $exec66->insert_id;
		echo ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
		//echo "f";

?>



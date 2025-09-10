 <?php 
session_start();
include ("../db/db_connect.php"); 

//$json = array('status'=>0,'msg'=>"Failed to update the cash");
$json = '0||fail';

$physical_cash   =   str_replace(",","", $_REQUEST['physicalcash']);
$docautono   =    $_REQUEST['locdocno'];

/*if($docautono)
{
	$cash_update_qry = "update details_login set physical_cash = '".$physical_cash."' where docno = '$docautono'";
	$exec4 = mysql_query($cash_update_qry) or die ("Error in Update Query".mysql_error());
	// record updated successfully
	//$json = array('status'=>1,'msg'=>"Cash  inserted successfully.");
	$json =  '1||success';
}*/
//echo json_encode($json);
//echo $json;



if (isset($_SESSION["username"]))
{
	
	$username = $_SESSION["username"];
			$query31 = "select auto_number, shiftouttime,physical_cash from shift_tracking where username = '$username'  order by auto_number desc limit 0, 1";
			$exe31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res31 = mysqli_fetch_array($exe31);
			 $res31anum = $res31["auto_number"];
			 $shiftouttime = $res31["shiftouttime"];
			 $physical_cash2 = $res31["physical_cash"];

			 
	if($shiftouttime == '0000-00-00 00:00:00' || $physical_cash2<=0)
	{		
	 $updatedatetime = date('Y-m-d H:i:s');
	 $query1 = "update shift_tracking set shiftouttime = '$updatedatetime',physical_cash = '".$physical_cash."' where username = '$username' and auto_number = '$res31anum' ";
	 $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	 $json =  '1||success';
	}else
	{
		 $json =  '2||'.$physical_cash2;

	}
	
}
echo $json;
?>
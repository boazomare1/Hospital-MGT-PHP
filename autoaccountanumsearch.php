<?php
session_start();
include ("db/db_connect.php");
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$consultationdate = date('Y-m-d');
//$customersearch = strtoupper($customersearch);
$searchresult = "";
$availablelimit = "";

$location= $_REQUEST["location"];
$accountsmain= $_REQUEST["accountsmain"];
$accountssub= $_REQUEST["accountssub"];

$query8 = "select * from master_location where locationcode = '$location'";
$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
$res8 = mysqli_fetch_array($exec8);
$locationprefix = $res8['prefix'];

$query82 = "select * from master_accountssub where auto_number = '$accountssub'";
$exec82 = mysqli_query($GLOBALS["___mysqli_ston"], $query82) or die ("Error in Query82".mysqli_error($GLOBALS["___mysqli_ston"]));
$res82 = mysqli_fetch_array($exec82);
$accanum = $res82['id'];
$shortname = $res82['shortname'];
$accanumexplode = explode('-',$accanum);
$accanum1 = $accanumexplode[0];
$accanum2 = $accanumexplode[1];

if(isset($accanumexplode[2]))
  $accanum3 = $accanumexplode[2];
else
  $accanum3 ='01';



$accinc = intval($accanum3);
$accinc = $accinc + 1;

//$query2 = "select * from master_accountname where locationcode = '$location' and accountsmain = '$accountsmain' and accountssub = '$accountssub'  order by auto_number desc";
$query2 = "select * from master_accountname where accountsmain = '$accountsmain' and accountssub = '$accountssub'  order by auto_number desc";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);

$res2id = $res2['id'];

if($res2id == '')
{
	$searchresult = $accanum1.'-'.$accanum2.'-'.$accinc;
}
else
{
	$res2id = $res2['id'];
	$res2idexplode = explode('-',$res2id);
	$res2id1 = $res2idexplode[0];
	$res2id2 = $res2idexplode[1];
	$res2id3 = $res2idexplode[2];

	
	$incanum = intval($res2id3);
	$incanum = $incanum + 1;
	
	$searchresult = $accanum1.'-'.$accanum2.'-'.$incanum;
	
	l1:
	  $select_query="select * from master_accountname where id = '$searchresult' limit 0,1";
	  $result = mysqli_query($GLOBALS["___mysqli_ston"], $select_query);
	  while($row = mysqli_fetch_array($result))
	  {
		$res2id = $row['id'];
        $res2idexplode = explode('-',$res2id);
		$res2id1 = $res2idexplode[0];
		$res2id2 = $res2idexplode[1];
		$res2id3 = $res2idexplode[2];

		
		$incanum = intval($res2id3);
		$incanum = $incanum + 1;
		
		$searchresult = $res2id1.'-'.$res2id2.'-'.$incanum;
		
        goto l1;
     }
}

if ($searchresult != '')
{
	echo $searchresult;
}

?>
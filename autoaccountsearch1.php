<?php
session_start();
include ("db/db_connect.php");

$docno = $_SESSION['docno'];
$username = $_SESSION['username'];

$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$locationname = $res1["locationname"];
$locationcode = $res1["locationcode"];  

if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }
$searchresult = "";

/*
$query2 = "select * from master_employeelocation where locationcode = '$locationcode' group by employeecode";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
while ($res2 = mysql_fetch_array($exec2))
{
	$res2employeecode = $res2['employeecode'];
	//$res2employeename = $res2['employeename'];
*/

$query3 = "select * from master_accountname where accountname like '%$accountname%' and accountsmain in ('4')";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res3 = mysqli_fetch_array($exec3))
{
	$res3accountname = $res3['accountname'];

	$accountcode = $res3['id'];
	$accountname = $res3['accountname'];
	$autonumber=$res3['auto_number'];
	$accountssub = $res3['accountssub'];
	
	$accsub_q = mysqli_query($GLOBALS["___mysqli_ston"], "select accountssub from master_accountssub where auto_number = '$accountssub'") or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
	$accsub_r = mysqli_fetch_array($accsub_q);
	$accsub = $accsub_r['accountssub'];

	if ($searchresult == '')
	{
		$searchresult = ''.$accountcode.'||'.$accountname.'||'.$autonumber.'|'.$accsub;
	}
	else
	{
		$searchresult = $searchresult.'||^||'.$accountcode.'||'.$accountname.'||'.$autonumber.'|'.$accsub;
	}

}

//}	

if ($searchresult != '')
{
	echo $searchresult;
}

?>

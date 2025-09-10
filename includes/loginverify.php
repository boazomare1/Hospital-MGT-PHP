<?php
include_once("db/db_connect.php");



$pagename = '';



if (!isset($_SESSION["username"])) header ("location:index.php");



if (isset($_SESSION['username'])) { $username1 = $_SESSION['username']; } else { $username1 = ""; }



$query1 = "select * from login_restriction where username = '$username1'";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res1 = mysqli_fetch_array($exec1);

$rowcount1 = mysqli_num_rows($exec1);

//$logincount = $res1['rowcount1'];

$res1sessionid = $res1['sessionid'];


if ($res1sessionid != session_id())

{

	//echo 'inside if';

	//header ("location:login1restricted1.php");

	//exit;

}


if (!isset($_SESSION["companyanum"])) // if the variable is set.

{

	header ("location:setactivecompany1.php"); 

}

$ipaddress = $_SERVER["REMOTE_ADDR"];

$username = $_SESSION["username"];



 $pagename=basename($_SERVER['REQUEST_URI']);
//$pagename = basename($_SERVER['REQUEST_URI'], ".php");



$query881 = "select * from master_menumain where mainmenulink='$pagename'";

$exec881 = mysqli_query($GLOBALS["___mysqli_ston"], $query881) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res881 = mysqli_fetch_array($exec881);

$menumainid = $res881['mainmenuid'];

$main_menu_access=0;
if($menumainid!=''){
$query882 = "select * from master_employeerights where mainmenuid='$menumainid' and username='$username'";

$exec882 = mysqli_query($GLOBALS["___mysqli_ston"], $query882) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$main_menu_access = mysqli_num_rows($exec882);
}
//echo $pagename;
$string=explode('?',$pagename);
$pagename=$string[0];

$query_sub = "select * from master_menusub where submenulink='$pagename'";

$exec_sub = mysqli_query($GLOBALS["___mysqli_ston"], $query_sub) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res_sub = mysqli_fetch_array($exec_sub);

 $submenuid = $res_sub['submenuid'];
$sub_menu_access=0;
if($submenuid!=''){
$query883 = "select * from master_employeerights where submenuid='$submenuid' and username='$username'";

$exec883 = mysqli_query($GLOBALS["___mysqli_ston"], $query883) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$sub_menu_access = mysqli_num_rows($exec883);
}

$_SESSION['timeout'] = time();

if($menumainid!='')
{
$menu_id=$menumainid;
}
if($submenuid!='')
{
$menu_id=$submenuid;
}
//echo $main_menu_access.'-'.$sub_menu_access;
if($main_menu_access==0&&$sub_menu_access==0)
{
//header ("location:index.php");
}


$companyautonum = $_SESSION['companyanum'];
$query334 = "select mpesa_integration, mpesa_url, mpesa_secret, barclayscard_integration, barclayscard_url, barclays_secret from master_company where auto_number = '$companyautonum'";
$exec334 = mysqli_query($GLOBALS["___mysqli_ston"], $query334) or die("Error in Query334".mysqli_error($GLOBALS["___mysqli_ston"]));
$res334 = mysqli_fetch_array($exec334);

$mpesa_secret = $res334['mpesa_secret'];
$mpesa_url = $res334['mpesa_url'];
$mpesa_integration = $res334['mpesa_integration'];
$barclayscard_integration = $res334['barclayscard_integration'];
$barclayscard_url = $res334['barclayscard_url'];
$barclays_secret = $res334['barclays_secret'];

?>
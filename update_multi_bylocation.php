<?php

include ("db/db_connect.php");
$data1=$_REQUEST['lct'];
$lct=json_decode($data1);
$username = $_REQUEST['username'];
$password=$_REQUEST['password'];
$locdocno=$_REQUEST['locdocno'];
$updatedatetime = date('Y-m-d H:i:s');
$todaydate = date('Y-m-d');
$ipaddress = $_SERVER["REMOTE_ADDR"];

$query1 = "update details_login set logouttime = '$updatedatetime' where username = '$username' and docno = '$locdocno'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
session_start();
session_destroy();


$totalclosingcash = '';
session_start();
session_regenerate_id();
$sessionid = session_id();
$query1 = "select validitydate,cashlimit from master_employee where username = '$username'";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$rowcount1 = mysqli_num_rows($exec1);
if ($rowcount1 == 0)
{
'0||0||0';
}
else
{
$res1 = mysqli_fetch_array($exec1);
$validitydate = $res1['validitydate'];
$cashlimit = $res1['cashlimit'];
$validitydatestr = strtotime($validitydate);
$todaydatestr = strtotime($todaydate);	

$query2 = "select auto_number from details_login  order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["auto_number"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
$billnumbercode ='1';
$openingbalance = '0.00';
}
else
{
$billnumber = $res2["auto_number"];
$billnumbercode = intval($billnumber);
$billnumbercode = $billnumbercode + 1;	
$maxanum = $billnumbercode;		
$billnumbercode = $maxanum;
}
$_SESSION["username"] = $username;
$_SESSION["timelimit"] = $cashlimit;
$_SESSION["logintime"] = $updatedatetime;	 
$_SESSION["timestamp"] = time();
$_SESSION['timeout'] = time();	
$_SESSION["docno"] = $billnumbercode;	
$cashlmt=$cashlimit*60;

$query7 = "select * from master_company order by auto_number limit 0, 1";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
$res7rowcount = mysqli_num_rows($exec7);
$res7 = mysqli_fetch_array($exec7);
$dfcompanyanum = $res7['auto_number'];
$query6 = "select * from master_company where auto_number = '$dfcompanyanum'";
$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
$res6 = mysqli_fetch_array($exec6);
$res6companyname = $res6["companyname"];
$res6companycode = $res6["companycode"];
$_SESSION["companyanum"] = $dfcompanyanum;
$_SESSION["companyname"] = $res6companyname;
$_SESSION["companycode"] = $res6companycode;
$_SESSION["sess_loc"] = $data1;

$query7 = "select * from master_settings where companycode = '$res6companycode' and modulename = 'SETTINGS' and 
settingsname = 'CURRENT_FINANCIAL_YEAR'";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
$res7 = mysqli_fetch_array($exec7);
$financialyear = $res7["settingsvalue"];
$_SESSION["financialyear"] = $financialyear;

setcookie('username',$username, time() + (86400 * 1));
setcookie('logintime',$updatedatetime, time() + (86400 * 1));
setcookie('logout','login', time() + (86400 * 1));

$query01="select locationcode,locationname from master_location where locationcode='$data1'  ";
$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
$res01=mysqli_fetch_array($exc01);
$locationname = $res01["locationname"];

$query2 = "insert into details_login (docno,username, logintime, openingcash,lastupdate, lastupdateipaddress, lastupdateusername, sessionid) value ('$billnumbercode','$username', '$updatedatetime', '0', '$updatedatetime', '$ipaddress', '$username', '$sessionid')";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$query4 = "delete from login_restriction where username = '$username'";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

$query3 = "insert into login_restriction (username, logintime, lastupdate, lastupdateipaddress, lastupdateusername, sessionid) value ('$username', '$updatedatetime', '$updatedatetime', '$ipaddress', '$username', '$sessionid')";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

$query7 = "insert into login_locationdetails (docno,username,locationname , locationcode) value ('$billnumbercode','$username','$locationname','$data1')";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));

//echo $billnumbercode.'||'.$username.'||'.$cashlmt.'||'.time().'||'.$sessionid;
echo $data1;
}

?>
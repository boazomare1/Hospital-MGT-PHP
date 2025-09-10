<?php
session_start();
include ("db/db_connect.php");
$recorddate = date('Y-m-d');
$recordtime = date('H:i:s');
$updatetime = date('Y-m-d H:i:s');
error_reporting(0);
$ipaddress = $_SERVER["REMOTE_ADDR"];
$action = $_REQUEST['action'];
$updatedatetime = date('Y-m-d H:i:s');
$todaydate = date('Y-m-d');
if($action=='sessioncheck')
{
	if (isset($_SESSION["username"]))
	{
		$user = $_SESSION['username'];
		$inactive = $_SESSION['timelimit'] * 60; 
		$session_life = time() - $_SESSION['timeout'];
	}
	else
	{
		$user = $_REQUEST['username'];
		$inactive = $_REQUEST['timelimit'] * 60; 
		$session_life = time() - $_REQUEST['timeout'];
	}
		
	if (isset($_COOKIE["logout"])) { $logout = $_COOKIE["logout"]; } else { $logout = ""; }
	
	$query31 = "select a.shiftouttime as shiftouttime from shift_tracking as a,master_employee as b where a.username=b.username and a.username = '$user' and shift='yes'  order by a.auto_number desc limit 0,1";
	$exe31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
	$num1=mysqli_num_rows($exe31);
	if($num1>0){
		$res31 = mysqli_fetch_array($exe31);
		$shiftouttime = $res31["shiftouttime"];
		if($shiftouttime != '0000-00-00 00:00:00')
		{	
			$logout='shiftwise1';
			$session_life = 0;
		}
	}		$locdocno = $_REQUEST['locdocno'];	$query22 = "select * from details_login where username='$user' and docno='$locdocno'  and logouttime!='0000-00-00 00:00:00' order by auto_number desc limit 0, 1";	$exe312 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die("Error in query22".mysqli_error($GLOBALS["___mysqli_ston"]));	$numfetdoc = mysqli_num_rows($exe312);	if($numfetdoc>0){	echo 4;	}else{	$query2 = "select * from details_login where username='$user' order by auto_number desc limit 0, 1";	$exe31 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));	$res31 = mysqli_fetch_array($exe31);		if(isset($_COOKIE["PHPSESSID"]) and $_COOKIE["PHPSESSID"]!=$res31['sessionid']){		$inactive=0;	}

	if($logout!='logout')
	{
		if($session_life > $inactive)
		{  
			echo 1;
			if (isset($_SESSION["logintime"])) { $logintime = $_SESSION["logintime"]; } else { $logintime = ""; }
			if($logintime!='')
			{
				$username = $_REQUEST["username"];
				$query1 = "update details_login set logouttime = '$updatedatetime' where username = '$username' and logintime = '$logintime'";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				session_destroy();
				session_start();
			}
		}
		else
		{									
			if($logout=='shiftwise1'){
				echo 3;		
			}else{
				echo 0;		
			}
				
			//echo 0;	
		}
	}
	else
	{
		//echo $_COOKIE["logout"];
		echo 2;
	}	}

}

if($action=='loginuser')
{
	$username = $_REQUEST['username'];
	$password =base64_encode($_POST["password"]);
	//$sessionid = session_id();
	$totalclosingcash = '';
	$locdocno = $_REQUEST["locdocno"];
	//session_start();
	session_destroy();
	session_start();
	session_regenerate_id();
	$sessionid = session_id();
	
	$query1 = "select validitydate,cashlimit from master_employee where username = '$username' and password = '$password'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$rowcount1 = mysqli_num_rows($exec1);
	if ($rowcount1 == 0)
	{
		echo '0||0||0';
	}
	else
	{
		$res1 = mysqli_fetch_array($exec1);
		$validitydate = $res1['validitydate'];
		$cashlimit = $res1['cashlimit'];
		$validitydatestr = strtotime($validitydate);
		$todaydatestr = strtotime($todaydate);		
		if($validitydatestr >= $todaydatestr)
		{			
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
			setcookie('logout','login', time() + (86400 * 1));
						
			$query2 = "insert into details_login (docno,username, logintime, openingcash,lastupdate, lastupdateipaddress, lastupdateusername, sessionid) 
			value ('$billnumbercode','$username', '$updatedatetime', '0', '$updatedatetime', '$ipaddress', '$username', '$sessionid')";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$query4 = "delete from login_restriction where username = '$username'";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$query3 = "insert into login_restriction (username, logintime, 
			lastupdate, lastupdateipaddress, lastupdateusername, sessionid) 
			value ('$username', '$updatedatetime', 
			'$updatedatetime', '$ipaddress', '$username', '$sessionid')";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));	
			
			$query5 = "select locationname,locationcode from login_locationdetails where docno='$locdocno'";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res5 = mysqli_fetch_array($exec5))
			{
				$locationname = $res5['locationname'];
				$locationcode = $res5['locationcode'];
				$query7 = "insert into login_locationdetails (docno,username,locationname , locationcode) 
					value ('$billnumbercode','$username','$locationname','$locationcode')";
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			
			$query6 = "select companyname,companycode,auto_number from master_company order by auto_number limit 0, 1";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);
			$res6companyname = $res6["companyname"];
			$res6companycode = $res6["companycode"];
			$dfcompanyanum = $res6['auto_number'];
			$_SESSION["companyanum"] = $dfcompanyanum;
			$_SESSION["companyname"] = $res6companyname;
			$_SESSION["companycode"] = $res6companycode;			
			$_SESSION["companyanum"] = $dfcompanyanum;
			$_SESSION["companyname"] = $res6companyname;
			$_SESSION["companycode"] = $res6companycode;
			//exit;
			$query7 = "select settingsvalue from master_settings where companycode = '$res6companycode' and modulename = 'SETTINGS' and 
			settingsname = 'CURRENT_FINANCIAL_YEAR'";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res7 = mysqli_fetch_array($exec7);
			$financialyear = $res7["settingsvalue"];
			
			$_SESSION["financialyear"] = $financialyear;
		}
		echo '1||'.time().'||'.$billnumbercode;
	}
}

if($action=='logoutuser')
{
	setcookie('logout','logout', time() + (86400 * 1));
	echo 'logout';
}
?>
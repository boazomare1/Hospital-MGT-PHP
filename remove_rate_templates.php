<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$ipaddress = $_SERVER["REMOTE_ADDR"];$sessionusername = $_SESSION['username'];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
	if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
	$paynowbillprefix = 'SM';
$paynowbillprefix1=strlen($paynowbillprefix);
 $query2 = "select * from master_menusub order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["submenuid"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
 $billnumbercode ='SM'.'1';
}
else
{
 $billnumber = $res2["submenuid"];
 $billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

 $billnumbercode = intval($billnumbercode);
 $billnumbercode = $billnumbercode + 1;
 $maxanum = $billnumbercode;
 $billnumbercode = 'SM' .$maxanum;
 
  
} 
	if ($frmflag1 == 'frmflag1')
	{
		$menu_id = $_REQUEST["menu_id"];
		$submenuid = $_REQUEST["submenuid"];
		$submenuorder = $_REQUEST["submenuorder"];
		$menu_name = $_REQUEST['submenu_name'];
		$menu_url = $_REQUEST['submenu_url'];
		
		 $Query = "insert into master_menusub(mainmenuid,submenuid,submenuorder,submenutext,submenulink) 
		values ('".$menu_id."','".$submenuid."','".$submenuorder."','".$menu_name."', '".$menu_url."')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $Query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));						$query4 = "insert into master_employeerights (employeecode, username, mainmenuid, submenuid, 					lastupdate, lastupdateipaddress, lastupdateusername) 					values ('EMP00000001', 'admin', '', '$submenuid', 					'$updatedatetime', '$ipaddress', '$sessionusername')";					$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));						
		$errmsg = "Success. New Sub Menu Created";
		//exit;
		$bgcolorcode = 'success';
	
	}

	if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
	if ($st == 'del')
	{
		$delanum = $_REQUEST["anum"];
		$Query = "update master_menusub set status = 'deleted' where auto_number = '".$delanum."'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $Query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	if ($st == 'activate')
	{
		$delanum = $_REQUEST["anum"];
		$Query = "update master_menusub set status = '' where auto_number = '".$delanum."'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $Query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	$paynowbillprefix = 'SM';
$paynowbillprefix1=strlen($paynowbillprefix);
 $query2 = "select * from master_menusub order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["submenuid"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
 $billnumbercode ='SM'.'1';
}
else
{
 $billnumber = $res2["submenuid"];
 $billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

 $billnumbercode = intval($billnumbercode);
 $billnumbercode = $billnumbercode + 1;
 $maxanum = $billnumbercode;
 $billnumbercode = 'SM' .$maxanum;
 
  
} 
?>
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
<link rel="stylesheet" href="css/main.css" type="text/css" />
<link rel="stylesheet" href="css/field.css" type="text/css" />

<script language="javascript">
	function process1()
	{
		//alert ("Inside Funtion");
		if (document.form1.menu_id.value == "")
		{
			alert ("Please Select the Menu ID");
			document.form1.menu_id.focus();
			return false;
		}
		if (document.form1.submenu_name.value == "")
		{
			alert ("Please Enter Sub Menu Name");
			document.form1.submenu_name.focus();
			return false;
		}
	}
</script>
<body  bgcolor='ECECEC'>
<?php include("includes/title1.php"); ?>

<?php include("includes/menu1.php"); ?>
<?php $query2 = "select * from master_testtemplate";$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));while($res2 = mysqli_fetch_array($exec2)){		echo $table=$res2['templatename'];		mysqli_query($GLOBALS["___mysqli_ston"],'DROP TABLE IF EXISTS `rfh`.'.$table.'') or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));}$query2 = "select * from master_testtemplate where referencetable<>''";$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));while($res2 = mysqli_fetch_array($exec2)){		echo $table=$res2['referencetable'];		mysqli_query($GLOBALS["___mysqli_ston"],'DROP TABLE IF EXISTS `rfh`.'.$table.'') or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));}?>
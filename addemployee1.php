<?php
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
$pagename = '';
if (!isset($_SESSION['username'])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$sessionusername = $_SESSION['username'];
$errmsg = '';
$bgcolorcode = '';

$query7 = "select * from master_edition";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
$res7 = mysqli_fetch_array($exec7);
$usersallowed1 = $res7['users'];

$query8 = "select * from master_employee";
$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
$rowcount8 = mysqli_num_rows($exec8);
$employeecount = $rowcount8;

if ($usersallowed1 <= $employeecount)
{
	//If this condition is true, javascript filter will return false.
	$errmsg = "Sorry, Maximum Allowed User Limit Reached. Please Purchase Additional User Licence.";
}

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{
	$employeecode=$_REQUEST['employeecode'];
	$employeename = $_REQUEST['employeename'];
	$employeename = strtoupper($employeename);
	$employeename = trim($employeename);
	$username2 = $_REQUEST['username2'];
	$password = $_REQUEST['password'];
	$password = base64_encode($password);
	$validitydate = $_REQUEST['validitydate'];
	$location = $_REQUEST['location'];
	$store= $_REQUEST['store'];
	$shift = $_REQUEST["shift"];
	$jobdescription = $_REQUEST['jobdescription'];
	$cashlimit = $_REQUEST['cashlimit'];
	//$status = $_REQUEST['status'];
	$status = 'Active';
	$reports_daterange_option = $_REQUEST['reports_daterange_option'];
	$option_edit_delete = $_REQUEST['option_edit_delete'];
	
	$query2 = "select * from master_employee where username = '$username2'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 == 0)
	{
		$query1 = "insert into master_employee (employeecode,employeename, username, password, 
		status, lastupdate, lastupdateusername, lastupdateipaddress, reports_daterange_option, option_edit_delete,location,store,shift,jobdescription,validitydate,cashlimit) 
		values ('$employeecode','$employeename', '$username2', '$password', 
		'$status', '$updatedatetime', '$sessionusername', '$ipaddress', '$reports_daterange_option', '$option_edit_delete','$location','$store','$shift','$jobdescription','$validitydate','$cashlimit')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	
		for ($i=0;$i<=1000;$i++)
		{
			if (isset($_REQUEST["cbmainmenu".$i])) { $cbmainmenu = $_REQUEST["cbmainmenu".$i]; } else { $cbmainmenu = ""; }
			//$cbmainmenu = $_REQUEST['cbmainmenu'.$i];
			if ($cbmainmenu != '')
			{
				//echo '<br>'.$cbmainmenu;
				$query5 = "select * from master_menumain where auto_number = '$cbmainmenu'";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res5 = mysqli_fetch_array($exec5);
				$res5mainmenuid = $res5['mainmenuid'];
				
				$query3 = "insert into master_employeerights (employeecode, username, mainmenuid, submenuid, 
				lastupdate, lastupdateipaddress, lastupdateusername) 
				values ('$employeecode', '$username2', '$res5mainmenuid', '', 
				'$updatedatetime', '$ipaddress', '$sessionusername')";
				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}

		//echo '<br><br>';
		for ($i=0;$i<=1000;$i++)
		{
			if (isset($_REQUEST["cbsubmenu".$i])) { $cbsubmenu = $_REQUEST["cbsubmenu".$i]; } else { $cbsubmenu = ""; }
			//$cbsubmenu = $_REQUEST['cbsubmenu'.$i];
			if ($cbsubmenu != '')
			{
				//echo '<br>'.$cbsubmenu;
				$query6 = "select * from master_menusub where auto_number = '$cbsubmenu'";
				$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res6 = mysqli_fetch_array($exec6);
				$res6submenuid = $res6['submenuid'];

				$query4 = "insert into master_employeerights (employeecode, username, mainmenuid, submenuid, 
				lastupdate, lastupdateipaddress, lastupdateusername) 
				values ('$employeecode', '$username2', '', '$res6submenuid', 
				'$updatedatetime', '$ipaddress', '$sessionusername')";
				$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		
		for ($i=0;$i<=1000;$i++)
		{
			if (isset($_REQUEST["cbdepartment".$i])) { $cbdepartment = $_REQUEST["cbdepartment".$i]; } else { $cbdepartment = ""; }
			//$cbsubmenu = $_REQUEST['cbsubmenu'.$i];
			if ($cbdepartment != '')
			{
				//echo '<br>'.$cbsubmenu;
				$query7 = "select * from master_department where auto_number = '$cbdepartment'";
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res7 = mysqli_fetch_array($exec7);
				$res7departmentname = $res7['department'];

				$query8 = "insert into master_employeedepartment (employeecode, username, departmentanum, department, 
				lastupdate, lastupdateipaddress, lastupdateusername) 
				values ('$employeecode', '$username2', '$cbdepartment', '$res7departmentname', 
				'$updatedatetime', '$ipaddress', '$sessionusername')";
				$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
	
		

		header ("location:addemployee1.php?st=success");
	}
	else
	{
		header ("location:addemployee1.php?st=failed");
	}

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == 'success')
{
		$errmsg = "Success. New Employee Updated.";
}
else if ($st == 'failed')
{
		$errmsg = "Failed. Employee Already Exists.";
}

$query1 = "select * from master_employee order by auto_number desc limit 0, 1";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$rowcount1 = mysqli_num_rows($exec1);
if ($rowcount1 == 0)
{
	$employeecode = 'EMP00000001';
}
else
{
	$res1 = mysqli_fetch_array($exec1);
	$res1employeecode = $res1['employeecode'];
	$employeecode = substr($res1employeecode, 3, 8);
	$employeecode = intval($employeecode);
	$employeecode = $employeecode + 1;

	$maxanum = $employeecode;
	if (strlen($maxanum) == 1)
	{
		$maxanum1 = '0000000'.$maxanum;
	}
	else if (strlen($maxanum) == 2)
	{
		$maxanum1 = '000000'.$maxanum;
	}
	else if (strlen($maxanum) == 3)
	{
		$maxanum1 = '00000'.$maxanum;
	}
	else if (strlen($maxanum) == 4)
	{
		$maxanum1 = '0000'.$maxanum;
	}
	else if (strlen($maxanum) == 5)
	{
		$maxanum1 = '000'.$maxanum;
	}
	else if (strlen($maxanum) == 6)
	{
		$maxanum1 = '00'.$maxanum;
	}
	else if (strlen($maxanum) == 7)
	{
		$maxanum1 = '0'.$maxanum;
	}
	else if (strlen($maxanum) == 8)
	{
		$maxanum1 = $maxanum;
	}
	
	$employeecode = 'EMP'.$maxanum1;

	//echo $employeecode;
}
//echo $res1employeecode;


?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script language="javascript">

function process1backkeypress1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}

</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">

function from1submit1()
{

	if (document.form1.employeename.value == "")
	{
		alert ("Employee Name Cannot Be Empty.");
		document.form1.employeename.focus();
		return false;
	}
	if (document.form1.username.value == "")
	{
		alert ("User Name Cannot Be Empty.");
		document.form1.username.focus();
		return false;
	}
	if (document.form1.username.value != "")
	{	
		var data = document.form1.username.value;
		//alert(data);
		// var iChars = "!%^&*()+=[];,.{}|\:<>?~"; //All special characters.*
		var iChars = "!^+=[];,{}|\<>?~$'\"@#%&*()-_`. "; 
		for (var i = 0; i < data.length; i++) 
		{
			if (iChars.indexOf(data.charAt(i)) != -1) 
			{
				//alert ("Your Item Name Has Blank White Spaces Or Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ $ ' \" These are not allowed.");
				alert ("Your User Name Has Blank White Spaces Or Special Characters. These Are Not Allowed.");
				return false;
			}
		}
	}
	if (document.form1.password.value == "")
	{
		alert ("Password Cannot Be Empty.");
		document.form1.password.focus();
		return false;
	}
	<?php
	if ($usersallowed1 == $employeecount)
	{
	?>
		alert ("Sorry, Maximum Allowed User Limit Reached. Please Purchase Additional User Licence.");
		return false;
	<?php
	}
	?>
}
function funclocationChange1()
{

	
	<?php 
	$query12 = "select * from master_location where status = ''";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res12 = mysqli_fetch_array($exec12))
	{
	$res12locationanum = $res12["auto_number"];
	$res12location = $res12["locationname"];
	?>
	if(document.getElementById("location").value=="<?php echo $res12locationanum; ?>")
	{
		document.getElementById("store").options.length=null; 
		var combo = document.getElementById('store'); 	
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Store", ""); 
		<?php
		$query10 = "select * from master_store where location = '$res12locationanum' and recordstatus = ''";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10 = mysqli_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10storeanum = $res10["auto_number"];
		$res10store = $res10["store"];
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10store;?>", "<?php echo $res10storeanum;?>"); 
		<?php 
		}
		?>
	}
	<?php
	}
	?>	
}

</script>
<script src="js/datetimepicker_css.js"></script>
<body>
<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5">
	<?php 
	
		include ("includes/menu1.php"); 
	
	//	include ("includes/menu2.php"); 
	
	?>	</td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">


      	  <form name="form1" id="form1" method="post" action="addemployee1.php" onKeyDown="return disableEnterKey()" onSubmit="return from1submit1()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860"><table width="900" height="250" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="2"><strong>Employee - New </strong></td>
                <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">* Indicated Mandatory Fields. </td>
              </tr>
              <tr>
                <td colspan="8" align="left" valign="middle"  
				bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
              </tr>
              <!--<tr bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3"  colspan="4"><strong>Registration</strong></font></div></td>
                </tr>-->
              <!--<tr>
                  <tr  bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3" colspan="4"><div align="right">* Indicates Mandatory</div></td>
                </tr>-->
				<tr>
                <td width="19%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Employee Code   *</td>
                <td align="left" valign="middle" >
				<input name="employeecode" id="employeecode" value="<?php echo $employeecode; ?>" readonly="readonly" style="border: 1px solid #001E6A" size="20"></td>
                <td align="left" valign="middle" ><span class="bodytext3">Validity Date</span></td>
                <td align="left" valign="middle" >
				<input name="validitydate" id="validitydate" style="border: 1px solid #001E6A" value="<?php echo date('Y-m-d'); ?>"  readonly="readonly" onKeyDown="return disableEnterKey()" size="10" />
					<img src="images2/cal.gif" onClick="javascript:NewCssCal('validitydate')" style="cursor:pointer"/>
					<input type="hidden" name="dateposted" id="dateposted" value="<?php echo $updatedatetime; ?>" onKeyDown="return process1backkeypress1()" style="border: 1px solid #001E6A"  size="20"  readonly="readonly" /></td>
				</tr>
              <tr>
                <td width="19%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Employee Name   *</td>
                <td colspan="3" align="left" valign="middle" >
				<input name="employeename" id="employeename" value="" style="border: 1px solid #001E6A;text-transform: uppercase;" size="60"></td>
              </tr>
			  <tr>
                <td width="19%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Job Description</td>
                <td colspan="3" align="left" valign="middle" >
				<input name="jobdescription" id="jobdescription" value="" style="border: 1px solid #001E6A;text-transform: uppercase;" size="60"></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">User Name </td>
                <td colspan="3" align="left" valign="middle" >
				<input name="username2" id="username" style="border: 1px solid #001E6A;" value=""  size="60" maxlength="20" />
				<span class="bodytext3">(Space or special characters are not allowed.) </span></td>
                </tr>
				 <tr>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Password</td>
                <td colspan="3" align="left" valign="middle" >
				<input name="password" type="password" id="password" style="border: 1px solid #001E6A;" value=""  size="60" maxlength="20" /></td>
                </tr>
                 <tr>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Location</td>
                   <td valign="middle" align="left" >
				   
				    <select name="location" id="location" onChange="return funclocationChange1();"  style="border: 1px solid #001E6A;">
                  <option value="" selected="selected">Select Location</option>  
				  <?php
				$query5 = "select * from master_location where status = '' order by locationname";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5locationname = $res5["locationname"];
				?>
                    <option value="<?php echo $res5anum; ?>"><?php echo $res5locationname; ?></option>
                    <?php
				}
				?>
                  </select>			   </td>
                  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Cash Limit</td>
                <td valign="middle" align="left" ><input type="text" name="cashlimit" id="cashlimit" style="border: 1px solid #001E6A" size="10"></td>
                  </tr>
                 <tr>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Store</td>
                   <td valign="middle" align="left">
				   <select name="store" id="store" style="border: 1px solid #001E6A;">
                    <option value="" selected="selected">Select Store</option>
<!--					
					<?php
				if ($subtype == '')
				{
					echo '<option value="" selected="selected">Select Store</option>';
				}
				else
				{
					$query51 = "select * from master_store where recordstatus = ''";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res51 = mysqli_fetch_array($exec51);
					$res51store = $res51["store"];
					echo '<option value="'.$res51store.'" selected="selected">'.$res51store.'</option>';
				}
				
				$query5 = "select * from master_store where recordstatus = '' order by store";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5store = $res5["store"];
				?>
                    <option value="<?php echo $res5store; ?>"><?php echo $res5store; ?></option>
                    <?php
				}
				?>
-->				  
                  </select>				</td>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                   <td colspan="2" align="left" valign="middle" >&nbsp;</td>
                  </tr>
				  <tr>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Shift Access </td>
                   <td valign="middle" align="left" ><select name="shift" id="shift">
				   <option value="">SELECT ACCESS</option>
                     <option value="YES">YES</option>
                     <option value="NO">NO</option>
                   </select></td>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                   <td colspan="2" align="left" valign="middle" >&nbsp;</td>
                  </tr>
                 <tr>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Menu Permissions </strong></td>
                   <td valign="middle" align="left" >&nbsp;</td>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                   <td colspan="2" align="left" valign="middle" >&nbsp;</td>
                  </tr>
                 <tr>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Main Menu </strong></td>
                   <td valign="middle" align="left" ><span class="bodytext3"><strong>Sub Menu </strong></span></td>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                   <td colspan="2" align="left" valign="middle" >&nbsp;</td>
                  </tr>
				 <?php
				 $query2 = "select * from master_menumain where status <> 'deleted' order by mainmenuorder";
				 $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				 while ($res2 = mysqli_fetch_array($exec2))
				 {
				 $res2anum = $res2['auto_number'];
				 $res2menuid = $res2['mainmenuid'];
				 $res2mainmenutext = $res2['mainmenutext'];
				 
				 //if ($res2mainmenutext != 'Home' && $res2mainmenutext != 'Logout')
				 //{
				 ?>
                 <tr>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
				   <input type="checkbox" name="cbmainmenu<?php echo $res2anum; ?>" checked="checked" value="<?php echo $res2anum; ?>">
                     <strong><?php echo $res2mainmenutext; ?></strong></td>
                   <td valign="middle" align="left" >&nbsp;</td>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                   <td colspan="2" align="left" valign="middle" >&nbsp;</td>
                  </tr>
				 <?php
				 $query3 = "select * from master_menusub where mainmenuid = '$res2menuid' and status <> 'deleted' order by submenuorder";
				 $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
				 while ($res3 = mysqli_fetch_array($exec3))
				 {
				 $res3anum = $res3['auto_number'];
				 $res3submenuid = $res3['submenuid'];
				 $res3submenutext = $res3['submenutext'];
				 ?>
                 <tr>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                   <td valign="middle" align="left" ><span class="bodytext3">
                     <input type="checkbox" name="cbsubmenu<?php echo $res3anum; ?>" checked="checked" value="<?php echo $res3anum; ?>">
                     <strong><?php echo $res3submenutext; ?></strong></span></td>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                   <td colspan="2" align="left" valign="middle" >&nbsp;</td>
                  </tr>
 				 <?php
				 }
				 ?>
                 <tr>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                   <td valign="middle" align="left"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                   <td colspan="2" align="left" valign="middle" >&nbsp;</td>
                  </tr>
				 <?php
				 //}
				 }
				 ?>
                 <tr>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Department</strong></td>
                   <td valign="middle" align="left" >&nbsp;</td>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                   <td colspan="2" align="left" valign="middle" >&nbsp;</td>
                 </tr>
				 <?php
				 $query31 = "select * from master_department where recordstatus <> 'deleted' order by auto_number";
				 $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
				 while ($res31 = mysqli_fetch_array($exec31))
				 {
				 $res31anum = $res31['auto_number'];
				 $res31department = $res31['department'];
				
				 ?>
                 <tr>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="checkbox" name="cbdepartment<?php echo $res31anum; ?>" checked="checked" value="<?php echo $res31anum; ?>">
                     <strong><?php echo $res31department; ?></strong></td>
                   <td valign="middle" align="left" ><span class="bodytext3">&nbsp;
                     </span></td>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                   <td colspan="2" align="left" valign="middle" >&nbsp;</td>
                  </tr>
 				 <?php
				 }
				 ?>
                 <tr>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
				   <strong><!--Report Date Range Option--> </strong></td>
                   <td align="left" valign="middle" >
				   <input type="hidden" name="reports_daterange_option" id="reports_daterange_option" value="">
<!--				   
				   <select name="reports_daterange_option" id="reports_daterange_option">
                       <option value="Show Date Range Option" selected="selected">Show Date Range Option</option>
                       <option value="Hide Date Range Option">Hide Date Range Option</option>
                     </select>
-->                   </td>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                   <td colspan="2" align="left" valign="middle" >&nbsp;</td>
                 </tr>
                 <tr>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                   <td valign="middle" align="left" >&nbsp;</td>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                   <td colspan="2" align="left" valign="middle" >&nbsp;</td>
                  </tr>
                 <tr>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Edit &amp; Delete Option </strong></td>
                   <td align="left" valign="middle" >
				   <select name="option_edit_delete" id="option_edit_delete">
                       <option value="Edit Delete Option Available" selected="selected">Edit Delete Option Available</option>
                       <option value="Edit Delete Option Denied">Edit Delete Option Denied</option>
                     </select>				</td>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                   <td colspan="2" align="left" valign="middle" >&nbsp;</td>
                 </tr>
                 <tr>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                   <td valign="middle" align="left" >&nbsp;</td>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                   <td colspan="2" align="left" valign="middle" >&nbsp;</td>
                 </tr>
                 <tr>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                   <td valign="middle" align="left" >&nbsp;</td>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                   <td colspan="2" align="left" valign="middle" >&nbsp;</td>
                  </tr>
              <tr>
                <td align="middle" colspan="4" >&nbsp;</td>
              </tr>
            </tbody>
          </table></td>
        </tr>
        <tr>
          <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="95%" 
            align="left" border="1">
            <tbody>
              <tr>
                <td width="3%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                <td width="30%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                <td width="30%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                <td width="41%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31"><div align="right">
				<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
				<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
				<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
				<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
				<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                    <input type="hidden" name="frmflag1" value="frmflag1" />
                    <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                    <input name="Submit222" accesskey="s" type="submit"  value="Save Employee(Alt+S)" class="button" style="border: 1px solid #001E6A"/>
                </font></font></font></font></font></div></td>
                </tr>
            </tbody>
          </table></td>
        </tr>
    </table>
	</form>
<script language="javascript">


</script>
    </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>


<?php
session_start();
$pagename = '';
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION['username'])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$sessionusername = $_SESSION['username'];
$errmsg = '';
$bgcolorcode = '';

if (isset($_REQUEST["searchsuppliername"])) {  $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchdescription"])) {   $searchdescription = $_REQUEST["searchdescription"]; } else { $searchdescription = ""; }
if (isset($_REQUEST["searchemployeecode"])) { $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{
	foreach($_REQUEST['employeecode'] as $key => $employeecode)
	{
	$employeecode=$_REQUEST['employeecode'][$key];
	$employeename = $_REQUEST['employeename'][$key];
	$employeename = strtoupper($employeename);
	$employeename = trim($employeename);
	$reports_daterange_option = $_REQUEST['reports_daterange_option'];
	$option_edit_delete = $_REQUEST['option_edit_delete'];
	$shift = $_REQUEST["shift"];
	
	$query2 = "select * from master_employee where employeecode = '$employeecode'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_num_rows($exec2);
	if ($res2 != 0)
	{
		$res2 = mysqli_fetch_array($exec2);
		$username1 = $res2['username'];
		$query1 = "update master_employee set employeename = '$employeename',shift = '$shift', lastupdate = '$updatedatetime', lastupdateusername = '$sessionusername', lastupdateipaddress = '$ipaddress', reports_daterange_option = '$reports_daterange_option', option_edit_delete = '$option_edit_delete' where employeecode = '$employeecode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		/*
		if ($username != 'admin')
		{
		*/
			
			$query33 = "delete from master_employeerights where employeecode = '$employeecode' and mainmenuid NOT IN ('MM001','MM026') and submenuid=''";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$query333 = "delete from master_employeelocation where employeecode = '$employeecode'";
			$exec333 = mysqli_query($GLOBALS["___mysqli_ston"], $query333) or die ("Error in Query333".mysqli_error($GLOBALS["___mysqli_ston"]));

			$q_submenu=array();
			$query_menu="select submenuid from master_menusub where mainmenuid NOT IN ('MM001','MM026')";
			$exec_menu = mysqli_query($GLOBALS["___mysqli_ston"], $query_menu) or die ("Error in query_menu".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res_menu = mysqli_fetch_array($exec_menu)){
				array_push($q_submenu, $res_menu['submenuid']);
			}
			
			$str_submenu = implode ("','", $q_submenu);

			$query33 = "delete from master_employeerights where employeecode = '$employeecode' and mainmenuid='' and submenuid IN ('$str_submenu')";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$query77 = "delete from master_employeedepartment where employeecode = '$employeecode'";
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));	

			
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
					values ('$employeecode', '$username1', '$res5mainmenuid', '', 
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
					values ('$employeecode', '$username1', '', '$res6submenuid', 
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
				values ('$employeecode', '$username1', '$cbdepartment', '$res7departmentname', 
				'$updatedatetime', '$ipaddress', '$sessionusername')";
				$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
		for ($i=0;$i<=1000;$i++)
		{
			if (isset($_REQUEST["cblocation".$i])) { $cblocation = $_REQUEST["cblocation".$i]; } else { $cblocation = ""; }
			
			$storecode = $_REQUEST['storecode'];
			//$cbsubmenu = $_REQUEST['cbsubmenu'.$i];
			if ($cblocation != '')
			{
				//echo '<br>'.$cbsubmenu;
				if($cblocation == $storecode) { $default = 'default'; }
				else { $default = ''; }
				$query1 = "select * from master_location where auto_number = '1'";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res1 = mysqli_fetch_array($exec1);
				$res1locationname = $res1['locationname'];
				$res1locationcode = $res1['locationcode'];
				
				$query1 = "select * from master_store where storecode = '$cblocation'";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res1 = mysqli_fetch_array($exec1);
				$res1store = $res1['store'];
				$res1storecode = $res1['storecode'];

				$query8 = "insert into master_employeelocation (employeecode, username, locationanum, locationname,locationcode, 
				lastupdate, lastupdateipaddress, lastupdateusername,`storecode`,`defaultstore`) 
				values ('$employeecode', '$username1', '1', '$res1locationname','$res1locationcode', 
				'$updatedatetime', '$ipaddress', '$sessionusername','$res1storecode','$default')";
				$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		}
			//header ("location:editemployee1.php?st=success");
		/*
		}
		else
		{
			header ("location:editemployee1.php?st=success");
		}
		*/

	}

}

	
	header ("location:editemployee_type.php?st=success");
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == 'success')
{
		$errmsg = "Success. Employee Updated.";
}
else if ($st == 'failed')
{
		$errmsg = "Failed. Employee Already Exists.";
}

if (isset($_REQUEST["selectemployeecode"])) { $selectemployeecode = $_REQUEST["selectemployeecode"]; } else { $selectemployeecode = ""; }
//$selectemployeecode = $_REQUEST['selectemployeecode'];




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
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />  
<script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>
<script type="text/javascript" src="js/autosuggestjobdescription1.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());
  
}
</script>
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



function funcEmployeeSelect1()
{
	if (document.getElementById("selectemployeecode").value == "")
	{
		alert ("Please Select Employee Type To Edit.");
		document.getElementById("selectemployeecode").focus();
		return false;
	}
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
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">
	
	
	<form name="selectemployee" id="selectempoyee" method="post" action="editemployee_type.php?st=edit" onSubmit="return funcEmployeeSelect1()">
	<table width="900" height="29" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<?php if ($errmsg != '') { ?>
	<tr>
	  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
	  <td colspan="2" align="left" valign="middle" 
	  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
	  </tr>
	<?php } ?>
	<tr>
	<td width="19%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
	<td width="21%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Select Employee Type To Edit </strong></td>
	<td width="60%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
	<select name="selectemployeecode" id="selectemployeecode">
	<option value="">Select Employee To Edit</option>
	<?php
	$query21 = "select * from master_jobtitle where recordstatus <> 'deleted' order by jobtitle";
	$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res21 = mysqli_fetch_array($exec21))
	{
	$jobtitleanum = $res21['auto_number'];
	$jobtitle = $res21['jobtitle'];
	?>
			  <option value="<?php echo $jobtitle; ?>" <?php if($selectemployeecode == $jobtitle){ echo  'selected';} ?>><?php echo $jobtitle; ?></option>
	<?php
	}
	?>
	</select>
	<input type="submit" name="Submit" value="Submit">	</td>
	</tr>
	</tbody>
	</table>  
	</form>
	
	
	
  <tr>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">  
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">

			<?php
			if ($selectemployeecode != '')
			{
			?>
      	  <form name="form1" id="form1" method="post" action="editemployee_type.php" onKeyDown="return disableEnterKey()" onSubmit="return from1submit1()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860"><table width="900" height="250" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="2"><strong>Employee - Edit </strong></td>
                <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">* Resets rights for all the below employees. </td>
              </tr>
              <tr>
                <td colspan="8" align="left" valign="middle"  
				bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
              </tr>
              <tr>
              </tr>
              <tr>
                <td width="19%" align="left" valign="middle"  bgcolor="#ccc" class="bodytext3"><strong>Employee Code</strong></td>
				
                <td width="19%" align="left" valign="middle"  bgcolor="#ccc" class="bodytext3"><strong>Employee Name</strong></td>
                <td colspan="2" align="left" valign="middle"   bgcolor="#ccc">
              </tr>
			  <?php
				$query7 = "select * from master_employee where job_title = '$selectemployeecode'";
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res7 = mysqli_fetch_array($exec7))
				{
					$res7employeecode=$res7['employeecode'];
					$res7employeename = $res7['employeename'];
					$res7employeename = strtoupper($res7employeename);
					$res7employeename = trim($res7employeename);
			  ?>
              <tr>
                <td width="19%" align="left" valign="middle" class="bodytext3"><?= $res7employeecode; ?>
				<input type='hidden' name="employeecode[]" value="<?php echo $res7employeecode; ?>" readonly style="border: 1px solid #001E6A" size="20"></td>
                <td width="19%" align="left" valign="middle" class="bodytext3"><?= $res7employeename; ?>
				<input type='hidden' name="employeename[]" value="<?php echo $res7employeename; ?>" readonly style="border: 1px solid #001E6A" size="20"></td>
                <td colspan="2" align="left" valign="middle" ></td>
              </tr>
				<?php } ?>
			 <tr>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Shift Access </td>
                <td valign="middle" align="left" ><select name="shift" id="shift" >
					
                  <option value="">SELECT ACCESS</option>
                  <option value="YES">YES</option>
                  <option value="NO">NO</option>
                </select></td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                <td valign="middle" align="left" >&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>&nbsp; </strong></td>
                <td valign="middle" align="left" bgcolor="#FFFFFF">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                <td valign="middle" align="left" >&nbsp;</td>
              </tr> 
			  <tr>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Location Permissions </strong></td>
                <td valign="middle" align="left" bgcolor="#FFFFFF">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                <td valign="middle" align="left" >&nbsp;</td>
              </tr>
			  <?php
					
						$query1 = "select * from master_store where recordstatus <> 'deleted' order by store";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1storecode = $res1["storecode"];
						$res1store = $res1["store"];
						$res1storeanum = $res1["auto_number"];
						?>
						<tr>
						<td valign="middle" align="left"  bgcolor="#FFFFFF"><span class="bodytext3">
                
                <input type="checkbox" name="cblocation<?php echo $res1storeanum; ?>" value="<?php echo $res1storecode; ?>" <?php if($res1storeanum == 1) {echo  'checked';}?>>
						<input type="radio" name="storecode" id="storecode<?php echo $res1storeanum; ?>" value="<?php echo $res1storecode; ?>" <?php if($res1storeanum == 1) { echo "Checked"; } ?>>
                  <strong><?php echo $res1store; ?></strong>
                  </span></td>
						<td valign="middle" align="left">&nbsp;</td>
						<td align="left" valign="middle" class="bodytext3"  bgcolor="#FFFFFF">&nbsp;</td>
						<td valign="middle" align="left" >&nbsp;</td>
						</tr>
						<?php
						}
						?>
			  
			  <tr>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Menu Permissions </strong></td>
                <td valign="middle" align="left" >&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                <td valign="middle" align="left" >&nbsp;</td>
              </tr>
              <script>
				 function allmenucheck()
				 {
					 var inputs = document.getElementsByClassName('mainmenucheck');	
					 for (var i = 0; i < inputs.length; i++) 
					 {
						 var displayattr = document.getElementById('mainmenucheck1').checked;
						 if(displayattr==true)
						 {
							inputs[i].checked='checked';
							//document.getElementById('id'+pino).innerHTML='+';
						 }
						 else
						 {
							inputs[i].checked='';
							//document.getElementById('id'+pino).innerHTML='-';
						 }
					 }
					 var inputs = document.getElementsByClassName('submenucheck');	
					 for (var i = 0; i < inputs.length; i++) 
					 {
						 var displayattr = document.getElementById('mainmenucheck1').checked;
						 if(displayattr==true)
						 {
							inputs[i].checked='checked';
							//document.getElementById('id'+pino).innerHTML='+';
						 }
						 else
						 {
							inputs[i].checked='';
							//document.getElementById('id'+pino).innerHTML='-';
						 }
					 }
				 }
				 
				 function submenucheck(mainmenucheck)
				 {
					 var inputs = document.getElementsByClassName(mainmenucheck);	
					 for (var i = 0; i < inputs.length; i++) 
					 {
						 
						 var displayattr = document.getElementById(mainmenucheck).checked;
						 if(displayattr==true)
						 {
							inputs[i].checked='checked';
							//document.getElementById('id'+pino).innerHTML='+';
						 }
						 else
						 {
							inputs[i].checked='';
							
							//document.getElementById('id'+pino).innerHTML='-';
						 }
					 }
					
				 }
			  </script>
              <tr>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Main Menu <input id="mainmenucheck1" class="mainmenucheck1" type="checkbox" name="cbmainmen" onClick="allmenucheck()"></strong></td>
                <td valign="middle" align="left" ><span class="bodytext3"><strong>Sub Menu </strong></span></td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                <td valign="middle" align="left" >&nbsp;</td>
              </tr>
              <?php
			  $checkedvalue1 = '';
			  $checkedvalue2 = '';
				 $query2 = "select * from master_menumain where mainmenuid NOT IN ('MM001','MM026') and status = '' order by mainmenuorder";
				 $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				 while ($res2 = mysqli_fetch_array($exec2))
				 {
				 $res2anum = $res2['auto_number'];
				 $res2menuid = $res2['mainmenuid'];
				 $res2mainmenutext = $res2['mainmenutext'];
				 
				 
				 
				 ?>
              <tr>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
				<input class="mainmenucheck" id="<?php echo $res2anum; ?>" type="checkbox" name="cbmainmenu<?php echo $res2anum; ?>" <?php echo $checkedvalue1; ?> value="<?php echo $res2anum; ?>" onClick="submenucheck('<?php echo $res2anum; ?>')">
                    <strong><?php echo $res2mainmenutext; ?></strong></td>
                <td valign="middle" align="left" >&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                <td valign="middle" align="left" >&nbsp;</td>
              </tr>
              <?php
				 $query3 = "select * from master_menusub where mainmenuid = '$res2menuid' and status = '' order by submenuorder";
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
                  <input class="submenucheck <?php echo $res2anum; ?>" type="checkbox" name="cbsubmenu<?php echo $res3anum; ?>" <?php echo $checkedvalue2; ?> value="<?php echo $res3anum; ?>">
                  <strong><?php echo $res3submenutext; ?></strong></span></td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                <td valign="middle" align="left" >&nbsp;</td>
              </tr>
              <?php
				 $checkedvalue2 = '';
				 }
				 ?>
              <tr>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                <td valign="middle" align="left"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                <td valign="middle" align="left" >&nbsp;</td>
              </tr>
              <?php
				 $checkedvalue1 = '';
				 //}
				 }
				 ?>
              <tr>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Department</strong></td>
                <td valign="middle" align="left" ><span class="bodytext3"><strong>&nbsp;</strong></span></td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                <td valign="middle" align="left" >&nbsp;</td>
              </tr>
			     <?php
				 $checkedvalue3 = '';
				 $query7 = "select * from master_department where recordstatus <> 'deleted' order by auto_number";
				 $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				 while ($res7 = mysqli_fetch_array($exec7))
				 {
				  $res7anum = $res7['auto_number'];
				 $res7department = $res7['department'];
				 
				 $query72 = "select * from master_employeedepartment where employeecode = '$selectemployeecode' and departmentanum = '$res7anum'";
				 $exec72 = mysqli_query($GLOBALS["___mysqli_ston"], $query72) or die ("Error in Query72".mysqli_error($GLOBALS["___mysqli_ston"]));
				 $res72 = mysqli_fetch_array($exec72);
				 $rowcount72 = mysqli_num_rows($exec72);
				 if ($rowcount72 > 0)
				 {
				 	$checkedvalue3 = 'checked="checked"';
				 }
				 ?>
              <tr>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="checkbox" name="cbdepartment<?php echo $res7anum; ?>" <?php echo $checkedvalue3; ?> value="<?php echo $res7anum; ?>">
                  <strong><?php echo $res7department; ?></strong></td>
                <td valign="middle" align="left" ><span class="bodytext3">&nbsp;
                  </span></td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                <td valign="middle" align="left" >&nbsp;</td>
              </tr>
              <?php
				 $checkedvalue3 = '';
				 }
				 ?>
              <tr>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Report Date Range Option </strong></td>
                <td align="left" valign="middle" ><select name="reports_daterange_option" id="reports_daterange_option">
                    
                    <option value="Show Date Range Option">Show Date Range Option</option>
                    <option value="Hide Date Range Option">Hide Date Range Option</option>
                  </select>                </td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                <td valign="middle" align="left" >&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                <td valign="middle" align="left" >&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                <td valign="middle" align="left" >&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Edit &amp; Delete Option </strong></td>
                <td align="left" valign="middle" >
				<select name="option_edit_delete" id="option_edit_delete">
                    <?php
				$query1editdelete = "select * from master_employee where username = '$res7username'";
				$exec1editdelete = mysqli_query($GLOBALS["___mysqli_ston"], $query1editdelete) or die ("Error in Query1editdelete".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res1editdelete = mysqli_fetch_array($exec1editdelete);
				$option_edit_delete = $res1editdelete["option_edit_delete"];
				if ($option_edit_delete == 'Edit Delete Option Available' || $option_edit_delete == '')
				{
					echo '<option value="Edit Delete Option Available" selected="selected">Edit Delete Option Available</option>';
				}
				if ($option_edit_delete == 'Edit Delete Option Denied')
				{	
					echo '<option value="Edit Delete Option Denied" selected="selected">Edit Delete Option Denied</option>';
				}
				?>
                    <option value="Edit Delete Option Available">Edit Delete Option Available</option>
                    <option value="Edit Delete Option Denied">Edit Delete Option Denied</option>
                  </select>                </td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                <td valign="middle" align="left" >&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                <td valign="middle" align="left" >&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                <td valign="middle" align="left" >&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                <td valign="middle" align="left" >&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                <td valign="middle" align="left" >&nbsp;</td>
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
                    <input name="Submit222" accesskey="s" type="submit"  value="Save Employee(Alt+S)" class="button"/>
                </font></font></font></font></font></div></td>
                </tr>
            </tbody>
          </table></td>
        </tr>
    </table>
	</form>
	<?php
	}
	?>
<script language="javascript">


</script>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>


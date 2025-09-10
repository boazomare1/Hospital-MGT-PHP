<?php
session_start();
ini_set('MAX_EXECUTION_TIME', -1);
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
if (isset($_REQUEST["searchemployeecode"])) {  $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }
if (isset($_REQUEST["mainmenu"])) {  $mainmenu = $_REQUEST["mainmenu"]; } else { $mainmenu = ""; }
if (isset($_REQUEST["frmflag"])) {   $frmflag1 = $_REQUEST["frmflag"]; } else { $frmflag1 = "55"; }


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

if (isset($_REQUEST["searchemployeecode"])) { $selectemployeecode = $_REQUEST["searchemployeecode"]; } else { $selectemployeecode = ""; }
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
<link href="autocomplete.css" rel="stylesheet">

<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>
<script type="text/javascript" src="js/autosuggestjobdescription1.js"></script>

<script type="text/javascript">
$(function() {
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());
});

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
}

function funcEmployeeSelect1()
{
	if (document.selectemployee.mainmenu.value == "")
	{
		alert ("Please Select the menu.");
		document.selectemployee.mainmenu.focus();
		return false;
	}
	
}

function funclocationChange1()
{

	
	<?php 
	$query12 = "select * from master_location where status = ''";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res12 = mysqli_fetch_assoc($exec12))
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
		while ($res10 = mysqli_fetch_assoc($exec10))
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
<script>
function checkboxreturn()
{
	return false;
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
	
	
	<form name="selectemployee" id="selectemployee" method="post" action="employeeaccessdetails_submenu.php" onSubmit="return funcEmployeeSelect1();">
	<table width="1300" height="29" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<?php if ($errmsg != '') { ?>
	<tr>
	  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
	  <td colspan="4" align="left" valign="middle" 
	  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
	  </tr>
	<?php } ?>
	<tr>
	<td width="9%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
	<td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Select Employee</strong></td>
	<td width="31%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
<!--	<select name="selectemployeecode" id="selectemployeecode">
	<option value="">Select Employee To Edit</option>
	<?php
	$query21 = "select * from master_employee where status = 'Active' order by employeename";
	$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res21 = mysqli_fetch_assoc($exec21))
	{
	$res21employeecode = $res21['employeecode'];
	$res21employeename = $res21['employeename'];
	?>
	<option value="<?php echo $res21employeecode; ?>"><?php echo $res21employeecode.' - '.$res21employeename; ?></option>
	<?php
	}
	?>
	</select>-->
	<input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
	<input name="searchdescription" id="searchdescription" type="hidden" value="">
	<input name="searchemployeecode" id="searchemployeecode" type="hidden" value="">
	<input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
	</td>
	<td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
	<strong>Select Mainmenu &nbsp;&nbsp;</strong>
	</td>
	<td width="30%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
	<select name="mainmenu" >
	<?php
	if($mainmenu=='')
	{
	?>
	<option value="">Select Menu</option>
	<?php
	}
	$qrymain = "select mainmenuid,mainmenutext from master_menumain where status <> 'deleted' order by mainmenuorder";
	$execmain = mysqli_query($GLOBALS["___mysqli_ston"], $qrymain) or die ("Error in qrymain".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($resmain = mysqli_fetch_assoc($execmain))
{
	?>
	<option value="<?= $resmain['mainmenuid']?>" <?php if($resmain['mainmenuid']==$mainmenu){echo "selected";}?>><?=$resmain['mainmenutext'];?></option>
	<?php
	}
	
	?>
	</select>
	</td>
	<td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
    <input name="frmflag" id="frmflag" type="hidden" value="frmflag">
	<input type="submit" name="Submit" value="Submit" >	</td>
	</tr>
	</tbody>
	</table>  
	</form>
<br><br>	

<table width="103%" border="0" cellspacing="0" cellpadding="2">
<?php
if($frmflag1=='frmflag')
{
?>
<tr>
	<td class="bodytext3"  bgcolor="#ecf0f5"><strong>Sno.</strong></td>
    <td class="bodytext3"  bgcolor="#ecf0f5"><strong>Emp. No.</strong></td>
    <td class="bodytext3"  bgcolor="#ecf0f5"><strong>User Name</strong></td>
<?php

$query1mm = "select submenutext from master_menusub where status <> 'deleted' and mainmenuid = '$mainmenu' order by submenuorder";
$exec1mm = mysqli_query($GLOBALS["___mysqli_ston"], $query1mm) or die ("Error in Query1mm".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1mm = mysqli_fetch_assoc($exec1mm))
{
$mainmenutext = $res1mm["submenutext"];
?>
    <td class="bodytext3"  bgcolor="#ecf0f5"><strong><?=$mainmenutext;?></strong></td>
  
  <?php
}
?>

			 <td colspan="12"></td>
		   	 <td class="bodytext31" valign="center"  align="right"><a href="print_employeeaccessdetails_submenu.php?searchemployeecode=<?=$searchemployeecode;?>&&mainmenu=<?=$mainmenu;?>" target="_blank"><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;"></a></td>
			  
  </tr>
   <?php
   
    
  $selec='';
  $colorloopcount=0;
  if($searchemployeecode <>'')
  {
  //$query02="select employeename,employeecode from master_employee where employeecode='$searchemployeecode' and status='Active' and is_user like 'yes'";
  $query02="select employeename,employeecode from master_employee where employeecode='$searchemployeecode' and status='Active' ";

  }
  else
  {
	  // $query02="select employeename,employeecode from master_employee where employeecode<>'' and employeename <>'' and employeecode in (select employeecode from master_employeerights where mainmenuid = '$mainmenu') and  status='Active' and is_user like 'yes'";

     $query02="select employeename,employeecode from master_employee where employeecode<>'' and employeename <>'' and employeecode in (select employeecode from master_employeerights where mainmenuid = '$mainmenu') and  status='Active' ";

  }
  $exe02=mysqli_query($GLOBALS["___mysqli_ston"], $query02);
  while($res02=mysqli_fetch_assoc($exe02))
  {
	  $employeename=$res02['employeename'];
	  $employeecode=$res02['employeecode'];
	  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				
				$colorcode = 'bgcolor="#FFFFFF"';
				//$colorcode = 'bgcolor="#ecf0f5"';
			}
			
			
			?>
			
            <tr <?php echo $colorcode; ?>>
  <td class="bodytext3"><?=$colorloopcount;?></td>          
  <td class="bodytext3"><?=$employeecode;?></td>
  <td class="bodytext3"><?=$employeename;?></td>
 
      <?php
	
  $query1mm = "select submenuid from master_menusub where status <> 'deleted' and mainmenuid = '$mainmenu' order by submenuorder";
$exec1mm = mysqli_query($GLOBALS["___mysqli_ston"], $query1mm) or die ("Error in Query1mm".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1mm = mysqli_fetch_assoc($exec1mm))
{
$mainmenuid = $res1mm["submenuid"];

 $query9 = "select employeecode from master_employeerights where employeecode = '$employeecode' and submenuid = '$mainmenuid'";
$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in query9".mysqli_error($GLOBALS["___mysqli_ston"]));
 $rowcount9 = mysqli_num_rows($exec9);
if ($rowcount9 != 0)
{
	$selec='src="images/select.png"';
}
else
{
	$selec='src="images/deselect.png"';
}
?>
    <td class="bodytext3" align="center"><img <?=$selec;?>  width="15" height="15" ></td>
  
  <?php

}
?>
</tr>
<?php

}
}
?>
</table>	
</table>

<?php include ("includes/footer1.php"); ?>
</body>
</html>


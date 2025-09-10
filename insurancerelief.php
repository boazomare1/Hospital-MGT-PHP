<?php
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");
$username = $_SESSION['username'];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = '';
$pagename = "";
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["frmflag12"])) { $frmflag12 = $_REQUEST["frmflag12"]; } else { $frmflag12 = ""; }
if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchemployeecode"])) { $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }
if ($frmflag12 == 'frmflag12')
{
	$rowcount = $_REQUEST['rowcount'];
	$employeecode = $_REQUEST['searchemployeecode'];
	$employeename = $_REQUEST['searchemployee'];
	$employeename = strtoupper($employeename);
	
	for($i=1;$i<$rowcount;$i++)
	{
		$insurancename = $_REQUEST['insurancename'.$i];
		$premium = $_REQUEST['premium'.$i];
		$taxpercent = $_REQUEST['taxpercent'.$i];
		$includepaye = $_REQUEST['includepaye'.$i];
		$includededuction = $_REQUEST['includededuction'.$i];
	
		$query4 = "insert into insurance_relief(employeecode, employeename, insurancename, premium, taxpercent, ipaddress, username, updatedatetime, includepaye,includededuction)
		values('$employeecode','$employeename','$insurancename','$premium','$taxpercent','$ipaddress','$username','$updatedatetime','$includepaye','$includededuction')";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"],$query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		
	}
	header("location:insurancerelief.php?st=success");	
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'success')
{
	$errmsg = "Success. Insurance Relief Updated.";
}
else if ($st == 'failed')
{
	$errmsg = "Failed. Insurance Relief Not Updated.";
}

else if($st == 'del')
{
$delanum = $_REQUEST['anum'];

$query8 = "update insurance_relief set status = 'deleted' where auto_number = '$delanum'";
$exec8 = mysqli_query($GLOBALS["___mysqli_ston"],$query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));

}
else if($st == 'active')
{
$editanum = $_REQUEST['anum'];
$query81 = "update insurance_relief set status = '' where auto_number = '$editanum'";
$exec81 = mysqli_query($GLOBALS["___mysqli_ston"],$query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
}

if($frmflag12 == 'frmflag12')
{
	$query45 = "select * from master_employee where employeecode = '$searchemployeecode'";
	$exec45 = mysqli_query($GLOBALS["___mysqli_ston"],$query45) or die ("Error in Query45".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res45 = mysqli_fetch_array($exec45);
	
	$employeecode = $res45['employeecode'];
	$employeename = $res45['employeename'];
	
}	

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
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script type="text/javascript" src="js/autosuggestemployeereportsearch1.js"></script>
<script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>
<script language="javascript">

window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchemployee"), new StateSuggestions());
  	
}

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

function WindowRedirect()
{
	window.location = "editemployeeinfo1.php";
}

$(document).ready(function(e) {
    $('#taxadd').click(function(){
		var insurancename = $('#insurancename').val();
		var premium = $('#premium').val();
		var taxpercent = $('#taxpercent').val();
		var includepaye = $('#includepaye').val();
		var includededuction = $('#includededuction').val();
		var rowcount = $('#rowcount').val();
		
		if(insurancename=="")
		{
			alert("Enter Insurancename");
			$('#insurancename').focus();
			return false;
		}
		else if(premium=="")
		{
			alert("Enter Premium");
			$('#premium').focus();
			return false;
		}
		else if(taxpercent=="")
		{
			alert("Enter Taxpercent");
			$('#taxpercent').focus();
			return false;
		}
		
		var rowbuild = "";
		rowbuild = rowbuild + '<tr id="TR'+rowcount+'">'+
			'<td align="left" class="bodytext3">'+
			'<input type="text" name="insurancename'+rowcount+'" id="insurancename'+rowcount+'" value="'+insurancename+'" readonly size="40" style="border:solid 1px #001E6A;">'+
			'</td><td align="left" class="bodytext3">'+
			'<input type="text" name="premium'+rowcount+'" id="premium'+rowcount+'" value="'+premium+'" size="15" readonly style="border:solid 1px #001E6A;">'+
			'</td><td align="left" class="bodytext3">'+
			'<input type="text" name="taxpercent'+rowcount+'" id="taxpercent'+rowcount+'" value="'+taxpercent+'" size="10" readonly style="border:solid 1px #001E6A;">'+
			'</td><td align="left" class="bodytext3">'+
			'<input type="text" name="includepaye'+rowcount+'" id="includepaye'+rowcount+'" value="'+includepaye+'" size="10" readonly style="border:solid 1px #001E6A;">'+
			'</td><td align="left" class="bodytext3">'+
			'<input type="text" name="includededuction'+rowcount+'" id="includededuction'+rowcount+'" value="'+includededuction+'" size="10" readonly style="border:solid 1px #001E6A;">'+
			'</td><td align="left" class="bodytext3">'+
			'<input type="button" name="taxdel'+rowcount+'" id="taxdel'+rowcount+'" value="Del" onclick="return Delrows('+rowcount+');">'+
			'</td></tr>';
			
			$('#addrows').append(rowbuild);
			$('#rowcount').val(parseInt(rowcount)+parseInt(1));
			var insurancename = $('#insurancename').val('');
			var premium = $('#premium').val('');
			var taxpercent = $('#taxpercent').val('');
			var includepaye = $('#includepaye').val('Yes');
			var includededuction = $('#includededuction').val('Yes');
	})
});

function Delrows(id){
	var confm = confirm("Are you sure to delete ?");
	if(confm == true)
	{
		$("#TR"+id).empty();
	}
}
</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
</head>
<script language="javascript">

function process1()
{
	if(document.getElementById("employeename").value == "")
	{
		alert("Please Enter Employeename");
		document.getElementById("employeename").focus();
		return false;
	}
	if(document.getElementById("employeecode").value == "")
	{
		alert("Please Select Employeename");
		//document.getElementById("employeename").focus();
		return false;
	}
}

function from1submit1()
{
	if(document.getElementById("searchemployee").value == "")
	{
		alert("Please Select Employee");
		document.getElementById("searchemployee").focus();
		return false;		
	}
	if(document.getElementById("searchemployeecode").value == "")
	{
		alert("Please Select Employee");
		document.getElementById("searchemployee").focus();
		return false;		
	}
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
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); 	//	include ("includes/menu2.php"); ?>	</td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">
		 <form name="form2" id="form2" method="post" onKeyDown="return disableEnterKey()" action="insurancerelief.php" onSubmit="return from1submit1()">
	<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#999999">
	<td colspan="5" align="left" class="bodytext3"><strong>Insurance Relief</strong></td>
	</tr>
	<?php if($errmsg != '') { ?>
	<tr bgcolor="#00FF66">
	<td colspan="5" align="left" class="bodytext3"><strong><?php echo $errmsg; ?></strong></td>
	</tr>
	<?php } ?>
	<tr>
	<td width="95" align="left" class="bodytext3">Search Employee</td>
	<td colspan="4" align="left" class="bodytext3">
	<input type="hidden" name="autobuildemployee" id="autobuildemployee">
	<input type="text" name="searchemployee" id="searchemployee" autocomplete="off" value="<?php echo $searchemployee; ?>" size="40" style="border:solid 1px #001E6A;">
	<input type="text" name="searchemployeecode" id="searchemployeecode" size="20" readonly style="border:solid 1px #001E6A;"></td>
	</tr>
    <tr>
    <td colspan="4">
    <table border="1" width="100%" cellpadding="5" cellspacing="5" style="border-collapse:collapse;">
    <thead>
	<tr bgcolor="#CCC">
	<th width="275" align="left" class="bodytext3"><strong>Insurance Name</strong></th>
    <th width="108" align="left" class="bodytext3"><strong>Premium Per Month</strong></th>
    <th width="101" align="left" class="bodytext3"><strong>Tax Percent</strong></th>
    <th width="112" align="left" class="bodytext3"><strong>Include in PAYE</strong></th>
    <th width="136" align="left" class="bodytext3"><strong>Include in Deduction</strong></th>
    <th width="51" align="left" class="bodytext3"><strong>Action</strong></th>
    </tr>
    </thead>
    <tbody id="addrows">
    </tbody>
    <tr>
	<td align="left" class="bodytext3">
	<input type="text" name="insurancename" id="insurancename" size="40" style="border:solid 1px #001E6A;">
	</td>
	<td align="left" class="bodytext3">
	<input type="text" name="premium" id="premium" size="15" style="border:solid 1px #001E6A;">
	</td>
	<td align="left" class="bodytext3">
	<input type="text" name="taxpercent" id="taxpercent" size="10" style="border:solid 1px #001E6A;">
	</td>
	<td align="left" class="bodytext3">
	<select name="includepaye" id="includepaye" style="border:solid 1px #001E6A;">
	<option value="Yes">Yes</option>
	<option value="No">No</option>
	</select>
	</td>
    <td align="left" class="bodytext3">
	<select name="includededuction" id="includededuction" style="border:solid 1px #001E6A;">
	<option value="Yes">Yes</option>
	<option value="No">No</option>
	</select>
	</td>
    <td align="left" class="bodytext3">
	<input type="button" name="taxadd" id="taxadd" value="Add" >
	</td>
	</tr>
    </table>
    </td>
    </tr>
	<tr>
		<td align="left">&nbsp;</td>
	<td width="560" align="left" class="bodytext3">
	<input type="hidden" name="frmflag12" id="frmflag12" value="frmflag12">
    <input type="hidden" name="rowcount" id="rowcount" value="1">
	<input type="submit" name="Search" value="Submit" style="border:solid 1px #001E6A;"></td>
	</tr>
	<tr>
	<td align="left" colspan="5">&nbsp;</td>
	</tbody>
	</table>
	</form>
	</td>
	</tr>
	<tr>
	 <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
	<td align="left" class="bodytext3">
	<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr>
	<td bgcolor="#999999" colspan="8" align="left" class="bodytext3"><strong>Insurance Relief - Existing</strong></td>
	</tr>
	<tr>
	<td align="center" class="bodytext3"><strong>Delete</strong></td>
	<td align="left" class="bodytext3"><strong>Employee</strong></td>
	<td align="left" class="bodytext3"><strong>Insurance</strong></td>
	<td align="left" class="bodytext3"><strong>Premium</strong></td>
	<td align="left" class="bodytext3"><strong>Tax Percent</strong></td>
	<td align="left" class="bodytext3"><strong>Paye</strong></td>
    <td align="left" class="bodytext3"><strong>Deduct</strong></td>
	<td align="left" class="bodytext3"><strong>Edit</strong></td>
	</tr>
	<?php
	$query6 = "select * from insurance_relief where status <> 'deleted' order by auto_number";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"],$query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res6 = mysqli_fetch_array($exec6))
	{
	$employeename = $res6['employeename'];
	$insurancename = $res6['insurancename'];
	$premium = $res6['premium'];
	$taxpercent = $res6['taxpercent'];
	$anum = $res6['auto_number'];
	$includepaye = $res6['includepaye'];
	$includededuction = $res6['includededuction'];
	
	$colorloopcount = $colorloopcount + 1;
		$showcolor = ($colorloopcount & 1); 
		if ($showcolor == 0)
		{
			$colorcode = 'bgcolor="#CBDBFA"';
		}
		else
		{
			$colorcode = 'bgcolor="#ecf0f5"';
		}
		
	?>
	<tr <?php echo $colorcode; ?>>
	<td align="left" class="bodytext3"><div align="center">	
		<a href="insurancerelief.php?st=del&&anum=<?php echo $anum; ?>"> 
		<img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
	<td align="left" class="bodytext3"><?php echo $employeename; ?></td>
	<td align="left" class="bodytext3"><?php echo $insurancename; ?></td>
	<td align="left" class="bodytext3"><?php echo $premium; ?></td>
	<td align="left" class="bodytext3"><?php echo $taxpercent; ?></td>
	<td align="left" class="bodytext3"><?php echo $includepaye; ?></td>
    <td align="left" class="bodytext3"><?php echo $includededuction; ?></td>
	<td align="left" class="bodytext3"><a href="editinsurancerelief.php?st=edit&&anum=<?php echo $anum; ?>">Edit</a></td>
	</tr>
	<?php
	}
	?>
	</tbody>
	</table>
	</td>
	</tr>
	<tr>
	<td align="left">&nbsp;</td>
	</tr>
	<tr>
	 <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
	<td align="left" class="bodytext3">
	<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr>
	<td bgcolor="#999999" colspan="7" align="left" class="bodytext3"><strong>Insurance Relief - Deleted</strong></td>
	</tr>
	<tr>
	<td align="center" class="bodytext3"><strong>Activate</strong></td>
	<td align="left" class="bodytext3"><strong>Employee</strong></td>
	<td align="left" class="bodytext3"><strong>Insurance</strong></td>
	<td align="left" class="bodytext3"><strong>Premium</strong></td>
	<td align="left" class="bodytext3"><strong>Tax Percent</strong></td>
	<td align="left" class="bodytext3"><strong>Paye</strong></td>
	<td align="left" class="bodytext3"><strong>&nbsp;</strong></td>
	</tr>
	<?php
	$query6 = "select * from insurance_relief where status = 'deleted' order by auto_number";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"],$query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($res6 = mysqli_fetch_array($exec6))
	{
	$employeename = $res6['employeename'];
	$insurancename = $res6['insurancename'];
	$premium = $res6['premium'];
	$taxpercent = $res6['taxpercent'];
	$anum1 = $res6['auto_number'];
	$includepaye = $res6['includepaye'];
	
	$colorloopcount = $colorloopcount + 1;
		$showcolor = ($colorloopcount & 1); 
		if ($showcolor == 0)
		{
			$colorcode = 'bgcolor="#CBDBFA"';
		}
		else
		{
			$colorcode = 'bgcolor="#ecf0f5"';
		}
		
	?>
	<tr <?php echo $colorcode; ?>>
	<td align="left" class="bodytext3"><div align="center">	
		<a href="insurancerelief.php?st=active&&anum=<?php echo $anum1; ?>"> 
		Activate</a></div></td>
	<td align="left" class="bodytext3"><?php echo $employeename; ?></td>
	<td align="left" class="bodytext3"><?php echo $insurancename; ?></td>
	<td align="left" class="bodytext3"><?php echo $premium; ?></td>
	<td align="left" class="bodytext3"><?php echo $taxpercent; ?></td>
	<td align="left" class="bodytext3"><?php echo $includepaye; ?></td>
	<td align="left" class="bodytext3">&nbsp;</td>
	</tr>
	<?php
	}
	?>
	</tbody>
	</table>
	</td>
	</tr>
    </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>


<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }
if (isset($_REQUEST["searchvisitcode"])) { $searchvisitcode = $_REQUEST["searchvisitcode"]; } else { $searchvisitcode = ""; }
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
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script type="text/javascript" src="js/autocomplete_ippatient.js"></script>
<script type="text/javascript" src="js/autosuggestippatient.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());   
}
</script>
<script language="javascript">

function cbsuppliername1()
{
	document.cbform1.submit();
}

function funcOnLoadBodyFunctionCall()
{ 
	//alert ("Inside Body On Load Fucntion.");
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	//funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
    //funcCreatePopup();
}
</script>
<script type="text/javascript">
function disableEnterKey(varPassed)
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}

	if(key == 13) // if enter key press
	{
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
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

function disableEnterKey()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}
	
	if(key == 13) // if enter key press
	{
		return false;
	}
	else
	{
		return true;
	}

}

function validchecking()
{
var customer = document.getElementById("customer").value;
if(customer == '')
{
alert("Please Select a Patient");
document.getElementById("customer").focus();
return false;
}
}
</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body onLoad="return funcOnLoadBodyFunctionCall()">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
              <form name="cbform1" method="post" action="ipuserreport.php" onSubmit="return validchecking()">
		<table width="799" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
			<tr bgcolor="#011E6A">
			  <td colspan="8" bgcolor="#ecf0f5" class="bodytext3"><strong>IP User Report</strong></td>
			</tr>
			<tr>
				<td width="14%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Patient Search </td>
				<td colspan="6" align="left" valign="middle"  bgcolor="#ecf0f5">
				<input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
				<input name="searchsuppliercode" id="searchsuppliercode" value="<?php echo $searchsuppliercode; ?>" type="hidden">
				<input name="searchvisitcode" id="searchvisitcode" value="<?php echo $searchvisitcode; ?>" type="hidden">
				<input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
				<input type="hidden" name="billnumbercode" id="billnumbercode" value="<?php echo $billnumbercode; ?>" readonly ></td>
				<td width="35%" align="left" valign="top"  bgcolor="#ecf0f5">
				<input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
				<input  type="submit" value="Search" name="Submit" onClick="return funcvalidcheck();"/>
				</td>
			</tr>
          </tbody>
        </table>
		</form></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  <form name="form11" id="form11" method="post" action="ipuserreport.php">	
	  <tr>
        <td>
		<?php
		$colorloopcount=0;
		$sno=0;
		if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
		if ($cbfrmflag1 == 'cbfrmflag1')
		{
		  $searchpatient = $_POST['searchsuppliername'];
		?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="797" 
            align="left" border="0">
          <tbody>
			<tr>
				<td colspan="2"  align="left" valign="center" 
				 class="bodytext31"><strong>Patient Name</strong></td>
				<td colspan="3"  align="left" valign="center" 
				 class="bodytext31"><?php echo $searchpatient; ?></td>
			    </tr>
			<tr>
				<td colspan="2" class="bodytext31" valign="center"  align="left" 
				><strong>IP Visit No</strong></td>
				<td colspan="3"  align="left" valign="center" 
				 class="bodytext31"><?php echo $searchvisitcode; ?></td>
				 </tr>
				 <tr>
				<td colspan="2" class="bodytext31" valign="center"  align="left" 
				>&nbsp;</td>
				<td colspan="3"  align="left" valign="center" 
				 class="bodytext31">&nbsp;</td>
				 </tr>
			<tr>
				<td width="7%" class="bodytext31" valign="center"  align="left" 
				bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="15%" class="bodytext31" valign="center"  align="left" 
				bgcolor="#ffffff"><strong>Activity</strong></td>
				<td width="58%" class="bodytext31" valign="center"  align="left" 
				bgcolor="#ffffff"><strong>User</strong></td>
				<td width="11%" class="bodytext31" valign="center"  align="left" 
				bgcolor="#ffffff"><strong>Date</strong></td>
				<td width="9%" class="bodytext31" valign="center"  align="left" 
				bgcolor="#ffffff"><strong>Time</strong></td>
				</tr>
           <?php
			if($searchpatient != '')
			{
			?>
			<tr bgcolor="#CBDBFA">
			<td class="bodytext31" valign="center"  align="center"><?php echo $sno = $sno + 1; ?></td>
			<td class="bodytext31" valign="center"  align="left">IP Visit</td>
			<?php
           $query34 = "select * from master_ipvisitentry where patientfullname like '%$searchpatient%' or patientcode like '%$searchsuppliercode%' or visitcode like '%$searchvisitcode%' order by auto_number desc ";
		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $num34=mysqli_num_rows($exec34);
		   $res34 = mysqli_fetch_array($exec34);
		   $res34username = $res34['username'];
		   $res34consultationdate = $res34['consultationdate'];
		   $res34consultationtime = $res34['consultationtime'];

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
				$colorcode = 'bgcolor="#ecf0f5"';
			}
			?>
			<td class="bodytext31" valign="center"  align="left"><?php echo $res34username; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $res34consultationdate; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $res34consultationtime; ?></td>
		  </tr>
		  
<tr bgcolor="#ecf0f5">
			<td class="bodytext31" valign="center"  align="center"><?php echo $sno = $sno + 1; ?></td>
			<td class="bodytext31" valign="center"  align="left">OP Admission Doctor</td>
		  <?php
		   $query35 = "select * from master_ipvisitentry where patientfullname like '%$searchpatient%' or patientcode like '%$searchpatient%' or visitcode like '%$searchpatient%' order by auto_number desc ";
		   $exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res35 = mysqli_fetch_array($exec35);
		   $res35opadmissiondoctor = $res35['opadmissiondoctor'];
		   $res35consultationdate = $res35['consultationdate'];
		   $res35consultationtime = $res35['consultationtime'];

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
				$colorcode = 'bgcolor="#ecf0f5"';
			}
			?>
			<td class="bodytext31" valign="center"  align="left"><?php echo $res35opadmissiondoctor; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php if($res35opadmissiondoctor!='') { echo $res35consultationdate; } ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php if($res35opadmissiondoctor!='') { echo $res35consultationtime; } ?></td>
		  </tr>

		   <?php
		   $query36 = "select * from master_ipvisitentry where patientfullname like '%$searchpatient%' or patientcode like '%$searchpatient%' or visitcode like '%$searchpatient%' order by auto_number desc ";
		   $exec36 = mysqli_query($GLOBALS["___mysqli_ston"], $query36) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res36 = mysqli_fetch_array($exec36);
		   $res36patientcode = $res36['patientcode'];
		   $res36visitcode = $res36['visitcode'];
		   ?>
	   <tr bgcolor="#CBDBFA">
		<td class="bodytext31" valign="center"  align="center"><?php echo $sno = $sno + 1; ?></td>
		<td class="bodytext31" valign="center"  align="left">Bed Allocation </td>
			<?php
		   
		   $query37 = "select * from ip_bedallocation where patientcode='$res36patientcode' and visitcode='$res36visitcode' order by auto_number desc ";
		   $exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res37 = mysqli_fetch_array($exec37);
		   $res37username = $res37['username'];
		   $res37recorddate = $res37['recorddate'];
		   $res37recordtime= $res37['recordtime'];

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
				$colorcode = 'bgcolor="#ecf0f5"';
			}
			?>
			<td class="bodytext31" valign="center"  align="left"><?php echo $res37username; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $res37recorddate; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $res37recordtime; ?></td>
		  </tr>

		  <?php
		   $query38 = "select * from master_ipvisitentry where patientfullname like '%$searchpatient%' or patientcode like '%$searchpatient%' or visitcode like '%$searchpatient%' order by auto_number desc ";
		   $exec38 = mysqli_query($GLOBALS["___mysqli_ston"], $query38) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res38 = mysqli_fetch_array($exec38);
		   $res38patientcode = $res38['patientcode'];
		   $res38visitcode = $res38['visitcode'];
		   ?>
		<tr bgcolor="#ecf0f5">
		<td class="bodytext31" valign="center"  align="center"><?php echo $sno = $sno + 1; ?></td>
		<td class="bodytext31" valign="center"  align="left">Discharge</td>
		<?php
		   $query39 = "select * from ip_discharge where patientcode='$res38patientcode' and visitcode='$res38visitcode' order by auto_number desc ";
		   $exec39 = mysqli_query($GLOBALS["___mysqli_ston"], $query39) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($res39 = mysqli_fetch_array($exec39))
		    {
		   $res39username = $res39['username'];
		   $res39recorddate = $res39['recorddate'];
		   $res39recordtime= $res39['recordtime'];

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
				$colorcode = 'bgcolor="#ecf0f5"';
			}
			?>
			<td class="bodytext31" valign="center"  align="left"><?php echo $res39username; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $res39recorddate; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $res39recordtime; ?></td>
		  </tr>
		  <?php
		  } 
          ?>
		  <?php
		   $query40 = "select * from master_ipvisitentry where patientfullname like '%$searchpatient%' or patientcode like '%$searchpatient%' or visitcode like '%$searchpatient%' order by auto_number desc ";
		   $exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $num40=mysqli_num_rows($exec40);
		   $res40 = mysqli_fetch_array($exec40);
		   $res40patientcode = $res40['patientcode'];
		   $res40visitcode = $res40['visitcode'];
		   ?>
   <tr bgcolor="#CBDBFA">
	<td class="bodytext31" valign="center"  align="center"><?php echo $sno = $sno + 1; ?></td>
	<td class="bodytext31" valign="center"  align="left">Bill Finalize</td>
			<?php
		   $query41 = "select * from master_transactionip where patientcode='$res40patientcode' and visitcode='$res40visitcode' order by auto_number desc ";
		   $exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $num41=mysqli_num_rows($exec41);
		   while($res41 = mysqli_fetch_array($exec41))
		    {
		      $res41username = $res41['username'];
		      $res41transactiondate = $res41['transactiondate'];
		      $res41transactiontime= $res41['transactiontime'];

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
				$colorcode = 'bgcolor="#ecf0f5"';
			}
			?>
			<td class="bodytext31" valign="center"  align="left"><?php echo $res41username; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $res41transactiondate; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $res41transactiontime; ?></td>
		  </tr>
		  <?php
		  } 
          ?>
            <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
             	<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			      </tr>
          </tbody>
        </table>
<?php
} }
?>	
		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
	  </form>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>


<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$icddatefrom = date('Y-m-d', strtotime('-1 month'));
$icddateto = date('Y-m-d');

$colorloopcount = '';
$sno = '';
$snocount = '';

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
$icddatefrom = $_REQUEST['ADate1'];
$icddateto = $_REQUEST['ADate2'];
}

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];
if ($ADate1 != '' && $ADate2 != '')
{
	$icdddatefrom = $_REQUEST['ADate1'];
	$icdddateto = $_REQUEST['ADate2'];
}
else
{
	$icdddatefrom = date('Y-m-d', strtotime('-1 month'));
	$icdddateto = date('Y-m-d');
}

?>
<script type="text/javascript">

function funcOnLoadBodyFunctionCall1()
{
//alert('h');
funcCustomerDropDownSearch1();
}
</script>
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
<?php include("autocompletebuild_icdcode.php"); ?>
<?php include ("js/dropdownlist1scriptingicdcode.php"); ?>
<script type="text/javascript" src="js/autocomplete_icdcode.js"></script>
<script type="text/javascript" src="js/autosuggesticdcode.js"></script> 
 <link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style3 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
</head>
<script>
function viewReport()
 {
window.open("<?php echo basename($_SERVER['PHP_SELF']); ?>","OriginalWindowA4",'width=922,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
  }
</script>
<script src="js/datetimepicker_css.js"></script>

<body onLoad="return funcOnLoadBodyFunctionCall1();">
<table width="1900" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
             <form name="cbform1" method="post" action="patientwiseicduser.php">
                <table width="750" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Patientwise ICD </strong>&nbsp;&nbsp;&nbsp;<a href="#" onClick="viewReport();"><strong>W</strong></a></td></td>
                      <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                      <td bgcolor="#ecf0f5" class="bodytext3" colspan="4">&nbsp;</td>
                    </tr>
					
					<tr>
                      <td width="13%"  align="left" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31"> Range </td>
                      <td width="21%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
					  <select name="range">
              <option value="">Range</option>
              <option value="equal">=</option>
              <option value="greater">></option>
			  <option value="lesser"><</option>
			  <option value="greaterequal">>=</option>
			  <option value="lesserequal"><=</option>
              </select>                      </td>
                      <td width="13%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Age </td>
                      <td width="21%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="age" id="age" size="10" />
                     </span></td>
                      <td width="13%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">Code</td>
                      <td width="19%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input type="text" name="icdcode" id="icdcode" size="15" autocomplete="off"></td>
					</tr>
                    <tr>
                      <td width="13%"  align="left" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31"> Date From </td>
                      <td width="21%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $icddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                      <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="13%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td colspan="3" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $icddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                      <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="5" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
                    </tr>
                  </tbody>
                </table>
              </form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1206" 
            align="left" border="0">
          <tbody>
            
            
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
				
				 $searchage = $_REQUEST['age'];
				 $searchrange = $_REQUEST['range'];
				 $searchicdcode = $_REQUEST['icdcode'];
				 $searchicdcode = trim($searchicdcode);
				?>
			<tr>
				<td width="2%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>No.</strong></td>
				<td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg.No</td>
				<td width="4%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">OP No</td>
				<td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">OP Date</td>
				<td width="12%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient</td>
				<td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Gender</td>
				<td width="4%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Age</td>
				<td width="7%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Department</td>
				<td width="22%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Primary Diagnosis</td>
				<td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">ICD Code</td>
				<td width="19%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Secondary Diagnosis</td>
				<td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">ICD Code</td>
				<td width="5%" rowspan="2" align="left" valign="center" bgcolor="#ecf0f5" class="style3"><span class="bodytext31"><a target="_blank" href="print_patientwiseicd.php?ADate1=<?php echo $icddatefrom; ?>&&ADate2=<?php echo $icddateto; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></span></td>
			</tr>
			
			<?php
			 if ($searchrange == '')
		  {         
		  if($searchicdcode == '')
		  {
		 $query1 = "select * from consultation_icd where age like '%$searchage%' and primaryicdcode like '%$searchicdcode%' and secicdcode like '%$searchicdcode%' and consultationdate between '$icddatefrom' and '$icddateto' order by auto_number desc ";
		   }
		   else
		   {
		    $query1 = "select * from consultation_icd where age like '%$searchage%' and primaryicdcode='$searchicdcode' or secicdcode='$searchicdcode' and consultationdate between '$icddatefrom' and '$icddateto' order by auto_number desc ";
		   }
		  }
		  else if ($searchrange == 'equal')
		  { 
		  if($searchicdcode == '')
		  {
		  $query1 = "select * from consultation_icd where age = '$searchage' and primaryicdcode like '%$searchicdcode%' and secicdcode like '%$searchicdcode%' and consultationdate between '$icddatefrom' and '$icddateto' order by auto_number desc ";
		 }
		 else
		 {
		  $query1 = "select * from consultation_icd where age = '$searchage' and primaryicdcode='$searchicdcode' or secicdcode='$searchicdcode' and consultationdate between '$icddatefrom' and '$icddateto' order by auto_number desc ";
		 }
		  }
		  else if ($searchrange == 'greater')
		  {
		  if($searchicdcode == '')
		  {
		  $query1 = "select * from consultation_icd where age > '$searchage' and primaryicdcode like '%$searchicdcode%' and secicdcode like '%$searchicdcode%' and consultationdate between '$icddatefrom' and '$icddateto' order by auto_number desc ";
		  }
		  else
		  {
		   $query1 = "select * from consultation_icd where age > '$searchage' and primaryicdcode='$searchicdcode' or secicdcode='$searchicdcode' and consultationdate between '$icddatefrom' and '$icddateto' order by auto_number desc ";
		  }
		  }
		  else if ($searchrange == 'lesser')
		  {
		  if($searchicdcode == '')
		  {
		   $query1 = "select * from consultation_icd where age < '$searchage' and primaryicdcode like '%$searchicdcode%' and secicdcode like '%$searchicdcode%' and consultationdate between '$icddatefrom' and '$icddateto' order by auto_number desc ";
		  }
		  else
		  {
		  $query1 = "select * from consultation_icd where age < '$searchage' and primaryicdcode='$searchicdcode' or secicdcode='$searchicdcode' and consultationdate between '$icddatefrom' and '$icddateto' order by auto_number desc ";
		  }
		  }
		  else if ($searchrange == 'greaterequal')
		  {
		   if($searchicdcode == '')
		  {
		  $query1 = "select * from consultation_icd where age >= '$searchage' and primaryicdcode like '%$searchicdcode%' and secicdcode like '%$searchicdcode%' and consultationdate between '$icddatefrom' and '$icddateto' order by auto_number desc ";
		  }
		  else
		  {
		   $query1 = "select * from consultation_icd where age >= '$searchage' and primaryicdcode='$searchicdcode' or secicdcode='$searchicdcode' and consultationdate between '$icddatefrom' and '$icddateto' order by auto_number desc ";
		  }
		  }
		  else if ($searchrange == 'lesserequal')
		  {
		    if($searchicdcode == '')
		  {
		  $query1 = "select * from consultation_icd where age <= '$searchage' and primaryicdcode like '%$searchicdcode%' and secicdcode like '%$searchicdcode%' and consultationdate between '$icddatefrom' and '$icddateto' order by auto_number desc ";
		  }
		  else
		  {
		   $query1 = "select * from consultation_icd where age <= '$searchage' and primaryicdcode='$searchicdcode' or secicdcode='$searchicdcode' and consultationdate between '$icddatefrom' and '$icddateto' order by auto_number desc ";
		  }
		  }
			
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res1 = mysqli_fetch_array($exec1))
			 {
			$res1patientcode= $res1['patientcode'];
			$res1patientvisitcode= $res1['patientvisitcode'];
			$res1consultationdate= $res1['consultationdate'];
			$res1patientname= $res1['patientname'];
			$res1disease= $res1['primarydiag'];
			$res1diseasecode= $res1['primaryicdcode'];
			$res2age = $res1['age'];
			
			$query2 = "select * from master_visitentry where patientcode = '$res1patientcode' ";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2 = mysqli_fetch_array($exec2);
			$res2gender= $res2['gender'];
			$res2consultationdate= $res2['consultationdate'];
			$res2department= $res2['departmentname'];
			
			$secondarydiagnosis = $res1['secondarydiag'];
			$secondarycode = $res1['secicdcode'];
			
			$snocount = $snocount + 1;
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
            
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientcode; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res1patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d-m-y',strtotime($res1consultationdate)); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res2gender; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res2age; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $res2department; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1disease; ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $res1diseasecode; ?></td>
				 <td class="bodytext31" valign="center"  align="left"><?php echo $secondarydiagnosis; ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $secondarycode; ?></td>

               </tr>
		   <?php 
		     
			 }
		   }
		   ?>
            <tr>
              <td colspan="2"  class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
			   </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>


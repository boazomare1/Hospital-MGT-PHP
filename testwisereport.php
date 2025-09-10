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
function valid()
{
	
	if(document.getElementById("icdcode").value == '')
	{
		alert("Please Select the Lab Name");
		return false;
	}
}
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
<!--<?php /*include("autocompletebuild_icdcode.php"); */?>
<?php //include ("js/dropdownlist1scriptingicdcode.php"); ?>
<script type="text/javascript" src="js/autocomplete_icdcode.js"></script>
<script type="text/javascript" src="js/autosuggesticdcode.js"></script> -->
<?php include("autocompletebuild_1lab.php"); ?>
<?php include ("js/dropdownlist1scriptinglabcode.php"); ?>
<script type="text/javascript" src="js/autocomplete_1lab.js"></script>
<script type="text/javascript" src="js/autosuggestlabcode.js"></script> 
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

<script src="js/datetimepicker_css.js"></script>

<body onLoad="return funcOnLoadBodyFunctionCall1();">
<table width="1900" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="testwisereport.php" onSubmit="return valid();">
                <table width="750" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Test wise Report </strong></td>
                      <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                      <td bgcolor="#ecf0f5" class="bodytext3" colspan="4">&nbsp;</td>
                    </tr>
					<tr>
					<td width="13%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><strong>Select Lab</strong></td>
                      <td width="19%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input type="text" name="icdcode" id="icdcode" size="50" autocomplete="off"></td>
					  <td colspan="2" bgcolor="#FFFFFF" >&nbsp;</td>
					</tr>
					<tr>
                      <td width="13%"  align="left" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31"> <strong>Range</strong> </td>
                      <td width="21%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
					  <select name="range">
              <option value="">Range</option>
              <option value="equal">=</option>
              <option value="greater">></option>
			  <option value="lesser"><</option>
			  <option value="greaterequal">>=</option>
			  <option value="lesserequal"><=</option>
              </select>                      </td>
                      <td width="13%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><strong> Age</strong> </td>
                      <td width="21%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="age" id="age" size="10" />
                     </span></td>
                      
					</tr>
                    <tr>
                      <td width="13%"  align="left" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31"> <strong>Date From</strong> </td>
                      <td width="21%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $icddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                      <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="13%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> <strong>Date To</strong> </td>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="947" 
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
				<td width="6%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>No.</strong></td>
				<td width="25%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Name</td>
				<td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg NO</td>
				<td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit Code</td>
				<td width="8%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Date</td>
				<td width="8%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Age</td>
				<td width="8%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Gender</td>
				<td width="25%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Result</td>
			</tr>
			
			<?php
		  if($searchicdcode == '')
		  {
		 $query1 = "select * from resultentry_lab where itemname = '$searchicdcode' and recorddate between '$icddatefrom' and '$icddateto' and resultvalue !='' order by auto_number desc ";
		  }
		   else
		   {
		    $query1 = "select * from resultentry_lab where itemname='$searchicdcode' and recorddate between '$icddatefrom' and '$icddateto' and resultvalue !='' order by auto_number desc ";
		   }
			
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res1 = mysqli_fetch_array($exec1))
			 {
				$res1patientcode= $res1['patientcode'];
				$res1patientvisitcode= $res1['patientvisitcode'];
				$res1consultationdate= $res1['recorddate'];
				$res1patientname= $res1['patientname'];
				$res1resultvalue= $res1['resultvalue'];
				$res1referencename=$res1['referencename'];
				
				$query751 = "select * from master_customer where customercode = '$res1patientcode'";
				$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res751 = mysqli_fetch_array($exec751);
				$dob = $res751['dateofbirth'];
				$gender = $res751['gender'];
			
			        $today = new DateTime();
					$diff = $today->diff(new DateTime($dob));
					
					if ($diff->y)
					{
					$res2age= $diff->y . ' Years';
					}
					elseif ($diff->m)
					{
					$res2age=$diff->m . ' Months';
					}
					else
					{
					$res2age=$diff->d . ' Days';
					}
			if ($res1patientcode == 'walkin')
			{ 
			  //$res2age=$res1['age'];
			}  

			if ($searchrange == '')
		     { 
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
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientname; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res1patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d-m-y',strtotime($res1consultationdate)); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res2age; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1referencename.' '.':'.' '.$res1resultvalue; ?></td>
               </tr>
		   <?php 
		  }
			
		  if ($searchrange == 'equal')
		  { 
		  if($searchage == $diff->y)
		  {
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
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientname; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res1patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d-m-y',strtotime($res1consultationdate)); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res2age; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1referencename.' '.':'.' '.$res1resultvalue; ?></td>
               </tr>
		   <?php 
		 }
		  }
		  else if ($searchrange == 'greater')
		  {
		  if($searchage < $diff->y)
		  {
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
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientname; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res1patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d-m-y',strtotime($res1consultationdate)); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res2age; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1referencename.' '.':'.' '.$res1resultvalue; ?></td>
               </tr>
		   <?php 
		  }
		  }
		  else if ($searchrange == 'lesser')
		  {
		  if($searchage > $diff->y)
		  {
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
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientname; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res1patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d-m-y',strtotime($res1consultationdate)); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res2age; ?></td>
			    <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1referencename.' '.':'.' '.$res1resultvalue; ?></td>
               </tr>
		   <?php 
		  }
		  }
		  else if ($searchrange == 'greaterequal')
		  {
		   if($searchage <= $diff->y)
		  {
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
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientname; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res1patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d-m-y',strtotime($res1consultationdate)); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res2age; ?></td>
			    <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1referencename.' '.':'.' '.$res1resultvalue; ?></td>
               </tr>
		   <?php 
		  }
		  }
		  else if ($searchrange == 'lesserequal')
		  {
		    if($searchage >= $diff->y)
		  {
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
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientname; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res1patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo date('d-m-y',strtotime($res1consultationdate)); ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res2age; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $gender; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1referencename.' '.':'.' '.$res1resultvalue; ?></td>
               </tr>
		   <?php 
		  }
		  }
			
			
			 }
			 ?>
             <tr bgcolor="#CCC">
             <td align="left" colspan="10">&nbsp;</td>
             </tr>
             <tr>
             <td class="bodytext31" valign="center"  align="left"> 
                  <a target="_blank" href="print_testwisereport.php?cbfrmflag1=cbfrmflag1&&searchrange=<?php echo $searchrange; ?>&&searchage=<?php echo $searchage; ?>&&searchicdcode=<?php echo $searchicdcode; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>"> <img src="images/excel-xls-icon.png" width="30" height="30"></a>
             </td>
             </tr>
             <?php
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
			   </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>


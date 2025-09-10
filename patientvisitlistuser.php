<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$timeonly = date('H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
		
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
if (isset($_REQUEST["code"])) { $code = $_REQUEST["code"]; if($code == '0'){ $code = "";} } else { $code = ""; }
if (isset($_REQUEST["department"])) { $department = $_REQUEST["department"]; } else { $department = " "; }
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
.number1
{
text-align:right;
padding-left:700px;
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

function cbcustomername1()
{
	document.cbform1.submit();
}

</script>
<script type="text/javascript" src="js/autocomplete_customer1.js"></script>
<script type="text/javascript" src="js/autosuggest3.js"></script>
<script type="text/javascript">
/*
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        
}
*/

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
</script>
<script>
function viewReport()
 {
window.open("<?php echo basename($_SERVER['PHP_SELF']); ?>","OriginalWindowA4",'width=922,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
  }
</script>
<script src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>

<body>
<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	    <tr>
	 <td width="860">
              <form name="cbform1" method="post" action="patientvisitlistuser.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr>
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext31"><strong>Patient List </strong>&nbsp;&nbsp;&nbsp;<a href="#" onClick="viewReport();"><strong>W</strong></a></td>
			    </tr>
					<tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                 </tr>				
			 		<tr>
					  <td width="20%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Type</td>
					  <td width="82%" colspan="1" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
						<select id="code" name="code"><option value="0">Select</option><option value="1">New</option><option value="2">Revisit</option></select>
					  </span></td>
					  <td bgcolor="#FFFFFF" class="bodytext3">Department</td>
					  <td bgcolor="#FFFFFF" class="bodytext3"><strong><select id="department" name="department"><option value="">Select</option>
					          <?php
				$query6 = "select * from master_department where recordstatus = '' and auto_number <> '7' order by department ";
				$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res6 = mysqli_fetch_array($exec6))
				{
				$res6anum = $res6["auto_number"];
				$res6department = $res6["department"];
				?>
                        <option value="<?php echo $res6department; ?>" ><?php echo $res6department; ?></option>
                        <?php
				}
				?>
                      </select>
				  </strong></td>
					</tr>	
				<tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
                    </tr>
                  </tbody>
                </table>
              </form>		</td>
	 </tr>  
	  <tr><td>&nbsp;</td></tr>		        
      <tr>
	  <?php if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			if($cbfrmflag1 == 'cbfrmflag1'){ ?>

	  <tr><form action="insurancelist.php" name="checklist" method="post">
        <td><table width="60%" height="80" border="0" 
            align="left" cellpadding="2" cellspacing="0" 
            bordercolor="#666666" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" >
          <tbody>
            <tr>
              <td colspan="7" bgcolor="#ecf0f5" class="bodytext31">
                <div align="left"><strong>Patient List </strong></div></td>
			    </tr>
	
            <tr>
			  <td width="3%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sno</strong></div></td>
              <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></td>
				 <td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Registration No</strong></div></td>
				<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit No</strong></div></td>
				<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit Date</strong></div></td>
              <td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Department</strong></div></td>
			  <td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Type</strong></div></td>
           </tr>
			<?php
			
			$colorloopcount = '';
			$sno = '';
			if($code <= 1){		
			$query1 = "select * from master_visitentry where consultationdate between '$ADate1' and '$ADate2' and visitcount like '%$code%' and departmentname like '%$department%' order by consultationdate desc";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			else
			{
			$query1 = "select * from master_visitentry where consultationdate between '$ADate1' and '$ADate2' and visitcount NOT IN (1) and departmentname like '%$department%' order by consultationdate desc";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$patientname = $res1['patientfullname'];
			$registrationno = $res1['patientcode'];
			$visitno = $res1['visitcode'];
			$visitdate =$res1['consultationdate'];
			$department = $res1['departmentname'];
			$visitcount = $res1['visitcount'];
						
			//$query2 = "select * from master_doctor where auto_number = '$consultingdoctoranum'";
			//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			//$res2 = mysql_fetch_array($exec2);
			//$consultingdoctorname  = $res2['doctorname'];
			
			if($visitcount <= 1){$visitcount = 'New';}else{$visitcount = 'Revisit';}
			
			$sno = $sno + 1;
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
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $patientname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $registrationno; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitdate;?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $department;?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $visitcount;?></div></td>
              </tr>
              
			<?php
			}
			
			 
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"></td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			  <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
   	       </tr>
          </tbody>
		  
        </table>
      </td> </form>
  </tr><?php } ?>
	</table>
	  
	
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>


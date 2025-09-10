<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$sno = '';
$colorloopcount = '';
$searchemployeename = '';
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
	$searchemployeename = $_REQUEST["employeename"];
}

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
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
<script language="javascript">

function cbcustomername1()
{
	document.cbform1.submit();
}

</script>
<script type="text/javascript" src="js/autocomplete_customer1.js"></script>
<script type="text/javascript" src="js/autosuggest3.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        
}

function loadprintpage1(banum)
{
	var varbanum = banum;
	//alert (varqanum);
	window.open("viewshiftreport1.php?anum="+varbanum+"","Window"+varbanum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}


</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; }
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

<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="shiftwisereport1user.php">
		<table width="791" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong> Shiftwise Report</strong>&nbsp;&nbsp;&nbsp;<a href="#" onClick="viewReport();"><strong>W</strong></a></td>
              <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td width="17%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><!--Search Customer -->
                <span class="bodytext32">User</span></td>
              <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <select name="employeename" id="employeename">
<!--                  <option value=""> SELECT EMPLOYEE NAME</option>
-->                  <?php
				 $query5 = "select * from master_employee where status = 'Active' and username = '$username' order by employeename desc";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$employeename = $res5["employeename"];
				$res5username = $res5["username"];
				?>
                  <option value="<?php echo $res5username; ?>"><?php echo $employeename; ?></option>
                  <?php
				}
				?>
                </select>
              </span></td>
              <td width="13%" align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
              <td width="28%" align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
			 <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>	
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input type="submit" value="Search" name="Submit" />
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="564" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="7%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="16%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>ID</strong></td>
              <td width="20%" align="left" valign="center"  
                bgcolor="#ffffff" class="style1">Username</td>
              <td width="27%" align="left" valign="center"  
                bgcolor="#ffffff" class="style1">Shiftstarttime</td>
              <td width="30%"  align="left" valign="center" 
                bgcolor="#ffffff" class="style1">Shiftouttime</td>
              <td  align="left" valign="center" 
                bgcolor="#ffffff" class="style1"><div align="center">View</div></td>
            </tr>
			<?php
			$ADate2 = date('Y-m-d H:i:s', strtotime($ADate2 . ' + 1 day'));
			
			$query31 = "select* from shift_tracking where username = '$searchemployeename' and lastupdate between '$ADate1' and '$ADate2' order by auto_number desc";
			$exe31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num1 = mysqli_num_rows($exe31);
			while($res31 = mysqli_fetch_array($exe31))
			{
			$res31anum = $res31["auto_number"];
			$shiftstarttime = $res31["shiftstarttime"];
			$shiftouttime = $res31["shiftouttime"];
			$res31username = $res31["username"];
			
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
			if($shiftouttime != "0000-00-00 00:00:00")
			{
			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res31anum; ?></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res31username; ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $shiftstarttime; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $shiftouttime; ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="center">		
					
				  <a href="shiftwisereportdetailed.php?anum=<?php echo $res31anum; ?>"><span class="bodytext3" >View</span></a>
				  
				</div></td>
            </tr>
			<?php
			}
			}
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
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
        </table></td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>


<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$sno = '';

if (isset($_REQUEST["tblid"])) { $tblid = $_REQUEST["tblid"]; } else { $tblid = ""; }
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = isset($_POST["frmflag1"]);
if ($frmflag1 == 'frmflag1')
{
	$tblname = $_REQUEST['tblname'];
for ($p=1;$p<=50;$p++)
		{	
			if(isset($_REQUEST['paynowlabcode'.$p]))
			{

				$paynowlabcode = $_REQUEST['paynowlabcode'.$p];

				if($paynowlabcode != '')
				{

					$fieldcol = $_REQUEST['tblcolumn'.$p];
					$paynowlabcoa = $_REQUEST['paynowlabcoa'.$p];
					$paynowlabsel = $_REQUEST['paynowlabsel'.$p];
					$paynowlabtype = $_REQUEST['paynowlabtype'.$p];
					$paynowlabcode = $_REQUEST['paynowlabcode'.$p];
					$paynowcond = $_REQUEST['paynowcond'.$p];
					$paynowdate = $_REQUEST['paynowdate'.$p];
					$displayname = $_REQUEST['displayname'.$p];
					$displayname = strtoupper($displayname);
					$groupcode = $_REQUEST['groupcode'.$p];
					
					$query7 = "select * from master_accountname where id = '$paynowlabcode'";
					$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die (mysqli_error($GLOBALS["___mysqli_ston"]));
					$res7 = mysqli_fetch_array($exec7);
					$accountssub = $res7['accountssub'];
					
					$query8 = "select * from master_accountssub where auto_number = '$accountssub'";
					$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die (mysqli_error($GLOBALS["___mysqli_ston"]));
					$res8 = mysqli_fetch_array($exec8);
					$accountsmain = $res8['accountssub'];

					if($paynowlabcode != '')
					{
						$query88 = "select * from master_financialintegration where tblname = '$tblname' and field = '$fieldcol' and selectstatus = '$paynowlabsel' and type = '$paynowlabtype' and groupcode = '$accountssub'";
						$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));
						$rows88 = mysqli_num_rows($exec88);
						//if($rows88 == 0)
						//{
							$query33 = "insert into master_financialintegration(tblname,field,coa,selectstatus,type,code,ipaddress,recorddate,username,groupcode, groupname, condfield, datefield, displayname)
							values('$tblname','$fieldcol','$paynowlabcoa','$paynowlabsel','$paynowlabtype','$paynowlabcode','$ipaddress','$updatedatetime','$username','$groupcode','$accountsmain','$paynowcond','$paynowdate','$displayname')";
							$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
						//}
						//else
						//{
							//header("location:financialintegrationacc.php?st=failed");
							//exit;
						//}
					}
				}
			}		
		}
header("location:financialintegrationacc.php?st=success");
}


if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = isset($_REQUEST["st"]);
if ($st == 1)
{
	$errmsg = "Login Failed. Please Try Again With Proper User Id and Password.";
}

?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5; 
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; 
}
.bodytext5 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; 
}
-->
</style>

<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script>
function coasearch(varCallFrom,id)
{
	var varCallFrom = varCallFrom;
	var id = id;
	window.open("popup_coasearch.php?callfrom="+varCallFrom+"&&id="+id,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}

function process1login1()
{
	for(var i=0;i<50;i++)
	{
		if(document.getElementById("paynowlabcode"+i) != null)
		{	
			if(document.getElementById("paynowlabcode"+i).value != "")
			{	
				if(document.getElementById("displayname"+i).value == "")
				{
					alert("Please Enter Display Name");
					document.getElementById("displayname"+i).focus();
					return false;
				}
				if(document.getElementById("paynowlabsel"+i).value == "")
				{
					alert("Please Select Cr / Dr");
					document.getElementById("paynowlabsel"+i).focus();
					return false;
				}
				if(document.getElementById("paynowdate"+i).value == "")
				{
					alert("Please Select Date Field");
					document.getElementById("paynowdate"+i).focus();
					return false;
				}				
			}
		}
	}
}
</script>
</head>

<body onLoad="return setFocus()">
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
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">
		  	  	<form id="form1" name="form1" method="post" action="financialintegrationtbl.php" onSubmit="return process1login1()">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
        <tr>
          <td><table width="1268" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse; ">
              <tbody>	
			  			<tr>
							<td align="left" colspan="10"  class="bodytext3"><strong>&nbsp;</strong></td>
							</tr>
			  			 <tr bgcolor="#ecf0f5">
							<td align="left" colspan="10" class="bodytext5"><strong>Financial Integration for <?php echo $tblid; ?></strong></td>
							</tr>
							
			              <tr>
							<td align="left" class="bodytext5"><strong>Table</strong></td>
							<td align="left" colspan="9" class="bodytext3"><select name="tblname" id="tblname">
							<?php if($tblid != '') { ?>
							<option value="<?php echo $tblid; ?>"><?php echo $tblid; ?></option>
							<?php } ?>
							</select></td>
						 </tr>     
					   <tr bgcolor="#ecf0f5">
                        <td width="78" align="left" valign="top"  class="bodytext3"><strong>Field</strong></td>
                        <td width="353" align="left" valign="top"  class="bodytext3"><strong>Select COA</strong></td>
                        <td width="164" align="left" valign="top"  class="bodytext3"><strong>Display Name</strong></td>
                        <td width="74" align="left" valign="top"  class="bodytext3"><strong>Date Field</strong></td>
                        <td width="73" align="left" valign="top"  class="bodytext3"><strong>Condition Field</strong></td>
                        <td width="73" align="left" valign="top"  class="bodytext3"><strong>Select</strong></td>
                        <td width="48" align="left" valign="top"  class="bodytext3"><strong>Type</strong></td>
                        <td width="50" align="left" valign="top"  class="bodytext3"><strong>Code</strong></td>
                        <td width="283" align="left" valign="top"  class="bodytext3"><strong>Group Code</strong></td>
				  </tr>
				 <?php
				 $query8 = "SHOW COLUMNS from $tblid";
				 $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
				 while($res8 = mysqli_fetch_array($exec8))
				 {
				 	$tblfield = $res8['Field'];
				    $tbltype = $res8['Type'];
					$tbllen = strlen($tbltype);
					$dttype = substr($tbltype,0,7);
					$dttype1 = substr($tbltype,0,3);
					if($tblfield != 'auto_number')
					{
				 	if($dttype == 'decimal' || $dttype1 == 'int')
					{
					$sno = $sno + 1;
					?>
				  <tr>
				  <td width="78" align="left" valign="top"  class="bodytext5"><strong><?php echo $tblfield; ?></strong>
				    <input type="hidden" name="tblcolumn<?php echo $sno; ?>" value="<?php echo $tblfield; ?>" /></td>
                        <td align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa<?php echo $sno; ?>" id="paynowlabcoa<?php echo $sno; ?>" size="25" readonly/>
                        <input type="button" value="Map" onClick="javascript:coasearch('1','<?php echo $sno; ?>')"></td>
                        <td align="left" valign="top"  class="bodytext3"><input type="text" name="displayname<?php echo $sno; ?>" id="displayname<?php echo $sno; ?>" size="20"></td>
                        <td align="left" valign="top" class="bodytext3">
                         <select name="paynowdate<?php echo $sno; ?>" id="paynowdate<?php echo $sno; ?>">
						<?php
					 $query96 = "SHOW COLUMNS from $tblid";
					 $exec96 = mysqli_query($GLOBALS["___mysqli_ston"], $query96) or die ("Error in Query96".mysqli_error($GLOBALS["___mysqli_ston"]));
					 while($res96 = mysqli_fetch_array($exec96))
					 {
				 	$tblfield4 = $res96['Field'];
				    $tbltype4 = $res96['Type'];
					$tbllen4 = strlen($tbltype4);
					$dttype4 = substr($tbltype4,0,4);
				 	if($dttype4 == 'date')
					{
					?>
						<option value="<?php echo $tblfield4; ?>"><?php echo $tblfield4; ?></option>
                  <?php } } ?>
                  </select></td> 
                  <td align="left" valign="top" class="bodytext3">
                         <select name="paynowcond<?php echo $sno; ?>" id="paynowcond<?php echo $sno; ?>">
                         <option value="">Select</option>
						<?php
				 $query98 = "SHOW COLUMNS from $tblid";
				 $exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die ("Error in Query98".mysqli_error($GLOBALS["___mysqli_ston"]));
				 while($res98 = mysqli_fetch_array($exec98))
				 {
				 	$tblfield5 = $res98['Field'];
					?>
						<option value="<?php echo $tblfield5; ?>"><?php echo $tblfield5; ?></option>
                  <?php } ?>
                  </select></td>     
                        <td width="73" align="left" valign="top"  class="bodytext3">
						<select name="paynowlabsel<?php echo $sno; ?>" id="paynowlabsel<?php echo $sno; ?>">
						<option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
					</select></td>
                    <td width="48" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype<?php echo $sno; ?>" id="paynowlabtype<?php echo $sno; ?>" size="4" readonly/></td>
                    <td align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode<?php echo $sno; ?>" id="paynowlabcode<?php echo $sno; ?>" size="5" readonly/></td>
                    <td align="left" valign="top"  class="bodytext3"><input type="text" name="groupcode<?php echo $sno; ?>" id="groupcode<?php echo $sno; ?>" size="4" readonly/></td>
				  </tr>
				 <?php
				   }
					}
				  }
				  ?> 
                <tr>
                 <td align="middle" valign="top">&nbsp;</td>
                  <td align="middle" valign="top"><div align="left">
                      <input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1" />
                      <input type="submit" name="Submit" value="Save" style="border: 1px solid #001E6A" />
                      
                  </div></td>
                   <td align="middle" valign="top" colspan="8"><div align="right">
                     &nbsp;
                  </div></td>
                </tr>
              </tbody>
            </table>
           
        </td>
        </tr>
      </table>
	</form>
    </td>
	</tr>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>


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
if (isset($_REQUEST["group"])) { $group = $_REQUEST["group"]; } else { $group = ""; }
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = isset($_POST["frmflag1"]);
if ($frmflag1 == 'frmflag1')
{
	
for ($p=1;$p<=50;$p++)
		{	
			if(isset($_REQUEST['paynowlabcode'.$p]))
			{

				$paynowlabcode = $_REQUEST['paynowlabcode'.$p];

				if($paynowlabcode != '')
				{
					$anum = $_REQUEST['anum'.$p];
					$tblname = $_REQUEST['tblname'.$p];
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
					
					$query8 = "select * from master_accountssub where auto_number = '$groupcode'";
					$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die (mysqli_error($GLOBALS["___mysqli_ston"]));
					$res8 = mysqli_fetch_array($exec8);
					$accountsmain = $res8['accountssub'];

					if($paynowlabcode != '')
					{
				    $query33 = "update master_financialintegration set tblname='$tblname',field='$fieldcol',coa='$paynowlabcoa',selectstatus='$paynowlabsel',type='$paynowlabtype',code='$paynowlabcode',ipaddress='$ipaddress',
					recorddate='$updatedatetime',username='$username',groupcode='$groupcode', groupname='$accountsmain', condfield='$paynowcond', datefield='$paynowdate', displayname='$displayname' where auto_number = '$anum'";
					$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
				}
			}		
		}
header("location:editfinancialintegrationtbl.php?st=success");
}


if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if (isset($_REQUEST["delanum"])) { $delanum = $_REQUEST["delanum"]; } else { $delanum = ""; }
if (isset($_REQUEST["actanum"])) { $actanum = $_REQUEST["actanum"]; } else { $actanum = ""; }
if ($st == "del" && $delanum != '')
{
	$query78 = "update master_financialintegration set recordstatus = 'deleted' where auto_number = '$delanum'";
	$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die("Error in Query78".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == "activate" && $actanum != '')
{
	$query79 = "update master_financialintegration set recordstatus = '' where auto_number = '$actanum'";
	$exec79 = mysqli_query($GLOBALS["___mysqli_ston"], $query79) or die("Error in Query79".mysqli_error($GLOBALS["___mysqli_ston"]));
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
function Pgload(code)
{
	var code = code;
	window.location = "editfinancialintegrationtbl.php?group="+code+"";	
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
		  	  	<form id="form1" name="form1" method="post" action="editfinancialintegrationtbl.php" onSubmit="return process1login1()">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
        <tr>
          <td><table width="1268" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse; ">
              <tbody>	
			  			<tr>
							<td align="left" colspan="12"  class="bodytext3"><strong>&nbsp;</strong></td>
							</tr>
			  			 <tr bgcolor="#999999">
							<td align="left" colspan="12" class="bodytext5"><strong>Edit Financial Integration</strong></td>
							</tr>
							
			              <tr>
							<td align="left" colspan="11" class="bodytext3"><strong>Select Group</strong>&nbsp;&nbsp;<select name="group" id="group" onChange="return Pgload(this.value);">
                            <option value=""> Select </option>
                            <?php 
                            $query7 = "select * from master_accountssub where recordstatus <> 'deleted' order by auto_number";
                            $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($res7 = mysqli_fetch_array($exec7))
                            {
                            $groupname = $res7['accountssub'];
                            $groupcode = $res7['auto_number'];
                            ?>
                            <option value="<?php echo $groupcode; ?>" <?php if($group == $groupcode) { echo "selected=selected"; } ?>> <?php echo $groupname; ?> </option>
                            <?php
                            }
                            ?>
                            </select>
                			</td>
						 </tr>  
                         <?php if($group != '') { ?>   
					   <tr bgcolor="#ecf0f5">
                        <td width="20" align="left" valign="top"  class="bodytext3"><strong>Delete</strong></td>
                        <td width="78" align="left" valign="top"  class="bodytext3"><strong>Table</strong></td>
                        <td width="78" align="left" valign="top"  class="bodytext3"><strong>Field</strong></td>
                        <td width="390" align="left" valign="top"  class="bodytext3"><strong>Select COA</strong></td>
                        <td width="164" align="left" valign="top"  class="bodytext3"><strong>Display Name</strong></td>
                        <td width="74" align="left" valign="top"  class="bodytext3"><strong>Date Field</strong></td>
                        <td width="73" align="left" valign="top"  class="bodytext3"><strong>Condition Field</strong></td>
                        <td width="73" align="left" valign="top"  class="bodytext3"><strong>Select</strong></td>
                        <td width="48" align="left" valign="top"  class="bodytext3"><strong>Type</strong></td>
                        <td width="50" align="left" valign="top"  class="bodytext3"><strong>Code</strong></td>
                        <td width="283" align="left" valign="top"  class="bodytext3"><strong>Group Code</strong></td>
				  </tr>
				 <?php
				 $query8 = "select * from master_financialintegration where groupcode = '$group' and recordstatus <> 'deleted'";
				 $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
				 while($res8 = mysqli_fetch_array($exec8))
				 {
				 	$anum = $res8['auto_number'];
				    $tblname = $res8['tblname'];
					$displayname = $res8['displayname'];
					$field = $res8['field'];
					$condfield = $res8['condfield'];
					$datefield = $res8['datefield'];
					$coa = $res8['coa'];
					$selectstatus = $res8['selectstatus'];
					$type = $res8['type'];
					$code = $res8['code'];
					$groupcode = $res8['groupcode'];
					
					$sno = $sno + 1;
					?>
				  <tr>
                  <td align="left" valign="top"  class="bodytext5"><a href="editfinancialintegrationtbl.php?st=del&&group=<?php echo $group; ?>&&delanum=<?php echo $anum; ?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></td>
				  <td width="78" align="left" valign="top"  class="bodytext5"><strong><input type="text" value="<?php echo $tblname; ?>" size="18" readonly/></strong></td>
                  <td width="78" align="left" valign="top"  class="bodytext5"><strong>
                  <select name="tblcolumn<?php echo $sno; ?>">
                  <option value="<?php echo $field; ?>"><?php echo $field; ?></option>
                  <?php
                   $query81 = "SHOW COLUMNS from $tblname";
				 $exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die ("Error in Query81".mysqli_error($GLOBALS["___mysqli_ston"]));
				 while($res81 = mysqli_fetch_array($exec81))
				 {
				 	$tblfield = $res81['Field'];
				    $tbltype = $res81['Type'];
					$tbllen = strlen($tbltype);
					$dttype = substr($tbltype,0,7);
					$dttype1 = substr($tbltype,0,3);
					if($tblfield != 'auto_number')
					{
				 	if($dttype == 'decimal' || $dttype1 == 'int')
					{
                    ?>
                    <option value="<?php echo $tblfield; ?>"><?php echo $tblfield; ?></option>
                    <?php } } } ?>
                    </select></strong>
				    
                    <input type="hidden" name="tblname<?php echo $sno; ?>" value="<?php echo $tblname; ?>" />
                    <input type="hidden" name="anum<?php echo $sno; ?>" value="<?php echo $anum; ?>" /></td>
                        <td align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcoa<?php echo $sno; ?>" id="paynowlabcoa<?php echo $sno; ?>" value="<?php echo $coa; ?>" size="25" readonly/>
                        <input type="button" value="Map" onClick="javascript:coasearch('1','<?php echo $sno; ?>')"></td>
                        <td align="left" valign="top"  class="bodytext3"><input type="text" name="displayname<?php echo $sno; ?>" id="displayname<?php echo $sno; ?>" value="<?php echo $displayname; ?>" size="20"></td>
                        <td align="left" valign="top" class="bodytext3">
                         <select name="paynowdate<?php echo $sno; ?>" id="paynowdate<?php echo $sno; ?>">
                         <option value="<?php echo $datefield; ?>"><?php echo $datefield; ?></option>
						<?php
					 $query96 = "SHOW COLUMNS from $tblname";
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
                         <option value="<?php echo $condfield; ?>"><?php echo $condfield; ?></option>
                         <option value="">Select</option>
						<?php
				 $query98 = "SHOW COLUMNS from $tblname";
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
						<option value="<?php echo $selectstatus; ?>"><?php echo $selectstatus; ?></option>
                        <option value="">Select</option>
						<option value="dr">Dr</option>
						<option value="cr">Cr</option>
					</select></td>
                    <td width="48" align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabtype<?php echo $sno; ?>" id="paynowlabtype<?php echo $sno; ?>" value="<?php echo $type; ?>" size="4" readonly/></td>
                    <td align="left" valign="top"  class="bodytext3"><input type="text" name="paynowlabcode<?php echo $sno; ?>" id="paynowlabcode<?php echo $sno; ?>" size="5" value="<?php echo $code; ?>" readonly/></td>
                    <td align="left" valign="top"  class="bodytext3"><input type="text" name="groupcode<?php echo $sno; ?>" id="groupcode<?php echo $sno; ?>" size="4" value="<?php echo $groupcode; ?>" readonly/></td>
				  </tr>
				 <?php
				 }
				  ?> 
                <tr>
                 <td align="middle" valign="top">&nbsp;</td>
                  <td align="middle" valign="top"><div align="left">
                      <input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1" />
                      <input type="submit" name="Submit" value="Save" style="border: 1px solid #001E6A" />
                      
                  </div></td>
                   <td align="middle" valign="top" colspan="10"><div align="right">
                     &nbsp;
                  </div></td>
                </tr>
                <tr bgcolor="#FFFFFF">
							<td align="left" colspan="12" class="bodytext5"><strong>&nbsp;</strong></td>
							</tr>
						 <tr bgcolor="#999999">
							<td align="left" colspan="12" class="bodytext5"><strong>Financial Integration - Deleted</strong></td>
							</tr>	
			          
					   <tr bgcolor="#ecf0f5">
                        <td width="20" align="left" valign="top"  class="bodytext3"><strong>Active</strong></td>
                        <td width="78" align="left" valign="top"  class="bodytext3"><strong>Table</strong></td>
                        <td width="78" align="left" valign="top"  class="bodytext3"><strong>Field</strong></td>
                        <td width="390" align="left" valign="top"  class="bodytext3"><strong>Select COA</strong></td>
                        <td width="164" align="left" valign="top"  class="bodytext3"><strong>Display Name</strong></td>
                        <td width="74" align="left" valign="top"  class="bodytext3"><strong>Date Field</strong></td>
                        <td width="73" align="left" valign="top"  class="bodytext3"><strong>Condition Field</strong></td>
                        <td width="73" align="left" valign="top"  class="bodytext3"><strong>Select</strong></td>
                        <td width="48" align="left" valign="top"  class="bodytext3"><strong>Type</strong></td>
                        <td width="50" align="left" valign="top"  class="bodytext3"><strong>Code</strong></td>
                        <td width="283" align="left" valign="top"  class="bodytext3"><strong>Group Code</strong></td>
				  </tr>
				 <?php
				 $sno='';
				 $query8 = "select * from master_financialintegration where groupcode = '$group' and recordstatus = 'deleted'";
				 $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
				 while($res8 = mysqli_fetch_array($exec8))
				 {
				 	$anum1 = $res8['auto_number'];
				    $tblname = $res8['tblname'];
					$displayname = $res8['displayname'];
					$field = $res8['field'];
					$condfield = $res8['condfield'];
					$datefield = $res8['datefield'];
					$coa = $res8['coa'];
					$selectstatus = $res8['selectstatus'];
					$type = $res8['type'];
					$code = $res8['code'];
					$groupcode = $res8['groupcode'];
					
					$sno = $sno + 1;
					$showcolor = ($sno & 1); 
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
                  <td align="left" valign="top"  class="bodytext5"><a href="editfinancialintegrationtbl.php?st=activate&&group=<?php echo $group; ?>&&actanum=<?php echo $anum1; ?>">Activate</a></td>
				  <td width="78" align="left" valign="top"  class="bodytext5"><?php echo $tblname; ?></td>
                  <td width="78" align="left" valign="top"  class="bodytext5"><?php echo $field; ?></td>
                <td align="left" valign="top"  class="bodytext3"><?php echo $coa; ?></td>
                <td align="left" valign="top"  class="bodytext3"><?php echo $displayname; ?></td>
                <td align="left" valign="top" class="bodytext3"><?php echo $datefield; ?></td> 
                  <td align="left" valign="top" class="bodytext3"><?php echo $condfield; ?></td>     
                        <td width="73" align="left" valign="top"  class="bodytext3"><?php echo $selectstatus; ?></td>
                    <td width="48" align="left" valign="top"  class="bodytext3"><?php echo $type; ?></td>
                    <td align="left" valign="top"  class="bodytext3"><?php echo $code; ?></td>
                    <td align="left" valign="top"  class="bodytext3"><?php echo $groupcode; ?></td>
				  </tr>
                  <?php
				 }
				}
				 ?>
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


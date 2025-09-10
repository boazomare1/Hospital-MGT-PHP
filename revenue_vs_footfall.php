<?php
// Get the start time
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$fromdate = date('Y-m-d');
$todate = date('Y-m-d');
$snocount = "";
$colorloopcount="";
$totalcollection = 0;
$totalrevenue = 0;
$totalpercentage = 0;

if(isset($_REQUEST['locationcode'])){ $locationcode = $_REQUEST['locationcode']; } else { $locationcode = ''; }
if(isset($_REQUEST['ADate1'])){ $ADate1 = $_REQUEST['ADate1']; } else { $ADate1 = ''; }
if(isset($_REQUEST['ADate1'])){ $fromdate = $_REQUEST['ADate1']; } else { $fromdate = date('Y-m-d'); }
if(isset($_REQUEST['ADate2'])){ $ADate2 = $_REQUEST['ADate2']; } else { $ADate2 = ''; }
if(isset($_REQUEST['ADate2'])){ $todate = $_REQUEST['ADate2']; } else { $todate = date('Y-m-d'); }

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
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>   
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
<body>
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
            <form name="cbform1" method="post" action="revenue_vs_footfall.php">
		        <table width="634" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Revenue vs Footfall Report</strong></td>
             </tr>
           	<tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
            
				 <select name="locationcode" id="locationcode">
				 <option value="">All</option>
				<?php
				$query1 = "select * from master_location order by locationname";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res1 = mysqli_fetch_array($exec1))
				{
				$locationname = $res1["locationname"];
				$locationcode1 = $res1["locationcode"];
				?>
				<option value="<?php echo $locationcode1; ?>" <?php if($locationcode!=''){if($locationcode == $locationcode1){echo "selected";}}?>><?php echo $locationname; ?></option>
				<?php         }?>
				</select>
           </tr>
		 
			<tr>
				<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
				<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $fromdate; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />&nbsp;&nbsp;<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
				<td width="" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
				<td width="" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31"><input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $todate; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />&nbsp;&nbsp;<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/></span></td>
			</tr>
			
			<tr>
				<td align="left" valign="top"  bgcolor="#FFFFFF"></td>
				<td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
				<input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
				<input type="submit" value="Search" name="Submit" />
				<input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
			</tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
	   <?php if(isset($_POST['Submit'])){ 
	  
		
			if($locationcode==''){
			$locationcodenew= "and a.locationcode like '%%'";
		}else{
			$locationcodenew= "and a.locationcode = '$locationcode'";
	
		}
		?> 
		
		<tr>
		<td>
			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="50%" align="left" border="0">
			<tbody>
				<tr>
					<td colspan="7" bgcolor="#ecf0f5" class="bodytext31" nowrap="nowrap"><div align="left"><strong>Fill Rate Report </strong></div></td>
				</tr>
				<tr>
					<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>So.No</strong></div></td>
					<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Provider</strong></div></td>
					<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong> Foot Fall </strong></div></td>
					<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Revenue </strong></div></td>
					<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Avg. Value </strong></div></td>
                </tr>
				<?php
				$query1 = "select * from master_subtype where recordstatus <> 'deleted' and auto_number != '1'";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1").mysqli_error($GLOBALS["___mysqli_ston"]);
				while($res1 = mysqli_fetch_array($exec1)){
				$subtypename = $res1['subtype'];
				$subtypeano = $res1['auto_number'];
				$subtype_ledger = $res1['subtype_ledger'];
				
				
				$queryn211 = "select count(a.auto_number) as visitcount from master_visitentry as a JOIN master_subtype as b ON a.subtype = b.auto_number where  a.consultationdate between '$ADate1' and '$ADate2' and a.billtype='PAY LATER' and b.subtype_ledger = '$subtype_ledger' $locationcodenew ";
				$execn211 = mysqli_query($GLOBALS["___mysqli_ston"], $queryn211) or die ("Error in Query211".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res231 = mysqli_fetch_array($execn211);
				$visitcount= $res231['visitcount'];
				
				$totamt=0;
				$queryn2111 = "select sum(a.totalamount) as totamt from billing_paylater as a JOIN master_visitentry as b ON a.visitcode = b.visitcode where  a.billdate between '$ADate1' and '$ADate2' and b.billtype='PAY LATER' and b.subtype = '$subtypeano' $locationcodenew ";
				$execn2111 = mysqli_query($GLOBALS["___mysqli_ston"], $queryn2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res2311 = mysqli_fetch_array($execn2111);
				$totamt= $res2311['totamt'];
				
				
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
				<tr <?=$colorcode;?>>
				<td class="bodytext31" align="left"><?=$snocount;?></td>
				<td  class="bodytext31" align="left"><?=$subtypename;?></td>
				<td  class="bodytext31" align="right"><?=number_format($visitcount,0,'.',',');?></td>
				<td  class="bodytext31" align="right"><?=number_format($totamt,2,'.',',');?></td>
				<td  class="bodytext31" align="right"><?php if($visitcount>0){ echo number_format(($totamt/$visitcount),2,'.',',');} else{ echo 0.00; } ?></td>
				</tr>
				<?php } ?>
			</tbody>
			</table>
		</td>
		</tr>
	   <?php } ?>
	 
	  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

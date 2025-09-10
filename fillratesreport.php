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
if(isset($_REQUEST['searchsuppliername1'])){ $searchsuppliername = $_REQUEST['searchsuppliername1']; } else { $searchsuppliername = ''; }
if(isset($_REQUEST['searchsubtypeanum1'])){ $searchsubtypeanum1 = $_REQUEST['searchsubtypeanum1']; } else { $searchsubtypeanum1 = ''; }
if(isset($_REQUEST['bytype'])){ $bytype = $_REQUEST['bytype']; } else { $bytype = ''; }


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
<script type="text/javascript" src="js/autocomplete_subtype_fillrate.js"></script>
<script type="text/javascript" src="js/autosuggestsubtype_fillrate.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl1(document.getElementById("searchsuppliername1"), new StateSuggestions1());
	
}
function checkprovider(byid){
	var id=byid;
	if(id==0){
		document.getElementById("searchsuppliername1").readOnly = true;	
		document.getElementById("searchsuppliername1").value='';	
		document.getElementById("searchsubtypeanum1").value='';	
		document.getElementById("searchpaymentcode").value=id;	
	}else{
		document.getElementById("searchsuppliername1").readOnly = false;
		document.getElementById("searchpaymentcode").value=id;	
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
            <form name="cbform1" method="post" action="fillratesreport.php">
		        <table width="634" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Fill Rate Report</strong></td>
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
			<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>By</strong></td>
			<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input type="radio" name="bytype" id="bytype1" value='0' onClick="checkprovider(this.value);"><strong>All</strong></td>
			<td width="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input type="radio" name="bytype" id="bytype2" value='1' onClick="checkprovider(this.value);"><strong>Provider</strong></td>
			<td width="" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="searchsuppliername1" type="text" id="searchsuppliername1" value="<?php echo $searchsuppliername; ?>" size="40" autocomplete="off" readonly placeholder="Search Account Here">
			  <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
			  <input name="searchsubtypeanum1" id="searchsubtypeanum1" value="<?php echo $searchsubtypeanum1; ?>" type="hidden">
			  
			  <input type="hidden" name="searchpaymentcode" id="searchpaymentcode" value="<?php echo $bytype; ?>" >
              </span></td>
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
	  
		
		if($bytype=='0') {
			
			if($locationcode==''){
			$locationcodenew= "and locationcode like '%%'";
			$locationcodenew1="and visitcode like '%OPV-%'";
		}else{
			$locationcodenew= "and locationcode = '$locationcode'";
			
			$query12 = "select auto_number from master_location where locationcode='$locationcode' order by locationname";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res12 = mysqli_fetch_array($exec12);
			$loctid = $res12["auto_number"];
			$locationcodenew1= "and visitcode like '%-$loctid'";
		}
		?>
		<tr>
		<td>
			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="40%" align="left" border="0">
			<tbody>
				<tr>
					<td colspan="7" bgcolor="#ecf0f5" class="bodytext31" nowrap="nowrap"><div align="left"><strong>Fill Rate Report </strong></div></td>
				</tr>
				<tr>
					<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Drugs Ordered</strong></div></td>
					<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong> Approved </strong></div></td>
					<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amended </strong></div></td>
					<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Issued  </strong></div></td>
					<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Approved %</strong></div></td>
					<td width=""  align="left" valign="center" 	bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amend%</strong></div></td>
					<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Fill Rate %</strong></div></td>
                </tr>
				
				<?php 
				$totdrugord=0;
				$totapproved=0;
				$totamended=0;
				$totissued=0;
				$queryn21 = "
				select count(auto_number) as drugordered,'0' as approved ,'0' as amended,'0' as issued  from master_consultationpharm where recorddate between '$ADate1' and '$ADate2' $locationcodenew
				UNION ALL
				select '0' as drugordered,count(auto_number) as approved,'0' as amended,'0' as issued   from master_consultationpharm where recorddate between '$ADate1' and '$ADate2' $locationcodenew and amendstatus='2'
				UNION ALL 
				select '0' as drugordered,'0' as approved,count(auto_number) as amended,'0' as issued from amendment_details where amenddate between '$ADate1' and '$ADate2' $locationcodenew1 and amendfrom='Pharmacy' and visitcode like 'OPV-%'
				UNION ALL
				select '0' as drugordered,'0' as approved,'0' as amended,count(auto_number) as issued  from master_consultationpharm where recorddate between '$ADate1' and '$ADate2' $locationcodenew and medicineissue='completed'	
				";
				$execn21 = mysqli_query($GLOBALS["___mysqli_ston"], $queryn21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res23 = mysqli_fetch_array($execn21)){
				$totdrugord += $res23['drugordered'];
				$totapproved += $res23['approved'];
				$totamended += $res23['amended'];
				$totissued += $res23['issued'];
			
				}
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
					<td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($totdrugord,0,'.',','); ?></strong></div></td>
					<td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($totapproved,0,'.',','); ?></strong></div></td>
					<td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($totamended,0,'.',','); ?></strong></div></td>
					<td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($totissued,0,'.',','); ?></strong></div></td>
					<td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php if($totapproved!=0) { echo number_format(($totapproved/$totdrugord)*100,2,'.',','); } else { echo 0.00; } ?>%</strong></div></td>
					<td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php  if($totamended!=0) { echo number_format(($totamended/$totdrugord)*100,2,'.',','); } else { echo 0.00; } ?>%</strong></div></td>
					<td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php  if($totissued!=0) { echo number_format(($totissued/$totdrugord)*100,2,'.',','); } else {echo 0.00; } ?>%</strong></div></td>
				</tr>
			</tbody>
			</table>
		</td>
		</tr>
		<?php } else if($bytype=='1') {
			
			if($locationcode==''){
			$locationcodenew= "and a.locationcode like '%%'";
			$locationcodenew1="and a.visitcode like '%OPV-%'";
		}else{
			$locationcodenew= "and a.locationcode = '$locationcode'";
			
			$query12 = "select auto_number from master_location where locationcode='$locationcode' order by locationname";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res12 = mysqli_fetch_array($exec12);
			$loctid = $res12["auto_number"];
			$locationcodenew1= "and a.visitcode like '%-$loctid'";
		}
			
			?>
		<tr>
		<td>
			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="41%" align="left" border="0">
			<tbody>
				<tr>
					<td colspan="7" bgcolor="#ecf0f5" class="bodytext31" nowrap="nowrap"><div align="left"><strong>Fill Rate Report </strong></div></td>
				</tr>
				<tr>
					<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Drugs Ordered</strong></div></td>
					<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong> Approved </strong></div></td>
					<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amended </strong></div></td>
					<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Issued  </strong></div></td>
					<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Approved %</strong></div></td>
					<td width=""  align="left" valign="center" 	bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amend%</strong></div></td>
					<td width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Fill Rate %</strong></div></td>
                </tr>
				
				<?php 
				
				if($searchsuppliername!=''){
				$query25 = "select auto_number,subtype from master_subtype where  auto_number = '$searchsubtypeanum1'";
				}else{
				$query25 = "select auto_number,subtype from master_subtype ";
				}
				$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res25 = mysqli_fetch_array($exec25)) {
				$searchsubtypeanum1 = $res25['auto_number'];
				$searchsubtype = $res25['subtype'];
				?>
				<tr>
					<td colspan="7"  align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong><?php echo $searchsubtype; ?></strong></div></td>
				</tr>
				
				<?php
				$totdrugord=0;
				$totapproved=0;
				$totamended=0;
				$totissued=0;
				$queryn21 = "
				select count(a.patientvisitcode) as drugordered,'0' as approved ,'0' as amended,'0' as issued  from master_consultationpharm as a join master_visitentry as b on a.patientvisitcode=b.visitcode where a.recorddate between '$ADate1' and '$ADate2' $locationcodenew and b.subtype='$searchsubtypeanum1'
				UNION ALL
				select '0' as drugordered,count(a.patientvisitcode) as approved,'0' as amended,'0' as issued   from master_consultationpharm as a join master_visitentry as b on a.patientvisitcode=b.visitcode where a.recorddate between '$ADate1' and '$ADate2' $locationcodenew and a.amendstatus='2'  and b.subtype='$searchsubtypeanum1'
				UNION ALL 
				select '0' as drugordered,'0' as approved,count(a.visitcode) as amended,'0' as issued from amendment_details as a join master_visitentry as b on a.visitcode=b.visitcode  where a.amenddate between '$ADate1' and '$ADate2' $locationcodenew1 and a.amendfrom='Pharmacy' and a.visitcode like 'OPV-%' and b.subtype='$searchsubtypeanum1'
				UNION ALL
				select '0' as drugordered,'0' as approved,'0' as amended,count(a.patientvisitcode) as issued  from master_consultationpharm as a join master_visitentry as b on a.patientvisitcode=b.visitcode where a.recorddate between '$ADate1' and '$ADate2' $locationcodenew and a.medicineissue='completed'  and b.subtype='$searchsubtypeanum1'	
				";
				$execn21 = mysqli_query($GLOBALS["___mysqli_ston"], $queryn21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res23 = mysqli_fetch_array($execn21)){
				$totdrugord += $res23['drugordered'];
				$totapproved += $res23['approved'];
				$totamended += $res23['amended'];
				$totissued += $res23['issued'];
				}
				if($totdrugord>0){
				$colorloopcount = $colorloopcount + 
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
					<td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($totdrugord,0,'.',','); ?></strong></div></td>
					<td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($totapproved,0,'.',','); ?></strong></div></td>
					<td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($totamended,0,'.',','); ?></strong></div></td>
					<td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($totissued,0,'.',','); ?></strong></div></td>
					<td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php if($totapproved!=0) { echo number_format(($totapproved/$totdrugord)*100,2,'.',','); } else { echo 0.00; } ?>%</strong></div></td>
					<td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php  if($totamended!=0) { echo number_format(($totamended/$totdrugord)*100,2,'.',','); } else { echo 0.00; } ?>%</strong></div></td>
					<td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php  if($totissued!=0) { echo number_format(($totissued/$totdrugord)*100,2,'.',','); } else {echo 0.00; } ?>%</strong></div></td>
				</tr>
		
				<?php } } ?>
			
			</tbody>
		</table>
		</td>
		</tr>
		<?php } } ?>
		
	  
	  </table>
<?php include ("includes/footer1.php"); ?>
<script>
$(document).ready(function(e) {
		var gg=$('#searchpaymentcode').val();	
		if(gg=='0'){	
			$("#bytype1").prop("checked", true);
			$("#bytype2").prop("checked", false);
		}else if(gg=='1') {
			$("#bytype1").prop("checked", false);
			$("#bytype2").prop("checked", true);
			document.getElementById("searchsuppliername1").readOnly = false;
		}
});
</script>
</body>
</html>

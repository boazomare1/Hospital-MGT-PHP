<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 week'));
$paymentreceiveddateto = date('Y-m-d');
$snocount='';
$colorloopcount='';
$res3recorddate = array();
$countitem  = '';
$totalcount = '';
$grandtotal=0;
$execution='';
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
	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$paymentreceiveddateto = $_REQUEST['ADate2'];
}
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
if (isset($_REQUEST["itemcode"])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ""; }
if (isset($_REQUEST["itemname"])) { $itemname = $_REQUEST["itemname"]; } else { $itemname = ""; }
if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
if (isset($_REQUEST["ageinp"])) { $ageinp = $_REQUEST["ageinp"]; } else { $ageinp = ""; }
if (isset($_REQUEST["dmy"])) { $dmy = $_REQUEST["dmy"]; } else { $dmy = ""; }
if (isset($_REQUEST["eptype"])) { $eptype = $_REQUEST["eptype"]; } else { $eptype = ""; }
//$billstatus = $_REQUEST['billstatus'];
if ($ADate1 != '' && $ADate2 != '')
{
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
}
else
{
	$transactiondatefrom = date('Y-m-d', strtotime('-1 week'));
	$transactiondateto = date('Y-m-d');
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
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<link href="js/jquery-ui.css" rel="stylesheet">
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script>
$(function() {
$('#itemname').autocomplete({
source:"ajaxautocomplete_labcode.php",
select:function(event,ui){
$('#itemname').val(ui.item.value);
$('#itemcode').val(ui.item.id);
}
});
});
</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
</head>
<script src="js/datetimepicker_css.js"></script>
<body>
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
             <form name="cbform1" method="post" action="labtestbydatereport.php">
                <table width="700" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Lab Test By Date </strong></td>
                      <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                      <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">&nbsp;</td>
                    </tr>
					 <tr bgcolor="#011E6A">
                      <td  bgcolor="#fff" width="13%" class="bodytext3"><strong>Test Name</strong></td>
                      
                      <td bgcolor="#fff" class="bodytext3" colspan="3">
					  <input type="text" name="itemname" id="itemname" size="50"/>
					  <input type="hidden" name="itemcode" id="itemcode"/>
					  </td>
                    </tr>
					<tr>
					<td width=""  align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"> Range </td>
					<td width="" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
						<select name="range">
							<option value="" selected>Select</option>
							<option value="=" <?php if($range == '='){echo ' selected';} ?>>= </option>
							<option value=">" <?php if($range == '>'){echo ' selected';} ?>>> </option>
							<option value="<" <?php if($range == '<'){echo ' selected';} ?>>< </option>
							<option value=">=" <?php if($range == '>='){echo ' selected';} ?>>>= </option>
							<option value="<=" <?php if($range == '<='){echo ' selected';} ?>><= </option>
						</select>						
					</td>
					
					<td width="" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Age </td>
					<td width="" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31"><input name="ageinp" id="ageinp" size="4"  value="<?php echo $ageinp ?>" onKeyPress="return isNumber(event)"/></span>
					<select id="dmy" name="dmy">
						<option value="years" selected>Years</option>
						<option value="months" <?php if($dmy == 'months'){ echo ' selected'; } ?>>Months</option>
						<option value="days" <?php if($dmy == 'days'){ echo ' selected'; } ?>>Days</option>
					</select>

					
					</td>
				</tr>
                    <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
					<tr>
						<td bgcolor="#FFFFFF" class="bodytext3">Location</td>
						<td width="18%" colspan="1" align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="location" id="location">
						<option value="">All</option>
						<?php
						$query = "select * from master_employeelocation where username='$username'  group by locationcode order by locationname";
						$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res = mysqli_fetch_array($exec))
						{
						$locationname = $res["locationname"];
						$locationcode = $res["locationcode"];
						?>
						<option value="<?php echo $locationcode; ?>" <?php if($location!=''){if($location == $locationcode){echo "selected";}}?>><?php echo $locationname; ?></option>
						<?php
						}
						?>
						</select></td>
						<td width=""  align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"> Type </td>
					<td width="" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
						<select name="eptype">
							<option value="OP+IP" <?php if($eptype == 'OP+IP'){echo ' selected';} ?>>OP+IP</option>
							<option value="OP" <?php if($eptype == 'OP'){echo ' selected';} ?>>OP</option>
							<option value="IP" <?php if($eptype == 'IP'){echo ' selected';} ?>>IP</option>
							<option value="Combain" <?php if($eptype == 'Combain'){echo ' selected';} ?>>Combain </option>
						</select>						
					</td>
					</tr>
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
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
	 <?php 
	 if ($cbfrmflag1 == 'cbfrmflag1')
	{
		if($location==''){

		$locationcodenew= "locationcode like '%%'";
		}else{
		$locationcodenew= "locationcode = '$location'";
		}
	
	?>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="600" align="left" border="0">
          <tbody>
			<?php if($eptype=='OP+IP' || $eptype=='OP'){ ?>
			<tr>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><strong>OP Tests</strong></td>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff">&nbsp;</td>
			</tr>
			<tr>
				<td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
			</tr>
			<tr>
				<td width="17%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
				<td width="39%" align="left" valign="left"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Test Name </strong></div></td>
				<td width="44%" align="center" valign="center"  bgcolor="#ffffff" class="style1">Quantity</td>
			</tr>
			<tr bgcolor="#9999FF">
				<td colspan="7"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo  'Between '.$transactiondatefrom.' and '.$transactiondateto;?></strong></td>
			</tr>
			 <?php
			$totalcount1=0;
			$query1 = "select labitemname,labitemcode,labsamplecoll,consultationdate,patientcode,patientvisitcode  from consultation_lab where  labsamplecoll = 'completed' and labitemcode like '%$itemcode%' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and $locationcodenew group by labitemcode";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num1 = mysqli_num_rows($exec1);
			//echo $num1;
			while($res1 = mysqli_fetch_array($exec1))
		    {
        	 $res1itemname = $res1['labitemname'];
        	 $res1itemcode = $res1['labitemcode'];
			 
        	  
			$countitem=0;
			$query2 = "select  labitemname,labitemcode,labsamplecoll,consultationdate,patientcode,patientvisitcode,sampleid from consultation_lab where labsamplecoll = 'completed' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and labitemcode = '$res1itemcode' and labitemrate<>'0.00' and $locationcodenew ";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num2 = mysqli_num_rows($exec2);
			while($res2 = mysqli_fetch_array($exec2))
			{
			$res2labitemname = $res2['labitemname'];
			$res2itemcode = $res2['labitemcode'];
			$res2labsamplecoll = $res2['labsamplecoll'];
			$res2patientcode = $res2['patientcode'];
			$res2patientvisitcode = $res2['patientvisitcode'];
			$res2sampleid = $res2['sampleid'];
			
				$query44 = "select auto_number from resultentry_lab where itemcode = '$res2itemcode' and patientvisitcode = '$res2patientvisitcode' and patientcode = '$res2patientcode' and sampleid='$res2sampleid' ";
				$exec44 =mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num44 = mysqli_num_rows($exec44);
				if($num44 !=0)
				{
					
				$query751 = "select * from master_customer where customercode = '$res2patientcode'";
				$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res751 = mysqli_fetch_array($exec751);
				$dob = $res751['dateofbirth'];

				$today = new DateTime();
				$comdob = new DateTime($dob);
				$diff = $today->diff($comdob);
				$totaldiffyears = $diff->y;
				$totaldiffmonths = $diff->m;
				$totaldiffdays = $diff->d;

				if ($diff->y)
				{
				$age= $diff->y . ' Years';
				$monthsdayscondition = '';
				}
				elseif ($diff->m)
				{
				$age =$diff->m . ' Months';
				$monthsdayscondition = 'monthsordays';
				}
				else
				{
				$age =$diff->d . ' Days';
				$monthsdayscondition = 'monthsordays';
				}
				
				if($ageinp!=""){
				if($dmy == 'years'){
					if($range == '='){
						if($totaldiffyears == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}
							
					}	
					if($range == '>'){
						if($totaldiffyears > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}
					}		
					if($range == '<'){
						if($totaldiffyears < $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffyears >= $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffyears <= $ageinp){
							$execution = true;
						}				
						else{
							$execution = false;
						}						
					}	
				
						if($execution == 'true'){
						
							
						$countitem=$countitem+1 ;
						
					 } }
				
				if($dmy == 'months'){
					
					if($range == '='){
						if($totaldiffmonths == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}	
					if($range == '>'){
						if($totaldiffmonths > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}		
					if($range == '<'){
						if($totaldiffmonths < $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffmonths >= $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffmonths <= $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}						
					
					
					if($execution == true){
						
						$countitem=$countitem+1 ;
						
					 } }
				
				if($dmy == 'days'){
					
					
					if($range == '='){
						if($totaldiffmonths == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}	
					if($range == '>'){
						if($totaldiffmonths > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}		
					if($range == '<'){
						if($totaldiffmonths < $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffmonths >= $ageinp){
							$execution = true;
						}				
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffmonths <= $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}						
					if($execution == true){
				
					$countitem=$countitem+1 ;
					}
					}
				}
				else{
						$countitem=$countitem+1 ;
				}
				}
            }
			if($countitem>0){
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
				<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				<td class="bodytext31" valign="center"  align="left"> <?php echo $res1itemname; ?>           </td>
				<td class="bodytext31" valign="center"  align="center"> <?php echo $countitem; ?>           </td>
			</tr>
				<?php
				$totalcount1 = $totalcount1 + $countitem;
				} 
			}
			
				$grandtotal= $grandtotal+$totalcount1;
				?>
			<tr>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5"><strong>Total Count</strong></td>
				<td class="bodytext31" valign="center"  align="center" bgcolor="#ecf0f5"><strong><?php echo $totalcount1; ?></strong></td>
			</tr>
			<tr>
				<td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left"	>&nbsp;</td>
			</tr>
			<?php 
			}
			if($eptype=='OP+IP' || $eptype=='IP')
			{
			?>
			
			<tr>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><strong>IP Tests</strong></td>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff">&nbsp;</td>
			</tr>
			<tr>
				<td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
			</tr>
			<tr>
				<td width="17%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
				<td width="39%" align="left" valign="left"  	bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Test Name </strong></div></td>
				<td width="44%" align="center" valign="center"  bgcolor="#ffffff" class="style1">Quantity</td>
			</tr>

			<tr bgcolor="#9999FF">
				<td colspan="7"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo  'Between '.$transactiondatefrom.' and '.$transactiondateto;?></strong></td>
			</tr>
			<?php
			
			$snocount =0;
			
			$totalcount=0;
			$colorloopcount=0;
			$query1 = "select labitemname,labitemcode,labsamplecoll,consultationdate from ipconsultation_lab where  labsamplecoll = 'completed' and labitemcode like '%$itemcode%' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and $locationcodenew group by labitemcode ";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num1 = mysqli_num_rows($exec1);
			while($res1 = mysqli_fetch_array($exec1))
			{
			$res1itemname = $res1['labitemname'];
			$res1labitemcode = $res1['labitemcode'];
			
			$countitem=0;
			$query2 = "select labitemname,labitemcode,labsamplecoll,patientcode,patientvisitcode,sampleid from ipconsultation_lab where labsamplecoll = 'completed' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and labitemcode = '$res1labitemcode' and $locationcodenew";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num2 = mysqli_num_rows($exec2);
			while($res2 = mysqli_fetch_array($exec2))
			{
			$res2labitemname = $res2['labitemname'];
			$res2itemcode = $res2['labitemcode'];
			$res2labsamplecoll = $res2['labsamplecoll'];
			$res2patientcode = $res2['patientcode'];
			$res2patientvisitcode = $res2['patientvisitcode'];
			$res2sampleid = $res2['sampleid'];
				
				
				$query44 = "select auto_number from ipresultentry_lab where itemcode = '$res2itemcode' and patientvisitcode = '$res2patientvisitcode' and patientcode = '$res2patientcode' and sampleid='$res2sampleid' ";
				$exec44 =mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num44 = mysqli_num_rows($exec44);
				if($num44 !=0)
				{
					
				$query751 = "select * from master_customer where customercode = '$res2patientcode'";
				$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res751 = mysqli_fetch_array($exec751);
				$dob = $res751['dateofbirth'];

				$today = new DateTime();
				$comdob = new DateTime($dob);
				$diff = $today->diff($comdob);
				$totaldiffyears = $diff->y;
				$totaldiffmonths = $diff->m;
				$totaldiffdays = $diff->d;

				if ($diff->y)
				{
				$age= $diff->y . ' Years';
				$monthsdayscondition = '';
				}
				elseif ($diff->m)
				{
				$age =$diff->m . ' Months';
				$monthsdayscondition = 'monthsordays';
				}
				else
				{
				$age =$diff->d . ' Days';
				$monthsdayscondition = 'monthsordays';
				}
				
				if($ageinp!=""){
				if($dmy == 'years'){
					if($range == '='){
						if($totaldiffyears == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}
							
					}	
					if($range == '>'){
						if($totaldiffyears > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}
					}		
					if($range == '<'){
						if($totaldiffyears < $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffyears >= $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffyears <= $ageinp){
							$execution = true;
						}				
						else{
							$execution = false;
						}						
					}	
				
						if($execution == 'true'){
						
							
						$countitem=$countitem+1 ;
						
					 } }
				
				if($dmy == 'months'){
					
					if($range == '='){
						if($totaldiffmonths == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}	
					if($range == '>'){
						if($totaldiffmonths > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}		
					if($range == '<'){
						if($totaldiffmonths < $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffmonths >= $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffmonths <= $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}						
					
					
					if($execution == true){
						
						$countitem=$countitem+1 ;
						
					 } }
				
				if($dmy == 'days'){
					
					
					if($range == '='){
						if($totaldiffmonths == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}	
					if($range == '>'){
						if($totaldiffmonths > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}		
					if($range == '<'){
						if($totaldiffmonths < $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffmonths >= $ageinp){
							$execution = true;
						}				
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffmonths <= $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}						
					if($execution == true){
				
					$countitem=$countitem+1 ;
					}
					}
				}
				else{
						$countitem=$countitem+1 ;
				}
				}
			}
			if($countitem>0){
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
				<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $res1itemname; ?>           </td>
				<td class="bodytext31" valign="center"  align="center"><?php echo $countitem; ?>           </td>
			</tr>
				<?php
				$totalcount = $totalcount + $countitem;
				} 
			}
				$grandtotal= $grandtotal+$totalcount;
				?>
			<tr>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5"><strong>Total Count</strong></td>
				<td class="bodytext31" valign="center"  align="center" bgcolor="#ecf0f5"><strong><?php echo $totalcount;?></strong></td>
			</tr>
			<?php } 
			if($eptype=='Combain')
			{
			?>
			<tr>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><strong>Combain Tests</strong></td>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff">&nbsp;</td>
			</tr>
			<tr>
				<td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
			</tr>
			<tr>
				<td width="17%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
				<td width="39%" align="left" valign="left"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Test Name </strong></div></td>
				<td width="44%" align="center" valign="center"  bgcolor="#ffffff" class="style1">Quantity</td>
			</tr>
			<tr bgcolor="#9999FF">
				<td colspan="7"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo  'Between '.$transactiondatefrom.' and '.$transactiondateto;?></strong></td>
			</tr>
			<?php
			//op start
			$totalcount1=0;
			$query1 = "select labitemname,labitemcode  from (
			select labitemname,labitemcode  from consultation_lab where  labsamplecoll = 'completed' and labitemcode like '%$itemcode%' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and $locationcodenew 
			UNION ALL 
			select labitemname,labitemcode from ipconsultation_lab where  labsamplecoll = 'completed' and labitemcode like '%$itemcode%' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and $locationcodenew) as e group by labitemcode";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num1 = mysqli_num_rows($exec1);
			//echo $num1;
			while($res1 = mysqli_fetch_array($exec1))
		    {
			$res1itemname = $res1['labitemname'];
			$res1itemcode = $res1['labitemcode'];
			 
        	$itemtot=0; 
			$countitem=0;
			$query2 = "select  labitemname,labitemcode,labsamplecoll,consultationdate,patientcode,patientvisitcode,sampleid from consultation_lab where labsamplecoll = 'completed' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and labitemcode = '$res1itemcode' and labitemrate<>'0.00' and $locationcodenew ";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num2 = mysqli_num_rows($exec2);
			while($res2 = mysqli_fetch_array($exec2))
			{
			$res2labitemname = $res2['labitemname'];
			$res2itemcode = $res2['labitemcode'];
			$res2labsamplecoll = $res2['labsamplecoll'];
			$res2patientcode = $res2['patientcode'];
			$res2patientvisitcode = $res2['patientvisitcode'];
			$res2sampleid = $res2['sampleid'];
			
				$query44 = "select auto_number from resultentry_lab where itemcode = '$res2itemcode' and patientvisitcode = '$res2patientvisitcode' and patientcode = '$res2patientcode' and sampleid='$res2sampleid' ";
				$exec44 =mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num44 = mysqli_num_rows($exec44);
				if($num44 !=0)
				{
					
				$query751 = "select * from master_customer where customercode = '$res2patientcode'";
				$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res751 = mysqli_fetch_array($exec751);
				$dob = $res751['dateofbirth'];

				$today = new DateTime();
				$comdob = new DateTime($dob);
				$diff = $today->diff($comdob);
				$totaldiffyears = $diff->y;
				$totaldiffmonths = $diff->m;
				$totaldiffdays = $diff->d;

				if ($diff->y)
				{
				$age= $diff->y . ' Years';
				$monthsdayscondition = '';
				}
				elseif ($diff->m)
				{
				$age =$diff->m . ' Months';
				$monthsdayscondition = 'monthsordays';
				}
				else
				{
				$age =$diff->d . ' Days';
				$monthsdayscondition = 'monthsordays';
				}
				
				if($ageinp!=""){
				if($dmy == 'years'){
					if($range == '='){
						if($totaldiffyears == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}
							
					}	
					if($range == '>'){
						if($totaldiffyears > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}
					}		
					if($range == '<'){
						if($totaldiffyears < $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffyears >= $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffyears <= $ageinp){
							$execution = true;
						}				
						else{
							$execution = false;
						}						
					}	
				
						if($execution == 'true'){
						
							
						$countitem=$countitem+1 ;
						
					 } }
				
				if($dmy == 'months'){
					
					if($range == '='){
						if($totaldiffmonths == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}	
					if($range == '>'){
						if($totaldiffmonths > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}		
					if($range == '<'){
						if($totaldiffmonths < $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffmonths >= $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffmonths <= $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}						
					
					
					if($execution == true){
						
						$countitem=$countitem+1 ;
						
					 } }
				
				if($dmy == 'days'){
					
					
					if($range == '='){
						if($totaldiffmonths == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}	
					if($range == '>'){
						if($totaldiffmonths > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}		
					if($range == '<'){
						if($totaldiffmonths < $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffmonths >= $ageinp){
							$execution = true;
						}				
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffmonths <= $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}						
					if($execution == true){
				
					$countitem=$countitem+1 ;
					}
					}
				}
				else{
						$countitem=$countitem+1 ;
				}
				}
            }
				if($countitem>0){
						$totalcount1 = $totalcount1 + $countitem;
						$itemtot = $itemtot + $countitem;
				} 
			
			$countitem1=0;
			$query2 = "select labitemname,labitemcode,labsamplecoll,patientcode,patientvisitcode,sampleid from ipconsultation_lab where labsamplecoll = 'completed' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and labitemcode = '$res1itemcode' and $locationcodenew";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num2 = mysqli_num_rows($exec2);
			while($res2 = mysqli_fetch_array($exec2))
			{
			$res2labitemname = $res2['labitemname'];
			$res2itemcode = $res2['labitemcode'];
			$res2labsamplecoll = $res2['labsamplecoll'];
			$res2patientcode = $res2['patientcode'];
			$res2patientvisitcode = $res2['patientvisitcode'];
			$res2sampleid = $res2['sampleid'];
				
				
				$query44 = "select auto_number from ipresultentry_lab where itemcode = '$res2itemcode' and patientvisitcode = '$res2patientvisitcode' and patientcode = '$res2patientcode' and sampleid='$res2sampleid' ";
				$exec44 =mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num44 = mysqli_num_rows($exec44);
				if($num44 !=0)
				{
					
				$query751 = "select * from master_customer where customercode = '$res2patientcode'";
				$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res751 = mysqli_fetch_array($exec751);
				$dob = $res751['dateofbirth'];

				$today = new DateTime();
				$comdob = new DateTime($dob);
				$diff = $today->diff($comdob);
				$totaldiffyears = $diff->y;
				$totaldiffmonths = $diff->m;
				$totaldiffdays = $diff->d;

				if ($diff->y)
				{
				$age= $diff->y . ' Years';
				$monthsdayscondition = '';
				}
				elseif ($diff->m)
				{
				$age =$diff->m . ' Months';
				$monthsdayscondition = 'monthsordays';
				}
				else
				{
				$age =$diff->d . ' Days';
				$monthsdayscondition = 'monthsordays';
				}
				
				if($ageinp!=""){
				if($dmy == 'years'){
					if($range == '='){
						if($totaldiffyears == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}
							
					}	
					if($range == '>'){
						if($totaldiffyears > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}
					}		
					if($range == '<'){
						if($totaldiffyears < $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffyears >= $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffyears <= $ageinp){
							$execution = true;
						}				
						else{
							$execution = false;
						}						
					}	
				
						if($execution == 'true'){
						
							
						$countitem1=$countitem1+1 ;
						
					 } }
				
				if($dmy == 'months'){
					
					if($range == '='){
						if($totaldiffmonths == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}	
					if($range == '>'){
						if($totaldiffmonths > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}		
					if($range == '<'){
						if($totaldiffmonths < $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffmonths >= $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffmonths <= $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}						
					
					
					if($execution == true){
						
						$countitem1=$countitem1+1 ;
						
					 } }
				
				if($dmy == 'days'){
					
					
					if($range == '='){
						if($totaldiffmonths == $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}	
					if($range == '>'){
						if($totaldiffmonths > $ageinp){
							$execution = true;
						}
						else{
							$execution = false;
						}						
					}		
					if($range == '<'){
						if($totaldiffmonths < $ageinp){
							$execution = true;
						}			
						else{
							$execution = false;
						}						
					}	
					if($range == '>='){
						if($totaldiffmonths >= $ageinp){
							$execution = true;
						}				
						else{
							$execution = false;
						}						
					}	
					if($range == '<='){
						if($totaldiffmonths <= $ageinp){
							$execution = true;
						}		
						else{
							$execution = false;
						}						
					}						
					if($execution == true){
				
					$countitem1=$countitem1+1 ;
					}
					}
				}
				else{
						$countitem1=$countitem1+1 ;
				}
				}
			}
				if($countitem1>0){
				  $totalcount1 = $totalcount1 + $countitem1;
				  $itemtot = $itemtot + $countitem1;
				} 
			if($itemtot>0){	
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
				<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $res1itemname; ?>           </td>
				<td class="bodytext31" valign="center"  align="center"><?php echo $countitem+$countitem1; ?>           </td>
			</tr>	
			<?php	
			}
			}
			//ip end 
			
			$grandtotal= $grandtotal+$totalcount1;
			?>
			<?php
			}
			?>
			<tr>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5"><strong>Grand Total Count</strong></td>
				<td class="bodytext31" valign="center"  align="center" bgcolor="#ecf0f5"><strong><?php echo  $grandtotal;?></strong></td>
				<td colspan="2" class="bodytext31" valign="center"  align="left" 
				bgcolor="#ecf0f5">&nbsp;</td>
				<td width="7%"  align="left" valign="center" bgcolor="" class="bodytext31">
				<?php
				if($eptype=='OP+IP')
				{
					$eptype='OPIP';
				}
				if($cbfrmflag1=='cbfrmflag1')
				{
				?>
				<a href="xl_labstasticst.php?itemname=<?= $itemname ?>&&itemcode=<?= $itemcode ?>&&cbfrmflag1=cbfrmflag1&&ADate1=<?= $transactiondatefrom ?>&&ADate2=<?= $transactiondateto ?>&&location=<?= $location ?>&&range=<?= $range ?>&&ageinp=<?= $ageinp ?>&&dmy=<?= $dmy ?>&&eptype=<?= $eptype ?>" target="_blank"> <img src="images/excel-xls-icon.png" width="30" height="30" /> </a>
				<?php
				}
				?>			  </td> 
			</tr>
          </tbody>
        </table></td>
      </tr>
	  <?php
	  }
	  ?>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
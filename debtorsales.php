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
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$snocount = "";
$colorloopcount="";
$totalcollection = 0;
$totalrevenue = 0;
$totalpercentage = 0;


if(isset($_REQUEST['locationcode'])){ $locationcode = $_REQUEST['locationcode']; } else { $locationcode = ''; }
if(isset($_REQUEST['year'])){ $from_year = $_REQUEST['year']; } else { $from_year = date('Y'); }
if(isset($_REQUEST['month'])){ $from_month = $_REQUEST['month']; } else { $from_month = date('m'); }


?>
<style type="text/css">
th {
            background-color: #ffffff;
            position: sticky;
            top: 0;
            z-index: 1;
        }
	   .bodytext31:hover { font-size:14px; }

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
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>
<!--<script type="text/javascript" src="js/autocomplete_customer2.js"></script>
<script type="text/javascript" src="js/autosuggestcustomer.js"></script>-->
<script type="text/javascript">
window.onload = function () 
{

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
            <form name="cbform1" method="post" action="debtorsales.php">
		        <table width="634" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Debtor Sales Branch Wise</strong></td>
             </tr>
           	<tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
            
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
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">Select Year </td>
                  <?php $years = range(2018, strftime("2025", time())); ?>
                      <td width="" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
                        <select name="year" id="year">
                          <?php if($from_year != ''){ ?>
                              <option value="<?php echo $from_year; ?>"><?php echo $from_year; ?></option>
                          <?php } ?>
                          <option>Select Year</option>
                          <?php foreach($years as $year1) : ?>
                              <option value="<?php echo $year1; ?>"><?php echo $year1; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </td>

                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">Select Month </td>
                      <td width="" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
                        <select name="month" id="month">
                          <option <?php if($from_month == '1') { ?> selected = 'selected' <?php } ?> value="1">January</option>
                          <option <?php if($from_month == '2') { ?> selected = 'selected' <?php } ?> value="2">February</option>
                          <option <?php if($from_month == '3') { ?> selected = 'selected' <?php } ?> value="3">March</option>
                          <option <?php if($from_month == '4') { ?> selected = 'selected' <?php } ?> value="4">April</option>
                          <option <?php if($from_month == '5') { ?> selected = 'selected' <?php } ?> value="5">May</option>
                          <option <?php if($from_month == '6') { ?> selected = 'selected' <?php } ?> value="6">June</option>
                          <option <?php if($from_month == '7') { ?> selected = 'selected' <?php } ?> value="7">July</option>
                          <option <?php if($from_month == '8') { ?> selected = 'selected' <?php } ?> value="8">August</option>
                          <option <?php if($from_month == '9') { ?> selected = 'selected' <?php } ?> value="9">September</option>
                          <option <?php if($from_month == '10'){ ?> selected = 'selected' <?php } ?> value="10">October</option>
                          <option <?php if($from_month == '11'){ ?> selected = 'selected' <?php } ?> value="11">November</option>
                          <option <?php if($from_month == '12'){ ?> selected = 'selected' <?php } ?> value="12">December</option>
                        </select>
                      </td>
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
		$valuesArray=array();
		
		$query12 = "select locationname from master_location where locationcode='$locationcode' and auto_number not in ('11','12') order by auto_number asc";
		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res12 = mysqli_fetch_array($exec12);
		$res1location = $res12["locationname"];
		if($res1location==''){
			$res1location='ALL';
		}
	  
		if($locationcode==''){
				$locationcodenew= "and a.locationcode like '%%'";
			
				$query121 = "select locationname from master_location where locationcode like '%%'  and auto_number not in ('11','12') order by auto_number asc";
				$exec121 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die ("Error in Query121".mysqli_error($GLOBALS["___mysqli_ston"]));
				$exec1211 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die ("Error in Query121".mysqli_error($GLOBALS["___mysqli_ston"]));
			
		}else{
				$locationcodenew= "and a.locationcode = '$locationcode'";
			
				$query121 = "select locationname from master_location where locationcode='$locationcode'  and auto_number not in ('11','12')  order by auto_number asc";
				$exec121 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die ("Error in Query121".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		
		
			$year_start = date('Y-m-d', strtotime('first day of january'.date($from_year)));
			$year_end = date('Y-m-d', strtotime('last day of '.date($from_year.'-'.$from_month)));
	  ?>
	   <tr>
        <td>
			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="2" cellpadding="4" width="" align="left" border="0">
			<tbody>
				<tr>
				<th bgcolor="#ecf0f5" class="bodytext31" align="center"><strong>S.No.</strong></th>
				<th bgcolor="#ecf0f5" class="bodytext31" align="center"><strong>ACCOUNT</strong></th>
				<?php 
				  while($res121 = mysqli_fetch_array($exec121)){
				?>
				<th bgcolor="#ecf0f5" class="bodytext31" align="right"><strong><?php echo $res121["locationname"]; ?></strong></th>
				<?php } ?>
				<th bgcolor="#ecf0f5" class="bodytext31" align="right"><strong>Total</strong></th>
				</tr>
				
				<?php
				$query1 = "select * from master_subtype where recordstatus <> 'deleted' and auto_number != '1'";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1").mysqli_error($GLOBALS["___mysqli_ston"]);
				while($res1 = mysqli_fetch_array($exec1)){
				$totcollection=0;
				$subtypename = $res1['subtype'];
				$subtypeano = $res1['auto_number'];
				$subtype_ledger = $res1['subtype_ledger'];
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
				<td class="bodytext31" align="center"><?=$snocount;?></td>
				<td  class="bodytext31" align="left"><?=$subtypename;?></td>
				<?php
				if($locationcode==''){
						$query121 = "select locationcode from master_location where locationcode like '%%'  and auto_number not in ('11','12') order by auto_number asc";
						$exec1211 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die ("Error in Query121".mysqli_error($GLOBALS["___mysqli_ston"]));
				}else{
						$query121 = "select locationcode from master_location where locationcode='$locationcode'  and auto_number not in ('11','12') order by auto_number asc";
						$exec1211 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die ("Error in Query121".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				while($res1211 = mysqli_fetch_array($exec1211)){
				$ltcamt=0;
				$selectlct=$res1211["locationcode"];	
				$queryn21 = "select sum(a.transactionamount) as ltcamt from master_transactionpaylater as a JOIN master_subtype as b ON a.accountcode = b.subtype_ledger where  a.transactiondate between '$year_start' and '$year_end' and a.billnumber<>'' and a.transactionmodule != 'PAYMENT'  and b.subtype_ledger = '$subtype_ledger' and a.locationcode='$selectlct' group by b.auto_number
				";
				$execn21 = mysqli_query($GLOBALS["___mysqli_ston"], $queryn21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res23 = mysqli_fetch_array($execn21)){
				$ltcamt+= $res23['ltcamt'];
				$totcollection+= $res23['ltcamt'];
				}
				?>
				<td class="bodytext31" align="right"><?=number_format($ltcamt,2,'.',',');?></td>
				<?php
				}
				?>
				<td class="bodytext31" align="right"><?=number_format($totcollection,2,'.',',');?></td>
				</tr>
				
				<?php } ?>
			</tbody>
			</table>
		</td>
		</tr>
	  <?php } ?>
	  </table>
    <!-- Modern JavaScript -->
    <script src="js/debtorsales-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>
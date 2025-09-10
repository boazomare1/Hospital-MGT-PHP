<?php
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
            <form name="cbform1" method="post" action="sales_collectionreport_test.php">
		        <table width="634" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Sales Vs Collection Report</strong></td>
             </tr>
           	<tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
              <select name="locationcode">
                <?php
                  $query20 = "select * FROM master_location";
                  $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20". mysqli_error($GLOBALS["___mysqli_ston"]));
                  while ($res20 = mysqli_fetch_array($exec20)){
                    echo "<option value=".$res20['locationcode'].">" .$res20['locationname']. "</option>";
                  }
                ?>
                </select></td>
           </tr>
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">Select Year </td>
                  <?php $years = range(2018, strftime("2025", time())); ?>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
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
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
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
      <?php if(isset($_POST['Submit'])){ ?>
      <tr>
          <td class="bodytext31" valign="center" align="left" colspan="2"> 
           <a href="xl_salescollectionreport.php?locationcode=<?php echo $locationcode; ?>&year=<?php echo $from_year; ?>&month=<?php echo $from_month; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a>
          </td>
        </tr>
       <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1000" 
            align="left" border="1">
          <tbody>
      <tr>
        <td bgcolor="#ecf0f5" colspan="42" class="bodytext31" align="center"><strong>SALES VS COLLECTION REPORT</strong></td>
      </tr>
      <?php
        $year_start = date('Y-m-d', strtotime('first day of january'.date($from_year)));
        $year_end = date('Y-m-d', strtotime('last day of '.date($from_year.'-'.$from_month)));
      ?>
      <tr>
        <td bgcolor="#ecf0f5" colspan="42" class="bodytext31" align="center"><strong>REPORT FROM <?php echo $year_start.' TO '.$year_end; ?></strong></td>
      </tr>
      <tr>
        <td bgcolor="#ecf0f5" class="bodytext31" align="center" colspan="2"><strong>&nbsp;</strong></td>
      <?php
        $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        for($i = 0; $i < $from_month; $i++){
             $month = $months[$i];
             $s_name = $months[0];
             $e_name = $months[$from_month-1];
      ?>
        <td bgcolor="#ecf0f5" colspan="3" class="bodytext31" align="center"><strong><?php echo $month; ?></strong></td>
      <?php } ?>
      <td bgcolor="#ecf0f5" colspan="3" class="bodytext31" align="center"><strong><?php echo $s_name.' To '.$e_name; ?></strong></td>
      </tr>
      <tr>
        <td bgcolor="#ecf0f5" class="bodytext31" align="center"><strong>Sno.</strong></td>
        <td bgcolor="#ecf0f5" class="bodytext31" align="center"><strong>ACCOUNT</strong></td>
        <?php 
          for($i = 0; $i < $from_month; $i++){
        ?>
        <td bgcolor="#ecf0f5" class="bodytext31" align="right"><strong>REVENUE</strong></td>
        <td bgcolor="#ecf0f5" class="bodytext31" align="right"><strong>COLLECTION</strong></td>
        <td bgcolor="#ecf0f5" class="bodytext31" align="right"><strong>PERCENTAGE</strong></td>
        <?php } ?>
        <td bgcolor="#ecf0f5" class="bodytext31" align="right"><strong>TOTAL REVENUE</strong></td>
        <td bgcolor="#ecf0f5" class="bodytext31" align="right"><strong>TOTAL COLLECTION</strong></td>
        <td bgcolor="#ecf0f5" class="bodytext31" align="right"><strong>TOTAL PERCENTAGE</strong></td>
      </tr>
        <?php
            $query1 = "select * from master_subtype where recordstatus <> 'deleted' and auto_number != '1'";
            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1").mysqli_error($GLOBALS["___mysqli_ston"]);
            while($res1 = mysqli_fetch_array($exec1)){
              $subtypename = $res1['subtype'];
              $subtypeano = $res1['auto_number'];

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
            <td class="bodytext31" valign="center" align="center"><?php echo $snocount; ?></td> 
            <td class="bodytext31" valign="center" align="left"><?php echo $subtypename; ?></td>
            <?php
              $subtypecollection = 0;
              $subtyperevenue = 0;
              $subtypeperc = 0;
              $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            
              for($i = 0; $i < $from_month; $i++){
                $month = $months[$i];
                $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
                $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));

                $query2 = "select accountname, sum(revenue) as revenue from (
                  SELECT sum(billing_ip.totalrevenue) as revenue, master_accountname.id, master_subtype.subtype as accountname FROM `billing_ip` JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ip.billdate between '$start_month' and '$end_month' and master_subtype.auto_number = '$subtypeano' and master_accountname.id != '02-4500-1' group by master_subtype.auto_number
                  UNION ALL 
                  SELECT sum(billing_ipcreditapproved.totalrevenue) as revenue, master_accountname.id, master_subtype.subtype as accountname FROM `billing_ipcreditapproved` JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipcreditapproved.billdate between '$start_month' and '$end_month' and master_subtype.auto_number = '$subtypeano' and master_accountname.id != '02-4500-1' group by master_subtype.auto_number
                  UNION ALL
                  SELECT sum(billing_paylater.totalamount) as revenue, master_accountname.id, master_subtype.subtype as accountname FROM `billing_paylater` JOIN master_accountname ON billing_paylater.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_paylater.billdate between '$start_month' and '$end_month' and master_subtype.auto_number = '$subtypeano' and master_accountname.id != '02-4500-1' group by master_subtype.auto_number
				  
				  UNION ALL
				   SELECT sum(billing_paynowpharmacy.fxamount) as revenue, master_accountname.id, master_subtype.subtype as accountname FROM `billing_paynowpharmacy` JOIN master_accountname ON billing_paynowpharmacy.accountname = master_accountname.accountname JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_paynowpharmacy.billdate between '$start_month' and '$end_month' and master_subtype.auto_number = '$subtypeano' and master_accountname.auto_number != '47' group by master_subtype.auto_number
				  
				  UNION ALL
				   SELECT sum(billing_consultation.consultation) as revenue, master_accountname.id, master_subtype.subtype as accountname FROM `billing_consultation` JOIN master_accountname ON billing_consultation.accountname = master_accountname.accountname JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_consultation.billdate between '$start_month' and '$end_month' and master_subtype.auto_number = '$subtypeano' and master_accountname.auto_number != '47' group by master_subtype.auto_number
				  
                  ) as rev group by accountname order by accountname";
                $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res2 = mysqli_fetch_array($exec2);
                $revenue = $res2['revenue'];
                $subtyperevenue += $revenue;

                $query3 = "select sum(a.transactionamount) as collection from master_transactionpaylater as a JOIN master_subtype as b ON a.subtype = b.subtype where a.docno LIKE 'AR-%' and a.transactiondate between '$start_month' and '$end_month' and a.transactionmodule = 'PAYMENT' and b.auto_number = '$subtypeano' group by b.auto_number ";
                $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res3 = mysqli_fetch_array($exec3);
                $collection = $res3['collection'];
                $subtypecollection += $collection;

                if($collection != '' && $revenue != ''){
                  $revpercentage = ($collection/$revenue)*100;
                } else { $revpercentage = 0; }

            ?>
            <td class="bodytext31" valign="center" align="right"><?php echo number_format($revenue,2); ?></td>
            <td class="bodytext31" valign="center" align="right"><?php echo number_format($collection,2); ?></td>
            <td class="bodytext31" valign="center" align="right"><?php echo number_format($revpercentage,2).'%'; ?></td>
            <?php } ?>
            <?php if($subtypecollection != '' && $subtyperevenue != ''){ $subtypeperc = ($subtypecollection/$subtyperevenue)*100; } else { $subtypeperc = 0; } ?>
            <td class="bodytext31" valign="center" align="right"><?php echo number_format($subtyperevenue,2); ?></td>
            <td class="bodytext31" valign="center" align="right"><?php echo number_format($subtypecollection,2); ?></td>
            <td class="bodytext31" valign="center" align="right"><?php echo number_format($subtypeperc,2).'%'; ?></td>
          <?php } ?>
          </tr>
          <tr bgcolor="#ecf0f5">
            <td class="bodytext31" valign="center" align="right" colspan="2"><strong>TOTAL: </strong></td>
          <?php 
              $yearlyrevenue = $yearlycollection = $yearlypercentage = 0;
              $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            
              for($i = 0; $i < $from_month; $i++){
                $month = $months[$i];
                $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
                $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));

                $query2 = "select accountname, sum(revenue) as revenue from (
                  SELECT sum(billing_ip.totalrevenue) as revenue, master_accountname.id, master_subtype.subtype as accountname FROM `billing_ip` JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ip.billdate between '$start_month' and '$end_month' and master_accountname.id != '02-4500-1' 
                  UNION ALL 
                  SELECT sum(billing_ipcreditapproved.totalrevenue) as revenue, master_accountname.id, master_subtype.subtype as accountname FROM `billing_ipcreditapproved` JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipcreditapproved.billdate between '$start_month' and '$end_month' and master_accountname.id != '02-4500-1'
                  UNION ALL
                  SELECT sum(billing_paylater.totalamount) as revenue, master_accountname.id, master_subtype.subtype as accountname FROM `billing_paylater` JOIN master_accountname ON billing_paylater.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_paylater.billdate between '$start_month' and '$end_month' and master_accountname.id != '02-4500-1'
				  
				   UNION ALL
				   SELECT sum(billing_paynowpharmacy.fxamount) as revenue, master_accountname.id, master_subtype.subtype as accountname FROM `billing_paynowpharmacy` JOIN master_accountname ON billing_paynowpharmacy.accountname = master_accountname.accountname JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_paynowpharmacy.billdate between '$start_month' and '$end_month' and master_accountname.auto_number != '47'
				  
				  UNION ALL
				   SELECT sum(billing_consultation.consultation) as revenue, master_accountname.id, master_subtype.subtype as accountname FROM `billing_consultation` JOIN master_accountname ON billing_consultation.accountname = master_accountname.accountname JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_consultation.billdate between '$start_month' and '$end_month' and master_accountname.auto_number != '47' 
				  
                  ) as rec1";
                $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query2").mysqli_error($GLOBALS["___mysqli_ston"]);
                $res2 = mysqli_fetch_array($exec2);
                $totalrevenue = $res2['revenue'];
                $yearlyrevenue += $totalrevenue;

                $query3 = "select sum(a.transactionamount) as collection from master_transactionpaylater as a JOIN master_subtype as b ON a.subtype = b.subtype where a.docno LIKE 'AR-%' and a.transactiondate between '$start_month' and '$end_month' and a.transactionmodule = 'PAYMENT' ";
                $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res3 = mysqli_fetch_array($exec3);
                $totalcollection = $res3['collection'];
                $yearlycollection += $totalcollection;

                if($totalcollection != '' && $totalrevenue != ''){ $totalpercentage = ($totalcollection/$totalrevenue)*100; } else { $totalpercentage = 0; }
          ?>
            <td class="bodytext31" valign="center" align="right"><strong><?php echo number_format($totalrevenue,2); ?></strong></td>
            <td class="bodytext31" valign="center" align="right"><strong><?php echo number_format($totalcollection,2); ?></strong></td>
            <td class="bodytext31" valign="center" align="right"><strong><?php echo number_format($totalpercentage,2).'%'; ?></strong></td>
          <?php } ?>
          <?php if($yearlycollection != '' && $yearlyrevenue != ''){ $yearlypercentage = ($yearlycollection/$yearlyrevenue)*100; } else {$yearlypercentage=0;} ?>
          <td class="bodytext31" valign="center" align="right"><strong><?php echo number_format($yearlyrevenue,2); ?></strong></td>
          <td class="bodytext31" valign="center" align="right"><strong><?php echo number_format($yearlycollection,2); ?></strong></td>
          <td class="bodytext31" valign="center" align="right"><strong><?php echo number_format($yearlypercentage,2).'%'; ?></strong></td>
          </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
    <?php } ?>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

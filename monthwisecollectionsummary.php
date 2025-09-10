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
            <form name="cbform1" method="post" action="monthwisecollectionsummary.php">
		        <table width="634" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Monthwise Collection Summary</strong></td>
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
           <a href="xl_monthwisecollectionsummary.php?locationcode=<?php echo $locationcode; ?>&year=<?php echo $from_year; ?>&month=<?php echo $from_month; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a>
          </td>
        </tr>
       <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1000" 
            align="left" border="1">
          <tbody>
      <tr>
        <td bgcolor="#ecf0f5" colspan="<?php echo ($from_month)+3; ?>" class="bodytext31" align="center"><strong><SUMMARY>MONTHWISE COLLECTION SUMMARY</SUMMARY></strong></td>
      </tr>
      <?php
        $year_start = date('Y-m-d', strtotime('first day of january'.date($from_year)));
        $year_end = date('Y-m-d', strtotime('last day of '.date($from_year.'-'.$from_month)));
      ?>
      <tr>
        <td bgcolor="#ecf0f5" colspan="<?php echo ($from_month)+3; ?>" class="bodytext31" align="center"><strong>REPORT FROM <?php echo $year_start.' TO '.$year_end; ?></strong></td>
      </tr>
      <tr>
        <td bgcolor="#ecf0f5" class="bodytext31" align="center"><strong>Sno.</strong></td>
        <td bgcolor="#ecf0f5" class="bodytext31" align="center"><strong>Type</strong></td>
      <?php
        $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        for($i = 0; $i < $from_month; $i++){
             $month = $months[$i];
             $s_name = $months[0];
             $e_name = $months[$from_month-1];
      ?>
        <td bgcolor="#ecf0f5" class="bodytext31" align="center"><strong><?php echo $month; ?></strong></td>
      <?php } ?>
      <td bgcolor="#ecf0f5" class="bodytext31" align="center"><strong><?php echo $s_name.' To '.$e_name; ?></strong></td>
      </tr>
        <?php
          $collections = ['CASH', 'CARD', 'CHEQUE', 'ONLINE', 'MPESA'];
          foreach ($collections as $key => $type) {
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
            <td class="bodytext31" valign="center" align="left"><?php echo $type; ?></td>
            <?php
              $totalcash = $totalcard = $totalcheque = $totalonline = $totalmpesa = 0;
              $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            
              for($i = 0; $i < $from_month; $i++){
                $month = $months[$i];
                $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
                $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));

                $query2 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionpaynow where locationcode='$locationcode' and transactiondate between '$start_month' and '$end_month'"; 
                $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res2 = mysqli_fetch_array($exec2);
                
                  $res2cashamount1 = $res2['cashamount1'];
                $res2onlineamount1 = $res2['onlineamount1'];
                $res2creditamount1 = $res2['creditamount1'];
                $res2chequeamount1 = $res2['chequeamount1'];
                $res2cardamount1 = $res2['cardamount1'];

                 
                  $query3 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionexternal where locationcode='$locationcode' and transactiondate between '$start_month' and '$end_month'"; 
                $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res3 = mysqli_fetch_array($exec3);
                
                  $res3cashamount1 = $res3['cashamount1'];
                $res3onlineamount1 = $res3['onlineamount1'];
                $res3creditamount1 = $res3['creditamount1'];
                $res3chequeamount1 = $res3['chequeamount1'];
                $res3cardamount1 = $res3['cardamount1'];
                
                
                $query4 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_billing where locationcode='$locationcode' and billingdatetime between '$start_month' and '$end_month'"; 
                $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res4 = mysqli_fetch_array($exec4);
                
                  $res4cashamount1 = $res4['cashamount1'];
                $res4onlineamount1 = $res4['onlineamount1'];
                $res4creditamount1 = $res4['creditamount1'];
                $res4chequeamount1 = $res4['chequeamount1'];
                $res4cardamount1 = $res4['cardamount1'];
                
                $query5 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from refund_paynow where locationcode='$locationcode' and transactiondate between '$start_month' and '$end_month'"; 
                $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res5 = mysqli_fetch_array($exec5);
                
                  $res5cashamount1 = $res5['cashamount1'];
                $res5onlineamount1 = $res5['onlineamount1'];
                $res5creditamount1 = $res5['creditamount1'];
                $res5chequeamount1 = $res5['chequeamount1'];
                $res5cardamount1 = $res5['cardamount1'];
                
                $query54 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1  from deposit_refund where locationcode='$locationcode' and  recorddate between '$start_month' and '$end_month'"; 
                $exec54 = mysqli_query($GLOBALS["___mysqli_ston"], $query54) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($res54 = mysqli_fetch_array($exec54))
                {
              
                $res54cashamount1 = $res54['cashamount1'];
                $res54onlineamount1 = $res54['onlineamount1'];
                $res54creditamount1 = $res54['creditamount1'];
                $res54chequeamount1 = $res54['chequeamount1'];
                $res54cardamount1 = $res54['cardamount1'];
                 
                 }  //refund adv
                
                $query6 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionadvancedeposit where locationcode='$locationcode' and transactiondate between '$start_month' and '$end_month'"; 
                $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res6 = mysqli_fetch_array($exec6);
                
                  $res6cashamount1 = $res6['cashamount1'];
                $res6onlineamount1 = $res6['onlineamount1'];
                $res6creditamount1 = $res6['creditamount1'];
                $res6chequeamount1 = $res6['chequeamount1'];
                $res6cardamount1 = $res6['cardamount1'];

                $query7 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionipdeposit where locationcode='$locationcode' and transactiondate between '$start_month' and '$end_month'"; 
                $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res7 = mysqli_fetch_array($exec7);
                
                  $res7cashamount1 = $res7['cashamount1'];
                $res7onlineamount1 = $res7['onlineamount1'];
                $res7creditamount1 = $res7['creditamount1'];
                $res7chequeamount1 = $res7['chequeamount1'];
                $res7cardamount1 = $res7['cardamount1'];
                
                $query8 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(mpesaamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionip where locationcode='$locationcode' and transactiondate between '$start_month' and '$end_month'"; 
                $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res8 = mysqli_fetch_array($exec8);
                
                  $res8cashamount1 = $res8['cashamount1'];
                $res8onlineamount1 = $res8['onlineamount1'];
                $res8creditamount1 = $res8['creditamount1'];
                $res8chequeamount1 = $res8['chequeamount1'];
                $res8cardamount1 = $res8['cardamount1'];
                
                  $query9 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionipcreditapproved where locationcode='$locationcode' and transactiondate between '$start_month' and '$end_month'"; 
                $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res9 = mysqli_fetch_array($exec9);
                
                  $res9cashamount1 = $res9['cashamount1'];
                $res9onlineamount1 = $res9['onlineamount1'];
                $res9creditamount1 = $res9['creditamount1'];
                $res9chequeamount1 = $res9['chequeamount1'];
                $res9cardamount1 = $res9['cardamount1'];

                $query10 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from receiptsub_details where locationcode='$locationcode' and transactiondate between '$start_month' and '$end_month'"; 
                $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res10 = mysqli_fetch_array($exec10);
                
                  $res10cashamount1 = $res10['cashamount1'];
                $res10onlineamount1 = $res10['onlineamount1'];
                $res10creditamount1 = $res10['creditamount1'];
                $res10chequeamount1 = $res10['chequeamount1'];
                $res10cardamount1 = $res10['cardamount1'];
              
              $query11 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount+mpesaamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionpaylater where locationcode='$locationcode' and docno like 'AR-%' and transactionstatus like 'onaccount' and transactiondate between '$start_month' and '$end_month'"; 
                $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res11 = mysqli_fetch_array($exec11);
                
                  $res11cashamount1 = $res11['cashamount1'];
                $res11onlineamount1 = $res11['onlineamount1'];
                $res11creditamount1 = $res11['creditamount1'];
                $res11chequeamount1 = $res11['chequeamount1'];
                $res11cardamount1 = $res11['cardamount1'];

                
                $cashamount = $res2cashamount1 + $res3cashamount1 + $res4cashamount1 + $res6cashamount1 + $res7cashamount1 + $res8cashamount1 + $res9cashamount1 + $res10cashamount1+ $res11cashamount1;
                $cardamount = $res2cardamount1 + $res3cardamount1 + $res4cardamount1 + $res6cardamount1 + $res7cardamount1 + $res8cardamount1 + $res9cardamount1 + $res10cardamount1+ $res11cardamount1;
                $chequeamount = $res2chequeamount1 + $res3chequeamount1 + $res4chequeamount1 + $res6chequeamount1 + $res7chequeamount1 + $res8chequeamount1 + $res9chequeamount1 + $res10chequeamount1+ $res11chequeamount1;
                $onlineamount = $res2onlineamount1 + $res3onlineamount1 + $res4onlineamount1 + $res6onlineamount1 + $res7onlineamount1 + $res8onlineamount1 + $res9onlineamount1 + $res10onlineamount1+ $res11onlineamount1;
                $creditamount = $res2creditamount1 + $res3creditamount1 + $res4creditamount1 + $res6creditamount1 + $res7creditamount1 + $res8creditamount1 + $res9creditamount1 + $res10creditamount1+ $res11creditamount1;
                
                $cashamount1 = $cashamount - $res5cashamount1 - $res54cashamount1;
                $cardamount1 = $cardamount - $res5cardamount1 - $res54cardamount1;
                $chequeamount1 = $chequeamount - $res5chequeamount1 - $res54chequeamount1;
                $onlineamount1 = $onlineamount - $res5onlineamount1 - $res54onlineamount1;
                $creditamount1 = $creditamount - $res5creditamount1 - $res54creditamount1;

                $totalcash += $cashamount1;
                $totalcard += $cardamount1;
                $totalcheque += $chequeamount1;
                $totalonline += $onlineamount1;
                $totalmpesa += $creditamount1;
                
                $total = $cashamount1 + $onlineamount1 + $chequeamount1 + $cardamount1 + $creditamount1;
              ?>
              <?php if($key == '0'){ ?>
                <td class="bodytext31" valign="center" align="right"><?php echo number_format($cashamount1,2); ?></td>
              <?php } else if ($key == '1') { ?>
                <td class="bodytext31" valign="center" align="right"><?php echo number_format($cardamount1,2); ?></td>
              <?php } else if ($key == '2') { ?>
                <td class="bodytext31" valign="center" align="right"><?php echo number_format($chequeamount1,2); ?></td>
              <?php } else if ($key == '3') { ?>
                <td class="bodytext31" valign="center" align="right"><?php echo number_format($onlineamount1,2); ?></td>
              <?php } else if ($key == '4') { ?>
                <td class="bodytext31" valign="center" align="right"><?php echo number_format($creditamount1,2); ?></td>
              <?php } ?> 
            <?php } ?> 
            <?php if($key == '0'){ ?>
              <td class="bodytext31" valign="center" align="right"><?php echo number_format($totalcash,2); ?></td>
            <?php } else if ($key == '1') { ?>
              <td class="bodytext31" valign="center" align="right"><?php echo number_format($totalcard,2); ?></td>
            <?php } else if ($key == '2') { ?>
              <td class="bodytext31" valign="center" align="right"><?php echo number_format($totalcheque,2); ?></td>
            <?php } else if ($key == '3') { ?>
              <td class="bodytext31" valign="center" align="right"><?php echo number_format($totalonline,2); ?></td>
            <?php } else if ($key == '4') { ?>
              <td class="bodytext31" valign="center" align="right"><?php echo number_format($totalmpesa,2); ?></td>
            <?php } ?>  
          </tr>
          <?php } ?>
          <tr bgcolor="#ecf0f5">
            <td class="bodytext31" valign="center" align="right" colspan="2"><strong>TOTAL: </strong></td>
            <?php
              $monthlytotal = $yearlytotal = 0;
              $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            
              for($i = 0; $i < $from_month; $i++){
                $month = $months[$i];
                $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
                $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));

                $query2 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionpaynow where locationcode='$locationcode' and transactiondate between '$start_month' and '$end_month'"; 
                $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res2 = mysqli_fetch_array($exec2);
                
                  $res2cashamount1 = $res2['cashamount1'];
                $res2onlineamount1 = $res2['onlineamount1'];
                $res2creditamount1 = $res2['creditamount1'];
                $res2chequeamount1 = $res2['chequeamount1'];
                $res2cardamount1 = $res2['cardamount1'];

                 
                  $query3 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionexternal where locationcode='$locationcode' and transactiondate between '$start_month' and '$end_month'"; 
                $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res3 = mysqli_fetch_array($exec3);
                
                  $res3cashamount1 = $res3['cashamount1'];
                $res3onlineamount1 = $res3['onlineamount1'];
                $res3creditamount1 = $res3['creditamount1'];
                $res3chequeamount1 = $res3['chequeamount1'];
                $res3cardamount1 = $res3['cardamount1'];
                
                
                $query4 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_billing where locationcode='$locationcode' and billingdatetime between '$start_month' and '$end_month'"; 
                $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res4 = mysqli_fetch_array($exec4);
                
                  $res4cashamount1 = $res4['cashamount1'];
                $res4onlineamount1 = $res4['onlineamount1'];
                $res4creditamount1 = $res4['creditamount1'];
                $res4chequeamount1 = $res4['chequeamount1'];
                $res4cardamount1 = $res4['cardamount1'];
                
                $query5 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from refund_paynow where locationcode='$locationcode' and transactiondate between '$start_month' and '$end_month'"; 
                $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res5 = mysqli_fetch_array($exec5);
                
                  $res5cashamount1 = $res5['cashamount1'];
                $res5onlineamount1 = $res5['onlineamount1'];
                $res5creditamount1 = $res5['creditamount1'];
                $res5chequeamount1 = $res5['chequeamount1'];
                $res5cardamount1 = $res5['cardamount1'];
                
                $query54 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1  from deposit_refund where locationcode='$locationcode' and  recorddate between '$start_month' and '$end_month'"; 
                $exec54 = mysqli_query($GLOBALS["___mysqli_ston"], $query54) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($res54 = mysqli_fetch_array($exec54))
                {
              
                $res54cashamount1 = $res54['cashamount1'];
                $res54onlineamount1 = $res54['onlineamount1'];
                $res54creditamount1 = $res54['creditamount1'];
                $res54chequeamount1 = $res54['chequeamount1'];
                $res54cardamount1 = $res54['cardamount1'];
                 
                 }  //refund adv
                
                $query6 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionadvancedeposit where locationcode='$locationcode' and transactiondate between '$start_month' and '$end_month'"; 
                $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res6 = mysqli_fetch_array($exec6);
                
                  $res6cashamount1 = $res6['cashamount1'];
                $res6onlineamount1 = $res6['onlineamount1'];
                $res6creditamount1 = $res6['creditamount1'];
                $res6chequeamount1 = $res6['chequeamount1'];
                $res6cardamount1 = $res6['cardamount1'];

                $query7 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionipdeposit where locationcode='$locationcode' and transactiondate between '$start_month' and '$end_month'"; 
                $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res7 = mysqli_fetch_array($exec7);
                
                  $res7cashamount1 = $res7['cashamount1'];
                $res7onlineamount1 = $res7['onlineamount1'];
                $res7creditamount1 = $res7['creditamount1'];
                $res7chequeamount1 = $res7['chequeamount1'];
                $res7cardamount1 = $res7['cardamount1'];
                
                $query8 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(mpesaamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionip where locationcode='$locationcode' and transactiondate between '$start_month' and '$end_month'"; 
                $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res8 = mysqli_fetch_array($exec8);
                
                  $res8cashamount1 = $res8['cashamount1'];
                $res8onlineamount1 = $res8['onlineamount1'];
                $res8creditamount1 = $res8['creditamount1'];
                $res8chequeamount1 = $res8['chequeamount1'];
                $res8cardamount1 = $res8['cardamount1'];
                
                  $query9 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionipcreditapproved where locationcode='$locationcode' and transactiondate between '$start_month' and '$end_month'"; 
                $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res9 = mysqli_fetch_array($exec9);
                
                  $res9cashamount1 = $res9['cashamount1'];
                $res9onlineamount1 = $res9['onlineamount1'];
                $res9creditamount1 = $res9['creditamount1'];
                $res9chequeamount1 = $res9['chequeamount1'];
                $res9cardamount1 = $res9['cardamount1'];

                $query10 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from receiptsub_details where locationcode='$locationcode' and transactiondate between '$start_month' and '$end_month'"; 
                $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res10 = mysqli_fetch_array($exec10);
                
                  $res10cashamount1 = $res10['cashamount1'];
                $res10onlineamount1 = $res10['onlineamount1'];
                $res10creditamount1 = $res10['creditamount1'];
                $res10chequeamount1 = $res10['chequeamount1'];
                $res10cardamount1 = $res10['cardamount1'];
              
              $query11 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount+mpesaamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionpaylater where locationcode='$locationcode' and docno like 'AR-%' and transactionstatus like 'onaccount' and transactiondate between '$start_month' and '$end_month'"; 
                $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res11 = mysqli_fetch_array($exec11);
                
                  $res11cashamount1 = $res11['cashamount1'];
                $res11onlineamount1 = $res11['onlineamount1'];
                $res11creditamount1 = $res11['creditamount1'];
                $res11chequeamount1 = $res11['chequeamount1'];
                $res11cardamount1 = $res11['cardamount1'];

                
                $cashamount = $res2cashamount1 + $res3cashamount1 + $res4cashamount1 + $res6cashamount1 + $res7cashamount1 + $res8cashamount1 + $res9cashamount1 + $res10cashamount1+ $res11cashamount1;
                $cardamount = $res2cardamount1 + $res3cardamount1 + $res4cardamount1 + $res6cardamount1 + $res7cardamount1 + $res8cardamount1 + $res9cardamount1 + $res10cardamount1+ $res11cardamount1;
                $chequeamount = $res2chequeamount1 + $res3chequeamount1 + $res4chequeamount1 + $res6chequeamount1 + $res7chequeamount1 + $res8chequeamount1 + $res9chequeamount1 + $res10chequeamount1+ $res11chequeamount1;
                $onlineamount = $res2onlineamount1 + $res3onlineamount1 + $res4onlineamount1 + $res6onlineamount1 + $res7onlineamount1 + $res8onlineamount1 + $res9onlineamount1 + $res10onlineamount1+ $res11onlineamount1;
                $creditamount = $res2creditamount1 + $res3creditamount1 + $res4creditamount1 + $res6creditamount1 + $res7creditamount1 + $res8creditamount1 + $res9creditamount1 + $res10creditamount1+ $res11creditamount1;
                
                $cashamount1 = $cashamount - $res5cashamount1 - $res54cashamount1;
                $cardamount1 = $cardamount - $res5cardamount1 - $res54cardamount1;
                $chequeamount1 = $chequeamount - $res5chequeamount1 - $res54chequeamount1;
                $onlineamount1 = $onlineamount - $res5onlineamount1 - $res54onlineamount1;
                $creditamount1 = $creditamount - $res5creditamount1 - $res54creditamount1;

                $totalcash += $cashamount1;
                $totalcard += $cardamount1;
                $totalcheque += $chequeamount1;
                $totalonline += $onlineamount1;
                $totalmpesa += $creditamount1;
                
                $total = $cashamount1 + $onlineamount1 + $chequeamount1 + $cardamount1 + $creditamount1;
                $monthlytotal = $total;
                $yearlytotal += $monthlytotal;
              ?>
              <td class="bodytext31" valign="center" align="right"><strong><?php echo number_format($monthlytotal,2); ?></strong></td>
            <?php } ?>
            <td class="bodytext31" valign="center" align="right"><strong><?php echo number_format($yearlytotal,2); ?></strong></td>
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

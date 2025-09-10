<?php 

session_start();

header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="CostCenterReport.xls"');

header('Cache-Control: max-age=80');


include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d');

$transactiondateto = date('Y-m-d');

$totalnetprofit=0;

$searchsuppliername = "";

$res1username = '';

$res2username = '';

$res3username = '';

$res4username = '';

$res5username = '';

$res6username = '';

$res7username = '';


$transactiondatefrom = date('Y-m-01');
$transactiondateto = date('Y-m-d');

if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('m'); }
if (isset($_REQUEST["searchquarter"])) { $searchquarter = $_REQUEST["searchquarter"]; } else { $searchquarter = ""; }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = ""; }
if (isset($_REQUEST["searchyear1"])) { $searchyear1 = $_REQUEST["searchyear1"]; } else { $searchyear1 = ""; }
if (isset($_REQUEST["fromyear"])) { $fromyear = $_REQUEST["fromyear"]; } else { $fromyear = ""; }
if (isset($_REQUEST["toyear"])) { $toyear = $_REQUEST["toyear"]; } else { $toyear = ""; }
if (isset($_REQUEST["period"])) { $period = $_REQUEST["period"]; } else { $period = ""; }
  if (isset($_REQUEST["cc_name"])) { $cc_name = $_REQUEST["cc_name"]; } else { $cc_name = ""; }
  if (isset($_REQUEST["searchmonthto"])) { $searchmonthto = $_REQUEST["searchmonthto"]; } else { $searchmonthto = date('m'); }
  if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; $transactiondatefrom = $_REQUEST["ADate1"];  } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; $transactiondateto = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }



  
        /*if($period == 'monthly')
        {
        $month = $searchmonth;
        $month12 = $searchmonth;
        $year = $searchyear;
        $fromdate = date('Y-m-d',strtotime('01-'.$month.'-'.$year));
        $todate = date('Y-m-t',strtotime('last day of'.$searchmonthto.'-'.$year));
        }*/
        if($period == 'quarterly')
        {
        
        $stmonth = ($searchquarter*3)+1;
        $enmonth = ($searchquarter+1)*3;
        $fromdate = date('Y-m-d',strtotime('01-'.$stmonth.'-'.$searchyear1));
        $todate = date('Y-m-t',strtotime('01-'.$enmonth.'-'.$searchyear1));
        }
        /*elseif($period == 'yearly')
        {
        $fromdate = date('Y-m-d',strtotime('01-01-'.$fromyear));
        $todate = date('Y-m-t',strtotime('01-12-'.$toyear));
        }*/
        elseif($period == 'dates range')
        {
        $fromdate = $ADate1;
        $todate = $ADate2;
        } 
        
  $query612 = "select * from master_costcenter where auto_number = '$cc_name' and recordstatus <> 'deleted'";
    $exec612 = mysqli_query($GLOBALS["___mysqli_ston"], $query612) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    $res612 = mysqli_fetch_array($exec612);
    $res612cost_center = $res612['name'];
?>



 
  <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse"   cellspacing="0" cellpadding="4" width="45%" align="left" border="0">
<tr><td>Cost Center Report</td></tr>
<tr>
 
 <?php

       if($period == 'monthly'){
  $months = array("","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    for($i = $searchmonth; $i <= $searchmonthto; $i++){
  $monthlystartdate= date($searchyear.'-'.$searchmonth.'-01');
  $monthlyenddate= date($searchyear.'-'.$searchmonthto.'-t');
  $month = $months[$i];
  }
        ?>
       <tr>
    <td width="25%"  align="left" valign="center"  class="bodytext31" style="text-transform:uppercase;"><?php echo $period; ?>&nbsp;_<?php echo $monthlystartdate; ?>_TO_<?php echo $monthlyenddate; ?>
    <?php  for($i = $searchmonth; $i <= $searchmonthto; $i++){ ?>
     
      <td   align="left" valign="center"    class="bodytext31">&nbsp;</td>    
    <?php }?>
    </tr>
       <tr>
        <td   align="left" valign="center"  class="bodytext31"><?php echo $res612cost_center; ?>
 
    <?php  for($i = $searchmonth; $i <= $searchmonthto; $i++){ ?>
     
      <td   align="left" valign="center"    class="bodytext31">&nbsp;</td>    
    <?php }?>
    </tr>
    <?php }else if($period == 'quarterly'){ ?>
    <tr>
    
    <td width="69%"  align="left" valign="center"  class="bodytext31" style="text-transform:uppercase;"><?php echo $period; ?>&nbsp;<?php echo $fromdate;?>_TO_<?php echo $todate; ?>
    </tr>
    <tr>
    <td width="69%"  align="left" valign="center"  class="bodytext31"><?php echo $res612cost_center; ?>
 </td>
       <td   align="left" valign="center"    class="bodytext31">&nbsp;</td>
      </tr> 
    <?php }else if($period == 'dates range'){ ?>
    <tr>
    <td width="69%"  align="left" valign="center"  class="bodytext31" style="text-transform:uppercase;"><?php echo $period; ?>&nbsp;_<?php echo $fromdate; ?>_&nbsp;To&nbsp;_<?php echo $todate; ?> 
    </tr>
    <tr>
    <td width="69%"  align="left" valign="center"  class="bodytext31"><?php echo $res612cost_center; ?>
 </td>    
     <td   align="left" valign="center"    class="bodytext31">&nbsp;</td> 
     </tr>
     <?php }else if($period == 'yearly'){ ?>
     
     <tr>
     
     
    <td   align="left" valign="center"  class="bodytext31" style="text-transform:uppercase;"><?php echo $period; ?>&nbsp;<?php echo $fromyear; ?>_TO_<?php echo $toyear; ?>
    
    
    
    <?php for($year = $fromyear;$year <= $toyear;$year++) // Show Years
          { ?>
          <td   align="left" valign="center"  class="bodytext31">&nbsp;</td> 
            <?php } ?>
    </tr>
     
     <tr>
    <td   align="left" valign="center"  class="bodytext31"><?php echo $res612cost_center; ?>
 </td>    
      <?php for($year = $fromyear;$year <= $toyear;$year++) // Show Years
          { ?>
          <td   align="left" valign="center"  class="bodytext31">&nbsp;</td> 
            <?php } ?>  
            </tr>
     <?php }?>

              </tr>
       <?php 
       if($period == 'dates range'){ ?>
       
<tr>
        
        <?php
            $gorsstotalamount=0;
      $gorsstotalamount1=0;
       $query12 = "
      
      select master_costcenter.name as name,B.id,B.accountsmain,A.auto_number from master_costcenter JOIN master_accountname AS B ON B.cost_center = master_costcenter.auto_number join tb AS A on A.ledger_id = B.id where master_costcenter.auto_number = '$cc_name' and (A.transaction_date BETWEEN '$fromdate' and '$todate') and B.accountsmain IN ('4','5') GROUP BY
   A.ledger_id ";
//sum(A.transaction_amount) as amount,
      $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
      $num12 = mysqli_num_rows($exec12);
      while ($res12 = mysqli_fetch_array($exec12))
      {
      
      $res12name= $res12['name'];
      
      $res12id = $res12['id'];
      
      $res12accountsmain = $res12['accountsmain'];
      
      $res12auto_number = $res12['auto_number'];
      
        if($res12accountsmain=='4'){
      $query2 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'C' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
  
    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res2 = mysqli_fetch_array($exec2))
    {
    $amount = $res2['trn_amount'];
      
    $gorsstotalamount+=$amount;
    } 
    }
    
    if($res12accountsmain=='5'){
     $query21 = " Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
    
    $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res21 = mysqli_fetch_array($exec21))
    {
    $res21amount = $res21['trn_amount'];
      
    $gorsstotalamount1+=$res21amount;
    } 
    }
      
       } 
       ?>
       <tr>
<td width="40%"  align="left" valign="center"   class="bodytext31">Total Revenue</td>
<td   align="right" valign="center"   class="bodytext31"><?php echo number_format($gorsstotalamount,2); ?></td>
  </tr>
       <tr>
<td width="40%"  align="left" valign="center"  class="bodytext31">Less: Supplies Cost</td>
<td   align="right" valign="center"    class="bodytext31"><?php echo number_format($gorsstotalamount1,2); ?></td>
 </tr>
      <?php
      $grosscc=$gorsstotalamount-$gorsstotalamount1;      
      ?>
        <tr>
                <td width="40%"  align="left" valign="center"    class="bodytext31">Gross Profit</td>
        <td   align="right" valign="center"  class="bodytext31"><?php echo number_format($grosscc,2); ?></td>
</tr>
       <tr> <td>&nbsp;</td></tr>
 <tr >
<td colspan="2"  align="left" valign="center"  class="bodytext31">Expenses</td>
 </tr>     
       <?php
       $totres201amount=0;
       $query20 = "select ledger_id,transaction_type,B.accountname from tb JOIN master_accountname AS B ON B.id = tb.ledger_id where cost_center_code = '$cc_name' and transaction_date BETWEEN '$fromdate' and '$todate' and B.accountsmain='6' GROUP BY
    ledger_id  ";
    $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res20 = mysqli_fetch_array($exec20))
    {
    
     $res20ledger_id= $res20['ledger_id'];
     $res20transaction_type = $res20['transaction_type'];
     $res20accountname = ucwords(strtolower($res20['accountname']));
      
    $query201 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res20ledger_id') and cost_center_code='$cc_name'
GROUP BY
    transaction_type) as result"; 
    $exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201) or die ("Error in Query201".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res201 = mysqli_fetch_array($exec201);
    $res201amount = $res201['trn_amount'];
    $totres201amount+=$res201amount;
    if($res201amount>0){
    ?>
    <tr>
                <td width="40%"  align="left" valign="center"   class="bodytext31"><?php echo $res20accountname; ?></td>
        <td   align="right" valign="center"  class="bodytext31"><?php echo number_format($res201amount,2); ?></td>
        </tr>
    <?php
    }
    } 
    ?>  
    <tr>
                <td width="40%"  align="left" valign="center"   class="bodytext31">Total Expenses</td>
        <td   align="right" valign="center"  class="bodytext31"><?php echo number_format($totres201amount,2); ?></td>
        </tr>   
    <tr> <td>&nbsp;</td> </tr>
    <?php
    $totalnetprofit=$grosscc-$totres201amount;
     ?>
    <tr>
                <td width="40%"  align="left" valign="center"   class="bodytext31">Net Profit Before Tax</td>
        <td   align="right" valign="center"  class="bodytext31"><?php echo number_format($totalnetprofit,2); ?></td>
        </tr>
       <tr>
        <td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
        <td  align="left" valign="center"  class="bodytext31">&nbsp;</td>
      </tr>
      </tr>
    
      
      <?php } 
       ?>
       <?php 
       if($period == 'monthly'){
       ?>
       <tr>
       <td   align="left" valign="center"  class="bodytext31">&nbsp;</td>
       <?php
        $months = array("","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        for($i = $searchmonth; $i <= $searchmonthto; $i++){
  $monthlystartdate= date($searchyear.'-'.'0'.$i.'-01');
  $monthlyenddate= date($searchyear.'-'.'0'.$i.'-t');
  $month = $months[$i];
       
      ?>
    
        <td  class="bodytext31" align="right"><?php echo $month; ?></td>
    <?php
    }
    ?>
    </tr>
    <tr>
      <td   align="left" valign="center"    class="bodytext31">Total Revenue</td>
    
      <?php
    
        $months = array("","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        for($i = $searchmonth; $i <= $searchmonthto; $i++){
  $monthlystartdate= date($searchyear.'-'.'0'.$i.'-01');
  $monthlyenddate= date($searchyear.'-'.'0'.$i.'-t');
  $month = $months[$i];
   
            $gorsstotalamount=0;
      $gorsstotalamount1=0;
     $query12 = "select master_costcenter.name as name,B.id,B.accountsmain,A.auto_number from master_costcenter JOIN master_accountname AS B ON B.cost_center = master_costcenter.auto_number join tb AS A on A.ledger_id = B.id where master_costcenter.auto_number = '$cc_name' and (A.transaction_date BETWEEN '$monthlystartdate' and '$monthlyenddate') and B.accountsmain IN ('4','5') GROUP BY
   A.ledger_id   ";
//sum(A.transaction_amount) as amount,
      $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
      $num12 = mysqli_num_rows($exec12);
      while ($res12 = mysqli_fetch_array($exec12))
      {
      
      $res12name= $res12['name'];
      
      $res12id = $res12['id'];
      
      $res12accountsmain = $res12['accountsmain'];
      
      $res12auto_number = $res12['auto_number'];
      
        if($res12accountsmain=='4'){
      $query2 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'C' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$monthlystartdate' AND '$monthlyenddate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
  
    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res2 = mysqli_fetch_array($exec2))
    {
    $amount = $res2['trn_amount'];
      
    $gorsstotalamount+=$amount;
    } 
    }
    
    if($res12accountsmain=='5'){
     $query21 = " Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$monthlystartdate' AND '$monthlyenddate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
    
    $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res21 = mysqli_fetch_array($exec21))
    {
    $res21amount = $res21['trn_amount'];
      
    $gorsstotalamount1+=$res21amount;
    } 
    }
      
       } 
       ?>
       
<td   align="right" valign="center"   class="bodytext31"><?php echo number_format($gorsstotalamount,2); ?></td>
      <?php     
     } ?>
     
     </tr>
     
     
     <tr>
      <td   align="left" valign="center"    class="bodytext31">Less: Supplies Cost</td>
    <?php
    
        $months = array("","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        for($i = $searchmonth; $i <= $searchmonthto; $i++){
  $monthlystartdate= date($searchyear.'-'.'0'.$i.'-01');
  $monthlyenddate= date($searchyear.'-'.'0'.$i.'-t');
  $month = $months[$i];
   
            $gorsstotalamount=0;
      $gorsstotalamount1=0;
     $query12 = "select master_costcenter.name as name,B.id,B.accountsmain,A.auto_number from master_costcenter JOIN master_accountname AS B ON B.cost_center = master_costcenter.auto_number join tb AS A on A.ledger_id = B.id where master_costcenter.auto_number = '$cc_name' and (A.transaction_date BETWEEN '$monthlystartdate' and '$monthlyenddate') and B.accountsmain IN ('4','5') GROUP BY
   A.ledger_id   ";
//sum(A.transaction_amount) as amount,
      $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
      $num12 = mysqli_num_rows($exec12);
      while ($res12 = mysqli_fetch_array($exec12))
      {
      
      $res12name= $res12['name'];
      
      $res12id = $res12['id'];
      
      $res12accountsmain = $res12['accountsmain'];
      
      $res12auto_number = $res12['auto_number'];
      
        if($res12accountsmain=='4'){
      $query2 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'C' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$monthlystartdate' AND '$monthlyenddate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
  
    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res2 = mysqli_fetch_array($exec2))
    {
    $amount = $res2['trn_amount'];
      
    $gorsstotalamount+=$amount;
    } 
    }
    
    if($res12accountsmain=='5'){
     $query21 = " Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$monthlystartdate' AND '$monthlyenddate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
    
    $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res21 = mysqli_fetch_array($exec21))
    {
    $res21amount = $res21['trn_amount'];
      
    $gorsstotalamount1+=$res21amount;
    } 
    }
      
       } 
       ?>
       
<td   align="right" valign="center"   class="bodytext31"><?php echo number_format($gorsstotalamount1,2); ?></td>
      <?php     
     } ?>
     
     </tr>
     
      <tr>
      <td   align="left" valign="center"    class="bodytext31">Gross Profit</td>
    <?php
    
        $months = array("","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        for($i = $searchmonth; $i <= $searchmonthto; $i++){
  $monthlystartdate= date($searchyear.'-'.'0'.$i.'-01');
  $monthlyenddate= date($searchyear.'-'.'0'.$i.'-t');
  $month = $months[$i];
   
            $gorsstotalamount=0;
      $gorsstotalamount1=0;
     $query12 = "select master_costcenter.name as name,B.id,B.accountsmain,A.auto_number from master_costcenter JOIN master_accountname AS B ON B.cost_center = master_costcenter.auto_number join tb AS A on A.ledger_id = B.id where master_costcenter.auto_number = '$cc_name' and (A.transaction_date BETWEEN '$monthlystartdate' and '$monthlyenddate') and B.accountsmain IN ('4','5') GROUP BY
   A.ledger_id   ";
//sum(A.transaction_amount) as amount,
      $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
      $num12 = mysqli_num_rows($exec12);
      while ($res12 = mysqli_fetch_array($exec12))
      {
      
      $res12name= $res12['name'];
      
      $res12id = $res12['id'];
      
      $res12accountsmain = $res12['accountsmain'];
      
      $res12auto_number = $res12['auto_number'];
      
        if($res12accountsmain=='4'){
      $query2 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'C' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$monthlystartdate' AND '$monthlyenddate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
  
    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res2 = mysqli_fetch_array($exec2))
    {
    $amount = $res2['trn_amount'];
      
    $gorsstotalamount+=$amount;
    } 
    }
    
    if($res12accountsmain=='5'){
     $query21 = " Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$monthlystartdate' AND '$monthlyenddate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
    
    $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res21 = mysqli_fetch_array($exec21))
    {
    $res21amount = $res21['trn_amount'];
      
    $gorsstotalamount1+=$res21amount;
    } 
    }
      
       } 
       
       $grosscc=$gorsstotalamount-$gorsstotalamount1;
       
       ?>
       
<td   align="right" valign="center"   class="bodytext31"><?php echo number_format($grosscc,2); ?></td>
      <?php     
     } ?>
     
     </tr>
      
      
      <tr>

        <td>&nbsp;</td>

      </tr>

       
       <tr >
              <td colspan=""  align="left" valign="center"  class="bodytext31">Expenses</td>
         <?php
      for($i = $searchmonth; $i <= $searchmonthto; $i++){ ?>
      <td   align="left" valign="center"    class="bodytext31">&nbsp;</td>
     
    <?php }?>

              </tr>
        
    <?php
    $totres2012amount=0;
        $months = array("","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

        $searchmonth_prefix = "";
        $searchmonthto_prefix="";
        if($searchmonth >0 && $searchmonth <10)
        {
          $searchmonth_prefix = '0';
        }
        if($searchmonthto >0 && $searchmonthto <10)
        {
          $searchmonthto_prefix = '0';
        }
        $start_date= date($searchyear.'-'.$searchmonth_prefix.$searchmonth.'-01');
        $end_date = date($searchyear.'-'.$searchmonthto_prefix.$searchmonthto.'-t');
       

        $query20 = "select ledger_id,transaction_type,B.accountname from tb JOIN master_accountname AS B ON B.id = tb.ledger_id where cost_center_code = '$cc_name' and transaction_date BETWEEN '$start_date' and '$end_date' and B.accountsmain='6' GROUP BY
    ledger_id  ";

    $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res20 = mysqli_fetch_array($exec20))
    {

      $res20ledger_id= $res20['ledger_id'];
     $res20transaction_type = $res20['transaction_type'];
     $res20accountname = ucwords(strtolower($res20['accountname']));

     ?>

     <tr><td   align="left" valign="center"   class="bodytext31"><?php echo $res20accountname; ?></td>
    <?php  for($i = $searchmonth; $i <= $searchmonthto; $i++){

      
        $prefix = "";
          
          if($i >0 && $i <10)
          {
            $prefix = '0';
          }
          
        $monthlystartdate= date($searchyear.'-'.$prefix.$i.'-01');
      $monthlyenddate= date($searchyear.'-'.$prefix.$i.'-t');
      $totres2012amount = 0;
          $query201 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$monthlystartdate' AND '$monthlyenddate' AND `ledger_id` IN('$res20ledger_id') and cost_center_code='$cc_name'
GROUP BY
    transaction_type) as result"; 
  
  
    $exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201) or die ("Error in Query201".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res201 = mysqli_fetch_array($exec201);
    $res201amount = $res201['trn_amount'];
    $totres2012amount = $res201amount;
      ?>

        <td   align="right" valign="center"  class="bodytext31"><?php  echo number_format($totres2012amount,2);   ?></td>

    <?php  }

    }

    ?>
      
    
      <tr>
                <td   align="left" valign="center"   class="bodytext31">Total Expenses</td>
        <?php
        $months = array("","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        for($i = $searchmonth; $i <= $searchmonthto; $i++){
    $monthlystartdate= date($searchyear.'-'.'0'.$i.'-01');
  $monthlyenddate= date($searchyear.'-'.'0'.$i.'-t');

      $totres201amount=0;
        $query20 = "select ledger_id,transaction_type,B.accountname from tb JOIN master_accountname AS B ON B.id = tb.ledger_id where cost_center_code = '$cc_name' and transaction_date BETWEEN '$monthlystartdate' and '$monthlyenddate' and B.accountsmain='6' GROUP BY
    ledger_id  ";
  
    $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res20 = mysqli_fetch_array($exec20))
    {
    
     $res20ledger_id= $res20['ledger_id'];
     $res20transaction_type = $res20['transaction_type'];
     $res20accountname = $res20['accountname'];
      
    $query201 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$monthlystartdate' AND '$monthlyenddate' AND `ledger_id` IN('$res20ledger_id') and cost_center_code='$cc_name'
GROUP BY
    transaction_type) as result"; 
  
  
    $exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201) or die ("Error in Query201".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res201 = mysqli_fetch_array($exec201);
    $res201amount = $res201['trn_amount'];
    $totres201amount+=$res201amount;
    }
      ?>
      
        <td   align="right" valign="center"  class="bodytext31"><?php echo number_format($totres201amount,2); ?></td>
        
        <?php }?>
        </tr>
    
    <tr>
        <td>&nbsp;</td>
      
      
    <tr>
                <td   align="left" valign="center"   class="bodytext31">Net Profit Before Tax</td>
      <?php
      $totalnetprofit=0;
    $months = array("","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        for($i = $searchmonth; $i <= $searchmonthto; $i++){
    
    
  $monthlystartdate= date($searchyear.'-'.'0'.$i.'-01');
  $monthlyenddate= date($searchyear.'-'.'0'.$i.'-t');
  $month = $months[$i];
   
            $gorsstotalamount=0;
      $gorsstotalamount1=0;
     $query12 = "select master_costcenter.name as name,B.id,B.accountsmain,A.auto_number from master_costcenter JOIN master_accountname AS B ON B.cost_center = master_costcenter.auto_number join tb AS A on A.ledger_id = B.id where master_costcenter.auto_number = '$cc_name' and (A.transaction_date BETWEEN '$monthlystartdate' and '$monthlyenddate') and B.accountsmain IN ('4','5') GROUP BY
   A.ledger_id   ";
//sum(A.transaction_amount) as amount,
      $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
      $num12 = mysqli_num_rows($exec12);
      while ($res12 = mysqli_fetch_array($exec12))
      {
      
      $res12name= $res12['name'];
      
      $res12id = $res12['id'];
      
      $res12accountsmain = $res12['accountsmain'];
      
      $res12auto_number = $res12['auto_number'];
      
        if($res12accountsmain=='4'){
      $query2 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'C' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$monthlystartdate' AND '$monthlyenddate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
  
    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res2 = mysqli_fetch_array($exec2))
    {
    $amount = $res2['trn_amount'];
      
    $gorsstotalamount+=$amount;
    } 
    }
    
    if($res12accountsmain=='5'){
     $query21 = " Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$monthlystartdate' AND '$monthlyenddate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
    
    $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res21 = mysqli_fetch_array($exec21))
    {
    $res21amount = $res21['trn_amount'];
      
    $gorsstotalamount1+=$res21amount;
    } 
    }
    /*echo $gorsstotalamount;
    echo $gorsstotalamount1;
    echo "</br>";*/
        
      
       } 
      
        $grosscc=$gorsstotalamount-$gorsstotalamount1;
       
      $totres201amount=0;
       $query20 = "select ledger_id,transaction_type,B.accountname from tb JOIN master_accountname AS B ON B.id = tb.ledger_id where cost_center_code = '$cc_name' and transaction_date BETWEEN '$monthlystartdate' and '$monthlyenddate' and B.accountsmain='6' GROUP BY
    ledger_id  ";
  
    $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res20 = mysqli_fetch_array($exec20))
    {
    
     $res20ledger_id= $res20['ledger_id'];
     $res20transaction_type = $res20['transaction_type'];
     $res20accountname = $res20['accountname'];
      
    $query201 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$monthlystartdate' AND '$monthlyenddate' AND `ledger_id` IN('$res20ledger_id') and cost_center_code='$cc_name'
GROUP BY
    transaction_type) as result"; 
    $exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201) or die ("Error in Query201".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res201 = mysqli_fetch_array($exec201);
    $res201amount = $res201['trn_amount'];
    $totres201amount+=$res201amount;
    
    }
  
      $totalnetprofit=$grosscc-$totres201amount; 
     
     
     ?>
    <td   align="right" valign="center"  class="bodytext31"><?php echo number_format($totalnetprofit,2); ?></td>
        
    <?php
    }
    ?>
    </tr>
      
     <?php
      }     
       ?>
      <?php 
       if($period == 'quarterly'){ ?>
  
 
<tr>
        
        <?php
            $gorsstotalamount=0;
      $gorsstotalamount1=0;
       $query12 = "
      
      select master_costcenter.name as name,B.id,B.accountsmain,A.auto_number from master_costcenter JOIN master_accountname AS B ON B.cost_center = master_costcenter.auto_number join tb AS A on A.ledger_id = B.id where master_costcenter.auto_number = '$cc_name' and (A.transaction_date BETWEEN '$fromdate' and '$todate') and B.accountsmain IN ('4','5') GROUP BY
   A.ledger_id ";
//sum(A.transaction_amount) as amount,
      $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
      $num12 = mysqli_num_rows($exec12);
      while ($res12 = mysqli_fetch_array($exec12))
      {
      
      $res12name= $res12['name'];
      
      $res12id = $res12['id'];
      
      $res12accountsmain = $res12['accountsmain'];
      
      $res12auto_number = $res12['auto_number'];
      
        if($res12accountsmain=='4'){
      $query2 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'C' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
  
    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res2 = mysqli_fetch_array($exec2))
    {
    $amount = $res2['trn_amount'];
      
    $gorsstotalamount+=$amount;
    } 
    }
    
    if($res12accountsmain=='5'){
     $query21 = " Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
    
    $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res21 = mysqli_fetch_array($exec21))
    {
    $res21amount = $res21['trn_amount'];
      
    $gorsstotalamount1+=$res21amount;
    } 
    }
      
       } 
       ?>
       <tr>
<td width="40%"  align="left" valign="center"   class="bodytext31">Total Revenue</td>
<td   align="right" valign="center"   class="bodytext31"><?php echo number_format($gorsstotalamount,2); ?></td>
  </tr>
       <tr>
<td width="40%"  align="left" valign="center"  class="bodytext31">Less: Supplies Cost</td>
<td   align="right" valign="center"    class="bodytext31"><?php echo number_format($gorsstotalamount1,2); ?></td>
 </tr>
      <?php
      $grosscc=$gorsstotalamount-$gorsstotalamount1;      
      ?>
        <tr>
                <td width="40%"  align="left" valign="center"    class="bodytext31">Gross Profit</td>
        <td   align="right" valign="center"  class="bodytext31"><?php echo number_format($grosscc,2); ?></td>
</tr>
       <tr> <td>&nbsp;</td></tr>
 <tr >
<td colspan="2"  align="left" valign="center"  class="bodytext31">Expenses</td>
 </tr>     
       <?php
       $totres201amount=0;
       $query20 = "select ledger_id,transaction_type,B.accountname from tb JOIN master_accountname AS B ON B.id = tb.ledger_id where cost_center_code = '$cc_name' and transaction_date BETWEEN '$fromdate' and '$todate' and B.accountsmain='6' GROUP BY
    ledger_id  ";
    $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res20 = mysqli_fetch_array($exec20))
    {
    
     $res20ledger_id= $res20['ledger_id'];
     $res20transaction_type = $res20['transaction_type'];
     
     $res20accountname = ucwords(strtolower($res20['accountname']));
      
    $query201 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res20ledger_id') and cost_center_code='$cc_name'
GROUP BY
    transaction_type) as result"; 
    $exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201) or die ("Error in Query201".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res201 = mysqli_fetch_array($exec201);
    $res201amount = $res201['trn_amount'];
    $totres201amount+=$res201amount;
    if($res201amount>0){
    ?>
    <tr>
                <td width="40%"  align="left" valign="center"   class="bodytext31"><?php echo $res20accountname; ?></td>
        <td   align="right" valign="center"  class="bodytext31"><?php echo number_format($res201amount,2); ?></td>
        </tr>
    <?php
    }
    } 
    ?>  
    <tr>
                <td width="40%"  align="left" valign="center"   class="bodytext31">Total Expenses</td>
        <td   align="right" valign="center"  class="bodytext31"><?php echo number_format($totres201amount,2); ?></td>
        </tr>   
    <tr> <td>&nbsp;</td> </tr>
    <?php
    $totalnetprofit=$grosscc-$totres201amount;
     ?>
    <tr>
                <td width="40%"  align="left" valign="center"   class="bodytext31">Net Profit Before Tax</td>
        <td   align="right" valign="center"  class="bodytext31"><?php echo number_format($totalnetprofit,2); ?></td>
        </tr>
       <tr>
        <td class="bodytext31" valign="center"  align="left" >&nbsp;</td>
        <td  align="left" valign="center"  class="bodytext31">&nbsp;</td>
      </tr>
      </tr>
    
      
      <?php 
       }       
       ?>     
      <?php 
       if($period == 'yearly') { ?>
       <tr>
       <td  >&nbsp;</td>
        <?php
      for($year = $fromyear;$year <= $toyear;$year++) // Show Years
          {
          $date = $year; 
          ?>
       <td width="auto" align="right" valign="middle" class="bodytext3" style=""  >
            <?= $date; ?>
          </td>
          <?php }?>
          </tr>
          
          <tr>
          <td   align="left" valign="center"   class="bodytext31">Total Revenue</td>
          
       <?php
      for($year = $fromyear;$year <= $toyear;$year++) // Show Years
          {
          $date = $year;
          $fromdate = date('Y-m-d',strtotime('01-01-'.$date));
        $todate = date('Y-m-t',strtotime('01-12-'.$date));
            $gorsstotalamount=0;
      $gorsstotalamount1=0;
        $query12 = "
      
      select master_costcenter.name as name,B.id,B.accountsmain,A.auto_number from master_costcenter JOIN master_accountname AS B ON B.cost_center = master_costcenter.auto_number join tb AS A on A.ledger_id = B.id where master_costcenter.auto_number = '$cc_name' and (A.transaction_date BETWEEN '$fromdate' and '$todate') and B.accountsmain IN ('4','5') GROUP BY
   A.ledger_id ";
   
//sum(A.transaction_amount) as amount,
      $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
      $num12 = mysqli_num_rows($exec12);
      while ($res12 = mysqli_fetch_array($exec12))
      {
      
      $res12name= $res12['name'];
      
      $res12id = $res12['id'];
      
      $res12accountsmain = $res12['accountsmain'];
      
      $res12auto_number = $res12['auto_number'];
      
        if($res12accountsmain=='4'){
      $query2 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'C' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
  
    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res2 = mysqli_fetch_array($exec2))
    {
    $amount = $res2['trn_amount'];
      
    $gorsstotalamount+=$amount;
    } 
    }
    
    if($res12accountsmain=='5'){
     $query21 = " Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
    
    $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res21 = mysqli_fetch_array($exec21))
    {
    $res21amount = $res21['trn_amount'];
      
    $gorsstotalamount1+=$res21amount;
    } 
    }
      
       } 
       ?>
<td   align="right" valign="center"   class="bodytext31"><?php echo number_format($gorsstotalamount,2); ?></td>
      <?php } ?>      
        </tr>
        
        <tr>
          <td   align="left" valign="center"   class="bodytext31">Less: Supplies Cost</td>
       <?php
      for($year = $fromyear;$year <= $toyear;$year++) // Show Years
          {
          $date = $year;
          $fromdate = date('Y-m-d',strtotime('01-01-'.$date));
        $todate = date('Y-m-t',strtotime('01-12-'.$date));
            $gorsstotalamount=0;
      $gorsstotalamount1=0;
        $query12 = "
      
      select master_costcenter.name as name,B.id,B.accountsmain,A.auto_number from master_costcenter JOIN master_accountname AS B ON B.cost_center = master_costcenter.auto_number join tb AS A on A.ledger_id = B.id where master_costcenter.auto_number = '$cc_name' and (A.transaction_date BETWEEN '$fromdate' and '$todate') and B.accountsmain IN ('4','5') GROUP BY
   A.ledger_id ";
   
//sum(A.transaction_amount) as amount,
      $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
      $num12 = mysqli_num_rows($exec12);
      while ($res12 = mysqli_fetch_array($exec12))
      {
      
      $res12name= $res12['name'];
      
      $res12id = $res12['id'];
      
      $res12accountsmain = $res12['accountsmain'];
      
      $res12auto_number = $res12['auto_number'];
      
        if($res12accountsmain=='4'){
      $query2 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'C' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
  
    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res2 = mysqli_fetch_array($exec2))
    {
    $amount = $res2['trn_amount'];
      
    $gorsstotalamount+=$amount;
    } 
    }
    
    if($res12accountsmain=='5'){
     $query21 = " Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
    
    $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res21 = mysqli_fetch_array($exec21))
    {
    $res21amount = $res21['trn_amount'];
      
    $gorsstotalamount1+=$res21amount;
    } 
    }
      
       } 
       ?>
<td   align="right" valign="center"   class="bodytext31"><?php echo number_format($gorsstotalamount1,2); ?></td>
      <?php } ?>      
        </tr>
        
        <td   align="left" valign="center"   class="bodytext31">Gross Profit</td>
       <?php
      for($year = $fromyear;$year <= $toyear;$year++) // Show Years
          {
          $date = $year;
          $fromdate = date('Y-m-d',strtotime('01-01-'.$date));
        $todate = date('Y-m-t',strtotime('01-12-'.$date));
            $gorsstotalamount=0;
      $gorsstotalamount1=0;
        $query12 = "
      
      select master_costcenter.name as name,B.id,B.accountsmain,A.auto_number from master_costcenter JOIN master_accountname AS B ON B.cost_center = master_costcenter.auto_number join tb AS A on A.ledger_id = B.id where master_costcenter.auto_number = '$cc_name' and (A.transaction_date BETWEEN '$fromdate' and '$todate') and B.accountsmain IN ('4','5') GROUP BY
   A.ledger_id ";
   
//sum(A.transaction_amount) as amount,
      $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
      $num12 = mysqli_num_rows($exec12);
      while ($res12 = mysqli_fetch_array($exec12))
      {
      
      $res12name= $res12['name'];
      
      $res12id = $res12['id'];
      
      $res12accountsmain = $res12['accountsmain'];
      
      $res12auto_number = $res12['auto_number'];
      
        if($res12accountsmain=='4'){
      $query2 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'C' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
  
    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res2 = mysqli_fetch_array($exec2))
    {
    $amount = $res2['trn_amount'];
      
    $gorsstotalamount+=$amount;
    } 
    }
    
    if($res12accountsmain=='5'){
     $query21 = " Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
    
    $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res21 = mysqli_fetch_array($exec21))
    {
    $res21amount = $res21['trn_amount'];
      
    $gorsstotalamount1+=$res21amount;
    } 
    }
      
       } 
       $grosscc=$gorsstotalamount-$gorsstotalamount1;
       ?>
       
<td   align="right" valign="center"   class="bodytext31"><?php echo number_format($grosscc,2); ?></td>
      <?php } ?>      
        </tr>
        
       
       <tr>

        <td>&nbsp;</td>

      </tr>
    
     <tr >
         <td   align="left" valign="center"  class="bodytext31">Expenses</td>
     <?php for($year = $fromyear;$year <= $toyear;$year++) // Show Years
          { ?>
          <td   align="left" valign="center"  class="bodytext31">&nbsp;</td> 
            <?php } ?>
        
       </tr>  
    <?php
    $totres2012amount=0;
      for($year = $fromyear;$year <= $toyear;$year++) // Show Years
    {
     $date = $year;
     $fromdate = date('Y-m-d',strtotime('01-01-'.$date));
     $todate = date('Y-m-t',strtotime('01-12-'.$date));

      $totres201amount=0;
        $query20 = "select ledger_id,transaction_type,B.accountname from tb JOIN master_accountname AS B ON B.id = tb.ledger_id where cost_center_code = '$cc_name' and transaction_date BETWEEN '$fromdate' and '$todate' and B.accountsmain='6' GROUP BY
    ledger_id  ";
  
    $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res20 = mysqli_fetch_array($exec20))
    {
    
     $res20ledger_id= $res20['ledger_id'];
     $res20transaction_type = $res20['transaction_type'];
     
     $res20accountname = ucwords(strtolower($res20['accountname']));
     ?>
     <tr>
     <?php
      $query201 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res20ledger_id') and cost_center_code='$cc_name'
GROUP BY
    transaction_type) as result"; 
  
  
    $exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201) or die ("Error in Query201".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res201 = mysqli_fetch_array($exec201);
    $res201amount = $res201['trn_amount'];
    $totres2012amount+=$res201amount;
    if($res201amount>0){
    
    ?>
    
                <td   align="left" valign="center"   class="bodytext31"><?php echo $res20accountname; ?></td>
        
        <?php  
      
        for($o = $fromyear; $o <= $toyear; $o++){ 
    
    ?>
        <td   align="right" valign="center"  class="bodytext31"><?php if($o==$year){ echo number_format($totres2012amount,2); } else { echo number_format(0,2); }  ?></td>
        <?php } 
        $totres2012amount=0;
        ?>
      
      </tr>
    <?php
    }
    }
      
      }?>
      
      <tr >
         <td   align="left" valign="center"  class="bodytext31">Total Expenses</td>     
      <?php
     for($year = $fromyear;$year <= $toyear;$year++) // Show Years
     {
     $date = $year;
     $fromdate = date('Y-m-d',strtotime('01-01-'.$date));
     $todate = date('Y-m-t',strtotime('01-12-'.$date));
      
      $totres201amount=0;
        $query20 = "select ledger_id,transaction_type,B.accountname from tb JOIN master_accountname AS B ON B.id = tb.ledger_id where cost_center_code = '$cc_name' and transaction_date BETWEEN '$fromdate' and '$todate' and B.accountsmain='6' GROUP BY
    ledger_id  ";
  
    $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res20 = mysqli_fetch_array($exec20))
    {
    
     $res20ledger_id= $res20['ledger_id'];
     $res20transaction_type = $res20['transaction_type'];
     $res20accountname = $res20['accountname'];
      
    $query201 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res20ledger_id') and cost_center_code='$cc_name'
GROUP BY
    transaction_type) as result"; 
  
  
    $exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201) or die ("Error in Query201".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res201 = mysqli_fetch_array($exec201);
    $res201amount = $res201['trn_amount'];
    $totres201amount+=$res201amount;
    }
      ?>
      
        <td   align="right" valign="center"  class="bodytext31"><?php echo number_format($totres201amount,2); ?></td>
        
        <?php } ?>
        </tr>
      <tr> <td>&nbsp;</td> </tr>
    <tr >
         <td   align="left" valign="center"  class="bodytext31">Net Profit Before Tax</td> 
     
     
     
     
     <?php
     for($year = $fromyear;$year <= $toyear;$year++) // Show Years
     {
     $date = $year;
     $fromdate = date('Y-m-d',strtotime('01-01-'.$date));
     $todate = date('Y-m-t',strtotime('01-12-'.$date));
    
   
            $gorsstotalamount=0;
      $gorsstotalamount1=0;
     $query12 = "select master_costcenter.name as name,B.id,B.accountsmain,A.auto_number from master_costcenter JOIN master_accountname AS B ON B.cost_center = master_costcenter.auto_number join tb AS A on A.ledger_id = B.id where master_costcenter.auto_number = '$cc_name' and (A.transaction_date BETWEEN '$fromdate' and '$todate') and B.accountsmain IN ('4','5') GROUP BY
   A.ledger_id   ";
//sum(A.transaction_amount) as amount,
      $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
      $num12 = mysqli_num_rows($exec12);
      while ($res12 = mysqli_fetch_array($exec12))
      {
      
      $res12name= $res12['name'];
      
      $res12id = $res12['id'];
      
      $res12accountsmain = $res12['accountsmain'];
      
      $res12auto_number = $res12['auto_number'];
      
        if($res12accountsmain=='4'){
      $query2 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'C' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
  
    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res2 = mysqli_fetch_array($exec2))
    {
    $amount = $res2['trn_amount'];
      
    $gorsstotalamount+=$amount;
    } 
    }
    
    if($res12accountsmain=='5'){
     $query21 = " Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res12id') 
GROUP BY
    transaction_type) as result ";
    
    $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res21 = mysqli_fetch_array($exec21))
    {
    $res21amount = $res21['trn_amount'];
      
    $gorsstotalamount1+=$res21amount;
    } 
    }
    /*echo $gorsstotalamount;
    echo $gorsstotalamount1;
    echo "</br>";*/
        
      
       } 
      
        $grosscc=$gorsstotalamount-$gorsstotalamount1;
       
      $totres201amount=0;
       $query20 = "select ledger_id,transaction_type,B.accountname from tb JOIN master_accountname AS B ON B.id = tb.ledger_id where cost_center_code = '$cc_name' and transaction_date BETWEEN '$fromdate' and '$todate' and B.accountsmain='6' GROUP BY
    ledger_id  ";
  
    $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($res20 = mysqli_fetch_array($exec20))
    {
    
     $res20ledger_id= $res20['ledger_id'];
     $res20transaction_type = $res20['transaction_type'];
     $res20accountname = $res20['accountname'];
      
    $query201 = "Select sum(amount) as trn_amount FROM (SELECT
    transaction_type,
    CASE WHEN transaction_type = 'D' THEN SUM(transaction_amount) ELSE(-1*(SUM(`transaction_amount`)))
END AS amount
FROM
    `tb`
WHERE
    `transaction_date` BETWEEN '$fromdate' AND '$todate' AND `ledger_id` IN('$res20ledger_id') and cost_center_code='$cc_name'
GROUP BY
    transaction_type) as result"; 
    $exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201) or die ("Error in Query201".mysqli_error($GLOBALS["___mysqli_ston"]));
    $res201 = mysqli_fetch_array($exec201);
    $res201amount = $res201['trn_amount'];
    $totres201amount+=$res201amount;
    
    }
  
      $totalnetprofit=$grosscc-$totres201amount; 
     
     
     ?>
    <td   align="right" valign="center"  class="bodytext31"><?php echo number_format($totalnetprofit,2); ?></td>
     
     
     <?php } ?>
     
     
     
     </tr>
      <?php
    }
    ?>
  </table>
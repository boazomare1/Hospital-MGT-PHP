<?php

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="consumptionreport.xls"');
header('Cache-Control: max-age=80');

session_start();
include ("db/db_connect.php");
error_reporting(0);
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

if (isset($_REQUEST["wardcode1"])) { $wardcode = $_REQUEST["wardcode1"]; } else { $wardcode = ""; }

if (isset($_REQUEST["locationcode"])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }

if (isset($_REQUEST["store"])) { $storecode = $_REQUEST["store"]; } else { $storecode = "store"; }

if (isset($_REQUEST["typecode"])) { $typecode = $_REQUEST["typecode"]; } else { $typecode = "typecode"; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

?>

<?php
    if($typecode == 2){
  ?>
  <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="1400" align="left" border="1">
  <tbody>
    </tr>
    <tr>
          <th width="2%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="center"><strong>Sno.</strong></div></th>
          <th width="6%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Doc No.</strong></div></th>
          <th width="6%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Date</strong></div></th>
          <th width="8%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Storename</strong></div></th>
          <th width="10%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Billnumber</strong></div></th>
          <th width="10%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Patientname</strong></div></th>
          <th width="7%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Patientcode</strong></div></th>
          <th width="7%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Visitcode</strong></div></th>
          <th width="7%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Description</strong></div></th>
          <th width="7%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Itemcode</strong></div></th>
          <th width="10%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Itemname</strong></div></th>
          <th width="7%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Quantity</strong></div></th>
          <th width="7%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Cost Of Sales</strong></div></th>
          <th width="10%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Self Consumption</strong></div></th>
          <th width="5%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Total</strong></div></th>
          <th width="5%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Sale Value</strong></div></th>
          <th width="5%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Profit</strong></div></th>
          <th width="5%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Profit %</strong></div></th>
          <th width="5%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Username</strong></div></th>
        </tr>
        <?php
        $costofsales = $totalcostofsales = $selfconsumption = $totalselfconsumption = $total = $sumtotal = $salevalue = $totalsalevalue = $profit = $profitpercentage = $totalprofit = $totalprofitpercentage = 0;
        $visitcodes = [];

        $query40 = "SELECT distinct(visitcode) FROM `billing_paynow` where billdate between '$ADate1' and '$ADate2' group by visitcode UNION ALL SELECT distinct(visitcode) FROM `billing_paylater` where billdate between '$ADate1' and '$ADate2' group by visitcode";
        $exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($res40 = mysqli_fetch_array($exec40)){
          $opcode = $res40['visitcode'];
          array_push($visitcodes, $opcode);
        }

        $query41 = "SELECT distinct(visitcode) FROM `billing_ip` where billdate between '$ADate1' and '$ADate2' group by visitcode UNION ALL SELECT distinct(visitcode) FROM `billing_ipcreditapproved` where billdate between '$ADate1' and '$ADate2' group by visitcode";
        $exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die("Error in Query41".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($res41 = mysqli_fetch_array($exec41)){
          $ipcode = $res41['visitcode'];
          array_push($visitcodes, $ipcode);
        }

          if($storecode != ''){
            $query1 = "select * from master_store where storecode='$storecode' and locationcode = '$locationcode'";
          } else {
            $query1 = "select * from master_store where locationcode = '$locationcode'";
          }
          $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
          while($res1 = mysqli_fetch_array($exec1)){
          $storename = $res1['store'];
          $storename = strtoupper($storename);
          $storecode = $res1['storecode'];  
          
          $costofsales = $selfconsumption = $total = $salevalue = $profit = $profitpercentage = 0;
              $query2 = "SELECT a.docno as docno, a.fromstore as storecode, a.transferquantity as quantity, a.itemcode as itemcode, a.itemname as itemname, a.categoryname as categoryname, amount as consumption, a.entrydate as entrydate, a.username as username from master_stock_transfer as a where a.entrydate between '$ADate1' and '$ADate2' and a.fromstore = '$storecode' and a.typetransfer = 'Consumable' and a.locationcode = '$locationcode'";
              $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
              while($res2 = mysqli_fetch_array($exec2)){
                  $itemname = $res2['itemname'];
                  $itemcode = $res2['itemcode'];
                  $categoryname = $res2['categoryname'];
                  $entrydate = $res2['entrydate'];
                  $docno = $res2['docno'];
                  $selfconsumption = $res2['consumption'];
                  $username = $res2['username'];
                  $quantity = $res2['quantity'];
                  $totalselfconsumption += $selfconsumption;
                  $description = 'Consumable';
                  $patientcode = '';
                  $visitcode = '';
                  $patientname = '';
                  $billnumber = '';

                  $total = $costofsales + $selfconsumption;

                  $totalcostofsales += $costofsales;
                  $totalsalevalue += $salevalue;
                  $sumtotal += $total;

                  $profit = $salevalue - $total;
                  $totalprofit += $profit;

                  if($total != 0 && $profit != 0){
                    $profitpercentage = ($profit / $total)*100;
                  } else {
                    $profitpercentage = 0;
                  }

                  $snocount = $snocount + 1;
                
                  $colorloopcount = $colorloopcount + 1;
                  $showcolor = ($colorloopcount & 1); 
                  if ($showcolor == 0)
                  {
                    $colorcode = 'bgcolor="#ffffff"';
                  }
                  else
                  {
                    $colorcode = 'bgcolor="#ffffff"';
                  }
              ?>
              <tr <?php echo $colorcode; ?>>
                  <td class="bodytext31" valign="center" align="center"><?php echo $snocount; ?></td>
                  <td class="bodytext31" valign="center" align="left"><?php echo $docno; ?></td>
                  <td class="bodytext31" valign="center" align="left"><?php echo $entrydate; ?></td>
                  <td class="bodytext31" valign="center" align="left"><?php echo $storename; ?></td>
                  <td class="bodytext31" valign="center" align="left"><?php echo $billnumber; ?></td>
                  <td class="bodytext31" valign="center" align="left"><?php echo $patientname; ?></td>
                  <td class="bodytext31" valign="center" align="left"><?php echo $patientcode; ?></td>
                  <td class="bodytext31" valign="center" align="left"><?php echo $visitcode; ?></td>
                  <td class="bodytext31" valign="center" align="left"><?php echo $description; ?></td>
                  <td class="bodytext31" valign="center" align="left"><?php echo $itemcode; ?></td>
                  <td class="bodytext31" valign="center" align="left"><?php echo $itemname; ?></td>
                  <td class="bodytext31" valign="center" align="right"><?php echo number_format($quantity); ?></td>
                  <td class="bodytext31" valign="center" align="right"><?php echo number_format($costofsales,2); ?></td>
                  <td class="bodytext31" valign="center" align="right"><?php echo number_format($selfconsumption,2); ?></td>
                  <td class="bodytext31" valign="center" align="right"><?php echo number_format($total,2); ?></td>
                  <td class="bodytext31" valign="center" align="right"><?php echo number_format($salevalue,2); ?></td>
                  <td class="bodytext31" valign="center" align="right"><?php echo number_format($profit,2); ?></td>
                  <td class="bodytext31" valign="center" align="right"><?php echo number_format($profitpercentage,2)."%"; ?></td>
                  <td class="bodytext31" valign="center" align="right"><?php echo $username; ?></td>
              </tr>
            <?php } ?>
            <?php 
            $visitcodes1 = implode("','" ,$visitcodes);
            $costofsales = $selfconsumption = $total = $salevalue = $profit = $profitpercentage = 0;   
            $query2 = "SELECT (IF(a.ipdocno = '', a.docnumber, a.ipdocno)) as docno, a.patientcode as patientcode, a.patientname as patientname, a.visitcode as visitcode, a.store as storecode, a.itemcode as itemcode, a.billnumber as billnumber, a.quantity as quantity, a.itemname as itemname, a.categoryname as categoryname, a.totalcp as costprice, a.totalamount as saleprice, a.entrydate as entrydate, a.username as username from pharmacysales_details as a where a.visitcode in ('$visitcodes1') and a.store = '$storecode' and a.locationcode = '$locationcode'";
            $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($res2 = mysqli_fetch_array($exec2)){
                  $itemname = $res2['itemname'];
                  $itemcode = $res2['itemcode'];
                  $categoryname = $res2['categoryname'];
                  $patientname = $res2['patientname'];
                  $patientcode = $res2['patientcode'];
                  $visitcode = $res2['visitcode'];
                  $entrydate = $res2['entrydate'];
                  $quantity = $res2['quantity'];
                  $docno = $res2['docno'];
                  $costofsales = $res2['costprice'];
                  $salevalue = $res2['saleprice'];
                  $username = $res2['username'];
                  $description = 'Pharmacy Sales';

                  $split_doc = substr($docno, 0, 2);
                  if($split_doc == 'OP'){
                    $query3 = "select billnumber from billing_paynowpharmacy where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";
                    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $numrows = mysqli_num_rows($exec3);
                    if($numrows == 0){
                      $query4 = "select billnumber from billing_paylaterpharmacy where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";
                      $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
                      $numrows = mysqli_num_rows($exec4);
                      $res4 = mysqli_fetch_array($exec4);
                      $billnumber = $res4['billnumber'];
                    } else {
                      $res3 = mysqli_fetch_array($exec3);
                      $billnumber = $res3['billnumber'];
                    }
                  } else {
                    $query3 = "select billnumber from billing_ippharmacy where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";
                    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $numrows = mysqli_num_rows($exec3);
                    $res3 = mysqli_fetch_array($exec3);
                    $billnumber = $res3['billnumber'];
                  }

                  $costofsales = $costofsales;  
                  $salevalue = $salevalue;  
                  $total = $costofsales + $selfconsumption;

                  $totalcostofsales += $costofsales;
                  $totalsalevalue += $salevalue;
                  $sumtotal += $total;

                  $profit = $salevalue - $total;
                  $totalprofit += $profit;

                  if($total != 0 && $profit != 0){
                    $profitpercentage = ($profit / $total)*100;
                  } else {
                    $profitpercentage = 0;
                  }

                  $snocount = $snocount + 1;
                
                  $colorloopcount = $colorloopcount + 1;
                  $showcolor = ($colorloopcount & 1); 
                  if ($showcolor == 0)
                  {
                    $colorcode = 'bgcolor="#ffffff"';
                  }
                  else
                  {
                    $colorcode = 'bgcolor="#ffffff"';
                  }
              ?>
              <tr <?php echo $colorcode; ?>>
                  <td class="bodytext31" valign="center" align="center"><?php echo $snocount; ?></td>
                  <td class="bodytext31" valign="center" align="left"><?php echo $docno; ?></td>
                  <td class="bodytext31" valign="center" align="left"><?php echo $entrydate; ?></td>
                  <td class="bodytext31" valign="center" align="left"><?php echo $storename; ?></td>
                  <td class="bodytext31" valign="center" align="left"><?php echo $billnumber; ?></td>
                  <td class="bodytext31" valign="center" align="left"><?php echo $patientname; ?></td>
                  <td class="bodytext31" valign="center" align="left"><?php echo $patientcode; ?></td>
                  <td class="bodytext31" valign="center" align="left"><?php echo $visitcode; ?></td>
                  <td class="bodytext31" valign="center" align="left"><?php echo $description; ?></td>
                  <td class="bodytext31" valign="center" align="left"><?php echo $itemcode; ?></td>
                  <td class="bodytext31" valign="center" align="left"><?php echo $itemname; ?></td>
                  <td class="bodytext31" valign="center" align="right"><?php echo number_format($quantity); ?></td>
                  <td class="bodytext31" valign="center" align="right"><?php echo number_format($costofsales,2); ?></td>
                  <td class="bodytext31" valign="center" align="right"><?php echo number_format($selfconsumption,2); ?></td>
                  <td class="bodytext31" valign="center" align="right"><?php echo number_format($total,2); ?></td>
                  <td class="bodytext31" valign="center" align="right"><?php echo number_format($salevalue,2); ?></td>
                  <td class="bodytext31" valign="center" align="right"><?php echo number_format($profit,2); ?></td>
                  <td class="bodytext31" valign="center" align="right"><?php echo number_format($profitpercentage,2)."%"; ?></td>
                  <td class="bodytext31" valign="center" align="right"><?php echo $username; ?></td>
              </tr>
            <?php } ?>
            <?php
            $costofsales = $selfconsumption = $total = $salevalue = $profit = $profitpercentage = 0;
            $query3 = "SELECT a.docnumber as docno, a.store as storecode, a.itemcode as itemcode, a.itemname as itemname, a.patientcode as patientcode,  a.visitcode as visitcode, a.categoryname as categoryname, a.quantity as quantity, a.billnumber as billnumber, (-1*a.totalcp) as costprice, (-1*a.totalamount) as saleprice, a.entrydate as entrydate, a.username as username from pharmacysalesreturn_details as a where a.visitcode in ('$visitcodes1') and a.store = '$storecode' and a.locationcode = '$locationcode'";
              $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
              while($res3 = mysqli_fetch_array($exec3)){
                    $itemname = $res3['itemname'];
                    $itemcode = $res3['itemcode'];
                    $categoryname = $res3['categoryname'];
                    $entrydate = $res3['entrydate'];
                    $patientcode = $res3['patientcode'];
                    $visitcode = $res3['visitcode'];
                    $docno = $res3['docno'];
                    $quantity = $res3['quantity'];
                    $costofsales = $res3['costprice'];
                    $salevalue = $res3['saleprice'];
                    $username = $res3['username'];
                    $billnumber = $res3['billnumber'];
                    $description = 'Pharmacy Sales Returns';

                    $query4 = "select patientname from pharmacysales_details where patientcode = '$patientcode' and visitcode = '$visitcode'";
                    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $res4 = mysqli_fetch_array($exec4);
                    $patientname = $res4['patientname'];

                    $costofsales = $costofsales;  
                    $salevalue = $salevalue; 
                    $total = $costofsales + $selfconsumption; 

                    $totalcostofsales += $costofsales;
                    $totalsalevalue += $salevalue;
                    $sumtotal += $total;

                    $profit = $salevalue - $total;
                    $totalprofit += $profit;

                    if($total != 0 && $profit != 0){
                      $profitpercentage = ($profit / $total)*100;
                    } else {
                      $profitpercentage = 0;
                    }

                    $snocount = $snocount + 1;
                
                    $colorloopcount = $colorloopcount + 1;
                    $showcolor = ($colorloopcount & 1); 
                    if ($showcolor == 0)
                    {
                      $colorcode = 'bgcolor="#ffffff"';
                    }
                    else
                    {
                      $colorcode = 'bgcolor="#ffffff"';
                    } 
              ?>
                    <tr <?php echo $colorcode; ?>>
                      <td class="bodytext31" valign="center" align="center"><?php echo $snocount; ?></td>
                      <td class="bodytext31" valign="center" align="left"><?php echo $docno; ?></td>
                      <td class="bodytext31" valign="center" align="left"><?php echo $entrydate; ?></td>
                      <td class="bodytext31" valign="center" align="left"><?php echo $storename; ?></td>
                      <td class="bodytext31" valign="center" align="left"><?php echo $billnumber; ?></td>
                      <td class="bodytext31" valign="center" align="left"><?php echo $patientname; ?></td>
                      <td class="bodytext31" valign="center" align="left"><?php echo $patientcode; ?></td>
                      <td class="bodytext31" valign="center" align="left"><?php echo $visitcode; ?></td>
                      <td class="bodytext31" valign="center" align="left"><?php echo $description; ?></td>
                      <td class="bodytext31" valign="center" align="left"><?php echo $itemcode; ?></td>
                      <td class="bodytext31" valign="center" align="left"><?php echo $itemname; ?></td>
                      <td class="bodytext31" valign="center" align="right"><?php echo number_format($quantity); ?></td>
                      <td class="bodytext31" valign="center" align="right"><?php echo number_format($costofsales,2); ?></td>
                      <td class="bodytext31" valign="center" align="right"><?php echo number_format($selfconsumption,2); ?></td>
                      <td class="bodytext31" valign="center" align="right"><?php echo number_format($total,2); ?></td>
                      <td class="bodytext31" valign="center" align="right"><?php echo number_format($salevalue,2); ?></td>
                      <td class="bodytext31" valign="center" align="right"><?php echo number_format($profit,2); ?></td>
                      <td class="bodytext31" valign="center" align="right"><?php echo number_format($profitpercentage,2)."%"; ?></td>
                  <td class="bodytext31" valign="center" align="right"><?php echo $username; ?></td>
                  </tr>
                  <?php } ?>
                  <?php 
                    if($sumtotal != 0 && $totalprofit != 0){
                      $totalprofitpercentage = ($totalprofit / $sumtotal)*100;
                    } else {
                      $totalprofitpercentage = 0;
                    }
                  ?>
            <?php } ?>
            <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right" colspan="12"><strong>TOTAL</strong></td>
            <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right"><strong><?php echo number_format($totalcostofsales,2); ?></strong></td>
            <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right"><strong><?php echo number_format($totalselfconsumption,2); ?></strong></td>
            <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right"><strong><?php echo number_format($sumtotal,2); ?></strong></td>
            <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right"><strong><?php echo number_format($totalsalevalue,2); ?></strong></td>
            <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right"><strong><?php echo number_format($totalprofit,2); ?></strong></td>
            <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right"><strong><?php echo number_format($totalprofitpercentage,2)."%"; ?></strong></td>
            <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right"><strong>&nbsp;</strong></td>
        </tr>
      </tbody>
    </table></td>
  <?php } else { ?>
    <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" align="left" border="1">
      <tbody>
    <tr>
      <td width="2%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="center"><strong>Sno.</strong></div></td>
      <td width="6%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Storename</strong></div></td>
      <td width="6%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Cost of Sales</strong></div></td>
      <td width="6%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Self Consumption</strong></div></td>
      <td width="6%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Total</strong></div></td>
      <td width="6%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Sale Value</strong></div></td>
      <td width="6%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Profit</strong></div></td>
      <td width="6%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Profit %</strong></div></td>
    </tr>
    <?php
    $costofsales = $totalcostofsales = $selfconsumption = $totalselfconsumption = $total = $sumtotal = $salevalue = $totalsalevalue = $profit = $profitpercentage = $totalprofit = $totalprofitpercentage = 0;

      if($storecode != ''){
        $query1 = "select * from master_store where storecode='$storecode' and locationcode = '$locationcode'";
      } else {
        $query1 = "select * from master_store where locationcode = '$locationcode'";
      }
      $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
      while($res1 = mysqli_fetch_array($exec1)){
      $storename = $res1['store'];
      $storename = strtoupper($storename);
      $storecode = $res1['storecode'];  


      $costofsales = $selfconsumption = $total = $salevalue = $profit = $profitpercentage = 0;
      $query2 = "SELECT a.docno as docno, a.fromstore as storecode, a.itemcode as itemcode, a.itemname as itemname, a.categoryname as categoryname, sum(amount) as consumption, a.entrydate as entrydate from master_stock_transfer as a where a.entrydate between '$ADate1' and '$ADate2' and a.fromstore = '$storecode' and a.typetransfer = 'Consumable' and a.locationcode = '$locationcode' group by a.fromstore";
      $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
      $res2 = mysqli_fetch_array($exec2);
      $selfconsumption = $res2['consumption'];
      $totalselfconsumption += $selfconsumption;

      $query3 = "SELECT (IF(a.ipdocno = '', a.docnumber, a.ipdocno)) as docno, a.patientcode as patientcode, a.patientname as patientname, a.visitcode as visitcode, a.store as storecode, a.itemcode as itemcode, a.itemname as itemname, a.categoryname as categoryname, sum(a.totalcp) as costprice, sum(a.totalamount) as saleprice, a.entrydate as entrydate from pharmacysales_details as a where a.entrydate between '$ADate1' and '$ADate2' and a.store = '$storecode' and a.locationcode = '$locationcode' group by a.store";
      $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
      $res3 = mysqli_fetch_array($exec3);
      $costofsales += $res3['costprice'];
      $salevalue += $res3['saleprice'];
      $total = $costofsales + $selfconsumption;

      $query4 = "SELECT a.docnumber as docno, a.store as storecode, a.itemcode as itemcode, a.itemname as itemname, a.patientcode as patientcode,  a.visitcode as visitcode, a.categoryname as categoryname, sum(-1*a.totalcp) as costprice, sum(-1*a.totalamount) as saleprice, a.entrydate as entrydate from pharmacysalesreturn_details as a where a.entrydate between '$ADate1' and '$ADate2' and a.store = '$storecode' and a.locationcode = '$locationcode' group by a.store";
      $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
      $res4 = mysqli_fetch_array($exec4);
      $costofsales += $res4['costprice'];
      $salevalue += $res4['saleprice'];

      $totalcostofsales += $costofsales;
      $totalsalevalue += $salevalue;
      $total = $costofsales + $selfconsumption;
      $sumtotal += $total;

      $profit = $salevalue - $total;
      $totalprofit += $profit;
      
      if($profit != 0 && $total != 0){
        $profitpercentage = ($profit / $total) * 100;
      } else {
        $profitpercentage = 0;
      }

        $snocount = $snocount + 1;
      
        $colorloopcount = $colorloopcount + 1;
        $showcolor = ($colorloopcount & 1); 
        if ($showcolor == 0)
        {
          $colorcode = 'bgcolor="#ffffff"';
        }
        else
        {
          $colorcode = 'bgcolor="#ffffff"';
        }
    ?>

    <tr <?php echo $colorcode; ?>>
        <td class="bodytext31" valign="center" align="center"><?php echo $snocount; ?></td>
        <td class="bodytext31" valign="center" align="left"><?php echo $storename; ?></td>
        <td class="bodytext31" valign="center" align="right"><?php echo number_format($costofsales,2); ?></td>
        <td class="bodytext31" valign="center" align="right"><?php echo number_format($selfconsumption,2); ?></td>
        <td class="bodytext31" valign="center" align="right"><?php echo number_format($total,2); ?></td>
        <td class="bodytext31" valign="center" align="right"><?php echo number_format($salevalue,2); ?></td>
        <td class="bodytext31" valign="center" align="right"><?php echo number_format($profit,2); ?></td>
        <td class="bodytext31" valign="center" align="right"><?php echo number_format($profitpercentage,2)."%"; ?></td>
    </tr>
  <?php } ?>
  <?php 

    if($totalprofit != 0 && $sumtotal != 0){
      $totalprofitpercentage = ($totalprofit / $sumtotal) * 100;
    } else {
      $totalprofitpercentage = 0;
    }

  ?>
  <tr>
      <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right" colspan="2"><strong>TOTAL</strong></td>
      <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right"><strong><?php echo number_format($totalcostofsales,2); ?></strong></td>
      <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right"><strong><?php echo number_format($totalselfconsumption,2); ?></strong></td>
      <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right"><strong><?php echo number_format($sumtotal,2); ?></strong></td>
      <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right"><strong><?php echo number_format($totalsalevalue,2); ?></strong></td>
      <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right"><strong><?php echo number_format($totalprofit,2); ?></strong></td>
      <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right"><strong><?php echo number_format($totalprofitpercentage,2)."%"; ?></strong></td>
  </tr>
  <?php } ?>
  </tr>
</table>
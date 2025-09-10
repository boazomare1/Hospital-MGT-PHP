<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Sales_CollectionReport.xls"');
header('Cache-Control: max-age=80');

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


if(isset($_REQUEST['locationcode'])){ $locationcode = $_REQUEST['locationcode']; } else { $locationcode = ''; }
if(isset($_REQUEST['year'])){ $from_year = $_REQUEST['year']; } else { $from_year = ''; }
if(isset($_REQUEST['month'])){ $from_month = $_REQUEST['month']; } else { $from_month = ''; }
if(isset($_REQUEST['as_per'])){ $as_per = $_REQUEST['as_per']; } else { $as_per = ''; }


?>

<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" align="left" border="1">
	<tbody>
      <tr>
        <td bgcolor="#ecf0f5" colspan="28" class="bodytext31" align="center"><strong>SALES VS COLLECTION REPORT</strong></td>
      </tr>
      <?php
        $year_start = date('Y-m-d', strtotime('first day of january'.date($from_year)));
        $year_end = date('Y-m-d', strtotime('last day of '.date($from_year.'-'.$from_month)));
      ?>
      <tr>
        <td bgcolor="#ecf0f5" colspan="28" class="bodytext31" align="center"><strong>REPORT FROM <?php echo $year_start.' TO '.$year_end; ?></strong></td>
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
        <td bgcolor="#ecf0f5" colspan="2" class="bodytext31" align="center"><strong><?php echo $month; ?></strong></td>
      <?php } ?>
      <td bgcolor="#ecf0f5" colspan="2" class="bodytext31" align="center"><strong><?php echo $s_name.' To '.$e_name; ?></strong></td>
      </tr>
      <tr>
        <td bgcolor="#ecf0f5" class="bodytext31" align="center"><strong>Sno.</strong></td>
        <td bgcolor="#ecf0f5" class="bodytext31" align="center"><strong>ACCOUNT</strong></td>
        <?php 
          for($i = 0; $i < $from_month; $i++){
        ?>
        <td bgcolor="#ecf0f5" class="bodytext31" align="right"><strong>REVENUE</strong></td>
        <td bgcolor="#ecf0f5" class="bodytext31" align="right"><strong>COLLECTION</strong></td>
        <?php } ?>
        <td bgcolor="#ecf0f5" class="bodytext31" align="right"><strong>TOTAL REVENUE</strong></td>
        <td bgcolor="#ecf0f5" class="bodytext31" align="right"><strong>TOTAL COLLECTION</strong></td>
      </tr>
        <?php
		  if($as_per=='Allocated') {
            $query1 = "select * from master_subtype where recordstatus <> 'deleted' and auto_number != '1'";
            $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1").mysqli_error($GLOBALS["___mysqli_ston"]);
            while($res1 = mysqli_fetch_array($exec1)){
			  $collection=0;
              $subtypename = $res1['subtype'];
              $subtypeano = $res1['auto_number'];

              $snocount = $snocount + 1;
              $colorloopcount = $colorloopcount + 1;
              $showcolor = ($colorloopcount & 1); 
              if ($showcolor == 0)
              {
                //echo "if";
                $colorcode = 'bgcolor="#ffffff"';
              }
              else
              {
                //echo "else";
                $colorcode = 'bgcolor="#ffffff"';
              }
          ?>
          <tr <?php echo $colorcode; ?>>
            <td class="bodytext31" valign="center" align="center"><?php echo $snocount; ?></td> 
            <td class="bodytext31" valign="center" align="left"><?php echo $subtypename; ?></td>
            <?php
              $subtypecollection = 0;
              $subtyperevenue = 0;
              $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            
              for($i = 0; $i < $from_month; $i++){
                $month = $months[$i];
                $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
                $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));

                $query2 = "select accountname, sum(revenue) as revenue from (
                  SELECT sum(billing_ip.totalrevenue) as revenue, master_accountname.id, master_subtype.subtype as accountname FROM `billing_ip` JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ip.billdate between '$start_month' and '$end_month' and master_subtype.auto_number = '$subtypeano'   group by master_subtype.auto_number
                  UNION ALL 
                  SELECT sum(billing_ipcreditapproved.totalrevenue) as revenue, master_accountname.id, master_subtype.subtype as accountname FROM `billing_ipcreditapproved` JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipcreditapproved.billdate between '$start_month' and '$end_month' and master_subtype.auto_number = '$subtypeano'   group by master_subtype.auto_number
                  UNION ALL
                  SELECT sum(billing_paylater.totalamount) as revenue, master_accountname.id, master_subtype.subtype as accountname FROM `billing_paylater` JOIN master_accountname ON billing_paylater.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_paylater.billdate between '$start_month' and '$end_month' and master_subtype.auto_number = '$subtypeano'   group by master_subtype.auto_number
                  ) as rev group by accountname order by accountname";
                $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query2").mysqli_error($GLOBALS["___mysqli_ston"]);
                $res2 = mysqli_fetch_array($exec2);
                $revenue = $res2['revenue'];
                $subtyperevenue += $revenue;

                  $query3 = "select sum(a.transactionamount) as collection from master_transactionpaylater as a JOIN master_subtype as b ON a.subtype = b.subtype where  a.bill_date between '$start_month' and '$end_month' and a.transactiontype = 'PAYMENT' and b.auto_number = '$subtypeano' and a.paylaterdocno='' and docno!='' and a.recordstatus='allocated' group by b.auto_number ";
                $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res3 = mysqli_fetch_array($exec3);
                $collection = $res3['collection'];
                $subtypecollection += $collection;

            ?>
            <td class="bodytext31" valign="center" align="right"><?php echo number_format($revenue,2); ?></td>
            <td class="bodytext31" valign="center" align="right"><?php echo number_format($collection,2); ?></td>
            <?php } ?>
            <td class="bodytext31" valign="center" align="right"><?php echo number_format($subtyperevenue,2); ?></td>
            <td class="bodytext31" valign="center" align="right"><?php echo number_format($subtypecollection,2); ?></td>
          <?php } ?>
          </tr>
          <tr>
            <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5" colspan="2"><strong>TOTAL: </strong></td>
          <?php 
              $yearlyrevenue = $yearlycollection = 0;
              $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            
              for($i = 0; $i < $from_month; $i++){
                $month = $months[$i];
                $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
                $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));

                $query2 = "select accountname, sum(revenue) as revenue from (
                  SELECT sum(billing_ip.totalrevenue) as revenue, master_accountname.id, master_subtype.subtype as accountname FROM `billing_ip` JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE master_subtype.auto_number!='1' and billing_ip.billdate between '$start_month' and '$end_month'   
                  UNION ALL 
                  SELECT sum(billing_ipcreditapproved.totalrevenue) as revenue, master_accountname.id, master_subtype.subtype as accountname FROM `billing_ipcreditapproved` JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE  master_subtype.auto_number!='1' and  billing_ipcreditapproved.billdate between '$start_month' and '$end_month'  
                  UNION ALL
                  SELECT sum(billing_paylater.totalamount) as revenue, master_accountname.id, master_subtype.subtype as accountname FROM `billing_paylater` JOIN master_accountname ON billing_paylater.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE master_subtype.auto_number!='1' and billing_paylater.billdate between '$start_month' and '$end_month'  
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
          ?>
            <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right"><strong><?php echo number_format($totalrevenue,2); ?></strong></td>
            <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right"><strong><?php echo number_format($totalcollection,2); ?></strong></td>
          <?php } ?>
          <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right"><strong><?php echo number_format($yearlyrevenue,2); ?></strong></td>
          <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right"><strong><?php echo number_format($yearlycollection,2); ?></strong></td>
          </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
    <?php } else {
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
                $colorcode = 'bgcolor="#ffffff"';
              }
              else
              {
                //echo "else";
                $colorcode = 'bgcolor="#ffffff"';
              }
          ?>
          <tr <?php echo $colorcode; ?>>
            <td class="bodytext31" valign="center" align="center"><?php echo $snocount; ?></td> 
            <td class="bodytext31" valign="center" align="left"><?php echo $subtypename; ?></td>
            <?php
              $subtypecollection = 0;
              $subtyperevenue = 0;
              $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            
              for($i = 0; $i < $from_month; $i++){
                $month = $months[$i];
                $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
                $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));

                $query2 = "select accountname, sum(revenue) as revenue from (
                  SELECT sum(billing_ip.totalrevenue) as revenue, master_accountname.id, master_subtype.subtype as accountname FROM `billing_ip` JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ip.billdate between '$start_month' and '$end_month' and master_subtype.auto_number = '$subtypeano'   group by master_subtype.auto_number
                  UNION ALL 
                  SELECT sum(billing_ipcreditapproved.totalrevenue) as revenue, master_accountname.id, master_subtype.subtype as accountname FROM `billing_ipcreditapproved` JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipcreditapproved.billdate between '$start_month' and '$end_month' and master_subtype.auto_number = '$subtypeano'   group by master_subtype.auto_number
                  UNION ALL
                  SELECT sum(billing_paylater.totalamount) as revenue, master_accountname.id, master_subtype.subtype as accountname FROM `billing_paylater` JOIN master_accountname ON billing_paylater.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_paylater.billdate between '$start_month' and '$end_month' and master_subtype.auto_number = '$subtypeano'   group by master_subtype.auto_number
                  ) as rev group by accountname order by accountname";
                $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query2").mysqli_error($GLOBALS["___mysqli_ston"]);
                $res2 = mysqli_fetch_array($exec2);
                $revenue = $res2['revenue'];
                $subtyperevenue += $revenue;

                 $query3 = "select sum(a.transactionamount) as collection from master_transactionpaylater as a JOIN master_subtype as b ON a.subtype = b.subtype where a.docno LIKE 'AR-%' and a.transactiondate between '$start_month' and '$end_month' and a.transactionmodule = 'PAYMENT' and b.auto_number = '$subtypeano' group by b.auto_number ";
                $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res3 = mysqli_fetch_array($exec3);
                $collection = $res3['collection'];
                $subtypecollection += $collection;

            ?>
            <td class="bodytext31" valign="center" align="right"><?php echo number_format($revenue,2); ?></td>
            <td class="bodytext31" valign="center" align="right"><?php echo number_format($collection,2); ?></td>
            <?php } ?>
            <td class="bodytext31" valign="center" align="right"><?php echo number_format($subtyperevenue,2); ?></td>
            <td class="bodytext31" valign="center" align="right"><?php echo number_format($subtypecollection,2); ?></td>
          <?php } ?>
          </tr>
          <tr>
            <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5" colspan="2"><strong>TOTAL: </strong></td>
          <?php 
              $yearlyrevenue = $yearlycollection = 0;
              $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            
              for($i = 0; $i < $from_month; $i++){
                $month = $months[$i];
                $start_month = date('Y-m-d', strtotime('first day of'.$from_year.'-'.$month));
                $end_month = date('Y-m-d', strtotime('last day of'.$from_year.'-'.$month));

                $query2 = "select accountname, sum(revenue) as revenue from (
                  SELECT sum(billing_ip.totalrevenue) as revenue, master_accountname.id, master_subtype.subtype as accountname FROM `billing_ip` JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE master_subtype.auto_number!='1' and billing_ip.billdate between '$start_month' and '$end_month'   
                  UNION ALL 
                  SELECT sum(billing_ipcreditapproved.totalrevenue) as revenue, master_accountname.id, master_subtype.subtype as accountname FROM `billing_ipcreditapproved` JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE  master_subtype.auto_number!='1' and  billing_ipcreditapproved.billdate between '$start_month' and '$end_month'  
                  UNION ALL
                  SELECT sum(billing_paylater.totalamount) as revenue, master_accountname.id, master_subtype.subtype as accountname FROM `billing_paylater` JOIN master_accountname ON billing_paylater.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE master_subtype.auto_number!='1' and billing_paylater.billdate between '$start_month' and '$end_month'  
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
          ?>
            <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right"><strong><?php echo number_format($totalrevenue,2); ?></strong></td>
            <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right"><strong><?php echo number_format($totalcollection,2); ?></strong></td>
          <?php } ?>
          <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right"><strong><?php echo number_format($yearlyrevenue,2); ?></strong></td>
          <td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right"><strong><?php echo number_format($yearlycollection,2); ?></strong></td>
          </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
    <?php } ?>
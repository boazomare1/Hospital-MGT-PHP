<?php



if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

if (isset($_REQUEST["locationcode1"])) { $locationcode1 = $_REQUEST["locationcode1"]; } else { $locationcode1 = ""; }



header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="debtorsreport['.$ADate1.' - '.$ADate2.'].xls"');

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





?>



<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="600" align="left" border="1">

	<tbody>
    <tr>
       <td colspan="6" align="center" valign="center" class="bodytext31"><div align="center"><strong>Debtors Sales Report (<?=$ADate1;?> To <?=$ADate2;?>)</strong></div></td>
    </tr>

  		<tr>

          <td width="5%" align="left" valign="center"  

            bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>SNO.</strong></div></td>

            <td width="30%" align="left" valign="center"  

            bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>ACCOUNTNAME</strong></div></td>

            <td width="15%" align="left" valign="center"  

            bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>MIS TYPE</strong></div></td>

          <td width="15%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>OP REVENUE</strong></div></td>
          <td width="15%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>IP REVENUE</strong></div></td>
          <td width="15%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Doc. Share</strong></div></td>
        </tr>

          

        <?php

           $revenue = $totalrevenue = 0.00;
            $oprevenue = $optotalrevenue = 0.00;
            $doc_share_amount = $total_doc_share_amount = 0.00;

            $acountname = '';
			
			if($locationcode1=='All')
				{
				$pass_location = "locationcode !=''";
				}
				else
				{
				$pass_location = "locationcode ='$locationcode1'";
				}

              $query1 = "SELECT accountname, sum(revenue) as revenue, miscode, sum(oprev) as oprev, sum(doc_share) as doc_share, sum(doc_share_org) as doc_share_org, sum(pvt_bill1) as pvt_bill1   from (

                  SELECT '0'  as pvt_bill1, '0' as doc_share_org, '0' as doc_share, '0' as oprev, sum(billing_ip.totalrevenue) as revenue, master_accountname.id, master_subtype.subtype as accountname, master_accountname.misreport as miscode FROM `billing_ip` JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ip.billdate between '$ADate1' and '$ADate2' and master_accountname.id != '02-4500-1' and billing_ip.$pass_location group by master_subtype.auto_number

                  UNION ALL SELECT '0'  as pvt_bill1, '0' as doc_share_org, '0' as doc_share, '0' as oprev, sum(billing_ipcreditapproved.totalrevenue) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ipcreditapproved` JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipcreditapproved.billdate between '$ADate1' and '$ADate2' and master_accountname.id != '02-4500-1' and billing_ipcreditapproved.$pass_location group by master_subtype.auto_number

                  -- PRIVATE DOC BILLING CALCULATIONS
                  UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((-1)*billing_ipprivatedoctor.transactionamount) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ip` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ip.billno  JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number  WHERE  billing_ip.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ip.accountnameano!='603' and billing_ipprivatedoctor.recorddate  between '$ADate1' and '$ADate2' and billing_ip.$pass_location group by master_subtype.auto_number


                   UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((-1)*billing_ipprivatedoctor.transactionamount) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ipcreditapproved` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ipcreditapproved.billno  JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipcreditapproved.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ipcreditapproved.accountnameano!='603' and billing_ipprivatedoctor.recorddate  between '$ADate1' and '$ADate2' and billing_ipcreditapproved.$pass_location group by master_subtype.auto_number

                    -- 1 start
                   UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((1)*billing_ipprivatedoctor.transactionamount) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ip` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ip.billno  JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number  WHERE  billing_ip.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ip.accountnameano!='603' AND billing_ipprivatedoctor.visittype='IP' and billing_ipprivatedoctor.coa!='' and billing_ipprivatedoctor.recorddate  between '$ADate1' and '$ADate2' and billing_ip.$pass_location group by master_subtype.auto_number


                   UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((1)*billing_ipprivatedoctor.transactionamount) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ipcreditapproved` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ipcreditapproved.billno  JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipcreditapproved.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ipcreditapproved.accountnameano!='603' AND billing_ipprivatedoctor.visittype='IP' and billing_ipprivatedoctor.coa!='' and billing_ipprivatedoctor.recorddate  between '$ADate1' and '$ADate2' and billing_ipcreditapproved.$pass_location group by master_subtype.auto_number

                  -- 2 one

                  UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((1)*billing_ipprivatedoctor.original_amt) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ip` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ip.billno  JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number  WHERE  billing_ip.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ip.accountnameano!='603' AND billing_ipprivatedoctor.visittype='IP'  and billing_ipprivatedoctor.coa='' and billing_ipprivatedoctor.recorddate  between '$ADate1' and '$ADate2' and billing_ip.$pass_location group by master_subtype.auto_number


                   UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((1)*billing_ipprivatedoctor.original_amt) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ipcreditapproved` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ipcreditapproved.billno  JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipcreditapproved.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ipcreditapproved.accountnameano!='603' AND billing_ipprivatedoctor.visittype='IP' and billing_ipprivatedoctor.coa='' and billing_ipprivatedoctor.recorddate  between '$ADate1' and '$ADate2' and billing_ipcreditapproved.$pass_location group by master_subtype.auto_number

                  -- 3 close

                  UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((1)*billing_ipprivatedoctor.transactionamount) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ip` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ip.billno  JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number  WHERE  billing_ip.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ip.accountnameano!='603' AND billing_ipprivatedoctor.visittype!='IP' and billing_ipprivatedoctor.recorddate  between '$ADate1' and '$ADate2' and billing_ip.$pass_location group by master_subtype.auto_number


                   UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((1)*billing_ipprivatedoctor.transactionamount) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ipcreditapproved` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ipcreditapproved.billno  JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipcreditapproved.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ipcreditapproved.accountnameano!='603' AND billing_ipprivatedoctor.visittype!='IP' and billing_ipprivatedoctor.recorddate  between '$ADate1' and '$ADate2' and billing_ipcreditapproved.$pass_location group by master_subtype.auto_number

                  -- PRIVATE DOC BILLING CALCULATIONS CLOSES

                   -- IP REBATE
                  UNION ALL SELECT '0'  as pvt_bill1, '0' as doc_share_org, '0' as doc_share, '0' as oprev, sum(billing_ipnhif.amount) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ipnhif` JOIN master_accountname ON billing_ipnhif.accountcode = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipnhif.recorddate between '$ADate1' and '$ADate2' and master_accountname.id != '02-4500-1' and billing_ipnhif.$pass_location group by master_subtype.auto_number

                  -- IP Discount 
                  UNION ALL 
                    SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((-1)*ip_discount.rate) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ip` JOIN ip_discount ON  ip_discount.patientvisitcode=billing_ip.visitcode  JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number  WHERE  billing_ip.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ip.accountnameano!='603' and ip_discount.consultationdate  between '$ADate1' and '$ADate2' and billing_ip.$pass_location group by master_subtype.auto_number


                   UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((-1)*ip_discount.rate) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ipcreditapproved` JOIN ip_discount ON  ip_discount.patientvisitcode=billing_ipcreditapproved.visitcode  JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipcreditapproved.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ipcreditapproved.accountnameano!='603' and ip_discount.consultationdate  between '$ADate1' and '$ADate2' and billing_ipcreditapproved.$pass_location group by master_subtype.auto_number
                 
                                  -- IP Close ============ OP Starts  
                  UNION ALL
                  SELECT '0'  as pvt_bill1, '0' as doc_share_org, '0' as doc_share, sum(billing_paylater.totalamount) as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_paylater` JOIN master_accountname ON billing_paylater.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_paylater.billdate between '$ADate1' and '$ADate2' and master_accountname.id != '02-4500-1' and billing_paylater.$pass_location group by master_subtype.auto_number

                   UNION ALL
                    -- paynow credits
                   SELECT '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, sum(billing_paynowpharmacy.fxamount) as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_paynowpharmacy` JOIN master_accountname ON billing_paynowpharmacy.accountname = master_accountname.accountname JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_paynowpharmacy.billdate between '$ADate1' and '$ADate2' and master_accountname.auto_number != '603' and billing_paynowpharmacy.$pass_location group by master_subtype.auto_number

                    UNION ALL
                    -- paynow credits
                    SELECT '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, sum(billing_consultation.consultation) as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_consultation` JOIN master_accountname ON billing_consultation.accountname = master_accountname.accountname JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_consultation.billdate between '$ADate1' and '$ADate2' and master_accountname.auto_number != '603' and billing_consultation.$pass_location group by master_subtype.auto_number

                                    -- ====== OP Ends and DOC SHARE STARTS ========

                    -- DOC SHARE IN SERVICES
                     UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, sum(billing_ipservices.sharingamount) as doc_share, '0' as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ip` JOIN billing_ipservices ON  billing_ipservices.patientvisitcode=billing_ip.visitcode  JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number  WHERE  billing_ip.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ip.accountnameano!='603' and billing_ip.$pass_location group by master_subtype.auto_number
                     
                     UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, sum(billing_ipservices.sharingamount) as doc_share, '0' as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ipcreditapproved` JOIN billing_ipservices ON  billing_ipservices.patientvisitcode=billing_ipcreditapproved.visitcode  JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number  WHERE  billing_ipcreditapproved.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ipcreditapproved.accountnameano!='603' and billing_ipcreditapproved.$pass_location group by master_subtype.auto_number
                     

                      -- DOC SHARE IN CREDIT CONSULTATION
                     UNION ALL SELECT '0'  as pvt_bill1,'0' as doc_share_org, sum(billing_consultation.sharingamount) as doc_share, '0' as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `master_visitentry` JOIN master_accountname ON master_visitentry.accountname = master_accountname.auto_number JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number join billing_consultation on billing_consultation.patientvisitcode=master_visitentry.visitcode WHERE billing_consultation.billdate between '$ADate1' and '$ADate2' and master_accountname.auto_number != '603' AND billing_consultation.accountname != 'CASH - HOSPITAL' and master_visitentry.$pass_location  group by master_subtype.auto_number

                     -- DOC SHARE IN billing_paylaterconsultation CONSULTATION
                     UNION ALL SELECT '0'  as pvt_bill1,'0' as doc_share_org, sum(billing_paylaterconsultation.sharingamount) as doc_share, '0' as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `master_visitentry` JOIN master_accountname ON master_visitentry.accountname = master_accountname.auto_number JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number join billing_paylaterconsultation on billing_paylaterconsultation.visitcode=master_visitentry.visitcode WHERE billing_paylaterconsultation.billdate between '$ADate1' and '$ADate2' and master_accountname.auto_number != '603' AND billing_paylaterconsultation.accountname != 'CASH - HOSPITAL' and master_visitentry.$pass_location group by master_subtype.auto_number
 
                      -- ip pvt doc share
                   UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, sum(billing_ipprivatedoctor.sharingamount) as doc_share, '0' as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ip` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ip.billno  JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number  WHERE  billing_ip.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ip.accountnameano!='603' and billing_ip.$pass_location group by master_subtype.auto_number


                   UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, sum(billing_ipprivatedoctor.sharingamount) as doc_share, '0' as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ipcreditapproved` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ipcreditapproved.billno  JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipcreditapproved.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ipcreditapproved.accountnameano!='603' and billing_ipcreditapproved.$pass_location group by master_subtype.auto_number

                  ) as rev group by accountname order by accountname";

              $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
              while($res1 = mysqli_fetch_array($exec1)){

                 $accountname = $res1['accountname'];
                  $revenue = $res1['revenue'];
                  $oprevenue = $res1['oprev'];
                  $doc_share_amount = $res1['doc_share'];
                  $doc_share_org_amount = 0;

                  $account_doc_share=$doc_share_amount+$doc_share_org_amount;

                  $miscode = $res1['miscode'];


                  $totalrevenue += $revenue;
                  $optotalrevenue += $oprevenue;
                  $total_doc_share_amount += $account_doc_share;
                  // $total_doc_share_amount += $doc_share_amount;

                  $query2 = "select * from mis_types where auto_number = '$miscode'";
                  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query2" . mysqli_error($GLOBALS["___mysqli_ston"]));
                  $res2 = mysqli_fetch_array($exec2);
                  $mistype = $res2['type'];
                  $snocount = $snocount + 1;

                  //echo $cashamount;
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

                <tr>
                  <td class="bodytext31" valign="center"  align="center"><?php echo $snocount; ?></td>
                  <td class="bodytext31" valign="center"  align="left"><?php echo $accountname; ?></td>
                  <td class="bodytext31" valign="center"  align="left"><?php echo $mistype; ?></td>
                  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($oprevenue,2); ?></td>
                  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($revenue,2); ?></td>
                  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($account_doc_share,2); ?></td>
              </tr>
            <?php } ?>
          <tr>
            <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5" colspan="3"><strong>TOTAL REVENUE</strong></td>
            <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($optotalrevenue,2); ?></strong></td>
            <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($totalrevenue,2); ?></strong></td>
            <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($total_doc_share_amount,2); ?></strong></td>
          </tr>

          </tbody>

        </table>
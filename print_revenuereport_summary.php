<?php
session_start();
include("includes/loginverify.php");
include("db/db_connect.php");


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Revenue Report Summary.xls"');
header('Cache-Control: max-age=80');



$ipaddress                 = $_SERVER['REMOTE_ADDR'];
$updatedatetime            = date('Y-m-d');
$username                  = $_SESSION['username'];
$companyanum               = $_SESSION['companyanum'];
$companyname               = $_SESSION['companyname'];
$paymentreceiveddatefrom   = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto     = date('Y-m-d');
$transactiondatefrom       = date('Y-m-d', strtotime('-1 month'));
$transactiondateto         = date('Y-m-d');
$errmsg                    = "";
$banum                     = "1";
$supplieranum              = "";
$custid                    = "";
$custname                  = "";
$balanceamount             = "0.00";
$totaliprefundamount              = "0.00";
$total_depositsip          = "0.00";
$total_depositsip_accounts = 0;
$openingbalance            = "0.00";
$disocuntamount            = 0;
$total                     = '0.00';
$totalamount               = "0.00";
$totalamount30             = "0.00";
$searchsuppliername        = "";
$searchsuppliername1       = "";
$cbsuppliername            = "";
$snocount                  = "";
$colorloopcount            = "";
$range                     = "";
$total30                   = "0.00";
$total60                   = "0.00";
$total90                   = "0.00";
$total120                  = "0.00";
$total180                  = "0.00";
$total240                  = "0.00";
$totalamount1              = "0.00";
$totalamount301            = "0.00";
$totalamount601            = "0.00";
$rebate                    = "0.00";
$totalamount901            = "0.00";
$totalamount1201           = "0.00";
$totalamount1801           = "0.00";
$totalamount2101           = "0.00";
$grandtotalamount1         = "0.00";
$grandtotalamount301       = "0.00";
$grandtotalamount601       = "0.00";
$grandtotalamount901       = "0.00";
$grandtotalamount1201      = "0.00";
$grandtotalamount1801      = "0.00";
$grandtotalamount2101      = "0.00";
$grandtotalamount2401      = "0.00";
$totalamount1              = "0.00";
$totalamount301            = "0.00";
$totalamount60             = "0.00";
$totalamount601            = "0.00";
$totalamount90             = "0.00";
$totalamount901            = "0.00";
$totalamount120            = "0.00";
$totalamount1201           = "0.00";
$totalamount180            = "0.00";
$totalamount1801           = "0.00";
$totalamount210            = "0.00";
$totalamount2101           = "0.00";
$totalamount240            = "0.00";
$totalamount2401           = "0.00";
$res21accountnameano       = '';
$closetotalamount1         = '0';
$closetotalamount301       = '0';
$closetotalamount601       = '0';
$closetotalamount901       = '0';
$closetotalamount1201      = '0';
$closetotalamount1801      = '0';
$closetotalamount2101      = '0';
$closetotalamount2401      = '0';
$total301                  = '0';
$total601                  = '0';
$total901                  = '0';
$total1201                 = '0';
$total1801                 = '0';
$total2401                 = '0';
$total3012                 = '0';
$total6012                 = '0';
$total9012                 = '0';
$total12012                = '0';
$total18012                = '0';
$total24012                = '0';
$total3013                 = '0';
$total6013                 = '0';
$total9013                 = '0';
$total12013                = '0';
$total18013                = '0';
$total24013                = '0';
if (isset($_REQUEST["searchsuppliername1"])) {
    $searchsuppliername1 = $_REQUEST["searchsuppliername1"];
} else {
    $searchsuppliername1 = "";
}
if (isset($_REQUEST["searchsubtypeanum1"])) {
    $searchsubtypeanum1 = $_REQUEST["searchsubtypeanum1"];
} else {
    $searchsubtypeanum1 = "";
}
if (isset($_REQUEST["type"])) {
    $type = $_REQUEST["type"];
} else {
    $type = "";
}
$type1 = $type;
if (isset($_REQUEST["ADate1"])) {
    $ADate1                  = $_REQUEST["ADate1"];
    $paymentreceiveddatefrom = $_REQUEST["ADate1"];
} else {
    $ADate1 = "";
}
if (isset($_REQUEST["ADate2"])) {
    $ADate2                = $_REQUEST["ADate2"];
    $paymentreceiveddateto = $_REQUEST["ADate2"];
} else {
    $ADate2 = "";
}
if (isset($_REQUEST["range"])) {
    $range = $_REQUEST["range"];
} else {
    $range = "";
}
if (isset($_REQUEST["amount"])) {
    $amount = $_REQUEST["amount"];
} else {
    $amount = "";
}
if (isset($_REQUEST["cbfrmflag2"])) {
    $cbfrmflag2 = $_REQUEST["cbfrmflag2"];
} else {
    $cbfrmflag2 = "";
}
if (isset($_REQUEST["frmflag2"])) {
    $frmflag2 = $_REQUEST["frmflag2"];
} else {
    $frmflag2 = "";
}
?>

 

 
 

 

<body>

<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1101" 

            align="left" border="1">

          <tbody>

            <tr>
              <td align="center" colspan="3" bgcolor="#ffffff" class="bodytext31"><strong>Revenue Summary</strong></td>
            </tr>

            

              <?php
if (isset($_REQUEST["cbfrmflag1"])) {
    $cbfrmflag1 = $_REQUEST["cbfrmflag1"];
} else {
    $cbfrmflag1 = "";
}
if ($cbfrmflag1 == 'cbfrmflag1') {
    if (isset($_REQUEST["cbcustomername"])) {
        $cbcustomername = $_REQUEST["cbcustomername"];
    } else {
        $cbcustomername = "";
    }
    if (isset($_REQUEST["customername"])) {
        $customername = $_REQUEST["customername"];
    } else {
        $customername = "";
    }
    if (isset($_REQUEST["cbbillnumber"])) {
        $cbbillnumber = $_REQUEST["cbbillnumber"];
    } else {
        $cbbillnumber = "";
    }
    if (isset($_REQUEST["cbbillstatus"])) {
        $cbbillstatus = $_REQUEST["cbbillstatus"];
    } else {
        $cbbillstatus = "";
    }
    $urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";
} else {
    $urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";
}
?>

                
 
            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></td>

              <td width="15%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account</strong></div></td>

              <td width="16%" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Total Revenue </strong></td>

             </tr>
            

            <?php
if (isset($_REQUEST["cbfrmflag1"])) {
    $cbfrmflag1 = $_REQUEST["cbfrmflag1"];
} else {
    $cbfrmflag1 = "";
}
if ($cbfrmflag1 == 'cbfrmflag1') {
    $totalbilling          = 0;
    $dotarray              = explode("-", $paymentreceiveddateto);
    $dotyear               = $dotarray[0];
    $dotmonth              = $dotarray[1];
    $dotday                = $dotarray[2];
    $paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
    $searchsuppliername1   = trim($searchsuppliername1);
    $searchsuppliername    = trim($searchsuppliername);
    if ($type != '') {
        $query513 = "select auto_number, paymenttype from master_paymenttype where auto_number = '$type' and recordstatus <> 'deleted'";
    } else {
        $query513 = "select auto_number, paymenttype from master_paymenttype where paymenttype <> 'cash' and recordstatus <> 'deleted'";
    }
    $exec513 = mysqli_query($GLOBALS["___mysqli_ston"], $query513) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    while ($res513 = mysqli_fetch_array($exec513)) {
        $type     = $res513['paymenttype'];
        $typeanum = $res513['auto_number'];
?>

            <tr>
            <td colspan="3" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31" ><strong><?php
        echo $type;
?> </strong></td>

            </tr>

            <tr>

            <td colspan="3"></td>

            </tr> 

            <?php
        if ($searchsubtypeanum1 == '') {
            $query2212 = "select accountname,auto_number,id,subtype from master_accountname where subtype <> '' and paymenttype = '$typeanum' group by subtype";
        } else if ($searchsubtypeanum1 != '') {
            $query2212 = "select accountname,auto_number,id,subtype from master_accountname where paymenttype = '$typeanum' and subtype='$searchsubtypeanum1'  group by subtype";
        }
        $exec2212 = mysqli_query($GLOBALS["___mysqli_ston"], $query2212) or die("Error in Query2212" . mysqli_error($GLOBALS["___mysqli_ston"]));
        $resnum = mysqli_num_rows($exec2212);
        while ($res2212 = mysqli_fetch_array($exec2212)) {
            $subtypeanum = $res2212['subtype'];
            $sno         = 1;
            $query9      = mysqli_query($GLOBALS["___mysqli_ston"], "select subtype from master_subtype where auto_number = '$subtypeanum'");
            $res9        = mysqli_fetch_array($query9);
            $subtype     = $res9['subtype'];
?>

            <tr>

            <td colspan="3"  align="left" valign="center" class="bodytext31" ><strong><?php
            echo $subtype; ?> </strong></td>

            </tr> 
            <tbody id="<?= $subtypeanum ?>" style="display:none">
            <?php
            if ($subtypeanum != '') {
                $query221 = "select accountname,auto_number,id from master_accountname where subtype='$subtypeanum'";
            }
            $exec221 = mysqli_query($GLOBALS["___mysqli_ston"], $query221) or die("Error in Query22" . mysqli_error($GLOBALS["___mysqli_ston"]));
            $resnum = mysqli_num_rows($exec221);
            while ($res221 = mysqli_fetch_array($exec221)) {
                $res22accountname    = $res221['accountname'];
                $res21accountnameano = $res221['auto_number'];
                $res21accountname    = $res221['accountname'];
                $res21accountid      = $res221['id'];
                $querydebit1         = "select * from master_transactionpaylater where accountnameano='$res21accountnameano' and accountnameid='$res21accountid'";
                $execdebit1 = mysqli_query($GLOBALS["___mysqli_ston"], $querydebit1) or die("Error in Querydebit1" . mysqli_error($GLOBALS["___mysqli_ston"]));
                $numdebit1 = mysqli_num_rows($execdebit1);
                if ($res22accountname != '' && $numdebit1 > 0) {
                    $openingbalance = '0';
                    if ($cbfrmflag1 == 'cbfrmflag1') {
                        $totaldebit            = 0;
                        $debit                 = 0;
                        $credit1               = 0;
                        $credit2               = 0;
                        $totalpayment          = 0;
                        $totalcredit           = '0';
                        $resamount             = 0;
                        $totalamountgreater    = 0;
                        $dotarray              = explode("-", $paymentreceiveddateto);
                        $dotyear               = $dotarray[0];
                        $dotmonth              = $dotarray[1];
                        $dotday                = $dotarray[2];
                        $paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
                        $searchsuppliername1   = trim($searchsuppliername1);

                        //////// new code ///////////
                        
$totaladmissionamount     = 0;
$totalpackagecharge       = 0;
$totalipbedcharges        = 0;
$totalipnursingcharges    = 0;
$totaliprmocharges        = 0;
$totaliprmocharges1       = 0;
$totallabamount           = 0;
$totalradiologyamount     = 0;
$totalpharmacyamount      = 0;
$totalservicesamount      = 0;
$totalambulanceamount     = 0;
$totalhomecareamount      = 0;
$totalprivatedoctoramount = 0;
$totalipmiscamount        = 0;
$totalipdiscamount        = 0;

$fromdate=$ADate1;
$todate=$ADate2;
$query186       = "select  auto_number,patientname,patientcode,visitcode,'billing' as type from billing_ip where  billdate between '$fromdate' and '$todate'  and accountnameano = '$res21accountnameano' 
     UNION ALL SELECT auto_number,patientname,patientcode,visitcode,'creditapproved' as type from billing_ipcreditapproved where billdate between '$fromdate' and '$todate' and  accountnameano = '$res21accountnameano'  group by visitcode  order by auto_number DESC ";
$exec186 = mysqli_query($GLOBALS["___mysqli_ston"], $query186) or die("Error in Query186" . mysqli_error($GLOBALS["___mysqli_ston"]));
$num186 = mysqli_num_rows($exec186);
while ($res186 = mysqli_fetch_array($exec186)) {
    $patientname = $res186['patientname'];
    $patientcode = $res186['patientcode'];
    $visitcode   = $res186['visitcode'];
    $query2      = "select  amountuhx  from billing_ipadmissioncharge where  patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
    $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query2" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $num2                 = mysqli_num_rows($exec2);
    $res2                 = mysqli_fetch_array($exec2);
    $admissionamount      = $res2['amountuhx'];
    $totaladmissionamount = $totaladmissionamount + $admissionamount;
    $query3               = "SELECT SUM(rateuhx) as amountuhx FROM `billing_iplab` WHERE billdate BETWEEN '$fromdate' AND '$todate' and   patientvisitcode ='$visitcode'

        UNION ALL SELECT SUM(fxamount) as amountuhx FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$todate' and billtype = 'PAY LATER' and description = 'Lab' and  patientvisitcode='$visitcode'";
    $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $num3           = mysqli_num_rows($exec3);
    $res3           = mysqli_fetch_array($exec3);
    $labamount      = $res3['amountuhx'];
    $totallabamount = $totallabamount + $labamount;
    $query4         = "SELECT sum(radiologyitemrateuhx) as amountuhx FROM `billing_ipradiology` WHERE billdate BETWEEN '$fromdate' AND '$todate' and patientvisitcode ='$visitcode'
            UNION ALL SELECT sum(fxamount) as amountuhx FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$ADate2' and billtype = 'PAY LATER' and description = 'Radiology' and patientvisitcode='$visitcode'";
    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die("Error in Query4" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $num4                 = mysqli_num_rows($exec4);
    $res4                 = mysqli_fetch_array($exec4);
    $radiologyamount      = $res4['amountuhx'];
    $totalradiologyamount = $totalradiologyamount + $radiologyamount;
    $query5               = "select sum(amount) from billing_ippharmacy where  patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
    $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die("Error in Query5" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $num5                = mysqli_num_rows($exec5);
    $res5                = mysqli_fetch_array($exec5);
    $pharmacyamount      = $res5['sum(amount)'];
    $totalpharmacyamount = $totalpharmacyamount + $pharmacyamount;
    $query6              = "SELECT SUM(servicesitemrateuhx) as amountuhx,sum(sharingamount) as sharingamount  FROM `billing_ipservices` WHERE  billdate BETWEEN '$fromdate' AND '$todate' and patientvisitcode ='$visitcode'
        UNION ALL SELECT SUM(fxamount) as amountuhx,'' as sharingamount FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$todate' and billtype = 'PAY LATER' and description = 'Service' and patientvisitcode='$visitcode'";
    $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die("Error in Query6" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $num6                = mysqli_num_rows($exec6);
    $res6                = mysqli_fetch_array($exec6);
    $servicesamount      = $res6['amountuhx'] - $res6['sharingamount'];
    $totalservicesamount = $totalservicesamount + $servicesamount;
    $query8              = "select sum(amountuhx) from billing_ipambulance where  patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
    $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die("Error in Query8" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $num8                 = mysqli_num_rows($exec8);
    $res8                 = mysqli_fetch_array($exec8);
    $ambulanceamount      = $res8['sum(amountuhx)'];
    $totalambulanceamount = $totalambulanceamount + $ambulanceamount;
    $query81              = "select sum(amount) from billing_iphomecare where  patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
    $exec81 = mysqli_query($GLOBALS["___mysqli_ston"], $query81) or die("Error in Query81" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $num81               = mysqli_num_rows($exec81);
    $res81               = mysqli_fetch_array($exec81);
    $homecareamount      = $res81['sum(amount)'];
    $totalhomecareamount = $totalhomecareamount + $homecareamount;
    // $query8              = "select sum(transactionamount) from billing_ipprivatedoctor where  patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
    // $exec8 = mysql_query($query8) or die("Error in Query8" . mysql_error());
    // $num8                     = mysql_num_rows($exec8);
    // $res8                     = mysql_fetch_array($exec8);
    // $privatedoctoramount      = $res8['sum(transactionamount)'];
    // $totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctoramount;
    $query8              = "select (transactionamount) as transactionamount, (original_amt) as original_amt, visittype, coa from billing_ipprivatedoctor where  patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
                $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die("Error in Query8" . mysqli_error($GLOBALS["___mysqli_ston"]));
                $num8                     = mysqli_num_rows($exec8);
                while($res8 = mysqli_fetch_array($exec8)){
                    if($res8['visittype'] =="IP")
              {
                if($res8['coa'] !="")
                 $privatedoctoramount = $res8['transactionamount'];
                else
                 $privatedoctoramount = $res8['original_amt'];
              }
              else
              {
                $privatedoctoramount = $res8['original_amt'];
              }
                      // $privatedoctoramount      = $res8['sum(transactionamount)'];
                      $totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctoramount;
                }


    $query9                   = "SELECT SUM(amountuhx) AS amount FROM `billing_ipbedcharges` WHERE description = 'Bed Charges' AND recorddate BETWEEN '$fromdate' AND '$todate'   and visitcode='$visitcode'  

                    UNION ALL SELECT SUM(fxamount) AS amount  FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$todate' and billtype = 'PAY LATER' and description = 'Bed Charges' and patientvisitcode='$visitcode'

                    ";
    $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die("Error in Query9" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $num9              = mysqli_num_rows($exec9);
    $res9              = mysqli_fetch_array($exec9);
    $ipbedcharges      = $res9['amount'];
    $totalipbedcharges = $totalipbedcharges + $ipbedcharges;
    if ($res186['type'] == 'billing') {
        $query10 = "select sum(amountuhx) as amount from billing_ipbedcharges where   description='Nursing Charges' and  visitcode='$visitcode'  and recorddate between '$fromdate' and '$todate' 

                      UNION ALL SELECT sum(fxamount)as amount FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$todate' and billtype = 'PAY LATER' and description='Nursing Charges' and patientvisitcode='$visitcode'";
    } else {
        $query10 = "select sum(amountuhx) as amount from billing_ipbedcharges where   description='Ward Dispensing Charges' and  visitcode='$visitcode'  and recorddate between '$fromdate' and '$todate' 

                       UNION ALL SELECT sum(fxamount) as amount FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$todate' and billtype = 'PAY LATER' and description='Ward Dispensing Charges' and patientvisitcode='$visitcode'  ";
    }
    $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die("Error in Query10" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $num10                 = mysqli_num_rows($exec10);
    $res10                 = mysqli_fetch_array($exec10);
    $ipnursingcharges      = $res10['amount'];
    $totalipnursingcharges = $totalipnursingcharges + $ipnursingcharges;
    if ($res186['type'] == 'billing') {
        $query11 = "SELECT sum(amountuhx) AS amount FROM `billing_ipbedcharges` WHERE (description = 'RMO Charges' or description ='Daily Review charge') AND recorddate BETWEEN '$ADate1' AND '$ADate2' and visitcode='$visitcode'

          UNION ALL SELECT sum(fxamount) as amount FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and billtype = 'PAY LATER' and description = 'RMO Charges' and patientvisitcode='$visitcode'";
    } else {
        $query11 = "SELECT  sum(amountuhx) AS amount FROM `billing_ipbedcharges` WHERE (description = 'Resident Doctor Charges') AND recorddate BETWEEN '$ADate1' AND '$ADate2'    and visitcode='$visitcode' ";
    }
    $exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die("Error in Query11" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $num11             = mysqli_num_rows($exec11);
    $res11             = mysqli_fetch_array($exec11);
    $iprmocharges      = $res11['amount'];
    $totaliprmocharges = $totaliprmocharges + $iprmocharges;
    $query111          = "select sum(amountuhx) from billing_ipbedcharges where  patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Consultant Fee' and recorddate between '$fromdate' and '$todate' ";
    $exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die("Error in Query11" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $num111             = mysqli_num_rows($exec111);
    $res111             = mysqli_fetch_array($exec111);
    $iprmocharges1      = $res111['sum(amountuhx)'];
    $totaliprmocharges1 = $totaliprmocharges1 + $iprmocharges1;
    $query133           = "select sum(amount) from deposit_refund where  patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
    $exec133 = mysqli_query($GLOBALS["___mysqli_ston"], $query133) or die("Error in Query133" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $num133              = mysqli_num_rows($exec133);
    $res133              = mysqli_fetch_array($exec133);
    $iprefundamount      = $res133['sum(amount)'];
    $totaliprefundamount = $totaliprefundamount + $iprefundamount;
    $query14             = "select sum(amountuhx) from billing_ipmiscbilling where  patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
    $exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die("Error in Query14" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $num14             = mysqli_num_rows($exec14);
    $res14             = mysqli_fetch_array($exec14);
    $ipmiscamount      = $res14['sum(amountuhx)'];
    $totalipmiscamount = $totalipmiscamount + $ipmiscamount;
    if ($res186['type'] == 'billing') {
        $query112 = "select sum(amountuhx) AS amountuhx from billing_ipbedcharges where   description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and  visitcode='$visitcode'  and recorddate between '$fromdate' and '$todate' 

          UNION ALL SELECT sum(fxamount)  as amountuhx FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$todate' and billtype = 'PAY LATER' and description NOT IN ('Bed Charges','Nursing Charges','RMO Charges','Daily Review charge','Consultant Fee') and patientvisitcode='$visitcode'";
    } else {
        $query112 = "select sum(amountuhx) AS amountuhx from billing_ipbedcharges where   description NOT IN  ('Bed Charges','Resident Doctor Charges','Ward Dispensing Charges') and  visitcode='$visitcode'  and recorddate between '$fromdate' and '$todate'

           UNION ALL SELECT  sum(fxamount) as amountuhx FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$fromdate' AND '$todate' and billtype = 'PAY LATER' and description NOT IN ('Bed Charges','Resident Doctor Charges','Ward Dispensing Charges') and patientvisitcode='$visitcode'

           ";
    }
    $exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die("Error in Query112" . mysqli_error($GLOBALS["___mysqli_ston"]));
    $num112             = mysqli_num_rows($exec112);
    $res112             = mysqli_fetch_array($exec112);
    $packagecharge      = $res112['amountuhx'];
    $totalpackagecharge = $totalpackagecharge + $packagecharge;
    // $query15            = "select patientname,patientcode,visitcode from billing_ipbedcharges where  patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
    // $exec15 = mysql_query($query15) or die("Error in Query15" . mysql_error());
    // $num15            = mysql_num_rows($exec15);
    // $res15            = mysql_fetch_array($exec15);
    // $res15patientname = $res1['patientname'];
    // $res15patientcode = $res1['patientcode'];
    // $res15visitcode   = $res1['visitcode'];
    // $query12          = "select transactionamount,docno from master_transactionipdeposit where  patientcode = '$patientcode' and visitcode='$visitcode' and transactiondate between '$fromdate' and '$todate' ";
    // $exec12 = mysql_query($query12) or die("Error in Query12" . mysql_error());
    // $num12 = mysql_num_rows($exec12);
    // while ($res12 = mysql_fetch_array($exec12)) {
    //     $transactionamount      = $res12['transactionamount'];
    //     $referencenumber        = $res12['docno'];
    //     $totaltransactionamount = $totaltransactionamount + $transactionamount;
    // }
    
}
$querysearchnew = "select visitcode from billing_ip where billdate between '$fromdate' and '$todate' and accountnameano ='$res21accountnameano'   UNION ALL SELECT visitcode from billing_ipcreditapproved where billdate between '$fromdate'  and '$todate' and accountnameano ='$res21accountnameano'";

		$query12 = "SELECT sum(-1*rate) as discount FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `master_transactionip` WHERE accountnameano ='$res21accountnameano' and transactiondate BETWEEN '$fromdate' AND '$todate' group by billnumber) and patientvisitcode IN ($querysearchnew)
			UNION ALL SELECT sum(-1*rate) as discount FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `billing_ipcreditapprovedtransaction` WHERE accountnameano ='$res21accountnameano' and billdate BETWEEN '$fromdate' AND '$todate' group by billno) and patientvisitcode IN ($querysearchnew)";
			
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num12=mysqli_num_rows($exec12);

		

		while($res12 = mysqli_fetch_array($exec12))

		{

			 $ipdiscamount=$res12['discount'];


			 $totalipdiscamount=$totalipdiscamount + $ipdiscamount;

		} 	

$rowtot2 = $totaladmissionamount+$totalpackagecharge+$totalipbedcharges+$totalipnursingcharges+$totaliprmocharges+ $totaliprmocharges1+$totallabamount+$totalradiologyamount+

						$totalpharmacyamount+$totalservicesamount+$totalambulanceamount+$totalhomecareamount+$totalprivatedoctoramount+$totalipmiscamount+$totalipdiscamount;

$closetotalamount301 = $closetotalamount301 + $rowtot2;
   $totalamount301      = $totalamount301 + $rowtot2;

                  //////// new code ///////////

$query1  = "SELECT subtypeano,accountname,subtype,transactiondate,patientcode,patientname,visitcode,billnumber,particulars,fxamount,auto_number from master_transactionpaylater where accountnameano='$res21accountnameano' and accountnameid='$res21accountid' and visitcode IN 
                ( SELECT visitcode from billing_paylater where billdate between '$ADate1' and '$ADate2' group by visitcode  
                )
            and transactiontype = 'finalize' and fxamount <> '0'   order by auto_number desc";

                        $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
                        while ($res2 = mysqli_fetch_array($exec1)) {
                            $resamount             = 0;
                            $res2transactionamount = 0;
                            $res2transactiondate   = $res2['transactiondate'];
                            $res2visitcode         = $res2['visitcode'];
                            $res2billnumber        = $res2['billnumber'];
                            $anum                  = $res2['auto_number'];
                            $exchange_rate         = 1;
                            $res2transactionamount = $res2['fxamount'] / $exchange_rate;
                            $totalbilling += $res2['fxamount'];
                            $totalpayment             = 0;
                            $res7sumtransactionamount = 0;
                            $res8sumtransactionamount = 0;
                            $resamount                = $res2transactionamount;
                            if ($resamount != '0') {
                                $snocount              = $snocount + 1;
                                $totalamount1          = $totalamount1 + $res2transactionamount;
                                $totalamount301        = $totalamount301 + $res2transactionamount;
                                $closetotalamount1     = $closetotalamount1 + $res2transactionamount;
                                $closetotalamount301   = $closetotalamount301 + $res2transactionamount;
                                $res2transactionamount = 0;
                                $resamount             = 0;
                            }
                            $res2transactionamount  = 0;
                            $resamount              = 0;
                            $res5transactionamount  = 0;
                            $respharmacreditpayment = 0;
                        }

// for paylater in paynow
        // paynow consultation with paylater ////
// $query_pnphar="select SUM(consultation) as billamount1 from billing_consultation where  billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select visitcode from master_visitentry where accountname='$res21accountnameano' ) and accountname != 'CASH - HOSPITAL'
// ";
$query_pnphar="select SUM(consultation) as billamount1 from billing_consultation where  billdate between '$ADate1' and '$ADate2' and accountname ='$res21accountname'
";
// union all select SUM(totalamount) AS billamount1 from billing_paylaterconsultation where billdate between '$ADate1' and '$ADate2' and accountname != 'CASH - HOSPITAL' and visitcode in (select visitcode from master_visitentry where accountname='$res21accountnameano' )

// $query_pnphar="select SUM(consultation) as billamount1 from billing_consultation where patientvisitcode in (select visitcode from master_visitentry where accountname='$res21accountnameano' and consultationdate between '$ADate1' and '$ADate2' group by visitcode )";
$exec_pnphar = mysqli_query($GLOBALS["___mysqli_ston"], $query_pnphar) or die ("Error in Query_pnphar".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res_pnphar = mysqli_fetch_array($exec_pnphar) ;
		    $res_pnpharrate = $res_pnphar['billamount1'];

		    $closetotalamount301 = $closetotalamount301 + $res_pnpharrate;
		  	$totalamount301 = $totalamount301+$res_pnpharrate;

// paynow pharmacy with paylater////
// $query_pd="SELECT sum(fxamount) as amount1 from billing_paynowpharmacy  where  billdate between '$ADate1' and '$ADate2' and patientvisitcode in (select visitcode from master_visitentry where accountname='$res21accountnameano' ) and accountname != 'CASH - HOSPITAL'

// ";

$query_pd="SELECT sum(fxamount) as amount1 from billing_paynowpharmacy  where  billdate between '$ADate1' and '$ADate2' and accountname ='$res21accountname'

";

// -- UNION all select SUM(fxamount) AS  amount1 from billing_paylaterpharmacy where  billdate between '$ADate1' and '$ADate2' and accountname != 'CASH - HOSPITAL' and patientvisitcode in (select visitcode from master_visitentry where accountname='$res21accountnameano')
// $query_pd="select sum(fxamount) as amount1 from billing_paynowpharmacy where patientvisitcode in (select visitcode from master_visitentry where accountname='$res21accountnameano' and consultationdate between '$ADate1' and '$ADate2' group by visitcode )";
$exec_pd = mysqli_query($GLOBALS["___mysqli_ston"], $query_pd) or die ("Error in Query_pd".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res_pd = mysqli_fetch_array($exec_pd) ;
		    $res_pdrate = $res_pd['amount1'];
		    $closetotalamount301 = $closetotalamount301 + $res_pdrate;
		  	$totalamount301 = $totalamount301+$res_pdrate;                
// for paylater in paynow ends

                        $query16 = "SELECT (1*amount) as rebate FROM `billing_ipnhif` where recorddate between '$ADate1' and '$ADate2' and accountcode='$res21accountid' ";
                        $exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die("Error in Query16" . mysqli_error($GLOBALS["___mysqli_ston"]));
                        $num16 = mysqli_num_rows($exec16);
                        while ($res16 = mysqli_fetch_array($exec16)) {
                            $rebateamount        = $res16['rebate'];
                            $closetotalamount301 = $closetotalamount301 + $rebateamount;
                            $totalamount301      = $totalamount301 + $rebateamount;
                        }
                        $depositsip       = 0;
                        $depositrefunds   = 0;
          //               $query_debitnotes = "SELECT (-1*deposit) as amountuhx FROM `billing_ip` WHERE   billdate between '$ADate1' and '$ADate2' and accountnameano = '$res21accountnameano' and accountnameid='$res21accountid' 
          //         union all SELECT (-1*deposit) as amountuhx FROM `billing_ipcreditapproved` WHERE   billdate between '$ADate1' and '$ADate2' and accountnameano = '$res21accountnameano' and accountnameid='$res21accountid' 
          // ";
          //               $exec_debitnotes = mysql_query($query_debitnotes) or die("Error in Query_debitnotes" . mysql_error());
          //               $num_debitnotes = mysql_num_rows($exec_debitnotes);
          //               while ($res_debitnotes = mysql_fetch_array($exec_debitnotes)) {
          //                   $depositsip += $res_debitnotes['amountuhx'];
          //               }
                        $closetotalamount1   = $closetotalamount1 + $openingbalance;
                        $closetotalamount301 = $closetotalamount301 + $openingbalance;
                        $totalamount1        = $totalamount1 + $openingbalance;
                        $totalamount301      = $totalamount301 + $openingbalance;
                        $colorloopcount      = $colorloopcount + 1;
                        $showcolor           = ($colorloopcount & 1);
                        if ($showcolor == 0) {
                            $colorcode = 'bgcolor="#CBDBFA"';
                        } else {
                            $colorcode = 'bgcolor="#ecf0f5"';
                        }
?>

          

           <tr>

           <td class="bodytext31" valign="center"  align="left"><?= $sno++; ?></td>

                <td class="bodytext31" valign="center"  align="left" 

                > <?php
                        echo $res22accountname;
?> </td>

                <td class="bodytext31" valign="center"  align="right" ><?php
                        echo number_format($closetotalamount301, 2, '.', ',');
?></td>
                <?php
                        $deposit = $depositsip - $depositrefunds;
                        $total_depositsip_accounts += $deposit;
?>
              <!--  <td class="bodytext31" valign="center"  align="right" ><?php
                        echo number_format($deposit, 2, '.', ',');
?></td> -->

            </tr>

            <?php
                        $closetotalamount1   = '0';
                        $closetotalamount301 = '0';
                    }
                    $totalamount30  = 0;
                    $totalamount60  = 0;
                    $totalamount90  = 0;
                    $totalamount120 = 0;
                    $totalamount180 = 0;
                    $totalamount210 = 0;
                }
            }
?>

            </tbody>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                >&nbsp;</td>

              <td class="bodytext31" valign="center"  align="center" 

                ><strong>Total:</strong></td>

              <td class="bodytext31" valign="center"  align="right"  ><strong><?php
            echo number_format($totalamount301, 2, '.', ',');
?></strong></td>
              <!-- <td class="bodytext31" valign="center"  align="right"  bgcolor="#ecf0f5"><strong><?php
            echo number_format($total_depositsip_accounts, 2, '.', ',');
?></strong></td> -->

            </tr>

            <tr>

            <?php
            $total_depositsip += $total_depositsip_accounts;
            $grandtotalamount1 += $totalamount1;
            $grandtotalamount301 += $totalamount301;
            $total_depositsip_accounts = "0.00";
            $totalamount1              = "0.00";
            $totalamount301            = "0.00";
            $urlpath                   = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&searchsuppliername=$searchsuppliername&&searchsuppliername1=$searchsuppliername1&&type=$type1&&searchsubtypeanum1=$searchsubtypeanum1";
?>

             <td colspan="2"></td>

               <td class="bodytext31" valign="center"  align="right"></td>

            </tr>    

               <?php
        }
    }
?>

               <tr >

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="center" 

                bgcolor="#ecf0f5"><strong>Grand Total:</strong></td>

              <td class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><strong><?php
    echo number_format($grandtotalamount301, 2, '.', ',');
?></strong></td>
              <!-- <td class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><strong><?php
    echo number_format($total_depositsip, 2, '.', ',');
?></strong></td> -->

            </tr>
 
            <?php
}
?>

          </tbody>

        </table> 

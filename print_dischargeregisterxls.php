<?php

header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="report_dischargeregister.xls"');

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
$wardcode='';




$snocount = "";

$colorloopcount="";

$range = "";

$opnumber = "";

$ipnumber = "";

$patientname = "";

$dateofadmission = "";

$dateofdischarge = "";

$class = "";

$admissiondoc = "";

$consultingdoc = "";

$revenue = "";

$returns = "";

$discount = "";

$nhif = "";

$netbill = "";

$invoiceno = "";

$dischargedby = "";

$wardcode = "";

$locationcode = "";

$patientcode = "";

$consultationfee = 0;

$labrate = 0;

$pharmamount = 0;

$radrate=0;

$serrate=0;

$bedallocationamount = 0;

$bedtransferamount = 0;

$packageamount = 0;



if (isset($_REQUEST["wardcode"])) { $wardcode = $_REQUEST["wardcode"]; } else { $wardcode = ""; }



if (isset($_REQUEST["locationcode"])) { $locationcode1 = $_REQUEST["locationcode"]; } else { $locationcode1 = ""; }

//echo $searchsuppliername;

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

//echo $amount;

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }



$query18 = "select * from master_location";

$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));

$row = array();

while($row[] = mysqli_fetch_array($exec18)){

$res1locationname = $row[0]['locationname'];

}



$query2 = "select * from master_ward where auto_number = '$wardcode'";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$res2wardnamename = $res2['ward'];



$currentdate = date('d/m/Y H:i:s');

if($locationcode1=='All')
		{
		$pass_location = "locationcode !=''";
		}
		else
		{
		$pass_location = "locationcode ='$locationcode1'";
		}

?>

<style type="text/css">

<!--

.bodytext3 {

}

.bodytext31 {

}

.bodytext311 {

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



<table cellspacing="3" cellpadding="0" align="left" border="0" style="border-collapse:collapse;" width="100%">

	<tbody>

		<tr>

			<td colspan="15"><br></td>

		</tr>

		<tr>

			<td class="bodytext31"  valign="middle"  align="left" colspan="20" ><strong><?php echo strtoupper($res1locationname); ?></strong></td>

		</tr>

		<tr>

			<td class="bodytext31" colspan="20" valign="middle"  align="left" ><strong>Discharge Register From <?php echo date("d/m/Y", strtotime($ADate1)); ?> to <?php echo date("d/m/Y", strtotime($ADate2)); ?> printed on <?php echo $currentdate; ?></strong></td>  

		</tr>

		<tr>

			<td colspan="15"><br></td>

		</tr>

	</tbody>

</table>

<table style="border-collapse:collapse;" cellspacing="3" cellpadding="0" width="1600" align="left" border="1">

    	<tr>

        <td width="2%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>No.</strong></div></td>

        <td width="8%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Ward</strong></div></td>

        <td width="5%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patientcode</strong></div></td>

        <td width="5%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visitcode</strong></div></td>

        <td width="10%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></td>

        <td width="5%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>D.O.A.</strong></div></td>

        <td width="5%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>D.O.A. Time</strong></div></td>

        <td width="5%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>D.O.D</strong></td>

        <td width="5%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>D.O.D Time</strong></div></td>

        <td width="3%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>LOS</strong></td>

        <td width="10%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Scheme</strong></td>
        
          <td width="10%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Ward</strong></td>

        <td width="10%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Admitting Doctor</strong></div></td>

        <td width="10%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Consulting Doctor</strong></div></td>

        <td width="5%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Revenue</strong></div></td>

        <td width="5%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Deposit</strong></div></td>

        <td width="5%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Discount</strong></div></td> 

        <td width="5%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>NHIF</strong></div></td> 

        <td width="5%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Net Bill</strong></div></td>

        <td width="8%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Invoice NO.</strong></div></td>

        <td width="5%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Discharged By</strong></div></td> 

      </tr>

       <?php



          $totalrevenue = $totaldiscount = $totaldeposit = $totalnhif = $totalnetbill = 0;
		  $ward12=$wardcode;
		  if($wardcode!='')
		{
			   $query110 = "select a.patientname, a.patientcode, a.visitcode, b.ward from billing_ipcreditapproved as a JOIN ip_bedallocation as b ON a.visitcode = b.visitcode where (a.billdate between '$ADate1' and '$ADate2') and a.$pass_location and b.ward='$ward12'
		 UNION ALL 
		 select a.patientname, a.patientcode, a.visitcode, b.ward from billing_ip as a JOIN ip_bedallocation as b ON a.visitcode = b.visitcode where (a.billdate between '$ADate1' and '$ADate2') and a.$pass_location and b.ward='$ward12' order by ward";
		}
		else
		{
			   $query110 = "select a.patientname, a.patientcode, a.visitcode, b.ward from billing_ipcreditapproved as a JOIN ip_bedallocation as b ON a.visitcode = b.visitcode where (a.billdate between '$ADate1' and '$ADate2') and a.$pass_location 
		 UNION ALL 
		 select a.patientname, a.patientcode, a.visitcode, b.ward from billing_ip as a JOIN ip_bedallocation as b ON a.visitcode = b.visitcode where (a.billdate between '$ADate1' and '$ADate2') and a.$pass_location order by ward";
		}
		  
	
          $exec110 = mysqli_query($GLOBALS["___mysqli_ston"], $query110) or die ("Error in Query110".mysqli_error($GLOBALS["___mysqli_ston"]));

          while ($res110 = mysqli_fetch_array($exec110)){

              $patientcode = $res110['patientcode'];

              $patientname = $res110['patientname'];

              $visitcode = $res110['visitcode'];



              $query10 = "select * from ip_bedallocation where patientcode = '$patientcode' and visitcode = '$visitcode'";

              $exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die("Error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));

              $res10 = mysqli_fetch_array($exec10);

              $admissiondate = $res10['recorddate'];

              $admissiontime = $res10['recordtime'];



              $wardno = $res10['ward'];

              $queryward = "select * from master_ward where auto_number = '$wardno'";

              $execward = mysqli_query($GLOBALS["___mysqli_ston"], $queryward) or die("Error in QueryWard".mysqli_error($GLOBALS["___mysqli_ston"]));

              $resward = mysqli_fetch_array($execward);

              $wardname = $resward['ward'];





              $querydischarge = "select * from ip_discharge where patientcode = '$patientcode' and visitcode = '$visitcode'";

              $execdischarge = mysqli_query($GLOBALS["___mysqli_ston"], $querydischarge) or die("Error in querydischarge".mysqli_error($GLOBALS["___mysqli_ston"]));

              $resdischarge = mysqli_fetch_array($execdischarge);

              $dischargedate = $resdischarge['recorddate'];

              $dischargetime = $resdischarge['recordtime'];

              $accountname = $resdischarge['accountname'];

              $dischargedby = $resdischarge['username'];



              $start = strtotime($admissiondate);

              $end = strtotime($dischargedate);

              $los = floor(abs($end - $start) / 86400);



              $query12 = "select * from master_ipvisitentry where patientcode = '$patientcode' and visitcode = '$visitcode'";

              $exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die("Error in query12".mysqli_error($GLOBALS["___mysqli_ston"]));

              $res12 = mysqli_fetch_array($exec12);

              $admissiondoc = $res12['opadmissiondoctor'];

              $consultingdoc = $res12['consultingdoctorName'];



              $query13 = "select * from billing_ip where patientcode = '$patientcode' and visitcode = '$visitcode'";

              $exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die("Error in query13".mysqli_error($GLOBALS["___mysqli_ston"]));

              $res13 = mysqli_fetch_array($exec13);

              $num13 = mysqli_num_rows($exec13);



              if($num13 == 1){

                $revenue = $res13['totalrevenue'];

                $deposit = $res13['deposit'];

                $discount = $res13['discount'];

                $nhif = $res13['nhif'];

                $netbill = $res13['totalamount'];

                $invoiceno = $res13['billno'];

              } else {

                $query14 = "select * from billing_ipcreditapproved where patientcode = '$patientcode' and visitcode = '$visitcode'";

                $exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die("Error in query14".mysqli_error($GLOBALS["___mysqli_ston"]));

                $res14 = mysqli_fetch_array($exec14);



                $revenue = $res14['totalrevenue'];

                $deposit = $res14['deposit'];

                $discount = $res14['discount'];

                $nhif = $res14['nhif'];

                $netbill = $res14['totalamount'];

                $invoiceno = $res14['billno'];

              }

              

              $totalrevenue += $revenue;

              $totaldeposit += $deposit;

              $totaldiscount += $discount;

              $totalnhif += $nhif;

             // $totalnetbill += $netbill;



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
            $deposit1=$deposit;
		   $deposit1=abs($deposit);
		   if($revenue<=0)
		   {
			 $revenue=$deposit1;
		   }
		   $netbill=$revenue-$discount-$nhif;
		    $totalnetbill += $netbill;
          ?>

               <tr <?php echo $colorcode; ?>>

                  <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $wardname; ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $patientcode; ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $visitcode; ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $patientname; ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $admissiondate; ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $admissiontime; ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $dischargedate; ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $dischargetime; ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $los; ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $accountname; ?></td>
                  
                  <td class="bodytext31" valign="center" align="left"><?php echo $wardname; ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $admissiondoc; ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $consultingdoc; ?></td>

                  <td class="bodytext31" valign="center" align="right"><?php echo number_format($revenue,2); ?></td>

                  <td class="bodytext31" valign="center" align="right"><?php echo number_format($deposit,2); ?></td>

                  <td class="bodytext31" valign="center" align="right"><?php echo "-".number_format($discount,2); ?></td>

                  <td class="bodytext31" valign="center" align="right"><?php echo number_format($nhif,2); ?></td>

                  <td class="bodytext31" valign="center" align="right"><?php echo number_format($netbill,2); ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $invoiceno; ?></td>

                  <td class="bodytext31" valign="center" align="left"><?php echo $dischargedby; ?></td>

          </tr>



          <?php

          }

          ?>



            <tr bgcolor="#ecf0f5">

              <td class="bodytext31" valign="center" align="right" colspan="14"><strong>Total:</strong></td>

              <td class="bodytext31" valign="center" align="right"><strong><?php echo number_format($totalrevenue,2); ?></strong></td>

              <td class="bodytext31" valign="center" align="right"><strong><?php echo number_format($totaldeposit,2); ?></strong></td>

              <td class="bodytext31" valign="center" align="right"><strong><?php echo "-".number_format($totaldiscount,2); ?></strong></td>

              <td class="bodytext31" valign="center" align="right"><strong><?php echo number_format($totalnhif,2); ?></strong></td>

              <td class="bodytext31" valign="center" align="right"><strong><?php echo number_format($totalnetbill,2); ?></strong></td>

              <td class="bodytext31" valign="center" align="right" colspan="2">&nbsp;</td>

            </tr>

</table>
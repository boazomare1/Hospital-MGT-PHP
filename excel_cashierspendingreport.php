<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];
$ADate1=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date('Y-m-d');

$ADate2=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:date('Y-m-d');

if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

$fromdate=$ADate1;
$todate=$ADate2;

/*header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="Cashier pending report.xls"');

header('Cache-Control: max-age=80');*/

$colorloopcount=0;

$sno=0;

$searchsuppliername = "";

$totalconsultation = 0;

$totalpharma = 0;

$totallab = 0;

$totalrad = 0;

$totalser = 0;

$totalref = 0;

$res7username = '';
?>

<?php



//$cbfrmflag1 = $_POST['cbfrmflag1'];


	
	?>
	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse; float:none" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1035" 

            align="left" border="0">

          <tbody>

             <tr>

			 <td colspan="15" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Cashier Pending Report</strong></div></td>

			 </tr>
			 <tr>

                <td width=""  align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>

                 <td width="25%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Patient Name </strong></td>

                 <td width="20%" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Reg Code</strong></td>

				  <td width="20%" align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><strong>Visit Code</strong></td>

				<td width="20%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Visit Date</strong></td>

					  <td width="30%" align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><strong>Account Name</strong></td>

	                <td width="20%" align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><strong>Consultation Amount </strong></td>

                    <td width="20%"  align="left" valign="center"    bgcolor="#ffffff" class="bodytext31"><strong>Pharmacy Amount</strong></td>

                           <td width="20%"  align="left" valign="center"  bgcolor="#ffffff" class="style1"><strong>Lab Amount</strong> </td>

                           <td width="20%"  align="left" valign="center"  bgcolor="#ffffff" class="style1"><strong>Service Amount </strong></td>

                           <td width="20%"  align="left" valign="center"  bgcolor="#ffffff" class="style1"><strong>Radiology Amount </strong></td>

				<td width="20%"  align="left" valign="center"   bgcolor="#ffffff" class="style1"><strong>Referal Amount </strong></td>
				
				</tr>
			 
			   <?php 
			   
			if($location=='All')
			{
			$pass_location = "locationcode !=''";
			}
			else
			{
			$pass_location = "locationcode ='$location'";
			}	
if ($cbfrmflag1 == 'cbfrmflag1')

{
           	$qry12 = "select visitcode from (select patientvisitcode as visitcode,consultationdate as date from consultation_lab where ((billtype like 'pay now' and paymentstatus like 'pending') or (billtype like 'pay later' and ((copay <> 'completed' and patientvisitcode in (select visitcode from master_visitentry where planpercentage > 0))) or (approvalstatus = '2' and paymentstatus like 'pending'))) and consultationdate between '$fromdate' and '$todate' and $pass_location

                      UNION ALL select patientvisitcode as visitcode,consultationdate as date from consultation_radiology where ((billtype like 'pay now' and paymentstatus like 'pending') or (billtype like 'pay later' and ((paymentstatus <> 'completed' and patientvisitcode in (select visitcode from master_visitentry where planpercentage > 0)))or (approvalstatus = '2' and paymentstatus like 'pending'))) and consultationdate between '$fromdate' and '$todate' and $pass_location

                      UNION ALL select patientvisitcode as visitcode,consultationdate as date from consultation_services where ((billtype like 'pay now' and paymentstatus like 'pending') or (billtype like 'pay later' and ((paymentstatus <> 'completed' and patientvisitcode in (select visitcode from master_visitentry where planpercentage > 0)))or (approvalstatus = '2' and paymentstatus like 'pending'))) and consultationdate between '$fromdate' and '$todate' and $pass_location

                       UNION ALL select patientvisitcode as visitcode,consultationdate as date from consultation_referal where ((billtype like 'pay now' and paymentstatus like 'pending') or (billtype like 'pay later' and paymentstatus <> 'completed' and patientvisitcode in (select visitcode from master_visitentry where planpercentage > 0))) and consultationdate between '$fromdate' and '$todate' and referalrate > 0 and $pass_location

                       UNION ALL select patientvisitcode as visitcode,recorddate as date from master_consultationpharm where ((billtype like 'pay now' and pharmacybill like 'pending' and amendstatus = '2') or (billtype like 'pay later' and pharmacybill like 'pending' and patientvisitcode in (select visitcode from master_visitentry where planpercentage > 0) and amendstatus = '2')) and recorddate between '$fromdate' and '$todate' and $pass_location

					   UNION ALL select visitcode as visitcode,consultationdate as date from master_visitentry where paymentstatus <> 'completed' and consultationdate between '$fromdate' and '$todate' and $pass_location) as viscode  group by visitcode order by date ASC";

				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $qry12) or die("Error in Qry12 ". mysqli_error($GLOBALS["___mysqli_ston"]));

				while($res12 = mysqli_fetch_array($exec12))

				{

				$visitcode  = $res12['visitcode'];

				$qry1 = "select patientfullname,patientcode,visitcode,consultationdate,consultationfees,planname,subtype,paymentstatus,billtype,accountfullname from master_visitentry where visitcode = '$visitcode'";

				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die("Error in Qry1 ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$res1 = mysqli_fetch_array($exec1);

				$res1patientfullname = $res1['patientfullname'];

				$res1patientcode = $res1['patientcode'];

				$res1visitcode = $res1['visitcode'];

				$res1consultationdate = $res1['consultationdate'];

				$consultationfee = 0;

				$labfee = 0;

				$radfee = 0;

				$servicefee = 0;

				$pahrmfee = 0;

				$planfixedamount = 0;

				$planpercentage = 0;

				$forall = '';

				$billtype = $res1['billtype'];

				$subtype = $res1['subtype'];

				if($res1['planname'] !='')

				{

				$plananum = $res1['planname'];

				$subtype = $res1['subtype'];

				$qryplan = "select planfixedamount,planpercentage,forall from master_planname where auto_number = '$plananum'";

				$execplan = mysqli_query($GLOBALS["___mysqli_ston"], $qryplan) or die("Error in Qryplan ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$resplan = mysqli_fetch_array($execplan);

				$planfixedamount = $resplan['planfixedamount'];

				$planpercentage = $resplan['planpercentage'];

				$forall = $resplan['forall'];

				}

				$qrysub  = "select fxrate from master_subtype where auto_number = '$subtype'";

				$execsub = mysqli_query($GLOBALS["___mysqli_ston"], $qrysub) or die("Error in Qrysub ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$ressub = mysqli_fetch_array($execsub);

				$fxrate = $ressub['fxrate'];

				if($res1['paymentstatus'] != 'completed')

				{

				$consultationfee = $res1['consultationfees'];

				if($billtype =='PAY LATER' ){

				if( $forall = 'yes' && $planpercentage > 0)

				{

				$consultationfee  =($consultationfee*$planpercentage/100)*$fxrate;

				}

				else

				{

				$consultationfee  =($planfixedamount)*$fxrate;

				}

				}

				}

				if($forall =='' && $billtype =='PAY LATER')

				{

				$qrylab  = "select sum(labitemrate) as labamount from consultation_lab where patientvisitcode = '$res1visitcode' and patientcode = '$res1patientcode' and paymentstatus <> 'completed' and approvalstatus = '2' and consultationdate between '$fromdate' and '$todate'";

				}

				else

				{

				$qrylab  = "select sum(labitemrate) as labamount from consultation_lab where patientvisitcode = '$res1visitcode' and patientcode = '$res1patientcode' and paymentstatus <>'completed' and consultationdate between '$fromdate' and '$todate'";

				}

				$execlab = mysqli_query($GLOBALS["___mysqli_ston"], $qrylab) or die("Error in Qrylab ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$reslab = mysqli_fetch_array($execlab);

				$labfee = $reslab['labamount'];

				if($forall == 'yes' && $planpercentage > 0)

				{

				$labfee = ($labfee*$planpercentage/100)*$fxrate;

				}

				if($forall =='' && $billtype =='PAY LATER')

				{

				$qryrad  = "select sum(radiologyitemrate) as radamount from consultation_radiology where patientvisitcode = '$res1visitcode' and patientcode = '$res1patientcode' and paymentstatus <> 'completed' and approvalstatus = '2' and consultationdate between '$fromdate' and '$todate'";

				}

				else

				{

				$qryrad  = "select sum(radiologyitemrate) as radamount from consultation_radiology where patientvisitcode = '$res1visitcode' and patientcode = '$res1patientcode' and paymentstatus <>'completed' and consultationdate between '$fromdate' and '$todate'";

				}

				$execrad = mysqli_query($GLOBALS["___mysqli_ston"], $qryrad) or die("Error in Qryrad ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$resrad = mysqli_fetch_array($execrad);

				$radfee = $resrad['radamount'];

				if($forall == 'yes' && $planpercentage > 0)

				{

				$radfee = ($radfee*$planpercentage/100)*$fxrate;

				}

				if($forall =='' && $billtype =='PAY LATER')

				{

				$qryser  = "select sum(amount) as seramount from consultation_services where patientvisitcode = '$res1visitcode' and patientcode = '$res1patientcode' and paymentstatus <> 'completed' and approvalstatus = '2' and consultationdate between '$fromdate' and '$todate'";

				}

				else

				{

				$qryser  = "select sum(amount) as seramount from consultation_services where patientvisitcode = '$res1visitcode' and patientcode = '$res1patientcode' and paymentstatus <>'completed' and consultationdate between '$fromdate' and '$todate'";

				}

				$execser = mysqli_query($GLOBALS["___mysqli_ston"], $qryser) or die("Error in Qryser ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$resser = mysqli_fetch_array($execser);

				$servicefee = $resser['seramount'];

				if($forall == 'yes' && $planpercentage > 0)

				{

				$servicefee = ($servicefee*$planpercentage/100)*$fxrate;

				}

				

				$qrypharm  = "select sum(amount) as pharmamount from master_consultationpharm where patientvisitcode = '$res1visitcode' and patientcode = '$res1patientcode' and pharmacybill = 'pending' and amendstatus = '2' and recorddate between '$fromdate' and '$todate'";

				$execpharm = mysqli_query($GLOBALS["___mysqli_ston"], $qrypharm) or die("Error in qrypharm ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$respharm = mysqli_fetch_array($execpharm);

				$pharmfee = $respharm['pharmamount'];

				if($forall == 'yes' && $planpercentage > 0)

				{

				$pharmfee = $pharmfee*$planpercentage/100;

				}

				$qryref  = "select sum(referalrate) as refamount from consultation_referal where patientvisitcode = '$res1visitcode' and patientcode = '$res1patientcode' and paymentstatus <> 'completed'  and consultationdate between '$fromdate' and '$todate'";

				

				$execref = mysqli_query($GLOBALS["___mysqli_ston"], $qryref) or die("Error in qryref ". mysqli_error($GLOBALS["___mysqli_ston"]));

				$resref = mysqli_fetch_array($execref);

				$referalfee = $resref['refamount'];

				

				$colorloopcount = $colorloopcount + 1;

			  $showcolor = ($colorloopcount & 1); 

			  $colorcode = '';

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

				<tr >

					<td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>

					<td  align="left" valign="center" class="bodytext31"><?php echo $res1patientfullname; ?></td>

					<td  align="left" valign="center" class="bodytext31"><?php echo $res1patientcode; ?></td>

					<td  align="left" valign="center" class="bodytext31"><?php echo $res1visitcode; ?></td>

					<td  align="left" valign="center" class="bodytext31"><?php echo $res1consultationdate; ?></td>

					<td  align="left" valign="center" class="bodytext31"><?php echo $res1['accountfullname']; ?></td>

					<td  align="right" valign="center" class="bodytext31"><?php echo number_format($consultationfee,2,'.',','); ?></td>

					<td  align="right" valign="center" class="bodytext31"> <?php echo number_format($pharmfee,2,'.',','); ?></td>

					<td  align="right" valign="center" class="bodytext31"><?php echo number_format($labfee,2,'.',','); ?></td>

					<td  align="right" valign="center" class="bodytext31"><?php echo number_format($servicefee,2,'.',','); ?></td>

					<td  align="right" valign="center" class="bodytext31"><?php echo number_format($radfee,2,'.',','); ?></td>

					<td  align="right" valign="center" class="bodytext31"><?php echo number_format($referalfee,2,'.',','); ?></td>

				</tr>

			  <?php 

				$totalconsultation += $consultationfee;

				$totalpharma += $pharmfee;

				$totallab += $labfee;

				$totalrad += $radfee;

				$totalser += $servicefee;

				$totalref += $referalfee;

				

			   }

			  ?>

			 

			<tr>

				<td class="bodytext31" valign="center"  align="left" 

				bgcolor="#ecf0f5">&nbsp;</td>

				<td  align="left" valign="center" 

				bgcolor="#ecf0f5" class="bodytext31"><strong>Grand Total :</strong></td>

				<td class="bodytext31" valign="center"  align="left" 

				bgcolor="#ecf0f5"><strong><?php $grandtotal = $totalconsultation +$totalpharma +$totallab +$totalrad +$totalser +$totalref ; echo number_format($grandtotal,2,'.',','); ?></strong></td>

				

				<td colspan="2" class="bodytext31" valign="center"  align="left" 

				bgcolor="#ecf0f5"></td>

				<td class="bodytext31" valign="center"  align="left" 

				bgcolor="#ecf0f5"><strong>Total :</strong></td>

				

			

				<td  class="bodytext31" valign="center"  align="right" 

				bgcolor="#ecf0f5"><strong><?php echo number_format($totalconsultation,2,'.',','); ?></strong></td>

					<td  class="bodytext31" valign="center"  align="right" 

				bgcolor="#ecf0f5"><strong><?php echo number_format($totalpharma,2,'.',','); ?></strong></td>

					<td  class="bodytext31" valign="center"  align="right" 

				bgcolor="#ecf0f5"><strong><?php echo number_format($totallab,2,'.',','); ?></strong></td>

					<td  class="bodytext31" valign="center"  align="right" 

				bgcolor="#ecf0f5"><strong><?php echo number_format($totalser,2,'.',','); ?></strong></td>

					<td class="bodytext31" valign="center"  align="right" 

				bgcolor="#ecf0f5"><strong><?php echo number_format($totalrad,2,'.',','); ?></strong></td>

					<td class="bodytext31" valign="center"  align="right" 

				bgcolor="#ecf0f5"><strong><?php echo number_format($totalref,2,'.',','); ?></strong></td>

			</tr>
<?php
}
?>
			 
</tbody>
</table>


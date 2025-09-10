<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];



header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="Patientvisitwise.xls"');

header('Cache-Control: max-age=80');



$searchcustomername = '';

$patientfirstname = '';

$visitcode = '';

$customername = '';

$cbcustomername = '';

$cbbillnumber = '';

$cbbillstatus = '';

$customername = '';

$paymenttype = '';

$billstatus = '';

$res2loopcount = '';

$custid = '';

$visitcode1='';

$custname = '';

$colorloopcount = '';

$sno = '';

$customercode = '';

$totalsalesamount = '0.00';

$totalsalesreturnamount = '0.00';

$netcollectionamount = '0.00';

$netpaymentamount = '0.00';

$res2total = '0.00';

$total1 = '0.00';

$total2 = '0.00';

$total3 = '0.00';

$total4 = '0.00';

$total5 = '0.00';



$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');



 $locationcode1=isset($_REQUEST['locationcode1'])?$_REQUEST['locationcode1']:'';

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 
 $department=isset($_REQUEST['department'])?$_REQUEST['department']:'';
 
if($locationcode1=='All')
{
$pass_location = "locationcode !=''";
}
else
{
$pass_location = "locationcode ='$locationcode1'";
}

//$getcanum = $_GET['canum'];



if ($getcanum != '')

{

	$query4 = "select * from master_customer where auto_number = '$getcanum'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res4 = mysqli_fetch_array($exec4);

	$cbcustomername = $res4['customername'];

	$customername = $res4['customername'];

}



if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{

}

?>

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #FFF;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

-->

</style>

	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="100%" 

            align="left" border="1">

          <tbody>

		  <tr>

		  <td colspan="11"><strong>Patient Visitwise Report</strong></td>

		  </tr>

                <?php

				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }

				$patientfirstname = $cbcustomername;

				if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

				if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

				$transactiondatefrom = $ADate1;

				$transactiondateto = $ADate2;

				if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

				if (isset($_REQUEST["locationcode1"])) { $locationcode1 = $_REQUEST["locationcode1"]; } else { $locationcode1 = ""; }

				?>

            <tr>

              <td width="4%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>S.No</strong></td>
                
                 <td width="4%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Location</strong></td>

				<td width="19%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Patient </strong></td>

              <td width="8%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Reg No. </strong></td>

              <td width="8%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Visit Code  </strong></td>

				<td width="7%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Visit Date  </strong></td>

              <td width="15%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong> Account </strong></td>
                
                 <td width="4%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Department</strong></td>

				<td width="7%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong> Pharmacy </strong></div></td>

              <td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Radiology </strong></div></td>

              <td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Lab</strong></div></td>

				<td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Service</strong></div></td>

				<td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total</strong></div></td>

				

            </tr>

			<?php

			$dotarray = explode("-", $transactiondateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				

				if (true)

				{
if($department!='')
{
			$query2 = "select * from master_visitentry where $pass_location and patientfullname like '%$patientfirstname%' and visitcode like '%$visitcode%' and consultationdate between '$transactiondatefrom' and '$transactiondateto' and department='$department' order by patientcode";
}
else
{
	$query2 = "select * from master_visitentry where $pass_location and patientfullname like '%$patientfirstname%' and visitcode like '%$visitcode%' and consultationdate between '$transactiondatefrom' and '$transactiondateto' order by patientcode";
}
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			while ($res2 = mysqli_fetch_array($exec2))

			{

			$res2patientcode = $res2['patientcode'];

			$res2visitcode = $res2['visitcode'];

			$res2patientfirstname = $res2['patientfirstname'];

			$res2patientmiddlename = $res2['patientmiddlename'];

			$res2patientlastname = $res2['patientlastname'];

			$res2accountname = $res2['accountname'];

			$res2billtype = $res2['billtype'];

			$res2consultationdate = $res2['consultationdate'];
			
			$res2locationcode = $res2['locationcode'];
			
			$res2departmentname = $res2['departmentname'];

		    $res2patientname = $res2patientfirstname.' '.$res2patientmiddlename.' '.$res2patientlastname;

			

			$query4 = "select * from master_accountname where  auto_number = '$res2accountname'";

		    $exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res4 = mysqli_fetch_array($exec4);

		    $res4accountname = $res4['accountname'];
			
		$query48 = "select locationname from master_location where locationcode = '$res2locationcode'";

		$exec48 = mysqli_query($GLOBALS["___mysqli_ston"], $query48) or die ("Error in Query48".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res48 = mysqli_fetch_array($exec48);

		$res4locationname= $res48['locationname'];

			

			if($res2billtype == 'PAY LATER')

			{

			$query5 = "select sum(amount) as pharmacyitemrate1 from billing_paylaterpharmacy where $pass_location and patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode'";

			}

			else 

			{

			$query5 = "select sum(amount) as pharmacyitemrate1 from billing_paynowpharmacy where $pass_location and patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode'";

			}

		    $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res5 = mysqli_fetch_array($exec5);

		    //$res5pharmacyitemrate = $res5['amount'];

			$res5pharmacyitemrate1 = $res5['pharmacyitemrate1'];

			

			if($res2billtype == 'PAY LATER')

			{

			$query6 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paylaterradiology where $pass_location and patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode'";

			}

			else 

			{

			$query6 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paynowradiology where $pass_location and patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode'";

			}

		    $exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res6 = mysqli_fetch_array($exec6);

		    //$res6radiologyitemrate = $res6['radiologyitemrate'];

			$res6radiologyitemrate1 = $res6['radiologyitemrate1'];

			

			if($res2billtype == 'PAY LATER')

			{

			$query7 = "select sum(labitemrate) as labitemrate1 from billing_paylaterlab where $pass_location and patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode'";

			}

			else 

			{

			$query7 = "select sum(labitemrate) as labitemrate1 from billing_paynowlab where $pass_location and patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode'";

			}

		    $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res7 = mysqli_fetch_array($exec7);

		    //$res7labitemrate = $res7['labitemrate'];

			$res7labitemrate1 = $res7['labitemrate1'];

			

			if($res2billtype == 'PAY LATER')

			{

			$query8 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paylaterservices where $pass_location and patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode'";

			}

			else 

			{

			$query8 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paynowservices where $pass_location and patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode'";

			}

		    $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res8 = mysqli_fetch_array($exec8);

		    //$res8servicesitemrate = $res8['servicesitemrate'];

			$res8servicesitemrate1 = $res8['servicesitemrate1'];

			

			$total = $res5pharmacyitemrate1 + $res6radiologyitemrate1 + $res7labitemrate1 + $res8servicesitemrate1;

			$total1 = $total1 + $res5pharmacyitemrate1;

			$total2 = $total2 + $res6radiologyitemrate1;

			$total3 = $total3 + $res7labitemrate1;

			$total4 = $total4 + $res8servicesitemrate1;

			$total5 = $total5 + $total;

			

			$colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

			if ($showcolor == 0)

			{

				$colorcode = 'bgcolor="#FFF"';

			}

			else

			{

				$colorcode = 'bgcolor="#FFF"';

			}



			?>

            <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
              
              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res4locationname; ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res2patientname; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res2patientcode; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31"><?php echo $res2consultationdate; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res4accountname; ?></div></td>
                
                <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res2departmentname; ?></div></td>

				<td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($res5pharmacyitemrate1,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($res6radiologyitemrate1,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($res7labitemrate1,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($res8servicesitemrate1,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($total,2,'.',','); ?></div></td>

				

            </tr>

			<?php

			}

			}

			?>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#fff">&nbsp;</td>
                
                  <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#fff">&nbsp;</td>
                
                  <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#fff">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#fff">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#fff">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#fff">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#fff">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#fff"><strong>Total:</strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#fff"><strong><?php echo number_format($total1,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#fff"><strong><?php echo number_format($total2,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#fff"><strong><?php echo number_format($total3,2,'.',','); ?></strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#fff"><strong><?php echo number_format($total4,2,'.',','); ?></strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#fff"><strong><?php echo number_format($total5,2,'.',','); ?></strong></td>

            </tr>

      

          </tbody>

    </table></td>

      </tr>

    </table>

  </table>

</body>

</html>




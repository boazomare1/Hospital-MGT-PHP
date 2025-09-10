<?php

session_start();



header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="chartofaccounts.xls"');

header('Cache-Control: max-age=80');



//include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = '';

$companyanum = '';

$companyname = '';

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$accountname2=isset($_REQUEST['accountname1'])?$_REQUEST['accountname1']:'';

?>

<style type="text/css">

<!--

body {

	

	background-color: #FFFFFF;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

-->

</style>

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

        <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 

            align="left" border="1">

          <tbody>

            <tr>

              <td width="13%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account Main</strong></div></td>

				<td width="15%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account Sub</strong></div></td>

              <td width="12%" align="left" valign="right"  

                bgcolor="#ffffff" class="bodytext31"><strong>Id</strong></td>

              <td width="29%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Account Name</strong></td>

              <td width="10%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Expiry Date</strong></div></td>

				<td width="11%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Payment Type</strong></div></td>

              <td width="10%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Sub Type</strong></div></td>

			 <td width="10%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>MIS Report</strong></div></td>
				
				<td width="10%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Cost Center</strong></div></td>

			  </tr>

          <?php

		  $accquery="select accountname,id,paymenttype,subtype,accountsmain,accountssub,expirydate,misreport,cost_center from master_accountname where recordstatus <>'DELETED' and accountname like '%$accountname2%' order by accountssub asc";

		  $exeqry=mysqli_query($GLOBALS["___mysqli_ston"], $accquery) or die("Error in accquery".mysqli_error($GLOBALS["___mysqli_ston"]));

		  while($resqry=mysqli_fetch_array($exeqry))

		  {

			  $accountname=$resqry['accountname'];

			  $id=$resqry['id'];

			  $paymenttype=$resqry['paymenttype'];

			  $subtype=$resqry['subtype'];

			  $accountsmain=$resqry['accountsmain'];

			  $accountssub=$resqry['accountssub'];

			  $expirydate=$resqry['expirydate'];
			  
			  $resqrycost_center=$resqry['cost_center'];

$query612 = "select * from master_costcenter where auto_number = '$resqrycost_center' and recordstatus <> 'deleted'";

		$exec612 = mysqli_query($GLOBALS["___mysqli_ston"], $query612) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$res612 = mysqli_fetch_array($exec612);

		$cost_center = $res612['name'];




			   $misreport=$resqry['misreport'];

               if($misreport==1)

				   $reportnamr='NHIF CAPITATION';

			   elseif($misreport==2)

				   $reportnamr='AON CAPITATION';

			   elseif($misreport==3)

				   $reportnamr='CASH';

			   elseif($misreport==4)

				   $reportnamr='NHIF';

			   elseif($misreport==5)

				   $reportnamr='FREE FOR SERVICE';

			   else

                  $reportnamr='';

			  

			  $payment=mysqli_query($GLOBALS["___mysqli_ston"], "select paymenttype from master_paymenttype where auto_number='$paymenttype'")or die("Error in payment".mysqli_error($GLOBALS["___mysqli_ston"]));

			  $respay=mysqli_fetch_array($payment);

			  $paymenttype1=$respay['paymenttype'];

			  

			   $sub=mysqli_query($GLOBALS["___mysqli_ston"], "select subtype from master_subtype where auto_number='$subtype'")or die("Error in sub".mysqli_error($GLOBALS["___mysqli_ston"]));

			  $ressub=mysqli_fetch_array($sub);

			  $subtype1=$ressub['subtype'];

			  

	$accountmain=mysqli_query($GLOBALS["___mysqli_ston"], "select accountsmain from master_accountsmain where auto_number='$accountsmain'")or die("Error in accountmanin".mysqli_error($GLOBALS["___mysqli_ston"]));

			  $resaccount=mysqli_fetch_array($accountmain);

			  $accountmain1=$resaccount['accountsmain'];

			  

			   $accountsub=mysqli_query($GLOBALS["___mysqli_ston"], "select accountssub from master_accountssub where auto_number='$accountssub'")or die("Error in payment".mysqli_error($GLOBALS["___mysqli_ston"]));

			  $resaccountsub=mysqli_fetch_array($accountsub);

			  $accountsub1=$resaccountsub['accountssub'];

			  ?>

              <tr>

              <td width="13%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><?=$accountmain1;?></div></td>

				<td width="15%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><?=$accountsub1;?></div></td>

              <td width="12%" align="left" valign="right"  

                bgcolor="#ffffff" class="bodytext31"><?="'".$id;?></td>

              <td width="29%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><?=$accountname;?></td>

              <td width="10%" align="left" valign="center"  

                bgcolor="#ffffff"  style="mso-number-format:'\@'"><div align="right"><?=$expirydate;?></div></td>

				

				<td width="11%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><?=$paymenttype1;?></div></td>

              <td width="10%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><?=$subtype1;?></div></td>

				<td width="10%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><?=$reportnamr;?></div></td>
				
				<td width="10%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><?=$cost_center;?></div></td>

			  </tr>

              <?php

		  }

		  ?>

          </tbody>

        </table></td>

      </tr>

	  

    </table>

</table>

</body>

</html>


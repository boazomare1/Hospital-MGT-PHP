<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');



/*header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="Radiology Test Counts.xls"');

header('Cache-Control: max-age=80');*/



$searchsuppliername = '';

$suppliername = '';

$cbsuppliername = '';

$cbcustomername = '';

$cbbillnumber = '';

$cbbillstatus = '';

$colorloopcount = '';

$sno = '';

$snocount = '';

$visitcode1 = '';

$total = '';

$looptotalpaidamount = '0.00';

$looptotalpendingamount = '0.00';

$looptotalwriteoffamount = '0.00';

$looptotalcashamount = '0.00';

$looptotalcreditamount = '0.00';

$looptotalcardamount = '0.00';

$looptotalonlineamount = '0.00';

$looptotalchequeamount = '0.00';

$looptotaltdsamount = '0.00';

$looptotalwriteoffamount = '0.00';

$pendingamount = '0.00';

$accountname = '';

$slocation = '';

$amount = 0;



if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }

if (isset($_REQUEST["radiology"])) { $radiology = $_REQUEST["radiology"]; } else { $radiology = ""; }

if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }

if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

//$getcanum = $_GET['canum'];

if ($getcanum != '')

{

	$query4 = "select * from master_supplier where auto_number = '$getcanum'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res4 = mysqli_fetch_array($exec4);

	$cbsuppliername = $res4['suppliername'];

	$suppliername = $res4['suppliername'];

}



if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

?>

 
 
<style>

.xlText {

    mso-number-format: "\@";

}

</style>



</head>



<body>

<table  border="0" cellspacing="0" cellpadding="2">

  <tr>
  	<?php $ADate1 = $_GET['ADate1'];
			$ADate2 = $_GET['ADate2']; ?>

<td colspan="1"  align="center" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Radiology Test Counts Report</strong></td>

 </tr>
 <tr>
 	<td colspan="1"  align="center" valign="center" bgcolor="#ffffff" class="bodytext31"><?php echo $ADate1; ?> To <?php echo $ADate2; ?></td>

 </tr>

 

  <tr>

    <!-- <td width="1%">&nbsp;</td> -->

    <td  valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

     

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td><table  >

          <tbody>
          	 

            

           <tr>

              <td   align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>

             <!--  <td width="9%" align="left" valign="left"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill Date</strong></div></td> -->

             <!--  <td width="9%" align="left" valign="left"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg Code</strong></div></td>

              <td width="9%" align="left" valign="center"  

                bgcolor="#ffffff" class="style1">Visit Code</td>

              <td width="16%" align="left" valign="left"  

                bgcolor="#ffffff" class="style1"><div align="left"><strong>Patitent Name</strong></div></td> -->

              <td  align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Code</strong></div></td>

                <td  align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Name</strong></div></td>

                <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>OP</strong></div></td>

                <td   align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>IP</strong></div></td>

                <td   align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total</strong></div></td>  

            </tr>

            

			<?php

			$num1=0;

			$num2=0;

			$num3=0;

			$num6=0;

			$grandtotal = 0;

			$res2itemname = '';
			

			$ADate1 = $_GET['ADate1'];
			$ADate2 = $_GET['ADate2'];
			$radiology = $_GET['radiology'];
			$cbfrmflag1 = $_GET['cbfrmflag1'];
			
			if($location=='All')
			{
			$pass_location = "locationcode !=''";
			}
			else
			{
			$pass_location = "locationcode ='$location'";
			}	
			

		    if($cbfrmflag1 == 'cbfrmflag1')

			{

			 $j = 0;
			 $op1=0;
			 $op2=0;
			 $op3=0;
			 $ip=0;
			 $count_op=0;
			 $count_op1=0;
			 $count_op2=0;
			 $count_ip=0;
			 $count_ip1=0;
			 $count_ip2=0;



				 $query1 = "SELECT itemname,itemcode,auto_number from master_radiology where itemname LIKE '%$radiology%' and status <> 'deleted' and $pass_location group by itemname";

				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

				while ($res1 = mysqli_fetch_array($exec1))

				{
					$itemcode=$res1['itemcode'];
					$itemname=$res1['itemname'];

			 // $querycr1in_op = "SELECT count(*) FROM (
			 	$sql1 = "SELECT '0' as ipcount, count(auto_number) as count FROM `billing_paynowradiology`  WHERE radiologyitemcode='$itemcode' AND billdate BETWEEN '$ADate1' AND '$ADate2' and $pass_location";

						 $sql2="SELECT '0' as ipcount, count(auto_number) as count FROM `billing_externalradiology`  WHERE radiologyitemcode='$itemcode' AND billdate BETWEEN '$ADate1' AND '$ADate2' and $pass_location ";

						    $sql3="SELECT '0' as ipcount, count(auto_number) as count FROM `billing_paylaterradiology`  WHERE radiologyitemcode='$itemcode' AND billdate BETWEEN '$ADate1' AND '$ADate2' and $pass_location"; 
						   $sql4="SELECT count(auto_number) as ipcount,'0' as count FROM `billing_ipradiology`  WHERE radiologyitemcode='$itemcode' AND billdate BETWEEN '$ADate1' AND '$ADate2'  and $pass_location";
					
						   

						   $exc1 = mysqli_query($GLOBALS["___mysqli_ston"], $sql1) or die ("Error in sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
						   $exc2 = mysqli_query($GLOBALS["___mysqli_ston"], $sql2) or die ("Error in sql2".mysqli_error($GLOBALS["___mysqli_ston"]));
						   $exc3 = mysqli_query($GLOBALS["___mysqli_ston"], $sql3) or die ("Error in sql3".mysqli_error($GLOBALS["___mysqli_ston"]));
						   $exc4 = mysqli_query($GLOBALS["___mysqli_ston"], $sql4) or die ("Error in sql4".mysqli_error($GLOBALS["___mysqli_ston"]));
						   while($res_op1 = mysqli_fetch_array($exc1)) { $op1=$res_op1['count']; }
						   while($res_op2 = mysqli_fetch_array($exc2)) { $op2=$res_op2['count']; }
						   while($res_op3 = mysqli_fetch_array($exc3)) { $op3=$res_op3['count']; }
						   while($res_op4 = mysqli_fetch_array($exc4)) { $ip=$res_op4['ipcount']; }

						     // $rowcount_op=mysql_num_rows($execcr1_op);
						      
						     $count_op = $op1+$op2+$op3;
						     $count_ip = $ip; 
						     if(($count_op!=0) || ($count_ip!=0)){
						     // if(1){
								$j+=1;
								$colorloopcount = $colorloopcount + 1;
								$showcolor = ($colorloopcount & 1); 
								if ($showcolor == 0)
								{
								$colorcode = 'bgcolor="#CBDBFA"';
								}
								else{
								$colorcode = 'bgcolor="#ecf0f5"';
								}
								

						     ?>

						     <tr <?php echo $colorcode; ?>>
				<td class="bodytext31" valign="center" align="left"><?php echo $j; ?></td>
				<td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $itemcode; ?></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $itemname; ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $count_op; ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $count_ip; ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $count_op+$count_ip; ?></div></td>
            </tr>

			<?php } } ?>

         
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




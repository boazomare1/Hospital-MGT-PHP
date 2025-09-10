<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedate = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$updatetime = date('H:i:s');

$colorloopcount='';

$sno='';



header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="IP_Rebate.xls"');
header('Cache-Control: max-age=80');


?>

 
 
 

</head>



           <?php

            $colorloopcount ='';

			$netamount='';

			if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

			

		//$ADate1='2015-02-01';

		//$ADate2='2015-02-28';

		?>

        <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="400" 

            align="left" border="0">

          <tbody>

            <tr>
              <td colspan="5" bgcolor="#FFFFFF" align="center" class="bodytext31"><strong>Rebate Details</strong></td>

              </tr>            

             <tr <?php //echo $colorcode; ?>>

              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>S.No</strong></td>

              <td align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Doc. No</td>

              <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Date</td>

              <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Visitcode</td>

              <td width="21%" align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Amount</td>

            </tr>



        <?php

		

		  $query9 = "SELECT * FROM `billing_ipnhif` where recorddate between '$ADate1' and '$ADate2'";

		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num9=mysqli_num_rows($exec9);
		$totaldiscountamount='0.00';
		while($res9 = mysqli_fetch_array($exec9))
		{

		$totaldiscount=$res9['amount'];
		$transfferdate=$res9['recorddate'];
		//$dischargeddate=$res13['dischargeddate'];

		$docno=$res9['docno'];

		$visitcode=$res9['visitcode'];

		   $sno=$sno+1;
		   $totaldiscountamount=$totaldiscountamount+$totaldiscount;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 

			if ($showcolor == 0)

			{

				//echo "if";

				$colorcode = 'bgcolor="#FFFFFF"';

			}

			else

			{

				//echo "else";

				$colorcode = 'bgcolor="#FFFFFF"';

			}

			?>

           <tr <?php //echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $docno;?></div> </td>

               <td class="bodytext31" valign="center" align="right"><?php echo $transfferdate;?></td>

               <td class="bodytext31" valign="center" align="right"><?php echo $visitcode;?></td>

            <td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo number_format($totaldiscount,2,'.',','); ?></div></td>

           </tr>

	<?php

		}

?>		

         <tr>

              <td colspan="4"  class="bodytext31" valign="center"  align="right" 

                bgcolor="#FFFFFF"><strong>Total Rebate Amount</strong></td>

              <td align="right" valign="center" 

                bgcolor="#FFFFFF" class="bodytext31"><strong><?php echo number_format($totaldiscountamount,2,'.',','); ?></strong></td>

 

          </tbody>

        </table>

        

			
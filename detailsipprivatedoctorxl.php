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

header('Content-Disposition: attachment;filename="IPdoctor.xls"');

header('Cache-Control: max-age=80');





?>

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

-->

</style>







<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

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



           <?php

            $colorloopcount ='';

			$netamount='';

			if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

			

		//$ADate1='2015-02-01';

		//$ADate2='2015-02-28';

		?>



        <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="686" 

            align="left" border="0">

          <tbody>

            <tr>

              <td width="5%" bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>

              <td colspan="4" bgcolor="#FFFFFF" class="bodytext31"><strong>Private Doctor Charge Details</strong></td>

              <td width="21%" bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>

              </tr>            

			

             <tr <?php //echo $colorcode; ?>>

              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>S.No</strong></td>

              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Doc. No</td>

              <td width="11%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Date</td>

              <td width="15%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Visitcode</td>

              <td width="38%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Doctor</td>

              <td width="21%" align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Amount</td>

            </tr>



        <?php

		

		 $query4 = "SELECT * FROM billing_ipprivatedoctor WHERE `recorddate` BETWEEN '$ADate1' and '$ADate2' and visitcode in (select  visitcode from billing_ip where billdate between '$ADate1' and '$ADate2' 
	 	UNION ALL SELECT visitcode from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' group by visitcode  order by auto_number DESC)";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num4=mysqli_num_rows($exec4);
		$totalprivatedoctorcharges='0.00';
		while($res4 = mysqli_fetch_array($exec4))
		{
		// $totalprivatedoctoramount=$res4['amountuhx'];
		$transfferdate=$res4['recorddate'];
		//$dischargeddate=$res13['dischargeddate'];
		$docno=$res4['docno'];
		$visitcode=$res4['visitcode'];
		// $doctorname=$res4['doctorname'];
		$doccoa=$res4['doccoa'];

		$query_docname = "SELECT doctorname FROM master_doctor WHERE `doctorcode`='$doccoa'";
		$exec_docname = mysqli_query($GLOBALS["___mysqli_ston"], $query_docname) or die ("Error in Query_docname".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res_docname = mysqli_fetch_array($exec_docname);
		$doctorname=$res_docname['doctorname'];
		$doctorname=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $doctorname);

		  // $bedtransferanum = $res13['bed'];

		   if($res4['visittype'] =="IP")
							{
								if($res4['coa'] !="")
								 $totalprivatedoctoramount = $res4['transactionamount'];
								else
								 $totalprivatedoctoramount = $res4['original_amt'];
							}
							else
							{
								$totalprivatedoctoramount = $res4['original_amt'];
							}
			                // $privatedoctoramount      = $res8['sum(transactionamount)'];
			                // $totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctoramount;

		   $totalprivatedoctorcharges=$totalprivatedoctorcharges+$totalprivatedoctoramount;

			if($totalprivatedoctoramount=='0'){
				continue;
			}

			 $sno=$sno+1;

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

           <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $docno;?></div> </td>

               <td class="bodytext31" valign="center" align="left"><?php echo $transfferdate;?></td>

               <td class="bodytext31" valign="center" align="left"><?php echo $visitcode;?></td>

               <td class="bodytext31" valign="center" align="left"><?php echo $doctorname;?></td>

               

            <td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo number_format($totalprivatedoctoramount,2,'.',','); ?></div></td>

           </tr>

	<?php

		}

?>		

         <tr>

              <td colspan="5"  class="bodytext31" valign="center"  align="right" 

                bgcolor="#FFFFFF"><strong>Total Private Doctor Charges:</strong></td>

              <td align="right" valign="center" 

                bgcolor="#FFFFFF" class="bodytext31"><strong><?php echo number_format($totalprivatedoctorcharges,2,'.',','); ?></strong></td>

<!--				<?php if($nettotal != 0.00) { ?>

				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="print_oprevenuereport.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&user=<?php echo $res21username; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>

                

			    <?php 

				}?>

-->		

          </tbody>

        </table>

        

			
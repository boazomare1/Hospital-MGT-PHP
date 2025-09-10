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



header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="IPBed.xls"');

header('Cache-Control: max-age=80');



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

			$totalbedcharges = 0;

			if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

			

		//$ADate1='2015-02-01';

		//$ADate2='2015-02-28';

		?>



        <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 

            align="left" border="1">

          <tbody>

            <tr>

              <!-- <td width="10%" bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td> -->

              <td colspan="8" bgcolor="#FFFFFF" align="center" class="bodytext31"><strong>Bed Charge Details</strong></td>

              <!-- <td width="10%" bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td> -->

              </tr>            

			

             <tr <?php //echo $colorcode; ?>>

              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>S.No</strong></td>
              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>Patient Code</strong></td>
              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>Patient Name</strong></td>
              <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Visitcode</strong></td>

              <td align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Doc. No</strong></td>
              <td align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Bed</strong></td>

              <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Date</strong></td>

              

              <td width="21%" align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Amount</strong></td>

            </tr>



        <?php

		$sno=0;
		$totalbedtransfercharges =0;

		$query66 = "select * from master_ipvisitentry where visitcode NOT IN (select visitcode from billing_ip) and consultationdate between '$ADate1' and '$ADate2'";

		$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));

		while($res66 = mysqli_fetch_array($exec66))

		{

			$patientcode = $res66['patientcode'];

			$visitcode = $res66['visitcode'];

		

			

			$querymenu = "select * from master_customer where customercode='$patientcode'";

			$execmenu = mysqli_query($GLOBALS["___mysqli_ston"], $querymenu) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$nummenu=mysqli_num_rows($execmenu);

			$resmenu = mysqli_fetch_array($execmenu);

			$menusub=$resmenu['subtype'];
			$customerfullname=$resmenu['customerfullname'];

			

			$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$menusub'");

			$execsubtype=mysqli_fetch_array($querysubtype);

			$patientsubtype1=$execsubtype['subtype'];

			$bedtemplate=$execsubtype['bedtemplate'];

			$labtemplate=$execsubtype['labtemplate'];

			$radtemplate=$execsubtype['radtemplate'];

			$sertemplate=$execsubtype['sertemplate'];

			$querytt32 = "select * from master_testtemplate where templatename='$bedtemplate'";

			$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$numtt32 = mysqli_num_rows($exectt32);

			$exectt=mysqli_fetch_array($exectt32);

			$bedtable=$exectt['referencetable'];

			if($bedtable=='')

			{

				$bedtable='master_bed';

			}

			$bedchargetable=$exectt['templatename'];

			if($bedchargetable=='')

			{

				$bedchargetable='master_bedcharge';

			}

		

			$query32 = "select currency,fxrate,subtype from master_subtype where auto_number = '".$menusub."'";

			$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			$mastervalue = mysqli_fetch_array($exec32);

			$currency=$mastervalue['currency'];

			$fxrate=$mastervalue['fxrate'];

			$subtype=$mastervalue['subtype'];

		

		$query17 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";

			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res17 = mysqli_fetch_array($exec17);

			$consultationfee=$res17['admissionfees'];

			$consultationfee = number_format($consultationfee,2,'.','');

			$viscode=$res17['visitcode'];

			$consultationdate=$res17['consultationdate'];

			$packchargeapply = $res17['packchargeapply'];

			$packageanum1 = $res17['package'];

			

		

			$query53 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";

			$exec53 = mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res53 = mysqli_fetch_array($exec53);

			$refno = $res53['docno'];

			

					  $packageamount = 0;

					  $packageamountuhx=0;

			 $query731 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";

			$exec731 = mysqli_query($GLOBALS["___mysqli_ston"], $query731) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res731 = mysqli_fetch_array($exec731);

			$packageanum1 = $res731['package'];

			$packagedate1 = $res731['consultationdate'];

			$packageamount = $res731['packagecharge'];

			

			$query741 = "select * from master_ippackage where auto_number='$packageanum1'";

			$exec741 = mysqli_query($GLOBALS["___mysqli_ston"], $query741) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res741 = mysqli_fetch_array($exec741);

			$packdays1 = $res741['days'];

			$packagename = $res741['packagename'];

			

			$packageamountuhx=$packageamount*$fxrate;

			 

			$totalbedallocationamount = 0;

			$totalbedallocationamountuhx=0;

			 $requireddate = '';

			 $quantity = '';

			 $allocatenewquantity = '';

			$query18 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";

			$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res18 = mysqli_fetch_array($exec18);

			$ward = $res18['ward'];

			$allocateward = $res18['ward'];

			

			$bed = $res18['bed'];

			$refno = $res18['docno'];

			$date = $res18['recorddate'];

			$bedallocateddate = $res18['recorddate'];

			$packagedate = $res18['recorddate'];

			$newdate = $res18['recorddate'];

			

			

			$query73 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";

			$exec73 = mysqli_query($GLOBALS["___mysqli_ston"], $query73) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res73 = mysqli_fetch_array($exec73);

			$packageanum = $res73['package'];

			$type = $res73['type'];

			

			

			$query74 = "select * from master_ippackage where auto_number='$packageanum'";

			$exec74 = mysqli_query($GLOBALS["___mysqli_ston"], $query74) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res74 = mysqli_fetch_array($exec74);

			$packdays = $res74['days'];

			

		   $query51 = "select * from `$bedtable` where auto_number='$bed'";

		   $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		   $res51 = mysqli_fetch_array($exec51);

		   $bedname = $res51['bed'];

		   $threshold = $res51['threshold'];

		   $thresholdvalue = $threshold/100;

		   

			

			  

			   $totalbedallocationamount=0;

			   $totalbedallocationamountuhx=0;

				$query18 = "select ward,bed,docno,recorddate,leavingdate,recordstatus from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";

				$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

				while($res18 = mysqli_fetch_array($exec18))

				{

					$ward = $res18['ward'];

					$allocateward = $res18['ward'];			

					$bed = $res18['bed'];

					$refno = $res18['docno'];

					$date = $res18['recorddate'];

					$bedallocateddate = $res18['recorddate'];

					$packagedate = $res18['recorddate'];

					$leavingdate = $res18['leavingdate'];

					$recordstatus = $res18['recordstatus'];

					if($leavingdate=='0000-00-00')

					{

						$leavingdate=$updatedate;

					}

					$query51 = "select bed,threshold from `$bedtable` where auto_number='$bed'";

					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

					$res51 = mysqli_fetch_array($exec51);

					$bedname = $res51['bed'];

					$threshold = $res51['threshold'];

					$thresholdvalue = $threshold/100;

					$time1 = new DateTime($bedallocateddate);

					$time2 = new DateTime($leavingdate);

					$interval = $time1->diff($time2);			  

					$quantity1 = $interval->format("%a");

					if($packdays1>$quantity1)

					{

						$quantity1=$quantity1-$packdays1; 

						$packdays1=$packdays1-$quantity1;

					}

					else

					{

						$quantity1=$quantity1-$packdays1;

						$packdays1=0;

					}

					$quantity='0';
					

					$diff = abs(strtotime($leavingdate) - strtotime($bedallocateddate));

					$query91 = "select charge,(rate) as rate1 from `$bedchargetable` where bedanum='$bed' and recordstatus ='' and charge not in ('Accommodation Charges','Cafetaria Charges')";

					$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

					$num91 = mysqli_num_rows($exec91);

					while($res91 = mysqli_fetch_array($exec91))
					// $res91 = mysql_fetch_array($exec91);
						// if(1)

					{

						$charge = $res91['charge'];

						$rate = $res91['rate1'];	

						

						if($charge!='Bed Charges')

						{

							//$quantity=$quantity1+1;

							if($recordstatus=='discharged')

							{

								if($bedallocateddate==$leavingdate)

								{

									$quantity=$quantity1+1;

								}

								else

								{

									$quantity=$quantity1;

								}

							}

							else

							{

								$quantity=$quantity1;

							}

						}

						else

						{

							if($recordstatus=='discharged')

							{

								if($bedallocateddate==$leavingdate)

								{

									$quantity=$quantity1+1;

								}

								else

								{

									$quantity=$quantity1;

								}

							}

							else

							{

								$quantity=$quantity1;

							}

						}

						$amount = $quantity * $rate;						

						$allocatequantiy = $quantity;

						$allocatenewquantity = $quantity;

						if($quantity>0)

						{

							if($type=='hospital'||$charge!='Resident Doctor Charges')

							{
 

								$amountuhx = $rate*$quantity;

								$amountuhx1 = $amountuhx*$fxrate;

								$totalbedcharges = $totalbedcharges + ($amountuhx1);

					  

							}

						}


						////////// ip bed transfer ///

						////////// ip bed transfer ///

					
						if($amountuhx1>0){
				
							$sno = $sno + 1;
			$colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

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

           <tr <?php // echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $patientcode; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $customerfullname; ?></td>
              <td class="bodytext31" valign="center" align="right"><?php echo $visitcode;?></td>

               <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php echo $refno;?></div> </td>
               <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php echo $bedname;?></div> </td>

               <td class="bodytext31" valign="center" align="right"><?php echo $bedallocateddate;?></td>

               

            <td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo number_format($amountuhx1,2,'.',','); ?></div></td>

           </tr>

	<?php } $amountuhx1=0;

		} // If(1)

		}	

		////////// bed tranafer charges //////////

		$totalbedtransferamount    = 0;
$totalbedtransferamountuhx = 0;
$query18 = "select ward,bed,docno,recorddate,leavingdate,recordstatus from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode'";
$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res18 = mysqli_fetch_array($exec18)) {
    $quantity1    = 0;
    $ward         = $res18['ward'];
    $allocateward = $res18['ward'];
    $bed          = $res18['bed'];
    $refno        = $res18['docno'];
    $date         = $res18['recorddate'];
    //$bedallocateddate = $res18['recorddate'];
    $packagedate  = $res18['recorddate'];
    $leavingdate  = $res18['leavingdate'];
    $recordstatus = $res18['recordstatus'];
    if ($leavingdate == '0000-00-00') {
        $leavingdate = $updatedate;
    }
    $query51 = "select bed,threshold from `$bedtable` where auto_number='$bed'";
    $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    $res51          = mysqli_fetch_array($exec51);
    $bedname        = $res51['bed'];
    $threshold      = $res51['threshold'];
    $thresholdvalue = $threshold / 100;
    $time1          = new DateTime($date);
    $time2          = new DateTime($leavingdate);
    $interval       = $time1->diff($time2);
    $quantity1      = $interval->format("%a");
    if ($packdays1 > $quantity1) {
        $quantity1 = $quantity1 - $packdays1;
        $packdays1 = $packdays1 - $quantity1;
    } else {
        $quantity1 = $quantity1 - $packdays1;
        $packdays1 = 0;
    }
    $bedcharge = '0';
    $quantity  = '0';
    $diff      = abs(strtotime($leavingdate) - strtotime($bedallocateddate));
    $query91   = "select charge,(rate) as rate2 from `$bedchargetable` where bedanum='$bed' and recordstatus ='' and charge not in ('Accommodation Charges','Cafetaria Charges')";
    $exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    $num91 = mysqli_num_rows($exec91);
    // $res91 = mysql_fetch_array($exec91);
    while ($res91 = mysqli_fetch_array($exec91)) {
    // if (1) {
        $charge = $res91['charge'];
        $rate   = $res91['rate2'];
        if ($charge != 'Bed Charges') {
            //$quantity=$quantity1+1;
            if ($recordstatus == 'discharged') {
                if ($bedallocateddate == $leavingdate) {
                    $quantity = $quantity1 + 1;
                } else {
                    $quantity = $quantity1;
                }
            } else {
                $quantity = $quantity1;
            }
        } else {
            if ($recordstatus == 'discharged') {
                if ($bedallocateddate == $leavingdate) {
                    $quantity = $quantity1 + 1;
                } else {
                    $quantity = $quantity1;
                }
            } else {
                $quantity = $quantity1;
            }
        }
        //echo $quantity;
        $amount              = $quantity * $rate;
        $allocatequantiy     = $quantity;
        $allocatenewquantity = $quantity;
        //echo $bedcharge;
        if ($bedcharge == '0') {
            //$quantity;
            if ($quantity > 0) {
                if ($type == 'hospital' || $charge != 'Resident Doctor Charges') {
                    
                    $totalbedtransferamount    = $totalbedtransferamount + ($amount);
                    $amountuhx                 = $rate * $quantity;
                    $amountuhx1                = $amountuhx * $fxrate;
                    $totalbedtransferamountuhx = $totalbedtransferamountuhx + ($amountuhx * $fxrate);
                    $totalbedtransfercharges   = $totalbedtransfercharges + $amountuhx1;
                }
            } else {
                if ($charge == 'Bed Charges') {
                    //$bedcharge='1';
                }
            }
        }
         if($amountuhx1>0){
        $sno=$sno + 1;
        $colorloopcount = $sno + 1;
                    $showcolor      = ($colorloopcount & 1);
                    if ($showcolor == 0) {
                        //echo "if";
                        $colorcode = 'bgcolor="#CBDBFA"';
                    } else {
                        //echo "else";
                        $colorcode = 'bgcolor="#ecf0f5"';
                    }
                   
        ?>

         <tr <?php //echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $patientcode; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $customerfullname; ?></td>
              <td class="bodytext31" valign="center" align="right"><?php echo $visitcode;?></td>

               <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php echo $refno;?></div> </td>
               <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php echo $bedname;?></div> </td>

               <td class="bodytext31" valign="center" align="right"><?php echo $date;?></td>

               

            <td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo number_format($amountuhx1,2,'.',','); ?></div></td>

           </tr>

        <?php  } $amountuhx1=0;
    }
}
		////////// bed tranafer charges //////////

		}	

?>		

         <tr>

              <td colspan="7"  class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong>Total Bed Charges:</strong></td>

              <td align="right" valign="center" 

                bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format(($totalbedcharges+$totalbedtransfercharges),2,'.',','); ?></strong></td>

        </tr>

          </tbody>

        </table>

        

			
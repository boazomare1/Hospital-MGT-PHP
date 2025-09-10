<?php

session_start();

ini_set('max_execution_time', 3000);

ini_set('memory_limit','-1');

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedate = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];



$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$dateonly = date("Y-m-d");

$colorloopcount = "";

$runningbalance = 0;

$totalunpre = 0;

$totalunclr = 0;

  

ob_start();



if (isset($_REQUEST["frmflg1"])) { $frmflg1 = $_REQUEST["frmflg1"]; } else { $frmflg1 = ""; }



if (isset($_REQUEST["ADate1"])) { $transactiondatefrom = $_REQUEST["ADate1"]; } else { $transactiondatefrom = date("Y-m-d"); }

if (isset($_REQUEST["ADate2"])) { $transactiondateto = $_REQUEST["ADate2"]; } else { $transactiondateto = date("Y-m-d"); }

if (isset($_REQUEST["bankname"])) 

{ 

	$bankfullname = $_REQUEST["bankname"];

	/*$bankfullname = explode("-",$bankfullname,2);

	$banknamereq = $bankfullname[0];

	$accountnumberreq = $bankfullname[1];*/

} 

else 

{ 

	$bankfullname = "";

	/*$banknamereq = "";

	$accountnumberreq = "";*/

}

$colorcode = 'bgcolor="#CBDBFA"';



?>

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #FFF;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none

}

-->

</style>

<!--<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

--><style type="text/css">



.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}



</style>

<body>

<table width="100%" border="1" align="left" cellpadding="4" cellspacing="0"  style="border-collapse: collapse">

				<?php

 					$sno = 0;

				if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = "frmflag1"; }

				//$cbfrmflag1 = $_POST['cbfrmflag1'];

				if ($frmflag1 == 'frmflag1')

				{	

					if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

					if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

					if ($ADate1 != '' && $ADate2 != '')

					{

						 $transactiondatefrom = $_REQUEST['ADate1'];

						 $transactiondateto = $_REQUEST['ADate2'];

					}

					else

					{

						$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

						$transactiondateto = date('Y-m-d');

					}

					   $bankname = $bankfullname;

						/*$bankname = $_REQUEST["bankname"];

						$banknameexplode = explode("-",$bankname,4);

						

						echo $bankname1 = $banknameexplode[0];

						$bankname1 = trim($bankname1);

						$bankname2 = $banknameexplode[1];

						$bankname2 = trim($bankname2);*/

						

						$query9 = mysqli_query($GLOBALS["___mysqli_ston"], "select accountname,currency from master_accountname where id = '$bankname'") or die ("Error ".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res9 = mysqli_fetch_array($query9);

						$accountname = $res9['accountname'];

				  $currency = $res9['currency'];

				  $cur_qry = "select * from master_currency where currency like '$currency'";

				  $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $cur_qry) or die ("Error in cur_qry".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $res21 = mysqli_fetch_array($exec21);

				  $fxrate = $res21['rate'];

				  if($fxrate == 0.00)

				  {

					  $fxrate = 1.00;

				  }

				?>

				<tr>

                  <td colspan="8" bgcolor="#FFF" class="bodytext3" align="center" valign="middle"><strong><?php echo $companyname; ?></strong></td>

				 </tr>

				 <tr>

                  <td colspan="8" bgcolor="#FFF" class="bodytext3" align="center" valign="middle"><strong><?php echo $accountname; ?></strong></td>

				 </tr> 	

				 <tr>

                  <td colspan="8" bgcolor="#FFF" class="bodytext3" align="center" valign="middle"><strong>Transaction From : <?php echo date('d-M-Y',strtotime($ADate1)); ?> To : <?php echo date('d-M-Y',strtotime($ADate2)); ?></strong></td>

				 </tr> 	  	

				<tr>

                  <td width="5%" align="center" valign="middle" bgcolor="#FFF" class="bodytext3"><strong>No</strong></td>

				  <td width="14%" align="left" valign="middle" bgcolor="#FFF" class="bodytext3"><strong>Transaction Date</strong></td>

                  <td width="14%" align="left" valign="middle" bgcolor="#FFF" class="bodytext3"><strong>Statement Date</strong></td>

                  <td width="16%" align="left" valign="middle" bgcolor="#FFF" class="bodytext3"><strong>Description</strong></td>

				  <td width="10%" align="left" valign="middle" bgcolor="#FFF" class="bodytext3"><strong>Transaction <br/> 

			      Ref No</strong></td>



				  <td width="11%" align="right" valign="middle" bgcolor="#FFF" class="bodytext3"><strong>Money In</strong></td>

                  <td width="12%" align="right" valign="middle" bgcolor="#FFF" class="bodytext3"><strong>Money Out</strong></td>

                  <td width="18%" align="right" valign="middle" bgcolor="#FFF" class="bodytext3"><strong>Running Balance</strong></td>

                </tr>

				  <?php

				  $totatlmoneyin = 0;

				  $totatlmoneyout = 0;

				  $totatlrunningbal = 0;

				  $moneyin = 0;

				  $moneyout = 0;

				  $runningbalancecalc =0;

				  $temp = 0;

				  $runningbalance = 0;

				  $sno=0;

				  $opening = 0;

				  

				  $query = "select openbalanceamount,entrydate,docno from openingbalanceaccount where accountcode = '$bankname'";

				  $exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));

				  while($res = mysqli_fetch_array($exec))

				  {

				  	$openingbal = $res['openbalanceamount'];

					$entrydate = $res['entrydate'];

					$docno = $res['docno'];

					$opening = $opening + $openingbal;



				  		$moneyin = 	$opening;

						$moneyout = 0;

				

						$runningbalance = $runningbalance + $moneyin - $moneyout;

						

				  $colorcode = 'bgcolor="#CBDBFA"';

				  ?>

				  <!--<tr  <?php echo $colorcode; ?>>

                  <td class="bodytext3" valign="middle"  align="center"><?php //echo $sno = $sno+1;?> </td>

				  <td class="bodytext3" valign="middle"  align="left"><?php echo $entrydate; ?></td>

                  <td class="bodytext3" valign="middle"  align="left"><?php echo '';?></td>

                  <td class="bodytext3" valign="middle"  align="left"><?php echo 'OPENING BALANCE';?></td>

				  <td class="bodytext3" valign="middle"  align="left"><?php echo $docno;?></td>

                  <td class="bodytext3" valign="middle"  align="right"><?php echo number_format($moneyin,2,'.',',');?> </td>

                  <td class="bodytext3" valign="middle"  align="right"><?php echo number_format($moneyout,2,'.',',');?></td>

                  <td class="bodytext3" valign="center"  align="right"><?php echo number_format($runningbalance,2,'.',',');?></td>

                </tr>-->

				<?php

				}

				?>

				<?php

				$qrybankstatements = "SELECT postdate,chequedate,bankdate,remarks,docno,bankamount,notes,status FROM bank_record WHERE bankdate < '$transactiondatefrom' AND bankcode = '$bankname' AND status IN ('Posted','Unpresented','Uncleared') ";

					$excebankstatements = mysqli_query($GLOBALS["___mysqli_ston"], $qrybankstatements) or die("Error in qrybankstatements".mysqli_error($GLOBALS["___mysqli_ston"]));

			

					while($resbankstatement = mysqli_fetch_array($excebankstatements))

					{

					  $postingdate = $resbankstatement["chequedate"];

					  $valuedate = $resbankstatement["bankdate"];

					  $description = $resbankstatement["remarks"];

					  $transrefno = $resbankstatement["docno"];

					  $notes = $resbankstatement["notes"];

					  $status = $resbankstatement["status"];

					  	

						$query2 = "select amount, creditamount from bankentryform where docnumber = '$transrefno' and (frombankid = '$bankname' or tobankid = '$bankname')";

						$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res2 = mysqli_fetch_array($exec2);

						$num2 = mysqli_num_rows($exec2);

						$dramount = $res2['amount'];

						$cramount = $res2['creditamount'];

						if($num2 == 0)

						{

							//MONEY IN  -- notes type is accountrecievelbe

							if($notes == 'accounts receivable')

							{

								

								if($status == 'Unpresented')

								{

									$moneyin = 0;

									$moneyout = $resbankstatement["bankamount"];

								}

								else if($status == 'Uncleared')

								{

									$moneyin = 	$resbankstatement["bankamount"];

									$moneyout = 0;

								}

								else

								{

									$moneyin = 	$resbankstatement["bankamount"];

									$moneyout = 0;

								}

							

							}
							else if($notes == 'journal entries'){

								if($resbankstatement["bankamount"]<0){
									$moneyout = abs($resbankstatement["bankamount"]);
									$moneyin = 0;
								}else{
									$moneyin = abs($resbankstatement["bankamount"]);	
									$moneyout = 0;
								
								}

							}
							
							else //MONEY OUT

							{

								$moneyout = abs($resbankstatement["bankamount"]);

								$moneyin = 0;

							}

						}

						else

						{

							$moneyin = 	$dramount;

							$moneyout = $cramount;

						}	

						$moneyin = $moneyin/$fxrate;

						$moneyout = $moneyout/$fxrate;

						

						$runningbalance = $runningbalance + $moneyin - $moneyout;

						

						/*if($moneyout!=0 && $moneyin == 0)

						{

							if($temp == 0)

							{

								$runningbalancecalc = $runningbalancecalc + $moneyout;

								$runningbalance = "-".number_format($runningbalancecalc,2,'.',',');

							}

							else

							{

								$runningbalancecalc = $temp - $moneyout;

								$runningbalance = number_format($runningbalancecalc,2,'.',',');

								$temp = $runningbalancecalc;

							}

						}

						if($moneyin!= 0 && $moneyout==0)

						{

							if($moneyin>$runningbalancecalc)

							{

								$runningbalancecalc =$moneyin - $runningbalancecalc;

								$runningbalance = number_format($runningbalancecalc,2,'.',',');

								$temp = $runningbalancecalc;

							}

							if($moneyin == $runningbalancecalc)

							{

								$runningbalancecalc = $moneyin - $runningbalancecalc;

								$runningbalance = number_format($runningbalancecalc,2,'.',',');

							}

							

						}*/

						

						$colorcode = 'bgcolor="#CBDBFA"';

						

						//TOTALS

						//$totatlmoneyin = $totatlmoneyin + $moneyin;

						//$totatlmoneyout = $totatlmoneyout + $moneyout;

						//$totatlrunningbal = $totatlrunningbal + $runningbalance;

					}

					?>	

					<tr>

                  <td class="bodytext3" valign="middle"  align="center"><?php echo $sno = $sno+1;?> </td>

				  <td class="bodytext3" valign="middle"  align="center"><?php //echo $sno = $sno+1; ?> </td>

				  <td colspan="3" class="bodytext3" valign="middle"  align="left"><?php echo 'OPENING BALANCE AND BALANCE CARRIED OVER'; ?></td>

                  <td class="bodytext3" valign="center"  align="right"><?php //echo number_format($totatlmoneyin,2,'.',',');?></td>

				  <td class="bodytext3" valign="center"  align="right"><?php //echo number_format($totatlmoneyout,2,'.',',');?></td>

				  <td class="bodytext3" valign="center"  align="right"><?php echo number_format($runningbalance,2,'.',',');?></td>

                </tr>

				  <?php

				  $qrybankstatements = "SELECT postdate,chequedate,bankdate,remarks,docno,bankamount,notes,status FROM bank_record WHERE bankdate BETWEEN '$transactiondatefrom' AND  '$transactiondateto' AND bankcode = '$bankname' AND status IN ('Posted','Unpresented','Uncleared') order by bankdate";

					$excebankstatements = mysqli_query($GLOBALS["___mysqli_ston"], $qrybankstatements) or die("Error in qrybankstatements".mysqli_error($GLOBALS["___mysqli_ston"]));

			

					while($resbankstatement = mysqli_fetch_array($excebankstatements))

					{

					  $postingdate = $resbankstatement["chequedate"];

					  $valuedate = $resbankstatement["bankdate"];

					  $description = $resbankstatement["remarks"];

					  $transrefno = $resbankstatement["docno"];

					  $notes = $resbankstatement["notes"];

					  $status = $resbankstatement["status"];

					  	

						$query2 = "select amount, creditamount from bankentryform where docnumber = '$transrefno' and (frombankid = '$bankname' or tobankid = '$bankname')";

						$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res2 = mysqli_fetch_array($exec2);

						$num2 = mysqli_num_rows($exec2);

						$dramount = $res2['amount'];

						$cramount = $res2['creditamount'];

						if($num2 == 0)

						{

							//MONEY IN  -- notes type is accountrecievelbe

							if($notes == 'accounts receivable')

							{

								if($status == 'Unpresented')

								{

									$moneyin = 0;

									$moneyout = $resbankstatement["bankamount"];

									$totalunpre = $resbankstatement["bankamount"];

								}

								else if($status == 'Uncleared')

								{

									$moneyin = 	$resbankstatement["bankamount"];

									$moneyout = 0;

									$totalunclr = $resbankstatement["bankamount"];

								}

								else

								{

									$moneyin = 	$resbankstatement["bankamount"];

									$moneyout = 0;

								}

							}

							else if($notes == 'journal entries'){

								if($resbankstatement["bankamount"]<0){
									$moneyout = abs($resbankstatement["bankamount"]);
									$moneyin = 0;
								}else{
									$moneyin = abs($resbankstatement["bankamount"]);	
									$moneyout = 0;
								
								}

							}


							else //MONEY OUT

							{

								$moneyout = abs($resbankstatement["bankamount"]);

								$moneyin = 0;

							}

						}

						else

						{

							$moneyin = 	$dramount;

							$moneyout = $cramount;

						}	

						$moneyin = $moneyin/$fxrate;

						$moneyout = $moneyout/$fxrate;

						

						$runningbalance = $runningbalance + $moneyin - $moneyout;

						

						/*if($moneyout!=0 && $moneyin == 0)

						{

							if($temp == 0)

							{

								$runningbalancecalc = $runningbalancecalc + $moneyout;

								$runningbalance = "-".number_format($runningbalancecalc,2,'.',',');

							}

							else

							{

								$runningbalancecalc = $temp - $moneyout;

								$runningbalance = number_format($runningbalancecalc,2,'.',',');

								$temp = $runningbalancecalc;

							}

						}

						if($moneyin!= 0 && $moneyout==0)

						{

							if($moneyin>$runningbalancecalc)

							{

								$runningbalancecalc =$moneyin - $runningbalancecalc;

								$runningbalance = number_format($runningbalancecalc,2,'.',',');

								$temp = $runningbalancecalc;

							}

							if($moneyin == $runningbalancecalc)

							{

								$runningbalancecalc = $moneyin - $runningbalancecalc;

								$runningbalance = number_format($runningbalancecalc,2,'.',',');

							}

							

						}*/

						

						//TOTALS

						$totatlmoneyin = $totatlmoneyin + $moneyin;

						$totatlmoneyout = $totatlmoneyout + $moneyout;

						//$totatlrunningbal = $totatlrunningbal + $runningbalance;

						

						$colorloopcount = $colorloopcount + 1;

							$showcolor = ($colorloopcount & 1); 

							if ($showcolor == 0)

							{

							//echo "if";

							$colorcode = 'bgcolor="#fff"';

							}

							else

							{

							//echo "else";

							$colorcode = 'bgcolor="#fff"';

							}		

				  ?>

				<tr  <?php echo $colorcode; ?>>

                  <td class="bodytext3" valign="middle"  align="center"><?php echo $sno = $sno+1;;?> </td>

				  <td class="bodytext3" valign="middle"  align="left"><?php echo $postingdate;?></td>

                  <td class="bodytext3" valign="middle"  align="left"><?php echo $valuedate;?></td>

                  <td class="bodytext3" valign="middle"  align="left"><?php echo $description;?></td>

				  <td class="bodytext3" valign="middle"  align="left"><?php echo $transrefno;?></td>

                  <td class="bodytext3" valign="middle"  align="right"><?php echo number_format($moneyin,2,'.',',');?> </td>

                  <td class="bodytext3" valign="middle"  align="right"><?php echo number_format($moneyout,2,'.',',');?></td>

                  <td class="bodytext3" valign="center"  align="right"><?php echo number_format($runningbalance,2,'.',',');?></td>

                </tr>

		    <?php

					}//CLOSE -- WHILE LOOP

			     ?>

                 <tr>

                 	<td colspan="5" class="bodytext3" bgcolor="#fff" align="right" valign="middle"><strong>Total</strong></td>

                    <td class="bodytext3" bgcolor="#fff" align="right" valign="middle"><strong><?php echo number_format($totatlmoneyin,2,'.',','); ?></strong></td>

                    <td class="bodytext3" bgcolor="#fff" align="right" valign="middle"><strong><?php echo number_format($totatlmoneyout,2,'.',','); ?></strong></td>

                    <td class="bodytext3" bgcolor="#fff" align="right" valign="middle"><strong><?php echo number_format($runningbalance,2,'.',','); ?></strong></td>

					</tr>

               

				 <tr>

                 	<td colspan="5" class="bodytext3" bgcolor="#fff" align="right" valign="middle"><strong>Total Unpresented</strong></td>

                    <td class="bodytext3" bgcolor="#fff" align="right" valign="middle"><strong><?php echo number_format(0,2,'.',','); ?></strong></td>

                    <td class="bodytext3" bgcolor="#fff" align="right" valign="middle"><strong><?php echo number_format($totalunpre,2,'.',','); ?></strong></td>

                    <td class="bodytext3" bgcolor="#fff" align="right" valign="middle"><strong><?php //echo number_format($runningbalance,2,'.',','); ?></strong></td>

					</tr>

                     <tr>

                 	<td colspan="5" class="bodytext3" bgcolor="#fff" align="right" valign="middle"><strong>Total Uncleared</strong></td>

                    <td class="bodytext3" bgcolor="#fff" align="right" valign="middle"><strong><?php echo number_format($totalunclr,2,'.',','); ?></strong></td>

                    <td class="bodytext3" bgcolor="#fff" align="right" valign="middle"><strong><?php echo number_format(0,2,'.',','); ?></strong></td>

                    <td class="bodytext3" bgcolor="#fff" align="right" valign="middle"><strong><?php //echo number_format($runningbalance,2,'.',','); ?></strong></td>

					</tr>

<tr>

                 	<td colspan="6" class="bodytext3" bgcolor="#fff" align="right" valign="middle"><strong>Total Bank Balance :</strong></td>

                    <td class="bodytext3" bgcolor="#fff" align="right" valign="middle"><strong><?php echo number_format($runningbalance,2,'.',','); ?></strong></td>

                    <td  class="bodytext3" bgcolor="#fff" align="right" valign="middle">&nbsp;</td>

                </tr>



				 <?php   		

				} //CLOSE -- IF(frmflag1)

				?>	

	      </table>

         

<?php	

require_once("dompdf/dompdf_config.inc.php");

$html =ob_get_clean();

$dompdf = new DOMPDF();

$dompdf->load_html($html);

$dompdf->set_paper("A4");

$dompdf->render();

$canvas = $dompdf->get_canvas();

//$canvas->line(10,800,800,800,array(0,0,0),1);

$font = Font_Metrics::get_font("Arial", "normal");

$canvas->page_text(272, 814, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));

$dompdf->stream("BankStatement.pdf", array("Attachment" => 0));

?>
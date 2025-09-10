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

header('Content-Disposition: attachment;filename="IPUnfinal_lab.xls"');

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

			if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

			

		//$ADate1='2015-02-01';

		//$ADate2='2015-02-28';

		?>

        <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="400" 

            align="left" border="1">

          <tbody>

            <tr>

              <td colspan="8" bgcolor="#ecf0f5" class="bodytext31" align="center"><strong>Lab Charge Details</strong></td>

              </tr>            

			

             <tr <?php //echo $colorcode; ?>>

              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>S.No</strong></td>
               <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>Patient Code</strong></td>
              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>Patient Name</strong></td>
                <td align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Visitcode</strong></td>
                <td align="left" width="18%" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Lab Name</strong></td>

               <td align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Doc. No</strong></td>

              <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Date</strong></td>


              <td width="18%" align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Amount</strong></td>

            </tr>



        <?php

		$labtotal=0;

		$sno=0;

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

			$fxrate = $execsubtype['fxrate'];

			

			$querytl32 = "select * from master_testtemplate where templatename='$labtemplate'";

			$exectl32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytl32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$numtl32 = mysqli_num_rows($exectl32);

			$exectl=mysqli_fetch_array($exectl32);		

			$labtable=$exectl['templatename'];

			if($labtable=='')

			{

				$labtable='master_lab';

			}

			

		 $totallab=0;

			    $totallabuhx=0;

			  $query19 = "select * from ipconsultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and labrefund <> 'refund'";

			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res19 = mysqli_fetch_array($exec19))

			{

			$labdate=$res19['consultationdate'];

			$labname=$res19['labitemname'];

			$labcode=$res19['labitemcode'];

			$labrate=$res19['labitemrate'];

			$labrefno=$res19['iptestdocno'];

			$labfree = $res19['freestatus'];

			

			if($labfree == 'No')

			{

			$queryl51 = "select rateperunit from `$labtable` where itemcode='$labcode'";

			$execl51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryl51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$resl51 = mysqli_fetch_array($execl51);

			$labrate = $resl51['rateperunit'];

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

			$totallab=$totallab+$labrate;

			$sno = $sno + 1;

			 $labrateuhx = $labrate*$fxrate;

		   $totallabuhx = $totallabuhx + $labrateuhx;

		   $labtotal = $labtotal + $labrateuhx;

			

			 ?>

           <tr>

              <td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>

              <td class="bodytext31" valign="center"  align="left"><?php echo $patientcode; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $customerfullname; ?></td>
              <td class="bodytext31" valign="center" align="left"><?php echo $visitcode;?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $labname; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $labrefno;?></div> </td>

               <td class="bodytext31" valign="center" align="right"><?php echo $labdate;?></td>

               

            <td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo number_format($labrateuhx,2,'.',','); ?></div></td>

           </tr>

	<?php   $labrateuhx=0;

		}

		}

			  }

?>		

         <tr>

              <td colspan="7"  class="bodytext31" valign="center"  align="right" 

                bgcolor="#fff"><strong>Total Lab Charges:</strong></td>

              <td align="right" valign="center" 

                bgcolor="#fff" class="bodytext31"><strong><?php echo number_format($labtotal,2,'.',','); ?></strong></td>

				</tr>

          </tbody>

        </table>

        

			
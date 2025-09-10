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

<table width="1900" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860">



        <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 

            align="left" border="0">

          <tbody>

            <tr>

              <!-- <td width="10%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td> -->

              <td colspan="8" bgcolor="#ecf0f5" class="bodytext31"><strong>Radiology Charge Details</strong></td>

              <!-- <td width="10%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td> -->

              </tr>            

 

              <tr <?php //echo $colorcode; ?>>

              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>S.No</strong></td>
               <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>Patient Code</strong></td>
              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>Patient Name</strong></td>
                <td align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Visitcode</strong></td>
                <td align="left" width="18%" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Radiology Name</strong></td>

               <td align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Doc. No</strong></td>

              <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Date</strong></td>


              <td width="18%" align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Amount</strong></td>

            </tr>
 



           <?php

            $colorloopcount ='';

			$netamount='';

			$sno=0;

			$totalradiologyitemrate =0;

			$totalquantity = 0;

			if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

		//$ADate1='2015-01-31';

		//$ADate2='2015-02-28';

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

			

			$querytt32 = "select * from master_testtemplate where templatename='$radtemplate'";

			$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$numtt32 = mysqli_num_rows($exectt32);

			$exectt=mysqli_fetch_array($exectt32);		

			$radtable=$exectt['templatename'];

			if($radtable=='')

			{

				$radtable='master_radiology';

			}

			

	

				$totalrad=0;

				$totalraduhx=0;

			  $query20 = "select * from ipconsultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund'";

			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res20 = mysqli_fetch_array($exec20))

			{

			$raddate=$res20['consultationdate'];

			$radname=$res20['radiologyitemname'];

			$radrate=$res20['radiologyitemrate'];

			$radref=$res20['iptestdocno'];

			$radiologyfree = $res20['freestatus'];

			$radiologyitemcode = $res20['radiologyitemcode'];

			if($radiologyfree == 'No')

			{

			$queryr51 = "select rateperunit from `$radtable` where itemcode='$radiologyitemcode'";

			$execr51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$resr51 = mysqli_fetch_array($execr51);

			$radrate = $resr51['rateperunit'];

			 

			$totalrad=$totalrad+$radrate;

			

			 $radrateuhx = $radrate*$fxrate;

		   $totalraduhx = $totalraduhx + $radrateuhx;

		   $totalradiologyitemrate = $totalradiologyitemrate + $radrateuhx;

		

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

			$sno = $sno + 1;


			?>
 

           <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $sno ?></td>

              <td class="bodytext31" valign="center"  align="left"><?php echo $patientcode; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $customerfullname; ?></td>
              <td class="bodytext31" valign="center" align="left"><?php echo $visitcode;?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $radname; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $radref;?></div> </td>

               <td class="bodytext31" valign="center" align="right"><?php echo $raddate;?></td>

               

            <td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo number_format($totalraduhx,2,'.',','); ?></div></td>

           </tr>

	<?php  $totalraduhx=0;

		}

		}

		}

?>		

         <tr>

              <td colspan="7"  class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong>Total Radiology Charges:</strong></td>

              <td align="right" valign="center" 

                bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($totalradiologyitemrate,2,'.',','); ?></strong></td>

<!--				<?php if($nettotal != 0.00) { ?>

				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="print_oprevenuereport.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&user=<?php echo $res21username; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>

                

			    <?php 

				}?>

-->		<tr>

				<td colspan="7" align="left">

			<a href="ipunfinalradioxl.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>"><img src="images/excel-xls-icon.png" width="40" height="40"></a></td>

			</tr>

          </tbody>

        </table>

        

			
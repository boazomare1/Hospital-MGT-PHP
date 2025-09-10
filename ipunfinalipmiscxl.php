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

header('Content-Disposition: attachment;filename="IPmisc.xls"');

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
  				<td colspan="7" bgcolor="#ecf0f5" class="bodytext31" align="center"><strong>IPMISC Details</strong></td>

              </tr>            

            
             <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31"  bgcolor="#FFFFFF" align="left"><strong>S.No</strong></td>
              <td class="bodytext31"  bgcolor="#FFFFFF" align="left"><strong>Patient Code</strong></td>
              <td class="bodytext31"  bgcolor="#FFFFFF" align="left"><strong>Patient Name</strong></td>
              <td class="bodytext31"  align="left"  bgcolor="#FFFFFF" ><strong>Visitcode</strong></td>
              <td class="bodytext31"  align="left"  bgcolor="#FFFFFF" ><strong>Doc. No</strong></td>
              <td class="bodytext31"  align="right"  bgcolor="#FFFFFF" ><strong>Date</strong></td>
              <td class="bodytext31"  width="21%" align="right"  bgcolor="#FFFFFF" ><strong>Amount</strong></td>
            </tr> 



        <?php

            $colorloopcount ='';

			$netamount='';

			$sno=0;

			$totalradiologyitemrate =0;

			$totalpharmacysaleamount=0;
			
			$totalambulanceamount = 0;
			$totalambulanceamountuhx=0;

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

			

			

			$query63 = "select * from ipmisc_billing where patientcode='$patientcode' and patientvisitcode='$visitcode'";

			$exec63 = mysqli_query($GLOBALS["___mysqli_ston"], $query63) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res63 = mysqli_fetch_array($exec63))

		   {

			$ambulancedate = $res63['consultationdate'];

			$ambulancerefno = $res63['docno'];

			$ambulance = $res63['description'];

			$ambulancerate = $res63['rate'];

			$ambulanceamount = $res63['amount'];

			$ambulanceunit = $res63['units'];


			$ambulanceamount = $ambulanceunit*($ambulancerate/$fxrate);

			 $ambulanceamountuhx = $ambulancerate*$ambulanceunit;

			 $totalambulanceamount = $totalambulanceamount + $ambulanceamountuhx;	

		

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

           <tr>	 
             <td class="bodytext31" valign="center"  align="left"><?php echo $sno; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $patientcode; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $customerfullname; ?></td>
               <td class="bodytext31" valign="center"  align="left"> <?php echo $visitcode;?> </td>
               <td class="bodytext31" valign="center" align="left"><?php echo $ambulancerefno;?></td>
               <td class="bodytext31" valign="center" align="right"><?php echo $ambulancedate;?></td>
              <td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo number_format($ambulanceamountuhx,2,'.',','); ?></div></td>
           </tr>

            
	<?php  $ambulanceamountuhx=0;
 
		}

		}

?>		

         <tr>

              <td colspan="6"  class="bodytext31" valign="center"  align="right" 

                bgcolor="#fff"><strong>Total IP MISC Amount</strong></td>

              <td align="right" valign="center" 

                bgcolor="#fff" class="bodytext31"><strong><?php echo number_format($totalambulanceamount,2,'.',','); ?></strong></td>

				</tr>

          </tbody>

        </table>

        

			
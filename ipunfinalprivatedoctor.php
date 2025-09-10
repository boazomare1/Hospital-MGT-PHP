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



<script src="js/datetimepicker_css.js"></script>

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

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" 

            align="left" border="0">

          <tbody>

            <tr>

              <!-- <td width="10%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td> -->
              <td colspan="8" bgcolor="#ecf0f5" class="bodytext31"><strong>Private Doctor Charge Details</strong></td>
              <!-- <td width="10%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td> -->
              </tr>           

            <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31"  bgcolor="#FFFFFF" align="left"><strong>S.No</strong></td>
              <td class="bodytext31"  bgcolor="#FFFFFF" align="left"><strong>Patient Code</strong></td>
              <td class="bodytext31"  bgcolor="#FFFFFF" align="left"><strong>Patient Name</strong></td>
              <td class="bodytext31"  align="left"  bgcolor="#FFFFFF" ><strong>Visitcode</strong></td>
              <td class="bodytext31"  align="left"  bgcolor="#FFFFFF" ><strong>Doctor Name</strong></td>
              <td class="bodytext31"  align="left"  bgcolor="#FFFFFF" ><strong>Doc. No</strong></td>
              <td class="bodytext31"  align="right"  bgcolor="#FFFFFF" ><strong>Date</strong></td>
              <td class="bodytext31"  width="21%" align="right"  bgcolor="#FFFFFF" ><strong>Amount</strong></td>
            </tr> 
 

        <?php
        $totalprivatedoctorcharges='0.00';
        $query66 = "select * from master_ipvisitentry where visitcode NOT IN (select visitcode from billing_ip) and consultationdate between '$ADate1' and '$ADate2'";
        $exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($res66 = mysqli_fetch_array($exec66))
        {
          $patientcode = $res66['patientcode'];
          $visitcode = $res66['visitcode'];

		  $query4 = "SELECT * FROM ipprivate_doctor WHERE  patientcode='$patientcode' and patientvisitcode='$visitcode' and pvt_flg = '1' ";
		$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num4=mysqli_num_rows($exec4);
		
		while($res4 = mysqli_fetch_array($exec4))
		{  
      $patientcode = $res4['patientcode'];
      $visitcode = $res4['patientvisitcode'];
      
      $querymenu = "select * from master_customer where customercode='$patientcode'";
      $execmenu = mysqli_query($GLOBALS["___mysqli_ston"], $querymenu) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
      $nummenu=mysqli_num_rows($execmenu);
      $resmenu = mysqli_fetch_array($execmenu);
      $menusub=$resmenu['subtype'];
      $customerfullname=$resmenu['customerfullname'];

      $privatedoctordate = $res4['consultationdate'];
      $privatedoctorrefno = $res4['docno'];
      $privatedoctor = $res4['doctorname'];
      $privatedoctorrate = $res4['rate'];
      $privatedoctoramount = $res4['amount'];
      $privatedoctorunit = $res4['units'];
      $description = $res4['remarks'];
      $doccoa = $res4['doccoa'];

      $totalprivatedoctorcharges+=$res4['amount'];

      $colorloopcount = $colorloopcount + 1;
      $showcolor = ($colorloopcount & 1); 
      if ($showcolor == 0)
      {
        $colorcode = 'bgcolor="#CBDBFA"';
      }
      else
      {
        $colorcode = 'bgcolor="#ecf0f5"';
      }
      $sno = $sno + 1;
      ?>
       <tr <?php echo $colorcode; ?>>
             <td class="bodytext31" valign="center"  align="left"><?php echo $sno; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $patientcode; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $customerfullname; ?></td>
               <td class="bodytext31" valign="center"  align="left"> <?php echo $visitcode;?> </td>
               <td class="bodytext31" valign="center"  align="left">  <?php echo $privatedoctor;?> </td>
               <td class="bodytext31" valign="center" align="left"><?php echo $privatedoctorrefno;?></td>
               <td class="bodytext31" valign="center" align="right"><?php echo $privatedoctordate;?></td>
              <td align="right" valign="center"  class="bodytext31"><div class="bodytext31"><?php echo number_format($privatedoctoramount,2,'.',','); ?></div></td>
           </tr>
      <?php $privatedoctoramount=0;
      }
    }

?>		

         <tr>

              <td colspan="7"  class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong>Total Private Doctor Charges:</strong></td>

              <td align="right" valign="center" 

                bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo number_format($totalprivatedoctorcharges,2,'.',','); ?></strong></td>

<!--				<?php if($nettotal != 0.00) { ?>

				<td rowspan="2" align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="print_oprevenuereport.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&user=<?php echo $res21username; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>

                

			    <?php 

				}?>

-->		<tr>

				<td colspan="7" align="left">

			<a href="ipunfinalprivatedoctorxl.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2;?>"><img src="images/excel-xls-icon.png" width="40" height="40"></a></td>

			</tr>

          </tbody>

        </table>

        

			
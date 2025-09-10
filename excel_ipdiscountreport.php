<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="ipdiscountreport.xls"');
header('Cache-Control: max-age=80');

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

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #FFFFFF;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

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



<script src="js/datetimepicker_css.js"></script>

           <?php

            $colorloopcount ='';

			$netamount='';

			if (isset($_REQUEST["fromdate"])) { $fromdate = $_REQUEST["fromdate"]; } else { $fromdate = ""; }

			if (isset($_REQUEST["todate"])) { $todate = $_REQUEST["todate"]; } else { $todate = ""; }

			if (isset($_REQUEST["locationcode1"])) { $locationcode1 = $_REQUEST["locationcode1"]; } else { $locationcode1 = ""; }

			if (isset($_REQUEST["searchpatient"])) { $searchpatient = $_REQUEST["searchpatient"]; } else { $searchpatient = ""; }

			if (isset($_REQUEST["searchpatientcode"])) { $searchpatientcode = $_REQUEST["searchpatientcode"]; } else { $searchpatientcode = ""; }
			
			if (isset($_REQUEST["searchvisitcode"])) { $searchvisitcode = $_REQUEST["searchvisitcode"]; } else { $searchvisitcode = ""; }

		




		?>

<table width="" border="0" cellspacing="0" cellpadding="2">


  <tr>

    <td width="" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="">

        	<?php $width="1000";$head_title_colspan="10"; ?>

        <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="<?= $width?>" 

            align="left" border="1">

          <tbody>

            <tr>

              <td width="" bgcolor="#ecf0f5" class="bodytext31" colspan="<?= $head_title_colspan?>"><strong>IP Discount</strong></td>

              </tr>            

			 <tr >

              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>S.No</strong></td>

              <td align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Patient Name</td>

			  <td align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Reg. No.</td>
			  
			  <td align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Visit Code</td>

              <td align="center" valign="center" bgcolor="#FFFFFF" class="bodytext31"> Remarks</td>

              <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">IP Date</td>

              <td width="" align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Amount</td>
			  
			  <td width="" align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">IP Address</td>
			  
			   <td align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Username</td>

              <td width="" align="right" valign="center" bgcolor="#FFFFFF" class="bodytext31">Time</td>
			  
			  

            </tr>
             <?php
			
			$query1 = "select * from ip_discount where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and locationcode='$locationcode1' and consultationdate between '$fromdate' and '$todate' order by auto_number desc";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num1=mysqli_num_rows($exec1);

		

		while($res1 = mysqli_fetch_array($exec1))

		{

		$patientname=$res1['patientname'];

		$patientcode=$res1['patientcode'];

		$visitcode=$res1['patientvisitcode'];

		$consultationdate=$res1['consultationdate'];

	    $amount=$res1['rate'];

		 $ipaddress=$res1['ipaddress'];

		 $username=$res1['username'];

		 $time=$res1['consultationtime'];
		 
		 $discount= $res1['description'];
		$authorizedby = $res1['authorizedby'];

		

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

          <tr >

              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $patientcode; ?></div></td>

			    <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $visitcode; ?></div></td>	
                 
				 <td class="bodytext31" valign="center"  align="left">


					<div class="bodytext31">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></div> </td>
            

                <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div>                  </td>

                <td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo number_format($amount,2,'.',','); ?></div></td>

                <td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $ipaddress; ?></div></td>

                <td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $username; ?></div></td>

                <td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $time; ?></div></td>

              </tr>

		   <?php 

		   } 

			
			 ?>		

         

           


          </tbody>

        </table>

        

			
<?php
 
error_reporting(0);
session_start();


include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$location =isset( $_REQUEST['location'])?$_REQUEST['location']:'';



$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$searchsuppliername = "";

$cbsuppliername = "";



//This include updatation takes too long to load for hunge items database.





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



if(isset($_REQUEST['searchitem'])) { $searchitem = $_REQUEST['searchitem']; } else { $searchitem = ""; }



if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-2 year'));

$paymentreceiveddateto = date('Y-m-d');


$paymentreceiveddatefrom = $_REQUEST['ADate1'];

	$paymentreceiveddateto = $_REQUEST['ADate2'];
header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="FixedAssetAcquisition.xls"');

header('Cache-Control: max-age=80');



?>

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px;  FONT-FAMILY: Tahoma

}

-->

</style>




<style type="text/css">

<!--

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px;  FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; FONT-FAMILY: Tahoma; text-decoration:none

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







<body>



		

<?php

	$colorloopcount=0;

	$sno=0;

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];



?>
 

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

             cellspacing="0" cellpadding="4" width="1100" 

            align="left" border="1">

          <tbody>


          		<tr>
            		<td colspan="8"  valign="center"  style="FONT-SIZE: 18px" align="center"><strong> Fixed Asset - Acquisition List</strong></td>
            	</tr>
            	<tr>
            		<td  colspan="8" valign="center"  style="FONT-SIZE: 12px" align="center"><strong> Date From <?=$paymentreceiveddatefrom?> To  <?=$paymentreceiveddateto?></strong></td>
            	</tr>

             

            <tr>

            	<td width="3%" class="bodytext31" valign="center"  align="left" 

                ><div align="center"><strong>S.No.</strong></div></td>
           	  <td width="3%" class="bodytext31" valign="center"  align="left" 

                ><div align="center"><strong>No.</strong></div></td>

			
                 <td width="15%"  align="left" valign="center" 

                class="bodytext31"><div align="center"><strong>Description</strong></div></td>
                 <td width="7%"  align="left" valign="center" 

                 class="bodytext31"><div align="center"><strong>Responsible Employee </strong></div></td>

              <td width="6%" class="bodytext31" valign="center"  align="left" 

                ><div align="center"><strong>Location Code	</strong></div></td>

				    <td width="8%" class="bodytext31" valign="center"  align="left" 

                ><div align="center"><strong>Serial No.</strong></div></td>

                <td width="8%" class="bodytext31" valign="center"  align="right" bgcolor="#ffffff"><div align="right"><strong>Acquisition Cost</strong></div></td>

                <td width="7%" class="bodytext31" valign="center"  align="right" bgcolor="#ffffff"><div align="right"><strong>Acquisition Date</strong></div></td>

                	                
              </tr>

           <?php

		 $total_rate_acq=0;

           $query34 = "select * from assets_register where entrydate between '$paymentreceiveddatefrom' and '$paymentreceiveddateto'  and recordstatus= '' order by auto_number";

		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		   while($res34 = mysqli_fetch_array($exec34))

		   {

		   $itemname = $res34['itemname'];

		   $itemcode = $res34['itemcode'];
		   $rate_acq = $res34['rate'];

		   $total_rate_acq += $res34['rate'];


		   $entrydate = $res34['entrydate'];

		   $entrydate = strtotime($entrydate);

		   $entrydate = date("d/m/Y", $entrydate);

		  

		   $suppliername = $res34['suppliername'];

		   $anum = $res34['auto_number'];

		   $asset_id = $res34['asset_id'];

			$asset_category = $res34['asset_category'];

			$serialno =  $res34['serial_number'];

			$asset_class = $res34['asset_class'];

			$asset_department = $res34['asset_department'];

			$asset_unit = $res34['asset_unit'];

			$asset_period = $res34['asset_period'];

			$startyear = $res34['startyear'];

			$responsible_employee = "";

			$locationcode = $res34['locationcode'];
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

			

          <tr>

               <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td> 

             
                <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $asset_id; ?>
              	
              </div></td>
              

			  <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $itemname; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $responsible_employee; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $locationcode; ?></div></td>

			     <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $serialno; ?></div></td>

			   <td class="bodytext31" valign="center"  align="right"> <div align="right"><?php echo number_format($rate_acq,2); ?></div></td>

			    <td class="bodytext31" valign="center"  align="right"><div align="right"><?php echo $entrydate; ?></div></td>

				</tr>

		  <?php

		  }

           ?>

            <tr>
              <td colspan="6" class="bodytext311" valign="center" align="right" bgcolor="#ecf0f5"><b>Total </b></td>
              <td colspan="1" class="bodytext311" valign="center" align="right" bgcolor="#ecf0f5"><b><?php echo number_format($total_rate_acq,2);?></b></td>
               <td colspan="1" class="bodytext311" valign="center" align="left" bgcolor="#ecf0f5">&nbsp;</td>

			</tr>

           
					

          </tbody>

        </table>


</body>

</html>




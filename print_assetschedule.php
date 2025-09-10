<?php

session_start();

include ("includes/loginverify.php");

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



header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="Assetschedule.xls"');

header('Cache-Control: max-age=80');



//This include updatation takes too long to load for hunge items database.


if (isset($_REQUEST["date_range"])) { $date_range = $_REQUEST["date_range"]; } else { $date_range = ""; }


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

<body>



<?php

	$colorloopcount=0;

	$sno=0;

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = "cbfrmflag1"; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{

$searchpatient = '';		

?>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1284" 

            align="left" border="1">

          <tbody>
          	<tr>
            	<td  colspan="16" valign="center"  style="FONT-SIZE: 14px" align="center"><strong> Assets Register	</strong></td>
            </tr>

             

                 <tr>

           	  <td width="3%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>

			
                 <td width="7%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Category</strong></div></td>
                 <td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Department </strong></div></td>

              <td width="5%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Asset ID</strong></div></td>

				    <td width="15%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Asset Name</strong></div></td>

                  <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Acquisition Date</strong></div></td>

                	 <td width="5%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Life</strong></div></td>

                  <td width="7%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Yearly Dep. Amt </strong></div></td>
                <td width="7%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Yearly Dep. % </strong></div></td>

                 <td width="7%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Dep. Start</strong></div></td>

				 <td width="9%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Purchase Cost </strong></div></td>

				<td width="9%"  align="right" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Salvage</strong></div></td>

				<td width="9%"  align="right" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Last Depreciation</strong></div></td>

                  <td width="7%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Acc. Depreciation  </strong></div></td>
                <td width="9%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Net Book Value </strong></div></td>
				
				 <td width="6%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Fully Depreciated</strong></div></td>

                <td width="6%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Asset Status</strong></div></td>
                

              </tr>

              <?php

		 

           $query34 = "select * from assets_register where (itemname like '%$searchitem%' or asset_class like '%$searchitem%') and entrydate<='$date_range'";

		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		   while($res34 = mysqli_fetch_array($exec34))

		   {

		   $itemname = $res34['itemname'];

		   $itemcode = $res34['itemcode'];

		   $totalamount = $res34['totalamount'];

		   $entrydate = $res34['entrydate'];

		   $suppliercode = $res34['suppliercode'];

		   $suppliername = $res34['suppliername'];

		   $anum = $res34['auto_number'];

		   $asset_id = $res34['asset_id'];

			$asset_category = $res34['asset_category'];

			$asset_class = $res34['asset_class'];

			$asset_department = $res34['asset_department'];

			$asset_unit = $res34['asset_unit'];

			$asset_period = $res34['asset_period'];

			$startyear = $res34['startyear'];

			$quantity = $res34['quantity'];

			$dep_percent = $res34['dep_percent'];

			$depreciation = $totalamount * ($dep_percent / 100);

			$accdepreciation = $depreciation * $asset_period;

			$depreciationmonth = $depreciation / 12;

			$netvalue = $totalamount - $depreciation;

			 $query77 = "select sum(depreciation) totdepamt from assets_depreciation where asset_id = '$asset_id' and entrydate<='$date_range'";
			 
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res77 = mysqli_fetch_array($exec77);

			$accdepreciation =  $res77['totdepamt'];
						
			$netbookvalue = $totalamount - $accdepreciation;

			$salvage = $res34['salvage'];

			
			if($asset_period > 0 && $asset_period !=0)
			{
				$dep_yearly_per = (1/$asset_period) * 100;

				$depreciationyearly = (($totalamount - $salvage)/ $asset_period);
			}
			else
			{
				$dep_yearly_per = 1 * 100;

				$depreciationyearly = (($totalamount - $salvage)/ 1);
			}
			
			

			

			

			// $qryprchamount = "SELECT sum(depreciation) as totdepreciation FROM assets_depreciation WHERE itemname='$itemname' AND recordstatus<>'deleted' and entrydate<='$date_range'";

			$qryprchamount = "SELECT sum(depreciation) as totdepreciation FROM assets_depreciation WHERE asset_id='$asset_id' AND recordstatus<>'deleted' and entrydate<='$date_range'";

			$execprchamount = mysqli_query($GLOBALS["___mysqli_ston"], $qryprchamount) or die ("Error in qryprchamount".mysqli_error($GLOBALS["___mysqli_ston"]));

			$resdep = mysqli_fetch_array($execprchamount);

			$totdepreciation = $resdep['totdepreciation'];

			if($totdepreciation ==  $totalamount && $asset_id !="")

			{

				$fdep = 'YES';

			}

			else

			{

				$fdep = 'NO';

			}

			$qrylastamount = "SELECT depreciation FROM assets_depreciation WHERE asset_id='$asset_id' AND recordstatus<>'deleted' order by auto_number desc limit 0,1";

			$execlastamount = mysqli_query($GLOBALS["___mysqli_ston"], $qrylastamount) or die ("Error in qrylastamount".mysqli_error($GLOBALS["___mysqli_ston"]));

			$resdep2 = mysqli_fetch_array($execlastamount);
			$last_depr_amt=$resdep2["depreciation"];

			$asset_status = "";
			// Check if the asset is disposed
			$qry_disposed = "select auto_number from assets_disposal where asset_id ='$asset_id'";
			$execdisp = mysqli_query($GLOBALS["___mysqli_ston"], $qry_disposed) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		    $disposed_num = mysqli_num_rows($execdisp);
		   if($disposed_num){
		   		$asset_status = "DISPOSED";
		   }

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

			    <div align="center"><?php echo $asset_class; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $asset_department; ?></div></td>

              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $asset_id; ?>
              	
              </div></td>

			  <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $itemname; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $entrydate; ?></div></td>

			    <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $asset_period; ?></div></td>

			    <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo number_format($depreciationyearly,2); ?></div></td>

				  <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $dep_yearly_per; ?></div></td>

			      <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $startyear; ?></div></td>


			    <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php echo number_format($totalamount,2); ?></div></td>

			     <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php echo number_format($salvage,2); ?></div></td>

                <td class="bodytext31" valign="right"  align="right">

			    <div align="right"><?php echo number_format($last_depr_amt,2); ?></div></td>

				<td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php echo number_format($accdepreciation,2); ?></div></td>

				<td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php echo number_format($netbookvalue,2); ?></div></td>

			

				<td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $fdep; ?></div></td>

			    <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $asset_status; ?></div></td>

				

				</tr>

		  <?php

		  }

           ?>

            <tr>

              <td colspan="17" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#FFF">&nbsp;</td>

			</tr>

					

          </tbody>

        </table>

<?php

}

?>	

</body>

</html>




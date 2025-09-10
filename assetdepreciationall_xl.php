<?php
  
error_reporting(0);
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



//This include updatation takes too long to load for hunge items database.





if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

if (isset($_REQUEST["assignmonth"])) { $assignmonth = $_REQUEST["assignmonth"]; } else { $assignmonth = date('M-Y'); }

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

//$frmflag2 = $_POST['frmflag2'];

if (isset($_REQUEST["assignmonth"])) { $assignmonth = $_REQUEST["assignmonth"]; } else { $assignmonth = date('M-Y'); }


if (isset($_REQUEST["frmflag56"])) { $frmflag56 = $_REQUEST["frmflag56"]; } else { $frmflag56 = ""; }

header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="Depreciation List.xls"');

header('Cache-Control: max-age=80');





if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$st = $_REQUEST['st'];

if ($st == '1')

{

	$errmsg = "Success. Payment Entry Update Completed.";

}

if ($st == '2')

{

	$errmsg = "Failed. Payment Entry Not Completed.";

}



?>





<body>



  

  

		

             <p class="bodytext3">Depreciation for Month : <?php echo $assignmonth; ?> </p> 

		<!-- <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            
         



           <tr>

				  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">Depreciation for Month </td>

				  <td colspan="3" align="left" valign="middle"  bgcolor="#ecf0f5"><?php echo $assignmonth; ?>

				</td>

			</tr>	

            

			    

             </tbody>

        </table> -->

		
      

	  

	  
	

		

<?php

	$colorloopcount=0;

	$sno=0;

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }


//$cbfrmflag1 = $_POST['cbfrmflag1'];


$searchpatient = '';		

?>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1250" 

            align="left" border="0">

          <tbody>

           

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

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Yearly Dep. % </strong></div></td>

                 <td width="7%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Dep. Start</strong></div></td>

				 <td width="9%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Purchase Cost </strong></div></td>

				<td width="9%"  align="right" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Salvage</strong></div></td>

                  <td width="7%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Acc. Depreciation  </strong></div></td>
                <td width="9%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Net Book Value </strong></div></td>
				
			 <td width="5%"  align="right" valign="right" 

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Depreciation </strong></div></td>

			 </tr>

			  

           <?php

$startyear = strtoupper($assignmonth);
	$depriciation_startyear = explode('-', $startyear);

		$start_month = $depriciation_startyear[0];

		switch ($start_month) {
			case 'JAN':
				$month = 1;
				break;
			case 'FEB':
			$month = 2;
				break;
				case 'MAR':
			$month = 3;
				break;
				case 'APR':
			$month = 4;
				break;
				case 'MAY':
			$month = 5;
				break;
				case 'JUN':
			$month = 6;
				break;
				case 'JUL':
			$month = 7;
				break;
				case 'AUG':
			$month = 8;
				break;
				case 'SEP':
			$month = 9;
				break;
				case 'OCT':
			$month = 10;
				break;
				case 'NOV':
			$month = 11;
				break;
				case 'DEC':
			$month = 12;
				break;
			default:
				$month = 1;
				break;
		}

		$start_year = $depriciation_startyear[1];

		if($month <10)
		{
			$month = "0".$month;
		}
		$start_day = '01';


		$depreciation_start_date = $start_year.'-'.$month.'-'.$start_day;

		$end_day = '31';
		$depration_done_date = $start_year.'-'.$month.'-'.$end_day;

		 	$sno = 0;

        
           $query34 = "select * from assets_register where depreciation_start_date <='$depreciation_start_date' order by depreciation_start_date asc";

           //echo $query34;

		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $number = mysqli_num_rows($exec34);
		   while($res34 = mysqli_fetch_array($exec34))

		   {

		   //$sno = $sno + 1;

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

			$accdepreciationvalue = $res34['accdepreciation'];

			$dep_percent = $res34['dep_percent'];

			$depreciationledgercode = $res34['depreciationledgercode'];

			$salvage = $res34['salvage'];

			$depreciationyearly = (($totalamount - $salvage)/ $asset_period);

			$depvalue=$depreciationmonth = ($depreciationyearly / 12);

			//$depreciation = $totalamount * ($dep_percent / 100);

			//$accdepreciation = $depreciation * $asset_period;

			//$depreciationmonth = $depreciation / 12;

			$depreciationmonth = number_format($depreciationmonth,2);

			 $query77 = "select sum(depreciation) totdepamt from assets_depreciation where asset_id = '$asset_id' and depreciation_date<='$depration_done_date'";

			 //echo 
			 
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res77 = mysqli_fetch_array($exec77);

			$accdepreciation =  $res77['totdepamt'];
						
			$netbookvalue = $totalamount - $accdepreciation;

			if($depvalue>$netbookvalue){
                $depreciationmonth = number_format($netbookvalue,2);
			}

			if($netbookvalue>0){

			$dep_yearly_per = (1/$asset_period) * 100;

			$disabled = 0;
			$query78 = "select auto_number from assets_depreciation where asset_id = '$asset_id' AND processmonth = '$assignmonth'";

			$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die ("Error in Query78".mysqli_error($GLOBALS["___mysqli_ston"]));
			$number78 = mysqli_num_rows($exec78);

			if($number78 > 0)
			{
				$disabled = 1;
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
			// Check if the asset is disposed
			$qry_disposed = "select auto_number from assets_disposal where asset_id ='$asset_id'";
			$execdisp = mysqli_query($GLOBALS["___mysqli_ston"], $qry_disposed) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		    $disposed_num = mysqli_num_rows($execdisp);
		   if($disposed_num == 0){

		   	 $sno = $sno + 1;
			?>

			

          <tr >

              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>

			 

			   <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $asset_class; ?></div></td>

			    	<td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $asset_department; ?></div></td>


              <td class="bodytext31" valign="center"  align="left"><div align="center">

			 

			

			  <?php echo $asset_id; ?></div></td>

			  <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $itemname; ?></div></td>

			     <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $entrydate; ?></div></td>

			       <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $asset_period; ?></div></td>

			     <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo number_format($dep_yearly_per,2); ?></div></td>

			     <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $startyear; ?></div></td>

				  <td class="bodytext31" valign="right"  align="right">

			    <div align="right"><?php echo number_format($totalamount,2); ?></div></td>

					 

				  <td class="bodytext31" valign="right"  align="right">

			    <div align="right"><?php echo number_format($salvage,2); ?></div></td>

					 
				

			

			    <td class="bodytext31" valign="right"  align="right">

			    <div align="right"><?php echo number_format($accdepreciation,2); ?></div></td>

			     <td class="bodytext31" valign="right"  align="right">

			    <div align="right"><?php echo number_format($netbookvalue,2); ?></div></td>

			    

			   <?php $style = "style='text-align:right;'"; if($disabled){$style = "style='text-align:right;background-color:lightgrey;'";} ?> 


				<td class="bodytext31" valign="center"  align="right">

			    <div align="right" <?php echo $style; ?>>


				<?php echo $depreciationmonth;  ?>
			    	
				
				

				</div></td>


					
				</tr>

		  <?php
		   }
		  	}
		  }

           ?>
           

          </tbody>

        </table>
	
  




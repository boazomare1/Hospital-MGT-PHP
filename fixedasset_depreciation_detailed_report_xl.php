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



if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

//$frmflag2 = $_POST['frmflag2'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-2 year'));

$paymentreceiveddateto = date('Y-m-d');

if ($frmflag2 == 'frmflag2')

{



}


/*$paymentreceiveddatefrom = $_REQUEST['ADate1'];

	$paymentreceiveddateto = $_REQUEST['ADate2'];
*/
	
	if (isset($_REQUEST["categoryid"])) { $categoryid_selected = $_REQUEST["categoryid"]; } else { $categoryid_selected = ""; }



header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="FixedAssetDepreciationDetailed.xls"');

header('Cache-Control: max-age=80');

?>


<?php

	$colorloopcount=0;

	$sno=0;

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];


/*$paymentreceiveddatefrom = $_REQUEST['ADate1'];

	$paymentreceiveddateto = $_REQUEST['ADate2'];
$searchpatient = '';		*/

?>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" 

            align="left" border="0">

          <tbody>

          	 <tr>

            	<td width="3%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>FA Posting Date</strong></div></td>
           	  <td width="3%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>FA Posting Category</strong></div></td>

			
                 <td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>FA Posting Type</strong></div></td>
                 <td width="7%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Document Type </strong></div></td>

              <td width="6%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Document No.</strong></div></td>

				    <td width="8%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Description</strong></div></td>

                  <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Amount</strong></div></td>

                  <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>No. of Depreciation Days</strong></div></td>

                  <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>User ID</strong></div></td>
                  <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Posting Date</strong></div></td>

                	 <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>G/L Entry No.</strong></div></td>
                 <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Entry No.</strong></div></td>                

              </tr>

           <?php
           $grand_netbookvalue = 0;
           $grand_purchasecost = 0;
           $grand_accdepreciation = 0;

           $grandtotal_accdepr = 0;

           $grandtotal_purchasecost = 0;

           $dep_till_date = date("Y-m-d");
		 	$categoryid_cond = "";

		 	if($categoryid_selected!="")
		 	{
		 		$categoryid_cond = " and auto_number='$categoryid_selected' ";
		 	}

           $categoryqry = "select auto_number,category from master_assetcategory where recordstatus= '' $categoryid_cond  order by auto_number ";

		   $categoryexec = mysqli_query($GLOBALS["___mysqli_ston"], $categoryqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		   while($rescategory = mysqli_fetch_array($categoryexec))

		   {

		   	$asset_category_id = $rescategory['auto_number'];
		   

		   	$category_name = $rescategory['category'];
		   	// get total cost for category
		   	 $query66 = "select sum(rate) as totalpurchasecost from assets_register where asset_category_id = $asset_category_id and entrydate<='$date_range'";

			
			 
			$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res66 = mysqli_fetch_array($exec66);

			$totalpurchasecost =  $res66['totalpurchasecost'];

			
		   
			 $incr = 1;

			 $total_category_purchasecost = 0;

			 $total_category_accdepr = 0;

			 $total_category_netbookvalue = 0;

			 $assetqry = "select auto_number,asset_id,itemname,totalamount,entrydate,username,salvage,asset_period,depreciation_start_date from assets_register where asset_category_id = $asset_category_id  and entrydate<='$date_range' order by auto_number ";

		   $assetexec = mysqli_query($GLOBALS["___mysqli_ston"], $assetqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		   while($resasset = mysqli_fetch_array($assetexec))
		   {
		   	
		   	$asset_id = $resasset['asset_id'];

		   	$totalamount = $resasset['totalamount'];
		   	$total_category_purchasecost = $total_category_purchasecost + $totalamount;

		   	$asset_name = $resasset['itemname'];

		   	$acquired_date = $resasset['entrydate'];

		   	$acquired_date_new = strtotime($acquired_date);

		   	 $acquired_date_new = date("d/m/Y", $acquired_date_new);

		   	$username = $resasset['username'];

		   	$salvage = $resasset['salvage'];

		   	$asset_period = $resasset['asset_period'];

		   	$depriciation_start_date = $resasset['depreciation_start_date'];

		   	//$depriciation_start_date = strtotime($depriciation_start_date);

		   	 $query77 = "select sum(depreciation) totdepamt from assets_depreciation where asset_id = '$asset_id' and  depreciation_date<='$date_range'";

			 
			 
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res77 = mysqli_fetch_array($exec77);

			$accdepreciation =  $res77['totdepamt'];

			$total_category_accdepr = $total_category_accdepr + $accdepreciation;
						
			$netbookvalue = $totalamount - $accdepreciation;

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

          	<!--  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td> --> 
               <td colspan="2" class="bodytext31" valign="center"  align="left"><div align="left"><strong><?php echo $category_name.' - '; ?></strong></div></td> 

             <td colspan="5" class="bodytext31" valign="center"  align="left"><div align="left"><strong><?php echo $asset_name; ?></strong></div></td> 
              <td colspan="5" class="bodytext31" valign="center"  align="left"><div align="left"><strong></strong></div></td>
		   </tr>

				<?php 

				$dep_incr = 1;
				// get depreciation start date and end date

				$query88 = "SELECT max(`depreciation_date`) latest_depreciation_date FROM `assets_depreciation` where asset_id = '$asset_id' and  depreciation_date<='$date_range'";
			 
				$exec88 = mysqli_query($GLOBALS["___mysqli_ston"], $query88) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));

				$res88 = mysqli_fetch_array($exec88);

				$latest_depreciation_date =  $res88['latest_depreciation_date'];

				//$start = $month = strtotime('2018-11-01');
				//$start = $month = strtotime($acquired_date);

				$start = $month = strtotime($depriciation_start_date);

				//$end = strtotime('2019-11-30');
				$end = strtotime($latest_depreciation_date);

				while($month < $end)
				{
				     //echo date('F Y', $month), PHP_EOL;
				     

					  if($dep_incr == 1)
					  {
					  	 

					  	$posting_type = "Acquisition Cost";
					  	?>

					  	 <tr>

            	<td width="3%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><?php echo $acquired_date_new; ?></div></td>
           	  <td width="3%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"></div></td>

			
                 <td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><?php echo $posting_type; ?></div></td>
                 <td width="7%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center">Invoice</div></td>

              <td width="6%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"></div></td>

				    <td width="8%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"></div></td>

                  <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><?php echo number_format($totalamount,2); ?></div></td>

                  <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center">30</div></td>

                  <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><?php echo $username ?></div></td>
                  <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><?php echo $acquired_date_new; ?></div></td>

                	 <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"></div></td>
                 <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"></div></td>                

              </tr>


					<?php   }

				      $monthnamefull = date('F', $month);

				    
				      $month_abr = strtoupper(substr($monthnamefull, 0, 3));

				      $year = date('Y', $month);

				      $depreciation_date = date("t/m/Y",$month);
				      $posting_date = $depreciation_date;
				     
				     $month = strtotime("+1 month", $month);

				   
				    	

				    	$posting_type = "Depreciation";
				    	$document_no = "DEP ".$month_abr.' '.$year;

				    	$depreciationyearly = (($totalamount - $salvage)/ $asset_period);

						$depreciationmonth = ($depreciationyearly / 12);

				     ?>

				  <tr>
				    

            	<td width="3%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><?php echo $posting_date; ?></div></td>
           	  <td width="3%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"></div></td>

			
                 <td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><?php echo $posting_type; ?></div></td>
                 <td width="7%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"></div></td>

              <td width="6%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><?php echo $document_no; ?></div></td>

				    <td width="8%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><?php echo $document_no; ?></div></td>

                  <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><?php echo number_format($depreciationmonth,2); ?></div></td>

                  <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center">30</div></td>

                  <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><?php echo $username ?></div></td>
                  <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><?php echo $posting_date; ?></div></td>

                	 <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"></div></td>
                 <td width="7%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"></div></td>                

              </tr>
          <?php 
				    $dep_incr = $dep_incr + 1; 

				}
				
				?>

			
		  <?php
		  $incr = $incr + 1;
		}
		$total_category_netbookvalue = $total_category_purchasecost - $total_category_accdepr;

		$grandtotal_purchasecost = $grandtotal_purchasecost + $total_category_purchasecost;

		$grandtotal_accdepr =  $grandtotal_accdepr + $total_category_accdepr;
		if($total_category_netbookvalue > 0){
		?>

	

		<?php 

		   }
		  }

		  $grandtotal_netbookvalue = $grandtotal_purchasecost - $grandtotal_accdepr;
		  
           ?>
            
          


        
          </tbody>

        </table>


		




<?php 


function getCategoryAssetIds($asset_category_id)
{
	
	$assetids_arr = array();
	$qry = " select asset_id from assets_register where asset_category_id='$asset_category_id' ";
	
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

	while ($res5 = mysqli_fetch_array($exec5))

				{
					$assetids_arr[] = $res5['asset_id'];
					//echo $res5['asset_id'].'<br>';
				}
	return $assetids_arr;
}
?>


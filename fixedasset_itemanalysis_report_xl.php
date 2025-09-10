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

if (isset($_REQUEST["categoryid"])) { $categoryid_selected = $_REQUEST["categoryid"]; } else { $categoryid_selected = ""; }

if ($frmflag2 == 'frmflag2')

{



}
if ($cbfrmflag1 == 'cbfrmflag1')

{

$paymentreceiveddatefrom = $_REQUEST['ADate1'];

	$paymentreceiveddateto = $_REQUEST['ADate2'];

	
	if (isset($_REQUEST["categoryid"])) { $categoryid_selected = $_REQUEST["categoryid"]; } else { $categoryid_selected = ""; }
}

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
header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="FixedAssetAnalysis.xls"');

header('Cache-Control: max-age=80');


?>

<body>


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

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 

            align="left" border="0">

          <tbody>

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
		   //	echo $asset_category_id;

		   	$category_name = $rescategory['category'];
		   	// get total cost for category
		   	 $query66 = "select sum(rate) as totalpurchasecost from assets_register where asset_category_id = $asset_category_id";

			 //echo 
			 
			$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res66 = mysqli_fetch_array($exec66);

			$totalpurchasecost =  $res66['totalpurchasecost'];

			//$grand_purchasecost = $grand_purchasecost +  $totalpurchasecost;

		   // Get assets ids for category
		   //	$assetids_arr = getCategoryAssetIds($asset_category_id);



		   //	echo '<pre>';print_r($assetids_arr);
		   	//$assetids_list = explode(delimiter, string);
		  // 	$assetids_list = "'" . implode ( "', '", $assetids_arr ) . "'";
		   	//echo $assetids_list;exit;

		   /* $query77 = "select sum(depreciation) totdepamt from assets_depreciation where asset_id IN($assetids_list)  and depreciation_date<='$dep_till_date'";

			 //echo 
			 
			$exec77 = mysql_query($query77) or die ("Error in Query77".mysql_error());

			$res77 = mysql_fetch_array($exec77);

			$accdepreciation =  $res77['totdepamt'];

			$grand_accdepreciation = $grand_accdepreciation + $accdepreciation;
						
			$netbookvalue = $totalpurchasecost - $accdepreciation;

			$grand_netbookvalue = $grand_netbookvalue + $netbookvalue;*/
			
		   
			 $incr = 1;

			 $total_category_purchasecost = 0;

			 $total_category_accdepr = 0;

			 $total_category_netbookvalue = 0;

			 $assetqry = "select auto_number,asset_id,itemname,totalamount from assets_register where asset_category_id = $asset_category_id   order by auto_number ";

		   $assetexec = mysqli_query($GLOBALS["___mysqli_ston"], $assetqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		   while($resasset = mysqli_fetch_array($assetexec))
		   {
		   	
		   	$asset_id = $resasset['asset_id'];

		   	$totalamount = $resasset['totalamount'];
		   	$total_category_purchasecost = $total_category_purchasecost + $totalamount;

		   	$asset_name = $resasset['itemname'];

		   	 $query77 = "select sum(depreciation) totdepamt from assets_depreciation where asset_id = '$asset_id'";

			 
			 
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
               <td class="bodytext31" valign="center"  align="left"><div align="left"><strong><?php echo $category_name.' - '; ?></strong></div></td> 

             <td colspan="1" class="bodytext31" valign="center"  align="left"><div align="left"><strong><?php echo $asset_name; ?></strong></div></td> 
              <td colspan="1" class="bodytext31" valign="center"  align="left"><div align="left"><strong></strong></div></td>
               
              

		

			     


				</tr>


          <tr >

          
               <td class="bodytext31" valign="center"  align="left"><div align="left">Acquisition Cost</div></td> 

             <td class="bodytext31" valign="center"  align="left"><div align="center"></div></td> 
               
              

			  <td class="bodytext31" valign="center"  align="left">

			    <div align="right"><?php echo number_format($totalamount,2); ?></div></td>
			
				</tr>

				 <tr >

          
               <td class="bodytext31" valign="center"  align="left"><div align="left">Depreciation</div></td> 

             <td class="bodytext31" valign="center"  align="left"><div align="center"></div></td> 
               
			  <td class="bodytext31" valign="center"  align="left">

			    <div align="right"><?php echo number_format($accdepreciation,2); ?></div></td>
			
				</tr>

				 <tr >

          
               <td class="bodytext31" valign="center"  align="left"><div align="left"><strong>Book Value</strong></div></td> 

             <td class="bodytext31" valign="center"  align="left"><div align="center"></div></td> 
               
              

			  <td class="bodytext31" valign="center"  align="left">

			    <div align="right"><strong><?php echo number_format($netbookvalue,2); ?></strong></div></td>

				</tr>
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
            <tr >

          	<!--  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td> --> 
               <td class="bodytext31" valign="center"  align="left"><div align="left"><strong>Group Total: Main Asset ----</strong></div></td> 

             <td colspan="1" class="bodytext31" valign="center"  align="left"><div align="left"><strong></strong></div></td> 
              <td colspan="1" class="bodytext31" valign="center"  align="left"><div align="left"><strong></strong></div></td>
               
              

		

			     


				</tr>


          <tr >

          
               <td class="bodytext31" valign="center"  align="left"><div align="left">Acquisition Cost</div></td> 

             <td class="bodytext31" valign="center"  align="left"><div align="center"></div></td> 
               
              

			  <td class="bodytext31" valign="center"  align="left">

			    <div align="right"><?php echo number_format($grandtotal_purchasecost,2); ?></div></td>
			
				</tr>

				 <tr >

          
               <td class="bodytext31" valign="center"  align="left"><div align="left">Depreciation</div></td> 

             <td class="bodytext31" valign="center"  align="left"><div align="center"></div></td> 
               
			  <td class="bodytext31" valign="center"  align="left">

			    <div align="right"><?php echo number_format($grandtotal_accdepr,2); ?></div></td>
			
				</tr>

				 <tr >

          
               <td class="bodytext31" valign="center"  align="left"><div align="left"><strong>Book Value</strong></div></td> 

             <td class="bodytext31" valign="center"  align="left"><div align="center"></div></td> 
               
              

			  <td class="bodytext31" valign="center"  align="left">

			    <div align="right"><strong><?php echo number_format($grandtotal_netbookvalue,2); ?></strong></div></td>

				</tr>
            
          </tbody>

        </table>
</body>

</html>

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


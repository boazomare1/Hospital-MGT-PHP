<?php
 
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

if (isset($_REQUEST["date_range"])) { $date_range = $_REQUEST["date_range"]; } else { $date_range = ""; }

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

if ($cbfrmflag1 == 'cbfrmflag1')

{

$paymentreceiveddatefrom = $_REQUEST['ADate1'];

	$paymentreceiveddateto = $_REQUEST['ADate2'];

	if (isset($_REQUEST["categoryid"])) { $categoryid_selected = $_REQUEST["categoryid"]; } else { $categoryid_selected = ""; }
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$st = $_REQUEST['st'];

header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="FixedAssetDetailedBook.xls"');

header('Cache-Control: max-age=80');
?>
</head>

<body >

<?php

	$colorloopcount=0;

	$sno=0;

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];

/*$paymentreceiveddatefrom = $_REQUEST['ADate1'];

	$paymentreceiveddateto = $_REQUEST['ADate2'];
$searchpatient = '';		*/

if (isset($_REQUEST["categoryid"])) { $categoryid_selected = $_REQUEST["categoryid"]; } else { $categoryid_selected = ""; }

?>
<!-- 
<table style="BORDER-COLLAPSE: collapse" 

             cellspacing="0" cellpadding="4" width="800" 

            align="left" border="0">
            <tr>
            	<td   valign="center"  style="FONT-SIZE: 18px" align="center"><strong> Fixed Asset - Detailed Book</strong></td>
            	<td colspan="4">&nbsp;</td>
            </tr>
            <tr>
            	<td    valign="center"  style="FONT-SIZE: 11px" align="center"></td>
            	<td colspan="4"></td>
            </tr>

</table> -->

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666"  width="1000" 

            align="left" border="1">

          <tbody>

          	<tr>
            	<td  colspan="6" valign="center"  style="FONT-SIZE: 18px" align="center"><strong> Fixed Asset - Detailed Book</strong></td>
            </tr>


            <tr>
            	 <td width="1%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>S.No.</strong></div></td> 
            	<td width="6%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
                <td width="6%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Description</strong></div></td>
           	  <td width="30%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="right"><strong>Acquisition Cost</strong></div></td>

			
                 <td width="3%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Depreciation</strong></div></td>
                <!--  <td width="7%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Disposal </strong></div></td> -->

              <td width="3%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="right"><strong>Book Value	</strong></div></td>

				    

                	                

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
		   //	echo $asset_category_id;

		   	$category_name = $rescategory['category'];
		   	// get total cost for category
		   	 $query66 = "select sum(rate) as totalpurchasecost from assets_register where asset_category_id = $asset_category_id and  entrydate<='$date_range'";

			 //echo 
			 
			$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res66 = mysqli_fetch_array($exec66);

			$totalpurchasecost =  $res66['totalpurchasecost'];

			$grand_purchasecost = $grand_purchasecost +  $totalpurchasecost;

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

			 $assetqry = "select auto_number,asset_id,itemname,totalamount from assets_register where asset_category_id = $asset_category_id and entrydate<='$date_range'  order by auto_number ";
			 

		   $assetexec = mysqli_query($GLOBALS["___mysqli_ston"], $assetqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		   while($resasset = mysqli_fetch_array($assetexec))
		   {
		   	if($incr == 1)
		   	{

		   	 ?>

		   	 <tr >

          	 <td colspan="2" class="bodytext31" valign="center"  align="left"><div align="left"><strong><?php echo $category_name; ?></strong></div></td> 
               
			     <td colspan="4" class="bodytext31" valign="center"  align="left"><div align="center"></div></td>


				</tr>

		   	 <?php

		   	}
		   	$asset_id = $resasset['asset_id'];

		   	$totalamount = $resasset['totalamount'];
		   	$total_category_purchasecost = $total_category_purchasecost + $totalamount;

		   	$asset_name = $resasset['itemname'];

		   	 $query77 = "SELECT sum(depreciation) totdepamt from assets_depreciation where asset_id = '$asset_id' and  depreciation_date<='$date_range'";
			 
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res77 = mysqli_fetch_array($exec77);

			$accdepreciation =  $res77['totdepamt'];

			$total_category_accdepr = $total_category_accdepr + $accdepreciation;
						
			$netbookvalue = $totalamount - $accdepreciation;

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
			?>

			

          <tr>

          	 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td> 
               <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $asset_id; ?></div></td> 

             <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $asset_name; ?></div></td> 
                <td class="bodytext31" valign="center"  align="right"><div align="right"><?php echo number_format($totalamount,2); ?>
              	
              </div></td>
              

			  <td class="bodytext31" valign="center"  align="left">

			    <div align="right"><?php echo number_format($accdepreciation,2); ?></div></td>
			 
			    <td class="bodytext31" valign="center"  align="left">

			    <div align="right"><?php echo number_format($netbookvalue,2); ?></div></td>

			</tr>

		  <?php
		  $incr = $incr + 1;
		}
		$total_category_netbookvalue = $total_category_purchasecost - $total_category_accdepr;

		$grandtotal_purchasecost = $grandtotal_purchasecost + $total_category_purchasecost;

		$grandtotal_accdepr =  $grandtotal_accdepr + $total_category_accdepr;

		if($total_category_netbookvalue > 0){
		?>

		 <tr>
               <td  colspan="3" class="bodytext31" valign="center"  align="left"><div align="left"><strong>Group Total : <?php echo $category_name;?></strong></div></td> 
              
             
                <td class="bodytext31" valign="center"  align="right"><div align="right"><strong><?php echo number_format($total_category_purchasecost,2); ?></strong>
              	
              </div></td>
             
			  <td class="bodytext31" valign="center"  align="left">

			    <div align="right"><strong><?php echo number_format($total_category_accdepr,2); ?></strong></div></td>
			  
			    <td class="bodytext31" valign="center"  align="left">

			    <div align="right"><strong><?php echo number_format($total_category_netbookvalue,2); ?></strong></div></td>
			</tr>

		<?php 

		   }
		  }

		   $grandtotal_netbookvalue = $grandtotal_purchasecost - $grandtotal_accdepr;
           ?>
            
            	 <tr>

          	 <!-- <td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>  -->
               <td  colspan="3" class="bodytext31" valign="center"  align="left"><div align="left"><strong>Total : </strong></div></td> 
              
             
                <td class="bodytext31" valign="center"  align="right"><div align="right"><strong><?php echo number_format($grandtotal_purchasecost,2); ?></strong>
              	
              </div></td>
             
			  <td class="bodytext31" valign="center"  align="left">

			    <div align="right"><strong><?php echo number_format($grandtotal_accdepr,2); ?></strong></div></td>
			    <!-- <td class="bodytext31" valign="center"  align="left">

			    <div align="center"></div></td> -->
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


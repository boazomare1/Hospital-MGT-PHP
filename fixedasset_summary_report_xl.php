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

if ($frmflag2 == 'frmflag2')

{



}


/*$paymentreceiveddatefrom = $_REQUEST['ADate1'];

	$paymentreceiveddateto = $_REQUEST['ADate2'];*/

	
	if (isset($_REQUEST["categoryid"])) { $categoryid_selected = $_REQUEST["categoryid"]; } else { $categoryid_selected = ""; }
	if (isset($_REQUEST["dateto"])) { $date_range = $_REQUEST["dateto"]; } else { $date_range = ""; }


header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="FixedAssetSummary.xls"');

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

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px;FONT-FAMILY: Tahoma; text-decoration:none

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

<!-- <table style="BORDER-COLLAPSE: collapse" 

             cellspacing="0" cellpadding="4" width="800" 

            align="left" border="0">
            <tr>
            	<td   width="300" valign="center"  style="FONT-SIZE: 18px" align="center"><strong> Fixed Asset - Summary</strong></td>
            	<td colspan="4">&nbsp;</td>
            </tr>
             <tr>
            	<td    valign="center"  style="FONT-SIZE: 11px" align="center"></td>
            	<td colspan="4"></td>
            </tr>

</table>  --> 
 
	

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

              width="800" 

            align="left" border="1">

          <tbody>

          	 <tr>
            	<td colspan="5"  valign="center"  style="FONT-SIZE: 18px" align="center"><strong> Fixed Asset - Summary</strong></td>
            	 
            </tr>

             

            <tr>
            	<td width="10%" class="bodytext31" valign="center"  align="left" 

                ><div align="left"><strong>S.No.</strong></div></td>
            	<td width="15%" class="bodytext31" valign="center"  align="left" 

                ><div align="center"><strong>Category</strong></div></td>
           	  <td width="10%" class="bodytext31" valign="center"  align="left" 

                ><div align="center"><strong>Acquisition Cost</strong></div></td>
			
                 <td width="10%"  align="left" valign="center" class="bodytext31"><div align="center"><strong>Depreciation</strong></div></td>
                <!--  <td width="7%"  align="left" valign="center" 

                 class="bodytext31"><div align="center"><strong>Disposal </strong></div></td> -->

              <td width="10%" class="bodytext31" valign="center"  align="left" 

                ><div align="center"><strong>Book Value	</strong></div></td>

				    

                	                

              </tr>

           <?php
           $grand_netbookvalue = 0;
           $grand_purchasecost = 0;
           $grand_accdepreciation = 0;
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
		   	$query66 = "select sum(totalamount) as totalpurchasecost,coa,accdepreciationledgercode from assets_register where asset_category_id = $asset_category_id and entrydate<='$date_range'";
		   	 // $query66 = "select sum(rate) as totalpurchasecost from assets_register where asset_category_id = $asset_category_id ";

			 //echo 
			 
			$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res66 = mysqli_fetch_array($exec66);

			$totalpurchasecost =  $res66['totalpurchasecost'];
			$coa =  $res66['coa'];
			$accdepreciationledgercode =  $res66['accdepreciationledgercode'];
			
            
          //$query66j = "select sum(totalje) as totalje from (select sum(if(selecttype='Cr',-1*transactionamount,transactionamount)) as totalje from master_journalentries where ledgerid = '$coa' and entrydate<='$date_range'   union all SELECT sum(-1*totalamount) as totalje FROM `purchase_details` WHERE expensecode='$coa' and billnumber not like 'FAP%' and entrydate<='$date_range' and billnumber not in (select billnumber from assets_register where asset_category_id = $asset_category_id and entrydate<='$date_range') ) as a		   ";

		    $query66j = "select sum(totalje) as totalje from (select sum(if(selecttype='Cr',-1*transactionamount,transactionamount)) as totalje from master_journalentries where ledgerid = '$coa' and entrydate<='$date_range' and docno!='EN-2863'
		  union all SELECT sum(-1*totalamount) as totalje FROM assets_disposal WHERE assetledgercode='$coa' and entrydate<='$date_range'
		  union all
		  select sum(-1*depreciation) totdepamt from assets_depreciation where accdepreciationledgercode='$coa'  and depreciation_date between '2019-07-01' and '$date_range'
		  ) as a
		  ";


			$exec66j = mysqli_query($GLOBALS["___mysqli_ston"], $query66j) or die ("Error in Query77j".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res66j = mysqli_fetch_array($exec66j);
			$totalje =  $res66j['totalje'];
			$totalpurchasecost = $totalpurchasecost + $totalje;

			$grand_purchasecost = $grand_purchasecost +  $totalpurchasecost;

		   // Get assets ids for category
		   //	$assetids_arr = getCategoryAssetIds($asset_category_id);
		   //	echo '<pre>';print_r($assetids_arr);
		   	//$assetids_list = explode(delimiter, string);
		   //	$assetids_list = "'" . implode ( "', '", $assetids_arr ) . "'";
		   	//echo $assetids_list;exit;

		     $query77 = "select sum(totdepamt) as totdepamt from ( 
		   select sum(depreciation) totdepamt from assets_depreciation where accdepreciationledgercode='$accdepreciationledgercode'  and depreciation_date between '2019-07-01' and '$date_range' union all
		   select sum(if(selecttype='Dr',-1*transactionamount,transactionamount)) as totdepamt from master_journalentries where ledgerid = '$accdepreciationledgercode' and entrydate<='$date_range' 
		   union all
		   select sum(if(transaction_type='D',-1*transaction_amount,transaction_amount)) as totdepamt from tb_opening_balances where ledger_id = '$accdepreciationledgercode' and transaction_date<='$date_range'
		   union all
		   SELECT sum(-1*transaction_amount) as totalje FROM tb WHERE ledger_id='$accdepreciationledgercode' and doc_number like 'ADIS-%' and transaction_date<='$date_range'
		   
		   ) as a
		   ";
		    // $query77 = "select sum(depreciation) totdepamt from assets_depreciation where asset_id IN($assetids_list)  and depreciation_date<='$dep_till_date'";
			 //echo 
			 
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res77 = mysqli_fetch_array($exec77);

			$accdepreciation =  $res77['totdepamt'];

			$grand_accdepreciation = $grand_accdepreciation + $accdepreciation;
						
			$netbookvalue = $totalpurchasecost - $accdepreciation;

			$grand_netbookvalue = $grand_netbookvalue + $netbookvalue;
			
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
               <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $category_name; ?></div></td> 

             
                <td class="bodytext31" valign="center"  align="right"><div align="right"><?php echo number_format($totalpurchasecost,2); ?>
              	
              </div></td>
              

			  <td class="bodytext31" valign="center"  align="left">

			    <div align="right"><?php echo number_format($accdepreciation,2); ?></div></td>
			    <!-- <td class="bodytext31" valign="center"  align="left">

			    <div align="center"></div></td> -->
			    <td class="bodytext31" valign="center"  align="left">

			    <div align="right"><?php echo number_format($netbookvalue,2); ?></div></td>

			     


				</tr>

		  <?php

		  }

           ?>
             <tr>

          	 <td class="bodytext31" valign="center"  align="left"><div align="center"></div></td> 
               <td class="bodytext31" valign="center"  align="left"><div align="center"><strong>Total</strong></div></td> 

             
                <td class="bodytext31" valign="center"  align="right"><div align="right"><strong><?php echo number_format($grand_purchasecost,2); ?></strong>
              	
              </div></td>
              

			  <td class="bodytext31" valign="center"  align="left">

			    <div align="right"><strong><?php echo number_format($grand_accdepreciation,2); ?></strong></div></td>
			    <!-- <td class="bodytext31" valign="center"  align="left">

			    <div align="center"></div></td> -->
			    <td class="bodytext31" valign="center"  align="left">

			    <div align="right"><strong><?php echo number_format($grand_netbookvalue,2); ?></strong></div></td>

			     


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


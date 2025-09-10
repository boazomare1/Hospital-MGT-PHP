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


if (isset($_REQUEST["categoryid"])) { $categoryid_selected = $_REQUEST["categoryid"]; } else { $categoryid_selected = ""; }


header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="Fixed Asset-Group Net Change.xls"');

header('Cache-Control: max-age=80');

	
	




?>

<body>



	

		

<?php

	$colorloopcount=0;

	$sno=0;

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }



?>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 

            align="left" border="0">

          <tbody>

             

            <tr>
            	<!-- <td width="1%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>S.No.</strong></div></td> -->
            	<td width="6%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="left"><strong>FA Posting Group</strong></div></td>
           	  <td width="3%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="left"><strong>Field Name</strong></div></td>

			
                 <td width="3%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account No.</strong></div></td>
                <!--  <td width="7%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Disposal </strong></div></td> -->

              <td width="3%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="left"><strong>Account Name</strong></div></td>

				      <td width="3%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="right"><strong>FA Net Change</strong></div></td>

                	                

              </tr>

           <?php
           $grand_netbookvalue = 0;
           $grand_purchasecost = 0;
           $grand_accdepreciation = 0;
           $sno = 0;
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

		   	 $query66 = "select * from assets_register where asset_category_id = '$asset_category_id' and assetledger !='' and accdepreciationledger != '' and assetledgercode != '' and depreciationledgercode != '' limit 0,1";

			 //echo 
			 
			$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res66 = mysqli_fetch_array($exec66);

			$ledgerid  =  $res66['assetledgercode'];

			$accountname = $res66['assetledger'];
			
			$depreciationledgercode = $res66['depreciationledgercode']; 
			$field_name = "Acquisition Cost Account";

			$query77 = "select sum(totalamount) amt from assets_register where assetledgercode = '$ledgerid' and asset_category_id = '$asset_category_id' ";
			 
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res77 = mysqli_fetch_array($exec77);

			$ledgeramount =  $res77['amt'];
			?>


			 <tr >

          	 
               <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $category_name; ?></div></td> 

             
                <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $field_name; ?>
              	
              </div></td>
              
              <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $ledgerid; ?>
              	
              </div></td>

              <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $accountname; ?>
              	
              </div></td>
              
			  <td class="bodytext31" valign="center"  align="left">

			    <div align="right">
			    	
  			<?php	echo number_format($ledgeramount,2);
		
			    	  ?></div></td>
			   

			     


				</tr>



				<?php 

				$accountname = $res66['accdepreciationledger'];
				$accdepreciationledgercode = $res66['accdepreciationledgercode']; 

			$query666 = "select sum(transaction_amount) as amount1 from tb where ledger_id = '$accdepreciationledgercode' and remarks='Depreciation' ";
						//echo $query66;
			$exec666 = mysqli_query($GLOBALS["___mysqli_ston"], $query666) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res666 = mysqli_fetch_array($exec666);

			$ledgeramount =  $res666['amount1'];
			$ledgeramount = $ledgeramount *-1;
				
				

				$field_name = "Accum. Depreciation Account";
				?>

				<tr >

          	 
               <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $category_name; ?></div></td> 

             
                <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $field_name; ?>
              	
              </div></td>
              
              <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $accdepreciationledgercode; ?>
              	
              </div></td>

              <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $accountname; ?>
              	
              </div></td>
              
			  <td class="bodytext31" valign="center"  align="left">

			    <div align="right">
			    	
  			<?php	echo number_format($ledgeramount,2);
		
			    	  ?></div></td>
			   

			     


				</tr>

				<?php 

				$depreciationledgercode = $res66['depreciationledgercode']; 

			$query666 = "select sum(transaction_amount) as amount1 from tb where ledger_id = '$depreciationledgercode' and remarks='Depreciation' ";
						//echo $query66;
			$exec666 = mysqli_query($GLOBALS["___mysqli_ston"], $query666) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res666 = mysqli_fetch_array($exec666);

			$ledgeramount =  $res666['amount1'];
				
				$accountname = "Provision for Depreciation"; 
				//$accountname = $res66['depreciationledger'];

				$field_name = "Depreciation Expense Acc.";
				?>

				 <tr>

          	 
               <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $category_name; ?></div></td> 

             
                <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $field_name; ?>
              	
              </div></td>
              
              <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $depreciationledgercode; ?>
              	
              </div></td>

              <td class="bodytext31" valign="center"  align="right"><div align="left"><?php echo $accountname; ?>
              	
              </div></td>
              
			  <td class="bodytext31" valign="center"  align="left">

			    <div align="right">
			    	
  			<?php	echo number_format($ledgeramount,2);
		
			    	  ?></div></td>
			   

			     


				</tr>




		  <?php  }

           ?>
             
           
		

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


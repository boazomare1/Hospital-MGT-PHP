<?php
session_start();

//include ("includes/loginverify.php");
include ("db/db_connect.php");
set_time_limit(0);
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d'); 
//$username = $_SESSION['username'];
$GLOBALS['eal'] = 0;
$GLOBALS['ieledgers'] = 0;
$GLOBALS['revenue'] = 0;

//echo $searchsuppliername;
//if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d', strtotime('-0 year')); }
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ''; }
//echo $ADate1;
//if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ''; }

 if (isset($_REQUEST["ADate1"])) { $from_date = $_REQUEST["ADate1"]; } else { $from_date = ''; }
 if (isset($_REQUEST["ADate2"])) { $to_date = $_REQUEST["ADate2"]; } else { $to_date = ''; }


//echo $searchsuppliername;
if (isset($_REQUEST["ADate3"])) { $ADate3 = $_REQUEST["ADate3"]; } else { $ADate3 = date('Y-m-d', strtotime('-0 year')); }
//echo $ADate1;
if (isset($_REQUEST["ADate4"])) { $ADate4 = $_REQUEST["ADate4"]; } else { $ADate4 = date('Y-m-d'); }
//echo $amount;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }


if (isset($_REQUEST["includeopenbal"])) { $includeopenbal = $_REQUEST["includeopenbal"]; } else { $includeopenbal = ""; }



if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }

header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="Trial Incomestatement '.$ADate1.'  to  '.$ADate2.'.xls"');

header('Cache-Control: max-age=80');  
//$frmflag2 = $_POST['frmflag2'];
if($location==''){
$locationwise="and locationcode like '%%'";
} else{
$locationwise="and locationcode = '$location'";
}
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


<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext44 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none; font-weight:bold
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
/* collpase table*/

</style>
</head>


 
<body>



<div id="tblData" class="container-full">
	<?php
	// if(isset($_REQUEST["cbfrmflag1"])){
	?>
	<div class="row">
		<div class="col-6">
		
			<table>
				<tr>
				<?php 
				$q1 = "SELECT companyname, address2 FROM master_company";
				$ex = mysqli_query($GLOBALS["___mysqli_ston"], $q1) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res = mysqli_fetch_array($ex);
				$hospitalname = $res['companyname'];
				$area = $res['address2'];
				?>
				<td align="center" colspan="7" ><b><?php echo $hospitalname.', '.$area ?></b></td>
				</tr>
				<tr>
					<td align="center" colspan="7" ><b>BranchIncome Statement</b></td>
				</tr>
				<tr>
					<td align="center" colspan="7" ><b>From   <?php echo $ADate2  ?>   To <?php echo $ADate2  ?></b></td>
				</tr>
			</table>
			<?php

				$from_date = $ADate1;
				$to_date = $ADate2;

				$balance_sheet = 0;
				$income_statement = 0;

				echo "<table id='collapsed' border='1' style='
				    width: 75%;background-color:#fff;
				    font-size: 12.5px;border:0px;
				' cellpadding='1' cellspacing='2'>";
				    echo '<tr bgcolor="#011E6A">
	              <td colspan="5" bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
	              </tr>';

					echo "<tr style='background-color: #4fc7fd;'><td>#</td> <td><b>Code</b></td> <td><b>Ledger</b></td> <td><b>Closing</b></td> </tr>";

				//$query = "select auto_number as uid,id as code,accountsmain as name,section from master_accountsmain where section in ('A','E')  order by section";
				$query = "select auto_number as uid,id as code,accountsmain as name,section from master_accountsmain where tb_group = 'I' order by id";
				$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));

				$sno = 0;
				while($res = mysqli_fetch_array($exec))
				{       
 						$sno = $sno + 1;
						$opening_dr_cr = 0;
						$opening_dr_cr1= 0;
						$transaction_dr = 0;
						$transaction_cr = 0;
						$closing_dr_cr = 0;
						$section = $res['section'];
						$uid = $res['uid'];

							$array_ledgers_ids = array();
							$query_ledger_ids = "select id from master_accountname where accountssub in(select auto_number from master_accountssub where accountsmain ='".$res['uid']."')";
								$exec_ledger_ids = mysqli_query($GLOBALS["___mysqli_ston"], $query_ledger_ids) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
								while($res_ledger_ids = mysqli_fetch_array($exec_ledger_ids)){
									array_push($array_ledgers_ids, $res_ledger_ids['id']);
								}

							$ledger_ids = implode("','", $array_ledgers_ids);



							$startyear =  date('Y',strtotime($from_date));
							$endyear =  date('Y',strtotime($to_date));

							$opening_dr_cr=0;
								$transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate)  as transaction_amount from tb where record_status='1' and ledger_id in ('".$ledger_ids."')  and ledger_id!='' and transaction_date between '".$from_date."' and '".$to_date."' $locationwise group by transaction_type ";
								$exec_transaction = mysqli_query($GLOBALS["___mysqli_ston"], $transaction_query) or die ("Error in transaction_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
								while($res_transaction = mysqli_fetch_array($exec_transaction)){
									if($res_transaction['transaction_type']=="D"){
										$transaction_dr += $res_transaction['transaction_amount'];
									}else{
										$transaction_cr += $res_transaction['transaction_amount'];
									}
								}

							
								
								if($uid=='4'){
								$closing_dr_cr =  -$transaction_cr;
								}elseif($uid=='5'){
								$closing_dr_cr =  $transaction_cr;	
								}else{
								$closing_dr_cr = $opening_dr_cr + $transaction_dr - $transaction_cr;	
								}
								
								
								$balance_sheet += $closing_dr_cr;
								echo "<tbody>";
						 		echo "<tr style='background-color: #ecf0f5;' data-node-id='".$sno."'><td></td> <td>"."'".$res['code']."</td> <td>".ucwords(strtolower($res['name']))."</td>  <td  align='right'>".showAmount($closing_dr_cr,'1')."</td> </tr> </li>";
								
								echo getSubgroups($res['uid'],$from_date,$to_date,$sno,$locationwise,$includeopenbal);
								echo "</tbody>";
				}

					$t1 = showAmount(net_profit1($from_date,$to_date),1);
					echo "<tr style='font-weight:bold;'> <td colspan='2' align='right'>P & L : </td> <td  colspan='2' align='right'>".showAmount($balance_sheet,'1')." </td> </tr>";
					//echo "<tr style='font-weight:bold;'> <td colspan='4' align='right'>Total : </td> <td  colspan='2' align='right'>".showAmount(net_profit1($from_date,$to_date),1)." </td> </tr>";

					//echo "<tr> <td colspan='5' align='right'> </td> <td  align='right'>".showAmount($balance_sheet+net_profit($from_date,$to_date),1)." </td> </tr>";

					//echo "<tr> <td colspan='5' align='right'>Net Profit : </td> <td  align='right'>".showAmount(-1*net_profit($from_date,$to_date),1)." </td> </tr>";
			    echo "</table>"
		       ?>
		   </div>
		   <div class="col-6">
			
		</div>
		<div class="col-12">
			<table border='0' style='width: 50%; font-size: initial;border:0px;' cellpadding='4' cellspacing='0' border="0">
				<tr>
					<td>&nbsp;</td>
				</tr>
					<?php 
				$pur_amount=0;
				$query299 = "select sum(transaction_amount) as pur_amount from tb where ledger_id='02-1000-1' and transaction_date between '$ADate1' and '$ADate2' and transaction_type='D' $locationwise order by transaction_date asc";
				$exec299 = mysqli_query($GLOBALS["___mysqli_ston"], $query299) or die ("Error in Query299".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res299 = mysqli_fetch_array($exec299);		
				$pur_amount = $res299['pur_amount'];
				
				$inv_amount=0;
				$query2999 = "select sum(totalprice) as inv_amount from transaction_stock where batch_stockstatus='1' $locationwise  ";
				$exec2999 = mysqli_query($GLOBALS["___mysqli_ston"], $query2999) or die ("Error in Query2999".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res2999 = mysqli_fetch_array($exec2999);		
				$inv_amount = $res2999['inv_amount'];
				?>
				
				
				<tr style='font-weight:bold;background: #fff;'> 
					<td colspan='4' align='right'>Total Purchases: </td> 
					<td  colspan='2' align='right'><?php echo number_format($pur_amount,1,'.',','); ?></td> 
				</tr>
				<tr style='font-weight:bold;background: #fff;'> 
					<td colspan='4' align='right'>Inventory As < <?php echo date('d-m-Y',strtotime($updatedatetime)); ?> >: </td> 
					<td  colspan='2' align='right'><?php echo number_format($inv_amount,1,'.',','); ?></td> 
				</tr>
			</table>
		</div>
	</div>
    <?php //} ?>
</div>

<?php
function getSubgroups($account_id,$from_date,$to_date,$sno,$locationwise,$includeopenbal){

	$subgroup_query = "select auto_number as uid, id as code,accountssub as name,show_ledger from master_accountssub where accountsmain='$account_id' order by auto_number";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $subgroup_query) or die ("Error in subgroup_query".mysqli_error($GLOBALS["___mysqli_ston"]));
	$data = "";
    
    $sno2 = 0;
	while($res = mysqli_fetch_array($exec))
	{   
		$sno2 = $sno2 + 1;
		getGroupBalance($res['uid'],$from_date,$to_date,$sno,$sno2,$locationwise,$includeopenbal);		
	}

	return $data;
}

function getLedger($group_id,$from_date,$to_date,$sno,$sno2,$locationwise,$includeopenbal){
	$ledger_query = "select auto_number as uid, id as code,accountname as name from master_accountname where accountssub='$group_id' order by auto_number";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $ledger_query) or die ("Error in ledger_query".mysqli_error($GLOBALS["___mysqli_ston"]));
	$data = "";
    
    $sno3 = 0;
	while($res = mysqli_fetch_array($exec))
	{   
		$sno3 = $sno3 + 1;

		$opening_dr_cr = 0;
		$transaction_dr = 0;
		$transaction_cr = 0;
		$closing_dr_cr = 0;
		$old_opening_dr_cr  = 0;
		
	$startyear =  date('Y',strtotime($from_date));
	$endyear =  date('Y',strtotime($to_date));
	//$financeyearstart = $startyear.'-01-01';	
	
	
	if($includeopenbal=='0'){
	$financeyearstart=$from_date;
	//$openingenddate=$to_date;
	}else{
	$financeyearstart = $startyear.'-01-01';
	//$openingenddate = date('Y-m-d',strtotime('-1 day', strtotime($from_date)));
	}
	
	
		$ledgerid = $res['code'];
		$query12 = "SELECT accountsmain FROM master_accountname WHERE id= '$ledgerid'";
		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in query12".mysqli_error($GLOBALS["___mysqli_ston"]));; 
		$res12= mysqli_fetch_array($exec12);
		$accountsmain12 = $res12['accountsmain'];
	
			
	$query1 = "SELECT section,auto_number FROM master_accountsmain WHERE auto_number = '$accountsmain12'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	$section = $res1['section'];		
	$uid = $res1['auto_number'];	
	/* if($includeopenbal=='1'){
	$opening_query = "select ledger_id,transaction_date,transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id='".$res['code']."'  and ledger_id!='' and transaction_date < '".$from_date."' $locationwise group by transaction_type,transaction_date ";
		$exec_opening = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res_opening = mysqli_fetch_array($exec_opening)){
			$transactiondate = $res_opening['transaction_date'];

			if($section == 'I' || $section == 'E' ){
				
				if($transactiondate < $financeyearstart){
					
					if($res_opening['transaction_type']=="D"){
						$old_opening_dr_cr += $res_opening['transaction_amount'];
					}
					else{
						$old_opening_dr_cr -= $res_opening['transaction_amount'];
					}					
				}
				else{
					
					if($res_opening['transaction_type']=="D"){
						$opening_dr_cr += $res_opening['transaction_amount'];
					}
					else{
						$opening_dr_cr -= $res_opening['transaction_amount'];
					}
					
				}
				if($from_date == $financeyearstart){
					$opening_dr_cr = 0;
				}
			}	
			else{
				
				if($res_opening['transaction_type']=="D"){
					$opening_dr_cr += $res_opening['transaction_amount'];
				}else{
					$opening_dr_cr -= $res_opening['transaction_amount'];
				}

			}
				
		}
	} else{
			$old_opening_dr_cr=0;
			$opening_dr_cr=0;
	}
	
		 		$query01 = "SELECT retainedearning_ledger FROM master_company";
				$exec01 = mysqli_query($GLOBALS["___mysqli_ston"], $query01) or die ("Error in query01".mysqli_error($GLOBALS["___mysqli_ston"]));; 
				$res01 = mysqli_fetch_array($exec01);
				$retainedledger = $res01['retainedearning_ledger'];

				if($retainedledger == $res['code']){
					
						 $opening_dr_cr += $GLOBALS['ieledgers'];
					
				}	 */
		$opening_dr_cr=0;
		$transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate)  as transaction_amount from tb where record_status='1' and ledger_id='".$res['code']."'  and ledger_id!='' and transaction_date between '".$from_date."' and '".$to_date."' $locationwise group by transaction_type ";
		$exec_transaction = mysqli_query($GLOBALS["___mysqli_ston"], $transaction_query) or die ("Error in transaction_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
		while($res_transaction = mysqli_fetch_array($exec_transaction)){
			if($res_transaction['transaction_type']=="D"){
				$transaction_dr += $res_transaction['transaction_amount'];
			}else{
				$transaction_cr += $res_transaction['transaction_amount'];
			}
		}

		if($uid=='4'){
		$closing_dr_cr =  -$transaction_cr;
		}elseif($uid=='5'){
		$closing_dr_cr =  $transaction_cr;	
		}else{
		$closing_dr_cr = $opening_dr_cr + $transaction_dr - $transaction_cr;	
		}
								
		 $ledgercode = $res['code'];

		
		 $data .="<tr data-node-id=".$sno.'.'.$sno2.'.'.$sno3." data-node-pid=".$sno.'.'.$sno2." > <td></td><td>"."'".$res['code']."</td> <td>".ucwords(strtolower($res['name']))."&nbsp;"."</td>  <td  align='right'>".showAmount($closing_dr_cr,'1')."</td> </tr>";
		
	}

	return $data;	
}

function showAmount($amount,$show_rule){
	if($show_rule=='1'){
		if($amount>=0){
			return "Dr ".number_format(abs($amount),2);
		}else{
			return "Cr ".number_format(abs($amount),2);
		}
	}else{
		return number_format(abs($amount),2);
	}
}

function getAllLedgers($group_id){

	$array_data = [];

$subgroup_query = "select auto_number as uid, id as code,accountssub as name,show_ledger from master_accountssub where accountsmain='$group_id' order by auto_number";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $subgroup_query) or die ("Error in subgroup_query".mysqli_error($GLOBALS["___mysqli_ston"]));
	$data = "";
	while($res = mysqli_fetch_array($exec))
	{
		$ledger_query1 = "select id as code from master_accountname where accountssub='".$res['code']."' order by auto_number";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $ledger_query1) or die ("Error in ledger_query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$data = "";

			while($res1 = mysqli_fetch_array($exec1))
			{
				array_push($array_data, $res1['code']);
			}

			getAllLedgers($res['code']);
	}	

	$ledger_query1 = "select id as code from master_accountname where accountssub='$group_id' order by auto_number";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $ledger_query1) or die ("Error in ledger_query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$data = "";

	while($res1 = mysqli_fetch_array($exec1))
	{
		array_push($array_data, $res1['code']);
	}


	return $array_data;

}

function getGroupBalance($group_id,$from_date,$to_date,$sno,$sno2,$locationwise,$includeopenbal){
	$data = "";
	$all_ledgers = getAllLedgers($group_id);
	//$GLOBALS['ieledgers'] = '';
	
	$subgroup_query = "select auto_number as uid, id as code,accountssub as name,show_ledger from master_accountssub where auto_number='$group_id' ";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $subgroup_query) or die ("Error in subgroup_query".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res = mysqli_fetch_array($exec))
	{

		$opening_dr_cr = 0;
		$transaction_dr = 0;
		$transaction_cr = 0;
		$closing_dr_cr = 0;
		$opening_dr_cr1 = 0;
		
	$query0 = " SELECT accountsmain FROM master_accountssub WHERE auto_number = '$group_id'";
	$exec0 = mysqli_query($GLOBALS["___mysqli_ston"], $query0) or die ("Error in query0".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res0 = mysqli_fetch_array($exec0);
	$accountsmain = $res0['accountsmain'];
	
	$query1 = "SELECT section,auto_number FROM master_accountsmain WHERE auto_number = '$accountsmain'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	$section = $res1['section'];			
	$uid = $res1['auto_number'];	
		$startyear =  date('Y',strtotime($from_date));
		$endyear =  date('Y',strtotime($to_date));	
		
	/* 	if($section == 'I' || $section == 'E' ){
			
			//$financeyearstart = $startyear.'-01-01';
			
			if($includeopenbal=='0'){
			$financeyearstart=$from_date;
			$openingenddate=$to_date;
			}else{
			$financeyearstart = $startyear.'-01-01';
			$openingenddate = date('Y-m-d',strtotime('-1 day', strtotime($to_date)));
			}
			
			 $opening_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('".implode("','",$all_ledgers)."')  and ledger_id!='' and transaction_date BETWEEN '$financeyearstart' AND '$from_date' $locationwise group by transaction_type ";
			$exec_opening = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res_opening = mysqli_fetch_array($exec_opening))
			{
				if($res_opening['transaction_type']=="D"){
					$opening_dr_cr += $res_opening['transaction_amount'];
				}
				else{
					$opening_dr_cr -= $res_opening['transaction_amount'];
				}
			}		
			if($from_date == $financeyearstart){
				$opening_dr_cr = 0;
			}
			//echo $section.'===>'.$opening_dr_cr;
			//echo '<br>';
			if($includeopenbal=='1'){
			$opening_query1 = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('".implode("','",$all_ledgers)."')  and ledger_id!='' and transaction_date < '$financeyearstart' $locationwise  group by transaction_type ";
			$exec_opening1 = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query1) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res_opening1 = mysqli_fetch_array($exec_opening1))
			{
				if($res_opening1['transaction_type']=="D"){
					$opening_dr_cr1 += $res_opening1['transaction_amount'];
					//$GLOBALS['ieledgers'] = $GLOBALS['ieledgers']+ $opening_dr_cr1;
				}
				else{
					$opening_dr_cr1 -= $res_opening1['transaction_amount'];
					//$GLOBALS['ieledgers'] = $GLOBALS['ieledgers']+ $opening_dr_cr1;
				}
			}
			} else{
					$opening_dr_cr1=0;
			}
			
		$GLOBALS['ieledgers'] += $opening_dr_cr1;
		}
		else{

			if($includeopenbal=='1'){
			 $opening_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and (ledger_id in ('".implode("','",$all_ledgers)."'))  and ledger_id!='' and transaction_date < '".$from_date."' $locationwise group by transaction_type ";

			$exec_opening = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res_opening = mysqli_fetch_array($exec_opening)){
				if($res_opening['transaction_type']=="D"){
					$opening_dr_cr += $res_opening['transaction_amount'];
				}else{
					$opening_dr_cr -= $res_opening['transaction_amount'];
				}
			}
			} else{
					$opening_dr_cr=0;
			}
			if($res['code'] == '03-4500'){
				$opening_dr_cr += $GLOBALS['ieledgers'];
			}
			
		} */
		$opening_dr_cr=0;
		$transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate)  as transaction_amount from tb where record_status='1' and  ledger_id in ('".implode("','",$all_ledgers)."')  and ledger_id!='' and transaction_date between '".$from_date."' and '".$to_date."' $locationwise group by transaction_type ";
		$exec_transaction = mysqli_query($GLOBALS["___mysqli_ston"], $transaction_query) or die ("Error in transaction_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
		while($res_transaction = mysqli_fetch_array($exec_transaction)){
			if($res_transaction['transaction_type']=="D"){
				$transaction_dr += $res_transaction['transaction_amount'];
			}else{
				$transaction_cr += $res_transaction['transaction_amount'];
			}
		}

		if($uid=='4'){
		$closing_dr_cr =  -$transaction_cr;
		}elseif($uid=='5'){
		$closing_dr_cr =  $transaction_cr;	
		}else{
		$closing_dr_cr = $opening_dr_cr + $transaction_dr - $transaction_cr;	
		}
								
		
         $uuid = $res['uid'] + 1;
		 $data .="<tr  style='background-color: aquamarine;' data-node-id=".$sno.'.'.$sno2." data-node-pid=".$sno."><td></td> <td>"."'".$res['code']."</td> <td>".ucwords(strtolower($res['name']))."</td> <td  align='right'>".showAmount($closing_dr_cr,'1')."</td> </tr>";
		
	 if($res['show_ledger']=="1"){
		 	 $data .=getLedger($res['uid'],$from_date,$to_date,$sno,$sno2,$locationwise,$includeopenbal);
		 }

	}

	echo $data;

}

function net_profit1($from_date,$to_date){
	$query = "select auto_number as uid,id as code,accountsmain as name from master_accountsmain where section in ('A','E')  order by auto_number";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
	$closing_dr_cr = 0;

	while($res = mysqli_fetch_array($exec))
	{

			$opening_dr_cr = 0;
			$transaction_dr = 0;
			$transaction_cr = 0;
		$uid = $res['uid'];
			$array_ledgers_ids = array();
			$query_ledger_ids = "select id from master_accountname where accountssub in(select auto_number from master_accountssub where accountsmain ='".$res['uid']."')";
				$exec_ledger_ids = mysqli_query($GLOBALS["___mysqli_ston"], $query_ledger_ids) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
				while($res_ledger_ids = mysqli_fetch_array($exec_ledger_ids)){
					array_push($array_ledgers_ids, $res_ledger_ids['id']);
				}

			$ledger_ids = implode("','", $array_ledgers_ids);

				/* $opening_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('".$ledger_ids."')  and ledger_id!=''  and transaction_date < '".$from_date."' group by transaction_type  ";
					$exec_opening = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
					while($res_opening = mysqli_fetch_array($exec_opening)){
						if($res_opening['transaction_type']=="D"){
							$opening_dr_cr += $res_opening['transaction_amount'];
						}else{
							$opening_dr_cr -= $res_opening['transaction_amount'];
						}
					}
				 */
					$transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate)  as transaction_amount from tb where record_status='1' and ledger_id in ('".$ledger_ids."')  and ledger_id!='' and transaction_date between '".$from_date."' and '".$to_date."' group by transaction_type ";
					$exec_transaction = mysqli_query($GLOBALS["___mysqli_ston"], $transaction_query) or die ("Error in transaction_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
					while($res_transaction = mysqli_fetch_array($exec_transaction)){
						if($res_transaction['transaction_type']=="D"){
							$transaction_dr += $res_transaction['transaction_amount'];
						}else{
							$transaction_cr += $res_transaction['transaction_amount'];
						}
					}

					if($uid=='4' || $uid=='5'){
					$closing_dr_cr += $opening_dr_cr  - $transaction_cr;
					}else{
					$closing_dr_cr += $opening_dr_cr + $transaction_dr - $transaction_cr;	
					}
	}
		return $closing_dr_cr;				
}

function net_profit3($from_date,$to_date){
	$query = "select auto_number as uid,id as code,accountsmain as name from master_accountsmain where section in ('L')  order by section,auto_number";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
	$closing_dr_cr = 0;

	while($res = mysqli_fetch_array($exec))
	{
            //print_r($res);
			$opening_dr_cr = 0;
			$transaction_dr = 0;
			$transaction_cr = 0;

			$array_ledgers_ids = array();
			$query_ledger_ids = "select id from master_accountname where accountssub in(select auto_number from master_accountssub where accountsmain ='".$res['uid']."')";
				$exec_ledger_ids = mysqli_query($GLOBALS["___mysqli_ston"], $query_ledger_ids) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
				while($res_ledger_ids = mysqli_fetch_array($exec_ledger_ids)){
					array_push($array_ledgers_ids, $res_ledger_ids['id']);
				}

			$ledger_ids = implode("','", $array_ledgers_ids);

				$opening_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('".$ledger_ids."')  and ledger_id!=''  and transaction_date < '".$from_date."' group by transaction_type  ";
				//echo $opening_query;
					$exec_opening = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
					while($res_opening = mysqli_fetch_array($exec_opening)){
						if($res_opening['transaction_type']=="D"){
							$opening_dr_cr += $res_opening['transaction_amount'];
						}else{
							$opening_dr_cr -= $res_opening['transaction_amount'];
						}
						//echo $closing_dr_cr;
					}
				
					$transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate)  as transaction_amount from tb where record_status='1' and ledger_id in ('".$ledger_ids."')  and ledger_id!='' and transaction_date between '".$from_date."' and '".$to_date."' group by transaction_type ";
                    //echo $transaction_query;
					$exec_transaction = mysqli_query($GLOBALS["___mysqli_ston"], $transaction_query) or die ("Error in transaction_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
					while($res_transaction = mysqli_fetch_array($exec_transaction)){
						//print_r($res_transaction);
						if($res_transaction['transaction_type']=="D"){
							$transaction_dr += $res_transaction['transaction_amount'];
						}else{
							$transaction_cr += $res_transaction['transaction_amount'];
						}
						//echo $transaction_cr.'<br>';echo $transaction_dr.'<br>';
					}
					// echo $closing_dr.'<br>';
					//$closing_dr_cr += $opening_dr_cr + $transaction_dr - $transaction_cr;
					//echo $closing_dr_cr;
	}
		return $closing_dr_cr;				
}
?>




</body>
</html>

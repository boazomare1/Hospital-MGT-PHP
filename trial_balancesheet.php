
<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
set_time_limit(0);
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d'); 
$username = $_SESSION['username'];

//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = '2019-05-01'; } else { $ADate1 = '2019-05-01'; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }

//echo $searchsuppliername;
if (isset($_REQUEST["ADate3"])) { $ADate3 = $_REQUEST["ADate3"]; } else { $ADate3 = date('Y-m-d', strtotime('-0 year')); }
//echo $ADate1;
if (isset($_REQUEST["ADate4"])) { $ADate4 = $_REQUEST["ADate4"]; } else { $ADate4 = date('Y-m-d'); }
//echo $amount;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

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
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />   
<link rel="stylesheet" type="text/css" href="css/simple-grid.min.css" />  
<link rel="stylesheet" href="css/jquery-simple-tree-table.css">   
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
/* grid */
* {
  box-sizing: border-box;
}
main {
  max-width: 1200px;
  margin: 10px auto;
  padding: 0 5px;
  width: 100%; 
  display: grid;
  /* Define Auto Row size */
  grid-auto-rows: 100px; 
  /*Define our columns */
  grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); 
  grid-gap: 1em;
}

article {
  border-radius: 1px;
  padding: 5px;
  color: #fff;
}

article:nth-child(odd) {
  /*background-color: #fff;*/
}

article:nth-child(even) {
  /*background-color: #fff;*/
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>
 
<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
</table>	

<form name="cbform1" method="post" action="trial_balancesheet.php">
<div class="row">
	<div class="col-8">
		<table  width="100%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse;">
			<tbody>
		    <tr bgcolor="#011E6A">
		      <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Balance Sheet</strong></td>
		      </tr>
		     <tr>
		              <!--<td width="15%"  align="right" valign="center" 
		        bgcolor="#FFFFFF" class="bodytext31"> Start Date </td>
		              <td width="40%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
					    <input type="text" name="ADate1" id="ADate1" readonly style="border: 1px solid #001E6A" value="<?php //echo $ADate1; ?>"  size="10" onKeyDown="return disableEnterKey()" />
							<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </span></td>-->
						<td width="15%"  align="right" valign="center" 
		        bgcolor="#FFFFFF" class="bodytext31"> As on Date </td>
		              <td width="63%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
		                <input name="ADate2" id="ADate2" readonly style="border: 1px solid #001E6A" value="<?php echo $ADate2; ?>"  size="10" onKeyDown="return disableEnterKey()" />
		          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
		               
		        </tr>	
		    <tr>
		      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="border: 1px solid #001E6A; text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
		      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
		          <input  style="border: 1px solid #001E6A" type="submit" value="Submit" name="Submit" />
		          <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td>
		    </tr>
		  </tbody>
		</table>
	</div>
	<div class="col-4">
		<div style="text-align:left;">
			<a href="print_trialbalancesheet.php?ADate2=<?php echo $ADate2; ?>" id="downloadLink" target="_blank"><img src="images25/excel-xls-icon.png" alt="excel export" width="50px" height="50px"/></a>
		</div>
	</div>
</div>
<div id="table" class="row">
	<div class="col-6">
		<?php

			$from_date = $ADate1;
			$to_date = $ADate2;

			$balance_sheet = 0;
			$income_statement = 0;

			echo "<table id='collapsed' border='0' style='
			    width: 100%;background-color:#fff;
			    font-size: 13px;border:0px;
			' cellpadding='1' cellspacing='2'>";
			    echo '<tr bgcolor="#011E6A">
              <td colspan="7" bgcolor="#ecf0f5" class="bodytext3"><strong>Assets</strong></td>
              </tr>';

				echo "<tr style='background-color: #4fc7fd;'><td>#</td> <td>Opening</td> <td>Code</td> <td>Ledger</td> <td>Debit</td>  <td>Credit</td> <td>Closing</td> </tr>";


			$query = "select auto_number as uid,id as code,accountsmain as name from master_accountsmain where section in ('A')  order by auto_number";
			$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));

			$sno = 0;
			while($res = mysqli_fetch_array($exec))
			{
					$sno = $sno + 1;
					$opening_dr_cr = 0;
					$transaction_dr = 0;
					$transaction_cr = 0;
					$closing_dr_cr = 0;

						$array_ledgers_ids = array();
						$query_ledger_ids = "select id from master_accountname where accountssub in(select auto_number from master_accountssub where accountsmain ='".$res['uid']."')";
							$exec_ledger_ids = mysqli_query($GLOBALS["___mysqli_ston"], $query_ledger_ids) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
							while($res_ledger_ids = mysqli_fetch_array($exec_ledger_ids)){
								array_push($array_ledgers_ids, $res_ledger_ids['id']);
							}

						$ledger_ids = implode("','", $array_ledgers_ids);

						$opening_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('".$ledger_ids."') and ledger_id!='' and transaction_date < '".$from_date."' group by transaction_type ";
							$exec_opening = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
							while($res_opening = mysqli_fetch_array($exec_opening)){
								if($res_opening['transaction_type']=="D"){
									$opening_dr_cr += $res_opening['transaction_amount'];
								}else{
									$opening_dr_cr -= $res_opening['transaction_amount'];
								}
							}
						
							$transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate)  as transaction_amount from tb where record_status='1' and ledger_id in ('".$ledger_ids."')  and ledger_id!='' and transaction_date between '".$from_date."' and '".$to_date."' group by transaction_type ";
							$exec_transaction = mysqli_query($GLOBALS["___mysqli_ston"], $transaction_query) or die ("Error in transaction_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
							while($res_transaction = mysqli_fetch_array($exec_transaction)){
								if($res_transaction['transaction_type']=="D"){
									$transaction_dr += $res_transaction['transaction_amount'];
								}else{
									$transaction_cr += $res_transaction['transaction_amount'];
								}
							}

							$closing_dr_cr = $opening_dr_cr + $transaction_dr - $transaction_cr;
							
							$balance_sheet += $closing_dr_cr;


					 echo "<tr style='background-color: #ecf0f5;' data-node-id='".$sno."'> <td></td><td  align='right'>".showAmount($opening_dr_cr,'1')."</td> <td>".$res['code']."</td> <td>".ucwords(strtolower($res['name']))."</td> <td  align='right'>".showAmount($transaction_dr,'0')."</td>  <td  align='right'>".showAmount($transaction_cr,'0')."</td> <td  align='right'>".showAmount($closing_dr_cr,'1')."</td> </tr>";

				echo getSubgroups($res['uid'],$from_date,$to_date,$sno);
			}

				//$t1 = showAmount(net_profit($from_date,$to_date),1);
				echo "<tr style='font-weight:bold;'> <td colspan='4' align='right'>Total : </td> <td  colspan='2' align='right'>".showAmount(net_profit1($from_date,$to_date),1)." </td> </tr>";

				//echo "<tr> <td colspan='5' align='right'> </td> <td  align='right'>".showAmount($balance_sheet+net_profit($from_date,$to_date),1)." </td> </tr>";

				//echo "<tr> <td colspan='5' align='right'>Net Profit : </td> <td  align='right'>".showAmount(-1*net_profit($from_date,$to_date),1)." </td> </tr>";
		    echo "</table>"
	       ?>
	</div>
	<div class="col-6">
		<?php

			echo "<table id='basic' border='0' style='
			    width: 100%;background-color:#fff;
			    font-size: 12.5px;border:0px;
			' cellpadding='1' cellspacing='2'>";
				echo '<tr bgcolor="#011E6A">
              <td colspan="7" bgcolor="#ecf0f5" class="bodytext3"><strong>Liabilities</strong></td>
              </tr>';

				echo "<tr style='background-color: #4fc7fd;'> <td>#</td><td>Opening</td> <td>Code</td> <td>Ledger</td> <td>Debit</td>  <td>Credit</td> <td>Closing</td> </tr>";
				$query = "select auto_number as uid,id as code,accountsmain as name from master_accountsmain where section in ('L')  order by auto_number";
				$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));

				$sno = 0;
				while($res = mysqli_fetch_array($exec))
				{

						$sno = $sno + 1;
						$opening_dr_cr = 0;
						$transaction_dr = 0;
						$transaction_cr = 0;
						$closing_dr_cr = 0;

							$array_ledgers_ids = array();
							$query_ledger_ids = "select id from master_accountname where accountssub in(select auto_number from master_accountssub where accountsmain ='".$res['uid']."')";
								$exec_ledger_ids = mysqli_query($GLOBALS["___mysqli_ston"], $query_ledger_ids) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
								while($res_ledger_ids = mysqli_fetch_array($exec_ledger_ids)){
									array_push($array_ledgers_ids, $res_ledger_ids['id']);
								}

							$ledger_ids = implode("','", $array_ledgers_ids);


							$opening_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('".$ledger_ids."')  and ledger_id!='' and transaction_date < '".$from_date."' group by transaction_type ";
								$exec_opening = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
								while($res_opening = mysqli_fetch_array($exec_opening)){
									if($res_opening['transaction_type']=="D"){
										$opening_dr_cr += $res_opening['transaction_amount'];
									}else{
										$opening_dr_cr -= $res_opening['transaction_amount'];
									}
								}
							
								$transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate)  as transaction_amount from tb where record_status='1' and ledger_id in ('".$ledger_ids."')  and ledger_id!='' and transaction_date between '".$from_date."' and '".$to_date."' group by transaction_type ";
								$exec_transaction = mysqli_query($GLOBALS["___mysqli_ston"], $transaction_query) or die ("Error in transaction_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
								while($res_transaction = mysqli_fetch_array($exec_transaction)){
									if($res_transaction['transaction_type']=="D"){
										$transaction_dr += $res_transaction['transaction_amount'];
									}else{
										$transaction_cr += $res_transaction['transaction_amount'];
									}
								}

								$closing_dr_cr = $opening_dr_cr + $transaction_dr - $transaction_cr;

								$income_statement += $closing_dr_cr;

						 echo "<tr style='background-color: #ecf0f5;' data-node-id='".$sno."'> <td></td><td  align='right'>".showAmount($opening_dr_cr,'1')."</td> <td>".$res['code']."</td> <td>".ucwords(strtolower($res['name']))."</td> <td  align='right'>".showAmount($transaction_dr,'0')."</td>  <td  align='right'>".showAmount($transaction_cr,'0')."</td> <td  align='right'>".showAmount($closing_dr_cr,'1')."</td> </tr>";

					echo getSubgroups($res['uid'],$from_date,$to_date,$sno);

				}
                    //$t2 = showAmount(-1*net_profit($from_date,$to_date)+$income_statement,1);
					echo "<tr style='font-weight:bold'> <td colspan='4' align='right'>Total </td> <td  colspan='2' align='right'>".showAmount(-1*net_profit2($from_date,$to_date)+$income_statement,1)." </td> </tr>";
			echo "</table>";
		?>
	</form>

	</div>
</div>
</form>
<?php
function getSubgroups($account_id,$from_date,$to_date,$sno){

	$subgroup_query = "select auto_number as uid, id as code,accountssub as name,show_ledger from master_accountssub where accountsmain='$account_id' order by auto_number";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $subgroup_query) or die ("Error in subgroup_query".mysqli_error($GLOBALS["___mysqli_ston"]));
	$data = "";

	$sno2 = 0;
	while($res = mysqli_fetch_array($exec))
	{	
		$sno2 = $sno2 + 1;
		getGroupBalance($res['uid'],$from_date,$to_date,$sno,$sno2);		
	}

	return $data;
}

function getLedger($group_id,$from_date,$to_date,$sno,$sno2){
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

	$opening_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id='".$res['code']."'  and ledger_id!='' and transaction_date < '".$from_date."' group by transaction_type ";
		$exec_opening = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
		while($res_opening = mysqli_fetch_array($exec_opening)){
			if($res_opening['transaction_type']=="D"){
				$opening_dr_cr += $res_opening['transaction_amount'];
			}else{
				$opening_dr_cr -= $res_opening['transaction_amount'];
			}
		}
	
		$transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate)  as transaction_amount from tb where record_status='1' and ledger_id='".$res['code']."'  and ledger_id!='' and transaction_date between '".$from_date."' and '".$to_date."' group by transaction_type ";
		$exec_transaction = mysqli_query($GLOBALS["___mysqli_ston"], $transaction_query) or die ("Error in transaction_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
		while($res_transaction = mysqli_fetch_array($exec_transaction)){
			if($res_transaction['transaction_type']=="D"){
				$transaction_dr += $res_transaction['transaction_amount'];
			}else{
				$transaction_cr += $res_transaction['transaction_amount'];
			}
		}

		$closing_dr_cr = $opening_dr_cr + $transaction_dr - $transaction_cr;

		 $ledgercode = $res['code'];

		 $data .="<tr data-node-id=".$sno.'.'.$sno2.'.'.$sno3." data-node-pid=".$sno.'.'.$sno2." > <td></td><td  align='right'>".showAmount($opening_dr_cr,'1')."</td> <td>".$res['code']."</td> <td>".ucwords(strtolower($res['name']))."&nbsp;<a href='ledgerview.php?ledgerid=$ledgercode&&ADate1=$from_date&&ADate2=$to_date' target='_blank' style='font-size:13px;'>&#9432;</a>"."</td> <td  align='right'>".showAmount($transaction_dr,'0')."</td>  <td  align='right'>".showAmount($transaction_cr,'0')."</td> <td  align='right'>".showAmount($closing_dr_cr,'1')."</td> </tr>";
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

function getGroupBalance($group_id,$from_date,$to_date,$sno,$sno2){
	$data = "";
	$all_ledgers = getAllLedgers($group_id);

	$subgroup_query = "select auto_number as uid, id as code,accountssub as name,show_ledger from master_accountssub where auto_number='$group_id' ";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $subgroup_query) or die ("Error in subgroup_query".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($res = mysqli_fetch_array($exec))
	{

		$opening_dr_cr = 0;
		$transaction_dr = 0;
		$transaction_cr = 0;
		$closing_dr_cr = 0;

		$opening_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('".implode("','",$all_ledgers)."')  and ledger_id!='' and transaction_date < '".$from_date."' group by transaction_type ";
		$exec_opening = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
		while($res_opening = mysqli_fetch_array($exec_opening)){
			if($res_opening['transaction_type']=="D"){
				$opening_dr_cr += $res_opening['transaction_amount'];
			}else{
				$opening_dr_cr -= $res_opening['transaction_amount'];
			}
		}
	
		$transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate)  as transaction_amount from tb where record_status='1' and  ledger_id in ('".implode("','",$all_ledgers)."')  and ledger_id!='' and transaction_date between '".$from_date."' and '".$to_date."' group by transaction_type ";
		$exec_transaction = mysqli_query($GLOBALS["___mysqli_ston"], $transaction_query) or die ("Error in transaction_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
		while($res_transaction = mysqli_fetch_array($exec_transaction)){
			if($res_transaction['transaction_type']=="D"){
				$transaction_dr += $res_transaction['transaction_amount'];
			}else{
				$transaction_cr += $res_transaction['transaction_amount'];
			}
		}

		$closing_dr_cr = $opening_dr_cr + $transaction_dr - $transaction_cr;

		 $data .="<tr  style='background-color: aquamarine;' data-node-id=".$sno.'.'.$sno2." data-node-pid=".$sno."> <td></td><td  align='right'>".showAmount($opening_dr_cr,'1')."</td> <td>".$res['code']."</td> <td>".ucwords(strtolower($res['name']))."</td> <td  align='right'>".showAmount($transaction_dr,'0')."</td>  <td  align='right'>".showAmount($transaction_cr,'0')."</td> <td  align='right'>".showAmount($closing_dr_cr,'1')."</td> </tr>";

	 if($res['show_ledger']=="1"){
		 	 $data .=getLedger($res['uid'],$from_date,$to_date,$sno,$sno2);
		 }


	}

	echo $data;

}

function net_profit1($from_date,$to_date){
	$query = "select auto_number as uid,id as code,accountsmain as name from master_accountsmain where section in ('A')  order by auto_number";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
	$closing_dr_cr = 0;

	while($res = mysqli_fetch_array($exec))
	{

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
					$exec_opening = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
					while($res_opening = mysqli_fetch_array($exec_opening)){
						if($res_opening['transaction_type']=="D"){
							$opening_dr_cr += $res_opening['transaction_amount'];
						}else{
							$opening_dr_cr -= $res_opening['transaction_amount'];
						}
					}
				
					$transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate)  as transaction_amount from tb where record_status='1' and ledger_id in ('".$ledger_ids."')  and ledger_id!='' and transaction_date between '".$from_date."' and '".$to_date."' group by transaction_type ";
					$exec_transaction = mysqli_query($GLOBALS["___mysqli_ston"], $transaction_query) or die ("Error in transaction_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
					while($res_transaction = mysqli_fetch_array($exec_transaction)){
						if($res_transaction['transaction_type']=="D"){
							$transaction_dr += $res_transaction['transaction_amount'];
						}else{
							$transaction_cr += $res_transaction['transaction_amount'];
						}
					}

					$closing_dr_cr += $opening_dr_cr + $transaction_dr - $transaction_cr;
	}
		return $closing_dr_cr;				
}
function net_profit2($from_date,$to_date){
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

<?php include ("includes/footer1.php"); ?>
<script src="js/jquery-3.3.1.slim.min.js"></script>
<script src="js/jquery-simple-tree-table.js"></script>
<script type="text/javascript">
  $('#collapsed').simpleTreeTable({
    opened: [0]
  });

  $('#basic').simpleTreeTable({
  	opened: [0]
  });
  </script>
<script type="text/javascript">
	function exportF(elem) {
	  var table = document.getElementById("table");
	  var html = table.outerHTML;
	  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
	  elem.setAttribute("href", url);
	  elem.setAttribute("download", "export_trial.xls"); // Choose the file name
	  return false;
	}
</script>
</body>
</html>

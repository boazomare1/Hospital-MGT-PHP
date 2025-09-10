
<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
set_time_limit(0);
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d'); 
$username = $_SESSION['username'];

//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d', strtotime('-0 year')); }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }
//echo $amount;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

?>
<style type="text/css">
th {
            background-color: #F0FFFF;
            position: sticky;
            top: 0;
            z-index: 1;
        }
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
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td colspan="2" valign="top"><table width="99%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2" width="46%">
		
		
              <form name="cbform1" method="post" action="trial.php">
		<table width="1202" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong> Trial Balance</strong></td>
              </tr>
             <tr>
                      <td width="9%"  align="right" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31"> From Date </td>
                      <td width="20%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
					    <input type="text" name="ADate1" id="ADate1" readonly style="border: 1px solid #001E6A" value="<?php echo $ADate1; ?>"  size="10" onKeyDown="return disableEnterKey()" />
<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </span></td>
						<td width="8%"  align="right" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31"> To Date </td>
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
		</form>		</td>
      </tr>
      <tr>
        <th>
        	<?php
				 if(isset($_REQUEST["cbfrmflag1"])){
			?>
        		<a href="print_trial.php?ADate1=<?php echo $ADate1;?>&&ADate2=<?php echo $ADate2; ?>" id="downloadLink" target="_blank" ><img src="images25/excel-xls-icon.png" alt="excel export" width="50px" height="50px"/></a>
            <?php } ?>
        </th>
      </tr>
<?php
	 if(isset($_REQUEST["cbfrmflag1"])){
	?>
       <tr>
        <th>
<?php

$from_date = $ADate1;
$to_date = $ADate2;

$balance_sheet = 0;
$income_statement = 0;

echo "<table border='1' style='
    width: 93%;
    font-size: initial;border:0px;
' cellpadding='2' cellspacing='0'>";

	echo "<tr style='background-color: #4fc7fd;'> <th>Opening</th> <th>Code</th> <th>Ledger</th> <th>Debit</th>  <th>Credit</th> <th>Closing</th> </tr>";


$query = "select auto_number as uid,id as code,accountsmain as name from master_accountsmain where section in ('A','L')  order by auto_number";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));

while($res = mysqli_fetch_array($exec))
{

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

			$opening_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('".$ledger_ids."') and transaction_date < '".$from_date."' group by transaction_type ";
				$exec_opening = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
				while($res_opening = mysqli_fetch_array($exec_opening)){
					if($res_opening['transaction_type']=="D"){
						$opening_dr_cr += $res_opening['transaction_amount'];
					}else{
						$opening_dr_cr -= $res_opening['transaction_amount'];
					}
				}
			
				$transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate)  as transaction_amount from tb where record_status='1' and ledger_id in ('".$ledger_ids."') and transaction_date between '".$from_date."' and '".$to_date."' group by transaction_type ";
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


		 echo "<tr style='background-color: tomato;'> <td  align='right'>".showAmount($opening_dr_cr,'1')."</td> <td>".$res['code']."</td> <td>".ucwords(strtolower($res['name']))."</td> <td  align='right'>".showAmount($transaction_dr,'0')."</td>  <td  align='right'>".showAmount($transaction_cr,'0')."</td> <td  align='right'>".showAmount($closing_dr_cr,'1')."</td> </tr>";

	echo getSubgroups($res['uid'],$from_date,$to_date);
}

	echo "<tr> <td colspan='5' align='right'>Net Profit : </td> <td  align='right'>".showAmount(net_profit($from_date,$to_date),1)." </td> </tr>";

	echo "<tr> <td colspan='5' align='right'> </td> <td  align='right'>".showAmount($balance_sheet+net_profit($from_date,$to_date),1)." </td> </tr>";

	echo "<tr> <td colspan='5' align='right'>Net Profit : </td> <td  align='right'>".showAmount(-1*net_profit($from_date,$to_date),1)." </td> </tr>";


$query = "select auto_number as uid,id as code,accountsmain as name from master_accountsmain where section in ('E','I')  order by auto_number";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res = mysqli_fetch_array($exec))
{

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


			$opening_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('".$ledger_ids."') and transaction_date < '".$from_date."' group by transaction_type ";
				$exec_opening = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
				while($res_opening = mysqli_fetch_array($exec_opening)){
					if($res_opening['transaction_type']=="D"){
						$opening_dr_cr += $res_opening['transaction_amount'];
					}else{
						$opening_dr_cr -= $res_opening['transaction_amount'];
					}
				}
			
				$transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate)  as transaction_amount from tb where record_status='1' and ledger_id in ('".$ledger_ids."') and transaction_date between '".$from_date."' and '".$to_date."' group by transaction_type ";
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

		 echo "<tr style='background-color: tomato;'> <td  align='right'>".showAmount($opening_dr_cr,'1')."</td> <td>".$res['code']."</td> <td>".ucwords(strtolower($res['name']))."</td> <td  align='right'>".showAmount($transaction_dr,'0')."</td>  <td  align='right'>".showAmount($transaction_cr,'0')."</td> <td  align='right'>".showAmount($closing_dr_cr,'1')."</td> </tr>";

	echo getSubgroups($res['uid'],$from_date,$to_date);

}

	echo "<tr> <td colspan='5' align='right'> </td> <td  align='right'>".showAmount(-1*net_profit($from_date,$to_date)+$income_statement,1)." </td> </tr>";

echo "</table>";

?>

<?php } ?>

<?php

function getSubgroups($account_id,$from_date,$to_date){

	$subgroup_query = "select auto_number as uid, id as code,accountssub as name,show_ledger from master_accountssub where accountsmain='$account_id' order by auto_number";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $subgroup_query) or die ("Error in subgroup_query".mysqli_error($GLOBALS["___mysqli_ston"]));
	$data = "";

	while($res = mysqli_fetch_array($exec))
	{
		getGroupBalance($res['uid'],$from_date,$to_date);		
	}

	return $data;
}

function getLedger($group_id,$from_date,$to_date){
	$ledger_query = "select auto_number as uid, id as code,accountname as name from master_accountname where accountssub='$group_id' order by auto_number";
	$exec = mysqli_query($GLOBALS["___mysqli_ston"], $ledger_query) or die ("Error in ledger_query".mysqli_error($GLOBALS["___mysqli_ston"]));
	$data = "";

	while($res = mysqli_fetch_array($exec))
	{
		$opening_dr_cr = 0;
		$transaction_dr = 0;
		$transaction_cr = 0;
		$closing_dr_cr = 0;

	$opening_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id='".$res['code']."' and transaction_date < '".$from_date."' group by transaction_type ";
		$exec_opening = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
		while($res_opening = mysqli_fetch_array($exec_opening)){
			if($res_opening['transaction_type']=="D"){
				$opening_dr_cr += $res_opening['transaction_amount'];
			}else{
				$opening_dr_cr -= $res_opening['transaction_amount'];
			}
		}
	
		$transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate)  as transaction_amount from tb where record_status='1' and ledger_id='".$res['code']."' and transaction_date between '".$from_date."' and '".$to_date."' group by transaction_type ";
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

		 $data .="<tr> <td  align='right'>".showAmount($opening_dr_cr,'1')."</td> <td>".$res['code']."</td> <td>".ucwords(strtolower($res['name']))."&nbsp;<a href='ledgerview.php?ledgerid=$ledgercode&&ADate1=$from_date&&ADate2=$to_date' target='_blank'><img src='img/info.png' width='16px' height='16px' alt='more'/></a>"."</td> <td  align='right'>".showAmount($transaction_dr,'0')."</td>  <td  align='right'>".showAmount($transaction_cr,'0')."</td> <td  align='right'>".showAmount($closing_dr_cr,'1')."</td> </tr>";
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

function getGroupBalance($group_id,$from_date,$to_date){
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

		$opening_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('".implode("','",$all_ledgers)."') and transaction_date < '".$from_date."' group by transaction_type ";
		$exec_opening = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
		while($res_opening = mysqli_fetch_array($exec_opening)){
			if($res_opening['transaction_type']=="D"){
				$opening_dr_cr += $res_opening['transaction_amount'];
			}else{
				$opening_dr_cr -= $res_opening['transaction_amount'];
			}
		}
	
		$transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate)  as transaction_amount from tb where record_status='1' and  ledger_id in ('".implode("','",$all_ledgers)."') and transaction_date between '".$from_date."' and '".$to_date."' group by transaction_type ";
		$exec_transaction = mysqli_query($GLOBALS["___mysqli_ston"], $transaction_query) or die ("Error in transaction_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
		while($res_transaction = mysqli_fetch_array($exec_transaction)){
			if($res_transaction['transaction_type']=="D"){
				$transaction_dr += $res_transaction['transaction_amount'];
			}else{
				$transaction_cr += $res_transaction['transaction_amount'];
			}
		}

		$closing_dr_cr = $opening_dr_cr + $transaction_dr - $transaction_cr;

		 $data .="<tr  style='background-color: aquamarine;'> <td  align='right'>".showAmount($opening_dr_cr,'1')."</td> <td>".$res['code']."</td> <td>".ucwords(strtolower($res['name']))."</td> <td  align='right'>".showAmount($transaction_dr,'0')."</td>  <td  align='right'>".showAmount($transaction_cr,'0')."</td> <td  align='right'>".showAmount($closing_dr_cr,'1')."</td> </tr>";

	 if($res['show_ledger']=="1"){
		 	 $data .=getLedger($res['uid'],$from_date,$to_date);
		 }


	}

	echo $data;

}

function net_profit($from_date,$to_date){
	$query = "select auto_number as uid,id as code,accountsmain as name from master_accountsmain where section in ('E','I')  order by auto_number";
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

				$opening_query = "select transaction_type,sum(transaction_amount*exchange_rate) as transaction_amount from tb where record_status='1' and ledger_id in ('".$ledger_ids."')  and transaction_date < '".$from_date."' group by transaction_type  ";
					$exec_opening = mysqli_query($GLOBALS["___mysqli_ston"], $opening_query) or die ("Error in opening_query".mysqli_error($GLOBALS["___mysqli_ston"]));; 
					while($res_opening = mysqli_fetch_array($exec_opening)){
						if($res_opening['transaction_type']=="D"){
							$opening_dr_cr += $res_opening['transaction_amount'];
						}else{
							$opening_dr_cr -= $res_opening['transaction_amount'];
						}
					}
				
					$transaction_query = "select transaction_type,sum(transaction_amount*exchange_rate)  as transaction_amount from tb where record_status='1' and ledger_id in ('".$ledger_ids."') and transaction_date between '".$from_date."' and '".$to_date."' group by transaction_type ";
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

?>
</td>
</tr>

</table>
</td>
</tr>
</table>

<?php include ("includes/footer1.php"); ?>
</body>
</html>

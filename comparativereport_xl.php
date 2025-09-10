<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="ledgerview.xls"');
header('Cache-Control: max-age=80');   
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username=$_SESSION["username"];
$registrationdate = date('Y-m-d');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$docno = $_SESSION['docno'];
$todaydate=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date("Y-m-d");
$fromdate=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date("Y-m-d");
$todate=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:date("Y-m-d");
$fromdate_actual=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date("Y-m-d");
$todate_actual=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:date("Y-m-d");
$time=strtotime($todaydate);
$month=date("m",$time);
$year=date("Y",$time);
 
$thismonth=$year."-".$month."___";
$todaydate = date("Y-m-d");
//echo $fromdate.'<br/>'.$todate;
//echo $_REQUEST['ADate1'];
// set ledger_id request
$ledger_id =isset($_REQUEST['ledgerid'])?$_REQUEST['ledgerid']:"";
$ledger_name =isset($_REQUEST['ledgername'])?$_REQUEST['ledgername']:"";
$searchpaymentcode =isset($_REQUEST['searchpaymentcode'])?$_REQUEST['searchpaymentcode']:"";
$viewtype =isset($_REQUEST['viewtype'])?$_REQUEST['viewtype']:"";
$accountsmaintype =isset($_REQUEST['accountsmaintype'])?$_REQUEST['accountsmaintype']:"";
$accountssub =isset($_REQUEST['accountssub'])?$_REQUEST['accountssub']:"";
$skipzeroballeg =isset($_REQUEST['skipzeroballeg'])?$_REQUEST['skipzeroballeg']:"0";
if (isset($_REQUEST["period"])) { $period = $_REQUEST["period"]; } else { $period = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('m'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = ""; }
if (isset($_REQUEST["fromyear"])) { $fromyear = $_REQUEST["fromyear"]; } else { $fromyear = ""; }
if (isset($_REQUEST["toyear"])) { $toyear = $_REQUEST["toyear"]; } else { $toyear = ""; }
if (isset($_REQUEST["searchmonthto"])) { $searchmonthto = $_REQUEST["searchmonthto"]; } else { $searchmonthto = date('m'); }

//get location for sort by location purpose
$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if($location=='All'){

$locationcodenew= "locationcode like '%%'";
}else{
$locationcodenew= "locationcode = '$location'";
}
?>
 <table width="110%" border="0" cellspacing="0" cellpadding="0">

		<tr id="data">
		<td>
		
		<?php if($searchpaymentcode=='1') {
			
		$query_ln = "select auto_number,id,accountname,accountssub,accountsmain from master_accountname where id ='$ledger_id' and recordstatus <> 'deleted'";
		$exec_ln = mysqli_query($GLOBALS["___mysqli_ston"], $query_ln) or die ("Error in Query_ln".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res_ln = mysqli_fetch_array($exec_ln);
		$ledger_name = $res_ln['accountname'];
		$account_main = $res_ln['accountsmain'];
		$account_sub = $res_ln['accountssub'];
		// account main
		$query_ln1 = "select * from master_accountsmain where auto_number ='$account_main' and recordstatus <> 'deleted'";
		$exec_ln1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_ln1) or die ("Error in Query_ln1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res_ln1 = mysqli_fetch_array($exec_ln1);
		$acc_main_name = $res_ln1['accountsmain'];
		$tb_group = $res_ln1['tb_group'];
		 // account sub
		$query_ln2 = "select * from master_accountssub where auto_number ='$account_sub' and recordstatus <> 'deleted'";
		$exec_ln2 = mysqli_query($GLOBALS["___mysqli_ston"], $query_ln2) or die ("Error in Query_ln2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res_ln2 = mysqli_fetch_array($exec_ln2);
		$acc_sub_name = $res_ln2['accountssub'];	
			
		?>
		
		<?php if($period == 'monthly'){ // monthlyy
        $months = array("","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        ?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse"   bordercolor="#666666" cellspacing="0" cellpadding="4" width="90%" align="left" border="0">
          <tbody>
          	<tr>
                <td colspan="12" bgcolor="" class="bodytext31">
                    <div align="left">
                    	<strong style="color:red;">
                   			 <?php 
	                    	    echo $acc_main_name .' '.'>'.' '.$acc_sub_name.' '.'>'.' '.$ledger_name.' '.' >'.'Ledger ID'.' '.'( '.$ledger_id.' )';
	                    	?>	
                		</strong>
                	</div>
                </td>
            </tr>
			<tr>
				<td width="15%" bgcolor="#ffffff" class="bodytext31"  align="center"><strong>Ledger Name</strong></td>
			<?php 
			for($i = $searchmonth; $i <= $searchmonthto; $i++){
			$monthlystartdate= date($searchyear.'-'.'0'.$i.'-01');
			$monthlyenddate= date($searchyear.'-'.'0'.$i.'-t');
			$month = $months[$i];
			?>
			
				
				<td width="" bgcolor="#ffffff" class="bodytext31"  align="right"><strong><?php echo $month; ?></strong></td>
				<td width="" bgcolor="#ffffff" class="bodytext31" align="right"><strong>Delta</strong></td>
			
			<?php } ?>
			</tr>
			
			<tr>
		
			<td width="15%" align="left" valign="left" bgcolor="" class="bodytext31"><strong><?php echo $ledger_name; ?></strong></td>
			<?php 
			$deltamonbal=0;
			for($i = $searchmonth; $i <= $searchmonthto; $i++){
			$monthlystartdate= date($searchyear.'-'.'0'.$i.'-01');
			$monthlyenddate= date($searchyear.'-'.'0'.$i.'-t');
			$month = $months[$i];
			$running_bal=0;
			$opening_bal=0;
			$deltabal=0;
					$sno = 0;
					//run previous
					$deltavalue=0;
					$closing_bal = 0;
					$total_c = 0;
					$total_d = 0;
					$debit_amount = 0;
					$credit_amount = 0;
					$query2 = "select * from tb where ledger_id='$ledger_id' and transaction_date between '$monthlystartdate' and '$monthlyenddate' and $locationcodenew order by transaction_date asc";
					$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num2=mysqli_num_rows($exec2);
					while($res2 = mysqli_fetch_array($exec2))
					{
					//var_dump($res2);
					$tb_auto_number = $res2["auto_number"];
					$transaction_date = $res2["transaction_date"];
					$transaction_type = $res2['transaction_type'];
					$transaction_number = $res2['doc_number'];
					$locationcode = $res2['locationcode'];
					$reference_no = $res2['refno'];
					$sno = $sno + 1;
						if($transaction_type == 'C'){
							$credit_amount+= $res2['transaction_amount'];
						}else{
							$credit_amount+= '0.00';
						}

						if($transaction_type == 'D'){
							$debit_amount+= $res2['transaction_amount'];
						}else{
							$debit_amount+= '0.00';
						}
				
					}
					if($tb_group == 'A' || $tb_group == 'E' )
					{		
					$running_bal=$credit_amount-$debit_amount;
					} elseif($tb_group == 'I' || $tb_group == 'L' ) {
					$running_bal=$debit_amount+$credit_amount;	
					}
					
					if($running_bal>0){
					$deltavalue=(($running_bal-$deltamonbal)/$running_bal)*100;
					}else{
					$deltavalue=0;	
					}
					
				?>
			
				<td width="8%" align="right" valign="center" bgcolor="" class="bodytext31"><strong><?php echo number_format((float)$running_bal, 2, '.', ','); ?></strong></td>
				<td width="8%" align="right" valign="center" bgcolor="" class="bodytext31"><strong><?php echo number_format($deltavalue,2,'.',','); ?> %</strong></td>
		
			<?php  $deltamonbal=$running_bal;	} ?>
			</tr>
			</tbody>
		</table>
		<?php } ?>
		<?php  if($period == 'yearly'){ ?>
		
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse"   bordercolor="#666666" cellspacing="0" cellpadding="4" width="550"    align="left" border="0">
          <tbody>
          	<tr>
                <td colspan="7" bgcolor="" class="bodytext31">
                    <div align="left">
                    	<strong style="color:red;">
                   			 <?php 
	                    	    echo $acc_main_name .' '.'>'.' '.$acc_sub_name.' '.'>'.' '.$ledger_name.' '.' >'.'Ledger ID'.' '.'( '.$ledger_id.' )';
	                    	?>	
                		</strong>
                	</div>
                </td>
            </tr>
			<tr>
			<td colspan="2" bgcolor="#4fc7fd" class="bodytext31"  align="center"><strong>Yearly</strong></td>
			<?php
			for($year = $fromyear;$year <= $toyear;$year++) // Show Years
			{
			$date = $year; 
			?>
			<td colspan="2" bgcolor="#4fc7fd" class="bodytext31"  align="center"><strong><?php echo $date; ?></strong></td>
			<td colspan="1" bgcolor="#4fc7fd" class="bodytext31"  align="center"><strong>Delta</strong></td>
			<?php
			}
			?>
			</tr>
			
			<tr>
			<td colspan="2" align="left" valign="left" bgcolor="" class="bodytext31"><strong><?php echo $ledger_name; ?></strong></td>
			<?php 
			$deltamonbal=0;
			for($year = $fromyear;$year <= $toyear;$year++) // Show Years
			{
			//echo $year.'<br>';
			$date = $year;
			$fromdate = date('Y-m-d',strtotime('01-01-'.$date));
			$todate = date('Y-m-t',strtotime('01-12-'.$date));
			?>
			<?php
					$sno = 0;
					//run previous
					$deltavalue=0;
					$closing_bal = 0;
					$total_c = 0;
					$total_d = 0;
					$debit_amount = 0;
					$credit_amount = 0;
				 	$query2 = "select * from tb where ledger_id='$ledger_id' and transaction_date between '$fromdate' and '$todate' and $locationcodenew order by transaction_date asc";
					$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num2=mysqli_num_rows($exec2);
					while($res2 = mysqli_fetch_array($exec2))
					{
					//var_dump($res2);
					$tb_auto_number = $res2["auto_number"];
					$transaction_date = $res2["transaction_date"];
					$transaction_type = $res2['transaction_type'];
					$transaction_number = $res2['doc_number'];
					$locationcode = $res2['locationcode'];
					$reference_no = $res2['refno'];
					$sno = $sno + 1;
						if($transaction_type == 'C'){
							$credit_amount+= $res2['transaction_amount'];
						}else{
							$credit_amount+= '0.00';
						}

						if($transaction_type == 'D'){
							$debit_amount+= $res2['transaction_amount'];
						}else{
							$debit_amount+= '0.00';
						}
				
					}
					if($tb_group == 'A' || $tb_group == 'E' )
					{		
					$running_bal=$credit_amount-$debit_amount;
					} elseif($tb_group == 'I' || $tb_group == 'L' ) {
					$running_bal=$debit_amount+$credit_amount;	
					}
					if($running_bal>0){
					$deltavalue=(($running_bal-$deltamonbal)/$running_bal);
					}else{
					$deltavalue=0;	
					}
					
				?>
			
				
				<td colspan="2" align="center" valign="center" bgcolor="" class="bodytext31"><strong><?php echo number_format((float)$running_bal, 2, '.', ','); ?></strong></td>
				<td width="" align="center" valign="center" bgcolor="" class="bodytext31"><strong><?php echo number_format($deltavalue,2,'.',','); ?> %</strong></td>
			
			
			
			
			<?php  $deltamonbal=$running_bal;	 } ?>
			</tr>
			
			
			</tbody>
		</table>
		
		<?php } ?>
		
		<?php } else { ?>
		<?php if($period == 'monthly'){ // monthlyy
        $months = array("","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        ?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse"   bordercolor="#666666" cellspacing="0" cellpadding="4" width="90%" align="left" border="0">
          <tbody>
		<?php
		$ledgertotamt=0;
		$count=0;
		$oldaccsub='';
		$colorloopcount=0;
		if($accountsmaintype!='' && $accountssub==''){
		$query_ln = "select auto_number,id,accountname,accountssub,accountsmain from master_accountname where accountsmain ='$accountsmaintype'  and recordstatus <> 'deleted'";
		}elseif($accountsmaintype!='' && $accountssub!=''){
		$query_ln = "select auto_number,id,accountname,accountssub,accountsmain from master_accountname where accountsmain ='$accountsmaintype' and accountssub='$accountssub' and recordstatus <> 'deleted'";	
		}
	
		$exec_ln = mysqli_query($GLOBALS["___mysqli_ston"], $query_ln) or die ("Error in Query_ln".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res_ln = mysqli_fetch_array($exec_ln)){
		$ledger_id = $res_ln['id'];
		$ledger_name = $res_ln['accountname'];
		$account_main = $res_ln['accountsmain'];
		$account_sub = $res_ln['accountssub'];
		$count++;
		
		// account main
		$query_ln1 = "select * from master_accountsmain where auto_number ='$account_main' and recordstatus <> 'deleted'";
		$exec_ln1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_ln1) or die ("Error in Query_ln1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res_ln1 = mysqli_fetch_array($exec_ln1);
		$acc_main_name = $res_ln1['accountsmain'];
		$tb_group = $res_ln1['tb_group'];

		// account sub
		$query_ln2 = "select * from master_accountssub where auto_number ='$account_sub' and recordstatus <> 'deleted'";
		$exec_ln2 = mysqli_query($GLOBALS["___mysqli_ston"], $query_ln2) or die ("Error in Query_ln2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res_ln2 = mysqli_fetch_array($exec_ln2);
		$acc_sub_name = $res_ln2['accountssub'];
		
		
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
		
		
		if($oldaccsub!=$acc_sub_name){
		?>
          	<tr>
                <td colspan="12" bgcolor="" class="bodytext31">
                    <div align="left">
                    	<strong style="color:red;">
                   			 <?php 
	                    	    echo $acc_main_name .' '.'>'.' '.$acc_sub_name;
	                    	?>	
                		</strong>
                	</div>
                </td>
            </tr>
			<tr>
				<td width="17%" bgcolor="#4fc7fd" class="bodytext31" align="center"><strong>Leger Name</strong></td>
				<?php 
				for($i = $searchmonth; $i <= $searchmonthto; $i++){
				$monthlystartdate= date($searchyear.'-'.'0'.$i.'-01');
				$monthlyenddate= date($searchyear.'-'.'0'.$i.'-t');
				$month = $months[$i];
				?>
				<td bgcolor="#4fc7fd" class="bodytext31" align="right"><strong><?php echo $month; ?></strong></td>
				<td bgcolor="#4fc7fd" class="bodytext31" align="right"><strong>Delta</strong></td>
				<?php } ?>
			</tr>
			<?php } 
			$searchmntfrom=date($searchyear.'-'.'0'.$searchmonth.'-01');
			$searchmntto=date($searchyear.'-'.$searchmonthto.'-31');
			$comp_ledgtotamt=0;
			$query25 = "select sum(transaction_amount) as ledgtotamt from tb where ledger_id='$ledger_id' and transaction_date between '$searchmntfrom' and '$searchmntto' and $locationcodenew order by transaction_date asc";
			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res25 = mysqli_fetch_array($exec25);
			$comp_ledgtotamt = $res25["ledgtotamt"];
			if($comp_ledgtotamt!=0 || $skipzeroballeg=='1'){
			?>
			<tr>
			<td width="" align="left" valign="left" class="bodytext31"><strong><?php echo $ledger_name; ?></strong></td>
			<?php 
			$deltamonbal=0;
			for($i = $searchmonth; $i <= $searchmonthto; $i++){
			$monthlystartdate= date($searchyear.'-'.'0'.$i.'-01');
			$monthlyenddate= date($searchyear.'-'.'0'.$i.'-t');
			$month = $months[$i];
			$running_bal=0;
			$opening_bal=0;
			$deltabal=0;
				$sno = 0;
				
				//run previous
				$deltavalue=0;
				$closing_bal = 0;
				$total_c = 0;
				$total_d = 0;
				$debit_amount = 0;
				$credit_amount = 0;
				$query2 = "select * from tb where ledger_id='$ledger_id' and transaction_date between '$monthlystartdate' and '$monthlyenddate' and $locationcodenew order by transaction_date asc";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num2=mysqli_num_rows($exec2);
				while($res2 = mysqli_fetch_array($exec2))
				{
				//var_dump($res2);
				$tb_auto_number = $res2["auto_number"];
				$transaction_date = $res2["transaction_date"];
				$transaction_type = $res2['transaction_type'];
				$transaction_number = $res2['doc_number'];
				$locationcode = $res2['locationcode'];
				$reference_no = $res2['refno'];
				$sno = $sno + 1;
					if($transaction_type == 'C'){
						$credit_amount+= $res2['transaction_amount'];
					}else{
						$credit_amount+= '0.00';
					}

					if($transaction_type == 'D'){
						$debit_amount+= $res2['transaction_amount'];
					}else{
						$debit_amount+= '0.00';
					}
			
				}
				if($tb_group == 'A' || $tb_group == 'E' )
				{		
				$running_bal=$credit_amount-$debit_amount;
				} elseif($tb_group == 'I' || $tb_group == 'L' ) {
				$running_bal=$debit_amount+$credit_amount;	
				}
				
				if($running_bal>0){
				$deltavalue=(($running_bal-$deltamonbal)/$running_bal)*100;
				}else{
				$deltavalue=0;	
				}
				
				
				
			?>
		
			<td width="" align="right" valign="center"  class="bodytext31"><strong><?php echo number_format((float)$running_bal, 2, '.', ','); ?></strong></td>
			<td width="" align="right" valign="center"  class="bodytext31"><strong><?php echo number_format($deltavalue,2,'.',','); ?> %</strong></td>
		
			<?php  $deltamonbal=$running_bal;	} ?>
			</tr>
			
			
			<?php } $oldaccsub=$acc_sub_name; } ?>
			</tbody>
		</table>
		<?php } ?>
		<?php  if($period == 'yearly'){ ?>
		
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse"   bordercolor="#666666" cellspacing="0" cellpadding="4" width="50%" align="left" border="0">
          <tbody>
		<?php
		$count=0;
		$oldaccsub='';
		$colorloopcount=0;
		if($accountsmaintype!='' && $accountssub==''){
		$query_ln = "select auto_number,id,accountname,accountssub,accountsmain from master_accountname where accountsmain ='$accountsmaintype'  and recordstatus <> 'deleted'";
		}elseif($accountsmaintype!='' && $accountssub!=''){
		$query_ln = "select auto_number,id,accountname,accountssub,accountsmain from master_accountname where accountsmain ='$accountsmaintype' and accountssub='$accountssub' and recordstatus <> 'deleted'";	
		}
	
		$exec_ln = mysqli_query($GLOBALS["___mysqli_ston"], $query_ln) or die ("Error in Query_ln".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($res_ln = mysqli_fetch_array($exec_ln)){
		$ledger_id = $res_ln['id'];
		$ledger_name = $res_ln['accountname'];
		$account_main = $res_ln['accountsmain'];
		$account_sub = $res_ln['accountssub'];
		$count++;
		
		// account main
		$query_ln1 = "select * from master_accountsmain where auto_number ='$account_main' and recordstatus <> 'deleted'";
		$exec_ln1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_ln1) or die ("Error in Query_ln1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res_ln1 = mysqli_fetch_array($exec_ln1);
		$acc_main_name = $res_ln1['accountsmain'];
		$tb_group = $res_ln1['tb_group'];

		// account sub
		$query_ln2 = "select * from master_accountssub where auto_number ='$account_sub' and recordstatus <> 'deleted'";
		$exec_ln2 = mysqli_query($GLOBALS["___mysqli_ston"], $query_ln2) or die ("Error in Query_ln2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res_ln2 = mysqli_fetch_array($exec_ln2);
		$acc_sub_name = $res_ln2['accountssub'];
		
		
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
		
		
		if($oldaccsub!=$acc_sub_name){
		?>
          	<tr>
                <td colspan="12" bgcolor="" class="bodytext31">
                    <div align="left">
                    	<strong style="color:red;">
                   			 <?php 
	                    	    echo $acc_main_name .' '.'>'.' '.$acc_sub_name;
	                    	?>	
                		</strong>
                	</div>
                </td>
            </tr>
			<tr>
				<td width="12%" bgcolor="#4fc7fd" class="bodytext31" align="center"><strong>Leger Name</strong></td>
				<?php 
				for($year = $fromyear;$year <= $toyear;$year++) // Show Years
				{
				$date = $year; 
				?>
				<td bgcolor="#4fc7fd" class="bodytext31" align="right"><strong><?php echo $date; ?></strong></td>
				<td bgcolor="#4fc7fd" class="bodytext31" align="right"><strong>Delta</strong></td>
				<?php } ?>
			</tr>
			<?php } 
			$searchmntfrom=date($searchyear.'-'.'0'.$searchmonth.'-01');
			$searchmntto=date($searchyear.'-'.$searchmonthto.'-31');
			$comp_ledgtotamt=0;
			$query25 = "select sum(transaction_amount) as ledgtotamt from tb where ledger_id='$ledger_id' and transaction_date between '$searchmntfrom' and '$searchmntto' and $locationcodenew order by transaction_date asc";
			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res25 = mysqli_fetch_array($exec25);
			$comp_ledgtotamt = $res25["ledgtotamt"];
			if($comp_ledgtotamt!=0 || $skipzeroballeg=='1'){
			
			?>
			<tr>
			<td width="" align="left" valign="left" class="bodytext31"><strong><?php echo $ledger_name; ?></strong></td>
			<?php 
			$deltamonbal=0;
			for($year = $fromyear;$year <= $toyear;$year++) // Show Years
			{
			$date = $year;
			$fromdate = date('Y-m-d',strtotime('01-01-'.$date));
			$todate = date('Y-m-t',strtotime('01-12-'.$date));		
			$running_bal=0;
			$opening_bal=0;
			$deltabal=0;
				$sno = 0;
				
				//run previous
				$deltavalue=0;
				$closing_bal = 0;
				$total_c = 0;
				$total_d = 0;
				$debit_amount = 0;
				$credit_amount = 0;
				$query2 = "select * from tb where ledger_id='$ledger_id' and transaction_date between '$fromdate' and '$todate' and $locationcodenew order by transaction_date asc";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num2=mysqli_num_rows($exec2);
				while($res2 = mysqli_fetch_array($exec2))
				{
				//var_dump($res2);
				$tb_auto_number = $res2["auto_number"];
				$transaction_date = $res2["transaction_date"];
				$transaction_type = $res2['transaction_type'];
				$transaction_number = $res2['doc_number'];
				$locationcode = $res2['locationcode'];
				$reference_no = $res2['refno'];
				$sno = $sno + 1;
					if($transaction_type == 'C'){
						$credit_amount+= $res2['transaction_amount'];
					}else{
						$credit_amount+= '0.00';
					}

					if($transaction_type == 'D'){
						$debit_amount+= $res2['transaction_amount'];
					}else{
						$debit_amount+= '0.00';
					}
			
				}
				if($tb_group == 'A' || $tb_group == 'E' )
				{		
				$running_bal=$credit_amount-$debit_amount;
				} elseif($tb_group == 'I' || $tb_group == 'L' ) {
				$running_bal=$debit_amount+$credit_amount;	
				}
				
				if($running_bal>0){
				$deltavalue=(($running_bal-$deltamonbal)/$running_bal)*100;
				}else{
				$deltavalue=0;	
				}
				
				
				
			?>
		
			<td width="8%" align="right" valign="center"  class="bodytext31"><strong><?php echo number_format((float)$running_bal, 2, '.', ','); ?></strong></td>
			<td width="8%" align="right" valign="center"  class="bodytext31"><strong><?php echo number_format($deltavalue,2,'.',','); ?> %</strong></td>
		
			<?php  $deltamonbal=$running_bal;	} ?>
			</tr>
			
			
			<?php } $oldaccsub=$acc_sub_name; } ?>
			</tbody>
		</table>
		
		
		<?php } ?>
		<?php } ?>
		</td>
		</tr>
	</table>
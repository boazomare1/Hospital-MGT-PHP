<?php
session_start();
//echo session_id();
include ("db/db_connect.php");
include ("includes/loginverify.php");

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
$ledger_id =isset($_REQUEST['ledgerid'])?$_REQUEST['ledgerid']:"04-1500-8";
$ledger_name =isset($_REQUEST['ledgername'])?$_REQUEST['ledgername']:"NHIF GAIN/LOSS";

//get location for sort by location purpose
$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if($location!='')
{
	  $locationcode=$location;
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
#position
{
position: absolute;
    left: 830px;
    top: 420;
}
-->
</style>

<style type="text/css">
.btn {
    background-color: rgba(0, 255, 0, 0.4);
    display: inline-block;
    zoom: 1;
    line-height: normal;
    white-space: nowrap;
    vertical-align: baseline;
    text-align: center;
    cursor: pointer;
    FONT-WEIGHT: normal;
    font-family: Tahoma;
    font-size: 11px;
    padding: .5em .9em .5em 1em;
    text-decoration: none;
    border-radius: 4px;
    text-shadow: 0 1px 1px rgba(0, 0, 0, .2);
}
</style>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">
<script src="js/datetimepicker_css.js"></script>
<script src="datetimepicker1_css.js"></script>
<style>
.hideClass
{display:none;}
</style>

<script language="javascript">


</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}

-->
</style>
</head>

<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%">&nbsp;</td>
   
    <td colspan="5" valign="top">
 <form name="cbform1" method="post" action="nhif_gainloss.php">
          <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
		  <!--<tr bgcolor="red">
              <td colspan="4" bgcolor="red" class="bodytext3"><strong> PLEASE REFRESH PAGE BEFORE MAKING BILL </strong></td>
              </tr>-->
            <tr bgcolor="#011E6A">
              <td colspan="6" bgcolor="#ecf0f5" class="bodytext3"><strong> Search Ledger Report </strong></td>
              <td colspan="1" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
                  <?php
						
					if ($location!='')
						{
						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res12 = mysqli_fetch_array($exec12);
						
						echo $res1location = $res12["locationname"];
						//echo $location;
						}
						else
						{
						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						//$res1locationanum = $res1["locationcode"];
						}
						?>
						
                  
                  </td>
     
              </tr>
              <?php
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
			  <tr>
			  	<td width="10" align="left" valign="center"bgcolor="#ffffff" class="bodytext31"><strong> Ledger Name </strong></td>
			  	<td width="100" align="left" valign="center"bgcolor="#ffffff" class="bodytext31">
			  		<input type="text" name="ledgername" id="ledgername" value="<?php echo $ledger_name?>" readonly>
			  		<input type="hidden" name="ledgerid" id="ledgerid" value="<?php echo $ledger_id;?>">
			  	</td>
	            <td width="70" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Date From</strong></td>
	            <td width="130" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
	            	<input name="ADate1" id="ADate1" value="<?php if($fromdate != ''){ echo $fromdate; }else{ $todaydate; } ?>" size="10" readonly="readonly" onKeyDown="return disableEnterKey()" />
				    <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>
				</td>
	            <td width="50" align="left" valign="center"  bgcolor="#FFFFFF" class="style1">
	            	<span class="bodytext31"><strong>Date To</strong></span>
	            </td>
		        <td width="130" align="left" valign="center"  bgcolor="#ffffff">
		        	<span class="bodytext31">
		                <input name="ADate2" id="ADate2" value="<?php if($todate != ''){ echo $todate; }else{ $todaydate; } ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
					    <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
				    </span>
				</td>
				<td  align="left" valign="right"  bgcolor="#ffffff">
		        	<span class="bodytext31">
		                <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
	                    <input class="btn" type="submit" value="Search" name="Submit" style="margin-right:75px;" />
				    </span>
				</td>
	          </tr>
	          <tr>
	          	<td colspan="7" align="left" valign="right"  bgcolor="#ffffff">&nbsp;<td>
	          </tr>
          </tbody>
        </table>
</form>	
<table width="980" border="0" cellspacing="0" cellpadding="0" style="margin:30px;">
	<tr>
	    <td colspan="2">&nbsp;</td>
	</tr>
</table>
<table width="110%" border="0" cellspacing="0" cellpadding="0">

		<tr id="data">
		<td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" 
            align="left" border="0">
          <tbody>
          	<tr>
                <td colspan="10" bgcolor="#ffffff" class="bodytext31">
                    <div align="left">
                    	<strong style="color:red;">
                   			 <?php 
	                    	    echo $acc_main_name .' '.'>'.' '.$acc_sub_name.' '.'>'.' '.$ledger_name;
	                    	?>	
                		</strong>
                	</div>
                </td>
            </tr>
            <tr>
                <td colspan="9" bgcolor="#ecf0f5" class="bodytext31">
                    <div align="left"><strong>Ledger View Report</strong></div>
                </td>
               <!--  <td bgcolor="#ecf0f5" class="bodytext31">
                    <div align="left">
                    	
                    	<span class="btn" onclick="exportExcel();">Export Excel</span>
                    </div>
                </td> -->
                <td  bgcolor="#ecf0f5" class="bodytext31" valign="center"  align="right"><a href="ledgerview_xl.php?ledgerid=<?php echo $ledger_id;?>&&ADate1=<?php echo $fromdate_actual; ?>&&ADate2=<?php echo $todate_actual; ?>&&ledgername=<?php echo $ledger_name; ?>"><img  width="30" height="30" src="images/excel-xls-icon.png" style="cursor:pointer;"></a>

          </td>
            </tr>
            <tr>
            	<td colspan="4" bgcolor="#ffffff" class="bodytext31">
                  <div align="left">
                  	<strong style="color:red;">Date From: </strong><?php echo date('d-m-Y',strtotime($fromdate_actual));?>&nbsp;<strong style="color:red;">Date To: </strong><?php echo date('d-m-Y',strtotime($todate_actual));?>
                  </div>
                </td>
                <td colspan="6" bgcolor="#ffffff" class="bodytext31">
                    <div align="center">&nbsp;</div>
                </td>
            </tr>
            <tr>
            	<td colspan="5" bgcolor="#ffffff" class="bodytext31">
                    <div align="left">
                    	<strong style="color:red;">
                    	<?php 
                    	    echo $ledger_name;
                    	?>	
                    	</strong>
						&nbsp;&nbsp;
						<strong style="color:Black;">
                    	<?php 
                    	    echo 'Ledger ID :';
                    	?>	
                    	</strong>&nbsp;&nbsp;
						<strong style="color:red;">
                    	<?php 
                    	    echo $ledger_id;
                    	?>	
                    	</strong>
                    </div>
                </td>
                <td  colspan="2" bgcolor="#ffffff" class="bodytext31">
                	<?php
                	
                	
                		if($tb_group == 'I')
                		{
                			$from_date = $fromdate;
                			$fromdate = getfromdate($fromdate);
                			$todate   = gettodate($from_date);
                			
	                		// debit tot bal
					        $query3 = "select auto_number,transaction_date,transaction_type as t_type,sum(transaction_amount) as damount from tb where ledger_id='$ledger_id' and transaction_type='D' and transaction_date between  '$fromdate' and '$todate' group by transaction_type";
					       
							$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
							$res3 = mysqli_fetch_array($exec3);
	                        $d_amount = $res3['damount'];


	                       

	                        // debit tot bal
					        $query3 = "select auto_number,transaction_date,transaction_type as t_type,sum(transaction_amount) as camount from tb where ledger_id='$ledger_id' and transaction_type='C' and transaction_date between  '$fromdate' and '$todate' group by transaction_type";
							$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
							$res3 = mysqli_fetch_array($exec3);
	                        $c_amount = $res3['camount'];
	                        $t_amount = $d_amount - $c_amount;
	                        $opening_bal_d = ($t_amount>=0)?$t_amount:0;
	                        $opening_bal_c = ($t_amount<0)?$t_amount:0;

	                        $opening_bal = $t_amount;
                		}
                		else{


                	    // debit tot bal
				        $query3 = "select auto_number,transaction_date,transaction_type as t_type,sum(transaction_amount) as damount from tb where ledger_id='$ledger_id' and transaction_type='D' and transaction_date < '$fromdate' group by transaction_type";
						$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res3 = mysqli_fetch_array($exec3);
                        $d_amount = $res3['damount'];

                        // debit tot bal
				        $query3 = "select auto_number,transaction_date,transaction_type as t_type,sum(transaction_amount) as camount from tb where ledger_id='$ledger_id' and transaction_type='C' and transaction_date < '$fromdate' group by transaction_type";
						$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res3 = mysqli_fetch_array($exec3);
                        $c_amount = $res3['camount'];
                        $t_amount = $d_amount - $c_amount;
                        $opening_bal_d = ($t_amount>=0)?$t_amount:0;
                        $opening_bal_c = ($t_amount<0)?$t_amount:0;

                        $opening_bal = $t_amount;
                    }

                	?>
                    <div align="center"><strong>Opening Balance:</strong></div>
                </td>
                <td bgcolor="#ffffff" class="bodytext31">
                    <div align="center"><strong><?php echo number_format((float)ABS($opening_bal_d), 2, '.', ',');?></strong></div>
                </td>
                <td bgcolor="#ffffff" class="bodytext31">
                    <div align="center"><strong><?php echo number_format((float)ABS($opening_bal_c), 2, '.', ',');?></strong></div>
                </td>

                <td bgcolor="#ffffff" class="bodytext31">
                    <div align="center"></div>
                </td>
            </tr>
            <tr>
                <td colspan="10" bgcolor="#ecf0f5" class="bodytext31">
                    <div align="center">&nbsp;</div>
                </td>
            </tr>
            <tr>
			 <td colspan="1" width="1%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>S.no</strong></div></td>
			 <td width="8%" colspan="1"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
			 <td width="8%" colspan="1"  align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Transaction No.</strong></div></td>
			  <td width="8%" colspan="1"  align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Reference No.</strong></div></td>
			  <td width="20%"   align="left" valign="left" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Description</strong></div></td>
			  <td width="8%"   align="left" valign="left" bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>User Name</strong></div></td>
			 <td width="10%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Debit Amount</strong></div></td>
			 <td width="10%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Credit Amount</strong></div></td>
			 <td width="10%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Running Balance</strong></div></td>
            </tr>
            <?php
		        $query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
			    $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res1 = mysqli_fetch_array($exec1);
				$res1location = $res1["locationname"]; 
				$res1locationcode = $res1["locationcode"];

				// var_dump($res1location);		
		   ?>
           <?php
            $colorloopcount ='';
            
			$query2 = "select * from tb where ledger_id='$ledger_id' and transaction_date between '$fromdate_actual' and '$todate_actual' order by transaction_date asc";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num2=mysqli_num_rows($exec2);
			$sno = 0;
			//run previous
			$previous_type = '';
			$previous_amt = '';
			$closing_bal = 0;
			$total_c = 0;
			$total_d = 0;
			
			while($res2 = mysqli_fetch_array($exec2))
			{
			//var_dump($res2);
			$tb_auto_number = $res2["auto_number"];
			$transaction_date = $res2["transaction_date"];
			$transaction_type = $res2['transaction_type'];
			$transaction_number = $res2['doc_number'];
			$reference_no = $res2['refno'];
			$patientcode  = trim($res2['patientcode']);
			$patientname  = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], trim($res2['patientname']));
			$visitcode    = trim($res2['visitcode']);
			$itemcode     = trim($res2['itemcode']);
			$itemname     = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], trim($res2['itemname']));
			$narration    = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], trim($res2['narration']));

			$from_table   = $res2['from_table'];

			$username     = $res2['user_name'];
			$description = "";

			$description .= "".$patientcode."";

			if($patientname!="")
				$description .= " , ".$patientname;

			if($visitcode!="")
				$description .= " , ".$visitcode;


			if($itemcode!="" && $visitcode!="")
				$description .= " , ".$itemcode;
			elseif($itemcode!="" && $visitcode=="")
				$description .= $itemcode;
			if($itemname!="")
				$description .= " , ".$itemname;
			if($narration!="")
				$description .= " , ".$narration;

			$accountname = "";
			$bankname    = "";
			$transactionmode = "";
			$chequenumber   = "";
			$remarkss    ="";
			if($from_table == "master_transactiononaccount")
			{
				
				$query_ar = "select accountname,transactionmode,bankname from master_transactiononaccount where docno='$transaction_number'";
			    $exec_ar = mysqli_query($GLOBALS["___mysqli_ston"], $query_ar) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res_ar = mysqli_fetch_array($exec_ar);
				$transactionmode = $res_ar["transactionmode"]; 
				$accountname     = $res_ar["accountname"];
				$bankname        = $res_ar["bankname"];
				$transactionmode = $res_ar["transactionmode"]; 
				//if($transactionmode == "CHEQUE")
				//{
					$query_ar = "select chequenumber,remarks from master_transactionpaylater where docno='$transaction_number'";
				    $exec_ar = mysqli_query($GLOBALS["___mysqli_ston"], $query_ar) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res_ar = mysqli_fetch_array($exec_ar);
					$chequenumber = $res_ar["chequenumber"];
					$remarkss   = $res_ar["remarks"];
				//}
				
				$description     = $accountname." , ".$transactionmode;

				if($chequenumber!="")
				{
					$description .= " , ".$chequenumber;
				}
				if($bankname!="")
				{
					$description .= " , ".$bankname;
				}
				if($remarkss!="")
				{
					$description .= " , ".$remarkss;
				}

			}

			if($from_table == "paymententry_details")
			{
				$accountname = "";
			$bankname    = "";
			$transactionmode = "";
			$chequenumber   = "";
			$chequedate   = "";
			$remarkss    ="";
				$query_ar = "select transactionmode,chequenumber,chequedate,bankname,remarks from master_transactionpharmacy where docno='$transaction_number'";
			    $exec_ar = mysqli_query($GLOBALS["___mysqli_ston"], $query_ar) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			    $numrows = mysqli_num_rows($exec_ar);
			    if($numrows)
			    {	
					$res_ar = mysqli_fetch_array($exec_ar);
					$transactionmode = $res_ar["transactionmode"]; 
					$chequenumber = $res_ar["chequenumber"];
					$chequedate = $res_ar["chequedate"];
					$bankname        = $res_ar["bankname"];
					$remarkss   = $res_ar["remarks"];
					
			    }
				
				$description     = $transactionmode;

				if($chequenumber!="")
				{
					$description .= " , ".$chequenumber;
				}
				if($chequedate!="")
				{
					$description .= " , ".$chequedate;
				}
				if($bankname!="")
				{
					$description .= " , ".$bankname;
				}
				if($remarkss!="")
				{
					$description .= " , ".$remarkss;
				}
			}
			
			if($transaction_type == 'C'){
				$credit_amount = $res2['transaction_amount'];
			}else{
				$credit_amount = '0.00';
			}

			if($transaction_type == 'D'){
				$debit_amount = $res2['transaction_amount'];
			}else{
				$debit_amount = '0.00';
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
			$sno = $sno + 1;
			$transaction_amount = $res2['transaction_amount'];
			
			

			?>
          <tr onClick="showsub(<?=$tb_auto_number?>)">
             
			    <td <?php echo $colorcode; ?> colspan="1" align="left" valign="center" class="bodytext31">
			      <?php echo $sno; ?>
			    </td>
				<td <?php echo $colorcode; ?> colspan="1"  align="center" valign="center" class="bodytext31"><?php echo date('d-m-Y',strtotime($transaction_date)); ?></td>
				<td <?php echo $colorcode; ?> colspan="1"  align="right" valign="center" class="bodytext31"><?php echo $transaction_number; ?></td>
				<td <?php echo $colorcode; ?> colspan="1"  align="center" valign="center" class="bodytext31"><?php echo $reference_no; ?></td>
				
				<td <?php echo $colorcode; ?> colspan="1"  align="left" valign="left" class="bodytext31"><?php echo $description; ?></td>
				<td <?php echo $colorcode; ?> colspan="1"  align="left" valign="left" class="bodytext31"><?php echo $username; ?></td>
				<td <?php echo $colorcode; ?> align="right" valign="center" class="bodytext31">
					<?php
					   $amt_d = number_format((float)$debit_amount, 2, '.', ','); echo $amt_d;
					   $total_d = (float)$total_d + (float)$debit_amount;
					 ?>
				</td>
				<td <?php echo $colorcode; ?> width="9%"  width="10%" align="right" valign="center" class="bodytext31">
					<?php 
					  $amt_c = number_format((float)$credit_amount, 2, '.', ','); echo $amt_c;
					  $total_c = (float)$total_c + (float)$credit_amount;
					  //echo $total_c
				    ?>
				</td>
				<td <?php echo $colorcode; ?> width="10%" align="right" valign="center" class="bodytext31">
					<?php 
					  //calc running bal
						if($sno == 1){
							if($transaction_type == 'C'){
								$running_bal = $opening_bal - $credit_amount;
							}else{
								$running_bal = $opening_bal + $debit_amount;
							}
							$previous_type = $transaction_type;
			                $previous_amt = $running_bal;
						}else{
							//echo $transaction_type.'<br>';
							if($transaction_type == 'C'){
								$running_bal = ((float)$previous_amt - (float)$credit_amount);
							}
							if($transaction_type == 'D'){
								$running_bal = ((float)$previous_amt + (float)$debit_amount);
							}
							// put var
							$previous_type = $transaction_type;
			                $previous_amt = $running_bal;
						}
						$closing_bal = $running_bal;
						echo number_format((float)$running_bal, 2, '.', ',');
					?>		
				</td>
			   </tr>
			 
			<tbody id="<?=$tb_auto_number?>" style="display:none" >
			
			
				<?php 
	
					$queryledger = "SELECT tb.`transaction_type`,tb.`ledger_id`,master_accountname.accountname, sum(transaction_amount) ledgersum FROM `tb` inner join master_accountname on master_accountname.id = tb.ledger_id WHERE doc_number='$transaction_number' group by ledger_id,transaction_type order by transaction_type desc";
					$execledger = mysqli_query($GLOBALS["___mysqli_ston"], $queryledger) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$numledger=mysqli_num_rows($execledger);
					
					$ledgersno = 0;
					while($resledger = mysqli_fetch_array($execledger))
					{
					   
					   $ledger_transaction_type = $resledger["transaction_type"];
					   $ledgeridd = $resledger["ledger_id"];
					   $ledgernamee = $resledger["accountname"];
					   $ledgersum = $resledger["ledgersum"];
					   if($ledgersum > 0)
					   {
						   $ledgersno += 1;
						if ($showcolor == 0)
						{
							//echo "if";
							$colorcode = 'bgcolor="#ffffff"';
						}
						else
						{
							//echo "else";
							$colorcode = 'bgcolor="#ffffff"';
						}
				?>		   
					<tr <?php echo $colorcode; ?> >
						<td class="bodytext31" valign="center" colspan="2" align="right" bgcolor="#ecf0f5"><strong>&nbsp;</strong></td>
						<td class="bodytext31" valign="center" colspan="1" align="right"><strong><?php echo $ledgersno;?></strong></td>
						<td class="bodytext31" valign="center"  align="left" colspan="3"><strong><?php echo $ledger_transaction_type.' - '.$ledgernamee.' - '.number_format($ledgersum, 2, '.', ','); ?><strong></td>
						<td colspan=""  align="right" valign="center" bgcolor="ecf0f5" class="bodytext31">&nbsp;</td>
					</tr>
						   
				<?php		   
						}
					   

				    }

				?>
			
			
			</tbody>
			   
			   
			   
		   <?php 
		   } 
		  
		   ?>
		    <tr>
                <td colspan="5" bgcolor="#ecf0f5" class="bodytext31">
                    <div align="right"><strong>Total Transactions:</strong></div>
                </td>
                <td bgcolor="#ecf0f5" class="bodytext31">
                    <div align="center"><strong></strong></div>
                </td>
                <td bgcolor="#ecf0f5" class="bodytext31">
                    <div align="right"><strong><?php $amt = number_format((float)$total_d, 2, '.', ','); echo $amt;?></strong></div>
                </td>
                <td bgcolor="#ecf0f5" class="bodytext31">
                    <div align="right"><strong><?php $amt = number_format((float)$total_c, 2, '.', ','); echo $amt;?></strong></div>
                </td>
                 <td bgcolor="#ecf0f5" class="bodytext31">
                    <div align="right"><strong></strong></div>
                </td>
               
            </tr>
            <tr>
                <td colspan="5" bgcolor="#ffffff" class="bodytext31">
                    <div align="right"><strong>Closing Balance:</strong></div>
                </td>
                <td bgcolor="#ffffff" class="bodytext31">
                    <div align="center"><strong></strong></div>
                </td>
                <td bgcolor="#ffffff" class="bodytext31">
                    <div align="right"><strong><?php if($closing_bal >=0) { $amt = number_format((float)$closing_bal, 2, '.', ','); echo $amt;}?></strong></div>
                </td>
                <td bgcolor="#ffffff" class="bodytext31">
                    <div align="right"><strong><?php if($closing_bal <0) { $val = ((float)$closing_bal * -1);$amt = number_format((float)$val, 2, '.', ','); echo $amt;}?></strong></div>
                </td>
                 <td bgcolor="#ffffff" class="bodytext31">
                    <div align="right"><strong></strong></div>
                </td>
                
            </tr>
            <tr>
             	<td colspan="8" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td><td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            
             	
             	</tr>
          </tbody>
        </table>		</td>
		</tr>
		
		</table>		</td>
		</tr>
	
      <tr>
        <td>&nbsp;</td>
      </tr>
				<tr>
        <td>&nbsp;</td>
        </tr>  
	  <tr>
        <td>&nbsp;</td>
		 <td>&nbsp;</td>
		  <td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
                 
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>

<script type="text/javascript">
$(function() {

    $('#ledgername').autocomplete({
		
	source:'trial_accountnamefinanceajax.php', 
	
	minLength:2,
	delay: 0,
	html: true, 
		select: function(event,ui){
				//var saccountauto=ui.item.saccountauto;
				var saccountid=ui.item.saccountid;
				//$('#saccountauto').val(saccountauto);	
				$('#ledgerid').val(saccountid);	
			}
    });
});

// export data to excel
function exportExcel() {
  //alert('clicked custom button 1!');
  //var url='data:application/vnd.ms-excel,' + encodeURIComponent($('#calendar').html()) 
  //location.href=url
  //return false
  var a = document.createElement('a');
  //getting data from our div that contains the HTML table
  var data_type = 'data:application/vnd.ms-excel';
  a.href = data_type + ', ' + encodeURIComponent($('#data').html());
  //setting the file name
  a.download = 'LedgerViewReport.xls';
  //triggering the function
  a.click();
  //just in case, prevent default behaviour
  e.preventDefault();
  return (a);
  /* end of excel function */
}

function showsub(subtypeano)
{
if(document.getElementById(subtypeano) != null)
{
if(document.getElementById(subtypeano).style.display == 'none')
{
document.getElementById(subtypeano).style.display = '';
}
else
{
document.getElementById(subtypeano).style.display = 'none';
}
}
}
</script>
</body>
</html>

<?php 

function getfromdate($fromdate){
	$timestamp = strtotime($fromdate);
	$year = date("Y", $timestamp);
	$fromdate = "$year-01-01";
	return $fromdate;
}
function gettodate($fromdate){
	$enddate = date('Y-m-d', strtotime('-1 day', strtotime($fromdate)));
	return $enddate;
}
?>

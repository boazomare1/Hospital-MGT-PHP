<?php 
ini_set('memory_limit', '1024M');
session_start();  

header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="bankrecon.xls"');

header('Cache-Control: max-age=80');


include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$docno = $_SESSION['docno']; 



$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];



if (isset($_REQUEST["bankname"])) { $bankname = $_REQUEST["bankname"]; } else { $bankname = ""; }
if (isset($_REQUEST["statementamount"])) { $statementamount = $_REQUEST["statementamount"]; } else { $statementamount = 0; }
$statementamount = (floatval($statementamount));

// get bankname from bankcode

$query1 = "select bankname from master_bank where bankcode='$bankname'";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						 $bank = $res1["bankname"];

if (isset($_REQUEST["ADate2"])) {  $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }


//if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }

$paymentreceiveddateto=$ADate2;

//echo $amount;

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

 

ob_start();
?>



<!--<page backtop="10mm" backbottom="10mm" backright="5mm" backleft="5mm">-->

<table border="0" align="center">

	<tr>

    	<td class="logo" colspan="3">Bank Reconciliation Report </td>

    </tr>

    <tr>

    	<td class="bodytext" colspan="3"><strong>Date As On : <?php $ADate2 = date("d-m-Y", strtotime($ADate2)); echo $ADate2; ?></strong></td>

    </tr>

	<tr>

    	<td class="bodytextbold left"><?php echo $bank;?></td>

        <td class="bodytextbold" width="150">&nbsp;</td>

        <td class="bodytextbold left">&nbsp;</td>

    </tr>

	

</table>
 



<body>

	<?php

				if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				

				?>


<table width="100%" border="0" cellspacing="0" cellpadding="2">

          <tbody>

        

            <tr>

             <td width="2%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>S.No</strong></div></td>  

              <td width="10%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>       
       <td width="10%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Cheque Date</strong></div></td>

              <td width="10%" align="left" valign="center"  

                 class="bodytext31"><strong> Voucher </strong></td>
                <td width="10%" align="left" valign="center"  

                 class="bodytext31"><strong> Ref.No. </strong></td>
                <td width="10%" align="left" valign="center"  

                class="bodytext31"><strong>Cheque No. </strong></td>
              

              <td width="32%" align="left" valign="center"  

                 class="bodytext31"><div align="left"><strong>Corresponding Ledger</strong></div></td>

              <td width="16%" align="left" valign="right"  

                 class="bodytext31"><div align="right"><strong>Amount</strong></div></td>

				

			

            </tr>

            <?php 

            if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

			if ($cbfrmflag2 == 'cbfrmflag2')

			{
				$apno = '';

				$openingcreditamount = 0;

				$openingdebittamount = 0;

				$openingbalance=0;

				$totalat = 0;

				$total_unpresented = 0;

				if (isset($_REQUEST["bankname"])) { $bankname = $_REQUEST["bankname"]; } else { $bankname = ""; }

				if (isset($_REQUEST["ADate2"])) {  $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date("Y-m-d"); }

					

					$snocount = 0;


					// OB
					//$querycr1op = "SELECT SUM(`transactionamount`) as openingbalance  FROM `billing_ipprivatedoctor` WHERE 
						$openingbalance = 0; 

				    ?>

 
		 	<tr>

			<!-- <td class="bodytext31" valign="center"  align="left" 

                ><strong>&nbsp;</strong></td>
                <td  align="left" valign="center"  

                 class="bodytext31"><strong> Statement Balance </strong></td>
				
  <td class="bodytext31" valign="center"  align="left" 

                ><strong>&nbsp;</strong></td>
              

              
              
                <td align="left" valign="center"  

                class="bodytext31"><div align="left"><strong>&nbsp;</strong></div></td>

              <td  align="right" valign="center"  

                class="bodytext31"><strong>&nbsp;</strong></td> -->

             

		 <td  colspan="7" align="left" valign="center"  

                 class="bodytext31"><strong> Statement Balance </strong></td>

				<td   align="right" valign="center"  

                 class="bodytext31"><div align="right"><strong><?php echo number_format($statementamount,2,'.',','); ?></strong></div></td>

			</tr> 

			<tr >

           
             <td  colspan="8" align="left" valign="left"  class="bodytext31"><strong>UnPresented</strong></td>
            
            </tr>

					<?php // OB

		
		////////////////////////

			$unpresented_incr = 0;
			$uncleared_incr = 0;
			$total_credit_amount = 0;
		    $total_debit_amount =  0;

			//$query1 = "select * from master_transactionpaylater where transactionmodule = 'PAYMENT' and bankname like '%$bankname%' and recordstatus <> 'deallocated' group by docno";

			//$query1 = "select * from master_transactionpaylater where transactionmodule = 'PAYMENT' and bankname like '%$bankname%' and recordstatus <> 'deallocated' and transactiondate <= '$ADate2' group by docno";

			$query1 = "select * from master_transactionpaylater where transactionmodule = 'PAYMENT' and bankcode = '$bankname' and recordstatus <> 'deallocated' and transactiondate <= '$ADate2' group by docno order by transactiondate ASC";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$apnums = mysqli_num_rows($exec1);

			//$query41 = "select * from bank_record where notes = 'accounts receivable' and status IN ('Posted','Unpresented','Uncleared')";

			$query41 = "select * from bank_record where notes = 'accounts receivable'";

			$exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die ("Error in Query41".mysqli_error($GLOBALS["___mysqli_ston"]));

			$post41 = mysqli_num_rows($exec41);

			$apnums = $apnums - $post41;

			if(true)

			{
	

			while ($res1 = mysqli_fetch_array($exec1))

			{

			$post21='';

			$apaccountname = strtoupper($res1['accountname']);

			$apdocno = $res1['docno'];

			$aptransactiondate =$res1['transactiondate'];

			$aptransactiondate = date("d-m-Y", strtotime($aptransactiondate));

			// $aptransactionamount = $res1['transactionamount'];

			$aptransactionamount1 = $res1['transactionamount'];

			$query_bankcharges = "select bank_charge from master_transactiononaccount where docno = '$apdocno'";
			$exec_bankcharges = mysqli_query($GLOBALS["___mysqli_ston"], $query_bankcharges) or die ("Error in Query_bankcharges".mysqli_error($GLOBALS["___mysqli_ston"]));
			$post_bankcharges = mysqli_num_rows($exec_bankcharges);
			if($post_bankcharges>0){
				$res1_bc = mysqli_fetch_array($exec_bankcharges);
				$bankchagesss = $res1_bc['bank_charge'];
				$aptransactionamount=$aptransactionamount1-$bankchagesss;
			}else{
				$aptransactionamount=$aptransactionamount1;
			}

			$apchequeno = $res1['chequenumber'];
			$apchequedate = $res1['chequedate'];

			
			if($apchequedate  == ''){
			$apchequedate = $aptransactiondate;

			}
			$apchequedate = date("d-m-Y", strtotime($apchequedate));
			$appostedby = $res1['username'];

			$apremarks = $res1['remarks'];

			$apbankname = $res1['bankname'];

			$querybankname1 = "select * from master_bank where bankname like '%$apbankname%' and bankstatus <> 'deleted'";

			$execbankname1 = mysqli_query($GLOBALS["___mysqli_ston"], $querybankname1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$resbankname1 = mysqli_fetch_array($execbankname1);

			$apbankcode = $resbankname1['bankcode'];

			$query10 = "select * from paymentmodedebit where billnumber = '$apdocno'";

			$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res10 = mysqli_fetch_array($exec10);

			$appostedby = $res10['username'];

			//$query21 = "select * from bank_record where docno = '$apdocno' and instno = '$apchequeno' and status IN ('Posted','Unpresented','Uncleared')";

			/*$query21 = "select * from bank_record where docno = '$apdocno' and instno = '$apchequeno'";

			$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());

			$res21 = mysql_fetch_array($exec21);

			$apposttotalamount = $apposttotalamount + $res21['amount'];

			$apposttotalamount = 0;

			$post21 = mysql_num_rows($exec21);*/

			
			$debit_amount = '0.00';
			$credit_amount = '0.00';
			
			
			 //$total_credit_amount = $total_credit_amount + $credit_amount;
		    
			//$total_unpresented = $total_debit_amount;
			$notes = "accounts receivable";

			$query21 = "select * from bank_record where docno = '$apdocno' and instno = '$apchequeno'";

			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res21 = mysqli_fetch_array($exec21);

			

			$post21 = mysqli_num_rows($exec21);

			if($post21 == 0 || $post21 == ''){

				$amount = getcreditdebitor($apdocno,$aptransactionamount);
			//$credit_amount = $amount['credit_amount'];
			$debit_amount = $amount['debit_amount'];

			$total_debit_amount =  $total_debit_amount  + $debit_amount;
			if($aptransactionamount!='0.00')
		    {
		    	$apno = $apno + 1;
		    	$unpresented_incr += 1;
			?>
				  <tr >

            
				  	<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $unpresented_incr; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $aptransactiondate; ?></div></td>   

            <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $apchequedate; ?></div></td>
                

          		<td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $notes; ?></div></td>

                 <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $apdocno; ?></div></td>
                 
               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $apchequeno; ?></div></td>
            
              <td class="bodytext31" valign="left"  align="left">

			  <?php echo $apaccountname; ?></td>

              <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php echo number_format($debit_amount,2,'.',',');?></div></td>

              

           </tr>

			<?php 
			  }
			}

					}

			

			

			

			 }


			$arno = '';

			//$query2 = "select * from master_transactionpharmacy where transactionmodule = 'PAYMENT' and bankname like '%$bankname%' and recordstatus <> 'deallocated' group by docno";

			//$query2 = "select * from master_transactionpharmacy where transactionmodule = 'PAYMENT' and bankname like '%$bankname%' and recordstatus <> 'deallocated' and transactiondate <= '$ADate2' group by docno";

			//$query2 = "select *,sum(transactionamount) as transactionamount from master_transactionpharmacy where transactionmodule = 'PAYMENT' and bankcode = '$bankname' and recordstatus <> 'deallocated' and transactiondate <= '$ADate2' group by docno";
			$query2 = "
			select entrydate AS chequedate,ledgername AS suppliername,docno AS docno,entrydate AS transactiondate,selecttype AS chequenumber,remarks AS remarks ,ledgername AS bankname,sum(debitamount-creditamount) as transactionamount from master_journalentries where ledgerid = '$bankname'  and debitamount!=0 and entrydate <= '$ADate2' group by docno  order by entrydate ASC

			";
			//echo $query2;exit;

			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$arnums = mysqli_num_rows($exec2);

			//$query42 = "select * from bank_record where notes = 'account payable' and status IN ('Posted','Unpresented','Uncleared')";

			$query42 = "select * from bank_record where notes = 'account payable'";


			$exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));

			$post42 = mysqli_num_rows($exec42);

			$arnums = $arnums - $post42;

			if(true)

			{?>
		   <?php

			while ($res2 = mysqli_fetch_array($exec2))

			{

			$araccountname = strtoupper($res2['suppliername']);

			 $ardocno = $res2['docno'];

			$artransactiondate =$res2['transactiondate'];

			$artransactiondate = date("d-m-Y", strtotime($artransactiondate));


			// get total transaction amount 


			$artransactionamount = $res2['transactionamount'];

			$archequeno = $res2['chequenumber'];
			$archequedate = $res2['chequedate'];
			
			if($archequedate  == ''){
			$archequedate = $artransactiondate;

			}
			$archequedate = date("d-m-Y", strtotime($archequedate));
			//$arpostedby = $res2['username'];

			$arremarks = $res2['remarks'];

			$arbankname = $res2['bankname'];

			$querybankname2 = "select * from master_bank where bankname like '%$arbankname%' and bankstatus <> 'deleted'";

			$execbankname2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybankname2) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$resbankname2 = mysqli_fetch_array($execbankname2);

			$arbankcode = $resbankname2['bankcode'];

			$query11 = "select * from paymentmodecredit where billnumber = '$ardocno'";

			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res11 = mysqli_fetch_array($exec11);

			$arpostedby = $res11['username'];

			//$query22 = "select * from bank_record where docno = '$ardocno' and instno = '$archequeno' and status IN ('Posted','Unpresented','Uncleared')";

			$query22 = "select * from bank_record where docno = '$ardocno' and instno = '$archequeno'  and bankcode='$bankname' ";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res22 = mysqli_fetch_array($exec22);

			//$arposttotalamount = $arposttotalamount + $res22['amount'];

			$arposttotalamount = 0;

			$post22 = mysqli_num_rows($exec22);

			if($post22 == 0 || $post22 == ''){

			//$arno = $arno + 1;

			//$artotalamount = $artotalamount + $artransactionamount;

			
			
		
			$amount = getcreditdebitor($ardocno,$artransactionamount);

		//	$credit_amount = $amount['credit_amount'];
			$debit_amount = $amount['debit_amount'];

			// $total_credit_amount = $total_credit_amount + $credit_amount;
		    $total_debit_amount =  $total_debit_amount  + $debit_amount;
		    $notes = "journal entries";
		    if($artransactionamount!='0.00')
		    {
		    	$arno = $arno + 1;
		    	$unpresented_incr += 1;
			?>

          
              	  <tr >

            
              	  	<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $unpresented_incr; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $artransactiondate; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $archequedate; ?></div></td>
                

          		<td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $notes; ?></div></td>

                 <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $ardocno; ?></div></td>
                 
               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $archequeno; ?></div></td>
            
              <td class="bodytext31" valign="left"  align="left">

			  <?php echo $araccountname; ?></td>

              <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php echo number_format($debit_amount,2,'.',',');?></div></td>

              

           </tr>

			<?php
		       }

			}

			}

			
			 }







		////////////////////////
		//$amount = 0;

		$total_uncleared = 0;
			?>
			<!-- <tr>

            <td colspan="4"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>&nbsp;</strong></td>
             <td  colspan="1" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>UnPresented Total</strong></td>
             <td   align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php echo number_format($total_unpresented,2,'.',',');?></strong></td>
            </tr>
 -->
 			<?php 



			$reno = '';

			

			//$query4 = "select * from receiptsub_details where bankname like '%$bankname%' and recordstatus <> 'deallocated' and transactiondate <='$ADate2' group by docnumber";

			$query4 = "select * from receiptsub_details where bankcode = '$bankname' and recordstatus <> 'deallocated' and transactiondate <='$ADate2' group by docnumber order by transactiondate ASC";

			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$renums = mysqli_num_rows($exec4);

			//$query44 = "select * from bank_record where notes = 'receipts' and status IN ('Posted','Unpresented','Uncleared')";

			$query44 = "select * from bank_record where notes = 'receipts'";

			$exec44 = mysqli_query($GLOBALS["___mysqli_ston"], $query44) or die ("Error in Query44".mysqli_error($GLOBALS["___mysqli_ston"]));

			$post44 = mysqli_num_rows($exec44);

			$renums = $renums - $post44;

			if(true)

			{?>

			

	

           

		   <?php
		   $reposttotalamount = 0;

			while ($res4 = mysqli_fetch_array($exec4))

			{

			

			$redocno = $res4['docnumber'];

			$retransactiondate =$res4['transactiondate'];

			$retransactionamount = $res4['transactionamount'];

			$rechequeno = $res4['chequenumber'];

			$repostedby = $res4['username'];

			$reremarks = $res4['remarks'];

			$reaccountnamecoa = $res4['receiptcoa'];

			$rebankname = $res4['bankname'];

			$querybankname4 = "select * from master_bank where bankname like '%$rebankname%' and bankstatus <> 'deleted'";

			$execbankname4 = mysqli_query($GLOBALS["___mysqli_ston"], $querybankname4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

			$resbankname4 = mysqli_fetch_array($execbankname4);

			$rebankcode = $resbankname4['bankcode'];

			$query9 = "select * from master_accountname where id = '$reaccountnamecoa'";

			$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res9 = mysqli_fetch_array($exec9);

			$reaccountname = strtoupper($res9['accountname']);

			//$query24 = "select * from bank_record where docno = '$redocno' and instno = '$rechequeno' and status IN ('Posted','Unpresented','Uncleared')";

			$query24 = "select * from bank_record where docno = '$redocno' and instno = '$rechequeno'";

			$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res24 = mysqli_fetch_array($exec24);

			//$reposttotalamount = $reposttotalamount + $res24['amount'];

			$reposttotalamount = 0;

			$post24 = mysqli_num_rows($exec24);

			if($post24 == 0 || $post24 == ''){

			//$reno = $reno + 1;

			//$retotalamount = $retotalamount + $retransactionamount;

			

			

		
			$amount = getcreditdebitor($redocno,$retransactionamount);
			//$credit_amount = $amount['credit_amount'];
			$debit_amount = $amount['debit_amount'];

			 //$total_credit_amount = $total_credit_amount + $credit_amount;
		    $total_debit_amount =  $total_debit_amount  + $debit_amount;
		    $notes = "receipts";
		    if($retransactionamount!='0.00')
		    {
		    	$reno = $reno + 1;
		    	$unpresented_incr +=1;
			?>

          
				  <tr >

            
				  <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $unpresented_incr; ?></div>	
               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $retransactiondate; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $retransactiondate; ?></div></td>
                

          		<td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $notes; ?></div></td>

                 <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $redocno; ?></div></td>
                 
               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $rechequeno; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="left">

			  <?php echo $reaccountname; ?></td>

              <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php echo number_format($debit_amount,2,'.',',');?></div></td>

              

           </tr>
              

			<?php
		       }

			}

			}

			?>

			
			<?php 

			 }


			 $query5 = "select * from bankentryform where (tobankid = '$bankname' or frombankid = '$bankname') and transactiondate <='$ADate2'  and  amount > 0  and creditamount = 0 group by docnumber";

			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

			$bknums = mysqli_num_rows($exec5);

			//$query45 = "select * from bank_record where notes = 'misc' and status IN ('Posted','Unpresented','Uncleared')";

			$query45 = "select * from bank_record where notes = 'misc'";

			$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die ("Error in Query45".mysqli_error($GLOBALS["___mysqli_ston"]));

			$post45 = mysqli_num_rows($exec45);

			$bknums = $bknums - $post45;

			if(true)

			{?>

			

		   <?php

			while ($res5 = mysqli_fetch_array($exec5))

			{

			

			$bkdocno = $res5['docnumber'];

			$bktransactiondate =$res5['transactiondate'];

			$bktransactiondate = date("d-m-Y", strtotime($bktransactiondate));

			$dramount = $res5['amount'];

			$cramount = $res5['creditamount'];

			$bktransactionamount = $cramount + $dramount;

			$bkchequeno = $res5['chequenumber'];

			if($bkchequeno=='')
			{
				$bkchequeno = 'Dr';
			}

			$bkpostedby = $res5['personname'];

			$bkremarks = $res5['remarks'];

			$bkbankname = $res5['bankname'];		

			$querybankname5 = "select * from master_bank where bankname like '%$bkbankname%' and bankstatus <> 'deleted'";

			$execbankname5 = mysqli_query($GLOBALS["___mysqli_ston"], $querybankname5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

			$resbankname5 = mysqli_fetch_array($execbankname5);

			$bkbankcode = $resbankname5['bankcode'];

			$bkaccountname = strtoupper($res5['transactiontype']);

			//$query25 = "select * from bank_record where docno = '$bkdocno' and status IN ('Posted','Unpresented','Uncleared')";

			$query25 = "select * from bank_record where docno = '$bkdocno'  and bankcode='$bankname'";

			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res25 = mysqli_fetch_array($exec25);

			//$bkposttotalamount = $bkposttotalamount + $res25['amount'];

			$bkposttotalamount = 0;

			$post25 = mysqli_num_rows($exec25);

			if($post25 == 0 || $post25 == ''){

			//$bkno = $bkno + 1;

			//$bktotalamount = $bktotalamount + $bktransactionamount;

			
			

		

			$amount = getcreditdebitor($bkdocno,$bktransactionamount);
			$debit_amount = $amount['credit_amount'];
			//$debit_amount = $amount['debit_amount'];

		   
		    $total_debit_amount =  $total_debit_amount  + $debit_amount;

		    $notes = "bank entry";

		     if($bktransactionamount!='0.00')
		    {
		    	//$bkno = $bkno + 1;
		    	$unpresented_incr +=1;
			?>

        		  <tr >

            <td class="bodytext31" valign="center"  align="left">

               <?php echo $unpresented_incr; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <?php echo $bktransactiondate; ?></td>
               <td class="bodytext31" valign="center"  align="left">

                <?php echo $bktransactiondate; ?></td>
                

          		<td class="bodytext31" valign="center"  align="left">

                <?php echo $notes; ?></td>

                 <td class="bodytext31" valign="center"  align="left">

                <?php echo $bkdocno; ?></td>
                 
               <td class="bodytext31" valign="center"  align="left">

               <?php echo $bkchequeno; ?></td>
            
              <td class="bodytext31" valign="center"  align="left">

			 <?php echo $bkaccountname; ?></td>

              <td class="bodytext31" valign="center"  align="right">

			    <?php echo number_format($debit_amount,2,'.',',');?></td>

              

           </tr>
              

			<?php
				}

			}

			}

				
			 }

			  $total_unpresented = $total_debit_amount;
 			?>

 			<tr>

            <td colspan="4"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>&nbsp;</strong></td>
             <td  colspan="3" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>UnPresented Total</strong></td>
             <td   align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php echo number_format($total_unpresented,2,'.',',');?></strong></td>
            </tr>
 
           <!--  <tr >

           
             <td  colspan="8" align="left" valign="left"  class="bodytext31"><strong>Uncleared</strong></td>
            
            </tr>
 -->
            <tr>

            <td colspan="4"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Uncleared</strong></td>
             <td  colspan="3" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>&nbsp;</strong></td>
             <td   align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>&nbsp;</strong></td>
            </tr>
			
			<?php 

			$arno = '';

			//$query2 = "select * from master_transactionpharmacy where transactionmodule = 'PAYMENT' and bankname like '%$bankname%' and recordstatus <> 'deallocated' group by docno";

			//$query2 = "select * from master_transactionpharmacy where transactionmodule = 'PAYMENT' and bankname like '%$bankname%' and recordstatus <> 'deallocated' and transactiondate <= '$ADate2' group by docno";

			//$query2 = "select *,sum(transactionamount) as transactionamount from master_transactionpharmacy where transactionmodule = 'PAYMENT' and bankcode = '$bankname' and recordstatus <> 'deallocated' and transactiondate <= '$ADate2' group by docno";


			// $query2 = "select res.* from ((select IF(chequedate='',transactiondate,chequedate) AS chequedate,suppliername AS suppliername,docno AS docno,transactiondate AS transactiondate,chequenumber AS chequenumber,remarks AS remarks,bankname AS bankname,sum(transactionamount) as transactionamount from master_transactionpharmacy where transactionmodule = 'PAYMENT' and bankcode = '$bankname' and recordstatus <> 'deallocated' and transactiondate <= '$ADate2' group by docno)  
			// UNION ALL
			// (select IF(chequedate='',transactiondate,chequedate) AS chequedate, doctorname AS suppliername,docno AS docno,transactiondate AS transactiondate,chequenumber AS chequenumber,remarks AS remarks ,bankname AS bankname,sum(netpayable) as transactionamount from master_transactiondoctor where transactionmodule = 'PAYMENT' and bankcode = '$bankname' and recordstatus <> 'deallocated' and transactiondate <= '$ADate2' group by docno) ) res  where res.chequedate <='$ADate2' order by chequedate ASC";

			
			//echo $query2;exit;

			$query2 = "SELECT res.* from ((select IF(chequedate='',transactiondate,chequedate) AS chequedate,suppliername AS suppliername,docno AS docno,transactiondate AS transactiondate,chequenumber AS chequenumber,remarks AS remarks,bankname AS bankname,sum(transactionamount) as transactionamount,'' as username from master_transactionpharmacy where transactionmodule = 'PAYMENT' and bankcode = '$bankname' and recordstatus <> 'deallocated' and transactiondate <= '$ADate2' group by docno)  
			UNION ALL
			(select IF(chequedate='',transactiondate,chequedate) AS chequedate, doctorname AS suppliername,docno AS docno,transactiondate AS transactiondate,chequenumber AS chequenumber,remarks AS remarks ,bankname AS bankname,sum(netpayable) as transactionamount,'' as username from master_transactiondoctor where transactionmodule = 'PAYMENT' and bankcode = '$bankname' and recordstatus <> 'deallocated' and transactiondate <= '$ADate2' group by docno)
			UNION ALL
			(select (transactiondate) AS chequedate, ledger_name AS suppliername,docno AS docno,transactiondate AS transactiondate,chequenumber AS chequenumber,remarks AS remarks ,bankname AS bankname,sum(bank_amount-bankcharges) as transactionamount, username as username from advance_payment_entry where transactionmodule = 'PAYMENT' and bankcode = '$bankname' and recordstatus <> 'deleted' and transactiondate <= '$ADate2' group by docno)

		) res  where res.chequedate <='$ADate2' order by chequedate ASC";

			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$arnums = mysqli_num_rows($exec2);

			//$query42 = "select * from bank_record where notes = 'account payable' and status IN ('Posted','Unpresented','Uncleared')";

			$query42 = "select * from bank_record where notes = 'account payable'";


			$exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));

			$post42 = mysqli_num_rows($exec42);

			$arnums = $arnums - $post42;

			if(true)

			{?>

		

	


		   <?php

			while ($res2 = mysqli_fetch_array($exec2))

			{

			$araccountname = strtoupper($res2['suppliername']);

			$ardocno = $res2['docno'];

			$artransactiondate =$res2['transactiondate'];

			$artransactiondate = date("d-m-Y", strtotime($artransactiondate));


			// get total transaction amount 


			$artransactionamount = $res2['transactionamount'];

			$archequeno = $res2['chequenumber'];
			$archequedate = $res2['chequedate'];

			
			if($archequedate  == ''){
			$archequedate = $artransactiondate;

			}
			$archequedate = date("d-m-Y", strtotime($archequedate));
			//$arpostedby = $res2['username'];

			$arremarks = $res2['remarks'];

			$arbankname = $res2['bankname'];

			$querybankname2 = "select * from master_bank where bankname like '%$arbankname%' and bankstatus <> 'deleted'";

			$execbankname2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybankname2) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$resbankname2 = mysqli_fetch_array($execbankname2);

			$arbankcode = $resbankname2['bankcode'];

			$username123 = $res2['username'];
			if($username123==''){
			$query11 = "select * from paymentmodecredit where billnumber = '$ardocno'";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11 = mysqli_fetch_array($exec11);
			$arpostedby = $res11['username'];
				}else{
					$arpostedby=$username123;
				}

			//$query22 = "select * from bank_record where docno = '$ardocno' and instno = '$archequeno' and status IN ('Posted','Unpresented','Uncleared')";

			$query22 = "select * from bank_record where docno = '$ardocno' and instno = '$archequeno'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res22 = mysqli_fetch_array($exec22);

			//$arposttotalamount = $arposttotalamount + $res22['amount'];

			$arposttotalamount = 0;

			$post22 = mysqli_num_rows($exec22);

			if($post22 == 0 || $post22 == ''){

			//$arno = $arno + 1;

			//$artotalamount = $artotalamount + $artransactionamount;

			
			
		
			$amount = getcreditdebitor($ardocno,$artransactionamount);
			$credit_amount = $amount['credit_amount'];
			//$debit_amount = $amount['debit_amount'];

			 $total_credit_amount = $total_credit_amount + $credit_amount;
		    //$total_debit_amount =  $total_debit_amount  + $debit_amount;
		    $notes = "account payable";
		     if($artransactionamount!='0.00')
		    {
		    	$arno = $arno + 1;
		    	$uncleared_incr +=1;
			?>

          
              	  <tr >

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $uncleared_incr; ?></div></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $artransactiondate; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $archequedate; ?></div></td>
                

          		<td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $notes; ?></div></td>

                 <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $ardocno; ?></div></td>
                 
               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $archequeno; ?></div></td>
            
              <td class="bodytext31" valign="left"  align="left">

			  <?php echo $araccountname; ?></td>

              <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php echo number_format($credit_amount,2,'.',',');?></div></td>

              

           </tr>

			<?php
		      }

			}

			}

			
			 }


			$arno = '';

			//$query2 = "select * from master_transactionpharmacy where transactionmodule = 'PAYMENT' and bankname like '%$bankname%' and recordstatus <> 'deallocated' group by docno";

			//$query2 = "select * from master_transactionpharmacy where transactionmodule = 'PAYMENT' and bankname like '%$bankname%' and recordstatus <> 'deallocated' and transactiondate <= '$ADate2' group by docno";

			//$query2 = "select *,sum(transactionamount) as transactionamount from master_transactionpharmacy where transactionmodule = 'PAYMENT' and bankcode = '$bankname' and recordstatus <> 'deallocated' and transactiondate <= '$ADate2' group by docno";
			$query2 = "
			select entrydate AS chequedate,ledgername AS suppliername,docno AS docno,entrydate AS transactiondate,selecttype AS chequenumber,remarks AS remarks ,ledgername AS bankname,sum(debitamount-creditamount) as transactionamount from master_journalentries where ledgerid = '$bankname'  and creditamount!=0 and entrydate <= '$ADate2' group by docno order by entrydate ASC

			";
			//echo $query2;exit; 

			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$arnums = mysqli_num_rows($exec2);

			//$query42 = "select * from bank_record where notes = 'account payable' and status IN ('Posted','Unpresented','Uncleared')";

			$query42 = "select * from bank_record where notes = 'account payable'";


			$exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));

			$post42 = mysqli_num_rows($exec42);

			$arnums = $arnums - $post42;

			if(true)

			{?>
		   <?php

			while ($res2 = mysqli_fetch_array($exec2))

			{

			$araccountname = strtoupper($res2['suppliername']);

			 $ardocno = $res2['docno'];

			$artransactiondate =$res2['transactiondate'];

			$artransactiondate = date("d-m-Y", strtotime($artransactiondate));


			// get total transaction amount 


			$artransactionamount = $res2['transactionamount'];

			$archequeno = $res2['chequenumber'];
			$archequedate = $res2['chequedate'];
			
			if($archequedate  == ''){
			$archequedate = $artransactiondate;

			}
			$archequedate = date("d-m-Y", strtotime($archequedate));
			//$arpostedby = $res2['username'];

			$arremarks = $res2['remarks'];

			$arbankname = $res2['bankname'];

			$querybankname2 = "select * from master_bank where bankname like '%$arbankname%' and bankstatus <> 'deleted'";

			$execbankname2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybankname2) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$resbankname2 = mysqli_fetch_array($execbankname2);

			$arbankcode = $resbankname2['bankcode'];

			$query11 = "select * from paymentmodecredit where billnumber = '$ardocno'";

			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res11 = mysqli_fetch_array($exec11);

			$arpostedby = $res11['username'];

			//$query22 = "select * from bank_record where docno = '$ardocno' and instno = '$archequeno' and status IN ('Posted','Unpresented','Uncleared')";

			$query22 = "select * from bank_record where docno = '$ardocno' and instno = '$archequeno'  and bankcode='$bankname'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res22 = mysqli_fetch_array($exec22);

			//$arposttotalamount = $arposttotalamount + $res22['amount'];

			$arposttotalamount = 0;

			$post22 = mysqli_num_rows($exec22);

			if($post22 == 0 || $post22 == ''){

			//$arno = $arno + 1;

			//$artotalamount = $artotalamount + $artransactionamount;

			
			
		
			$amount = getcreditdebitor($ardocno,$artransactionamount);

			$credit_amount = $amount['credit_amount'];
			//$debit_amount = $amount['debit_amount'];

			 $total_credit_amount = $total_credit_amount + $credit_amount;
		    //$total_debit_amount =  $total_debit_amount  + $debit_amount;
		    $notes = "journal entries";
		     if($artransactionamount!='0.00')
		    {
		    	$arno = $arno + 1;
		    	$uncleared_incr +=1;
			?>

          
              	  <tr >

            
              	  	 <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $uncleared_incr; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $artransactiondate; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $archequedate; ?></div></td>
                

          		<td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $notes; ?></div></td>

                 <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $ardocno; ?></div></td>
                 
               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $archequeno; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="left">

			  <?php echo $araccountname; ?></td>

              <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php echo number_format($credit_amount,2,'.',',');?></div></td>

              

           </tr>

			<?php
		      }

			}

			}

			
			 }





			$bkno = '';

			

			//$query5 = "select * from bankentryform where (bankname like '%$bankname%' or frombankname like '%$bankname%') and transactiondate <='$ADate2' group by docnumber";

			$query5 = "select * from bankentryform where (tobankid = '$bankname' or frombankid = '$bankname') and transactiondate <='$ADate2' and  amount = 0 and creditamount > 0 group by docnumber";

			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

			$bknums = mysqli_num_rows($exec5);

			//$query45 = "select * from bank_record where notes = 'misc' and status IN ('Posted','Unpresented','Uncleared')";

			$query45 = "select * from bank_record where notes = 'misc'";

			$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die ("Error in Query45".mysqli_error($GLOBALS["___mysqli_ston"]));

			$post45 = mysqli_num_rows($exec45);

			$bknums = $bknums - $post45;

			if(true)

			{?>

			

		   <?php

			while ($res5 = mysqli_fetch_array($exec5))

			{

			

			$bkdocno = $res5['docnumber'];

			$bktransactiondate =$res5['transactiondate'];

			$bktransactiondate = date("d-m-Y", strtotime($bktransactiondate));

			$dramount = $res5['amount'];

			$cramount = $res5['creditamount'];

			$bktransactionamount = $cramount + $dramount;

			$bkchequeno = $res5['chequenumber'];

			if($bkchequeno=='')
			{
				$bkchequeno = 'Cr';
			}


			$bkpostedby = $res5['personname'];

			$bkremarks = $res5['remarks'];

			$bkbankname = $res5['bankname'];		

			$querybankname5 = "select * from master_bank where bankname like '%$bkbankname%' and bankstatus <> 'deleted'";

			$execbankname5 = mysqli_query($GLOBALS["___mysqli_ston"], $querybankname5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

			$resbankname5 = mysqli_fetch_array($execbankname5);

			$bkbankcode = $resbankname5['bankcode'];

			$bkaccountname = strtoupper($res5['transactiontype']);

			//$query25 = "select * from bank_record where docno = '$bkdocno' and status IN ('Posted','Unpresented','Uncleared')";

			$query25 = "select * from bank_record where docno = '$bkdocno'  and bankcode='$bankname'";

			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res25 = mysqli_fetch_array($exec25);

			//$bkposttotalamount = $bkposttotalamount + $res25['amount'];

			$bkposttotalamount = 0;

			$post25 = mysqli_num_rows($exec25);

			if($post25 == 0 || $post25 == ''){

			//$bkno = $bkno + 1;

			//$bktotalamount = $bktotalamount + $bktransactionamount;

			
			

		

			$amount = getcreditdebitor($bkdocno,$bktransactionamount);
			$credit_amount = $amount['credit_amount'];
			//$debit_amount = $amount['debit_amount'];

		    $total_credit_amount = $total_credit_amount + $credit_amount;
		    //$total_debit_amount =  $total_debit_amount  + $debit_amount;

		    $notes = "bank entry";

		     if($bktransactionamount!='0.00')
		    {
		    	$bkno = $bkno + 1;
		    	$uncleared_incr +=1;
			?>

        		  <tr >

            <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $uncleared_incr; ?></div></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $bktransactiondate; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $bktransactiondate; ?></div></td>
                

          		<td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $notes; ?></div></td>

                 <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $bkdocno; ?></div></td>
                 
               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $bkchequeno; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="left">

			  <?php echo $bkaccountname; ?></td>

              <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php echo number_format($credit_amount,2,'.',',');?></div></td>

              

           </tr>
              

			<?php
				}

			}

			}

				$total_uncleared = $total_credit_amount;
			 }

			

			?>
			<tr >

            <td colspan="4"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>&nbsp;</strong></td>
             <td  colspan="3" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Uncleared Total</strong></td>
             <td  align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php echo number_format($total_uncleared,2,'.',',');?></strong></td>
              
            </tr>



            <tr >

            <td colspan="4"  align="left" valign="left" bgcolor="#ffffff" class="bodytext31"><strong>&nbsp;</strong></td>
             <td  colspan="3" align="right" valign="left" bgcolor="#ffffff" class="bodytext31"><strong>&nbsp;</strong></td>
             <td   align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>&nbsp;</strong></td>
             
              
            </tr>
              <tr >

            <td colspan="4"  align="left" valign="left" bgcolor="#ffffff" class="bodytext31"><strong>&nbsp;</strong></td>
             <td  colspan="3" align="right" valign="left" bgcolor="#ffffff" class="bodytext31"><strong>&nbsp;</strong></td>
             <td   align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>&nbsp;</strong></td>
             
              
            </tr>
            <?php 
            $calculated_balance = 0;
            $calculated_balance = $total_unpresented + $statementamount - $total_uncleared;
            ?>
			<tr >

            <td colspan="4"  align="left" valign="left" bgcolor="#ffffff" class="bodytext31"><strong>&nbsp;</strong></td>
             <td  colspan="3" align="right" valign="left" bgcolor="#ffffff" class="bodytext31"><strong>Calculated Balance</strong></td>
             <td   align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php echo number_format($calculated_balance,2,'.',',');?></strong></td>
             
              
            </tr>

            <?php 
            $ledger_id = $bankname;
             // debit tot bal
				        /*$query3 = "select auto_number,transaction_date,transaction_type as t_type,sum(transaction_amount) as damount from tb where ledger_id='$ledger_id' and transaction_type='D' and transaction_date < '$fromdate' group by transaction_type";
						$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
						$res3 = mysql_fetch_array($exec3);
                        $d_amount = $res3['damount'];

                        // debit tot bal
				        $query3 = "select auto_number,transaction_date,transaction_type as t_type,sum(transaction_amount) as camount from tb where ledger_id='$ledger_id' and transaction_type='C' and transaction_date < '$fromdate' group by transaction_type";
						$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
						$res3 = mysql_fetch_array($exec3);
                        $c_amount = $res3['camount'];
                        $t_amount = $d_amount - $c_amount;
                        $opening_bal_d = ($t_amount>=0)?$t_amount:0;
                        $opening_bal_c = ($t_amount<0)?$t_amount:0;

                        $opening_bal = $t_amount;*/

                        $opening_bal = 0;

                        
            
			$query2 = "select * from tb where ledger_id='$ledger_id' and transaction_date <= '$ADate2' order by transaction_date asc";
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
			$transaction_date = $res2["transaction_date"];
			$transaction_type = $res2['transaction_type'];
			$transaction_number = $res2['doc_number'];

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
	        

	        
			$sno = $sno + 1;
			$transaction_amount = $res2['transaction_amount'];
			
			
			    
				
				
					
					   $amt_d = number_format((float)$debit_amount, 2, '.', ','); 
					   $total_d = (float)$total_d + (float)$debit_amount;
					 
				
					  $amt_c = number_format((float)$credit_amount, 2, '.', ','); 
					  $total_c = (float)$total_c + (float)$credit_amount;
					  //echo $total_c
				   
				
					
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
						
					
				
		   
		   } 
		  
		  
		  
   
            if($closing_bal >=0) { 
            	$amt = number_format((float)$closing_bal, 2, '.', ','); 
            }
       
        
            if($closing_bal <0) {
             $val = ((float)$closing_bal * -1);
            	$amt = number_format((float)$val, 2, '.', ','); 
            }
       
               
           

            $closing_balance_ledger = $closing_bal;

            $difference = $closing_balance_ledger - $calculated_balance;
             ?>

             <tr >

            <td colspan="4"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>&nbsp;</strong></td>
             <td  colspan="3" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Cash Book Balance</strong></td>
             <td  align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php echo number_format($closing_balance_ledger,2,'.',',');?></strong></td>
              
            </tr>

             <tr >

            <td colspan="4"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>&nbsp;</strong></td>
             <td  colspan="3" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Difference</strong></td>
             <td    align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php echo number_format($difference,2,'.',',');?></strong></td>
             
            </tr>
           </tbody>

	</table>
</body>

<?php }



function getcreditdebitor($refno,$aptransactionamount)
{
	
	$debit_amount = '0.00';
	$credit_amount = '0.00';
	$haystack = $refno;
	$needle   = "AR";
	if( strpos( $haystack, $needle ) !== false) {
		
		$debit_amount = $aptransactionamount;
		$credit_amount = '0.00';
	}
	else
	{
		$debit_amount = '0.00';
		$needle   = "SPE";
		if( strpos( $haystack, $needle ) !== false) {
		
			$credit_amount = $aptransactionamount;
		}
		else
		{
			$credit_amount = '0.00';
			$needle   = "RE";
			if( strpos( $haystack, $needle ) !== false) {
		
				$debit_amount = $aptransactionamount;
				$credit_amount = '0.00';
			}
			else
			{
				$debit_amount = '0.00';

				$needle   = "BE";
				if( strpos( $haystack, $needle ) !== false) {
		
					$credit_amount = $aptransactionamount;
				}
				else
				{
					$credit_amount = '0.00';
					//FOR DOCTORS PAYMENT ENTRY
					$debit_amount = '0.00';
					$needle   = "DP";
					if( strpos( $haystack, $needle ) !== false) {
					
						$credit_amount = $aptransactionamount;
					}
					else{
						$credit_amount = '0.00';
						
					}
				}
			}

		}
	}

$needle   = "EN";
	if( strpos( $haystack, $needle ) !== false) {
	
		if($aptransactionamount<0)
			$credit_amount = abs($aptransactionamount);
		else
			$debit_amount = abs($aptransactionamount);
	}

	$amount['debit_amount'] = $debit_amount;
	$amount['credit_amount'] = $credit_amount;
	return $amount;
		    
}



?>

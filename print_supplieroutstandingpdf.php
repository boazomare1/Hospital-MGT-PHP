<?php

require_once('html2pdf/html2pdf.class.php');

ob_start();

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$totalsum = 0.00;

$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$total = '0.00';

$totalat = '0.00';

$exchange_rate=1;

$searchsuppliername = "";

$cbsuppliername = "";

$snocount = "";

$colorloopcount="";

$range = "";

$arraysuppliername = '';

$arraysuppliercode = '';	

$totalatret = 0.00;

$totalpayment = 0.00;

$totout = 0.00;

$res112subtotal = 0.00;



$query1 = "select * from master_company where auto_number = '$companyanum'";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res1 = mysqli_fetch_array($exec1);

$res1companyname = $res1['companyname'];

$res1address1 = $res1['address1'];

$resfaxnumber1 = $res1['faxnumber1'];

$res1area = $res1['area'];

$res1city = $res1['city'];

$res1state = $res1['state'];

$res1emailid1= $res1['emailid1'];

$res1country = $res1['country'];

$res1pincode = $res1['pincode'];

$phonenumber1 = $res1['phonenumber1'];

$locationname = $res1['locationname'];

$locationcode = $res1['locationcode'];



if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

//echo $searchsuppliername;

if (isset($_REQUEST["code"])) { $searchsuppliercode = $_REQUEST["code"]; } else { $searchsuppliercode = ""; }



if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

//echo $ADate2;

if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }

//echo $range;

if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }

//echo $amount;

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

//$frmflag2 = $_POST['frmflag2'];

?>



       <?php

				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{

					if (isset($_REQUEST["name"])) { $arraysuppliername = $_REQUEST["name"]; } else { $arraysuppliername = ""; }

					//echo $searchsuppliername;

					if (isset($_REQUEST["code"])) { $arraysuppliercode = $_REQUEST["code"]; } else { $arraysuppliercode = ""; }



					if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

					//echo $ADate1;

					if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

				}	

				?>

                <?php  include("print_header1.php"); ?>



         <table width="1000" border="1" cellspacing="3" cellpadding="0" style="border-collapse:collapse;">

            <tr>

              <td colspan="8" class="bodytext31" valign="middle"  align="left" 

                bgcolor="#ffffff">&nbsp;</td>

            </tr>

            <tr>

              <td colspan="8" class="bodytext31" valign="middle"  align="center" 

                bgcolor="#ffffff"><strong>Supplier Outstanding</strong></td>

            </tr>

			<?php

				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				if (isset($_REQUEST["name"])) { $arraysuppliername = $_REQUEST["name"]; } else { $arraysuppliername = ""; }

				if (isset($_REQUEST["code"])) { $arraysuppliercode = $_REQUEST["code"]; } else { $arraysuppliercode = ""; }

				

				$arraysuppliercode=$searchsuppliercode;

				$openingbalance =0;

				$query_acc = "select * from master_accountname where id = '$arraysuppliercode'";

				  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_acc) or die ("Error in query_acc".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $res1 = mysqli_fetch_array($exec1);

				  $currency = $res1['currency'];

				  

			$res21accountname = $res1['accountname'];

			$supplieranum = $res1['auto_number'];

			if( $res21accountname != '')

			{

			?>

			<tr bgcolor="#ffffff">

            <td colspan="8"  align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong><?php echo $res21accountname;?> (Date From: <?php echo $ADate1; ?> Date To: <?php echo $ADate2;?>)</strong></td>

            </tr>

			

			<?php } ?>

			<tr>

				<td width="35" class="bodytext31" valign="middle"  align="left" bgcolor="#ffffff"><strong>No.</strong></td>

				<td width="75" align="left" valign="middle"  bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>

				<td width="277" align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>

				<td width="100" align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong> Invoice No </strong></td>

				<td width="150" align="right" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>Debit</strong></td>

				<td width="150" align="right" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>Credit</strong></td>

				<td width="60" align="right" valign="middle"  bgcolor="#ffffff" class="bodytext31"><strong>Days</strong></td>

				<td width="180" align="right" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>Current Balance</strong></td>

			</tr>



			<?php

			$cur_qry = "select * from master_currency where currency like '$currency'";

				  $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $cur_qry) or die ("Error in cur_qry".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $res21 = mysqli_fetch_array($exec21);

				  $exchange_rate = $res21['rate'];

				  if($exchange_rate == 0.00)

				  {

					  $exchange_rate=1;

				  }

			  $query45 = "select totalfxamount,billnumber from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and transactiondate < '$ADate1' and transactiontype = 'PURCHASE'  and billnumber NOT LIKE 'PV%'  ";

		  $exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die ("Error in Query45".mysqli_error($GLOBALS["___mysqli_ston"]));

		  //echo $num = mysql_num_rows($exec3);

		  while ($res45 = mysqli_fetch_array($exec45))

		  {

		  $res45transactionamount1 = $res45['totalfxamount'];

		  $res45billnumber=$res45['billnumber'];


		  /////////////// for wht //////////////
		  $wh_tax_value=0;
		   $query222 = "select sum(wh_tax_value) as wh_tax_value from purchase_details where billnumber='$res45billnumber' and suppliercode = '$arraysuppliercode' and entrydate < '$ADate1' group by billnumber";
		  $exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res222 = mysqli_fetch_array($exec222);
		  $wh_tax_value = $res222['wh_tax_value'];
		  //////////////// for wht //////////////
		  $res45transactionamount=$res45transactionamount1-$wh_tax_value;

		  

		  $query98 = "select sum(transactionamount) from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and billnumber = '$res45billnumber' and transactiondate < '$ADate1' and transactiontype= 'PAYMENT' and recordstatus <> 'deallocated' and transactionmode <> 'CREDIT' and transactionstatus=''  and billnumber NOT LIKE 'PV%' ";

		  $exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		  $num98 = mysqli_num_rows($exec98);

		  while($res98 = mysqli_fetch_array($exec98))

		  {

         $totalpayment =$res98['sum(transactionamount)'];

		  }

		  if($totalpayment != $res45transactionamount) 

		  {

		  $openingbalance=$openingbalance+($res45transactionamount-$totalpayment);

		  }  

				

		    }

			

			 $query145 = "select * from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and transactiondate < '$ADate1'  and transactiontype = 'PURCHASE'  and billnumber NOT LIKE 'PV%'  order by transactiondate desc";

		  $exec145 = mysqli_query($GLOBALS["___mysqli_ston"], $query145) or die ("Error in Query145".mysqli_error($GLOBALS["___mysqli_ston"]));

		  //echo $num = mysql_num_rows($exec3);

		  while ($res145 = mysqli_fetch_array($exec145))

		  {

     	  $res145transactiondate = $res145['transactiondate'];

	      $res145patientname = $res145['suppliername'];

		  $res145patientcode = $res145['suppliercode'];

		  $res145transactionamount = $res145['transactionamount'];

		  $res145billnumber = $res145['billnumber'];

		  $res145openingbalance = $res145['openingbalance'];

		  $res145docno = $res145['docno'];

		  
     	  $query113 = "select * from purchasereturn_details where grnbillnumber= '$res145billnumber' and entrydate < '$ADate1' order by entrydate desc";

		  $exec113 = mysqli_query($GLOBALS["___mysqli_ston"], $query113) or die ("Error in Query113".mysqli_error($GLOBALS["___mysqli_ston"]));

		  //echo $num = mysql_num_rows($exec3);

		   while ($res113 = mysqli_fetch_array($exec113)) {

		   

		     

		  $res113billnumber= $res113['grnbillnumber'];

		  $res113rbillnumber= $res113['billnumber'];

		   $res112subtotal=0;

		  $query112 = "select *  from purchasereturn_details where grnbillnumber = '$res113billnumber' and entrydate < '$ADate1' ";

		  $exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));

		  //echo $num = mysql_num_rows($exec3);

		   while($res112 = mysqli_fetch_array($exec112)) {

		     

		   $res112subtotal += $res112['subtotal'];

		          }

		   		  

		  

			 if($res112subtotal != 0)

			 { 

			 $openingbalance=$openingbalance-$res112subtotal;

		     } }

           }

		   

		   

		    $query145on = "select * from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and transactiondate < '$ADate1' and transactionmodule = 'PAYMENT' and transactionstatus = 'onaccount'  and billnumber NOT LIKE 'PV%'  order by transactiondate desc";

		  $exec145on = mysqli_query($GLOBALS["___mysqli_ston"], $query145on) or die ("Error in Query145on".mysqli_error($GLOBALS["___mysqli_ston"]));

		  //echo $num = mysql_num_rows($exec3);

		  while ($res145on = mysqli_fetch_array($exec145on))

		  {

     	  $res145ontransactiondate = $res145on['transactiondate'];

	      $res145onpatientname = $res145on['suppliername'];

		  $res145onpatientcode = $res145on['suppliercode'];

		  $res145ontransactionamount = $res145on['transactionamount'];

		  $res145onbillnumber = $res145on['billnumber'];

		  $res145onopeningbalance = $res145on['openingbalance'];

		  $res145ondocno = $res145on['docno'];

		 

		  $res146ontransactionamount = '';

		  

		  $query146on = "select * from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and docno='$res145ondocno' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and recordstatus <> 'deallocated' and transactionstatus <> 'onaccount' and billnumber NOT LIKE 'PV%'   order by transactiondate desc";

		  $exec146on = mysqli_query($GLOBALS["___mysqli_ston"], $query146on) or die ("Error in Query146on".mysqli_error($GLOBALS["___mysqli_ston"]));

		  //echo $num = mysql_num_rows($exec3);

		  while ($res146on = mysqli_fetch_array($exec146on))

		  {

		  $res146ontransactionamount += $res146on['transactionamount'];

		  }

		  $res146ontransactionamount =$res145ontransactionamount - $res146ontransactionamount;

		  

 if($res146ontransactionamount != 0)

			 {

			  $openingbalance = $openingbalance - $res146ontransactionamount; 

		    }

           }   

		    

		  $query69 = "select * from master_journalentries where ledgerid = '$arraysuppliercode' and entrydate < '$ADate1' order by entrydate desc";

		  $exec69 = mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die ("Error in Query69".mysqli_error($GLOBALS["___mysqli_ston"]));

		  //echo $num = mysql_num_rows($exec3);

		  while ($res69 = mysqli_fetch_array($exec69))

		  {

     	  $journalcredit = $res69['creditamount']-$res69['debitamount'];

		

					 $openingbalance=$openingbalance+$journalcredit;



				  }

				   //////////////sdbt bills////////
				  
				$query5 = "SELECT sum(total_amount) as total_amount from supplier_debit_transactions where supplier_id = '$arraysuppliercode'  and date(created_at) < '$ADate1' ";
			  $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			  // $num5 = mysql_num_rows($exec5);
			  $res5 = mysqli_fetch_array($exec5);
			  	$total_amount = $res5['total_amount'];
			  	
			  	$openingbalance=$openingbalance-$total_amount;

  		$openingbalance = $openingbalance / $exchange_rate;

		  ?><!--

		<tr >

			<td colspan="7" class="bodytext31" valign="middle"  align="left"><strong> Opening Balance </strong> </td>

			<td class="bodytext31" valign="middle"  align="right"><strong><?php echo number_format($openingbalance,2,'.',''); ?></strong> </td>

		</tr>-->

			<?php

			$totalamount30 = 0;

			$totalamount60 = 0;

			$totalamount90 = 0;

			$totalamount120 = 0;

			$totalamount180 = 0;

			$totalamountgreater = 0;



		    $query45 = "select transactiondate as groupdate,suppliername,suppliercode,totalfxamount,billnumber, auto_number from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PURCHASE'  and billnumber NOT LIKE 'PV%'  ";

			$query45 .= " union all select transactiondate as groupdate,suppliername,suppliercode,totalfxamount,billnumber,docno from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactionmodule = 'PAYMENT' and transactionstatus = 'onaccount'  and billnumber NOT LIKE 'PV%' ";

			$query45 .= " UNION ALL SELECT entrydate as groupdate,username,locationcode,sum(`openbalanceamount`) as totalfxamount, docno as billnumber,auto_number FROM `openingbalanceaccount` WHERE `accountcode` = '$arraysuppliercode' AND `entrydate` between '$ADate1' and '$ADate2'";

			$query45 .= "union all select entrydate as groupdate,username,locationcode, sum(creditamount-debitamount) as totalfxamount,docno,auto_number from master_journalentries where ledgerid = '$arraysuppliercode' and entrydate between '$ADate1' and '$ADate2' group by docno ";
			// order by groupdate asc

			$query45 .= " UNION ALL SELECT date(created_at) as groupdate,user_id as username,'' as locationcode,(total_amount) as totalfxamount,approve_id as docno,auto_number from supplier_debit_transactions where supplier_id = '$arraysuppliercode'  and date(created_at) between '$ADate1' and '$ADate2' order by groupdate ASC";

			//  echo $query45;

		  $exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die ("Error in Query45".mysqli_error($GLOBALS["___mysqli_ston"]));

		  //echo $num = mysql_num_rows($exec3);

		  while ($res45 = mysqli_fetch_array($exec45))

		  

		  {

		  

		  

     	  $res45transactiondate = $res45['groupdate'];

	      $res45patientname = $res45['suppliername'];

		  $res45patientcode = $res45['suppliercode'];

		  $res45transactionamount1 = $res45['totalfxamount'];

		  $res45billnumber = $res45['billnumber'];

		  $res45openingbalance = $res45['auto_number'];


		   /////////////// for wht //////////////
		  $wh_tax_value=0;
		   $query222 = "select sum(wh_tax_value) as wh_tax_value from purchase_details where billnumber='$res45billnumber' and suppliercode = '$arraysuppliercode' and entrydate between '$ADate1' and '$ADate2' group by billnumber";
		  $exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in Query222".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $res222 = mysqli_fetch_array($exec222);
		  $wh_tax_value = $res222['wh_tax_value'];
		  //////////////// for wht //////////////
		  $res45transactionamount=$res45transactionamount1-$wh_tax_value;

		  $query456="select auto_number from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PURCHASE' and  transactionstatus <> 'onaccount' and billnumber='$res45billnumber' and auto_number='$res45openingbalance'";

		  $exe456=mysqli_query($GLOBALS["___mysqli_ston"], $query456);

		  $num456=mysqli_num_rows($exe456);

		  if($num456>0)

		  {

		  $query98 = "select sum(transactionamount) from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and billnumber = '$res45billnumber' and transactiondate between '$ADate1' and '$ADate2' and transactiontype= 'PAYMENT' and recordstatus <> 'deallocated' and transactionmode <> 'CREDIT' and transactionstatus=''";

		  $exec98 = mysqli_query($GLOBALS["___mysqli_ston"], $query98) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		  $num98 = mysqli_num_rows($exec98);

		  while($res98 = mysqli_fetch_array($exec98))

		  {

         $totalpayment =$res98['sum(transactionamount)'];

		  }

		  

		  $query85 = "select * from master_purchase where billnumber = '$res45billnumber' and billdate between '$ADate1' and '$ADate2' order by billdate desc";

		  $exec85 = mysqli_query($GLOBALS["___mysqli_ston"], $query85) or die ("Error in Query85".mysqli_error($GLOBALS["___mysqli_ston"]));

		  //echo $num = mysql_num_rows($exec3);

		   while ($res85 = mysqli_fetch_array($exec85))

		  {

		  $res85supplierbillnumber = $res85['supplierbillnumber'];

		 

		 

		  $totalat = $totalat + $res45transactionamount + $openingbalance;

		  $totalout = $res45transactionamount - $totalpayment;

		  $totalout = $totalout / $exchange_rate;

		  $totcur = $totalout - $totalat;

		   }

		     if($totalpayment != $res45transactionamount) 

			   {

		    $t1 = strtotime("$ADate2");

		  $t2 = strtotime("$res45transactiondate");

		  $days_between = ceil(abs($t1 - $t2) / 86400);

		  $snocount = $snocount + 1;

		  

		  if($snocount == 1)

		  {

		  $total = $openingbalance + $totalout;

		  }

		  else

		  {

		  $total = $total + $totalout;

		  }

		

		  

		  if($days_between <= 30)

		  {

		  if($snocount == 1)

		  {

		  $totalamount30 = $openingbalance + $totalout;

		  }

		  else

		  {

		  $totalamount30 = $totalamount30 + $totalout;

		  }

		  }

		  else if(($days_between >30) && ($days_between <=60))

		  {

		  if($snocount == 1)

		  {

		  $totalamount60 = $openingbalance + $totalout;

		  }

		  else

		  {

		  $totalamount60 = $totalamount60 + $totalout;

		  }

		  }

		  else if(($days_between >60) && ($days_between <=90))

		  {

		  if($snocount == 1)

		  {

		  $totalamount90 = $openingbalance + $totalout;

		  }

		  else

		  {

		  $totalamount90 = $totalamount90 + $totalout;

		  }

		  }

		  else if(($days_between >90) && ($days_between <=120))

		  {

		  if($snocount == 1)

		  {

		  $totalamount120 = $openingbalance + $totalout;

		  }

		  else

		  {

		  $totalamount120 = $totalamount120 + $totalout;

		  }

		  }

		  else if(($days_between >120) && ($days_between <=180))

		  {

		    if($snocount == 1)

		  {

		  $totalamount180 = $openingbalance + $totalout;

		  }

		  else

		  {

		  $totalamount180 = $totalamount180 + $totalout;

		  }

		  }

		  else

		  {

		      if($snocount == 1)

		  {

		  $totalamountgreater = $openingbalance + $totalout;

		  }

		  else

		  {

		  $totalamountgreater = $totalamountgreater + $totalout;

		  }

		  }

			

			//echo $cashamount;

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

				$colorcode = '';

			}

	        

			?>

			<?php 

			

			?>

			

		<tr >

			<td width="35" class="bodytext31" valign="middle"  align="left"><?php echo $snocount; ?></td>

			<td width="75" class="bodytext31" valign="middle"  align="left"><?php echo $res45transactiondate; ?></td>

			<td width="277" class="bodytext31" valign="middle"  align="left"><?php echo 'Towards Purchase'; ?> (<?php echo $res45billnumber;  ?>)</td>

			<td width="100" class="bodytext31" valign="middle"  align="left"><?php echo $res85supplierbillnumber; ?></td>

			<td width="150" class="bodytext31" valign="middle"  align="right"> <?php //echo number_format($res45transactionamount,2,'.',',');  ?></td>

			<td width="150" class="bodytext31" valign="middle"  align="right"> <?php  echo number_format($totalout,2,'.',',');?>  <?php $totalsum = $totalsum + $totalout; ?></td>

			<td width="60" class="bodytext31" valign="middle"  align="right"> <?php echo $days_between;?> </td>

			<td width="180" class="bodytext31" valign="middle"  align="right">  <?php echo number_format($totalsum,2,'.',','); ?> </td>

			

		</tr>

				

		      <?php 

			    } 

			}	

				     

			$query1131 = "select * from openingbalanceaccount where docno= '$res45billnumber' and entrydate between '$ADate1' and '$ADate2' order by entrydate desc";

		  $exec1131 = mysqli_query($GLOBALS["___mysqli_ston"], $query1131) or die ("Error in Query113".mysqli_error($GLOBALS["___mysqli_ston"]));

		 $num1131 = mysqli_num_rows($exec1131);

		  if($num1131>0)

		  {

     	  $res145transactiondate = $res45['groupdate'];

	      $res145patientname = $res45['suppliername'];

		  $res145patientcode = $res45['suppliercode'];

		  $res145transactionamount = $res45['totalfxamount'];

		  $res145billnumber = $res45['billnumber'];

//		  $res145openingbalance = $res45['openingbalance'];

		

		  

		   $query198 = "select sum(transactionamount) from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and billnumber = '$res145billnumber' and transactiondate between '$ADate1' and '$ADate2' and transactionmodule= 'PAYMENT' order by transactiondate desc";

		  $exec198 = mysqli_query($GLOBALS["___mysqli_ston"], $query198) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		  $num198 = mysqli_num_rows($exec198);

		  while($res198 = mysqli_fetch_array($exec198))

		  {

         $totalpayment =$res198['sum(transactionamount)'];

		  }

		    

     	  $query113 = "select * from openingbalanceaccount where docno= '$res145billnumber' and entrydate between '$ADate1' and '$ADate2' order by entrydate desc";

		  $exec113 = mysqli_query($GLOBALS["___mysqli_ston"], $query113) or die ("Error in Query113".mysqli_error($GLOBALS["___mysqli_ston"]));

		  //echo $num = mysql_num_rows($exec3);

		   while ($res113 = mysqli_fetch_array($exec113)) {

		   

		     

		  $res113billnumber='';

		  $res113rbillnumber= $res113['docno'];

		   

		  $query112 = "select *  from openingbalanceaccount where docno = '$res113rbillnumber' and entrydate between '$ADate1' and '$ADate2' ";

		  $exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));

		  //echo $num = mysql_num_rows($exec3);

		   while($res112 = mysqli_fetch_array($exec112)) {

		     

		   $res112subtotal= $res112['openbalanceamount'];

		    $res112subtotal = $res112subtotal / $exchange_rate;

		          }

		   		  

		  

				  		  

		   $totalsum = $totalsum - $res112subtotal;

		   $t1 = strtotime("$ADate2");

		  $t2 = strtotime("$res145transactiondate");

		  $days_between = ceil(abs($t1 - $t2) / 86400);

		 

		   

		  $snocount = $snocount + 1;

		  

		    if($days_between <= 30)

		  {

		  $totalamount30 = $totalamount30 - $res112subtotal;

		  

		 //echo $totalamount30;

		  }

		  else if(($days_between >30) && ($days_between <=60))

		  {

		  $totalamount60 = $totalamount60 - $res112subtotal;

		 

		  }

		  else if(($days_between >60) && ($days_between <=90))

		  {

		  $totalamount90 = $totalamount90 - $res112subtotal;

		  

		  }

		  else if(($days_between >90) && ($days_between <=120))

		  {

		 

		  $totalamount120 = $totalamount120 - $res112subtotal;

		 

		  }

		  else if(($days_between >120) && ($days_between <=180))

		  {

		 

		  $totalamount180 = $totalamount180 - $res112subtotal;

		 

		  }

		  else

		  {

		  

		  $totalamountgreater = $totalamountgreater - $res112subtotal;

		  

		  }

		

		  

			//echo $cashamount;

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

			<?php if($res112subtotal != 0)

			 { 

			  ?>

			

		<tr >

			<td width="35" class="bodytext31" valign="middle"  align="left"><?php echo $snocount; ?></td>

			<td width="75" class="bodytext31" valign="middle"  align="left"> <?php echo $res145transactiondate; ?> </td>

			<td width="277" class="bodytext31" valign="middle"  align="left"><?php echo 'Towards Opening Debit ('.$res113rbillnumber.','.$res145billnumber;  ?>) </td>

			<td width="100" class="bodytext31" valign="middle"  align="left">Opening Balance </td>

			<td width="150" class="bodytext31" valign="middle"  align="right"> <?php echo number_format($res112subtotal,2,'.',','); ?></td>

			<td width="150" class="bodytext31" valign="middle"  align="right"><?php //echo number_format($res5transactionamount,2,'.',',');?> </td>

			<td width="60" class="bodytext31" valign="middle"  align="right"> <?php echo $days_between;?> </td>

			<td width="180" class="bodytext31" valign="middle"  align="right"><?php echo number_format($totalsum,2,'.',','); ?> </td>

			

		</tr>

			

		   <?php

		     } }

           }   

		

		

		  $query1131 = "select * from purchasereturn_details where grnbillnumber= '$res45billnumber' and entrydate between '$ADate1' and '$ADate2' order by entrydate desc";

		  $exec1131 = mysqli_query($GLOBALS["___mysqli_ston"], $query1131) or die ("Error in Query113".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $num1131 = mysqli_num_rows($exec1131);

		  if($num1131>0)

		  {

     	  $res145transactiondate = $res45['groupdate'];

	      $res145patientname = $res45['suppliername'];

		  $res145patientcode = $res45['suppliercode'];

		  $res145transactionamount = $res45['totalfxamount'];

		  $res145billnumber = $res45['billnumber'];

//		  $res145openingbalance = $res45['openingbalance'];

		

		  

		   $query198 = "select sum(transactionamount) from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and billnumber = '$res145billnumber' and transactiondate between '$ADate1' and '$ADate2' and transactionmodule= 'PAYMENT' order by transactiondate desc";

		  $exec198 = mysqli_query($GLOBALS["___mysqli_ston"], $query198) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		  $num198 = mysqli_num_rows($exec198);

		  while($res198 = mysqli_fetch_array($exec198))

		  {

         $totalpayment =$res198['sum(transactionamount)'];

		  }

		    

     	  $query113 = "select * from purchasereturn_details where grnbillnumber= '$res145billnumber' and entrydate between '$ADate1' and '$ADate2' order by entrydate desc";

		  $exec113 = mysqli_query($GLOBALS["___mysqli_ston"], $query113) or die ("Error in Query113".mysqli_error($GLOBALS["___mysqli_ston"]));

		  //echo $num = mysql_num_rows($exec3);

		   while ($res113 = mysqli_fetch_array($exec113)) {

		   

		     

		  $res113billnumber= $res113['grnbillnumber'];

		  $res113rbillnumber= $res113['billnumber'];

		   

		  $query112 = "select *  from purchasereturn_details where grnbillnumber = '$res113billnumber' and entrydate between '$ADate1' and '$ADate2' ";

		  $exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));

		  //echo $num = mysql_num_rows($exec3);

		   while($res112 = mysqli_fetch_array($exec112)) {

		     

		   $res112subtotal= $res112['subtotal'];

		   

		   $res112subtotal = $res112subtotal / $exchange_rate;

		          }

		   		  

		  

				  		  

		   $totalsum = $totalsum - $res112subtotal;

		   $t1 = strtotime("$ADate2");

		  $t2 = strtotime("$res145transactiondate");

		  $days_between = ceil(abs($t1 - $t2) / 86400);

		 

		   

		  $snocount = $snocount + 1;

		  

		    if($days_between <= 30)

		  {

		  $totalamount30 = $totalamount30 - $res112subtotal;

		  

		 //echo $totalamount30;

		  }

		  else if(($days_between >30) && ($days_between <=60))

		  {

		  $totalamount60 = $totalamount60 - $res112subtotal;

		 

		  }

		  else if(($days_between >60) && ($days_between <=90))

		  {

		  $totalamount90 = $totalamount90 - $res112subtotal;

		  

		  }

		  else if(($days_between >90) && ($days_between <=120))

		  {

		 

		  $totalamount120 = $totalamount120 - $res112subtotal;

		 

		  }

		  else if(($days_between >120) && ($days_between <=180))

		  {

		 

		  $totalamount180 = $totalamount180 - $res112subtotal;

		 

		  }

		  else

		  {

		  

		  $totalamountgreater = $totalamountgreater - $res112subtotal;

		  

		  }

		

		  

			//echo $cashamount;

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

				$colorcode = '';

			}

	    

			?>

			<?php if($res112subtotal != 0)

			 { 

			  ?>

			

		<tr >

			<td width="35" class="bodytext31" valign="middle"  align="left"><?php echo $snocount; ?></td>

			<td width="75" class="bodytext31" valign="middle"  align="left"> <?php echo $res145transactiondate; ?> </td>

			<td width="277" class="bodytext31" valign="middle"  align="left"> <?php echo 'Towards Return ('.$res113rbillnumber.','.$res145billnumber; ?>) </td>

			<td width="100" class="bodytext31" valign="middle"  align="left"> <?php //echo number_format($res45transactionamount,2,'.',','); ?></td>

			<td width="150" class="bodytext31" valign="middle"  align="right"> <?php echo number_format($res112subtotal,2,'.',','); ?></td>

			<td width="150" class="bodytext31" valign="middle"  align="right"> <?php //echo number_format($res5transactionamount,2,'.',',');?> </td>

			<td width="60" class="bodytext31" valign="middle"  align="right"> <?php echo $days_between;?> </td>

			<td width="180" class="bodytext31" valign="middle"  align="right">  <?php echo number_format($totalsum,2,'.',','); ?> </td>

			

		</tr>



			

		   <?php

		     } }

           }   

		   ?>

			  <?php

		   // Onaccount 

		    $query145on = "select * from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactionmodule = 'PAYMENT' and transactionstatus = 'onaccount' and billnumber='$res45billnumber' and docno='$res45openingbalance' order by transactiondate desc";

		  $exec145on = mysqli_query($GLOBALS["___mysqli_ston"], $query145on) or die ("Error in Query145on".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $num145on = mysqli_num_rows($exec145on);

		  if($num145on >0)

		  {

     	  $res145ontransactiondate = $res45['groupdate'];

	      $res145onpatientname = $res45['suppliername'];

		  $res145onpatientcode = $res45['suppliercode'];

		  $res145ontransactionamount = $res45['transactionamount'];

		  $res145onbillnumber = $res45['billnumber'];

		 

		  $res145ondocno = $res45['auto_number'];

		 

		  $res146ontransactionamount = '';

		  

		  $query146on = "select * from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and docno='$res145ondocno' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and recordstatus <> 'deallocated' and transactionstatus <> 'onaccount'  order by transactiondate desc";

		  $exec146on = mysqli_query($GLOBALS["___mysqli_ston"], $query146on) or die ("Error in Query146on".mysqli_error($GLOBALS["___mysqli_ston"]));

		  //echo $num = mysql_num_rows($exec3);

		  while ($res146on = mysqli_fetch_array($exec146on))

		  {

		  $res146ontransactionamount += $res146on['transactionamount'];

		  }

		  $res146ontransactionamount =$res145ontransactionamount - $res146ontransactionamount;

		  $res146ontransactionamount = $res146ontransactionamount / $exchange_rate;

		   $totalsum = $totalsum - $res146ontransactionamount;

		  $snocount = $snocount + 1;

			

		  $t1 = strtotime("$ADate2");

		  $t2 = strtotime("$res145ontransactiondate");

		  $days_between = ceil(abs($t1 - $t2) / 86400);

		  

		     if($days_between <= 30)

		  {

		  $totalamount30 = $totalamount30 - $res146ontransactionamount;

		  

		 //echo $totalamount30;

		  }

		  else if(($days_between >30) && ($days_between <=60))

		  {

		  $totalamount60 = $totalamount60 - $res146ontransactionamount;

		 

		  }

		  else if(($days_between >60) && ($days_between <=90))

		  {

		  $totalamount90 = $totalamount90 - $res146ontransactionamount;

		  

		  }

		  else if(($days_between >90) && ($days_between <=120))

		  {

		 

		  $totalamount120 = $totalamount120 - $res146ontransactionamount;

		 

		  }

		  else if(($days_between >120) && ($days_between <=180))

		  {

		 

		  $totalamount180 = $totalamount180 - $res146ontransactionamount;

		 

		  }

		  else

		  {

		  

		  $totalamountgreater = $totalamountgreater - $res146ontransactionamount;

		  

		  }

		  

			//echo $cashamount;

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

				$colorcode = '';

			}

	    

			?>

			<?php if($res146ontransactionamount != 0)

			 { 

			  ?>

		<tr >

			<td width="35" class="bodytext31" valign="middle"  align="left"><?php echo $snocount; ?></td>

			<td width="75" class="bodytext31" valign="middle"  align="left"> <?php echo $res145transactiondate; ?> </td>

			<td width="277" class="bodytext31" valign="middle"  align="left"> <?php echo 'Onaccount ('.$res145ondocno; ?>) </td>

			<td width="100" class="bodytext31" valign="middle"  align="left"> <?php //echo number_format($res45transactionamount,2,'.',','); ?></td>

			<td width="150" class="bodytext31" valign="middle"  align="right"> <?php echo number_format($res146ontransactionamount,2,'.',','); ?></td>

			<td width="150" class="bodytext31" valign="middle"  align="right"> <?php //echo number_format($res5transactionamount,2,'.',',');?> </td>

			<td width="60" class="bodytext31" valign="middle"  align="right"> <?php echo $days_between;?> </td>

			<td width="180" class="bodytext31" valign="middle"  align="right">  <?php echo number_format($totalsum,2,'.',','); ?> </td>

			

		</tr>

				

		   <?php

		    }

           }   

		   ?>

		  

			<?php

			$resjournalcreditpayment = 0;

			$dotarray = explode("-", $paymentreceiveddateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

			

		      

		  $query69 = "select * from master_journalentries where docno='$res45billnumber'";

		  $exec69 = mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die ("Error in Query69".mysqli_error($GLOBALS["___mysqli_ston"]));

		  $num69 = mysqli_num_rows($exec69);

		  if($num69>0)

		  {

     	  

		   $journalcredit = $res45['totalfxamount'];

		  $journaldate = $res45['groupdate'];

		  $jusername = $res45['suppliername'];

		  $jdocno = $res45['billnumber'];

		 

		  

		   $t1 = strtotime("$ADate2");

		  $t2 = strtotime("$journaldate");

		  $days_between = ceil(abs($t1 - $t2) / 86400);

		  

		  $resjournalcreditpayment = $journalcredit;

		  $resjournalcreditpayment = $resjournalcreditpayment / $exchange_rate;

		

		  if($resjournalcreditpayment != 0)

		  {

		  $total = $total + $resjournalcreditpayment;

		 

		 	  

		  if($days_between <= 30)

		  {

		 

		  $totalamount30 = $totalamount30 + $resjournalcreditpayment;

		 

		  }

		  else if(($days_between >30) && ($days_between <=60))

		  {

		 

		  $totalamount60 = $totalamount60 + $resjournalcreditpayment;

		  

		  }

		  else if(($days_between >60) && ($days_between <=90))

		  {

		

		  $totalamount90 = $totalamount90 + $resjournalcreditpayment;

		 

		  }

		  else if(($days_between >90) && ($days_between <=120))

		  {

		 

		  $totalamount120 = $totalamount120 + $resjournalcreditpayment;

		  

		  }

		  else if(($days_between >120) && ($days_between <=180))

		  {

		 

		  $totalamount180 = $totalamount180 + $resjournalcreditpayment;

		  

		  }

		  else

		  {

		

		  $totalamountgreater = $totalamountgreater + $resjournalcreditpayment;

		  

		  }

		   $snocount = $snocount + 1;

			

			//echo $cashamount;

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

				$colorcode = '';

			}

	

			?>

			

		<tr >

			<td width="35" class="bodytext31" valign="middle"  align="left"><?php echo $snocount; ?></td>

			<td width="75" class="bodytext31" valign="middle"  align="left"> <?php echo $journaldate; ?> </td>

			<td width="277" class="bodytext31" valign="middle"  align="left"> <?php echo 'Journal Entry Credit'.' - '.ucfirst($jusername); ?> </td>

			<td width="100" class="bodytext31" valign="middle"  align="left"> <?php //echo number_format($res45transactionamount,2,'.',','); ?></td>

			<td width="150" class="bodytext31" valign="middle"  align="right"> <?php if($journalcredit<0){ echo number_format(abs($resjournalcreditpayment),2,'.',','); } ?></td>

			<td width="150" class="bodytext31" valign="middle"  align="right"> <?php if($journalcredit>=0){ echo number_format(abs($resjournalcreditpayment),2,'.','');}?> </td>

			<td width="60" class="bodytext31" valign="middle"  align="right"> <?php echo $days_between;?> </td>

			<td width="180" class="bodytext31" valign="middle"  align="right">  <?php echo number_format($total,2,'.',','); ?> </td>

			

		</tr>

			

				

		<?php $totalsum = $totalsum + $journalcredit;

			}

			}

			///////////////////////////SDBT
		   $resjournalcreditpaymentsdbt = 0;
$query69 = "select * from supplier_debit_transactions where approve_id='$res45billnumber'";
		  $exec69 = mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die ("Error in Query69".mysqli_error($GLOBALS["___mysqli_ston"]));
		  $num69 = mysqli_num_rows($exec69);
		  if($num69>0)
		  {
		   $sdbtdebit1 = $res45['totalfxamount'];
		  $sdbtdate = $res45['groupdate'];
		  $sdbtusername = $res45['suppliername'];
		  $sdbtdocno = $res45['billnumber'];

		  $transactionamount='0';
			 $query3 = "SELECT * from master_transactionpharmacy where  docno = '$res45billnumber' and recordstatus = 'allocated'";

				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
				// $num=mysql_num_rows($exec3);
				while ($res3 = mysqli_fetch_array($exec3))
				{  $transactionamount += $res3['transactionamount'];
				}
				 $sdbtdebit = $sdbtdebit1-$transactionamount;
 
		 	 
		  

		   $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$sdbtdate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		  $resjournalcreditpaymentsdbt = (-1)*$sdbtdebit;
		  $resjournalcreditpaymentsdbt = $resjournalcreditpaymentsdbt / $exchange_rate;
		  if($resjournalcreditpaymentsdbt != 0)
		  {
		  $total = $total + $resjournalcreditpaymentsdbt;
		  if($days_between <= 30)
		  {
		  $totalamount30 = $totalamount30 + $resjournalcreditpaymentsdbt;
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		  $totalamount60 = $totalamount60 + $resjournalcreditpaymentsdbt;
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		  $totalamount90 = $totalamount90 + $resjournalcreditpaymentsdbt;
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		  $totalamount120 = $totalamount120 + $resjournalcreditpaymentsdbt;
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		  $totalamount180 = $totalamount180 + $resjournalcreditpaymentsdbt;
		  }
		  else
		  {
		  $totalamountgreater = $totalamountgreater + $resjournalcreditpaymentsdbt;
		  }
		   $snocount = $snocount + 1;
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
			<tr >

			<td width="35" class="bodytext31" valign="middle"  align="left"><?php echo $snocount; ?></td>

			<td width="75" class="bodytext31" valign="middle"  align="left"> <?php echo $sdbtdate; ?> </td>

			<td width="277" class="bodytext31" valign="middle"  align="left"> <?php echo 'Towards Debit'.' - '.ucfirst($sdbtusername); ?> </td>

			<td width="100" class="bodytext31" valign="middle"  align="left"> <?php //echo number_format($res45transactionamount,2,'.',','); ?></td>

			<td width="150" class="bodytext31" valign="middle"  align="right"> <?php  echo number_format(($sdbtdebit),2,'.',',');  ?></td>

			<td width="150" class="bodytext31" valign="middle"  align="right">  </td>

			<td width="60" class="bodytext31" valign="middle"  align="right"> <?php echo $days_between;?> </td>

			<td width="180" class="bodytext31" valign="middle"  align="right">  <?php echo number_format($total,2,'.',','); ?> </td>

			

		</tr>

			<?php $totalsum = $totalsum + $resjournalcreditpaymentsdbt; ?>

		  <?php

		  }

		  }

		  ///////////////////////////SDBT
		  ///////////////////////////

			

			

			}

		?>

		  

		<tr>

			<td width="35" class="bodytext31" valign="middle"  align="left" bgcolor="#FFFFFF">&nbsp;</td>

			<td width="75" class="bodytext31" valign="middle"  align="left" bgcolor="#FFFFFF">&nbsp;</td>

			<td width="277" class="bodytext31" valign="middle"  align="left" bgcolor="#FFFFFF">&nbsp;</td>

			<td width="100" class="bodytext31" valign="middle"  align="left" bgcolor="#FFFFFF">&nbsp;</td>

			<td width="150" class="bodytext31" valign="middle"  align="left" bgcolor="#FFFFFF">&nbsp;</td>

			<td width="150" class="bodytext31" valign="middle"  align="left" bgcolor="#FFFFFF">&nbsp;</td>

			<td width="60" class="bodytext31" valign="middle"  align="left" bgcolor="#FFFFFF">&nbsp;</td>

			<td width="180" class="bodytext31" valign="middle"  align="left" bgcolor="#FFFFFF">&nbsp;</td>

		</tr>

		

       </table>

		

		<table cellspacing="3" cellpadding="0" align="left" border="1" style="border-collapse:collapse;" width="1200" >

		<tr>

			<td colspan="7" class="bodytext31" valign="middle"  align="left" bgcolor="#FFFFFF">&nbsp;</td>

		</tr>

			<tr>

				<td width="136" class="bodytext31" valign="middle"  align="right" 

				bgcolor="#FFFFFF"><strong>30 days</strong></td>

				<td width="136" class="bodytext31" valign="middle"  align="right" 

				bgcolor="#ffffff"><strong>60 days</strong></td>

				<td width="136" class="bodytext31" valign="middle"  align="right" 

				bgcolor="#ffffff"><strong>90 days</strong></td>

				<td width="136" class="bodytext31" valign="middle"  align="right" 

				bgcolor="#ffffff"><strong>120 days</strong></td>

				<td width="136" class="bodytext31" valign="middle"  align="right" 

				bgcolor="#ffffff"><strong>180 days</strong></td>

				<td width="136" class="bodytext31" valign="middle"  align="right" 

				bgcolor="#ffffff"><strong>180+ days</strong></td>

				<td width="220" class="bodytext31" valign="middle"  align="right" 

				bgcolor="#ffffff"><strong>Total Outstanding</strong>&nbsp;</td>

			</tr>

			<tr>

               <td width="136" class="bodytext31" valign="middle"  align="right" 

                bgcolor="#FFFFFF"><?php echo number_format($totalamount30,2,'.',','); ?></td>

              <td width="136" class="bodytext31" valign="middle"  align="right" 

                bgcolor="#FFFFFF"><?php echo number_format($totalamount60,2,'.',','); ?></td>

              <td width="136" class="bodytext31" valign="middle"  align="right" 

                bgcolor="#FFFFFF"><?php echo number_format($totalamount90,2,'.',','); ?></td>

				<td width="136" class="bodytext31" valign="middle"  align="right" 

                bgcolor="#FFFFFF"><?php echo number_format($totalamount120,2,'.',','); ?></td>

				<td width="136" class="bodytext31" valign="middle"  align="right" 

                bgcolor="#FFFFFF"><?php echo number_format($totalamount180,2,'.',','); ?></td>

            <td width="136" class="bodytext31" valign="middle"  align="right" 

                bgcolor="#FFFFFF"><?php echo number_format($totalamountgreater,2,'.',','); ?></td>

             	 <td width="220" class="bodytext31" valign="middle"  align="right" 

                bgcolor="#FFFFFF"><?php echo number_format($totalsum,2,'.',','); ?>&nbsp;</td>

				

	      </tr>		

		<tr>

			<td colspan="7" class="bodytext31" valign="middle"  align="left" bgcolor="#FFFFFF">&nbsp;</td>

		</tr>

   	   </table>



		

			  <?php



    $content = ob_get_clean();



    // convert in PDF

    try

    {

        $html2pdf = new HTML2PDF('L', 'A4', 'en');

//      $html2pdf->setModeDebug();

        $html2pdf->setDefaultFont('Arial');

        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $html2pdf->Output('print_supplieroutstanding.pdf');

    }

    catch(HTML2PDF_exception $e) {

        echo $e;

        exit;

    }

?>


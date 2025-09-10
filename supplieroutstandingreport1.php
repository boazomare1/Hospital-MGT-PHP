<?php

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



$exchange_rate=1;

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





//This include updatation takes too long to load for hunge items database.

//include ("autocompletebuild_account2.php");



if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }
//echo $searchsuppliername;

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $transactiondatefrom; }

//echo $ADate1;


if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $transactiondateto; }

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

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<script>

function funcAccount()

{

if((document.getElementById("searchsuppliername").value == "")||(document.getElementById("searchsuppliername").value == " "))

{

alert('Please Select Account Name.');

return false;

}

}

</script>



<?php //include ("autocompletebuild_supplier1.php"); ?>

<!--<script type="text/javascript" src="js/autocomplete_supplier12.js"></script>

<script type="text/javascript" src="js/autosuggest2supplier1.js"></script>-->

<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/autocomplete.css"> 

<script type="text/javascript">

/*window.onload = function () 

{

	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        

}*/



$(document).ready(function(e) {

	$('#searchsuppliername').autocomplete({

		

	source:"ajaxsupplieraccount_nm.php",

	//alert(source);

	matchContains: true,

	minLength:1,

	html: true, 

		select: function(event,ui){

			var accountname=ui.item.value;

			var accountid=ui.item.id;

			$("#searchsuppliercode").val(accountid);

			},

	});	

});



</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<style type="text/css">

<!--

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

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

    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860">

		

		

              <form name="cbform1" method="post" action="supplieroutstandingreport1.php">

		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Supplier Outstanding</strong></td>

              </tr>

            <!--<tr>

              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">

			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 

                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 

				</td>

              </tr>-->

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Supplier </td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

              <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">

              </span></td>

           </tr>

		   

			  <tr>

                      <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF"> Date From </td>

                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>

                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>

                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">

                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>

                    </tr>	

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                  <input type="submit" onClick="return funcAccount();" value="Search" name="Submit" />

                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>

            </tr>

          </tbody>

        </table>

		</form>		</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

       <tr>

        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" 

            align="left" border="0">

          <tbody>

            <tr>

              <td width="4%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td colspan="14" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311">

              <?php

				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{

					if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

					//echo $searchsuppliername;

					if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

					//echo $ADate1;

					if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

					//$cbbillstatus = $_REQUEST['cbbillstatus'];

					

					//$transactiondatefrom = $_REQUEST['ADate1'];

					//$transactiondateto = $_REQUEST['ADate2'];

					

					//$paymenttype = $_REQUEST['paymenttype'];

					//$billstatus = $_REQUEST['billstatus'];

					

					$arraysuppliername = $_REQUEST["searchsuppliername"];

					$arraysuppliername = trim($arraysuppliername);

					$arraysuppliercode = $_REQUEST["searchsuppliercode"];

					

					$urlpath = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&name=$arraysuppliername&&code=$arraysuppliercode";

				}

				else

				{

					$urlpath = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&name=$arraysuppliername&&code=$arraysuppliercode";//&&companyname=$companyname";

				}

				?>

 				<?php

				/*//For excel file creation.

				

				$applocation1 = $applocation1; //Value from db_connect.php file giving application path.

				$filename1 = "print_supplierreport.php?$urlpath";

				$fileurl = $applocation1."/".$filename1;

				$filecontent1 = @file_get_contents($fileurl);

				

				$indiatimecheck = date('d-M-Y-H-i-s');

				$foldername = "dbexcelfiles";

				$fp = fopen($foldername.'/PaymentGivenToSupplier.xls', 'w+');

				fwrite($fp, $filecontent1);

				fclose($fp);

*/

				?>

              <script language="javascript">

				function printbillreport1()

				{

					window.open("print_supplierreport.php?<?php echo $urlpath; ?>","Window1",'width=900,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

					//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');

				}

				function printbillreport2()

				{

					window.location = "dbexcelfiles/PaymentGivenToSupplier.xls"

				}

				</script>

              <!--<input  value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />

&nbsp;				<input  value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />-->

</span></td>  

            </tr>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></td>

              <td width="9%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>

              <td width="15%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>

                <td width="15%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Invoice No </strong></td>

              <td width="20%" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Debit</strong></td>

              <td width="16%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Credit</strong></div></td>

				<td width="16%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Days</strong></div></td>

				<td width="16%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Current Balance</strong></div></td>

				</tr>

			<?php
			$total_amount=0;
			/*$arraysupplier = explode("#", $searchsuppliername);  //ce

			$arraysuppliername = $arraysupplier[0];

			$arraysuppliername = trim($arraysuppliername);

			$arraysuppliercode = $arraysupplier[1];*/

		

			/* $query1 = "select * from master_supplier where suppliercode = '$arraysuppliercode'";

			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());

			$res1 = mysql_fetch_array($exec1);

			$openingbalance = $res1['openingbalance'];	*/

			$openingbalance =0;

			$query_acc = "select * from master_accountname where id = '$arraysuppliercode'";

				  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_acc) or die ("Error in query_acc".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $res1 = mysqli_fetch_array($exec1);

				  $currency = $res1['currency'];

				  $cur_qry = "select * from master_currency where currency like '$currency'";

				  $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $cur_qry) or die ("Error in cur_qry".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $res21 = mysqli_fetch_array($exec21);

				  $exchange_rate = $res21['rate'];

				  if($exchange_rate == 0.00)

				  {

					  $exchange_rate=1;

				  }

			  $query45 = "select transactionamount as totalfxamount,billnumber from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and transactiondate < '$ADate1' and transactiontype = 'PURCHASE' and billnumber NOT LIKE 'PV%' ";

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

		  

		  $query98 = "select sum(transactionamount) from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and billnumber = '$res45billnumber' and transactiondate < '$ADate1' and transactiontype= 'PAYMENT' and recordstatus <> 'deallocated' and transactionmode <> 'CREDIT' and transactionstatus='' and billnumber NOT LIKE 'PV%'";

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

			

			 $query145 = "select * from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and transactiondate < '$ADate1'  and transactiontype = 'PURCHASE' and billnumber NOT LIKE 'PV%'  order by transactiondate desc";

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

		   

		   

		    $query145on = "select * from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and transactiondate < '$ADate1' and transactionmodule = 'PAYMENT' and transactionstatus = 'onaccount' and billnumber NOT LIKE 'PV%' order by transactiondate desc";

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

		  

		  $query146on = "select * from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and docno='$res145ondocno' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and recordstatus <> 'deallocated' and transactionstatus <> 'onaccount' and billnumber NOT LIKE 'PV%'  order by transactiondate desc";

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

		  ?>

			<tr>

			<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><strong>&nbsp;</strong></td>

				

              <td width="9%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>&nbsp;</strong></div></td>

              <td width="35%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><strong> Opening Balance </strong></td>

              <td width="20%" align="right" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><strong>&nbsp;</strong></td>

                <td width="20%" align="right" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><strong>&nbsp;</strong></td>

              <td width="16%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>

			 <td width="16%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>	

				<td width="16%" align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong><?php echo number_format($openingbalance,2,'.',''); ?></strong></div></td>

				</tr>

			<?php

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

			if ($cbfrmflag1 == 'cbfrmflag1')

			{

			$query21 = "select * from master_supplier where suppliercode = '$arraysuppliercode' and status <>'DELETED' and dateposted between '$ADate1' and '$ADate2' group by suppliername order by suppliername desc ";

			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res21 = mysqli_fetch_array($exec21);

			

			$res21accountname = $res21['suppliername'];

			$supplieranum = $res21['auto_number'];

			 ?>

			 <?php 

			

			if( $res21accountname != '')

			{

			?>

			<tr bgcolor="#ffffff">

            <td colspan="15"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php echo $res21accountname;?> (Date From: <?php echo $ADate1; ?> Date To: <?php echo $ADate2;?>)</strong></td>

            </tr>

			

			<?php } ?>

			<?php

			$totalamount30 = 0;

			$totalamount60 = 0;

			$totalamount90 = 0;

			$totalamount120 = 0;

			$totalamount180 = 0;

			$totalamountgreater = 0;



		    $query45 = "SELECT transactiondate as groupdate,suppliername,suppliercode,transactionamount as totalfxamount,billnumber, auto_number from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PURCHASE' and billnumber NOT LIKE 'PV%' ";

			$query45 .= " union all select transactiondate as groupdate,suppliername,suppliercode,totalfxamount,billnumber,docno from master_transactionpharmacy where suppliercode = '$arraysuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactionmodule = 'PAYMENT' and transactionstatus = 'onaccount' and billnumber NOT LIKE 'PV%' ";

			$query45 .= " UNION ALL SELECT entrydate as groupdate,username,locationcode,sum(`openbalanceamount`) as totalfxamount, docno as billnumber,auto_number FROM `openingbalanceaccount` WHERE `accountcode` = '$arraysuppliercode' AND `entrydate` between '$ADate1' and '$ADate2'";

			$query45 .= "union all select entrydate as groupdate,username,locationcode,sum(creditamount-debitamount) as totalfxamount,docno,auto_number from master_journalentries where ledgerid = '$arraysuppliercode' and entrydate between '$ADate1' and '$ADate2' group by docno ";
			// order by groupdate asc 

			$query45 .= " UNION ALL SELECT date(created_at) as groupdate,user_id as username,'' as locationcode,(total_amount) as totalfxamount,approve_id as docno,auto_number from supplier_debit_transactions where supplier_id = '$arraysuppliercode'  and date(created_at) between '$ADate1' and '$ADate2' order by groupdate ASC";

			 // echo $query45;

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

				$colorcode = 'bgcolor="#ecf0f5"';

			}

	        

			?>

			<?php 

			

			?>	   

           <tr <?php  echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res45transactiondate; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo 'Towards Purchase'; ?> (<?php echo $res45billnumber; ?>)</div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <?php echo $res85supplierbillnumber; ?></td>

              <td class="bodytext31" valign="center"  align="right">

			  <?php //echo number_format($res45transactionamount,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php echo number_format($totalout,2,'.',',');?></div></td>

				<td class="bodytext31" valign="center"  align="right">

				<?php $totalsum = $totalsum + $totalout; ?>

			    <div align="center"><?php echo $days_between;?></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalsum,2,'.',','); ?></div></td>

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

           <tr <?php  echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res145transactiondate; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo 'Towards Opening Debit ('.$res113rbillnumber.','.$res145billnumber; ?>)</div></td>

                <td class="bodytext31" valign="center"  align="right">

			    <div align="left">Opening Balance</div></td>

              <td class="bodytext31" valign="center"  align="right">

			  <?php echo number_format($res112subtotal,2,'.',','); ?></td>

             

                <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php //echo number_format($res5transactionamount,2,'.',',');?></div></td>

				<td class="bodytext31" valign="center"  align="right">

			    <div align="center"><?php echo $days_between;?></div></td>

				

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalsum,2,'.',','); ?></div></td>

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

				$colorcode = 'bgcolor="#ecf0f5"';

			}

	    

			?>

			<?php if($res112subtotal != 0)

			 { 

			  ?>

           <tr <?php  echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res145transactiondate; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo 'Towards Return ('.$res113rbillnumber.','.$res145billnumber; ?>)</div></td>

              <td class="bodytext31" valign="center"  align="right">

			  <?php echo number_format($res112subtotal,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php //echo number_format($res5transactionamount,2,'.',',');?></div></td>

                <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php //echo number_format($res5transactionamount,2,'.',',');?></div></td>

				<td class="bodytext31" valign="center"  align="right">

			    <div align="center"><?php echo $days_between;?></div></td>

				

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalsum,2,'.',','); ?></div></td>

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

				$colorcode = 'bgcolor="#ecf0f5"';

			}

	    

			?>

			<?php if($res146ontransactionamount != 0)

			 { 

			  ?>

           <tr <?php  echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $res145transactiondate; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo 'Onaccount ('.$res145ondocno; ?>)</div></td>

              <td class="bodytext31" valign="center"  align="right">

			  <?php echo number_format($res146ontransactionamount,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php //echo number_format($res5transactionamount,2,'.',',');?></div></td>

                <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php //echo number_format($res5transactionamount,2,'.',',');?></div></td>

				<td class="bodytext31" valign="center"  align="right">

			    <div align="center"><?php echo $days_between;?></div></td>

				

                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalsum,2,'.',','); ?></div></td>

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

				$colorcode = 'bgcolor="#ecf0f5"';

			}

	

			?>

           <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $journaldate; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo 'Journal Entry Credit ('.$jdocno.')'.' - '.ucfirst($jusername); ?></div></td>

                <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php //echo number_format($res5transactionamount,2,'.',',');?></div></td>

             <td class="bodytext31" valign="center"  align="right">

			  <?php if($journalcredit<0){ echo number_format(abs($resjournalcreditpayment),2,'.',','); } ?></td>

              <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php if($journalcredit>=0){ echo number_format(abs($resjournalcreditpayment),2,'.',',');}?></div></td>

				<td class="bodytext31" valign="center"  align="right">

			    <div align="center"><?php echo $days_between;?></div></td>

               <td class="bodytext31" valign="center"  align="left">

			    <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>

           </tr>

			<?php $totalsum = $totalsum + $journalcredit; ?>

		  <?php

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

           <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>

               <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo $sdbtdate; ?></div></td>


              <td class="bodytext31" valign="center"  align="left">

                <div class="bodytext31"><?php echo 'Towards Debit ('.$sdbtdocno.') '.' - '.ucfirst($sdbtusername); ?></div></td>

                <td class="bodytext31" valign="center"  align="right">

			    <div align="right"><?php //echo number_format($res5transactionamount,2,'.',',');?></div></td>

             <td class="bodytext31" valign="center"  align="right">

			  <?php   echo number_format(($sdbtdebit),2,'.',',');   ?></td>

              <td class="bodytext31" valign="center"  align="right">

			    <div align="right"> </div></td>

				<td class="bodytext31" valign="center"  align="right">

			    <div align="center"><?php echo $days_between;?></div></td>

               <td class="bodytext31" valign="center"  align="left">

			    <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>

           </tr>

			<?php $totalsum = $totalsum + $resjournalcreditpaymentsdbt; ?>

		  <?php

		  }

		  }

		  ///////////////////////////SDBT
		  ///////////////////////////

		  

		  

		  }		  ?>

		

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				 <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

			    </tr>

				 </tbody>

        </table></td>

      </tr>

	  

   

			<tr>

        <td>&nbsp;</td>

      </tr>

		

			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 

            align="left" border="0">

			<tr>

              <td width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td  width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				<td  width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

					<td  width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

            

				<td  width="160" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

            

            	 </tr>

						<tr>

               <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>30 days</strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>60 days</strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>90 days</strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>120 days</strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>180 days</strong></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>180+ days</strong></td>

           	 <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>Total Outstanding</strong></td>

            </tr>

			<?php 

			//$grandtotal = $totalamount30 + $totalamount60 + $totalamount90 + $totalamount120 + $totalamount180 + $totalamountgreater;

			?>

			<tr>

               <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($totalamount30,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($totalamount60,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($totalamount90,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($totalamount120,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($totalamount180,2,'.',','); ?></td>

            <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($totalamountgreater,2,'.',','); ?></td>

             	 <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($totalsum,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="right">&nbsp;</td>

			<?php if($totalsum != 0.00) { ?>	

                <td class="bodytext31" valign="center"  align="right"> 

                  <a target="_blank" href="print_supplieroutstanding.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&name=<?php echo $arraysuppliername; ?>&&code=<?php echo $arraysuppliercode; ?>"> <img src="images/excel-xls-icon.png" width="30" height="30"></a>

             </td>

			 <td class="bodytext31" valign="center"  align="right"> 

                  <a target="_blank" href="print_supplieroutstandingpdf.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&name=<?php echo $arraysuppliername; ?>&&code=<?php echo $arraysuppliercode; ?>"> <img src="images/pdfdownload.jpg" width="30" height="30"></a>

             </td>

			 

			 <?php } ?>

			</tr>

			

		    <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

					<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

           

		   	<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

           

               </tr>

			  </table>

			<?php

			}

			

			//}

			?>

</table>





</table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>


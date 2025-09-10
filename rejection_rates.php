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

$total_inv = 0;
$total_rej_amt = 0;
$total_rej_rate = 0;
$total_disc_amt = 0;
$total_disc_rate = 0;



$snocount = "";

$colorloopcount="";

$range = "";

$admissiondate = "";

$ipnumber = "";

$patientname = "";

$gender = "";

$admissiondoc = "";

$consultingdoc = "";

$companyname = "";

$bedno = "";

$dischargedate = "";

$wardcode = "";

$locationcode = "";



//This include updatation takes too long to load for hunge items database.

//include ("autocompletebuild_customer2.php");

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }

if (isset($_REQUEST["searchsupplieranum"])) { $searchsupplieranum = $_REQUEST["searchsupplieranum"]; } else { $searchsupplieranum = ""; }


if (isset($_REQUEST["wardcode1"])) { $wardcode = $_REQUEST["wardcode1"]; } else { $wardcode = ""; }

if (isset($_REQUEST["view_status"])) { $view_status = $_REQUEST["view_status"]; } else { $view_status = ""; }


if (isset($_REQUEST["locationcode"])) { $locationcode1 = $_REQUEST["locationcode"]; } else { $locationcode1 = ""; }

//echo $searchsuppliername;

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; $paymentreceiveddatefrom = $ADate1; } else { $ADate1 = ""; }

//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; $paymentreceiveddateto = $ADate2; } else { $ADate2 = ""; }

//echo $ADate2;

if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }

//echo $range;

if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }

//echo $amount;

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

//$frmflag2 = $_POST['frmflag2'];

/*function get_initial($fromdate,$todate,$accountid)
{
	
			
			$query31 = "select sum(b.transactionamount) as invoice_amount, from master_transactionpaylater a JOIN master_transactionpaylater b ON b.billnumber = a.billnumber  WHERE  b.docno LIKE 'AR-%' and a.transactiontype = 'PAYMENT' and a.paylaterdocno='' and a.docno!='' and a.recordstatus='allocated' and b.docno='' and b.transactiontype='finalize' and a.bill_date between '$fromdate' and '$todate'";
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res31 = mysqli_fetch_array($exec31);
			$collection = $res31['collection'];
		    $inv_amount += $collection;

}*/



?>

<style type="text/css">
.bodytext31:hover { font-size:14px; }

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

<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/autocomplete.css">      

<script>

$(document).ready(function(e) {

   

		$('#searchsuppliername').autocomplete({

		

	source:"ajaxaccount_search_new.php",

	//alert(source);

	matchContains: true,

	minLength:1,

	html: true, 

		select: function(event,ui){
			var accountname=ui.item.value;
			var accountid=ui.item.id;
			var accountanum=ui.item.anum;
			$("#searchsuppliercode").val(accountid);
			$("#searchsupplieranum").val(accountanum);
			$('#searchsuppliername').val(accountname);
	
			},

    

	});

		

});
</script>



<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<script src="js/datetimepicker_css.js"></script>



<!--<script type="text/javascript" src="js/autocomplete_customer2.js"></script>

<script type="text/javascript" src="js/autosuggestcustomer.js"></script>-->

<script type="text/javascript">

window.onload = function () 

{

	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        

}

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

		

		

              <form name="cbform1" method="post" action="rejection_rates.php">

		<table width="634" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Debtors Report</strong></td>

             </tr>

             <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>

              <td width="82%" colspan="2" align="left" valign="top"  bgcolor="#FFFFFF">

              <select name="locationcode" id="$locationcode">
			  <option value="All">All</option>

                <?php

                  $query20 = "select * FROM master_location";

                  $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20". mysqli_error($GLOBALS["___mysqli_ston"]));

                  while ($res20 = mysqli_fetch_array($exec20)){
				?>
                    <option value="<?php echo $res20['locationcode'];?>" <?php if($locationcode1==$res20['locationcode']){ echo  'selected'; } ?>><?php echo $res20['locationname'];?> </option>;
				<?php
                  }

                ?>

                </select></td>
                
            
                <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
                <select name="view_status" id="view_status">
                <option <?php if($view_status == 'Summary') { ?> selected = 'selected' <?php } ?> value="Summary">Summary</option>
                <option <?php if($view_status == 'Detailed') { ?> selected = 'selected' <?php } ?> value="Detailed">Detailed</option>
                </select>
                </td>

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

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Account </td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">

				<input type="hidden" name="searchsuppliercode" id="searchsuppliercode" value="<?php echo $searchsuppliercode; ?>" size="20" />

				<input type="hidden" name="searchsupplieranum" id="searchsupplieranum" value="<?php echo $searchsupplieranum; ?>" size="20" />

              </span></td>

              </tr>

                  <tr>

	              <td align="left" valign="top"  bgcolor="#FFFFFF"></td>

	              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

				            <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

	                  <input type="submit" value="Search" name="Submit" />

	                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>

            	</tr>

          </tbody>

        </table>

		</form>		</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

       <tr>

        <?php

        if(isset($_POST['Submit'])){
 if($view_status=='Summary') {
	  ?>

        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="2" width="1000" 
align="left" border="0">

          <tbody>

        <tr>

          <td class="bodytext31" valign="center"  align="left" colspan="2"> 


           <a href="print_rejection_ratesxls.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&locationcode1=<?php echo $locationcode1; ?>&&source=<?php echo $view_status; ?>&&searchsuppliercode=<?php echo $searchsuppliercode; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a>

          </td>

        </tr>

<tr>

<td width="5%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>SNO.</strong></div></td>
<td width="25%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>ACCOUNTNAME</strong></div></td>
<td width="20%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Invoice Amt</strong></div></td>
<td width="10%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Rej Amt</strong></div></td>
<td width="10%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Rej Rate</strong></div></td>
<td width="10%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Disc Amt</strong></div></td>
<td width="10%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Disc. Rate</strong></div></td>
</tr>

          

        <?php

            $revenue = $totalrevenue = 0.00;
            $oprevenue = $optotalrevenue = 0.00;
            $doc_share_amount = $total_doc_share_amount = 0.00;

            $acountname = '';
			
				if($locationcode1=='All')
				{
				$pass_location = "locationcode !=''";
				}
				else
				{
				$pass_location = "locationcode ='$locationcode1'";
				}

				if($searchsuppliercode!='')
				{
				$query1 = "SELECT id,accountname  from master_accountname where id='$searchsuppliercode'";
				}
				else
				{
				
				$query1 = "SELECT id,accountname  from master_accountname where id!='02-4500-1'";
				}

               $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

               while($res1 = mysqli_fetch_array($exec1)){

                  $id = $res1['id'];
				  $accountname = $res1['accountname'];
					$rejection_amount=0.00;
					$discount_amount=0.00;
					$initial_amount=0.00;
					$rej_rate=0.00;
					$disc_rate=0.00;
				
			   $query3 = "select sum(a.decline) as rejection_amount,sum(a.discount) as discount_amount,sum(b.transactionamount) as initial_amount from master_transactionpaylater as a JOIN master_transactionpaylater as b on (a.billnumber=b.billnumber)  where  a.bill_date between '$ADate1' and '$ADate2' and a.transactiontype = 'PAYMENT' and a.paylaterdocno='' and a.docno!='' and a.recordstatus='allocated' and a.accountcode='$id' and a.$pass_location and b.docno='' and b.accountcode='$id' group by a.accountcode ";
                $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res3 = mysqli_fetch_array($exec3);
				$rejection_amount = $res3['rejection_amount'];
				$discount_amount = $res3['discount_amount'];
				$initial_amount = $res3['initial_amount'];
				if($rejection_amount=='')
				{
					$rejection_amount=0.00;
				}
				if($discount_amount=='')
				{
					$discount_amount=0.00;
				}
				if($rejection_amount>0)
				{
					$rej_rate = ($rejection_amount / $initial_amount) * 100;
				}
				if($discount_amount>0)
				{
					$disc_rate = ($discount_amount / $initial_amount) * 100;
				}
				
				if($initial_amount>0)
				{
					$total_inv += $initial_amount;
					$total_rej_amt += $rejection_amount;
					$total_rej_rate += $rej_rate;
					$total_disc_amt += $discount_amount;
					$total_disc_rate += $disc_rate;
		
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

                  <td class="bodytext31" valign="center"  align="center"><?php echo $snocount; ?></td>

                  <td class="bodytext31" valign="center"  align="left"><?php echo $accountname; ?></td>
             
                  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($initial_amount,2); ?></td>
                  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($rejection_amount,2); ?></td>
                  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($rej_rate,2).'%'; ?></td>
                  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($discount_amount,2); ?></td>
                  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($disc_rate,2).'%'; ?></td>

              </tr>

            <?php } }?>

          <tr>


            <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5" colspan="2"><strong>TOTAL REVENUE</strong></td>
            <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($total_inv,2); ?></strong></td>
            <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($total_rej_amt,2); ?></strong></td>
            <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($total_rej_rate,2); ?></strong></td>
            <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($total_disc_amt,2); ?></strong></td>
            <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($total_disc_rate,2); ?></strong></td>
          </tbody>

        </table></td>

      <?php } else {  

	  ?>


        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="2" width="1100" 
align="left" border="0">

          <tbody>

        <tr>

          <td class="bodytext31" valign="center"  align="left" colspan="2"> 

        
           <a href="print_rejection_ratesxls.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&locationcode1=<?php echo $locationcode1; ?>&&source=<?php echo $view_status; ?>&&searchsuppliercode=<?php echo $searchsuppliercode; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a>

          </td>

        </tr>

<tr>

<td width="5%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>SNO.</strong></div></td>
<td width="10%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>ACCOUNTNAME</strong></div></td>
<td width="25%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></td>
<td width="10%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Bill No</strong></div></td>
<td width="10%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Invoice Amt</strong></div></td>
<td width="10%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Rej Amt</strong></div></td>
<td width="10%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Rej Rate</strong></div></td>
<td width="10%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Disc Amt</strong></div></td>
<td width="10%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Disc. Rate</strong></div></td>
</tr>

          

        <?php

            $revenue = $totalrevenue = 0.00;
            $oprevenue = $optotalrevenue = 0.00;
            $doc_share_amount = $total_doc_share_amount = 0.00;

            $acountname = '';
			
				if($locationcode1=='All')
				{
				$pass_location = "locationcode !=''";
				}
				else
				{
				$pass_location = "locationcode ='$locationcode1'";
				}


               if($searchsuppliercode!='')
				{
				$query1 = "SELECT id,accountname  from master_accountname where id='$searchsuppliercode'";
				}
				else
				{
				
				$query1 = "SELECT id,accountname  from master_accountname where id!='02-4500-1'";
				}

               $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

               while($res1 = mysqli_fetch_array($exec1)){

                  $id = $res1['id'];
				  $accountname = $res1['accountname'];
				  $rejection_amount=0.00;
				  $discount_amount=0.00;
				  $initial_amount=0.00;
				  $rej_rate=0.00;
				  $disc_rate=0.00;
				
			   $query3 = "select (a.decline) as rejection_amount,(a.discount) as discount_amount,(b.transactionamount) as initial_amount,a.patientname,a.billnumber from master_transactionpaylater as a JOIN master_transactionpaylater as b on (a.billnumber=b.billnumber)  where  a.bill_date between '$ADate1' and '$ADate2' and a.transactiontype = 'PAYMENT' and a.paylaterdocno='' and a.docno!='' and a.recordstatus='allocated' and a.accountcode='$id' and a.$pass_location and b.docno='' and b.accountcode='$id'  ";
                $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($res3 = mysqli_fetch_array($exec3)){
				$rejection_amount=0.00;
				$discount_amount=0.00;
				$initial_amount=0.00;
				$rej_rate=0.00;
				$disc_rate=0.00;
				$rejection_amount = $res3['rejection_amount'];
				$discount_amount = $res3['discount_amount'];
				$patientname = $res3['patientname'];
				$billnumber = $res3['billnumber'];
				if($rejection_amount=='')
				{
					$rejection_amount=0.00;
				}
				if($discount_amount=='')
				{
					$discount_amount=0.00;
				}
				$initial_amount = $res3['initial_amount'];
				if($rejection_amount>0)
				{
					$rej_rate = ($rejection_amount / $initial_amount) * 100;
				}
				if($discount_amount>0)
				{
				$disc_rate = ($discount_amount / $initial_amount) * 100;
				}
				
				if($initial_amount>0)
				{
					$total_inv += $initial_amount;
					$total_rej_amt += $rejection_amount;
					$total_rej_rate += $rej_rate;
					$total_disc_amt += $discount_amount;
					$total_disc_rate += $disc_rate;
		
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

                  <td class="bodytext31" valign="center"  align="center"><?php echo $snocount; ?></td>

                  <td class="bodytext31" valign="center"  align="left"><?php echo $accountname; ?></td>
                  
                  <td class="bodytext31" valign="center"  align="left"><?php echo $patientname; ?></td>

                  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>
             
                  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($initial_amount,2); ?></td>
                  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($rejection_amount,2); ?></td>
                  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($rej_rate,2).'%'; ?></td>
                  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($discount_amount,2); ?></td>
                  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($disc_rate,2).'%'; ?></td>

              </tr>

            <?php } } }?>

          <tr>


            <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5" colspan="4"><strong>TOTAL REVENUE</strong></td>
            <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($total_inv,2); ?></strong></td>
            <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($total_rej_amt,2); ?></strong></td>
            <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($total_rej_rate,2); ?></strong></td>
            <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($total_disc_amt,2); ?></strong></td>
            <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($total_disc_rate,2); ?></strong></td>
          </tbody>

        </table></td>

      <?php 
        
      }  }?>

      </tr>

	  

    </table>

</table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>


<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d');
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
$curdt = date('Y-m-d H:i:s');
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
$totalamount30 = 0;
$totalamount60 = 0;
$totalamount90 = 0;
$totalamount120 = 0;
$totalamount180 = 0;
$totalamountgreater = 0;
$totalamount1 = 0;
include ("autocompletebuild_supplier1.php");
if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

if (isset($_REQUEST["entrydoc"])) { $entrydoc = $_REQUEST["entrydoc"]; } else { $entrydoc = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
?>
<style type="text/css">
th {
            background-color: #ffffff;
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
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script>
function funcAccount()
{
}
</script>
<script type="text/javascript" src="js/autocomplete_supplier12.js"></script>
<script type="text/javascript" src="js/autosuggest2supplier1.js"></script>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
}

$(document).ready(function(){
	$( ".edititem" ).click(function() {
		var clickedid = $(this).attr('id');		
		//alert(clickedid);
		var current_expdate = $('tr#'+clickedid).find("div.txnno").text();		
		var current_txnno = $('tr#'+clickedid).find("div.mptxnno").text();
		$('tr#'+clickedid).find("td.txnno1").show();		
		$('tr#'+clickedid).find("td.mptxnno1").show();
		$('tr#'+clickedid).find("td.itemrateupdate").hide();	
		$('#txnno_'+clickedid).val(current_expdate);
		$('#mptxnno_'+clickedid).val(current_txnno);
		$('#s_'+clickedid).show();
		$('#s1_'+clickedid).show();
		$('#e_'+clickedid).hide();
		return false;
	})	
	
	
	$( ".saveitem" ).click(function() {
		var clickedid = $(this).attr('id');
		var idstr = clickedid.split('s_');
		var id = idstr[1];
		var cdtxn_no= $('#txnno_'+id).val();
		var userby= $('#userby_'+id).val();
		var useron= $('#useron_'+id).val();
		//alert(cdtxn_no);
		var mptxn_no= $('#mptxnno_'+id).val();
		var bankcode=mptxn_no.split('||')[0];
        var bankname=mptxn_no.split('||')[1];
		//alert(mptxn_no);
		var autono=  $('#autono_'+id).val();
		var tablename=  $('#tablename_'+id).val();
		
		$.ajax({
		  url: 'ajax/ajaxupdatepaymentvoucherbank.php',
		  type: 'POST',
		  //async: false,
		  dataType: 'json',
		  //processData: false,    
		  data: { 
		      userby: userby, 
		      useron: useron, 
		      cdtxn_no: cdtxn_no, 
		      mptxn_no: mptxn_no,
			  autono: autono, 
			  tablename: tablename,
			  bankname: bankname,
		      
		  },
		  success: function (data) { 
		  	//alert(data)
		  	var msg = data.msg;
		  	if(data.status == 1)
		  	{
			//alert(id);
		  		$('tr#'+id).find("td.mptxnno1").hide();
				$('tr#'+id).find("td.txnno1").hide();
				$('tr#'+id).find("td.itemrateupdate").show();
				$('#caredittxno_'+id).text(bankname);
				$('#caredittxno1_'+id).text(mptxn_no);
				$('#usname_'+id).text(userby);
				$('#uson_'+id).text(useron);
				$('#s_'+id).hide();
				$('#s1_'+id).hide();
				$('#e_'+id).show();
		  	}
		  	else
		  	{
		  		alert(msg);
		  	}
		  }
		});
		return false;
	})	
	

})

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
    <td width="">&nbsp;</td>
    <td width="" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="">
		
		
              <form name="cbform1" method="post" action="paymentapprovereport.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong> Supplier Payment Approve Report</strong></td>
              </tr>
           <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Supplier </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
              </span></td>
           </tr>
		   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Entry Docno </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="entrydoc" type="text" id="entrydoc" value="<?php echo $entrydoc; ?>" size="10" autocomplete="off">
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
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="100%" 
            align="left" border="0">
          <tbody>
           <!-- <tr>
			  <td colspan="7" bgcolor="#FFF" class="bodytext31"><strong>Payment Voucher</strong></td>  
              <td width="14%" bgcolor="#FFF" class="bodytext31">&nbsp;</td>
            </tr>-->
			<?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					$arraysuppliercode = '';
					$arraysuppliername = '';
					if($searchsuppliername != "")
					{
					$arraysupplier = explode("#", $searchsuppliername);
					$arraysuppliername = $arraysupplier[0];
					$arraysuppliername = trim($arraysuppliername);
					$arraysuppliercode = $arraysupplier[1];
					}				
			     }
				?>
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			if($entrydoc==''){
		   	?>
            <tr>
              <th width=""  align="left" valign="center" 
                bgcolor="#ccc" class="bodytext31"><strong>No.</strong></th>
              <th width="" align="left" valign="center"  
                bgcolor="#ccc" class="bodytext31"><div align="left"><strong>Date</strong></div></th>
				<th width=" align="left" valign="center"  
                bgcolor="#ccc" class="bodytext31"><strong>Doc No </strong></th>
				<th width=" align="left" valign="center"  
                bgcolor="#ccc" class="bodytext31"><strong>Print</strong></th>
              <th width="" align="left" valign="center"  
                bgcolor="#ccc" class="bodytext31"><strong> Suppliername </strong></th>
              <th width="" align="left" valign="center"  
                bgcolor="#ccc" class="bodytext31"><strong>Cheque No</strong></th>
				<th width="" align="left" valign="center"  
                bgcolor="#ccc" class="bodytext31"><strong>Bank Name</strong></th>
              <th width="" align="right" valign="center"  
                bgcolor="#ccc" class="bodytext31"><strong>Amount</strong></th>
				 <th width="" align="center" valign="center"  
                bgcolor="#ccc" class="bodytext31"><strong>Remarks</strong></th>
              </tr>
			<?php
			
			 $query1 = "select * from master_supplier where suppliercode = '$arraysuppliercode'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$openingbalance = $res1['openingbalance'];	
			
			$totalamount = 0;
			$query5 = "select suppliercode, suppliername from master_transactionpharmacy where approved_payment = '1' and paymentvoucherno <> '' AND suppliername LIKE '%$arraysuppliername%' group by suppliercode";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num=mysqli_num_rows($exec5);
			while ($res5 = mysqli_fetch_array($exec5))
			{
			$suppliercode1 = $res5['suppliercode'];
			$suppliername1 = $res5['suppliername'];
			$totalamount = 0;
			
		    $query3 = "select paymentvoucherno, sum(approved_amount) as transactionamount, appvdcheque, suppliercode, suppliername, transactiondate, chequenumber, remarks, appvdbank, billnumber from master_transactionpharmacy where approved_payment = '1' and paymentvoucherno <> '' AND suppliercode = '$suppliercode1' and transactiondate between '$ADate1' and '$ADate2' group by paymentvoucherno";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num1=mysqli_num_rows($exec3);
			if($num1>0){
			?>
			<tr>
			<td colspan="9" bgcolor="#FFF" class="bodytext31" valign="center"  align="left"><strong><?php echo $suppliername1; ?></strong></td>
			</tr>
		    <?php
			while ($res3 = mysqli_fetch_array($exec3))
			{
				//echo $res3['auto_number'];
				$docno = $res3['paymentvoucherno'];
				$transactionamount = $res3['transactionamount'];
				$suppliercode = $res3['suppliercode'];
				$suppliername = $res3['suppliername'];
				$transactiondate = $res3['transactiondate'];
				$chequenumber = $res3['appvdcheque'];
				$remarks = $res3['remarks'];
				$bank = $res3['appvdbank'];
				$billnumber = $res3['billnumber'];
				$totalamount = $totalamount + $transactionamount;
				$totalamount1 = $totalamount1 + $transactionamount;
				
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
			
           <tr <?php  echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
                	<?php echo $docno; ?>
                	
                 </div>
             </td>
              <td class="bodytext31" valign="center"  align="center"><a href="print_payment1.php?billnumber=<?php echo $billnumber; ?>&&suppliercode=<?php echo $suppliercode; ?>&&voucherno=<?php echo $docno; ?>" target="_blank">Print</a></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $suppliername; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $chequenumber; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $bank; ?></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($transactionamount,2,'.',',');?></div></td>
				<td class="bodytext31" valign="center"  align="center"><?php echo $remarks; ?></td>
               </tr>
		   <?php
		   }  
		   ?>
		   <tr>
		    <td colspan="7" class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong>Sub Total :</strong></td>
			<td bgcolor="#CCC" class="bodytext31" valign="center"  align="right"><strong><?php echo number_format($totalamount,2); ?></strong></td>
			 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			</tr>
		   <?php
			}
		   }
			
		   ?>
			<tr>
		    <td colspan="7" class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong> Total :</strong></td>
			<td bgcolor="#CCC" class="bodytext31" valign="center"  align="right"><strong><?php echo number_format($totalamount1,2); ?></strong></td>
			 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			</tr>
			<?php } ?>
			<tr>
		    <td colspan="7" class="bodytext31" valign="center"  align="right"><strong> &nbsp;</strong></td>
			</tr>
		
		   <tr>
		   <td colspan="12" bgcolor="#FFF" class="bodytext31" valign="center"  align="left"><strong> Posted Payment Vouchers</strong></td>
			</tr>
			<tr>
              <th width=""  align="left" valign="center" 
                bgcolor="#ccc" class="bodytext31"><strong>No.</strong></th>
              <th width="" align="left" valign="center"  
                bgcolor="#ccc" class="bodytext31"><div align="left"><strong>Date</strong></div></th>
				<th width="" align="left" valign="center"  
                bgcolor="#ccc" class="bodytext31"><strong>Doc No </strong></th>
				<th width="" align="left" valign="center"  
                bgcolor="#ccc" class="bodytext31"><strong>Entry Doc No </strong></th>
              <th width="" align="left" valign="center"  
                bgcolor="#ccc" class="bodytext31"><strong> Suppliername </strong></th>
              <th width="" align="left" valign="center"  
                bgcolor="#ccc" class="bodytext31"><strong>Cheque No</strong></th>
				<th width="" align="left" valign="center"  
                bgcolor="#ccc" class="bodytext31"><strong>Bank Name</strong></th>
              <th width="" align="right" valign="center"  
                bgcolor="#ccc" class="bodytext31"><strong>Amount</strong></th>
				 <th width="" align="center" valign="center"  
                bgcolor="#ccc" class="bodytext31"><strong>Remarks</strong></th>
				<th width="" align="left" valign="left"  
                bgcolor="#ccc" class="bodytext31"><strong>Edited By</strong></th>
				<th width="" align="left" valign="center"  
                bgcolor="#ccc" class="bodytext31"><strong>Edited On</strong></th>
				<th width="" align="center" valign="center"  
                bgcolor="#ccc" class="bodytext31"><strong>Action</strong></th>
              </tr>
		
			<?php
			$colorloopcount=0;
			$totalamount=0;
			$totalamount1=0;
			if($entrydoc!=''){
			$doc="and docno='$entrydoc'";
			}else{
			$doc="and docno like '%%'";	
			}
		    $query3 = "select paymentvoucherno, sum(transactionamount) as transactionamount, appvdcheque, suppliercode, suppliername, transactiondate, chequenumber, remarks, bankname,docno,bank_editedby,bank_editedon from master_transactionpharmacy where recordstatus = 'allocated' and approvalstatus='APPROVED' and paymentvoucherno <> '' AND suppliername LIKE '%$arraysuppliername%' and transactiondate between '$ADate1' and '$ADate2' $doc group by paymentvoucherno";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num=mysqli_num_rows($exec3);
			while ($res3 = mysqli_fetch_array($exec3))
			{
				//echo $res3['auto_number'];
				$docno = $res3['paymentvoucherno'];
				$transactionamount = $res3['transactionamount'];
				$suppliercode = $res3['suppliercode'];
				$suppliername = $res3['suppliername'];
				$transactiondate = $res3['transactiondate'];
				$chequenumber = $res3['appvdcheque'];
				$remarks = $res3['remarks'];
				$bank = $res3['bankname'];
				$paymentdocno = $res3['docno'];
				$bank_editedby = $res3['bank_editedby'];
				$bank_editedon = $res3['bank_editedon'];
			
				$query66 = "select * from master_purchase where paymentvoucherno = '$docno'";
				$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));	
				$rows66 = mysqli_num_rows($exec66);
				//if($rows66 > 0)
				//{
				$totalamount = $totalamount + $transactionamount;
				$totalamount1 = $totalamount1 + $transactionamount;
				
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
			
			<tr <?php  echo $colorcode; ?> id="<?php echo $colorloopcount;?>">
				<td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $transactiondate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $docno; ?> </div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $paymentdocno; ?> </div></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $suppliername; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $chequenumber; ?></td>
				
				<td align="left" valign="top"  class="bodytext3 itemrateupdate"><div class="mptxnno" id="caredittxno_<?php echo $colorloopcount;?>"><?php echo $bank; ?> </td>
				<td  style="display:none;" class="txnno1" width="123" align="left" valign="center"   class="bodytext31">
				<div bgcolor="#ffffff">
				<select class="mptxnno1" name="mptxnno[]" id="mptxnno_<?php  echo $colorloopcount;?>">
				<option value="">Select Account</option>
				<?php 
				$querybankname = "select accountname, id from master_accountname where accountsmain = '2' and accountssub IN ('7') and recordstatus <> 'deleted'";
				$execbankname = mysqli_query($GLOBALS["___mysqli_ston"], $querybankname) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($resbankname = mysqli_fetch_array($execbankname))
				{?>
					<option value="<?php echo $resbankname['id'].'||'.$resbankname['accountname']; ?>"><?php echo $resbankname['accountname']; ?></option>
				<?php
				}
				?>
				</select>
				<input type="hidden" id="tablename_<?php echo $colorloopcount;?>" name="tablename_<?php echo $colorloopcount;?>" value="<?php echo 'paymententry_details';?>"/>
				<input type="hidden" name="autono[]" id="autono_<?php echo $colorloopcount;?>" value="<?php echo $paymentdocno ?>" />
				<input type="hidden" name="userby[]" id="userby_<?php echo $colorloopcount;?>" value="<?php echo $username ?>" />
				<input type="hidden" name="useron[]" id="useron_<?php echo $colorloopcount;?>" value="<?php echo $curdt ?>" />
				</div>
				</td>
				<td class="bodytext31" valign="center"  align="right"><div align="right"><?php echo number_format($transactionamount,2,'.',',');?></div></td>
				<td class="bodytext31" valign="center"  align="center"><?php echo $remarks; ?></td>
				<td class="bodytext31" valign="center"  align="left"><div class="mptxnno" id="usname_<?php echo $colorloopcount;?>"><?php echo $bank_editedby; ?> </td>
				<td class="bodytext31" valign="center"  align="left"><div class="mptxnno" id="uson_<?php echo $colorloopcount;?>"><?php echo $bank_editedon; ?> </td>
				<td align="center" valign="center" id="e_<?php echo $colorloopcount; ?>"  class="bodytext31 itemrateupdate"><div class="bodytext31"><div align="center" ><a class="edititem" id="<?php echo $colorloopcount; ?>" href="" style="padding-right: 10px;"><strong>Edit Bank</strong></a> </div>   </div></td>
				<td align="center" style="display:none;" id="s1_<?php echo $colorloopcount; ?>" valign="center"   class="bodytext31"><div class="bodytext31"> <div align="center">
				<a  class="saveitem" id="s_<?php echo $colorloopcount; ?>" href="" ><strong>Update</strong></a>
				</div>  </div></td>
				
			</tr>
		   <?php
		  // } 
		   } 
		   ?>	
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
			<?php
			}
			?>
</table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
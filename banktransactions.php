<?php
session_start();
error_reporting(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$timeonly = date('H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = '';
$transactiondateto = date('Y-m-d');
$errmsg = "";
$bgcolorcode = "";
if (isset($_REQUEST["frmflg1"])) { $frmflg1 = $_REQUEST["frmflg1"]; } else { $frmflg1 = ""; }
if($frmflg1 == 'frmflg1')
{
	$aprows = $_REQUEST['apnums'];
	$arrows = $_REQUEST['arnums'];
	$sprows = $_REQUEST['spnums'];
	$exrows = $_REQUEST['exnums'];
	$rerows = $_REQUEST['renums'];
	$bkrows = $_REQUEST['bknums'];
	$apjrows = $_REQUEST['apjnums'];
	//accounts receivable
	if($aprows !=0)
	{ 
		for($i=1;$i<=$aprows;$i++)
		{
			//$apstatus = $_REQUEST['apstatus'.$i];
			$apdate = $_REQUEST['apdate'.$i];
			//if($apstatus != 'Pending')
			if($apdate != '')
			{
				$apaccountname = $_REQUEST['apaccountname'.$i];
				$apdocno = $_REQUEST['apdocno'.$i];
				$apchequeno = $_REQUEST['apchequeno'.$i];
				$aptransactionamount = $_REQUEST['aptransactionamount'.$i];
				$aptransactiondate = $_REQUEST['aptransactiondate'.$i];
				$apchequedate  = $_REQUEST['apchequedate'.$i];
				$appostedby = $_REQUEST['appostedby'.$i];
				$apremarks = $_REQUEST['apremarks'.$i];
				$apdate = $_REQUEST['apdate'.$i];
				//$apstatus = $_REQUEST['apstatus'.$i];
				$apstatus = "POSTED";
				$apbankname = $_REQUEST['apbankname'.$i];
				$apbankcode = $_REQUEST['apbankcode'.$i];
				$apbankamount = $_REQUEST['apbankamount'.$i];
				$apbankamount = str_replace(",", "", $apbankamount);
				$query33 = "select auto_number from bank_record where docno = '$apdocno' and bankcode='$apbankcode' and bankamount='$apbankamount' and notes='accounts receivable'";
				$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
				$row33 = mysqli_num_rows($exec33);
				if($row33 == 0)
				{ 
				$query15 = "insert into bank_record (description,docno,instno,amount,postdate,postby,chequedate,remarks,bankdate,status,ipaddress,username,companyanum,companyname,
				updateddate,updatedtime,bankname,bankcode,bankamount,notes)values('$apaccountname','$apdocno','$apchequeno','$aptransactionamount','$aptransactiondate','$appostedby','$apchequedate','$apremarks','$apdate',
				'$apstatus','$ipaddress','$username','$companyanum','$companyname','$transactiondateto','$timeonly','$apbankname','$apbankcode','$apbankamount','accounts receivable')";
				$exec15 = mysqli_query($GLOBALS["___mysqli_ston"], $query15) or die ("Error in Query15".mysqli_error($GLOBALS["___mysqli_ston"]));
				$errmsg = "Success. Bank Details Updated.";
				$bgcolorcode = 'success';
			    }
			 
			}
		}
	}
	//account payable
	if($arrows !=0)
	{ 
		for($i=1;$i<=$arrows;$i++)
		{
			//$arstatus = $_REQUEST['arstatus'.$i];
			$arstatus = "POSTED";
			$ardate = $_REQUEST['ardate'.$i];
			//if($arstatus != 'Pending')
			if($ardate != '')
			{
				$araccountname = $_REQUEST['araccountname'.$i];
				$ardocno = $_REQUEST['ardocno'.$i];
				$archequeno = $_REQUEST['archequeno'.$i];
				$artransactionamount = $_REQUEST['artransactionamount'.$i];
				$artransactiondate = $_REQUEST['artransactiondate'.$i];
				$archequedate  = $_REQUEST['archequedate'.$i];
				$arpostedby = $_REQUEST['arpostedby'.$i];
				$arremarks = $_REQUEST['arremarks'.$i];
				$ardate = $_REQUEST['ardate'.$i];
				$arbankname = $_REQUEST['arbankname'.$i];
				$arbankcode = $_REQUEST['arbankcode'.$i];
				$arbankamount = $_REQUEST['arbankamount'.$i];
				$arbankamount = str_replace(",", "", $arbankamount);
				$query33 = "select auto_number from bank_record where docno = '$ardocno' and bankcode='$arbankcode' and bankamount='$arbankamount' and notes='account payable'";
				$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
				$row33 = mysqli_num_rows($exec33);
				if($row33 == 0)
				{ 
					$query16 = "insert into bank_record (description,docno,instno,amount,postdate,postby,chequedate,remarks,bankdate,status,ipaddress,username,companyanum,companyname,
				updateddate,updatedtime,bankname,bankcode,bankamount,notes)values('$araccountname','$ardocno','$archequeno','$artransactionamount','$artransactiondate','$arpostedby','$archequedate','$arremarks','$ardate',
				'$arstatus','$ipaddress','$username','$companyanum','$companyname','$transactiondateto','$timeonly','$arbankname','$arbankcode','$arbankamount','account payable')";
				$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
				$errmsg = "Success. Bank Details Updated.";
				$bgcolorcode = 'success';
				}
				
			}
		}
	}
	
	
	//sup d.note
	if($sprows !=0)
	{ 
		for($i=1;$i<=$sprows;$i++)
		{
			$spstatus = "POSTED";
			$spdate = $_REQUEST['spdate'.$i];
			//if($arstatus != 'Pending')
			if($spdate != '')
			{
				$spaccountname = $_REQUEST['spaccountname'.$i];
				$spdocno = $_REQUEST['spdocno'.$i];
				$spchequeno = $_REQUEST['spchequeno'.$i];
				$sptransactionamount = $_REQUEST['sptransactionamount'.$i];
				$sptransactiondate = $_REQUEST['sptransactiondate'.$i];
				$spchequedate  = $_REQUEST['spchequedate'.$i];
				$sppostedby = $_REQUEST['sppostedby'.$i];
				$spremarks = $_REQUEST['spremarks'.$i];
				$spdate = $_REQUEST['spdate'.$i];
				$spbankname = $_REQUEST['spbankname'.$i];
				$spbankcode = $_REQUEST['spbankcode'.$i];
				$spbankamount = $_REQUEST['spbankamount'.$i];
				$spbankamount = str_replace(",", "", $spbankamount);
				$query33 = "select auto_number from bank_record where docno = '$spdocno' and bankcode='$spbankcode' and bankamount='$spbankamount' and notes='supplier debit note'";
				$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
				$row33 = mysqli_num_rows($exec33);
				if($row33 == 0)
				{ 
				$query16 = "insert into bank_record (description,docno,instno,amount,postdate,postby,chequedate,remarks,bankdate,status,ipaddress,username,companyanum,companyname,
				updateddate,updatedtime,bankname,bankcode,bankamount,notes)values('$spaccountname','$spdocno','$spchequeno','$sptransactionamount','$sptransactiondate','$sppostedby','$spchequedate','$spremarks','$spdate',
				'$spstatus','$ipaddress','$username','$companyanum','$companyname','$transactiondateto','$timeonly','$spbankname','$spbankcode','$spbankamount','supplier debit note')";
				$exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));
				$errmsg = "Success. Bank Details Updated.";
				$bgcolorcode = 'success';
			
				}
				
			}
		}
	}
	
	
	
	//expenses
	if($exrows !=0)
	{ 
		for($i=1;$i<=$exrows;$i++)
		{	
			//$exstatus = $_REQUEST['exstatus'.$i];
			$exstatus = "POSTED";
			$exdate = $_REQUEST['exdate'.$i];
			//if($exstatus != 'Pending')
			if($exdate != '')
			{
				$exaccountname = $_REQUEST['exaccountname'.$i];
				$exdocno = $_REQUEST['exdocno'.$i];
				$exchequeno = $_REQUEST['exchequeno'.$i];
				$extransactionamount = $_REQUEST['extransactionamount'.$i];
				$extransactiondate = $_REQUEST['extransactiondate'.$i];
				$expostedby = $_REQUEST['expostedby'.$i];
				$exremarks = $_REQUEST['exremarks'.$i];
				$exdate = $_REQUEST['exdate'.$i];
				$exbankname = $_REQUEST['exbankname'.$i];
				$exbankcode = $_REQUEST['exbankcode'.$i];
				$exbankamount = $_REQUEST['exbankamount'.$i];
				$exbankamount = str_replace(",", "", $exbankamount);
				$query33 = "select auto_number from bank_record where docno = '$exdocno' and bankcode='$exbankcode' and bankamount='$exbankamount' and notes='expenses'";
				$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
				$row33 = mysqli_num_rows($exec33);
				if($row33 == 0)
				{ 
				$query17 = "insert into bank_record (description,docno,instno,amount,postdate,postby,chequedate,remarks,bankdate,status,ipaddress,username,companyanum,companyname,
				updateddate,updatedtime,bankname,bankcode,bankamount,notes)values('$exaccountname','$exdocno','$exchequeno','$extransactionamount','$extransactiondate','$expostedby','$extransactiondate','$exremarks','$exdate',
				'$exstatus','$ipaddress','$username','$companyanum','$companyname','$transactiondateto','$timeonly','$exbankname','$exbankcode','$exbankamount','expenses')";
				$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query17".mysqli_error($GLOBALS["___mysqli_ston"]));
				$errmsg = "Success. Bank Details Updated.";
				$bgcolorcode = 'success';
			   }
			}
			
		}
	}
	
	//receipts
	if($rerows !=0)
	{ 
		for($i=1;$i<=$rerows;$i++)
		{
			//$restatus = $_REQUEST['restatus'.$i];
			$restatus = "POSTED";
			$redate = $_REQUEST['redate'.$i];
			//if($restatus != 'Pending')
			if($redate != '')
			{
				$reaccountname = $_REQUEST['reaccountname'.$i];
				$redocno = $_REQUEST['redocno'.$i];
				$rechequeno = $_REQUEST['rechequeno'.$i];
				$retransactionamount = $_REQUEST['retransactionamount'.$i];
				$retransactiondate = $_REQUEST['retransactiondate'.$i];
				$repostedby = $_REQUEST['repostedby'.$i];
				$reremarks = $_REQUEST['reremarks'.$i];
				$redate = $_REQUEST['redate'.$i];
				$rebankname = $_REQUEST['rebankname'.$i];
				$rebankcode = $_REQUEST['rebankcode'.$i];
				$rebankamount = $_REQUEST['rebankamount'.$i];
				$rebankamount = str_replace(",", "", $rebankamount);
				$query33 = "select auto_number from bank_record where docno = '$redocno' and bankcode='$rebankcode' and bankamount='$rebankamount' and notes='receipts'";
				$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
				$row33 = mysqli_num_rows($exec33);
				if($row33 == 0)
				{ 
				$query18 = "insert into bank_record (description,docno,instno,amount,postdate,postby,chequedate,remarks,bankdate,status,ipaddress,username,companyanum,companyname,
				updateddate,updatedtime,bankname,bankcode,bankamount,notes)values('$reaccountname','$redocno','$rechequeno','$retransactionamount','$retransactiondate','$repostedby','$retransactiondate','$reremarks','$redate',
				'$restatus','$ipaddress','$username','$companyanum','$companyname','$transactiondateto','$timeonly','$rebankname','$rebankcode','$rebankamount','receipts')";
				$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query18".mysqli_error($GLOBALS["___mysqli_ston"]));
				$errmsg = "Success. Bank Details Updated.";
				$bgcolorcode = 'success';
			    }
 
			}
		}
	}
	//banktransactions
	if($bkrows !=0)
	{ 
		for($i=1;$i<=$bkrows;$i++)
		{
			//$bkstatus = $_REQUEST['bkstatus'.$i];
			$bkstatus = "POSTED";
			$bkdate = $_REQUEST['bkdate'.$i];
			//if($bkstatus != 'Pending')
			if($bkdate != '')
			{
				$bkaccountname = $_REQUEST['bkaccountname'.$i];
				$bkdocno = $_REQUEST['bkdocno'.$i];
				$bkchequeno = $_REQUEST['bkchequeno'.$i];
				$bktransactionamount = $_REQUEST['bktransactionamount'.$i];
				$bktransactiondate = $_REQUEST['bktransactiondate'.$i];
				$bkpostedby = $_REQUEST['bkpostedby'.$i];
				$bkremarks = $_REQUEST['bkremarks'.$i];
				$bkdate = $_REQUEST['bkdate'.$i];
				$bkbankname = $_REQUEST['bkbankname'.$i];
				$bkbankcode = $_REQUEST['bkbankcode'.$i];
				$bkbankamount = $_REQUEST['bkbankamount'.$i];
				$bkbankamount = str_replace(",", "", $bkbankamount);
				$query33 = "select auto_number from bank_record where docno = '$bkdocno' and bankcode='$bkbankcode' and bankamount='$bkbankamount' and notes='misc'";
				$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
				$row33 = mysqli_num_rows($exec33);
 
				if($row33 == 0)
				{ 
				$query19 = "insert into bank_record (description,docno,instno,amount,postdate,postby,chequedate,remarks,bankdate,status,ipaddress,username,companyanum,companyname,
				updateddate,updatedtime,bankname,bankcode,bankamount,notes)values('$bkaccountname','$bkdocno','$bkchequeno','$bktransactionamount','$bktransactiondate','$bkpostedby','$bktransactiondate','$bkremarks','$bkdate',
				'$bkstatus','$ipaddress','$username','$companyanum','$companyname','$transactiondateto','$timeonly','$bkbankname','$bkbankcode','$bkbankamount','misc')";
				$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query19".mysqli_error($GLOBALS["___mysqli_ston"]));
				$errmsg = "Success. Bank Details Updated.";
				$bgcolorcode = 'success';
			   }
			}			
		}
	}
	//JOURNAL ENTRIES
	if($apjrows !=0)
	{ 
		for($i=1;$i<=$apjrows;$i++)
		{
//			$apjstatus = $_REQUEST['apjstatus'.$i];
//			if($apjstatus != 'Pending')
			$apjdate = $_REQUEST['apjdate'.$i];
			//if($apjstatus != 'Pending')
			if($apjdate != '')
			{
				
			    $apjaccountname = $_REQUEST['apjaccountname'.$i];
				$apjdocno = $_REQUEST['apjdocno'.$i];
				$apjchequeno = $_REQUEST['apjchequeno'.$i];
				$apjtransactionamount = $_REQUEST['apjtransactionamount'.$i];
				$apjtransactiondate = $_REQUEST['apjtransactiondate'.$i];
				$apjpostedby = $_REQUEST['apjpostedby'.$i];
				$apjremarks = $_REQUEST['apjremarks'.$i];
				$apjdate = $_REQUEST['apjdate'.$i];
				$apjstatus = 'POSTED';
				$apjbankname = $_REQUEST['apjbankname'.$i];
				$apjbankcode = $_REQUEST['apjbankcode'.$i];
				$apjbankamount = $_REQUEST['apjbankamount'.$i];
				
				$apjbankamount = str_replace(",", "", $apjbankamount);
				
			$query21 = "select * from bank_record where docno = '$apjdocno' and instno = '$apjchequeno' and bankcode='$apjbankcode' ";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res21 = mysqli_fetch_array($exec21);
			$post21 = mysqli_num_rows($exec21);
			if($post21<=0){	
				
				
				$query14 = "insert into bank_record (description,docno,instno,amount,postdate,postby,chequedate,remarks,bankdate,status,ipaddress,username,companyanum,companyname,
				updateddate,updatedtime,bankname,bankcode,bankamount,notes)
				values('$apjaccountname','$apjdocno','$apjchequeno','$apjtransactionamount','$apjtransactiondate','$apjpostedby','$apjtransactiondate','$apjremarks','$apjdate',
				'$apjstatus','$ipaddress','$username','$companyanum','$companyname','$transactiondateto','$timeonly','$apjbankname','$apjbankcode','$apjbankamount','journal entries')";
				$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));
			} else {
			 $query1 = "update bank_record set bankdate = '$apjdate',status = '$apjstatus',updateddate='$transactiondateto',updatedtime='$timeonly'  where docno = '$apjdocno' and instno = '$apjchequeno' and bankcode='$apjbankcode' ";
		     $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));			
			}	
				
				
				
				
				$errmsg = "Success. Bank Details Updated.";
				$bgcolorcode = 'success';
				
			}
		}
	}
//print_r($_POST);
}
   if (isset($_REQUEST["bankname"])) { $bankname = $_REQUEST["bankname"]; } else { $bankname = ""; } 
	   if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
	  if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $ADate1 = date('Y-m-d'); }
	  if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $ADate1 = date('Y-m-d'); }
	  if (isset($_REQUEST["statementamount"])) { $statementamount = $_REQUEST["statementamount"]; } else { $statementamount = ""; }
	  //echo $bankname;
?>
<style type="text/css">
th {
            background-color: #ccccc;
            position: sticky;
            top: 0;
            z-index: 1;
        }
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #add8e6;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.number1
{
text-align:right;
padding-left:700px;
}
/*.ui-state-hover{background-color:red !important;}*/
ui-datepicker {
    width: 13em !important;
    }
ui-datepicker {
    width: 13em !important;
    }
.grouptotals{
	border: none;
    background: #add8e6;
    text-align: right;
    font-weight: bold;
    font-family: : Tahoma;
    color: : #3b3b3c;
    font-size: 12px;
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">
function cbcustomername1()
{
	document.cbform1.submit();
}
</script>
<script type="text/javascript" src="js/autocomplete_customer1.js"></script>
<script type="text/javascript" src="js/autosuggest3.js"></script>
<!-- <script src="js/jquery-1.11.1.min.js"></script> -->
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
   
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">    
<link href="css/blitzer/jquery-ui-1.10.4.custom.css" rel="stylesheet">
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.js"></script>
<script type="text/javascript">
/*
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        
}
*/
/*$( function() {
    $( ".datepicker" ).datepicker({
			dateFormat: "yy-mm-dd"});
    
   
  } );*/
var docnoarr = [];
$(document).ready(function(){
	
	//$('.datepicker').trigger('click');//$('.datepicker').click();
	console.log('document ready')
	$( ".datepicker" ).datepicker({
			dateFormat: "yy-mm-dd",
			showOn: "button",
      buttonImage: "images/calendar.gif",
      buttonImageOnly: true,
      buttonText: "Select date",
      inline: true
		});
	$(".datepicker")
.datepicker({
    onSelect: function(dateText) {
        console.log("Selected date: " + dateText + "; input's current value: " + this.value);
    }
})
.on("change", function() {
    console.log("Got change event from field");
    console.log(this.id);
    var str = this.id;
    console.log('#'+str+'#');
   
    if (str.indexOf("apdate") >= 0)
    {
    	var type = "apdate";
    	var transtype = "D";
    	var amtstr = "ap";
    	/*console.log('yes');
    	var id = str.substr(str.indexOf("apdate") + 6);
    	var dramt = $('#apdramt_'+id).val();
    	console.log(dramt);
    	var total_debit_amount = $('#total_debit_amount').val();
    	total_debit_amount = total_debit_amount.replace(/,/g,'');
    	var new_tot_debit_amt = parseFloat(total_debit_amount) - parseFloat(dramt);
    	//aaa
    	var cramt = $('#apcramt_'+id).val();
    	console.log(new_tot_debit_amt);
    	new_tot_debit_amt = new_tot_debit_amt.toFixed(2);
    	new_tot_debit_amt = new_tot_debit_amt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    	$('#total_debit_amount').val(new_tot_debit_amt);
    	console.log(id);
    	console.log(total_debit_amount);*/
    	//changetotals(type,str,transtype,amtstr);
    	var sno = str.substr(str.indexOf(type) + 6);
    	console.log(sno);
    	var docno = $('#apdocno'+sno).val();
    	if(docnoarr.includes(docno) === false)
    	{
    		docnoarr.push(docno);
    		changetotals(type,str,transtype,amtstr);
    	}
    }
    else if(str.indexOf("ardate") >= 0)
    {
    	var type = "ardate";
    	var transtype = "C";
    	var amtstr = "ar";
    	console.log('ardate loop');
    	
    	
    	//changetotals(type,str,transtype,amtstr);
    	var sno = str.substr(str.indexOf(type) + 6);
    	console.log(sno);
    	var docno = $('#ardocno'+sno).val();
    	console.log(docno);
    	console.log('@'+docnoarr.includes(docno)+'@');
    	if(docnoarr.includes(docno) ===false)
    	{
    		docnoarr.push(docno);
    		changetotals(type,str,transtype,amtstr);
    	}
    }
	else if(str.indexOf("spdate") >= 0)
    {
    	var type = "spdate";
    	var transtype = "C";
    	var amtstr = "sp";
    	console.log('spdate loop');
    	
    	
    	//changetotals(type,str,transtype,amtstr);
    	var sno = str.substr(str.indexOf(type) + 6);
    	console.log(sno);
    	var docno = $('#spdocno'+sno).val();
    	console.log(docno);
    	console.log('@'+docnoarr.includes(docno)+'@');
    	if(docnoarr.includes(docno) ===false)
    	{
    		docnoarr.push(docno);
    		changetotals(type,str,transtype,amtstr);
    	}
    }
    else if(str.indexOf("apjdate") >= 0)
    {
    	
    	var type = "apjdate";
    	var transtype = "";
    	var amtstr = "apj";
    	console.log('apjdate loop');
    	
    	
    	var sno = str.substr(str.indexOf(type) + 7);
    	var docno = $('#apjdocno'+sno).val();
    	if(docnoarr.includes(docno) ===false)
    	{
    		docnoarr.push(docno);
    		changetotals(type,str,transtype,amtstr);
    	}
    }
    else if(str.indexOf("redate") >= 0)
    {
    	
    	var type = "redate";
    	var transtype = "D";
    	var amtstr = "re";
    	console.log('redate loop');
    	
    	var sno = str.substr(str.indexOf(type) + 6);
    	var docno = $('#redocno'+sno).val();
    	if(docnoarr.includes(docno) ===false)
    	{
    		docnoarr.push(docno);
    		changetotals(type,str,transtype,amtstr);
    	}
    }
    else if(str.indexOf("bkdate") >= 0)
    {
    	
    	var type = "bkdate";
    	var transtype = "";
    	var amtstr = "bk";
    	console.log('bkdate loop');
    	
    	var sno = str.substr(str.indexOf(type) + 6);
    	var docno = $('#bkdocno'+sno).val();
    	if(docnoarr.includes(docno) ===false)
    	{
    		docnoarr.push(docno);
    		changetotals(type,str,transtype,amtstr);
    	}
    }
    
    //console.log('##'+this.value);
});
	var todaysdate = $('#todaysdate').val();
	var receiptscnt = $('#renums').val();
	for (var i = 0; i <= receiptscnt; i++) {
		showvalid_dates('receipts',i);
	}
	var receiptscnt = $('#arnums').val();
	for (var i = 0; i <= receiptscnt; i++) {
		showvalid_dates('receivables',i);
	}
	var receiptscnt = $('#spnums').val();
	for (var i = 0; i <= receiptscnt; i++) {
		showvalid_dates('supplier',i);
	}
	var receiptscnt = $('#apnums').val();
	
	for (var i = 0; i <= receiptscnt; i++) {
		
		showvalid_dates('payables',i);
	}
	var receiptscnt = $('#exnums').val();
	for (var i = 0; i <= receiptscnt; i++) {
		showvalid_dates('expenses',i);
	}
	var receiptscnt = $('#bknums').val();
	for (var i = 0; i <= receiptscnt; i++) {
		showvalid_dates('banks',i);
	}
	var receiptscnt = $('#apjnums').val();
	for (var i = 0; i <= receiptscnt; i++) {
		showvalid_dates('journals',i);
	}
	/*console.log('before trigger fire stmt')
	$(".datepicker").trigger("click"); */
	
	//$('.datepicker').click();
	/*$('.datepicker').click(function(){
		console.log('click called');
    	//console.log('date picker clicked')
    	//console.log($(this).attr('id'));
    	var selectid = $(this).attr('id');
    	if(selectid.indexOf("redate") > -1)
    	{
    		//console.log('receipt date selected')
    		var idsplitarr = selectid.split("redate");
    		
    		//console.log('##'+idsplitarr[1])
    		var currid = idsplitarr[1];
    		var posteddate = $('#retransactiondate'+currid).val();
    		$('#'+selectid).datepicker("destroy");
    		// receipt date selected
			$('#'+selectid).datepicker({
			dateFormat: "yy-mm-dd",
			minDate: new Date(posteddate),
			maxDate: new Date(todaysdate)
			});
    	}
    	else
    	{
    		if(selectid.indexOf("ardate") > -1)
    		{
    			// Account payable date selected
				//console.log('payable date selected')
				var idsplitarr = selectid.split("ardate");
				//console.log('##'+idsplitarr[1])
				var currid = idsplitarr[1];
				var posteddate = $('#artransactiondate'+currid).val();
				$('#'+selectid).datepicker("destroy");
				// receipt date selected
				$('#'+selectid).datepicker({
				dateFormat: "yy-mm-dd",
				minDate: new Date(posteddate),
				maxDate: new Date(todaysdate)
				});
    		}
    		else
    		{
    			if(selectid.indexOf("apdate") > -1)
    			{
    				// Account receivable date selected
    				//console.log('receivable date selected')
					var idsplitarr = selectid.split("apdate");
					//console.log('##'+idsplitarr[1])
					var currid = idsplitarr[1];
					var posteddate = $('#aptransactiondate'+currid).val();
					$('#'+selectid).datepicker("destroy");
					// receipt date selected
					$('#'+selectid).datepicker({
					dateFormat: "yy-mm-dd",
					minDate: new Date(posteddate),
					maxDate: new Date(todaysdate)
					});
    			}
    		}
    	}
    })*/
    $('.stmtamt').keypress(function (event) {
           return isNumber(event, this)
    });
    $('#UpdateBtn').on('click',function()
  {
    
      
      
     
    
    $(this).val('Please wait ...')
      .attr('disabled','disabled');
      $('#reconform').submit();
    //bbb
  });
    
});
/*function validatesubmit()
{
}*/
function isNumber(evt, element) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (
            (charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57))
            return false;
        return true;
    } 
   
function showvalid_dates(type,sno)
{
	//var todaysdate = $('#todaysdate').val();
	var todaysdate = $('#formdate').val();
	if(type=='receipts')
	{
		//var idsplitarr = selectid.split("redate");
    		console.log('receipts fnc called')
    		var selectid = "redate"+sno;
    		//console.log('##'+idsplitarr[1])
    		//var currid = idsplitarr[1];
    		var currid = sno;
    		var posteddate = $('#retransactiondate'+currid).val();
    		/*var bankrecentdate = $('#rerecentdate'+currid).val();
    		if(bankrecentdate !="")
    		{
    			var posteddate = bankrecentdate;
    		}*/
    		
    		$('#'+selectid).datepicker("destroy");
    		// receipt date selected
			$('#'+selectid).datepicker({
			dateFormat: "yy-mm-dd",
			showOn: "button",
		      buttonImage: "images/calendar.gif",
		      buttonImageOnly: true,
		      buttonText: "Select date",
			minDate: new Date(posteddate),
			maxDate: new Date(todaysdate),
			inline: true
			});
	}
	if(type=='payables')
	{
		//var idsplitarr = selectid.split("redate");
    		console.log('payables fnc called')
    		var selectid = "apdate"+sno;
    		//console.log('##'+idsplitarr[1])
    		//var currid = idsplitarr[1];
    		var currid = sno;
    		//var posteddate = $('#aptransactiondate'+currid).val();
    		var posteddate = $('#apchequedate'+currid).val();
    		
    		/*var bankrecentdate = $('#aprecentdate'+currid).val();
    		if(bankrecentdate !="")
    		{
    			var posteddate = bankrecentdate;
    		}*/
    		
    		$('#'+selectid).datepicker("destroy");
    		// receipt date selected
			$('#'+selectid).datepicker({
			dateFormat: "yy-mm-dd",
			showOn: "button",
		      buttonImage: "images/calendar.gif",
		      buttonImageOnly: true,
		      buttonText: "Select date",
			minDate: new Date(posteddate),
			maxDate: new Date(todaysdate),
			inline: true
			});
			
	}
	if(type=='receivables')
	{
		//var idsplitarr = selectid.split("redate");
    		console.log('receivables fnc called')
    		var selectid = "ardate"+sno;
    		//console.log('##'+idsplitarr[1])
    		//var currid = idsplitarr[1];
    		var currid = sno;
    		//var posteddate = $('#artransactiondate'+currid).val();
    		var posteddate = $('#archequedate'+currid).val();
    		/*var bankrecentdate = $('#arrecentdate'+currid).val();
    		if(bankrecentdate !="")
    		{
    			var posteddate = bankrecentdate;
    		}*/
    		
    		$('#'+selectid).datepicker("destroy");
    		// receipt date selected
			$('#'+selectid).datepicker({
			dateFormat: "yy-mm-dd",
			showOn: "button",
		      buttonImage: "images/calendar.gif",
		      buttonImageOnly: true,
		      buttonText: "Select date",
			minDate: new Date(posteddate),
			maxDate: new Date(todaysdate),
			inline: true
			});
	}
	
	if(type=='supplier')
	{
	
		//var idsplitarr = selectid.split("redate");
    		console.log('supplier fnc called')
    		var selectid = "spdate"+sno;
    		//console.log('##'+idsplitarr[1])
    		//var currid = idsplitarr[1];
    		var currid = sno;
    		//var posteddate = $('#artransactiondate'+currid).val();
    		var posteddate = $('#spchequedate'+currid).val();
    		/*var bankrecentdate = $('#arrecentdate'+currid).val();
    		if(bankrecentdate !="")
    		{
    			var posteddate = bankrecentdate;
    		}*/
    		
    		$('#'+selectid).datepicker("destroy");
    		// receipt date selected
			$('#'+selectid).datepicker({
			dateFormat: "yy-mm-dd",
			showOn: "button",
		      buttonImage: "images/calendar.gif",
		      buttonImageOnly: true,
		      buttonText: "Select date",
			minDate: new Date(posteddate),
			maxDate: new Date(todaysdate),
			inline: true
			});
	}
	
	
	
	if(type=='expenses')
	{
		//var idsplitarr = selectid.split("redate");
    		console.log('expenses fnc called')
    		var selectid = "exdate"+sno;
    		//console.log('##'+idsplitarr[1])
    		//var currid = idsplitarr[1];
    		var currid = sno;
    		var posteddate = $('#extransactiondate'+currid).val();
    		/*var bankrecentdate = $('#exrecentdate'+currid).val();
    		if(bankrecentdate !="")
    		{
    			var posteddate = bankrecentdate;
    		}*/
    		$('#'+selectid).datepicker("destroy");
    		// receipt date selected
			$('#'+selectid).datepicker({
			dateFormat: "yy-mm-dd",
			showOn: "button",
		      buttonImage: "images/calendar.gif",
		      buttonImageOnly: true,
		      buttonText: "Select date",
			minDate: new Date(posteddate),
			maxDate: new Date(todaysdate),
			inline: true
			});
	}
	if(type=='banks')
	{
		//var idsplitarr = selectid.split("redate");
    		console.log('banks fnc called')
    		var selectid = "bkdate"+sno;
    		//console.log('##'+idsplitarr[1])
    		//var currid = idsplitarr[1];
    		var currid = sno;
    		var posteddate = $('#bktransactiondate'+currid).val();
    		/*var bankrecentdate = $('#bkrecentdate'+currid).val();
    		if(bankrecentdate !="")
    		{
    			var posteddate = bankrecentdate;
    		}*/
    		$('#'+selectid).datepicker("destroy");
    		// receipt date selected
			$('#'+selectid).datepicker({
			dateFormat: "yy-mm-dd",
			showOn: "button",
		      buttonImage: "images/calendar.gif",
		      buttonImageOnly: true,
		      buttonText: "Select date",
			minDate: new Date(posteddate),
			maxDate: new Date(todaysdate),
			inline: true
			});
	}
	if(type=='journals')
	{
		//var idsplitarr = selectid.split("redate");
    		console.log('journal fnc called')
    		var selectid = "apjdate"+sno;
    		//console.log('##'+idsplitarr[1])
    		//var currid = idsplitarr[1];
    		var currid = sno;
    		var posteddate = $('#apjtransactiondate'+currid).val();
    		/*var bankrecentdate = $('#apjrecentdate'+currid).val();
    		if(bankrecentdate !="")
    		{
    			var posteddate = bankrecentdate;
    		}*/
    		$('#'+selectid).datepicker("destroy");
    		// receipt date selected
			$('#'+selectid).datepicker({
			dateFormat: "yy-mm-dd",
			showOn: "button",
		      buttonImage: "images/calendar.gif",
		      buttonImageOnly: true,
		      buttonText: "Select date",
			minDate: new Date(posteddate),
			maxDate: new Date(todaysdate),
			inline: true
			});
	}	
}
/*$(".datepicker").datepicker({
    onSelect: function(dateText, inst) {
        var date = $(this).val();
        var time = $('#time').val();
        alert('on select triggered');
        //$("#start").val(date + time.toString(' HH:mm').toString());
    }
});*/
function changetotals(type,str,transtype,amtstr)
{
    console.log('in change totals fn')
console.log(amtstr)
    var id = str.substr(str.indexOf(type) + 6);
    	
    	
    if(transtype=='D'){
    	console.log('DR')
    	var dramt = $('#'+amtstr+'dramt_'+id).val();
    	console.log('Dr Amt'+dramt);
    	var total_debit_amount = $('#total_debit_amount').val();
    	total_debit_amount = total_debit_amount.replace(/,/g,'');
    	var new_tot_debit_amt = parseFloat(total_debit_amount) - parseFloat(dramt);
    	console.log(new_tot_debit_amt);
    	new_tot_debit_amt = new_tot_debit_amt.toFixed(2);
    	new_tot_debit_amt = new_tot_debit_amt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    	$('#total_debit_amount').val(new_tot_debit_amt);
    }
    else if(transtype=='C')
    {
    	console.log('CR')
    	var cramt = $('#'+amtstr+'cramt_'+id).val();
    	console.log('cramt'+cramt)
    	var total_credit_amount = $('#total_credit_amount').val();
    	total_credit_amount = total_credit_amount.replace(/,/g,'');
    	var new_tot_credit_amt = parseFloat(total_credit_amount) - parseFloat(cramt);
    	//aaa
    	//var cramt = $('#apcramt_'+id).val();
    	console.log(new_tot_credit_amt);
    	new_tot_credit_amt = new_tot_credit_amt.toFixed(2);
    	new_tot_credit_amt = new_tot_credit_amt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    	$('#total_credit_amount').val(new_tot_credit_amt);
    }
    else
    {
    	if(amtstr == 'bk')
    	{
    		var id = str.substr(str.indexOf(type) + 6);
    	}
    	if(amtstr == 'apj')
    	{
    		var id = str.substr(str.indexOf(type) + 7);
    	}
    	//var id = str.substr(str.indexOf(type) + 7);
    	console.log('Not DR Not CR');
    	var dramt = $('#'+amtstr+'dramt_'+id).val();
    	if(parseFloat(dramt) > 0 )
    	{
    		console.log('dr amt exists');
    		var total_debit_amount = $('#total_debit_amount').val();
    	total_debit_amount = total_debit_amount.replace(/,/g,'');
    	var new_tot_debit_amt = parseFloat(total_debit_amount) - parseFloat(dramt);
    	console.log(new_tot_debit_amt);
    	new_tot_debit_amt = new_tot_debit_amt.toFixed(2);
    	new_tot_debit_amt = new_tot_debit_amt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    	$('#total_debit_amount').val(new_tot_debit_amt);
    	}
    	else
    	{
    		console.log('cr amt exists');
    		var cramt = $('#'+amtstr+'cramt_'+id).val();
    		console.log('#'+amtstr+'cramt_'+id);
    	console.log('cramt'+cramt)
    	var total_credit_amount = $('#total_credit_amount').val();
    	total_credit_amount = total_credit_amount.replace(/,/g,'');
    	var new_tot_credit_amt = parseFloat(total_credit_amount) - parseFloat(cramt);
    	//aaa
    	//var cramt = $('#apcramt_'+id).val();
    	console.log(new_tot_credit_amt);
    	new_tot_credit_amt = new_tot_credit_amt.toFixed(2);
    	new_tot_credit_amt = new_tot_credit_amt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    	$('#total_credit_amount').val(new_tot_credit_amt);
    	}
    }
    //Amount to be Reconciled = ledger balance - (statement amount  + amount not reflected in bank (dr amt - cr amt))
    var ledger_balance_amt = $('#closing_balance_ledger_hid').val();
    console.log('before'+ledger_balance_amt);
    
    //ledger_balance_amt = ledger_balance_amt.replace(/,/g,'');
    //ledger_balance_amt =  Math.abs(ledger_balance_amt);
    console.log('after'+ledger_balance_amt);
    var statement_amount = $('#statement_amount_hid').val();
    if(statement_amount == '')
    	statement_amount = 0;
    //statement_amount = statement_amount.replace(/,/g,'');
    //statement_amount = Math.abs(statement_amount);
     console.log('stmt amt'+statement_amount);
    var final_dr_amt = $('#total_debit_amount').val();
    final_dr_amt = final_dr_amt.replace(/,/g,'');
    console.log('finaldr amt'+final_dr_amt);
    var final_cr_amt = $('#total_credit_amount').val();
    final_cr_amt = final_cr_amt.replace(/,/g,'');
    console.log('finalcr amt'+final_cr_amt);
    var amount_tobe_reconsiled = parseFloat(ledger_balance_amt) - ( parseFloat(statement_amount) + ( parseFloat(final_dr_amt) - parseFloat(final_cr_amt) ) );
    console.log('#to reconsile amt'+amount_tobe_reconsiled);
    amount_tobe_reconsiled = Math.abs(amount_tobe_reconsiled);
    amount_tobe_reconsiled = amount_tobe_reconsiled.toFixed(2);
    amount_tobe_reconsiled = amount_tobe_reconsiled.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    $('#amount_tobe_reconsiled').val(amount_tobe_reconsiled);
    // aaaa
}
function disableEnterKey(varPassed)
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}
	if(key == 13) // if enter key press
	{
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
}
function valid()
{
	console.log('in valid fn')
	if(document.getElementById('bankname').value =='')
	{
		alert("Please Select The Bank");
		return false;
	}
	if(document.getElementById('ADate2').value =='')
	{
		alert("Please Select The Date");
		return false;
	}
return true;
}
function postcalc()
{
	//alert("hi");
	var apnums = document.getElementById('apnums').value;
	var arnums = document.getElementById('arnums').value;
	var spnums = document.getElementById('spnums').value;
	var renums = document.getElementById('renums').value;
	var exnums = document.getElementById('exnums').value;
	var bknums = document.getElementById('bknums').value;
	var apjnums = document.getElementById('apjnums');
	var appostamount = '0.00';
	var arpostamount = '0.00';
	var sppostamount = '0.00';
	var repostamount = '0.00';
	var expostamount = '0.00';
	var bkpostamount = '0.00';
	var apjpostamount = '0.00';
	var totalpostamount = '0.00';
	var appendamount = '0.00';
	var arpendamount = '0.00';
	var sppendamount = '0.00';
	var rependamount = '0.00';
	var expendamount = '0.00';
	var bkpendamount = '0.00';
	var apjpendamount = '0.00';
	var totalpendamount = '0.00';
	if(apjnums != null)
	{	
		var apjnums = document.getElementById('apjnums').value;
		for(var i=1;i<=apjnums;i++)
		{
			var apjpostamount1 = 0.00;
			var apjpendamount1 = 0.00;
			if((document.getElementById('apjbankamount'+i)))
			{
				var apjstatus = document.getElementById('apjstatus'+i).value;
				if(apjstatus == 'Posted' || apjstatus == 'Unpresented' || apjstatus == 'Uncleared')
				{
					if(document.getElementById('apjdate'+i).value == ""){
					alert('Select Bank Date');
					document.getElementById('apjstatus'+i).value = 'Pending';
					return false;
					}
				 	apjpostamount1 = document.getElementById('apjbankamount'+i).value;
					apjpostamount1 = apjpostamount1.replace(/,/g,'');
					apjpostamount = apjpostamount.replace(/,/g,'');
					apjpostamount = parseFloat(apjpostamount) + parseFloat(apjpostamount1);
				 	apjpostamount = apjpostamount.toFixed(2);
					apjpostamount = apjpostamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				}
				else
				{
					apjpendamount1 = document.getElementById('apjbankamount'+i).value;
					apjpendamount1 = apjpendamount1.replace(/,/g,'');
					apjpendamount = apjpendamount.replace(/,/g,'');
					apjpendamount = parseFloat(apjpendamount) + parseFloat(apjpendamount1);
				 	apjpendamount = apjpendamount.toFixed(2);
					apjpendamount = apjpendamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				}
			}
		}
		if(document.getElementById('apjpostamount')){
		document.getElementById('apjpostamount').innerHTML = apjpostamount;
		document.getElementById('apjpendamount').innerHTML = apjpendamount;
		}
		//alert(apnums);
	}
	if(apnums != null)
	{	
		var apnums = document.getElementById('apnums').value;
		for(var i=1;i<=apnums;i++)
		{
			var appostamount1 = 0.00;
			var appendamount1 = 0.00;
			if((document.getElementById('apbankamount'+i)))
			{
				var apstatus = document.getElementById('apstatus'+i).value;
				if(apstatus == 'Posted' || apstatus == 'Unpresented' || apstatus == 'Uncleared')
				{
					if(document.getElementById('apdate'+i).value == ""){
					alert('Select Bank Date');
					document.getElementById('apstatus'+i).value = 'Pending';
					return false;
					}
				 	appostamount1 = document.getElementById('apbankamount'+i).value;
					appostamount1 = appostamount1.replace(/,/g,'');
					appostamount = appostamount.replace(/,/g,'');
					appostamount = parseFloat(appostamount) + parseFloat(appostamount1);
				 	appostamount = appostamount.toFixed(2);
					appostamount = appostamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				}
				else
				{
					appendamount1 = document.getElementById('apbankamount'+i).value;
					appendamount1 = appendamount1.replace(/,/g,'');
					appendamount = appendamount.replace(/,/g,'');
					appendamount = parseFloat(appendamount) + parseFloat(appendamount1);
				 	appendamount = appendamount.toFixed(2);
					appendamount = appendamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				}
			}
		}
		if(document.getElementById('appostamount')){
		document.getElementById('appostamount').innerHTML = appostamount;
		document.getElementById('appendamount').innerHTML = appendamount;
		}
		//alert(apnums);
	}
	if(arnums != null)
	{
		var arnums = document.getElementById('arnums').value;
		for(var i=1;i<=arnums;i++)
		{
			var arpostamount1 = 0.00;
			var arpendamount1 = 0.00;
			if((document.getElementById('arbankamount'+i)))
			{
				var arstatus = document.getElementById('arstatus'+i).value;
				if(arstatus == 'Posted' || arstatus == 'Unpresented' || arstatus == 'Uncleared')
				{
					if(document.getElementById('ardate'+i).value == ""){
					alert('Select Bank Date');
					document.getElementById('arstatus'+i).value = 'Pending';
					return false;
					}
				 	arpostamount1 = document.getElementById('arbankamount'+i).value;
					arpostamount1 = arpostamount1.replace(/,/g,'');
					arpostamount = arpostamount.replace(/,/g,'');
					arpostamount = parseFloat(arpostamount) + parseFloat(arpostamount1);
				 	arpostamount = arpostamount.toFixed(2);
					arpostamount = arpostamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				}
				else
				{
					arpendamount1 = document.getElementById('arbankamount'+i).value;
					arpendamount1 = arpendamount1.replace(/,/g,'');
					arpendamount = arpendamount.replace(/,/g,'');
					arpendamount = parseFloat(arpendamount) + parseFloat(arpendamount1);
				 	arpendamount = arpendamount.toFixed(2);
					arpendamount = arpendamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				}
			}
		}
		if(document.getElementById('arpostamount')){
		document.getElementById('arpostamount').innerHTML = arpostamount;
		document.getElementById('arpendamount').innerHTML = arpendamount;
		}
		//alert(arnums);
	}
	if(spnums != null)
	{
		var spnums = document.getElementById('spnums').value;
		for(var i=1;i<=spnums;i++)
		{
			var sppostamount1 = 0.00;
			var sppendamount1 = 0.00;
			if((document.getElementById('spbankamount'+i)))
			{
				var spstatus = document.getElementById('spstatus'+i).value;
				if(spstatus == 'Posted' || spstatus == 'Unpresented' || spstatus == 'Uncleared')
				{
					if(document.getElementById('spdate'+i).value == ""){
					alert('Select Bank Date');
					document.getElementById('spstatus'+i).value = 'Pending';
					return false;
					}
				 	sppostamount1 = document.getElementById('spbankamount'+i).value;
					sppostamount1 = sppostamount1.replace(/,/g,'');
					sppostamount = sppostamount.replace(/,/g,'');
					sppostamount = parseFloat(sppostamount) + parseFloat(sppostamount1);
				 	sppostamount = sppostamount.toFixed(2);
					sppostamount = sppostamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				}
				else
				{
					sppendamount1 = document.getElementById('spbankamount'+i).value;
					sppendamount1 = sppendamount1.replace(/,/g,'');
					sppendamount = sppendamount.replace(/,/g,'');
					sppendamount = parseFloat(sppendamount) + parseFloat(sppendamount1);
				 	sppendamount = sppendamount.toFixed(2);
					sppendamount = sppendamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				}
			}
		}
		if(document.getElementById('sppostamount')){
		document.getElementById('sppostamount').innerHTML = sppostamount;
		document.getElementById('sppendamount').innerHTML = sppendamount;
		}
		//alert(arnums);
	}
	
	
	if(renums != null)
	{
		var renums = document.getElementById('renums').value;
		for(var i=1;i<=renums;i++)
		{
			var repostamount1 = 0.00;
			var rependamount1 = 0.00;
			if((document.getElementById('rebankamount'+i)))
			{
				var restatus = document.getElementById('restatus'+i).value;
				if(restatus == 'Posted' || restatus == 'Unpresented' || restatus == 'Uncleared')
				{
					if(document.getElementById('redate'+i).value == ""){
					alert('Select Bank Date');
					document.getElementById('restatus'+i).value = 'Pending';
					return false;
					}
				 	repostamount1 = document.getElementById('rebankamount'+i).value;
					repostamount1 = repostamount1.replace(/,/g,'');
					repostamount = repostamount.replace(/,/g,'');
					repostamount = parseFloat(repostamount) + parseFloat(repostamount1);
				 	repostamount = repostamount.toFixed(2);
					repostamount = repostamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				}
				else
				{
					rependamount1 = document.getElementById('rebankamount'+i).value;
					rependamount = rependamount.replace(/,/g,'');
					rependamount1 = rependamount1.replace(/,/g,'');
					rependamount = parseFloat(rependamount) + parseFloat(rependamount1);
				 	rependamount = rependamount.toFixed(2);
					rependamount = rependamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				}
			}			
		}
		if(document.getElementById('repostamount')){
		document.getElementById('repostamount').innerHTML = repostamount;
		document.getElementById('rependamount').innerHTML = rependamount;
		}
		//alert(renums);
	}
	if(exnums != null)
	{
		var exnums = document.getElementById('exnums').value;
		for(var i=1;i<=exnums;i++)
		{//alert("hi");
			var expostamount1 = 0.00;
			var expendamount1 = 0.00;
			if((document.getElementById('exbankamount'+i)))
			{
				var exstatus = document.getElementById('exstatus'+i).value;
				if(exstatus == 'Posted' || exstatus == 'Unpresented' || exstatus == 'Uncleared')
				{
					if(document.getElementById('exdate'+i).value == ""){
					alert('Select Bank Date');
					document.getElementById('exstatus'+i).value = 'Pending';
					return false;
					}
					expostamount1 = document.getElementById('exbankamount'+i).value;
					expostamount1 =expostamount1.replace(/,/g,'');
					expostamount =expostamount.replace(/,/g,'');
					expostamount = parseFloat(expostamount) + parseFloat(expostamount1);
				 	expostamount = expostamount.toFixed(2);
					expostamount = expostamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				}
				else
				{
					expendamount1 = document.getElementById('exbankamount'+i).value;
					expendamount1 =expendamount1.replace(/,/g,'');
					expendamount =expendamount.replace(/,/g,'');
					expendamount = parseFloat(expendamount) + parseFloat(expendamount1);
				 	expendamount = expendamount.toFixed(2);
					expendamount = expendamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				}				
			}
		}
		if(document.getElementById('expostamount')){
		document.getElementById('expostamount').innerHTML = expostamount;
		document.getElementById('expendamount').innerHTML = expendamount;
		}
		//alert(exnums);
	}
	if(bknums != null)
	{
		var bknums = document.getElementById('bknums').value;
		for(var i=1;i<=bknums;i++)
		{
			var bkpostamount1 = 0.00;
			var bkpendamount1 = 0.00;
			if((document.getElementById('bkbankamount'+i)))
			{
				var bkstatus = document.getElementById('bkstatus'+i).value;
				if(bkstatus == 'Posted' || bkstatus == 'Unpresented' || bkstatus == 'Uncleared')
				{
					if(document.getElementById('bkdate'+i).value == ""){
					alert('Select Bank Date');
					document.getElementById('bkstatus'+i).value = 'Pending';
					return false;
					}
				 	bkpostamount1 = document.getElementById('bkbankamount'+i).value;
					bkpostamount1 = bkpostamount1.replace(/,/g,'');
					bkpostamount = bkpostamount.replace(/,/g,'');
					bkpostamount = parseFloat(bkpostamount) + parseFloat(bkpostamount1);
				 	bkpostamount = bkpostamount.toFixed(2);
					bkpostamount = bkpostamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				}
				else
				{
					bkpendamount1 = document.getElementById('bkbankamount'+i).value;
					bkpendamount1 = bkpendamount1.replace(/,/g,'');
					bkpendamount = bkpendamount.replace(/,/g,'');
					bkpendamount = parseFloat(bkpendamount) + parseFloat(bkpendamount1);
				 	bkpendamount = bkpendamount.toFixed(2);
					bkpendamount = bkpendamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				}
			}
		}
		if(document.getElementById('bkpostamount')){
		document.getElementById('bkpostamount').innerHTML = bkpostamount;
		document.getElementById('bkpendamount').innerHTML = bkpendamount;
		}
		//alert(bknums);
	}
	appostamount = appostamount.replace(/,/g,'');
	arpostamount = arpostamount.replace(/,/g,'');
	sppostamount = sppostamount.replace(/,/g,'');
	repostamount = repostamount.replace(/,/g,'');
	expostamount = expostamount.replace(/,/g,'');
	bkpostamount = bkpostamount.replace(/,/g,'');
	apjpostamount = apjpostamount.replace(/,/g,'');
	appendamount = appendamount.replace(/,/g,'');
	arpendamount = arpendamount.replace(/,/g,'');
	sppendamount = sppendamount.replace(/,/g,'');
	rependamount = rependamount.replace(/,/g,'');
	expendamount = expendamount.replace(/,/g,'');
	bkpendamount = bkpendamount.replace(/,/g,'');
	apjpendamount = apjpendamount.replace(/,/g,'');
	totalpostamount = parseFloat(appostamount) + parseFloat(arpostamount)+ parseFloat(sppostamount) + parseFloat(repostamount) + parseFloat(expostamount) + parseFloat(bkpostamount)+ parseFloat(apjpostamount);
	totalpendamount = parseFloat(appendamount) + parseFloat(arpendamount)+ parseFloat(sppendamount) + parseFloat(rependamount) + parseFloat(expendamount) + parseFloat(bkpendamount)+ parseFloat(apjpendamount);
	
	totalpostamount = totalpostamount.toFixed(2);
	totalpostamount = totalpostamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	document.getElementById('totalpostamount').innerHTML = totalpostamount;
	totalpendamount = totalpendamount.toFixed(2);
	totalpendamount = totalpendamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	document.getElementById('totalpendamount').innerHTML = totalpendamount;
}
</script>
<script src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<body>
<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#add8e6"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#add8e6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#add8e6"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	    <tr>
	 <td width="890">
              <form name="cbform1" method="post" action="banktransactions.php" onSubmit="return valid();">
              	 
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
				   
                    <tr>
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext31">
                <div align="left"><strong>Bank Transaction </strong></div></td>
			    </tr>
				<tr>
                        <td colspan="10" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
					<tr>
					
                         <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Bank </td>
                        <td colspan="2" align="left" valign="top"  bgcolor="#FFFFFF" colspan="2" ><!--<input type="text" name="chequebank" id="chequebank">-->
						<select name="bankname" id="bankname">
					<option value="">Select Bank</option>
						<?php 
						
						$querybankname = "select * from master_bank where bankstatus <> 'deleted'";
						$execbankname = mysqli_query($GLOBALS["___mysqli_ston"], $querybankname) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($resbankname = mysqli_fetch_array($execbankname))
						{
						?>
							
							<option value="<?php echo $resbankname['bankcode']; ?>" <?php if($bankname == $resbankname['bankcode']) echo 'selected'; ?>><?php echo $resbankname['bankname'];?></option>
						<?php }
						?>
					</select></td>
					
					<td colspan="2" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3" ><div align="left"><strong></strong></div></td>
                      </tr>
                      
                       <tr>
                     <!--  <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td> -->
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2"   size="10"  readonly="readonly" value="<?= $ADate2;?>" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                        <td colspan="2" bgcolor="#FFFFFF"></td>
                    </tr>
                     <tr>
                     <!--  <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td> -->
                      <td width="25%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Statement Amount </td>
                      <td width="20%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="statementamount" id="statementamount"  value="<?= $statementamount ?>" type="text" size="12" class="stmtamt"/>
                        </span></td>
                        <td colspan="2" bgcolor="#FFFFFF"></td>
                    </tr>
			 		
			 		
				<tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
                    </tr>
                  </tbody>
                </table>
              </form>		</td>
	 </tr>  
	  <tr><td>&nbsp;</td></tr>		        
      <tr>
	  <?php if (isset($_REQUEST["bankname"])) { $bankname = $_REQUEST["bankname"]; } else { $bankname = ""; } ?>
	  <?php if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
	  if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $ADate1 = date('Y-m-d'); }
	  if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $ADate1 = date('Y-m-d'); }
	  if (isset($_REQUEST["statementamount"])) { $statementamount = $_REQUEST["statementamount"]; } else { $statementamount = 0; }
	  // if (isset($_REQUEST["bankname"])) { $bankcode_new = $_REQUEST["bankname"]; } else { $bankcode_new=''; }
			if($cbfrmflag1 == 'cbfrmflag1'){ 
				$query1 = "select bankname from master_bank where bankcode='$bankname'";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						 $bank = $res1["bankname"];
				?>
				 <input type="hidden" name="bankcode_new" value="<?=$bankcode_new;?>">
	  <tr><form id="reconform" action="banktransactions.php" name="checklist" method="post">
        <td><table width="1300" height="80" border="0" 
            align="left" cellpadding="2" cellspacing="0" 
            bordercolor="#666666" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" >
          <tbody>
             <tr>
              <td colspan="13" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong><?php echo $bank; ?></strong></div></td>
			    </tr>
			<?php
			
			$colorloopcount = '';
			$apno = '';
			$totalamount = '0.00';
			$aptotalamount = '0.00';
			$apposttotalamount = '0.00';
			$artotalamount = '0.00';
			$arposttotalamount = '0.00';
			$extotalamount = '0.00';
			$exposttotalamount = '0.00';
			$retotalamount = '0.00';
			$reposttotalamount = '0.00';
			$bktotalamount = '0.00';
			$bkposttotalamount = '0.00';
			$apjtotalamount = '0.00';
			$apjposttotalamount = '0.00';
			$total_credit_amount = 0;
		    $total_debit_amount =  0;
		    
		   
			$bankrecent_date = "";
			$query612 = "select bankdate from bank_record where bankdate <> '' and bankdate <> ' ' and bankdate <>'0000-00-00' and bankdate IS NOT NULL and bankcode = '$bankname' order by bankdate desc limit 0,1";
		    $exec612 = mysqli_query($GLOBALS["___mysqli_ston"], $query612) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		    $numrows = mysqli_num_rows($exec612);
		    if($numrows)
		    {
		    	$res612 = mysqli_fetch_array($exec612);
		    	$bankrecent_date = $res612['bankdate'];
		    }
		    
			//$query1 = "select * from master_transactionpaylater where transactionmodule = 'PAYMENT' and bankname like '%$bankname%' and recordstatus <> 'deallocated' group by docno";
			//$query1 = "select * from master_transactionpaylater where transactionmodule = 'PAYMENT' and bankname like '%$bankname%' and recordstatus <> 'deallocated' and transactiondate <= '$ADate2' group by docno";
			$query1 = "select * from master_transactionpaylater where transactionmodule = 'PAYMENT' and bankcode = '$bankname' and recordstatus <> 'deallocated' and transactiondate <= '$ADate2' group by docno order by transactiondate ASC" ;
			
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$apnums = mysqli_num_rows($exec1);
			//$query41 = "select * from bank_record where notes = 'accounts receivable' and status IN ('Posted','Unpresented','Uncleared')";
			$query41 = "select * from bank_record where notes = 'accounts receivable'";
			$exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die ("Error in Query41".mysqli_error($GLOBALS["___mysqli_ston"]));
			$post41 = mysqli_num_rows($exec41);
			$apnums = $apnums - $post41;
			if(true)
			{?>
			 <tr>
              <td colspan="13" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Account Receivable
			   </strong></div></td>
			    </tr>
	
        <!--     <tr>
			<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sno</strong></div></td>			  
              <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account Name</strong></div></td>
				 <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doc No</strong></div></td>
				<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Inst.No</strong></div></td>
				<td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
				<td width="8%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Posting Date</strong></div></td>
				<td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Posted By</strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Remarks</strong></div></td>
				<td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bank Amount</strong></div></td>
                <td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Debit Amt</strong></div></td>
                <td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Credit Amt</strong></div></td>
				<td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bank Date</strong></div></td>
				
           </tr> -->
           <?php include('bankrecon_header_common.php'); ?>
		   <?php
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$post21='';
			$apaccountname = strtoupper($res1['accountname']);
			$apdocno = $res1['docno'];
			$aptransactiondate =$res1['transactiondate'];
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
			$appostedby = $res1['username'];
			$apremarks = $res1['remarks'];
			// $apbankname = $res1['bankname'];
			$apbankcode = $res1['bankcode'];
			$querybankname1 = "select * from master_bank where bankcode like '$apbankcode' and bankstatus <> 'deleted'";
			$execbankname1 = mysqli_query($GLOBALS["___mysqli_ston"], $querybankname1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resbankname1 = mysqli_fetch_array($execbankname1);
			// $apbankcode = $resbankname1['bankcode'];
			$apbankname = $resbankname1['bankname'];
			$query10 = "select * from paymentmodedebit where billnumber = '$apdocno'";
			$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res10 = mysqli_fetch_array($exec10);
			$appostedby = $res10['username'];
			//$query21 = "select * from bank_record where docno = '$apdocno' and instno = '$apchequeno' and status IN ('Posted','Unpresented','Uncleared')";
			$query21 = "select * from bank_record where docno = '$apdocno' and instno = '$apchequeno'";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res21 = mysqli_fetch_array($exec21);
			$apposttotalamount = $apposttotalamount + $res21['amount'];
			$apposttotalamount = 0;
			$post21 = mysqli_num_rows($exec21);
			if($post21 == 0 || $post21 == ''){
			//$apno = $apno + 1;
			$aptotalamount = $aptotalamount + $aptransactionamount;
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
				$colorcode = 'bgcolor="#5fe5de"';
			}
			$debit_amount = '0.00';
			$credit_amount = '0.00';
			/*$haystack = $apdocno;
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
						}
					}
				}
			}
		    */
			$amount = getcreditdebitor($apdocno,$aptransactionamount);
			$credit_amount = $amount['credit_amount'];
			$debit_amount = $amount['debit_amount'];
			 $total_credit_amount = $total_credit_amount + $credit_amount;
		    $total_debit_amount =  $total_debit_amount  + $debit_amount;
		    if($aptransactionamount!='0.00')
		    {
		    	$apno = $apno + 1;
			?>
            <tr <?php echo $colorcode; ?>>
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $apno; ?></div>
			   <input name="apno<?php echo $apno; ?>" id="apno<?php echo $apno; ?>" value="<?php echo $apno; ?>" type="hidden"/>
			   <input name="apbankname<?php echo $apno; ?>" id="apbankname<?php echo $apno; ?>" type="hidden" value="<?php echo $apbankname; ?>">
			   <input name="apbankcode<?php echo $apno; ?>" id="apbankcode<?php echo $apno; ?>" type="hidden" value="<?php echo $apbankcode; ?>">
			  </td>
			  
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $apaccountname; ?></div>
			  <input name="apaccountname<?php echo $apno; ?>" id="apaccountname<?php echo $apno; ?>" value="<?php echo $apaccountname; ?>" type="hidden"/></td>
			  
			  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $apdocno; ?></div>
			   <input name="apdocno<?php echo $apno; ?>" id="apdocno<?php echo $apno; ?>" value="<?php echo $apdocno; ?>" type="hidden"/></td>
			   
			  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $apchequeno; ?></div>
			  <input name="apchequeno<?php echo $apno; ?>" id="apchequeno<?php echo $apno; ?>" value="<?php echo $apchequeno; ?>" type="hidden"/></td>
			  
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($aptransactionamount,2,'.',','); ?></div>
			   <input name="aptransactionamount<?php echo $apno; ?>" id="aptransactionamount<?php echo $apno; ?>" value="<?php echo $aptransactionamount; ?>" type="hidden"/></td>
			   
              <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $aptransactiondate; ?></div>
			  <input name="aptransactiondate<?php echo $apno; ?>" id="aptransactiondate<?php echo $apno; ?>" value="<?php echo $aptransactiondate; ?>" type="hidden"/></td>   <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $apchequedate; ?></div>
			  <input name="apchequedate<?php echo $apno; ?>" id="apchequedate<?php echo $apno; ?>" value="<?php echo $apchequedate; ?>" type="hidden"/></td>
			   <input name="aprecentdate<?php echo $apno; ?>" id="aprecentdate<?php echo $apno; ?>" value="<?php echo $bankrecent_date; ?>" type="hidden"/>
			  
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $appostedby; ?></div>
			   <input name="appostedby<?php echo $apno; ?>" id="appostedby<?php echo $apno; ?>" value="<?php echo $appostedby; ?>" type="hidden"/></td>
			   
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $apremarks; ?></div>
			   <input name="apremarks<?php echo $apno; ?>" id="apremarks<?php echo $apno; ?>" value="<?php echo $apremarks; ?>" type="hidden"/></td>
			   
			   <td class="bodytext31" valign="center"  align="left"><!-- <div align="left"></div> -->
			   <input name="apbankamount<?php echo $apno; ?>" id="apbankamount<?php echo $apno; ?>" value="<?php echo number_format($aptransactionamount,2,'.',','); ?>" size="10" type="text" readonly onChange="postcalc();"/></td>
			   
			   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($debit_amount,2,'.',','); ?></div>
			   	<input type="hidden" name="apdramt[]" id="apdramt_<?php echo $apno; ?>"  value="<?php echo $debit_amount; ?>">
			  </td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($credit_amount,2,'.',','); ?></div>
			   	<input type="hidden" name="apcramt[]" id="apcramt_<?php echo $apno; ?>"  value="<?php echo $credit_amount; ?>">
			  </td>
			    <td class="bodytext31" valign="center"  align="right"><div align="left"><input name="apdate<?php echo $apno; ?>" id="apdate<?php echo $apno; ?>" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" class="datepicker"  onKeyDown="return disableEnterKey()" />
                 <!-- <img src="images2/cal.gif" onClick="javascript:NewCssCal('apdate<?php echo $apno; ?>')" style="cursor:pointer"/> -->
             </div></td>
				 
				<!-- <td class="bodytext31" valign="center"  align="left"><div align="left">
				<select id="apstatus<?php echo $apno; ?>" name="apstatus<?php echo $apno; ?>" onChange="postcalc();">
				<option value="Pending">Pending</option>
				<option value="Posted">Posted</option>
                <option value="Unpresented">Unpresented</option>
                <option value="Uncleared">Uncleared</option>
				</select>
				</div></td> -->
              </tr>
              
			<?php
		       }
			}
			}
			?>
			<input name="apnums" id="apnums" value="<?php echo $apno; ?>" type="hidden"/>
			<!-- <tr bgcolor="#ecf0f5"><td class="bodytext31" colspan="8" align="right">
			
			<strong>Pending Total:</strong></td><td class="bodytext31" align="right"><strong id="appendamount"><?php echo number_format($aptotalamount,2,'.',','); ?></strong></td>
			<td class="bodytext31" colspan="2" align="right"><strong>Posting Total: </strong></td><td class="bodytext31" align="right"><strong id="appostamount"> <?php echo number_format($apposttotalamount,2,'.',','); ?> </strong></td></tr> -->
			<tr><td colspan="10">&nbsp;</td></tr> 
			 <?php 
			 }
			?>
			<?php
						
			$arno = '';
			//$query2 = "select * from master_transactionpharmacy where transactionmodule = 'PAYMENT' and bankname like '%$bankname%' and recordstatus <> 'deallocated' group by docno";
			//$query2 = "select * from master_transactionpharmacy where transactionmodule = 'PAYMENT' and bankname like '%$bankname%' and recordstatus <> 'deallocated' and transactiondate <= '$ADate2' group by docno";
			 $query2 = "SELECT res.* from ((select IF(chequedate='',transactiondate,chequedate) AS chequedate,suppliername AS suppliername,docno AS docno,transactiondate AS transactiondate,chequenumber AS chequenumber,remarks AS remarks,bankname AS bankname,sum(transactionamount) as transactionamount,'' as username, bankcode as bankcode from master_transactionpharmacy where transactionmodule = 'PAYMENT' and bankcode = '$bankname' and recordstatus <> 'deallocated' and transactiondate <= '$ADate2' group by docno)  
			UNION ALL
			(select IF(chequedate='',transactiondate,chequedate) AS chequedate, doctorname AS suppliername,docno AS docno,transactiondate AS transactiondate,chequenumber AS chequenumber,remarks AS remarks ,bankname AS bankname,sum(netpayable) as transactionamount,'' as username, bankcode as bankcode from master_transactiondoctor where transactionmodule = 'PAYMENT' and bankcode = '$bankname' and recordstatus <> 'deallocated' and transactiondate <= '$ADate2' group by docno)
			UNION ALL
			(select (transactiondate) AS chequedate, ledger_name AS suppliername,docno AS docno,transactiondate AS transactiondate,chequenumber AS chequenumber,remarks AS remarks ,bankname AS bankname,sum(bank_amount-bankcharges) as transactionamount, username as username, bankcode as bankcode from advance_payment_entry where transactionmodule = 'PAYMENT' and bankcode = '$bankname' and recordstatus <> 'deleted' and transactiondate <= '$ADate2' group by docno)
		) res  where res.chequedate <='$ADate2' order by chequedate ASC";
			//echo $query2;exit;
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$arnums = mysqli_num_rows($exec2);
			//$query42 = "select * from bank_record where notes = 'account payable' and status IN ('Posted','Unpresented','Uncleared')";
			$query42 = "select * from bank_record where notes = 'account payable'";
			$exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));
			$post42 = mysqli_num_rows($exec42);
			$arnums = $arnums - $post42;
			if(true)
			{ ?>
			 <tr>
              <td colspan="13" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Account Payable
			   </strong></div></td>
			    </tr>
	
<!-- 
            <tr>
			<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sno</strong></div></td>			  
              <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account Name</strong></div></td>
				 <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doc No</strong></div></td>
				<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Inst.No</strong></div></td>
				<td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
				<td width="8%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Posting Date</strong></div></td>
				<td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Posted By</strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Remarks</strong></div></td>
				<td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bank Amount</strong></div></td>
                 <td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Debit Amount</strong></div></td>
                <td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Credit Amount</strong></div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bank Date</strong></div></td>
				
           </tr> -->
           <?php include('bankrecon_header_common.php'); ?>
		   <?php
			while ($res2 = mysqli_fetch_array($exec2))
			{
			$araccountname = strtoupper($res2['suppliername']);
			$ardocno = $res2['docno'];
			$artransactiondate =$res2['transactiondate'];
			// get total transaction amount 
			$artransactionamount = $res2['transactionamount'];
			$archequeno = $res2['chequenumber'];
			$archequedate = $res2['chequedate'];
			if($archequedate  == ''){
			$archequedate = $artransactiondate;
			}
			//$arpostedby = $res2['username'];
			$arremarks = $res2['remarks'];
			// $arbankname = $res2['bankname'];
			
			// $username123 = $res2['username'];
			$arbankcode = $res2['bankcode'];
			// $querybankname2 = "select * from master_bank where bankname like '%$arbankname%' and bankstatus <> 'deleted'";
			$querybankname2 = "select * from master_bank where bankcode like '$arbankcode' and bankstatus <> 'deleted'";
			$execbankname2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybankname2) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resbankname2 = mysqli_fetch_array($execbankname2);
			$arbankname = $resbankname2['bankname'];
			// $arbankcode = $resbankname2['bankcode'];
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
			$arposttotalamount = $arposttotalamount + $res22['amount'];
			$arposttotalamount = 0;
			$post22 = mysqli_num_rows($exec22);
			if($post22 == 0 || $post22 == ''){
			//$arno = $arno + 1;
			$artotalamount = $artotalamount + $artransactionamount;
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
				$colorcode = 'bgcolor="#5fe5de"';
			}
		
			$amount = getcreditdebitor($ardocno,$artransactionamount);
			$credit_amount = $amount['credit_amount'];
			$debit_amount = $amount['debit_amount'];
			 $total_credit_amount = $total_credit_amount + $credit_amount;
		    $total_debit_amount =  $total_debit_amount  + $debit_amount;
		    if($artransactionamount!='0.00')
		    {
		    	$arno = $arno + 1;
			?>
            <tr <?php echo $colorcode; ?>>
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $arno; ?></div>
			   <input name="arno<?php echo $arno; ?>" id="arno<?php echo $arno; ?>" value="<?php echo $arno; ?>" type="hidden"/>
			   <input name="arbankname<?php echo $arno; ?>" id="arbanknam<?php echo $arno; ?>e" type="hidden" value="<?php echo $arbankname; ?>">
			   <input name="arbankcode<?php echo $arno; ?>" id="arbankcode<?php echo $arno; ?>" type="hidden" value="<?php echo $arbankcode; ?>">
			  </td>
			  
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $araccountname; ?></div>
			  <input name="araccountname<?php echo $arno; ?>" id="araccountname<?php echo $arno; ?>" value="<?php echo $araccountname; ?>" type="hidden"/></td>
			  
			  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $ardocno; ?></div>
			   <input name="ardocno<?php echo $arno; ?>" id="ardocno<?php echo $arno; ?>" value="<?php echo $ardocno; ?>" type="hidden"/></td>
			   
			  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $archequeno; ?></div>
			  <input name="archequeno<?php echo $arno; ?>" id="archequeno<?php echo $arno; ?>" value="<?php echo $archequeno; ?>" type="hidden"/></td>
			  
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($artransactionamount,2,'.',','); ?></div>
			   <input name="artransactionamount<?php echo $arno; ?>" id="artransactionamount<?php echo $arno; ?>" value="<?php echo $artransactionamount; ?>" type="hidden"/></td>
			   
              <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $artransactiondate; ?></div>
			  <input name="artransactiondate<?php echo $arno; ?>" id="artransactiondate<?php echo $arno; ?>" value="<?php echo $artransactiondate; ?>" type="hidden"/></td> 
				<td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $archequedate; ?></div>
			  <input name="archequedate<?php echo $arno; ?>" id="archequedate<?php echo $arno; ?>" value="<?php echo $archequedate; ?>" type="hidden"/></td>
			   <input name="arrecentdate<?php echo $arno; ?>" id="arrecentdate<?php echo $arno; ?>" value="<?php echo $bankrecent_date; ?>" type="hidden"/>
			  
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $arpostedby; ?></div>
			   <input name="arpostedby<?php echo $arno; ?>" id="arpostedby<?php echo $arno; ?>" value="<?php echo $arpostedby; ?>" type="hidden"/></td>
			   
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $arremarks; ?></div>
			   <input name="arremarks<?php echo $arno; ?>" id="arremarks<?php echo $arno; ?>" value="<?php echo $arremarks; ?>" type="hidden"/></td>
			   
			   <td class="bodytext31" valign="center"  align="left"><div align="left">
			   <input name="arbankamount<?php echo $arno; ?>" id="arbankamount<?php echo $arno; ?>" size="10" value="<?php echo number_format($artransactionamount,2,'.',','); ?>" type="text" readonly onChange="postcalc();"/></td>
			      <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($debit_amount,2,'.',','); ?></div>
			      	<input type="hidden" name="ardramt[]" id="ardramt_<?php echo $arno; ?>"  value="<?php echo $debit_amount; ?>">
			  </td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($credit_amount,2,'.',','); ?></div>
			   	<input type="hidden" name="arcramt[]" id="arcramt_<?php echo $arno; ?>"  value="<?php echo $credit_amount; ?>">
			  </td>
			    <td class="bodytext31" valign="center"  align="left"><div align="left"><input name="ardate<?php echo $arno; ?>" id="ardate<?php echo $arno; ?>" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" class="datepicker" onclick="showvalid_dates('receivables',<?php echo $arno; ?>)" onKeyDown="return disableEnterKey()" />
                <!--  <img src="images2/cal.gif" onClick="javascript:NewCssCal('ardate<?php echo $arno; ?>')" style="cursor:pointer"/> --></div></td>
				 
				<!-- <td class="bodytext31" valign="center"  align="left"><div align="left">
				<select id="arstatus<?php echo $arno; ?>" name="arstatus<?php echo $arno; ?>" onChange="postcalc();">
				<option value="Pending">Pending</option>
				<option value="Posted">Posted</option>
                <option value="Unpresented">Unpresented</option>
                <option value="Uncleared">Uncleared</option>
				</select>
				</div></td> -->
              </tr>
              
			<?php
			   }
			}
			}
			?>
			<input name="arnums" id="arnums" value="<?php echo $arno; ?>" type="hidden"/>
			<!-- <tr bgcolor="#ecf0f5"><td class="bodytext31" colspan="8" align="right">
			
			<strong>Pending Total:</strong></td><td class="bodytext31" align="right"><strong  id="arpendamount"><?php echo number_format($artotalamount,2,'.',','); ?></strong></td>
			<td class="bodytext31" colspan="2" align="right"><strong></strong></td><td class="bodytext31" align="right"><strong id="arpostamount"><?php echo number_format($arposttotalamount,2,'.',','); ?> </strong></td></tr> -->
			<tr><td colspan="10">&nbsp;</td></tr>
			 <?php 
			 }
			?>
			
			
			<?php
			$spno = '';
			$sptotalamount = 0;
			$query2sp = "SELECT * from supplier_debits where  ledger_id = '$bankname'  and invoice_date <= '$ADate2' group by invoice_id ";
			$exec2sp = mysqli_query($GLOBALS["___mysqli_ston"], $query2sp) or die ("Error in Query1sp".mysqli_error($GLOBALS["___mysqli_ston"]));
			$arnumssp = mysqli_num_rows($exec2sp);
			$query42sp = "select * from bank_record where notes = 'account payable'";
			$exec42sp = mysqli_query($GLOBALS["___mysqli_ston"], $query42sp) or die ("Error in Query42sp".mysqli_error($GLOBALS["___mysqli_ston"]));
			$post42sp = mysqli_num_rows($exec42sp);
			$arnums = $arnumssp - $post42sp;
			if(true)
			{ 
			?>		
				<tr>
					<td colspan="13" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Supplier D.Note</strong></div></td>
				</tr>
				<?php include('bankrecon_header_common.php'); ?>
			
			<?php
			while ($res2sp = mysqli_fetch_array($exec2sp))
			{
			$spaccountid = $res2sp['supplier_id'];
			$spdocno = $res2sp['invoice_id'];
			$sptransactiondate =$res2sp['invoice_date'];
			$sptransactionamount = $res2sp['fx_total_amount'];		
			$spchequedate = $artransactiondate;
			$spremarks = $res2sp['item_name'];
			$spbankcode = $res2sp['ledger_id'];
			$username123 = $res2sp['user_id'];
			$instid = $res2sp['auto_number'];
			$spchequeno = $res2sp['ref_number'];
			$sppostedby=$username123;
			
			$querybankname2 = "select * from master_bank where bankcode like '$spbankcode' and bankstatus <> 'deleted'";
			$execbankname2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybankname2) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resbankname2 = mysqli_fetch_array($execbankname2);
			$spbankname = $resbankname2['bankname'];
			
			$querybankname21 = "select accountname from master_accountname where id = '$spaccountid'";
			$execbankname21 = mysqli_query($GLOBALS["___mysqli_ston"], $querybankname21) or die ("Error in querybankname21".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resbankname21 = mysqli_fetch_array($execbankname21);
			$spaccountname = $resbankname21['accountname'];
			
			
			$query22 = "select * from bank_record where docno = '$spdocno' and instno = '$instid'";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22);
			$arposttotalamount = $arposttotalamount + $res22['amount'];
			$arposttotalamount = 0;
			$post22 = mysqli_num_rows($exec22);
			if($post22 == 0 || $post22 == ''){
			$sptotalamount = $sptotalamount + $sptransactionamount;
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				$colorcode = 'bgcolor="#5fe5de"';
			}
		
			/* $amount = getcreditdebitor($spdocno,$sptransactionamount); */
			$credit_amount = $sptransactionamount;
			$debit_amount = 0;
			$total_credit_amount = $total_credit_amount + 0;
		    $total_debit_amount =  $total_debit_amount  + $sptransactionamount;
		    if($sptransactionamount!='0.00')
		    {
		    $spno = $spno + 1;
			?>
			
			 <tr <?php echo $colorcode; ?>>
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $spno; ?></div>
			   <input name="spno<?php echo $spno; ?>" id="spno<?php echo $spno; ?>" value="<?php echo $spno; ?>" type="hidden"/>
			   <input name="spbankname<?php echo $spno; ?>" id="spbanknam<?php echo $spno; ?>e" type="hidden" value="<?php echo $spbankname; ?>">
			   <input name="spbankcode<?php echo $spno; ?>" id="spbankcode<?php echo $spno; ?>" type="hidden" value="<?php echo $spbankcode; ?>">
			  </td>
			  
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $spaccountname; ?></div>
			  <input name="spaccountname<?php echo $spno; ?>" id="spaccountname<?php echo $spno; ?>" value="<?php echo $spaccountname; ?>" type="hidden"/></td>
			  
			  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $spdocno; ?></div>
			   <input name="spdocno<?php echo $spno; ?>" id="spdocno<?php echo $spno; ?>" value="<?php echo $spdocno; ?>" type="hidden"/></td>
			   
			  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $spchequeno; ?></div>
			  <input name="spchequeno<?php echo $spno; ?>" id="spchequeno<?php echo $spno; ?>" value="<?php echo $instid; ?>" type="hidden"/></td>
			  
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($sptransactionamount,2,'.',','); ?></div>
			   <input name="sptransactionamount<?php echo $spno; ?>" id="sptransactionamount<?php echo $spno; ?>" value="<?php echo $sptransactionamount; ?>" type="hidden"/></td>
			   
              <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $sptransactiondate; ?></div>
			  <input name="sptransactiondate<?php echo $spno; ?>" id="sptransactiondate<?php echo $spno; ?>" value="<?php echo $sptransactiondate; ?>" type="hidden"/></td> 
				<td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $spchequedate; ?></div>
			  <input name="spchequedate<?php echo $spno; ?>" id="spchequedate<?php echo $spno; ?>" value="<?php echo $spchequedate; ?>" type="hidden"/></td>
			   <input name="sprecentdate<?php echo $spno; ?>" id="sprecentdate<?php echo $spno; ?>" value="<?php echo $bankrecent_date; ?>" type="hidden"/>
			  
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sppostedby; ?></div>
			   <input name="sppostedby<?php echo $spno; ?>" id="sppostedby<?php echo $spno; ?>" value="<?php echo $sppostedby; ?>" type="hidden"/></td>
			   
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $spremarks; ?></div>
			   <input name="spremarks<?php echo $spno; ?>" id="spremarks<?php echo $spno; ?>" value="<?php echo $spremarks; ?>" type="hidden"/></td>
			   
			   <td class="bodytext31" valign="center"  align="left"><div align="left">
			   <input name="spbankamount<?php echo $spno; ?>" id="spbankamount<?php echo $spno; ?>" size="10" value="<?php echo number_format($sptransactionamount,2,'.',','); ?>" type="text" readonly onChange="postcalc();"/></td>
			      <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($debit_amount,2,'.',','); ?></div>
			      	<input type="hidden" name="spdramt[]" id="spdramt_<?php echo $spno; ?>"  value="<?php echo $debit_amount; ?>">
			  </td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($credit_amount,2,'.',','); ?></div>
			   	<input type="hidden" name="spcramt[]" id="spcramt_<?php echo $spno; ?>"  value="<?php echo $credit_amount; ?>">
			  </td>
			    <td class="bodytext31" valign="center"  align="left"><div align="left"><input name="spdate<?php echo $spno; ?>" id="spdate<?php echo $spno; ?>" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" class="datepicker" onclick="showvalid_dates('supplier',<?php echo $spno; ?>)" onKeyDown="return disableEnterKey()" />
              
              </tr>
			
			
			
			
			<?php } } } 
			
			?>
			<input name="spnums" id="spnums" value="<?php echo $spno; ?>" type="hidden"/>
			<tr><td colspan="10">&nbsp;</td></tr>
			<?php
			} ?>
			
			
			
			
			<?php
			
			
			$exno = '';
			
			//$query3 = "select * from expensesub_details where bankname like '%$bankname%' and recordstatus <> 'deallocated' and transactiondate <='$ADate2' group by docnumber";
			$query3 = "select * from expensesub_details where bankcode = '$bankname' and recordstatus <> 'deallocated' and transactiondate <='$ADate2' group by docnumber order by transactiondate ASC";
			
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$exnums = mysqli_num_rows($exec3);
			//$query43 = "select * from bank_record where notes = 'expenses' and status IN ('Posted','Unpresented','Uncleared')";
			$query43 = "select * from bank_record where notes = 'expenses'";
			$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die ("Error in Query43".mysqli_error($GLOBALS["___mysqli_ston"]));
			$post43 = mysqli_num_rows($exec43);
			$exnums = $exnums - $post43;
			if(true)
			{?>
			 <tr>
              <td colspan="13" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Expenses
			   </strong></div></td>
			    </tr>
	
<!-- 
            <tr>
			<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sno</strong></div></td>			  
              <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account Name</strong></div></td>
				 <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doc No</strong></div></td>
				<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Inst.No</strong></div></td>
				<td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
				<td width="8%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Posting Date</strong></div></td>
				<td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Posted By</strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Remarks</strong></div></td>
				<td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bank Amount</strong></div></td>
                 <td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Debit Amount</strong></div></td>
                <td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Credit Amount</strong></div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bank Date</strong></div></td>
				
           </tr> -->
           <?php include('bankrecon_header_common.php'); ?>
		   <?php
			while ($res3 = mysqli_fetch_array($exec3))
			{
			
			$exdocno = $res3['docnumber'];
			$extransactiondate =$res3['transactiondate'];
			$extransactionamount = $res3['transactionamount'];
			$exchequeno = $res3['chequenumber'];
			$expostedby = $res3['username'];
			$exremarks = $res3['remarks'];
			$exaccountnamecoa = $res3['expensecoa'];
			// $exbankname = $res3['bankname'];
			$exbankcode = $res3['bankcode'];
			// $querybankname3 = "select * from master_bank where bankname like '%$exbankname%' and bankstatus <> 'deleted'";
			$querybankname3 = "select * from master_bank where bankcode like '$exbankcode' and bankstatus <> 'deleted'";
			$execbankname3 = mysqli_query($GLOBALS["___mysqli_ston"], $querybankname3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resbankname3 = mysqli_fetch_array($execbankname3);
			// $exbankcode = $resbankname3['bankcode'];
			$exbankname = $resbankname3['bankname'];
			$query8 = "select * from master_accountname where id = '$exaccountnamecoa'";
			$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res8 = mysqli_fetch_array($exec8);
			$exaccountname = strtoupper($res8['accountname']);
			//$query23 = "select * from bank_record where docno = '$exdocno' and instno = '$exchequeno' and status IN ('Posted','Unpresented','Uncleared')";
			$query23 = "select * from bank_record where docno = '$exdocno' and instno = '$exchequeno'";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res23 = mysqli_fetch_array($exec23);
			$exposttotalamount = $exposttotalamount + $res23['amount'];
			$exposttotalamount = 0;
			$post23 = mysqli_num_rows($exec23);
			if($post23 == 0 || $post23 == ''){
			//$exno = $exno + 1;
			$extotalamount = $extotalamount + $extransactionamount;
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
				$colorcode = 'bgcolor="#5fe5de"';
			}
		
			$amount = getcreditdebitor($exdocno,$extransactionamount);
			$credit_amount = $amount['credit_amount'];
			$debit_amount = $amount['debit_amount'];
			 $total_credit_amount = $total_credit_amount + $credit_amount;
		    $total_debit_amount =  $total_debit_amount  + $debit_amount;
		    
		    if($extransactionamount!='0.00')
		    {
		    	$exno = $exno + 1;
			?>
            <tr <?php echo $colorcode; ?>>
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $exno; ?></div>
			   <input name="exno<?php echo $exno; ?>" id="exno<?php echo $exno; ?>" value="<?php echo $exno; ?>" type="hidden"/> 
			   <input name="exbankname<?php echo $exno; ?>" id="exbankname<?php echo $exno; ?>" type="hidden" value="<?php echo $exbankname; ?>">
			   <input name="exbankcode<?php echo $exno; ?>" id="exbankcode<?php echo $exno; ?>" type="hidden" value="<?php echo $exbankcode; ?>">
			   </td>
			   
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $exaccountname; ?></div>
			  <input name="exaccountname<?php echo $exno; ?>" id="exaccountname<?php echo $exno; ?>" value="<?php echo $exaccountname; ?>" type="hidden"/></td>
			  
			  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $exdocno; ?></div>
			   <input name="exdocno<?php echo $exno; ?>" id="exdocno<?php echo $exno; ?>" value="<?php echo $exdocno; ?>" type="hidden"/></td>
			   
			  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $exchequeno; ?></div>
			  <input name="exchequeno<?php echo $exno; ?>" id="exchequeno<?php echo $exno; ?>" value="<?php echo $exchequeno; ?>" type="hidden"/></td>
			  
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($extransactionamount,2,'.',','); ?></div>
			   <input name="extransactionamount<?php echo $exno; ?>" id="extransactionamount<?php echo $exno; ?>" value="<?php echo $extransactionamount; ?>" type="hidden"/></td>
			   
              <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $extransactiondate; ?></div>
			  <input name="extransactiondate<?php echo $exno; ?>" id="extransactiondate<?php echo $exno; ?>" value="<?php echo $extransactiondate; ?>" type="hidden"/></td>
			  <input name="exrecentdate<?php echo $exno; ?>" id="exrecentdate<?php echo $exno; ?>" value="<?php echo $bankrecent_date; ?>" type="hidden"/>
              <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $extransactiondate; ?></div></td>
			  
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $expostedby; ?></div>
			   <input name="expostedby<?php echo $exno; ?>" id="expostedby<?php echo $exno; ?>" value="<?php echo $expostedby; ?>" type="hidden"/></td>
			   
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $exremarks; ?></div>
			   <input name="exremarks<?php echo $exno; ?>" id="exremarks<?php echo $exno; ?>" value="<?php echo $exremarks; ?>" type="hidden"/></td>
			   
			   <td class="bodytext31" valign="center"  align="left"><div align="left">
			   <input name="exbankamount<?php echo $exno; ?>" id="exbankamount<?php echo $exno; ?>" size="10" value="<?php echo number_format($extransactionamount,2,'.',','); ?>" readonly onChange="postcalc();" type="text"/></td>
			      <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($debit_amount,2,'.',','); ?></div>
			      	<input type="hidden" name="exdramt[]" id="exdramt_<?php echo $exno; ?>"  value="<?php echo $debit_amount; ?>">
			  </td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($credit_amount,2,'.',','); ?></div>
			   		<input type="hidden" name="excramt[]" id="excramt_<?php echo $exno; ?>"  value="<?php echo $credit_amount; ?>">
			  </td>
			    <td class="bodytext31" valign="center"  align="left"><div align="left"><input name="exdate<?php echo $exno; ?>" id="exdate<?php echo $exno; ?>" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" class="datepicker" onclick="showvalid_dates('expenses',<?php echo $exno; ?>)" onKeyDown="return disableEnterKey()" />
                 <!-- <img src="images2/cal.gif" onClick="javascript:NewCssCal('exdate<?php echo $exno; ?>')" style="cursor:pointer"/> --></div></td>
				 
				<!-- <td class="bodytext31" valign="center"  align="left"><div align="left">
				<select id="exstatus<?php echo $exno; ?>" name="exstatus<?php echo $exno; ?>" onChange="postcalc();">
				<option value="Pending">Pending</option>
				<option value="Posted">Posted</option>
                <option value="Unpresented">Unpresented</option>
                <option value="Uncleared">Uncleared</option>
				</select>
				</div></td> -->
              </tr>
              
			<?php
		       }
			}
			}
			?>
			<input name="exnums" id="exnums" value="<?php echo $exno; ?>" type="hidden"/>
			<!-- <tr bgcolor="#ecf0f5"><td class="bodytext31" colspan="8" align="right">
			
			<strong>Pending Total:</strong></td><td class="bodytext31" align="right"><strong id="expendamount"><?php echo number_format($extotalamount,2,'.',','); ?></strong></td>
			<td class="bodytext31" colspan="2" align="right"><strong> Posting Total: </strong></td><td class="bodytext31" align="right"><strong id="expostamount"> <?php echo number_format($exposttotalamount,2,'.',','); ?> </strong></td></tr> -->
			<tr><td colspan="12">&nbsp;</td></tr>
			<?php 
			 }
			?>
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
			 <tr>
              <td colspan="13" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Receipts
			   </strong></div></td>
			    </tr>
	
           <!--  <tr>
			<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sno</strong></div></td>			  
              <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account Name</strong></div></td>
				 <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doc No</strong></div></td>
				<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Inst.No</strong></div></td>
				<td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
				<td width="8%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Posting Date</strong></div></td>
				<td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Posted By</strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Remarks</strong></div></td>
				<td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bank Amount</strong></div></td>
                 <td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Debit Amt</strong></div></td>
                <td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Credit Amt</strong></div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bank Date</strong></div></td>
			
           </tr> -->
           <?php include('bankrecon_header_common.php'); ?>
		   <?php
			while ($res4 = mysqli_fetch_array($exec4))
			{
			
			$redocno = $res4['docnumber'];
			$retransactiondate =$res4['transactiondate'];
			$retransactionamount = $res4['transactionamount'];
			$rechequeno = $res4['chequenumber'];
			$repostedby = $res4['username'];
			$reremarks = $res4['remarks'];
			$reaccountnamecoa = $res4['receiptcoa'];
			// $rebankname = $res4['bankname'];
			$rebankcode = $res4['bankcode'];
			$querybankname4 = "select * from master_bank where bankcode like '$rebankcode' and bankstatus <> 'deleted'";
			$execbankname4 = mysqli_query($GLOBALS["___mysqli_ston"], $querybankname4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resbankname4 = mysqli_fetch_array($execbankname4);
			// $rebankcode = $resbankname4['bankcode'];
			$rebankname = $resbankname4['bankname'];
			$query9 = "select * from master_accountname where id = '$reaccountnamecoa'";
			$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res9 = mysqli_fetch_array($exec9);
			$reaccountname = strtoupper($res9['accountname']);
			//$query24 = "select * from bank_record where docno = '$redocno' and instno = '$rechequeno' and status IN ('Posted','Unpresented','Uncleared')";
			$query24 = "select * from bank_record where docno = '$redocno' and instno = '$rechequeno'";
			$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res24 = mysqli_fetch_array($exec24);
			$reposttotalamount = $reposttotalamount + $res24['amount'];
			$reposttotalamount = 0;
			$post24 = mysqli_num_rows($exec24);
			if($post24 == 0 || $post24 == ''){
			//$reno = $reno + 1;
			$retotalamount = $retotalamount + $retransactionamount;
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
				$colorcode = 'bgcolor="#5fe5de"';
			}
		
			$amount = getcreditdebitor($redocno,$retransactionamount);
			$credit_amount = $amount['credit_amount'];
			$debit_amount = $amount['debit_amount'];
			 $total_credit_amount = $total_credit_amount + $credit_amount;
		    $total_debit_amount =  $total_debit_amount  + $debit_amount;
		    
		    if($retransactionamount!='0.00')
		    {
		    	$reno = $reno + 1;
			?>
            <tr <?php echo $colorcode; ?>>
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $reno; ?></div>
			   <input name="reno<?php echo $reno; ?>" id="reno<?php echo $reno; ?>" value="<?php echo $reno; ?>" type="hidden"/>
			   <input name="rebankname<?php echo $reno; ?>" id="rebankname<?php echo $reno; ?>" type="hidden" value="<?php echo $rebankname; ?>">
			   <input name="rebankcode<?php echo $reno; ?>" id="rebankcode<?php echo $reno; ?>" type="hidden" value="<?php echo $rebankcode; ?>">
			  </td>
			  
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $reaccountname; ?></div>
			  <input name="reaccountname<?php echo $reno; ?>" id="reaccountname<?php echo $reno; ?>" value="<?php echo $reaccountname; ?>" type="hidden"/></td>
			  
			  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $redocno; ?></div>
			   <input name="redocno<?php echo $reno; ?>" id="redocno<?php echo $reno; ?>" value="<?php echo $redocno; ?>" type="hidden"/></td>
			   
			  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $rechequeno; ?></div>
			  <input name="rechequeno<?php echo $reno; ?>" id="rechequeno<?php echo $reno; ?>" value="<?php echo $rechequeno; ?>" type="hidden"/></td>
			  
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($retransactionamount,2,'.',','); ?></div>
			   <input name="retransactionamount<?php echo $reno; ?>" id="retransactionamount<?php echo $reno; ?>" value="<?php echo $retransactionamount; ?>" type="hidden"/></td>
			   
              <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $retransactiondate; ?></div>
			  <input name="retransactiondate<?php echo $reno; ?>"  id="retransactiondate<?php echo $reno; ?>" value="<?php echo $retransactiondate; ?>" type="hidden"/></td>
			   
			  <input name="rerecentdate<?php echo $reno; ?>"  id="rerecentdate<?php echo $reno; ?>" value="<?php echo $bankrecent_date; ?>" type="hidden"/>
              <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $retransactiondate; ?></div></td>
			  
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $repostedby; ?></div>
			   <input name="repostedby<?php echo $reno; ?>" id="repostedby<?php echo $reno; ?>" value="<?php echo $repostedby; ?>" type="hidden"/></td>
			   
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $reremarks; ?></div>
			   <input name="reremarks<?php echo $reno; ?>" id="reremarks<?php echo $reno; ?>" value="<?php echo $reremarks; ?>" type="hidden"/></td>
			   
			   <td class="bodytext31" valign="center"  align="left"><div align="left">
			   <input name="rebankamount<?php echo $reno; ?>" id="rebankamount<?php echo $reno; ?>" size="10" value="<?php echo number_format($retransactionamount,2,'.',','); ?>" readonly onChange="postcalc();" type="text"/></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($debit_amount,2,'.',','); ?></div>
			   	<input type="hidden" name="redramt[]" id="redramt_<?php echo $reno; ?>"  value="<?php echo $debit_amount; ?>">
			  </td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($credit_amount,2,'.',','); ?></div>
			   	<input type="hidden" name="recramt[]" id="recramt_<?php echo $reno; ?>"  value="<?php echo $credit_amount; ?>">
			  </td>
			    <td class="bodytext31" valign="center"  align="left"><div align="left"><input name="redate<?php echo $reno; ?>" id="redate<?php echo $reno; ?>" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" class="datepicker" onclick="showvalid_dates('receipts',<?php echo $reno; ?>)" />
                 <!-- <img src="images2/cal.gif" onClick="javascript:NewCssCal('redate<?php echo $reno; ?>')" style="cursor:pointer"/> --></div></td>
				 
				<!-- <td class="bodytext31" valign="center"  align="left"><div align="left">
				<select id="restatus<?php echo $reno; ?>" name="restatus<?php echo $reno; ?>" onChange="postcalc();">
				<option value="Pending">Pending</option>
				<option value="Posted">Posted</option>
                <option value="Unpresented">Unpresented</option>
                <option value="Uncleared">Uncleared</option>
				</select>
				</div></td> -->
              </tr>
              
			<?php
		       }
			}
			}
			?>
			<input name="renums" id="renums" value="<?php echo $reno; ?>" type="hidden"/>
		<!-- 	<tr bgcolor="#ecf0f5"><td class="bodytext31" colspan="8" align="right">
			
			<strong>Pending Total:</strong></td><td class="bodytext31" align="right"><strong id="rependamount"><?php echo number_format($retotalamount,2,'.',','); ?></strong></td>
			<td class="bodytext31" colspan="2" align="right"><strong>Posting Total: </strong></td><td class="bodytext31" align="right"><strong id="repostamount"> <?php echo number_format($reposttotalamount,2,'.',','); ?></strong></td></tr> -->
			<tr><td colspan="13">&nbsp;</td></tr>
			<?php 
			 }
			?>
<?php			
			////////////////////////////JOURNAL ENTRIES////////////////////////////////////	
						$apjno = '';
			 $query1 = "select *,sum(transactionamount) as trn_amount from master_journalentries where entrydate <= '$ADate2' and ledgerid like '%$bankname%'  group by docno,selecttype order by entrydate ASC";
			  
			 
			 
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $apjnums = mysqli_num_rows($exec1);
	
			$query41 = "select * from bank_record where notes = 'journal entries' and status IN ('Posted','Unpresented','Uncleared')";
			$exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die ("Error in Query41".mysqli_error($GLOBALS["___mysqli_ston"]));
			$post41 = mysqli_num_rows($exec41);
			//$apjnums = $apjnums - $post41;
			
			if(1)
			{?>
			 <tr>
              <td colspan="13" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Journals
			   </strong></div></td>
			    </tr>
	
<!--             <tr>
			<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sno</strong></div></td>			  
              <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account Name</strong></div></td>
				 <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doc No</strong></div></td>
				<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Type</strong></div></td>
				<td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
				<td width="8%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Posting Date</strong></div></td>
				<td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Posted By</strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Remarks</strong></div></td>
				<td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bank Amount</strong></div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bank Date</strong></div></td>
				<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Status</strong></div></td>
           </tr> -->
           <?php include('bankrecon_header_common.php'); ?>
		   <?php
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$post21='';
			$apaccountname = 'JOURNALS';
			$apdocno = $res1['docno'];
			$aptransactiondate =$res1['entrydate'];
			$aptransactionamount = $res1['trn_amount'];
			$apselecttype= $res1['selecttype'];
			if($apselecttype =='Cr'){
				$aptransactionamount = '-'.$aptransactionamount ;
				
			}
			else{
				$aptransactionamount  = $aptransactionamount;
				
			}
			
			$apchequeno =$apselecttype;
			//$apchequeno = $res1['chequenumber'];
			$appostedby = $res1['username'];
			$apremarks = $res1['narration'];
			$apbankname = $res1['ledgername'];
			$apbankcode = $res1['ledgerid'];
			
			$query210 = "select * from bank_record where docno = '$apdocno' and instno = '$apselecttype' and status IN ('Unpresented','Uncleared')";
			$exec210 = mysqli_query($GLOBALS["___mysqli_ston"], $query210) or die ("Error in Query210".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res210 = mysqli_fetch_array($exec210);
			$apbrstatus = $res210['status'];
			$apbrbankdate = $res210['bankdate'];
			
			
			//and instno = '$apchequeno'
			$query21 = "select * from bank_record where docno = '$apdocno' and instno = '$apselecttype' and bankcode='$bankname' ";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res21 = mysqli_fetch_array($exec21);
			$apposttotalamount = $apposttotalamount + $res21['amount'];
			$apposttotalamount = 0;
			$post21 = mysqli_num_rows($exec21);
			if($post21 <= 0){
			
			//$apjno = $apjno + 1;
			$apjtotalamount = $apjtotalamount + $aptransactionamount;
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
				$colorcode = 'bgcolor="#5fe5de"';
			}
		
			$amount = getcreditdebitor($apdocno,$aptransactionamount);
			$credit_amount = $amount['credit_amount'];
			$debit_amount = $amount['debit_amount'];
			 $total_credit_amount = $total_credit_amount + $credit_amount;
		    $total_debit_amount =  $total_debit_amount  + $debit_amount;
		    if($aptransactionamount!='0.00')
		    {
		    	$apjno = $apjno + 1;
			?>
            <tr <?php echo $colorcode; ?>>
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $apjno; ?></div>
			   <input name="apjno<?php echo $apjno; ?>" id="apjno<?php echo $apjno; ?>" value="<?php echo $apjno; ?>" type="hidden"/>
			   <input name="apjbankname<?php echo $apjno; ?>" id="apjbankname<?php echo $apjno; ?>" type="hidden" value="<?php echo $apbankname; ?>">
			   <input name="apjbankcode<?php echo $apjno; ?>" id="apjbankcode<?php echo $apjno; ?>" type="hidden" value="<?php echo $apbankcode; ?>">
			  </td>
			  
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $apaccountname; ?></div>
			  <input name="apjaccountname<?php echo $apjno; ?>" id="apjaccountname<?php echo $apjno; ?>" value="<?php echo $apaccountname; ?>" type="hidden"/></td>
			  
			  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $apdocno; ?></div>
			   <input name="apjdocno<?php echo $apjno; ?>" id="apjdocno<?php echo $apjno; ?>" value="<?php echo $apdocno; ?>" type="hidden"/></td>
			   
			  <td class="bodytext31" valign="center"  align="left"><div align="left"></div>
			  <input name="apjchequeno<?php echo $apjno; ?>" id="apjchequeno<?php echo $apjno; ?>" value="<?php echo $apchequeno; ?>" type="hidden"/></td>
			  
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(abs($aptransactionamount),2,'.',','); ?></div>
			   <input name="apjtransactionamount<?php echo $apjno; ?>" id="apjtransactionamount<?php echo $apjno; ?>" value="<?php echo $aptransactionamount; ?>" type="hidden"/></td>
			   
              <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $aptransactiondate; ?></div>
			  <input name="apjtransactiondate<?php echo $apjno; ?>" id="apjtransactiondate<?php echo $apjno; ?>" value="<?php echo $aptransactiondate; ?>" type="hidden"/></td>
			  <input name="apjrecentdate<?php echo $apjno; ?>" id="apjrecentdate<?php echo $apjno; ?>" value="<?php echo $bankrecent_date; ?>" type="hidden"/>
              <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $aptransactiondate; ?></div></td>
			  
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $appostedby; ?></div>
			   <input name="apjpostedby<?php echo $apjno; ?>" id="apjpostedby<?php echo $apjno; ?>" value="<?php echo $appostedby; ?>" type="hidden"/></td>
			   
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $apremarks; ?></div>
			   <input name="apjremarks<?php echo $apjno; ?>" id="apjremarks<?php echo $apjno; ?>" value="<?php echo $apremarks; ?>" type="hidden"/></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="left">
			   <input name="apjbankamount<?php echo $apjno; ?>" id="apjbankamount<?php echo $apjno; ?>" size="10" value="<?php echo number_format($aptransactionamount,2,'.',','); ?>" readonly onChange="postcalc();" type="hidden"/>
			   <input name="apjbankamounta<?php echo $apjno; ?>" id="apjbankamounta<?php echo $apjno; ?>" size="10" value="<?php echo number_format(abs($aptransactionamount),2,'.',','); ?>" readonly type="text"/></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php  if($aptransactionamount>0) { echo number_format(abs($aptransactionamount),2); } else { echo "0.00"; } ?></div>
			   	<input type="hidden" name="apjdramt[]" id="apjdramt_<?php echo $apjno; ?>"  value="<?php if($aptransactionamount>0) { echo abs($aptransactionamount); } else { echo "0.00"; } ?>">
			   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php if($aptransactionamount<0) { echo number_format(abs($aptransactionamount),2); }  else { echo "0.00"; } ?></div></td>
			   <input type="hidden" name="apjcramt[]" id="apjcramt_<?php echo $apjno; ?>"  value="<?php if($aptransactionamount<0) { echo abs($aptransactionamount); } else { echo "0.00"; } ?>">
			   			    <td class="bodytext31" valign="center"  align="left"><div align="left"><input name="apjdate<?php echo $apjno; ?>" id="apjdate<?php echo $apjno; ?>" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" class="datepicker" onclick="showvalid_dates('journals',<?php echo $apjno; ?>)" />
				 
              </tr>
              
			<?php
			  }	
			}
			}
			?>
			<input name="apjnums" id="apjnums" value="<?php echo $apjno; ?>" type="hidden"/>
						<tr><td colspan="13">&nbsp;</td></tr>
			 <?php 
			 }
			 //done
			 ?>
			<?php
						
			$bkno = '';
			
			//$query5 = "select * from bankentryform where (bankname like '%$bankname%' or frombankname like '%$bankname%') and transactiondate <='$ADate2' group by docnumber";
			$query5 = "select * from bankentryform where (tobankid = '$bankname' or frombankid = '$bankname') and transactiondate <='$ADate2' group by docnumber order by transactiondate ASC";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$bknums = mysqli_num_rows($exec5);
			//$query45 = "select * from bank_record where notes = 'misc' and status IN ('Posted','Unpresented','Uncleared')";
			$query45 = "select * from bank_record where notes = 'misc'";
			$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die ("Error in Query45".mysqli_error($GLOBALS["___mysqli_ston"]));
			$post45 = mysqli_num_rows($exec45);
			$bknums = $bknums - $post45;
			if(true)
			{ ?>
			 <tr>
              <td colspan="13" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Bank Entries
			   </strong></div></td>
			    </tr>
	
          <!--   <tr>
			<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sno</strong></div></td>			  
              <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account Name</strong></div></td>
				 <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doc No</strong></div></td>
				<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Inst.No</strong></div></td>
				<td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
				<td width="8%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Posting Date</strong></div></td>
				<td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Posted By</strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Remarks</strong></div></td>
				<td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bank Amount</strong></div></td>
                 <td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Debit Amt</strong></div></td>
                <td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Credit Amt</strong></div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bank Date</strong></div></td>
				
           </tr> -->
           <?php include('bankrecon_header_common.php'); ?>
		   <?php
			while ($res5 = mysqli_fetch_array($exec5))
			{
			
			$bkdocno = $res5['docnumber'];
			$bktransactiondate =$res5['transactiondate'];
			$dramount = $res5['amount'];
			$cramount = $res5['creditamount'];
			$bktransactionamount = $cramount + $dramount;
			
			$bkchequeno = $res5['chequenumber'];
			if($dramount > 0)
			{
				$bktransactionamount = $dramount;
				if($bkchequeno =='')
				{
					$bkchequeno = 'Dr';
				}
			}
			else
			{
				$bktransactionamount = '-'.$cramount;
				if($bkchequeno =='')
				{
					$bkchequeno = 'Cr';
				}
			}
			$bkpostedby = $res5['personname'];
			$bkremarks = $res5['remarks'];
			$bkbankname = $res5['bankname'];		
			$querybankname5 = "select * from master_bank where bankname like '%$bkbankname%' and bankstatus <> 'deleted'";
			$execbankname5 = mysqli_query($GLOBALS["___mysqli_ston"], $querybankname5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$resbankname5 = mysqli_fetch_array($execbankname5);
			// $bkbankcode = $resbankname5['bankcode'];
			$bkbankcode = $bankname;
			$bkaccountname = strtoupper($res5['transactiontype']);
			//$query25 = "select * from bank_record where docno = '$bkdocno' and status IN ('Posted','Unpresented','Uncleared')";
			$query25 = "select * from bank_record where docno = '$bkdocno' and bankcode='$bankname' ";
			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res25 = mysqli_fetch_array($exec25);
			$bkposttotalamount = $bkposttotalamount + $res25['amount'];
			$bkposttotalamount = 0;
			$post25 = mysqli_num_rows($exec25);
			if($post25 == 0 || $post25 == ''){
			//$bkno = $bkno + 1;
			$bktotalamount = $bktotalamount + $bktransactionamount;
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
				$colorcode = 'bgcolor="#5fe5de"';
			}
			$amount = getcreditdebitor($bkdocno,$bktransactionamount);
			//$credit_amount = $amount['credit_amount'];
			//$debit_amount = $amount['debit_amount'];
			$credit_amount = $cramount;
			$debit_amount = $dramount;
		    $total_credit_amount = $total_credit_amount + $credit_amount;
		    $total_debit_amount =  $total_debit_amount  + $debit_amount;
		    if($bktransactionamount!='0.00')
		    {
		    	$bkno = $bkno + 1;
			?>
            <tr <?php echo $colorcode; ?>>
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $bkno; ?></div>
			   <input name="bkno<?php echo $bkno; ?>" id="bkno<?php echo $bkno; ?>" value="<?php echo $bkno; ?>" type="hidden"/>
			   <input name="bkbankname<?php echo $bkno; ?>" id="bkbankname<?php echo $bkno; ?>" type="hidden" value="<?php echo $bkbankname; ?>">
			   <input name="bkbankcode<?php echo $bkno; ?>" id="bkbankcode<?php echo $bkno; ?>" type="hidden" value="<?php echo $bkbankcode; ?>">
			  </td>
			  
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $bkaccountname; ?></div>
			  <input name="bkaccountname<?php echo $bkno; ?>" id="bkaccountname<?php echo $bkno; ?>" value="<?php echo $bkaccountname; ?>" type="hidden"/></td>
			  
			  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $bkdocno; ?></div>
			   <input name="bkdocno<?php echo $bkno; ?>" id="bkdocno<?php echo $bkno; ?>" value="<?php echo $bkdocno; ?>" type="hidden"/></td>
			   
			  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $bkchequeno; ?></div>
			  <input name="bkchequeno<?php echo $bkno; ?>" id="bkchequeno<?php echo $bkno; ?>" value="<?php echo $bkchequeno; ?>" type="hidden"/></td>
			  
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(abs($bktransactionamount),2,'.',','); ?></div>
			   <input name="bktransactionamount<?php echo $bkno; ?>" id="bktransactionamount<?php echo $bkno; ?>" value="<?php echo $bktransactionamount; ?>" type="hidden"/></td>
			   
              <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $bktransactiondate; ?></div>
			  <input name="bktransactiondate<?php echo $bkno; ?>" id="bktransactiondate<?php echo $bkno; ?>" value="<?php echo $bktransactiondate; ?>" type="hidden"/></td>
			  <input name="bkrecentdate<?php echo $bkno; ?>" id="bkrecentdate<?php echo $bkno; ?>" value="<?php echo $bankrecent_date; ?>" type="hidden"/>
			   
              <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $bktransactiondate; ?></div></td>
			  
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $bkpostedby; ?></div>
			   <input name="bkpostedby<?php echo $bkno; ?>" id="bkpostedby<?php echo $bkno; ?>" value="<?php echo $bkpostedby; ?>" type="hidden"/></td>
			   
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $bkremarks; ?></div>
			   <input name="bkremarks<?php echo $bkno; ?>" id="bkremarks<?php echo $bkno; ?>" value="<?php echo $bkremarks; ?>" type="hidden"/></td>
			   
			   <td class="bodytext31" valign="center"  align="left">
			   <input name="bkbankamounta<?php echo $bkno; ?>" id="bkbankamounta<?php echo $bkno; ?>" size="10" value="<?php echo number_format(abs($bktransactionamount),2,'.',','); ?>" readonly onChange="postcalc();" type="text"/>
			   <input name="bkbankamount<?php echo $bkno; ?>" id="bkbankamount<?php echo $bkno; ?>" size="10" value="<?php echo number_format($bktransactionamount,2,'.',','); ?>" type="hidden"/>
			</td>
			   	<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($debit_amount,2,'.',','); ?></div>
			   		<input type="hidden" name="bkdramt[]" id="bkdramt_<?php echo $bkno; ?>"  value="<?php echo $debit_amount; ?>">
			  </td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($credit_amount,2,'.',','); ?></div>
			   	<input type="hidden" name="bkcramt[]" id="bkcramt_<?php echo $bkno; ?>"  value="<?php echo $credit_amount; ?>">
			  </td>
			    <td class="bodytext31" valign="center"  align="left"><div align="left"><input name="bkdate<?php echo $bkno; ?>" id="bkdate<?php echo $bkno; ?>" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" class="datepicker" onclick="showvalid_dates('banks',<?php echo $bkno; ?>)" onKeyDown="return disableEnterKey()" />
                 <!-- <img src="images2/cal.gif" onClick="javascript:NewCssCal('bkdate<?php echo $bkno; ?>')" style="cursor:pointer"/> --></div></td>
				 
				<!-- <td class="bodytext31" valign="center"  align="left"><div align="left">
				<select id="bkstatus<?php echo $bkno; ?>" name="bkstatus<?php echo $bkno; ?>" onChange="postcalc();">
				<option value="Pending">Pending</option>
				<option value="Posted">Posted</option>
                <option value="Unpresented">Unpresented</option>
                <option value="Uncleared">Uncleared</option>
				</select>
				</div></td> -->
              </tr>
              
			<?php
				}
			}
			}?>
			<input name="bknums" id="bknums" value="<?php echo $bkno; ?>" type="hidden"/>
<!-- 
			<tr bgcolor="#ecf0f5"><td class="bodytext31" colspan="8" align="right">
			
			<strong>Pending Total:</strong></td><td class="bodytext31" align="right"><strong id="bkpendamount"><?php echo number_format($bktotalamount,2,'.',','); ?></strong></td>
			<td class="bodytext31" colspan="2" align="right"><strong></strong></td><td class="bodytext31" align="right"><strong id="bkpostamount"> <?php echo number_format($bkposttotalamount,2,'.',','); ?> </strong></td></tr> -->
			 <?php }
			 $totalamount = $aptotalamount + $artotalamount + $extotalamount + $retotalamount +$bktotalamount;
			 $totalpostamount = $apposttotalamount + $arposttotalamount + $exposttotalamount + $reposttotalamount + $bkposttotalamount;
			?>
			<input name="formdate" id="formdate" value="<?php echo $ADate2; ?>" type="hidden"/>
			<!-- <tr bgcolor="#ffffff"><td class="bodytext31" colspan="9" align="right"><strong>Grand Pending Total:</strong></td><td class="bodytext31" align="right"><strong id="totalpendamount"><?php echo number_format($totalamount,2,'.',','); ?></strong></td>
			<td class="bodytext31" colspan="1" align="right"><strong>Grand Posting Total: </strong></td><td class="bodytext31" align="right"><strong id="totalpostamount"> <?php echo number_format($totalpostamount,2,'.',','); ?> </strong></td></tr> -->
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
            $query3 = "select sum(amount) as amt from bank_record where bankcode='$ledger_id' and updateddate <= '$ADate2' group by bankcode";
						$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res3 = mysqli_fetch_array($exec3);
                        $amount_reconsiled = $res3['amt'];
             $balance_as_per_books = $closing_balance_ledger + $amount_reconsiled ;
             $amount_tobe_reconsiled = ($closing_balance_ledger - ( $statementamount + ($total_debit_amount - $total_credit_amount)));
             
             
             $bankname1=$ledger_id;
             $runningbalance=0;
			 $qrybankstatements = "SELECT postdate,chequedate,bankdate,remarks,docno,bankamount,notes,status FROM bank_record WHERE bankdate < '$ADate2' AND bankcode = '$bankname1' AND status IN ('Posted','Unpresented','Uncleared')";
            	$excebankstatements = mysqli_query($GLOBALS["___mysqli_ston"], $qrybankstatements) or die("Error in qrybankstatements".mysqli_error($GLOBALS["___mysqli_ston"]));
            	while($resbankstatement = mysqli_fetch_array($excebankstatements))
					{
					  $postingdate = $resbankstatement["chequedate"];
					  $valuedate = $resbankstatement["bankdate"];
					  $description = $resbankstatement["remarks"];
					  $transrefno = $resbankstatement["docno"];
					  $notes = $resbankstatement["notes"];
					  $status = $resbankstatement["status"];
					  	
						$query2 = "select amount, creditamount from bankentryform where docnumber = '$transrefno' and (frombankid = '$bankname1' or tobankid = '$bankname1')";
						$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res2 = mysqli_fetch_array($exec2);
						$num2 = mysqli_num_rows($exec2);
						$dramount = $res2['amount'];
						$cramount = $res2['creditamount'];
						if($num2 == 0)
						{
							//MONEY IN  -- notes type is accountrecievelbe
							if($notes == 'accounts receivable')
							{
								if($status == 'Unpresented')
								{
									$moneyin = 0;
									$moneyout = $resbankstatement["bankamount"];
								}
								else if($status == 'Uncleared')
								{
									$moneyin = 	$resbankstatement["bankamount"];
									$moneyout = 0;
								}
								else
								{
									$moneyin = 	$resbankstatement["bankamount"];
									$moneyout = 0;
								}
							}
							else if($notes == 'journal entries'){
								if($resbankstatement["bankamount"]<0){
									$moneyout = abs($resbankstatement["bankamount"]);
									$moneyin = 0;
								}else{
									$moneyin = abs($resbankstatement["bankamount"]);	
									$moneyout = 0;
								
								}
							}
							else //MONEY OUT
							{
								$moneyout = abs($resbankstatement["bankamount"]);
								$moneyin = 0;
							}
						}
						else
						{
							$moneyin = 	$dramount;
							$moneyout = $cramount;
						}	
 $fxrate = 1.00;
						$moneyin = $moneyin/$fxrate;
						$moneyout = $moneyout/$fxrate;
						$runningbalance = $runningbalance + $moneyin - $moneyout;
						$colorcode = 'bgcolor="#CBDBFA"';
					}
            
			 ?>
			 	<tr >
                 <td class="bodytext31" colspan="9" align="right"><strong><?php echo 'OPENING BALANCE AND BALANCE CARRIED OVER'; ?></strong></td>
                
				  <td class="bodytext31" valign="center"  align="right"><strong><?php echo number_format($runningbalance,2,'.',',');?></strong></td>
				    <td class="bodytext31" valign="center"  align="right"></td>
                    <td class="bodytext31" valign="center"  align="right"></td>
				  <td class="bodytext31" valign="center"  align="right"></td>
                </tr>
            <tr style="display:none">          
                <td class="bodytext31" colspan="9" align="right"><strong>Ledger Balance:</strong></td>
                <td class="bodytext31" align="right"><strong id="totalpendamount"><?php if($closing_bal >=0) { $amt = number_format((float)$closing_bal, 2, '.', ',');?><input type="text" name="closing_balance_ledger" id="closing_balance_ledger" value="<?=$amt?>" class="grouptotals" readonly><?php }?></strong></td>
			 	<td class="bodytext31" align="right">
			 	    <strong id=""><?php if($closing_bal <0) { $val = ((float)$closing_bal * -1);$amt = number_format((float)$val, 2, '.', ',');?><input type="text" name="closing_balance_ledger" id="closing_balance_ledger" value="<?=$amt?>" class="grouptotals" readonly><?php }?></strong>
			 	    <input type="hidden" name="closing_balance_ledger_hid" id="closing_balance_ledger_hid" value="<?=$closing_balance_ledger?>" class="grouptotals" readonly>
			 	</td>
			 	<td></td>
			 
                <td></td>
			</tr>
			 <tr ><td class="bodytext31" colspan="9" align="right"><strong>Amount Not Reflected in Bank:</strong></td><td class="bodytext31" align="right"><strong id=""><?php $total_debit_amount = number_format($total_debit_amount,2,'.',','); ?><input type="text" name="total_debit_amount" id="total_debit_amount" value="<?=$total_debit_amount?>" class="grouptotals" readonly></strong></td>
			 	<td class="bodytext31" align="right"><strong id=""><?php $total_credit_amount = number_format($total_credit_amount,2,'.',','); ?><input type="text" name="total_credit_amount" id="total_credit_amount" value="<?=$total_credit_amount?>" class="grouptotals" readonly></strong></td>
			 	<td></td>
			 	<td></td>
			</tr>
			 <tr><td class="bodytext31" colspan="9" align="right"><strong>Balance as per books:</strong></td><td class="bodytext31" align="right"><strong id=""><?php if($balance_as_per_books >=0) { $amt = number_format((float)$balance_as_per_books, 2, '.', ',');?><input type="text" name="balance_as_per_books" id="balance_as_per_books" value="<?=$amt?>" class="grouptotals" readonly><?php }?></strong></td>
			 	<td class="bodytext31" align="right"><strong id=""><?php if($balance_as_per_books <0) { $val = ((float)$balance_as_per_books * -1);$amt = number_format((float)$val, 2, '.', ',');?><input type="text" name="balance_as_per_books" id="balance_as_per_books" value="<?=$amt?>" class="grouptotals" readonly><?php }?></strong></td>
			 	<td></td>
			 	<td></td>
			</tr>
				 <tr><td class="bodytext31" colspan="9" align="right"><strong>Statement Amount:</strong></td><td class="bodytext31" align="right"><strong id=""><?php if($statementamount >=0) { $amt = number_format((float)$statementamount, 2, '.', ','); ?><input type="text" name="statement_amount" id="statement_amount" value="<?=$amt?>" class="grouptotals" readonly><?php }?></strong></td>
			 	<td class="bodytext31" align="right"><strong id=""><?php if($statementamount <0) { $val = ((float)$statementamount * -1);$amt = number_format((float)$val, 2, '.', ',');?> <input type="text" name="statement_amount" id="statement_amount" value="<?=$amt?>" class="grouptotals" readonly><?php }?></strong></td>
			 	<input type="hidden" name="statement_amount_hid" id="statement_amount_hid" value="<?=$statementamount?>" class="grouptotals" readonly>
			 	<td></td>
			 	<td></td>
			</tr>
			 <tr ><td class="bodytext31" colspan="9" align="right"><strong>Amount to be Reconciled:</strong></td><td class="bodytext31" align="right"><strong id=""><?php if($amount_tobe_reconsiled >=0) { $amt = number_format((float)$amount_tobe_reconsiled, 2, '.', ','); ?><input type="text" name="amount_tobe_reconsiled" id="amount_tobe_reconsiled" value="<?=$amt?>" class="grouptotals" readonly><?php }?></strong></td>
			 	<td class="bodytext31" align="right"><strong id=""><?php if($amount_tobe_reconsiled <0) { $val = ((float)$amount_tobe_reconsiled * -1);$amt = number_format((float)$val, 2, '.', ','); ?><input type="text" name="amount_tobe_reconsiled" id="amount_tobe_reconsiled" value="<?=$amt?>" class="grouptotals" readonly><?php }?></strong></td>
			 	<td></td>
			 	<td></td>
			</tr>
			<tr><td colspan="10" align="right"><input type="hidden" name="frmflg1" id="frmflg1" value="frmflg1" /><input type="button" value="Update" id="UpdateBtn"  />
			</td></tr>
			<tr>
				
				  <td class="bodytext31" valign="top" bgcolor="#add8e6" align="left"> 
                 <a target="_blank" href="print_bankreconreport.php?bankname=<?php echo $bankname;?>&&ADate2=<?php echo $ADate2; ?>&&ADate2=<?php echo $ADate2; ?>&&bankcode=<?php echo $bankname;?>&&cbfrmflag2=cbfrmflag2&&statementamount=<?php echo $statementamount?>"> <img src="images/pdfdownload.jpg" width="30" height="30"></a> 
                </td> 
                 <td colspan="1" class="bodytext31" valign="center"  align="left"><a href="bankreconreport_excel.php?bankname=<?php echo $bankname;?>&&ADate2=<?php echo $ADate2; ?>&&ADate2=<?php echo $ADate2; ?>&&bankcode=<?php echo $bankname;?>&&cbfrmflag2=cbfrmflag2&&statementamount=<?php echo $statementamount?>"><img  width="30" height="30" src="images/excel-xls-icon.png" style="cursor:pointer;"></a>
          </td>
            </tr>
          </tbody>
		  <input type="hidden" name="todaysdate" id="todaysdate" value="<?=  date("Y-m-d");?>">
        </table>
      </td> </form>
  </tr><?php } ?>
	</table>
	  
	
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
<?php 
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
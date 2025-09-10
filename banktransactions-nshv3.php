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
	$exrows = $_REQUEST['exnums'];
	$rerows = $_REQUEST['renums'];
	$bkrows = $_REQUEST['bknums'];
	//accounts receivable
	if($aprows !=0)
	{ 
		for($i=1;$i<=$aprows;$i++)
		{
			$apstatus = $_REQUEST['apstatus'.$i];
			if($apstatus != 'Pending')
			{
				$apaccountname = $_REQUEST['apaccountname'.$i];
				$apdocno = $_REQUEST['apdocno'.$i];
				$apchequeno = $_REQUEST['apchequeno'.$i];
				$aptransactionamount = $_REQUEST['aptransactionamount'.$i];
				$aptransactiondate = $_REQUEST['aptransactiondate'.$i];
				$appostedby = $_REQUEST['appostedby'.$i];
				$apremarks = $_REQUEST['apremarks'.$i];
				$apdate = $_REQUEST['apdate'.$i];
				$apstatus = $_REQUEST['apstatus'.$i];
				$apbankname = $_REQUEST['apbankname'.$i];
				$apbankcode = $_REQUEST['apbankcode'.$i];
				$apbankamount = $_REQUEST['apbankamount'.$i];
				$apbankamount = str_replace(",", "", $apbankamount);
				$query15 = "insert into bank_record (description,docno,instno,amount,postdate,postby,remarks,bankdate,status,ipaddress,username,companyanum,companyname,
				updateddate,updatedtime,bankname,bankcode,bankamount,notes)values('$apaccountname','$apdocno','$apchequeno','$aptransactionamount','$aptransactiondate','$appostedby','$apremarks','$apdate',
				'$apstatus','$ipaddress','$username','$companyanum','$companyname','$transactiondateto','$timeonly','$apbankname','$apbankcode','$apbankamount','accounts receivable')";
				$exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());
				$errmsg = "Success. Bank Details Updated.";
				$bgcolorcode = 'success';
			}
		}
	}
	//account payable
	if($arrows !=0)
	{ 
		for($i=1;$i<=$arrows;$i++)
		{
			$arstatus = $_REQUEST['arstatus'.$i];
			if($arstatus != 'Pending')
			{
				$araccountname = $_REQUEST['araccountname'.$i];
				$ardocno = $_REQUEST['ardocno'.$i];
				$archequeno = $_REQUEST['archequeno'.$i];
				$artransactionamount = $_REQUEST['artransactionamount'.$i];
				$artransactiondate = $_REQUEST['artransactiondate'.$i];
				$arpostedby = $_REQUEST['arpostedby'.$i];
				$arremarks = $_REQUEST['arremarks'.$i];
				$ardate = $_REQUEST['ardate'.$i];
				$arbankname = $_REQUEST['arbankname'.$i];
				$arbankcode = $_REQUEST['arbankcode'.$i];
				$arbankamount = $_REQUEST['arbankamount'.$i];
				$arbankamount = str_replace(",", "", $arbankamount);
				$query16 = "insert into bank_record (description,docno,instno,amount,postdate,postby,remarks,bankdate,status,ipaddress,username,companyanum,companyname,
				updateddate,updatedtime,bankname,bankcode,bankamount,notes)values('$araccountname','$ardocno','$archequeno','$artransactionamount','$artransactiondate','$arpostedby','$arremarks','$ardate',
				'$arstatus','$ipaddress','$username','$companyanum','$companyname','$transactiondateto','$timeonly','$arbankname','$arbankcode','$arbankamount','account payable')";
				$exec16 = mysql_query($query16) or die ("Error in Query16".mysql_error());
				$errmsg = "Success. Bank Details Updated.";
				$bgcolorcode = 'success';
			}
		}
	}
	//expenses
	if($exrows !=0)
	{ 
		for($i=1;$i<=$exrows;$i++)
		{	
			$exstatus = $_REQUEST['exstatus'.$i];
			if($exstatus != 'Pending')
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
				$query17 = "insert into bank_record (description,docno,instno,amount,postdate,postby,remarks,bankdate,status,ipaddress,username,companyanum,companyname,
				updateddate,updatedtime,bankname,bankcode,bankamount,notes)values('$exaccountname','$exdocno','$exchequeno','$extransactionamount','$extransactiondate','$expostedby','$exremarks','$exdate',
				'$exstatus','$ipaddress','$username','$companyanum','$companyname','$transactiondateto','$timeonly','$exbankname','$exbankcode','$exbankamount','expenses')";
				$exec17 = mysql_query($query17) or die ("Error in Query17".mysql_error());
				$errmsg = "Success. Bank Details Updated.";
				$bgcolorcode = 'success';
			}
			
		}
	}
	//receipts
	if($rerows !=0)
	{ 
		for($i=1;$i<=$rerows;$i++)
		{
			$restatus = $_REQUEST['restatus'.$i];
			if($restatus != 'Pending')
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
				$query18 = "insert into bank_record (description,docno,instno,amount,postdate,postby,remarks,bankdate,status,ipaddress,username,companyanum,companyname,
				updateddate,updatedtime,bankname,bankcode,bankamount,notes)values('$reaccountname','$redocno','$rechequeno','$retransactionamount','$retransactiondate','$repostedby','$reremarks','$redate',
				'$restatus','$ipaddress','$username','$companyanum','$companyname','$transactiondateto','$timeonly','$rebankname','$rebankcode','$rebankamount','receipts')";
				$exec18 = mysql_query($query18) or die ("Error in Query18".mysql_error());
				$errmsg = "Success. Bank Details Updated.";
				$bgcolorcode = 'success';
			}
		}
	}
	//banktransactions
	if($bkrows !=0)
	{ 
		for($i=1;$i<=$bkrows;$i++)
		{
			$bkstatus = $_REQUEST['bkstatus'.$i];
			if($bkstatus != 'Pending')
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
				$query19 = "insert into bank_record (description,docno,instno,amount,postdate,postby,remarks,bankdate,status,ipaddress,username,companyanum,companyname,
				updateddate,updatedtime,bankname,bankcode,bankamount,notes)values('$bkaccountname','$bkdocno','$bkchequeno','$bktransactionamount','$bktransactiondate','$bkpostedby','$bkremarks','$bkdate',
				'$bkstatus','$ipaddress','$username','$companyanum','$companyname','$transactiondateto','$timeonly','$bkbankname','$bkbankcode','$bkbankamount','misc')";
				$exec19 = mysql_query($query19) or die ("Error in Query19".mysql_error());
				$errmsg = "Success. Bank Details Updated.";
				$bgcolorcode = 'success';
			}			
		}
	}
//print_r($_POST);

}
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.number1
{
text-align:right;
padding-left:700px;
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
<script type="text/javascript">
/*
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        
}
*/

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
	if(document.getElementById('bankname').value =='')
	{
		alert("Please Select The Bank");
		//return false;
	}
}
function postcalc()
{
	//alert("hi");
	var apnums = document.getElementById('apnums');
	var arnums = document.getElementById('arnums');
	var renums = document.getElementById('renums');
	var exnums = document.getElementById('exnums');
	var bknums = document.getElementById('bknums');
	var appostamount = '0.00';
	var arpostamount = '0.00';
	var repostamount = '0.00';
	var expostamount = '0.00';
	var bkpostamount = '0.00';
	var totalpostamount = '0.00';
	var appendamount = '0.00';
	var arpendamount = '0.00';
	var rependamount = '0.00';
	var expendamount = '0.00';
	var bkpendamount = '0.00';
	var totalpendamount = '0.00';
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
	repostamount = repostamount.replace(/,/g,'');
	expostamount = expostamount.replace(/,/g,'');
	bkpostamount = bkpostamount.replace(/,/g,'');
	appendamount = appendamount.replace(/,/g,'');
	arpendamount = arpendamount.replace(/,/g,'');
	rependamount = rependamount.replace(/,/g,'');
	expendamount = expendamount.replace(/,/g,'');
	bkpendamount = bkpendamount.replace(/,/g,'');
	totalpostamount = parseFloat(appostamount) + parseFloat(arpostamount) + parseFloat(repostamount) + parseFloat(expostamount) + parseFloat(bkpostamount);
	totalpendamount = parseFloat(appendamount) + parseFloat(arpendamount) + parseFloat(rependamount) + parseFloat(expendamount) + parseFloat(bkpendamount);
	
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
    <td colspan="9" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ECF0F5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	    <tr>
	 <td width="860">
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
					
                        <td colspan="2" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3" ><div align="left"><strong></strong></div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" colspan="2" ><!--<input type="text" name="chequebank" id="chequebank">-->
						<select name="bankname" id="bankname">
					<option value="">Select Bank</option>
						<?php 
						$querybankname = "select * from master_bank where bankstatus <> 'deleted'";
						$execbankname = mysql_query($querybankname) or die ("Error in Query3".mysql_error());
						while($resbankname = mysql_fetch_array($execbankname))
						{
						?>
							
							<option value="<?php echo $resbankname['bankname']; ?>"><?php echo $resbankname['bankname'];?></option>
						<?php }
						?>
					</select></td>
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
			if($cbfrmflag1 == 'cbfrmflag1'){ ?>

	  <tr><form action="banktransactions.php" name="checklist" method="post">
        <td><table width="1049" height="80" border="0" 
            align="left" cellpadding="2" cellspacing="0" 
            bordercolor="#666666" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" >
          <tbody>
             <tr>
              <td colspan="11" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong><?php echo $bankname; ?></strong></div></td>
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
			$query1 = "select * from master_transactionpaylater where transactionmodule = 'PAYMENT' and bankname like '%$bankname%' and recordstatus <> 'deallocated' group by docno";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$apnums = mysql_num_rows($exec1);
			$query41 = "select * from bank_record where notes = 'accounts receivable' and status IN ('Posted','Unpresented','Uncleared')";
			$exec41 = mysql_query($query41) or die ("Error in Query41".mysql_error());
			$post41 = mysql_num_rows($exec41);
			$apnums = $apnums - $post41;
			if(true)
			{?>
			 <tr>
              <td colspan="11" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Account Receivable
			   </strong></div></td>
			    </tr>
	
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
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bank Date</strong></div></td>
				<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Status</strong></div></td>
           </tr>
		   <?php
			while ($res1 = mysql_fetch_array($exec1))
			{
			$post21='';
			$apaccountname = strtoupper($res1['accountname']);
			$apdocno = $res1['docno'];
			$aptransactiondate =$res1['transactiondate'];
			$aptransactionamount = $res1['transactionamount'];
			$apchequeno = $res1['chequenumber'];
			$appostedby = $res1['username'];
			$apremarks = $res1['remarks'];
			$apbankname = $res1['bankname'];
			$querybankname1 = "select * from master_bank where bankname like '%$apbankname%' and bankstatus <> 'deleted'";
			$execbankname1 = mysql_query($querybankname1) or die ("Error in Query1".mysql_error());
			$resbankname1 = mysql_fetch_array($execbankname1);
			$apbankcode = $resbankname1['bankcode'];
			$query10 = "select * from paymentmodedebit where billnumber = '$apdocno'";
			$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
			$res10 = mysql_fetch_array($exec10);
			$appostedby = $res10['username'];
			$query21 = "select * from bank_record where docno = '$apdocno' and instno = '$apchequeno' and status IN ('Posted','Unpresented','Uncleared')";
			$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
			$res21 = mysql_fetch_array($exec21);
			$apposttotalamount = $apposttotalamount + $res21['amount'];
			$apposttotalamount = 0;
			$post21 = mysql_num_rows($exec21);
			if($post21 == 0 || $post21 == ''){
			$apno = $apno + 1;
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
				$colorcode = 'bgcolor="#CBDBFA"';
			}
		
		    
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
			  <input name="aptransactiondate<?php echo $apno; ?>" id="aptransactiondate<?php echo $apno; ?>" value="<?php echo $aptransactiondate; ?>" type="hidden"/></td>
			  
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $appostedby; ?></div>
			   <input name="appostedby<?php echo $apno; ?>" id="appostedby<?php echo $apno; ?>" value="<?php echo $appostedby; ?>" type="hidden"/></td>
			   
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $apremarks; ?></div>
			   <input name="apremarks<?php echo $apno; ?>" id="apremarks<?php echo $apno; ?>" value="<?php echo $apremarks; ?>" type="hidden"/></td>
			   
			   <td class="bodytext31" valign="center"  align="left"><div align="left"></div>
			   <input name="apbankamount<?php echo $apno; ?>" id="apbankamount<?php echo $apno; ?>" value="<?php echo number_format($aptransactionamount,2,'.',','); ?>" size="10" type="text" onChange="postcalc();"/></td>
			   
			    <td class="bodytext31" valign="center"  align="left"><div align="left"><input name="apdate<?php echo $apno; ?>" id="apdate<?php echo $apno; ?>" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                 <img src="images2/cal.gif" onClick="javascript:NewCssCal('apdate<?php echo $apno; ?>')" style="cursor:pointer"/></div></td>
				 
				<td class="bodytext31" valign="center"  align="left"><div align="left">
				<select id="apstatus<?php echo $apno; ?>" name="apstatus<?php echo $apno; ?>" onChange="postcalc();">
				<option value="Pending">Pending</option>
				<option value="Posted">Posted</option>
                <option value="Unpresented">Unpresented</option>
                <option value="Uncleared">Uncleared</option>
				</select>
				</div></td>
              </tr>
              
			<?php
			}
			}
			?>
			<tr bgcolor="#ecf0f5"><td class="bodytext31" colspan="7" align="right">
			<input name="apnums" id="apnums" value="<?php echo $apno; ?>" type="hidden"/>
			<strong>Pending Total:</strong></td><td class="bodytext31" align="right"><strong id="appendamount"><?php echo number_format($aptotalamount,2,'.',','); ?></strong></td>
			<td class="bodytext31" colspan="2" align="right"><strong>Posting Total:</strong></td><td class="bodytext31" align="right"><strong id="appostamount"><?php echo number_format($apposttotalamount,2,'.',','); ?></strong></td></tr>
			<tr><td colspan="10">&nbsp;</td></tr> 
			 <?php 
			 }
			?>
			<?php
						
			$arno = '';
			$query2 = "select * from master_transactionpharmacy where transactionmodule = 'PAYMENT' and bankname like '%$bankname%' and recordstatus <> 'deallocated' group by docno";
			$exec2 = mysql_query($query2) or die ("Error in Query1".mysql_error());
			$arnums = mysql_num_rows($exec2);
			$query42 = "select * from bank_record where notes = 'account payable' and status IN ('Posted','Unpresented','Uncleared')";
			$exec42 = mysql_query($query42) or die ("Error in Query42".mysql_error());
			$post42 = mysql_num_rows($exec42);
			$arnums = $arnums - $post42;
			if(true)
			{?>
			 <tr>
              <td colspan="11" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Account Payable
			   </strong></div></td>
			    </tr>
	
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
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bank Date</strong></div></td>
				<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Status</strong></div></td>
           </tr>
		   <?php
			while ($res2 = mysql_fetch_array($exec2))
			{
			$araccountname = strtoupper($res2['suppliername']);
			$ardocno = $res2['docno'];
			$artransactiondate =$res2['transactiondate'];
			$artransactionamount = $res2['transactionamount'];
			$archequeno = $res2['chequenumber'];
			//$arpostedby = $res2['username'];
			$arremarks = $res2['remarks'];
			$arbankname = $res2['bankname'];
			$querybankname2 = "select * from master_bank where bankname like '%$arbankname%' and bankstatus <> 'deleted'";
			$execbankname2 = mysql_query($querybankname2) or die ("Error in Query1".mysql_error());
			$resbankname2 = mysql_fetch_array($execbankname2);
			$arbankcode = $resbankname2['bankcode'];
			$query11 = "select * from paymentmodecredit where billnumber = '$ardocno'";
			$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
			$res11 = mysql_fetch_array($exec11);
			$arpostedby = $res11['username'];
			$query22 = "select * from bank_record where docno = '$ardocno' and instno = '$archequeno' and status IN ('Posted','Unpresented','Uncleared')";
			$exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
			$res22 = mysql_fetch_array($exec22);
			$arposttotalamount = $arposttotalamount + $res22['amount'];
			$arposttotalamount = 0;
			$post22 = mysql_num_rows($exec22);
			if($post22 == 0 || $post22 == ''){
			$arno = $arno + 1;
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
				$colorcode = 'bgcolor="#CBDBFA"';
			}
		
		    
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
			  
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $arpostedby; ?></div>
			   <input name="arpostedby<?php echo $arno; ?>" id="arpostedby<?php echo $arno; ?>" value="<?php echo $arpostedby; ?>" type="hidden"/></td>
			   
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $arremarks; ?></div>
			   <input name="arremarks<?php echo $arno; ?>" id="arremarks<?php echo $arno; ?>" value="<?php echo $arremarks; ?>" type="hidden"/></td>
			   
			   <td class="bodytext31" valign="center"  align="left"><div align="left">
			   <input name="arbankamount<?php echo $arno; ?>" id="arbankamount<?php echo $arno; ?>" size="10" value="<?php echo number_format($artransactionamount,2,'.',','); ?>" type="text" onChange="postcalc();"/></td>
			   
			    <td class="bodytext31" valign="center"  align="left"><div align="left"><input name="ardate<?php echo $arno; ?>" id="ardate<?php echo $arno; ?>" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                 <img src="images2/cal.gif" onClick="javascript:NewCssCal('ardate<?php echo $arno; ?>')" style="cursor:pointer"/></div></td>
				 
				<td class="bodytext31" valign="center"  align="left"><div align="left">
				<select id="arstatus<?php echo $arno; ?>" name="arstatus<?php echo $arno; ?>" onChange="postcalc();">
				<option value="Pending">Pending</option>
				<option value="Posted">Posted</option>
                <option value="Unpresented">Unpresented</option>
                <option value="Uncleared">Uncleared</option>
				</select>
				</div></td>
              </tr>
              
			<?php
			}
			}
			?>
			<tr bgcolor="#ecf0f5"><td class="bodytext31" colspan="7" align="right">
			<input name="arnums" id="arnums" value="<?php echo $arno; ?>" type="hidden"/>
			<strong>Pending Total:</strong></td><td class="bodytext31" align="right"><strong  id="arpendamount"><?php echo number_format($artotalamount,2,'.',','); ?></strong></td>
			<td class="bodytext31" colspan="2" align="right"><strong>Posting Total:</strong></td><td class="bodytext31" align="right"><strong id="arpostamount"><?php echo number_format($arposttotalamount,2,'.',','); ?></strong></td></tr>
			<tr><td colspan="10">&nbsp;</td></tr>
			 <?php 
			 }
			?>
			<?php
			
			
			$exno = '';
			
			$query3 = "select * from expensesub_details where bankname like '%$bankname%' and recordstatus <> 'deallocated' group by docnumber";
			$exec3 = mysql_query($query3) or die ("Error in Query1".mysql_error());
			$exnums = mysql_num_rows($exec3);
			$query43 = "select * from bank_record where notes = 'expenses' and status IN ('Posted','Unpresented','Uncleared')";
			$exec43 = mysql_query($query43) or die ("Error in Query43".mysql_error());
			$post43 = mysql_num_rows($exec43);
			$exnums = $exnums - $post43;
			if(true)
			{?>
			 <tr>
              <td colspan="11" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Expenses
			   </strong></div></td>
			    </tr>
	
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
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bank Date</strong></div></td>
				<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Status</strong></div></td>
           </tr>
		   <?php
			while ($res3 = mysql_fetch_array($exec3))
			{
			
			$exdocno = $res3['docnumber'];
			$extransactiondate =$res3['transactiondate'];
			$extransactionamount = $res3['transactionamount'];
			$exchequeno = $res3['chequenumber'];
			$expostedby = $res3['username'];
			$exremarks = $res3['remarks'];
			$exaccountnamecoa = $res3['expensecoa'];
			$exbankname = $res3['bankname'];
			$querybankname3 = "select * from master_bank where bankname like '%$exbankname%' and bankstatus <> 'deleted'";
			$execbankname3 = mysql_query($querybankname3) or die ("Error in Query3".mysql_error());
			$resbankname3 = mysql_fetch_array($execbankname3);
			$exbankcode = $resbankname3['bankcode'];
			$query8 = "select * from master_accountname where id = '$exaccountnamecoa'";
			$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
			$res8 = mysql_fetch_array($exec8);
			$exaccountname = strtoupper($res8['accountname']);
			$query23 = "select * from bank_record where docno = '$exdocno' and instno = '$exchequeno' and status IN ('Posted','Unpresented','Uncleared')";
			$exec23 = mysql_query($query23) or die ("Error in Query23".mysql_error());
			$res23 = mysql_fetch_array($exec23);
			$exposttotalamount = $exposttotalamount + $res23['amount'];
			$exposttotalamount = 0;
			$post23 = mysql_num_rows($exec23);
			if($post23 == 0 || $post23 == ''){
			$exno = $exno + 1;
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
				$colorcode = 'bgcolor="#CBDBFA"';
			}
		
		    
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
			  
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $expostedby; ?></div>
			   <input name="expostedby<?php echo $exno; ?>" id="expostedby<?php echo $exno; ?>" value="<?php echo $expostedby; ?>" type="hidden"/></td>
			   
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $exremarks; ?></div>
			   <input name="exremarks<?php echo $exno; ?>" id="exremarks<?php echo $exno; ?>" value="<?php echo $exremarks; ?>" type="hidden"/></td>
			   
			   <td class="bodytext31" valign="center"  align="left"><div align="left">
			   <input name="exbankamount<?php echo $exno; ?>" id="exbankamount<?php echo $exno; ?>" size="10" value="<?php echo number_format($extransactionamount,2,'.',','); ?>" onChange="postcalc();" type="text"/></td>
			   
			    <td class="bodytext31" valign="center"  align="left"><div align="left"><input name="exdate<?php echo $exno; ?>" id="exdate<?php echo $exno; ?>" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                 <img src="images2/cal.gif" onClick="javascript:NewCssCal('exdate<?php echo $exno; ?>')" style="cursor:pointer"/></div></td>
				 
				<td class="bodytext31" valign="center"  align="left"><div align="left">
				<select id="exstatus<?php echo $exno; ?>" name="exstatus<?php echo $exno; ?>" onChange="postcalc();">
				<option value="Pending">Pending</option>
				<option value="Posted">Posted</option>
                <option value="Unpresented">Unpresented</option>
                <option value="Uncleared">Uncleared</option>
				</select>
				</div></td>
              </tr>
              
			<?php
			}
			}
			?>
			<tr bgcolor="#ecf0f5"><td class="bodytext31" colspan="7" align="right">
			<input name="exnums" id="exnums" value="<?php echo $exno; ?>" type="hidden"/>
			<strong>Pending Total:</strong></td><td class="bodytext31" align="right"><strong id="expendamount"><?php echo number_format($extotalamount,2,'.',','); ?></strong></td>
			<td class="bodytext31" colspan="2" align="right"><strong>Posting Total:</strong></td><td class="bodytext31" align="right"><strong id="expostamount"><?php echo number_format($exposttotalamount,2,'.',','); ?></strong></td></tr>
			<tr><td colspan="10">&nbsp;</td></tr>
			<?php 
			 }
			?>
			<?php
			
			
			$reno = '';
			
			$query4 = "select * from receiptsub_details where bankname like '%$bankname%' and recordstatus <> 'deallocated' group by docnumber";
			$exec4 = mysql_query($query4) or die ("Error in Query1".mysql_error());
			$renums = mysql_num_rows($exec4);
			$query44 = "select * from bank_record where notes = 'receipts' and status IN ('Posted','Unpresented','Uncleared')";
			$exec44 = mysql_query($query44) or die ("Error in Query44".mysql_error());
			$post44 = mysql_num_rows($exec44);
			$renums = $renums - $post44;
			if(true)
			{?>
			 <tr>
              <td colspan="11" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Receipts
			   </strong></div></td>
			    </tr>
	
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
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bank Date</strong></div></td>
				<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Status</strong></div></td>
           </tr>
		   <?php
			while ($res4 = mysql_fetch_array($exec4))
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
			$execbankname4 = mysql_query($querybankname4) or die ("Error in Query4".mysql_error());
			$resbankname4 = mysql_fetch_array($execbankname4);
			$rebankcode = $resbankname4['bankcode'];
			$query9 = "select * from master_accountname where id = '$reaccountnamecoa'";
			$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
			$res9 = mysql_fetch_array($exec9);
			$reaccountname = strtoupper($res9['accountname']);
			$query24 = "select * from bank_record where docno = '$redocno' and instno = '$rechequeno' and status IN ('Posted','Unpresented','Uncleared')";
			$exec24 = mysql_query($query24) or die ("Error in Query24".mysql_error());
			$res24 = mysql_fetch_array($exec24);
			$reposttotalamount = $reposttotalamount + $res24['amount'];
			$reposttotalamount = 0;
			$post24 = mysql_num_rows($exec24);
			if($post24 == 0 || $post24 == ''){
			$reno = $reno + 1;
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
				$colorcode = 'bgcolor="#CBDBFA"';
			}
		
		    
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
			  <input name="retransactiondate<?php echo $reno; ?>" id="retransactiondate<?php echo $reno; ?>" value="<?php echo $retransactiondate; ?>" type="hidden"/></td>
			  
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $repostedby; ?></div>
			   <input name="repostedby<?php echo $reno; ?>" id="repostedby<?php echo $reno; ?>" value="<?php echo $repostedby; ?>" type="hidden"/></td>
			   
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $reremarks; ?></div>
			   <input name="reremarks<?php echo $reno; ?>" id="reremarks<?php echo $reno; ?>" value="<?php echo $reremarks; ?>" type="hidden"/></td>
			   
			   <td class="bodytext31" valign="center"  align="left"><div align="left">
			   <input name="rebankamount<?php echo $reno; ?>" id="rebankamount<?php echo $reno; ?>" size="10" value="<?php echo number_format($retransactionamount,2,'.',','); ?>" onChange="postcalc();" type="text"/></td>
			   
			    <td class="bodytext31" valign="center"  align="left"><div align="left"><input name="redate<?php echo $reno; ?>" id="redate<?php echo $reno; ?>" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                 <img src="images2/cal.gif" onClick="javascript:NewCssCal('redate<?php echo $reno; ?>')" style="cursor:pointer"/></div></td>
				 
				<td class="bodytext31" valign="center"  align="left"><div align="left">
				<select id="restatus<?php echo $reno; ?>" name="restatus<?php echo $reno; ?>" onChange="postcalc();">
				<option value="Pending">Pending</option>
				<option value="Posted">Posted</option>
                <option value="Unpresented">Unpresented</option>
                <option value="Uncleared">Uncleared</option>
				</select>
				</div></td>
              </tr>
              
			<?php
			}
			}
			?>
			<tr bgcolor="#ecf0f5"><td class="bodytext31" colspan="7" align="right">
			<input name="renums" id="renums" value="<?php echo $reno; ?>" type="hidden"/>
			<strong>Pending Total:</strong></td><td class="bodytext31" align="right"><strong id="rependamount"><?php echo number_format($retotalamount,2,'.',','); ?></strong></td>
			<td class="bodytext31" colspan="2" align="right"><strong>Posting Total:</strong></td><td class="bodytext31" align="right"><strong id="repostamount"><?php echo number_format($reposttotalamount,2,'.',','); ?></strong></td></tr>
			<tr><td colspan="10">&nbsp;</td></tr>
			<?php 
			 }
			?>
			<?php
						
			$bkno = '';
			
			$query5 = "select * from bankentryform where (bankname like '%$bankname%' or frombankname like '%$bankname%') group by docnumber";
			$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
			$bknums = mysql_num_rows($exec5);
			$query45 = "select * from bank_record where notes = 'misc' and status IN ('Posted','Unpresented','Uncleared')";
			$exec45 = mysql_query($query45) or die ("Error in Query45".mysql_error());
			$post45 = mysql_num_rows($exec45);
			$bknums = $bknums - $post45;
			if(true)
			{?>
			 <tr>
              <td colspan="11" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>Misc
			   </strong></div></td>
			    </tr>
	
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
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bank Date</strong></div></td>
				<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Status</strong></div></td>
           </tr>
		   <?php
			while ($res5 = mysql_fetch_array($exec5))
			{
			
			$bkdocno = $res5['docnumber'];
			$bktransactiondate =$res5['transactiondate'];
			$dramount = $res5['amount'];
			$cramount = $res5['creditamount'];
			$bktransactionamount = $cramount + $dramount;
			$bkchequeno = $res5['chequenumber'];
			$bkpostedby = $res5['personname'];
			$bkremarks = $res5['remarks'];
			$bkbankname = $res5['bankname'];		
			$querybankname5 = "select * from master_bank where bankname like '%$bkbankname%' and bankstatus <> 'deleted'";
			$execbankname5 = mysql_query($querybankname5) or die ("Error in Query5".mysql_error());
			$resbankname5 = mysql_fetch_array($execbankname5);
			$bkbankcode = $resbankname5['bankcode'];
			$bkaccountname = strtoupper($res5['transactiontype']);
			$query25 = "select * from bank_record where docno = '$bkdocno' and status IN ('Posted','Unpresented','Uncleared')";
			$exec25 = mysql_query($query25) or die ("Error in Query25".mysql_error());
			$res25 = mysql_fetch_array($exec25);
			$bkposttotalamount = $bkposttotalamount + $res25['amount'];
			$bkposttotalamount = 0;
			$post25 = mysql_num_rows($exec25);
			if($post25 == 0 || $post25 == ''){
			$bkno = $bkno + 1;
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
				$colorcode = 'bgcolor="#CBDBFA"';
			}
		
		    
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
			  
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($bktransactionamount,2,'.',','); ?></div>
			   <input name="bktransactionamount<?php echo $bkno; ?>" id="bktransactionamount<?php echo $bkno; ?>" value="<?php echo $bktransactionamount; ?>" type="hidden"/></td>
			   
              <td class="bodytext31" valign="center"  align="center"><div align="center"><?php echo $bktransactiondate; ?></div>
			  <input name="bktransactiondate<?php echo $bkno; ?>" id="bktransactiondate<?php echo $bkno; ?>" value="<?php echo $bktransactiondate; ?>" type="hidden"/></td>
			  
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $bkpostedby; ?></div>
			   <input name="bkpostedby<?php echo $bkno; ?>" id="bkpostedby<?php echo $bkno; ?>" value="<?php echo $bkpostedby; ?>" type="hidden"/></td>
			   
			   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $bkremarks; ?></div>
			   <input name="bkremarks<?php echo $bkno; ?>" id="bkremarks<?php echo $bkno; ?>" value="<?php echo $bkremarks; ?>" type="hidden"/></td>
			   
			   <td class="bodytext31" valign="center"  align="left">
			   <input name="bkbankamount<?php echo $bkno; ?>" id="bkbankamount<?php echo $bkno; ?>" size="10" value="<?php echo number_format($bktransactionamount,2,'.',','); ?>" onChange="postcalc();" type="text"/></td>
			   
			    <td class="bodytext31" valign="center"  align="left"><div align="left"><input name="bkdate<?php echo $bkno; ?>" id="bkdate<?php echo $bkno; ?>" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                 <img src="images2/cal.gif" onClick="javascript:NewCssCal('bkdate<?php echo $bkno; ?>')" style="cursor:pointer"/></div></td>
				 
				<td class="bodytext31" valign="center"  align="left"><div align="left">
				<select id="bkstatus<?php echo $bkno; ?>" name="bkstatus<?php echo $bkno; ?>" onChange="postcalc();">
				<option value="Pending">Pending</option>
				<option value="Posted">Posted</option>
                <option value="Unpresented">Unpresented</option>
                <option value="Uncleared">Uncleared</option>
				</select>
				</div></td>
              </tr>
              
			<?php
			}
			}?>
			<tr bgcolor="#ecf0f5"><td class="bodytext31" colspan="7" align="right">
			<input name="bknums" id="bknums" value="<?php echo $bkno; ?>" type="hidden"/>
			<strong>Pending Total:</strong></td><td class="bodytext31" align="right"><strong id="bkpendamount"><?php echo number_format($bktotalamount,2,'.',','); ?></strong></td>
			<td class="bodytext31" colspan="2" align="right"><strong>Posting Total:</strong></td><td class="bodytext31" align="right"><strong id="bkpostamount"><?php echo number_format($bkposttotalamount,2,'.',','); ?></strong></td></tr>
			 <?php }
			 $totalamount = $aptotalamount + $artotalamount + $extotalamount + $retotalamount +$bktotalamount;
			 $totalpostamount = $apposttotalamount + $arposttotalamount + $exposttotalamount + $reposttotalamount + $bkposttotalamount;
			?>
			<tr bgcolor="#ffffff"><td class="bodytext31" colspan="7" align="right"><strong>Grand Pending Total:</strong></td><td class="bodytext31" align="right"><strong id="totalpendamount"><?php echo number_format($totalamount,2,'.',','); ?></strong></td>
			<td class="bodytext31" colspan="2" align="right"><strong>Grand Posting Total:</strong></td><td class="bodytext31" align="right"><strong id="totalpostamount"><?php echo number_format($totalpostamount,2,'.',','); ?></strong></td></tr>
			<tr><td colspan="11" align="right"><input type="hidden" name="frmflg1" id="frmflg1" value="frmflg1" /><input type="submit" name="submit" value="Update" />
			</td></tr>
          </tbody>
		  
        </table>
      </td> </form>
  </tr><?php } ?>
	</table>
	  
	
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
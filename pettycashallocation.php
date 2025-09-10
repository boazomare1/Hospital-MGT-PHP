<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$entrydate = date('Y-m-d');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$dummy = '';
$cr_amount="";
//$sessiondocno = $_SESSION['docno'];


if(isset($_REQUEST['frmflag1'])) { $frmflag1 = $_REQUEST['frmflag1']; } else { $frmflag1 = ''; }

if($frmflag1 == 'frmflag1')
{

visitcreate:
$paynowbillprefix = 'PCA-';
$paynowbillprefix1=strlen($paynowbillprefix);
 $query2 = "select * from master_journalentries where docno like 'PCA-%' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
 $billnumbercode ='PCA-'.'1';
}
else
{
 $billnumber = $res2["docno"];
 $billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

 $billnumbercode = intval($billnumbercode);
 $billnumbercode = $billnumbercode + 1;
 $maxanum = $billnumbercode;
 $billnumbercode = 'PCA-' .$maxanum;
  
} 
$docno1 = $billnumbercode;

$query2 = "select * from master_journalentries where docno ='$docno1'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_num_rows($exec2);
if($res2>0){
	goto visitcreate;
}

$entryid = $_REQUEST['entryid'];
$entrydate = $_REQUEST['entrydate'];
$entrydate = date('Y-m-d',strtotime($entrydate));
$narration = $_REQUEST['narration'];
$locationcode = $_REQUEST['location'];
$ddoc = $_REQUEST['ddoc'];
//ddoc
$querry1="select doc_no from pcrequest where doc_no='$ddoc'";
$es=mysqli_query($GLOBALS["___mysqli_ston"], $querry1);
$res=mysqli_fetch_array($es);
$doc=$res['doc_no'];
$query66 = "select locationname from master_location where locationcode = '$locationcode'";
$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
$res66 = mysqli_fetch_array($exec66);
$locationname = $res66['locationname'];

for($i=1;$i<=50;$i++)
{
	if(isset($_REQUEST['serialnumberentries'.$i]))
	{
		$serialnumberentries = $_REQUEST['serialnumberentries'.$i];
		
		if($serialnumberentries != '')
		{
			
			$entrytype = $_REQUEST['entrytype'.$i];
			$ledger = $_REQUEST['ledger'.$i];
			$ledgerno = $_REQUEST['ledgerno'.$i];
			$amount = $_REQUEST['amount'.$i];
			$amount = str_replace(',','',$amount);
			$billwise = $_REQUEST['billwise'.$i];
			if($entrytype == 'Cr')
			{
				$creditamount = $amount;
				$debitamount = '0.00';
			}
			else
			{
				$debitamount = $amount;
				$creditamount = '0.00';
			}
			
			 $query7 = "insert into master_journalentries (`docno`, `entrydate`, `voucheranum`, `vouchertype`, `selecttype`, `ledgerid`, `ledgername`, `transactionamount`, `creditamount`, `debitamount`, `status`, `ipaddress`, `username`, `updatedatetime`, `locationcode`, `locationname`, `narration`,disbursstatus,pcdocno)
			values('$docno1','$entrydate','','JOURNAL','$entrytype','$ledgerno','$ledger', '$amount', '$creditamount', '$debitamount','','$ipaddress','$username','$updatedatetime','$locationcode','$locationname','$narration','pending','$ddoc')";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			if($exec7){
				
				
			  $quer="update pcrequest set final_status='completed' where doc_no='$ddoc' ";
			$exe=mysqli_query($GLOBALS["___mysqli_ston"], $quer);
			
			}
		}
	}
}

header("location:finalappprovedlist.php?st=success");

}

?>

<?php

$paynowbillprefix = 'PCA-';
$paynowbillprefix1=strlen($paynowbillprefix);
 $query2 = "select * from master_journalentries where docno like 'PCA-%' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
 $billnumbercode ='PCA-'.'1';
}
else
{
 $billnumber = $res2["docno"];
 $billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

 $billnumbercode = intval($billnumbercode);
 $billnumbercode = $billnumbercode + 1;
 $maxanum = $billnumbercode;
 $billnumbercode = 'PCA-' .$maxanum;
  
} 
$docno1 = $billnumbercode;
?>
<style type="text/css">

body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5 !important;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext11 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
</style>

</script>

</head>

<script type="text/javascript" language="javascript">

	
function entries()
{
	//alert ("Inside Funtion");
	if (document.form1.ledger1.value == "")
	{
		alert ("Please Select Ledger.");
		document.form1.ledger1.focus();
		return false;
	}
	if (document.form1.ledgerno1.value == "")
	{
		alert ("Please Select Ledger.");
		document.form1.ledger1.focus();
		return false;
	}
	
	if (isNaN(document.form1.amount1.value == ""))
	{
		alert ("Please Enter Amount.");
		document.form1.amount1.focus();
		return false;
	}
	if (document.form1.amount1.value == "")
	{
		alert ("Please Enter Amount.");
		document.form1.amount1.focus();
		return false;
	}
	
	var TotalCreditAmt = 0.00;
	var TotalDebitAmt = 0.00;
	
	var Flg = "false";

	for(var i=1;i<=50;i++)
	{
		
		if(document.getElementById("entrytype"+i)!=null)
		{	
			var Flg = "false";
			
			if(document.getElementById("ledgerno"+i).value == "")
			{
				alert("Please Select Ledger from list");
				document.getElementById("ledger"+i).focus();
				return false;
			}
			
			if(document.getElementById("entrytype"+i).value == "Cr")
			{
				var CreditAmt = document.getElementById("amount"+i).value;
				CreditAmt=CreditAmt.replace(/,/g,'');
				TotalCreditAmt = parseFloat(TotalCreditAmt) + parseFloat(CreditAmt);
				//alert(TotalCreditAmt);
			}
			else
			{
				var DebitAmt = document.getElementById("amount"+i).value;
				DebitAmt=DebitAmt.replace(/,/g,'');
				TotalDebitAmt = parseFloat(TotalDebitAmt) + parseFloat(DebitAmt);
				//alert(TotalDebitAmt);
			}
		}
	}
	
	var TotalDiff = parseFloat(TotalCreditAmt) - parseFloat(TotalDebitAmt);
	TotalDiff = Math.abs(TotalDiff);
	//alert(TotalDiff);
	if(TotalDiff > 0)
	{
		alert("Sum of Credit and Debit Mismatch");
		return false;		
	}
	
	var sno = document.getElementById("serialnumber").value;
	//alert(sno);
	var rno = parseFloat(sno) - 1;
	//alert(rno);
	var TotalCreditAmt = 0.00;
	var TotalDebitAmt = 0.00;
	
	var Tef = confirm("Are you Sure to Submit ?");	
	
	if(Tef == false)
	{
		return false;
	}	
}

function btnDeleteClickindustry(id)
{
	var id = id;
	var newtotal3;
	//alert(vrate1);
	var varDeleteID1 = id;
	//alert(varDeleteID1);
	var fRet4; 
	fRet4 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet4); 
	if (fRet4 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}
	
	var limt = parseFloat(varDeleteID1) + 10;
	for(var i=varDeleteID1;i<=limt;i++)
	{	
		var child1 = document.getElementById('insertrow'+i); //tr name
		var child2 = document.getElementById('tblref'+i); //tr name
		var parent1 = document.getElementById('maintableledger'); // tbody name.
		if (child1 != null) 
		{
			//alert (child1);
			document.getElementById ('maintableledger').removeChild(child1);
			document.getElementById ('maintableledger').removeChild(child2);
			
		}
	}	
	
	document.getElementById("serialnumber").value = parseFloat(varDeleteID1);
	
	totend();
}
</script>



<script language="javascript">
function Funcvoucher()
{

}

function numbervaild(key)
{
	var keycode = (key.which) ? key.which : key.keyCode;

	 if(keycode > 40 && (keycode < 48 || keycode > 57 )&&( keycode < 96 || keycode > 111))
	{
		return false;
	}
}

</script>



<link href="css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link href="css/autocomplete.css" rel="stylesheet">
<script type="text/javascript">
$(function() {

$('#ledger1').autocomplete({
	
	source:"pcledger_cr.php",
	//alert(source);
	minLength:0,
	html: true, 
		select: function(event,ui){
				
			var code = ui.item.id;

			var billwise = ui.item.billwise;
			if(code != '') {
				var textid = $(this).attr('id');
				var res = textid.split("ledger");
				var textid1 = res[0];
				var ressno = res[1];
				
			//	var nno = textid.substr(6,5);
				
				$("#ledgerno1").val(code);
				
			}
			},
			open: function( event, ui ) {
			$("#ledgerno1").val('');  
	   }

    });
 });
function Dis(sno)
{	
	if($('#billwise'+sno).val() == "Yes")
	{
		document.getElementById("selectact"+sno).style.display = "";
	}
}
function Dissub(rid,sid)
{
	$("#refamount"+rid+sid).focus(function(){
	
	$("#refaction"+rid+sid).show();
	});
	
	$("#refaction"+rid+sid).blur(function(){
	$("#refaction"+rid+sid).hide();
	});
}

function Buildledgers(id)
{	
    $('.clientglaccountsc').autocomplete({
	
	source:"pcledger.php",
	//alert(source);
	minLength:0,
	html: true, 
		select: function(event,ui){
				
			var code = ui.item.id;
			var billwise = ui.item.billwise;
			if(code != '') {
				var textid = $(this).attr('id');
				var res = textid.split("ledger");
				var textid1 = res[0];
				var ressno = res[1];
				
			//	var nno = textid.substr(6,5);
				
				$("#ledgerno"+ressno).val(code);
				
			}
			},
    });
}	

$(function() {

$('.from_date').datepicker({
    //weekStart: 1,
    //startDate: startDate,
    //endDate: FromEndDate,
    autoclose: true
});

});

$(document).ready(function($){

	Buildledgers('1');
	
	$('#addmainledger').click( function(){
	var sno = $('#serialnumber').val();
	//alert(sno);
	var rno = parseFloat(sno) - 1;
	//alert(rno);
	var TotalCreditAmt = 0.00;
	var TotalDebitAmt = 0.00;
	var tt = parseFloat(rno);
	
	var ttl = $('#entrytype'+rno).val();
	var cra;
	var dra;
	var nwl = newledger(rno);
	//alert(nwl);
	var nwlsplit = nwl.split("|");
	var nwlamt = nwlsplit[0];
	var nwltype = nwlsplit[1];
	
	
	if(nwltype == "Cr") { var cra = nwlamt; dra = ''; } else { dra = nwlamt; cra = '';}
	
	var appendledger = '<tbody id="insertrow'+sno+'">';
		appendledger = appendledger+'<tr id="idTRI'+sno+'">';
		appendledger = appendledger+'<td id="idTDI'+sno+'" align="left"><input id="serialnumberentries'+sno+'" name="serialnumberentries'+sno+'" type="hidden" align="left" size="2" value="'+sno+'" readonly="">';
		appendledger = appendledger+'<select name="entrytype'+sno+'" id="entrytype'+sno+'" onChange="return FillAmt('+sno+')" style="text-align:left; font-weight:bold;">';
		/*appendledger = appendledger+'<option value="'+nwltype+'" selected="selected">'+nwltype+'</option>';*/
		//appendledger = appendledger+'<option value="">Select</option>';
		/*appendledger = appendledger+'<option value="Cr">Cr</option>';*/
		appendledger = appendledger+'<option value="Dr" selected="selected">Dr</option>';
		appendledger = appendledger+'</select></td>';
		appendledger = appendledger+'<td id="idTDJ'+sno+'" align="left"><input id="ledger'+sno+'" class="clientglaccountsc" name="ledger'+sno+'" type="text" align="left" size="50" style="text-align:left; font-weight:bold;">';
		appendledger = appendledger+'<input id="ledgerno'+sno+'" class="clientglaccountsc" name="ledgerno'+sno+'" type="hidden" align="left" size="50">';
		appendledger = appendledger+'<input id="billwise'+sno+'" class="clientglaccountsc" name="billwise'+sno+'" type="hidden" align="left" size="50">';
		appendledger = appendledger+'</td>';
		appendledger = appendledger+'<td id="idTDK'+sno+'" align="left"><input class="clientglaccountamt" id="amount'+sno+'" name="amount'+sno+'" type="text" align="left" size="12" value="'+nwlamt+'" onBlur="addcommas(this.id)"  onKeyDown="return numbervaild(event)" onFocus="return Dis('+sno+')" onKeyUp="return FillAmt('+sno+')" style="text-align:right; font-weight:bold;"></td>';
		appendledger = appendledger+'<td id="btnact'+sno+'" align="right"><select id="selectact'+sno+'" name="selectact'+sno+'" class="mainrefaction" multiple="multiple" size="3" style="text-align:left; font-weight:bold;display:none">';
		//appendledger = appendledger+'<option value="">Select</option>';
		appendledger = appendledger+'<option value="1">New Ref</option>';
		appendledger = appendledger+'<option value="2">Agst Ref</option>';
		appendledger = appendledger+'<option value="3">On Account</option>';
		appendledger = appendledger+'</select></td>';
		appendledger = appendledger+'<td>&nbsp;</td>';
		appendledger = appendledger+'<td align="right"><input id="cramount'+sno+'" name="cramount'+sno+'" type="text" readonly="readonly" value="'+cra+'" align="right" size="12" onBlur="addcommas(this.id)"  onKeyDown="return numbervaild(event)" style="text-align:right; font-weight:bold;color:#FF0000; border:none; background-color:transparent;"></td>';
		appendledger = appendledger+'<td align="right"><input id="dramount'+sno+'" name="dramount'+sno+'" type="text" readonly="readonly" value="'+dra+'" align="right" size="12" onBlur="addcommas(this.id)"  onKeyDown="return numbervaild(event)" style="text-align:right; font-weight:bold;color:#FF0000; border:none; background-color:transparent;"></td>';
		appendledger = appendledger+'<td><input type="button" value="Del" onClick="return btnDeleteClickindustry('+sno+')"></td>';
		appendledger = appendledger+'</tr>';
		appendledger = appendledger+'</tbody>';
		appendledger = appendledger+'<tbody id="tblref'+sno+'"></tbody>';
		//alert(appendledger);
		$("#maintableledger").append(appendledger);
		
		$("#ledger"+sno).focus();
		
		$('#serialnumber').val(parseInt(sno)+1);
		
		totend();
		
		var vlsno = $('#serialnumber').val();
		var lsno = parseFloat(vlsno) - 1;
		//alert(lsno);
		var action = $('#entrytype'+lsno).val();
		//alert(action);
		Buildledgers(lsno);
		
	 });
		 
	
});

function BalCalc(rid,sid)
{
	var ltype = $('#entrytype'+rid).val();
	var lvalue = $('#amount'+rid).val();
	lvalue=lvalue.replace(/,/g,'');
	var sno = $('#serialnumberref').val();
	var tcr = 0.00
	var tdr = 0.00
	var cramt = 0.00;
	var dramt = 0.00;
	
	for(var i=1;i<=sno;i++)
	{
		if($("#refentrytype"+rid+i).val() != undefined)
		{	
			//alert(i);
			
			if($("#refentrytype"+rid+i).val() == "Cr")
			{	
				//alert("cr");
				var cramt = $("#refamount"+rid+i).val();
				if(cramt == "") { cramt = "0.00"; }
				cramt=cramt.replace(/,/g,'');
				var tcr = parseFloat(tcr) + parseFloat(cramt);
			}
			else
			{	
				//alert("dr");
				var dramt = $("#refamount"+rid+i).val();
				if(dramt == "") { dramt = "0.00"; }
				dramt=dramt.replace(/,/g,'');
				var tdr = parseFloat(tdr) + parseFloat(dramt);
			}
		}
	}
	
	//alert(tcr);
	//alert(tdr);
	if(ltype == "Dr")
	{
		var diff = parseFloat(lvalue) - parseFloat(tdr) + parseFloat(tcr);
		diff = parseFloat(diff).toFixed(2);
		if(parseFloat(diff) < 0)
		{
			diff = Math.abs(diff);
			diff = parseFloat(diff).toFixed(2);
			diff = diff.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			$("#refamount"+rid+sid).val(diff);
			//alert('har1')
			$("#refentrytype"+rid+sid).val("Cr");
		}
		else
		{
			diff = parseFloat(diff).toFixed(2);
			diff = diff.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			$("#refamount"+rid+sid).val(diff);
			$("#refentrytype"+rid+sid).val(ltype);
		}
	}
	else
	{
		var diff = parseFloat(lvalue) - parseFloat(tcr) + parseFloat(tdr);
		diff = parseFloat(diff).toFixed(2);
		if(parseFloat(diff) < 0)
		{
			diff = Math.abs(diff);
			diff = parseFloat(diff).toFixed(2);
			diff = diff.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			$("#refamount"+rid+sid).val(diff);
			$("#refentrytype"+rid+sid).val("Dr");
		}
		else
		{
			diff = parseFloat(diff).toFixed(2);
			diff = diff.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			$("#refamount"+rid+sid).val(diff);
			$("#refentrytype"+rid+sid).val(ltype);
		}
	}
	
	$('#ref'+rid+sid).focus();
	
	ledtotal(rid);	
}

function ledtotal(rid)
{
	var ltype = $('#entrytype'+rid).val();
	var lvalue = $('#amount'+rid).val();
	lvalue=lvalue.replace(/,/g,'');
	var sno = $('#serialnumberref').val();
	var tcr = 0.00
	var tdr = 0.00
	var cramt = 0.00;
	var dramt = 0.00;
	
	for(var i=1;i<=sno;i++)
	{
		if($("#refentrytype"+rid+i).val() != undefined)
		{	
			//alert(i);
		
			if($("#refentrytype"+rid+i).val() == "Cr")
			{	
				//alert("cr");
				var cramt = $("#refamount"+rid+i).val();
				if(cramt == "") { cramt = "0.00"; }
				cramt=cramt.replace(/,/g,'');
				var tcr = parseFloat(tcr) + parseFloat(cramt);
			}
			else
			{	
				//alert("dr");
				var dramt = $("#refamount"+rid+i).val();
				if(dramt == "") { dramt = "0.00"; }
				dramt=dramt.replace(/,/g,'');
				var tdr = parseFloat(tdr) + parseFloat(dramt);
			}
		}
		
		if($("#refori"+rid+i).val() != undefined)
		{
			var refori = $("#refori"+rid+i).val(); 
			if(refori == "") { refori = "0.00"; }
			refori=refori.replace(/,/g,'');
			var criamt = $("#refamount"+rid+i).val();
			if(criamt == "") { criamt = "0.00"; }
			criamt=criamt.replace(/,/g,'');
			if(parseFloat(criamt) > parseFloat(refori))
			{
				alert("Amount exceed balance");
				$("#refamount"+rid+i).val(refori);
				ledtotal(rid);
				return false;
			}
		}
	}
	
	var diff = parseFloat(tdr) - parseFloat(tcr);
	if(parseFloat(diff) < 0)
	{
		var diff = Math.abs(diff);
		diff = parseFloat(diff).toFixed(2);
		diff = diff.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
		$("#totamount"+rid).val(diff);
		//alert('har3')
		$("#totcr"+rid).val("Cr");
	}
	else
	{
		var diff = Math.abs(diff);
		diff = parseFloat(diff).toFixed(2);
		diff = diff.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
		$("#totamount"+rid).val(diff);
		$("#totcr"+rid).val("Dr");
	}
}

function newledger(rid)
{
	var ltype = $('#entrytype'+rid).val();
	var lvalue = $('#amount'+rid).val();
	lvalue=lvalue.replace(/,/g,'');
	var sno = $('#serialnumber').val();
	var tcr = 0.00
	var tdr = 0.00
	var cramt = 0.00;
	var dramt = 0.00;
	
	for(var i=1;i<=sno;i++)
	{
		if($("#entrytype"+i).val() != undefined)
		{	
			//alert(i);
			
			if($("#entrytype"+i).val() == "Cr")
			{	
				//alert("cr");
				var cramt = $("#amount"+i).val();
				if(cramt == "") { cramt = "0.00"; }
				cramt=cramt.replace(/,/g,'');
				var tcr = parseFloat(tcr) + parseFloat(cramt);
			}
			else
			{	
				//alert("dr");
				var dramt = $("#amount"+i).val();
				if(dramt == "") { dramt = "0.00"; }
				dramt=dramt.replace(/,/g,'');
				var tdr = parseFloat(tdr) + parseFloat(dramt);
			}
		}
	}
	
	if($('#entrytype1').val() == "Cr")
	{	
		var vamount = $('#vamount').val();
		vamount=vamount.replace(/,/g,'');
		if(parseFloat(tcr) < parseFloat(vamount)) 
		{	
			var ldiff = parseFloat(tcr) - parseFloat(vamount);
			var ldiff = Math.abs(ldiff);
			ldiff = parseFloat(ldiff).toFixed(2);
			ldiff = ldiff.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			//$("#amount"+rid).val(diff);
			//$("#entrytype"+rid).val("Cr");
			return ldiff+'|'+"Cr";
		}
		else
		{
			var diff = parseFloat(tdr) - parseFloat(tcr);
			if(parseFloat(diff) < 0)
			{
				var diff = Math.abs(diff);
				diff = parseFloat(diff).toFixed(2);
				diff = diff.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				//$("#amount"+rid).val(diff);
				//$("#entrytype"+rid).val("Cr");
				return diff+'|'+"Dr";
			}
			else
			{
				var diff = Math.abs(diff);
				diff = parseFloat(diff).toFixed(2);
				diff = diff.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				//$("#amount"+rid).val(diff);
				//$("#entrytype"+rid).val("Dr");
				return diff+'|'+"Cr";
			}
		}
	}
	else if($('#entrytype1').val() == "Dr")
	{	
		var vamount = $('#vamount').val();
		vamount=vamount.replace(/,/g,'');
		if(parseFloat(tdr) < parseFloat(vamount)) 
		{
			var ldiff = parseFloat(tdr) - parseFloat(vamount);
			var ldiff = Math.abs(ldiff);
			ldiff = parseFloat(ldiff).toFixed(2);
			ldiff = ldiff.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			//$("#amount"+rid).val(diff);
			//$("#entrytype"+rid).val("Cr");
			return ldiff+'|'+"Dr";
		}
		else
		{
			var diff = parseFloat(tdr) - parseFloat(tcr);
			if(parseFloat(diff) < 0)
			{
				var diff = Math.abs(diff);
				diff = parseFloat(diff).toFixed(2);
				diff = diff.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				//$("#amount"+rid).val(diff);
				//$("#entrytype"+rid).val("Cr");
				return diff+'|'+"Dr";
			}
			else
			{
				var diff = Math.abs(diff);
				diff = parseFloat(diff).toFixed(2);
				diff = diff.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				//$("#amount"+rid).val(diff);
				//$("#entrytype"+rid).val("Dr");
				return diff+'|'+"Cr";
			}
		}
	}
}

function DelRef(rid,sid)
{
	var fRet4; 
	fRet4 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet4); 
	if (fRet4 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}
	
	var child1 = document.getElementById('TRIS'+rid+sid); // tbody name.
	if (child1 != null) 
	{
		//alert (child1);
		document.getElementById ('tblrowinsertl'+rid).removeChild(child1);
	}
	
	ledtotal(rid);
}
function addcommas(id)
{
//alert(id);
var totalbillamt = document.getElementById(id).value;
if(totalbillamt!='')
{
totalbillamt=totalbillamt.replace(/,/g,'');
totalbillamt = parseFloat(totalbillamt).toFixed(2);
totalbillamt = totalbillamt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
document.getElementById(id).value=totalbillamt;
}
}

function isNumberDecimal(evt) {
        //getting key code of pressed key  
        var charCode = (evt.which) ? evt.which : evt.keyCode
		//comparing pressed keycodes
		
        if (  (charCode < 48 || charCode > 57) && charCode != 46)
            return false;
        return true;
} 
	
function Ledgeractiondel(varCallFrom,docno)
{
 var varCallFrom = varCallFrom;
 var docno = docno;
 var ledno = document.getElementById("ledgerno"+varCallFrom).value;
// var Sel = document.getElementById("selectact"+varCallFrom).value;
// if(Sel == 2) {
 window.open("popup_ledgeraction.php?callfrom="+varCallFrom+"&&docno="+docno+"&&ledno="+ledno,"Window2",'toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=no,width=750,height=350,left=100,top=100');
 //window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
	//}
}

function ucFirstAllWords1( str,id,key)

{

 var keycode = (key.which) ? key.which : key.keyCode; 

 //alert(str);  

  var pieces = str.split(" ");

  //alert(pieces);

  for ( var i = 0; i < pieces.length; i++ )

  {

   var j = pieces[i].charAt(0).toUpperCase();

   pieces[i] = j + pieces[i].substr(1);

  }

  var word = pieces.join(" ");

  //alert(word);

  document.getElementById(id).value=word;

} 

</script>
<script type="text/javascript">
function FillAmt(id)
{	
	Buildledgers(id);
	
	var Amt = $('#amount'+id).val();
	if(Amt == '') { Amt = 0.00; }
	Amt=Amt.replace(/,/g,'');
	Amt = parseFloat(Amt).toFixed(2);
	Amt = Amt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	
	if($('#entrytype'+id).val() == "Cr")
	{
		$('#cramount'+id).val(Amt);
		$('#dramount'+id).val("");
	}
	else
	{
		$('#dramount'+id).val(Amt);
		$('#cramount'+id).val("");
	}
	
	totend();
}

function totend()
{
	var lim = document.getElementById("serialnumber").value;
	var TotalCreditAmt = 0.00;
	var TotalDebitAmt = 0.00;
	for(var i=1;i<=lim;i++)
	{
		
		if(document.getElementById("entrytype"+i)!=null)
		{	
			var Flg = "false";
			
			if(document.getElementById("entrytype"+i).value == "Cr")
			{
				var CreditAmt = document.getElementById("amount"+i).value;
				if(CreditAmt == '') { CreditAmt = 0.00; }
				CreditAmt=CreditAmt.replace(/,/g,'');
				TotalCreditAmt = parseFloat(TotalCreditAmt) + parseFloat(CreditAmt);
				//alert(TotalCreditAmt);
			}
			else
			{
				var DebitAmt = document.getElementById("amount"+i).value;
				if(DebitAmt == '') { DebitAmt = 0.00; }
				DebitAmt=DebitAmt.replace(/,/g,'');
				TotalDebitAmt = parseFloat(TotalDebitAmt) + parseFloat(DebitAmt);
				//alert(TotalDebitAmt);
			}
		}
	}
	
	TotalCreditAmt = parseFloat(TotalCreditAmt).toFixed(2);
	TotalCreditAmt = TotalCreditAmt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	
	TotalDebitAmt = parseFloat(TotalDebitAmt).toFixed(2);
	TotalDebitAmt = TotalDebitAmt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	
	document.getElementById("totalcr").value = TotalCreditAmt;
	document.getElementById("totaldr").value = TotalDebitAmt;
}
</script>
<script src="js/datetimepicker_css.js"></script>
<?php 
if(isset($_REQUEST['docno'])) { $docno = $_REQUEST['docno']; } else { $docno = ''; }
  $querry=" select  * from pcrequest where  delete_status <>'deleted'  and approved_status ='3' and doc_no='$docno'";
 
	$exe=mysqli_query($GLOBALS["___mysqli_ston"], $querry);
	$result=mysqli_fetch_array($exe);
	$approved_amt=$result['approved_amt'];
	$doc_no=$result['doc_no'];
	
	
 ?>
</head>
<body id="voucherbgcolor" onLoad="return FillAmt('1')">
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
    <td width="10%">&nbsp;</td>
    <td width="90%" valign="top">
	
			  <form name="form1" id="form1" method="post" action="pettycashallocation.php" enctype="multipart/form-data" >
			  
                  <table width="918" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                      <tr bgcolor="#011E6A">
                        <td colspan="7" bgcolor="#999999" class="bodytext11"><strong> Journal Entries - Add New </strong></td>
						<td align="right" colspan="2" bgcolor="#999999" class="bodytext11">&nbsp;</td>
                      </tr>
					  <?php if(isset($_REQUEST['st'])) { $st = $_REQUEST['st']; } else { $st = ""; } 
					  if($st == 'success') { ?>
					  <tr>
                        <td colspan="8" bgcolor="#00FF33" align="left" valign="middle" class="bodytext3"><div align="left" style="font-size:12px"><strong><?php echo "Entry Saved"; ?></strong></div></td>
                      </tr>
					  <?php } ?>
					   <tr>
                        <td colspan="4" align="left" valign="middle" class="bodytext3">&nbsp;</td>
                      </tr>
					   <tr>
                        <td width="142" align="left" valign="middle"  class="bodytext3"><div align="right">ID </div></td>
                        <td align="left" colspan="3" valign="top"><input type="text" name="entryid" id="entryid" value="<?php echo $docno1; ?>" size="20" readonly>
						</td>
					  </tr>
					   <tr>
                        <td align="left" valign="middle" class="bodytext3"><div align="right">Entry Date</div></td>
                        <td align="left" colspan="3" valign="top"><input type="text" name="entrydate" id="entrydate" size="10" value="<?php echo date('Y-m-d'); ?>" readonly>
						<img src="images2/cal.gif" onClick="javascript:NewCssCal('entrydate')" style="cursor:pointer"/> 
						</td>
					  </tr>
					 
					   <tr>
                        <td align="left" valign="middle" class="bodytext3"><div align="right">Location</div></td>
                        <td align="left" colspan="3" valign="top">
					  <select name="location" id="location" onChange="locationform(form1,this.value); ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
                      <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$sessiondocno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>"><?php echo $res1location; ?></option>
						<?php
						}
						?>
                  </select>
				  </td>
                  </tr>
				   <tr>
					<td align="left" valign="middle" class="bodytext3"><div align="right">&nbsp; </div></td>
					<td align="left" colspan="3" valign="top">
					<input id="vamount" name="vamount" type="hidden" align="left" size="12" onBlur="addcommas(this.id)"  onKeyDown="return numbervaild(event)" style="text-align:right; font-weight:bold;">
					</td>
				  </tr>
						<tr>
						<td colspan="10">
						<table align="left" id="maintableledger" width="100%" border="0" cellpadding="4" cellspacing="4" style="border-collapse:collapse">
						<tbody>
						<tr id="heading" style="display:;" bgcolor="#ecf0f5">
						<td align="left" class="bodytext11"><strong>Type</strong></td>
						<td width="50" align="left" class="bodytext11"><strong>Ledger</strong></td>
						<td colspan="2" align="center" class="bodytext11"><strong>Amount</strong></td>
						<td align="right" class="bodytext11">&nbsp;</td>
						<td align="right" class="bodytext11"><strong>Credit Amount</strong></td>
						<td align="right" class="bodytext11"><strong>Debit Amount</strong></td>
						<td align="right" class="bodytext11"><strong>&nbsp;</strong></td>
						</tr>
						</tbody>
						<tbody id="insertrow1" style="display:;">
						<tr id="idTRI1">
						<td id="idTDI1" align="left"><input id="serialnumberentries1" name="serialnumberentries1" type="hidden" align="left" size="2" value="1" readonly>
						<select name="entrytype1" id="entrytype1" onChange="return FillAmt('1')" style="text-align:left; font-weight:bold;" >
						<!--<option value="">Select</option>-->
						<option value="Cr">Cr</option >
						<!--<option value="Dr">Dr</option>-->
						</select></td>
						<td id="idTDJ1" align="left"><input id="ledger1"  name="ledger1" type="text" align="left" size="50" style="text-align:left; font-weight:bold;" >
						<input id="ledgerno1" class="clientglaccountsc" name="ledgerno1" type="hidden" align="left" size="50" value="">
						<input id="billwise1" class="clientglaccountsc" name="billwise1" type="hidden" align="left" size="50">
						</td>
						<td id="idTDK1" align="left"><input class="clientglaccountamt" value="<?php echo number_format($approved_amt,2,'.',','); ?>" id="amount1" name="amount1" type="text" align="left" size="12" onKeyUp="addcommas(this.id)"  onKeyDown="return numbervaild(event)" onBlur="return FillAmt('1')" onFocus="return Dis('1')" style="text-align:right; font-weight:bold;" readonly ></td>
						<td id="btnact1" align="right">
						<select id="selectact1" name="selectact1" class="mainrefaction" multiple="multiple" size="3" style="text-align:left; font-weight:bold; display:none;">
						<option value="1">New Ref</option>
						<option value="2">Agst Ref</option>
						<option value="3">On Account</option>
						</select>
						</td>
						<td>&nbsp;</td>
						<td align="right"><input id="cramount1" name="cramount1" type="text" align="right" readonly size="12" onBlur="addcommas(this.id)"  onKeyDown="return numbervaild(event)" style="text-align:right; font-weight:bold; color:#FF0000; border:none; background-color:transparent;"></td>
						<td align="right"><input id="dramount1" name="dramount1" type="text" align="right" readonly size="12" onBlur="addcommas(this.id)"  onKeyDown="return numbervaild(event)" style="text-align:right; font-weight:bold;color:#FF0000; border:none; background-color:transparent;"></td>
						</tr>
						</tbody>
						<tbody id="tblref1">
						
						</tbody>
						</table>
						</td>
						</tr>
						
						<tr id="theading" style="display:;">
						<td width="42" align="left" class="bodytext13"><strong><input type="button" name="Add" value="Add Ledger" id="addmainledger" /></strong></td>
						<td width="36" align="left" class="bodytext13"><strong>&nbsp;</strong></td>
						<td colspan="2" align="center" class="bodytext13"><strong>&nbsp;</strong></td>
						<td width="257" align="right" class="bodytext13">&nbsp;</td>
						<td width="350" align="center" class="bodytext13"><strong>
						  <input id="totalcr" name="totalcr" type="text" align="right" readonly size="12" onBlur="addcommas(this.id)"  onKeyDown="return numbervaild(event)" style="text-align:right; font-weight:bold; background-color: transparent; border:none; color:#FF0000"></strong></td>
						<td width="92" align="center" class="bodytext13"><strong>
						  <input id="totaldr" name="totaldr" type="text" align="right" readonly size="12" onBlur="addcommas(this.id)"  onKeyDown="return numbervaild(event)" style="text-align:right; font-weight:bold; background-color: transparent; border:none; color:#FF0000"></strong></td>
						  <td width="60" align="right" class="bodytext13">&nbsp;</td>
						</tr>
						
						 <tr>
                        <td align="left" valign="middle" class="bodytext3"><div align="right">Narration</div></td>
                        <td align="left" colspan="3" valign="top"><textarea name="narration" id="narration" rows="3" cols="30"></textarea>
						</td>
					    </tr>
                        <tr id="sbtn" style="display:;">
                        <td align="left" valign="top">&nbsp;</td>
                        <td width="293" colspan="1" align="left" valign="middle" >
                        <input type="hidden" name="frmflag" value="addnew" />
						<input type="hidden" name="serialnumber" id="serialnumber" value="2" size="1" />
						<input type="hidden" name="serialnumberref" id="serialnumberref" value="1" size="1" />
						<input type="hidden" name="subrefserial" id="subrefserial" value="1" size="1" />
                        <input type="hidden" name="frmflag1" value="frmflag1" />
                        <input type="hidden" name="ddoc" id="ddoc" value="<?php echo $doc_no; ?>" size="1" />
						   <input type="submit" name="Submit" value="Submit" onClick="return entries()"/>&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="reset" name="reset" value="Reset" onClick="javascript: var aa = confirm('Are you Sure to Reset ?'); if(aa == false) { return false; } window.location = 'pettycashallocation.php'" />
                          </td>
                      </tr>	
        </table> 
		
              </form>
   </td>
  </tr>
</table>

</body>
</html>


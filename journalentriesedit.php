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
$sessiondocno = $_SESSION['docno'];

//get request docno
//$doc_no = $_GET['docno'];

if(isset($_GET['docno'])){ $doc_no=$_GET['docno']; }else{ $doc_no = $_REQUEST['doc_no']; }




$query31 = "select fromyear,toyear from master_financialyear where status = 'Active' order by auto_number desc";
$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
$res31 = mysqli_fetch_array($exec31);
$finfromyear = $res31['fromyear'];
$fintoyear = $res31['toyear'];

if(isset($_REQUEST['frmflag1'])) { $frmflag1 = $_REQUEST['frmflag1']; } else { $frmflag1 = ''; }
if($frmflag1 == 'frmflag1')
{

$paynowbillprefix = 'EN-';
$paynowbillprefix1=strlen($paynowbillprefix);
 $query2 = "select * from master_journalentries order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
 $billnumbercode ='EN-'.'1';
}
else
{
 $billnumber = $res2["docno"];
 $billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

 $billnumbercode = intval($billnumbercode);
 $billnumbercode = $billnumbercode + 1;
 $maxanum = $billnumbercode;
 $billnumbercode = 'EN-' .$maxanum;
  
} 
$docno = $billnumbercode;

//$entryid = $_REQUEST['entryid'];
$entrydate = $_REQUEST['entrydate'];
$entrydate = date('Y-m-d',strtotime($entrydate));
$narration = $_REQUEST['narration'];
$count_arr = $_REQUEST['count_arr'];
//$locationcode = $_REQUEST['location'];

$doc_no = $_REQUEST['doc_no'];
$loca_id = $_REQUEST['loca_id'];

$query66 = "select locationname from master_location where locationcode = '$loca_id'";
$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
$res66 = mysqli_fetch_array($exec66);
$locationname = $res66['locationname'];


for($i=1;$i<=$count_arr;$i++)
{
	$entrytype = $_REQUEST['entrytype'.$i];
	$ledger = $_REQUEST['ledger'.$i];
	$ledgerno = $_REQUEST['ledgerno'.$i];
	$oldledgerno = $_REQUEST['oldledgerno'.$i];
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

	$query7 = "UPDATE `master_journalentries` SET `selecttype`='$entrytype',`ledgername`='$ledger',`ledgerid`='$ledgerno',`transactionamount`='$amount',`creditamount`='$creditamount',`debitamount`='$debitamount',`ipaddress`='$ipaddress',`updatedatetime`='$updatedatetime',`narration`='$narration',`edited_by`='$username' WHERE `docno`='$doc_no' AND `ledgerid`='$oldledgerno' AND `locationcode`='$loca_id' AND `selecttype`='$entrytype'";

	$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));

}

header("location:journaledit.php?st=success");

}

?>

<?php

$paynowbillprefix = 'EN-';
$paynowbillprefix1=strlen($paynowbillprefix);
 $query2 = "select * from master_journalentries order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
 $billnumbercode ='EN-'.'1';
}
else
{
 $billnumber = $res2["docno"];
 $billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

 $billnumbercode = intval($billnumbercode);
 $billnumbercode = $billnumbercode + 1;
 $maxanum = $billnumbercode;
 $billnumbercode = 'EN-' .$maxanum;
  
} 
$docno = $billnumbercode;
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
			
			if(document.getElementById("ledger"+i).value == "")
			{
				alert("Please Select Ledger");
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
	
	source:"ajaxentriesvoucherledger.php",
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
		appendledger = appendledger+'<option value="'+nwltype+'" selected="selected">'+nwltype+'</option>';
		//appendledger = appendledger+'<option value="">Select</option>';
		appendledger = appendledger+'<option value="Cr">Cr</option>';
		appendledger = appendledger+'<option value="Dr">Dr</option>';
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
<script src="js/datetimepicker_css_fin.js"></script>
</head>
<body id="voucherbgcolor">
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
	
			  <form name="form1" id="form1" method="post" action="journalentriesedit.php" enctype="multipart/form-data" >
			  
                  <table width="918" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                      <tr bgcolor="#011E6A">
                        <td colspan="7" bgcolor="#999999" class="bodytext11"><strong> Journal Entries - Edit </strong></td>
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
                      <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$sessiondocno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						  $res1location = $res1["locationname"];
						  $res1locationanum = $res1["locationcode"];
					    }
					  ?>
                      <?php 
                       //get journal by doc_no
                      $totaldr = '0.00';
			          $totalcr = '0.00';
                      $query_journal = "SELECT * FROM master_journalentries WHERE locationcode = '$res1locationanum' AND docno LIKE '$doc_no' order by auto_number";
                      $exec_journal = mysqli_query($GLOBALS["___mysqli_ston"], $query_journal) or die ("Error in Query_journal".mysqli_error($GLOBALS["___mysqli_ston"]));
				      while($res_journal = mysqli_fetch_array($exec_journal))
						{
							//$res2billnumber = $res2['docno'];
			                $transdate = $res_journal['entrydate'];
			                $loca = $res_journal['locationname'];
			                $loca_id = $res_journal['locationcode'];
						}
                      ?>
					   <tr>
                        <td width="142" align="left" valign="middle"  class="bodytext3"><div align="right">ID </div></td>
                        <td align="left" colspan="3" valign="top"><input type="text" name="doc_no" id="doc_no" value="<?php echo $doc_no; ?>" size="20" readonly="readonly">
						</td>
					  </tr>
					   <tr>
                        <td align="left" valign="middle" class="bodytext3"><div align="right">Entry Date</div></td>
                        <td align="left" colspan="3" valign="top"><input type="text" name="entrydate" id="entrydate" size="10" value="<?php echo $transdate; ?>" readonly="readonly">
						<!--<img src="images2/cal.gif" onClick="javascript:NewCssCal('entrydate','','','','','','past','<?= $finfromyear; ?>','<?= $fintoyear; ?>')" style="cursor:pointer"/> -->
						</td>
					  </tr>
					 
					   <tr>
                        <td align="left" valign="middle" class="bodytext3"><div align="right">Location</div></td>
                        <td align="left" colspan="3" valign="top">
                       <!--
					  <select name="location" id="location" onChange="locationform(form1,this.value); ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
                      <?php
						
						/*$query1 = "select * from login_locationdetails where username='$username' and docno='$sessiondocno' group by locationname order by locationname";
						echo $query1;
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>"><?php echo $res1location; ?></option>
						<?php
						}*/
						?>
                       </select>-->
                       <input type="text" name="locat" id="locat" value="<?php echo $loca;?>" readonly="readonly">
                       <input type="hidden" name="loca_id" id="loca_id" value="<?php echo $loca_id;?>" readonly="readonly">
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
						<td colspan="2" align="left" class="bodytext11"><strong>Type</strong></td>
						<td width="50" align="left" class="bodytext11"><strong>Ledger</strong></td>
						<td colspan="2" align="center" class="bodytext11"><strong>Amount</strong></td>
						<td align="right" class="bodytext11">&nbsp;</td>
						<td align="right" class="bodytext11"><strong>Credit Amount</strong></td>
						<td align="right" class="bodytext11"><strong>Debit Amount</strong></td>
						<td align="right" class="bodytext11"><strong>&nbsp;</strong></td>
						</tr>
						</tbody>
						<?php
						$sno = 0;
                        $query_journal1 = "select * from master_journalentries where locationcode = '$res1locationanum' and docno = '$doc_no' order by selecttype desc";
						$exec_journal1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_journal1) or die ("Error in query_journal1" .mysqli_error($GLOBALS["___mysqli_ston"]));
						$count_arr = mysqli_num_rows($exec_journal1);
						while($res_journal1 = mysqli_fetch_array($exec_journal1))
						{
						$ledgerid = $res_journal1['ledgerid'];
						$ledgername = $res_journal1['ledgername'];
						$res3transactionamount = $res_journal1['transactionamount'];
						$username = $res_journal1['username'];
						$updatetime = $res_journal1['updatedatetime'];
						$narration = $res_journal1['narration'];
						$selecttype = $res_journal1['selecttype'];
						$creditamount = $res_journal1['creditamount'];
						$debitamount = $res_journal1['debitamount'];
						$sno = $sno + 1;
						if($selecttype == 'Dr')
						{
							$totaldr = $totaldr + $res3transactionamount;
						}
						else
						{
							$totalcr = $totalcr + $res3transactionamount;
						}
                      ?>
                      <tbody id="insertrow1" style="display:;">
                         <tr id="idTRI1">
                         	<td id="idTDJ1" align="left">
								<input type="hidden" name="chk[]" id="chk<?php echo $sno; ?>" value="<?php echo $sno; ?>">
							</td>
                         	<td id="idTDI1" align="left"><input id="serialnumberentries1" name="serialnumberentries1" type="hidden" align="left" size="2" value="1" readonly="">
								<select name="entrytype<?php echo $sno;?>" id="entrytype<?php echo $sno;?>" onChange="return FillAmt('<?php echo $sno;?>')" style="text-align:left; font-weight:bold;">
								<!--<option value="">Select</option>-->
									<?php
									   if($selecttype=='Dr'){
									?>
									    <option value="<?php echo $selecttype;?>" selected><?php echo $selecttype;?></option>
								    <?php } ?>
								    <?php
									   if($selecttype=='Cr'){
									?>
									    <option value="<?php echo $selecttype;?>" selected><?php echo $selecttype;?></option>
								    <?php } ?>
								</select>
							</td>
							<td id="idTDJ1" align="left">
								<input id="ledger<?php echo $sno;?>" class="clientglaccountsc" name="ledger<?php echo $sno;?>" type="text" align="left" size="50" style="text-align:left; font-weight:bold;" value="<?php echo $ledgername;?>">
								<input id="oldledgerno<?php echo $sno;?>" class="clientglaccountsc" name="oldledgerno<?php echo $sno;?>" type="hidden" align="left" size="50" value="<?php echo $ledgerid;?>">
								<input id="ledgerno<?php echo $sno;?>" class="clientglaccountsc" name="ledgerno<?php echo $sno;?>" type="hidden" align="left" size="50" value="<?php echo $ledgerid;?>">
								<input id="billwise<?php echo $sno;?>" class="clientglaccountsc" name="billwise<?php echo $sno;?>" type="hidden" align="left" size="50">
							</td>
							<td id="idTDK1" align="left">
								<input class="clientglaccountamt" id="amount<?php echo $sno;?>" name="amount<?php echo $sno;?>" type="text" align="left" size="12" onBlur="addcommas(this.id)"  onKeyDown="return numbervaild(event)" onKeyUp="return FillAmt('<?php echo $sno;?>')" onFocus="return Dis('<?php echo $sno;?>')" style="text-align:right; font-weight:bold;" value="<?php if($selecttype == 'Dr'){ echo number_format($debitamount,2,'.',',');}elseif($selecttype == 'Cr'){ echo number_format($creditamount,2,'.',','); }?>">
							</td>
							<td id="btnact1" align="right">
								<select id="selectact<?php echo $sno;?>" name="selectact<?php echo $sno;?>" class="mainrefaction" multiple="multiple" size="3" style="text-align:left; font-weight:bold; display:none;">
								<option value="1">New Ref</option>
								<option value="2">Agst Ref</option>
								<option value="3">On Account</option>
								</select>
							</td>
							<td>&nbsp;</td>
							<td align="right">
								<input id="cramount<?php echo $sno;?>" name="cramount<?php echo $sno;?>" type="text" align="right" readonly="readonly" size="12" onBlur="addcommas(this.id)"  onKeyDown="return numbervaild(event)" style="text-align:right; font-weight:bold; color:#FF0000; border:none; background-color:transparent;" value="<?php echo number_format($creditamount,2,'.',','); ?>">
							</td>
							<td align="right">
								<input id="dramount<?php echo $sno;?>" name="dramount<?php echo $sno;?>" type="text" align="right" readonly="readonly" size="12" onBlur="addcommas(this.id)"  onKeyDown="return numbervaild(event)" style="text-align:right; font-weight:bold;color:#FF0000; border:none; background-color:transparent;" value="<?php echo number_format($debitamount,2,'.',','); ?>">
							</td>
                         </tr>
                      </tbody>
                      <?php
                        }
                      ?>

						</table>
						</td>
						</tr>
						
						<tr id="theading" style="display:;">
							<!--<td width="42" align="left" class="bodytext13"><strong><input type="button" name="Add" value="Add Ledger" id="addmainledger" /></strong>
							</td>
							<td width="36" align="left" class="bodytext13"><strong>&nbsp;</strong></td>
							<td colspan="2" align="center" class="bodytext13"><strong>&nbsp;</strong></td>
							<td width="257" align="right" class="bodytext13">&nbsp;</td>
							<td width="350" align="center" class="bodytext13"><strong>
							  <input id="totalcr" name="totalcr" type="text" align="right" readonly="readonly" size="12" onBlur="addcommas(this.id)"  onKeyDown="return numbervaild(event)" style="text-align:right; font-weight:bold; background-color: transparent; border:none; color:#FF0000"></strong></td>
							<td width="92" align="center" class="bodytext13"><strong>
							  <input id="totaldr" name="totaldr" type="text" align="right" readonly="readonly" size="12" onBlur="addcommas(this.id)"  onKeyDown="return numbervaild(event)" style="text-align:right; font-weight:bold; background-color: transparent; border:none; color:#FF0000"></strong></td>
							  <td width="60" align="right" class="bodytext13">&nbsp;</td>-->
						</tr>
						
						<tr>
	                        <td align="left" valign="middle" class="bodytext3"><div align="right">Narration</div></td>
	                        <td align="left" colspan="3" valign="top">
	                        	<input type="hidden" name="count_arr" id="count_arr" value="<?php echo $count_arr;?>">
	                        	<textarea name="narration" id="narration" rows="3" cols="30"><?php echo $narration;?></textarea>
							</td>
					    </tr>-->
                        <tr id="sbtn" style="display:;">
	                        <td align="left" valign="top">&nbsp;</td>
	                        <td width="293" colspan="1" align="left" valign="middle" >
		                        <input type="hidden" name="frmflag" value="addnew" />
								<input type="hidden" name="serialnumber" id="serialnumber" value="2" size="1" />
								<input type="hidden" name="serialnumberref" id="serialnumberref" value="1" size="1" />
								<input type="hidden" name="subrefserial" id="subrefserial" value="1" size="1" />
		                        <input type="hidden" name="frmflag1" value="frmflag1" />
		                    
								<input type="submit" name="Submit" value="Submit" onClick="return entries()"/>&nbsp;&nbsp;&nbsp;&nbsp;
		                       <!-- <input type="reset" name="reset" value="Reset" onClick="javascript: var aa = confirm('Are you Sure to Reset ?'); if(aa == false) { return false; } window.location = 'entries.php'" />-->
	                        </td>
                      </tr>	
        </table> 
		
              </form>
   </td>
  </tr>
</table>

</body>
</html>


<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
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
$query31 = "select fromyear,toyear from master_financialyear where status = 'Active' order by auto_number desc";
$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
$res31 = mysqli_fetch_array($exec31);
$finfromyear = $res31['fromyear'];
$fintoyear = $res31['toyear'];
if(isset($_REQUEST['frmflag1'])) { $frmflag1 = $_REQUEST['frmflag1']; } else { $frmflag1 = ''; }
if($frmflag1 == 'frmflag1')
{
$entryid = $_REQUEST['entryid'];	
$query2 = "select * from master_journalentries where docno ='$entryid'";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_num_rows($exec2);
if($res2>0){

$entrydate = $_REQUEST['entrydate'];
$entrydate = date('Y-m-d',strtotime($entrydate));
$narration = $_REQUEST['narration'];
$locationcode = $_REQUEST['location'];

$query66 = "select locationname from master_location where locationcode = '$locationcode'";
$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));
$res66 = mysqli_fetch_array($exec66);
$locationname = $res66['locationname'];
///////////////////
$total_debitamount=0;
$total_creditamount=0;
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
			
			if($ledgerno!=''){
				$total_debitamount +=$debitamount;
				$total_creditamount +=$creditamount;
			}
		}
	}
}
if($total_debitamount == $total_creditamount)
{
	//save the data into db
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
			$remark = $_REQUEST['remark'.$i];
			$journal_id = $_REQUEST['journal_id'.$i];
			$tb_id = $_REQUEST['tb_id'.$i];
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
			
			if(isset($_REQUEST['costcenter'.$i]))
			{
			$costcenter = $_REQUEST['costcenter'.$i];
			}else{
			$costcenter = "";	
			}
			if($ledgerno!=''){
				
				$query7 = "update master_journalentries set entrydate='$entrydate',selecttype='$entrytype',ledgerid='$ledgerno',ledgername='$ledger',cost_center='$costcenter',transactionamount='$amount',creditamount='$creditamount',debitamount='$debitamount',username='$username',updatedatetime='$updatedatetime',locationcode='$locationcode',locationname='$locationname',narration='$narration',remarks='$remark' where docno='$entryid' and auto_number='$journal_id'";
				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				
			}
		}
	}
}
	if (isset($_SESSION['items'])) {
	   unset($_SESSION['items']);
    }
	
}
else
{
	
	if (isset($_SESSION['items'])) {
	   unset($_SESSION['items']);
    }
// do not save the data into db
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
			$remark = $_REQUEST['remark'.$i];
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
			$costcenter = "";
			if(isset($_REQUEST['costcenter'.$i]))
			{
				$costcenter = $_REQUEST['costcenter'.$i];
			}
			if($ledgerno!=''){
				$_SESSION['items'][$i] = array('entrytype' => $entrytype, 'ledger' => $ledger, 'ledgerno' => $ledgerno, 'amount' => $amount, 'billwise' => $billwise, 'remark' => $remark,'costcenter' => $costcenter);
			}
		}
	}
}
	header("location:entries.php");
}
header("location:editentries.php");
exit;
}
//////////////////
//exit;
?>
<script>
		window.open("journalprint.php?billnumber=<?php echo $docno; ?>", "OriginalWindow", 'width=522,height=650,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
		window.open("entries.php?st=success","_self")
	</script>
<?php
}
?>
<?php
$entryid='';
$entrydate_jour='';
$locationcode_jour='';
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if ($cbfrmflag1 == 'cbfrmflag1'){ 
$entryid = $_POST['entryid'];

$query1 = "select * from master_journalentries where docno='$entryid' group by docno";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$entrydate_jour = $res1["entrydate"];
	$locationcode_jour = $res1["locationcode"];
	
}


}


function processReplacement($one, $two)
{
return $one . strtoupper($two);
}
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
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />   
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
		alert ("Please Select Ledger Properly.");
		document.form1.ledger1.focus();
				document.getElementById("ledger1").value = "";
				document.getElementById("ledgerno1").value = "";
				// document.getElementById("ledger1").focus();
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
				document.getElementById("ledgerno"+i).value = "";
				return false;
			}
			if(document.getElementById("ledgerno"+i).value == "")
			{
				alert("Please Select Ledger Properly!");
				document.getElementById("ledger"+i).value = "";
				document.getElementById("ledgerno"+i).value = "";
				document.getElementById("ledger"+i).focus();
				// $("#ledgerno"+i).val("");
				// $("#ledgerno"+i).focus();
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
		var flag = validate_costcenter(i);
		if(flag === false)
		{
			return false;
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
<!--<link href="css/bootstrap.min.css" rel="stylesheet">-->
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
			var ledger_groupid = ui.item.ledgergroupid;
			if(code != '') {
				var textid = $(this).attr('id');
				var res = textid.split("ledger");
				var textid1 = res[0];
				var ressno = res[1];
				
			//	var nno = textid.substr(6,5);
			
			var current_ledgerid = $(this).attr("id");
			var ledgerres = current_ledgerid.split("ledger");
			var current_id = ledgerres[1];
					var sno = $('#serialnumber').val();
					//var rno = parseFloat(sno) - 1;
					var rno = current_id;
				$("#ledgerno"+ressno).val(code);
				//alert(ledger_groupid);
				$.ajax({
				  url: 'ajax/getcostcenters.php',
				  type: 'GET',
				  //async: false,
				  dataType: 'json',
				  //processData: false, 
				   data: { 
		      		group_id: ledger_groupid,
		      		ref_no:rno
		 		 },   
				  success: function (data) { 
				  	
				  	
				  	console.log(data.msg);
				  	console.log(data.status);
					console.log('rno'+rno)
				  	var response_data = data.msg;
				  	if(response_data !="")
				  	{
				  		//$('#costcentertd').show();
				  		$('#showhide').show();
				  		$('#costcenter_tdcontent'+rno).html('');
				  		$('#costcenter_tdcontent'+rno).html(response_data);
				  		//$('#costcenterid'+rno).val(ledger_groupid);
				  		
				  		
				  	}
				  	else
				  	{
				  		//$('#showhide').hide();
				  		$('#costcenter_tdcontent'+rno).html('');
				  		//$('#costcentertd').hide();
				  		var costcenter_entries = 0;
	  					var costcenter_cnt = sno;
				  		for(i=1;i<=costcenter_cnt;i++)
					  	{
					  		if($("#costcenter"+i).is(":visible")){
				          	 costcenter_entries = parseInt(costcenter_entries) + 1;
					  		}
					  	}
					  	console.log(costcenter_entries);
					  	if(parseInt(costcenter_entries)  == 0)
					  	{
					  		//$('#costcenter_tdcontent'+sno).show();
					  		$('#costcenter_tdcontent'+rno).html('');
					  		//var style='';
					  		//$('#costcenter_tdcontent'+rno).hide();
					  	}
				  		//$('#costcenter_tdcontent'+rno).hide();
				  		//$('#costcenterid'+rno).val('');
				  		showemptycenter();
				  		
				  	}
				  }
				});
			}
			},
    });
}	
function showemptycenter()
{
		var sno = $('#serialnumber').val();
		var costcenter_entries = 0;
	  	var costcenter_cnt = sno;
	for(i=1;i<=costcenter_cnt;i++)
					  	{
					  		if($("#costcenter"+i).is(":visible")){
				          	 costcenter_entries = parseInt(costcenter_entries) + 1;
					  		}
					  	}
					  	console.log(costcenter_entries);
					  	if(parseInt(costcenter_entries)  == 0)
					  	{
					  		console.log('show empty cost center')
					  	}
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
	// check if the ledger is of expense then check if the cost center is selected
	//$("#yourSelect option[value='yourValue']").length > 0;
	var sno = $('#serialnumber').val();
	//alert(sno);
	var rno = parseFloat(sno) - 1;
	//alert(rno);
	var flag = validate_costcenter(rno);
	if(flag === false)
	{
		return false;
	}
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
		var style=' style="display: none;" ';
		var costcenter_entries = 0;
	  	var costcenter_cnt = sno;
	  	for(i=1;i<=costcenter_cnt;i++)
	  	{
	  		if($("#costcenter"+i).is(":visible")){
          	 costcenter_entries = parseInt(costcenter_entries) + 1;
	  		}
	  	}
	  	console.log(costcenter_entries);
	  	if(parseInt(costcenter_entries)  > 0)
	  	{
	  		//$('#costcenter_tdcontent'+sno).show();
	  		//$('#costcenter_tdcontent'+rno).html('');
	  		var style='';
	  	}
	  	var style='';
		//appendledger = appendledger+'<td id="costcenter_tdcontent'+sno+'" align="left" style="display: none;"></td>';
		appendledger = appendledger+'<td id="costcenter_tdcontent'+sno+'" align="left" '+style+'></td>';
		appendledger = appendledger+'<td id="idTDK'+sno+'" align="left"><input class="clientglaccountamt" id="amount'+sno+'" name="amount'+sno+'" type="text" align="left" size="12" value="'+nwlamt+'" onBlur="addcommas(this.id)"  onKeyDown="return numbervaild(event)" onFocus="return Dis('+sno+')" onKeyUp="return FillAmt('+sno+')" style="text-align:right; font-weight:bold;"></td>';
		// remark
		appendledger = appendledger+'<td>&nbsp;</td>';
		appendledger = appendledger+'<td id="idTDK'+sno+'" align="left"><textarea class="clientglaccountremarks" id="remark'+sno+'" name="remark'+sno+'" type="text" align="left" rows="2" cols="15"  style="font-weight:bold;"></textarea></td>';
		appendledger = appendledger+'<td id="btnact'+sno+'" align="right"><select id="selectact'+sno+'" name="selectact'+sno+'" class="mainrefaction" multiple="multiple" size="3" style="text-align:left; font-weight:bold;display:none">';
		//appendledger = appendledger+'<option value="">Select</option>';
		appendledger = appendledger+'<option value="1">New Ref</option>';
		appendledger = appendledger+'<option value="2">Agst Ref</option>';
		appendledger = appendledger+'<option value="3">On Account</option>';
		appendledger = appendledger+'</select></td>';
		appendledger = appendledger+'<td align="right"><input id="cramount'+sno+'" name="cramount'+sno+'" type="text" readonly="readonly" value="'+cra+'" align="right" size="12" onBlur="addcommas(this.id)"  onKeyDown="return numbervaild(event)" style="text-align:right; font-weight:bold; border:none; background-color:transparent;"></td>';
		appendledger = appendledger+'<td align="right"><input id="dramount'+sno+'" name="dramount'+sno+'" type="text" readonly="readonly" value="'+dra+'" align="right" size="12" onBlur="addcommas(this.id)"  onKeyDown="return numbervaild(event)" style="text-align:right; font-weight:bold; border:none; background-color:transparent;"></td>';
		appendledger = appendledger+'<td align="right"><input type="button" value="Del" onClick="return btnDeleteClickindustry('+sno+')"></td>';
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
		/*var costcenter_entries = 0;
	  	var costcenter_cnt = sno;
	  	for(i=1;i<=costcenter_cnt;i++)
	  	{
	  		if($("#costcenter"+i).is(":visible")){
          	 costcenter_entries = parseInt(costcenter_entries) + 1;
	  		}
	  	}
	  	if(costcenter_entries)
	  	{
	  		$('#costcenter_tdcontent'+sno).show();
	  		//$('#costcenter_tdcontent'+rno).html('');
	  	}*/
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
function validate_costcenter(sno)
{
	
		var flag = true;
		if($("#costcenter"+sno).is(":visible")){
           //alert("The cost center  is visible.");
           if($("#costcenter"+sno).val() == "")
           {
           	alert("Please select cost center");
           	$("#costcenter"+sno).focus();
           	flag = false;
           }
        } else{
           //alert("The cost center  is hidden.");
           flag = true;
        }
        return flag;
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

function clicklocation()
{

	var location=document.getElementById("location").value;
	if(location=='')
	{
		alert('Please Select Location');
		document.getElementById("location").focus();
		return false;
	}
}

$(function() {

$('#entryid').autocomplete({

	source:'ajaxjournalentriesserach.php', 

	select: function(event,ui){

			var code = ui.item.id;
			$('#entryid').val(code);
			this.form.submit();
			},

	html: true

});

});
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
    <td width="2%">&nbsp;</td>
    <td width="90%" valign="top">
	
		<form name="form1" id="form1" method="post" action="editentries.php" enctype="multipart/form-data" >
		<table width="918" border="0" align="left" cellpadding="3" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

			<tr bgcolor="#011E6A">
			<td colspan="7" bgcolor="#999999" class="bodytext11"><strong> Journal Entries - Add New </strong></td>
			<td align="right" colspan="2" bgcolor="#999999" class="bodytext11">&nbsp;</td>
			</tr>

			<tr>
			<td width="142" align="left" valign="middle"  class="bodytext3"><div align="right">ID </div></td>
			<td align="left" colspan="3" valign="top"><input type="text" name="entryid" id="entryid" value="<?php echo $entryid; ?>" size="20" style="text-transform:uppercase;">
			</td>
			</tr>

			<tr>
			<td align="left" valign="middle" class="bodytext3"><div align="right">Entry Date</div></td>
			<td align="left" colspan="3" valign="top"><input type="text" name="entrydate" id="entrydate" size="10" value="<?php echo $entrydate_jour;?>" readonly="readonly">
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('entrydate','','','','','','past','<?= $finfromyear; ?>','<?= $fintoyear; ?>')" style="cursor:pointer"/> 
			</td>
			</tr>

			<tr>
			<td align="left" valign="middle" class="bodytext3"><div align="right">Location</div></td>
			<td align="left" colspan="3" valign="top">

			<select name="location" id="location"  onChange=" ajaxlocationfunction(this.value);" style="pointer-events: none;">
			<option value="">--Select Location--</option>
			<?php
			$query01="select locationcode,locationname from master_location where status=''  group by locationcode";
			$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
			while($res01=mysqli_fetch_array($exc01))
			{?>
			<option value="<?= $res01['locationcode'] ?>" <?php if($locationcode_jour==$res01['locationcode']){ echo 'selected';} ?>> <?= $res01['locationname'] ?></option>		
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
			<input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
			</td>
			</tr>
		</table>
		
      <tr><td>&nbsp; </td></tr>
		<?php if ($cbfrmflag1 == 'cbfrmflag1'){ ?>
			<tr>
			<td width="2%">&nbsp;</td>
			<td width="90%" valign="top">
			<!--<table align="left" id="maintableledger" width="918" border="0" cellpadding="4" cellspacing="4" style="border-collapse:collapse">-->
			<table width="918" border="0" align="left" cellpadding="3" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
			<tbody>
			<tr id="heading" style="display:;" bgcolor="#ecf0f5">
			<td align="left" class="bodytext11"><strong>Type</strong></td>
			<td width="50" align="left" class="bodytext11"><strong>Ledger</strong></td>
			<td id="costcentertd" width="50" align="left" class="bodytext11"><strong><span id='showhide' style="display:none">Cost Center</span></strong></td>
			<td colspan="2" align="center" class="bodytext11"><strong>Amount</strong></td>
			<td align="left" class="bodytext11"><strong>Remarks</strong></td>
			<td align="right" class="bodytext11">&nbsp;</td>
			<td align="right" class="bodytext11"><strong>Cr.Amt</strong></td>
			<td align="right" class="bodytext11"><strong>Dr.Amt</strong></td>
			</tr>
			<tbody id="insertrow1" style="display:;">
			<?php
			$sno=0;
			$crtotalamount=0.00;
			$drtotalamount=0.00;
			$query1 = "select * from master_journalentries where docno='$entryid' order by auto_number asc";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$crledgeramt=0.00;
			$drledgeramt=0.00;
			$auto_number_jour = $res1["auto_number"];
			$selecttype_jour = $res1["selecttype"];
			$ledgername_jour = $res1["ledgername"];
			$ledgerid_jour = $res1["ledgerid"];
			$transactionamountjour = $res1["transactionamount"];
			$remarks_jour = $res1["remarks"];
			$narration_jour = $res1["narration"];
			$sno+=1;
			if($selecttype_jour=='Cr'){
			$crledgeramt=$res1["creditamount"];
			$crtotalamount+=$res1["creditamount"];
			}else{
			$drledgeramt=$res1["debitamount"];	
			$drtotalamount+=$res1["debitamount"];	
			}
			
				$tbcostcenter="select cost_center_code,auto_number from tb where ledger_id='$ledgerid_jour' and doc_number='$entryid'";
				$exectb = mysqli_query($GLOBALS["___mysqli_ston"], $tbcostcenter);
				$restb= mysqli_fetch_array($exectb);
				$costcenteridd=$restb["cost_center_code"];
				$auto_number_tb=$restb["auto_number"];
			
			
			
				$hasdata =0;
				$html="";
				if(trim($ledgerid_jour !="" ))
				{
					
					
					$html="";
					$cc_style = "'display:block'";
					$query11 = "select accountsmain from master_accountname where id = '$ledgerid_jour'";
					$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res11 = mysqli_fetch_array($exec11);
					$accountsmain = $res11['accountsmain'];
					
					$query11 = "select auto_number from master_accountsmain where auto_number = '$accountsmain'";
					$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res11 = mysqli_fetch_array($exec11);
					$ledgergroupid = $res11['auto_number'];
					if($ledgergroupid!="")
					{
							$key=$sno;
							$query10 = "select auto_number,name from `master_costcenter` where group_id = '$ledgergroupid'";
							$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
							$num_rows = mysqli_num_rows($exec10);
							if($num_rows > 0)
							{
							$i =0;
							while ($res10 = mysqli_fetch_array($exec10))
							{
							$auto_number = $res10["auto_number"];
							$name = ucfirst(strtolower($res10["name"]));
							$name=preg_replace("/(^|[^a-zA-Z])([a-z])/e","processReplacement('$1', '$2')", $name);
							if(!$i)
							{
							$html .= '<select name="costcenter'.$key.'" id="costcenter'.$key.'"><option value="">Select Cost Center</option>';
							}
							$sel = "";
							
							if($costcenteridd== $auto_number)
							{
							$sel = "selected";
							}
							$html .= '<option value="'.$auto_number.'" '.$sel.'>'.$name.'</option>';
							$i++;	
							$hasdata++;
							}
							}
							
							if($hasdata)
							{
							$html .= "</select>";
							}
							
					}
				}
				
			?>
						<tr id="idTRI1">
						<td id="idTDI1" align="left">
						
						<input id="serialnumberentries<?php echo $sno; ?>" name="serialnumberentries<?php echo $sno; ?>" type="hidden" align="left" size="2" value="<?php echo $sno; ?>" readonly="">
						<input id="journal_id<?php echo $sno; ?>" name="journal_id<?php echo $sno; ?>" type="hidden" align="left" size="2" value="<?php echo $auto_number_jour; ?>" readonly="">
						<input id="tb_id<?php echo $sno; ?>" name="tb_id<?php echo $sno; ?>" type="hidden" align="left" size="2" value="<?php echo $auto_number_tb; ?>" readonly="">
						
						
						
						
						<select name="entrytype<?php echo $sno; ?>" id="entrytype<?php echo $sno; ?>" onChange="return FillAmt('1')" style="text-align:left; font-weight:bold; pointer-events: none;" >
						<option value="Cr" <?php if($selecttype_jour=='Cr'){ echo 'selected'; } ?>>Cr</option>
						<option value="Dr" <?php if($selecttype_jour=='Dr'){ echo 'selected'; } ?>>Dr</option>
						</select></td>
						<td id="idTDJ1" align="left"><input id="ledger<?php echo $sno; ?>" class="clientglaccountsc" name="ledger<?php echo $sno; ?>" type="text" align="left" size="50" style="text-align:left; font-weight:bold;" onClick="clicklocation();" value="<?php echo $ledgername_jour; ?>">
						<input id="ledgerno<?php echo $sno; ?>" class="clientglaccountsc" name="ledgerno<?php echo $sno; ?>" type="hidden" value="<?php echo $ledgerid_jour; ?>" align="left" size="50">
						<input id="billwise<?php echo $sno; ?>" class="clientglaccountsc" name="billwise<?php echo $sno; ?>" type="hidden" align="left" size="50">
						</td>
						<td id="costcenter_tdcontent<?php echo $sno; ?>" align="left" >
						<?= $html;?>	
						</td>
						<td id="idTDK1" align="left"><input class="clientglaccountamt" id="amount<?php echo $sno; ?>" name="amount<?php echo $sno; ?>" type="text" align="left" size="12" onBlur="addcommas(this.id)"  onKeyDown="return numbervaild(event)" onKeyUp="return FillAmt('1')" onFocus="return Dis('1')" value="<?php echo number_format($transactionamountjour,2,'.',',');?>" style="text-align:right; font-weight:bold; pointer-events: none;"></td>
						<td align="left">&nbsp;</td>
						<td id="idTDK11" align="left"><textarea class="clientglaccountremarks" id="remark<?php echo $sno; ?>" name="remark<?php echo $sno; ?>" type="text" align="left" rows="2" cols="15" style="font-weight:bold;"><?php echo $remarks_jour; ?></textarea></td>
						<td id="btnact1" align="right">
						<select id="selectact<?php echo $sno; ?>" name="selectact<?php echo $sno; ?>" class="mainrefaction" multiple="multiple" size="3" style="text-align:left; font-weight:bold; display:none;">
						<option value="1">New Ref</option>
						<option value="2">Agst Ref</option>
						<option value="3">On Account</option>
						</select>
						</td>
						<td align="right"><input id="cramount<?php echo $sno; ?>" name="cramount<?php echo $sno; ?>" type="text" align="right" readonly="readonly" size="12"  style="text-align:right; font-weight:bold;  border:none; background-color:transparent;" value="<?php echo number_format($crledgeramt,2,'.',','); ?>"></td>
						<td align="right"><input id="dramount<?php echo $sno; ?>" name="dramount<?php echo $sno; ?>" type="text" align="right" readonly="readonly" size="12" style="text-align:right; font-weight:bold; border:none; background-color:transparent;" value="<?php echo number_format($drledgeramt,2,'.',','); ?>"></td>
						</tr>
			<?php } ?>
			
						<tr id="theading" style="display:;">
						<td width="42" align="left" class="bodytext13"><strong>&nbsp;</strong></td>
						<td width="" align="left" class="bodytext13"><strong>&nbsp;</strong></td>
						<td colspan="5" align="center" class="bodytext13"><strong>&nbsp;</strong></td>
						<td width="" align="center" class="bodytext13"><strong>
						<input id="totalcr" name="totalcr" type="text" align="right" readonly="readonly" size="12" onBlur="addcommas(this.id)"  onKeyDown="return numbervaild(event)" style="text-align:right; font-weight:bold; background-color: transparent; border:none; color:#FF0000" value="<?php echo number_format($crtotalamount,2,'.',',');?>"></strong></td>
						<td width="" align="center" class="bodytext13"><strong>
						<input id="totaldr" name="totaldr" type="text" align="right" readonly="readonly" size="12" onBlur="addcommas(this.id)"  onKeyDown="return numbervaild(event)" style="text-align:right; font-weight:bold; background-color: transparent; border:none; color:#FF0000" value="<?php echo number_format($drtotalamount,2,'.',','); ?>"></strong></td>						  
						</tr>
						<tr>
                        <td align="left" valign="middle" class="bodytext3"><div align="right"></div></td>
                        <td colspan="2" align="center" class="bodytext3"><span style="display: block; align-items : center;" > Narration &nbsp;</span><textarea name="narration" id="narration" rows="3" cols="30"><?php echo $narration_jour; ?></textarea>
						</td>
						</tr>
						<tr>
						<td align="left" valign="middle" class="bodytext3"><div align="right"></div></td>
						<td colspan="2" align="right" valign="middle" >
                        <input type="hidden" name="frmflag" value="addnew" />
						<input type="hidden" name="serialnumber" id="serialnumber" value="<?php echo $sno;?>" size="1" />
						<input type="hidden" name="serialnumberref" id="serialnumberref" value="<?php echo $sno;?>" size="1" />
						<input type="hidden" name="subrefserial" id="subrefserial" value="<?php echo $sno;?>" size="1" />
                        <input type="hidden" name="frmflag1" value="frmflag1" />
						<input type="submit" name="Submit" value="Submit" onClick="return entries()"/>
						</td>
						</tr>
			</tbody>
			</table>
			</td>
			</tr>
			
		<?php } ?>
		</form>
		</td>
      </tr>
   </td>
  </tr>
</table>
</body>
</html>
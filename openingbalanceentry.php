<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$entrytime = date('H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$dummy = '';
$cr_amount="";
$sessiondocno = $_SESSION['docno'];
$query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$sessiondocno' group by locationname order by locationname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res1 = mysqli_fetch_array($exec1);
$locationcode = $res1['locationcode'];
$locationname = $res1['locationname'];

$query31 = "select fromyear,toyear from master_financialyear where status = 'Active' order by auto_number desc";
$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
$res31 = mysqli_fetch_array($exec31);
$finfromyear = $res31['fromyear'];
$fintoyear = $res31['toyear'];

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
//$entrydate = $_REQUEST['entrydate'];
$entrydate = date('Y-m-d',strtotime($_REQUEST['entrydate']));
foreach($_REQUEST['accountsub'] as $value=>$key)
{

$accountsub=$_REQUEST['accountsub'][$value];
$accountsubno=$_REQUEST['accountsubno'][$value];
$accountname=$_REQUEST['accountname'][$value];
$accountid=$_REQUEST['accountid'][$value];
$accountanum=$_REQUEST['accountanum'][$value];
$cramount=$_REQUEST['cramount'][$value];
$cramount=str_replace(',', '', $cramount);
$dramount=$_REQUEST['dramount'][$value];
$dramount=str_replace(',', '', $dramount);
$remarks='';
$payablestatus =0;

$query134 = "select accountsmain from master_accountssub where auto_number = '$accountsubno'";
$exec134 = mysqli_query($GLOBALS["___mysqli_ston"], $query134) or die ("Error in Query134".mysqli_error($GLOBALS["___mysqli_ston"]));
$res134 = mysqli_fetch_array($exec134);
$accountsmain = $res134['accountsmain'];

$query135 = "select section from master_accountsmain where auto_number = '$accountsmain'";
$exec135 = mysqli_query($GLOBALS["___mysqli_ston"], $query135) or die ("Error in Query135".mysqli_error($GLOBALS["___mysqli_ston"]));
$res135 = mysqli_fetch_array($exec135);
$section = $res135['section'];

if($cramount !='' && $cramount !='0.00')
{
//to update transaction master form transaction report.
	$paynowbillprefix = 'SOP-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from openingbalancesupplier order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='SOP-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'SOP-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
	$docnumber = $billnumbercode;
	//if($accountsub != 'ACCOUNTS PAYABLE')
	if($section != 'A' || $section != 'E')
	{
	$payablestatus =1;
	}
	$query41 = "select * from master_financialintegration where field='openingbalancesupplier'";
	$exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res41 = mysqli_fetch_array($exec41);
	$coa = $res41['code'];
	
	$query9 = "insert into openingbalancesupplier (docno, accountname, accountcode, openbalanceamount, 
	amount, entrydate, entrytime, remarks, username, ipaddress, companyname, companyanum,coa,locationcode,locationname,payablestatus)  
	values ('$docnumber', '$accountname', '$accountid', '$cramount', '$cramount', '$entrydate',  
	'$entrytime', '$remarks', '$username', '$ipaddress', '$companyname', '$companyanum','$coa','$locationcode','$locationname','$payablestatus')";
	$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
	//if($accountsub == 'ACCOUNTS PAYABLE')
	if($section != '')
	{
	$query13 = "select * from master_accountssub where auto_number = '$accountsubno'";
	$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res13 = mysqli_fetch_array($exec13);
	$supplieranum = $res13['id'];
	$query91 = "insert into master_purchase (billnumber, suppliername, suppliercode,  
	totalamount, billdate,supplierbillnumber,companyanum,username,ipaddress,locationcode,locationname,totalfxamount,fxrate,currency) 
	values ('$docnumber', '$accountname', '$accountid', '$cramount', '$entrydate','Opening Balance','$companyanum','$username','$ipaddress','$locationcode','$locationname','$cramount','1.00','UGX')";
	$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die ("Error in Query91".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query92 = "insert into master_transactionpharmacy (billnumber, suppliername,suppliercode,  
	transactionamount, transactiondate, remarks, ipaddress, companyname, companyanum,transactiontype,transactionmode,creditamount,balanceamount,supplieranum,locationcode,locationname,totalfxamount,fxrate,currency) 
	values ('$docnumber', '$accountname', '$accountid', '$cramount', '$entrydate',  
	'$remarks', '$ipaddress', '$companyname', '$companyanum','PAYMENT','CREDIT','$cramount','$cramount','$supplieranum','$locationcode','$locationname','$cramount','1.00','UGX')";
	$exec92 = mysqli_query($GLOBALS["___mysqli_ston"], $query92) or die ("Error in Query92".mysqli_error($GLOBALS["___mysqli_ston"]));
	$query93 = "insert into master_transactionpharmacy (billnumber, suppliername,suppliercode,transactionamount, transactiondate, remarks, ipaddress, companyname, companyanum,transactiontype,transactionmode,supplieranum,locationcode,locationname,totalfxamount,fxrate,currency) 
	values ('$docnumber', '$accountname', '$accountid', '$cramount', '$entrydate','$remarks', '$ipaddress', '$companyname', '$companyanum','PURCHASE','BILL','$supplieranum','$locationcode','$locationname','$cramount','1.00','UGX')";
	$exec93 = mysqli_query($GLOBALS["___mysqli_ston"], $query93) or die ("Error in Query93".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query1 = "select * from master_accountname where id = '$accountid'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	$subtype = $res1['subtype'];
	$paymenttype = $res1['paymenttype'];
	
	$query11 = "select * from master_subtype where auto_number = '$subtype'";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res11 = mysqli_fetch_array($exec11);
	$subtypename = $res11['subtype'];
	
	$query12 = "select * from master_paymenttype where auto_number = '$paymenttype'";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res12 = mysqli_fetch_array($exec12);
	$paymenttypename = $res12['paymenttype'];
	
	/*$query911 = "insert into billing_paylater (billno, accountname,  
	totalamount, billdate,patientname,billstatus,subtype,locationcode,locationname,accountcode) 
	values ('$docnumber', '$accountname', '$dramount', '$entrydate','Opening Balance','unpaid','$subtypename','$locationcode','$locationname','$accountid')";
	$exec911 = mysql_query($query911) or die ("Error in Query911".mysql_error());
	
	$query921 = "insert into master_transactionpaylater (billnumber, accountname,  
	transactionamount,billbalanceamount, transactiondate, transactiontime, remarks, username, ipaddress, companyname, companyanum,patientname,paymenttype,subtype,transactiontype,locationcode,locationname,accountcode,accountnameid,accountnameano,acc_flag) 
	values ('$docnumber', '$accountname', '$dramount','$dramount', '$entrydate',  
	'$entrytime', '$remarks', '$username', '$ipaddress', '$companyname', '$companyanum','Opening Balance','$paymenttypename','$subtypename','finalize','$locationcode','$locationname','$accountid','$accountid','$accountanum','0')";
	$exec921 = mysql_query($query921) or die ("Error in Query921".mysql_error()); */
	}
}
if($dramount !='' && $dramount !='0.00')
{
//to update transaction master form transaction report.
	$paynowbillprefix = 'AOP-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from openingbalanceaccount order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='AOP-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'AOP-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
	$docnumber = $billnumbercode;
	
	$query41 = "select * from master_financialintegration where field='openingbalanceaccount'";
	$exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$res41 = mysqli_fetch_array($exec41);
	$coa = $res41['code'];
	
	
	$query9 = "insert into openingbalanceaccount (docno, accountname, accountcode, openbalanceamount, 
	amount, entrydate, entrytime, remarks, username, ipaddress, companyname, companyanum,coa,locationcode,locationname) 
	values ('$docnumber', '$accountname', '$accountid', '$dramount', '$dramount', '$entrydate',  
	'$entrytime', '$remarks', '$username', '$ipaddress', '$companyname', '$companyanum','$coa','$locationcode','$locationname')";
	$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
	//if($accountsub == 'ACCOUNTS RECEIVABLE')
	if($section == 'A' || $section == 'E')
	{
	$query1 = "select * from master_accountname where id = '$accountid'";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
	$subtype = $res1['subtype'];
	$paymenttype = $res1['paymenttype'];
	
	$query11 = "select * from master_subtype where auto_number = '$subtype'";
	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res11 = mysqli_fetch_array($exec11);
	$subtypename = $res11['subtype'];
	
	$query12 = "select * from master_paymenttype where auto_number = '$paymenttype'";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res12 = mysqli_fetch_array($exec12);
	$paymenttypename = $res12['paymenttype'];
	
	$query91 = "insert into billing_paylater (billno, accountname,  
	totalamount, billdate,patientname,billstatus,subtype,locationcode,locationname,accountcode) 
	values ('$docnumber', '$accountname', '$dramount', '$entrydate','Opening Balance','unpaid','$subtypename','$locationcode','$locationname','$accountid')";
	$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query92 = "insert into master_transactionpaylater (billnumber, accountname,  
	transactionamount,billbalanceamount, transactiondate, transactiontime, remarks, username, ipaddress, companyname, companyanum,patientname,paymenttype,subtype,transactiontype,locationcode,locationname,accountcode,accountnameid,accountnameano,acc_flag) 
	values ('$docnumber', '$accountname', '$dramount','$dramount', '$entrydate',  
	'$entrytime', '$remarks', '$username', '$ipaddress', '$companyname', '$companyanum','Opening Balance','$paymenttypename','$subtypename','finalize','$locationcode','$locationname','$accountid','$accountid','$accountanum','0')";
	$exec92 = mysqli_query($GLOBALS["___mysqli_ston"], $query92) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
}

}
header ("location:openingbalanceentry.php?st=success");
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
.bodytext11 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
tr.tbpad td {
  padding-bottom: 2px;
}
tr.tbpad input[type=text]{
font-weight:bold;
background-color: transparent;
border:none;
}
input[type="text"]:read-only {
    cursor: normal;
	border:1px solid #999999;
    background-color: #EEE;
}
.submitbtn:disabled{
  border: 1px solid #999999;
  background-color: #ecf0f5;
  color: #666666;
}
</style>

</script>

</head>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/insertnewitemob.js"></script>
<script src="js/datetimepicker_css.js"></script>
<link href="css/autocomplete.css" rel="stylesheet">
<script type="text/javascript">
$(document).ready(function($){
$('#accountsub').autocomplete({
	source:"ajaxaccountsub_search1.php",
	//alert(source);
	matchContains: true,
	minLength:1,
	html: true, 
		select: function(event,ui){
			var subaccountname=ui.item.value;
			var subaccountanum=ui.item.anum;
			subanumsn ="#accountsubno";
			$(subanumsn).val(subaccountanum);
			$("hiddenaccountsub").val(subaccountname);
			accnmsn = "#accountname";
			$(accnmsn).attr('disabled',false);
			funaccount(subaccountanum,accnmsn);
			},
	});
	$( "#accountsub" ).keyup(function() {
	if($( "#accountsub" ).val()!=$( "#hiddenaccountsub" ).val()&&$( "#accountsubno").val()!='')
	{
 	$("#accountsubno").val('');
			$("hiddenaccountsub").val('');
			accnmsn = "#accountname";
			$(accnmsn).attr('disabled',true);
			$("#accountname").val('');
			$("#accountid").val('');
			$("#accountanum").val('');
  }
});
$( "#accountname" ).keyup(function() {
  if($( "#accountname" ).val()!=$( "#hiddenaccountname" ).val()&&$( "#accountid").val()!='')
	{
 	$("#accountid").val('');
	$("#accountanum").val('');
			$("hiddenaccountname").val('');	
			$("#cramount").val('');
			$("#dramount").val('');
			$("#cramount").attr('disabled',true);
			$("#dramount").attr('disabled',true);
  }
});
});
function funcaltotal()
{
totalcramt = 0.00;
totaldramt = 0.00;
crelems = document.getElementsByName("cramount[]");
for(i=0; i < crelems.length; i++) {
        cramt = crelems[i].value;
        if(cramt!='') {
           totalcramt= parseFloat(totalcramt)+ parseFloat(cramt.replace(/,/g,''));
        }
    }
drelems = document.getElementsByName("dramount[]");
for(i=0; i < drelems.length; i++) {
        dramt = drelems[i].value;
        if(dramt!='') {
           totaldramt= parseFloat(totaldramt)+parseFloat(dramt.replace(/,/g,''));
        }
    }
	document.getElementById('totalcr').value=totalcramt;
	addcommas('totalcr');
	document.getElementById('totaldr').value=totaldramt;
	addcommas('totaldr');
	if(totalcramt==totaldramt && totalcramt>0.00 &&totalcramt>0.00)
	{
	document.getElementById('submitbtn').disabled=false;
	}
	else
	{
	document.getElementById('submitbtn').disabled=true;
	}
}
function btnDeleteClickindustry(delid)
{
if(confirm("Are you Sure. You want to Delete entry?"))
{
var elem = document.getElementById('idTRI'+delid);
 elem.parentNode.removeChild(elem);
 funcaltotal();
}
}
function funaccount(subaccountanum,accnmsn)
{
dramtsn="#dramount";
cramtsn="#cramount";
$(accnmsn).val('');
$(dramtsn).val('');
$(cramtsn).val('');
$(accnmsn).autocomplete({
	source:"ajaxaccount_subsearch.php?sub="+subaccountanum+"",
	//alert(source);
	matchContains: true,
	minLength:1,
	html: true, 
		select: function(event,ui){
			var accountname=ui.item.value;
			var accountid=ui.item.id;
			var accountanum=ui.item.anum;
			accidsn ="#accountid";
			accanumsn ="#accountanum";
			//alert(cramtsn);
			$("#hiddenaccountname").val(accountname);
			$(accanumsn).val(accountanum);
			$(accidsn).val(accountid);
			$(dramtsn).attr('disabled',false);
			$(cramtsn).attr('disabled',false);
			},
    
	});
	
	
}
function numbervaild(key)
{
	var keycode = (key.which) ? key.which : key.keyCode;

	 if(keycode > 40 && (keycode < 48 || keycode > 57 )&&( keycode < 96 || keycode > 111))
	{
		return false;
	}
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
</script>

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
	
			  <form name="form1" id="form1" method="post" action="openingbalanceentry.php" enctype="multipart/form-data" >
			  
                  <table width="918" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                      <tr bgcolor="#011E6A">
                        <td colspan="7" bgcolor="#999999" class="bodytext11"><strong> Opening Balance Entries - Add New </strong></td>
						<td align="right" colspan="2" bgcolor="#999999" class="bodytext11">&nbsp;</td>
                      </tr>
					  <tr>
					  <td>&nbsp;</td>
					  </tr>
					  <?php if(isset($_REQUEST['st'])) { $st = $_REQUEST['st']; } else { $st = ""; } 
					  if($st == 'success') { ?>
					  <tr>
                        <td colspan="8" bgcolor="#00FF33" align="left" valign="middle" class="bodytext3"><div align="left" style="font-size:12px"><strong><?php echo "Entry Saved"; ?></strong></div></td>
                      </tr>
					  <?php } ?>
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
                        <td align="left" valign="middle" class="bodytext3">&nbsp;
				  </td>
                  </tr>
				  		 <tr>
                        <td align="left" valign="middle" class="bodytext3"><div align="right">Entry Date</div></td>
                        <td align="left" colspan="3" valign="top">
					 <input name="entrydate" id="entrydate" style="border: 1px solid #001E6A" value="<?php echo date( "Y-m-d", strtotime( "2017-05-1" ) ); ?>"  readonly="readonly" onKeyDown="return disableEnterKey()" size="20" />
					<img src="images2/cal.gif" onClick="javascript:NewCssCal('entrydate')" style="cursor:pointer"/>	
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
						<table align="left" id="maintableledger" width="100%" border="0"  cellpadding="4" cellspacing="4" style="border-collapse:collapse">
						<thead>
						<tr id="heading" style="display:;" bgcolor="#ecf0f5">
						<td align="left" class="bodytext11"><strong>Account Sub Group</strong></td>
						<td width="50" align="left" class="bodytext11"><strong>Account</strong></td>
						<td align="left" class="bodytext11"><strong>Account Id</strong></td>
						<td align="right" class="bodytext11"><strong>Credit Amount</strong></td>
						<td align="right" class="bodytext11"><strong>Debit Amount</strong></td>
						<td align="right" class="bodytext11"><strong>&nbsp;</strong></td>
						</tr>
						</thead>
						<tbody id="tblref1">
						
						</tbody>
						<tbody id="insertrow1" style="display:;">
						<tr id="idTRI1">
						<td id="idTDI1" align="left">
						<input class="accountsub" type="text"  id="accountsub"  size="30">
						<input id="accountsubno"  type="hidden" align="left">
						<input id="hiddenaccountsub"  type="hidden" align="left">
						</td>
						<td id="idTDJ1" align="left">
						<input id="accountname" disabled="disabled" class="accountname"  type="text" align="left" size="50" >
						<input id="accountanum"  type="hidden" align="left" size="50">
						<input id="hiddenaccountname"  type="hidden" align="left" size="50">
						</td>
						<td align="left">
						<input id="accountid"  type="text" readonly align="left" size="15">
						</td>
						<td align="right"><input class="crm" id="cramount" disabled="disabled" type="text" align="right" size="12" onBlur="addcommas(this.id)"  onKeyDown="return numbervaild(event)" ></td>
						<td align="right"><input class="drm" id="dramount" disabled="disabled"  type="text" align="right" size="12" onBlur="addcommas(this.id)"  onKeyDown="return numbervaild(event)" ></td>
						<td align="right">
						<input type="button" name="Add" value="Add To List" id="addmainledger" onClick="addopenentry();" />
						</td>
						</tr>
						<tr>
						<td  align="right" class="bodytext13">&nbsp;</td>
						</tr>
						<tr id="theading" >
						<td  align="left" class="bodytext13"><strong></strong></td>
						<td  align="right" class="bodytext13">&nbsp;</td>
						<td  align="right" class="bodytext13"><strong>
						  <input id="totalcr" name="totalcr" type="text" align="right" readonly size="12" onBlur="addcommas(this.id);funcaltotal();" onKeyDown="return numbervaild(event)" style="text-align:right; font-weight:bold; background-color: transparent; border:none; color:#FF0000"></strong></td>
						<td  align="right" class="bodytext13"><strong>
						  <input id="totaldr" name="totaldr" type="text" align="right" readonly size="12" onBlur="addcommas(this.id);funcaltotal();" onKeyDown="return numbervaild(event)" style="text-align:right; font-weight:bold; background-color: transparent; border:none; color:#FF0000"></strong></td>
						  <td  align="right" class="bodytext13">&nbsp;</td>
						</tr>
						</tbody>
						
						</table>
						</td>
						</tr>
						
						
						
						 <!--<tr>
                        <td align="left" valign="middle" class="bodytext3"><div align="right">Narration</div></td>
                        <td align="left" colspan="3" valign="top"><textarea name="narration" id="narration" rows="3" cols="30"></textarea>
						</td>
					    </tr>-->
						<tr>
						<td align="left" valign="top">&nbsp;</td>
						</tr>
                        <tr id="sbtn" style="display:;">
                        <td align="left" valign="top">&nbsp;</td>
                        <td colspan="1" align="left" valign="middle" >
                        <input type="hidden" name="frmflag" value="addnew" />
						<input type="hidden" name="serialnumber" id="serialnumber" value="1" size="1" />
						<input type="hidden" name="frmflag1" value="frmflag1" />
						<input type="submit" id="submitbtn" class="submitbtn" name="Submit" value="Submit" onClick="return entries()" disabled="disabled"/>&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="reset" name="reset" value="Reset" onClick="javascript: var aa = confirm('Are you Sure to Reset ?'); if(aa == false) { return false; } window.location = 'openingbalanceentry.php'" />
                          </td>
                      </tr>	
        </table> 
		
              </form>
   </td>
  </tr>
</table>

</body>
</html>


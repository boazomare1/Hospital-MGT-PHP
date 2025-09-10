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
$dateonly = date("Y-m-d");
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$accno = "";
$acctype = "";
$query31 = "select fromyear,toyear from master_financialyear where status = 'Active' order by auto_number desc";
$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
$res31 = mysqli_fetch_array($exec31);
$finfromyear = $res31['fromyear'];
$fintoyear = $res31['toyear'];
if (isset($_REQUEST["docno1"])) { $docno1 = $_REQUEST["docno1"]; } else { $docno1 = ""; }
//echo $docno1;
if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	$frombankname1 = $_REQUEST['frombankname'];
	$frombanknamesplit = explode('||',$frombankname1);
	$frombankid = $frombanknamesplit[0];
	$frombankname = $frombanknamesplit[1];
	$tobankname1 = $_REQUEST['tobankname'];
	$tobanknamesplit = explode('||',$tobankname1);
	$tobankid = $tobanknamesplit[0];
	$tobankname = $tobanknamesplit[1];
	$docnumber = $_REQUEST['docnumber'];
	$branch = $_REQUEST["branchname"];
	$accno = $_REQUEST["accno"];
	 $acctype = $_REQUEST["acctype"];
	 $transactiontype = $_REQUEST["transactiontype"];
	 $ADate = $_REQUEST["ADate"];
	 $transactionmode = $_REQUEST["transactionmode"];
	 $personname = $_REQUEST["personname"];
	 if($transactionmode =='CHEQUE')
	 {
	 	$chequedate = $_REQUEST["ADate1"];
		$chequenumber = $_REQUEST["chequenumber"];
		$chequebankname = '';
		$chequebankbranch = $_REQUEST["branchname"];
	 }
	    $remarks = $_REQUEST["remarks"];
	    $amount = $_REQUEST["amount"];
		$amount = str_replace(',', '', $amount);
		$location = $_REQUEST['location'];
		$locsplit = explode('|',$location);
		$locationcode = $locsplit[0];
		$locationname = $locsplit[1];
		
 $query251 = "select * from bankentryform where docnumber='$docnumber' group by docnumber ";
   $exec251 = mysqli_query($GLOBALS["___mysqli_ston"], $query251) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   $num251 = mysqli_num_rows($exec251);
   if($num251 > 0)
   {
                        $paynowbillprefix = 'BE-';
						$paynowbillprefix1=strlen($paynowbillprefix);
						$query2 = "select * from bankentryform order by auto_number desc limit 0, 1";
						$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res2 = mysqli_fetch_array($exec2);
						$billnumber = $res2["docnumber"];
						$billdigit=strlen($billnumber);
		 			    if ($billnumber == '')
						{
							$docnumber ='BE-'.'1';
							$openingbalance = '0.00';
						}
						else
						{
							$billnumber = $res2["docnumber"];
							$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
							//echo $billnumbercode;
							$billnumbercode = intval($billnumbercode);
							$billnumbercode = $billnumbercode + 1;					
							$maxanum = $billnumbercode;
							$docnumber = 'BE-' .$maxanum;
							$openingbalance = '0.00';
							//echo $companycode;
						}
   }	
		
		
	if($transactionmode =='CASH')
	{
		 $query1 = "insert into bankentryform (frombankid, frombankname,branch,accnumber,acctype,transactiontype,transactiondate,transactionmode,creditamount,personname,remarks, ipaddress, updatetime, docnumber,locationcode,locationname) 
		values ('$frombankid','$frombankname','$branch','$accno','$acctype','$transactiontype','$ADate','$transactionmode','$amount','$personname','$remarks','$ipaddress', '$updatedatetime', '$docnumber','$locationcode','$locationname')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query11 = "insert into bankentryform (tobankid, bankname,branch,accnumber,acctype,transactiontype,transactiondate,transactionmode,amount,personname,remarks, ipaddress, updatetime, docnumber,locationcode,locationname) 
		values ('$tobankid','$tobankname','$branch','$accno','$acctype','$transactiontype','$ADate','$transactionmode','$amount','$personname','$remarks','$ipaddress', '$updatedatetime', '$docnumber','$locationcode','$locationname')";
		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$errmsg = "Success. Bank Details Updated.";
		$bgcolorcode = 'success';
	}	
	else if($transactionmode =='MPESA')
	{
		 $query1 = "insert into bankentryform (frombankid, frombankname,branch,accnumber,acctype,transactiontype,transactiondate,transactionmode,creditamount,personname,remarks, ipaddress, updatetime, docnumber,locationcode,locationname) 
		values ('$frombankid','$frombankname','$branch','$accno','$acctype','$transactiontype','$ADate','$transactionmode','$amount','$personname','$remarks','$ipaddress', '$updatedatetime', '$docnumber','$locationcode','$locationname')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query11 = "insert into bankentryform (tobankid, bankname,branch,accnumber,acctype,transactiontype,transactiondate,transactionmode,amount,personname,remarks, ipaddress, updatetime, docnumber,locationcode,locationname) 
		values ('$tobankid','$tobankname','$branch','$accno','$acctype','$transactiontype','$ADate','$transactionmode','$amount','$personname','$remarks','$ipaddress', '$updatedatetime', '$docnumber','$locationcode','$locationname')";
		$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$errmsg = "Success. Bank Details Updated.";
		$bgcolorcode = 'success';
	}
	else
	{
	  	$query12 = "insert into bankentryform (frombankid, frombankname,branch,accnumber,acctype,transactiontype,transactiondate,transactionmode,chequedate,chequenumber,chequebankname,chequebankbranch,creditamount,personname,remarks, ipaddress, updatetime, docnumber, locationcode, locationname) 
		values ('$frombankid','$frombankname','$branch','$accno','$acctype','$transactiontype','$ADate','$transactionmode','$chequedate','$chequenumber','$chequebankname','$chequebankbranch','$amount','$personname','$remarks','$ipaddress', '$updatedatetime', '$docnumber','$locationcode','$locationname')";
		$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query13 = "insert into bankentryform (tobankid,bankname,branch,accnumber,acctype,transactiontype,transactiondate,transactionmode,chequedate,chequenumber,chequebankname,chequebankbranch,amount,personname,remarks, ipaddress, updatetime, docnumber, locationcode, locationname) 
		values ('$tobankid','$tobankname','$branch','$accno','$acctype','$transactiontype','$ADate','$transactionmode','$chequedate','$chequenumber','$chequebankname','$chequebankbranch','$amount','$personname','$remarks','$ipaddress', '$updatedatetime', '$docnumber','$locationcode','$locationname')";
		$exec13 = mysqli_query($GLOBALS["___mysqli_ston"], $query13) or die ("Error in Query13".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$errmsg = "Success. Bank Details Updated.";
		$bgcolorcode = 'success';
	}
	
	header("location:bankentryform1.php?docno1=$docnumber");
}
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_color set status = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_color set status = '' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'default')
{
	$delanum = $_REQUEST["anum"];
	$query4 = "update master_color set defaultstatus = '' where cstid='$custid' and cstname='$custname'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$query5 = "update master_color set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'removedefault')
{
	$delanum = $_REQUEST["anum"];
	$query6 = "update master_color set defaultstatus = '' where auto_number = '$delanum'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
}
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link href="css/autocomplete.css" rel="stylesheet">
<!--<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
--><style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style></head>
<script>
var docno="<?php echo $docno1;?>";
if(docno!="")
{
window.open("printbank.php?billnumber="+docno+"",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 	
}
</script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script type="text/javascript" src="js/autosuggestbank1.js"></script>
<script type="text/javascript" src="js/autobanksearch.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>     
<script type="text/javascript">     
$(document).ready(function() { 
 $(".hideshow").hide();
 $("#transactionmode").change(function(){
           var $hideshow = $(".hideshow");
          // var $feeschedule2 = $(".feeschedule2");
           var transactionmode = $(this).find('option:checked').val();
            if (transactionmode == 'CHEQUE')
			{
                $hideshow.show();
            }
			else
			{
                $hideshow.hide();
            }
			});  
			});     
</script>     
<script language="javascript">
function check_ledger(code)
{
		var led_id=code;
		var myArray = led_id.split("||");
		var word = myArray[0];
	
		var entrydate=$("#entrydate").val();
	    $.ajax({
		type: "POST",
		url: "check_ledger_bal.php",
		datatype: "json",
		async: false,
		data:{'ledger_id' : word,'todate' : entrydate},
		catch : false,
		success:function(data){
	
		$('#crbal').val(data);
	
		
		}
		
		});	
}
function check_ledger1(code)
{
		var led_id=code;
		var myArray = led_id.split("||");
		var word = myArray[0];

		var entrydate=$("#entrydate").val();
	    $.ajax({
		type: "POST",
		url: "check_ledger_bal.php",
		datatype: "json",
		async: false,
		data:{'ledger_id' : word,'todate' : entrydate},
		catch : false,
		success:function(data){
	
		$('#drbal').val(data);
	
		
		}
		
		});	
}
	
function change123(){ 
obj2 = new Intl.NumberFormat('en-US');
var v=document.getElementById("amount").value;
v=v.replace(/\,/g,'');
var intv=document.getElementById("crbal").value;
intv=intv.replace(/\,/g,'');
if((parseFloat(v) == parseFloat(v)) && !isNaN(v)){
/* var totnhifclaim= (v*totaldays);
totnhifclaim = obj2.format(totnhifclaim);  
var totglclaim= ((v*totaldays)-parseFloat(intv)).toFixed(2);
totglclaim = obj2.format(totglclaim);  */

if(parseFloat(v)>parseFloat(intv)){
alert('Amount is Greater than Cr Bank');
document.getElementById("amount").value='';
return false;
}	
}
} 	
	


function Functionchequedetails()
{
	//alert("hi");	
if(document.getElementById("transactiontype").value =="WITHDRAWAL")
	{
	var Bankname = document.getElementById("bankname").value;
	//alert(Bankname);
	
	ajaxprocessACCS7();		
	}
}
var xmlHttp
function ajaxprocessACCS7()
{
	//alert("Meow..");
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return false;
	} 
	var Bankname = document.getElementById("bankname").value;
	//alert(Bankname);
	//var Transactiontype = document.getElementById("transactiontype").value;
	//alert(Transactiontype);
	var url5 = '';
	var url5 = "bankbalancecheck1.php?RandomKey="+Math.random()+"&&Bankname="+Bankname;//+"&&Transactiontype="+Transactiontype
    //alert(url5);
    xmlHttp.onreadystatechange=stateChangedACCS7
	xmlHttp.open("GET",url5,true)
	xmlHttp.send(null)
}
function stateChangedACCS7() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
	
	
			var t = "";
			t=t+xmlHttp.responseText;
			//alert(t);
	var varCompleteStringReturned=t;
	//alert (varCompleteStringReturned);
	var varNewLineValue=varCompleteStringReturned.split("||");
	//alert(varNewLineValue);
	//alert(varNewLineValue.length);
	var varNewLineLength = varNewLineValue.length;
	//alert(varNewLineLength);
	varNewLineLength = varNewLineLength - 1;
	//alert(varNewLineLength);
	if (varNewLineLength == 0)
	{
		//return false;
	}
	for (m=1;m<=varNewLineLength;m++)
	{
		//alert (m);
		var varNewRecordValue=varNewLineValue[m].split("||");
		//alert(varNewRecordValue);
		var VarBankBalance = varNewRecordValue[0];
		//alert(VarBankBalance);
		 var Checkbankbalance = document.getElementById("amount").value;
		// alert(Checkbankbalance);
		 if(parseInt(Checkbankbalance) > parseInt(VarBankBalance))
		 {
		 	alert(" You Have Low Balance You Cannot Proceed");
			document.getElementById("amount").focus();
			return false;
		}
		
	//}
	}
}
function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}
	
	
	
	
	
 } 
function additemusedprocess1()
{
	//alert ("Inside Funtion");
	if (document.form1.frombankname.value == "")
	{
		alert ("Please Select Bank Name.");
		document.form1.frombankname.focus();
		return false;
	}
	if (document.form1.tobankname.value == "")
	{
		alert ("Please Select Bank Name.");
		document.form1.tobankname.focus();
		return false;
	}
	if (document.form1.frombankname.value == document.form1.tobankname.value)
	{
		alert ("Dr and Cr Bank Should not be Same");
		document.form1.tobankname.focus();
		return false;
	}
	if (document.form1.transactiontype.value == "")
	{
		alert ("Please Select Transaction Type To Proceed.");
		document.form1.transactiontype.focus();
		return false;
	}
	if (document.form1.transactionmode.value == "")
	{
		alert ("Please Select Transaction Mode To Proceed.");
		document.form1.transactionmode.focus();
		return false;
	}
	if (document.form1.amount.value == "")
	{
		alert ("Please Enter Amount  To Proceed.");
		document.form1.amount.focus();
		return false;
	}
	
	if (document.form1.personname.value == "")
	{
		alert ("Please Enter Person Name To Proceed.");
		document.form1.personname.focus();
		return false;
	}
	if (document.form1.location.value == "")
	{
		alert ("Please select Location.");
		document.form1.location.focus();
		return false;
	}
}
</script>
<script src="js/datetimepicker_css_fin.js"></script>
<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#ecf0f5"><?php  include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td><form name="form1" id="form1" method="post" action="bankentryform1.php" onSubmit="return additemusedprocess1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Bank Entry Form </strong></td>
                        <td colspan="1" bgcolor="#ecf0f5" class="bodytext3"><strong>Balance </strong></td>
                      </tr>
					  <tr>
                        <td colspan="3" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Cr Bank Name </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="frombankname" id="frombankname" onchange="return check_ledger(this.value)">
						<option value="">Select Account</option>
						
						<?php 
						$query1 ="select * from master_accountname where (accountssub IN  ('7','8','9') ) and auto_number <> '603' and recordstatus <> 'deleted'";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res1 = mysqli_fetch_array($exec1))
						{
						$accountname = $res1["accountname"];
						$id = $res1["id"];
						?>
						<option  value="<?php echo $id.'||'.$accountname;?>"><?php echo $accountname;?></option>
						<?php
						}
						?>
						</select></td>
						<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right"><input id="crbal" name="crbal"> </div></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Dr Bank Name </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="tobankname" id="tobankname" onchange="return check_ledger1(this.value)">
						<option value="">Select Account</option>
						<?php 
						$query1 ="select * from master_accountname where (accountssub IN  ('7','8','9') ) and auto_number <> '603' and recordstatus <> 'deleted'";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($res1 = mysqli_fetch_array($exec1))
						{
						$accountname = $res1["accountname"];
						$id = $res1["id"];
						?>
						<option  value="<?php echo $id.'||'.$accountname;?>"><?php echo $accountname;?></option>
						<?php
						}
						?>
						</select></td>
						<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right"><input id="drbal" name="drbal"> </div></td>
                      </tr>
					  <tr>
		 			 <?php		
						$paynowbillprefix = 'BE-';
						$paynowbillprefix1=strlen($paynowbillprefix);
						$query2 = "select * from bankentryform order by auto_number desc limit 0, 1";
						$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res2 = mysqli_fetch_array($exec2);
						$billnumber = $res2["docnumber"];
						$billdigit=strlen($billnumber);
						if ($billnumber == '')
						{
							$billnumbercode ='BE-'.'1';
							$openingbalance = '0.00';
						}
						else
						{
							$billnumber = $res2["docnumber"];
							$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
							//echo $billnumbercode;
							$billnumbercode = intval($billnumbercode);
							$billnumbercode = $billnumbercode + 1;
						
							$maxanum = $billnumbercode;
							$billnumbercode = 'BE-' .$maxanum;
							$openingbalance = '0.00';
							//echo $companycode;
						}?>
						 <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Doc No</div></td>
                        <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><label>
                        <input type="text" name="docnumber" id="docnumber" value="<?php echo  $billnumbercode;?>" readonly>
                        <input type="hidden" name="branchname" id="branchname">
						<input type="hidden" name="accno" id="accno">
                          <input type="hidden" name="acctype" id="acctype">
                          <input type="hidden" name="entrydate" id="entrydate" value="<?php echo $dateonly;?>">
                        </label></td>
					  </tr>
                     <!-- <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Branch</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><label>
                        <input type="hidden" name="branchname" id="branchname">
                        </label></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Account Number </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="accno" id="accno"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">AccountType </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><label>
                          <input type="hidden" name="acctype" id="acctype">
                        </label></td>
                      </tr>-->
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Transaction Type </div></td>
                        <td colspan="3"  align="left" valign="top"  bgcolor="#FFFFFF"><select width="150" name="transactiontype" id="transactiontype">
						<option value="">SELECT TYPE</option>
						<!--<option>DEPOSIT</option>
						<option>WITHDRAWAL</option>-->
						<option>TRANSFER</option>
						<!--<option>BANK CHARGES</option>
						<option>INTEREST</option>
						<option>OPENING BALANCE</option>-->
						</select>&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Transaction Date </div></td>
                        <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><label>
                         <input name="ADate" id="ADate" value="<?php echo $dateonly; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
						 <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate','','','','','','past','<?= $finfromyear; ?>','<?= $fintoyear; ?>')" style="cursor:pointer"/>
                        </label></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Transaction Mode </div></td>
                        <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="transactionmode" id = "transactionmode">
						<option value ="">Select Mode</option>
						<option value='CASH'>CASH</option>
						<option value='MPESA'>MPESA</option>
						<option value ='CHEQUE'>CHEQUE</option>
						</select>                      </tr>
						
                      <tr class="hideshow">
                        <td align="left" valign="top"   bgcolor="#FFFFFF" class="bodytext3" ><div align="right">Cheque Date </div></td>
                        <td  colspan="3" align="left" valign="top"  bgcolor="#FFFFFF" ><span class="bodytext312">
                          <input name="ADate1" id="ADate1" value="<?php echo $dateonly; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1','','','','','','past','<?= $finfromyear; ?>','<?= $fintoyear; ?>')" style="cursor:pointer"/>
                        </span>						</td></tr>
                      <tr class="hideshow">
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3" ><div align="right">Cheque Number</div></td>
                        <td align="left" colspan="3" valign="top"  bgcolor="#FFFFFF" ><input type="text" name="chequenumber" id="chequenumber"></td>
                      </tr>
                     <!-- <tr class="hideshow">
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3" ><div align="right">Cheque Bank Name </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" ><!--<input type="text" name="chequebank" id="chequebank">
						<select name="chequebank" id="chequebank">
					<option value="">Select Bank</option>
					<?php 
					$querybankname = "select * from master_bank where bankstatus <> 'deleted'";
					$execbankname = mysqli_query($GLOBALS["___mysqli_ston"], $querybankname) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($resbankname = mysqli_fetch_array($execbankname))
					{?>
					
						<option value="<?php echo $resbankname['bankname'];?>"><?php echo $resbankname['bankname']; ?></option>
					<?php
					}
					?>
					</select></td>
                      </tr>
                      <tr class="hideshow">
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3" ><div align="right">Bank Branch </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" ><input type="text" name="chequebankbranch" id="chequebankbranch"></td>
                      </tr>-->
                      <tr>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Amount</div></td>
                        <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="text" name="amount" id="amount" class="decimalnumber" onkeyup="return change123()"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Done By </div></td>
                        <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="text" name="personname" id="personname"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Remarks</div></td>
                        <td  colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><textarea name="remarks" id="remarks"></textarea></td>
                      </tr>
					  <tr>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Location</div></td>
                        <td  colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="location" id="location" style="border: 1px solid #001E6A;">
						
						<?php
						$query1 = "select * from master_employeelocation where username='$username' group by locationcode order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationcode = $res1["locationcode"];
						?>
						<option selected  value="<?php echo $res1locationcode.'|'.$res1location; ?>"><?php echo $res1location; ?></option>
						<?php
						}
						?>
				        </select>
						</td>
                      </tr>
                      <tr>
                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
                          <input type="submit" name="Submit"  value="Submit" /></td>
						    <td width="" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="middle" colspan="2" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                </form>
                </td>
            </tr>
            <tr>
              <td>
			  <table width="900" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
			<tbody>
			  <tr bgcolor="#011E6A">
				<td colspan="8" bgcolor="#ecf0f5" class="bodytext3"><strong>Bank Entry List </strong></td>
			  </tr>
			  <tr bgcolor="#FFFFFF">
			  <td align="left" class="bodytext3"><strong>S.No</strong></td>
			  <td align="left" class="bodytext3"><strong>Dr Bank</strong></td>
			  <td align="left" class="bodytext3"><strong>Cr Bank</strong></td>
			  <td align="right" class="bodytext3"><strong>Amount</strong></td>
			  <td align="left" class="bodytext3"><strong>Entry Date</strong></td>
			  <td align="left" class="bodytext3"><strong>Entry By</strong></td>
			  <td align="left" class="bodytext3"><strong>Edit</strong></td>
               <td align="left" class="bodytext3"><strong>Print</strong></td>
			  </tr>
			  <?php
			  $colorloopcount = 0;
			  $query31 = "select * from bankentryform group by docnumber order by auto_number desc";
				$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res31 = mysqli_fetch_array($exec31))
				{
				$docnumber = $res31['docnumber'];
				$entrydate = $res31['transactiondate'];
				
				$query32 = "select * from bankentryform where docnumber = '$docnumber' order by auto_number desc";
				$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res32 = mysqli_fetch_array($exec32);
				
				$bankname = $res32['bankname'];
				$amount = $res32['amount'];
				$personname = $res32['personname'];
				
				
				$query33 = "select * from bankentryform where docnumber = '$docnumber' order by auto_number";
				$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res33 = mysqli_fetch_array($exec33);
				
				$frombankname = $res33['frombankname'];
				$creditamount = $res33['creditamount'];
				$personname = $res33['personname'];
				
				
				if($amount == '0.00')
				{
				$amount = $creditamount;
				}
				else
				{
				$amount = $amount;
				}
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
			  <td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
			  <td align="left" class="bodytext3"><?php echo $bankname; ?></td>
			  <td align="left" class="bodytext3"><?php echo $frombankname; ?></td>
			  <td align="right" class="bodytext3"><?php echo number_format($amount,2); ?></td>
			  <td align="left" class="bodytext3"><?php echo $entrydate; ?></td>
			  <td align="left" class="bodytext3"><?php echo $personname; ?></td>
			  <td align="left" class="bodytext3"><a href="bankentryformedit1.php?st=edit&&docno=<?php echo $docnumber; ?>"><?php echo 'Edit'; ?></a></td>
              <td align="left" class="bodytext3"><a target="_blank" href="printbank.php?billnumber=<?php echo $docnumber; ?>"><?php echo 'Print'; ?></a></td>
			   </tr>
			   <?php
			   }
			   ?>	
			  </tbody>
			  </table>
			  </td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </table>
  <script>
  $('input.decimalnumber').keyup(function(event) {
  // skip for arrow keys
  if(event.which >= 37 && event.which <= 40) return;
  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    ;
  });
});	
  </script>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
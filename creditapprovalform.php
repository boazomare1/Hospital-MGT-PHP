<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('H:i:s');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
	 //get locationcode and locationname for inserting
 $locationcodeget=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';
 $locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
//get ends here
		$visitcode=$_REQUEST["visitcode"];
		$patientcode = $_REQUEST["patientcode"];
		$patientname = $_REQUEST["patientname"];
		
		$accountname= $_REQUEST['accname'];
		$accountcode= $_REQUEST['acccode'];
		$accountanum= $_REQUEST['accanum'];
		$subtype = $_REQUEST['subtype'];
		$paymenttype = $_REQUEST['paymenttype'];
		$totalamount=$_REQUEST['grandtotal'];
		$account1name = $_REQUEST['accountname'];
		$account1nameid = $_REQUEST['accountnameid'];
		$account1nameano = $_REQUEST['accountnameano'];
		if($account1name == '')
		{
		$account1name = 'nil';
		}
		$account2name = $_REQUEST['accountname2'];
		$account2nameid = $_REQUEST['accountnameid2'];
		$account2nameano = $_REQUEST['accountnameano2'];
		if($account2name == '')
		{
		$account2name = 'nil';
		}
		$account3name = $_REQUEST['accountname3'];
		$account3nameid = $_REQUEST['accountnameid3'];
		$account3nameano = $_REQUEST['accountnameano3'];
		if($account3name == '')
		{
		$account3name = 'nil';
		}
		$account4name = $_REQUEST['accountname4'];
		$account4nameid = $_REQUEST['accountnameid4'];
		$account4nameano = $_REQUEST['accountnameano4'];
		if($account4name == '')
		{
		$account4name = 'nil';
		}
		$account1amount = $_REQUEST['amount1'];
		$account1amount = str_replace(',', '', $account1amount);
		$account2amount = $_REQUEST['amount2'];
		$account2amount = str_replace(',', '', $account2amount);
		$account3amount = $_REQUEST['amount3'];
		$account3amount = str_replace(',', '', $account3amount);
		$account4amount = $_REQUEST['amount4'];
		$account4amount = str_replace(',', '', $account4amount);
		$approvalcomments = $_REQUEST['approvalcomments'];
		
		
		
		$query3 = "select * from master_company where companystatus = 'Active'";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res3 = mysqli_fetch_array($exec3);
		$paylaterbillprefix = 'IPCAF';
		$paylaterbillprefix1=strlen($paylaterbillprefix);
		$query2 = "select * from ip_creditapprovalformdata order by auto_number desc limit 0, 1";
		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2 = mysqli_fetch_array($exec2);
		$billnumber = $res2["billno"];
		$billdigit=strlen($billnumber);
		if ($billnumber == '')
		{
			$billnumbercode =$paylaterbillprefix.'1';
			$openingbalance = '0.00';
		}
		else
		{
			$billnumber = $res2["billno"];
			$billnumbercode = substr($billnumber,$paylaterbillprefix1, $billdigit);
			//echo $billnumbercode;
			$billnumbercode = intval($billnumbercode);
			$billnumbercode = $billnumbercode + 1;
		
			$maxanum = $billnumbercode;
			
			
			$billnumbercode = $paylaterbillprefix .$maxanum;
			$openingbalance = '0.00';
			//echo $companycode;
		}
		
		$query91 = "insert into ip_creditapprovalformdata(billno,patientname,patientcode,visitcode,totalamount,billdate,accountname,accountnameid,accountnameano,subtype,account1name,account1nameid,account1nameano,account1amount,account2name,account2nameid,account2nameano,account2amount,account3name,account3nameid,account3nameano,account3amount,approvalcomments,locationname,locationcode,account4name,account4nameid,account4nameano,account4amount)
		values('$billnumbercode','$patientname','$patientcode','$visitcode','$totalamount','$transactiondateto','$accountname','$accountcode','$accountanum','$subtype','$account1name','$account1nameid','$account1nameano','$account1amount','$account2name','$account2nameid','$account2nameano','$account2amount','$account3name','$account3nameid','$account3nameano','$account3amount','$approvalcomments','".$locationnameget."','".$locationcodeget."','$account4name','$account4nameid','$account4nameano','$account4amount')";
		$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query92 = "update ip_creditapproval set recordstatus='approved' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec92 = mysqli_query($GLOBALS["___mysqli_ston"], $query92) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		header("location:creditapprovallist.php");
		exit;

		
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
}


?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paylaterbillprefix = 'IPCAF';
$paylaterbillprefix1=strlen($paylaterbillprefix);
$query2 = "select * from ip_creditapprovalformdata order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$paylaterbillprefix.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billno"];
	$billnumbercode = substr($billnumber,$paylaterbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $paylaterbillprefix .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
<?php
include ("autocompletebuild_accounts1.php");
include ("autocompletebuild_accounts12.php");
include ("autocompletebuild_accounts13.php");
if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
$query4 = "select * from finance_ledger_mapping where auto_number = '20'";
$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
$res4 = mysqli_fetch_array($exec4);
$nhifledger_id = $res4['ledger_id'];
$nhifledger_name = $res4['ledger_name'];

$query41= "select * from master_accountname where id = '$nhifledger_id'";
$exec41 = mysqli_query($GLOBALS["___mysqli_ston"], $query41) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
$res41 = mysqli_fetch_array($exec41);
$nhifledger_autoid = $res41['auto_number'];
$nhif_array=array('411','412','413','414','415','416','417','418','419');
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

<script>



function funcwardChange1()
{
	/*if(document.getElementById("ward").value == "1")
	{
		alert("You Cannot Add Account For CASH Type");
		document.getElementById("ward").focus();
		return false;
	}*/
	<?php 
	$query12 = "select * from master_ward where recordstatus=''";
	$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
	while ($res12 = mysqli_fetch_array($exec12))
	{
	$res12wardanum = $res12["auto_number"];
	$res12ward = $res12["ward"];
	?>
	if(document.getElementById("ward").value=="<?php echo $res12wardanum; ?>")
	{
		document.getElementById("bed").options.length=null; 
		var combo = document.getElementById('bed'); 	
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 
		<?php
		$query10 = "select * from master_bed where ward = '$res12wardanum' and recordstatus = ''";
		$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("error in query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res10 = mysqli_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10bedanum = $res10['auto_number'];
		$res10bed = $res10["bed"];
		
		
		
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10bed;?>", "<?php echo $res10bedanum;?>"); 
		<?php 
		
		}
		?>
	}
	<?php
	}
	?>	
}

function funcvalidation()
{
//alert('h');
if(document.getElementById("readytodischarge").checked == false)
{
alert("Please Click on Ready To Discharge");
return false;
}

}

function balancecalc(serialnumber)
{
var account=document.getElementById("accountname2").value;
	if(account==""){
		document.getElementById("accountnameid2").value='';
		document.getElementById("accountnameano2").value='';
	}
var account3=document.getElementById("accountname3").value;
	if(account3==""){
		document.getElementById("accountnameid3").value='';
		document.getElementById("accountnameano3").value='';
	}
var serialnumber = serialnumber;

var grandtotal = document.getElementById("grandtotal").value;
var amount1 = document.getElementById("amount1").value;
var amount1=Number(amount1.replace(/[^0-9\.]+/g,""));
if(amount1 == '')
{
amount1 = 0;
}
var amount2 = document.getElementById("amount2").value;
var amount2=Number(amount2.replace(/[^0-9\.]+/g,""));
if(amount2 == '')
{
amount2 = 0;
}
var amount3 = document.getElementById("amount3").value;
var amount3=Number(amount3.replace(/[^0-9\.]+/g,""));
if(amount3 == '')
{
amount3 = 0;
}
var amount4 = document.getElementById("amount4").value;
var amount4=Number(amount4.replace(/[^0-9\.]+/g,""));
if(amount4 == '')
{
amount4 = 0;
}
var balance = grandtotal - (parseFloat(amount1)+parseFloat(amount2)+parseFloat(amount3)+parseFloat(amount4));

if(balance < 0)
{
alert("Entered Amount is greater than Net Payable");
if(serialnumber == '1')
{
document.getElementById("amount1").value = "0.00";
}
if(serialnumber == '2')
{
document.getElementById("amount2").value = "0.00";
}
if(serialnumber == '3')
{
document.getElementById("amount3").value = "0.00";
}
if(serialnumber == '4')
{
document.getElementById("amount4").value = "0.00";
}
document.getElementById("balance").value = "";
return false;
}
document.getElementById("balance").value = balance.toFixed(2);
var nhif_count=0;
var provider_count=0;
var acc_anum1 = document.getElementById("accountnameano").value;
var acc_anum2 = document.getElementById("accountnameano2").value;
var acc_anum3 = document.getElementById("accountnameano3").value;
var nhif_array=['411','412','413','414','415','416','417','418','419'];
if(acc_anum1!=''){
	var anum1=(nhif_array.indexOf(acc_anum1) >= 0);
	if(anum1==true)
	{
		nhif_count=parseFloat(nhif_count)+1;
	}else
	{
	provider_count=parseFloat(provider_count)+1;	
	}
}

if(acc_anum2!=''){
	var anum2=(nhif_array.indexOf(acc_anum2) >= 0);
	if(anum2==true)
	{
		nhif_count=parseFloat(nhif_count)+1;
	}else
	{
	   provider_count=parseFloat(provider_count)+1;	
	}
}
if(acc_anum3!=''){
	var anum3=(nhif_array.indexOf(acc_anum3) >= 0);
	if(anum3==true)
	{
		nhif_count=parseFloat(nhif_count)+1;
	}else
	{
	   provider_count=parseFloat(provider_count)+1;	
	}
}
//alert(nhif_count);
//alert(provider_count);
document.getElementById("smart_text").innerHTML ="";
if((nhif_count==1)&&(provider_count==1))
{
document.getElementById("smart_text").innerHTML ="Smart Applicable";	
}
else
{
document.getElementById("smart_text").innerHTML ="Smart Not Applicable";	
}
}

function validcheck()
{

if(document.getElementById("accountname").value!='' && document.getElementById("accountnameid").value.trim()==''){
  alert("Please Select any Account");
  document.getElementById("accountname").focus();
  return false;
}

if(document.getElementById("accountname2").value!='' && document.getElementById("accountnameid2").value.trim()==''){
  alert("Please Select any Account");
  document.getElementById("accountname2").focus();
  return false;
}
if(document.getElementById("accountname3").value!='' && document.getElementById("accountnameid3").value==''){
  alert("Please Select any Account");
  document.getElementById("accountname3").focus();
  return false;
}

var i;
var accountname = document.getElementById("accountnameid").value
if(accountname == '')
{
i = 0;
}
else
{
i = 1;
}

if(i == 0)
{
var accountname2 = document.getElementById("accountnameid2").value
if(accountname2 == '')
{
i = 0;
}
else
{
i = 1;
}
}

if(i == 0)
{
var accountname3 = document.getElementById("accountnameid3").value
if(accountname3 == '')
{
i = 0;
}
else
{
i = 1;
}
}

if(i == 0)
{
alert("Please Select any Account");
return false;
}



var balance = document.getElementById("balance").value;
if(balance == '')
{
alert("Please Enter the Amount");
return false;
}
if(balance != 0.00)
{
alert("Balance is still pending");
return false;
}

var varUserChoice; 
	varUserChoice = confirm('Are You Sure Want To Save This Entry?'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		alert ("Entry Not Saved.");
		return false;
	}
}

function clearData(sno)
{
	
	var account=document.getElementById("accountname"+sno).value;
	if(account==""){
		document.getElementById("accountnameid"+sno).value=' ';
		document.getElementById("accountnameano"+sno).value=' ';
	}
}
</script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/autocomplete_accounts1.js"></script>
<script type="text/javascript" src="js/autocomplete_accounts12.js"></script>
<script type="text/javascript" src="js/autocomplete_accounts13.js"></script>
<script type="text/javascript" src="js/autosuggest3accounts1.js"></script>
<script type="text/javascript" src="js/autosuggestaccounts12.js"></script>
<script type="text/javascript" src="js/autosuggestaccounts13.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("accountname"), new StateSuggestions()); 
	var oTextbox2 = new AutoSuggestControl2(document.getElementById("accountname2"), new StateSuggestions2()); 
	var oTextbox3 = new AutoSuggestControl3(document.getElementById("accountname3"), new StateSuggestions3());        
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
font-weight:bold;
}
.bali
{
text-align:right;
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<form name="form1" id="form1" method="post" action="creditapprovalform.php" onSubmit="return validcheck()">	
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="15" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="15" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="15" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="15">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
   
    <td colspan="6" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      
	 
	
		<tr>
		<td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
           <?php
		  
		  $locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
		   $query1 = "select locationcode from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
		
		
		$locationcodeget = $res1['locationcode'];
		$query551 = "select * from master_location where locationcode='".$locationcodeget."'";
		$exec551 = mysqli_query($GLOBALS["___mysqli_ston"], $query551) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res551 = mysqli_fetch_array($exec551);
		$locationnameget = $res551['locationname'];
		}?>
             <tr>
						  <td colspan="4" class="bodytext31" bgcolor="#ecf0f5"><strong>Credit Approval</strong></td>
                           <td colspan="3" class="bodytext31" bgcolor="#ecf0f5"><strong>Location &nbsp;</strong><?php echo $locationnameget;?></td>
                  <input type="hidden" name="locationcodeget" value="<?php echo $locationcodeget?>">
				<input type="hidden" name="locationnameget" value="<?php echo $locationnameget?>">
						</tr>
            <tr>
              <td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Doc No</strong></div></td>
				 <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>
           
				 <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>
				 <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Visit  </strong></div></td>
				 <td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill Type</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
              </tr>
           <?php
            $colorloopcount ='';
		
		$query1 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
		
		while($res1 = mysqli_fetch_array($exec1))
		{
		$patientname=$res1['patientfullname'];
		$patientcode=$res1['patientcode'];
		$patienttype=$accountname = $res1['accountname'];
		$billtype = $res1['billtype'];
		$gender = $res1['gender'];
		$age = $res1['age'];
		$patientsubtype=$res1['subtype'];
		
		
		//$Querylab=mysql_query("select * from master_customer where customercode='$patientcode'");
		//$execlab=mysql_fetch_array($Querylab);
		//$patienttype=$execlab['maintype'];
		$querytype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_paymenttype where auto_number='$patienttype'");
		$exectype=mysqli_fetch_array($querytype);
		$patienttype1=$exectype['paymenttype'];
		//$patientsubtype=$execlab['subtype'];

		$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$patientsubtype'");
		$execsubtype=mysqli_fetch_array($querysubtype);
		$patientsubtype1=$execsubtype['subtype'];
		$currency=$execsubtype['currency'];
		$fxrate=$execsubtype['fxrate'];
		$bedtemplate=$execsubtype['bedtemplate'];
		$labtemplate=$execsubtype['labtemplate'];
		$radtemplate=$execsubtype['radtemplate'];
		$sertemplate=$execsubtype['sertemplate'];
		$querytt32 = "select * from master_testtemplate where templatename='$bedtemplate'";
		$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$numtt32 = mysqli_num_rows($exectt32);
		$exectt=mysqli_fetch_array($exectt32);
		$bedtable=$exectt['referencetable'];
		if($bedtable=='')
		{
			$bedtable='master_bed';
		}
		$bedchargetable=$exectt['templatename'];
		if($bedchargetable=='')
		{
			$bedchargetable='master_bedcharge';
		}
		$querytl32 = "select * from master_testtemplate where templatename='$labtemplate'";
		$exectl32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytl32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$numtl32 = mysqli_num_rows($exectl32);
		$exectl=mysqli_fetch_array($exectl32);		
		$labtable=$exectl['templatename'];
		if($labtable=='')
		{
			$labtable='master_lab';
		}
		
		$querytt32 = "select * from master_testtemplate where templatename='$radtemplate'";
		$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$numtt32 = mysqli_num_rows($exectt32);
		$exectt=mysqli_fetch_array($exectt32);		
		$radtable=$exectt['templatename'];
		if($radtable=='')
		{
			$radtable='master_radiology';
		}
		
		$querytt32 = "select * from master_testtemplate where templatename='$sertemplate'";
		$exectt32 = mysqli_query($GLOBALS["___mysqli_ston"], $querytt32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$numtt32 = mysqli_num_rows($exectt32);
		$exectt=mysqli_fetch_array($exectt32);
		$sertable=$exectt['templatename'];
		if($sertable=='')
		{
			$sertable='master_services';
		}
		$query813 = "select * from ip_discharge where visitcode='$visitcode' and patientcode='$patientcode'";
		$exec813 = mysqli_query($GLOBALS["___mysqli_ston"], $query813) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res813 = mysqli_fetch_array($exec813);
		$num813 = mysqli_num_rows($exec813);
		if($num813 > 0)
		{
		$updatedate=$res813['recorddate'];
		}
			
		
		$query67 = "select * from master_accountname where auto_number='$accountname'";
		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
		$res67 = mysqli_fetch_array($exec67);
		$accname = $res67['accountname'];
		$acccode = $res67['id'];
		$accanum = $res67['auto_number'];
		
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
               <td align="left" valign="center" class="bodytext31">
			    <div align="center"><?php echo $billnumbercode; ?></div></td>
			
			  <td align="left" valign="center" class="bodytext31">
			    <div align="center"><?php echo $patientname; ?></div></td>
				<td align="center" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $visitcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $updatedate; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $billtype; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $accname; ?></td>
			<input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname; ?>">
				 
				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>">
					<input type="hidden" name="subtype" id="subtype" value="<?php echo $patientsubtype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
				<input type="hidden" name="paymenttype" id="paymenttype" value="<?php echo $patienttype1; ?>">	
			
				<input type="hidden" name="accname" id="accname" value="<?php echo $accname; ?>">
				<input type="hidden" name="acccode" id="acccode" value="<?php echo $acccode; ?>">
				<input type="hidden" name="accanum" id="accanum" value="<?php echo $accanum; ?>">
				<input type="hidden" name="billno" id="billno" value="<?php echo $billnumbercode; ?>">
			   </tr>
		   <?php 
		   } 
		  
		   ?>
           
            <tr>
             	<td colspan="7" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>
             	</tr>
          </tbody>
        </table>		</td>
		</tr>
		
		</table>		</td>
		</tr>
		<tr>
        <td>&nbsp;</td>
		</tr>
	<tr>
	
	<td>&nbsp;</td>
	<td width="6%">&nbsp;</td>
	<td colspan="2">
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
           <tr bgcolor="#011E6A">
                <td colspan="9" bgcolor="#ecf0f5" class="bodytext31"><strong>Transaction Details</strong></td>
			 </tr>
          
            <tr>
			 
              <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ref.No</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Description</strong></div></td>
                <td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Qty</strong></div></td>
				<td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong><?php echo strtoupper($currency);?></strong></div></td>
                <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount</strong></div></td>
                <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>UHX(<?php echo strtoupper($currency);?>)</strong></div></td>
                <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount</strong></div></td>
                  </tr>
				  		<?php
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
			$totalquantity = 0;
			$totalop =0;
			$totalopuhx=0;
			$query17 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res17 = mysqli_fetch_array($exec17);
			$consultationfee=$res17['admissionfees'];
			$consultationfee = number_format($consultationfee,2,'.','');
			$viscode=$res17['visitcode'];
			$consultationdate=$res17['consultationdate'];
			$packchargeapply = $res17['packchargeapply'];
			$packageanum1 = $res17['package'];
			
			
			$query53 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec53 = mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res53 = mysqli_fetch_array($exec53);
			$refno = $res53['docno'];
			
			if($packageanum1 != 0)
			{
			if($packchargeapply == 1)
		{
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
			$totalop=$consultationfee/$fxrate;
			$totalopuhx=$consultationfee;
			?>
			   <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Admission Charge'; ?></div></td>
			     <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
				  	 <input type="hidden" name="admissionchargerate[]" id="admissionchargerate" value="<?php echo $consultationfee/$fxrate; ?>">
			 <input type="hidden" name="admissionchargeamount[]" id="admissionchargeamount" value="<?php echo $consultationfee/$fxrate; ?>">
             
               	 <input type="hidden" name="admissionchargerateuhx[]" id="admissionchargerateuhx" value="<?php echo $consultationfee; ?>">
			 <input type="hidden" name="admissionchargeamountuhx[]" id="admissionchargeamountuhx" value="<?php echo $consultationfee; ?>">
			
	  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($consultationfee/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($consultationfee/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($consultationfee),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($consultationfee),2,'.',','); ?></div></td>
            </tr>
			<?php
			}
			}
			else
			{
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
			$totalop=$consultationfee/$fxrate;
			$totalopuhx=$consultationfee;
			?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Admission Charge'; ?></div></td>
			     <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
				 		  	 <input type="hidden" name="admissionchargerate[]" id="admissionchargerate" value="<?php echo $consultationfee/$fxrate; ?>">
			 <input type="hidden" name="admissionchargeamount[]" id="admissionchargeamount" value="<?php echo $consultationfee/$fxrate; ?>">
             
              	 <input type="hidden" name="admissionchargerateuhx[]" id="admissionchargerateuhx" value="<?php echo $consultationfee; ?>">
			 <input type="hidden" name="admissionchargeamountuhx[]" id="admissionchargeamountuhx" value="<?php echo $consultationfee; ?>">
             
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($consultationfee/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($consultationfee/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($consultationfee),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($consultationfee),2,'.',','); ?></div></td>
            </tr>
			<?php
			}
			
			?>
					  <?php
					  $packageamount = 0;
					  $packageamountuhx=0;
			 $query731 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec731 = mysqli_query($GLOBALS["___mysqli_ston"], $query731) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res731 = mysqli_fetch_array($exec731);
			$packageanum1 = $res731['package'];
			$packagedate1 = $res731['consultationdate'];
			$packageamount = $res731['packagecharge'];
			
			$query741 = "select * from master_ippackage where auto_number='$packageanum1'";
			$exec741 = mysqli_query($GLOBALS["___mysqli_ston"], $query741) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res741 = mysqli_fetch_array($exec741);
			$packdays1 = $res741['days'];
			$packagename = $res741['packagename'];
			
			$packageamountuhx=$packageamount*$fxrate;
			if($packageanum1 != 0)
	{
	
	 $reqquantity = $packdays1;
	 
	 $reqdate = date('Y-m-d',strtotime($packagedate1) + (24*3600*$reqquantity));
	 
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
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $packagedate1; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $visitcode; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $packagename; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			 <input type="hidden" name="description[]" id="description" value="<?php echo $packagename; ?>">
			 <input type="hidden" name="descriptionrate[]" id="descriptionrate" value="<?php echo $packageamount; ?>">
			 <input type="hidden" name="descriptionamount[]" id="descriptionamount" value="<?php echo $packageamount; ?>">
			 <input type="hidden" name="descriptionquantity[]" id="descriptionquantity" value="<?php echo '1'; ?>">
			  <input type="hidden" name="descriptiondocno[]" id="descriptiondocno" value="<?php echo $visitcode; ?>">
              
               <input type="hidden" name="descriptionrateuhx[]" id="descriptionrateuhx" value="<?php echo $packageamount*$fxrate; ?>">
			 <input type="hidden" name="descriptionamountuhx[]" id="descriptionamountuhx" value="<?php echo $packageamount*$fxrate; ?>">
             
                     <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($packageamount),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($packageamount),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($packageamount*$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($packageamount*$fxrate),2,'.',','); ?></div></td>
              </tr>
			  <?php
			  }
			  ?>
			<?php 
			$totalbedallocationamount = 0;
			$totalbedallocationamountuhx=0;
			 $requireddate = '';
			 $quantity = '';
			 $allocatenewquantity = '';
			$query18 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res18 = mysqli_fetch_array($exec18);
			$ward = $res18['ward'];
			$allocateward = $res18['ward'];
			
			$bed = $res18['bed'];
			$refno = $res18['docno'];
			$date = $res18['recorddate'];
			$bedallocateddate = $res18['recorddate'];
			$packagedate = $res18['recorddate'];
			$newdate = $res18['recorddate'];

			
			
			
			$query73 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec73 = mysqli_query($GLOBALS["___mysqli_ston"], $query73) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res73 = mysqli_fetch_array($exec73);
			$packageanum = $res73['package'];
			$type = $res73['type'];
			$doctorType = $res73['doctorType'];
			$ipage = $res73['age'];
			
			
			$query74 = "select * from master_ippackage where auto_number='$packageanum'";
			$exec74 = mysqli_query($GLOBALS["___mysqli_ston"], $query74) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res74 = mysqli_fetch_array($exec74);
			$packdays = $res74['days'];
			
		   $query51 = "select * from master_bed where auto_number='$bed'";
		   $exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res51 = mysqli_fetch_array($exec51);
		   $bedname = $res51['bed'];
		   $threshold = $res51['threshold'];
		   $thresholdvalue = $threshold/100;
		   
			
			  
			   $totalbedallocationamount=0;
			   $totalbedallocationamountuhx=0;
			   $discount_bed = 0;
				$query18 = "select ward,bed,docno,recorddate,leavingdate,recordstatus,discount_amt from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
				$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res18 = mysqli_fetch_array($exec18))
				{
					$ward = $res18['ward'];
					$allocateward = $res18['ward'];		
					
					$ward_discount=0;
			$sql_ward_disc="select discount from ward_scheme_discount where ward_id='$ward' and account_id='$accountname' and record_status='1'";
			$warddisc73 = mysqli_query($GLOBALS["___mysqli_ston"], $sql_ward_disc) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$wardnum73 = mysqli_num_rows($warddisc73);
			if($wardnum73>0){
			$wardres73 = mysqli_fetch_array($warddisc73);
			$ward_discount=$wardres73['discount'];

			}

					$bed = $res18['bed'];
					$refno = $res18['docno'];
					$date = $res18['recorddate'];
					$bedallocateddate = $res18['recorddate'];
					$packagedate = $res18['recorddate'];
					$leavingdate = $res18['leavingdate'];
					$recordstatus = $res18['recordstatus'];
					$discount_bed = $res18['discount_amt'];
					if($leavingdate=='0000-00-00')
					{
						$leavingdate=$updatedate;
					}
					$query51 = "select bed,threshold from `$bedtable` where auto_number='$bed'";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$res51 = mysqli_fetch_array($exec51);
					$bedname = $res51['bed'];
					$threshold = $res51['threshold'];
					$thresholdvalue = $threshold/100;
					$time1 = new DateTime($bedallocateddate);
					$time2 = new DateTime($leavingdate);
					$interval = $time1->diff($time2);			  
					$quantity_bedt=$quantity1 = $interval->format("%a");
					if($packdays1>$quantity1)
					{
						$quantity1=$quantity1-$packdays1; 
						$packdays1=$packdays1-$quantity_bedt;
					}
					else
					{
						$quantity1=$quantity1-$packdays1;
						$packdays1=0;
					}
					$quantity='0';
					$diff = abs(strtotime($leavingdate) - strtotime($bedallocateddate));
					$query91 = "select charge,rate from `$bedchargetable` where bedanum='$bed' and recordstatus ='' ";
					$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num91 = mysqli_num_rows($exec91);

					$tmp=array();
					$tmpbed=array();
					$tmpbedcharge=array();
					while($res91 = mysqli_fetch_array($exec91))
					{
                       $tmp[]=$res91;
					}
										
					if(is_array($tmp)){
						foreach($tmp as $k =>$v){
						   if($v[0]=='Accommodation Only'){
                              $tmpbed[0]=$v[0];
							  $tmpbed['charge']=$v[0];
						      $tmpbed[1]=$v[1];
							  $tmpbed['rate']=$v[1];
                              unset($tmp[$k]);
						   }
						}

						if(is_array($tmpbed) and count($tmpbed)>0){
                           
						   foreach($tmp as $k =>$v){
                              if($v[0]=='Bed Charges'){
                                 $tmpbedcharge[]=$v;
								 $tmpbedcharge[]=$tmpbed;
							  }else
								  $tmpbedcharge[]=$v;

						   }
						   unset($tmp);
						   $tmp=$tmpbedcharge;
						}
					}

					foreach($tmp as $rslt)
					{
						$charge = $rslt['charge'];
						$rate = $rslt['rate'];	
                        
						if($doctorType==1 && $charge=='Daily Review charge')
							continue;
						elseif($doctorType==0 && $charge=='Consultant Fee')
							continue;

						if($ipage >7 && $charge=='Accommodation Only' )
						  continue;
						
						if($charge!='Bed Charges')
						{
							//$quantity=$quantity1+1;
							if($recordstatus=='discharged')
							{
								if($bedallocateddate==$leavingdate)
								{
									$quantity=$quantity1+1;
								}
								else
								{
									$quantity=$quantity1;
								}
							}
							else
							{
								$quantity=$quantity1;
							}
						}
						else
						{
							$rate = $rate-$discount_bed-$ward_discount;
							if($recordstatus=='discharged')
							{
								if($bedallocateddate==$leavingdate)
								{
									$quantity=$quantity1+1;
								}
								else
								{
									$quantity=$quantity1;
								}
							}
							else
							{
								$quantity=$quantity1;
							}
						}
						$amount = $quantity * $rate;						
						$allocatequantiy = $quantity;
						$allocatenewquantity = $quantity;
						if($quantity>0 && $amount>0)
						{
							if($type=='hospital'||$charge!='Resident Doctor Charges')
							{
								   $colorloopcount = $sno + 1;
								   if($charge == 'Cafetaria Charges')
									{
										$charge1 = 'Meals';
									}
									elseif($charge == 'Nursing Charges')
									{
										$charge1 = 'Nursing Care';
									}
									elseif($charge == 'RMO Charges')
									{
										$charge1 = 'Doctors Review';
									}
									elseif($charge == 'Accommodation Charges')
									{
										$charge1 = 'Sundries';
									}
									else{
										$charge1 = $charge;
									}
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
								if($quantity!=0){
								$totalbedallocationamount=$totalbedallocationamount+($amount);
								$amountuhx = $rate*$quantity;
								$totalbedallocationamountuhx = $totalbedallocationamountuhx + ($amountuhx*$fxrate);
								
					  ?>
								<tr <?php echo $colorcode; ?>>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $bedallocateddate; ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge1; ?>(<?php echo $bedname; ?>)</div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
                                    <input type="hidden" name="descriptioncharge12[]" id="descriptioncharge12" value="<?php echo $quantity*($rate); ?>">
                                     <input type="hidden" name="descriptionchargerate12[]" id="descriptionchargerate12" value="<?php echo $rate; ?>">
                                     <input type="hidden" name="descriptionchargeamount12[]" id="descriptionchargeamount12" value="<?php echo $quantity*($rate); ?>">
									
									<input type="hidden" name="descriptionchargequantity[]" id="descriptionchargequantity" value="<?php echo $quantity; ?>">
									<input type="hidden" name="descriptionchargedocno[]" id="descriptionchargedocno" value="<?php echo $refno; ?>">
									<input type="hidden" name="descriptionchargeward[]" id="descriptionchargeward" value="<?php echo $ward; ?>">
									<input type="hidden" name="descriptionchargebed[]" id="descriptionchargebed" value="<?php echo $bed; ?>">
                                    <input type="hidden" name="descriptionchargerate12uhx[]" id="descriptionchargerate12uhx" value="<?php echo $rate*$fxrate; ?>">
			 <input type="hidden" name="descriptionchargeamount12uhx[]" id="descriptionchargeamount12uhx" value="<?php echo $rate*$quantity*$fxrate; ?>">
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($rate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($quantity*($rate)),2,'.',','); ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($rate*$fxrate,2,'.',','); ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount*$fxrate,2,'.',','); ?></div></td>
								</tr>              
					 
					   <?php } // if Qtantity !=0 close
							}
						}
					}
				}
				$totalbedtransferamount=0;
				$totalbedtransferamountuhx=0;
				$discount_bed =0 ;
				$query18 = "select ward,bed,docno,recorddate,leavingdate,recordstatus,discount_amt from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode'";
				$exec18 = mysqli_query($GLOBALS["___mysqli_ston"], $query18) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($res18 = mysqli_fetch_array($exec18))
				{
					$quantity1=0;
					$ward = $res18['ward'];
					$allocateward = $res18['ward'];		
					
					$ward_discount=0;
					$sql_ward_disc="select discount from ward_scheme_discount where ward_id='$ward' and account_id='$accountname' and record_status='1'";
					$warddisc73 = mysqli_query($GLOBALS["___mysqli_ston"], $sql_ward_disc) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$wardnum73 = mysqli_num_rows($warddisc73);
					if($wardnum73>0){
					$wardres73 = mysqli_fetch_array($warddisc73);
					$ward_discount=$wardres73['discount'];

					}


					$bed = $res18['bed'];
					$refno = $res18['docno'];
					$date = $res18['recorddate'];
					//$bedallocateddate = $res18['recorddate'];
					$packagedate = $res18['recorddate'];
					$discount_bed = $res18['discount_amt'];

					$leavingdate = $res18['leavingdate'];
					$recordstatus = $res18['recordstatus'];
					if($leavingdate=='0000-00-00')
					{
						$leavingdate=$updatedate;
					}
					$query51 = "select bed,threshold from `$bedtable` where auto_number='$bed'";
					$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$res51 = mysqli_fetch_array($exec51);
					$bedname = $res51['bed'];
					$threshold = $res51['threshold'];
					$thresholdvalue = $threshold/100;
					$time1 = new DateTime($date);
					$time2 = new DateTime($leavingdate);
					$interval = $time1->diff($time2);			  
					$quantity1 = $interval->format("%a");
					if($packdays1>$quantity1)
					{
						$quantity1=$quantity1-$packdays1; 
						$packdays1=$packdays1-$quantity1;
					}
					else
					{
						$quantity1=$quantity1-$packdays1;
						$packdays1=0;
					}
					$bedcharge='0';
					$quantity='0';
					$diff = abs(strtotime($leavingdate) - strtotime($bedallocateddate));
					$query91 = "select charge,rate from `$bedchargetable` where bedanum='$bed' and recordstatus ='' ";
					$exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					$num91 = mysqli_num_rows($exec91);
					while($res91 = mysqli_fetch_array($exec91))
					{
						$charge = $res91['charge'];
						$rate = $res91['rate'];	
						
						if($doctorType==1 && $charge=='Daily Review charge')
							continue;
						elseif($doctorType==0 && $charge=='Consultant Fee')
							continue;
						 
						if($ipage > 7 && $charge=='Accommodation Only' ) {
						  continue;
						  }

						if($charge!='Bed Charges')
						{
							//$quantity=$quantity1+1;
							if($recordstatus=='discharged')
							{
								if($bedallocateddate==$leavingdate)
								{
									$quantity=$quantity1+1;
								}
								else
								{
									$quantity=$quantity1;
								}
							}
							else
							{
								$quantity=$quantity1;
							}
						}
						else
						{
							$rate = $rate-$discount_bed-$ward_discount;
							if($recordstatus=='discharged')
							{
								if($bedallocateddate==$leavingdate)
								{
									$quantity=$quantity1+1;
								}
								else
								{
									$quantity=$quantity1;
								}
							}
							else
							{
								$quantity=$quantity1;
							}
						}
						//echo $quantity;
						$amount = $quantity * $rate;						
						$allocatequantiy = $quantity;
						$allocatenewquantity = $quantity;
						//echo $bedcharge;
						if($bedcharge=='0')
						{
							//$quantity
							if($quantity>0 && $amount>0)
							{
								if($type=='hospital'||$charge!='Resident Doctor Charges')
								{
									$colorloopcount = $sno + 1;
									$showcolor = ($colorloopcount & 1);  
									if($charge == 'Cafetaria Charges')
									{
										$charge1 = 'Meals';
									}
									elseif($charge == 'Nursing Charges')
									{
										$charge1 = 'Nursing Care';
									}
									elseif($charge == 'RMO Charges')
									{
										$charge1 = 'Doctors Review';
									}
									elseif($charge == 'Accommodation Charges')
									{
										$charge1 = 'Sundries';
									}
									else{
										$charge1 = $charge;
									}
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
									if($quantity!=0){
									$totalbedtransferamount=$totalbedtransferamount+($amount);
									$amountuhx = $rate*$quantity;
									$totalbedtransferamountuhx = $totalbedtransferamountuhx + ($amountuhx*$fxrate);
						  ?>
									<tr <?php echo $colorcode; ?>>
										<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge1; ?>(<?php echo $bedname; ?>)</div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
										<input type="hidden" name="descriptioncharge12[]" id="descriptioncharge12" value="<?php echo $quantity*($rate); ?>">
                                         <input type="hidden" name="descriptionchargerate12[]" id="descriptionchargerate12" value="<?php echo $rate; ?>">
                                         <input type="hidden" name="descriptionchargeamount12[]" id="descriptionchargeamount12" value="<?php echo $quantity*($rate); ?>">
										<input type="hidden" name="descriptionchargequantity[]" id="descriptionchargequantity" value="<?php echo $quantity; ?>">
										<input type="hidden" name="descriptionchargedocno[]" id="descriptionchargedocno" value="<?php echo $refno; ?>">
										<input type="hidden" name="descriptionchargeward[]" id="descriptionchargeward" value="<?php echo $ward; ?>">
										<input type="hidden" name="descriptionchargebed[]" id="descriptionchargebed" value="<?php echo $bed; ?>">
                                        <input type="hidden" name="descriptionchargerate12uhx[]" id="descriptionchargerate12uhx" value="<?php echo $rate*$fxrate; ?>">
			 <input type="hidden" name="descriptionchargeamount12uhx[]" id="descriptionchargeamount12uhx" value="<?php echo $rate*$quantity*$fxrate; ?>">
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($rate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($quantity*($rate)),2,'.',','); ?></div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($rate*$fxrate,2,'.',','); ?></div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount*$fxrate			,2,'.',','); ?></div></td>
									</tr>              
						 
						   <?php  } // if Qtantity !=0 close
								}
							}
							else
							{
								if($charge=='Bed Charges')
								{
									//$bedcharge='1';
								}
							}
						}
					}
				}
			  ?>
			 
			   <?php 
			$totalpharm=0;
			$totalpharmuhx=0;
			$query23 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' GROUP BY ipdocno,itemcode";
			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res23 = mysqli_fetch_array($exec23))
			{
			$phaquantity=0;
			$quantity1=0;
			$phaamount=0;
			$phaquantity1=0;
			$totalrefquantity=0;
			$phaamount1=0;
			$phadate=$res23['entrydate'];
			$phaname=$res23['itemname'];
			 $phaitemcode=$res23['itemcode'];
			$pharate=$res23['rate'];
			$quantity=$res23['quantity'];
			$refno = $res23['ipdocno'];
			$pharmfree = $res23['freestatus'];
			$amount=$pharate*$quantity;
			$query33 = "select quantity,totalamount from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode' and ipdocno = '$refno'";
			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res33 = mysqli_fetch_array($exec33))
			{
			$quantity=$res33['quantity'];
			$phaquantity=$phaquantity+$quantity;
			$amount=$res33['totalamount'];
			$phaamount=$phaamount+$amount;
			}
   			$quantity=$phaquantity;
			$amount=$pharate*$quantity;
			$query331 = "select sum(quantity) as quantity, sum(totalamount) as totalamount from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and docnumber='$refno' and itemcode='$phaitemcode'";
			$exec331 = mysqli_query($GLOBALS["___mysqli_ston"], $query331) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $res331 = mysqli_fetch_array($exec331);
			
			$quantity1=$res331['quantity'];
			//$phaquantity1=$phaquantity1+$quantity1;
			$amount1=$res331['totalamount'];
			//$phaamount1=$phaamount1+$amount1;
			
			
			$resquantity = $quantity - $quantity1;
			$resamount = $amount - $amount1;
						
			$resamount=number_format($resamount,2,'.','');
			//if($resquantity != 0)
			{
			if(strtoupper($pharmfree) =='NO')
			{
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
			if($resquantity!=0){  
			$resamount=$resquantity*($pharate/$fxrate);
			$totalpharm=$totalpharm+$resamount;
			
			 $resamountuhx = $pharate*$resquantity;
		   $totalpharmuhx = $totalpharmuhx + $resamountuhx;
			
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $phaname; ?></div></td>
			 <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo $resquantity; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php echo $pharate/$fxrate; ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php echo $resamount; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo floatval($resquantity); ?></div></td>
             
              <input name="rateuhx[]" type="hidden" id="rateuhx" readonly size="8" value="<?php echo $pharate; ?>">
			 <input name="amountuhx[]" type="hidden" id="amountuhx" readonly size="8" value="<?php echo $pharate*$resquantity; ?>">
             
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($pharate/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($resquantity*($pharate/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($pharate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($pharate*$resquantity),2,'.',','); ?></div></td>
                  
             <?php  } // if Qtantity !=0 close
         		} 
			  }
			  }
			  ?>
			  <?php 
			  $totallab=0;
			    $totallabuhx=0;
			  $query19 = "select * from ipconsultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and labrefund <> 'refund'";
			$exec19 = mysqli_query($GLOBALS["___mysqli_ston"], $query19) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res19 = mysqli_fetch_array($exec19))
			{
			$labdate=$res19['consultationdate'];
			$labname=$res19['labitemname'];
			$labcode=$res19['labitemcode'];
			$labrate=$res19['labitemrate'];
			$labrefno=$res19['iptestdocno'];
			$labfree = $res19['freestatus'];
			
			if(strtoupper($labfree) == 'NO')
			{
			$queryl51 = "select rateperunit from `$labtable` where itemcode='$labcode'";
			$execl51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryl51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$resl51 = mysqli_fetch_array($execl51);
			$labrate = $resl51['rateperunit'];
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
			$totallab=$totallab+$labrate;
			
			 $labrateuhx = $labrate*$fxrate;
		   $totallabuhx = $totallabuhx + $labrateuhx;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labrefno; ?></div></td>
			 <input name="lab[]" id="lab" size="69" type="hidden" value="<?php echo $labname; ?>">
			 <input name="rate5[]" id="rate5" readonly size="8" type="hidden" value="<?php echo $labrate; ?>">
			 <input name="labcode[]" id="labcode" readonly size="8" type="hidden" value="<?php echo $labcode; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $labname; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             
             
              <input name="rate5uhx[]" id="rate5uhx" readonly size="8" type="hidden" value="<?php echo $labrate*$fxrate; ?>">
              
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labrate,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labrate,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($labrate*$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($labrate*$fxrate),2,'.',','); ?></div></td>
                  
             <?php }
			  }
			  ?>
			  
			    <?php 
				$totalrad=0;
				$totalraduhx=0;
			  $query20 = "select * from ipconsultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund'";
			$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res20 = mysqli_fetch_array($exec20))
			{
			$raddate=$res20['consultationdate'];
			$radname=$res20['radiologyitemname'];
			$radrate=$res20['radiologyitemrate'];
			$radref=$res20['iptestdocno'];
			$radiologyfree = $res20['freestatus'];
			$radiologyitemcode = $res20['radiologyitemcode'];
			if(strtoupper($radiologyfree) == 'NO')
			{
			$queryr51 = "select rateperunit from `$radtable` where itemcode='$radiologyitemcode'";
			$execr51 = mysqli_query($GLOBALS["___mysqli_ston"], $queryr51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$resr51 = mysqli_fetch_array($execr51);
			$radrate = $resr51['rateperunit'];
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
			$totalrad=$totalrad+$radrate;
			
			 $radrateuhx = $radrate*$fxrate;
		   $totalraduhx = $totalraduhx + $radrateuhx;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $raddate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $radref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $radname; ?></div></td>

			 <input name="radiology[]" id="radiology" type="hidden" size="69" autocomplete="off" value="<?php echo $radname; ?>">
			 <input name="rate8[]" type="hidden" id="rate8" readonly size="8" value="<?php echo $radrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             
              <input name="rate8uhx[]" type="hidden" id="rate8uhx" readonly size="8" value="<?php echo $radrate*$fxrate; ?>">
             
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radrate,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radrate,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($radrate*$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($radrate*$fxrate),2,'.',','); ?></div></td>
                  
             <?php }
			  }
			  ?>	  	    <?php 
					
					$totalser=0;
					$totalseruhx=0;
		    $query21 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund' group by servicesitemcode,iptestdocno";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res21 = mysqli_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$serref=$res21['iptestdocno'];
			$servicesfree = $res21['freestatus'];
			$servicesdoctorname = $res21['doctorname'];
			$sercode=$res21['servicesitemcode'];
			$querys51 = "select rateperunit from `$sertable` where itemcode='$sercode'";
			$execs51 = mysqli_query($GLOBALS["___mysqli_ston"], $querys51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$ress51 = mysqli_fetch_array($execs51);
			$serrate = $ress51['rateperunit'];
			$query2111 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and servicerefund <> 'refund'";
			$exec2111 = mysqli_query($GLOBALS["___mysqli_ston"], $query2111) or die ("Error in Query2111".mysqli_error($GLOBALS["___mysqli_ston"]));
			$numrow2111 = mysqli_num_rows($exec2111);
			$res211 = mysqli_fetch_array($exec2111);
			$serqty=$res21['serviceqty'];
			if($serqty==0){$serqty=$numrow2111;}
			
			if(strtoupper($servicesfree) == 'NO')
			{	
			$totserrate=$res21['amount'];
			 if($totserrate==0){
			$totserrate=$serrate*$numrow2111;
			  }
			/*$totserrate=$serrate*$numrow2111;*/
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
			if($serqty!=0){ 
				$totalser=$totalser+$totserrate;
			
			 $totserrateuhx = ($totserrate*$fxrate);
		   $totalseruhx = $totalseruhx + $totserrateuhx;
			?>
            
            
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sername." - ".$servicesdoctorname; ?></div></td>
			 <input name="services[]" type="hidden" id="services" size="69" value="<?php echo $sername; ?>">
			 <input name="rate3[]" type="hidden" id="rate3" readonly size="8" value="<?php echo $totserrate; ?>">
			 <input name="quantityser[]" type="hidden" id="quantityser" readonly size="8" value="<?php echo $serqty; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serqty; ?></div></td>
             
             <input name="rate3uhx[]" type="hidden" id="rate3uhx" readonly size="8" value="<?php echo ($totserrate*$fxrate); ?>">
             
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serrate,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($totserrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($serrate*$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format((($totserrate*$fxrate)),2,'.',','); ?></div></td>
                  
             <?php 		 } // if Qtantity !=0 close
         			}
			  }
			  ?>
			<?php
			$totalotbillingamount = 0;
			$totalotbillingamountuhx=0;
			$query61 = "select * from ip_otbilling where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res61 = mysqli_fetch_array($exec61))
		   {
			$otbillingdate = $res61['consultationdate'];
			$otbillingrefno = $res61['docno'];
			$otbillingname = $res61['surgeryname'];
			$otbillingrate = $res61['rate'];
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
			$otbillingrate = 1*($otbillingrate/$fxrate);
			$totalotbillingamount = $totalotbillingamount + $otbillingrate;
			
			 $otbillingrateuhx = $otbillingrate;
		   $totalotbillingamountuhx = $totalotbillingamountuhx + $otbillingrateuhx;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $otbillingdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $otbillingrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $otbillingname; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			  		 <input type="hidden" name="otbilling[]" id="otbilling" value="<?php echo $otbillingname; ?>">
			 	 <input type="hidden" name="otbillingrate[]" id="otbillingrate" value="<?php echo $otbillingrate/$fxrate; ?>">
			 <input type="hidden" name="otbillingamount[]" id="otbillingamount" value="<?php echo $otbillingrate/$fxrate; ?>">
             
              <input type="hidden" name="otbillingrateuhx[]" id="otbillingrateuhx" value="<?php echo $otbillingrate; ?>">
			 
  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($otbillingrate/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format((1*($otbillingrate/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($otbillingrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($otbillingrate*1),2,'.',','); ?></div></td>
             </tr>
				<?php
				}
				?>
				<?php
			$totalprivatedoctoramount = 0;
			$totalprivatedoctoramountuhx=0;
			$query62 = "select * from ipprivate_doctor where patientcode='$patientcode' and patientvisitcode='$visitcode' and pvt_flg ='1'";
			$exec62 = mysqli_query($GLOBALS["___mysqli_ston"], $query62) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res62 = mysqli_fetch_array($exec62))
		   {
			$privatedoctordate = $res62['consultationdate'];
			$privatedoctorrefno = $res62['docno'];
			$privatedoctor = $res62['doctorname'];
			$privatedoctorrate = $res62['rate'];
			$privatedoctoramount = $res62['amount'];
			$privatedoctorunit = $res62['units'];
			$description = $res62['remarks'];
			$doccoa = $res62['doccoa'];
			if($description != '')
			{
			$description = '-'.$description;
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
			$privatedoctoramount = $privatedoctorunit*($privatedoctorrate/$fxrate);
			$totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctoramount;
			
			 $privatedoctoramountuhx = $privatedoctorrate*$privatedoctorunit;
		   $totalprivatedoctoramountuhx = $totalprivatedoctoramountuhx + $privatedoctoramountuhx;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $privatedoctordate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $privatedoctorrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $privatedoctor.' '.$description; ?></div></td>
			 		 <input type="hidden" name="privatedoctor[]" id="privatedoctor" value="<?php echo $privatedoctor; ?>">
			 	 <input type="hidden" name="privatedoctorrate[]" id="privatedoctorrate" value="<?php echo $privatedoctorrate/$fxrate; ?>">
			 <input type="hidden" name="privatedoctoramount[]" id="privatedoctoramount" value="<?php echo $privatedoctoramount; ?>">
			 <input type="hidden" name="privatedoctorquantity[]" id="privatedoctorquantity" value="<?php echo $privatedoctorunit; ?>">
			 <input type="hidden" name="doccoa[]" id="doccoa" value="<?php echo $doccoa; ?>">
             
              <input type="hidden" name="privatedoctorrateuhx[]" id="privatedoctorrateuhx" value="<?php echo $privatedoctorrate; ?>">
			 <input type="hidden" name="privatedoctoramountuhx[]" id="privatedoctoramountuhx" value="<?php echo $privatedoctorrate*$privatedoctorunit; ?>">

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $privatedoctorunit; ?></div></td>
             
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($privatedoctorrate/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($privatedoctorunit*($privatedoctorrate/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($privatedoctorrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($privatedoctorrate*$privatedoctorunit),2,'.',','); ?></div></td>
             </tr>
				<?php
				}
				?>
				<?php
			$totalambulanceamount = 0;
			$totalambulanceamountuhx=0;
			$query63 = "select * from ip_ambulance where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec63 = mysqli_query($GLOBALS["___mysqli_ston"], $query63) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res63 = mysqli_fetch_array($exec63))
		   {
			$ambulancedate = $res63['consultationdate'];
			$ambulancerefno = $res63['docno'];
			$ambulance = $res63['description'];
			$ambulancerate = $res63['rate'];
			$ambulanceamount = $res63['amount'];
			$ambulanceunit = $res63['units'];
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
			$ambulanceamount = $ambulanceunit*($ambulancerate/$fxrate);
			$totalambulanceamount = $totalambulanceamount + $ambulanceamount;
			
			 $ambulanceamountuhx = $ambulancerate*$ambulanceunit;
		   $totalambulanceamountuhx = $totalambulanceamountuhx + $ambulanceamountuhx;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambulancedate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambulancerefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $ambulance; ?></div></td>
			 <input type="hidden" name="ambulance[]" id="ambulance" value="<?php echo $ambulance; ?>">
			 	 <input type="hidden" name="ambulancerate[]" id="ambulancerate" value="<?php echo $ambulancerate/$fxrate; ?>">
			 <input type="hidden" name="ambulanceamount[]" id="ambulanceamount" value="<?php echo $ambulanceamount; ?>">
			 <input type="hidden" name="ambulancequantity[]" id="ambulancequantity" value="<?php echo $ambulanceunit; ?>">
	
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambulanceunit; ?></div></td>
             
             	 <input type="hidden" name="ambulancerateuhx[]" id="ambulancerateuhx" value="<?php echo $ambulancerate; ?>">
			 <input type="hidden" name="ambulanceamountuhx[]" id="ambulanceamountuhx" value="<?php echo $ambulancerate*$ambulanceunit; ?>">
             
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($ambulancerate/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($ambulanceunit*($ambulancerate/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($ambulancerate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($ambulancerate*$ambulanceunit),2,'.',','); ?></div></td>
             </tr>
				<?php
				}
				?>
				<?php
			$totalmiscbillingamount = 0;
			$totalmiscbillingamountuhx=0;
			$query69 = "select * from ipmisc_billing where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec69 = mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res69 = mysqli_fetch_array($exec69))
		   {
			$miscbillingdate = $res69['consultationdate'];
			$miscbillingrefno = $res69['docno'];
			$miscbilling = $res69['description'];
			$miscbillingrate = $res69['rate'];
			$miscbillingamount = $res69['amount'];
			$miscbillingunit = $res69['units'];
			
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
			$miscbillingamount = $miscbillingunit*($miscbillingrate/$fxrate);
			$totalmiscbillingamount = $totalmiscbillingamount + $miscbillingamount;
			
			 $miscbillingamountuhx = $miscbillingrate*$miscbillingunit;
		   $totalmiscbillingamountuhx = $totalmiscbillingamountuhx + $miscbillingamountuhx;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $miscbillingdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $miscbillingrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $miscbilling; ?></div></td>
			  <input type="hidden" name="miscbilling[]" id="miscbilling" value="<?php echo $miscbilling; ?>">
			 	 <input type="hidden" name="miscbillingrate[]" id="miscbillingrate" value="<?php echo $miscbillingrate/$fxrate; ?>">
			 <input type="hidden" name="miscbillingamount[]" id="miscbillingamount" value="<?php echo $miscbillingamount; ?>">
			 <input type="hidden" name="miscbillingquantity[]" id="miscbillingquantity" value="<?php echo $miscbillingunit; ?>">
	
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $miscbillingunit; ?></div></td>
             
              <input type="hidden" name="miscbillingrateuhx[]" id="miscbillingrateuhx" value="<?php echo $miscbillingrate; ?>">
			 <input type="hidden" name="miscbillingamountuhx[]" id="miscbillingamountuhx" value="<?php echo $miscbillingrate*$miscbillingunit; ?>">
             
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($miscbillingrate/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($miscbillingunit*($miscbillingrate/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($miscbillingrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($miscbillingrate*$miscbillingunit),2,'.',','); ?></div></td>
             </tr>
				<?php
				}
				?>
				<?php
			$totaldiscountamount = 0;
			$totaldiscountamountuhx=0;
			$query64 = "select * from ip_discount where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec64 = mysqli_query($GLOBALS["___mysqli_ston"], $query64) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res64 = mysqli_fetch_array($exec64))
		   {
			$discountdate = $res64['consultationdate'];
			$discountrefno = $res64['docno'];
			$discount= $res64['description'];
			$discountrate = $res64['rate'];
			$discountrate1 = -$discountrate;
			$discountrate = -$discountrate;
			$authorizedby = $res64['authorizedby'];
			
						
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
			$discountrate = 1*($discountrate1/$fxrate);
			$totaldiscountamount = $totaldiscountamount + $discountrate;
			
			 $discountrateuhx = $discountrate1;
		   $totaldiscountamountuhx = $totaldiscountamountuhx + $discountrateuhx;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $discountdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $discountrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($discountrate1/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format((1*($discountrate1/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($discountrate1),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($discountrate1*1),2,'.',','); ?></div></td>
             </tr>
				<?php
				}
				?>
						<?php
			$totalnhifamount = 0;
			$totalnhifamountuhx=0;
			$query641 = "select * from ip_nhifprocessing where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec641 = mysqli_query($GLOBALS["___mysqli_ston"], $query641) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res641= mysqli_fetch_array($exec641))
		   {
			$nhifdate = $res641['consultationdate'];
			$nhifrefno = $res641['docno'];
			$nhifqty = $res641['totaldays'];
			$nhifrate = $res641['nhifrebate'];
			$nhifclaim = $res641['nhifclaim'];
			$nhifclaim = -$nhifclaim;
			
						
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
			$nhifclaim = $nhifqty*($nhifrate/$fxrate);
			$totalnhifamount = -($totalnhifamount + $nhifclaim);
			
			 $nhifclaimuhx = $nhifrate*$nhifqty;
		   $totalnhifamountuhx = -($totalnhifamountuhx + $nhifclaimuhx);
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"> <?php echo 'NHIF'; ?></div></td>
			 	
			 	 <input type="hidden" name="nhifrate[]" id="nhifrate" value="<?php echo $nhifrate/$fxrate; ?>">
			 <input type="hidden" name="nhifamount[]" id="nhifamount" value="<?php echo $nhifclaim; ?>">
			 <input type="hidden" name="nhifquantity[]" id="nhifquantity" value="<?php echo $nhifqty; ?>">
             
              <input type="hidden" name="nhifrateuhx[]" id="nhifrateuhx" value="<?php echo $nhifrate; ?>">
			 <input type="hidden" name="nhifamountuhx[]" id="nhifamountuhx" value="<?php echo $nhifrate*$nhifqty; ?>">
	
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifqty; ?></div></td>
                 
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($nhifrate/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($nhifqty*($nhifrate/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($nhifrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($nhifrate*$nhifqty),2,'.',','); ?></div></td>
             </tr>
				<?php
				}
				?>
			<?php
			$totaldepositamount = 0;
			$totaldepositamountuhx=0;
			$query112 = "select * from master_transactionipdeposit where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res112 = mysqli_fetch_array($exec112))
			{
			$depositamount = $res112['transactionamount'];
			$depositamount1 = -$depositamount;
			$docno = $res112['docno'];
			$transactionmode = $res112['transactionmode'];
			$transactiondate = $res112['transactiondate'];
			$chequenumber = $res112['chequenumber'];
			
			$query731 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec731 = mysqli_query($GLOBALS["___mysqli_ston"], $query731) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res731 = mysqli_fetch_array($exec731);
			$depositbilltype = $res731['billtype'];
		
			
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
			$depositamount1 = 1*($depositamount/$fxrate);
			$totaldepositamount = $totaldepositamount + $depositamount1;
			
			 $depositamount1uhx = $depositamount;
		   $totaldepositamountuhx = $totaldepositamountuhx + $depositamount1uhx;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $transactiondate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Deposit'; ?>&nbsp;&nbsp;<?php echo $transactionmode; ?>
             
			 <?php
			 if($transactionmode == 'CHEQUE')
			 {
			 echo $chequenumber;
			 }
			 ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo '-'. number_format(($depositamount/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo '-'. number_format((1*($depositamount/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo '-'.  number_format(($depositamount),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo '-'. number_format(($depositamount*1),2,'.',','); ?></div></td>
                  
                  
             <?php }
			 $totaladvancedepositamount = 0;
			$totaladvancedepositamountuhx=0;
			$query112 = "select * from master_transactionadvancedeposit where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res112 = mysqli_fetch_array($exec112))
			{
			$advancedepositamount = $res112['transactionamount'];
			$docno = $res112['docno'];
			$transactiondate = $res112['transactiondate'];
			
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
			$advancedepositamount = 1*($advancedepositamount/$fxrate);
			$totaldepositamount += $advancedepositamount;
			
			 $advancedepositamountuhx = $advancedepositamount;
		   $totaldepositamountuhx = $totaldepositamountuhx + $advancedepositamountuhx;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $transactiondate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Advance Deposit'; ?>
			</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             
              <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($advancedepositamount/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format((1*($advancedepositamount/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($advancedepositamount),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($advancedepositamount*1),2,'.',','); ?></div></td>
                  
             <?php 
			  }
			  ?>
			  		  <?php
			$totaldepositrefundamount = 0;
			$totaldepositrefundamountuhx=0;
			$query112 = "select * from deposit_refund where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res112 = mysqli_fetch_array($exec112))
			{
			$depositrefundamount = $res112['amount'];
			$docno = $res112['docno'];
			$transactiondate = $res112['recorddate'];
			
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
			$depositrefundamount = 1*($depositrefundamount/$fxrate);
			$totaldepositrefundamount = $totaldepositrefundamount + $depositrefundamount;
			
			 $depositrefundamountuhx = $depositrefundamount;
		   $totaldepositrefundamountuhx = $totaldepositrefundamountuhx + $depositrefundamountuhx;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $transactiondate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Deposit Refund'; ?>
			</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($depositrefundamount/$fxrate),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format((1*($depositrefundamount/$fxrate)),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($depositrefundamount),2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format(($depositrefundamount*1),2,'.',','); ?></div></td>
                  
             <?php 
			  }
			  ?>
              
              <!--for package doctor-->
              
              
               <?php /*?><?php
			   if($res2package!=0)
			   {
			$totalprivatedoctorbill = 0;
			$query112 = "select * from privatedoctor_billing where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysql_query($query112) or die(mysql_error());
			while($res112 = mysql_fetch_array($exec112))
			{
			$privatedoctorbill = $res112['amount'];
			$docno = $res112['visitcode'];
			$transactiondate = $res112['recorddate'];
			$doctorname = $res112['description'];
			
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
			$totalprivatedoctorbill = $totalprivatedoctorbill + $privatedoctorbill;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $transactiondate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $doctorname; ?>
			</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($privatedoctorbill,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($privatedoctorbill,2,'.',','); ?></div></td>
			    
			  
			  <?php 
			  }
			  ?>
              <?php
			   
			$totalresidentdoctorbill = 0;
			$query112 = "select * from residentdoctor_billing where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysql_query($query112) or die(mysql_error());
			while($res112 = mysql_fetch_array($exec112))
			{
			$residentdoctorbill = $res112['amount'];
			$docno = $res112['visitcode'];
			$transactiondate = $res112['recorddate'];
			$doctorname = $res112['description'];
			
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
			$totalresidentdoctorbill = $totalresidentdoctorbill + $residentdoctorbill;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $transactiondate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $doctorname; ?>
			</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($residentdoctorbill,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($residentdoctorbill,2,'.',','); ?></div></td>
			    
			  
			  <?php 
			  }}
			  ?><?php */?>
			  <?php 
			 
			  $depositamount = 0;
			  
			  $overalltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totaldiscountamount+$totalmiscbillingamount-$totaldepositamount+$totalnhifamount+$totaldepositrefundamount);
			  $overalltotal=number_format($overalltotal,2,'.','');
			  $totalrevenue = $totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totalmiscbillingamount;
			  $consultationtotal=$totalop;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser;
			   $netpay=number_format($netpay,2,'.','');
			   
			   $totaldepositamount = $totaldepositamount + $totaldepositrefundamount;
			   $positivetotaldiscountamount = -($totaldiscountamount);
			   $positivetotaldepositamount = -($totaldepositamount);
			   $positivetotalnhifamount = -($totalnhifamount);
			   //uhx
			   
			     $overalltotaluhx=($totalopuhx+$totalbedtransferamountuhx+$totalbedallocationamountuhx+$totallabuhx+$totalpharmuhx+$totalraduhx+$totalseruhx+$packageamountuhx+$totalotbillingamountuhx+$totalprivatedoctoramountuhx+$totalambulanceamountuhx+$totaldiscountamountuhx+$totalmiscbillingamountuhx-$totaldepositamountuhx+$totalnhifamountuhx+$totaldepositrefundamountuhx);
			  $overalltotaluhx=number_format($overalltotaluhx,2,'.','');
			  $consultationtotauhxl=$totalopuhx;
			   $consultationtotaluhx=number_format($consultationtotal,2,'.','');
			   $netpayuhx= $consultationtotaluhx+$totallabuhx+$totalpharmuhx+$totalraduhx+$totalseruhx;
			   $netpayuhx=number_format($netpayuhx,2,'.','');
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
                bgcolor="#ecf0f5"><strong>Grand Total</strong></td>
	     <td class="bodytext31" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format(round($overalltotal),2,'.',','); ?></strong></td><input type="hidden" name="grandtotaluhx" id="grandtotaluhx" value="<?php echo round($overalltotaluhx); ?>">
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong>Grand Total</strong></td>
	     <td class="bodytext31" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format(round($overalltotaluhx),2,'.',','); ?></strong></td><input type="hidden" name="grandtotal" id="grandtotal" value="<?php echo round($overalltotal); ?>">
			 </tr>
          </tbody>
        </table>		</td>
	</tr>
	
			<td class="bodytext31" align="center">&nbsp;</td>
			<td class="bodytext31" align="center">&nbsp;</td>
			<td colspan="2">
			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
		  <tr>
			<td width="18%" align="right" class="bodytext31">&nbsp;</td>
			 
	
			<td width="25%" align="center" class="bodytext31">Search Account</td>
		    <td width="9%" align="center" class="bodytext31">Amount</td>
		    <td width="15%" align="center" class="bodytext31"></td>
		  </tr>
			<tr>
			<td align="right" class="bodytext31">&nbsp;</td>
			 <td class="bodytext31" align="center"><input name="accountname" type="text" id="accountname" value="<?php echo $accname;?>" size="32" autocomplete="off" readonly>
			 <input name="accountnameid" type="hidden" id="accountnameid" value="<?php echo $acccode;?>" size="32" autocomplete="off" >
			 <input name="accountnameano" type="hidden" id="accountnameano" value="<?php echo $accanum;?>" size="32" autocomplete="off"></td>
			 <td class="bodytext31" align="right" id="chequenumber"><input type="text" id="amount1" name="amount1" size="10" onKeyUp="return balancecalc('1')" class="number"></td>
			 <td class="bodytext31" align="right">&nbsp;</td>
			 <td width="13%" align="left" class="bodytext31">&nbsp;</td>
	     <td width="11%" align="right" class="bodytext31">Balance</td>
		 <td width="9%" align="right" class="bodytext31"><input type="text" name="balance" id="balance" size="8" class="bal" readonly></td>
			</tr>
			<tr>
			<td class="bodytext31" align="right">&nbsp;</td>
			 <td class="bodytext31" align="center"><input name="accountname2" type="text" id="accountname2" value="" size="32" autocomplete="off"  onkeypress="clearData('2')" onmouseleave="clearData('2')">
			 <input name="accountnameid2" type="hidden" id="accountnameid2" value="" size="32" autocomplete="off">
			 <input name="accountnameano2" type="hidden" id="accountnameano2" value="" size="32" autocomplete="off"></td>
		 <td class="bodytext31" align="right" id="onlinenumber"><input type="text" class="number" id="amount2" name="amount2" size="10" onKeyUp="return balancecalc('2')" readonly></td>
			 <td class="bodytext31" align="center"></td>
				 <td class="bodytext31" align="center">&nbsp;</td>
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td class="bodytext31" align="center">&nbsp;</td>
			</tr>
			<tr>
			<td class="bodytext31" align="right">&nbsp;</td>
			 <td class="bodytext31" align="center"><input name="accountname3" type="text" id="accountname3" value="" size="32" autocomplete="off" onkeypress="clearData('3')" onmouseleave="clearData('3')">
			 <input name="accountnameid3" type="hidden" id="accountnameid3" value="" size="32" autocomplete="off">
			 <input name="accountnameano3" type="hidden" id="accountnameano3" value="" size="32" autocomplete="off"></td>
			 <td class="bodytext31" align="right" id="creditcardnumber"><input type="text" class="number" id="amount3" name="amount3" size="10" onKeyUp="return balancecalc('3')" readonly></td>
			 <td class="bodytext31" align="center"></td>
		 <td class="bodytext31" align="center">&nbsp;</td>
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td class="bodytext31" align="center">&nbsp;</td>
			</tr>
			
			<tr>
			<td class="bodytext31" align="right">&nbsp;</td>
			 <td class="bodytext31" align="center"><input name="accountname4" type="text" id="accountname4" value="<?php echo $nhifledger_name;?>" size="32" autocomplete="off" readonly >
			 <input name="accountnameid4" type="hidden" id="accountnameid4" value="<?php echo $nhifledger_id;?>" size="32" autocomplete="off">
			 <input name="accountnameano4" type="hidden" id="accountnameano4" value="<?php echo $nhifledger_autoid;?>" size="32" autocomplete="off">
			 <td class="bodytext31" align="right" id=""><input type="text" id="amount4" name="amount4" size="10" onKeyUp="return balancecalc('4')"  class="number"></td>
			 <td class="bodytext31" align="center"></td>
		 <td class="bodytext31" align="center">&nbsp;</td>
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td class="bodytext31" align="center">&nbsp;</td>
			</tr>
			<tr>
			<td class="bodytext31" align="right">&nbsp;</td>
			 <td class="bodytext31" align="center"></td>
			 <td class="bodytext31" align="right" id="mpesanumber">&nbsp;</td>
			 <td class="bodytext31" align="center"></td>
		 <td class="bodytext31" align="center">&nbsp;</td>
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td class="bodytext31" align="center">&nbsp;</td>
			</tr>
			</tbody>
			</table>			</td>
			</tr>
	  <tr>
        <td>&nbsp;</td>
		 <td>&nbsp;</td>
		  <td width="10%" class="bodytext31" align="left">Approval Comments</td>
		  <td width="50%" class="bodytext31" align="left"><textarea name="approvalcomments" id="approvalcomments"></textarea></td>
	    <td width="1%">&nbsp;</td>
		<td width="1%">&nbsp;</td>
		<td width="31%" align="center" valign="center" class="bodytext311">&nbsp; </td>
      </tr>
	  <tr>
        <td>&nbsp;</td>
		 <td>&nbsp;</td>
		  <td colspan="2"></td>
		<td width="1%">&nbsp;</td>
		<td width="15%"><b><span id="smart_text" style="color:red;FONT-SIZE:19px"></span></b></td>
		<td width="31%" align="center" valign="center" class="bodytext311">         
         <input type="hidden" name="frm1submit1" value="frm1submit1" />
		<input name="Submit222" type="submit" value="Save Bill" class="button" style="border: 1px solid #001E6A"/>
	
		</td>
      </tr>
    </table>
  </table>
</form>
<script>
$('input.number').keyup(function(event) {
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


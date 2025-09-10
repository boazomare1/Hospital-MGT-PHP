<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$updatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
 $total = "0.00";
$query_acc = "SELECT * FROM finance_ledger_mapping WHERE map_anum = '20' AND record_status <> 'deleted'";
$exec_acc = mysqli_query($GLOBALS["___mysqli_ston"], $query_acc) or die ("Error in Query_acc".mysqli_error($GLOBALS["___mysqli_ston"]));
$ledgername = '';
$res_acc = mysqli_fetch_array($exec_acc);

$accountcode1 = $res_acc['ledger_id'];
$accountname1 = trim($res_acc['ledger_name']);

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $transactiondatefrom; }

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $transactiondateto; }
if (isset($_REQUEST["searchaccoutname"])) { $searchaccoutname = $_REQUEST["searchaccoutname"]; } else { $searchaccoutname = ""; }
if (isset($_REQUEST["searchaccoutnameanum"])) { $searchaccoutnameanum = $_REQUEST["searchaccoutnameanum"]; } else { $searchaccoutnameanum = ""; }

 
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_accounts.php");
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 $locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 	$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res12 = mysqli_fetch_array($exec12);
						
						 $locationname1 = $res12["locationname"];

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];



if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}

if (isset($_REQUEST["searchsuppliername1"])) { $searchsuppliername = $_REQUEST["searchsuppliername1"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchsubtypeanum1"])) { $searchsubtypeanum1 = $_REQUEST["searchsubtypeanum1"]; } else { $searchsubtypeanum1 = ""; }
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

if($frmflag2=='frmflag2')
{
		$locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
		$locationcodeget=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';
		
 $query77 = "select * from completed_billingpaylater order by auto_number desc";
$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
$res77 = mysqli_fetch_array($exec77);
 $batch = $res77['batch'];
$suffix='CBL-';
if($batch == '')
{
	$batchnumber =$suffix. '1'; 
}
else
{	
		$splitbat=explode('-', $batch);
	//echo $batchno=substr($batch,0,4); 
		$batchno1=$splitbat[1]+1;
	$batchnumber = $suffix.$batchno1;  
}

	$printno = $_REQUEST['printno'];
	
	
	
		foreach($_POST['comcheck'] as $key)
	{
		
	 	$patientcode = $_REQUEST['patientcode'.$key];
		$patientname = $_REQUEST['patientname'.$key];
		$visitcode = $_REQUEST['visitcode'.$key];
		$billno = $_REQUEST['billno'.$key];
		$billdate = $_REQUEST['billdate'.$key];
		$amount = $_REQUEST['amount'.$key];
		$accountname = $_REQUEST['accountname'.$key];
		$subtype = $_REQUEST['subtype'.$key];
		
		$locationnameinsert = $_REQUEST['locationnameget'.$key];
		$locationcodeinsert = $_REQUEST['locationcodeget'.$key];
		
		$billno = $_REQUEST['billno'.$key];
		
		$completed = 'completed';
		
		
		
		 $query7 = "insert into completed_billingpaylater(printno, patientcode, patientname, visitcode, billno, billdate,totalamount,  completed, batch, ipaddress, username, subtype, accountname,locationname,locationcode)
		values('$printno', '$patientcode', '$patientname', '$visitcode', '$billno', '$billdate', '$amount', '$completed', '$batchnumber', '$ipaddress', '$username', '$subtype', '$accountname','".$locationnameinsert."','".$locationcodeinsert."')"; 
		$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query5 = "UPDATE billing_paylater SET completed = 'completed',missing='',incomplete='' WHERE billno = '".$billno."'";
		$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

		if(isset($_REQUEST['isnhif'.$key]) && $_REQUEST['isnhif'.$key]==1)
			$query51 = "UPDATE billing_ipnhif SET completed = 'completed',missing='',incomplete='' WHERE docno = '".$billno."'";
		else		
		    $query51 = "UPDATE billing_ip SET completed = 'completed',missing='',incomplete='' WHERE billno = '".$billno."'";

		$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die ("Error in Query51".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query52 = "UPDATE billing_ipcreditapprovedtransaction SET completed = 'completed',missing='',incomplete='' WHERE billno = '".$billno."' and accountname = '$accountname'";
		$exec52 = mysqli_query($GLOBALS["___mysqli_ston"], $query52) or die ("Error in Query52".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	
		foreach($_POST['misscheck'] as $key)
	 {
		$billno = $_REQUEST['billno'.$key];
			$patientcode = $_REQUEST['patientcode'.$key];
		$patientname = $_REQUEST['patientname'.$key];
		$visitcode = $_REQUEST['visitcode'.$key];
		$billno = $_REQUEST['billno'.$key];
		$billdate = $_REQUEST['billdate'.$key];
		$amount = $_REQUEST['amount'.$key];
		$accountname = $_REQUEST['accountname'.$key];
		
		$locationnameinsert = $_REQUEST['locationnameget'.$key];
		$locationcodeinsert = $_REQUEST['locationcodeget'.$key];
		
		 /*$query8 = "insert into completed_billingpaylater(printno, patientcode, patientname, visitcode, billno, billdate,totalamount, missing,  batch, ipaddress, username, subtype, accountname,locationname,locationcode)
		values('$printno', '$patientcode', '$patientname', '$visitcode', '$billno', '$billdate', '$amount', 'missing', '$batchnumber', '$ipaddress', '$username', '$subtype', '$accountname','".$locationnameinsert."','".$locationcodeinsert."')"; 
		$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error()); */

		$query6 = "UPDATE print_deliverysubtype SET status = 'deleted'  WHERE billno = '".$billno."'";
		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query6 = "UPDATE billing_paylater SET missing = 'missing',completed='',incomplete='' WHERE billno = '".$billno."'";
		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		if(isset($_REQUEST['isnhif'.$key]) && $_REQUEST['isnhif'.$key]==1)
			$query61 = "UPDATE billing_ipnhif SET completed = '',missing='missing',incomplete='' WHERE docno = '".$billno."'";
		else	
		  $query61 = "UPDATE billing_ip SET  missing = 'missing',completed='',incomplete='' WHERE billno = '".$billno."'";

		$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query61".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query62 = "UPDATE billing_ipcreditapprovedtransaction SET  missing = 'missing',completed='',incomplete='' WHERE billno = '".$billno."' and accountname = '$accountname'";
		$exec62 = mysqli_query($GLOBALS["___mysqli_ston"], $query62) or die ("Error in Query62".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		
		}
	 foreach($_POST['incomcheck'] as $key)
	 {
		$billno = $_REQUEST['billno'.$key];
			$patientcode = $_REQUEST['patientcode'.$key];
		$patientname = $_REQUEST['patientname'.$key];
		$visitcode = $_REQUEST['visitcode'.$key];
		$billno = $_REQUEST['billno'.$key];
		$billdate = $_REQUEST['billdate'.$key];
		$amount = $_REQUEST['amount'.$key];
		$accountname = $_REQUEST['accountname'.$key];
		
		$locationnameinsert = $_REQUEST['locationnameget'.$key];
		$locationcodeinsert = $_REQUEST['locationcodeget'.$key];
		
		/* $query9 = "insert into completed_billingpaylater(printno, patientcode, patientname, visitcode, billno, billdate,totalamount,  incomplete, batch, ipaddress, username, subtype, accountname,locationname,locationcode)
		values('$printno', '$patientcode', '$patientname', '$visitcode', '$billno', '$billdate', '$amount','incomplete',  '$batchnumber', '$ipaddress', '$username', '$subtype', '$accountname','".$locationnameinsert."','".$locationcodeinsert."')"; 
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error()); */

		$query6 = "UPDATE print_deliverysubtype SET status = 'deleted'  WHERE billno = '".$billno."'";
		$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query7 = "UPDATE billing_paylater SET incomplete = 'incomplete',completed='',missing='' WHERE billno = '".$billno."'";
		$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		if(isset($_REQUEST['isnhif'.$key]) && $_REQUEST['isnhif'.$key]==1)
			$query71 = "UPDATE billing_ipnhif SET completed = '',missing='',incomplete='incomplete' WHERE docno = '".$billno."'";
		else
		   $query71 = "UPDATE billing_ip SET incomplete = 'incomplete',completed='',missing='' WHERE billno = '".$billno."'";

		$exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die ("Error in Query71".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query72 = "UPDATE billing_ipcreditapprovedtransaction SET incomplete = 'incomplete',completed='',missing='' WHERE billno = '".$billno."'  and accountname = '$accountname'";
		$exec72 = mysqli_query($GLOBALS["___mysqli_ston"], $query72) or die ("Error in Query72".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	
		$frmflag2='';
		
		header("location:deliveryreportsubtypeprint.php?st=printsuccess&&printno=$printno");
	}
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $transactiondatefrom; }

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $transactiondateto; }




$query7 = "select * from completed_billingpaylater order by auto_number desc";
$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));
$res7 = mysqli_fetch_array($exec7);
$printno = $res7['printno'];
if($printno == '')
{
	$printnumber = '1';
}
else
{
	$printnumber = $printno + 1;
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if (isset($_REQUEST["printno"])) { $printno = $_REQUEST["printno"]; } else { $printno = ""; }
if($st == 'printsuccess')
{
?>
<script>
window.open("print_deliveryreportsubtype2.php?printno=<?php echo $printno; ?>");
window.open("print_deliveryreportsubtype2xl.php?printno=<?php echo $printno; ?>");
</script>
<?php
}
?>

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma;}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<link href="autocomplete.css" rel="stylesheet">

<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/datetimepicker_css.js"></script>

<script>

$(function() {
	
$('#searchaccoutname').autocomplete({
		
	source:'ajaxaccountnewsearching.php?data_from=account', 
	minLength:1,
	delay: 0,
	html: true, 
		select: function(event,ui){
			
			var searchaccoutname = ui.item.auto_number;
			var accountname = ui.item.accountname;
			$('#searchaccoutname').val(accountname);
			$('#searchaccoutnameanum').val(searchaccoutname);
			
			},
    });


$('#searchsuppliername1').autocomplete({
		
	source:'ajaxaccountnewsearching.php?data_from=subtype', 
	minLength:1,
	delay: 0,
	html: true, 
		select: function(event,ui){
			
			var searchaccoutname = ui.item.auto_number;
			var accountname = ui.item.accountname;
			$('#searchsuppliername1').val(accountname);
			$('#searchsubtypeanum1').val(searchaccoutname);
			
			},
    });

	
});
</script>

<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>

<script type="text/javascript">
function clickcheck(cat,val)
{
	//alert(cat);
	//alert(val);
	if(cat=='com')
	{
		document.getElementById("misscheck"+val).checked=false;
		document.getElementById("incomcheck"+val).checked=false;
		}
	else if(cat=='incom')
	{
		document.getElementById("comcheck"+val).checked=false;
		document.getElementById("misscheck"+val).checked=false;
		}
	else 
	{
		document.getElementById("comcheck"+val).checked=false;
		document.getElementById("incomcheck"+val).checked=false;
		}
	}

function ajaxlocationfunction(val)
{ 
if (window.XMLHttpRequest)
					  {// code for IE7+, Firefox, Chrome, Opera, Safari
					  xmlhttp=new XMLHttpRequest();
					  }
					else
					  {// code for IE6, IE5
					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					  }
					xmlhttp.onreadystatechange=function()
					  {
					  if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;
						}
					  }
					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);
					xmlhttp.send();
}
					
//ajax to get location which is selected ends here


window.onload = function () 
{
	//var oTextbox = new AutoSuggestControl1(document.getElementById("searchsuppliername1"), new StateSuggestions1());
	
}
</script>
<script>
function funcAccount1()
{

if((document.getElementById("searchsubtypeanum1").value == "" || document.getElementById("searchsuppliername1").value == ""))
{
alert ('Please Select Sub type ');
document.getElementById("searchsuppliername1").focus();
return false;
}
}
</script>
<script language="javascript">

function cbsuppliername1()
{
	document.cbform1.submit();
}
function validcheck()
{

if(confirm("Do You Want To Save The Record?")==false){
	return false;
}	
return true;

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
.ui-menu .ui-menu-item{ zoom:1 !important; }

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma;}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
</style>



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
		
		
              <form name="cbform1" method="post" action="deliveryreportsubtypeprint-test.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Dispatch Report Subtype</strong></td>
              <td colspan="2" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
						
						if ($location!='')
						{
						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res12 = mysqli_fetch_array($exec12);
						
						echo $res1location = $res12["locationname"];
						//echo $location;
						}
						else
						{
						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						//$res1locationanum = $res1["locationcode"];
						}
						
						

						?>
						
						
                  
                  </td> 
              </tr>
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Subtype</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <span class="bodytext32">
                <input name="searchsuppliername1" type="text" id="searchsuppliername1" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
                </span>
                <input name="searchaccoutnameanum" id="searchaccoutnameanum" value="<?php echo $searchaccoutnameanum; ?>" type="hidden">
				<input name="searchsubtypeanum1" id="searchsubtypeanum1" value="<?php echo $searchsubtypeanum1; ?>" type="hidden">
              </span></td>
           </tr>

           <!-- <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Account </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <span class="bodytext32">
                <input name="searchaccoutname" type="text" id="searchaccoutname" value="<?php echo $searchaccoutname; ?>" size="50" autocomplete="off" >
                </span>
                <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
			  <input name="searchsubtypeanum1" id="searchsubtypeanum1" value="<?php echo $searchsubtypeanum1; ?>" type="hidden">
              </span></td>
           </tr>-->
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $ADate1; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $ADate2; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
						<tr>
  			  <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			 
				 <select name="location" id="location" onChange="ajaxlocationfunction(this.value);">
                    <?php
						
						$query1 = "select * from login_locationdetails where   username='$username' and docno='$docno' order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$loccode=array();
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$locationname = $res1["locationname"];
						$locationcode = $res1["locationcode"];
						
						?>
						 <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>
						<?php
						} 
						?>
                      </select>
					 
              </span></td>
			   <td width="10%" align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
			  </tr>
					
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" onClick="return funcAccount1()" value="Search" name="Submit" />
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
        <td>
		<form method="post" name="form4" action="deliveryreportsubtypeprint.php">
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1032" 
            align="left" border="0">
          <tbody>
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
		    if ($cbfrmflag1 == 'cbfrmflag1')
			{
			
			?>
			<tr>
                <td class="bodytext31" valign="center"  align="left" colspan="2"> 
                 	<a href="xl_deliveryreportsubtype.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&subtype=<?php echo $searchsuppliername; ?>&&accountname=<?php echo $searchaccoutnameanum; ?>&&cbfrmflag1=<?php echo $cbfrmflag1; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a>
                </td>
          	</tr>
			<tr>
              <td colspan="8" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo $searchsuppliername; ?></strong></td>
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311"></span></td>
               <!--<td align="left" valign="top"  class="bodytext3">
						  <div align="left">
						  <a href="print_deliverreportsubtype.php?searchsuppliername=<?=$searchsuppliername?>&&ADate1=<?=$ADate1?>&&ADate2=<?=$ADate2?>" class="bodytext3"><img src="images/excel-xls-icon.png" width="30" height="30"></a></div></td>-->
            </tr>
		    <tr>
              <td colspan="6" bgcolor="#00CCFF" class="bodytext31"><strong><?php echo 'Completed Invoice'; ?></strong></td>
              <td colspan="4" bgcolor="#00CCFF" class="bodytext31"><span class="bodytext311"></span></td>
            </tr>
            <tr>
				<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
                <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Dispatch</strong></td>
                <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Missing Forms</strong></td>
                <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Incomplete Invoice</strong></td>
                <td width="16%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Account Name</strong></td>
              <td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg No</strong></div></td>
              <td width="11%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Patient </strong></td>
              <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Bill No </strong></td>
              <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill Date </strong></div></td>
              <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
              <td width="3%" align="left" valign="center"  
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              </tr>
			<?php
			$total = '0.00';
			$snocount = '';
			 $searchsuppliername;
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
		    if ($cbfrmflag1 == 'cbfrmflag1')
			{ 
			
			  if($searchsuppliername!='')
			      $query25 = "select auto_number,subtype from master_subtype where  subtype = '$searchsuppliername'";
				else
					$query25 = "select auto_number,subtype from master_subtype ";

			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res25 = mysqli_fetch_array($exec25)) {

			$searchsubtypeanum1 = $res25['auto_number'];
			$searchsuppliername = $res25['subtype'];
			//echo $searchsuppliername;
			$searchsuppliername=trim($searchsuppliername);
			$query21 = "select accountname from master_accountname where  subtype = '$searchsubtypeanum1'  and recordstatus <> 'DELETED' order by subtype desc";	
			
			if($searchaccoutname!=''){

				 $query21 = "select accountname from master_accountname where  auto_number = '$searchaccoutnameanum'  and recordstatus <> 'DELETED'";			
			}

			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			while ($res21 = mysqli_fetch_array($exec21))
			{

			 $res21accountname = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], trim($res21['accountname']));
			
			
			$query24 = "select accountname from print_deliverysubtype where  trim(accountname) = '$res21accountname' and subtype = '$searchsuppliername' and date(updatedatetime) between '$ADate1' and '$ADate2' and status <> 'deleted' group by accountname";

			if($searchsuppliername==''){
				$query6 = "select accountname from print_deliverysubtype where  trim(accountname) = '$res21accountname' and date(updatedatetime) between '$ADate1' and '$ADate2' and status <> 'deleted' group by accountname";
			}

			$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));
		    $res24 = mysqli_fetch_array($exec24);
			$res24accountname = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], trim($res24['accountname']));

			if($res24accountname != '')
			{
			?>
			<?php
			
			$query6 = "select billno,locationname,locationcode,isnhif from print_deliverysubtype where  trim(accountname) = '$res21accountname' and subtype = '$searchsuppliername' and date(updatedatetime) between '$ADate1' and '$ADate2' and status <> 'deleted'";

			if($searchsuppliername==''){
				$query6 = "select billno,locationname,locationcode,isnhif from print_deliverysubtype where  trim(accountname) = '$res21accountname' and date(updatedatetime) between '$ADate1' and '$ADate2' and status <> 'deleted'";
			}
		    //echo $query6;
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			
		 while ($res6 = mysqli_fetch_array($exec6))
		 {
			
		  $billno = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], trim($res6['billno']));
		  $isnhif=$res6['isnhif'];
			
			
		  $query2 = "select * from billing_paylater where  billno = '$billno' and completed <> 'completed' and (missing ='' OR missing ='missing' OR incomplete='incomplete' )  order by accountname, billdate desc"; 
		  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res2 = mysqli_fetch_array($exec2))
		  {
     	  $res2accountname = $res2['accountname'];
		  $res2patientcode = $res2['patientcode'];
		  $res2visitcode = $res2['visitcode'];
		  $res2billno = $res2['billno'];
          $res2totalamount = $res2['totalamount'];
		  $res2billdate = $res2['billdate'];
		  $res2subtype = $res2['subtype'];
		  $res2patientname = $res2['patientname'] ;
		  $res2accountname = $res2['accountname'];
		  
		 
			
		   $res6billnumber = $res6['billno'];
		   $locationnameget = $res6['locationname'];
		   $locationcodeget = $res6['locationcode'];

		   $total = $total + $res2totalamount;
		  
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
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
			  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><input type="checkbox" name="comcheck[]" id="comcheck<?php echo $snocount;?>" value="<?php echo $snocount;?>" onClick="clickcheck('com',<?php echo $snocount;?>)" checked>
               <input type="hidden" name="billno<?php echo $snocount; ?>" value="<?php echo $res6billnumber;?>">
               <input type="hidden" name="locationcodeget<?php echo $snocount; ?>" value="<?php echo $locationcodeget;?>">
               <input type="hidden" name="locationnameget<?php echo $snocount; ?>" value="<?php echo $locationnameget;?>">
               </td>
                <td class="bodytext31" valign="center"  align="left"><input type="checkbox" name="misscheck[]" id="misscheck<?php echo $snocount;?>" value="<?php echo $snocount;?>" onClick="clickcheck('miss',<?php echo $snocount;?>)">
               
                </td>
                 <td class="bodytext31" valign="center"  align="left"><input type="checkbox" name="incomcheck[]" id="incomcheck<?php echo $snocount;?>" value="<?php echo $snocount;?>" onClick="clickcheck('incom',<?php echo $snocount;?>)">
               
                </td>
                 <td class="bodytext31" valign="center"  align="left"><?php echo $res2accountname; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
				<input type="hidden" name="patientcode<?php echo $snocount; ?>" id="patientcode" value="<?php echo $res2patientcode; ?>"> <?php echo $res2patientcode; ?></div>
                <input type="hidden" name="subtype<?php echo $snocount; ?>" id="subtype" value="<?php echo $res2subtype; ?>">
				</td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
                <input type="hidden" name="visitcode<?php echo $snocount; ?>" id="visitcode" value="<?php echo $res2visitcode; ?>">
				<input type="hidden" name="patientname<?php echo $snocount; ?>" id="patientname" value="<?php echo $res2patientname; ?>">
				<?php echo $res2patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <input type="hidden" name="billno<?php echo $snocount; ?>" id="billno" value="<?php echo $res2billno; ?>">
			  <?php echo $res2billno; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
				<input type="hidden" name="billdate<?php echo $snocount; ?>" id="billdate" value="<?php echo $res2billdate; ?>">
				<?php echo $res2billdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right">
			  <input type="hidden" name="accountname<?php echo $snocount; ?>" id="accountname" value="<?php echo $res2accountname; ?>">
			  <input type="hidden" name="amount<?php echo $snocount; ?>" id="amount" value="<?php echo $res2totalamount; ?>">
			  <?php echo number_format($res2totalamount,2,'.',','); ?></div></td>
              <td bgcolor="#ecf0f5"class="bodytext31" valign="center"  align="left">&nbsp;</td>
              </tr>
			<?php
			}
		  
		  if($isnhif==1)
		  {
			  $query3 = "select * from billing_ipnhif where  docno = '$billno' and completed <> 'completed' and (missing ='' OR missing ='missing' OR incomplete='incomplete' ) order by recorddate desc"; 
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while ($res3 = mysqli_fetch_array($exec3))
			  {
			  $res3accountname = $accountname1;
			  $res3patientcode = $res3['patientcode'];
			  $res3visitcode = $res3['visitcode'];
			  $res3billno = $res3['docno'];
			  $res3subtype = 'NATIONAL HOSPITAL INSURANCE FUND-NHIF';
			  $res3totalamount = $res3['finamount'];
			  $res3billdate = $res3['recorddate'];
			  $res3patientname = $res3['patientname'];
			  $res6billnumber = $res6['billno'];
			  
			  
			   $locationnameget1 = $res6['locationname'];
			   $locationcodeget1 = $res6['locationcode'];
			  $total = $total + $res3totalamount;
			  
			  $snocount = $snocount + 1;
				
				//echo $cashamount;
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
			  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><input type="checkbox" name="comcheck[]" id="comcheck<?php echo $snocount;?>" value="<?php echo $snocount;?>" onClick="clickcheck('com',<?php echo $snocount;?>)" checked>
               <input type="hidden" name="billno<?php echo $snocount; ?>" value="<?php echo $res6billnumber;?>">
               <input type="hidden" name="locationcodeget<?php echo $snocount; ?>" value="<?php echo $locationcodeget1;?>">
               <input type="hidden" name="locationnameget<?php echo $snocount; ?>" value="<?php echo $locationnameget1;?>">
               </td>
                <td class="bodytext31" valign="center"  align="left"><input type="checkbox" name="misscheck[]" id="misscheck<?php echo $snocount;?>" value="<?php echo $snocount;?>" onClick="clickcheck('miss',<?php echo $snocount;?>)">
               
                </td>
                 <td class="bodytext31" valign="center"  align="left"><input type="checkbox" name="incomcheck[]" id="incomcheck<?php echo $snocount;?>" value="<?php echo $snocount;?>" onClick="clickcheck('incom',<?php echo $snocount;?>)">
               
                </td>
                 <td class="bodytext31" valign="center"  align="left"><?php echo $res3accountname; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
				<input type="hidden" name="patientcode<?php echo $snocount; ?>" id="patientcode<?php echo $snocount; ?>" value="<?php echo $res3patientcode; ?>">
				<?php echo $res3patientcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
                 <input type="hidden" name="subtype<?php echo $snocount; ?>" id="subtype" value="<?php echo $res3subtype; ?>">
				<input type="hidden" name="patientname<?php echo $snocount; ?>" id="patientname<?php echo $snocount; ?>" value="<?php echo $res3patientname; ?>">
				<?php echo $res3patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
              <input type="hidden" name="visitcode<?php echo $snocount; ?>" id="visitcode<?php echo $snocount; ?>" value="<?php echo $res3visitcode; ?>">
			  <input type="hidden" name="billno<?php echo $snocount; ?>" id="billno<?php echo $snocount; ?>" value="<?php echo $res3billno; ?>">
			  <?php echo $res3billno; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
				<input type="hidden" name="billdate<?php echo $snocount; ?>" id="billdate<?php echo $snocount; ?>" value="<?php echo $res3billdate; ?>">
				<?php echo $res3billdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right">
			  <input type="hidden" name="accountname<?php echo $snocount; ?>" id="accountname<?php echo $snocount; ?>" value="<?php echo $res3accountname; ?>">
			  <input type="hidden" name="amount<?php echo $snocount; ?>" id="amount<?php echo $snocount; ?>" value="<?php echo $res3totalamount; ?>">
			  <input type="hidden" name="isnhif<?php echo $snocount; ?>" id="isnhif<?php echo $snocount; ?>" value="1">

			  <?php echo number_format($res3totalamount,2,'.',','); ?></div></td>
              <td bgcolor="#ecf0f5"class="bodytext31" valign="center"  align="left">&nbsp;</td>
              </tr>
			<?php
			  }

		  }
		  else{
		  $query3 = "select * from billing_ip where  billno = '$billno' and completed <> 'completed' and (missing ='' OR missing ='missing' OR incomplete='incomplete' ) order by accountname, billdate desc"; 
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res3 = mysqli_fetch_array($exec3))
		  {
     	  $res3accountname = $res3['accountname'];
		  $res3patientcode = $res3['patientcode'];
		  $res3visitcode = $res3['visitcode'];
		  $res3billno = $res3['billno'];
		  $res3subtype = $res3['subtype'];
          $res3totalamount = $res3['totalamount'];
		  $res3billdate = $res3['billdate'];
		  $res3patientname = $res3['patientname'];
		  $res6billnumber = $res6['billno'];
		  
		  
		   $locationnameget1 = $res6['locationname'];
		   $locationcodeget1 = $res6['locationcode'];
		  $total = $total + $res3totalamount;
		  
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
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
			  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><input type="checkbox" name="comcheck[]" id="comcheck<?php echo $snocount;?>" value="<?php echo $snocount;?>" onClick="clickcheck('com',<?php echo $snocount;?>)" checked>
               <input type="hidden" name="billno<?php echo $snocount; ?>" value="<?php echo $res6billnumber;?>">
               <input type="hidden" name="locationcodeget<?php echo $snocount; ?>" value="<?php echo $locationcodeget1;?>">
               <input type="hidden" name="locationnameget<?php echo $snocount; ?>" value="<?php echo $locationnameget1;?>">
               </td>
                <td class="bodytext31" valign="center"  align="left"><input type="checkbox" name="misscheck[]" id="misscheck<?php echo $snocount;?>" value="<?php echo $snocount;?>" onClick="clickcheck('miss',<?php echo $snocount;?>)">
               
                </td>
                 <td class="bodytext31" valign="center"  align="left"><input type="checkbox" name="incomcheck[]" id="incomcheck<?php echo $snocount;?>" value="<?php echo $snocount;?>" onClick="clickcheck('incom',<?php echo $snocount;?>)">
               
                </td>
                 <td class="bodytext31" valign="center"  align="left"><?php echo $res3accountname; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
				<input type="hidden" name="patientcode<?php echo $snocount; ?>" id="patientcode<?php echo $snocount; ?>" value="<?php echo $res3patientcode; ?>">
				<?php echo $res3patientcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
                 <input type="hidden" name="subtype<?php echo $snocount; ?>" id="subtype" value="<?php echo $res3subtype; ?>">
				<input type="hidden" name="patientname<?php echo $snocount; ?>" id="patientname<?php echo $snocount; ?>" value="<?php echo $res3patientname; ?>">
				<?php echo $res3patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
              <input type="hidden" name="visitcode<?php echo $snocount; ?>" id="visitcode<?php echo $snocount; ?>" value="<?php echo $res3visitcode; ?>">
			  <input type="hidden" name="billno<?php echo $snocount; ?>" id="billno<?php echo $snocount; ?>" value="<?php echo $res3billno; ?>">
			  <?php echo $res3billno; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
				<input type="hidden" name="billdate<?php echo $snocount; ?>" id="billdate<?php echo $snocount; ?>" value="<?php echo $res3billdate; ?>">
				<?php echo $res3billdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right">
			  <input type="hidden" name="accountname<?php echo $snocount; ?>" id="accountname<?php echo $snocount; ?>" value="<?php echo $res3accountname; ?>">
			  <input type="hidden" name="amount<?php echo $snocount; ?>" id="amount<?php echo $snocount; ?>" value="<?php echo $res3totalamount; ?>">
			  <?php echo number_format($res3totalamount,2,'.',','); ?></div></td>
              <td bgcolor="#ecf0f5"class="bodytext31" valign="center"  align="left">&nbsp;</td>
              </tr>
			<?php
			}
		  }
			
			
			 $query3 = "select * from billing_ipcreditapprovedtransaction where  billno = '$billno'  and completed <> 'completed' and ( missing ='' OR missing ='missing' OR incomplete='incomplete') order by accountname, billdate desc"; 
		  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
		  while ($res3 = mysqli_fetch_array($exec3))
		  {
     	  $res3accountname = $res3['accountname'];
		  $res3patientcode = $res3['patientcode'];
		  $res3visitcode = $res3['visitcode'];
		  $res3billno = $res3['billno'];
		   $res3subtype = $res3['subtype'];
          $res3totalamount = $res3['totalamount'];
		  $res3billdate = $res3['billdate'];
		  $res3patientname = $res3['patientname'];

		 
			
		  $res6billnumber = $res6['billno'];
		  
		  
		   $locationnameget2 = $res6['locationname'];
		   $locationcodeget2 = $res6['locationcode'];
		  $total = $total + $res3totalamount;
		  
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
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
			  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><input type="checkbox" name="comcheck[]" id="comcheck<?php echo $snocount;?>" value="<?php echo $snocount;?>" onClick="clickcheck('com',<?php echo $snocount;?>)" checked>
               <input type="hidden" name="billno<?php echo $snocount; ?>" value="<?php echo $res6billnumber;?>">
               <input type="hidden" name="locationcodeget<?php echo $snocount; ?>" value="<?php echo $locationcodeget2;?>">
               <input type="hidden" name="locationnameget<?php echo $snocount; ?>" value="<?php echo $locationnameget2;?>">
               </td>
                <td class="bodytext31" valign="center"  align="left"><input type="checkbox" name="misscheck[]" id="misscheck<?php echo $snocount;?>" value="<?php echo $snocount;?>" onClick="clickcheck('miss',<?php echo $snocount;?>)">
               
                </td>
                 <td class="bodytext31" valign="center"  align="left"><input type="checkbox" name="incomcheck[]" id="incomcheck<?php echo $snocount;?>" value="<?php echo $snocount;?>" onClick="clickcheck('incom',<?php echo $snocount;?>)">
               
                </td>
                 <td class="bodytext31" valign="center"  align="left"><?php echo $res3accountname; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
				<input type="hidden" name="patientcode<?php echo $snocount; ?>" id="patientcode<?php echo $snocount; ?>" value="<?php echo $res3patientcode; ?>">
				<?php echo $res3patientcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
				<input type="hidden" name="patientname<?php echo $snocount; ?>" id="patientname<?php echo $snocount; ?>" value="<?php echo $res3patientname; ?>">
				<?php echo $res3patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
              <input type="hidden" name="subtype<?php echo $snocount; ?>" id="subtype" value="<?php echo $res3subtype; ?>">
              <input type="hidden" name="visitcode<?php echo $snocount; ?>" id="visitcode<?php echo $snocount; ?>" value="<?php echo $res3visitcode; ?>">
			  <input type="hidden" name="billno<?php echo $snocount; ?>" id="billno<?php echo $snocount; ?>" value="<?php echo $res3billno; ?>">
			  <?php echo $res3billno; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
				<input type="hidden" name="billdate<?php echo $snocount; ?>" id="billdate<?php echo $snocount; ?>" value="<?php echo $res3billdate; ?>">
				<?php echo $res3billdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="right">
			  <input type="hidden" name="accountname<?php echo $snocount; ?>" id="accountname<?php echo $snocount; ?>" value="<?php echo $res3accountname; ?>">
			  <input type="hidden" name="amount<?php echo $snocount; ?>" id="amount<?php echo $snocount; ?>" value="<?php echo $res3totalamount; ?>">
			  <?php echo number_format($res3totalamount,2,'.',','); ?></div></td>
              <td bgcolor="#ecf0f5"class="bodytext31" valign="center"  align="left">&nbsp;</td>
              </tr>
			<?php
			}
			}
			}
			}
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
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong>Total:</strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($total,2,'.',','); ?></strong></div></td>
              <td rowspan="2" align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
			  <?php if($total != 0.00) { ?>	
              <?php } ?>
			</tr>
						
			<tr>
              <td colspan="8" class="bodytext31" valign="center"  align="left">
               <input type="hidden" name="locationnameget" value="<?php echo $locationname1;?>" >
               <input type="hidden" name="locationcodeget" value="<?php echo $locationcode1;?>" >
			  <input type="hidden" name="subtype" id="subtype" value="<?php echo $searchsuppliername; ?>">
			  <input type="hidden" name="printno" id="printno" value="<?php echo $printnumber; ?>">
			  <input type="hidden" name="frmflag2" id="frmflag2" value="frmflag2">
              <input type="submit" value="Submit" onclick='return validcheck();'>
			  </td>
			</tr>
			<?php
			}
			}
			?>
          </tbody>
        </table>
		</form>
		</td>
      </tr>
	  
    </table>
	</td>
	</tr>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

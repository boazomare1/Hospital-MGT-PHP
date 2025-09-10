<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$timeonly = date("H:i:s");
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$dateonly1 = date("Y-m-d");
$titlestr = 'SALES BILL';
$docno = $_SESSION['docno'];



if (isset($_REQUEST["q_itemcode"])) { $q_itemcode = $_REQUEST["q_itemcode"]; } else { $q_itemcode = ""; }
if (isset($_REQUEST["q_refno"])) { $q_refno = $_REQUEST["q_refno"]; } else { $q_refno = ""; }
if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }

if(isset($_REQUEST['status'])){$searchstatus = $_REQUEST['status'];}else{$searchstatus='';}

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{   
$patientname=$_REQUEST['customername'];
$billnumber1=$_REQUEST['billnumber'];
$locationcode = $_REQUEST['locationcode'];
$locationname = $_REQUEST['locationname'];

	$paynowbillprefix = 'ES-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from samplecollection_lab where patientcode = 'walkin' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='ES-'.'1';
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
	
	
	$billnumbercode = 'ES-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
$dateonly = date("Y-m-d");
foreach($_POST['lab'] as $key => $value)
		{
		$sampleid = '';
		$labname=$_POST['lab'][$key];
		$itemcode=$_POST['code'][$key];
		$sample=$_POST['sample'][$key];
		$itemstatus=$_POST['status'][$key];
		$labno =$_POST['labno'][$key];
		$remarks=$_POST['remarks'][$key];
		
		$transferloc = isset($_POST['transferlocation'][$key])?$_POST['transferlocation'][$key]:'|';
		//$transferlocsplit = explode('|',$transferloc);
		$transferloccode = isset($_POST['transferlocationcode'][$key])?$_POST['transferlocationcode'][$key]:'';
		$transferlocname = isset($_POST['transferlocation'][$key])?$_POST['transferlocation'][$key]:'';
		
		if(isset($_POST['ack']))
		{
		$status='completed';
		}
		else
		{
		$status='pending';
		}
	foreach($_POST['ack'] as $check)
		{
		$acknow=$check;
	
		if($acknow == $labno)
		{
		$status='completed';
		$status2='norefund';
		break;
		}
		else
		{
		$status='pending';
		}
	}

$status1='norefund';
	foreach($_POST['ref'] as $check1)
	{
	$refund=$check1;
	
	if($refund == $labno)
	{
	$status1='refund';
	$status2='refund';
	$status='completed';
	break;
	}
	else
	{
	$status1='norefund';
	}
	}
	

if($labname == "")
{
$query68="select * from master_lab where itemcode='$itemcode'";
$exec68=mysqli_query($GLOBALS["___mysqli_ston"], $query68);
$res68=mysqli_fetch_array($exec68);
$labname=$res68['itemname'];

}
	
 // mysql_query("insert into master_stock(itemname,itemcode,quantity,batchnumber,rateperunit,totalrate,companyanum,transactionmodule,transactionparticular)values('$medicine','$itemcode','$quantity',' $batch','$rate','$amount','$companyanum','SALES','BY SALES (BILL NO: $billnumber )')");
if($labname != "")
   {
    if(($status == 'completed')&&($itemstatus != ''))
   {
   $paynowbillprefix = 'EPS-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from samplecollection_lab where patientcode = 'walkin' and sampleid <> '' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$sampleidno = $res2["sampleid"];
$billdigit=strlen($sampleidno);
if ($sampleidno == '')
{
	$sampleid ='EPS-'.'1';
	$openingbalance = '0.00';
}
else
{
	$sampleidno = $res2["sampleid"];
	$sampleid = substr($sampleidno,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$sampleid = intval($sampleid);
	$sampleid = $sampleid + 1;

	$maxanum = $sampleid;	
	$sampleid = 'EPS-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
   if($itemstatus != 'discard') {  
   $query26="insert into samplecollection_lab(patientname,patientcode,patientvisitcode,recorddate,itemcode,itemname,sample,acknowledge,refund,billnumber,docnumber,username,sampleid,status,remarks,recordtime,locationcode,locationname,transferlabcode, transferlabname)values('$patientname','walkin',
   'walkinvis','$dateonly','$itemcode','$labname','$sample','$status','$status1','$billnumber1','$billnumbercode','$username','$sampleid','$itemstatus','$remarks','$timeonly','$locationcode','$locationname','$transferloccode','$transferlocname')";
   $exec26=mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
     
	 $query261="insert into opipsampleid_lab(patientname,patientcode,patientvisitcode,recorddate,recordtime,itemcode,itemname,sample,acknowledge,refund,docnumber,sampleid,locationcode,locationname)values('$patientname','walkin',
   'walkinvis','$dateonly','$timeonly','$itemcode','$labname','$sample','$status','$status1','$billnumbercode','$sampleid','$locationcode','$locationname')";
   $exec261=mysqli_query($GLOBALS["___mysqli_ston"], $query261) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   
   $query29=mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_lab set labsamplecoll='$itemstatus',labrefund='$status1',docnumber='$billnumbercode',sampleid='$sampleid', sampledatetime='$updatedatetime' where labitemname='$labname' and billnumber='$billnumber1' and auto_number='$labno'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   }
   
   $query291=mysqli_query($GLOBALS["___mysqli_ston"], "update consultation_lab set labsamplecoll='$itemstatus',labrefund='$status1' where labitemname='$labname' and billnumber='$billnumber1' and auto_number='$labno'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));
 
 }
  
  	}
	
}
 
  header("location:collectedsampleview.php?patientcode=walkin&&visitcode=walkinvis&&docnumber=$billnumbercode");
}

?>

<?php
if (isset($_REQUEST["errcode"])) { $errcode = $_REQUEST["errcode"]; } else { $errcode = ""; }
if($errcode == 'failed')
{
	$errmsg="No Stock";
}

$paynowbillprefix = 'ES-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from samplecollection_lab where patientcode = 'walkin' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='ES-'.'1';
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
	
	
	$billnumbercode = 'ES-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
<link href="autocomplete.css" rel="stylesheet">

<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script>
function acknowledgevalid()
{
var chks = document.getElementsByName('ack[]');
var hasChecked = false;
for (var i = 0; i < chks.length; i++)
{
if (chks[i].checked)
{
hasChecked = true;
}
}
var chks1 = document.getElementsByName('ref[]');
hasChecked1 = false;
for(var j = 0; j < chks1.length; j++)
{
if(chks1[j].checked)
{
hasChecked1 = true;
}
}

if (hasChecked == false && hasChecked1 == false)
{
alert("Please either acknowledge/refund a sample  or click back button on the browser to exit sample collection");
return false;
}
for(n=1;n<10;n++)
	{
if(document.getElementById("status"+n+"").value == 'discard')
{
if(document.getElementById("remarks"+n+"").value == '')
{
alert("Please Enter Remarks");
document.getElementById("remarks"+n+"").focus();
return false;
}
}

if(document.getElementById("status"+n+"").value == 'transfer')
{
if(document.getElementById("transferlocation"+n+"").value == '')
{
alert("Please Select Location");
document.getElementById("transferlocation"+n+"").focus();
return false;
}
}

}
return true;
}

function checkboxcheck(varserialnumber)
{

var varserialnumber = varserialnumber;

if(document.getElementById("ack"+varserialnumber+"").checked == true)
{	

document.getElementById("ref"+varserialnumber+"").disabled = true;
}
else
{
	document.getElementById("ref"+varserialnumber+"").disabled = false;
}
}

function checkboxcheck1(varserialnumber1)
{

var varserialnumber1 = varserialnumber1;

if(document.getElementById("ref"+varserialnumber1+"").checked == true)
{
	document.getElementById("remarks"+varserialnumber1+"").style.display = '';

document.getElementById("ack"+varserialnumber1+"").disabled = true;
}
else
{
document.getElementById("ack"+varserialnumber1+"").disabled = false;
	document.getElementById("remarks"+varserialnumber1+"").style.display = 'none';

}
}

function funcremarksshow(k)
{
var i = k;
//alert(k);
  for(i=1;i<10;i++)
	{
	if (document.getElementById("status"+i+"") != null) 
	{
		if (document.getElementById("status"+i+"").value == 'discard') 
		{	
			document.getElementById("remarks"+i+"").style.display = '';
			document.getElementById("transferlocation"+i+"").style.display = 'none';
		}
		if (document.getElementById("status"+i+"").value == 'transfer') 
		{	
			document.getElementById("transferlocation"+i+"").style.display = '';
			document.getElementById("remarks"+i+"").style.display = 'none';
		}
	}
	}	
	
}

function funcremarkshide()
{			
	for(i=1;i<10;i++)
	{
	if (document.getElementById("status"+i+"") != null) 
	{
		if (document.getElementById("status"+i+"").value == 'completed')  
		{	
			document.getElementById("remarks"+i+"").style.display = 'none';
			document.getElementById("transferlocation"+i+"").style.display = 'none';
		}
	}
	}		
}

function funcstatus(j)
{
var j = j;
if(document.getElementById("status"+j+"").value == 'discard')
{
funcremarksshow(j);
}
if(document.getElementById("status"+j+"").value == 'transfer')
{
funcremarksshow(j);
}
if(document.getElementById("status"+j+"").value == 'completed')
{
funcremarkshide();
}
}

function funcOnLoadBodyFunctionCall()
{
funcremarkshide();

}
</script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>

<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.style1 {
	font-size: 36px;
	font-weight: bold;
}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
.ui-menu .ui-menu-item {
	margin:0;
	padding: 0;
	zoom: 1 !important;
}	
</style>
<?php
$billnumber = $_REQUEST["billnumber"];
$query55="select * from consultation_lab where billnumber='$billnumber'";
$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55=mysqli_fetch_array($exec55);
$patientname=$res55['patientname'];
$locationcode = $res55['locationcode'];
$locationname = $res55['locationname'];

$query66="select * from billing_external where billno='$billnumber'";
$exec66=mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res66=mysqli_fetch_array($exec66);
$row66=mysqli_num_rows($exec66);
if($row66 > 0)
{
$age=$res66['age'];
$gender=$res66['gender'];
}
else
{
$query66="select * from request_externallab where billno='$billnumber'";
$exec66=mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res66=mysqli_fetch_array($exec66);
$row66=mysqli_num_rows($exec66);
$age=$res66['age'];
$gender=$res66['gender'];
}
?>
<script src="js/datetimepicker_css.js"></script>
<script>
$(function() {
	
$('.transfer').autocomplete({
		
	source:'ajaxtransferlocsearch.php', 
	//alert(source);
	minLength:3,
	delay: 0,
	html: true, 
		select: function(event,ui){
		    var textid = $(this).attr('id');
			var tid = textid.split('transferlocation');
			//alert(tid[1]);
			var loccode = ui.item.acccode;
			var locname = ui.item.accname;
			
			$('#transferlocationcode'+tid[1]).val(loccode);
			
			},
    });
});
</script>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="frmsales" id="frmsales" method="post" action="externallabsamplecollection.php" onKeyDown="return disableEnterKey(event)">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="980" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td colspan="4" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo 'red'; } ?>" class="bodytext3"><strong><?php echo $errmsg;?>&nbsp;</strong></td></tr>
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
              
                    <input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 
                    <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
               <td bgcolor="#ecf0f5" class="bodytext3"><strong>Patient  * </strong></td>
	  <td width="21%" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext3">
				<input name="customername" type="hidden" id="customer" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $patientname; ?>                  </td>
                          <td bgcolor="#ecf0f5" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>
				
                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
                
                <td width="28%" bgcolor="#ecf0f5" class="bodytext3">
               
                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" value="<?php echo $dateonly1; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                  <img src="images2/cal.gif" style="cursor:pointer"/>				</td>
               
               
                <td width="10%" bgcolor="#ecf0f5" class="bodytext3"><strong>Doc No</strong></td>
                <td width="25%" bgcolor="#ecf0f5" class="bodytext3" align="left"><?php echo $billnumbercode; ?> </td>
              </tr>
			   <tr>

			  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
			    <td align="left" valign="middle" class="bodytext3">
				<input type="hidden" name="patientage" id="patientage" value="<?php echo $age; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $age; ?>
				&
				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $gender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $gender; ?>			        </td>
                <td width="6%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong> Bill No</strong></td>
                <td align="left" valign="middle" class="bodytext3">
				<input name="billnumber" id="billnumber" type="hidden" value="<?php echo $billnumber; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $billnumber; ?>				</td>
				<td width="10%" class="bodytext3"><strong>Location </strong></td>
                <td width="25%" class="bodytext3" align="left"><?php echo $locationname; ?> 
				<input type="hidden" name="locationcode" value="<?php echo $locationcode; ?>">
				<input type="hidden" name="locationname" value="<?php echo $locationname; ?>">
				</td>
              
				  </tr>
			   
			   
				  <tr>
				  <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
				  </tr>
            </tbody>
        </table></td>
      </tr>
      
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
             <tr>
					<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Refund</strong></div></td>
              <td width="28%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Test Name</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Sample Type</strong></div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Acknowledge</strong></div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Status</strong></div></td>
				 <td width="23%" align="center" valign="center" bgcolor="#ffffff" class="bodytext311"><strong>Remarks</strong></td>
			      </tr>

			<?php

			$colorloopcount = '';
			$sno = '';

						$queryaa1 = "select categoryname,auto_number from master_categorylab order by categoryname ";
						$execaa1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryaa1) or die ("Error in Queryaa1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($resaa1 = mysqli_fetch_array($execaa1))
						{
				
						$data_count=0;
						$categoryname = $resaa1["categoryname"];
						$auto_number = $resaa1["auto_number"];
					?>
	  		<?php
			$tno=0;
			$ssno=0;
			$totalamount=0;			
			$query61 = "select a.* from consultation_lab as a  JOIN master_lab as b ON a.labitemcode=b.itemcode and b.categoryname='$categoryname'  where a.billnumber='$billnumber' and a.patientname='$patientname' and a.labsamplecoll='$searchstatus' and a.labrefund='norefund'";
$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$numb=mysqli_num_rows($exec61);
while($res61 = mysqli_fetch_array($exec61))
{

if($tno==0){
	echo '<tr> <td colspan="6" class="bodytext31" bgcolor="oldlace" > '.$categoryname .' </td> </tr>';
}
$tno++;

$labname =$res61["labitemname"];
$labautono = $res61['auto_number'];
$query68="select * from master_lab where itemname='$labname' and status <> 'deleted'";
$exec68=mysqli_query($GLOBALS["___mysqli_ston"], $query68);
$res68=mysqli_fetch_array($exec68);
$samplename=$res68['sampletype'];
$itemcode=$res68['itemcode'];
$query41="select * from master_categorylab where categoryname='$labname'";
$exec41=mysqli_query($GLOBALS["___mysqli_ston"], $query41);
$num41=mysqli_num_rows($exec41);
if($num41 > 0)
{
$itemcode=$ssno;
$ssno=$ssno + 1;
}

$sno = $sno + 1;
?>
  <tr>
  <td class="bodytext31" valign="center"  align="left"><div align="center">
        <input type="checkbox" name="ref[]" id="ref<?php echo $sno; ?>" value="<?php echo $labautono; ?>" onClick="return checkboxcheck1('<?php echo $sno; ?>')"/></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labname;?></div></td>
		<input type="hidden" name="lab[]" value="<?php echo $labname;?>">
		<input type="hidden" name="code[]" value="<?php echo $itemcode; ?>">
		<input type="hidden" name="labno[]" value="<?php echo $labautono; ?>">
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $samplename; ?>
       </div></td><input type="hidden" name="sample[]" value="<?php echo $samplename; ?>">
        <td class="bodytext31" valign="center"  align="left"><div align="center">
        <input type="checkbox" id="ack<?php echo $sno; ?>" name="ack[]" value="<?php echo $labautono; ?>" onClick="return checkboxcheck('<?php echo $sno; ?>')"/></div></td>
						 <td class="bodytext31" valign="center"  align="left"><div align="center">
		 <select name="status[]" id="status<?php echo $sno; ?>" onChange="return funcstatus('<?php echo $sno; ?>');">
		 <option value="completed">Completed</option>
		 <option value="discard">Discard</option>
		 <option value="transfer">Transfer</option>
		 </select>
		 </div></td>
		  <td align="center" valign="center" class="bodytext311" id="remarks123<?php echo $sno; ?>"><textarea name="remarks[]" id="remarks<?php echo $sno; ?>"></textarea>
		  <input type="text" class="transfer" name="transferlocation[]" id="transferlocation<?php echo $sno; ?>" style="border: 1px solid #001E6A;">
		  <input type="hidden" name="transferlocationcode[]" id="transferlocationcode<?php echo $sno; ?>" style="border: 1px solid #001E6A;">
		  </td>			

						</tr>
			<?php 
		
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

             </tr>
           
          </tbody>
        </table>		</td>
      </tr>
      
      
      
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr>
              <td width="54%" align="right" valign="top" >
                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
             	  <input name="Submit2223" type="submit" value="Save " onClick="return acknowledgevalid()" accesskey="b" class="button"/>
               </td>
              
            </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
  </table>

</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>
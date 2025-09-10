<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];

$titlestr = 'SALES BILL';
 $fee=isset($_REQUEST['fee'])?$_REQUEST['fee']:'';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{

    $visitcode=$_REQUEST["visitcode"];
	$patientcode = $_REQUEST["customercode"];
	$patientname = $_REQUEST["customername"];
	$consultationdate = date("Y-m-d");
	$accountname = $_REQUEST["account"];
	$billtype = $_REQUEST['billtype'];
//	print_r($_POST);
	if($billtype =='PAY NOW')
	{
	$status='pending';
	}
	else
	{
	$status='completed';
	}
	foreach($_POST['itemcode'] as $key => $value)
	{
	$aitemcode = $_POST['itemcode'][$key];
	//$alabfree = $_POST['alabfree'][$key];
	
	 $rate = $_POST['rate'][$key];
	 $qty = $_POST['qty'][$key];
	 $amount = $_POST['amount'][$key];
	  $doctorcode = $_POST['doctorcode'][$key];
	$docnoget = $_POST['docnoget'][$key];
	$autno = $_POST['autno'][$key];
	if($fee!='fee')
	{
		$query1="update ipprivate_doctor set amount='".$amount."' , rate='".$rate."', units = '$qty',updated_user='$username',updated_date='$updatedatetime' where patientcode='$patientcode' and patientvisitcode='$visitcode'  and doccoa ='".$doctorcode."' and auto_number='".$autno."'";
		}
		
	//echo 
	//echo '<br/>';
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"])); 
	}
	$query2 = "select * from ipprivate_doctor where patientcode='$patientcode' and patientvisitcode='$visitcode' order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$labrefnonumber = $res2["refno"];

		header("location:amendlistipdoctor.php");
		exit();

}

if(isset($_REQUEST['del']) && isset($_REQUEST['visitcode'])){
 
  $delid=$_REQUEST['del'];
  $visitcode=$vid=$_REQUEST['visitcode'];
  $patientcode= $pid=$_REQUEST['patientcode'];
  

  $data=mysqli_query($GLOBALS["___mysqli_ston"], "select auto_number,patientname,docno,doccoa,doctorname,rate from ipprivate_doctor where auto_number='$delid'");

  $data1=mysqli_fetch_array($data);
   
   $patientname=$data1['patientname'];
   $refno=$data1['docno'];
   $medicinecode=$data1['doccoa'];
   $medicinename=$data1['doctorname'];
   $rate=$data1['rate'];
  
  $date=date('Y-m-d'); 

$time=date('H:i:s');

$remarks=stripslashes(urldecode($_REQUEST['remarks-'.$delid]));

   $query="insert into amendment_details (patientcode,visitcode,patientname,refno,itemcode,itemname,rate,amenddate,amendtime,amendfrom,amendby,ipaddress,type,remarks) values ('$patientcode','$visitcode','$patientname','$refno','$medicinecode','$medicinename','$rate','$date','$time','IP Doctor','$username','$ipaddress','IP','$remarks')";

   mysqli_query($GLOBALS["___mysqli_ston"], $query)or die("Error in query".mysqli_error($GLOBALS["___mysqli_ston"]));


  $query2 = "delete from ipprivate_doctor where auto_number='$delid' and patientvisitcode='$vid'";
  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

  $query22 = "select * from ipprivate_doctor where patientcode='$pid' and patientvisitcode='$vid'";
  $exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
  $num386=mysqli_num_rows($exec22);
 if($num386>0){
  header("location:amendipdoctor.php?patientcode=".$pid."&visitcode=".$vid);
  exit();
 }else{
   header("location:amendlistipdoctor.php");
   exit();
 }

}


//to redirect if there is no entry in masters category or item or customer or settings



//To get default tax from autoitemsearch1.php and autoitemsearch2.php - for CST tax override.
if (isset($_REQUEST["defaulttax"])) { $defaulttax = $_REQUEST["defaulttax"]; } else { $defaulttax = ""; }
/*if(isset($_REQUEST['delete']))
{
$labname=$_REQUEST['delete'];
$viscode=$_REQUEST['visitcode'];
mysql_query("delete from ipconsultation_lab where auto_number='$labname' and patientvisitcode='$viscode'");
}*/
//$defaulttax = $_REQUEST["defaulttax"];
if ($defaulttax == '')
{
	$_SESSION["defaulttax"] = '';
}
else
{
	$_SESSION["defaulttax"] = $defaulttax;
}
if(isset($_REQUEST["patientcode"]))
{
$patientcode=$_REQUEST["patientcode"];
$visitcode=$_REQUEST["visitcode"];
}


//This include updatation takes too long to load for hunge items database.

//include ("autocompletebuild_lab1.php");
//include ("autocompletebuild_labcategory.php");
//To populate the autocompetelist_services1.js


//To verify the edition and manage the count of bills.
$thismonth = date('Y-m-');
$query77 = "select * from master_edition where status = 'ACTIVE'";
$exec77 =  mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
$res77 = mysqli_fetch_array($exec77);
$res77allowed = $res77["allowed"];



/*
$query99 = "select count(auto_number) as cntanum from master_quotation where quotationdate like '$thismonth%'";
$exec99 = mysql_query($query99) or die ("Error in Query99".mysql_error());
$res99 = mysql_fetch_array($exec99);
$res99cntanum = $res99["cntanum"];
$totalbillandquote = $res88cntanum + $res99cntanum; //total of bill and quote in current month.
if ($totalbillandquote > $res77allowed)
{
	//header ("location:usagelimit1.php"); // redirecting.
	//exit;
}
*/

//To Edit Bill
if (isset($_REQUEST["delbillst"])) { $delbillst = $_REQUEST["delbillst"]; } else { $delbillst = ""; }
//$delbillst = $_REQUEST["delbillst"];
if (isset($_REQUEST["delbillautonumber"])) { $delbillautonumber = $_REQUEST["delbillautonumber"]; } else { $delbillautonumber = ""; }
//$delbillautonumber = $_REQUEST["delbillautonumber"];
if (isset($_REQUEST["delbillnumber"])) { $delbillnumber = $_REQUEST["delbillnumber"]; } else { $delbillnumber = ""; }
//$delbillnumber = $_REQUEST["delbillnumber"];

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
//$frm1submit1 = $_REQUEST["frm1submit1"];


if (isset($_REQUEST["st"])) { 

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST["st"];
if (isset($_REQUEST["banum"])) { $banum = $_REQUEST["banum"]; } else { $banum = ""; }
//$banum = $_REQUEST["banum"];
if ($st == '1')
{
	$errmsg = "Success. New Bill Updated. You May Continue To Add Another Bill.";
	$bgcolorcode = 'success';
}
if ($st == '2')
{
	$errmsg = "Failed. New Bill Cannot Be Completed.";
	$bgcolorcode = 'failed';
}
if ($st == '1' && $banum != '')
{
	$loadprintpage = 'onLoad="javascript:loadprintpage1()"';
}

if ($delbillst == "" && $delbillnumber == "")
{
	$res41customername = "";
	$res41customercode = "";
	$res41tinnumber = "";
	$res41cstnumber = "";
	$res41address1 = "";
	$res41deliveryaddress = "";
	$res41area = "";
	$res41city = "";
	$res41pincode = "";
	$res41billdate = "";
	$billnumberprefix = "";
	$billnumberpostfix = "";
}




?>

<?php
$query78="select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec78=mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res78=mysqli_fetch_array($exec78);
$patientage=$res78['age'];
$patientgender=$res78['gender'];
$res111paymenttype = $res78['paymenttype'];

$query121 = "select * from master_paymenttype where auto_number = '$res111paymenttype'";
$exec121 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die (mysqli_error($GLOBALS["___mysqli_ston"]));
$res121 = mysqli_fetch_array($exec121);
$res121paymenttype = $res121['paymenttype'];

$res111subtype = $res78['subtype'];

$query131 = "select * from master_subtype where auto_number = '$res111subtype'";
$exec131 = mysqli_query($GLOBALS["___mysqli_ston"], $query131) or die ("Error in Query131".mysqli_error($GLOBALS["___mysqli_ston"]));
$res131 = mysqli_fetch_array($exec131);
$res131subtype = $res131['subtype'];
?>
<?php
 $fee=isset($_REQUEST['fee'])?$_REQUEST['fee']:'';
$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from ipprivate_doctor where patientcode='$patientcode'");
$execlab1=mysqli_fetch_array($querylab1);
$patientname=$execlab1['patientname'];
$patientaccount=$execlab1['accountname'];
$billtype=$execlab1['billtype'];
if($fee=='fee')
{
	$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from ipprivate_doctor_fees where patientcode='$patientcode'");
$execlab1=mysqli_fetch_array($querylab1);
$patientname=$execlab1['patientname'];
$patientaccount=$execlab1['accountname'];
$billtype=$execlab1['billtype'];
	}
?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$labprefix = $res3['labprefix'];

$query2 = "select * from billing_lab order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billnumber"];
if ($billnumber == '')
{
	$billnumbercode =$labprefix.'00000001';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billnumber"];
	$billnumbercode = substr($billnumber, 3, 8);
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	if (strlen($maxanum) == 1)
	{
		$maxanum1 = '0000000'.$maxanum;
	}
	else if (strlen($maxanum) == 2)
	{
		$maxanum1 = '000000'.$maxanum;
	}
	else if (strlen($maxanum) == 3)
	{
		$maxanum1 = '00000'.$maxanum;
	}
	else if (strlen($maxanum) == 4)
	{
		$maxanum1 = '0000'.$maxanum;
	}
	else if (strlen($maxanum) == 5)
	{
		$maxanum1 = '000'.$maxanum;
	}
	else if (strlen($maxanum) == 6)
	{
		$maxanum1 = '00'.$maxanum;
	}
	else if (strlen($maxanum) == 7)
	{
		$maxanum1 = '0'.$maxanum;
	}
	else if (strlen($maxanum) == 8)
	{
		$maxanum1 = $maxanum;
	}
	
	$billnumbercode = $labprefix .$maxanum1;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>

<?php include ("js/sales1scripting1.php"); ?>
<script type="text/javascript">

function numbervaild(key)
{
 var keycode = (key.which) ? key.which : key.keyCode;

  if(keycode > 40 && (keycode < 48 || keycode > 57 )&&( keycode < 96 || keycode > 111))
 {
	 
  return false;
 }
}

function FuncCalc(id)
{
	var Rate = document.getElementById("rate"+id).value;
	var Qty = document.getElementById("qty"+id).value;
	if(Rate == ''){ Rate = '0'; }
	if(Qty == ''){ Qty = '0'; }
	var Amt = parseFloat(Rate) * parseFloat(Qty);
	var Amt = parseFloat(Amt);
	document.getElementById("amount"+id).value = Amt.toFixed(2);
}

function delconfirm(id,pid,vid){

var msg=document.getElementById('remarks-'+id).value;
if(msg.trim()==''){
alert("Must have remarks.");
document.getElementById('remarks-'+id).focus();

return false;
}

var confirm1=confirm("You are deleting the record permanently, On Click of OK, the record will no longer be available. Pl Note");
if(confirm1 == false) 
{
  return false;
}else{
  window.location='amendipdoctor.php?patientcode='+pid+'&visitcode='+vid+'&del='+id+'&remarks-'+id+'='+msg;

}

}
</script>
<script type="text/javascript" src="js/insertnewitem22iplab.js"></script>

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

</style>

<!--<script src="js/datetimepicker_css.js"></script>
<?php /*?><?php include ("js/dropdownlist1scriptinglab1.php"); ?><?php */?>
<script type="text/javascript" src="js/autocomplete_lab1.js"></script>
<script type="text/javascript" src="js/autosuggestlab1.js"></script> 
<script type="text/javascript" src="js/autolabcodesearch2.js"></script>
-->

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body>
<form name="form1" id="frmsales" method="post" action="amendipdoctor.php" onKeyDown="return disableEnterKey(event)">
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
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              
			 
		
			  <tr>
			    <td width="15%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient * </strong></td>
                <td width="36%" align="left" valign="middle" class="bodytext3">
				<input name="customername" id="customer" type="hidden" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $patientname; ?>
                  </td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Patient code </strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3">
				<input name="customercode" id="customercode" type="hidden" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
             
			    </tr>
			   <tr>
			    <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
			    <td align="left" valign="middle" class="bodytext3">
				<input type="hidden" name="patientage" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientage; ?>
				&
				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientgender; ?>
				<input type="hidden" name="address1" id="address1" value="<?php echo $res41address1; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;" size="30" />
			      <span class="style4"><!--Area--> </span>
			      <input type="hidden" name="area" id="area" value="<?php echo $res41area; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="10" />
				  </td>
				    <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3">
				<input name="account" id="account" type="hidden" value="<?php echo $patientaccount; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientaccount; ?>
				<input type="hidden" name="billtype" id="billtype" value="<?php echo $billtype; ?>">	
				<input type="hidden" name="billtypes" id="billtypes" value="<?php echo $billtype; ?>">	
				 <input type="hidden" name="paymenttype" id="payment" value="<?php echo $res121paymenttype; ?>" readonly   size="20" />		
				  <input type="hidden" name="subtype" id="subtype"  value="<?php echo $res131subtype; ?>" >  
				 	  </tr>
				  <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit Code</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3">
				<input name="visitcode" id="visitcode" type="hidden" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $visitcode; ?>
				
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
              <td width="6%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>TXN Date</strong></div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Code </strong></div></td>
				<td width="32%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Doctor</strong></div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Qty  </strong></div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>

				<td width="13%"  align="left" valign="center" 

 				bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Remarks </strong></div></td>

				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action </strong></div></td>
				
                  </tr>
				  		<?php
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
			if($billtype == 'PAY NOW')
			{
			$status='pending';
			}
			else
	{
	$status='completed'; 
	}
	if($fee!='fee')
{
			$query17 = "select * from ipprivate_doctor where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending' order by consultationdate,consultationtime";
			$exec17 = mysqli_query($GLOBALS["___mysqli_ston"], $query17) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res17 = mysqli_fetch_array($exec17))
			{
			
				$paharmitemname=$res17['doctorname'];
				$autonumber = $res17['auto_number'];
				
				$pharmitemcode=$res17['patientcode'];
			$rate=$res17['rate'];
			$amount=$res17['amount'];
			$qty = $res17['units'];
			$freestatus=$res17['freestatus'];
			$docnoget=$res17['docno'];
			$txndate=$res17['consultationdate'].' '.$res17['consultationtime'];
			
			$doctorcode=$res17['doccoa'];
		
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
			$totalamount=$totalamount+$pharmitemrate;
			$totalamount=number_format($totalamount,2);
			?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $txndate; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemcode; ?>
				<input type="hidden" name="itemcode[<?php echo $sno;?>]" id="itemcode<?php echo $sno; ?>" value="<?php echo $pharmitemcode; ?>"></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" value="<?php echo $rate; ?>" name="rate[<?php echo $sno;?>]" id="rate<?php echo $sno;?>" onKeyUp="return FuncCalc('<?php echo $sno;?>')" onKeyDown="return numbervaild(event)" autocomplete="off" size="12"></div>
                <input type="hidden" name="doctorcode[<?php echo $sno;?>]" value="<?php echo $doctorcode;?>">
                <input type="hidden" name="autno[<?php echo $sno;?>]" value="<?php echo $autonumber;?>"></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" value="<?php echo $qty; ?>" name="qty[<?php echo $sno;?>]" id="qty<?php echo $sno;?>" onKeyUp="return FuncCalc('<?php echo $sno;?>')" onKeyDown="return numbervaild(event)" autocomplete="off" size="5"></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" readonly value="<?php echo $amount; ?>" name="amount[<?php echo $sno;?>]" id="amount<?php echo $sno;?>" onKeyDown="return numbervaild(event)" autocomplete="off" size="12"></div></td><input type="hidden" value="<?php echo $docnoget; ?>" name="docnoget[]" id="docnoget"></td>
                <td class="bodytext31" valign="center"  align="left"><div align="center"><input type = "text" name ="remarks-<?php echo $autonumber; ?>" id ="remarks-<?php echo $autonumber; ?>"></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><a href='javascript:return false;' onclick='return delconfirm("<?php echo $autonumber;?>","<?php echo $patientcode;?>","<?php echo $visitcode;?>")'>Delete</a></div></td>
			<?php } }
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
              <td colspan="2" class="bodytext31" valign="center"  align="left" 
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
	   
	  
      
     
				     
				
		       
      <tr><input type="hidden" name="fee" value="<?php echo $fee;?>">
        
		 <td colspan="2" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
		  <input type="hidden" name="frm1submit1" value="frm1submit1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
               <input name="Submit222" type="submit"  value="Save Request" class="button"/>
		 </td>
      </tr>
	  </table>
      </td>
      </tr>
    
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>
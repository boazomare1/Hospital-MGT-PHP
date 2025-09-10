<?php

session_start();

error_reporting(0);

//date_default_timezone_set('Asia/Calcutta');

include ("db/db_connect.php");

include ("includes/loginverify.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$updatedatetime = date("Y-m-d H:i:s");

$indiandatetime = date ("d-m-Y H:i:s");

$dateonly = date("Y-m-d");

$timeonly = date("H:i:s");

$datetimeonly = date("Y-m-d H:i:s");

$username = $_SESSION["username"];

$ipaddress = $_SERVER["REMOTE_ADDR"];



$companyname = $_SESSION["companyname"];

$financialyear = $_SESSION["financialyear"];



//get locationcode to get locationname

 $locationcode=isset($_REQUEST['loccode'])?$_REQUEST['loccode']:'';


function bilnumber(){
    $paynowbillprefix = 'OPRF-';
	$paynowbillprefix1=strlen($paynowbillprefix);
	$query2 = "select * from master_item_refund order by auto_number desc limit 0, 1";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_fetch_array($exec2);
	$billnumber = $res2["billnumber"];
	$billdigit=strlen($billnumber);
	if ($billnumber == '')
	{
		$billnumbercode ='OPRF-'.'1';
	}
	else
	{
		$billnumber = $res2["billnumber"];
		$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
		$billnumbercode = intval($billnumbercode);
		$billnumbercode = $billnumbercode + 1;
		$maxanum = $billnumbercode;
		$billnumbercode = 'OPRF-'.$maxanum;
	}
	return $billnumbercode;

}





if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

if ($frm1submit1 == 'frm1submit1')

{   
      
   $billno=bilnumber();
   $type='master_consultationpharm';
   $visitcode=$_POST['visitcode'];
   $patientcode=$_POST['patientcode'];
   $customername=$_POST['customername'];
   $account=$_POST['account'];
   $remarks=addslashes($_POST['remarks']);
   $locationcode=$_REQUEST['location'];
   
   foreach($_POST['ref'] as $key => $value)
   {
	   $rowno=$value-1;
	   $auto_numer=$_POST['recordid'][$rowno];
	   $paymentstatus=$_POST['paymentstatus'][$rowno];
	   $medicine=$_POST['medicine'][$rowno];
	   $itemcode=$_POST['itemcode'][$rowno];
	   $quantity=$_POST['quantity'][$rowno];
	   $rate=$_POST['rate'][$rowno];
	   $amount=$_POST['amount'][$rowno];

	   

	   if($paymentstatus=='paynow'){
		   $status='requested';
	   }
	   else{
		   $status='completed';
	   }

	    $query43="insert into master_item_refund(billnumber,patientcode,visitcode,itemcode,itemname,quantity,rate,totalamount,request_username,request_ip,request_date,request_id,remarks,from_table,billstatus,locationcode)values('$billno','$patientcode','$visitcode','$itemcode','$medicine','$quantity','$rate','$amount','$username','$ipaddress','$datetimeonly','$auto_numer','$remarks','$type','$status','$locationcode')"; 

		$exec43=mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));


       $sqlupdate="update $type set refund='$status' where auto_number='$auto_numer'";
	   $exec8=mysqli_query($GLOBALS["___mysqli_ston"], $sqlupdate);
	   $sqlupdate="update master_consultationpharmissue set refund='$status' where auto_number='$auto_numer'";
	   $exec8=mysqli_query($GLOBALS["___mysqli_ston"], $sqlupdate);

   }
   header("location:pharmacy_refundlist.php");
   exit;
}



?>



<?php

if (isset($_REQUEST["errcode"])) { $errcode = $_REQUEST["errcode"]; } else { $errcode = ""; }

if($errcode == 'failed')

{

	$errmsg="No Stock";

}

?>









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

.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }

</style>

<?php

$patientcode = $_REQUEST["patientcode"];

$visitcode = $_REQUEST["visitcode"];

?>
<script src="jquery/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>

<script src="js/datetimepicker_css.js"></script>

<?php

$query65= "select * from master_visitentry where patientcode='$patientcode'";

$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die("error in query65".mysqli_error($GLOBALS["___mysqli_ston"]));

$res65=mysqli_fetch_array($exec65);

$Patientname=$res65['patientfullname'];



$query69="select * from master_customer where customercode='$patientcode'";

$exec69=mysqli_query($GLOBALS["___mysqli_ston"], $query69) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res69=mysqli_fetch_array($exec69);

$dob = $res69['dateofbirth'];

$patientage = calculate_age($dob);

$billtype = $res69['billtype'];



$patientgender=$res69['gender'];

$patientaccount=$res69['accountname'];



$query70="select * from master_accountname where auto_number='$patientaccount'";

$exec70=mysqli_query($GLOBALS["___mysqli_ston"], $query70);

$res70=mysqli_fetch_array($exec70);

$accountname=$res70['accountname'];
// $iscapitation_f=$res70['accountname'];




//////////// for capitation////////////////////////

$querylab1=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_visitentry where visitcode='$visitcode' and patientcode='$patientcode'");
$execlab1=mysqli_fetch_array($querylab1);
// $patientname12112=$execlab1['patientfullname'];
//$patientaccount=$execlab1['accountname'];
$patientaccount121=$execlab1['accountname'];

$querylab2=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_accountname where auto_number='$patientaccount121'");
$execlab2=mysqli_fetch_array($querylab2);
// $patientaccount1=$execlab2['accountname'];
// $patientaccountid1=$execlab2['id'];
// $accountnameano=$execlab2['auto_number'];
$iscapitation_f=$execlab2['iscapitation'];
//////////// for capitation////////////////////////

if(isset($_REQUEST['store'])){ $defaultstore = $_REQUEST['store']; } else { $defaultstore = ''; }

if($defaultstore == '')

{

$querysto = "select storecode,locationanum from master_employeelocation where username='$username' AND locationcode = '".$locationcode."' and defaultstore='default' order by  storecode desc";

}

else

{

$querysto = "select storecode,locationanum from master_employeelocation where username='$username' AND locationcode = '".$locationcode."' and storecode='$defaultstore' order by  storecode desc";

}

$execsto = mysqli_query($GLOBALS["___mysqli_ston"], $querysto) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

while ($ressto = mysqli_fetch_array($execsto))

{

    $res7storeanum = $ressto['storecode'];

	$res7locationanum = $ressto['locationanum'];

}





$query55 = "select * from master_location where auto_number='$res7locationanum'";

$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res55 = mysqli_fetch_array($exec55);

$locationname = $res55['locationname']; 

$locationcode = $res55['locationcode']; 



//$res7storeanum = $res23['store'];



$query75 = "select ms.store,ms.storecode from master_store as ms where auto_number='$res7storeanum'";

$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res75 = mysqli_fetch_array($exec75);

   $store = $res75['store'];

   $storecode = $res75['storecode'];

/*$query61 = "select * from master_consultationpharmissue where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and recordstatus <>'deleted' and quantity <> '$zero' and paymentstatus='completed'";*/

function calculate_age($birthday)

{

    $today = new DateTime();

    $diff = $today->diff(new DateTime($birthday));



    if ($diff->y)

    {

        return $diff->y . ' Years';

    }

    elseif ($diff->m)

    {

        return $diff->m . ' Months';

    }

    else

    {

        return $diff->d . ' Days';

    }

}



?>

<?php

$query3 = "select * from master_company where companystatus = 'Active'";

$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

$res3 = mysqli_fetch_array($exec3);

$billnumbercode=bilnumber()

?>

</head>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />   

<script type="text/javascript">

function Redirect(patientcode,visitcode,location)

{

var patientcode = patientcode;

var visitcode = visitcode;

var location = location;



var Store = document.getElementById("store").value;



<?php

$query10 = "select * from master_store";

$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));

while($res10 = mysqli_fetch_array($exec10))

{

$res10storecode = $res10['storecode'];

$res10storeanum = $res10['auto_number'];

?>

if(document.getElementById("store").value == "<?php echo $res10storecode; ?>")

{

//alert("<?php echo $res10storeanum; ?>");

var Storeanum = "<?php echo $res10storeanum; ?>";

window.location = "pharmacy1.php?patientcode="+patientcode+"&&visitcode="+visitcode+"&&loccode="+location+"&&store="+Storeanum;

}

<?php

}

?>

//window.location = "pharmacy1.php?patientcode="+patientcode+"&&visitcode="+visitcode+"&&loccode="+location+"&&store="+Store;



}


function saveValid(){


    if($('#frmsales').find('input[type=checkbox]:checked').length == 0)
    {
        alert('Please select atleast an item');
		return false;
    }

if(document.getElementById("remarks").value==''){
  alert("Please enter the remarks.");
  document.getElementById("remarks").focus();
  return false;
}

var confirm1=confirm("Do you want to save?");
if(confirm1 == false) 
{
  return false;
}	
return true;
}

function number(event)

{

	var charcode=(event.which)?event.which:event.keycode

	if(charcode>31 && (charcode<47 || charcode >57))

	{

		return false;

	}

		return true;

}

function acknowledgevalid(varSerialNumber2)

{

var varSerialNumber2=varSerialNumber2;



var hasChecked = false;

if (document.getElementById("ref"+varSerialNumber2+"").checked)

{

hasChecked = true;

}



if (hasChecked == false)

{

//alert("Please either refund a drug  or click back button on the browser to exit");

document.getElementById("returnquantity"+varSerialNumber2+"").value = 0;
grandtotal=parseFloat(document.getElementById("totalamt").value) - parseFloat(document.getElementById("amount"+varSerialNumber2+"").value);
document.getElementById("amount"+varSerialNumber2+"").value = 0;
document.getElementById("totalamt").value =grandtotal.toFixed(2);;

return false;

}

return true;



}


function balancecalc(varSerialNumber1,qnty1,totalcount)

{

var varSerialNumber1 = varSerialNumber1;

var qnty1 = qnty1;

var totalcount=totalcount;

//alert(totalcount);

var grandtotal=0;



var abc=acknowledgevalid(varSerialNumber1);

if(abc == true)

{



var returnquantity=document.getElementById("quantity"+varSerialNumber1+"").value;

returnquantity = parseInt(returnquantity);

qnty1 = parseInt(qnty1);

if(returnquantity>qnty1)

{

alert("Please Enter a Lesser Quantity");

document.getElementById("balamount"+varSerialNumber1+"").value=0.00;

document.getElementById("totalamt").value=0.00;

document.getElementById("amount"+varSerialNumber1+"").value=0.00;

document.getElementById("returnquantity"+varSerialNumber1+"").value = 0;

//document.getElementById("returnquantity"+varSerialNumber1+"").focus();

return false;

}

if(returnquantity <= qnty1)

{

var balancequantity=parseFloat(qnty1)-parseFloat(returnquantity);

document.getElementById("returnquantity"+varSerialNumber1+"").value = returnquantity;

document.getElementById("balamount"+varSerialNumber1+"").value=balancequantity;



var rate=document.getElementById("rate"+varSerialNumber1+"").value;

var newamount=rate * returnquantity;

document.getElementById("amount"+varSerialNumber1+"").value=newamount.toFixed(2);

for(i=1;i<=totalcount;i++)

{

var totalamount=document.getElementById("amount"+i+"").value;



if(totalamount == "")

{

totalamount=0;

}

//alert(totalamount);

grandtotal=parseFloat(grandtotal)+parseFloat(totalamount);



}

//alert(grandtotal);

document.getElementById("totalamt").value=grandtotal.toFixed(2);

}

return true;

}



}

</script>  

<style>
.bal

{

border-style:none;

background:none;

text-align:right;

}
</style>

<body >

<form name="frmsales" id="frmsales" method="post" action="" onKeyDown="return disableEnterKey(event)" onSubmit="document.getElementById('subbutton').disabled=true">

<table width="101%" border="0" cellspacing="0" cellpadding="2" >

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

               <td bgcolor="#ecf0f5" class="bodytext31"><strong>Patient  </strong></td>

	           <td width="26%" align="left" valign="middle" class="bodytext3" bgcolor="#ecf0f5"><?php echo $Patientname; ?>

				<input name="customername" id="customer" type="hidden" value="<?php echo $Patientname; ?>"  size="40" autocomplete="off" readonly/>                  </td>

                          <td bgcolor="#ecf0f5" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>

				

                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />

                

                <td width="27%" bgcolor="#ecf0f5" class="bodytext3"><?php echo $dateonly; ?>

               

                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" type="hidden" value="<?php echo $dateonly; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" /></td>

               

                <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Doc No</strong></td>

                <td width="20%" align="left" valign="middle" class="bodytext3" bgcolor="#ecf0f5"><?php echo $billnumbercode; ?>

			<input name="docnumber" id="docnumber" value="<?php echo $billnumbercode; ?>" type="hidden" style="border: 1px solid #001E6A" size="8" rsize="20" readonly/>                  </td>

              </tr>

			 

		

			  <tr>



			    <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Visit No </strong></td>

                <td width="26%" align="left" valign="middle" class="bodytext3"><?php echo $visitcode; ?>

			<input name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" type="hidden" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>                  </td>

                 <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Reg.No</strong></td>

                 <td align="left" valign="middle" class="bodytext3"><?php echo $patientcode; ?>

				<input name="customercode" id="customercode" type="hidden" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>

				

				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>

             

			    <td align="left" valign="middle" class="bodytext3"><strong>Location</strong></td>

			    <td align="left" valign="middle" class="bodytext3"><?php echo $locationname; ?><input  name="location" type="hidden" value="<?php echo $locationcode; ?>" size="18" style="border: 1px solid #001E6A" readonly><input  name="locationname" type="hidden" value="<?php echo $locationname; ?>" size="18" style="border: 1px solid #001E6A" readonly></td>

			  </tr>

				  <tr>



			  <td align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>

			    <td align="left" valign="middle" class="bodytext3"><?php echo $patientage; ?>

				<input type="hidden" name="patientage" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly>

				&  <?php echo $patientgender; ?>

				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly>				     </td>

                <td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Account</strong></td>

                <td align="left" valign="middle" class="bodytext3"><?php echo $accountname; ?>

				<input name="account" id="account" type="hidden" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				                  

                <td align="left" valign="middle" class="bodytext3"></td>           

                <td align="left" valign="middle" class="bodytext3"> 

				
				 </td>           

				  </tr>

				  <tr>
				  		<td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
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

            <td width="8%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>

              <td width="18%" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>Medicine Name</strong></div></td>

				<td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Frequency</strong></div></td>

				<td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Days</strong></div></td>

				

                <td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Dose</strong></div></td>

				<td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Dose.Measure</strong></div></td>

                <td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Pres.Qty</strong></div></td>
				

				<td width="16%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ret. Qty</strong></div></td>

				<td width="9%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bal. Qty</strong></div></td>

				<td width="9%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate</strong></div></td>

				<td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount</strong></div></td>

			      </tr>

				  		<?php

			$colorloopcount = '';

			$sno = 1;

			$totalamount=0;		

			$zero=0;	

			$query23 = "select * from master_employeelocation where username='$username' and defaultstore = 'default' and locationcode='$locationcode'";

$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res23 = mysqli_fetch_array($exec23);

 $location = $res23['locationname'];

 $res7locationanum = $res23['locationcode'];

 $res7storeanum = $res23['storecode'];



/*$query55 = "select * from master_location where locationcode='$res7locationanum'";

$exec55 = mysql_query($query55) or die(mysql_error());

$res55 = mysql_fetch_array($exec55);

$location = $res55['locationname'];

*/





$query75 = "select * from master_store where auto_number='$res7storeanum'";

$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res75 = mysqli_fetch_array($exec75);

 $storename = $res75['store'];



if($billtype == 'PAY NOW')

{

			$query61 = "select * from master_consultationpharmissue where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and recordstatus <>'deleted' and quantity <> '$zero' and paymentstatus='completed' and amendstatus='2' and refund=''";

}

else

{

			$query61 = "select * from master_consultationpharmissue where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and recordstatus <>'deleted' and quantity <> '$zero' and paymentstatus='completed' and amendstatus='2' and refund=''";

}

$exec61 = mysqli_query($GLOBALS["___mysqli_ston"], $query61) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$numb=mysqli_num_rows($exec61);

//echo $numb;

while($res61 = mysqli_fetch_array($exec61))

{

$res1medicinename1='';

$oldmedicinename='';

$totalstock=0;

$oldstock=0;

$i=0;

$totalst=0;

$pending='';

$recordid =$res61["auto_number"];

$res1medicinename =$res61["medicinename"];

$res1medicinename =addslashes($res1medicinename);

 $itemcode =trim($res61['medicinecode']);

 $consid=$res61['consultation_id'];

$res1dose = $res61["dose"];

$res1frequency = $res61["frequencynumber"];

$res1days = $res61["days"];

$res1quantity = $res61["quantity"];

$res1route = $res61["route"];

$res3quantity = $res61["prescribed_quantity"];

$res1rate = $res61["rate"];

$res1amount = $res61["amount"];

$instructions = $res61['instructions'];

$res1medicinename=trim($res1medicinename);

$excludestatus=$res61['excludestatus'];

$excludebill = $res61['excludebill'];

$dosemeasure = $res61['dosemeasure'];
$balanceqty=0;


$i=0;

$loopcontrol='';

$query23 = "select * from master_employeelocation where locationcode='$locationcode' AND username = '".$username."' and defaultstore = 'default'";

$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res23 = mysqli_fetch_array($exec23);

 $location = $res23['locationname'];

 $res7locationanum = $res23['locationcode'];

 $res7storeanum = $res23['storecode'];



$query75 = "select * from master_store where auto_number='$res7storeanum'";

$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res75 = mysqli_fetch_array($exec75);

$storename = $res75['store'];

$sqlrate="select rate from billing_paynowpharmacy where patientvisitcode='$visitcode' and medicinecode='$itemcode'";
$exec754 = mysqli_query($GLOBALS["___mysqli_ston"], $sqlrate);
$numrate=mysqli_num_rows($exec754);
if($numrate>0){
  $paymentstatus="paynow";
  $res754 = mysqli_fetch_array($exec754);
  $res1rate=$res754['rate'];
}else{
  $paymentstatus="paylater";
}

 ?>

			  <tr>

              <td class="bodytext31" valign="center"  align="left"><div align="center">

        <input type="checkbox" name="ref[]" id="ref<?php echo $sno; ?>" value="<?php echo $sno; ?>" onclick="balancecalc('<?php echo $sno; ?>','<?php echo $res3quantity;?>','<?php echo $numb; ?>')"/>

        </div></td>

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo stripslashes($res1medicinename);?></div></td>

			 <input type="hidden" name="medicine[]" value="<?php echo stripslashes($res1medicinename);?>" />

			 <input type="hidden" name="itemcode[]" value="<?php echo $itemcode; ?>" />

             <input type="hidden" name="consid[]" value="<?=$consid;?>">
			 <input type="hidden" name="recordid[]" value="<?=$recordid;?>">
			 <input type="hidden" name="paymentstatus[]" value="<?=$paymentstatus;?>">

             

			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1frequency;?></div></td>

			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1days;?></div></td>



			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1dose;?></div></td>

		        <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $dosemeasure;?></div></td>


			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res3quantity;?></div></td>

			     <input type="hidden" name="quantity[]" id="quantity<?php echo $sno; ?>" value="<?php echo $res1quantity;?>" />


				<input type="hidden" name="rate[]" id="rate<?php echo $sno; ?>" value="<?php echo $res1rate;?>" />

				
				 
			 
		

			 	 <td class="bodytext31" valign="center"  align="left"> 
				   <input type="text" name="returnquantity[]" id="returnquantity<?php echo $sno; ?>" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $res1quantity;?>','<?php echo $numb; ?>')"  onKeyPress="return number(event)"  size="7" class="bal">
				 
				 </td>

                 
				<td class="bodytext31" valign="center"  align="left"><input type="text" class="bal" name="balamount[]" id="balamount<?php echo $sno; ?>" size="7" readonly value="<?php echo $balanceqty; ?>"></td>

				<td class="bodytext31" valign="center"  align="left"><div align="center"><div align="center"><?php echo $res1rate;?></div></td>

				<td class="bodytext31" valign="center"  align="left"><input type="text" class="bal" name="amount[]" id="amount<?php echo $sno; ?>" size="7" readonly></td>

				 

				  	</tr>

			<?php 

			$sno++;

			}


			 ?>

			  <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5" ><strong style='color:red'>Remarks</strong>: </td>

             
				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5" colspan='4'><input type="hidden" name="serialno" id="serialno" value="<?php echo $sno; ?>"><textarea name="remarks" id="remarks" cols='25' rows='2'></textarea></td>

               <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

             <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

           

               <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5" colspan='2'><strong>Total Refund</strong></td>

				

               
                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><input type="text" name="totalamt" id="totalamt" size="7" class="bal" readonly=""></td>

       

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

             	  <input name="Submit2223" type="submit" id="subbutton" onClick="return saveValid()" value="Refund" accesskey="b" class="button" />

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

<script type="text/javascript">

	

	$(document).ready(function(){

		for(var i=1;i<=$("#serialno").val();i++){

			$("#ref"+i).trigger('click');

		}

	});

</script>
</html>


<?php

session_start();

error_reporting(0);

//date_default_timezone_set('Asia/Calcutta');

include ("db/db_connect.php");

include ("includes/loginverify.php");
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



$titlestr = 'SALES BILL';





if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

if ($frm1submit1 == 'frm1submit1')

{   



//get location and store

 $locationcodeget=isset($_REQUEST['location'])?$_REQUEST['location']:'';

 $locationnameget=isset($_REQUEST['locationname'])?$_REQUEST['locationname']:'';

 $storecode=$storecodeget=isset($_REQUEST['store'])?$_REQUEST['store']:'';
 
 include("store_stocktaking_chk1.php");
  if($num_stocktaking > 0) {
   echo "<script>history.back();</script>";
   exit;

}


$patientcode=$_REQUEST['patientcode'];

$visitcode=$_REQUEST['visitcode'];

$companyanum = $_SESSION["companyanum"];

$patientname=$_REQUEST['customername'];

$paynowbillprefix = 'OPPI-';

$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from pharmacysales_details where patientcode <> 'walkin' and ipdocno='' order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["docnumber"];

$billdigit=strlen($billnumber);

if ($billnumber == '')

{

	$billnumbercode ='OPPI-'.'1';

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

	

	

	$billnumbercode = 'OPPI-' .$maxanum;

	}

	$docnumber = $billnumbercode;

$accountname=$_REQUEST['account'];

$totalpending = 0;

 
		foreach($_POST['ref'] as $key => $value)

		{
            $key=$value;
			
			$medicinename=$_POST['medicine'][$key];

			$itemcode=$_POST['itemcode'][$key];

	 		$consid1=$_POST['consid'][$key]; 

			$quantity=$_POST['issue'][$key];

			$rate=$_POST['rate'][$key];

			$amount=$rate * $quantity;

			$batch=$_POST['batch'][$key];

			$batch = str_replace("�","",$batch);

			$batch = trim($batch);

			$pending=$_POST['pending1'][$key];

			$route = $_POST['route'][$key];

			$instructions=$_POST['instructions'][$key];

			$fifo_code=$_POST['fifo_code'][$key];
			$pharmano=$_POST['pharmano'][$key];

			$query612 = "select sum(quantity) as tot_qty from master_consultationpharm where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and recordstatus <>'deleted' and pharmacybill='completed' and medicinecode = '$itemcode'";

			$exec612 = mysqli_query($GLOBALS["___mysqli_ston"], $query612) or die ("Error in query612".mysqli_error($GLOBALS["___mysqli_ston"]));
		   $rescumstock234 = mysqli_fetch_array($exec612);
          $tot_qty=$rescumstock234["tot_qty"];


		   $query612 = "select sum(quantity) as sale_qty from pharmacysales_details where itemcode='".$itemcode."' and patientcode = '$patientcode' and visitcode = '$visitcode' ";
           $exec612 = mysqli_query($GLOBALS["___mysqli_ston"], $query612) or die ("Error in query612".mysqli_error($GLOBALS["___mysqli_ston"]));
		   $rescumstock234 = mysqli_fetch_array($exec612);
           $sale_qty=$rescumstock234["sale_qty"];
         
			//if($quantity==($tot_qty-$sale_qty-$pending)) {
			if(true) {

			$query31 = "select categoryname from master_itempharmacy where itemcode = '$itemcode'"; 

			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res31 = mysqli_fetch_array($exec31);

			$categoryname = $res31['categoryname'];

			

			$query6 = "select ledgername, ledgercode, ledgerautonumber,incomeledger,incomeledgercode,inventoryledgercode,inventoryledgername,purchaseprice from master_medicine where itemcode = '$itemcode'"; 

			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res6 = mysqli_fetch_array($exec6);

			$ledgername = $res6['ledgername'];

			$ledgercode = $res6['ledgercode'];

			$ledgeranum = $res6['ledgerautonumber'];

			$incomeledger =$res6['incomeledger'];

			$incomeledgercode = $res6['incomeledgercode'];

			$inventoryledgercode = $res6['inventoryledgercode'];

			$inventoryledgername = $res6['inventoryledgername'];

			//$costprice = $res6['purchaseprice'];

			//$totalcp = $quantity * $costprice;

			$query40 = "select rate  from transaction_stock where batch_stockstatus='1' and batchnumber='$batch' and itemcode='$itemcode' and locationcode='$locationcodeget' and storecode='$storecodeget' and fifo_code='$fifo_code' limit 0,1";

			$exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die ("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res40 = mysqli_fetch_array($exec40);
			$costprice = $res40['rate'];

			$totalcp = $quantity * $costprice;
						

	 // mysql_query("insert into master_stock(itemname,itemcode,quantity,batchnumber,rateperunit,totalrate,companyanum,transactionmodule,transactionparticular)values('$medicine','$itemcode','$quantity',' $batch','$rate','$amount','$companyanum','SALES','BY SALES (BILL NO: $billnumber )')");

	   if($medicinename != "")

	   {   

		   //$query251 = "select * from pharmacysales_details where itemcode='$itemcode' and fifo_code='$fifo_code' and visitcode='$visitcode' and docnumber='$docnumber' and entrydate='$dateonly'";

		   //$exec251 = mysql_query($query251) or die(mysql_error());

		   //$num251 = mysql_num_rows($exec251);

		   if(true)

		   {

			   

				$querycumstock2 = "select sum(batch_quantity) as cum_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcodeget'";

				$execcumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querycumstock2) or die ("Error in CumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

				$rescumstock2 = mysqli_fetch_array($execcumstock2);

				$cum_quantity = $rescumstock2["cum_quantity"];

				$cum_quantity = $cum_quantity-$quantity;

				if($cum_quantity=='0'){ $cum_stockstatus='0'; }else{$cum_stockstatus='1';}

				//echo $cum_quantity.','.$itemcode.'<br>';

				if($cum_quantity>='0')

				{

					$querybatstock2 = "select batch_quantity, auto_number from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcodeget' and fifo_code='$fifo_code' and storecode ='$storecodeget'";

					$execbatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock2) or die ("Error in batQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

					$resbatstock2 = mysqli_fetch_array($execbatstock2);

					$bat_quantity = $resbatstock2["batch_quantity"];

					$auto_num1 = $resbatstock2["auto_number"];

					$quantity = intval($quantity);

					$bat_quantity = $bat_quantity-$quantity;

					$bat_quantity = intval($bat_quantity);

					

				//	echo $bat_quantity.','.$itemcode.'<br>';

					if($bat_quantity=='0'){ $batch_stockstatus='0'; }else{$batch_stockstatus='1';}

					if($bat_quantity>='0')

					{

						$querycheckbat = "select auto_number from transaction_stock where itemcode='$itemcode' and locationcode='$locationcodeget' and fifo_code='$fifo_code' and storecode ='$storecodeget' and auto_number > '$auto_num1'";

						$execcheckbat= mysqli_query($GLOBALS["___mysqli_ston"], $querycheckbat) or die ("Error in checkbat".mysqli_error($GLOBALS["___mysqli_ston"]));

						$num252 = mysqli_num_rows($exec251);

						if($num252 == 0){

							

						$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' ,batch_stockstatus='0' where itemcode='$itemcode' and locationcode='$locationcodeget' and storecode='$storecodeget' and fifo_code='$fifo_code'";

						$execupdatebatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatebatstock2) or die ("Error in updatebatQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

						

						$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$itemcode' and locationcode='$locationcodeget'";

						$execupdatebatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatebatstock2) or die ("Error in updatebatQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

						

						$stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,

						batchnumber, batch_quantity, 

						transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,patientcode,patientvisitcode,patientname,rate,totalprice,ledgeranum,ledgercode,ledgername,incomeledger,incomeledgercode,inventoryledgercode,inventoryledgername)

						values ('$fifo_code','pharmacysales_details','$itemcode', '$medicinename', '$dateonly','0', 'Sales', 

						'$batch', '$bat_quantity', '$quantity', 

						'$cum_quantity', '$docnumber', '','$cum_stockstatus','$batch_stockstatus', '$locationcodeget','','$storecodeget', '', '$username', '$ipaddress','$dateonly','$timeonly','$datetimeonly','$patientcode','$visitcode','$patientname','$costprice','$totalcp','$ledgeranum','$ledgercode','$ledgername','$incomeledger','$incomeledgercode','$inventoryledgercode','$inventoryledgername')";

						

						$stockexecquery2=mysqli_query($GLOBALS["___mysqli_ston"], $stockquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

						

						$query32 = "insert into pharmacysales_details(fifo_code,itemname,itemcode,quantity,rate,totalamount,batchnumber,companyanum,patientcode,visitcode,patientname,financialyear,username,ipaddress,entrydate,accountname,docnumber,entrytime,location,store,instructions,categoryname,route,locationname,locationcode,ledgeranum,ledgercode,ledgername,incomeledger,incomeledgercode,inventoryledgercode,inventoryledgername,costprice,totalcp)

						values('$fifo_code','$medicinename','$itemcode','$quantity','$rate','$amount','$batch','$companyanum','$patientcode','$visitcode','$patientname','$financialyear','$username','$ipaddress','$dateonly','$accountname','$docnumber','$timeonly','$location1','".$storecodeget."','$instructions','$categoryname','$route','".$locationnameget."','".$locationcodeget."','$ledgeranum','$ledgercode','$ledgername','$incomeledger','$incomeledgercode','$inventoryledgercode','$inventoryledgername','$costprice','$totalcp')";

						$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

						

					    $issuestatus = 'pending';

						if($pending == '')

						{

						$issuestatus = 'completed';

				

						}

						mysqli_query($GLOBALS["___mysqli_ston"], "update master_consultationpharmissue set quantity='$pending',docnumber='$docnumber' where medicinecode='$itemcode' and patientvisitcode='$visitcode' and consultation_id='$consid1' and auto_number='$pharmano'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));

						mysqli_query($GLOBALS["___mysqli_ston"], "update master_consultationpharm set medicineissue='$issuestatus',docnumber='$docnumber' where medicinecode='$itemcode' and patientvisitcode='$visitcode' and consultation_id='$consid1' and auto_number='$pharmano'");

						}

					}

					else

					{

						exit;

					}

				}

				else

				{

					exit;

				}

				

			header("location:pharmacylist1.php");

			}

		}

		if($pending == '')

		{

		

		//mysql_query("update master_consultationpharm set medicineissue='completed',docnumber='$docnumber' where medicinecode='$itemcode' and patientvisitcode='$visitcode'");

		}

		}
		else{
           echo '<script> alert("Some item faild to issue/already issued, please check again"); window.location="pharmacylist1.php";</script>';
	       exit;
		}

	}

	

	foreach($_POST['pending2'] as $key => $value)

	{

		$pending2=$_POST['pending2'][$key];

		$medicinename2=$_POST['medicinename2'][$key];
		$pharmano=$_POST['pharmano'][$key];	
		

		if($pending2 == '')

		{

			mysqli_query($GLOBALS["___mysqli_ston"], "update master_consultationpharm set medicineissue='completed',docnumber='$docnumber' where medicinename='$medicinename2' and patientvisitcode='$visitcode' and auto_number='$pharmano'");

		}		

	}	

	



	//header("location:pharmacylist1.php?patientcode=$patientcode&&visitcode=$visitcode&&billnumber=$docnumber");

	exit();

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

<script type="text/javascript" src="js/disablebackenterkey.js"></script>

<script src="js/datetimepicker_css.js"></script>

<?php

$query65= "select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";

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

$paynowbillprefix = 'OPPI-';

$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from pharmacysales_details where patientcode <> 'walkin' and ipdocno='' order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["docnumber"];

$billdigit=strlen($billnumber);

if ($billnumber == '')

{

	$billnumbercode ='OPPI-'.'1';

	$openingbalance = '0.00';

}

else

{

	$billnumber = $res2["docnumber"];

	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

	$billnumbercode;

	$billnumbercode = intval($billnumbercode);

	$billnumbercode = $billnumbercode + 1;



	$maxanum = $billnumbercode;

	

	

	$billnumbercode = 'OPPI-' .$maxanum;

	$openingbalance = '0.00';

	//echo $companycode;

}

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
var confirm1=confirm("Do you want to save?");
if(confirm1 == false) 
{
  return false;
}	
return true;
}
</script>   

<body onLoad="return funcOnLoadBodyFunctionCall();">

<form name="frmsales" id="frmsales" method="post" action="pharmacy1.php" onKeyDown="return disableEnterKey(event)" onSubmit="document.getElementById('subbutton').disabled=true">

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

                <td align="left" valign="middle" class="bodytext3"><strong>Store</strong></td>           

                <td align="left" valign="middle" class="bodytext3"> 

				<select name="store" id="store" onChange="return Redirect('<?php echo $patientcode; ?>','<?php echo $visitcode; ?>','<?php echo $locationcode; ?>')">

				<?php if($storecode != '') { ?>

				<option value="<?php echo $storecode; ?>"><?php echo $store; ?></option>

				<?php } ?>

				<?php 

				$query9 = "select * from master_employeelocation where username = '$username' and locationcode = '$locationcode'";

				$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

				while($res9 = mysqli_fetch_array($exec9))

				{

				$res9anum = $res9['storecode'];

				$res9default = $res9['defaultstore'];

				

				$query10 = "select * from master_store where auto_number = '$res9anum'";

				$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));

				$res10 = mysqli_fetch_array($exec10);

				$res10storecode = $res10['storecode'];

				$res10store = $res10['store'];

				$res10anum = $res10['auto_number'];

				?>

				<option value="<?php echo $res10storecode; ?>"><?php echo $res10store; ?></option>

				<?php } ?>

				</select>

				 </td>           

				  </tr>

				  <tr>
				  		<td width="9%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>&nbsp;</strong></td>
				  </tr>

				  <?php  if($iscapitation_f=='1'){  ?>
				  <tr>
         				<td  colspan="6">
			        	 	<p style="color: red; text-align: justify; padding-bottom: 6px;"><b>Capitation Account, Please Inform client about no Refunds on the Medicine after Issue.</b></p>
						</td>
				  </tr>
				<?php   }   ?>
            </tbody>
        </table></td>
      </tr>
       <?php
	 include_once("store_stocktaking_chk1.php");
	 if($num_stocktaking > 0) {
	  ?>
	  <tr><td colspan="7" class="bodytext3"><font color='red' size='6px'><strong><?php echo $stocktake_err;?></strong></font></td></tr>
	  <?php
	 }else{
	 ?>

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

				<td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Batch.No</strong></div></td>

                <td width="9%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Avl.Qty</strong></div></td>

						<td width="9%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Iss.Qty</strong></div></td>

				<td width="9%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Route</strong></div></td>

				<td width="16%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Instructions</strong></div></td>

				<td width="9%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Pending.Qty</strong></div></td>

				<td width="8%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"></div></td>

			      </tr>

				  		<?php

			$colorloopcount = '';

			$sno = '';

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

			$query61 = "select * from master_consultationpharmissue where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and recordstatus <>'deleted' and quantity <> '$zero' and paymentstatus='completed' and amendstatus='2' and refund='' and store='$storecode' ";

}

else

{

			$query61 = "select * from master_consultationpharmissue where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and recordstatus <>'deleted' and quantity <> '$zero' and paymentstatus='completed' and amendstatus='2' and refund='' and store='$storecode' ";

}

$sno=1;

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

			$pharmano = $res61['auto_number'];

			

$query49="select * from master_itempharmacy where itemname='$res1medicinename'";

$res49=mysqli_query($GLOBALS["___mysqli_ston"], $query49);

$nummm=mysqli_num_rows($res49);

$exec49=mysqli_fetch_array($res49);

if($itemcode == '')

{

$itemcode=trim($exec49['itemcode']);

}



if((($excludestatus == '')&&($excludebill == ''))||(($excludestatus == 'excluded')&&($excludebill == 'completed')))

			{

		

		

$query77 = "select itemcode,batchnumber,batch_quantity,description,fifo_code,expirydate  from (select a.itemcode as itemcode,a.batchnumber as batchnumber,a.batch_quantity as batch_quantity,a.description as description,a.fifo_code as fifo_code,b.expirydate as expirydate  from transaction_stock a join materialreceiptnote_details b on (a.batchnumber = b.batchnumber and a.itemcode = b.itemcode) where a.storecode='".$storecode."' AND a.locationcode='".$locationcode."' AND a.itemcode = '$itemcode' and a.batch_stockstatus='1' and b.expirydate >now()

			UNION ALL select a.itemcode as itemcode,a.batchnumber as batchnumber,a.batch_quantity as batch_quantity,a.description as description,a.fifo_code as fifo_code,b.expirydate as expirydate from transaction_stock a join purchase_details b on (a.batchnumber = b.batchnumber and a.itemcode = b.itemcode) where a.storecode='".$storecode."' AND a.locationcode='".$locationcode."' AND a.itemcode = '$itemcode' and a.batch_stockstatus='1' and b.expirydate >now()) as batchl group by fifo_code order by expirydate ASC";

//$query77 = "select * from purchase_details where itemcode='$itemcode' AND locationcode = '".$locationcode."' AND store = '".$storecode."'";

//echo $query57;

$res77=mysqli_query($GLOBALS["___mysqli_ston"], $query77);

$num77=mysqli_num_rows($res77);

//echo $num77;

while($exec77 = mysqli_fetch_array($res77))

{

 $batchname = $exec77['batchnumber']; 

//echo $batchname;

$companyanum = $_SESSION["companyanum"];

			$itemcode = $itemcode;

			$batchname = $batchname;

			

$currentstock = $exec77["batch_quantity"];

$itemcode = $itemcode;

$batchname = $batchname;

$description = $exec77["description"];

$fifo_code = $exec77["fifo_code"];

	//include ('autocompletestockbatch.php');

	$currentstock = $currentstock; 

	$totalst=$totalst+$currentstock;

	//echo $totalst;

	}

	//echo $totalst;

if($totalst == 0)

{

?>

  <tr >

  <td class="bodytext31" valign="center"  align="left"><div align="center">

        <input type="checkbox" disabled name="ref1[]" id="ref<?php echo $sno; ?>" value="<?php echo $sno; ?>" onClick="return checkboxcheck1"/></div></td>

		<td class="bodytext31" valign="center"  align="left" style='COLOR:red'><div align="center"><?php echo $res1medicinename;?></div></td>

	

    	<td class="bodytext31" valign="center"  align="left" style='COLOR:red'><div align="center"><?php echo $res1frequency;?></div></td>

		<td class="bodytext31" valign="center"  align="left" style='COLOR:red'><div align="center"><?php echo $res1days;?></div></td>



		<td class="bodytext31" valign="center"  align="left" style='COLOR:red'><div align="center"><?php echo $res1dose;?></div></td>

		<td class="bodytext31" valign="center"  align="left" style='COLOR:red'><div align="center"><?php echo $dosemeasure;?></div></td>





		<td class="bodytext31" valign="center"  align="left" style='COLOR:red'><div align="center"><?php echo $res3quantity;?></div></td>

	

    	

		<td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>

        <td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>

		<td class="bodytext31" valign="center"  align="left" style='COLOR:red'><div align="center"><?php echo $res1route;?></div></td>

			<td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>

		<td class="bodytext31" valign="center"  align="left" style='COLOR:red'><div align="center"><?php echo $res1quantity;?></div></td>

		 <td class="bodytext31" valign="center"  align="center">

                 <input type="hidden" name="pending2[]" value="<?php echo $res1quantity;?>">
				 <input type="hidden" name="pharmano[]" value="<?php echo $pharmano;?>">				 

				  <input type="hidden" name="medicinename2[]" value="<?php echo $res1medicinename;?>"></td>

				</tr>



<?php

}

else

{

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

$query35=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_itempharmacy where itemname='$res1medicinename'");

$exec35=mysqli_fetch_array($query35);

if($itemcode == '')

{

$itemcode=$exec35['itemcode'];

}



 $query57 = "select itemcode,batchnumber,batch_quantity,description,fifo_code,expirydate  from (select a.itemcode as itemcode,a.batchnumber as batchnumber,a.batch_quantity as batch_quantity,a.description as description,a.fifo_code as fifo_code,b.expirydate as expirydate  from transaction_stock a join materialreceiptnote_details b on (a.batchnumber = b.batchnumber and a.itemcode = b.itemcode) where a.storecode='".$storecode."' AND a.locationcode='".$locationcode."' AND a.itemcode = '$itemcode' and a.batch_stockstatus='1' and b.expirydate >now()

			UNION ALL select a.itemcode as itemcode,a.batchnumber as batchnumber,a.batch_quantity as batch_quantity,a.description as description,a.fifo_code as fifo_code,b.expirydate as expirydate from transaction_stock a join purchase_details b on (a.batchnumber = b.batchnumber and a.itemcode = b.itemcode) where a.storecode='".$storecode."' AND a.locationcode='".$locationcode."' AND a.itemcode = '$itemcode' and a.batch_stockstatus='1' and b.expirydate >now()) as batchl group by fifo_code order by expirydate ASC";

//echo $query57;

$res57=mysqli_query($GLOBALS["___mysqli_ston"], $query57);

$num57=mysqli_num_rows($res57);

//echo $num57;

while($exec57 = mysqli_fetch_array($res57))

{

if($loopcontrol != 'stop')

{

$batchname = $exec57['batchnumber']; 

//echo $batchname;

$companyanum = $_SESSION["companyanum"];

$currentstock = $exec57["batch_quantity"];

$fifo_code = $exec57["fifo_code"];

			$itemcode = $itemcode;

			$batchname = $batchname;

	//include ('autocompletestockbatch.php');

	 $currentstock = $currentstock;

	//echo $currentstock;

	if($currentstock > 0 )

	{

  $totalstock = $totalstock+$currentstock;

if($totalstock >= $res1quantity)

{



 $issuequantity = $res1quantity-$oldstock;

  $pending='';

}

 else

 {

 $issuequantity = $currentstock;

 $oldstock = $oldstock+$currentstock;



 $pending=$res1quantity-$oldstock;



 }	

 $res1medicinename1=$res1medicinename;

 if($oldmedicinename == $res1medicinename)

 {

 //$res1medicinename1='';

 $res1dose='';

 $res1frequency='';

 $res1days='';

 $pending='';

 

 }

 $oldmedicinename=$res1medicinename;

 ?>

			  <tr>

              <td class="bodytext31" valign="center"  align="left"><div align="center">

        <input type="checkbox" name="ref[<?php echo $sno; ?>]" id="ref<?php echo $sno; ?>" checked value="<?php echo $sno; ?>"/>

        </div></td>

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1medicinename1;?></div></td>

			 <input type="hidden" name="medicine[<?php echo $sno; ?>]" value="<?php echo $res1medicinename;?>" />

			 <input type="hidden" name="itemcode[<?php echo $sno; ?>]" value="<?php echo $itemcode; ?>" />

             <input type="hidden" name="consid[<?php echo $sno; ?>]" value="<?=$consid;?>">

             <input type="hidden" name="fifo_code[<?php echo $sno; ?>]" value="<?php echo $fifo_code; ?>" />

             

					    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1frequency;?></div></td>

			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1days;?></div></td>



			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1dose;?></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $dosemeasure;?></div></td>





			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res3quantity;?></div></td>

			 <input type="hidden" name="quantity[<?php echo $sno; ?>]" value="<?php echo $res1quantity;?>" />



			 	 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $batchname;?></div></td>

					 <input type="hidden" name="batch[<?php echo $sno; ?>]" value="<?php echo $batchname;?>" />

				<input type="hidden" name="rate[<?php echo $sno; ?>]" value="<?php echo $res1rate;?>" />

				<input type="hidden" name="pending1[<?php echo $sno; ?>]" value="<?php echo $pending; ?>">

                 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $currentstock;?></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $issuequantity;?></div></td>

				 <input type="hidden" name="amount[<?php echo $sno; ?>]" value="<?php echo $res1amount;?>" />

				 <input type="hidden" name="issue[<?php echo $sno; ?>]" value="<?php echo $issuequantity;?>">

				 			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1route;?></div></td>

			 <input type="hidden" name="route[<?php echo $sno; ?>]" value="<?php echo $res1route;?>" />

			 <input type="hidden" name="pharmano[<?php echo $sno; ?>]" value="<?php echo $pharmano;?>">

		

			 	 <td class="bodytext31" valign="center"  align="left"> <input type="text" name="instructions[<?php echo $sno; ?>]" value="<?php echo $instructions ;?>" size="25" align="absmiddle"></div></td>

                 <input type="hidden" name="currentstock" value="<?php echo $currentstock;?>">

				 	 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pending; ?></div></td>

				 <td class="bodytext31" valign="center"  align="center">

                 <input type="hidden" name="pending" value="<?php echo $pending; ?>"></td>

				  	</tr>

			<?php 
            $sno=$sno+1;
			if($totalstock >= $res1quantity)

			{

			$loopcontrol = 'stop';

			}

		

			}

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

                bgcolor="#ecf0f5">&nbsp;</td>

               <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" colspan="2" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

                <td class="bodytext31" colspan="2" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

                <td class="bodytext31" colspan="2" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

       

             </tr>

           

          </tbody>

        </table>		</td>

      </tr>

      

      

      

      <tr>

        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

		    <tr>
			<td  valign="top" class="bodytext31">
			<strong>Note:
		     <p style='color:red'>&nbsp;&nbsp;&nbsp;&nbsp;The items marked in RED are not having stock. Pl note these will not save to database.</p></strong>
		   </td>
		  </tr>

            <tr>

              <td width="54%" align="right" valign="top" >

                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">

             	  <input name="Submit2223" type="submit" id="subbutton" onClick="return saveValid()" value="Save " accesskey="b" class="button" />

               </td>

              

            </tr>
 <?php
            if($billtype=='PAY NOW'){
            ?>
            <tr>
			<td  valign="top">
		
		     <p style='color:red;font-size:17px'><b>&nbsp;&nbsp;&nbsp;&nbsp;Please verify the Cash Receipt Before issue of Drugs.</b></p>
		   </td>
		  </tr>
	<?php }	  ?>
          </tbody>

        </table></td>

      </tr>
     <?php } ?>
    </table>

  </table>



</form>

<?php include ("includes/footer1.php"); ?>

<?php //include ("print_bill_dmp4inch1.php"); ?>

</body>

</html>


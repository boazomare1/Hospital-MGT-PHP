<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");


$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$dateonly = date("Y-m-d");

$timeonly = date("H:i:s");

$datetimeonly = date("Y-m-d H:i:s");

$query23 = "select * from master_employee where username='$username'";

$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res23 = mysqli_fetch_array($exec23);

$res7locationanum = $res23['location'];



$query55 = "select * from master_location where auto_number='$res7locationanum'";

$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res55 = mysqli_fetch_array($exec55);

$location = $res55['locationname'];





$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$searchsuppliername = "";

$cbsuppliername = "";







$docno = $_SESSION['docno'];

$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

	

	 $locationname  = $res["locationname"];

	 $locationcode = $res["locationcode"];

	 $res12locationanum = $res["auto_number"];

	 

  $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';

  if($locationcode!='')

  {

  $query4 = "select locationname,locationcode from master_location where locationcode = '$locationcode'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res4 = mysqli_fetch_array($exec4);

	  $locationnameget = $res4['locationname'];

	  $locationcodeget = $res4['locationcode'];

  }

   $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

   $storecode=isset($_REQUEST['store'])?$_REQUEST['store']:'';

//This include updatation takes too long to load for hunge items database.





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



if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{



	$searchsuppliername = $_POST['medicinename'];

	//echo $searchsuppliername;

	if ($searchsuppliername != '')

	{

		$arraysupplier = explode("||", $searchsuppliername);

		$arraysuppliercode = $arraysupplier[0];

		$arraysuppliername = $arraysupplier[1];

		$arraysuppliername = trim($arraysuppliername);

		

		

		$query1 = "select * from master_supplier where suppliercode = '$arraysuppliercode'";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res1 = mysqli_fetch_array($exec1);

		$supplieranum = $res1['auto_number'];

		$openingbalance = $res1['openingbalance'];



		$cbsuppliername = $arraysuppliername;

		$suppliername = $arraysuppliername;

	}

	else

	{

		$cbsuppliername = $_REQUEST['cbsuppliername'];

		$suppliername = $_REQUEST['cbsuppliername'];

	}



	//$transactiondatefrom = $_REQUEST['ADate1'];

	//$transactiondateto = $_REQUEST['ADate2'];



}



if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

//$frmflag2 = $_POST['frmflag2'];



if ($frmflag2 == 'frmflag2')

{

	

	

	

    $itemname=$_REQUEST['itemname'];

	$itemcode=$_REQUEST['itemcode'];

	$remarks=$_REQUEST['remarks'];

	$storecode = $store=$_REQUEST['storename'];

	include("store_stocktaking_chk1.php");
		  if($num_stocktaking > 0) {
		   echo "<script>history.back();</script>";
		   exit;

		}

	$adjustmentdate=date('Y-m-d');

	

			$query31 = "select * from master_itempharmacy where itemcode = '$itemcode'"; 

			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res31 = mysqli_fetch_array($exec31);

			$categoryname = $res31['categoryname'];



$paynowbillprefix = 'ADJ-';

$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from master_stock where transactionmodule = 'ADJUSTMENT' order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["billnumber"];

$billdigit=strlen($billnumber);

if ($billnumber == '')

{

	$billnumbercode ='ADJ-'.'1';

	$openingbalance = '0.00';

}

else

{

	$billnumber = $res2["billnumber"];

	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

	//echo $billnumbercode;

	$billnumbercode = intval($billnumbercode);

	$billnumbercode = $billnumbercode + 1;



	$maxanum = $billnumbercode;

	

	

	$billnumbercode = 'ADJ-'.$maxanum;

	$openingbalance = '0.00';

	//echo $companycode;

}

 $locationcodenew=isset($_REQUEST['locationcodenew'])?$_REQUEST['locationcodenew']:'';

			$query31 = "select locationname from master_location where locationcode = '$locationcodenew'"; 

			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res31 = mysqli_fetch_array($exec31);

			$locationnamenew = $res31['locationname'];

	foreach($_POST['batch'] as $key => $value)

		{

		$batchnumber=$_POST['batch'][$key];

		$batchnumber = str_replace(" ","",$batchnumber);

		$batchnumber = trim($batchnumber);

		$addstock=$_POST['addstock'][$key];

		$minusstock=$_POST['minusstock'][$key];

		$fifo_code=$_POST['fifo_code'][$key];

		//$query40 = "select * from master_itempharmacy where itemcode = '$itemcode'";

		$query40 = "select rate  from transaction_stock where batch_stockstatus='1' and batchnumber='$batchnumber' and itemcode='$itemcode' and locationcode='$locationcodenew' and storecode='$store' and fifo_code='$fifo_code' limit 0,1";
		
	$exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die ("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res40 = mysqli_fetch_array($exec40);

	//$itemmrp = $res40['rateperunit'];
	$itemmrp = $res40['rate'];



	

	//$itemsubtotal = $itemmrp * $addstock;

	

		if($addstock != '')

		{

			$itemsubtotal = $itemmrp * $addstock;

		$querybatstock2 = "select batch_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcodenew' and fifo_code='$fifo_code' and storecode ='$store'";

		$execbatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock2) or die ("Error in batQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$resbatstock2 = mysqli_fetch_array($execbatstock2);

		$bat_quantity = $resbatstock2["batch_quantity"];

		$bat_quantity = $bat_quantity+$addstock;

		if($bat_quantity<='0'){ $batch_stockstatus='0'; }else{$batch_stockstatus='1';}

		

		$querycumstock2 = "select cum_quantity from transaction_stock where cum_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcodenew'";

		$execcumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querycumstock2) or die ("Error in CumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$rescumstock2 = mysqli_fetch_array($execcumstock2);

		$cum_quantity = $rescumstock2["cum_quantity"];

		$cum_quantity = $cum_quantity+$addstock;

		if($cum_quantity<='0'){ $cum_stockstatus='0'; }else{$cum_stockstatus='1';}

		if(1)

		{

		if($bat_quantity>='0')

		{

		$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' ,batch_stockstatus='0' where itemcode='$itemcode' and locationcode='$locationcodenew' and storecode='$store' and fifo_code='$fifo_code'";

		$execupdatebatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatebatstock2) or die ("Error in updatebatQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

		

		$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$itemcode' and locationcode='$locationcodenew'";

		$execupdatebatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatebatstock2) or die ("Error in updatebatQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

			

		$stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,

			batchnumber, batch_quantity, 

			transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice)

			values ('$fifo_code','master_stock','$itemcode', '$itemname', '$dateonly','1', 'Stock Adj Add Stock', 

			'$batchnumber', '$bat_quantity', '$addstock', 

			'$cum_quantity', '$billnumbercode', '','$cum_stockstatus','$batch_stockstatus', '$locationcodenew','','$store', '', '$username', '$ipaddress','$dateonly','$timeonly','$datetimeonly','$itemmrp', '$itemsubtotal')";

			

		$stockexecquery2=mysqli_query($GLOBALS["___mysqli_ston"], $stockquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		

		$query65="insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 

	transactionparticular,  billnumber, quantity, remarks, 

	 username, ipaddress, rateperunit, totalrate, companyanum, companyname,batchnumber,location,store,categoryname,locationname,locationcode)

	values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 

	'BY ADJUSTMENT ADD',  '$billnumbercode', '$addstock', '$remarks', 

	'$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname','$batchnumber','$location','$store','$categoryname','".$locationnamenew."','".$locationcodenew."')";

	$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		}

		}

		}

		else if($minusstock != '')

		{

			

		$stockaction=$_REQUEST["stockaction"];

		

				if($stockaction=='1')

				{

					$description='Stock Adj Minus Stock';

				}

				else if($stockaction=='2')

				{

					$description='Stock Damaged Minus Stock';

				}

				else if($stockaction=='3')

				{

					$description='Stock Expired Minus Stock';

				}

				$itemsubtotal = $itemmrp * $minusstock;

		

		$querybatstock2 = "select batch_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcodenew' and fifo_code='$fifo_code' and storecode ='$store'";

		$execbatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock2) or die ("Error in batQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$resbatstock2 = mysqli_fetch_array($execbatstock2);

		$bat_quantity = $resbatstock2["batch_quantity"];

		$bat_quantity = $bat_quantity-$minusstock;

		

		$querycumstock2 = "select cum_quantity from transaction_stock where cum_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcodenew'";

		$execcumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querycumstock2) or die ("Error in CumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

		$rescumstock2 = mysqli_fetch_array($execcumstock2);

		$cum_quantity = $rescumstock2["cum_quantity"];

		$cum_quantity = $cum_quantity-$minusstock;

		if($cum_quantity<='0'){ $cum_stockstatus='0'; }else{$cum_stockstatus='1';}

		if($bat_quantity<='0'){ $batch_stockstatus='0'; }else{$batch_stockstatus='1';}

		if(1)

		{

		if($bat_quantity>='0')

		{

		$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' ,batch_stockstatus='0' where itemcode='$itemcode' and locationcode='$locationcodenew' and storecode='$store' and fifo_code='$fifo_code'";

		$execupdatebatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatebatstock2) or die ("Error in updatebatQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

		

		$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$itemcode' and locationcode='$locationcodenew'";

		$execupdatebatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatebatstock2) or die ("Error in updatebatQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

			

		$stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,

			batchnumber, batch_quantity, 

			transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice)

			values ('$fifo_code','master_stock','$itemcode', '$itemname', '$dateonly','0', '$description', 

			'$batchnumber', '$bat_quantity', '$minusstock', 

			'$cum_quantity', '$billnumbercode', '','$cum_stockstatus','$batch_stockstatus', '$locationcodenew','','$store', '', '$username', '$ipaddress','$dateonly','$timeonly','$datetimeonly','$itemmrp', '$itemsubtotal')";

			

		$stockexecquery2=mysqli_query($GLOBALS["___mysqli_ston"], $stockquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		

	 	$query65="insert into master_stock (fifo_code,itemcode, itemname, transactiondate, transactionmodule, 

	transactionparticular,  billnumber, quantity, remarks, 

	 username, ipaddress, rateperunit, totalrate, companyanum, companyname,batchnumber,location,store,categoryname,locationname,locationcode,description)

	values ('$fifo_code','$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 

	'BY ADJUSTMENT MINUS', '$billnumbercode', '$minusstock', '$remarks', 

	'$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname','$batchnumber','$location','$store','$categoryname','".$locationnamenew."','".$locationcodenew."','$description')";

	$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			}

			else

			{

	

	 $emptybatch.=$batchnumber.',';

		 $itemnamenew.=$itemname.',';

	

	

			}

			}

	 $batchnumber13=$emptybatch;

		 $itmename13=$itemnamenew;

		 	}

		}$batchnumber13;

		$itmename13;

	header("location:stockadjustment.php?batch=$batchnumber13&&itemname=$itmename13");

	exit;

	

}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if (isset($_REQUEST["batch"])) {  $batch = $_REQUEST["batch"]; } else { $batch = ""; }

if (isset($_REQUEST["itemname"])) {  $itemname = $_REQUEST["itemname"]; } else { $itemname = ""; }

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





.modal {

    display:    none;

    position:   fixed;

    z-index:    1000;

    top:        0;

    left:       0;

    height:     100%;

    width:      100%;

    background: rgba( 255, 255, 255, .8 ) 

                url('http://i.stack.imgur.com/FhHRx.gif') 

                50% 50% 

                no-repeat;

}



/* When the body has the loading class, we turn

   the scrollbar off with overflow:hidden */

body.loading {

    overflow: hidden;   

}



/* Anytime the body has the loading class, our

   modal element will be visible */

body.loading .modal {

    display: block;

}



</style>



<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />



<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>



<link rel="stylesheet" type="text/css" href="css/autocomplete.css">

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />



<?php //include("autocompletebuild_med.php"); ?><!--

<script type="text/javascript" src="js/autosuggestmed.js"></script> 

<script type="text/javascript" src="js/autocomplete_med.js"></script> -->

<script type="text/javascript" src="js/datetimepicker_css.js"></script>

<!--<script type="text/javascript" src="js/autosuggest1itemstock2.js"></script>

<script type="text/javascript" src="js/autocomplete_item1pharmacy4.js"></script>-->



<script language="javascript">



$body = $("body");



/* $(document).on({

	

    ajaxStart: function() { $body.addClass("loading");

	//alert('hai');

	    },

     ajaxStop: function() { $body.removeClass("loading"); }    

}); */



function number(event)

{

	var charcode=(event.which)?event.which:event.keycode

	if(charcode>31 && (charcode<47 || charcode >57))

	{

		return false;

	}

		return true;

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





function cbsuppliername1()

{

	document.cbform1.submit();

}



window.onload = function () 

{

	var oTextbox = new AutoSuggestControl(document.getElementById("medicinename"), new StateSuggestions());        

}







</script>



<script type="text/javascript">





function disableEnterKey(varPassed)

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

	

	var key;

	if(window.event)

	{

		key = window.event.keyCode;     //IE

	}

	else

	{

		key = e.which;     //firefox

	}



	if(key == 13) // if enter key press

	{

		//alert ("Enter Key Press2");

		return false;

	}

	else

	{

		return true;

	}

}





function process1backkeypress1()

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

}



function disableEnterKey()

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

	

	var key;

	if(window.event)

	{

		key = window.event.keyCode;     //IE

	}

	else

	{

		key = e.which;     //firefox

	}

	

	if(key == 13) // if enter key press

	{

		return false;

	}

	else

	{

		return true;

	}



}



function paymententry1process2()

{

	if (document.getElementById("location").value == "")

	{

		alert ("Please Select Location");

		document.getElementById("location").focus();

		return false;

	}

	if (document.getElementById("store").value == "")

	{

		alert ("Please Select Store");

		document.getElementById("store").focus();

		return false;

	}

	

	if (document.getElementById("medicinename").value == "")

	{

		alert ("Enter The Medicine Name");

		document.getElementById("medicinename").focus();

		return false;

	}

	

	//if(confirm("Are You Want To Save The Record?")==false){return false;}

}





function funcPrintReceipt1()

{

	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

}



//ajax function to get store for corrosponding location

function storefunction(loc)

{

	var username=document.getElementById("username").value;

	

var xmlhttp;



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

    document.getElementById("store").innerHTML=xmlhttp.responseText;

    }

  }

xmlhttp.open("GET","ajax/ajaxstore.php?loc="+loc+"&username="+username,true);

xmlhttp.send();



	}

	

	function functioncheklocationandstock()

	{

		if(document.getElementById("location").value=='')

		{

		alert('Please Select Location!');

		document.getElementById("location").focus();

		return false;

		}

		if(document.getElementById("store").value=='')

		{

		alert('Please Select Store!');

		document.getElementById("store").focus();

		return false;

		}

	}

	



	function stockactionchange(obj,sno11)

	{

		var id11='addstock'+sno11;

		var id12='minusstock'+sno11;

		document.getElementById(id11).value='';

		document.getElementById(id12).value='';

		if(obj.value==1)

		{

		document.getElementById(id11).readOnly = false;

		document.getElementById(id12).readOnly = false;

		}

		else if(obj.value==2)

		{

			document.getElementById(id11).readOnly = true;

			document.getElementById(id12).readOnly = false;

		}

		else if(obj.value==3)

		{

			document.getElementById(id11).readOnly = true;

			document.getElementById(id12).readOnly = false;

		}

		else

		{

			document.getElementById(id11).readOnly = true;

			document.getElementById(id12).readOnly = true;

		}

	}

</script>



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

</style>

</head>

<script >

$(document).ready(function(e) {

	$('#medicinename').autocomplete({

		

	source:"ajaxautosearchitempharmcy.php",		// by Kenique 27 Nov 2018

	//alert(source);

	matchContains: true,

	minLength:1,

	html: true, 

		select: function(event,ui){

			var citemnamevalue=ui.item.value;

			var citemname=ui.item.citemname;

			var citemcode=ui.item.citemcode;

			$("#searchitem1hiddentextbox").val(citemnamevalue);

			$("#cbsuppliername").val(citemname);

			$("#searchsuppliercode").val(citemcode);

			

			},

	});	

});

function storechk(store){

 if(store!=''){
    var loc =document.getElementById("location").value;

	$.ajax({
	type : "get",
	url : "store_stocktaking_chk.php?storecode="+store+"&locationcode="+loc,
	catch : false,
	success : function(data){
		if(data==1){
			alert("Stock Take in process. Transactions are Frozen.");	
			$("#store").val("");
		}
	}
	});
 }

}

</script>





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

		

		

              <form name="cbform1" method="post" action="stockadjustment.php" onSubmit="return paymententry1process2()">

		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="1" bgcolor="#ecf0f5" class="bodytext3"><strong>Stock Adjustment </strong></td>

               <td colspan="3" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>

           

             

             

             

             

            

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

                </tr>

               <?php

    

     if ( $batch != '') 

	{

		

	 $batchnew=trim($batch);

	$itemnamene=trim($itemname);

	

	  $batchnum=explode(',', $batchnew);

	 $itemnamesp=explode(',', $itemnamene);

		

	 for($i = 0; $i < (count($batchnum)-1); $i++){

	

	?>

     <tr  >

        <td colspan="4" style=" background-color: #F96" width="20%" ><?php echo $errmsg = "Failed. These Batch No ".$batchnum[$i].' , Item Name '. $itemnamesp[$i]." Transaction Not Done. <br />"; ?></td>

       

        

      </tr>

	 



<?php

	}



}

?>         

       

            <tr>

              <td align="left" valign="middle" bgcolor="#FFFFFF"   class="bodytext3"><strong>Location</strong></td>

              <td   class="bodytext3"  colspan="3" bgcolor="#FFFFFF"><select name="location" id="location"  style="border: 1px solid #001E6A;" onChange="storefunction(this.value); ajaxlocationfunction(this.value);">

              <option value="">Select</option>

                  <?php

						

						$query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

						$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res = mysqli_fetch_array($exec))

						{

						$reslocation = $res["locationname"];

						$reslocationanum = $res["locationcode"];

						?>

						<option value="<?php echo $reslocationanum; ?>" <?php if($location!='')if($location==$reslocationanum){echo "selected";}?>><?php echo $reslocation; ?></option>

						<?php 

						}

						?>

                  </select></td>

                   

                

                <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">

             

              </tr>

		<tr>

		  <td width="104" align="left" bgcolor="#FFFFFF" valign="center" class="bodytext31"><strong>Store</strong> </td>

          <td width="680" align="left" bgcolor="#FFFFFF" valign="center"  class="bodytext31">

		  <?php  $loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';

 				 $username=isset($_REQUEST['username'])?$_REQUEST['username']:'';

 				 $frmflag1=isset($_REQUEST['frmflag1'])?$_REQUEST['frmflag1']:'';

				 $store=isset($_REQUEST['store'])?$_REQUEST['store']:'';?>  

                 <select name="store" id="store" onChange="storechk(this.value); ">

		   <option value="">-Select Store-</option>

           <?php if ($frmflag1 == 'frmflag1')

{$loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';

$username=isset($_REQUEST['username'])?$_REQUEST['username']:'';

$query5 = "select ms.auto_number,ms.storecode,ms.store from master_employeelocation as me LEFT JOIN master_store as ms ON me.storecode=ms.auto_number where me.locationcode = '".$loc."' AND me.username= '".$username."'";

				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

				while ($res5 = mysqli_fetch_array($exec5))

				{

				$res5anum = $res5["storecode"];

				$res5name = $res5["store"];

				//$res5department = $res5["department"];

?>

<option value="<?php echo $res5anum;?>" <?php if($store==$res5anum){echo 'selected';}?>><?php echo $res5name;?></option>

<?php }}?>

		  </select>

		  </td>

		</tr>

		<tr>

			<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Drug </td>

			<td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

				<span class="bodytext3">

					<input name="medicinename" type="text" id="medicinename" style="border: 1px solid #001E6A;" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">

					<input type="hidden" name="searchitem1hiddentextbox" id="searchitem1hiddentextbox" size="50">

				</span>

			</td>

			

		</tr>

		

		<tr>

			<td width="18%"  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Drug </td>

			<td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

				<input value="<?php echo $cbsuppliername; ?>" name="cbsuppliername" type="text" id="cbsuppliername" readonly onKeyDown="return disableEnterKey()" size="50" style="border: 1px solid #001E6A"></td>

		</tr>

		

		<tr>

			<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">

				<input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="border: 1px solid #001E6A; text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" />

			</td>

			<td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

				<input type="hidden" name="frmflag1" value="frmflag1">

				<input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

				<input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />

				<input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" />

			</td>

		</tr>

		

	</tbody>

	</table>

	</form>

	</td>

	</tr>

	

	<tr>

		<td>&nbsp;</td>

	</tr>

	

	<tr>

		<td>&nbsp;</td>

	</tr>

	

	<tr>

		<td>&nbsp;</td>

	</tr>

	

	<tr>

		<td>&nbsp;</td>

	</tr>

	

	<tr>

		<td>

			<form name="form1" id="form1" method="post" action="stockadjustment.php" onSubmit="return doSave()" >	

				<input type="hidden" name="locationcodenew" value="<?php echo $location;?>">

<?php

	$colorloopcount=0;

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{



	$searchsuppliername = $_POST['medicinename'];

	//$searchsuppliername;

	if ($searchsuppliername != '')

	{

		$arraysupplier = explode("||", $searchsuppliername);

			$arraysuppliercode = $arraysupplier[0];

		$arraysuppliername = $arraysupplier[1];

		$arraysuppliername = trim($arraysuppliername);

		

		$query1 = "select * from master_supplier where suppliercode = '$arraysuppliercode'";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res1 = mysqli_fetch_array($exec1);

		$supplieranum = $res1['auto_number'];

		$openingbalance = $res1['openingbalance'];



		$cbsuppliername = $arraysuppliername;

		$suppliername = $arraysuppliername;

		$itemcode=$arraysuppliercode;

	}

	else

	{

		$cbsuppliername = $_REQUEST['cbsuppliername'];

		$suppliername = $_REQUEST['cbsuppliername'];

	}

	

?>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 

            align="left" border="0">

          <tbody>

            <tr>

              <td colspan="3" bgcolor="#ecf0f5" class="bodytext311"><strong><?php echo $suppliername; ?></strong></td>

              <td width="6%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>

              <td width="7%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>

              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>

              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>

              <td width="8%" bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td>

           </tr>

            <tr>

              <td width="5%" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ffffff" class="bodytext311"><strong>No.</strong></td>

				  <td width="6%" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ffffff" class="bodytext311"><strong>Medicine Code</strong></td>

              <td width="20%" align="left" valign="center" bordercolor="#f3f3f3" 

                bgcolor="#ffffff" class="bodytext311"><strong>Medicine </strong></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ffffff"><div align="left"><strong>Action </strong></div></td>

                

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ffffff"><div align="left"><strong>Batch </strong></div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ffffff"><div align="left"><strong>Stock </strong></div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ffffff"><div align="left"><strong>Add Stock </strong></div></td>

              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ffffff"><div align="left"><strong>Minus Stock </strong></div></td>

               </tr>

           <?php

             $sno=0;

			 $i=0;

					

			

			$querybatstock2 = "select batch_quantity,fifo_code,batchnumber from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcode' and storecode ='$store'";

			$execbatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock2) or die ("Error in batQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

			while($resbatstock2 = mysqli_fetch_array($execbatstock2))

			{

			$bat_quantity = $resbatstock2["batch_quantity"];

			$batchname = $resbatstock2['batchnumber']; 

			$companyanum = $_SESSION["companyanum"];

			$fifo_code = $resbatstock2["fifo_code"];

			$itemcode = $itemcode;

			//include ('autocompletestockbatch.php');

			$currentstock = $bat_quantity;



			if($currentstock > 0 )

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



			//if ($balanceamount != 0.00)

			//{

			?>

           <tr<?php echo $colorcode; ?>>

		     <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $sno = $sno + 1; ?></td>

			   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $itemcode; ?></td>

				<input type="hidden" name="itemcode" value="<?php echo $itemcode; ?>">

				<input type="hidden" name="storename" value="<?php echo $store; ?>">

                <input type="hidden" name="fifo_code[]" value="<?php echo $fifo_code; ?>">

				 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $suppliername; ?></td>

				 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">

				 <select name="stockaction" onChange="stockactionchange(this,<?php echo $sno;?>)">

                 <option value="">--Select--</option>

                 <option value="1">Stock Adj</option> 

                 <option value="2">Stock Damaged</option>

                 <option value="3">Stock Expired</option>  

                 </select>               

                 </td>

				<input type="hidden" name="itemname" value="<?php echo $suppliername; ?>">

			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $batchname; ?></td>

				<input type="hidden" name="batch[]" id="batch" value="<?php echo $batchname; ?>">

			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $currentstock; ?></td>

			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input type="text" size="6" onKeyPress="return number(event)" name="addstock[]" id="<?php echo 'addstock'.$sno;?>" ></td>

			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input type="text" size="6" name="minusstock[]" onKeyPress="return number(event)" id="<?php echo 'minusstock'.$sno;?>" ></td>

			

		   </tr>

		   <?php 

		   } 

		   }

		   ?>

           

            <tr>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

             

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong>

                <?php //echo number_format($totalpurchaseamount, 2); ?>

              </strong></div></td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong>

                <?php //echo number_format($netpaymentamount, 2); ?>

              </strong></div></td>

              <td class="bodytext311" colspan="2" valign="center" bordercolor="#f3f3f3" align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

      

			</tr>

			<tr>

			<td align="left" valign="middle" class="bodytext3">&nbsp;</td>

			<td align="left" valign="middle" class="bodytext3"><strong>Remarks</strong></td>

			<td align="left" valign="middle" class="bodytext3"><textarea cols="30" name="remarks"></textarea></td>

			</tr>

			<tr>

			

			  <td colspan="7" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right">  <input type="hidden" name="frmflag2" value="frmflag2">

                      <input name="Submit" type="submit"  value="Save" class="button" id="doSaveButton" style="border: 1px solid #001E6A" />

                  </td>

           

			</tr>

          </tbody>

        </table>

<?php

}



?>	

		

		

		

		

		

		</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

	  </form>

    </table>

  </table>

  <script>

  	function doSave(){

		document.getElementById("doSaveButton").disabled = true;

		return true;

	}

  </script>

<?php include ("includes/footer1.php"); ?>



</body>

</html>




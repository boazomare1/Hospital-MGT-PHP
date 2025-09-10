<?php
session_start();
ob_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");


$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$currentdate = date("Y-m-d");

$docno = $_SESSION['docno'];

$query01="select locationcode from login_locationdetails where docno ='$docno' and username='$username' order by auto_number desc";
$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
$res01=mysqli_fetch_array($exc01);
$main_locationcode = $res01['locationcode'];

$query018="select auto_number from master_location where locationcode='$main_locationcode'";
$exc018=mysqli_query($GLOBALS["___mysqli_ston"], $query018);
$res018=mysqli_fetch_array($exc018);
$location_auto = $res018['auto_number'];




 //get location for sort by location purpose

  $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';

	if($locationcode!='')

	{

		  $locationcode=$locationcode;

		}

		else

		{

			$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

	

	 $locationname  = $res["locationname"];

	 $locationcode = $res["locationcode"];

			}

		//location get end here

		 $ADate1=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:'';

		 $ADate2=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:'';

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$st = $_REQUEST['st'];

if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }

//$st = $_REQUEST['st'];

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

if ($frm1submit1 == 'frm1submit1')

{

	$job_title = $_POST['jobtitle'];

	foreach($_POST['docno'] as $key => $value)

	{

		//$key;

		$docno = $_POST['docno'][$key];

		$numb12 = $_POST['numb12'.$key];

		for($i=1;$i<=$numb12;$i++)

		{

			$itemcode = $_POST['itemcode'.$key][$i];

			$suppliername = addslashes($_POST['suppliername'.$key][$i]);

			$suppliercode = $_POST['suppliercode'.$key][$i];

			$supplieranum = $_POST['supplieranum'.$key][$i];

			$fx = $_POST['fx'.$key][$i];

			$fxrate = $_POST['fxrate'.$key][$i];

			$reqqty = $_POST['reqqty'.$key][$i];

			$package = $_POST['package'.$key][$i];

			$packagequantity = $_POST['packagequantity'.$key][$i];

			

			$auto_number = $_POST['auto_number'.$key][$i];

			$purchasetype = $_POST['purchasetype'.$key][$i];

			

			$fxpkrate = $_POST['fxpkrate'.$key][$i];

			$fxamount = $_POST['fxamount'.$key][$i];

			$rate = $_POST['rate'.$key][$i];

			$amount = $_POST['amount'.$key][$i];

			$reqqty = str_replace(',', '', $reqqty);

			$rate = str_replace(',', '', $rate);

			$amount = str_replace(',', '', $amount);

			$fxpkrate = str_replace(',', '', $fxpkrate);

			$fxamount = str_replace(',', '', $fxamount);

			if(trim($purchasetype)=='Expenses' || trim($purchasetype)=='Others' || strtoupper(trim($purchasetype))=='ASSETS')

			{

				$query55="update purchase_indent set suppliername='$suppliername',suppliercode='$suppliercode',supplieranum='$supplieranum',currency='$fx',fxamount='$fxrate',quantity='$reqqty',packagequantity='$packagequantity',fxpkrate='$rate',fxtotamount='$amount',rate='$rate',amount='$amount',edited_by='$username',updatedatetime='$updatedatetime' where docno='$docno' and auto_number='$auto_number'";

				$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"])."ERROR IN QUERY55");

			}

			else

			{

			 	$query55="update purchase_indent set suppliername='$suppliername',suppliercode='$suppliercode',supplieranum='$supplieranum',currency='$fx',fxamount='$fxrate',quantity='$reqqty',packagequantity='$packagequantity',fxpkrate='$rate',fxtotamount='$amount',rate='$rate',amount='$amount',edited_by='$username',updatedatetime='$updatedatetime' where docno='$docno' and medicinecode='$itemcode' and auto_number='$auto_number'";

				$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"])."ERROR IN QUERY55");

				

				$query555="update master_itemtosupplier set suppliername='$suppliername',suppliercode='$suppliercode',supplieranum='$supplieranum' where itemcode='$itemcode'";

				$exec555=mysqli_query($GLOBALS["___mysqli_ston"], $query555) or die(mysqli_error($GLOBALS["___mysqli_ston"])."ERROR IN QUERY555"); 

			}

			

		}

	}



	foreach($_POST['select'] as $key => $value)

	{

			//echo $key,'<br/>';

		 $docno = $_POST['docno'][$key];		 

		 $locationname = $_POST['locationname'][$key];

		 $locationcode = $_POST['locationcode'][$key];

		 $storecode = $_POST['storecode'][$key];

		 $storename = $_POST['storename'][$key];				

				

		$query33 = "select * from purchase_indent where docno='$docno' and approvalstatus='approved' and pogeneration!='completed'";

		$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		while($res33 = mysqli_fetch_array($exec33))

		{

			$itemname = $res33['medicinename'];

			$itemcode = $res33['medicinecode'];

			$quantity = $res33['quantity'];

			$quantity = str_replace(',', '', $quantity);

			$rate = $res33['rate'];

			$amount = $res33['amount'];

			$fxpkrate = $res33['fxpkrate'];

			$fxtotamount = $res33['fxtotamount'];

			$baremarks = $res33['baremarks'];

			$packagequantity = $res33['packagequantity'];

			$purchasetype = $res33['purchasetype'];

			$suppliername = $res33['suppliername'];

			$suppliercode = $res33['suppliercode'];

			$supplieranum = $res33['supplieranum'];

			$auto_number = $res33['auto_number'];

			$currency = $res33['currency'];

			$fxamount = $res33['fxamount'];



			$freeqty  = $res33['freeqty'];

			$discount = $res33['discount'];

			$baserate = $res33['baserate'];

			$tax_amount = $res33['tax_amount'];
			$tax_amount = str_replace(',', '', $tax_amount);
			$tax_percentage = $res33['tax_percentage'];

			$discount_by_percent = $res33['discount_by_percent'];

			if($discount_by_percent)

				$discount_per = $discount;

			else

				$discount_per = 0;



			$discount_amt = $baserate - $rate;

			$lpodate = $res33['povalidity'];

			if(trim($purchasetype)!='Expenses' && trim($purchasetype)!='Others')

			{

				if($suppliername=='')

				{

					$query45 = "select suppliername,suppliercode from master_itemtosupplier where itemcode='$itemcode' order by auto_number desc limit 0, 1";

					$exec45 = mysqli_query($GLOBALS["___mysqli_ston"], $query45) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

					$res45 = mysqli_fetch_array($exec45);

					$suppliername=$res45['suppliername'];

					$suppliercode=$res45['suppliercode'];

					$supplieranum=$res45['supplieranum'];

				}

				$query3 = "select * from bill_formats where description = 'purchase_order'";
				
				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$res3 = mysqli_fetch_array($exec3);
				
				$paynowbillprefix =  $res3['prefix'];
			
				$paynowbillprefix1=strlen($paynowbillprefix);

				$query3 = "select * from purchaseorder_details order by auto_number desc limit 0, 1";

				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				$num3 = mysqli_num_rows($exec3);

				$res3 = mysqli_fetch_array($exec3);

				$billnumber = $res3['billnumber'];

				$billdigit=strlen($billnumber);

				if($num3 >0)

				{

				$query2 = "select * from purchaseorder_details where suppliercode = '$suppliercode' and recordstatus = 'Process' and locationcode='$locationcode' order by auto_number desc limit 0, 1";
				
					$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

					$num2 = mysqli_num_rows($exec2);

					$res2 = mysqli_fetch_array($exec2);

					$billnumber = $res2["billnumber"];					

					$billdigit=strlen($billnumber);

					if($billnumber != '')

					{

						$billnumbercode = $billnumber;

						$docstatus = '';

					}

					else

					{

						$query24 = "select * from purchaseorder_details where docstatus = 'new' order by auto_number desc limit 0, 1";

						$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res24 = mysqli_fetch_array($exec24);

						$billnumber = $res24['billnumber'];

						/*$billdigit=strlen($billnumber);

						$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);						

						$billnumbercode = intval($billnumbercode);	
						
						$billnumbercode=abs($billnumbercode);					

						$billnumbercode = $billnumbercode + 1;						

						$maxanum = $billnumbercode;	*/	
						
						$maxcount=split("-",$billnumber);
		                $maxcount1=$maxcount[1];
		                $maxanum = $maxcount1+1;				

						//$billnumbercode = $paynowbillprefix .$maxanum;
						
						$billnumbercode = $paynowbillprefix ."-".$maxanum."-".date('y')."-".$location_auto;

						$openingbalance = '0.00';						

						$docstatus = 'new';

					}

				}

				else

				{

					$query2 = "select * from purchaseorder_details where docstatus = 'new' order by auto_number desc limit 0, 1";

					$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

					$res2 = mysqli_fetch_array($exec2);

					$billnumber = $res2["billnumber"];

					$billdigit=strlen($billnumber);

					if ($billnumber == '')

					{

						$billnumbercode =$paynowbillprefix.'1';

						$openingbalance = '0.00';

						$docstatus = 'new';

					}

				}

				

				$query56="insert into purchaseorder_details(companyanum,billnumber,itemcode,itemname,rate,quantity,free,discountpercentage,totalamount,discountamount,username, ipaddress, billdate,purchaseindentdocno,suppliername,suppliercode,supplieranum,packagequantity,recordstatus,docstatus,locationname,locationcode,storename,storecode,currency,fxamount,fxpkrate,fxtotamount,remarks,job_title,baserate,povalidity,discount_by_percent,itemtaxpercentage,itemtaxamount)

				values('$companyanum','$billnumbercode','$itemcode','$itemname','$rate','$quantity','$freeqty','$discount_per','$amount','$discount_amt','$username','$ipaddress','$currentdate','$docno','$suppliername','$suppliercode',$supplieranum,'$packagequantity','Process','$docstatus','".$locationname."','".$locationcode."','".$storename."','".$storecode."','$currency','$fxamount','$fxpkrate','$fxtotamount','$baremarks','$job_title','$baserate','$lpodate','$discount_by_percent','$tax_percentage','$tax_amount')";

				$exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		

				

				$query55="update purchase_indent set pogeneration='completed' where docno='$docno' and medicinecode='$itemcode'";

				$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			}

			else

			{

				$paynowbillprefix = 'MLPO-';

				$paynowbillprefix1=strlen($paynowbillprefix);

				$query3 = "select * from manual_lpo order by auto_number desc limit 0, 1";

				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				$num3 = mysqli_num_rows($exec3);

				$res3 = mysqli_fetch_array($exec3);

				$billnumber = $res3['billnumber'];

				$billdigit=strlen($billnumber);

				if($num3 >0)

				{

					$query2 = "select * from manual_lpo where suppliercode = '$suppliercode' and recordstatus = 'Process' order by auto_number desc limit 0, 1";

					$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

					$num2 = mysqli_num_rows($exec2);

					$res2 = mysqli_fetch_array($exec2);

					$billnumber = $res2["billnumber"];					

					$billdigit=strlen($billnumber);

					if($billnumber != '')

					{

						$billnumbercode = $billnumber;

						$docstatus = '';					

					}

					else

					{

						$query24 = "select * from manual_lpo order by auto_number desc limit 0, 1";

						$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res24 = mysqli_fetch_array($exec24);

						$billnumber = $res24['billnumber'];

						$billdigit=strlen($billnumber);

						$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);						

						$billnumbercode = intval($billnumbercode);						

						$billnumbercode = $billnumbercode + 1;						

						$maxanum = $billnumbercode;						

						$billnumbercode = $paynowbillprefix .$maxanum;

						$openingbalance = '0.00';						

						$docstatus = 'new';

					}

				}

				else

				{

					$query2 = "select * from manual_lpo order by auto_number desc limit 0, 1";

					$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

					$res2 = mysqli_fetch_array($exec2);

					$billnumber = $res2["billnumber"];

					$billdigit=strlen($billnumber);

					if ($billnumber == '')

					{

						$billnumbercode =$paynowbillprefix.'1';

						$openingbalance = '0.00';

						$docstatus = 'new';

					}

				}

				

				$query56="insert into manual_lpo(companyanum,billnumber,itemcode,itemname,rate,quantity,totalamount,username, ipaddress, entrydate,purchaseindentdocno,purchasetype,suppliername,suppliercode,supplieranum,recordstatus,docstatus,locationname,locationcode,storename,storecode,currency,fxamount,fxpkrate,fxtotamount,remarks,job_title,,itemtaxpercentage,itemtaxamount) values('$companyanum','$billnumbercode','$itemcode','$itemname','$rate','$quantity','$amount','$username','$ipaddress','$currentdate','$docno','$purchasetype','$suppliername','$suppliercode',$supplieranum,'Process','$docstatus','".$locationname."','".$locationcode."','".$storename."','".$storecode."','$currency','$fxamount','$fxpkrate','$fxtotamount','$baremarks','$job_title','$tax_percentage','$tax_amount')";

				$exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		

				

				$query55="update purchase_indent set pogeneration='completed' where docno='$docno' and auto_number='$auto_number'";

				$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			}

		}

		//}

	}

	foreach($_POST['select'] as $key => $value)

	{

		$docno = $_POST['select'][$key];		

		$query53="update purchaseorder_details set recordstatus='generated' where recordstatus='Process'";

		$exec53=mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		

		$query53="update manual_lpo set recordstatus='generated' where recordstatus='Process'";

		$exec53=mysqli_query($GLOBALS["___mysqli_ston"], $query53) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	

	}

	foreach($_POST['reapproval'] as $key => $value)

	{

		$docno = $_POST['reapproval'][$key];	

		$query55="update purchase_indent set approvalstatus='1' where docno='$docno'";

		$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	

	}

	//exit;

	header("location:consolidateindents.php");

	exit;

}



?>

<?php

$query3 = "select * from master_company where companystatus = 'Active'";

$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

$res3 = mysqli_fetch_array($exec3);

$paynowbillprefix = 'PO-';

$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from purchase_ordergeneration order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["docno"];

$billdigit=strlen($billnumber);

if ($billnumber == '')

{

	$billnumbercode ='PO-'.'1';

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

	

	

	$billnumbercode = 'PO-' .$maxanum;

	$openingbalance = '0.00';

	//echo $companycode;

}

?>

<style type="text/css">

.ui-menu .ui-menu-item{ zoom:1 !important; }

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

.number

{

padding-left:690px;

text-align:right;

font-weight:bold;

}



</style>

<link href="autocomplete.css" rel="stylesheet">

<script type="text/javascript" src="js/jquery-1.10.2.js"></script>

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>



<script language="javascript">

function validcheck()

{

	document.getElementById("savepo").disabled=true;

	var app=0;

	var supp=0;

	var count = $("[type='checkbox']").length;

	for(i=0;i<=count/2;i++)

	{

		if($("#reapproval"+i).attr("checked"))

		{

			app=1;

			if($("#reapproval"+i).prop("disabled"))

		{

			$("#reapproval"+i).prop("disabled",false);

		}

		}

	}

	

	for(i=0;i<=count/2;i++)

	{

		if($("#select"+i).prop("disabled"))

		{

			supp=1;

		}

	}

	//alert(app);

	if(app && supp)

	{

		if(confirm("Alterations have been made on the indent. Indent will be sent to Finance for approval \n Do you want to proceed?")==false){document.getElementById("savepo").disabled=false;return false;}	

	}

	else

	{

		if(supp)

		{

			if(confirm("Supplier Name Needs a update so the page refreshes & other selected P/O 's will be generated. \n Do you want to proceed?")==false){document.getElementById("savepo").disabled=false;return false;}	

		}

		else

		{

			if(confirm(" Do you want to generate P/O?")==false){document.getElementById("savepo").disabled=false;return false;}

		}

	}

}

function cbcustomername1()

{

	document.cbform1.submit();

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





function loadprintpage1(banum)

{

	var banum = banum;

	window.open("print_bill1_op1.php?billautonumber="+banum+"","Window"+banum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');

	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');

}



$(function() {

	

$('.suppliername').autocomplete({

		

	source:'ajaxsuppliernewserach.php', 

	//alert(source);

	minLength:3,

	delay: 0,

	html: true, 

		select: function(event,ui){

			var supplier = this.id;

			var code = ui.item.id;

			var anum = ui.item.anum;

			var suppliername = supplier.split('suppliername');

			var suppliercode = suppliername[1];

			$('#suppliercode'+suppliercode).val(code);

			$('#supplieranum'+suppliercode).val(anum);

			},

    });

});



function totalcalc(varserialnumber)

{

var varserialnumber = varserialnumber;

var receivedqty = document.getElementById("receivedquantity"+varserialnumber+"").value;

if(receivedqty != '')

{

is_int(receivedqty,varserialnumber);

}

var balqty = document.getElementById("balqty"+varserialnumber+"").value;

if(parseFloat(receivedqty) > parseFloat(balqty))

{

alert("Received quantity is greater than Balancequantity.Please Enter Lesser quantity");

document.getElementById("receivedquantity"+varserialnumber+"").value=0;

return false;

}

if(receivedqty != '')

{

var packsize=document.getElementById("packsize"+varserialnumber+"").value;

var packvalue=packsize.substring(0,packsize.length - 1);

var totalqty=parseInt(receivedqty) * parseInt(packvalue);

document.getElementById("totalquantity"+varserialnumber+"").value=totalqty;

}

return true;

}

 function is_int(value,varserialnumber8){ 

  if((parseFloat(value) == parseInt(value)) && !isNaN(value)){

      return true;

  } else { 

  alert("Quantity should be integer");

  document.getElementById("receivedquantity"+varserialnumber8+"").value=0;

      return false;

  } 

}



function totalamount(varserialnumber2,varserialnumber)

{

	var grandtotaladjamt = 0;

	var grandtotalfxadjamt = 0;

	var varserialnumber2 = varserialnumber2;

	var totalcount = document.getElementById("numb12"+varserialnumber+"").value;

	var budgetamount = document.getElementById("budgetamount"+varserialnumber+"").value;

	var fxamount = document.getElementById("fxpkrate"+varserialnumber2+"").value;

	var fxrate = document.getElementById("fxrate"+varserialnumber2+"").value;

	if(fxamount=='')

	{

		fxamount=0;

	}

	fxamount=fxamount.replace(/[^0-9\.]+/g,"");

	var receivedqty2 = document.getElementById("reqqty"+varserialnumber2+"").value.replace(/[^0-9\.]+/g,"");

	var priceperpack2 = parseFloat(fxamount)/parseFloat(fxrate);

	priceperpack2 = priceperpack2.toFixed(2);

	if(priceperpack2 != '' && receivedqty2 != '')

	{		

		var packsize1=document.getElementById("package"+varserialnumber2+"").value;

		var packvalue1=packsize1.substring(0,packsize1.length - 1);

		var totalamount = parseFloat(receivedqty2) * parseFloat(priceperpack2);

		var totalfxamount=parseFloat(receivedqty2) * parseFloat(fxamount);

		totalamount = parseFloat(totalamount).toFixed(2);

		totalamount = totalamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

		totalfxamount = parseFloat(totalfxamount).toFixed(2);

		totalfxamount = totalfxamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

		document.getElementById("amount"+varserialnumber2+"").value = totalamount;

		document.getElementById("fxamount"+varserialnumber2+"").value = totalfxamount;

		var tot=parseFloat(receivedqty2) * parseFloat(packvalue1);		

		var classamount = document.getElementsByClassName("amount"+varserialnumber+"");

		//alert(classamount.length);

		for(i=0;i<classamount.length;i++)

		{

			//alert(classamount[i].value);

			var totaladjamount=classamount[i].value;

			totaladjamount=totaladjamount.replace(/,/g,'');

			grandtotaladjamt=parseFloat(grandtotaladjamt)+parseFloat(totaladjamount);

			

		}

		/*for(i=1;i<=totalcount;i++)

		{

			var totaladjamount=document.getElementById("amount"+i+"").value;

			var totaladjfxamount=document.getElementById("fxamount"+i+"").value;

			

			if(totaladjamount == "")

			{

				totaladjamount=0;

			}

			if(totaladjfxamount == "")

			{

				totaladjfxamount=0;

			}

			totaladjamount=totaladjamount.replace(/,/g,'');

			totaladjfxamount=totaladjfxamount.replace(/,/g,'');

			grandtotaladjamt=parseFloat(grandtotaladjamt)+parseFloat(totaladjamount);

			totalfxamount = parseFloat(grandtotalfxadjamt);

		}*/

		grandtotaladjamt = parseFloat(grandtotaladjamt).toFixed(2);

		grandtotaladjamt = grandtotaladjamt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

		document.getElementById("totalamount"+varserialnumber).value = grandtotaladjamt;

		//document.getElementById("totalfxamount").value = totalfxamount.toFixed(2);

		priceperpack2 = priceperpack2.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

		document.getElementById("rate"+varserialnumber2+"").value=priceperpack2;

		if(parseFloat(budgetamount)==parseFloat(grandtotaladjamt.replace(/[^0-9\.]+/g,"")))

		{

			document.getElementById("select"+varserialnumber).disabled=false;

			document.getElementById("select"+varserialnumber).checked=true;

			document.getElementById("reapproval"+varserialnumber).disabled=true;

			document.getElementById("reapproval"+varserialnumber).checked=false;

			document.getElementById("reapprove").value=0;

		}

		else

		{

			document.getElementById("select"+varserialnumber).disabled=true;

			document.getElementById("select"+varserialnumber).checked=false;

			document.getElementById("reapproval"+varserialnumber).disabled=true;

			document.getElementById("reapproval"+varserialnumber).checked=true;

			document.getElementById("reapprove").value=1;			

		}

	}

}

function recheck(sno)

{

	if(document.getElementById("reapproval"+sno).checked==true)

	{

		document.getElementById("select"+sno).disabled=true;

	}

	else

	{

		document.getElementById("select"+sno).disabled=false;

	}

}

function checkboxselect(sno,id)

{

	//alert(id);

	var nosupp = '0';

	var yessupp = '0';

	if(document.getElementById(id).checked==true)

	{

		//alert('hi');

		document.getElementById("reapproval"+id.split('select')[1]).disabled=true;

		var classnames = document.getElementsByClassName(sno);

		for (var i = 0; i < classnames.length; i++) 

		{

			var displayattr = classnames[i].value;

			if(displayattr=='')

			{

				nosupp = parseFloat(nosupp)+1;

				//document.getElementById('id'+pino).innerHTML='+';

			}

			else

			{

				yessupp = parseFloat(yessupp)+1;	

				//document.getElementById('id'+pino).innerHTML='-';

			}

		}

		if(parseFloat(nosupp)>0)

		{

			alert('Please Select Supplier Name For This PI');

			document.getElementById(id).checked=false;

			document.getElementById("reapproval"+id.split('select')[1]).disabled=false;

		}

	}

	else

	{

	document.getElementById("reapproval"+id.split('select')[1]).disabled=false;

	}

}



</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<style type="text/css">



.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}



</style>

</head>

<script src="js/datetimepicker_css.js"></script>



<body>



<?php 

$query34="select * from purchase_indent where  approvalstatus='approved' and pogeneration='' and locationcode='".$locationcode."' and date BETWEEN '".$ADate1."' and '".$ADate2."'  group by docno";

$exec34=mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$resnw1=mysqli_num_rows($exec34);

?>

<table width="100%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" 

            align="left" border="0">

          <tbody>

          <tr>

          	<td colspan="6">

            	<form name="cbform1" method="post" action="consolidateindents.php" >

          <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

         

		  <!--<tr bgcolor="red">

              <td colspan="4" bgcolor="red" class="bodytext3"><strong> PLEASE REFRESH PAGE BEFORE MAKING BILL </strong></td>

              </tr>-->

            <tr bgcolor="#011E6A">

              <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong> Search Purchase Indents </strong></td>

              <td colspan="1" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>

             

            

                  <?php

						

					if ($locationcode!='')

						{

						$query12 = "select locationname from master_location where locationcode='$locationcode' order by locationname";

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

             <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>

              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

               <select name="location" id="location"   style="border: 1px solid #001E6A;">

                  <?php

						

						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res1 = mysqli_fetch_array($exec1))

						{

						$res1location = $res1["locationname"];

						$res1locationanum = $res1["locationcode"];

						?>

						<option value="<?php echo $res1locationanum; ?>" <?php if($locationcode!='')if($locationcode==$res1locationanum){echo "selected";}?>><?php echo $res1location; ?></option>

						<?php

						}

						?>

                  </select>

              </span></td>

              </tr>

              

			    <tr>

            

			  <tr>

          <td width="136" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>

          <td width="131" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>

          <td width="76" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>

          <td width="425" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">

            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>

		  </span></td>

          </tr>

			   <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                  <input  type="submit" value="Search" name="Submit" />

                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>

            </tr>

         

        </table>

		</form>

            </td>

             

                       <script>

                       		$(function() {$("[id^='droupid']").hide(0);

							

							}

							

							);

							function dropdown(id,action)

							{

								if(action=='down')

								{

									$("#droupid"+id).slideDown(300); $("#down"+id).hide(0); $("#up"+id).show();

									}

									

								else if(action=='up')

								{

									$("#droupid"+id).slideUp(300);  $("#up"+id).hide(0); $("#down"+id).show();

									}

							//$("#down").click(function(){$("#droupid2").slideDown(300); $("#down").hide(0); $("#up").show();});

							//$("#down").click(function(){$("#droupid1").slideDown(1000);});

							//$("#up").click(function(){$("#droupid2").slideUp(300);  $("#up").hide(0); $("#down").show();});

								}

                       </script>

          </tr>

          <form method="post" name="form1" action="consolidateindents.php"  onSubmit="return validcheck()">

            <tr>

             

              <td colspan="10" bgcolor="#ecf0f5" class="bodytext31">

                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->

                <div align="left"><strong>Consolidate Indents</strong><label class="number"><<<?php echo $resnw1;?>>></label></div></td>

              </tr>

			  

			<?php

			if ($st == 'success' && $billautonumber != '')

			{

			?>

            <tr>

              <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff">&nbsp;</td>

              <td colspan="8"  align="left" valign="center" bgcolor="#FFFF00" class="bodytext31">&nbsp;

			  * Success. Bill Saved. &nbsp;&nbsp;&nbsp;

			  <input name="billprint" type="button" onClick="return loadprintpage1('<?php echo $billautonumber; ?>')" value="Click Here To Print Invoice" class="button" style="border: 1px solid #001E6A"/>

			  </td>

              <td  align="left" valign="center" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>

            </tr>

			<?php

			}

			?>

			

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>

                 <td width="13%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Location </strong></div></td>

                 <td width="13%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Store </strong></div></td>

				 <td width="13%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date </strong></div></td>

				<td width="13%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>From</strong></div></td>

				<td width="13%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Doc No</strong></div></td>

              <td width="20%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Status</strong></div></td>

                <td width="20%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Appr Budget</strong></div></td>

				<td width="20%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Select</strong></div></td>

              	<td width="20%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Re-Approval</strong></div></td>

              </tr>

			

            

			<?php

			$colorloopcount = '';

			$sno = '';

			$sno1 = '';

		$query34="select * from purchase_indent where approvalstatus='approved' and pogeneration='' and locationcode='".$locationcode."' and date BETWEEN '".$ADate1."' and '".$ADate2."'  group by docno";

		$exec34=mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		while($res34=mysqli_fetch_array($exec34))

			{

			$date=$res34['date'];

			$user=$res34['username'];

			$docno=$res34['docno'];

			

			$locationname=$res34['locationname'];

			$locationcode=$res34['locationcode'];

			$storename=$res34['storename'];

			$storecode=$res34['storecode'];

			$job_title=$res34['job_title'];

			

			$query121 = "select sum(amount) as budgetamount from purchase_indent where docno='$docno' and approvalstatus='approved' and pogeneration!='completed'";

			$exec121 = mysqli_query($GLOBALS["___mysqli_ston"], $query121) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$numb=mysqli_num_rows($exec121);			

			$res121 = mysqli_fetch_array($exec121);

			$budgetamount = $res121['budgetamount']; 

			

			$query128 = "select purchaseindentdocno from purchaseorder_details where purchaseindentdocno='$docno'";

			$exec128 = mysqli_query($GLOBALS["___mysqli_ston"], $query128) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$numbpo=mysqli_num_rows($exec128);		

			if($numbpo == 0)

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

			?>

			  <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php  $sno = $sno + 1; ?>

              <a id="down<?php echo $sno; ?>" onClick="dropdown(<?php echo $sno; ?>,'down')" href="#" style="background:url(img/arrow1.png) 0px 10px;width:20px;height:10px;float:left;display:block;text-decoration:none;"></a>

                <a id="up<?php echo $sno; ?>"  onClick="dropdown(<?php echo $sno; ?>,'up')" href="#" style="background:url(img/arrow1.png) 0px 0px;width:20px;height:10px;float:left;display:block;text-decoration:none;display:none;"></a><div align="center"><?php echo $sno ; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $locationname; ?></div></td>

                <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $storename; ?></div></td>

                

				<input type="hidden" name="jobtitle" value="<?php echo $job_title; ?>"> 

                <input type="hidden" name="locationname[<?php echo $sno;?>]" value="<?php echo $locationname; ?>"> 

                <input type="hidden" name="locationcode[<?php echo $sno;?>]" value="<?php echo $locationcode; ?>"> 

                <input type="hidden" name="storename[<?php echo $sno;?>]" value="<?php echo $storename; ?>"> 

                <input type="hidden" name="storecode[<?php echo $sno;?>]" value="<?php echo $storecode; ?>"> 

                <input type="hidden" name="budgetamount[<?php echo $sno;?>]" id="budgetamount<?php echo $sno;?>" value="<?php echo $budgetamount; ?>"> 

			   <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $date; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $user; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $docno; ?></div></td>

				<input type="hidden" name="docno[<?php echo $sno;?>]" value="<?php echo $docno; ?>"> 

              <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31" align="center"><?php echo 'Approved' ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31" align="center"><?php echo number_format($budgetamount,2,'.',','); ?></div></td>

			   <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31" align="center"><input type="checkbox"  name="select[<?php echo $sno;?>]" id="select<?php echo $sno;?>" value="<?php echo $docno; ?>" onClick="checkboxselect('<?php echo $docno; ?>',this.id)" class="select"></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31" align="center"><input type="checkbox"  name="reapproval[<?php echo $sno;?>]" id="reapproval<?php echo $sno;?>" value="<?php echo $docno; ?>" class="reapproval" onClick="recheck(<?php echo $sno; ?>)"></div></td>

                       </tr>

                      

             

                       <tr>

                       <span>

                       

                       <td colspan="10">

                        <div id="droupid<?php echo $sno; ?>" style="BORDER-COLLAPSE: collapse;">

                       	<table id="dr1" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 

            align="left" border="0">

          <tbody id="foo">

             <tr>

                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Medicine Name</strong></td>

                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Supplier Name</strong></td>

                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>FX</strong></td>

                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Exc Rate</strong></td>

                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Req Qty</strong></td>

                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Pack Size</strong></td>

                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Pkg Qty</strong></td>

                      	<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Mst/Ind Rate</strong></td>

                        <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Mst/Ind Amount</strong></td>

						<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Original Rate</strong></td>

                        <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>PO Rate</strong></td>

                        <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>PO Amount</strong></td>

					    

                       

                     </tr>

				  		<?php

		//	$colorloopcount = '';

			$sno2 = 0;

			$totalamount=0;	

			$budgetamount=0;		

			$query12 = "select * from purchase_indent where docno='$docno' and approvalstatus='approved' and pogeneration!='completed'";

			$exec12= mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$numb12=mysqli_num_rows($exec12);

			

			while($res12 = mysqli_fetch_array($exec12))

        	{

        	$tax_amount = 0;
			$medicinename = $res12['medicinename'];

			$itemcode = $res12['medicinecode'];			

			$reqqty = $res12['quantity'];

			$purchasetype = $res12['purchasetype'];

			$suppliername = $res12['suppliername'];

			$suppliercode = $res12['suppliercode'];

			$supplieranum = $res12['supplieranum'];

			$auto_number = $res12['auto_number'];

			$originalrate=$res12['originalrate'];

			$currency = $res12['currency'];

			$fxamount = $res12['fxamount'];

			$tax_amount = $res12['tax_amount'];

			if($currency=='')

			{

				$currency='UGX';

				$fxamount='1';

			}

			$query2 = "select * from master_medicine where itemcode = '$itemcode'";

			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res2 = mysqli_fetch_array($exec2);

			$package = $res2['packagename'];

			

			$packagequantity = $res12['packagequantity'];

			$rate = $res12['rate'];

			$amount = $res12['amount']; 

			$fxpkrate = $res12['rate']*$fxamount;

			$fxtotamount = $fxpkrate*$reqqty; 

			$itemcode = $itemcode;

    if($fxpkrate=='0')

    {

     $fxpkrate=$rate;

     $fxtotamount=$rate*$packagequantity;

    }

  $fxtotamount = $fxtotamount + $tax_amount;

   

			$totalamount= $totalamount + $amount;

			$sno1 = $sno1 + 1;

			$sno2 = $sno2 + 1;

$budgetamount = $budgetamount + (number_format($fxtotamount/$fxamount,2,'.',''));		

?>

  <tr>

		

		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $medicinename;?>

        <input type="hidden" id="itemcode<?php echo $sno1;?>" name="itemcode<?php echo $sno;?>[<?php echo $sno2; ?>]" value="<?php echo $itemcode;?>">

        <input type="hidden" id="purchasetype<?php echo $sno1;?>" name="purchasetype<?php echo $sno;?>[<?php echo $sno2; ?>]" value="<?php echo $purchasetype;?>">

        <input type="hidden" id="auto_number<?php echo $sno1;?>" name="auto_number<?php echo $sno;?>[<?php echo $sno2; ?>]" value="<?php echo $auto_number;?>">

        </div></td>

        

        <td class="bodytext31" valign="center"  align="left"><div align="center"> 

        

        <?php

		if($purchasetype!='Expenses' && $purchasetype!='Others')

		{

			if($suppliername=='')

			{

			$query3 = "select suppliername,suppliercode,supplieranum from master_itemtosupplier where locationcode = '$locationcode' and itemcode = '$itemcode' and recordstatus <> 'deleted' ORDER BY auto_number desc";

			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

			//$rows3 = mysql_num_rows($exec3);

			$res3 = mysqli_fetch_array($exec3);

			$suppliername = $res3['suppliername'];

			$suppliercode = $res3['suppliercode'];

			$supplieranum = $res3['supplieranum'];

			}

		}

		 echo '<input type="text" id="suppliername'.$sno1.'" name="suppliername'.$sno.'['.$sno2.']" class="suppliername '.$docno.'" value="'.trim($suppliername).'"/><input type="hidden" id="suppliercode'.$sno1.'" name="suppliercode'.$sno.'['.$sno2.']" class="suppliercode" value="'.trim($suppliercode).'"/><input type="hidden" id="supplieranum'.$sno1.'" name="supplieranum'.$sno.'['.$sno2.']" class="supplieranum" value="'.trim($supplieranum).'"/>';

		 if($suppliername=='')

		 {

			 echo "<script>document.getElementById('select".$sno."').checked=false;document.getElementById('select".$sno."').disabled=true;</script>";

		 }

		 ?></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" size="2" id="fx<?php echo $sno1;?>" name="fx<?php echo $sno;?>[<?php echo $sno2; ?>]" value="<?php echo $currency;?>" readonly></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" size="2" id="fxrate<?php echo $sno1;?>" name="fxrate<?php echo $sno;?>[<?php echo $sno2; ?>]" value="<?php echo $fxamount;?>" onKeyUp="totalamount('<?php echo $sno1;?>','<?php echo $sno;?>');"></div></td>

		

		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" size="2" id="reqqty<?php echo $sno1;?>" name="reqqty<?php echo $sno;?>[<?php echo $sno2; ?>]" value="<?php echo number_format($reqqty);?>" readonly>

        </div></td>

		<!--onKeyUp="totalamount('<?php echo $sno1;?>','<?php echo $sno;?>');"-->

		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" size="2" id="package<?php echo $sno1;?>" name="package<?php echo $sno;?>[<?php echo $sno2; ?>]" value="<?php echo $package;?>" readonly></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="packagequantity" size="1" name="packagequantity<?php echo $sno;?>[<?php echo $sno2; ?>]" id="packagequantity<?php echo $sno1;?>" value="<?php echo $packagequantity;?>" readonly></div></td>

        <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" size="5" name="fxpkrate<?php echo $sno;?>[<?php echo $sno2; ?>]" id="fxpkrate<?php echo $sno1;?>" value="<?php echo number_format($fxpkrate,'2','.',',');?>" onKeyUp="totalamount('<?php echo $sno1;?>','<?php echo $sno;?>');"></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" size="5" name="fxamount<?php echo $sno;?>[<?php echo $sno2; ?>]" id="fxamount<?php echo $sno1;?>" value="<?php echo number_format($fxtotamount,'2','.',',');?>" readonly></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" size="5" name="orate<?php echo $sno;?>[<?php echo $sno2; ?>]" id="orate<?php echo $sno1;?>" value="<?php echo number_format($originalrate,'2','.',',');?>" readonly>

       </div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" size="5" name="rate<?php echo $sno;?>[<?php echo $sno2; ?>]" id="rate<?php echo $sno1;?>" value="<?php echo number_format($fxpkrate/$fxamount,2,'.',',');?>" readonly></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" size="5" name="amount<?php echo $sno;?>[<?php echo $sno2; ?>]" class="amount<?php echo $sno;?>" id="amount<?php echo $sno1;?>" value="<?php echo number_format($fxtotamount/$fxamount,2,'.',',');?>" readonly></div></td>

		

				</tr>

			<?php 

			}

			

		?>

        <tr>

		

		<td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>        

        <td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>	

		<td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>

        <td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>

        <td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>

		<td class="bodytext31" valign="center"  align="left"><div align="center">

        <input type="text" size="5" name="totalamount<?php echo $sno;?>" id="totalamount<?php echo $sno;?>" value="<?php echo number_format($budgetamount,2,'.',',');?>" readonly>

        <input type="hidden" size="5" name="numb12<?php echo $sno;?>" id="numb12<?php echo $sno;?>" value="<?php echo $numb12;?>" readonly>

        

        </div></td>

		

				</tr>

			 

           

          </tbody>

        </table></div>

                       </td>

                       </span>

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

        </table></td>

      </tr>

	  <tr>

	   <td class="bodytext31" valign="center"  align="left">&nbsp;</td>

	  </tr>

	  <tr>

	  <td class="bodytext31" valign="center"  align="center">

	   <input type="hidden" name="frm1submit1" value="frm1submit1" />

	   <input type="hidden" name="reapprove" value="0" />

	   <input type="hidden" name="doccno" value="<?php echo $billnumbercode; ?>">

	    <input type="submit" name="submit" value="Generate PO / Re-Approval" id="savepo"></td>

	  </tr>

      </form>

    </table>

</table>



<?php include ("includes/footer1.php"); ?>



</body>

</html>




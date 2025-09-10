<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$dateonly = date("Y-m-d");

$timeonly = date("H:i:s");

$datetimeonly = date("Y-m-d H:i:s");

$i='';

$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res1 = mysqli_fetch_array($exec1);

$res1location = $res1["locationname"];

$locationname = $res1location;

$locationcode = $res1["locationcode"];



if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if ($cbfrmflag1 == 'cbfrmflag1')

{



$requestdocno = $_REQUEST['requestdocno'];

$storecode =$fromstore = $_REQUEST['fromstore'];

include("store_stocktaking_chk1.php");
  if($num_stocktaking > 0) {
   echo "<script>history.back();</script>";
   exit;

}

$storecode =$tostore = $_REQUEST['tostore'];

include("store_stocktaking_chk1.php");
  if($num_stocktaking > 0) {
   echo "<script>history.back();</script>";
   exit;

}

$locationcode = $_REQUEST['locationcode'];

$typetransfer = $_REQUEST['typetransfer'];

if($typetransfer == 'Consumable')

{

$tostore = $_REQUEST['expense'];

}

$fromlocationcode=$locationcode;

$tolocationcode=$locationcode;



$paynowbillprefix1 = 'ITRN-';

$paynowbillprefix12=strlen($paynowbillprefix1);

$query23 = "select * from master_stock_transfer order by auto_number desc limit 0, 1";

$exec23= mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res23 = mysqli_fetch_array($exec23);

$billnumber1 = $res23["docno"];

$billdigit1=strlen($billnumber1);

if ($billnumber1 == '')

{

	$billnumbercode1 ='ITRN-'.'1';

	$openingbalance1 = '0.00';

}

else

{

	$billnumber1 = $res23["docno"];

	$billnumbercode1 = substr($billnumber1,$paynowbillprefix12, $billdigit1);

	//echo $billnumbercode;

	$billnumbercode1 = intval($billnumbercode1);

	$billnumbercode1 = $billnumbercode1 + 1;



	$maxanum1 = $billnumbercode1;

	

	

	$billnumbercode1 = 'ITRN-'.$maxanum1;

	$openingbalance1 = '0.00';

	//echo $companycode;

}



foreach($_POST['rownumber'] as $key => $value)

		{

				   

		$medicinename=$_REQUEST['itemname'][$key];



		$medicinename=trim($medicinename);

		$medicinecode=$_REQUEST['itemcode'][$key];

		$transferquantity = $_REQUEST['transferqty'][$key];

		$reqquantity = $_REQUEST['reqquantity'][$key];

		$balance_qty = $_REQUEST['balance_qty'][$key];

		 $batch = $_REQUEST['batch'][$key];

		$rate = $_REQUEST['cost'][$key];

		$amount = $_REQUEST['amount'][$key];

		$ledgercode=$_REQUEST['legdercode'][$key];

		$ledgername=$_REQUEST['legdername'][$key];

		$ledgeranum=$_REQUEST['ledgeranum'][$key];
		$balance_qty_final=$_REQUEST['pending_qty_single'][$key];

		$itemcode = $medicinecode;

		$store = $fromstore;

		$batchname = $batch;

        
		$reqsqlchk="select sum(quantity) as tot_transferquantity from master_internalstockrequest where docno='$requestdocno' and itemcode='$medicinecode'  and recordstatus!='deleted'";
		$execcumstock234 = mysqli_query($GLOBALS["___mysqli_ston"], $reqsqlchk);
        $rescumstock234 = mysqli_fetch_array($execcumstock234);
        $tot_transferquantity4=$rescumstock234["tot_transferquantity"];
       

		$sqlchk="select sum(transferquantity) as tot_transferquantity from master_stock_transfer where requestdocno='$requestdocno' and itemcode='$medicinecode' and tostore='$tostore' and typetransfer='Transfer'";
		$execcumstock23 = mysqli_query($GLOBALS["___mysqli_ston"], $sqlchk);
        $rescumstock23 = mysqli_fetch_array($execcumstock23);
        $tot_transferquantity=$rescumstock23["tot_transferquantity"];


		if($tot_transferquantity4>=($tot_transferquantity+$transferquantity)){
		

		$fifo_code=$batch;

		 $querycumstock21 = "select batchnumber from transaction_stock where  fifo_code='$batch'";

		$execcumstock21 = mysqli_query($GLOBALS["___mysqli_ston"], $querycumstock21) or die ("Error in CumQuery21".mysqli_error($GLOBALS["___mysqli_ston"]));

		$rescumstock21 = mysqli_fetch_array($execcumstock21);

		$batchnumber = $rescumstock21["batchnumber"];

		$batchnumber = str_replace("�","",$batchnumber);

		$batchnumber = trim($batchnumber);

		/*include('autocompletestockbatch.php');

		$currentstock = $currentstock;

		$fromstorequantitybeforetransfer = $currentstock;

		$fromstorequantityaftertransfer = $currentstock - $transferquantity;

		*/

		$store = $tostore;

		$itemcode = $itemcode;

		

		

		$tnxquantity = $transferquantity;

		

			$query31 = "select * from master_itempharmacy where itemcode = '$medicinecode'"; 

			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res31 = mysqli_fetch_array($exec31);

			

			$categoryname = $res31['categoryname'];

		

			if($medicinename!="" && $batchname!='' && $transferquantity>'0')

		{

		 $querycumstock21 = "select sum(batch_quantity) as cum_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$fromlocationcode'";

		$execcumstock21 = mysqli_query($GLOBALS["___mysqli_ston"], $querycumstock21) or die ("Error in CumQuery21".mysqli_error($GLOBALS["___mysqli_ston"]));

		$rescumstock21 = mysqli_fetch_array($execcumstock21);

		$cum_quantity = $rescumstock21["cum_quantity"];

		$cum_quantity = $cum_quantity-$tnxquantity;

		

		if($cum_quantity=='0'){ $cum_stockstatus='0'; }else{$cum_stockstatus='1';}

		if($cum_quantity>='0')

		{

		$querybatstock21 = "select batch_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$fromlocationcode' and fifo_code='$fifo_code' and storecode ='$fromstore'";

		$execbatstock21 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock21) or die ("Error in batQuery21".mysqli_error($GLOBALS["___mysqli_ston"]));

		$resbatstock21 = mysqli_fetch_array($execbatstock21);

		$bat_quantity = $resbatstock21["batch_quantity"];

		$bat_quantity = $bat_quantity-$tnxquantity;

		$fromstorequantitybeforetransfer = $bat_quantity;

		$fromstorequantityaftertransfer = $bat_quantity - $tnxquantity;

		if($bat_quantity=='0'){ $batch_stockstatus='0'; }else{$batch_stockstatus='1';}

		if($bat_quantity>='0')

		{

		$queryupdatebatstock21 = "update transaction_stock set cum_stockstatus='0' ,batch_stockstatus='0' where itemcode='$itemcode' and locationcode='$fromlocationcode' and storecode='$fromstore' and fifo_code='$fifo_code'";

		$execupdatebatstock21 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatebatstock21) or die ("Error in updatebatQuery21".mysqli_error($GLOBALS["___mysqli_ston"]));

		

		//$queryupdatebatstock21 = "update transaction_stock set cum_stockstatus='0' where itemcode='$medicinecode' and locationcode='$fromlocationcode'";

		//$execupdatebatstock21 = mysql_query($queryupdatebatstock21) or die ("Error in updatebatQuery21".mysql_error());

			

		 $stockquery21="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,

			batchnumber, batch_quantity, 

			transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice,ledgercode,ledgername,ledgeranum)

			values ('$fifo_code','master_stock_transfer','$medicinecode', '$medicinename', '$dateonly','0', 'Stock Transfer From', 

			'$batchnumber', '$bat_quantity', '$tnxquantity', 

			'$cum_quantity', '$billnumbercode1', '','$cum_stockstatus','$batch_stockstatus', '$fromlocationcode','','$fromstore', '', '$username', '$ipaddress','$dateonly','$timeonly','$datetimeonly','$rate','$amount','$ledgercode','$ledgername','$ledgeranum')";

			

		$stockexecquery21=mysqli_query($GLOBALS["___mysqli_ston"], $stockquery21) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		

		

		

		if($typetransfer=='Transfer')

		{

			//$querycumstock2 = "select cum_quantity from transaction_stock where cum_stockstatus='1' and itemcode='$itemcode' and locationcode='$fromlocationcode'";

			//$execcumstock2 = mysql_query($querycumstock2) or die ("Error in CumQuery2".mysql_error());

			//$rescumstock2 = mysql_fetch_array($execcumstock2);

			//$cum_quantity = $rescumstock2["cum_quantity"];

			$cum_quantity = $cum_quantity+$tnxquantity;

			

			$querybatstock2 = "select batch_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$fromlocationcode' and fifo_code='$fifo_code' and storecode ='$tostore'";

			$execbatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock2) or die ("Error in batQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

			$resbatstock2 = mysqli_fetch_array($execbatstock2);

			$bat_quantity = $resbatstock2["batch_quantity"];

			$bat_quantity = $bat_quantity+$tnxquantity;

			$tostorequantitybeforetransfer = $bat_quantity;

			$tostorequantityaftertransfer = $bat_quantity + $tnxquantity;

			$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' ,batch_stockstatus='0' where itemcode='$itemcode' and locationcode='$fromlocationcode' and storecode='$tostore' and fifo_code='$fifo_code'";

			$execupdatebatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatebatstock2) or die ("Error in updatebatQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

			

			//$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$medicinecode' and locationcode='$fromlocationcode'";

			//$execupdatebatstock2 = mysql_query($queryupdatebatstock2) or die ("Error in updatebatQuery2".mysql_error());

			

			 $stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,

				batchnumber, batch_quantity, 

				transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice,ledgercode,ledgername,ledgeranum)

				values ('$fifo_code','master_stock_transfer','$medicinecode', '$medicinename', '$dateonly','1', 'Stock Transfer To', 

				'$batchnumber', '$bat_quantity', '$tnxquantity', 

				'$cum_quantity', '$billnumbercode1', '','1','1', '$fromlocationcode','','$tostore', '', '$username', '$ipaddress','$dateonly','$timeonly','$datetimeonly','$rate','$amount','$ledgercode','$ledgername','$ledgeranum')";

				

			$stockexecquery2=mysqli_query($GLOBALS["___mysqli_ston"], $stockquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		}

	 $medicinequery2="insert into master_stock_transfer(fifo_code,docno,fromstore,tostore,itemcode,itemname,transferquantity,batch,fromstorequantitybeforetransfer,fromstorequantityaftertransfer,tostorequantitybeforetransfer,tostorequantityaftertransfer,rate,amount,username,ipaddress,companyanum,locationcode,recordstatus,entrydate,categoryname,typetransfer,locationname,requestdocno)values('$fifo_code','$billnumbercode1','$fromstore','$tostore','$medicinecode','$medicinename','$transferquantity','$batchnumber','$fromstorequantitybeforetransfer','$fromstorequantityaftertransfer','$tostorequantitybeforetransfer','$tostorequantityaftertransfer','$rate','$amount','$username','$ipaddress','$companyanum','$locationcode','completed','$updatedatetime','$categoryname','$typetransfer','$locationname','$requestdocno')";

	

	$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		if($typetransfer=='Consumable')

			{

				$medicinequery2="insert into consumedstock(docno,typetransfer,fromstore,toaccountcode,itemcode,itemname,transferquantity,batch,fromstorequantitybeforetransfer,fromstorequantityaftertransfer,tostorequantitybeforetransfer,tostorequantityaftertransfer,rate,amount,username,ipaddress,companyanum,recordstatus,entrydate,categoryname,locationname,locationcode,tolocationname,tolocationcode,fifo_code)

				values('$billnumbercode1','$typetransfer','$fromstore','$tostore','$medicinecode','$medicinename','$tnxquantity','$batchnumber','$fromstorequantitybeforetransfer','$fromstorequantityaftertransfer','$tostorequantitybeforetransfer','$tostorequantityaftertransfer','$rate','$amount','$username','$ipaddress','$companyanum','completed','$updatedatetime','$categoryname','$fromlocationname','$fromlocationcode','$tolocationname','$tolocationcode','$fifo_code')";

				

				$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			}

			// 

			$query551 = "SELECT balance_qty,quantity from master_internalstockrequest where  docno = '$requestdocno' and itemcode='$medicinecode'";
			$exec551 = mysqli_query($GLOBALS["___mysqli_ston"], $query551) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res551 = mysqli_fetch_array($exec551)){
				$balance_qty_fet1 = $res551['balance_qty'];
				$reqquantity = $res551['quantity'];
			} 

					if($balance_qty_fet1 == '0'){
						$balance_qty_fet = $reqquantity ;
					} else {
						$balance_qty_fet = $balance_qty_fet1;
					}
			// if($balance_qty_fet == 0 ){ $balance_qty_final = 0 ; }
			// else { 
				// $balance_qty_final = $balance_qty_fet - $tnxquantity; 
			// }

			// $balance_qty_final = $balance_qty - $tnxquantity;

				// $balance_qty_final=$_POST['pending_qty'];

			if($balance_qty_final == '0') {
				$recordstatus = 'completed';
			} else {

				$recordstatus = 'pending';

			}

			$query55 = "update master_internalstockrequest set recordstatus = '$recordstatus', balance_qty = '$balance_qty_final' where docno = '$requestdocno' and itemcode='$medicinecode'";

			$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			//
			// if($exec55){
			

			// 	}

		}

		}
		}

		}
		else{

			$bal=$tot_transferquantity4 - ($tot_transferquantity+$transferquantity);

            if($bal<1)
              $query55 = "update master_internalstockrequest set recordstatus = 'completed', balance_qty = '0' where docno = '$requestdocno' and itemcode='$medicinecode'";
			else
				 $query55 = "update master_internalstockrequest set  balance_qty = '$bal' where docno = '$requestdocno' and itemcode='$medicinecode'";

			$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			//echo "<script>alert('Transaction Failed, Please try again.');window.location.href ='stocktransfer.php?docno=".$requestdocno.";</script>";
		}

		/*else

		{

			$query55 = "update master_internalstockrequest set recordstatus = 'discarded' and itemcode='$medicinecode' where docno = '$requestdocno'";

			$exec55 = mysql_query($query55) or die(mysql_error());

		}*/

		}
		echo "<script>window.open('print_stockrequest.php?docno=$requestdocno&&transdoc=$billnumbercode1', '_blank');</script>";
		echo "<script> window.location.href = 'mainmenu1.php';</script>";

		
		// header("location:mainmenu1.php");
		// header("location: print_stockrequest.php?docno=$requestdocno&&transdoc=$billnumbercode1");
		 
		// window.open('print_stockrequest.php?docno=<?=$requestdocno;&&transdoc=<?=$billnumbercode1;', '_blank');
		exit;
}

?>

<?php



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

$docno = $_REQUEST['docno'];

if ($st == 'del')

{

	$delanum = $_REQUEST["anum"];

	

	$query3 = "update master_internalstockrequest set recordstatus = 'deleted' where auto_number = '$delanum'";

	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

	

	header("location:stocktransfer.php?docno=$docno");



}



?>

<?php

$query3 = "select * from master_company where companystatus = 'Active'";

$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

$res3 = mysqli_fetch_array($exec3);

$paynowbillprefix = 'ITRN-';

$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from master_stock_transfer order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["docno"];

$billdigit=strlen($billnumber);

if ($billnumber == '')

{

	$billnumbercode ='ITRN-'.'1';

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

	

	

	$billnumbercode = 'ITRN-'.$maxanum;

	$openingbalance = '0.00';

	//echo $companycode;

}

?>

<?php

if(isset($_REQUEST['docno']))

{

$docno = $_REQUEST['docno'];



$query43 = "select * from master_internalstockrequest where docno='$docno'";

$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"])); 

$res43 = mysqli_fetch_array($exec43);

$from = $res43['fromstore'];

$to = $res43['tostore'];

$typetransfer1 = $res43['typetransfer'];

$typetransfer = $res43['typetransfer'];

if($typetransfer=='0')

{

	$typetransfer='Transfer';

}

else

{

	$typetransfer='Consumable';

}

if($typetransfer1=='0')

{

	$typetransfer1='Transfer';

}

elseif($typetransfer1=='1')

{

	$typetransfer1='Consumable';

}

elseif($typetransfer1=='2')

{

	$typetransfer1='Clinical Consumable';

}







$queryfrom751 = "select store from master_store where storecode='$from'";

$execfrom751 = mysqli_query($GLOBALS["___mysqli_ston"], $queryfrom751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$resfrom751 = mysqli_fetch_array($execfrom751);

$fromname = $resfrom751['store'];



$queryto751 = "select store from master_store where storecode='$to'";

$execto751 = mysqli_query($GLOBALS["___mysqli_ston"], $queryto751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$resto751 = mysqli_fetch_array($execto751);

$toname = $resto751['store'];

}

?>

<script>

function incri(){
	// var inc1 = document.getElementById(incriment).value;
	var inc = document.getElementById("incriment").value;
	// var inc = inc+1;
	for(i=1;i<=inc;i++){
		//$('.list'+i).hide();
		$('.plus'+i).hide();
	}
}

function btnDeleteClick10(delID){

	//alert ("Inside btnDeleteClick.");


	//alert(pharmamount);

	var varDeleteID = delID;

	//alert (varDeleteID);

	var fRet3; 

	fRet3 = confirm('Are You Sure Want To Delete This Entry?'); 

	//alert(fRet); 

	if (fRet3 == false)

	{

		//alert ("Item Entry Not Deleted.");

		return false;

	}



	var child = document.getElementById('idTR'+varDeleteID);  //tr name

    var parent = document.getElementById('insertrow'); // tbody name.

	document.getElementById ('insertrow').removeChild(child);

	

	var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name

    var parent = document.getElementById('insertrow'); // tbody name.

	//alert (child);

	if (child != null) 

	{

		//alert ("Row Exsits.");

		document.getElementById ('insertrow').removeChild(child);

		

		

	}

	



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



</script>

<script>

function medicinecheck()

{

if(document.cbform1.typetransfer.value=="Consumable"){



	if(document.cbform1.expense.value=="")

	{

		alert("Please Select the Expense Ledger");

		document.cbform1.expense.focus();

		return false;

	}



}else{



	if(document.cbform1.tostore.value=="")

	{

		alert("Please Select the store");

		document.cbform1.tostore.focus();

		return false;

	}



}



	varUserChoice = confirm('Are You Sure Want To Save This Entry?'); 

	//alert(fRet); 

	if (varUserChoice == false)

	{

		alert ("Entry Cancelled");

		return false;

	}

//        form.cbform1.submit();

document.getElementById("cbform1").submit();

	document.getElementById("savebutton").disabled = true;

	return true;

	

}

function amountcalc(serial,inc1,nrows)

{

	var serial = serial;
	//var transferqty = document.getElementById("transferqty"+serial+"").value;
	var transferqty = $.trim($('#transferqty'+serial).val());
	var batch = document.getElementById("batch"+serial+"").value;
	if(batch == '')
	{
	alert("Please Select Batch");
	document.getElementById("transferqty"+serial+"").value = 0;
	document.getElementById("amount"+serial+"").value = 0.00;
	return false;

	}
	var reqquantity = document.getElementById("reqquantity"+serial+"").value;
	var balance_qty = document.getElementById("balance_qty"+serial+"").value;
	if(parseInt(transferqty) > parseInt(balance_qty))
	{
	alert("Transfer Quantity cannot be morethan Balance Quantity");
	document.getElementById("transferqty"+serial+"").value = 0;
	document.getElementById("amount"+serial+"").value = 0.00;
	return false;
	}
	var availqty = document.getElementById("availablestock"+serial+"").value;
	if(parseInt(transferqty) > parseInt(availqty))
	{
	alert("Transfer Quantity cannot be morethan Available Quantity");
	document.getElementById("transferqty"+serial+"").value = 0;
	document.getElementById("amount"+serial+"").value = 0.00;
	return false;
	}
	var costprice = document.getElementById("cost"+serial+"").value;
	if(transferqty !='' && transferqty >=0){
		var amount = parseFloat(transferqty) * parseFloat(costprice);
		document.getElementById("amount"+serial+"").value = amount.toFixed(2);
	}
	if(transferqty =='')
	{
		document.getElementById("amount"+serial+"").value = 0.00;
	}
	

	var inc1 = inc1;
	var balance_qty = document.getElementById("balance_qty"+serial+"").value;
	// var transferqty = document.getElementById("transferqty"+serial+"").value;
			var penquantity = document.getElementById("pending_qty"+inc1+"").value;
			// if(transferqty>penquantity){
			if(penquantity<0){
				alert("Transfer Quantity cannot be morethan Pending Quantity");
					document.getElementById("transferqty"+serial+"").value = 0;
					document.getElementById("amount"+serial+"").value = 0.00;
				 
				 
			}
	// var transferqty = document.getElementById("transferqty"+serial+"").value;
	// var penquantity = document.getElementById("pending_qty"+inc1+"").value;
	// var abc = penquantity-transferqty;
	// document.getElementById("pending_qty"+inc1+"").value=abc;
	// var penquantity = document.getElementById("pending_qty"+inc1+"").value;
	var nrows = nrows;
	var sno= $('#sno').val();
	var b;
	var tq=0;
	var penquantity2 = document.getElementById("pending_qty"+inc1+"").value;
	// if(penquantity2>0){
			// for((a=1;a<=nrows;a++) && (b=1;b<=sno,b++)){
			for(b=1;b<=sno;b++){
					var tqty = $('.abc'+inc1+'-'+b).val();
					if(tqty=="" || tqty==null){
						tqty=0;
					}
					tq=tq+parseInt(tqty);
			}
			var penquantity = document.getElementById("pending_qty"+inc1+"").value;
			var new_value = balance_qty-tq;
			document.getElementById("pending_qty"+inc1+"").value=new_value;
			document.getElementById("pending_qty_single"+serial+"").value=new_value;
			tq=0;
		// }
	// alert(tq);
	

	
	// alert(penquantity);
	// if(transferqty>penquantity){
	// 	alert("Transfer Quantity cannot be morethan Available Quantity");
	// document.getElementById("transferqty"+serial+"").value = 0;
	// document.getElementById("amount"+serial+"").value = 0.00;
	
	// var balance_qty = document.getElementById("balance_qty"+serial+"").value;
	// document.getElementById("pending_qty"+inc1+"").value=balance_qty;
	// return false;
	// }



}

function cal_change(serial,inc1,nrows){
	var inc1 = inc1;
	var serial = serial;
	var balance_qty = document.getElementById("balance_qty"+serial+"").value;
	// var transferqty = document.getElementById("transferqty"+serial+"").value;
			var penquantity = document.getElementById("pending_qty"+inc1+"").value;
			// if(transferqty>penquantity){
			if(penquantity<0){
				alert("Transfer Quantity cannot be morethan Pending Quantity");
					document.getElementById("transferqty"+serial+"").value = 0;
					document.getElementById("amount"+serial+"").value = 0.00;
			}
	// var transferqty = document.getElementById("transferqty"+serial+"").value;
	// var penquantity = document.getElementById("pending_qty"+inc1+"").value;
	// var abc = penquantity-transferqty;
	// document.getElementById("pending_qty"+inc1+"").value=abc;
	// var penquantity = document.getElementById("pending_qty"+inc1+"").value;
	var nrows = nrows;
	var sno= $('#sno').val();
	var b;
	var tq=0;
	var penquantity2 = document.getElementById("pending_qty"+inc1+"").value;
	// if(penquantity2>0){
			// for((a=1;a<=nrows;a++) && (b=1;b<=sno,b++)){
			for(b=1;b<=sno;b++){
					var tqty = $('.abc'+inc1+'-'+b).val();
					if(tqty=="" || tqty==null){
						tqty=0;
					}
					tq=tq+parseInt(tqty);
			}
			var penquantity = document.getElementById("pending_qty"+inc1+"").value;
			var new_value = balance_qty-tq;
			document.getElementById("pending_qty"+inc1+"").value=new_value;
			document.getElementById("pending_qty_single"+serial+"").value=new_value;
			tq=0;
		// }
	// alert(tq);
}

function valid()

{

//alert("hi");

var numrows = document.getElementById("numrows").value;

for(i=1;i<=numrows;i++)

{

	var batch = document.getElementById("batch"+i+"").value;

	if(batch=='')

	{

	 alert("Select Batch");

	 return false;

	}

}

//return false;

}



function funcDeleteMedicine(varPaymentTypeAutoNumber)

{

    var varPaymentTypeAutoNumber = varPaymentTypeAutoNumber;

	var fRet;

	fRet = confirm('Are you sure want to delete this account name '+varPaymentTypeAutoNumber+'?');

	//alert(fRet);

	if (fRet == true)

	{

		alert ("Payment Type Entry Delete Completed.");

		//return false;

	}

	if (fRet == false)

	{

		alert ("Payment Type Entry Delete Not Completed.");

		return false;

	}

	//return false;



}



</script>

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

..bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

-->

</style>

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<?php include("js/dropdownlist1scriptingtostore.php"); ?>

<script type="text/javascript" src="js/autocomplete_store.js"></script>

<script type="text/javascript" src="js/autosuggeststore.js"></script>



<?php include ("js/dropdownlist1scriptingrequestmedicine.php"); ?>

<script type="text/javascript" src="js/autosuggestrequestmedicine.js"></script> <!-- For searching customer -->

<script type="text/javascript" src="js/autocomplete_requestmedicine.js"></script>





<?php include ("js/dropdownlist1scriptingrequestmedicine.php"); ?>

<script type="text/javascript" src="js/autosuggestrequestmedicine.js"></script> <!-- For searching customer -->

<script type="text/javascript" src="js/autocomplete_requestmedicine.js"></script>



<script type="text/javascript" src="js/insertnewitemrequestmedicine.js"></script>

<script type="text/javascript" src="js/batchselectionscript.js"></script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />  

<link href="autocomplete.css" rel="stylesheet">

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>   



<script type="text/javascript">

$(function() {

	$('#expensename').autocomplete({

		

	source:'autoexpensesearch_stock.php', 

	//alert(source);

	minLength:3,

	delay: 0,

	html: true, 

		select: function(event,ui){

			var code = ui.item.id;

			var expensename = ui.item.value;

			$('#expense').val(code);

			$('#expensename').val(expensename);

			

			},

    });

});







function funcShowView(inc)
{
var inc = inc;
 //  if (document.getElementById("list"+inc) != null) 
 //     {
	//  // document.getElementById("list"+inc).style.display = 'none';
	//  $('.list'+inc).hide();
	// }
	if (document.getElementById("list"+inc) != null) 
	  {
	  // document.getElementById("list"+inc).style.display = '';
	  $('.list'+inc).show();
	  $('.plus'+inc).hide();
	  $('.minus'+inc).show();

	 }

}
function funcHideView(inc)
{		
	var inc = inc;
 // if (document.getElementById("list"+inc) != null) 
	// {
	// document.getElementById("list"+inc).style.display = 'none';
	$('.list'+inc).hide();
	  $('.plus'+inc).show();
	   $('.minus'+inc).hide();

	// }			
}



</script>

<style type="text/css">

  

.ui-menu .ui-menu-item{ zoom:1 !important; }

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

 

.bal

{

border-style:none;

background:none;

text-align:center;

FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bali

{

text-align:right;

}

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

</style>

</head>



<script src="js/datetimepicker_css.js"></script>



<body onLoad="incri()">

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

		

		

              <form name="cbform1" id="cbform1" method="post" action="stocktransfer.php">

                <table width="1197" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                  <tbody>

                    <tr bgcolor="#011E6A">

                      <td colspan="9" bgcolor="#ecf0f5" class="bodytext32"><strong> Stock transfer </strong></td>

                    </tr>

                    <tr>

                      <td width="35" align="left" valign="middle"  class="bodytext32"><strong>Doc No</strong></td>

                      <td width="217" align="left" valign="middle"><span class="bodytext32">

                        <input name="docnumber" type="text" id="docnumber" style="border: 1px solid #001E6A;" value="<?php echo $billnumbercode; ?>" size="8" autocomplete="off" readonly>

                        <input type="hidden" name="location" id="location" value="<?php echo $res7locationanum; ?>">

                        <input type="hidden" name="requestdocno" value="<?php echo $docno; ?>">

                        <input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode; ?>">

                        <input type="hidden" name="typetransfer" id="typetransfer" value="<?php echo $typetransfer; ?>">

                        

                      </span></td>

                      <td width="47" align="left" valign="middle" class="bodytext32"><strong>From </strong></td>

                      

                      <?php

					  

				$trans_status=0;	  

				$query2a = "select storecode,defaultstore from master_employeelocation WHERE username='$username' and defaultstore='default'"; 

				$exec2a = mysqli_query($GLOBALS["___mysqli_ston"], $query2a) or die ("Error in Query2a".mysqli_error($GLOBALS["___mysqli_ston"]));

				while ($res2a = mysqli_fetch_array($exec2a))

				{

					$storecodeanuma = $res2a['storecode'];

					$defaultstorea = $res2a['defaultstore'];

					$query751a = "select store,storecode from master_store where auto_number='$storecodeanuma'";

					$exec751a = mysqli_query($GLOBALS["___mysqli_ston"], $query751a) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

					$res751a = mysqli_fetch_array($exec751a);

					$res2storea = $res751a['store'];

					$storecodea = $res751a['storecode'];

					if($to==$storecodea){

						$trans_status=1;	  

					}

				}

				$query_stocktaking = "select storecode from master_store  where  locationcode = '".$locationcode."' and storecode='".$from."' and is_freeze=1";
				$exec_stocktaking = mysqli_query($GLOBALS["___mysqli_ston"], $query_stocktaking) or die ("Error in query_stocktaking".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num_stocktaking = mysqli_num_rows($exec_stocktaking); 

				$query_stocktaking1 = "select storecode from master_store where  locationcode = '".$locationcode."' and storecode='".$to."' and is_freeze=1";
				$exec_stocktaking1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_stocktaking1) or die ("Error in query_stocktaking1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num_stocktaking1 = mysqli_num_rows($exec_stocktaking1); 

					  ?>

                      <td width="108" align="left" valign="middle" class="bodytext32"><?php 					  

  						if($trans_status==0){

							echo "<span class='bodytext32' style='color:red'> Can't Process </span>";

						}else{	

					  		echo $toname;

						}

						?>

                      <input type="hidden" name="fromstore" id="fromstore" value="<?php echo $to; ?>">

                      

                      </td>

                      <td width="55" align="middle" valign="middle" class="bodytext32"><strong>To </strong></td>

                      <td colspan="2" align="left" valign="middle" class="bodytext32"><?php echo $fromname; ?>

                          <input type="hidden" name="tostore" id="tostore" size="18" autocomplete="off" value="<?php echo $from; ?>"></td>

                      <input name="searchtostore1hiddentextbox" id="searchtostore1hiddentextbox" type="hidden" value="">

                      <input name="searchtostoreanum1" id="searchtostoreanum1" value="" type="hidden">

                      <td width="120" align="middle" valign="middle"><span class="bodytext32"><strong>Date</strong></span></td>

					  <td align="left" valign="top"><span class="bodytext32">&nbsp;

					    <input name="date" type="text" id="date" style="border: 1px solid #001E6A;" value="<?php echo $updatedatetime; ?>" size="8" autocomplete="off" readonly>

					  </span></td>

					  <td width="389" rowspan="2" align="left" valign="top"><span class="bodytext32">

					  <font color="blue"><strong>Please note:</strong> The items with proper batches will only affect the stock  transfers, items with out batches will be rejected automatically. </font>

  

					  </span></td>

                    </tr>

                    <tr>

                      <td align="left" valign="top" class="bodytext32"><strong>Type Transfe</strong>r</td>

                      <td align="left" valign="top" class="bodytext32"><?php echo $typetransfer1; ?></td>

					  <?php 

					  if($typetransfer == 'Consumable')

					  {

					  ?>

					  <td align="left" valign="top" class="bodytext32"><strong>Select Expense</strong></td>

					  <td align="left" valign="top" class="bodytext32">

                      <input type="text" name="expensename" id="expensename" size="30" autocomplete="off" value="">

                      <input type="hidden" name="expense" id="expense" value="">

                    </td>

                    <?php

                    }

                    ?> 

                    </tr>
					<?php
					 //include_once("store_stocktaking_chk1.php");
					 if($num_stocktaking > 0 || $num_stocktaking1 > 0) {
					  ?>
					  <tr><td colspan="11" class="bodytext3"><font color='red' size='6px'><strong>Stock Take in process. Transactions are Frozen.</strong></font></td></tr>
					  <?php
					 }else{
					 ?>

                     <tr>

                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ffffff"><strong>NO</strong></td>

                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ffffff"><strong>Item</strong></td>

                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ffffff"><strong>Req.Qty</strong></td>

                      <td align="center" valign="middle" class="bodytext32" bgcolor="#ffffff"><strong>Batch</strong></td>

                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ffffff"><strong>Exp.Dt</strong></td>

                      <td width="52" align="left" valign="middle" bgcolor="#ffffff" class="bodytext32"><strong>Avl.Qty</strong></td>

                      <td width="44" align="left" valign="middle" bgcolor="#ffffff" class="bodytext32"><strong>Trn.Qty</strong></td>

                      <td width="44" align="left" valign="middle" bgcolor="#ffffff" class="bodytext32"><strong>Pending Qty</strong></td>

                      <td align="center" valign="middle" class="bodytext32" bgcolor="#ffffff"><strong>Cost</strong></td>

                      <td width="25" align="left" valign="middle" bgcolor="#ffffff" class="bodytext32"><strong>Amount</strong></td>

					  <td width="25" align="left" valign="middle" bgcolor="#ffffff" class="bodytext32"><strong>Delete</strong></td>					  

                    </tr>

                    <?php

					$sno ='';
					$inc =0;
					$colorloopcount=0;

					

					$query34 = "select * from master_internalstockrequest where docno='$docno' and recordstatus = 'pending'";

					$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

					$nums34 = mysqli_num_rows($exec34);

					while($res34 = mysqli_fetch_array($exec34))

					{

					$itemname = $res34['itemname'];

					$reqquantity = $res34['quantity'];

					$itemcode = $res34['itemcode'];

					$frommstore = $res34['fromstore'];

					$toostore = $res34['tostore'];

					$anum = $res34['auto_number'];

					$requestdocno = $res34['docno'];

					$balance_qty1 = $res34['balance_qty'];

					if($balance_qty1 == 0){

						$balance_qty = $reqquantity - $balance_qty1;

					} else {

						$balance_qty = $res34['balance_qty'];

					}
					$inc += 1;
					if($balance_qty>0){

						$colorloopcount = $colorloopcount + 1;
						$showcolor = ($colorloopcount & 1); 
						if ($showcolor == 0) { $colorcode = 'bgcolor="#CBDBFA"';
						}else{ $colorcode = 'bgcolor="#ecf0f5"'; }

					 
					?>
					
					<tr  <?=$colorcode;?> style="cursor: pointer;">
					<!-- 	<div class="plus<?=$inc;?>" onClick="return funcShowView(<?=$inc;?>)"><tr  <?=$colorcode;?> ></div>
						 	<div class="minus<?=$inc;?>"  onClick="return funcHideView(<?=$inc;?>)"><tr  <?=$colorcode;?> ></div> -->
					 <!-- onClick="return funcHideView(<?=$inc;?>); -->
						 <td align="left" valign="middle" colspan="2" class="bodytext32">
						 		<div class="plus<?=$inc;?>" onClick="return funcShowView(<?=$inc;?>)"><?php echo $itemname; ?></div>
						 	<div class="minus<?=$inc;?>"  onClick="return funcHideView(<?=$inc;?>)"><?php echo $itemname; ?></div>
						 	</td>
						 <td align="left" valign="middle" colspan="1" class="bodytext32"><?php //echo $reqquantity; ?>
						 	<div class="plus<?=$inc;?>" onClick="return funcShowView(<?=$inc;?>)"><?php echo $reqquantity; ?></div>
						 	<div class="minus<?=$inc;?>"  onClick="return funcHideView(<?=$inc;?>)"><?php echo $reqquantity; ?></div>
						 </td>
						 <td  valign="middle"  class="bodytext32" align="center">

						 	<div class="plus<?=$inc;?>"><img src="images2/cal_plus.gif" width="13" height="13" onClick="return funcShowView(<?=$inc;?>)">&nbsp;</div>
						 	<div class="minus<?=$inc;?>"><img src="images2/cal_minus.gif" width="13" height="13" onClick="return funcHideView(<?=$inc;?>)">&nbsp;</div>
						 </td>
						 <td>
						 	<div class="plus<?=$inc;?>" onClick="return funcShowView(<?=$inc;?>)">&nbsp;</div>
						 	<div class="minus<?=$inc;?>"  onClick="return funcHideView(<?=$inc;?>)">&nbsp;</div>
						 </td>
						  <td>
						 	<div class="plus<?=$inc;?>" onClick="return funcShowView(<?=$inc;?>)">&nbsp;</div>
						 	<div class="minus<?=$inc;?>"  onClick="return funcHideView(<?=$inc;?>)">&nbsp;</div>
						 </td>
						  <td>
						 	<div class="plus<?=$inc;?>" onClick="return funcShowView(<?=$inc;?>)">&nbsp;</div>
						 	<div class="minus<?=$inc;?>"  onClick="return funcHideView(<?=$inc;?>)">&nbsp;</div>
						 </td>

						 <td align="left" valign="middle"   class="bodytext32"><input class="bal" type="text" name="pending_qty[<?= $inc ?>]" id="pending_qty<?php echo $inc; ?>" size="6" value="<?php echo $balance_qty; ?>" readonly ></td>
						 
						<td>
							<div class="plus<?=$inc;?>" onClick="return funcShowView(<?=$inc;?>)">&nbsp;</div>
							<div class="minus<?=$inc;?>"  onClick="return funcHideView(<?=$inc;?>)">&nbsp;</div>
						</td>
						<td>
							<div class="plus<?=$inc;?>" onClick="return funcShowView(<?=$inc;?>)">&nbsp;</div>
							<div class="minus<?=$inc;?>"  onClick="return funcHideView(<?=$inc;?>)">&nbsp;</div>
						</td>
												  

							<td> 
								<a href="stocktransfer.php?st=del&&anum=<?php echo $anum;?>&&docno=<?php echo $docno;?>" class="bodytext32"  onClick="return funcDeleteMedicine('<?php echo $itemname;?>')">
								<font color="blue"><strong>Delete</strong></font></a></div>
							</td>

						 
						 <!-- <td align="left" valign="middle" colspan="7" class="bodytext32"><img src="images/plus1.gif" width="13" height="13" onDblClick="return funcHideView(<?=$inc;?>)"  onClick="return funcShowView(<?=$inc;?>)"></td> -->
					</tr>
					<?php

					

					

					$query751 = "select * from master_store where storecode='$toostore'";

					$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

					$res751 = mysqli_fetch_array($exec751);

					$locationnumber = $res751['location'];

					

					$query551 = "select * from master_location where auto_number='$locationnumber'";

					$exec551 = mysqli_query($GLOBALS["___mysqli_ston"], $query551) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

					$res551 = mysqli_fetch_array($exec551);

					$location = $res551['locationname'];

					$locationcode = $res551['locationcode'];

					

					$store = $frommstore;

					

									

					$companyanum = $_SESSION["companyanum"];

					$itemcode = $itemcode;

					

	//include ('autocompletestockcount1include1.php');

							

					

					$query67 = "select purchaseprice,ledgercode,ledgername,ledgerautonumber from master_medicine where itemcode='$itemcode'";

					$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

					$res67 = mysqli_fetch_array($exec67);

					$costprice = $res67['purchaseprice'];

					$legdercode = $res67['ledgercode'];

					$legdername = $res67['ledgername'];

					$ledgeranum = $res67['ledgerautonumber'];
					/////////////////
					$query44="SELECT itemcode,batchnumber,batch_quantity,description,fifo_code from transaction_stock where storecode='".$toostore."' AND locationcode='".$locationcode."' AND itemcode = '$itemcode' and batch_stockstatus='1' and (batchnumber in(select batchnumber from materialreceiptnote_details where expirydate>now() and itemcode ='$itemcode') or batchnumber in(select batchnumber from purchase_details where expirydate>now() and itemcode ='$itemcode'))";

$exec44=mysqli_query($GLOBALS["___mysqli_ston"], $query44);
$numb44=mysqli_num_rows($exec44);
while($res44=mysqli_fetch_array($exec44))
{
$itemcode = $res44['itemcode'];
$batchname = $res44['batchnumber']; 
$currentstock = $res44["batch_quantity"];
$itemcode = $itemcode;
$batchname = $batchname;
$description = $res44["description"];
$fifo_code = $res44["fifo_code"];
// $expirydate = 1;
if($currentstock > 0 )
			{


$store = $toostore;

$query2 = "select expirydate,costprice,fifo_code from purchase_details where recordstatus = '' and fifo_code = '$fifo_code' and itemcode='$itemcode'";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$num2 = mysqli_num_rows($exec2);

if($num2>0)

{

 $res2 = mysqli_fetch_array($exec2);

 $expirydate = $res2['expirydate'];

 $fifo_code = $res2['fifo_code'];

}

else

{

 $query2 = "select expirydate,costprice,fifo_code from materialreceiptnote_details where recordstatus = '' and fifo_code = '$fifo_code' and itemcode='$itemcode'";

 $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

 $num2 = mysqli_num_rows($exec2);

 $res2 = mysqli_fetch_array($exec2);

 $expirydate = $res2['expirydate'];

 $fifo_code = $res2['fifo_code'];

}

// $batchname = $batchname;

	//include ('autocompletestockbatch.php');

$querybatstock2 = "select batch_quantity,rate from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcode' and fifo_code='$fifo_code' and storecode ='$store'";
$execbatstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querybatstock2) or die ("Error in batQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

$resbatstock2 = mysqli_fetch_array($execbatstock2);

$bat_quantity = $resbatstock2["batch_quantity"];
$costprice=$resbatstock2['rate'];
					/////////////////////

					$sno = $sno + 1;

					?>
					 <input class="bal" type="hidden" name="pending_qty_single[<?= $sno ?>]" id="pending_qty_single<?php echo $sno; ?>" size="6" value="<?php echo $balance_qty; ?>" readonly > 

                    <tr class="list<?=$inc;?>" id="list<?=$inc;?>">
                      <td align="left" valign="middle" class="bodytext32"><?php echo $sno; ?>
					  <input type="hidden" name="numrows" id="numrows" value="<?php echo $nums34; ?>">
					  </td>
                      <!-- <td align="left" valign="middle" class="bodytext32"><?php echo $itemname; ?> -->
				<input name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox" type="hidden" value="">
			  	<input name="searchmedicineanum1" id="searchmedicineanum1" value="" type="hidden">

                          <input type="hidden" name="rownumber[<?= $sno ?>]" id="rownumber" value="<?= $sno ?>">

					  

                          <input type="hidden" name="itemname[<?= $sno ?>]" id="itemname" value="<?php echo $itemname; ?>">

                          <input type="hidden" name="itemcode[<?= $sno ?>]" id="itemcode<?php echo $sno; ?>" value="<?php echo $itemcode; ?>">

                          <input type="hidden" name="legdercode[<?= $sno ?>]" id="legdercode<?php echo $sno; ?>" value="<?php echo $legdercode; ?>">

                          <input type="hidden" name="legdername[<?= $sno ?>]" id="legdername<?php echo $sno; ?>" value="<?php echo $legdername; ?>">

                          <input type="hidden" name="ledgeranum[<?= $sno ?>]" id="ledgeranum<?php echo $sno; ?>" value="<?php echo $ledgeranum; ?>">

                          

                          <input type="hidden" name="cost[<?= $sno ?>]" id="cost<?php echo $sno; ?>" value="<?php echo $costprice; ?>">
                      <td></td>

                      <!-- <td align="left" valign="middle" class="bodytext32"><?php echo $reqquantity; ?> -->

                          <input type="hidden" name="reqquantity[<?= $sno ?>]" id="reqquantity<?php echo $sno; ?>" value="<?php echo $reqquantity; ?>">
                          <td></td>

                        <td align="left" valign="top">
                        	<input  class="bal"  type="text" name="batchbatch" value="<?php echo $batchname.'('.$currentstock.')'; ?>">
                      	 
                   				<input  class="bal" type="hidden" value="<?php echo $fifo_code ;?>" name="batch[<?= $sno ?>]" id="batch<?php echo $sno; ?>"  >
                   				<!-- onClick="return funcbatchselection('<?php echo $sno; ?>')" -->
                   				 
                  </td>

                      <td align="left" valign="middle"><input type="text" name="expirydate" value="<?=$expirydate?>" id="expirydate<?php echo $sno; ?>" class="bal" size="10" readonly></td>

                      <td align="left" valign="middle"><input type="text" name="availablestock" value="<?=$bat_quantity?>" id="availablestock<?php echo $sno; ?>" class="bal" size="10" readonly></td>

                      <!-- <td align="left" valign="middle"><input type="text" name="expirydate" id="expirydate<?php echo $sno; ?>" class="bal" size="10" readonly></td> -->

                      <!-- <td align="left" valign="middle"><input type="text" name="availablestock" id="availablestock<?php echo $sno; ?>" class="bal" size="10" readonly></td> -->

                      <td align="left" valign="middle" class="bodytext32"><input type="text" name="transferqty[<?= $sno ?>]" id="transferqty<?php echo $sno; ?>" size="6" onKeyUp="amountcalc('<?php echo $sno; ?>','<?php echo $inc; ?>','<?=$numb44;?>'), cal_change('<?php echo $sno; ?>','<?php echo $inc; ?>','<?=$numb44;?>');;" onKeyPress="return number(event)" class="abc<?=$inc.'-'.$sno;?>" onChange="return cal_change('<?php echo $sno; ?>','<?php echo $inc; ?>','<?=$numb44;?>');"></td>

                      <td align="left" valign="middle" class="bodytext32"><input type="hidden" name="balance_qty[<?= $sno ?>]" id="balance_qty<?php echo $sno; ?>" size="6" value="<?php echo $balance_qty; ?>" readonly ></td>

                      <td align="left" valign="middle" class="bodytext32"><input type="text" id="costprice<?php echo $sno; ?>" name="cost[<?= $sno ?>]" class="bal" value="<?php echo $costprice; ?>" readonly></td>

                      <td align="left" valign="middle"><input type="text" name="amount[<?= $sno ?>]" id="amount<?php echo $sno; ?>" class="bal" size="10" readonly></td>

					 <td></td>

						

                      <?php

			  

	?>

                    </tr>

                    <?php }

					}
				}
			}

					?>
					<input type="hidden" id="incriment" value="<?=$inc;?>">
					<input type="hidden" id="sno" value="<?=$sno;?>">

                    <tr>

                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>

                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>

                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>

                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>

                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>

                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>

                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>

                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>

                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>

					  <td align="left" valign="middle" class="bodytext32" bgcolor="#ecf0f5">&nbsp;</td>

                      <td width="50" align="left" valign="middle" bgcolor="#ecf0f5" class="bodytext32">&nbsp;</td>

                    </tr>

                  <td align="left" valign="middle" class="bodytext32"></td>

                      <td align="left" valign="top">&nbsp;</td>

                    <td align="left" valign="top">&nbsp;</td>

                    <td align="left" valign="top">&nbsp;</td>

                    <td align="left" valign="top">&nbsp;</td>

                    <td align="left" valign="top">&nbsp;</td>

                    <td align="left" valign="top">&nbsp;</td>

                    <td align="left" valign="top">&nbsp;</td>

                    <td align="left" valign="top">

					<input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                    <?php

					if($trans_status==1){ ?>

                          <input  style="border: 1px solid #001E6A" type="submit" value="Save" name="Submit" id="savebutton" onClick="return medicinecheck();"/>

                    <?php } ?>      

                    </td>

					<td align="left" valign="top">

					<!-- <a href="editstocrequest.php?docno=<?php echo $docno;?>" class="bodytext32"><font color="blue"><strong>Add New</strong></font> </a> &nbsp;&nbsp;

                  

                  <a href="print_stockrequest.php?docno=<?php echo $docno;?>" target="_blank" class="bodytext32"><img src="images25/pdfdownload.jpg" width="40"></a> -->

                  

                  </tr>
				  <?php } ?>

                </table>

              </form>		</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

   

    </table>

</table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>




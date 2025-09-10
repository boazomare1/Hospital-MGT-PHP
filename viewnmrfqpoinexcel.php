<?php
//include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$totalsum = 0;
$currentdate = date("Y-m-d");
$currenttime = date("H:i:s");

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Purchaseorder.xls"');
header('Cache-Control: max-age=80');

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billnumber"]; } else { $billautonumber = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
$pono = $_REQUEST['pono'];
$suppliercode = $_REQUEST['suppliercode'];
$suppliername = $_REQUEST['suppliername'];
foreach($_POST['itemname'] as $key => $value)
{
$itemname = $_POST['itemname'][$key];
$itemcode = $_POST['itemcode'][$key];
$remarks = $_POST['remarks'][$key];
$amount = $_POST['amountval'][$key];
$packagequantity = $_POST['packagequantity'][$key];

$query34 = "update master_rfq set packagequantity='$packagequantity',remarks='$remarks',amount = '$amount' where suppliercode='$suppliercode' and medicinecode='$itemcode' and status = 'generated'";
$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"])); 
}
		for ($p=1;$p<=20;$p++)
		{	
		 	
if (isset($_REQUEST['medicinename'.$p])) { $medicinename = $_REQUEST['medicinename'.$p]; } else { $medicinename = ""; }
if($medicinename != '')
{
		    $medicinename = $_REQUEST['medicinename'.$p];
			$query77="select * from master_medicine where itemname='$medicinename'";
			$exec77=mysqli_query($GLOBALS["___mysqli_ston"], $query77);
			$res77=mysqli_fetch_array($exec77);
			$medicinecode=$res77['itemcode'];
			$packsize = $res77['packagename'];
			$reqqty = $_REQUEST['reqqty'.$p];
		    $pkgqty = $_REQUEST['pkgqty'.$p];
			$rate = $_REQUEST['rate'.$p];
			$amt = $_REQUEST['amount'.$p];
			
						  
			  $query52="select * from master_rfqpurchaseorder where suppliercode='$suppliercode' and itemcode='$medicinecode'";
			  $exec52=mysqli_query($GLOBALS["___mysqli_ston"], $query52) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			  $num52=mysqli_num_rows($exec52);
			  $res52=mysqli_fetch_array($exec52);
			  $existingquantity = $res52['packagequantity'];
			  $existingamount = $res52['amount'];
			  
			  $totalquantity = $existingquantity+$pkgqty;
			  $amount = $existingamount+$amt;
			
			if($num52 == 0)
			{
			if ($medicinename != "")
			{
		  $query43="insert into master_rfq(medicinename,medicinecode,packagequantity,rate,amount,username,status,companyanum,suppliername,suppliercode,packsize,ipaddress)values
		                 ('$medicinename','$medicinecode','$reqqty','$rate','$amount','$username','generated','$companyanum','$suppliername','$suppliercode','$packsize','$ipaddress')";
				$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		 
			
			$query21 = "insert into master_rfqpurchaseorder(itemname,itemcode,username,recordstatus,companyanum,suppliername,suppliercode,billnumber,billdate,ipaddress)values('$medicinename','$medicinecode','$username','generated','$companyanum','$suppliername','$suppliercode','$pono','$currentdate','$ipaddress')";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	
			}
				}
				else
				{
				if ($medicinename != "")
				{
				$query11="update master_rfq set packagequantity='$totalquantity',amount='$amount' where suppliercode='$suppliercode' and medicinecode='$medicinecode'";
				$exec11=mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			}
				}
				}
				}

//header("location:rfqviewpurchaseorders.php");

}

?>
<?php 
if(isset($_REQUEST['itemcode']))
{
$item=$_REQUEST['itemcode'];
$bill=$_REQUEST['billnumber'];
$query23 = "update master_rfqpurchaseorder set recordstatus='deleted' where itemcode='$item' and billnumber='$bill'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

}
?>
<?php
if(isset($_REQUEST['billnumber']))
{
$pono = $_REQUEST['billnumber'];
$query55 = "select * from master_nmrfqpurchaseorder where billnumber='$pono' and goodsstatus = ''";
$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55=mysqli_fetch_array($exec55);
$suppliername = $res55['suppliername'];
$suppliercode = $res55['suppliercode'];


$query66 = "select * from master_supplier where suppliercode='$suppliercode'";
$exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res66 = mysqli_fetch_array($exec66);
$addressname = $res66['address1'];
$address = $addressname;
$addressname1 = $res66['address2'];
if($addressname1 != '')
{
$address = $address.','.$addressname1;
}
$area = $res66['area'];
if($area != '')
{
$address = $address.','.$area;
}
$city = $res66['city'];
if($city !='')
{
$address = $address.','.$city;
}
$state = $res66['state'];
if($state !='')
{
$address = $address.','.$state;
}
$country = $res66['country'];
if($country !='')
{
$address = $address.','.$country;
}
$telephone2 = $res66['mobilenumber'];
$tele=$telephone2;
$telephone = $res66['phonenumber1'];
if($telephone != '')
{
$tele=$tele.','.$telephone;
}
$telephone1 = $res66['phonenumber2'];
if($telephone1 != '')
{
$tele=$tele.','.$telephone1;
}

$email = $res66['emailid1'];
$email1 = $res66['emailid2'];
if($email1 != '')
{
$email = $email.','.$email1;
}
}
?>

<script language="javascript">

function cbcustomername1()
{
	document.cbform1.submit();
}
function calc()
{
var reqqty=document.getElementById("reqqty").value;
var packsize=document.getElementById("packsize").value;

var packvalue=packsize.substring(0,packsize.length - 1);
var rate=document.getElementById("rate").value;
var amount=parseFloat(reqqty) * parseFloat(rate);
document.getElementById("amount").value=amount.toFixed(2);
var pkgqty=reqqty/packvalue;
packvalue=parseInt(packvalue);
if(reqqty < packvalue)
{
pkgqty=1;
}


document.getElementById("pkgqty").value=Math.round(pkgqty);
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
function funcOnLoadBodyFunctionCall()
{


	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	 //To handle ajax dropdown list.
	funcCustomerDropDownSearch4();
	funcPopupPrintFunctionCall();
	
}
function btnDeleteClick10(delID4,vrate4)
{
	//alert ("Inside btnDeleteClick.");
	var newtotal;
	//alert(delID4);
	var varDeleteID4= delID4;
	//alert(vrate4);
	
	//alert(rateref);
	//alert (varDeleteID3);
	var fRet7; 
	fRet7 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet7 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child4 = document.getElementById('idTR'+varDeleteID4);  
	//alert (child3);//tr name
    var parent4 = document.getElementById('insertrow'); // tbody name.
	document.getElementById ('insertrow').removeChild(child4);
	
	var child4= document.getElementById('idTRaddtxt'+varDeleteID4);  //tr name
    var parent4 = document.getElementById('insertrow'); // tbody name.
	
	if (child4 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow').removeChild(child4);
	}

	var currenttotal=document.getElementById('total').value;
	//alert(currenttotal);
	newtotal= currenttotal-vrate4;
	
	//alert(newtotal);
	
	document.getElementById('total').value=newtotal.toFixed(2);
		
}
function amountcalc(varserialnumber)
{
var varserialnumber= varserialnumber;
var receivedquantity = document.getElementById("packagequantity"+varserialnumber+"").value;
var rate = document.getElementById("rate"+varserialnumber+"").value;
if(receivedquantity != '')
{
var amount = parseFloat(receivedquantity) * parseFloat(rate);
}
document.getElementById("amount"+varserialnumber+"").value = amount.toFixed(2);
}

function deletevalid()
{
var del;
del=confirm("Do You want to delete this medicine ?");
if(del == false)
{
return false;
}
}
</script>
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form method="post" name="form1" action="viewrfqpo.php">
<table cellspacing="0" cellpadding="4" width="900" 
            align="left" border="0">
          <tbody>
            
			<?php
			if ($st == 'success' && $billautonumber != '')
			{
			?>
            
			<?php
			}
			?>
			  <!--<tr>
			    <td width="7%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>PO No</strong></td>
                <td width="25%" align="left" valign="top" class="bodytext3"><?php echo $pono; ?>
				<input type="hidden" name="pono" id="pono" value="<?php echo $pono; ?>" style="border: 1px solid #001E6A;" size="10" autocomplete="off" readonly="readonly"/>                  </td>
                 <td width="15%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Date</strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $currentdate; ?>
				<input type="hidden" name="date" id="date" value="<?php echo $currentdate; ?>" style="border: 1px solid #001E6A" size="10" rsize="20" readonly="readonly"/>				</td>
			    </tr>
				<tr>
			    <td width="7%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Supplier</strong></td>
                <td width="25%" align="left" valign="top" class="bodytext3"><?php echo $suppliername; ?> & <?php echo $suppliercode; ?>
				<input type="hidden" name="suppliercode" id="suppliercode" value="<?php echo $suppliercode; ?>" />
				<input type="hidden" name="suppliername" id="suppliername" value="<?php echo $suppliername; ?>" style="border: 1px solid #001E6A;" size="20" autocomplete="off" readonly="readonly"/>                  </td>
                 <td width="15%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Telephone</strong></td>
                <td width="15%" align="left" valign="top" class="bodytext3"><?php echo $tele; ?>
				<input type="hidden" name="telephone" id="telephone" value="<?php echo $tele; ?>" style="border: 1px solid #001E6A;" size="20" autocomplete="off" readonly="readonly"/>                  </td>
			    </tr>
				<tr>
			   <td width="7%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Address</strong></td>
                <td width="25%" align="left" valign="top" class="bodytext3"><?php echo $address; ?>
				<input type="hidden" name="address" value="<?php echo $address; ?>"></td>
				   <td width="15%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Email</strong></td>
				  <td width="15%" align="left" valign="top" class="bodytext3"><?php echo $email; ?>
				<input type="hidden" name="email" id="email" value="<?php echo $email; ?>" style="border: 1px solid #001E6A;" size="20" autocomplete="off" readonly="readonly"/>                  </td>
			    </tr>
				<tr>
				  <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
				</tr>-->
		     <tr>
    <td colspan="4">
	Ruaraka Uhai Neema Hospital <br />
	P.o.Box 65122-00618, Ruaraka, Nairobi, Kenya.<br/>
	Tel: +254.20.2535326  Email: info@runeemahospital.org	</td>
	<!--<td colspan="4" align="right">
	
	  <?php
			$query2showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec2showlogo = mysqli_query($GLOBALS["___mysqli_ston"], $query2showlogo) or die ("Error in Query2showlogo".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res2showlogo = mysqli_fetch_array($exec2showlogo);
			$showlogo = $res2showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
      <img src="logofiles/<?php echo $companyanum;?>.jpg" width="75" height="75" />
      <?php
			}
			?>
      &nbsp;</td>-->
  </tr>		
             <tr>
               <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
             </tr>
             <tr>
               <td colspan="8"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>PURCHASE ORDER </strong></td>
               </tr>
             <tr>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Company</strong></td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><?php echo $suppliername; ?></td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
             </tr>
             <tr>
               <td colspan="8"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">Reference to your quotation: </td>
               </tr>
             <tr>
               <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
             </tr>
             <tr>
               <td colspan="8"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">We request you to supply us with the following items in the list below:</td>
               </tr>
             <tr>
               <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
               <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
             </tr>
             <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>S. No.</strong></div></td>
				 <td width="28%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Description</strong></td>
				<td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Qty</strong></div></td>
				
			   <td width="10%"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Unit Price </strong></div></td>
				<td width="10%"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total KSHS</strong></div></td>

				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Brand</strong></div></td>
				</tr>
			
            
			<?php
			$colorloopcount = '';
			$sno = '';
		$query34="select * from master_nmrfqpurchaseorder where billnumber='$pono' and recordstatus='generated' and goodsstatus = '' group by itemname";
		$exec34=mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num34 = mysqli_num_rows($exec34);
		while($res34=mysqli_fetch_array($exec34))
			{
			$totalquantity =0;
			$amount = 0;
			$itemname=$res34['itemname'];
			//$itemcode=$res34['itemcode'];
			$suppliercode = $res34['suppliercode'];
		
		$query35="select * from master_nmrfq where suppliercode='$suppliercode' and status='generated' and itemname='$itemname' order by auto_number desc";
		$exec35=mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res35=mysqli_fetch_array($exec35);
		$totalquantity = $res35['quantity'];
		$rate = $res35['rate'];
		$amount = $res35['amount'];
		//$packsize = $res35['packsize'];
		$totalsum = $totalsum + $amount;
		
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
			  <tr>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $itemname; ?></div></td>
				<input type="hidden" name="itemname[]" value="<?php echo $itemname; ?>">
				<input type="hidden" name="itemcode[]" value="<?php echo $itemcode; ?>">
				
				<td class="bodytext31" valign="center"  align="center"><?php echo $totalquantity; ?></td>
				<td class="bodytext31" valign="center" align="right" style='mso-number-format:"\@"; '><?php echo $rate; ?></td>
				<td  align="right" valign="center" style='mso-number-format:"\@"; ' class="bodytext31"><?php echo number_format($amount,2,'.',','); ?>
				  <input type="hidden" size="6" name="amountval[]" id="amount<?php echo $sno ;?>" value="<?php echo $amount; ?>" class="bal" readonly="readonly" /></td>
				<td class="bodytext31" valign="center"  align="left"> <div align="right"></div></td>
				</tr>
			  <?php
			}
			?>
              <tr>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              </tr>
              <tr>
                <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Total Amount </strong></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">(in number)</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">(in letter)</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">Currency</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              </tr>
              <tr>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff" style='mso-number-format:"\@"; '><?php echo number_format($totalsum,2,'.',','); ?></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="align" 
                bgcolor="#ffffff">KES</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Invoice should be addressed to </strong></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="6">&nbsp;</td>
              </tr>
              <tr>
               <td colspan="6">
				Ruaraka Uhai Neema Hospital <br />
				P.o.Box 65122-00618, Ruaraka, Nairobi, Kenya.<br/>
				Tel: +254.20.2535326  Email: info@runeemahospital.org			 </td>
			 </tr>
			  <tr>
			    <td colspan="8">&nbsp;</td>
		    </tr>
			  <tr>
			    <td colspan="8"><strong>Project::</strong></td>
		    </tr>
			  <tr>
			    <td colspan="8"><strong>Budget Code:</strong></td>
		    </tr>
			  <tr>
               <td colspan="8"><strong>LPO Validity:</strong></td>
			 </tr>
			  <tr>
			    <td colspan="8"><strong>Warranty:</strong></td>
		    </tr>
			  <tr>
			    <td><strong>Delivery/transport:</strong><br /></td>
			    <td colspan="3">Neema Preventive and Diagnostic Center, Located in Nairobi </td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
		    </tr>
			  <tr>
			    <td>&nbsp;</td>
				<td colspan="3">Kasarani Lane, Off Babadogo, by the supplier</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
		      </tr>
			  <tr>
			    <td colspan="8"><strong>Terms of Payment: </strong></td>
		    </tr>
			  <tr>
			    <td colspan="8">&nbsp;</td>
		    </tr>
			  <tr>
			    <td colspan="8">&nbsp;</td>
		    </tr>
			  <tr>
			    <td colspan="8">&nbsp;</td>
		    </tr>
			  <tr>
			    <td><strong>Date:  <?php echo date('d-m-y',strtotime($currentdate)); ?></strong></td>
		        <td>&nbsp;</td>
				<td>&nbsp;</td>
			    <td>&nbsp;</td>
                <td>&nbsp;</td>
				<td><strong>Signature:</strong></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>   
				
		    </tr>
          </tbody>
        </table>
</form>


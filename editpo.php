<?php

session_start();

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

$currenttime = date("H:i:s");



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$st = $_REQUEST['st'];

if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }

//$st = $_REQUEST['st'];

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

if ($frm1submit1 == 'frm1submit1')

{

$pono = $_REQUEST['pono'];

foreach($_POST['itemname'] as $key => $value)

{

$itemname = $_POST['itemname'][$key];

$itemcode = $_POST['itemcode'][$key];

$remarks = $_POST['remarks'][$key];

$packagequantity = $_POST['packagequantity'][$key];

$totalquantity = $_POST['totalquantity'][$key];

$amount = $_POST['existamount'][$key];

$packagename = $_POST['packagename'][$key];



$query34 = "UPDATE purchaseorder_details set packagequantity='$packagequantity',remarks='$remarks',packsize='$packagename',quantity='$totalquantity',totalamount='$amount' where billnumber='$pono' and itemcode='$itemcode'";

$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"])); 

}
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

.number

{

padding-left:690px;

text-align:right;

font-weight:bold;

}

-->

</style>



<script>

function updatechange()

{
var rate=document.getElementById("change_q").value;

var qty=document.getElementById("qty").value;


var amount = parseFloat(rate) * parseFloat(qty);

//document.getElementById("tprice").value=x.toFixed(2);
// document.getElementById("tprice").value=Math.round(x);


document.getElementById("amounttd").innerHTML = formatMoney(amount.toFixed(2));
// calculate tax amount
var taxper = document.getElementById("taxper").value;

var taxamount = parseFloat(amount) * parseFloat((taxper / 100));

document.getElementById("taxamount").value = taxamount.toFixed(2);
document.getElementById("taxamounttd").innerHTML = formatMoney(taxamount.toFixed(2));
var taxamt = document.getElementById("taxamount").value;

var totalamount = parseFloat(amount) + parseFloat(taxamt);

document.getElementById("tprice").value=totalamount.toFixed(2);

}

function updarate()
{
	var discount=document.getElementById("discount").value;
	
	if(discount>100)
	{
	document.getElementById("discount").value=100;	
	}
	var original_rate=document.getElementById("original_rate").value;
	var discount=document.getElementById("discount").value;
	if(discount=='')
	{
	discount=0;	
	}
	var cal_rate=(parseFloat(discount)/100)*parseFloat(original_rate);
	var new_rate=parseFloat(original_rate)-parseFloat(cal_rate);
	document.getElementById("change_q").value=new_rate.toFixed(2);
	updatechange();
}

function validatenumerics(key) {

           //getting key code of pressed key

           var keycode = (key.which) ? key.which : key.keyCode;

           //comparing pressed keycodes



           if (keycode > 31 && (keycode < 48 || keycode > 57)) {

               //alert(" You can enter only characters 0 to 9 ");

               return false;

           }

           else return true;

 



       } 
function formatMoney(number, places, thousand, decimal) {

  number = number || 0;

  places = !isNaN(places = Math.abs(places)) ? places : 2;

  

  thousand = thousand || ",";

  decimal = decimal || ".";

  var negative = number < 0 ? "-" : "",

      i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",

      j = (j = i.length) > 3 ? j % 3 : 0;

  return  negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");



}

</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.bal

{

border-style:none;

background:none;

text-align:right;

FONT-FAMILY: Tahoma;

FONT-SIZE: 11px;

}

-->

</style>

</head>



<body >






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

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1050" 

            align="left" border="0">

          <tbody>
          	<?php
          	$aum = $_GET['anum'];
          	$totamountval_det=0;
          	$qrypodetailed = "SELECT * FROM purchaseorder_details WHERE auto_number = '$aum' AND recordstatus<>'deleted'";

				$execpodetailed = mysqli_query($GLOBALS["___mysqli_ston"], $qrypodetailed) or die ("Error in qrypodetailed".mysqli_error($GLOBALS["___mysqli_ston"]));

				while($respodetailed = mysqli_fetch_array($execpodetailed))
				{
					$purchaseindentdocno = $respodetailed["purchaseindentdocno"];
					$pono = $respodetailed["billnumber"];
					$suppliername = $respodetailed["suppliername"];
					$suppliercode = $respodetailed["suppliercode"];
		$billdate_det = $respodetailed["billdate"];
		

		$itemcode_det = $respodetailed["itemcode"];

		$itemname_det = $respodetailed["itemname"];


		$rate_det = $respodetailed["rate"];

		$pkgqnty_det = $respodetailed["packagequantity"];

		$username_det = $respodetailed["username"];

		$fxamount_det = $respodetailed["totalamount"];
		$totamountval_det = $totamountval_det + $fxamount_det;


		$po_freeqty_det = $respodetailed["free"];

    $taxpercentage = $respodetailed["itemtaxpercentage"];

    $taxamount = $respodetailed["itemtaxamount"];

    $amount = $rate_det * $pkgqnty_det;
// fxpkrate
// fxtotamount
// baserate
		


				}

				if(isset($_POST['submitq'])){
					$change_q=$_POST['change_q'];
					$tprice=$_POST['tprice'];
          $taxamount = $_POST['taxamount'];
          $qty = $_POST['qty'];

				$query3412 = "UPDATE purchaseorder_details set rate='$change_q',fxpkrate='$change_q',totalamount='$tprice',fxtotamount='$tprice',itemtaxamount='$taxamount', updateratedate='$currentdate', updateuser='$username',packagequantity='$qty', quantity='$qty' where billnumber='$pono' and auto_number = '$aum' ";
					$exec3412 = mysqli_query($GLOBALS["___mysqli_ston"], $query3412) or die(mysqli_error($GLOBALS["___mysqli_ston"])); 

					$query34122 = "UPDATE purchase_indent set rate='$change_q',fxpkrate='$change_q',baserate='$change_q',amount='$tprice',fxtotamount='$tprice',tax_amount='$taxamount',packagequantity='$qty', quantity='$qty' where medicinecode='$itemcode_det' and docno = '$purchaseindentdocno' ";
					$exec34122 = mysqli_query($GLOBALS["___mysqli_ston"], $query34122) or die(mysqli_error($GLOBALS["___mysqli_ston"])); ?>

					<script> document.location.href="purchase_order_edit.php?pono=<?=$pono;?>";</script>
				<?php }


          	?>
            

			

			  <tr>

			    <td width="7%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>PO No</strong></td>

                <td width="23%" align="left" valign="top" class="bodytext3"><?php echo $pono; ?>

				<input type="hidden" name="pono" id="pono" value="<?php echo $pono; ?>" style="border: 1px solid #001E6A;" size="10" autocomplete="off" readonly/>                  </td>

				<td width="7%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>PI No</strong></td>

                <td width="23%" align="left" valign="top" class="bodytext3"><?php echo $purchaseindentdocno; ?></td>

                 <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Date</strong></td>

                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $currentdate; ?>

				<input type="hidden" name="date" id="date" value="<?php echo $currentdate; ?>" style="border: 1px solid #001E6A" size="10" rsize="20" readonly/>				</td>

			    </tr>

				<tr>

			    <td width="7%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Supplier</strong></td>

                <td width="23%" align="left" valign="top" class="bodytext3"><?php echo $suppliername; ?> & <?php echo $suppliercode; ?>

				<input type="hidden" name="suppliername" id="suppliername" value="<?php echo $suppliername; ?>" style="border: 1px solid #001E6A;" size="20" autocomplete="off" readonly/>                  </td>

                 

               

			    </tr>

				 

			    

				<tr>

				  <td class="bodytext31" valign="center"  align="left">&nbsp;</td>

				</tr>

            <tr bgcolor="#ffffff">

                <!-- <td width="" class="bodytext31" valign="middle"  align="center">S.No</td> -->
                <td>&nbsp;</td>
			    <td width="10%"   align="left" valign="middle"  class="bodytext31">Date</td>

				<td width=""  align="left" valign="middle" class="bodytext31">Item Code</td>

                <td width="25%"  align="left" valign="middle" class="bodytext31">Item Name</td>
                <td width=""  align="left" valign="middle" class="bodytext31">Discount %</td>

				<td width=""  align="center" valign="center" class="bodytext31">Rate</td>

                <td width=""  align="right" valign="right" class="bodytext31">Ord.Qty</td>

                <td width=""  align="right" valign="right" class="bodytext31">Free.Qty</td>
                <td width=""  align="right" valign="right" class="bodytext31">Tax%</td>
                <td width=""  align="center" valign="right" class="bodytext31">Amount</td>
                <td width=""  align="right" valign="right" class="bodytext31">Tax.Amt</td>

               <!--  <td width=""  align="right" valign="right" class="bodytext31">Recd.Qty</td>

                 <td width=""  align="right" valign="right" class="bodytext31">Recd.Free.Qty</td>

                 <td width=""  align="right" valign="right" class="bodytext31">Bal.Qty</td> -->

               <!--  <td width=""  align="left" valign="right" class="bodytext31"><strong>Username</strong></td> -->

                
                 <td width=""  align="center" valign="right" class="bodytext31">Total Amt</td>
                <td width=""  align="right" valign="right" class="bodytext31">Action</td>

		     </tr> 
		     <form method="POST">
		     <tr>
		     	<td>&nbsp;</td>
        <td class="bodytext31" valign="middle"  align="left"><?php echo $billdate_det;?></td>

        <td class="bodytext31" valign="middle"  align="left"><?php echo $itemcode_det;?></td>

        <td class="bodytext31" valign="middle"  align="left"><?php echo $itemname_det;?></td>

        <td class="bodytext31" valign="right"  align="right"><?php //echo $rate_det;?>
        	<input type="text" name="discount" id="discount" value=""  size="10" onkeyup="updarate()" style="text-align: right;" onkeypress="return validatenumerics(event)">
        	<input type="hidden" name="original_rate" id="original_rate" value="<?=$rate_det;?>"  >
        </td> 
		<td class="bodytext31" valign="right"  align="right"><?php //echo $rate_det;?>
        	<input type="text" name="change_q" id="change_q" value="<?=$rate_det;?>"  size="10" onkeyup="updatechange()" style="text-align: right;">
        </td>

        <td class="bodytext31" valign="right"  align="right">
          <input type="text" name="qty" style="text-align: right;" id="qty" size="7" value="<?=$pkgqnty_det;?>" onkeyup="updatechange()">
          <?php //echo $pkgqnty_det;?>
        </td>

        <td class="bodytext31" valign="right"  align="right"><?php echo $po_freeqty_det;?></td>

         <td class="bodytext31" valign="right"  align="right"><?php echo $taxpercentage;?></td>
         <input type="hidden" name="taxper" id="taxper" value="<?=$taxpercentage;?>" >

         <td class="bodytext31" id="amounttd" valign="right"  align="right"><?php echo number_format($amount, 2, '.', ',');?></td>

          <td class="bodytext31" id="taxamounttd" valign="right"  align="right"><?php echo number_format($taxamount, 2, '.', ',');?></td>
          <input type="hidden" name="taxamount" id="taxamount" value="<?=$taxamount;?>" >

        <!-- <td class="bodytext31" valign="right"  align="right"><?php echo $recqty_det;?></td>

         <td class="bodytext31" valign="right"  align="right"><?php echo $recfreeqty_det;?></td>

        <td class="bodytext31" valign="right"  align="right"><?php echo $balqty_det;?></td> -->

        <!-- <td class="bodytext31" valign="middle"  align="left"><?php echo $username_det;?></td> -->
          
        <td class="bodytext31" valign="right"  align="right"><?php //echo  number_format($fxamount_det, 2, '.', ',');?>
        	<input type="text" name="tprice" id="tprice" value="<?=$fxamount_det;?>" readonly>

        </td>
        <td class="bodytext31" valign="right"  align="right"> <input type="submit" name="submitq" value="Update"> </td>
		     </tr>
		    </form>


            <tr>

              <td colspan="12" class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
          </tr>

          </tbody>

        </table></td>

      </tr>

      

      

 </table>

</table>



<?php include ("includes/footer1.php"); ?>



</body>

</html>




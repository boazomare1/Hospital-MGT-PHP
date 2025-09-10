<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];


$billnumber = $_REQUEST["billno"];
/*$update_print_details="update kotmanual_entry_table set print_status='Printed' where tablenameid='$billnumber'";
$query_update=mysql_query($update_print_details) or die ("Error in Query".mysql_error());*/
//header("Location:kotenterypage.php");
//$billnumber = 'SBL00000007';
//echo "Hello Print World.";
$subtotaldiscounttotal = '';
$showdiscountext = '';



include ('convert_currency_to_words.php');
//$convertedwords = covert_currency_to_words($res3totalamount); //function call

?><head>
<title>Bill Printout</title>
</head>
<script language="javascript">
function funcBodyOnLoadFunction1()
{
	window.blur()  //To minimize the popup window.
	funcPrint();
	funcWindowAutoClose1()
}

function funcWindowAutoClose1()
{
	//Close after printing is complete.
	setTimeout("self.close();",10000)  //After Ten Seconds.
	//window.close();
}

function escapekeypressed()
{
	//alert(event.keyCode);
	if(event.keyCode=='27'){ window.close(); }
}

</script>

<body onkeydown="escapekeypressed()">
<table border="0" cellspacing="0" cellpadding="0">
<tr>
<td colspan="5"><div align="center">
</td>
</tr>
<tr>
<td colspan="5"><div align="center">
 
</div></td>
</tr>
<tr>
<td colspan="5"><div align="center"><?php //echo $companyname; ?>

</div></td>
</tr>
<tr>
<td colspan="5"><div align="center"><?php //echo $address1; ?>

</div></td>
</tr>
<tr>
<td colspan="5">
<div align="center">

</div></td>
</tr>
<tr>
<td colspan="5"><div align="center"><?php //echo $address3; ?>
</div>
</td>
</tr>
<?php
//if ($tinnumber1 != '')
{
?>
<tr>
  <td colspan="5"><div align="center"><?php // echo 'TIN : '.$tinnumber1; ?></div></td>
</tr>
<?php
}
?>
<?php
//if ($cstnumber1 != '')
{
?>
<tr>
  <td colspan="5"><div align="center"><?php // echo 'CST : '.$cstnumber1; ?></div></td>
</tr>
<?php
}
?>
<?php
//if ($customername != '')
{
?>
<!--<tr>
<td colspan="5">
TO: 
<?php //echo $customername; ?>
</td>
</tr>-->
<?php
}
?>
<tr>
<td colspan="5">
Bill NO: <?php echo $billnumber ?></td>
</tr>
<!--<tr>
<td colspan="5">
<?php //echo 'DATE: '.substr($billdate, 0, 10).' '.$billtime; ?></td>
</tr>-->
<!--<tr>
<td colspan="5">
<?php// echo 'Table: '.$res3tablename.'-'.$res3seatname; ?></td>
</tr>-->
<tr>
<td colspan="5">
  <div align="center">-------------------------------------------------------</div></td>
</tr>
<tr>
<td width="10%">No</td>
<td>
ITEM CODE</td>
<td >
ITEM NAME</td>

<td>QTY &nbsp;&nbsp;&nbsp;&nbsp;</td>

<td>RATE &nbsp;&nbsp;&nbsp;&nbsp; </td>

<td>TOTAL &nbsp;&nbsp;&nbsp;</td>

</tr>
<?php
$ss_kot_manual_entry_details="select * from caftorder_details where ordernumber='$billnumber'";
$query_kot_manual_entry_details=mysqli_query($GLOBALS["___mysqli_ston"], $ss_kot_manual_entry_details) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
$num_kot_manual_entry_details=mysqli_num_rows($query_kot_manual_entry_details);
if($num_kot_manual_entry_details>0)
{
$count=0;
while($ff_kot_manual_entry_details=mysqli_fetch_array($query_kot_manual_entry_details))
{
$count++;

$itemcode=$ff_kot_manual_entry_details['itemcode'];
$itemname=$ff_kot_manual_entry_details['itemname'];
$itemquantity=$ff_kot_manual_entry_details['quantity'];
$rate=$ff_kot_manual_entry_details['rate'];
$amount=$ff_kot_manual_entry_details['totalrate'];
?>
<tr>
<td><?php echo $count; ?></td>
<td><?php  echo $itemcode; ?></td>
<td ><?php  echo $itemname; ?></td>
<td><?php echo $itemquantity;?></td>
<td align="right"><?php  echo $rate; ?></td>
<td align="right"><?php  echo $amount; ?></td>
</tr>

<?php
}
}
?>
<tr>
<td colspan="5">
  <div align="center">-------------------------------------------------------</div></td>
</tr>
<tr>
<td colspan="5">

</td>
</tr>
</div>
</div>
</div>
</div>
</tr>
</table>
<br>
<br>
</body>


<?php	
	$content = ob_get_clean();
   
    // convert to PDF
   
    try
    {	
		$width_in_inches = 4.39;
		$height_in_inches = 6.2;
		$width_in_mm = $width_in_inches * 25.4; 
		$height_in_mm = $height_in_inches * 25.4;
        $html2pdf = new HTML2PDF('P', array($width_in_mm,$height_in_mm), 'en', true, 'UTF-8', array(0, 0, 0,0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->setDefaultFont('Helvetica');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('print_consultationbill.pdf');
		
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
	
?>

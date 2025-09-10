<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$currentdate = date("Y-m-d");
$docno = $_SESSION['docno'];

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="AutomaticPI.xls"');
header('Cache-Control: max-age=80');

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if (isset($_REQUEST["frmflag45"])) { $frmflag45 = $_REQUEST["frmflag45"]; } else { $frmflag45 = ""; }
if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }
if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
//echo $location;
if ($frm1submit1 == 'frm1submit1')
{

}
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #FFFFFF;
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
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<body>
<table border="1" width="100%" style="border-collapse:collapse;">
      <tr>
        <td width="77"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>No.</strong></div></td>
		<td width="314"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>ItemName </strong></div></td>
				<td width="100"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Avl.Stock</strong></div></td>
		<td width="87"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>ROL</strong></div></td>
				<td width="81"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Min</strong></div></td>
				<td width="83"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Max</strong></div></td>
              <td width="67"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>ROQ</strong></div></td>
	    <td width="223"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Supplier</strong></div></td>
			
			 <td width="70" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Pack Size</strong></div></td>
			 <td width="78" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Status</strong></div></td>
				<td width="77" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              
  </tr>
			
            
			<?php
			$colorloopcount = '';
			$sno = '';
			$location = $_REQUEST['location'];
			$query11 = "select itemcode,itemname,rol,minimum,maximum from master_itemtosupplier where recordstatus <> 'Deleted' and locationcode = '$location' and storecode = '$store' and rol <> '0' group by itemcode order by itemname ";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num11 = mysqli_num_rows($exec11);
			while($res11=mysqli_fetch_array($exec11))
			{
			
			$itemcode = $res11['itemcode'];
			$itemname = $res11['itemname'];
			$rol = $res11['rol'];
			$min = $res11['minimum'];
			$max = $res11['maximum'];
			
			$query12 = "select packagename from master_medicine where itemcode = '$itemcode' and status <> 'deleted'";
			$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num12 = mysqli_num_rows($exec12);
			$res12=mysqli_fetch_array($exec12);
			if($num12==0)
			{
			//echo  '<br>'.$itemcode;
			}
			$packsize = $res12['packagename'];
			
			$query65 = "select suppliercode,suppliername from master_itemtosupplier where itemcode='$itemcode' and locationcode = '$location' and storecode = '$store'";
			$exec65 = mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res65 = mysqli_fetch_array($exec65);
			$suppliername1=$res65['suppliername'];
			$suppliercode1=$res65['suppliercode'];
			$locationcode = $location;
			
			$query8 = "select itemcode,billdate from purchaseorder_details where itemcode = '$itemcode' and locationcode = '$location' and storecode = '$store' and recordstatus<>'deleted' and goodsstatus=''";
			$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res8 = mysqli_fetch_array($exec8);
			$res8itemcode = $res8['itemcode'];
			$billdate = $res8['billdate'];
			
			if($res8itemcode!='')
			{
				$status='PO is Generated';
			}
			else
			{
				$status='';
			}
			$itemcode = $itemcode;
			//include ('autocompletestockcount1include5.php');
			$reorderquery1 = "select SUM(batch_quantity) as cum_quantity from transaction_stock where itemcode = '$itemcode' and batch_stockstatus='1' and locationcode = '$location' and storecode = '$store'";
			$reorderexec1 = mysqli_query($GLOBALS["___mysqli_ston"], $reorderquery1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$reordernum1 = mysqli_num_rows($reorderexec1);
			$reorderres1=mysqli_fetch_array($reorderexec1);
			$currentstock = $reorderres1['cum_quantity'];	
			if($currentstock=='')
			{
				$currentstock='0';
			}
			$currentstock = $currentstock;
			//echo $rol;
			$roq = $max - $currentstock;
			if($currentstock <= $rol)
			{
			if($roq >= 0)
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
			if($status!='')
			{
				$colorcode = 'bgcolor="#9966FF"';
			}
			?>
			  <tr>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $itemname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $currentstock; ?></div></td>
					<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $rol; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $min; ?></div></td>
				
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $max; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $roq; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $suppliername1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $packsize; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $status; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"></div></td>
            </tr>
			  <?php
			}
			}
			}
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
			  <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
           	 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
           <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
             		 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
           		 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
          </tbody>
        </table>
</body>
</html>


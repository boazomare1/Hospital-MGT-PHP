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
header('Content-Disposition: attachment;filename="LocationReorderLevel.xls"');
header('Cache-Control: max-age=80');

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if (isset($_REQUEST["frmflag45"])) { $frmflag45 = $_REQUEST["frmflag45"]; } else { $frmflag45 = ""; }
if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }
if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
if (isset($_REQUEST["categoryid"])) { $categoryid = $_REQUEST["categoryid"]; } else { $categoryid = ""; } 
 if (isset($_REQUEST["statustype"])) { $statustype = $_REQUEST["statustype"]; } else { $statustype = "all"; }
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
                <td width="100"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>ItemCode</strong></td>
                <td width="150"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Category</strong></td>
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
             
	    <td width="223"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Supplier</strong></div></td>
			
			 <td width="70" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Pack Size</strong></div></td>
			 <td width="78" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Status</strong></div></td>
				
              
  </tr>
			
            
			
			  
			<?php

			
			$colorloopcount = '';
			$sno = '';
			$location = $_REQUEST['location'];
			
			$incr = 0;
			$query11 = "select itemcode,itemname,rol,minimumstock,maximumstock,packagename,categoryname from master_medicine where status <> 'deleted' and categoryname like '%$categoryid%'   group by itemcode order by itemname";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$num11 = mysqli_num_rows($exec11);
			while($res11=mysqli_fetch_array($exec11))
			{
			
			$itemcode = $res11['itemcode'];
			$itemname = $res11['itemname'];
			$rol = $res11['rol'];
			$min = $res11['minimumstock'];
			$max = $res11['maximumstock'];
		

			$packsize = $res11['packagename'];
			$categoryname = $res11["categoryname"];
			
		

			$suppliername1 = "";
			$queryfav = "select a.suppliercode,b.accountname from master_itemmapsupplier as a left join master_accountname as b on a.suppliercode=b.id where itemcode='$itemcode' and fav_supplier = '1'";
			
			$execfav = mysqli_query($GLOBALS["___mysqli_ston"], $queryfav) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	
			$fav_res_rows =  mysqli_num_rows($execfav);
			
			if($fav_res_rows)
			{
				
				$resfav = mysqli_fetch_array($execfav);
				$suppliercode1=$resfav['suppliercode'];

				
				$suppliername1 = $resfav['accountname'];

				
			}
			
			
			$locationcode = $location;
			$status ="";
			
			$itemcode = $itemcode;
			
			$reorderquery1 = "select SUM(batch_quantity) as cum_quantity from transaction_stock where itemcode = '$itemcode' and batch_stockstatus='1' and locationcode = '$location'";
			
			$reorderexec1 = mysqli_query($GLOBALS["___mysqli_ston"], $reorderquery1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$reordernum1 = mysqli_num_rows($reorderexec1);
			$reorderres1=mysqli_fetch_array($reorderexec1);
			$currentstock = $reorderres1['cum_quantity'];	
			if($currentstock=='')
			{
				$currentstock='0';
			}
			$currentstock = $currentstock;
			
			$roq = $max - $currentstock;
			
			
			
			if($currentstock < $rol)
			{
				$incr = $incr + 1;
			
				$flag_arr[1][$incr] = $itemcode;
				$reorder[] = $itemcode;
				$reorderdata[$itemcode]['itemcode'] = $itemcode;
				$reorderdata[$itemcode]['categoryname'] = $categoryname;
				$reorderdata[$itemcode]['itemname'] = $itemname;
				$reorderdata[$itemcode]['currentstock'] = $currentstock;

				$reorderdata[$itemcode]['rol'] = $rol;

				$reorderdata[$itemcode]['min'] = $min;
				$reorderdata[$itemcode]['max'] = $max;

				$reorderdata[$itemcode]['suppliername'] = $suppliername1;
				$reorderdata[$itemcode]['packsize'] = $packsize;
				
			}
			elseif($currentstock > $max)
			{
				$incr = $incr + 1;
			
				$flag_arr[2][$incr] = $itemcode;
				$abovemax[] = $itemcode;

				$abovemaxdata[$itemcode]['itemcode'] = $itemcode;
				$abovemaxdata[$itemcode]['categoryname'] = $categoryname;
				$abovemaxdata[$itemcode]['itemname'] = $itemname;
				$abovemaxdata[$itemcode]['currentstock'] = $currentstock;

				$abovemaxdata[$itemcode]['rol'] = $rol;

				$abovemaxdata[$itemcode]['min'] = $min;
				$abovemaxdata[$itemcode]['max'] = $max;

				$abovemaxdata[$itemcode]['suppliername'] = $suppliername1;
				$abovemaxdata[$itemcode]['packsize'] = $packsize;
				
			}
			elseif($currentstock <= $max && $currentstock >= $min && $currentstock < $rol)
			{
				$incr = $incr + 1;
				
				$flag_arr[1][$incr] = $itemcode;
				$reorder[] = $itemcode;

				$reorderdata[$itemcode]['itemcode'] = $itemcode;
				$reorderdata[$itemcode]['categoryname'] = $categoryname;
				$reorderdata[$itemcode]['itemname'] = $itemname;
				$reorderdata[$itemcode]['currentstock'] = $currentstock;

				$reorderdata[$itemcode]['rol'] = $rol;

				$reorderdata[$itemcode]['min'] = $min;
				$reorderdata[$itemcode]['max'] = $max;

				$reorderdata[$itemcode]['suppliername'] = $suppliername1;
				$reorderdata[$itemcode]['packsize'] = $packsize;

			}
			elseif($currentstock <= $max && $currentstock >= $min && $currentstock >= $rol)
			{
				$incr = $incr + 1;
				$colorcode = 'bgcolor="#90EE90"';
			
				$flag_arr[3][$incr] = $itemcode;
				$ok[] = $itemcode;
				$okdata[$itemcode]['itemcode'] = $itemcode;
				$okdata[$itemcode]['categoryname'] = $categoryname;
				$okdata[$itemcode]['itemname'] = $itemname;
				$okdata[$itemcode]['currentstock'] = $currentstock;

				$okdata[$itemcode]['rol'] = $rol;

				$okdata[$itemcode]['min'] = $min;
				$okdata[$itemcode]['max'] = $max;

				$okdata[$itemcode]['suppliername'] = $suppliername1;
				$okdata[$itemcode]['packsize'] = $packsize;
				

			}
			
			$status_arr = $status;


			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
		
			


			
			
			}
			   if($statustype == "all" || $statustype=="reorder")
			   {
				foreach ($reorder as $key => $itmcode1) {
					# code...
				$itemcode = $itmcode1;

					$itemcode = $reorderdata[$itemcode]['itemcode'];
				$categoryname = $reorderdata[$itemcode]['categoryname'] ; 
				$itemname = $reorderdata[$itemcode]['itemname'] ;
				$currentstock = $reorderdata[$itemcode]['currentstock'] ;

				$rol = $reorderdata[$itemcode]['rol'] ;

				$min = $reorderdata[$itemcode]['min'] ;
				$max = $reorderdata[$itemcode]['max']  ;

				$suppliername1 = $reorderdata[$itemcode]['suppliername']  ;
				 $packsize = $reorderdata[$itemcode]['packsize'];




					$status = "Reorder";
					$colorcode = 'bgcolor="#ffffe0"';
			?>
			  <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno+1; ?></div>
			  </td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $itemcode ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $categoryname ?></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $itemname; ?></div></td>
				
				<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($currentstock,'2','.',','); ?></div></td>
					<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($rol,'2','.',','); ?></div></td>
			
			
				<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($min,'2','.',','); ?></div></td>
				
              <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31" align="right"><?php echo number_format($max,'2','.',','); ?></div></td>
			
			  
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $suppliername1; ?></div></td>
			
		   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $packsize; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $status; ?></div></td>
		
			   
            </tr>
			  <?php
				
			}

		 }
		  if($statustype == "all" || $statustype=="abovemax")
			   {
				foreach ($abovemax as $key => $itmcode2) {

					$itemcode = $itmcode2;
					# code...
				$itemcode = $abovemaxdata[$itemcode]['itemcode'];
				$categoryname = $abovemaxdata[$itemcode]['categoryname'] ; 
				$itemname = $abovemaxdata[$itemcode]['itemname']  ;
				$currentstock = $abovemaxdata[$itemcode]['currentstock'] ;

				$rol = $abovemaxdata[$itemcode]['rol'] ;

				$min = $abovemaxdata[$itemcode]['min'] ;
				$max = $abovemaxdata[$itemcode]['max']  ;

				$suppliername1 = $abovemaxdata[$itemcode]['suppliername']  ;
				 $packsize = $abovemaxdata[$itemcode]['packsize'];

					$colorcode = 'bgcolor="#FFCCCB"';
				    $status ='Above Max';

			?>
			   <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno+1; ?></div>
			  </td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $itemcode ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $categoryname ?></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $itemname; ?></div></td>
				
				<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($currentstock,'2','.',','); ?></div></td>
					<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($rol,'2','.',','); ?></div></td>
			
			
				<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($min,'2','.',','); ?></div></td>
				
              <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31" align="right"><?php echo number_format($max,'2','.',','); ?></div></td>
			
			  
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $suppliername1; ?></div></td>
			
		   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $packsize; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $status; ?></div></td>
		
			   
            </tr>
			  <?php
			  $main_item[] = $itemcode;
			
			}
		  }
		  if($statustype == "all" || $statustype=="ok")
			   {
				foreach ($ok as $key => $itmcode3) {
					# code...
					$itemcode = $itmcode3;
						$itemcode = $okdata[$itemcode]['itemcode'];
				$categoryname = $okdata[$itemcode]['categoryname'] ; 
				$itemname = $okdata[$itemcode]['itemname'] ;
				$currentstock = $okdata[$itemcode]['currentstock'] ;

				$rol = $okdata[$itemcode]['rol'] ;

				$min = $okdata[$itemcode]['min'] ;
				$max = $okdata[$itemcode]['max']  ;

				$suppliername1 = $okdata[$itemcode]['suppliername']  ;
				 $packsize = $okdata[$itemcode]['packsize'];
					$colorcode = 'bgcolor="#90EE90"';
				    $status ='Optimum';
			?>
			    <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno+1; ?></div>
			  </td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $itemcode ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $categoryname ?></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $itemname; ?></div></td>
				
				<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($currentstock,'2','.',','); ?></div></td>
					<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($rol,'2','.',','); ?></div></td>
			
			
				<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($min,'2','.',','); ?></div></td>
				
              <td class="bodytext31" valign="center"  align="right">
			  <div class="bodytext31" align="right"><?php echo number_format($max,'2','.',','); ?></div></td>
			
			  
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $suppliername1; ?></div></td>
			
		   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $packsize; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $status; ?></div></td>
		
			   
            </tr>
			  <?php
				
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


<?php
error_reporting(0);
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


<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
<script>
function Valid1()
{

if(document.getElementById("store").value == '')
{
alert("Please Select Store");
document.getElementById("store").focus();
return false;
}
}
</script>
</head>

<body>

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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
            <tr>
             <td colspan="11" bgcolor="#ecf0f5" class="bodytext31"><strong>Store Reorder Level</strong></td>
             </tr>
               
			  <form method="post" name="form2" id="form2" action="" onSubmit="return Valid1();">
			   <tr>
              <td colspan="2" class="bodytext31" valign="center"  align="left" bgcolor="#FFFFFF"><strong>Location</strong></td>
              <td colspan="9" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">
			  <?php if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; } 
			   if (isset($_REQUEST["statustype"])) { $statustype = $_REQUEST["statustype"]; } else { $statustype = "all"; }

			  ?>
			  <select name="location" id="location" style="border: 1px solid #001E6A;" onChange="storefunction(this.value)">
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
                  </select>
				   
			  </td>
			 </tr>
			 <tr>
              <td colspan="2" class="bodytext31" valign="center"  align="left" bgcolor="#FFFFFF"><strong>Status Type</strong></td>
              <td colspan="9" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">
			
			  <select name="statustype" id="statustype" style="border: 1px solid #001E6A;">
             	
					<option value="all"  <?php if($statustype=="all"){echo "selected";}?>>All</option>
					<option value="reorder"  <?php if($statustype=="reorder"){echo "selected";}?>>Reorder</option>
					<option value="abovemax"  <?php if($statustype=="abovemax"){echo "selected";}?>>Above Max</option>
					<option value="ok"  <?php if($statustype=="ok"){echo "selected";}?>>Optimum</option>
					
                  </select>
				   
			  </td>
			 </tr>
			 <?php  if (isset($_REQUEST["categoryid"])) { $categoryid = $_REQUEST["categoryid"]; } else { $categoryid = ""; }  ?>

		 <tr>

              <td colspan="2" align="left" bgcolor="#FFFFFF" class="bodytext3"><strong>Category</strong></td>

              <td   colspan="9" bgcolor="#FFFFFF" align="left" class="bodytext3">
              	<select name="categoryid" id="categoryid" style="border: 1px solid #001E6A;">

            <option value="" selected="selected">Select Category</option>

                  <?php

						 

						$query1 = "select * from master_categorypharmacy where status <> 'deleted' order by categoryname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1categoryname = $res1["categoryname"];
						$catid = $res1["auto_number"];
						?>
                          <option value="<?php echo $res1categoryname; ?>" <?php if($categoryid==$res1categoryname){echo 'selected';}?>><?php echo $res1categoryname; ?></option>
                          <?php
						}
						?>

                  </select></td>

                   

         

             

              </tr>
			  <tr>
              <td colspan="2" class="bodytext31" valign="center"  align="left" bgcolor="#FFFFFF"><strong>Store</strong></td>
              <td colspan="9" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">
			
			  <select name="store" id="store" >

		<?php 

            echo '<option value="">-Select-</option>';
			$query2 = "SELECT b.storecode,b.store,a.defaultstore from master_employeelocation as a join master_store as b on a.storecode=b.auto_number where a.username='$username' and a.locationcode='$reslocationanum'";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			while ($res2 = mysqli_fetch_array($exec2))
			{
				$storesname=$res2['store'];
				$scode=$res2['storecode'];
                $defaultstore=$res2['defaultstore'];	
	            
                   
				if($scode==$store)
					$selected='selected';				
				else
					$selected='';

				echo '<option value="'.$scode.'" '.$selected.' >' .$storesname.'</option>';

			}

				?>



			  
			</select>
				   
			  </td>
			 </tr>
			 <?php  $loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 				 $username=isset($_REQUEST['username'])?$_REQUEST['username']:'';
 				 $frmflag45=isset($_REQUEST['frmflag45'])?$_REQUEST['frmflag45']:'';
				 $store=isset($_REQUEST['store'])?$_REQUEST['store']:'';?>  
			 
		 
		  <tr> 
		  <td colspan="2" align="left" bgcolor="#FFFFFF">&nbsp;</td>
           <td colspan="9" bgcolor="#FFFFFF" align="left" class="bodytext3"><input type="hidden" name="frmflag45" id="frmflag45" value="frmflag45">
		   <input type="submit" value="Search" name="submit56">
		   </td>
            </tr>	
			</form>
			<tr>
              <td width="69"  align="left" valign="center" class="bodytext31">&nbsp;</td>
			</tr> 

			<?php
			if($frmflag45 == 'frmflag45')
			{ 

				?>
			<tr>
	   <td align="left" colspan="7"> <a target="_blank" href="print_storereorderlevelxl.php?location=<?= $location;?>&&statustype=<?=$statustype?>&store=<?=$store?>&categoryid=<?=$categoryid?>"> <img src="images/excel-xls-icon.png" width="30" height="30"></a> </td>
	  </tr>
			<form method="post" name="form1" action="locationreorderlevel.php">
				<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="1">
			
            <tbody>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center">
				<input type="hidden" name="locationcode" id="locationcode" value="<?php echo $location; ?>">
				<strong>No.</strong></div></td>
				<td width="25"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>ItemCode</strong></td>
                <td width="25"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Category</strong></td>
			    <td width="163"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>ItemName </strong></div></td>
				<td width="63"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Avl.Stock</strong></div></td>
				<td width="71"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>ROL</strong></div></td>
				<td width="77"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Min</strong></div></td>
				<td width="79"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Max</strong></div></td>
             
			    <td width="159"  align="left" valign="center" 
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

			 $query11 = "select a.itemcode,a.itemname,a.rol,a.minimumstock,a.maximumstock,a.packagename,a.categoryname from master_medicine as a JOIN transaction_stock as b ON a.itemcode = b.itemcode and b.storecode='$store' where a.status <> 'deleted' and a.categoryname like '%$categoryid%'  group by a.itemcode order by a.itemname";
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
			
			$reorderquery1 = "select SUM(batch_quantity) as cum_quantity from transaction_stock where itemcode = '$itemcode' and batch_stockstatus='1' and locationcode = '$location' and storecode='$store' ";
			
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
          
              </tbody>
          </tbody>
        </table></td>
      </tr>
	  
	  </form>
	  <?php } ?>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>

</body>
</html>


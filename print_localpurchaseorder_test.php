<?php
session_start();
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$username = $_SESSION["username"];
$docno=$_SESSION["docno"];
$netamount=0.00;
$baname='';
$faname='';
$ceoname='';
ob_start();
	$query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname ";
	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res1 = mysqli_fetch_array($exec1);
 	$locationname = $res1["locationname"];
	$locationcode = $res1["locationcode"];
	
if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }
$suppliercode1=isset($_REQUEST['suppliercode'])?$_REQUEST['suppliercode']:'';

	$query2 = "select * from master_company where auto_number = '$companyanum'";
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res2 = mysqli_fetch_array($exec2);
	$companyname = $res2["companyname"];
	$address1 = $res2["address1"];
	$area = $res2["area"];
	$city = $res2["city"];
	$pincode = $res2["pincode"];
	$phonenumber1 = $res2["phonenumber1"];
	$phonenumber2 = $res2["phonenumber2"];
	$tinnumber1 = $res2["tinnumber"];
	$cstnumber1 = $res2["cstnumber"];

	
	$query55 = "select a.billdate,a.suppliername,a.suppliercode,a.remarks,a.povalidity,b.baremarks as bremarks,b.priority as priority,b.username as req_user,b.discount_by_percent,b.lpo_type from purchaseorder_details a JOIN purchase_indent b ON (a.purchaseindentdocno=b.docno) where a.billnumber='$billnumber' and a.suppliercode='$suppliercode1'";
	$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$num55=mysqli_num_rows($exec55);
	$res55=mysqli_fetch_array($exec55);
	$billdate = $res55['billdate'];
	$suppliername = $res55['suppliername'];
	$suppliercode = $res55['suppliercode'];
	$remarks = $res55['remarks'];
	$beremarks = $res55['bremarks'];
	$req_user = $res55['req_user'];
		$priority = $res55['priority'];
		$lpo_type = $res55['lpo_type'];
	/*$discount_by_percent = $res55['discount_by_percent'];
	echo '#'.$discount_by_percent.'#';*/
	$lpodate = $res55['povalidity'];
	if($req_user !='')
			{
			 $query6 = "select employeename from master_employee where username='$req_user' ";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);			
			$req_name = $res6['employeename'];
			
			}
	
	$query14 = "select accountname,address,contact,phone from master_accountname where id='$suppliercode'";
	$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res14 = mysqli_fetch_array($exec14);
	$res14accountname = $res14['accountname'];
	$res14address = $res14['address'];
	$res14contact = $res14['contact'];
	$res14phone = $res14['phone'];
	
	include("print_header_pdf2.php");


 $t1 = strtotime($lpodate);
$today_date = date("Y-m-d");
		  $t2 = strtotime($today_date);

		  $validity_days = ceil(abs($t1 - $t2) / 86400);


$locationcode = 'LTC-1';

$queryloc = "select * from master_location where locationcode = '$locationcode'";

$execloc = mysqli_query($GLOBALS["___mysqli_ston"], $queryloc) or die ("Error in Queryloc".mysqli_error($GLOBALS["___mysqli_ston"]));

$resloc = mysqli_fetch_array($execloc);

$locationname = $resloc['locationname'];

$address1 = $resloc['address1'];

$address2 = $resloc['address2'];

$phone = $resloc['phone'];

$email = $resloc['email'];

$website = $resloc['website'];



$queryloc = "select tinnumber from master_company";

$execloc = mysqli_query($GLOBALS["___mysqli_ston"], $queryloc) or die ("Error in Queryloc".mysqli_error($GLOBALS["___mysqli_ston"]));

$resloc = mysqli_fetch_array($execloc);

$tinnumber = $resloc['tinnumber'];

?>
<style>
.logo{font-weight:bold; font-size:18px; text-align:center;}
.bodyhead{font-weight:bold; font-size:14px; text-align:center; text-decoration:underline;}
.bodytextbold{font-weight:bold; font-size:12px; }
.bodytext32{font-weight:none; font-size:13px;}
.bodytext{font-weight:normal; font-size:11px; }
.bodytextbig{font-size: 14px;}
.border{border:1px #000000;}
td{{height: 50px;padding: 5px;}
table{table-layout:fixed;
width:100%;
display:table;
border-collapse:collapse;}
</style>

<style>

.bodytexthead {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000; font-family: Times;}

.bodytexttin {FONT-WEIGHT: bold; FONT-SIZE: 10px; COLOR: #000000; font-family: Times;}

.bodytextaddress {FONT-WEIGHT: none; FONT-SIZE: 11px; COLOR: #000000; font-family: Times;}
tr.heading{
    border-bottom: 1px solid black;
}
.bld{font-weight: bold; font-size:13px;}
/*.body{font-family:Times;}*/

.bodytext,.bodytext32,.main,.cls_005{font-family:Times !important;font-size:12.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
.main{width: 600px;}
.div1{float: left;width: 300px;}
.div2{float:right;width: 300px;}
.clear{clear: both;}
/*div.cls_005{font-family:Arial,serif;font-size:9.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}*/
</style>

<?php 
	/*$qry_dis = "select discount_by_percent,discountpercentage from purchaseorder_details where billnumber='$billnumber' and suppliercode='$suppliercode1' and recordstatus='generated' and itemstatus != 'deleted'";
			$exec_dis = mysql_query($qry_dis) or die(mysql_error());
			$res_dis = mysql_fetch_array($exec_dis);
			$discount_by_percent = $res_dis['discount_by_percent'];
			//$discount_percentage = $res_dis['discountpercentage'];*/

?>
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
	 <tr>
    	<td colspan="5" class="bodytext32">____________________________________________________________________________________________________________________</td>
         
    </tr>
</table>

	<!--  <tr>
    	<td colspan="5" class="bodytext32">___________________________________________________________________________________________________________________</td>
         
    </tr> -->

    
    	<div class="main" width="600px">
    		<div class="div1" width="300px;">
    			To:<br>
    			<?php echo strtoupper($suppliername);?><br>
    			<?php echo $res14address;?><br>

Contact Name: <?= strtoupper($res14contact) ?><br>
Phone No: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $res14phone;?>
    		</div>
    		<div style="position:absolute;left:415.00px;top:148.00px" class="cls_005"><span class="cls_005">LPO No:</span></div>
<div style="position:absolute;left:485.00px;top:148.00px" class="cls_005"><span class="cls_005"><?php echo $billnumber; ?></span></div>
<!-- <div style="position:absolute;left:41.00px;top:162.00px" class="cls_005"><span class="cls_005">LPO Date</span></div> -->
<div style="position:absolute;left:415.00px;top:167.00px" class="cls_005"><span class="cls_005">LPO Date :</span></div>
<div style="position:absolute;left:485.00px;top:167.00px;width:150px" class="cls_005"><span class="cls_005"><?php echo date("d/M/Y", strtotime($billdate)); ?>&nbsp;&nbsp;<?php //echo date('g.m A',strtotime($billdate)); ?></span></div>
<div style="position:absolute;left:415.00px;top:185.00px" class="cls_005"><span class="cls_005">LPO Validity:</span></div>
<div style="position:absolute;left:485.00px;top:185.00px" class="cls_005"><span class="cls_005"><?php echo date("d/M/Y", strtotime($lpodate)); echo '  ('.$validity_days.') days'; ?></span></div>
<div style="position:absolute;left:415.00px;top:202.00px" class="cls_005"><span class="cls_005">LPO Type:</span></div>
<div style="position:absolute;left:487.00px;top:202.00px" class="cls_005"><span class="cls_005"><?php echo $lpo_type; ?></span></div>
    		<div class="div2" width="300px"  >
    			
<!-- <div style="position:absolute;left:415.00px;top:178.00px" class=""><span class="">Department:</span></div>
<div style="position:absolute;left:500.00px;top:178.00px" class=""><span class="">GENERAL</span></div>
<div style="position:absolute;left:415.00px;top:194.00px" class=""><span class="">Generated By:</span></div>
<div style="position:absolute;left:500.00px;top:194.00px" class=""><span class="">Roda Dahir</span></div>
 -->


    			<!-- <table border="0" width="500px" align="center" cellpadding="0" cellspacing="0">
    				
    				<tr>
    	
		<td class="bodytext">LPO No:</td>
		<td class="bodytext"><?php echo $billnumber; ?></td>
		 
		  
    </tr> 
      <tr>
      	
		<td class="bodytext">LPO Date :</td>
		
		 <td class="bodytext"><?php echo date("d/M/Y", strtotime($billdate)); ?>&nbsp;&nbsp;<?php echo date('g.m A',strtotime($billdate));?></td>
		
    </tr> 
     <tr>
    	
		<td class="bodytext">LPO Validity:</td>
		<td class="bodytext"><?php echo date("d/M/Y", strtotime($lpodate)); echo '  ('.$validity_days.') days'; ?> </td>
    </tr> 
    			</table> -->

    			<!-- <p>LPO No: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $billnumber; ?></p>
    			<p>LPO Date : &nbsp;&nbsp;&nbsp;&nbsp;<?php echo date("d/M/Y", strtotime($billdate)); ?>&nbsp;&nbsp;<?php echo date('g.m A',strtotime($billdate));?></p>
    			
    			<p>LPO Validity: <?php echo date("d/M/Y", strtotime($lpodate)); echo '  ('.$validity_days.') days'; ?></p> -->
    			
    		</div>
    		<div class="clear" style="clear:both;"></div>

    	</div>
    	
   
    <!-- <tr>
    	<td class="bodytext32">To:</td>
         <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="bodytext">Contact Name:</td>
        <td class="bodytext"><?= strtoupper($res14contact) ?></td>
    </tr>
    <tr>
    	<td class="bodytext32"><?php echo strtoupper($suppliername);?></td>
		 <td>&nbsp;</td>
       <td>&nbsp;</td>
		<td class="bodytext">Phone No:</td>
		
		 
		 <td class="bodytext"><?php  echo $res14phone;?></td>
    </tr>
     <tr>
    	 <td class="bodytext"><?php  echo $res14address;?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
		<td class="bodytext">LPO No:</td>
		<td class="bodytext"><?php echo $billnumber; ?></td>
		 
		  
    </tr> 
      <tr>
      	<td>&nbsp;</td>
    	 
        <td>&nbsp;</td>
        <td>&nbsp;</td>
		<td class="bodytext">LPO Date :</td>
		
		 <td class="bodytext"><?php echo date("d/M/Y", strtotime($billdate)); ?>&nbsp;&nbsp;<?php echo date('g.m A',strtotime($billdate));?></td>
		
    </tr> 
     <tr>
    	 <td class="bodytext32"></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
		<td class="bodytext">LPO Validity:</td>
		<td class="bodytext"><?php echo date("d/M/Y", strtotime($lpodate)); echo '  ('.$validity_days.') days'; ?> </td>
    </tr> -->
 <!--  <tr>
    	<td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
    </tr> -->


<div style="border:1px solid black;">
<table width="100%" align="center" border="0" cellpadding="5" cellspacing="" height='90%'>
<thead style="border-bottom:1px solid black;">

  <tr>
	  <!--<td width="20" align="center" class="bodytextbold" >MEDs CODE</td>-->
	 <!--  <td width="20" align="center" class="bodytextbold" >ITEM CODE</td> -->
	 <td width="3%" align="left" class="bodytext" >S.No.</td>
      <td width="35%" align="left" class="bodytext" >Item Name</td>
    <!-- <td width="5%" align="left" class="bodytext" >UoM.</td> -->
    <td width="5%" align="center" class="bodytext" >Qty</td>
    <!--<td width="20" align="center" class="bodytextbold" >PACK SIZE</td>-->
    <td width="8%" align="center" class="bodytext ">Free Qty</td>
    <!-- <?php if($discount_by_percent){ ?>
    <td id="discount_per_heading" width="35" align="center" class="bodytextbold ">DISCOUNT %</td>
<?php } ?> -->
    <td width="10%" align="center" class="bodytext ">Rate</td>
	<td width="7%" align="left" class="bodytext ">Disc</td>
	<td width="7%" align="left" class="bodytext ">Tax</td>
	 
	   <td width="10%" align="right" class="bodytext" >U.C.P </td>
	   <td width="15%" align="center" class="bodytext" >Total</td>
	    <!-- <td width="28" align="center" class="bodytextbold " >REMARKS</td> -->
  </tr>
  </thead>
	  <?php
			$sno = 1;
			$total_tax_amount = 0;
			$total_without_tax = 0;
			$final_totalamount = 0;
			$rowcount='';
		$query34="select * from purchaseorder_details where billnumber='$billnumber' and suppliercode='$suppliercode1' and recordstatus='generated' and itemstatus != 'deleted' ";
		$exec34=mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$num34 = mysqli_num_rows($exec34);
		while($res34=mysqli_fetch_array($exec34))
			{
				$ucp_amt = 0;
			$totalquantity =0;
			$sumtotalquantity = 0;
			$amount = 0;
			$quantity=0;
			$itemname=$res34['itemname'];
			$itemcode=$res34['itemcode'];
			$res34username=$res34['username'];
			$currency=$res34['currency'];
			$discount = $res34['discountamount'];
			$freeqty = $res34['free'];
			$baserate = $res34['baserate'];
			$itemprice = $res34['rate'];
			$discount_by_percent = $res34['discount_by_percent'];
			$discount_percentage = $res34['discountpercentage'];
			$tax_amount = $res34['itemtaxamount'];
			$tax_percentage = $res34['itemtaxpercentage'];
			
			//$amount_wt_tax = 

			//$disc_per = $discount_percentage + 0;

			
			//$purchaseindentdocno=$res34['purchaseindentdocno'];
			
			/*$query35="select packagequantity,totalamount,rate, quantity,purchaseindentdocno from purchaseorder_details where billnumber='$billnumber' and suppliercode='$suppliercode1' and recordstatus='generated' and itemstatus != 'deleted' and itemname='$itemname'";
			$exec35=mysql_query($query35) or die(mysql_error());
			while($res35=mysql_fetch_array($exec35))
			{
			$packagequantity=$res35['packagequantity'];
			$purchaseindentdocno=$res35['purchaseindentdocno'];
			$amt = $res35['totalamount'];
			$itemrate = $res35['rate'];
			$quantity += $res35['quantity'];
			$rowcount=$rowcount+$quantity;
			$pakagequantity=$res35['packagequantity'];
			$subtotal = $itemrate * $quantity;
			$amount = $amount + $amt;
			$totalquantity=$totalquantity+$packagequantity;
			$sumtotalquantity = $sumtotalquantity + $quantity;
			}*/
			
			$packagequantity=$res34['packagequantity'];
			$purchaseindentdocno=$res34['purchaseindentdocno'];
			$amt = $res34['totalamount'];
			$itemrate = $res34['rate'];
			$quantity += $res34['quantity'];
			$rowcount=$rowcount+$quantity;
			$pakagequantity=$res34['packagequantity'];
			$subtotal = $itemrate * $quantity;
			$amount = $amount + $amt;
			$totalquantity=$totalquantity+$packagequantity;
			$sumtotalquantity = $sumtotalquantity + $quantity;

			if($quantity > 0)
			{
	    
			$query77 = "select rateperunit,packagename from master_medicine where itemcode='$itemcode'";
			$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res77 = mysqli_fetch_array($exec77);
			$rate = $res77['rateperunit'];
			$meds_code='';
			$pakagesize=$res77['packagename'];
			$netamount = $netamount + $amount;
			
			$ratebyunit=$amount/$quantity;
			
			$query777 = "select bausername,fausername,ceousername,username,s_terms from purchase_indent where docno='$purchaseindentdocno'";
			$exec777 = mysqli_query($GLOBALS["___mysqli_ston"], $query777) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res777 = mysqli_fetch_array($exec777);
			
			$bausername = $res777['bausername'];
			$fausername = $res777['fausername'];
			$ceousername = $res777['ceousername'];
			$s_terms = $res777['s_terms'];
			
			if($bausername !='')
			{
			 $query6 = "select employeename from master_employee where username='$bausername' ";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);			
			$baname = $res6['employeename'];
			
			}
			if($fausername !='')
			{
			$query7 = "select employeename from master_employee where username='$fausername' ";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res7 = mysqli_fetch_array($exec7);			
			$faname = $res7['employeename']; 
			
			}
			if($ceousername !='')
			{
			$query3 = "select employeename from master_employee where username='$ceousername' ";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);			
			$ceoname = $res3['employeename'];
			}

			$single_item_taxamt = $tax_amount / $quantity;
			$ucp_amt = $itemprice + $single_item_taxamt;


			$total_tax_amount = $total_tax_amount + $tax_amount;
			$without_tax = $itemprice * $quantity;
			$total_without_tax = $total_without_tax + $without_tax;
			$totalamount = $ucp_amt * $quantity;

			$final_totalamount = $final_totalamount + $totalamount;
			
			//$rowcount = $freeqty + $rowcount;// free qty + ordered qty
			
			?>
    <tr>
        <!--<td  width="20" class="bodytext" valign="center"  align="left" ><?php echo $meds_code; ?></td>-->
        <!-- <td  width="20" class="bodytext" valign="center"  align="left" ><?php echo $itemcode; ?></td> -->
         <td width=""  class="bodytext" valign="center"  align="left" ><?php echo $sno; ?></td>
        <td width=""  class="bodytext" valign="center"  align="left" ><?php echo implode('<br/>',str_split($itemname,30)); ?></td>
       <!--  <td width=""  class="bodytext" valign="center"  align="left" >&nbsp;</td> -->
        <td class="bodytext" valign="center"  align="center" ><?php echo number_format($quantity); ?></td>
         <td class="bodytext" valign="center"  align="center" ><?php echo $freeqty; ?></td>
        <!--<td class="bodytext" valign="center"  align="right" ><?php echo $pakagesize; ?></td>-->
        <td class="bodytext" valign="center"  align="center"><?php echo number_format($itemprice,2,'.',','); ?></td>
        <?php if($discount_by_percent){
        	$discount_percentage = preg_replace('~\.0+$~','',$discount_percentage);
         ?>
        <td class="bodytext" valign="center"  align="left" cval="<?php echo $discount_by_percent; ?>"><?php echo $discount_percentage.' %'; ?></td>
    	<?php } else { ?>
    	<td class="bodytext" valign="center"  align="left"><?php echo number_format($discount,2,'.',','); ?></td>
    	<?php } ?>
         
        
         <td class="bodytext" valign="center"  align="left" ><?php echo $tax_percentage; ?></td>
        <td class="bodytext" valign="center"  align="right" ><?php echo number_format($ucp_amt,2,'.',','); ?></td>
       
        <td class="bodytext" valign="center"  align="right" ><?php echo number_format($totalamount,2,'.',','); ?></td>
        <!-- <td class="bodytext" valign="center"  align="right">&nbsp;</td> -->				
    </tr>
			<?php
			$sno = $sno + 1;
			}
			}
			?> 
			<tr><td colspan="10">&nbsp;</td></tr>
			<tr><td colspan="10">&nbsp;</td></tr>
			<tr><td colspan="10">&nbsp;</td></tr>
			<tr><td colspan="10">&nbsp;</td></tr>
			
</table>
</div>

            <table width="100%" align="center" border="0" cellpadding="5" cellspacing="">
			<!--<tr>
			<td class="bodytextbold" valign="center" width="60"  align="left" >Total No of Items :</td>
			<td class="bodytext" valign="center" width="58"  align="left" ><?php echo number_format($rowcount,2,'.',','); ?></td>
			<td class="bodytextbold" valign="center" width="57"   align="left"><strong>Net Amount:</strong></td>
			  <td  width="30" class="bodytext" valign="center"   align="left"><?php echo number_format($netamount,2,'.',','); ?></td>
			  <td width="30" class="bodytext" valign="center"  align="right">&nbsp;</td>
			</tr> -->
			<?php
				include('convert_currency_to_words.php');
				
			$convertedwords = covert_currency_to_words($final_totalamount); 
			?>
			 <tr>
			
			<td  colspan="3" align="left" class="bodytext"><?php echo strtoupper($currency).': '.strtoupper($convertedwords); ?></td>
			<td class="bodytext" valign="center"  align="right">&nbsp;</td>
			<td class="bodytext" valign="center"  align="right" colspan="1">&nbsp;</td>
			<!-- <td class="bodytext" valign="center"  align="right" colspan="1">&nbsp;</td> -->
			<!-- <td class="bodytext" valign="center"  align="right">&nbsp;</td> -->
			</tr>  
			<tr>
			
			<td  align="left" class="bodytext"><!-- <?php echo strtoupper($currency).': '.strtoupper($convertedwords); ?> --></td>
			<td  class="bodytextbold" valign="center"  align="right" >&nbsp;</td>
			<td class="bodytext" valign="center"  align="right" colspan="2">Goods Amount:</td>
			<td  class="bodytext" valign="center"  align="right" ><?php echo number_format($total_without_tax,2,'.',','); ?></td>
			
			</tr> 
			<tr>
			<td  class="bodytextbold" valign="center"  align="right" >&nbsp;</td>
			<td  class="bodytextbold" valign="center"  align="right" >&nbsp;</td>
			<td class="bodytext" valign="center"  align="right" colspan="2">VAT Amount:</td>
			<td  class="bodytext" valign="center"  align="right" ><?php echo number_format($total_tax_amount,2,'.',','); ?></td>
			</tr> 

			<tr>
			<td  class="bodytextbold" valign="center"  align="right" >&nbsp;</td>
			<td  class="bodytextbold" valign="center"  align="right" >&nbsp;</td>
			<td class="bodytext32" valign="center"  align="right" colspan="2">Total Amount:<strong></strong></td>
			<td  class="bodytextbold" valign="center"  align="right" ><?php echo number_format($final_totalamount,2,'.',','); ?></td>
			
			</tr> 
			<tr> 
				<td colspan="5" class="bodytext32" style='fond-size:14px'><?=$s_terms;?></td>
			</tr>
			
			


			<tr>
				<td colspan="5" align="left" class="bodytext32">&nbsp;</td>
			</tr>

			



			<!-- <tr>
			<td colspan="2" align="left" class="bodytext32">-----------------------------------------------</td>
             <td colspan="1" align="left" class="bodytext32">&nbsp;</td>
			<td colspan="2" align="right" class="bodytext32">-----------------------------------------------</td>
           
			</tr> -->
			<tr>
			<td colspan="5" align="left" class="bodytext32">&nbsp;</td>
			</tr>
			<tr>
			<td colspan="5" align="left" class="bodytext32">&nbsp;</td>
			</tr>

			<tr>
			<td colspan="5" align="left" class="bodytext32">&nbsp;</td>
			</tr>

			<!-- <tr>
			<td align="left" colspan="2" class="bodytext32"><?php echo $bausername; ?> </td>
			<td align="left" class="bodytext32"><?php echo $fausername; ?></strong> </td>
			<td colspan="2" align="right" class="bodytext32"><?php echo $ceousername; ?> </td>
              
			</tr>
            <tr>
			<td colspan="2" align="left" class="bodytext32">(Prepared by Procurement)</td>
            <td colspan="1" align="left" class="bodytext32">(Approved by )</td>
			<td colspan="1" align="left" class="bodytext32">&nbsp;</td>
			<td colspan="1" align="right" class="bodytext32">(Authorized by )</td>
            
			</tr> -->

			<tr>
			<td colspan="2" align="left" class="bodytext32"><?php echo strtoupper('procurement officer'); ?></td>
            <td colspan="1" align="left" class="bodytext32"><?php echo strtoupper('finance manager'); ?></td>
			<td colspan="1" align="left" class="bodytext32">&nbsp;</td>
			<td colspan="1" align="right" class="bodytext32"><?php echo strtoupper('c.e.o.');?></td>
            
			</tr>
			<tr>
			<td align="left" colspan="2" class="bodytext32"><strong>Date:</strong> <?php echo $billdate ?></td>
			<td align="left" class="bodytext32"><strong>Date:</strong> <?php echo $billdate ?></td>
			<td colspan="2" align="right" class="bodytext32"><strong>Date:</strong> <?php echo $billdate ?></td>
              
			</tr>
			
           <!-- <tr>
			<td colspan="5" align="left" class="bodytext32">&nbsp;</td>
			</tr>
			<tr>
			<td colspan="5" align="center" class="bodytext32">&nbsp;</td>
			</tr>
             <tr>
			<td colspan="5" align="center" class="bodytext32">&nbsp;</td>
            </tr>
           
            <tr>
			<td colspan="" align="left" class="bodytext32">&nbsp;</td>
            
			<td colspan="2" align="center" class="bodytext32">&nbsp;</td>
            <td colspan="" align="left" class="bodytext32">&nbsp;</td>
            <td colspan="" align="left" class="bodytext32">&nbsp;</td>
			</tr>
			<tr>
			<td colspan="5" align="left" class="bodytext32">&nbsp;</td>
			</tr>-->
			<!--<tr>
			<td colspan="5" align="center" class="bodytext32">This Purchase order is not valid unless signed by three signatories</td>
			</tr>-->
			
			
			
    </table>
<!-----------------------------------unwanted---------------------------------->

<?php	
require_once("dompdf/dompdf_config.inc.php");
$html =ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("A4", 'P');
$dompdf->render();
$canvas = $dompdf->get_canvas();
//$canvas->line(10,800,800,800,array(0,0,0),1);
$font = Font_Metrics::get_font("Arial", "normal");
$canvas->page_text(272, 800, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 12, array(0,0,0));
$dompdf->stream("LPO.pdf", array("Attachment" => 0)); 
?>

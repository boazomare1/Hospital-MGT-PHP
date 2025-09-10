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

$currency='';

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



	

	$query55 = "select a.entrydate,a.suppliername,a.suppliercode,a.locationcode,b.baremarks as bremarks,b.priority as priority, b.username as username,b.povalidity from manual_lpo a JOIN purchase_indent b ON (a.purchaseindentdocno=b.docno) where a.billnumber='$billnumber' and a.suppliercode='$suppliercode1'";

	$exec55=mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	$num55=mysqli_num_rows($exec55);

	$res55=mysqli_fetch_array($exec55);

	$billdate = $res55['entrydate'];

	$suppliername = $res55['suppliername'];

	$suppliercode = $res55['suppliercode'];

	$beremarks = $res55['bremarks'];
$act_locationcode = $res55['locationcode'];
	$priority = $res55['priority'];

	if(is_null($res55['povalidity']))
	{
		$lpodate = date('Y-m-d', strtotime("+30 days"));;
	}
	else
	{
		$lpodate = $res55['povalidity'];
	}
	//$lpodate = $res55['povalidity'];

	$req_username1 = $res55['username'];

	$t1 = strtotime($lpodate);
	$today_date = date("Y-m-d");
	$t2 = strtotime($today_date);

	$validity_days = ceil(abs($t1 - $t2) / 86400);

	$query88 = mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username  = '$req_username1' and username <> ''") or die ("Error in Query88".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res88 = mysqli_fetch_array($query88);

	$req_username = $res88['employeename'];



	$remarks ='';

	

	$query14 = "select accountname,address,contact,phone from master_accountname where id='$suppliercode'";

	$exec14 = mysqli_query($GLOBALS["___mysqli_ston"], $query14) or die ("Error in Query14".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res14 = mysqli_fetch_array($exec14);

	$res14accountname = $res14['accountname'];

	$res14address = $res14['address'];

	$res14contact = $res14['contact'];
	$res14phone = $res14['phone'];

	//include("print_headerpo.php");
	include("print_header_pdf2.php");


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

			<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
	 <tr>
    	<td colspan="5" class="bodytext32">____________________________________________________________________________________________________________________</td>
         
    </tr>
</table>
	
    	
    	<div class="main" width="600px">
    	    <table>
    	        <tr>
    	            <td>
    		<div class="div1" width="300px;">
    			To:<br>
    			<?php echo strtoupper($suppliername);?><br>
    			<?php echo $res14address;?><br>
Contact Name: <?= strtoupper($res14contact) ?><br>
Phone No: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $res14phone;?>
    		</div>
    		</td>
    		<td>
    		    <div class="div1" width="500px;">
    		LPO No: <?php echo $billnumber; ?><br/>
    		LPO Date : <?php echo date("d/M/Y", strtotime($billdate)); ?>&nbsp;&nbsp;<?php echo date('g.m A',strtotime($billdate));?><br/>
    	LPO Validity : <?php echo date("d/M/Y", strtotime($lpodate)); echo '  ('.$validity_days.') days'; ?>
</div>
</td>
</tr>
</table>
    	</div>
    	


			<div style="border:1px solid black;">
<table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" >


  <tr>
	 <td width="3%" align="left" class="bodytext" >S.No.</td>
      <td width="35%" align="left" class="bodytext" >Item Name</td>
    <td width="5%" align="center" class="bodytext" >Qty</td>
    <td width="10%" align="center" class="bodytext ">Rate</td>
	<td width="7%" align="left" class="bodytext ">Tax</td>
	 
	   <td width="10%" align="right" class="bodytext" >U.C.P </td>
	   <td width="15%" align="center" class="bodytext" >Total</td>
  </tr>



	  <?php

			$sno = 1;
			$total_tax_amount = 0;
			$total_without_tax = 0;
			$final_totalamount = 0;

			$rowcount='0.00';			

		$query34="select itemname,username,purchaseindentdocno from manual_lpo where billnumber='$billnumber' and suppliercode='$suppliercode1' and recordstatus='generated' group by itemname";

		$exec34=mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		$num34 = mysqli_num_rows($exec34);

		while($res34=mysqli_fetch_array($exec34))

			{

			$totalquantity =0;

			$sumtotalquantity = 0;

			$amount = 0;

			$itemname=$res34['itemname'];

			$itemcode='';

			$res34username=$res34['username'];

			$purchaseindentdocno=$res34['purchaseindentdocno'];

	
			

		$query35="select totalamount,rate,quantity,itemtaxamount,itemtaxpercentage from manual_lpo where billnumber='$billnumber' and suppliercode='$suppliercode1' and recordstatus='generated' and itemname='$itemname'";

		$exec35=mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

		while($res35=mysqli_fetch_array($exec35))

		{

			$ucp_amt = 0;
		$packagequantity=1;

		$amt = $res35['totalamount'];

		$itemrate = $res35['rate'];

		$quantity = $res35['quantity'];

	 	$rowcount=$rowcount+$quantity;

		$subtotal = $itemrate * $quantity;



		$amount = $amount + $subtotal;

		$totalquantity=$totalquantity+$packagequantity;

		$sumtotalquantity = $sumtotalquantity + $quantity;

		$tax_amount = $res35['itemtaxamount'];
		$tax_percentage = $res35['itemtaxpercentage'];

		$baserate = $itemrate;
		$single_item_taxamt = $tax_amount / $quantity;
			$ucp_amt = $baserate + $single_item_taxamt;


			$total_tax_amount = $total_tax_amount + $tax_amount;
			$without_tax = $baserate * $quantity;
			$total_without_tax = $total_without_tax + $without_tax;
			$totalamount = $ucp_amt * $quantity;

			$final_totalamount = $final_totalamount + $totalamount;

	    }

		$netamount = $netamount + $amount;

		

		$query777 = "select bausername,fausername,ceousername,currency,s_terms from purchase_indent where docno='$purchaseindentdocno'";

			$exec777 = mysqli_query($GLOBALS["___mysqli_ston"], $query777) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res777 = mysqli_fetch_array($exec777);

			

			$bausername = $res777['bausername'];

			$fausername = $res777['fausername'];

			$ceousername = $res777['ceousername'];

			$currency = $res777['currency'];

			$s_terms = $res777['s_terms'];

			$baname = "";

			//$rateperunit=$amt/$quantity;

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

		

			?>

 

      <tr>
         <td width=""  class="bodytext" valign="center"  align="left" ><?php echo $sno; ?></td>
        <td width=""  class="bodytext" valign="center"  align="left" ><?php echo $itemname; ?></td>
        <td class="bodytext" valign="center"  align="center" ><?php echo number_format($quantity); ?></td>
        <td class="bodytext" valign="center"  align="center"><?php echo number_format($baserate,2,'.',','); ?></td>
        
        
         <td class="bodytext" valign="center"  align="left" ><?php echo $tax_percentage; ?></td>
        <td class="bodytext" valign="center"  align="right" ><?php echo number_format($ucp_amt,2,'.',','); ?></td>
       
        <td class="bodytext" valign="center"  align="right" ><?php echo number_format($totalamount,2,'.',','); ?></td>
    </tr>

			<?php
			$sno = $sno + 1;
			  }

			?> 
		
                 </table>
                 </div>

            <table width="100%" align="center" border="0" cellpadding="5" cellspacing="">
		
			<?php
				include('convert_currency_to_words.php');
				
			$convertedwords = covert_currency_to_words($final_totalamount); 
			?>
			 <tr>
			
			<td  colspan="3" align="left" class="bodytext"><?php echo strtoupper($currency).': '.strtoupper($convertedwords); ?></td>
			<td class="bodytext" valign="center"  align="right">&nbsp;</td>
			<td class="bodytext" valign="center"  align="right" colspan="1">&nbsp;</td>
		
			</tr>  
			<tr>
			
			<td  align="left" class="bodytext"></td>
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

		
			<tr>
			<td colspan="5" align="left" class="bodytext32">&nbsp;</td>
			</tr>
			<tr>
			<td colspan="5" align="left" class="bodytext32">&nbsp;</td>
			</tr>

			<tr>
			<td colspan="5" align="left" class="bodytext32">&nbsp;</td>
			</tr>
		

		
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

  
    </table>

<!-----------------------------------unwanted---------------------------------->





<?php	
//exit;
require_once("dompdf/dompdf_config.inc.php");

$html =ob_get_clean();

$dompdf = new DOMPDF();

$dompdf->load_html($html);

$dompdf->set_paper("A4");

$dompdf->render();

$canvas = $dompdf->get_canvas();

//$canvas->line(10,800,800,800,array(0,0,0),1);

$font = Font_Metrics::get_font("times-roman", "normal");

$canvas->page_text(272, 814, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));

$dompdf->stream("LPO.pdf", array("Attachment" => 0)); 

?>
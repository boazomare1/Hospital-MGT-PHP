<?php

session_start();
$pagename = '';





include ("db/db_connect.php");

$colorloopcount="0";

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$sessionusername = $_SESSION['username'];

$errmsg = '';

$bgcolorcode = '';

header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="poanalysisreport_xl.xls"');

header('Cache-Control: max-age=80');



$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$query1 = "select * from master_company where auto_number = '$companyanum'";

$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res1 = mysqli_fetch_array($exec1);

$res1companyname = $res1['companyname'];

$res1address1 = $res1['address1'];

$resfaxnumber1 = $res1['faxnumber1'];

$res1area = $res1['area'];

$res1city = $res1['city'];

$res1state = $res1['state'];

$res1emailid1= $res1['emailid1'];

$res1country = $res1['country'];

$res1pincode = $res1['pincode'];

$phonenumber1 = $res1['phonenumber1'];

$locationname = $res1['locationname'];

$locationcode = $res1['locationcode'];







if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }



if(isset($_REQUEST["searchsupplname"])){ $searchsuppliername = $_REQUEST["searchsupplname"];}else{$searchsuppliername = "";}

if(isset($_REQUEST["searchsupplcode"])){ $searchsuppliercode = $_REQUEST["searchsupplcode"];}else{$searchsuppliercode = "";}

//if(isset($_REQUEST["ponumber"])){ $searchponumber = $_REQUEST["ponumber"];}else{$searchponumber = "";}

if(isset($_REQUEST["type"])){ $type = $_REQUEST["type"];}else{$type = "";}



if(isset($_REQUEST["ADate1"])){ $ADate1 = $_REQUEST["ADate1"];}else{$ADate1 = date('Y-m-d');}

if(isset($_REQUEST["ADate2"])){ $ADate2 = $_REQUEST["ADate2"];}else{$ADate2 = date('Y-m-d');}

if(isset($_REQUEST["reporttype"])){ $reporttype = $_REQUEST["reporttype"];}else{$reporttype = "summary";}

$totalcopay = 0;

$totalgrt = 0;

$totalgrn = 0;

$totalnet = 0;

$grandgrn = 0;

$grandgrt = 0;

$grandnet = 0;

?>


<style type="text/css">

<!--



.bodytext3 {	FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}
.bodytext31 {	FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}




-->

</style>


<?php 

if($frmflag1 == "frmflag1")

{

?><?php  include("print_header1.php"); ?>


 <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="1" cellpadding="1" width="100%" align="left" border="0" >

          <tbody>

             <tr bgcolor="#011E6A">
             	<?php $reporttype = $_REQUEST["reporttype"];
             		if($reporttype=='supplierwise'){ ?>

                <td colspan="7" bgcolor="#ecf0f5" class="bodytext31"><strong>Purchase Order Details</strong></td>
                 <td colspan="6" bgcolor="#ecf0f5" class="bodytext31" align="right" valign="middle"><strong>From <?php echo $ADate1;?> To <?php echo $ADate2;?></strong></td>
             <?php }else{ ?>
             	<td colspan="5" bgcolor="#ecf0f5" class="bodytext31"><strong>Purchase Order Details</strong></td>
                 <td colspan="5" bgcolor="#ecf0f5" class="bodytext31" align="right" valign="middle"><strong>From <?php echo $ADate1;?> To <?php echo $ADate2;?></strong></td>
             <?php } ?>

			 </tr>
    

<?php
$sno_det = 0;

	$sno = 0;

	$lpototal = 0;

	$mlpototal=0;

	$grandtotal=0;

   /* $searchsuppliername = $_REQUEST["suppliername"];

	$searchsuppliercode = $_REQUEST["suppliercode"];*/

	//(isset($_REQUEST["ponumber"])){ $searchponumber = $_REQUEST["ponumber"];}else{$searchponumber = "";}

	//(isset($_REQUEST["hidpurchaseordercode"])){ $hidpurchaseno = $_REQUEST["hidpurchaseordercode"];}else{$hidpurchaseno = "";}

	

	$totamountval_det = 0;

	$ADate1 = $_REQUEST["ADate1"];

	$ADate2 = $_REQUEST["ADate2"];
	$reporttype = $_REQUEST["reporttype"];

	if(($type=='po' || $type=='all') && ($reporttype=='supplierwise'))
	{

	if($searchsuppliername == "")

	{

	//GET PURCHASE ORDER DETAILS -- all

	$qrypodetatils = "SELECT billdate,purchaseindentdocno,billnumber,suppliername,suppliercode,SUM(totalamount) AS totvalue,goodsstatus FROM purchaseorder_details WHERE suppliername LIKE '%$searchsuppliername%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND recordstatus<>'deleted' GROUP BY suppliername";

	}

	else

	{
		
		//GET PURCHASE ORDER DETAILS -- for search po

	$qrypodetatils = "SELECT billdate,purchaseindentdocno,billnumber,suppliername,suppliercode,SUM(totalamount) AS totvalue,goodsstatus FROM purchaseorder_details WHERE suppliercode = '$searchsuppliercode' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND recordstatus<>'deleted' GROUP BY suppliername";

	}

	?>

    <tr>

                <td width="" class="bodytext31" valign="middle"  align="center" bgcolor="#ffffff"><strong>No.</strong></td>

			    <td width="" colspan="5"  align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>Suplier Name</strong></td>
			   <!--  <td width=""  align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong></strong></td>
			    <td width=""  align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong></strong></td> -->

				<!-- <td width=""  align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong></strong></td> -->

				<!-- <td width=""  align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong></strong></td> -->
				<!-- <td width=""  align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong></strong></td> -->

                <td width=""  align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong></strong></td>

                <td width=""  align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong></strong></td>

                <td width=""  align="right" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>PO Value</strong></td>

                <td width=""  align="right" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>GRN Amt</strong></td>

                <td width=""  align="right" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>GRT Amt</strong></td>

                <td width=""  align="right" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>Net Amt</strong></td>

				<td width=""  align="center" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong></strong></td>

				
				

	         </tr>   

    

    <?php

	

	$execpodetatils = mysqli_query($GLOBALS["___mysqli_ston"], $qrypodetatils) or die ("Error in qrypodetatils".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($respodetatils = mysqli_fetch_array($execpodetatils))

	{

		$billdate = $respodetatils["billdate"];

		$pinumber = $respodetatils["purchaseindentdocno"];

		$ponumber = $respodetatils["billnumber"];

		//echo $ponumber.'<br>';

		$suppliername = $respodetatils["suppliername"];
		$suppliercodee = $respodetatils["suppliercode"];

		$totalamount = $respodetatils["totvalue"];

		 $lpototal = $lpototal + $totalamount;



		 // check status

		 $pocnt_qry = "SELECT COUNT(auto_number) pocnt FROM `purchaseorder_details` WHERE `billnumber` = '$ponumber' ";

		 $execpocnt = mysqli_query($GLOBALS["___mysqli_ston"], $pocnt_qry) or die ("Error in PO Count Query".mysqli_error($GLOBALS["___mysqli_ston"]));

		 $pocntres = mysqli_fetch_array($execpocnt);

		$pocnt = $pocntres['pocnt'];



 		$poreccnt_qry = "SELECT COUNT(auto_number) poreccnt FROM `purchaseorder_details` WHERE `billnumber` = '$ponumber' and goodsstatus='received'";

		 $execrecpocnt = mysqli_query($GLOBALS["___mysqli_ston"], $poreccnt_qry) or die ("Error in PO REC Count Query".mysqli_error($GLOBALS["___mysqli_ston"]));

		 $porecntres = mysqli_fetch_array($execrecpocnt);

		$poreccnt = $porecntres['poreccnt'];

		if($pocnt == $poreccnt)

		{

			// po fully received

			$grnstatus="PO Fully Received";

			$status_colorcode = 'COLOR: green; font-weight:bold';

		}

		else

		{

			// po partially received

			$grnstatus="PO Partially Received";

			$status_colorcode = 'COLOR: red; font-weight:bold';

		}

		

		/* $goodsstatus = $respodetatils["goodsstatus"];

		 if($goodsstatus == 'received')

		 	$postatus = 1;

		 else

		 	$postatus = 0;*/

		 

		 $mrnbuild = array();

		 $grnamount = 0;

		 $grtamount = 0;

		 $query89 = "select billnumber, sum(totalfxamount) as totalfxamount from materialreceiptnote_details where ponumber = '$ponumber' group by billnumber";

		 $exec89 = mysqli_query($GLOBALS["___mysqli_ston"], $query89) or die ("Error in Query89".mysqli_error($GLOBALS["___mysqli_ston"]));

		 while($res89 = mysqli_fetch_array($exec89))

		 {

			 $mrnno = $res89['billnumber'];

			 $mrnbuild[] = $mrnno;

			 $grn = $res89['totalfxamount'];

			 $grnamount = $grnamount + $grn;

			 $totalgrn = $totalgrn + $grn;

		 }

		 

		/*if($grnamount==$totalamount){

			$grnstatus="PO Fully Received";

			$status_colorcode = 'COLOR: green; font-weight:bold';

		}

		else

		{

			if($grnamount!=0){

				$grnstatus="PO Partially Received";

				$status_colorcode = 'COLOR: red; font-weight:bold';

	

			}

			else{

				$grnstatus="PO Not Received";

				$status_colorcode = 'COLOR:#FFFF00; font-weight:bold';

			}

		}*/

		 if($grnamount==0){

		 	$grnstatus="PO Not Received";

			$status_colorcode = 'COLOR:blue; font-weight:bold';

		 }

		 $mrnbuildvalue = implode("','",$mrnbuild);

		 

		 $query91 = "select billnumber, sum(totalamount) as totalamount from purchasereturn_details where grnbillnumber IN ('".$mrnbuildvalue."') group by billnumber";

		 $exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die ("Error in Query91".mysqli_error($GLOBALS["___mysqli_ston"]));

		 while($res91 = mysqli_fetch_array($exec91))

		 {

			 $grtno = $res91['billnumber'];

			 $grt = $res91['totalamount'];

			 $grtamount = $grtamount + $grt;

			 $totalgrt = $totalgrt + $grt;

		 }

		

		$netamount = $grnamount - $grtamount;

		$totalnet = $totalnet + $netamount;

		

		$colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

			$colorcode = 'bgcolor="#ecf0f5"';
			/*if ($showcolor == 0)

			{

				//echo "if";

				$colorcode = 'bgcolor="#CBDBFA"';

			}

			else

			{

				//echo "else";

				$colorcode = 'bgcolor="#ecf0f5"';

			}*/

	?>

    <tr <?php echo $colorcode;?>>

    	<td class="bodytext31" valign="middle"  align="center"><?php echo $sno = $sno + 1;?></td>
    	<td class="bodytext31" colspan="5" width="15%" valign="middle"  align="left"><?php echo $suppliername;?></td>
    	<!-- <td></td>
    	<td></td> -->

        <!-- <td class="bodytext31" valign="middle"  align="left"><?php //echo $billdate;?></td> -->

        <!-- <td class="bodytext31" valign="middle"  align="left"><?php //echo $pinumber;?></td> -->

        <td class="bodytext31" valign="middle"  align="left"><?php //echo $ponumber;?></td>

        

        <td class="bodytext31" width="15%" valign="middle"  align="left" style="<?php echo $status_colorcode;?>"><?php //echo $grnstatus;?></td>

        <td class="bodytext31" valign="middle"  align="right"><?php echo  number_format($totalamount, 2, '.', ',');?></td>

        <td class="bodytext31" valign="middle"  align="right"><?php if($grnamount!=0){ ?><p><?php echo  number_format($grnamount, 2, '.', ',');?></p><?php }  else { ?> <?php echo  number_format($grnamount, 2, '.', ',');?><?php } ?></td>

        <td class="bodytext31" valign="middle"  align="right"><?php if($grtamount!=0){ ?><p><?php echo  number_format($grtamount, 2, '.', ',');?></p><?php } else { ?><?php echo  number_format($grtamount, 2, '.', ',');?> <?php } ?></td>

        <td class="bodytext31" valign="middle"  align="right"><?php echo  number_format($netamount, 2, '.', ',');?></td>

        <td class="bodytext31" valign="middle"  align="center">

        	<!-- <a href="poanalysisdetatiled.php?viewflag=viewflag&&ponum=<?php echo $ponumber;?>&&ADate1=<?php echo $ADate1;?>&&ADate2=<?php echo $ADate2;?>&&suppnm=<?php echo $searchsuppliername;?>" target="_blank" id="viewpo" name="viewpo">view</a> --></td>
        	<!--  <td class="bodytext31" valign="middle"  align="left"></td>
        	  <td class="bodytext31" valign="middle"  align="left"></td>
        	   <td class="bodytext31" valign="middle"  align="left"></td> -->

    </tr>


     <?php

     	if($reporttype == "supplierwise"){

     		$detailed_cnt = 1;
       // Items list for po
    	$qrypodetailed = "SELECT billdate,itemcode,billnumber,purchaseindentdocno,suppliercode, itemname,rate,packagequantity,username,fxtotamount,free FROM purchaseorder_details WHERE suppliercode = '$suppliercodee' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND recordstatus<>'deleted'";
    	
	$execpodetailed = mysqli_query($GLOBALS["___mysqli_ston"], $qrypodetailed) or die ("Error in qrypodetailed".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($respodetailed = mysqli_fetch_array($execpodetailed))

	{

		$billdate_det = $respodetailed["billdate"];
		$po_number = $respodetailed["billnumber"];
		//echo '##'.$po_number.'##<br>';
		$pi_number = $respodetailed["purchaseindentdocno"];
		$suppliercode = $respodetailed["suppliercode"];
		

		$itemcode_det = $respodetailed["itemcode"];

		$itemname_det = $respodetailed["itemname"];

		$rate_det = $respodetailed["rate"];

		$pkgqnty_det = $respodetailed["packagequantity"];

		$username_det = $respodetailed["username"];

		$fxamount_det = $respodetailed["fxtotamount"];

		$totamountval_det = $totamountval_det + $fxamount_det;



		$po_freeqty_det = $respodetailed["free"];



		$mrnqry = "SELECT sum(`itemtotalquantity`) totalrecqty FROM `materialreceiptnote_details` WHERE ponumber='$po_number' AND itemcode='$itemcode_det' and suppliercode='$suppliercodee'";
		

		$execmrn = mysqli_query($GLOBALS["___mysqli_ston"], $mrnqry) or die ("Error in Total Rec Quantity Query".mysqli_error($GLOBALS["___mysqli_ston"]));

		$resmrn = mysqli_fetch_array($execmrn);

		((mysqli_free_result($execmrn) || (is_object($execmrn) && (get_class($execmrn) == "mysqli_result"))) ? true : false);

	

		$recqty_det = $resmrn['totalrecqty'];

		$recqty = preg_replace('~\.0+$~','',$recqty_det);



		$balqty_det = $pkgqnty_det - $recqty_det;



		$qry = "SELECT sum(free) free FROM `materialreceiptnote_details` WHERE ponumber='$ponumber' AND itemcode='$itemcode_det' and free !='' and suppliercode='$suppliercodee'";

		//echo $qry.'<br>';

		$exec = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res = mysqli_fetch_assoc($exec);

		

		$recfreeqty_det = $res['free'];

		//echo '#'.$recfreeqty.'#<br>';

		((mysqli_free_result($exec) || (is_object($exec) && (get_class($exec) == "mysqli_result"))) ? true : false);


		?>
		<?php if($detailed_cnt == 1){ ?>
		 <tr bgcolor="#ffffff">

                <!-- <td width="" class="bodytext31" valign="middle"  align="center">S.No</td> -->
                <td>&nbsp;</td>
			    <td width=""  align="left" valign="middle"  class="bodytext31">Date</td>
			    <td width=""  align="left" valign="middle"  class="bodytext31">PI </td>
			    <td width=""  align="left" valign="middle"  class="bodytext31">PO </td>


				<td width=""  align="left" valign="middle" class="bodytext31">Item Code</td>

                <td width=""  align="left" valign="middle" class="bodytext31">Item Name</td>

				<td width=""  align="right" valign="right" class="bodytext31">Rate</td>

                <td width=""  align="right" valign="right" class="bodytext31">Ord.Qty</td>

                <td width=""  align="right" valign="right" class="bodytext31">Free.Qty</td>

                <td width=""  align="right" valign="right" class="bodytext31">Recd.Qty</td>

                 <td width=""  align="right" valign="right" class="bodytext31">Recd.Free.Qty</td>

                 <td width=""  align="right" valign="right" class="bodytext31">Bal.Qty</td>

               <!--  <td width=""  align="left" valign="right" class="bodytext31"><strong>Username</strong></td> -->

                <td width=""  align="right" valign="right" class="bodytext31">Amount</td>

		     </tr> 
		      <?php 

		 
		} 

		 $detailed_cnt = $detailed_cnt + 1;
		 ?>
			<tr bgcolor="#ffffff">

    	
		<!-- <td class="bodytext31" valign="middle"  align="center"><?php echo $sno_det = $sno_det + 1;?></td> -->
		<td>&nbsp;</td>
        <td class="bodytext31" valign="middle"  align="left"><?php echo $billdate_det;?></td>
        <td class="bodytext31" valign="middle"  align="left"><?php echo $pi_number;?></td>
        <td class="bodytext31" valign="middle"  align="left"><?php echo $po_number;?></td>

        <td class="bodytext31" valign="middle"  align="left"><?php echo $itemcode_det;?></td>

        <td class="bodytext31" valign="middle"  align="left"><?php echo $itemname_det;?></td>

        <td class="bodytext31" valign="middle"  align="right"><?php echo $rate_det;?></td>

        <td class="bodytext31" valign="middle"  align="right"><?php echo $pkgqnty_det;?></td>

        <td class="bodytext31" valign="middle"  align="right"><?php echo $po_freeqty_det;?></td>

        <td class="bodytext31" valign="middle"  align="right"><?php echo $recqty_det;?></td>

         <td class="bodytext31" valign="middle"  align="right"><?php echo $recfreeqty_det;?></td>

        <td class="bodytext31" valign="middle"  align="right"><?php echo $balqty_det;?></td>

        <!-- <td class="bodytext31" valign="middle"  align="left"><?php echo $username_det;?></td> -->

        <td class="bodytext31" valign="middle"  align="right"><?php echo  number_format($fxamount_det, 2, '.', ',');?></td>

    </tr>


	<?php }

     }

	}//while--close

	?>

	<tr>

    	<td colspan="7"  bgcolor="#999999">&nbsp;</td>

        <td class="bodytext31" valign="middle"  align="right"  bgcolor="#999999"><strong>Total</strong></td>

        <td class="bodytext31" valign="middle"  align="right"  bgcolor="#999999"><strong><?php echo number_format($lpototal, 2, '.', ',');?></strong></td>

        <td class="bodytext31" valign="middle"  align="right"  bgcolor="#999999"><strong><?php echo number_format($totalgrn, 2, '.', ',');?></strong></td>

        <td class="bodytext31" valign="middle"  align="right"  bgcolor="#999999"><strong><?php echo number_format($totalgrt, 2, '.', ',');?></strong></td>

        <td class="bodytext31" valign="middle"  align="right"  bgcolor="#999999"><strong><?php echo number_format($totalnet, 2, '.', ',');?></strong></td>

        <td  bgcolor="#999999">&nbsp;</td>

        

    </tr>

    <?php
}
	elseif($type=='po' || $type=='all'){

		if($searchsuppliername == "")

	{

	//GET PURCHASE ORDER DETAILS -- all

	$qrypodetatils = "SELECT billdate,purchaseindentdocno,billnumber,suppliername,suppliercode,SUM(totalamount) AS totvalue,goodsstatus FROM purchaseorder_details WHERE suppliername LIKE '%$searchsuppliername%' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND recordstatus<>'deleted' GROUP BY billnumber";

	}

	else

	{

		//GET PURCHASE ORDER DETAILS -- for search po

	$qrypodetatils = "SELECT billdate,purchaseindentdocno,billnumber,suppliername,suppliercode,SUM(totalamount) AS totvalue,goodsstatus FROM purchaseorder_details WHERE suppliercode = '$searchsuppliercode' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND recordstatus<>'deleted' GROUP BY billnumber";

	}

	?>

    <tr>

                <td width="" class="bodytext31" valign="middle"  align="center" bgcolor="#ffffff"><strong>No.</strong></td>

			    <td width=""  align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>

				<td width=""  align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>PI Number</strong></td>

				<td width=""  align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>PO Number</strong></td>

                <td width=""  align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>Suplier Name</strong></td>

                <td width=""  align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>PO Status</strong></td>

                <td width=""  align="right" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>PO Value</strong></td>

                <td width=""  align="right" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>GRN Amt</strong></td>

                <td width=""  align="right" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>GRT Amt</strong></td>

                <td width=""  align="right" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>Net Amt</strong></td>

				<!-- <td width=""  align="center" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>View</strong></td> -->

				<td>&nbsp;</td>
				

	         </tr>   

    

    <?php

	$execpodetatils = mysqli_query($GLOBALS["___mysqli_ston"], $qrypodetatils) or die ("Error in qrypodetatils".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($respodetatils = mysqli_fetch_array($execpodetatils))

	{

		$billdate = $respodetatils["billdate"];

		$pinumber = $respodetatils["purchaseindentdocno"];

		$ponumber = $respodetatils["billnumber"];

		//echo $ponumber.'<br>';

		$suppliername = $respodetatils["suppliername"];
		$suppliercode = $respodetatils["suppliercode"];

		$totalamount = $respodetatils["totvalue"];

		 $lpototal = $lpototal + $totalamount;



		 // check status

		 $pocnt_qry = "SELECT COUNT(auto_number) pocnt FROM `purchaseorder_details` WHERE `billnumber` = '$ponumber' ";

		 $execpocnt = mysqli_query($GLOBALS["___mysqli_ston"], $pocnt_qry) or die ("Error in PO Count Query".mysqli_error($GLOBALS["___mysqli_ston"]));

		 $pocntres = mysqli_fetch_array($execpocnt);

		$pocnt = $pocntres['pocnt'];



 		$poreccnt_qry = "SELECT COUNT(auto_number) poreccnt FROM `purchaseorder_details` WHERE `billnumber` = '$ponumber' and goodsstatus='received'";

		 $execrecpocnt = mysqli_query($GLOBALS["___mysqli_ston"], $poreccnt_qry) or die ("Error in PO REC Count Query".mysqli_error($GLOBALS["___mysqli_ston"]));

		 $porecntres = mysqli_fetch_array($execrecpocnt);

		$poreccnt = $porecntres['poreccnt'];

		if($pocnt == $poreccnt)

		{

			// po fully received

			$grnstatus="PO Fully Received";

			$status_colorcode = 'COLOR: green; font-weight:bold';

		}

		else

		{

			// po partially received

			$grnstatus="PO Partially Received";

			$status_colorcode = 'COLOR: red; font-weight:bold';

		}

		

		/* $goodsstatus = $respodetatils["goodsstatus"];

		 if($goodsstatus == 'received')

		 	$postatus = 1;

		 else

		 	$postatus = 0;*/

		 

		 $mrnbuild = array();

		 $grnamount = 0;

		 $grtamount = 0;

		 $query89 = "select billnumber, sum(totalfxamount) as totalfxamount from materialreceiptnote_details where ponumber = '$ponumber' group by billnumber";

		 $exec89 = mysqli_query($GLOBALS["___mysqli_ston"], $query89) or die ("Error in Query89".mysqli_error($GLOBALS["___mysqli_ston"]));

		 while($res89 = mysqli_fetch_array($exec89))

		 {

			 $mrnno = $res89['billnumber'];

			 $mrnbuild[] = $mrnno;

			 $grn = $res89['totalfxamount'];

			 $grnamount = $grnamount + $grn;

			 $totalgrn = $totalgrn + $grn;

		 }

		 

		/*if($grnamount==$totalamount){

			$grnstatus="PO Fully Received";

			$status_colorcode = 'COLOR: green; font-weight:bold';

		}

		else

		{

			if($grnamount!=0){

				$grnstatus="PO Partially Received";

				$status_colorcode = 'COLOR: red; font-weight:bold';

	

			}

			else{

				$grnstatus="PO Not Received";

				$status_colorcode = 'COLOR:#FFFF00; font-weight:bold';

			}

		}*/

		 if($grnamount==0){

		 	$grnstatus="PO Not Received";

			$status_colorcode = 'COLOR:blue; font-weight:bold';

		 }

		 $mrnbuildvalue = implode("','",$mrnbuild);

		 

		 $query91 = "select billnumber, sum(totalamount) as totalamount from purchasereturn_details where grnbillnumber IN ('".$mrnbuildvalue."') group by billnumber";

		 $exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die ("Error in Query91".mysqli_error($GLOBALS["___mysqli_ston"]));

		 while($res91 = mysqli_fetch_array($exec91))

		 {

			 $grtno = $res91['billnumber'];

			 $grt = $res91['totalamount'];

			 $grtamount = $grtamount + $grt;

			 $totalgrt = $totalgrt + $grt;

		 }

		

		$netamount = $grnamount - $grtamount;

		$totalnet = $totalnet + $netamount;

		

		$colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

			$colorcode = 'bgcolor="#ecf0f5"';
			/*if ($showcolor == 0)

			{

				//echo "if";

				$colorcode = 'bgcolor="#CBDBFA"';

			}

			else

			{

				//echo "else";

				$colorcode = 'bgcolor="#ecf0f5"';

			}*/

	?>

    <tr <?php echo $colorcode;?>>

    	<td class="bodytext31"  valign="middle"  align="center"><?php echo $sno = $sno + 1;?></td>

        <td class="bodytext31" valign="middle"  align="left"><?php echo $billdate;?></td>

        <td class="bodytext31" valign="middle"  align="left"><?php echo $pinumber;?></td>

        <td class="bodytext31" valign="middle"  align="left"><?php echo $ponumber;?></td>

        <td class="bodytext31"  valign="middle"  align="left"><?php echo $suppliername;?></td>

        <td class="bodytext31"  valign="middle"  align="left" ><?php echo $grnstatus;?></td>

        <td class="bodytext31" valign="middle"  align="right"><?php echo  number_format($totalamount, 2, '.', ',');?></td>

        <td class="bodytext31" valign="middle"  align="right"><?php if($grnamount!=0){ ?><p><?php echo  number_format($grnamount, 2, '.', ',');?></p><?php }  else { ?> <?php echo  number_format($grnamount, 2, '.', ',');?><?php } ?></td>

        <td class="bodytext31" valign="middle"  align="right"><?php if($grtamount!=0){ ?><p ><?php echo  number_format($grtamount, 2, '.', ',');?></p><?php } else { ?><?php echo  number_format($grtamount, 2, '.', ',');?> <?php } ?></td>

        <td class="bodytext31" valign="middle"  align="right"><?php echo  number_format($netamount, 2, '.', ',');?></td>

      	<td></td>
        	<!--  <td class="bodytext31" valign="middle"  align="left"></td>
        	  <td class="bodytext31" valign="middle"  align="left"></td>
        	   <td class="bodytext31" valign="middle"  align="left"></td> -->

    </tr>


     <?php

     	if($reporttype == "detailed"){

     		$detailed_cnt = 1;
       // Items list for po
    	$qrypodetailed = "SELECT billdate,itemcode,itemname,rate,packagequantity,username,fxtotamount,free FROM purchaseorder_details WHERE billnumber = '$ponumber' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND recordstatus<>'deleted'";

	$execpodetailed = mysqli_query($GLOBALS["___mysqli_ston"], $qrypodetailed) or die ("Error in qrypodetailed".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($respodetailed = mysqli_fetch_array($execpodetailed))

	{

		$billdate_det = $respodetailed["billdate"];
		

		$itemcode_det = $respodetailed["itemcode"];

		$itemname_det = $respodetailed["itemname"];

		$rate_det = $respodetailed["rate"];

		$pkgqnty_det = $respodetailed["packagequantity"];

		$username_det = $respodetailed["username"];

		$fxamount_det = $respodetailed["fxtotamount"];

		$totamountval_det = $totamountval_det + $fxamount_det;



		$po_freeqty_det = $respodetailed["free"];



		$mrnqry = "SELECT sum(`itemtotalquantity`) totalrecqty FROM `materialreceiptnote_details` WHERE ponumber='$ponumber' AND itemcode='$itemcode_det'";

		$execmrn = mysqli_query($GLOBALS["___mysqli_ston"], $mrnqry) or die ("Error in Total Rec Quantity Query".mysqli_error($GLOBALS["___mysqli_ston"]));

		$resmrn = mysqli_fetch_array($execmrn);

		((mysqli_free_result($execmrn) || (is_object($execmrn) && (get_class($execmrn) == "mysqli_result"))) ? true : false);

	

		$recqty_det = $resmrn['totalrecqty'];

		$recqty = preg_replace('~\.0+$~','',$recqty_det);



		$balqty_det = $pkgqnty_det - $recqty_det;



		$qry = "SELECT sum(free) free FROM `materialreceiptnote_details` WHERE ponumber='$ponumber' AND itemcode='$itemcode_det' and free !='' ";

		//echo $qry.'<br>';

		$exec = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res = mysqli_fetch_assoc($exec);

		

		$recfreeqty_det = $res['free'];

		//echo '#'.$recfreeqty.'#<br>';

		((mysqli_free_result($exec) || (is_object($exec) && (get_class($exec) == "mysqli_result"))) ? true : false);

		?>
		<?php if($detailed_cnt == 1){ ?>
		 <tr bgcolor="#ffffff">

                <!-- <td width="" class="bodytext31" valign="middle"  align="center">S.No</td> -->
                <td>&nbsp; </td>
               
			    <td width=""  align="left" valign="middle"  class="bodytext31">Date</td>

				<td width=""  align="left" valign="middle" class="bodytext31">Item Code</td>

                <td width=""  align="left" valign="middle" class="bodytext31">Item Name</td>

				<td width=""  align="right" valign="right" class="bodytext31">Rate</td>

                <td width=""  align="right" valign="right" class="bodytext31">Ord.Qty</td>

                <td width=""  align="right" valign="right" class="bodytext31">Free.Qty</td>

                <td width=""  align="right" valign="right" class="bodytext31">Recd.Qty</td>

                 <td width=""  align="right" valign="right" class="bodytext31">Recd.Free.Qty</td>

                 <td width=""  align="right" valign="right" class="bodytext31">Bal.Qty</td>

              

                <td width=""  align="right" valign="right" class="bodytext31">Amount</td>

		     </tr> 
		 <?php 

		 
		} 

		 $detailed_cnt = $detailed_cnt + 1;
		 ?>
			<tr bgcolor="#ffffff">

    	
		<td>&nbsp;</td>
		
        <td class="bodytext31" valign="middle"  align="left"><?php echo $billdate_det;?></td>

        <td class="bodytext31" valign="middle"  align="left"><?php echo $itemcode_det;?></td>

        <td class="bodytext31" valign="middle"  align="left"><?php echo $itemname_det;?></td>

        <td class="bodytext31" valign="right"  align="right"><?php echo $rate_det;?></td>

        <td class="bodytext31" valign="right"  align="right"><?php echo $pkgqnty_det;?></td>

        <td class="bodytext31" valign="right"  align="right"><?php echo $po_freeqty_det;?></td>

        <td class="bodytext31" valign="right"  align="right"><?php echo $recqty_det;?></td>

         <td class="bodytext31" valign="right"  align="right"><?php echo $recfreeqty_det;?></td>

        <td class="bodytext31" valign="right"  align="right"><?php echo $balqty_det;?></td>

     

        <td class="bodytext31" valign="right"  align="right"><?php echo  number_format($fxamount_det, 2, '.', ',');?></td>

    </tr>


	<?php }

     }

	}//while--close

	?>

	<tr>

    	<td colspan="5"  bgcolor="#999999">&nbsp;</td>

        <td class="bodytext31" valign="middle"  align="right"  bgcolor="#999999"><strong>Total</strong></td>

        <td class="bodytext31" valign="middle"  align="right"  bgcolor="#999999"><strong><?php echo number_format($lpototal, 2, '.', ',');?></strong></td>

        <td class="bodytext31" valign="middle"  align="right"  bgcolor="#999999"><strong><?php echo number_format($totalgrn, 2, '.', ',');?></strong></td>

        <td class="bodytext31" valign="middle"  align="right"  bgcolor="#999999"><strong><?php echo number_format($totalgrt, 2, '.', ',');?></strong></td>

        <td class="bodytext31" valign="middle"  align="right"  bgcolor="#999999"><strong><?php echo number_format($totalnet, 2, '.', ',');?></strong></td>

        <td  bgcolor="#999999">&nbsp;</td>

        

    </tr>

    <?php

	}

	

	$grandgrn = $grandgrn + $totalgrn;

	$grandgrt = $grandgrt + $totalgrt;

	$grandnet = $grandnet + $totalnet;

	?>

    

    <?php

	//MLPO

	$totalgrn = '0';

	$totalgrt = '0';

	$totalnet = '0';

	if(($type=='mlpo' || $type=='all') && ($reporttype=='supplierwise'))

	{
		// if(){

		// }

	if($searchsuppliername == "")

	{

	//GET PURCHASE ORDER DETAILS -- all

	 $qrympodetatils = "SELECT entrydate,purchaseindentdocno,billnumber,suppliername,SUM(totalamount) AS totvalue FROM manual_lpo WHERE suppliername LIKE '%$searchsuppliername%' AND entrydate BETWEEN '$ADate1' AND '$ADate2' AND recordstatus<>'deleted' GROUP BY suppliername";

	

	}

	else

	{

		//GET PURCHASE ORDER DETAILS -- for search po

	$qrympodetatils = "SELECT entrydate,purchaseindentdocno,billnumber,suppliername,SUM(totalamount) AS totvalue FROM manual_lpo WHERE suppliercode = '$searchsuppliercode' AND entrydate BETWEEN '$ADate1' AND '$ADate2' AND recordstatus<>'deleted' GROUP BY suppliername";

	}

	?>

    <tr>

                <td width="" class="bodytext31" valign="middle"  align="center" bgcolor="#ffffff"><strong>No.</strong></td> 
                 <td width="" colspan="5"  align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>Suplier Name</strong></td>

			    <!-- <td width=""  align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>

				<td width=""  align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>PI Number</strong></td>

				<td width=""  align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>MLPO Number</strong></td> -->
				<!-- <td width="" class="bodytext31" valign="middle"  align="center" bgcolor="#ffffff"></td> -->
				<!-- <td width="" class="bodytext31" valign="middle"  align="center" bgcolor="#ffffff"></td> -->
				<!-- <td width=""  align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong></strong></td> -->

				<!-- <td width=""  align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong></strong></td> -->

				<td width=""  align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong></strong></td>

                

                 <td width=""  align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong></strong></td>

                <td width=""  align="right" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>PO Value</strong></td>

                <td width=""  align="right" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>GRN Amt</strong></td>

                <td width=""  align="right" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>GRT Amt</strong></td>

                <td width=""  align="right" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>Net Amt</strong></td>

				<td width=""  align="center" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong></strong></td>
				<!-- <td width=""  align="center" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong></strong></td>
				<td width=""  align="center" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong></strong></td>
				<td width=""  align="center" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong></strong></td> -->

	         </tr> 

    <?php

	$execmpodetatils = mysqli_query($GLOBALS["___mysqli_ston"], $qrympodetatils) or die ("Error in qrympodetatils".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($resmpodetatils = mysqli_fetch_array($execmpodetatils))

	{

		$billdate1 = $resmpodetatils["entrydate"];

		$pinumber1 = $resmpodetatils["purchaseindentdocno"];

		$ponumber1 = $resmpodetatils["billnumber"];
		
		$suppliername1 = $resmpodetatils["suppliername"];

		$totalamount1 = $resmpodetatils["totvalue"];
		$totalfxamount = $resmpodetatils["totvalue"];

		$mlpototal = $mlpototal + $totalamount1;

		

		$mrnbuild = array();

		 $grnamount = 0;

		 $grtamount = 0;

		 $query89 = "select billnumber, sum(totalfxamount) as totalfxamount from materialreceiptnote_details where ponumber = '$ponumber1' group by billnumber";

		 $exec89 = mysqli_query($GLOBALS["___mysqli_ston"], $query89) or die ("Error in Query89".mysqli_error($GLOBALS["___mysqli_ston"]));

		 while($res89 = mysqli_fetch_array($exec89))

		 {

			 $mrnno = $res89['billnumber'];

			 $mrnbuild[] = $mrnno;

			 $grn = $res89['totalfxamount'];

			 $grnamount = $grnamount + $grn;
			 // $grnamount = $totalfxamount + $grn;

			 $totalgrn = $totalgrn + $grn;

		 }


		 if($totalfxamount==$totalamount1){

			$grnstatus="PO Fully Received";

			$status_colorcode = 'COLOR: green; font-weight:bold';

		}

		else

		{

			if($grnamount!=0){

				$grnstatus="PO Partially Received";

				$status_colorcode = 'COLOR: red; font-weight:bold';

	

			}

			else{

				$grnstatus="PO Not Received";

				$status_colorcode = 'COLOR:blue; font-weight:bold';

			}

		}

		 

		 $mrnbuildvalue = implode("','",$mrnbuild);

		 

		 $query91 = "select billnumber, sum(totalamount) as totalamount from purchasereturn_details where grnbillnumber IN ('".$mrnbuildvalue."') group by billnumber";

		 $exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die ("Error in Query91".mysqli_error($GLOBALS["___mysqli_ston"]));

		 while($res91 = mysqli_fetch_array($exec91))

		 {

			 $grtno = $res91['billnumber'];

			 $grt = $res91['totalamount'];

			 $grtamount = $grtamount + $grt;

			 $totalgrt = $totalgrt + $grt;

		 }

		

		$netamount = $totalfxamount - $grtamount;
		// $netamount = $grnamount - $grtamount;

		$totalnet = $totalnet + $netamount;
		

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

    <tr <?php echo $colorcode;?>>

    	<td class="bodytext31" valign="middle"  align="center"><?php echo $sno = $sno + 1;?></td>
    	<td class="bodytext31" colspan="5" valign="middle"  align="left"><?php echo $suppliername1;?></td>

        <!-- <td class="bodytext31" valign="middle"  align="left"><?php //echo $billdate1;?></td>
        <td class="bodytext31" valign="middle"  align="left"><?php //echo $billdate1;?></td>
        <td class="bodytext31" valign="middle"  align="left"><?php //echo $billdate1;?></td>

        <td class="bodytext31" valign="middle"  align="left"><?php //echo $pinumber1;?></td> -->

        <td class="bodytext31" valign="middle"  align="left"><?php //echo $ponumber1;?></td>


        <td class="bodytext31" valign="middle"  align="left" style="<?php echo $status_colorcode;?>"><?php //echo $grnstatus;?></td>

        <td class="bodytext31" valign="middle"  align="right"><?php echo  number_format($totalamount1, 2, '.', ',');?></td>

        <td class="bodytext31" valign="middle"  align="right"><?php if($totalfxamount!=0){ ?><p><?php echo  number_format($totalfxamount, 2, '.', ',');?></p><?php }  else { ?> <?php echo  number_format($totalfxamount, 2, '.', ',');?><?php } ?></td>

        <td class="bodytext31" valign="middle"  align="right"><?php if($grtamount!=0){ ?><p><?php echo  number_format($grtamount, 2, '.', ',');?></p><?php } else { ?><?php echo  number_format($grtamount, 2, '.', ',');?> <?php } ?></td>

        <td class="bodytext31" valign="middle"  align="right"><?php echo  number_format($netamount, 2, '.', ',');?></td>

        <td class="bodytext31" valign="middle"  align="center">

        	<!-- <a href="poanalysisdetatiled.php?viewflag=viewflag&&ponum=<?php echo $ponumber1;?>&&ADate1=<?php echo $ADate1;?>&&ADate2=<?php echo $ADate2;?>&&suppnm=<?php echo $searchsuppliername;?>" target="_blank" id="viewpo" name="viewpo">view</a> -->
        </td>

    </tr>
   
    

	<?php }

	?>

     <tr>

    	<td colspan="7"  bgcolor="#999999">&nbsp;</td>

        <td class="bodytext31" valign="middle"  align="right"  bgcolor="#999999"><strong>Total</strong></td>

        <td class="bodytext31" valign="middle"  align="right"  bgcolor="#999999"><strong><?php echo number_format($mlpototal, 2, '.', ',');?></strong></td>

        <td class="bodytext31" valign="middle"  align="right"  bgcolor="#999999"><strong><?php $totalgrn=$mlpototal; echo number_format($totalgrn, 2, '.', ',');?></strong></td>
        <!-- <td class="bodytext31" valign="middle"  align="right"  bgcolor="#999999"><strong><?php echo number_format($totalgrn, 2, '.', ',');?></strong></td> -->

        <td class="bodytext31" valign="middle"  align="right"  bgcolor="#999999"><strong><?php echo number_format($totalgrt, 2, '.', ',');?></strong></td>

        <td class="bodytext31" valign="middle"  align="right"  bgcolor="#999999"><strong><?php echo number_format($totalnet, 2, '.', ',');?></strong></td>

        <td  bgcolor="#999999">&nbsp;</td>

        

    </tr>

    <?php

	}elseif(($type=='mlpo' || $type=='all')){
		if($searchsuppliername == "")

	{

	//GET PURCHASE ORDER DETAILS -- all

	 $qrympodetatils = "SELECT entrydate,purchaseindentdocno,billnumber,suppliername,SUM(totalamount) AS totvalue FROM manual_lpo WHERE suppliername LIKE '%$searchsuppliername%' AND entrydate BETWEEN '$ADate1' AND '$ADate2' AND recordstatus<>'deleted' GROUP BY billnumber";

	

	}

	else

	{

		//GET PURCHASE ORDER DETAILS -- for search po

	$qrympodetatils = "SELECT entrydate,purchaseindentdocno,billnumber,suppliername,SUM(totalamount) AS totvalue FROM manual_lpo WHERE suppliercode = '$searchsuppliercode' AND entrydate BETWEEN '$ADate1' AND '$ADate2' AND recordstatus<>'deleted' GROUP BY billnumber";

	}
	?>

    <tr>

                <td width="" class="bodytext31" valign="middle"  align="center" bgcolor="#ffffff"><strong>No.</strong></td>

			    <td width=""  align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>

				<td width=""  align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>PI Number</strong></td>

				<td width=""  align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>MLPO Number</strong></td>

                 <td width=""  align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>Suplier Name</strong></td>

                 <td width=""  align="left" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>PO Status</strong></td>

                <td width=""  align="right" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>PO Value</strong></td>

                <td width=""  align="right" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>GRN Amount</strong></td>

                <td width=""  align="right" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>GRT Amount</strong></td>

                <td width=""  align="right" valign="middle" bgcolor="#ffffff" class="bodytext31"><strong>Net Purchase Value</strong></td>

				
			

	         </tr> 

    <?php

	

	$execmpodetatils = mysqli_query($GLOBALS["___mysqli_ston"], $qrympodetatils) or die ("Error in qrympodetatils".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($resmpodetatils = mysqli_fetch_array($execmpodetatils))

	{

		$billdate1 = $resmpodetatils["entrydate"];

		$pinumber1 = $resmpodetatils["purchaseindentdocno"];

		$ponumber1 = $resmpodetatils["billnumber"];
		
		$suppliername1 = $resmpodetatils["suppliername"];

		$totalamount1 = $resmpodetatils["totvalue"];

		$mlpototal = $mlpototal + $totalamount1;

		

		$mrnbuild = array();

		 $grnamount = 0;

		 $grtamount = 0;

		 $query89 = "select billnumber, sum(totalfxamount) as totalfxamount from materialreceiptnote_details where ponumber = '$ponumber1' group by billnumber";

		 $exec89 = mysqli_query($GLOBALS["___mysqli_ston"], $query89) or die ("Error in Query89".mysqli_error($GLOBALS["___mysqli_ston"]));

		 while($res89 = mysqli_fetch_array($exec89))

		 {

			 $mrnno = $res89['billnumber'];

			 $mrnbuild[] = $mrnno;

			 $grn = $res89['totalfxamount'];

			 $grnamount = $grnamount + $grn;

			 $totalgrn = $totalgrn + $grn;

		 }

		 

		 if($grnamount==$totalamount1){

			$grnstatus="PO Fully Received";

			$status_colorcode = 'COLOR: green; font-weight:bold';

		}

		else

		{

			if($grnamount!=0){

				$grnstatus="PO Partially Received";

				$status_colorcode = 'COLOR: red; font-weight:bold';

	

			}

			else{

				$grnstatus="PO Not Received";

				$status_colorcode = 'COLOR:#FFFF00; font-weight:bold';

			}

		}

		 

		 $mrnbuildvalue = implode("','",$mrnbuild);

		 

		 $query91 = "select billnumber, sum(totalamount) as totalamount from purchasereturn_details where grnbillnumber IN ('".$mrnbuildvalue."') group by billnumber";

		 $exec91 = mysqli_query($GLOBALS["___mysqli_ston"], $query91) or die ("Error in Query91".mysqli_error($GLOBALS["___mysqli_ston"]));

		 while($res91 = mysqli_fetch_array($exec91))

		 {

			 $grtno = $res91['billnumber'];

			 $grt = $res91['totalamount'];

			 $grtamount = $grtamount + $grt;

			 $totalgrt = $totalgrt + $grt;

		 }

		

		$netamount = $grnamount - $grtamount;

		$totalnet = $totalnet + $netamount;

		

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

    <tr <?php echo $colorcode;?>>

    	<td class="bodytext31" valign="middle"  align="center"><?php echo $sno = $sno + 1;?></td>

        <td class="bodytext31" valign="middle"  align="left"><?php echo $billdate1;?></td>

        <td class="bodytext31" valign="middle"  align="left"><?php echo $pinumber1;?></td>

        <td class="bodytext31" valign="middle"  align="left"><?php echo $ponumber1;?></td>

        <td class="bodytext31" valign="middle"  align="left"><?php echo $suppliername1;?></td>

        <td class="bodytext31" valign="middle"  align="left" style="<?php echo $status_colorcode;?>"><?php echo $grnstatus;?></td>

        <td class="bodytext31" valign="middle"  align="right"><?php echo  number_format($totalamount1, 2, '.', ',');?></td>

        <td class="bodytext31" valign="middle"  align="right"><?php if($grnamount!=0){ ?><a target="_blank" href="viewgrnpurchase.php?ponumber=<?= $ponumber1; ?>"><?php echo  number_format($grnamount, 2, '.', ',');?></a><?php }  else { ?> <?php echo  number_format($grnamount, 2, '.', ',');?><?php } ?></td>

        <td class="bodytext31" valign="middle"  align="right"><?php if($grtamount!=0){ ?><a target="_blank" href="viewgrtpurchase.php?ponumber=<?= $mrnbuildvalue; ?>"><?php echo  number_format($grtamount, 2, '.', ',');?></a><?php } else { ?><?php echo  number_format($grtamount, 2, '.', ',');?> <?php } ?></td>

        <td class="bodytext31" valign="middle"  align="right"><?php echo  number_format($netamount, 2, '.', ',');?></td>

      

    </tr>
   
     <?php

     if($reporttype == "detailed"){
       // Items list for po
    	$qrypodetailed = "SELECT billdate,itemcode,itemname,rate,packagequantity,username,fxtotamount,free FROM purchaseorder_details WHERE billnumber = '$ponumber1' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND recordstatus<>'deleted'";

	$execpodetailed = mysqli_query($GLOBALS["___mysqli_ston"], $qrypodetailed) or die ("Error in qrypodetailed".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($respodetailed = mysqli_fetch_array($execpodetailed))

	{

		$billdate_det = $respodetailed["billdate"];
		

		$itemcode_det = $respodetailed["itemcode"];

		$itemname_det = $respodetailed["itemname"];

		$rate_det = $respodetailed["rate"];

		$pkgqnty_det = $respodetailed["packagequantity"];

		$username_det = $respodetailed["username"];

		$fxamount_det = $respodetailed["fxtotamount"];

		$totamountval_det = $totamountval_det + $fxamount_det;



		$po_freeqty_det = $respodetailed["free"];



		$mrnqry = "SELECT sum(`itemtotalquantity`) totalrecqty FROM `materialreceiptnote_details` WHERE ponumber='$ponumber1' AND itemcode='$itemcode_det'";

		$execmrn = mysqli_query($GLOBALS["___mysqli_ston"], $mrnqry) or die ("Error in Total Rec Quantity Query".mysqli_error($GLOBALS["___mysqli_ston"]));

		$resmrn = mysqli_fetch_array($execmrn);

		((mysqli_free_result($execmrn) || (is_object($execmrn) && (get_class($execmrn) == "mysqli_result"))) ? true : false);

	

		$recqty_det = $resmrn['totalrecqty'];

		$recqty = preg_replace('~\.0+$~','',$recqty_det);



		$balqty_det = $pkgqnty_det - $recqty_det;



		$qry = "SELECT sum(free) free FROM `materialreceiptnote_details` WHERE ponumber='$ponumber1' AND itemcode='$itemcode_det' and free !='' ";

		//echo $qry.'<br>';

		$exec = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res = mysqli_fetch_assoc($exec);

		

		$recfreeqty_det = $res['free'];

		

		((mysqli_free_result($exec) || (is_object($exec) && (get_class($exec) == "mysqli_result"))) ? true : false);

		?>
			<tr>

    	

        <td class="bodytext31" valign="middle"  align="left"><?php echo $billdate_det;?></td>

        <td class="bodytext31" valign="middle"  align="left"><?php echo $itemcode_det;?></td>

        <td class="bodytext31" valign="middle"  align="left"><?php echo $itemname_det;?></td>

        <td class="bodytext31" valign="middle"  align="left"><?php echo $rate_det;?></td>

        <td class="bodytext31" valign="middle"  align="center"><?php echo $pkgqnty_det;?></td>

        <td class="bodytext31" valign="middle"  align="center"><?php echo $po_freeqty_det;?></td>

        <td class="bodytext31" valign="middle"  align="center"><?php echo $recqty_det;?></td>

         <td class="bodytext31" valign="middle"  align="center"><?php echo $recfreeqty_det;?></td>

        <td class="bodytext31" valign="middle"  align="center"><?php echo $balqty_det;?></td>

        

        <td class="bodytext31" valign="middle"  align="right"><?php echo  number_format($fxamount_det, 2, '.', ',');?></td>

    </tr>


	<?php } 

		}?>

   

	<?php }

	?>

     <tr>

    	<td colspan="5"  bgcolor="#999999">&nbsp;</td>

        <td class="bodytext31" valign="middle"  align="right"  bgcolor="#999999"><strong>Total</strong></td>

        <td class="bodytext31" valign="middle"  align="right"  bgcolor="#999999"><strong><?php echo number_format($mlpototal, 2, '.', ',');?></strong></td>

        <td class="bodytext31" valign="middle"  align="right"  bgcolor="#999999"><strong><?php echo number_format($totalgrn, 2, '.', ',');?></strong></td>

        <td class="bodytext31" valign="middle"  align="right"  bgcolor="#999999"><strong><?php echo number_format($totalgrt, 2, '.', ',');?></strong></td>

        <td class="bodytext31" valign="middle"  align="right"  bgcolor="#999999"><strong><?php echo number_format($totalnet, 2, '.', ',');?></strong></td>

        <td  bgcolor="#999999">&nbsp;</td>

        

    </tr>

    <?php

	}

	$grandtotal=$lpototal+$mlpototal;

	$grandgrn = $grandgrn + $totalgrn;

	$grandgrt = $grandgrt + $totalgrt;

	$grandnet = $grandnet + $totalnet;

	

	

	if($lpototal && $mlpototal !=0)

	{

?>  

    <tr>
<?php 
if($reporttype=='supplierwise'){ ?> <td colspan="7"  bgcolor="#999999">&nbsp;</td> <?php }else{ ?><td colspan="5"  bgcolor="#999999">&nbsp;</td> <?php } ?>
    	<!-- <td colspan="5"  bgcolor="#999999">&nbsp;</td> -->

        <td class="bodytext31" valign="middle"  align="right"  bgcolor="#999999"><strong>Grand Total</strong></td>

        <td class="bodytext31" valign="middle"  align="right"  bgcolor="#999999"><strong><?php echo number_format($grandtotal, 2, '.', ',');?></strong></td>

        <td class="bodytext31" valign="middle"  align="right"  bgcolor="#999999"><strong><?php echo number_format($grandgrn, 2, '.', ',');?></strong></td>

        <td class="bodytext31" valign="middle"  align="right"  bgcolor="#999999"><strong><?php echo number_format($grandgrt, 2, '.', ',');?></strong></td>

        <td class="bodytext31" valign="middle"  align="right"  bgcolor="#999999"><strong><?php echo number_format($grandnet, 2, '.', ',');?></strong></td>

        <td  bgcolor="#999999">&nbsp;</td>

    </tr>

    <?php

	}

	?>

   
         </tbody>

        </table>


<?php	

}

?>



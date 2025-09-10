

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

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$location =isset( $_REQUEST['location'])?$_REQUEST['location']:'';

$dateonly = date("Y-m-d");

$colorloopcount = "";





if(isset($_REQUEST["viewflag"])){ $viewflag = $_REQUEST["viewflag"];}else{$viewflag = "";}

if(isset($_REQUEST["ponum"])){ $searchponumber = $_REQUEST["ponum"];}else{$searchponumber = "";}

if(isset($_REQUEST["suppnm"])){ $viewsupplier = $_REQUEST["suppnm"];}else{$viewsupplier = "";}



if(isset($_REQUEST["ADate1"])){ $ADate1 = $_REQUEST["ADate1"];}else{$ADate1 = date('Y-m-d');}

if(isset($_REQUEST["ADate2"])){ $ADate2 = $_REQUEST["ADate2"];}else{$ADate2 = date('Y-m-d');}



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

-->

</style>

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />    

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>



<script language="javascript">

function ajaxlocationfunction(val)

{ 

if (window.XMLHttpRequest)

					  {// code for IE7+, Firefox, Chrome, Opera, Safari

					  xmlhttp=new XMLHttpRequest();

					  }

					else

					  {// code for IE6, IE5

					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

					  }

					xmlhttp.onreadystatechange=function()

					  {

					  if (xmlhttp.readyState==4 && xmlhttp.status==200)

						{

						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;

						}

					  }

					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);

					xmlhttp.send();

}

</script>







<!--ENDS-->

<style type="text/css">

<!--

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

-->

.bal

{

border-style:none;

background:none;

text-align:right;

}

.bali

{

text-align:right;

}

.style2 {

	COLOR: #3b3b3c;

	FONT-FAMILY: Tahoma;

	text-decoration: none;

	font-size: 11px;

	font-weight: bold;

}

</style>

</head>







<script src="js/datetimepicker_css.js"></script>



<body onLoad="return funcOnLoadBodyFunctionCall()">

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

    <td width="" valign="top">

   <table width="" border="0" cellspacing="0" cellpadding="0">

   <?php

     if($viewflag == "viewflag")

	 {

		 	$sno = 0;

			$totamountval = 0;

		  if(isset($_REQUEST["ponum"])){ $searchponumber = $_REQUEST["ponum"];}else{$searchponumber = "";}

		  if(isset($_REQUEST["suppnm"])){ $viewsupplier = $_REQUEST["suppnm"];}else{$viewsupplier = "";}

          if(isset($_REQUEST["ADate1"])){ $ADate1 = $_REQUEST["ADate1"];}else{$ADate1 = date('Y-m-d');}

		  if(isset($_REQUEST["ADate2"])){ $ADate2 = $_REQUEST["ADate2"];}else{$ADate2 = date('Y-m-d');}

		  

		  $subpo=$searchponumber;

		  $mlpo=$subpo[0];

		    $mlpo;

   ?>

 	<tr>

     <td>

  		 <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="2" width="1000" align="left" border="0">

          <tbody>

             <tr bgcolor="#011E6A">

                <td colspan="12" bgcolor="#ecf0f5" class="bodytext31" align="left" valign="middle"><strong>PO Analysis Detailed Report</strong></td>

             </tr>

             <tr>

             	<td colspan="8" bgcolor="#ffffff" align="left" valign="middle" class="bodytext31">PO Number : <strong><?php echo $searchponumber;?></strong></td>

                <td colspan="4" bgcolor="#ffffff" align="right" valign="middle" class="bodytext31">From <strong><?php echo $ADate1;?></strong> To <strong><?php echo $ADate2;?></strong></td>

             </tr>

             <tr bgcolor="#999999">

                <td width="" class="bodytext31" valign="middle"  align="center"><strong>No.</strong></td>

			    <td width=""  align="left" valign="middle"  class="bodytext31"><strong>Date</strong></td>

				<td width=""  align="left" valign="middle" class="bodytext31"><strong>Item Code</strong></td>

                <td width=""  align="left" valign="middle" class="bodytext31"><strong>Item Name</strong></td>

				<td width=""  align="left" valign="middle" class="bodytext31"><strong>Rate</strong></td>

                <td width=""  align="center" valign="middle" class="style2">Ord.Qty</td>

                <td width=""  align="center" valign="middle" class="style2">Free.Qty</td>

                <td width=""  align="center" valign="middle" class="style2">Recd.Qty</td>

                 <td width=""  align="center" valign="middle" class="style2">Recd.Free.Qty</td>

                 <td width=""  align="center" valign="middle" class="style2">Bal.Qty</td>

                 <td width=""  align="center" valign="middle" class="style2">Tax %</td>
                 <td width=""  align="center" valign="middle" class="style2">Tax Amt</td>

                <td width=""  align="left" valign="middle" class="bodytext31"><strong>Username</strong></td>

                <td width=""  align="right" valign="middle" class="bodytext31"><strong>Amount</strong></td>

		     </tr>    

    

<?php

	

	if($mlpo!='M')

	{

	//GET PURCHASE ORDER DETAILS

	$qrypodetailed = "SELECT billdate,itemcode,itemname,rate,packagequantity,username,fxtotamount,free,purchaseindentdocno,itemtaxpercentage,itemtaxamount FROM purchaseorder_details WHERE billnumber = '$searchponumber' AND billdate BETWEEN '$ADate1' AND '$ADate2' AND recordstatus<>'deleted'";

	$execpodetailed = mysqli_query($GLOBALS["___mysqli_ston"], $qrypodetailed) or die ("Error in qrypodetailed".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($respodetailed = mysqli_fetch_array($execpodetailed))

	{

		$billdate = $respodetailed["billdate"];

		$itemcode = $respodetailed["itemcode"];

		$itemname = $respodetailed["itemname"];

		$rate = $respodetailed["rate"];

		$pkgqnty = $respodetailed["packagequantity"];

		$username = $respodetailed["username"];

		$fxamount = $respodetailed["fxtotamount"];

		 
		$taxpercentage = $respodetailed["itemtaxpercentage"];

    	$taxamount = $respodetailed["itemtaxamount"];
		

		$totamountval = $totamountval + $fxamount;



		$po_freeqty = $respodetailed["free"];

		$purchaseindentdocno1 = $respodetailed['purchaseindentdocno'];
		$query477 = "select purchasetype from purchase_indent where docno = '$purchaseindentdocno1'";
		$exec477 = mysqli_query($GLOBALS["___mysqli_ston"], $query477) or die ("Error in Query477".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res477 = mysqli_fetch_array($exec477);
		$purchasetypee = $res477['purchasetype'];
		$qty_condn = "";

		if($purchasetypee == 'ASSETS')
		{
				
			$qty_condn = " and itemname = '$itemname' ";
		}

		$mrnqry = "SELECT sum(`itemtotalquantity`) totalrecqty FROM `materialreceiptnote_details` WHERE ponumber='$searchponumber' AND itemcode='$itemcode' $qty_condn";

		$execmrn = mysqli_query($GLOBALS["___mysqli_ston"], $mrnqry) or die ("Error in Total Rec Quantity Query".mysqli_error($GLOBALS["___mysqli_ston"]));

		$resmrn = mysqli_fetch_array($execmrn);

		((mysqli_free_result($execmrn) || (is_object($execmrn) && (get_class($execmrn) == "mysqli_result"))) ? true : false);

	

		$recqty = $resmrn['totalrecqty'];

		$recqty = preg_replace('~\.0+$~','',$recqty);



		$balqty = $pkgqnty - $recqty;



		$qry = "SELECT sum(free) free FROM `materialreceiptnote_details` WHERE ponumber='$searchponumber' AND itemcode='$itemcode' and free !='' ";

		//echo $qry.'<br>';

		$exec = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));

		$res = mysqli_fetch_assoc($exec);

		//echo '<pre>';print_r($res);

		$recfreeqty = $res['free'];

		//echo '#'.$recfreeqty.'#<br>';

		((mysqli_free_result($exec) || (is_object($exec) && (get_class($exec) == "mysqli_result"))) ? true : false);

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

        <td class="bodytext31" valign="middle"  align="left"><?php echo $billdate;?></td>

        <td class="bodytext31" valign="middle"  align="left"><?php echo $itemcode;?></td>

        <td class="bodytext31" valign="middle"  align="left"><?php echo $itemname;?></td>

        <td class="bodytext31" valign="middle"  align="left"><?php echo $rate;?></td>

        <td class="bodytext31" valign="middle"  align="center"><?php echo $pkgqnty;?></td>

        <td class="bodytext31" valign="middle"  align="center"><?php echo $po_freeqty;?></td>

        <td class="bodytext31" valign="middle"  align="center"><?php echo $recqty;?></td>

         <td class="bodytext31" valign="middle"  align="center"><?php echo $recfreeqty;?></td>

        <td class="bodytext31" valign="middle"  align="center"><?php echo $balqty;?></td>

          <td class="bodytext31" valign="middle"  align="center"><?php echo $taxpercentage;?></td>
         <td class="bodytext31" valign="middle"  align="right"><?php echo  number_format($taxamount, 2, '.', ',');?></td>

        <td class="bodytext31" valign="middle"  align="left"><?php echo $username;?></td>

        <td class="bodytext31" valign="middle"  align="right"><?php echo  number_format($fxamount, 2, '.', ',');?></td>

    </tr>

    <?php	

	}//while--close

	}



?> 



<?php

	//MLPO//

	if($mlpo=='M')

	{

	$qrypodetailed = "SELECT entrydate,suppliercode,itemname,rate,quantity,username,totalamount,itemtaxpercentage,itemtaxamount FROM manual_lpo WHERE billnumber = '$searchponumber' AND entrydate BETWEEN '$ADate1' AND '$ADate2' AND recordstatus<>'deleted'";

	$execpodetailed = mysqli_query($GLOBALS["___mysqli_ston"], $qrypodetailed) or die ("Error in qrypodetailed".mysqli_error($GLOBALS["___mysqli_ston"]));

	while($respodetailed = mysqli_fetch_array($execpodetailed))

	{

		$billdate = $respodetailed["entrydate"];

		$itemcode = $respodetailed["suppliercode"];

		$itemname = $respodetailed["itemname"];

		$rate = $respodetailed["rate"];

		$pkgqnty = $respodetailed["quantity"];

		$username = $respodetailed["username"];

		$fxamount = $respodetailed["totalamount"];

		$taxpercentage = $respodetailed["itemtaxpercentage"];

    	$taxamount = $respodetailed["itemtaxamount"];
		

		$totamountval = $totamountval + $fxamount;

		

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

        <td class="bodytext31" valign="middle"  align="left"><?php echo $billdate;?></td>

        <td class="bodytext31" valign="middle"  align="left"><?php //echo $itemcode;?></td>

        <td class="bodytext31" valign="middle"  align="left"><?php echo $itemname;?></td>

        <td class="bodytext31" valign="middle"  align="left"><?php echo $rate;?></td>

        <td class="bodytext31" valign="middle"  align="center"><?php echo $pkgqnty;?></td>
         <td class="bodytext31" valign="middle"  align="center">&nbsp;</td>

        <td class="bodytext31" valign="middle"  align="center">&nbsp;</td>

         <td class="bodytext31" valign="middle"  align="center">&nbsp;</td>

        <td class="bodytext31" valign="middle"  align="center">&nbsp;</td>
         <td class="bodytext31" valign="middle"  align="center"><?php echo $taxpercentage;?></td>
         <td class="bodytext31" valign="middle"  align="right"><?php echo  number_format($taxamount, 2, '.', ',');?></td>

        <td class="bodytext31" valign="middle"  align="left"><?php echo $username;?></td>

        <td class="bodytext31" valign="middle"  align="right"><?php echo  number_format($fxamount, 2, '.', ',');?></td>

    </tr>

    <?php	

	}//while--close

	}

?> 

	<tr>

    	<td colspan="12" bgcolor="#999999">&nbsp;</td>

    	<td class="bodytext31" valign="middle"  align="right" bgcolor="#999999"><strong>Total</strong></td>

        <td class="bodytext31" valign="middle"  align="right" bgcolor="#999999"><strong><?php echo number_format($totamountval, 2, '.', ',');?></strong></td>

        <td class="bodytext31" valign="middle"  align="left">

        	  <a href="poanalysisdetailedreoprt_xl.php?frmflag1=frmflag1&&viewponum=<?php echo $searchponumber;?>&&ADate1=<?php echo $ADate1;?>&&ADate2=<?php echo $ADate2;?>">

              <img src="images/excel-xls-icon.png" width="30" height="30"></a>    

        </td>

    </tr> 

         </tbody>

        </table>

       </td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

    

    <?php

  } //CLOSE -- if ($cbfrmflag1 == 'cbfrmflag1')

  ?>	  

  

    </table>

    </form>

    </td>

    </tr>

  </table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>




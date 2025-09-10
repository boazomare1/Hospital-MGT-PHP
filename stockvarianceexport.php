<?php

session_start();



header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="stockvarianceexport.xls"');

header('Cache-Control: max-age=80');



include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$currentdate = date("Y-m-d");





$query23 = "select * from master_employeelocation where username='$username' order by locationname";

$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res23 = mysqli_fetch_array($exec23);

 $res7locationanum = $res23['locationcode'];









if (isset($_REQUEST["docno"])) { $docno = $_REQUEST["docno"]; } else { $docno = ""; }



$query2 = "select * from stock_taking where billnumber = '$docno'";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$store = $res2['store'];

$storecode = $res2['store'];

$locationcode = $res2['location'];
$query55 = "select * from master_location where locationcode='$locationcode'";

$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res55 = mysqli_fetch_array($exec55);

 $location = $res55['locationname'];


$res7storeanum = $res2['store'];



$query75 = "select * from master_store where storecode='$res7storeanum'";

$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res75 = mysqli_fetch_array($exec75);

 $store = $res75['store'];

?>



<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	

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







<table width="103%" border="0" cellspacing="0" cellpadding="2">



  <tr>

    <td colspan="9">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" 

            align="left" border="0">

          <tbody>

            <tr>

             

              <td colspan="1" class="bodytext31">

                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->

                <div align="center"><strong>Location </strong> <?php echo $location;?></div></td>

				<td class="bodytext31">

                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->

                <div align="left"><strong>Store </strong> <?php echo $store; ?></div></td>

               

               

            </tr>

			 <tr>

	   <td class="bodytext31" valign="center"  align="left">&nbsp;</td>

	  </tr>

             <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>

		          <td width="25%" align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Item</strong></div></td>

				 <td width="14%" align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Batch</strong></div></td>

				<td colspan="1" align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Phy.Qty</strong></div></td>

				<td colspan="1" align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Sys.Qty</strong></div></td>

         

              	<td colspan="1" align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Variance</strong></div></td>

                <td colspan="1" align="right" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Variance Cost</strong></div></td>

              </tr>

			<?php

			$colorloopcount = '';

			$sno = '';

			$i = '';

			

			$query71 = "select itemname,itemcode,batchnumber,quantity,allpackagetotalquantity,rateperunit from stock_taking where billnumber='$docno' order by auto_number desc";

			$exec71 = mysqli_query($GLOBALS["___mysqli_ston"], $query71) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));	

			$num1 = mysqli_num_rows($exec71);

			while($res71=mysqli_fetch_array($exec71))

			{

			$itemname=$res71['itemname'];

			$itemcode = $res71['itemcode'];

			$batchname = $res71['batchnumber'];

			$physicalquantity = $res71['quantity'];

			$physicalquantity = intval($physicalquantity);

			$currentstock = $res71['allpackagetotalquantity'];

			$query72 = "select itemname,itemcode,purchaseprice from master_medicine where itemcode='$itemcode' order by auto_number desc";

			$exec72 = mysqli_query($GLOBALS["___mysqli_ston"], $query72) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));	

			$num2 = mysqli_num_rows($exec72);

			$res72=mysqli_fetch_array($exec72);

			//$purchaseprice = $res72['purchaseprice'];
			$purchaseprice = $res71['rateperunit'];
			//include ('autocompletestockbatch.php');

			 //$query1 = "select sum(batch_quantity) as currentstock from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcode' and storecode ='$storecode' and batchnumber = '$batchname'";

//			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());

//			$res1 = mysql_fetch_array($exec1);

//			$currentstock = $res1['currentstock'];

//			$currentstock = $currentstock;

			$variance = $physicalquantity - $currentstock;

			

			if($currentstock > $physicalquantity)

			{

			$colorcode1 = 'bgcolor="orange"';

			}

			else if($currentstock < $physicalquantity)

			{

			$colorcode1 = 'bgcolor="yellow"';

			}

			else

			{

			$colorcode1 = '';

			}

			

			

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

				$colorcode = 'bgcolor="#5fe5de"';

			} 

			?>

            <tr >

              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>

			   <td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $itemname; ?></div></td>

				<td class="bodytext31" valign="center"  align="left">

			    <div align="center"><?php echo $batchname; ?></div></td>

		        <td colspan="1"  align="right" valign="center" class="bodytext31">

			  <div class="bodytext31" align="center"><?php echo $physicalquantity; ?></div></td>

			     <td colspan="1"  align="right" valign="center" class="bodytext31">

			  <div class="bodytext31" align="center"><?php echo $currentstock; ?></div></td>

				      <td colspan="1"  align="left" valign="center" class="bodytext31">

			  <div class="bodytext31" align="center"><?php echo $variance; ?></div></td>

               <td colspan="1"  align="left" valign="center" class="bodytext31">

			  <div class="bodytext31" align="right"><?php echo number_format($variance* $purchaseprice,2,'.',','); ?></div></td>

                </tr>

			  <?php

			}

			?>

            

          </tbody>

        </table></td>

      </tr>

	  <tr>

	   <td class="bodytext31" valign="center"  align="left">&nbsp;</td>

	  </tr>

<tr>

        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr>

              <td width="54%" align="center" valign="top" >

                    

               </td>

              

            </tr>

          </tbody>

        </table></td>

      </tr>

    </table>

</table>





<?php include ("includes/footer1.php"); ?>



</body>

</html>




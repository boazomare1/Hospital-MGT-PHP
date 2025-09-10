<?php
session_start();
error_reporting(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$timeonly = date('H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = '';
$transactiondateto = date('Y-m-d');
$errmsg = "";
$bgcolorcode = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$overalltotalamount=0;
$totalamount1=0;

if (isset($_REQUEST["arraysuppliercode"])) { $searchsuppliername = $_REQUEST["arraysuppliercode"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Doctor_Remittance.xls"');
header('Cache-Control: max-age=80');

if($cbfrmflag1 == 'cbfrmflag1'){ 
 
 
?>
<style>
.bodytext332{FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; }
</style>

        <table width="1000" border="1" align="center" cellpadding="1" cellspacing="1" >
	<!-- <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="700"  border="0">-->

	           <tr>
                <td width="40"  align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>S.No</strong></td>
                <td width="120"align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>
                <td width="120" align="left" valign="center"    bgcolor="#ffffff" class="bodytext31"><strong>Doc No</strong></td>				
				<td width="250" align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><strong>Doctorcode</strong></td>				
				<td width="100" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Cheque No</strong></td>
				<td width="180" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Bank Name</strong></td>			
			    <td width="100" class="bodytext31" valign="center"  align="left"  ><strong>Amount </strong></td>
				<td width="100" class="bodytext31" valign="center"  align="left"  ><strong>Remarks </strong></td>
              </tr>
        
			<?php
		     $totalamount = 0;

			$query5 = "select doctorcode, doctorname from master_transactiondoctor where  doctorcode LIKE '%$arraysuppliercode%' group by doctorcode";

			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

			$num=mysqli_num_rows($exec5);

			while ($res5 = mysqli_fetch_array($exec5))

			{

			$doctorcode1 = $res5['doctorcode'];

			$doctorname1 = $res5['doctorname'];

			$totalamount = 0;

			?>

			<tr>

			<td colspan="8" bgcolor="#FFF" class="bodytext31" valign="center"  align="left"><strong><?php echo $doctorname1; ?></strong></td>

			</tr>

		    <?php

		    $query3 = "select transactiondate,docno,doctorname,chequenumber,bankname,sum(transactionamount) as transactionamount,remarks from master_transactiondoctor where   doctorcode = '$doctorcode1' and transactiondate between '$ADate1' and '$ADate2' group by docno";

			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

			$num=mysqli_num_rows($exec3);

			while ($res3 = mysqli_fetch_array($exec3))

			{

				//echo $res3['auto_number'];
				$transactiondate = $res3['transactiondate'];

				$docno = $res3['docno'];

				$transactionamount = $res3['transactionamount'];
			
				$doctorname = $res3['doctorname'];

				$chequenumber = $res3['chequenumber'];

				$remarks = $res3['remarks'];

				$bank = $res3['bankname'];


				$totalamount = $totalamount + $transactionamount;
				$totalamount1 = $totalamount1 + $transactionamount;

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

			

           <tr >

              <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>

               <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php echo $transactiondate; ?></div></td>

              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"> <?php echo $docno; ?> </div>
             </td>

              <td class="bodytext31" valign="center"  align="left"><?php echo $doctorname; ?></td>

              <td class="bodytext31" valign="center"  align="left"><?php echo $chequenumber; ?></td>

			  <td class="bodytext31" valign="center"  align="left"><?php echo $bank; ?></td>

              <td class="bodytext31" valign="center"  align="right"> <div align="right"><?php echo number_format($transactionamount,2,'.',',');?></div></td>

				<td class="bodytext31" valign="center"  align="center"><?php echo $remarks; ?></td>
				
				
				
				
               </tr>

		   <?php

		   }  

		   ?>

		   <tr>

		    <td colspan="6" class="bodytext31" valign="center"  align="right" ><strong>Sub Total :</strong></td>

			<td bgcolor="#CCC" class="bodytext31" valign="center"  align="right"><strong><?php echo number_format($totalamount,2); ?></strong></td>

			

			</tr>

		   <?php

		   }
			
			  ?>
			 
			   <tr>
                <td  colspan="6" class="bodytext31" valign="center"  align="right" ><strong>Total</strong></td>
                <td class="bodytext31" valign="center"  align="right" ><strong><?php echo number_format($totalamount1,2); ?></strong></td>
				 <td class="bodytext31" valign="center"  align="left" >&nbsp;</td>                 
           	</tr>
			 
			 
			 
		 
        </table>
     
  <?php } ?>


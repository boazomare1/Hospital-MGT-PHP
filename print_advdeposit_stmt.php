<?php


ob_start();
session_start();
require_once('html2pdf/html2pdf.class.php');


//include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION["username"];

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];





//ob_start();



include('convert_currency_to_words.php');


?>

<style type="text/css">


</style>

  <page pagegroup="new" >
<?php $locationcode = "";
?>
        

		
<?php include('print_header80x80.php'); ?>
		

            

           <?php



           $patientcode=isset($_REQUEST['patientcode'])?$_REQUEST['patientcode']:'';

	if($patientcode!='')

	{

		 $detailquery="select patientname,patientcode,visitcode,docno,transactionamount,transactiondate from master_transactionadvancedeposit where  patientcode = '$patientcode' limit 1";

     





	 $docnum = "";

	$sno1='';

	$colorloopcount='';

	$showcolor='';

$exedetail=mysqli_query($GLOBALS["___mysqli_ston"], $detailquery)or die("Error in query".mysqli_error($GLOBALS["___mysqli_ston"]));

while($resquery=mysqli_fetch_array($exedetail))

{



	$patientname=$resquery['patientname'];

	}



	} ?>       

						

			

    

     

	   	<table id="AutoNumber5" style="" 

             cellspacing="10" cellpadding="10" width="50%" 

            align="center" border="0">

            

          <tbody>

             <tr><td colspan="1">&nbsp;</td><td colspan="5" class="bodytext31">Statement for <strong><?php echo  $patientname; ?></strong></td></tr>

            <tr>

              <td  class="bodytext31" 

                ><div ><strong>S.No.</strong></div></td>

                <td  align="center"><strong>Txn.Amount</strong></td>

                <td  ><strong>Doc no</strong></td>

                <td  align="center"><strong>Date</strong></td>

                 <td ><strong>Debit</strong></td>

                  <td ><strong>Credit</strong></td>

                

     

     

			            

              </tr>

	  <?php 



	$patientcode=isset($_REQUEST['patientcode'])?$_REQUEST['patientcode']:'';

	if($patientcode!='')

	{

		   

	 //$detailquery="select patientcode,billno,adjustamount,balamt,billdate from adjust_advdeposits where  patientcode = '$patientcode' order by id";





   $stmtquery="select res.* from ((select transactionamount,docno,transactiondate as stmtdate,'' as debit,transactionamount as credit from master_transactionadvancedeposit where patientcode = '$patientcode' order by transactiondate ) UNION (select adjustamount,billno,DATE(createdon),adjustamount as debit,'' as credit from adjust_advdeposits where patientcode = '$patientcode' order by createdon ) UNION (select amount,docno,recorddate as stmtdate,amount as debit,'' as credit from deposit_refund where patientcode = '$patientcode' order by recorddate) ) res order by res.stmtdate ";





	 $docnum = "";

	$sno1='';

	$colorloopcount='';

	$showcolor='';

  $total_debit = 0;

  $total_credit = 0;

$exedetail=mysqli_query($GLOBALS["___mysqli_ston"], $stmtquery)or die("Error in query".mysqli_error($GLOBALS["___mysqli_ston"]));

$numrow=mysqli_num_rows($exedetail);

if($numrow >0)

{

while($resquery=mysqli_fetch_array($exedetail))

{



	

	$docnum=$resquery['docno'];

	

  $transactiondate=$resquery['stmtdate'];

$transactionamount=$resquery['transactionamount'];





$debit = $resquery['debit'];

$credit = $resquery['credit'];



$total_debit  = $total_debit + $debit;

$total_credit = $total_credit + $credit;

  

	$sno1=$sno1+1;

	 $colorloopcount = $colorloopcount + 1;

			  $showcolor = ($colorloopcount & 1); 

			  $colorcode = '';

				if ($showcolor == 0)

				{

					

					$colorcode = 'bgcolor="#CBDBFA"';

				}

				else

				{

					

					$colorcode = 'bgcolor="#ecf0f5"';

				}

        

?>

<tr >

<td class="bodytext31"><?=$sno1;?></td>

<td class="bodytext31" ><?= number_format($transactionamount,'2','.',',');?></td>

<td class="bodytext31"><?= $docnum;?></td>

<td class="bodytext31" ><?= $transactiondate;?></td>

<td class="bodytext31" align="right"><?php if(isset($debit) && $debit !="") echo number_format($debit,'2','.',',');?></td>

<td class="bodytext31" align="right"><?php if(isset($credit) && $credit !="") echo number_format($credit,'2','.',',');?></td>



</tr>



		 <?php

} 



$total_available = $total_credit - $total_debit;

?>




             


<tr><td colspan="5" class="bodytext31" align="right"><?php echo number_format($total_debit,'2','.',','); ?></td><td colspan="1" class="bodytext31" align="right"><?php echo number_format($total_credit,'2','.',','); ?></td></tr>

<tr><td colspan="5" class="bodytext31" align="right">Avl. Balance</td><td colspan="1" class="bodytext31" align="right"><strong><?php echo number_format($total_available,'2','.',','); ?></strong></td></tr>

<?php }



}

		   ?>
</tbody>
            </table>

            </page>
        
<?php

$content = ob_get_clean();

    // convert in PDF
	 
    try

    {

        $html2pdf = new HTML2PDF('P', 'A4', 'en');

//      $html2pdf->setModeDebug();

        $html2pdf->setDefaultFont('Arial');

        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));


        $html2pdf->Output('print_advdeposit_stmt.pdf');

    }

    catch(HTML2PDF_exception $e) {

        echo $e;

        exit;

    }

	?>

<?php

require_once('html2pdf/html2pdf.class.php');

ob_start();

session_start();

include ("db/db_connect.php");

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$docno = $_SESSION['docno'];

$username = $_SESSION['username'];

$transactiondatefrom = date('Y-m-d');

$transactiondateto = date('Y-m-d');

  $ADate1=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:$transactiondatefrom;

  $ADate2=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:$transactiondateto;

$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

if($location!='')

{

	$locationcode=$location;

	}

$data = '';

$status = '';

$searchsupplier = '';



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





$fromstore=isset($_REQUEST['fromstore'])?$_REQUEST['fromstore']:"";

$tostore=isset($_REQUEST['tostore'])?$_REQUEST['tostore']:"";

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

?>

<page pagegroup="new" backtop="12mm" backbottom="20mm" backleft="2mm" backright="2mm">

<?php  include("print_header_pdf4.php"); ?>

 <page_footer>

  <div class="page_footer" style="width: 100%; text-align: center">

                     Page [[page_cu]] of [[page_nb]]

                </div>

    </page_footer>


			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 

            align="left" border="1">

            <tbody>

              <tr>

                <td colspan="13" align="center" bgcolor="#FFF" class="bodytext31">

				<strong>Stock Transfer Report From <?=$_GET['ADate1']; ?> To <?=$_GET['ADate2']; ?> </strong></td>

                </tr>


              <tr>

                <td  width="20"width="20" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></td>

                <td  width="20" align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"> <strong>Type</strong> </td>

                <td  width="20" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"> <strong> Doc No </strong> </td>

                <!-- <td  width="20"class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"> <strong>Location</strong> </td> -->

                <td  width="20"class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"> <strong> From Store </strong> </td>

                <td  width="20"class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"> <strong>To Store</strong> </td>

                <td  width="20"class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"> <strong>Date</strong> </td>
                 <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><div align="left"><strong>Category</strong></div></td>


                <td  width="20"class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"> <strong>Itemname</strong> </td>

                <td  width="20"class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"> <strong>Batch </strong> </td>

                <td  width="20"class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"> <strong>Exp.Dt </strong> </td>

                <td  width="20"class="bodytext31" valign="right"  align="right" 

                bgcolor="#ffffff"> <strong>Trn.Qty </strong> </td>

                <td  width="20"class="bodytext31" valign="right"  align="right" 

                bgcolor="#ffffff"> <strong>Cost</strong> </td>

				<td  width="20"class="bodytext31" valign="right"  align="right" 

                bgcolor="#ffffff"> <strong>Total Amt</strong> </td>

              </tr>

			  <?php

			  $colorloopcount = '';

			  $loopcount = '';

			  $totamount = 0;

			 $location=isset($_REQUEST['location'])?$_REQUEST['location']:$res1locationanum;
             if(isset($_REQUEST['categoryname'])){  $categoryname_s=$_REQUEST['categoryname']; }
               if(isset($_REQUEST['tranfer_type'])){  $tranfer_type=$_REQUEST['tranfer_type']; }

           

            if($tostore!="" && $fromstore!='' && $categoryname_s!=""){  

             $query66 = "SELECT * from master_stock_transfer where locationcode = '".$location."' and fromstore = '".$fromstore."' and tostore like '".$tostore."' and entrydate BETWEEN '".$ADate1."' and '".$ADate2."'  and categoryname='$categoryname_s'";

            }

            elseif($fromstore!="" && $tostore=='' && $categoryname_s!=""){

             $query66 = "select * from master_stock_transfer where locationcode = '".$location."' and fromstore = '".$fromstore."'  and entrydate BETWEEN '".$ADate1."' and '".$ADate2."' and categoryname='$categoryname_s'";

            }elseif($fromstore=="" && $tostore=='' && $categoryname_s!=""){

             $query66 = "select * from master_stock_transfer where locationcode = '".$location."'  and entrydate BETWEEN '".$ADate1."' and '".$ADate2."' and categoryname='$categoryname_s'";

            }

      elseif($tostore!="" && $fromstore!='' && $categoryname_s==""){
       $query66 = "SELECT * from master_stock_transfer where locationcode = '".$location."' and fromstore = '".$fromstore."' and tostore like '".$tostore."' and entrydate BETWEEN '".$ADate1."' and '".$ADate2."'  ";
      }

      elseif($fromstore!="" && $tostore=='' &&  $categoryname_s==""){

       $query66 = "select * from master_stock_transfer where locationcode = '".$location."' and fromstore = '".$fromstore."'  and entrydate BETWEEN '".$ADate1."' and '".$ADate2."'  ";

      }elseif($fromstore=="" && $tostore=='' && $categoryname_s==""){

       $query66 = "select * from master_stock_transfer where locationcode = '".$location."'  and entrydate BETWEEN '".$ADate1."' and '".$ADate2."'  ";

      }

      if($tranfer_type=="Transfer"){
        $query66 .= " and typetransfer='Transfer' ";
      }
      if($tranfer_type=="Consumable"){
        $query66 .= " and typetransfer='Consumable' ";
      }



			 $exec66 = mysqli_query($GLOBALS["___mysqli_ston"], $query66) or die ("Error in Query66".mysqli_error($GLOBALS["___mysqli_ston"]));

			 while($res66 = mysqli_fetch_array($exec66))

			 {

			  $itemcode = $res66['itemcode'];

			  $docno = $res66['docno'];

			  $typetransfer = $res66['typetransfer'];

			  $fromstore = $res66['fromstore'];

			  $tostore = $res66['tostore'];
              $categoryname = $res66['categoryname'];

			  $loopcount=$loopcount+1;

			  

			  $query22 = mysqli_query($GLOBALS["___mysqli_ston"], "select store from master_store where storecode = '$fromstore'");

			  $res22 = mysqli_fetch_array($query22);

			  $fromstore1 = $res22['store'];

			  

			  $query221 = mysqli_query($GLOBALS["___mysqli_ston"], "select store from master_store where storecode = '$tostore'");

			  $res221 = mysqli_fetch_array($query221);

			  $tostore1 = $res221['store'];



			if($typetransfer=="Consumable" || $tostore1==''){						

			  $query2a = "select accountname,accountsmain,id from master_accountname where id='$tostore'";

			  $exec2a = mysqli_query($GLOBALS["___mysqli_ston"], $query2a) or die ("Error in Query2a".mysqli_error($GLOBALS["___mysqli_ston"]));

			  $res2a = mysqli_fetch_array($exec2a);

			  $tostore1 = $res2a["accountname"];

			 }

			  

			  $batch = $res66['batch'];
			  $fifo_code = $res66['fifo_code'];
			  $transaction_quantity = $res66['transferquantity'];
			  $entrydate = $res66['entrydate'];
			  $itemname = $res66['itemname'];
			  $locationname = $res66['locationname'];


 			  $query2 = "SELECT expirydate FROM purchase_details WHERE fifo_code = '$fifo_code' and itemcode = '$itemcode' order by auto_number desc";
        //$query2 = "SELECT expirydate FROM purchase_details WHERE batchnumber = '$batch' and itemcode = '$itemcode' order by auto_number desc";
        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
        $num2 = mysqli_num_rows($exec2);
        $res2 = mysqli_fetch_array($exec2);
        $expirydate = $res2['expirydate'];
        
        if($num2==0){
        $query2 = "SELECT expirydate FROM materialreceiptnote_details WHERE fifo_code = '$fifo_code' and itemcode = '$itemcode' order by auto_number desc";
        $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
        $res2 = mysqli_fetch_array($exec2);
        $expirydate = $res2['expirydate'];
        }

			  

			  $query3 = "select purchaseprice from master_medicine where itemcode = '$itemcode'";

			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

			  $res3 = mysqli_fetch_array($exec3);

			  $rate = $res3['purchaseprice'];

			  

			  $amount = $transaction_quantity * $rate;

			  $totamount = $totamount + $amount;

			  

			  $colorloopcount = $colorloopcount + 1;

			  $showcolor = ($colorloopcount & 1); 

			  $colorcode = '';

			  if ($showcolor == 0)

			  {

			  	//$colorcode = 'bgcolor="#66CCFF"';

			  }

			  else

			  {

			  	$colorcode = 'bgcolor="#cbdbfa"';

			  }

			  ?>

              <tr>

                <td class="bodytext31" valign="center"  align="left"><?php echo $loopcount; ?></td>

                <td class="bodytext31" valign="center"  align="left">

				 <?php echo $typetransfer;?> </td>

                <td class="bodytext31" valign="center"  align="left">

                 

                   <?php echo $docno;?> 

                 </td>

               <!--  <td class="bodytext31" width="100" valign="center"  align="left"> 

				<?php echo $locationname; ?> </td> -->

                <td class="bodytext31"  valign="center"  align="left">

				 

				   <?php echo $fromstore1; ?> 

				 </td>

                <td class="bodytext31"  valign="center"  align="left">

				   <?php echo $tostore1; ?> </td>

                <td class="bodytext31" valign="center"  align="left"><?php echo $entrydate; ?> </td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $categoryname; ?> </td>
                 

                <td  width="230" class="bodytext31" valign="center"  align="left">

				   <?php echo $itemname; ?> </td>


                <td class="bodytext31" valign="center"  align="left">

				   <?php echo $batch; ?> </td>

                <td class="bodytext31" valign="center"  align="left">

				   <?php echo $expirydate; ?> </td>

                  <td class="bodytext31" valign="right"  align="right">

				   <?php echo $transaction_quantity; ?> </td>

                <td class="bodytext31" valign="right"  align="right">

				 <?php echo $rate; ?> </td>

				<td class="bodytext31" valign="right"  align="right">

				   <?php echo number_format($amount,2); ?> </td>

              </tr>

			  <?php

			  //}

			  }

			  ?>

              <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff">&nbsp;</td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff">&nbsp;</td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff">&nbsp;</td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff">&nbsp;</td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff">&nbsp;</td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff">&nbsp;</td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff">&nbsp;</td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff">&nbsp;</td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff">&nbsp;</td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff">&nbsp;</td>

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff">&nbsp;</td>

                <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>Total : </strong></td>

                <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong><?php echo number_format($totamount,2); ?></strong></td>

                </tr>

            </tbody>

        </table>

	</page>	

		

<?php



    $content = ob_get_clean();



    // convert in PDF

    require_once('html2pdf/html2pdf.class.php');

    try

    {

        $html2pdf = new HTML2PDF('L', 'A4', 'en');

//      $html2pdf->setModeDebug();

        //$html2pdf->setDefaultFont('Arial');

        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $html2pdf->Output('print_stocktransferreport.pdf');

    }

    catch(HTML2PDF_exception $e) {

        echo $e;

        exit;

    }

?>


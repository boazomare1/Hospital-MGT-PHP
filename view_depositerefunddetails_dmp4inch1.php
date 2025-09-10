<?php

require_once('html2pdf/html2pdf.class.php');

ob_start();

session_start();

error_reporting(0);

include ("includes/loginverify.php");

include ("db/db_connect.php");





$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];



$patientcode = $_REQUEST['patientcode'];

$billnumbercode = $_REQUEST['billautonumber'];

$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';

?>

<style type="text/css">

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; 

}

.style2 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; 

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; 

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c;  text-decoration:none

}

.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c;  text-decoration:none

}

.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c;  text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; 

}

.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; 

}.style2 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; 

}

.bodytext33{FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; }

.bodytext312 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; 

}



.bodytext332{FONT-WEIGHT: bold; FONT-SIZE: 25px; COLOR: #000000; }

body {

	margin-left: 0px;

	margin-top: 0px;

	

}

.bodytext33 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;

}

.bodytext34 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;

}

.bodytext35 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;

}

.bodytext36 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;

}

.bodytext37 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;

}

.bodytext38 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;

}

.bodytext39 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;

}

.bodytext40 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;

}

.bodytext41 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;

}

.bodytext42 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;

}

.bodytext43 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;

}

.page_footer

{

	font-family: Times;

	text-align:center;

	font-weight:bold;

	margin-bottom:25px;

	

}



</style>





	

	<?php //include('print_header80x80.php'); ?>

	

<table border="0" cellspacing="0" align="center" cellpadding="0" >	

       

  

<?php include ('convert_currency_to_words.php'); ?>

<?php

/*	 $query1 = "select * from master_customer where locationcode='$locationcode' and customercode = '$patientcode'";

		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());

		$num1=mysql_num_rows($exec1);

		

		$res1 = mysql_fetch_array($exec1);

		

		$patientname=$res1['customerfullname'];

		$patientcode=$res1['customercode'];

		$accountname = $res1['accountname'];

		$gender = $res1['gender'];

		$age = $res1['age'];

		

		

		$query67 = "select * from master_accountname where locationcode='$locationcode' and auto_number='$accountname'";

		$exec67 = mysql_query($query67); 

		$res67 = mysql_fetch_array($exec67);

		$accname = $res67['accountname'];*/

		

		$query1 = "select * from deposit_refund where locationcode='$locationcode' and patientcode = '$patientcode'  and docno='$billnumbercode'";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num1=mysqli_num_rows($exec1);

		
$transactionmod='';
		$transactionamount = 0.00;

		

		$res1 = mysqli_fetch_array($exec1);

	     $patientname=$res1['patientname'];

		$patientcode=$res1['patientcode'];

		$accountname = $res1['accountname'];
		
		
		 $cashamount = $res1['cashamount'];
		if($cashamount != '0')
		{
		
		$transactionmode = 'CASH';
		}
		$chequeamount = $res1['chequeamount'];
		if($chequeamount != '0')
		{
		if($transactionmode==''){
		$transactionmode = 'CHEQUE';
		}else{
		$transactionmode='SPLIT';
		}
		}
		$cardamount = $res1['cardamount'];
		if($cardamount != '0')
		{
		if($transactionmode==''){
		$transactionmode = 'CARD';
		}else{
		$transactionmode='SPLIT';
		}
		}
		$onlineamount = $res1['onlineamount'];
		if($onlineamount != '0')
		{
		if($transactionmode==''){
		$transactionmode = 'ONLINE';
		}else{
		$transactionmode='SPLIT';
		}
		}
		$creditamount = $res1['creditamount'];
		if($creditamount != '0')
		{
		if($transactionmode==''){
		$transactionmode = 'CREDIT';
		}else{
		$transactionmode='SPLIT';
		}
		}
		
		
		
		
		
		 $transactionamount = $cashamount+$chequeamount+$cardamount+$onlineamount+$creditamount;
		 
		
		//$transactionamount=$transactionmode;
		

	    //$transactionamount = $transactionamount;

	    $transactiondate = $res1['recorddate'];

		$transactiontime = $res1['recordtime'];

	    $transactiondate = strtotime($transactiondate);

		$depusername = $res1['username'];

	  

	   $transactionamountinwords = covert_currency_to_words($transactionamount); 



		?>



<tr>

  <td colspan="5"  class="bodytext32">&nbsp;</td>

  </tr>

<tr>

  <td width="78" class="bodytext37">Receipt No:</td>

  <td class="bodytext37" width="207" nowrap="nowrap"><?php echo $billnumbercode; ?></td>

  <td width="50" nowrap="nowrap" class="bodytext37">Date:</td>

  <td colspan="2" nowrap="nowrap" class="bodytext37" ><?php echo date('d/m/y',$transactiondate); ?></td>

  </tr>

<tr>

  <td colspan="5" class="bodytext32">&nbsp;</td>

  </tr>

<tr>

  <td class="bodytext37">Patient : </td>

  <td class="bodytext37" colspan="4" nowrap="nowrap"><?php echo $patientname; ?></td>

  </tr>

<tr>

  <td class="bodytext38" >Reg No: </td>

  <td class="bodytext38" colspan="4" nowrap="nowrap"><?php  echo $patientcode; ?></td>

</tr>

<tr>

  <td class="bodytext39" >Mode :</td>

  <td class="bodytext39" colspan="4" nowrap="nowrap"><?php echo $transactionmode; ?></td>

</tr>

<tr>

			<td colspan="2" class="bodytext40" >Deposit Amount: <strong><?php echo number_format($transactionamount,2,'.',','); ?></strong></td>

			

          

</tr>

		

		

		<tr>

		  <td class="bodytext32" colspan="5">&nbsp;</td>

  </tr>

		<tr>

		<td class="bodytext41" colspan="5"><?php echo $transactionamountinwords; ?></td>

	</tr>

<?php

?>





<?php



?>



<tr>

  <td colspan="5" class="bodytext32">&nbsp;</td>

</tr>





<?php



		//$age = $res1['age'];

?>

	

<?php



?>

<?php

?>



<?php



?>



<?php



?>



<tr>

<td class="bodytext42" align="right">&nbsp;</td>

<td class="bodytext42" align="right" ><strong>Served By:</strong></td>

<td width="31" colspan="2" align="right" class="bodytext42"><strong><?php echo strtoupper($depusername); ?></strong></td>

<td width="18" align="right" class="bodytext42">&nbsp;</td>

</tr>

<tr>

  <td class="bodytext43" align="right">&nbsp;</td>

  <td class="bodytext43" colspan="1" align="right" >&nbsp;</td>

  <td class="bodytext43" align="right">&nbsp;</td>

  <td class="bodytext43" align="right" colspan="1">&nbsp;</td>

  <td class="bodytext43" align="right"><strong><?php echo $transactiontime; ?></strong></td>

  

</tr>

</table>



<?php	

 /* $content = ob_get_clean();

    // convert in PDF

    try

    {

        $html2pdf = new HTML2PDF('P', 'A5', 'en');

//      $html2pdf->setModeDebug();

      //  $html2pdf->setDefaultFont('Arial');

        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

		

        $html2pdf->Output('print_depositcollection.pdf');

    }

    catch(HTML2PDF_exception $e) {

        echo $e;

        exit;

    }*/

	?>


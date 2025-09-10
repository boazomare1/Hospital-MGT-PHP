<?php

require_once('html2pdf/html2pdf.class.php');

ob_start();

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");





$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];



 $patientcode = $_REQUEST['patientcode'];

 $billnumbercode = $_REQUEST['billnumbercode'];

 $locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';

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

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>





<script type="text/javascript" src="js/autocomplete_users.js"></script>

<script type="text/javascript" src="js/autosuggestusers.js"></script>



<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

-->

</style>

</head>



<script src="js/datetimepicker_css.js"></script>
<body>

<?php include ('convert_currency_to_words.php'); ?>

<?php 

	$query1 = "select * from master_customer where  customercode = '$patientcode'";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num1=mysqli_num_rows($exec1);

		

		$res1 = mysqli_fetch_array($exec1);

		

		$patientname=$res1['customerfullname'];

		$patientcode=$res1['customercode'];

		$accountname = $res1['accountname'];

		$gender = $res1['gender'];

		$age = $res1['age'];

		

		

		$query67 = "select * from master_accountname where locationcode='$locationcode' and auto_number='$accountname'";

		$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 

		$res67 = mysqli_fetch_array($exec67);

		$accname = $res67['accountname'];

		

		$query1 = "select * from master_transactionadvancedeposit where locationcode='$locationcode' and patientcode = '$patientcode' and docno='$billnumbercode' order by auto_number desc limit 0, 1";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		$num1=mysqli_num_rows($exec1);

		

		$transactionamount = 0.00;

		

		$res1 = mysqli_fetch_array($exec1);

	     $patientname=$res1['patientname'];

		$patientcode=$res1['patientcode'];

		$accountname = $res1['accountname'];

		 $transactionmode = $res1['transactionmode'];

	    $transactionamount = $res1['transactionamount'];

	    $transactiondate = $res1['transactiondate'];

		$transactiontime = $res1['transactiontime'];

		$locationname=$res1['locationname'];

		$billnumbercode=$res1['docno'];

		//if transaction mode is split

		 $cashamount=$res1['cashamount'];

		$onlineamount=$res1['onlineamount'];

		$creditamount=$res1['creditamount'];

		$chequeamount=$res1['chequeamount'];

		$cardamount=$res1['cardamount'];

		$remarks=$res1['remarks'];

		

		$mpesanumber=$res1['mpesanumber'];

		$chequenumber=$res1['chequenumber'];

		$chequedate=$res1['chequedate'];

		$bankname=$res1['bankname'];

		$creditcardnumber=$res1['creditcardnumber'];

		$creditcardbankname=$res1['creditcardbankname'];

		$creditcardname=$res1['creditcardname'];

		$onlinenumber=$res1['onlinenumber'];

		$username=$res1['username'];

		//ends here

		

	    $transactiondate = strtotime($transactiondate);

		

	  $transactionamount=number_format($transactionamount,2,'.',',');

	   $transactionamountinwords = covert_currency_to_words($transactionamount); 



		?>




<table width="500" border="0" cellspacing="0" cellpadding="2">

 

  <tr>

    <td colspan="9">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="500">

		

		

              <form name="cbform1" method="post" action="billenquiry.php">

		<table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

           <tr> 

           <td class="bodytext33" bgcolor="#FFFFFF" >Name : </td>

    <td  class="bodytext33" bgcolor="#FFFFFF" ><?php echo $patientname; ?></td>
	
	<td  class="bodytext33"  bgcolor="#FFFFFF">Rec No:  </td>

        <td valign="top"  colspan="" class="bodytext33"  bgcolor="#FFFFFF"><?php echo $billnumbercode; ?></td>
	</tr>
	
	
	<tr>

		<td align="left" class="bodytext33" bgcolor="#FFFFFF" >Reg No: </td>

        <td  align="left" class="bodytext33" bgcolor="#FFFFFF" ><?php echo $patientcode; ?></td>
		
		 <td class="bodytext33" bgcolor="#FFFFFF">Date: </td>

		<td class="bodytext33" colspan="" bgcolor="#FFFFFF"><?php echo date("d/m/Y", $transactiondate); ?></td>
		
		</tr>

	
	
	<tr>

		<td align="left" colspan="4" class="bodytext33" bgcolor="#FFFFFF" >Deposit Amount:  <?php echo $transactionamount; ?></td>

       
		
	
		
		</tr>
		
		
		<tr>

			<td colspan="4" class="bodytext33"   bgcolor="#FFFFFF">Remarks: <strong><?php echo nl2br($remarks); ?></strong></td>

</tr>

	<tr>

  <td class="bodytext bodytext33" colspan="4"  bgcolor="#FFFFFF">Payment Mode :</td>

</tr>

	
		<tr>

		<td align="left" class="bodytext33" bgcolor="#FFFFFF" >Cash : </td>

        <td  align="left" colspan="4" class="bodytext33" bgcolor="#FFFFFF" ><?php echo number_format($cashamount,2,'.',','); ?></td>
		
		</tr>
    
	
	<tr>

		<td align="left" class="bodytext33" bgcolor="#FFFFFF" >Online :</td>

        <td  align="left" colspan="4" class="bodytext33" bgcolor="#FFFFFF" ><?php echo number_format($onlineamount,2,'.',','); ?></td>
		
		</tr>
	
	<tr>

		<td align="left" class="bodytext33" bgcolor="#FFFFFF" >Mobile Money: </td>

        <td  align="left" colspan="4" class="bodytext33" bgcolor="#FFFFFF" ><?php echo number_format($creditamount,2,'.',','); ?></td>
		
		</tr>
	<tr>

		<td align="left" class="bodytext33" bgcolor="#FFFFFF" >Cheque: </td>

        <td  align="left" colspan="4" class="bodytext33" bgcolor="#FFFFFF" ><?php echo number_format($chequeamount,2,'.',','); ?></td>
		
		</tr>
	
	<tr>

		<td align="left" class="bodytext33" bgcolor="#FFFFFF" >Credit Card:</td>

        <td  align="left" colspan="4" class="bodytext33" bgcolor="#FFFFFF" ><?php echo number_format($cardamount,2,'.',','); ?></td>
		
		</tr>
		
		
		<tr>

    <td colspan="5" class="bodytext33" bgcolor="#FFFFFF"><strong>Kenyan Shillings  </strong><?php echo str_replace('Kenyan Shillings','',$transactionamountinwords); ?></td>

  </tr>
  
  <tr>

    <td  colspan="5" align="right" class="bodytext33" bgcolor="#FFFFFF"><strong>Served By: </strong><?php echo strtoupper($username); ?></td>

  </tr>
  

		 </tbody>
		 </table>
		 </form>
		 
		

        </td>

      </tr>

    </table>

  </table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>




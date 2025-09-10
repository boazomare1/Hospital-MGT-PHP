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



<table width="1901" border="0" cellspacing="0" cellpadding="2">

 

  

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

		

		$query1 = "select * from master_transactionipdeposit where locationcode='$locationcode' and patientcode = '$patientcode' and transactionmodule = 'PAYMENT' and docno='$billnumbercode'";

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

	    $transactiondate = strtotime($transactiondate);

		$depusername = $res1['username'];

	  

	   $transactionamountinwords = covert_currency_to_words($transactionamount); 



		?>



  <tr>

    <td colspan="9">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="1134">

		

		

              <form name="cbform1" method="post" action="">

		<table width="791" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

           <tr> 

           <td class="bodytext33" bgcolor="#FFFFFF" >Receipt No: </td>

    <td  class="bodytext33" bgcolor="#FFFFFF" ><?php echo $billnumbercode; ?></td>
	
	<td  class="bodytext33"  bgcolor="#FFFFFF">Date:  </td>

        <td valign="top"  colspan="" class="bodytext33"  bgcolor="#FFFFFF"><?php echo date('d/m/y',$transactiondate);  ?></td>
	</tr>
	
	
	<tr>

		<td align="left" class="bodytext33" bgcolor="#FFFFFF" >Patient :</td>

        <td  align="left" colspan="4" class="bodytext33" bgcolor="#FFFFFF" ><?php echo $patientname; ?></td>
		
		 
		
		</tr>

	
	
	<tr>

		<td align="left" class="bodytext33" bgcolor="#FFFFFF" >Reg No:  </td>

        <td  align="left" colspan="4" class="bodytext33" bgcolor="#FFFFFF" ><?php echo $patientcode; ?></td>
		
	
		
		</tr>
	
	
	<tr>

		<td align="left" class="bodytext33" bgcolor="#FFFFFF" >Mode : </td>

        <td  align="left" colspan="4" class="bodytext33" bgcolor="#FFFFFF" ><?php echo $transactionmode; ?></td>
		
		</tr>
	
	
	 <tr>

			<td colspan="5" class="bodytext33" bgcolor="#FFFFFF">Deposit Amount: <strong><?php echo number_format($transactionamount,2,'.',','); ?></strong></td>
   

</tr>
	     
		 
		 </tr>

		<tr>

		<td class="bodytext33" colspan="5" bgcolor="#FFFFFF"><?php echo $transactionamountinwords; ?></td>

	</tr>

    
  
  <tr>
<td align="left" class="bodytext33" bgcolor="#FFFFFF"  colspan="2"> </td>

<td align="left" class="bodytext33" bgcolor="#FFFFFF" >Served By:  </td>

        <td  align="left"   class="bodytext33" bgcolor="#FFFFFF" ><?php echo strtoupper($username); ?></td>



   

  </tr>
  <tr>
<td align="left" class="bodytext33" bgcolor="#FFFFFF"  colspan="3"> </td>
    <td  colspan="" width="100" align="left" class="bodytext30" bgcolor="#FFFFFF"><?php echo  date('g.i A',strtotime($transactiontime)); ?> </td>

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




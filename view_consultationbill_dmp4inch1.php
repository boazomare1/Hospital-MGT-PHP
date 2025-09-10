<?php

require_once('html2pdf/html2pdf.class.php');

ob_start();

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER["REMOTE_ADDR"];

$updatedatetime = date('Y-m-d H:i:s');

$companyanum = $_SESSION["companyanum"];

$companyname = $_SESSION["companyname"];

$financialyear = $_SESSION["financialyear"];



$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';

if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }



/*	$query2 = "select * from master_company where locationcode='$locationcode' and auto_number = '$companyanum'";

	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());

	$res2 = mysql_fetch_array($exec2);

	$companyname = $res2["companyname"];

	$address1 = $res2["address1"];

	$area = $res2["area"];

	$city = $res2["city"];

	$pincode = $res2["pincode"];

	$phonenumber1 = $res2["phonenumber1"];

	$phonenumber2 = $res2["phonenumber2"];

	$tinnumber1 = $res2["tinnumber"];

	$cstnumber1 = $res2["cstnumber"];*/



	include('convert_currency_to_words.php');

	

	$query11 = "select * from master_billing where billnumber = '$billautonumber' ";

	$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));

	mysqli_num_rows($exec11);

	$res11 = mysqli_fetch_array($exec11);

	$res11patientfirstname = $res11['patientfirstname'];

	$res11patientfullname = $res11['patientfullname'];

	$res11patientcode = $res11['patientcode'];

	$res11visitcode = $res11['visitcode'];

	$res11billnumber = $res11['billnumber'];

	$res11consultationfees = $res11['consultationfees'];

	$res11subtotalamount = $res11['subtotalamount'];

	$convertedwords = covert_currency_to_words($res11subtotalamount);

	$res11billingdatetime = $res11['billingdatetime'];

	$res11patientpaymentmode = $res11['patientpaymentmode'];

	$res11username = $res11['username'];

	$res11cashamount = $res11['cashamount'];

	$res11chequeamount = $res11['chequeamount'];

	$res11cardamount = $res11['cardamount'];

	$res11onlineamount= $res11['onlineamount'];

  $res11adjustamount= $res11['adjustamount'];

	$res11creditamount= $res11['creditamount'];

	$res11updatetime= $res11['consultationtime'];

	$res11cashgivenbycustomer = $res11['cashgivenbycustomer'];

	$res11cashgiventocustomer = $res11['cashgiventocustomer'];

	$res11locationcode = $res11['locationcode'];

	

	$queryuser="select employeename from master_employee where username='$res11username'";

		$execuser = mysqli_query($GLOBALS["___mysqli_ston"], $queryuser) or die ("Error in queryuser".mysqli_error($GLOBALS["___mysqli_ston"]));

		$resuser = mysqli_fetch_array($execuser);

		$res11username=$resuser['employeename'];

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

 

  <tr>

    <td colspan="9">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="1134">

		

		

              <form name="cbform1" method="post" action="billenquiry.php">

		<table width="791" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

           <tr> 

           <td class="bodytext33" bgcolor="#FFFFFF" >Name : </td>

    <td  colspan="3" class="bodytext33" bgcolor="#FFFFFF" ><?php echo $res11patientfullname; ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
	
	
	<tr>

		<td align="left" class="bodytext33" bgcolor="#FFFFFF" >Reg No: </td>

        <td colspan="3" align="left" class="bodytext33" bgcolor="#FFFFFF" ><?php echo $res11patientcode; ?></td></tr>

	
	<tr>
		<td align="left" class="bodytext33" bgcolor="#FFFFFF">Visit No: </td>
        <td colspan="3" align="left" class="bodytext33" bgcolor="#FFFFFF"><?php echo $res11visitcode; ?></td></tr>

	     
<tr>

		<td class="bodytext33" bgcolor="#FFFFFF">Bill No: </td>

      <td class="bodytext33" bgcolor="#FFFFFF"><?php echo $res11billnumber; ?></td>
	  
	  
	   <td class="bodytext33" bgcolor="#FFFFFF">Bill Date: </td>

        <td class="bodytext33" bgcolor="#FFFFFF"><?php echo date("d/m/Y", strtotime($res11billingdatetime)); ?></td>
</tr>


             
<tr>

    <td class="bodytext33" width="20%" bgcolor="#FFFFFF">Consultation Charges:</td>

    <td  align="left" colspan="3" class="bodytext33" bgcolor="#FFFFFF"> <?php echo number_format($res11subtotalamount,2,'.',','); ?></td>

   

  </tr>
          
<tr>

    <td class="bodytebodytext33xt31" colspan="4" bgcolor="#FFFFFF">Payment Mode:</td>

  </tr>
		<?php if($res11cashgivenbycustomer != 0.00) { ?> 	

  <tr>

    <td class="bodytext33" bgcolor="#FFFFFF">Cash Received:</td>

    <td colspan="3" align="left" class="bodytext33" bgcolor="#FFFFFF"><?php echo number_format($res11cashgivenbycustomer,2,'.',','); ?></td>

    

  </tr>	
  
  
  <tr>

    <td class="bodytext33" bgcolor="#FFFFFF">Cash Returned:</td>

    <td colspan="3" align="left" class="bodytext33" bgcolor="#FFFFFF"><?php echo number_format($res11cashgiventocustomer,2,'.',','); ?></td>

  

  </tr>

  
<?php }?>

<?php if($res11chequeamount != 0.00) { ?> 	

  <tr>

    <td class="bodytext33" bgcolor="#FFFFFF">Cheque Amount:</td>

    <td colspan="3" align="right" class="bodytext33" bgcolor="#FFFFFF"><?php echo number_format($res11chequeamount,2,'.',','); ?></td>

    
  </tr>

  <?php } ?>
            
	<?php if($res11creditamount != 0.00) { ?> 

  <tr>

    <td class="bodytext33" bgcolor="#FFFFFF">MPESA Amount:</td>

    <td colspan="3" align="right" class="bodytext33" bgcolor="#FFFFFF"><?php echo number_format($res11creditamount,2,'.',','); ?></td>

   

  </tr>

   <?php } ?>
   
   
   
    <?php if($res11cardamount != 0.00) { ?> 

  <tr>

    <td class="bodytext33" bgcolor="#FFFFFF">Card Amount:</td>

    <td colspan="3"  align="right" class="bodytext33" bgcolor="#FFFFFF"><?php echo number_format($res11cardamount,2,'.',','); ?></td>

   

  </tr>

  <?php } ?>
  
  
  
  <?php if($res11onlineamount != 0.00) { ?>

  <tr>

    <td class="bodytext33" bgcolor="#FFFFFF">Online Amount:</td>

    <td colspan="3"  align="right" class="bodytext33" bgcolor="#FFFFFF"><?php echo number_format($res11onlineamount,2,'.',','); ?></td>


  </tr>

   <?php } ?>
   
   <?php if($res11adjustamount != 0.00) { ?>

  <tr>

    <td class="bodytext33" bgcolor="#FFFFFF">Deposit Adjusted:</td>

    <td colspan="3" align="right" class="bodytext33" bgcolor="#FFFFFF"><?php echo number_format($res11adjustamount,2,'.',','); ?></td>

   
  </tr>

   <?php } ?>
   <tr>

    <td colspan="4" class="bodytext33" bgcolor="#FFFFFF"><strong>Kenya Shillings </strong><?php echo str_replace('Kenya Shillings','',$convertedwords); ?></td>

  </tr>
  
   <tr>

    <td colspan="4" bgcolor="#FFFFFF">&nbsp;</td>

  </tr>


  <tr>

    <td  colspan="4" align="right" class="bodytext33" bgcolor="#FFFFFF"><strong>Served By: </strong><?php echo strtoupper($res11username); ?></td>

  </tr>
 <tr>

    <td  colspan="4" width="400" align="right" class="bodytext30" bgcolor="#FFFFFF"><?php echo date("d/m/Y", strtotime($res11billingdatetime)). "&nbsp;". date('g.i A',strtotime($res11updatetime)); ?> </td>

  </tr>
          </tbody>

        </table>

		</form>		</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      

        </td>

      </tr>

    </table>

  </table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>




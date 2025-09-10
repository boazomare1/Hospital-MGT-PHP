<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');
$currentdate = date('Y-m-d');



$searchsuppliername = '';

$suppliername = '';

$cbsuppliername = '';

$cbcustomername = '';

$cbbillnumber = '';

$cbbillstatus = '';

$colorloopcount = '';

$sno = '';

$snocount = '';

$visitcode1 = '';

$total = '';

$looptotalpaidamount = '0.00';

$looptotalpendingamount = '0.00';

$looptotalwriteoffamount = '0.00';

$looptotalcashamount = '0.00';

$looptotalcreditamount = '0.00';

$looptotalcardamount = '0.00';

$looptotalonlineamount = '0.00';

$looptotalchequeamount = '0.00';

$looptotaltdsamount = '0.00';

$looptotalwriteoffamount = '0.00';

$pendingamount = '0.00';

$accountname = '';

$slocation = '';

$amount = 0;



if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }

if (isset($_REQUEST["radiology"])) { $radiology = $_REQUEST["radiology"]; } else { $radiology = ""; }

if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }

if (isset($_REQUEST["slocation"])) { $slocation = $_REQUEST["slocation"]; } else { $slocation = ""; }

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

//$getcanum = $_GET['canum'];

if ($getcanum != '')

{

	$query4 = "select * from master_supplier where auto_number = '$getcanum'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res4 = mysqli_fetch_array($exec4);

	$cbsuppliername = $res4['suppliername'];

	$suppliername = $res4['suppliername'];

}



if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{



	//$cbsuppliername = $_REQUEST['cbsuppliername'];

	//$suppliername = $_REQUEST['cbsuppliername'];

	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$currentdate = $_REQUEST['ADate1'];

	$paymentreceiveddateto = $_REQUEST['ADate2'];

	$visitcode1 = 10;



}



if (isset($_REQUEST["task"])) { $task = $_REQUEST["task"]; } else { $task = ""; }

//$task = $_REQUEST['task'];

if ($task == 'deleted')

{

	$errmsg = 'Payment Entry Delete Completed.';

}



if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

//$paymenttype = $_REQUEST['paymenttype'];

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

//$billstatus = $_REQUEST['billstatus'];

if ($ADate1 != '' && $ADate2 != '')

{

	$transactiondatefrom = $_REQUEST['ADate1'];

	$transactiondateto = $_REQUEST['ADate2'];

}

else

{

	$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

	$transactiondateto = date('Y-m-d');

}



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

<script src="js/datetimepicker_css.js"></script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />      

<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/autocomplete.css">      

<script>

$(document).ready(function(e) {

   

		$('#radiology').autocomplete({

	

	source:"ajaxradiology_search.php",

	//alert(source);

	matchContains: true,

	minLength:1,

	html: true, 

		select: function(event,ui){

			var accountname=ui.item.value;

			var accountid=ui.item.id;

			var accountanum=ui.item.anum;

			$("#radiologycode").val(accountid);

			$("#radiology").val(accountname);

			

			},

    

	});

		

});

</script>

<script language="javascript">



function cbsuppliername1()

{

	document.cbform1.submit();

}



</script>

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

-->

</style>

<script language="javascript">



function funcPrintReceipt1(varRecAnum)

{

	var varRecAnum = varRecAnum

	//alert (varRecAnum);

	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php //echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

	window.open("print_payment_receipt1.php?receiptanum="+varRecAnum+"","OriginalWindow<?php //echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

}



function funcDeletePayment1(varPaymentSerialNumber)

{

	var varPaymentSerialNumber = varPaymentSerialNumber;

	var fRet;

	fRet = confirm('Are you sure want to delete this payment entry serial number '+varPaymentSerialNumber+'?');

	//alert(fRet);

	if (fRet == true)

	{

		alert ("Payment Entry Delete Completed.");

		//return false;

	}

	if (fRet == false)

	{

		alert ("Payment Entry Delete Not Completed.");

		return false;

	}

	//return false;

}



</script>

</head>



<script src="js/datetimepicker_css.js"></script>



<body>

<table width="1900" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860">

		

		

              <form name="cbform1" method="post" action="radiologytestcount.php">

                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                  <tbody>

                    <tr bgcolor="#011E6A">

                      <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Radiology Test Counts Report </strong></td>

                      <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->

                      <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">&nbsp;</td>

                    </tr>

					<tr>

                      <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF"> Search Radiology </td>

                      <td colspan="3" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">

					  <input type="text" name="radiology" id="radiology" size="60" value="<?php echo $radiology; ?>">

					  <input type="hidden" name="radiologycode" id="radiologycode">

					  </td>

                       </tr>

                    <tr>

                      <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF"> Date From </td>

                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $currentdate; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>

                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>

                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">

                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>

                    </tr>

					 <tr>

                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location </td>

                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">

                      <select name="slocation" id="slocation">
                      <option value="All">All</option>

                      	 <?php

						$query01="select locationcode,locationname from master_location where status ='' order by locationname";

						$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);

						while($res01=mysqli_fetch_array($exc01))

						{ ?>

							<option value="<?= $res01['locationcode'] ?>" <?php if($slocation==$res01['locationcode']){ echo "selected";} ?>> <?= $res01['locationname'] ?></option>		

						<?php 

						}

						?>

                      </select>

                      </td>

                      

                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>

                    <!--   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">

                      <select name="type" id="type">

                      	<option value="" selected>ALL</option>

                      	<option value="OP" <?php if($type=='OP'){ echo "selected";} ?>> OP + EXTERNAL </option>

                      	<option value="IP" <?php if($type=='IP'){ echo "selected";} ?>> IP </option>

                      

                      </select> -->

                      </td>

                      

                    </tr>

                    <tr>

                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                          <input  type="submit" value="Search" name="Submit" />

                          <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>

                    </tr>

                  </tbody>

                </table>

              </form>		</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1032" 

            align="left" border="0">

          <tbody>
          	 <td colspan="6"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo  'Between '.$ADate1.' and '.$ADate2;?></strong></td>

              <!-- </tr> -->

            

           <tr>

              <td width="3%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>

             <!--  <td width="9%" align="left" valign="left"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill Date</strong></div></td> -->

             <!--  <td width="9%" align="left" valign="left"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg Code</strong></div></td>

              <td width="9%" align="left" valign="center"  

                bgcolor="#ffffff" class="style1">Visit Code</td>

              <td width="16%" align="left" valign="left"  

                bgcolor="#ffffff" class="style1"><div align="left"><strong>Patitent Name</strong></div></td> -->

              <td width="9%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Code</strong></div></td>

                <td width="20%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Name</strong></div></td>

                <td width="8%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>OP</strong></div></td>

                <td width="7%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>IP</strong></div></td>

                <td width="15%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total</strong></div></td>  

            </tr>

            

			<?php

			$num1=0;

			$num2=0;

			$num3=0;

			$num6=0;

			$grandtotal = 0;

			$res2itemname = '';

			

			$ADate1 = $transactiondatefrom;

			$ADate2 = $transactiondateto;
			
			if($slocation=='All')
			{
			$pass_location = "locationcode !=''";
			}
			else
			{
			$pass_location = "locationcode ='$slocation'";
			}

		    if($cbfrmflag1 == 'cbfrmflag1')

			{

			 $j = 0;
			 $op1=0;
			 $op2=0;
			 $op3=0;
			 $ip=0;
			 $count_op=0;
			 $count_op1=0;
			 $count_op2=0;
			 $count_ip=0;
			 $count_ip1=0;
			 $count_ip2=0;

	  	    
			// function searchForId($id, $array) {
			//    foreach ($array as $key => $val) {
			//        if ($val == $id) {
			//            return $key;
			//        }
			//    }
			//    return null;
			// }
			// 			$crresult = array();
			// 			$name = array('1');

			


				 $query1 = "SELECT itemname,itemcode,auto_number from master_radiology where itemname LIKE '%$radiology%' and status <> 'deleted' and $pass_location group by itemname";

				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

				while ($res1 = mysqli_fetch_array($exec1))

				{
					$itemcode=$res1['itemcode'];
					$itemname=$res1['itemname'];

			 // $querycr1in_op = "SELECT count(*) FROM (
			 	$sql1 = "SELECT '0' as ipcount, count(auto_number) as count FROM `billing_paynowradiology`  WHERE radiologyitemcode='$itemcode' AND billdate BETWEEN '$ADate1' AND '$ADate2' and $pass_location";

						 $sql2="SELECT '0' as ipcount, count(auto_number) as count FROM `billing_externalradiology`  WHERE radiologyitemcode='$itemcode' AND billdate BETWEEN '$ADate1' AND '$ADate2'  and $pass_location";

						    $sql3="SELECT '0' as ipcount, count(auto_number) as count FROM `billing_paylaterradiology`  WHERE radiologyitemcode='$itemcode' AND billdate BETWEEN '$ADate1' AND '$ADate2' and $pass_location"; 
						   $sql4="SELECT count(auto_number) as ipcount,'0' as count FROM `billing_ipradiology`  WHERE radiologyitemcode='$itemcode' AND billdate BETWEEN '$ADate1' AND '$ADate2'  and $pass_location";
					
						   

						   $exc1 = mysqli_query($GLOBALS["___mysqli_ston"], $sql1) or die ("Error in sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
						   $exc2 = mysqli_query($GLOBALS["___mysqli_ston"], $sql2) or die ("Error in sql2".mysqli_error($GLOBALS["___mysqli_ston"]));
						   $exc3 = mysqli_query($GLOBALS["___mysqli_ston"], $sql3) or die ("Error in sql3".mysqli_error($GLOBALS["___mysqli_ston"]));
						   $exc4 = mysqli_query($GLOBALS["___mysqli_ston"], $sql4) or die ("Error in sql4".mysqli_error($GLOBALS["___mysqli_ston"]));
						   while($res_op1 = mysqli_fetch_array($exc1)) { $op1=$res_op1['count']; }
						   while($res_op2 = mysqli_fetch_array($exc2)) { $op2=$res_op2['count']; }
						   while($res_op3 = mysqli_fetch_array($exc3)) { $op3=$res_op3['count']; }
						   while($res_op4 = mysqli_fetch_array($exc4)) { $ip=$res_op4['ipcount']; }

						     // $rowcount_op=mysql_num_rows($execcr1_op);
						      
						     $count_op = $op1+$op2+$op3;
						     $count_ip = $ip; 
						     if(($count_op!=0) || ($count_ip!=0)){
						     // if(1){
								$j+=1;
								$colorloopcount = $colorloopcount + 1;
								$showcolor = ($colorloopcount & 1); 
								if ($showcolor == 0)
								{
								$colorcode = 'bgcolor="#CBDBFA"';
								}
								else{
								$colorcode = 'bgcolor="#ecf0f5"';
								}
								

						     ?>

						     <tr <?php echo $colorcode; ?>>
				<td class="bodytext31" valign="center" align="left"><?php echo $j; ?></td>
				<td class="bodytext31" valign="center"  align="left">

			    <div align="left"><?php echo $itemcode; ?></div></td>

                <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $itemname; ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $count_op; ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $count_ip; ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $count_op+$count_ip; ?></div></td>
            </tr>

			<?php } } ?>

         

		  

		   

			

            <tr>

              <td colspan="6" class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>

              

              <td width="7%"  align="left" valign="center" bgcolor="" class="bodytext31">

             <a href="radiologytestcount_xl.php?location=<?= $slocation; ?>&&cbfrmflag1=cbfrmflag1&&ADate1=<?= $transactiondatefrom ?>&&ADate2=<?= $transactiondateto ?>&&radiology=<?php echo $radiology; ?>" target="_blank"> <img src="images/excel-xls-icon.png" width="30" height="30" /> </a>

               </td> 

            </tr>

			<?php

			  }

			  ?>

          </tbody>

        </table></td>

      </tr>

    </table>

</table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>




<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

ob_start();



header('Content-Type: application/vnd.ms-excel');

header('Content-Disposition: attachment;filename="supplieractivity.xls"');

header('Cache-Control: max-age=80');

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');



$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$searchsuppliername = "";

$cbsuppliername = "";



//This include updatation takes too long to load for hunge items database.





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







//include ("autocompletebuild_supplier2.php");



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$st = $_REQUEST['st'];

if ($st == '1')

{

	$errmsg = "Success. Payment Entry Update Completed.";

}

if ($st == '2')

{

	$errmsg = "Failed. Payment Entry Not Completed.";

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



<script language="javascript">



function cbsuppliername1()

{

	document.cbform1.submit();

}







</script>



<script type="text/javascript">





function disableEnterKey(varPassed)

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

	

	var key;

	if(window.event)

	{

		key = window.event.keyCode;     //IE

	}

	else

	{

		key = e.which;     //firefox

	}



	if(key == 13) // if enter key press

	{

		//alert ("Enter Key Press2");

		return false;

	}

	else

	{

		return true;

	}

}





function process1backkeypress1()

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

}



function disableEnterKey()

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

	

	var key;

	if(window.event)

	{

		key = window.event.keyCode;     //Ie

	}

	else

	{

		key = e.which;     //firefox

	}

	

	if(key == 13) // if enter key press

	{

		return false;

	}

	else

	{

		return true;

	}



}



function paymententry1process2()

{

	if (document.getElementById("cbfrmflag1").value == "")

	{

		alert ("Search Bill Number Cannot Be Empty.");

		document.getElementById("cbfrmflag1").focus();

		//document.getElementById("cbfrmflag1").value = "<?php echo $cbfrmflag1; ?>";

		return false;

	}

}



function funcPrintReceipt1()

{

	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

}



</script>

       

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

</style>

</head>



<script src="js/datetimepicker_css.js"></script>



<body>

<table width="101%" border="0" cellspacing="0" cellpadding="2">

  

  <tr>

   

        <td>

	

		

<?php

	$colorloopcount=0;

	$sno=0;

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{



	$searchsuppliername1 = $_REQUEST['searchsuppliername'];

	$searchdocno=$_REQUEST['docno'];

	

	$fromdate=$_REQUEST['ADate1'];

	$todate=$_REQUEST['ADate2'];

		

		

$searchsuppliername = "";		

$arraysuppliercode = "";



		if($searchsuppliername1!=''){

			$arraysupplier = explode(" #", $searchsuppliername1);

			$arraysuppliername = $arraysupplier[0];

			$searchsuppliername1 = trim($arraysuppliername);

			$arraysuppliercode = $arraysupplier[1];

		}

	//echo $searchpatient;

		//$transactiondatefrom = $_REQUEST['ADate1'];

	//$transactiondateto = $_REQUEST['ADate2'];





	

?>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="929" 

            align="left" border="0">

          <tbody>

             

           <tr>

                <td width="4%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>S.No</strong></td>

                <td width="9%"align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>

                <td width="7%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Doc No</strong></td>

				  <td width="8%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Mode</strong></td>

					  <td width="9%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Inst.Number</strong></td>

				<td width="11%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Supplier Name</strong></td>

					<td width="11%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Bank Code</strong></td>

				<td width="20%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Bank Name</strong></td>

				<td width="11%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Acc.Number</strong></td>

			        <td width="10%"class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="right"><strong>Amount </strong></div></td>

            

                  </tr>

			  <?php 

			  $totalamount = 0;

            $query2 = "select * from master_transactionpharmacy where suppliercode like '%$arraysuppliercode%' and transactioncode like '%$searchdocno%' and transactionmodule = 'PAYMENT' and transactiondate between '$fromdate' and '$todate' group by docno order by auto_number desc";

			  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			  $num2 = mysqli_num_rows($exec2);

			 // echo $num2;

			  while ($res2 = mysqli_fetch_array($exec2))

			  {

			      $totalamount=0;

			 	  $transactiondate = $res2['transactiondate'];

				  $date = explode(" ",$transactiondate);

				  $docno = $res2['docno'];

				  $mode = $res2['transactionmode'];

				  $bankcode=$res2['bankcode'];

				  $bankname=$res2['bankname'];

				  $suppliername = $res2['suppliername'];

				  

				$query51="select sum(transactionamount) as transactionamount from paymentmodecredit where billnumber='$docno'";

				$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				$res51 = mysqli_fetch_array($exec51);

				$totalamount = $res51['transactionamount'];  				  				 

				  $number = $res2['chequenumber'];

				 

				  

			  $query3 = "select accountnumber from master_bank where bankcode = '$bankcode' order by auto_number desc limit 0, 1";

			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

			  $res3 = mysqli_fetch_array($exec3);

			  $accnumber = $res3['accountnumber'];

			  
if($totalamount>0){
			  

			  

			  $colorloopcount = $colorloopcount + 1;

			  $showcolor = ($colorloopcount & 1); 

			  $colorcode = '';

				if ($showcolor == 0)

				{

					//echo "if";

					$colorcode = 'bgcolor="#FFFFFF"';

				}

				else

				{

					//echo "else";

					$colorcode = 'bgcolor="#FFFFFF"';

				}

			  ?>

              <tr <?php echo $colorcode; ?>>

                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>

               

                    <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="left"><span class="bodytext32"><?php echo $date[0]; ?></span></div>

                </div></td>

						  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="left"><span class="bodytext32"><?php echo $docno; ?></span></div>

                </div></td>

           

                   <td class="bodytext31" valign="center"  align="left">

				  <div align="left"><?php echo $mode; ?></div></td>

           

                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="left"> <span class="bodytext3"> <?php echo $number; ?> </span> </div>

                </div></td>

				<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="left"> <span class="bodytext3"> <?php echo $suppliername; ?> </span> </div>

                </div></td>

				<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="left"> <span class="bodytext3"> <?php echo $bankcode; ?> </span> </div>

                </div></td>

				<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="left"> <span class="bodytext3"> <?php echo $bankname; ?> </span> </div>

                </div></td>

				<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="left"> <span class="bodytext3"> <?php echo $accnumber; ?> </span> </div>

                </div></td>

				

				<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="right"> <span class="bodytext3"> <?php echo number_format($totalamount,2,'.',','); ?> </span> </div>

                </div></td>

           

		  

                  </tr>

			  <?php

			  }

			
}
			  ?>

              

			

          </tbody>

        </table>

	

		

	  

      <?php

	  }

	  ?>

	 

	  </td>

	  </tr>

      

  </table>



</body>

</html>




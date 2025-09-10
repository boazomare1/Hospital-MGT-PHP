<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$currentdate = date("Y-m-d");


$colorloopcount ='';


$grandtotal=0;

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

.number

{

padding-left:690px;

text-align:right;

font-weight:bold;

}

-->

</style>

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<script language="javascript">



function cbcustomername1()

{

	document.cbform1.submit();

}



</script>

<script type="text/javascript" src="js/autocomplete_customer1.js"></script>

<script type="text/javascript" src="js/autosuggest3.js"></script>

<script type="text/javascript">

window.onload = function () 

{

	var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        

}





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





function loadprintpage1(banum)

{

	var banum = banum;

	window.open("print_bill1_op1.php?billautonumber="+banum+"","Window"+banum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');

	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');

}





</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

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

        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" 

            align="left" border="0">

          <tbody>

            <tr>

              <td width="4%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td colspan="9" bgcolor="#ecf0f5" class="bodytext31">

                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->

                <div align="left"><strong>Unallocated Payables</strong></div></td>

              </tr>

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
                <td colspan="11" align = "right" >
				<a href="excel_unallocatedpayables.php?cbfrmflag1=cbfrmflag1"><img  width="30" height="30" src="images/excel-xls-icon.png" style="cursor:pointer;"></a>
			</td>

              </tr>

			 <?php 
			  $totalamount = 0;
              $query2 = "select * from master_transactionpharmacy where  transactionmode <> 'CREDIT' and transactiondate between '2020-03-05' and '2020-05-05' group by paymentvoucherno order by suppliercode desc";
			  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $num2 = mysqli_num_rows($exec2);
			 // echo $num2;
			  while ($res2 = mysqli_fetch_array($exec2))
			  {
			      $totalamount=0;
			 	  $transactiondate = $res2['transactiondate'];
				  $date = explode(" ",$transactiondate);
				  $docno = $res2['paymentvoucherno'];
				  $mode = $res2['paymentmode'];
				  //$mode = 'CHEQUE';
				  $bankcode=$res2['bankcode'];
				  $bankname=$res2['appvdbank'];
				  $suppliername = $res2['suppliername'];
				$query51="select sum(approved_amount) as transactionamount from master_transactionpharmacy where paymentvoucherno='$docno'";
				$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$res51 = mysqli_fetch_array($exec51);
				$totalamount = $res51['transactionamount'];  				  				 
				  $number = $res2['appvdcheque'];
				 
				  
			  $query3 = "select accountnumber from master_bank where bankcode = '$bankcode' order by auto_number desc limit 0, 1";
			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res3 = mysqli_fetch_array($exec3);
			  $accnumber = $res3['accountnumber'];
			  
			  $query35 = "select paymentvoucherno from master_purchase where paymentvoucherno = '$docno' and billnumber IN (select billnumber from master_transactionpharmacy where paymentvoucherno='$docno' and transactiontype = 'PURCHASE' and transactionmode <> 'CREDIT')";
			  $exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die ("Error in Query35".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $row35 = mysqli_num_rows($exec35);
			  if($row35 == 0)
			  {
				  $grandtotal=$grandtotal+$totalamount;
			  $colorloopcount = $colorloopcount + 1;
			  $showcolor = ($colorloopcount & 1); 
			  $colorcode = '';
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

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

			   <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong></strong></td>

		  <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong></strong></td>

				  <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong></strong>Total</td>
				
				 <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong><?php echo number_format($grandtotal,2,'.',',');?></strong></td>

		

              </tr>

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

</form>



<?php include ("includes/footer1.php"); ?>



</body>

</html>




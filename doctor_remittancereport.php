<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));

$paymentreceiveddateto = date('Y-m-d');

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');



$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$total = '0.00';

$totalat = '0.00';

$searchsuppliername = "";

$cbsuppliername = "";

$snocount = "";

$colorloopcount="";

$range = "";

$arraysuppliername = '';

$arraysuppliercode = '';	

$totalatret = 0.00;

$totalamount1=0;

$totalamount30 = 0;

$totalamount60 = 0;

$totalamount90 = 0;

$totalamount120 = 0;

$totalamount180 = 0;

$totalamountgreater = 0;

$totalamount1 = 0;



include ("autocompletebuild_supplier1.php");





if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

//echo $searchsuppliername;

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

//echo $amount;

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }

//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];

if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

//$frmflag2 = $_POST['frmflag2'];



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

<script>

function funcAccount()

{



}

</script>



<script type="text/javascript" src="js/autocomplete_doctor.js"></script>
<script type="text/javascript" src="js/autosuggestdoctor.js"></script>

<script type="text/javascript">

window.onload = function () 

{

	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        

}

</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

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

    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>

      &nbsp;</td>

    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860">

		

		

              <form name="cbform1" method="post" action="doctor_remittancereport.php">

		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Doctor Remittance Report </strong></td>

              </tr>

           <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Doctor </td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

              <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">

              </span></td>

           </tr>

		   

			  <tr>

                      <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF"> Date From </td>

                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>

                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>

                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">

                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>

                    </tr>	

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                  <input type="submit" onClick="return funcAccount();" value="Search" name="Submit" />

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

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="927" 

            align="left" border="0">

          <tbody>

            <tr>

			  <td colspan="8" bgcolor="#FFF" class="bodytext31"><strong>Doctor Remittance</strong></td>  

              <td width="14%" bgcolor="#FFF" class="bodytext31">&nbsp;</td>

            </tr>

			<?php

				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{

					$arraysuppliercode = '';

					$arraysuppliername = '';

					if($searchsuppliername != "")

					{

					$arraysupplier = explode("#", $searchsuppliername);

					$arraysuppliername = $arraysupplier[0];

					$arraysuppliername = trim($arraysuppliername);

					$arraysuppliercode = $arraysupplier[1];

					}		
					
					
							

			     }

				?>

			<?php

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

			if ($cbfrmflag1 == 'cbfrmflag1')

			{

		   	?>

            <tr>

              <td width="5%"  align="left" valign="center" 

                bgcolor="#ccc" class="bodytext31"><strong>No.</strong></td>

              <td width="8%" align="left" valign="center"  

                bgcolor="#ccc" class="bodytext31"><div align="left"><strong>Date</strong></div></td>

				<td width="8%" align="left" valign="center"  

                bgcolor="#ccc" class="bodytext31"><strong>Doc No </strong></td>

              <td width="30%" align="left" valign="center"  

                bgcolor="#ccc" class="bodytext31"><strong> Doctorcode </strong></td>

              <td width="10%" align="left" valign="center"  

                bgcolor="#ccc" class="bodytext31"><strong>Cheque No</strong></td>

				<td width="16%" align="left" valign="center"  

                bgcolor="#ccc" class="bodytext31"><strong>Bank Name</strong></td>

              <td width="9%" align="right" valign="center"  

                bgcolor="#ccc" class="bodytext31"><strong>Amount</strong></td>

				 <td width="14%" align="center" valign="center"  

                bgcolor="#ccc" class="bodytext31"><strong>Remarks</strong></td>
				
				<td width="14%" align="center" valign="center"  

                bgcolor="#ccc" class="bodytext31"><strong>Action</strong></td>

 <td class="bodytext31"  valign="center"  align="left"> 
               <a target="_blank" href="print_doctorremittance_xls.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&arraysuppliercode=<?php echo $arraysuppliercode; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a>
            </td>


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

			<td colspan="9" bgcolor="#FFF" class="bodytext31" valign="center"  align="left"><strong><?php echo $doctorname1; ?></strong></td>

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

			

           <tr <?php  echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>

               <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php echo $transactiondate; ?></div></td>

              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"> <?php echo $docno; ?> </div>
             </td>

              <td class="bodytext31" valign="center"  align="left"><?php echo $doctorname; ?></td>

              <td class="bodytext31" valign="center"  align="left"><?php echo $chequenumber; ?></td>

			  <td class="bodytext31" valign="center"  align="left"><?php echo $bank; ?></td>

              <td class="bodytext31" valign="center"  align="right"> <div align="right"><?php echo number_format($transactionamount,2,'.',',');?></div></td>

				<td class="bodytext31" valign="center"  align="center"><?php echo $remarks; ?></td>
				
				<td class="bodytext31" valign="center"  align="center"><a href="print_doctorremittances.php?docno=<?php echo $docno; ?>" target="_blank">Print</a></td>
				
				
               </tr>

		   <?php

		   }  

		   ?>

		   <tr>

		    <td colspan="6" class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong>Sub Total :</strong></td>

			<td bgcolor="#CCC" class="bodytext31" valign="center"  align="right"><strong><?php echo number_format($totalamount,2); ?></strong></td>

			 <td class="bodytext31"  colspan="2" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

			</tr>

		   <?php

		   }

		   ?>

			<tr>

		    <td colspan="6" class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong> Total :</strong></td>

			<td bgcolor="#CCC" class="bodytext31" valign="center"  align="right"><strong><?php echo number_format($totalamount1,2); ?></strong></td>

			 <td class="bodytext31" valign="center" colspan="2"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

			</tr>

			

            <tr>

              <td class="bodytext31" colspan="2" valign="center"  align="left" 

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

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

            </tr>

			  </tbody>

        </table></td>

      </tr>

			<?php

			}

			?>

</table>





</table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>


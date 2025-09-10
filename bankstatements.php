<?php

session_start();

//error_reporting(0);

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$timeonly = date('H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = "2014-01-01";

$transactiondateto = date('Y-m-d');

$errmsg = "";

$bgcolorcode = "";



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

.number1

{

text-align:right;

padding-left:700px;

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

/*

window.onload = function () 

{

	var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        

}

*/



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



function valid()

{

	if(document.getElementById('bankname').value =='')

	{

		alert("Please Select The Bank");

		return false;

	}

}



</script>

<script src="js/datetimepicker_css.js"></script>

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

    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

	    <tr>

	 <td width="860">

              <form name="cbform1" method="post" action="bankstatements.php" onSubmit="return valid();">

                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                  <tbody>

				   

                    <tr>

              <td colspan="4" bgcolor="#ecf0f5" class="bodytext31">

                <div align="left"><strong>Bank Statement Details</strong></div></td>

			    </tr>

				<tr>

                        <td colspan="10" align="left" valign="middle"   

						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>

                      </tr>

					<tr>

					

                        <td colspan="1" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3" ><div align="left"><strong>Bank Name </strong></div></td>

                        <td align="left" valign="top"  bgcolor="#FFFFFF" colspan="3" >

						<select name="bankname" id="bankname">

					<option value="">Select Bank</option>

						<?php 

						$querybankname = "select * from master_bank where bankstatus <> 'deleted'";

						$execbankname = mysqli_query($GLOBALS["___mysqli_ston"], $querybankname) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

						while($resbankname = mysqli_fetch_array($execbankname))

						{

						?>

							<option value="<?php echo $resbankname['bankname']; ?>"  <?php if($_REQUEST['bankname']==$resbankname['bankname']) { echo "selected"; } ?> ><?php echo $resbankname['bankname'];?></option>

						<?php }

						?>

					</select></td>

                      </tr>

                      <tr bgcolor="#FFFFFF">

						  <td class="bodytext3"><strong>Date From</strong></td>

						  <td class="bodytext31" valign="center"  align="left"><div align="left"><input name="adatefrom" id="adatefrom" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

					 <img src="images2/cal.gif" onClick="javascript:NewCssCal('adatefrom')" style="cursor:pointer"/></div></td>

						   <td class="bodytext3"><strong>Date From</strong></td>

						  <td class="bodytext31" valign="center"  align="left"><div align="left"><input name="adateto" id="adateto" value="<?php echo date('Y-m-d'); ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

					 <img src="images2/cal.gif" onClick="javascript:NewCssCal('adateto')" style="cursor:pointer"/></div></td>

					  </tr>

			 		

				<tr>

                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>

                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                          <input  type="submit" value="Search" name="Submit" />

                          <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>

                    </tr>

                  </tbody>

                </table>

              </form>		</td>

	 </tr>  

	  <tr><td>&nbsp;</td></tr>		        

      <tr>

	  <?php if (isset($_REQUEST["bankname"])) { $bankname = $_REQUEST["bankname"]; } else { $bankname = ""; } ?>

	  <?php if (isset($_REQUEST["adatefrom"])) { $adatefrom = $_REQUEST["adatefrom"]; } else { $adatefrom = ""; } ?>

	  <?php if (isset($_REQUEST["adateto"])) { $adateto = $_REQUEST["adateto"]; } else { $adateto = ""; } ?>

	  <?php if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

	  if($cbfrmflag1 == 'cbfrmflag1'){ ?>



	  <tr><form action="banktransactions.php" name="checklist" method="post">

        <td><table width="600" height="80" border="0" 

            align="left" cellpadding="2" cellspacing="0" 

            bordercolor="#666666" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" >

          <tbody>

            

			<?php

			

			$colorloopcount = '';

			$apno = '';

			$totalcredit = '0.00';

			$totaldebit = '0.00';

			$query1 = "select * from bank_record where updateddate between '$adatefrom' and '$adateto' and bankname like '%$bankname%' and status <> ''";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$apnums = mysqli_num_rows($exec1);

			if($apnums !=0 )

			{?>

				 <tr>

				  <td colspan="11" bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong><?php echo $bankname.'('.$adatefrom.' to '.$adateto.')'; ?>

				   <input name="apnums" id="apnums" value="<?php echo $apnums; ?>" type="hidden"/></strong></div></td>

					</tr>

		

				<tr>

					<td width="4%"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Sno</strong></div></td>			  

				  	<td width="20%"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Description</strong></div></td>

					<td width="7%"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Debit</strong></div></td>

					<td width="7%"  align="left" valign="center" 

					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Credit</strong></div></td>

					

			   </tr>

			   <?php

				while ($res1 = mysqli_fetch_array($exec1))

				{

					$debit = '';

					$credit = '';

					$accountname = strtoupper($res1['description']);

					$docno = $res1['docno'];

					$transactionamount = $res1['bankamount'];

					$chequeno = $res1['instno'];

					$notes = $res1['notes'];

					if($notes == 'misc')

					{

						$notes = strtolower($accountname);

					}

					if($notes == 'withdrawal' || $notes == 'bank charges' || $notes == 'expenses' || $notes == 'account payable')

					{

						$debit = $transactionamount;

						$totaldebit = $totaldebit + $debit;

						$debit = number_format($debit,2,'.',',');

					}

					else

					{

						$credit = $transactionamount;

						$totalcredit = $totalcredit + $credit;

						$credit = number_format($credit,2,'.',',');

					}

					$apno = $apno + 1;

					

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

					<tr <?php echo $colorcode; ?>>

					

					  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $apno; ?></div></td>

					  

					  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php if($chequeno != ''){ echo $accountname.'('.$chequeno.')';} else{ echo $accountname; } ?></div></td>

					  

					  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $debit; ?></div></td>

					   

					  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $credit; ?></div></td>

								  

					</tr>

					  

					<?php

				}

			

			?>

			<tr><td class="bodytext31"><strong>Total Debit:</strong></td><td class="bodytext31" align="right"><strong><?php echo number_format($totaldebit,2,'.',','); ?></strong></td></tr>

			<tr><td class="bodytext31"><strong>Total Credit:</strong></td><td class="bodytext31" align="right"><strong><?php echo number_format($totalcredit,2,'.',','); ?></strong></td></tr> 

			<tr><td class="bodytext31"><strong>Balance:</strong></td><td class="bodytext31" align="right"><strong><?php echo number_format($totalcredit-$totaldebit,2,'.',','); ?></strong></td></tr> 

			<?php }else{?>

			<tr><td class="bodytext31" colspan="4" align="center"><strong>No Transactions Found</strong></td></tr><?php }?>

          </tbody>

		  

        </table>

      </td> </form>

  </tr><?php } ?>

	</table>

	  

	

  </table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>




<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$dateonly = date("Y-m-d");
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$openingbalance  = '';	
$depositamount1 = '0.00';
$withdrawamount1  = '0.00';
$bankchargesamount1  = '0.00';
$interestamount1  = '0.00';
$openingbalanceamount1 = '0.00';
$res2closingbalance  = '0.00';	
$res2depositamount1 = '0.00';
$res2withdrawamount1  = '0.00';
$res2bankchargesamount1 = '0.00';
$res2interestamount1 = '0.00';
$res2openingbalanceamount1 = '0.00';
$res2closingbalanceopen  = '0.00';	
$res2depositamount1open = '0.00';
$res2withdrawamount1open  = '0.00';
$res2bankchargesamount1open = '0.00';
$res2interestamount1open = '0.00';
$res2openingbalanceamount1open = '0.00';
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
<!--<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
--><style type="text/css">

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}

</style>
<script>
function functiontest()
{
if(document.getElementById("bankname").value == "")
{
 alert("Please Select Bank To Proceed");
 document.getElementById("bankname").focus();
 return false;
}
/*if(document.getElementById("transactiontype").value == '')
{
	alert("Please Select Transaction Type To Proceed");
	 document.getElementById("transactiontype").focus();
 	return false;
}*/
}
	</script>
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
    <td colspan="10" bgcolor="#ecf0f5"><?php  include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td><form>
                <table width="759" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>			  
                <tr>
                  <td  colspan="5" bgcolor="#ecf0f5" class="bodytext3"><strong>Bank Entry Form Report </strong></td>
                  </tr>
                <tr>
                  <td width="90" bgcolor="#ffffff" class="bodytext3"><div align="left">Bank  Name</div></td>
                  <td bgcolor="#ffffff" class="bodytext3"><select name="bankname" id="bankname">
                    <option value="">SELECT BANK </option>
                    <?php
				 	$query11 = "select * from master_bank where bankstatus ='' ";
					$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res11 = mysqli_fetch_array($exec11))
					{
					$bankname = $res11["bankname"];
					$accountnumber = $res11["accountnumber"];
					 ?>
                    <option value="<?php echo $bankname;?>-<?php echo $accountnumber;?>"><?php echo $bankname;?>-<?php echo $accountnumber;?></option>
                    <?php
					 }
					 ?>
                  </select></td>
                  <td bgcolor="#ffffff" class="bodytext3">&nbsp;</td>
                  <td bgcolor="#ffffff" class="bodytext3">&nbsp;</td>
                  <td bgcolor="#ffffff" class="bodytext3">&nbsp;</td>
                </tr>
                <tr>
                  <td bgcolor="#ffffff" class="bodytext3"><span class="bodytext31">Date From </span></td>
                  <td width="192" bgcolor="#ffffff" class="bodytext3"><span class="bodytext31">
                    <input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                    <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/></span></td>
                  <td width="107" bgcolor="#ffffff" class="bodytext3"><span class="bodytext31">Date To</span></td>
                  <td width="159" bgcolor="#ffffff" class="bodytext3"><span class="bodytext31">
                    <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                    <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/></span></td>
                  <td width="171" bgcolor="#ffffff" class="bodytext3">
 					<input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1" >				  
				  <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" onClick="return functiontest()" />                   </td>
                  </tr>
				  </tbody>
				  </table>
				  </form>
			    </td>
				  </tr>
				  
                <tr >
				<td><table width="1700" align="left" cellpadding="4" cellspacing="0"  style="border-collapse: collapse">
				<?php
 
				if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
				//$cbfrmflag1 = $_POST['cbfrmflag1'];
				if ($frmflag1 == 'frmflag1')
				{	
				if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
				if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
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
					$bankname = $_REQUEST["bankname"];
					$banknameexplode = explode("-",$bankname);
					
					$bankname1 = $banknameexplode[0];
					$bankname2 = $banknameexplode[1];
					
					 $query1 = "select * from bankentryform where bankname = '$bankname1' and accnumber = '$bankname2' and transactiondate <= '$transactiondatefrom'";
					$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res1 = mysqli_fetch_array($exec1))
					{
						  $res1transactiontype = $res1["transactiontype"];
						 $res1amount = $res1["amount"];
						
						if($res1transactiontype == 'DEPOSIT')
						{
							$depositamount = $res1amount;
							$depositamount1 = $depositamount1 + $depositamount;
							
						}
						
						
						
					}
					
					include("bankentryopeningbalance.php");
					?>
					
				<tr>
				  <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong><?php echo $bankname1; ?></strong></td>
				  <td bgcolor="#ecf0f5" class="bodytext3"><strong>A/C No : <?php echo $bankname2; ?></strong></td>
				  <td bgcolor="#ecf0f5" class="bodytext3"><div align="right"><strong>Opening Balance : </strong></div></td>
				  <td bgcolor="#ecf0f5" class="bodytext3"><?php echo number_format($res2closingbalanceopen,2,'.',','); ?></td>
				  <td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  <td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  <td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  <td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  <td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  <td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				<td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				<td bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
				  </tr>
				 
				<tr>
                  <td width="56" bgcolor="#ecf0f5" class="bodytext3"><strong>No</strong></td>
				  <td width="115" bgcolor="#ecf0f5" class="bodytext3"><strong>Opening Balance</strong></td>
                  <td width="82" bgcolor="#ecf0f5" class="bodytext3"><strong>Deposit</strong></td>
                  <td width="90" bgcolor="#ecf0f5" class="bodytext3"><strong>WithDrawal</strong></td>
				  <td width="115" bgcolor="#ecf0f5" class="bodytext3"><strong>Bank Charges</strong></td>
				  <td width="92" bgcolor="#ecf0f5" class="bodytext3"><strong>Interest</strong></td>
                  <td width="114" bgcolor="#ecf0f5" class="bodytext3"><strong>Transaction Date</strong></td>
                  <td width="120" bgcolor="#ecf0f5" class="bodytext3"><strong>Transaction Mode</strong></td>
                  <td width="118" bgcolor="#ecf0f5" class="bodytext3"><strong>Cheque Date </strong></td>
                  <td width="118" bgcolor="#ecf0f5" class="bodytext3"><strong> Cheque Number </strong></td>
                  <td width="119" bgcolor="#ecf0f5" class="bodytext3"><strong> Cheque BankName </strong></td>
                  <td width="118" bgcolor="#ecf0f5" class="bodytext3"><strong>Cheque Bank Branch </strong></td>
                  <td width="115" bgcolor="#ecf0f5" class="bodytext3"><strong>Done By </strong></td>
                  <td width="214" bgcolor="#ecf0f5" class="bodytext3"><strong>Remarks</strong></td>
                  </tr>
				  <?php
				  	$sno = '';
					$query2 = "select * from bankentryform where bankname = '$bankname1' and accnumber = '$bankname2' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
					$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res2 = mysqli_fetch_array($exec2))
					{			
						$res2bankname = $res2["bankname"];
						$res2branch = $res2["branch"];
						$res2accnumber = $res2["accnumber"];
						$res2amount = $res2["amount"];
						$res2transactiontype = $res2["transactiontype"];
						$transactiondate = $res2["transactiondate"];
						$transactionmode = $res2["transactionmode"];
						$chequedate = $res2["chequedate"];
						$chequenumber = $res2["chequenumber"];
						$chequebank = $res2["chequebankname"];
						$chequebankbranch = $res2["chequebankbranch"];
						$personname = $res2["personname"];
						$remarks = $res2["remarks"];	
						$sno = $sno +1;
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
				<tr  <?php echo $colorcode; ?>>
                  <td class="bodytext3" valign="center"  align="left"><?php echo $sno;?> </td>
				  <td class="bodytext3" valign="center"  align="left"><?php if($res2transactiontype == 'OPENING BALANCE')
						{ echo number_format($res2amount,2,'.',','); } ?>&nbsp;</td>

                  <td class="bodytext3" valign="center"  align="left"><?php if($res2transactiontype == 'DEPOSIT')
						{ echo number_format($res2amount,2,'.',','); } ?>&nbsp;</td>
                  <td class="bodytext3" valign="center"  align="left"> <?php if ($res2transactiontype == 'WITHDRAWAL')
						{ echo number_format($res2amount,2,'.',','); } ?> </td>
						<td class="bodytext3" valign="center"  align="left"><?php if($res2transactiontype == 'BANK CHARGES')
						{ echo number_format($res2amount,2,'.',','); } ?>&nbsp;</td>
                  <td class="bodytext3" valign="center"  align="left"> <?php if ($res2transactiontype == 'INTEREST')
						{ echo number_format($res2amount,2,'.',','); } ?> </td>
                  <td class="bodytext3" valign="center"  align="left"><?php echo $transactiondate;?></td>
                  <td class="bodytext3" valign="center"  align="left"><?php echo $transactionmode;?></td>
                  <td class="bodytext3" valign="center"  align="left"><?php echo $chequedate;?>&nbsp;</td>
                  <td class="bodytext3" valign="center"  align="left"><?php echo $chequenumber;?>&nbsp;</td>
                  <td class="bodytext3" valign="center"  align="left"><?php echo $chequebank;?> &nbsp;</td>
                  <td class="bodytext3" valign="center"  align="left"><?php echo $chequebankbranch ;?>&nbsp;</td>
                  <td class="bodytext3" valign="center"  align="left"><?php echo $personname;?>&nbsp;</td>
                  <td class="bodytext3" valign="center"  align="left"><?php echo $remarks;?>&nbsp;</td>
                  </tr>
				<?php
				
						if($res2transactiontype == 'OPENING BALANCE')
						{
							$res2openingbalanceamount = $res2amount;
							$res2openingbalanceamount1 = $res2openingbalanceamount1 + $res2openingbalanceamount;
							
						}
						if($res2transactiontype == 'DEPOSIT')
						{
							$res2depositamount = $res2amount;
							$res2depositamount1 = $res2depositamount1 + $res2depositamount;
							
						}
						if ($res2transactiontype == 'WITHDRAWAL')
						{
							$res2withdrawamount = $res2amount;
							$res2withdrawamount1 = $res2withdrawamount1 + $res2withdrawamount;
						}
						if ($res2transactiontype == 'BANK CHARGES')
						{
							$res2bankchargesamount = $res2amount;
							$res2bankchargesamount1 = $res2bankchargesamount1 + $res2bankchargesamount;
						}
						if ($res2transactiontype == 'INTEREST')
						{
							$res2interestamount = $res2amount;
							$res2interestamount1 = $res2interestamount1 + $res2interestamount;
						}
						
						$res2closingbalance = $res2openingbalanceamount1 + $res2depositamount1 - $res2withdrawamount1 - $res2bankchargesamount1 + $res2interestamount1;
				}
				?>

				
                  <tr bgcolor="#FFFFFF">
                     <td><span class="bodytext3"><strong>Total</strong></span></td>
					 <td class="bodytext3" valign="center"  align="left"><strong><?php echo number_format($res2openingbalanceamount1,2,'.',',');?></strong>&nbsp;</td>
                    <td class="bodytext3" valign="center"  align="left"><strong><?php echo number_format($res2depositamount1,2,'.',',');?></strong>&nbsp;</td>
                    <td class="bodytext3" valign="center"  align="left"><strong><?php echo number_format($res2withdrawamount1,2,'.',',');?> </strong></td>
                    <td><span class="bodytext3"><strong><?php echo number_format($res2bankchargesamount1,2,'.',','); ?></strong>
                    </span></td>
                    <td class="bodytext3" valign="center"  align="left"><strong><?php echo number_format($res2interestamount1,2,'.',','); ?></strong></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
					<td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr bgcolor="#ecf0f5">
								  <td colspan="2"  align="left" valign="center" class="bodytext3"><div align="right"><strong>Closing Balance </strong></div></td>
				  <td class="bodytext3" valign="center"  align="left"><strong><?php echo number_format($res2closingbalance,2,'.',',') ;?></strong>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td class="bodytext3" valign="center"  align="left">&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				   <td>&nbsp;</td>
                    <td>&nbsp;</td>
				  </tr>
				   <?php
				  }
				  ?>
	      </table></td>
            </tr>  
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>


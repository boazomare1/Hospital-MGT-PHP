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
$snocount='';
$colorloopcount='';
$res3recorddate = array();
$countitem  = '';

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
	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$paymentreceiveddateto = $_REQUEST['ADate2'];
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
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
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
             <form name="cbform1" method="post" action="tbreportlist.php">
               <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>TB Report </strong></td>
                      <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                      <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">&nbsp;</td>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="600" 
            align="left" border="0">
          <tbody>
		  <?php
		  //$ardates
		  $sCurrentDate = $transactiondatefrom;
			$sEndDate = $transactiondateto;
			 
			  
			 
			  ?>
            <tr>
              <td width="17%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="39%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Test Name </strong></div></td>
              <td width="44%" align="center" valign="center"  
                bgcolor="#ffffff" class="style1">Description</td>
			  <td width="17%" align="center" valign="center"  
                bgcolor="#ffffff" class="style1">Counts</td>
              </tr>
			  
			
			 
			  <?php
		  
		  
		  //echo $num1;
		  
		  
			
			if($countitem != '0'){
			 //$snocount = $snocount + 1;
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
			}
			?>
           <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"><?php echo ++$snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
             TB CASES DETECETD</td>
			  <td class="bodytext31" valign="center"  align="left">
             0-14(FEMALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where gender = 'female' and age <= '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			  <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
             </td>
			  <td class="bodytext31" valign="center"  align="left">
             0-14(MALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where gender = 'male' and age <= '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			 <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
             </td>
			  <td class="bodytext31" valign="center"  align="left">
             Above 14 (FEMALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where gender = 'female' and age > '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			  <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
             </td>
			  <td class="bodytext31" valign="center"  align="left">
             Above 14 (MALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where gender = 'male' and age > '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			  <tr bgcolor="#ecf0f5">
              <td class="bodytext31" valign="center"  align="left"><?php echo ++$snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
             SMEAR POSITIVE</td>
			  <td class="bodytext31" valign="center"  align="left">
             0-14(FEMALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where smear ='positive' and gender = 'female' and age <= '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			  <tr bgcolor="#ecf0f5">
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
             </td>
			  <td class="bodytext31" valign="center"  align="left">
             0-14(MALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where smear ='positive' and gender = 'male' and age <= '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			 <tr bgcolor="#ecf0f5">
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
             </td>
			  <td class="bodytext31" valign="center"  align="left">
             Above 14 (FEMALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where smear ='positive' and gender = 'female' and age > '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			  <tr bgcolor="#ecf0f5">
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
             </td>
			  <td class="bodytext31" valign="center"  align="left">
             Above 14 (MALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where smear ='positive' and gender = 'male' and age > '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			
			<tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"><?php echo ++$snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
             SMEAR NEGATIVE</td>
			  <td class="bodytext31" valign="center"  align="left">
             0-14(FEMALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where smear ='negative' and gender = 'female' and age <= '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			  <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
             </td>
			  <td class="bodytext31" valign="center"  align="left">
             0-14(MALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where smear ='negative' and gender = 'male' and age <= '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			 <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
             </td>
			  <td class="bodytext31" valign="center"  align="left">
             Above 14 (FEMALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where smear ='negative' and gender = 'female' and age > '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			  <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
             </td>
			  <td class="bodytext31" valign="center"  align="left">
             Above 14 (MALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where smear ='negative' and gender = 'male' and age > '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			  <tr bgcolor="#ecf0f5">
              <td class="bodytext31" valign="center"  align="left"><?php echo ++$snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
             EXTRA PULMONARY TB</td>
			  <td class="bodytext31" valign="center"  align="left">
             0-14(FEMALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where extrapulmonarytb ='Yes' and gender = 'female' and age <= '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			  <tr bgcolor="#ecf0f5">
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
             </td>
			  <td class="bodytext31" valign="center"  align="left">
             0-14(MALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where extrapulmonarytb ='Yes' and gender = 'male' and age <= '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			 <tr bgcolor="#ecf0f5">
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
             </td>
			  <td class="bodytext31" valign="center"  align="left">
             Above 14 (FEMALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where extrapulmonarytb ='Yes' and gender = 'female' and age > '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			  <tr bgcolor="#ecf0f5">
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
             </td>
			  <td class="bodytext31" valign="center"  align="left">
             Above 14 (MALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where extrapulmonarytb ='Yes' and gender = 'male' and age > '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			  <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"><?php echo ++$snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
             NO OF TB PATIENTS TESTED FOR HIV</td>
			  <td class="bodytext31" valign="center"  align="left">
             0-14(FEMALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where hiv <> '' and gender = 'female' and age <= '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			  <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
             </td>
			  <td class="bodytext31" valign="center"  align="left">
             0-14(MALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where hiv <> '' and gender = 'male' and age <= '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			 <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
             </td>
			  <td class="bodytext31" valign="center"  align="left">
             Above 14 (FEMALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where hiv <> '' and gender = 'female' and age > '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			  <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
             </td>
			  <td class="bodytext31" valign="center"  align="left">
             Above 14 (MALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where hiv <> '' and gender = 'male' and age > '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			  <tr bgcolor="#ecf0f5">
              <td class="bodytext31" valign="center"  align="left"><?php echo ++$snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
             HIV+</td>
			  <td class="bodytext31" valign="center"  align="left">
             0-14(FEMALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where hiv = 'positive' and gender = 'female' and age <= '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			  <tr bgcolor="#ecf0f5">
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
             </td>
			  <td class="bodytext31" valign="center"  align="left">
             0-14(MALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where hiv = 'positive' and gender = 'male' and age <= '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			 <tr bgcolor="#ecf0f5">
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
             </td>
			  <td class="bodytext31" valign="center"  align="left">
             Above 14 (FEMALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where hiv = 'positive' and gender = 'female' and age > '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			  <tr bgcolor="#ecf0f5">
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
             </td>
			  <td class="bodytext31" valign="center"  align="left">
             Above 14 (MALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where hiv = 'positive' and gender = 'male' and age > '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			   <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"><?php echo ++$snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
             TOTAL NO OF PATIENTS ON CPT</td>
			  <td class="bodytext31" valign="center"  align="left">
             0-14(FEMALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where cpt = 'Yes' and gender = 'female' and age <= '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			  <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
             </td>
			  <td class="bodytext31" valign="center"  align="left">
             0-14(MALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where cpt = 'Yes' and gender = 'male' and age <= '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			 <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
             </td>
			  <td class="bodytext31" valign="center"  align="left">
             Above 14 (FEMALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where cpt = 'Yes' and gender = 'female' and age > '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			  <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
             </td>
			  <td class="bodytext31" valign="center"  align="left">
             Above 14 (MALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where cpt = 'Yes' and gender = 'male' and age > '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			  <tr bgcolor="#ecf0f5">
              <td class="bodytext31" valign="center"  align="left"><?php echo ++$snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
             NO OF DEFAULTERS</td>
			  <td class="bodytext31" valign="center"  align="left">
             0-14(FEMALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where defaulter ='Yes' and gender = 'female' and age <= '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			  <tr bgcolor="#ecf0f5">
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
             </td>
			  <td class="bodytext31" valign="center"  align="left">
             0-14(MALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where defaulter ='Yes' and gender = 'male' and age <= '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			 <tr bgcolor="#ecf0f5">
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
             </td>
			  <td class="bodytext31" valign="center"  align="left">
             Above 14 (FEMALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where defaulter ='Yes' and gender = 'female' and age > '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			  <tr bgcolor="#ecf0f5">
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
             </td>
			  <td class="bodytext31" valign="center"  align="left">
             Above 14 (MALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where defaulter ='Yes' and gender = 'male' and age > '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			  <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"><?php echo ++$snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
             NO OF COMPLETED TB TREATMENTS</td>
			   <td class="bodytext31" valign="center"  align="left">
             0-14(FEMALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where nooftreatcomp = 'Yes' and gender = 'female' and age <= '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			  <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
             </td>
			  <td class="bodytext31" valign="center"  align="left">
             0-14(MALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where nooftreatcomp = 'Yes' and gender = 'male' and age <= '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			 <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
             </td>
			  <td class="bodytext31" valign="center"  align="left">
             Above 14 (FEMALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where nooftreatcomp = 'Yes' and gender = 'female' and age > '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
			  
			  <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
             </td>
			  <td class="bodytext31" valign="center"  align="left">
             Above 14 (MALE)</td>
              <td class="bodytext31" valign="center"  align="center">
               <?php 
				$query12 = "select * from tbtemplate where nooftreatcomp = 'Yes' and gender = 'male' and age > '14' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
				$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num12 = mysqli_num_rows($exec12);
				echo $num12; ?>           </td>
              </tr>
            <tr>
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
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>


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
$errmsg = "";
$banum = "1";
$bgcolorcode = '';
$colorloopcount = '0';

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if (isset($_REQUEST["accountname"])) { $searchaccountname = $_REQUEST["accountname"]; } else { $searchaccountname = ""; }

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
<script language="javascript">

function cbcustomername1()
{
	document.cbform1.submit();
}

</script>
<script type="text/javascript" src="js/autocomplete_customer1.js"></script>
<script type="text/javascript" src="js/autosuggest3.js"></script>
<script type="text/javascript" src="js/expensefunction.js"></script>

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
		key = window.event.keyCode;     //IE
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


</script>
<script>
function coasearch(varCallFrom)
{
	var varCallFrom = varCallFrom;
	window.open("popup_openingbalacesearch.php?callfrom="+varCallFrom,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
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
        <td >
		
		
		
				<form name="form1" id="form1" method="post" action="editopeningbalancelist.php">
			  <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                <tbody>
                  <tr bgcolor="#011E6A">
                    <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Opening Balance Account - Details </strong></td>
                    <!--<td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                    <td bgcolor="#ecf0f5" class="bodytext3" colspan="2">&nbsp;</td>
                  </tr>
                
                  <tr>
                    <td colspan="2" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="text" name="accountname" id="paynowreferalcoa" size="40" value="<?php echo $searchaccountname; ?>" placeholder = "Search Docno"/>
						 <input type="hidden" onClick="javascript:coasearch('4')" value="Select Account" accesskey="m" style="border: 1px solid #001E6A"> 
						 <input type="hidden" name="paynowlabtype5" id="paynowreferaltype" size="10"/>
						 	<input type="hidden" name="cashcoa" value="<?php echo $cashcoa; ?>">
				<input type="hidden" name="chequecoa" value="<?php echo $chequecoa; ?>">
				<input type="hidden" name="mpesacoa" value="<?php echo $mpesacoa; ?>">
				<input type="hidden" name="cardcoa" value="<?php echo $cardcoa; ?>">
				<input type="hidden" name="onlinecoa" value="<?php echo $onlinecoa; ?>">
	
						 <input type="hidden" name="paynowlabcode5" id="paynowreferalcode" size="10"/>
                         <input type="hidden" name="cbfrmflag2" value="<?php echo $customeranum; ?>">
                      <input type="hidden" name="frmflag1" value="frmflag1">
                      <input name="Submit" type="submit"  value="Search" class="button" style="border: 1px solid #001E6A"/></td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><b id="balamount" style="display:none"></b></td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"></td>
                  </tr>
                
                </tbody>
              </table>
			  </form>		</td>
      </tr>
      <tr>
        <td>
        <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
         <tbody>
         <tr bgcolor="#ecf0f5">
         <td width="33" align="left" class="bodytext31"><strong>S.No</strong></td>
         <td width="65" align="left" class="bodytext31"><strong>Doc No</strong></td>
         <td width="52" align="left" class="bodytext31"><strong>ID</strong></td>
         <td width="303" align="left" class="bodytext31"><strong>Account Name</strong></td>
         <td width="132" align="right" class="bodytext31"><strong>Opening Balance</strong></td>
         <td width="98" align="right" class="bodytext31"><strong>Entry Date</strong></td>
         <td width="61" align="right" class="bodytext31"><strong>Edit</strong></td>
         </tr>
		 <?php
		 $sum1 = 0;
		 $query8 = "select accountssub, auto_number from master_accountssub where recordstatus <> 'deleted'"; 
		 $exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
		 while($res8 = mysqli_fetch_array($exec8))
		 {
			$accountssub = $res8['auto_number'];
			$accountssubname = $res8['accountssub'];
		 ?>
		 <tr>
		 <td colspan="7" align="left" class="bodytext3"><strong><?= $accountssubname; ?></strong></td>
		 </tr>
		 <?php	
		 $sum1 = 0;
		 $query9 = "select id, auto_number from master_accountname where accountssub = '$accountssub' order by auto_number";
		 $exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		 while($res9 = mysqli_fetch_array($exec9))
		 {
			$accountcode = $res9['id'];
			
		 $query5 = "select * from openingbalanceaccount where accountcode = '$accountcode' and docno like '%$searchaccountname%'";
		 $exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
		 while($res5 = mysqli_fetch_array($exec5))
		 {
			 $anum = $res5['auto_number'];
			 $docno = $res5['docno'];
			 $accountcode = $res5['accountcode'];
			 $accountname = $res5['accountname'];
			 $openbalanceamount = $res5['openbalanceamount'];
			 $entrydate = $res5['entrydate'];
			 $entrytime = $res5['entrytime'];
			 $sum1 = $sum1 + $openbalanceamount;
			 			  
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
        <td align="left" class="bodytext31"><?php echo $colorloopcount; ?></td>
        <td align="left" class="bodytext31"><?php echo $docno; ?></td>
        <td align="left" class="bodytext31"><?php echo $accountcode; ?></td>
        <td align="left" class="bodytext31"><?php echo $accountname; ?></td>
        <td align="right" class="bodytext31"><?php echo $openbalanceamount; ?></td>
        <td align="right" class="bodytext31"><?php echo $entrydate; ?></td>
        <td align="right" class="bodytext31"><a href="editopeningbalanceentry1.php?opentrydate=<?php echo $entrydate; ?>&&opentrytime=<?php echo $entrytime; ?>"><?php echo 'Edit'; ?></a></td>
         </tr>
         <?php 
		 }
		 $query23 = "select * from openingbalancesupplier where accountcode = '$accountcode' and docno like '%$searchaccountname%'";
		 $exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));
		 while($res23 = mysqli_fetch_array($exec23))
		 {
			 $anum1 = $res23['auto_number'];
			 $docno = $res23['docno'];
			 $accountcode = $res23['accountcode'];
			 $accountname = $res23['accountname'];
			 $openbalanceamount = $res23['openbalanceamount'];
			 $entrydate = $res23['entrydate'];
			 $entrytime = $res23['entrytime'];
			 $sum1 = $sum1 + $openbalanceamount;
			 			  
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
        <td align="left" class="bodytext31"><?php echo $colorloopcount; ?></td>
        <td align="left" class="bodytext31"><?php echo $docno; ?></td>
        <td align="left" class="bodytext31"><?php echo $accountcode; ?></td>
        <td align="left" class="bodytext31"><?php echo $accountname; ?></td>
        <td align="right" class="bodytext31"><?php echo $openbalanceamount; ?></td>
        <td align="right" class="bodytext31"><?php echo $entrydate; ?></td>
        <td align="right" class="bodytext31"><a href="editopeningbalanceentry1.php?opentrydate=<?php echo $entrydate; ?>&&opentrytime=<?php echo $entrytime; ?>"><?php echo 'Edit'; ?></a></td>
         </tr>
         <?php 
		 }
		 
		 /*$query25 = "select * from master_fixedassets where fixedassetcode = '$accountcode'";
		 $exec25 = mysql_query($query25) or die ("Error in Query25".mysql_error());
		 while($res25 = mysql_fetch_array($exec25))
		 {
			 $anum2 = $res25['auto_number'];
			 $docno = $res25['id'];
			 $accountcode = $res25['fixedassetcode'];
			 $accountname = $res25['fixedassets'];
			 $openbalanceamount = $res25['assetvalue'];
			 $entrydate = $res25['entrydate'];
			 $sum1 = $sum1 + $openbalanceamount;
			 			  
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
        <td align="left" class="bodytext31"><?php echo $colorloopcount; ?></td>
        <td align="left" class="bodytext31"><?php echo $docno; ?></td>
        <td align="left" class="bodytext31"><?php echo $accountcode; ?></td>
        <td align="left" class="bodytext31"><?php echo $accountname; ?></td>
        <td align="right" class="bodytext31"><?php echo $openbalanceamount; ?></td>
        <td align="right" class="bodytext31"><?php echo $entrydate; ?></td>
        <td align="right" class="bodytext31"><a href="editfixedassets.php?st=edit&&anum=<?php echo $anum2; ?>"><?php echo 'Edit'; ?></a></td>
         </tr>
         <?php 
		 }*/
		 }
		 ?>
		  <tr bgcolor="#CCC">
         <td colspan="5" align="right" class="bodytext31"><strong><?php echo number_format($sum1,2); ?></strong></td>
		 <td colspan="2" align="right" class="bodytext31">&nbsp;</td>
         </tr>
        <?php
		}
		?>
         </tbody>
         </table>
        </td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>


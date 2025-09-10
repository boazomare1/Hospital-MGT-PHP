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
$total = '0';
$pendingamount = '0.00';
$accountname = '';
$amount=0;

if (isset($_REQUEST["slocation"])) { $slocation = $_REQUEST["slocation"]; } else { $slocation = ""; }
if (isset($_REQUEST["typemode"])) { $typemode = $_REQUEST["typemode"];  } else { $typemode = ""; }
//$getcanum = $_GET['canum'];


if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	//$cbsuppliername = $_REQUEST['cbsuppliername'];
	//$suppliername = $_REQUEST['cbsuppliername'];
	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$paymentreceiveddateto = $_REQUEST['ADate2'];
	//$visitcode1 = 10;

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

<script language="javascript">


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



</script>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="1800" border="0" cellspacing="0" cellpadding="2">
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
		
		
              <form name="cbform1" method="post" action="theatrecancellationreport.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Theatre Cancellation Report </strong></td>
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
		   			<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Reason </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF" colspan="3"  >
					<select name="typemode" id="typemode"  >
                        <option value="">ALL</option>
                        <option value="Financial cash"<?php if($typemode=='Financial cash') echo 'selected'; ?>>Financial cash</option>
                        <option value="Patient medical condition"<?php if($typemode=='Patient medical condition') echo 'selected'; ?>>Patient medical condition</option>
						<option value="Surgeon not available"<?php if($typemode=='Surgeon not available') echo 'selected'; ?>>Surgeon not available</option>
						<option value="Equipment/ instruments not available"<?php if($typemode=='Equipment/ instruments not available') echo 'selected'; ?>>Equipment/ instruments not available</option>
						<option value="Patient declined surgery"<?php if($typemode=='Patient declined surgery') echo 'selected'; ?>>Patient declined surgery</option>
						<option value="Patient did not show up"<?php if($typemode=='Patient did not show up') echo 'selected'; ?>>Patient did not show up</option>
						<option value="Financial insurance"<?php if($typemode=='Financial insurance') echo 'selected'; ?>>Financial insurance</option>
                    </select></td>
                  </tr>
					
					
					
                   
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location </td>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
                      <select name="slocation" id="slocation">
                      	<?php
						$query01="select locationcode,locationname from master_location where status ='' order by locationname";
						$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
						while($res01=mysqli_fetch_array($exc01))
						{?>
							<option value="<?= $res01['locationcode'] ?>" <?php if($slocation==$res01['locationcode']){ echo "selected";} ?>> <?= $res01['locationname'] ?></option>		
						<?php 
						}
						?>
                      </select>
                      </td>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
                      
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
        <td>
            
         
            
			<?php
			
			
			$ADate1 = $transactiondatefrom;
			$ADate2 = $transactiondateto;
			
			$colorloopcount = '';
            $sno = '';
			
			if($cbfrmflag1 == 'cbfrmflag1')
			{ 
			
		
			?>
			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="500" align="left" border="0">
          <tbody>
			 <tr>
              <td  colspan="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">Description</strong></td>
			  <td  colspan="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">Count</strong></td>
			  <td  colspan="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">Action</strong></td>
            </tr>
			
			
			 <?php
			 $querycr1in = " SELECT count(auto_number) as count,auto_number,category,cancel_reason FROM `master_theatre_booking`  WHERE date(date) BETWEEN '$ADate1' AND '$ADate2'  and cancel_reason like '%$typemode%' group by cancel_reason";	
			 $execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $rows = mysqli_num_rows($execcr1);
			 while($res = mysqli_fetch_array($execcr1))
			 {
			 $bookingid = $res['auto_number'];
			 $category=$res['category'];
			 $count=$res['count'];
			 $cancel_reason=$res['cancel_reason'];
			 
			  
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
              <td width=""  align="left" valign="center"  class="bodytext31"><?php echo $cancel_reason; ?></td>
			  <td width="" align="left" valign="center"   class="bodytext31"><?php echo $count; ?></td>
			  <td width="" align="left" valign="center"   class="bodytext31"><span class="bodytext3"><a target="_blank" href="theatrecancellationview_report.php?cancel_reason=<?php echo $cancel_reason; ?>&&cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>">VIEW</a> </span> </td>
			 
            </tr>
			
			 
			<?php
			} 
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


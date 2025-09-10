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
if (isset($_REQUEST["overview"])) { $overview = $_REQUEST["overview"];  } else { $overview = ""; }
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
		
		
              <form name="cbform1" method="post" action="theatresurgeriesreport.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Surgeries Report </strong></td>
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
              <td  colspan="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">Doctor Name</strong></td>
			  <td  colspan="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">Count</strong></td>
			  <td  colspan="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">Type of Surgery</strong></td>
			  <td  colspan="" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">Action</strong></td>
            </tr>
			
			
			 <?php
			 $querycr1in = " SELECT a.auto_number,a.category,b.surgeon_id,count(b.surgeon_id) as count FROM `master_theatre_booking` as a join `theatre_booking_surgeons` as b on b.booking_id=a.auto_number WHERE date(a.starttime) BETWEEN '$ADate1' AND '$ADate2' and a.starttime <>'0000-00-00 00:00:00' group by b.surgeon_id,a.category";	
			 $execcr1 = mysqli_query($GLOBALS["___mysqli_ston"], $querycr1in) or die ("Error in querycr1in".mysqli_error($GLOBALS["___mysqli_ston"]));
			 $rows = mysqli_num_rows($execcr1);
			 while($res = mysqli_fetch_array($execcr1))
			 {
			 $bookingid = $res['auto_number'];
			 $category=$res['category'];
			 $surgeon_id=$res['surgeon_id'];
			 $count=$res['count'];
			 
			 
			  $query_t = "SELECT * FROM master_doctor WHERE doctorcode= '$surgeon_id'";
			  $exec_t = mysqli_query($GLOBALS["___mysqli_ston"], $query_t) or die ("Error in Query_s".mysqli_error($GLOBALS["___mysqli_ston"]));
			  $res_t = mysqli_fetch_assoc($exec_t);  
			  $newdoctorname=$res_t['doctorname'];
			  
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
              <td width=""  align="left" valign="center"  class="bodytext31"><?php echo $newdoctorname; ?></td>
			  <td width="" align="left" valign="center"   class="bodytext31"><?php echo $count; ?></td>
			  <td width=""  align="left" valign="center"   class="bodytext31"><?php echo strtoupper($category); ?></td>
			  <td width="" align="left" valign="center"   class="bodytext31"><span class="bodytext3"><a target="_blank" href="theatresurgeriesview_report.php?surgeon_id=<?php echo $surgeon_id; ?>&&cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>">VIEW</a> </span> </td>
			 
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


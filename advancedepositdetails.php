<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');

$docno = $_SESSION['docno'];

  
   $query1 = "select * from login_locationdetails where username='$username'  group by locationcode order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1=mysqli_fetch_array($exec1);
					 	$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
			
$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
$patient=isset($_REQUEST['patient'])?$_REQUEST['patient']:'';
$patientcode=isset($_REQUEST['patientcode'])?$_REQUEST['patientcode']:'';
$visitcode=isset($_REQUEST['visitcode'])?$_REQUEST['visitcode']:'';
$ADate1=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:'';
$ADate2=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:'';

$docnumber=isset($_REQUEST['docno1'])?$_REQUEST['docno1']:'';
 $refundstatus=isset($_REQUEST['refundstatus'])?$_REQUEST['refundstatus']:'';
if($refundstatus==1)
{
	//mysql_query("update master_transactionadvancedeposit set refundstatus='process' where patientcode='$patientcode' and visitcode='$visitcode' and docno='$docnumber'");

  mysqli_query($GLOBALS["___mysqli_ston"], "update master_transactionadvancedeposit set refundstatus='process' where patientcode='$patientcode'");
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
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<link href="js/jquery-ui.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery-1.11.1.js"></script>
<script type="text/javascript">
  
  function refundConfirmation(patientcode){
    var result = confirm("Are you sure to Refund?");
    if(result){
        // Delete logic goes here
        //alert('yes refund');
        console.log('yes refund')
        var reason_refund = $('#'+patientcode).val();
        reason_refund = $.trim(reason_refund);

    $.ajax({
      url: 'ajax/refundremarks.php',
      type: 'POST',
      //async: false,
      dataType: 'json',
      //processData: false,    
      data: { 
          patientcode: patientcode,
          reasonrefund:reason_refund
      },
      success: function (data) { 
        //alert(data)
        console.log(data.msg);
      }
    });
    return true;
    }
    else
      return false;
}
</script>
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
        <td width="800" rowspan="9"><form name="cbform1" method="post" action="advancedepositdetails.php">
          <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
		  <!--<tr bgcolor="red">
              <td colspan="4" bgcolor="red" class="bodytext3"><strong> PLEASE REFRESH PAGE BEFORE MAKING BILL </strong></td>
              </tr>-->
            <tr bgcolor="#011E6A">
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong> Advance Deposit Details</strong></td>
              <td colspan="1" bgcolor="#ecf0f5" class="bodytext3" id="location"><strong> Location </strong>&nbsp;
             
            
                  <?php
						echo $res1location;
					
						?>
						
                  
                  </td>
     
              </tr>
             <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
               <select name="location" id="location" onChange="ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
                  <?php
						
						 $query1 = "select * from login_locationdetails where username='$username' group by locationcode order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						$locationcode2=$reslocationanum;
						?>
						<option value="<?php echo $res1locationanum; ?>" <?php if($res1location!='')if($res1location==$res1locationanum){echo "selected";}?>><?php echo $res1location; ?></option>
						<?php
						}
						?>
                  </select>
            </span></td>
              </tr>
			    <tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patient" type="text" id="patient" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			    <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Registration No</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patientcode" type="text" id="patient" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			   <!-- <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="visitcode" type="text" id="visitcode" value="" size="50" autocomplete="off">
              </span></td>
              </tr> -->
			  <tr>
          <td width="136" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="131" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="76" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="425" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
        <td width="481" class="bodytext3" style="font-size: 14px">&nbsp;</td>
      </tr>
      <tr>
        <td class="bodytext3" style="font-size: 14px"><span class="bodytext32" style="font-size: 14px"><strong>&nbsp;</strong></span></td>
      </tr>
     <!-- <tr>
        <td class="bodytext3" style="font-size: 14px"><span class="bodytext32" style="font-size: 14px"><strong><a href="billing_pending_op2.php" target="_blank" style="text-decoration:none;">Credit Patient Billing</a></strong></span></td>
      </tr>-->
      <tr>
         <td class="bodytext3" style="font-size: 14px"><span class="bodytext32" style="font-size: 14px"><strong>&nbsp;</strong></span></td>
      </tr>
      <tr>
        <td><span class="bodytext32" style="font-size: 14px"><strong>&nbsp;</strong></span></td>
      </tr>
      <tr>
         <td><span class="bodytext32" style="font-size: 14px"><strong>&nbsp;</strong></span></td>
      </tr>
      <tr>
        <td><span class="bodytext32" style="font-size: 14px"><strong>&nbsp;</strong></span></td>
      </tr>
      <tr>
     
      <tr>
        <td><span class="bodytext32" style="font-size: 14px"><strong>&nbsp;</strong></span></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="2">
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
	
	?>
    <table width="60%" align="left" border="0" cellspacing="0" cellpadding="2">
    <tr>
    <td width="5%" class="bodytext32" bgcolor="#ecf0f5"><strong>S.no</strong></td>
    <!-- <td width="8%" class="bodytext32" bgcolor="#ecf0f5"><strong>Date</strong></td> -->
     <!-- <td width="10%" class="bodytext32" bgcolor="#ecf0f5"><strong>Doc no</strong></td> -->
    <td width="15%" class="bodytext32" bgcolor="#ecf0f5"><strong>Patient code</strong></td>
   <!-- <td width="14%" class="bodytext32" bgcolor="#ecf0f5"><strong>Visit code</strong></td>-->
     <td width="20%" class="bodytext32" bgcolor="#ecf0f5"><strong>Patient name</strong></td>
    <td width="14%" class="bodytext32" bgcolor="#ecf0f5"><strong>Amount</strong></td>
    <td width="14%" class="bodytext32" bgcolor="#ecf0f5"><strong>Bal Amt</strong></td>
    <td width="14%" class="bodytext32" bgcolor="#ecf0f5"><strong>Remarks</strong></td>
    <td width="14%" class="bodytext32" bgcolor="#ecf0f5"><strong>Action</strong></td>
    </tr>
    
    <?php
	$sno1='';
	$colorloopcount='';
	$showcolor='';
 //$detailquery="select patientname,patientcode,visitcode,docno,transactionamount,transactiondate from master_transactionadvancedeposit where patientname like '%$patient%' and patientcode like '%$patientcode%' and visitcode like '%$visitcode%' and transactiondate between '$ADate1' and '$ADate2' and recordstatus='' and refundstatus not in('process','completed') order by auto_number desc";

 $detailquery="select patientname,patientcode,sum(transactionamount) amt from master_transactionadvancedeposit where patientname like '%$patient%' and patientcode like '%$patientcode%' and transactiondate between '$ADate1' and '$ADate2' and recordstatus='' and refundstatus not in('process','completed') group by patientcode order by auto_number desc";

$exedetail=mysqli_query($GLOBALS["___mysqli_ston"], $detailquery)or die("Error in detailquery".mysqli_error($GLOBALS["___mysqli_ston"]));
$numrow=mysqli_num_rows($exedetail);
if($numrow >0)
{
while($resquery=mysqli_fetch_array($exedetail))
{
	$patientname=$resquery['patientname'];
	$patientcode=$resquery['patientcode'];
	//$visitcode=$resquery['visitcode'];
	//$docnum=$resquery['docno'];
	//$transactionamount=$resquery['transactionamount'];
  $transactionamount=$resquery['amt'];
	//$transactiondate=$resquery['transactiondate'];

  $query43 = "select sum(transactionamount) amt from master_transactionadvancedeposit where patientcode='$patientcode' group by patientcode";
        $exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
        $num43 = mysqli_num_rows($exec43);
        $res43 = mysqli_fetch_array($exec43);
        $deposit_totalamt = $res43['amt'];
        $deposit_bal_amt = $deposit_totalamt;
        $all_adjust_amt = 0;
        $all_refund_amt = 0;

  //$deposit_amt_bal_query = "SELECT balamt FROM `adjust_advdeposits` WHERE `patientcode` = '$patientcode' order by id desc limit 1";
  $deposit_amt_bal_query = "SELECT sum(adjustamount) usedamt FROM `adjust_advdeposits` WHERE `patientcode` = '$patientcode'";
  $bal_exec = mysqli_query($GLOBALS["___mysqli_ston"], $deposit_amt_bal_query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   if(mysqli_num_rows($bal_exec) > 0)
   {
       $bal_res = mysqli_fetch_array($bal_exec);
       $all_adjust_amt = $bal_res['usedamt']; 
       //$deposit_bal_amt = $deposit_totalamt - $all_adjust_amt;
       //$deposit_bal_amt = $bal_res['balamt']; 
   }

    $refund_amt_bal_query = "SELECT sum(amount) as refundamt from deposit_refund where patientcode = '$patientcode' and visitcode not in(select visitcode from adjust_advdeposits where patientcode='$patientcode')";
    $refund_bal_exec = mysqli_query($GLOBALS["___mysqli_ston"], $refund_amt_bal_query) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    if(mysqli_num_rows($refund_bal_exec) > 0)
    {
     $refund_bal_res = mysqli_fetch_array($refund_bal_exec);
     $all_refund_amt = $refund_bal_res['refundamt']; 

    }

    $deposit_bal_amt = ($deposit_totalamt - ($all_adjust_amt + $all_refund_amt) );
	$sno1=$sno1+1;
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
        $docnum = "";
?>
<tr <?php echo $colorcode; ?>>
<td class="bodytext32"><?=$sno1;?></td>
<!-- <td class="bodytext32"><?= $transactiondate;?></td> -->
<!-- <td class="bodytext32"><?= $docnum;?></td> -->
<td class="bodytext32"><?= $patientcode;?></td>
<!--<td class="bodytext32"><?= $visitcode;?></td>-->
<td class="bodytext32"><?= $patientname;?></td>
<td class="bodytext32"><?= number_format($transactionamount,'2','.',',');?></td>
<td class="bodytext32"><?php echo number_format($deposit_bal_amt,'2','.',','); ?></td>
<td class="bodytext32"><textarea id="<?php echo $patientcode;?>"  name="refund_reason[]" ></textarea></td>
<td class="bodytext32"><a href="advancedepositdetails.php?patientcode=<?=$patientcode?>&&refundstatus=1" onclick=" return refundConfirmation('<?php echo $patientcode; ?>')">Refund</a></td>
</tr>
		 <?php
}}}
		 ?>		
	 
   </table>
   </td>
      </tr>
	  </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>


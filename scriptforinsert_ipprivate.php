<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date("Y-m-d",strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
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
padding-left:650px;
text-align:right;
font-weight:bold;
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>
<script type="text/javascript">


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
    <td width="99%" valign="top">
	<table width="105%" border="0" cellspacing="0" cellpadding="0">
	      
		  <tr>
        <td width="860">
              <form name="cbform1" method="post" action="">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
				
			  
                 	
				
			<tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Update" name="Submit" /></td>
                    </tr>
                  </tbody>
                </table>
              </form>		</td>
      </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
    <?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
	?>
  <tr>
   
    <td width="99%" valign="top">
	<table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1075" 
            align="left" border="0">
          <tbody>
            
		
			<?php
			$sno = '';
			$showcolor='';
			$colorloopcount = '';
	
	
		?>
	
			
          
             <?php
			///paylater.
			 $query21 = "select billnumber,patientcode,patientvisitcode,id from (
			select billnumber,patientcode,patientvisitcode,'ref_con' as id from refund_paylaterconsultation 
			UNION 
			select billnumber,patientcode,patientvisitcode,'ref_payre' as id from refund_paylaterreferal ) t order by patientvisitcode
			";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res21=mysqli_fetch_array($exec21))
			{
			$billnumber=$res21['billnumber'];
			$patientcode=$res21['patientcode'];
			$patientvisitcode=$res21['patientvisitcode'];
			$resid=$res21['id'];
			
			
				if($resid=='ref_con'){
					$sharingamount=0;
			 	
				$query2312= "select billno as  billnumber,visitcode  from billing_paylaterconsultation where visitcode = '$patientvisitcode' and patientcode='$patientcode'";
				$exec2312 = mysqli_query($GLOBALS["___mysqli_ston"], $query2312) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$rows2312 = mysqli_num_rows($exec2312);
				$res2312 = mysqli_fetch_array($exec2312);
				$res2312billnumber=$res2312['billnumber'];
				$res2312patientvisitcode=$res2312['visitcode'];
				
				
				$query211 = "select * from billing_ipprivatedoctor_refund where    against_refbill = '$res2312billnumber' and docno='$billnumber'";
			$exec211 = mysqli_query($GLOBALS["___mysqli_ston"], $query211) or die ("Error in Query211".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rows211 = mysqli_num_rows($exec211);
			if($rows211==0){
			$res211=mysqli_fetch_array($exec211);
				
				
				$query11 = "select * from refund_paylaterconsultation where    against_refbill = '$res2312billnumber'  ";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11=mysqli_fetch_array($exec11);
			$against_refbill1 = $res11['against_refbill'];
			$billnumber1 = $res11['billnumber'];
			$patientname1 = $res11['patientname'];
			$patientcode1 = $res11['patientcode'];
			$patientvisitcode1 = $res11['patientvisitcode'];
			$accountname1 = $res11['accountname'];
			$sharingamount = $res11['fxamount'];
			$billdate1 = $res11['billdate'];
			$username1 = $res11['username'];
			$locationcode1 = $res11['locationcode'];
			$locationname1 = $res11['locationname'];
			$consultation1 = $res11['fxamount'];
			//$consultation_percentage1 = $res11['referalrate'];
			
			
		$query77 = "select * from master_visitentry where visitcode='$patientvisitcode1'";
		$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res77 = mysqli_fetch_array($exec77);
		$doctor = $res77['consultingdoctor'];
		$res77doctorcode = $res77['consultingdoctorcode'];
		
		$query78 = "select * from master_doctor where doctorcode='$res77doctorcode'";
		$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res78 = mysqli_fetch_array($exec78);
		$doctorname1 = $res78['doctorname'];
		$doctorcode1 = $res78['doctorcode'];
		$consultation_percentage1 = $res78['consultation_percentage'];
		
		
		$sharingamount1 = ($sharingamount*$consultation_percentage1)/100; 
			
			
			
			
		$querycoa = "select ledger_id from finance_ledger_mapping where auto_number = '6'";
		$execcoa = mysqli_query($GLOBALS["___mysqli_ston"], $querycoa) or die("Error in Querycoa".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rescoa = mysqli_fetch_array($execcoa);
		$coa = $rescoa['ledger_id'];
			
			
				$updatepvtdr = "insert into billing_ipprivatedoctor_refund(docno, patientname, patientcode, visitcode, accountname, description, doccoa, coa, quantity, rate, amount, recordtime, recorddate, username, billstatus, doctorstatus, billtype, locationname, locationcode, transactionmode, transactionamount, cashamount, chequeamount, cardamount, onlineamount, creditamount, rateuhx, amountuhx, doctorcode, doctorname, visittype, original_amt, percentage, pvtdr_percentage, sharingamount, against_refbill) 
				values
				('$billnumber1', '$patientname1', '$patientcode1', '$patientvisitcode1', '$accountname1', '$doctorname1', '$doctorcode1', '$coa', '1', '$sharingamount1', '$sharingamount1', '', '', '$username1', 'paid', 'unpaid', 'PAY LATER', '$locationname1', '$locationcode1', 'CASH', '$sharingamount1', '$consultation1', '0', '0', '0', '0', '$sharingamount1', '$sharingamount1', '$doctorcode1', '$doctorname1', 'OP', '$consultation1', '$consultation_percentage1', '', '$sharingamount1','$against_refbill1')";
				$execupdate = mysqli_query($GLOBALS["___mysqli_ston"], $updatepvtdr) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				
					}
				}
				else {
					$sharingamount1=0;
			
				$query2312= "select billnumber,patientvisitcode  from billing_paylaterreferal where patientvisitcode = '$patientvisitcode' and patientcode='$patientcode'";
				$exec2312 = mysqli_query($GLOBALS["___mysqli_ston"], $query2312) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$rows2312 = mysqli_num_rows($exec2312);
				$res2312 = mysqli_fetch_array($exec2312);
				$res2312billnumber=$res2312['billnumber'];
				$res2312patientvisitcode=$res2312['patientvisitcode'];
				
			$query211 = "select * from billing_ipprivatedoctor_refund where    against_refbill = '$res2312billnumber' and docno='$billnumber' ";
			$exec211 = mysqli_query($GLOBALS["___mysqli_ston"], $query211) or die ("Error in Query211".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rows211 = mysqli_num_rows($exec211);
			if($rows211==0){
			$res211=mysqli_fetch_array($exec211);	
				
				
				$query11 = "select * from refund_paylaterreferal where    against_refbill = '$res2312billnumber'  ";
			$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res11=mysqli_fetch_array($exec11);
			$against_refbill1 = $res11['against_refbill'];
			$billnumber1 = $res11['billnumber'];
			$patientname1 = $res11['patientname'];
			$patientcode1 = $res11['patientcode'];
			$patientvisitcode1 = $res11['patientvisitcode'];
			$accountname1 = $res11['accountname'];
			$sharingamount = $res11['referalrate'];
			$billdate1 = $res11['billdate'];
			$username1 = $res11['username'];
			$locationcode1 = $res11['locationcode'];
			$locationname1 = $res11['locationname'];
			$consultation1 = $res11['referalrate'];
			$doctorname1 = $res11['referalname'];
			$doctorcode1 = $res11['referalcode'];
			//$consultation_percentage1 = $res11['referalrate'];
			
			
		
		$query78 = "select * from master_doctor where doctorcode='$doctorcode1'";
		$exec78 = mysqli_query($GLOBALS["___mysqli_ston"], $query78) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		$res78 = mysqli_fetch_array($exec78);
		$consultation_percentage1 = $res78['consultation_percentage'];
		
		
		$sharingamount1 = ($sharingamount*$consultation_percentage1)/100; 
			
			
			
			
		$querycoa = "select ledger_id from finance_ledger_mapping where auto_number = '6'";
		$execcoa = mysqli_query($GLOBALS["___mysqli_ston"], $querycoa) or die("Error in Querycoa".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rescoa = mysqli_fetch_array($execcoa);
		$coa = $rescoa['ledger_id'];
			
			
				$updatepvtdr = "insert into billing_ipprivatedoctor_refund(docno, patientname, patientcode, visitcode, accountname, description, doccoa, coa, quantity, rate, amount, recordtime, recorddate, username, billstatus, doctorstatus, billtype, locationname, locationcode, transactionmode, transactionamount, cashamount, chequeamount, cardamount, onlineamount, creditamount, rateuhx, amountuhx, doctorcode, doctorname, visittype, original_amt, percentage, pvtdr_percentage, sharingamount, against_refbill) 
				values
				('$billnumber1', '$patientname1', '$patientcode1', '$patientvisitcode1', '$accountname1', '$doctorname1', '$doctorcode1', '$coa', '1', '$sharingamount1', '$sharingamount1', '', '', '$username1', 'paid', 'unpaid', 'PAY LATER', '$locationname1', '$locationcode1', 'CASH', '$sharingamount1', '$consultation1', '0', '0', '0', '0', '$sharingamount1', '$sharingamount1', '$doctorcode1', '$doctorname1', 'OP', '$consultation1', '$consultation_percentage1', '', '$sharingamount1','$against_refbill1')";
				$execupdate = mysqli_query($GLOBALS["___mysqli_ston"], $updatepvtdr) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				
				
				
				}
			}
			}
	
			echo "paylater sucess";
			?>
			
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


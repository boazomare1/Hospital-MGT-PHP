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
			///paynow.
			$query21 = "select billnumber,patientcode,patientvisitcode,id from (
			select billnumber,patientcode,patientvisitcode,'ref_con' as id from refund_consultation 
			UNION 
			select billnumber,patientcode,patientvisitcode,'ref_payre' as id from refund_paynowreferal ) t order by patientvisitcode
			";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res21=mysqli_fetch_array($exec21))
			{
			$billnumber=$res21['billnumber'];
			$patientcode=$res21['patientcode'];
			$patientvisitcode=$res21['patientvisitcode'];
			$resid=$res21['id'];
			
			
				if($resid=='ref_con'){
					$query2312= "select billnumber,patientvisitcode  from billing_consultation where patientvisitcode = '$patientvisitcode' and patientcode='$patientcode'";
				$exec2312 = mysqli_query($GLOBALS["___mysqli_ston"], $query2312) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$rows2312 = mysqli_num_rows($exec2312);
				$res2312 = mysqli_fetch_array($exec2312);
				$res2312billnumber=$res2312['billnumber'];
				$res2312patientvisitcode=$res2312['patientvisitcode'];
					
				
			  	$query591 = "update refund_consultation set against_refbill='$res2312billnumber' where patientvisitcode='$res2312patientvisitcode' and against_refbill=''";
				$exec591 = mysqli_query($GLOBALS["___mysqli_ston"], $query591) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				
			
			  	$query59 = "update billing_ipprivatedoctor_refund set against_refbill='$res2312billnumber' where visitcode='$res2312patientvisitcode' and docno='$billnumber'";
				$exec59= mysqli_query($GLOBALS["___mysqli_ston"], $query59) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				
				
				} 
				else {
					
					$query2312= "select billnumber,patientvisitcode  from billing_paynowreferal where patientvisitcode = '$patientvisitcode' and patientcode='$patientcode'";
				$exec2312 = mysqli_query($GLOBALS["___mysqli_ston"], $query2312) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$rows2312 = mysqli_num_rows($exec2312);
				$res2312 = mysqli_fetch_array($exec2312);
				$res2312billnumber12=$res2312['billnumber'];
				$res2312patientvisitcode12=$res2312['patientvisitcode'];
					
				
			 	$query591 = "update refund_paynowreferal set against_refbill='$res2312billnumber12' where patientvisitcode='$res2312patientvisitcode12' and against_refbill=''";
				$exec591 = mysqli_query($GLOBALS["___mysqli_ston"], $query591) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				
			
				
				 	$query59 = "update billing_ipprivatedoctor_refund set against_refbill='$res2312billnumber12' where visitcode='$res2312patientvisitcode12' and docno='$billnumber'";
				$exec59 = mysqli_query($GLOBALS["___mysqli_ston"], $query59) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				
			
			
				
				}
			}
		
	
			echo "paynow sucess";
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
					
					$query2312= "select billno as  billnumber,visitcode  from billing_paylaterconsultation where visitcode = '$patientvisitcode' and patientcode='$patientcode'";
				$exec2312 = mysqli_query($GLOBALS["___mysqli_ston"], $query2312) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$rows2312 = mysqli_num_rows($exec2312);
				$res2312 = mysqli_fetch_array($exec2312);
				$res2312billnumber=$res2312['billnumber'];
				$res2312patientvisitcode=$res2312['visitcode'];
					
					$sharingamount=0;
			 	$query591 = "update refund_paylaterconsultation set against_refbill='$res2312billnumber' where patientvisitcode='$res2312patientvisitcode' and against_refbill=''";
				$exec591 = mysqli_query($GLOBALS["___mysqli_ston"], $query591) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				
				
				
				
				}
				else {
					
					$query2312= "select billnumber,patientvisitcode  from billing_paylaterreferal where patientvisitcode = '$patientvisitcode' and patientcode='$patientcode'";
				$exec2312 = mysqli_query($GLOBALS["___mysqli_ston"], $query2312) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$rows2312 = mysqli_num_rows($exec2312);
				$res2312 = mysqli_fetch_array($exec2312);
				$res2312billnumber=$res2312['billnumber'];
				$res2312patientvisitcode=$res2312['patientvisitcode'];
					
					
					$sharingamount1=0;
				$query591 = "update refund_paylaterreferal set against_refbill='$res2312billnumber' where patientvisitcode='$res2312patientvisitcode' and against_refbill=''";
				$exec591 = mysqli_query($GLOBALS["___mysqli_ston"], $query591) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				
				
				
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


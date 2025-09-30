<?php
session_start();
//echo session_id();
include ("db/db_connect.php");
include ("includes/loginverify.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username=$_SESSION["username"];
$registrationdate = date('Y-m-d');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$docno = $_SESSION['docno'];
$todaydate=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date("Y-m-d");
$fromdate=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date("Y-m-d");
$todate=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:date("Y-m-d");
$time=strtotime($todaydate);
$month=date("m",$time);
$year=date("Y",$time);
 
$thismonth=$year."-".$month."___";

//get location for sort by location purpose
$location=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
if($location!='')
{
	  $locationcode=$location;
	}
?>

<?php
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
    for ($i=1; $i <= 30; $i++) { 
    	//echo $i;
    	$ledger_id = $_REQUEST['ledger_id'.$i];
    	$ledger_name = $_REQUEST['ledger_name'.$i];
    	$acc_id = $_REQUEST['account_id'.$i];

    	//echo 'account_id'.$acc_id.'<br>';
   

    	$date = date('Y-m-d H:i:s');
    	

    	
		$query_finance_check = "SELECT * FROM finance_ledger_mapping WHERE map_anum = '$acc_id'";
		//echo $query_finance_check.'<br>';
		
		$exec_finance_check = mysqli_query($GLOBALS["___mysqli_ston"], $query_finance_check) or die ("Error in query_finance_check".mysqli_error($GLOBALS["___mysqli_ston"]));
		$check_rows = mysqli_num_rows($exec_finance_check);
		if($check_rows > 0){
			// record exists

			$query_update = "UPDATE finance_ledger_mapping SET ledger_id='$ledger_id', ledger_name='$ledger_name', financetype='', user_id='$username', ip_address='$ipaddress', location_code='$locationcode' WHERE map_anum='$acc_id'";
			$exec_update = mysqli_query($GLOBALS["___mysqli_ston"], $query_update) or die ("Error in query_update".mysqli_error($GLOBALS["___mysqli_ston"]));

			$bgcolorcode = 'Success';	
		    $errmsg = "Record Updated!";

		    header("Location: financemapping.php?st=success");	
		} else {
			// record not exists
			$query_insert = "INSERT INTO `finance_ledger_mapping`(`map_anum`, `financetype`, `ledger_id`, `ledger_name`, `created_at`, `updated_at`, `record_status`, `user_id`, `ip_address`, `location_code`) VALUES ($acc_id,'','$ledger_id','$ledger_name','$date','','','$username','$ipaddress','$locationcode')";
			$exec_insert = mysqli_query($GLOBALS["___mysqli_ston"], $query_insert) or die ("Error in query_insert".mysqli_error($GLOBALS["___mysqli_ston"]));

			$bgcolorcode = 'Success';	
		    $errmsg = "Record Created!";
		}
    }

}
?>
<?php
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'success')
{
		$errmsg = "Success. Record Created.";
		if (isset($_REQUEST["cpynum"])) { $cpynum = $_REQUEST["cpynum"]; } else { $cpynum = ""; }
		if ($cpynum == 1) //for first company.
		{
			$errmsg = "Success. New Re Created.";
		}
}
else if ($st == 'failed')
{
		$errmsg = "Failed. Please try again.";
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
#position
{
position: absolute;
    left: 830px;
    top: 420;
}
-->
</style>


<style>
.hideClass
{display:none;}
</style>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">

<script language="javascript">

function process1()
{   
	/*$arr = 5;
	for (var i = 1; i < arr; i++) {
		if (document.form1.ledger_name+i.value == "")
		{
			alert ("Please select all ledgers.");
			document.form1.ledger_name+i.focus();
			return false;
		}
		console.log(i);
	}*/
}



</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}

-->
</style>
</head>

<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>

  <tr>
    <td width="2%">&nbsp;</td>
   
    <td colspan="5" valign="top">
<table width="116%" border="0" cellspacing="0" cellpadding="0">

		<tr>
		<td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
          	<tr bgcolor="#011E6A">
              <td colspan="8" bgcolor="#ecf0f5" class="bodytext3"><strong> Finance Mapping </strong></td>
              <td colspan="6" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
                  <?php
						
					if ($location!='')
						{
						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res12 = mysqli_fetch_array($exec12);
						
						echo $res1location = $res12["locationname"];
						//echo $location;
						}
						else
						{
						$query1 = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						     $res1locationanum = $res1["locationcode"];
						}
						?>
						
                  
                  </td>
     
              </tr>
            
            <form name="form1" action="financemapping.php" onSubmit="return process1()">
            <!-- finance mapping -->
            <tr>
            	<td>
            		<input type="hidden" name="locationcode" id="locationcode" value="<?php echo $res1locationanum;?>">
            	</td>
            </tr>
            <?php
              //$name_arr = array('1'=>'Cash Sales','2'=>'Transport Income','3'=>'MPESA Account','4'=>'Output Vat','5'=>'Inventory','6'=>'Input Vat','7'=>'Cost of goods sold','8'=>'With Holding Tax','9'=>'Petty Cash Disburse Account','10'=>'Purchase Suspense Account','11'=>'Discount Ledger','12'=>'Promotion Ledger','13'=>'Distribution Rebate','14'=>'Purchase Bonus','15'=>'Rounding Difference','16'=>'FGW Staging','17'=>'Internal Damages Destructions','18'=>'Production W/OFF Ledger','19'=>'SF Production Variance','20'=>'WIP Production Variance','21'=>'Inventory Cost Adj');
              $name_arr = array('1'=>'Cash Sales','2'=>'Cheque Collection','3'=>'Online Collection', '4'=>'Card Collection','5'=>'Mpesa Collection','6'=>'Consultation Bill','7'=>'Lab Discount','8'=>'Service Discount','9'=>'Radiology Discount','10'=>'Pharmacy Discount','11'=>'Patient Deposits','12'=> 'IP Bed Charges', '13' => 'IP Admission Charge',  '14'=>'IP MISC Billing', '15'=>'IP Discount', '16'=>'Purchase Control','17'=>'Input VAT', '18'=>'Inventory Adjustment', '19' => 'Withholding Tax', '20' => 'NHIF REBATE', '21' => 'Ambulance', '22' => 'Hospital Revenue', '23' => 'Debtor Discount', '24' => 'Bank Charges', '25' => 'Nursing Charges', '26' => 'Branch GIT Control', '27' => 'Patient Refunds', '28' => 'Doctor Fee Costs', '29' => 'Consultation Fee Costs');

              $length=sizeof($name_arr); 
              for($i=1;$i<=$length;$i++){ 
              	// select ledger from db
              	$query_acc = "SELECT * FROM finance_ledger_mapping WHERE map_anum = '$i' AND record_status <> 'deleted'";
              	//echo $query_acc;
              	$exec_acc = mysqli_query($GLOBALS["___mysqli_ston"], $query_acc) or die ("Error in Query_acc".mysqli_error($GLOBALS["___mysqli_ston"]));
              	$ledgername = '';
              	while ($res_acc = mysqli_fetch_array($exec_acc))
				{
					$map_anum = $res_acc['map_anum'];
					$ledgercode = $res_acc['ledger_id'];
					$ledgername = $res_acc['ledger_name'];
					//echo $map_anum.'<br>';
					//echo $ledgercode.'<br>';
				}
            ?>  
              <tr>
              	<td class="bodytext3"><label><?php echo $name_arr[$i];?></label></td>
            	<td class="bodytext3">
            		<input type="text" id="ledger_name<?php echo $i;?>" name="ledger_name<?php echo $i;?>" value="<?php if($ledgername != ''){echo $ledgername;} ?>" onkeypress="return auto(this.id)" autocomplete="off">
            		<input  id="ledger_id<?php echo $i;?>" name="ledger_id<?php echo $i;?>" value="<?php if ($ledgercode != ''){echo $ledgercode;} ?>" type="text" value="" >
            		<input  id="account_id<?php echo $i;?>" name="account_id<?php echo $i;?>"  type="hidden" value="<?php echo $i;?>" >
                    <input  id="finance<?php echo $i;?>" name="finance<?php echo $i;?>"  type="hidden" value="<?php echo $name_arr[$i];?>" >
            	</td>
              </tr>
             <?php } ?>
            

            <tr>
            	<td>&nbsp;</td>
            	<td>&nbsp;</td>
            	<td colspan="4" align="left" style="padding-right:20px;">
            		<input type="hidden" name="frmflag1" value="frmflag1" />
            		<input type="submit" value="Save" name="submit" id="submit">
            	</td>
            </tr>
           </form>
            <tr>
             	<td colspan="12" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ecf0f5" class="bodytext311">&nbsp;</td><td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            
             	<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            </tr>
          </tbody>
        </table>		</td>
		</tr>
		
		</table>		</td>
		</tr>
	
      <tr>
        <td>&nbsp;</td>
      </tr>
	    <tr >
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				    <table id="presid" width="767" border="0" cellspacing="1" cellpadding="1">
                     <!--
					 <tr>
                     <td class="bodytext3">Priliminary Diseases</td>
				   <td width="423"> <input name="dis2[]" id="dis2" type="text" size="69" autocomplete="off"></td>
                   </tr> -->
                     					
				      </table>
				  </td>
		        </tr>
				<tr>
        <td>&nbsp;</td>
        </tr>  
	  <tr>
        <td>&nbsp;</td>
		 <td>&nbsp;</td>
		  <td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
                 
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>


<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>


<script type="text/javascript">
/*$(function() {

    $('#saccountname').autocomplete({
		
	source:'accountnameajax.php', 
	
	minLength:2,
	delay: 0,
	html: true, 
		select: function(event,ui){
				var saccountauto=ui.item.saccountauto;
				var saccountid=ui.item.saccountid;
				$('#saccountauto').val(saccountauto);	
				$('#saccountid').val(saccountid);	
			}
    });
	
	$('#iaccountname').autocomplete({
		
	source:'accountnameajax1.php', 
	
	minLength:2,
	delay: 0,
	html: true, 
		select: function(event,ui){
				var saccountauto=ui.item.saccountauto;
				var saccountid=ui.item.saccountid;
				$('#iaccountauto').val(saccountauto);	
				$('#iaccountid').val(saccountid);	
			}
    });
	$('#inv_accountname').autocomplete({
		
	source:'accountnameajax2.php', 
	
	minLength:2,
	delay: 0,
	html: true, 
		select: function(event,ui){
				var saccountauto=ui.item.saccountauto;
				var saccountid=ui.item.saccountid;
				$('#inv_accountauto').val(saccountauto);	
				$('#inv_accountid').val(saccountid);	
			}
    });
});*/

function auto(id)
{
	//alert('#'+id);
	var lastChar = id.replace("ledger_name", "");

		//var lastChar = id[id.length -1];
		//alert(lastChar);
    
    var el = '#'+id;
    $(el).autocomplete({    
    //source:'get_mapped_ledger_data', 
    source:'accountnamefinanceajaxall.php', 

    minLength:1,
    delay: 0,
    html: true,
	  change: function(event,ui){
	  	var account_id=ui.item.saccountid;
	  	var account_auto=ui.item.saccountauto;
        //var account_id = ui.item.account_id;
		console.log(account_id);
        $('#ledger_id'+lastChar).val(account_id);
      },
      select: function(event,ui){
        var account_id = ui.item.account_id;
        $('#ledger_id'+lastChar).val(account_id);
      },

    }); 
}
</script>

</body>
</html>


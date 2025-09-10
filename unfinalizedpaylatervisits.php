<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-7 days'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-7 days'));
$transactiondateto = date('Y-m-d');
$totallab = '0.00';
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$totalamount1 = '0.00';
$totalamount2 = '0.00';
$totalamount3 = '0.00';
$totalamount4 = '0.00';
$totalamount5 = '0.00';
$totalamount6 = '0.00';
$totalamount7 = '0.00';
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$res3labitemrate = "";
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_account2.php");
$location =isset( $_REQUEST['location'])?$_REQUEST['location']:''; 
if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchsuppliercode "])) { $searchsuppliercode  = $_REQUEST["searchsuppliercode "]; } else { $searchsuppliercode  = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d', strtotime('-7 days')); }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
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
<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="js/jquery-ui.js" type="text/javascript"></script>
<link href="js/jquery-ui.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
<link rel="stylesheet" type="text/css" href="css/style.css">
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<!--<script type="text/javascript" src="js/autocomplete_accounts2.js"></script>
<script type="text/javascript" src="js/autosuggest4accounts.js"></script>-->
<script type="text/javascript">
//window.onload = function () 
//{
	//var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
//}
</script>
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
</style>
<script>
$(document).ready(function(e) {
   
		$('#searchsuppliername').autocomplete({
		
	
	source:"ajaxaccountplan_search.php",
	//alert(source);
	matchContains: true,
	minLength:1,
	html: true, 
		select: function(event,ui){
			var accountname=ui.item.value;
			var accountid=ui.item.id;
			var accountanum=ui.item.anum;
			$("#searchsuppliercode").val(accountid);
			$("#searchsupplieranum").val(accountanum);
			
			},
    
	});
		
});

$(document).ready(function(){
$( ".saveitem" ).click(function() {
	if(confirm("Are you sure to update this Visit ?")){	
		var clickedid = $(this).attr('id');
		var idstr = clickedid.split('s_');
		var id = idstr[1];
		var autono=  $('#autono_'+id).val();
		var tablename=  $('#tablename_'+id).val();
		$.ajax({
		  url: 'ajax/ajaxopunfinalizedvisitclose.php',
		  type: 'POST',
		  //async: false,
		  dataType: 'json',
		  //processData: false,    
		  data: { 
			  autono: autono, 
			  tablename: tablename,
		  },
		  success: function (data) { 
		  	//alert(data)
		  	var msg = data.msg;
		  	if(data.status == 1)
		  	{
				$('#trid_'+id).hide();
		  	}
		  	else
		  	{
		  		alert(msg);
		  	}
		  }
		}); 
		return false;
	}
	return false;
	})	
	
	})	
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
        <td width="860">
		
		
              <form name="cbform1" method="post" action="unfinalizedpaylatervisits.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Unfinalized Paylater Visits</strong></td>
              </tr>
		   
		    <tr>
		              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Account </td>
		              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
		              <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
					  <input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" />
					   <input name="searchsupplieranum" type="hidden" id="searchsupplieranum" value="<?php echo $searchsupplieranum; ?>" size="50" autocomplete="off">
		              </span></td>
           		</tr>
		   
		  <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">From Date </td>
              <td width="32%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			  <input name="ADate1" id="ADate1" value="<?php echo $ADate1; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>	
              </span></td>
			  <td width="6%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">To Date </td>
              <td width="44%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			  <input name="ADate2" id="ADate2" value="<?php echo $ADate2; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>	
              </span></td>
           </tr>	
           
           
            <tr>
           <td width="68" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Location </strong></span></td>
          <td  colspan="3" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
           <select name="location" id="location" onChange="ajaxlocationfunction(this.value);" >
            <option value="All">All</option>
          <?php
						
						$query01="select locationcode,locationname from master_location where status ='' order by locationname";
						$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
	                    $loccode=array();
						while($res01=mysqli_fetch_array($exc01))
						{?>
							<option value="<?= $res01['locationcode'] ?>" <?php if($location==$res01['locationcode']){ echo "selected";} ?>> <?= $res01['locationname'] ?></option>		
						<?php 
						}
						?>
                      </select></span></td>
          </tr> 	
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
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
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="85%" align="left" border="0">
          <tbody>
			<tr>
				<td width="3%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td colspan="13" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311">
				<?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
				if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }
				//$cbbillnumber = $_REQUEST['cbbillnumber'];
				if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }
				//$cbbillstatus = $_REQUEST['cbbillstatus'];
				if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
				//$cbbillnumber = $_REQUEST['cbbillnumber'];
				if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
				$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				else
				{
				$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				?></span></td>  
			</tr>
			<tr >
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><strong>No.</strong></td>
				<td width="6%" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg. Date</strong></div></td>
				<td width="6%" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit No</strong></div></td>
				<td width="6%" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Reg. No </strong></td>
				<td width="10%" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Account </strong></td>
				<td width="14%" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Patient </strong></td>
				<td width="9%" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Visit Created By </strong></td>
				<td width="5%" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total </strong></div></td>
				<td width="5%" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Lab </strong></div></td>
				<td width="6%" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Service </strong></div></td>
				<td width="6%" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Pharmacy</strong></div></td>
				<td width="6%" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right"><div align="right"><strong>Radiology </strong></div></div></td>
				<td width="6%" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Consultation</strong></div></td>
				<td width="6%" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Referral </strong></div></td>
				<td width="11%" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Action </strong></div></td>
				<td><a href="unfinalizedpaylatervisits_xl.php?searchsuppliername=<?php echo $searchsuppliername;?>&&ADate1=<?php echo $ADate1;?>&&ADate2=<?php echo $ADate2;?>&&location=<?php echo $location;?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>
			</tr>
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			
			if($location=='All')
			{
			$pass_location = "locationcode !=''";
			}
			else
			{
			$pass_location = "locationcode ='$location'";
			}	
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			$query21 = "select accountfullname,scheme_id from master_visitentry where billtype='PAY LATER' and overallpayment='' and visitcode not in (select visitcode from billing_paylater) and accountfullname like '%$searchsuppliername%' and $pass_location and recordstatus='' group by accountfullname order by accountfullname desc";
			$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res21 = mysqli_fetch_array($exec21))
			{
			$res21accountname = $res21['accountfullname'];
			$scheme_id = $res21['scheme_id'];
			
			$query22 = "select * from master_planname where scheme_id = '$scheme_id' and recordstatus <>'DELETED'  ";
			$exec22 = mysqli_query($GLOBALS["___mysqli_ston"], $query22) or die ("Error in Query22".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res22 = mysqli_fetch_array($exec22);
			$res22accountname = $res22['scheme_name'];
			if($res21accountname != '')
			{
			?>
			<tr bgcolor="#ecf0f5">
            <td colspan="14"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo $res22accountname;?></strong></td>
            </tr>
			
			<?php

			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$res3labitemrate = "0.00";

			$query2 = "select patientcode,visitcode,patientfullname,consultationdate,accountfullname,username,auto_number from master_visitentry where billtype='PAY LATER' and overallpayment='' and visitcode not in (select visitcode from billing_paylater) and accountfullname = '$res21accountname' and consultationdate between '$ADate1' and '$ADate2' and $pass_location and recordstatus=''  order by accountfullname desc ";
			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2 = mysqli_fetch_array($exec2))
			{
			$res2patientcode = $res2['patientcode'];
			$res2visitcode = $res2['visitcode'];
			$res2patientfullname = $res2['patientfullname'];
			$res2registrationdate = $res2['consultationdate'];
			$res2accountname = $res2['accountfullname'];
			$res2username = $res2['username'];
			$auto_number = $res2['auto_number'];

			//$query10 = "select * from master_accountname where auto_number = '$res2accountname' group by accountname desc";
			//$exec10 = mysql_query($query10) or die ("Error in query10".mysql_error());
			//$res10 = mysql_fetch_array($exec10);
			//$res10auto_number = $res10['auto_number'];
			//$res10accountname = $res10['accountname'];

			$query3 = "select sum(labitemrate) as labitemrate1 from consultation_lab where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			$res3labitemrate = $res3['labitemrate1'];
			if ($res3labitemrate =='')
			{
			$res3labitemrate = '0.00';
			}
			else 
			{
			$res3labitemrate = $res3['labitemrate1'];
			}
			$query4 = "select sum(servicesitemrate) as servicesitemrate1 from consultation_services where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and wellnessitem <> 1";
			$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in query4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res4 = mysqli_fetch_array($exec4);
			$res4servicesitemrate = $res4['servicesitemrate1'];
			if ($res4servicesitemrate =='')
			{
			$res4servicesitemrate = '0.00';
			}
			else 
			{
			$res4servicesitemrate = $res4['servicesitemrate1'];
			}
			$query5 = "select sum(radiologyitemrate) as radiologyitemrate1 from consultation_radiology where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' ";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res5 = mysqli_fetch_array($exec5);
			$res5radiologyitemrate = $res5['radiologyitemrate1'];
			if ($res5radiologyitemrate =='')
			{
			$res5radiologyitemrate = '0.00';
			}
			else 
			{
			$res5radiologyitemrate = $res5['radiologyitemrate1'];
			}
			$query6 = "select sum(referalrate) as referalrate1 from consultation_referal where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' ";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);
			$res6referalrate = $res6['referalrate1'];
			if ($res6referalrate =='')
			{
			$res6referalrate = '0.00';
			}
			else 
			{
			$res6referalrate = $res6['referalrate1'];
			}

			$query7 = "select sum(consultationfees) as consultationfees1 from master_visitentry where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' ";
			$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in query7".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res7 = mysqli_fetch_array($exec7);
			$res7consultationfees = $res7['consultationfees1'];

			$query8 = "select sum(copayfixedamount) as copayfixedamount1 from master_billing where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' ";
			$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in query8".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res8 = mysqli_fetch_array($exec8);
			$res8copayfixedamount = $res8['copayfixedamount1'];

			$consultation = $res7consultationfees - $res8copayfixedamount;

			$query9 = "select sum(totalamount) as totalamount1 from pharmacysales_details where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' ";
			$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in query9".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res9 = mysqli_fetch_array($exec9);
			$res9pharmacyrate = $res9['totalamount1'];
			if ($res9pharmacyrate == '')
			{
			$res9pharmacyrate = '0.00';
			}
			else 
			{
			$res9pharmacyrate = $res9['totalamount1'];
			}

			$totalamount = $res3labitemrate + $res4servicesitemrate + $res5radiologyitemrate + $res6referalrate + $consultation + $res9pharmacyrate;
			$totalamount1 = $totalamount1 + $totalamount;
			$totalamount2 = $totalamount2 + $res3labitemrate;
			$totalamount3 = $totalamount3 + $res4servicesitemrate;
			$totalamount4 = $totalamount4 + $res9pharmacyrate;
			$totalamount5 = $totalamount5 + $res5radiologyitemrate;
			$totalamount6 = $totalamount6 + $consultation;
			$totalamount7 = $totalamount7 + $res6referalrate;
			$snocount = $snocount + 1;

			//echo $cashamount;
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
			<tr <?php echo $colorcode; ?> id="trid_<?php echo $snocount;?>">
				<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2registrationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2accountname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2patientfullname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div class="bodytext31"><?php echo $res2username; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalamount,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($res3labitemrate,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($res4servicesitemrate,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($res9pharmacyrate,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($res5radiologyitemrate,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($consultation,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($res6referalrate,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="right"><a  class="saveitem" id="s_<?php echo $snocount; ?>" href="" ><strong>Visit Close</strong></a></div>
				<input type="hidden" name="autono_" id="autono_<?php echo $snocount; ?>" value="<?php echo $auto_number;?>">
				<input type="hidden" name="tablename_" id="tablename_<?php echo $snocount; ?>" value="master_visitentry"></td>
			</tr>
			<?php
			}
			}
			}
			}
			?>
			<tr>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><strong>Total:</strong></td>
				<td class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount1,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount2,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount3,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount4,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount5,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount6,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($totalamount7,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="left" bgcolor="#ecf0f5">&nbsp;</td>
			</tr>
          </tbody>
        </table></td>
      </tr>
	  
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
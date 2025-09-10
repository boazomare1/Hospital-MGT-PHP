<?php
//ini_set('max_execution_time', 300); 
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$res1suppliername = '';
$total1 = '0.00';
$total2 = '0.00';
$total3 = '0.00';
$total4 = '0.00';
$total5 = '0.00';
$total6 = '0.00';
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_customer2.php");

$reportformat = "";
if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }
if (isset($_REQUEST["searchvisitcode"])) { $searchvisitcode = $_REQUEST["searchvisitcode"]; } else { $searchvisitcode = ""; }//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"];$transactiondatefrom = $_REQUEST['ADate1']; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; $transactiondateto = $_REQUEST['ADate2'];} else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if (isset($_REQUEST["visitType"])) { $visittype = $_REQUEST["visitType"]; } else { $visittype = ""; }
if (isset($_REQUEST["serviceCategory"])) { $servicecategory = $_REQUEST["serviceCategory"]; } else { $servicecategory = ""; }
if(isset($_POST['reportformat']) )
{
	$reportformat = $_POST['reportformat'];
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
<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript" src="js/autocomplete_patientstatus.js"></script>
<script type="text/javascript" src="js/autosuggestpatientstatus1.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
}
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
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
#visitType{width:148px;}
</style>
</head>



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
		
		
              <form name="cbform1" method="post" action="patientwiseservicebills.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Service Category Revenue</strong></td>
              </tr>
            <tr>
              <!--<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Patient</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off"> -->
			  <input name="searchsuppliercode" id="searchsuppliercode" value="<?php echo $searchsuppliercode; ?>" type="hidden">
			  <input name="searchvisitcode" id="searchvisitcode" value="<?php echo $searchvisitcode; ?>" type="hidden">
			  <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
              </span></td>
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
                    <?php 
                     $query1 = "select auto_number,categoryname from master_categoryservices where status <> 'deleted' order by categoryname";
					$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
					
                    ?>
            <tr>
            	<td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">Visit Type</td>
            	<td width="30%">
            		<select class="bodytext3" name="visitType" id="visitType">
            			<option value="">Select</option>
            			<option value="op" <?php if(isset($_REQUEST['visitType']) && $_REQUEST['visitType'] == 'op') echo 'selected'; ?> >OP</option>
            			<option value="ip" <?php if(isset($_REQUEST['visitType']) && $_REQUEST['visitType'] == 'ip') echo 'selected'; ?> >IP</option>
            			<option value="all" <?php if(isset($_REQUEST['visitType']) && $_REQUEST['visitType'] == 'all') echo 'selected'; ?>>ALL</option>
            		</select>
            	</td>
            </tr>
             <tr>
            	<td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">Category</td>
            	<td>
            		<select class="bodytext3" name="serviceCategory" id="serviceCategory">
            			<option value="">Select</option>
            			<?php 
            			while ($res1 = mysqli_fetch_array($exec1))
						{
							$categoryname = $res1["categoryname"];
							$auto_number = $res1["auto_number"];
							$selected = '';
							if($categoryname == $servicecategory) { $selected = 'selected';}
							echo '<option value="'.$categoryname.'" '.$selected.'>'.$categoryname.'</option>';
				   		 }
            			 ?>
            		</select>
            	</td>
            </tr> 
            <tr><td class="bodytext3">Report Type</td><td class="bodytext3"><input type="radio" name="reportformat" value="detailed" <?php if($reportformat =="detailed" || $reportformat =="") echo 'checked'; ?>>Detailed</td><td class="bodytext3"><input type="radio" name="reportformat" value="summary" <?php if($reportformat =="summary") echo 'checked'; ?>>Summary</td></tr>		
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
                  <td width="14%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="print_service_category_revenue_report.php?ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&visitType=<?php echo $visittype; ?>&&serviceCategory=<?php echo $servicecategory; ?>&&reportformat=<?php echo $reportformat; ?>"><img src="images/excel-xls-icon.png" width="30" height="30" border="0"></a></td>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="9" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311">
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
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					//$transactiondatefrom = $_REQUEST['ADate1'];
					//$transactiondateto = $_REQUEST['ADate2'];
					
					//$paymenttype = $_REQUEST['paymenttype'];
					//$billstatus = $_REQUEST['billstatus'];
					
					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				else
				{
					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				?>
 			
              <script language="javascript">
				function printbillreport1()
				{
					window.open("print_paymentgivenreport1.php?<?php echo $urlpath; ?>","Window1",'width=900,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
					//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
				}
				function printbillreport2()
				{
					window.location = "dbexcelfiles/PaymentGivenToSupplier.xls"
				}
				</script>
              <!--<input  value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />
&nbsp;				<input  value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />-->
</span></td>  
            </tr>

            <!-- NEW CODE STARTS -->
             <?php if($reportformat == "detailed" || $reportformat == "") {?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit Type </strong></div></td>
              
              <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg. No</strong></div></td>
                <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit. No</strong></div></td>

                  <td width="25%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></td>
				 <td width="25%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Insurance</strong></div></td>

                 <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
                <td width="45%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Category</strong></div></td>
                <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Service</strong></div></td>
                <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
            </tr>
            <?php }?>
            <!-- NEW CODE ENDS -->
           <!--  <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="47%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Test Name </strong></div></td>
              
              <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
            </tr> -->
			<?php
			$visitval = "OP";
			 $table = "master_visitentry";
			 if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{

				if($visittype == "op"){
					$table = "master_visitentry";
					$visitval = "OP";
				}
		  		
		  		if($visittype == "ip"){
		  			$table = "master_ipvisitentry";
		  			$visitval = "IP";
		  		}
		  		
		  		//if(($visittype == "op") || ($visittype == "ip") || $visittype == "")
          if(($visittype == "op") || ($visittype == "ip"))
		  		$query21 = "select patientcode,visitcode,patientfullname,billtype,@visittype:='$visitval' as visittype,subtype from $table where consultationdate between '$ADate1' and '$ADate2'";
		  	    elseif($visittype == "all" || $visittype == "")
		  	    $query21 = "select patientcode,visitcode,patientfullname,billtype,@visittype:='OP' as visittype,subtype from master_visitentry where consultationdate between '$ADate1' and '$ADate2' UNION select patientcode,visitcode,patientfullname,billtype,@visittype:='IP' as visittype,subtype from master_ipvisitentry where consultationdate between '$ADate1' and '$ADate2'";
		  	//echo $query21;exit;
		 		 $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while ($res21 = mysqli_fetch_array($exec21))
			  {
	     	  $res21patientfullname = $res21['patientfullname'];
			  $res21patientcode = $res21['patientcode'];
			  $res21visitcode = $res21['visitcode'];
			  $res21billtype = $res21['billtype'];
			  $visitvalue = $res21['visittype'];
			  $subtypeid = $res21['subtype'];

			  $subtypesql="SELECT subtype FROM `master_subtype` where auto_number='".$subtypeid."' ";
			  $subexec21 = mysqli_query($GLOBALS["___mysqli_ston"], $subtypesql);
			  $subres21 = mysqli_fetch_array($subexec21);
			  $subtype = $subres21['subtype'];


			  //$res21age = $res21['age'];
			  //$res21gender= $res21['gender'];
			    
			  
		  if($res21billtype == 'PAY LATER')
		  { 
		  	$table = "billing_paylaterservices";
	  		if($visittype == "op")
	  		$table = "billing_paylaterservices";
	  		if($visittype == "ip")
	  		$table = "billing_ipservices";

	  		if(($visittype == "op"))
	  		{
	  		$query31 = "select servicesitemcode,servicesitemname,fxamount as servicesitemrate,billdate from billing_paylaterservices where patientvisitcode = '$res21visitcode' and patientcode = '$res21patientcode'
			            union all
						select servicesitemcode,servicesitemname,-1*fxamount as servicesitemrate,billdate from refund_paylaterservices where patientvisitcode = '$res21visitcode' and patientcode = '$res21patientcode'
			
			";

	  		if($servicecategory !="")
		  	$query31 = "select servicesitemcode,servicesitemname,fxamount as servicesitemrate,billdate from billing_paylaterservices inner join master_services on master_services.itemcode = billing_paylaterservices.servicesitemcode where patientvisitcode = '$res21visitcode' and patientcode = '$res21patientcode' and master_services.categoryname = '$servicecategory'
			union all
			select servicesitemcode,servicesitemname,-1*fxamount as servicesitemrate,billdate from refund_paylaterservices inner join master_services on master_services.itemcode = refund_paylaterservices.servicesitemcode where patientvisitcode = '$res21visitcode' and patientcode = '$res21patientcode' and master_services.categoryname = '$servicecategory'
			";

	  	    }elseif(($visittype == "ip"))
	  		{
	  		$query31 = "select servicesitemcode,servicesitemname,servicesitemrateuhx as servicesitemrate,billdate from billing_ipservices where patientvisitcode = '$res21visitcode' and patientcode = '$res21patientcode'";

	  		if($servicecategory !="")
		  	$query31 = "select servicesitemcode,servicesitemname,servicesitemrateuhx as servicesitemrate,billdate from billing_ipservices inner join master_services on master_services.itemcode = billing_ipservices.servicesitemcode where patientvisitcode = '$res21visitcode' and patientcode = '$res21patientcode' and master_services.categoryname = '$servicecategory'";

	  	    }
	  		//echo $query31.';<br>';
	  		elseif($visittype == "all"  || $visittype == ""){
	  		$query31 = "select servicesitemcode,servicesitemname,fxamount as  servicesitemrate,billdate from billing_paylaterservices where patientvisitcode = '$res21visitcode' and patientcode = '$res21patientcode'
			            UNION all 
						select servicesitemcode,servicesitemname,servicesitemrateuhx as servicesitemrate,billdate from billing_ipservices where patientvisitcode = '$res21visitcode' and patientcode = '$res21patientcode'
						union all
						select servicesitemcode,servicesitemname,-1*fxamount as servicesitemrate,billdate from refund_paylaterservices where patientvisitcode = '$res21visitcode' and patientcode = '$res21patientcode'
						
						
						";
          if($servicecategory !="")
          {
            $query31 = "select servicesitemcode,servicesitemname,fxamount as  servicesitemrate,billdate from billing_paylaterservices inner join master_services on master_services.itemcode = billing_paylaterservices.servicesitemcode where patientvisitcode = '$res21visitcode' and patientcode = '$res21patientcode'  and master_services.categoryname = '$servicecategory' 
			UNION all select servicesitemcode,servicesitemname,servicesitemrateuhx as servicesitemrate,billdate from billing_ipservices inner join master_services on master_services.itemcode = billing_ipservices.servicesitemcode where patientvisitcode = '$res21visitcode' and patientcode = '$res21patientcode' and master_services.categoryname = '$servicecategory'
			union all
			select servicesitemcode,servicesitemname,-1*fxamount as servicesitemrate,billdate from refund_paylaterservices inner join master_services on master_services.itemcode = refund_paylaterservices.servicesitemcode where patientvisitcode = '$res21visitcode' and patientcode = '$res21patientcode' and master_services.categoryname = '$servicecategory'
			
			";
          }
        }
	  		}
		  else if($res21billtype == 'PAY NOW')
		  {
		  	$table = "billing_paynowservices";
		  	if($visittype == "op")
		  		$table = "billing_paynowservices";
		  	if($visittype == "ip")
		  		$table = "billing_ipservices";
		  	if(($visittype == "op") )
		  	{
		  		
		  		$query31 = "select servicesitemcode,servicesitemname,fxamount as servicesitemrate,billdate from billing_paynowservices where patientvisitcode = '$res21visitcode' and patientcode = '$res21patientcode'
			                 union all
						   select servicesitemcode,servicesitemname,-1*servicetotal as servicesitemrate,billdate from refund_paynowservices where patientvisitcode = '$res21visitcode' and patientcode = '$res21patientcode'
			
			";

		  		if($servicecategory !="")
		  		$query31 = "select servicesitemcode,servicesitemname,fxamount as servicesitemrate,billdate from billing_paynowservices inner join master_services on master_services.itemcode = billing_paynowservices.servicesitemcode where patientvisitcode = '$res21visitcode' and patientcode = '$res21patientcode' and master_services.categoryname = '$servicecategory'
				union all
			     select servicesitemcode,servicesitemname,-1*servicetotal as servicesitemrate,billdate from refund_paynowservices inner join master_services on master_services.itemcode = refund_paynowservices.servicesitemcode where patientvisitcode = '$res21visitcode' and patientcode = '$res21patientcode' and master_services.categoryname = '$servicecategory'
				";

		    }elseif(($visittype == "ip") )
		  	{
		  		
		  		$query31 = "select servicesitemcode,servicesitemname,servicesitemrateuhx as servicesitemrate,billdate from billing_ipservices where patientvisitcode = '$res21visitcode' and patientcode = '$res21patientcode'";

		  		if($servicecategory !="")
		  		$query31 = "select servicesitemcode,servicesitemname,servicesitemrateuhx as servicesitemrate,billdate from billing_ipservices inner join master_services on master_services.itemcode = billing_ipservices.servicesitemcode where patientvisitcode = '$res21visitcode' and patientcode = '$res21patientcode' and master_services.categoryname = '$servicecategory'";

		    }
		  
		  	elseif($visittype == "all" || $visittype == ""){
		  	$query31 = "select servicesitemcode,servicesitemname,fxamount as servicesitemrate,billdate from billing_paynowservices where patientvisitcode = '$res21visitcode' and patientcode = '$res21patientcode' 
		                UNION all select servicesitemcode,servicesitemname,servicesitemrateuhx as servicesitemrate,billdate from billing_ipservices where patientvisitcode = '$res21visitcode' and patientcode = '$res21patientcode'
						 union all
						   select servicesitemcode,servicesitemname,-1*servicetotal as servicesitemrate,billdate from refund_paynowservices where patientvisitcode = '$res21visitcode' and patientcode = '$res21patientcode'
						
						";
        if($servicecategory !="")
          $query31 = "select servicesitemcode,servicesitemname,fxamount as servicesitemrate,billdate from billing_paynowservices inner join master_services on master_services.itemcode = billing_paynowservices.servicesitemcode where patientvisitcode = '$res21visitcode' and patientcode = '$res21patientcode' and master_services.categoryname = '$servicecategory'
				UNION all
				select servicesitemcode,servicesitemname,servicesitemrateuhx as servicesitemrate,billdate from billing_ipservices inner join master_services on master_services.itemcode = billing_ipservices.servicesitemcode where patientvisitcode = '$res21visitcode' and patientcode = '$res21patientcode' and master_services.categoryname = '$servicecategory' and master_services.categoryname = '$servicecategory'
				union all
			     select servicesitemcode,servicesitemname,-1*servicetotal as servicesitemrate,billdate from refund_paynowservices inner join master_services on master_services.itemcode = refund_paynowservices.servicesitemcode where patientvisitcode = '$res21visitcode' and patientcode = '$res21patientcode' and master_services.categoryname = '$servicecategory'
				";
        }
		  }
		  $exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31". mysqli_error($GLOBALS["___mysqli_ston"]));
		  
		  /*if($res21billtype == 'PAY LATER')
		  {
		  	$table = "billing_paylaterservices";
		  	if($visittype == "op")
		  		$table = "billing_paylaterservices";
		  	if($visittype == "ip")
		  		$table = "billing_ipservices";
		  	$query44 = "select servicesitemname,servicesitemrate,billdate from $table where  patientvisitcode = '$res21visitcode'";
		  }*/
		  /*else if($res21billtype == 'PAY NOW')
		  {
		  	$table = "billing_paynowservices";
		  	if($visittype == "op")
		  		$table = "billing_paynowservices";
		  	if($visittype == "ip")
		  		$table = "billing_ipservices";
		   $query44 = "select servicesitemname,servicesitemrate,billdate from $table  where  patientvisitcode = '$res21visitcode'";
		  }
		  $exec44 =mysql_query($query44) or die(mysql_error());
		  $num44 = mysql_num_rows($exec44);
		  if($num44 !=0)
		  {
		  ?>
			  <?php
			  }*/
		  while ($res31= mysqli_fetch_array($exec31))
		  {
		  $res31servicesitemname = $res31['servicesitemname'];
		  $res31servicesitemrate = $res31['servicesitemrate'];
		  $billdate = $res31['billdate'];
		  // code 
		  $servicesItemCode = $res31['servicesitemcode'];
		  $catsql = "SELECT categoryname FROM `master_services` WHERE `itemcode`='".$servicesItemCode."'";
		  //echo $catsql;exit;
		  $catsql_ex = mysqli_query($GLOBALS["___mysqli_ston"], $catsql) or die ("Error in catsql". mysqli_error($GLOBALS["___mysqli_ston"]));
		   $catrow = mysqli_num_rows($catsql_ex);
		   $categoryname = "-";
		  if($catrow > 0)
		  {
		  	$categorynamearr = mysqli_fetch_array($catsql_ex);
		  	$categoryname = $categorynamearr['categoryname'];
		  }
		  $total = $total + $res31servicesitemrate;
		 
		  
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
			<?php if($reportformat == "detailed" || $reportformat == "") {
				//if($categoryname == $servicecategory) {
				?>
			 <tr <?php echo $colorcode; ?>>
				<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($visitvalue); ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $res21patientcode; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $res21visitcode; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res21patientfullname); ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($subtype); ?></td>

				<td class="bodytext31" valign="center"  align="left"><?php echo $billdate; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $categoryname; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $res31servicesitemname; ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($res31servicesitemrate,2,'.',','); ?></td>
           </tr>
       <?php 
       //} 
   			}?>

           
			<?php
			}
			}
			}
			
			?>

			<?php if($reportformat == "summary"){ ?>

				<tr>
					<td colspan="2" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong><?php echo $ADate1.' - '.$ADate2; ?></strong></td>
					<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong><?php if($visittype !="all") echo strtoupper($visittype); ?></strong></td>
					<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong><?php echo 'Total Amount'; ?></strong></td>
					<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($total,2,'.',','); ?></strong></td>
				</tr>

			<?php } ?> 
			<?php if($reportformat == "detailed" || $reportformat == "") {?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>

                 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
                 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td> 
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"> <strong> Total:</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($total,2,'.',','); ?></strong></td>
            </tr>
            	<?php }?>
          </tbody>
        </table></td>
      </tr>
	  
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

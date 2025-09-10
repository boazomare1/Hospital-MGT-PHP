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

if (isset($_REQUEST["visitType"])) { $visittype = $_REQUEST["visitType"]; } else { $visittype = "all"; }
if (isset($_REQUEST["serviceCategory"])) { $servicecategory = $_REQUEST["serviceCategory"]; } else { $servicecategory = ""; }
if (isset($_REQUEST["slocation"])) { $slocation = $_REQUEST["slocation"]; } else { $slocation = ""; }
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
		
		
              <form name="cbform1" method="post" action="servicecategoryrevenue.php">
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
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
                    <?php 
                     $query1 = "select auto_number,categoryname from master_categoryservices where status <> 'deleted' order by categoryname";
					$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query".mysqli_error($GLOBALS["___mysqli_ston"]));
					
                    ?>
            <tr>
            	<td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">Visit Type</td>
            	<td width="30%" bgcolor="#FFFFFF" class="bodytext31">
            		<select  name="visitType" id="visitType">
            			<option value="all" <?php if(isset($visittype) && $visittype == 'all') echo 'selected'; ?>>ALL</option>
            			<option value="op" <?php if(isset($visittype) && $visittype == 'op') echo 'selected'; ?> >OP</option>
            			<option value="ip" <?php if(isset($visittype) && $visittype == 'ip') echo 'selected'; ?> >IP</option>
            			
            		</select>
            	</td>
              <td colspan="2" class="bodytext3" width="10%" valign="middle" bgcolor="#FFFFFF" align="left"></td>
            </tr>
             <tr>
            	<td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">Category</td>
            	<td bgcolor="#FFFFFF" class="bodytext31">
            		<select  name="serviceCategory" id="serviceCategory">
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
              <td colspan="2" class="bodytext3" width="10%" valign="middle" bgcolor="#FFFFFF" align="left"></td>
            </tr> 
            <tr><td class="bodytext3" bgcolor="#FFFFFF" >Report Type</td>
              <td class="bodytext3" bgcolor="#FFFFFF" ><input type="radio" name="reportformat" value="detailed" <?php if($reportformat =="detailed" || $reportformat =="") echo 'checked'; ?>>Detailed</td><td class="bodytext3" bgcolor="#FFFFFF" ><input type="radio" name="reportformat" value="summary" <?php if($reportformat =="summary") echo 'checked'; ?>>Summary</td>
<td colspan="1" class="bodytext3" width="10%" valign="middle" bgcolor="#FFFFFF" align="left"></td>
            </tr>	
 <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location </td>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
                      <select name="slocation" id="slocation">
                      <option value="All">All</option>
                      	 <?php
						$query01="select locationcode,locationname from master_location where status ='' order by locationname";
						$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
						while($res01=mysqli_fetch_array($exc01))
						{ ?>
							<option value="<?= $res01['locationcode'] ?>" <?php if($slocation==$res01['locationcode']){ echo "selected";} ?>> <?= $res01['locationname'] ?></option>		
						<?php 
						}
						?>
                      </select>
                  <td align="left"  colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> </td>
                    </tr>			
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
                  <td width="14%" align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="print_service_category_revenue_report.php?ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&visitType=<?php echo $visittype; ?>&&serviceCategory=<?php echo $servicecategory; ?>&&reportformat=<?php echo $reportformat; ?>&&location=<?= $slocation; ?>"><img src="images/excel-xls-icon.png" width="30" height="30" border="0"></a></td>

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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="120%" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td colspan="9" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311">
              <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				
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
				?>
 				
</span></td>  
            </tr>

            
          
		<?php 
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      $visittype = $_POST['visitType'];
	  
	  	if($slocation=='All')
			{
			$pass_location = "locationcode !=''";
			}
			else
			{
			$pass_location = "locationcode ='$slocation'";
			}
             if($reportformat == "detailed" || $reportformat == "") {?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit Type </strong></div></td>
              
              <td width="" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg. No</strong></div></td>
                <td width="" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit. No</strong></div></td>

                  <td width="" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name</strong></div></td>
                 <td width="" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
                <td width="" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Category</strong></div></td>
                <td width="" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Service</strong></div></td>
				<td width="" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Provider</strong></div></td> 
				<td width="" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Scheme</strong></div></td>
				<td width="" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doctor</strong></div></td>
                <td width="" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
            </tr>
            <?php }
      $category_condition = "";
      if($servicecategory !="")
      {
        $category_condition = " AND master_services.categoryname = '$servicecategory' ";
      }

      if($visittype == "all"){

            $billing_query = "SELECT auto_number,patientcode,patientvisitcode,patientfullname,billdate,categoryname,servicesitemname,amt,visittype,servicesitemcode,subtype,accountfullname from (select billing_ipservices.auto_number,billing_ipservices.patientcode,billing_ipservices.patientvisitcode,master_ipvisitentry.patientfullname,billdate,master_services.categoryname,billing_ipservices.servicesitemname,billing_ipservices.servicesitemrate amt,@visittype:='IP' as visittype,billing_ipservices.servicesitemcode as servicesitemcode,master_ipvisitentry.subtype,master_ipvisitentry.accountfullname FROM billing_ipservices left join master_services on master_services.itemcode = billing_ipservices.servicesitemcode inner join master_ipvisitentry on master_ipvisitentry.visitcode = billing_ipservices.patientvisitcode WHERE billing_ipservices.billdate between '$ADate1' and '$ADate2' and billing_ipservices.$pass_location $category_condition 
		   UNION ALL SELECT    billing_paynowservices.auto_number,billing_paynowservices.patientcode,billing_paynowservices.patientvisitcode,master_visitentry.patientfullname,billdate,master_services.categoryname,billing_paynowservices.servicesitemname,billing_paynowservices.servicesitemrate amt,@visittype:='OP' as visittype,billing_paynowservices.servicesitemcode as servicesitemcode,master_visitentry.subtype,master_visitentry.accountfullname FROM billing_paynowservices left join master_services on master_services.itemcode = billing_paynowservices.servicesitemcode inner join master_visitentry on master_visitentry.visitcode = billing_paynowservices.patientvisitcode WHERE billing_paynowservices.billdate between '$ADate1' and '$ADate2' $category_condition  and billing_paynowservices.$pass_location
		   UNION ALL
            SELECT    billing_paylaterservices.auto_number,billing_paylaterservices.patientcode,billing_paylaterservices.patientvisitcode,master_visitentry.patientfullname,billdate,master_services.categoryname,billing_paylaterservices.servicesitemname,billing_paylaterservices.servicesitemrate amt,@visittype:='OP' as visittype,billing_paylaterservices.servicesitemcode as servicesitemcode,master_visitentry.subtype,master_visitentry.accountfullname FROM billing_paylaterservices left join master_services on master_services.itemcode = billing_paylaterservices.servicesitemcode inner join master_visitentry on master_visitentry.visitcode = billing_paylaterservices.patientvisitcode WHERE billing_paylaterservices.billdate between '$ADate1' and '$ADate2' $category_condition and billing_paylaterservices.$pass_location) as a group by  patientvisitcode,servicesitemcode";
       }
      if($visittype == "ip"){ 

        $billing_query = " SELECT auto_number,patientcode,patientvisitcode,patientfullname,billdate,categoryname,servicesitemname,amt,visittype,servicesitemcode,subtype,accountfullname from (  select billing_ipservices.auto_number,billing_ipservices.patientcode,billing_ipservices.patientvisitcode,master_ipvisitentry.patientfullname,billdate,master_services.categoryname,billing_ipservices.servicesitemname,billing_ipservices.servicesitemrate amt,@visittype:='IP' as visittype,billing_ipservices.servicesitemcode as servicesitemcode,master_ipvisitentry.subtype,master_ipvisitentry.accountfullname FROM billing_ipservices left join master_services on master_services.itemcode = billing_ipservices.servicesitemcode inner join master_ipvisitentry on master_ipvisitentry.visitcode = billing_ipservices.patientvisitcode WHERE billing_ipservices.billdate between '$ADate1' and '$ADate2' $category_condition and billing_ipservices.$pass_location) as a group by  patientvisitcode,servicesitemcode";
        
       }
       
       if($visittype == "op" ){

        $billing_query = "SELECT auto_number,patientcode,patientvisitcode,patientfullname,billdate,categoryname,servicesitemname,amt,visittype,servicesitemcode,subtype,accountfullname from (  SELECT   billing_paynowservices.auto_number,billing_paynowservices.patientcode,billing_paynowservices.patientvisitcode,master_visitentry.patientfullname,billdate,master_services.categoryname,billing_paynowservices.servicesitemname,billing_paynowservices.servicesitemrate amt,@visittype:='OP' as visittype,billing_paynowservices.servicesitemcode as servicesitemcode,master_visitentry.subtype,master_visitentry.accountfullname FROM billing_paynowservices left join master_services on master_services.itemcode = billing_paynowservices.servicesitemcode inner join master_visitentry on master_visitentry.visitcode = billing_paynowservices.patientvisitcode WHERE billing_paynowservices.billdate between '$ADate1' and '$ADate2' $category_condition and billing_paynowservices.$pass_location UNION ALL
        SELECT   billing_paylaterservices.auto_number,billing_paylaterservices.patientcode,billing_paylaterservices.patientvisitcode,master_visitentry.patientfullname,billdate,master_services.categoryname,billing_paylaterservices.servicesitemname,billing_paylaterservices.servicesitemrate amt,@visittype:='OP' as visittype,billing_paylaterservices.servicesitemcode as servicesitemcode,master_visitentry.subtype ,master_visitentry.accountfullname FROM billing_paylaterservices left join master_services on master_services.itemcode = billing_paylaterservices.servicesitemcode inner join master_visitentry on master_visitentry.visitcode = billing_paylaterservices.patientvisitcode WHERE billing_paylaterservices.billdate between '$ADate1' and '$ADate2' $category_condition and billing_paylaterservices.$pass_location) as a group by  patientvisitcode,servicesitemcode";
       }
       
       $billing_res = mysqli_query($GLOBALS["___mysqli_ston"], $billing_query) or die ("Error in billing_query". mysqli_error($GLOBALS["___mysqli_ston"]));
       $total = 0;
       $records_cnt = mysqli_num_rows($billing_res);
       $resdata = mysqli_fetch_array($billing_res);
        while ($res= mysqli_fetch_array($billing_res))
        {
			
		$patientvisitcode= $res['patientvisitcode'];
		$seritemrate=$res['amt'];
		$serviceautoid=$res['auto_number'];
		$accountfullname=$res['accountfullname'];
		$subtype=$res['subtype'];
		
		$querysubtype=mysqli_query($GLOBALS["___mysqli_ston"], "select * from master_subtype where auto_number='$subtype'");
		$execsubtype=mysqli_fetch_array($querysubtype);
		$patientsubtype1=$execsubtype['subtype'];
		
			if($res['visittype'] == "IP"){ 
			
				
			
				$query201 = "select pkg_status,package_process_id from billing_ipservices where Patientvisitcode = '$patientvisitcode'  and auto_number='$serviceautoid'  ";
				$exec201 = mysqli_query($GLOBALS["___mysqli_ston"], $query201) or die('Error in Query201'.mysqli_error($GLOBALS["___mysqli_ston"]));
				$res201 = mysqli_fetch_array($exec201);
				$pkg_status = $res201['pkg_status'];
				$package_process_id = $res201['package_process_id'];
				
				
					if($pkg_status=='NO'){
						
						$seritemrate=$res['amt'];
						$total = $total +$seritemrate;	
						
					} elseif($pkg_status=='YES' && $package_process_id==0){
						
						$query20 = "select packagecharge,package from master_ipvisitentry where visitcode = '$patientvisitcode' ";
						$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die('Error in Query20'.mysqli_error($GLOBALS["___mysqli_ston"]));
						$res20 = mysqli_fetch_array($exec20);
						$package = $res20['package'];
						$seritemrate=$packagecharge = $res20['packagecharge'];
						$total = $total + $packagecharge;
						
					} else{
						continue;
					}
				
				
				
			} else{
			
			   $total = $total +$res['amt'];
			}
			
			
			
          
        
          $snocount = $snocount + 1;

          $colorloopcount = $colorloopcount + 1;
          $showcolor = ($colorloopcount & 1); 
          if ($showcolor == 0)
          {

          $colorcode = 'bgcolor="#CBDBFA"';
          }
          else
          {

          $colorcode = 'bgcolor="#ecf0f5"';
          }
      
          ?>
          <?php if($reportformat == "detailed" || $reportformat == "") {
            //if($categoryname == $servicecategory) {
			if($res['visittype']=='OP')
			{
				$usql ="select '' as doctorname from consultation_services as c  where c.patientcode='".$res['patientcode']."' and c.patientvisitcode='".$res['patientvisitcode']."' and c.servicesitemcode='".$res['servicesitemcode']."'";

			}
			else
			{
               $usql ="select d.doctorname as doctorname from ipconsultation_services as c left join master_doctor as d on c.doctorcode=d.doctorcode where c.patientcode='".$res['patientcode']."' and c.patientvisitcode='".$res['patientvisitcode']."' and c.servicesitemcode='".$res['servicesitemcode']."'";

				
			}

			$usql_res = mysqli_query($GLOBALS["___mysqli_ston"], $usql) or die ("Error in usql". mysqli_error($GLOBALS["___mysqli_ston"]));
                $res_user= mysqli_fetch_array($usql_res);
				$username = $res_user ['doctorname'];
            ?>
             <tr <?php echo $colorcode; ?>>
                <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $res['visittype']; ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $res['patientcode']; ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $res['patientvisitcode']; ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res['patientfullname']); ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $res['billdate']; ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $res['categoryname']; ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $res['servicesitemname']; ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $patientsubtype1; ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $res['accountfullname']; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $username; ?></td>
                <td class="bodytext31" valign="center"  align="right"><?php echo number_format($seritemrate,2,'.',','); ?></td>
              </tr>
           <?php 
           //} 
            }?>


     <?php } ?> 

      <?php if($reportformat == "summary"){ 
         if($records_cnt > 0){ ?>
        <tr>
          <td width="19%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong>Date Range: &nbsp;<?php echo $ADate1.' - '.$ADate2; ?></strong></td>
          <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong><?php if($visittype !="all") echo strtoupper($visittype); ?></strong></td>
          <td width="8%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong><?php echo 'Total Amount'; ?></strong></td>
          <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($total,2,'.',','); ?></strong></td>
				 <td colspan="6" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
        </tr>

      <?php } 
      } ?> 

    <?php  if($reportformat == "detailed" || $reportformat == "") {

        if($records_cnt > 0){
        ?>
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
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"> <strong> Total:</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ecf0f5"><strong><?php echo number_format($total,2,'.',','); ?></strong></td>
            </tr>
              <?php } }

              if($records_cnt == 0){ ?>
                <tr>
              <td  colspan="9" class="bodytext31" valign="center"  align="center" 
                bgcolor="#ecf0f5">No Records Found</td>
              </tr>

              <?php }

    }?>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

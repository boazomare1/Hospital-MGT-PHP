<?php

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





$snocount = "";

$colorloopcount="";

$range = "";

$admissiondate = "";

$ipnumber = "";

$patientname = "";

$gender = "";

$admissiondoc = "";

$consultingdoc = "";

$companyname = "";

$bedno = "";

$dischargedate = "";

$wardcode = "";

$locationcode = "";



//This include updatation takes too long to load for hunge items database.

//include ("autocompletebuild_customer2.php");





if (isset($_REQUEST["wardcode1"])) { $wardcode = $_REQUEST["wardcode1"]; } else { $wardcode = ""; }



if (isset($_REQUEST["locationcode"])) { $locationcode1 = $_REQUEST["locationcode"]; } else { $locationcode1 = ""; }

//echo $searchsuppliername;

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; $paymentreceiveddatefrom = $ADate1; } else { $ADate1 = ""; }

//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; $paymentreceiveddateto = $ADate2; } else { $ADate2 = ""; }

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debtors Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/vat-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker Scripts -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>
    <script src="js/datetimepicker_css.js"></script>

<style type="text/css">
.bodytext31:hover { font-size:14px; }

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



<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<script src="js/datetimepicker_css.js"></script>



<!--<script type="text/javascript" src="js/autocomplete_customer2.js"></script>

<script type="text/javascript" src="js/autosuggestcustomer.js"></script>-->

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

</style>



</head>







</head>
<body>
    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Advanced Healthcare Management Platform</p>
    </header>

    <!-- User Information Bar -->
    <div class="user-info-bar">
        <div class="user-welcome">
            <span class="welcome-text">Welcome, <strong><?php echo htmlspecialchars($username); ?></strong></span>
            <span class="location-info">📍 Company: <?php echo htmlspecialchars($companyname); ?></span>
        </div>
        <div class="user-actions">
            <a href="mainmenu1.php" class="btn btn-outline">🏠 Main Menu</a>
            <a href="logout.php" class="btn btn-outline">🚪 Logout</a>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Home</a>
        <span>→</span>
        <span>Debtors Report</span>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Alert Container -->
        <div id="alertContainer">
            <?php include ("includes/alertmessages1.php"); ?>
        </div>

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <h2>Debtors Report</h2>
                <p>Comprehensive analysis of outstanding debts and payment patterns across all departments.</p>
            </div>
            <div class="page-header-actions">
                <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
                <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                    <i class="fas fa-download"></i> Export
                </button>
            </div>
        </div>

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

		

		

              <form name="cbform1" method="post" action="debtorsreport.php">

		<table width="634" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Debtors Report</strong></td>

             </tr>

             <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

              <select name="locationcode" id="$locationcode">
			  <option value="All">All</option>

                <?php

                  $query20 = "select * FROM master_location";

                  $exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die ("Error in Query20". mysqli_error($GLOBALS["___mysqli_ston"]));

                  while ($res20 = mysqli_fetch_array($exec20)){
				?>
                    <option value="<?php echo $res20['locationcode'];?>" <?php if($locationcode1==$res20['locationcode']){ echo  'selected'; } ?>><?php echo $res20['locationname'];?> </option>;
				<?php
                  }

                ?>

                </select></td>

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

	              <td align="left" valign="top"  bgcolor="#FFFFFF"></td>

	              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

				            <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

	                  <input type="submit" value="Search" name="Submit" />

	                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>

            	</tr>

          </tbody>

        </table>

		</form>		</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

       <tr>

        <?php

        if(isset($_POST['Submit'])){

        ?>

        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 

            align="left" border="0">

          <tbody>

        <tr>

          <td class="bodytext31" valign="center"  align="left" colspan="2"> 

           <!-- <a target="_blank" href="print_admissionregister.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&wardcode=<?php echo $wardcode; ?>"><img src="images/pdfdownload.jpg" width="30" height="30"></a> -->

           <a href="print_debtorsreportxls.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&locationcode1=<?php echo $locationcode1; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a>

          </td>

        </tr>

          <tr>

          <td width="5%" align="left" valign="center"  

            bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>SNO.</strong></div></td>

            <td width="30%" align="left" valign="center"  

            bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>ACCOUNTNAME</strong></div></td>

            <td width="15%" align="left" valign="center"  

            bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>MIS TYPE</strong></div></td>

          <td width="15%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>OP REVENUE</strong></div></td>
          <td width="15%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>IP REVENUE</strong></div></td>
          <td width="15%" align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="right"><strong>Doc. Share</strong></div></td>
        </tr>

          

        <?php

            $revenue = $totalrevenue = 0.00;
            $oprevenue = $optotalrevenue = 0.00;
            $doc_share_amount = $total_doc_share_amount = 0.00;

            $acountname = '';
			
				if($locationcode1=='All')
				{
				$pass_location = "locationcode !=''";
				}
				else
				{
				$pass_location = "locationcode ='$locationcode1'";
				}

            // 02-4500-1 CASH ACCOUNT ID
            // 07-7701 REPLACE WITH CASH ACCOUNT ID

               $query1 = "SELECT accountname, sum(revenue) as revenue, miscode, sum(oprev) as oprev, sum(doc_share) as doc_share, sum(doc_share_org) as doc_share_org, sum(pvt_bill1) as pvt_bill1   from (

                  SELECT '0'  as pvt_bill1, '0' as doc_share_org, '0' as doc_share, '0' as oprev, sum(billing_ip.totalrevenue) as revenue, master_accountname.id, master_subtype.subtype as accountname, master_accountname.misreport as miscode FROM `billing_ip` JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ip.billdate between '$ADate1' and '$ADate2' and master_accountname.id != '02-4500-1' and billing_ip.$pass_location  group by master_subtype.auto_number

                  UNION ALL SELECT '0'  as pvt_bill1, '0' as doc_share_org, '0' as doc_share, '0' as oprev, sum(billing_ipcreditapproved.totalrevenue) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ipcreditapproved` JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipcreditapproved.billdate between '$ADate1' and '$ADate2' and master_accountname.id != '02-4500-1' and billing_ipcreditapproved.$pass_location group by master_subtype.auto_number

                  -- PRIVATE DOC BILLING CALCULATIONS
                  UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((-1)*billing_ipprivatedoctor.transactionamount) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ip` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ip.billno  JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number  WHERE  billing_ip.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ip.accountnameano!='603' and billing_ipprivatedoctor.recorddate  between '$ADate1' and '$ADate2' and billing_ip.$pass_location group by master_subtype.auto_number


                   UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((-1)*billing_ipprivatedoctor.transactionamount) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ipcreditapproved` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ipcreditapproved.billno  JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipcreditapproved.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ipcreditapproved.accountnameano!='603' and billing_ipprivatedoctor.recorddate  between '$ADate1' and '$ADate2' and billing_ipcreditapproved.$pass_location group by master_subtype.auto_number

                    -- 1 start
                   UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((1)*billing_ipprivatedoctor.transactionamount) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ip` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ip.billno  JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number  WHERE  billing_ip.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ip.accountnameano!='603' AND billing_ipprivatedoctor.visittype='IP' and billing_ipprivatedoctor.coa!='' and billing_ipprivatedoctor.recorddate  between '$ADate1' and '$ADate2' and billing_ip.$pass_location group by master_subtype.auto_number


                   UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((1)*billing_ipprivatedoctor.transactionamount) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ipcreditapproved` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ipcreditapproved.billno  JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipcreditapproved.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ipcreditapproved.accountnameano!='603' AND billing_ipprivatedoctor.visittype='IP' and billing_ipprivatedoctor.coa!='' and billing_ipprivatedoctor.recorddate  between '$ADate1' and '$ADate2' and billing_ipcreditapproved.$pass_location group by master_subtype.auto_number

                  -- 2 one

                  UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((1)*billing_ipprivatedoctor.original_amt) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ip` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ip.billno  JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number  WHERE  billing_ip.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ip.accountnameano!='603' AND billing_ipprivatedoctor.visittype='IP'  and billing_ipprivatedoctor.coa='' and billing_ipprivatedoctor.recorddate  between '$ADate1' and '$ADate2' and billing_ip.$pass_location group by master_subtype.auto_number


                   UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((1)*billing_ipprivatedoctor.original_amt) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ipcreditapproved` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ipcreditapproved.billno  JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipcreditapproved.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ipcreditapproved.accountnameano!='603' AND billing_ipprivatedoctor.visittype='IP' and billing_ipprivatedoctor.coa='' and billing_ipprivatedoctor.recorddate  between '$ADate1' and '$ADate2' and billing_ipcreditapproved.$pass_location group by master_subtype.auto_number

                  -- 3 close

                  UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((1)*billing_ipprivatedoctor.transactionamount) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ip` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ip.billno  JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number  WHERE  billing_ip.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ip.accountnameano!='603' AND billing_ipprivatedoctor.visittype!='IP' and billing_ipprivatedoctor.recorddate  between '$ADate1' and '$ADate2' and billing_ip.$pass_location group by master_subtype.auto_number


                   UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((1)*billing_ipprivatedoctor.transactionamount) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ipcreditapproved` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ipcreditapproved.billno  JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipcreditapproved.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ipcreditapproved.accountnameano!='603' AND billing_ipprivatedoctor.visittype!='IP' and billing_ipprivatedoctor.recorddate  between '$ADate1' and '$ADate2' and billing_ipcreditapproved.$pass_location group by master_subtype.auto_number

                  -- PRIVATE DOC BILLING CALCULATIONS CLOSES

                   -- IP REBATE
                  UNION ALL SELECT '0'  as pvt_bill1, '0' as doc_share_org, '0' as doc_share, '0' as oprev, sum(billing_ipnhif.amount) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ipnhif` JOIN master_accountname ON billing_ipnhif.accountcode = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipnhif.recorddate between '$ADate1' and '$ADate2' and master_accountname.id != '02-4500-1' and billing_ipnhif.$pass_location group by master_subtype.auto_number

                  -- IP Discount 
                  UNION ALL 
                    SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((-1)*ip_discount.rate) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ip` JOIN ip_discount ON  ip_discount.patientvisitcode=billing_ip.visitcode  JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number  WHERE  billing_ip.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ip.accountnameano!='603' and ip_discount.consultationdate  between '$ADate1' and '$ADate2' and billing_ip.$pass_location group by master_subtype.auto_number


                   UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, '0' as oprev, sum((-1)*ip_discount.rate) as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ipcreditapproved` JOIN ip_discount ON  ip_discount.patientvisitcode=billing_ipcreditapproved.visitcode  JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipcreditapproved.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ipcreditapproved.accountnameano!='603' and ip_discount.consultationdate  between '$ADate1' and '$ADate2' and billing_ipcreditapproved.$pass_location group by master_subtype.auto_number
                 
                                  -- IP Close ============ OP Starts  
                  UNION ALL
                  SELECT '0'  as pvt_bill1, '0' as doc_share_org, '0' as doc_share, sum(billing_paylater.totalamount) as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_paylater` JOIN master_accountname ON billing_paylater.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_paylater.billdate between '$ADate1' and '$ADate2' and master_accountname.id != '02-4500-1' and billing_paylater.$pass_location group by master_subtype.auto_number

                   UNION ALL
                    -- paynow credits
                   SELECT '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, sum(billing_paynowpharmacy.fxamount) as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_paynowpharmacy` JOIN master_accountname ON billing_paynowpharmacy.accountname = master_accountname.accountname JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_paynowpharmacy.billdate between '$ADate1' and '$ADate2' and master_accountname.auto_number != '603' and billing_paynowpharmacy.$pass_location group by master_subtype.auto_number

                    UNION ALL
                    -- paynow credits
                    SELECT '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share, sum(billing_consultation.consultation) as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_consultation` JOIN master_accountname ON billing_consultation.accountname = master_accountname.accountname JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_consultation.billdate between '$ADate1' and '$ADate2' and master_accountname.auto_number != '603' and billing_consultation.$pass_location group by master_subtype.auto_number

                                    -- ====== OP Ends and DOC SHARE STARTS ========

                    -- DOC SHARE IN SERVICES
                     UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, sum(billing_ipservices.sharingamount) as doc_share, '0' as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ip` JOIN billing_ipservices ON  billing_ipservices.patientvisitcode=billing_ip.visitcode  JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number  WHERE  billing_ip.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ip.accountnameano!='603' and billing_ip.$pass_location group by master_subtype.auto_number
                     
                     UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, sum(billing_ipservices.sharingamount) as doc_share, '0' as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ipcreditapproved` JOIN billing_ipservices ON  billing_ipservices.patientvisitcode=billing_ipcreditapproved.visitcode  JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number  WHERE  billing_ipcreditapproved.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ipcreditapproved.accountnameano!='603' and billing_ipcreditapproved.$pass_location group by master_subtype.auto_number
                     

                      -- DOC SHARE IN CREDIT CONSULTATION
                     UNION ALL SELECT '0'  as pvt_bill1,'0' as doc_share_org, sum(billing_consultation.sharingamount) as doc_share, '0' as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `master_visitentry` JOIN master_accountname ON master_visitentry.accountname = master_accountname.auto_number JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number join billing_consultation on billing_consultation.patientvisitcode=master_visitentry.visitcode WHERE billing_consultation.billdate between '$ADate1' and '$ADate2' and master_accountname.auto_number != '603' AND billing_consultation.accountname != 'CASH - HOSPITAL' and master_visitentry.$pass_location group by master_subtype.auto_number

                     -- DOC SHARE IN billing_paylaterconsultation CONSULTATION
                     UNION ALL SELECT '0'  as pvt_bill1,'0' as doc_share_org, sum(billing_paylaterconsultation.sharingamount) as doc_share, '0' as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `master_visitentry` JOIN master_accountname ON master_visitentry.accountname = master_accountname.auto_number JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number join billing_paylaterconsultation on billing_paylaterconsultation.visitcode=master_visitentry.visitcode WHERE billing_paylaterconsultation.billdate between '$ADate1' and '$ADate2' and master_accountname.auto_number != '603' AND billing_paylaterconsultation.accountname != 'CASH - HOSPITAL' and master_visitentry.$pass_location group by master_subtype.auto_number
 
                      -- ip pvt doc share
                   UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, sum(billing_ipprivatedoctor.sharingamount) as doc_share, '0' as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ip` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ip.billno  JOIN master_accountname ON billing_ip.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number  WHERE  billing_ip.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ip.accountnameano!='603' and billing_ip.$pass_location group by master_subtype.auto_number


                   UNION ALL SELECT  '0'  as pvt_bill1,'0' as doc_share_org, sum(billing_ipprivatedoctor.sharingamount) as doc_share, '0' as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `billing_ipcreditapproved` JOIN billing_ipprivatedoctor ON  billing_ipprivatedoctor.docno=billing_ipcreditapproved.billno  JOIN master_accountname ON billing_ipcreditapproved.accountnameid = master_accountname.id JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number WHERE billing_ipcreditapproved.billdate between '$ADate1' and '$ADate2'  and master_accountname.auto_number != '603' and billing_ipcreditapproved.accountnameano!='603' and billing_ipcreditapproved.$pass_location group by master_subtype.auto_number

                  ) as rev group by accountname order by accountname";

                  // -- paynow credits
                    // -- SELECT '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share,  sum(billing_paynowpharmacy.fxamount) as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `master_visitentry` JOIN master_accountname ON master_visitentry.accountname = master_accountname.auto_number JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number JOIN billing_paynowpharmacy on billing_paynowpharmacy.patientvisitcode=master_visitentry.visitcode WHERE billing_paynowpharmacy.billdate between '$ADate1' and '$ADate2' and master_accountname.auto_number != '603' AND billing_paynowpharmacy.accountname != 'CASH - HOSPITAL'  group by master_subtype.auto_number
                  // for the removal of the accountname   -- paynow credits
                  // -- SELECT '0'  as pvt_bill1,'0' as doc_share_org, '0' as doc_share,  sum(billing_consultation.consultation) as oprev, '0' as revenue, master_accountname.id, master_subtype.subtype as accountname,master_accountname.misreport as miscode FROM `master_visitentry` JOIN master_accountname ON master_visitentry.accountname = master_accountname.auto_number JOIN master_subtype ON master_accountname.subtype = master_subtype.auto_number JOIN billing_consultation on billing_consultation.patientvisitcode=master_visitentry.visitcode WHERE billing_consultation.billdate between '$ADate1' and '$ADate2' and master_accountname.auto_number != '603' AND billing_consultation.accountname != 'CASH - HOSPITAL'  group by master_subtype.auto_number
 
       // 'PVTDOC' as naming, billing_ipprivatedoctor.coa as coa, billing_ipprivatedoctor.visittype as visittype,
      // '' as naming, '' as coa, '' as visittype, '0' as doc_share_org,

              $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

              while($res1 = mysqli_fetch_array($exec1)){


                  $accountname = $res1['accountname'];
                  $revenue = $res1['revenue'];
                  $oprevenue = $res1['oprev'];
                  $doc_share_amount = $res1['doc_share'];
                  $doc_share_org_amount = 0;

                  $account_doc_share=$doc_share_amount+$doc_share_org_amount;

                  $miscode = $res1['miscode'];


                  $totalrevenue += $revenue;
                  $optotalrevenue += $oprevenue;
                  $total_doc_share_amount += $account_doc_share;
                  // $total_doc_share_amount += $doc_share_amount;



                  $query2 = "select * from mis_types where auto_number = '$miscode'";

                  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die("Error in Query2" . mysqli_error($GLOBALS["___mysqli_ston"]));

                  $res2 = mysqli_fetch_array($exec2);

                  $mistype = $res2['type'];



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

               <tr <?php echo $colorcode; ?>>

                  <td class="bodytext31" valign="center"  align="center"><?php echo $snocount; ?></td>

                  <td class="bodytext31" valign="center"  align="left"><?php echo $accountname; ?></td>

                  <td class="bodytext31" valign="center"  align="left"><?php echo $mistype; ?></td>

                  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($oprevenue,2); ?></td>
                  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($revenue,2); ?></td>
                  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($account_doc_share,2); ?></td>

              </tr>

            <?php } ?>

          <tr>


            <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5" colspan="3"><strong>TOTAL REVENUE</strong></td>
            <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($optotalrevenue,2); ?></strong></td>
            <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($totalrevenue,2); ?></strong></td>
            <td class="bodytext31" valign="center" align="right" bgcolor="#ecf0f5"><strong><?php echo number_format($total_doc_share_amount,2); ?></strong></td>
          </tbody>

        </table></td>

      <?php } ?>

      </tr>

	  

    </table>

</table>

            </div>
        </main>

    <!-- Modern JavaScript -->
    <script src="js/debtorsreport-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>


<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$docno = $_SESSION['docno'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$currentdate = date("Y-m-d");



$grandtotal = '0.00';

$searchcustomername = '';

$patientfirstname = '';

$visitcode = '';

$customername = '';

$cbcustomername = '';

$cbbillnumber = '';

$cbbillstatus = '';

$customername = '';

$paymenttype = '';

$billstatus = '';

$res2loopcount = '';

$custid = '';

$visitcode1='';

$res2username ='';

$custname = '';

$colorloopcount = '';

$sno = '';

$customercode = '';

$totalsalesamount = '0.00';

$totalsalesreturnamount = '0.00';

$netcollectionamount = '0.00';

$netpaymentamount = '0.00';

$res2total = '0.00';

$cashamount = '0.00';

$cardamount = '0.00';

$chequeamount = '0.00';

$onlineamount = '0.00';

$total = '0.00';

$cashtotal = '0.00';

$cardtotal = '0.00';

$chequetotal = '0.00';

$onlinetotal = '0.00';

$res2cashamount1 ='';

$res2cardamount1 = '';

$res2chequeamount1 = '';

$res2onlineamount1 ='';

$cashamount2 = '0.00';

$cardamount2 = '0.00';

$chequeamount2 = '0.00';

$onlineamount2 = '0.00';

$total1 = '0.00';

$billnumber = '';

$netcashamount = '0.00';

$netcardamount = '0.00';

$netchequeamount = '0.00';

$netonlineamount = '0.00';

$netcreditamount = 0.00;

$nettotal = '0.00';



$transactiondatefrom = date('Y-m-d');

$transactiondateto = date('Y-m-d');  



include ("autocompletebuild_users.php");

 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

 $locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';

//$getcanum = $_GET['canum'];



if ($getcanum != '')

{

	$query4 = "select * from master_customer where locationcode='$locationcode1' and auto_number = '$getcanum'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res4 = mysqli_fetch_array($exec4);

	$cbcustomername = $res4['customername'];

	$customername = $res4['customername'];

}



if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{



	$cbcustomername = $_REQUEST['cbcustomername'];

	

	if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }

	//$cbbillnumber = $_REQUEST['cbbillnumber'];

	if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }

	//$cbbillstatus = $_REQUEST['cbbillstatus'];

	

	$transactiondatefrom = $_REQUEST['ADate1'];

	$transactiondateto = $_REQUEST['ADate2'];

	

	if (isset($_REQUEST["paymenttype"])) { $paymenttype = $_REQUEST["paymenttype"]; } else { $paymenttype = ""; }

	//$paymenttype = $_REQUEST['paymenttype'];

	if (isset($_REQUEST["billstatus"])) { $billstatus = $_REQUEST["billstatus"]; } else { $billstatus = ""; }

	//$billstatus = $_REQUEST['billstatus'];



}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Day Book Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/vat-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Date Picker CSS -->
    <link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
    
    <!-- Date Picker Scripts -->
    <script type="text/javascript" src="js/adddate.js"></script>
    <script type="text/javascript" src="js/adddate2.js"></script>

<script language="javascript">





function ajaxlocationfunction(val)

{ 

if (window.XMLHttpRequest)

					  {// code for IE7+, Firefox, Chrome, Opera, Safari

					  xmlhttp=new XMLHttpRequest();

					  }

					else

					  {// code for IE6, IE5

					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

					  }

					xmlhttp.onreadystatechange=function()

					  {

					  if (xmlhttp.readyState==4 && xmlhttp.status==200)

						{

						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;

						}

					  }

					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);

					xmlhttp.send();

}

					

//ajax to get location which is selected ends here





function cbcustomername1()

{

	document.cbform1.submit();

}



</script>



<script type="text/javascript" src="js/autocomplete_users.js"></script>

<script type="text/javascript" src="js/autosuggestusers.js"></script>

<script type="text/javascript">

window.onload = function () 

{

//alert ('hai');

	var oTextbox = new AutoSuggestControl(document.getElementById("cbcustomername"), new StateSuggestions());        

}

</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

-->

</style>

</head>



<script src="js/datetimepicker_css.js"></script>



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
        <span>Day Book Report</span>
    </nav>

    <!-- Floating Menu Toggle -->
    <div id="menuToggle" class="floating-menu-toggle">
        <i class="fas fa-bars"></i>
    </div>

    <!-- Main Container with Sidebar -->
    <div class="main-container-with-sidebar">
        <!-- Left Sidebar -->
        <aside id="leftSidebar" class="left-sidebar">
            <div class="sidebar-header">
                <h3>Quick Navigation</h3>
                <button id="sidebarToggle" class="sidebar-toggle">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="mainmenu1.php" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="daybookreport.php" class="nav-link">
                            <i class="fas fa-book"></i>
                            <span>Day Book Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="dailykpi_report.php" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Daily KPI Report</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="daytodayflash.php" class="nav-link">
                            <i class="fas fa-bolt"></i>
                            <span>Day to Day Flash</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="debtorsreport.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Debtors Report</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Alert Container -->
            <div id="alertContainer">
                <?php include ("includes/alertmessages1.php"); ?>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <h2>Day Book Report</h2>
                    <p>Comprehensive daily transaction report with payment breakdowns and financial summaries.</p>
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

            <!-- Filter Form Section -->
            <div class="filter-form-section">
                <div class="filter-form-header">
                    <i class="fas fa-filter filter-form-icon"></i>
                    <h3 class="filter-form-title">Day Book Report Filters</h3>
                </div>
                
                <form id="dayBookForm" name="cbform1" method="post" action="daybookreport.php" class="filter-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="location" class="form-label">Location</label>
                            <div id="ajaxlocation" class="location-display">
                                <strong>Location</strong>

             

            

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

						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res1 = mysqli_fetch_array($exec1);

						

						echo $res1location = $res1["locationname"];

						//$res1locationanum = $res1["locationcode"];

						}

						?>

						

						

                  

                  </td> 

            </tr>

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search User </td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

                <input name="cbcustomername" type="text" id="cbcustomername" value="" size="50" autocomplete="off">

               </td>

              </tr>

           

           <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#FFFFFF"> Date From </td>

              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">

			  <input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>				</td>

              <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>

              <td align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">

                <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

				<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>

			  </span></td>

            </tr>

			<tr>

           

			  <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>

              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

			 

				 <select name="location" id="location" onChange="ajaxlocationfunction(this.value);">
                  <option value="All">All</option>

                    <?php

						

						$query1 = "select locationname,locationcode from master_location  order by auto_number desc";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						$loccode=array();

						while ($res1 = mysqli_fetch_array($exec1))

						{

						$locationname = $res1["locationname"];

						$locationcode = $res1["locationcode"];

						

						?>

						 <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>

						<?php

						} 

						?>

                      </select>

					 

              </span></td>

			   <td width="10%" align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>

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

        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1000" 

            align="left" border="0">

          <tbody>

            <tr>

              <td width="7%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td colspan="9" bgcolor="#ecf0f5" class="bodytext31">

                <?php

				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{

					$cbcustomername = $_REQUEST['cbcustomername'];

					//$patientfirstname =  $cbcustomername;

					

					$customername = $_REQUEST['cbcustomername'];

					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }

					//$cbbillnumber = $_REQUEST['cbbillnumber'];

					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }

					//$cbbillstatus = $_REQUEST['cbbillstatus'];

					

					$transactiondatefrom = $_REQUEST['ADate1'];

					$transactiondateto = $_REQUEST['ADate2'];

				}

				?> 			             </tr>

				<?php

			 

			 if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{
					
if($locationcode1=='All')
{
$pass_location = "locationcode !=''";
}
else
{
$pass_location = "locationcode ='$locationcode1'";
}

				 $cbcustomername=trim($cbcustomername);
				 
			 $query31 = "select * from master_employee as me LEFT JOIN master_employeelocation as mel ON me.employeecode = mel.employeecode where mel.$pass_location and me.shift = 'YES' and me.username like '%$cbcustomername%'  GROUP BY me.employeecode";
			$exe31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res31 = mysqli_fetch_array($exe31))
			{

			$res21username = $res31["username"];
			if( $res21username != '')
			{

				
				
				
			include("include_daybookreport.php");
			if($numsd2 !=0 || $numsd23 !=0 || $numsd24 !=0 || $numsd25 !=0 || $numsd26 !=0 || $numsd27 !=0 || $numsd28 !=0 || $numsd29 !=0 || $numsd40 !=0 ||$numsd291 !=0 ||$numsd140 !=0){

				

			?>

            <tr bgcolor="#9999FF">

              <td colspan="10"  align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo strtoupper ($res21username);?></strong></td>

              </tr>

				

				

<tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></td>

				<td width="18%" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Bill Date </strong></td>

				<td width="12%" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Bill No </strong></td>

              <td width="12%" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Cash </strong></td>

              <td width="12%" align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Card </strong></td>

			 <td width="12%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Txn No</strong></td><!-- Card -->
              <td width="12%"  align="right" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong> Cheque </strong></td>

				<td  width="12%"  align="right" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Online</strong></td>

				<td  width="12%"  align="right" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>Mpesa</strong></td>

				<td  width="12%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Txn No</strong></td>

				<td width="5%"  align="right" valign="center" bgcolor="#ecf0f5">&nbsp;</td>

				<td width="16%"  align="right" valign="center" bgcolor="#ecf0f5">&nbsp;  </td>



			  

			  

			

			  

			  <?php 
$totalcashamount1 = '0.00';
$totalcardamount1 = '0.00';
$totalchequeamount1 = '0.00';
$totalonlineamount1 = '0.00';
$totalcreditamount1 = '0.00';
$totalcashamount2 = '0.00';
$totalcardamount2 = '0.00';
$totalchequeamount2 = '0.00';
$totalonlineamount2 ='0.00';
$totalcreditamount2 ='0.00';
$totalcashamount3 = '0.00';
$totalcardamount3 = '0.00';
$totalchequeamount3 = '0.00';
$totalonlineamount3 ='0.00';
$totalcreditamount3 ='0.00';
$totalcashamount4 = '0.00';
$totalcardamount4 = '0.00';
$totalchequeamount4 = '0.00';
$totalonlineamount4 ='0.00';
$totalcreditamount4 ='0.00';  
$totalcashamount5 = '0.00';
$totalcardamount5 = '0.00';
$totalchequeamount5 = '0.00';
$totalonlineamount5 ='0.00';
$totalcreditamount5 ='0.00';			
$totalcashamount6 = '0.00';
$totalcardamount6 = '0.00';
$totalchequeamount6 = '0.00';
$totalonlineamount6 ='0.00';
$totalcreditamount6 ='0.00';
$totalcashamount7 = '0.00';
$totalcardamount7 = '0.00';
$totalchequeamount7 = '0.00';
$totalonlineamount7 ='0.00';
$totalcreditamount7 ='0.00';
$totalcashamount8 = '0.00';
$totalcardamount8 = '0.00';
$totalchequeamount8 = '0.00';
$totalonlineamount8 ='0.00';
$totalcreditamount8 ='0.00';
$totalcashamount9 = '0.00';
$totalcardamount9 = '0.00';
$totalchequeamount9 = '0.00';
$totalonlineamount9 ='0.00';
$totalcreditamount9 ='0.00';
$totalcardamount41 = '0.00';
$totalchequeamount41 = '0.00';
$totalonlineamount41 ='0.00';
$totalcreditamount41 ='0.00';
$totalcashamount41='0.00';

			$superunionquery =  "SELECT billnumber AS billnumber, CONCAT( transactiondate,' ', transactiontime ) AS transactiondate,username AS username FROM master_transactionpaynow WHERE username = '$res21username' AND transactiondate between '$transactiondatefrom' AND '$transactiondateto' 
			UNION
			SELECT billnumber AS billnumber,billingdatetime AS transactiondate,username AS username  FROM master_billing WHERE username = '$res21username' AND billingdatetime between '$transactiondatefrom' AND '$transactiondateto' 
			UNION
			SELECT billnumber AS billnumber,CONCAT( transactiondate,' ', transactiontime ) AS transactiondate,username AS username  FROM master_transactionexternal WHERE  username = '$res21username' AND transactiondate between '$transactiondatefrom' AND '$transactiondateto'  
			UNION
			SELECT billnumber AS billnumber,CONCAT( transactiondate,' ', transactiontime ) AS transactiondate,username AS username  FROM refund_paynow WHERE  username = '$res21username' AND transactiondate between '$transactiondatefrom' AND '$transactiondateto' 
			UNION
			SELECT docno AS billnumber,CONCAT( transactiondate,' ', transactiontime ) AS transactiondate,username AS username  FROM master_transactionadvancedeposit WHERE username = '$res21username' AND transactiondate between '$transactiondatefrom' AND '$transactiondateto' 
			UNION
			SELECT docno AS billnumber,CONCAT( transactiondate,' ', transactiontime ) AS transactiondate,username AS username FROM master_transactionipdeposit WHERE  username = '$res21username' AND transactiondate between '$transactiondatefrom' AND '$transactiondateto'  
			UNION
			SELECT billnumber AS billnumber,CONCAT( transactiondate,' ', transactiontime ) AS transactiondate,username AS username  FROM master_transactionip WHERE username = '$res21username' AND transactiondate between '$transactiondatefrom' AND '$transactiondateto'  
			UNION
			SELECT billnumber AS billnumber,CONCAT( transactiondate,' ', transactiontime ) AS transactiondate,username AS username FROM master_transactionipcreditapproved WHERE username = '$res21username' AND transactiondate between '$transactiondatefrom' AND '$transactiondateto' 
			UNION
			SELECT docnumber  AS billnumber, CONCAT( transactiondate,' ', '00:00:00' )  AS transactiondate,username AS username FROM receiptsub_details WHERE  username = '$res21username' AND transactiondate between '$transactiondatefrom' AND '$transactiondateto' 
			UNION
			SELECT docno AS billnumber,CONCAT( transactiondate,' ', transactiontime ) AS transactiondate,username AS username FROM master_transactionpaylater WHERE username = '$res21username' AND transactiondate between '$transactiondatefrom' AND '$transactiondateto' and transactionstatus='onaccount'
			UNION
			SELECT docno AS billnumber,CONCAT( recorddate,' ', recordtime ) AS transactiondate,username AS username FROM deposit_refund WHERE  username = '$res21username' AND recorddate between '$transactiondatefrom' AND '$transactiondateto' GROUP BY billnumber  ORDER BY transactiondate";
			$superunionexec = mysqli_query($GLOBALS["___mysqli_ston"], $superunionquery) or die("Error in Superunionquery".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($superunionres = mysqli_fetch_array($superunionexec))
			{
				 $unionbillnumber = $superunionres['billnumber'];			
				 $uniontransactiondate= $superunionres['transactiondate'];			
			/*$dotarray = explode("-", $transactiondateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];*/

			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));



			//$cbcustomername=trim($cbcustomername);

			

			$query2 = "select * from master_transactionpaynow where billnumber = '$unionbillnumber' AND $pass_location and username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";

			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

	        while($res2 = mysqli_fetch_array($exec2))

			{

			$res2billnumber = $res2['billnumber'];

			$res2transactiondate = $res2['transactiondate'].' '.$res2['transactiontime'];

			

			$query3 = "select * from master_transactionpaynow where $pass_location and billnumber = '$res2billnumber'";

			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3" .mysqli_error($GLOBALS["___mysqli_ston"]));

			$res3 = mysqli_fetch_array($exec3);

			$res3cashamount1 = $res3['cashamount'];

			$res3cardamount1 = $res3['cardamount'];

			$res3creditamount1 = $res3['creditamount'];

			$res3chequeamount1 = $res3['chequeamount'];

			$res3onlineamount1 = $res3['onlineamount'];

			$res3transactionamount = $res3['transactionamount'];

			$totalcashamount1 = $totalcashamount1 + $res3cashamount1;

			$totalcardamount1 = $totalcardamount1 + $res3cardamount1;

			$totalchequeamount1 = $totalchequeamount1 + $res3chequeamount1;

			$totalonlineamount1 = $totalonlineamount1 + $res3onlineamount1;  

			$totalcreditamount1 = $totalcreditamount1 + $res3creditamount1;



			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";

		if($res3transactionamount != '0.00')

		{

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

			
		   $txtno=$res3['mpesanumber'];
		   $cardtxtno=$res3['creditcardnumber'];


			?>

            <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>

			   <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>

			  <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($res3cashamount1,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

			  <div class="bodytext31"><?php echo number_format($res3cardamount1,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="center"><?php echo $cardtxtno; ?></td>
              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($res3chequeamount1,2,'.',','); ?></div></td>

				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res3onlineamount1,2,'.',','); ?></div></td>

				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res3creditamount1,2,'.',','); ?></div></td>

                 <td class="bodytext31" valign="center"  align="center"><?php echo $txtno; ?></td>
				<td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>

				<td class="bodytext31" valign="center" bgcolor="#ecf0f5" align="right">&nbsp;</td>

              </tr>

			<?php
			}
			}

			?>

			  

			  <?php 

			/*$dotarray = explode("-", $transactiondateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));*/



			//$cbcustomername=trim($cbcustomername);

			

			$query23 = "select * from master_billing where billnumber = '$unionbillnumber' AND $pass_location and username = '$res21username' and billingdatetime between '$transactiondatefrom' and '$transactiondateto' order by username desc";

			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query23".mysqli_error($GLOBALS["___mysqli_ston"]));

	        while($res23 = mysqli_fetch_array($exec23))

			{

			$res23billnumber = $res23['billnumber'];

			$res23billingdatetime = $res23['billingdatetime'];

			

			$query33 = "select * from master_billing where $pass_location and billnumber = '$res23billnumber'";

			$exec33 = mysqli_query($GLOBALS["___mysqli_ston"], $query33) or die ("Error in Query33" .mysqli_error($GLOBALS["___mysqli_ston"]));

			$res33 = mysqli_fetch_array($exec33);

			$res33cashamount1 = $res33['cashamount'];

			$res33cardamount1 = $res33['cardamount'];

			$res33creditamount1 = $res33['creditamount'];

			$res33chequeamount1 = $res33['chequeamount'];

			$res33onlineamount1 = $res33['onlineamount']; 

			$res33transactionamount = $res33['totalamount'];

			

			$totalcashamount2 = $totalcashamount2 + $res33cashamount1;

			$totalcardamount2 = $totalcardamount2 + $res33cardamount1;

			$totalchequeamount2 = $totalchequeamount2 + $res33chequeamount1;

			$totalonlineamount2 = $totalonlineamount2 + $res33onlineamount1; 

			$totalcreditamount2 = $totalcreditamount2 + $res33creditamount1;

			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";

		

		if($res33transactionamount != '0.00')

		{

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


            
					$txtno=$res33['mpesanumber'];
			
					$cardtxtno=$res33['creditcardnumber'];
			?>

            <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>

			  <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo $res23billingdatetime; ?></div></td>

			  <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo $res23billnumber; ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($res33cashamount1,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

			  <div class="bodytext31"><?php echo number_format($res33cardamount1,2,'.',','); ?></div></td>

			   <td class="bodytext31" valign="center"  align="center"><?php echo $cardtxtno; ?></td>
              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($res33chequeamount1,2,'.',','); ?></div></td>

				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res33onlineamount1,2,'.',','); ?></div></td>

				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res33creditamount1,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="center"><?php echo $txtno; ?></td>

				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5" align="right">&nbsp;</td>

				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5" align="right">&nbsp;</td>

              </tr>

			  

			<?php

			 }	

			 }

			?>

			

			 <?php 

			/*$dotarray = explode("-", $transactiondateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));*/



			//$cbcustomername=trim($cbcustomername);

			

			$query24 = "select * from master_transactionexternal where  billnumber = '$unionbillnumber' AND $pass_location and username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";

			$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));

	        while($res24 = mysqli_fetch_array($exec24))

			{

			$res24billnumber = $res24['billnumber'];

			$res24transactiondate = $res24['transactiondate'].' '.$res24['transactiontime'];

			

			$query34 = "select * from master_transactionexternal where $pass_location and billnumber = '$res24billnumber'";

			$exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die ("Error in Query34" .mysqli_error($GLOBALS["___mysqli_ston"]));

			$res34 = mysqli_fetch_array($exec34);

			$res34cashamount1 = $res34['cashamount'];

			$res34cardamount1 = $res34['cardamount'];

			$res34creditamount1 = $res34['creditamount'];

			$res34chequeamount1 = $res34['chequeamount'];

			$res34onlineamount1 = $res34['onlineamount']; 

			$res34transactionamount = $res34['transactionamount'];

			

			$totalcashamount3 = $totalcashamount3 + $res34cashamount1;

			$totalcardamount3 = $totalcardamount3 + $res34cardamount1; 

			$totalchequeamount3 = $totalchequeamount3 + $res34chequeamount1;

			$totalonlineamount3 = $totalonlineamount3 + $res34onlineamount1; 

			$totalcreditamount3 = $totalcreditamount3 + $res34creditamount1;

			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";

		

		if($res34transactionamount != '0.00')

		{

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

			$txtno=$res34['mpesanumber'];
			$cardtxtno=$res34['creditcardnumber'];


			?>

            <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>

			  <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo $res24transactiondate; ?></div></td>

			  <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo $res24billnumber; ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($res34cashamount1,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

			  <div class="bodytext31"><?php echo number_format($res34cardamount1,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="center"><?php echo $cardtxtno; ?></td>
              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($res34chequeamount1,2,'.',','); ?></div></td>

				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res34onlineamount1,2,'.',','); ?></div></td>

				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res34creditamount1,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="center"><?php echo $txtno; ?></td>
				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5"  align="right">&nbsp;</td>

				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5"  align="right">&nbsp;</td>

              </tr>

			<?php

			 }

			 }

			?>

			

			<?php 

			/*//$dotarray = explode("-", $transactiondateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));*/



			//$cbcustomername=trim($cbcustomername);

			

			$query25 = "select * from refund_paynow where billnumber = '$unionbillnumber' AND  $pass_location and username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";

			$exec25 = mysqli_query($GLOBALS["___mysqli_ston"], $query25) or die ("Error in Query25".mysqli_error($GLOBALS["___mysqli_ston"]));

	        while($res25 = mysqli_fetch_array($exec25))

			{

			$res25billnumber = $res25['billnumber'];

			$res25transactiondate = $res25['transactiondate'].' '.$res25['transactiontime'];

			

			$query35 = "select * from refund_paynow where $pass_location and billnumber = '$res25billnumber'";

			$exec35 = mysqli_query($GLOBALS["___mysqli_ston"], $query35) or die ("Error in Query35" .mysqli_error($GLOBALS["___mysqli_ston"]));

			$res35 = mysqli_fetch_array($exec35);

			$res35cashamount1 = $res35['cashamount'];

			$res35cardamount1 = $res35['cardamount'];

			$res35creditamount1 = $res35['creditamount'];

			$res35chequeamount1 = $res35['chequeamount'];

			$res35onlineamount1 = $res35['onlineamount'];

			$res35transactionamount = $res35['transactionamount'];

			

			$totalcashamount4 = $totalcashamount4 + $res35cashamount1;

			$totalcardamount4 = $totalcardamount4 + $res35cardamount1;

			$totalchequeamount4 = $totalchequeamount4 + $res35chequeamount1;

			$totalonlineamount4 = $totalonlineamount4 + $res35onlineamount1;

			$totalcreditamount4 = $totalcreditamount4 + $res35creditamount1;

			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";

		

		if($res35transactionamount != '0.00')

		{

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


			$txtno=$res35['mpesanumber'];
			$cardtxtno=$res35['creditcardnumber'];


			?>

            <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>

			  <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo $res25transactiondate; ?></div></td>

			  <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo $res25billnumber; ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format(- $res35cashamount1,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

			  <div class="bodytext31"><?php echo number_format(- $res35cardamount1,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="center"><?php echo $cardtxtno; ?></td>
              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format(- $res35chequeamount1,2,'.',','); ?></div></td>

				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format(- $res35onlineamount1,2,'.',','); ?></div></td>

				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format(- $res35creditamount1,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="center"><?php echo $txtno; ?></td>
				<td class="bodytext31" valign="center"   bgcolor="#ecf0f5" align="right">&nbsp;</td>

				<td class="bodytext31" valign="center"   bgcolor="#ecf0f5" align="right">&nbsp;</td>

              </tr>

			<?php

			 }	

			 }

			?>

			 <?php 

			/*//$dotarray = explode("-", $transactiondateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));*/



			//$cbcustomername=trim($cbcustomername);

			

			$query26 = "select * from master_transactionadvancedeposit where  docno = '$unionbillnumber' AND $pass_location and username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";

			$exec26 = mysqli_query($GLOBALS["___mysqli_ston"], $query26) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));

	        while($res26 = mysqli_fetch_array($exec26))

			{

			$res26billnumber = $res26['docno'];

			$res26transactiondate = $res26['transactiondate'].' '.$res26['transactiontime'];

			

			$query36 = "select * from master_transactionadvancedeposit where $pass_location and docno = '$res26billnumber'";

			$exec36 = mysqli_query($GLOBALS["___mysqli_ston"], $query36) or die ("Error in Query34" .mysqli_error($GLOBALS["___mysqli_ston"]));

			$res36 = mysqli_fetch_array($exec36);

			$res36cashamount1 = $res36['cashamount'];

			$res36cardamount1 = $res36['cardamount'];

			$res36creditamount1 = $res36['creditamount'];

			$res36chequeamount1 = $res36['chequeamount'];

			$res36onlineamount1 = $res36['onlineamount']; 

			$res36transactionamount = $res36['transactionamount'];

			

			$totalcashamount5 = $totalcashamount5 + $res36cashamount1;

			$totalcardamount5 = $totalcardamount5 + $res36cardamount1; 

			$totalchequeamount5 = $totalchequeamount5 + $res36chequeamount1;

			$totalonlineamount5 = $totalonlineamount5 + $res36onlineamount1; 

			$totalcreditamount5 = $totalcreditamount5 + $res36creditamount1;

			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";

		

		if($res36transactionamount != '0.00')

		{

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


			$txtno=$res36['mpesanumber'];
			$cardtxtno=$res36['creditcardnumber'];


			?>

            <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>

			  <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo $res26transactiondate; ?></div></td>

			  <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo $res26billnumber; ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($res36cashamount1,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

			  <div class="bodytext31"><?php echo number_format($res36cardamount1,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="center"><?php echo $cardtxtno; ?></td>
              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($res36chequeamount1,2,'.',','); ?></div></td>

				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res36onlineamount1,2,'.',','); ?></div></td>

				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res36creditamount1,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="center"><?php echo $txtno; ?></td>
				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5"  align="right">&nbsp;</td>

				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5"  align="right">&nbsp;</td>

              </tr>

			<?php

			 }

			 }

			?>

			<?php 

			/*//$dotarray = explode("-", $transactiondateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));*/



			//$cbcustomername=trim($cbcustomername);

			

			$query27 = "select * from master_transactionipdeposit where  docno = '$unionbillnumber' AND $pass_location and username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";

			$exec27 = mysqli_query($GLOBALS["___mysqli_ston"], $query27) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));

	        while($res27 = mysqli_fetch_array($exec27))

			{

			$res27billnumber = $res27['docno'];

			$res27transactiondate = $res27['transactiondate'].' '.$res27['transactiontime'];

			

			$query37 = "select * from master_transactionipdeposit where $pass_location and docno = '$res27billnumber' and docno <> ''";

			$exec37 = mysqli_query($GLOBALS["___mysqli_ston"], $query37) or die ("Error in Query34" .mysqli_error($GLOBALS["___mysqli_ston"]));

			while($res37 = mysqli_fetch_array($exec37)){

			$res37cashamount1 = $res37['cashamount'];

			$res37cardamount1 = $res37['cardamount'];

			$res37creditamount1 = $res37['creditamount'];

			$res37chequeamount1 = $res37['chequeamount'];

			$res37onlineamount1 = $res37['onlineamount']; 

			$res37transactionamount = $res37['transactionamount'];

			

			$totalcashamount6 = $totalcashamount6 + $res37cashamount1;

			$totalcardamount6 = $totalcardamount6 + $res37cardamount1; 

			$totalchequeamount6 = $totalchequeamount6 + $res37chequeamount1;

			$totalonlineamount6 = $totalonlineamount6 + $res37onlineamount1; 

			$totalcreditamount6 = $totalcreditamount6 + $res37creditamount1;

			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";

		

		if($res37transactionamount != '0.00')

		{

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

              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>

			  <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo $res27transactiondate; ?></div></td>

			  <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo $res27billnumber; ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($res37cashamount1,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

			  <div class="bodytext31"><?php echo number_format($res37cardamount1,2,'.',','); ?></div></td>

			  <td class="bodytext31" valign="center"  align="center"><?php if($res37cardamount1>0) echo $res37['chequenumber']; ?></td>
              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($res37chequeamount1,2,'.',','); ?></div></td>

				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res37onlineamount1,2,'.',','); ?></div></td>

				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res37creditamount1,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="center"><?php if($res37creditamount1>0) echo $res37['chequenumber']; ?></td>
				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5"  align="right">&nbsp;</td>

				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5"  align="right">&nbsp;</td>

              </tr>

			<?php

			 }

			 }

			 }

			?>

			<?php 

		/*	//$dotarray = explode("-", $transactiondateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));*/



			//$cbcustomername=trim($cbcustomername);

			

			$query28 = "select * from master_transactionip where  billnumber = '$unionbillnumber' AND $pass_location and username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";

			$exec28 = mysqli_query($GLOBALS["___mysqli_ston"], $query28) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));

	        while($res28 = mysqli_fetch_array($exec28))

			{

			$res28billnumber = $res28['billnumber'];

			$res28transactiondate = $res28['transactiondate'].' '.$res28['transactiontime'];

			

			$query38 = "select * from master_transactionip where $pass_location and billnumber = '$res28billnumber'";

			$exec38 = mysqli_query($GLOBALS["___mysqli_ston"], $query38) or die ("Error in Query34" .mysqli_error($GLOBALS["___mysqli_ston"]));

			$res38 = mysqli_fetch_array($exec38);

			$res38cashamount1 = $res38['cashamount'];

			$res38cardamount1 = $res38['cardamount'];

			$res38creditamount1 = $res38['mpesaamount'];

			$res38chequeamount1 = $res38['chequeamount'];

			$res38onlineamount1 = $res38['onlineamount']; 

			$res38transactionamount = $res38['transactionamount'];

			

			$totalcashamount7 = $totalcashamount7 + $res38cashamount1;

			$totalcardamount7 = $totalcardamount7 + $res38cardamount1; 

			$totalchequeamount7 = $totalchequeamount7 + $res38chequeamount1;

			$totalonlineamount7 = $totalonlineamount7 + $res38onlineamount1; 

			$totalcreditamount7 = $totalcreditamount7 + $res38creditamount1;

			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";

		

		if($res38transactionamount != '0.00')

		{

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

			$txtno=$res38['mpesanumber'];
			$cardtxtno=$res38['creditcardnumber'];


			?>

            <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>

			  <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo $res28transactiondate; ?></div></td>

			  <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo $res28billnumber; ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($res38cashamount1,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

			  <div class="bodytext31"><?php echo number_format($res38cardamount1,2,'.',','); ?></div></td>

			   <td class="bodytext31" valign="center"  align="center"><?php echo $cardtxtno; ?></td>
              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($res38chequeamount1,2,'.',','); ?></div></td>

				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res38onlineamount1,2,'.',','); ?></div></td>

				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res38creditamount1,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="center"><?php echo $txtno; ?></td>
				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5"  align="right">&nbsp;</td>

				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5"  align="right">&nbsp;</td>

              </tr>

			<?php

			 }

			 }

			?>

			<?php 

		/*	//$dotarray = explode("-", $transactiondateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));*/



			//$cbcustomername=trim($cbcustomername);

			

			$query29 = "select * from master_transactionipcreditapproved where billnumber = '$unionbillnumber' AND $pass_location and username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";

			$exec29 = mysqli_query($GLOBALS["___mysqli_ston"], $query29) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));

	        while($res29 = mysqli_fetch_array($exec29))

			{

			$res29billnumber = $res29['billnumber'];

			$res29transactiondate = $res29['transactiondate'].' '.$res29['transactiontime'];

			$res2postingaccount = $res29['postingaccount'];

			

			$query39 = "select * from master_transactionipcreditapproved where $pass_location and billnumber = '$res29billnumber' and postingaccount = '$res2postingaccount'";

			$exec39 = mysqli_query($GLOBALS["___mysqli_ston"], $query39) or die ("Error in Query34" .mysqli_error($GLOBALS["___mysqli_ston"]));

			$res39 = mysqli_fetch_array($exec39);

			$res39cashamount1 = $res39['cashamount'];

			$res39cardamount1 = $res39['cardamount'];

			$res39creditamount1 = $res39['creditamount'];

			$res39chequeamount1 = $res39['chequeamount'];

			$res39onlineamount1 = $res39['onlineamount']; 

			$res39transactionamount = $res39['transactionamount'];

			

			$totalcashamount8 = $totalcashamount8 + $res39cashamount1;

			$totalcardamount8 = $totalcardamount8 + $res39cardamount1; 

			$totalchequeamount8 = $totalchequeamount8 + $res39chequeamount1;

			$totalonlineamount8 = $totalonlineamount8 + $res39onlineamount1;

			$totalcreditamount8 = $totalcreditamount8 + $res39creditamount1;

			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";

		

		if(($res39cashamount1 != '0.00')||($res39cardamount1 != '0.00')||($res39chequeamount1 != '0.00')||($res39onlineamount1 != '0.00'))

		{

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


		   $txtno=$res39['mpesanumber'];
			$cardtxtno=$res39['creditcardnumber'];


			?>

            <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>

			  <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo $res29transactiondate; ?></div></td>

			  <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo $res29billnumber; ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($res39cashamount1,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

			  <div class="bodytext31"><?php echo number_format($res39cardamount1,2,'.',','); ?></div></td>

			   <td class="bodytext31" valign="center"  align="center"><?php echo $cardtxtno; ?></td>
              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($res39chequeamount1,2,'.',','); ?></div></td>

				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res39onlineamount1,2,'.',','); ?></div></td>

				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res39creditamount1,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="center"><?php echo $txtno; ?></td>
				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5"  align="right">&nbsp;</td>

				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5"  align="right">&nbsp;</td>

              </tr>

			<?php

			 }

			 }

			?>





			<?php 

			/*//$dotarray = explode("-", $transactiondateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));*/



			//$cbcustomername=trim($cbcustomername);

			

			$query40 = "select * from receiptsub_details where docnumber = '$unionbillnumber' AND $pass_location and username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";

			$exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die ("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));

	        while($res40 = mysqli_fetch_array($exec40))

			{

			$res40billnumber = $res40['docnumber'];

			$res40transactiondate = $res40['transactiondate'].' '.$res40['transactiontime'];

			//$res40postingaccount = $res40['postingaccount'];

			

			/*$query39 = "select * from receiptsub_details where billnumber = '$res29billnumber' and postingaccount = '$res2postingaccount'";

			$exec39 = mysql_query($query39) or die ("Error in Query34" .mysql_error());

			$res39 = mysql_fetch_array($exec39);*/

			$res40cashamount1 = $res40['cashamount'];

			$res40cardamount1 = $res40['cardamount'];

			$res40creditamount1 = $res40['creditamount'];

			$res40chequeamount1 = $res40['chequeamount'];

			$res40onlineamount1 = $res40['onlineamount']; 

			$res40transactionamount = $res40['transactionamount'];

			

			$totalcashamount9 = $totalcashamount9 + $res40cashamount1;

			$totalcardamount9 = $totalcardamount9 + $res40cardamount1; 

			$totalchequeamount9 = $totalchequeamount9 + $res40chequeamount1;

			$totalonlineamount9 = $totalonlineamount9 + $res40onlineamount1; 

			$totalcreditamount9 = $totalcreditamount9 + $res40creditamount1;

			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";

		

		if(($res40cashamount1 != '0.00')||($res40cardamount1 != '0.00')||($res40chequeamount1 != '0.00')||($res40onlineamount1 != '0.00'))

		{

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

			$txtno=$res40['mpesanumber'];
			$cardtxtno=$res40['creditcardnumber'];


			?>

            <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>

			  <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo $res40transactiondate; ?></div></td>

			  <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo $res40billnumber; ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($res40cashamount1,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

			  <div class="bodytext31"><?php echo number_format($res40cardamount1,2,'.',','); ?></div></td>

			   <td class="bodytext31" valign="center"  align="center"><?php echo $cardtxtno; ?></td>
              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($res40chequeamount1,2,'.',','); ?></div></td>

				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res40onlineamount1,2,'.',','); ?></div></td>

				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res40creditamount1,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="center"><?php echo $txtno; ?></td>
				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5"  align="right">&nbsp;</td>

				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5"  align="right">&nbsp;</td>

              </tr>

			<?php

			 }

			 }

			?>



			<?php 

			/*//$dotarray = explode("-", $transactiondateto);

			$dotyear = $dotarray[0];

			$dotmonth = $dotarray[1];

			$dotday = $dotarray[2];

			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));*/

			//$cbcustomername=trim($cbcustomername);

			

			$query40 = "select * from master_transactionpaylater where docno = '$unionbillnumber' AND $pass_location and username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and docno like 'AR-%' and transactionstatus='onaccount' ";

			$exec40 = mysqli_query($GLOBALS["___mysqli_ston"], $query40) or die ("Error in Query40".mysqli_error($GLOBALS["___mysqli_ston"]));

	        while($res40 = mysqli_fetch_array($exec40))

			{

			$res40billnumber = $res40['docno'];

			$res40transactiondate = $res40['transactiondate'].' '.$res40['transactiontime'];

			//$res40postingaccount = $res40['postingaccount'];

			

			/*$query39 = "select * from receiptsub_details where billnumber = '$res29billnumber' and postingaccount = '$res2postingaccount'";

			$exec39 = mysql_query($query39) or die ("Error in Query34" .mysql_error());

			$res39 = mysql_fetch_array($exec39);*/

			$res40cashamount1 = $res40['cashamount'];

			$res40cardamount1 = $res40['cardamount'];

			$res40creditamount1 = $res40['creditamount'];

			$res40chequeamount1 = $res40['chequeamount'];

			$res40onlineamount1 = $res40['onlineamount']; 

			$res40transactionamount = $res40['transactionamount'];

			

			$totalcashamount9 = $totalcashamount9 + $res40cashamount1;

			$totalcardamount9 = $totalcardamount9 + $res40cardamount1; 

			$totalchequeamount9 = $totalchequeamount9 + $res40chequeamount1;

			$totalonlineamount9 = $totalonlineamount9 + $res40onlineamount1; 

			$totalcreditamount9 = $totalcreditamount9 + $res40creditamount1;

			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";

		

		if(($res40cashamount1 != '0.00')||($res40cardamount1 != '0.00')||($res40chequeamount1 != '0.00')||($res40onlineamount1 != '0.00'))

		{

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


           $txtno=$res40['mpesanumber'];
			$cardtxtno=$res40['creditcardnumber'];
			?>

            <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>

			  <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo $res40transactiondate; ?></div></td>

			  <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo $res40billnumber; ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($res40cashamount1,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

			  <div class="bodytext31"><?php echo number_format($res40cardamount1,2,'.',','); ?></div></td>

			   <td class="bodytext31" valign="center"  align="center"><?php echo $cardtxtno; ?></td>
              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format($res40chequeamount1,2,'.',','); ?></div></td>

				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res40onlineamount1,2,'.',','); ?></div></td>

				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format($res40creditamount1,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="center"><?php echo $txtno; ?></td>
				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5"  align="right">&nbsp;</td>

				<td class="bodytext31" valign="center"  bgcolor="#ecf0f5"  align="right">&nbsp;</td>

              </tr>

			<?php

			 }

			 }

			?>

			

            <?php 


			$query251 = "select * from deposit_refund where docno = '$unionbillnumber' AND $pass_location and username = '$res21username' and recorddate between '$transactiondatefrom' and '$transactiondateto' order by username desc";

			$exec251 = mysqli_query($GLOBALS["___mysqli_ston"], $query251) or die ("Error in Query251".mysqli_error($GLOBALS["___mysqli_ston"]));

	        while($res251 = mysqli_fetch_array($exec251))

			{

			$res25billnumber1 = $res251['docno'];

			$res25transactiondate1 = $res251['recorddate'].' '.$res251['recordtime'];

			

			$query351 = "select * from deposit_refund where $pass_location and docno = '$res25billnumber1'";

			$exec351 = mysqli_query($GLOBALS["___mysqli_ston"], $query351) or die ("Error in Query351" .mysqli_error($GLOBALS["___mysqli_ston"]));

			$res351 = mysqli_fetch_array($exec351);

			$res35cashamount11 = $res351['cashamount'];

			$res35cardamount11 = $res351['cardamount'];

			$res35creditamount11 = $res351['creditamount'];

			$res35chequeamount11 = $res351['chequeamount'];

			$res35onlineamount11 = $res351['onlineamount'];

		 	$res35transactionamount1 = $res351['amount'];

			

			$totalcashamount41 = $totalcashamount41 + $res35cashamount11;

			$totalcardamount41 = $totalcardamount41 + $res35cardamount11;

			$totalchequeamount41 = $totalchequeamount41 + $res35chequeamount11;

			$totalonlineamount41 = $totalonlineamount41 + $res35onlineamount11;

			$totalcreditamount41 = $totalcreditamount41 + $res35creditamount11;

			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";

		

		if($res35transactionamount1 != '0.00')

		{

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

			$txtno=@$res351['mpesanumber'];
			$cardtxtno=@$res351['creditcardnumber'];


			?>

            <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>

			  <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo $res25transactiondate1; ?></div></td>

			  <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo $res25billnumber1; ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format(- $res35cashamount11,2,'.',','); ?></div></td>

              <td class="bodytext31" valign="center"  align="right">

			  <div class="bodytext31"><?php echo number_format(- $res35cardamount11,2,'.',','); ?></div></td>

			   <td class="bodytext31" valign="center"  align="center"><?php echo $cardtxtno; ?></td>
              <td class="bodytext31" valign="center"  align="right">

                <div class="bodytext31"><?php echo number_format(- $res35chequeamount11,2,'.',','); ?></div></td>

				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format(- $res35onlineamount11,2,'.',','); ?></div></td>

				<td  align="right" valign="center" class="bodytext31"><div class="bodytext31"><?php echo number_format(- $res35creditamount11,2,'.',','); ?></div></td>

				<td class="bodytext31" valign="center"  align="center"><?php echo $txtno; ?></td>
				<td class="bodytext31" valign="center"   bgcolor="#ecf0f5" align="right">&nbsp;</td>

				<td class="bodytext31" valign="center"   bgcolor="#ecf0f5" align="right">&nbsp;</td>

              </tr>

			<?php

			 }	

			 }
			}
			?>

            

			<?php

			$totalcashamount = $totalcashamount1 + $totalcashamount2 + $totalcashamount3 - $totalcashamount4 + $totalcashamount5 + $totalcashamount6 + $totalcashamount7 + $totalcashamount8 + $totalcashamount9 -$totalcashamount41;

			$totalcardamount = $totalcardamount1 + $totalcardamount2 + $totalcardamount3 - $totalcardamount4 - $totalcardamount41 + $totalcardamount5 + $totalcardamount6 + $totalcardamount7 + $totalcardamount8 + $totalcardamount9;

			$totalchequeamount = $totalchequeamount1 + $totalchequeamount2 + $totalchequeamount3 - $totalchequeamount4 - $totalchequeamount41 + $totalchequeamount5 + $totalchequeamount6 + $totalchequeamount7 + $totalchequeamount8 + $totalchequeamount9;

			$totalonlineamount = $totalonlineamount1 + $totalonlineamount2 +$totalonlineamount3 - $totalonlineamount4 - $totalonlineamount41 + $totalonlineamount5 + $totalonlineamount6 + $totalonlineamount7 + $totalonlineamount8 + $totalonlineamount9; 

			$totalcreditamount = $totalcreditamount1 + $totalcreditamount2 +$totalcreditamount3 - $totalcreditamount4 - $totalcreditamount41 + $totalcreditamount5 + $totalcreditamount6 + $totalcreditamount7 + $totalcreditamount8 + $totalcreditamount9; 

			$netcashamount = $netcashamount + $totalcashamount;

			$netcardamount = $netcardamount + $totalcardamount;

			$netchequeamount = $netchequeamount + $totalchequeamount;

			$netonlineamount = $netonlineamount + $totalonlineamount;

			$netcreditamount = $netcreditamount + $totalcreditamount;

			$grandtotal = $totalcashamount + $totalcardamount + $totalchequeamount + $totalonlineamount + $totalcreditamount; 

			$nettotal = $nettotal + $grandtotal;

			

			if(($totalcashamount != '0.00')||($totalcardamount != '0.00')||($totalchequeamount != '0.00')||($totalonlineamount != '0.00')||($totalcreditamount != '0.00'))
			// if(1)

			{

			?>

            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"></td>

				

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong>Total:</strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($totalcashamount,2,'.',','); ?></td>

              <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($totalcardamount,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"></td>
				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><?php echo number_format($totalchequeamount,2,'.',','); ?></td>

				<td  align="right" valign="center" 

                bgcolor="#ecf0f5" class="bodytext31"><?php echo number_format($totalonlineamount,2,'.',',');?></td>

				<td  align="right" valign="center" 

                bgcolor="#ecf0f5" class="bodytext31"><?php echo number_format($totalcreditamount,2,'.',',');?></td>

				<td  align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"></td>

                <?php  if($cbcustomername!=""){ ?>

				<td  align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="daybookreport_total_print_pdf.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $locationcode1; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&cbcustomername=<?php echo $cbcustomername; ?>"><img src="images/pdfdownload.jpg" width="30" height="30"></a></td>

		<td><a href="daybookreport_total_print.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $locationcode1; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&cbcustomername=<?php echo $cbcustomername; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>

				<?php } ?>

			 </tr>

			  

			  

			 <!-- <tr>

			    <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"></td>

			    <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"></td>

			    <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>Grand Total:</strong></td>

			    <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><?php echo number_format($netcashamount,2,'.',','); ?></td>

			    <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><?php echo number_format($netcardamount,2,'.',','); ?></td>

			    <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><?php echo number_format($netchequeamount,2,'.',','); ?></td>

			    <td  align="right" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><?php echo number_format($netonlineamount,2,'.',',');?></td>

			    <td class="bodytext31" valign="center"  align="right" 

                 bgcolor="#ecf0f5">&nbsp;</td>

			    </tr>-->

			  <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"></td>

			

              <td colspan="3" class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><strong>Total for Payment Modes :</strong></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff" style="mso-number-format:'\@'"><?php echo number_format($grandtotal,2,'.',','); ?></td>

			  <td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><?php //echo number_format($totalcardamount,2,'.',','); ?></td>

				<td class="bodytext31" valign="center"  align="right" 

                bgcolor="#ffffff"><?php //echo number_format($totalchequeamount,2,'.',','); ?></td>

				<td  align="right" valign="center" colspan="3" 

                bgcolor="#ffffff" class="bodytext31"><?php //echo number_format($totalonlineamount,2,'.',',');?></td>

				</tr>

			  <?php 

			  }

			  }
			  	}		  

						  } }

			  ?>

			  <tr>

			    <td colspan="3" class="bodytext31" valign="center"  align="right">&nbsp;</td>

			    </tr>
			    <?php if($nettotal!=0){ ?>

			  <tr>


	    <td colspan="3" class="bodytext31" valign="center"  align="right"><strong>Grand Total :</strong> </td>

		<td class="bodytext31" valign="center"  align="right"><?php echo number_format($nettotal,2,'.',','); ?></td>

		<td class="bodytext31" valign="center"  align="right">&nbsp;</td>

		<td class="bodytext31" valign="center"  align="right">&nbsp;</td>

		<td colspan="4" class="bodytext31" valign="center"  align="right">&nbsp;</td>

 		<?php  if($cbcustomername==""){ ?>

		<td  align="right" valign="center" bgcolor="#ecf0f5" class="bodytext31"><a target="_blank" href="daybookreport_total_print_pdf.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $locationcode1; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&cbcustomername=<?php echo $cbcustomername; ?>"><img src="images/pdfdownload.jpg" width="30" height="30"></a></td>

		<td><a href="daybookreport_total_print.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $locationcode1; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&cbcustomername=<?php echo $cbcustomername; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>

		<?php } ?>


	  </tr>	 
		<?php } ?>

          </tbody>

        </table></td>

      </tr>

    </table>

  </table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>




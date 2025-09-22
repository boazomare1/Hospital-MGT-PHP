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



$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$total = '0.00';

$totalat = '0.00';

$searchsuppliername = "";

$cbsuppliername = "";

$snocount = "";

$colorloopcount="";

$range = "";

$arraysuppliername = '';

$arraysuppliercode = '';	

$totalatret = 0.00;

$totalamount1=0;

$totalamount30 = 0;

$totalamount60 = 0;

$totalamount90 = 0;

$totalamount120 = 0;

$totalamount180 = 0;

$totalamountgreater = 0;

$totalamount1 = 0;



include ("autocompletebuild_supplier1.php");





if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

//echo $searchsuppliername;

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

//echo $ADate1;

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

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
    <title>Doctor Remittance Report - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/doctor-remittance-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

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

<script>

function funcAccount()

{



}

</script>



<script type="text/javascript" src="js/autocomplete_doctor.js"></script>
<script type="text/javascript" src="js/autosuggestdoctor.js"></script>

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



<script src="js/datetimepicker_css.js"></script>

<!-- Modern JavaScript -->
<script src="js/doctor-remittance-modern.js?v=<?php echo time(); ?>"></script>



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
        <span>Doctor Remittance Report</span>
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
                    <li class="nav-item">
                        <a href="doctor_remittancereport.php" class="nav-link active">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Doctor Remittance</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="fulldrstatementdetail.php" class="nav-link">
                            <i class="fas fa-file-invoice"></i>
                            <span>Doctor Statement</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="doctorwiserevenuereport.php" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Doctor Revenue</span>
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
                    <h2>Doctor Remittance Report</h2>
                    <p>Comprehensive remittance tracking and payment management for doctors with detailed transaction history.</p>
                </div>
                <div class="page-header-actions">
                    <button type="button" class="btn btn-secondary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline" onclick="printPage()">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>

<table width="101%" border="0" cellspacing="0" cellpadding="2">






      <tr>

        <td width="860">

		

		

            <!-- Doctor Remittance Report Form Section -->
            <div class="form-section">
                <div class="form-header">
                    <i class="fas fa-money-bill-wave form-icon"></i>
                    <h3 class="form-title">Doctor Remittance Report Search</h3>
                </div>

              <form name="cbform1" method="post" action="doctor_remittancereport.php">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="searchsuppliername" class="form-label">Search Doctor</label>
                            <input name="searchsuppliername" type="text" id="searchsuppliername" 
                                   value="<?php echo $searchsuppliername; ?>" 
                                   class="form-input" autocomplete="off" 
                                   placeholder="Enter doctor name to search..." />
                            <input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" 
                                   onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" 
                                   style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" />
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <div class="date-input-group">
                                <input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>" 
                                       class="form-input date-input" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" 
                                     class="date-picker-icon" style="cursor:pointer"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <div class="date-input-group">
                                <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>" 
                                       class="form-input date-input" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" 
                                     class="date-picker-icon" style="cursor:pointer"/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                        <button type="submit" class="submit-btn" onClick="return funcAccount();">
                            <i class="fas fa-search"></i>
                            Search Remittances
                        </button>
                        <button name="resetbutton" type="reset" id="resetbutton" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

       <tr>

            <!-- Doctor Remittance Report Results Section -->
            <div class="report-section">
                <div class="report-header">
                    <h3 class="report-title">Doctor Remittance Report Results</h3>
                    <div class="report-actions">
                        <button type="button" class="btn btn-outline" onclick="exportToExcel()">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </button>
                        <button type="button" class="btn btn-outline" onclick="exportToPDF()">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </button>
                    </div>
                </div>
                
                <table class="modern-table remittance-table" id="AutoNumber3">

          <tbody>

            <tr>

			  <td colspan="8" bgcolor="#FFF" class="bodytext31"><strong>Doctor Remittance</strong></td>  

              <td width="14%" bgcolor="#FFF" class="bodytext31">&nbsp;</td>

            </tr>

			<?php

				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];

				if ($cbfrmflag1 == 'cbfrmflag1')

				{

					$arraysuppliercode = '';

					$arraysuppliername = '';

					if($searchsuppliername != "")

					{

					$arraysupplier = explode("#", $searchsuppliername);

					$arraysuppliername = $arraysupplier[0];

					$arraysuppliername = trim($arraysuppliername);

					$arraysuppliercode = $arraysupplier[1];

					}		
					
					
							

			     }

				?>

			<?php

			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

			if ($cbfrmflag1 == 'cbfrmflag1')

			{

		   	?>

            <tr>

              <td width="5%"  align="left" valign="center" 

                bgcolor="#ccc" class="bodytext31"><strong>No.</strong></td>

              <td width="8%" align="left" valign="center"  

                bgcolor="#ccc" class="bodytext31"><div align="left"><strong>Date</strong></div></td>

				<td width="8%" align="left" valign="center"  

                bgcolor="#ccc" class="bodytext31"><strong>Doc No </strong></td>

              <td width="30%" align="left" valign="center"  

                bgcolor="#ccc" class="bodytext31"><strong> Doctorcode </strong></td>

              <td width="10%" align="left" valign="center"  

                bgcolor="#ccc" class="bodytext31"><strong>Cheque No</strong></td>

				<td width="16%" align="left" valign="center"  

                bgcolor="#ccc" class="bodytext31"><strong>Bank Name</strong></td>

              <td width="9%" align="right" valign="center"  

                bgcolor="#ccc" class="bodytext31"><strong>Amount</strong></td>

				 <td width="14%" align="center" valign="center"  

                bgcolor="#ccc" class="bodytext31"><strong>Remarks</strong></td>
				
				<td width="14%" align="center" valign="center"  

                bgcolor="#ccc" class="bodytext31"><strong>Action</strong></td>

 <td class="bodytext31"  valign="center"  align="left"> 
               <a target="_blank" href="print_doctorremittance_xls.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&arraysuppliercode=<?php echo $arraysuppliercode; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a>
            </td>


              </tr>

			<?php

		

			
			

			$totalamount = 0;

			$query5 = "select doctorcode, doctorname from master_transactiondoctor where  doctorcode LIKE '%$arraysuppliercode%' group by doctorcode";

			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

			$num=mysqli_num_rows($exec5);

			while ($res5 = mysqli_fetch_array($exec5))

			{

			$doctorcode1 = $res5['doctorcode'];

			$doctorname1 = $res5['doctorname'];

			$totalamount = 0;

			?>

			<tr>

			<td colspan="9" bgcolor="#FFF" class="bodytext31" valign="center"  align="left"><strong><?php echo $doctorname1; ?></strong></td>

			</tr>

		    <?php

		    $query3 = "select transactiondate,docno,doctorname,chequenumber,bankname,sum(transactionamount) as transactionamount,remarks from master_transactiondoctor where   doctorcode = '$doctorcode1' and transactiondate between '$ADate1' and '$ADate2' group by docno";

			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

			$num=mysqli_num_rows($exec3);

			while ($res3 = mysqli_fetch_array($exec3))

			{

				//echo $res3['auto_number'];
				$transactiondate = $res3['transactiondate'];

				$docno = $res3['docno'];

				$transactionamount = $res3['transactionamount'];
			
				$doctorname = $res3['doctorname'];

				$chequenumber = $res3['chequenumber'];

				$remarks = $res3['remarks'];

				$bank = $res3['bankname'];


				$totalamount = $totalamount + $transactionamount;
				$totalamount1 = $totalamount1 + $transactionamount;

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

			

           <tr <?php  echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>

               <td class="bodytext31" valign="center"  align="left"> <div class="bodytext31"><?php echo $transactiondate; ?></div></td>

              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31"> <?php echo $docno; ?> </div>
             </td>

              <td class="bodytext31" valign="center"  align="left"><?php echo $doctorname; ?></td>

              <td class="bodytext31" valign="center"  align="left"><?php echo $chequenumber; ?></td>

			  <td class="bodytext31" valign="center"  align="left"><?php echo $bank; ?></td>

              <td class="bodytext31" valign="center"  align="right"> <div align="right"><?php echo number_format($transactionamount,2,'.',',');?></div></td>

				<td class="bodytext31" valign="center"  align="center"><?php echo $remarks; ?></td>
				
				<td class="bodytext31" valign="center"  align="center"><a href="print_doctorremittances.php?docno=<?php echo $docno; ?>" target="_blank">Print</a></td>
				
				
               </tr>

		   <?php

		   }  

		   ?>

		   <tr>

		    <td colspan="6" class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong>Sub Total :</strong></td>

			<td bgcolor="#CCC" class="bodytext31" valign="center"  align="right"><strong><?php echo number_format($totalamount,2); ?></strong></td>

			 <td class="bodytext31"  colspan="2" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

			</tr>

		   <?php

		   }

		   ?>

			<tr>

		    <td colspan="6" class="bodytext31" valign="center"  align="right" 

                bgcolor="#ecf0f5"><strong> Total :</strong></td>

			<td bgcolor="#CCC" class="bodytext31" valign="center"  align="right"><strong><?php echo number_format($totalamount1,2); ?></strong></td>

			 <td class="bodytext31" valign="center" colspan="2"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

			</tr>

			

            <tr>

              <td class="bodytext31" colspan="2" valign="center"  align="left" 

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

            </tr>

			  </tbody>

        </table></td>

      </tr>

			<?php

			}

			?>

</table>





                </table>
            </div>
        </main>
    </div>
</body>
</html>


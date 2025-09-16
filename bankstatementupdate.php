<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
include ("includes/check_user_access.php");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$dateonly = date("Y-m-d");
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$runningbalance = 0;
$totalunpre = 0;
$totalunclr = 0;

// Handle form submission and search parameters
if (isset($_REQUEST["frmflg1"])) { 
    $frmflg1 = $_REQUEST["frmflg1"]; 
} else { 
    $frmflg1 = ""; 
}

if (isset($_REQUEST["ADate1"])) { 
    $transactiondatefrom = $_REQUEST["ADate1"]; 
} else { 
    $transactiondatefrom = date("Y-m-d"); 
}

if (isset($_REQUEST["ADate2"])) { 
    $transactiondateto = $_REQUEST["ADate2"]; 
} else { 
    $transactiondateto = date("Y-m-d"); 
}

if (isset($_REQUEST["referenceno"])) { 
    $referenceno = $_REQUEST["referenceno"]; 
} else { 
    $referenceno = ""; 
}

if (isset($_REQUEST["bankname"])) { 
    $bankfullname = $_REQUEST["bankname"];
} else { 
    $bankfullname = "";
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Statement Update - MedStar</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="css/bankstatementupdate-modern.css?v=<?php echo time(); ?>">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<script type="text/javascript">
	

	$(document).ready(function(){



	$( ".edititem" ).click(function() {


		console.log('in edit item')
		

		var clickedid = $(this).attr('id');

		var current_expdate = $('tr#'+clickedid).find("div.expdate").text();

		//var current_expdate = $('#uiexpirydate_'+clickedid).text();
		

		//alert(current_expdate)
		//var current_batch = $('tr#'+clickedid).find("div.updatebatch").text();

		$('tr#'+clickedid).find("td.expirydatetd").show();

		$('tr#'+clickedid).find("td.expirydatetdstatic").hide();

		//$('tr#'+clickedid).find("td.batchupdatetd").show();
		//$('tr#'+clickedid).find("td.batchupdatestatic").hide();
        //$('#batchupdate_'+clickedid).val(current_batch);

		$('#expdate_'+clickedid).val(current_expdate);

		$('#s_'+clickedid).show();

		return false;

	})	





	$( ".saveitem" ).click(function() {



		

		var clickedid = $(this).attr('id');

		var idstr = clickedid.split('s_');

		var id = idstr[1];

		var expiry_date = $('#expdate_'+id).val();

		var autonumber = $('#autonumber_'+id).val(); 


		var chequedate = $('#chequedate_'+id).val();

		var bankdate = expiry_date;
	
	

	  var chequedate = new Date(chequedate);
	  var date1 = chequedate.getTime();  
	  
	  var expiry_date = new Date(expiry_date);
	  var date2 = expiry_date.getTime();
  
  	if(date1 > date2){
		alert('Statement Date should not be less than Transaction Date');
		
		return false;
	}

		

		$.ajax({

		  url: 'ajax/bankstmtdateupdate.php',

		  type: 'POST',

		  //async: false,

		  dataType: 'json',

		  //processData: false,    

		  data: { 

		      autonumber: autonumber, 
		      bankdate:bankdate

		  },

		  success: function (data) { 

		  	//alert(data)

		  	

		  	var msg = data.msg;

		  	if(data.status == 1)

		  	{

		  		$('#expirydate_'+id).val(bankdate);
		  		

		  		$('tr#'+id).find("td.expirydatetd").hide();

				$('tr#'+id).find("td.expirydatetdstatic").show();

				

				$('#uiexpirydate_'+id).text(bankdate);

				

				$('#s_'+id).hide();



		  	}

		  	else

		  	{

		  		alert(msg);

		  	}

		  	

		  }

		});

		return false;

	})	

	

})

</script>
    <!-- Modern Header -->
    <header class="modern-header">
        <div class="header-content">
            <div class="logo-section">
                <h1><i class="fas fa-university"></i> MedStar</h1>
                <span class="system-name">Bank Statement Update</span>
            </div>
            <div class="user-info-bar">
                <span class="welcome-text">Welcome, <strong><?php echo htmlspecialchars($username); ?></strong></span>
                <span class="location-info">📍 Company: <?php echo htmlspecialchars($companyname); ?></span>
            </div>
            <div class="header-actions">
                <a href="mainmenu1.php" class="btn btn-outline">🏠 Main Menu</a>
                <a href="logout.php" class="btn btn-outline">🚪 Logout</a>
            </div>
        </div>
    </header>

    <!-- Breadcrumb Navigation -->
    <nav class="nav-breadcrumb">
        <div class="breadcrumb-content">
            <a href="mainmenu1.php">🏠 Home</a>
            <span class="breadcrumb-separator">›</span>
            <span class="current-page">Bank Statement Update</span>
        </div>
    </nav>

    <!-- Main Container with Sidebar -->
    <div class="main-container-with-sidebar">
        <!-- Left Sidebar -->
        <aside class="left-sidebar">
            <nav class="sidebar-nav">
                <div class="nav-section">
                    <h3><i class="fas fa-chart-line"></i> Financial Management</h3>
                    <ul class="nav-menu">
                        <li>
                            <a href="mainmenu1.php" class="nav-link">
                                <i class="fas fa-home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="addaccountsmain.php" class="nav-link">
                                <i class="fas fa-plus-circle"></i>
                                <span>Add Accounts Main</span>
                            </a>
                        </li>
                        <li>
                            <a href="addaccountssub.php" class="nav-link">
                                <i class="fas fa-plus-square"></i>
                                <span>Add Accounts Sub</span>
                            </a>
                        </li>
                        <li>
                            <a href="addbank1.php" class="nav-link">
                                <i class="fas fa-university"></i>
                                <span>Add Bank</span>
                            </a>
                        </li>
                        <li>
                            <a href="bankreconupdate.php" class="nav-link">
                                <i class="fas fa-sync-alt"></i>
                                <span>Bank Reconciliation</span>
                            </a>
                        </li>
                        <li>
                            <a href="payrollbankreport1.php" class="nav-link">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <span>Payroll Bank Report</span>
                            </a>
                        </li>
                        <li>
                            <a href="banktransactionstatement.php" class="nav-link">
                                <i class="fas fa-file-alt"></i>
                                <span>Bank Transaction Statement</span>
                            </a>
                        </li>
                        <li>
                            <a href="bankstatementupdate.php" class="nav-link active">
                                <i class="fas fa-edit"></i>
                                <span>Bank Statement Update</span>
                            </a>
                        </li>
                        <li>
                            <a href="vat.php" class="nav-link">
                                <i class="fas fa-percentage"></i>
                                <span>VAT Management</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Page Header -->
            <div class="page-header">
                <h2><i class="fas fa-edit"></i> Bank Statement Update</h2>
                <p>Update bank statement dates for transactions</p>
            </div>

            <!-- Alert Messages -->
            <div class="alert-container">
                <?php if (!empty($errmsg)): ?>
                    <div class="alert alert-<?php echo $bgcolorcode === 'success' ? 'success' : ($bgcolorcode === 'failed' ? 'error' : 'info'); ?>">
                        <i class="fas fa-<?php echo $bgcolorcode === 'success' ? 'check-circle' : ($bgcolorcode === 'failed' ? 'exclamation-triangle' : 'info-circle'); ?> alert-icon"></i>
                        <span><?php echo htmlspecialchars($errmsg); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Search Form Section -->
            <div class="search-form-section">
                <form id="bankStatementForm" method="post" action="bankstatementupdate.php" class="add-form">
                    <div class="form-group">
                        <label for="referenceno" class="form-label">Transaction Reference Number</label>
                        <input type="text" name="referenceno" id="referenceno" 
                               value="<?php echo htmlspecialchars($referenceno); ?>" 
                               class="form-input" placeholder="Enter transaction reference number" />
                    </div>
                    <div class="form-group">
                        <button type="submit" id="submitBtn" class="submit-btn">
                            <i class="fas fa-search"></i>
                            Search Transactions
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                    <input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
                </form>
            </div>

            <!-- Data Table Section -->
            <div class="data-table-section">
                <?php
                $sno = 0;
                if (isset($_REQUEST["frmflag1"])) { 
                    $frmflag1 = $_REQUEST["frmflag1"]; 
                } else { 
                    $frmflag1 = ""; 
                }

                if ($frmflag1 == 'frmflag1') {
                    if (isset($_REQUEST["ADate1"])) { 
                        $ADate1 = $_REQUEST["ADate1"]; 
                    } else { 
                        $ADate1 = ""; 
                    }

                    if (isset($_REQUEST["ADate2"])) { 
                        $ADate2 = $_REQUEST["ADate2"]; 
                    } else { 
                        $ADate2 = ""; 
                    }

                    if ($ADate1 != '' && $ADate2 != '') {
                        $transactiondatefrom = $_REQUEST['ADate1'];
                        $transactiondateto = $_REQUEST['ADate2'];
                    } else {
                        $transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
                        $transactiondateto = date('Y-m-d');
                    }
                    $bankname = $bankfullname;
                ?>
                
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Transaction Date</th>
                                <th>Statement Date</th>
                                <th>Description</th>
                                <th>Transaction Ref No</th>
                                <th>Money In</th>
                                <th>Money Out</th>
                                <th>Action</th>
                                <th>Update</th>
                            </tr>
                        </thead>
                        <tbody>

				  <?php

				  $totatlmoneyin = 0;

				  $totatlmoneyout = 0;

				  $totatlrunningbal = 0;

				  $moneyin = 0;

				  $moneyout = 0;

				  $runningbalancecalc =0;

				  $temp = 0;

				  $runningbalance = 0;

				  $sno=0;

				  $opening = 0;

				  $query_acc = "select * from master_accountname where id = '$bankname'";

				  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_acc) or die ("Error in query_acc".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $res1 = mysqli_fetch_array($exec1);

				  $currency = $res1['currency'];

				  $cur_qry = "select * from master_currency where currency like '$currency'";

				  $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $cur_qry) or die ("Error in cur_qry".mysqli_error($GLOBALS["___mysqli_ston"]));

				  $res21 = mysqli_fetch_array($exec21);

				  $fxrate = $res21['rate'];

				  if($fxrate == 0.00)

				  {

					  $fxrate = 1.00;

				  }

				  $incr = 0;
				  $qrybankstatements = "SELECT auto_number,postdate,chequedate,bankdate,remarks,docno,bankamount,notes,status,bankcode FROM bank_record WHERE docno like '%$referenceno%'";

					$excebankstatements = mysqli_query($GLOBALS["___mysqli_ston"], $qrybankstatements) or die("Error in qrybankstatements".mysqli_error($GLOBALS["___mysqli_ston"]));

			

					while($resbankstatement = mysqli_fetch_array($excebankstatements))

					{

						
					  $postingdate = $resbankstatement["chequedate"];

					  $valuedate = $resbankstatement["bankdate"];

					  $description = $resbankstatement["remarks"];

					  $transrefno = $resbankstatement["docno"];

					  $notes = $resbankstatement["notes"];

					  $status = $resbankstatement["status"];

					  $auto_number = $resbankstatement["auto_number"];

					  $bankcode = $resbankstatement["bankcode"];

					  	if($incr == 0){

							 $query_acc = "select * from master_accountname where id = '$bankcode'";

							  $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_acc) or die ("Error in query_acc".mysqli_error($GLOBALS["___mysqli_ston"]));

							  $res1 = mysqli_fetch_array($exec1);

							  $currency = $res1['currency'];

							  $cur_qry = "select * from master_currency where currency like '$currency'";

							  $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $cur_qry) or die ("Error in cur_qry".mysqli_error($GLOBALS["___mysqli_ston"]));

							  $res21 = mysqli_fetch_array($exec21);

							  $fxrate = $res21['rate'];

							  if($fxrate == 0)

							  {

								  $fxrate = 1;

							  }
						}

						$query2 = "select amount, creditamount from bankentryform where docnumber = '$transrefno' and (frombankid = '$bankcode' or tobankid = '$bankcode')";

						$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res2 = mysqli_fetch_array($exec2);

						$num2 = mysqli_num_rows($exec2);

						$dramount = $res2['amount'];

						$cramount = $res2['creditamount'];

						if($num2 == 0)

						{

							//MONEY IN  -- notes type is accountrecievelbe

							if($notes == 'accounts receivable')

							{

								if($status == 'Unpresented')

								{

									$moneyin = 0;

									$moneyout = $resbankstatement["bankamount"];

									$totalunpre = $resbankstatement["bankamount"];

								}

								else if($status == 'Uncleared')

								{

									$moneyin = 	$resbankstatement["bankamount"];

									$moneyout = 0;

									$totalunclr = $resbankstatement["bankamount"];

								}

								else

								{

									$moneyin = 	$resbankstatement["bankamount"];

									$moneyout = 0;

								}

							}

							else //MONEY OUT

							{

								$moneyout = abs($resbankstatement["bankamount"]);

								$moneyin = 0;

							}

						}

						else

						{

							$moneyin = 	$dramount;

							$moneyout = $cramount;

						}	

						

						$moneyin = $moneyin/$fxrate;

						$moneyout = $moneyout/$fxrate;

						$runningbalance = $runningbalance + $moneyin - $moneyout;

						

						

						

						//TOTALS

						$totatlmoneyin = $totatlmoneyin + $moneyin;

						$totatlmoneyout = $totatlmoneyout + $moneyout;

						//$totatlrunningbal = $totatlrunningbal + $runningbalance;

						

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
							$sno = $sno+1;
				  ?>

                            <tr id="<?php echo $sno; ?>">
                                <td><?php echo $sno; ?></td>
                                <td><?php echo htmlspecialchars($postingdate); ?>
                                    <input type="hidden" id="chequedate_<?php echo $sno?>" value="<?php echo $postingdate;?>">
                                </td>
                                <td class="expirydatetd" style="display:none;">
                                    <input class="form-input expdatepicker" id="expdate_<?php echo $sno;?>" name="expdate[]" 
                                           value="" size="10" readonly="readonly" onKeyDown="return disableEnterKey()" />
                                    <i class="fas fa-calendar-alt date-picker-icon" 
                                       onClick="javascript:NewCssCal('expdate_<?php echo $sno;?>','yyyyMMdd','','','','','')" 
                                       style="cursor:pointer"></i>
                                </td>
                                <td class="expirydatetdstatic">
                                    <div class="expdate" id="uiexpirydate_<?php echo $sno;?>">
                                        <?php echo htmlspecialchars($valuedate); ?>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($description.' ('.$status.')'); ?></td>
                                <td>
                                    <span class="ref-number-badge"><?php echo htmlspecialchars($transrefno); ?></span>
                                </td>
                                <td>
                                    <?php if($moneyin > 0): ?>
                                        <span class="money-in-badge"><?php echo number_format($moneyin,2,'.',','); ?></span>
                                    <?php else: ?>
                                        <span class="amount-zero">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($moneyout > 0): ?>
                                        <span class="money-out-badge"><?php echo number_format($moneyout,2,'.',','); ?></span>
                                    <?php else: ?>
                                        <span class="amount-zero">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-outline edititem" id="<?php echo $sno; ?>" href="">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <input type="hidden" id="autonumber_<?php echo $sno?>" value="<?php echo $auto_number;?>">
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-primary saveitem" id="s_<?php echo $sno; ?>" href="" style="display:none;">
                                        <i class="fas fa-save"></i> Update
                                    </a>
                                </td>
                            </tr>

                            <?php
                            $incr += 1;
                            } // Close while loop
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php } // Close if ($frmflag1 == 'frmflag1') ?>
            </div>
        </main>
    </div>

    <!-- Modern JavaScript -->
    <script src="js/bankstatementupdate-modern.js?v=<?php echo time(); ?>"></script>
</body>
</html>




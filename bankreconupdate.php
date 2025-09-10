<?php

session_start();

error_reporting(0);

include ("includes/loginverify.php");

include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$timeonly = date('H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = '';

$transactiondateto = date('Y-m-d');

$errmsg = "";

$bgcolorcode = "";



if (isset($_REQUEST["frmflg1"])) { $frmflg1 = $_REQUEST["frmflg1"]; } else { $frmflg1 = ""; }


if($frmflg1 == 'frmflg1')

{
	
	//$aprows = $_REQUEST['apnums'];
	$aprows = 1;

	/*$arrows = $_REQUEST['arnums'];

	$exrows = $_REQUEST['exnums'];

	$rerows = $_REQUEST['renums'];

	$bkrows = $_REQUEST['bknums'];

	$apjrows = $_REQUEST['apjnums'];*/

	//accounts receivable

	if($aprows > 0)

	{ 

		for($i=1;$i<=$aprows;$i++)

		{

			//$apstatus = $_REQUEST['apstatus'.$i];

			$apdate = $_REQUEST['apdate'];

			//if($apstatus != 'Pending')

			if($apdate != '')

			{
				$auto_number = $apno = $_REQUEST['apno'];
				$apaccountname = $_REQUEST['apaccountname'.$i];

				$apdocno = $_REQUEST['apdocno'.$i];

				$apchequeno = $_REQUEST['apchequeno'.$i];

				$aptransactionamount = $_REQUEST['aptransactionamount'.$i];

				$aptransactiondate = $_REQUEST['aptransactiondate'.$i];

				$apchequedate  = $_REQUEST['apchequedate'.$i];

				$appostedby = $_REQUEST['appostedby'.$i];

				$apremarks = $_REQUEST['apremarks'.$i];

				$apdate = $_REQUEST['apdate'];

				//$apstatus = $_REQUEST['apstatus'.$i];

				$apstatus = "POSTED";

				$apbankname = $_REQUEST['apbankname'.$i];

				$apbankcode = $_REQUEST['apbankcode'.$i];

				$apbankamount = $_REQUEST['apbankamount'.$i];

				$apbankamount = str_replace(",", "", $apbankamount);



				/*$query15 = "insert into bank_record (description,docno,instno,amount,postdate,postby,chequedate,remarks,bankdate,status,ipaddress,username,companyanum,companyname,

				updateddate,updatedtime,bankname,bankcode,bankamount,notes)values('$apaccountname','$apdocno','$apchequeno','$aptransactionamount','$aptransactiondate','$appostedby','$apchequedate','$apremarks','$apdate',

				'$apstatus','$ipaddress','$username','$companyanum','$companyname','$transactiondateto','$timeonly','$apbankname','$apbankcode','$apbankamount','accounts receivable')";

				$exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());*/
				$query1 = "update bank_record set bankdate = '$apdate',updateddate='$transactiondateto',updatedtime='$timeonly',recon_date_update_flag='1'  where auto_number = '$auto_number'";
		     $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));		
				$errmsg = "Success. Bank Details Updated.";

				$bgcolorcode = 'success';
			 

			}

		}

	}

	//account payable

	/*if($arrows !=0)

	{ 

		for($i=1;$i<=$arrows;$i++)

		{

			//$arstatus = $_REQUEST['arstatus'.$i];
			$arstatus = "POSTED";

			$ardate = $_REQUEST['ardate'.$i];

			//if($arstatus != 'Pending')

			if($ardate != '')

			{

				$araccountname = $_REQUEST['araccountname'.$i];

				$ardocno = $_REQUEST['ardocno'.$i];

				$archequeno = $_REQUEST['archequeno'.$i];

				$artransactionamount = $_REQUEST['artransactionamount'.$i];

				$artransactiondate = $_REQUEST['artransactiondate'.$i];

				$archequedate  = $_REQUEST['archequedate'.$i];

				$arpostedby = $_REQUEST['arpostedby'.$i];

				$arremarks = $_REQUEST['arremarks'.$i];

				$ardate = $_REQUEST['ardate'.$i];

				$arbankname = $_REQUEST['arbankname'.$i];

				$arbankcode = $_REQUEST['arbankcode'.$i];

				$arbankamount = $_REQUEST['arbankamount'.$i];

				$arbankamount = str_replace(",", "", $arbankamount);

				$query16 = "insert into bank_record (description,docno,instno,amount,postdate,postby,chequedate,remarks,bankdate,status,ipaddress,username,companyanum,companyname,

				updateddate,updatedtime,bankname,bankcode,bankamount,notes)values('$araccountname','$ardocno','$archequeno','$artransactionamount','$artransactiondate','$arpostedby','$archequedate','$arremarks','$ardate',

				'$arstatus','$ipaddress','$username','$companyanum','$companyname','$transactiondateto','$timeonly','$arbankname','$arbankcode','$arbankamount','account payable')";

				$exec16 = mysql_query($query16) or die ("Error in Query16".mysql_error());

				$errmsg = "Success. Bank Details Updated.";

				$bgcolorcode = 'success';

			}

		}

	}

	//expenses

	if($exrows !=0)

	{ 

		for($i=1;$i<=$exrows;$i++)

		{	

			//$exstatus = $_REQUEST['exstatus'.$i];

			$exstatus = "POSTED";

			$exdate = $_REQUEST['exdate'.$i];

			//if($exstatus != 'Pending')
			if($exdate != '')

			{

				$exaccountname = $_REQUEST['exaccountname'.$i];

				$exdocno = $_REQUEST['exdocno'.$i];

				$exchequeno = $_REQUEST['exchequeno'.$i];

				$extransactionamount = $_REQUEST['extransactionamount'.$i];

				$extransactiondate = $_REQUEST['extransactiondate'.$i];

				$expostedby = $_REQUEST['expostedby'.$i];

				$exremarks = $_REQUEST['exremarks'.$i];

				$exdate = $_REQUEST['exdate'.$i];

				$exbankname = $_REQUEST['exbankname'.$i];

				$exbankcode = $_REQUEST['exbankcode'.$i];

				$exbankamount = $_REQUEST['exbankamount'.$i];

				$exbankamount = str_replace(",", "", $exbankamount);

				$query17 = "insert into bank_record (description,docno,instno,amount,postdate,postby,chequedate,remarks,bankdate,status,ipaddress,username,companyanum,companyname,

				updateddate,updatedtime,bankname,bankcode,bankamount,notes)values('$exaccountname','$exdocno','$exchequeno','$extransactionamount','$extransactiondate','$expostedby','$extransactiondate','$exremarks','$exdate',

				'$exstatus','$ipaddress','$username','$companyanum','$companyname','$transactiondateto','$timeonly','$exbankname','$exbankcode','$exbankamount','expenses')";

				$exec17 = mysql_query($query17) or die ("Error in Query17".mysql_error());

				$errmsg = "Success. Bank Details Updated.";

				$bgcolorcode = 'success';

			}

			

		}

	}

	//receipts

	if($rerows !=0)

	{ 

		for($i=1;$i<=$rerows;$i++)

		{

			//$restatus = $_REQUEST['restatus'.$i];

			$restatus = "POSTED";

			$redate = $_REQUEST['redate'.$i];

			//if($restatus != 'Pending')
			if($redate != '')

			{

				$reaccountname = $_REQUEST['reaccountname'.$i];

				$redocno = $_REQUEST['redocno'.$i];

				$rechequeno = $_REQUEST['rechequeno'.$i];

				$retransactionamount = $_REQUEST['retransactionamount'.$i];

				$retransactiondate = $_REQUEST['retransactiondate'.$i];

				$repostedby = $_REQUEST['repostedby'.$i];

				$reremarks = $_REQUEST['reremarks'.$i];

				$redate = $_REQUEST['redate'.$i];

				$rebankname = $_REQUEST['rebankname'.$i];

				$rebankcode = $_REQUEST['rebankcode'.$i];

				$rebankamount = $_REQUEST['rebankamount'.$i];

				$rebankamount = str_replace(",", "", $rebankamount);

				$query18 = "insert into bank_record (description,docno,instno,amount,postdate,postby,chequedate,remarks,bankdate,status,ipaddress,username,companyanum,companyname,

				updateddate,updatedtime,bankname,bankcode,bankamount,notes)values('$reaccountname','$redocno','$rechequeno','$retransactionamount','$retransactiondate','$repostedby','$retransactiondate','$reremarks','$redate',

				'$restatus','$ipaddress','$username','$companyanum','$companyname','$transactiondateto','$timeonly','$rebankname','$rebankcode','$rebankamount','receipts')";

				$exec18 = mysql_query($query18) or die ("Error in Query18".mysql_error());

				$errmsg = "Success. Bank Details Updated.";

				$bgcolorcode = 'success';

			}

		}

	}

	//banks

	if($bkrows !=0)

	{ 

		for($i=1;$i<=$bkrows;$i++)

		{

			//$bkstatus = $_REQUEST['bkstatus'.$i];

			$bkstatus = "POSTED";

			$bkdate = $_REQUEST['bkdate'.$i];

			//if($bkstatus != 'Pending')
			if($bkdate != '')

			{

				$bkaccountname = $_REQUEST['bkaccountname'.$i];

				$bkdocno = $_REQUEST['bkdocno'.$i];

				$bkchequeno = $_REQUEST['bkchequeno'.$i];

				$bktransactionamount = $_REQUEST['bktransactionamount'.$i];

				$bktransactiondate = $_REQUEST['bktransactiondate'.$i];

				$bkpostedby = $_REQUEST['bkpostedby'.$i];

				$bkremarks = $_REQUEST['bkremarks'.$i];

				$bkdate = $_REQUEST['bkdate'.$i];

				$bkbankname = $_REQUEST['bkbankname'.$i];

				$bkbankcode = $_REQUEST['bkbankcode'.$i];

				$bkbankamount = $_REQUEST['bkbankamount'.$i];

				$bkbankamount = str_replace(",", "", $bkbankamount);

				$query19 = "insert into bank_record (description,docno,instno,amount,postdate,postby,chequedate,remarks,bankdate,status,ipaddress,username,companyanum,companyname,

				updateddate,updatedtime,bankname,bankcode,bankamount,notes)values('$bkaccountname','$bkdocno','$bkchequeno','$bktransactionamount','$bktransactiondate','$bkpostedby','$bktransactiondate','$bkremarks','$bkdate',

				'$bkstatus','$ipaddress','$username','$companyanum','$companyname','$transactiondateto','$timeonly','$bkbankname','$bkbankcode','$bkbankamount','banks')";

				$exec19 = mysql_query($query19) or die ("Error in Query19".mysql_error());

				$errmsg = "Success. Bank Details Updated.";

				$bgcolorcode = 'success';

			}

		}

	}

	//journals

	if($apjrows !=0)

	{ 

		for($i=1;$i<=$apjrows;$i++)

		{

			//$apjstatus = $_REQUEST['apjstatus'.$i];

			$apjstatus = "POSTED";

			$apjdate = $_REQUEST['apjdate'.$i];

			//if($apjstatus != 'Pending')
			if($apjdate != '')

			{

				$apjaccountname = $_REQUEST['apjaccountname'.$i];

				$apjdocno = $_REQUEST['apjdocno'.$i];

				$apjchequeno = $_REQUEST['apjchequeno'.$i];

				$apjtransactionamount = $_REQUEST['apjtransactionamount'.$i];

				$apjtransactiondate = $_REQUEST['apjtransactiondate'.$i];

				$apjpostedby = $_REQUEST['apjpostedby'.$i];

				$apjremarks = $_REQUEST['apjremarks'.$i];

				$apjdate = $_REQUEST['apjdate'.$i];

				$apjbankname = $_REQUEST['apjbankname'.$i];

				$apjbankcode = $_REQUEST['apjbankcode'.$i];

				$apjbankamount = $_REQUEST['apjbankamount'.$i];

				$apjbankamount = str_replace(",", "", $apjbankamount);

				$query20 = "insert into bank_record (description,docno,instno,amount,postdate,postby,chequedate,remarks,bankdate,status,ipaddress,username,companyanum,companyname,

				updateddate,updatedtime,bankname,bankcode,bankamount,notes)values('$apjaccountname','$apjdocno','$apjchequeno','$apjtransactionamount','$apjtransactiondate','$apjpostedby','$apjtransactiondate','$apjremarks','$apjdate',

				'$apjstatus','$ipaddress','$username','$companyanum','$companyname','$transactiondateto','$timeonly','$apjbankname','$apjbankcode','$apjbankamount','journals')";

				$exec20 = mysql_query($query20) or die ("Error in Query20".mysql_error());

				$errmsg = "Success. Bank Details Updated.";

				$bgcolorcode = 'success';

			}

		}

	}*/

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Reconciliation Update - <?php echo $companyname; ?></title>
    <link rel="stylesheet" href="css/bankreconupdate-modern.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Alert Container -->
    <div id="alertContainer"></div>

    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title"><?php echo $companyname; ?></h1>
        <p class="hospital-subtitle">Bank Reconciliation Update System</p>
    </header>

    <!-- User Info Bar -->
    <div class="user-info-bar">
        <div class="user-info">
            <i class="fas fa-user"></i>
            <span>Welcome, <?php echo $username; ?></span>
        </div>
        <div class="datetime">
            <i class="fas fa-calendar"></i>
            <span><?php echo date('d M Y, h:i A'); ?></span>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <nav class="breadcrumb-nav">
        <div class="breadcrumb">
            <a href="index.php">Home</a>
            <span class="separator">/</span>
            <span>Bank Management</span>
            <span class="separator">/</span>
            <span>Reconciliation Update</span>
        </div>
    </nav>

    <!-- Floating Menu Toggle -->
    <button id="menuToggle" class="floating-menu-toggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Left Sidebar -->
        <aside id="leftSidebar" class="left-sidebar">
            <div class="sidebar-header">
                <h3>Navigation</h3>
                <button id="sidebarToggle" class="sidebar-toggle">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            <nav class="sidebar-nav">
                <?php include ("includes/menu1.php"); ?>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-title">
                    <h2><i class="fas fa-balance-scale"></i> Bank Reconciliation Update</h2>
                    <p>Update bank reconciliation details and transaction dates</p>
                </div>
                <div class="page-header-actions">
                    <button onclick="refreshPage()" class="btn btn-secondary">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                    <button onclick="exportToExcel()" class="btn btn-secondary">
                        <i class="fas fa-file-excel"></i> Export
                    </button>
                </div>
            </div>

            <!-- Alert Messages -->
            <?php if ($errmsg != ''): ?>
                <div class="alert alert-<?php echo ($bgcolorcode == 'success') ? 'success' : 'error'; ?>">
                    <i class="fas fa-<?php echo ($bgcolorcode == 'success') ? 'check-circle' : 'exclamation-triangle'; ?> alert-icon"></i>
                    <span><?php echo $errmsg; ?></span>
                </div>
            <?php endif; ?>

            <!-- Bank Reconciliation Form -->
            <section class="bank-recon-section">
                <div class="section-header">
                    <h3><i class="fas fa-university"></i> Bank Reconciliation Details</h3>
                </div>
                
                <form name="form1" id="form1" method="post" action="bankreconupdate.php" class="bank-recon-form">
                    <input type="hidden" name="frmflg1" id="frmflg1" value="frmflg1" />
                    
                    <div class="form-container">
                        <table class="recon-table">
                            <thead>
                                <tr>
                                    <th>Account Name</th>
                                    <th>Doc No</th>
                                    <th>Inst. No</th>
                                    <th>Amount</th>
                                    <th>Posting Date</th>
                                    <th>Cheque Date</th>
                                    <th>Posted By</th>
                                    <th>Remarks</th>
                                    <th>Bank Amount</th>
                                    <th>Bank Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $colorloopcount = '';
                                $apno = '';
                                $totalamount = '0.00';
                                $aptotalamount = '0.00';
                                $apposttotalamount = '0.00';
                                $artotalamount = '0.00';
                                $arposttotalamount = '0.00';
                                $extotalamount = '0.00';
                                $exposttotalamount = '0.00';
                                $retotalamount = '0.00';
                                $reposttotalamount = '0.00';
                                $bktotalamount = '0.00';
                                $bkposttotalamount = '0.00';
                                $apjtotalamount = '0.00';
                                $apjposttotalamount = '0.00';
                                $total_credit_amount = 0;
                                $total_debit_amount = 0;

                                if(true) {
                                    $post21 = '';
                                    $query21 = "select * from bank_record where docno = '$transaction_number' and bankcode='$bankname' limit 0,1";
                                    $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    $res21 = mysqli_fetch_array($exec21);
                                    
                                    $apposttotalamount = $apposttotalamount + $res21['amount'];
                                    $apposttotalamount = 0;
                                    $post21 = mysqli_num_rows($exec21);

                                    if($post21 > 0) {
                                        $auto_number = $res21['auto_number'];
                                        $apaccountname = strtoupper($res21['description']);
                                        $apdocno = $res21['docno'];
                                        $apchequeno = $res21['instno'];
                                        $aptransactionamount = $res21['amount'];
                                        $aptransactiondate = $res21['bankdate'];
                                        $apchequedate = $res21['chequedate'];
                                        $appostedby = $res21['postby'];
                                        $apremarks = $res21['remarks'];
                                        $debit_amount = '0.00';
                                        $credit_amount = '0.00';

                                        if($auto_number != '') {
                                ?>
                                <tr>
                                    <input name="apno<?php echo $apno; ?>" id="apno<?php echo $apno; ?>" value="<?php echo $auto_number; ?>" type="hidden"/>
                                    <input name="apbankname<?php echo $apno; ?>" id="apbankname<?php echo $apno; ?>" type="hidden" value="<?php echo $apbankname; ?>">
                                    <input name="apbankcode<?php echo $apno; ?>" id="apbankcode<?php echo $apno; ?>" type="hidden" value="<?php echo $apbankcode; ?>">
                                    
                                    <td class="account-name">
                                        <?php echo $apaccountname; ?>
                                        <input name="apaccountname<?php echo $apno; ?>" id="apaccountname<?php echo $apno; ?>" value="<?php echo $apaccountname; ?>" type="hidden"/>
                                    </td>
                                    
                                    <td class="doc-no">
                                        <?php echo $apdocno; ?>
                                        <input name="apdocno<?php echo $apno; ?>" id="apdocno<?php echo $apno; ?>" value="<?php echo $apdocno; ?>" type="hidden"/>
                                    </td>
                                    
                                    <td class="inst-no">
                                        <?php echo $apchequeno; ?>
                                        <input name="apchequeno<?php echo $apno; ?>" id="apchequeno<?php echo $apno; ?>" value="<?php echo $apchequeno; ?>" type="hidden"/>
                                    </td>
                                    
                                    <td class="amount">
                                        <?php echo number_format($aptransactionamount,2,'.',','); ?>
                                        <input name="aptransactionamount<?php echo $apno; ?>" id="aptransactionamount<?php echo $apno; ?>" value="<?php echo $aptransactionamount; ?>" type="hidden"/>
                                    </td>
                                    
                                    <td class="posting-date">
                                        <?php echo $aptransactiondate; ?>
                                        <input name="aptransactiondate<?php echo $apno; ?>" id="aptransactiondate<?php echo $apno; ?>" value="<?php echo $aptransactiondate; ?>" type="hidden"/>
                                    </td>
                                    
                                    <td class="cheque-date">
                                        <?php echo $apchequedate; ?>
                                        <input name="apchequedate<?php echo $apno; ?>" id="apchequedate<?php echo $apno; ?>" value="<?php echo $apchequedate; ?>" type="hidden"/>
                                        <input name="aprecentdate<?php echo $apno; ?>" id="aprecentdate<?php echo $apno; ?>" value="<?php echo $bankrecent_date; ?>" type="hidden"/>
                                    </td>
                                    
                                    <td class="posted-by">
                                        <?php echo $appostedby; ?>
                                        <input name="appostedby<?php echo $apno; ?>" id="appostedby<?php echo $apno; ?>" value="<?php echo $appostedby; ?>" type="hidden"/>
                                    </td>
                                    
                                    <td class="remarks">
                                        <?php echo $apremarks; ?>
                                        <input name="apremarks<?php echo $apno; ?>" id="apremarks<?php echo $apno; ?>" value="<?php echo $apremarks; ?>" type="hidden"/>
                                    </td>
                                    
                                    <td class="bank-amount">
                                        <input name="apbankamount<?php echo $apno; ?>" id="apbankamount<?php echo $apno; ?>" 
                                               value="<?php echo number_format($aptransactionamount,2,'.',','); ?>" 
                                               class="form-input" readonly />
                                    </td>
                                    
                                    <td class="bank-date">
                                        <input name="apdate" id="apdate" value="" 
                                               class="form-input datepicker" 
                                               placeholder="Select Date" readonly />
                                    </td>
                                    
                                    <td class="action">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Save
                                        </button>
                                    </td>
                                </tr>
                                <?php
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <input name="formdate" id="formdate" value="<?php echo $ADate2; ?>" type="hidden"/>
                    <input type="hidden" name="todaysdate" id="todaysdate" value="<?= date("Y-m-d"); ?>">
                </form>
            </section>
        </main>
    </div>

    <!-- Footer -->
    <?php include ("includes/footer1.php"); ?>

    <!-- Scripts -->
    <script src="js/bankreconupdate-modern.js"></script>
</body>
</html>

<?php 
function getcreditdebitor($refno,$aptransactionamount)
{
	
	$debit_amount = '0.00';
	$credit_amount = '0.00';
	$haystack = $refno;
	$needle   = "AR";
	if( strpos( $haystack, $needle ) !== false) {
		
		$debit_amount = $aptransactionamount;
		$credit_amount = '0.00';
	}
	else
	{
		$debit_amount = '0.00';
		$needle   = "SPE";
		if( strpos( $haystack, $needle ) !== false) {
		
			$credit_amount = $aptransactionamount;
		}
		else
		{
			$credit_amount = '0.00';
			$needle   = "RE";
			if( strpos( $haystack, $needle ) !== false) {
		
				$debit_amount = $aptransactionamount;
				$credit_amount = '0.00';
			}
			else
			{
				$debit_amount = '0.00';

				$needle   = "BE";
				if( strpos( $haystack, $needle ) !== false) {
		
					$credit_amount = $aptransactionamount;
				}
				else
				{
					$credit_amount = '0.00';
					//FOR DOCTORS PAYMENT ENTRY
					$debit_amount = '0.00';
					$needle   = "DP";
					if( strpos( $haystack, $needle ) !== false) {
					
						$credit_amount = $aptransactionamount;
					}
					else{
						$credit_amount = '0.00';
						
					}
				}
			}

		}
	}

	$needle   = "EN";
	if( strpos( $haystack, $needle ) !== false) {
	
		if($aptransactionamount<0)
			$credit_amount = abs($aptransactionamount);
		else
			$debit_amount = abs($aptransactionamount);
	}



	$amount['debit_amount'] = $debit_amount;
	$amount['credit_amount'] = $credit_amount;
	return $amount;
		    
}
?>
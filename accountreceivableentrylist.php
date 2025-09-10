<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$sno=0;

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');



$errmsg = "";

$banum = "1";

$supplieranum = "";

$custid = "";

$custname = "";

$balanceamount = "0.00";

$openingbalance = "0.00";

$searchsuppliername = "";

$cbsuppliername = "";

/////////////// FOR DELETE //////////////
if (isset($_REQUEST["del"])) { $del= $_REQUEST["del"]; } else { $del = ""; }
if($del != ''){
	$tbl = $_REQUEST['tbl'];
	$doc = $_REQUEST['docno'];
	$query_del1 = "UPDATE `$tbl` SET transactionamount = '0', cashamount ='0', onlineamount='0',creditamount='0',chequeamount='0',cardamount='0',mpesaamount='0',fxamount='0',receivableamount='0' WHERE docno LIKE '$doc'";
	//echo $query_del1;
	$exec_del1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_del1) or die ("Error in Query_del1".mysqli_error($GLOBALS["___mysqli_ston"]));

	$query2 = "UPDATE `excel_insurance_upload` SET `status`='0' WHERE `docno`='$doc'  ";
	// and upload_id='$uploadid'
	$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

}
/////////////// FOR DELETE //////////////

 
if(isset($_GET['searchdocno'])){ $searchdocno1=$_GET['searchdocno'];  }
if(isset($_GET['searchaccount'])){ $searchaccount1=$_GET['searchaccount'];  }
// if($_GET['searchaccount']==""){ $searchaccount1=$_GET['searchaccount'];  }
if(isset($_GET['fromdate'])){ $fromdate1=$_GET['fromdate'];  }
if(isset($_GET['todate'])){ $todate1=$_GET['todate'];  }

  if (isset($_REQUEST["search_type"])) { $search_type = $_REQUEST["search_type"]; } else { $search_type = "0"; }  
if (isset($_REQUEST["frmflag_upload"])) { $frmflag_upload = $_REQUEST["frmflag_upload"]; } else { $frmflag_upload = ""; }
///////////////////// EXCEL //////// UPLOAD ////////
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);

	
	 $locationname  = $res["locationname"];
	  $locationcode123 = $res["locationcode"];
	  $locationcode = $res["locationcode"];
	 $res12locationanum = $res["auto_number"];

  $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

function readCSV($csvFile){

    $file_handle = fopen($csvFile, 'r');

    while (!feof($file_handle) ) {

        $line_of_text[] = fgetcsv($file_handle, 1024);

    }

    fclose($file_handle);
    // return false;
    return $line_of_text;
    // window.location
 //    $searchaccount = $_POST['searchsuppliername'];
	// $searchdocno=$_POST['docno'];
	// $fromdate=$_POST['ADate1'];
	// $todate=$_POST['ADate2'];

}
if (isset($_REQUEST["frmflag_upload"]))
{	
	foreach($_POST['docno_post'] as $key => $value){

	 $docno_get=$_POST['docno_post'][$key];
	 $subtype_get=$_POST['subtype'][$key];
	 $ar_amount=$_POST['ar_amount'][$key];
	 // $upload_file=$_POST['upload_file'][$key];
	 if(!empty($_FILES['upload_file']))
{

	// UPDATE STATUS AS ZERO FOR THE DOC NUMBER //
	 // $query2 = "UPDATE `excel_insurance_upload` SET `status`='0' WHERE `docno`='$docno_get'";
	// $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	// UPDATE STATUS AS ZERO FOR THE DOC NUMBER //

	// $res2 = mysql_fetch_array($exec2);
	// $billnumber = $res2["billnumber"];
		// echo $locationcode = $_POST['locationcode'];


	$query3 = "SELECT auto_number FROM `master_subtype` where subtype='$subtype_get' ";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res3 = mysqli_fetch_array($exec3);
	$subtype_code = $res3["auto_number"];
	$amount_check=0;

	 $query_alloc = "SELECT sum(amount) as alloc_amounrt_final FROM `excel_insurance_upload` WHERE docno='$docno_get' and status='1' ";
	$exec_alloc = mysqli_query($GLOBALS["___mysqli_ston"], $query_alloc) or die ("Error in query_alloc".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res_alloc = mysqli_fetch_array($exec_alloc);
	$value_of_alloc = $res_alloc['alloc_amounrt_final'];
	if($value_of_alloc == ""){
		$value_of_alloc=0;
	}

			$query_allocated_amount = "SELECT sum(transactionamount) as amount, sum(discount) as discount from master_transactionpaylater where  recordstatus='allocated' and docno='$docno'";
			$exec_allocated_amount = mysqli_query($GLOBALS["___mysqli_ston"], $query_allocated_amount) or die ("Error in Query_allocated_amount".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res_allocated_amount = mysqli_fetch_array($exec_allocated_amount)){
			$allocated_amount=$res_allocated_amount['amount'];
			// $allocated_amount=$res_allocated_amount['amount']+$res_allocated_amount['discount'];
			}
	 $final_value = $ar_amount-$allocated_amount;
	 // $final_value = $ar_amount-$value_of_alloc;
	  // $final_value = number_format($final_value, 2);

		if(!empty($_FILES['upload_file']))

		{

		$inputFileName = $_FILES['upload_file']['tmp_name'];

		//print_r($_FILES['upload_file']);

		include 'phpexcel/Classes/PHPExcel/IOFactory.php';

		try {

    		$inputFileType = PHPExcel_IOFactory::identify($inputFileName);

			$objReader = PHPExcel_IOFactory::createReader($inputFileType);

		    $objPHPExcel = $objReader->load($inputFileName);

			$sheet = $objPHPExcel->getSheet(0); 

			$highestRow = $sheet->getHighestRow();

			$highestColumn = $sheet->getHighestColumn();

			$row = 1;

			$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,

                                    NULL,

                                    TRUE,

                                    FALSE)[0];

			foreach($rowData as $key=>$value)

			{
					$paynowbillprefix1 = 'EXUP-';
					$paynowbillprefix12=strlen($paynowbillprefix1);
					$query23 = "SELECT * from excel_insurance_upload order by auto_number desc limit 0, 1";
					$exec23= mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res23 = mysqli_fetch_array($exec23);
					$billnumber1 = $res23["upload_id"];
					$billdigit1=strlen($billnumber1);
					if ($billnumber1 == '')
					{
						$upload_exid ='EXUP-'.'1';
					}
					else
					{
						$billnumber1 = $res23["upload_id"];
						$upload_exid = substr($billnumber1,$paynowbillprefix12, $billdigit1);
						//echo $billnumbercode;
						$upload_exid = intval($upload_exid);
						$upload_exid = $upload_exid + 1;
						$maxanum1 = $upload_exid;
						$upload_exid = 'EXUP-'.$maxanum1;
					}
				
			// if($rowData[$key] == 'Doc No')

			//  $docno_xl = $key;

			//  if($rowData[$key] == 'Subtype')

			//  $subtype = $key;

			 // if($rowData[$key] == 'Visit Code')

			 // $visit_code = $key;

			 // if($rowData[$key] == 'Patient Name')

			 // $patient_name = $key;

			 if($rowData[$key] == 'Invoice No')

			 $bill_no = $key;

			 if($rowData[$key] == 'Invoice Amount')

			 $invoice_amount = $key;

			if($rowData[$key] == 'Discount')

			 $discount = $key;
			if($rowData[$key] == 'Denied')
			 $denied = $key;

			if($rowData[$key] == 'Net Paid  Amount')
			 $amount = $key;

			 // if($rowData[$key] == 'Phy Qty')

			 // $phyqtynm = $key;

			 // if($rowData[$key] == 'Sys Qty')

			 // $sysqtynm = $key;

			}			

			for ($row = 2; $row <= $highestRow; $row++){ 
    		//  Read a row of data into an array
    		$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,

                                    NULL,

                                    TRUE,

                                    FALSE)[0];


				 
				$bill_no1=$rowData[$bill_no];

				$invoice_amount1=$rowData[$invoice_amount];
				$discount1=$rowData[$discount];
				$denied1=$rowData[$denied];

				$amount_check+=$rowData[$amount];
			}
				// echo '<script>alert("'.$amount_check.'-'.$final_value.'Amount is greater than the Receipt Amount");</script>';
			// $amount_check = number_format($amount_check, 2);
			// if($amount_check>$final_value){
				// if (abs(($amount_check>$final_value)/$b) < 0.00001) {
				if(round($amount_check, 2) > round($final_value, 2)){
					// if((string)$amountdue == (string)$amount) {
				echo '<script>alert("Upload Amount is greater than the Receipt Amount");</script>';
				// echo '<script>alert("'.$amount_check.'-'.$final_value.'Amount is greater than the Receipt Amount");</script>';
				// exit();
			}else{

			for ($row = 2; $row <= $highestRow; $row++){ 
    		//  Read a row of data into an array
    		$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,

                                    NULL,

                                    TRUE,

                                    FALSE)[0];


				 
				$bill_no1=$rowData[$bill_no];

				$invoice_amount1=$rowData[$invoice_amount];
				$discount1=$rowData[$discount];
				$denied1=$rowData[$denied];

				$amount1=$rowData[$amount];
		 

				 
			if($bill_no1!="")
				{
				 $medicinequery2="INSERT INTO `excel_insurance_upload`(`docno`,`upload_id`, `subtype`, `upload_date`, `status`, `subtype_code`, `visit_code`, `patient_name`, `bill_no`,`invoice_amount`,`discount`,`denied`, `amount`, `username`, `ipaddress`, `location`)
					values ('$docno_get','$upload_exid', '$subtype_get', '$updatedatetime', '1', '$subtype_code', '', '', '$bill_no1', '$invoice_amount1', '$discount1', '$denied1', '$amount1', '$username', '$ipaddress','$locationcode123')";

					$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					// echo "success";

				}
   				 //  Insert row data array into your database of choice here
			}
					$searchaccount = $_POST['searchsuppliername'];
					$searchdocno=$_POST['docno'];
					$fromdate=$_POST['ADate1'];
					$todate=$_POST['ADate2'];
			// echo "<script>window.location.href = 'view_uploaded_excel.php?docno=$docno_get&&searchaccount=$searchaccount&&searchdocno=$searchdocno&&uploadid=$upload_exid&&fromdate=$fromdate&&todate=$todate&&search_type=$search_type';</script>";

			// working one
			 echo "<script>window.location.href = 'view_uploaded_excel_directlink.php?docno=$docno_get&&searchaccount=$searchaccount&&searchdocno=$searchdocno&&uploadid=$upload_exid&&fromdate=$fromdate&&todate=$todate&&search_type=$search_type';</script>";
			/// above is working one


			// echo "<script>window.open('view_uploaded_excel_directlink.php?docno=$docno_get&&searchaccount=$searchaccount&&searchdocno=$searchdocno;&&uploadid=$upload_exid&&fromdate=$fromdate&&todate=$todate&&search_type=$search_type','_blank')</script>";
			} // for second row condotion in the excel ends.


			} catch(Exception $e) {

				echo '<script>alert("File is Empty!.. Please retry Again");</script>';
			 // die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
				}
	} // excel upload file empty if loop


}

}
$searchaccount = $_POST['searchsuppliername'];

	$searchdocno=$_POST['docno'];

	$fromdate=$_POST['ADate1'];

	$todate=$_POST['ADate2'];



	// 	header("location:accountreceivableentrylist.php");
	// exit;
}
////////////// END OF EXCEL UPLOAD /////////////////////


if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }

//$getcanum = $_GET['canum'];

if ($getcanum != '')

{

	$query4 = "select * from master_supplier where auto_number = '$getcanum'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res4 = mysqli_fetch_array($exec4);

	$cbsuppliername = $res4['suppliername'];

	$suppliername = $res4['suppliername'];

}



if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }


if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }

if (isset($_REQUEST["searchsupplieranum"])) { $searchsupplieranum = $_REQUEST["searchsupplieranum"]; } else { $searchsupplieranum = ""; }



//include ("autocompletebuild_accounts1.php");



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$st = $_REQUEST['st'];

if ($st == '1')

{

	$errmsg = "Success. Payment Entry Update Completed.";

}

if ($st == '2')

{

	$errmsg = "Failed. Payment Entry Not Completed.";

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

<script language="javascript">



function cbsuppliername1()

{

	document.cbform1.submit();

}







</script>

<!--<script type="text/javascript" src="js/autocomplete_accounts1.js"></script>

<script type="text/javascript" src="js/autosuggest3accounts.js"></script>

<script type="text/javascript">

window.onload = function () 

{

	var oTextbox = new AutoSuggestControl(document.getElementById("accountname"), new StateSuggestions());        

}

</script>-->

<script type="text/javascript">





function disableEnterKey(varPassed)

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

	

	var key;

	if(window.event)

	{

		key = window.event.keyCode;     //IE

	}

	else

	{

		key = e.which;     //firefox

	}



	if(key == 13) // if enter key press

	{

		//alert ("Enter Key Press2");

		return false;

	}

	else

	{

		return true;

	}

}





function process1backkeypress1()

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

}



function disableEnterKey()

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

	

	var key;

	if(window.event)

	{

		key = window.event.keyCode;     //IE

	}

	else

	{

		key = e.which;     //firefox

	}

	

	if(key == 13) // if enter key press

	{

		return false;

	}

	else

	{

		return true;

	}



}



function paymententry1process2()

{

	if (document.getElementById("cbfrmflag1").value == "")

	{

		alert ("Search Bill Number Cannot Be Empty.");

		document.getElementById("cbfrmflag1").focus();

		document.getElementById("cbfrmflag1").value = "<?php echo $cbfrmflag1; ?>";

		return false;

	}

}





function funcPrintReceipt1()

{

	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');

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
.hideclass{
	display: none;
}

</style>

</head>



<script src="js/datetimepicker_css.js"></script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />      

<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/autocomplete.css">
<link rel="stylesheet" href="css/accountreceivable-modern.css">

<script>
function pop_up(url){
window.open(url,'win2=no','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=800,height=500,directories=no,location=no');
return false;
}
</script>

<script>

$(document).ready(function(e) {

   

		$('#searchsuppliername').autocomplete({

		

	source:"ajaxaccountsub_search.php",

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

			$('#searchsuppliername').val(accountname);

			

			},

    

	});

		

});

function validcheck(idsub)
{
	var idsubm=idsub;
	// alert(idsubm);
	var a = $('#upload_file'+idsubm).val();
	
	if ((document.getElementById('upload_file'+idsubm).value=="") ) 
	{
		 alert('Select Excel file to Upload');
		 return false;
	} 
	if(confirm("Do you Want to Upload the File?")==false){return false;}	
}
// var a = document.getElementById('upload_file'+idsubm).files.length;
	// var a = document.getElementById('upload_file'+idsubm).value;

// function incri(){
// 	var inc = document.getElementById("colorloopcount123").value;
// 	// var inc = $('#colorloopcount123').val();
// 	 // alert(inc);
// 	for(var i=1;i<=inc;i++){
// 		$('.list'+i).hide();
// 		$('.minus'+i).hide();
// 	}
// }

function funcShowView(inc)
{
var inc = inc;
 	if (document.getElementById("list"+inc) != null) 
	  {
	  $('.list'+inc).show();
	  $('.plus'+inc).hide();
	  $('.minus'+inc).show();
	 }
}
function funcHideView(inc)
{		
	var inc = inc;
	$('.list'+inc).hide();
	  $('.plus'+inc).show();
	   $('.minus'+inc).hide();
}
 
 
		function num_cond($var1, $op, $var2) {
		switch ($op) {
		case "=":  return $var1 == $var2;
		case "!=": return $var1 != $var2;

		default:       return true;
		}   
		} 
</script>

<body onLoad="incri();">

    <!-- Hospital Header -->
    <header class="hospital-header">
        <h1 class="hospital-title">🏥 MedStar Hospital Management</h1>
        <p class="hospital-subtitle">Account Receivable Management System</p>
    </header>

    <!-- Navigation Breadcrumb -->
    <nav class="nav-breadcrumb">
        <a href="mainmenu1.php">🏠 Dashboard</a>
        <span>→</span>
        <a href="#">📊 IP Masters</a>
        <span>→</span>
        <span>💰 Account Receivable Entry List</span>
    </nav>

    <!-- Floating Menu Toggle -->
    <button class="floating-menu-toggle" id="menuToggle" title="Toggle Menu (Ctrl+M)">
        <span class="toggle-icon">☰</span>
    </button>

    <!-- Main Container with Sidebar -->
    <div class="main-container-with-sidebar">
        <!-- Left Sidebar -->
        <aside class="left-sidebar" id="leftSidebar">
            <div class="sidebar-header">
                <h3>💰 Financial Management</h3>
                <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
                    <span class="toggle-icon">☰</span>
                </button>
            </div>
            <nav class="sidebar-nav">
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="mainmenu1.php" class="nav-link">
                            <span class="nav-icon">🏠</span>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link active">
                            <span class="nav-icon">💰</span>
                            <span class="nav-text">Account Receivable</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <span class="nav-icon">📊</span>
                            <span class="nav-text">Financial Reports</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <span class="nav-icon">📋</span>
                            <span class="nav-text">Transaction History</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content-area">
            <!-- Page Header -->
            <div class="page-header">
                <h2 class="page-title">
                    <span class="section-icon">💰</span>
                    Account Receivable Entry List
                </h2>
                <p class="page-subtitle">Search, filter, and manage account receivable transactions with advanced filtering and pagination.</p>
            </div>

            <!-- Alert Messages -->
            <?php include ("includes/alertmessages1.php"); ?>

		

		

            <!-- Search Form Section -->
            <div class="search-form-section">
                <div class="section-header">
                    <span class="section-icon">🔍</span>
                    <h3 class="section-title">Search & Filter Transactions</h3>
                </div>

                <form name="cbform1" method="post" action="accountreceivableentrylist.php" id="searchForm">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="search_type" class="form-label">Transaction Type</label>
                            <select name="search_type" id="search_type" class="form-select">
                                <option value="0" <?php if ($search_type==0){ echo 'selected'; } ?>>Allocate</option>
                                <option value="1" <?php if ($search_type==1){ echo 'selected'; } ?>>Fully Allocate</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="searchsuppliername" class="form-label">Subtype/Account</label>
                            <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" class="form-input" placeholder="Enter subtype or account name" autocomplete="off">
                            <input type="hidden" name="searchsuppliercode" id="searchsuppliercode" value="<?php echo $searchsuppliercode; ?>" />
                            <input type="hidden" name="searchsupplieranum" id="searchsupplieranum" value="<?php echo $searchsupplieranum; ?>" />
                        </div>

                        <div class="form-group">
                            <label for="docno" class="form-label">Document Number</label>
                            <input name="docno" type="text" id="docno" class="form-input" placeholder="Enter document number" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="ADate1" class="form-label">Date From</label>
                            <input name="ADate1" id="ADate1" class="form-input" value="<?php echo $transactiondatefrom; ?>" readonly="readonly" onKeyDown="return disableEnterKey()" />
                        </div>

                        <div class="form-group">
                            <label for="ADate2" class="form-label">Date To</label>
                            <input name="ADate2" id="ADate2" class="form-input" value="<?php echo $transactiondateto; ?>" readonly="readonly" onKeyDown="return disableEnterKey()" />
                        </div>

                        <div class="form-group form-actions">
                            <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                            <button type="submit" class="btn btn-primary">🔍 Search</button>
                            <button type="reset" class="btn btn-secondary">🔄 Reset</button>
                            <a href="Sample_AR_Upload.xlsx" class="btn btn-outline">📥 Download Sample Excel</a>
                        </div>
                    </div>
                </form>
            </div>

      

      <tr>

        <td>&nbsp;</td>

      </tr>

      

      <tr>

        <td>&nbsp;</td>

      </tr>

	  <tr>

        <td>

	<!-- <form name="form1" id="form1" method="post" action="accountreceivableentrylist.php">	 -->

		

<?php

	$colorloopcount=0;

	$sno=0;

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1' or isset($searchaccount) or isset($fromdate1))
{ 
	if(isset($fromdate1)){
		$searchaccount =  $searchaccount1;
	$searchdocno= $searchdocno1;
	$fromdate= $fromdate1;
	$todate= $todate1;
	}else{
	$searchaccount = $_POST['searchsuppliername'];
	$searchdocno=$_POST['docno'];
	$fromdate=$_POST['ADate1'];
	$todate=$_POST['ADate2'];
	}
	//echo $searchpatient;
		//$transactiondatefrom = $_REQUEST['ADate1'];
	//$transactiondateto = $_REQUEST['ADate2'];
?>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 

            align="left" border="0">

          <tbody>

            <!-- Data Section -->
            <div class="data-section">
                <div class="section-header">
                    <span class="section-icon">📊</span>
                    <h3 class="section-title">Transaction Data</h3>
                </div>

                <!-- Search and Filter Bar -->
                <div class="search-filter-bar">
                    <div class="search-section">
                        <input type="text" id="transactionSearch" class="search-input" placeholder="Search transactions...">
                        <button type="button" class="btn btn-primary btn-sm" onclick="filterTransactions()">🔍 Search</button>
                    </div>
                    <div class="filter-section">
                        <select id="typeFilter" class="form-select">
                            <option value="">All Types</option>
                            <option value="0">Allocate</option>
                            <option value="1">Fully Allocate</option>
                        </select>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="clearFilters()">🔄 Clear</button>
                    </div>
                </div>

                <!-- Data Table with Pagination -->
                <div class="table-container">
                    <table class="data-table" id="transactionsTable">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Date</th>
                                <th>Subtype</th>
                                <th>Doc No</th>
                                <th>Mode</th>
                                <th>Inst.Number</th>
                                <th>Amount</th>
                                <th>Pending Amt</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="transactionsTableBody">
                            <!-- Data will be loaded here via JavaScript -->
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Controls -->
                <div class="pagination-controls">
                    <div class="pagination-info">
                        Showing <span id="startIndex">0</span> to <span id="endIndex">0</span> of <span id="totalItems">0</span> transactions
                    </div>
                    <div class="pagination-buttons">
                        <button class="pagination-btn" id="prevBtn" onclick="previousPage()" disabled>← Previous</button>
                        <div class="page-numbers" id="pageNumbers"></div>
                        <button class="pagination-btn" id="nextBtn" onclick="nextPage()" disabled>Next →</button>
                    </div>
                    <div class="items-per-page">
                        <label for="itemsPerPage">Items per page:</label>
                        <select id="itemsPerPage" class="items-select" onchange="changeItemsPerPage()">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </div>
                    </div>
                </div>
            </div>

			  <?php 
			  if (isset($_REQUEST["search_type"])) { $search_type = $_REQUEST["search_type"]; } else { $search_type = "0"; }

			  $total_amount_of_excel=0;
			  $query89 = "select auto_number from master_subtype where subtype like '%$searchsuppliername%' and recordstatus <> 'deleted'";
			  $exec89 = mysqli_query($GLOBALS["___mysqli_ston"], $query89) or die ("Error in Query89".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res89 = mysqli_fetch_array($exec89))
			  {
			  $subtypeanum = $res89['auto_number'];			  
			  $query90 = "select auto_number, id, accountname from master_accountname where subtype = '$subtypeanum' and recordstatus <> 'deleted'";

			  $exec90 = mysqli_query($GLOBALS["___mysqli_ston"], $query90) or die ("Error in Query90".mysqli_error($GLOBALS["___mysqli_ston"]));

			  while($res90 = mysqli_fetch_array($exec90))

			  {

			  $accountnameid = $res90['id'];

			  $accountnameano = $res90['auto_number'];

			  $accountname = $res90['accountname'];

			  

              $query2 = "select * from master_transactionpaylater where accountnameid = '$accountnameid' and docno like '%$searchdocno%' and transactiondate between '$fromdate' and '$todate' and transactiontype <> 'pharmacycredit' and transactionmode <> 'CREDIT NOTE' and transactiontype <> 'paylatercredit' and transactiontype <> 'finalize' and acc_flag = '2' group by docno order by auto_number desc";

			  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			  $num2 = mysqli_num_rows($exec2);

			  

			  while ($res2 = mysqli_fetch_array($exec2))

			  {

			      $totalamount=0;

			 	  $transactiondate = $res2['transactiondate'];

				  $accountname = $res2['accountname'];

				  $docno = $res2['docno'];

				  $mode = $res2['transactionmode'];

				  $amount = $res2['transactionamount'];

				  $totalamount = $res2['receivableamount'];

				  $record_status = $res2['recordstatus'];

				 

				  $number = $res2['chequenumber'];

			  

			 

			  

							$query_alloc = "SELECT sum(amount) as alloc_amounrt_final FROM `excel_insurance_upload` WHERE docno='$docno' and status='1' ";
							$exec_alloc = mysqli_query($GLOBALS["___mysqli_ston"], $query_alloc) or die ("Error in query_alloc".mysqli_error($GLOBALS["___mysqli_ston"]));
							$res_alloc = mysqli_fetch_array($exec_alloc);
							$value_of_alloc = $res_alloc['alloc_amounrt_final'];
							if($value_of_alloc == ""){
							$value_of_alloc=0;
							}

								 $query_allocated_amount = "SELECT sum(transactionamount) as amount, sum(discount) as discount from master_transactionpaylater where  recordstatus='allocated' and docno='$docno'";
								// docno='$docno' and
								// $query_allocated_amount = "SELECT * FROM `excel_insurance_upload` WHERE bill_no='$bill_no' and status='1' and location='$locationcode'";
								$exec_allocated_amount = mysqli_query($GLOBALS["___mysqli_ston"], $query_allocated_amount) or die ("Error in Query_allocated_amount".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($res_allocated_amount = mysqli_fetch_array($exec_allocated_amount)){
								$allocated_amount=$res_allocated_amount['amount'];
								// $allocated_amount=$res_allocated_amount['amount']+$res_allocated_amount['discount'];
								}
					$pendig_final_value = $totalamount-$allocated_amount;
					// $pendig_final_value = $totalamount-$value_of_alloc;

					$query_upload = "SELECT * FROM `excel_insurance_upload` WHERE docno='$docno' and status='1'  group by upload_id order by auto_number";
					// and allocate='1'
					$exec_upload = mysqli_query($GLOBALS["___mysqli_ston"], $query_upload) or die ("Error in Query1_upload".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num2_upload = mysqli_num_rows($exec_upload); 
						
				if ($search_type == 0){
						 
						 
						//  $v1 =  $pendig_final_value;
						// $v2 =0;
						// if (!num_cond($v1, $op, $v2))
						if($pendig_final_value != 0) {

												$colorloopcount = $colorloopcount + 1;
												$showcolor = ($colorloopcount & 1); 
												$colorcode = '';
												$sno=$sno+1;
								if ($showcolor == 0)
									{ $colorcode = 'bgcolor="#CBDBFA"';
									}
									else
									{ $colorcode = 'bgcolor="#ecf0f5"';
									}
									$count = $colorloopcount;
							  ?>
			

			  <form name="cbform1<?=$colorloopcount;?>" method="post" enctype="multipart/form-data" >
			 <!-- <form name="cbform1" method="post" action="upload_excel_insurance.php?docno=<?php echo $docno; ?>&&subtype=<?=$accountname;?>" enctype="multipart/form-data" onSubmit="return validcheck()"> -->
			 	<input type="hidden" name="docno_post[]" value="<?=$docno;?>">
			 	<input type="hidden" name="subtype[]" value="<?=$accountname;?>">

			 	<input type="hidden" name="searchsuppliername" value="<?=$searchaccount;?>">
			 	<input type="hidden" name="docno" value="<?=$searchdocno;?>">
			 	<input type="hidden" name="ADate1" value="<?=$fromdate;?>">
			 	<input type="hidden" name="ADate2" value="<?=$todate;?>">
			 	<!-- #00e68a  ff9933 -->

              <tr <?php if($pendig_final_value=='0'){ echo 'bgcolor="#FF9900"'; } if($num2_upload>0){ echo 'bgcolor="#00e68a"'; }else{ echo $colorcode; } ?>>
                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
                    <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $transactiondate; ?></span></div>
                </div></td>

				<td  align="left" valign="center" class="bodytext31"><div class="bodytext31"> <div align="center"><span class="bodytext32"><?php echo $accountname; ?></span></div> </div></td>

				<td  align="left" valign="center" class="bodytext31"><div class="bodytext31"> <div align="left"><span class="bodytext32"><?php echo $docno; ?></span></div> </div></td>

				<td>
					<?php // if($totalamount!=$pendig_final_value){ ?>
					<?php if($value_of_alloc>0){ ?>
					<div class="plus<?=$colorloopcount;?>"><img src="images2/cal_minus.gif" width="13" height="13" onClick="return funcShowView(<?=$colorloopcount;?>)">&nbsp;</div><span> <div class="minus<?=$colorloopcount;?> hideclass"><img src="images2/cal_plus.gif" width="13" height="13" onClick="return funcHideView(<?=$colorloopcount;?>)">&nbsp;</div></span>
					<?php   } ?>
				</td>

           

                 <td class="bodytext31" valign="center"  align="left"> <div align="left"><?php echo $mode; ?></div></td>

           

                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31"> <div align="left"> <span class="bodytext3"> <?php echo $number; ?> </span> </div> </div></td>

				

				<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="right"> <span class="bodytext3"> <?php echo number_format($totalamount,2,'.',','); ?> </span> </div>
                    <input type="hidden" name="ar_amount[]" value="<?=$totalamount;?>">
                </div></td>
                
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                 <div align="right"> <span class="bodytext3"> <?php echo number_format($pendig_final_value,2,'.',','); ?> </span> </div>
                </div></td>

           
			 	<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"><a href="accountreceivableentry.php?docno=<?php echo $docno; ?>">Manual</a> </span> </div>
                </div></td>
                <?php 
            		$query = "SELECT * FROM `excel_insurance_upload` WHERE docno='$docno' and status='1' ";
					$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num2 = mysqli_num_rows($exec);
					while($res = mysqli_fetch_array($exec)){
 						$allocation_amount = $res['amount']+$res['discount'];
						$total_amount_of_excel += $allocation_amount;
								}

								// echo $total_amount_of_excel1 = number_format($total_amount_of_excel, 2);
								// echo $totalamount1 = number_format($totalamount, 2);
								 
             ?>
              

                 <td  align="left" valign="center" class="bodytext31"><div class="bodytext31" >
					<div align="left" style='height: 20px; width: 180px; overflow:hidden;'> 
						 <!-- border: 1px solid #ccc; -->
						<span class="bodytext3">
							<!-- <label class="btn fileUpload btn-default"> -->
							<input type="file" name="upload_file" id="upload_file<?=$colorloopcount;?>"  <?php if($pendig_final_value=='0'){ echo "disabled='' style='color: red; opacity:0;background:none;border:none;margin:0;padding:0;'"; } ?> >
							<!-- <input type="file" name="upload_file" id="upload_file<?=$sno;?>"  <?php// if($total_amount_of_excel>=$totalamount){ //echo "disabled='' style='color: red; opacity:0;background:none;border:none;margin:0;padding:0;'"; } ?> > -->
						<!-- </label> -->
						</span> 

					</div></td>
					
                <!-- <a href="upload_excel_insurance.php?docno=<?php echo $docno; ?>&&subtype=<?=$accountname;?>"></a> -->
                 <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                 	

              <span><input type="hidden" name="frmflag_upload" id="subid<?=$colorloopcount;?>" value="frmflag_upload">
			<input type="submit" name="frmsubmit1" value="Save" onClick="return validcheck(<?=$colorloopcount;?>)"  <?php if($pendig_final_value=='0'){ echo "disabled='' style='color: red; opacity:0;background:none;border:none;margin:0;padding:0;'"; } ?>  ></span></td>
			<!--   onClick="return validcheck(<?=$colorloopcount;?>)" -->
			<!-- <input type="submit" name="frmsubmit1" value="Save"  <?php// if($total_amount_of_excel>=$totalamount){ //echo "disabled='' style='color: red; opacity:0;background:none;border:none;margin:0;padding:0;'"; } ?>></span></td> -->

			 <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
			 	<input type="button"   style="cursor: pointer;color: blue;  background:none;border:none;margin:0;padding:0;"  onclick="window.open('view_uploaded_excel_old.php?docno=<?php echo $docno; ?>&&searchaccount=<?=$searchaccount?>&&searchdocno=<?=$searchdocno;?>&&fromdate=<?=$fromdate?>&&todate=<?=$todate?>&&search_type=<?=$search_type;?>','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=1400,height=1000,directories=no,location=no');" value="Full View">
			 	<!-- <?php //if($num_view==0){ echo "disabled=''  style='color: red; opacity:0;background:none;border:none;margin:0;padding:0;'"; } ?>  -->
			 	<!-- <a href="view_uploaded_excel.php?docno=<?php// echo $docno; ?>" onclick="pop_up(this);" >Review</a> -->
			 </div>
			</td>
                 	</form>
				<!--  <td  align="left" valign="center" class="bodytext31">
				</td> -->	


				<!--<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
				 	
				 	<?php if($totalamount == $pendig_final_value){?>
                    <div align="left"> <span class="bodytext3"><a href="accountreceivableentrylist.php?docno=<?php echo $docno; ?>&&tbl=master_transactionpaylater&&del=del" onclick="return confirm('Do you want to delete?')">DELETE</a> </span> </div>
                    <?php }?>
                </div></td>-->			

				 </tr>

				<?php 
				// $total_amount_of_excel=0;
				$sno=0;
				$query_upload = "SELECT * FROM `excel_insurance_upload` WHERE docno='$docno' and status='1'  group by upload_id order by auto_number";
				// and allocate='1'
				$exec_upload = mysqli_query($GLOBALS["___mysqli_ston"], $query_upload) or die ("Error in Query1_upload".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num2_upload = mysqli_num_rows($exec_upload); 
				if($num2_upload>0){ ?>
					<tr class="list<?=$colorloopcount;?> hideclass" <?php if($pendig_final_value=='0'){ echo 'bgcolor="#FF9900"'; } if($num2_upload>0){ echo 'bgcolor="#00e68a"'; } ?>>
						<td class="bodytext31" valign="center"  align="left"  ><strong></strong></td>
						<td class="bodytext31" valign="center"  align="left"  ><strong>S.No</strong></td>
						<td class="bodytext31" valign="center"  align="left"  ><strong>Date</strong></td>
						<td colspan="2" class="bodytext31" valign="center"  align="left"  ><strong>Upload ID</strong></td>
						<td colspan="2" class="bodytext31" valign="center"  align="right"  ><strong>Net Paid Amount</strong></td>
						<td class="bodytext31" valign="center"  align="right"  ><strong>Discount</strong></td>
						<td class="bodytext31" valign="center"  align="right"  ><strong>Denied</strong></td>
						<td colspan="2" class="bodytext31" valign="center"  align="right"  ><strong>Total Amount</strong></td>
						<td class="bodytext31" valign="center"  align="center"  ><strong>User</strong></td>
						<td class="bodytext31" valign="center"  align="left"  ><strong>Action</strong></td>
						<td class="bodytext31" valign="center"  align="left"  ><strong>&nbsp;</strong></td>
					</tr>

					<?php
				while ($res2_upid = mysqli_fetch_array($exec_upload)){
					$uploadid=$res2_upid['upload_id'];
					$upload_date=$res2_upid['upload_date'];
					$sno += 1;
					$invoice_amount1 = 0;
					$discount1 = 0;
					$denied1 = 0;
					$amount1 = 0;
					$allocation_amount1 = 0;
					$query = "SELECT * FROM `excel_insurance_upload` WHERE docno='$docno' and upload_id='$uploadid' and status='1' ";
					$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
					$num2 = mysqli_num_rows($exec);
					while($res = mysqli_fetch_array($exec)){
 						$allocation_amount = $res['amount']+$res['discount'];

						// $invoice_amount1 += $res['invoice_amount'];
						$discount1 += $res['discount'];
						$denied1 += $res['denied'];
						$amount1 += $res['amount'];
						$allocation_amount1 += $allocation_amount;
						
						$username = ucwords($res['username']);
								}
								$total_amount_of_excel += $allocation_amount;


						$query_alloc = "SELECT sum(transactionamount) as amount FROM `master_transactionpaylater` WHERE recordstatus='allocated' and docno='$docno' and upload_id='$uploadid' ";
						$exec_alloc = mysqli_query($GLOBALS["___mysqli_ston"], $query_alloc) or die ("Error in Query_alloc".mysqli_error($GLOBALS["___mysqli_ston"]));
						$num2_alloc = mysqli_num_rows($exec_alloc);
						while($res_alloc = mysqli_fetch_array($exec_alloc)){
						$allocation_amount_from_tb = $res_alloc['amount'];
						}
						

					 

							?>
						<!-- <tr <?php// echo $colorcode; ?>> -->

						<tr  <?php echo $colorcode; ?> class="list<?=$colorloopcount;?> hideclass" id="list<?=$colorloopcount;?>">
							<td colspan="1" class="bodytext31" valign="center"  align="left"></td>
							<td class="bodytext31" valign="center"  align="left"><?php echo $sno; ?></td>
							<td class="bodytext31" valign="center"  align="left"><?php echo $upload_date; ?></td>
							<td colspan="2"  align="left" valign="center" class="bodytext31"><div class="bodytext31"><div align="left"><span class="bodytext32"><?php echo $uploadid; ?></span></div> </div></td>

							<td colspan="2" class="bodytext31" valign="center"  align="right"><?php echo number_format($amount1,2,'.',','); ?></td>
							<td class="bodytext31" valign="center"  align="right"><?php echo number_format($discount1,2,'.',','); ?></td>
							<td class="bodytext31" valign="center"  align="right"><?php echo number_format($denied1,2,'.',','); ?></td>
							<td colspan="2" class="bodytext31" valign="center"  align="right"><?php echo number_format($allocation_amount1,2,'.',','); ?></td>
							
							<td colspan="1" class="bodytext31" valign="center"  align="center"><?=$username;?></td>

							<td  align="left" valign="center" class="bodytext31">
								<?php if($allocation_amount_from_tb==$amount1){ ?>
								<input type="button"   style="cursor: pointer;color: blue; text-decoration: underline;  background:none;border:none;margin:0;padding:0;"  onclick="window.open('view_uploaded_excel.php?docno=<?php echo $docno; ?>&&searchaccount=<?=$searchaccount?>&&searchdocno=<?=$searchdocno;?>&&uploadid=<?=$uploadid;?>&&fromdate=<?=$fromdate?>&&todate=<?=$todate?>&&search_type=<?=$search_type;?>','_blank');" value="Deallocate">
							<?php }else{ ?>
								<input type="button"   style="cursor: pointer;color: blue; text-decoration: underline;  background:none;border:none;margin:0;padding:0;"  onclick="window.open('view_uploaded_excel.php?docno=<?php echo $docno; ?>&&searchaccount=<?=$searchaccount?>&&searchdocno=<?=$searchdocno;?>&&uploadid=<?=$uploadid;?>&&fromdate=<?=$fromdate?>&&todate=<?=$todate?>&&search_type=<?=$search_type;?>','_blank');" value="Allocate">
							<?php } ?>
								<!-- <input type="button"   style="cursor: pointer;color: blue; text-decoration: underline;  background:none;border:none;margin:0;padding:0;"  onclick="window.open('view_uploaded_excel.php?docno=<?php //echo $docno; ?>&&searchaccount=<?=$searchaccount?>&&searchdocno=<?=$searchdocno;?>&&uploadid=<?=$uploadid;?>&&fromdate=<?=$fromdate?>&&todate=<?=$todate?>','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=1400,height=1000,directories=no,location=no');" value="Allocate"> -->
							</td>
							<td colspan="1" class="bodytext31" valign="center"  align="center">&nbsp;</td>
						</tr>

			  <?php 	} // while  above
			  			} // num_upload >0

		  				} // colapse closedir
			  		}  else{
			  					// if ($search_type == 0){
						 
						 
														//  $v1 =  $pendig_final_value;
														// $v2 =0;
														// if (!num_cond($v1, $op, $v2))
														if($pendig_final_value == 0) {
															$colorloopcount = $colorloopcount + 1;
																$showcolor = ($colorloopcount & 1); 
																$colorcode = '';
																$sno=$sno+1;
																if ($showcolor == 0)
																	{ $colorcode = 'bgcolor="#CBDBFA"';
																	}
																	else
																	{ $colorcode = 'bgcolor="#ecf0f5"';
																	}
																	$count = $colorloopcount;
															  ?>
											

											  <form name="cbform1<?=$colorloopcount;?>" method="post" enctype="multipart/form-data" >
											 <!-- <form name="cbform1" method="post" action="upload_excel_insurance.php?docno=<?php //echo $docno; ?>&&subtype=<?=$accountname;?>" enctype="multipart/form-data" onSubmit="return validcheck()"> -->
											 	<input type="hidden" name="docno_post[]" value="<?=$docno;?>">
											 	<input type="hidden" name="subtype[]" value="<?=$accountname;?>">

											 	<input type="hidden" name="searchsuppliername" value="<?=$searchaccount;?>">
											 	<input type="hidden" name="docno" value="<?=$searchdocno;?>">
											 	<input type="hidden" name="ADate1" value="<?=$fromdate;?>">
											 	<input type="hidden" name="ADate2" value="<?=$todate;?>">
											 	<!-- #00e68a  ff9933 -->
											 		<!-- if($pendig_final_value=='0'){ echo 'bgcolor="#FF9900"'; } if($num2_upload>0){ echo 'bgcolor="#00e68a"'; }else{  -->
								              <tr <?php echo $colorcode;  ?>>
								                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
								                    <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
								                    <div align="left"><span class="bodytext32"><?php echo $transactiondate; ?></span></div>
								                </div></td>

												<td  align="left" valign="center" class="bodytext31"><div class="bodytext31"> <div align="center"><span class="bodytext32"><?php echo $accountname; ?></span></div> </div></td>

												<td  align="left" valign="center" class="bodytext31"><div class="bodytext31"> <div align="left"><span class="bodytext32"><?php echo $docno; ?></span></div> </div></td>

												<td>
													<?php if($value_of_alloc>0){ ?>
													<div class="plus<?=$colorloopcount;?>"><img src="images2/cal_minus.gif" width="13" height="13" onClick="return funcShowView(<?=$colorloopcount;?>)">&nbsp;</div><span> <div class="minus<?=$colorloopcount;?> hideclass"><img src="images2/cal_plus.gif" width="13" height="13" onClick="return funcHideView(<?=$colorloopcount;?>)">&nbsp;</div></span>
													<?php   } ?>
												</td>

								           

								                 <td class="bodytext31" valign="center"  align="left"> <div align="left"><?php echo $mode; ?></div></td>

								           

								                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31"> <div align="left"> <span class="bodytext3"> <?php echo $number; ?> </span> </div> </div></td>

												

												<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

								                    <div align="right"> <span class="bodytext3"> <?php echo number_format($totalamount,2,'.',','); ?> </span> </div>
								                    <input type="hidden" name="ar_amount[]" value="<?=$totalamount;?>">
								                </div></td>
								                
								                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
								                 <div align="right"> <span class="bodytext3"> <?php echo number_format($pendig_final_value,2,'.',','); ?> </span> </div>
								                </div></td>

								           
											 	<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

								                    <div align="left"> <span class="bodytext3"><a href="accountreceivableentry.php?docno=<?php echo $docno; ?>">Manual</a> </span> </div>
								 

								                </div></td>
								                <?php 
								            		$query = "SELECT * FROM `excel_insurance_upload` WHERE docno='$docno' and status='1' ";
													$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
													$num2 = mysqli_num_rows($exec);
													while($res = mysqli_fetch_array($exec)){
								 						$allocation_amount = $res['amount']+$res['discount'];
														$total_amount_of_excel += $allocation_amount;
																}

																// echo $total_amount_of_excel1 = number_format($total_amount_of_excel, 2);
																// echo $totalamount1 = number_format($totalamount, 2);
																 
								             ?>
								              

								                 <td  align="left" valign="center" class="bodytext31"><div class="bodytext31" >
													<div align="left" style='height: 20px; width: 180px; overflow:hidden;'> 
														 <!-- border: 1px solid #ccc; -->
														<span class="bodytext3">
															<!-- <label class="btn fileUpload btn-default"> -->
															<input type="file" name="upload_file" id="upload_file<?=$colorloopcount;?>"  <?php if($pendig_final_value=='0'){ echo "disabled='' style='color: red; opacity:0;background:none;border:none;margin:0;padding:0;'"; } ?> >
															<!-- <input type="file" name="upload_file" id="upload_file<?=$sno;?>"  <?php// if($total_amount_of_excel>=$totalamount){ //echo "disabled='' style='color: red; opacity:0;background:none;border:none;margin:0;padding:0;'"; } ?> > -->
														<!-- </label> -->
														</span> 

													</div></td>
													
								                <!-- <a href="upload_excel_insurance.php?docno=<?php echo $docno; ?>&&subtype=<?=$accountname;?>"></a> -->
								                 <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
								                 	

								              <span><input type="hidden" name="frmflag_upload" id="subid<?=$colorloopcount;?>" value="frmflag_upload">
											<input type="submit" name="frmsubmit1" value="Save" onClick="return validcheck(<?=$colorloopcount;?>)"  <?php if($pendig_final_value=='0'){ echo "disabled='' style='color: red; opacity:0;background:none;border:none;margin:0;padding:0;'"; } ?>  ></span></td>
											<!--   onClick="return validcheck(<?=$colorloopcount;?>)" -->
											<!-- <input type="submit" name="frmsubmit1" value="Save"  <?php// if($total_amount_of_excel>=$totalamount){ //echo "disabled='' style='color: red; opacity:0;background:none;border:none;margin:0;padding:0;'"; } ?>></span></td> -->
											   

											 <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
											 	 
											 	<input type="button"   style="cursor: pointer;color: blue;  background:none;border:none;margin:0;padding:0;"  onclick="window.open('view_uploaded_excel_old.php?docno=<?php echo $docno; ?>&&searchaccount=<?=$searchaccount?>&&searchdocno=<?=$searchdocno;?>&&fromdate=<?=$fromdate?>&&todate=<?=$todate?>&&search_type=<?=$search_type;?>','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=1400,height=1000,directories=no,location=no');" value="Full View">
											 	<!-- <?php //if($num_view==0){ echo "disabled=''  style='color: red; opacity:0;background:none;border:none;margin:0;padding:0;'"; } ?>  -->
											 	<!-- <a href="view_uploaded_excel.php?docno=<?php //echo $docno; ?>" onclick="pop_up(this);" >Review</a> -->
											 </div>
											</td>
											<!--<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
												 	
												 	<?php if($totalamount == $pendig_final_value){?>
								                    <div align="left"> <span class="bodytext3"><a href="accountreceivableentrylist.php?docno=<?php echo $docno; ?>&&tbl=master_transactionpaylater&&del=del" onclick="return confirm('Do you want to delete?')">DELETE</a> </span> </div>
								                    <?php }?>
								                </div></td>		-->
								                 	</form>
												<!--  <td  align="left" valign="center" class="bodytext31">

												</td> -->				

												 </tr>

												<?php 
												// $total_amount_of_excel=0;
												$sno=0;
												$query_upload = "SELECT * FROM `excel_insurance_upload` WHERE docno='$docno' and status='1'  group by upload_id order by auto_number";
												// and allocate='1'
												$exec_upload = mysqli_query($GLOBALS["___mysqli_ston"], $query_upload) or die ("Error in Query1_upload".mysqli_error($GLOBALS["___mysqli_ston"]));
												$num2_upload = mysqli_num_rows($exec_upload); 
												if($num2_upload>0){ ?>
													<!-- if($pendig_final_value=='0'){ echo 'bgcolor="#FF9900"'; } if($num2_upload>0){ echo 'bgcolor="#00e68a"'; } ?> -->
													<tr class="list<?=$colorloopcount;?> hideclass" <?php  echo 'bgcolor="#00e68a"';  ?>>
														<td class="bodytext31" valign="center"  align="left"  ><strong></strong></td>
														<td class="bodytext31" valign="center"  align="left"  ><strong>S.No</strong></td>
														<td class="bodytext31" valign="center"  align="left"  ><strong>Date</strong></td>
														<td colspan="2" class="bodytext31" valign="center"  align="left"  ><strong>Upload ID</strong></td>
														<td colspan="2" class="bodytext31" valign="center"  align="right"  ><strong>Net Paid Amount</strong></td>
														<td class="bodytext31" valign="center"  align="right"  ><strong>Discount</strong></td>
														<td class="bodytext31" valign="center"  align="right"  ><strong>Denied</strong></td>
														<td colspan="2" class="bodytext31" valign="center"  align="right"  ><strong>Total Amount</strong></td>
														<td class="bodytext31" valign="center"  align="center"  ><strong>User</strong></td>
														<td class="bodytext31" valign="center"  align="left"  ><strong>Action</strong></td>
														<td class="bodytext31" valign="center"  align="left"  ><strong>&nbsp;</strong></td>
													</tr>

													<?php
												while ($res2_upid = mysqli_fetch_array($exec_upload)){
													$uploadid=$res2_upid['upload_id'];
													$upload_date=$res2_upid['upload_date'];
													$sno += 1;
													$invoice_amount1 = 0;
													$discount1 = 0;
													$denied1 = 0;
													$amount1 = 0;
													$allocation_amount1 = 0;
													$query = "SELECT * FROM `excel_insurance_upload` WHERE docno='$docno' and upload_id='$uploadid' and status='1' ";
													$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
													$num2 = mysqli_num_rows($exec);
													while($res = mysqli_fetch_array($exec)){
								 						$allocation_amount = $res['amount']+$res['discount'];

														// $invoice_amount1 += $res['invoice_amount'];
														$discount1 += $res['discount'];
														$denied1 += $res['denied'];
														$amount1 += $res['amount'];
														$allocation_amount1 += $allocation_amount;
														
														$username = ucwords($res['username']);
																}
																$total_amount_of_excel += $allocation_amount;
															?>
														<!-- <tr <?php //echo $colorcode; ?>> -->

														<tr  <?php echo $colorcode; ?> class="list<?=$colorloopcount;?> hideclass" id="list<?=$colorloopcount;?>">
															<td colspan="1" class="bodytext31" valign="center"  align="left"></td>
															<td class="bodytext31" valign="center"  align="left"><?php echo $sno; ?></td>
															<td class="bodytext31" valign="center"  align="left"><?php echo $upload_date; ?></td>
															<td colspan="2"  align="left" valign="center" class="bodytext31"><div class="bodytext31"><div align="left"><span class="bodytext32"><?php echo $uploadid; ?></span></div> </div></td>

															<td colspan="2" class="bodytext31" valign="center"  align="right"><?php echo number_format($amount1,2,'.',','); ?></td>
															<td class="bodytext31" valign="center"  align="right"><?php echo number_format($discount1,2,'.',','); ?></td>
															<td class="bodytext31" valign="center"  align="right"><?php echo number_format($denied1,2,'.',','); ?></td>
															<td colspan="2" class="bodytext31" valign="center"  align="right"><?php echo number_format($allocation_amount1,2,'.',','); ?></td>
															
															<td colspan="1" class="bodytext31" valign="center"  align="center"><?=$username;?></td>

															<td  align="left" valign="center" class="bodytext31">
																<input type="button"   style="cursor: pointer;color: blue; text-decoration: underline;  background:none;border:none;margin:0;padding:0;"  onclick="window.open('view_uploaded_excel.php?docno=<?php echo $docno; ?>&&searchaccount=<?=$searchaccount?>&&searchdocno=<?=$searchdocno;?>&&uploadid=<?=$uploadid;?>&&fromdate=<?=$fromdate?>&&todate=<?=$todate?>&&search_type=<?=$search_type;?>','_blank');" value="Allocate">
																<!-- <input type="button"   style="cursor: pointer;color: blue; text-decoration: underline;  background:none;border:none;margin:0;padding:0;"  onclick="window.open('view_uploaded_excel.php?docno=<?php //echo $docno; ?>&&searchaccount=<?=$searchaccount?>&&searchdocno=<?=$searchdocno;?>&&uploadid=<?=$uploadid;?>&&fromdate=<?=$fromdate?>&&todate=<?=$todate?>','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=1400,height=1000,directories=no,location=no');" value="Allocate"> -->
															</td>
															<td colspan="1" class="bodytext31" valign="center"  align="center">&nbsp;</td>
														</tr>

											  <?php 	} // while  above
											  			} // num_upload >0

										  				}
			  				} 

			  }  




			  ?>
			  
<!-- 
			   <?php 

    //         $query256 = "select * from master_journalentries where ledgerid = '$accountnameid' and docno like '%$searchdocno%' and entrydate between '$fromdate' and '$todate' and selecttype = 'Dr' group by docno order by auto_number desc";
			 //  $exec256 = mysql_query($query256) or die ("Error in Query256".mysql_error());
			 //  $num256 = mysql_num_rows($exec256);

			  
			 //  while ($res256 = mysql_fetch_array($exec256))
			 //  {
			 //      $totalamount=0;

			 // 	  $transactiondate = $res256['entrydate'];

				//   $accountname = $res256['ledgername'];

				//   $docno = $res256['docno'];

				//   $mode = 'Journal';

				//   $amount = $res256['transactionamount'];

				//   $totalamount = $res256['transactionamount'];

				//   $ledgerid = $res256['ledgerid'];

				 

				//   $number = $res256['narration'];

			  

			 //  $colorloopcount = $colorloopcount + 1;

			 //  $showcolor = ($colorloopcount & 1); 

			 //  $colorcode = '';

				// if ($showcolor == 0)

				// {

				// 	//echo "if";

				// 	$colorcode = 'bgcolor="#CBDBFA"';

				// }

				// else

				// {

				// 	//echo "else";

				// 	$colorcode = 'bgcolor="#ecf0f5"';

				// }


			  ?>

              <tr <?php echo $colorcode; ?>>

                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>

               

                    <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="left"><span class="bodytext32"><?php echo $transactiondate; ?></span></div>

                </div></td>

				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="center"><span class="bodytext32"><?php echo $accountname; ?></span></div>

                </div></td>

					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="left"><span class="bodytext32"><?php echo $docno; ?></span></div>

                </div></td>

           

                   <td class="bodytext31" valign="center"  align="left">

				  <div align="left"><?php echo $mode; ?></div></td>

           

                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="left"> <span class="bodytext3"> <?php echo $number; ?> </span> </div>

                </div></td>

				

				<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="right"> <span class="bodytext3"> <?php echo number_format($totalamount,2,'.',','); ?> </span> </div>

                </div></td>

           

			 <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="left"> <span class="bodytext3"><a href="accountreceivableentry1.php?docno=<?php echo $docno; ?>&&ledgerid=<?php echo $ledgerid; ?>">VIEW</a> </span> </div>

                </div></td>

				 <td  align="left" valign="center" class="bodytext31">

				</td>				

				 </tr>
 -->
			  <?php

			  // }

			  }

			  }
			  ?><input type="hidden" id="colorloopcount123" value="<?=$colorloopcount;?>"><?php

			  ?>

              <tr>

                     <td colspan="14" class="bodytext31" valign="center"  align="left"  bgcolor="#ecf0f5">&nbsp;</td>


				 </tr>

          </tbody>

        </table>

	

		

	  <tr>

        <td>&nbsp;</td>

      </tr>
      <!-- ///removed THE CREDIT NOTES ///////// -->
      
     <tr>

        <td>

		<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td width="700" colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>Credit Notes </strong></td>

              </tr>

			 

	  <tr>

	  <td>

	  <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" 

            align="left" border="0">

          <tbody>

		  <tr>

		    <td  class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>S.No</strong></td>

                <td width="8%"  align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>

                <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Subtype</strong></div></td>

                <td width="10%" align="left" valign="center"    bgcolor="#ffffff" class="bodytext31"><strong>Doc No</strong></td>

				  <td width="25%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Patient</strong></td>

					  <td  width="8%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Reg.No</strong></td>


				        <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="left"><strong>Visitcode</strong></div></td>

					        <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="left"><strong>Amount</strong></div></td>

          

               <td align="center" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action</strong></div></td>

           </tr>

		    <?php 

			$colorloopcount1 = 0;

			$query89 = "select auto_number,subtype from master_subtype where subtype like '%$searchsuppliername%' and recordstatus <> 'deleted'";

			  $exec89 = mysqli_query($GLOBALS["___mysqli_ston"], $query89) or die ("Error in Query89".mysqli_error($GLOBALS["___mysqli_ston"]));

			  while($res89 = mysqli_fetch_array($exec89))

			  {

			  $subtypeanum = $res89['auto_number'];
			  $subtype_name = $res89['subtype'];

			  

			  $query90 = "select auto_number, id, accountname from master_accountname where subtype = '$subtypeanum' and recordstatus <> 'deleted'";
			  $exec90 = mysqli_query($GLOBALS["___mysqli_ston"], $query90) or die ("Error in Query90".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while($res90 = mysqli_fetch_array($exec90))
			  {
			  $accountnameid = $res90['id'];
			  $accountnameano = $res90['auto_number'];
			  $accountname = $res90['accountname'];

			  

    //           $query24 = "select * from master_transactionpaylater where accountnameid = '$accountnameid' and transactiontype = 'pharmacycredit' and transactiondate between '$fromdate' and '$todate' group by docno order by auto_number desc";

			 //  $exec24 = mysql_query($query24) or die ("Error in Query24".mysql_error());

			 //  $num24 = mysql_num_rows($exec24);

			 // // echo $num2;

			 //  while ($res24 = mysql_fetch_array($exec24))

			 //  {

			 //      $totalamount1=0;

			 // 	  $transactiondate1 = $res24['transactiondate'];

				//   $accountname1 = $res24['accountname'];

				//   $docno1 = $res24['docno'];

				//   $patients = $res24['patientname'];

				//   $patientcodes = $res24['patientcode'];

				//   $visitcodes = $res24['visitcode'];

				//   $transamount = $res24['fxamount'];

				     

			 //  $totalamount1 = number_format($transamount,2,'.','');

	

				  

			 //  $colorloopcount1 = $colorloopcount1 + 1;

			 //  $showcolor1 = ($colorloopcount1 & 1); 

			 //  $colorcode1 = '';

				// if ($showcolor1 == 0)

				// {

				// 	//echo "if";

				// 	$colorcode1 = 'bgcolor="#CBDBFA"';

				// }

				// else

				// {

				// 	//echo "else";

				// 	$colorcode1 = 'bgcolor="#ecf0f5"';

				// }

			  ?>

			<!--     <tr <?php echo $colorcode1; ?>>

                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount1; ?></td>

               

                    <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="left"><span class="bodytext32"><?php echo $transactiondate1; ?></span></div>

                </div></td>

				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="left"><span class="bodytext32"><?php echo $accountname1; ?></span></div>

                </div></td>

					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="left"><span class="bodytext32"><?php echo $docno1; ?></span></div>

                </div></td>

           

                   <td class="bodytext31" valign="center"  align="left">

				  <div align="left"><?php echo $patients; ?></div></td>

           

                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="left"> <span class="bodytext3"> <?php echo $patientcodes; ?> </span> </div>

                </div></td>

				

				<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="left"> <span class="bodytext3"> <?php echo $visitcodes; ?> </span> </div>

                </div></td>

				<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="right"> <span class="bodytext3"> <?php echo number_format($transamount,2,'.',','); ?></span> </div>

                </div></td>

           

		   <td  align="center" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="center"> <span class="bodytext3"><a href="accountreceivableentry.php?docno=<?php echo $docno1; ?>">VIEW</a> </span> </div>

                </div></td>

                    </tr>
 -->
			  <?php
			  // }
 
			  // $colorloopcount1 = 0;
				$query24 = "select * from master_transactionpaylater where accountnameid = '$accountnameid' and transactiontype = 'paylatercredit' and transactiondate between '$fromdate' and '$todate' group by docno order by auto_number desc";
						$exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die("Error in Query24" . mysqli_error($GLOBALS["___mysqli_ston"]));
						$num24 = mysqli_num_rows($exec24);
						// echo $num2;
						while ($res24 = mysqli_fetch_array($exec24)) {
						    $totalamount1     = 0;
						    $transactiondate1 = $res24['transactiondate'];
						    $accountname1     = $res24['accountname'];
						    $docno1           = $res24['docno'];
						    $patients         = $res24['patientname'];
						    $patientcodes     = $res24['patientcode'];
						    $visitcodes       = $res24['visitcode'];
						    $transamount      = $res24['fxamount'];
						    $totalamount1     = number_format($transamount, 2, '.', '');


					// IF ALREADY ALLOCATED/////////// ALLOCATED AMOUNT ///////////////////
					$query_allocated_amount2 = "SELECT sum(transactionamount) as amount, sum(discount) as discount from master_transactionpaylater where  recordstatus='allocated' and docno='$docno1'";
					$exec_allocated_amount2 = mysqli_query($GLOBALS["___mysqli_ston"], $query_allocated_amount2) or die ("Error in Query_allocated_amount2".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($res_allocated_amount2 = mysqli_fetch_array($exec_allocated_amount2)){
								$allocated_amount2=$res_allocated_amount2['amount'];
							}
					/////////// ALLOCATED AMOUNT ///////////////////
							$credit_pending_amount=$transamount-$allocated_amount2;
						if($credit_pending_amount!=0){
						    $colorloopcount1  = $colorloopcount1 + 1;
						    $showcolor1       = ($colorloopcount1 & 1);
						    $colorcode1       = '';
						    if ($showcolor1 == 0) {
						        //echo "if";
						        $colorcode1 = 'bgcolor="#CBDBFA"';
						    } else {
						        //echo "else";
						        $colorcode1 = 'bgcolor="#ecf0f5"';
						    }
						
						?>

			    <tr <?php echo $colorcode1; ?>>

                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount1; ?></td>

               

                    <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="left"><span class="bodytext32"><?php echo $transactiondate1; ?></span></div>

                </div></td>

						<!-- $accountname1 is for the accountname field which is working -->
				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="left"><span class="bodytext32"><?php echo $subtype_name; ?></span></div>

                </div></td>

					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="left"><span class="bodytext32"><?php echo $docno1; ?></span></div>

                </div></td>

           

                   <td class="bodytext31" valign="center"  align="left">

				  <div align="left"><?php echo $patients; ?></div></td>

           

                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="left"> <span class="bodytext3"> <?php echo $patientcodes; ?> </span> </div>

                </div></td>

				

				<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="left"> <span class="bodytext3"> <?php echo $visitcodes; ?> </span> </div>

                </div></td>

				<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="right"> <span class="bodytext3"> <?php echo number_format($transamount,2,'.',',');  ?> </span> </div>

                </div></td>

           

		   <td  align="center" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="center"> <span class="bodytext3"><a href="accountreceivableentry.php?docno=<?php echo $docno1; ?>">VIEW</a> </span> </div>

                </div></td>

                    </tr>

			  <?php } // if loop ends for pending amount check.

			  }

			  }

			  }

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
                

            

                   

           	</tr>

			<?php 

			}

			?>

		  </tbody>

		  </table>

		  </td>

		  </tr> 
      <!-- ///removed THE CREDIT NOTES ///////// -->
			  </tbody>

			  </table>

		</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

	  

	  <!-- </form> -->

    </table>

  </table>

        </main>
    </div>

    <!-- JavaScript for Modern Functionality -->
    <script>
        // Global variables
        let currentPage = 1;
        let itemsPerPage = 10;
        let allTransactions = [];
        let filteredTransactions = [];

        // Initialize when document is ready
        $(document).ready(function() {
            loadTransactions();
            setupEventListeners();
            setupSidebar();
        });

        // Setup event listeners
        function setupEventListeners() {
            // Search input event
            $('#transactionSearch').on('input', function() {
                filterTransactions();
            });

            // Type filter change
            $('#typeFilter').on('change', function() {
                filterTransactions();
            });

            // Keyboard shortcut for menu toggle
            $(document).on('keydown', function(e) {
                if (e.ctrlKey && e.key === 'm') {
                    e.preventDefault();
                    toggleSidebar();
                }
            });
        }

        // Setup sidebar functionality
        function setupSidebar() {
            $('#menuToggle').on('click', function() {
                toggleSidebar();
            });

            $('#sidebarToggle').on('click', function() {
                toggleSidebar();
            });
        }

        // Toggle sidebar
        function toggleSidebar() {
            const sidebar = $('#leftSidebar');
            const container = $('.main-container-with-sidebar');
            const toggle = $('#menuToggle');
            
            sidebar.toggleClass('collapsed');
            container.toggleClass('sidebar-collapsed');
            toggle.toggleClass('active');
        }

        // Load transactions from server
        function loadTransactions() {
            // Get form values
            const searchType = $('#search_type').val();
            const searchAccount = $('#searchsuppliername').val();
            const searchDocno = $('#docno').val();
            const fromDate = $('#ADate1').val();
            const toDate = $('#ADate2').val();

            // Build query parameters
            const params = new URLSearchParams();
            if (searchType) params.append('search_type', searchType);
            if (searchAccount) params.append('search_account', searchAccount);
            if (searchDocno) params.append('search_docno', searchDocno);
            if (fromDate) params.append('from_date', fromDate);
            if (toDate) params.append('to_date', toDate);

            // Make AJAX call
            $.ajax({
                url: 'get_account_receivable.php',
                method: 'GET',
                data: params.toString(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        allTransactions = response.transactions;
                        filteredTransactions = [...allTransactions];
                        currentPage = 1;
                        renderTable();
                        updatePagination();
                    } else {
                        console.error('Error loading transactions:', response.error);
                        $('#transactionsTableBody').html('<tr><td colspan="9" class="no-data">Error loading data. Please try again.</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    $('#transactionsTableBody').html('<tr><td colspan="9" class="no-data">Error loading data. Please try again.</td></tr>');
                }
            });
        }

        // Filter transactions
        function filterTransactions() {
            const searchTerm = $('#transactionSearch').val().toLowerCase();
            const typeFilter = $('#typeFilter').val();

            filteredTransactions = allTransactions.filter(transaction => {
                const matchesSearch = !searchTerm || 
                    transaction.subtype.toLowerCase().includes(searchTerm) ||
                    transaction.docno.toLowerCase().includes(searchTerm) ||
                    transaction.mode.toLowerCase().includes(searchTerm);

                const matchesType = !typeFilter || transaction.recordstatus === (typeFilter === '1' ? 'allocated' : 'not_allocated');

                return matchesSearch && matchesType;
            });

            currentPage = 1;
            renderTable();
            updatePagination();
        }

        // Clear all filters
        function clearFilters() {
            $('#transactionSearch').val('');
            $('#typeFilter').val('');
            filteredTransactions = [...allTransactions];
            currentPage = 1;
            renderTable();
            updatePagination();
        }

        // Render table with current data
        function renderTable() {
            const tbody = $('#transactionsTableBody');
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const pageData = filteredTransactions.slice(startIndex, endIndex);

            if (pageData.length === 0) {
                tbody.html('<tr><td colspan="9" class="no-data">No transactions found. Try adjusting your search criteria.</td></tr>');
                return;
            }

            tbody.empty();
            pageData.forEach((transaction, index) => {
                const row = `
                    <tr class="table-row ${index % 2 === 0 ? 'even' : 'odd'}">
                        <td class="sno-cell">${startIndex + index + 1}</td>
                        <td class="date-cell">${transaction.transactiondate}</td>
                        <td class="subtype-cell">${transaction.subtype}</td>
                        <td class="docno-cell">${transaction.docno}</td>
                        <td class="mode-cell">${transaction.mode}</td>
                        <td class="inst-number-cell">${transaction.instnumber}</td>
                        <td class="amount-cell">${transaction.transactionamount}</td>
                        <td class="pending-amount-cell">${transaction.pending_amount}</td>
                        <td class="actions-cell">
                            <div class="action-buttons">
                                <a href="accountreceivableentrylist.php?st=upload&&anum=${transaction.auto_number}" class="action-btn upload-btn" title="Upload Document">
                                    <span class="action-icon">📤</span>
                                </a>
                                <a href="accountreceivableentrylist.php?st=submit&&anum=${transaction.auto_number}" class="action-btn submit-btn" title="Submit Transaction">
                                    <span class="action-icon">📝</span>
                                </a>
                                <a href="accountreceivableentrylist.php?st=review&&anum=${transaction.auto_number}" class="action-btn review-btn" title="Review Transaction">
                                    <span class="action-icon">👁️</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                `;
                tbody.append(row);
            });
        }

        // Update pagination controls
        function updatePagination() {
            const totalPages = Math.ceil(filteredTransactions.length / itemsPerPage);
            const startIndex = (currentPage - 1) * itemsPerPage + 1;
            const endIndex = Math.min(currentPage * itemsPerPage, filteredTransactions.length);

            // Update info
            $('#startIndex').text(filteredTransactions.length > 0 ? startIndex : 0);
            $('#endIndex').text(endIndex);
            $('#totalItems').text(filteredTransactions.length);

            // Update buttons
            $('#prevBtn').prop('disabled', currentPage === 1);
            $('#nextBtn').prop('disabled', currentPage === totalPages);

            // Update page numbers
            const pageNumbers = $('#pageNumbers');
            pageNumbers.empty();

            if (totalPages <= 7) {
                // Show all page numbers
                for (let i = 1; i <= totalPages; i++) {
                    pageNumbers.append(`
                        <button class="pagination-btn ${i === currentPage ? 'active' : ''}" onclick="goToPage(${i})">${i}</button>
                    `);
                }
            } else {
                // Show first, last, current, and neighbors
                const pages = [1];
                
                if (currentPage > 3) {
                    pages.push('<span class="pagination-ellipsis">...</span>');
                }
                
                for (let i = Math.max(2, currentPage - 1); i <= Math.min(totalPages - 1, currentPage + 1); i++) {
                    if (!pages.includes(i)) {
                        pages.push(i);
                    }
                }
                
                if (currentPage < totalPages - 2) {
                    pages.push('<span class="pagination-ellipsis">...</span>');
                }
                
                if (totalPages > 1) {
                    pages.push(totalPages);
                }

                pages.forEach(page => {
                    if (typeof page === 'number') {
                        pageNumbers.append(`
                            <button class="pagination-btn ${page === currentPage ? 'active' : ''}" onclick="goToPage(${page})">${page}</button>
                        `);
                    } else {
                        pageNumbers.append(page);
                    }
                });
            }
        }

        // Navigation functions
        function goToPage(page) {
            currentPage = page;
            renderTable();
            updatePagination();
        }

        function previousPage() {
            if (currentPage > 1) {
                currentPage--;
                renderTable();
                updatePagination();
            }
        }

        function nextPage() {
            const totalPages = Math.ceil(filteredTransactions.length / itemsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                renderTable();
                updatePagination();
            }
        }

        function changeItemsPerPage() {
            itemsPerPage = parseInt($('#itemsPerPage').val());
            currentPage = 1;
            renderTable();
            updatePagination();
        }

        // Form submission handler
        $('#searchForm').on('submit', function(e) {
            e.preventDefault();
            loadTransactions();
        });
    </script>

<?php include ("includes/footer1.php"); ?>

</body>

</html>




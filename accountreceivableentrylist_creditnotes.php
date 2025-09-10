<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

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

// if(isset($_GET['docno'])){ $_POST['searchdocno']=$_GET['docno'];  }
// if(isset($_GET['searchaccount'])){ $_POST['searchaccount']=$_GET['searchaccount'];  }
// if(isset($_GET['fromdate'])){ $_POST['fromdate']=$_GET['fromdate'];  }
// if(isset($_GET['todate'])){ $_POST['todate']=$_GET['todate'];  }

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
			echo "<script>window.location.href = 'view_uploaded_excel_directlink.php?docno=$docno_get&&searchaccount=$searchaccount&&searchdocno=$searchdocno&&uploadid=$upload_exid&&fromdate=$fromdate&&todate=$todate&&search_type=$search_type';</script>";
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

<table width="101%" border="0" cellspacing="0" cellpadding="2" >

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

		

		

              <form name="cbform1" method="post" action="accountreceivableentrylist_creditnotes.php">

		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Account Activity -- Credit Notes </strong></td>

              </tr>


			<!-- <tr>
			
			<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Type</td>
			<td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
					<select name="search_type" type="text" id="search_type">
						<option value="0" <?php	 if ($search_type==0){ echo 'selected'; } ?> >Allocate</option>
						<option value="1" <?php if ($search_type==1){ echo 'selected'; }  ?>>Fully Allocate</option>
					</select>
				</span>
			</td>
			</tr> -->

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Subtype</td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">

				<input type="hidden" name="searchsuppliercode" id="searchsuppliercode" value="<?php echo $searchsuppliercode; ?>" size="20" />

				<input type="hidden" name="searchsupplieranum" id="searchsupplieranum" value="<?php echo $searchsupplieranum; ?>" size="20" />

              </span></td>

              </tr> 

			    <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Doc No</td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                <input name="docno" type="text" id="docno" style="border: 1px solid #001E6A;" value="" size="50" autocomplete="off">

              </span></td>

              </tr>

			   

			  <tr>

          <td width="76" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>

          <td width="123" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>

          <td width="51" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>

          <td width="129" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">

            <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>

		  </span></td>

          </tr>

			   <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>

              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">

			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                  <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />

                  <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td>

            </tr>

          </tbody>

        </table>

		</form>		</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      

      <tr>

        <td>&nbsp;</td>

      </tr>

      

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

		
	

		

	  <tr>

        <td>&nbsp;</td>

      </tr>

       <tr>

        <td>

		<table width="708" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td width="700" colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>Credit Notes </strong></td>

              </tr>

			 

	  <tr>

	  <td>

	  <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse"   bordercolor="#666666" cellspacing="0" cellpadding="4" width="800"  align="left" border="0">

          <tbody>

		  <tr>
					<td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><strong>S.No</strong></td>
					<td align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
					<td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Subtype</strong></div></td>
					<td align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Doc No</strong></td>
					<td align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><strong>Patient</strong></td>
					<td align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><strong>Reg.No</strong></td>
					<td class="bodytext31" valign="center"  align="left"  bgcolor="#ffffff"><div align="left"><strong>Visitcode</strong></div></td>
					<td class="bodytext31" valign="center"  align="left"  bgcolor="#ffffff"><div align="left"><strong>Amount</strong></div></td>
					<td align="center" valign="center"   bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action</strong></div></td>
           </tr>

		    <?php 

			$colorloopcount1 = 0;

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

			  

              $query24 = "select * from master_transactionpaylater where accountnameid = '$accountnameid' and transactiontype = 'pharmacycredit' and transactiondate between '$fromdate' and '$todate' group by docno order by auto_number desc";

			  $exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));

			  $num24 = mysqli_num_rows($exec24);

			 // echo $num2;

			  while ($res24 = mysqli_fetch_array($exec24))

			  {

			      $totalamount1=0;

			 	  $transactiondate1 = $res24['transactiondate'];

				  $accountname1 = $res24['accountname'];

				  $docno1 = $res24['docno'];

				  $patients = $res24['patientname'];

				  $patientcodes = $res24['patientcode'];

				  $visitcodes = $res24['visitcode'];

				  $transamount = $res24['fxamount'];

				     

			  $totalamount1 = number_format($transamount,2,'.','');

	

				  

			  $colorloopcount1 = $colorloopcount1 + 1;

			  $showcolor1 = ($colorloopcount1 & 1); 

			  $colorcode1 = '';

				if ($showcolor1 == 0)

				{

					//echo "if";

					$colorcode1 = 'bgcolor="#CBDBFA"';

				}

				else

				{

					//echo "else";

					$colorcode1 = 'bgcolor="#ecf0f5"';

				}

			  ?>

			    <tr <?php echo $colorcode1; ?>>

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

			  <?php

			  }

			 

			  ?>

			  <?php 

			// $colorloopcount1 = 0;

            $query24 = "select * from master_transactionpaylater where accountnameid = '$accountnameid' and transactiontype = 'paylatercredit' and transactiondate between '$fromdate' and '$todate' group by docno order by auto_number desc";

			  $exec24 = mysqli_query($GLOBALS["___mysqli_ston"], $query24) or die ("Error in Query24".mysqli_error($GLOBALS["___mysqli_ston"]));

			  $num24 = mysqli_num_rows($exec24);

			 // echo $num2;

			  while ($res24 = mysqli_fetch_array($exec24))

			  {

			      $totalamount1=0;

			 	  $transactiondate1 = $res24['transactiondate'];

				  $accountname1 = $res24['accountname'];

				  $docno1 = $res24['docno'];

				  $patients = $res24['patientname'];

				  $patientcodes = $res24['patientcode'];

				  $visitcodes = $res24['visitcode'];

				  $transamount = $res24['fxamount'];

				     

			  $totalamount1 = number_format($transamount,2,'.','');

	

				  

			  $colorloopcount1 = $colorloopcount1 + 1;

			  $showcolor1 = ($colorloopcount1 & 1); 

			  $colorcode1 = '';

				if ($showcolor1 == 0)

				{

					//echo "if";

					$colorcode1 = 'bgcolor="#CBDBFA"';

				}

				else

				{

					//echo "else";

					$colorcode1 = 'bgcolor="#ecf0f5"';

				}

			  ?>

			    <tr <?php echo $colorcode1; ?>>

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

                    <div align="right"> <span class="bodytext3"> <?php echo $transamount; ?> </span> </div>

                </div></td>

           

		   <td  align="center" valign="center" class="bodytext31"><div class="bodytext31">

                    <div align="center"> <span class="bodytext3"><a href="accountreceivableentry.php?docno=<?php echo $docno1; ?>">VIEW</a> </span> </div>

                </div></td>

                    </tr>

			  <?php

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

<?php include ("includes/footer1.php"); ?>

</body>

</html>




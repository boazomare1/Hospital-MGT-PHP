<?php

session_start();

error_reporting(0);

//date_default_timezone_set('Asia/Calcutta');

include ("db/db_connect.php");

include ("includes/loginverify.php");

$updatedatetime = date("Y-m-d H:i:s");

$indiandatetime = date ("d-m-Y H:i:s");

$dateonly = date("Y-m-d");
$currentdate = date("Y-m-d");

$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];  
$financialyear = $_SESSION["financialyear"];

$docno1 = $_SESSION['docno'];
$locationname=isset($_REQUEST['locationname'])?$_REQUEST['locationname']:'';
$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
$storecode=isset($_REQUEST['storecode'])?$_REQUEST['storecode']:'';
$store=isset($_REQUEST['store'])?$_REQUEST['store']:'';

$query = "select * from login_locationdetails where username='$username' and docno='$docno1' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
$locationname  = $res["locationname"];
$locationcode = $res["locationcode"];



$titlestr = 'SALES BILL';

$query77 = "select job_title from master_employee where username = '$username'";
$exec77 = mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));
$res77 = mysqli_fetch_array($exec77);
$job_title = $res77['job_title'];


if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
	if($username!='')
	{
	$docno_auto = $_REQUEST['docno'];
	$location = $_REQUEST['location'];
	$status = $_REQUEST['status'];
	$remarks = $_REQUEST['remarks'];
	$priority = $_REQUEST['priority'];
	$purchasetype = $_REQUEST['purchasetype'];
	$currency = explode(',',$_REQUEST['currency']);
	$currency = $currency[1];
	$fxamount = $_REQUEST['fxamount'];
	$jobdescription = $_REQUEST['jobdescription'];


 //  $paynowbillprefix = 'SDBT-';
 //  $paynowbillprefix1=strlen($paynowbillprefix);
 //  $query2 = "SELECT * from supplier_debit_transactions order by auto_number desc limit 0, 1";
 //  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
 //  $res2 = mysql_fetch_array($exec2);
 //  $billnumber = $res2["approve_id"];
 //  $billdigit=strlen($billnumber);
 //  if ($billnumber == '')
 //  {
 //    $billnumbercode ='SDBT-'.'1';
 //  }
 //  else
 //  {
 //    $billnumber = $res2["approve_id"];
 //    $billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
 //    //echo $billnumbercode;
 //    $billnumbercode = intval($billnumbercode);
 //    $billnumbercode = $billnumbercode + 1;
 //   $maxanum = $billnumbercode;
 //    $billnumbercode = 'SDBT-' .$maxanum;
 // //echo $companycode;
 //  }
  
	$searchsuppliername = $_REQUEST['supplier'];
	$searchsuppliercode = $_REQUEST['srchsuppliercode'];
	$searchsupplieranum = $_REQUEST['searchsupplieranum'];
	$fxrate = $_REQUEST['fxamount'];
	// $total_tax = $_REQUEST['total_tax'];
	// $total_amount = $_REQUEST['total_amount'];
	// $grand_total_all = $_REQUEST['grand_total_all'];

	$total_tax = str_replace(',','',$_REQUEST['total_tax'.$p]);
	$total_amount = str_replace(',','',$_REQUEST['total_amount'.$p]);
	$grand_total_all = str_replace(',','',$_REQUEST['grand_total_all'.$p]);
	$fx_total_tax = $fxrate*$total_tax;
	$fx_total_amount = $fxrate*$total_amount;
	$fx_grand_total_all = $fxrate*$grand_total_all;
	$refno = $_REQUEST['refno'];
	$invoiceref = $_REQUEST['invoiceref'];
	$invoicedt = $_REQUEST['invoicedt'];
	$date = $_REQUEST['date'];

	$query56= "INSERT INTO `supplier_debit_transactions`(`approve_id`, `supplier_id`, `clerk_id`, `total_tax_amount`, `total_goods_amount`, `total_amount`, `fx_total_tax_amount`, `fx_total_goods_amount`, `fx_total_amount`, `exchange_rate`, `created_at`,  `record_status`, `user_id`, `ip_address`, `location_code`,`ref_no`) VALUES ('$docno_auto','$searchsuppliercode','','$total_tax','$total_amount','$grand_total_all','$fx_total_tax','$fx_total_amount','$fx_grand_total_all','$fxrate','$date','1','$username','$ipaddress','$locationcode','$refno')";
	$exec56 = mysqli_query($GLOBALS["___mysqli_ston"], $query56) or die("Error in Query56".mysqli_error($GLOBALS["___mysqli_ston"])); 

    for ($p=1;$p<=2000;$p++)

    { 
		$medicinename = $_REQUEST['medicinename'.$p];
		$medicinecode='';
		$pkgqty = str_replace(',','',$_REQUEST['req_qty'.$p]);
		// $reqqty = str_replace(',','',$_REQUEST['req_qty'.$p]);
		$reqqty = $_REQUEST['reqqty'.$p];
		// $rate =$_REQUEST['rate'.$p];
		$tax_percent =$_REQUEST['tax_percent'.$p];
		// $tax_percent =str_replace(',','',$_REQUEST['tax_percent'.$p]) ;
		// $amount =str_replace(',','',$_REQUEST['amount'.$p]);
		// $amount =$_REQUEST['amount'.$p];
		// $description =$_REQUEST['description'.$p];
		$expense =$_REQUEST['expense'.$p];
		$expensecode =$_REQUEST['expenseno'.$p];
		$taxamount = $_REQUEST['taxamount'.$p];
		$rate = $_REQUEST['rate'.$p];
		$amount = $_REQUEST['amount'.$p];
		$fx_taxamount = $fxrate*$_REQUEST['taxamount'.$p];
		$fx_rate = $fxrate*$_REQUEST['rate'.$p];
		$fx_amount = $fxrate*$_REQUEST['amount'.$p];
		if ($medicinename != "")
		{
		$query43="INSERT INTO `supplier_debits`( `invoice_id`, `supplier_id`, `ledger_id`, `ref_number`, `inv_reference`, `invoice_date`, `item_name`,    `required_qty`, `rate`, `tax_percent`, `tax_amount`, `item_amount`, `total_tax_amount`, `total_items_amount`, `total_amount`, `fx_tax_amount`, `fx_item_amount`, `fx_total_tax_amount`, `fx_total_items_amount`, `fx_total_amount`,  `created_at`,`record_status`, `user_id`, `ip_address`, `location_code`) VALUES('$docno_auto','$searchsuppliercode','$expensecode','$refno','$invoiceref','$date','$medicinename','$reqqty','$rate','$tax_percent','$taxamount','$rate','$taxamount','$rate','$amount','$fx_taxamount','$fx_rate','$fx_taxamount','$fx_rate','$fx_amount','$date','1','$username','$ipaddress','$locationcode')";
		$exec43 = mysqli_query($GLOBALS["___mysqli_ston"], $query43) or die("Error in Query43".mysqli_error($GLOBALS["___mysqli_ston"]));     
		}
        }
        
 ?>
        <script>
		window.open("print_supplierdebitnote.php?st=<?php echo '1'; ?>&&docno=<?php echo $docno_auto; ?>", "OriginalWindow", 'width=522,height=650,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
		window.open("supplier_debitnote.php","_self")
	</script>
	<?php	
	} else {  
  
		header("location:supplier_debitnote.php?success=Failed");
       exit;
    }
}

//to redirect if there is no entry in masters category or item or customer or settings


//To get default tax from autoitemsearch1.php and autoitemsearch22.php - for CST tax override.

if (isset($_REQUEST["defaulttax"])) { $defaulttax = $_REQUEST["defaulttax"]; } else { $defaulttax = ""; }

if (isset($_REQUEST["success"])) { $success = $_REQUEST["success"]; } else { $success = ""; }

if(isset($_REQUEST['delete']))

{

$referalname=$_REQUEST['delete'];

mysqli_query($GLOBALS["___mysqli_ston"], "delete from consultation_referal where referalname='$referalname'");

}

//$defaulttax = $_REQUEST["defaulttax"];

if ($defaulttax == '')

{

  $_SESSION["defaulttax"] = '';

}

else

{

  $_SESSION["defaulttax"] = $defaulttax;

}

if(isset($_REQUEST["patientcode"]))

{

$patientcode=$_REQUEST["patientcode"];

$visitcode=$_REQUEST["visitcode"];

}





//This include updatation takes too long to load for hunge items database.





//To populate the autocompetelist_services1.js





//To verify the edition and manage the count of bills.

$thismonth = date('Y-m-');

$query77 = "select * from master_edition where status = 'ACTIVE'";

$exec77 =  mysqli_query($GLOBALS["___mysqli_ston"], $query77) or die ("Error in Query77".mysqli_error($GLOBALS["___mysqli_ston"]));

$res77 = mysqli_fetch_array($exec77);

$res77allowed = $res77["allowed"];







/*

$query99 = "select count(auto_number) as cntanum from master_quotation where quotationdate like '$thismonth%'";

$exec99 = mysql_query($query99) or die ("Error in Query99".mysql_error());

$res99 = mysql_fetch_array($exec99);

$res99cntanum = $res99["cntanum"];

$totalbillandquote = $res88cntanum + $res99cntanum; //total of bill and quote in current month.

if ($totalbillandquote > $res77allowed)

{

  //header ("location:usagelimit1.php"); // redirecting.

  //exit;

}

*/



//To Edit Bill

if (isset($_REQUEST["delbillst"])) { $delbillst = $_REQUEST["delbillst"]; } else { $delbillst = ""; }

//$delbillst = $_REQUEST["delbillst"];

if (isset($_REQUEST["delbillautonumber"])) { $delbillautonumber = $_REQUEST["delbillautonumber"]; } else { $delbillautonumber = ""; }

//$delbillautonumber = $_REQUEST["delbillautonumber"];

if (isset($_REQUEST["delbillnumber"])) { $delbillnumber = $_REQUEST["delbillnumber"]; } else { $delbillnumber = ""; }

//$delbillnumber = $_REQUEST["delbillnumber"];



if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

//$frm1submit1 = $_REQUEST["frm1submit1"];









if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

//$st = $_REQUEST["st"];

if (isset($_REQUEST["banum"])) { $banum = $_REQUEST["banum"]; } else { $banum = ""; }

//$banum = $_REQUEST["banum"];

if ($st == '1')

{

  $errmsg = "Success. New Bill Updated. You May Continue To Add Another Bill.";

  $bgcolorcode = 'success';

}

if ($st == '2')

{

  $errmsg = "Failed. New Bill Cannot Be Completed.";

  $bgcolorcode = 'failed';

}

if ($st == '1' && $banum != '')

{

  $loadprintpage = 'onLoad="javascript:loadprintpage1()"';

}



if ($delbillst == "" && $delbillnumber == "")

{

  $res41customername = "";

  $res41customercode = "";

  $res41tinnumber = "";

  $res41cstnumber = "";

  $res41address1 = "";

  $res41deliveryaddress = "";

  $res41area = "";

  $res41city = "";

  $res41pincode = "";

  $res41billdate = "";

  $billnumberprefix = "";

  $billnumberpostfix = "";

}









?>





<?php

// $query3 = "SELECT * from master_company where companystatus = 'Active'";

// $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());

// $res3 = mysql_fetch_array($exec3);

$paynowbillprefix = 'SDBT-';

$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "SELECT * from supplier_debit_transactions order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["approve_id"];

$billdigit=strlen($billnumber);

if ($billnumber == '')

{

  $billnumbercode ='SDBT-'.'1';
 

}

else

{

  $billnumber = $res2["approve_id"];

  $billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

  //echo $billnumbercode;

  $billnumbercode = intval($billnumbercode);

  $billnumbercode = $billnumbercode + 1;



  $maxanum = $billnumbercode;

  
  $billnumbercode = 'SDBT-' .$maxanum;
 
  //echo $companycode;

}

$query = "select * from login_locationdetails where username='$username' and docno='$docno1' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

  

   $locationname  = $res["locationname"];

   $locationcode = $res["locationcode"];



$query23 = "select * from master_employeelocation where username='$username' and defaultstore='default' and locationcode='".$locationcode."'";

$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res23 = mysqli_fetch_array($exec23);



$res7storeanum = $res23['storecode'];

$query75 = "select * from master_store where auto_number='$res7storeanum'";

$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res75 = mysqli_fetch_array($exec75);

$store = $res75['store'];

$storecode = $res75['storecode'];



?>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />

<link rel="stylesheet" type="text/css" href="css/autocomplete.css" />  



<script language="javascript">

function deletevalid()

{
var del;
del=confirm("Do You want to delete this referal ?");
if(del == false)
{
return false;
}

}

function btnDeleteClick10(delID4,vrate4,tax,gamount)
{
  //alert ("Inside btnDeleteClick.");
  var newtotal;
  //alert(delID4);
  var varDeleteID4= delID4;
  //alert(vrate4);
  //alert (varDeleteID3);
  var fRet7; 
  fRet7 = confirm('Are You Sure Want To Delete This Entry?'); 
  //alert(fRet); 
  if (fRet7 == false)
  {
    //alert ("Item Entry Not Deleted.");
    return false;
  }
  var child4 = document.getElementById('idTR'+varDeleteID4);  
  //alert (child3);//tr name
    var parent4 = document.getElementById('insertrow'); // tbody name.

  document.getElementById ('insertrow').removeChild(child4);
  var child4= document.getElementById('idTRaddtxt'+varDeleteID4);  //tr name
    var parent4 = document.getElementById('insertrow'); // tbody name.

  
  if (child4 != null) 
  {
    //alert ("Row Exsits.");
    document.getElementById ('insertrow').removeChild(child4);
  }
  var currenttotal=document.getElementById('total').value.replace(/[^0-9\.]+/g,"");
  //alert(currenttotal);
  newtotal= currenttotal-vrate4;
//alert(newtotal);
document.getElementById('total').value=formatMoney(newtotal.toFixed(2));

  var taxamount=document.getElementById('total_tax').value.replace(/[^0-9\.]+/g,"");
  newtotaltax= taxamount-tax;
  document.getElementById('total_tax').value=formatMoney(newtotaltax.toFixed(2));

  var gdamount=document.getElementById('total_amount').value.replace(/[^0-9\.]+/g,"");
  newtotal_gamount= gdamount-gamount;
  document.getElementById('total_amount').value=formatMoney(newtotal_gamount.toFixed(2));
 currencyfix();  
}
</script>

<?php //include ("js/sales1scripting1.php"); ?>

<script language="javascript">

$(document).ready(function(){
  
  $('.allowdecimal').keypress(function (event) {
      return isNumber(event, this)
  });

});

  function is_int(){ 
    // var decimal=  /^[-+]?[0-9]+\.[0-9]+$/; 
    // var decimal= /^[-+][0-9]+\.[0-9]+[eE][-+]?[0-9]+$/;  

// if(as.match(decimal)) {
  var v=document.getElementById("req_qty").value;
  if((parseFloat(v) == parseInt(v)) && !isNaN(v)){
      return true;
  } else { 
  alert("Quantity should be integer");
  $('#req_qty').val('0.00');
 // if (isNaN(amount)) a = 0;
      return false;
  } 
}

  function is_int_r(value){ 
  if((parseFloat(value) == parseFloat(value)) && !isNaN(value)){
      return true;
  } else { 
  // alert("Rate should be In numbers");
  document.getElementById("rate_fx").value='0';
  
      return false;
  } 
}

  function CalculateAmount(){

// /^\d*$/.req_qty(value);
// /^\d*$/.rate_fx(value);


 var medicinename = $('#medicinename').val();
var item_code = '';
 if(medicinename == '')
 {
   alert('Please Enter Item Description');
   $('#req_qty').val('');
   $('#medicinename').focus();
 }

  var req_qty=($.trim($('#req_qty').val())!='')?$.trim($('#req_qty').val()):'0';
  // var req_qty=($.trim($('#req_qty').val())!='')?$.trim($('#req_qty').val()):'0';
  // is_int_q(req_qty);
  // var rate=($.trim($('#rate_fx').val())!='');
  var rate=($.trim($('#rate_fx').val())!='')?$.trim($('#rate_fx').val()):'0.00';
  // $('#rate_fx').val(rate);
  is_int_r(rate);
  
  var tax=$('#tax_percent').val();
  // var percent=tax_data.split('|');
  // var tax=percent[1];
  // var exclude_goods=percent[0];
  // if(exclude_goods==1)
  // {
  //   tax=0;
  // }
  //var tax=$.trim($('#tax_template_value').val());
  var fxrate=($.trim($('#fxrate').val())!='')?$.trim($('#fxrate').val()):'1.00';
  //var fxrate=
    var package_qnty = $('#package_qty').val();
 
 var main_rate = $('#rate') .val();
 
 if(req_qty!='0' && item_code == '' && medicinename!='' && tax!='')
 {
   $('#rate_fx').prop('readonly',false);
   $('#rate').val(rate);
   $('#pack_size').val('1S');
    var req_pkg_qnty = parseFloat(req_qty)/1;
   $('#pkg_qty').val(req_pkg_qnty);
 }
 else 
 {
   var req_pkg_qnty = parseFloat(req_qty)/parseFloat(package_qnty);
  
  $('#pkg_qty').val(req_pkg_qnty);
 }

 // if(req_qty=='0' || req_qty=="")
 // {
 //   $('#amount').val('0.00');
 // }else{
 
 var total_main_amount = parseFloat(req_qty*main_rate);
  $('#main_amount').val(total_main_amount);
  
  // rate=(rate/fxrate);
  var total1=parseFloat(req_qty*rate);
 
  var total2=parseFloat(total1*tax) / 100;
  $('#taxamount').val(total2);
   var total3=parseFloat(total2+total1);
    // var total_amount=parseFloat(req_qty*rate).toFixed(2); 
     var total_amount1=parseFloat(total3).toFixed(2); 
     $('#amount').val(total_amount1);
     console.log(~~NaN);
   // }
  
}

function calc()
{
  var reqqty=document.getElementById("reqqty").value;
  var packsize=document.getElementById("packsize").value;
  var purchasetype=document.getElementById("purchasetype").value;
  var fxamount=document.getElementById("fxamount").value;
  var packvalue=packsize.substring(0,packsize.length - 1);

  
  var rt = document.getElementById("rate").value.replace(/[^0-9\.]+/g,"");
  document.getElementById("fxrate").value=parseFloat(fxamount*rt);
  var rate=document.getElementById("fxrate").value.replace(/[^0-9\.]+/g,"");
    rate = parseFloat(rate)/parseFloat(fxamount);

  //}

  if(reqqty!='')
      reqqty = reqqty.replace(/[^0-9\.]+/g,"");
  var amount=parseFloat(reqqty) * parseFloat(rate);
  document.getElementById("amount").value=formatMoney(amount.toFixed(2));
  var pkgqty=reqqty/packvalue;
  packvalue=parseInt(packvalue);
  if(reqqty < packvalue)
  {
    pkgqty=1;
  } 

  if(purchasetype!='non-medical')
  {
    document.getElementById("pkgqty").value=Math.round(pkgqty);
  }
  else
  {
  document.getElementById("pkgqty").value=Math.round(1);
  }
  
}

function formatMoney(number, places, thousand, decimal) {

  number = number || 0;

  places = !isNaN(places = Math.abs(places)) ? places : 2;

  

  thousand = thousand || ",";

  decimal = decimal || ".";

  var negative = number < 0 ? "-" : "",

      i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",

      j = (j = i.length) > 3 ? j % 3 : 0;

  return  negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");



}

</script>

<script type="text/javascript" src="js/supplier_debitnote_insert.js"></script>

<script src="js/datetimepicker_css_fin.js"></script>
<?php include ("js/dropdownlist1scriptingpurchaseorder.php"); ?>
<script type="text/javascript" src="js/autocomplete_purchaseorder.js"></script>
<script type="text/javascript" src="js/autosuggestpurchaseorder.js"></script>

<style type="text/css">

.bodytext3 {  FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

body {

  margin-left: 0px;

  margin-top: 0px;

  background-color: #ecf0f5;

}

.style1 {

  font-size: 36px;

  font-weight: bold;

}

.style2 {

  font-size: 18px;

  font-weight: bold;

}

.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }

.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

input[name="priority"] {

  -webkit-appearance: checkbox; /* Chrome, Safari, Opera */

  -moz-appearance: checkbox;    /* Firefox */

  -ms-appearance: checkbox;     /* not currently supported */

}

</style>



<script src="js/datetimepicker_css_fin.js"></script>

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<?php //include("autocompletebuild_medicine1.php"); ?>

<?php //include("js/dropdownlist1scriptingmedicine1.php"); ?>

<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>

<script type="text/javascript" src="js/autocomplete_medicine1.js"></script>

<script type="text/javascript" src="js/automedicinecodesearch5kiambu1.js"></script>

<script type="text/javascript" src="js/jquery.min-autocomplete.js"></script>

<script type="text/javascript" src="js/jquery-ui.min.js"></script>

<script type="text/javascript">
  function exp(){
  
$('#expense').autocomplete({

  source:'autoexpensesearch.php', 

  select: function(event,ui){

      var code = ui.item.id;

      var anum = ui.item.anum;

      $('#expenseno').val(code);

      $('#expenseanum').val(anum);

      },

  html: true

    });
};
  $(function() {
$('#supplier').autocomplete({
  source:'ajaxsuppliernewserach.php', 
  select: function(event,ui){
      var code = ui.item.id;
      var anum = ui.item.anum;
      $('#srchsuppliercode').val(code);
      $('#searchsupplieranum').val(anum);
      // this.form.submit();
      },
  html: true
    });

  /*$('#supplier').change(function() {
        if($('#srchsuppliercode').val() !="")
        this.form.submit();
    });*/
   
});


function clickmedicine()

{
  var currency=document.getElementById("currency").value;
  if(currency=='')
  {
    alert('Please Select currency');
    document.getElementById("currency").focus();
    return false;
  }
  var supplier=document.getElementById("supplier").value;
  if(supplier=='')
  {
    alert('Please Select Supplier');
    document.getElementById("supplier").focus();
    return false;
  }
}

function check(){
  var refno= $('#refno').val();
  // var invoiceref= $('#invoiceref').val();
  var supplier= $('#supplier').val();
  var total_final= $('#total').val();
  if(supplier==""){
    alert('Select the supplier');
    document.getElementById("supplier").focus();
    return false;
  }
  if(refno==""){
    alert('Enter the refno');
    document.getElementById("refno").focus();
    return false;
  }
  // if(invoiceref==""){
  //   alert('Enter the Invoice Reference');
  //   document.getElementById("invoiceref").focus();
  //   return false;
  // }
  if(total_final==""){
    alert('Add Atlest one  description');
    document.getElementById("invoiceref").focus();
    return false;
  }
  
}

</script>

</head>

      

<body>

<form name="form1" id="frmsales" method="post" action="supplier_debitnote.php" onSubmit="return check();" >

<table width="101%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>

  </tr>



  <tr>

    <td width="1%">&nbsp;</td>

    <td width="99%" valign="top"><table width="980" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

            <tbody>

              <?php if($success=='success'){?>

        <tr>

          <td colspan="8" align="left" valign="middle"  bgcolor="#FF9933" class="bodytext3"><strong>Transaction SucessFully Saved</strong></td>

                

          </tr>

      <?php }?>

        <tr>

          <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>DOC No</strong></td>

                <td width="12%" align="left" valign="top" >

        <input name="docno" id="docno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A;" size="10" autocomplete="off" readonly/>                  </td>

                 <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Date</strong></td>

                <td width="12%" align="left" valign="top" >

        <input name="date" id="date" value="<?php echo $dateonly; ?>" style="border: 1px solid #001E6A" size="10" rsize="20" readonly/>    
<img src="images2/cal.gif" onClick="javascript:NewCssCal('date','yyyyMMdd','','','','','past','','<?php echo date('Y-m-d');?>')" style="cursor:pointer"/>
		</td>

                <!-- <td width="9%" align="left" valign="middle" class="bodytext3" ><strong>Store</strong></td>

                <td width="18%" align="left" valign="top" ><input type="text" name="store" id="store" value="<?php echo $store; ?>" size="18" rsize="20" style="border: 1px solid #001E6A">

                <input type="hidden" name="storecode" id="storecode" value="<?php echo $storecode; ?>" size="18" rsize="20" style="border: 1px solid #001E6A">

                </td> -->

                <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Location</strong></td>

                <td width="20%" colspan="3" align="left" valign="top" >

        <input name="location" id="location" value="<?php echo $locationname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/> 

                <input type="hidden" name="locationcode" value="<?php echo $locationcode?>">      </td>

          </tr>

                

                <tr>

          <!-- <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Purchase Type</strong></td>

                <td width="12%" align="left" valign="top" >

        <select id="purchasetype" name="purchasetype" onChange="functiontransactionfx()" style="border:#F00 1px solid">

                <option value=''>Select</option>

                <?php

                $query16 = "select name from master_purchase_type where status <> 'deleted' order by id";

        $exec16 = mysqli_query($GLOBALS["___mysqli_ston"], $query16) or die ("Error in Query16".mysqli_error($GLOBALS["___mysqli_ston"]));

        while ($res16 = mysqli_fetch_array($exec16))

        {

        $purchasetype = $res16["name"];

        ?>

                <option value="<?= $purchasetype; ?>"><?= $purchasetype; ?></option>

        <?php

        }

        ?>

                </select>

                </td> -->

                 <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Currency</strong></td>

                <td width="12%" align="left" valign="top" >

        <select  name="currency" id="currency"  >
          <!-- onChange="return functioncurrencyfx(this.value)" -->

                   <option value="">Select Currency</option>

                    <?php

          $query1currency = "select currency,rate from master_currency where recordstatus = '' ";

          $exec1currency = mysqli_query($GLOBALS["___mysqli_ston"], $query1currency) or die ("Error in Query1currency".mysqli_error($GLOBALS["___mysqli_ston"]));

          while ($res1currency = mysqli_fetch_array($exec1currency))

          {

          $currency = $res1currency["currency"];

          $rate = $res1currency["rate"];

          ?>

                  <option value="<?php echo $rate.','.$currency; ?>" selected><?php echo $currency; ?></option>

                  <?php

          }

          ?>

                    

                  

                   </select>        </td>

                <td width="9%" align="left" valign="middle" class="bodytext3" ><strong>FX Rate</strong></td>

                <td width="18%" align="left" valign="top" ><input name="fxamount" type="text" id="fxamount" size="8" value="1" readonly>
                 </td>

               <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Supplier</strong></td>
                <td width="27%" align="left" valign="middle" class="bodytext3">
        <input  type="text" name="supplier" id="supplier" value="<?php echo $suppliername; ?>" size="25" autocomplete="off" style="text-transform:uppercase;width:300px" />    
        <input type="hidden" name="srchsuppliercode" id="srchsuppliercode" value="<?php echo $suppliercode; ?>">
         <input type="hidden" name="searchsupplieranum" id="searchsupplieranum"  value="<?php echo $srchsupplieranum ?>" size="20" />
          </td>



                <!-- <td width="11%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>Supplier Name</strong></td>

                <td width="20%" colspan="3" align="left" valign="top" >

                <input name="searchsuppliername" type="text" id="searchsuppliername" value="" size="30" autocomplete="off">

                <input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" />

         <input type="hidden" name="searchsupplieranum" id="searchsupplieranum" style="text-transform:uppercase" value="<?php echo $searchsupplieranum; ?>" size="20" />

          </td> -->


          </tr>
          <tr>
              <td width="9%" align="left" valign="middle" class="bodytext3" ><strong>Ref No.</strong></td>
              <td width="18%" align="left" valign="top" ><input name="refno" type="text" id="refno" size="8" value="" > </td>

              <!-- <td width="9%" align="left" valign="middle" class="bodytext3" ><strong>Invoice Reference</strong></td> -->
              <!-- <td width="18%" align="left" valign="top" > -->
                <input name="invoiceref" type="hidden" id="invoiceref"   value="" >
                 <!-- </td> -->

              <!-- <td width="9%" align="left" valign="middle" class="bodytext3" ><strong>Invoice Date</strong></td> -->
              <!-- <td width="18%" align="left" valign="top" > -->
                <input name="invoicedt" type="hidden" id="invoicedt"   value="<?php echo $dateonly; ?>" readonly>
                 <!-- </td> -->
          </tr>

                <?php 

        $query1mail = "select emailto,emailcc from master_email where recordstatus <> 'deleted' and module='Purchase Indent' order by auto_number desc";

        $exec1mail = mysqli_query($GLOBALS["___mysqli_ston"], $query1mail) or die ("Error in Query1mail".mysqli_error($GLOBALS["___mysqli_ston"]));

        while ($res1mail = mysqli_fetch_array($exec1mail))

        {

          $emailto = $res1mail["emailto"];

          $emailcc = $res1mail["emailcc"];

        }

        $query1mail = "select mei.email,me.jobdescription from master_employee me,master_employeeinfo mei where me.username='$username' and me.employeecode=mei.employeecode";

        $exec1mail = mysqli_query($GLOBALS["___mysqli_ston"], $query1mail) or die ("Error in Query1mail".mysqli_error($GLOBALS["___mysqli_ston"]));

        while ($res1mail = mysqli_fetch_array($exec1mail))

        {

          $useremail = $res1mail["email"];

          $jobdescription = $res1mail["jobdescription"];

        }

        ?>

                <!--<tr>

          <td width="10%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>From</strong></td>

                <td colspan="2" align="left" valign="top" ><?php echo $useremail;?></td>

                 <td width="8%" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><strong>To</strong></td>

                <td colspan="2" align="left" valign="top" ><?php echo $emailto;?></td>

                <td width="9%" align="left" valign="middle" class="bodytext3" ><strong>CC</strong></td>

                <td colspan="2" align="left" valign="top" ><?php echo $emailcc;?></td>

          </tr>
-->

        <input type="hidden" name="piemailfrom" id="piemailfrom" value="<?php echo $useremail;?>"><input type="hidden" name="jobdescription" id="jobdescription" value="<?php echo $jobdescription;?>">
        <input type="hidden" name="bamailfrom" id="bamailfrom" value="<?php echo $emailto;?>">
        <input type="hidden" name="bamailcc" id="bamailcc" value="<?php echo $emailcc;?>">
                

            </tbody>

        </table></td>

      </tr>

      <tr>

    <td>&nbsp;

    </td>

    </tr>

      <tr id="pressid">

           <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

           <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">

                     <tr>

                       <td width="150" class="bodytext3">Item Description </td>

                       <!-- <td width="48" class="bodytext3"> Description</td> -->

                       <!-- <td width="41" class="bodytext3">Req Qty</td>

                       <td width="48" class="bodytext3">Pack Size</td>

                       <td width="48" class="bodytext3">Pkg Qty</td>   -->                    

                       <td class="bodytext3">Rate</td>
                       <td class="bodytext3">Tax%</td>
                       <td class="bodytext3">Tax Amount</td>

                       <td width="48" class="bodytext3">Amount</td>
                        <td width="120" class="bodytext3">Ledger</td>

                     </tr>

           <tr>

           <div id="insertrow">          </div></tr>

                     <tr>

            <input type="hidden" name="serialnumber" id="serialnumber" value="1">

                       <td><input name="medicinename" type="text" id="medicinename" size="25" autocomplete="off"  onClick="clickmedicine();">

             <input type="hidden" name="medicinenamel" id="medicinenamel" value="">

             </td>
               <!-- <td><input name="description" type="text" id="description" size="25" autocomplete="off"  ></td> -->
                        <input class="allowdecimal" value="1" name="req_qty" type="hidden" id="req_qty" size="8" onkeyup="CalculateAmount()" > 
                       
                       <td width="48">
                        <!-- <input name="rate" type="text" id="rate"  size="8" onkeyup="CalculateAmount()" > -->

                        <input  id="rate_fx" name="rate_fx" type="text" onkeyup="CalculateAmount()" >
                   <input  id="rate" name="rate" type="hidden" readonly="readonly">

                          <!-- <input name="fxrate" type="hidden" id="fxrate"  size="8"> -->
                          </td>
                          <td class="bodytext31" valign="center"  align="left" ><div align="center">
                                            <select name="tax_percent" id="tax_percent" style="width: 150px;"  onchange="CalculateAmount()">>
                                              <option value="">--Select--</option>
                                              <?php 
                                              $query_wht = "SELECT * from master_tax";
                                      $exec_wht = mysqli_query($GLOBALS["___mysqli_ston"], $query_wht) or die ("Error in query_wht".mysqli_error($GLOBALS["___mysqli_ston"]));
                                      while ($res_wht = mysqli_fetch_array($exec_wht))
                                      { ?>
                                    <option value="<?=$res_wht['taxpercent'];?>"><?=ucwords($res_wht['taxname']) ;?></option>
                                      <?php }
                                        ?>
                                            </select>

                        </div></td>

                        <td> <input name="taxamount" type="text" id="taxamount" readonly=""   size="8"></td>
                        <td> <input name="amount" type="text" id="amount" readonly=""   size="8"></td>

                        <td class="bodytext31" valign="center"  align="left">
                          <input name="expense" id="expense" onKeyup="return exp()" value="" size="30" rsize="40" autocomplete="off"/>
                          <input name="expenseno" id="expenseno" value="" type="hidden" />
                          <input name="expenseanum" id="expenseanum" value="" type="hidden" />
                        </td>

                       <td><label>

                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem10()" class="button" style="border: 1px solid #001E6A">

                       </label></td>

             </tr>

                     

           <input type="hidden" name="h" id="h" value="0">

                   </table>         </td>

             </tr>

                <tr><td colspan="8">&nbsp;</td>&nbsp;</tr>
                <tr>&nbsp;</tr>

                <tr>
                <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Goods Amount&nbsp;:&nbsp;&nbsp;</span><input type="text" id="total_amount" name="total_amount" readonly size="7"></td>
                </tr>

                <tr>
                <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Tax Amount&nbsp;:&nbsp;&nbsp;</span><input type="text" id="total_tax" name="total_tax" readonly size="7"></td>
                </tr>
                <tr>
                <td colspan="8" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3"><span class="style2">Total Amount&nbsp;:&nbsp;&nbsp;</span><input type="text" id="total" name="grand_total_all" readonly size="7"></td>
                </tr>

          <tr>

    <td>&nbsp;

    </td>

    </tr>

      <tr>

    <td>

    

    </td>

    </tr>       

            

      <tr>

        

     <td colspan="2" align="right" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

      <input type="hidden" name="frm1submit1" value="frm1submit1" />

                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />

               <input name="Submit222" type="submit" onclick="return confirm('Are you sure you want to Save this?');"  value="Save" class="button" id="saveindent" style="border: 1px solid #001E6A"/>    </td>

      </tr>

    </table>

      </td>

      </tr>


  </table>

</form>

<?php include ("includes/footer1.php"); ?>

<?php //include ("print_bill_dmp4inch1.php"); ?>

</body>

</html>
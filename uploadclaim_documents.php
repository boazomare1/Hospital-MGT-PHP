<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$updatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$searchsubtype = "";
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
 $total = "0.00";
 
 $docno=$_SESSION["docno"];
$username = $_SESSION["username"];
$query01="select locationcode from login_locationdetails where docno ='$docno' and username='$username' order by auto_number desc";
$exc01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);
$res01=mysqli_fetch_array($exc01);
$slocation = $res01['locationcode'];
 
 
 
if (isset($_REQUEST["visitcode"])) {$visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 $locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where locationcode='$locationcode1' and auto_number = '$getcanum'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$res4 = mysqli_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}

$query_acc = "SELECT * FROM finance_ledger_mapping WHERE map_anum = '20' AND record_status <> 'deleted'";
$exec_acc = mysqli_query($GLOBALS["___mysqli_ston"], $query_acc) or die ("Error in Query_acc".mysqli_error($GLOBALS["___mysqli_ston"]));
$ledgername = '';
$res_acc = mysqli_fetch_array($exec_acc);

$accountcode1 = $res_acc['ledger_id'];
$accountname1 = trim($res_acc['ledger_name']);

if (isset($_REQUEST["searchsuppliername1"])) { $searchsuppliername = $_REQUEST["searchsuppliername1"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchsubtypeanum1"])) { $searchsubtypeanum1 = $_REQUEST["searchsubtypeanum1"]; } else { $searchsubtypeanum1 = ""; }
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
if($frmflag2 == 'frmflag2')
{}

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $transactiondatefrom; }

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $transactiondateto; }




if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if (isset($_REQUEST["printno"])) { $printno = $_REQUEST["printno"]; } else { $printno = ""; }
if($st == 'printsuccess')
{
?>
<script>
window.open("print_deliverysubpdf2.php?printno=<?php echo $printno; ?>");
</script>
<?php
}
?>
<style type="text/css">
th {
            background-color: #ffffff;
            position: sticky;
            top: 0;
            z-index: 1;
        }
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
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script type="text/javascript" src="js/autocomplete_accounts2.js"></script>
<script type="text/javascript" src="js/autosuggest4accounts.js"></script>
 <link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style3 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>


<script type="text/javascript">


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



window.onload = function () 
{
	var oTextbox = new AutoSuggestControl1(document.getElementById("searchsuppliername1"), new StateSuggestions1());
	
}
</script>
<script>

</script>
<script language="javascript">

function cbsuppliername1()
{
	document.cbform1.submit();
}

function funcAccount1()
{}

function validcheck()
{

if(confirm("Do You Want To Save The Record?")==false){
	return false;
}	
return true;

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

/*input[type="file"] {*/
 /*  content: 'Select some files';
  display: inline-block;
  background: linear-gradient(top, #f9f9f9, #e3e3e3);
  border: 1px solid #999;
  border-radius: 3px;
  padding: 5px 8px;
  outline: none;
  white-space: nowrap;
  -webkit-user-select: none;
  cursor: pointer;
  text-shadow: 1px 1px #fff;
  font-weight: 700;
  font-size: 10pt;*/
 /*width:80px;*/
/*}*/
 
</style>
<!-- <script src="https://code.jquery.com/jquery-1.10.2.js"></script> -->

<script src="js/jquery-1.11.1.min.js"></script>
<!-- <script src="js/jquery.min-autocomplete.js"></script> -->
<script src="js/jquery-ui.min.js"></script>
<script type="text/javascript">

// $('input[type=file]').change(function () {
//     console.log(this.files[0].mozFullPath);
// });


function update_claimdetails(visitcode,sno,source,billno)
{
		var get_file=$("#file_upload"+sno).val();	
		var autono_final = sno;
		var mainsource='claimform';
		var property = document.getElementById('file_upload'+autono_final).files[0];
		var image_name = property.name;
		var image_extension = image_name.split('.').pop().toLowerCase();
		if(jQuery.inArray(image_extension,['pdf']) == -1){
		alert("Please Upload only the PDF files!");
		return false;
		}
		
		var check = confirm("Are you sure you want to Upload the "+image_name+"?");
		if (check != true) {
		$('#file_upload'+autono_final).val('');
		return false;
		}
		
		var form_data = new FormData();
		form_data.append("file",property);
		 // alert(form_data);
		$.ajax({
		url:'slade-claim-attachment.php?visitcode='+visitcode+'&&sno='+sno+'&&get_file='+image_name+'&&source='+source+'&&billno='+billno+'&&mainsource='+mainsource,
		method:'POST',
		data:form_data,
		contentType:false,
		cache:false,
		processData:false,
		success:function(data){
		//$('#idTR'+sno).hide();
		$('#idTR'+sno).css('background-color','#00FF00');
		}
		});	
	
}



function update_claimdetails_ds(visitcode,sno,source,billno)
{
		var get_file=$("#dis_summ_upload"+sno).val();	
		var autono_final = sno;
		var mainsource='discharge';
		var property = document.getElementById('dis_summ_upload'+autono_final).files[0];
		var image_name = property.name;
		var image_extension = image_name.split('.').pop().toLowerCase();
		if(jQuery.inArray(image_extension,['pdf']) == -1){
		alert("Please Upload only the PDF files!");
		return false;
		}
		
		var check = confirm("Are you sure you want to Upload the "+image_name+"?");
		if (check != true) {
		$('#file_upload'+autono_final).val('');
		return false;
		}
		
		var form_data = new FormData();
		form_data.append("file",property);
		 // alert(form_data);
		$.ajax({
		url:'slade-claim-attachment.php?visitcode='+visitcode+'&&sno='+sno+'&&get_file='+image_name+'&&source='+source+'&&billno='+billno+'&&mainsource='+mainsource,
		method:'POST',
		data:form_data,
		contentType:false,
		cache:false,
		processData:false,
		success:function(data){
		$('#idTR'+sno).css('background-color','#00FF00');
		}
		});	
	
}



function upload_invoice(autono,billno,maintype){
	FuncPopup();
	var autono_final = autono;
	var billno = billno;
	var maintype = maintype;
	var property = document.getElementById('invoicepdf'+autono_final).files[0];
        var image_name = property.name;
        var image_extension = image_name.split('.').pop().toLowerCase();
        if(jQuery.inArray(image_extension,['pdf']) == -1){
          alert("Please Upload only the PDF files!");
          $("#imgloader").hide();
          $('#invoicepdf'+autono_final).val('');
          return false;
        }

        var check = confirm("Are you sure you want to Upload the "+image_name+"?");
         if (check != true) {
         	$("#imgloader").hide();
         	$('#invoicepdf'+autono_final).val('');
            return false;
        	}

        var form_data = new FormData();
        form_data.append("file",property);
        // alert(form_data);
        $.ajax({
          url:'upload_files.php?auto='+autono_final+'&&uploadtype=invoice&&uploadfrom=delivery&&billno='+billno+'&&maintype='+maintype,
          method:'POST',
          data:form_data,
          contentType:false,
          cache:false,
          processData:false,
          // 
          success:function(data){
            // alert(data);
             $('#invoicepdf'+autono_final).val('');
             $("#imgloader").hide();
             $("#invoicepdfview"+autono_final).show();
             return checkbox_hide(autono_final,maintype);
          }
        });
        	 // $('#invoicepdf'+autono_final).val('');
             // $("#imgloader").hide();
}

function checkbox_hide(auto,maintype){
	var auotnumber2=auto;
	var maintype=maintype;
	// alert(auotnumber2);
	$.ajax({
          url:'upload_files.php?auto='+auotnumber2+'&&uploadtype=checkboxcheck&&maintype='+maintype,
          method:'POST',
          success:function(response){
            // alert(data);
					var result = $.trim(response);
					if(result==="success"){
					 		$(".checkbox"+auotnumber2).show();
							return false;
					}
          }
        });
}
 
function FuncPopup()
{
	window.scrollTo(0,0);
	document.getElementById("imgloader").style.display = "";
}
</script>
<style type="text/css">
.imgloader { background-color:#FFFFFF; }
#imgloader1 {
    position: absolute;
    /*margin: auto;*/
    top: 200px;
    left: 487px;
    width: 28%;
    height: 24%;
}
</style>
 
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
	<div align="center" class="imgloader" id="imgloader" style="display:none;">
		<div align="center" class="imgloader" id="imgloader1" style="display:;">
			<p style="text-align:center;"><strong>Upload in Progress <br><br> Please be patience...</strong></p>
			<img src="images/ajaxloader.gif">
		</div>
	</div>
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
		
		
              <form name="cbform1" method="post" action="uploadclaim_documents.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Claim Attachments-Slade</strong></td>
              <td colspan="2" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
						
						if ($location!='')
						{
						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res12 = mysqli_fetch_array($exec12);
						
						$res1location = $res12["locationname"];
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
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
           <!-- <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Subtype </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="searchsuppliername1" type="text" id="searchsuppliername1" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
			  <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
			  <input name="searchsubtypeanum1" id="searchsubtypeanum1" value="<?php echo $searchsubtypeanum1; ?>" type="hidden">
              </span></td>
           </tr>-->
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $ADate1; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $ADate2; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
					<tr>
  			  <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			 
				 <select name="location" id="location" onChange="ajaxlocationfunction(this.value);">
                    <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
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
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" onClick="return funcAccount1()" value="Search" name="Submit" />
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
        <td>
		<form method="post" name="form4" action="uploadclaim_documents.php">
        <input type="hidden" name="locationnameget" value="<?php echo $locationname;?>" >
                      <input type="hidden" name="locationcodeget" value="<?php echo $locationcode;?>" >
<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="1300" align="left" border="0">
          <tbody>
            <tr>
              <td colspan="5" bgcolor="#ecf0f5" class="bodytext31"><strong><?php echo $searchsuppliername; ?></strong></td>
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext31"><span class="bodytext311">
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
 				<?php
				//For excel file creation.
				
				/*$applocation1 = $applocation1; //Value from db_connect.php file giving application path.
				$filename1 = "print_paymentgivenreport1.php?$urlpath";
				$fileurl = $applocation1."/".$filename1;
				$filecontent1 = @file_get_contents($fileurl);
				
				$indiatimecheck = date('d-M-Y-H-i-s');
				$foldername = "dbexcelfiles";
				$fp = fopen($foldername.'/PaymentGivenToSupplier.xls', 'w+');
				fwrite($fp, $filecontent1);
				fclose($fp);*/

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
            <tr>
				<th width="1%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>No.</strong></th>
                <th width="6%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Code</th>
				<th width="6%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit Code</th>
				<th width="6%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit Date</th>
                <th width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</th>
				<th width="3%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Gender</th>
				<th width="2%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Age</th>
				<th width="8%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Subtype</th>
				<th width="6%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Account</th>
				<th width="6%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</th>
                <th width="15%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Claim Form</th>
                <th width="15%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Discharge Form</th>
  			
				
			</tr>
			<?php 
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
		    if ($cbfrmflag1 == 'cbfrmflag1')
			{
					
			
		  $query1 = "select a.subtype,'op' as source,a.gender,a.age,a.registrationdate as consultationdate,a.patientcode,a.patientfullname as patientname,a.visitcode as visitcode,a.accountname from master_visitentry as a 
			 inner join slade_claim as b
			 where a.visitcode=b.visitcode and b.claim_invoice_status='pending' and a.locationcode ='$slocation' 
			 UNION ALL
			select  a.subtype,'ip' as source,a.gender,a.age,a.registrationdate as consultationdate,a.patientcode,a.patientfullname as patientname,a.visitcode as visitcode,a.accountname from master_ipvisitentry as a 
			inner join slade_claim as b
			where a.visitcode=b.visitcode and b.claim_invoice_status='pending' and a.locationcode ='$slocation' ";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
 		 	 $num=mysqli_num_rows($exec1);
			
			while($res1 = mysqli_fetch_array($exec1))
		  {
			$billnumber='';
			$res1patientcode= $res1['patientcode'];
			$visitcode= $res1['visitcode'];
			$accountname= $res1['accountname'];
			$source= $res1['source'];
			$gender= $res1['gender'];
			$res1patientvisitcode= $res1['visitcode'];
			$res1consultationdate= $res1['consultationdate'];
		 	$res1patientname= $res1['patientname'];
			$res1age=$res1['age'];
		    $subtype=$res1['subtype'];
			
		$query222 = "select subtype from master_subtype where auto_number = '$subtype' AND recordstatus = '' "; 
		$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in query222".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res222 = mysqli_fetch_array($exec222);
		$subtypename= $res222['subtype'];
		
		 $query2221 = "select claim_upload_payload,claim_ds_upload from slade_claim where visitcode = '$res1patientvisitcode'"; 
		$exec2221 = mysqli_query($GLOBALS["___mysqli_ston"], $query2221) or die ("Error in query2221".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2221 = mysqli_fetch_array($exec2221);
		$claim_upload_payload= $res2221['claim_upload_payload'];
		$claim_ds_upload= $res2221['claim_ds_upload'];
		
		$query222 = "select accountname from master_accountname where auto_number = '$accountname' AND recordstatus = 'ACTIVE' "; 
		$exec222 = mysqli_query($GLOBALS["___mysqli_ston"], $query222) or die ("Error in query222".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res222 = mysqli_fetch_array($exec222);
		$res21accountname= $res222['accountname'];
		
		if($source=='op')
		{
		$query2221 = "select billno from billing_paylater where visitcode = '$visitcode'"; 
		$exec2221 = mysqli_query($GLOBALS["___mysqli_ston"], $query2221) or die ("Error in query2221".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2221 = mysqli_fetch_array($exec2221);
		$billnumber= $res2221['billno'];
		}
		else
		{
		$query2221 = "select billno from billing_ip where visitcode = '$visitcode'"; 
		$exec2221 = mysqli_query($GLOBALS["___mysqli_ston"], $query2221) or die ("Error in query2221".mysqli_error($GLOBALS["___mysqli_ston"]));
		$res2221 = mysqli_fetch_array($exec2221);
		$billnumber= $res2221['billno'];	
		}
			
			$snocount = $snocount + 1;
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
            
            <tr <?php echo $colorcode; ?> id='idTR<?php echo $snocount;?>'>
              <td class="bodytext31" width="1%" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" width="4%"  valign="center"  align="left"><?php echo $res1patientcode; ?></td>
                <td class="bodytext31" width="4%"  valign="center"  align="left"><?php echo $visitcode; ?></td>
               <td class="bodytext31" width="4%"  valign="center"  align="left"><?php echo date('d-m-y',strtotime($res1consultationdate)); ?></td>
               <td class="bodytext31" width="6%"  valign="center"  align="left"><?php echo $res1patientname; ?></td>
               <td class="bodytext31" width="3%"  valign="center"  align="left"><?php echo $gender; ?></td>
               <td class="bodytext31" width="2%"  valign="center"  align="left"><?php echo $res1age; ?></td>
			   <td class="bodytext31" width="6%"  valign="center"  align="left"><?php echo $subtypename; ?></td>
				<td class="bodytext31" width="6%"  valign="center"  align="left"><?php echo $res21accountname; ?></td>
				<td class="bodytext31" width="6%"  valign="center"  align="left"><?php echo $billnumber; ?></td>
                   <?php
			   if($claim_upload_payload=='')
		       {?>              
               <td class="bodytext31" width="6%"  valign="center"  align="left">
        <input type="file" id="file_upload<?php echo $snocount; ?>" name="file_upload<?php echo $snocount; ?>"  title="Upload" onChange="update_claimdetails('<?php echo $visitcode; ?>','<?php echo $snocount; ?>','<?php echo $source; ?>','<?php echo $billnumber; ?>')"/></td>
               <?php } else { ?>
         <td class="bodytext31" width="6%"  valign="center"  align="left">Successfully Uploaded</td>
               <?php
		      }
			   if($source=='op' || $claim_ds_upload!='')
		       {?>
                <td class="bodytext31" width="6%"  valign="center"  align="left"></td>
                <?php } else { ?>
           <td class="bodytext31" width="6%"  valign="center"  align="left">
          <input type="file" id="dis_summ_upload<?php echo $snocount; ?>" name="dis_summ_upload<?php echo $snocount; ?>"  title="Upload" onChange="update_claimdetails_ds('<?php echo $visitcode; ?>','<?php echo $snocount; ?>','<?php echo $source; ?>','<?php echo $billnumber; ?>')" /></td>
               <?php } ?>
               
                 
               </tr>
		   <?php 
		   
			}
		  
		
			
			
			?>
          
			<?php
			}
			
			?>
          </tbody>
        </table>
		</form>
		</td>
      </tr>
	  
    </table>
	</td>
	</tr>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

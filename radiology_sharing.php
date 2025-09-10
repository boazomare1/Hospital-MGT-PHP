<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$errmsg = "";
$customercode='';
$sno='';
$amount='';

$transactiondatefrom = date('Y-m-d', strtotime('-1 week'));
$transactiondateto = date('Y-m-d');

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

if ($ADate1 != '' && $ADate2 != '')
{
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
}
else
{
	$transactiondatefrom = date('Y-m-d', strtotime('-1 week'));
	$transactiondateto = date('Y-m-d');
}

	$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];

    if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag2 == 'cbfrmflag2')
{
	//print_r($_POST['check']);
	$locationcode=$_REQUEST["locationcode"];
	
	
					 $searchsuppliername=$_POST['searchsuppliername'];
					 
					 $sear=explode('#', $searchsuppliername);
					  $supname=$sear[0];
					$supcode=$sear[1];
					 $invoiceno=$_POST['invoice'];
					 $transactiondate=$_POST['transactiondate'];
					 $actualtotal=$_POST['actualtotal'];
					 $externaltotal=$_POST['externaltotal'];
					 					 $billnumbercode=$_POST['billnumbercode'];

					 
			foreach($_POST['check'] as $check1=>$value)
			{
				 $check1;
			//echo $value;
				 $date=$_POST['date'][$check1];
				 $patientname=$_POST['patientname'][$check1];
				 $patientcode=$_POST['patientcode'][$check1];
				 $visitcode=$_POST['visitcode'][$check1];
				 $account=$_POST['account'][$check1];
				 
				 $docnumber=$_POST['docnumber'][$check1];
				 $itemname=$_POST['itemname'][$check1];
				 $amount1=$_POST['amount'][$check1];
				 
				  $amount = str_replace(',', '', $amount1);
				 
				 $externalshare=$_POST['externalshare'][$check1];
				 $internalshare=$_POST['internalshare'][$check1];
				 
				  $externalshare = str_replace(',', '', $externalshare);
				  
				  $internalshare = str_replace(',', '', $internalshare);

				 $itemcode=$_POST['itemcode'][$check1];
				 
				 
		$query9 = "insert into radshare_details (consultationdate,docno, patientcode, patientname, 
		patientvisitcode, radiologyitemcode, radiologyitemname, radiologyitemrate,hospitalsharing,
		
		externalsharing, accountname,billnumber,username,suppliername,suppliercode,invoicenumber,transactiondate,locationcode) 
		values ('$date','$billnumbercode', '$patientcode', '$patientname', 
		'$visitcode', '$itemcode', '$itemname', '$amount', '$internalshare','$externalshare', '$account','$docnumber','$username','$supname','$supcode','$invoiceno','$transactiondate','$locationcode'
		)";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$query12=mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE resultentry_radiology SET sharing_status='1' WHERE  docnumber='$docnumber' and patientvisitcode='$visitcode' and itemcode='$itemcode' ");
		$query13=mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE ipresultentry_radiology SET sharing_status='1' WHERE  docnumber='$docnumber' and patientvisitcode='$visitcode' and itemcode='$itemcode' ");
			}
			
		$query3 = "insert into master_purchase (companyanum, billnumber, billdate, suppliercode, suppliername,totalamount,ipaddress,supplierbillnumber,typeofpurchase)values('$companyanum','$billnumbercode','$transactiondate','$supcode', '$supname','$externaltotal','$ipaddress','$invoiceno','Process')";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CREDIT';
		$particulars = 'BY CREDIT (Inv NO:'.$billnumber.$invoiceno.')';	
		//include ("transactioninsert1.php");
		$query9 = "insert into master_transactionpharmacy (transactiondate, particulars,  suppliername, 
		transactionmode, transactiontype, transactionamount, creditamount,balanceamount,
		billnumber,  ipaddress, updatedate,  companyanum, companyname,suppliercode) 
		values ('$updatedatetime', '$particulars', '$supname', 
		'$transactionmode', '$transactiontype', '$externaltotal', '$externaltotal', '$externaltotal',
		'$billnumbercode',  '$ipaddress', '$updatedatetime', '$companyanum', '$companyname', '$supcode')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$transactiontype = 'PURCHASE';
		$transactionmode = 'BILL';
		$particulars = 'BY PURCHASE (Inv NO:'.$billnumber.$invoiceno.')';	
		//include ("transactioninsert1.php");
		$query9 = "insert into master_transactionpharmacy (transactiondate, particulars,  suppliername, 
		transactionmode, transactiontype, transactionamount, creditamount,balanceamount,
		billnumber,  ipaddress, updatedate,  companyanum, companyname,suppliercode) 
		values ('$updatedatetime', '$particulars', '$supname', 
		'$transactionmode', '$transactiontype', '$externaltotal', '$externaltotal', '$externaltotal',
		'$billnumbercode',  '$ipaddress', '$updatedatetime', '$companyanum', '$companyname', '$supcode')";
		$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));

			  header("location:radiology_sharing.php");

			
			}


include ("autocompletebuild_supplier1.php");

     if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];

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
</script>
<script type="text/javascript" src="js/autocomplete_supplier12.js"></script>
<!--<script type="text/javascript" src="js/autosuggest2supplier12.js"></script>
-->
<script type="text/javascript" src="js/autosuggest2supplier12.js"></script><script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
}
</script>

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; }
-->
</style>
</head>
<script language="javascript">

</script>
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<script type="text/javascript">


function process2()
{
	//alert('hai');
	//return false;
	var supplier=document.getElementById("searchsuppliername").value;
	var invoice=document.getElementById("invoice").value;
	//alert(supplier);
//return false;
	if (supplier == "")
	{
		alert ("Please Select Supplier Name.")
		return false;
	}
	if (invoice == "")
	{
		alert ("Please Enter invoice No.")
		return false;
	}
	
	varUserChoice = confirm('Are You Sure Want To Save This Entry?'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		alert ("Entry Cancelled");
		return false;
	}
	
}


function itemcodeentry2()
{
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
		//itemcodeentry1();
		return false;
	}
	else
	{
		return true;
	}
}




$(document).ready(function() {
	
    $("input[name^='check[']").click(function(event) {
        var checkid=this.id;
		//alert(checkid);
		
	//if($(this)is(':checked'))
	if(document.getElementById(checkid).checked==true)
	{	
	var checkno1 = checkid.split('-'); 
	var checkno = checkno1[1];
	
	var externalvalue = $("#externalshare"+checkno).val();
	//alert(externalvalue);
	var internalshare = $("#internalshare"+checkno).val();
	var singleamount = $("#amount"+checkno).val();

	
	var externalvalue=parseFloat(externalvalue.replace(/\,/g,''));
	var internalshare=parseFloat(internalshare.replace(/\,/g,''));
	var singleamount=parseFloat(singleamount.replace(/\,/g,''));
	
	//var addamount=parseFloat(totalamounttoless.replace(/\,/g,''))
	
	
	var internaltotal = $("#internaltotal").val();
	var externaltotal = $("#externaltotal").val();
	var actualtotal = $("#actualtotal").val();

	var internaltotal=parseFloat(internaltotal.replace(/\,/g,''));
	var externaltotal=parseFloat(externaltotal.replace(/\,/g,''));
	var actualtotal=parseFloat(actualtotal.replace(/\,/g,''));
	
	var internaltotal1=internaltotal+internalshare;
	var externaltotal1=externaltotal+externalvalue;
	var overaltotal=actualtotal+singleamount;
	
	
	var internaltotal1=parseFloat(internaltotal1);
	var externaltotal1=parseFloat(externaltotal1);
	var overaltotal=parseFloat(overaltotal);
	//alert(externaltotal1);
	$("#internaltotal").val(internaltotal1.toFixed(2));
	$("#externaltotal").val(externaltotal1.toFixed(2));
	$("#actualtotal").val(overaltotal.toFixed(2));
	}
	if(document.getElementById(checkid).checked==false)
{
	var checkno1 = checkid.split('-'); 
	var checkno = checkno1[1];
	
	var externalvalue = $("#externalshare"+checkno).val();
	//alert(externalvalue);
	var internalshare = $("#internalshare"+checkno).val();
	var singleamount = $("#amount"+checkno).val();

	
	
	var externalvalue=parseFloat(externalvalue.replace(/\,/g,''));
	var internalshare=parseFloat(internalshare.replace(/\,/g,''));
	var singleamount=parseFloat(singleamount.replace(/\,/g,''));
	
	
	var internaltotal = $("#internaltotal").val();
	var externaltotal = $("#externaltotal").val();
	var actualtotal = $("#actualtotal").val();

	var internaltotal=parseFloat(internaltotal.replace(/\,/g,''));
	var externaltotal=parseFloat(externaltotal.replace(/\,/g,''));
	var actualtotal=parseFloat(actualtotal.replace(/\,/g,''));
	
	var internaltotal1=internaltotal-internalshare;
	var externaltotal1=externaltotal-externalvalue;
	var overaltotal=actualtotal-singleamount;
	
	
	var internaltotal1=parseFloat(internaltotal1);
	var externaltotal1=parseFloat(externaltotal1);
	var overaltotal=parseFloat(overaltotal);
	//alert(externaltotal1);
	$("#internaltotal").val(internaltotal1.toFixed(2));
	$("#externaltotal").val(externaltotal1.toFixed(2));
	$("#actualtotal").val(overaltotal.toFixed(2));
}
    });
});



</script>

<script src="js/datetimepicker_css.js"></script>

<body <?php //echo $loadprintpage; ?>>
<table width="1500" border="0" cellspacing="0" cellpadding="2">
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
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%" rowspan="3">&nbsp;</td>
    <td valign="top">
    <table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		
		
			<form name="stockinward" action="radiology_sharing.php" method="post" onKeyDown="return disableEnterKey()" onSubmit="return process1()">
	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
      <tbody id="foo">
        <tr>
          <td colspan="5" bgcolor="#ecf0f5" class="bodytext31"><strong>Radiology Sharing</strong></td>
          </tr>
        <tr>
          <td colspan="5" align="left" valign="center"  
                 bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#cbdbfa'; } ?>" class="bodytext31"><?php echo $errmsg; ?>&nbsp;</td>
          </tr>
        <script language="javascript">

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

		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
	

}


function process1rateperunit()
{
	servicenameonchange1();
}


function deleterecord1(varEntryNumber,varAutoNumber)
{
	var varEntryNumber = varEntryNumber;
	var varAutoNumber = varAutoNumber;
	var fRet;
	fRet = confirm('Are you sure want to delete the stock entry no. '+varEntryNumber+' ?');
	//alert(fRet);
	if (fRet == false)
	{
		alert ("Stock Entry Delete Not Completed.");
		return false;
	}
	else
	{
		window.location="stockreport2.php?task=del&&delanum="+varAutoNumber;		
	}
}




</script>
        <tr>
          <td width="75" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="136" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="65" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="125" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          <td width="338" align="left" valign="center"  bgcolor="#ffffff">

		            </td>
        </tr>
        <tr>
          <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><input type="hidden" name="itemcode2" id="itemcode2" style="border: 1px solid #001E6A; text-align:left" onKeyDown="return disableEnterKey()" value="<?php echo $itemcode; ?>" size="10" readonly /></td>
          <td colspan="3" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
                      <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
            <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />
	<input type="hidden" name="frmflag1" value="frmflag1" id="frmflag1">

		 </td>
          <td align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right">
          </div></td>
        </tr>
        <tr>
          <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff">&nbsp;</td>
          <td colspan="4" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"></td>
        </tr>
      </tbody>
    </table>
    </form>	</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    <?php  if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
	
	 ?>
<form name="cbform1" method="post">
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="90%" 
            align="left" border="0"> 
          <tbody>
<!--            <tr>
              <td width="2%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="3%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="6%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="2%" bgcolor="#ecf0f5" class="bodytext31"><a 
                  href="#"></a></td>
              <td width="2%" bgcolor="#ecf0f5" class="bodytext31"></td>
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext31"></td>
               <td width="5%" bgcolor="#ecf0f5" class="bodytext31"></td>
              <td colspan="4" bgcolor="#ecf0f5" class="bodytext31"></tr>
            <tr>
-->              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>S.No</strong></td>
              <td class="bodytext31" valign="center"  align="left"  width="8%"
                bgcolor="#ffffff"><strong>Date</strong></td>
              <td align="left" valign="center"  width="20%" 
                bgcolor="#ffffff" class="bodytext31"><strong>Patient Name</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" width="10%" class="bodytext31"><strong>Reg No</strong></td>
                <td align="left" valign="center" width="10%" 
                bgcolor="#ffffff" class="bodytext31"><strong>Visit No</strong></td>
                <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Account</strong></td>
              <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Doc No.</strong></td>
              <td width="20%" align="left" valign="center"  
                bgcolor="#ffffff"  class="bodytext31"><div align="left"><strong>Test Name</strong></div></td>
              <td width="4%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
                  <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>EX- %</strong></div></td>
              <td width="4%" align="center" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>HOS- %</strong></div></td>
                <td width="3%" align="center" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Check</strong></td>
            </tr>
            
      
            <?php
			
			//$selectedstore=$_REQUEST['store'];
			$colorloopcount='';
			$externalshare1=0.00;
			$internalshare1=0.00;
			$amount1=0.00;	
			$sno='';
			$rateper=0;
			$snum=isset($_REQUEST['snum']);
			
			$query32= "select categoryname from master_categoryradiology where status=''  group by categoryname";
			$exec32 = mysqli_query($GLOBALS["___mysqli_ston"], $query32) or die ("Error in Query32".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res32 = mysqli_fetch_array($exec32))
			{	
			$categoryname1 = $res32['categoryname']; 
			$amount1=0.00;
			$externalshare1=0.00;
			$internalshare1=0.00;
			
/*			$query322 = "select rate from master_categoryradiology where categoryname='$categoryname1'";
			$exec322 = mysql_query($query322) or die ("Error in Query322".mysql_error());
			$res322 = mysql_fetch_array($exec322);
*/			//$rateper = $res322['rate'];
			?>
            <tr>
 <td colspan="12" bgcolor="#999999" class="bodytext31" valign="center"  align="left"><strong> <?php echo $categoryname1; ?>   </strong>
</td>
</tr> 
        	
			<?php
			$sno='';
			$snum;
				$query31 = "select itemcode from master_radiology where categoryname='$categoryname1' and status = '' group by itemcode";
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res31 = mysqli_fetch_array($exec31))
			{
			
			$itemcode31 = $res31['itemcode'];
			
						
            
				$query2 = "select * from resultentry_radiology where itemcode='$itemcode31'  and sharing_status!='1' and recorddate between '$transactiondatefrom' and '$transactiondateto'   order by auto_number desc";// and cstid='$custid' and cstname='$custname'";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2 ".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2 = mysqli_fetch_array($exec2))
			{
			
			 $res2anum = $res2['auto_number'];
			$patientname = $res2['patientname'];
			$patientcode = $res2['patientcode'];
		//	$itemname = $res2['itemname'];
			$itemcode = $res2['itemcode'];
			$docnumber=$res2['docnumber'];
			$visitcode=$res2['patientvisitcode'];
			$date = $res2['recorddate'];
			$account=$res2['account'];
			$sno = $sno + 1;
			$snum= $snum + 1;
			
				$query301 = "select externalshare from master_radiology where itemcode='$itemcode31'";
			$exec301 = mysqli_query($GLOBALS["___mysqli_ston"], $query301) or die ("Error in Query301".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res301 = mysqli_fetch_array($exec301);
			
			$rateper = $res301['externalshare'];
			
			$query5 = "select paymenttype from master_visitentry where visitcode = '$visitcode'";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res5 = mysqli_fetch_array($exec5);
			$paymenttype = $res5['paymenttype'];
			
				
			
			
			$query3 = "select radiologyitemrate,radiologyitemname from consultation_radiology where patientcode = '$patientcode' and patientvisitcode='$visitcode' and radiologyitemcode='$itemcode'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			
			$amount = $res3['radiologyitemrate'];
			$itemname = $res3['radiologyitemname'];
			
			$externalshare=(($amount/100)*$rateper);
			$internalshare=$amount-$externalshare;
			
			$amount1=$amount1+$amount;
			$externalshare1=$externalshare1+$externalshare;
			$internalshare1=$internalshare1+$internalshare;
			
			
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
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $sno; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $date; ?>
 <input type="hidden" id="date" name="date[<?php echo $snum;?>]" value="<?php echo $date;  ?>" >
               </td>
              <td class="bodytext31" valign="center"  align="left">
              <input type="hidden" id="patientname" name="patientname[<?php echo $snum;?>]" value="<?php echo $patientname;  ?>" >
              <input type="hidden" id="itemcode" name="itemcode[<?php echo $snum;?>]" value="<?php echo $itemcode;  ?>" >
              <input type="hidden" name="locationcode" value="<?php echo $locationcode?>">
              
 			  <div class="bodytext31"><?php echo $patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
               <input type="hidden" id="patientcode" name="patientcode[<?php echo $snum;?>]" value="<?php echo $patientcode;  ?>" >
			  <div class="bodytext31"><?php echo $patientcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
               <input type="hidden" id="visitcode" name="visitcode[<?php echo $snum;?>]" value="<?php echo $visitcode;  ?>" >
			  <div class="bodytext31"><?php echo $visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
              <input type="hidden" id="account" name="account[<?php echo $snum;?>]" value="<?php echo $account;  ?>" >
			  <div class="bodytext31"><?php echo $account; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
              <input type="hidden" id="docnumber" name="docnumber[<?php echo $snum;?>]" value="<?php echo $docnumber;  ?>" >
			  <div class="bodytext31"><?php echo $docnumber; ?></div></td>
              <td class="bodytext31" valign="left"  align="left">
              <input type="hidden" id="itemname" name="itemname[<?php echo $snum;?>]" value="<?php echo $itemname;  ?>" ><div class="bodytext31">
                  <div align="left"><?php echo $itemname; ?>-<?php echo intval($rateper); ?> %</div>
              </div></td>
              <td class="bodytext31" valign="center"  align="left">
              <input type="hidden" id="amount<?php echo $snum;  ?>" name="amount[<?php echo $snum;?>]" value="<?php echo $amount;  ?>" ><div class="bodytext31">
                  <div align="right"><?php echo $amount; ?></div>
              </div></td>
                <td class="bodytext31" valign="left"  align="center">
                <input type="hidden" id="externalshare<?php echo $snum;  ?>" name="externalshare[<?php echo $snum;?>]" value="<?php echo number_format($externalshare,2,'.',',');  ?>" ><div class="bodytext31">
                  <div align="center"><?php echo number_format($externalshare,2,'.',','); ?></div>
              </div></td>
              <td class="bodytext31" valign="left"  align="center">
              <input type="hidden" id="internalshare<?php echo $snum;  ?>" name="internalshare[<?php echo $snum;?>]" value="<?php echo number_format($internalshare,2,'.',',');  ?>" ><div class="bodytext31">
                  <div align="center"><?php echo number_format($internalshare,2,'.',','); ?></div>
              </div></td>
                <td class="bodytext31" valign="center"  align="left">
			  <input type="checkbox"  name="check[<?php echo $snum;?>]" id="check-<?php echo $snum;  ?>" value="<?php echo $docnumber; ?>"></td>
            </tr>
            <?php
			}
			
			}
			
			$account='';
			$sno;
				$query31 = "select itemcode from master_radiology where categoryname='$categoryname1' and status = '' group by itemcode";
			$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($res31 = mysqli_fetch_array($exec31))
			{
			
			$itemcode32 = $res31['itemcode'];
			
			
			
			$query2 = "select * from ipresultentry_radiology
			 where itemcode='$itemcode32' and sharing_status!='1'  and   recorddate between '$transactiondatefrom' and '$transactiondateto'";// and cstid='$custid' and cstname='$custname'";
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2 ".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res2 = mysqli_fetch_array($exec2))
			{
			
			 $res2anum = $res2['auto_number'];
			$patientname = $res2['patientname'];
			$patientcode = $res2['patientcode'];
			$itemcode = $res2['itemcode'];
			$docnumber=$res2['docnumber'];
			$visitcode=$res2['patientvisitcode'];
			// $accountname=$res2['accountname'];
			
			$query5 = "select paymenttype,accountfullname from master_visitentry where visitcode = '$visitcode'";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res5 = mysqli_fetch_array($exec5);
			$paymenttype = $res5['paymenttype'];
			$account = $res5['accountfullname'];
			$sno = $sno + 1;
			$snum=$snum + 1;
			
				$query301 = "select externalshare from master_radiology where itemcode='$itemcode31'";
			$exec301 = mysqli_query($GLOBALS["___mysqli_ston"], $query301) or die ("Error in Query301".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res301 = mysqli_fetch_array($exec301);
			
			$rateper = $res301['externalshare'];
			
			$query3 = "select radiologyitemrate,radiologyitemname,consultationdate,accountname from ipconsultation_radiology where patientcode = '$patientcode' and patientvisitcode='$visitcode' and radiologyitemcode='$itemcode'";
			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res3 = mysqli_fetch_array($exec3);
			
			$amount = $res3['radiologyitemrate'];
			$itemname = $res3['radiologyitemname'];
			$date = $res3['consultationdate'];
			$account=$res3['accountname'];
			
			$externalshare=(($amount/100)*$rateper);
			$internalshare=$amount-$externalshare;
			
			$amount1=$amount1+$amount;
			$externalshare1=$externalshare1+$externalshare;
			$internalshare1=$internalshare1+$internalshare;
			
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
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $sno; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $date; ?>
 <input type="hidden" id="date" name="date[<?php echo $snum;?>]" value="<?php echo $date;  ?>" >              </td>
              <td class="bodytext31" valign="center"  align="left">
              <input type="hidden" id="patientname" name="patientname[<?php echo $snum;?>]" value="<?php echo $patientname;  ?>" >
                            <input type="hidden" id="itemcode" name="itemcode[<?php echo $snum;?>]" value="<?php echo $itemcode;  ?>" >

 			  <div class="bodytext31"><?php echo $patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
               <input type="hidden" id="patientcode" name="patientcode[<?php echo $snum;?>]" value="<?php echo $patientcode;  ?>" >
			  <div class="bodytext31"><?php echo $patientcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
               <input type="hidden" id="visitcode" name="visitcode[<?php echo $snum;?>]" value="<?php echo $visitcode;  ?>" >
			  <div class="bodytext31"><?php echo $visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
              <input type="hidden" id="account" name="account[<?php echo $snum;?>]" value="<?php echo $account;  ?>" >
			  <div class="bodytext31"><?php echo $account; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
              <input type="hidden" id="docnumber" name="docnumber[<?php echo $snum;?>]" value="<?php echo $docnumber;  ?>" >
			  <div class="bodytext31"><?php echo $docnumber; ?></div></td>
              <td class="bodytext31" valign="left"  align="left">
              <input type="hidden" id="itemname" name="itemname[<?php echo $snum;?>]" value="<?php echo $itemname;  ?>" ><div class="bodytext31">
                  <div align="left"><?php echo $itemname; ?>-<?php echo intval($rateper); ?> %</div>
              </div></td>
              <td class="bodytext31" valign="center"  align="left">
              <input type="hidden" id="amount<?php echo $snum;  ?>" name="amount[<?php echo $snum;?>]" value="<?php echo $amount;  ?>" ><div class="bodytext31">
                  <div align="right"><?php echo $amount; ?></div>
              </div></td>
                <td class="bodytext31" valign="left"  align="center">
                <input type="hidden" id="externalshare<?php echo $snum;  ?>" name="externalshare[<?php echo $snum;?>]" value="<?php echo number_format($externalshare,2,'.',',');  ?>" ><div class="bodytext31">
                  <div align="center"><?php echo number_format($externalshare,2,'.',','); ?></div>
              </div></td>
              <td class="bodytext31" valign="left"  align="center">
              <input type="hidden" id="internalshare<?php echo $snum;  ?>" name="internalshare[<?php echo $snum;?>]" value="<?php echo number_format($internalshare,2,'.',',');  ?>" ><div class="bodytext31">
                 <?php echo number_format($internalshare,2,'.',','); ?>
              </div></td>
                <td class="bodytext31" valign="center"  align="left">
			  <input type="checkbox"  name="check[<?php echo $snum;?>]" id="check-<?php echo $snum;  ?>" value="<?php echo $docnumber; ?>"></td>
            </tr>
           <?php
            
			}
			
			}
			?>
			
            
            
           
           <!--<tr> <td colspan="7">
            <td class="bodytext31" ><strong>Total</strong></td>
            <td class="bodytext31" align="right"><strong> <?php  echo number_format($amount1,2,'.',','); ?> </strong></td>
            
            <td class="bodytext31" align="right"><strong> <?php  echo number_format($externalshare1,2,'.',','); ?> </strong></td>
            
            <td class="bodytext31" align="right"><strong> <?php  echo number_format($internalshare1,2,'.',','); ?> </strong></td>
            </tr>-->
	
   		
            <?php
			}
			?>
            <tr>
            <td colspan="7">
           	 <td class="bodytext31" ><strong>Total</strong></td>
            <td class="bodytext31" align="center" valign="right"><strong><input type="text" readonly id="actualtotal" name="actualtotal" value="0.00" size="10" > </strong></td>
            <td class="bodytext31" align="center"><strong><input type="text" readonly id="externaltotal" name="externaltotal" value="0.00" size="10"> </strong></td>
            
            <td class="bodytext31" align="center"><strong> <input type="text" readonly id="internaltotal" name="internaltotal" value="0.00" size="10">   </strong></td>
                      
                         
                </tr>

            <?php
/*			$paynowbillprefix1 = 'ISR-';
$paynowbillprefix12=strlen($paynowbillprefix1);
 $query2 = "select docno from radshare_details  order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	 $billnumbercode ='EXS-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode1 = substr($billnumber1,$paynowbillprefix12, $billdigit1);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	 $billnumbercode = 'EXS-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

*/
$paynowbillprefix1 = 'EXSR-';
$paynowbillprefix12=strlen($paynowbillprefix1);
$query23 = "select * from radshare_details order by auto_number desc limit 0, 1";
$exec23= mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$billnumber1 = $res23["docno"];
$billdigit1=strlen($billnumber1);
if ($billnumber1 == '')
{
	$billnumbercode ='EXSR-'.'1';
	$openingbalance1 = '0.00';
}
else
{
	$billnumber1 = $res23["docno"];
	$billnumbercode1 = substr($billnumber1,$paynowbillprefix12, $billdigit1);
	//echo $billnumbercode;
	$billnumbercode1 = intval($billnumbercode1);
	$billnumbercode1 = $billnumbercode1 + 1;

	$maxanum1 = $billnumbercode1;
	
	
	$billnumbercode = 'EXSR-'.$maxanum1;
	$openingbalance1 = '0.00';
	//echo $companycode;
}


			
			$snum=$sno;
			?>
            
     <input type="hidden" name="snum" value="<?php echo $snum; ?>" >
</div>

			<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>Select Supplier </strong></td>
              <td colspan="1" align="right" bgcolor="#ecf0f5" class="bodytext3"><strong><?php echo $billnumbercode;?></strong>
                <input name="billnumbercode" type="hidden" id="billnumbercode" value="<?php echo $billnumbercode; ?>">
              </td>
              </tr>
            <tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
              </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Supplier </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php //echo $searchsuppliername; ?>" size="50" autocomplete="off">
              </span></td>
              
              </tr>
              
            <tr>
              <td width="18%"  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Invoice No </td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input value="<?php //echo $cbsuppliername; ?>" name="invoice" type="text" id="invoice"  onKeyDown="return disableEnterKey()" size="50" ></td>
              </tr>
              <tr>
               <td width="75" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"> Date  </td>
          <td width="136" colspan="3" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="transactiondate" id="date" style="border: 1px solid #001E6A" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('date')" style="cursor:pointer"/>			</td>
              </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="border: 1px solid #001E6A; text-transform:uppercase" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag2" value="cbfrmflag2">
                  <input  type="submit" onClick="return process2()" value="Save" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
            </tr>
          </tbody>
        </table>            
            <?php
			
			
	}
	?>       
        <td>

   		</form>

        </table>
        </td>
        </tr>	
       </td>
       </tr>      
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>    
  <tr>
    <td valign="top">    
  <tr>
    <td width="99%" valign="top">    
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
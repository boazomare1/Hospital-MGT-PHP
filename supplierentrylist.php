<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



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



//This include updatation takes too long to load for hunge items database.





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







//include ("autocompletebuild_supplier2.php");



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

<?php //include ("autocompletebuild_supplier1.php"); ?>

<!--<script type="text/javascript" src="js/autocomplete_supplier12.js"></script>

<script type="text/javascript" src="js/autosuggest2supplier1.js"></script>-->

<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/autocomplete.css">    

<script type="text/javascript">

/*window.onload = function () 

{



	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        

	

}*/



$(document).ready(function(e) {

	$('#searchsuppliername').autocomplete({

		

	source:"ajaxsupplieraccount_nm.php",

	//alert(source);

	matchContains: true,

	minLength:1,

	html: true, 

		select: function(event,ui){

			var accountname=ui.item.value;

			var accountid=ui.item.id;

			$("#searchsuppliercode").val(accountid);

			},

	});	

});



</script>

<script type="text/javascript">


function myFunction() {
  
}




function funcDeleteVoucher(varVoucherNumber,sno,voucher,mode)

{

var varVoucherNumber = varVoucherNumber;
	//alert(varVoucherNumber);
	var sno = sno;
	var voucher = voucher;
		var mode = mode;


/*var remarks=document.getElementById("remarks"+sno).value;
	if(remarks==''){*/
	
var person = prompt("Please enter the remarks", );
if (person != null) {

//if(confirm("Are you sure to delete this Entry ?")){	
	
	var action="deletesuppliervoucher";	
	var dataString = 'docno='+varVoucherNumber+'&&ddocno='+sno+'&&action='+action+'&&voucher='+voucher+'&&mode='+mode+'&&remarks='+person;
	if(sno!=''){		
		$.ajax({
		
			type:"get",
			url:"supplieractivityvoucherdelete.php",
			data:dataString,
			cache: true,
			success: function(html){		
			//$('#idTR'+vai).css('background-color','#00FF00');
			//$('#btnadd'+vai).show();
			$('#idTR'+sno).hide();	
			//return false;
				
			}			
			});		
		}
	}
	//}
	//}
	
	else 
	return false;
	
	
	
}

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

		key = window.event.keyCode;     //Ie

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

</style>

</head>



<script src="js/datetimepicker_css.js"></script>



<body>

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

		

		

              <form name="cbform1" method="post" action="supplierentrylist.php">

		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>Supplier Entries </strong></td>

              </tr>

          

            <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Supplier Name</td>

              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">

                 <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">

              <input name="searchsuppliernamehiddentextbox" id="searchsuppliernamehiddentextbox" value="" type="hidden">

			  <input name="searchaccountnameanum1" id="searchaccountnameanum1" value="" type="hidden">

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

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode"  id="searchsuppliercode" style="text-transform:uppercase" value="" size="20" /></td>

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

	<form name="form1" id="form1" method="post" action="supplierentrylist.php">	

		

<?php

	$colorloopcount=0;

	$sno=0;

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

//$cbfrmflag1 = $_POST['cbfrmflag1'];

if ($cbfrmflag1 == 'cbfrmflag1')

{

	

	$searchsuppliername1 = $_POST['searchsuppliername'];

	$searchdocno=$_POST['docno'];

	

	$fromdate=$_POST['ADate1'];

	$todate=$_POST['ADate2'];

		

		

$searchsuppliername = "";		

$arraysuppliercode = "";



		if($searchsuppliername1!=''){

			$arraysuppliername = $_POST['searchsuppliername'];

			$searchsuppliername1 = trim($arraysuppliername);

			$arraysuppliercode = $_POST['searchsuppliercode'];

		}

	//echo $searchpatient;

		//$transactiondatefrom = $_REQUEST['ADate1'];

	//$transactiondateto = $_REQUEST['ADate2'];





	

?>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="929" 

            align="left" border="0">

          <tbody>

             

           <tr>

                <td width="4%"  align="left" valign="center" 

                bgcolor="#ffffff" class="bodytext31"><strong>S.No</strong></td>

                <td width="9%"align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>

                <td width="7%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Doc No</strong></td>

				  <td width="8%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Mode</strong></td>

					  <td width="9%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Inst.Number</strong></td>

				<td width="11%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Supplier Name</strong></td>

					<td width="11%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Bank Code</strong></td>

				<td width="20%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Bank Name</strong></td>

				<td width="11%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Acc.Number</strong></td>

			        <td width="10%"class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="right"><strong>Amount </strong></div></td>
				
				
				
				

               <td width="6%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Action</strong></div></td>

				 <td width="5%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Print</strong></div></td>
				 <td width="5%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>&nbsp;</strong></div></td>

                  </tr>

			  <?php 

			  $totalamount = 0;

            $query2 = "select * from master_transactionpharmacy where suppliercode like '%$arraysuppliercode%' and transactioncode like '%$searchdocno%' and transactionmodule = 'PAYMENT' and transactiondate between '$fromdate' and '$todate' group by docno order by auto_number desc";

			  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			  $num2 = mysqli_num_rows($exec2);

			 // echo $num2;

			  while ($res2 = mysqli_fetch_array($exec2))

			  {

			      $totalamount=0;

			 	  $transactiondate = $res2['transactiondate'];
				  
				  $paymentvoucher = $res2['paymentvoucherno'];

				  $date = explode(" ",$transactiondate);

				  $docno = $res2['docno'];

				  $mode = $res2['transactionmode'];

				  $bankcode=$res2['bankcode'];

				  $bankname=$res2['bankname'];

				  $suppliername = $res2['suppliername'];
				  
				  
				  $transactionmode=$res2['transactionmode'];

				$query51="select sum(transactionamount) as transactionamount from paymentmodecredit where billnumber='$docno'";

				$exec51 = mysqli_query($GLOBALS["___mysqli_ston"], $query51) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				$res51 = mysqli_fetch_array($exec51);

				$totalamount = $res51['transactionamount'];  				  				 

				  $number = $res2['chequenumber'];

				 

				  

			  $query3 = "select accountnumber from master_bank where bankcode = '$bankcode' order by auto_number desc limit 0, 1";

			  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

			  $res3 = mysqli_fetch_array($exec3);

			  $accnumber = $res3['accountnumber'];

			  

			  if($totalamount>0){

			  

			  $colorloopcount = $colorloopcount + 1;

			  $showcolor = ($colorloopcount & 1); 

			  $colorcode = '';

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
<tr <?php echo $colorcode; ?> id="idTR<?php echo $colorloopcount;?>">

       <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>

       <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">  <div align="left"><span class="bodytext32"><?php echo $date[0]; ?></span></div> </div></td>

	<td  align="left" valign="center" class="bodytext31"><div class="bodytext31"> <div align="left"><span class="bodytext32"><?php echo $docno; ?></span></div>  </div></td>

      <td class="bodytext31" valign="center"  align="left"> <div align="left"><?php echo $mode; ?></div></td>

    <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">  <div align="left"> <span class="bodytext3"> <?php echo $number; ?> </span> </div>  </div></td>

   <td  align="left" valign="center" class="bodytext31"><div class="bodytext31"><div align="left"> <span class="bodytext3"> <?php echo $suppliername; ?> </span> </div> </div></td>

	<td  align="left" valign="center" class="bodytext31"><div class="bodytext31"> <div align="left"> <span class="bodytext3"> <?php echo $bankcode; ?> </span> </div>   </div></td>

	<td  align="left" valign="center" class="bodytext31"><div class="bodytext31"> <div align="left"> <span class="bodytext3"> <?php echo $bankname; ?> </span> </div> </div></td>

	<td  align="left" valign="center" class="bodytext31"><div class="bodytext31"><div align="left"> <span class="bodytext3"> <?php echo $accnumber; ?> </span> </div> </div></td>

	<td  align="left" valign="center" class="bodytext31"><div class="bodytext31"> <div align="right"> <span class="bodytext3"> <?php echo number_format($totalamount,2,'.',','); ?> </span> </div> </div></td>
	
	
	

	<td  align="left" valign="center" class="bodytext31"><div class="bodytext31"><div align="left"> <span class="bodytext3"><a href="supplierentry.php?docno=<?php echo $docno; ?>">VIEW</a> </span> </div> </div></td>

   <td  align="left" valign="center" class="bodytext31"> <div align="left"> <span class="bodytext3"><a href="print_supplierpayment1.php?billnumber=<?php echo $docno; ?>" target="_blank">PRINT</a>  </span> </div></td>
	
	<td  align="left" valign="center" class="bodytext31"><div class="bodytext31"> 
	<a href="supplierentrylist.php?st=del&&anum=<?php echo $docno; ?>"  onClick="return funcDeleteVoucher('<?php echo $docno;?>','<?php echo $colorloopcount;?>','<?php echo $paymentvoucher; ?>','<?php echo $transactionmode; ?>')"><img src="images/b_drop.png" width="16" height="16" border="0" /></a>
					
					</td>

                  </tr>

			  <?php

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

                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				 <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td> 
				  <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

				 <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>                   

           	</tr>

			<a href="supplierentrylistxls.php?cbfrmflag1=<?= $cbfrmflag1; ?>&&searchsuppliername=<?= $searchsuppliername1; ?>&&docno=<?= $searchdocno; ?>&&ADate1=<?= $fromdate; ?>&&&&ADate2=<?= $todate; ?>" target="_blank"><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;"></a> 

          </tbody>

        </table>

	

		

	  

      <?php

	  }

	  ?>

	  </form>

	  </td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

	  

	  

    </table>

  </table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>




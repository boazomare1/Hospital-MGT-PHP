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
$totalamount="0.00";

//This include updatation takes too long to load for hunge items database.

$loadkey=isset($_REQUEST["loadkey"])?$_REQUEST["loadkey"]:'';
$che=isset($_REQUEST["che"])?$_REQUEST["che"]:'';
/*if($loadkey!='')
{
	foreach($che as $key)
	{
		echo $key;
		}
	}*/
	$locationname=isset($_REQUEST["locationname"])?$_REQUEST["locationname"]:'';
	$locationcode=isset($_REQUEST["locationcode"])?$_REQUEST["locationcode"]:'';
	
if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
/*if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}*/

$query21 = "select docno from medicine_return_request order by auto_number desc limit 0, 1";
	 $exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
	 $rowcount21 = mysqli_num_rows($exec21);
	if ($rowcount21 == 0)
	{
		$consultationcode = 'MRC001';
	}
	else
	{
		$res21 = mysqli_fetch_array($exec21);
		 $consultationcode = $res21['docno'];
		 $consultationcode = substr($consultationcode, 3, 7);
		$consultationcode= intval($consultationcode);
		$consultationcode = $consultationcode + 1;
	
		
		
		
		if (strlen($consultationcode) == 2)
		{
			$consultationcode= '0'.$consultationcode;
		}
		if (strlen($consultationcode) == 1)
		{
			$consultationcode= '00'.$consultationcode;
		}
			$consultationcode = 'MRC'.$consultationcode;
		}

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag2 == 'frmflag2')
{
	
    
		 $adjustmentdate=date('Y-m-d');

 	     $patientname=$_POST['patientname'];
		 $patientcode=$_POST['patientcode'];
		 $visitcode=$_POST['visitcode'];
		 foreach($_POST['che'] as $key)
		 {  
		 // $key=$key-1;
		 $itemname=$_POST['itemname'][$key];
		 $itemcode=$_POST['itemcode'][$key];
		 $issueqty=$_POST['issueqty'][$key];
		 $returnmed=$_POST['returnmed'][$key];
		 $rateperunit=$_POST['rateperunit'][$key];
		 $refundamount=$_POST['refundamount'][$key];
		 
		 $fifocode=$_POST['fifocode'][$key];
		 $freestatus=$_POST['freestatus'][$key];
		 $refno=$_POST['refno'][$key];
		 $date1=$_POST['date1'][$key];
	     $storecode =$_POST['storecode'][$key]; 
	  	 $date1=date("Y-m-d",strtotime($date1));

		  $queryrefund = "select sum(return_quantity) as return_total from medicine_return_request where patientcode = '$patientcode' and visitcode = '$visitcode' and itemcode='".$itemcode."' and refno='".$refno."' and completestatus <> 'complete' group by itemcode,refno,fifo_code";
		   $execrefund = mysqli_query($GLOBALS["___mysqli_ston"], $queryrefund) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		  $returnqty=0;
		  $returnqty1=0;
		   while($resrefund = mysqli_fetch_array($execrefund))
		   {
		   $returnqty = $resrefund['return_total'];
		   }
		
		    $queryrefund1 = "select sum(quantity) as  return_total  from  pharmacysalesreturn_details where fifo_code='$fifo_code' and patientcode = '$patientcode' and visitcode = '$visitcode' and itemcode='".$itemcode."' and docnumber='".$refno."' group by itemcode,docnumber,fifo_code";
		   $execrefund1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryrefund1) or die("queryrefund1 ".mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($resrefund1 = mysqli_fetch_array($execrefund1))
		  {
		    $returnqty1 = $resrefund1['return_total'];
		   }
		    $returnqty1+=$returnqty;


		 
		 if(($returnmed != '' || $returnmed != 0) && $key!=='' && ($issueqty-$returnqty1)>0 )
		{
		$query65="insert into medicine_return_request (itemcode, itemname, date, docno, refno, issue_quantity, return_quantity, rateperunit, freestatus, return_amount, 
	 username, ipaddress,patientname ,patientcode, visitcode,locationname,locationcode,fifo_code,store)
	values ('$itemcode', '$itemname', '".$updatedatetime."', '".$consultationcode."','".$refno."','".$issueqty."','".$returnmed."','".$rateperunit."','".$freestatus."','".$refundamount."',
	'$username', '$ipaddress', '".$patientname."','".$patientcode."','".$visitcode."','".$locationname."','".$locationcode."','$fifocode','$storecode')";
$exec65=mysqli_query($GLOBALS["___mysqli_ston"], $query65) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		/*$query40 = "select * from master_itempharmacy where itemcode = '$itemcode'";
	$exec40 = mysql_query($query40) or die ("Error in Query40".mysql_error());
	$res40 = mysql_fetch_array($exec40);
	$itemmrp = $res40['rateperunit'];
	
	$itemsubtotal = $itemmrp * $addstock;
	
		if($addstock != '')
		{
		$query65="insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 
	transactionparticular, billautonumber, billnumber, quantity, remarks, 
	 username, ipaddress, rateperunit, totalrate, companyanum, companyname,batchnumber)
	values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 
	'BY ADJUSTMENT ADD', '$billautonumber', '$billnumber', '$addstock', '$remarks', 
	'$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname','$batchnumber')";
$exec65=mysql_query($query65) or die(mysql_error());
		}
		else
		{
		$query65="insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 
	transactionparticular, billautonumber, billnumber, quantity, remarks, 
	 username, ipaddress, rateperunit, totalrate, companyanum, companyname,batchnumber)
	values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 
	'BY ADJUSTMENT MINUS', '$billautonumber', '$billnumber', '$minusstock', '$remarks', 
	'$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname','$batchnumber')";
$exec65=mysql_query($query65) or die(mysql_error());
	
		}*/
		}
		
	header("location:activeinpatientlist.php");
	exit;
	
}

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

include ("autocompletebuild_customeripbilling.php");
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
<?php include ("js/dropdownlistipbilling.php"); ?>
<script type="text/javascript" src="js/autosuggestipbilling.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_customeripbilling.js"></script>
<script language="javascript">
function numbervaild(key)
{
 var keycode = (key.which) ? key.which : key.keyCode;

  if(keycode > 40 && (keycode < 48 || keycode > 57 )&&( keycode < 96 || keycode > 111))
 {
  return false;
 }
 
 //var val=document.getElementById("returnmed").value; // alert(val);
	//var keycode = (key.which) ? key.which : key.keyCode;
	
	 
	/*var amount=(parseFloat(val)*parseFloat(document.getElementById("rateperunit").value));
	if(document.getElementById("freestatus").value=='No')
	{
		document.getElementById("refundamount").value=amount;
		}
		else
		{
		document.getElementById("refundamount").value=0;
		}*/
}
function emptyreturn(rowkey)
{
	document.getElementById("returnmed"+rowkey).value=0.00;
	
	}
function refundmaount(rowkey,key)
{  //var rowkey1=parseFloat(rowkey)-1;
//var temps=document.form11.rateperunit[rowkey1].value; alert(temps);
//alert(rowkey); 
var checked=document.getElementById("che"+rowkey).checked;// alert(checked);
if(checked==true) 
{ 
var rpu=document.getElementById("rateperunit"+rowkey).value; // alert(rpu);
var rqty=document.getElementById("returnmed"+rowkey).value;  //alert(rqty);
var isqty=document.getElementById("canreturn"+rowkey).value;
	//var keycode = (key.which) ? key.which : key.keyCode;
	
	
		 if((rqty=='')||(rqty==0))
		 {
			 document.getElementById("refundamount"+rowkey).value=0;
			 return ;
			 }
			 else
			 {
						 if(parseFloat(isqty)>=parseFloat(rqty))
							{
							var amount=(parseFloat(rpu)*parseFloat(rqty));
							if(document.getElementById("freestatus"+rowkey).value=='No')
							{
								document.getElementById("refundamount"+rowkey).value=amount;
								}
								else
								{
								document.getElementById("refundamount"+rowkey).value=0;
								}
							}
						else
						{
							alert('Return Quantity Greater than Balance Quantity');
							document.getElementById("returnmed"+rowkey).value=0;
							document.getElementById("refundamount"+rowkey).value=0;
							return false;
							}
			}
}
else{alert('Please Select Check box');document.getElementById("returnmed"+rowkey).value=''; return false;}

	}
	
	
function cbsuppliername1()
{
	document.cbform1.submit();
}

function funcOnLoadBodyFunctionCall()
{ 
	//alert ("Inside Body On Load Fucntion.");
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
}



</script>
<script type="text/javascript">

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
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body onLoad="return funcOnLoadBodyFunctionCall()">
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
	
		
<form name="form11" id="form11" method="post" action="medicinereturnrequest.php">
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1175" 
            align="left" border="0">
            	
          <tbody>
          <?php
	$colorloopcount=0;
	$sno=0;
	
	$patientcode = $_REQUEST['patientcode'];
	$visitcode = $_REQUEST['visitcode'];
	if (isset($_REQUEST["docnumber"])) { $docnumber = $_REQUEST["docnumber"]; } else { $docnumber = ""; }
	
	$query39 = "select * from ipmedicine_issue where patientcode = '$patientcode' and visitcode = '$visitcode' ";
		   $exec39 = mysqli_query($GLOBALS["___mysqli_ston"], $query39) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   $res39 = mysqli_fetch_array($exec39);
           $res39visitcode = $res39['visitcode'];
		   $res39patientname = $res39['patientname'];
	
           $reslocationname = '';
		    $reslocationcode = '';
		
?>
               <tr>
			     <td colspan="12" align="center" bgcolor="#cccccc" class="bodytext31"><strong><?php echo $res39patientname;  ?>-<?php echo $patientcode; ?>-<?php echo $res39visitcode; ?></strong></td><input type="hidden" name="patientname" value="<?php echo $res39patientname;?>">
                 <input type="hidden" name="patientcode" value="<?php echo $patientcode;?>">
                 <input type="hidden" name="visitcode" value="<?php echo $res39visitcode;?>">
                 <input type="hidden" name="locationname" value="<?php echo $reslocationname;?>">
                 <input type="hidden" name="locationcode" value="<?php echo $reslocationcode;?>">
			 </tr>
            <tr>
              <td width="4%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong> &nbsp;Select</strong></div></td>
                 <td width="4%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong> &nbsp;S.No.</strong></div></td>
				<td width="9%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Store</strong></div></td>
				    <td width="9%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Date</strong></div></td>
				 <td width="8%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Ref No</strong></div></td>
				  <td width="16%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Medicine</strong></div></td>
				 <td width="7%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Issues</strong></div></td>
				 <td width="7%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Returns</strong></div></td>
                <td width="7%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Balance</strong></div></td>
				    <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate</strong></div></td>
		            <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Free</strong></div></td>
	                <td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>
	                 <td width="1%"  align="left" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                    <td width="16%"  align="left" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              </tr>
           <?php
		  
		 
           $query34 = "select patientname,patientcode,visitcode,itemname,itemcode,ipdocno,quantity,entrydate,rate,totalamount,fifo_code,freestatus,auto_number,sum(quantity) as quantity1,sum(totalamount) as totalamount1,store from pharmacysales_details where patientcode = '$patientcode' and visitcode = '$visitcode' and entrydate >='2016-01-01' group by itemcode,store,ipdocno,fifo_code";
		   $exec34 = mysqli_query($GLOBALS["___mysqli_ston"], $query34) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($res34 = mysqli_fetch_array($exec34))
		   {
		   $patientname = $res34['patientname'];
		   $patientcode = $res34['patientcode'];
		   $visitcode = $res34['visitcode'];
		   $itemname = $res34['itemname'];
		   $itemcode = $res34['itemcode'];
		   $docno = $res34['ipdocno'];
		   $quantity = $res34['quantity1'];
		   $res34date = $res34['entrydate'];
		   $rateperunit = $res34['rate'];
		   $totalrate = $res34['totalamount1'];
		   $freestatus = $res34['freestatus'];
		   $auto_number = $res34['auto_number'];
		   $fifo_code=$res34['fifo_code'];
		   $store=$res34['store'];

	        $query10 = "select store from master_store where storecode = '$store'";
			$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res10 = mysqli_fetch_array($exec10);
			$storename = $res10['store'];

		   $totalamount = $totalamount + $totalrate;
		   $returnqty='';
		   $returnqty1='';
		   $queryrefund = "select sum(return_quantity) as return_total from medicine_return_request where patientcode = '$patientcode' and visitcode = '$visitcode' and itemcode='".$itemcode."' and fifo_code='$fifo_code' and refno='".$docno."' and completestatus <> 'complete' group by itemcode,refno,fifo_code";
		   $execrefund = mysqli_query($GLOBALS["___mysqli_ston"], $queryrefund) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
		 $returnqty=0;
		 $returnqty1=0;
		   while($resrefund = mysqli_fetch_array($execrefund))
		   {
		   $returnqty = $resrefund['return_total'];
		   }
		
		    $queryrefund1 = "select sum(quantity) as  return_total  from  pharmacysalesreturn_details where fifo_code='$fifo_code' and patientcode = '$patientcode' and visitcode = '$visitcode' and itemcode='".$itemcode."' and docnumber='".$docno."' group by itemcode,docnumber,fifo_code";
		   $execrefund1 = mysqli_query($GLOBALS["___mysqli_ston"], $queryrefund1) or die("queryrefund1 ".mysqli_error($GLOBALS["___mysqli_ston"]));
		   while($resrefund1 = mysqli_fetch_array($execrefund1))
		  {
		    $returnqty1 = $resrefund1['return_total'];
		   }
		    $returnqty1+=$returnqty;
			
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
			$sno = $sno + 1;
			?>
			
          <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" name="che[<?= $sno ?>]" id="che<?php echo $sno;?>" value="<?php echo $sno;?>" onClick="emptyreturn(<?php echo $sno;?>)" <?php if(($quantity-$returnqty1)<=0) echo "disabled"; ?>></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno;  ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $storename;  ?></div></td>

		
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo  date("d/m/Y", strtotime($res34date)); ?></div><input type="hidden" name="date1[<?= $sno ?>]"  value="<?php echo $res34date; ?>"></td>
				
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $docno; ?></div><input type="hidden" name="refno[<?= $sno ?>]" value="<?php echo $docno;?>"></td>
					  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $itemname; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo intval($quantity); ?><input type="hidden" name="issueqty[<?= $sno ?>]" id="issueqty<?php echo $sno;?>" value="<?php echo intval($quantity);?>"></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><input type="text" name="returnmed[<?= $sno ?>]" id="returnmed<?php echo $sno;?>" style="width:40px" onKeyDown="return numbervaild(event)"  onKeyUp="refundmaount(<?php echo $sno;?>,event)" value="<?php echo $returnqty1;?>"></div></td>
                <input type="hidden" name="returnedmed[<?= $sno ?>]" id="returnedmed<?php echo $sno;?>" value="<?php echo $returnqty;?>">
                <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $balance=$quantity-$returnqty1; ?><input type="hidden" name="balance[<?= $sno ?>]" id="balance<?php echo $sno;?>" value="<?php echo $balance;?>"></div></td>			<input type="hidden" name="canreturn[<?= $sno ?>]" id="canreturn<?php echo $sno;?>" value="<?php echo $balance;?>">
					  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $rateperunit; ?><input type="hidden" name="rateperunit[<?= $sno ?>]" id="rateperunit<?php echo $sno;?>" value="<?php echo $rateperunit;?>"></div></td>
			          

                      <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $freestatus;?><input type="hidden" name="freestatus[<?= $sno ?>]" id="freestatus<?php echo $sno;?>" value="<?php echo $freestatus;?>"></div></td>
		              <td  align="left" valign="center" class="bodytext31"><div align="center"><input type="text" readonly name="refundamount[<?= $sno ?>]" id="refundamount<?php echo $sno;?>" style="background:none;border:none;width:50px"></div></td>
	                  <td class="bodytext31" bgcolor="#ecf0f5" valign="center" align="left">&nbsp;</td>
                    <td class="bodytext31" bgcolor="#ecf0f5" valign="center" align="left">&nbsp;</td>
                    <input type="hidden" name="itemname[<?= $sno ?>]" value="<?php echo $itemname;?>">
                    <input type="hidden" name="itemcode[<?= $sno ?>]" value="<?php echo $itemcode;?>">
                    <input type="hidden" name="fifocode[<?= $sno ?>]" value="<?php echo $fifo_code;?>">
					<input type="hidden" name="storecode[<?= $sno ?>]" value="<?php echo $store;?>">

                    </tr>
			<?php } ?>			
					

			
			
            <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>

			
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
             	<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
            <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"><div align="center"><strong>&nbsp;</strong></div></td>
				   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"><div align="center"><strong>&nbsp;</strong></div></td>
                <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"><div align="center"><strong>&nbsp;</strong></div></td>
                <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ecf0f5"><div align="center"><strong>&nbsp;</strong></div></td>
				   <td align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				   <td align="right" valign="center" 
                bgcolor="#ecf0f5" class="bodytext31"><div align="left">&nbsp;</div></td>
                
                </tr>
              <?php  ?>
			
             <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><input type="submit" value="Submit" >
        <input type="hidden" name="frmflag2" value="frmflag2">
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
			<tr>
			<td valign="center" class="style1">&nbsp;</td></tr>
            
          </tbody> 
        </table>	</form>	</td>
      </tr>
     
	 
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>


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
$transferquantity2 = '';
$transferamount2 = '0';
$snocount="";
$colorloopcount="";

$total_price1="";

$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	 $res12locationanum = $res["auto_number"];
	 
  $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
//To populate the autocompetelist_services1.js
//include ("autocompletebuild_item1pharmacy.php");
if (isset($_REQUEST["store"]) && $_REQUEST["store"]!='') { $store = $_REQUEST["store"]; } else { $store = ""; }
// $transactiondatefrom = '2017-01-01';
// $transactiondateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
	
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
// if (isset($_REQUEST["ADate2"])) { $transactiondateto = $_REQUEST["ADate2"]; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
if ($ADate1 != '' && $ADate2 != '')
{
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
}
else
{
	$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
	$transactiondateto = date('Y-m-d');
}



if (isset($_REQUEST["searchitemcode"])) { $searchitemcode = $_REQUEST["searchitemcode"]; } else { $searchitemcode = ""; }
//$itemcode = $_REQUEST['itemcode'];
if (isset($_REQUEST["servicename"])) { $servicename = $_REQUEST["servicename"]; } else { $servicename = ""; }
//$servicename = $_REQUEST['servicename'];

//if ($servicename == '') $servicename = 'ALL';

if (isset($_REQUEST["itemname"])) { $searchitemname = $_REQUEST["itemname"]; } else { $searchitemname = ""; }
if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
//$searchitemname = $_REQUEST['itemname'];
if ($searchitemname != '')
{
	$arraysearchitemname = explode('||', $searchitemname);
	$itemcode = $arraysearchitemname[0];
	$itemcode = trim($itemcode);
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

<script src="js/datetimepicker_css.js"></script>
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
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<?php include ("js/dropdownlist1scripting1stock1.php"); ?>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script type="text/javascript" src="js/autosuggest1itemstock2.js"></script>
<script type="text/javascript" src="js/autocomplete_item1pharmacy4.js"></script>
<script type="text/javascript">


function stockinwardvalidation1()
{
	
	if (document.stockinward.itemcode.value == "")
	{
		alert ("Please Select Item Name.")
		return false;
	}
	else if (document.stockinward.servicename.value == "")
	{
		alert ("Please Select Item Name.")
		document.stockinward.servicename.focus();
		return false;
	}
	else if (document.stockinward.stockquantity.value == "")
	{
		alert ("Please Enter Stock Quantity.")
		document.stockinward.stockquantity.focus();
		return false;
	}
	else if (isNaN(document.stockinward.stockquantity.value))
	{
		alert ("Please Enter Only Numbers Stock Quantity.")
		document.stockinward.stockquantity.focus();
		return false;
	}
	else if (document.stockinward.stockquantity.value == "0")
	{
		alert ("Please Enter Stock Quantity.")
		document.stockinward.stockquantity.focus();
		return false;
	}
	else if (document.stockinward.stockquantity.value == "0.0")
	{
		alert ("Please Enter Stock Quantity.")
		document.stockinward.stockquantity.focus();
		return false;
	}
	else if (document.stockinward.stockquantity.value == "0.00")
	{
		alert ("Please Enter Stock Quantity.")
		document.stockinward.stockquantity.focus();
		return false;
	}
	else if (document.stockinward.stockquantity.value == "0.000")
	{
		alert ("Please Enter Stock Quantity.")
		document.stockinward.stockquantity.focus();
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

function Locationcheck()
{
if(document.getElementById("location").value == '')
{
alert("Please Select Location");
document.getElementById("location").focus();
return false;
}
/*if(document.getElementById("store").value == '')
{
alert("Please Select Store");
document.getElementById("store").focus();
return false;
}*/
}

//ajax function to get store for corrosponding location
function storefunction(loc)
{
	var username=document.getElementById("username").value;
	
var xmlhttp;

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
    document.getElementById("store").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","ajax/ajaxstore.php?loc="+loc+"&username="+username,true);
xmlhttp.send();

	}
</script>
<body onLoad="return funcCustomerDropDownSearch1();">
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
    <td width="1%" rowspan="3">&nbsp;</td>
    <td width="2%" rowspan="3" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		<form name="stockinward" action="non_moving_stock.php" method="post" onKeyDown="return disableEnterKey()" onSubmit="return Locationcheck()">
	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
      <tbody id="foo">
        <tr>
          <td colspan="5" bgcolor="#ecf0f5" class="bodytext31"><strong>Non Moving Stock</strong></td>
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
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Location</strong></td>
              <td  bgcolor="#FFFFFF" class="bodytext3"  colspan="4" ><select name="location" id="location" style="border: 1px solid #001E6A;" onChange="storefunction(this.value)">
              <!-- <option value="">-Select Location-</option> -->
                  <?php
						
						$query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res = mysqli_fetch_array($exec))
						{
						$reslocation = $res["locationname"];
						$reslocationanum = $res["locationcode"];
						?>
						<option value="<?php echo $reslocationanum; ?>" <?php if($location!='')if($location==$reslocationanum){echo "selected";}?>><?php echo $reslocation; ?></option>
						<?php 
						}
						?>
                  </select></td>
                   
                  <input type="hidden" name="locationnamenew" value="<?php echo $locationname; ?>">
                <input type="hidden" name="locationcodenew" value="<?php echo $res1locationanum; ?>">
                <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
             
              </tr>
		<tr>
		  <td width="104" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Store</strong> </td>
          <td colspan="4" width="680" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
		  <?php  $loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 				 $username=isset($_REQUEST['username'])?$_REQUEST['username']:'';
 				 $frmflag1=isset($_REQUEST['frmflag1'])?$_REQUEST['frmflag1']:'';
				 $store=isset($_REQUEST['store'])?$_REQUEST['store']:'';?>  
           <select name="store" id="store">
           	
		   <option value="">-Select Store-</option>
           <?php //if ($frmflag1 == 'frmflag1')
			//{ 
				$loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';
			$username=isset($_REQUEST['username'])?$_REQUEST['username']:'';
			$query5 = "SELECT auto_number, storecode, store from master_store order by store";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5 = mysqli_fetch_array($exec5))
				{
				$res5anum = $res5["storecode"];
				$res5name = $res5["store"];
				//$res5department = $res5["department"];
					?>
				<option value="<?php echo $res5anum;?>" <?php if($store==$res5anum){ echo 'selected'; } ?>><?php echo $res5name;?></option>
				<?php } 
			//} ?>
			</select>
		  </td>
		  </tr>
          
       
        
	    <!-- <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"><b> Date From </b></td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php  echo $transactiondatefrom;  ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                  </tr> -->
                  <tr>
                  	<td width="104" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Days</strong> </td>
          			<td colspan="4" width="680" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
          				<input type="text" name="days" value="<?php if(isset($_POST['days'])){ echo $_POST['days']; }else{ echo '90'; } ?>" placeholder="Enter Days">
          			</td>

                  </tr>
                  <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
             
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF" >
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                  <input  type="submit" value="Search" name="search" />
                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
                   <td class="bodytext31"  bgcolor="#FFFFFF" align="right">Please Note: The cost price is from Master. </td>
            </tr>
		  
        <tr>
          <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"></td>
          <td colspan="4" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">&nbsp;		  </td>
          </tr>
      </tbody>
    </table>
    </form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1250" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="3%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="8%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <td width="14%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
                  <td width="13%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
              <!-- <td width="11%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td> -->
                    <td width="13%" bgcolor="#ecf0f5" class="bodytext31"><a 
                  href="#"></a></td>
                     <td width="11%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
			    <td width="9%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
			    <td width="9%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
			    <td width="9%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<td width="13%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>
				<!--<td width="13%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>-->
            </tr>

            <tr>
              <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><strong>No.</strong></td>
              <td align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Item Code </strong></td>
              <td align="left" valign="center"   bgcolor="#ffffff" class="bodytext31"><strong>Item Name </strong></td>
				
				<td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Category </strong></td>
				
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Last Transaction Date</strong></td>

                <td align="middle" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Non Moving Days</strong></td>

                <!--  <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Batch Number</strong></td> -->
				      <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Current Stock</strong></div></td>

                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Cost Price</strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
   
                  <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Store</strong></div></td>
                            
        
            </tr>
            <?php
			if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
			if (isset($_REQUEST["store"]) ) { $store = $_REQUEST["store"]; } else { $store = ""; }
			if (isset($_REQUEST["days"]) ) { $days = $_REQUEST["days"]; } else { $days = ""; }
			//$categoryname = $_REQUEST['categoryname'];
			if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
			//$frmflag1 = $_REQUEST['frmflag1'];
			if (isset($_POST['search']))
			{
				$qty=0;
				$total_price1="0.00";
			// echo $query21 = "SELECT sum(batch_quantity) as qty FROM `transaction_stock` WHERE `batch_stockstatus`='1' and storecode='$store'  group by itemcode ";
			// $exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
			//   while ($res21 = mysql_fetch_array($exec21))
			//   {
		 //  	 	$qty=$res21['qty'];
		 //  	 }
			  	 $query2 = "SELECT sum(batch_quantity) as qty,storecode,transaction_date, itemcode, itemname  FROM `transaction_stock` WHERE `batch_stockstatus`='1' and storecode='$store' group by itemcode order by transaction_date asc";
			  	// desc limit 1
				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			  while ($res2 = mysqli_fetch_array($exec2))
			  {
			  	     $qty=$res2['qty'];
				  	$storecode=$res2['storecode'];

				  	$itemcode=$res2['itemcode'];
					$query3 = "SELECT * FROM `transaction_stock` WHERE itemcode='$itemcode' and `batch_stockstatus`='1' and storecode='$store' order by transaction_date desc limit 1  ";
					$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
			  		while ($res3 = mysqli_fetch_array($exec3)){
			  			$trans_date=$res3['transaction_date'];
			  		}

				  	// $trans_date=$res2['transaction_date'];
				  	//$trans_date1=strtotime($res2['transaction_date']);
					$trans_date1=strtotime($trans_date);
				  	$today_date=strtotime($transactiondateto);
					$datediff = $today_date - $trans_date1;
					$diff_days = round($datediff / (60 * 60 * 24));

					
					
			$query72 = "select categoryname from master_medicine where itemcode='$itemcode' order by auto_number desc";

			$exec72 = mysqli_query($GLOBALS["___mysqli_ston"], $query72) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));	

			$num2 = mysqli_num_rows($exec72);

			$res72=mysqli_fetch_array($exec72);

			$categoryname = $res72['categoryname'];
					

					// $earlier = new DateTime($trans_date);
					// $later = new DateTime($transactiondateto);
					//  $diff = $later->diff($earlier)->format("%a")."--";
					if($days!=""){
						$noofdays_old=$days;
					}else{
						$noofdays_old="90";
						$days='90';
					}
					// $qty="0";
					// $itemcode=$res2['itemcode'];
					// $query3 = "SELECT * FROM `transaction_stock` WHERE itemcode='$itemcode' and `batch_stockstatus`='1' and storecode='$store' group by itemcode  ";
					// $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			  // 		while ($res3 = mysql_fetch_array($exec3)){
			  // 			$qty=$qty+$res3['batch_quantity'];
			  // 		}
					
					if(($diff_days>=$noofdays_old) && ($qty>0)){


					  	$snocount = $snocount + 1;
					    $colorloopcount = $colorloopcount + 1;
						$showcolor = ($colorloopcount & 1); 
						if ($showcolor == 0)
						{
							$colorcode = 'bgcolor="#CBDBFA"';
						}
						else
						{
							$colorcode = 'bgcolor="#ecf0f5"';
						}



					?>

		  <tr <?php echo $colorcode; ?>>
		  	<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2['itemcode']; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2['itemname']; ?></div></td>
				
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $categoryname; ?></div></td>
				
				
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2['transaction_date']; ?></td>
			  
              <td class="bodytext31" valign="center"  align="center">
			    <div align="center"><?php echo $diff_days; ?></div></td>
				
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php  echo number_format($qty,2,'.',','); ?></div></td>
			    

				<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php 
			    $itemcode=$res2['itemcode'];
			     $query112 = "SELECT * from master_medicine where itemcode='$itemcode'";
				$exec112 = mysqli_query($GLOBALS["___mysqli_ston"], $query112) or die ("Error in Query112".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res112 = mysqli_fetch_array($exec112);
						echo $pprice=$res112['purchaseprice'];
			     ?></div></td>

			     <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php 
			     $total_price=$pprice*$qty;
			     echo number_format($total_price,2,'.',','); 
			     ?></div></td>
				

				<td class="bodytext31" valign="center"  align="center">
			    <div align="center"><?php 

			    $query11 = "SELECT * from master_store where storecode='$storecode'";
				$exec11 = mysqli_query($GLOBALS["___mysqli_ston"], $query11) or die ("Error in Query11".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res11 = mysqli_fetch_array($exec11);
						echo $store_name=$res11['store'];
						 
						


			     ?></div></td>


				
              <td class="bodytext31" bgcolor="#ecf0f5" valign="center"  align="left">&nbsp; </td>
           </tr>
		  <?php  $total_price1=$total_price1+$total_price;

		  } // if condition
		   } //while
		// }
		  
			
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>&nbsp; </strong></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>&nbsp; </strong></div></td>
                        <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php //echo $totalcurrentstock1; ?>&nbsp;</strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>&nbsp;</strong></div></td>
                
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php echo number_format($total_price1,2,'.',','); ?></strong></div></td>
                
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong>&nbsp;</strong></div></td>
                   <!-- <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php //echo number_format($totalpurchaseprice1,2,'.',','); ?>&nbsp;</strong></div></td>
				   <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5"><div align="right"><strong><?php //echo number_format($grandtotalcogs,2,'.',','); ?>&nbsp;</strong></div></td> -->
       <td align="left" colspan="1"> <a target="_blank" href="xl_non_moving_stock.php?store=<?= $store;?>&&location=<?= $reslocationanum;?>&&days=<?= $days;?>"> <img src="images/excel-xls-icon.png" width="30" height="30"></a> </td>
            </tr>
			<?php
			}
			?>
          </tbody>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>    
  <tr>
    <td valign="top">    
  <tr>
    <td width="97%" valign="top">    
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

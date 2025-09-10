<?php
session_start();
set_time_limit(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");
date_default_timezone_set('Asia/Calcutta'); 
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$errmsg = "";
$searchmedicinename = "";
$colorloopcount = '';
$openingbalance = 0;
$user = ''; 
$snocount=0;   

$openingbalance_on_date1_final=0;
			$quantity1_purchase_final=0;
			$quantity1_preturn_final=0;
			$quantity1_receipts_final=0;
			$quantity2_transferout_final=0;
			$quantity2_sales_final=0;
			$quantity1_refunds_final=0;
			$quantity2_transferout_ownusage_final=0;
			$quantity1_excess_final=0;
			$quantity2_Short_final=0;
			$closingstock_on_date2_final=0;
//To populate the autocompetelist_services1.js
if (isset($_REQUEST["mainsearch"])) { $mainsearch = $_REQUEST["mainsearch"]; } else { $mainsearch = ""; }

$transactiondatefrom = date('Y-m-d', strtotime('-1 week'));
$transactiondateto = date('Y-m-d');

if (isset($_REQUEST["medicinecode"])) { $searchmedicinecode = $_REQUEST["medicinecode"]; } else { $searchmedicinecode = ""; }

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $transactiondatefrom; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $transactiondateto; }

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{
if (isset($_REQUEST["searchitemcode"])) { $searchmedicinecode = $_REQUEST["searchitemcode"]; } else { $searchmedicinecode = ""; }
//$medicinecode = $_REQUEST['medicinecode'];
if (isset($_REQUEST["itemname"])) { $searchmedicinename = $_REQUEST["itemname"]; } else { $searchmedicinename = ""; }
if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
if (isset($_REQUEST["store"])) { $store_search = $_REQUEST["store"]; } else { $store_search = ""; }

} 

$docno = $_SESSION['docno'];

  $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
  
  
  $query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	 $res12locationanum = $res["auto_number"];
	 
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
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; }
-->
</style>
</head>
<script language="javascript">
function funcOnLoadBodyFunctionCall()
{


	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	 //To handle ajax dropdown list.
	funcCustomerDropDownSearch4();
	
	
}

function Locationcheck()
{
if(document.getElementById("location").value == '')
{
alert("Please Select Location");
document.getElementById("location").focus();
return false;
}
// if(document.getElementById("store").value == '')
// {
// alert("Please Select Store");
// document.getElementById("store").focus();
// return false;
// }
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
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<script type="text/javascript" src="js/disablebackenterkey.js"></script>

<?php //include("autocompletebuild_medicine2.php"); ?>
<script type="text/javascript" src="js/autosuggestmedicine2.js"></script>
<?php include("js/dropdownlist1scripting1stock1.php"); ?>
<!--<script type="text/javascript" src="js/autocomplete_medicine2.js"></script>-->
<script type="text/javascript" src="js/autosuggest1itemstock2.js"></script>
<script type="text/javascript" src="js/autocomplete_item1pharmacy4.js"></script>

<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>

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

function Showrows(id, code, action)
{
	if(action=='down')
	{
		$("."+code).toggle('slow'); 
		$("#down"+id).hide(0); 
		$("#up"+id).show();
	}	
	else if(action=='up')
	{
		$("."+code).toggle('slow');  
		$("#up"+id).hide(0); 
		$("#down"+id).show();
	}
	
}

 function mainsearch_type() {
    var mainsearch  =  document.getElementById("mainsearch");
    var mainsearchvalue = mainsearch.options[mainsearch.selectedIndex].value;
    var trcat =  document.getElementById("trcat");
    var trsearch =  document.getElementById("trsearch");

      if (mainsearchvalue == 1) {
       trcat.style.display = "none";
       trsearch.style.display = "none";

      }
      else {
      trcat.style.display = "";
      trsearch.style.display = "";
      }  
}   
</script>
<?php // if($mainsearch==1){ ?><!-- 
<style type="text/css">
	.hidden{
		display: none;
	}
</style> -->
<?php // } ?>
<body onLoad="return funcCustomerDropDownSearch1();">
<table width="110%" border="0" cellspacing="0" cellpadding="2">
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
		
		
			<form name="stockinward" action="fullstock_movement.php" method="post" onKeyDown="return disableEnterKey()" onSubmit="return Locationcheck()">
	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
      <tbody id="foo">
        <tr>
          <td colspan="6" bgcolor="#ecf0f5" class="bodytext31"><strong>Stock Movement Report</strong></td>
          </tr>
        <tr>
          <td colspan="6" align="left" valign="center"  
                 bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#cbdbfa'; } ?>" class="bodytext31"><?php echo $errmsg; ?>&nbsp;</td>
          </tr>
          <tr>
          	<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Type</strong></td>
              <td  bgcolor="#FFFFFF" class="bodytext3"  colspan="5" >
              	<select name="mainsearch" id="mainsearch" onChange="mainsearch_type();" style="border: 1px solid #001E6A;" >
              		<option value="">--Select Type--</option>
              		<option value="1" <?php if($mainsearch==1){ echo 'selected';}?>>Summary</option>
              		<option value="2" <?php if($mainsearch==2){ echo 'selected';}?>>Detail</option>
              		<option value="3" <?php if($mainsearch==3){ echo 'selected';}?>>Detail with Batch</option>
              	</select>
          </tr>
        
		 <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Location</strong></td>
              <td  bgcolor="#FFFFFF" class="bodytext3"  colspan="5" ><select name="location" id="location" style="border: 1px solid #001E6A;" onChange="storefunction(this.value)">
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
						
				$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
				$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res = mysqli_fetch_array($exec);
				
				$locationname  = $res["locationname"];
				$locationcode = $res["locationcode"];
				$res12locationanum = $res["auto_number"];
						?>
                  </select></td>
                   
                  <input type="hidden" name="locationnamenew" value="<?php echo $locationname; ?>">
                <input type="hidden" name="locationcodenew" value="<?php echo $res1locationanum; ?>">
                <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
             
              </tr>
		<tr >
		  <td width="104" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Store</strong> </td>
          <td width="680" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31" colspan="5" >
		  <?php  $loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 				 $username=isset($_REQUEST['username'])?$_REQUEST['username']:'';
 				 $frmflag1=isset($_REQUEST['frmflag1'])?$_REQUEST['frmflag1']:'';
				 $store=isset($_REQUEST['store'])?$_REQUEST['store']:'';?>  
                 <select name="store" id="store">
		   <option value="">Select Store</option>
		   <!-- <option value="All">All</option>  -->
      <?php //if (1)
// {$loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';
// $username=isset($_REQUEST['username'])?$_REQUEST['username']:'';

// $query5 = "select ms.auto_number,ms.storecode,ms.store from master_employeelocation as me LEFT JOIN master_store as ms ON me.storecode=ms.auto_number where me.locationcode = '".$loc."' AND me.username= '".$username."'";
                $query5 = "SELECT storecode, store from master_store where locationcode='$locationcode'";
				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

				while ($res5 = mysqli_fetch_array($exec5))
				{
				$res5anum = $res5["storecode"];
				$res5name = $res5["store"];
				//$res5department = $res5["department"];
?>
 
<option value="<?php echo $res5anum;?>" <?php if($store==$res5anum){ echo 'selected';}?>><?php echo $res5name;?></option>
<?php } //}?>
		  </select>
		  </td>
		  </tr>
        <tr id="trcat" class="hidden">
          <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Category</strong></td>
          <td colspan="5" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><select name="categoryname" id="categoryname">
            <?php
			$categoryname = $_REQUEST['categoryname'];
			if ($categoryname != '')
			{
			?>
            <option value="<?php echo $categoryname; ?>" selected="selected"><?php echo $categoryname; ?></option>
            <option value="">Show All Category</option>
            <?php
			}
			else
			{
			?>
            <option selected="selected" value="">Show All Category</option>
            <?php
			}
			?>
            <?php
			$query42 = "select * from master_medicine where status = '' group by categoryname order by categoryname";
			$exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res42 = mysqli_fetch_array($exec42))
			{
			$categoryname1 = $res42['categoryname'];
			?>
            <option value="<?php echo $categoryname1; ?>"><?php echo $categoryname1; ?></option>
            <?php
			}
			?>
          </select></td>
        </tr>
        <tr id="trsearch" class="hidden">
        	 
	        <div >
	          <td align="left" valign="center"  
	                bgcolor="#ffffff" class="bodytext31"><strong>Search</strong></td>
	          <td colspan="5" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
			  <input type="hidden" name="searchitem1hiddentextbox" id="searchitem1hiddentextbox">
			  <input type="hidden" name="searchitemcode" id="searchitemcode">
			  <input name="itemname" type="text" id="itemname" style="border: 1px solid #001E6A; text-align:left" size="50" autocomplete="off" value="<?php echo $searchmedicinename; ?>">
	           </td>
	       </div>
        </tr>
        
        <tr>
          <td width="76" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="123" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $ADate1; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="51" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td colspan="2" width="129" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $ADate2; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
		  </tr>
        <tr>
          <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><input type="hidden" name="medicinecode" id="medicinecode" style="border: 1px solid #001E6A; text-align:left" onKeyDown="return disableEnterKey()" value="<?php echo $searchmedicinecode; ?>" size="10" readonly /></td>
          <td colspan="5" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
		 <div align="left">
            <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
            <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />
            <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" />
			<input type="hidden" name="frmflag1" value="frmflag1" id="frmflag1">
          </div></td>
        </tr>
        <tr>
          <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff">&nbsp;</td>
          <td colspan="5" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Date Range : <?php echo $ADate1.' To '.$ADate2; ?></strong></td>
        </tr>
      </tbody>
    </table>
    </form>		
	</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200"
            align="left" border="0">

          <tbody>
				<?php
				if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{

if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }

$noofdays=strtotime($ADate2) - strtotime($ADate1);
				$noofdays = $noofdays/(3600*24);
?>
<?php

if($_POST['mainsearch']=='1'){

?>

          	<tr>
             <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Sl. No</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Description</strong></td>
             <!--  <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Batch</strong></td> -->
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Opg.Stock</strong></div></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Purchase</strong></div></td>

                 <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Purchase Returns</strong></div></td>

                  <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Receipts</strong></div></td>

              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Issued To Dept</strong></div></td>

                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Sales</strong></div></td>


              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Refunds</strong></div></td>

                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Own Usage</strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Phy.Excess</strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Phy.Short</strong></div></td>

              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Closing Stock</strong></div></td>
				<!-- <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Username</strong></div></td> -->
				</tr>


<?php

 $query_store = "SELECT * FROM `master_store`"; 
if($store!=''){ 
  $query_store .= " where storecode='$store'  " ; 
}

$exec_store = mysqli_query($GLOBALS["___mysqli_ston"], $query_store) or die ("Error in query_store".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res_store = mysqli_fetch_array($exec_store))
				{ 
					$store=$res_store['storecode'];
					
					 $storename=$res_store['store']; 
                ////////////////////FIRST //////////////////
                // echo $openingbalance_on_date; 
                // $ADate12 = date('Y-m-d', strtotime('-1 day', strtotime($ADate1)));
                   $query1a = "SELECT sum(transaction_quantity) as addstock from transaction_stock where locationcode='$location' and storecode ='$store' and transaction_date < '$ADate1' and transactionfunction='1' order by auto_number desc  ";
                 // echo $query1a = "SELECT sum(transaction_quantity) as addstock from transaction_stock where itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date between '$ADate1' and '$ADate2' and transactionfunction='1' order by auto_number desc  ";
				$exec1a = mysqli_query($GLOBALS["___mysqli_ston"], $query1a) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	 
				$res1a = mysqli_fetch_array($exec1a);
				 $totaladdstock = $res1a['addstock'];
				
				$query1m = "SELECT sum(transaction_quantity) as minusstock from transaction_stock where  locationcode='$location' and storecode ='$store' and transaction_date < '$ADate1' and transactionfunction='0' order by auto_number desc  ";
				$exec1m = mysqli_query($GLOBALS["___mysqli_ston"], $query1m) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		 
				$res1m = mysqli_fetch_array($exec1m);
				 $totalminusstock = $res1m['minusstock'];
				
				 $openingbalance_on_date1 = $totaladdstock-$totalminusstock;
				// $balance_close_stock1 = $openingbalance;
				 ///////////////////////second//////////////////
				 $quantity1_purchase=0;  //PURCHASE
                   $query1_purchase = "SELECT transaction_quantity from transaction_stock where locationcode = '".$locationcode."'  and transactionfunction='1' and (description='Purchase' or description='OPENINGSTOCK' or description='".$storename."' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_purchase = mysqli_query($GLOBALS["___mysqli_ston"], $query1_purchase) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_purchase = mysqli_fetch_array($exec1_purchase))
				{
				
				  $quantity1_purchase += $res1_purchase['transaction_quantity'];

				} 
				//////////////////////THIRD /////////////////
				$quantity1_preturn=0;  //PURCHASE RETURN
                  $query1_pr = "SELECT transaction_quantity from transaction_stock where locationcode = '".$locationcode."' and transactionfunction='0' and description='Purchase Return' and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_pr = mysqli_query($GLOBALS["___mysqli_ston"], $query1_pr) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_pr = mysqli_fetch_array($exec1_pr))
				{
				
				  $quantity1_preturn += $res1_pr['transaction_quantity'];

				} 
				/////////////////// FOURTH //////////////////
				$quantity2_transferout_ownusage=0;
				$quantity1_receipts=0; //	Receipts --> Transfer IN
				$quantity1_receipts_1=0;
				$quantity1_receipts_2=0;
				
                   $query1_receipts = "SELECT transaction_quantity,entrydocno, storecode, itemcode from transaction_stock where locationcode = '".$locationcode."' and transactionfunction='1' and description='Stock Transfer To'   and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_receipts = mysqli_query($GLOBALS["___mysqli_ston"], $query1_receipts) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_receipts = mysqli_fetch_array($exec1_receipts))
				{
				  // $quantity1_receipts += $res1_receipts['transaction_quantity'];

				  	$docno=$res1_receipts['entrydocno'];
					$storecode_fet=$res1_receipts['storecode'];
					$itemcode_fet=$res1_receipts['itemcode'];

					// SELECT sum(`transferquantity`) FROM `master_stock_transfer` WHERE `fromstore`='STO1' and `typetransfer`='Transfer' and `entrydate` between '2019-03-01' and '2019-05-02'

						// $quantity1_receipts += $res1_receipts['transaction_quantity'];
					 
                    $query1_receipts2 = "SELECT typetransfer from master_stock_transfer where `docno`='$docno' and itemcode='$itemcode_fet' and locationcode = '".$locationcode."' ";
					$exec_receipts2 = mysqli_query($GLOBALS["___mysqli_ston"], $query1_receipts2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
					$res_receipts2 = mysqli_fetch_array($exec_receipts2);
					
						$typetransfer=$res_receipts2['typetransfer'];
						if($typetransfer=='Transfer'){
					  			$quantity1_receipts += $res1_receipts['transaction_quantity'];
					  		}else{
					  			$quantity2_transferout_ownusage += $res1_receipts['transaction_quantity'];
					  		}
				  	
				  	// $quantity1_receipts_1 = $quantity1_receipts+$quantity1_receipts1;
				  	// $quantity2_transferout_ownusage += $quantity2_transferout_ownusage1;
				} 
				//  $query1_receipts_2 = "SELECT transaction_quantity,entrydocno, storecode from transaction_stock where locationcode = '".$locationcode."' AND  transactionfunction='1' and  description='Stock Adj Add Stock'  and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				// $exec1_receipts_2 = mysql_query($query1_receipts_2) or die(mysql_error());			
				// while($res1_receipts_2 = mysql_fetch_array($exec1_receipts_2))
				// {
				// 	  			$quantity1_receipts_2 += $res1_receipts_2['transaction_quantity'];
				// } 
				// $quantity1_receipts=$quantity1_receipts_1+$quantity1_receipts_2;

				//////////////// fifth ///////////////////////////////////
				 $quantity2_transferout=0;  //Transfer out
				 $quantity2_transferout_1=0;   
				 $quantity2_transferout_2=0; 

				 $quantity2_transferout_11=0; 
				 $quantity2_transferout_22=0;
				 $quantity2_transferout_ownusage1=0; 
				 
                    $query12_transferout = "SELECT transaction_quantity,storecode, entrydocno ,itemcode from transaction_stock where locationcode = '".$locationcode."' AND  transactionfunction='0' and description='Stock Transfer From'  and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec12_transferout = mysqli_query($GLOBALS["___mysqli_ston"], $query12_transferout) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res12_transferout = mysqli_fetch_array($exec12_transferout))
				{

					$docno=$res12_transferout['entrydocno'];
					$storecode_fet=$res12_transferout['storecode'];
					$itemcode_fet=$res12_transferout['itemcode'];

					 // SELECT sum(`transferquantity`) FROM `master_stock_transfer` WHERE `fromstore`='STO1' and `typetransfer`='Transfer' and `entrydate` between '2019-03-01' and '2019-05-02'

                    $query12_transferout2 = "SELECT typetransfer ,transferquantity from master_stock_transfer where `docno`='$docno' and itemcode='$itemcode_fet' and locationcode = '".$locationcode."' ";
                    // AND  fromstore = '$storecode_fet'
					$exec12_transferout2 = mysqli_query($GLOBALS["___mysqli_ston"], $query12_transferout2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
					$res12_transferout2 = mysqli_fetch_array($exec12_transferout2);
					
						$typetransfer=$res12_transferout2['typetransfer'];
						// $transferquantity=$res12_transferout2['transferquantity'];
						if($typetransfer=='Consumable'){
					  			// $quantity2_transferout_ownusage += $transferquantity;
					  			$quantity2_transferout_ownusage += $res12_transferout['transaction_quantity'];
					  		}elseif($typetransfer=='Transfer'){
					  		// }else{
					  			// $quantity2_transferout += $transferquantity;
					  			$quantity2_transferout += $res12_transferout['transaction_quantity'];
					  		}
				  	// }
				  	
				  	// $quantity2_transferout = $quantity2_transferout+$quantity2_transferout_11;
				  	// $quantity2_transferout_ownusage=$quantity2_transferout_ownusage+$quantity2_transferout_ownusage1;
				} 

				 

				////////////////////////// SIXTH ///////////////
				$quantity2_sales=0;   // Sales
                    $query12_sales = "SELECT transaction_quantity from transaction_stock where locationcode = '".$locationcode."' AND transactionfunction='0' and (description='Sales' or description='Package' or description='IP Direct Sales' or description='IP Sales' or description='Process' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec12_sales = mysqli_query($GLOBALS["___mysqli_ston"], $query12_sales) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res12_sales = mysqli_fetch_array($exec12_sales))
				{
				
				  $quantity2_sales += $res12_sales['transaction_quantity'];

				} 
				////////////////// SEVENTH ///////////////////////////
				$quantity1_refunds=0;   // Refunds
                  $query1_refunds = "SELECT transaction_quantity from transaction_stock where locationcode = '".$locationcode."' AND  transactionfunction='1' and (description='Sales Return' or description='IP Sales Return' or description='Sales Return' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_refunds = mysqli_query($GLOBALS["___mysqli_ston"], $query1_refunds) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_refunds = mysqli_fetch_array($exec1_refunds))
				{
				
				  $quantity1_refunds += $res1_refunds['transaction_quantity'];

				} 
				/////////////////////////// eight CLOSING STOCK ///////////////////

				$query1a_closingstock = "SELECT sum(transaction_quantity) as addstock from transaction_stock where  locationcode='$location' and storecode ='$store' and transaction_date <= '$ADate2' and transactionfunction='1' order by auto_number desc  ";
                 // echo $query1a = "SELECT sum(transaction_quantity) as addstock from transaction_stock where itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date between '$ADate1' and '$ADate2' and transactionfunction='1' order by auto_number desc  ";
				$exec1a_closingstock = mysqli_query($GLOBALS["___mysqli_ston"], $query1a_closingstock) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	 
				$res1a_closingstock = mysqli_fetch_array($exec1a_closingstock);
				 $totaladdstock_closingstock = $res1a_closingstock['addstock'];
				
				$query1m_closingstock = "SELECT sum(transaction_quantity) as minusstock from transaction_stock where locationcode='$location' and storecode ='$store' and transaction_date <= '$ADate2' and transactionfunction='0' order by auto_number desc  ";
				$exec1m_closingstock = mysqli_query($GLOBALS["___mysqli_ston"], $query1m_closingstock) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		 
				$res1m_closingstock = mysqli_fetch_array($exec1m_closingstock);
				 $totalminusstock_closingstock = $res1m_closingstock['minusstock'];
				
				 $closingstock_on_date2 = $totaladdstock_closingstock-$totalminusstock_closingstock;
				///////////////////////////phy excess///////////////////////////
				 $quantity1_excess=0;
				 $query1_excess = "SELECT transaction_quantity,entrydocno, storecode from transaction_stock where locationcode = '".$locationcode."' AND  transactionfunction='1' and  description='Stock Adj Add Stock'  and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_excess = mysqli_query($GLOBALS["___mysqli_ston"], $query1_excess) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_excess = mysqli_fetch_array($exec1_excess))
				{
					  			$quantity1_excess += $res1_excess['transaction_quantity'];
				} 
				 /////////////////////  Phy.Short /////////
				 $quantity2_Short=0;
				 $query12_Short = "SELECT transaction_quantity,storecode, entrydocno from transaction_stock where locationcode = '".$locationcode."' AND  transactionfunction='0' and (description='Stock Damaged Minus Stock' or description='Stock Expired Minus Stock' or description='Stock Adj Minus Stock' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec12_Short = mysqli_query($GLOBALS["___mysqli_ston"], $query12_Short) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res12_Short = mysqli_fetch_array($exec12_Short))
				{
					$quantity2_Short += $res12_Short['transaction_quantity'];
				} 
				// $quantity2_Short_2=$quantity2_Short_2+$quantity2_Short_22;

				// $quantity2_Short=$quantity2_Short_1+$quantity2_Short_2;

				// if($openingbalance_on_date1==0 && $quantity1_purchase==0 && $quantity1_preturn==0 && $quantity1_receipts==0 && $quantity2_transferout==0 && $quantity2_sales==0 && $quantity1_refunds==0 && $closingstock_on_date2==0 && $quantity2_transferout_ownusage==0){

				// }else{

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
				} ?>
				 <tr <?php echo $colorcode; ?>>
				 	<td class="bodytext31" valign="center"  align="center"><?php echo $snocount; ?></td>
					<td class="bodytext31" valign="center"  align="left" ><strong><?=$storename;?></strong></td>
				
            	
            		  <td align="right" valign="right"  
                 class="bodytext31"><div align="right"><strong><?php echo number_format($openingbalance_on_date1,0,'.',','); ?></strong></div></td>

				<td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity1_purchase,0,'.',',');  ?>  </strong></td>

                 <td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity1_preturn,0,'.',','); ?>  </strong></td>
				
				<td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity1_receipts,0,'.',','); ?>  </strong></td>
       			
       			<td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity2_transferout,0,'.',',');   ?>  </strong></td>


            <td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity2_sales,0,'.',',');  ?>  </strong></td>
               
			<td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity1_refunds,0,'.',',');?>  </strong></td>

       			 <!-- <td align="left" valign="center"  
                 class="bodytext31"><strong> <?php //echo intval($balance);?> </strong></td> -->

                 <td align="right" valign="right"  
                 class="bodytext31"><strong> <?php echo number_format($quantity2_transferout_ownusage,0,'.',','); ?> </strong></td>
                   <td align="right" valign="right"  
                 class="bodytext31"><strong> <?php echo number_format($quantity1_excess,0,'.',',');  ?> </strong></td>
                   <td align="right" valign="right"  
                 class="bodytext31"><strong> <?php echo number_format($quantity2_Short,0,'.',','); ?> </strong></td>


                <td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($closingstock_on_date2,0,'.',','); ?>  </strong></td>
				 
			</tr>

<?php
// } // else of ==0 condition
   $openingbalance_on_date1_final        += $openingbalance_on_date1;
			$quantity1_purchase_final        +=$quantity1_purchase;
			$quantity1_preturn_final        +=$quantity1_preturn;
			$quantity1_receipts_final        +=$quantity1_receipts;
			$quantity2_transferout_final        +=$quantity2_transferout;
			$quantity2_sales_final        +=$quantity2_sales;
			$quantity1_refunds_final        +=$quantity1_refunds;
			$quantity2_transferout_ownusage_final        +=$quantity2_transferout_ownusage;
			$quantity1_excess_final        +=$quantity1_excess;
			$quantity2_Short_final        +=$quantity2_Short;
			$closingstock_on_date2_final  +=$closingstock_on_date2;

}//if condition
}else if($_POST['mainsearch']=='2'){
?>

          	<tr>
             <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Sl. No</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Description</strong></td>
             <!--  <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Batch</strong></td> -->
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Opg.Stock</strong></div></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Purchase</strong></div></td>

                 <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Purchase Returns</strong></div></td>

                  <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Receipts</strong></div></td>

              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Issued To Dept</strong></div></td>

                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Sales</strong></div></td>


              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Refunds</strong></div></td>

                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Own Usage</strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Phy.Excess</strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Phy.Short</strong></div></td>

              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Closing Stock</strong></div></td>
				<!-- <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Username</strong></div></td> -->
				</tr>

<?php
$query_store = "SELECT * FROM `master_store`"; 
if($store!=''){ 
$query_store .= " where storecode='$store'  " ; 
	}
$exec_store = mysqli_query($GLOBALS["___mysqli_ston"], $query_store) or die ("Error in query_store".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res_store = mysqli_fetch_array($exec_store))
				{ 
					$store=$res_store['storecode'];
					 $storename=$res_store['store']; 
					?>
					<tr>
                <td bgcolor="#FF9900" colspan="14" class="bodytext3" align="left"><strong><?php echo $res_store['store']; ?></strong></td>
                </tr>
                <?php

// $query991 = "select itemcode, categoryname, itemname from master_medicine where categoryname like '%$categoryname%' and itemcode like '%$searchmedicinecode%' and status <> 'deleted' group by categoryname order by categoryname, itemname";
// $exec991 = mysql_query($query991) or die ("Error in Query991".mysql_error());
// 				while ($res991 = mysql_fetch_array($exec991))
// 				{
// 					$categoryname2 = $res991['categoryname'];
// 					$itemname = $res991['itemname'];
				?>
               <!--  <tr>
                <td bgcolor="#FF9900" colspan="8" class="bodytext3" align="left"><strong><?php echo $categoryname2; ?></strong></td>
                </tr> -->
                <?php
				$sno = 0;
				$query99 = "SELECT itemcode, categoryname, itemname from master_medicine where categoryname like '%$categoryname%' and itemcode like '%$searchmedicinecode%' order by itemname";
				// $query99 = "select itemcode, categoryname, itemname from master_medicine where categoryname = '$categoryname2' and itemcode like '%$searchmedicinecode%' and status <> 'deleted' order by itemname";
$exec99 = mysqli_query($GLOBALS["___mysqli_ston"], $query99) or die ("Error in Query99".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res99 = mysqli_fetch_array($exec99))
				{
					$categoryname2 = $res99['categoryname'];
					$medicinecode = $res99['itemcode'];
					$itemname = $res99['itemname'];
				?>
				
                <?php
				//get store for location
// 	$loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';
// $username=isset($_REQUEST['username'])?$_REQUEST['username']:'';
//   $query5ll = "select ms.auto_number,ms.storecode,ms.store from master_employeelocation as me LEFT JOIN master_store as ms ON me.storecode=ms.auto_number where me.locationcode = '".$loc."' AND me.username= '".$username."'";
// if($store!='')
// {
// 	$query5ll .=" and ms.storecode='".$store."' group by ms.storecode";
// 	}
// 				$exec5ll = mysql_query($query5ll) or die ("Error in Query5ll".mysql_error());
// 				while ($res5ll = mysql_fetch_array($exec5ll))
// 				{
			
// 				}
                
				
				?>
				 
                
                <?php
                ////////////////////FIRST //////////////////
                // echo $openingbalance_on_date; 
                // $ADate12 = date('Y-m-d', strtotime('-1 day', strtotime($ADate1)));
                   $query1a = "SELECT sum(transaction_quantity) as addstock from transaction_stock where itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date < '$ADate1' and transactionfunction='1'   ";
                 // echo $query1a = "SELECT sum(transaction_quantity) as addstock from transaction_stock where itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date between '$ADate1' and '$ADate2' and transactionfunction='1' order by auto_number desc  ";
				$exec1a = mysqli_query($GLOBALS["___mysqli_ston"], $query1a) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	 
				$res1a = mysqli_fetch_array($exec1a);
				 $totaladdstock = $res1a['addstock'];
				
				$query1m = "SELECT sum(transaction_quantity) as minusstock from transaction_stock where itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date < '$ADate1' and transactionfunction='0'   ";
				$exec1m = mysqli_query($GLOBALS["___mysqli_ston"], $query1m) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		 
				$res1m = mysqli_fetch_array($exec1m);
				 $totalminusstock = $res1m['minusstock'];
				
				 $openingbalance_on_date1 = $totaladdstock-$totalminusstock;
				// $balance_close_stock1 = $openingbalance;
				 ///////////////////////second//////////////////
				 $quantity1_purchase=0;  //PURCHASE
                   $query1_purchase = "SELECT transaction_quantity from transaction_stock where locationcode = '".$locationcode."' AND itemcode = '$medicinecode' and transactionfunction='1' and (description='Purchase' or description='OPENINGSTOCK' or description='".$storename."' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_purchase = mysqli_query($GLOBALS["___mysqli_ston"], $query1_purchase) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_purchase = mysqli_fetch_array($exec1_purchase))
				{
				
				  $quantity1_purchase += $res1_purchase['transaction_quantity'];

				} 
				//////////////////////THIRD /////////////////
				$quantity1_preturn=0;  //PURCHASE RETURN
                  $query1_pr = "SELECT transaction_quantity from transaction_stock where locationcode = '".$locationcode."' AND itemcode = '$medicinecode' and transactionfunction='0' and description='Purchase Return' and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_pr = mysqli_query($GLOBALS["___mysqli_ston"], $query1_pr) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_pr = mysqli_fetch_array($exec1_pr))
				{
				
				  $quantity1_preturn += $res1_pr['transaction_quantity'];

				} 
				/////////////////// FOURTH //////////////////
				$quantity2_transferout_ownusage=0;
				$quantity1_receipts=0; //	Receipts --> Transfer IN
				$quantity1_receipts_1=0;
				$quantity1_receipts_2=0;
				
                   $query1_receipts = "SELECT transaction_quantity,entrydocno, storecode from transaction_stock where locationcode = '".$locationcode."' AND itemcode = '$medicinecode' and transactionfunction='1' and description='Stock Transfer To'   and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_receipts = mysqli_query($GLOBALS["___mysqli_ston"], $query1_receipts) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_receipts = mysqli_fetch_array($exec1_receipts))
				{
				  // $quantity1_receipts += $res1_receipts['transaction_quantity'];

				  	$docno=$res1_receipts['entrydocno'];
					$storecode_fet=$res1_receipts['storecode'];

					 
                    $query1_receipts2 = "SELECT typetransfer from master_stock_transfer where `docno`='$docno'  AND itemcode = '$medicinecode' limit 0,1";
					$exec_receipts2 = mysqli_query($GLOBALS["___mysqli_ston"], $query1_receipts2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
					$res_receipts2 = mysqli_fetch_array($exec_receipts2);
					
						$typetransfer=$res_receipts2['typetransfer'];
						if($typetransfer=='Transfer'){
					  			$quantity1_receipts += $res1_receipts['transaction_quantity'];
					  		}else{
					  			$quantity2_transferout_ownusage += $res1_receipts['transaction_quantity'];
					  		}
				  	
				  	// $quantity1_receipts_1 = $quantity1_receipts+$quantity1_receipts1;
				  	// $quantity2_transferout_ownusage += $quantity2_transferout_ownusage1;
				} 
				//  $query1_receipts_2 = "SELECT transaction_quantity,entrydocno, storecode from transaction_stock where locationcode = '".$locationcode."' AND itemcode = '$medicinecode' and transactionfunction='1' and  description='Stock Adj Add Stock'  and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				// $exec1_receipts_2 = mysql_query($query1_receipts_2) or die(mysql_error());			
				// while($res1_receipts_2 = mysql_fetch_array($exec1_receipts_2))
				// {
				// 	  			$quantity1_receipts_2 += $res1_receipts_2['transaction_quantity'];
				// } 
				// $quantity1_receipts=$quantity1_receipts_1+$quantity1_receipts_2;

				//////////////// fifth ///////////////////////////////////
				 $quantity2_transferout=0;  //Transfer out
				 $quantity2_transferout_1=0;   
				 $quantity2_transferout_2=0;   
				 
                    $query12_transferout = "SELECT transaction_quantity,storecode, entrydocno from transaction_stock where locationcode = '".$locationcode."' AND itemcode = '$medicinecode' and transactionfunction='0' and description='Stock Transfer From'  and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec12_transferout = mysqli_query($GLOBALS["___mysqli_ston"], $query12_transferout) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res12_transferout = mysqli_fetch_array($exec12_transferout))
				{

					$docno=$res12_transferout['entrydocno'];
					$storecode_fet=$res12_transferout['storecode'];

					 
                    $query12_transferout2 = "SELECT typetransfer from master_stock_transfer where `docno`='$docno' and locationcode = '".$locationcode."' AND itemcode = '$medicinecode'  and fromstore = '$storecode_fet'";
					$exec12_transferout2 = mysqli_query($GLOBALS["___mysqli_ston"], $query12_transferout2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
					$res12_transferout2 = mysqli_fetch_array($exec12_transferout2);
					
						$typetransfer=$res12_transferout2['typetransfer'];
						if($typetransfer=='Transfer'){
					  			$quantity2_transferout += $res12_transferout['transaction_quantity'];
					  		}else{
					  			$quantity2_transferout_ownusage += $res12_transferout['transaction_quantity'];
					  		}
				  	

				} 

				//  $query12_transferout = "SELECT transaction_quantity,storecode, entrydocno from transaction_stock where locationcode = '".$locationcode."' AND itemcode = '$medicinecode' and transactionfunction='0' and (description='Stock Damaged Minus Stock' or description='Stock Expired Minus Stock' or description='Stock Adj Minus Stock' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				// $exec12_transferout = mysql_query($query12_transferout) or die(mysql_error());			
				// while($res12_transferout = mysql_fetch_array($exec12_transferout))
				// {
				// 	$quantity2_transferout_2 += $res12_transferout['transaction_quantity'];
				// } 
				// $quantity2_transferout=$quantity2_transferout_1+$quantity2_transferout_2;

				////////////////////////// SIXTH ///////////////
				$quantity2_sales=0;   // Sales
                    $query12_sales = "SELECT transaction_quantity from transaction_stock where locationcode = '".$locationcode."' AND itemcode = '$medicinecode' and transactionfunction='0' and (description='Sales' or description='Package' or description='IP Direct Sales' or description='IP Sales' or description='Process' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec12_sales = mysqli_query($GLOBALS["___mysqli_ston"], $query12_sales) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res12_sales = mysqli_fetch_array($exec12_sales))
				{
				
				  $quantity2_sales += $res12_sales['transaction_quantity'];

				} 
				////////////////// SEVENTH ///////////////////////////
				$quantity1_refunds=0;   // Refunds
                  $query1_refunds = "SELECT transaction_quantity from transaction_stock where locationcode = '".$locationcode."' AND itemcode = '$medicinecode' and transactionfunction='1' and (description='Sales Return' or description='IP Sales Return' or description='Sales Return' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_refunds = mysqli_query($GLOBALS["___mysqli_ston"], $query1_refunds) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_refunds = mysqli_fetch_array($exec1_refunds))
				{
				
				  $quantity1_refunds += $res1_refunds['transaction_quantity'];

				} 
				/////////////////////////// eight CLOSING STOCK ///////////////////

				$query1a_closingstock = "SELECT sum(transaction_quantity) as addstock from transaction_stock where itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date <= '$ADate2' and transactionfunction='1' order by auto_number desc  ";
                 // echo $query1a = "SELECT sum(transaction_quantity) as addstock from transaction_stock where itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date between '$ADate1' and '$ADate2' and transactionfunction='1' order by auto_number desc  ";
				$exec1a_closingstock = mysqli_query($GLOBALS["___mysqli_ston"], $query1a_closingstock) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	 
				$res1a_closingstock = mysqli_fetch_array($exec1a_closingstock);
				 $totaladdstock_closingstock = $res1a_closingstock['addstock'];
				
				$query1m_closingstock = "SELECT sum(transaction_quantity) as minusstock from transaction_stock where itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date <= '$ADate2' and transactionfunction='0' order by auto_number desc  ";
				$exec1m_closingstock = mysqli_query($GLOBALS["___mysqli_ston"], $query1m_closingstock) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		 
				$res1m_closingstock = mysqli_fetch_array($exec1m_closingstock);
				 $totalminusstock_closingstock = $res1m_closingstock['minusstock'];
				
				 $closingstock_on_date2 = $totaladdstock_closingstock-$totalminusstock_closingstock;

				 ///////////////////////////phy excess///////////////////////////
				 $quantity1_excess=0;
				 $query1_excess = "SELECT transaction_quantity,entrydocno, storecode from transaction_stock where locationcode = '".$locationcode."' AND itemcode = '$medicinecode' AND  transactionfunction='1' and  description='Stock Adj Add Stock'  and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_excess = mysqli_query($GLOBALS["___mysqli_ston"], $query1_excess) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_excess = mysqli_fetch_array($exec1_excess))
				{
					  			$quantity1_excess += $res1_excess['transaction_quantity'];
				} 
				 /////////////////////  Phy.Short /////////
				 $quantity2_Short=0;
				 $query12_Short = "SELECT transaction_quantity,storecode, entrydocno from transaction_stock where locationcode = '".$locationcode."' AND itemcode = '$medicinecode' AND  transactionfunction='0' and (description='Stock Damaged Minus Stock' or description='Stock Expired Minus Stock' or description='Stock Adj Minus Stock' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec12_Short = mysqli_query($GLOBALS["___mysqli_ston"], $query12_Short) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res12_Short = mysqli_fetch_array($exec12_Short))
				{
					$quantity2_Short += $res12_Short['transaction_quantity'];
				} 
				//////////////////////////////////////////////////////

				if($openingbalance_on_date1==0 && $quantity1_purchase==0 && $quantity1_preturn==0 && $quantity1_receipts==0 && $quantity2_transferout==0 && $quantity2_sales==0 && $quantity1_refunds==0 && $closingstock_on_date2==0 && $quantity2_transferout_ownusage==0 && $quantity1_excess==0 && $quantity2_Short==0){

				}else{

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
				} ?>
				 <tr <?php echo $colorcode; ?>>
				 	<td class="bodytext31" valign="center"  align="center"><?php echo $snocount; ?></td>
					<td class="bodytext31" valign="center"  align="left" ><strong><?=$itemname;?></strong></td>
				
            
            		  <td align="right" valign="right"  
                 class="bodytext31"><div align="right"><strong><?php echo number_format($openingbalance_on_date1,0,'.',',');?></strong></div></td>

				<td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity1_purchase,0,'.',','); ?>  </strong></td>

                 <td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity1_preturn,0,'.',','); ?>  </strong></td>
				
				<td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity1_receipts,0,'.',','); ?>  </strong></td>
       			
       			<td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity2_transferout,0,'.',','); ?>  </strong></td>


            <td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity2_sales,0,'.',',') ;  ?>  </strong></td>
               
			<td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity1_refunds,0,'.',','); ?>  </strong></td>

       			 <!-- <td align="left" valign="center"  
                 class="bodytext31"><strong> <?php //echo number_format($quantity1_purchase,0,'.',',') intval($balance);?> </strong></td> -->

                 <td align="right" valign="right"  
                 class="bodytext31"><strong> <?php echo number_format($quantity2_transferout_ownusage,0,'.',',');?> </strong></td>
                   <td align="right" valign="right"  
                 class="bodytext31"><strong> <?php echo number_format($quantity1_excess,0,'.',',');?> </strong></td>
                   <td align="right" valign="right"  
                 class="bodytext31"><strong> <?php echo number_format($quantity2_Short,0,'.',',');?> </strong></td>


                <td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($closingstock_on_date2,0,'.',','); ?>  </strong></td>
				 
			</tr>
				<?php
				   $openingbalance_on_date1_final        += $openingbalance_on_date1;
			$quantity1_purchase_final        +=$quantity1_purchase;
			$quantity1_preturn_final        +=$quantity1_preturn;
			$quantity1_receipts_final        +=$quantity1_receipts;
			$quantity2_transferout_final        +=$quantity2_transferout;
			$quantity2_sales_final        +=$quantity2_sales;
			$quantity1_refunds_final        +=$quantity1_refunds;
			$quantity2_transferout_ownusage_final        +=$quantity2_transferout_ownusage;
			$quantity1_excess_final        +=$quantity1_excess;
			$quantity2_Short_final        +=$quantity2_Short;
			$closingstock_on_date2_final  +=$closingstock_on_date2;

			} // if loop for all zeros has closed
			

			     
			// $openingbalance_on_date1=
			// $quantity1_purchase=
			// $quantity1_preturn=
			// $quantity1_receipts=
			// $quantity2_transferout=
			// $quantity2_sales=
			// $quantity1_refunds=
			// $quantity2_transferout_ownusage=
			// $quantity1_excess=
			// $quantity2_Short=
			// $closingstock_on_date2=
				}
}}
else if($_POST['mainsearch']=='3'){
?>

          	<tr>
             <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Sl. No</strong></td>     
				<td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Code</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Description</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Batch</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Expiry</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Opg.Stock</strong></div></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Purchase</strong></div></td>

                 <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Purchase Returns</strong></div></td>

                  <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Receipts</strong></div></td>

              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Issued To Dept</strong></div></td>

                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Sales</strong></div></td>


              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Refunds</strong></div></td>

                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Own Usage</strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Phy.Excess</strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Phy.Short</strong></div></td>

              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Closing Stock</strong></div></td>
				<!-- <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Username</strong></div></td> -->
				</tr>


<?php
$query_store = "SELECT * FROM `master_store`"; 
if($store!=''){ 
$query_store .= " where storecode='$store'  " ; 
	}
$exec_store = mysqli_query($GLOBALS["___mysqli_ston"], $query_store) or die ("Error in query_store".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res_store = mysqli_fetch_array($exec_store))
				{ 
					$store=$res_store['storecode'];
					 $storename=$res_store['store']; 
					?>
					<tr>
                <td bgcolor="#FF9900" colspan="16" class="bodytext3" align="left"><strong><?php echo $res_store['store']; ?></strong></td>
                </tr>
                <?php
				// $query991 = "select itemcode, categoryname, itemname from master_medicine where categoryname like '%$categoryname%' and itemcode like '%$searchmedicinecode%' and status <> 'deleted' group by categoryname order by categoryname, itemname";
				// $exec991 = mysql_query($query991) or die ("Error in Query991".mysql_error());
				// 				while ($res991 = mysql_fetch_array($exec991))
				// 				{
				// 					$categoryname2 = $res991['categoryname'];
				// 					$itemname = $res991['itemname'];
				?>
	            <!--  <tr>
       	        <td bgcolor="#FF9900" colspan="8" class="bodytext3" align="left"><strong><?php echo $categoryname2; ?></strong></td>
                </tr> -->
                <?php
				$sno = 0;
					$query99 = "SELECT b.itemcode, b.categoryname, b.itemname, a.batchnumber  from transaction_stock as a JOIN master_medicine as b on b.itemcode = a.itemcode where b.categoryname like '%$categoryname%' and b.itemcode like '%$searchmedicinecode%' group by a.itemcode,a.batchnumber order by b.itemname";
				// $query99 = "select itemcode, categoryname, itemname from master_medicine where categoryname = '$categoryname2' and itemcode like '%$searchmedicinecode%' and status <> 'deleted' order by itemname";
$exec99 = mysqli_query($GLOBALS["___mysqli_ston"], $query99) or die ("Error in Query99".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res99 = mysqli_fetch_array($exec99))
				{
					$categoryname2 = $res99['categoryname'];
					$medicinecode = $res99['itemcode'];
					$itemname = $res99['itemname'];
					$itemname = "<pre class='bodytext31'>".$res99['itemname']."</pre>";
					$batchnumber = $res99['batchnumber'];
					$expiry_date = '';

			 $query_inner = "select expirydate from purchase_details where batchnumber = '$batchnumber' and itemcode='$medicinecode' 
			 union all select expirydate from materialreceiptnote_details where batchnumber = '$batchnumber' and itemcode='$medicinecode' limit 0,1 ";
				$exec_inner = mysqli_query($GLOBALS["___mysqli_ston"], $query_inner) or die ("Error in Query_inner".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res_inner = mysqli_fetch_array($exec_inner))
				{
					$expiry_date = $res_inner['expirydate'];
				}

				?>
				
                <?php
				//get store for location
// 	$loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';
// $username=isset($_REQUEST['username'])?$_REQUEST['username']:'';
//   $query5ll = "select ms.auto_number,ms.storecode,ms.store from master_employeelocation as me LEFT JOIN master_store as ms ON me.storecode=ms.auto_number where me.locationcode = '".$loc."' AND me.username= '".$username."'";
// if($store!='')
// {
// 	$query5ll .=" and ms.storecode='".$store."' group by ms.storecode";
// 	}
// 				$exec5ll = mysql_query($query5ll) or die ("Error in Query5ll".mysql_error());
// 				while ($res5ll = mysql_fetch_array($exec5ll))
// 				{
			
// 				}
                
				
				?>
				 
                
                <?php
                ////////////////////FIRST //////////////////
                // echo $openingbalance_on_date; 
                // $ADate12 = date('Y-m-d', strtotime('-1 day', strtotime($ADate1)));
                   $query1a = "SELECT sum(transaction_quantity) as addstock from transaction_stock where batchnumber='$batchnumber' and itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date < '$ADate1' and transactionfunction='1'   ";
                 // echo $query1a = "SELECT sum(transaction_quantity) as addstock from transaction_stock where batchnumber='$batchnumber' and itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date between '$ADate1' and '$ADate2' and transactionfunction='1' order by auto_number desc  ";
				$exec1a = mysqli_query($GLOBALS["___mysqli_ston"], $query1a) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	 
				$res1a = mysqli_fetch_array($exec1a);
				 $totaladdstock = $res1a['addstock'];
				
				$query1m = "SELECT sum(transaction_quantity) as minusstock from transaction_stock where batchnumber='$batchnumber' and itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date < '$ADate1' and transactionfunction='0'   ";
				$exec1m = mysqli_query($GLOBALS["___mysqli_ston"], $query1m) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		 
				$res1m = mysqli_fetch_array($exec1m);
				 $totalminusstock = $res1m['minusstock'];
				
				 $openingbalance_on_date1 = $totaladdstock-$totalminusstock;
				// $balance_close_stock1 = $openingbalance;
				 ///////////////////////second//////////////////
				 $quantity1_purchase=0;  //PURCHASE
                   $query1_purchase = "SELECT transaction_quantity from transaction_stock where locationcode = '".$locationcode."' AND batchnumber='$batchnumber' and itemcode = '$medicinecode' and transactionfunction='1' and (description='Purchase' or description='OPENINGSTOCK' or description='".$storename."' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_purchase = mysqli_query($GLOBALS["___mysqli_ston"], $query1_purchase) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_purchase = mysqli_fetch_array($exec1_purchase))
				{
				
				  $quantity1_purchase += $res1_purchase['transaction_quantity'];

				} 
				//////////////////////THIRD /////////////////
				$quantity1_preturn=0;  //PURCHASE RETURN
                  $query1_pr = "SELECT transaction_quantity from transaction_stock where locationcode = '".$locationcode."' AND batchnumber='$batchnumber' and itemcode = '$medicinecode' and transactionfunction='0' and description='Purchase Return' and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_pr = mysqli_query($GLOBALS["___mysqli_ston"], $query1_pr) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_pr = mysqli_fetch_array($exec1_pr))
				{
				
				  $quantity1_preturn += $res1_pr['transaction_quantity'];

				} 
				/////////////////// FOURTH //////////////////
				$quantity2_transferout_ownusage=0;
				$quantity1_receipts=0; //	Receipts --> Transfer IN
				$quantity1_receipts_1=0;
				$quantity1_receipts_2=0;
				
                   $query1_receipts = "SELECT transaction_quantity,entrydocno, storecode from transaction_stock where locationcode = '".$locationcode."' AND batchnumber='$batchnumber' and itemcode = '$medicinecode' and transactionfunction='1' and description='Stock Transfer To'   and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_receipts = mysqli_query($GLOBALS["___mysqli_ston"], $query1_receipts) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_receipts = mysqli_fetch_array($exec1_receipts))
				{
				  // $quantity1_receipts += $res1_receipts['transaction_quantity'];

				  	$docno=$res1_receipts['entrydocno'];
					$storecode_fet=$res1_receipts['storecode'];

					 
                    $query1_receipts2 = "SELECT typetransfer from master_stock_transfer where `docno`='$docno'  and itemcode = '$medicinecode' limit 0,1";
					$exec_receipts2 = mysqli_query($GLOBALS["___mysqli_ston"], $query1_receipts2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
					$res_receipts2 = mysqli_fetch_array($exec_receipts2);
					
						$typetransfer=$res_receipts2['typetransfer'];
						if($typetransfer=='Transfer'){
					  			$quantity1_receipts += $res1_receipts['transaction_quantity'];
					  		}else{
					  			$quantity2_transferout_ownusage += $res1_receipts['transaction_quantity'];
					  		}
				  	
				  	// $quantity1_receipts_1 = $quantity1_receipts+$quantity1_receipts1;
				  	// $quantity2_transferout_ownusage += $quantity2_transferout_ownusage1;
				} 
				//  $query1_receipts_2 = "SELECT transaction_quantity,entrydocno, storecode from transaction_stock where locationcode = '".$locationcode."' AND batchnumber='$batchnumber' and itemcode = '$medicinecode' and transactionfunction='1' and  description='Stock Adj Add Stock'  and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				// $exec1_receipts_2 = mysql_query($query1_receipts_2) or die(mysql_error());			
				// while($res1_receipts_2 = mysql_fetch_array($exec1_receipts_2))
				// {
				// 	  			$quantity1_receipts_2 += $res1_receipts_2['transaction_quantity'];
				// } 
				// $quantity1_receipts=$quantity1_receipts_1+$quantity1_receipts_2;

				//////////////// fifth ///////////////////////////////////
				 $quantity2_transferout=0;  //Transfer out
				 $quantity2_transferout_1=0;   
				 $quantity2_transferout_2=0;   
				 
                    $query12_transferout = "SELECT transaction_quantity,storecode, entrydocno from transaction_stock where locationcode = '".$locationcode."' AND batchnumber='$batchnumber' and itemcode = '$medicinecode' and transactionfunction='0' and description='Stock Transfer From'  and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec12_transferout = mysqli_query($GLOBALS["___mysqli_ston"], $query12_transferout) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res12_transferout = mysqli_fetch_array($exec12_transferout))
				{

					$docno=$res12_transferout['entrydocno'];
					$storecode_fet=$res12_transferout['storecode'];

					 
                    $query12_transferout2 = "SELECT typetransfer from master_stock_transfer where `docno`='$docno' and locationcode = '".$locationcode."'and itemcode = '$medicinecode'  and fromstore = '$storecode_fet'";
					$exec12_transferout2 = mysqli_query($GLOBALS["___mysqli_ston"], $query12_transferout2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
					$res12_transferout2 = mysqli_fetch_array($exec12_transferout2);
					
						$typetransfer=$res12_transferout2['typetransfer'];
						if($typetransfer=='Transfer'){
					  			$quantity2_transferout += $res12_transferout['transaction_quantity'];
					  		}else{
					  			$quantity2_transferout_ownusage += $res12_transferout['transaction_quantity'];
					  		}
				  	

				} 

				//  $query12_transferout = "SELECT transaction_quantity,storecode, entrydocno from transaction_stock where locationcode = '".$locationcode."' AND batchnumber='$batchnumber' and itemcode = '$medicinecode' and transactionfunction='0' and (description='Stock Damaged Minus Stock' or description='Stock Expired Minus Stock' or description='Stock Adj Minus Stock' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				// $exec12_transferout = mysql_query($query12_transferout) or die(mysql_error());			
				// while($res12_transferout = mysql_fetch_array($exec12_transferout))
				// {
				// 	$quantity2_transferout_2 += $res12_transferout['transaction_quantity'];
				// } 
				// $quantity2_transferout=$quantity2_transferout_1+$quantity2_transferout_2;

				////////////////////////// SIXTH ///////////////
				$quantity2_sales=0;   // Sales
                    $query12_sales = "SELECT transaction_quantity from transaction_stock where locationcode = '".$locationcode."' AND batchnumber='$batchnumber' and itemcode = '$medicinecode' and transactionfunction='0' and (description='Sales' or description='Package' or description='IP Direct Sales' or description='IP Sales' or description='Process' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec12_sales = mysqli_query($GLOBALS["___mysqli_ston"], $query12_sales) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res12_sales = mysqli_fetch_array($exec12_sales))
				{
				
				  $quantity2_sales += $res12_sales['transaction_quantity'];

				} 
				////////////////// SEVENTH ///////////////////////////
				$quantity1_refunds=0;   // Refunds
                  $query1_refunds = "SELECT transaction_quantity from transaction_stock where locationcode = '".$locationcode."' AND batchnumber='$batchnumber' and itemcode = '$medicinecode' and transactionfunction='1' and (description='Sales Return' or description='IP Sales Return' or description='Sales Return' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_refunds = mysqli_query($GLOBALS["___mysqli_ston"], $query1_refunds) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_refunds = mysqli_fetch_array($exec1_refunds))
				{
				
				  $quantity1_refunds += $res1_refunds['transaction_quantity'];

				} 
				/////////////////////////// eight CLOSING STOCK ///////////////////

				$query1a_closingstock = "SELECT sum(transaction_quantity) as addstock from transaction_stock where batchnumber='$batchnumber' and itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date <= '$ADate2' and transactionfunction='1' order by auto_number desc  ";
                 // echo $query1a = "SELECT sum(transaction_quantity) as addstock from transaction_stock where batchnumber='$batchnumber' and itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date between '$ADate1' and '$ADate2' and transactionfunction='1' order by auto_number desc  ";
				$exec1a_closingstock = mysqli_query($GLOBALS["___mysqli_ston"], $query1a_closingstock) or die(mysqli_error($GLOBALS["___mysqli_ston"]));	 
				$res1a_closingstock = mysqli_fetch_array($exec1a_closingstock);
				 $totaladdstock_closingstock = $res1a_closingstock['addstock'];
				
				$query1m_closingstock = "SELECT sum(transaction_quantity) as minusstock from transaction_stock where batchnumber='$batchnumber' and itemcode='$medicinecode' and locationcode='$location' and storecode ='$store' and transaction_date <= '$ADate2' and transactionfunction='0' order by auto_number desc  ";
				$exec1m_closingstock = mysqli_query($GLOBALS["___mysqli_ston"], $query1m_closingstock) or die(mysqli_error($GLOBALS["___mysqli_ston"]));		 
				$res1m_closingstock = mysqli_fetch_array($exec1m_closingstock);
				 $totalminusstock_closingstock = $res1m_closingstock['minusstock'];
				
				 $closingstock_on_date2 = $totaladdstock_closingstock-$totalminusstock_closingstock;

				 ///////////////////////////phy excess///////////////////////////
				 $quantity1_excess=0;
				 $query1_excess = "SELECT transaction_quantity,entrydocno, storecode from transaction_stock where locationcode = '".$locationcode."' AND batchnumber='$batchnumber' and itemcode = '$medicinecode' AND  transactionfunction='1' and  description='Stock Adj Add Stock'  and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1_excess = mysqli_query($GLOBALS["___mysqli_ston"], $query1_excess) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res1_excess = mysqli_fetch_array($exec1_excess))
				{
					  			$quantity1_excess += $res1_excess['transaction_quantity'];
				} 
				 /////////////////////  Phy.Short /////////
				 $quantity2_Short=0;
				 $query12_Short = "SELECT transaction_quantity,storecode, entrydocno from transaction_stock where locationcode = '".$locationcode."' AND batchnumber='$batchnumber' and itemcode = '$medicinecode' AND  transactionfunction='0' and (description='Stock Damaged Minus Stock' or description='Stock Expired Minus Stock' or description='Stock Adj Minus Stock' ) and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec12_Short = mysqli_query($GLOBALS["___mysqli_ston"], $query12_Short) or die(mysqli_error($GLOBALS["___mysqli_ston"]));			
				while($res12_Short = mysqli_fetch_array($exec12_Short))
				{
					$quantity2_Short += $res12_Short['transaction_quantity'];
				} 
				//////////////////////////////////////////////////////

				if($openingbalance_on_date1==0 && $quantity1_purchase==0 && $quantity1_preturn==0 && $quantity1_receipts==0 && $quantity2_transferout==0 && $quantity2_sales==0 && $quantity1_refunds==0 && $closingstock_on_date2==0 && $quantity2_transferout_ownusage==0 && $quantity1_excess==0 && $quantity2_Short==0){

				}else{

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
				} ?>
				 <tr <?php echo $colorcode; ?>>
				 	<td class="bodytext31" valign="center"  align="center"><?php echo $snocount; ?></td>
				 	<td class="bodytext31" valign="center"  align="center"><strong><?php echo $medicinecode; ?></strong></td>
					<td class="bodytext31" valign="center"  align="left" ><strong><?=$itemname;?></strong></td>
				
					<td class="bodytext31" valign="center"  align="left" ><strong><?=$batchnumber;?></strong></td>
				
					<td class="bodytext31" valign="center"  align="left" width="10px" ><strong><?=$expiry_date;?></strong></td>
				
            
            		  <td align="right" valign="right"  
                 class="bodytext31"><div align="right"><strong><?php echo number_format($openingbalance_on_date1,0,'.',',');?></strong></div></td>

				<td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity1_purchase,0,'.',','); ?>  </strong></td>

                 <td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity1_preturn,0,'.',','); ?>  </strong></td>
				
				<td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity1_receipts,0,'.',','); ?>  </strong></td>
       			
       			<td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity2_transferout,0,'.',','); ?>  </strong></td>


            <td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity2_sales,0,'.',',') ;  ?>  </strong></td>
               
			<td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($quantity1_refunds,0,'.',','); ?>  </strong></td>

       			 <!-- <td align="left" valign="center"  
                 class="bodytext31"><strong> <?php //echo number_format($quantity1_purchase,0,'.',',') intval($balance);?> </strong></td> -->

                 <td align="right" valign="right"  
                 class="bodytext31"><strong> <?php echo number_format($quantity2_transferout_ownusage,0,'.',',');?> </strong></td>
                   <td align="right" valign="right"  
                 class="bodytext31"><strong> <?php echo number_format($quantity1_excess,0,'.',',');?> </strong></td>
                   <td align="right" valign="right"  
                 class="bodytext31"><strong> <?php echo number_format($quantity2_Short,0,'.',',');?> </strong></td>


                <td align="right" valign="right"  
                 class="bodytext31"><strong><?php echo number_format($closingstock_on_date2,0,'.',','); ?>  </strong></td>
				 
			</tr>
				<?php
				   $openingbalance_on_date1_final        += $openingbalance_on_date1;
			$quantity1_purchase_final        +=$quantity1_purchase;
			$quantity1_preturn_final        +=$quantity1_preturn;
			$quantity1_receipts_final        +=$quantity1_receipts;
			$quantity2_transferout_final        +=$quantity2_transferout;
			$quantity2_sales_final        +=$quantity2_sales;
			$quantity1_refunds_final        +=$quantity1_refunds;
			$quantity2_transferout_ownusage_final        +=$quantity2_transferout_ownusage;
			$quantity1_excess_final        +=$quantity1_excess;
			$quantity2_Short_final        +=$quantity2_Short;
			$closingstock_on_date2_final  +=$closingstock_on_date2;

			} // if loop for all zeros has closed
			

			     
			// $openingbalance_on_date1=
			// $quantity1_purchase=
			// $quantity1_preturn=
			// $quantity1_receipts=
			// $quantity2_transferout=
			// $quantity2_sales=
			// $quantity1_refunds=
			// $quantity2_transferout_ownusage=
			// $quantity1_excess=
			// $quantity2_Short=
			// $closingstock_on_date2=
				}
				// } // FIRST WHILE LOOP AFTER ELSE

				} // fetch_store close
			} // main if loop
}// main else for the main search ended				
				?>
				

		  </tbody>
		   <tfoot style="background-color: #FF9900;" >

		  		<td class="bodytext31" valign="center"  align="center"><?php echo ""; ?></td>
				<td class="bodytext31" valign="center"  align="left" ><strong><?="Total";?></strong></td>
				<?php if(isset($_POST['mainsearch']) && $_POST['mainsearch']=='3'){
				?>
		  			<td class="bodytext31" valign="center"  align="center"><?php echo ""; ?></td>
		  			<td class="bodytext31" valign="center"  align="center"><?php echo ""; ?></td>
		  			<td class="bodytext31" valign="center"  align="center"><?php echo ""; ?></td>
				<?php 
				}
				?>



				<td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($openingbalance_on_date1_final,0,'.',',');?></strong></td>
				<td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($quantity1_purchase_final,0,'.',',');?></strong></td>
				<td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($quantity1_preturn_final,0,'.',',');?></strong></td>
				<td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($quantity1_receipts_final,0,'.',',');?></strong></td>
				<td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($quantity2_transferout_final,0,'.',',');?></strong></td>
				<td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($quantity2_sales_final,0,'.',',');?></strong></td>
				<td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($quantity1_refunds_final,0,'.',',');?></strong></td>
				<td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($quantity2_transferout_ownusage_final,0,'.',',');?></strong></td>
				<td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($quantity1_excess_final,0,'.',',');?></strong></td>
				<td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($quantity2_Short_final,0,'.',',');?></strong></td>
				<td class="bodytext31" valign="center"  align="right" ><strong><?=number_format($closingstock_on_date2_final,0,'.',',');?></strong></td>
		  </tfoot>
		  </table>
          <?php
          if ($frmflag1 == 'frmflag1')
		  { ?>
          <a target="_blank" href="xl_fullstockmovement.php?mainsearch=<?=$mainsearch;?>&&frmflag1=<?=$frmflag1;?>&&searchitemcode=<?=$searchmedicinecode;?>&&categoryname=<?= $categoryname;?>&&location=<?= $loc;?>&&store=<?= $store_search;?>&&ADate1=<?= $ADate1;?>&&ADate2=<?=$ADate2;?>"> <img src="images/excel-xls-icon.png" width="30" height="30"></a>
          <?php } ?>
          </td>
		  
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

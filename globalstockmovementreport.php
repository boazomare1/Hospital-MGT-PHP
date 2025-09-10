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
//To populate the autocompetelist_services1.js
$transactiondatefrom = date('Y-m-d', strtotime('-1 week'));
$transactiondateto = date('Y-m-d');
if (isset($_REQUEST["medicinecode"])) { $medicinecode = $_REQUEST["medicinecode"]; } else { $medicinecode = ""; }
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{
if (isset($_REQUEST["searchitemcode"])) { $medicinecode = $_REQUEST["searchitemcode"]; } else { $medicinecode = ""; }
//$medicinecode = $_REQUEST['medicinecode'];
if (isset($_REQUEST["itemname"])) { $searchmedicinename = $_REQUEST["itemname"]; } else { $searchmedicinename = ""; }
if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
if (isset($_REQUEST["store"])) { $storecode = $_REQUEST["store"]; } else { $storecode = ""; }
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
if (isset($_REQUEST["ADate1"])) { $AbDate1 = $_REQUEST["ADate1"]; } else { $AbDate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $AbDate2 = $_REQUEST["ADate2"]; } else { $AbDate2 = ""; }
}
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	 $res12locationanum = $res["auto_number"];
	 
  $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
?>
<style type="text/css">
th {
            background-color: #ffffff;
            position: sticky;
            top: 0;
            z-index: 1;
        }
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
if(document.getElementById("itemname").value == '')
{
alert("Please Enter Itemname");
document.getElementById("itemname").focus();
return false;
}
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
		
		
			<form name="stockinward" action="globalstockmovementreport.php" method="post" onKeyDown="return disableEnterKey()" onSubmit="return Locationcheck()">
	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
      <tbody id="foo">
        <tr>
          <td colspan="6" bgcolor="#ecf0f5" class="bodytext31"><strong>Global Stock Movement Report</strong></td>
          </tr>
        <tr>
          <td colspan="6" align="left" valign="center"  
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
              <td  bgcolor="#FFFFFF" class="bodytext3"  colspan="5" ><select name="location" id="location" style="border: 1px solid #001E6A;" onChange="storefunction(this.value)">
              <option value="">-Select Location-</option>
                  <?php
						
						$query = "select * from master_employeelocation where username='$username' group by locationcode order by locationname";
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
          <td width="680" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31" colspan="5" >
		 <?php 
			$loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';
			$username=isset($_REQUEST['username'])?$_REQUEST['username']:'';
			$frmflag1=isset($_REQUEST['frmflag1'])?$_REQUEST['frmflag1']:'';
			$store=isset($_REQUEST['store'])?$_REQUEST['store']:'';?>  
			<select name="store" id="store">
			<option value="">-Select Store-</option>
			<?php if ($frmflag1 == 'frmflag1')
			{$loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';
			$username=isset($_REQUEST['username'])?$_REQUEST['username']:'';
			$query5 = "select ms.auto_number,ms.storecode,ms.store from master_employeelocation as me LEFT JOIN master_store as ms ON me.storecode=ms.auto_number where me.locationcode = '".$loc."' AND me.username= '".$username."'";
			$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res5 = mysqli_fetch_array($exec5))
			{
			$res5anum = $res5["storecode"];
			$res5name = $res5["store"];
			//$res5department = $res5["department"];
		?>
			<option value="<?php echo $res5anum;?>" <?php if($store==$res5anum){echo 'selected';}?>><?php echo $res5name;?></option>
			<?php }}?>
		  </select>
		  </td>
		  </tr>
        <tr>
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
			$categoryname = $res42['categoryname'];
			?>
            <option value="<?php echo $categoryname; ?>"><?php echo $categoryname; ?></option>
            <?php
			}
			?>
          </select></td>
        </tr>
        <tr>
          <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Search</strong></td>
          <td colspan="5" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
		  <input type="hidden" name="searchitem1hiddentextbox" id="searchitem1hiddentextbox">
		  <input type="hidden" name="searchitemcode" id="searchitemcode" value="<?php echo $medicinecode; ?>">
		  <input name="itemname" type="text" id="itemname" style="border: 1px solid #001E6A; text-align:left" size="50" autocomplete="off" value="<?php echo $searchmedicinename; ?>">
           </td>
        </tr>
        
        <tr>
          <td width="76" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="123" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="51" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td colspan="2" width="129" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
		  </tr>
        <tr>
          <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><input type="hidden" name="medicinecode" id="medicinecode" style="border: 1px solid #001E6A; text-align:left" onKeyDown="return disableEnterKey()" value="<?php echo $medicinecode; ?>" size="10" readonly /></td>
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
          <td colspan="5" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Date Range : <?php echo $transactiondatefrom.' To '.$transactiondateto; ?></strong></td>
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
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="70%"align="left" border="0">
          <tbody>
			<tr>

			<th align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Description</strong></th>
			<th align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Batch</strong></th>
			<th align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Opg.Stock</strong></div></th>
			<th align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Receipts</strong></div></th>
			<th align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Issues</strong></div></th>
			<th align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Returns</strong></div></th>
			<th align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Closing Stock</strong></div></th>
			</tr>
				<?php
				if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
				//$frmflag1 = $_REQUEST['frmflag1'];
				if ($frmflag1 == 'frmflag1')
				{
				if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }
				if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
				?>
				<?php
				if($searchmedicinename != '')
				{
				$noofdays=strtotime($ADate2) - strtotime($ADate1);
				$noofdays = $noofdays/(3600*24);
				//get store for location
				$loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';
				$username=isset($_REQUEST['username'])?$_REQUEST['username']:'';
				$query5ll = "select ms.auto_number,ms.storecode,ms.store from master_employeelocation as me LEFT JOIN master_store as ms ON me.storecode=ms.auto_number where me.locationcode = '".$loc."' AND me.username= '".$username."'";
				if($store!='')
				{
				$query5ll .=" and ms.storecode='".$store."'";
				}
				$exec5ll = mysqli_query($GLOBALS["___mysqli_ston"], $query5ll) or die ("Error in Query5ll".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res5ll = mysqli_fetch_array($exec5ll))
				{
				$store = $res5ll["storecode"];
				$res5name = $res5ll["store"];
				?>
				<tr bgcolor="#ecf0f5">
				<td colspan="7" class="bodytext31" style="font-size:18px;"><strong><?php echo $res5name;?></strong></td>
				</tr>
				<?php
				//$res5department = $res5["department"];
				$ADate1=$AbDate1;
				for($i=0;$i<=$noofdays;$i++)
				{
					if($i!=0)
					{
					$ADate1=date('Y-m-d',strtotime($ADate1) + (1*3600*24));
					 $ADate2=$ADate1;
					}
					else
					{
				
					 $ADate2=$ADate1;
					}
					?>
				<tr bgcolor="#ecf0f5">
				<td colspan="7" class="bodytext31"><?php echo $ADate1;?></td>
				</tr>
				<?php
				include("openingbalancecalculation.php");
				$balance = $openingbalance;
				//echo $openingbalance;
				?>
			<tr>
			  <td align="left" valign="center" colspan="7" class="bodytext31"><strong><?php echo $searchmedicinename; ?></strong></td>
			</tr>
			<tr>
			<td class="bodytext31" width="19%" valign="center"  align="left" bgcolor="#ecf0f5"><strong>Opening Balance</strong></td>
			<td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong>&nbsp;</strong></div></td>
			<td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><div align="left"><strong><?php echo $openingbalance; ?></strong></div></td>
			<td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>  </strong></td>
			<td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>  </strong></td>
			<td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong>  </strong></td>
			<td align="left" valign="center"  bgcolor="#ecf0f5" class="bodytext31"><strong> <?php echo $balance; ?> </strong></td>
			</tr>
			<?php
			//echo $balance;
				
			if($store == 'all')
			{
				$query1 = "select entrydocno,transaction_date,transaction_quantity,batchnumber,username,description,patientname,patientvisitcode,transactionfunction,auto_number from transaction_stock where locationcode = '".$locationcode."' AND itemcode like '%$medicinecode%' and transaction_date between '$ADate1' and '$ADate2'";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				$num1 = mysqli_num_rows($exec1);
				}
				else
				{				
				$query1 = "select entrydocno,transaction_date,transaction_quantity,batchnumber,username,description,patientname,patientvisitcode,transactionfunction,auto_number from transaction_stock where locationcode = '".$locationcode."' AND itemcode = '$medicinecode' and transaction_date between '$ADate1' and '$ADate2' and storecode = '$store'";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				}				
				while($res1 = mysqli_fetch_array($exec1))
				{
				$billnumber = $res1['entrydocno'];
				$suppliername = '';
				$billdate = $res1['transaction_date'];
				$quantity = $res1['transaction_quantity'];
				$purchaseopeningstock = 0;
				$purchaseissues = 0;
				$purchasereturns = 0;
				$batch = $res1['batchnumber'];	
				$user = $res1['username'];
				
				
				$description = $res1['description'];
				$patientname = $res1['patientname'];
				$patientvisitcode = $res1['patientvisitcode'];
				$transactionfunction = $res1['transactionfunction'];
				if($description=="" && $transactionfunction=='1' && substr($billnumber,0,3)=="ADJ"){
					$description='Stock Adj Add Stock';
				}else if($description=="" && $transactionfunction=='0' && substr($billnumber,0,3)=="ADJ"){
					$description="Stock Adj Minus Stock";
				}
				if($transactionfunction=='1')
				{
					$purchaseissues = $quantity;
					$purchasereturns = 0;
					$openingbalance = $openingbalance + $quantity;
					$purchasequantity = $openingbalance;
				}
				else
				{
					$purchaseissues = 0;
					$purchasereturns = $quantity;
					$openingbalance = $openingbalance - $quantity;
					$purchasequantity = $openingbalance;
				}
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
             
              <td align="left" valign="center"  
                class="bodytext31"><strong>
                <?php
				if($description=='Purchase'||$description=='OPENINGSTOCK')
				{ 
					$query8 = "select suppliername from master_purchase where billnumber = '$billnumber'";
					$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res8 = mysqli_fetch_array($exec8);
					$suppliername = $res8['suppliername'];
					echo  'By Purchase ('.$billnumber.','.$suppliername.' , '.$billdate.','.$user.')';
					$purchaseissues='0';                
				}
				if($description=='Purchase Return')
				{ 
					$query8 = "select suppliername from purchasereturn_details where billnumber = '$billnumber'";
					$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res8 = mysqli_fetch_array($exec8);
					$suppliername = $res8['suppliername'];
					echo  'By Purchase Return ('.$billnumber.','.$suppliername.' , '.$billdate.','.$user.')';
					$quantity='0';                
				}
				else if($description=='Package'||$description=='Sales'||$description=='IP Direct Sales'||$description=='IP Sales')
				{
					echo  'By Issue ('.$patientname.' ,'.$patientvisitcode.' ,'.$billnumber.' ,'.$billdate.' ,'.$user.' )'; 
					$purchaseissues=$purchasereturns;
					$purchasereturns='0';
					$quantity='0';     
				}
				else if($description=='IP Sales Return'||$description=='Sales Return')
				{
					echo  'By Return ('.$patientname.' ,'.$patientvisitcode.' ,'.$billnumber.' ,'.$billdate.' ,'.$user.' )';
					$purchasereturns=$purchaseissues;
					$purchaseissues='0';
					$quantity='0';      
				}
				else if($description=='Process')
				{
					echo  'By Process ('.$patientname.' ,'.$patientvisitcode.' ,'.$billnumber.' ,'.$billdate.' ,'.$user.' )';
					$purchaseissues=$purchasereturns;
					$purchasereturns='0';
					$quantity='0';     
				}
				else if($description=='Stock Damaged Minus Stock')
				{
					echo  'By Adjust -  Damaged ('.$billnumber.' ,'.$billdate.' ,'.$user.' )';   
					$quantity='0';
					$purchaseissues = $purchasereturns;  
					$purchasereturns='0';    
				}
				else if($description=='Stock Adj Minus Stock')
				{
					echo  'By Adjust - Stk Adj Minus ('.$billnumber.' ,'.$billdate.' ,'.$user.' )';   
					$quantity='0';
					$purchaseissues = $purchasereturns;  
					$purchasereturns='0'; 
				}
				else if($description=='Stock Adj Add Stock')
				{
					echo  'By Adjust - Stk Adj Add ('.$billnumber.' ,'.$billdate.' ,'.$user.' )';
					$quantity=$purchaseissues;
					$purchaseissues='0';   
				}
				else if($description=='Stock Expired Minus Stock')
				{
					echo  'By Adjust - Expired ('.$billnumber.' ,'.$billdate.' ,'.$user.' )';   
					$quantity='0';  
					$purchaseissues = $purchasereturns;  
					$purchasereturns='0';  
				}
				else if($description=='Stock Transfer From'||$description=='Stock Transfer To')
				{
					
					$query8 = "select typetransfer,fromstore,tostore,tolocationname,locationname from master_stock_transfer where docno = '$billnumber'";
					$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res8 = mysqli_fetch_array($exec8);
					$fromstore = $res8['fromstore'];
					$tostore = $res8['tostore'];
					$tolocationname = $res8['tolocationname'];
					$locationname = $res8['locationname'];					
					$typetransfer = $res8['typetransfer'];
					$query8 = "select store from master_store where storecode = '$fromstore'";
					$exec8 = mysqli_query($GLOBALS["___mysqli_ston"], $query8) or die ("Error in Query8".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res8 = mysqli_fetch_array($exec8);
					$fromstorename = $res8['store'];					
					$query9 = "select store from master_store where storecode = '$tostore'";
					$exec9 = mysqli_query($GLOBALS["___mysqli_ston"], $query9) or die ("Error in Query9".mysqli_error($GLOBALS["___mysqli_ston"]));
					$res9 = mysqli_fetch_array($exec9);
					$tostorename = $res9['store'];
					if($typetransfer=="Consumable" || $tostorename==''){						
						$query2a = "select accountname,accountsmain,id from master_accountname where id='$tostore'";
						$exec2a = mysqli_query($GLOBALS["___mysqli_ston"], $query2a) or die ("Error in Query2a".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res2a = mysqli_fetch_array($exec2a);
							$tostorename = $res2a["accountname"];
					}
					
					if($description=='Stock Transfer From')
					{  
						echo  'By Transfer ('.$fromstorename.' to '.$tostorename.' , '.$billnumber.' ,'.$billdate.' ,'.$user.' )';   
						$purchaseissues=$quantity;
						$purchasereturns='0';
						$quantity='0';
					}
					else
					{
						echo  'By Transfer ('.$fromstorename.' to '.$tostorename.' , '.$billnumber.' ,'.$billdate.' ,'.$user.' )';   
						$purchaseissues=0;
						$purchasereturns='0';
					}
					
				}
				//echo $description;
				?>
                </strong></td>
                <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><strong><?php echo $batch; ?></strong></div></td>
					           <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><strong><?php echo $purchaseopeningstock; ?></strong></div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div align="left"><strong><?php echo intval($quantity); ?></strong></div></td>
              <td align="left" valign="center"  
                class="bodytext31"><div align="left"><strong><?php echo $purchaseissues; ?></strong></div></td>
              <td align="left" valign="center"  
                class="bodytext31"><div align="left"><strong><?php echo $purchasereturns; ?></strong></div></td>
              <td align="left" valign="center"  
                class="bodytext31"><div align="left"><strong><?php echo intval($purchasequantity); ?></strong></div></td>
				</tr>
				<?php
				}
				?>
							<?php
				$balance = $openingbalance;
			
				}
				}
				}
				}
				?>
					<tr>
					<td width="75"  align="left" valign="center" bgcolor="" class="bodytext31">
              <a href="pdf_globalstockmovementreport.php?frmflag1=frmflag1&&ADate1=<?= $AbDate1 ?>&&ADate2=<?= $AbDate2 ?>&&medicinecode=<?php echo $medicinecode; ?>&&searchitemcode=<?php echo $medicinecode; ?>&&itemname=<?php echo $searchmedicinename; ?>&&categoryname=<?php echo $categoryname; ?>&&store=<?php echo $storecode; ?>&&location=<?php echo $location; ?>" target="_blank"><img src="images/pdfdownload.jpg" width="30" height="30"></a>
			  
              </td> 
			  	</tr>
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
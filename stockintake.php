<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	 $res12locationanum = $res["auto_number"];
	 
  $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
  
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if ($cbfrmflag1 == 'cbfrmflag1')
{
 $billnumber=$_REQUEST['docnumber']; 
 $location=$_REQUEST['location']; 
   $receivedfrom=$_REQUEST['recivedfrom']; 
$serial = $_REQUEST['serialnumber'];
 $store = $_REQUEST['store'];
$number = $serial - 1;

/*$query231 = "select * from master_employee where username='$username'";
$exec231 = mysql_query($query231) or die(mysql_error());
$res231 = mysql_fetch_array($exec231);
$res7locationanum1 = $res231['location'];*/

$query551 = "select * from master_location where locationcode='$location'";
$exec551 = mysqli_query($GLOBALS["___mysqli_ston"], $query551) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res551 = mysqli_fetch_array($exec551);
$locationname = $res551['locationname'];

//$res7storeanum1 = $res231['store'];

$query751 = "select * from master_store where storecode='$store'";
$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res751 = mysqli_fetch_array($exec751);
 $store1 = $res751['store']; 

for ($p=1;$p<=$number;$p++)
		{
				   
		$bloodgroup=$_REQUEST['bloodgroup'.$p];
		$bloodgroup=trim($bloodgroup);
		
		
		
		 $quantity=$_REQUEST['quantity'.$p]; 
		
	    $batchnumber=$_REQUEST['batchnumber'.$p]; 
		
		$expirydate=$_REQUEST['expirydate'.$p];
		
		$locationcode=$_REQUEST['locationcode'.$p];
		$storecode=$_REQUEST['storecode'.$p];
		
		$expirymonth = substr($expirydate, 0, 2);
			$expiryyear = substr($expirydate, 3, 2);
			$expiryday = '01';
			$expirydate = $expiryyear.'-'.$expirymonth.'-'.$expiryday;
		
		$itemsubtotal=$salesrate * $quantity;
		
		
		if($bloodgroup!="" && $batchnumber!="")
		{
		
	 $medicinequery2="insert into bloodstock (bloodgroup, transactiondate,transactionmodule,transactionparticular,
	 docno, quantity, 
	 username, ipaddress, companyanum, companyname,batchnumber,expirydate,store,storecode,location,locationcode,locationname,receivedfrom)
	values ('$bloodgroup', '$updatedatetime', 'OPENINGSTOCK', 
	'BY STOCK ADD', '$billnumber', '$quantity', 
	'$username', '$ipaddress','$companyanum', '$companyname','$batchnumber','$expirydate','$store','".$store."','$locationcode','$locationcode','$locationname','$receivedfrom')";  
	
	$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}
		}
		header("location:mainmenu1.php");
		exit;
}

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'ST-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from bloodstock order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='ST-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'ST-'.$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
<script>


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



function validcheck()
{
	if(confirm("Are You Want To Save The Record?")==false){return false;}	
}

function funcOnLoadBodyFunctionCall()
{


	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	 //To handle ajax dropdown list.
	//funcCustomerDropDownSearch4();
	//funcPopupPrintFunctionCall();
	
}
function btnDeleteClick10(delID)
{
	//alert ("Inside btnDeleteClick.");
	
	//alert(pharmamount);
	var varDeleteID = delID;
	//alert (varDeleteID);
	var fRet3; 
	fRet3 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet3 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child = document.getElementById('idTR'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	document.getElementById ('insertrow').removeChild(child);
	
	var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	//alert (child);
	if (child != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow').removeChild(child);
		
		
	}
	

}
</script>
<script>
function Formcheck()
{
if(document.cbform1.location.value=="")
	{
		alert("Please select location name");
		document.cbform1.location.focus();
		return false;
	}
	if(document.cbform1.store.value=="")
	{
		alert("Please select store");
		document.cbform1.store.focus();
		return false;
	}
	if(document.getElementById("recivedfrom").value=='')
		{
		alert('Please enter recivedfrom!');
		document.getElementById("recivedfrom").focus();
		return false;
		}
	return true;
	
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
	
	function functioncheklocationandstock()
	{
		if(document.getElementById("location").value=='')
		{
		alert('Please Select Location!');
		document.getElementById("location").focus();
		return false;
		}
		if(document.getElementById("store").value=='')
		{
		alert('Please Select Store!');
		document.getElementById("store").focus();
		return false;
		}
		
	}
</script>
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
<?php /*?><?php include("autocompletebuild_stockmedicine.php"); ?>
<script type="text/javascript" src="js/autosuggeststockmedicine1.js"></script>
<?php include("js/dropdownlist1scriptingstockmedicine.php"); ?><?php */?>
<!--<script type="text/javascript" src="js/autocomplete_stockmedicine.js"></script>-->
<script type="text/javascript" src="js/insertnewitemstocktaking_blood.js"></script>
<!--<script type="text/javascript" src="js/autocomplete_batchnumberippharmacyissue.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        -->
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

<body onLoad="return funcOnLoadBodyFunctionCall();">
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
		
		
              <form name="cbform1" method="post" action="stockintake.php" onSubmit="return validcheck()">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="1" bgcolor="#ecf0f5" class="bodytext3"><strong> Stock Intake </strong></td>
               <td colspan="6" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
						
						if ($location!='')
						{
						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res12 = mysqli_fetch_array($exec12);
						
						echo $res1location = $res12["locationname"];
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
          	 <tr>
              <td align="left" valign="middle"   class="bodytext3"><strong>Location</strong></td>
              <td   class="bodytext3"  colspan="3" ><select name="location" id="location" style="border: 1px solid #001E6A;" onChange="storefunction(this.value); ajaxlocationfunction(this.value);">
             <option value="" >Select Location</option>
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
                  <td align="left" valign="top"><span class="bodytext3"></span></td>
                  <td align="left" valign="top"><span class="bodytext3"></span></td>
                  <td width="13" align="left" valign="top"><span class="bodytext3"></span></td>
                  <td width="147" align="left" valign="top"><span class="bodytext3"></span></td>
                   
                  <input type="hidden" name="locationnamenew" value="<?php echo $locationname; ?>">
                <input type="hidden" name="locationcodenew" value="<?php echo $res1locationanum; ?>">
                <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
             
              </tr>
		<tr>
		  <td width="77" align="left" valign="center" class="bodytext31"><strong>Store</strong> </td>
          <td width="202" align="left" valign="center"  class="bodytext31">
		  <?php  $loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';
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
          <td align="left" valign="top"><span class="bodytext3"></span></td>
          <td align="left" valign="top"><span class="bodytext3"></span></td>
          <td align="left" valign="top"><span class="bodytext3"></span></td>
          <td align="left" valign="top"><span class="bodytext3"></span></td>
          <td align="left" valign="top"><span class="bodytext3"></span></td>
		  </tr>
            <tr>
              <td align="left" valign="middle"  class="bodytext3">Date</td>
              <td align="left" valign="top"><span class="bodytext3">
                <input name="date" type="text" id="date" style="border: 1px solid #001E6A;" value="<?php echo $updatedatetime; ?>" size="8" autocomplete="off">
              </span></td>
			    <td width="37" align="left" valign="middle"  class="bodytext3">Doc NO</td>
              <td width="66" align="left" valign="top"><span class="bodytext3">
                <input name="docnumber" type="text" id="docnumber" style="border: 1px solid #001E6A;" value="<?php echo $billnumbercode; ?>" size="8" autocomplete="off">
              </span></td>
              
               <td width="53" align="left" valign="middle"  class="bodytext3">Recived From</td>
              <td width="141" align="left" valign="top"><span class="bodytext3">
                <input name="recivedfrom" type="text" id="recivedfrom" style="border: 1px solid #001E6A;" value="" size="15" autocomplete="off">
              </span></td>
              </tr>
	  <tr id="pressid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				   <table id="presid" width="500" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="177" class="bodytext3">Blood Group</td>
                      
                       <td width="69" class="bodytext3">Quantity</td>
                      <td width="72" class="bodytext3">Batch</td>
                      <td width="72" class="bodytext3">Exp Date</td>
                      
                       
                     </tr>
					 <tr>
					 <div id="insertrow">					 </div></tr>
                     <tr>
					  <input type="hidden" name="serialnumber" id="serialnumber" value="1">
					  <input type="hidden" name="medicinecode" id="medicinecode" value="">
                        <td>
                        <select name="bloodgroup" id="bloodgroup" style="width: 150px;">
				  <option value="" selected="selected">Select Blood Group</option>
                      <?php
				  	$query55 = "select * from master_bloodgroup where recordstatus = '' order by bloodgroup";
				$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while ($res55 = mysqli_fetch_array($exec55))
				{
				$res5anum = $res55["auto_number"];
				$res5bloodgroup = $res55["bloodgroup"];
				
				?>
                      <option value="<?php echo $res5bloodgroup; ?>"><?php echo $res5bloodgroup; ?></option>
                      <?php
				}
				?>
                        	
                        </select>
                        </td>
						
						<td><input name="quantity" type="text" id="quantity" size="8"></td>
						<td><input name="batchnumber" type="text" id="batchnumber" size="8"></td>
              <td>
						<input name="expirydate" type="text" id="expirydate" size="8">
                        </td>
						<td width="169"><label>
                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem10()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
                     
					 <input type="hidden" name="h" id="h" value="0">
                   </table>				  </td>
			       </tr>
			   <tr>
              <td align="left" valign="middle" class="bodytext3"></td>
              <td align="left" valign="top">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  style="border: 1px solid #001E6A" type="submit" value="Save" name="Submit" onClick="return Formcheck()"/>
                 </td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      
	  
	  </form>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>


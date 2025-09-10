<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

$patientcode=isset($_REQUEST['patientcode'])?$_REQUEST['patientcode']:'';
$visitcode=isset($_REQUEST['visitcode'])?$_REQUEST['visitcode']:'';

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
// $location=$_REQUEST['location']; 
//   $receivedfrom=$_REQUEST['recivedfrom']; 
//$serial = $_REQUEST['serialnumber'];
// $store = $_REQUEST['storecode'];
//$number = $serial - 1;

$locationname=isset($_REQUEST['locationname'])?$_REQUEST['locationname']:'';
$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
$storecode=isset($_REQUEST['storecode'])?$_REQUEST['storecode']:'';
$patientname=isset($_REQUEST['patientname'])?$_REQUEST['patientname']:'';

$bloodgroup=isset($_REQUEST['bloodgroup'])?$_REQUEST['bloodgroup']:'';
$issueqty=isset($_REQUEST['issueqty'])?$_REQUEST['issueqty']:'';
$avlqty=isset($_REQUEST['avlqty'])?$_REQUEST['avlqty']:'';
$remarks=isset($_REQUEST['remarks'])?$_REQUEST['remarks']:'';

/*$query231 = "select * from master_employeelocation where username='$username'";
$exec231 = mysql_query($query231) or die(mysql_error());
$res231 = mysql_fetch_array($exec231);
$locationname = $res231['locationname'];
$locationcode = $res231['locationcode'];
$storecode = $res231['storecode'];
*/

$query751 = "select * from master_store where storecode='$storecode'";
$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res751 = mysqli_fetch_array($exec751);
 $store1 = $res751['store']; 


		if($bloodgroup!="")
		{
		
	 $medicinequery2="insert into bloodissued (patientname,patientcode,visitcode,bloodgroup, transactiondate,
	 docno, quantity, 
	 username, ipaddress, companyanum, companyname,store,storecode,location,locationcode,locationname,remarks)
	values ('".$patientname."','".$patientcode."','".$visitcode."','$bloodgroup', '$updatedatetime', '$billnumber', '$issueqty', 
	'$username', '$ipaddress','$companyanum', '$companyname','$store1','".$storecode."','$locationcode','$locationcode','$locationname','".$remarks."')";  
	
	$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
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
$query2 = "select * from bloodissued order by auto_number desc limit 0, 1";
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

$query231 = "select * from master_employeelocation where username='$username' and locationcode='LTC-1' and storecode='1'";
$exec231 = mysqli_query($GLOBALS["___mysqli_ston"], $query231) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res231 = mysqli_fetch_array($exec231);
$locationname = $res231['locationname'];
$locationcode = $res231['locationcode'];
$storecode = $res231['storecode'];


$query751 = "select * from master_store where auto_number='$storecode'";
$exec751 = mysqli_query($GLOBALS["___mysqli_ston"], $query751) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res751 = mysqli_fetch_array($exec751);
 $storecode = $res751['storecode']; 
$query3 = "select * from master_customer where customercode='".$patientcode."'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$patientname=$res3['customername'];
$patientcode=$res3['customercode'];

$bloodgroup=$res3['bloodgroup'];
$patientcode=$res3['customercode'];

$query3 = "select * from master_visitentry where patientcode='".$patientcode."'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
//$patientname=$res3['customername'];
$visitcode=$res3['visitcode'];
//echo date('Y m d');
 $query3 = "select sum(quantity) as bloodtaken from bloodstock where bloodgroup='".$bloodgroup."' and locationcode='".$locationcode."' and storecode='".$storecode."' and DATE_FORMAT(expirydate,'%Y %m %d')<=DATE_FORMAT(CURDATE(),'%Y %m %d')";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
//$patientname=$res3['customername'];
$qtytotal=$res3['bloodtaken'];

$query3 = "select sum(quantity) as bloodissued from bloodissued where bloodgroup='".$bloodgroup."' and locationcode='".$locationcode."' and storecode='".$storecode."'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
//$patientname=$res3['customername'];
$qtyissued=$res3['bloodissued'];

$avlbloodqty=$qtytotal-$qtyissued;
?>
<script>

function noDecimal(evt) {

  
        var charCode = (evt.which) ? evt.which : event.keyCode
		//alert(charCode)
        if (charCode > 31 && ((charCode < 48) || charCode > 57)  )
  return false;
        else 
		//calculate(document.getElementById("issueqty").value);
        return true;


}
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
if(document.cbform1.bloodgroup.value=="")
	{
		alert("Blood Group is empty!");
		document.cbform1.bloodgroup.focus();
		return false;
	}
	if(document.cbform1.issueqty.value=="")
	{
		alert("Please Enter Issue quantity");
		document.cbform1.issueqty.focus();
		return false;
	}
	if(document.getElementById("remarks").value=='')
		{
		alert('Please enter Remarks!');
		document.getElementById("remarks").focus();
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
		
		
              <form name="cbform1" method="post" action="bloodissue.php" onSubmit="return validcheck()">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="1" bgcolor="#ecf0f5" class="bodytext3"><strong> Blood Issue</strong></td>
               <td colspan="2" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong>  </strong>
             
            
              
						
						
                  
                  </td> 
                  <td colspan="3" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
						
						
						
					echo	$locationname ;
						
						
						?>
						
						
                  
                  </td> 
              </tr>
          	 <tr>
              <td align="left" valign="middle"   class="bodytext3">Patient Name</td>
              <td   class="bodytext3"  colspan="3" ><input type="text"  value="<?php echo $patientname;?>" name="patientname" readonly></td>
                  <td align="left" valign="top"><span class="bodytext3">Patientcode</span></td>
                  <td align="left" valign="top"><span class="bodytext3"><input type="text" name="patientcode" value="<?php echo $patientcode?>" readonly></span></td>
                  <td width="13" align="left" valign="top"><span class="bodytext3"></span></td>
                  <td width="147" align="left" valign="top"><span class="bodytext3"></span></td>
                   
                  <input type="hidden" name="locationname" value="<?php echo $locationname; ?>">
                <input type="hidden" name="locationcode" value="<?php echo $locationcode; ?>">
                <input type="hidden" name="storecode" value="<?php echo $storecode; ?>">
                <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
             
              </tr>
		<tr>
		  <td width="77" align="left" valign="center" class="bodytext31">Visit Code </td>
          <td width="202" align="left" valign="center"  class="bodytext31">
		  <input type="text" name="visitcode" value="<?php echo $visitcode?>">
                 
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
			    
              
              
              </tr>
              <tr>
              	<td width="37" align="left" valign="middle"  class="bodytext3">Doc NO</td>
              <td width="66" align="left" valign="top"><span class="bodytext3">
                <input name="docnumber" type="text" id="docnumber" style="border: 1px solid #001E6A;" value="<?php echo $billnumbercode; ?>" size="8" autocomplete="off">
              </span></td>
              </tr>
              
              <tr>
              	<td width="37" align="left" valign="middle"  class="bodytext3">Blood Group</td>
              <td width="66" align="left" valign="top"><span class="bodytext3">
                <input name="bloodgroup" type="text" id="bloodgroup" style="border: 1px solid #001E6A;" value="<?php echo $bloodgroup; ?>" size="8" autocomplete="off">
              </span></td>
              </tr>
              
              <tr>
              	<td width="37" align="left" valign="middle"  class="bodytext3">Issue Qty</td>
              <td width="66" align="left" valign="top"><span class="bodytext3">
                <input name="issueqty" type="text" id="issueqty" style="border: 1px solid #001E6A;" value="" size="8" autocomplete="off" onKeyUp="calculate(this.value)" onkeypress="return noDecimal(event);">
                <script>
                	function calculate(val)
					{//alert(val);
						var avl;
						avl =document.getElementById('avlqty').value;
						if(parseFloat(avl)<parseFloat(val))
						{
							alert("Issue quantity is greater than Available quantity");
							document.getElementById('issueqty').value='';
							return false;
							}
						}
                </script>
              </span></td>
              <td width="37" align="left" valign="middle"  class="bodytext3">Avl Stock</td>
              <td width="66" align="left" valign="top"><span class="bodytext3">
                <input name="avlqty" type="text" id="avlqty" style="border: 1px solid #001E6A;" value="<?php echo number_format($avlbloodqty,2); ?>" size="8" autocomplete="off" readonly>
              </span></td>
              </tr>
              
              <tr>
              	<td width="37" align="left" valign="middle"  class="bodytext3">Remarks</td>
              <td width="66" align="left" valign="top"><span class="bodytext3">
                <textarea name="remarks" id="remarks" style="resize:none;border: 1px solid #001E6A;"></textarea>
              </span></td>
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


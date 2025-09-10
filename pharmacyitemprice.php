<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$colorloopcount = '';
$sno = '';
$snocount = '';
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
$res = mysqli_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	 $res12locationanum = $res["auto_number"];
	 
  $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
  $subtype=isset($_REQUEST['subtype'])?$_REQUEST['subtype']:'';
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
  
function readCSV($csvFile){
    $file_handle = fopen($csvFile, 'r');
    while (!feof($file_handle) ) {
        $line_of_text[] = fgetcsv($file_handle, 1024);
    }
    fclose($file_handle);
    return $line_of_text;
}
    
if (isset($_REQUEST["frmflag_upload"])) { $frmflag_upload = $_REQUEST["frmflag_upload"]; } else { $frmflag_upload = ""; }
if ($frmflag_upload == 'frmflag_upload')
{	
$paynowbillprefix = 'SA-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select billnumber from stock_taking order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='SA-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billnumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'SA-'.$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
	$locationcode = $_REQUEST['locationcode'];
	if(!empty($_FILES['upload_file']))
	{
		$inputFileName = $_FILES['upload_file']['tmp_name'];
		//print_r($_FILES['upload_file']);
		include 'phpexcel/Classes/PHPExcel/IOFactory.php';
		try {
    		$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		    $objPHPExcel = $objReader->load($inputFileName);
			$sheet = $objPHPExcel->getSheet(0); 
			$highestRow = $sheet->getHighestRow(); 
			$highestColumn = $sheet->getHighestColumn();
			$row = 1;
			$subtypeanos = array();
			$subtypes = array();
			$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                    NULL,
                                    TRUE,
                                    FALSE)[0];
			
			foreach($rowData as $key => $value)
			{
			if($value =="Purchase Price")
			{
			$ratenm = $key;
			}
			if($value =="Item Code")
			{
			$itemcodenm = $key;
			}
			if($value =="Item Name")
			{
			$itemnamenm = $key;
			}
			}
			
			for ($row = 2; $row <= $highestRow; $row++){ 
    		//  Read a row of data into an array
    		$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                    NULL,
                                    TRUE,
                                    FALSE)[0];
			
				//$sno = $rowData[0];	
				$querystr = '';			
				$itemcode=$rowData[$itemcodenm];	
				$itemname=$rowData[$itemnamenm];
				
				if(isset($ratenm))
				{
						
				$rate=floatval($rowData[$ratenm]);
				}
				if($itemcode!="" )
				{
				$medicinequery2="update master_medicine SET ipaddress = '$ipaddress' , purchaseprice = '$rate' where itemcode= '$itemcode'";
				$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				}
   				 //  Insert row data array into your database of choice here
			}
					
			} catch(Exception $e) {
			 die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}
			header("location:pharmacyitemprice.php");
			//print_r($objPHPExcel);
			
		}
		//$extension = substr(strrchr($_FILES['upload_file']['name'], "."), 1);
//		if($extension == 'csv')
//		{
//			$csv = readCSV($csvFile);
//			//print_r($csv);
//			$count = count($csv);
//			for($i=1;$i<$count;$i++)
//			{
//				$sno = $csv[$i][0];				
//				$storecode=$csv[$i][1];	
//				$itemcode=$csv[$i][2];	
//				$itemname=$csv[$i][3];	
//				$rate=$csv[$i][4];
//				$expirydate=$csv[$i][5];
//				$expirydate=date('Y-m-d', strtotime($expirydate));
//				$batchnumber=$csv[$i][6];
//				$batchnumber=str_replace("'","",$batchnumber);
//				$batchnumber=mysql_real_escape_string($batchnumber);
//				$avlquantity=$csv[$i][7];
//				$phyquantity=$csv[$i][8];
//				$itemsubtotal=$rate * $phyquantity;
//				if($batchnumber!="" )
//				{
//					$medicinequery2="insert into stock_taking (itemcode, itemname, transactiondate,transactionmodule,transactionparticular,
//					billnumber, quantity, 
//					username, ipaddress, rateperunit,companyanum, companyname,batchnumber,expirydate,store,location,totalrate,allpackagetotalquantity)
//					values ('$itemcode', '$itemname', '$updatedatetime', 'OPENINGSTOCK', 
//					'BY STOCK ADD', '$billnumbercode', '$phyquantity', 
//					'$username', '$ipaddress','$rate','$companyanum', '$companyname','$batchnumber','$expirydate','$storecode','$locationcode','$itemsubtotal','$avlquantity')";
//					$execquery2=mysql_query($medicinequery2) or die(mysql_error());
//				}
//		
//			} 
//		}
//		
//	}
	
	//header("location:stocktaking.php?billnumber=".$billnumber."");
	//exit;

}

?>

<?php
if(isset($_GET['billnumber']))
{
 $billnumber=$_GET['billnumber'];
	 // header("location:stockexport.php?billnumber=".$billnumber."");

$link = "<script>window.open('stockexport.php?billnumber=".$billnumber."', 'width=710,height=555,left=160,top=170')</script>";
echo $link;
//header("location:stocktaking.php");
	
}

?>


<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$res3 = mysqli_fetch_array($exec3);
$paynowbillprefix = 'SA-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select billnumber from stock_taking order by auto_number desc limit 0, 1";
$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
$res2 = mysqli_fetch_array($exec2);
$billnumber = $res2["billnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='SA-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billnumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'SA-'.$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
<script type="text/javascript" src="jquery/jquery-1.11.1.js"></script>
<script>



					
//ajax to get location which is selected ends here



function validcheck()
{
	if (document.getElementById('upload_file').value == '') 
	{
		 alert('Select CSV file to Upload');
		 return false;
	} 
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
function medicinecheck()
{
	if(document.cbform12.location.value=="")
	{
		alert("Please select location name");
		document.cbform12.location.focus();
		return false;
	}

	var location = document.getElementById("location").value;
	window.open("medicinepurchaseprice_csv.php?frmflag34=frmflag34&&location="+location, "_blank");
	return true;
	
}

function checkqty(val,sno)
{
	var snum=sno;
	var value=val;
	
	var avlquantity=document.getElementById("avlquantity"+snum).value;
	var phyquantity=document.getElementById("phyquantity"+snum).value;
	
	if(parseInt(value) > parseInt(avlquantity))
	{
		//alert("Please enter lesser then avlquantity");
		//document.getElementById("phyquantity"+snum).value='';
		
		//return false;
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
	function checkallfunc()
	{
		if(document.getElementById("checkall").checked==true)
		{
			//document.getElementById("check").checked=true;
			var checkvar = document.getElementsByClassName("check");
			for(var i=0;i<checkvar.length;i++)
			{
				checkvar[i].checked=true;
			}
		}
		else
		{
			var checkvar = document.getElementsByClassName("check");
			for(var i=0;i<checkvar.length;i++)
			{
				checkvar[i].checked=false;
			}
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
	<td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?> &nbsp;</td>
	<td width="97%" valign="top">
	
	<table width="116%" border="0" cellspacing="0" cellpadding="0">
	
	<tr>
	<td width="860">
		
	<form name="cbform12" method="post" action="pharmacyitemprice.php" onSubmit="return medicinecheck()" >
	<table width="570" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
			<tbody>
			
				<tr bgcolor="#011E6A">
					<td bgcolor="#ecf0f5" class="bodytext3"><strong> Pharamcy Purchase Price </strong></td>
					<td  align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
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
					<td align="left" valign="middle"  bgcolor="FFFFFF"  class="bodytext3"><strong>Location</strong></td>
					<td   class="bodytext3" bgcolor="FFFFFF" >
					<select name="location" id="location" style="border: 1px solid #001E6A;">
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
					</select>
					
					<input type="hidden" name="locationnamenew" value="<?php echo $locationname; ?>">
					<input type="hidden" name="locationcodenew" value="<?php echo $res1locationanum; ?>">
					<input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
					
					</td>
					
					
				</tr> 
			
			<!--
			<tr>
				<td align="left" valign="middle"  bgcolor="FFFFFF"  class="bodytext3"><strong>Subtype</strong></td>
				<td   class="bodytext3" bgcolor="FFFFFF"   colspan="3" >
					<select name="subtype" id="subtype" style="border: 1px solid #001E6A;">
						<option value="" >Select Subtype</option>
					<?php
						
						$query = "select * from master_subtype where recordstatus <> 'deleted'";
						$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res = mysqli_fetch_array($exec))
						{
						$res1subtype = $res["subtype"];
						$subtypeanum = $res["auto_number"];
						?>
						<option value="<?php echo $subtypeanum; ?>" <?php if($subtype!='')if($subtype==$subtypeanum){echo "selected";}?>><?php echo $res1subtype; ?></option>
						<?php 
						}
					?>
                  </select>
				</td>
			</tr>
			-->
				
			<tr>
				<td align="left" valign="middle" bgcolor="FFFFFF"  class="bodytext3"></td>
				<td align="left" valign="top"  bgcolor="FFFFFF" >
					<input type="hidden" name="cbfrmflag12" value="cbfrmflag12">
					<input  type="submit" id='submit' value="Search" name="submit" />
					<input name="resetbutton" type="reset" id="resetbutton" value="Reset" />
				</td>
					
			</tr>

		</tbody>
		
	</table>
	</form>
	</td>
	</tr>
		
	<tr>
		<td>&nbsp;</td>
	</tr>
	
	<form name="cbform1" method="post" action="pharmacyitemprice.php" enctype="multipart/form-data" onSubmit="return validcheck()">	
	<?php
		if (isset($_REQUEST["cbfrmflag12"])) { $cbfrmflag12 = $_REQUEST["cbfrmflag12"]; } else { $cbfrmflag12 = ""; }
		if ($cbfrmflag12 == 'cbfrmflag12')
		{
			$locationcode = $_REQUEST['location'];
	?>
	<tr>
	<td>
	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" bordercolor="#666666" cellspacing="0" cellpadding="4" width="767" align="left" border="0">
		
		<tbody bgcolor="#ecf0f5">
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
			
		<tr>
			<td width="102">&nbsp;</td>
			<td width="643" colspan="2" align="left" class="bodytext3">
				<strong>Upload CSV File </strong>
			</td>
		</tr>
		
		<tr>
			<td>&nbsp;</td>
			<td colspan="2"><input type="file" name="upload_file" id="upload_file"></td>
		</tr>
		
		<tr>
			<td>&nbsp;</td>
			<td colspan="2">
			<input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode; ?>">
			<input type="hidden" name="frmflag_upload" id="frmflag_upload" value="frmflag_upload">
			<input type="submit" name="frmsubmit1" value="Upload Excel">
			</td>
		</tr>
		
		</tbody>
		
	</table>
	</td>
	</tr>

	</form>
	</table>
	
	</td>
</tr>
</table>

  <?php 
  }
  ?>
<?php include ("includes/footer1.php"); ?>
</body>
</html>


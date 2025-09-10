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
//print_r($_SESSION);
$query1 = "select locationname, locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						
						 $res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if (isset($_REQUEST["locationcode"])) {  $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }
if ($cbfrmflag1 == 'cbfrmflag1')
{
$services = $_REQUEST['services'];
$servicescode = $_REQUEST['servicescode'];
$serial1 = $_REQUEST['serialnumberp'];
$serial2 = $_REQUEST['serialnumberl'];
$serial3 = $_REQUEST['serialnumberr'];
$serial4 = $_REQUEST['serialnumbers'];

 $number1 = $serial1 - 1;
$number2= $serial2 - 1;
 $number3 = $serial3 - 1;
 $number4= $serial4 - 1;


for ($p=1;$p<=$number1;$p++)
		{
				   
		$medicinename=$_REQUEST['medicinename'.$p];
		$medicinename=trim($medicinename);
	/*	$query77="select itemcode from master_medicine where itemname='$medicinename'";
			$exec77=mysql_query($query77);
			$num77=mysql_num_rows($exec77);
			//echo $num77;
			$res77=mysql_fetch_array($exec77);
			$medicinecode=$res77['itemcode'];*/
			
		$medicinecode=$_REQUEST['medicinecode'.$p];
			
		$quantity=$_REQUEST['quantity'.$p];
		$pharmarate=$_REQUEST['pharmarate'.$p];
	  	
		if($medicinename!="")
		{
		
	 $medicinequery2="insert into healthcarepackagelinking (servicecode,servicename, itemcode, itemname, quantity,username, ipaddress,Department,date,rate,locationname,locationcode)
	values ('$servicescode','$services','$medicinecode', '$medicinename','$quantity','$username', '$ipaddress','1','$updatedatetime','$pharmarate','$res1locationanum','$res1locationname')";
	
	$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	
		}
		
	
		for ($p=1;$p<=$number2;$p++)
		{
				   
		$labname=$_REQUEST['labname'.$p];
		$labname=trim($labname);
	/*	$query77="select itemcode from master_lab where itemname='$labname'";
			$exec77=mysql_query($query77);
			$num77=mysql_num_rows($exec77);
			//echo $num77;
			$res77=mysql_fetch_array($exec77);
			$labcode=$res77['itemcode'];*/
			
		$labcode=$_REQUEST['labcode'.$p];
			
		$labrate=$_REQUEST['labrate'.$p];
		
	  	
		if($labname!="")
		{
		
	$labquery2="insert into healthcarepackagelinking (servicecode,servicename, itemcode, itemname,username, ipaddress,Department,date,rate,locationname,locationcode)
	values ('$servicescode','$services','$labcode', '$labname','$username', '$ipaddress','2','$updatedatetime','$labrate','$res1locationanum','$res1locationname')";
	
	$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $labquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	
		}
		
		
		for ($p=1;$p<=$number3;$p++)
		{
				   
		$radname=$_REQUEST['radname'.$p];
		$radname=trim($radname);
	/*	$query77="select itemcode from master_medicine where itemname='$medicinename'";
			$exec77=mysql_query($query77);
			$num77=mysql_num_rows($exec77);
			//echo $num77;
			$res77=mysql_fetch_array($exec77);
			$medicinecode=$res77['itemcode'];*/
			
		$radcode=$_REQUEST['radcode'.$p];
			
		$radrate=$_REQUEST['radrate'.$p];
		
	  	
		if($radname!="")
		{
		
	$radquery2="insert into healthcarepackagelinking (servicecode,servicename, itemcode, itemname,username, ipaddress,Department,date,rate,locationname,locationcode)
	values ('$servicescode','$services','$radcode', '$radname','$username', '$ipaddress','3','$updatedatetime','$radrate','$res1locationanum','$res1locationname')";
	
	$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $radquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	
		}
		
		for ($p=1;$p<=$number4;$p++)
		{
				   
		$sername=$_REQUEST['sername'.$p];
		$sername=trim($sername);
		/*$query77="select itemcode from master_medicine where itemname='$medicinename'";
			$exec77=mysql_query($query77);
			$num77=mysql_num_rows($exec77);
			echo $num77;
			$res77=mysql_fetch_array($exec77);
			$medicinecode=$res77['itemcode'];*/
			
		$sercode=$_REQUEST['sercode'.$p];
			
		$serrate=$_REQUEST['serrate'.$p];
		
	  	
		if($sername!="")
		{
		
	$serquery2="insert into healthcarepackagelinking (servicecode,servicename, itemcode, itemname,username, ipaddress,Department,date,rate,locationname,locationcode)
	values ('$servicescode','$services','$sercode', '$sername','$username', '$ipaddress','4','$updatedatetime','$serrate','$res1locationanum','$res1locationname')";
	
	$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $serquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	
	
		}
		
		
		header("location:healthcarepackagelinking.php");
}

?>

<?php
$query23 = "select * from master_employee where username='$username'";
$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res23 = mysqli_fetch_array($exec23);
$res7locationanum = $res23['location'];

$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res55 = mysqli_fetch_array($exec55);
$location = $res55['locationname'];

$res7storeanum = $res23['store'];

$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$res75 = mysqli_fetch_array($exec75);
$store = $res75['store'];
?>
<script>
function funcOnLoadBodyFunctionCall()
{

	//funcCustomerDropDownSearch4();
	//funcCustomerDropDownSearch3();
	
	
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
    var parent = document.getElementById('insertrow1'); // tbody name.
	document.getElementById ('insertrow1').removeChild(child);
	
	var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow1'); // tbody name.
	//alert (child);
	if (child != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow1').removeChild(child);
		
		
	}
	

}
function btnDeleteClick12(delID)
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

	var child = document.getElementById('idlabTR'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow2'); // tbody name.
	document.getElementById ('insertrow2').removeChild(child);
	
	var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow2'); // tbody name.
	//alert (child);
	if (child != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow2').removeChild(child);
		
		
	}
	

}
function btnDeleteClick13(delID)
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

	var child = document.getElementById('idradTR'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow3'); // tbody name.
	document.getElementById ('insertrow3').removeChild(child);
	
	var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow3'); // tbody name.
	//alert (child);
	if (child != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow3').removeChild(child);
		
		
	}
	
}
function btnDeleteClick14(delID)
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

	var child = document.getElementById('idserTR'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow4'); // tbody name.
	document.getElementById ('insertrow4').removeChild(child);
	
	var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow4'); // tbody name.
	//alert (child);
	if (child != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow4').removeChild(child);
		
		
	}
	

}
</script>
<script>
function medicinecheck()
{
if(document.cbform1.tostore.value=="")
	{
		alert("Please Select the store");
		document.cbform1.tostore.focus();
		return false;
	}

	
	
	return true;
	
}
</script>

<link href="css/bootstrap.min.css" rel="stylesheet">

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

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link href="css/autocomplete.css" rel="stylesheet">

<script>
$('document').ready(function(e) {
$('#services').autocomplete({
		
	source:'ajaxhealthcaresearch.php', 
	//alert(source);
	minLength:1,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var servicescode = ui.item.itemcode;
			var varservicesname = ui.item.itemname;
			$('#servicescode').val(servicescode);
			$('#hiddenservices').val(varservicesname);
			//funcservicessearch7();
			},
    });
	
	$('#medicinename').autocomplete({
		
	source:'ajaxhealthcaremedicinesearch.php?loc=<?= $res1locationanum ?>', 
	//alert(source);
	minLength:1,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var medicinecode = ui.item.itemcode;
			var varmedicinename = ui.item.value;
			var varmedicinerate = ui.item.rate;
			$('#medicinecode').val(medicinecode);
			$('#searchmedicineanum1').val(medicinecode);
			$('#searchmedicinename1hiddentextbox').val(varmedicinename);
			$('#pharmarate').val(varmedicinerate);
			//funcservicessearch7();
			},
		
    })
	.focusout(function() {
			if($('#medicinename').val()!= $('#searchmedicinename1hiddentextbox').val())
			{
			$('#medicinecode').val('');
			}
 		});
		
		$('#labname').autocomplete({
		
	source:'ajaxhealthcarelabsearch.php', 
	//alert(source);
	minLength:1,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var labcode = ui.item.itemcode;
			var varlabname = ui.item.value;
			var varlabrate = ui.item.rate;
			$('#labcode').val(labcode);
			$('#searchlabanum1').val(labcode);
			$('#searchlab1hiddentextbox').val(varlabname);
			$('#labrate').val(varlabrate);
			//funcservicessearch7();
			},
		
    })
	.focusout(function() {
			if($('#labname').val()!= $('#searchlab1hiddentextbox').val())
			{
			$('#labcode').val('');
			}
 		});
		$('#radname').autocomplete({
	source:'ajaxhealthcareradsearch.php', 
	//alert(source);
	minLength:1,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var radcode = ui.item.itemcode;
			var varradname = ui.item.value;
			var varradrate = ui.item.rate;
			$('#radcode').val(radcode);
			$('#searchlabanum1').val(radcode);
			$('#searchrad1hiddentextbox').val(varradname);
			$('#radrate').val(varradrate);
			//funcservicessearch7();
			},
		
    })
	.focusout(function() {
			if($('#radname').val()!= $('#searchrad1hiddentextbox').val())
			{
			$('#radcode').val('');
			}
 		});
		$('#sername').autocomplete({
		
	source:'ajaxhealthcaresersearch.php', 
	//alert(source);
	minLength:1,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var sercode = ui.item.itemcode;
			var varsername = ui.item.value;
			var varserrate = ui.item.rate;
			$('#sercode').val(sercode);
			$('#searchseranum1').val(sercode);
			$('#searchser1hiddentextbox').val(varsername);
			$('#serrate').val(varserrate);
			//funcservicessearch7();
			},
		
    })
	.focusout(function() {
			if($('#sername').val()!= $('#searchser1hiddentextbox').val())
			{
			$('#sercode').val('');
			}
 		});
    
});
</script>


  <?php

//include ("autocompletebuild_services11.php");
?>
<?php //include ("js/dropdownlist1scriptingservices1.php"); ?>
<!--<script type="text/javascript" src="js/autocomplete_services1.js"></script>
<script type="text/javascript" src="js/autosuggestservices1.js"></script>
-->

<script type="text/javascript" src="js/insertnewitem1hclinking.js"></script> <!--pharmacy-->
<script type="text/javascript" src="js/insertnewitem2hclinking.js"></script> <!--lab-->
<script type="text/javascript" src="js/insertnewitem3hclinking.js"></script><!--radiology-->
<script type="text/javascript" src="js/insertnewitem4hclinking.js"></script><!--service-->
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
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
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
		
		
              <form name="cbform1" method="post" action="healthcarepackagelinking.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
		   <tr>
              <td colspan="5" bgcolor="#ecf0f5" class="bodytext3"><strong> Wellness Package Linking </strong></td>
               <td colspan="3" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             		<?php echo $res1location; ?>
            						
						<input type="hidden" name="locationcode" id="locationcode" value="<?php echo $res1locationanum; ?>">
                  
                  </td> 
              </tr>
            
            <tr>
              <td colspan="8" class="bodytext3"><strong> Select Service </strong>
                <input name="services" type="text" id="services" size="69">
			    <input type="hidden" name="servicescode" id="servicescode" value="">
			    <input name="rate3[]" type="hidden" id="rate3" readonly size="8"></td>
			   </tr>
          
          

<!--Service-->   <tr id="pressid3">
				   <td colspan="15" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				   <table id="presid3" width="500" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="211" class="bodytext3"> Service Item</td>
                      
                       <td width="55" class="bodytext3">Rate</td>
                     </tr>
					 <tr>
					 <div id="insertrow4">					 </div></tr>
                     <tr>
					  <input type="hidden" name="serialnumbers" id="serialnumbers" value="1">
					  <input type="hidden" name="sercode" id="sercode" value="">
                        <td><input name="sername" type="text" id="sername" size="35" autocomplete="off" ></td>
								   <input name="searchser1hiddentextbox" id="searchser1hiddentextbox" type="hidden" value="">
			  <input name="searchseranum1" id="searchseranum1" value="" type="hidden">
			
						<td><input type="text" name="serrate" id="serrate" size="8" readonly/></td>
						<input name="avlquantity" type="hidden" id="avlquantity" size="8">
						
						
						<td width="224"><label>
                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem14()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
                     
					 <input type="hidden" name="h" id="h" value="0">
                   </table>				  </td>
			       </tr>  <!--end of Service-->
				   
				   
				    <tr>
              <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
              <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
              <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
              <td colspan="2" align="left" valign="middle" class="bodytext3">&nbsp;</td>
              <td align="left" valign="top">			              </td>
            </tr>
			   <tr>
              <td align="left" valign="middle" class="bodytext3"></td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  style="border: 1px solid #001E6A" type="submit" value="Save" name="Submit" onClick="return medicinecheck();"/>                 </td>
            </tr>
			 <tr bgcolor="#011E6A">
                        <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>Services Linking - Existing List </strong></td>
                      </tr>
                      <tr>
                        <td width="5%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>S.no </strong></td>
                        <td width="48%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Service </strong></td>
                        <td width="9%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Edit</strong></td>
                      </tr>
                      <?php
					  $colorloopcount = '';
					  
	    $query1 = "select * from healthcarepackagelinking where recordstatus <> 'deleted' group by servicecode";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$servicecode = $res1['servicecode'];
		$servicename = $res1["servicename"];
		
		//$defaultstatus = $res1["defaultstatus"];
		
		
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
					                                      <td align="left" valign="top"  class="bodytext3"><?php echo $colorloopcount; ?> </td>

                                    <td align="left" valign="top"  class="bodytext3"><?php echo $servicename; ?> </td>
                        <td align="left" valign="top"  class="bodytext3">
						<a href="edithealthcarelinking.php?st=edit&&code=<?php echo $servicecode; ?>" style="text-decoration:none">Edit</a>						</td>
                      </tr>
                      <?php
		}
		?>
                      <tr>
                        <td align="middle" colspan="2" >&nbsp;</td>
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


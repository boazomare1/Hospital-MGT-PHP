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

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if ($cbfrmflag1 == 'cbfrmflag1')
{
	$labcode = $_REQUEST['labcode'];
	$labname = $_REQUEST['lab'];
	$n = sizeof($_REQUEST['parameter']);
	if($n>0)
	{
	mysqli_query($GLOBALS["___mysqli_ston"], "delete from master_test_parameter where labcode = '$labcode'");
	}
	for( $i=0; $i<$n;$i++)
	{
	$parameter = $_REQUEST['parameter'][$i];
	$parametercode = $_REQUEST['parametercode'][$i];
	echo '<br>'.$qryinsert = "insert into master_test_parameter (labcode,labname,parametername,parametercode) values ('".$labcode."','".$labname."','".$parameter."','".$parametercode."')";
	mysqli_query($GLOBALS["___mysqli_ston"], $qryinsert) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	}

		header("location:parameterlinking.php");
}

?>
<?php


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

	funcCustomerDropDownSearch1();
	
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
if(document.cbform1.interfacemachine.value=="")
	{
		alert("Please Select Interface Machine");
		document.cbform1.interfacemachine.focus();
		return false;
	}

	
	
	return true;
	
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
.ui-menu .ui-menu-item{ zoom:1 !important; }
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>

<?php include ("js/dropdownlist1scriptinglab1.php"); ?>
<script type="text/javascript" src="js/autocomplete_labanalyser.js"></script>
<script type="text/javascript" src="js/autosuggestlab1.js"></script> 
<script type="text/javascript" src="js/insertnewitemmachineitemlinking.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />   
<link href="autocomplete.css" rel="stylesheet">

<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script>
$(function() {
$('#lab').focus();
$('#lab').autocomplete({
		
	source:'ajaxlabnewserach.php', 
	//alert(source);
	minLength:2,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var code = ui.item.code;
			
			$('#labcode').val(code);
			labreference(code);
			
			},
    });
	});
	
	function labreference(code)
	{
		var dataString = 'labcode='+code;
		//alert(dataString);
		$.ajax({
			type: "POST",
			url: "lablinkparameter.php",
			data: dataString,
			success: function(html){
				//alert(html);
				$("#insertreference").empty();
				$("#insertreference").append(html);
										
			}
		});
	}
	
</script>     
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
		
		
              <form name="cbform1" method="post" action="parameterlinking.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
		   <tr>
              <td colspan="8" bgcolor="#ecf0f5" class="bodytext3"><strong> Test Parameter Linking </strong></td>
              </tr>
           
          
           
	  <tr id="pressid">
				   <td colspan="15" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				   <table id="presid" width="500" border="0" cellspacing="1" cellpadding="1">
                     <tr>
					
                       <td width="211" class="bodytext3"><strong>Lab Item</strong></td>
					   <td width="55" class="bodytext3"><strong>Lab Code</strong></td>
                       
					   <td align="left">&nbsp;</td>
                     </tr>
					 
					 <tbody id="insertrow">					 </tbody>
                     <tr>
					 
					 <td>
					  <input name="lab" type="text" id="lab" size="35" >
						 
			 			 <input type="hidden" name="serialnumber" id="serialnumber" value="1">
						</td>
						<td>
					 <input type="text" name="labcode" id="labcode" value="" readonly>
					 </td>
						<td width="224"></td>
					   </tr>
					   <tr>
					   <td>&nbsp;</td>
					   </tr>
                     <tbody id="insertreference">					 </tbody>
                     
					 <input type="hidden" name="h" id="h" value="0">
                   </table>				  </td>
			       </tr>
				    <tr>
              <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
              <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
              <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
              <td colspan="2" align="left" valign="middle" class="bodytext3">&nbsp;</td>
              <td width="1%" align="left" valign="top">			              </td>
            </tr>
			   <tr>
              <td align="left" valign="middle" class="bodytext3"></td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  style="border: 1px solid #001E6A" type="submit" value="Save" name="Submit" onClick="return medicinecheck();"/>                 </td>
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


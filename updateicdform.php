<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$currenttime = date('H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('2014-01-01');
$paymentreceiveddateto = date('Y-m-d');


if(isset($_REQUEST["patientcodes"])){$patientcodes = $_REQUEST["patientcodes"];}
if(isset($_REQUEST["visitcodes"])){$visitcodes = $_REQUEST["visitcodes"];}
if(isset($_REQUEST["date"])){$dates = $_REQUEST["date"];}



include("autocompletebuild_medicine1.php");
include("autocompletebuild_medicine1.php");
include ("autocompletebuild_lab1.php");
include ("autocompletebuild_radiology1.php");
include ("autocompletebuild_services1.php");
include ("autocompletebuild_referal.php");
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
<?php
 if(isset($_REQUEST['save'])) {
 
  $patientcode = $_REQUEST['patientcode'];
  $patientname = $_REQUEST['patientname'];
  $patientvisitcode = $_REQUEST['visitcode'];
  $query2 = "select * from master_visitentry where patientcode='$patientcode' and visitcode='$patientvisitcode'";
  $exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res2 = mysqli_fetch_array($exec2);
  $age = $res2['age'];
  $account = $res2['accountfullname'];
  $query3 = "select max(consultation_id) as conid from master_consultation where patientcode='$patientcode' and patientvisitcode = '$patientvisitcode'";
  $exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
  $res3 = mysqli_fetch_array($exec3);
  $conid = $res3['conid'];
  //$is=169
 foreach($_POST['dis'] as $key=>$value)
		{
			//echo "pair";
			$pairs111 = $_POST['dis'][$key];
			$pairvar111 = $pairs111;
			$pairs112 = $_POST['code'][$key];
			$pairvar112 = $pairs112;
			$pairs113 = $_POST['dis1'][$key];
			$pairs114 = $_POST['code1'][$key];
			
			
			//print_r($_POST);
			
			if($pairvar111 != "")
			{
			
			$icdquery1 = "insert into consultation_icd(consultationid,patientcode,patientname,patientvisitcode,accountname,consultationdate,consultationtime,primarydiag,
primaryicdcode,secondarydiag,secicdcode,age)values('$conid','$patientcode','$patientname','$patientvisitcode','$account','$paymentreceiveddateto','$currenttime','$pairs111','$pairs112','$pairs113','$pairs114','$age')";
			$execicdquery = mysqli_query($GLOBALS["___mysqli_ston"], $icdquery1) or die("Error in icdquery1". mysqli_error($GLOBALS["___mysqli_ston"]));
			$st='success';
			header('location:updateicd.php?st=success');
			exit;
			}
			else
			{
			header('location:updateicd.php?st=failed');
			exit;
			}
		}
	
		
}
 ?>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>

<script language="javascript">

function cbsuppliername1()
{
	document.cbform1.submit();
}
function funcOnLoadBodyFunctionCall()
{ 
	//alert ("Inside Body On Load Fucntion.");
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	//alert("hi");
	funcCustomerDropDownSearch10();
	funcCustomerDropDownSearch15();
	//To handle ajax dropdown list.
}
function validate()
{
if(document.form1.dis.value=="")
	{
		alert("Please enter disease name");
		document.form1.dis.focus();
		return false;
	}
}
function btnDeleteClick13(delID13)
{
	//alert ("Inside btnDeleteClick.");
	//var newtotal;
	//alert(delID4);
	var varDeleteID13= delID13;
	//alert(varDeleteID4);
	
	//alert(rateref);
	//alert (varDeleteID3);
	var fRet13; 
	fRet13 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet13 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child13 = document.getElementById('idTR'+varDeleteID13);  
	//alert (child3);//tr name
    var parent13 = document.getElementById('insertrow13'); // tbody name.
	document.getElementById ('insertrow13').removeChild(child13);
	
	var child13= document.getElementById('idTRaddtxt'+varDeleteID13);  //tr name
    var parent13 = document.getElementById('insertrow13'); // tbody name.
	
	if (child13 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow13').removeChild(child13);
	}

	
}
function btnDeleteClick14(delID14)
{
	//alert ("Inside btnDeleteClick.");
	//var newtotal;
	//alert(delID4);
	var varDeleteID14= delID14;
	//alert(varDeleteID4);
	
	//alert(rateref);
	//alert (varDeleteID3);
	var fRet14; 
	fRet14 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet14 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child14 = document.getElementById('idTR'+varDeleteID14);  
	//alert (child3);//tr name
    var parent14 = document.getElementById('insertrow14'); // tbody name.
	document.getElementById ('insertrow14').removeChild(child14);
	
	var child14= document.getElementById('idTRaddtxt'+varDeleteID14);  //tr name
    var parent14 = document.getElementById('insertrow14'); // tbody name.
	
	if (child14 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow14').removeChild(child14);
	}

	
}
</script>

<?php include ("js/dropdownlist1icd.php"); ?>
<script type="text/javascript" src="js/autosuggestnewicdcode.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newicd.js"></script>

<?php include ("js/dropdownlist1icd1.php"); ?>
<script type="text/javascript" src="js/autosuggestnewicdcode1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newicd1.js"></script>

<?php include ("js/dropdownlist1newscriptingmedicine1.php"); ?>
<script type="text/javascript" src="js/autosuggestnewmedicine1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newmedicineq.js"></script>
<script type="text/javascript" src="js/automedicinecodesearch2.js"></script>

<script type="text/javascript" src="js/insertnewitem13.js"></script>
<script type="text/javascript" src="js/insertnewitem14.js"></script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>

</head>
 <link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 
 
<script src="js/datetimepicker_css.js"></script>

<body onLoad="return funcOnLoadBodyFunctionCall();">
<table width="1900" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
	 
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="700" 
            align="left" border="0">
          <tbody>
            <form name="form1" id="form1" method="post" action="updateicdform.php" onSubmit="return validate();">
            <tr>
			<?php if ($patientcodes != '')
		  		{
			  		$query2 = "select * from master_visitentry where patientcode='$patientcodes' and visitcode='$visitcodes'";
  			  		$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
			  		$res2 = mysqli_fetch_array($exec2);
			  		$name = $res2['patientfullname'];
			  	} ?>
              <td class="bodytext31" valign="center"  align="left" colspan="2" 
               ><strong>Patient Name:<?php echo $name; ?> <input type="hidden" name="patientname" id="patientname" value="<?php echo $name; ?>" /></strong></td>
              <td align="left" valign="left"  colspan="2"
                 class="bodytext31"><div align="left"><strong>Reg NO:<?php echo $patientcodes; ?><input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcodes; ?>"/></strong></div></td>
			</tr>
			<tr>
              <td width="18%" align="left" valign="center"  
               class="style1" colspan="2">Visit Code:<?php echo $visitcodes; ?><input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcodes; ?>" /></td>
              <td width="41%" align="left" valign="center"  colspan="2"
                class="style1">Date:<?php echo $dates; ?></td>
               
            </tr>
			<tr><td>&nbsp;</td></tr>
			<?php
			
			
		    
			
		  if ($patientcodes != '')
		  {
			 
		 
		  	$colorloopcount='';
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
           
		
		<tr id="disease">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				    <table id="presid" width="767" border="0" cellspacing="1" cellpadding="1">
                     <tr>
					 <td width="72" class="bodytext3"></td>
                       <td width="423" class="bodytext3">Disease</td>
                       <td class="bodytext3">Code</td>
					   <td class="bodytext3"></td>
                     </tr>
					  <tr>
					 <div id="insertrow13">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumberdisease" id="serialnumberdisease" value="1">
					  <input type="hidden" name="diseas" id="diseas" value="">
					  <td class="bodytext3">Primary</td>
				   <td width="423"> <input name="dis[]" id="dis" type="text" size="69" autocomplete="off"></td>
				      <td width="101"><input name="code[]" type="text" id="code" readonly size="8">
					  <input name="autonum" type="hidden" id="autonum" readonly size="8">
					  <input name="searchdisease1hiddentextbox" type= "hidden" id = "searchdisease1hiddentextbox" >
					  <input name="chapter[]" type="hidden" id="chapter" readonly size="8"></td>
					   <td><label>
                       
                       </label></td>
					   </tr>
				      </table>						</td>
		        </tr>
				
				<tr id="disease1">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">
				    <table id="presid" width="769" border="0" cellspacing="1" cellpadding="1">
                     <tr>
					 <td width="72" class="bodytext3"></td>
                       <td width="425" class="bodytext3">Disease</td>
                       <td class="bodytext3">Code</td>
					   <td class="bodytext3"></td>
                     </tr>
					  <tr>
					 <div id="insertrow14">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumberdisease1" id="serialnumberdisease1" value="1">
					  <input type="hidden" name="diseas1" id="diseas1" value="">
					  <td class="bodytext3">Secondary </td>
				   <td width="425"> <input name="dis1[]" id="dis1" type="text" size="69" autocomplete="off"></td>
				      <td width="99"><input name="code1[]" type="text" id="code1" readonly size="8">
					  <input name="autonum1" type="hidden" id="autonum1" readonly size="8">
					  <input name="searchdisease1hiddentextbox1" type= "hidden" id = "searchdisease1hiddentextbox1" >
					  <input name="chapter1[]" type="hidden" id="chapter1" readonly size="8"></td>
					   <td><label>
                       
                       </label></td>
					   </tr>
				      </table>						</td>
		        </tr>
				<tr>
                      <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"><input type="hidden" name="save" value="save" />
                          <input  type="submit" value="Save" name="submit" />
                          <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
                    </tr>
			<?php
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
                bgcolor="#ecf0f5"><strong>&nbsp;</strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
			  <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ecf0f5">&nbsp;</td>
               
            </tr></form>
          </tbody>
        </table></td>
		
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>


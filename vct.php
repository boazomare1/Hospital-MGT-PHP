<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$date = date('Y-m-d');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	$name = $_REQUEST['name'];
	$gender = $_REQUEST['gender'];
	$dob = $_REQUEST['dateofbirth'];
	$age = $_REQUEST['age'];
	$height = $_REQUEST['height'];
	$weight = $_REQUEST['weight'];
	$bmi = $_REQUEST['bmi'];
	$batch = $_REQUEST['batch'];
	$ageduration = $_REQUEST['ageduration'];
	$vaccine = $_REQUEST['vct'];
	$celsius = $_REQUEST['celsius'];
	$resultvalue = $_REQUEST['result'];
		
	if ($vaccine != '')
	{
		$query1 = "insert into vct (childname,height,weight,bmi,dateofbirth,age,vaccine,batch,ageduration,ipaddress,recorddate,username,temp,gender,resultvalue) 
		values ('$name','$height','$weight','$bmi','$dob','$age','$vaccine','$batch','$ageduration','$ipaddress','$date','$username','$celsius','$gender','$resultvalue')";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$errmsg = "Success. New Patient Updated.";
		$bgcolorcode = 'success';
		
	}
	//exit();
	else
	{
		$errmsg = "Failed. Sub Type Already Exists.";
		$bgcolorcode = 'failed';
	}
	
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_genericname set recordstatus = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_genericname set recordstatus = '' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'default')
{
	$delanum = $_REQUEST["anum"];
	$query4 = "update master_genericname set defaultstatus = '' where cstid='$custid' and cstname='$custname'";
	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$query5 = "update master_genericname set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";
	$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'removedefault')
{
	$delanum = $_REQUEST["anum"];
	$query6 = "update master_genericname set defaultstatus = '' where auto_number = '$delanum'";
	$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
}


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add Sub Type To Proceed For Billing.";
	$bgcolorcode = 'failed';
}



?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #ecf0f5;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
.bal
{
border-style:none;
background:none;
text-align:left;
FONT-FAMILY: Tahoma;
FONT-SIZE: 11px;
font-weight:bolder;
}
-->
</style>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">

function addward1process1()
{
	//alert ("Inside Funtion");
	/*if (document.form1.subtype.value == "")
	{
		alert ("Pleae Enter Sub Type Name.");
		document.form1.subtype.focus();
		return false;
	}*/
	var name = document.form1.name.value;
	var gender = document.form1.gender.value;
	var dateofbirth = document.form1.dateofbirth.value;
	var age = document.form1.age.value;
	var height = document.form1.height.value;
	var weight = document.form1.weight.value;
	var bmi = document.form1.bmi.value;
	var vct = document.form1.vct.value;
	if(name == ""){
		alert("Please Enter the Name");
		document.form1.name.focus();
		return false;
	}
	if(gender == ""){
		alert("Please Select the Gender");
		document.form1.gender.focus();
		return false;
	}
	if(dateofbirth == ""){
		alert("Please Enter the Date Of Birth");
		document.form1.dateofbirth.focus();
		return false;
	}
	if(age == ""){
		alert("Please Enter the Age");
		document.form1.dateofbirth.focus();
		return false;
	}
	if(height == ""){
		alert("Please Enter the Height");
		document.form1.height.focus();
		return false;
	}
	if(weight == ""){
		alert("Please Enter the Weight");
		document.form1.weight.focus();
		return false;
	}
	if(bmi == ""){
		alert("Please Enter the BMI");
		document.form1.bmi.focus();
		return false;
	}
	if(vct == ""){
		alert("Please Select the VCT");
		document.form1.bmi.focus();
		return false;
	}
	if (confirm("Do you want to save the record?")==false){return false;}
}

function funcDeleteSubType(varSubTypeAutoNumber)
{
 var varSubTypeAutoNumber = varSubTypeAutoNumber;
	var fRet;
	fRet = confirm('Are you sure want to delete this generic name '+varSubTypeAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Generic Name Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Generic Name Entry Delete Not Completed.");
		return false;
	}

}
function GetDifference1()
{
	//To reset any existing values;
	document.getElementById("age").value = "";
	document.getElementById("ageduration").value = "";

	var dtFrom = document.getElementById("dateofbirth").value;
	var dtTo = document.getElementById("todaydate").value;
	//alert(dtFrom);
	//alert(dtTo);

   //To change format from YYYY-MM-DD to MM-DD-YYYY
    var mystr1 = dtFrom;
    var myarr1 = mystr1.split("-");
    var dtFrom = myarr1[1] + "-" + myarr1[2] + "-" + myarr1[0];
    
    var mystr2 = dtTo;
    var myarr2 = mystr2.split("-");
    var dtTo = myarr2[1] + "-" + myarr2[2] + "-" + myarr2[0];
    
	var dtFrom = new Date(dtFrom);
	var dtTo = new Date(dtTo);
    
	//document.getElementById("totalmonths1").value = months_between(dtFrom, dtTo);
	var varMonthCount = months_between(dtFrom, dtTo);
	var varMonthCount = parseInt(varMonthCount);
	if (varMonthCount <= 12)// || varMonthCount > 0)
	{
		//document.getElementById('ageduration').selectedIndex = 1; //To Select Month, index number 2 given.
		document.getElementById("age").value = varMonthCount;
		document.getElementById('ageduration').value = 'MONTHS';
	}
	
	//alert (varMonthCount);
	//To Count Days.
	if (varMonthCount == 0)// || varMonthCount > 0)
	{
		//document.getElementById('ageduration').selectedIndex = 1; //To Select Month, index number 2 given.
		document.getElementById('ageduration').value = 'DAYS';
	
		var dtFrom = document.getElementById("dateofbirth").value;
		var dtTo = document.getElementById("todaydate").value;
		
		///*
		//To change format from YYYY-MM-DD to MM-DD-YYYY
		var mystr1 = dtFrom;
		var myarr1 = mystr1.split("-");
		//alert (myarr1);
	    var dtFrom = myarr1[1] + "-" + myarr1[2] + "-" + myarr1[0];
		
		var mystr2 = dtTo;
		var myarr2 = mystr2.split("-");
	    var dtTo = myarr2[1] + "-" + myarr2[2] + "-" + myarr2[0];
		
		//alert (dtFrom);
		//alert (dtTo);
		
		var dtFrom = new Date(dtFrom);
		var dtTo = new Date(dtTo);
		
		//alert (dtFrom);
		//alert (dtTo);
		
		//*/
		
		// 24 hours, 60 minutes, 60 seconds, 1000 milliseconds
		var varDaysCount = Math.round((dtTo - dtFrom) / (1000 * 60 * 60 * 24)); // round the amount of days
		//alert (varDaysCount);
		document.getElementById("age").value = varDaysCount;

	}
	
	if (varMonthCount > 12)
	{
		var dtFrom = document.getElementById("dateofbirth").value;
		//alert(dtFrom);
	
	   //To change format from YYYY-MM-DD to YYYYMMDD
		var mystr1 = dtFrom;
		var myarr1 = mystr1.split("-");
		var dtFrom = myarr1[0] + "" + myarr1[1] + "" + myarr1[2];
		//alert (dtFrom);
		
		//var dob='19800810';
		var dob = dtFrom;
		var year = Number( dob.substr(0,4) );
		var month = Number( dob.substr(4,2) ) - 1;
		var day = Number( dob.substr(6,2) );
		var today = new Date();
		var age = today.getFullYear() - year;
		if( today.getMonth() < month || ( today.getMonth() == month && today.getDate() < day )) { age--; }
		//alert(age);
		var varYearsCount = age;
		
		document.getElementById('ageduration').value = 'YEARS';
		document.getElementById("age").value = varYearsCount;
	}
	
}

function months_between(date1, date2)
{
	return date2.getMonth() - date1.getMonth() + (12 * (date2.getFullYear() - date1.getFullYear()));
}

function dobcalc()
{
var age=document.getElementById("age").value;
document.getElementById('ageduration').value = 'YEARS';
var year1= new Date();
var yob=year1.getFullYear() - age;
var dob= yob+"-"+"0"+1+"-"+"0"+1;
document.getElementById("dateofbirth").value = dob;
//alert(dob);
}
function funcOnLoadBodyFunctionCall2()
{ 
funcCustomerDropDownSearch1();
}
function FunctionBMI()
{	
 
	if(document.form1.height.value != "" && document.form1.weight.value != "")
	{
	    var height = document.getElementById("height").value;
		var weight = document.getElementById("weight").value;
		var bmi = (weight/(height/100*height/100));
		//alert(bmi);
		bmi=(bmi).toFixed(2);
		document.getElementById("bmi").value = bmi;	
		
		if(bmi < 18.5)
		{
		
		document.getElementById("bmicategory").value ="Under Weight(<18.5)";
		}
		if((bmi >= 18.5)&&(bmi <= 24.9))
		{
		document.getElementById("bmicategory").value ="Normal Weight(18.5-24.9)";
		}
		if((bmi >= 25)&&(bmi <= 29.9))
		{
		document.getElementById("bmicategory").value ="Over Weight(25-29.9)";
		}
		if((bmi) >= 30)
		{
		document.getElementById("bmicategory").value ="Obesity(>=30)";
		}
	}
	//else
//	{
//		document.form1.value == "";
//		alert("Please Enter Height and Weight");
//	}
}	

</script>
<?php include ("autocompletebuild_vaccine.php"); ?>
<?php include ("js/dropdownlist1scriptingvaccine.php"); ?>
<script type="text/javascript" src="js/autocomplete_vaccine.js"></script>
<script type="text/javascript" src="js/autosuggestvaccine.js"></script> <!-- For searching customer -->

<script src="js/datetimepicker_css.js"></script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />    
<body onLoad="return funcOnLoadBodyFunctionCall2();">
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
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td><form name="form1" id="form1" method="post" action="vct.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><strong>VCT</strong></td>
                      </tr>
					  <tr>
                        <td colspan="4" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                       <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Name</div></td>
                        <td width="43%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="name" id="name" style="text-transform:uppercase" size="40" /></td>
                        <td width="8%" align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
                        <td width="28%" align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right"> Gender</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="gender" id="gender">
				  <option value="">Select Gender</option>
				  <option value="Male">Male</option>
				  <option value="Female">Female</option>
				  </select></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
                      </tr>
					  <tr>
					  <td align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">DOB </td>
			      <td align="left" valign="middle"  bgcolor="#FFFFFF">
				  <input type="text" name="dateofbirth" id="dateofbirth" value="" onChange="return GetDifference1()" readonly>
                      <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('dateofbirth')" style="cursor:pointer"/> </span></strong>
                      <input type="hidden" name="todaydate" id="todaydate" value="<?php echo date('Y-m-d'); ?>"></td>
					   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Age</td>
					   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input name="age" type="text" id="age" value="" size="5" onKeyUp="return dobcalc();" onBlur="return idhide();"><input name="ageduration" id="ageduration" value="" size="5" readonly></td>
					  </tr>
					  <tr>
                       <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Height</div></td>
                        <td width="43%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="height" id="height" style="text-transform:uppercase" size="10" onKeyUp="return FunctionBMI()" onKeyPress="return isNumber(event)"/></td>
                        <td width="8%" align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
                        <td width="28%" align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
                      </tr>
					   <tr>
                       <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Weight</div></td>
                        <td width="43%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="weight" id="weight" style=" text-transform:uppercase" size="10" onKeyUp="return FunctionBMI()" onKeyPress="return isNumber(event)"/></td>
                        <td width="8%" align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
                        <td width="28%" align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
                      </tr>
					   <tr>
                       <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">BMI</div></td>
                        <td width="43%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="bmi" id="bmi" style=" text-transform:uppercase" size="10" /></td>
                        <td colspan="2" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="bmicategory" id="bmicategory" class="bal" readonly size="21" value=""></td>
					   </tr>
						<tr>
                       <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Temp - C</div></td>
                        <td width="43%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="celsius" id="celsius" style="text-transform:uppercase" size="10" /></td>
                        <td width="8%" align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
                        <td width="28%" align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
                      </tr>
					  <tr>
                       <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Kits</div></td>
                        <td width="43%" align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="vct" id="vct">
						<option value="">Select</option>
						<option value="DETERMINE ">DETERMINE</option>
						<option value="UNIGOLD">UNIGOLD</option>
						<option value="KHB">KHB</option>
						<option value="FIRST RESPONSE">FIRST RESPONSE</option>
						</select>
						                     <td width="8%" align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
                        <td width="28%" align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
                      </tr>
					 												
                       
					  <tr>
                       <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Batch</div></td>
                        <td width="43%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="batch" id="batch" style="text-transform:uppercase" size="10" /></td>
                        <td width="8%" align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
                        <td width="28%" align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
                      </tr>
					  
					   <tr>
                       <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Result Value</div></td>
                        <td width="43%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="result" id="result" size="10" /></td>
                        <td width="8%" align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
                        <td width="28%" align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
                      </tr>
				
                      <tr>
                        <td width="15%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
						
                            <input type="hidden" name="frmflag1" value="frmflag1" />
                          <input type="submit" name="Submit" value="Submit" /></td>
                      </tr>
                      <tr>
                        <td align="middle" colspan="4" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                
                
              </form>
                </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>


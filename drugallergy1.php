<?php 
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$pagename = "";
$consultationfees1 = '';
$availablelimit = '';
include ("autocompletebuild_drugallergy1.php");
?>
<?php include ("js/dropdownlist1scriptingdrug1.php"); ?>
<script type="text/javascript" src="js/autosuggestitem1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_drugallergy1.js"></script>
<script type="text/javascript" src="js/autoitemcodesearch2.js"></script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script>
function funcOnLoadBodyFunctionCall()
{
	
	funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
	
	
}
function Drugallergy()
{
var i;
var varDrug1Catch =  document.getElementById("drug1").value;
var varDrug2Catch =  document.getElementById("drug2").value;
var varDrug3Catch =  document.getElementById("drug3").value;
var varDrug4Catch =  document.getElementById("drug4").value;

var Drugs = new Array();
Drugs[0] = varDrug1Catch ;
Drugs[1] = varDrug2Catch;
Drugs[2] = varDrug3Catch;
Drugs[3] = varDrug4Catch;

for (i=0;i<Drugs.length;i++)
{
window.opener.document.getElementById("drugallergy").value = Drugs.join('\n');
}
window.close();
}
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />     
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style2 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
</style>
<link href="css/default.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #ecf0f5;
}
-->
</style><body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="form1" method="post" action="drugallergy1.php"  onSubmit="return Drugallergy()">
<table width="456" height="207" border="0" cellpadding="1" cellspacing="1" style="border-collapse: collapse" bgcolor="#ecf0f5">
  <tr>
    <td width="93" height="34" class="bodytext3">Enter Drug Name </td>
    <td width="356"><label>
    <input name="drug" type="text" id="drug" size="50"  autocomplete="off" style="border: 1px solid #001E6A;"/>
    <input name="drugcode" id="drugcode" type="hidden"  />
    </label></td>
  </tr>
  <tr>
    <td class="bodytext3">Drug1</td>
    <td><label>
      <input name="drug1" type="text" id="drug1" size="30" style="border: 1px solid #001E6A;" />
    </label></td>
    </tr>
  <tr>
    <td class="bodytext3">Drug2</td>
    <td><label>
      <input name="drug2" type="text" id="drug2" size="30" style="border: 1px solid #001E6A;"/>
    </label></td>
    </tr>
  <tr>
    <td class="bodytext3">Drug3</td>
    <td><label>
      <input name="drug3" type="text" id="drug3" size="30" style="border: 1px solid #001E6A;"/>
    </label></td>
    </tr>
  <tr>
    <td height="35" class="bodytext3">Drug4</td>
    <td><label>
      <input name="drug4" type="text" id="drug4" size="30" style="border: 1px solid #001E6A;"/>
    </label></td>
    </tr>
  <tr>
    <td height="47" colspan="2"><label>
      <div align="center">
        <input type="Submit" name="Submit" value="Submit" class="button" style="border: 1px solid #001E6A"/>
      </div>
    </label></td>
  </tr>
</table>
</form>
</body>
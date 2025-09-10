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
include ("autocompletebuild_foodallergy1.php");
?>
<?php include ("js/dropdownlist1scriptingfood1.php"); ?>
<script type="text/javascript" src="js/autosuggestfood1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_foodallergy1.js"></script>
<script type="text/javascript" src="js/autofoodearch2.js"></script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script>
function funcOnLoadBodyFunctionCall()
{
 funcCustomerDropDownSearch1(); //To handle ajax dropdown list.	
}
function foodallergy()
{
var i;
var varfood1Catch =  document.getElementById("food1").value;
var varfood2Catch =  document.getElementById("food2").value;
var varfood3Catch =  document.getElementById("food3").value;
var varfood4Catch =  document.getElementById("food4").value;
var food = new Array();
food[0] =  varfood1Catch;
food[1] =  varfood2Catch;
food[2] =  varfood3Catch;
food[3] =  varfood4Catch;
for (i=0;i<food.length;i++)
{
window.opener.document.getElementById("foodallergy").value = food.join('\n');
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
<form name="form1" id="form1" method="post" action="foodallergy1.php"  onSubmit="return foodallergy()">
<table width="456" height="207" border="0" cellpadding="1" cellspacing="1" style="border-collapse: collapse" bgcolor="#ecf0f5">
  <tr>
    <td width="93" height="34" class="bodytext3">Enter Food Name </td>
    <td width="356"><label>
    <input name="food" type="text" id="food" size="50"  autocomplete="off" style="border: 1px solid #001E6A;"/>
    <input name="autonumber" id="autonumber" type="hidden"  />
    </label></td>
  </tr>
  <tr>
    <td class="bodytext3">Food 1</td>
    <td><label>
      <input name="food1" type="text" id="food1" size="30" style="border: 1px solid #001E6A;" />
    </label></td>
    </tr>
  <tr>
    <td class="bodytext3">Food 2 </td>
    <td><label>
      <input name="food2" type="text" id="food2" size="30" style="border: 1px solid #001E6A;"/>
    </label></td>
    </tr>
  <tr>
    <td class="bodytext3">Food 3 </td>
    <td><label>
      <input name="food3" type="text" id="food3" size="30" style="border: 1px solid #001E6A;"/>
    </label></td>
    </tr>
  <tr>
    <td height="35" class="bodytext3">Food 4</td>
    <td><label>
      <input name="food4" type="text" id="food4" size="30" style="border: 1px solid #001E6A;"/>
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
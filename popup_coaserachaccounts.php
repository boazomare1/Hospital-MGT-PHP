<?php
session_start();
//include ("includes/loginverify.php");
include ("db/db_connect.php");

if (isset($_REQUEST["callfrom"])) { $callfrom = $_REQUEST["callfrom"]; } else { $callfrom = ""; }
//$callfrom = $_REQUEST[callfrom];

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<script type="text/javascript" src="js/autocoasearchaccounts.js"></script>
<script language="javascript">

function captureEscapeKey1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		//alert ("Escape Key Press.");
		//event.keyCode=0; 
		//return event.keyCode 
		//return false;
	}
}

function escapekeypressed(e)
{

	evt = e || window.event; 
	key = evt.keyCode;
	//alert(event.keyCode);
	
	//if(event.keyCode=='27'){alert('you pressed escape');}
	//if(event.keyCode=='27'){ window.close(); } //Working only in IE and Chrome
	if(key == '27'){ window.close(); }
	//if(event.keyCode=='38'){ alert("Up Arrow Key Press."); }
	//if(event.keyCode=='40'){ alert("Down Arrow Key Press."); }	
	//alert ("Func Call From Escape Key");
	var varDownKeyCount = 0;

	//if(event.keyCode=='40') //down arrow key press //Working only in IE and Chrome
	if(key == '40') 
	{ 
		//alert("Down Arrow Key Press."); 
		//alert (document.activeElement.name);
		var varActiveElementName = document.activeElement.name;
		//alert (varActiveElementName);
		var varSubString = varActiveElementName.substring(0,12);
		//alert (varSubString);
		
		if (varSubString == "serialnumber") //focus is already on serial number.
		{
			//document.getElementById("Submit2").focus();
			var varSerialNumber = varActiveElementName.substring(12,20);
			var varSerialNumber = parseInt(varSerialNumber);
			//alert (varSerialNumber);
			if (varSerialNumber >= 1)
			{
				var varUpdateRow = varSerialNumber; 
				//alert (varUpdateRow);
				document.getElementById("serialnumber"+varUpdateRow).focus();
				document.getElementById("idTD1"+varUpdateRow).style.backgroundColor="#FFFFFF";
				document.getElementById("idTD2"+varUpdateRow).style.backgroundColor="#FFFFFF";
				document.getElementById("idTD3"+varUpdateRow).style.backgroundColor="#FFFFFF";
				document.getElementById("serialnumber"+varUpdateRow).style.backgroundColor="#FFFFFF";
				document.getElementById("customercode"+varUpdateRow).style.backgroundColor="#FFFFFF";
				document.getElementById("customername"+varUpdateRow).style.backgroundColor="#FFFFFF";
				document.getElementById("customeraddress1"+varUpdateRow).style.backgroundColor="#FFFFFF";
					
				var varUpdateRow = varSerialNumber + 1;
				//alert (varUpdateRow);
				if (document.getElementById("serialnumber"+varUpdateRow) == null)//to avoid no existing element error.
				{
					return false;
				}
				document.getElementById("serialnumber"+varUpdateRow).focus();
				document.getElementById("idTD1"+varUpdateRow).style.backgroundColor="#99FF00";
				document.getElementById("idTD2"+varUpdateRow).style.backgroundColor="#99FF00";
				document.getElementById("idTD3"+varUpdateRow).style.backgroundColor="#99FF00";
				document.getElementById("serialnumber"+varUpdateRow).style.backgroundColor="#99FF00";
				document.getElementById("customercode"+varUpdateRow).style.backgroundColor="#99FF00";
				document.getElementById("customername"+varUpdateRow).style.backgroundColor="#99FF00";
				document.getElementById("customeraddress1"+varUpdateRow).style.backgroundColor="#99FF00";
					//alert (document.activeElement.name);
				
			}
			
		}
		else
		{
			//document.getElementById("Submit2").focus();
			document.getElementById("serialnumber1").focus();
			document.getElementById("idTD11").style.backgroundColor="#99FF00";
			document.getElementById("idTD21").style.backgroundColor="#99FF00";
			document.getElementById("idTD31").style.backgroundColor="#99FF00";
			document.getElementById("serialnumber1").style.backgroundColor="#99FF00";
			document.getElementById("customercode1").style.backgroundColor="#99FF00";
			document.getElementById("customername1").style.backgroundColor="#99FF00";
			document.getElementById("customeraddress11").style.backgroundColor="#99FF00";
				
		}
		//alert (document.activeElement.name);
	
	return false;
	}
		
		
	//if(event.keyCode=='38') //up arrow key press //Working only in IE and Chrome.
	if(key == '38') //up arrow key press
	{ 
		//alert("Down Arrow Key Press."); 
		//alert (document.activeElement.name);
		var varActiveElementName = document.activeElement.name;
		//alert (varActiveElementName);
		var varSubString = varActiveElementName.substring(0,12);
		//alert (varSubString);
		
		if (varSubString == "serialnumber") //focus is already on serial number.
		{
			//document.getElementById("Submit2").focus();
			var varSerialNumber = varActiveElementName.substring(12,20);
			var varSerialNumber = parseInt(varSerialNumber);
			//alert (varSerialNumber);
			if (varSerialNumber >= 1)
			{
				var varUpdateRow = varSerialNumber; 
				//alert (varUpdateRow);
				document.getElementById("serialnumber"+varUpdateRow).focus();
				document.getElementById("idTD1"+varUpdateRow).style.backgroundColor="#FFFFFF";
				document.getElementById("idTD2"+varUpdateRow).style.backgroundColor="#FFFFFF";
				document.getElementById("idTD3"+varUpdateRow).style.backgroundColor="#FFFFFF";
				document.getElementById("serialnumber"+varUpdateRow).style.backgroundColor="#FFFFFF";
				document.getElementById("customercode"+varUpdateRow).style.backgroundColor="#FFFFFF";
				document.getElementById("customername"+varUpdateRow).style.backgroundColor="#FFFFFF";
				document.getElementById("customeraddress1"+varUpdateRow).style.backgroundColor="#FFFFFF";
					
				var varUpdateRow = varSerialNumber - 1;
				//alert (varUpdateRow);
				if (document.getElementById("serialnumber"+varUpdateRow) == null) //to avoid no existing element error.
				{
					document.getElementById("coasearch").focus(); //to show the search text box. or it will hide.
					return false;
				}
				document.getElementById("serialnumber"+varUpdateRow).focus();
				document.getElementById("idTD1"+varUpdateRow).style.backgroundColor="#99FF00";
				document.getElementById("idTD2"+varUpdateRow).style.backgroundColor="#99FF00";
				document.getElementById("idTD3"+varUpdateRow).style.backgroundColor="#99FF00";
				document.getElementById("serialnumber"+varUpdateRow).style.backgroundColor="#99FF00";
				document.getElementById("customercode"+varUpdateRow).style.backgroundColor="#99FF00";
				document.getElementById("customername"+varUpdateRow).style.backgroundColor="#99FF00";
				document.getElementById("customeraddress1"+varUpdateRow).style.backgroundColor="#99FF00";
					//alert (document.activeElement.name);

			}
			
		}
		else
		{
			//document.getElementById("Submit2").focus();
			document.getElementById("serialnumber1").focus();
			document.getElementById("idTD11").style.backgroundColor="#99FF00";
			document.getElementById("idTD21").style.backgroundColor="#99FF00";
			document.getElementById("idTD31").style.backgroundColor="#99FF00";
			document.getElementById("serialnumber1").style.backgroundColor="#99FF00";
			document.getElementById("customercode1").style.backgroundColor="#99FF00";
			document.getElementById("customername1").style.backgroundColor="#99FF00";
			document.getElementById("customeraddress11").style.backgroundColor="#99FF00";
			document.getElementById("customerarea1").style.backgroundColor="#99FF00";
			document.getElementById("customercity1").style.backgroundColor="#99FF00";
			document.getElementById("customerpincode1").style.backgroundColor="#99FF00";

		}

		//alert (document.activeElement.name);
		return false;
	}
	
	//if (event.keyCode=='13') //Working only in IE and Chrome
	if(key == '13') //up arrow key press
	{
		//alert ("Enter Key Press.");
		//alert (document.activeElement.name);
		var varActiveElementName = document.activeElement.name;
		var varActiveElementNumber = varActiveElementName.substring(12,20);

		var varActiveElementNumber = parseInt(varActiveElementNumber);
		//alert (varActiveElementNumber);
		if (!isNaN(varActiveElementNumber)) //to prevent losing focus to submit2.
		{
			
			<?php
			//To catch and pass values to the respective parent forms.
			if ($callfrom == '1')
			{
			?>
			
			var varIdCatch =  document.getElementById("customercode"+varActiveElementNumber).value;
			//alert (varCustomerCodeCatch);
			var varCoaCatch =  document.getElementById("customername"+varActiveElementNumber).value;
			//alert (varCustomerNameCatch);
			var varTypeCatch =  document.getElementById("customeraddress1"+varActiveElementNumber).value;
			varTypeCatch = varTypeCatch.toUpperCase();
			//alert (varCustomerNameCatch);
			
			//alert (varCustomerNameCatch);
			window.opener.document.getElementById("paynowlabcoa").value = varCoaCatch;
			window.opener.document.getElementById("paynowlabtype").value = varTypeCatch;
			window.opener.document.getElementById("paynowlabcode").value = varIdCatch;
				window.opener.document.getElementById("paynowlabcoa").focus();
			<?php
			}
			else if ($callfrom == '2')
			{
			?>
			
			var varIdCatch =  document.getElementById("customercode"+varActiveElementNumber).value;
			//alert (varCustomerCodeCatch);
			var varCoaCatch =  document.getElementById("customername"+varActiveElementNumber).value;
			//alert (varCustomerNameCatch);
			var varTypeCatch =  document.getElementById("customeraddress1"+varActiveElementNumber).value;
			varTypeCatch = varTypeCatch.toUpperCase();
			//alert (varCustomerNameCatch);
			
			//alert (varCustomerNameCatch);
			window.opener.document.getElementById("paynowradiologycoa").value = varCoaCatch;
			window.opener.document.getElementById("paynowradiologytype").value = varTypeCatch;
			window.opener.document.getElementById("paynowradiologycode").value = varIdCatch;
				window.opener.document.getElementById("paynowradiologycoa").focus();

			<?php
			}
			else if ($callfrom == '3')
			{
			?>
			var varIdCatch =  document.getElementById("customercode"+varActiveElementNumber).value;
			//alert (varCustomerCodeCatch);
			var varCoaCatch =  document.getElementById("customername"+varActiveElementNumber).value;
			//alert (varCustomerNameCatch);
			var varTypeCatch =  document.getElementById("customeraddress1"+varActiveElementNumber).value;
			varTypeCatch = varTypeCatch.toUpperCase();
			//alert (varCustomerNameCatch);
			
			//alert (varCustomerNameCatch);
			window.opener.document.getElementById("paynowservicecoa").value = varCoaCatch;
			window.opener.document.getElementById("paynowservicetype").value = varTypeCatch;
			window.opener.document.getElementById("paynowservicecode").value = varIdCatch;
				window.opener.document.getElementById("paynowservicecoa").focus();
			<?php
			}
			else if ($callfrom == '4')
			{
			?>
			var varIdCatch =  document.getElementById("customercode"+varActiveElementNumber).value;
			//alert (varCustomerCodeCatch);
			var varCoaCatch =  document.getElementById("customername"+varActiveElementNumber).value;
			//alert (varCustomerNameCatch);
			var varTypeCatch =  document.getElementById("customeraddress1"+varActiveElementNumber).value;
			varTypeCatch = varTypeCatch.toUpperCase();
			//alert (varCustomerNameCatch);
			
			//alert (varCustomerNameCatch);
			window.opener.document.getElementById("paynowreferalcoa").value = varCoaCatch;
			window.opener.document.getElementById("paynowreferaltype").value = varTypeCatch;
			window.opener.document.getElementById("paynowreferalcode").value = varIdCatch;
				window.opener.document.getElementById("paynowreferalcoa").focus();
				<?php
			}
			else if ($callfrom == '5')
			{
			?>
			var varIdCatch =  document.getElementById("customercode"+varActiveElementNumber).value;
			//alert (varCustomerCodeCatch);
			var varCoaCatch =  document.getElementById("customername"+varActiveElementNumber).value;
			//alert (varCustomerNameCatch);
			var varTypeCatch =  document.getElementById("customeraddress1"+varActiveElementNumber).value;
			varTypeCatch = varTypeCatch.toUpperCase();
			//alert (varCustomerNameCatch);
			
			//alert (varCustomerNameCatch);
			window.opener.document.getElementById("paynowpharmacycoa").value = varCoaCatch;
			window.opener.document.getElementById("paynowpharmacytype").value = varTypeCatch;
			window.opener.document.getElementById("paynowpharmacycode").value = varIdCatch;
				window.opener.document.getElementById("paynowpharmacycoa").focus();
				<?php
			}
			else if ($callfrom == '6')
			{
			?>
			var varIdCatch =  document.getElementById("customercode"+varActiveElementNumber).value;
			//alert (varCustomerCodeCatch);
			var varCoaCatch =  document.getElementById("customername"+varActiveElementNumber).value;
			//alert (varCustomerNameCatch);
			var varTypeCatch =  document.getElementById("customeraddress1"+varActiveElementNumber).value;
			varTypeCatch = varTypeCatch.toUpperCase();
			//alert (varCustomerNameCatch);
			
			//alert (varCustomerNameCatch);
			window.opener.document.getElementById("paynowcashcoa").value = varCoaCatch;
			window.opener.document.getElementById("paynowcashtype").value = varTypeCatch;
			window.opener.document.getElementById("paynowcashcode").value = varIdCatch;
				window.opener.document.getElementById("paynowcashcoa").focus();
				<?php
			}
			else if ($callfrom == '7')
			{
			?>
			var varIdCatch =  document.getElementById("customercode"+varActiveElementNumber).value;
			//alert (varCustomerCodeCatch);
			var varCoaCatch =  document.getElementById("customername"+varActiveElementNumber).value;
			//alert (varCustomerNameCatch);
			var varTypeCatch =  document.getElementById("customeraddress1"+varActiveElementNumber).value;
			varTypeCatch = varTypeCatch.toUpperCase();
			//alert (varCustomerNameCatch);
			
			//alert (varCustomerNameCatch);
			window.opener.document.getElementById("paynowchequecoa").value = varCoaCatch;
			window.opener.document.getElementById("paynowchequetype").value = varTypeCatch;
			window.opener.document.getElementById("paynowchequecode").value = varIdCatch;
				window.opener.document.getElementById("paynowchequecoa").focus();
				<?php
			}
			else if ($callfrom == '8')
			{
			?>
			var varIdCatch =  document.getElementById("customercode"+varActiveElementNumber).value;
			//alert (varCustomerCodeCatch);
			var varCoaCatch =  document.getElementById("customername"+varActiveElementNumber).value;
			//alert (varCustomerNameCatch);
			var varTypeCatch =  document.getElementById("customeraddress1"+varActiveElementNumber).value;
			varTypeCatch = varTypeCatch.toUpperCase();
			//alert (varCustomerNameCatch);
			
			//alert (varCustomerNameCatch);
			window.opener.document.getElementById("paynowmpesacoa").value = varCoaCatch;
			window.opener.document.getElementById("paynowmpesatype").value = varTypeCatch;
			window.opener.document.getElementById("paynowmpesacode").value = varIdCatch;
				window.opener.document.getElementById("paynowmpesacoa").focus();
				<?php
			}
			else if ($callfrom == '9')
			{
			?>
			var varIdCatch =  document.getElementById("customercode"+varActiveElementNumber).value;
			//alert (varCustomerCodeCatch);
			var varCoaCatch =  document.getElementById("customername"+varActiveElementNumber).value;
			//alert (varCustomerNameCatch);
			var varTypeCatch =  document.getElementById("customeraddress1"+varActiveElementNumber).value;
			varTypeCatch = varTypeCatch.toUpperCase();
			//alert (varCustomerNameCatch);
			
			//alert (varCustomerNameCatch);
			window.opener.document.getElementById("paynowcardcoa").value = varCoaCatch;
			window.opener.document.getElementById("paynowcardtype").value = varTypeCatch;
			window.opener.document.getElementById("paynowcardcode").value = varIdCatch;
				window.opener.document.getElementById("paynowcardcoa").focus();
				<?php
			}
			else if ($callfrom == '10')
			{
			?>
			var varIdCatch =  document.getElementById("customercode"+varActiveElementNumber).value;
			//alert (varCustomerCodeCatch);
			var varCoaCatch =  document.getElementById("customername"+varActiveElementNumber).value;
			//alert (varCustomerNameCatch);
			var varTypeCatch =  document.getElementById("customeraddress1"+varActiveElementNumber).value;
			varTypeCatch = varTypeCatch.toUpperCase();
			//alert (varCustomerNameCatch);
			
			//alert (varCustomerNameCatch);
			window.opener.document.getElementById("paynowonlinecoa").value = varCoaCatch;
			window.opener.document.getElementById("paynowonlinetype").value = varTypeCatch;
			window.opener.document.getElementById("paynowonlinecode").value = varIdCatch;
				window.opener.document.getElementById("paynowonlinecoa").focus();
				<?php
			}
			?>
			window.close();
		}
		
	}

	return false;
}


function bodyonload1()
{
	document.body.focus();
	document.getElementById("coasearch").focus();
}

function getcoa()
{
	//alert ("GetCustomer1");
	coasearch();
}

function downkeycount1()
{
}


</script>

<body onLoad="bodyonload1()" onkeydown="escapekeypressed(event)">
<table width="100%" border="1" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
    <tbody>
      <tr bgcolor="#011E6A">
        <td colspan="2" bgcolor="#ecf0f5" class="bodytext3"><strong>Search COA </strong></td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
		<input name="coasearch" id="coasearch" accesskey="s" onKeyUp="return getcoa()" type="text" size="50" value="<?php //echo $coasearch; ?>" />
        <input type="submit" name="Submit2" value="Alt+S" onClick="javascript:document.getElementById('coasearch').focus();" style="border: 1px solid #001E6A" /></td>
      </tr>
    </tbody>
</table>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
  <tbody id="tblrowinsert">
    <tr bgcolor="#011E6A">
      <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>Press Down &amp; Up Arrow To Scroll. Press Enter To Select. </strong></td>
    </tr>
   
    
  </tbody>
</table>
</body>

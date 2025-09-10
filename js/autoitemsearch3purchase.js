// JavaScript Document
//function to call ajax process
function itemsearch3()
{
	
	//alert("Meow...");
	if(document.getElementById("itemcode").value!="")
	{
		var varItemSearch = document.getElementById("itemcode").value;
		//alert (varItemSearch);
		var varItemSearchLen = varItemSearch.length;
		//alert (varItemSearchLen);
		
/*		if (varItemSearchLen == 8)
		{
			ajaxprocess();		
		}
		else
		{
			alert ("Item Code Not Found. Give Proper Code. Try Again.");
		}
*/		
		ajaxprocess();		
		//alert("Meow...");
		//ajaxprocess();		
		//var url = "";
	}
}

var xmlHttp

function ajaxprocess()
{
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request")
		return
	} 
  
  	var itemcode=document.getElementById("itemcode").value;
	var varSupplierCode1 = document.getElementById("suppliercode").value;
	//alert(itemcode);
	var url = "";
	var url="autoitemsearch2purchase.php?RandomKey="+Math.random()+"&&suppliercode="+varSupplierCode1+"&&itemcode="+itemcode;
    //alert(url);

	xmlHttp.onreadystatechange=stateChanged 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
} 

function stateChanged() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
	//document.form4.to1.options.clear;
	//document.getElementById("itemname").innerHTML="";
	//document.getElementById("itemcode").value="";
	
	//var t="$";
	var t = "";
	t=t+xmlHttp.responseText;
	//alert(t);
	
	//document.getElementById("price").innerHTML=t;
	var varCompleteStringReturned=t;

	//alert ("var");
	//var varNewLineValue=varCompleteStringReturned.split("||||");
	//alert(varNewLineValue);
	//alert(varNewLineValue.length);
	//var varNewLineLength = varNewLineValue.length;
	//alert(varNewLineLength);
	//varNewLineLength = varNewLineLength - 1;
	//alert(varNewLineLength);
	
	//for (m=0;m<=varNewLineLength;m++)
	//{
		//alert (m);
		var varNewRecordValue=varCompleteStringReturned.split("||");
		//alert(varNewRecordValue);
		//alert(varNewRecordValue.length);
		var varNewRecordLength = varNewRecordValue.length;
		//alert(varNewRecordLength);
		varNewRecordLength = varNewRecordLength - 4;
		//alert(varNewRecordLength);
		
		var k = 0;
		for (i=0;i<varNewRecordLength;i++)
		{
			var varItemCode1 = varNewRecordValue[0];
			//alert (varItemCode1);
			var varItemName1 = varNewRecordValue[1];
			//alert (varItemName1);
			var varItemMRP = varNewRecordValue[2];
			//alert (varItemName1);
			var varItemMRP = parseFloat(varItemMRP).toFixed(2);
			//alert (varItemName1);
			var varTaxName = varNewRecordValue[3];
			//alert (varItemName1);
			var varTaxPercent = varNewRecordValue[4];
			//alert (varItemName1);
			var varTaxAnum = varNewRecordValue[5];
			//alert (varItemName1);
			var varItemDescription1 = varNewRecordValue[6];
			//alert (varItemName1);
			var varItemStock1 = varNewRecordValue[7];
			//alert (varItemStock1);
			var varItemStockCount = varNewRecordValue[8];
			//alert (varItemStockCount);
			var varItemPackageAnum = varNewRecordValue[9];
			//alert (varItemStockCount);
			var varItemPackageName = varNewRecordValue[10];
			///alert (varItemPackageName);
			var varItemSalesPrice = varNewRecordValue[11];
			//alert (varItemSalesPrice);
			var varItemManufacturerName = varNewRecordValue[12];
			//alert (varItemManufacturerName);
			var varItemspmarkup = varNewRecordValue[13];
			
			if (varItemName1 == "")
			{
				//alert ("Item Code Not Found. Give Proper Code. Try Again.");
				document.getElementById("itemcode").focus();
				return false;
			}
			document.getElementById("itemname").value = varItemName1;
			document.getElementById("spmarkup").value = varItemspmarkup;
			document.getElementById("itemtaxpercent").value = varTaxPercent;
			document.getElementById("itemtaxname").value = varTaxName;
			document.getElementById("itemtaxautonumber").value = varTaxAnum;
			
			document.getElementById("itemdescription").value = varItemDescription1;
			document.getElementById("showcurrentstock1").value = varItemStockCount;
			//document.getElementById("itempackageanum").value = varItemPackageAnum;
			//document.getElementById("itempackagename").value = varItemPackageName;
			
			document.getElementById("manufacturername").value = varItemManufacturerName;
			
			///*
			//To populate the package if already entered in the master.
			//Function connected with autocomplete_package1pharmacy1.js
			
			//*/



			///*
			//To populate the package if already entered in the master.
			//Function connected with autocomplete_package1pharmacy1.js
			if (varItemManufacturerName != "")
			{
				document.getElementById('manufacturername').options.length=null; 
				//Ref: http://viralpatel.net/blogs/dynamic-combobox-listbox-drop-down-using-javascript/
				var newOption = document.createElement('option');
				newOption.text = varItemManufacturerName;
				newOption.value = varItemManufacturerName;
				newOption.selected = "selected";
				try 
				{
					document.getElementById("manufacturername").options.add(newOption, null); //Standard To Chrome and Firefox.
				}
				catch(error) 
				{
					document.getElementById("manufacturername").options.add(newOption); //Only For IE.
				}
			}
			else
			{
				document.getElementById('manufacturername').options.length=null; 
				
				//Function connected with autoitemsearch3purchase.js
				//Ref: http://viralpatel.net/blogs/dynamic-combobox-listbox-drop-down-using-javascript/
				var newOption = document.createElement('option');
				newOption.text = "MFR";
				newOption.value = "";
				newOption.selected = "selected";
				try 
				{
					document.getElementById("manufacturername").options.add(newOption, null); //Standard To Chrome and Firefox.
				}
				catch(error) 
				{
					document.getElementById("manufacturername").options.add(newOption); //Only For IE.
				}
			}
			//*/



			document.getElementById("manufacturername").focus();
			//document.getElementById("manufacturername").select();

			//document.getElementById("itemmrp").focus();
			//document.getElementById("itemmrp").select();
			
			//document.getElementById("itemquantity").focus();
			//document.getElementById("itemquantity").select();
		}
	//}
	//alert (k);
	} 
}

function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}
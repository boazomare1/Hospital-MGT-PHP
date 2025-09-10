<script language="javascript">
//This file cannot be save as .js, reason, php coding is involved. It needs to be as .php file than .js 

//window.onload = function funcCustomerDropDownSearch1() 
function funcCustomerDropDownSearch1() 
{
	//StateSuggestions function is from autocompletebuild_item1.php
	//alert("simple");
	//var oTextbox = new AutoSuggestControl(document.getElementById("customer"), new StateSuggestions()); 
	//alert(oTextbox);       
	
	var oTextbox1 = new AutoSuggestControl4(document.getElementById("itemname"), new StateSuggestions4());
	//alert(oTextbox1);       
}



</script>
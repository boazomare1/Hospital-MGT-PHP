<script language="javascript">

//This file cannot be save as .js, reason, php coding is involved. It needs to be as .php file than .js 

function funcCustomerDropDownSearch3() 
{
	//alert("simple");
	
	var oTextbox1 = new AutoSuggestControl1(document.getElementById("itemname"), new StateSuggestions1()); 
	//alert(oTextbox3);    
	var oTextbox2 = new AutoSuggestControl2(document.getElementById("depreciationledger"), new StateSuggestions2()); 
	//alert(oTextbox3);    
	var oTextbox3 = new AutoSuggestControl3(document.getElementById("accdepreciationledger"), new StateSuggestions3()); 
	//alert(oTextbox3);         
}


</script>
function insertitemcurrency()
{
	
	
	if(document.getElementById("currency").value=="")
	{
		alert("Please Select the Currency type");
		document.getElementById("currency").focus();
		return false;
	}
	if(document.getElementById("currencyamt").value=="")
	{
		alert("Please enter currency amount");
		document.getElementById("currencyamt").focus();
		return false;
	}
	if(document.getElementById("fxamount").value=="")
	{
		alert("Please enter rate");
		document.getElementById("fxamount").focus();
		return false;
	}
	if(document.getElementById("amounttot").value=="")
	{
		alert("Please enter amount");
		document.getElementById("amounttot").focus();
		return false;
	}
	
	
	var tdshowtotal1 = document.getElementById("tdShowTotal").innerHTML ;

	 tdshowtotal = tdshowtotal1.replace(/\,/g,'');
	 
	var totalamount = document.getElementById("totalamount").value ;
		
	
	var varSerialNumber41 = document.getElementById("serialnumber").value;
	var myarr = document.getElementById("currency").value;
	
	var mycur = myarr.split(",");
	var currate=mycur[0];
	var varcurrency=mycur[1];
		
	var varrefRate = document.getElementById("currencyamt").value;
	var varunits = document.getElementById("fxamount").value;
	var varamount = document.getElementById("amounttot").value;
	
	var ledgernames = document.getElementById("ledgername").value;
	var ledgercodes = document.getElementById("ledgercode").value;
	
	var cashgivenbycustomer = document.getElementById("cashgivenbycustomer").value;

	var overalamount='0.00';
		
		/*if(parseInt(varamount) > parseInt(tdshowtotal))
		{
		alert("Should not allow to pay more than total amount");
		var varreferal = document.getElementById("currency").value = '';
		var varrefRate = document.getElementById("currencyamt").value = '';
		var varunits = document.getElementById("fxamount").value = '';
		var varamount = document.getElementById("amounttot").value = '';
		
		var ledgernames = document.getElementById("ledgername").value = '';
		var ledgercodes = document.getElementById("ledgercode").value = '';
		return false;	
		}*/
	
	if (document.getElementById("billtype").value == "CASH")
	{
		//document.getElementById("totalamount").value;
		var cashpay=document.getElementById("cashgivenbycustomer").value;
		
		if(cashpay==''){
		cashpay=0.00;
		}
		
		var allcash=parseFloat(cashpay);
		if(parseFloat(allcash)>=parseFloat(totalamount))
		{
			alert("Given amount already exits the Bill amount!");
			var varreferal = document.getElementById("currency").value = '';
			var varrefRate = document.getElementById("currencyamt").value = '';
			var varunits = document.getElementById("fxamount").value = '';
			var varamount = document.getElementById("amounttot").value = '';
			
			var ledgernames = document.getElementById("ledgername").value = '';
			var ledgercodes = document.getElementById("ledgercode").value = '';
			return false;
		}
		if(cashgivenbycustomer=='')
		{	
			document.getElementById("cashgivenbycustomer").value=varamount;
			//alert(varamount);
			var balance= parseInt(totalamount )-  parseInt(varamount);	
			if(balance<=0)
			{
				balance=0;
			}
			if(parseFloat(varamount)>parseFloat(totalamount))
			{
				document.getElementById("cashgiventocustomer").value=parseFloat(varamount)-parseFloat(totalamount );
			}
		}
		else
		{	
			var overalamount= parseInt(cashgivenbycustomer)+  parseInt(varamount);			
			document.getElementById("cashgivenbycustomer").value=overalamount;
			var balance= parseInt(totalamount )-  parseInt(overalamount);
			if(balance<=0)
			{
				balance=0;
			}
			if(parseFloat(overalamount)>parseFloat(totalamount ))
			{
				document.getElementById("cashgiventocustomer").value=parseFloat(overalamount)-parseFloat(totalamount );
			}
		}
	}
	
	if (document.getElementById("billtype").value == "SPLIT")
	{
		
		//document.getElementById("totalamount").value;

		if(cashgivenbycustomer=='')
			var cashpay=document.getElementById("currencyamt").value;
		else
		var cashpay=document.getElementById("cashgivenbycustomer").value;
		
		if(cashpay==''){
		cashpay=0.00;
		}
		
		var mpaypay=document.getElementById("creditamount").value;
		var cheqpay=document.getElementById("chequeamount").value;
		var cardpay=document.getElementById("cardamount").value;
		var onlipay=document.getElementById("onlineamount").value;
		var adjustpay=document.getElementById("adjustamount").value;
		
		

		var allcash=parseFloat(cashpay)+parseFloat(mpaypay)+parseFloat(cheqpay)+parseFloat(cardpay)+parseFloat(onlipay)+parseFloat(adjustpay);
		console.log('all cash is'+allcash)
	//	alert(cashgivenbycustomer);
		if(parseFloat(allcash)>parseFloat(totalamount))
		{
			alert("Given amount already exits the Bill amount!");
			var varreferal = document.getElementById("currency").value = '';
			var varrefRate = document.getElementById("currencyamt").value = '';
			var varunits = document.getElementById("fxamount").value = '';
			var varamount = document.getElementById("amounttot").value = '';
			
			var ledgernames = document.getElementById("ledgername").value = '';
			var ledgercodes = document.getElementById("ledgercode").value = '';
			return false;
		}
		if(cashgivenbycustomer=='')
		{	
			
			document.getElementById("cashgivenbycustomer").value=varamount;
			//document.getElementById("cashamount").value=varamount;
			//alert(varamount);
			var balance= parseInt(totalamount )-  parseInt(allcash);	
		//	alert(balance);
		}
		else
		{	
			
			var overalamount= parseInt(cashgivenbycustomer)+  parseInt(varamount);		
			document.getElementById("cashgivenbycustomer").value=overalamount;
			//document.getElementById("cashamount").value=overalamount;
			var cashpay=document.getElementById("cashgivenbycustomer").value;
				if(cashpay==''){
					cashpay=0.00;
				}
			var allcash=parseFloat(cashpay)+parseFloat(mpaypay)+parseFloat(cheqpay)+parseFloat(cardpay)+parseFloat(onlipay)+parseFloat(adjustpay);
			var balance= parseInt(totalamount )-  parseInt(allcash);
			if(balance<=0)
			{
				balance=0;
			}
			if(parseFloat(allcash)>parseFloat(totalamount ))
			{
				document.getElementById("cashgiventocustomer").value=parseFloat(allcash)-parseFloat(totalamount );
			}		
		}		
	}
	/*if(cashgivenbycustomer=='')
	{	
		document.getElementById("cashgivenbycustomer").value=varamount;
		//alert(varamount);
			var balance= parseInt(totalamount )-  parseInt(varamount);

		
		
	}
	else
	{
	var overalamount= parseInt(cashgivenbycustomer)+  parseInt(varamount);
	
		document.getElementById("cashgivenbycustomer").value=overalamount;
				var balance= parseInt(totalamount )-  parseInt(overalamount);
				if(balance<=0)
				{
					balance=0;
					}

		
	}*/
	
	//var balance= parseInt(tdshowtotal )-  parseInt(cashgivenbycustomer);
	if(balance >= 0)
	{
	 	document.getElementById("balanceamt").value=balance;
		document.getElementById("tdShowTotal").innerHTML =balance;
		//alert(balance);
	}
	else
	{
		var rbalance=-balance;
		var abalance=0;
		document.getElementById("balanceamt").value=abalance;
		document.getElementById("tdShowTotal").innerHTML =abalance;
	
				document.getElementById("cashgiventocustomer").value=rbalance;
			
	/*alert("Should not allow to pay more than total amount");
	
	
	var numm=parseInt(overalamount)-parseInt(varamount);
	//alert(numm);
	document.getElementById("cashgivenbycustomer").value=numm;
	
	
	var varreferal = document.getElementById("currency").value = '';
	var varrefRate = document.getElementById("currencyamt").value = '';
	var varunits = document.getElementById("fxamount").value = '';
	var varamount = document.getElementById("amounttot").value = '';
	
	var ledgernames = document.getElementById("ledgername").value = '';
	var ledgercodes = document.getElementById("ledgercode").value = '';
	
	return false;*/
		
	}

	
	
	
	var varSerialNumber=parseInt(varSerialNumber41)+1;
	
	var n = varSerialNumber;
	//alert(n);
	
	var tr = document.createElement ('TR');
	tr.id = "idTR"+n+"";
	//alert(n+"d");
	var td1 = document.createElement ('td');
	td1.id = "serialnumber"+n+"";
	
	td1.valign = "top";
	td1.style.backgroundColor = "#FFFFFF";
	td1.style.border = "0px solid #001E6A";
	
	var text1 = document.createElement ('input');
	text1.id = "serialnumber"+n+"";
	text1.name = "serialnumber"+n+"";
	text1.type = "hidden";
	text1.size = "25";
	text1.value = varSerialNumber;
	text1.readOnly = "readonly";
	text1.style.backgroundColor = "#FFFFFF";
	text1.style.border = "0px solid #001E6A";
	text1.style.textAlign = "left";
	td1.appendChild (text1);
	
	
	var text11 = document.createElement ('input');
	text11.id = "currency["+n+"]";
	text11.name = "currency["+n+"]";
	text11.type = "text";
	text11.align = "left";
	text11.size = "32";
	text11.value = varcurrency;
	text11.readOnly = "readonly";
	text11.style.backgroundColor = "#FFFFFF";
	text11.style.border = "0px solid #001E6A";
	text11.style.textAlign = "left";
	
	td1.appendChild (text1);
	td1.appendChild (text11);
	tr.appendChild (td1);
	
	var text12 = document.createElement ('input');
	text12.id = "ledgername["+n+"]";
	text12.name = "ledgername["+n+"]";
	text12.type = "hidden";
	text12.align = "left";
	text12.size = "32";
	text12.value = ledgernames;
	text12.readOnly = "readonly";
	text12.style.backgroundColor = "#FFFFFF";
	text12.style.border = "0px solid #001E6A";
	text12.style.textAlign = "left";
	
	td1.appendChild (text12);
	
	var text13 = document.createElement ('input');
	text13.id = "ledgercode["+n+"]";
	text13.name = "ledgercode["+n+"]";
	text13.type = "hidden";
	text13.align = "left";
	text13.size = "32";
	text13.value = ledgercodes;
	text13.readOnly = "readonly";
	text13.style.backgroundColor = "#FFFFFF";
	text13.style.border = "0px solid #001E6A";
	text13.style.textAlign = "left";
	
	td1.appendChild (text13);
	
	
//	td1.appendChild (text1);
	
	//tr.appendChild (td1);
	
	var td3 = document.createElement ('td');
	td3.id = "currencyamt["+n+"]";
	td3.align = "left";
	td3.valign = "top";
	td3.style.backgroundColor = "#FFFFFF";
	td3.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text3 = document.createElement ('input');
	text3.id = "currencyamt["+n+"]";
	text3.name = "currencyamt["+n+"]";
	text3.type = "text";
	text3.size = "8";
	text3.value = varunits;
	text3.readOnly = "readonly";
	text3.style.backgroundColor = "#FFFFFF";
	text3.style.border = "0px solid #001E6A";
	text3.style.textAlign = "left";
	td3.appendChild (text3);
	tr.appendChild (td3);
	
	
	var td8 = document.createElement ('td');
	td8.id = "fxamount"+n+"";
	td8.align = "left";
	td8.valign = "top";
	td8.style.backgroundColor = "#FFFFFF";
	td8.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text8 = document.createElement ('input');
	text8.id = "fxamount["+n+"]";
	text8.name = "fxamount["+n+"]";
	text8.type = "text";
	text8.size = "8";
	text8.value = varrefRate;
	text8.readOnly = "readonly";
	text8.style.backgroundColor = "#FFFFFF";
	text8.style.border = "0px solid #001E6A";
	text8.style.textAlign = "left";
	td8.appendChild (text8);
	tr.appendChild (td8);
	
	var td7 = document.createElement ('td');
	td7.id = "amounttottd["+n+"]";
	td7.align = "left";
	td7.valign = "top";
	td7.style.backgroundColor = "#FFFFFF";
	td7.style.border = "0px solid #001E6A";
	//var text8 = document.createElement ('<input name="discountrupees'+i+'" value="'+varItemDiscountRupees+'" id="discountrupees'+i+'" readonly="readonly" style="border: 0px solid #001E6A; text-align:right" size="2" />');
	var text7 = document.createElement ('input');
	text7.id = "amounttot["+n+"]";
	text7.name = "amounttot["+n+"]";
	text7.type = "text";
	text7.size = "8";
	text7.value = varamount;
	text7.readOnly = "readonly";
	text7.style.backgroundColor = "#FFFFFF";
	text7.style.border = "0px solid #001E6A";
	text7.style.textAlign = "left";
	td7.appendChild (text7);
	tr.appendChild (td7);
	
	
	
	
	var td10 = document.createElement ('td');
	td10.id = "btndelete["+n+"]";
	td10.align = "right";
	td10.valign = "top";
	td10.style.backgroundColor = "#FFFFFF";
	td10.style.border = "0px solid #001E6A";
	
	
	var text11 = document.createElement ('input');
	text11.id = "btndelete["+n+"]";
	text11.name = "btndelete["+n+"]";
	text11.type = "button";
	text11.value = "Del";
	text11.style.border = "1px solid #001E6A";
	text11.onclick = function() { return btnDeleteClick4(n); }
	
	
	td10.appendChild (text11);
	tr.appendChild (td10);
	
	
	
	

    document.getElementById ('insertrow').appendChild (tr);
	
	var varamountadd = parseInt(document.getElementById("totalamountadd").value) + parseInt( document.getElementById("amounttot").value);
	//alert(varamountadd);
	//var i = parseInt(varSerialNumber)+parseInt(1);
	document.getElementById("serialnumber").value = parseInt(n) + 1;
	
		
	
	
	var varreferal = document.getElementById("currency").value = '';
	var varrefRate = document.getElementById("currencyamt").value = '';
	var varunits = document.getElementById("fxamount").value = '';
	var varamount = document.getElementById("amounttot").value = '';
	
	var ledgernames = document.getElementById("ledgername").value = '';
	var ledgercodes = document.getElementById("ledgercode").value = '';
	
	//funcbillamountcalc1();

document.getElementById("tdShowTotal").innerHTML=(document.getElementById("tdShowTotal").innerHTML).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	
	document.getElementById("currency").focus();
	
	window.scrollBy(0,5); 
	return true;

}

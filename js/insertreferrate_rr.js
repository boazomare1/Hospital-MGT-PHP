function insertitemr()
{
	//alert('hi');
	//alert(document.getElementById('departmentreferal').value);
	var id = document.getElementById('departmentreferal').value;
	if(id=='')
	{
		var rate='0';
	}
	else
	{
		var refer='refer'+id;
		//alert(refer);
		//alert(document.getElementById(refer).value);
		var rate = document.getElementById(refer).value;
	}
	
	
	//alert(rate);
	document.getElementById('totalr').value = rate;
		
	if(document.getElementById('total').value=='')
	{
	totalamount=0;
	}
	else
	{
	total=document.getElementById('total').value;
	totalamount=Number(total.replace(/[^0-9\.]+/g,""));
	}
	
	if(document.getElementById('total1').value=='')
	{
	totalamount1=0;
	}
	else
	{
	total1=document.getElementById('total1').value;
	totalamount1=Number(total1.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total2').value=='')
	{
	totalamount2=0;
	}
	else
	{
	total2=document.getElementById('total2').value;
	totalamount2=Number(total2.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('total3').value=='')
	{
	totalamount3=0;
	}
	else
	{
	total3=document.getElementById('total3').value;
	totalamount3=Number(total3.replace(/[^0-9\.]+/g,""));
	}
	if(document.getElementById('totalr').value=='')
	{
	totalamountr=0;
	}
	else
	{
	totalr=document.getElementById('totalr').value;
	totalamountr=Number(totalr.replace(/[^0-9\.]+/g,""));
	}
	
	
	
	grandtotal= parseFloat(totalamount)+parseFloat(totalamount1)+parseFloat(totalamount2)+parseFloat(totalamount3)+parseFloat(totalamount4)+parseFloat(totalamountr);
	
	document.getElementById("total4").value=formatMoney(grandtotal) ;
	
	

}



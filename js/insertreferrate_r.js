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
	document.getElementById('totalr').value = formatMoney(rate);
		document.getElementById('tr').value = rate;
	if(document.getElementById('t1').value=='')
	{
	totalamount=0;
	}
	else
	{
	totalamount=document.getElementById('t1').value;
	}
	
	if(document.getElementById('t2').value=='')
	{
	totalamount1=0;
	}
	else
	{
	totalamount1=document.getElementById('t2').value;
	}
	if(document.getElementById('t3').value=='')
	{
	totalamount2=0;
	}
	else
	{
	totalamount2=document.getElementById('t3').value;
	}
	if(document.getElementById('t4').value=='')
	{
	totalamount3=0;
	}
	else
	{
	totalamount3=document.getElementById('t4').value;
	}
	if(document.getElementById('t6').value=='')
	{
	totalamountr=0;
	}
	else
	{
	totalamountr=document.getElementById('t6').value;
	}
	
	
	
	grandtotal= parseFloat(totalamount)+parseFloat(totalamount1)+parseFloat(totalamount2)+parseFloat(totalamount3)+parseFloat(totalamount4)+parseFloat(totalamountr);
	
	document.getElementById("total4").value=formatMoney(grandtotal);
	document.getElementById("gt").value=grandtotal;
	

}



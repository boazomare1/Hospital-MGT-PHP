function insertitemr()
{
	//alert('hi');
	//alert(document.getElementById('departmentreferal').value);
	var id = document.getElementById('departmentreferal').value;
	if(id=='')
	{
		var rate='0.00';
	}
	else
	{
		var refer='refer'+id;
		//alert(refer);
		//alert(document.getElementById(refer).value);
		var rate = document.getElementById(refer).value;
	}
	if(document.getElementById('ancfreerefer').checked == true)
	{
		rate = '0.00';
	}
	
	//alert(rate);
	document.getElementById('totalr').value = rate;
		
	if(document.getElementById('total').value=='')
	{
	totalamount=0;
	}
	else
	{
	totalamount=document.getElementById('total').value;
	}
	
	if(document.getElementById('total1').value=='')
	{
	totalamount1=0;
	}
	else
	{
	totalamount1=document.getElementById('total1').value;
	}
	if(document.getElementById('total2').value=='')
	{
	totalamount2=0;
	}
	else
	{
	totalamount2=document.getElementById('total2').value;
	}
	if(document.getElementById('total3').value=='')
	{
	totalamount3=0;
	}
	else
	{
	totalamount3=document.getElementById('total3').value;
	}
	if(document.getElementById('totalr').value=='')
	{
	totalamountr=0;
	}
	else
	{
	totalamountr=document.getElementById('totalr').value;
	}
	
	
	
	grandtotal= parseFloat(totalamount)+parseFloat(totalamount1)+parseFloat(totalamount2)+parseFloat(totalamount3)+parseFloat(totalamount4)+parseFloat(totalamountr);
	
	document.getElementById("total4").value=grandtotal.toFixed(2);
	
	if(id == '4')
	{
	funcancfreeShowView();
	}
	else
	{
	funcancfreeHideView();
	}

}
function funcancfreeShowView()
{
  if (document.getElementById("ancfree") != null) 
     {
	 document.getElementById("ancfree").style.display = 'none';
	}
	if (document.getElementById("ancfree") != null) 
	  {
	  document.getElementById("ancfree").style.display = '';
	 }
}

function funcancfreeHideView()
{		
 if (document.getElementById("ancfree") != null) 
	{
	document.getElementById("ancfree").style.display = 'none';
	}	
}


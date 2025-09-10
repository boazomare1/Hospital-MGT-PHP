function disableEnterKey(e)
{

	//alert (document.activeElement.name); //To get the current active element.
	
	///*
	if (document.activeElement.name != "itemdescription") //To allow multiple lines, enter key enabled.
	{
	if (document.activeElement.name != "itemdescription1") //To allow multiple lines, enter key enabled.
	{
	if (document.activeElement.name != "itemdescription2") //To allow multiple lines, enter key enabled.
	{
	if (document.activeElement.name != "itemdescription3") //To allow multiple lines, enter key enabled.
	{
	if (document.activeElement.name != "itemdescription4") //To allow multiple lines, enter key enabled.
	{
	if (document.activeElement.name != "itemdescription5") //To allow multiple lines, enter key enabled.
	{
	if (document.activeElement.name != "itemdescription6") //To allow multiple lines, enter key enabled.
	{
	if (document.activeElement.name != "itemdescription7") //To allow multiple lines, enter key enabled.
	{
	if (document.activeElement.name != "itemdescription8") //To allow multiple lines, enter key enabled.
	{
	if (document.activeElement.name != "itemdescription9") //To allow multiple lines, enter key enabled.
	{
	if (document.activeElement.name != "itemdescription10") //To allow multiple lines, enter key enabled.
	{
	if (document.activeElement.name != "deliveryaddress") //To allow multiple lines, enter key enabled.
	{
	//*/
			//alert ("Back Key Press");
		
			var evt = e || window.event; 
			var key = evt.keyCode;
			//alert (key);
			if(key == 13) // if enter key press
			{
				//alert ("Enter Key Press");
				return false;
			}

			/*
			if (event.keyCode==8) 
			{
				event.keyCode=0; 
				return event.keyCode 
				return false;
			}
			*/
			
			/*
			var key;
			if(window.event)
			{
				key = window.event.keyCode;     //IE
			}
			else
			{
				key = e.which;     //firefox
			}
			
			alert (key);
			if(key == 13) // if enter key press
			{
				//alert ("Enter Key Press2");
				return false;
			}
			else
			{
				return true;
			}
			//*/
	///*
	}
	}
	}
	}
	}
	}
	}
	}
	}
	}
	}
	}
	//*/
	
	//return false;

}





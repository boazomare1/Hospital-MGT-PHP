function addopenentry(){
	varaccountsub=$('#accountsub').val();
	varaccountsubno=$('#accountsubno').val();
	varaccountname=$('#accountname').val();
	varaccountid=$('#accountid').val();
	varaccountanum=$('#accountanum').val();
	vardramount=$('#dramount').val();
	varcramount=$('#cramount').val();
	if(varaccountid!='' && (vardramount !='' || varcramount !=''))
	{
							
	if(vardramount != '' && varcramount !='')
	{
		alert("You can only add Either Credit or Debit amount for an Account");
		return false;
	}
	if(vardramount != '')
	{
		varcramount=0.00;
	}
	if(varcramount != '')
	{
		vardramount=0.00;
	}
	var sno = $('#serialnumber').val();
	var appendledger = '';
		appendledger = appendledger+'<tr id="idTRI'+sno+'" class="tbpad">';
		appendledger = appendledger+'<td id="idTDI'+sno+'" align="left"><input id="serialnumberentries'+sno+'" name="serialnumberentries'+sno+'" type="hidden" align="left" size="2" value="'+sno+'" readonly="">';
		appendledger = appendledger+'<input class="accountsub" type="text" name="accountsub[]" id="accountsub'+sno+'" value="'+varaccountsub+'" readonly  size="30"><input id="accountsubno'+sno+'" name="accountsubno[]" value="'+varaccountsubno+'" readonly type="hidden" align="left"></td>';
		appendledger = appendledger+'<td id="idTDJ'+sno+'" align="left"><input id="accountname'+sno+'" value="'+varaccountname+'" readonly  class="accountname" name="accountname[]" type="text" align="left" size="50"><input id="accountanum'+sno+'" name="accountanum[]" value="'+varaccountanum+'" readonly type="hidden" align="left" size="50">';
		appendledger = appendledger+'</td><td align="left"><input id="accountid'+sno+'" value="'+varaccountid+'" readonly  name="accountid[]" type="text" align="left" size="15">';
		appendledger = appendledger+'</td>';
		appendledger = appendledger+'<td align="right"><input onchange="funcaltotal()" id="cramount'+sno+'" name="cramount[]" value="'+varcramount+'" readonly type="text"   align="right" size="12" onBlur="addcommas(this.id)"  onKeyDown="return numbervaild(event)" style="text-align:right; font-weight:bold; background-color: transparent; border:none; color:#FF0000" ></td>';
		appendledger = appendledger+'<td align="right"><input onchange="" id="dramount'+sno+'" name="dramount[]" type="text" value="'+vardramount+'" readonly align="right" size="12" onBlur="addcommas(this.id);funcaltotal();"  onKeyDown="return numbervaild(event)" style="text-align:right; font-weight:bold; background-color: transparent; border:none; color:#FF0000" ></td>';
		appendledger = appendledger+'<td align="right"><input type="button" value="Del" onClick="return btnDeleteClickindustry('+sno+')"></td>';
		appendledger = appendledger+'</tr>';
		//alert(appendledger);
		$("#maintableledger").append(appendledger);
		$('#accountsub').val('');
		$('#accountsubno').val('');
		$('#accountname').val('');
		$('#accountid').val('');
		$('#accountanum').val('');
		$('#dramount').val('');
		$('#cramount').val('');
		$('#accountname').attr('disabled','disabled');
		$('#dramount').attr('disabled','disabled');
		$('#cramount').attr('disabled','disabled');
		$('#serialnumber').val(parseInt(sno)+1);
		funcaltotal();	
	}
	else
	{
		alert("Please Fill the proper account and also one of the two amounts.");
	}
	 }
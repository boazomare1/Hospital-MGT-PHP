<?php

session_start();

//include ("includes/loginverify.php");

include ("db/db_connect.php");



$updatedatetime = date("Y-m-d H:i:s");

$username = $_SESSION["username"];



if (isset($_REQUEST["item"])) { $itemcode = $_REQUEST["item"]; } else { $itemcode = ""; }



if(isset($_REQUEST["cnfform"]) && $_REQUEST["cnfform"]=='cnfform' && $_REQUEST["item"]!=''){

$suppliercode = $_REQUEST["supcode1"];

$itemcode = $_REQUEST["item"];

$st = 0;

	if(count($suppliercode)>0){

		foreach($suppliercode as $k=>$v){

             $suppliercodes = $suppliercode[$k];

			 $rates = $_POST['rate1'][$k];
			 
			 $tat = $_POST['tat1'][$k];

			 $supautocodes = $_POST['supautocode'][$k];

			 

			 $chkSql = "select * from rad_supplierlink where suppliercode='$suppliercodes' and itemcode='$itemcode' and supplier_autoid='$supautocodes' and status!='deleted'";

			 $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $chkSql) or die ("Error in chkSql".mysqli_error($GLOBALS["___mysqli_ston"]));

			 $numSup = mysqli_num_rows($exec1);

			 if($numSup==0){ 

				mysqli_query($GLOBALS["___mysqli_ston"], "insert into rad_supplierlink(itemcode,suppliercode,rate,updateddate,username,supplier_autoid,tat)values('$itemcode','$suppliercodes','$rates','$updatedatetime','$username','$supautocodes','$tat')") or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				 $st = 1;

			 }

			 

		}

        header("location:popup_radmapmultiple.php?item=$itemcode&st=1");

		exit;

	}

}



if(isset($_REQUEST["cnfform1"]) && $_REQUEST["cnfform1"]=='cnfform1' && $_REQUEST["item"]!=''){

$suppliercode = $_REQUEST["sup_auto2"];

$st = 0;

	if(isset($_POST['fav_supplier']))

	{

	  $fav = $_POST['fav_supplier'];

	}



	if(count($suppliercode)>0){

		foreach($suppliercode as $k=>$v){

             $suppliercodes = $suppliercode[$k];

			 $rates = $_POST['rate2'][$k];
			 $tat = $_POST['tat2'][$k];



			 $chkSql = "select * from rad_supplierlink where auto_number='$suppliercodes'";

			 $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $chkSql) or die ("Error in chkSql".mysqli_error($GLOBALS["___mysqli_ston"]));

			 $numSup = mysqli_num_rows($exec1);

			 if($numSup>0){ 

				 if($fav==$suppliercodes)

				    mysqli_query($GLOBALS["___mysqli_ston"], "update rad_supplierlink set rate='$rates',fav_supplier='1',tat='$tat' where auto_number='$suppliercodes'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				 else

					 mysqli_query($GLOBALS["___mysqli_ston"], "update rad_supplierlink set rate='$rates',fav_supplier='0',tat='$tat' where auto_number='$suppliercodes'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				 $st = 2;

			 }

			 

		}

        header("location:popup_radmapmultiple.php?item=$itemcode&st=2");

		exit;

	}

}



if(isset($_REQUEST["cnfform2"]) && $_REQUEST["cnfform2"]=='cnfform2' && $_REQUEST["item"]!='' && $_REQUEST["id"]!=''){

$id = $_REQUEST["id"];

$itemcode = $_REQUEST["item"];

$st = 0;

	

			 $chkSql = "select * from rad_supplierlink where auto_number='$id'";

			 $exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $chkSql) or die ("Error in chkSql".mysqli_error($GLOBALS["___mysqli_ston"]));

			 $numSup = mysqli_num_rows($exec1);

			 if($numSup>0){ 

				mysqli_query($GLOBALS["___mysqli_ston"], "delete from rad_supplierlink where auto_number='$id'") or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				header("location:popup_radmapmultiple.php?item=$itemcode&st=3");

		        exit;

			 }



}



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

$errmsg ='';

if ($st == '1')

{

	$errmsg = "Success.  Insert Completed.";

}

elseif ($st == '2')

{

	$errmsg = "Success.  Update Completed.";

}

elseif ($st == '3')

{

	$errmsg = "Success.  Delete Completed.";

}

?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<style type="text/css">

<!--

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

-->

</style>



<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />  

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js" type="text/javascript"></script>

<link href="js/jquery-ui.css" rel="stylesheet">



<script language="javascript">





function validatenumerics(key) {

   var keycode = (key.which) ? key.which : key.keyCode;

   if (keycode != 46 && keycode > 31 && (keycode < 48 || keycode > 57)) {

	   return false;

   }

   else return true;

}



$(function() {

    $("#supplier").autocomplete({

        source: "ajax_suppliersearch.php?RandomKey="+Math.random(),

		minLength: 2,

		dataType: 'json',

		select: function( event, ui ) {

            event.preventDefault();

            $("#supplier").val(ui.item.name);

			$("#supname").val(ui.item.name);

			$("#supcode").val(ui.item.id);

			$("#sup_autocode").val(ui.item.auto_number);

			document.getElementById("rate").readOnly = false;
			
			document.getElementById("tat").readOnly = false;

        },

	    open: function( event, ui ) {

			$("#supcode").val('');

			$("#supname").val('');

			$("#rate").val('');

			$("#sup_autocode").val('');

			document.getElementById("rate").readOnly = true;  
			
			document.getElementById("tat").readOnly = true;
	   }

    });

});



function addSupplier(){

   

   if($("#supcode").val()==''){

    alert("please select a supplier");

	document.getElementById("supplier").focus();

	return false;

   }

   if($("#rate").val()==''){

    alert("please enter the rate");

	document.getElementById("rate").focus();

	return false;

   }



   var itemcode = $("#supcode").val() ;

   var item_autocode = $("#sup_autocode").val() ;

   var itemrate = $("#rate").val() ;

   var itemname = $("#supname").val();

	var tat = $("#tat").val() ;

    if($("#idTR"+item_autocode).length) {

	   alert("Supplier already in list");

       $("#supcode").val('');

	   $("#sup_autocode").val('');

	   $("#supname").val('');

	   $("#supplier").val('');

	   $("#rate").val('');

	   document.getElementById("rate").readOnly = true; 

	   return false;

	}else if($("#trEx"+item_autocode).length) {

	   alert("Supplier already mapped");

       $("#supcode").val('');

	   $("#sup_autocode").val('');

	   $("#supname").val('');

	   $("#supplier").val('');

	   $("#rate").val('');

	   document.getElementById("rate").readOnly = true; 

	   return false;

	}



    var tr = document.createElement ('tr');

	tr.id = "idTR"+item_autocode+"";

	tr.size = "40";

	

	var td1 = document.createElement ('td');

	td1.id = "sup-"+item_autocode+"";

	

	td1.valign = "top";

	td1.style.backgroundColor = "#CCCCCC";

	td1.style.border = "0px solid #001E6A";



	var text11 = document.createElement ('input');

	text11.id = "sup"+item_autocode+"";

	text11.name = "sup[]";

	text11.type = "text";

	text11.align = "left";

	text11.size = "50";

	text11.value = itemname;

	text11.readOnly = "readonly";

	text11.style.backgroundColor = "#CCCCCC";

	text11.style.border = "0px solid #001E6A";

	text11.style.textAlign = "left";



	var text111 = document.createElement ('input');

	text111.id = "supcode1"+item_autocode+"";

	text111.name = "supcode1[]";

	text111.type = "hidden";

	text111.align = "left";

	text111.size = "50";

	text111.value = itemcode;

	text111.readOnly = "readonly";

	text111.style.backgroundColor = "#CCCCCC";

	text111.style.border = "0px solid #001E6A";

	text111.style.textAlign = "left";



	td1.appendChild (text11);

	td1.appendChild (text111);



	var text111 = document.createElement ('input');

	text111.id = "supautocode"+item_autocode+"";

	text111.name = "supautocode[]";

	text111.type = "hidden";

	text111.align = "left";

	text111.size = "50";

	text111.value = item_autocode;

	text111.readOnly = "readonly";

	text111.style.backgroundColor = "#CCCCCC";

	text111.style.border = "0px solid #001E6A";

	text111.style.textAlign = "left";

	

	td1.appendChild (text111);

	tr.appendChild (td1);


	///new
	var td8 = document.createElement ('td');

	td8.id = "rate"+item_autocode+"";

	td8.align = "left";

	td8.valign = "top";

	td8.style.backgroundColor = "#CCCCCC";

	td8.style.border = "0px solid #001E6A";

	var text8 = document.createElement ('input');

	text8.id = "rate1"+item_autocode+"";

	text8.name = "rate1[]";

	text8.type = "text";

	text8.size = "8";

	text8.value = itemrate;

	text8.readOnly = "readonly";

	text8.style.backgroundColor = "#CCCCCC";

	text8.style.border = "0px solid #001E6A";

	text8.style.textAlign = "left";

	td8.appendChild (text8);

	tr.appendChild (td8);
	
	//new


	var td9 = document.createElement ('td');

	td9.id = "tat"+item_autocode+"";

	td9.align = "left";

	td9.valign = "top";

	td9.style.backgroundColor = "#CCCCCC";

	td9.style.border = "0px solid #001E6A";

	var text9 = document.createElement ('input');

	text9.id = "tat1"+item_autocode+"";

	text9.name = "tat1[]";

	text9.type = "text";

	text9.size = "8";

	text9.value = tat;

	text9.readOnly = "readonly";

	text9.style.backgroundColor = "#CCCCCC";

	text9.style.border = "0px solid #001E6A";

	text9.style.textAlign = "left";

	td9.appendChild (text9);

	tr.appendChild (td9);
	
	
	



	var td10 = document.createElement ('td');

	td10.id = "btndelete1"+item_autocode+"";

	td10.align = "right";

	td10.valign = "top";

	td10.style.backgroundColor = "#CCCCCC";

	td10.style.border = "0px solid #001E6A";



	var text11 = document.createElement ('input');

	text11.id = "btndelete1"+item_autocode+"";

	text11.name = "btndelete1"+item_autocode+"";

	text11.type = "button";

	text11.value = "Del";

	text11.style.border = "1px solid #001E6A";

	text11.onclick = function() { return btnDeleteClick1(item_autocode); }

	

	

	td10.appendChild (text11);

	tr.appendChild (td10);

	document.getElementById ('insertrow1').appendChild (tr);







   $("#supcode").val('');

   $("#supname").val('');

   $("#supplier").val('');

   $("#rate").val('');
   
   $("#tat").val('');

   $("#sup_autocode").val('');

   document.getElementById("rate").readOnly = true;

   document.getElementById("save").disabled = false;



}

function btnDeleteClick1(delID1)

{

    

	var varDeleteID1 = delID1;

	var fRet4; 

	fRet4 = confirm('Are You Sure Want To Delete This Entry?'); 

	if (fRet4 == false)

	{

		return false;

	}

	

	var child1 = document.getElementById('idTR'+varDeleteID1); //tr name

    var parent1 = document.getElementById('insertrow1'); // tbody name.

	document.getElementById ('insertrow1').removeChild(child1);

	

	var child1= document.getElementById('idTRaddtxt'+varDeleteID1);  //tr name

    var parent1= document.getElementById('insertrow1'); // tbody name.

	if (child1 != null) 

	{

		document.getElementById ('insertrow1').removeChild(child1);

	}



	if($("#insertrow1 tr").length > 0)

	{

		

	}

	else

	{

		document.getElementById("save").disabled = true;

	}



	

}



function valid(){

	var r = confirm("Do you want Save?");

	if (r == true) {

	  return true;

	}else

      return false;

}

function valid2(){

	var r = confirm("Do you want Update?");

	if (r == true) {

	  return true;

	}else

      return false;

}



function del(id,item){

	var r = confirm("Do you want Delete?");

	if (r == true) {

	  window.location='popup_radmapmultiple.php?cnfform2=cnfform2&item='+item+'&id='+id;

	}else

      return false;

}

</script>



<body >

<form name='form1' id='form1' action='popup_radmapmultiple.php?item=<?php echo $itemcode;?>' method='post' onSubmit="return valid();">



<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

    <tbody>

	<?php

	if($itemcode!=''){

	$query1 = "select itemcode,itemname,rateperunit from master_radiology where itemcode ='".$itemcode."' and status <> 'deleted' ";

	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

	$numLab = mysqli_num_rows($exec1);

	if($numLab>0){ 

	$res1 = mysqli_fetch_array($exec1);



	?>

	  <?php if ($errmsg != '') { ?>

		 <tr>

			<td  align="center" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#CBDBFA'; } ?>" class="bodytext3"><?php echo $errmsg;?></td>

			

		  </tr>

		<?php } ?>

      <tr bgcolor="#011E6A">

        <td width="20%" bgcolor="#CCCCCC" class="bodytext3"><strong>Add Suppliers for "<?php echo $res1['itemname'];?>(<?php echo $res1['itemcode'];?>)"</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Rate "<?php echo number_format($res1['rateperunit'],2);?>"</strong></td>

      </tr>

      <tr>

        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">

		<input type='hidden' name="supcode" id="supcode"  />

		<input type='hidden' name="sup_autocode" id="sup_autocode"  />

		<input type='hidden' name="supname" id="supname"  />

		<strong>Supplier : </strong><input type='text' name="supplier" id="supplier"  autocomplete="off" size="35" /> &nbsp;

		<strong>Rate : </strong><input type='text' name="rate" id="rate" size="8" readonly onKeyPress="return validatenumerics(event);"/>&nbsp;

		<strong>TAT : </strong><input type='text' name="tat" id="tat" size="8" readonly onKeyPress="return validatenumerics(event);"/>

        <input type="button" name="add" value="Add" style="border: 1px solid #001E6A" onClick="return addSupplier();"/></td>

      </tr>

	  <tr >

		<td>

		  <table cellpadding="4" cellspacing="0" id="insertrow1" bordercolor="#666666" border='0'  >

		  </table>

		</td>

	  </tr>

	  <tr >

		<td  align='center'>

		  <input type='hidden' name="itemcode" id="itemcode"  value='<?php echo $itemcode;?>' />

		  <input type='hidden' name="cnfform" id="cnfform" value='cnfform' />

		  <input type='submit' name='save' id='save' value='Save' disabled>

		  

		</td>

	  </tr>

	  <tr >

		<td>&nbsp;

		 

		</td>

	  </tr>



	  <?php } else { ?>



	  <tr >

        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3" style='red' align='center'><strong>Invalid item code.</strong></td>

      </tr>



	  <?php }

      }else {  ?>

       <tr >

        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3" style='red' align='center'><strong>Invalid access.</strong></td>

      </tr>

      <?php

	  }

	  ?>

    </tbody>

</table>

</form>

<?php

$query2 = "select a.auto_number as id,a.fav_supplier as fav_supplier,a.supplier_autoid as supplier_autoid,a.suppliercode as suppliercode,a.rate as rate,a.tat as tat,b.accountname as name  from rad_supplierlink as a join master_accountname as b on a.suppliercode=b.id and a.supplier_autoid = b.auto_number where  a.itemcode='$itemcode' and a.status <> 'deleted' ";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$numLab1 = mysqli_num_rows($exec2);

if($numLab1>0){ 

?>

<form name='form2' id='form2' action='popup_radmapmultiple.php?item=<?php echo $itemcode;?>' method='post' onSubmit="return valid2();">

<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

    <tr bgcolor="#011E6A">

		<td bgcolor="#CCCCCC" class="bodytext3" colspan='7'>

		  <strong>Mapped Suppliers for "<?php echo $res1['itemname'];?>(<?php echo $res1['itemcode'];?>)"</strong>

		</td>

	</tr>

	<tr bgcolor="#011E6A">

		<td width="4%" bgcolor="#CCCCCC" class="bodytext3"><div><strong>Sno</strong></div></td>

		<td width="15%" bgcolor="#CCCCCC" class="bodytext3"><strong>Supplier Code</strong></td>

		<td width="14%" bgcolor="#CCCCCC" class="bodytext3"><strong>Supplier Name</strong></td>

		<td width="24%" bgcolor="#CCCCCC" class="bodytext3"><strong>Rate</strong></td>
		
		<td width="14%" bgcolor="#CCCCCC" class="bodytext3"><strong>TAT</strong></td>

		<td width="4%" bgcolor="#CCCCCC" class="bodytext3"><strong>Fav.</strong></td>

		<td width="4%" bgcolor="#CCCCCC" class="bodytext3"><strong>Action</strong></td>

	  </tr>

	  <?php

	 $colorloopcount = 0;

	 while ($res2 = mysqli_fetch_array($exec2))

	{

		 $colorloopcount = $colorloopcount + 1;

		 $showcolor = ($colorloopcount & 1); 

		if ($showcolor == 0)

		{

			$colorcode = 'bgcolor="#CBDBFA"';

		}

		else

		{

			$colorcode = 'bgcolor="#CBDBFA"';

		}

	?>

	<tr <?php echo $colorcode; ?> id='trEx<?php echo $res2['supplier_autoid']; ?>'>

		<td align="left" valign="top"   class="bodytext3"><div align="center">

		<?php echo $colorloopcount; ?> <input type='hidden' id='sup_auto2<?php echo $res2['id']; ?>' name='sup_auto2[]' value='<?php echo $res2['id']; ?>' size='8'>

		</div></td>

		<td align="left" valign="top"  class="bodytext3"><?php echo $res2['suppliercode']; ?> </td>

		<td align="left" valign="top"  class="bodytext3"><?php echo $res2['name']; ?> </td>

		<td align="left" valign="top"  class="bodytext3"><input type='text' id='rate2<?php echo $res2['supplier_autoid']; ?>' name='rate2[]' value='<?php echo $res2['rate']; ?>' size='8' onKeyPress="return validatenumerics(event);"></td>
		
		
		<td align="left" valign="top"  class="bodytext3"><input type='text' id='tat2<?php echo $res2['tat']; ?>' name='tat2[]' value='<?php echo $res2['tat']; ?>' size='8' onKeyPress="return validatenumerics(event);"></td>



		<td align="left" valign="top"  class="bodytext3"><input type="radio" name="fav_supplier" id="fav_supplier" value="<?php echo $res2['id']; ?>" <?php if($res2['fav_supplier']==1) echo 'checked'; else ''; ?>></td>



		<td align="left" valign="top"  class="bodytext3"><a href='javascript:return false;' onclick='return del("<?php echo $res2['id']; ?>","<?php echo $res1['itemcode'];?>");'>Delete</a></td>

	 </tr>

	 <?php

	}

      ?>

	 <tr bgcolor="#011E6A">

		<td width="4%" bgcolor="#CCCCCC" class="bodytext3"></td>

		<td width="7%" bgcolor="#CCCCCC" class="bodytext3"></td>

		<td width="14%" bgcolor="#CCCCCC" class="bodytext3"></td>

		<td width="24%" bgcolor="#CCCCCC" class="bodytext3"></td>

		<td width="4%" bgcolor="#CCCCCC" class="bodytext3"></td>
		
		<td width="4%" bgcolor="#CCCCCC" class="bodytext3"></td>

		<td width="4%" bgcolor="#CCCCCC" class="bodytext3">

		  <input type='hidden' name="cnfform1" id="cnfform1" value='cnfform1' />

		  <input type='submit' name='update' id='update' value='Update'></td>

	  </tr>

	

 </tbody>

</table>

</form>

<?php

}

?>

</body>


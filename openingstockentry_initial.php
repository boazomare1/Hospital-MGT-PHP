<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");

//echo $menu_id;
include ("includes/check_user_access.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

 $username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$docno = $_SESSION['docno'];

$updatetime = date('H:i:s');

$updatedate = date('Y-m-d H:i:s');


 $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';

 

 $query233 = "select * from master_location where locationcode='$locationcode'";

$exec233 = mysqli_query($GLOBALS["___mysqli_ston"], $query233) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res233 = mysqli_fetch_array($exec233);

$location = $res233['locationname'];



 $query23 = "select * from master_employee where username='$username'";

$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res23 = mysqli_fetch_array($exec23);

 $res7locationanum = $res23['location'];

 



$res7storeanum = $res23['store'];



$query75 = "select * from master_store where auto_number='$res7storeanum'";

$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res75 = mysqli_fetch_array($exec75);

 $store = $res75['store'];





if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if ($cbfrmflag1 == 'cbfrmflag1')

{}



?>

<?php

$query3 = "select * from master_company where companystatus = 'Active'";

$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

$res3 = mysqli_fetch_array($exec3);

$paynowbillprefix = 'OPS-';

$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select * from openingstock_entry order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["billnumber"];

$billdigit=strlen($billnumber);

if ($billnumber == '')

{

	$billnumbercode ='OPS-'.'1';

	$openingbalance = '0.00';

}

else

{

	$billnumber = $res2["billnumber"];

	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);

	//echo $billnumbercode;

	$billnumbercode = intval($billnumbercode);

	$billnumbercode = $billnumbercode + 1;



	$maxanum = $billnumbercode;

	

	

	$billnumbercode = 'OPS-'.$maxanum;

	$openingbalance = '0.00';

	//echo $companycode;

}

?>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="js/jquery-ui.js" type="text/javascript"></script>
<link href="js/jquery-ui.css" rel="stylesheet">
<link href="css/autocomplete.css" rel="stylesheet"/>
<script>



//ajax function to get store for corrosponding location

function storefunction(loc)

{

	var username=document.getElementById("username").value;

	

var xmlhttp;



if (window.XMLHttpRequest)

  {// code for IE7+, Firefox, Chrome, Opera, Safari

  xmlhttp=new XMLHttpRequest();

  }

else

  {// code for IE6, IE5

  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

  }

xmlhttp.onreadystatechange=function()

  {

  if (xmlhttp.readyState==4 && xmlhttp.status==200)

    {

    document.getElementById("store").innerHTML=xmlhttp.responseText;

    }

  }

xmlhttp.open("GET","ajax/ajaxstore.php?loc="+loc+"&username="+username,true);

xmlhttp.send();



	}



function funcOnLoadBodyFunctionCall()

{





	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php

	

	 //To handle ajax dropdown list.

	//funcCustomerDropDownSearch4();

	//funcPopupPrintFunctionCall();

	

}

function btnDeleteClick10(delID)

{

	//alert ("Inside btnDeleteClick.");

	

	//alert(pharmamount);

	var varDeleteID = delID;

	//alert (varDeleteID);

	var fRet3; 

	fRet3 = confirm('Are You Sure Want To Delete This Entry?'); 

	//alert(fRet); 

	if (fRet3 == false)

	{

		//alert ("Item Entry Not Deleted.");

		return false;

	}



	var child = document.getElementById('idTR'+varDeleteID);  //tr name

    var parent = document.getElementById('insertrow'); // tbody name.

	document.getElementById ('insertrow').removeChild(child);

	

	var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name

    var parent = document.getElementById('insertrow'); // tbody name.

	//alert (child);

	if (child != null) 

	{

		//alert ("Row Exsits.");

		document.getElementById ('insertrow').removeChild(child);

		

		

	}

	



}



function validcheck()

{

document.getElementById("savebutton").value == true;

if(document.getElementById("codevalue").value == 0)

{

alert("Please Add an Item");

document.getElementById("savebutton").value == false;

return false;

}

	if(confirm("Are You Want To Save The Record?")==false){document.getElementById("savebutton").value == false;return false;}

}

function storechk(store){

 if(store!=''){
    var loc =document.getElementById("location").value;

	$.ajax({
	type : "get",
	url : "store_stocktaking_chk.php?storecode="+store+"&locationcode="+loc,
	catch : false,
	success : function(data){
		if(data==1){
			alert("Stock Take in process. Transactions are Frozen.");	
			$("#store").val("");
		}
	}
	});
 }

}

$(function() {
	
$('#docnumber').autocomplete({
	source:"ajax_openingstock_entry.php?&&action=searchdocno",
	//alert(source);
	delay: 0,
	html: true, 
		select: function(event,ui){
		    $('#location').val(ui.item.location);
			$('#locationcodenew').val(ui.item.locationcode);
			$('#store').val(ui.item.storename);
			$('#storecode').val(ui.item.store);
			$('#docnumber').val(ui.item.value);
			displaydata();
			},
    }).keydown(function(){
		    $('#location').val(ui.item.location);
			$('#locationcodenew').val(ui.item.locationcode);
			$('#store').val(ui.item.storename);
			$('#storecode').val(ui.item.store);
		
	});
	

});

function selectmedicine(id)
{
$('#medicinename').autocomplete({
	source:"ajax_openingstock_entry.php?&&id="+id,
	//alert(source);
	delay: 0,
	html: true, 
		select: function(event,ui){
			
		    $('#medicinecode').val(ui.item.itemcode);
			$('#salesrate').val(ui.item.purchaseprice);
			$('#medicinename').val(ui.item.itemname);
			$('#formula').val(ui.item.formula);
			$('#rol').val(ui.item.rol);
			$('#quantity').focus();
			
			},
    }).keydown(function(){
		    
		    $('#medicinecode').val(ui.item.itemcode);
			$('#salesrate').val(ui.item.purchaseprice);
			$('#medicinename').val(ui.item.itemname);
			$('#formula').val(ui.item.formula);
			$('#rol').val(ui.item.rol);
		
	});
	
}
function checkvalidations()
{
	var medicinecode= $('#medicinecode').val();
	var docnumber=$('#docnumber').val();
	var batch= $('#batch').val();
	var action='checkvalidation';
	 $.ajax({
	type: "POST",
	url: "ajax_openingstock_entry.php",
	datatype: "json",
	async: false,
	data:{'action':action,'medicinecode' : medicinecode,'docnumber' : docnumber,'batch' : batch},
	catch : false,
	success:function(data){
	  if(data>0)
		{
    alert("Batch Already Exist");
	$('#batch').focus();
	return false;
		}
		insertitem();
	}
	
	
	});
}
function insertitem()
{
var medicinecode= $('#medicinecode').val();
var medicinename= $('#medicinename').val();
var salesrate= $('#salesrate').val();
var quantity= $('#quantity').val();
var batch= $('#batch').val();
var expirydate= $('#expirydate').val();
var insert_data='insert_data';
var docnumber=$('#docnumber').val();
var location=$('#location').val();
var locationcodenew=$('#locationcodenew').val();
var store=$('#store').val();
var storecode=$('#storecode').val();
var producttype=$('#producttype').val();

	if(quantity=="")
	{

		alert("Please enter quantity");

		document.getElementById("quantity").focus();

		return false;

	}

	if(batch=="")

	{

		alert("Please enter batch");

		document.getElementById("batch").focus();

		return false;

	}

	var varItemExpiryDate = document.getElementById("expirydate").value;

	if (varItemExpiryDate == "")

	{

		alert ("Please Enter Expiry Date.");

		document.getElementById("expirydate").focus();

		return false;

	}

	var varItemExpiryDateLength = varItemExpiryDate.length;

	var varItemExpiryDateLength = parseInt(varItemExpiryDateLength);

	if (varItemExpiryDateLength != 5)

	{

		alert ("Expiry Date Not In Format. Please Enter MM/YY Format. Length Should Be Five Characters.");

		document.getElementById("expirydate").focus();

		return false;

	}

	var varItemExpiryDateArray = varItemExpiryDate.split("/");
	var varItemExpiryDateArrayLength = varItemExpiryDateArray.length;
	if (varItemExpiryDateArrayLength != 2)
	{

		alert ("Expiry Date Not In Format. Please Enter MM/YY Format. Forward Slash Is Missing.");

		document.getElementById("expirydate").focus();

		return false;

	}

	var varItemExpiryDateMonthLength = varItemExpiryDateArray[0];

	var varItemExpiryDateMonthLength = varItemExpiryDateMonthLength.length;

	var varItemExpiryDateMonthLength = parseInt(varItemExpiryDateMonthLength);

	if (varItemExpiryDateMonthLength != 2)
	{

		alert ("Expiry Date Not In Format. Please Enter MM/YY Format. Preceding Zero Is Required Except November & December.");

		document.getElementById("expirydate").focus();

		return false;
	}

	var varItemExpiryDateYearLength = varItemExpiryDateArray[0];
	var varItemExpiryDateYearLength = varItemExpiryDateYearLength.length;
	var varItemExpiryDateYearLength = parseInt(varItemExpiryDateYearLength);

	if (varItemExpiryDateYearLength != 2)

	{

		alert ("Expiry Date Not In Format. Please Enter MM/YY Format. Simply Give Current Year In Two Digits.");

		document.getElementById("expirydate").focus();

		return false;

	}

	var varItemExpiryDateMonth = varItemExpiryDateArray[0];
	if (isNaN(varItemExpiryDateMonth))

	{

		alert ("Expiry Date Not In Format. Please Enter MM/YY Format. Month Should Be Number.");

		document.getElementById("expirydate").focus();

		return false;

	}

	var varItemExpiryDateYear = varItemExpiryDateArray[1];
	if (isNaN(varItemExpiryDateYear))

	{

		alert ("Expiry Date Not In Format. Please Enter MM/YY Format. Year Should Be Number.");

		document.getElementById("expirydate").focus();

		return false;

	}

	var varItemExpiryDateMonth = varItemExpiryDateArray[0];

	if (varItemExpiryDateMonth > 12 || varItemExpiryDateMonth == 0)
	{
		alert ("Expiry Month Should Be Between 1 And 12.");

		document.getElementById("expirydate").focus();

		return false;
	}

	var varItemExpiryDateYear = varItemExpiryDateArray[1];

	if (varItemExpiryDateYear < 20 || varItemExpiryDateYear > 50)
	{
		alert ("Expiry Year Should Be Between 2020 And 2050.");

		document.getElementById("expirydate").focus();

		return false;

	}

        $.ajax({
		type: "POST",
		url: "ajax_openingstock_entry.php",
		datatype: "json",
		async: false,
		data:{'action':insert_data,'medicinename' : medicinename,'medicinecode' : medicinecode,'salesrate' : salesrate,'quantity' : quantity,'batch' : batch,'expirydate' : expirydate,'docnumber' : docnumber,'location' : location,'locationcodenew' : locationcodenew,'store' : store,'storecode' : storecode,'producttype' : producttype},
		catch : false,
		success:function(data){
		//$("#appenddata").remove();
		$(".idTRP").remove();
		$("#presid").append(data);
		}
		
		
		});	

$("#medicinename").val('');
$("#medicinecode").val('');
$("#salesrate").val('');
$("#quantity").val('');
$("#batch").val('');
$("#expirydate").val('');
$("#formula").val('');
$("#rol").val('');
}


function btnDeleteClickitem(id,status,sno)
{
var docnumber=$('#docnumber').val();
var producttype=$('#producttype').val();
	var delete_data='delete_data';
	
	var qty=$('#qty'+sno).val();
	var batch=$('#batch'+sno).val();
	var expirydate=$('#expirydate'+sno).val();

	
	$.ajax({
		type: "POST",
		url: "ajax_openingstock_entry.php",
		datatype: "json",
		async: false,
		data:{'action':delete_data,'auto_number' : id,'producttype' : producttype,'docnumber' : docnumber,'status' : status,'qty' : qty,'batch' : batch,'expirydate' : expirydate},
		catch : false,
		success:function(data){
	   //$(this).parents('idTRP').remove();
		$(".idTRP").remove();
		$("#presid").append(data);
		}
		
		
		});	
}

function displaydata()
{

var docnumber=$('#docnumber').val();
var producttype=$('#producttype').val();
	var insert_data='insert_data';
	var medicinecode='';
	$.ajax({
		type: "POST",
		url: "ajax_openingstock_entry.php",
		datatype: "json",
		async: false,
		data:{'action':insert_data,'producttype' : producttype,'docnumber' : docnumber,'medicinecode' : medicinecode},
		catch : false,
		success:function(data){
	   //$(this).parents('idTRP').remove();
		$(".idTRP").remove();
		$("#presid").append(data);
		}
		
		
		});	
}
</script>

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

-->

</style>



<?php /*?><?php include("autocompletebuild_stockmedicine.php"); ?><?php */?>

<!--<script type="text/javascript" src="js/autosuggeststockmedicine1.js"></script>-->

<?php include("js/dropdownlist1scriptingstockmedicine.php"); ?>

<!--<script type="text/javascript" src="js/autocomplete_stockmedicine.js"></script>-->

<!--<script type="text/javascript" src="js/insertnewitem41.js"></script>-->

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<style type="text/css">

<!--

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

-->

.bal

{

border-style:none;

background:none;

text-align:right;

}

.bali

{

text-align:right;

}

</style>

</head>



<script src="js/datetimepicker_css.js"></script>



<body onLoad="return funcOnLoadBodyFunctionCall();">

<table width="101%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%">&nbsp;</td>

    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>

      &nbsp;</td>

    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860">

		

		

              <form name="cbform1" method="post" action="openingstockentry_initial.php" onSubmit="return validcheck()">

		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="8" bgcolor="#ecf0f5" class="bodytext3"><strong>Opening Stock Entry </strong></td>

              </tr>

          

<tr>


<td width="89" align="left" valign="middle"  class="bodytext3" style="font-size:15px"><strong>Doc No</strong></td>

<td width="89" align="left" valign="middle"  class="bodytext3"> <input name="docnumber" type="text" id="docnumber" value=""  autocomplete="off" placeholder="Search Docno" size"4" style="font-size:15px"></td>

</tr>

              

               <tr>

              <td align="left" valign="middle"   class="bodytext3" style="font-size:10px"><strong>Location</strong></td>

              <td   class="bodytext3"  colspan="3" >
              <input name="location" id="location" type="text" readonly  style="font-size:10px">
              <input type="hidden" name="locationcodenew" id="locationcodenew" value=""/>
             </td>

                        

        

		  <td width="54" align="left" valign="center" class="bodytext31" style="font-size:10px"><strong>Store</strong> </td>

          <td width="387" align="left" valign="center"  class="bodytext31">
                
           <input name="store" id="store" type="text" readonly style="font-size:10px">
           <input type="hidden" name="storecode" id="storecode" value=""/></td>
           
            <td width="150" align="left" valign="" class="bodytext31">Product Type</td>
            <td align="left" valign="top">
            <select name="producttype" id="producttype" onChange="selectmedicine(this.value)" >
            <option value="" selected="selected">All</option>
            <?php
			$query1 = "select * from master_categorypharmacy where status <> 'deleted' order by categoryname";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1" . mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1)) {
			$res1categoryname = $res1["categoryname"];
          
            ?>
            <option value="<?php echo $res1categoryname; ?>"><?php echo $res1categoryname; ?></option>
            <?php
            }
            ?>
            </select>
            </td>

		  </tr>

            


	  <tr id="pressid">

				   <td colspan="12" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				   <table id="presid" width="500" border="0" cellspacing="1" cellpadding="1">

                     <tr>

                       <td width="350" class="bodytext3">Medicine Name</td>

                       <td width="48" class="bodytext3">Cost Price</td>
                       
                       <td width="48" class="bodytext3">Formula</td>
                       
                       <td width="48" class="bodytext3">VOL</td>

                       <td width="120" class="bodytext3">Quantity</td>

                      <td width="48" class="bodytext3">Batch</td>

                       <td width="48" class="bodytext3">Exp Date</td>

                     </tr>
                     
              
					 <tr>

					 <div id="insertrow">					 </div></tr>

                     <tr>

					  <input type="hidden" name="serialnumber" id="serialnumber" value="1">

					  <input type="hidden" name="medicinecode" id="medicinecode" value="">

                        <td><input name="medicinename" type="text" id="medicinename" size="65" autocomplete="off"></td>

						<td><input name="salesrate" type="text" id="salesrate" size="8" style="text-align:right"  readonly></td>
                        
                        <td><input name="formula" type="text" id="formula" size="8"   readonly></td>
                        
                        <td><input name="rol" type="text" id="rol" size="8" style="text-align:right"  readonly></td>

						<td><input name="quantity" type="text" id="quantity" style="text-align:right" size="8"></td>

						<td><input name="batch" type="text" style="text-align:right" id="batch" size="8"></td>

						<td><input name="expirydate" type="text" style="text-align:right" id="expirydate" size="8"></td>

						<td><label>

                       <input type="button" name="Add" id="Add" value="Add" onClick="return checkvalidations()" class="button" >

                       </label></td>

					   </tr>

                     <input type="hidden" name="codevalue" id="codevalue" value="0">

					 <input type="hidden" name="h" id="h" value="0">

                   </table>				  </td>

			       </tr>

			  

          </tbody>

        </table>

		</form>		</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      

	  

	  </form>

    </table>

  </table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>

<script>
$(document).ready(function(){

selectmedicine();

});
</script>


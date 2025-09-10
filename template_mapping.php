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

$query1 = "select locationname, locationcode from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res1 = mysqli_fetch_array($exec1);

						

						 $res1location = $res1["locationname"];

						$res1locationanum = $res1["locationcode"];



if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if (isset($_REQUEST["locationcode"])) {  $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }

if (isset($_REQUEST["template_id"])) {  $template_id = $_REQUEST["template_id"]; } else { $template_id = ""; }

if ($cbfrmflag1 == 'cbfrmflag1')

{

/*$services = $_REQUEST['services'];

$servicescode = $_REQUEST['servicescode'];
*/
$serial = $_REQUEST['serialnumber'];

$number = $serial - 1;

for ($p=1;$p<=$number;$p++)

		{
	   

		 $medicinename=$_REQUEST['medicinename'.$p];

		$medicinename=trim($medicinename);
		
		$quantity=$_REQUEST['quantity'.$p];


		if($medicinename!="")

		{

	$medicinequery2="insert into purchase_templatelinking (template_id, itemname, quantity,username, ipaddress,date)

	values ('$template_id', '$medicinename','$quantity','$username', '$ipaddress','$updatedatetime')";

	

	$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

	}

		}

		header("location:template_purchase.php");
	

}



?>



<?php

$query23 = "select * from master_employee where username='$username'";

$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res23 = mysqli_fetch_array($exec23);

$res7locationanum = $res23['location'];



$query55 = "select * from master_location where auto_number='$res7locationanum'";

$exec55 = mysqli_query($GLOBALS["___mysqli_ston"], $query55) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res55 = mysqli_fetch_array($exec55);

$location = $res55['locationname'];



$res7storeanum = $res23['store'];



$query75 = "select * from master_store where auto_number='$res7storeanum'";

$exec75 = mysqli_query($GLOBALS["___mysqli_ston"], $query75) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

$res75 = mysqli_fetch_array($exec75);

$store = $res75['store'];

?>

<script>

function funcOnLoadBodyFunctionCall()

{



	funcCustomerDropDownSearch4();

	//funcCustomerDropDownSearch3();

	

	

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


	var deleted_itemcode = $('#medicinecode'+varDeleteID).val();
	var index = itemcodearr.indexOf(deleted_itemcode);
	if (index > -1) {
	  itemcodearr.splice(index, 1);
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

</script>

<script>

function medicinecheck()

{

if(document.cbform1.tostore.value=="")

	{

		alert("Please Select the store");

		document.cbform1.tostore.focus();

		return false;

	}



	

	

	return true;

	

}

</script>



<link href="css/bootstrap.min.css" rel="stylesheet">



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



<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 

<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>

<link href="css/autocomplete.css" rel="stylesheet">



<script>
itemcodearr = new Array();
$('document').ready(function(e) {

$('#services').autocomplete({

		

	source:'ajaxservicenamesearch.php?locationcode='+$('#locationcode').val(), 

	//alert(source);

	minLength:1,

	delay: 0,

	html: true, 

		select: function(event,ui){

			var servicescode = ui.item.itemcode;

			var varservicesname = ui.item.itemname;

			$('#servicescode').val(servicescode);

			$('#hiddenservices').val(varservicesname);

		

			//funcservicessearch7();

				

			},

    });



    

});

</script>





  <?php



//include ("autocompletebuild_services11.php");

?>

<?php //include ("js/dropdownlist1scriptingservices1.php"); ?>

<!--<script type="text/javascript" src="js/autocomplete_services1.js"></script>

<script type="text/javascript" src="js/autosuggestservices1.js"></script>

-->



<?php include ("js/dropdownlist1scriptingrequestmedicine.php"); ?>

<!--<script type="text/javascript" src="js/autosuggestrequestmedicine.js"></script> 
<script type="text/javascript" src="js/autocomplete_requestmedicine.js"></script>-->



<script type="text/javascript" src="js/insertnewitemserviceslinking.js"></script>

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

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

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

		

		

              <form name="cbform1" method="post" action="template_mapping.php">

		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

		   <tr>

              <td colspan="5" bgcolor="#ecf0f5" class="bodytext3"><strong> Template Linking </strong></td>

               <td colspan="3" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>

             		<?php echo $res1location; ?>

            						

						<input type="hidden" name="locationcode" id="locationcode" value="<?php echo $res1locationanum; ?>">

                  

                  </td> 

              </tr>

            

            <!--<tr>

              <td colspan="8" class="bodytext3"><strong> Select Service </strong>

                <input name="services" type="text" id="services" size="69">

			    <input type="hidden" name="servicescode" id="servicescode" value="">

			    <input name="rate3[]" type="hidden" id="rate3" readonly size="8"></td>

			   </tr>-->

          

           

	  <tr id="pressid">

				   <td colspan="15" align="left" valign="middle"  bgcolor="#ecf0f5" class="bodytext3">

				   <table id="presid" width="500" border="0" cellspacing="1" cellpadding="1">

                     <tr>

                       <td width="211" class="bodytext3">Item</td>

                      

                       <td width="55" class="bodytext3">Qty</td>

                     </tr>

					 <tr>

					 <div id="insertrow">					 </div></tr>

                     <tr>

					  <input type="hidden" name="serialnumber" id="serialnumber" value="1">

					  <input type="hidden" name="medicinecode" id="medicinecode" value="">
                      
                      <input type="hidden" name="template_id" id="template_id" value="<?php echo $template_id;?>">

                        <td><input name="medicinename" type="text" id="medicinename" size="35" autocomplete="off" onKeyDown="return StateSuggestionspharm4()" onKeyUp="return funcCustomerDropDownSearch4()"></td>

								   <input name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox" type="hidden" value="">

			  <input name="searchmedicineanum1" id="searchmedicineanum1" value="" type="hidden">

			

						<td><input type="text" name="quantity" id="quantity" size="8" /></td>

						<input name="avlquantity" type="hidden" id="avlquantity" size="8">

						

						

						<td width="224"><label>

                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem10()" class="button" style="border: 1px solid #001E6A">

                       </label></td>

					   </tr>

                     

					 <input type="hidden" name="h" id="h" value="0">

                   </table>				  </td>

			       </tr>

				    <tr>

              <td align="left" valign="middle" class="bodytext3">&nbsp;</td>

              <td align="left" valign="middle" class="bodytext3">&nbsp;</td>

              <td align="left" valign="middle" class="bodytext3">&nbsp;</td>

              <td colspan="2" align="left" valign="middle" class="bodytext3">&nbsp;</td>

              <td align="left" valign="top">			              </td>

            </tr>

			   <tr>

              <td align="left" valign="middle" class="bodytext3"></td>

              <td align="left" valign="top">&nbsp;</td>

              <td align="left" valign="top">&nbsp;</td>

              <td align="left" valign="top">&nbsp;</td>

              <td align="left" valign="top">&nbsp;</td>

              <td align="left" valign="top">

			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                  <input  style="border: 1px solid #001E6A" type="submit" value="Save" name="Submit" onClick="return medicinecheck();"/>                 </td>

            </tr>

			 <tr bgcolor="#011E6A">

                        <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>Template Linking - Existing List </strong></td>

                      </tr>

                      <tr>

                        
<td width="9%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>ID</strong></td>

                        <td width="48%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Service </strong></td>

                        <td width="9%" align="left" valign="top" bgcolor="#ecf0f5"  class="bodytext3"><strong>Edit</strong></td>

                      </tr>

                      <?php

					  $colorloopcount = '';

	    $query1 = "select * from purchase_templatelinking where recordstatus <> 'deleted' and template_id='$template_id'";

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res1 = mysqli_fetch_array($exec1))

		{

		$servicecode = $res1['template_id'];

		$servicename = $res1["itemname"];

		

		//$defaultstatus = $res1["defaultstatus"];

		

		

		$colorloopcount = $colorloopcount + 1;

		$showcolor = ($colorloopcount & 1); 

		if ($showcolor == 0)

		{

			$colorcode = 'bgcolor="#CBDBFA"';

		}

		else

		{

			$colorcode = 'bgcolor="#ecf0f5"';

		}

		  

		?>

                      <tr <?php echo $colorcode; ?>>

					                <td align="left" valign="top"  class="bodytext3"><?php echo $servicecode; ?> </td>

                                    <td align="left" valign="top"  class="bodytext3"><?php echo $servicename; ?> </td>

                        <td align="left" valign="top"  class="bodytext3">

						<a href="editserviceslinking.php?st=edit&&code=<?php echo $servicecode; ?>&&menuid=<?php echo $menu_id; ?>" style="text-decoration:none">Edit</a>						</td>

                      </tr>

                      <?php

		}

		?>

                      <tr>

                        <td align="middle" colspan="3" >&nbsp;</td>

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




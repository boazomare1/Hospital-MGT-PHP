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



if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if ($cbfrmflag1 == 'cbfrmflag1')

{

$billnumber=$_REQUEST['docnumber'];

 $storecode=$store = $_REQUEST['store'];

 include("store_stocktaking_chk1.php");
  if($num_stocktaking > 0) {
   echo "<script>alert('".$stocktake_err."');history.back();</script>";
   exit;

 }
 $get_status=$_REQUEST['get_status'];
 $remarks=$_REQUEST['remarks'];
 
if($get_status=='Reject')
{
$medicinequery2="update openingstock_dataentry set recordstatus='Rejected',actionby='$username',remarks='$remarks' where docno='$billnumber'";
$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
}
else
{

$query212 = "select itemcode,itemname,quantity,rateperunit,batchnumber,expirydate,auto_number from openingstock_data where docno='$billnumber' and recordstatus=''";

$exec212 = mysqli_query($GLOBALS["___mysqli_ston"], $query212) or die ("Error in Query212".mysqli_error($GLOBALS["___mysqli_ston"]));

while($res212 = mysqli_fetch_array($exec212))
{
$medicinecode = $res212["itemcode"];
$medicinename = $res212["itemname"];
$quantity = $res212["quantity"];
$salesrate = $res212["rateperunit"];
$batch = $res212["batchnumber"];
$expirydate = $res212["expirydate"];

$medicinename = addslashes($medicinename);

$batch = str_replace(" ","",$batch);

$batch = trim($batch);

	
			$query23 = "select * from master_itempharmacy where itemcode = '$medicinecode'";

			$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query23) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			$res23 = mysqli_fetch_array($exec23);

			$categoryname = $res23['categoryname'];

			$expirymonth = substr($expirydate, 0, 2);

			$expiryyear = substr($expirydate, 3, 2);

			$expiryday = '01';

			$expirydate = $expiryyear.'-'.$expirymonth.'-'.$expiryday;
			$itemsubtotal=$salesrate * $quantity;

		if($medicinename!="")

		{

			$querystock2 = "select fifo_code from transaction_stock where docstatus='New Batch' order by auto_number desc limit 0, 1";

			$execstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querystock2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			$resstock2 = mysqli_fetch_array($execstock2);

			$fifo_code = $resstock2["fifo_code"];

			if ($fifo_code == '')

			{		

				$fifo_code = '1';

				$querycumstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$medicinecode' and locationcode='$locationcode'";

				$execcumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querycumstock2) or die ("Error in CumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

				

				$stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,

				batchnumber, batch_quantity, 

				transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice,expirydate)

				values ('1','purchase_details','$medicinecode', '$medicinename', '$updatedatetime','1', 'OPENINGSTOCK', 

				'$batch', '$quantity', '$quantity', 

				'$quantity', '$billnumber', 'New Batch','1','1', '$locationcode','','$store', '', '$username', '$ipaddress','$updatedatetime','$updatetime','$updatedate','$salesrate','$itemsubtotal','$expirydate')";

				$stockexecquery2=mysqli_query($GLOBALS["___mysqli_ston"], $stockquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

				}

				else

				{

				$querycumstock2 = "select sum(batch_quantity) as cum_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$medicinecode' and locationcode='$locationcode'";

				$execcumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $querycumstock2) or die ("Error in CumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

				$rescumstock2 = mysqli_fetch_array($execcumstock2);

				$cum_quantity = $rescumstock2["cum_quantity"];

				$cum_quantity = $quantity+$cum_quantity;

				$fifo_code = $fifo_code + 1;				

				$queryupdatecumstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$medicinecode' and locationcode='$locationcode'";

				$execupdatecumstock2 = mysqli_query($GLOBALS["___mysqli_ston"], $queryupdatecumstock2) or die ("Error in updateCumQuery2".mysqli_error($GLOBALS["___mysqli_ston"]));

				

	$stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,

	batchnumber, batch_quantity, 

	transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice,expirydate)

	values ('$fifo_code','purchase_details','$medicinecode', '$medicinename', '$updatedatetime','1', 'OPENINGSTOCK', 

	'$batch', '$quantity', '$quantity','$cum_quantity', '$billnumber', 'New Batch','1','1', '$locationcode','','$store', '', '$username', '$ipaddress','$updatedatetime','$updatetime','$updatedate','$salesrate','$itemsubtotal','$expirydate')";

				

				$stockexecquery2=mysqli_query($GLOBALS["___mysqli_ston"], $stockquery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));				

			}

			$medicinequery1="insert into purchase_details (itemcode, itemname, entrydate,suppliername,suppliercode,

			quantity,allpackagetotalquantity,totalamount,

			username, ipaddress, rate, subtotal, companyanum,batchnumber,expirydate,location, locationcode,store,billnumber,categoryname,fifo_code)

			values ('$medicinecode', '$medicinename', '$updatedatetime', 'OPENINGSTOCK','OPSE-1',

			'$quantity','$quantity','$itemsubtotal',

			'$username', '$ipaddress', '$salesrate','$itemsubtotal','$companyanum','$batch','$expirydate','$location','$locationcode','$store','$billnumber','$categoryname','$fifo_code')"; 

			

			$execquery1=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			

			$medicinequery2="insert into openingstock_entry (itemcode, itemname, transactiondate,transactionmodule,transactionparticular,

			billnumber, quantity, 

			username, ipaddress, rateperunit, totalrate, companyanum, companyname,batchnumber,expirydate,store,location,locationcode)

			values ('$medicinecode', '$medicinename', '$updatedatetime', 'OPENINGSTOCK', 

			'BY STOCK ADD', '$billnumber', '$quantity', 

			'$username', '$ipaddress', '$salesrate','$itemsubtotal','$companyanum', '$companyname','$batch','$expirydate', '$store', '$location','$locationcode')";

			

			$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

			

			}

			}
$medicinequery2="update openingstock_dataentry set recordstatus='Approved',actionby='$username' where docno='$billnumber'";
$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
}
		header("location:openingstockentry_master.php");

}



?>

<?php

$query21 = "select store,storename,location,locationcode from openingstock_dataentry where docno='$anum' and recordstatus=''";

$exec21 = mysqli_query($GLOBALS["___mysqli_ston"], $query21) or die ("Error in Query21".mysqli_error($GLOBALS["___mysqli_ston"]));

$res21 = mysqli_fetch_array($exec21);

$store11 = $res21["store"];
$storename1 = $res21["storename"];
$location1 = $res21["location"];
$locationcode1 = $res21["locationcode"];

?>
<script src="js/jquery-1.11.1.min.js"></script>
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

	funcCustomerDropDownSearch4();

	funcPopupPrintFunctionCall();

	

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

function FuncPopup()

{

	window.scrollTo(0,0);

	document.getElementById("imgloader").style.display = "";

}  


function validcheck()

{

document.getElementById("savebutton").value == true;

 FuncPopup();

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
function Check_appstatus()
{
	 var rejap =document.getElementById("get_status").value;
	 if(rejap=='Reject')
	 {
	   $("#rejremarks").show();	 
	 }
	 else
	 {
		 $("#rejremarks").hide();
	 }
}
function delete_indv(id,sno)
{

	var delete_data='delete_indv';

	
	$.ajax({
		type: "POST",
		url: "ajax_openingstock_entry.php",
		datatype: "json",
		async: false,
		data:{'action':delete_data,'auto_number' : id},
		catch : false,
		success:function(data){
		$("#indv"+sno).hide();
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



<?php include("autocompletebuild_stockmedicine.php"); ?>

<script type="text/javascript" src="js/autosuggeststockmedicine1.js"></script>

<?php include("js/dropdownlist1scriptingstockmedicine.php"); ?>

<script type="text/javascript" src="js/autocomplete_stockmedicine.js"></script>

<script type="text/javascript" src="js/insertnewitem41.js"></script>

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
<div align="center" class="imgloader" id="imgloader" style="display:none;">

<div align="center" class="imgloader" id="imgloader1" style="display:;">

<p style="text-align:center;"><strong>Transaction in Progress <br><br> Please be patience...</strong></p>

<img src="images/ajaxloader.gif">

</div>

</div>

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

		
	

              <form name="cbform1" method="post" action="openingstockentry_view.php" onSubmit="return validcheck()">

		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="6" bgcolor="#ecf0f5" class="bodytext3"><strong>Opening Stock Entry List</strong></td>

              </tr>

          

            <tr>

               <td align="left" valign="middle"   class="bodytext3">Date</td>

               <td   class="bodytext3"  colspan="3" ><?php echo $updatedatetime; ?>

                <input name="date" type="hidden" id="date" style="border: 1px solid #001E6A;" value="<?php //echo $updatedatetime; ?>" size="8" autocomplete="off">

              </span></td>

			  

			    <td width="80" align="left" valign="center" class="bodytext31" style="font-size:15px"><strong>Doc No</strong></td>

              <td width="79" align="left" valign="middle"><span class="bodytext3" size"4" style="font-size:20px"><?php echo $anum; ?>

<input name="docnumber" type="hidden" id="docnumber"  value="<?php echo $anum; ?>"  readonly>

              </span></td>

              </tr>

              

               <tr>

              <td align="left" valign="middle"   class="bodytext3"><strong>Location</strong></td>

              <td   class="bodytext3"  colspan="3" >
              <select name="location" id="location" style="border: 1px solid #001E6A;" onChange="storefunction(this.value); ">

              <option value="<?php echo $locationcode1;?>"><?php echo $location1;?></option>

               </select></td>

                   

                  <input type="hidden" name="locationnamenew" value="<?php echo $location1; ?>">

                <input type="hidden" name="locationcodenew" value="<?php echo $locationcode1; ?>">

                <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">


                    <td width="54" align="left" valign="center" class="bodytext31"><strong>Store</strong> </td>
                    
                    <td width="387" align="left" valign="center"  class="bodytext31">
                    
                    
                    
                    <select name="store" id="store" onChange="storechk(this.value); ">
                    
                    <option value="<?php echo $store11;?>"><?php echo $storename1;?></option>
                    
                    
                    </select>
                    
                    
                    
                    </td>

		  </tr>

              

              

	  <tr id="pressid">

				   <td colspan="12" align="left" valign="middle"  bgcolor="" class="bodytext3">

				   <table id="presid" width="800" border="0" cellspacing="1" cellpadding="1">

                     <tr>
                     
                      <td width="50" class="bodytext3"><strong>Sno</strong></td>

                       <td width="600" class="bodytext3"><strong>Medicine Name</strong></td>

                       <td width="70" class="bodytext3"><strong>Cost Price</strong></td>

                       <td width="60" class="bodytext3"><strong>Quantity</strong></td>

                      <td width="50" class="bodytext3"><strong>Batch</strong></td>

                       <td width="80" class="bodytext3"><strong>Exp Date</strong></td>
                       
                       <!-- <td width="100" class="bodytext3"><strong>Action</strong></td>-->

                     </tr>
<?php
$incrm=0;
$colorloopcount=0;
$query212 = "select itemcode,itemname,quantity,rateperunit,batchnumber,expirydate,auto_number from openingstock_data where docno='$anum' and recordstatus='' order by itemcode";
$exec212 = mysqli_query($GLOBALS["___mysqli_ston"], $query212) or die ("Error in Query212".mysqli_error($GLOBALS["___mysqli_ston"]));
while($res212 = mysqli_fetch_array($exec212))
{
$incrm=$incrm+1;
$itemcode = $res212["itemcode"];
$itemname = $res212["itemname"];
$quantity = $res212["quantity"];
$rateperunit = $res212["rateperunit"];
$batchnumber = $res212["batchnumber"];
$expirydate = $res212["expirydate"];
$auto_number = $res212["auto_number"];

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
 <tr id="indv<?php echo $incrm;?>" <?php echo $colorcode; ?>>
                       <td width="50"><?php echo $incrm;?> </td>
                        
                       <td width="600"><?php echo $itemname;?> </td>

                       <td width="70" align="right"><?php echo $rateperunit;?> </td>

                       <td width="60" align="right"><?php echo $quantity;?> </td>

                      <td width="50" align="right"><?php echo $batchnumber;?> </td>

                       <td width="80" align="right"><?php echo $expirydate;?> </td>
                       
                       <!--<td width="100"><input type="button" id="delete_it<?php echo $incrm;?>" name="delete_it<?php echo $incrm;?>" onClick="delete_indv('<?php echo $auto_number;?>','<?php echo $incrm;?>')" value="Del" /> </td>-->

                     </tr>
<?php }
?>
                     

                     <input type="hidden" name="codevalue" id="codevalue" value="0">

					 <input type="hidden" name="h" id="h" value="0">

                   </table>				  </td>

			       </tr>

			   <tr>

              <td align="left" valign="middle" class="bodytext3" colspan="4">
              <select id="get_status" name="get_status" onChange="Check_appstatus()">

              <option value="Approve">Approve</option>
              <option value="Reject">Reject</option>

               </select></td>
             </td>
             
              <td colspan="2" align="left" valign="top" style="display:none" id="rejremarks">
              <textarea id="remarks" name="remarks"></textarea>
              </td>

              <td colspan="2" align="left" valign="top">

			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                  <input type="submit" value="Save" name="Submit" id="savebutton" style="font-size:20px"/> </td>

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




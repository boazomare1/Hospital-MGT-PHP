	<?php

session_start();

set_time_limit(0);

include ("includes/loginverify.php");

include ("db/db_connect.php");

date_default_timezone_set('Asia/Calcutta'); 

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$updatedate = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$errmsg = "";

$searchmedicinename = "";

$colorloopcount = '';

$openingbalance = 0;

$user = '';   

//To populate the autocompetelist_services1.js





$transactiondatefrom = date('Y-m-d', strtotime('-1 week'));

$transactiondateto = date('Y-m-d');



 $ADate1 = $transactiondatefrom;

  $ADate2 = $transactiondateto;

if (isset($_REQUEST["medicinecode"])) { $medicinecode = $_REQUEST["medicinecode"]; } else { $medicinecode = ""; }





if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

//$frmflag1 = $_REQUEST['frmflag1'];

if ($frmflag1 == 'frmflag1')

{

if (isset($_REQUEST["searchitemcode"])) { $medicinecode = $_REQUEST["searchitemcode"]; } else { $medicinecode = ""; }

//$medicinecode = $_REQUEST['medicinecode'];

if (isset($_REQUEST["itemname"])) { $searchmedicinename = $_REQUEST["itemname"]; } else { $searchmedicinename = ""; }

if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }

if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $transactiondatefrom; }

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $transactiondateto; }



}



$docno = $_SESSION['docno'];

$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

	

	 $locationname  = $res["locationname"];

	 $locationcode = $res["locationcode"];

	 $res12locationanum = $res["auto_number"];

	 

  $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';

  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

?>

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

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<style type="text/css">

<!--

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma

}

.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; }

-->

</style>

</head>



<script src="js/datetimepicker_css.js"></script>

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js" type="text/javascript"></script>

<link href="js/jquery-ui.css" rel="stylesheet">

<script src="js/datetimepicker_css.js"></script>

<script type="text/javascript" src="js/jquery-1.11.1.js"></script>

<script language="javascript">

function funcOnLoadBodyFunctionCall()

{





	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php

	

	 //To handle ajax dropdown list.

	funcCustomerDropDownSearch4();

	

	

}



function Locationcheck()

{

if(document.getElementById("location").value == '')

{

alert("Please Select Location");

document.getElementById("location").focus();

return false;

}

/*if(document.getElementById("store").value == '')

{

alert("Please Select Store");

document.getElementById("store").focus();

return false;

}*/

/*if(document.getElementById("itemname").value == '')

{

alert("Please Enter Itemname");

document.getElementById("itemname").focus();

return false;

}

*/

}





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



	$(document).ready(function(){



	$( ".edititem" ).click(function() {



		

		var clickedid = $(this).attr('id');

		var current_expdate = $('tr#'+clickedid).find("div.expdate").text();

		//alert(current_expdate)

		$('tr#'+clickedid).find("td.expirydatetd").show();

		$('tr#'+clickedid).find("td.expirydatetdstatic").hide();

		

		$('#expdate_'+clickedid).val(current_expdate);

		$('#s_'+clickedid).show();

		return false;

	})	





	$( ".saveitem" ).click(function() {



		

		var clickedid = $(this).attr('id');

		var idstr = clickedid.split('s_');

		var id = idstr[1];

		var expiry_date = $('#expdate_'+id).val();

		

		var batchnumber = $('#batchno_'+id).val();

		

		var itemcode    =  $('#itemcode_'+id).val();

		

		var itemname    =  $('#itemname_'+id).val();

		



		$.ajax({

		  url: 'ajax/ajaxcommon.php',

		  type: 'POST',

		  //async: false,

		  dataType: 'json',

		  //processData: false,    

		  data: { 

		      itemcode: itemcode, 

		      batchnumber: batchnumber,

		      expirydate:expiry_date,

		      itemname:itemname

		  },

		  success: function (data) { 

		  	//alert(data)

		  	

		  	var msg = data.msg;

		  	if(data.status == 1)

		  	{

		  		$('#expirydate_'+id).val(expiry_date);

		  		$('tr#'+id).find("td.expirydatetd").hide();

				$('tr#'+id).find("td.expirydatetdstatic").show();

				$('#uiexpirydate_'+id).text(expiry_date);

				$('#s_'+id).hide();



		  	}

		  	else

		  	{

		  		alert(msg);

		  	}

		  	

		  }

		});

		return false;

	})	

	

})



	function saveExpDate(date)

	{

		alert('date selected')

	}

</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        



<script type="text/javascript" src="js/disablebackenterkey.js"></script>



<?php //include("autocompletebuild_medicine2.php"); ?>

<script type="text/javascript" src="js/autosuggestmedicine2.js"></script>

<?php include("js/dropdownlist1scripting1stock1.php"); ?>

<!--<script type="text/javascript" src="js/autocomplete_medicine2.js"></script>-->

<script type="text/javascript" src="js/autosuggest1itemstock2.js"></script>

<script type="text/javascript" src="js/autocomplete_item1pharmacy4.js"></script>



<script src="js/datetimepicker_css.js"></script>



<body onLoad="return funcCustomerDropDownSearch1();">

<table width="110%" border="0" cellspacing="0" cellpadding="2">

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

    <td width="1%" rowspan="3">&nbsp;</td>

    <td width="2%" rowspan="3" valign="top"><?php //include ("includes/menu4.php"); ?>

      &nbsp;</td>

    <td valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td>

		

		 

			<form name="stockinward" action="expirydtupdate_duplicate.php" method="post" onKeyDown="return disableEnterKey()" onSubmit="return Locationcheck()">

	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 

            align="left" border="0">

      <tbody id="foo">

        <tr>

          <td colspan="6" bgcolor="#ecf0f5" class="bodytext31"><strong>Expiry Stock Report</strong></td>

          </tr>

        <tr>

          <td colspan="6" align="left" valign="center"  

                 bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#cbdbfa'; } ?>" class="bodytext31"><?php echo $errmsg; ?>&nbsp;</td>

          </tr>

        <script language="javascript">



function disableEnterKey()

{

	//alert ("Back Key Press");

	if (event.keyCode==8) 

	{

		event.keyCode=0; 

		return event.keyCode 

		return false;

	}

	

	var key;

	if(window.event)

	{

		key = window.event.keyCode;     //IE

	}

	else

	{

		key = e.which;     //firefox

	}

	

	if(key == 13) // if enter key press

	{

		//alert ("Enter Key Press2");

		return false;

	}

	else

	{

		return true;

	}

	



}









function deleterecord1(varEntryNumber,varAutoNumber)

{

	var varEntryNumber = varEntryNumber;

	var varAutoNumber = varAutoNumber;

	var fRet;

	fRet = confirm('Are you sure want to delete the stock entry no. '+varEntryNumber+' ?');

	//alert(fRet);

	if (fRet == false)

	{

		alert ("Stock Entry Delete Not Completed.");

		return false;

	}

	else

	{

		window.location="stockreport2.php?task=del&&delanum="+varAutoNumber;		

	}

}





</script>

		 <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Location</strong></td>

              <td  bgcolor="#FFFFFF" class="bodytext3"  colspan="5" ><select name="location" id="location" style="border: 1px solid #001E6A;" onChange="storefunction(this.value)">

              <option value="">-Select Location-</option>

                  <?php

						

						$query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

						$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res = mysqli_fetch_array($exec))

						{

						$reslocation = $res["locationname"];

						$reslocationanum = $res["locationcode"];

						?>

						<option value="<?php echo $reslocationanum; ?>" <?php if($location!='')if($location==$reslocationanum){echo "selected";}?>><?php echo $reslocation; ?></option>

						<?php 

						}

						?>

                  </select></td>

                   

                  <input type="hidden" name="locationnamenew" value="<?php echo $locationname; ?>">

                <input type="hidden" name="locationcodenew" value="<?php echo $res1locationanum; ?>">

                <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">

             

              </tr>

		<tr>

		  <td width="104" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Store</strong> </td>

          <td width="680" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31" colspan="5" >

		  <?php  $loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';

 				 $username=isset($_REQUEST['username'])?$_REQUEST['username']:'';

 				 $frmflag1=isset($_REQUEST['frmflag1'])?$_REQUEST['frmflag1']:'';

				 $store=isset($_REQUEST['store'])?$_REQUEST['store']:'';?>  

                 <select name="store" id="store">

		   <option value="">-Select Store-</option>

           <?php if ($frmflag1 == 'frmflag1')

{$loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';

$username=isset($_REQUEST['username'])?$_REQUEST['username']:'';

$query5 = "select ms.auto_number,ms.storecode,ms.store from master_employeelocation as me LEFT JOIN master_store as ms ON me.storecode=ms.auto_number where me.locationcode = '".$loc."' AND me.username= '".$username."'";

				$exec5 = mysqli_query($GLOBALS["___mysqli_ston"], $query5) or die ("Error in Query5".mysqli_error($GLOBALS["___mysqli_ston"]));

				while ($res5 = mysqli_fetch_array($exec5))

				{

				$res5anum = $res5["storecode"];

				$res5name = $res5["store"];

				//$res5department = $res5["department"];

?>

<option value="<?php echo $res5anum;?>" <?php if($store==$res5anum){echo 'selected';}?>><?php echo $res5name;?></option>

<?php }}?>

		  </select>

		  </td>

		  </tr>

        <tr>

          <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Category</strong></td>

          <td colspan="5" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><select name="categoryname" id="categoryname">

            <?php

			$categoryname = $_REQUEST['categoryname'];

			if ($categoryname != '')

			{

			?>

            <option value="<?php echo $categoryname; ?>" selected="selected"><?php echo $categoryname; ?></option>

            <option value="">Show All Category</option>

            <?php

			}

			else

			{

			?>

            <option selected="selected" value="">Show All Category</option>

            <?php

			}

			?>

            <?php

			$query42 = "select * from master_medicine where status = '' group by categoryname order by categoryname";

			$exec42 = mysqli_query($GLOBALS["___mysqli_ston"], $query42) or die ("Error in Query42".mysqli_error($GLOBALS["___mysqli_ston"]));

			while ($res42 = mysqli_fetch_array($exec42))

			{

			$categoryname = $res42['categoryname'];

			?>

            <option value="<?php echo $categoryname; ?>"><?php echo $categoryname; ?></option>

            <?php

			}

			?>

          </select></td>

        </tr>

        <tr>

          <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Search Item</strong></td>

          <td colspan="5" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">

		  <input type="hidden" name="searchitem1hiddentextbox" id="searchitem1hiddentextbox">

		  <input type="hidden" name="searchitemcode" id="searchitemcode">

		  <input name="itemname" type="text" id="itemname" style="border: 1px solid #001E6A; text-align:left" size="50" autocomplete="off" value="<?php echo $searchmedicinename; ?>">

           </td>

        </tr>

        

        

        <tr>

          <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><input type="hidden" name="medicinecode" id="medicinecode" style="border: 1px solid #001E6A; text-align:left" onKeyDown="return disableEnterKey()" value="<?php echo $medicinecode; ?>" size="10" readonly /></td>

          <td colspan="5" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">

		 <div align="left">

            <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

            <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />

            <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" />

			<input type="hidden" name="frmflag1" value="frmflag1" id="frmflag1">

          </div></td>

        </tr>



      </tbody>

    </table>

    </form>		

	</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1000"

            align="left" border="0">

          <tbody>

		  

		 

		            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></td>

              <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Code </strong></td>

              <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Category </strong></td>

              <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Item Name </strong></td>

              <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Batch No </strong></td>

              <td align="left" valign="center"  

                bgcolor="#ffffff" class="style1">Expiry Date </td>

              <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Supplier Name </strong></div></td>

              <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Quantity</strong></div></td>

			<td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Cost</strong></div></td>

                <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Action</strong></div></td>

                <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong></strong></div></td>

              </tr>

        

        

				<?php

				if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }



if ($frmflag1 == 'frmflag1')

{



if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }

if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }



?>

<?php



				$noofdays=strtotime($ADate2) - strtotime($ADate1);

				$noofdays = $noofdays/(3600*24);

				//get store for location

	$loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';

$username=isset($_REQUEST['username'])?$_REQUEST['username']:'';



$sno=0;



			$query99 = "select itemcode,expirydate,suppliername,batchnumber,itemname,sum(batch_quantity) as batch_quantity,categoryname,cost from ((select ts.itemcode as itemcode,pd.expirydate as expirydate,pd.suppliername as suppliername,ts.batchnumber as batchnumber,ts.itemname as itemname,ts.batch_quantity as batch_quantity,pd.categoryname as categoryname,ts.rate as cost from transaction_stock as ts LEFT JOIN purchase_details as pd ON ts.batchnumber = pd.batchnumber where ts.batch_stockstatus = 1 and ts.locationcode = '".$loc."' and ts.storecode ='".$store."' and pd.categoryname like '%".$categoryname."%'  and pd.companyanum = '$companyanum' and ts.itemcode ='$medicinecode' group by ts.itemcode,ts.fifo_code,ts.batchnumber )";

			
				$query99 .= " union (select ts1.itemcode as itemcode,mrn.expirydate as expirydate,mrn.suppliername as suppliername,ts1.batchnumber as batchnumber,ts1.itemname as itemname,ts1.batch_quantity as batch_quantity,mrn.categoryname as categoryname,ts1.rate as cost from transaction_stock as ts1 LEFT JOIN materialreceiptnote_details as mrn ON ts1.batchnumber = mrn.batchnumber where ts1.batch_stockstatus = 1 and ts1.locationcode = '".$loc."' and ts1.storecode ='".$store."' and mrn.categoryname like '%".$categoryname."%'  and mrn.companyanum = '$companyanum' and ts1.itemcode ='$medicinecode' group by ts1.itemcode,ts1.fifo_code,ts1.batchnumber)) res group by res.itemcode,res.batchnumber";

		//echo $query99.'<br>';exit;

			$exec99 = mysqli_query($GLOBALS["___mysqli_ston"], $query99) or die ("Error in Query99".mysqli_error($GLOBALS["___mysqli_ston"]));

		

			while ($res99 = mysqli_fetch_array($exec99))

			{
				
			    $res99itemcode = $res99['itemcode']; 

				$res99categoryname = $res99['categoryname'];

		      	$res99expirydate = $res99['expirydate'];

			$res59suppliername = $res99['suppliername'];

			$res59batchnumber = $res99['batchnumber'];

			$res59itemname = trim($res99['itemname']);

			//$batch_quantity = $res99['batch_quantity'];

			
			
			$query1 = "select sum(transaction_quantity) as currentstock from transaction_stock where  itemcode='$res99itemcode' and locationcode='$loc' and storecode = '$store' and batchnumber = '$res59batchnumber' and recorddate <= '$updatedate' and transactionfunction='1'";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res1 = mysqli_fetch_array($exec1);
				$currentstock1 = $res1['currentstock'];

				$query1 = "select sum(transaction_quantity) as currentstock from transaction_stock where  itemcode='$res99itemcode' and locationcode='$location' and storecode='$store' and batchnumber = '$res59batchnumber' and recorddate <= '$updatedate' and transactionfunction='0'";
				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$res1 = mysqli_fetch_array($exec1);
				$currentstock2 = $res1['currentstock'];

				$batch_quantity= $currentstock1-$currentstock2;
			
			
			
			

            $query2 = "select purchaseprice from master_medicine where itemcode='$res99itemcode'";

			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res2 = mysqli_fetch_array($exec2);

			$cost = $res2['purchaseprice'];



			if($cost=='')

				$cost = $res99['cost'];

			

		//	$itemcode = $res99itemcode;

		//	$batchname = $res59batchnumber;

			

	//		$locationcode=$location;

	//		$storecode=$store;

			

	//		include ('autocompletestockbatch.php');

	  //      $currentstock1 = $currentstock;

			

	//		$expirymonth = $expirymonth;

		/*	if ($expirymonth == '') $expirymonth = date('m');

			$expiryyear = $expiryyear;

			if ($expiryyear == '') $expiryyear = date('Y');

			$expirymonthyear = $expirymonth.'/'.$expiryyear;*/

			//echo $expirymonthyear;

			//echo $res1expirydate;

			//echo '<br>';

			

			/*if ($res99expirydate == $expirymonthyear)

			{

			*/

			$colorloopcount = $colorloopcount + 1;

			$showcolor = ($colorloopcount & 1); 

			if ($showcolor == 0)

			{

				//echo "if";

				$colorcode = 'bgcolor="#CBDBFA"';

			}

			else

			{

				//echo "else";

				$colorcode = 'bgcolor="#ecf0f5"';

			}

			$sno = $sno + 1;

			?>

            <tr <?php echo $colorcode; ?> id="<?php echo $sno;  ?>">

              <td class="bodytext31" valign="center"  align="left" 

                ><?php echo $sno; ?></td>

              <td align="left" valign="center"  

                 class="bodytext31"><div class="bodytext31"><?php echo $res99itemcode; ?></div></td>

              <td align="left" valign="center"  

                 class="bodytext31"><div class="bodytext31"><?php echo $categoryname;?></div></td>

              <td align="left" valign="center"  

                 class="bodytext31"><div class="bodytext31"><?php echo $res59itemname; ?></div></td>

              <td align="left" valign="center"  

                 class="bodytext31"><div class="bodytext31">

                <div align="left"><?php echo $res59batchnumber; ?>&nbsp;</div>

              </div></td>

              <td  style="display:none;" class="expirydatetd" width="123" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input class="expdatepicker" id="expdate_<?php  echo $sno;?>" name="expdate[]" style="border: 1px solid #001E6A" value=""  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('expdate_<?php  echo $sno;?>','yyyyMMdd','','','','','future')" style="cursor:pointer"/>			</td>

              <td align="left" valign="center"  

                 class="bodytext31 expirydatetdstatic"><div class="bodytext31">

                <div align="left" class="expdate" id="uiexpirydate_<?php echo $sno;?>"><?php echo $res99expirydate; ?>  &nbsp;</div>

              </div></td>

              <td align="left" valign="center"  

                 class="bodytext31"><div align="right">

                <div class="bodytext31">

                  <div align="left"><?php echo $res59suppliername; ?>&nbsp;</div>

                </div>

              </div></td>

              <td align="left" valign="center"  

                 class="bodytext31"><div class="bodytext31">

                <div align="right"><?php echo $batch_quantity; ?>&nbsp;</div>

              </div></td>

			  <td align="left" valign="center"  

                 class="bodytext31"><div class="bodytext31">

                <div align="right"><?php echo $cost; ?>&nbsp;</div>

              </div></td>

               <td align="left" valign="center"  

                 class="bodytext31"><div class="bodytext31">

                <div align="right"><a class="edititem" id="<?php echo $sno; ?>" href="" style="padding-right: 10px;">Edit</a>

                	<!-- <a style="display:none;" class="saveitem" id="s_<?php echo $sno; ?>" href="" >Save</a> -->

                </div>

               

              </div></td>

              <td align="left" valign="center"  

                 class="bodytext31"><div class="bodytext31">

                <div align="right">

                	<a style="display:none;" class="saveitem" id="s_<?php echo $sno; ?>" href="" >Update</a>

                </div>

               

              </div></td>

              </tr>

          <input type="hidden" name="batchno[]" id="batchno_<?php echo $sno;?>" value="<?php echo $res59batchnumber ?>" />

          <input type="hidden" name="itemcode[]"  id="itemcode_<?php echo $sno;?>" value="<?php echo $res99itemcode ?>" />

          <input type="hidden" name="itemname[]" id="itemname_<?php echo $sno;?>" value="<?php echo $res59itemname ?>" />

          <input type="hidden" name="expirydate[]" id="expirydate_<?php echo $sno;?>" value="<?php echo $res99expirydate ?>" />

			<?php

			//}

			

			}

			

			

			

			

		}	

			?>



            <tr>

              <td colspan="2" class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong>

                <?php //echo $totalcurrentstock1; ?>&nbsp;</strong></div></td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

			<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong>

                <?php //echo $totalitemrate1; ?>&nbsp;</strong></div></td>

				<td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              </tr>







    </table>    

  <tr>

    <td valign="top">    

  <tr>

    <td width="97%" valign="top">    

</table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>


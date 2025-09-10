<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$errmsg = "";





$docno = $_SESSION['docno'];

$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

	

	 $locationname  = $res["locationname"];

	 $locationcode = $res["locationcode"];

	 $res12locationanum = $res["auto_number"];

	 

  $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';

  if($locationcode!='')

  {

  $query4 = "select locationname,locationcode from master_location where locationcode = '$locationcode'";

	$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));

	$res4 = mysqli_fetch_array($exec4);

	  $locationnameget = $res4['locationname'];

	 $locationcodeget = $res4['locationcode'];

  }

  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

   $storecode=isset($_REQUEST['store'])?$_REQUEST['store']:'';

   $storename = "";
   if($storecode !="")
   {



   $query = "select store from master_store where storecode='$storecode' ";

			$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res = mysqli_fetch_array($exec);			

			$storename = $res["store"];
	}

   $doc_number  = $_REQUEST['doc_number'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 week'));

$transactiondateto = date('Y-m-d');



if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }



if ($ADate1 != '' && $ADate2 != '')

{

	$transactiondatefrom = $_REQUEST['ADate1'];

	$transactiondateto = $_REQUEST['ADate2'];

}

else

{

	$transactiondatefrom = date('Y-m-d', strtotime('-1 week'));

	$transactiondateto = date('Y-m-d');

}



if (isset($_REQUEST["itemcode"])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ""; }

//$itemcode = $_REQUEST['itemcode'];

if (isset($_REQUEST["servicename"])) { $servicename = $_REQUEST["servicename"]; } else { $servicename = ""; }

//$servicename = $_REQUEST['servicename'];



if ($servicename == '') $servicename = 'ALL';



if (isset($_REQUEST["searchoption1"])) { $searchoption1 = $_REQUEST["searchoption1"]; } else { $searchoption1 = ""; }

//$searchoption1 = $_REQUEST['searchoption1'];
$where_cond ="";
if($storecode !="")
{
	$where_cond = "and store='$storecode'";
}
$query = "select * from master_stock where doc_number='$doc_number' $where_cond limit 0,1";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

	

	 $usernamedoc  = $res["username"];

	 $remarks = $res["remarks"];

	 $docdate = $res["transactiondate"];



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

<script language="javascript">



</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<script type="text/javascript">





function ajaxlocationfunction(val)

{ 

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

						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;

						}

					  }

					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);

					xmlhttp.send();

}

					

//ajax to get location which is selected ends here





function process1()

{

	if (document.getElementById("location").value == "")

	{

		alert ("Please Select Location");

		document.getElementById("location").focus();

		return false;

	}

	/*if (document.stockinward.categoryname.value == "")

	{

		alert ("Please Select Category Name.")

		return false;

	}

	if (document.stockinward.searchoption1.value == "")

	{

		alert ("Please Select Search Option.")

		return false;

	}*/

}





function itemcodeentry2()

{

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

		//itemcodeentry1();

		return false;

	}

	else

	{

		return true;

	}

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

	

	function functioncheklocationandstock()

	{

		if(document.getElementById("location").value=='')

		{

		alert('Please Select Location!');

		document.getElementById("location").focus();

		return false;

		}

		if(document.getElementById("store").value=='')

		{

		alert('Please Select Store!');

		document.getElementById("store").focus();

		return false;

		}

	}



</script>



<script src="js/datetimepicker_css.js"></script>



<body <?php //echo $loadprintpage; ?>>

<table width="1500" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9" bgcolor="#ecf0f5"><?php include ("includes/menu1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="9">&nbsp;</td>

  </tr>

  <tr>

    <td width="1%" rowspan="3">&nbsp;</td>

    <td valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td>

		

		

			<form name="stockinward" action="reportbyitem1adjustment.php" method="post" onKeyDown="return disableEnterKey()" onSubmit="return process1()">

	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 

            align="left" border="0">

      <tbody id="foo">

        <tr>

          <td colspan="2" bgcolor="#ecf0f5" class="bodytext31"><strong>View Stock Variance Items </strong></td>

           <td colspan="3" align="right" bgcolor="#ecf0f5" class="bodytext3" id="ajaxlocation"><strong> Location </strong>

             

            

                  <?php

						

						if ($location!='')

						{

						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";

						$exec12 = mysqli_query($GLOBALS["___mysqli_ston"], $query12) or die ("Error in Query12".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res12 = mysqli_fetch_array($exec12);

						

						echo $res1location = $res12["locationname"];

						//echo $location;

						}

						else

						{

						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";

						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						$res1 = mysqli_fetch_array($exec1);

						

						echo $res1location = $res1["locationname"];

						//$res1locationanum = $res1["locationcode"];

						}

						?>

						

						

                  

                  </td> 
                   <td class="bodytext3"><a href="stockvariancereport.php" >Go Back</a></td>

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





function process1rateperunit()

{

	

	servicenameonchange1();

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

		<!--  <tr>

              <td align="left" valign="middle" bgcolor="#FFFFFF"   class="bodytext3"><strong>Location</strong></td>

              <td   class="bodytext3"  colspan="5" bgcolor="#FFFFFF"><select name="location" id="location" style="border: 1px solid #001E6A;" onChange="storefunction(this.value); ajaxlocationfunction(this.value);">

              

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

             

              </tr> -->
<!-- 
		<tr>

		  <td align="left" bgcolor="#FFFFFF" valign="center" class="bodytext31"><strong>Store</strong> </td>

          <td  align="left" bgcolor="#FFFFFF" colspan="5" valign="center"  class="bodytext31">

		  <?php  $loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';

 				 //$username=isset($_REQUEST['username'])?$_REQUEST['username']:'';

 				 $frmflag1=isset($_REQUEST['frmflag1'])?$_REQUEST['frmflag1']:'frmflag1';

				 $store=isset($_REQUEST['store'])?$_REQUEST['store']:'';

				 ?>  

                 

                 <select name="store" id="store">

		   <option value="">-Select Store-</option>

           <?php if ($frmflag1 == 'frmflag1')

{$loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';

//$username=isset($_SESSION['username'])?$_SESSION['username']:'';



$query5 = "select ms.auto_number,ms.storecode,ms.store from master_employeelocation as me LEFT JOIN master_store as ms ON me.storecode=ms.auto_number where me.locationcode = '".$reslocationanum."' AND me.username= '".$username."'";

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

		  </tr> -->


       <!--  <tr>

          <td width="75" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>

          <td width="136" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>

          <td  align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>

          <td  colspan="1" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">

            <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>

		  </span></td>

          <td  colspan="1" align="left" valign="center"  bgcolor="#ffffff"></td>

         <?php /*?><!-- <td width="338" align="left" valign="center"  bgcolor="#ffffff">



		  <select name="searchoption1" id="searchoption1">

		  <!--<option value="">Select Search Option</option>-->

		  <?php

		  if ($searchoption1 == 'CUMULATIVE')

		  {

		  ?>

		  <option value="CUMULATIVE" selected="selected">CUMULATIVE SEARCH ( List By Item )</option>

		  <?php

		  }

		  ?>

		  <?php

		  if ($searchoption1 == 'DETAILED')

		  {

		  ?>

		  <option value="DETAILED" selected="selected">DETAILED SEARCH ( List By Date )</option>

		  <?php

		  }

		  ?>

		  <option value="CUMULATIVE">CUMULATIVE SEARCH ( List By Item )</option>

		  <option value="DETAILED">DETAILED SEARCH ( List By Date )</option>

          </select>          </td>--><?php */?>

        </tr> -->

     <!--    <tr>

          <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><input type="hidden" name="itemcode2" id="itemcode2" style="border: 1px solid #001E6A; text-align:left" onKeyDown="return disableEnterKey()" value="<?php echo $itemcode; ?>" size="10" readonly /></td>

          <td colspan="3" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">

		  <strong></strong></td>

          <td align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right">

            <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

            <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />

            <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" />

	<input type="hidden" name="frmflag1" value="frmflag1" id="frmflag1">

          </div></td>

        </tr> -->

      <!--   <tr>

          <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff">&nbsp;</td>

          <td colspan="4" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Date Range : <?php echo $transactiondatefrom.' To '.$transactiondateto; ?></strong></td>

        </tr> -->

      </tbody>

    </table>

    </form>	</td>

      </tr>

    <!--   <tr>

        <td>&nbsp;</td>

      </tr> -->

      <tr>

        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="88%" 

            align="left" border="0">

          <tbody>

          <!--   <tr>

              <td width="3%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td width="6%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td width="18%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td width="6%" bgcolor="#ecf0f5" class="bodytext31"><a 

                  href="#"></a></td>

              <td width="6%" bgcolor="#ecf0f5" class="bodytext31"><a 

                  href="#"></a></td>

              <td width="8%" bgcolor="#ecf0f5" class="bodytext31"><a 

                  href="#"></a></td>

              <td width="14%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

              <td width="13%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

               <td width="13%" bgcolor="#ecf0f5" class="bodytext31">&nbsp;</td>

            </tr> -->

                 <tr >

              <td colspan="2" class="bodytext31" valign="center"  align="left" 

                ><strong>Doc No</strong></td>
                 <td class="bodytext31" valign="center"  align="left" 

                ><strong><?=  $doc_number;?></strong></td>
                <td align="left" valign="center"  

                 class="bodytext31"><strong>Store</strong></td>

                <td align="left" valign="center"  

                 class="bodytext31"><strong><?=  $storename;?></strong></td>
            </tr>
           <!--  <tr>

              <td align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><strong>Store</strong></td>

                <td align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><strong><?=  $storename;?></strong></td>

            </tr> -->
            <tr>

              <td colspan="2" align="left" valign="center"  

                class="bodytext31"><strong>Date </strong></td>
                  <td align="left" valign="center"  

                class="bodytext31"><strong><?=  $docdate;?> </strong></td>
                 <td align="left" valign="center"  

                 class="bodytext31"><strong>User </strong></td>
                  <td align="left" valign="center"  

                 class="bodytext31"><strong><?=  $usernamedoc;?> </strong></td>
            </tr>
           <!--  <tr>

                <td align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><strong>User </strong></td>
                  <td align="left" valign="center"  

                bgcolor="#ecf0f5" class="bodytext31"><strong><?=  $usernamedoc;?> </strong></td>

            </tr> -->
            <tr>
            	<!-- <td colspan="2"></td> -->
            	<td colspan="2" align="left" valign="center"  

                class="bodytext31"><strong>Remarks </strong></td>

                 <td align="left" valign="center"  

                 class="bodytext31"><strong><?=  $remarks;?> </strong></td>

                 <td align="left" valign="center"  

                class="bodytext31"><strong> </strong></td>

                 <td align="left" valign="center"  

                 class="bodytext31"><strong> </strong></td>

            </tr>

            <!--  <tr bgcolor="#ecf0f5">

             

              

            

              

            </tr> -->

          
            <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><strong>No.</strong></td>

              <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Code</strong></td>

              <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Item </strong></td>
                <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Particulars </strong></td>

                 <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Batch</strong></td>

                <td align="right" valign="right"  

                bgcolor="#ffffff" class="bodytext31"><strong>Phy Qty</strong></td>

                 <td align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Sys. Qty</strong></td>
                 <td align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong>Variance</strong></td>

              <td  width="6%" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Add Stock</strong></div></td>

              <td width="6%"  align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Minus Stock</strong></div></td>

              <td align="right" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Cost</strong></div></td>

              

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ffffff"><div align="right"><strong>Amount</strong></div></td>

              

            </tr>

          

            <?php

			if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }

			//$categoryname = $_REQUEST['categoryname'];

			
			$running_total = 0;
			$colorloopcount = '';

			$sno = '';

			$stockdate = '';

			$transactionparticular = '';

			$stockremarks = '';

			$totalquantity = '';

			$totalsalesamount = '';

			$totalsalesquantity = '';

			$totalsalesreturnamount = '';

			$totalsalesreturnquantity = '';

			$totalpurchaseamount = '';

			$totalpurchasequantity = '';

			$totalpurchasereturnamount = '';

			$totalpurchasereturnquantity = '';

			$totaldccustomerquantity = '';

			$totaldccustomeramount = '';

			$totaldcsupplierquantity = '';

			$totaldcsupplieramount = '';

			$totaladjustmentaddquantity = '';

			$totaladjustmentminusquantity = '';

			

			if ($locationcode != '') //To list all categories, if not selected.

			{

			

			/*if ($searchoption1 == 'DETAILED')

			{

				$query2 = "select * from master_stock where locationcode = '".$locationcodeget."' AND itemcode like '%$itemcode%' and transactionmodule like '%ADJUSTMENT%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and recordstatus <> 'DELETED' and companyanum = '$companyanum' ";

				if($storecode!='')

				{

					$query2 .=" AND store = '".$storecode."'";

					}

				$query2 .=" order by lastupdate";

				// and cstid='$custid' and cstname='$custname'";

			}*/
			
			$searchitemcode=$itemcode;

			$searchstorecode=$storecode;

			 	$query2 = "select * from master_stock where locationcode = '".$locationcodeget."' AND transactionmodule like '%ADJUSTMENT%' and  recordstatus <> 'DELETED' and doc_number='$doc_number' ";// and cstid='$custid' and cstname='$custname'";

				if($store!='')

				{

					$query2 .=" AND store = '".$store."'";

					}

				$query2 .="order by itemname";

			

			$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

			$numrows=mysqli_num_rows($exec2);

			while ($res2 = mysqli_fetch_array($exec2))

			{

			$res2anum = $res2['auto_number'];

			$itemcode = $res2['itemcode'];

			$itemname = $res2['itemname'];

			$username_1=$res2['username'];

			$stockdate = $res2['transactiondate'];

			$storecode = $res2['store'];

			$stockremarks = $res2['remarks'];

			$quantity = $res2['quantity'];

			$sumquantity = $res2['quantity'];

			$sumamount = $res2['totalrate'];

			$batch = $res2['batchnumber'];

			$physical_qty = $res2['physical_quantity'];
			$system_qty = $res2['system_current_stock'];
			$variance = $res2['variance'];
			$cost = $res2['rateperunit'];
			$amount = 
			$usernamedetail=mysqli_query($GLOBALS["___mysqli_ston"], "select employeename from master_employee where username='$username_1' and locationcode ='$locationcodeget'");

			$resuser=mysqli_fetch_array($usernamedetail);

			$userfullname=$resuser['employeename'];

			

			$transactionmodule = $res2['transactionmodule'];

			$res2transactionparticular = $res2['transactionparticular'];

			$storecode = $res2['store'];

			

			$query = "select store from master_store where storecode='$storecode' ";

			$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res = mysqli_fetch_array($exec);			

			$storename = $res["store"];

						

			$query3 = "select categoryname from master_itempharmacy where itemcode = '$itemcode' and status <> 'DELETED'";

			$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

			$res3 = mysqli_fetch_array($exec3);

			$res3categoryname = $res3['categoryname'];

			if ($res3categoryname == $res3categoryname)

			{

			

			

			

			if ($transactionmodule == 'ADJUSTMENT')

			{

				$salesquantity = '';

				$salesreturnquantity = '';

				$purchasequantity = '';

				$purchasereturnquantity = '';

				$dccustomerquantity = '';

				$dcsupplierquantity = '';

				if ($res2transactionparticular == 'BY ADJUSTMENT ADD')

				{

					$adjustmentaddquantity = $sumquantity;

					$adjustmentminusquantity = '';

					//$adjustmentaddquantity = round($adjustmentaddquantity, 4);

					$totaladjustmentaddquantity = $totaladjustmentaddquantity + $adjustmentaddquantity;

					//$amount = $sumquantity * $cost;
					$amount = $adjustmentaddquantity * $cost;

				}

				if ($res2transactionparticular == 'BY ADJUSTMENT MINUS')

				{

					$adjustmentaddquantity = '';

					$adjustmentminusquantity = $sumquantity;

					//$adjustmentminusquantity = round($adjustmentminusquantity, 4);

					$totaladjustmentminusquantity = $totaladjustmentminusquantity + $adjustmentminusquantity;

					//$amount = -($sumquantity * $cost);

					$amount = -($adjustmentminusquantity * $cost);

				}

			}

			else

			{	

				$quantity = '0';

			}

			

			

			

			

			//$quantity = round($quantity, 4);

			

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

			

			$totalquantity = $totalquantity + $quantity;

			$running_total = $running_total + $amount;

			?>

            <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left">

			  <?php echo $sno; ?></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31"><?php echo $itemcode; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">

			  <div class="bodytext31"><?php echo $itemname; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">

                  <div align="left"><?php echo $res2transactionparticular; ?></div>

              </div></td>
               <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">

                  <div align="left"><?php echo $batch; ?></div>

              </div></td>

              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">

                  <div align="right"><?php echo $physical_qty; ?></div>

              </div></td>

              <td class="bodytext31" valign="center"  align="left"><div class="bodytext31">

                  <div align="right"><?php echo $system_qty; ?></div>

              </div></td>

              <td class="bodytext31" valign="center"  align="center"><div class="bodytext31">

			  <?php echo $variance; ?></div></td>

             

              <td class="bodytext31" valign="center"  align="left"><div align="right">

			  <?php echo $adjustmentaddquantity; ?>

			  </div></td>

              <td class="bodytext31" valign="center"  align="left"><div align="right">

			  <?php echo $adjustmentminusquantity; ?>

			  </div></td>

			   <td class="bodytext31" valign="center"  align="right"><div align="right">

			 
			  <?php echo number_format($cost,'2','.',',');?>

			  </div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="right">

			 
			   <?php echo number_format($amount,'2','.',',');?>

			  </div></td>

            </tr>

            <?php

			$sumamount = '';

			$sumquantity = '';

			$salesquantity = '';

			$salesreturnquantity = '';

			$purchasequantity = '';

			$purchasereturnquantity = '';

			$adjustmentaddquantity = '';

			$adjustmentminusquantity = '';

			$purchasereturnquantity = '';

			$totalpurchasereturnquantity = '';

			

			$salesamount = '';

			$salesreturnamount = '';

			$purchaseamount = '';

			$purchasereturnamount = '';

			$adjustmentaddamount = '';

			$adjustmentminusamount = '';

			$totalpurchasereturnamount = '';

			$totalpurchasereturnamount = '';



			}

			

			}

			

			}

			?>

             <tr>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>


              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><div align="right"><strong></strong></div></td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><div class="style1">

                <div align="right"></div>

              </div></td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5"><div class="style1">

                <div align="right"></div>

              </div></td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

              <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

                   <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>
                  <td class="bodytext31" valign="center"  align="left" 

                bgcolor="#ecf0f5">&nbsp;</td>

                <td bgcolor="#ecf0f5" class="bodytext31" valign="top"   align="right"> 

                <strong><?php echo number_format($running_total,'2','.',',');?></strong>

                </td>

            </tr> 
            <tr> <td class="bodytext3" colspan="11">&nbsp;</td><td class="bodytext3"><a href="stockvariancereport.php" >Go Back</a></td></tr>

          </tbody>

        </table></td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

    </table>    

  <tr>

    <td valign="top">    

  <tr>

    <td width="99%" valign="top">    

</table>

<?php include ("includes/footer1.php"); ?>

</body>

</html>

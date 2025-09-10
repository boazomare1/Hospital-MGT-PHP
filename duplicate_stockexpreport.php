	<?php

session_start();

set_time_limit(0);

include ("includes/loginverify.php");

include ("db/db_connect.php");

date_default_timezone_set('Asia/Calcutta'); 

$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d H:i:s');

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

if(document.getElementById("store").value == '')

{

alert("Please Select Store");

document.getElementById("store").focus();

return false;

}

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

		

		 

			<form name="stockinward" action="duplicate_stockexpreport.php" method="post" onKeyDown="return disableEnterKey()" onSubmit="return Locationcheck()">

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

          <td width="76" align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>

          <td width="123" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $ADate1; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>

          <td width="51" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>

          <td colspan="2" width="129" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">

            <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $ADate2; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>

		  </span></td>

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

               <!--  <td align="left" valign="center"  

                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Action</strong></div></td> -->

              </tr>

        

        

				<?php

				if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

//$frmflag1 = $_REQUEST['frmflag1'];

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



			// $query99 = "select ts.itemcode as itemcode,pd.expirydate as expirydate,pd.suppliername as suppliername,ts.batchnumber as batchnumber,ts.itemname as itemname,ts.batch_quantity as batch_quantity,pd.categoryname as categoryname from transaction_stock as ts LEFT JOIN purchase_details as pd ON ts.fifo_code = pd.fifo_code where ts.batch_stockstatus = 1 and ts.locationcode = '".$loc."' and ts.storecode ='".$store."' and pd.categoryname like '%".$categoryname."%'  and pd.expirydate BETWEEN '".$ADate1."' and '".$ADate2."' and pd.companyanum = '$companyanum' ";

	

			 //$query99 = "select ts.itemcode as itemcode,pd.expirydate as expirydate,pd.suppliername as suppliername,ts.batchnumber as batchnumber,ts.itemname as itemname,ts.batch_quantity as batch_quantity,pd.categoryname as categoryname,ts.rate as cost from transaction_stock as ts LEFT JOIN purchase_details as pd ON ts.batchnumber = pd.batchnumber where ts.batch_stockstatus = 1 and ts.locationcode = '".$loc."' and ts.storecode ='".$store."' and pd.categoryname like '%".$categoryname."%'  and pd.expirydate BETWEEN '".$ADate1."' and '".$ADate2."' and pd.companyanum = '$companyanum' ";

	

				//$query99 .= " and ts.itemname like '%".$searchmedicinename."%'";

	

	

	

	//$query99 .= " group by ts.batchnumber";

$query01="select * from (select a.auto_number as auto_number,trim(a.itemname) as itemname,a.itemcode as itemcode,sum(a.batch_quantity) as batch_quantity,a.batchnumber as batchnumber,a.rate as rate,c.categoryname as category,c.genericname,  a.locationcode,a.storecode,a.fifo_code,b.expirydate as expirydate from transaction_stock a left JOIN (select * from (
		select billnumber,itemcode,expirydate,fifo_code from purchase_details where ((not((billnumber like 'GRN-%'))) and (itemcode <> '')) and expirydate BETWEEN '".$ADate1."' and '".$ADate2."' and itemname like '%".$searchmedicinename."%' group by itemcode,fifo_code,expirydate
		union all 
		select billnumber,itemcode,expirydate,fifo_code from materialreceiptnote_details where (itemcode <> '') and expirydate BETWEEN '".$ADate1."' and '".$ADate2."' and itemname like '%".$searchmedicinename."%' group by itemcode,fifo_code,expirydate
		) as a group by itemcode,fifo_code,expirydate) as b ON a.fifo_code=b.fifo_code left JOIN  master_medicine as c ON (a.itemcode=c.itemcode)  where a.storecode='$store' AND a.locationcode='$loc' and  c.categoryname like '%".$categoryname."%'  and a.itemcode <> ''  and b.expirydate BETWEEN '".$ADate1."' and '".$ADate2."' group by a.batchnumber,b.expirydate,a.itemcode) as final  order by IF(final.itemname RLIKE '^[a-z]', 1, 2), final.itemname";
	

	 //echo $query01;

		$run01=mysqli_query($GLOBALS["___mysqli_ston"], $query01);

		while($exec01=mysqli_fetch_array($run01))

		{

			$medanum=$exec01['auto_number'];

			$itemname=$exec01['itemname'];

			$itemcode=$exec01['itemcode']; 

			$batchnumber=$exec01['batchnumber'];

			$category = $exec01['category'];

			$fifo_code = $exec01['fifo_code'];

			
			
			// $query03="select SUM(batch_quantity) as batch_quantity FROM transaction_stock WHERE itemcode='$itemcode' AND storecode='".$storecode."' AND locationcode='".$locationcode."' AND batch_quantity > '0' AND batch_stockstatus ='1' and batchnumber='$batchnumber' and fifo_code = '$fifo_code'";

			// $run03=mysql_query($query03);

			// $exec03=mysql_fetch_array($run03);				

			$batch_quantity=$exec01['batch_quantity'];

			

			$query04="select expirydate,suppliername FROM purchase_details WHERE itemcode='$itemcode' and fifo_code='$fifo_code' group by expirydate, batchnumber asc";

			$run04=mysqli_query($GLOBALS["___mysqli_ston"], $query04);

			$exec04=mysqli_fetch_array($run04);	

			$expirydate=$exec04['expirydate'];
			$suppliername = $exec04['suppliername'];

			if($expirydate=='')

			{

				$query05="select expirydate,suppliername FROM materialreceiptnote_details WHERE itemcode='$itemcode' and fifo_code='$fifo_code' order by expirydate, batchnumber asc";

				$run05=mysqli_query($GLOBALS["___mysqli_ston"], $query05);

				$exec05=mysqli_fetch_array($run05);	

				$expirydate=$exec05['expirydate'];
				if($suppliername =="")
				$suppliername = $exec05['suppliername'];

			}


	//itemname = '".$searchitemname."'

		//	$query99 = "select * from purchase_details where recordstatus <> 'DELETED' and companyanum = '$companyanum' and locationcode = '".$locationcode."' and store ='".$store."'  group by batchnumber";

		$query1 = "select sum(transaction_quantity) as currentstock  from transaction_stock as a join (
		
			select itemcode, expirydate,batchnumber,fifo_code from purchase_details where itemcode='$itemcode' and batchnumber='$batchnumber' and expirydate='$expirydate' group by fifo_code,expirydate, batchnumber 
			union all
			select itemcode,expirydate,batchnumber,fifo_code FROM materialreceiptnote_details WHERE itemcode='$itemcode' and batchnumber='$batchnumber' and expirydate='$expirydate' group by fifo_code,expirydate, batchnumber
			
			) as b on a.batchnumber=b.batchnumber and a.itemcode=b.itemcode and a.fifo_code=b.fifo_code	where a.transactionfunction='1' and a.batchnumber='$batchnumber' and a.itemcode='$itemcode' and a.locationcode='$locationcode' and a.storecode='$store'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$currentstock1 = $res1['currentstock'];

			$query1 = "select sum(transaction_quantity) as currentstock  from transaction_stock as a join (
		
			select itemcode, expirydate,batchnumber,fifo_code from purchase_details where itemcode='$itemcode' and batchnumber='$batchnumber' and expirydate='$expirydate' group by fifo_code,expirydate, batchnumber 
			union all
			select itemcode,expirydate,batchnumber,fifo_code FROM materialreceiptnote_details WHERE itemcode='$itemcode' and batchnumber='$batchnumber' and expirydate='$expirydate' group by fifo_code,expirydate, batchnumber
			
			) as b on a.batchnumber=b.batchnumber and a.itemcode=b.itemcode and a.fifo_code=b.fifo_code	where a.transactionfunction='0' and a.batchnumber='$batchnumber' and a.itemcode='$itemcode' and a.locationcode='$locationcode' and a.storecode='$store'";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res1 = mysqli_fetch_array($exec1);
			$currentstock2 = $res1['currentstock'];

			$batch_quantity= $currentstock1-$currentstock2;

			if(!$batch_quantity)
			{
				$batch_quantity = 0;
			}



			$rate=$exec01['rate'];

			

			

		  

			

			

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
			if($batch_quantity>0){
			$sno = $sno + 1;

			?>

            <tr <?php echo $colorcode; ?>>

              <td class="bodytext31" valign="center"  align="left" 

                ><?php echo $sno; ?></td>

              <td align="left" valign="center"  

                 class="bodytext31"><div class="bodytext31"><?php echo $itemcode; ?></div></td>

              <td align="left" valign="center"  

                 class="bodytext31"><div class="bodytext31"><?php echo $category;?></div></td>

              <td align="left" valign="center"  

                 class="bodytext31"><div class="bodytext31"><?php echo $itemname; ?></div></td>

              <td align="left" valign="center"  

                 class="bodytext31"><div class="bodytext31">

                <div align="left"><?php echo $batchnumber; ?>&nbsp;</div>

              </div></td>

              <td align="left" valign="center"  

                 class="bodytext31"><div class="bodytext31">

                <div align="left"><?php echo $expirydate; ?>&nbsp;</div>

              </div></td>

              <td align="left" valign="center"  

                 class="bodytext31"><div align="right">

                <div class="bodytext31">

                  <div align="left"><?php echo $suppliername; ?>&nbsp;</div>

                </div>

              </div></td>

              <td align="left" valign="center"  

                 class="bodytext31"><div class="bodytext31">

                <div align="right"><?php echo $batch_quantity; ?>&nbsp;</div>

              </div></td>

			  <td align="left" valign="center"  

                 class="bodytext31"><div class="bodytext31">

                <div align="right"><?php echo $rate; ?>&nbsp;</div>

              </div></td>

              <!--  <td align="left" valign="center"  

                 class="bodytext31"><div class="bodytext31">

                <div align="right"><a href="" >Edit</a></div>

              </div></td> -->

              </tr>

          

			<?php

			}

			

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

				<td align="left"><a target="_blank" href="stockreportbyexpirydatexl.php?categoryname=<?= $categoryname; ?>&&store=<?= $store;?>&&location=<?= $reslocationanum;?>&&ADate1=<?= $ADate1;?>&&ADate2=<?= $ADate2;?>&&searchmedicinename=<?= $searchmedicinename;?>"> <img src="images/excel-xls-icon.png" width="30" height="30"></a> </td>

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


<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));

$transactiondateto = date('Y-m-d');

$sno = 0;

$colorloopcount = '';

$totalcost = 0.00;

$docno = $_SESSION['docno'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Revenue Current Stock Report</title>
<!-- Modern CSS -->
<link href="css/revenuecurrentstock-modern.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<link href="css/three.css" rel="stylesheet" type="text/css">
<!-- Modern JavaScript -->
<script type="text/javascript" src="js/revenuecurrentstock-modern.js?v=<?php echo time(); ?>"></script>
</head>

<body>

<header>
  <?php include ("includes/alertmessages1.php"); ?>
  <?php include ("includes/title1.php"); ?>
  <?php include ("includes/menu1.php"); ?>
</header>

<main class="main-container">
<?php

$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

	

	 $locationname  = $res["locationname"];

	 $locationcode = $res["locationcode"];

	 $res12locationanum = $res["auto_number"];

	 

  $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';

  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

//To populate the autocompetelist_services1.js

//include ("autocompletebuild_item1pharmacy.php");



$transactiondatefrom = date('Y-m-d', strtotime('-1 week'));

$transactiondateto = date('Y-m-d');

	

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }

if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

if (isset($_REQUEST["docnumber"])) { $docnumber = $_REQUEST["docnumber"]; } else { $docnumber = ""; }

if (isset($_REQUEST["ADate1"])) { $fromdate = $_REQUEST["ADate1"]; } else { $fromdate = ""; }

if (isset($_REQUEST["ADate2"])) { $todate = $_REQUEST["ADate2"]; } else { $todate = ""; }

if (isset($_REQUEST["store"])) { $store1 = $_REQUEST["store"]; } else { $store = ""; }

if (isset($_REQUEST["location"])) { $location1 = $_REQUEST["location"]; } else { $location1 = ""; }

if (isset($_REQUEST["searchitemcode"])) { $searchitemcode = $_REQUEST["searchitemcode"]; } else { $searchitemcode = ""; }

//$itemcode = $_REQUEST['itemcode'];

if (isset($_REQUEST["servicename"])) { $servicename = $_REQUEST["servicename"]; } else { $servicename = ""; }

//$servicename = $_REQUEST['servicename'];



//if ($servicename == '') $servicename = 'ALL';



if (isset($_REQUEST["itemname"])) { $searchitemname = $_REQUEST["itemname"]; } else { $searchitemname = ""; }

if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }



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

.number

{

padding-left:900px;

text-align:right;

font-weight:bold;

}

.bali

{

text-align:right;

}

.style2 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

</style>

</head>

<script>

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

}	

</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<?php include ("js/dropdownlist1scripting1stock1.php"); ?>

<script type="text/javascript" src="js/disablebackenterkey.js"></script>

<script type="text/javascript" src="js/autosuggest1itemstock2.js"></script>

<script type="text/javascript" src="js/autocomplete_item1pharmacy4.js"></script>

<script src="js/datetimepicker_css.js"></script>



<body  onLoad="return funcCustomerDropDownSearch1();">

<table width="101%" border="0" cellspacing="0" cellpadding="2">

  <tr>

    <td colspan="10" ><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" ><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" ><?php include ("includes/menu1.php"); ?></td>

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

		

		

			<form name="stockinward" action="revenuecurrentstock.php" method="post" onKeyDown="return disableEnterKey()" onSubmit="return Locationcheck()">

	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 

            align="left" border="0">

      <tbody id="foo">

        <tr>

          <td colspan="5"  class="bodytext31"><strong>Revenue Current Stock</strong></td>

          </tr>

        <tr>

          



       

         <tr>

              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Location</strong></td>

              <td  bgcolor="#FFFFFF" class="bodytext3"  colspan="3" ><select name="location" id="location" style="border: 1px solid #001E6A;" onChange="storefunction(this.value)">

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

		  <td width="104" align="left" valign="center"   class="bodytext31"><strong>Store</strong> </td>

          <td width="680" colspan="4" align="left" valign="center"   class="bodytext31">

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

 class="bodytext31"><strong>Category</strong></td>

          <td colspan="4" align="left" valign="center"   class="bodytext31"><select name="categoryname" id="categoryname">

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

 class="bodytext31"><strong>Search</strong></td>

          <td colspan="4" align="left" valign="center"   class="bodytext31"><input name="itemname" type="text" id="itemname" value="<?php echo $searchitemname; ?>" style="border: 1px solid #001E6A; text-align:left" size="50" autocomplete="off">

		  <input type="hidden" name="searchitem1hiddentextbox" id="searchitem1hiddentextbox">

		  <input type="hidden" name="searchitemcode" id="searchitemcode">

            <input name="searchbutton12" type="submit" id="searchbutton12" style="border: 1px solid #001E6A" value="Search Item Name" /></td>

        </tr>

        <tr>

          <td width="155" align="left" valign="center"  

 class="bodytext31"><strong> Date From </strong></td>

          <td width="246" align="left" valign="center"   class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>

          <td width="106" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>

          <td width="256" align="left" valign="center"  ><span class="bodytext31">

            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />

			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>

		  </span></td>

          </tr>

        <tr>

          <td width="104" align="left" valign="center"  

 class="bodytext31"><strong></strong></td>

          <td width="680" colspan="4" align="left" valign="center"   class="bodytext31">

		            

		  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

            <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />

            <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td>

			<input type="hidden" name="frmflag1" value="frmflag1" id="frmflag1">

          </tr>

		  

        <tr>

          <td class="bodytext31" valign="center"  align="left" ><input type="hidden" name="itemcode2" id="itemcode2" style="border: 1px solid #001E6A; text-align:left" onKeyDown="return disableEnterKey()" value="<?php echo $itemcode; ?>" size="10" readonly /></td>

          <td colspan="4" align="left" valign="center"   class="bodytext31">&nbsp;		  </td>

          </tr>

      </tbody>

    </table>

    </form>		</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      

  <tr>

   

    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">

      

	  <tr>

        <td width="860">

	<form name="form1" id="form1" method="post" action="revenuecurrentstock.php">

	  <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="889" 

            align="left" border="0">

          <tbody>

             <tr>

			 <td colspan="9"  class="bodytext31" align="left" valign="middle"><strong>Revenue Current Stock</strong></td>

			 </tr>

			  <tr>

			    <td width="41" class="bodytext31" valign="center"  align="left" 

>&nbsp;</td>

				  <td width="41" class="bodytext31" valign="center"  align="left" 

><strong>S.No.</strong></td>

				  				  <td width="233"  align="left" valign="center" 

 class="style2">Item</td>

				  				  <td width="142"  align="right" valign="center" 

 class="style2">Cost Price </td>

                    <td width="142"  align="right" valign="center" 

 class="style2">Sales Price </td>

				  	<td width="120"  align="right" valign="center" 

 class="style2">Current Qty</td>

                    <td width="120"  align="right" valign="center" 

 class="style2">Sales Qty</td>

                    <td width="120"  align="right" valign="center" 

 class="style2">COGS</td>

				  				  <td width="216"  align="right" valign="center" 

 class="bodytext31"><strong>Revenue </strong></td>

				  	<td rowspan="2" class="bodytext31" valign="center"  align="right">

                   <?php  if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }?> 

                 <a target="_blank"  href="print_revenuecurrentstock.php?ADate1=<?php echo $fromdate; ?>&&ADate2=<?php echo $todate; ?>&&searchitemcode=<?php echo $searchitemcode; ?>&&store=<?php echo $store1; ?>&&location=<?php echo $locationcode; ?>&&categoryname=<?php echo $categoryname;?>"> <img src="images/pdfdownload.jpg" width="30" height="30"></a></td>	

                  </tr>					

           <?php

		   if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }

			if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }

			//$categoryname = $_REQUEST['categoryname'];

			if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

			if (isset($_REQUEST["ADate2"])) { $todate = $_REQUEST["ADate2"]; } else { $todate = ""; }

			if (isset($_REQUEST["ADate1"])) { $fromdate = $_REQUEST["ADate1"]; } else { $fromdate = ""; }

			

			//$frmflag1 = $_REQUEST['frmflag1'];

			if ($frmflag1 == 'frmflag1')

			{

		   $totalsales=0;

		   $totalcogs=0;

		   $totalrevenue=0;

		   if(trim($searchitemcode)!='')

		   {

			$query1 = "select entrydocno,itemname,itemcode,transaction_date,transaction_quantity,fifo_code from transaction_stock where  transaction_date between '$fromdate' and '$todate' and itemcode ='$searchitemcode' and locationcode='$locationcode' and storecode='$store' group by itemcode";

			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

			$num1=mysqli_num_rows($exec1);

			

			while($res1 = mysqli_fetch_array($exec1))

			{

				$res1billnumber =$res1['entrydocno'];

				$res1itemname =$res1['itemname'];

				$res1itemcode =$res1['itemcode'];

				$res1transactiondate =$res1['transaction_date'];

				$res1expirydate ='';

				$res1quantity =$res1['transaction_quantity'];

				$res1fifo_code =$res1['fifo_code'];

				$res1rateperunit ='0';

				$res1totalrate ='0';

				

				

				$query2 = "select purchaseprice,rateperunit from master_medicine where itemcode='$res1itemcode'";

				$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

				$num2=mysqli_num_rows($exec2);		

				$res2 = mysqli_fetch_array($exec2);

				$res1rateperunit =$res2['purchaseprice'];

				$res1sells =$res2['rateperunit'];

				$totalcost = $totalcost + $res1rateperunit;

				$totalsales = $totalsales + $res1sells;

				$colorloopcount = $colorloopcount + 1;

				

				$query3 = "select sum(transaction_quantity) as qty from transaction_stock where itemcode='$res1itemcode' and description in ('IP Direct Sales','Sales') and transaction_date between '$fromdate' and '$todate' and storecode='$store' and locationcode='$locationcode'";

				$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

				$num3 = mysqli_num_rows($exec3);		

				$res3 = mysqli_fetch_array($exec3);

				$res3qty =$res3['qty'];

				$cogs = $res3qty*$res1sells;

				$totalcogs=$totalcogs+$cogs;

				$query7 = "select sum(transaction_quantity) as qty from transaction_stock where itemcode='$res1itemcode' and batch_stockstatus='1' and storecode='$store' and locationcode='$locationcode'";

				$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));

				$num7 = mysqli_num_rows($exec7);		

				$res7 = mysqli_fetch_array($exec7);

				$res7qty =$res7['qty'];

				$revenue = ($res3qty*$res1sells) - ($res3qty*$res1rateperunit);

				$totalrevenue=$totalrevenue+$revenue;

				

				

				$showcolor = ($colorloopcount & 1); 

				if ($showcolor == 0)

				{

					//echo "if";

					$colorcode = 'bgcolor="#CBDBFA"';

				}

				else

				{

					//echo "else";

					$colorcode = '';

				}

			 ?>

				<tr <?php echo $colorcode; ?>>

				  <td width="41" align="left" valign="center" class="bodytext31">&nbsp;</td>

					<td width="41" align="left" valign="center" class="bodytext31"><?php echo $sno= $sno + 1; ?></td>

					<td width="233"  align="left" valign="center" class="bodytext31"><?php echo $res1itemname; ?></td>

					<td width="142"  align="right" valign="center" class="bodytext31"><?php echo number_format($res1rateperunit,2,'.',','); ?></td>

					<td width="142"  align="right" valign="center" class="bodytext31"><?php echo number_format($res1sells,2,'.',','); ?></td>

					<td width="120"  align="right" valign="center" class="bodytext31"><?php echo intval($res7qty); ?></td>

					<td width="120"  align="right" valign="center" class="bodytext31"><?php echo intval($res3qty); ?></td>

					<td width="142"  align="right" valign="center" class="bodytext31"><?php echo number_format($cogs,2,'.',','); ?></td>

					<td width="216"  align="right" valign="center" class="bodytext31"><?php echo number_format($revenue,2,'.',','); ?></td>

					<td width="40"  align="right" valign="center" class="bodytext31">&nbsp;</td>

					</tr>	

	      <?php }

		   }

		   else

		   {

			if($searchitemcode=='')

			{

			   $query10 = "select itemcode,purchaseprice,rateperunit from master_medicine where categoryname like '%$categoryname%' and status <> 'DELETED' group by itemcode";// and companyanum = '$companyanum'";// and cstid='$custid' and cstname='$custname'";

			}

			else

			{

				$query10 = "select itemcode,purchaseprice,rateperunit from master_medicine where itemcode = '$searchitemcode' and categoryname like '%$categoryname%' and status <> 'DELETED' group by itemcode";

			}

			$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));

			$num10 = mysqli_num_rows($exec10);

			while ($res10 = mysqli_fetch_array($exec10))

			{

				$itemcode =$res10['itemcode'];

				$res1rateperunit =$res10['purchaseprice'];

				$res1sells =$res10['rateperunit'];

				$query1 = "select entrydocno,itemname,itemcode,transaction_date,transaction_quantity,fifo_code from transaction_stock where  transaction_date between '$fromdate' and '$todate' and itemcode ='$itemcode' and storecode='$store' and locationcode='$locationcode' group by itemcode";

				$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

				$num1=mysqli_num_rows($exec1);

				

				while($res1 = mysqli_fetch_array($exec1))

				{

					$res1billnumber =$res1['entrydocno'];

					$res1itemname =$res1['itemname'];

					$res1itemcode =$res1['itemcode'];

					$res1transactiondate =$res1['transaction_date'];

					$res1expirydate ='';

					$res1quantity =$res1['transaction_quantity'];

					$res1fifo_code =$res1['fifo_code'];

					//$res1rateperunit ='0';

					$res1totalrate ='0';

					

					

					$totalcost = $totalcost + $res1rateperunit;

					$totalsales = $totalsales + $res1sells;

					$colorloopcount = $colorloopcount + 1;

					

					$query3 = "select sum(transaction_quantity) as qty from transaction_stock where itemcode='$res1itemcode' and description in ('IP Direct Sales','Sales') and transaction_date between '$fromdate' and '$todate' and storecode='$store' and locationcode='$locationcode'";

					$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

					$num3 = mysqli_num_rows($exec3);		

					$res3 = mysqli_fetch_array($exec3);

					$res3qty =$res3['qty'];

					$cogs = $res3qty*$res1rateperunit;

					$totalcogs=$totalcogs+$cogs;

					$query7 = "select sum(transaction_quantity) as qty from transaction_stock where itemcode='$res1itemcode' and batch_stockstatus='1' and storecode='$store' and locationcode='$locationcode'";

					$exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));

					$num7 = mysqli_num_rows($exec7);		

					$res7 = mysqli_fetch_array($exec7);

					$res7qty =$res7['qty'];

					$revenue = $res3qty*$res1sells;

					$totalrevenue=$totalrevenue+$revenue;

					$showcolor = ($colorloopcount & 1); 

					if ($showcolor == 0)

					{

						//echo "if";

						$colorcode = 'bgcolor="#CBDBFA"';

					}

					else

					{

						//echo "else";

						$colorcode = '';

					}

			 ?>

				<tr <?php echo $colorcode; ?>>

					  <td width="41" align="left" valign="center" class="bodytext31">&nbsp;</td>

						<td width="41" align="left" valign="center" class="bodytext31"><?php echo $sno= $sno + 1; ?></td>

						<td width="233"  align="left" valign="center" class="bodytext31"><?php echo $res1itemname; ?></td>

						<td width="142"  align="right" valign="center" class="bodytext31"><?php echo number_format($res1rateperunit,2,'.',','); ?></td>

						<td width="142"  align="right" valign="center" class="bodytext31"><?php echo number_format($res1sells,2,'.',','); ?></td>

						<td width="120"  align="right" valign="center" class="bodytext31"><?php echo intval($res7qty); ?></td>

						<td width="120"  align="right" valign="center" class="bodytext31"><?php echo intval($res3qty); ?></td>

						<td width="142"  align="right" valign="center" class="bodytext31"><?php echo number_format($cogs,2,'.',','); ?></td>

						<td width="216"  align="right" valign="center" class="bodytext31"><?php echo number_format($revenue,2,'.',','); ?></td>

						<td width="40"  align="right" valign="center" class="bodytext31">&nbsp;</td>

						</tr>	

			  <?php }

				}

		   }

			?>		

		

			 <tr>

			   <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 

>&nbsp;</td>

			<td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 

>&nbsp;</td>

			<td  valign="center" bordercolor="#f3f3f3" 

 class="bodytext31" align="right"><strong>Total</strong></td>

			<td  valign="center" bordercolor="#f3f3f3" 

 class="bodytext31" align="right"><?php echo number_format($totalcost,2,'.',','); ?></td>

			<td align="right" valign="center" bordercolor="#f3f3f3" 

 class="bodytext31"><?php echo number_format($totalsales,2,'.',','); ?></td>

			<td align="left" valign="center" bordercolor="#f3f3f3" 

 class="bodytext31">&nbsp;</td>

			<td align="left" valign="center" bordercolor="#f3f3f3" 

 class="bodytext31">&nbsp;</td>

                <td align="right" valign="center" bordercolor="#f3f3f3" 

 class="bodytext31"><?php echo number_format($totalcogs,2,'.',','); ?></td>

                <td align="right" valign="center" bordercolor="#f3f3f3" 

 class="bodytext31"><?php echo number_format($totalrevenue,2,'.',','); ?></td>

		    </tr>

            <?php }?>		

          </tbody>

        </table>

<tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

	  

	  </form>

    </table>

  </table>

<footer>
  <?php include ("includes/footer1.php"); ?>
</footer>
</main>

</body>

</html>




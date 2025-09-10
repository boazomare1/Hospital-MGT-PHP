<?php

session_start();

include ("includes/loginverify.php");

include ("db/db_connect.php");



$ipaddress = $_SERVER["REMOTE_ADDR"];

$username = $_SESSION['username'];

$updatedatetime = date('Y-m-d H:i:s');

$errmsg = "";

$bgcolorcode = "";

$colorloopcount = "";

$rateperunit = "0";

$purchaseprice = "0";

$checkboxnumber = '';



if (isset($_POST["searchflag1"])) { $searchflag1 = $_POST["searchflag1"]; } else { $searchflag1 = ""; }

if (isset($_POST["search1"])) { $search1 = $_POST["search1"]; } else { $search1 = ""; }

if (isset($_POST["search2"])) { $search2 = $_POST["search2"]; } else { $search2 = ""; }

if (isset($_POST["location"])) { $location = $_POST["location"]; } else { $location = ""; }

if (isset($_POST["store"])) { $store = $_POST["store"]; } else { $store = ""; }



?>

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ecf0f5;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none

}

-->

</style>

<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/adddate.js"></script>

<script type="text/javascript" src="js/adddate2.js"></script>

<style type="text/css">

<!--

.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none

}

.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none

}

-->

</style>

</head>

<script>

function coasearch(varCallFrom,item)

{

	var varCallFrom = varCallFrom;

	var item = item;

	window.open("popup_labmapmultiple.php?callfrom="+varCallFrom+'&item='+item,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');

	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');

	return false;

}



function form1valid()

{

	if(document.getElementById("location").value == "")

	{

		alert('Select Location');

		document.getElementById("location").focus();

		return false;

	}

	

}



function form2Valid()

{

	if(document.getElementById("locationcode").value == "")

	{

		alert('Select Location');

		document.getElementById("locationcode").focus();

		return false;

	}

	/*if(document.getElementById("paynowcashcoa").value == "")

	{

		alert('Select Supplier');

		document.getElementById("paynowcashcoa").focus();

		return false;

	}*/

}

</script>



<script src="js/jquery-1.11.1.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/autocomplete.css">

<link rel="stylesheet" type="text/css" href="css/style.css">

<script src="js/jquery.min-autocomplete.js"></script>

<script src="js/jquery-ui.min.js"></script>


<link href="css/autocomplete.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>


<body >

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

    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="860"><table width="" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">

            <tr>

              <td>

                <table width="850" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

                    <tbody>

                      <tr bgcolor="#011E6A">

                        <td colspan="15" bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><strong>Item Map Master </strong></span></td>

                      </tr>

						<?php

						if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

						//echo $st;

						if ($st == 'success') 

						{

						//echo "Item Mapping To Supplier Completed.";

						?>

                      <tr bgcolor="#011E6A">

                        <td colspan="15" bgcolor="#CCFF00" class="bodytext3">

						Item Mapping To Supplier Completed.&nbsp;</td>

                      </tr>

						<?php

						}

						?>

						<form name="form1" id="form1" action="labmapmultiple.php" method="post" onSubmit="return form1valid();">

                      <tr bgcolor="#011E6A">

                        <td bgcolor="#FFFFFF" class="bodytext3"><strong>Location</strong> </td>

						<td colspan="2" bgcolor="#FFFFFF" class="bodytext3"><select name="location" id="location" >

					  

					  <?php

					  $query7 = "select * from master_location where status <> 'deleted'";

					  $exec7 = mysqli_query($GLOBALS["___mysqli_ston"], $query7) or die ("Error in Query7".mysqli_error($GLOBALS["___mysqli_ston"]));

					  while($res7 = mysqli_fetch_array($exec7))

					  {

					  $res7locationcode = $res7['locationcode'];

					  $res7locationname = $res7['locationname'];

					  ?>

					  <option value="<?php echo $res7locationcode; ?>" <?php if($location == $res7locationcode) { echo "selected"; } ?>><?php echo $res7locationname; ?></option>

					  <?php

					  }

					  ?>

					  </select></td>

					   <td colspan="3" bgcolor="#FFFFFF" class="bodytext3"><strong>&nbsp;</strong>&nbsp;&nbsp;

					  </td>

                      </tr>

					 

					   <tr bgcolor="#011E6A">

					   <td bgcolor="#FFFFFF" class="bodytext3"><strong>Item </strong> </td>

                        <td colspan="5" bgcolor="#FFFFFF" class="bodytext3">

						 <input name="search1" type="text" id="search1" size="40" value="<?php echo $search1; ?>" onFocus="return auditypeearch()">

						<input type="hidden" name="searchitemcode" id="searchitemcode" value="">	
							
						<!--<input type="hidden" name="username" id="username" value="<?php echo $username; ?>">-->

						<input type="hidden" name="searchflag1" id="searchflag1" value="searchflag1">

                          <input type="submit" name="Submit2" value="Search" style="border: 1px solid #001E6A" />

						 </td>

                      </tr>

					   </form>	

					   <tr>

					    <td colspan='6'>&nbsp;</td>

					   </tr>

                      

                      <tr bgcolor="#011E6A">

                        <td width="4%" bgcolor="#ecf0f5" class="bodytext3"><div><strong>Sno</strong></div></td>

                        <td width="7%" bgcolor="#ecf0f5" class="bodytext3"><strong>ID / Code </strong></td>

                        <td width="14%" bgcolor="#ecf0f5" class="bodytext3"><strong>Category</strong></td>

                        <td width="24%" bgcolor="#ecf0f5" class="bodytext3"><strong>Test</strong></td>

						<td width="4%" bgcolor="#ecf0f5" class="bodytext3" align="center"><strong>Rate</strong></td>

						<td width="20%" bgcolor="#ecf0f5" class="bodytext3"><strong>Suppliername</strong></td>

                        <td width="4%" bgcolor="#ecf0f5" class="bodytext3"><strong>Action</strong></td>

                      </tr>

                      

 		 <form name="form2" id="form2" action="additemtosupplier2.php" method="post" onSubmit="return form2Valid();">

                     <?php

	  if ($searchflag1 == 'searchflag1')

	  {

		$items_build = "''";	  

		$search1 = $_REQUEST["search1"];

	

		 $query1 = "select itemcode,categoryname,itemname,rateperunit,sampletype from master_lab  where itemname like '%$search1%' and status <> 'deleted' and externallab = 'yes'  order by itemname";

			

		//echo $query1;

		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

		while ($res1 = mysqli_fetch_array($exec1))

		{

		$itemcode = $res1["itemcode"];

		$itemname = $res1["itemname"];

		$categoryname = $res1["categoryname"];

		$rateperunit = $res1["rateperunit"];

		$sampletype = $res1["sampletype"];
		
		$supplierq = "select suppliercode from lab_supplierlink where itemcode = '$itemcode' and fav_supplier='1'";
		$execq = mysqli_query($GLOBALS["___mysqli_ston"], $supplierq) or die("Error in SupplierQ".mysqli_error($GLOBALS["___mysqli_ston"]));
		$resq = mysqli_fetch_array($execq);
		$suppliercode = $resq['suppliercode'];

		$query20 = "select accountname from master_accountname where id = '$suppliercode' ";
		$exec20 = mysqli_query($GLOBALS["___mysqli_ston"], $query20) or die('Error in Query20'.mysqli_error($GLOBALS["___mysqli_ston"]));
		$res20 = mysqli_fetch_array($exec20);
		$suppliername = $res20['accountname'];


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

		

		  

		$checkboxnumber = $checkboxnumber + 1;

		?>

        <tr <?php echo $colorcode; ?>>

                        <td align="left" valign="top"   class="bodytext3"><div align="center">

						<?php echo $checkboxnumber; ?>

						</div></td>

                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>

                        <td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>

                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?> </td>

                        <td align="right" valign="top"  class="bodytext3"><?php echo number_format($rateperunit,2); ?> </td>

                        <td align="left" valign="top"  class="bodytext3"><?php echo $suppliername; ?> </td>

						<td align="left" valign="top"  class="bodytext3"><a href='javascript:return false;' onClick="javascript:coasearch('7','<?php echo $itemcode;?>','<?php echo $rateperunit;?>');" value="Map" accesskey="m">Map</a></td>

                      </tr>

                      <?php

		}

		?>

          <tr>

            <td bgcolor="" class="bodytext3" colspan="6">

            <strong>&nbsp;</strong>

            </td>

          </tr>

         

          

        <?php

	

	    }

		?>

    

		  </form>		   

                    </tbody>

                  </table>

				  

			    </td>

            </tr>

            <tr>

              <td>&nbsp;</td>

            </tr>

        </table></td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

    </table>

</table>
<script>



function auditypeearch(){
			
var search1=document.getElementById('search1').value;
	    // alert(medicinename);   
  $('#search1').autocomplete({	
  source:"ajax_labmapmultiple_search.php?pid="+search1,
  minLength:1,
  html: true,
  select: function(event,ui)
	{
	 var mobile=ui.item.value;
		var excessnov=ui.item.mobile;
		// var cdocno=ui.item.cdocno;
		 
		$("#search1").val(mobile);
		$("#searchitemcode").val(excessnov);
		
		
	
		
	}, 
	});
	
	}
	
	
	
</script>

<?php include ("includes/footer1.php"); ?>

</body>

</html>




<?php

session_start();

include ("includes/loginverify.php"); 

include ("db/db_connect.php");



$ipaddress = $_SERVER['REMOTE_ADDR'];

$updatedatetime = date('Y-m-d');

$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];

$companyname = $_SESSION['companyname'];

$colorloopcount = '';

$sno = '';

$snocount = '';

$docno = $_SESSION['docno'];

$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";

$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

$res = mysqli_fetch_array($exec);

	

	 $locationname  = $res["locationname"];

	 $locationcode = $res["locationcode"];

	 $res12locationanum = $res["auto_number"];

	 $locationcode_new = $locationcode;

  $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';

  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

  

function readCSV($csvFile){

    $file_handle = fopen($csvFile, 'r');

    while (!feof($file_handle) ) {

        $line_of_text[] = fgetcsv($file_handle, 1024);

    }

    fclose($file_handle);

    return $line_of_text;

}

    

if (isset($_REQUEST["frmflag_upload"])) { $frmflag_upload = $_REQUEST["frmflag_upload"]; } else { $frmflag_upload = ""; }

if ($frmflag_upload == 'frmflag_upload')

{	

$paynowbillprefix = 'SA-';

$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select billnumber from stock_taking order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["billnumber"];

$billdigit=strlen($billnumber);

if ($billnumber == '')

{

	$billnumbercode ='SA-'.'1';

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

	

	

	$billnumbercode = 'SA-'.$maxanum;

	$openingbalance = '0.00';

	//echo $companycode;

}

	$locationcode = $_REQUEST['locationcode'];

		

	if(!empty($_FILES['upload_file']))

	{

		$inputFileName = $_FILES['upload_file']['tmp_name'];

		//print_r($_FILES['upload_file']);

		include 'phpexcel/Classes/PHPExcel/IOFactory.php';

		try {

    		$inputFileType = PHPExcel_IOFactory::identify($inputFileName);

			$objReader = PHPExcel_IOFactory::createReader($inputFileType);

		    $objPHPExcel = $objReader->load($inputFileName);

			$sheet = $objPHPExcel->getSheet(0); 

			 $highestRow = $sheet->getHighestRow();

			$highestColumn = $sheet->getHighestColumn();

			$row = 1;

			$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,

                                    NULL,

                                    TRUE,

                                    FALSE)[0];

			foreach($rowData as $key=>$value)

			{

			if($rowData[$key] == 'storecode')

			 $storecodenm = $key;

			 if($rowData[$key] == 'itemcode')

			 $itemcodenm = $key;

			 if($rowData[$key] == 'itemname')

			 $itemnamenm = $key;

			 if($rowData[$key] == 'rate')

			 $ratenm = $key;

			 

			 if($rowData[$key] == 'batchnumber')

			 $batchnm = $key;

			 if($rowData[$key] == 'physical quantity')

			 $phyqtynm = $key;

			/*  if($rowData[$key] == 'Sys Qty')
			 	$sysqtynm = $key;

			 if($rowData[$key] == 'Download Time')
			 	$downloadtime = $key;
			 	 */
			 

			}			
//echo $highestRow;
			for ($row = 2; $row <= $highestRow; $row++){ 

    		//  Read a row of data into an array

    		$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,

                                    NULL,

                                    TRUE,

                                    FALSE)[0];

			

				//print_r($rowData);			

				 $storecode=$rowData[$storecodenm];	
                if($storecode!=''){
					include("store_stocktaking_chk1.php");
					//echo $num_stocktaking;
					if($num_stocktaking < 1) { ?>
					   <tr><td colspan="7" class="bodytext3"><font color='red' size='6px'><strong>Please freeze the store and then upload.</strong></font></td></tr>

					   <?php
					   exit;
					}
                }
				 $itemcode=$rowData[$itemcodenm];	

				 $itemname=$rowData[$itemnamenm];	

				$rate=$rowData[$ratenm];

				//$expirydate=$rowData[$expirynm];
				$expirydate=date('Y-m-d');

				 $expirydate=date('Y-m-d', strtotime($expirydate));

				$batchnumber=$rowData[$batchnm];

				$batchnumber=str_replace("'","",$batchnumber);

				 $batchnumber=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $batchnumber);
				 
				   $query1 = "select sum(transaction_quantity) as currentstock from transaction_stock where  itemcode='$itemcode'  and storecode='$storecode' and batchnumber = '$batchnumber'  and transactionfunction='1' ";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						$currentstock1 = $res1['currentstock'];

						$query1 = "select sum(transaction_quantity) as currentstock from transaction_stock where  itemcode='$itemcode'  and storecode='$storecode' and batchnumber = '$batchnumber'  and transactionfunction='0' ";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$res1 = mysqli_fetch_array($exec1);
						$currentstock2 = $res1['currentstock'];

				        $avlquantity = $currentstock1-$currentstock2;
				
					/* $query1 = "select sum(transaction_quantity) as currentstock  from transaction_stock where batchnumber='$batchnumber' and itemcode='$itemcode'  and storecode='$storecode' and batch_stockstatus='1'";
			
					$exec23 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

					$res23 = mysqli_fetch_array($exec23);
				 $avlquantity=$res23['currentstock']; */
				//$avlquantity=$rowData[$sysqtynm];
				

				$phyquantity=$rowData[$phyqtynm];

				$itemsubtotal=$rate * $phyquantity;
                //$downloadtime1=$rowData[$downloadtime];
                $downloadtime1='';
				

			    if($batchnumber!="" )

				{

				 $medicinequery2="insert into stock_taking (itemcode, itemname, transactiondate,transactionmodule,transactionparticular,

					billnumber, quantity, 

					username, ipaddress, rateperunit,companyanum, companyname,batchnumber,expirydate,store,location,totalrate,allpackagetotalquantity,downloadtime)

					values ('$itemcode', '$itemname', '$updatedatetime', 'OPENINGSTOCK', 

					'BY STOCK ADD', '$billnumbercode', '$phyquantity', 

					'$username', '$ipaddress','$rate','$companyanum', '$companyname','$batchnumber','$expirydate','$storecode','$locationcode','$itemsubtotal','$avlquantity','$downloadtime1')";

					$execquery2=mysqli_query($GLOBALS["___mysqli_ston"], $medicinequery2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
					

				}

   				 //  Insert row data array into your database of choice here

			}

			} catch(Exception $e) {

			 die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());

			}

			

			//print_r($objPHPExcel);
			
			

		}

		//$extension = substr(strrchr($_FILES['upload_file']['name'], "."), 1);

//		if($extension == 'csv')

//		{

//			$csv = readCSV($csvFile);

//			//print_r($csv);

//			$count = count($csv);

//			for($i=1;$i<$count;$i++)

//			{

//				$sno = $csv[$i][0];				

//				$storecode=$csv[$i][1];	

//				$itemcode=$csv[$i][2];	

//				$itemname=$csv[$i][3];	

//				$rate=$csv[$i][4];

//				$expirydate=$csv[$i][5];

//				$expirydate=date('Y-m-d', strtotime($expirydate));

//				$batchnumber=$csv[$i][6];

//				$batchnumber=str_replace("'","",$batchnumber);

//				$batchnumber=mysql_real_escape_string($batchnumber);

//				$avlquantity=$csv[$i][7];

//				$phyquantity=$csv[$i][8];

//				$itemsubtotal=$rate * $phyquantity;

//				if($batchnumber!="" )

//				{

//					$medicinequery2="insert into stock_taking (itemcode, itemname, transactiondate,transactionmodule,transactionparticular,

//					billnumber, quantity, 

//					username, ipaddress, rateperunit,companyanum, companyname,batchnumber,expirydate,store,location,totalrate,allpackagetotalquantity)

//					values ('$itemcode', '$itemname', '$updatedatetime', 'OPENINGSTOCK', 

//					'BY STOCK ADD', '$billnumbercode', '$phyquantity', 

//					'$username', '$ipaddress','$rate','$companyanum', '$companyname','$batchnumber','$expirydate','$storecode','$locationcode','$itemsubtotal','$avlquantity')";

//					$execquery2=mysql_query($medicinequery2) or die(mysql_error());

//				}

//		

//			} 

//		}

//		

//	}

	

	//header("location:stocktaking.php?billnumber=".$billnumber."");

	//exit;



}



?>



<?php

if(isset($_GET['billnumber']))

{

 $billnumber=$_GET['billnumber'];

	 // header("location:stockexport.php?billnumber=".$billnumber."");



$link = "<script>window.open('stockexport.php?billnumber=".$billnumber."', 'width=710,height=555,left=160,top=170')</script>";

echo $link;

//header("location:stocktaking.php");

	

}



?>





<?php

$query3 = "select * from master_company where companystatus = 'Active'";

$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

$res3 = mysqli_fetch_array($exec3);

$paynowbillprefix = 'SA-';

$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select billnumber from stock_taking order by auto_number desc limit 0, 1";

$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));

$res2 = mysqli_fetch_array($exec2);

$billnumber = $res2["billnumber"];

$billdigit=strlen($billnumber);

if ($billnumber == '')

{

	$billnumbercode ='SA-'.'1';

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

	

	

	$billnumbercode = 'SA-'.$maxanum;

	$openingbalance = '0.00';

	//echo $companycode;

}

?>

<script src="jquery/jquery-1.11.3.min.js"></script>
<script>

function storechk(store){

 if(store!=''){
    var loc =document.getElementById("location").value;

	$.ajax({
	type : "get",
	url : "store_stocktaking_chk.php?storecode="+store+"&locationcode="+loc,
	catch : false,
	success : function(data){
		if(data==0){
			alert("Please freeze the store and try.");	
			$("#store").val("");
			return false;
		}
	}
	});
 }

}



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







function validcheck()

{

	if (document.getElementById('upload_file').value == '') 

	{

		 alert('Select CSV file to Upload');

		 return false;

	} 

	if(confirm("Are You Want To Save The Record?")==false){return false;}	

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

</script>



<script>

function medicinecheck()

{

if(document.cbform12.location.value=="")

	{

		alert("Please select location name");

		document.cbform12.location.focus();

		return false;

	}

	if(document.cbform12.store.value=="")

	{

		alert("Please select store name");

		document.cbform12.store.focus();

		return false;

	}

	var location = document.getElementById("location").value;

	var store = document.getElementById("store").value;

	var product_type = document.getElementById("producttype").value; 

	var categoryid = document.getElementById("categoryid").value; 
	//var category = document.getElementById("categoryid").text;

	var res_prod_id = document.getElementById("res_prod_id").value; 


	var categorySelect = document.getElementById("categoryid");
	var category = categorySelect.options[categorySelect.selectedIndex].text;

	var genericnameSelect = document.getElementById("genericname");
	var genericname = genericnameSelect.options[genericnameSelect.selectedIndex].text;
	//alert('here');
	//return false;
	window.open("stocktaking_csv1.php?frmflag34=frmflag34&&location="+location+"&&store="+store+"&&producttype="+product_type+"&&categoryid="+categoryid+"&&category="+category+"&&genericname="+genericname+"&&res_prod_id="+res_prod_id, "_blank");

	return true;

	

}



function checkqty(val,sno)

{

	var snum=sno;

	var value=val;

	

	var avlquantity=document.getElementById("avlquantity"+snum).value;

	var phyquantity=document.getElementById("phyquantity"+snum).value;

	

	if(parseInt(value) > parseInt(avlquantity))

	{

		//alert("Please enter lesser then avlquantity");

		//document.getElementById("phyquantity"+snum).value='';

		

		//return false;

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

	function checkallfunc()

	{

		if(document.getElementById("checkall").checked==true)

		{

			//document.getElementById("check").checked=true;

			var checkvar = document.getElementsByClassName("check");

			for(var i=0;i<checkvar.length;i++)

			{

				checkvar[i].checked=true;

			}

		}

		else

		{

			var checkvar = document.getElementsByClassName("check");

			for(var i=0;i<checkvar.length;i++)

			{

				checkvar[i].checked=false;

			}

		}

	}


</script>

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	background-color: #ECF0F5;

}

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma

}

-->

</style>

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />







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

    <td colspan="10" bgcolor="#ECF0F5"><?php include ("includes/alertmessages1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" bgcolor="#ECF0F5"><?php include ("includes/title1.php"); ?></td>

  </tr>

  <tr>

    <td colspan="10" bgcolor="#ECF0F5"><?php include ("includes/menu1.php"); ?></td>

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

		

		

              <form name="cbform12" method="post" action="stocktaking.php" onSubmit="return medicinecheck()" >

		<table width="670" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">

          <tbody>

            <tr bgcolor="#011E6A">

              <td colspan="1" bgcolor="#CCCCCC" class="bodytext3"><strong> Stock Taking </strong></td>

               <td colspan="3" align="right" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation"><strong> Location </strong>

             

            

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

              </tr>

          	 <tr>

              <td align="left" valign="middle"  bgcolor="FFFFFF"  class="bodytext3"><strong>Location</strong></td>

              <td   class="bodytext3" bgcolor="FFFFFF"   colspan="3" ><select name="location" id="location" style="border: 1px solid #001E6A;" onChange="storefunction(this.value); ajaxlocationfunction(this.value);">

             <option value="" >Select Location</option>

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

		  <td width="104" align="left" bgcolor="FFFFFF"  valign="center" class="bodytext31"><strong>Store</strong> </td>

          <td width="450" align="left" bgcolor="FFFFFF"  valign="center"  class="bodytext31" colspan="3">

		  <?php  $loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';

 				 $username=isset($_REQUEST['username'])?$_REQUEST['username']:'';

 				 $frmflag1=isset($_REQUEST['frmflag1'])?$_REQUEST['frmflag1']:'';

				 $store=isset($_REQUEST['store'])?$_REQUEST['store']:'';?>  

                 <select name="store" id="store" style="border: 1px solid #001E6A;" onChange="return storechk(this.value);">

		   <option value="">-Select Store-</option>

           <?php $loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';

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

<?php }?>

		  </select>

		  </td>

		  </tr>





		   <tr style="display:none">

              <td align="left" valign="middle"  bgcolor="FFFFFF"  class="bodytext3"><strong>Purchase Type</strong></td>

              <td   class="bodytext3" bgcolor="FFFFFF"   colspan="3" ><select name="producttype" id="producttype" style="border: 1px solid #001E6A;">

             <option value="" >Select Purchase Type</option>

                  <?php

						 $producttypeid=isset($_REQUEST['producttype'])?$_REQUEST['producttype']:'';

						$query = "select id,name from master_purchase_type where status !='deleted' order by id desc";

						$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));

						while ($res = mysqli_fetch_array($exec))

						{

						$producttype = $res["name"];

						$product_type_id = $res["id"];

						?>

						<option value="<?php echo $producttype; ?>" <?php if($producttypeid==$producttype){echo 'selected';}?>><?php echo $producttype; ?></option>

						<?php 

						}

						?>

                  </select></td>

              </tr>
			  
			  
			  <tr style="display:none">
              <td align="left" valign="middle"  bgcolor="FFFFFF"  class="bodytext3"><strong>Product Type</strong></td>
              <td   class="bodytext3" bgcolor="FFFFFF"   colspan="3" ><select name="res_prod_id" id="res_prod_id" style="border: 1px solid #001E6A;">
             <option value="" >Select Product Type</option>
                  <?php
						 $res_prod_id_type=isset($_REQUEST['res_prod_id'])?$_REQUEST['res_prod_id']:'';
						
								     // Select * from product_type table
								     $query_prod_type = "select * from product_type where status = '1' ";
								     $exec_prod_type = mysqli_query($GLOBALS["___mysqli_ston"], $query_prod_type) or die ("Error in query_prod_type".mysqli_error($GLOBALS["___mysqli_ston"]));
								 while ($res_prod_type = mysqli_fetch_array($exec_prod_type))
								 {
								     $res_prod_name = $res_prod_type['name'];
									 $res_prod_id = $res_prod_type['id'];
								 ?>
		                          <option value="<?php echo $res_prod_id; ?>"<?php if($res_prod_id_type==$res_prod_id){echo 'selected';} ?>><?php echo $res_prod_name; ?></option>
								 <?php
								     }
								 ?>
                  </select></td>
              </tr>
			  
			  
			  
			  
			  
			  
			  

<?php  if (isset($_REQUEST["categoryid"])) { $categoryid = $_REQUEST["categoryid"]; } else { $categoryid = ""; }
 ?>
                <tr style="display:none">

              <td align="left" valign="middle"  bgcolor="FFFFFF"  class="bodytext3"><strong>Category</strong></td>

              <td   class="bodytext3" bgcolor="FFFFFF"   colspan="3" >
              	<select name="categoryid" id="categoryid" style="border: 1px solid #001E6A;">

            <option value="" selected="selected">Select Category</option>

                  <?php

						 

						$query1 = "select * from master_categorypharmacy where status <> 'deleted' order by categoryname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$res1categoryname = $res1["categoryname"];
						$catid = $res1["auto_number"];
						?>
                          <option value="<?php echo $catid; ?>" <?php if($catid==$categoryid){echo 'selected';}?>><?php echo $res1categoryname; ?></option>
                          <?php
						}
						?>

                  </select></td>

                   

         

             

              </tr>
              <?php  if (isset($_REQUEST["genericname"])) { $genericname = $_REQUEST["genericname"]; } else { $genericname = ""; }
 ?>
                 <tr style="display:none">

              <td align="left" valign="middle"  bgcolor="FFFFFF"  class="bodytext3"><strong>Generic Name</strong></td>

              <td   class="bodytext3" bgcolor="FFFFFF"   colspan="3" >
              	<select name="categoryid" id="genericname" style="border: 1px solid #001E6A;">

            <option value="" >Select Generic Name</option>

                  <?php
						$query111 = "select * from master_genericname where recordstatus = '' ";
						$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res111 = mysqli_fetch_array($exec111))
						{
						$res111genericname = trim($res111['genericname']);
						?>
                          <option value="<?php echo $res111genericname; ?>" <?php if($res111genericname==$genericname){echo 'selected';}?>><?php echo $res111genericname; ?></option>
						  <?php
						  }
						  ?>

                  </select></td>

              </tr>



          <tr>

          <td align="left" valign="middle" bgcolor="FFFFFF"  class="bodytext31"><strong>Doc No</strong></td>

           <td align="left"  bgcolor="FFFFFF" class="bodytext3"  valign="top" colspan="3"><span >

                <input name="docnumber" type="text" id="docnumber" readonly style="border: 1px solid #001E6A;" value="<?php echo $billnumbercode; ?>" size="8" autocomplete="off">

              </span></td>

          </tr>

            <tr>

              <td align="left" valign="middle" bgcolor="FFFFFF"  class="bodytext3"></td>

              <td colspan="3" align="left" valign="top"  bgcolor="FFFFFF" ><input type="hidden" name="cbfrmflag12" value="cbfrmflag12">

                          <input  type="submit" id='submit' value="Search" name="submit" />

                          <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>

			      

              </tr>

	 <!-- <tr id="pressid">

				   <td colspan="11" align="left" valign="middle"  bgcolor="#ECF0F5" class="bodytext3">

				   <table id="presid" width="500" border="0" cellspacing="1" cellpadding="1">

                     <tr>

                       <td width="177" class="bodytext3">Medicine Name</td>

                      

                       <td width="69" class="bodytext3">Quantity</td>

                      <td width="72" class="bodytext3">Batch</td>

                      

                       

                     </tr>

					 <tr>

					 <div id="insertrow">					 </div></tr>

                     <tr>

					  <input type="hidden" name="serialnumber" id="serialnumber" value="1">

					  <input type="hidden" name="medicinecode" id="medicinecode" value="">

                        <td><input name="medicinename" type="text" id="medicinename" size="25" autocomplete="off" onKeyDown="return StateSuggestionspharm4()" onKeyUp="return funcCustomerDropDownSearch4()" onClick="functioncheklocationandstock()"></td>

						

						<td><input name="quantity" type="text" id="quantity" size="8"></td>

						<td><select name="batchnumber" id="batchnumber" onFocus="return funcBatchNumberPopulate1()" onChange="return funcBatchNumberVerify1()" onBlur="return funcBatchNumberVerify2()">

			  <option value="" selected="selected">Batch</option>

              </select></td>

						<input name="expirydate" type="hidden" id="expirydate" size="8">

						<td width="169"><label>

                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem10()" class="button" style="border: 1px solid #001E6A">

                       </label></td>

					   </tr>

                     

					 <input type="hidden" name="h" id="h" value="0">

                   </table>				  </td>

			       </tr>

			   <tr>

              <td align="left" valign="middle" class="bodytext3"></td>

              <td align="left" valign="top">

			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">

                  <input  style="border: 1px solid #001E6A" type="submit" value="Save" name="Submit"/>

                 </td>

            </tr>-->

          </tbody>

        </table>

		</form> 	</td>

      </tr>

      

       <tr>

        <td>&nbsp;</td>

      </tr>

      <form name="cbform1" method="post" action="stocktaking.php" enctype="multipart/form-data" onSubmit="return validcheck()">	

        <?php

				if (isset($_REQUEST["cbfrmflag12"])) { $cbfrmflag12 = $_REQUEST["cbfrmflag12"]; } else { $cbfrmflag12 = ""; }

				

				//if ($cbfrmflag12 == 'cbfrmflag12')

				//{

						 /*$locationcode = $_REQUEST['location'];

					     $storecode = $_REQUEST['store']; */

					?>

      <tr>

        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 

            bordercolor="#666666" cellspacing="0" cellpadding="4" width="767" 

            align="left" border="0">

          <tbody bgcolor="#CBDBFA">

            <tr>

			<td colspan="3">&nbsp;</td>

			</tr>

			<tr>

			<td width="102">&nbsp;</td>

			<td width="643" colspan="2" align="left" class="bodytext3">

			<strong>Upload CSV File </strong>			</td>

			</tr>

			<tr>

			<td>&nbsp;</td>

			<td colspan="2"><input type="file" name="upload_file" id="upload_file"></td>

			</tr>

			<tr>

			<td>&nbsp;</td>

			<td colspan="2">

			<input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode_new; ?>">

			<input type="hidden" name="frmflag_upload" id="frmflag_upload" value="frmflag_upload">

			<input type="submit" name="frmsubmit1" value="Upload Excel">

			</td>

			</tr>

          </tbody>

        </table></td>

      </tr>

      

	  </form>

    </table>

  </table>

  <?php 

  //}

  ?>

<?php include ("includes/footer1.php"); ?>

</body>

</html>




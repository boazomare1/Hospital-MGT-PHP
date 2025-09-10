<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
//echo $menu_id;
include ("includes/check_user_access.php");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
//to redirect if there is no entry in masters category or item.
if (!isset($_SESSION['radtablename'])){$_SESSION['radtablename']='master_radiology';}
if (isset($_REQUEST["radtemplate"])) { $radtemplate = $_REQUEST["radtemplate"]; $_SESSION['radtablename']=$radtemplate; } else { $radtemplate = $_SESSION['radtablename']; }
if (isset($_REQUEST['uploadexcel'])){
	//echo "santu";
	
	
	
	if(!empty($_FILES['upload_file']))
	{
		$inputFileName = $_FILES['upload_file']	['tmp_name'];
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
			if($rowData[$key] == 'Item Code')
			 //$storecodenm = $key;
			 $itemcodenm = $key;
			 if($rowData[$key] == 'Category')
			// $itemcodenm = $key;
			$categorynm = $key;
			 if($rowData[$key] == 'Item Name')
			 //$itemnamenm = $key;
			 $itemnamenm = $key;
			 if($rowData[$key] == 'Location')
			 //$ratenm = $key;
			 $locationnm = $key;
			 if($rowData[$key] == 'Temp Name')
			 //$expirynm = $key;
			 $tempidnm = $key;
			 if($rowData[$key] == 'Unit Charges')
			 //$batchnm = $key;
			$chargesnm = $key;
			}			
			for ($row = 2; $row <= $highestRow; $row++){ 
    		//  Read a row of data into an array
    		$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                    NULL,
                                    TRUE,
                                    FALSE)[0];
				//$sno = $rowData[0];					
				$itemcode=$rowData[$itemcodenm];	
				$category=$rowData[$categorynm];	
				$itemname=$rowData[$itemnamenm];
				$location=$rowData[$locationnm];
				$tempid=$rowData[$tempidnm];
				$charges=$rowData[$chargesnm];
//labtemplate
			if($itemcode!="" )
				{
					
			
					
			 	$query591 = "update $tempid set rateperunit='$charges' where itemcode = '$itemcode' and locationcode='$location'";
				$exec591 = mysqli_query($GLOBALS["___mysqli_ston"], $query591) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
				
					
				}
   				 //  Insert row data array into your database of choice here
			}
			} catch(Exception $e) {
			 die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}
			
			}
	
	
	
	//exit;
	
	
	
	
	
}
if (isset($_REQUEST['update'])){
			if (isset($_REQUEST['newserselect'])){$numrow = (sizeof($_REQUEST["newserselect"]))?sizeof($_REQUEST["newserselect"]):0;} else {$numrow=0;}
		if($numrow>0)
		{
		$itemcodes= $_REQUEST['newserselect'];
		 for($i=0;$i<$numrow;$i++){
		//echo $i."<br>";
		 $query1 = "select * from master_radiology where itemcode = '".$itemcodes[$i]."' order by auto_number ";
		$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec3))
		{
		$itemcode = $res1["itemcode"];
	//	echo $itemcode;
		$itemname = $res1["itemname"];
		$categoryname = $res1["categoryname"];
		$description = $res1["description"];
		$purchaseprice = $res1["purchaseprice"];
		$rateperunit = $res1["rateperunit"];
		$expiryperiod = $res1["expiryperiod"];
		$radtime = $res1["radtime"];
		$itemname_abbreviation = $res1["itemname_abbreviation"];
		$taxname = $res1["taxname"];
		$taxanum = $res1["taxanum"];
		$ipmarkup = $res1["ipmarkup"];
		$locationcode = $res1["locationcode"];
		$rate2 = $res1['rate2'];
		$rate3 = $res1['rate3'];
		$location=$res1['location'];
		$referencevalue=$res1['referencevalue'];
		$status=$res1['status'];
		$externalshare=$res1['externalshare'];
		$pkg=$res1['pkg'];
$locationname=$res1['locationname'];
//(  `status`, `referencevalue`,  `location`, `locationname`, `externalshare`, `radtime`) 
//	(`status`,`referencevalue`,location`,  `locationname`,`externalshare`, `radtime`)
		if ($expiryperiod != '0') 
		{ 
			$expiryperiod = $expiryperiod.' Months'; 
		}
		else
		{
			$expiryperiod = ''; 
		}
		
		$query1 = "insert into $radtemplate (itemcode, itemname, categoryname,purchaseprice, rateperunit, rate2, expiryperiod, ipaddress, updatetime,locationcode,ipmarkup, pkg,itemname_abbreviation,description, rate3,taxname,taxanum,radtime,status,location,locationname,externalshare) 
			values ('$itemcode', '$itemname', '$categoryname','".$purchaseprice."', '".$rateperunit."','".$rate2."', '$expiryperiod', '$ipaddress', '$updatedatetime','".$locationcode."','$ipmarkup','".$pkg."','$itemname_abbreviation','$description', '".$rate3."','$taxname','$taxanum','$radtime','$status','$location','$locationname','$externalshare')";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		}    // inner while
		
		}   //for
		
		
		}   //while
		
		
//header(servicename1temp.php);
//exit;
}
	$itemname = '';
	$rateperunit  = '0.00';
	$purchaseprice  = '0.00';
	$description='';
	$referencevalue = '';
	
	
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update $radtemplate set status = 'deleted',username = '$username',ipaddress = '$ipaddress',updatetime = '$updatedatetime' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$query31 = "update master_radiology set status = 'deleted',username = '$username',ipaddress = '$ipaddress',updatetime = '$updatedatetime' where auto_number = '$delanum'";
	$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update $radtemplate set status = '',username = '$username',ipaddress = '$ipaddress',updatetime = '$updatedatetime' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
$query31 = "update master_radiology set status = '',username = '$username',ipaddress = '$ipaddress',updatetime = '$updatedatetime' where auto_number = '$delanum'";
	$exec31 = mysqli_query($GLOBALS["___mysqli_ston"], $query31) or die ("Error in Query31".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add radiology Item To Proceed For Billing.";
	$bgcolorcode = 'failed';
}
if (isset($_REQUEST["searchflag1"])) { $searchflag1 = $_REQUEST["searchflag1"]; } else { $searchflag1 = ""; }
if (isset($_REQUEST["searchflag2"])) { $searchflag2 = $_REQUEST["searchflag2"]; } else { $searchflag2 = ""; }
if (isset($_REQUEST["search1"])) { $search1 = $_REQUEST["search1"]; } else { $search1 = ""; }
if (isset($_REQUEST["search2"])) { $search2 = $_REQUEST["search2"]; } else { $search2 = ""; }
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
<link href="../hospitalmillennium/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<link href="js/jquery-ui.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery-1.11.1.js"></script>
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
.pagination{float:right;}
-->
</style>
</head>
<script language="javascript">
function additem1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.categoryname.value == "")
	{	
		alert ("Please Select Category Name.");
		document.form1.categoryname.focus();
		return false;
	}
	if (document.form1.itemcode.value == "")
	{	
		alert ("Please Enter radiology Item Code or ID.");
		document.form1.itemcode.focus();
		return false;
	}
	if (document.form1.itemcode.value != "")
	{	
		var data = document.form1.itemcode.value;
		//alert(data);
		// var iChars = "!%^&*()+=[];,.{}|\:<>?~"; //All special characters.*
		var iChars = "!^+=[];,{}|\<>?~$'\"@#%&*()-_`. "; 
		for (var i = 0; i < data.length; i++) 
		{
			if (iChars.indexOf(data.charAt(i)) != -1) 
			{
				//alert ("Your radiology Item Name Has Blank White Spaces Or Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ $ ' \" These are not allowed.");
				alert ("Your radiology Item Code Has Blank White Spaces Or Special Characters. These Are Not Allowed.");
				return false;
			}
		}
	}
	if (document.form1.itemname.value == "")
	{
		alert ("Pleae Enter radiology Item Name.");
		document.form1.itemname.focus();
		return false;
	}
	/*
	if (document.form1.itemname_abbreviation.value == "")
	{
		alert ("Pleae Select Unit Name.");
		document.form1.itemname_abbreviation.focus();
		return false;
	}
	*/
	if (document.form1.purchaseprice.value == "")
	{	
		alert ("Please Enter Purchase Price Per Unit.");
		document.form1.purchaseprice.focus();
		return false;
	}
	if (document.form1.rateperunit.value == "")
	{	
		alert ("Please Enter Selling Price Per Unit.");
		document.form1.rateperunit.focus();
		return false;
	}
	
	if (isNaN(document.form1.rateperunit.value) == true)
	{	
		alert ("Please Enter Rate Per Unit In Numbers.");
		document.form1.rateperunit.focus();
		return false;
	}
	if (document.form1.rateperunit.value == "0.00")
	{
		var fRet; 
		fRet = confirm('Rate Per Unit Is 0.00, Are You Sure You Want To Continue To Save?'); 
		//alert(fRet);  // true = ok , false = cancel
		if (fRet == false)
		{
			return false;
		}
/*		else if (document.form1.itemname_abbreviation.value == "SR")
		{
			if (document.form1.expiryperiod.value == "")
			{	
				alert ("Please Select Expiry Period.");
				document.form1.expiryperiod.focus();
				return false;
			}
		}
*/	}
/*	else if (document.form1.itemname_abbreviation.value == "SR")
	{
		if (document.form1.expiryperiod.value == "")
		{	
			alert ("Please Select Expiry Period.");
			document.form1.expiryperiod.focus();
			return false;
		}
	}
*/}
/*
function process1()
{
	//alert (document.form1.itemname.value);
	if (document.form1.itemname_abbreviation.value == "SR")
	{
		document.getElementById('expiryperiod').style.visibility = '';
	}
	else
	{
		document.getElementById('expiryperiod').style.visibility = 'hidden';
	}
}
*/
function spl()
{
	var data=document.form1.itemname.value ;
	//alert(data);
	// var iChars = "!%^&*()+=[];,.{}|\:<>?~"; //All special characters.
	var iChars = "!^+=[];,{}|\<>?~"; 
	for (var i = 0; i < data.length; i++) 
	{
		if (iChars.indexOf(data.charAt(i)) != -1) 
		{
			alert ("Your radiology Item Name Has Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ These are not allowed.");
			return false;
		}
	}
}
 
 
function process2()
{
	//document.getElementById('expiryperiod').style.visibility = 'hidden';
}
function process1backkeypress1()
{
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
		return false;
	}
	else
	{
		return true;
	}
}

$(document).ready(function(){
	$( ".edititem" ).click(function() {
		var clickedid = $(this).attr('id');		
		//alert(clickedid);
		var current_expdate = $('tr#'+clickedid).find("div.txnno").text();		
		var current_txnno = $('tr#'+clickedid).find("div.mptxnno").text();
		$('tr#'+clickedid).find("td.txnno1").show();		
		$('tr#'+clickedid).find("td.mptxnno1").show();
		$('tr#'+clickedid).find("td.itemrateupdate").hide();	
		$('#txnno_'+clickedid).val(current_expdate);
		$('#mptxnno_'+clickedid).val(current_txnno);
		$('#s_'+clickedid).show();
		return false;
	})	
	$( ".saveitem" ).click(function() {
		var clickedid = $(this).attr('id');
		var idstr = clickedid.split('s_');
		var id = idstr[1];
		var cdtxn_no= $('#txnno_'+id).val();
		//alert(cdtxn_no);
		var mptxn_no= $('#mptxnno_'+id).val();
		//alert(mptxn_no);
		var autono=  $('#autono_'+id).val();
		var tablename=  $('#tablename_'+id).val();
		
		$.ajax({
		  url: 'ajax/ajaxeditradiologytemplaterate.php',
		  type: 'POST',
		  //async: false,
		  dataType: 'json',
		  //processData: false,    
		  data: { 
		      cdtxn_no: cdtxn_no, 
		      mptxn_no: mptxn_no,
			  autono: autono, 
			  tablename: tablename,
		      
		  },
		  success: function (data) { 
		  	//alert(data)
		  	var msg = data.msg;
		  	if(data.status == 1)
		  	{
			//alert(id);	
		  		$('tr#'+id).find("td.mptxnno1").hide();
				$('tr#'+id).find("td.txnno1").hide();
				$('tr#'+id).find("td.itemrateupdate").show();
				$('#caredittxno_'+id).text(mptxn_no);
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
</script>
<body onLoad="return process2()">
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
        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td>
				  <form method="post" enctype="multipart/form-data">
                <table width="1300" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="5" bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><strong>Radiology Item Master - Existing List - Latest 100 radiology Items </strong></span></td>
						<td colspan="1" bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">
						<?php //error_reporting(0);
						if($searchflag1 != 'searchflag1'){
							$tbl_name="master_radiology";		//your table name
							// How many adjacent pages should be shown on each side?
							$adjacents = 3;
							
							/* 
							   First get total number of rows in data table. 
							   If you have a WHERE clause in your query, make sure you mirror it here.
							*/
							$query111 = "select * from $radtemplate where status <> 'deleted' order by auto_number desc";
							$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
							$res111 = mysqli_fetch_array($exec111);
							$total_pages = mysqli_num_rows($exec111);
												
							/*$query = "SELECT * FROM $tbl_name";
							$total_pages = mysql_fetch_array(mysql_query($query));
							echo $numrow = mysql_num_rows($total_pages);*/
							
							/* Setup vars for query. */
							$targetpage = $_SERVER['PHP_SELF']; 	//your file name  (the name of this file)
							$limit = 50; 								//how many items to show per page
							if(isset($_REQUEST['page'])){ $page=$_REQUEST['page'];} else { $page="";}
							if($page) 
								$start = ($page - 1) * $limit; 			//first item to display on this page
							else
								$start = 0;								//if no page var is given, set start to 0
							
							/* Setup page vars for display. */
							if ($page == 0) $page = 1;					//if no page var is given, default to 1.
							$prev = $page - 1;							//previous page is page - 1
							$next = $page + 1;							//next page is page + 1
							$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
							$lpm1 = $lastpage - 1;						//last page minus 1
							
							/* 
								Now we apply our rules and draw the pagination object. 
								We're actually saving the code to a variable in case we want to draw it more than once.
							*/
							$pagination = "";
							if($lastpage >= 1)
							{	
								$pagination .= "<div class=\"pagination\">";
								//previous button
								if ($page > 1) 
									$pagination.= "<a href=\"$targetpage?page=$prev\" style='color:#3b3b3c;'>previous</a>";
								else
									$pagination.= "<span class=\"disabled\">previous</span>";	
								
								//pages	
								if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
								{	
									for ($counter = 1; $counter <= $lastpage; $counter++)
									{
										if ($counter == $page)
											$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
										else
											$pagination.= "<a href=\"$targetpage?page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
									}
								}
								elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
								{
									//close to beginning; only hide later pages
									if($page < 1 + ($adjacents * 2))		
									{
										for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
										{
											if ($counter == $page)
												$pagination.= "<span class=\"current\" style='margin:0 0 0 2px;' color:#3b3b3c;>$counter</span>";
											else
												$pagination.= "<a href=\"$targetpage?page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
										}
										$pagination.= "...";
										$pagination.= "<a href=\"$targetpage?page=$lpm1\"style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";
										$pagination.= "<a href=\"$targetpage?page=$lastpage\"style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";		
									}
									//in middle; hide some front and some back
									elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
									{
										$pagination.= "<a href=\"$targetpage?page=1\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";
										$pagination.= "<a href=\"$targetpage?page=2\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";
										$pagination.= "...";
										for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
										{
											if ($counter == $page)
												$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
											else
												$pagination.= "<a href=\"$targetpage?page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
										}
										$pagination.= "...";
										$pagination.= "<a href=\"$targetpage?page=$lpm1\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";
										$pagination.= "<a href=\"$targetpage?page=$lastpage\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";		
									}
									//close to end; only hide early pages
									else
									{
										$pagination.= "<a href=\"$targetpage?page=1\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";
										$pagination.= "<a href=\"$targetpage?page=2\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";
										$pagination.= "...";
										for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
										{
											if ($counter == $page)
												$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
											else
												$pagination.= "<a href=\"$targetpage?page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
										}
									}
								}
								
								//next button
								if ($page < $counter - 1) 
									$pagination.= "<a href=\"$targetpage?page=$next\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</a>";
								else
									$pagination.= "<span class=\"disabled\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</span>";
								echo $pagination.= "</div>\n";		
							}
						}
						else
						{
							$tbl_name="master_radiology";		//your table name
							// How many adjacent pages should be shown on each side?
							$adjacents = 3;
							$search1 = $_REQUEST["search1"];
							/* 
							   First get total number of rows in data table. 
							   If you have a WHERE clause in your query, make sure you mirror it here.
							*/
							$query111 = "select * from $radtemplate where itemname like '%$search1%' or categoryname like '%$search1%' and  status <> 'deleted' order by auto_number desc";
							$exec111 = mysqli_query($GLOBALS["___mysqli_ston"], $query111) or die ("Error in Query111".mysqli_error($GLOBALS["___mysqli_ston"]));
							$res111 = mysqli_fetch_array($exec111);
							$total_pages = mysqli_num_rows($exec111);
												
							/*$query = "SELECT * FROM $tbl_name";
							$total_pages = mysql_fetch_array(mysql_query($query));
							echo $numrow = mysql_num_rows($total_pages);*/
							
							/* Setup vars for query. */
							$targetpage = $_SERVER['PHP_SELF']; 	//your file name  (the name of this file)
							$limit = 50; 								//how many items to show per page
							if(isset($_REQUEST['page'])){ $page=$_REQUEST['page'];} else { $page="";}
							if($page) 
								$start = ($page - 1) * $limit; 			//first item to display on this page
							else
								$start = 0;								//if no page var is given, set start to 0
							
							/* Setup page vars for display. */
							if ($page == 0) $page = 1;					//if no page var is given, default to 1.
							$prev = $page - 1;							//previous page is page - 1
							$next = $page + 1;							//next page is page + 1
							$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
							$lpm1 = $lastpage - 1;						//last page minus 1
							
							/* 
								Now we apply our rules and draw the pagination object. 
								We're actually saving the code to a variable in case we want to draw it more than once.
							*/
							$pagination = "";
							if($lastpage >= 1)
							{	
								$pagination .= "<div class=\"pagination\">";
								//previous button
								if ($page > 1) 
									$pagination.= "<a href=\"$targetpage?radtemplate=$radtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=$prev\" style='color:#3b3b3c;'>previous</a>";
								else
									$pagination.= "<span class=\"disabled\">previous</span>";	
								
								//pages	
								if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
								{	
									for ($counter = 1; $counter <= $lastpage; $counter++)
									{
										if ($counter == $page)
											$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
										else
											$pagination.= "<a href=\"$targetpage?radtemplate=$radtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
									}
								}
								elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
								{
									//close to beginning; only hide later pages
									if($page < 1 + ($adjacents * 2))		
									{
										for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
										{
											if ($counter == $page)
												$pagination.= "<span class=\"current\" style='margin:0 0 0 2px;' color:#3b3b3c;>$counter</span>";
											else
												$pagination.= "<a href=\"$targetpage?radtemplate=$radtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
										}
										$pagination.= "...";
										$pagination.= "<a href=\"$targetpage?radtemplate=$radtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=$lpm1\"style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";
										$pagination.= "<a href=\"$targetpage?radtemplate=$radtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=$lastpage\"style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";		
									}
									//in middle; hide some front and some back
									elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
									{
										$pagination.= "<a href=\"$targetpage?radtemplate=$radtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=1\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";
										$pagination.= "<a href=\"$targetpage?radtemplate=$radtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=2\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";
										$pagination.= "...";
										for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
										{
											if ($counter == $page)
												$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
											else
												$pagination.= "<a href=\"$targetpage?radtemplate=$radtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
										}
										$pagination.= "...";
										$pagination.= "<a href=\"$targetpage?radtemplate=$radtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=$lpm1\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";
										$pagination.= "<a href=\"$targetpage?radtemplate=$radtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=$lastpage\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";		
									}
									//close to end; only hide early pages
									else
									{
										$pagination.= "<a href=\"$targetpage?radtemplate=$radtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=1\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";
										$pagination.= "<a href=\"$targetpage?radtemplate=$radtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=2\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";
										$pagination.= "...";
										for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
										{
											if ($counter == $page)
												$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
											else
												$pagination.= "<a href=\"$targetpage?radtemplate=$radtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
										}
									}
								}
								
								//next button
								if ($page < $counter - 1) 
									$pagination.= "<a href=\"$targetpage?radtemplate=$radtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=$next\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</a>";
								else
									$pagination.= "<span class=\"disabled\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</span>";
								echo $pagination.= "</div>\n";		
							}
						}
						?>
						</span></td>
                         <td align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31" ><a target="_blank" href="print_raditemtemp.php?radtemp=<?=$radtemplate?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>
                      </tr>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#FFFFFF" class="bodytext3">
						<input name="search1" type="text" id="search1" size="40" value="<?php echo $search1; ?>">
						<input type="hidden" name="searchflag1" id="searchflag1" value="searchflag1">
                         </td>
						  <td colspan="1" bgcolor="#FFFFFF" class="bodytext3">
						<select name="radtemplate" id="radtemplate"  style="border: 1px solid #001E6A;">
						<?php
						if($radtemplate!='')
						{?>
						<option value="<?php echo $radtemplate; ?>"><?php echo $radtemplate; ?></option>
						<?php } else
						{?>
						<option value="" selected="selected">Select Radiology</option>
						<?php }
						if($radtemplate != 'master_radiology'){
						?>
						<option value="master_radiology" >master_radiology</option>						
						<?php
						}
							$query10 = "select * from master_testtemplate where testname = 'radiology' order by templatename";
							$exec10 = mysqli_query($GLOBALS["___mysqli_ston"], $query10) or die ("Error in Query10".mysqli_error($GLOBALS["___mysqli_ston"]));
							while ($res10 = mysqli_fetch_array($exec10))
							{							
								$templatename = $res10["templatename"];
								if($templatename != $radtemplate)
								{
								?>
								<option value="<?php echo $templatename; ?>"><?php echo $templatename; ?></option>
								<?php
								}
							}
						?>
                        </select>
                          <input type="submit" name="Submit2" value="Search" style="border: 1px solid #001E6A" />
						   <input type="submit" name="Submit3" value="New radiology" style="border: 1px solid #001E6A" /></td>
						   
						   
						     <td colspan="5" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31" >
				 	<a target="_blank" href="download_radiologyitemtemp.php?radtemp=<?=$radtemplate?>"> Download Temp	</a>&nbsp;
						
						<input type="file" name="upload_file" id="upload_file"> &nbsp;
						
						<input type="submit" name="uploadexcel" id="uploadexcel"   value="Upload Excel">
						
						</td>
						   
						   
                        </tr>
                    
                      <?php
	  if ($searchflag1 == 'searchflag1')
	  {
		
		if(isset($_REQUEST["Submit3"]))	{
			?>
			<tr bgcolor="#011E6A">
			<td width="9%" bgcolor="#ecf0f5" class="bodytext3"><strong>ID / Code </strong></td>
			<td width="12%" bgcolor="#ecf0f5" class="bodytext3"><strong>Category</strong></td>
			<td width="28%" bgcolor="#ecf0f5" class="bodytext3"><strong>Radiology Item</strong></td>
			<td width="13%" bgcolor="#ecf0f5" class="bodytext3"><strong>Unit</strong>    <div align="center"><strong><!--Purchase--></strong></div></td>
			<td width="9%" bgcolor="#ecf0f5" class="bodytext3"><div><strong>Charges</strong></div></td>
			<td width="13%" bgcolor="#ecf0f5" class="bodytext3"><div><strong>&nbsp;</strong></div></td>
			</tr>
			<?php
			$search1 = $_REQUEST["search1"];			  
			$query1 = "select * from master_radiology where (itemname like '%$search1%' or categoryname like '%$search1%') and status <> 'deleted' and itemcode NOT IN (SELECT itemcode FROM $radtemplate) group by itemcode order by itemcode asc LIMIT $start , $limit";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$itemcode = $res1["itemcode"];
			$itemname = $res1["itemname"];
			$categoryname = $res1["categoryname"];
			$purchaseprice = $res1["purchaseprice"];
			$rateperunit = $res1["rateperunit"];
			$expiryperiod = $res1["expiryperiod"];
			$auto_number = $res1["auto_number"];
			$itemname_abbreviation = $res1["itemname_abbreviation"];
			$taxname = $res1["taxname"];
			$taxanum = $res1["taxanum"];
			$ipmarkup = $res1["ipmarkup"];
			if($radtemplate =='NHIF_ADUAFYA'){
			$location = $res1["location"];
			}else{
			$location = $res1["locationcode"];
			}
			$rate2 = $res1['rate2'];
			$rate3 = $res1['rate3'];
			if ($expiryperiod != '0') 
			{ 
			$expiryperiod = $expiryperiod.' Months'; 
			}
			else
			{
			$expiryperiod = ''; 
			}
			/*?>	
			$query6 = "select * from master_tax where auto_number = '$taxanum'";
			$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
			$res6 = mysql_fetch_array($exec6);
			$res6taxpercent = $res6["taxpercent"];<?php */
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
			<td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="center"><input type="checkbox" name="newserselect[]" id="newserselect" value="<?php echo $itemcode;?>"></div><input type="hidden" name="numrow" id="numrow" value="<?php echo $row; ?>"></td>
			<td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?><input type="hidden" name="itemcode[]" id="itemcode" value="<?php echo $itemcode; ?>"> </td>
			<td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>
			<td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?> </td>
			<td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?> <div align="right"></div></td>
			<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rateperunit; ?></div></td>
			</tr>
			<?php
			}
			?>
			<tr> <td align="left" valign="top"  class="bodytext3"><input type='submit' value="Update" name="update" id="update"> </td></tr>
			<?php
			}
			else{
			?>			   
			<tr bgcolor="#011E6A">
			<td width="9%" bgcolor="#ecf0f5" class="bodytext3"><strong>ID / Code</strong></td>
			<td width="12%" bgcolor="#ecf0f5" class="bodytext3"><strong>Category</strong></td>
			<td width="28%" bgcolor="#ecf0f5" class="bodytext3"><strong>Radiology Item</strong></td>
			<td width="13%" bgcolor="#ecf0f5" class="bodytext3"><strong>Unit</strong>                        </td>
			<td width="9%" bgcolor="#ecf0f5" align="right" class="bodytext3"><div><strong>Charges</strong></div></td>
			<td width="12%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Edit</strong></div></td>
			</tr>
			<?php 
			$sno=0;
			$search1 = $_REQUEST["search1"];			  
			$query1 = "select * from $radtemplate where itemname like '%$search1%' and status <> 'deleted' group by itemcode order by itemcode asc LIMIT $start , $limit";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$itemcode = $res1["itemcode"];
			$itemname = $res1["itemname"];
			$categoryname = $res1["categoryname"];
			$purchaseprice = $res1["purchaseprice"];
			$rateperunit = $res1["rateperunit"];
			$expiryperiod = $res1["expiryperiod"];
			$auto_number = $res1["auto_number"];
			$itemname_abbreviation = $res1["itemname_abbreviation"];
			$taxname = $res1["taxname"];
			$taxanum = $res1["taxanum"];
			$ipmarkup = $res1["ipmarkup"];
			if($radtemplate =='NHIF_ADUAFYA'){
			$location = $res1["location"];
			}else{
			$location = $res1["locationcode"];
			}
			$rate2 = $res1['rate2'];
			$rate3 = $res1['rate3'];
			if ($expiryperiod != '0') 
			{ 
			$expiryperiod = $expiryperiod.' Months'; 
			}
			else
			{
			$expiryperiod = ''; 
			}
			/*?>	
			$query6 = "select * from master_tax where auto_number = '$taxanum'";
			$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
			$res6 = mysql_fetch_array($exec6);
			$res6taxpercent = $res6["taxpercent"];<?php */
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
			$sno = $sno + 1;
			?>
			<tr <?php echo $colorcode; ?> id="<?php echo $sno;?>">
			<!--<td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="center"><a href="radiologyitem1.php?st=del&&anum=<?php// echo $auto_number; ?>&&radtemplate=<?php //echo $radtemplate; ?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>-->
			<td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>
			<td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>
			<td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?> </td>
			<td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?> <div align="right"></div></td>
			<!--<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rateperunit; ?></div></td>-->
			<td class="bodytext31 itemrateupdate" valign="center"  align="right"><div class="mptxnno" id="caredittxno_<?php echo $sno;?>"><?php echo $rateperunit; ?></div></td>
			<td  style="display:none;" class="txnno1" width="123" align="left" valign="center"   class="bodytext31">
			<div bgcolor="#ffffff"><input class="mptxnno1" id="mptxnno_<?php  echo $sno;?>" name="mptxnno[]" style="border: 1px solid #001E6A" value=""  size="10"   onKeyDown="return disableEnterKey()" /> 
			<input type="hidden" id="tablename_<?php echo $sno;?>" name="tablename_<?php echo $sno;?>" value="<?php echo $radtemplate;?>"/>
			<input type="hidden" name="autono[]" id="autono_<?php echo $sno;?>" value="<?php echo $auto_number ?>" /></div>
			</td>
			
			<!--<td align="left" valign="top"  class="bodytext3"><div align="center"><a href="edititem1radiology.php?sanum=<?php //echo $auto_number; ?>&&itemcode=<?php //echo $itemcode; ?>&&radtemplate=<?php //echo $radtemplate; ?>" class="bodytext3">Edit</a></div></td>-->
			
			<td align="left" valign="center"  class="bodytext31 itemrateupdate"><div class="bodytext31">
			<div align="center" ><a class="edititem" id="<?php echo $sno; ?>" href="" style="padding-right: 10px;">Edit</a> </div>   </div></td>
			<td align="left" valign="center"   class="bodytext31"><div class="bodytext31"> <div align="center">
			<a style="display:none;" class="saveitem" id="s_<?php echo $sno; ?>" href="" >Update</a>
			</div>  </div></td>
			</tr>
			<?php
			}
			}
			}
			else
			{
			?>
			<tr bgcolor="#011E6A">
			<td width="9%" bgcolor="#ecf0f5" class="bodytext3"><strong>ID / Code </strong></td>
			<td width="12%" bgcolor="#ecf0f5" class="bodytext3"><strong>Category</strong></td>
			<td width="28%" bgcolor="#ecf0f5" class="bodytext3"><strong>Radiology Item</strong></td>
			<td width="13%" bgcolor="#ecf0f5" class="bodytext3"><strong>Unit</strong>    <div align="center"><strong><!--Purchase--></strong></div></td>
			<td width="9%" bgcolor="#ecf0f5" class="bodytext3" align="right"><div><strong>Charges</strong></div></td>
			<td width="13%" bgcolor="#ecf0f5" class="bodytext3" align="center"><div><strong>Action</strong></div></td>
			</tr>
			
			<?php
			$sno=0;
			$query1 = "select * from $radtemplate where status <> 'deleted' group by itemcode order by itemcode asc LIMIT $start , $limit";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$itemcode = $res1["itemcode"];
			$itemname = $res1["itemname"];
			$categoryname = $res1["categoryname"];
			$purchaseprice = $res1["purchaseprice"];
			$rateperunit = $res1["rateperunit"];
			$expiryperiod = $res1["expiryperiod"];
			$auto_number = $res1["auto_number"];
			$itemname_abbreviation = $res1["itemname_abbreviation"];
			$taxname = $res1["taxname"];
			$taxanum = $res1["taxanum"];
			$ipmarkup = $res1["ipmarkup"];
			if($radtemplate =='NHIF_ADUAFYA'){
			$location = $res1["location"];
			}else{
			$location = $res1["locationcode"];
			}
			$rate2 = $res1['rate2'];
			$rate3 = $res1['rate3'];
			if ($expiryperiod != '0') 
			{ 
			$expiryperiod = $expiryperiod.' Months'; 
			}
			else
			{
			$expiryperiod = ''; 
			}
			/*?>$query6 = "select * from master_tax where auto_number = '$taxanum'";
			$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
			$res6 = mysql_fetch_array($exec6);
			$res6taxpercent = $res6["taxpercent"];<?php */
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
			$sno = $sno + 1;
			?>
			<tr <?php echo $colorcode; ?> id="<?php echo $sno; ?>">
			<!--<td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="center"><a href="radiologyitem1.php?st=del&&anum=<?php echo $auto_number; ?>&&radtemplate=<?php echo $radtemplate; ?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>-->
			<td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>
			<td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>
			<td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?> </td>
			<td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?> <div align="right"></div></td>
			<!--<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rateperunit; ?></div></td>-->
			
			<td class="bodytext31 itemrateupdate" valign="center"  align="right"><div class="mptxnno" id="caredittxno_<?php echo $sno;?>"><?php echo $rateperunit; ?></div></td>
			<td  style="display:none;" class="txnno1" width="123" align="left" valign="center"   class="bodytext31">
			<div bgcolor="#ffffff"><input class="mptxnno1" id="mptxnno_<?php  echo $sno;?>" name="mptxnno[]" style="border: 1px solid #001E6A" value=""  size="10"   onKeyDown="return disableEnterKey()" /> 
			<input type="hidden" id="tablename_<?php echo $sno;?>" name="tablename_<?php echo $sno;?>" value="<?php echo $radtemplate;?>"/>
			<input type="hidden" name="autono[]" id="autono_<?php echo $sno;?>" value="<?php echo $auto_number ?>" /></div>
			</td>
			
			<!--<td align="left" valign="top"  class="bodytext3"><div align="center"><a href="edititem1radiology.php?sanum=<?php //echo $auto_number; ?>&&itemcode=<?php //echo $itemcode; ?>&&radtemplate=<?php //echo $radtemplate; ?>" class="bodytext3">Edit</a></div></td>-->
			
			<td align="left" valign="center"  class="bodytext31 itemrateupdate"><div class="bodytext31">
			<div align="center" ><a class="edititem" id="<?php echo $sno; ?>" href="" style="padding-right: 10px;">Edit</a> </div>   </div></td>
			<td align="left" valign="center"   class="bodytext31"><div class="bodytext31"> <div align="center">
			<a style="display:none;" class="saveitem" id="s_<?php echo $sno; ?>" href="" >Update</a>
			</div>  </div></td>
			</tr>
			<?php
			}
			}
			?>
			</tbody>
			</table>
			</form>
			<br>
			<form>
			<table width="1240" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
			<tbody>
			<tr bgcolor="#011E6A">
			<td colspan="11" bgcolor="#ecf0f5" class="bodytext3"><strong>Radiology Item Master - Deleted </strong></td>
			</tr>
			<tr bgcolor="#011E6A">
			<td colspan="11" bgcolor="#FFFFFF" class="bodytext3"><span class="bodytext32">
			<input name="search2" type="text" id="search2" size="40" value="<?php echo $search2; ?>">
			<input type="hidden" name="searchflag2" id="searchflag2" value="searchflag2">
			<input type="submit" name="Submit22" value="Search" style="border: 1px solid #001E6A" />
			</span></td>
			</tr>
			<tr bgcolor="#011E6A">
			<td width="6%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Activate</strong></div></td>
			<td width="10%" bgcolor="#ecf0f5" class="bodytext3"><strong>ID / Code </strong></td>
			<td width="13%" bgcolor="#ecf0f5" class="bodytext3"><strong>Category</strong></td>
			<td width="21%" bgcolor="#ecf0f5" class="bodytext3"><strong>radiology Item</strong></td>
			<td width="15%" bgcolor="#ecf0f5" class="bodytext3"><strong>Unit</strong></td>
			<td width="10%" bgcolor="#ecf0f5" class="bodytext3"><strong>Charges</strong></td>
			<td width="12%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Edit</strong></div></td>
			</tr>
			<?php
			if (isset($_REQUEST["searchflag2"])) { $searchflag2 = $_REQUEST["searchflag2"]; } else { $searchflag2 = ""; }
			if ($searchflag2 == 'searchflag2')
			{
			$search2 = $_REQUEST["search2"];			  
			$query1 = "select * from $radtemplate where itemname like '%$search2%'  and status = 'deleted' group by itemcode order by auto_number desc LIMIT 100";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$itemcode = $res1["itemcode"];
			$itemname = $res1["itemname"];
			$categoryname = $res1["categoryname"];
			$purchaseprice = $res1["purchaseprice"];
			$rateperunit = $res1["rateperunit"];
			$expiryperiod = $res1["expiryperiod"];
			$auto_number = $res1["auto_number"];
			$itemname_abbreviation = $res1["itemname_abbreviation"];
			$taxname = $res1["taxname"];
			$taxanum = $res1["taxanum"];
			$ipmarkup = $res1["ipmarkup"];
			if($radtemplate =='NHIF_ADUAFYA'){
			$location = $res1["location"];
			}else{
			$location = $res1["locationcode"];
			}
			$rate2 = $res1['rate2'];
			$rate3 = $res1['rate3'];
			if ($expiryperiod != '0') 
			{ 
			$expiryperiod = $expiryperiod.' Months'; 
			}
			else
			{
			$expiryperiod = ''; 
			}
			$query6 = "select * from master_tax where auto_number = '$taxanum'";
			$exec6 = mysqli_query($GLOBALS["___mysqli_ston"], $query6) or die ("Error in Query6".mysqli_error($GLOBALS["___mysqli_ston"]));
			$res6 = mysqli_fetch_array($exec6);
			$res6taxpercent = $res6["taxpercent"];
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
			<td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
			<a href="radiologyitem1temp.php?st=activate&&anum=<?php echo $auto_number; ?>&&radtemplate=<?php echo $radtemplate; ?>" class="bodytext3">
			<div align="center" class="bodytext3">Activate</div>
			</a></td>
			<td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>
			<td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>
			<td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?></td>
			<td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?></td>
			<td align="left" valign="top"  class="bodytext3"><div align="right"><span class="bodytext32"><?php echo $rateperunit; ?></span></div></td>
			<td align="left" valign="top"  class="bodytext3">
			<div align="center">
			<a href="edititem1radiology.php?sanum=<?php echo $auto_number; ?>&&itemcode=<?php echo $itemcode; ?>&&radtemplate=<?php echo $radtemplate; ?>" class="bodytext3">Edit</a></div></td>
			</tr>
			<?php
			}
			}
			else
			{
			$query1 = "select * from $radtemplate where status = 'deleted' group by itemcode order by auto_number desc LIMIT 100";
			$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($res1 = mysqli_fetch_array($exec1))
			{
			$itemcode = $res1["itemcode"];
			$itemname = $res1["itemname"];
			$categoryname = $res1["categoryname"];
			$purchaseprice = $res1["purchaseprice"];
			$rateperunit = $res1["rateperunit"];
			$expiryperiod = $res1["expiryperiod"];
			$auto_number = $res1["auto_number"];
			$itemname_abbreviation = $res1["itemname_abbreviation"];
			$taxname = $res1["taxname"];
			$taxanum = $res1["taxanum"];
			$ipmarkup = $res1["ipmarkup"];
			if($radtemplate =='NHIF_ADUAFYA'){
			$location = $res1["location"];
			}else{
			$location = $res1["locationcode"];
			}
			$rate2 = $res1['rate2'];
			$rate3 = $res1['rate3'];
			if ($expiryperiod != '0') 
			{ 
			$expiryperiod = $expiryperiod.' Months'; 
			}
			else
			{
			$expiryperiod = ''; 
			}
			/*<?php ?>$query6 = "select * from master_tax where auto_number = '$taxanum'";
			$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
			$res6 = mysql_fetch_array($exec6);
			$res6taxpercent = $res6["taxpercent"];
			<?php ?>*/
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
			<td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
			<a href="radiologyitem1temp.php?st=activate&&anum=<?php echo $auto_number; ?>&&radtemplate=<?php echo $radtemplate; ?>" class="bodytext3">
			<div align="center" class="bodytext3">Activate</div>
			</a></td>
			<td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>
			<td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>
			<td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?></td>
			<td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?></td>
			<td align="left" valign="top"  class="bodytext3"><div align="right"><span class="bodytext32"><?php echo $rateperunit; ?></span></div></td>
			<td align="left" valign="top"  class="bodytext3">
			<div align="center">
			<a href="edititem1radiology.php?sanum=<?php echo $auto_number; ?>&&itemcode=<?php echo $itemcode; ?>&&radtemplate=<?php echo $radtemplate; ?>" class="bodytext3">Edit</a></div></td>
			</tr>
			<?php
			}
			}
			?>
			<tr>
			<td colspan="6" align="middle" >&nbsp;</td>
			</tr>
			</tbody>
			</table>
			</form>
			</td>
			</tr>            <tr>
              <td>&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
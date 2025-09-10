<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";  
$bgcolorcode = "";
$colorloopcount = "";

//to redirect if there is no entry in masters category or item.
if (!isset($_SESSION['labtablename'])){$_SESSION['labtablename']='master_lab';}
if (isset($_REQUEST["labtemplate"])) { $labtemplate = $_REQUEST["labtemplate"]; $_SESSION['labtablename']=$labtemplate; } else { $labtemplate = $_SESSION['labtablename']; }
if (isset($_REQUEST['update'])){}


	$itemname = '';
	$rateperunit  = '0.00';
	$purchaseprice  = '0.00';
	$description='';
	$referencevalue = '';
	
	
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update $labtemplate set status = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update $labtemplate set status = '' where auto_number = '$delanum'";
	$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
}


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add lab Item To Proceed For Billing.";
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
<script type="text/javascript" src="js/insertnewitemlab.js"></script>
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
		alert ("Please Enter lab Item Code or ID.");
		document.form1.itemcode.focus();
		return false;
	}
	
	if (document.form1.itemname.value == "")
	{
		alert ("Pleae Enter lab Item Name.");
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
			alert ("Your lab Item Name Has Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ These are not allowed.");
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

function btnDeleteClick10(delID)
{
	//alert ("Inside btnDeleteClick.");
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
				  <form>
                <table width="1200" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="12" bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><strong>Lab Item Master - Existing List - Latest 100 Lab Items </strong></span></td>
						<td colspan="4" bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">
						<?php //error_reporting(0);
						if($searchflag1 == 'searchflag1'){
							$tbl_name="master_lab";		//your table name
							// How many adjacent pages should be shown on each side?
							$adjacents = 3;
							$search1 = $_REQUEST["search1"];
							/* 
							   First get total number of rows in data table. 
							   If you have a WHERE clause in your query, make sure you mirror it here.
							*/
							$query111 = "select * from $labtemplate where itemname like '%$search1%' or categoryname like '%$search1%' and  status <> 'deleted' group by itemcode order by auto_number desc";
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
									$pagination.= "<a href=\"$targetpage?labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=$prev\" style='color:#3b3b3c;'>previous</a>";
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
											$pagination.= "<a href=\"$targetpage?labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
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
												$pagination.= "<a href=\"$targetpage?labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
										}
										$pagination.= "...";
										$pagination.= "<a href=\"$targetpage?labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=$lpm1\"style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";
										$pagination.= "<a href=\"$targetpage?labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=$lastpage\"style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";		
									}
									//in middle; hide some front and some back
									elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
									{
										$pagination.= "<a href=\"$targetpage?labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=1\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";
										$pagination.= "<a href=\"$targetpage?labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=2\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";
										$pagination.= "...";
										for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
										{
											if ($counter == $page)
												$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
											else
												$pagination.= "<a href=\"$targetpage?page=labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
										}
										$pagination.= "...";
										$pagination.= "<a href=\"$targetpage?page=labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&$lpm1\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";
										$pagination.= "<a href=\"$targetpage?page=labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&$lastpage\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";		
									}
									//close to end; only hide early pages
									else
									{
										$pagination.= "<a href=\"$targetpage?labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=1\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";
										$pagination.= "<a href=\"$targetpage?labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=2\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";
										$pagination.= "...";
										for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
										{
											if ($counter == $page)
												$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
											else
												$pagination.= "<a href=\"$targetpage?labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
										}
									}
								}
								
								//next button
								if ($page < $counter - 1) 
									$pagination.= "<a href=\"$targetpage?labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=$next\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</a>";
								else
									$pagination.= "<span class=\"disabled\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</span>";
								echo $pagination.= "</div>\n";		
							}
						}
						else
						{
						
							$tbl_name="master_lab";		//your table name
							// How many adjacent pages should be shown on each side?
							$adjacents = 3;
							//$search1 = $_REQUEST["search1"];
							/* 
							   First get total number of rows in data table. 
							   If you have a WHERE clause in your query, make sure you mirror it here.
							*/
							$query111 = "select * from $labtemplate where status <> 'deleted' group by itemcode order by auto_number desc";
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
									$pagination.= "<a href=\"$targetpage?labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=$prev\" style='color:#3b3b3c;'>previous</a>";
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
											$pagination.= "<a href=\"$targetpage?labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
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
												$pagination.= "<a href=\"$targetpage?labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
										}
										$pagination.= "...";
										$pagination.= "<a href=\"$targetpage?labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=$lpm1\"style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";
										$pagination.= "<a href=\"$targetpage?labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=$lastpage\"style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";		
									}
									//in middle; hide some front and some back
									elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
									{
										$pagination.= "<a href=\"$targetpage?labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=1\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";
										$pagination.= "<a href=\"$targetpage?labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=2\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";
										$pagination.= "...";
										for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
										{
											if ($counter == $page)
												$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
											else
												$pagination.= "<a href=\"$targetpage?page=labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
										}
										$pagination.= "...";
										$pagination.= "<a href=\"$targetpage?page=labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&$lpm1\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";
										$pagination.= "<a href=\"$targetpage?page=labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&$lastpage\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";		
									}
									//close to end; only hide early pages
									else
									{
										$pagination.= "<a href=\"$targetpage?labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=1\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";
										$pagination.= "<a href=\"$targetpage?labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=2\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";
										$pagination.= "...";
										for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
										{
											if ($counter == $page)
												$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
											else
												$pagination.= "<a href=\"$targetpage?labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
										}
									}
								}
								
								//next button
								if ($page < $counter - 1) 
									$pagination.= "<a href=\"$targetpage?labtemplate=$labtemplate&&searchflag1=$searchflag1&&search1=$search1&&page=$next\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</a>";
								else
									$pagination.= "<span class=\"disabled\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</span>";
								echo $pagination.= "</div>\n";		
							}
							
						
						}
						?>
						</span></td>
                         <?php if($total_pages > 0)
			 { 
			  ?>	 
				 <td align="left" valign="center" bgcolor="#ecf0f5" class="bodytext31" ><a target="_blank" href="print_labitemtemp.php?locationcode=<?php echo $locationcode; ?>&&labtemp=<?=$labtemplate?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>
              <?php
		      }
		   ?>
                      </tr>
                      <tr bgcolor="#011E6A">
                        <td colspan="3" bgcolor="#FFFFFF" class="bodytext3">
						<input name="search1" type="text" id="search1" size="40" value="<?php echo $search1; ?>">
						<input type="hidden" name="searchflag1" id="searchflag1" value="searchflag1">
                          </td>
						  <td colspan="13" bgcolor="#FFFFFF" class="bodytext3">
						<input type="hidden" name="labtemplate" id="labtemplate" value="master_lab" style="border: 1px solid #001E6A;">
			
                          <input type="submit" name="Submit2" value="Search" style="border: 1px solid #001E6A" />
						  </td> 
                        </tr>
               
                      <?php
	  if ($searchflag1 == 'searchflag1')
	  {
				  
		$search1 = $_REQUEST["search1"];
		
			?>
			       <tr bgcolor="#011E6A">
                        <td width="5%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Delete</strong></div></td>
                        <td width="7%" bgcolor="#ecf0f5" class="bodytext3"><strong>ID / Code </strong></td>
                        <td width="14%" bgcolor="#ecf0f5" class="bodytext3"><strong>Category</strong></td>
                        <td width="27%" bgcolor="#ecf0f5" class="bodytext3"><strong>lab Item</strong></td>
                        <td width="4%" bgcolor="#ecf0f5" class="bodytext3"><strong>Unit</strong></td>
                        <td width="9%" bgcolor="#ecf0f5" class="bodytext3"><strong>Sample Type</strong></td>
						 <td width="9%" bgcolor="#ecf0f5" class="bodytext3"><strong>Reference</strong></td>
						  <td width="9%" bgcolor="#ecf0f5" class="bodytext3"><strong>Ref.Unit</strong></td>
						   <td width="9%" bgcolor="#ecf0f5" class="bodytext3"><strong>Range</strong></td>
                        <td width="9%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Tax%</strong></div></td>
						 <td width="9%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>IP Markup</strong></div></td>
                        <td width="10%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Charges</strong></div></td>
						 <td width="10%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Rate2</strong></div></td>
						  <td width="10%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Rate3</strong></div></td>
						 <td width="10%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Location</strong></div></td>
                        <td width="4%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Edit</strong></div></td>
                      </tr>
					  
					  <?php	
		
					  
	    $query1 = "select * from $labtemplate where itemname like '%$search1%' or categoryname like '%$search1%' and status <> 'deleted' group by itemcode order by auto_number desc LIMIT $start , $limit";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$itemcode = $res1["itemcode"];
		$itemname = $res1["itemname"];
		$categoryname = $res1["categoryname"];
		$purchaseprice = $res1["purchaseprice"];
		$sampletype= $res1["sampletype"];
		$rateperunit = $res1["rateperunit"];
		$expiryperiod = $res1["expiryperiod"];
		$auto_number = $res1["auto_number"];
		$itemname_abbreviation = $res1["itemname_abbreviation"];
		$taxname = $res1["taxname"];
		$taxanum = $res1["taxanum"];
		$ipmarkup = $res1["ipmarkup"];
		$location = $res1["location"];
		$referencename = $res1['referencename'];
		$referenceunit = $res1['referenceunit'];
		$referencerange = $res1['referencerange'];
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
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="center"><a href="labitem1interpret.php?st=del&&anum=<?php echo $auto_number; ?>&&labtemplate=<?php echo $labtemplate;?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?> </td>
						 <td align="left" valign="top"  class="bodytext3"><?php echo $sampletype; ?> </td>
						  <td align="left" valign="top"  class="bodytext3"><?php echo $referencename; ?> </td>
						   <td align="left" valign="top"  class="bodytext3"><?php echo $referenceunit; ?> </td>
						    <td align="left" valign="top"  class="bodytext3"><?php echo $referencerange; ?> </td>
                      <td align="left" valign="top"  class="bodytext3"><?php echo $res6taxpercent; ?> </td>
					   <td align="left" valign="top"  class="bodytext3"><?php echo $ipmarkup; ?> </td>
                       
                        <td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rateperunit; ?></div></td>
						<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate2; ?></div></td>
						<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate3; ?></div></td>
						 <td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $location; ?></div></td>
                        <td width="4%" align="left" valign="top"  class="bodytext3">
						  <div align="center">
						  <a href="edititem1interpret.php?sanum=<?php echo $auto_number; ?>&&itemcode=<?php echo $itemcode; ?>&&labtemplate=<?php echo $labtemplate; ?>" class="bodytext3">Edit</a></div></td>
                      </tr>
                      <?php
		}

	}
	else
	{
		?>
        <tr bgcolor="#011E6A">
        <td width="5%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Delete</strong></div></td>
        <td width="7%" bgcolor="#ecf0f5" class="bodytext3"><strong>ID / Code </strong></td>
        <td width="14%" bgcolor="#ecf0f5" class="bodytext3"><strong>Category</strong></td>
        <td width="27%" bgcolor="#ecf0f5" class="bodytext3"><strong>lab Item</strong></td>
        <td width="4%" bgcolor="#ecf0f5" class="bodytext3"><strong>Unit</strong></td>
        <td width="9%" bgcolor="#ecf0f5" class="bodytext3"><strong>Sample Type</strong></td>
         <td width="9%" bgcolor="#ecf0f5" class="bodytext3"><strong>Reference</strong></td>
          <td width="9%" bgcolor="#ecf0f5" class="bodytext3"><strong>Ref.Unit</strong></td>
           <td width="9%" bgcolor="#ecf0f5" class="bodytext3"><strong>Range</strong></td>
        <td width="9%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Tax%</strong></div></td>
         <td width="9%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>IP Markup</strong></div></td>
        <td width="10%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Charges</strong></div></td>
         <td width="10%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Rate2</strong></div></td>
          <td width="10%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Rate3</strong></div></td>
         <td width="10%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Location</strong></div></td>
        <td width="4%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Edit</strong></div></td>
      </tr>
        <?php
		$query1 = "select * from $labtemplate where status <> 'deleted' group by itemcode order by auto_number desc LIMIT $start , $limit";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$itemcode = $res1["itemcode"];
		$itemname = $res1["itemname"];
		$categoryname = $res1["categoryname"];
		$purchaseprice = $res1["purchaseprice"];
		$sampletype= $res1["sampletype"];
		$rateperunit = $res1["rateperunit"];
		$expiryperiod = $res1["expiryperiod"];
		$auto_number = $res1["auto_number"];
		$itemname_abbreviation = $res1["itemname_abbreviation"];
		$taxname = $res1["taxname"];
		$taxanum = $res1["taxanum"];
		$ipmarkup = $res1["ipmarkup"];
		$location = $res1["location"];
		$referencename = $res1['referencename'];
		$referenceunit = $res1['referenceunit'];
		$referencerange = $res1['referencerange'];
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
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="center"><a href="labitem1interpret.php?st=del&&anum=<?php echo $auto_number; ?>&&labtemplate=<?php echo $labtemplate;?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $sampletype; ?> </td>
						  <td align="left" valign="top"  class="bodytext3"><?php echo $referencename; ?> </td>
						   <td align="left" valign="top"  class="bodytext3"><?php echo $referenceunit; ?> </td>
						    <td align="left" valign="top"  class="bodytext3"><?php echo $referencerange; ?> </td>
                     
						 <td align="left" valign="top"  class="bodytext3"><?php echo $res6taxpercent; ?> </td>
					   <td align="left" valign="top"  class="bodytext3"><?php echo $ipmarkup; ?> </td>
                   
                        
                        <td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rateperunit; ?></div></td>
						<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate2; ?></div></td>
						<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate3; ?></div></td>
						<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $location; ?></div></td>
                        <td align="left" valign="top"  class="bodytext3">
						  <div align="center">
						  <a href="edititem1interpret.php?sanum=<?php echo $auto_number; ?>&&itemcode=<?php echo $itemcode; ?>&&labtemplate=<?php echo $labtemplate; ?>" class="bodytext3">Edit</a></div></td>
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
                <table width="1200" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="15" bgcolor="#ecf0f5" class="bodytext3"><strong>lab Item Master - Deleted </strong></td>
                      </tr>
                      <tr bgcolor="#011E6A">
                        <td colspan="15" bgcolor="#FFFFFF" class="bodytext3"><span class="bodytext32">
                          <input name="search2" type="text" id="search2" size="40" value="<?php echo $search2; ?>">
                          <input type="hidden" name="searchflag2" id="searchflag2" value="searchflag2">
                          <input type="submit" name="Submit22" value="Search" style="border: 1px solid #001E6A" />
                        </span></td>
                        </tr>
                      <tr bgcolor="#011E6A">
						<td width="6%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Activate</strong></div></td>
						<td width="10%" bgcolor="#ecf0f5" class="bodytext3"><strong>ID / Code </strong></td>
						<td width="13%" bgcolor="#ecf0f5" class="bodytext3"><strong>Category</strong></td>
						<td width="17%" bgcolor="#ecf0f5" class="bodytext3"><strong>lab Item</strong></td>
						<td width="6%" bgcolor="#ecf0f5" class="bodytext3"><strong>Unit</strong></td>
						<td width="9%" bgcolor="#ecf0f5" class="bodytext3"><strong>Sample Type</strong></td>
						<td width="9%" bgcolor="#ecf0f5" class="bodytext3"><strong>Reference</strong></td>
						<td width="9%" bgcolor="#ecf0f5" class="bodytext3"><strong>Ref.Unit</strong></td>
						<td width="9%" bgcolor="#ecf0f5" class="bodytext3"><strong>Range</strong></td>
						<td width="9%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Tax%</strong></div></td>
						<td width="9%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>IP Markup</strong></div></td>
						<td width="8%" bgcolor="#ecf0f5" class="bodytext3"><strong>Charges</strong></td>
						<td width="10%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Rate2</strong></div></td>
						<td width="10%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Rate3</strong></div></td>
						<td width="11%" bgcolor="#ecf0f5" class="bodytext3"><strong>Location</strong></td>
                      </tr>
                      <?php
		if (isset($_REQUEST["searchflag2"])) { $searchflag2 = $_REQUEST["searchflag2"]; } else { $searchflag2 = ""; }
	  if ($searchflag2 == 'searchflag2')
	  {
					  
		$search2 = $_REQUEST["search2"];			  
	    $query1 = "select * from $labtemplate where itemname like '%$search2%' or categoryname like '%$search1%' and status = 'deleted' group by itemcode order by auto_number desc LIMIT 100";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$itemcode = $res1["itemcode"];
		$itemname = $res1["itemname"];
		$categoryname = $res1["categoryname"];
		$purchaseprice = $res1["purchaseprice"];
		$sampletype= $res1["sampletype"];
		$rateperunit = $res1["rateperunit"];
		$expiryperiod = $res1["expiryperiod"];
		$auto_number = $res1["auto_number"];
		$itemname_abbreviation = $res1["itemname_abbreviation"];
		$taxname = $res1["taxname"];
		$taxanum = $res1["taxanum"];
		$ipmarkup = $res1["ipmarkup"];
		$location = $res1["location"];
		$referencename = $res1['referencename'];
		$referenceunit = $res1['referenceunit'];
		$referencerange = $res1['referencerange'];
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
		<a href="labitem1interpret.php?st=activate&&anum=<?php echo $auto_number; ?>&&labtemplate=<?php echo $labtemplate;?>" class="bodytext3">
		<div align="center" class="bodytext3">Activate</div>
		</a></td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?></td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?></td>
		
		<td align="left" valign="top"  class="bodytext3"><?php echo $sampletype; ?></td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $referencename; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $referenceunit; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $referencerange; ?> </td>
		
		<td align="left" valign="top"  class="bodytext3"><?php echo $res6taxpercent; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $ipmarkup; ?> </td>
		
		<td align="left" valign="top"  class="bodytext3"><div align="right"><span class="bodytext32"><?php echo $rateperunit; ?></span></div></td>
		<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate2; ?></div></td>
		<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate3; ?></div></td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $location; ?> </td>
		</tr>
                      <?php
		}
	}
	else
	{
		
	    $query1 = "select * from $labtemplate where status = 'deleted' group by itemcode order by auto_number desc LIMIT 100";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while ($res1 = mysqli_fetch_array($exec1))
		{
		$itemcode = $res1["itemcode"];
		$itemname = $res1["itemname"];
		$categoryname = $res1["categoryname"];
		$purchaseprice = $res1["purchaseprice"];
		$sampletype= $res1["sampletype"];
		$rateperunit = $res1["rateperunit"];
		$expiryperiod = $res1["expiryperiod"];
		$auto_number = $res1["auto_number"];
		$itemname_abbreviation = $res1["itemname_abbreviation"];
		$ipmarkup = $res1["ipmarkup"];
		$location = $res1["location"];
		$taxanum = $res1["taxanum"];
		$referencename = $res1['referencename'];
		$referenceunit = $res1['referenceunit'];
		$referencerange = $res1['referencerange'];
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
		<a href="labitem1interpret.php?st=activate&&anum=<?php echo $auto_number; ?>&&labtemplate=<?php echo $labtemplate;?>" class="bodytext3">
		<div align="center" class="bodytext3">Activate</div>
		</a></td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?></td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?></td>
		
		<td align="left" valign="top"  class="bodytext3"><?php echo $sampletype; ?></td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $referencename; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $referenceunit; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $referencerange; ?> </td>
		
		<td align="left" valign="top"  class="bodytext3"><?php echo $res6taxpercent; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $ipmarkup; ?> </td>
		
		<td align="left" valign="top"  class="bodytext3"><div align="right"><span class="bodytext32"><?php echo $rateperunit; ?></span></div></td>
		<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate2; ?></div></td>
		<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate3; ?></div></td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $location; ?> </td>
		</tr>
                      <?php
		}
	}
		?>
                      <tr>
                        <td colspan="9" align="middle" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
              </form>
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
<?php include ("includes/footer1.php"); ?>
</body>
</html>


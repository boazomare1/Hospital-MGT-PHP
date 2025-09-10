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

 $loccountloop=isset($_REQUEST['locationcount'])?$_REQUEST['locationcount']:'';
$pkg=isset($_REQUEST['pkg'])?$_REQUEST['pkg']:'no';

if (isset($_REQUEST["searchflag1"])) { $searchflag1 = $_REQUEST["searchflag1"]; } else { $searchflag1 = ""; }
if (isset($_REQUEST["searchflag2"])) { $searchflag2 = $_REQUEST["searchflag2"]; } else { $searchflag2 = ""; }
if (isset($_REQUEST["search1"])) { $search1 = $_REQUEST["search1"]; } else { $search1 = ""; }
if (isset($_REQUEST["search2"])) { $search2 = $_REQUEST["search2"]; } else { $search2 = ""; }
$locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
$num='';
$num1='';
$num2='';
$num3='';

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
	
	
	var ifcount=0;
	var lcheck='lcheck';
	//var lcheckk='lcheck3';
	//alert(document.form1.lcheck.value);
	var lcount=document.form1.locationcount.value;
	
	if(lcount!=0)
	{
		for(var i=1; i<=lcount; i++)
		{
			if(document.form1.elements["lcheck"+i].checked == true)
			{ ifcount=ifcount+1;}
			/*var lname=lcheck+i;
			alert(lname);
			alert(document.form1.elements[lname].value);*/
			//alert(document.getElementById("icheck"+i).value);
		}
		if(ifcount==0)
		{
			alert('Please select atleast one Location');
			return false;
		}
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
*/

//var ifcount=0;
//	var lcheck='lcheck';
//	//var lcheckk='lcheck3';
//	//alert(document.form1.lcheck.value);
//	var lcount=document.form1.locationcount.value;
//	
//	if(lcount!=0)
//	{
//		for(var i=1; i<=lcount; i++)
//		{
//			if(document.form1.elements["lcheck"+i].checked == true)
//			{ ifcount=ifcount+1;}
//			/*var lname=lcheck+i;
//			alert(lname);
//			alert(document.form1.elements[lname].value);*/
//			//alert(document.getElementById("icheck"+i).value);
//		}
//		if(ifcount==0)
//		{
//			alert('Please select atleast one Location');
//			return false;
//		}
//	}

}

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
      
     </tr> 
      <table width="400" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
         
   			<form name="form1" id="form1" method="post" action="radiologyitemsbylocation.php" onSubmit="return additem1process1()">
                  <table width="900" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><strong>Radiology Item View</strong></td>
                      </tr>
                      <tr>
   				 <td colspan="3"  bgcolor="#FFFFFF" width="1%">&nbsp;</td>
                  
                 </tr>
					<tr>
                    <td  bgcolor="#FFFFFF" class="bodytext3" align="left" ><strong>Location</strong></td>
                    <td colspan="2" align="left" bgcolor="#FFFFFF" class="bodytext3"><select name="location" id="location" >
                    <option value="">Select Location </option>
                     <?php $query1 = "select locationcode,locationname,prefix,suffix from master_location where status <> 'deleted' order by locationname";
						$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
						$incr=0;
						while ($res1 = mysqli_fetch_array($exec1))
						{
						$locationcode = $res1["locationcode"];
						$locationname = $res1["locationname"];
						?>
                        
                         <option value="<?php echo $locationcode; ?>" <?php if($location!=''){if($location == $locationcode){echo "selected";}}?>><?php echo $locationname; ?></option>
                        <?php
						}
						?>
                        </select>
                       </td>
                      
                       </tr>
                       <tr>
                       <td colspan="1" bgcolor="#FFFFFF"></td>	
                          <td colspan="2" bgcolor="#FFFFFF" class="bodytext3"> <input type="submit" name="Submit" value="Search" style="border: 1px solid #001E6A" /> </td>
                        
                    </tr>	
                       
                      <tr>
                        
                        <td width="20%" align="left" valign="top"  bgcolor="#ecf0f5"><input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
                                                 </td>
                          <td width="18%" align="left" valign="top"  bgcolor="#ecf0f5" class="bodytext3">&nbsp;</td>
                        <td width="46%" align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
                        <td width="16%" align="left" valign="top"  bgcolor="#ecf0f5">&nbsp;</td>
                      </tr>
                    </tbody>
                    </table>
                    
                  </table>
				  </form>
                 
                  <?php 
				  
				 // if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
			
				 
				 
				  ?>
				  <form>
                <table width="900" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32"><strong>Radiology Item Master - Existing List - Latest 100 radiology Items </strong></span></td>
						<td colspan="3" bgcolor="#ecf0f5" class="bodytext3"><span class="bodytext32">
						<?php //error_reporting(0);
						if($searchflag1 != 'searchflag1'){
							$tbl_name="master_lab";		//your table name
							// How many adjacent pages should be shown on each side?
							$adjacents = 3;
						 $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
							/* 
							   First get total number of rows in data table. 
							   If you have a WHERE clause in your query, make sure you mirror it here.
							*/
							$query111 = "select * from master_radiology where locationcode='$locationcode' and status <> 'deleted' order by auto_number desc";
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
									$pagination.= "<a href=\"$targetpage?page=$prev&&location=$locationcode\" style='color:#3b3b3c;'>previous</a>";
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
											$pagination.= "<a href=\"$targetpage?page=$counter&&location=$locationcode\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
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
												$pagination.= "<a href=\"$targetpage?page=$counter&&location=$locationcode\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
										}
										$pagination.= "...";
										$pagination.= "<a href=\"$targetpage?page=$lpm1&&location=$locationcode\"style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";
										$pagination.= "<a href=\"$targetpage?page=$lastpage&&location=$locationcode\"style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";		
									}
									//in middle; hide some front and some back
									elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
									{
										$pagination.= "<a href=\"$targetpage?page=1&&location=$locationcode\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";
										$pagination.= "<a href=\"$targetpage?page=2&&location=$locationcode\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";
										$pagination.= "...";
										for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
										{
											if ($counter == $page)
												$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
											else
												$pagination.= "<a href=\"$targetpage?page=$counter&&location=$locationcode\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
										}
										$pagination.= "...";
										$pagination.= "<a href=\"$targetpage?page=$lpm1&&location=$locationcode\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";
										$pagination.= "<a href=\"$targetpage?page=$lastpage&&location=$locationcode\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";		
									}
									//close to end; only hide early pages
									else
									{
										$pagination.= "<a href=\"$targetpage?page=1&&location=$locationcode\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";
										$pagination.= "<a href=\"$targetpage?page=2&&location=$locationcode\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";
										$pagination.= "...";
										for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
										{
											if ($counter == $page)
												$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
											else
												$pagination.= "<a href=\"$targetpage?page=$counter&&location=$locationcode\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
										}
									}
								}
								
								//next button
								if ($page < $counter - 1) 
									$pagination.= "<a href=\"$targetpage?page=$next&&location=$locationcode\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</a>";
								else
									$pagination.= "<span class=\"disabled\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</span>";
								echo $pagination.= "</div>\n";		
							}
						}
						?>
						</span></td>
                                               
                   	<td bgcolor="#ecf0f5" align="left"><a href="print_radiologyviewxl.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $locationcode; ?>&&search=<?php echo $search1; ?>&&type=active"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>

                      </tr> 
                    
                      <tr bgcolor="#011E6A">
                        <td colspan="6" bgcolor="#FFFFFF" class="bodytext3">
						<input name="search1" type="text" id="search1" size="40" value="<?php echo $search1; ?>">
						<input type="hidden" name="searchflag1" id="searchflag1" value="searchflag1">
                        <input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode; ?>">
                      
                        
                          <input type="submit" name="Submit2" value="Search" style="border: 1px solid #001E6A" /></td>
                        </tr>
                      <tr bgcolor="#011E6A">
                       
                        <td width="9%" bgcolor="#ecf0f5" class="bodytext3"><strong>ID / Code </strong></td>
                        <td width="12%" bgcolor="#ecf0f5" class="bodytext3"><strong>Category</strong></td>
                        <td width="28%" bgcolor="#ecf0f5" class="bodytext3"><strong>Radiology Item</strong></td>
                       <!-- <td width="13%" bgcolor="#ecf0f5" class="bodytext3"><strong>Unit</strong>                          <div align="center"><strong></strong></div></td>
                        <td width="9%" bgcolor="#ecf0f5" class="bodytext3"><div><strong>Charges</strong></div></td>
						 
						  <td width="10%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Rate3</strong></div></td>-->
						<td width="5%" bgcolor="#ecf0f5" class="bodytext3"><div><strong>IP Markup</strong></div></td>
                        <td width="10%" bgcolor="#ecf0f5" class="bodytext3"><div align="center"><strong>Rate</strong></div></td>
						<!--<td width="13%" bgcolor="#ecf0f5" class="bodytext3"><div><strong>Location</strong></div></td>-->
						 
                       </tr>
                      <?php
	  if ($searchflag1 == 'searchflag1')
	  {
			$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';		  
		$search1 = $_REQUEST["search1"];			  
	    $query1 = "select * from master_radiology where locationcode='$locationcode' and (itemname like '%$search1%' or categoryname like '%$search1%') and status <> 'deleted' group by itemcode order by auto_number desc LIMIT 100";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num=mysqli_num_rows($exec1);
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
		$location = $res1["location"];
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
                      <!--  <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="center"><a href="radiologyitem1.php?st=del&&anum=<?php echo $auto_number; ?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>-->
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?> </td>
                        <?php /*?><!--<td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?> <div align="right"></div></td>
                        
						<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate2; ?></div></td>
						<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate3; ?></div></td>--><?php */?>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $ipmarkup; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><div align="center"><?php echo $rateperunit; ?></div></td>
						 <?php /*?><!--<td align="left" valign="top"  class="bodytext3"><?php echo $location; ?></td>--><?php */?>
						  <!-- <td align="left" valign="top"  class="bodytext3">
						  <div align="center">
						  <a href="edititem1radiology.php?sanum=<?php echo $auto_number; ?>&&itemcode=<?php echo $itemcode; ?>" class="bodytext3">Edit</a></div></td>-->
                      </tr>
                      <?php
		}
	if($num != 0)
	{
	?>
    <tr>
                     <td colspan="8" align="right"><a  href="print_radiologyviewxl.php?cbfrmflag1=cbfrmflag1&&locationcode=<?php echo $locationcode; ?>&&search=<?php echo $search1; ?>&&type=active"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>
                     </tr>
    <?php 
	}
	  }
	else
	{
	$query1 = "select * from master_radiology where locationcode='$locationcode' and status <> 'deleted'  group by itemcode  order by auto_number desc LIMIT $start , $limit";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$num1=mysqli_num_rows($exec1);
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
		$location = $res1["location"];
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
		  
		?>
        <tr <?php echo $colorcode; ?>>
                        <!--<td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="center"><a href="radiologyitem1.php?st=del&&anum=<?php echo $auto_number; ?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>-->
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?> </td>
                       <?php /*?><!-- <td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?> <div align="right"></div></td>
                        <td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rateperunit; ?></div></td>
						<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate2; ?></div></td>
						<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate3; ?></div></td>--><?php */?>
						  <td align="center" valign="top"  class="bodytext3"><?php echo $ipmarkup; ?></td>
                            <td align="left" valign="top"  class="bodytext3"><div align="center"><?php echo $rateperunit; ?></div></td>
                          
						 <?php /*?><!--<td align="left" valign="top"  class="bodytext3"><?php echo $location; ?></td>--><?php */?>
						 <!-- <td align="left" valign="top"  class="bodytext3">
						  <div align="center">
						  <a href="edititem1radiology.php?sanum=<?php echo $auto_number; ?>&&itemcode=<?php echo $itemcode; ?>" class="bodytext3">Edit</a></div></td>-->
                     </tr>
                    
						 
                      <?php
		}
	}
	
                     ?>
                     
                     
                    </tbody>
                  </table>
				  </form>
				
				  
              
              <?php 
			//	}
              ?>
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


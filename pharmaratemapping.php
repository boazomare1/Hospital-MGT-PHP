<?php
//error_reporting(0);
error_reporting(~E_ALL);
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$lastid = "";
$columnname = "";
$altersql = "";
$searchflag1="";
$search1="";

if (isset($_POST["frmflag2"])) { $frmflag2 = $_POST["frmflag2"]; } else { $frmflag2 = ""; }
if ($frmflag2 == 'frmflag2')
{

 	if (isset($_POST["save"])) { $save = $_POST["save"]; } else { $save = ""; }
  
	if (isset($_POST["save"])) {
			
			$checked_arr = $_POST['surveychk'];
			$templateautono1 = $_POST['templateautono'];
			if($templateautono1 !=""){
				$templateautono = $_POST['templateautono'];
			}else{
				$templateautono = $_POST['templateautoid1'];
			}
			
			//$updatecolumname = "subtype_".$subtypeautono;
			
			$count = count($checked_arr);
		if($count > 0){

	        foreach($_REQUEST['surveychk'] as $key=>$value){
				$auto_id = $_POST['surveychk'][$key];  
				$updaterate = $_POST['rate'.$auto_id];
				$itemcode = $_POST['itemcode'.$auto_id];
				$templatecode = $_POST['templateautocode'.$auto_id];
				// check if exists first
				$date = date("Y-m-d");

				 $query341 = "SELECT * FROM pharma_template_map where templateid='$templatecode' and productcode='$itemcode'";
				 $exec341 = mysqli_query($GLOBALS["___mysqli_ston"], $query341) or die ("Error in Query34".mysqli_error($GLOBALS["___mysqli_ston"]));
				 $res341 = mysqli_fetch_array($exec341);
				 $rowcount341 = mysqli_num_rows($exec341);
				 if($rowcount341 > 0)
				 {
				 	$sqlquery= "UPDATE pharma_template_map SET rate = '$updaterate' WHERE productcode = '$itemcode' and templateid = '$templatecode' ";
				    $exequery = mysqli_query($GLOBALS["___mysqli_ston"], $sqlquery);
				 }else{
				 	$sqlquery= "INSERT INTO pharma_template_map(templateid, productcode, rate, username,dateadded, recordstatus) VALUES ('$templatecode','$itemcode','$updaterate','$username','$date','')";
				    $exequery = mysqli_query($GLOBALS["___mysqli_ston"], $sqlquery);
				 }
				
			 
				$bgcolorcode = 'Success';	
				$errmsg = "Pharmacy Template Rate Updated Successfully";
			}
		   //exit;	
		}else{
			$bgcolorcode = 'failed';	
			$errmsg = "Please Select item for Update";
 
		}	
	
	header("Location: pharmaratemapping.php");		
	}

}

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["searchflag1"])) { $searchflag1 = $_REQUEST["searchflag1"]; } else { $searchflag1 = ""; }
if(isset($_REQUEST['sid'])){ $sid=$_REQUEST['sid'];} else { $sid="";}
								
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

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>

<link type="text/css" rel="stylesheet" href="css/jquery-ui.min.css" />

<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/jquerys-ui.min.js"></script>

</head>
<script language="javascript">
$(document).ready(function(){
	//alert("----");
	$("#save").hide();

	
	$('input.selectchk').change(function (){
	  var lenchkbox1 = $('input.selectchk:checked').length; 
        //alert(lenchkbox1);
		if(lenchkbox1 <= 0){
			$("#save").hide();		
		}else{
			$("#save").show();
			
		}

});   
	
});

$(function() {
	
$('#template').autocomplete({
		
	source:'ajaxpharmacytempsearch.php', 
	//alert(source);
	minLength:1,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var templatename = ui.item.templatename;
			var templateautono = ui.item.templateautono;
			$('#templateid').val(templateautono); 
			$('#template').val(templatename);
			$('#templatename').val(templatename);
			$("#search").focus();	
		},
    });
});

function addward1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.subtype.value == "")
	{
		alert ("Pleae Enter Sub Type Name.");
		document.form1.subtype.focus();
		return false;
	}

}

	function checkAll1(event,id){

		if(event.checked) {
          // Iterate each checkbox
          $('.surveychk'+id+'').each(function() {
			// alert(this.checked);
            this.checked = true;                        
          });
		  $("#save").show();
        } 
		else {
          // Iterate each checkbox
          $('.surveychk'+id+'').each(function() {
			// alert(this.checked);
            this.checked = false;                        
          });
		  $("#save").hide();
        }
    
	}
	
	function updaterate(e,autono){
		//alert(autono);
		
		//$(e).css("background","#FFF");
		var itemcode1 = $("#itemcode"+autono).val();
		var rate = $("#rate"+autono).val();
		var tempcode = $("#templateautocode"+autono).val();
		var itemname = $("#itemname"+autono).val();
		//alert(subtypename);
		var data = "itemcode="+itemcode1+"&&rate="+rate+"&&tempcode="+tempcode;
		//alert(data);
		$.ajax({
			
			type : "post",
			url : "ajaxinlineditratepharm.php",
			data : data,
			catch : false,
			success : function(data){
				//alert(data);
				if(data="yes"){
					alert("The Rate Has Been Updated Successfully for "+itemname+".");	
				}else{
					alert("The Rate Failed to Update for "+itemname+".");
				} 
				
				
				//$(e).css("background","#80c341");
			}
		});
	}
</script>

<style>
.pagination {
    float: right;
    font-weight: bold;
	padding: 2px 6px;
	
}
.pagination a{
    color: black;
    padding: 2px 6px;
	text-decoration: none;
}
.current{
	padding: 2px 6px;
	background-color: #ffffdd; 
	
}
.button{
    /*  border: none;  color: white;*/
   
	display: inline-block;
    padding: 2px 6px;
    text-align: center;
    
    	
}
.btn{
 
	background-color: rgba(0, 255, 0, 0.4);
	display: inline-block;
    zoom: 1;
    line-height: normal;
    white-space: nowrap;
    vertical-align: baseline;
    text-align: center;
    cursor: pointer;
	FONT-WEIGHT: normal;
    font-family: Tahoma;
    font-size: 11px;
    padding: .5em .9em .5em 1em;
    text-decoration: none;
    border-radius: 4px;
    text-shadow: 0 1px 1px rgba(0, 0, 0, .2);
}
.pagination a:hover:not(.current) {background-color: #ddd;}
</style>

<body>
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
		<td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>&nbsp;</td>
		<td width="97%" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="860">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
						<tr>
							<td>
								<form name="form1" id="form1" method="post" action="pharmaratemapping.php" onSubmit="return addward1process11()">
				
								<table width="600" border="1" align="center" cellpadding="4" cellspacing="2" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
									<tbody>
									<tr bgcolor="#011E6A">
										<td colspan="2" bgcolor="#ecf0f5" class="bodytext3">
											<strong> Pharmacy Rate Mapping </strong>
										</td>
									</tr>
									<tr>
										<td colspan="2" align="left" valign="middle" bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3">
											<div align="left"><?php echo $errmsg; ?></div>
										</td>
									</tr>
									<tr>
										<td width="15%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
											<div align="right"> Select Template </div>
										</td>
										<td width="82%" align="left" valign="middle"  bgcolor="#FFFFFF">
											<input name="template" id="template" style="border: 1px solid #001E6A; text-transform:uppercase" size="60" autocomplete="off" /> 
											<input type="hidden" name="templatename" id="templatename" value=""/>
											<input type="hidden" name="templateid" id="templateid" value="" />
											
										</td>
									</tr>
                                    <tr>
										<td width="15%" align="left" valign="top" bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
										<td width="82%" align="left" valign="top"  bgcolor="#FFFFFF">
											<input type="hidden" name="frmflag" value="addnew" />
											<input type="hidden" name="frmflag1" value="frmflag1" />
											<input type="submit" name="Submit" id="search" value="Search" style="border: 1px solid #001E6A" />
										</td>
									</tr>
									<tr>
										<td align="middle" colspan="2" >&nbsp;</td>
									</tr>
									</tbody>
								</table>
								</form>
								
								<form name="form2" id="form2" method="post" action="pharmaratemapping.php">
								
						
								<table width="900" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
								<tbody>
								<tr bgcolor="#011E6A">
									<td colspan="2" bgcolor="#ecf0f5" class="bodytext3">
										<strong>Medicine List </strong>
									</td>
									<td colspan="6" align="right" bgcolor="#ecf0f5" class="bodytext3"><span>
									<?php 
										$colorloopcount=0;
										$sno=0;
										
									if ($frmflag1 != ''){
										$sid='';
									
										$templateautocode = $_POST['templateid'];
										$columname = $_POST['templatename'];
						
										
									}else if ($sid !=''){
										$frmflag1='';
										
										$templateautocode = $_REQUEST['sid'];
										$query3 = "SELECT templatename, markup FROM pharma_rate_template WHERE recordstatus <> 'deleted' AND auto_number = '$templateautocode'";
										$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
										$res3 = mysqli_fetch_array($exec3);
										$columname = $res3['templatename'];
							
									} 
									if($searchflag1 !=''){
										$sid='';
										
										$templateautocode = $_REQUEST["templateautoid1"]; 
										$query4 = "SELECT templatename, markup FROM pharma_rate_template WHERE recordstatus <> 'deleted' AND auto_number = '$templateautocode'";
										$exec4 = mysqli_query($GLOBALS["___mysqli_ston"], $query4) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
										$res4 = mysqli_fetch_array($exec4);
										$columname = $res4['templatename'];	
															
									
									}

                                         
									if ($templateautocode != ''){
										
										//$sqlresult=mysql_query('SELECT DATABASE()');
										//$row=mysql_fetch_row($sqlresult);
										//$active_db=$row[0];
											//echo "Active Database :<b> $active_db</b> ";
											
										//$columnnames = 'subtype_'.$subtypeautocode;
										//$columnnames = '';
										//$sqlq= "SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '$active_db' AND TABLE_NAME = 'master_medicine' AND COLUMN_NAME = '$columnnames'";
										$sqlq= "SELECT * FROM master_medicine where status <> 'deleted'";
										$querys = mysqli_query($GLOBALS["___mysqli_ston"], $sqlq);											
										$checkcolmncnt = mysqli_num_rows($querys);
										
											
											
										if($checkcolmncnt > '0'){
												
										

									 //error_reporting(0);
										$tbl_name="master_medicine";		//your table name
										// How many adjacent pages should be shown on each side?
										$adjacents = 3;
								
										/* 
										   First get total number of rows in data table. 
										   If you have a WHERE clause in your query, make sure you mirror it here.
										*/
										$query111 = "select * from $tbl_name where type in ('drugs','medical items','sundries','lab reagents','Radiology Consumables','medical','other medical') and status <> 'deleted'";
										
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
										if($lastpage > 1)
										{	
											$pagination .= "<div class='pagination'>";
											//previous button
											if ($page > 1) 
												$pagination.= "<a href=\"$targetpage?sid=$templateautocode&&page=$prev\" style='color:#3b3b3c;'>previous</a>";
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
														$pagination.= "<a href=\"$targetpage?sid=$templateautocode&&page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
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
														else //Kenique
															$pagination.= "<a href=\"$targetpage?sid=$templateautocode&&page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
													}
													$pagination.= "...";
													$pagination.= "<a href=\"$targetpage?sid=$templateautocode&&page=$lpm1\"style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";
													$pagination.= "<a href=\"$targetpage?sid=$templateautocode&&page=$lastpage\"style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";		
												}
												//in middle; hide some front and some back
												elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
												{
													$pagination.= "<a href=\"$targetpage?sid=$templateautocode&&page=1\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";
													$pagination.= "<a href=\"$targetpage?sid=$templateautocode&&page=2\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";
													$pagination.= "...";
													for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
													{
														if ($counter == $page)
															$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
														else
															$pagination.= "<a href=\"$targetpage?sid=$templateautocode&&page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
													}
													$pagination.= "...";
													$pagination.= "<a href=\"$targetpage?sid=$templateautocode&&page=$lpm1\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";
													$pagination.= "<a href=\"$targetpage?sid=$templateautocode&&page=$lastpage\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";		
												}
												//close to end; only hide early pages
												else
												{
													$pagination.= "<a href=\"$targetpage?sid=$templateautocode&&page=1\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";
													$pagination.= "<a href=\"$targetpage?sid=$templateautocode&&page=2\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";
													$pagination.= "...";
													for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
													{
														if ($counter == $page)
															$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
														else
															$pagination.= "<a href=\"$targetpage?sid=$templateautocode&&page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
													}
												}
											}
												
												//next button
												if ($page < $counter - 1) 
													$pagination.= "<a href=\"$targetpage?sid=$templateautocode&&page=$next\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</a>";
												else
													$pagination.= "<span class=\"disabled\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</span>";
												echo $pagination.= "</div>\n";		
										}
									
									?></span> 
									</td>								
								</tr>
								<tr bgcolor="#011E6A">
									<td colspan="8" bgcolor="#FFFFFF" class="bodytext3">
										<input name="search1" type="text" id="search1" size="40" value="<?php echo $search1; ?>">
										<input type="hidden" name="templateautoid1" id="templateautoid1" value="<?php echo $templateautocode; ?>">
										<input type="hidden" name="subtypename1" id="subtypename1" value="<?php echo $columname; ?>">
										<input type="hidden" name="searchflag1" id="searchflag1" value="searchflag1">
										<input type="submit" name="Submit2" value="Search" style="border: 1px solid #001E6A" />
									</td>
								</tr><!-- -->
								<tr bgcolor="#011E6A">
									<td width="10%" bgcolor="#ecf0f5" align="center" class="bodytext3">
										<div align="center"><strong>Select All</strong>
											<input type="checkbox" id="selectalla" title= "Select All"  onclick="checkAll1(this,<?php echo $templateautocode; ?>)" />
											<input type="hidden" name="templateautono" value="<?php echo $templateautocode; ?>" >
										</strong></div> 
									</td>									
									<td width="4%" bgcolor="#ecf0f5" class="bodytext3">
										<div align="center"><strong>S.No</strong></div>
									</td>
									<td width="10%" bgcolor="#ecf0f5" class="bodytext3">
										<strong>ID / Code </strong>
									</td>
									<td width="15%" bgcolor="#ecf0f5" class="bodytext3">
										<strong>Category</strong>
									</td>
									<td width="35%" bgcolor="#ecf0f5" class="bodytext3">
										<strong>Pharmacy Item</strong>
									</td>
									<td width="35%" bgcolor="#ecf0f5" class="bodytext3">
										<strong>Cost Price</strong>
									</td>
									<td width="20%" bgcolor="#ecf0f5" class="bodytext3">
										<strong> <?php echo $columname;?> </strong>  
									</td>
									<td width="5%" bgcolor="#ecf0f5" align="center" class="bodytext3">
										<div align="center">
											<strong>Action</strong>
										</div> 
									</td>									
								</tr>
								<?php

								if ($searchflag1 == 'searchflag1'){
												  
									$search1 = $_REQUEST["search1"];
									$templateautocode = $_REQUEST["templateautoid1"];
									
									$cnt = "0";									
									$query1 = "select * from master_medicine where  (itemname like '%$search1%' or categoryname = '$search1') and  status <> 'deleted' order by auto_number desc ";
									$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
									while ($res1 = mysqli_fetch_array($exec1))
									{
										$cnt = $cnt+1;
										$itemcode = $res1["itemcode"];
										$itemname = $res1["itemname"];
										$categoryname = $res1["categoryname"];
										$auto_number = $res1["auto_number"];
										$rateperunit = $res1["subtype_".$subtypeautocode];
										$cost = $res1['purchaseprice'];

										$result = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM pharma_template_map WHERE templateid='$templateautocode' and productcode='$itemcode'");

										$row = mysqli_fetch_assoc($result);
										$rt = $row['rate'];
										if($rt ==''){
								    		$rate = '0.00';
								    	}else{
								    		//$rate = number_format($rt);
								    		$rate = number_format((float)$rt, 2, '.', '');
								    	}
										
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
								<td align="center"  valign="middle"  class="bodytext3">
								    <input type="checkbox" name="surveychk[]" id="surveychk<?php echo $auto_number; ?>" class="surveychk<?php echo $templateautocode; ?> selectchk" value="<?php echo $auto_number; ?>" >

									<input type="hidden" name="templateautocode<?php echo $auto_number; ?>" id="templateautocode<?php echo $auto_number; ?>" value="<?php echo $templateautocode; ?>" />
									<input type="hidden" name="itemcode<?php echo $auto_number; ?>" id="itemcode<?php echo $auto_number; ?>" value="<?php echo $itemcode; ?>" />
									<input type="hidden" name="itemname<?php echo $auto_number; ?>" id="itemname<?php echo $auto_number; ?>" value="<?php echo $itemname; ?>" />
								</td> 
									<td align="left" valign="middle" class="bodytext3">
										<div align="center"><?php echo $cnt; ?></div>
									</td>
									<td align="left" valign="middle" class="bodytext3"><?php echo $itemcode; ?> </td>
									<td align="left" valign="middle" class="bodytext3"><?php echo $categoryname; ?> </td>
									<td align="left" valign="middle" class="bodytext3"><?php echo $itemname; ?> </td>
									<td align="left" valign="middle"  class="bodytext3"><?php echo number_format($cost); ?> </td>
									<td align="left" valign="middle" class="bodytext3">
										<!-- pharmacy template rate-->
										<div align="center">
											<input type="text" name="rate<?php echo $auto_number; ?>" id="rate<?php echo $auto_number; ?>" style="text-align: right;" value="<?php if($rate==''){echo '0.00';}else{echo $rate;} ?>" size="8">
										</div>
									</td>
									<td align="center" valign="middle" class="bodytext3">
										<span onClick="updaterate(this,<?php echo $auto_number; ?>)" class="btn"> Update </span>
										 
									</td> 
								</tr>
								<?php
									}
								}else{
								$cnt ="0";
								$query1 = "select * from master_medicine where type in ('drugs','medical items','sundries','lab reagents','Radiology Consumables','medical','other medical')  and  status <> 'deleted' order by auto_number desc LIMIT $start, $limit";
								$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
								while ($res1 = mysqli_fetch_array($exec1))
								{
									$cnt = $cnt+1;
									$itemcode = $res1["itemcode"];
									$itemname = $res1["itemname"];
									$categoryname = $res1["categoryname"];
									$auto_number = $res1["auto_number"];
									$rateperunit = $res1["subtype_".$subtypeautocode];
									$cost = $res1['purchaseprice'];
                                    
                                    $result = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM pharma_template_map WHERE templateid='$templateautocode' and productcode='$itemcode'");

									$row = mysqli_fetch_assoc($result);
									$rt = $row['rate'];
									if($rt ==''){
							    		$rate = '0.00';
							    	}else{
							    		//$rate = number_format($rt);
							    		$rate = number_format((float)$rt, 2, '.', '');
							    	}

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
								<td align="center"  valign="middle"  class="bodytext3">
								    <input type="checkbox" name="surveychk[]" id="surveychk<?php echo $auto_number; ?>" class="surveychk<?php echo $templateautocode; ?> selectchk" value="<?php echo $auto_number; ?>" >
									<?php //echo $itemcode; ?>
									<input type="hidden" name="templateautocode<?php echo $auto_number; ?>" id="templateautocode<?php echo $auto_number; ?>" value="<?php echo $templateautocode; ?>" />
									<input type="hidden" name="itemcode<?php echo $auto_number; ?>" id="itemcode<?php echo $auto_number; ?>" value="<?php echo $itemcode; ?>" />
									<input type="hidden" name="itemname<?php echo $auto_number; ?>" id="itemname<?php echo $auto_number; ?>" value="<?php echo $itemname; ?>" />
								</td> 							
								<td align="left" valign="middle" class="bodytext3">
									<div align="center"><?php echo $cnt; ?></div>
								</td>
								<td align="left" valign="middle"  class="bodytext3"><?php echo $itemcode; ?> </td>
								<td align="left" valign="middle"  class="bodytext3"><?php echo $categoryname; ?> </td>
								<td align="left" valign="middle"  class="bodytext3"><?php echo $itemname; ?> </td>
								<td align="left" valign="middle"  class="bodytext3"><?php echo number_format($cost); ?> </td>
								<td align="left" valign="middle" class="bodytext3">
									<!-- pharmacy template rate-->
									<div align="center">
										<input type="text" name="rate<?php echo $auto_number; ?>" id="rate<?php echo $auto_number; ?>" style="text-align: right;" value="<?php if($rate==''){echo '0.00';}else{echo $rate;} ?>" size="8">
									</div>
								</td>
								<td align="center"  valign="middle"  class="bodytext3">
									<span onClick="updaterate(this,<?php echo $auto_number; ?>)" class="btn"> Update </span>
								</td> 									
							</tr>
							<?php
								}
								}
										}else{
							?>				
							<tr >
								<td colspan="8" align="center" valign="middle" bgcolor="#FFFFFF" class="bodytext3">
									<font color="#f93635" >
										<b> ------ No Records Available. Please Update Sub Type ------ </b>
									</font>
								</td>
							</tr>											
							<?php			}	
											}
							?>
							
							<tr >
								<td colspan="8" align="center" valign="middle" bgcolor="#FFFFFF" class="bodytext3" >
									<input type="hidden" name="frmflag2" value="frmflag2" />
									<input type="submit" name="save" id="save" value="Submit" style="border: 1px solid #001E6A"  /> 
								</td>
							</tr>								
							</tbody>
						</table>
						</form>
							</td>
						</tr>
					</table>
					</td>
				</tr>
			</table>

		</td>
	</tr>		
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>


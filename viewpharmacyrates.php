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
				$itemcode = $_POST['itemcode'.$auto_id];
                // check if exists first
				$date = date("Y-m-d");
                
                // get all pharma rate temp codes
		        /*$query_rt211 = "SELECT templatename FROM pharma_rate_template ORDER BY auto_number ASC";
			    $exec_rt211 = mysql_query($query_rt211) or die ("Error in Query_rt211".mysql_error());
			    $obj_ids = mysql_fetch_assoc($exec_rt211);
                
                var_dump($obj_ids);*/
                //echo $auto_id.'<br>';
                $obj_ids = array();
			    $query_rt211 = "SELECT auto_number,templatename FROM pharma_rate_template ORDER BY auto_number ASC";
			    $exec_rt211 = mysqli_query($GLOBALS["___mysqli_ston"], $query_rt211) or die ("Error in Query_rt211".mysqli_error($GLOBALS["___mysqli_ston"]));
			    while ($res_rt211 = mysqli_fetch_assoc($exec_rt211))
				{   
					$auto_no= $res_rt211['auto_number'];
					array_push($obj_ids, $auto_no);
				}
                
                //var_dump($obj_ids);
                foreach ($obj_ids as $k => $v) {
                	$varid = $v;
                	//echo $varid.'<br>';
                	$tempcode = $_POST['tempcode'.$auto_id.$itemcode.$varid];
                    $updaterate = $_POST['rate'.$tempcode.$auto_id].'<br>';
                    $itemmargin = $_POST['itemmargin'.$tempcode.$auto_id].'<br>';
                    //echo $itemmargin;
                    //echo 'tempcode'.$auto_id.$itemcode.$varid.'<br>';
                    //echo $tempcode.'<br>';
                    //echo 'rate'.$tempcode.$varid.'<br>';
                	// query
                	if($itemmargin > 0){
				    	// calc new rate
				    	// calc new rate
				    	$query01 = "SELECT * from master_medicine WHERE itemcode='$itemcode'";
						$exec01 = mysqli_query($GLOBALS["___mysqli_ston"], $query01) or die ("Error in Query0".mysqli_error($GLOBALS["___mysqli_ston"]));
						while ($res01 = mysqli_fetch_assoc($exec01)){
							$pprice = $res01['purchaseprice'];
						}
				    	$rate_perc = (($itemmargin/100)* $pprice);
				    	$new_rate = ($pprice + $rate_perc);
				    }else{
				    	$new_rate = $updaterate;
				    }

                	$sqlquery= "INSERT INTO pharma_template_map(templateid, productcode, rate, username,dateadded, recordstatus,margin,ipaddress) VALUES ('$tempcode','$itemcode','$new_rate','$username','$date','','$itemmargin','$ipaddress')";
                    //echo $sqlquery.'<br>';
                    //exit;
				    $exequery = mysqli_query($GLOBALS["___mysqli_ston"], $sqlquery);

					$query3 = "UPDATE master_medicine SET markup = '$itemmargin' WHERE itemcode = '$itemcode'";
					$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));

				    // get all subtype auto_no from master_subtypes where row matches temp id
					$obj = array();
					$query2 = "SELECT auto_number from master_subtype WHERE pharmtemplate='$tempcode'";
					$exec2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2) or die ("Error in Query2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$obj = mysqli_fetch_assoc($exec2);
					while ($res2 = mysqli_fetch_assoc($exec2))
					{   
						$auto_no= $res2['auto_number'];
						array_push($obj, $auto_no);
					}
					//var_dump($obj);
					// update medicine table
					if(is_array($obj)){
						foreach ($obj as $key => $value) {
							$col = 'subtype_'.$value;
							$query3 = "UPDATE master_medicine SET $col = '$new_rate' WHERE itemcode = '$itemcode'";
							//echo $query3.'<br>';
							$exec3 = mysqli_query($GLOBALS["___mysqli_ston"], $query3) or die ("Error in Query3".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
					}
                }
		
			 
				$bgcolorcode = 'Success';	
				$errmsg = "Pharmacy Template Rate Updated Successfully";
			}
		   //exit;	
		}else{
			$bgcolorcode = 'failed';	
			$errmsg = "Please Select item for Update";
 
		}	
	
	header("Location: pharmacyrateupdate.php");		
	}

}

function getLen($rm_rate){
	$tmp = explode('.', $rm_rate);
	if(count($tmp)>1){
		return strlen($tmp[1]);
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

<style type="text/css">
/*
input[type=number]{
    width: 100px;
}
*/


</style>
</head>
<script language="javascript">
$(document).ready(function(){
	//alert("----");
	
	$('#search1').autocomplete({
		source:'ajaxpharmacyitems.php?action=item', 
		minLength:1,
		html: true, 
		select: function(event,ui){
			var medicine = ui.item.value;
			$('#search1').val(medicine);
			
		},
    });	
	
	
	
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
	
	function updaterate(e,autono,tempids){
		//alert(tempids);
		
		//$(e).css("background","#FFF");
		var itemcode1 = $("#itemcode"+autono).val();
		var itemname = $("#itemname"+autono).val();
		//var tempcode = $("#tempcode"+tempid).val();
		//var rate = $("#rate"+tempid).val();
		// get all item rates
        var idsLength = tempids.length;
        var arr = [];
		for (var i = 0; i < idsLength; i++) {
		    //console.log(tempids[i]);
		    var tempcode = tempids[i];
		    //var rate = $("#rate"+tempids[i]).val();
		    var rate = document.getElementById("rate"+tempcode+autono).value;
		    var itemmargin = document.getElementById("itemmargin"+tempcode+autono).value;
		    //console.log(itemmargin);
		    //console.log(rate);
		    var ar = {"tempid":tempcode, "rate":rate, "itemmargin":itemmargin };
		    arr.push(ar);
		    //console.log(rate);
		}
		//console.log(arr);
		//alert(subtypename);
		json = JSON.stringify(arr); 
		var data = "itemcode="+itemcode1+"&&arr="+json;
		//alert(data);
		$.ajax({
			
			type : "post",
			url : "ajaxinlineditratepharm1.php",
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

	function updateRateItem(e,autono,tempids){
		//alert(tempids);
		
		//var itemcode1 = $("#itemcode"+autono).val();
		//var itemname = $("#itemname"+autono).val();

		// get all item rates
       // var idsLength = tempids.length;
        //console.log(tempids);
       // var arr = [];
		//for (var i = 0; i < idsLength; i++) {
		    //console.log(tempids[i]);
		    var tempcode = tempids;
		    //var rate = $("#rate"+tempids[i]).val();
		    var cost = document.getElementById("itemcost"+tempcode+autono).value;
		    var itemmargin = document.getElementById("itemmargin"+tempcode+autono).value;
		    if(itemmargin > 0){
		    	var newperc = 0;
		    	var newcost = 0;

		    	var costprice = parseFloat(cost);

		    	newperc = ((itemmargin/100) * costprice);
		    	newcost = (costprice + newperc);
                var num = Number(Math.round(newcost+'e2')+'e-2');
                var newnum = num.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

                document.getElementById("rate"+tempcode+autono).value = newnum;

		    }
		//}

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
								
								<form name="form2" id="form2" method="post" action="viewpharmacyrates.php">
								
						
								<table width="1200" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
								<tbody>
								<tr bgcolor="#011E6A">
									<td colspan="2" bgcolor="#ecf0f5" class="bodytext3">
										<strong>Medicine List </strong>
									</td>
									<?php 
									  //get colspan from rows
									  $query_rt0 = "SELECT templatename FROM pharma_rate_template ORDER BY auto_number DESC";
									  $exec_rt0 = mysqli_query($GLOBALS["___mysqli_ston"], $query_rt0) or die ("Error in Query_rt".mysqli_error($GLOBALS["___mysqli_ston"]));
									  $num_rows = mysqli_num_rows($exec_rt0);
									  $colspan = 6 + ($num_rows * 2);
									?>
									<td colspan="<?php echo $colspan;?>" align="right" bgcolor="#ecf0f5" class="bodytext3"><span>
									<?php 
										$colorloopcount=0;
										$sno=0;
								    
								    // checkbox flag
                                    $templateautocode = 1;
                                         
									if ($templateautocode == '1'){
										
										//$sqlresult=mysql_query('SELECT DATABASE()');
										//$row=mysql_fetch_row($sqlresult);
										//$active_db=$row[0];
											//echo "Active Database :<b> $active_db</b> ";
											
										//$columnnames = 'subtype_'.$subtypeautocode;
										//$columnnames = '';
										//$sqlq= "SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '$active_db' AND TABLE_NAME = 'master_medicine' AND COLUMN_NAME = '$columnnames'";
										$sqlq= "SELECT * FROM master_medicine where status <> 'deleted' ORDER BY auto_number DESC";
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
									<?php 
									  //get colspan from rows
									  $query_rt0 = "SELECT templatename FROM pharma_rate_template ORDER BY auto_number DESC";
									  $exec_rt0 = mysqli_query($GLOBALS["___mysqli_ston"], $query_rt0) or die ("Error in Query_rt".mysqli_error($GLOBALS["___mysqli_ston"]));
									  $num_rows = mysqli_num_rows($exec_rt0);
									  $colspan = 6 + ($num_rows * 2);
									?>
									<td colspan="<?php echo $colspan;?>" bgcolor="#FFFFFF" class="bodytext3">
										<input name="search1" type="text" id="search1" size="40" value="<?php echo $search1; ?>" autocomplete = 'off'>
										<input type="hidden" name="templateautoid1" id="templateautoid1" value="<?php echo $templateautocode; ?>">
										<input type="hidden" name="subtypename1" id="subtypename1" value="<?php echo $columname; ?>">
										<input type="hidden" name="searchflag1" id="searchflag1" value="searchflag1">
										<input type="submit" name="Submit2" value="Search" style="border: 1px solid #001E6A" />
									</td>
									<td bgcolor="#FFFFFF"><!--<a href="print_pharmacyrates.php" target="_blank" class="btn">Export Excel</a>--></td>
								</tr><!-- -->
								<tr bgcolor="#011E6A">
									<td width="10%" bgcolor="#ecf0f5" align="center" class="bodytext3">
										
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
									<td width="25%" align="right" bgcolor="#ecf0f5" class="bodytext3">
										<strong>Cost Price</strong>
									</td>
									<!-- rate templates headers -->
									<?php 
									  $query_rt = "SELECT templatename,markup FROM pharma_rate_template ORDER BY auto_number ASC";
									  $exec_rt = mysqli_query($GLOBALS["___mysqli_ston"], $query_rt) or die ("Error in Query_rt".mysqli_error($GLOBALS["___mysqli_ston"]));
										while ($res_rt = mysqli_fetch_array($exec_rt))
										{
											$col_rt = $res_rt['templatename'];
											$col_markup = $res_rt['markup'];
									?>
									<td  align="center" width="20%" bgcolor="#ecf0f5" class="bodytext3">
										<strong> <?php echo ucfirst($col_rt);?> <?php //if($col_markup != '0'){echo '('.$col_markup.'%)'; }?></strong>  
									</td>
								    <?php } ?>
																		
								</tr>
								<?php

								if ($searchflag1 == 'searchflag1'){
												  
									$search1 = $_REQUEST["search1"];
									$templateautocode = $_REQUEST["templateautoid1"];
									
									$cnt = "0";									
									$query1 = "select * from master_medicine where  (itemname like '%$search1%' or categoryname = '$search1') and  status <> 'deleted' order by auto_number asc ";
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
								    <!--<input type="checkbox" name="surveychk[]" id="surveychk<?php echo $auto_number; ?>" class="surveychk<?php echo $templateautocode; ?> selectchk" value="<?php //echo $auto_number; ?>" >-->

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
									<td align="right" valign="middle"  class="bodytext3">
										<div style="text-align:right;">
										     <?php echo number_format($cost, 2, '.', ','); ?>
									    </div>
									</td>
									<!-- pharmacy template rate-->
									<?php
									    // Get all templates
									    $query_rt1 = "SELECT auto_number,markup FROM pharma_rate_template ORDER BY auto_number ASC";
									    $exec_rt1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_rt1) or die ("Error in Query_rt".mysqli_error($GLOBALS["___mysqli_ston"]));
										while ($res_rt1 = mysqli_fetch_array($exec_rt1))
										{
											$tempid = $res_rt1['auto_number'];
											$rate = '0.00';
											$margin = $res_rt1['markup'];
						                ?>
						            <?php
									    // Get all pharmacy template mapping rates
									   $query_rm = "SELECT * FROM pharma_template_map WHERE templateid='$tempid' and productcode='$itemcode' ORDER BY auto_number DESC LIMIT 1";
										$exec_rm = mysqli_query($GLOBALS["___mysqli_ston"], $query_rm) or die("Error in Query_rm".mysqli_error($GLOBALS["___mysqli_ston"]));
										while($res_rm = mysqli_fetch_array($exec_rm)){
											$rm_rate = $res_rm['rate'];
											$rm_productcode = $res_rm['productcode'];
											$rm_templateid = $res_rm['templateid'];
											$item_margin = $res_rm['margin'];
											 // format number
									    	
											// rate
											if($rm_rate ==''){
												$rt = $rate;
											}else{
												$rate = number_format((float)$rm_rate, 2, '.', ',');
												//$rate = number_format($rm_rate, getLen($rm_rate));
											}
									?>
								    <?php }  ?>
								   
								   
								    <td align="left" valign="middle" class="bodytext3">
								    	<input type="hidden" name="tempcode<?php echo $auto_number; ?><?php echo $itemcode; ?><?php echo $tempid; ?>" id="tempcode<?php echo $auto_number; ?><?php echo $itemcode; ?><?php echo $tempid; ?>" value="<?php echo $tempid; ?>" />
									    <div align="center">
										<?php echo $rate; ?>
											</div>
									</td>
									 <?php } ?>
									 <?php 
									       // get all pharma rate temp codes
									        $arr1 = array();
									        //query
									        $query_rt2 = "SELECT auto_number FROM pharma_rate_template ORDER BY auto_number ASC";
										    $exec_rt2 = mysqli_query($GLOBALS["___mysqli_ston"], $query_rt2) or die ("Error in Query_rt".mysqli_error($GLOBALS["___mysqli_ston"]));
											while ($res_rt2 = mysqli_fetch_assoc($exec_rt2))
											{   
												$tempid= $res_rt2['auto_number'];
												array_push($arr1, $tempid);
											}
											$tempids = json_encode($arr1);
											//echo $tempids;
									    ?>
									
								<?php
									}
								}else{
								$cnt ="0";
								$query1 = "select * from master_medicine where status <> 'deleted' order by auto_number asc LIMIT $start, $limit";
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
								    <!--<input type="checkbox" name="surveychk[]" id="surveychk<?php echo $auto_number; ?>" class="surveychk<?php echo $templateautocode; ?> selectchk" value="<?php //echo $auto_number; ?>" >-->
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
								<td align="right" valign="middle"  class="bodytext3">
									<div style="text-align:right;">
									     <?php echo number_format($cost, 2, '.', ','); ?>
								    </div>
							    </td>
								<!-- pharmacy template rate-->
									<?php
									    // Get all templates
									    $query_rt1 = "SELECT auto_number,markup FROM pharma_rate_template ORDER BY auto_number ASC";
									    $exec_rt1 = mysqli_query($GLOBALS["___mysqli_ston"], $query_rt1) or die ("Error in Query_rt".mysqli_error($GLOBALS["___mysqli_ston"]));
										while ($res_rt1 = mysqli_fetch_array($exec_rt1))
										{
											$tempid = $res_rt1['auto_number'];
											$rate = '0.00';
											$margin = $res_rt1['markup'];
						                ?>
						            <?php
									    // Get all pharmacy template mapping rates
									    $query_rm = "SELECT * FROM pharma_template_map WHERE templateid='$tempid' and productcode='$itemcode' ORDER BY auto_number DESC LIMIT 1";
										$exec_rm = mysqli_query($GLOBALS["___mysqli_ston"], $query_rm) or die("Error in Query_rm".mysqli_error($GLOBALS["___mysqli_ston"]));
										while($res_rm = mysqli_fetch_array($exec_rm)){
											$rm_rate = $res_rm['rate'];
											$rm_productcode = $res_rm['productcode'];
											$rm_templateid = $res_rm['templateid'];
											$item_margin = $res_rm['margin'];
											// rate
											if($rm_rate ==''){
												$rt = $rate;
											}else{
												//$rate = number_format((float)$rm_rate, 2, '.', '');
												$rate = number_format((float)$rm_rate, 2, '.', ',');
											}
									?>
								    <?php }  ?>
								  
									<td align="left" valign="middle" class="bodytext3">
								    	<input type="hidden" name="tempcode<?php echo $auto_number; ?><?php echo $itemcode; ?><?php echo $tempid; ?>" id="tempcode<?php echo $auto_number; ?><?php echo $itemcode; ?><?php echo $tempid; ?>" value="<?php echo $tempid; ?>" />
									    <div align="center">
										<?php echo $rate; ?>
											</div>
									</td>
								 <?php } ?>
																	
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


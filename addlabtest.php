<?php
session_start();
include ("db/db_connect.php");
$subtype=isset($_REQUEST['subtype'])?$_REQUEST['subtype']:'';
$qrytbl = mysqli_query($GLOBALS["___mysqli_ston"], "select labtemplate from master_subtype where auto_number  = $subtype");
$restbl = mysqli_fetch_assoc($qrytbl);
$tb=$restbl['labtemplate'];
if($tb =='')
{
$tb = 'master_lab';
}
$category="";
$tb=trim($tb);
$query = "select * from master_lab where status <> 'deleted'";
$exec = mysqli_query($GLOBALS["___mysqli_ston"], $query) or die("error in query".mysqli_error($GLOBALS["___mysqli_ston"]));
 $total_labs = mysqli_num_rows($exec);
$querycat = "select * from master_lab where status <> 'deleted' group by categoryname";
$execcat = mysqli_query($GLOBALS["___mysqli_ston"], $querycat) or die("error in querycat".mysqli_error($GLOBALS["___mysqli_ston"]));
 $total_lab_cats = mysqli_num_rows($execcat);
 $length = intval(($total_labs+$total_lab_cats)/6)+1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="css/bootstrap.css">
  <script src="js/jquery-1.11.3.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
<style>
.btn-xs{
font-size:14px;
}

</style>
<script> 
$(document).ready(function (){
	window.moveTo(0, 0);
window.resizeTo(screen.availWidth, screen.availHeight);
	$("#addlabitems").click(function (){
		var myArray = [];
		$(":checkbox:checked").each(function() {
		if(this.value!='')
		{
		$.ajax({
		type: "POST",
		url: "ajaxlab.php",
		data:{'labcode':this.value,'tb':'<?php echo $tb; ?>'},
		success:function(data){
		//alert(data);
		myArray.push(data);
		}
		});
		}	
		});
		setTimeout(function () { 
		var checkedata = myArray.join(",");
		if(checkedata==""){
			alert("Please select lab item");
			return false;
		}else{
			window.opener.insertitem21(checkedata);	
		}
		
		window.close();
		}, 1000);
	});
	

$(".btn").click(function (){
	//alert($(this).children("input:checkbox").prop("checked"));
	 if(!$(this).children("input:checkbox").prop("checked"))
	 {
	 	if($(this).children("input:checkbox").val()=='')
		{
				$(this).addClass('btn-danger');
		}
		else
		{
				 $(this).addClass('btn-success');
		}
	 }
	  else{
	   $(this).removeClass('btn-success');
	  }
});
	
});
</script>  
</head>

<body>
<div class="container-fluid">
  <form>
  
<div class="row clearfix">
<div class="col-sm-2" style="display:inline-block;padding-top:10px; border-right:solid;">
		<?php
		$itl =0;
		while($rescat = mysqli_fetch_array($execcat))
		{
		$category = $rescat['categoryname'];
		$itl++;
		?>
	   <div style="background-color:#ccc;"><label> <b><?= $category;?></b></label></div>
	   <div style="background-color:#fff;display:inline-block;">
	   <?php
		 $query1 = "select * from master_lab where status <> 'deleted' and categoryname = '$category'";
		$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("error in query1".mysqli_error($GLOBALS["___mysqli_ston"]));
		
 		while($res1 = mysqli_fetch_array($exec1))
		{
		$itl++;
		?>
		<div class="btn-group col-sm-10" data-toggle="buttons">
	  <label class="btn btn-xs" title="<?= $res1['itemname']?>"><input class="btn btn-xs" type="checkbox" name="labitem[]" id="labitem" value="<?= $res1['itemcode']?>" /> <?= substr($res1['itemname'],0,18)?></label>
	  </div>
		<?php
		if($itl == $length)
		{
		?>
		</div>
		</div>
		<div class="col-sm-2" style="display:inline-block;padding-top:10px; border-right:solid;">
		<div style="background-color:#ccc;"><label> <b><?= $category;?></b></label></div>
	   <div style="background-color:#fff;display:inline-block;">
		<?php
		$itl=0;
		}
		}
	   ?>
	    </div>
	   <?php
		if(($itl+1) == $length)
		{
		?>
		
		</div>
		<div class="col-sm-2" style="display:inline-block;padding-top:10px; border-right:solid;">
		<?php
		$itl=0;
		}
	    } 
		?>
	   
  	 
		
	 
   	   
	  </div>

</div>
	
<div class="row" >
   <div class="pull-right">
   	 <button align="right" class="btn-success btn verticaltext" type="button" name="addlabitems" id="addlabitems" style="position:fixed; bottom:20px;right:25px;">Add Tests </button> 
   </div>
</div>
  </form>
  </div>
</body>
</html>
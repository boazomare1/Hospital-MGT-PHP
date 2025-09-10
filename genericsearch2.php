<?php
include ("db/db_connect.php");

if(isset($_REQUEST['itemcode'])){$itemcode = $_REQUEST['itemcode']; } else { $itemcode = ''; }
if(isset($_REQUEST['referencename'])){$referencename = $_REQUEST['referencename']; } else { $referencename = ''; }
if(isset($_REQUEST['sno'])){$sno = $_REQUEST['sno']; } else { $sno = ''; }

?>

<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="multiselect/dist/js/multiselect.js"></script>

<script type="text/javascript">
function saveOptions(){
    var ddlArray= new Array();
    var ddl = document.getElementById('search_to');
    for (i = 0; i < ddl.options.length; i++) {
       ddlArray[i] = ddl .options[i].value;
    }
    var sno = document.getElementById('sno').value;
    window.opener.document.getElementById('result'+sno).value = ddlArray;
    window.close();
}
</script>


<div class="row">
    <div class="col-xs-12">
    	<h2 align="center"><?php echo $referencename; ?></h2>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col-xs-5">
        <select name="from[]" id="search" class="form-control" size="8" multiple="multiple">
            <?php 
            	$query1 = "select * from master_genericname";
            	$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
            	while($res1 = mysqli_fetch_array($exec1)){
            		$itemcode = $res1['auto_number'];
            		$itemname = $res1['genericname'];
    		?>
    		<option value="<?php echo $itemname; ?>"><?php echo $itemname; ?></option>
			<?php } ?>
        </select>
        <input type="hidden" name="sno" id="sno" value="<?php echo $sno; ?>">
    </div>
    
    <div class="col-xs-2">
        <div><br><br><br><br></div>
        <!-- <button type="button" id="search_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button> -->
        <button type="button" id="search_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
        <button type="button" id="search_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
        <!-- <button type="button" id="search_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button> -->
    </div>
    
    <div class="col-xs-5">
        <select name="to[]" id="search_to" class="form-control" size="8" multiple="multiple"></select>
    </div>

    <div class="row">
        <div class="col-xs-12" align="center">
            <br><br>
            <input type="submit" name="Save" onclick="saveOptions()">
        </div>
    </div>
</div>

<script type="text/javascript">
  $( document ).ready(function() {
    $('#search').multiselect({
        search: {
            left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
            right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
        },
        fireSearch: function(value) {
            return value.length > 1;
        }
    });
  });
</script>
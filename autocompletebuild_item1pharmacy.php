<?php
//session_start();
set_time_limit(0);
include ("db/db_connect.php");
$stringpart1 = '
function StateSuggestions1() {
//alert ("Meow..");
this.states = 
[
';

$stringpart2 = '];
}

/**
 * Request suggestions for the given autosuggest control. 
 * @scope protected
 * @param oAutoSuggestControl The autosuggest control to provide suggestions for.
 */
StateSuggestions1.prototype.requestSuggestions = function (oAutoSuggestControl /*:AutoSuggestControl*/,
                                                          bTypeAhead /*:boolean*/) {
    var aSuggestions = [];
    var sTextboxValue = oAutoSuggestControl.textbox.value;
    //alert (sTextboxValue);
	//Dummy value to have one intentional blank space to allow down and up keys to select items is list contains only one item.
	var varDummyValue = " "; 
	
 	var loopLength = 0;

    if (sTextboxValue.length > 0){
	
	var sTextboxValue = sTextboxValue.toUpperCase();

        //search for matching states
        for (var i=0; i < this.states.length; i++) 
		{ 
            if (this.states[i].indexOf(sTextboxValue) >= 0) 
			{
                loopLength = loopLength + 1;
				if (loopLength <= 15) //TO REDUCE THE SUGGESTIONS DROP DOWN LIST
				{
					aSuggestions.push(this.states[i]);
				}
            } 
        }
    }

	aSuggestions.push(varDummyValue);
    //provide suggestions to the control
    oAutoSuggestControl.autosuggest(aSuggestions, bTypeAhead);
};';

$stringbuild2 = "";
$query1 = "select * from master_itempharmacy where status <> 'deleted' order by categoryname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$citemcode = $res1["itemcode"];
	$citemcode = strtoupper($citemcode);
	$citemname = $res1["itemname"];
	$citemname = strtoupper($citemname);

	$ccategoryname = $res1["categoryname"];
	$citemname = stripslashes($citemname);
	$citemname = preg_replace('/,/', ' ', $citemname);
	$citemname = preg_replace ('/["]/i','\"', $citemname);
	$citemname = preg_replace ("/[']/i","\'", $citemname);
	if ($stringbuild2 == '')
	{
		//$stringbuild2 = '"'.$citemcode.' || '.$citemname.' || '.$citemstock.'"';
		$stringbuild2 = '"'.$citemcode.' || '.$citemname. '"'; //.' || '.$citemstock.'"';
	}
	else
	{
		$stringbuild2 = $stringbuild2.',"'.$citemcode.' || '.$citemname.'"';
	}
}
//echo $stringbuild2;

//building file.
///*
$filecontent = $stringpart1.$stringbuild2.$stringpart2;
$filefolder = 'js';
$filename = 'autocomplete_item1pharmacy.js'; //Intentionally renamed to avoid overwrite of file.
$filepath = $filefolder.'/'.$filename;
$fp = fopen($filepath, 'w');
fwrite($fp, $filecontent);
fclose($fp);
//*/
?>
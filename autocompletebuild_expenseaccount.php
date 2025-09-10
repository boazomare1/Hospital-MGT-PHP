<?php
//session_start();
include ("db/db_connect.php");

$stringpart1 = '
function StateSuggestions11() {
this.states = 
[
';

$stringpart2 = '];
}

/**
 * Request suggestions for the given autosuggest control. 
 * @scope protected
 * @param oAutoSuggestControl11 The autosuggest control to provide suggestions for.
 */
StateSuggestions11.prototype.requestSuggestions = function (oAutoSuggestControl11 /*:AutoSuggestControl*/,
                                                          bTypeAhead /*:boolean*/) {
    var aSuggestions = [];
    var sTextboxValue = oAutoSuggestControl11.textbox.value;
    
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

    //provide suggestions to the control
    oAutoSuggestControl11.autosuggest(aSuggestions, bTypeAhead);
};';


$stringbuild1 = "";
$query1 = "select * from master_accountname where (accountsmain = '4' or accountssub = '2') and recordstatus <> 'Deleted' order by accountname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$res1accountcode = $res1['id'];
	$res1accountname = $res1['accountname'];
	$res1accountname = strtoupper($res1accountname);
	$res1accountname = trim($res1accountname);
	$res1accountname = preg_replace('/,/', ' ', $res1accountname);
	if ($stringbuild1 == '')
	{
		$stringbuild1 = '"'.$res1accountname.'#'.$res1accountcode.'"';
	}
	else
	{
		$stringbuild1 = $stringbuild1.',"'.$res1accountname.'#'.$res1accountcode.'"';
	}
}
//echo $stringbuild1;

//building file.
$filecontent = $stringpart1.$stringbuild1.$stringpart2;
//$filename = $scriptname.'js';
$filefolder = 'js';
$filename = 'autocomplete_12accounts.'.'js';
$filepath = $filefolder.'/'.$filename;
$fp = fopen($filepath, 'w');
fwrite($fp, $filecontent);
fclose($fp);





?>
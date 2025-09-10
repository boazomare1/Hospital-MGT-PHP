<?php
//session_start();
include ("db/db_connect.php");

$stringpart1 = '
function StateSuggestions3() {
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
StateSuggestions3.prototype.requestSuggestions = function (AutoSuggestControl3 /*:AutoSuggestControl*/,
                                                          bTypeAhead /*:boolean*/) {
    var aSuggestions = [];
    var sTextboxValue = AutoSuggestControl3.textbox.value;
    //alert (sTextboxValue);
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
    AutoSuggestControl3.autosuggest(aSuggestions, bTypeAhead);
};';

$stringbuild1 = "";
$query1 = "select * from master_accountname where accountssub = '14' and recordstatus = 'ACTIVE' group by id";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$res1autonumber = $res1['auto_number'];
	$res1itemcode=$res1['id'];
	$res1itemname = $res1['accountname'];
	
	$res1itemname = addslashes($res1itemname);

	$res1itemname = strtoupper($res1itemname);

	$res1itemname = trim($res1itemname);
	
	//$res1itemcode = preg_replace('/,/', ' ', $res1itemcode);
	$res1itemname = preg_replace('/,/', ' ', $res1itemname);
	
	if ($stringbuild1 == '')
	{
		$stringbuild1 = '"'.$res1itemcode.'||'.$res1itemname.'"';
	}
	else
	{
		$stringbuild1 = $stringbuild1.',"'.$res1itemcode.'||'.$res1itemname.'"';
	}
}
//echo $stringbuild1;

//building file.
$filecontent = $stringpart1.$stringbuild1.$stringpart2;
//$filename = $scriptname.'js';
$filefolder = 'js';
$filename = 'autocompletebuild_accdepreciation.'.'js';
$filepath = $filefolder.'/'.$filename;
$fp = fopen($filepath, 'w');
fwrite($fp, $filecontent);
fclose($fp);

?>
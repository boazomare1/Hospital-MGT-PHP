<?php
//session_start();
include ("db/db_connect.php");

$stringpart1 = '
function StateSuggestions1() {
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
StateSuggestions1.prototype.requestSuggestions = function (AutoSuggestControl1 /*:AutoSuggestControl*/,
                                                          bTypeAhead /*:boolean*/) {
    var aSuggestions = [];
    var sTextboxValue = AutoSuggestControl1.textbox.value;
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
    AutoSuggestControl1.autosuggest(aSuggestions, bTypeAhead);
};';

$stringbuild1 = "";
$query1 = "select * from master_lab group by itemcode";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_num_rows($exec1);
while ($res1 = mysqli_fetch_array($exec1))
{
	//$res1autonumber = $res1['auto_number'];
	
		$res1icdcode=$res1['itemname'];
		$res1icdcode = strtoupper($res1icdcode);
		if ($stringbuild1 == '')
		{
			$stringbuild1 = '"'.''.$res1icdcode.'"';
		}
		else
		{
			$stringbuild1 = $stringbuild1.',"'.''.$res1icdcode.'"';
		}
	
}

//echo $stringbuild1;

//building file.
$filecontent = $stringpart1.$stringbuild1.$stringpart2;
//$filename = $scriptname.'js';
$filefolder = 'js';
$filename = 'autocomplete_1lab.'.'js';
$filepath = $filefolder.'/'.$filename;
$fp = fopen($filepath, 'w');
fwrite($fp, $filecontent);
fclose($fp);

?>
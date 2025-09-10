<?php
//session_start();
include ("db/db_connect.php");

$stringpart1 = '
function StateSuggestions2() {
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
StateSuggestions2.prototype.requestSuggestions = function (AutoSuggestControl2 /*:AutoSuggestControl*/,
                                                          bTypeAhead /*:boolean*/) {
    var aSuggestions = [];
    var sTextboxValue = AutoSuggestControl2.textbox.value;
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
    AutoSuggestControl2.autosuggest(aSuggestions, bTypeAhead);
};';

$stringbuild1 = "";
$query1 = "select * from master_itempharmacy where status <> 'Deleted' order by itemname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$res1autonumber = $res1['auto_number'];
	$res1drug = $res1['itemname'];
	/*$res1customermiddlename = $res1['customermiddlename'];
	$res1customerlastname = $res1['customerlastname'];
	$res1nationalidnumber = $res1['nationalidnumber'];
	$res1mobilenumber = $res1['mobilenumber'];
	*/
	
	//$res1autonumber = addslashes($res1autonumber);
	$res1drug = addslashes($res1drug);
	/*$res1customermiddlename = addslashes($res1customermiddlename);
	$res1customerlastname = addslashes($res1customerlastname);
	$res1nationalidnumber = addslashes($res1nationalidnumber);
	$res1mobilenumber = addslashes($res1mobilenumber);
*/
	//$res1autonumber = strtoupper($res1autonumber);
	$res1drug = strtoupper($res1drug);
	/*$res1customermiddlename = strtoupper($res1customermiddlename);
	$res1customerlastname = strtoupper($res1customerlastname);
	$res1nationalidnumber = strtoupper($res1nationalidnumber);
	$res1mobilenumber = strtoupper($res1mobilenumber);
	*/
	//$res1autonumber = trim($res1autonumber);
	$res1drug = trim($res1drug);
	
	//$res1itemcode = preg_replace('/,/', ' ', $res1itemcode);
	$res1drug = preg_replace('/,/', ' ', $res1drug);
	if ($stringbuild1 == '')
	{
		$stringbuild1 = '"'.$res1autonumber.'||'.$res1drug.'"';
	}
	else
	{
		$stringbuild1 = $stringbuild1.',"'.$res1autonumber.'||'.$res1drug.'"';
	}
}
//echo $stringbuild1;

//building file.
$filecontent = $stringpart1.$stringbuild1.$stringpart2;
//$filename = $scriptname.'js';
$filefolder = 'js';
$filename = 'autocomplete_drugallergy1.'.'js';
$filepath = $filefolder.'/'.$filename;
$fp = fopen($filepath, 'w');
fwrite($fp, $filecontent);
fclose($fp);

?>
<?php
//session_start();
include ("db/db_connect.php");

$stringpart1 = '
function StateSuggestions77() {
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
StateSuggestions77.prototype.requestSuggestions = function (AutoSuggestControl7 /*:AutoSuggestControl*/,
                                                          bTypeAhead /*:boolean*/) {
    var aSuggestions = [];
    var sTextboxValue = AutoSuggestControl7.textbox.value;
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
    AutoSuggestControl7.autosuggest(aSuggestions, bTypeAhead);
};';

$stringbuild1 = "";
$query1 = "select * from master_surgery where recordstatus <> 'Deleted' order by surgery";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	//$res1autonumber = $res1['auto_number'];
	$res1anum = $res1['auto_number'];
	$res1surgery= $res1['surgery'];
	/*$res1customermiddlename = $res1['customermiddlename'];
	$res1customerlastname = $res1['customerlastname'];
	$res1nationalidnumber = $res1['nationalidnumber'];
	$res1mobilenumber = $res1['mobilenumber'];
	*/
	
	//$res1autonumber = addslashes($res1autonumber);
	
	/*$res1customermiddlename = addslashes($res1customermiddlename);
	$res1customerlastname = addslashes($res1customerlastname);
	$res1nationalidnumber = addslashes($res1nationalidnumber);
	$res1mobilenumber = addslashes($res1mobilenumber);
*/
	//$res1autonumber = strtoupper($res1autonumber);
	$res1surgery= strtoupper($res1surgery);
	/*$res1customermiddlename = strtoupper($res1customermiddlename);
	$res1customerlastname = strtoupper($res1customerlastname);
	$res1nationalidnumber = strtoupper($res1nationalidnumber);
	$res1mobilenumber = strtoupper($res1mobilenumber);
	*/
	//$res1autonumber = trim($res1autonumber);
	$res1surgery = trim($res1surgery);
	
	//$res1doctorcode = preg_replace('/,/', ' ', $res1doctorcode);
	$res1surgery = preg_replace('/,/', ' ', $res1surgery);
	if ($stringbuild1 == '')
	{
		$stringbuild1 = '"'.$res1anum.'||'.' '.$res1surgery.'"';
	}
	else
	{
		$stringbuild1 = $stringbuild1.',"'.$res1anum.'||'.' '.$res1surgery.'"';
	}
}
if ($stringbuild1 != '')
{
 //echo $stringbuild1;
}
//echo $stringbuild1;

//building file.
$filecontent = $stringpart1.$stringbuild1.$stringpart2;
//$filename = $scriptname.'js';
$filefolder = 'js';
$filename = 'autocomplete_surgery.'.'js';
$filepath = $filefolder.'/'.$filename;
$fp = fopen($filepath, 'w');
fwrite($fp, $filecontent);
fclose($fp);

?>
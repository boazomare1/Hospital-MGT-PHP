<?php
//session_start();
include ("db/db_connect.php");

$stringpart1 = '
function StateSuggestions() {
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
StateSuggestions.prototype.requestSuggestions = function (oAutoSuggestControl /*:AutoSuggestControl*/,
                                                          bTypeAhead /*:boolean*/) {
    var aSuggestions = [];
    var sTextboxValue = oAutoSuggestControl.textbox.value;
    
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
    oAutoSuggestControl.autosuggest(aSuggestions, bTypeAhead);
};';
$stringbuild1 = "";
$query1 = "select * from master_ipvisitentry where bedallocation='completed' and recordstatus <> 'Deleted' and discharge <> 'completed' order by patientfullname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{
	$res1patientcode = $res1['patientcode'];
	
	$res1visitcode = $res1['visitcode'];
	
	$res1patientfullname=$res1['patientfullname'];
	

	
	$res1patientcode = addslashes($res1patientcode);
	
   $res1patientfullname=addslashes($res1patientfullname);
	
	$res1patientcode = strtoupper($res1patientcode);
	
	$res1patientfullname=strtoupper($res1patientfullname);
	
	$res1patientcode = trim($res1patientcode);
	$res1patientfullname = trim($res1patientfullname);
	
	$res1patientcode = preg_replace('/,/', ' ', $res1patientcode);
	$res1patientfullname = preg_replace('/,/', ' ', $res1patientfullname);
	
	if ($stringbuild1 == '')
	{
		$stringbuild1 = '"'.$res1patientfullname.'#'.$res1patientcode.'#'.$res1visitcode.'"';
	}
	else
	{
		$stringbuild1 = $stringbuild1.',"'.$res1patientfullname.'#'.$res1patientcode.'#'.$res1visitcode.'"';
	}
}
//echo $stringbuild1;

//building file.
$filecontent = $stringpart1.$stringbuild1.$stringpart2;
//$filename = $scriptname.'js';
$filefolder = 'js';
$filename = 'autocomplete_customerbedtransfer.'.'js';
$filepath = $filefolder.'/'.$filename;
$fp = fopen($filepath, 'w');
fwrite($fp, $filecontent);
fclose($fp);





?>

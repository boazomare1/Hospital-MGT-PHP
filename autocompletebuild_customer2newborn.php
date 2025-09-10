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
$query1 = "select * from master_ipvisitentry where discharge = '' order by patientfullname";
$exec1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1) or die ("Error in Query1".mysqli_error($GLOBALS["___mysqli_ston"]));
while ($res1 = mysqli_fetch_array($exec1))
{

	$res1customercode = $res1['patientcode'];
	$res1customername = $res1['patientfirstname'];
	$res1customerfullname=$res1['patientfullname'];
	$res1customervisitcode=$res1['visitcode'];
	$date = $res1['consultationdate'];
	$accountname = $res1['accountname'];
	$query67 = "select * from master_accountname where auto_number='$accountname'";
	$exec67 = mysqli_query($GLOBALS["___mysqli_ston"], $query67); 
	$res67 = mysqli_fetch_array($exec67);
	$accname = $res67['accountname'];
		
	$querys = "SELECT * FROM `master_customer` where customercode = '$res1customercode'";
	$execs = mysqli_query($GLOBALS["___mysqli_ston"], $querys) or die ("Error in Query4".mysqli_error($GLOBALS["___mysqli_ston"]));
	$ress = mysqli_fetch_array($execs);
	$dob = $ress['dateofbirth'];
	$days = (strtotime($date) - strtotime($dob))/86400;
	if($days >= 1)
	{
		$res1customercode = addslashes($res1customercode);
		$res1customername = addslashes($res1customername);
		$res1customerfullname=addslashes($res1customerfullname);
		$res1customervisitcode=addslashes($res1customervisitcode);
		
		$res1customercode = strtoupper($res1customercode);
		$res1customername = strtoupper($res1customername);
		$res1customerfullname=strtoupper($res1customerfullname);
		$res1customervisitcode=strtoupper($res1customervisitcode);
		
		$res1customercode = trim($res1customercode);
		$res1customername = trim($res1customername);
		$res1customervisitcode = trim($res1customervisitcode);
		
		$res1customercode = preg_replace('/,/', ' ', $res1customercode);
		$res1customername = preg_replace('/,/', ' ', $res1customername);
		$res1customervisitcode = preg_replace('/,/', ' ', $res1customervisitcode);
		
		if ($stringbuild1 == '')
		{
			$stringbuild1 = '"'.$res1customerfullname.'#'.$res1customercode.'#'.$res1customervisitcode.'#'.$accname.'"';
		}
		else
		{
			$stringbuild1 = $stringbuild1.',"'.$res1customerfullname.'#'.$res1customercode.'#'.$res1customervisitcode.'#'.$accname.'"';
		}
	}
}
//echo $stringbuild1;

//building file.
$filecontent = $stringpart1.$stringbuild1.$stringpart2;
//$filename = $scriptname.'js';
$filefolder = 'js';
$filename = 'autocomplete_customer2newborn.'.'js';
$filepath = $filefolder.'/'.$filename;
$fp = fopen($filepath, 'w');
fwrite($fp, $filecontent);
fclose($fp);





?>
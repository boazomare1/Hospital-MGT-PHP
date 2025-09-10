
function StateSuggestions3() {
this.states = 
[
"APA INSURANCE#02-1500-2#1523","BRITAM GENERAL INSURANCE#02-1500-3#1524","DIRECTORS CURRENT#02-3000-4#589","EQUITY#02-1500-4#1525","FIXED DEPOSITS#02-3000-2#588","HERITAGE INSURANCE#02-1500-5#1526","KENYAN ALLIANCE INSURANCE#02-1500-6#1527","LUTON HOSPITAL#02-1500-7#1528","MADISON INSURANCE#02-1500-8#1529","MTIBA INSURANCE#02-1500-9#1530","MTN INSURANCE#02-1500-14#1535","MUA INSURANCE#02-1500-10#1531","NATIONALL HEALTH INSURANCE FUND#02-1500-11#1532","SEDGWICK INSURANCE#02-1500-12#1533","STAFF RECEIVABLE ACCOUNT#02-3500-2#590","TRIDENT INSURANCE#02-1500-13#1534","WORK IN PROGRESS#02-3000-5#587"];
}

/**
 * Request suggestions for the given autosuggest control. 
 * @scope protected
 * @param oAutoSuggestControl The autosuggest control to provide suggestions for.
 */
StateSuggestions3.prototype.requestSuggestions = function (oAutoSuggestControl3 /*:AutoSuggestControl*/,
                                                          bTypeAhead /*:boolean*/) {
    var aSuggestions = [];
    var sTextboxValue = oAutoSuggestControl3.textbox.value;
    
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
    oAutoSuggestControl3.autosuggest(aSuggestions, bTypeAhead);
};
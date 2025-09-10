/*
function StateSuggestionsbed() {
this.states = 
[
"BRITISH AMERICAN INSURANCE COMPANY","CASH","ICICI INSURANCE","INDIVIDUAL ACCOUNTS","JUBILEE INSURANCE COMPANY","JUNIOR STAFF","LIC INDIA","MANAGEMENT STAFF","UNITED INSURANCE INDIA"];
}
*/
function StateSuggestionsbed() {
this.states = 
[];
}

/**
 * Request suggestions for the given autosuggest control. 
 * @scope protected
 * @param oAutoSuggestControlbed The autosuggest control to provide suggestions for.
 */
StateSuggestionsbed.prototype.requestSuggestions = function (oAutoSuggestControlbed /*:AutoSuggestControlmed*/,
                                                          bTypeAhead /*:boolean*/) {
    var aSuggestions = [];
    var sTextboxValue = oAutoSuggestControlbed.textbox.value;
    
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
    oAutoSuggestControlbed.autosuggest(aSuggestions, bTypeAhead);
};
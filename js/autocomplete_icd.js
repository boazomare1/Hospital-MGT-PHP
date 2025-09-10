/*
function StateSuggestions17() {
this.states = 
[
"BRITISH AMERICAN INSURANCE COMPANY","CASH","ICICI INSURANCE","INDIVIDUAL ACCOUNTS","JUBILEE INSURANCE COMPANY","JUNIOR STAFF","LIC INDIA","MANAGEMENT STAFF","UNITED INSURANCE INDIA"];
}
*/
function StateSuggestions17() {
	//alert('h');
this.states = 
[];
}

/**
 * Request suggestions for the given autosuggest control. 
 * @scope protected
 * @param oAutoSuggestControl17 The autosuggest control to provide suggestions for.
 */
StateSuggestions17.prototype.requestSuggestions = function (oAutoSuggestControl17 /*:AutoSuggestControl17*/,
                                                          bTypeAhead /*:boolean*/) {
	
    var aSuggestions = [];
	//alert(aSuggestions);
    var sTextboxValue = oAutoSuggestControl17.textbox.value;
    
 	var loopLength = 0;

    if (sTextboxValue.length > 0){
    
	var sTextboxValue = sTextboxValue.toUpperCase();
	
	//alert(sTextboxValue);

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
    oAutoSuggestControl17.autosuggest(aSuggestions, bTypeAhead);
};
/*
function StateSuggestionsmed() {
this.states = 
[
"BRITISH AMERICAN INSURANCE COMPANY","CASH","ICICI INSURANCE","INDIVIDUAL ACCOUNTS","JUBILEE INSURANCE COMPANY","JUNIOR STAFF","LIC INDIA","MANAGEMENT STAFF","UNITED INSURANCE INDIA"];
}
*/
function StateSuggestionscustomer() {
	
this.states = 
[];
}

/**
 * Request suggestions for the given autosuggest control. 
 * @scope protected
 * @param oAutoSuggestControlmed The autosuggest control to provide suggestions for.
 */
StateSuggestionscustomer.prototype.requestSuggestions = function (oAutoSuggestControlcustomer /*:AutoSuggestControlmed*/,
                                                          bTypeAhead /*:boolean*/) {
	//alert('h');
    var aSuggestions = [];
    var sTextboxValue = oAutoSuggestControlcustomer.textbox.value;
    //alert(sTextboxValue);
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
    oAutoSuggestControlcustomer.autosuggest(aSuggestions, bTypeAhead);
};
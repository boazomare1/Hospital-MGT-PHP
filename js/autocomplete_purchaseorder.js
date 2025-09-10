
function StateSuggestions3() {
this.states = 
[
" PO-102-24-1"," PO-109-24-1"," PO-126-24-1"," PO-127-24-1"," PO-128-24-1"," PO-129-24-1"," PO-130-24-1"," PO-131-24-1"," PO-132-24-1"," PO-133-24-1"," PO-134-24-1"," PO-135-24-1"," PO-136-24-1"," PO-137-24-1"," PO-138-24-1"," PO-140-24-1"," PO-141-24-1"," PO-142-24-1"," PO-143-24-1"," PO-15-24-1"," PO-157-24-1"," PO-158-24-1"," PO-159-24-1"," PO-160-24-1"," PO-161-24-1"," PO-162-24-1"," PO-163-24-1"," PO-164-24-1"," PO-165-24-1"," PO-166-24-1"," PO-167-24-1"," PO-168-24-1"," PO-169-24-1"," PO-170-24-1"," PO-19-24-1"," PO-20-24-1"," PO-21-24-1"," PO-22-24-1"," PO-24-24-1"," PO-25-24-1"," PO-27-24-1"," PO-28-24-1"," PO-29-24-1"," PO-31-24-1"," PO-38-24-1"," PO-40-24-1"," PO-44-24-1"," PO-59-24-1"," PO-60-24-1"," PO-61-24-1"," PO-62-24-1"," PO-63-24-1"," PO-65-24-1"," PO-66-24-1"," PO-67-24-1"," PO-68-24-1"," PO-72-24-1"," PO-73-24-1"," PO-74-24-1"," PO-75-24-1"," PO-92-24-1"," PO-93-24-1"];
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
};
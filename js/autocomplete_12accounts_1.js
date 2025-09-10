
function StateSuggestions11() {
this.states = 
[
"MEDICAL EQUIPMENT - COST.#04-5101","MOTOR VEHICLES-COST#04-5111","INVESTMENT IN ASSOCIATE#04-5201","MEDICAL EQUIPMENT-COST#04-5140-NHL","ACCUMULATED DEPN-MEDICAL EQUIPMENT.#04-5141-NHL","MEDICAL EQUIPMENT-DISPOSALS#04-5142-NHL","ACCUMULATED DEPN-DISPOSAL#04-5143-NHL","BUILDING-COST#06-6101-NHL","ACCUMULATED DEPN - BUILDINGS#06-6102-NHL","ACCUMULATED-DEPN#06-6103-NHL","BUILDING-DISPOSAL#06-6104-NHL","LAND-COST#06-6201-NHL","ACCUMULATED DEPRECIATION-LAND#06-6202-NHL","LAND-ADDITIONS#06-6203-NHL","COMPUTERS-COST#06-6301-NHL","ACCUMULATED DEPN - COMPUTER#06-6302-NHL","COMPUTER-DISPOSAL#06-6303-NHL","ACCUMULATED DEPN-DISPOSALS#06-6304-NHL","FURNITURE AND FITTINGS-COST#06-4001-NHL","ACCUMULATED DEPN - FURNITURE AND FITTINGS#06-4002-NHL","FURNITURE AND FITTINGS-DISPOSALS#06-4003-NHL","ACCUMULATED DEPN- MOTOR VEHICLES#06-6601-NHL","OFFICE EQUIPMENT - COST#06-7003-NHL","ACCUMULATED DEPN- OFFICE EQUIPMENT#06-7004-NHL","OFFICE EQUIPMENT - DISPOSALS#06-7005-NHL","OFFICE EQUIPMENT - ACC DEPN DISPORSALS#06-7006-NHL","FURNITURE & FITTINGS - DEPN DISPOSALS#06-4004-NHL","MOTOR VEHICLES - DISPOSALS#06-6603-NHL","MOTOR VEHICLES - DEPN DISPOSALS#06-6604-NHL","LOOSE TOOLS AND EQUIPMENT - COST#06-6803-NHL","ACCUMULATED DEPN- LOOSE TOOLS AND EQUIPMENT#06-6804-NHL","LOOSE TOOLS AND EQUIPMENT - DISPOSALS#06-6805-NHL","ACCUMULATED DEPN - DISPOSALS#06-6806-NHL"];
}

/**
 * Request suggestions for the given autosuggest control. 
 * @scope protected
 * @param oAutoSuggestControl11 The autosuggest control to provide suggestions for.
 */
StateSuggestions11.prototype.requestSuggestions = function (oAutoSuggestControl11 /*:AutoSuggestControl*/,
                                                          bTypeAhead /*:boolean*/) {
    var aSuggestions = [];
    var sTextboxValue = oAutoSuggestControl11.textbox.value;
    
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
    oAutoSuggestControl11.autosuggest(aSuggestions, bTypeAhead);
};
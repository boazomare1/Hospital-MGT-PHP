
function StateSuggestions() {
this.states = 
[
"NORMAL DELIVERY","CEASERIAN SECTION","MYOMECTOMY","LAPARATOMY","TOTAL ABDOMINAL HISTELECTOMY","MACDONALD STITCHING","REMOVAL OF MACDONALD STITCHES","M.V.A","DILATATION & CULATAGE-GENERAL WARD","REMOVAL OF IUCD","REMOVAL OF RETAINED PLACENTA","SECONDARY SUTURING","REPAIR OF CERVICAL TEARS 3RD DEGREE","ORCHIDAPEXY","SEQUESTRECTOMY","ASSISTED DELIVERY","ECTOPIC PREGNANCY","INFILTRATION","MASTECTOMY/THYROIDECTOMY","EXCISION UNDER G.A/CYSTECTOMY","EXCISION UNDER SEDATION","EPISIOTOMY/PERINEAL REPAIR","DIATHERMY","HERNIARRPHY","APPENDICECTOMY","HYDROCELECTOMY","CIRCUMCISSION(IN PHIMOSIS)","SURGICAL TOILETING"];
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
};
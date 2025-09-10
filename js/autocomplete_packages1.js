
function StateSuggestions3() {
this.states = 
[
"23||AAR INSURANCE MEDEX RATES","38||ANTE-NATAL SCREEN","10||CAESERIAN SECTION","44||CHILDREN WELLNESS","16||CIRCUMCISION UNDER GENERAL ANAESTHETIST (GA)","15||CIRCUMCISION UNDER LOCAL ANAESTHETIST (LA)","39||DIABETES PACKAGE","22||FIRST ASSURANCE STANDARD HEALTH CHECK UP FEMALE","21||FIRST ASSURANCE STANDARD HEALTH CHECK UP MALE","13||HEALTH CHECK UP PACKAGE FEMALE (DHL GLOBAL)","14||HEALTH CHECK UP PACKAGE MALE (DHL GLOBAL)","43||INFANT SCREENING PACKAGE - 12 MONTHS","42||INFANT SCREENING PACKAGE - 6 MONTHS","41||INFANT SCREENING PACKAGE - WEEK 1 - WEEK 6 (BORN ELSEWHERE)","40||INFANT SCREENING PACKAGE - WEEK 1- WEEK 6 (BORN @ PREMIER)","20||INSURANCE HEALTH CHECK UP (FEMALE)","19||INSURANCE HEALTH CHECK UP (MALE)","37||MALKIA BASIC HEALTH CHECKUP","8||MALKIA CANCER SCREENING","33||MALKIA COMPREHENSIVE HEALTH CHECKUP","46||MALKIA EXECUTIVE HEALTH CHECK UP","36||MALKIA STANDARD HEALTH CHECKUP","35||MFALME BASIC HEALTH CHECKUP","9||MFALME CANCER SCREENING","32||MFALME COMPREHENSIVE HEALTH CHECKUP","45||MFALME EXECUTIVE HEALTH CHECK UP","34||MFALME STANDARD HEALTH CHECKUP","1||NORMAL DELIVERY","18||TRANCENC STANDARD HEALTH CHECK UP (FEMALE)","17||TRANCENC STANDARD HEALTH CHECK UP (MALE)","25||WELL MAN JUBILEE BASIC","29||WELL MAN JUBILEE COMPREHENSIVE","31||WELL MAN JUBILEE EXECUTIVE","27||WELL MAN JUBILEE STANDARD","24||WELL WOMAN JUBILEE BASIC","28||WELL WOMAN JUBILEE COMPREHENSIVE","30||WELL WOMAN JUBILEE EXECUTIVE","26||WELL WOMAN JUBILEE STANDARD","12||WELL WOMAN PACKAGE(CREDIT BANK)","11||WELL-MAN PACKAGE(CREDIT BANK)","7||WELLNESS CHECKUP FEMALE(WITH CANCER SCREENING)","2||WELLNESS CHECKUP MALE(WITH CANCER SCREENING)"];
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
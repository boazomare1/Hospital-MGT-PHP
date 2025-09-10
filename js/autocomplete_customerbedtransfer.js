
function StateSuggestions() {
this.states = 
[
"ANGEL WANJIKU#PH-25-24#IPV-35-1","BLESSING WAMBUI NJOROGE#PH-373-24#IPV-127-1","DAMIEN IRUNGU MUSYOKA#PH-195-24#IPV-89-1","ELIZABETH GABRIELLA VICTOR#PH-33-24#IPV-16-1","ELKANA NGENO KIPRONO#PH-318-24#IPV-113-1","ESTHER NJERI#PH-131-24#IPV-71-1","FUREZAH MARY NYAKIO KIMANI#PH-394-24#IPV-132-1","GLADYS MWANGANGI#PH-9-24#IPV-42-1","HUSSEIN FARDOSA SAMATA#PH-405-24#IPV-134-1","HYLINE MANYARA#PH-19-24#IPV-32-1","ISAAC CHEGE MUHIA#PH-154-24#IPV-78-1","IVY CHEPTOO#PH-143-24#IPV-75-1","JANE WAITHIRA KAMAU#PH-392-24#IPV-131-1","JESSICAH KAMANDI KILUI#PH-264-24#IPV-104-1","JOHN NDIRANGU KAMAU#PH-291-24#IPV-107-1","JOHN NYAMBERI MABIRIA#PH-21-24#IPV-33-1","JOSEPH KAMAU#PH-266-24#IPV-105-1","JOSEPH KARIUKI WAICHUNGO#PH-238-24#IPV-100-1","JOSEPHINE MUMBUA MAIMA#PH-4-24#IPV-4-1","KAYLAH VISA MWEU#PH-35-24#IPV-17-1","KEVIN NGANGA#PH-5-24#IPV-40-1","MARGARET MBITHE MUTISO#PH-250-24#IPV-103-1","MERCY KAMORANGI#PH-385-24#IPV-129-1","MERCY SYOKAU KIOKO#PH-145-24#IPV-76-1","MERCY WANJIKU#PH-245-24#IPV-116-1","NICHOLAS NDOME#PH-396-24#IPV-133-1","NICKSON MBOGO#PH-352-24#IPV-123-1","PASQUALINA WANJIRA MUNYI#PH-14-24#IPV-11-1","PETER KYALO NZIOKA#PH-128-24#IPV-68-1","PETER MAINA NDIRANGU#PH-18-24#IPV-3-1","PRINCESS MUTHONI GITHURE#PH-8-24#IPV-8-1","RUTH BANZA#PH-246-24#IPV-102-1","SHABANI SALIKI ADOLF#PH-406-24#IPV-135-1","SHANNEL JEPCHIRCHIR#PH-184-24#IPV-88-1","STANLEY KAMAU GATUNE#PH-6-24#IPV-6-1","SUSAN MUITE#PH-356-24#IPV-126-1","SUSAN NDUTA#PH-27-24#IPV-13-1","TALISHA WANJIKU NJOKI#PH-12-24#IPV-44-1","VINCENT SEBASTIAN WANDERA#PH-28-24#IPV-36-1","ZAINA RONICA KASAYA#PH-219-24#IPV-96-1"];
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
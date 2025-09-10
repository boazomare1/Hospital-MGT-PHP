
function StateSuggestions() {
this.states = 
[
"ERIC KYALO KITHOME#PH-93-24#IPV-55-1","ANGEL PATRICIA WAITHERA#PH-34-24#IPV-24-1","PATRICIA KANGANGI KANGANGI#PH-38-24#IPV-26-1","STEPHEN KIMINDA KAMAU#PH-111-24#IPV-65-1","STEPHEN NGUNGI MWANGI#PH-77-24#IPV-52-1","JAMES MUTONGA#PH-102-24#IPV-60-1","KAI BLUEBELL NYABETA#PH-130-24#IPV-70-1","PHILOMENA NYAMBURA WAMBUI#PH-107-24#IPV-64-1","JOSEPH NDUNGU WANYOIKE#PH-10-24#IPV-43-1","ALICE KAVUGWI AMADALO#PH-11-24#IPV-9-1","KAYLA WANJIKU MURAYA#PH-171-24#IPV-82-1","KAYLAN WAMBUI MWANGI#PH-91-24#IPV-54-1","JOSEPH KARANGA NJERU#PH-47-24#IPV-46-1","JOSEPHAT IRUNGU THUO#PH-201-24#IPV-90-1","SARAH LASOHA#PH-138-24#IPV-87-1","TITUS MWANGI MUGWE#PH-29-24#IPV-14-1","HENRY KISANDA AMUYUNZU#PH-173-24#IPV-84-1","ROSE MUTHONI#PH-159-24#IPV-81-1","ANAH OKWARO WERE#PH-233-24#IPV-99-1","MARGARET MWERU WANYUGI#PH-26-24#IPV-12-1","SAMMY WANGITHI#PH-226-24#IPV-98-1","SAMMY WANGITHI#PH-226-24#IPV-98-1","MARY KANJE KIMATU#PH-24-24#IPV-10-1","CHRISTINE WANJIRU#PH-103-24#IPV-61-1","JOE MAINA NJUGUNA#PH-22-24#IPV-7-1","JOE MAINA NJUGUNA#PH-22-24#IPV-7-1","MARGARET NJOKI MBURU#PH-7-24#IPV-41-1","MARGARET NJOKI MBURU#PH-7-24#IPV-41-1","FATUMA BILLOW ISSACK#PH-172-24#IPV-83-1","MAGDALINE WANJIKU KABUE#PH-204-24#IPV-92-1","JANE WANJIRU MWANGI#PH-45-24#IPV-22-1","PETER OWINO ONGITO#PH-2-24#IPV-2-1","LYNNE NGINA#PH-341-24#IPV-119-1","PHILOMENA KIVUVE KAMENE#PH-347-24#IPV-122-1","SAMSON MWANGI WANJAU#PH-345-24#IPV-121-1","EMMANUEL NDICU NJOROGE#PH-39-24#IPV-27-1","DERRICK LUSASU JOSIAH#PH-23-24#IPV-34-1","FATUMA MWERU#PH-1-24#IPV-38-1","JANE ACHOLA OTWARO#PH-179-24#IPV-86-1","ESUPAT GABRIEL KIMIREI#PH-217-24#IPV-95-1","HANNAH WANJIRU WANGANGA#PH-300-24#IPV-110-1","PATRICK KIILU MUSYOKA#PH-307-24#IPV-111-1","JAREMIAH SIBOUR ACHILA#PH-390-24#IPV-130-1","JOSHUA KILEU KILIMO#PH-355-24#IPV-125-1","ALEX MUUMBA#PH-372-24#IPV-128-1","STEPHEN KARANJA MBUGUA#PH-224-24#IPV-97-1","FREDRICK MBURU THOBORA#PH-354-24#IPV-124-1","FREDRICK MBURU THOBORA#PH-354-24#IPV-124-1","ROSE MUNANIE MUNYOKI#PH-20-24#IPV-5-1","DAVID MUTHUI PHILIP#PH-13-24#IPV-45-1"];
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



%As Panikos I prefer ordering delivery as much as possible then takeaway then cooking my meal by myself.
%There is a chance that The restaurant does noDelivery, noTakeway or noCook.
%Moreover there is a chance I am in a moodToCook so I prefer cooking and if I haveHw I prefer Delivery because HW is important.
%Additionally, if easyHw then if we were to cook then we cook even though we have HW
%There is chance that noDelivery is possible so we resort to takeAway as delivery other than cooking if neg(moodToCook).
%Lastly if noDelivery, noTakeway or noCook then we are forced to cook even though noCook


%method args
:- dynamic noCook/0, noDelivery/0, noTakeaway/0, moodToCook/0 , haveHw/0, easyHw/0 .

%he rpefers delivery than take away
prefersDelivery.

% OPTIONS and complementarity
complement(cook(Method), delivery(Method)).
complement(cook(Method), takeAway(Method)).
complement(delivery(Method), cook(Method)).
complement(delivery(Method), takeAway(Method)).
complement(takeAway(Method), delivery(Method)).
complement(takeAway(Method), cook(Method)).

%method argumentation

rule(emptyMethodRuleDel(Method), delivery(Method) , []).
rule(emptyMethodRuleCook(Method), cook(Method) , []).
rule(emptyMethodRuleTake(Method), takeAway(Method) , []).

%Panikos Likes delivery than all then take away finaly cook
rule(delThanCookEmptyRule, prefer(emptyMethodRuleDel(Method), emptyMethodRuleCook(Method)), []).
rule(takeThanCookEmptyRule, prefer(emptyMethodRuleTake(Method), emptyMethodRuleCook(Method)), []).

%prefer del than take way - Cristian pregers otherwise
rule(delThanTakeEmptyRule, prefer(emptyMethodRuleDel(Method), emptyMethodRuleTake(Method)), []).

%If he is in a moodToCook then he prefers Cook then Delivery then takeAway

rule(moodToCookRule(Method), cook(Method) , []) :- moodToCook . %mood to cook rule

rule(preferMoodToCook1, prefer(moodToCookRule(Method), emptyMethodRuleDel(Method)), []):- moodToCook.
rule(preferMoodToCook2, prefer(moodToCookRule(Method), emptyMethodRuleTake(Method)), []):- moodToCook.
rule(preferMoodToCook3, prefer(moodToCookRule(Method), emptyMethodRuleCook(Method)), []):- moodToCook.


%If he has Hw then delivery and take away win over
rule(haveHwRuleDel(Method), delivery(Method) , []) :- haveHw.
rule(haveHwRuleTake(Method), takeAway(Method) , []) :- haveHw.

rule(preferHaveHwRuleDel1, prefer(haveHwRuleDel(Method), emptyMethodRuleDel(Method)), []).
rule(preferHaveHwRuleDel2, prefer(haveHwRuleDel(Method), emptyMethodRuleTake(Method)), []).
rule(preferHaveHwRuleDel3, prefer(haveHwRuleDel(Method), emptyMethodRuleCook(Method)), []).

rule(preferHaveHwRuleTake1, prefer(haveHwRuleTake(Method), emptyMethodRuleDel(Method)), []).
rule(preferHaveHwRuleTake2, prefer(haveHwRuleTake(Method), emptyMethodRuleTake(Method)), []).
rule(preferHaveHwRuleTake3, prefer(haveHwRuleTake(Method), emptyMethodRuleCook(Method)), []).

%Del over take away
rule(preferHaveHwRule, prefer(haveHwRuleDel(Method), haveHwRuleTake(Method)), []):-prefersDelivery.


%take away over del
rule(preferHaveHwRule, prefer(haveHwRuleTake(Method), haveHwRuleDel(Method)), []):-not(prefersDelivery).



%If he has Hw and moodToCook then delivery and take away win over
rule(haveHwMoodRuleDel(Method), delivery(Method) , []) :- haveHw, moodToCook.
rule(haveHwMoodRuleTake(Method), takeAway(Method) , []) :- haveHw, moodToCook.

rule(preferHaveHwMoodRuleDel1, prefer(haveHwMoodRuleDel(Method), haveHwRuleDel(Method)), []).
rule(preferHaveHwMoodRuleDel2, prefer(haveHwMoodRuleDel(Method), haveHwRuleTake(Method)), []).

rule(preferHaveHwMoodRuleTake1, prefer(haveHwMoodRuleTake(Method), haveHwRuleDel(Method)), []).
rule(preferHaveHwMoodRuleTake2, prefer(haveHwMoodRuleTake(Method), haveHwRuleTake(Method)), []).

rule(preferHaveHwMoodRuleTake3, prefer(haveHwMoodRuleTake(Method), moodToCookRule(Method)), []).


rule(preferHaveHwMoodRuleDel3, prefer(haveHwMoodRuleDel(Method), moodToCookRule(Method)), []).


%Del over take away
rule(preferHaveHwMoodRule2, prefer(haveHwMoodRuleDel(Method), haveHwMoodRuleTake(Method)), []):- prefersDelivery .

% take Del
rule(preferHaveHwMoodRule3, prefer(haveHwMoodRuleTake(Method), haveHwMoodRuleDel(Method)), []):- not(prefersDelivery) .

%If we have Hw and but its ezHw then we cook
rule(haveEzHwMoodToCookRule(Method), cook(Method) , []) :- haveHw,easyHw .

rule(preferHaveEzHwMoodToCookRuleDel, prefer(haveEzHwMoodToCookRule(Method), haveHwMoodRuleDel(Method)), []).
rule(preferHaveEzHwMoodToCookRuleTake, prefer(haveEzHwMoodToCookRule(Method), haveHwMoodRuleTake(Method)), []).


%If noDelivery then all possible Dels are neg

rule(noDelivery(Method), neg(delivery(Method)) , []) :- noDelivery .

rule(preferNoDelivery1, prefer(noDelivery(Method), emptyMethodRuleDel(Method)), []).
rule(preferNoDelivery2, prefer(noDelivery(Method), haveHwRuleDel(Method)), []).
rule(preferNoDelivery3, prefer(noDelivery(Method), haveHwMoodRuleDel(Method)), []).


%If noCook then all possible Dels are neg

rule(noCook(Method), neg(cook(Method)) , []) :- noCook .

rule(preferNoCook1, prefer(noCook(Method), emptyMethodRuleCook(Method)), []).
rule(preferNoCook2, prefer(noDelivery(Method), moodToCookRule(Method)), []).
rule(preferNoCook3, prefer(noDelivery(Method), haveEzHwMoodToCookRule(Method)), []).


%If noCook then all possible Dels are neg

rule(noTakeawayRule(Method), neg(takeAway(Method)) , []) :- noTakeaway .

rule(preferNoTakeawayRule1, prefer(noTakeawayRule(Method), emptyMethodRuleTake(Method)), []).
rule(preferNoTakeawayRule2, prefer(noTakeawayRule(Method), haveHwRuleTake(Method)), []).
rule(preferNoTakeawayRule3, prefer(noTakeawayRule(Method), haveHwMoodRuleTake(Method)), []).

%no options we cook because out of options
rule(noOptions(Method), cook(Method) , []) :- noTakeaway, noCook, noDelivery .

rule(preferNoOptions1, prefer(noOptions(Method), noDelivery(Method)), []).
rule(preferNoOptions2, prefer(noOptions(Method), noCook(Method)), []).
rule(preferNoOptions3, prefer(noOptions(Method), noTakeawayRule(Method)), []).


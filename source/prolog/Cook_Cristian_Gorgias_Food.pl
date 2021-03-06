% As  Cristian  I  prefer  cooking as  much  as possible then takeaway then delivery.
% There is a chance that the restaurant does noDelivery, noTakeway or noCook.
% Moreover there is a chance I am in a moodToCook so I prefer cooking and 
% if I  haveHw I prefer Delivery because HW is important.
% Additionally, if easyHw then we cooking always
% There is chance that noDelivery is possible so we resort to takeaway 
% as delivery other than cooking if neg(moodToCook).
% Lastly if  noDelivery, noTakeway or noCook then we are forced to cook even though noCook, no options left


%method args
:- dynamic noCook/0, noDelivery/0, notakeaway/0, moodToCook/0 , haveHw/0, easyHw/0 .


% The prefers takeaway than delivery secondly
prefersCooking.

% OPTIONS and complementarity
complement(cook(Method), takeaway(Method)).
complement(cook(Method), delivery(Method)).
complement(takeaway(Method), delivery(Method)).
complement(takeaway(Method), cook(Method)).
complement(delivery(Method), cook(Method)).
complement(delivery(Method), takeaway(Method)).

% Method argumentation
rule(emptyMethodRuleCook(Method), cook(Method) , []).
rule(emptyMethodRuleTake(Method), takeaway(Method) , []).
rule(emptyMethodRuleDel(Method), delivery(Method) , []).

% He likes cooking then takeaway then take delivery
rule(cookThanTakeEmptyRule, prefer(emptyMethodRuleCook(Method), emptyMethodRuleTake(Method)), []). 
rule(cookThanDelEmptyRule, prefer(emptyMethodRuleCook(Method), emptyMethodRuleDel(Method)), []).
rule(takeThanDelEmptyRule, prefer(emptyMethodRuleTake(Method), emptyMethodRuleDel(Method)), []).

% If he is in a moodToCook then he prefers Cook then takeaway then Delivery
rule(moodToCookRule(Method), cook(Method) , []) :- moodToCook . % mood to cook rule

%% Preference is based on order preference of Cristian
rule(preferMoodToCook1, prefer(moodToCookRule(Method), emptyMethodRuleCook(Method)), []).  
rule(preferMoodToCook2, prefer(moodToCookRule(Method), emptyMethodRuleTake(Method)), []).  
rule(preferMoodToCook3, prefer(moodToCookRule(Method), emptyMethodRuleDel(Method)), []).  

% If he has Hw then prefers ordering delivery then takeaway
rule(haveHwRuleDel(Method), delivery(Method) , []) :- haveHw.
rule(haveHwRuleTake(Method), takeaway(Method) , []) :- haveHw.

%% Preference is based on order preference of Cristian
rule(preferHaveHwRuleDel1, prefer(haveHwRuleDel(Method), emptyMethodRuleCook(Method)), []).
rule(preferHaveHwRuleDel2, prefer(haveHwRuleDel(Method), emptyMethodRuleTake(Method)), []).
rule(preferHaveHwRuleDel3, prefer(haveHwRuleDel(Method), emptyMethodRuleDel(Method)), []).  
  
%% Preference is based on order preference of Cristian
rule(preferHaveHwRuleTake1, prefer(haveHwRuleTake(Method), emptyMethodRuleCook(Method)), []).
rule(preferHaveHwRuleTake2, prefer(haveHwRuleTake(Method), emptyMethodRuleTake(Method)), []).  
rule(preferHaveHwRuleTake3, prefer(haveHwRuleTake(Method), emptyMethodRuleDel(Method)), []).  

% Delivery over take away since we have homework
rule(preferHaveHwRule1, prefer(haveHwRuleDel(Method), haveHwRuleTake(Method)), []) :- prefersCooking.

% If he has Hw and moodToCook then delivery and take away win over
rule(haveHwMoodRuleDel(Method), delivery(Method) , []) :- haveHw, moodToCook.
rule(haveHwMoodRuleTake(Method), takeaway(Method) , []) :- haveHw, moodToCook.

rule(preferHaveHwMoodRuleDel1, prefer(haveHwMoodRuleDel(Method), haveHwRuleDel(Method)), []).  
rule(preferHaveHwMoodRuleDel2, prefer(haveHwMoodRuleDel(Method), haveHwRuleTake(Method)), []).  
rule(preferHaveHwMoodRuleDel3, prefer(haveHwMoodRuleDel(Method), moodToCookRule(Method)), []).

rule(preferHaveHwMoodRuleTake1, prefer(haveHwMoodRuleTake(Method), haveHwRuleDel(Method)), []).  
rule(preferHaveHwMoodRuleTake2, prefer(haveHwMoodRuleTake(Method), haveHwRuleTake(Method)), []).  
rule(preferHaveHwMoodRuleTake3, prefer(haveHwMoodRuleTake(Method), moodToCookRule(Method)), []).  
  
% Del over take away 
rule(preferHaveHwMoodRuleDelW, prefer(haveHwMoodRuleDel(Method), haveHwMoodRuleTake(Method)), []):- prefersCooking.


%If we have Hw and moodToCook but its ezHw then we cook
rule(haveEzHwRule(Method), cook(Method) , []) :- haveHw, easyHw .

rule(preferHaveEzHwMoodToCookRuleDel, prefer(haveEzHwRule(Method), haveHwRuleDel(Method)), []).  
rule(preferHaveEzHwMoodToCookRuleTake, prefer(haveEzHwRule(Method), haveHwRuleTake(Method)), []).  


%If noDelivery then all possible Dels are neg

rule(noDelivery(Method), neg(delivery(Method)) , []) :- noDelivery .

rule(preferNoDelivery1, prefer(noDelivery(Method), emptyMethodRuleDel(Method)), []).  
rule(preferNoDelivery2, prefer(noDelivery(Method), haveHwRuleDel(Method)), []).  
rule(preferNoDelivery3, prefer(noDelivery(Method), haveHwMoodRuleDel(Method)), []).  


%If noCook then all possible Dels are neg

rule(noCook(Method), neg(cook(Method)) , []) :- noCook .

rule(preferNoCook1, prefer(noCook(Method), emptyMethodRuleCook(Method)), []).  
rule(preferNoCook2, prefer(noCook(Method), moodToCookRule(Method)), []).  
rule(preferNoCook3, prefer(noCook(Method), haveEzHwRule(Method)), []).  


%If noCook then all possible Dels are neg

rule(notakeawayRule(Method), neg(takeaway(Method)) , []) :- notakeaway .

rule(preferNotakeawayRule1, prefer(notakeawayRule(Method), emptyMethodRuleTake(Method)), []).  
rule(preferNotakeawayRule2, prefer(notakeawayRule(Method), haveHwRuleTake(Method)), []). 
rule(preferNotakeawayRule3, prefer(notakeawayRule(Method), haveEzHwRule(Method)), []).   
rule(preferNotakeawayRule4, prefer(notakeawayRule(Method), haveHwMoodRuleTake(Method)), []).  

%no options we cook because out of options
rule(noOptions(Method), cook(Method) , []) :- notakeaway, noCook, noDelivery  .

rule(preferNoOptions1, prefer(noOptions(Method), noDelivery(Method)), []).  
rule(preferNoOptions2, prefer(noOptions(Method), noCook(Method)), []).  
rule(preferNoOptions3, prefer(noOptions(Method), notakeawayRule(Method)), []).  


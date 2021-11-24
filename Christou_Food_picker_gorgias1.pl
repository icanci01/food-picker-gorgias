%As  a  student  I  prefer  ordering delivery  as  much  as possible;than  cooking my  mealbymyself. Say I am doing  an  assignment;in  that  case I  need  to  have  food  delivered, because  I  need  to  spend  the  time  on  the assignment itself. Moreover, if I don’t have money or I’m in a mood to cook then I should cook. If I have guests coming, then there is not a clear option, and we have a dilemma.Additionally, I prefer pork souvlaki, beef burgers and salad in the order mentioned.Sometimes I may want to eat healthy, or I don’t have pork.Lastly,there is a chance ofmebeinghostedwhich results to not deciding anything.


:- compile('../lib/gorgias').
:- compile('../ext/lpwnf').


%method args
:- dynamic broke/0, noCook/0, moodToCook/0, haveHomework/0, guestsComing/0 , easyHomework/0 .

%food args
:- dynamic noPork/0, noBeef/0, noSalad/0, healthy/0, moodForBeef/0, moodForSalad/0.


% OPTIONS and complementarity
complement(cook(Food), delivery(Food)).
complement(delivery(Food), cook(Food)).

complement(souvlaki(Food), beef(Food)).
complement(souvlaki(Food), salad(Food)).
complement(beef(Food), souvlaki(Food)).
complement(beef(Food), salad(Food)).
complement(salad(Food), beef(Food)).
complement(salad(Food), souvlaki(Food)).


%method argumentation

% Object level

rule(deliveryRule(Food), delivery(Food) , []):-neg(noDelivery).
rule(r2(Food), cook(Food) , []):-neg(noCook).
rule(p1, prefer(r1(Food), r2(Food)), []). % prefer delivery than cooking in general



% Basic rules 
rule(r3(Food), delivery(Food) , []):- haveHomework. 
rule(r4(Food), cook(Food) , []):-broke.
rule(r5(Food), cook(Food) , []):-noDelivery.
rule(r6(Food), cook(Food) , []):-moodToCook.

rule(p2, prefer(r4(Food), r1(Food)), []).
rule(p3, prefer(r5(Food), r1(Food)), []).
rule(p4, prefer(r6(Food), r1(Food)), []).

% If we are broke or it does not deliver then we definitely don't deliver,
rule(p5, prefer(r4(Food), r3(Food)), []).
rule(p6, prefer(r5(Food), r3(Food)), []).

% If we have both mood to cook and homework, both can happen
rule(r7(Food), cook(Food) , []):-haveHomework,moodToCook.
rule(r8(Food), delivery(Food) , []):-haveHomework,moodToCook.

rule(r9(Food), cook(Food) , []):-haveHomework,moodToCook, noDelivery.
rule(r10(Food), cook(Food) , []):-haveHomework,moodToCook, 	broke.
rule(r11(Food), cook(Food) , []):-haveHomework,moodToCook, moodToCook.

rule(p7, prefer(r9(Food), r8(Food)), []).
rule(p8, prefer(r10(Food), r8(Food)),[]).
rule(p9, prefer(r11(Food), r8(Food)),[]).

rule(p10, prefer(r9(Food), r3(Food)), []).
rule(p11, prefer(r10(Food), r3(Food)),[]).
rule(p12, prefer(r11(Food), r3(Food)),[]).

% If we guests coming then both can happen
rule(r12(Food), cook(Food) , []):-guestsComing.
rule(r13(Food), delivery(Food) , []):-guestsComing.

% Restablishing that if we are broke, does not deliver or mood to cook we always cook. We do not put have homework since we cannot have hw and call guests
rule(r14(Food), cook(Food) , []):-guestsComing , noDelivery.
rule(r15(Food), cook(Food) , []):-guestsComing , 	broke.
rule(r16(Food), cook(Food) , []):-guestsComing , moodToCook.

rule(p14, prefer(r14(Food), r13(Food)), []).
rule(p15, prefer(r15(Food), r13(Food)),[]).
rule(p16, prefer(r16(Food), r13(Food)),[]).

%method args
:- dynamic broke/0, noDelivery/0, noCook/0, moodToCook/0, haveHomework/0, guestsComing/0, beingHosted/0 .


%food args
:- dynamic noPork/0, noBeef/0, noSalad/0, healhy/0, moodForBeef, moodForSalad.

:- compile('../lib/gorgias').
:- compile('../ext/lpwnf').

% OPTIONS and complementarity
complement(cook(Food), delivery(Food)).
complement(delivery(Food), cook(Food)).

complement(souvlaki(Food), beef(Food)).
complement(souvlaki(Food), salad(Food)).
complement(beef(Food), souvlaki(Food)).
complement(beef(Food), salad(Food)).
complement(salad(Food), beef(Food)).
complement(salad(Food), souvlaki(Food)).

rule(r1(Food), delivery(Food) , []):-not(noDelivery).
rule(r2(Food), cook(Food) , []):-not(noCook).
rule(p1, prefer(r1(Food), r2(Food)), []). % prefer delivery than cooking in general

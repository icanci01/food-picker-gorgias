:-dynamic delta/1.
listToJson:-delta(List),write("{"),writeq("Delta"),write(":["),iterate(List),write("]}").
iterate([]).
iterate([H|T]):-write("\""),write(H),write("\""),printComma(T),iterate(T).
printComma([]):-!.
printComma(_RuleList):-write(',').


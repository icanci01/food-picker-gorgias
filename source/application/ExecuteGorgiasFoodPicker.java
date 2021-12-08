import org.jpl7.Query;
import org.jpl7.Term;
import org.json.simple.JSONArray;
import org.json.simple.JSONObject;

import java.util.Map;

public class ExecuteGorgiasFoodPicker {
	public static JSONObject executeGorgias(String filename, String productId, String customerId) {
		JSONObject resultJson = new JSONObject();
		resultJson.put("canSellHigh", false);
		resultJson.put("sellHighDelta", new JSONArray());
		resultJson.put("canSellLow", false);
		resultJson.put("sellLowDelta", new JSONArray());


		// path to tweety.pl C\\.....\.gorgias\examples\tweety.pl
		String prologQuery = "consult('" + filename + "').";
		Query q = new Query(prologQuery);
		if (q.hasNext()) {// Εκτέλεση consult
			String gorgiasQuerySellHigh = "prove([sell(" +productId  + "," +customerId  + ",high)],Delta)";
			q = new Query(gorgiasQuerySellHigh);
			if (q.hasSolution()) {
				resultJson.put("canSellHigh", true);

				if (q.hasNext()) {
					Map<String, Term> result = q.next();
					Term delta = result.get("Delta");
					// Επεξεργασία δέλτα για να βρούμε τους κανόνες που οδηγούν στο συμπέρασμα
					JSONArray deltaRules = iterateDelta(delta);
					// Εκτύπωση εξήγησης για το πώς οδηγηθήκαμε στο συμπέρασμα
					// System.out.println("Because:" +"<ul>" +deltaRulesExplanation+"</ul>");
					resultJson.replace("sellHighDelta", deltaRules);
				}

			}

			String gorgiasQuerySellLow = "prove([sell(" +productId  + "," + customerId + ",low)],Delta)";
			q = new Query(gorgiasQuerySellLow);
			if (q.hasSolution()) {
				resultJson.put("canSellLow", true);
				if (q.hasNext()) {
					Map<String, Term> result = q.next();
					Term delta = result.get("Delta");
					// Επεξεργασία δέλτα για να βρούμε τους κανόνες που οδηγούν στο συμπέρασμα
					JSONArray deltaRules = iterateDelta(delta);
					// Εκτύπωση εξήγησης για το πώς οδηγηθήκαμε στο συμπέρασμα
					// System.out.println("Because:" +"<ul>" +deltaRulesExplanation+"</ul>");
					resultJson.replace("sellLowDelta", deltaRules);

				}

			}
		}
		return resultJson;
	}

	public static JSONArray iterateDelta(Term delta) {
		JSONArray deltaArray = new JSONArray();
		//Ελέγχουμε ότι το δέλτα δεν είναι Null και ότι το δέλτα είναι λίστα.
		if (delta != null & delta.isListPair())
			//Διατρέχουμε την λίστα με τους κανόνες του δέλτα
			for (Term rule : delta.toTermArray()) {
				//Εάν υπάρχει εξήγηση για τον κανόνα μας στο HashMap deltaRulesExplanation
				String ruleName = rule.toString().split("\\(")[0];
				deltaArray.add(ruleName);
				/*if (deltaRulesExplanation.containsKey(ruleName)) {
					//Κάνουμε append τον κανόνα στο αποτέλεσμα
					deltaExplanation.append(deltaRulesExplanation.get(ruleName) + "\n");

				}*/
			}
		//Επιστρέφουμε το αποτέλεσμα πίσω στην συνάρτηση ως String
		return deltaArray;

	}

	public static void main(String[] args) {
		// TODO Auto-generated method stub
		if (args.length == 3) {
			System.out.print(executeGorgias(args[0], args[1], args[2]));

		}

	}

}

<?php
require_once('./SwaggerClient-php/vendor/autoload.php');

use Swagger\Client\Api\PrologControllerApi as PrologControllerApi;
use Swagger\Client\Model\QueryObj as QueryObj;

class LinkGorgiasWithPHP
{

    private $deltaExplanation;

    public function __construct()
    {
        $this->deltaExplanation = array();
        $this->deltaExplanation['emptyMethodRuleDel'] = 'I will order delivery!';
        $this->deltaExplanation['p2p3'] = $this->deltaExplanation['p2'] = $this->deltaExplanation['p3'] = $this->deltaExplanation['c2c4'] = $this->deltaExplanation['c2'] = $this->deltaExplanation['c4'] = '';
    }

    private function generateResultArray($obj)
    {
        $result = array(
            'canSellHigh' => $obj['canSellHigh'],
            'sellHighDelta' => $obj['sellHighDelta'],
            'sellHighDeltaExplanation' => "",
            'canSellLow' => $obj['canSellLow'],
            'sellLowDelta' => $obj['sellLowDelta'],
            'sellLowDeltaExplanation' => ""
        );
        if (array_key_exists('canSellHigh', $obj) && $obj['canSellHigh']) {

            $result['sellHighDeltaExplanation'] = $this->createExplanationFromGorgiasDelta($obj['sellHighDelta']);
        }
        if (array_key_exists('canSellLow', $obj) && $obj['canSellLow']) {
            $result['sellLowDeltaExplanation'] = $this->createExplanationFromGorgiasDelta($obj['sellLowDelta']);
        }
        return $result;
    }

    private function createExplanationFromGorgiasDelta($deltaArray)
    {
        if (in_array('p2', $deltaArray) && in_array('p3', $deltaArray)) {
            return $this->deltaExplanation['p2p3'];
        } else if (in_array('c2', $deltaArray) && in_array('c4', $deltaArray)) {
            return $this->deltaExplanation['c2c4'];
        } else if (in_array('p2', $deltaArray)) {
            return $this->deltaExplanation['p2'];
        } else if (in_array('p3', $deltaArray)) {
            return $this->deltaExplanation['p3'];
        } else if (in_array('c2', $deltaArray)) {
            return $this->deltaExplanation['c2'];
        } else if (in_array('c4', $deltaArray)) {
            return $this->deltaExplanation['c4'];
        } else if (in_array('r1', $deltaArray)) {
            return $this->deltaExplanation['r1'];
        }
    }

    public function executeGorgias($userMod, $noCook, $noDelivery, $noTakeway, $noOption, $moodToCook, $haveHw, $easyHw)
    {

        if ($userMod)
            echo "YES";
        else
            echo "NO";

        // Create prolog API object instance
        $prologApiInstance = new PrologControllerApi();

        // Configure HTTP basic authorization: basicAuth
        $prologApiInstance->getConfig()->setUsername("pchris08");
        $prologApiInstance->getConfig()->setPassword("X9ZYWZnSC6jr4dx");
        $prologApiInstance->getConfig()->setHost("http://aiasvm1.amcl.tuc.gr:8085");

        // Consult the  Gorgias policy file from the specific project:
        // consultFileUsingPOST("gorgias policy file", "project name")
//        if ($userMod)
//            $result = $prologApiInstance->consultFileUsingPOST("Del_Panikos_Gorgias_Food.pl", "project2_group1");
//        else
//            $result = $prologApiInstance->consultFileUsingPOST("Cook_Cristian_Gorgias_food.pl", "project2_group1");

        // We will use the fact list to retract the facts when we finish
        $factsList = array();

        // Create prolog query object instance
        $prologQueryObj = new QueryObj();

        // Configure  maximum number of answers and execution time
        $prologQueryObj->setResultSize(1);
        $prologQueryObj->setTime(1000);

        // Assert fact (Non-defeasible conditions)
        if ($noOption) {
            // Prepare fact string
            $fact = "pay_cash(" . $productId . "," . $customerId . ")";
            // Assert fact
            $prologQueryObj->setQuery('assert(' . $fact . ').');
            $result = $prologApiInstance->prologCommandUsingPOST($prologQueryObj);
            // Add fact to facts list
            $factsList[] = $fact;
        }

        // Assert fact (defeasible conditions)
        if ($regularCustomer) {
            // Prepare fact string
            $fact = "rule(f2,regular(" . $customerId . "),[])";
            // Assert fact
            $prologQueryObj->setQuery('assert(' . $fact . ').');
            $result = $prologApiInstance->prologCommandUsingPOST($prologQueryObj);
            // Add fact to facts list
            $factsList[] = $fact;
        }
        // Assert fact (defeasible conditions)
        if ($highSeason) {
            // Prepare fact string
            $fact = "rule(f3,high_season,[])";
            // Assert fact
            $prologQueryObj->setQuery('assert(' . $fact . ').');
            $result = $prologApiInstance->prologCommandUsingPOST($prologQueryObj);
            // Add fact to facts list
            $factsList[] = $fact;
        }
        // Assert fact (defeasible conditions)
        if ($lateDelivery) {
            // Prepare fact string
            $fact = "rule(f4,late_delivery(" . $customerId . "," . $productId . "),[])";
            // Assert fact
            $prologQueryObj->setQuery('assert(' . $fact . ').');
            $result = $prologApiInstance->prologCommandUsingPOST($prologQueryObj);
            // Add fact to facts list
            $factsList[] = $fact;
        }

        // Result array:
        $gorgiasResult = array(
            "canSellHigh" => false,
            "sellHighDelta" => array(),
            "canSellLow" => false,
            "sellLowDelta" => array()
        );

        // Prepare Gorgias query string
        $querySellHigh = "sell(" . $productId . "," . $customerId . ",high)";
        // Prepare prove command
        $gorgiasQuerySellHigh = "prove([" . $querySellHigh . "],Delta)";
        // Create query object instance
        $gorgiasQueryObj = new QueryObj();
        // Configure  Maximum number of answers
        $gorgiasQueryObj->setResultSize(1);
        // Configure execution time
        $gorgiasQueryObj->setTime(1000);
        // Set Gorgias query
        $gorgiasQueryObj->setQuery($gorgiasQuerySellHigh);
        // Execute Gorgias query on Gorgias cloud
        $response = $prologApiInstance->proveUsingPOST($gorgiasQueryObj);

        /*
         * If the response is an array and the array contains a string
         * in the format({Delta=[delta rules heads]} )
         * the answer of the query is true.
         */
        if (is_array($response)) {
            if (preg_match('/^{Delta=(\[.*\])}$/', $response[0], $matches)) {
                $gorgiasResult["canSellHigh"] = true;
                // parse the explanation (delta) string to a php array
                // parse from ["{Delta=[nott(d2(21, customer)), d2(21, customer), nott(c4(21, customer)), p1(21, customer), c4(21, customer), f3, r1(21, customer)]}"]
                // to ["d2","p1","c4","f3","r1"]
                $gorgiasResult["sellHighDelta"] = $this->parseDeltaToPHPArray($matches[1]);
            }
        }

        $querySellLow = "sell(" . $productId . "," . $customerId . ",low)";
        $gorgiasQuerySellLow = "prove([" . $querySellLow . "],Delta)";
        $gorgiasQueryObj->setQuery($gorgiasQuerySellLow);
        $response = $prologApiInstance->proveUsingPOST($gorgiasQueryObj);

        if (is_array($response)) {
            if (preg_match('/^{Delta=(\[.*\])}$/', $response[0], $matches)) {
                $gorgiasResult["canSellLow"] = true;
                $gorgiasResult["sellLowDelta"] = $this->parseDeltaToPHPArray($matches[1]);
            }
        }

        // When we finish we must unload the Gorgias file and retract all facts
        // unloadFileUsingPOST("your gorgias policy file, "your project name)

        $result = $prologApiInstance->unloadFileUsingPOST("seller.pl", "seller");

        // Retract all facts    

        foreach ($factsList as $fact) {
            $prologQueryObj->setQuery('retract(' . $fact . ').');
            $result = $prologApiInstance->prologCommandUsingPOST($prologQueryObj);
        }
        // We use the function generateResultArray to generate the explanation in natural language:

        return $this->generateResultArray($gorgiasResult);
    }

    /*
     * We use the  parseDeltaToPHPArray function to parse the string to a php array,
     * that contains explanation rules heads.
     * parse from ["{Delta=[nott(d2(21, customer)), d2(21, customer), nott(c4(21, customer)), p1(21, customer), c4(21, customer), f3, r1(21, customer)]}"]
     * to ["d2","p1","c4","f3","r1"]
     */
    public function parseDeltaToPHPArray($delta)
    {
        $listToJsonFile = file_get_contents('listToJson.pl');
        $parseDeltaTemp = tempnam("", "prd");
        $handleStoryFile = fopen($parseDeltaTemp, "w");
        fwrite($handleStoryFile, $listToJsonFile . PHP_EOL);
        fwrite($handleStoryFile, 'delta(' . $delta . ').' . PHP_EOL);
        fclose($handleStoryFile);

        $command = "swipl -f " . $parseDeltaTemp . " -g " . escapeshellarg("listToJson") . " -t halt";

        $output = shell_exec(escapeshellcmd($command));
        unlink($parseDeltaTemp);
        $deltaBeforeParsing = json_decode($output);
        $deltaArray = array();
        foreach ($deltaBeforeParsing->{'Delta'} as $deltaTerm) {
            if (preg_match('/^ass\(.*\)$/', $deltaTerm, $matches)) {
                $deltaArray[] = $deltaTerm;
            } else if (!preg_match('/^nott\(.*\)$/', $deltaTerm, $matches)) {
                $ruleHead = explode('(', $deltaTerm)[0];
                $deltaArray[] = $ruleHead;
            }
        }
        return $deltaArray;
    }
}

?>
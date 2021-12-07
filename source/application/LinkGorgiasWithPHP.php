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
        // Create prolog API object instance
        $prologApiInstance = new PrologControllerApi();

        // Configure HTTP basic authorization: basicAuth
        $prologApiInstance->getConfig()->setUsername("pchris08");
        $prologApiInstance->getConfig()->setPassword("X9ZYWZnSC6jr4dx");
        $prologApiInstance->getConfig()->setHost("http://aiasvm1.amcl.tuc.gr:8085");

        // Consult the  Gorgias policy file from the specific project:
        // consultFileUsingPOST("gorgias policy file", "project name")
        if ($userMod)
            $result = $prologApiInstance->consultFileUsingPOST("Del_Panikos_Gorgias_Food.pl", "project2_group1");
        else
            $result = $prologApiInstance->consultFileUsingPOST("Cook_Cristian_Gorgias_food.pl", "project2_group1");

        $factsList = array();
        $prologQueryObj = new QueryObj();
        $prologQueryObj->setResultSize(1);
        $prologQueryObj->setTime(1000);

        // Assert fact (non-defeasible conditions)
        if ($noOption) {
            $fact = "noOptions";
            $prologQueryObj->setQuery('assert(' . $fact . ').');
            $result = $prologApiInstance->prologCommandUsingPOST($prologQueryObj);
            $factsList[] = $fact;
        }
        // Assert fact (defeasible conditions)
        if ($noCook) {
            $fact = "noCook";
            $prologQueryObj->setQuery('assert(' . $fact . ').');
            $result = $prologApiInstance->prologCommandUsingPOST($prologQueryObj);
            $factsList[] = $fact;
        }
        // Assert fact (defeasible conditions)
        if ($noDelivery) {
            $fact = "noDelivery";
            $prologQueryObj->setQuery('assert(' . $fact . ').');
            $result = $prologApiInstance->prologCommandUsingPOST($prologQueryObj);
            $factsList[] = $fact;
        }
        // Assert fact (defeasible conditions)
        if ($noTakeway) {
            $fact = "noTakeaway";
            $prologQueryObj->setQuery('assert(' . $fact . ').');
            $result = $prologApiInstance->prologCommandUsingPOST($prologQueryObj);
            $factsList[] = $fact;
        }
        // Assert fact (defeasible conditions)
        if ($moodToCook) {
            $fact = "moodToCook";
            $prologQueryObj->setQuery('assert(' . $fact . ').');
            $result = $prologApiInstance->prologCommandUsingPOST($prologQueryObj);
            $factsList[] = $fact;
        }
        // Assert fact (defeasible conditions)
        if ($haveHw) {
            $fact = "moodToCook";
            $prologQueryObj->setQuery('assert(' . $fact . ').');
            $result = $prologApiInstance->prologCommandUsingPOST($prologQueryObj);
            $factsList[] = $fact;
        }
        // Assert fact (defeasible conditions)
        if ($easyHw) {
            $fact = "easyHw";
            $prologQueryObj->setQuery('assert(' . $fact . ').');
            $result = $prologApiInstance->prologCommandUsingPOST($prologQueryObj);
            $factsList[] = $fact;
        }

        // Result array:
        $gorgiasResult = array(
            "delivery" => false,
            "deliveryDelta" => array(),
            "cook" => false,
            "cookDelta" => array(),
            "takeaway" => false,
            "takeawayDelta" => array()
        );

        $gorgiasQueryObj = new QueryObj();
        $gorgiasQueryObj->setResultSize(1);
        $gorgiasQueryObj->setTime(1000);

        // Prepare Gorgias query for delivery proving
        $queryTakeaway = "delivery(m)";
        $gorgiasQueryTakeaway = "prove([" . $queryTakeaway . "],Delta)";
        $gorgiasQueryObj->setQuery($gorgiasQueryTakeaway);
        $response = $prologApiInstance->proveUsingPOST($gorgiasQueryObj);

        if (is_array($response)) {
            if (preg_match('/^{Delta=(\[.*\])}$/', $response[0], $matches)) {
                $gorgiasResult["delivery"] = true;
                $gorgiasResult["deliveryDelta"] = $this->parseDeltaToPHPArray($matches[1]);
            }
        }

        // Prepare Gorgias query for cooking proving
        $queryCooking = "cook(m)";
        $gorgiasQueryCooking = "prove([" . $queryCooking . "],Delta)";
        $gorgiasQueryObj->setQuery($gorgiasQueryCooking);
        $response = $prologApiInstance->proveUsingPOST($gorgiasQueryObj);

        if (is_array($response)) {
            if (preg_match('/^{Delta=(\[.*\])}$/', $response[0], $matches)) {
                $gorgiasResult["cook"] = true;
                $gorgiasResult["cookDelta"] = $this->parseDeltaToPHPArray($matches[1]);
            }
        }

        // Prepare Gorgias query for takeaway proving
        $queryTakeaway = "takeaway(m)";
        $gorgiasQueryTakeaway = "prove([" . $queryTakeaway . "],Delta)";
        $gorgiasQueryObj->setQuery($gorgiasQueryTakeaway);
        $response = $prologApiInstance->proveUsingPOST($gorgiasQueryObj);

        if (is_array($response)) {
            if (preg_match('/^{Delta=(\[.*\])}$/', $response[0], $matches)) {
                $gorgiasResult["takeaway"] = true;
                $gorgiasResult["takeawayDelta"] = $this->parseDeltaToPHPArray($matches[1]);
            }
        }

        // When we finish we must unload the Gorgias file and retract all facts
        // unloadFileUsingPOST("your gorgias policy file, "your project name)

        if ($userMod)
            $result = $prologApiInstance->unloadFileUsingPOST("Del_Panikos_Gorgias_Food.pl", "project2_group1");
        else
            $result = $prologApiInstance->unloadFileUsingPOST("Cook_Cristian_Gorgias_food.pl", "project2_group1");

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
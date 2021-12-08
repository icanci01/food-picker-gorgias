<?php
require_once('./lib/SwaggerClient-php/vendor/autoload.php');

use Swagger\Client\Api\PrologControllerApi as PrologControllerApi;
use Swagger\Client\Model\QueryObj as QueryObj;

class LinkGorgiasWithPHP
{

    private $deltaExplanation;

    public function __construct()
    {
        $this->deltaExplanation = array();

        // First level preference
        $this->deltaExplanation['emptyMethodRuleCook'] = 'Normally, I prefer <u><b>cooking</b><u> my food!';
        $this->deltaExplanation['emptyMethodRuleTake'] = 'Normally, I prefer ordering <u><b>takeaway</b><u>!';
        $this->deltaExplanation['emptyMethodRuleDel'] = 'Normally, I prefer ordering <u><b>delivery</b><u>!';

        // Second layer of preferences, (COOK : TAKEAWAY : DELIVERY)
        $this->deltaExplanation['cookThanTakeEmptyRule'] = 'Normally, I prefer <u><b>cooking</b><u> than ordering <b>takeaway</b>!';
        $this->deltaExplanation['cookThanDelEmptyRule'] = 'Normally, I prefer <u><b>cooking</b><u> than ordering <b>delivery</b>!';
        $this->deltaExplanation['takeThanDelEmptyRule'] = 'Normally, I prefer ordering <u><b>takeaway</b><u> than ordering <b>delivery</b>!';

        // Preference based on (moodToCook/1)
        $this->deltaExplanation['preferMoodToCook1'] = 'Normally, I prefer <b>cooking</b> and since i am <b>in the mood to cook<b> I will <u><b>cook</b><u>!';
        $this->deltaExplanation['preferMoodToCook2'] = 'Normally, I prefer ordering <b>takeaway</b> however, since i am <b>in the mood to cook<b> I will <u><b>cook</b><u>!';
        $this->deltaExplanation['preferMoodToCook3'] = 'Normally, I prefer ordering <b>delivery</b> however, since i am <b>in the mood to cook<b> I will <u><b>cook</b><u>!';

        // Preference based on (haveHw/1)
        $this->deltaExplanation['preferHaveHwRuleDel1'] = 'Normally, I prefer <b>cooking</b> and since I <b>have homework<b> I should order <u><b>delivery</b><u>!';
        $this->deltaExplanation['preferHaveHwRuleDel2'] = 'Normally, I prefer ordering <b>takeaway</b> however, since I <b>have homework<b> I will order <u><b>delivery</b><u>!';
        $this->deltaExplanation['preferHaveHwRuleDel3'] = 'Normally, I prefer ordering <b>delivery</b> however, since I <b>have homework<b> I will order <u><b>delivery</b><u>!';
        $this->deltaExplanation['preferHaveHwRuleTake1'] = 'Normally, I prefer <b>cooking</b> and since I <b>have homework<b> I should order <u><b>takeaway</b><u>!';
        $this->deltaExplanation['preferHaveHwRuleTake2'] = 'Normally, I prefer ordering <b>takeaway</b> however, since I <b>have homework<b> I will order <u><b>takeaway</b><u>!';
        $this->deltaExplanation['preferHaveHwRuleTake3'] = 'Normally, I prefer ordering <b>delivery</b> however, since I <b>have homework<b> I will order <u><b>takeaway</b><u>!';

        //-- Preference based on (haveHw/1. prefersCooking. / first order priority)
        $this->deltaExplanation['preferHaveHwRule1'] = 'Normally, I prefer <b>cooking</b> and since I <b>have homework<b> I will order <u><b>delivery</b><u>!';

        // Preference based on (haveHw/1. moodToCook/1 )
        $this->deltaExplanation['preferHaveHwMoodRuleDel1'] = 'Normally, I prefer <b>cooking</b> but I <b>have homework<b>, I will order <u><b>delivery</b><u>, even if I am <b>in the mood to cook</b>!';
        $this->deltaExplanation['preferHaveHwMoodRuleDel2'] = 'Normally, I prefer <b>cooking</b> but I <b>have homework<b>, I will order <u><b>delivery</b><u>, even if I am <b>in the mood to cook</b>!';
        $this->deltaExplanation['preferHaveHwMoodRuleDel3'] = 'Normally, I prefer <b>cooking</b> but I <b>have homework<b>, I will order <u><b>delivery</b><u>, even if I am <b>in the mood to cook</b>!';

        $this->deltaExplanation['preferHaveHwMoodRuleTake1'] = 'Normally, I prefer <b>cooking</b> but I <b>have homework<b> I will order <u><b>takeaway</b><u>, even if I am <b>in the mood to cook</b>!';
        $this->deltaExplanation['preferHaveHwMoodRuleTake2'] = 'Normally, I prefer <b>cooking</b> but I <b>have homework<b> I will order <u><b>takeaway</b><u>, even if I am <b>in the mood to cook</b>!';
        $this->deltaExplanation['preferHaveHwMoodRuleTake3'] = 'Normally, I prefer <b>cooking</b> but I <b>have homework<b> I will order <u><b>takeaway</b><u>, even if I am <b>in the mood to cook</b>!';

        //-- Preference based on (haveHw/1. moodToCook/1. prefersCooking. / first order priority)
        $this->deltaExplanation['preferHaveHwMoodRuleDelW'] = 'Normally, I prefer <b>cooking</b> and since I <b>have homework<b> I will order <u><b>delivery</b><u>, even if I am <b>in the mood to cook</b>,!';

        // Preference based on (haveHw/1. easyHw/1.)
        $this->deltaExplanation['preferHaveEzHwMoodToCookRuleDel'] = 'Normally, I prefer <b>cooking</b> and since I <b>have homework<b> and it is an <b>easy homework</b>, I will <u><b>cook</b><u>!';
        $this->deltaExplanation['preferHaveEzHwMoodToCookRuleTake'] = 'Normally, I prefer <b>cooking</b> and since I <b>have homework<b> and it is an <b>easy homework</b>, I will <u><b>cook</b><u>!';

        // Preference based on (noDelivery/1.)
        $this->deltaExplanation['preferNoDelivery1'] = 'Normally, I prefer <b>cooking</b> and I will <u><b>cook</b><u>, since I can not order <b>delivery</b>!';
        $this->deltaExplanation['preferNoDelivery2'] = 'Normally, I prefer <b>cooking</b> and since I <b>have homework</b> and since I can not order <b>delivery</b>, I will <u><b>cook</b><u>!';
        $this->deltaExplanation['preferNoDelivery3'] = 'Normally, I prefer <b>cooking</b> and since I <b>have homework</b> and I am <b>in the mood to cook<b> and since I can not order <b>delivery</b>,, I will <u><b>cook</b><u>!';

        // Preference based on (noCook/1.)
        $this->deltaExplanation['preferNoCook1'] = 'Normally, I prefer <b>cooking</b> and I will order <u><b>takeaway</b><u>, since I can not <b>cook</b>!';
        $this->deltaExplanation['preferNoCook2'] = 'Normally, I prefer <b>cooking</b> and since I <b>have homework</b> but since I can not <b>cook</b>, I will order<u><b>takeaway</b><u>, even if I am in the <b>mood to cook</b>!';
        $this->deltaExplanation['preferNoCook3'] = 'Normally, I prefer <b>cooking</b> and since I <b>have easy homework</b> but since I can not <b>cook</b>, I will order<u><b>takeaway</b><u>!';

        // Preference based on (noTakeaway/1.)
        $this->deltaExplanation['preferNoTakeawayRule1'] = 'Normally, I prefer <b>cooking</b> and I will <u><b>cook</b><u>, since I can not order <b>takeaway</b>!';
        $this->deltaExplanation['preferNoTakeawayRule2'] = 'Normally, I prefer <b>cooking</b> but since I <b>have homework</b> and since I can not order <b>takeaway</b>, I will order<u><b>delivery</b><u>!';
        $this->deltaExplanation['preferNoTakeawayRule3'] = 'Normally, I prefer <b>cooking</b> but since I <b>have easy homework</b> and since I can not order <b>takeaway</b>, I will order <u><b>delivery</b><u>!';
        $this->deltaExplanation['preferNoTakeawayRule4'] = 'Normally, I prefer <b>cooking</b> but since I am <b>in the mood to cook<b> and since I can not order <b>delivery</b>, I will <u><b>cook</b><u>!';

        // Preference based on (noOptions/1.)
        $this->deltaExplanation['preferNoOptions1'] = 'Normally, I prefer <b>cooking</b> and I will <u><b>cook</b><u>, since I have <b>no options</b> left!';
    }

    private function generateResultArray($obj)
    {
        $result = array(
            'delivery' => $obj['delivery'],
            'deliveryDelta' => $obj['deliveryDelta'],
            'deliveryDeltaExplanation' => "",
            'cook' => $obj['cook'],
            'cookDelta' => $obj['cookDelta'],
            'cookDeltaExplanation' => "",
            'takeaway' => $obj['takeaway'],
            'takeawayDelta' => $obj['takeawayDelta'],
            'takeawayDeltaExplanation' => "",
        );
        if (array_key_exists('delivery', $obj) && $obj['delivery']) {
            $result['deliveryDeltaExplanation'] = $this->createExplanationFromGorgiasDelta($obj['deliveryDelta']);
        }
        if (array_key_exists('cook', $obj) && $obj['cook']) {
            $result['cookDeltaExplanation'] = $this->createExplanationFromGorgiasDelta($obj['cookDelta']);
        }
        if (array_key_exists('takeaway', $obj) && $obj['takeaway']) {
            $result['takeawayDeltaExplanation'] = $this->createExplanationFromGorgiasDelta($obj['takeawayDelta']);
        }
        return $result;
    }

    private function createExplanationFromGorgiasDelta($deltaArray)
    {
        if (in_array('emptyMethodRuleCook', $deltaArray)) {
            return $this->deltaExplanation['emptyMethodRuleCook'];
        } else if (in_array('emptyMethodRuleTake', $deltaArray)) {
            return $this->deltaExplanation['emptyMethodRuleTake'];
        } else if (in_array('emptyMethodRuleDel', $deltaArray)) {
            return $this->deltaExplanation['emptyMethodRuleDel'];
        } else if (in_array('cookThanTakeEmptyRule', $deltaArray)) {
            return $this->deltaExplanation['cookThanTakeEmptyRule'];
        } else if (in_array('cookThanDelEmptyRule', $deltaArray)) {
            return $this->deltaExplanation['cookThanDelEmptyRule'];
        } else if (in_array('takeThanDelEmptyRule', $deltaArray)) {
            return $this->deltaExplanation['takeThanDelEmptyRule'];
        } else if (in_array('preferMoodToCook1', $deltaArray)) {
            return $this->deltaExplanation['preferMoodToCook1'];
        } else if (in_array('preferMoodToCook2', $deltaArray)) {
            return $this->deltaExplanation['preferMoodToCook2'];
        } else if (in_array('preferMoodToCook3', $deltaArray)) {
            return $this->deltaExplanation['preferMoodToCook3'];
        } else if (in_array('preferHaveHwRuleDel1', $deltaArray)) {
            return $this->deltaExplanation['preferHaveHwRuleDel1'];
        } else if (in_array('preferHaveHwRuleDel2', $deltaArray)) {
            return $this->deltaExplanation['preferHaveHwRuleDel2'];
        } else if (in_array('preferHaveHwRuleDel3', $deltaArray)) {
            return $this->deltaExplanation['preferHaveHwRuleDel3'];
        } else if (in_array('preferHaveHwRuleTake1', $deltaArray)) {
            return $this->deltaExplanation['preferHaveHwRuleTake1'];
        } else if (in_array('preferHaveHwRuleTake2', $deltaArray)) {
            return $this->deltaExplanation['preferHaveHwRuleTake2'];
        } else if (in_array('preferHaveHwRuleTake3', $deltaArray)) {
            return $this->deltaExplanation['preferHaveHwRuleTake3'];
        } else if (in_array('preferHaveHwRule1', $deltaArray)) {
            return $this->deltaExplanation['preferHaveHwRule1'];
        } else if (in_array('preferHaveHwMoodRuleDel1', $deltaArray)) {
            return $this->deltaExplanation['preferHaveHwMoodRuleDel1'];
        } else if (in_array('preferHaveHwMoodRuleDel2', $deltaArray)) {
            return $this->deltaExplanation['preferHaveHwMoodRuleDel2'];
        } else if (in_array('preferHaveHwMoodRuleDel3', $deltaArray)) {
            return $this->deltaExplanation['preferHaveHwMoodRuleDel3'];
        } else if (in_array('preferHaveHwMoodRuleTake1', $deltaArray)) {
            return $this->deltaExplanation['preferHaveHwMoodRuleTake1'];
        } else if (in_array('preferHaveHwMoodRuleTake2', $deltaArray)) {
            return $this->deltaExplanation['preferHaveHwMoodRuleTake2'];
        } else if (in_array('preferHaveHwMoodRuleTake3', $deltaArray)) {
            return $this->deltaExplanation['preferHaveHwMoodRuleTake3'];
        } else if (in_array('preferHaveHwMoodRuleDelW', $deltaArray)) {
            return $this->deltaExplanation['preferHaveHwMoodRuleDelW'];
        } else if (in_array('preferHaveEzHwMoodToCookRuleDel', $deltaArray)) {
            return $this->deltaExplanation['preferHaveEzHwMoodToCookRuleDel'];
        } else if (in_array('preferHaveEzHwMoodToCookRuleTake', $deltaArray)) {
            return $this->deltaExplanation['preferHaveEzHwMoodToCookRuleTake'];
        } else if (in_array('preferNoDelivery1', $deltaArray)) {
            return $this->deltaExplanation['preferNoDelivery1'];
        } else if (in_array('preferNoDelivery2', $deltaArray)) {
            return $this->deltaExplanation['preferNoDelivery2'];
        } else if (in_array('preferNoDelivery3', $deltaArray)) {
            return $this->deltaExplanation['preferNoDelivery3'];
        } else if (in_array('preferNoCook1', $deltaArray)) {
            return $this->deltaExplanation['preferNoCook1'];
        } else if (in_array('preferNoCook2', $deltaArray)) {
            return $this->deltaExplanation['preferNoCook2'];
        } else if (in_array('preferNoCook3', $deltaArray)) {
            return $this->deltaExplanation['preferNoCook3'];
        } else if (in_array('preferNoTakeawayRule1', $deltaArray)) {
            return $this->deltaExplanation['preferNoTakeawayRule1'];
        } else if (in_array('preferNoTakeawayRule2', $deltaArray)) {
            return $this->deltaExplanation['preferNoTakeawayRule2'];
        } else if (in_array('preferNoTakeawayRule3', $deltaArray)) {
            return $this->deltaExplanation['preferNoTakeawayRule3'];
        } else if (in_array('preferNoTakeawayRule4', $deltaArray)) {
            return $this->deltaExplanation['preferNoTakeawayRule4'];
        } else if (in_array('preferNoOptions1', $deltaArray) && in_array('preferNoOptions2', $deltaArray) && in_array('preferNoOptions3', $deltaArray)) {
            return $this->deltaExplanation['preferNoOptions'];
        }
    }

    public function executeGorgias($userMod, $noCook, $noDelivery, $noTakeway, $noOption, $moodToCook, $haveHw, $easyHw)
    {

        echo "<p>User Selected:&nbsp;";
        if ($userMod)
            echo nl2br("<b>PANIKOS</b></p>\n ");
        else
            echo nl2br("<b>CRISTIAN</b></p>\n");

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
        $queryDelivery = "delivery(m)";
        $gorgiasQueryDelivery = "prove([" . $queryDelivery . "],Delta)";
        $gorgiasQueryObj->setQuery($gorgiasQueryDelivery);
        $response = $prologApiInstance->proveUsingPOST($gorgiasQueryObj);

        if (is_array($response)) {
            if (preg_match('/^{Delta=(\[.*\])}$/', $response[0], $matches)) {
                $gorgiasResult["delivery"] = true;
                $gorgiasResult["deliveryDelta"] = $this->parseDeltaToPHPArray($matches[1]);
            }
        }

//        // Prepare Gorgias query for cooking proving
//        $queryCooking = "cook(m)";
//        $gorgiasQueryCooking = "prove([" . $queryCooking . "],Delta)";
//        $gorgiasQueryObj->setQuery($gorgiasQueryCooking);
//        $response = $prologApiInstance->proveUsingPOST($gorgiasQueryObj);
//
//        if (is_array($response)) {
//            if (preg_match('/^{Delta=(\[.*\])}$/', $response[0], $matches)) {
//                $gorgiasResult["cook"] = true;
//                $gorgiasResult["cookDelta"] = $this->parseDeltaToPHPArray($matches[1]);
//            }
//        }
//
//        // Prepare Gorgias query for takeaway proving
//        $queryTakeaway = "takeaway(m)";
//        $gorgiasQueryTakeaway = "prove([" . $queryTakeaway . "],Delta)";
//        $gorgiasQueryObj->setQuery($gorgiasQueryTakeaway);
//        $response = $prologApiInstance->proveUsingPOST($gorgiasQueryObj);
//
//        if (is_array($response)) {
//            if (preg_match('/^{Delta=(\[.*\])}$/', $response[0], $matches)) {
//                $gorgiasResult["takeaway"] = true;
//                $gorgiasResult["takeawayDelta"] = $this->parseDeltaToPHPArray($matches[1]);
//            }
//        }

        foreach ($factsList as $fact_temp) {
            echo nl2br($fact_temp . "\n");
        }

        // Retract all facts
        foreach ($factsList as $fact) {
            $prologQueryObj->setQuery('retract(' . $fact . ').');
            $result = $prologApiInstance->prologCommandUsingPOST($prologQueryObj);
        }

        // When we finish we must unload the Gorgias file and retract all facts
        // unloadFileUsingPOST("your gorgias policy file, "your project name)
        if ($userMod)
            $result = $prologApiInstance->unloadFileUsingPOST("Del_Panikos_Gorgias_Food.pl", "project2_group1");
        else
            $result = $prologApiInstance->unloadFileUsingPOST("Cook_Cristian_Gorgias_food.pl", "project2_group1");

        // We use the function generateResultArray to generate the explanation in natural language:
        return $this->generateResultArray($gorgiasResult);
    }

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
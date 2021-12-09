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
        $this->deltaExplanation['emptyMethodRuleCook'] = 'Normally, I prefer <u><b>cooking</b></u> my food!';
        $this->deltaExplanation['emptyMethodRuleDel'] = 'Normally, I prefer ordering <u><b>delivery</b></u>!';
        $this->deltaExplanation['emptyMethodRuleTake'] = 'Normally, I prefer ordering <u><b>takeaway</b></u>!';

        // Cristian Scenarios preferences
        $this->deltaExplanation['preferCookingNoOption'] = 'Normally, I prefer <b>cooking</b>, and I will <u><b>cook</b></u> since I have no other option!';
        $this->deltaExplanation['preferCookingNoCook'] = 'Normally, I prefer <b>cooking</b>, and I will order <u><b>takeaway</b></u> since I can not <b>cook</b>!';
        $this->deltaExplanation['preferCookingEzHw'] = 'Normally, I prefer <b>cooking</b>, and I will <u><b>cook</b></u> since I have an <b>easy homework</b>!';
        $this->deltaExplanation['preferCookingHaveHw'] = 'Normally, I prefer <b>cooking</b>, but I will order <u><b>takeaway</b></u> since I have <b>homework</b>!';
        $this->deltaExplanation['preferCookingNoCookNoTakeaway'] = 'Normally, I prefer <b>cooking</b> and then <b>takeaway</b>, but I will order <u><b>delivery</b></u> since I can not <b>cook</b> or order <b>takeaway</b>!';
        $this->deltaExplanation['preferCookingMoodToCookHaveHw'] = 'Normally, I prefer <b>cooking</b> and then <b>takeaway</b>. Even if I am <b>in the mood to cook</b>, I will order <u><b>takeaway</b></u> since I <b>have homework</b>!';
        $this->deltaExplanation['preferCookingMoodToCookNoCook'] = 'Normally, I prefer <b>cooking</b> and then <b>takeaway</b>. I will order <u><b>takeaway</b></u> since I can not <b>cook</b>!';
        $this->deltaExplanation['preferCookingMoodToCookNoCookNoTakeaway'] = 'Normally, I prefer <b>cooking</b> and then <b>takeaway</b>. Even if I am <b>in the mood to cook</b>, I will order <u><b>delivery</b></u> since I can not <b>cook</b> or order <b>takeaway</b>!';
        $this->deltaExplanation['preferCookingMoodToCookNoCookNoTakeawayHaveHw'] = 'Normally, I prefer <b>cooking</b> and then <b>takeaway</b>. Even if I am <b>in the mood to cook</b>, I will order <u><b>delivery</b></u> since I <b>have homework</b> and I can not <b>cook</b> or order <b>takeaway</b>!';

        // Panikos Scenarios preferences
        $this->deltaExplanation['preferDeliveryMoodToCookNoCookHaveHw'] = 'Normally, I prefer <b>delivery</b> and then <b>takeaway</b>. Even if I am <b>in the mood to cook</b>, I will order <u><b>delivery</b></u> since I <b>have homework</b> and I can not <b>cook</b>!';
        $this->deltaExplanation['preferDeliveryMoodToCookNoCookNoTakeawayHaveHw'] = 'Normally, I prefer <b>delivery</b> and then <b>takeaway</b>. Even if I am <b>in the mood to cook</b>, I will order <u><b>delivery</b></u> since I <b>have homework</b> and I can not <b>cook</b> or order <b>takeaway</b>!';
        $this->deltaExplanation['preferDeliverMoodToCookNoCook'] = 'Normally, I prefer <b>delivery</b> and then <b>takeaway</b>. Even if I am <b>in the mood to cook</b>, I will order <u><b>delivery</b></u> since I can not <b>cook</b>!';
        $this->deltaExplanation['preferDeliverHaveHw'] = 'Normally, I prefer <b>delivery</b> and then <b>takeaway</b> and I will order <u><b>delivery</b></u> since I <b>have homework</b>!';
        $this->deltaExplanation['preferDeliverMoodToCookHaveHw'] = 'Normally, I prefer <b>delivery</b> and then <b>takeaway</b>. Even if I am <b>in the mood to cook</b>, I will order <u><b>delivery</b></u> since I <b>have homework</b>!';
        $this->deltaExplanation['preferDeliveryNoDelivery'] = 'Normally, I prefer <b>delivery</b> and then <b>takeaway</b>. Since I can not order <b>delivery</b>, I will order <u><b>takeaway</b></u>!';
        $this->deltaExplanation['preferDeliveryNoOption'] = 'Normally, I prefer <b>delivery</b> and then <b>takeaway</b>. However, I will <u><b>cook</b></u> since I have no other option!';
        $this->deltaExplanation['preferDeliverMoodToCook'] = 'Normally, I prefer <b>delivery</b> and then <b>takeaway</b>. However, I will <u><b>cook</b></u> since I am <b>in the mood to cook</b>!';
        $this->deltaExplanation['preferDeliveryNoDeliveryNoTakeaway'] = 'Normally, I prefer <b>delivery</b> and then <b>takeaway</b>. However, I will <u><b>cook</b></u> since can not order <b>delivery</b> or <b>takeaway</b>!';
        $this->deltaExplanation['preferCookingMoodToCookHaveHwEzHw'] = 'Normally, I prefer <b>delivery</b> and then <b>takeaway</b>. However, I will <u><b>cook</b></u> since I am <b>in the mood to cook</b> and I am assigned an <b>easy homework</b>!';

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
        // emptyMethodRuleCook
        if (in_array('emptyMethodRuleCook', $deltaArray)) {
            if (in_array('noOptions', $deltaArray) && in_array('preferNoOptions2', $deltaArray))
                if (in_array('noTakeawayRule', $deltaArray) && in_array('preferNoTakeawayRule1', $deltaArray)&& in_array('noDelivery', $deltaArray)&& in_array('preferNoDelivery1', $deltaArray))
                    return $this->deltaExplanation['preferDeliveryNoOption'];
                else
                    return $this->deltaExplanation['preferCookingNoOption'];
            else if (in_array('preferHaveEzHwMoodToCookRuleTake', $deltaArray) && in_array('haveEzHwRule', $deltaArray) && in_array('preferHaveEzHwMoodToCookRuleDel', $deltaArray))
                return $this->deltaExplanation['preferCookingEzHw'];
            else if (in_array('preferMoodToCook2', $deltaArray) && in_array('moodToCookRule', $deltaArray)&& in_array('preferMoodToCook1', $deltaArray))
                return $this->deltaExplanation['preferDeliverMoodToCook'];
            else if (in_array('noTakeawayRule', $deltaArray) && in_array('preferNoTakeawayRule1', $deltaArray)&& in_array('noDelivery', $deltaArray)&& in_array('preferNoDelivery1', $deltaArray))
                return $this->deltaExplanation['preferDeliveryNoDeliveryNoTakeaway'];
            else
                return $this->deltaExplanation['emptyMethodRuleCook'];
        } // emptyMethodRuleDel
        else if (in_array('emptyMethodRuleDel', $deltaArray)) {
            if (in_array('noTakeawayRule', $deltaArray) && in_array('preferNoTakeawayRule1', $deltaArray) && in_array('noCook', $deltaArray) && in_array('preferNoCook1', $deltaArray))
                if (in_array('preferNoCook2', $deltaArray))
                    return $this->deltaExplanation['preferCookingMoodToCookNoCookNoTakeaway'];
                else
                    return $this->deltaExplanation['preferCookingNoCookNoTakeaway'];
            else if (in_array('preferHaveHwRuleDel2', $deltaArray) && in_array('preferHaveHwMoodRuleDel3', $deltaArray) && in_array('noTakeawayRule', $deltaArray) && in_array('preferNoTakeawayRule3', $deltaArray) && in_array('haveHwMoodRuleDel', $deltaArray) && in_array('preferHaveHwMoodRuleDel2', $deltaArray) && in_array('haveHwRuleDel', $deltaArray) && in_array('preferHaveHwRuleDel3', $deltaArray))
                return $this->deltaExplanation['preferCookingMoodToCookNoCookNoTakeawayHaveHw'];
            else if (in_array('noCook', $deltaArray) && in_array('preferNoCook2', $deltaArray))
                if (in_array('noTakeawayRule', $deltaArray) && in_array('preferNoTakeawayRule2', $deltaArray))
                    return $this->deltaExplanation['preferDeliveryMoodToCookNoCookNoTakeawayHaveHw'];
                else if (in_array('haveHwMoodRuleDel', $deltaArray) && in_array('preferHaveHwMoodRule2', $deltaArray) && in_array('haveHwRuleDel', $deltaArray) && in_array('preferHaveHwRule', $deltaArray))
                    return $this->deltaExplanation['preferDeliveryMoodToCookNoCookHaveHw'];
                else
                    return $this->deltaExplanation['preferDeliverMoodToCookNoCook'];
            else if (in_array('haveHwRuleDel', $deltaArray) && in_array('preferHaveHwRule', $deltaArray))
                if (in_array('haveHwMoodRuleDel', $deltaArray) && in_array('preferHaveHwMoodRule2', $deltaArray) && in_array('preferHaveHwMoodRuleDel3', $deltaArray))
                    return $this->deltaExplanation['preferDeliverMoodToCookHaveHw'];
                else
                    return $this->deltaExplanation['preferDeliverHaveHw'];
            else
                return $this->deltaExplanation['emptyMethodRuleDel'];
        } // emptyMethodRuleTake
        else if (in_array('emptyMethodRuleTake', $deltaArray)) {
            if (in_array('noCook', $deltaArray) && in_array('preferNoCook1', $deltaArray))
                if (in_array('preferNoCook2', $deltaArray))
                    return $this->deltaExplanation['preferCookingMoodToCookNoCook'];
                else
                    return $this->deltaExplanation['preferCookingNoCook'];
            else if (in_array('preferHaveHwRuleTake3', $deltaArray) && in_array('haveHwRuleTake', $deltaArray) && in_array('preferHaveHwRule2', $deltaArray))
                if (in_array('preferHaveHwMoodRuleTake3', $deltaArray) && in_array('preferHaveHwMoodRuleTake3', $deltaArray) && in_array('preferHaveHwMoodRuleTake4', $deltaArray))
                    return $this->deltaExplanation['preferCookingMoodToCookHaveHw'];
                else
                    return $this->deltaExplanation['preferCookingHaveHw'];
            else if (in_array('noDelivery', $deltaArray) && in_array('preferNoDelivery1', $deltaArray))
                return $this->deltaExplanation['preferDeliveryNoDelivery'];
            else
                return $this->deltaExplanation['emptyMethodRuleTake'];
        }
        // moodToCook last option Panikos
        else if (in_array('preferHaveEzHwMoodToCookRuleTake', $deltaArray) && in_array('haveEzHwMoodToCookRule', $deltaArray) && in_array('preferHaveEzHwMoodToCookRuleDel', $deltaArray)&& in_array('moodToCookRule', $deltaArray))
            return $this->deltaExplanation['preferCookingMoodToCookHaveHwEzHw'];
    }

    public function executeGorgias($userMod, $noCook, $noDelivery, $noTakeway, $moodToCook, $haveHw, $easyHw)
    {

        echo "<p>User Selected:&nbsp;";
        if ($userMod)
            echo nl2br("<b>PANIKOS</b></p>");
        else
            echo nl2br("<b>CRISTIAN</b></p>");

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
            $result = $prologApiInstance->consultFileUsingPOST("Cook_Cristian_Gorgias_Food.pl", "project2_group1");

        $factsList = array();
        $prologQueryObj = new QueryObj();
        $prologQueryObj->setResultSize(1);
        $prologQueryObj->setTime(1000);

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
            $fact = "haveHw";
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
            $result = $prologApiInstance->unloadFileUsingPOST("Cook_Cristian_Gorgias_Food.pl", "project2_group1");

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
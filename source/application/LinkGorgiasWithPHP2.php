<?php
require_once ('./SwaggerClient-php/vendor/autoload.php');
use Swagger\Client\Api\PrologControllerApi as PrologControllerApi;
use Swagger\Client\Model\QueryObj as QueryObj;

class LinkGorgiasWithPHP2
{

    private $deltaExplanation;

    public function __construct()
    {
        $this->deltaExplanation = array();
        $this->deltaExplanation['Noexplanation'] = 'Normally, heating is <u>off</u> and home alarm is <u>on</u>';
        $this->deltaExplanation['r1r2'] = 'Normally, heating is <u>off</u> and home alarm is <u>on</u>';
        $this->deltaExplanation['r2r1'] = 'Normally, heating is <u>off</u> and home alarm is <u>on</u>';

        $this->deltaExplanation['r3r4'] = 'Normally, heating is off and home alarm is on, but because user is <b>at home</b>, heating is <u>on</u> and home alarm is <u>off</u>';
        $this->deltaExplanation['r4r3'] = 'Normally, heating is off and home alarm is on, but because user is <b>at home</b>, heating is <u>on</u> and home alarm is <u>off</u>';

        $this->deltaExplanation['r4r5'] = 'Normally, heating is off and home alarm is on, but because user <b>is at home</b> (<i>he will not leave</i>) and the <b>temperature of the house is under 20 degrees</b>, heating is <u>on</u> and home alarm is <u>off</u>';
        $this->deltaExplanation['r5r4'] = 'Normally, heating is off and home alarm is on, but because user <b>is at home</b> (<i>he will not leave</i>) and the <b>temperature of the house is under 20 degrees</b>, heating is <u>on</u> and home alarm is <u>off</u>';

        $this->deltaExplanation['r7r4'] = 'Normally, heating is off and home alarm is on, but because user <b>is at home</b> and the <b>temperature of the house is above 27 degrees</b>, heating is <u>off</u> and home alarm is <u>off</u>';
        $this->deltaExplanation['r4r7'] = 'Normally, heating is off and home alarm is on, but because user <b>is at home</b> and the <b>temperature of the house is above 27 degrees</b>, heating is <u>off</u> and home alarm is <u>off</u>';

        $this->deltaExplanation['r3r6'] = 'Normally, heating is off and home alarm is on, but because user <b>is at home</b> and he is about to <b>leave home</b>, heating is <u>off</u> and home alarm is <u>on</u>';
        $this->deltaExplanation['r6r3'] = 'Normally, heating is off and home alarm is on, but because user <b>is at home</b> and he is about to <b>leave home</b>, heating is <u>off</u> and home alarm is <u>on</u>';

        $this->deltaExplanation['r2r6'] = 'Normally, heating is off and home alarm is on, but because user <b>is at home</b> and he is about to <b>leave home</b>, it does not matter what is the temperature, and so heating is <u>Off</u> and home alarm is <u>On</u>';
        $this->deltaExplanation['r6r2'] = 'Normally, heating is off and home alarm is on, but because user <b>is at home</b> and he is about to <b>leave home</b>, it does not matter what is the temperature, and so heating is <u>Off</u> and home alarm is <u>On</u>';

        $this->deltaExplanation['r8r1'] = 'Normally, heating is off and home alarm is on, but because user <b>is not at home</b> and he is about to <b>arrive home</b>, heating is <u>off</u> and home alarm is <u>on</u>';
        $this->deltaExplanation['r1r8'] = 'Normally, heating is off and home alarm is on, but because user <b>is not at home</b> and he is about to <b>arrive home</b>, heating is <u>off</u> and home alarm is <u>on</u>';

        $this->deltaExplanation['r9r10'] = 'Generally when is <b>after midnight</b> heating is <u>off</u> and home alarm is <u>on</u>, it does not matter if the user is home or absent and it is not affected by the house temperature';
        $this->deltaExplanation['r10r9'] = 'Generally when is <b>after midnight</b> heating is <u>off</u> and home alarm is <u>on</u>, it does not matter if the user is home or absent and it is not affected by the house temperature';
    }

    private function generateResultArray($obj)
    {
        $result = array(
            'alarmOn' => $obj['alarmOn'],
            'alarmOnDelta' => $obj['alarmOnDelta'],
            'alarmOnDeltaExplanation' => "",
            'alarmOff' => $obj['alarmOff'],
            'alarmOffDelta' => $obj['alarmOffDelta'],
            'alarmOffDeltaExplanation' => "",
            'heatOn' => $obj['heatOn'],
            'heatOnDelta' => $obj['heatOnDelta'],
            'heatOnDeltaExplanation' => "",
            'heatOff' => $obj['heatOff'],
            'heatOffDelta' => $obj['heatOffDelta'],
            'heatOffDeltaExplanation' => ""
        );
        if (array_key_exists('alarmOn', $obj) && $obj['alarmOn']) {
            if (array_key_exists('heatOff', $obj) && $obj['heatOff'])
                $result['alarmOnDeltaExplanation'] = $this->createExplanationFromGorgiasDelta($obj['alarmOnDelta'], $obj['heatOffDelta']);
        } else if (array_key_exists('alarmOff', $obj) && $obj['alarmOff']) {
            if (array_key_exists('heatOff', $obj) && $obj['heatOff'])
                $result['alarmOffDeltaExplanation'] = $this->createExplanationFromGorgiasDelta($obj['alarmOffDelta'], $obj['heatOffDelta']);
        } else if (array_key_exists('alarmOn', $obj) && $obj['alarmOn']) {
            if (array_key_exists('heatOn', $obj) && $obj['heatOn'])
                $result['alarmOnDeltaExplanation'] = $this->createExplanationFromGorgiasDelta($obj['alarmOnDelta'], $obj['heatOnDelta']);
        }
        if (array_key_exists('alarmOff', $obj) && $obj['alarmOff']) {
            if (array_key_exists('heatOn', $obj) && $obj['heatOn'])
                $result['alarmOffDeltaExplanation'] = $this->createExplanationFromGorgiasDelta($obj['alarmOffDelta'], $obj['heatOnDelta']);
        }

        return $result;
    }

    private function createExplanationFromGorgiasDelta($param, $obj)
    {
        if (in_array('r2', $param) && in_array('r1', $obj)) {
            return $this->deltaExplanation['r1r2'];
        } else if (in_array('r4', $param) && in_array('r3', $obj)) {
            return $this->deltaExplanation['r3r4'];
        } else if (in_array('r4', $param) && in_array('r5', $obj)) {
            return $this->deltaExplanation['r4r5'];
        } else if (in_array('r4', $param) && in_array('r7', $obj)) {
            return $this->deltaExplanation['r4r7'];
        } else if (in_array('r6', $param) && in_array('r3', $obj)) {
            return $this->deltaExplanation['r3r6'];
        } else if (in_array('r6', $param) && in_array('r1', $obj)) {
            return $this->deltaExplanation['r1r6'];
        } else if (in_array('r8', $param) && in_array('r1', $obj)) {
            return $this->deltaExplanation['r8r1'];
        } else if (in_array('r10', $param) && in_array('r9', $obj)) {
            return $this->deltaExplanation['r9r10'];
        }
    }

    public function executeGorgias($at_home, $arrive_home, $leave_home, $home_temperature_under_20, $home_temperature_more_27, $after_midnight)
    {
        // Create prolog API object instance
        $prologApiInstance = new PrologControllerApi();

        // Configure HTTP basic authorization: basicAuth

        $prologApiInstance->getConfig()->setUsername("mtsokk01");
        $prologApiInstance->getConfig()->setPassword("99922240a");
        $prologApiInstance->getConfig()->setHost("http://aiasvm1.amcl.tuc.gr:8085");

        // Consult the  Gorgias policy file from the specific project:rrrrrrrrrrr
        // consultFileUsingPOST("your gorgias policy file, "your project name)

        $result = $prologApiInstance->consultFileUsingPOST("prol.pl", "proj2");

        // We will use the fact list to retract the facts when we finish

        $factsList = array();
        // Create prolog query object instance

        $prologQueryObj = new QueryObj();

        // Configure  maximum number of answers and execution time
        // ////evala 2 dame sto setresultsize eno ishen 1

        $prologQueryObj->setResultSize(10);
        $prologQueryObj->setTime(1000);

        // Assert fact (Non-defeasible conditions)
        if ($at_home) {
            // Prepare fact string
            $fact = "at_home";
            // Assert fact
            $prologQueryObj->setQuery('assert(' . $fact . ').');
            $result = $prologApiInstance->prologCommandUsingPOST($prologQueryObj);
            // Add fact to facts list
            $factsList[] = $fact;
        }

        // Assert fact (defeasible conditions)
        if ($arrive_home) {
            // Prepare fact string
            $fact = "arrive_home";
            // Assert fact
            $prologQueryObj->setQuery('assert(' . $fact . ').');
            $result = $prologApiInstance->prologCommandUsingPOST($prologQueryObj);
            // Add fact to facts list
            $factsList[] = $fact;
        }
        // Assert fact (defeasible conditions)
        if ($leave_home) {
            // Prepare fact string
            $fact = "leave_home";
            // Assert fact
            $prologQueryObj->setQuery('assert(' . $fact . ').');
            $result = $prologApiInstance->prologCommandUsingPOST($prologQueryObj);
            // Add fact to facts list
            $factsList[] = $fact;
        }
        // Assert fact (defeasible conditions)
        if ($home_temperature_under_20) {
            // Prepare fact string
            $fact = "home_temperature_under_20";
            // Assert fact
            $prologQueryObj->setQuery('assert(' . $fact . ').');
            $result = $prologApiInstance->prologCommandUsingPOST($prologQueryObj);
            // Add fact to facts list
            $factsList[] = $fact;
        }

        // Assert fact (defeasible conditions)
        if ($home_temperature_more_27) {
            // Prepare fact string
            $fact = "home_temperature_more_27";
            // Assert fact
            $prologQueryObj->setQuery('assert(' . $fact . ').');
            $result = $prologApiInstance->prologCommandUsingPOST($prologQueryObj);
            // Add fact to facts list
            $factsList[] = $fact;
        }

        // Assert fact (defeasible conditions)
        if ($after_midnight) {
            // Prepare fact string
            $fact = "after_midnight";
            // Assert fact
            $prologQueryObj->setQuery('assert(' . $fact . ').');
            $result = $prologApiInstance->prologCommandUsingPOST($prologQueryObj);
            // Add fact to facts list
            $factsList[] = $fact;
        }
        // Result array:
        $gorgiasResult = array(
            "alarmOn" => false,
            "alarmOnDelta" => array(),
            "alarmOff" => false,
            "alarmOffDelta" => array(),
            "heatOn" => false,
            "heatOnDelta" => array(),
            "heatOff" => false,
            "heatOffDelta" => array()
        );

        // Prepare Gorgias query string
        $querySellHigh = "heating(Y),alarm(X)";
        // Prepare prove command
        $gorgiasQuerySellHigh = "prove([" . $querySellHigh . "],Delta)";
        // Create query object instance
        $gorgiasQueryObj = new QueryObj();
        // Configure  Maximum number of answers
        $gorgiasQueryObj->setResultSize(10);
        // Configure execution time
        $gorgiasQueryObj->setTime(1000);
        // Set Gorgias query
        $gorgiasQueryObj->setQuery($gorgiasQuerySellHigh);
        // console.log("kkkkkkkkmkmkmkmkmkmkmkmkm");
        // Execute Gorgias query on Gorgias cloud
        /*
         * $js_code = 'console.log(' . json_encode($gorgiasQuerySellHigh , JSON_HEX_TAG) .
         * ');';
         */
        // echo $gorgiasQuerySellHigh;
        // if ($with_script_tags) {
        // $js_code = '<script>' . $js_code . '</script>';
        // }
        // echo $js_code;
        $response = $prologApiInstance->proveUsingPOST($gorgiasQueryObj);

        /*
         * If the response is an array and the array contains a string
         * in the format({Delta=[delta rules heads]} )
         * the answer of the query is true.
         */

        if (is_array($response)) {
            $rr = 0;

            if (isset($response[1])) {

                $rr ++;
            }

            if (isset($response[2])) {

                $rr ++;
            }
            if (isset($response[3])) {

                $rr ++;
            }

            if (isset($response[4])) {

                $rr ++;
            }

            if (isset($response[5])) {

                $rr ++;
            }
            if (isset($response[6])) {

                $rr ++;
            }
            if (isset($response[7])) {

                $rr ++;
            }

            if (isset($response[8])) {

                $rr ++;
            }
            if (isset($response[9])) {

                $rr ++;
            }
            echo "<br>";

            $re = '/{Delta=\[([^][,]*),\h*([^][]*)][^{}]*}/';
            // $str = '{Delta=[r3, r4], X=alarmOff, Y=heatOn}';

            if (strlen($response[$rr]) < 42)
                $result = preg_replace($re, '$1$2', $response[$rr]);
            else {
                $te = '/{Delta=\[nott\(.*\)([^][,]*),\h*([^][]*),\h*([^][]*),\h*([^][]*),\h*([^][]*)][^{}]*}/';
                $result = preg_replace($te, '$2$4', $response[$rr]);
                $result = preg_replace($te, '$2$4', $response[$rr]);
            }
            // echo $result;

            if (isset($this->deltaExplanation[$result])) {
                // echo $this->deltaExplanation[$result];

                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h3>Explanation:</h3><h4>' . $this->deltaExplanation[$result] . '</h4>';
                echo '</div>';
                echo '</div>';
            }
            /*
             * else if (!isset($this->deltaExplanation[$result])) {
             * echo '<h3 class="bg-success text-white"> No explanation for the scenarios you have selected so here is the general explanation: </h3>';
             * echo '<div class="card">';
             * echo '<div class="card-body">';
             * echo '<h3>Explanation:</h3><h4>'.$this->deltaExplanation[$Noexplanation].'</h4>';
             * echo '</div>';
             * echo '</div>';
             *
             * }
             */

            if (preg_match('/^{Delta=(\[.*\])}$/', $response[0])) {

                $gorgiasResult["alarmOn"] = true;
                $gorgiasResult["heatOn"] = true; // //

                // parse the explanation (delta) string to a php array
                // parse from ["{Delta=[nott(d2(21, customer)), d2(21, customer), nott(c4(21, customer)), p1(21, customer), c4(21, customer), f3, r1(21, customer)]}"]
                // to ["d2","p1","c4","f3","r1"]
                echo "1";
                $gorgiasResult["alarmOnDelta"] = $this->parseDeltaToPHPArray($matches[1]);
                echo $matches[1];
                $gorgiasResult["heatOnDelta"] = $this->parseDeltaToPHPArray($matches[1]);
                echo $matches[1];
            }
            if (preg_match('/^{Delta=(\[.*\, .*\])}$/', $response[0], $matches)) {
                $gorgiasResult["alarmOn"] = true;
                $gorgiasResult["heatOff"] = true;
                // parse the explanation (delta) string to a php array
                // parse from ["{Delta=[nott(d2(21, customer)), d2(21, customer), nott(c4(21, customer)), p1(21, customer), c4(21, customer), f3, r1(21, customer)]}"]
                // to ["d2","p1","c4","f3","r1"]
                echo "2";
                $gorgiasResult["alarmOnDelta"] = $this->parseDeltaToPHPArray($matches[1]);
                echo $matches[1];
                $gorgiasResult["heatOffDelta"] = $this->parseDeltaToPHPArray($matches[1]);
                echo $matches[1];
            }
            if (preg_match('/^{Delta=(\[.*\])}$/', $response[0], $matches)) {
                $gorgiasResult["alarmOff"] = true;
                $gorgiasResult["heatOn"] = true;
                // parse the explanation (delta) string to a php array
                // parse from ["{Delta=[nott(d2(21, customer)), d2(21, customer), nott(c4(21, customer)), p1(21, customer), c4(21, customer), f3, r1(21, customer)]}"]
                // to ["d2","p1","c4","f3","r1"]
                echo "3";
                $gorgiasResult["alarmOffDelta"] = $this->parseDeltaToPHPArray($matches[1]);
                echo $matches[1];
                $gorgiasResult["heatOnDelta"] = $this->parseDeltaToPHPArray($matches[1]);
                echo $matches[1];
            }
            if (preg_match('/^{Delta=(\[.*\])}$/', $response[0], $matches)) {
                $gorgiasResult["alarmOff"] = true;
                $gorgiasResult["heatOff"] = true;
                // parse the explanation (delta) string to a php array
                // parse from ["{Delta=[nott(d2(21, customer)), d2(21, customer), nott(c4(21, customer)), p1(21, customer), c4(21, customer), f3, r1(21, customer)]}"]
                // to ["d2","p1","c4","f3","r1"]
                echo "4";
                $gorgiasResult["alarmOffDelta"] = $this->parseDeltaToPHPArray($matches[1]);
                echo $matches[1];
                $gorgiasResult["heatOffDelta"] = $this->parseDeltaToPHPArray($matches[1]);
                echo $matches[1];
            }
        }
        /*
         * $querySellLow="heating(Y)";
         * $gorgiasQuerySellLow = "prove([" .$querySellLow. "],Delta)";
         * $gorgiasQueryObj->setQuery($gorgiasQuerySellLow);
         * $response= $prologApiInstance->proveUsingPOST($gorgiasQueryObj);
         *
         * if(is_array($response)){
         * if (preg_match('/^{Delta=(\[.*\])}$/', $response[0], $matches)) {
         * $gorgiasResult["heatOn"]=true;
         * $gorgiasResult["on_heatingDelta"]=$this->parseDeltaToPHPArray($matches[1]);
         * }
         * if (preg_match('/^{Delta=(\[.*\])}$/', $response[0], $matches)) {
         * $gorgiasResult["off_heating"]=true;
         * $gorgiasResult["off_heatingDelta"]=$this->parseDeltaToPHPArray($matches[1]);
         * }
         * }
         */

        // When we finish we must unload the Gorgias file and retract all facts
        // unloadFileUsingPOST("your gorgias policy file, "your project name)

        $result = $prologApiInstance->unloadFileUsingPOST("prol.pl", "proj2");

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
            } else if (! preg_match('/^nott\(.*\)$/', $deltaTerm, $matches)) {
                $ruleHead = explode('(', $deltaTerm)[0];
                $deltaArray[] = $ruleHead;
            }
        }
        return $deltaArray;
    }
}

?>
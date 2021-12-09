<?php

require_once('LinkGorgiasWithPHP.php');

class Api
{

    public function __construct()
    {

    }

    public function handleRequest()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userMod = isset($_POST["togBtn"]);
            $noCook = isset($_POST["noCook"]);
            $noDelivery = isset($_POST["noDelivery"]);
            $noTakeaway = isset($_POST["noTakeaway"]);
            $moodToCook = isset($_POST["moodToCook"]);
            $haveHw = isset($_POST["haveHw"]);
            $easyHw = isset($_POST["easyHw"]);

            $linkGorgiasWithPHP = new LinkGorgiasWithPHP();
            return $linkGorgiasWithPHP->executeGorgias($userMod, $noCook, $noDelivery, $noTakeaway, $moodToCook, $haveHw, $easyHw);
        }
    }

}

?>
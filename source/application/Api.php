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
            $userMod = $_POST["userMod"];
            $noCook = false;
            $noDelivery = false;
            $noTakeaway = false;
            $noOptions = false;
            $moodToCook = false;
            $haveHw = false;
            $easyHw = false;

            if (isset($_POST["noCook"])) {
                $noCook = true;
            }
            if (isset($_POST["noDelivery"])) {
                $noDelivery = true;
            }
            if (isset($_POST["noTakeaway"])) {
                $noTakeaway = true;
            }
            if (isset($_POST["noCook"]) && isset($_POST["noDelivery"]) && isset($_POST["noTakeaway"])) {
                $noOptions = true;
            }
            if (isset($_POST["moodToCook"])) {
                $moodToCook = true;
            }
            if (isset($_POST["haveHw"])) {
                $haveHw = true;
            }
            if (isset($_POST["easyHw"])) {
                $easyHw = true;
            }

            $linkGorgiasWithPHP = new LinkGorgiasWithPHP();
            return $linkGorgiasWithPHP->executeGorgias($userMod, $noCook, $noDelivery, $noTakeaway, $noOptions, $moodToCook, $haveHw, $easyHw);
        }

    }

}

?>
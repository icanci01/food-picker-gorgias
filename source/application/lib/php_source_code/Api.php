<?php

require_once('LinkGorgiasWithPHP.php');

class Api {

    public function __construct() {
        
    }

    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["productId"]) && !empty($_POST["productId"])) {
                $regularCustomer = false;
                $customerId = "customer";
                $lateDelivery = false;
                $highSeason = false;
                $payCash = false;
                if (isset($_POST["customerId"]) && !empty($_POST["customerId"]) && is_numeric($_POST["customerId"])) {
                    $customerId = $_POST["customerId"];
                    $regularCustomer = true;
                }
                if (isset($_POST["lateDelivery"])) {
                    $lateDelivery = $_POST["lateDelivery"];
                }
                if (isset($_POST["highSeason"])) {
                    $highSeason = $_POST["highSeason"];
                }
                if (isset($_POST["paymentMethod"]) && $_POST["paymentMethod"] == "cash") {
                    $payCash = true;
                }
                $linkGorgiasWithPHP = new LinkGorgiasWithPHP();
                return $linkGorgiasWithPHP->executeGorgias($_POST["productId"], $customerId, $regularCustomer, $payCash, $lateDelivery, $highSeason);
            }
        }
    }

}

?>
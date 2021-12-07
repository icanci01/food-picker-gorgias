<?php
require_once ('LinkGorgiasWithPHP2.php');

class Api
{

    public function __construct()
    {}

    public function handleRequest()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $at_home = false;
            $leave_home = false;
            $arrive_home = false;
            $home_temperature_under_20 = false;
            $home_temperature_more_27 = false;
            $after_midnight = false;
            if (isset($_POST['at_home'])) {
                $at_home = $_POST['at_home'];
                // $at_home=true;
            }
            if (isset($_POST['leave_home'])) {
                $leave_home = $_POST['leave_home'];
            }
            if (isset($_POST['arrive_home'])) {
                $arrive_home = $_POST['arrive_home'];
            }
            if (isset($_POST['home_temperature_under_20'])) {
                $home_temperature_under_20 = $_POST['home_temperature_under_20'];
            }
            if (isset($_POST['home_temperature_more_27'])) {
                $home_temperature_more_27 = $_POST['home_temperature_more_27'];
            }
            if (isset($_POST['after_midnight'])) {
                $after_midnight = $_POST['after_midnight'];
            }

            $linkGorgiasWithPHP2 = new LinkGorgiasWithPHP2();
            return $linkGorgiasWithPHP2->executeGorgias($at_home, $arrive_home, $leave_home, $home_temperature_under_20, $home_temperature_more_27, $after_midnight);
        }
    }
}

?>
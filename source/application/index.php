<?php
require_once('Api.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Gorgias Food Picker</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap">
    <link rel="stylesheet" href="customStyles.css">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
</head>
<body>
<div class="container" style="margin-top: 1em">
    <div class="card">
        <div class="card-header bg-dark text-white" style="display: flex; align-items: center; justify-content: center">
            <h1>Food Method Picker</h1>
        </div>
        <div class="card-body bg-light text-dark">
            <form method="POST" action="index.php">
                <div class="row">
                    <!-- Switch between the two users -->
                    <div class="col">
                        <div class="form-group">
                            <label class="switch">
                                <input type="checkbox" name="togBtn" id="togBtn"
                                    <?php
                                    if (isset($_POST['togBtn']) && $_POST['togBtn']) {
                                        echo htmlspecialchars('checked');
                                    }
                                    ?>
                                >
                                <div class="slider round">
                                    <div class="on">
                                        <span>Panikos</span>
                                    </div>
                                    <div class="off">
                                        <span>Cristian</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <!-- Preferences for Panikos -->
                    <div class="col">
                        <h3>Panikos</h3>
                        <h5>
                            Prefers it in this order: <br>
                            <ul>
                                <li>Delivery</li>
                                <li>Takeaway</li>
                                <li>Cook</li>
                            </ul>
                        </h5>
                    </div>
                    <!-- Preferences for Cristian -->
                    <div class="col">
                        <h3>Cristian</h3>
                        <h5>
                            Prefers it in this order: <br>
                            <ul>
                                <li>Cook</li>
                                <li>Takeaway</li>
                                <li>Delivery</li>
                            </ul>
                        </h5>
                    </div>
                </div>
                <hr>
                <!-- noCook -->
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="noCook" name="noCook"
                            <?php
                            if (isset($_POST['noCook']) && $_POST['noCook']) {
                                echo htmlspecialchars('checked');
                            }
                            ?>> <label class="custom-control-label" for="noCook">Can not Cook</label>
                    </div>
                </div>
                <!-- noDelivery -->
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="noDelivery" name="noDelivery"
                            <?php
                            if (isset($_POST['noDelivery']) && $_POST['noDelivery']) {
                                echo htmlspecialchars('checked');
                            }
                            ?>> <label class="custom-control-label" for="noDelivery">Can not Deliver</label>
                    </div>
                </div>
                <!-- noTakeaway -->
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="noTakeaway" name="noTakeaway"
                            <?php
                            if (isset($_POST['noTakeaway']) && $_POST['noTakeaway']) {
                                echo htmlspecialchars('checked');
                            }
                            ?>> <label class="custom-control-label" for="noTakeaway">Can not Takeaway</label>
                    </div>
                </div>
                <!-- moodToCook -->
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input"
                               id="moodToCook" name="moodToCook"
                            <?php
                            if (isset($_POST['moodToCook']) && $_POST['moodToCook']) {
                                echo htmlspecialchars('checked');
                            }
                            ?>> <label class="custom-control-label"
                                       for="moodToCook">I am in the mood to cook</label>
                    </div>
                </div>
                <!-- haveHw -->
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="haveHw"
                               name="haveHw"
                            <?php
                            if (isset($_POST['haveHw']) && $_POST['haveHw']) {
                                echo htmlspecialchars('checked');
                            }
                            ?>> <label class="custom-control-label"
                                       for="haveHw">I have homework</label>
                    </div>
                </div>
                <!-- easyHw -->
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="easyHw"
                               name="easyHw"
                            <?php
                            if (isset($_POST['easyHw']) && $_POST['easyHw']) {
                                echo htmlspecialchars('checked');
                            }
                            ?>> <label class="custom-control-label"
                                       for="easyHw">I have easy homework</label>
                    </div>
                </div>

                <button type="submit" name="btn_submit" id="btn_submit" class="btn btn-primary btn-lg">Submit</button>
                <button type="reset" name="btn_clear" id="btn_clear" class="btn btn-warning btn-lg">Clear all</button>
            </form>
        </div>
        <div class="card-footer bg-light text-dark">
            <?php

            $api = new Api();
            $result = $api->handleRequest();

            ?>
        </div>
    </div>
</div>
</body>
<footer>
    <div class="container" style="margin-top: 1em; display: flex; align-items: center; justify-content: center;">
        <div class="card-footer bg-dark text-white">
            <h5>Created by Panikos Christou and Cristian - Ionut Canciu</h5>
        </div>
    </div>
</footer>
</html>
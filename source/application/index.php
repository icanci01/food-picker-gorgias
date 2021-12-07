<?php
require_once ('Api.php');

// unset($_POST["noCook"]);
// unset($_POST["noDelivery"]);
// unset($_POST["noTakeaway"]);
// unset($_POST["moodToCook"]);
// unset($_POST["haveHw"]);
// unset($_POST["easyHw"]);
// unset($_POST["cristian"]);

if (isset($_POST["btn_submit"])) {
    $noCook = false;
    $noDelivery = false;
    $noTakeaway = false;
    $noOptions = false;
    $moodToCook = false;
    $haveHw = false;
    $easyHw = false;
    $cristian = false;
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
    if (isset($_POST["slid"])) {
        $cristian = true;
    }
    // echo $cristian;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Gorgias Food Picker</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet"
	href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap">
<link rel="stylesheet" href="customStyles.css">
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<style>
h1, h2, h3, h4: {
	font-family: 'Roboto', sans-serif;
}

.switch {
	position: relative;
	display: inline-block;
	width: 300px;
	height: 68px;
}

.switch input {
	display: none;
}

.slider {
	position: absolute;
	cursor: pointer;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background-color: #cc0000;
	-webkit-transition: .4s;
	transition: .4s;
}

.slider:before {
	position: absolute;
	content: "";
	height: 60px;
	width: 52px;
	left: 4px;
	bottom: 4px;
	background-color: white;
	-webkit-transition: .4s;
	transition: .4s;
}

input:checked+.slider {
	background-color: #008000;
}

input:focus+.slider {
	box-shadow: 0 0 1px #008000;
}

input:checked+.slider:before {
	-webkit-transform: translateX(240px);
	-ms-transform: translateX(240px);
	transform: translateX(240px);
}

/*------ ADDED CSS ---------*/
.on {
	display: none;
}

.on, .off {
	color: white;
	position: absolute;
	transform: translate(-50%, -50%);
	top: 50%;
	left: 50%;
	font-size: 30px;
	font-family: Verdana, sans-serif;
}

input:checked+.slider .on {
	display: block;
}

input:checked+.slider .off {
	display: none;
}

/*--------- END --------*/

/* Rounded sliders */
.slider.round {
	border-radius: 34px;
}

.slider.round:before {
	border-radius: 50%;
}
</style>
</head>
<body>
	<div class="container" style="margin-top: 1em">
		<div class="card">
			<div class="card-header bg-dark text-white"
				style="display: flex; align-items: center; justify-content: center">
				<h1>Food Method Picker</h1>
			</div>
			<form method="POST"action="index.php">
			<div class="card-body">
				<div class="row">
					<!-- Switch between the two users -->
					<div class="col">
						<div class="form-group">
							<label class="switch" for="togBtn"> <input type="checkbox"
								id="togBtn">
								<label class="switch">
								
  <input type="checkbox" name="slid" id="slid" >
  
  <div class="slider round"> <div class="on">
										<span>Panikos</span>
									</div>
									<div class="off">
										<span>Cristian</span>
									</div></div>
</label>
								<!--  <div class="slider round">
									<!--ADDED HTML -->
									<!-- 
									<div class="on">
										<span>Panikos</span>
									</div>
									<div class="off">
										<span>Cristian</span>
									</div>

								</div>-->
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
				<div class="form-group" >
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="noCook"
							name="noCook"
							<?php

    if (isset($_POST['noCook']) && $_POST['noCook']) {
        echo htmlspecialchars('checked');
    }
    ?>> <label class="custom-control-label"
							for="noCook">Can not Cook</label>
					</div>
				</div>
				<!-- noDelivery -->
				<div class="form-group">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input"
							id="noDelivery" name="noDelivery"
<?php
if (isset($_POST['noDelivery']) && $_POST['noDelivery']) {
    echo htmlspecialchars('checked');
}
?>> <label class="custom-control-label"
							for="noDelivery">Can not Deliver</label>
					</div>
				</div>
				<!-- noTakeaway -->
				<div class="form-group">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input"
							id="noTakeaway" name="noTakeaway"
							<?php
    if (isset($_POST['noTakeaway']) && $_POST['noTakeaway']) {
        echo htmlspecialchars('checked');
    }
    ?>> <label class="custom-control-label"
							for="noTakeaway">Can not Takeaway</label>
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
			</div>
</form>
			<div class="card-footer bg-light text-dark">
            <?php

            // $api = new Api();
            // $result = $api->handleRequest();
            // echo $result;

            $linkGorgiasWithPHP = new LinkGorgiasWithPHP();
            return $linkGorgiasWithPHP->executeGorgias($cristian, $noCook, $noDelivery, $noTakeaway, $noOptions, $moodToCook, $haveHw, $easyHw);

            ?>
        </div>

		</div>
	</div>
</body>
<footer>
	<div class="container"
		style="margin-top: 1em; display: flex; align-items: center; justify-content: center;">
		<div class="card-footer bg-dark text-white">
			<h5>Created by Panikos Christou and Cristian - Ionut Canciu</h5>
		</div>
	</div>
</footer>
</html>
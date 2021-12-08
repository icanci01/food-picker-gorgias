<?php
require_once ('Api.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Gorgias Seller</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link
	href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap"
	rel="stylesheet">

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
			<div class="card-header bg-dark text-white">
				<h1>Food method Picker</h1>
			</div>
			<div class="card-header bg-dark text-white">
				<h5>-By Panikos Christou and Cristian Ionut Canciu</h5>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col">
						<div class="form-group">

							<label class="switch"> <input type="checkbox" id="togBtn">
								<div class="slider round">
									<!--ADDED HTML -->
									<span class="on">Panikos</span> <span class="off">Cristian</span>
									<!--END-->
								</div>
							</label>

						</div>
					</div>
					<div class="col">
						<div class="form-group">
							<h1>Cristian</h1>
							<h3>
								Prefers it in this order: <br>
								<ul>
									<li>Cook</li>
									<li>Takeaway</li>
									<li>Delivery</li>
								</ul>
							</h3>
							<hr>
							<h1>Panikos</h1>
							<h3>
								Prefers it in this order: <br>
								<ul>
									<li>Delivery</li>
									<li>Takeaway</li>
									<li>Cook</li>
								</ul>
							</h3>
						</div>
					</div>
				</div>
				<hr>
				<div class="form-group">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="noCook"
							name="noCook"
							<?php

    if (isset($_POST['noCook']) && $_POST['noCook']) {
        echo htmlspecialchars('checked');
    }
    ?>> <label class="custom-control-label" for="noCook">Can not Cook</label>
					</div>
				</div>

				<button type="submit" class="btn btn-primary btn-lg">Submit</button>
			</div>
			<div class="card-footer bg-light text-dark">
                    <?php
                    $api = new Api();
                    $result = $api->handleRequest();
                    if (isset($result['canSellHigh']) && $result['canSellHigh']) {
                        echo '<h3 class="bg-success text-white">Sell at High Price</h3>';
                        echo '<div class="card">';
                        echo '<div class="card-body">';
                        echo '<h3>Explanation:</h6><h4>' . $result['sellHighDeltaExplanation'] . '</h4>';
                        echo '</div>';
                        echo '</div>';
                    }
                    if (isset($result['canSellLow']) && $result['canSellLow']) {
                        echo '<h3 class="bg-success text-white">Sell at Low Price</h3>';
                        echo '<div class="card">';
                        echo '<div class="card-body">';
                        echo '<h3>Explanation:</h3><h4>' . $result['sellLowDeltaExplanation'] . '</h4>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
		</div>
	</div>

</body>
</html>
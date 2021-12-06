<?php
require_once('Api.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="Assets/index.css">

	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<title>Gorgias Alarm & Heat Assistant</title>
</head>
<body>
		<!-- background -->
		<header class="masthead text-white text-center">
			<div class="overlay"></div>
			<div class="container">
				<div class="row">
					<div class="col-xl-9 mx-auto">
						
						<h3 class="bg text-white">Home heat and alarm assistant</h3>
					</div>
				</div>
			</div>
		</header>

		<section class="bg-light text-center">
			<div class="container">
				<div class="row">
					<div class="mx-auto mt-4 mb-5 mb-lg-0 mb-lg-3">
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
							<div class="form-group row">
								<div class="p-1 bg-success text-white rounded">Options for home devices Alarm and Heat</div>
							</div>
							<div class="form-group row">
								<div class="text-left">
									<div class="form-check">
										
										<input id="at_home" type="checkbox" class="form-check-input" name="at_home" <?php if (isset($_POST['at_home']) && $_POST['at_home']){ echo htmlspecialchars('checked');} ?>>
										<label for="at_home" class="form-check-label">At home.</label>
									</div>
									<div class="form-check">
										<input id="leave_home" type="checkbox" class="form-check-input" name="leave_home" <?php if (isset($_POST['leave_home']) && $_POST['leave_home']){echo htmlspecialchars('checked');}?>>
										<label for="leave_home" class="form-check-label">Leave home.</label>
									</div>
									<div class="form-check">
										<input id="arrive_home" type="checkbox" class="form-check-input" name="arrive_home" <?php if (isset($_POST['arrive_home']) && $_POST['arrive_home']){ echo htmlspecialchars('checked');} ?>>
										<label for="arrive_home" class="form-check-label">Arrive home.</label>
									</div>
									<div class="form-check">
										<input id="home_temp_under" type="checkbox" class="form-check-input" name="home_temperature_under_20" <?php if (isset($_POST['home_temperature_under_20']) && $_POST['home_temperature_under_20']){ echo htmlspecialchars('checked');} ?>>
										<label for="home_temp_under" class="form-check-label">Home temperature is under 20C.</label>
									</div>
									<div class="form-check">
										<input id="home_temp_above" type="checkbox" class="form-check-input" name="home_temperature_more_27" <?php if (isset($_POST['home_temperature_more_27']) && $_POST['home_temperature_more_27']){ echo htmlspecialchars('checked');} ?>>
										<label for="home_temp_above" class="form-check-label">Home temperature is above 27C.</label>
									</div>
									<div class="form-check">
										<input id="after_midnight" type="checkbox" class="form-check-input" name="after_midnight" <?php if (isset($_POST['after_midnight']) && $_POST['after_midnight']){ echo htmlspecialchars('checked');} ?>>
										<label for="after_midnight" class="form-check-label">After midnight.</label>
									</div>
								</div>
							</div>
							<div class="form-group row">
                                <div class="col-lg">
                                    <button class="btn btn-primary btn-lg">Submit</button>
                                </div>
							</div>
						</form>
					</div>
				</div>
                <div class="card-footer bg-light text-dark">
                    <?php
                        $api = new Api();////prin itan keflaio to prasino api
                        $result = $api->handleRequest();
//                        echo '<pre>';
//                        echo htmlspecialchars(var_dump($result));
//                        echo '</pre>';
//                        die();
                        if ($result['alarmOn'] && $result['heatOn']){
                            echo '<h3 class="bg-success text-white">Heat and alarm are ON</h3>';
                            echo '<div class="card">';
                            echo '<div class="card-body">';
                            echo '<h3>Explanation:</h3><h4>'.$result['alarmOnDeltaExplanation'].'</h4>';
//                            echo '<h3>Explanation:</h3><h4>'.$result['heatOnDeltaExplanation'].'</h4>';
                            echo '</div>';
                            echo '</div>';
                        }else
                        if ($result['alarmOff'] && $result['heatOff']){
                            echo '<h3 class="bg-success text-white">Heat and alarm are OFF</h3>';
                            echo '<div class="card">';
                            echo '<div class="card-body">';
                            echo '<h3>Explanation:</h3><h4>'.$result['alarmOffDeltaExplanation'].'</h4>';
//                            echo '<h3>Explanation:</h3><h4>'.$result['heatOffDeltaExplanation'].'</h4>';
                            echo '</div>';
                            echo '</div>';
                        }else
                        if ($result['heatOn'] && $result['alarmOff']){
                            echo '<h3 class="bg-success text-white">Heat is ON and Home alarm is Off</h3>';
                            echo '<div class="card">';
                            echo '<div class="card-body">';
                            echo '<h3>Explanation:</h3><h4>'.$result['alarmOffDeltaExplanation'].'</h4>';
//                            echo '<h3>Explanation:</h3><h4>'.$result['heatOnDeltaExplanation'].'</h4>';
                            echo '</div>';
                            echo '</div>';
                        }else
                        if ($result['heatOff'] && $result['alarmOn']){
                            echo '<h3 class="bg-success text-white">Heat is OFF and Home alarm is ON</h3>';
                            echo '<div class="card">';
                            echo '<div class="card-body">';
                            echo '<h3>Explanation:</h3><h4>'.$result['alarmOnDeltaExplanation'].'</h4>';
//                            echo '<h3>Explanation:</h3><h4>'.$result['heatOffDeltaExplanation'].'</h4>';
                            echo '</div>';
                            echo '</div>';
                        }
                        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
                            echo '<div class="mt-4 form-group row">
                                <div class="col-lg">
                                    <a href="index.php" class="btn btn-warning btn-lg">Clear</a>
                                </div>
							</div>';
                        }else if ($_SERVER['REQUEST_METHOD'] === 'GET'){
                            echo '<div class="mt-2">
                                    <div class="form-group row">
                                        <div class="col-lg">
                                            <p>
                                                <i>Select your choise</i>
                                            </p>
                                        </div>
                                    </div>
                                </div>';
                        }
                    ?>
                </div>
			</div>
		</section>
	</div>
</body>
</html>
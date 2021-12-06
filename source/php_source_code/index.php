<!DOCTYPE html>
<html lang="en">
<head>
    <title>Gorgias Food Picker</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
</head>
<body>
<div class="container" style="margin-top:1em">
    <div class="card">
        <div class="card-header bg-dark text-white"><h1>Food Picker</h1></div>
        <div class="card-body">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="preferredOrderingMethod">Select preferred ordering method</label>
                    <select name="ordering" id="ordering" style="margin-left: 2em">
                        <option value="Delivery">Delivery</option>
                        <option value="Cook">Cook</option>
                        <option value="Dine-in">Dine-in</option>
                        <option value="Take-Away">Take-away</option>

                    </select>

                </div>

                <div class="form-group">
                    <label for="foodPreferences">Food Preferences</label>
                </div>

                <button type="submit" class="btn btn-primary btn-lg">Submit</button>
            </form>
        </div>
        <div class="card-footer bg-light text-dark">

        </div>
    </div>
</div>
</body>
</html>
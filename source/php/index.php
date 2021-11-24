<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Gorgias Seller</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
        <style>
            h1,h2,h3,h4:{
                font-family: 'Roboto', sans-serif;
            }
        </style>
    </head>
    <body>
        <div class="container" style="margin-top:1em"> 
            <div class="card">
                <div class="card-header bg-dark text-white" ><h1>Sale Information</h1></div>
                <div class="card-body">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"> 
                        <div class="form-group">
                            <label for="usr">Product code:</label>
                            <input type="number"  min="00001" max="99999" class="form-control  form-control-lg" id="productId" name="productId" value="<?php if (isset($_POST['productId'])) {
    echo htmlspecialchars($_POST['productId']);
} ?>"   required>
                        </div> 
                        <div class="form-group">
                            <label for="pwd">Customer id:</label>
                            <input type="number" min="00001" max="99999" class="form-control  form-control-lg" id="customerId" name="customerId" value="<?php if (isset($_POST['customerId'])) {
    echo htmlspecialchars($_POST['customerId']);
} ?>" >
                        </div>



                        <div class="form-group">
                            <label for="paymentMethod">Select Payment method:</label>

                            <select id="paymentMethod" name="paymentMethod" class="custom-select">
                                <option value="empty" <?php if (!isset($_POST['paymentMethod']) || isset($_POST['paymentMethod']) && $_POST['paymentMethod'] == 'empty') {
    echo htmlspecialchars('selected');
} ?>></option>
                                <option value="cash" <?php if (isset($_POST['paymentMethod']) && $_POST['paymentMethod'] == 'cash') {
    echo htmlspecialchars('selected');
} ?>>Cash</option>
                                <option value="card" <?php if (isset($_POST['paymentMethod']) && $_POST['paymentMethod'] == 'card') {
    echo htmlspecialchars('selected');
} ?>>Credit/Debit Card</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="lateDelivery" name="lateDelivery" <?php if (isset($_POST['lateDelivery']) && $_POST['lateDelivery']) {
    echo htmlspecialchars('checked');
} ?>>
                                <label class="custom-control-label" for="lateDelivery">Customer can have late delivery</label>
                            </div>  </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="highSeason" name="highSeason" <?php if (isset($_POST['highSeason']) && $_POST['highSeason']) {
    echo htmlspecialchars('checked');
} ?> >
                                <label class="custom-control-label" for="highSeason">High season</label>
                            </div>
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
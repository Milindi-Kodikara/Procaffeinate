<?php
    session_start();
    include_once('tools.php');

$name = '';
$email = '';
$address = '';
$phone = '';
$card = '';
$date = '';
$expiryDate = '';
$nameErrorMessage = '';
$addressErrorMessage = '';
$emailErrorMessage = '';
$phoneErrorMessage = '';
$cardErrorMessage = '';
$dateErrorMessage = '';

$errorsFound = false;

if(!empty($_POST['checkout'])){
    if(!empty($_POST['name'])){
       $name = $_POST['name'];
        if(!(preg_match("/[a-zA-Z\-\,\'\.[ ]+$/", $name))){
          $nameErrorMessage = "Please enter a valid name!";
          $errorsFound = true;
        }else{
            $_SESSION['user']['name'] = $name;
        }
    }
    else {
        $errorsFound = true;
    }

    if (!empty($_POST['email'])){
        $email = $_POST['email'];
        if (!(filter_var($email, FILTER_VALIDATE_EMAIL))){
            $emailErrorMessage = "Please enter a valid email address!";
            $errorsFound = true;
        }
        else{
            $_SESSION['user']['email'] = $email;
        }
    }
    else {
        $errorsFound = true;
    }

    if(!empty($_POST['address'])){
        $address = $_POST['address'];
        if (!(preg_match("/^[a-zA-Z0-9\-\,\'\. \/\n]+$/", $address))){
            $addressErrorMessage = "Please enter a valid address!";
            $errorsFound = true;
        }
        else{
            $_SESSION['user']['address'] = $address;
        }
    }
    else{
        $errorsFound = true;
    }

    if (!empty($_POST['phone'])){
        $phone = $_POST['phone'];
        if (preg_match("/^(\(04\)|04|\+614){1}([ ]?\d){8}$/",$phone)){
            $errorsFound = false;
            $_SESSION['user']['phone'] = $phone;
        }else{
            $phoneErrorMessage = "Please enter a valid phone number!";
            $errorsFound = true;
        }
    }
    else{
        $errorsFound = true;
    }

    if (!empty($_POST['card'])){
        $card = $_POST['card'];
        if (preg_match("/^([ ]*\d){12,19}\s*$/",$card)){
            if(preg_match("/^(4){1}([ ]*\d){13,15}\s*$/", $card)){
                $errorsFound = false;
                $_SESSION['user']['card'] = $card;
            }
        }else{
            $cardErrorMessage = "Please enter a valid credit card number!";
            $errorsFound = true;
        }
    //if empty
    }else{
        $errorsFound = true;
    }
    if (!empty($_POST['date'])){
        $date = $_POST['date'];

        $expiryDate = strtotime($date);
        $futureDate = strtotime("+28 days");

        if($expiryDate < $futureDate){
            $dateErrorMessage = "The expiry date must be 28 days or more than 28 days in the future!";
            $errorsFound = true;
        }
        else $_SESSION['user']['date'] = $expiryDate;
    }
    else{
        $errorsFound = true;
    }
    if(!$errorsFound){
        header('Location: receipt.php');
    }
}

    top_module("Checkout|Procaffeination");
?>
<body>
    <div id="checkout-bkgrd" class='bkgrd'>
        <div class="card">
            <h3>Checkout</h3>
            <form action='checkout.php' method="post" class='form'>

                <label for="checkout-name">Full Name</label><input type='text' id="checkout-name" name='name' value='<?php echo $name ?>' required>
                <p>
                    <?php echo $nameErrorMessage ?>
                </p>

                <label for="checkout-email">Email Address</label>
                <input type='email' name='email' value='<?php echo $email ?>' required />
                <p>
                    <?php echo $emailErrorMessage ?>
                </p>

                <label for='address'>Delivery Address</label>
                <input type='text area' id='address' name='address' value='<?php echo $address ?>' required/>
                <p>
                    <?php echo $addressErrorMessage ?>
                </p>

                <label for='phone'>Mobile Number</label>
                <input type='text' id='phone' name='phone' value='<?php echo $phone ?>' required/>
                <p>
                    <?php echo $phoneErrorMessage ?>
                </p>

                <label for='card'>Credit card number</label>
                <input type='text' id='card' name='card' value='<?php echo $card ?>' required oninput="visaCard()"/>
                <!--para for the logo to display-->
                <p id="parapara"></p>
                <p>
                    <?php echo $cardErrorMessage ?>
                </p>

                <label for='date'>Card expiry date</label>
                <input type='date' id='date' name='date' value='<?php echo date("Y-m-d", $expiryDate) ?>' required />
                <p>
                    <?php echo $dateErrorMessage ?>
                </p>

                <input type='submit' name='checkout' value="Proceed">
            </form>
        </div>
    </div>
    <script src="eventhandler.js"></script>
    <?php bottom_module(); 
    echo preShow($_SESSION,true);
    ?>
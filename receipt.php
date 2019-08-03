<?php
    session_start();
    include_once('tools.php');
    top_module("Receipt|Procaffeination", 'receipt');
    write_orders('orders.txt');
?>
<pre>
    <?php
    $name = $_SESSION['user']['name'];
    $email = $_SESSION['user']['email'];
    $phone = $_SESSION['user']['phone'];
    $address = $_SESSION['user']['address'];
echo "
<table class='right-float'>
    <tr>
        <th>Name</th>
        <td>$name</td>
    </tr>
    <tr>
        <th>Email</th>
        <td>$email</td>
    </tr>
    <tr>
        <th>Mobile</th>
        <td>$phone
        </td>
    </tr>
    <tr>
        <th>Address</th>
        <td>$address</td>
    </tr>
</table>
"
    ?>
    <table>
        <tr>
            <th>
                Product name
            </th>
            <th>
                Size
            </th>
            <th>
                Quantity
            </th>
            <th>
                Unit price
            </th>
            <th>
                Subtotal
            </th>
        </tr>
        <?php
            $cart_size = sizeof($_SESSION['cart']);
            for ($i=0; $i < $cart_size; $i++) { 
                display_details($i);
            }
        ?>
    </table>
    <p></p>
</pre>

<?php
    bottom_module();
?>
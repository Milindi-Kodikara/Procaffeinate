<?php
    session_start();
    include_once('tools.php');
    if (sizeof($_POST) > 0)
    {
        $found_product = find_product($_POST['id'], $_POST['oid']);
        if (isset($_POST['add'], $_POST['id'], $_POST['qty'], $_POST['oid']) &&
            filter_input(INPUT_POST, "qty", FILTER_VALIDATE_INT) &&
            $_POST['qty'] > 0 &&
            $found_product !== FALSE)
        {
            $_SESSION['cart'][] = $_POST;
        }
        else {
            header("Location: products.php");
        }
    }
    top_module("Cart|Procaffeination");
    $count = 0;
    $totalPrice = 0;
    if (sizeof($_POST) > 0)
    {
        foreach($_SESSION['cart'] as $order){
            $subtotal = calculateTotalPrice($count);
            $_SESSION['cart'][$count]['subtotal'] = $subtotal;
            $_SESSION['cart'][$count]['price'] = find_product($order['id'], $order['oid'])['Price'];
            $totalPrice += $subtotal;
            $count++;
        };
    }
    $display_price = number_format((float)$totalPrice,2,'.','');
    $_SESSION['cart_total'] = $display_price;

?>
<div class='bkgrd' id='cart-bkgrd'>
    <div class="card">
        <h3>Cart</h3>
        <table>
            <tr>
                <th>Product Image</th>
                <th>Name</th>
                <th>Size</th>
                <th>Quantity</th>
                <th>Unit price</th>
                <th>Subtotal</th>
            </tr>
            <?php
            $count = 0;
            foreach($_SESSION['cart'] as $cart){
                display_details($count, TRUE);
                 $count++;
            }
            ?>
            </table>
    <div>
        <?php
        ?>

        </div>
            <form action="checkout.php" method="post">
                <input type='submit' value="Checkout" name='checkout' class='home-button'>
            </form>
            <form action="products.php" method="post">
            <input type='submit' value="Cancel" name="cancel" class='home-button'>
            </form>
</div>
<?php
bottom_module();
echo preShow($_SESSION,true);
// echo preShow(array_keys($_SESSION["cart"]));
?>

<?php
    session_start();
    include_once('tools.php');

    $products = read_table("products.txt");
    $product_id = $_GET['id'];
    $found_product = 0;
    foreach (array_filter($products, "unique_id_filter") as $product) {
        if ($product_id == $product['ID'])
            $found_product = $product;
    }
    if (!$found_product) {
        header('Location: products.php');
    }
    top_module("{$found_product['Title']}|Procaffeination");

    $product_price_id = $product['ID'];
    $arrayPhp = array($products);
    php2js($arrayPhp, 'products');
?>
<script src='forms.js'></script>
    <main>
        <div id="product-bkgrd" class='bkgrd'>
            <div class='product-outer-layer'>
                <div class='product-layer-1'>
                    <h3 id='heading-product' class='text-shadow'><?php echo $found_product['Title']; ?></h3>
                    <!--Following description sourced from https://www.nescafeusa.com/coffee101/coffee-drink-recipes-peppermint-latte and used for educational purposes only -->
                    <p id='product-para' class='firstLetterBig'>
                        <?php echo $found_product['Description']; ?>
                    </p>
                    <p>Available sizes</p>
                    <img src='./media/small.png' alt='size-image' class='icon-img'>
                    <img src='./media/medium.png' alt='size-image' class='icon-img'>
                    <img src='./media/large.png' alt='size-image' class='icon-img'>
                    <form action='cart.php' method="post" onsubmit='return validateForm()' class='product-layer-2'>
                        <input type='hidden' name='id' id='current_id' value='<?php echo $found_product['ID']; ?>'>
                        <p id='size-para'>Size</p>
                        <div id='prod-option'>
                            <select name='oid' id='size' oninput="displayPrice()">
                                <option value='None' selected>Please select an option</option>
                                <?php
                                    $to_find = $found_product['ID'];
                                    $filtered_products = array_filter($products, function($elem) use($to_find){
                                        return $to_find == $elem['ID'];
                                    });
                                    foreach($filtered_products as $prod) {
                                        echo "<option value='{$prod['OID']}'>{$prod['Option']}</option>";
                                    };
                                ?>
                            </select>
                        </div>
                        <!-- Code adapted from https://codepen.io/mtbroomell/pen/yNwwdv and used for educational purposes only-->
                        <div id='add-qty'>
                            <div class="home-button" id="decrease" value="Decrease Value" onclick=" decreaseValue() ; displayPrice()">-</div>
                            <input type="number" name='qty' id="number" value="0" oninput="displayPrice()" />
                            <div class="home-button" id="increase" value="Increase Value" onclick=" increaseValue() ; displayPrice()">+</div>
                        </div>
                        <p id='priceh'>Amount</p>
                        <p id='demo-price'>$0.00</p>
                        <div id='reset'>
                            <input type='reset' onclick='clearPrice()' name='clear all' value='Clear' id='reset-button' class='home-button'></div>
                        <div id='buy'>
                            <input type='submit' value="Buy" name='add' id='add' class='home-button'>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
<?php
    bottom_module();
?>

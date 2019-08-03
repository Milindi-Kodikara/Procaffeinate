<?php
    session_start();
    include_once 'tools.php';
    top_module("Menu|Procaffeination");
    if (isset($_POST['cancel'])) {
        unset($_SESSION['cart']);
    }

?>
<main id='products-format'>
    <section id="hero">
        <div id="products-hero-image">
            <h3 id="product-heading" class="hero-heading">Experience coffee like never before!</h3>
        </div>
    </section>
    <!--Description adapted from https://www.starbucks.com.au/Coffee-Espresso.php and used for educational purposes only -->
    <h3 class='prod-prod-topic' id='seasonal'>Seasonal</h3>
    <p class='prod-des'>Without the very best coffee, beverages are forgettable. The best machine, the best milk, even the best barista aren't enough to create the ultimate Red Velvet Latte or Freshy Breeze like ours this Winter!</p>
    <?php
        display_products();
    ?>
</main>
<?php
    bottom_module();
    debug_module();
?>

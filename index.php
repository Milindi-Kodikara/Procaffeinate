<?php
    session_start();
    include_once 'tools.php';
    top_module("Home|Procaffeination");
?>
<main id='home-page'>
    <section id="hero">
        <div id="hero-image">
            <h3 class="hero-heading text-shadow">Procrastinate? Why not Procaffeinate!</h3>
            <p hidden class="hero-para text-shadow">I can't espresso how much you bean to me!</p>
        </div>
    </section>
    <!-- Paragraph with the focus -->
    <article id='about-us'>
        <h3 class='text-shadow'> Our Goal </h3>
        <p class="firstLetterBig">At Procaffeination, we aim to fulfil YOUR caffeine needs with our exceptional taste in coffee. Every breath you take, every move you make, every bond you break, every step you take we'll be caffeinating you because we guarantee that every sip you take is going to be worth every cent you spend.</p>
    </article>
    <div class='goal-images'>
        <img src='./media/goal1.png' alt='Image of coffee with marshmellows and chocolate sauce' class="goal-image">
        <img src='./media/goal2.png' alt='Image of a coffee cup to be filled using a coffee machine' class="goal-image">
    </div>
    <h3 id='prod-topic'>Explore our seasonal blends!</h3>
    <?php
        display_products();
    ?>
    <div class='home-button-cl'>
        <a href='products.php' class='home-button'>View all products</a>
    </div>
</main>
<?php
    bottom_module();
?>
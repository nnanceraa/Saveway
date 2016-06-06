<!DOCTYPE html>
<!--SHOPPING CART PAGE-->
<?php
session_start();
include 'connect.php';

if (empty($_SESSION['email'])) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('You need to be logged in to view this page.')
    window.location.href='http://nancyra.com/Saveway/DefaultHome.php';
    </SCRIPT>");
}
?>
<html lang="en">

    <?php
    include 'head.php';
    ?>

    <body>
        <header>
            <img src="images/logo.png" alt="D&amp;N logo" height="70">
            <div id="hgroup">

                <h1>SAVEWAY Online Grocery Store</h1>
                <h2>Brought to you by <span class="shadow">D&amp;N </span>Ltd.</h2>
                <div id='usercheck'> 
                    <?php
                    include 'usercheck.php';
                    ?>
                </div>
            </div>
        </header>
        <nav>
            <ul>
                <li><a href="DefaultHome.php">Home</a></li>
                <li><a href="Browse.php">Browse</a></li>
                <li><a href="Cart.php">
                        <?php
                        // count products in cart
                        if (isset($_SESSION['cart_items'])) {
                            $cart_count = count($_SESSION['cart_items']);
                        }
                        ?>
                        My Cart
                        <span class="badge" id="comparison-count">
                            <?php
                            if (!isset($_SESSION['cart_items'])) {
                                echo "0";
                            } else {
                                echo $cart_count;
                            }
                            ?>
                        </span></a>
                </li>
                <li><a href="Profile.php">Profile</a></li>
            </ul>
        </nav>
        <section>
            <h1> My Cart </h1>
            <div id="cartBox">
                <?php
                include 'CartProducts/shoppingcart.php';
                ?>
            </div>
        </section>
        <script src="scripts/jquery/jquery.js"></script>
        <script src="scripts/jquery-ui.js"></script>
        <script>
            $(".remove").button();
        </script>
    </body>
    <?php
    include 'footer.php';
    ?>
</html>

<!DOCTYPE html>
<!--HOMEPAGE-->
<?php
session_start();
?>

<html lang="en">
    <?php
    include 'head.php';
    ?>
    <body>
        <header>
            <img src="images/logo.png" alt="D&amp;N logo" height="70">
            <hgroup>
                <h1>SAVEWAY Online Grocery Store</h1>
                <h2>Brought to you by <span class="shadow">D&amp;N </span>Ltd.</h2>

            </hgroup>
            <div id='usercheck'> 
                <?php
                include 'usercheck.php';
                ?>
            </div>
        </header>
        <nav>
            <ul id="main-nav" class="clearfix">
                <li><a class="current" href="DefaultHome.php">Home</a></li>
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
            <h1 id="welcome">Welcome to SAVEWAY!</h1>
            <div id="logBox" >
                <br>
                <h2>Already have an account?</h2>
                <form action="http://nancyra.com/Saveway/Login.php">
                    <input type="submit" value="Login" class="loginregister">
                    <br>
                </form>
                <h2>New Customer?</h2>
                <form action="http://nancyra.com/Saveway/Register.php">
                    <input type="submit" value="Register" class="loginregister">
                </form>
            </div>

            <!--PHP if-statement to only display login/registration if no session ID is stored-->
            <?php if (isset($_SESSION['email']) && !empty($_SESSION['email'])) { ?>
                <script>
                    document.getElementById("logBox").style.display = "none";
                </script>
                <?php
            } else {
                ?>
                <script>
                    document.getElementById("logBox").style.display = "show";
                </script>
                <?php
            }
            ?>


            <div class="jcarousel-wrapper" >
                <div class="jcarousel" >
                    <ul style="left: 0px; top: 0px;">
                        <li style="width: 200px;"><img src="images/carousel1.jpg" alt="Grand Opening"></li>
                        <li style="width: 200px;"><img src="images/carousel2.jpg" alt="Okanagon"></li>
                        <li style="width: 200px;"><img src="images/carousel3.jpg" alt="Discount Fridays"></li>
                    </ul>
                </div>
                <a href="#" class="jcarousel-control-prev">&lsaquo;</a>
                <a href="#" class="jcarousel-control-next">&rsaquo;</a>
                <p class="jcarousel-pagination">
                    <a href="#1">1</a>
                    <a href="#2">2</a>
                    <a href="#3">3</a>
                </p>
            </div>
        </section>
        <!-- jquery ui -->
        <script src="scripts/jquery/jquery.js"></script>
        <script src="scripts/jquery-ui.js"></script>
        <script>
                $(".loginregister").button();
        </script>
        <!-- jquery carousel -->
        <script src="scripts/jquery.jcarousel.min.js"></script>  
        <script src="scripts/jcarousel.responsive.js"></script>  
        <script src="scripts/jquery/jcarousel.js"></script>  
    </body>
    <?php
    include 'footer.php';
    ?>
</html>

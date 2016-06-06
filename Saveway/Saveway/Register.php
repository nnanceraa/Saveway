<!DOCTYPE html>
<?php
session_start();
$form_token = md5(uniqid('auth', true));
$_SESSION['form_token'] = $form_token;
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

        </header>
        <nav>
            <ul id="main-nav" class="clearfix">
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
            <h1> Welcome to SAVEWAY's Grocery Store! </h1>
            <p id="ugh">Note: Passwords must be at least 4 characters long and must be alphanumeric. </p>
            <div id="register">
                <form action="http://nancyra.com/RegistrationResults.php" method="POST">

                    <h2> Register </h2>
                    <label>Name:</label><br>
                    <input type="text" id="NAME" name="NAME">
                    <br>
                    <label>Email:</label><br>
                    <input type="email" id="EMAIL" name="EMAIL">
                    <br>
                    <label>Password:</label><br>
                    <input type="password" id="PASSWORD" name="PASSWORD">
                    <br>
                    <label>Confirm Password:</label><br>
                    <input type="password" id="CONFIRM_PASSWORD" name="PASSWORD">
                    <br>
                    <input type="hidden" name="form_token" value="<?php echo $form_token; ?>" />
                    <br>
                    <input type="submit" value="Register" class="register">
                </form>
            </div>
        </section>
        <script src="scripts/jquery/jquery.js"></script>
        <script src="scripts/jquery-ui.js"></script>
        <script>

            $(".register").button();
            $(".register").css({"width": "199px"});

//Ensure BOTH passwords are the same before proceeding

            var password = document.getElementById("PASSWORD")
                    , confirm_password = document.getElementById("CONFIRM_PASSWORD");

            function validatePassword() {
                if (password.value != confirm_password.value) {
                    confirm_password.setCustomValidity("Passwords Does Not Match");
                } else {
                    confirm_password.setCustomValidity('');
                }
            }

            password.onchange = validatePassword;
            confirm_password.onkeyup = validatePassword;


        </script>
    </body>
    <?php
    include 'footer.php';
    ?>
</html>

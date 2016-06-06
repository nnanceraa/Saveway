<?php
session_start();
include 'connect.php';

if (empty($_SESSION['email'])) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('You need to be logged in to view this page.')
    window.location.href='http://localhost/Saveway/DefaultHome.php';
    </SCRIPT>");
}
?>
<!DOCTYPE html>
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
            </div>
            <div id='usercheck'> 
                <?php
                include 'usercheck.php';
                ?>
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
                <li><a class="current" href="Profile.php">Profile</a></li>
            </ul>
        </nav>
        <section>
            <form>
                <div>
                    <h1> Edit Profile </h1>
                    <?php
                    if (isset($_SESSION['email'])) {
                        $email = $_SESSION['email'];
                        $stmt = $dbh->prepare('SELECT * FROM customer WHERE email=:email LIMIT 1');
                        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
                        $stmt->execute();
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    }
                    ?>
                    Email:<br><br>
                    <label class="profile">
                        <?php
                        echo $result['EMAIL'];
                        ?>
                    </label>
                    <br><br>
                    Name:<br><br>
                    <label class="profile">
<?php echo $result['NAME'] ?>
                    </label>
                    <br><br>
                    Old Password:<br>
                    <input type="password" name="oldpassword">
                    <br>
                    New Password:<br>
                    <input type="password" name="newpassword">
                    <br>
                    Confirm New Password:<br>
                    <input type="password" name="confirmnewpassword">
                    <br>
                    <br>
                    <input id="ProfileSave1" type="submit" value="Update" onClick="return update1()">
                    <br>
                    <br>
                </div>
            </form>
        </section>
        <script src="scripts/jquery/jquery.js"></script>
        <script src="scripts/jquery-ui.js"></script>
        <script>

                        $("#ProfileSave1").button();

                        function update1()
                        {
                            alert("This function is under construction. Your password has NOT been changed.");
                        }

                        function guestalert()
                        {
                            alert("You need to be signed in to view this page.");
                        }

        </script>
    </body>
    <?php
    include 'footer.php';
    ?>
</html>

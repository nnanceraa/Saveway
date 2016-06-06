<?php
session_start();
include 'connect.php';
include 'head.php';


if (isset($_POST['submit'])) {
    $errMsg = '';
    //username and password sent from Form
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email == '')
        $errMsg .= 'You must enter your Username<br>';

    if ($password == '')
        $errMsg .= 'You must enter your Password<br>';


    if ($errMsg == '') {

        $records = $dbh->prepare('SELECT CUSTOMER_ID,NAME,EMAIL,PASSWORD FROM  CUSTOMER WHERE EMAIL = :email');
        $records->bindParam(':email', $email);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);

        if (count($results) > 0 && password_verify($password, '$2y$10$hvXzKbgSPp3yD9UHVR2CqOcc0FhbBFjgpnAAmODGPp7Sko5viI6KS')) {
            $_SESSION['email'] = $results['EMAIL'];
            $_SESSION['name'] = $results['NAME'];
            $_SESSION['logged'] = TRUE;
            $_SESSION['cust_id'] = $results['CUSTOMER_ID'];
            header("location: http://nancyra.com/Saveway/Admin.php");
            exit;
        } else if (count($results) > 0 && password_verify($password, $results['PASSWORD'])) {
            $_SESSION['email'] = $results['EMAIL'];
            $_SESSION['name'] = $results['NAME'];
            $_SESSION['logged'] = TRUE;
            $_SESSION['cust_id'] = $results['CUSTOMER_ID'];
            header("location: http://nancyra.com/Saveway/Browse.php");
            exit;
        } else {
            $errMsg .= 'Username and Password are not found<br>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
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
                <li><a href="DefaultHome.php">Home</a></li>
                <li><a href="Browse.php">Browse</a></li>
                <li><a href="Cart.php">My Cart</a></li>
                <li><a href="Profile.php">Profile</a></li>
            </ul>
        </nav>

        <section>
            <h1> Welcome to SAVEWAY's Grocery Store! </h1>
            <div id="logBox">
                <form action='' method="post">
                    <h2> Login </h2>
                    Email:<br>
                    <input type="email" name="email">
                    <br>
                    Password:<br>
                    <input type="password" name="password">
                    <br><br>
                    <input type="submit" name="submit" value="Login" class="register">
                </form>

            </div>
            <?php
            if (isset($errMsg)) {
                echo '<div style="color:#FF0000;text-align:left;font-size:12px;">' . $errMsg . '</div>';
            }
            ?>
            <br>
        </section>
        <script src="scripts/jquery/jquery.js"></script>
        <script src="scripts/jquery-ui.js"></script>
        <script>

            $(".register").button();
            $(".register").css({"width": "199px"});


        </script>
    </body>
    <?php
    include 'footer.php';
    ?>
</html>
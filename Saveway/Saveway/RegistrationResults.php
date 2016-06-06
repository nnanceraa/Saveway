<!DOCTYPE html>
<html lang="en">

    <?php
    include 'head.php';
    session_start();

    /*     * *check that the username, email, password, and form token have been sent ** */
    if (!isset($_POST['NAME'], $_POST['EMAIL'], $_POST['PASSWORD'], $_POST['form_token'])) {
        $message = 'Please enter a valid username, email, and password.';
    }

    /*     * * check the form token is valid ** */ elseif ($_POST['form_token'] != $_SESSION['form_token']) {
        $message = 'Invalid form submission.';
    }

    /*     * * check the email is the correct length ** */ elseif (strlen($_POST['EMAIL']) > 80 || strlen($_POST['EMAIL']) < 4) {
        $message = 'Incorrect EMAIL length.';
    }
    /*     * * check the password is the correct length ** */ elseif (strlen($_POST['PASSWORD']) > 50 || strlen($_POST['PASSWORD']) < 4) {
        $message = 'Incorrect Length for PASSWORD';
    }

    /*     * * check the password has only alpha numeric characters ** */ elseif (ctype_alnum($_POST['PASSWORD']) != true) {
        /*         * * if there is no match ** */
        $message = "PASSWORD must be alpha numeric";
    } else {
        /*         * * if we are here the data is valid and we can insert it into database ** */
        $NAME = filter_var($_POST['NAME'], FILTER_SANITIZE_STRING);
        $EMAIL = filter_var($_POST['EMAIL'], FILTER_SANITIZE_STRING);
        $PASSWORD = filter_var($_POST['PASSWORD'], FILTER_SANITIZE_STRING);

        /*         * * now we can encrypt the password ** */
        $PASSWORD = password_hash($PASSWORD, PASSWORD_BCRYPT);

        /*         * * connect to database ** */

//DB configuration Constants
$servername = "localhost";
$username = "saveway_admin";
$password = "saveway123";
$dbname = "Saveway";


        try {
            $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            /*             * * $message = a message saying we have connected ** */

            /*             * * set the error mode to excptions ** */
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            /*             * * prepare the insert ** */
            $stmt = $dbh->prepare("INSERT INTO customer (NAME, EMAIL, PASSWORD ) VALUES (:NAME, :EMAIL, :PASSWORD )");

            /*             * * bind the parameters ** */
            $stmt->bindParam(':NAME', $NAME, PDO::PARAM_STR);
            $stmt->bindParam(':EMAIL', $EMAIL, PDO::PARAM_STR, 40);
            $stmt->bindParam(':PASSWORD', $PASSWORD, PDO::PARAM_STR, 50);

            /*             * * execute the prepared statement ** */
            $stmt->execute();

            /*             * * unset the form token session variable ** */
            unset($_SESSION['form_token']);

            /*             * * if all is done, say thanks ** */
            $message = 'New user added';
        } catch (Exception $e) {
            /*             * * check if the username already exists 
             * this has not been implemented correctly as it is taking the same
             * email more than once, if time allows, come back and fix this** */
            if ($e->getCode() == 23000) {
                $message = 'Username already exists';
            } else {
                /*                 * * if we are here, something has gone wrong with the database ** */
                $message = 'We are unable to process your request. Please try again later"';
            }
        }
    }
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
                <li><a href="Cart.php">My Cart</a></li>
                <li><a href="Profile.php">Profile</a></li> 
            </ul>
        </nav>

        <section>
            <h1> Your Registration Results! </h1>
            <p><?php
                if ($message == "New user added") {
                    echo $message;
                    echo '<br><br><a id="button" href="http://localhost/Saveway/Browse.php">
   Start Shopping
</a><br>';
                } else {
                    echo $message;
                    echo '<br/><br/><a id="button" href="http://localhost/Saveway/Register.php?">
   Try Again
</a><br/>';
                }
                ?></p>
        </section>

        <script src="scripts/jquery/jquery.js"></script>
        <script src="scripts/jquery-ui.js"></script>
        <script>
            $("#button").button();
        </script>
    </body>
    <?php
    include 'footer.php';
    ?>
</html>


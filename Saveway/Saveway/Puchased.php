<!DOCTYPE html>
<html lang="en">
    <?php
    session_start();
    include 'head.php';
    ?>
    <body>
        <header>
            <img src="images/logo.png" alt="D&amp;Nlogo" height="70">
            <hgroup>
                <h1>SAVEWAY Online Grocery Store</h1>
                <h2>Brought to you by <span class="shadow">D&amp;N</span>Ltd.</h2>
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
                <li><a href="Cart.php">My Cart</a></li>
                <li><a href="Profile.php">Profile</a></li>
            </ul>
        </nav>
        <section>
            <h1>Your products were purchased!</h1>
            <a href="Cart.php">Back to Cart</a>
        </section>

    </body>
    <?php
    include 'footer.php';
    ?>
</html>
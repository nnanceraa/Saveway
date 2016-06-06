<?php

if (!empty($_SESSION['email']) && $_SESSION['email'] == 'admin@saveway.com') {
    echo '<div id="adminBtn"><a class="customBtn" style="text-align:center" href = "Admin.php">Admin</a></div>';
}

if (!empty($_SESSION['logged']) && $_SESSION['logged'] == TRUE) {
    echo '<div id="logOut"><a class="customBtn" style="text-align:center" href = "Logout.php">Logout</a></div>';
}
?>


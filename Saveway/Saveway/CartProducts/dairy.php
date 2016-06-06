<?php

include 'connect.php';

// to prevent undefined index notice
$action = isset($_GET['action']) ? $_GET['action'] : "";
$id = isset($_GET['id']) ? $_GET['id'] : "1";
$name = isset($_GET['name']) ? $_GET['name'] : "";

$query = "SELECT ITEM_ID, ITEM_NAME, PRICE, DESCRIPTION, PHOTO_FILENAME FROM ITEM WHERE CATEGORY_ID ='3' ORDER BY ITEM_NAME";
$stmt = $dbh->prepare($query);
$stmt->execute();

$num = $stmt->rowCount();

if ($num > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        //creating each div

        echo "<h3>{$ITEM_NAME}</h3>";
        echo "<div class='accord'>";
        echo "<img src='images/{$PHOTO_FILENAME}' alt='{$PHOTO_FILENAME}'/>";
        echo "<h4>Description</h4>";
        echo "{$DESCRIPTION}";
        echo "<h4>Price</h4>";
        echo "&#36;{$PRICE}<br><br>";

        echo "<a href='CartProducts/add_to_cart.php?id={$ITEM_ID}&name="
        . "{$ITEM_NAME}' class='button'>";
        echo "Add to cart";
        echo "</a>";
        echo "</div>";
    }
}

// tell the user if there's no products in the database
else {
    echo "No products found.";
}
?>

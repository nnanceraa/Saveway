<?php

$action = isset($_GET['action']) ? $_GET['action'] : "";
$name = isset($_GET['name']) ? $_GET['name'] : "";

if ($action == 'removed') {
    echo "<div class='alert alert-info'>";
    echo "<strong>{$name}</strong> was removed from your cart!";
    echo "</div>";
}

if (isset($_SESSION['cart_items']) && isset($_SESSION['cust_id'])) {

    $customer = $_SESSION['cust_id'];

    // get the product ids
    $ids = "";
    foreach ($_SESSION['cart_items'] as $id => $value) {
        $ids = $ids . $id . ",";
    }

    // remove the last comma
    $ids = rtrim($ids, ',');

    //start table
    echo "<table id='cartTable' class='table table-hover table-responsive table-bordered'>";

    // our table heading
    echo "<tr >";
    echo "<th style='border:1px solid #599601' class='textAlignLeft'></th>";
    echo "<th style='border:1px solid #599601' class='textAlignLeft'>Product Name</th>";
    echo "<th style='border:1px solid #599601'>Price (CAN)</th>";
    echo "<th style='border:1px solid #599601'>Action</th>";
    echo "</tr>";

    $query = "SELECT PHOTO_FILENAME, ITEM_ID, ITEM_NAME, PRICE FROM ITEM WHERE ITEM_ID IN ({$ids}) ORDER BY ITEM_NAME";

    $stmt = $dbh->prepare($query);
    $stmt->execute();

    $total_price = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        echo "<tr>";
        echo "<td><img src='images/{$PHOTO_FILENAME}' alt='{$PHOTO_FILENAME}'/></td>";
        echo "<td>{$ITEM_NAME}</td>";
        echo "<td>&#36;{$PRICE}</td>";
        echo "<td>";
        echo "<a href='CartProducts/remove_from_cart.php?id={$ITEM_ID}&name={$ITEM_NAME}' class='remove'>";
        echo "Remove";
        echo "</a>";
        echo "</td>";
        echo "</tr>";

        $total_price+=$PRICE;
    }


    echo "<tr>";
    echo "<td></td>";
    echo "<td><b>Total</b></td>";
    echo "<td>&#36;{$total_price}</td>";
    echo "<td>";
    echo "<a href='Checkout.php?price={$total_price}&customer={$customer}&ids={$ids}' class='remove'>";
    echo "Checkout";
    echo "</a>";
    echo "</td>";
    echo "</tr>";

    echo "</table>";
} else {
    echo "<div class='alert alert-danger'>";
    echo "<strong>No products found</strong> in your cart!";
    echo "</div>";
}
?>
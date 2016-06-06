<?php

$customer = isset($_GET['customer']) ? $_GET['customer'] : "";
$price = isset($_GET['price']) ? $_GET['price'] : "";
$ids = isset($_GET['ids']) ? $_GET['ids'] : "";

include 'connect.php';

try {
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $query = "INSERT INTO INVOICE SET VALUE = ?, INVOICE_STATUS_ID = 1, DATE_TIME = NOW(), CUSTOMER_ID = ?";

    $stmt = $dbh->prepare($query);

    $stmt->bindParam(1, $price);

    $stmt->bindParam(2, $customer);


    if ($stmt->execute()) {
        $invoice_new_id = $dbh->lastInsertId();
        header('Location: http://nancyra.com/Saveway/Puchased.php?total_price=' . $price);
    }
    else {
        echo "Unable to purchase";
    }

    //to handle error
} catch (PDOException $exception) {
    echo "Error: " . $exception->getMessage();
}
?>
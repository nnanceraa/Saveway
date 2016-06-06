<?php

include 'connect.php';

try {

    $query = "update
                ITEM
            set
                CATEGORY_ID = :CATEGORY_ID,
                ITEM_NAME = :ITEM_NAME,
                DESCRIPTION = :DESCRIPTION,
                PRICE = :PRICE,
                COST = :COST,
               QUANTITY = :QUANTITY,
               PHOTO_FILENAME = :PHOTO_FILENAME

            where
                ITEM_ID = :ITEM_ID";

    //prepare query for excecution
    $stmt = $dbh->prepare($query);

    //bind the parameters

    $stmt->bindParam(':CATEGORY_ID', $_POST['CATEGORY_ID']);
    $stmt->bindParam(':ITEM_NAME', $_POST['ITEM_NAME']);
    $stmt->bindParam(':DESCRIPTION', $_POST['DESCRIPTION']);
    $stmt->bindParam(':PRICE', $_POST['PRICE']);
    $stmt->bindParam(':COST', $_POST['COST']);
    $stmt->bindParam(':QUANTITY', $_POST['QUANTITY']);
    $stmt->bindParam(':PHOTO_FILENAME', $_POST['PHOTO_FILENAME']);
    $stmt->bindParam(':ITEM_ID', $_POST['ITEM_ID']);

    // Execute the query

    if ($stmt->execute()) {
        echo "Item was updated.";
    } else {
        echo "Unable to update item.";
    }

    ////to handle error
} catch (PDOException $exception) {
    echo "Error: " . $exception->getMessage();
}
?>
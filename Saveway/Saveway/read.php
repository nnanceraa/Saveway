<?php

//include database connection
include 'connect.php';

//select all data
$query = "SELECT ITEM_ID, CATEGORY_ID, ITEM_NAME, DESCRIPTION, PRICE, COST, QUANTITY, PHOTO_FILENAME FROM ITEM ORDER BY ITEM_ID desc";
$stmt = $dbh->prepare($query);
$stmt->execute();

//this is how to get number of rows returned
$num = $stmt->rowCount();

if ($num > 0) { //check if more than 0 record found
    echo "<br><table id='productTable' border='1'>"; //start table
    //retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //extract row
        //this will make $row['firstname'] to
        //just $firstname only
        extract($row);

        //creating new table row per record
        echo "<tr>";
        echo "<td style='border:1px green solid'>";
        echo "<b>Category ID:</b> {$CATEGORY_ID}<br>";
        echo "<b>Item Name:</b> {$ITEM_NAME}<br>";
        echo "<b>Description:</b> {$DESCRIPTION}<br>";
        echo "<b>Price:</b> {$PRICE}<br>";
        echo "<b>Cost:</b> {$COST}<br>";
        echo "<b>Quantity:</b> {$QUANTITY}<br>";
        echo "<b>Filename:</b> {$PHOTO_FILENAME}<br>";
        echo "<b>Item ID:</b> <div class='ITEM_ID'>{$ITEM_ID}</div><br>";

        //we will use this links on next part of this post
        echo "<div class='editBtn customBtn'>Edit</div>";

        //we will use this links on next part of this post
        echo "<div class='deleteBtn customBtn'>Delete</div><br>";
        echo "</td></tr>";
    }

    echo "</table>"; //end table
}

// tell the user if no records found
else {
    echo "<div class='noneFound'>No records found.</div>";
}
?>
<?php
try {
    include 'connect.php';

    // select record to be edited
    $query = "select
                ITEM_ID, CATEGORY_ID, ITEM_NAME, DESCRIPTION, PRICE, COST, QUANTITY, PHOTO_FILENAME
            from
                ITEM
            where
                ITEM_ID = ?
            limit 0,1";

    $stmt = $dbh->prepare($query);

    //this is the first question mark
    $stmt->bindParam(1, $_REQUEST['ITEM_ID']);

    //execute our query
    if ($stmt->execute()) {

        //store retrieved row to a variable
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //values to fill up our form
        $ITEM_ID = $row['ITEM_ID'];
        $CATEGORY_ID = $row['CATEGORY_ID'];
        $ITEM_NAME = $row['ITEM_NAME'];
        $DESCRIPTION = $row['DESCRIPTION'];
        $PRICE = $row['PRICE'];
        $COST = $row['COST'];
        $QUANTITY = $row['QUANTITY'];
        $PHOTO_FILENAME = $row['PHOTO_FILENAME'];
    } else {
        echo "Unable to read record.";
    }
}

//to handle error
catch (PDOException $exception) {
    echo "Error: " . $exception->getMessage();
}
?>

<form id='updateItemForm' action='#' method='post' >
    <table>
        <tr>
            <td>Item Category</td>
            <td><input type='text' name='CATEGORY_ID' value='<?php echo $CATEGORY_ID; ?>' required /></td>
        </tr>
        <tr>
            <td>Item Name</td>
            <td><input type='text' name='ITEM_NAME' id='ITEM_NAME' value='<?php echo $ITEM_NAME; ?>' required /></td>
        </tr>
        <tr>
            <td>Item Description</td>
            <td><input type='text' name='DESCRIPTION' value='<?php echo $DESCRIPTION; ?>' required /></td>
        </tr>
        <tr>
            <td>Item Price</td>
            <td><input type='text' name='PRICE' value='<?php echo $PRICE; ?>' required /></td>
        </tr>
        <tr>
            <td>Item Cost</td>
            <td><input type='text' name='COST' value='<?php echo $COST; ?>' required /></td>
        </tr>
        <tr>
            <td>Item Quantity</td>
            <td><input type='text' name='QUANTITY' value='<?php echo $QUANTITY; ?>' required /></td>
        </tr>
        <tr>
            <td>Image Filename</td>
            <td><input type='text' id="PHOTO_FILENAME" name='PHOTO_FILENAME' value='<?php echo $PHOTO_FILENAME; ?>' required /></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <!-- so that we could identify what record is to be updated -->
                <input type='hidden' name='ITEM_ID' value='<?php echo $ITEM_ID; ?>' />
                <input type='submit' value='Update' class='customBtn' />

            </td>
        </tr>
    </table>
</form>

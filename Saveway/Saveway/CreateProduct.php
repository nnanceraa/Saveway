<!--CREATE NEW PRODUCT PAGE / PHP POST -->
<?php

include 'connect.php';
// empty JSON
$methodType = $_SERVER['REQUEST_METHOD'];
$data = array("msg" => "$methodType");

if ($methodType === 'POST') {

    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        // yes, is AJAX call
        // answer POST call and get the data that was sent

        if (isset($_POST["ITEM_NAME"]) && !empty($_POST["ITEM_NAME"]) && isset($_POST["CATEGORY_ID"]) && !empty($_POST["CATEGORY_ID"]) && isset($_POST["DESCRIPTION"]) && !empty($_POST["DESCRIPTION"]) && isset($_POST["COST"]) && !empty($_POST["COST"]) && isset($_POST["PHOTO_FILENAME"]) && !empty($_POST["PHOTO_FILENAME"]) && isset($_POST["QUANTITY"]) && !empty($_POST["QUANTITY"]) && isset($_POST["PRICE"]) && !empty($_POST["PRICE"])) {

            try {
                $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

                $query = "INSERT INTO ITEM SET CATEGORY_ID = ?, ITEM_NAME = ?, DESCRIPTION = ?,"
                        . " PRICE  = ?, COST = ?, QUANTITY = ?, PHOTO_FILENAME = ?";

                $stmt = $dbh->prepare($query);
                //this is the first question mark
                $stmt->bindParam(1, $_POST['CATEGORY_ID']);

                $stmt->bindParam(2, $_POST['ITEM_NAME']);

                //this is the second question mark
                $stmt->bindParam(3, $_POST['DESCRIPTION']);

                //this is the third question mark
                $stmt->bindParam(4, $_POST['PRICE']);

                //this is the fourth question mark
                $stmt->bindParam(5, $_POST['COST']);

                //this is the fifth question mark
                $stmt->bindParam(6, $_POST['QUANTITY']);

                $file = basename($_POST['PHOTO_FILENAME']);
                //this is the sixth question mark
                $stmt->bindParam(7, $file);


                $stmt->execute();



                $data = ["msg" => "Success"];
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    $data = ["msg" => "Invalid Category ID."];
                } else {
                    $data = ["msg" => "Server Error - Try again later."];
                }
            }
        } else {
            $data = array("msg" => "Either firstName, lastName, or email were not filled out correctly.");
        }
    } else {
        // not AJAX
        $data = array("msg" => "Has to be an AJAX call.");
    }
} else {
    // simple error message, only taking POST requests
    $data = array("msg" => "Error: only POST allowed.");
}

echo json_encode($data, JSON_FORCE_OBJECT);
return;


?>
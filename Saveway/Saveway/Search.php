<?php

include 'connect.php';

$methodType = $_SERVER['REQUEST_METHOD'];


$result = array("msg" => "$methodType");

if ($methodType == 'GET') {

    if (isset($_GET['name']) && !empty($_GET['name'])) {
        $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        $data = "%" . $_GET['name'] . "%";

        $query = "SELECT ITEM_ID, ITEM_NAME, PRICE, DESCRIPTION, PHOTO_FILENAME FROM ITEM WHERE ITEM_NAME like ?";
        $stmt = $dbh->prepare($query);
        $stmt->execute(array($data));
        $rows = $stmt->fetchAll();
        if ($stmt->rowCount() > 0) {
            $result = ["msg" => "success", "response" => $rows];
        } else {
            $result = ["msg" => "Search returned nothing"];
        }
    } else {
        $result = ["msg" => "There must be a product name"];
    }
} else {
    $result = ["msg" => "Error: only GET allowed"];
}


echo json_encode($result, JSON_FORCE_OBJECT);
?>
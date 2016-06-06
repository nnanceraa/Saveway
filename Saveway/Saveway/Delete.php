<!--DELETE PHP-->
<?php
//include database connection
include 'connect.php';
  
try {
  
    $query = "DELETE FROM ITEM WHERE ITEM_ID = ?";
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(1, $_POST['ITEM_ID']);
  
    if($stmt->execute()){
        echo "Item was deleted.";
    }else{
        echo "Unable to delete item.";
    }
  
}
  
//to handle error
catch(PDOException $exception){
    echo "Error: " . $exception->getMessage();
}
?>
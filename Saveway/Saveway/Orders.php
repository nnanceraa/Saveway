<?php

$getOrders = $dbh->prepare("SELECT * FROM INVOICE");
$getOrders->execute();

$orders = $getOrders->fetchAll();

echo "<table>";
echo "<tr>"
 . "<th>Order ID</th>"
 . "<th>Customer ID</th>"
 . "<th>Status</th>"
 . "<th>Value</th>"
 . "<th>Date</th>"
 . "</tr>";

foreach ($orders as $row) {
    echo "<tr>";
    echo "<td>" . $row['INVOICE_ID'] . "</td>";
    echo "<td>" . $row['CUSTOMER_ID'] . "</td>";
    echo "<td>" . $row['INVOICE_STATUS_ID'] . "</td>";
    echo "<td>" . "&#36;".$row['VALUE'] . "</td>";
    echo "<td>" . $row['DATE_TIME'] . "</td>";
    echo "</tr>";
}

echo "</table>";
?>
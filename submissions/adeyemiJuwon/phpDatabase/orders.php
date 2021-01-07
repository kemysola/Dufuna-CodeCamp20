<?php

include('connect.php');

try{
     $sql = 'SELECT order_items.unit_price, 
            order_items.total_amount, orders.order_date, orders.id ,customers.street_address, customers.city,customers.state, 
            customers.country,order_items.quantity, products.name
            FROM order_items 
            LEFT JOIN orders ON orders.id = order_items.order_id
            LEFT JOIN customers on orders.customer_id = customers.id
            LEFT JOIN products ON products.id = order_items.product_id 
            WHERE  orders.customer_id = order_items.id';
            $results = $pdo->query($sql);
            setcookie('order_items',  json_encode($results), time() + 3600);

if($results ->rowCount() > 0) {
    echo "<table>";
        echo "<tr>";
            echo "<td>S/N</td>";
            echo "<td>Product Name</td>";
            echo "<td>Unit Price</td>";
            echo "<td>Quantity</td>";
            echo "<td>Total Price</td>";
            echo "<td>Order Date</td>";
            echo "<td>Customer Location</td>";
    echo "</tr>";
     while($row = $results -> fetch()) {
        echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['unit_price'] . "</td>";
            echo "<td>" . $row['quantity'] . "</td>";
            echo "<td>" . $row['total_amount'] . "</td>";
            echo "<td>" . $row['order_date'] . "</td>";
            echo "<td>" . $row['street_address'] . ", " . $row['city'] . ", " . $row['state'] . ", "  . $row['country'] ."</td>";
        echo "</tr>";
    };
    echo "</table>";
    unset($orders);
} else {
    echo 'No records matching your query were found';
};
}catch(PDOException $e){
    die("ERROR: Could not excute $sql." .$e->getMessage());
}
if(isset($_COOKIE['order_items'])) {
    echo "customers '" . $order_items . "' is set!<br>";
  
} else {
  echo "customers '" . 'customers' . "' is not set!";
}
unset($pdo);
?>
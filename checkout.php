<?php

include ('session_cart.php');

if ( isset( $_GET['total'] ) && ( $_GET['total'] > 0 ) && (!empty($_SESSION['cart']) ) ) {

require ('connection_db.php');

$q = "INSERT INTO orders ( user_id, total, order_date ) VALUES (". $_SESSION['user_id'].",".$_GET['total'].", NOW() ) ";
$r = mysqli_query ($link, $q);

$order_id = mysqli_insert_id($link) ;

$q = "SELECT * FROM products WHERE item_id IN (";
foreach ($_SESSION['cart'] as $id => $value) { $q .= $id . ','; }
$q = substr( $q, 0, -1 ) . ') ORDER BY item_id ASC';
$r = mysqli_query ($link, $q);

while ($row = mysqli_fetch_array ($r, MYSQLI_ASSOC)) {
  $query = "INSERT INTO order_contents ( order_id, item_id, quantity, price )
  VALUES ( $order_id, 
         ".$row['item_id'].",
         ".$_SESSION['cart'][$row['item_id']]['quantity'].",
         ".$_SESSION['cart'][$row['item_id']]['price'].")" ;
  $result = mysqli_query($link,$query);
}

mysqli_close($link);

echo "
<div class=\"container\">
    <div class=\"alert alert-secondary\" role=\"alert\">
        <button type=\"button\" class=\"class\" data-dismiss=\"alert\" aria-label=\"Close\">
        <span aria-hidden=\"true\">&times;</span>
        </button><p>Thanks for your order. Your Order Number Is #".$order_id."</p>  
    </div>
</div>";

$_SESSION['cart'] = NULL;
}
else { echo "
<div class=\"container\">
    <div class=\"alert alert-secondary\" role=\"alert\">
        <button type=\"button\" class=\"class\" data-dismiss=\"alert\" aria-label=\"Close\">
        <span aria-hidden=\"true\">&times;</span>
        </button><p>There are no items in your cart.</p>  
    </div>
</div>"; }

?>
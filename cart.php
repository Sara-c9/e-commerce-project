<?php

include ('session_cart.php');

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
  foreach ( $_POST['qty'] as $item_id => $item_qty ) {
    $id = (int) $item_id;
    $qty = (int) $item_qty;

    if ( $qty == 0 ) { 
      unset ($_SESSION['cart'][$id]); 
    } elseif ( $qty > 0 ) { 
      $_SESSION['cart'][$id]['quantity'] = $qty; 
    }
  }
}

$total = 0; 
if (!empty($_SESSION['cart'])) {
    require ('connection_db.php');

    $q = "SELECT * FROM products WHERE item_id IN (";
    foreach ($_SESSION['cart'] as $id => $value) { 
      $q .= $id . ','; 
    }
    $q = substr( $q, 0, -1 ) . ') ORDER BY item_id ASC';
    $r = mysqli_query ($link, $q);

    echo "
    <form action='cart.php' method='post'>
        <div class='container my-4'>
          <div class='row justify-content-center'>
            <div class='col-md-8'>
              <div class='list-group'>";
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
      $subtotal = $_SESSION['cart'][$row['item_id']]['quantity'] * $_SESSION['cart'][$row['item_id']]['price'];
      $total += $subtotal;
    
      echo "
      <div class='list-group-item py-3'>
        <div class='row align-items-center'>
          <div class='col-md-4'>
            <h5>{$row['item_name']}</h5>
          </div>
          <div class='col-md-4 text-center'>
            <input type='text' 
              size='3' 
              name='qty[{$row['item_id']}]' 
              value='{$_SESSION['cart'][$row['item_id']]['quantity']}'>
          </div>
          <div class='col-md-4 text-start'>
            @ {$row['item_price']} = &pound;" . number_format($subtotal, 2) . "
          </div>
        </div>
      </div>";
    }
    
    echo "</div>
            <div class='mt-4 p-3 bg-light'>
              <div class='row'>
                <div class='col-md-6'>
                  <p class='fw-bold'>Total = &pound;" . number_format($total, 2) . "</p>
                </div>
                <div class='col-md-6 text-end'>
                  <p><input type='submit' name='submit' class='btn btn-success btn-block' value='Update My Cart'></p>
                  <br>
                  <a href='checkout.php?total=" . $total . "' class='btn btn-success btn-block'>Checkout Now</a>
                </div>
              </div>
            </div>
          </div>
        </div>
    </form>";    
}

else

{ echo '<p>Your cart is currently empty.</p>' ; }
?>

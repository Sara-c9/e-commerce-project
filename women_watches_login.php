<?php
include('session.php');

require('connection_db.php');

echo '<div class="row">';

$q = 'SELECT * FROM products WHERE category="women_collection"';
$r = mysqli_query ($link,$q);

if (mysqli_num_rows ($r)>0) {
    while ($row = mysqli_fetch_array ($r, MYSQLI_ASSOC)) {
echo '

<div class="col-md-4 d-flex justify-content-center">
  <div class="card m-5">
    <img src="'. $row['item_img'].'" class="card-img-top" alt="'. $row['item_name'].'">
      <div class="card-body text-center">
        <h5 class="card-title">'. $row['item_name'].'</h5>
        <p class="card-text">'. $row['item_desc'].'</p>
        </div>
        <div class ="card-footer bg-transparent border-dark text-center">
        <p class="card-text">&pound '. $row['item_price'].'</p>
        </div>
        <div class="card-footer text-muted text-center">
        <a href="added.php?id='.$row['item_id'].'" class="btn btn-success btn-block">Add to Cart</a>
    </div>
  </div>
</div>
';

}
mysqli_close($link);
}

else {echo '<p>There are currently no items in the table to display </p>';}

include('footer.php');
?>
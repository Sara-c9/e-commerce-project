<?php

include('nav.php');

if ( isset( $errors ) && !empty( $errors ) ) {
 echo '<p id="err_msg">Oops! There was a problem:<br>' ;
 foreach ( $errors as $msg ) { echo " - $msg<br>" ; }
 echo 'Please try again or <a href="register.php">Register</a></p>' ;
}
?>
<div class="container-fluid" style="background: url('http://localhost/Projects/MKTIME/Img/watch.jpg') no-repeat center center; background-size: cover; height: 100vh;">
  <div class="d-flex justify-content-center align-items-center h-100">
    <div class="card shadow-sm border-0" style="max-width: 400px; width: 100%;">
      <div class="card-body">
        <h6 class="text-center text-success mb-1 fs-2">Log in or <a href="register.php">register</a> to shop</h6>
        <form action="login_action.php" method="post">
          <div class="mb-1">
            <label for="email" class="form-label"></label>
            <input type="email" class="form-control fs-6" name="email" id="email" aria-describedby="emailHelp" placeholder="Email">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label"></label>
            <input type="password" class="form-control fs-6" name="pass" id="password" placeholder="Password">
          </div>
          <div class="text-center text-info mt-2">
            <a href="#" class="navlink ">
              <h6 class="mb-0">Forgot your password?</h6>
            </a>
          </div>
          <div class="text-center mt-4">
            <input id="login" type="submit" class="btn btn-success btn-lg w-100" value="Login">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
include('footer.php');
?>


